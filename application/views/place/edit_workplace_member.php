<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Edit Member</title>

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

	<script type="text/javascript" src="<?php echo base_url();?>js/validation.js"></script>		

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>
	 
<script>

function changeUserRole(thisVal)
{
	//alert(thisVal.value);
	var userRole = thisVal.value;
    if(userRole == "0")
	{           
		//$('#isPlaceManager1').attr('disabled','disabled');  
		//$('#isPlaceManager0').attr('disabled','disabled');
		     
    }
	else
	{
        //$('#isPlaceManager1').removeAttr('disabled');  
		//$('#isPlaceManager0').removeAttr('disabled');
    }  
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



        <?php /*?><table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0"><?php */?>

			<!-- Main menu -->

			<?php
			/*
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

			//	$this->load->view('common/artifact_tabs', $details);

			}
			*/
			 

			?>
</div>
</div>
			<!-- Main menu -->	
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
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
			?>
						<div class="menu_new" >

           

						  <ul class="tab_menu_new1">

					<li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
					
					<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

					<li><a href="<?php echo base_url()?>view_workplace_members" class="active"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

					<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

					<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

						<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>				
						
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

				</ul>

					<div class="clr"></div>

					</div>		

				  

				    <table style="margin:0 auto;" width="85%<?php //echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td colspan="2" align="left" valign="top">

					<!-- Main Body -->

			<form action="<?php echo base_url();?>edit_workplace_member/update" method="post" enctype="multipart/form-data" name="frmWorkPlace" id="frmWorkPlace" onSubmit="return validateWorkPlaceMemberEditPlace(this)">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

    						<td colspan="3" align="left"><strong><?php echo $this->lang->line('txt_Edit_Profile');?></strong></td>

  						</tr>
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

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span> </td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" onclick="$(this).blur();" readonly="readonly" onfocus="$(this).blur();" />

&nbsp;<span id="userNameStatusText"></span></td>

                        </tr>

                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Password');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="30" /></td>

                        </tr>

                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Retype_Password');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" /></td>

                        </tr>

                        <tr>

                          <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" valign="top" class="text_gre1">

                            <input name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" onclick="return false;" />

                            <input type="hidden" name="userTitle" id="userTitle" value="" />

                          </td>

                        </tr>

                        <tr>

                          <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly" onclick="return false;" />

                          </td>

                        </tr>
						
						<!--Nickname field start-->
						<tr>
						
						  <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_nick_name');?></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="nickName" class="text_gre1" id="nickName" size="30"  value="<?php echo $Profiledetail['editNickName'];?>" />

                          </td>

                        </tr>
						<!--Nickname field end-->

						<tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['editUserTagName'];?>" onclick="return false;" readonly /></td>

                        </tr>

                        
						<!--User time zone view start here-->
						
						  <tr>

                          <td valign="left"  valign="top" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

							<select name="timezone" id="timezone">
							
								<option <?php if( $timezone == '0' ||  $timezone == 'NULL') { echo 'selected'; }?> value='0' selected><?php echo $this->lang->line('select_time_zone_txt'); ?></option>
								<?php
								foreach($timezoneDetails as $timezoneData)
								{
								?>
								<option <?php if( $timezone == $timezoneData['timezoneid'] ) { echo 'selected'; }?> value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
								<?php	
								}
								?>
								
							</select>

                          

                          </td>

                        </tr>
						
						<!--User time zone view end here-->
                        

                        <tr>

                          <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Photo');?></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" valign="top" class="text_gre1">

                            <input type="file" name="photo" class="text_gre1" id="photo" size="30" value="" /> (jpg, jpeg, png, gif only)

                          </td>

                        </tr>



                        <tr>

                          <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Role');?></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="role" class="text_gre1" id="role" size="30"  value="<?php echo stripslashes($Profiledetail['role']);?>"/>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Department');?></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="department" class="text_gre1" id="department" size="30"  value="<?php echo stripslashes($Profiledetail['department']);?>"/>

                          </td>

                        </tr>
						
                        <tr style="display:none;">

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_skills');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="skills" rows="3" id="skills" style="width:50%;"><?php echo stripslashes($Profiledetail['skills']);?></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Status');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="status" rows="3" id="status" style="width:50%;"><?php echo stripslashes($Profiledetail['statusUpdate']);?></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="address1" rows="3" id="address1" style="width:50%;"><?php echo stripslashes($Profiledetail['address1']);?></textarea></td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          <td align="center" valign="top" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left" class="text_gre1">

                            <input name="phone" class="text_gre1" id="phone" size="30" value="<?php echo $Profiledetail['phone'];?>"/></td>

                        </tr>

                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>

                          <td align="center" valign="top"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left">

                            <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $Profiledetail['mobile'];?>"/></td>

                        </tr>                     

                        <tr style="display:none;">

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="otherMember" rows="3" id="otherMember" style="width:50%;"><?php echo stripslashes($Profiledetail['other']);?></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_as');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                                <select name="userGroup" id="userGroup" onchange="changeUserRole(this)">



                      				<option value="1" <?php if( $Profiledetail['userGroup'] == 1 ) { echo 'selected'; }?>><?php echo $this->lang->line('txt_Employee');?></option>

                                    <option value="0" <?php if( $Profiledetail['userGroup'] == 0 ) { echo 'selected'; }?>><?php echo $this->lang->line('txt_Guest');?></option>



                    			</select>

                          </td>

                        </tr>
						
						 <?php /*?><tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('assign_space_txt'); ?> 'Try Teeme'</td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="radio" name="createDefaultSpace" id="createDefaultSpace1" value="1" checked="checked" />Yes<input type="radio" name="createDefaultSpace" id="createDefaultSpace0" <?php if($this->input->post('createDefaultSpace') && $this->input->post('createDefaultSpace')=='0'){?> checked="checked"<?php }?> value="0" />No</td>

                        </tr> <?php */?>
                          
                        <tr>

                          <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_as_place_manager');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
                              
                              <input type="radio" name="isPlaceManager" id="isPlaceManager1" value="1" <?php if( $Profiledetail['isPlaceManager'] == 1 ) { echo 'checked'; }?> >Yes</input>
                              <input type="radio" name="isPlaceManager" id="isPlaceManager0" value="0" <?php if( $Profiledetail['isPlaceManager'] != 1 ) { echo 'checked'; }?> >No</input>

                          </td>

                        </tr>

                       <?php /*?> <tr>

                          <td align="left" valign="top" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="top" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">&nbsp;</td>

                        </tr>

                        



                        

                        <tr>

                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                        </tr><?php */?>

                      </tbody>

                    </table>

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse; margin-bottom:2%;">

                      <tbody>

                        <tr>

                          <td width="179" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                          <td width="5" align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td width="512" align="left" class="text_gre">

                            <input type="hidden" name="email" class="hidden" id="email" size="30" value="<?php echo $Profiledetail['userName'];?>"/>

                            <input type="hidden" name="userId" class="hidden" id="userId" size="30" value="<?php echo $Profiledetail['userId'];?>"/>

                            <input type="hidden" name="workSpaceId" class="hidden" id="workSpaceId" size="30" value="<?php echo $workSpaceId;?>"/>

                            <input type="hidden" name="workSpaceType" class="hidden" id="workSpaceType" size="30" value="<?php echo $workSpaceType;?>"/>

                            <input type="hidden" name="userPassword" class="hidden" id="userPassword" size="30" value="<?php echo $Profiledetail['password'];?>"/>

                            

                            <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Update');?>" class="button01"/>

                          </td>

                        </tr>

                      </tbody>

                  </table>

            </form>

				

				</td>

                </tr>

            </table>

         

       </div>

        <!--Added by Dashrath- load notification side bar-->
		<?php $this->load->view('common/notification_sidebar.php');?>
		<!--Dashrath- code end-->

   </div>

   <?php $this->load->view('common/foot.php');
   //$this->load->view('common/footer');?>

</body>
</html>