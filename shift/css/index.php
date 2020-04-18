<?php
	include('../Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (isAdmin()) {
		header('location: ../admin/home.php');
	}elseif (isMod()) {
		header('location: ../moderator/home.php');
	}elseif (isUser()) {
		header('location: ../index.php');
	}elseif (isSpector()) {
		header('location: ../spector/index.php');
	}
?>
