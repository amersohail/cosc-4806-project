<?php
    require_once 'app/models/User.php';
    // Load the User model
    $user = new User();
?>
  
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COSC 4806 - Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/app/styles/style.css" rel="stylesheet">
  </head>
    <body>

      <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container">
              <a class="navbar-brand" href="#">COSC 4806</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav me-auto">
                      <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="/home">Home</a>
                      </li>
                  </ul>
                  <ul class="navbar-nav ms-auto">
                      <?php if ($user->isAuthenticated()): ?>
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  <?php echo htmlspecialchars($_SESSION['username']); ?>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end">
                                  <li><a class="dropdown-item" href="/logout">Logout</a></li>
                              </ul>
                          </li>
                      <?php else: ?>
                          <li class="nav-item">
                              <a class="btn btn-primary" href="/login?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" style="background-color: #E4B721; border-color: #E4B721;">
                                  Log In
                              </a>
                          </li>
                      <?php endif; ?>
                  </ul>
              </div>
          </div>
      </nav>

<div class="content">