<?php $route = route("login")?>
<div class="container mt-5">
  <h2 class="text-center mb-4">Login</h2>

  <form action="<?= $route ?>" method="POST" class="p-4 bg-light border rounded">
      <?= csrf() ?>
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
          <?php unset($error_message);?>
      <?php endif; ?>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>