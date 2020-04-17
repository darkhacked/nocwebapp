<?php
	session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array();

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_POST['changepass_btn'])) {
		changepass();
	}


	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: login.php");
	}

	// REGISTER USER
	function register() {
		global $db, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$shift			 =  e($_POST['shift']);
		$user_name    =  e($_POST['user_name']);
		$user_nickname    =  e($_POST['user_nickname']);


		// form validation: ensure that the form is correctly filled
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (username, email, user_type, shift, user_name, user_nickname, password)
						  VALUES('$username', '$email', '$user_type', '$shift',  '$user_name',  '$user_nickname', '$password')";
				mysqli_query($db, $query);
				$_SESSION['success']  = "New user successfully created!!";
				header('location: home.php');
			}else{
				$query = "INSERT INTO users (username, email, user_type, shift, user_name, user_nickname, password)
						  VALUES('$username', '$email', 'user', '$shift',  '$user_name',  '$user_nickname', '$password')";
				mysqli_query($db, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				header('location: index.php');
			}

		}

	}

	// return user array from their id
	function getUserById($id) {
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login() {
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin/home.php');

				}elseif ($logged_in_user['user_type'] == 'moderator') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: moderator/home.php');

				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: index.php');
				}
			}else {
				array_push($errors, "Wrong Username OR Password");
			}
		}
	}

	function isLoggedIn()	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin() {
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	function isMod() {
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'moderator' ) {
			return true;
		}else{
			return false;
		}
	}

	function isUser() {
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'user' ) {
			return true;
		}else{
			return false;
		}
	}

	function isSpector() {
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'spector' ) {
			return true;
		}else{
			return false;
		}
	}

	function changepass() {
		global $db, $errors;

		$user =  e($_POST['username']);
		$oldpass  =  e($_POST['oldpass']);
		$newpass  =  e($_POST['newpass']);
		$confirmnewpass  =  e($_POST['confirmnewpass']);
		$passmd5 = md5($oldpass);

		$qryoldpass = "SELECT password FROM users WHERE username = '$user'";
		$qry = mysqli_query($db, $qryoldpass);
		while ($qrypass = mysqli_fetch_array($qry)) {
			$oldpass2 = $qrypass["password"];
		}


		if (empty($oldpass)) {
			array_push($errors, "โปรดระบุรหัสผ่านเดิม");
		}
		if ($passmd5 != $oldpass2) {
			array_push($errors, "รหัสผ่านเดิมไม่ถูกต้อง");
		}
		if (empty($newpass)) {
			array_push($errors, "โปรดระบุรหัสผ่านที่ต้องการใหม่");
		}
		if (empty($confirmnewpass)) {
			array_push($errors, "โปรดยืนยันรหัสผ่านใหม่");
		}
		if ($newpass != $confirmnewpass) {
			array_push($errors, "รหัสยืนยันไม่ตรงกับรหัสใหม่");
		}

		if (count($errors) == 0) {
			$password = md5($newpass);

			if (isset($_POST['newpass'])) {
				$query = "UPDATE users SET password='$password' WHERE username='$user'";
				mysqli_query($db, $query);

				array_push($errors, "รหัสผ่านถูกเปลี่ยนแล้วเรียบร้อย");

				session_destroy();
			}

	}
}

	// escape string
	function e($val) {
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}


?>
