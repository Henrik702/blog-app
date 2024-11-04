<?php

namespace App\Blogs;


use DB\Connection;

class BlogsController
{
    protected $connection;

    protected $cacheDir = __DIR__ . '/cache/';

    public function __construct()
    {
        if(empty($_SESSION["user_id"])){
            redirect(route("login"));
        }
        $this->connection = Connection::connect();
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    /***
     * @return false|string
     */
    public function index()
    {
        $user_id = $this->connection->real_escape_string($_SESSION['user_id']);
        $query   = "SELECT * FROM posts WHERE author_id = '$user_id' ORDER BY created_at DESC";

        $cacheFile = $this->cacheDir . "all_posts_{$user_id}.cache";
        if (file_exists($cacheFile)) {
            $posts = unserialize(file_get_contents($cacheFile));
        } else {
            $result = $this->connection->query($query);
            $posts  = $result->fetch_all(MYSQLI_ASSOC);

            file_put_contents($cacheFile, serialize($posts));
        }

        return view("home", compact('posts'));
    }

    /***
     * @param $request
     *
     * @return false|string|void
     */
    public function create($request)
    {
        if (empty($request['title']) || empty($request['content'])) {
            return view("create_post",["error_massage" => "All fields are required."]);
        }

        $author_id = $_SESSION['user_id'];
        $title     = htmlspecialchars($request['title']);
        $content   = htmlspecialchars($request['content']);

        $stmt = $this->connection->prepare("INSERT INTO posts (author_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $author_id, $title, $content);

        if ($stmt->execute()) {
            // Invalidate all posts cache for the user
            unlink($this->cacheDir . "all_posts_{$author_id}.cache");
            $_SESSION['success_message'] = "Post created successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to create post.";
        }

        redirect(route("home"));
    }

    /**
     * @param $request
     *
     * @return false|string
     */
    public function show($request)
    {
        $id = (int) $request["id"];

        $post = $this->getCachedPost($id);
        if (!$post) {
            $stmt = $this->connection->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $post   = $result->fetch_assoc();

            $this->cachePost($id, $post);
        }

        return view("blog.show_blog", ["blog" => $post]);
    }

    /**
     * @param $request
     *
     * @return false|string
     */
    public function edit($request)
    {
        $id   = (int) $request["id"];
        $stmt = $this->connection->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return view("blog.edit_blog", ["blog" => $result->fetch_assoc()]);
    }

    /**
     * @param $request
     *
     * @return void
     */
    public function update($request)
    {
        $id = (int) $request["id"];

        if (empty($request['title']) || empty($request['content'])) {
            $_SESSION['error_message'] = "Title and content are required.";
            redirect(route("edit_post", ['id' => $id]));
        }

        $title   = htmlspecialchars($request['title']);
        $content = htmlspecialchars($request['content']);

        $stmt = $this->connection->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);

        // Execute the statement
        if ($stmt->execute()) {
            $postStmt = $this->connection->prepare("SELECT * FROM posts WHERE id = ?");
            $postStmt->bind_param("i", $id);
            $postStmt->execute();
            $result    = $postStmt->get_result();
            $fetchPost = $result->fetch_assoc();

            $cacheFile  = $this->cacheDir . "all_posts_" . $_SESSION["user_id"] . ".cache";
            $cachePosts = array_map(function ($item) use ($id, $title, $content) {
                if ($item["id"] == $id) {
                    $item["title"]   = $title;
                    $item["content"] = $content;
                }

                return $item;
            }, unserialize(file_get_contents($cacheFile)));
            file_put_contents($cacheFile, serialize($cachePosts));

            $this->invalidatePostCache($id);
            $_SESSION['success_message'] = "Post updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update post.";
        }

        redirect(route("home"));
    }

    /***
     * @param $request
     *
     * @return void
     */
    public function delete($request)
    {
        $id = (int) $request["id"];

        // Prepare and execute the delete statement for the post
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $cacheFile  = $this->cacheDir . "all_posts_" . $_SESSION["user_id"] . ".cache";
            $cachePosts = array_filter(unserialize(file_get_contents($cacheFile)), function ($item) use ($id) {
                return $item["id"] != $id;
            });
            file_put_contents($cacheFile, serialize($cachePosts));
            $_SESSION['success_message'] = "Post and cache deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete post: " . $stmt->error;
        }

        redirect(route("home"));
    }

    /**
     * @param $request
     *
     * @return false|string
     */
    public function search($request)
    {
        $query        = $request['query'];
        $search_query = "%" . $this->connection->real_escape_string($query) . "%";
        $user_id      = $_SESSION['user_id'];
        $stmt         = $this->connection->prepare("SELECT * FROM posts WHERE (title LIKE ? OR content LIKE ?) AND author_id = ?");
        $stmt->bind_param("ssi", $search_query, $search_query, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts  = $result->fetch_all(MYSQLI_ASSOC);

        return view('home', compact('posts'));
    }

    /**
     * @param $postId
     * @param $post
     *
     * @return void
     */
    protected function cachePost($postId, $post)
    {
        file_put_contents($this->cacheDir . "post_{$postId}.cache", serialize($post));
    }

    /**
     * @param $postId
     *
     * @return mixed|null
     */
    protected function getCachedPost($postId)
    {
        $cacheFile = $this->cacheDir . "post_{$postId}.cache";
        if (file_exists($cacheFile)) {
            return unserialize(file_get_contents($cacheFile));
        }

        return null;
    }

    /**
     * @param $postId
     *
     * @return void
     */
    protected function invalidatePostCache($postId)
    {
        $cacheFile = $this->cacheDir . "post_{$postId}.cache";
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

}
