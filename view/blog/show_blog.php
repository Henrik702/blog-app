<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Post</h2>

    <form action="" method="POST">
        <div class="form-group">
            <label for="title">Title</label>
            <input disabled type="text" name="title" id="title" class="form-control" value='<?= $blog["title"]?>' required>
        </div>

        <div class="form-group mb-2">
            <label for="content">Content</label>
            <textarea disabled name="content" id="content" class="form-control" rows="8" required><?= $blog["content"]?></textarea>
        </div>

    </form>

</div>