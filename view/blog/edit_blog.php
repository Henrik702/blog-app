<div class="container mt-5">
  <h2 class="text-center mb-4">Edit Post</h2>

<form action="<?= route('update_post', $blog["id"]) ?>" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value='<?= $blog["title"]?>' required>
    </div>

    <div class="form-group mb-2">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control" rows="8" required><?= $blog["content"]?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="<?= route('index') ?>" class="btn btn-secondary">Cancel</a>
</form>

</div>