<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Preferences</title>
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
    <?php $this->load->view('common/artifact_tabs'); ?>
  </div>
</div>
<div id="container">
  <div id="content">
	
<div>

    <ul class="tab_menu_new">
	
	
	
		<!--Notification tab start here-->
		
			<li>

            <a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="notification" title="notification" class="active" onclick="$('#notification').addClass('active');$('#profile').removeClass('active');$('#preferences').removeClass('active');$('#profileForm').hide();$('#editorChoice').hide();$('#notificationSection').show();"><?php echo $this->lang->line('txt_notification_tab'); ?></a>

        	</li>
		
		<!--Notification tab end here-->

        <li>

            <a href="javascript:void(0);" id="profile" style="padding-left:12%;margin-left:17%;" title="profile" class="" onclick="$('#profile').addClass('active');$('#preferences').removeClass('active');$('#notification').removeClass('active');$('#editorChoice').hide();$('#notificationSection').hide();$('#profileForm').show();"><?php echo $this->lang->line('profile_txt'); ?></a>

        </li>

        <li>

            <a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="preferences" title="preferences" class="" onclick="$('#preferences').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#editorChoice').show();"><?php echo $this->lang->line('preferences_txt'); ?></a>

        </li>
		
		

    </ul>

    <div id="content">

    <div id="profileForm" style="display:none;">

    <div style="padding-left:6%;padding-top:1%;width:100%;color:red;"><?php echo $_SESSION['errorMsg'];unset($_SESSION['errorMsg']);?></div>

    <div class="err" style="margin-left:52px; margin-bottom:10px;"><strong><?php echo $_SESSION['msg'];unset($_SESSION['msg']);?></strong></div>
	
	<div class="successMsg" style="margin-left:52px; margin-bottom:10px;"><?php echo $_SESSION['successMsg'];unset($_SESSION['successMsg']);?></div>

    	<form action="<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>" method="post" enctype="multipart/form-data" name="frmWorkPlace" id="frmWorkPlace" >

          <div id="workPlaceDiv" style="padding-left:0%;">

            <div style="text-align:left;margin-left:52px;width:<?php echo ($this->config->item('page_width')/10)+6.6;?>%; float:left;"> <strong><?php echo $this->lang->line('txt_Edit_Profile');?></strong> </div>
			<div class="clr"></div>
			<div style="height:100; margin-top:30px;" >
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Photo');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:50px;">
				<!--<img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >-->
							<?php
								if ($_SESSION['photo']!='noimage.jpg')
								{
							?>
									<img class="clsHeaderUserImage" src="<?php echo base_url();?>workplaces/<?php echo $placeName;?>/user_profile_pics/<?php echo $_SESSION['photo'];?>">
                          	<?php
								}
								else
								{
							?>
									<img class="clsHeaderUserImage" src="<?php echo base_url();?>images/<?php echo $_SESSION['photo'];?>">
							<?php
								}
							?>
              <input type="file" name="photo" id="photo" class="text_gre1" size="30" />

              
              <div>(jpg, jpeg, png, gif only) </div>
			 </div>
			 </div>
			 <div class="clr"></div>

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
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />

              <input type="hidden" name="userTitle" id="userTitle" value="" />

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>

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
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Mobile');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $Profiledetail['mobile'];?>"/>

            </div>
			</div>
			<div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Other_Details');?>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:80px;">

              <textarea name="otherMember" rows="3"  id="otherMember" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['other'];?></textarea>

            </div>
			</div>
            <div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left; height:30px;">

              <input name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>

              &nbsp;<span id="userNameStatusText"></span> </div>
			  </div>
			  <div class="clr"></div>
			<div style="height:50" class="prof_txt">
            <div class="prof_left" style="width:30%; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span>:</div>

            <div style="width:<?php echo ($this->config->item('page_width')/10)-28;?>%; float:left;height:30px;">

              <input name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['userTagName'];?>" readonly="readonly"/>

            </div>
			</div>
			<div class="clr"></div>

            <div style=" width:<?php echo ($this->config->item('page_width')/10)-28;?>%; margin-top:10px; float:left; margin-left:210px ">

              <input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>

              <input type="hidden" name="userCommunity"  id="userCommunity" value="<?php echo $Profiledetail['userCommunityId']; ?>" />

              <input type="hidden" name="userId" class="hidden" id="userId" size="30" value="<?php echo $Profiledetail['userId'];?>"/>

              <input type="hidden" name="workSpaceId" class="hidden" id="workSpaceId" size="30" value="<?php echo $workSpaceId;?>"/>

             <input type="hidden" name="workSpaceType" class="hidden" id="workSpaceType" size="30" value="<?php echo $workSpaceType;?>"/>

              <input type="hidden" name="userPassword" class="hidden" id="userPassword" size="30" value="<?php echo $Profiledetail['password'];?>"/>

              <input type="button" name="Submit" value="<?php echo $this->lang->line('txt_Save');?>" class="button01" onClick="return validateWorkPlaceMemberEdit('document.frmWorkPlace','<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>','<?php echo base_url();?>edit_workplace_member/uploadImage');"/>

              <!--<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="hidePopWin(false);" />-->

            </div>

          </div>

        </form>

    </div>

    

    

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

            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

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

            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

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

			{?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($setttings['defaultSpace'] == $workSpaceData['workSpaceId'] || ($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2)) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php

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
		foreach($notification_user_preferences as $keyVal=>$userPreferenceData)
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
			
			
			
		}
		
		foreach($notification_email_preferences as $emailPreferenceData)
		{
			if($emailPreferenceData['notification_modes_id']==2)
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
				//$urgentEmailNotification = $emailPreferenceData['preference'];
			}
			/*if($emailPreferenceData['notification_modes_id']==7)
			{
				$personalizeEmailNotification = $emailPreferenceData['preference'];
			}
			if($emailPreferenceData['notification_modes_id']==8)
			{
				$summarizeEmailNotification = $emailPreferenceData['preference'];
			}*/
			
		}
		
		foreach($notification_language_preferences as $languagePreferenceData)
		{
			if($languagePreferenceData['notification_language_id']==1)
			{
				$languageStatus = $languagePreferenceData['notification_language_id'];
			}
			if($languagePreferenceData['notification_language_id']==2)
			{
				$languageStatus = $languagePreferenceData['notification_language_id'];
			}
		}
		//echo $treeCreateStatus;
	?>
	
	<div id="notificationSection" >
		<div class="notification_head">
			<p><?php echo $this->lang->line('txt_notifications_settings_title'); ?></p>
		</div>
		<div class="emailNotification">
			<div>
				<p class="email_notify_head"><?php echo $this->lang->line('txt_Email'); ?></p>
				<div>
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_receive_email_notification'); ?>
				</div>
				<div class="rightSection">
					
	<input type="checkbox" id="neverEmail" name="emailPreference[]" onclick="disableEmailPreference();" value="2" <?php if($neverEmailStatus=='1') { echo 'checked'; }?>> <?php echo $this->lang->line('txt_email_notify_never'); ?>						    
	
	<input type="checkbox" id="emailOneHour" name="emailPreference[]" onclick="disableNeverPreference();" value="3" <?php if($EmailOneHourStatus=='1') { echo 'checked'; }?>><?php echo $this->lang->line('txt_email_notify_every_hour'); ?>
	
	<input type="checkbox" id="email24Hour" name="emailPreference[]" onclick="disableNeverPreference();" value="4" <?php if($Email24HourStatus=='1') { echo 'checked'; }?>><?php echo $this->lang->line('txt_email_notify_24_hour'); ?>
					
				</div>
				</div>
				
				<div style="margin-top:20px;">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_email_notification_type'); ?>
				</div>
				<div class="rightSection">
				
					<input type="checkbox" id="all" name="emailPreference[]" value="5" <?php if($allEmailNotification=='1') { echo 'checked'; }?>> <?php echo $this->lang->line('txt_all_email_notification'); ?>						    
	
	<input type="checkbox" id="personalized" name="emailPreference[]" value="6" <?php if($personalizeEmailNotification=='1') { echo 'checked'; }?>><?php echo $this->lang->line('txt_personalize_email_notification'); ?>
				
					<?php /* 5=all emails, 6=urgent emails */ ?>
					<?php /*?><select name="email_notification_type">
						<option value="5" <?php if($allEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_all_email_notification'); ?></option>
						<option value="6" <?php if($urgentEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_urgent_email_notification'); ?></option>	
						<option value="7" <?php if($personalizeEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_personalize_email_notification'); ?></option>
						<option value="8" <?php if($summarizeEmailNotification=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_summarize_email_notification'); ?></option>
					</select><?php */?>
					
				</div>
				</div>
				<!--Language section start-->
				<p class="email_notify_head"><?php echo $this->lang->line('txt_Language'); ?></p>
				<div>
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_notification_language'); ?>
				</div>
				<div class="rightSection">
					<select name="language">
						<option value="eng" <?php if($languageStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_english_language'); ?></option>
						<option value="jpn" <?php if($languageStatus=='2'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_japanese_language'); ?></option>
					</select>
				</div>
				</div>
				<!--Language section end-->
				
			</div>
			<div class="clear"></div>
			<div style="padding-top:0px;">
			
				
				<!--Tree section start-->
				<!-- Option value means 1=status,1=type_id,1=action_type_id -->
				<div>
				<div class="preference_head" style="float:left; width:34%;">
					<p class="email_notify_subhead" ><?php echo $this->lang->line('txt_Tree'); ?></p>
				</div>
				<?php /*?><div style="float:left;">
					<p class="email_notify_subhead" >Urgent</p>
				</div><?php */?>
				</div>
				<div class="clr"></div>
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_tree_created');?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="tree_create" value="0,1,1" />
					  <input class="switch-input" name="tree_create" type="checkbox" value="1,1,1" <?php if($treeCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span> 
					</label>
					
					<?php /*?><select name="tree_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,1" <?php if($treeCreateStatus=='1'){ ?> selected <?php } ?> ><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,1" <?php if($treeCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /* 0,1,1,1 0=preference, 1=object, 1=action, 1=urgent status */ ?>
					<?php /*?><input name="tree_create_urgent" type="hidden" value="0,1,1,0">
					<input name="tree_create_urgent" class="urgent_notify" type="checkbox" value="0,1,1,1" <?php if($treeCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
					
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_tree_title_edited'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="tree_title_edit" value="0,1,2" />
					  <input class="switch-input" name="tree_title_edit" type="checkbox" value="1,1,2" <?php if($treeEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span> 
					</label>
					<?php /*?><select name="tree_title_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,2" <?php if($treeEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,2" <?php if($treeEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="tree_title_edit_urgent" type="hidden" value="0,1,2,0">
					<input name="tree_title_edit_urgent" class="urgent_notify" type="checkbox" value="0,1,2,1" <?php if($treeEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_new_tree_version_created'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="tree_version_create" value="0,1,14" />
					  <input class="switch-input" name="tree_version_create" type="checkbox" value="1,1,14" <?php if($treeNewVersionStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="tree_version_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,14" <?php if($treeNewVersionStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,14" <?php if($treeNewVersionStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="tree_version_create_urgent" type="hidden" value="0,1,14,0">
					<input name="tree_version_create_urgent" class="urgent_notify" type="checkbox" value="0,1,14,1" <?php if($treeNewVersionUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_tree_started'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="tree_start" value="0,1,5" />
					  <input class="switch-input" name="tree_start" type="checkbox" value="1,1,5" <?php if($treeStartStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="tree_start">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,5" <?php if($treeStartStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,5" <?php if($treeStartStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="tree_start_urgent" type="hidden" value="0,1,5,0">
					<input name="tree_start_urgent" class="urgent_notify" type="checkbox" value="0,1,5,1" <?php if($treeStartUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_tree_stopped'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="tree_stop" value="0,1,6" />
					  <input class="switch-input" name="tree_stop" type="checkbox" value="1,1,6" <?php if($treeStopStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="tree_stop">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,6" <?php if($treeStopStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,6" <?php if($treeStopStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="tree_stop_urgent" type="hidden" value="0,1,6,0">
					<input name="tree_stop_urgent" class="urgent_notify" type="checkbox" value="0,1,6,1" <?php if($treeStopUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_tree_moved_to_space'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="tree_move" value="0,1,11" />
					  <input class="switch-input" name="tree_move" type="checkbox" value="1,1,11" <?php if($treeMoveStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="tree_move">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,1,11" <?php if($treeMoveStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,1,11" <?php if($treeMoveStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="tree_move_urgent" type="hidden" value="0,1,11,0">
					<input name="tree_move_urgent" class="urgent_notify" type="checkbox" value="0,1,11,1" <?php if($treeMoveUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_contributor_assigned'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="contributor_assign" value="0,14,9" />
					  <input class="switch-input" name="contributor_assign" type="checkbox" value="1,14,9" <?php if($contributorAssignStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="contributor_assign">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,14,9" <?php if($contributorAssignStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,14,9" <?php if($contributorAssignStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="contributor_assign_urgent" type="hidden" value="0,14,9,0">
					<input name="contributor_assign_urgent" class="urgent_notify" type="checkbox" value="0,14,9,1" <?php if($contributorAssignUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_contributor_removed'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="contributor_remove" value="0,14,10" />
					  <input class="switch-input" name="contributor_remove" type="checkbox" value="1,14,10" <?php if($contributorUnassignStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="contributor_remove">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,14,10" <?php if($contributorUnassignStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,14,10" <?php if($contributorUnassignStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="contributor_remove_urgent" type="hidden" value="0,14,10,0">
					<input name="contributor_remove_urgent" class="urgent_notify" type="checkbox" value="0,14,10,1" <?php if($contributorUnassignUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--Tree section end-->
				
				<!--Leaf section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Leaf'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_leaf_created'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="leaf_create" value="0,2,1" />
					  <input class="switch-input" name="leaf_create" type="checkbox" value="1,2,1" <?php if($leafCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="leaf_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,2,1" <?php if($leafCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,2,1" <?php if($leafCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="leaf_create_urgent" type="hidden" value="0,2,1,0">
					<input name="leaf_create_urgent" class="urgent_notify" type="checkbox" value="0,2,1,1" <?php if($leafCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_leaf_edited'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="leaf_edit" value="0,2,2" />
					  <input class="switch-input" name="leaf_edit" type="checkbox" value="1,2,2" <?php if($leafEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="leaf_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,2,2" <?php if($leafEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,2,2" <?php if($leafEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="leaf_edit_urgent" type="hidden" value="0,2,2,0">
					<input name="leaf_edit_urgent" class="urgent_notify" type="checkbox" value="0,2,2,1" <?php if($leafEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--Leaf section end-->
				
				<!--Post section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Post'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_post_added'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="post_add" value="0,3,1" />
					  <input class="switch-input" name="post_add" type="checkbox" value="1,3,1" <?php if($postCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="post_add">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,3,1" <?php if($postCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,3,1" <?php if($postCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="post_add_urgent" type="hidden" value="0,3,1,0">
					<input name="post_add_urgent" class="urgent_notify" type="checkbox" value="0,3,1,1" <?php if($postCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_post_comment_added'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="post_comment_add" value="0,3,13" />
					  <input class="switch-input" name="post_comment_add" type="checkbox" value="1,3,13" <?php if($postCommentStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="post_comment_add">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,3,13" <?php if($postCommentStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,3,13" <?php if($postCommentStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="post_comment_add_urgent" type="hidden" value="0,3,13,0">
					<input name="post_comment_add_urgent" class="urgent_notify" type="checkbox" value="0,3,13,1" <?php if($postCommentUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--Post section end-->
				
				<!--Tag section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_tag'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_simple_tag_created'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="simple_tag_create" value="0,4,1" />
					  <input class="switch-input" name="simple_tag_create" type="checkbox" value="1,4,1" <?php if($simpleTagCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="simple_tag_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,4,1" <?php if($simpleTagCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,4,1" <?php if($simpleTagCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="simple_tag_create_urgent" type="hidden" value="0,4,1,0">
					<input name="simple_tag_create_urgent" class="urgent_notify" type="checkbox" value="0,4,1,1" <?php if($simpleTagCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_simple_tag_applied'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="simple_tag_apply" value="0,4,4" />
					  <input class="switch-input" name="simple_tag_apply" type="checkbox" value="1,4,4" <?php if($simpleTagApplyStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="simple_tag_apply">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,4,4" <?php if($simpleTagApplyStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,4,4" <?php if($simpleTagApplyStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="simple_tag_apply_urgent" type="hidden" value="0,4,4,0">
					<input name="simple_tag_apply_urgent" class="urgent_notify" type="checkbox" value="0,4,4,1" <?php if($simpleTagApplyUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_simple_tag_removed'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="simple_tag_remove" value="0,4,3" />
					  <input class="switch-input" name="simple_tag_remove" type="checkbox" value="1,4,3" <?php if($simpleTagDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="simple_tag_remove">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,4,3" <?php if($simpleTagDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,4,3" <?php if($simpleTagDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="simple_tag_remove_urgent" type="hidden" value="0,4,3,0">
					<input name="simple_tag_remove_urgent" class="urgent_notify" type="checkbox" value="0,4,3,1" <?php if($simpleTagDeleteUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_action_tag_applied'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="action_tag_apply" value="0,5,4" />
					  <input class="switch-input" name="action_tag_apply" type="checkbox" value="1,5,4" <?php if($actionTagApplyStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="action_tag_apply">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,5,4" <?php if($actionTagApplyStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,5,4" <?php if($actionTagApplyStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="action_tag_apply_urgent" type="hidden" value="0,5,4,0">
					<input name="action_tag_apply_urgent" class="urgent_notify" type="checkbox" value="0,5,4,1" <?php if($actionTagApplyUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_action_tag_edit'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="action_tag_edit" value="0,5,2" />
					  <input class="switch-input" name="action_tag_edit" type="checkbox" value="1,5,2" <?php if($actionTagEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="action_tag_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,5,2" <?php if($actionTagEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,5,2" <?php if($actionTagEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="action_tag_edit_urgent" type="hidden" value="0,5,2,0">
					<input name="action_tag_edit_urgent" class="urgent_notify" type="checkbox" value="0,5,2,1" <?php if($actionTagEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_action_tag_delete'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="action_tag_delete" value="0,5,3" />
					  <input class="switch-input" name="action_tag_delete" type="checkbox" value="1,5,3" <?php if($actionTagDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="action_tag_delete">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,5,3" <?php if($actionTagDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,5,3" <?php if($actionTagDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="action_tag_delete_urgent" type="hidden" value="0,5,3,0">
					<input name="action_tag_delete_urgent" class="urgent_notify" type="checkbox" value="0,5,3,1" <?php if($actionTagDeleteUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_contact_tag_applied'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="contact_tag_apply" value="0,6,4" />
					  <input class="switch-input" name="contact_tag_apply" type="checkbox" value="1,6,4" <?php if($contactTagApplyStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="contact_tag_apply">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,6,4" <?php if($contactTagApplyStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,6,4" <?php if($contactTagApplyStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="contact_tag_apply_urgent" type="hidden" value="0,6,4,0">
					<input name="contact_tag_apply_urgent" class="urgent_notify" type="checkbox" value="0,6,4,1" <?php if($contactTagApplyUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions">
					<?php echo $this->lang->line('txt_contact_tag_removed'); ?>
				</div>
				<div>
					<label class="switch">
					  <input type="hidden" name="contact_tag_remove" value="0,6,3" />
					  <input class="switch-input" name="contact_tag_remove" type="checkbox" value="1,6,3" <?php if($contactTagDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="contact_tag_remove">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,6,3" <?php if($contactTagDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,6,3" <?php if($contactTagDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="contact_tag_remove_urgent" type="hidden" value="0,6,3,0">
					<input name="contact_tag_remove_urgent" class="urgent_notify" type="checkbox" value="0,6,3,1" <?php if($contactTagDeleteUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--Tag section end-->
				
				<!--Link section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Link'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_link_applied'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="link_apply" value="0,7,4" />
					  <input class="switch-input" name="link_apply" type="checkbox" value="1,7,4" <?php if($linkApplyStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="link_apply">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,7,4" <?php if($linkApplyStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,7,4" <?php if($linkApplyStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="link_apply_urgent" type="hidden" value="0,7,4,0">
					<input name="link_apply_urgent" class="urgent_notify" type="checkbox" value="0,7,4,1" <?php if($linkApplyUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<?php /*?><div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_link_removed'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="link_remove" value="0,7,3" />
					  <input  class="switch-input" name="link_remove" type="checkbox" value="1,7,3" <?php if($linkDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<select name="link_remove">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,7,3" <?php if($linkDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,7,3" <?php if($linkDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
					<input name="link_remove_urgent" type="hidden" value="0,7,3,0">
					<input name="link_remove_urgent" class="urgent_notify" type="checkbox" value="0,7,3,1" <?php if($linkDeleteUrgentStatus=='1'){ ?> checked <?php } ?>>
				</div>
				</div>
				<div class="clear"></div><?php */?>
				
				<!--Link section end-->
				
				
				<!--Talk section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Talk'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_talk_comment_added'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="talk_comment_add" value="0,8,13" />
					  <input class="switch-input" name="talk_comment_add" type="checkbox" value="1,8,13" <?php if($talkCommentStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="talk_comment_add">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,8,13" <?php if($talkCommentStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,8,13" <?php if($talkCommentStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="talk_comment_add_urgent" type="hidden" value="0,8,13,0">
					<input name="talk_comment_add_urgent" class="urgent_notify" type="checkbox" value="0,8,13,1" <?php if($talkCommentUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--Talk section end-->
				
				
				<!--File section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_file'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_file_imported'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="file_import" value="0,9,12" />
					  <input class="switch-input" name="file_import" type="checkbox" value="1,9,12" <?php if($fileImportStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="file_import">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,9,12" <?php if($fileImportStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,9,12" <?php if($fileImportStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="file_import_urgent" type="hidden" value="0,9,12,0">
					<input name="file_import_urgent" class="urgent_notify" type="checkbox" value="0,9,12,1" <?php if($fileImportUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_imported_file_delete'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="file_delete" value="0,9,3" />
					  <input class="switch-input" name="file_delete" type="checkbox" value="1,9,3" <?php if($fileDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="file_delete">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,9,3" <?php if($fileDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,9,3" <?php if($fileDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="file_delete_urgent" type="hidden" value="0,9,3,0">
					<input name="file_delete_urgent" class="urgent_notify" type="checkbox" value="0,9,3,1" <?php if($fileDeleteUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<!--File section end-->
				
				
				<!--Space section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Workspace'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_space_create'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="space_create" value="0,10,1" />
					  <input class="switch-input" name="space_create" type="checkbox" value="1,10,1" <?php if($spaceCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="space_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,10,1" <?php if($spaceCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,10,1" <?php if($spaceCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="space_create_urgent" type="hidden" value="0,10,1,0">
					<input name="space_create_urgent" class="urgent_notify" type="checkbox" value="0,10,1,1" <?php if($spaceCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_space_edit'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="space_edit" value="0,10,2" />
					  <input class="switch-input" name="space_edit" type="checkbox" value="1,10,2" <?php if($spaceEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="space_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,10,2" <?php if($spaceEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,10,2" <?php if($spaceEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="space_edit_urgent" type="hidden" value="0,10,2,0">
					<input name="space_edit_urgent" class="urgent_notify" type="checkbox" value="0,10,2,1" <?php if($spaceEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_space_suspend'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="space_suspend" value="0,10,8" />
					  <input class="switch-input" name="space_suspend" type="checkbox" value="1,10,8" <?php if($spaceSuspendStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="space_suspend">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,10,8" <?php if($spaceSuspendStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,10,8" <?php if($spaceSuspendStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="space_suspend_urgent" type="hidden" value="0,10,8,0">
					<input name="space_suspend_urgent" class="urgent_notify" type="checkbox" value="0,10,8,1" <?php if($spaceSuspendUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_space_activate'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="space_activate" value="0,10,7" />
					  <input class="switch-input" name="space_activate" type="checkbox" value="1,10,7" <?php if($spaceActivateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="space_activate">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,10,7" <?php if($spaceActivateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,10,7" <?php if($spaceActivateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="space_activate_urgent" type="hidden" value="0,10,7,0">
					<input name="space_activate_urgent" class="urgent_notify" type="checkbox" value="0,10,7,1" <?php if($spaceActivateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_subspace_create'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="subSpace_create" value="0,11,1" />
					  <input class="switch-input" name="subSpace_create" type="checkbox" value="1,11,1" <?php if($subSpaceCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="subSpace_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,11,1" <?php if($subSpaceCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,11,1" <?php if($subSpaceCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="subSpace_create_urgent" type="hidden" value="0,11,1,0">
					<input name="subSpace_create_urgent" class="urgent_notify" type="checkbox" value="0,11,1,1" <?php if($subSpaceCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_subspace_edit'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="subSpace_edit" value="0,11,2" />
					  <input class="switch-input" name="subSpace_edit" type="checkbox" value="1,11,2" <?php if($subSpaceEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="subSpace_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,11,2" <?php if($subSpaceEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,11,2" <?php if($subSpaceEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="subSpace_edit_urgent" type="hidden" value="0,11,2,0">
					<input name="subSpace_edit_urgent" class="urgent_notify" type="checkbox" value="0,11,2,1" <?php if($subSpaceEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_subspace_suspend'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="subSpace_suspend" value="0,11,8" />
					  <input class="switch-input" name="subSpace_suspend" type="checkbox" value="1,11,8" <?php if($subSpaceSuspendStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="subSpace_suspend">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,11,8" <?php if($subSpaceSuspendStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,11,8" <?php if($subSpaceSuspendStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="subSpace_suspend_urgent" type="hidden" value="0,11,8,0">
					<input name="subSpace_suspend_urgent" class="urgent_notify" type="checkbox" value="0,11,8,1" <?php if($subSpaceSuspendUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_subspace_activate'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="subSpace_activate" value="0,11,7" />
					  <input class="switch-input" name="subSpace_activate" type="checkbox" value="1,11,7" <?php if($subSpaceActivateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="subSpace_activate">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,11,7" <?php if($subSpaceActivateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,11,7" <?php if($subSpaceActivateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="subSpace_activate_urgent" type="hidden" value="0,11,7,0">
					<input name="subSpace_activate_urgent" class="urgent_notify" type="checkbox" value="0,11,7,1" <?php if($subSpaceActivateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
								
				<!--Space section end-->
				
				
				<!--Place section start-->
				<div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_Workplace'); ?></p>
				</div>
				
				<?php /*?><div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_create'); ?>
				</div>
				<div class="rightSection">
					<select name="place_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,12,1" <?php if($placeCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,12,1" <?php if($placeCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_edit'); ?>
				</div>
				<div class="rightSection">
					<select name="place_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,12,2" <?php if($placeEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,12,2" <?php if($placeEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_suspend'); ?>
				</div>
				<div class="rightSection">
					<select name="place_suspend">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,12,8" <?php if($placeSuspendStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,12,8" <?php if($placeSuspendStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_activate'); ?>
				</div>
				<div class="rightSection">
					<select name="place_activate">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,12,7" <?php if($placeActivateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,12,7" <?php if($placeActivateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div><?php */ ?>
								
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_manager_create'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="place_manager_create" value="0,16,1" />
					  <input class="switch-input" name="place_manager_create" type="checkbox" value="1,16,1" <?php if($placeManagerCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="place_manager_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,16,1" <?php if($placeManagerCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,16,1" <?php if($placeManagerCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="place_manager_create_urgent" type="hidden" value="0,16,1,0">
					<input name="place_manager_create_urgent" class="urgent_notify" type="checkbox" value="0,16,1,1" <?php if($placeManagerCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_manager_edit'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="place_manager_edit" value="0,16,2" />
					  <input class="switch-input" name="place_manager_edit" type="checkbox" value="1,16,2" <?php if($placeManagerEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="place_manager_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,16,2" <?php if($placeManagerEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,16,2" <?php if($placeManagerEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="place_manager_edit_urgent" type="hidden" value="0,16,2,0">
					<input name="place_manager_edit_urgent" class="urgent_notify" type="checkbox" value="0,16,2,1" <?php if($placeManagerEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_manager_suspend'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="place_manager_suspend" value="0,16,8" />
					  <input class="switch-input" name="place_manager_suspend" type="checkbox" value="1,16,8" <?php if($placeManagerSuspendStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="place_manager_suspend">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,16,8" <?php if($placeManagerSuspendStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,16,8" <?php if($placeManagerSuspendStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="place_manager_suspend_urgent" type="hidden" value="0,16,8,0">
					<input name="place_manager_suspend_urgent" class="urgent_notify" type="checkbox" value="0,16,8,1" <?php if($placeManagerSuspendUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_manager_activate'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="place_manager_activate" value="0,16,7" />
					  <input class="switch-input" name="place_manager_activate" type="checkbox" value="1,16,7" <?php if($placeManagerActivateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="place_manager_activate">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,16,7" <?php if($placeManagerActivateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,16,7" <?php if($placeManagerActivateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="place_manager_activate_urgent" type="hidden" value="0,16,7,0">
					<input name="place_manager_activate_urgent" class="urgent_notify" type="checkbox" value="0,16,7,1" <?php if($placeManagerActivateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_member_create'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="member_create" value="0,15,1" />
					  <input class="switch-input" name="member_create" type="checkbox" value="1,15,1" <?php if($userCreateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="member_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,15,1" <?php if($userCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,15,1" <?php if($userCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="member_create_urgent" type="hidden" value="0,15,1,0">
					<input name="member_create_urgent" class="urgent_notify" type="checkbox" value="0,15,1,1" <?php if($userCreateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_member_edit'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="member_edit" value="0,15,2" />
					  <input class="switch-input" name="member_edit" type="checkbox" value="1,15,2" <?php if($userEditStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="member_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,15,2" <?php if($userEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,15,2" <?php if($userEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="member_edit_urgent" type="hidden" value="0,15,2,0">
					<input name="member_edit_urgent" class="urgent_notify" type="checkbox" value="0,15,2,1" <?php if($userEditUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_member_suspend'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="member_suspend" value="0,15,8" />
					  <input class="switch-input" name="member_suspend" type="checkbox" value="1,15,8" <?php if($userSuspendStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="member_suspend">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,15,8" <?php if($userSuspendStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,15,8" <?php if($userSuspendStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="member_suspend_urgent" type="hidden" value="0,15,8,0">
					<input name="member_suspend_urgent" class="urgent_notify" type="checkbox" value="0,15,8,1" <?php if($userSuspendUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_member_activate'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="member_activate" value="0,15,7" />
					  <input class="switch-input" name="member_activate" type="checkbox" value="1,15,7" <?php if($userActivateStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="member_activate">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,15,7" <?php if($userActivateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,15,7" <?php if($userActivateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="member_activate_urgent" type="hidden" value="0,15,7,0">
					<input name="member_activate_urgent" class="urgent_notify" type="checkbox" value="0,15,7,1" <?php if($userActivateUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_member_delete'); ?>
				</div>
				<div class="rightSection">
					<label class="switch">
					  <input type="hidden" name="member_delete" value="0,15,3" />
					  <input class="switch-input" name="member_delete" type="checkbox" value="1,15,3" <?php if($userDeleteStatus=='1'){ ?> checked <?php } ?> >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span>
					</label>
					<?php /*?><select name="member_delete">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,15,3" <?php if($userDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,15,3" <?php if($userDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select><?php */?>
					<?php /*?><input name="member_delete_urgent" type="hidden" value="0,15,3,0">
					<input name="member_delete_urgent" class="urgent_notify" type="checkbox" value="0,15,3,1" <?php if($userDeleteUrgentStatus=='1'){ ?> checked <?php } ?>><?php */?>
				</div>
				</div>
				<div class="clear"></div>
				
				<?php /*?><div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_place_backup_created'); ?>
				</div>
				<div class="rightSection">
					<select name="place_backup_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1"><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0"><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div><?php */?>				
								
				<!--Place section end-->
				
				<!--Admin section start-->
				<?php /*?><div>
				<p class="email_notify_subhead"><?php echo $this->lang->line('txt_admin'); ?></p>
				</div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_admin_add'); ?>
				</div>
				<div class="rightSection">
					<select name="admin_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,13,1" <?php if($adminCreateStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,13,1" <?php if($adminCreateStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_admin_edit'); ?>
				</div>
				<div class="rightSection">
					<select name="admin_edit">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,13,2" <?php if($adminEditStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,13,2" <?php if($adminEditStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div>
				
				<div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_admin_delete'); ?>
				</div>
				<div class="rightSection">
					<select name="admin_delete">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1,13,3" <?php if($adminDeleteStatus=='1'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0,13,3" <?php if($adminDeleteStatus=='0'){ ?> selected <?php } ?>><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div><?php */?>
								
				
				<?php /*?><div class="emailSettingOptions">
				<div class="settingOptions leftSection">
					<?php echo $this->lang->line('txt_instance_backup_created'); ?>
				</div>
				<div class="rightSection">
					<select name="instance_backup_create">
						<option value=""><?php echo $this->lang->line('txt_Select'); ?></option>
						<option value="1"><?php echo $this->lang->line('txt_email_notify_on'); ?></option>
						<option value="0"><?php echo $this->lang->line('txt_email_notify_off'); ?></option>
					</select>
				</div>
				</div>
				<div class="clear"></div><?php */?>
							
				<!--Admin section end-->
				
				
				
			</div>
		</div>
			<input type="submit" name="submit" value="<?php echo $this->lang->line('txt_Save'); ?>" class="button01 notificationBtn" />
			<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
	</div>
	
	
	<?php echo form_close();?>
	<!--Manoj: email notification tab end here-->
	  
	  <!--Manoj: Notification tab view end here-->
	  

    </div>

</div>
</div>
</div>
<?php $this->load->view('common/foot');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
<script>
function disableEmailPreference()
{
	if ($('input[id="neverEmail"]:checked').length > 0)
	{
		
		//$("#emailOneHour").attr("disabled", true);	
		$("#emailOneHour").prop( "checked" ,false);
		//$("#email24Hour").attr("disabled", true);	
		$("#email24Hour").prop( "checked" ,false);
	}
}

function disableNeverPreference()
{
	if($('input[id="emailOneHour"]:checked').length > 0 || $('input[id="email24Hour"]:checked').length > 0)
	{
		$("#neverEmail").prop( "checked" ,false);
		//$("#emailOneHour").attr("disabled", false);	
		//$("#email24Hour").attr("disabled", false);	
	}
}


</script>