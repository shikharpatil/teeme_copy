<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<?php //echo "workspaceId= " .$workSpaceId; exit;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>



<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';		



</script>



</head>

<body >

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php //$this->load->view('common/wp_header'); ?>



<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			$details['workSpaces']		= $workSpaces;

			$details['workSpaceId'] 	= $workSpaceId;

			if($workSpaceId > 0)

			{				

				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];

			}

			else

			{

				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	

			}


			/*Commented by Dashrath- Comment for new ui*/
			// $this->load->view('common/artifact_tabs', $details); 

			 ?>

</div>

</div>

<div id="container">

		<!--Added by Dashrath- Add left menu bar for new ui-->
		<div id="leftSideBar" class="leftSideBar">
			<?php $this->load->view('common/left_menu_bar'); ?>
		</div>
		<!--Dashrath- code end-->

		<!--Changed by Dashrath- replace div id content to rightSideBar-->
		<div id="rightSideBar"   >

		    <?php

			$this->load->helper('form'); 

			$attributes = array('name' => 'frmPasswordReset', 'method' => 'post');	

			echo form_open('dashboard/password_reset', $attributes);

			?>

		 

		  			<div >

								<div class="clsMarginBottom10" >

									<div  class="passwordLable"  align="right" ><strong><?php echo $this->lang->line('reset_your_password_txt'); ?> </strong></div>

									<div class="passwordLable" >

														

									</div>

									<div class='clr' ></div>

								</div>

								

								

								<div class="clsMarginBottom10" >

									<div  class="passwordLable error"  align="right" ><?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?></span></div>
									<!--Manoj : success message display here-->
									<div  class="passwordLable successMsg"  align="right" ><?php if(isset($_SESSION['successMsg'])) { echo $_SESSION['successMsg']; $_SESSION['successMsg'] =''; }?></span></div>
									<div class="passwordLable" >

														

									</div>

									<div class='clr' ></div>

								</div>

								

								

								<div class="clsMarginBottom10" >

									<div  class="passwordLable"  align="right" ><?php echo $this->lang->line('txt_Current_Password'); ?> : &nbsp;</span></div>

									<div class="passwordLable" >

											<?php 

												$data = array(

															  'name'      => 'currentPassword',

															  'id'        => 'currentPassword',

															  'type'      => 'password',		

															  'size'      => '20',

															  'class'   => 'text_gre'																		

															);															

												echo form_input($data);

											?>			

														

									</div>

									<div class='clr' ></div>

								</div>

								

								

								<div class="clsMarginBottom10" >

									<div  class="passwordLable"  align="right" ><?php echo $this->lang->line('txt_New_Password'); ?> : &nbsp;</span></div>

									<div class="passwordLable" >

									

												<?php 

													$data = array(

																  'name'      => 'newPassword',

																  'id'        => 'newPassword',

																  'type'      => 'password',		

																  'size'      => '20',

																  'class'   => 'text_gre'																		

																);															

													echo form_input($data);

												?>		

														

									</div>

									<div class='clr' ></div>

								</div>

								

								

								<div class="clsMarginBottom10" >

									<div  class="passwordLable"  align="right" ><?php echo $this->lang->line('txt_Confirm_Password_New'); ?> : &nbsp;</span></div>

									<div class="passwordLable" >

									

												

												

												<?php 

															$data = array(

																		  'name'      => 'confirmPassword',

																		  'id'        => 'confirmPassword',

																		  'type'      => 'password',		

																		  'size'      => '20',

																		  'class'   => 'text_gre'																		

																		);															

															echo form_input($data);

															?>		

														

									</div>

									<div class='clr' ></div>

								</div>

								

								

								<div class="clsMarginBottom10" >

									<div  class="passwordLable"  align="right" >&nbsp;</span></div>

									<div class="passwordLable" >

										<?php 

												$data = array(

															  'name'      => 'submit',

															  'id'        => 'submit',

															  'type'      => 'submit',		

															  'value'     => 'OK',

															  'class'     => 'button01'																		  																		

															);															

												echo form_input($data);

				                         ?>

									</div>

									<div class='clr' ></div>

								</div>

								

				</div>

		

		        <?php

				echo form_close();

				?>	

	 </div>	

</div>

<div>

<?php $this->load->view('common/foot.php');?>

<?php 
/*Commented by Dashrath- Commented for new ui*/
// $this->load->view('common/footer');
?>

</div>

</body>

</html>		

