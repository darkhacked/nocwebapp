
<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/mystyle.css" rel="stylesheet">
<title>Super</title>
</head>
<body>
 <h1>TEST</h1>
 <br>
<!--start navbar-->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Check User Online</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#profile">Find User Interrim</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="#">Change Profile</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Separated link</a>
      </div>
    </li>
  </ul>
  <!--end navbar-->
  <!--start myTabContent-->
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade show active" id="home"><br>
      <div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Warning!</h4>
  <p class="mb-0">อิสสะโฟ้ อิสสะเฟ้ หยุกหยิก ดุกดิก งุงิ จุ๊กกรู้ <a href="#" class="alert-link">อย่าคลิกไม่มีอะไรหรอก</a>.</p>
      </div>
      <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
	<form action="/test.py" method="get">
	<div class="form-group">
  <label class="col-form-label" for="inputDefault">Default input</label>
  <input type="text" class="form-control" placeholder="Default input" id="inputDefault" name="wan"><br>
  <button type="submit" class="btn btn-primary">Submit</button>&nbsp<button type="reset" class="btn btn-primary">Reset</button>
	</div>
	</form>
    </div>
    <div class="tab-pane fade" id="profile">
      <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
    </div>
    <div class="tab-pane fade" id="dropdown1">
      <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
    </div>
    <div class="tab-pane fade" id="dropdown2">
      <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
    </div>
  </div>
  <!--end myTabContent-->
  <!--start footer-->
  <div class="credit">
	<hr>
    <span class="border-0">
          <p class="text-secondary">© 2020-2021 Management by Mawmasing.<br>This Web application All rights reserved under <a href="LICENSE.txt"><font color=#444>WTFPL LICENSE</font></a>.</br></p>
          <a href="http://www.wtfpl.net/"><img
       src="http://www.wtfpl.net/wp-content/uploads/2012/12/wtfpl-badge-4.png"
       width="80" height="15" alt="WTFPL" /></a>
    </span>
  </div>
  <!--end footer-->
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
