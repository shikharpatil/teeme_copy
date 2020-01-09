<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<title>Teeme > View Spaces</title>

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





       

			<!-- header -->	
			<!--Manoj: Load header_place_panel_for_mobile view-->
			<?php  $this->load->view('common/header_place_panel_for_mobile'); ?>

			<!-- header -->	

			

        

			<?php $this->load->view('common/wp_header'); ?>

			

         

			<!-- Main menu -->

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

						

                        	<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace" class="active"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

							<!--Manoj: Commented create space code-->
                        	<!--<li style="margin:0px!important;width:110px!important;"><a href="<?php //echo base_url()?>create_workspace"><span><?php //echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<!--<li style="margin:0px!important;width:60px!important;"><a href="<?php //echo base_url()?>add_workplace_member/registrations"  ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

							<li style="margin:0px!important;width:50px!important;"><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
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

					

						<table width="99%" border="0" align="center">

                   

                    <tr>

                    	

                  		<td width="95%" align="left" valign="top" colspan="3"><b><?php echo $this->lang->line('txt_Workplace').': ';?></b><?php echo $workPlaceDetails['companyName'];?>

                        <br />

						<b><?php echo $this->lang->line('txt_Manager').': ';?></b><?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo $tmp[0];?></td>

                    </tr>

                   

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

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

					

					<tr>

					    <td colspan="4" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></td>

					</tr>	

             

              <?php

				}

				

				?>

		

		<?php

		if(count($workSpaces) > 0)

		{

		?>		

          <tr>

            

            <td width="56%" align="left"><strong><?php echo $this->lang->line('txt_Workspace_Name');?></strong></td>

            <?php /* Disabled by Parv - Place Manager column is disabled 

            <td width="22%"><strong><?php echo $this->lang->line('txt_Place_Manager');?> </strong></td>

			*/

			?>

           <!-- <td width="30%" align="left"><strong><?php //echo $this->lang->line('txt_Created_Date');?> </strong></td>-->

          	<td width="54%" align="right"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

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

				

				<td align="left"><div style="width:120px; overflow:hidden; text-overflow:ellipsis;"><?php echo $workSpaceData['workSpaceName'];?></div></td>

                <?php /* Disabled by Parv - Place Manager column is disabled 

				<td><?php echo $workSpaceManager;?></td>

				*/

				?>

				<!--<td align="left"><?php //echo $this->time_manager->getUserTimeFromGMTTime($workSpaceData['workSpaceCreatedDate'],'m-d-Y h:i A');?></td>-->

			  <td align="right">

			<?php 

				

			if($workSpaceData['workSpaceManagerId'] == $_SESSION['userId'] || $_SESSION['WPManagerAccess'] == true)

			{

			?>

				<a href="<?php echo base_url();?>edit_workspace/place/<?php echo $workSpaceData['workSpaceId'];?>">

                <img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>" title="<?php echo $this->lang->line('txt_Edit');?>" border="0" style="margin-right:0px;"></a>


				<?php

                if($workSpaceData['status'] == 0)

				{

				?>

			    	<a href="<?php echo base_url();?>edit_workspace/activate/<?php echo $workSpaceData['workSpaceId'];?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer;margin-left:10px;"></a>

				<?php

				}

				else

				{

				?>

                	<a href="<?php echo base_url();?>edit_workspace/suspend/<?php echo $workSpaceData['workSpaceId'];?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer;margin-left:10px;"></a>

                <?php

				}

				?>
				
              <?php /*?>  <a href="<?php echo base_url();?>delete_workspace/index/<?php echo $workSpaceData['workSpaceId'];?>" onclick="return confirmDeleteWorkSpace();">

                <img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0" style="cursor:pointer;"></a><?php */?>

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

		  </div>

			<!-- Footer -->	
				<?php $this->load->view('common/foot_for_mobile');?>
				<?php $this->load->view('common/footer_for_mobile');?>

			<!-- Footer -->

		

   

</body>

</html>

  <script type="text/javascript">

/*//$('#jsddm3').jcarousel();

$(document).ready(function() {

    $('#jsddm4').jcarousel();

	window.addEventListener("orientationchange", function() {

	//jQuery('#jsddm3').jcarousel({});

	});

});

*/

</script> 