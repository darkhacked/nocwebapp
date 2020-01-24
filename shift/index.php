<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/style.css" rel="stylesheet">
<title>WEB SHIFT</title>
</head>
<body>
<div align="center" style="padding-top:100px">
 <div class="card shadow-sm bg-white rounded" style="width:600px;">
                    <article class="card-body">
                        <h4 class="card-title text-info text-center mb-4 mt-1">WORK SCHEDULE V0.1</h4>
                        <hr>
                        <p class="text-info">NOC JI-NET WORK SCHEDULE WEB APPLICATION</p>
                        <form name="form1" method="post" action="check-newlogin.php">
                        <div class="form-group">
                        <div class="input-group">
                            <input name="txtUsername" id="txtUsername" type="Username" placeholder="Username" class="form-control" onkeydown="upperCaseF(this)">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                        <div class="input-group">
                            <input name="txtPassword" id="txtPassword" type="password" placeholder="Password" class="form-control">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                        <button type="submit" class="btn btn-success">Login</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal">Reset</button>
                        </div> <!-- form-group// -->
                        </form>
                    </article>
  </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        test test system ทดสอบๆๆๆสวดาวกาเกเ
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
