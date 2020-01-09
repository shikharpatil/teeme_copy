<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

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

<script language="javascript" type="application/javascript" src="<?php echo base_url();?>js/function_tablet.js"></script>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<!--Manoj: added jquery alert css for admin login error popup-->

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

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

						$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheckInstance(this)');	

						echo form_open(base_url().'instance/login/loginCheck', $attributes);

				?>

						

						

						<?php /*?><div class="clsMarginBottom10"  ><strong><?php echo $this->lang->line('admin_login_txt'); ?> </strong></div><?php */?>

						

						

						<?php /*?><div class="clsMarginBottom10" ><span   class=" error"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div><?php */?>

						
			<table cellpadding="4px">
			<tr>
				<td class="leftLogin"></td>
				<td class="rightLogin">
				<div><strong><?php echo $this->lang->line('admin_login_txt'); ?> </strong></div>
				</td>
			</tr>
			<tr>
				<td colspan="2"><div class="clsMarginBottom10" ><span class=" error"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div></td>
			</tr>
			<tr>
				<td class="leftLogin"><span class="loginLable"><?php echo $this->lang->line('txt_Email');?>: </span> </td>
				<td class="rightLogin"><span>
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

          </span></td>
			</tr>
			<tr>
				<td class="leftLogin"><span class="loginLable"  align="left" ><?php echo $this->lang->line('txt_Password');?>: </span></td>
				<td class="rightLogin"><span>
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

          </span></td>
			</tr>
			<tr>
				<td class="leftLogin"></td>
				<td class="rightLogin"><span>
			<input type="hidden" id="timeDiff" name="timeDiff" value="0" />			
			
				
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

																		  'value'     => 'Login'																	  																		

																		);															

															echo form_input($data);

															

					

					 echo form_close() ;?>
			</span>
			<span>
			<a href="<?php echo base_url();?>forgot_password/index/0/a"><?php echo $this->lang->line('forgot_password_txt'); ?></a>
			</span></td>
			</tr>
		</table>

						
						<!--Old login code start-->
						<?php /*?><div class="widthForLogin">

						<div class="clsMarginBottom10" >

							<div  class="loginLable"  align="right" ><?php echo $this->lang->line('txt_Email');?> : &nbsp; </div>

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

						<div class="clsMarginBottom10" style="margin-right:60px;">
						<input type="hidden" id="timeDiff" name="timeDiff" value="0" />

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

																		  'value'     => 'Login'																	  																		

																		);															

															echo form_input($data);

															

					

					 echo form_close() ;?>
					 </div>
					 <div class="clsMarginBottom10" >
					 <a href="<?php echo base_url();?>forgot_password/index/0/a"><?php echo $this->lang->line('forgot_password_txt'); ?></a>
					 </div><?php */?>
					 <!--Old login code end-->



        </div>

</div>

<div>

<?php $this->load->view('common/footer');?>

</div>	

</body>

</html>	



<script>
function updateTimeZone()

{	

	var now = new Date();

	var offset = (now.getTimezoneOffset() / 60)*-1;

	

	document.getElementById('timeDiff').value = offset;

	//setCookie ('time_diff',offset);

}

var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));

if(ismobile)

{

   document.cookie="ismobile_admin=1";

}

else

{

   document.cookie="ismobile_admin=0";

}   



function loginCheckInstance(){

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