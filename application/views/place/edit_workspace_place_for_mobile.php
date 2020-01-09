<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Edit Space</title>

<!--Manage place js css file-->
<?php $this->load->view('common/view_head.php');?>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />


					<?php

					$memberIds = array();

					foreach($workSpaceMembers as $membersData)

					{

						$memberIds[] = $membersData['userId'];

					}

					$managerIds = array();

					foreach($workSpaceManagers as $managersData)

					{

						$managerIds[] = $managersData['managerId'];

					}
					
					//space tree config ids
					$treeTypeConfigIds = array();

					foreach($spaceTreeDetails as $spaceTreeData)

					{

						$treeTypeConfigIds[] = $spaceTreeData['tree_type_id'];

					}

					?>
					
<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>					


<script>

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';


function showFilteredManagers()
{
	var toMatch = document.getElementById('showManagers').value;

	var val = '';

		if (1)

		{
			
			<?php

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	
			{
				
				if ((in_array($workPlaceMemberData['userId'],$managerIds)) && ($workPlaceMemberData['userGroup']>0))
				{

			?>
			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';
				
				if (toMatch!='')
				{
					var pattern = new RegExp('\^'+toMatch, 'gi');
		
					if (str.match(pattern))
					{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;
						<?php
							}
						}
						else
						{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;

						<?php
						}
						?>
		
					}
				}
				else
				{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;	
						<?php
							}
						}
						else
						{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;	

						<?php
						}
						?>
				}

			<?php

				}

        	}
			
			?>
			document.getElementById('showMan').innerHTML = val;
			<?php

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if (!(in_array($workPlaceMemberData['userId'],$managerIds)) && ($workPlaceMemberData['userGroup']>0))

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';
			
				if (toMatch!='')
				{
					var pattern = new RegExp('\^'+toMatch, 'gi');
		
					if (str.match(pattern))		
					{
		
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;
						<?php
							}
						}
						else
						{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;

						<?php
						}
						?>
		
					}	
				}
				else
				{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;
						<?php
							}
						}
						else
						{
						?>
								val +=  '<input class="mngrs" type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMan').innerHTML = val;

						<?php
						}
						?>
				}

			<?php

				}

        	}
			
			?>
			document.getElementById('showMan').innerHTML = val;
			<?php

        	?>
			var list = $("#managerslist").val();
			var val1 = list.split(",");
			
			$(".mngrs").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});
		}
}

function showFilteredMembers()
{
	var toMatch = document.getElementById('showMembers').value;
	
	var val = '';

		if (1)
		{
			<?php

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ((in_array($workPlaceMemberData['userId'],$memberIds)) || (in_array($workPlaceMemberData['userId'],$managerIds)))

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';
				if (toMatch!='')
				{
					var pattern = new RegExp('\^'+toMatch, 'gi');
		
					if (str.match(pattern))
		
					{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;
						<?php
							}
						}
						else
						{
						?>	
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;
						<?php
						}
						?>	
					}	
				}
				else
				{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>				
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;	
						<?php
							}
						}
						else
						{
						?>	
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;		
						<?php
						}
						?>								
				}


			<?php

				}

        	}
			?>
			document.getElementById('showMem').innerHTML = val;
			<?php
			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if (!(in_array($workPlaceMemberData['userId'],$memberIds)) && !(in_array($workPlaceMemberData['userId'],$managerIds)))

				{

			?>
//Manoj: replace mysql_escape_str function
			var str = '<?php echo $this->db->escape_str($workPlaceMemberData['tagName']); ?>';
			
				if (toMatch!='')
				{
					var pattern = new RegExp('\^'+toMatch, 'gi');
		
					if (str.match(pattern))
		
					{
		
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;
						<?php
							}
						}
						else
						{
						?>	
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;
						<?php
						}
						?>	
		
					}
				}
				else
				{
						<?php
						if ($workSpaceDetails['workSpaceName']=='Place Managers')
						{
							if ($workPlaceMemberData['isPlaceManager']==1)
							{
						?>				
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;	
						<?php
							}
						}
						else
						{
						?>	
								val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?>/><?php echo $workPlaceMemberData['tagName'];?><br>';
				
								//document.getElementById('showMem').innerHTML = val;		
						<?php
						}
						?>	
				}

			<?php

				}

        	}
			?>
			document.getElementById('showMem').innerHTML = val;
			<?php

        	?>
			var list = $("#memberslist").val();
			var val1 = list.split(",");
			
			$(".members").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});
		}
}

</script>
</head>
<body>

<?php  //$this->load->view('common/header'); 
			$this->load->view('common/header_place_panel_for_mobile');
			?>

<?php $this->load->view('common/wp_header'); ?>

<!-- Main menu -->

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

			if ($_SESSION['workPlacePanel'] != 1)

			{

				//$this->load->view('common/artifact_tabs', $details);

			}
			?>



