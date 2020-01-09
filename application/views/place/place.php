<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>



<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js">

</script>

</head>

<body onLoad="updateTimeZone()">

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

</div>

</div>

<div id="container">



		<div id="content" align="center"   >

		

				<?php

						


						$this->load->helper('form'); 

						$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheckPlace(this)');	

						echo form_open('/login_check/place_manager_login_check/'.$this->uri->segment(2), $attributes);

						?>

						

						

						<div class="clsMarginBottom10"  ><strong><?php echo $this->lang->line('txt_Place_Manager_Login');?> </strong></div>

						

						

						<div class="clsMarginBottom10" ><span   class=" error"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div>

						

						

						<div class="widthForLogin">

						<div class="clsMarginBottom10" >

							<div  class="loginLable"  align="right" ><?php echo $this->lang->line('txt_Email');?> : &nbsp; 

                        </div>

						<div class="loginLable" >

							 <?php 

                                $data = array(

										  'name'      => 'userName',

										  'id'        => 'userName',

										  'type'      => 'text',		

										  'size'      => '25',

										  'class'   => 'text_gre'																		

										);															

                                echo form_input($data);

                             ?>

						</div>

						<div class='clr' ></div>

					</div>

						

						

						

						<div  class="clsMarginBottom10" >

							<div class="loginLable"  align="right" ><?php echo $this->lang->line('txt_Password');?> : &nbsp; </div>

							

							<div class="loginLable" >

													 <?php 

															$data = array(

																		  'name'      => 'userPassword',

																		  'id'        => 'userPassword',

																		  'type'      => 'password',		

																		  'size'      => '25',

																		  'class'   => 'text_gre'																		

																		);															

															echo form_input($data);

															?>

							</div>

							<div class='clr'></div>

						</div>

						

						</div>

						<div class="clsMarginBottom10" >

					<input type="hidden" name="contName" value="<?php echo $contName;?>" />
					
					<input type="hidden" id="timeDiff" name="timeDiff" value="0" />

                  <input type="hidden" name="workPlaceId" value="<?php echo $workPlaceId;?>" />

                  <?php 

					$data = array(

								  'name'      => 'action',

								  'id'        => 'action',

								  'type'      => 'hidden',		

								  'value'      => 'userLogin'																		  																		

								);															

					echo form_input($data);

					$data = array(

								  'name'      => 'Submit',

								  'id'        => 'Submit',

								  'type'      => 'submit',		

								  'value'     => "   ".$this->lang->line('txt_Login')."   "																	  																		

								);															

					echo form_input($data);

					?>

					

					<?php echo form_close() ;?>

				</div>
				<div>
				<a href="<?php echo base_url();?>forgot_password/index/<?php echo $contName;?>/u">Forgot password?</a>
				</div>

        </div>

</div>

<div>

<?php $this->load->view('common/footer');?>

</div>

</body>

</html>

<script>

//this function used to update the time difference between client machine and GMT time

function updateTimeZone()

{	

	var now = new Date();

	var offset = (now.getTimezoneOffset() / 60)*-1;

	

	document.getElementById('timeDiff').value = offset;

	//setCookie ('time_diff',offset);

}

updateTimeZone();

var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));

if(ismobile==true)

{

   document.cookie="ismobile_place=1"+";path=/";

   //document.cookie="ismobile=1";

}

else

{

   document.cookie="ismobile_place=0"+";path=/";

   //document.cookie="ismobile=0";

}   





function loginCheckPlace(){

	var userName = $('#userName').val();

	var userPass = $('#userPassword').val();

	var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;

	var err='';

	if(userName==''){

		err +="Please enter email<br />";

	}

	else if(emailTest.test(userName)==false){

		err +="Please enter valid email<br />";

	}

	if(userPass==''){

		err +="Please enter password.";

	}

	if(err==''){

		

	}else{

		jAlert (err,'Alert');

		return false;

	}

}

</script>