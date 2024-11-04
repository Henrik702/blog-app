<?php
$isLoggedIn = isset($_SESSION['user_id']);

function checkActive($needle)
{
    if ($needle && !empty($_SERVER["REQUEST_URI"])) {
        $pathName = $_SERVER["REQUEST_URI"];

        return str_contains($pathName, $needle) ? "active" : '';
    }

    return "";
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="<?=route("")?>">My Website</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <?php if (!$isLoggedIn): ?>
            <li class="nav-item">
              <a class="nav-link <?=checkActive("login")?>" href="<?=route("login")?>">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?=checkActive("register")?>" href="<?=route("register")?>">Register</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?=checkActive("home")?>" href="<?=route("home")?>">Dashboard</a>
            </li>
            <li class="nav-item">
              <form action="<?=route("logout")?>" method="POST" style="display: inline;">
                  <?=csrf()?>
                <button type="submit" class="btn btn-danger">Logout</button>
              </form>
            </li>
          <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
