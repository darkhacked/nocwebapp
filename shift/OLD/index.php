<?php session_start(); ?>

<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/style.css" rel="stylesheet">
<title>WEB SHIFT</title>
</head>
<body>
  <div class="container">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if (isset($_SESSION['id'])) { ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ยินดีต้อนรับคุณ ...
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Logout</a>
        </div>
      </li>
    <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
    <?php } ?>
    </ul>
  </div>
</nav>
</div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
