<?php
	include('functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
  <div align="center" style="padding-top:100px; padding-bottom:150px">
   <div class="card shadow-lg bg-white rounded" style="width:600px;">
        <article class="card-body">
            <h4 class="card-title text-primary text-center mb-4 mt-1">เปลี่ยนรหัสผ่านใหม่</h4>
            <hr>

            <form method="POST" action="changepass.php">
              <?php echo display_error(); ?>
              <br>
              <div class="form-group">
                  <input type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                  <input name="oldpass" type="text" placeholder="Old Password" class="form-control">
              </div>
              <div class="form-group">
                  <input name="newpass" type="text" placeholder="New Password" class="form-control">
              </div>
              <div class="form-group">
                  <input name="confirmnewpass" type="text" placeholder="Confirm New Password" class="form-control">
              </div>
            <div class="form-group">
            <button type="submit" class="btn btn-success" name="changepass_btn">SUBMIT</button>
            <button class="btn btn-secondary"><a href="index.php" style="color:#FFFFFF; text-decoration:none;">BACK</a></button>
            </div>
            </form>
        </article>
    </div>
  </div>

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
