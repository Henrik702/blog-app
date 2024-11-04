<div class="container mt-5">
  <h2 class="text-center mb-4">Create a New Blog Post</h2>

    <?php if (isset($_SESSION['error_message'])): ?>
      <div class="alert alert-danger text-center">
          <?=htmlspecialchars($_SESSION['error_message'])?>
          <?php unset($_SESSION['error_message']); ?>
      </div>
    <?php endif; ?>

  <!-- Create Post Form -->
  <form action="<?=route('create')?>" method="POST" class="p-4 bg-light border rounded mb-4">
      <?=csrf()?>
    <div class="mb-3">
      <label for="title" class="form-label">Post Title</label>
      <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
    </div>
    <div class="mb-3">
      <label for="content" class="form-label">Content</label>
      <textarea class="form-control" id="content" name="content" rows="5" placeholder="Write your content here..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100">Create Post</button>
  </form>

  <h2 class="text-center mb-4">Search Blog Posts</h2>
  <form action="<?=route('search')?>" method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="query" class="form-control" placeholder="Search posts..." required>
      <button type="submit" class="btn btn-outline-secondary">Search</button>
    </div>
  </form>

  <h2 class="text-center mb-4">Existing Blog Posts</h2>
    <?php if (!empty($posts)): ?>
      <div class="list-group">
          <?php foreach ($posts as $post): ?>
            <div class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <a href="<?=route('view_post', $post['id'])?>" class="list-group-item-action">
                  <h5 class="mb-1"><?=htmlspecialchars($post['title'])?></h5>
                  <p class="mb-1"><?=htmlspecialchars(substr($post['content'], 0, 100)) . '...'?></p>
                  <small> on <?=date('F j, Y', strtotime($post['created_at']))?></small>
                </a>
              </div>
              <div class="pt-2 mb-2 d-flex flex-column align-items-end">
                <a href="<?=route('view_post', $post['id'])?>" class="btn btn-sm btn-info mb-2">Show</a>

                <a href="<?=route('edit_post', $post['id'])?>" class="btn btn-sm btn-primary mb-2">Edit</a>

                <form action="<?=route('delete_post', $post['id'])?>" method="POST" style="display:inline;">
                  <input type="hidden" name="_method" value="POST">
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No blog posts available.</div>
    <?php endif; ?>
</div>
