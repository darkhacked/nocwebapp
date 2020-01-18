<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/mystyle.css" rel="stylesheet">
<title>WEB SHIFT</title>
</head>
<body>
 <div class="card shadow-sm bg-white rounded ">
                    <article class="card-body">
                        <h4 class="card-title text-info text-center mb-4 mt-1">Welcome</h4>
                        <hr>
                        <form name="form1" method="post" action="check-newlogin.php">
                        <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input name="txtUsername" id="txtUsername" type="Username" placeholder="Username" value="26-924" class="form-control" onkeydown="upperCaseF(this)">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                             </div>
                            <input name="txtPassword" id="txtPassword" type="password" placeholder="Password" value="0816789959" class="form-control">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <div class="checkbox">
                              	<input type="checkbox" name="remember" id="remember" checked=""> <small class="text-muted">Save password</small>
                            </div> <!-- checkbox .// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary btn-block"> Login  </button>
                        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#forgotPWModal">Get password</button>
                        </div> <!-- form-group// -->
                        </form>
                    </article>
  </div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
