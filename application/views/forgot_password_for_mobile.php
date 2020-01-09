<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	//var workSpaceId		= '<?php echo $workSpaceId;?>';

	//var workSpaceType	= '<?php echo $workSpaceType;?>';		

</script>


</head>

<body >

<div id="wrap1">

<div id="header-wrap" style="width:100%;">

<?php $this->load->view('common/header_for_mobile'); ?>

<?php //$this->load->view('common/wp_header'); ?>



<?php

/*			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

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

			 $this->load->view('common/artifact_tabs', $details); 
*/
?>

</div>

</div>

<div id="container_for_mobile">
		<div id="content">

		    <?php

			$this->load->helper('form'); 

			$attributes = array('name' => 'frmPasswordReset', 'method' => 'post');	

			echo form_open('forgot_password/send_forgot_password_email', $attributes);

			?>

		 

		  			<div >

								<div class="clsMarginBottom10" style="margin-top:15px;">

									<div  class="passwordLable"  align="left" ><strong><?php echo $this->lang->line('please_enter_your_email'); ?> </strong></div>

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

								<div class="clsMarginBottom10" style="text-align:left">

									<div  class="passwordLable"  ><?php echo $this->lang->line('txt_Email'); ?> : &nbsp;</span></div>

									<div class="passwordLable" >

									

												<?php 

													$data = array(

																  'name'      => 'username',

																  'id'        => 'username',

																  'type'      => 'text',		

																  'size'      => '30',

																  'class'   => 'text_gre'																		

																);															

													echo form_input($data);

												?>		

														

									</div>

									<div class='clr' ></div>

								</div>

								<div class="clsMarginBottom10" style="text-align:left" >
									<input type="hidden" name="place_name" value="<?php echo $place_name;?>" />
									<input type="hidden" name="user_type" value="<?php echo $user_type;?>" />

									<?php /*?><div class="passwordLable"  align="right" >&nbsp;</span></div><?php */?>

									<div class="passwordLable" >

										<?php 

												$data = array(

															  'name'      => 'submit',

															  'id'        => 'submit',

															  'type'      => 'submit',		

															  'value'     => 'Done'																  																		

															);															

												echo form_input($data);

				                         ?>

									</div>

									<div class='clr' ></div>

								</div>
								<div class="clsMarginBottom10 flLt">
								<a href="javascript:void(0);" onClick="history.go(-1)"><< Back</a>
								<div class='clr' ></div>
								</div>

								

				</div>

		

		        <?php

				echo form_close();

				?>	

	 </div>	

</div>

<div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</div>

</body>

</html>		

