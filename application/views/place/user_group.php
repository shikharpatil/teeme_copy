<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > User Group</title>

<!--Manage place js css file-->
<?php $this->load->view('common/view_head.php');?>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

</script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>

<script>

function showFilteredManagers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showManagers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

			<?php
			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	
			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'] && $workPlaceMemberData['userGroup']>0)

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
			var list = $("#groupUsersList").val();
			var val1 = list.split(",");
			
			$(".mngrs").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});


}

</script>

</head>

<body>
<div id="wrap1">
  <div id="header-wrap">
			<!-- header -->	

			<?php  $this->load->view('common/header'); 
			//$this->load->view('common/header_place_panel');
			?>

			<!-- header -->	



<?php $this->load->view('common/wp_header'); ?>

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

						<li><a href="<?php echo base_url()?>view_workplace_members" ><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

						<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>language" ><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>user_group" class="active"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
						
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

				<?php
				//}
				?>	
				
				

				<form name="frmWorkPlace" action="<?php echo base_url();?>user_group/add" method="post" onSubmit="return validateGroup(this)">

				<input value="" id="groupUsersList" type="hidden" name="groupUsersList" />

				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:1%;">
				
				
				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	
				
				<?php

				

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	
			  
			  	<?php if(!isset($_SESSION['workPlacePanel'])){ ?>

				<tr>
					<!--Step 1 of 2: -->
                    <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Create_User_Group');?></td>

		      	</tr>
				<?php } ?>		  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center" >

                     <tbody>
				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td colspan="3" class="tdSpace"><span class="errorMsg">Error: <?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>						                  

                       <tr>

                         <td width="15" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Group_Name');?><span class="text_red">*</span></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="485" align="left" class="text_gre">

                           <input name="userGroupName" class="text_gre1" id="userGroupName" size="30" value=""/>&nbsp;<span id="workPlaceStatusText"></span>

                         </td>

                       	</tr>
						<!--Manoj: comment remove start-->
							<tr>
	
							 <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Select_Users');?><span class="text_red">*</span></td>
	
							 <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
	
							 <td align="left" class="text_gre">
	
								<input type="text" id="showManagers" name="showManagers" onkeyup="showFilteredManagers()"/> 
	
							 </td>
	
							</tr>
						
                       <tr>

                       	<td align="right" valign="top" class="text_gre1">&nbsp;</td>

                        <td width="5" align="center" valign="middle" class="text_gre">&nbsp;</td>

                        <td align="left" class="text_gre">

						 <!--Manoj: comment remove start-->
						 			<input type="hidden" class="mngrs" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>"/> 
                    				<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" /> 
									<?php echo $currentUserDetails['tagName'];?><br />    
							<div id="showMan" style="height:120px; width:300px; overflow:scroll;">

            				<?php	

							//print_r ($workPlaceMembers);				

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

							{

								//if((in_array($workPlaceMemberData['userId'],$managerIds)))
								if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $workPlaceMemberData['userGroup']>0)

								{						

							?>

                    				<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								}

							}

							?>

    						</div>
							
                        </td>

                       </tr>
					   
					   
					   <tr>
				   			<td align="right" valign="top" class="text_gre1"></td>

                         	<td width="5" align="center" valign="middle" class="text_gre"></td>

                         	<td align="left" class="text_gre">
								<div>
									<?php /*?><input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>"><?php */?>
									<input name="submit" type="submit" id="submit" value="<?php echo $this->lang->line('txt_Done');?>">
									<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
								</div>
				  			</td>

			    		</tr>

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				<!--Comment for old button view-->
				

			  </table>		

		 			 </form>

			<div style="margin-top:3%">
				<?php $this->load->view('place/show_user_groups');?>
			</div>			 

				</div>

				<!--Added by Dashrath- load notification side bar-->
				<?php $this->load->view('common/notification_sidebar.php');?>
				<!--Dashrath- code end-->

			</div>	 
				<?php $this->load->view('common/foot.php');?>
			<!-- Footer -->	

				<?php //$this->load->view('common/footer');?>

			<!-- Footer -->

    

</body>
</html>
<script>
//On single checkbox click myspace start

$('.mngrs').live("click",function(){
		//alert('dfsd');
		val = $("#groupUsersList").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#groupUsersList").val()==''){

				$("#groupUsersList").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#groupUsersList").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#groupUsersList").val(arr);
			}

		}

	});
function validateGroup()
{	
	var err='';
	
	var groupName = $('#userGroupName').val();
	
	var groupUsers = $('#groupUsersList').val();
	
	var regGroupName = /^[^0-9][a-zA-Z0-9-_ ]+$/;
	
	if(groupName == '')

	{

		err += '<?php echo $this->lang->line('txt_enter_group_name'); ?> \n';	

	}
	
	if(groupName != '')

	{
		if (groupName.search(regGroupName) == -1)
		{
			err += '<?php echo $this->lang->line('txt_enter_valid_group_name'); ?> \n';	
		}
	}
	
	if(groupUsers == '')

	{

		err += '<?php echo $this->lang->line('txt_select_group_user'); ?> \n';	

	}
	
	if (err == '')
	{
		var msg= "<?php echo $this->lang->line('msg_group_create'); ?>";

		var agree = confirm(msg);
	
		if (agree)
	
		{
			return true;
		}
		else
		{
			return false ;
		}
	}
	else
	{
		jAlert (err,'Alert');
		return false;	
	}
}
function confirmDelete()
{	
	var msg= "<?php echo $this->lang->line('msg_group_delete'); ?>";

	var agree = confirm(msg);

	if (agree)

	{
		return true;
	}
	else
	{
		return false ;
	}
}

</script>