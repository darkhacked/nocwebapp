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
	<title>ADD NEW MEMBER</title>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<script src="../js/jquery.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>

	<div align="center" style="padding-top:100px; padding-bottom:150px">
	 <div class="card shadow-lg bg-white rounded" style="width:600px;">
				<article class="card-body">
						<h4 class="card-title text-primary text-center mb-4 mt-1">Create New User</h4>
						<hr>

						<form method="POST" action="create_user.php">
							<?php echo display_error(); ?>
							<div class="form-group" align="left">
									<input class="form-control form-control-sm" type="hidden" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
									<label class="col-form-label col-form-label-sm">รหัสพนักงาน</label>
									<input class="form-control form-control-sm" type="text" onkeyup="this.value = this.value.toUpperCase();" name="username" value="<?php echo $username; ?>">
							</div>
							<div class="form-group" align="left">
									<label class="col-form-label col-form-label-sm">E-Mail</label>
									<input  class="form-control form-control-sm" type="email" name="email" value="<?php echo $email; ?>">
							</div>
							<div class="form-group" align="left">
								<label class="col-form-label col-form-label-sm">User type</label>
								<select class="form-control form-control-sm" name="user_type">
									<option value="spector">Spector</option>
									<option value="user">User</option>
									<option value="assist">Assist</option>
									<option value="moderator">Moderator</option>
									<!--	<option value="admin">Admin</option> -->
								</select>
							</div>
							<div class="form-group" align="left">
								<label class="col-form-label col-form-label-sm">Shift</label>
								<select class="form-control form-control-sm" name="shift">
									<option value=""></option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
							<div class="form-group" align="left">
									<label class="col-form-label col-form-label-sm">ชื่อ นามสกุล</label>
									<input class="form-control form-control-sm" type="text" name="user_name">
							</div>
							<div class="form-group" align="left">
									<label class="col-form-label col-form-label-sm">ชื่อเล่น</label>
									<input class="form-control form-control-sm" type="text" name="user_nickname">
							</div>
							<div class="form-group" align="left">
									<label class="col-form-label col-form-label-sm">Password</label>
									<input class="form-control form-control-sm" type="password" name="password_1">
							</div>
							<div class="form-group" align="left">
									<label class="col-form-label col-form-label-sm">Confirm password</label>
									<input class="form-control form-control-sm" type="password" name="password_2">
							</div>
							<div class="form-group">
									<br><br>
									<button type="submit" class="btn btn-success" name="register_btn">Create user</button>
									<button class="btn btn-secondary"><a href="home.php" style="color:#FFFFFF; text-decoration:none;">BACK</a></button>
							</div>
						</form>
				</article>
		</div>
	</div>
	<div><iframe src="../credit.html" width="100%" frameBorder="0"></iframe></div>
</body>
</html>
