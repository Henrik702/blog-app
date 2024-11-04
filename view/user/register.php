<div class="container mt-5">
  <h2 class="text-center mb-4">Register</h2>

    <?php
    if (isset($error_message)): ?>
      <div class="alert alert-danger text-center">
          <?= htmlspecialchars($error_message) ?>
      </div>
    <?php endif; ?>

  <form action="<?= route("register") ?>" method="POST" class="p-4 bg-light border rounded mx-auto" style="max-width: 500px;">
      <?= csrf() ?>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?= old("register","username") ?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?= old("register","email")?>">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
    </div>
    <div class="mb-3">
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
    </div>
    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>
</div>
