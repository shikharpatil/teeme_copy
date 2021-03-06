<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<title>Teeme > View Members</title>

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

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>

<script>

function confirmDeleteMember ()

{

	var msg = '<?php echo $this->lang->line('msg_member_deactivate');?>';

	if (confirm(msg) == 1)

	{

		return true;

	}

	else

	{

		return false;

	}

}

function confirmDeleteMember2 ()

{

	var msg = '<?php echo $this->lang->line('msg_member_delete');?>';

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


<!--Manoj: Load header_place_panel_for_mobile view-->
<?php $this->load->view('common/header_place_panel_for_mobile'); ?>



<?php $this->load->view('common/wp_header'); ?>

 

			<!-- Main menu -->

			<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

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

			if ($_SESSION['workPlacePanel'] != 1)

			{

				$this->load->view('common/artifact_tabs', $details);

			}

			 

			 ?>

			<!-- Main menu -->	

         

			<div id="container_for_mobile" style="padding:0px 0px 40px">



				<div id="content">

				<div class="menu_new" >

           

						 <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">

						<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

						<!--Manoj: Commented create space code-->
						<!--<li style="margin:0px!important;width:110px!important;"><a href="<?php //echo base_url()?>create_workspace"><span><?php //echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

						<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members" class="active"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<!--<li><a href="<?php //echo base_url()?>add_workplace_member/registrations"  ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

						<li style="margin:0px!important;width:50px!important;"><a href="<?php echo base_url()?>view_metering/metering"><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
						
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

			

			 <div style="width:90%">

			<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

           

              <!-- <td width="7%">&nbsp;</td>-->

			

           <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            

            <?php

				}
				
				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

           

              <!-- <td width="7%">&nbsp;</td>-->

			

           <span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span>

            

            <?php

				}

				

				?>

                        	<form name="frmSearch" action="<?php echo base_url()?>view_workplace_members" method="post" onsubmit="return checkValidMember(this);">

					<div class="flLt" style="margin-top:4px;margin-bottom:10px;">		

                            <input type="text" name="search1" value="<?php echo $this->input->post('search');?>" id="search" size="20"/>
							
					</div>

                    <div class="flLt" style="margin-left:5px">		        

				  		    <input type="submit" name="submit" value="<?php echo $this->lang->line('txt_Search');?>" style="padding:0px 5px;margin-top:6px;" class="buttonLogin"/>

                    </div>

                    <div class="clr"></div>

                            </form>

           </div>

            <div style="width:100%">

            <?php

		if(count($workPlaceMembers) > 0)

		{

		?>

        

           		

            

             <!-- <td width="7%">&nbsp;</td>-->

             <div class="flLt memberMobileView"> <strong><?php echo $this->lang->line('txt_Member');?></strong></div>

             <div class="flLt memberMobileView" style="margin-left:3%;" > <strong><?php echo $this->lang->line('txt_Tag_Name');?></strong></div>

              

            <!--  <td width="28%"><strong><?php echo $this->lang->line('txt_Added_Date');?></strong></td>-->

             <div class="flLt" style="margin-left:3%;"> <strong><?php echo $this->lang->line('txt_Action');?></strong></div>

            <div class="clr"></div>

            <?php

			$i = 1;

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

			{ 

				$this->load->model('dal/identity_db_manager');

				$objIdentity	= $this->identity_db_manager;			

				$userCommunityName = $this->identity_db_manager->getUserCommunityNameByCommunityId($workPlaceMemberData['userCommunityId']);						

			?>

           

              <!--<td>&nbsp;</td>-->

              <div class="flLt memberMobileView" style="margin-top:4%;"><?php echo $workPlaceMemberData['firstName'].' '.$workPlaceMemberData['lastName'];?></div>

       <div class="flLt memberMobileView" style="margin-left:3%; margin-top:4%;">  <?php echo ($workPlaceMemberData['tagName'])?$workPlaceMemberData['tagName']:"&nbsp;";?></div>

             

             <!-- <td><?php //echo $this->time_manager->getUserTimeFromGMTTime($workPlaceMemberData['registeredDate'], 'm-d-Y h:i A');?></td>-->

              <div class="flLt" style="margin-left:1%; margin-top:4%;">

              	<a href="<?php echo base_url();?>edit_workplace_member/index/<?php echo $workPlaceMemberData['userId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>"  title="<?php echo $this->lang->line('txt_Edit');?>" border="0"></a>

              	<?php

				if ($workPlaceMemberData['status']==0)

				{

				?>

              	&nbsp;<a href="<?php echo base_url();?>delete_workplace_member/index/<?php echo $workPlaceMemberData['userId'];?>/1" onClick="return confirmDeleteMember();"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0"></a>

            	<?php

				}

				else

				{

				?>

                &nbsp;<a href="<?php echo base_url();?>delete_workplace_member/index/<?php echo $workPlaceMemberData['userId'];?>/0"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0"></a>

                <?php

				}

				?> 
				<?php /*?><a href="<?php echo base_url();?>delete_workplace_member/deleteMember/<?php echo $workPlaceMemberData['userId'];?>" onClick="return confirmDeleteMember2();"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txtDelete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0"></a>	<?php */?>	
				
				</div>

                <div class="clr"></div>

           

            <?php

			  

				$i++;					

			}

		}

		else

		{

		?>

            <?php echo $this->lang->line('txt_None');?>

            

            <?php

		}

		?>

		</div> 

</div></div>			

		

				<?php $this->load->view('common/foot_for_mobile');?>
				<?php $this->load->view('common/footer_for_mobile');?>


			

  </body>

</html>

  <script type="text/javascript">

//$('#jsddm3').jcarousel();

/*$(document).ready(function() {

    $('#jsddm4').jcarousel();

	window.addEventListener("orientationchange", function() {

	//jQuery('#jsddm3').jcarousel({});

	});

});

*/

</script> 