<?php
	include('../Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (!isAdmin()) {
		header('location: ../login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">LOGO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../backend/schedule.php">ตารางงาน</a>
      </li>
			<li class="nav-item">
        <a class="nav-link" href="create_user.php">Create New User</a>
      </li>
    </ul>
		<ul class="navbar-nav ml-auto">
      <?php  if (isset($_SESSION['user'])) ; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user']['user_name']; ?> <?php echo $_SESSION['user']['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../changepass.php">Change Password</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
			<a class="nav-link" href="../index.php?logout='1'">Logout</a>
    </ul>
  </div>
</nav>
			</div>
		</div>
	</div>
	<script src="../js/jquery.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
