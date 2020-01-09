<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

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

			 $this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container" >



		<div id="content">

		

				

						<div class="menu_new" >

           

						  <ul class="tab_menu_new1">

						  <li><a href="<?php echo base_url()?>edit_workspace/index/<?php echo $workSpaceId;?>"><span><?php echo $this->lang->line('txt_Edit_Workspace');?></span></a></li>

                        	<li><a href="<?php echo base_url()?>view_sub_work_spaces/index/<?php echo $workSpaceId;?>/1"><span><?php echo $this->lang->line('txt_View_Sub_Workspaces');?></span></a></li>

                        	<li><a href="<?php echo base_url();?>create_sub_work_space/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Create_Sub_Workspace');?></span></a></li>

                        	<li><a href="<?php echo base_url()?>help/space_manager/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Help');?></span></a></li>

                        </ul>

						<div class="clr"></div>

                	</div>

						<?php 

							$this->load->view('help/space_manager_help');

						?>

				

				

   </div>

</div>

<?php $this->load->view('common/foot.php');?>

<?php $this->load->view('common/footer');?>

</body>

</html>		