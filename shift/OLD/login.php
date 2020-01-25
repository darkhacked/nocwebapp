<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/style.css" rel="stylesheet">
<title>WEB SHIFT</title>
</head>
<body>
  <?php
  	session_start();
  	include_once('connect.php');

  	if (isset($_POST['submit'])) {
  		$username = $_POST['user'];
  		$password = $conn->real_escape_string($_POST['pass']);

  		$sql = "SELECT * FROM 'user' WHERE 'user' = '".$username."' AND 'pass' = '".$password."'";
  		$result = $conn->query($sql);

  		echo $result;


  	}
  ?>

<div align="center" style="padding-top:100px">
 <div class="card shadow-lg bg-white rounded" style="width:600px;">
      <article class="card-body">
          <h4 class="card-title text-primary text-center mb-4 mt-1">WORK SCHEDULE Pre-Alpha</h4>
          <hr>
          <!-- <p class="text-primary small">NOC JI-NET WORK SCHEDULE WEB APPLICATION</p>
          <div class="alert alert-warning">
              <h4 class="alert-heading">!! Caution !!</h4>
                <p class="mb-0">ยังเป็น Pre-Alpha เปิดให้ Assis test ระบบก่อน User ทั่วไปรอก่อนนาคร้าบบ</p>
          </div> -->
          <form method="POST" action="">
          <div class="form-group">
          <div class="input-group">
              <input name="user" id="user" type="text" placeholder="Username" class="form-control">
          </div> <!-- input-group.// -->
          </div> <!-- form-group// -->
          <div class="form-group">
          <div class="input-group">
              <input name="pass" id="pass" type="password" placeholder="Password" class="form-control">
          </div> <!-- input-group.// -->
          </div> <!-- form-group// -->
          <div class="form-group">
          <button type="submit" class="btn btn-success">Login</button>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#repass">Reset</button>
          </div> <!-- form-group// -->
          </form>
      </article>
  </div>
</div>

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
      </div>
    </div>
  </div>
</div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
