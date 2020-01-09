<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Stats</title>

<!--Manage place js css file-->
<?php $this->load->view('common/view_head.php');?>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';		

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu1.js"></script>

</head>

<body>

<script language="JavaScript1.2">mmLoadMenus();</script>

<script>

function confirmDeleteWorkSpace ()

{

	var msg = '<?php echo $this->lang->line('msg_workspace_delete');?>';

	if (confirm(msg) == 1)

	{

		return true;

	}

	else

	{

		return false;

	}

}

</script>

<div id="wrap1">
  <div id="header-wrap">
			<!-- header -->	

			<?php  $this->load->view('common/header'); 
			//$this->load->view('common/header_place_panel');
			?>

			<!-- header -->	

			<?php $this->load->view('common/wp_header'); ?>


			<?php
			/*
			$workPlaceDetails = $this->identity_db_manager->getWorkPlaceDetails ($_SESSION['workPlaceId']);

			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId2( $_SESSION['workPlaceId']);

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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
			*/
			//$this->load->view('common/artifact_tabs', $details); ?>

			<!-- Main menu -->	
</div>
</div>
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
<?php
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
?>

				

                      	<div class="menu_new" >

           

						  <ul class="tab_menu_new1">

                        	<li><a href="<?php echo base_url()?>manage_workplace" ><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
							
							<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

							<li><a href="<?php echo base_url()?>view_metering/metering"  class="active"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>language"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
							<li><a href="<?php echo base_url()?>manage_workplace/configuration" ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>

                        	<?php /*?><li><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
							
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=place" target="_blank">
								<img src="<?php echo base_url()?>images/help_new.png" title="help" class="help_icon">
						</a>
						</div>
						<!--Manoj: code end-->

                      	</ul>

					<div class="clr"></div>

					</div>			

                     

					

					<table width="99%" border="0">

                    

                  

		  		<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

					

					<tr>

						<td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

					</tr>	

             

              <?php

				}

				

				?>

		

		<?php

		if(count($db_details) > 0)

		{

			$totalDbSize=0;

			$totalImportedFileSize=0;

		?>		

          <tr>

            <!--<td width="25%"><strong><?php echo $this->lang->line('txt_Month');?></strong></td>-->

            <td width="33%" align="left"><strong><?php echo $this->lang->line('total_db_size_txt'); ?></strong></td>

            <td width="33%" align="left"><strong><?php echo $this->lang->line('total_imported_file_size_txt'); ?></strong></td>

          	<td width="33%" align="left"><strong><?php echo $this->lang->line('total_members_txt'); ?></strong></td>

          </tr>

			<?php

/*			$i=1;

			foreach($db_details as $keyVal=>$data)

			{

			

			   $totalDbSize=$totalDbSize+	$data['dbSize'];

			   $totalMembers=$totalMembers+	$data['membersCount'];

			   $totalImportedFileSize=	$totalImportedFileSize+$data['importedFileSize'];		

				

			?>		

			  <tr class="<?php echo ($i%2==0)?"row2":"row1 ";?>">

				<td><?php echo $data['month'];?></td>

				<td align="left"><?php echo $data['dbSize'];?></td>

				<td align="left"><?php echo $data['importedFileSize'];?></td>

			  	<td align="left"><?php echo $data['membersCount'];?></td>

			  </tr>

		<?php

				$i++;				

			}*/

			?>	
			 <tr>
				<td align="left"><?php echo $db_details['dbSize'];?></td>

				<td align="left"><?php echo $db_details['importedFileSize'];?></td>

			  	<td align="left"><?php echo $db_details['membersCount'];?></td>

			  </tr>

<!--			  <tr>

				<td align="left"><strong><?php echo $this->lang->line('txt_Total');?></strong></td>

				<td align="left"><strong><?php echo $totalDbSize;?></strong></td>

				<td align="left"><strong><?php  echo  $totalImportedFileSize ;?></strong></td>

			  	<td align="left"><strong><?php  echo  $totalMembers ;?></strong></td>

			  </tr>-->

		<?php

			

		}

		else

		{

		?>	

          <tr>

            <td colspan="3"><?php echo $this->lang->line('txt_None');?></td>          

          </tr>

		<?php

		}

		?>

        </table>

	</div>

	<!--Added by Dashrath- load notification side bar-->
	<?php $this->load->view('common/notification_sidebar.php');?>
	<!--Dashrath- code end-->

</div>		

       

 <?php //$this->load->view('common/footer');?>  
 <?php $this->load->view('common/foot.php');?>

</body>
</html>