<div id="container_for_mobile" style="padding:0px 0px 40px" >
		<div id="content">

			<!-- Main menu -->	

					<!-- Main Body -->
					
					<?php
				
					if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
					{	
						if($subWorkSpaceId > 0)
						{
							$tmpWorkSpaceId = $subWorkSpaceId;
							$tmpWorkSpaceType = 2;
						}
						else if($workSpaceType == 2)
						{
							$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 2;
						}
						else
						{
							$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 1;
						}

						if($tmpWorkSpaceId > 0)
						{
							if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
							{
								
								$_SESSION['WSManagerAccess'] = 1;
							}
							else
							{		
								$_SESSION['WSManagerAccess'] = 0;
							}
						}
						else
						{
							$_SESSION['WSManagerAccess'] = 0;
						}
						//echo $_SESSION['WSManagerAccess'].'===='.$_SESSION['workPlacePanel']; 
					
					}
					?>			
					
				<?php 
			
				$spaceManagersList = implode(",",$managerIds); 
				
				$spaceMembersList = implode(",",$memberIds); 
				
				$treeTypeConfigLists = implode(",",array_filter($treeTypeConfigIds));
				
				?>			
					
				<form name="frmWorkPlace" action="<?php echo base_url();?>edit_workspace/update" method="post"  onSubmit="return validateWorkSpace(this)">
				
				<input value="<?php echo $spaceManagersList ?>" id="managerslist" type="hidden" name="managerslist" />
			
				<input value="<?php echo $spaceMembersList ?>" id="memberslist" type="hidden" name="memberslist" />	
				
				<input value="<?php echo $treeTypeConfigLists; ?>" id="treeTypeList" type="hidden" name="treeTypeList" />	

				<div class="menu_new" >

           

						<ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">

						<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace" ><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
						
						<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>edit_workspace/place/<?php echo $workSpaceId; ?>" class="active"><span><?php echo $this->lang->line('txt_Edit_Workspace');?></span></a></li>

						<?php /*?><li style="margin:0px!important;width:110px!important;"><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li><?php */?>

						<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<!--<li><a href="<?php //echo base_url()?>add_workplace_member/registrations" ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

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

				<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

					

					  <div><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div>

				<?php

				}

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

					

					  <div><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></div>

				<?php

				}

				?>	

				  

				  <table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

                    <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Workspace_Details');?></td>

		      </tr>

				  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                     <tbody>                    

                       <tr>

                         <td width="205" align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Workspace_Name');?><span class="text_red">*</span> </td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="70%" align="left" class="text_gre">

                           <input name="workSpaceName" class="text_gre1" id="workSpaceName" value="<?php echo $workSpaceDetails['workSpaceName'];?>" //>&nbsp;<span id="workPlaceStatusText"></span>

                         </td>

                       </tr>

                       <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Workspace_Managers');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="text" id="showManagers" name="showManagers" onkeyup="showFilteredManagers()"/> 

                         </td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle" class="text_gre1">&nbsp;</td>

                         <td width="5" align="center" valign="middle" class="text_gre">&nbsp;</td>

                         <td align="left" class="text_gre">

                        

                        	<div id="showMan" style="height:120px; width:300px; overflow:scroll;">

            				<?php	


							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)
							{

								if((in_array($workPlaceMemberData['userId'],$managerIds)) && ($workPlaceMemberData['userGroup']>0))
								{						
									if ($workSpaceDetails['workSpaceName']=='Place Managers')
									{
										if ($workPlaceMemberData['isPlaceManager']==1)
										{
										?>
											<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />
										<?php
										}
									}
									else
									{
							?>

										<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 
	
										<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php
									}

								}

							}

							

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

							{

								if(!(in_array($workPlaceMemberData['userId'],$managerIds)) && ($workPlaceMemberData['userGroup']>0))

								{						
									if ($workSpaceDetails['workSpaceName']=='Place Managers')
									{
										if ($workPlaceMemberData['isPlaceManager']==1)
										{
										?>
											<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />
										<?php
										}
									}
									else
									{
							?>

										<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 
	
										<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php
									}

								}

							}

							?>

    						</div>

                        

                         </td>

                       </tr>

                       <tr>
					   <td>
  						<table style="display:none;">
                       <?php

						if(!isset($_SESSION['workPlacePanel']))

						{

						?>

                     
 
                       <tr>
						<!--Manoj: Make align right-->
                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Add_Workspace_Members');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/> 

                         </td>

                       </tr>

                      <tr>

                         <td align="left" valign="middle" class="text_gre1">&nbsp;</td>

                         <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                         <td align="left" class="text_gre">

                        	<div id="showMem" style="height:120px; width:300px; overflow:scroll;">

            				<?php	

											

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)
							{
								if((in_array($workPlaceMemberData['userId'],$memberIds)) || (in_array($workPlaceMemberData['userId'],$managerIds)))
								{						
									if ($workSpaceDetails['workSpaceName']=='Place Managers')
									{
										if ($workPlaceMemberData['isPlaceManager']==1)
										{
										?>							

											<input type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?> /> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />
									<?php
										}
									}
									else
									{
							?>
											<input type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?> /> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php
									}

								}

							}

							

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)
							{

								if(!(in_array($workPlaceMemberData['userId'],$memberIds)) && !(in_array($workPlaceMemberData['userId'],$managerIds)))
								{						
									if ($workSpaceDetails['workSpaceName']=='Place Managers')
									{
										if ($workPlaceMemberData['isPlaceManager']==1)
										{
										?>							

											<input type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?> /> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />
									<?php
										}
									}
									else
									{
							?>
											<input type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds) || in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?> <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'disabled="disabled"'; }?> /> 
		
											<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php
									}

								}

							}

							?>

    						</div> 

                         </td>

                       </tr>

                       <?php

					   }

					   else

					   {?>

					   		<input type="hidden" name="workSpaceMembers" value="none"  /> 

					   <?php }

					   ?>

					   <?php

						//if(isset($_SESSION['workPlacePanel']))

						//{

						?>

					    <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_tree_access');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="radio" name="treeAccess" value="0"  <?php  if($workSpaceDetails['treeAccess']==0 ) echo 'checked="checked"'; ?>   /><?php echo $this->lang->line('txt_Space_Managers');?>

							<input type="radio" name="treeAccess" value="1" <?php  if($workSpaceDetails['treeAccess']==1 ) echo 'checked="checked"'; ?>  /><?php echo $this->lang->line('txt_All_Members');?>

							

                         </td>

                       </tr>
					   
					  

					   <?php // } ?>
					   
					   </table>
					   </td>
					   </tr>
					   
					   <!--Space tree configuration start-->
						
						 <tr style="margin-top:1%; display:none;">

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Workspace_Tree_Type');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">
							<div style="width:410px;">
								<?php /*?><div><input type="checkbox" name="checkAllTreeTypes" id="checkAllTreeTypes" onclick="checkAllTreeTypes();"><?php echo $this->lang->line('txt_All');?></div><?php */?>
								<?php 
														
								foreach($spaceTreeDetails as $keyVal=>$spaceTreeTypeIds)
								{
									$treeTypeIds[] = $spaceTreeTypeIds['tree_type_id'];
								}
								//print_r($treeTypeIds);
								?>
									<div <?php if(!(in_array('1',$treeTypeIds))) { ?> style="display:none;" <?php } ?>  ><input <?php if(in_array('1',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="1" /><?php echo $this->lang->line('txt_Document');?></div>
									<div <?php if(!(in_array('3',$treeTypeIds))) { ?> style="display:none;" <?php } ?> ><input <?php if(in_array('3',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="3" /><?php echo $this->lang->line('txt_Discuss');?></div>
									<div <?php if(!(in_array('4',$treeTypeIds))) { ?> style="display:none;" <?php } ?> ><input <?php if(in_array('4',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="4" /><?php echo $this->lang->line('txt_Task');?></div>
									<div <?php if(!(in_array('6',$treeTypeIds))) { ?> style="display:none;" <?php } ?> ><input <?php if(in_array('6',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="6" /><?php echo $this->lang->line('txt_Notes');?></div>
									<div <?php if(!(in_array('5',$treeTypeIds))) { ?> style="display:none;" <?php } ?> ><input <?php if(in_array('5',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="5" /><?php echo $this->lang->line('txt_Contact');?> </div>
									
									<div <?php if(!(in_array('1',$treeTypeIds))) { ?> style="display:block; " <?php } else { ?> style="display:none;" <?php } ?> ><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="1" /><?php echo $this->lang->line('txt_Document');?> </div>
									<div <?php if(!(in_array('3',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="3" /><?php echo $this->lang->line('txt_Discuss');?> </div>
									<div <?php if(!(in_array('4',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="4" /><?php echo $this->lang->line('txt_Task');?> </div>
									<div <?php if(!(in_array('6',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="6" /><?php echo $this->lang->line('txt_Notes');?></div>
									<div <?php if(!(in_array('5',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="5" /><?php echo $this->lang->line('txt_Contact');?> </div>
							</div>
                         </td>

                       </tr>
					   <!--Space tree configuration end-->

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				 <tr>

				   <td class="subHeading" colspan="3">&nbsp;</td>

		      </tr>

				 

			    <tr>
				<td width="30"></td>

				  <td>
				  
				  <input name="Submit" type="submit" id="Submit" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"> 
				  
				 <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
				  
				  </td>
				  
				  

			    </tr>

			  </table>		

			<input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceId;?>">
			
			<input type="hidden" name="placePanel" id="placePanel" value="1">


	    </form>

				
</div>

</div>

<?php $this->load->view('common/footer_for_mobile');?>
<?php $this->load->view('common/foot_for_mobile');?>

</body>

</html>		

<script>
//On single checkbox click myspace start

//$('.mngrs').live("click",function()
$(document).on('click', '.mngrs', function(){
		//alert('dfsd');
		val = $("#managerslist").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#managerslist").val()==''){

				$("#managerslist").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#managerslist").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#managerslist").val(arr);
			}

		}

	});
	
//$('.members').live("click",function()
$(document).on('click', '.members', function(){
		//alert('dfsd');
		val = $("#memberslist").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#memberslist").val()==''){

				$("#memberslist").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#memberslist").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#memberslist").val(arr);
			}

		}

	});	
</script>