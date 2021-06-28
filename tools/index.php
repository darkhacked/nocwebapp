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
<title>ติด 3G อีกและ</title>
</head>
<body>
  <h1>Make Config Router GGEZ</h1>
	<h5>Config อันไหนทำแล้วไม่ Up หรือมี Config ตัวใหม่จาก TSD เพิ่มเติมบอกด้วยนะเดี๋ยว Update ให้</h5>
 <br>
<!--start navbar-->
<div class="row">
<div class="col-4">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#mik">Mikrotik</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#hong">Hongdian</a>
    </li>
    <!--<li class="nav-item">
      <a class="nav-link disabled" href="#">-</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle disabled" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">-</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">1</a>
        <a class="dropdown-item" href="#">1</a>
        <a class="dropdown-item" href="#">1</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">4</a>
      </div>
    </li>-->
  </ul>
  <!--end navbar-->
  <!--start myTabContent-->
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade show active" id="mik"><br>
    <div class="col">
      <div class="form-group">

          <div class="input-group mb-3">
            <select class="custom-select" name="config" id="configlist">
              <option selected>Select Config</option>
              <option value="1_AISFUP">Mikrotik + 3G AISFUP</option>
              <option value="2_DTACFUP">Mikrotik + 3G DTACFUP</option>
              <option value="3_4GNETVPN">Mikrotik + 4G INTERNET (VPN)</option>
							<option value="4_4GNETNET">Mikrotik + 4G INTERNET (NET)</option>
            </select>
          </div>

              <div id="1_AISFUP" style="display:none">
								<form class="was-validated" method="post" action="index.php">
									<input type="hidden" name="config" value="1_AISFUP">
                      <div class="input-group is-invalid mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
                          </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
                      </div>

                      <div class="input-group is-invalid mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input USER Aisfup</span>
                          </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. aisfup1022" name="usersim">
                      </div>

                      <div class="input-group is-invalid mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
                            </div>
                              <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
                          </div>

                      <div>
                              Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
                      </div>

                      <div>
                          <div class="input-group mb-3">
                              <span class="input-group-text">Input LAN 2/Subnet</span>
                              <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
                      		</div>

													<div class="input-group mb-3">
			                        <span class="input-group-text">Input LAN 3/Subnet</span>
			                        <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
			                    </div>
                      </div>

                    <div class="btn">
                        <button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
                    </div>
								</form>
              </div>



							<div id="2_DTACFUP" style="display:none">
								<form class="was-validated" method="post" action="index.php">
									<input type="hidden" name="config" value="2_DTACFUP">
			               <div class="input-group is-invalid mb-3">
			                  <div class="input-group-prepend">
			                        <span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
			                  </div>
			                        <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
			               </div>
			                  <div class="input-group is-invalid mb-3">
			                    <div class="input-group-prepend">
			                        <span class="input-group-text" id="validatedInputGroupPrepend">Input USER Dtacfup</span>
			                    </div>
			                        <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. aisfup1022" name="usersim">
			                  </div>
			                  <div class="input-group is-invalid mb-3">
			                    <div class="input-group-prepend">
			                        <span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
			                    </div>
			                        <input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
			                  </div>

												<div>
	                              Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
	                      </div>

	                      <div>
	                          <div class="input-group mb-3">
	                              <span class="input-group-text">Input LAN 2/Subnet</span>
	                              <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
	                      		</div>

														<div class="input-group mb-3">
				                        <span class="input-group-text">Input LAN 3/Subnet</span>
				                        <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
				                    </div>
	                      </div>

			                  <div class="btn">
			                        <button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
			                  </div>
								</form>
				      </div>


							<div id="3_4GNETVPN" style="display:none">
								<form class="was-validated" method="post" action="index.php">
									<input type="hidden" name="config" value="3_4GNETVPN">
										<div class="input-group is-invalid mb-3">
											<div class="input-group-prepend">
													<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
											</div>
													<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
										</div>

										<div class="input-group is-invalid mb-3">
											<div class="input-group-prepend">
													<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
											</div>
													<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
										</div>

										<div>
														Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
										</div>

										<div>
												<div class="input-group mb-3">
														<span class="input-group-text">Input LAN 2/Subnet</span>
														<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
												</div>

												<div class="input-group mb-3">
														<span class="input-group-text">Input LAN 3/Subnet</span>
														<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
												</div>
										</div>

										<div class="btn">
													<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
										</div>
									</form>
								</div>



							<div id="4_4GNETNET" style="display:none">
								<form class="was-validated" method="post" action="index.php">
									<input type="hidden" name="config" value="4_4GNETNET">
													<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN + Domain</span>
														</div>
															<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. greenlatex2@jiplus" name="user">
													</div>

													<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="validatedInputGroupPrepend">Input Password VPN</span>
														</div>
															<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 1234567" name="passvpn">
													</div>

													<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
														</div>
															<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
													</div>

													<div>
		                              Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
		                      </div>

		                      <div>
		                          <div class="input-group mb-3">
		                              <span class="input-group-text">Input LAN 2/Subnet</span>
		                              <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
		                      		</div>

															<div class="input-group mb-3">
					                        <span class="input-group-text">Input LAN 3/Subnet</span>
					                        <input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
					                    </div>
		                      </div>

														<div class="btn">
																	<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
														</div>
												</form>
										</div>
				        </div>
				    </div>
				  </div>


    <div class="tab-pane fade" id="hong">
		    <div class="col">
		      <div class="form-group">
						<br>
		          <div class="input-group mb-3">
		            <select class="custom-select" name="config" id="configlist2">
		              <option selected>Select Config</option>
		              <option value="H1_AISFUP">Hongdian + 3G AISFUP</option>
		              <option value="H2_AISVPN">Hongdian + 3G AISVPN (tempa)</option>
		              <option value="H3_DTACFUP">Hongdian + 3G DTACFUP</option>
									<option value="H4_4GNET">Hongdian + SIM 3G&4G INTERNET (VPN)</option>
		            </select>
		          </div>

								<div id="H1_AISFUP" style="display:none">
									<form class="was-validated" method="post" action="index.php">
										<input type="hidden" name="config" value="H1_AISFUP">
												<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
																<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
														</div>
																<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
												</div>

												<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
																<span class="input-group-text" id="validatedInputGroupPrepend">Input USER Aisfup</span>
														</div>
																<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. aisfup1022" name="usersim">
												</div>

												<div class="input-group is-invalid mb-3">
														<div class="input-group-prepend">
																<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
															</div>
																<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
														</div>

												<div>
																Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
												</div>

												<div>
														<div class="input-group mb-3">
																<span class="input-group-text">Input LAN 2/Subnet</span>
																<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
														</div>

														<div class="input-group mb-3">
																<span class="input-group-text">Input LAN 3/Subnet</span>
																<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
														</div>
												</div>

									<div class="btn">
											<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
									</div>
							</form>
					</div>


					<div id="H2_AISVPN" style="display:none">
						<form class="was-validated" method="post" action="index.php">
							<input type="hidden" name="config" value="H2_AISVPN">
									<div class="input-group is-invalid mb-3">
											<div class="input-group-prepend">
													<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
											</div>
													<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
									</div>

									<div class="input-group is-invalid mb-3">
											<div class="input-group-prepend">
													<span class="input-group-text" id="validatedInputGroupPrepend">Input USER Aisfup</span>
											</div>
													<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. tempa66" name="usersim">
									</div>

									<div class="input-group is-invalid mb-3">
											<div class="input-group-prepend">
													<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
												</div>
													<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
											</div>

									<div>
													Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
									</div>

									<div>
											<div class="input-group mb-3">
													<span class="input-group-text">Input LAN 2/Subnet</span>
													<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
											</div>

											<div class="input-group mb-3">
													<span class="input-group-text">Input LAN 3/Subnet</span>
													<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
											</div>
									</div>

										<div class="btn">
												<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
										</div>
								</form>
						</div>



						<div id="H3_DTACFUP" style="display:none">
							<form class="was-validated" method="post" action="index.php">
								<input type="hidden" name="config" value="H3_DTACFUP">
										<div class="input-group is-invalid mb-3">
												<div class="input-group-prepend">
														<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
												</div>
														<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
										</div>

										<div class="input-group is-invalid mb-3">
												<div class="input-group-prepend">
														<span class="input-group-text" id="validatedInputGroupPrepend">Input USER dtacfup</span>
												</div>
														<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. dtacfup1004" name="usersim">
										</div>

										<div class="input-group is-invalid mb-3">
												<div class="input-group-prepend">
														<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
													</div>
														<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
												</div>

										<div>
														Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
										</div>

										<div>
												<div class="input-group mb-3">
														<span class="input-group-text">Input LAN 2/Subnet</span>
														<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
												</div>

												<div class="input-group mb-3">
														<span class="input-group-text">Input LAN 3/Subnet</span>
														<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
												</div>
										</div>

											<div class="btn">
													<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
											</div>
									</form>
							</div>



							<div id="H4_4GNET" style="display:none">
								<form class="was-validated" method="post" action="index.php">
									<input type="hidden" name="config" value="H4_4GNET">
											<div class="input-group is-invalid mb-3">
													<div class="input-group-prepend">
															<span class="input-group-text" id="validatedInputGroupPrepend">Input USER VPN</span>
													</div>
															<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. l2temp1097" name="user">
											</div>

											<div class="input-group is-invalid mb-3">
													<div class="input-group-prepend">
															<span class="input-group-text" id="validatedInputGroupPrepend">Input LAN/Subnet</span>
														</div>
															<input type="text" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required placeholder="Ex. 10.21.197.254/24" name="lan">
													</div>

											<div>
															Option Lan 2-3 จะใส่ไม่ใส่ก็ได้
											</div>

											<div>
													<div class="input-group mb-3">
															<span class="input-group-text">Input LAN 2/Subnet</span>
															<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan2">
													</div>

													<div class="input-group mb-3">
															<span class="input-group-text">Input LAN 3/Subnet</span>
															<input type="text" class="form-control" placeholder="Ex. 10.21.197.254/24" name="lan3">
													</div>
											</div>

												<div class="btn">
														<button type="submit" class="btn btn-primary" name="submit_btn">โอม จง Upๆ</button>
												</div>
										</form>
								</div>


				</div>
			</div>
    </div>


		</div>
    <div class="tab-pane fade" id="dropdown1">
      <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
    </div>
    <div class="tab-pane fade" id="dropdown2">
      <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
    </div>
  </div>
	<!--end myTabContent-->

	<div class="col">
		<button class="btn btn-primary btn-sm mb-3" onclick="CopyToClipboard('showconfig')">Click to Copy</button>&nbsp;&nbsp;&nbsp;☜(ﾟヮﾟ☜)
		<div><?php include($ConURL);?></div>
	</div>
