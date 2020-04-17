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
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #003366;
		}
		button[name=register_btn] {
			background: #003366;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Create User</h2>
	</div>

	<form method="post" action="create_user.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>รหัสพนักงาน</label>
			<input type="text" onkeyup="this.value = this.value.toUpperCase();" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>User type</label>
			<select name="user_type" id="user_type" >
				<option value="spector">Spector</option>
				<option value="user">User</option>
			  <option value="mod">Moderator</option>
				<!--	<option value="admin">Admin</option> -->
			</select>
		</div>
		<div class="input-group">
			<label>Shift</label>
			<select name="shift" id="user_type">
				<option value=""></option>
				<option value="A">A</option>
				<option value="B">B</option>
			</select>
		</div>
		<div class="input-group">
			<label>ชื่อ นามสกุล</label>
			<input type="text" name="user_name">
		</div>
		<div class="input-group">
			<label>ชื่อเล่น</label>
			<input type="text" name="user_nickname">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn"> + Create user</button>
			<button class="btn" onclick="history.go(-1);">Back</button>
		</div>
	</form>
</body>
</html>
