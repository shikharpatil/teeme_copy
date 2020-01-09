<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Stats</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lib/skins/tango/skin.css" />

    <script type="text/javascript" src="<?php echo base_url();?>js/lib/jquery.jcarousel.min.js"></script>

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




<!--Manoj: Load header_place_panel_for_mobile view-->
<?php $this->load->view('common/header_place_panel_for_mobile'); ?>



<?php $this->load->view('common/wp_header'); ?>

       

          

        

     

			<?php

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

			 //$this->load->view('common/artifact_tabs', $details); ?>

			<!-- Main menu -->	

					

					

			<div id="container_for_mobile" style="padding:0px 0px 40px">



				<div id="content">		

				

                      	<div class="menu_new" >

           

						  <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">

                        	<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace" ><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

							<!--Manoj: Commented create space code-->
                        	<!--<li style="margin:0px!important;width:110px!important;"><a href="<?php //echo base_url()?>create_workspace"><span><?php //echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<!--<li><a href="<?php //echo base_url()?>add_workplace_member/registrations"  ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

							<li style="margin:0px!important;width:73px!important;"><a href="<?php echo base_url()?>view_metering/metering"  class="active"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>language"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
							
							<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
							<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>manage_workplace/configuration" ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>

                        	<?php /*?><li style="margin:0px!important;width:45px!important;"><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
							
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=place" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon_mob">
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

						<td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></td>

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

           <?php /*?> <td width="25%"><strong><?php echo $this->lang->line('txt_Month');?></strong></td>

            <td width="25%" align="left"><strong><?php echo $this->lang->line('txt_Data_Base_Size');?></strong></td>

            <td width="25%" align="left"><strong><?php echo $this->lang->line('txt_Total_Imported_File_Size');?> </strong></td>

          	<td width="25%" align="left"><strong><?php echo $this->lang->line('txt_Total_members');?></strong></td><?php */?>
			
			<td width="33%" align="left"><strong><?php echo $this->lang->line('total_db_size_txt'); ?></strong></td>

            <td width="33%" align="left"><strong><?php echo $this->lang->line('total_imported_file_size_txt'); ?></strong></td>

          	<td width="33%" align="left"><strong><?php echo $this->lang->line('total_members_txt'); ?></strong></td>


          </tr>

			<?php

			/*$i=1;

			foreach($db_details as $keyVal=>$data)

			{

			

			   $totalDbSize=$totalDbSize+	$data['dbSize'];

			   $totalMembers=$totalMembers+	$data['membersCount'];

			   $totalImportedFileSize=	$totalImportedFileSize+$data['importedFileSize'];		*/

				

			?>		

			  <tr class="<?php echo ($i%2==0)?"row2":"row1 ";?>">

			<?php /*?>	<td><?php echo $data['month'];?></td>

				<td align="left"><?php echo $data['dbSize'];?></td>

				<td align="left"><?php echo $data['importedFileSize'];?></td>

			  	<td align="left"><?php echo $data['membersCount'];?></td>
<?php */?>

				<td align="left"><?php echo $db_details['dbSize'];?></td>

				<td align="left"><?php echo $db_details['importedFileSize'];?></td>

			  	<td align="left"><?php echo $db_details['membersCount'];?></td>
				
				
			  </tr>

		<?php

			/*	$i++;				

			}*/

			

			?>		

			  <?php /*?><tr>

				<td align="left"><strong><?php echo $this->lang->line('txt_Total');?></strong></td>

				<td align="left"><strong><?php echo $totalDbSize;?></strong></td>

				<td align="left"><strong><?php  echo  $totalImportedFileSize ;?></strong></td>

			  	<td align="left"><strong><?php  echo  $totalMembers ;?></strong></td>

			  </tr><?php */?>

		<?php

			

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

        <?php /*?><tr>

            <td colspan="4"><strong> * - Size in MB</strong></td></tr>
<?php */?>
        </table>

				

        

         

				

	</div>

</div>		

       

<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>