</div>  <!--end row-->


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

				$("#configlist2").change(function(){
				var viewID = $("#configlist2 option:selected").val();
				$("#configlist2 option").each(function(){
					var hideID = $(this).val();
					$("#"+hideID).hide();
				});
				$("#"+viewID).show();
				})

				//ฟังชั่น copy text in pre tag
				function CopyToClipboard() {
				  const copyText = document.getElementById("showconfig").textContent;
				  const textArea = document.createElement('textarea');
				  textArea.textContent = copyText;
				  document.body.append(textArea);
				  textArea.select();
				  document.execCommand("copy");
					alert("Copy Config เรียบร้อย")
				}

				document.getElementById('button').addEventListener('click', copyFunction);


//ฟังชั่น copy text in div tag มี bug ไม่แสดงผลกับ chrome
//						function CopyToClipboard(containerid) {
//					  if (document.selection) {
//					    var range = document.body.createTextRange();
//					    range.moveToElementText(document.getElementById(containerid));
//					    range.select().createTextRange();
//					    document.execCommand("copy");
//					  } else if (window.getSelection) {
//					    var range = document.createRange();
//					    range.selectNode(document.getElementById(containerid));
//					    window.getSelection().addRange(range);
//					    document.execCommand("copy");
//					    alert("Copy Config เรียบร้อย")
//					  }
//					}


      </script>
  <!-- end script ซ่อนเมนู -->

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
