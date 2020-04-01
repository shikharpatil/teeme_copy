<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Backups</title>

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

<script language="JavaScript1.2">mmLoadMenus();</script>

</head>

<body>

<div id="wrap1">
  <div id="header-wrap">

			<!-- header -->	

			<?php  $this->load->view('common/header'); 
			//$this->load->view('common/header_place_panel');
			?>

			<!-- header -->	
			<?php $this->load->view('common/wp_header'); 
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
			//$this->load->view('common/artifact_tabs', $details);
?>

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

                        	<li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
							
							<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

							<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup" class="active"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
							
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
				</div>

				<!--Added by Dashrath- load notification side bar-->
				<?php $this->load->view('common/notification_sidebar.php');?>
				<!--Dashrath- code end-->
<div style="margin-left:210px;">				
<table border="0" align="left" cellpadding="0" cellspacing="0">

<tr>

  <td valign="top">

	  <table width="<?php //echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

		<tr>

		  <td align="left" valign="top">

		  <!-- header -->	

		  

		  <!-- header -->	

		  </td>

		</tr>

		<tr>

		  <td align="left" valign="top">&nbsp;</td>

		</tr>

	  

		<tr>

		  <td align="left" valign="top"><table width="<?php //echo $this->config->item('page_width')+35;?>" border="0" align="center" cellpadding="0" cellspacing="0">

			  <tr>

				<td align="left" valign="top">

				  <!-- Main Body -->

				  <table width="100%" border="0" cellpadding="6" cellspacing="6">

				  

				  <tr>

					  <td colspan="5" align="left">

					  <?php //echo $this->lang->line('msg_workplaces_not_available');?>
					
					  <form method="post" action="">
												  
						  <input type="submit" name="backup" value="Create New Backup" onclick="document.getElementById('please_wait').style.display='';" />

					  </form>

				  <!--onclick="document.getElementById('please_wait').style.display='';"-->

					  <span id="please_wait" style="display:none;">

						  <?php echo $this->lang->line('please_wait_txt'); ?>

					  </span>

					  </td>

					</tr>
			   <?php
			  //Manoj: code to show the status of backup
			  
			  
			  if( $Place_Backup_Fail!='false' && $Remote_Backup_Fail=='false')
			  {
			  ?>

				<tr>
				  <td colspan="5" class="tdSpace"><span class="successMsg"><?php echo  $this->lang->line('current_server_backup_success'); ?></span></td>
			  </tr>
			  <tr>
				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('Remote_backup_failed'); ?></span></td>
			  </tr>

				<?php				
			  }
			  else if($Place_Backup_Fail=='false' && $Remote_Backup_Fail=='false')

			  {

			  ?>

				<tr>

				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('current_server_backup_failed'); ?></span></td>
			  </tr>
			  <tr>
				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('Remote_backup_failed'); ?></span></td>
			  </tr>

				<?php

			  }
			  else if($Place_Backup_Fail=='false')

			  {

			  ?>

				<tr>
				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('current_server_backup_failed'); ?></span></td>
			  </tr>
			  
			  <?php

			  }
			  else if($Remote_Backup_Sucess==1 && $Place_Backup_Success==1)
			  {
			  ?>

				<tr>

				  <td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('current_server_backup_success'); ?></span></td>
			  </tr>
			  <tr>
				  <td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('Remote_backup_success'); ?></span></td>

				</tr>

				<?php				
			  }
			  else if($Place_Backup_Success==1)
			  {
			  ?>

				<tr>
				  <td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('current_server_backup_success'); ?></span></td>
			  </tr>
			  
			  <?php				
			  }
			  
			  if(isset($_SESSION['ftpErrorMsg']) && $_SESSION['ftpErrorMsg'] !=	"")

			  {

			  ?>

				<tr>

				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['ftpErrorMsg']; $_SESSION['ftpErrorMsg'] ='';?></span></td>

				</tr>

				<?php

			  }
			  
			  //Manoj: showing backup status end
			  /*
			  if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

			  {

			  ?>

				<?php ?><tr>

				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

				</tr><?php ?>

				<?php

			  }
			  */
			  if(isset($_SESSION['backupStatusMsg']) && $_SESSION['backupStatusMsg'] !=	"")

			  {

			  ?>

				<?php ?><tr>

				  <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['backupStatusMsg']; $_SESSION['backupStatusMsg'] ='';?></span></td>

				</tr><?php ?>

				<?php

			  }
			  if ($success==1)

			  {

/*					header('Content-Type: application/octet-stream');

				  header('Content-Length: '.$filesize);

				  header('Content-Disposition: attachment; filename='.$filename);

				  header('Content-Transfer-Encoding: binary');

				  readfile($filename);*/

			  ?>

				<?php /*?><tr>

				  <td colspan="5" class="tdSpace"><span class="errorMsg">Total size of the backup = <?php echo $filesize;?> MB</span></td>

				</tr><?php */?>	

				<?php

			  }

			  ?>
			  <tr>
				  <td colspan="5">
					  <span class="formErrorMsg"></span>
				  </td>
			  </tr>
		  <?php

		  if(count($backupDetails) > 0)

		  {

		  ?>

			<tr>

			  <td><strong><?php echo $this->lang->line('backup_id_txt'); ?></strong></td>

			  <td><strong><?php echo $this->lang->line('backup_name_txt'); ?> </strong></td>

			  <td><strong><?php echo $this->lang->line('backup_size_txt'); ?> </strong></td>

			  <td><strong><?php echo $this->lang->line('backup_date_txt'); ?> </strong></td>
			  
			  <td><strong><?php echo $this->lang->line('backup_date_type'); ?> </strong></td>
			  
			  <td><strong><?php echo $this->lang->line('remote_server_txt'); ?> </strong></td>

			  <td align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

			</tr>

			<?php

		  $i = 1;

		  foreach($backupDetails as $keyVal=>$backupData)

		  {				

		  ?>

			<tr>

			  <td><?php echo $backupData['backupId'];?></td>

			  <td><?php echo $backupData['filename'];?></td>

			  <td><?php echo $backupData['filesize'];?></td>

			  <td><?php echo $this->time_manager->getUserTimeFromGMTTime($backupData['createdDate'], 'm-d-Y h:i A');?></td>
			  
			  <!--Manoj: Showing backup type-->
			  <td><?php 
				  $configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
				  $path = $configBackupDir;
				  if ($handle = opendir($path)) {
				  
					  while (false !== ($file = readdir($handle))) { 
						  if($file==$backupData['filename'])
						  {
							  $val=$this->lang->line('automatic_txt');
							  break;
						  }
						  else
						  {
							  $val=$this->lang->line('manual_txt');
						  }	
					  }
					  echo $val;
				  
					  closedir($handle); 
				  } ?></td>
				  <td>
				  <?php 
					  echo $backupData['remoteServer']['ftp_host'];
				  ?>
				  </td>
				  
				  <!--Manoj: code end-->

			  <td align="center">

				  <a href="<?php echo base_url();?>place_backup/downloadBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/download.gif" alt="<?php echo $this->lang->line('txt_Download');?>" title="<?php echo $this->lang->line('txt_Download');?>" border="0" style="cursor:pointer;"></a>

				  &nbsp;<a href="<?php echo base_url();?>place_backup/deleteBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" onClick="return confirmDelete()" border="0" style="cursor:pointer;"></a>

			  </td>

			</tr>

			<?php

			  $i++;					

		  }

	  }

	  ?>





		  </table>

			  <!-- Main Body -->

			  

			  </td>

			  </tr>

		  </table></td>

		</tr>

		

		

	  </table>

  </td>

</tr>

</table>
</div>
			</div> <!-- Container div end -->
					  


<?php //$this->load->view('common/footer');?>
<?php $this->load->view('common/foot.php');?>
</body>
</html>