<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Welcome Page</title>
  <style>
      body {
          background-color: #f8f9fa;
          font-family: Arial, sans-serif;
      }

      .hero {
          height: 93.6vh;
          display: flex;
          justify-content: center;
          align-items: center;
          text-align: center;
          background-size: cover;
          color: white;
          position: relative;
      }

      .hero::before {
          content: "";
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: rgba(0, 0, 0, 0.5);
      }

      .hero-content {
          position: relative;
          z-index: 1;
      }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="hero-content">
    <h1 class="display-4">Welcome to Our Website!</h1>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
