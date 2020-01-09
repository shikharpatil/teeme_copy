<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Preferences</title>
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';		
	</script>
	
<script>

function profileEdit(){

	$('#frmWorkPlace').submit();

}

</script>



<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<?php $this->load->view('common/scroll_to_top'); ?>
<?php
$placeName =  $this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);
if(isset($_POST['submit'])){?>

<script>

window.top.location='<?php echo base_url().'dashboard/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';?>';

</script>

<?php

}?>

</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <!--Commented by Dashrath- for new ui-->
    <?php //$this->load->view('common/artifact_tabs'); ?>
  </div>
</div>
<div id="container">
	<!--Added by Dashrath- Add left menu bar-->
	<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>

  <!--Changed by Dashrath- Changed div id content to rightSideBar-->
  <div id="rightSideBar">
	
<div>

    <ul class="tab_menu_new">
	
	
		<?php //echo $profileForm.'==='.$passwordForm; ?>
		<?php //echo $_SESSION['successMsg']; ?>
		<!--Notification tab start here-->
		
			<li>

            <a href="javascript:void(0);" style="padding-left:12px;margin-left:2px;" id="notification" title="notification" class="<?php if($profileForm!='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#notification').addClass('active');$('#profile').removeClass('active');$('#passwordForm').removeClass('active');$('#profileForm').hide();$('#password_form').hide();$('#notificationSection').show(); clearSessionMsg();"><?php echo $this->lang->line('preference_txt'); ?></a>

        	</li>
		
		<!--Notification tab end here-->

        <li>

            <a href="javascript:void(0);" id="profile" style="padding-left:12px;margin-left:17px;" title="profile" class="<?php if($profileForm=='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#profile').addClass('active');$('#passwordForm').removeClass('active');$('#notification').removeClass('active');$('#password_form').hide();$('#notificationSection').hide();$('#profileForm').show(); clearSessionMsg();"><?php echo $this->lang->line('profile_txt'); ?></a>

        </li>
		<!--profile tab end here-->
		 <li>

            <a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a>

        </li>
		<!--Password tab end here-->
        <?php /*?><li>

            <a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="preferences" title="preferences" class="" onclick="$('#preferences').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#editorChoice').show();"><?php echo $this->lang->line('preferences_txt'); ?></a>

        </li><?php */?>
		
		

    </ul>

    <div id="content">

    <div id="profileForm" style=" <?php if($profileForm=='1' && $passwordForm!='1'){ ?> display:block; <?php }else{ ?> display:none; <?php } ?> ">

	<?php if($profileForm=='1' && $passwordForm!='1'){?>
	
	<div style="padding-top:1%;width:100%;color:red;" class="errorHeadMsg"><?php echo $_SESSION['errorHeadMsg'];unset($_SESSION['errorHeadMsg']);?></div>
	
    <?php /*?><div style="padding-left:6%;padding-top:1%;width:100%;color:red;"><?php echo $_SESSION['errorMsg'];unset($_SESSION['errorMsg']);?></div>

    <div class="err" style="margin-left:0px; margin-bottom:10px;"><strong><?php echo $_SESSION['msg'];unset($_SESSION['msg']);?></strong></div>
	
	<div class="successMsg" style="margin-left:0px; margin-bottom:10px;"><?php echo $_SESSION['successMsg'];unset($_SESSION['successMsg']);?></div><?php */?>
	<?php } ?>

    	<form action="<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>" method="post" enctype="multipart/form-data" name="frmWorkPlace" id="frmWorkPlace" >

			<div class="userInfo" style="margin-bottom:10px;">
				<?php /*?><div style="float:left; font-size:1.3em; font-weight:bold;">
				<?php echo $Profiledetail['firstName'].' '.$Profiledetail['lastName']; ?>
				</div><?php */?>
				<div style="float:left; font-weight:bold;">
				<?php //echo $Profiledetail['userTagName']; ?>
				</div>
				<div style="float:left; margin-left:2.5%; font-weight:bold;">
				<?php //echo $Profiledetail['userName']; ?>
				</div>
			</div>
			<div class="clr"></div>
          <div id="workPlaceDiv" style="padding-left:0%; margin-top:1%;">

			<?php /*?> <div style="text-align:left;margin-left:0px; margin-top:20px; width:<?php echo ($this->config->item('page_width')/10)+6.6;?>%; float:left;"> <strong><?php echo $this->lang->line('txt_Edit_Profile');?></strong> </div><?php */?>
			<div class="clr"></div>
			
			<!--First section start here-->
			<div class="FirstDiv">
			
			<!--Hidden value of user profile start-->
			 <input type="hidden" name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />
			 <input type="hidden" name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>
			 <input type="hidden" name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>
			 <input type="hidden" name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['editUserTagName'];?>" readonly="readonly"/>
			<input type="hidden" name="userGroup" type="text" class="text_gre1" id="userGroup" size="30" value="<?php echo $Profiledetail['userGroup'];?>" readonly="readonly"/>
			<!--Hidden value of user profile end-->
			
			<?php /*?><div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />

              <input type="hidden" name="userTitle" id="userTitle" value="" />

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>

            </div>
			</div>
			
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>

              &nbsp;<span id="userNameStatusText"></span> </div>
			  </div>
			  <div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left;height:30px;">

              <input type="hidden" name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['userTagName'];?>" readonly="readonly"/>

            </div>
			</div>
			
			<div class="clr"></div><?php */?>
			
			<table width="100%">
			<tr>
			<td style="padding-bottom:20px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_Photo');?>:
			</td>
			<td style="padding-bottom:20px;">
				<?php
								if ($_SESSION['photo']!='noimage.jpg')
								{
							?>
									<img style="width:36px; margin-top:0px;" class="clsHeaderUserImage uploadedImg" src="<?php echo base_url();?>workplaces/<?php echo $placeName;?>/user_profile_pics/<?php echo $_SESSION['photo'];?>">
									<img src="" style="width:36px; display:none;" class="uploadTempImg" />
                          	<?php
								}
								else
								{
							?>
									<img style="width:36px;" class="clsHeaderUserImage uploadedImg" src="<?php echo base_url();?>images/<?php echo $_SESSION['photo'];?>">
									<img src="" style="width:36px; display:none;" class="uploadTempImg"/>
							<?php
								}
							?>
			<div>
              <input type="file" name="photo" id="photo" class="text_gre1" size="30" onchange="readURL(this);" onclick="clearSessionMsg();" /><span class="errorMsg photoErrorMsg" style="color:red;"><?php echo $_SESSION['errorMsg'];unset($_SESSION['errorMsg']);?></span>
			  </div>
			                
              <div>(jpg, jpeg, png, gif only) </div>
			</td>
			</tr>
			<tr>
			<td style="padding-bottom:20px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_user_full_name');?>:
			</td>
			<td style="padding-bottom:20px;">
				<input class="text_gre1" size="30" value="<?php echo $Profiledetail['firstName'].' '.$Profiledetail['lastName']; ?>" readonly="" style="background:#ccc;"/>
			</td>
			</tr>
			<tr>
			<td style="padding-bottom:20px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_nick_name');?>:
			</td>
			<td style="padding-bottom:20px;">
				<input name="nickName" class="text_gre1" id="nickName" size="30" value="<?php echo $Profiledetail['editNickName'];?>"/>
			</td>
			</tr>
			<tr>
				<td style="padding-bottom:20px;" class="profileLeftLabel">
					<?php echo $this->lang->line('txt_Status');?>:
				</td>
				<td style="padding-bottom:20px;">
					 <textarea name="status" id="statusUpdate" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['statusUpdate'];?></textarea>
				</td>
				</tr>
			<tr>
			<td style="padding-bottom:20px;" class="profileLeftLabel">	
				<?php echo $this->lang->line('txt_Role');?>:
			</td>
			<td style="padding-bottom:20px;">
					<input name="role" class="text_gre1" id="role" size="30"  value="<?php echo $Profiledetail['role'];?>"/>
			</td>
			</tr>
			<tr> 
				<td style="padding-bottom:20px;" class="profileLeftLabel">
					<?php echo $this->lang->line('txt_Mobile');?>:
				</td>			
	
				<td style="padding-bottom:20px;">
					 <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $Profiledetail['mobile'];?>"/>
			</td>
			</tr>
			<tr>
			<td style="padding-bottom:20px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_Email');?>:
			</td>
			<td style="padding-bottom:20px;">
				<input class="text_gre1"  size="30" value="<?php echo $Profiledetail['userName'];?>" readonly="" style="background:#ccc;"/>
			</td>
			</tr>
			<tr>
			<td style="" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_user_profile_tag_name');?>:
			</td>
			<td style="">
				<input class="text_gre1" size="30" value="<?php echo $Profiledetail['editUserTagName'];?>" readonly="" style="background:#ccc;"/>
			</td>
			</tr>
			<tr>
			</tr>
			</table>
			<div style="height:50; display:none;" class="prof_txt">

              <div class="prof_left" style="width:30%; float:left; margin: 0px 6px 18px 0; " align="right"><?php echo $this->lang->line('select_default_space_txt');?></div>

              <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

                <?php

		   

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			
					//echo "<li>Settings= "; print_r($settings); exit;
			//echo "<li>ws= " .$workSpaceData['workSpaceId'];

		?>

          <select name="spaceSelect" class="selbox-min" style="padding:0px; margin:0px;" >

            <?php 

			

	if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <option value="0" <?php if($Profiledetail['defaultSpace'] == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>

    <?php

		$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}
				if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) || $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))
				{

			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId']) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
		}

    }

	else

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <?php

    	$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

			{
				if($workSpaceData['workSpaceId']!=1)
				{
			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId'] || ($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2)) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
			}

		}

    

	}

    ?>

          </select>

              </div>

            </div>
			<!--<div class="clr"></div>-->
			
			<!--User timezone start-->
			<div style="height:50; display:none;" class="prof_txt" >
			<div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('time_zone_txt');?>:</div>
			<div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">
			<select name="timezone" id="timezone" style="width:200px;">
							
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
			</div>
			</div>
			<!--<div class="dotted_line_for_desktop"></div>-->
			<!--User timezone end-->
			<div class="ver"></div>
			</div>
			
			<!--<div class="clr"></div>-->
			<!--First section end here -->
			
			<!--Second section start here-->
			<?php /*?><div class="SecondDiv">
			
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Department');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="department" class="text_gre1" id="department" size="30"  value="<?php echo $Profiledetail['department'];?>"/>

            </div>
			</div>
			<div class="clr"></div>
			
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_skills');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:80px;">

              <textarea name="skills"  id="skills" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['skills'];?></textarea>

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Address');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:80px;">

              <textarea name="address1"  id="address1" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['address1'];?></textarea>

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Telephone');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="phone" class="text_gre1" id="phone" size="30" value="<?php echo $Profiledetail['phone'];?>"/>

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Other_Details');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:80px;">

              <textarea name="otherMember" rows="3"  id="otherMember" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['other'];?></textarea>

            </div>
			</div>
			</div><?php */?>
           
			<!--Second section start here-->
			
			<!--Third section start here-->
			<?php /*?><div class="ThirdDivs" style="display:none;">
			
			<div style="height:50" class="prof_txt">

              <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Current_Password');?>:</div>

              <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

                <input name="currentPassword" type="password" class="text_gre1" id="currentPassword" size="30" />

              </div>

            </div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_New_Password');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="password" type="password" class="text_gre1" id="password" size="30" />

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Retype_New_Password');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" />

            </div>
			</div>
			<!--<div class="dotted_line_for_desktop"></div>-->
			</div><?php */?>
			<!--<div class="clr"></div>-->
			 <div class="clr"></div>
			<!--Third section end here-->

            <div style=" width:<?php echo ($this->config->item('page_width')/10)-28;?>%; margin-top:10px; float:left; margin-left:0px ">

              <input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>

              <input type="hidden" name="userCommunity"  id="userCommunity" value="<?php echo $Profiledetail['userCommunityId']; ?>" />

              <input type="hidden" name="userId" class="hidden" id="userId" size="30" value="<?php echo $Profiledetail['userId'];?>"/>

              <input type="hidden" name="workSpaceId" class="hidden" id="workSpaceId" size="30" value="<?php echo $workSpaceId;?>"/>

             <input type="hidden" name="workSpaceType" class="hidden" id="workSpaceType" size="30" value="<?php echo $workSpaceType;?>"/>

              <input type="hidden" name="userPassword" class="hidden" id="userPassword" size="30" value="<?php echo $Profiledetail['password'];?>"/>

              <input type="button" name="Submit" value="<?php echo $this->lang->line('txt_Save');?>" class="button01" onClick="return validateWorkPlaceMemberEdit('document.frmWorkPlace','<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>','<?php echo base_url();?>edit_workplace_member/uploadImage');"/>
			  
			  <input type="reset" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearProfileForm()"/>
			  
			   <span class="successMsg" style="margin-left:0px; margin-bottom:10px;"><?php echo $_SESSION['successMsg'];unset($_SESSION['successMsg']);?></span>

              <!--<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="hidePopWin(false);" />-->

            </div>

          </div>

        </form>

    </div>

    
	<!--Password form start here-->
	
	<div id="password_form" style=" <?php if($passwordForm=='1'){ ?> display:block; <?php }else{ ?> display:none; <?php } ?> ">
 	<?php if($passwordForm=='1'){ ?>
    <div style="margin-left:5px; padding-top:0%;width:100%;color:red;"><?php echo $_SESSION['passwordErrorMsg'];unset($_SESSION['passwordErrorMsg']);?></div>

   <?php /*?> <div class="err" style="margin-left:0px; margin-bottom:10px;"><strong><?php echo $_SESSION['msg'];unset($_SESSION['msg']);?></strong></div><?php */?>
	
	<div class="successMsg" style="margin-left:0px; margin-bottom:10px;"><?php echo $_SESSION['passwordSuccessMsg'];unset($_SESSION['passwordSuccessMsg']);?></div>
	<?php } ?>
    	<form action="<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>" method="post" enctype="multipart/form-data" name="frmWorkPlace1" id="frmWorkPlace1" >

			
			<div class="clr"></div>
          <div id="workPlaceDiv" style="padding-left:0%; margin-top:1%;">

			<?php /*?> <div style="text-align:left;margin-left:0px; margin-top:20px; width:<?php echo ($this->config->item('page_width')/10)+6.6;?>%; float:left;"> <strong><?php echo $this->lang->line('txt_Edit_Profile');?></strong> </div><?php */?>
			<div class="clr"></div>
			
			<!--First section start here-->
			<input type="hidden" name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />
			 <input type="hidden" name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>
			 <input type="hidden" name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>
			 <input type="hidden" name="tagName" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['editUserTagName'];?>" readonly="readonly"/>
			  <input type="hidden" name="nickName" class="text_gre1" id="nickName" size="30" value="<?php echo $Profiledetail['editNickName'];?>"/>
			   <input type="hidden" name="userGroup" type="text" class="text_gre1" id="userGroup" size="30" value="<?php echo $Profiledetail['userGroup'];?>" readonly="readonly"/>
			<div class="FirstDivs" style="display: none;">
			
			<!--Hidden value of user profile start-->
			<!--Hidden value of user profile end-->
			
			<?php /*?><div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />

              <input type="hidden" name="userTitle" id="userTitle" value="" />

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>

            </div>
			</div>
			
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input type="hidden" name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>

              &nbsp;<span id="userNameStatusText"></span> </div>
			  </div>
			  <div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left;height:30px;">

              <input type="hidden" name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['userTagName'];?>" readonly="readonly"/>

            </div>
			</div>
			
			<div class="clr"></div><?php */?>
			
			<div style="height:100; margin-top:22px;" >
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Photo');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left;">
				<!--<img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >-->
							<?php
								if ($_SESSION['photo']!='noimage.jpg')
								{
							?>
									<img style="width:36px;" class="clsHeaderUserImage" src="<?php echo base_url();?>workplaces/<?php echo $placeName;?>/user_profile_pics/<?php echo $_SESSION['photo'];?>">
                          	<?php
								}
								else
								{
							?>
									<img style="width:36px;" class="clsHeaderUserImage" src="<?php echo base_url();?>images/<?php echo $_SESSION['photo'];?>">
							<?php
								}
							?>
              <input type="file" name="photo" id="photo" class="text_gre1" size="30" />

              
              <div>(jpg, jpeg, png, gif only) </div>
			 </div>
			 </div>
			 <div class="clr"></div>
			 
			 <!--Status update code start-->
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Status');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:80px;">

              <textarea name="status" id="statusUpdate" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['statusUpdate'];?></textarea>

            </div>
			</div>
			<div class="clr"></div>
			<!--Status update code end-->
			
			<div style="height:50" class="prof_txt">

              <div class="prof_left" style="width:30%; float:left; margin: 0px 6px 18px 0; " align="right"><?php echo $this->lang->line('select_default_space_txt');?></div>

              <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

                <?php

		   

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			
					//echo "<li>Settings= "; print_r($settings); exit;
			//echo "<li>ws= " .$workSpaceData['workSpaceId'];

		?>

          <select name="spaceSelect" class="selbox-min" style="padding:0px; margin:0px;" >

            <?php 

			

	if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <option value="0" <?php if($Profiledetail['defaultSpace'] == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>

    <?php

		$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}
				if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) || $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))
				{

			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId']) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
		}

    }

	else

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <?php

    	$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

			{
				if($workSpaceData['workSpaceId']!=1)
				{
			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId'] || ($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2)) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
			}

		}

    

	}

    ?>

          </select>

              </div>

            </div>
			<div class="clr"></div>
			
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Mobile');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $Profiledetail['mobile'];?>"/>

            </div>
			</div>
			<div class="clr"></div>	
			
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Role');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="role" class="text_gre1" id="role" size="30"  value="<?php echo $Profiledetail['role'];?>"/>

            </div>
			</div>
			<div class="clr"></div>		
			
			<!--User timezone start-->
			<div style="height:50; display:none;" class="prof_txt">
			<div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('time_zone_txt');?>:</div>
			<div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">
			<select name="timezone" id="timezone" style="width:200px;">
							
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
			</div>
			</div>
			<!--<div class="dotted_line_for_desktop"></div>-->
			<!--User timezone end-->
			</div>
			
			<!--<div class="clr"></div>-->
			<!--First section end here -->
			
			<!--Third section start here-->
			<div class="ThirdDiv" style="width:70%;">
			
			
			<table>
			<tr>
			<td style="padding-bottom:10px;">
              <?php echo $this->lang->line('txt_Current_Password');?>:
			</td>
			<td style="padding-bottom:10px;">
              <input name="currentPassword" type="password" class="text_gre1" id="currentPassword" size="30" />

             </td>
			 </tr>
			 <tr>

			<td style="padding-bottom:10px;">
           <?php echo $this->lang->line('txt_New_Password');?>:
			</td>
			<td style="padding-bottom:10px;">
          
              <input name="password" type="password" class="text_gre1" id="password" size="30" />

            
			</td>
			<tr>
			<td>
			<?php echo $this->lang->line('txt_Retype_New_Password');?>:
			</td>
			<td>
            
              <input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" />

          
			</td>
			</tr>
			</table>
			
			<!--<div class="dotted_line_for_desktop"></div>-->
			</div>
			<!--<div class="clr"></div>-->
			 <div class="clr"></div>
			<!--Third section end here-->

            <div style=" width:<?php echo ($this->config->item('page_width')/10)-28;?>%; margin-top:10px; float:left; margin-left:0px ">

              <input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>

              <input type="hidden" name="userCommunity"  id="userCommunity" value="<?php echo $Profiledetail['userCommunityId']; ?>" />

              <input type="hidden" name="userId" class="hidden" id="userId" size="30" value="<?php echo $Profiledetail['userId'];?>"/>

              <input type="hidden" name="workSpaceId" class="hidden" id="workSpaceId" size="30" value="<?php echo $workSpaceId;?>"/>

             <input type="hidden" name="workSpaceType" class="hidden" id="workSpaceType" size="30" value="<?php echo $workSpaceType;?>"/>

              <input type="hidden" name="userPassword" class="hidden" id="userPassword" size="30" value="<?php echo $Profiledetail['password'];?>"/>

              <input type="button" name="Submit" value="<?php echo $this->lang->line('txt_Save');?>" class="button01" onClick="return validateWorkPlaceMemberPasswordEdit('document.frmWorkPlace1','<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>','<?php echo base_url();?>edit_workplace_member/uploadImage');"/>
			  
			  <input type="reset" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" />

              <!--<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="hidePopWin(false);" />-->

            </div>

          </div>

        </form>

    </div>
	
	<!--Password form end here-->
    

    <div id="editorChoice" style="display:none;">

        <div class="clsMarginBottom10" > 

          <div class='clr' ></div>

        </div>

        <?php $attributes = array('name' => 'frmSettings', 'method' => 'post');	

		echo form_open(base_url().'preference/index/'.$workSpaceId.'/type/'.$workSpaceType, $attributes);?>
        <div  class="clsMarginBottom10"> 

        <div class="flLt confSetting" style="text-align:left;">
			<?php echo $this->lang->line('load_editor_txt'); ?>
          	<input type="radio" value="Yes" name="editor1" <?php if($settings['editorOption']!='No'){echo "checked='checked'";} ?> />&nbsp;Yes
          	<input type="radio" value="No" name="editor1" <?php if($settings['editorOption']=='No'){echo "checked='checked'";} ?> />&nbsp;No 
		</div>
		<div class='clr'></div>
        <div class="flLt confSetting" style="text-align:left;" > 
		
		<?php echo $this->lang->line('select_default_space_txt'); ?> &nbsp;&nbsp;&nbsp;&nbsp;:  

        <?php

		   

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			
					//echo "<li>Settings= "; print_r($settings); exit;
		//echo "<li>ws= " .$workSpaceData['workSpaceId'];

		?>

          <select name="spaceSelect" class="selbox-min" >

            <?php 

			

	if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <option value="0" <?php if($workSpaceId == 0 && $setttings['defaultSpace'] ==0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>

    <?php

		$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($settings['defaultSpace'] == $workSpaceData['workSpaceId']) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php

		}

    }

	else

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <?php

    	$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

			{
				if($workSpaceData['workSpaceId']!=1)
				{
			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($setttings['defaultSpace'] == $workSpaceData['workSpaceId'] || ($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2)) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
			}

		}

    

	}

    ?>

          </select>

        </div>

         <div class='clr'></div>

          <input type="submit" name="submit" value="Save" class="button01" style="margin-left: 58px; float:left;" />

          <div class='clr' ></div>

        </div>

       

        <?php echo form_close();?>

      </div>
	  
	  <!--Manoj: Notification tab view start here-->
	  
	  	<!--Manoj: email notification tab start from here-->
	
	<?php $attributes = array('name' => 'formNotificationSettings', 'method' => 'post');	

		echo form_open(base_url().'notifications/setNotificationUserPreference/'.$workSpaceId.'/type/'.$workSpaceType, $attributes);?>
		
	<?php 
		/*foreach($notification_user_preferences as $keyVal=>$userPreferenceData)
		{ 
			//Tree type start
			if($userPreferenceData['notification_type_id']==1)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$treeCreateStatus = $userPreferenceData['preference'];
					$treeCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$treeEditStatus = $userPreferenceData['preference'];
					$treeEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==14)
				{
					$treeNewVersionStatus = $userPreferenceData['preference'];
					$treeNewVersionUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==5)
				{
					$treeStartStatus = $userPreferenceData['preference'];
					$treeStartUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==6)
				{
					$treeStopStatus = $userPreferenceData['preference'];
					$treeStopUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==11)
				{
					$treeMoveStatus = $userPreferenceData['preference'];
					$treeMoveUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Tree type end
			
			//Contributor type start
			if($userPreferenceData['notification_type_id']==14)
			{
				if($userPreferenceData['notification_action_type_id']==9)
				{
					$contributorAssignStatus = $userPreferenceData['preference'];
					$contributorAssignUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==10)
				{
					$contributorUnassignStatus = $userPreferenceData['preference'];
					$contributorUnassignUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Contributor type end
			
			//Leaf type start
			if($userPreferenceData['notification_type_id']==2)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$leafCreateStatus = $userPreferenceData['preference'];
					$leafCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$leafEditStatus = $userPreferenceData['preference'];
					$leafEditUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Leaf type end
			
			//Post type start
			if($userPreferenceData['notification_type_id']==3)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$postCreateStatus = $userPreferenceData['preference'];
					$postCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==13)
				{
					$postCommentStatus = $userPreferenceData['preference'];
					$postCommentUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Post type end
			
			//Simple tag type start
			if($userPreferenceData['notification_type_id']==4)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$simpleTagCreateStatus = $userPreferenceData['preference'];
					$simpleTagCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==4)
				{
					$simpleTagApplyStatus = $userPreferenceData['preference'];
					$simpleTagApplyUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$simpleTagDeleteStatus = $userPreferenceData['preference'];
					$simpleTagDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Simple tag type end
			
			//Action tag type start
			if($userPreferenceData['notification_type_id']==5)
			{
				if($userPreferenceData['notification_action_type_id']==4)
				{
					$actionTagApplyStatus = $userPreferenceData['preference'];
					$actionTagApplyUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$actionTagEditStatus = $userPreferenceData['preference'];
					$actionTagEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$actionTagDeleteStatus = $userPreferenceData['preference'];
					$actionTagDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Action tag type end
			
			//Contact tag type start
			if($userPreferenceData['notification_type_id']==6)
			{
				if($userPreferenceData['notification_action_type_id']==4)
				{
					$contactTagApplyStatus = $userPreferenceData['preference'];
					$contactTagApplyUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$contactTagDeleteStatus = $userPreferenceData['preference'];
					$contactTagDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Contact tag type end
			
			//Link type start
			if($userPreferenceData['notification_type_id']==7)
			{
				if($userPreferenceData['notification_action_type_id']==4)
				{
					$linkApplyStatus = $userPreferenceData['preference'];
					$linkApplyUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$linkDeleteStatus = $userPreferenceData['preference'];
					$linkDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Link type end
			
			//Talk comment type start
			if($userPreferenceData['notification_type_id']==8)
			{
				if($userPreferenceData['notification_action_type_id']==13)
				{
					$talkCommentStatus = $userPreferenceData['preference'];
					$talkCommentUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Talk comment type end
			
			//File type start
			if($userPreferenceData['notification_type_id']==9)
			{
				if($userPreferenceData['notification_action_type_id']==12)
				{
					$fileImportStatus = $userPreferenceData['preference'];
					$fileImportUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$fileDeleteStatus = $userPreferenceData['preference'];
					$fileDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//File type end
			
			//Space type start
			if($userPreferenceData['notification_type_id']==10)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$spaceCreateStatus = $userPreferenceData['preference'];
					$spaceCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$spaceEditStatus = $userPreferenceData['preference'];
					$spaceEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==8)
				{
					$spaceSuspendStatus = $userPreferenceData['preference'];
					$spaceSuspendUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==7)
				{
					$spaceActivateStatus = $userPreferenceData['preference'];
					$spaceActivateUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Space type end
			
			//Subspace type start
			if($userPreferenceData['notification_type_id']==11)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$subSpaceCreateStatus = $userPreferenceData['preference'];
					$subSpaceCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$subSpaceEditStatus = $userPreferenceData['preference'];
					$subSpaceEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==8)
				{
					$subSpaceSuspendStatus = $userPreferenceData['preference'];
					$subSpaceSuspendUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==7)
				{
					$subSpaceActivateStatus = $userPreferenceData['preference'];
					$subSpaceActivateUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Subspace type end
			
			//Place type start
			if($userPreferenceData['notification_type_id']==12)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$placeCreateStatus = $userPreferenceData['preference'];
					$placeCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$placeEditStatus = $userPreferenceData['preference'];
					$placeEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==8)
				{
					$placeSuspendStatus = $userPreferenceData['preference'];
					$placeSuspendUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==7)
				{
					$placeActivateStatus = $userPreferenceData['preference'];
					$placeActivateUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Place type end
			
			//Place manager type start
			if($userPreferenceData['notification_type_id']==16)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$placeManagerCreateStatus = $userPreferenceData['preference'];
					$placeManagerCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$placeManagerEditStatus = $userPreferenceData['preference'];
					$placeManagerEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==8)
				{
					$placeManagerSuspendStatus = $userPreferenceData['preference'];
					$placeManagerSuspendUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==7)
				{
					$placeManagerActivateStatus = $userPreferenceData['preference'];
					$placeManagerActivateUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Place manager type end
			
			//member type start
			if($userPreferenceData['notification_type_id']==15)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$userCreateStatus = $userPreferenceData['preference'];
					$userCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$userEditStatus = $userPreferenceData['preference'];
					$userEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$userDeleteStatus = $userPreferenceData['preference'];
					$userDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==8)
				{
					$userSuspendStatus = $userPreferenceData['preference'];
					$userSuspendUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==7)
				{
					$userActivateStatus = $userPreferenceData['preference'];
					$userActivateUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//member type end
			
			//Admin type start
			if($userPreferenceData['notification_type_id']==13)
			{
				if($userPreferenceData['notification_action_type_id']==1)
				{
					$adminCreateStatus = $userPreferenceData['preference'];
					$adminCreateUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==2)
				{
					$adminEditStatus = $userPreferenceData['preference'];
					$adminEditUrgentStatus = $userPreferenceData['urgent'];
				}
				if($userPreferenceData['notification_action_type_id']==3)
				{
					$adminDeleteStatus = $userPreferenceData['preference'];
					$adminDeleteUrgentStatus = $userPreferenceData['urgent'];
				}
			}
			//Admin type end
			
			
			
		}*/
		
		//echo '<pre>';
		//print_r($notification_email_preferences);
		//exit;
		
		foreach($notification_email_preferences as $emailPreferenceData)
		{
			if($emailPreferenceData['notification_type_id']==1)
			{
				if($emailPreferenceData['notification_priority_id']==2)
				{
					$allNeverEmailStatus = $emailPreferenceData['preference'];
				}
				if($emailPreferenceData['notification_priority_id']==3)
				{
					$allEmailOneHourStatus = $emailPreferenceData['preference'];
				}
				if($emailPreferenceData['notification_priority_id']==4)
				{
					$allEmail24HourStatus = $emailPreferenceData['preference'];
				}				
			}
			if($emailPreferenceData['notification_type_id']==2)
			{
				if($emailPreferenceData['notification_priority_id']==2)
				{
					$personalizeNeverEmailStatus = $emailPreferenceData['preference'];
				}
				if($emailPreferenceData['notification_priority_id']==3)
				{
					$personalizeEmailOneHourStatus = $emailPreferenceData['preference'];
				}
				if($emailPreferenceData['notification_priority_id']==4)
				{
					$personalizeEmail24HourStatus = $emailPreferenceData['preference'];
				}
			}
			
			if($allNeverEmailStatus=='1' || $allEmailOneHourStatus=='1' || $allEmail24HourStatus=='1')
			{	
				$allNotificationTypeStatus=1;
			}
			if($personalizeNeverEmailStatus=='1' || $personalizeEmailOneHourStatus=='1' || $personalizeEmail24HourStatus=='1') 
			{	
				$personalizeTypeStatus=1;
			}
			/*if($emailPreferenceData['notification_modes_id']==2)
			{
				$neverEmailStatus = $emailPreferenceData['preference'];
			}
			if($emailPreferenceData['notification_modes_id']==3)
			{
				$EmailOneHourStatus = $emailPreferenceData['preference'];
			}
			if($emailPreferenceData['notification_modes_id']==4)
			{
				$Email24HourStatus = $emailPreferenceData['preference'];
			}
			if($emailPreferenceData['notification_modes_id']==5)
			{
				$allEmailNotification = $emailPreferenceData['preference'];
			}
			if($emailPreferenceData['notification_modes_id']==6)
			{
				$personalizeEmailNotification = $emailPreferenceData['preference'];
			}*/
		}
		
		/*foreach($notification_language_preferences as $languagePreferenceData)
		{
			if($languagePreferenceData['notification_language_id']==1)
			{
				$languageStatus = $languagePreferenceData['notification_language_id'];
			}
			if($languagePreferenceData['notification_language_id']==2)
			{
				$languageStatus = $languagePreferenceData['notification_language_id'];
			}
		}*/
		
		if($notification_language_preferences['notification_language_id']==1)
		{
			$languageStatus = $notification_language_preferences['notification_language_id'];
		}
		if($notification_language_preferences['notification_language_id']==2)
		{
			$languageStatus = $notification_language_preferences['notification_language_id'];
		}
		//echo $treeCreateStatus;
	?>
	
	<div id="notificationSection" style=" padding: 0 2px 35px; <?php if($profileForm=='1'){ ?> display:none; <?php } ?> ">
	
	<div class="successMsg" style="margin-left:0px; margin-bottom:10px;"><?php echo $_SESSION['preferenceSuccessMsg'];unset($_SESSION['preferenceSuccessMsg']);?></div>
		
		<?php /*?><div class="notification_head">
			<p><?php echo $this->lang->line('txt_notifications_settings_title'); ?></p>
		</div><?php */?>
		
		<!--Language section start-->
				<?php /*?><p class="email_notify_head" style="padding-left:4px;"><?php echo $this->lang->line('txt_Language'); ?></p>
				<div>
				<div class="settingOptions leftSection" style="width:13%; padding-left:4px;">
					<?php echo $this->lang->line('txt_notification_language'); ?>
				</div>
				<div class="rightSection">
					<select name="language">
						<option value="eng" <?php if($languageStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_english_language'); ?></option>
						<option value="jpn" <?php if($languageStatus=='2'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_japanese_language'); ?></option>
					</select>
				</div>
				</div><?php */?>
		<!--Language section end-->
		
		
		<div class="emailNotification">
			<div>
			
				<?php /*?><p class="email_notify_head" style="padding-left:4px;"><?php echo $this->lang->line('txt_Email').' '.$this->lang->line('txt_notification_tab'); ?></p><?php */?>
			
				<!--Language section start-->
				<?php /*?><p class="email_notify_head" style="padding-left:4px;"><?php echo $this->lang->line('txt_Language'); ?></p><?php */?>
			<table width="85%">
			<tr>
			<td style="padding-bottom:7px;">
				<?php echo $this->lang->line('select_default_space_txt');?>:
			</td>
			<td style="padding-bottom:7px;">
				

            <?php

		   
			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			
			
			?>

          <select name="spaceSelect" class="selbox-min" style="padding:0px; margin:0px;" >

            <?php 

			

	if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <option value="0" <?php if($Profiledetail['defaultSpace'] == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>

    <?php

		$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}
				if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) || $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))
				{

			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId']) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
		}

    }

	else

	{

	?>

            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>

            <?php

    	$i = 1;



		foreach($workSpaces as $keyVal=>$workSpaceData)

		{				

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

			{
				if($workSpaceData['workSpaceId']!=1)
				{
			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($Profiledetail['defaultSpace'] == $workSpaceData['workSpaceId'] || ($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2)) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php
				}
			}

		}

    

	}

    ?>

          </select>

             
			</td>
			</tr>
			<tr>
			<td style="padding-bottom:10px;">
				
					<?php echo $this->lang->line('txt_notification_language'); ?>:
				
			</td>
			<td style="padding-bottom:10px;">
				
					<select name="language">
						<option value="eng" <?php if($languageStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_english_language'); ?></option>
						<option value="jpn" <?php if($languageStatus=='2'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_japanese_language'); ?></option>
					</select>
				
			</td>
			</tr>
		<!--Language section end-->
		
		<!--Timezone section start-->
				<?php /*?><p class="email_notify_head" style="padding-left:4px;"><?php echo $this->lang->line('time_zone_txt'); ?></p><?php */?>
				<tr>
				<td style="padding-bottom:10px;">
				
					<?php echo $this->lang->line('txt_current_locale'); ?>:
				
				</td>
				<td style="padding-bottom:10px;">
				
						<select name="timezone" id="timezone" style="width:200px;">
							
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
				<!--Timezone section end-->
				
				<?php /*?><div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_what_you_will_receive'); ?>
				</div>
				<div class="rightSection" style="float:left; width:60%;">
				
				<div>
				<?php */?>
				
				<tr>
				<?php /*?><th style="text-align:left; padding-bottom:15px;">
					<?php echo $this->lang->line('preferences_txt'); ?>
				</th>
				<th style="text-align:left; padding-bottom:15px;">
					<?php echo $this->lang->line('txt_priority'); ?>
				</th><?php */?>
				</tr>
				<tr> 
				<td style="padding-bottom:10px;">
	<?php /*?><input type="checkbox" id="all" name="allEmailTypePreference" onclick="disablePreference('all');" value="1" <?php if($allNotificationTypeStatus=='1') { echo 'checked'; }?>><?php */?> <?php echo $this->lang->line('txt_email_all_notifications'); ?>:	
				</td>			
	
				<td style="padding-bottom:10px;">
				
	<input type="checkbox" id="allNeverEmail" name="allEmailPreference[]" onclick="disableEmailPreference('all');" value="2" <?php if($allNeverEmailStatus=='1') { echo 'checked'; }?><?php if($allNeverEmailStatus!=1){ echo 'uncheck'; } ?>> <?php echo $this->lang->line('txt_email_notify_never'); ?>						    
	
	<input type="checkbox" id="allEmailOneHour" name="allEmailPreference[]" onclick="disableNeverPreference('all');" value="3" <?php if($allEmailOneHourStatus=='1') { echo 'checked'; }?> <?php if($allEmailOneHourStatus!=1){ echo 'uncheck'; } ?>><?php echo $this->lang->line('txt_email_notify_every_hour'); ?>
	
	<input type="checkbox" id="allEmail24Hour" name="allEmailPreference[]" onclick="disableNeverPreference('all');" value="4" <?php if($allEmail24HourStatus=='1') { echo 'checked'; }?> <?php if($allEmail24HourStatus!=1){ echo 'uncheck"'; }  ?>><?php echo $this->lang->line('txt_email_notify_24_hour'); ?>
	
			</td>
			</tr>
			<tr>
			<td style="">	
<?php /*?><input type="checkbox" id="personalized" name="personalizeEmailTypePreference" onclick="disablePreference('personalize');" value="2" <?php if($personalizeTypeStatus=='1') { echo 'checked'; }?>><?php */?><?php echo $this->lang->line('txt_email_personalized_notifications'); ?>:				
	
			</td>
			<td>
					
	<input type="checkbox" id="personalizeNeverEmail" name="personalizeEmailPreference[]" onclick="disableEmailPreference('personalize');" value="2" <?php if($personalizeNeverEmailStatus=='1') { echo 'checked'; }?><?php if($personalizeNeverEmailStatus!=1){ echo 'uncheck'; } ?>> <?php echo $this->lang->line('txt_email_notify_never'); ?>						    
	
	<input type="checkbox" id="personalizeEmailOneHour" name="personalizeEmailPreference[]" onclick="disableNeverPreference('personalize');" value="3" <?php if($personalizeEmailOneHourStatus=='1') { echo 'checked'; }?><?php if($personalizeEmailOneHourStatus!=1){ echo 'uncheck'; } ?>><?php echo $this->lang->line('txt_email_notify_every_hour'); ?>
	
	<input type="checkbox" id="personalizeEmail24Hour" name="personalizeEmailPreference[]" onclick="disableNeverPreference('personalize');" value="4" <?php if($personalizeEmail24HourStatus=='1') { echo 'checked'; }?><?php if($personalizeEmail24HourStatus!=1){ echo 'uncheck'; } ?>><?php echo $this->lang->line('txt_email_notify_24_hour'); ?>
	
	</td>
	</tr>
	</table>
					
				
				
	</div>
				
				<div class="clr"></div>
				
				<?php /*?><div style="margin-top:20px;">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_what_you_will_receive'); ?>
				</div>
				<div class="rightSection">
					
					<input type="checkbox" id="all" name="emailPreference[]" onclick="disablePersonalizePreference();" value="5" <?php if($allEmailNotification=='1') { echo 'checked'; }?>> <?php echo $this->lang->line('txt_all_email_notification'); ?>						    
	
	<input type="checkbox" id="personalized" name="emailPreference[]" onclick="disableAllPreference();" value="6" <?php if($personalizeEmailNotification=='1') { echo 'checked'; }?>><?php echo $this->lang->line('txt_personalize_email_notification'); ?>
					
					<select name="email_notification_type">
						<option value="5" <?php if($allEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_all_email_notification'); ?></option>
						<option value="6" <?php if($urgentEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_urgent_email_notification'); ?></option>	
						<option value="7" <?php if($personalizeEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_personalize_email_notification'); ?></option>
						<option value="8" <?php if($summarizeEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_summarize_email_notification'); ?></option>
					</select>
					
				</div>
				</div><?php */?>
				
				
			</div>
			
			
			
			<div class="clear"></div>
			<input type="submit" name="submit" value="<?php echo $this->lang->line('txt_Save'); ?>" class="button01 notificationBtn" />
			<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
		</div>
			
	</div>
	
	
	<?php echo form_close();?>
	<!--Manoj: email notification tab end here-->
	  
	  <!--Manoj: Notification tab view end here-->
	  

    </div>

</div>

<!--Added by Dashrath- load notification side bar-->
<?php $this->load->view('common/notification_sidebar.php');?>
<!--Dashrath- code end-->

</div>
</div>
<?php $this->load->view('common/foot');?>

<!--Commented by Dashrath- Comment footer for new ui-->
<?php //$this->load->view('common/footer');?>
</body>
</html>
<script>
function disableEmailPreference(notification_type)
{
	if(notification_type=='all')
	{
		if ($('input[id="allNeverEmail"]:checked').length > 0)
		{
			$("#allEmailOneHour").prop( "checked" ,false);
			$("#allEmail24Hour").prop( "checked" ,false);
		}
	}
	else if(notification_type=='personalize')
	{
		if ($('input[id="personalizeNeverEmail"]:checked').length > 0)
		{
			$("#personalizeEmailOneHour").prop( "checked" ,false);
			$("#personalizeEmail24Hour").prop( "checked" ,false);
		}
	}
}

function disableNeverPreference(notification_type)
{
	if(notification_type=='all')
	{
		if($('input[id="allEmailOneHour"]:checked').length > 0 || $('input[id="allEmail24Hour"]:checked').length > 0)
		{
			$("#allNeverEmail").prop( "checked" ,false);
		}
	}
	else if(notification_type=='personalize')
	{
		if($('input[id="personalizeEmailOneHour"]:checked').length > 0 || $('input[id="personalizeEmail24Hour"]:checked').length > 0)
		{
			$("#personalizeNeverEmail").prop( "checked" ,false);
		}
	}
}
function disablePreference(notification_type)
{
	if(notification_type=='all')
	{
		if($('input[id="all"]:checked').length > 0)
		{
			$("#allNeverEmail").attr( "disabled" ,false);
			$("#allEmailOneHour").attr("disabled", false);	
			$("#allEmail24Hour").attr("disabled", false);
		}
		else
		{
			$("#allNeverEmail").attr( "disabled" ,true);
			$("#allEmailOneHour").attr("disabled", true);	
			$("#allEmail24Hour").attr("disabled", true);
		}
	}
	else if(notification_type=='personalize')
	{
		if($('input[id="personalized"]:checked').length > 0)
		{
			$("#personalizeNeverEmail").attr( "disabled" ,false);
			$("#personalizeEmailOneHour").attr("disabled", false);	
			$("#personalizeEmail24Hour").attr("disabled", false);
		}
		else
		{
			$("#personalizeNeverEmail").attr( "disabled" ,true);
			$("#personalizeEmailOneHour").attr("disabled", true);	
			$("#personalizeEmail24Hour").attr("disabled", true);
		}
	}
	
}
function disablePersonalizePreference()
{
	if($('input[id="all"]:checked').length > 0)
	{
		$("#personalized").prop( "checked" ,false);
	}
}
//Upload image and show preview
function readURL(input) {
	
			if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					//alert(e.target.result);
					$('.uploadedImg').hide();
                   	$('.uploadTempImg').show();
				    $('.uploadTempImg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
			
			var ext = $('#photo').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
				$('.photoErrorMsg').html('<?php echo $this->lang->line('Error_unknown_file_extension'); ?>');
			}
}
function clearProfileForm()
{
	$(".uploadTempImg").hide();
	$(".uploadTempImg").removeAttr('src');
	$(".uploadedImg").show();
	clearSessionMsg();
}
function clearSessionMsg()
{
	$('.successMsg').html('');
	$('.errorMsg').html('');
	$('.err').html('');
	$('.errorHeadMsg').html('');
	$('.uploadTempImg').hide();
	$('.uploadedImg').show();
	$('#photo').val('');
}
</script>