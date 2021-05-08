<?php
	include('Functions/functions.php');
?>
<!DOCTYPE html>
<html>
 <head>
 <meta charset="utf-8">
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/mystyle.css" rel="stylesheet">
 <script src="Functions/jquery-3.6.0.js"></script>
<title>TOOL อิอิ</title>
</head>
<body>
  <h1>Make Config Router GGEZ</h1>
 <br>
<!--start navbar-->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#mik">Mikrotik</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" data-toggle="tab" href="#hong">Hongdian</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#">Change Profile</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ทำไว้ก่อนยังนึกไม่ออกจะใส่อะไร</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">1</a>
        <a class="dropdown-item" href="#">1</a>
        <a class="dropdown-item" href="#">1</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">4</a>
      </div>
    </li>
  </ul>
  <!--end navbar-->
  <!--start myTabContent-->
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade show active" id="mik"><br>


  <div class="row">
    <div class="col-4">
      <div class="form-group">
        <form class="was-validated" method="post" action="index.php">
          <div class="input-group mb-3">
            <select class="custom-select" name="config" id="configlist">
              <option selected>Select Config</option>
              <option value="1_AISFUP">Mikrotik + 3G AISFUP</option>
              <option disabled value="dtacfup">Mikrotik + 3G DTACFUP // ยังทำไม่เสร็จ</option>
              <option disabled value="internet">Mikrotik + 4G INTERNET (LTE) // ยังทำไม่เสร็จ</option>
            </select>
          </div>

              <div id="1_AISFUP" style="display:none">
                          <div class="input-group is-invalid mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
                            </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
                          </div>

                          <div class="input-group is-invalid mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input USER aisfup</span>
                            </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. aisfup1022" name="usersim">
                          </div>

                          <div class="input-group is-invalid mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
                            </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
                          </div>


                          <div class="form-check mb-3">
                              <input class="form-check-input" type="checkbox" id="addlan2" onclick="add_lan2(this.id);">
                              <label class="form-check-label" for="addlan2">
                                  Add Lan 2 ?
                              </label>
                          </div>

                          <div id="lan2" style="display:none">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Input LAN 2/Subnet</span>
                                <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
                          </div>

                          <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="addlan3" onclick="add_lan3(this.id);">
                            <label class="form-check-label" for="addlan3">
                              Want more ?
                            </label>
                            </div>
                          </div>

                          <div class="input-group mb-3" id="lan3" style="display:none">
                              <span class="input-group-text">Input LAN 3/Subnet</span>
                            <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
                          </div>

                          <div class="btn">
                            <button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
                          </div>
                    </div>
                </form>





            <div id="dtacfup" style="display:none">
              <form method="post" action="#">
                  <div class="input-group mb-3">
                    <span class="input-group-text">Input USER VPN</span>
                    <input type="text" class="form-control" placeholder="Ex. l2temp1097" name="user">
                  </div>
                  <div class="input-group mb-3">
                    <span class="input-group-text">Input USER dtacfup</span>
                    <input type="text" class="form-control" placeholder="Ex. tempa22" name="usersim">
                  </div>
                  <div class="input-group mb-3">
                    <span class="input-group-text">Input LAN/Subnet</span>
                    <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>&nbsp<button type="reset" class="btn btn-secondary">Clear</button>
            </form>
          </div>

          <div id="internet" style="display:none">
            <form method="post" action="#">
                <div class="input-group mb-3">
                  <span class="input-group-text">Input USER VPN</span>
                  <input type="text" class="form-control" placeholder="Ex. l2temp1097" name="user">
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text">Input LAN/Subnet</span>
                  <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>&nbsp<button type="reset" class="btn btn-secondary">Clear</button>
            </form>
          </div>


        </div>
    </div>


    <div class="col bg">
      <font style="color:lightgreen">
        <?php include($ConURL); ?>
      </font>
    </div>
  </div>


    </div>
    <div class="tab-pane fade" id="hong">
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

  <!-- script ซ่อนเมนู -->
      <script language="javascript">
        $("#configlist").change(function(){
        var viewID = $("#configlist option:selected").val();
        $("#configlist option").each(function(){
          var hideID = $(this).val();
          $("#"+hideID).hide();
        });
        $("#"+viewID).show();
        })

        function add_lan2(id){
              if(id=='addlan2'){
              if($('#'+id).is(':checked')==false)
              $('#lan2').css({'display':"none"});

              else {
                $('#lan2').css({'display':""});
              }
            }
          }

          function add_lan3(id){
                if(id=='addlan3'){
                if($('#'+id).is(':checked')==false)
                $('#lan3').css({'display':"none"});

                else {
                  $('#lan3').css({'display':""});
                }
              }
            }

      </script>
  <!-- end script ซ่อนเมนู -->

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
