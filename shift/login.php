<?php
	include('functions.php')
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="header">
		<h2>NOC JI-NET WORK SCHEDULE</h2>
		<h2>V0.1.1 <a href="changelog.md" target="_blank">Changelog</a></h2>
	</div>

	<form method="post" action="login.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>รหัสพนักงาน</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Login</button>
		</div>
		<p>
			<!--Not yet a member? <a href="register.php">Sign up</a>-->
		</p>
	</form>


</body>
</html>
