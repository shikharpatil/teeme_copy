<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/stylish-select.css" />

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

<?php $this->load->view('common/view_head.php');?>

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>



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
			//print_r ($details); exit;

			/*Commented by Dashrath- comment old ui code*/
			//$this->load->view('common/artifact_tabs', $details);

	?>

		



</div>

</div>





       

         <div id="container">

         	<!--Added by Dashrath- Add left menu bar-->
         	<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
			</div>
			<!--Dashrath- code end-->

		<!--Changed by Dashrath- change div id content to rightSideBar-->
		<div id="rightSideBar"> 

          

			

			<!-- Main menu -->	

			

		  

		 

            <table width="<?php echo $this->config->item('page_width')-55;?>" border="0" cellpadding="0" cellspacing="0">

                

                <tr>

                  <td colspan="2" align="left" valign="top">

				  <!-- Main Body -->

				  

				  <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

				  

				  <!-- Main Body -->

				</td>

                </tr>

            </table>

   

</div>
		<!--Added by Dashrath- load notification side bar-->
		<?php $this->load->view('common/notification_sidebar.php');?>
		<!--Dashrath- code end-->

</div>

<div>

<!--Commented by Dashrath- comment footer-->
<?php //$this->load->view('common/footer');?>
<?php $this->load->view('common/foot.php');?>

</div>

</body>

</html>