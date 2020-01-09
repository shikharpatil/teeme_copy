<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<title>Teeme</title>

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

	<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>



	<script language="JavaScript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	

	<script language="JavaScript1.2">

mmLoadMenus();

function showFilteredManagers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showManagers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php



			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMan').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

}

function showFilteredMembers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showMembers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>
			//Manoj: replace mysql_escape_str function
			var str = '<?php echo $this->db->escape_str($workPlaceMemberData['tagName']); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

}

</script>

</head>

<body>



	



			<?php $this->load->view('common/header_for_mobile'); ?>

			

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

			

			<div id="container_for_mobile" style="padding:0px 0px 40px">



		<div id="content">

		  

					<form name="frmWorkPlace" action="<?php echo base_url();?>create_workspace/add" method="post" onSubmit="return validateWorkSpace(this)">

					

				

							<div class="menu_new" >

           

						   <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">

							<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

							<li style="margin:0px!important;width:110px!important;"><a href="<?php echo base_url()?>create_workspace" class="active"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>

							<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

							<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<!--<li><a href="<?php //echo base_url()?>add_workplace_member/registrations" ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

							<li style="margin:0px!important;width:50px!important;"><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>

                        	<li style="margin:0px!important;width:45px!important;"><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li>

                        </ul>

					<div class="clr"></div>

					</div>

				

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td colspan="3" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	

				  

				<tr>

                    <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Workspace_Details');?></td>

		      	</tr>

				  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center" >

                     <tbody>                    

                       <tr>

                         <td width="20%" align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Workspace_Name');?><span class="text_red">*</span></td>

                         <td width="2%" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td width="75%" align="left" class="text_gre">

                           <input name="workSpaceName" class="text_gre1" id="workSpaceName" size="26" value=""/>&nbsp;<span id="workPlaceStatusText"></span>

                         </td>

                       	</tr>

                       <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Workspace_Managers');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre" valign="top">

                         	<input type="text" id="showManagers" name="showManagers" onkeyup="showFilteredManagers()" size="26" /> 

                         </td>

                       </tr>

					   

                       <tr>

                       	<td align="right" valign="top" class="text_gre1">&nbsp;</td>

                        <td width="5" align="center" valign="top" class="text_gre">&nbsp;</td>

                        <td align="left" class="text_gre">

                        

                        <div id="showMan" style="height:120px; width:300px; overflow:scroll;">

	           				<?php			

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

							{

												

							?>

                    				<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								

							}

							?>

    					</div> 

                        </td>

                       </tr>

                        <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_tree_access');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="radio" name="treeAccess" value="0"  checked="checked" /><?php echo $this->lang->line('txt_Space_Managers');?><br />

							<input type="radio" name="treeAccess" value="1" /><?php echo $this->lang->line('txt_All_Members');?>

							

                         </td>

                       </tr>

                       

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				 <tr>

				   <td class="subHeading" colspan="3">&nbsp;</td>

		      </tr>

				 <tr>

				   <td class="subHeading" colspan="3">

					<span id="otherCommunity" style="display:none;">

					<table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                     <tbody>                    

                       <tr>

                         <td width="31%" align="left" valign="top" class="text_gre1">Please enter <span id="otherCommunityName">yahoo</span> user name</td>

                         <td width="2%" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td width="67%" align="left" class="text_gre">

                           <input type="text" name="otherUserName" class="text_gre1" id="otherUserName" size="30" value="" onKeyUp="checkUserName(this)"/><span id="userNameStatus1"></span>

                         </td>

                       </tr>

                      

					</tbody>

					</table>	</span>				</td>

		      </tr>

			    <tr><td>&nbsp;</td>

				  <td><input name="submit" type="submit" id="submit" value="<?php echo $this->lang->line('txt_Add');?>" class="button01"></td>

			    </tr>

			  </table>		

		 			 </form>

					 

				</div></div>	 

			<!-- Footer -->	

				<?php $this->load->view('common/footer');?>

			<!-- Footer -->

    

</body>

</html>

