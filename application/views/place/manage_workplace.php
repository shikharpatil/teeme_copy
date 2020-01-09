<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > View Spaces</title>
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



</head>

<body>


<div id="wrap1">
  <div id="header-wrap">

			<!-- header -->	

			<?php  
			//$this->load->view('common/header_place_panel');
			$this->load->view('common/header'); 
			?>

			<!-- header -->	

			

        

			<?php $this->load->view('common/wp_header'); ?>

			
			<?php 
			
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			
			?>
         

			<!-- Main menu -->

			<?php
			/*
			$workPlaceDetails = $this->identity_db_manager->getWorkPlaceDetails ($_SESSION['workPlaceId']);

			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId2( $_SESSION['workPlaceId'],1);

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
			// $this->load->view('common/artifact_tabs', $details); 
			// echo "here"; exit;
			
			
			 ?>
		
</div>
</div>		
			<!-- Main menu -->	

<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
<?php
			$workPlaceDetails = $this->identity_db_manager->getWorkPlaceDetails ($_SESSION['workPlaceId']);
			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId2( $_SESSION['workPlaceId'],1);
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
?>
					

                      	<div class="menu_new">

           

						  <ul class="tab_menu_new1">

                        	<li><a href="<?php echo base_url()?>manage_workplace" class="active"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
							
							<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<?php //if($_COOKIE['istablet']==0)
							if($deviceName!='tablet'){
							?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

							<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>language"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>

							<li><a href="<?php echo base_url()?>manage_workplace/configuration"  ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>

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

					

						<table width="99%" border="0" align="center">

                   

                    <tr>

                    	<td width="4%">&nbsp;</td>

                  		<td width="95%" align="left" valign="top" colspan="3"><b><?php echo $this->lang->line('txt_Workplace').': ';?></b><?php echo $workPlaceDetails['companyName'];?>
						<!--Manoj: Showing Place manager fullname-->
						&nbsp;<b><?php echo $this->lang->line('txt_Manager').': ';?></b><?php /*$tmp = explode('@',$_SESSION['workPlaceManagerName']);*/ echo $_SESSION['workPlaceManagerFullName'];?></td>

                    </tr>

                   

		  		<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

					

					<tr>

					    <td>&nbsp;</td>

						<td colspan="3" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></td>

					</tr>	

             

              <?php

				}

				

				?>
				<?php

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

					

					<tr>

					    <td>&nbsp;</td>

						<td colspan="3" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></td>

					</tr>	

             

              <?php

				}

				

				?>

		

		<?php

		if(count($workSpaces) > 0)

		{

		?>		

          <tr>

            <td width="4%">&nbsp;</td>

            <td width="36%" align="left"><strong><?php echo $this->lang->line('txt_Workspace_Name');?></strong></td>

            <?php /* Disabled by Parv - Place Manager column is disabled 

            <td width="22%"><strong><?php echo $this->lang->line('txt_Place_Manager');?> </strong></td>

			*/

			?>

            <td width="30%" align="left"><strong><?php echo $this->lang->line('txt_Created_Date');?> </strong></td>

          	<td width="30%" align="left"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

          </tr>

			<?php

			$i = 1;

			foreach($workSpaces as $keyVal=>$workSpaceData)

			{				

				if($workSpaceData['workSpaceManagerId'] == 0)

				{

					$workSpaceManager = $this->lang->line('txt_Not_assigned');

				}

				else

				{					

					$arrUserDetails = $this->identity_db_manager->getPlaceManagerDetailsByPlaceId($_SESSION['workPlaceId']);

					

					$workSpaceManager = $arrUserDetails['firstName'].' '.$arrUserDetails['lastName'];

				}

			?>		

			  <tr>

				<td>&nbsp;</td>

				<td align="left"><?php echo $workSpaceData['workSpaceName'];?></td>

                <?php /* Disabled by Parv - Place Manager column is disabled 

				<td><?php echo $workSpaceManager;?></td>

				*/

				?>

				<td align="left"><?php echo $this->time_manager->getUserTimeFromGMTTime($workSpaceData['workSpaceCreatedDate'],'m-d-Y h:i A');?></td>

			  <td align="left">

			<?php 

				

			if($workSpaceData['workSpaceManagerId'] == $_SESSION['userId'] || $_SESSION['WPManagerAccess'] == true)

			{

			?>

				<a href="<?php echo base_url();?>edit_workspace/place/<?php echo $workSpaceData['workSpaceId'];?>">

                <img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>" title="<?php echo $this->lang->line('txt_Edit');?>" border="0"></a>
				
				<?php

                if($workSpaceData['status'] == 0)

				{

				?>

			    	<a href="<?php echo base_url();?>edit_workspace/activate/<?php echo $workSpaceData['workSpaceId'];?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer; padding-left:8px;"></a>

				<?php

				}

				else

				{

				?>

                	<a href="<?php echo base_url();?>edit_workspace/suspend/<?php echo $workSpaceData['workSpaceId'];?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer; padding-left:8px;"></a>

                <?php

				}

				?>

                <a href="<?php echo base_url();?>delete_workspace/index/<?php echo $workSpaceData['workSpaceId'];?>" onclick="return confirmDeleteWorkSpace();">

               <!-- <img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0" style="cursor:pointer;"></a>-->

			<?php

			}

			?>	

			</td>

			  </tr>

		<?php

				$i++;					

			}

		}

		else

		{

		?>	

          <tr>

            <td colspan="4"><?php echo $this->lang->line('txt_None');?></td>          

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

			<!-- Footer -->	

				<?php //$this->load->view('common/footer');?>
				
				<?php $this->load->view('common/foot.php');?>

			<!-- Footer -->

		

   

</body>
</html>