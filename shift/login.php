<?php
	include('Functions/functions.php')
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
	          <h4 class="card-title text-primary text-center mt-1">NOC JI-NET WORK SCHEDULE</h4>
						<h6 class="card-title text-primary text-center">Version 1.6.2 | <a href="changelog.html" target="_blank"><font color="lightblue">Changelog</font></a></h6>
	          <hr>
	          <!--<p class="text-primary small">V0.1.1 <a href="changelog.md" target="_blank">Changelog</a></p>-->
	          <div class="alert alert-warning">
	                <p class="mb-0">สามารถเข้าใช้งานได้แล้วโดย user = รหัสพนง / pass = 1234<br>Login แล้วเข้าไปเปลี่ยนรหัสผ่านกันเองนะครับ<br></p>
	          </div>
	          <form method="POST" action="login.php">
							<?php echo display_error(); ?>
	          <div class="form-group">
	          <div class="input-group">
	              <input name="username" id="username" type="text" onkeyup="this.value = this.value.toUpperCase();" placeholder="รหัสพนักงาน" class="form-control">
	          </div> <!-- input-group.// -->
	          </div> <!-- form-group// -->
	          <div class="form-group">
	          <div class="input-group">
	              <input name="password" id="password" type="password" placeholder="Password" class="form-control">
	          </div> <!-- input-group.// -->
	          </div> <!-- form-group// -->
	          <div class="form-group">
	          <button type="submit" class="btn btn-success" name="login_btn">Login</button>
	          <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#repass">Reset</button> -->
	          </div> <!-- form-group// -->
	          </form>
	      </article>
	  </div>
	</div>
 <!-- Start foget password -->
	<div class="modal fade" id="repass" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Not Avaliable
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary">RESET</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					 <!-- end foget password -->
	      </div>
	    </div>
	  </div>
	</div>
	<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>
	<br>
	<script src="js/jquery.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
