<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Create Member</title>

<!--Manage place js css file-->
<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';		

</script>


<script>

function changeUserRole(thisVal)
{
	//alert(thisVal.value);
	var userRole = thisVal.value;
    if(userRole == "0")
	{           
		//$("#createDefaultSpace1").prop("checked", false);
		//$("#createDefaultSpace0").prop("checked", true);
    	$('#createDefaultSpace1').attr('disabled','disabled');  
		$('#createDefaultSpace0').attr('disabled','disabled');  
		
		//$("#isPlaceManager1").prop("checked", false);
		//$("#isPlaceManager0").prop("checked", true);
    	$('#isPlaceManager1').attr('disabled','disabled');  
		$('#isPlaceManager0').attr('disabled','disabled');
		     
    }
	else
	{
        $('#createDefaultSpace1').removeAttr('disabled');
		$('#createDefaultSpace0').removeAttr('disabled');  
		
		$('#isPlaceManager1').removeAttr('disabled');  
		$('#isPlaceManager0').removeAttr('disabled');
    }  
}

function changeTagName (val)

{

	document.getElementById('tagName').value = val.value;

	checkTagName(val,<?php echo $_SESSION['workPlaceId'];?>);

}

function showUserTagName ()

{

	var first_name 	= document.getElementById('firstName').value;

	var last_name 	= document.getElementById('lastName').value;

	

	if (first_name!='' && last_name!='')

	{

		var suggestion1 = first_name+'_'+last_name;

		var suggestion2 = last_name+'_'+first_name;

		var suggestion3 = first_name+last_name;

		var suggestion4 = last_name+first_name;

		var val='';
		

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion1+'"/>'+suggestion1+'&nbsp;';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion2+'"/>'+suggestion2+'<br>';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion3+'"/>'+suggestion3+'&nbsp;';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion4+'"/>'+suggestion4+'<br>';

		

		document.getElementById('userTagName').innerHTML = val;

		



	}

	else

	{

		document.getElementById('userTagName').innerHTML = '';

	}

}





function displayname(){

/*	if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__')

	{

		document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

	}*/

			//document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

			var suggestion1 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

			var suggestion2 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value+'_01';

			var suggestion3 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value+'_02';

			var suggestion4 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value;

			var suggestion5 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value+'_01';

			var suggestion6 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value+'_02';

			var suggestion7 = document.getElementById('first_name').value+document.getElementById('last_name').value;

			var suggestion8 = document.getElementById('first_name').value+document.getElementById('last_name').value+'_01';

			var suggestion9 = document.getElementById('first_name').value+document.getElementById('last_name').value+'_02';

			var suggestion10 = document.getElementById('last_name').value+document.getElementById('first_name').value;

			var suggestion11 = document.getElementById('last_name').value+document.getElementById('first_name').value+'_01';

			var suggestion12 = document.getElementById('last_name').value+document.getElementById('first_name').value+'_02';

			

			

			var suggestions = suggestion1+', '+suggestion2+', '+suggestion3+', '+suggestion4+', '+suggestion5+', '+suggestion6+', '+suggestion7+', '+suggestion8+', '+suggestion9+', '+suggestion10+', '+suggestion11+', '+suggestion12;

			

			document.getElementById('tagNameSuggestions').innerHTML=suggestions;



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

				//$this->load->view('common/artifact_tabs', $details);

			}
			*/
			 

			 ?>
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

				

			<form action="<?php echo base_url();?>add_workplace_member/add" method="post" enctype="multipart/form-data" name="frmWorkPlace" id="frmWorkPlace" onsubmit="return validateWorkPlaceMember(this)">

             		<div class="menu_new" >

           

						<ul class="tab_menu_new1">

                            <li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
							
							<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                            <li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                            <li><a href="<?php echo base_url()?>add_workplace_member" class="active"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

                           <?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

                            <li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>language"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
							<li><a href="<?php echo base_url()?>manage_workplace/configuration" ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>

                           <?php /*?> <li><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
						   
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

				<table width="100%" border="0" cellspacing="0" cellpadding="0"> 

                <tr>

                  <td class="subHeading" colspan="4">&nbsp;</td>

                </tr>
                <?php
				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
				{
				?>
                <tr>

                  <td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

                <?php
				}
				?>
                <tr>

                  <td colspan="4"><span id="teemeCommunity">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td  valign="middle"  align="right"class="text_gre1"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="userName" autocapitalize="off" class="text_gre1" id="userName" size="30" onkeyup="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $this->input->post('userName');?>"/>

&nbsp;<span id="userNameStatusText"></span></td>

                        </tr>

                        <tr>

                          <td  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_Password');?><span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="30" /></td>

                        </tr>

                        <tr>

                          <td  valign="middle"  align="right" class="text_gre1"><?php echo $this->lang->line('txt_Retype_Password');?><span class="text_red">*</span> </td>

                          <td align="center" valign="middle"  align="right" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" /></td>

                        </tr>

                        <tr>

                          <td  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" valign="top" class="text_gre1">

                            <input name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $this->input->post('firstName');?>"/>

                            <input type="hidden" name="userTitle" id="userTitle" value="" />

                          </td>

                        </tr>

                        <tr>

                          <td  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $this->input->post('lastName');?>"/>

                          </td>

                        </tr>
						
						<!--Nickname field start-->
						<tr>

                          <td  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_nick_name');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="nickName" class="text_gre1" id="nickName" size="30"  value="<?php echo $this->input->post('nickName');?>"/>
							<?php //echo $this->lang->line('txt_nick_name_format'); ?>

                          </td>

                        </tr>
						<!--Nickname field end-->

						<tr>

                          <td  valign="middle"  align="right" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Pattern');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
						  
						  <?php
							/*
                          <input name="tagName" type="text" autocapitalize="off" class="text_gre1" id="tagName" size="30" onfocus="checkTagName(this,<?php echo $_SESSION['workPlaceId'];?>)" onkeyup="checkTagName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $this->input->post('tagName');?>"/>&nbsp;<span id="tagNameStatusText"></span><br /><span style="color:#006600" id="tagNameSuggestions"></span>
						  */
						  ?>
						  
						      <input type="radio" name="tagNamePreference" value="f_l" <?php if( $this->input->post('tagNamePreference') != 'l_f' ) { echo 'checked'; }?>>firstname_lastname</input>
                              <input type="radio" name="tagNamePreference" value="l_f" <?php if( $this->input->post('tagNamePreference') == 'l_f' ) { echo 'checked'; }?>>lastname_firstname</input>



                          </td>

                        </tr>
						
						<!--User time zone view start here-->
						
						  <tr>

                          <td valign="middle"  align="right" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

							<select name="timezone" id="timezone">
							
								<option value='0' selected><?php echo $this->lang->line('select_time_zone_txt'); ?></option>
								<?php
								foreach($timezoneDetails as $timezoneData)
								{
								?>
								<!--Changed by Dashrath- show selected default timezone-->
								<option <?php if( $timezone == $timezoneData['timezoneid'] ) { echo 'selected'; }?> value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
								<?php	
								}
								?>
								
							</select>

                          

                          </td>

                        </tr>
						
						<!--User time zone view end here-->
						
						<?php
						/*
                        <tr>

                          <td  valign="middle"  align="right" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">

                          <div id="userTagName">

                          </div>

                          </td>

                        </tr>
						*/
						?>

                        <tr>

                          <td width="179"  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_Photo');?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" valign="top" class="text_gre1">

                            <input type="file" name="photo" class="text_gre1" id="photo" size="30" value="" /> (jpg, jpeg, png, gif only)

                          </td>

                        </tr>



                        <tr>

                          <td width="179"  valign="middle" align="right" class="text_gre1"><?php echo $this->lang->line('txt_Role');?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="role" class="text_gre1" id="role" size="30"  value="<?php echo $this->input->post('role');?>"/>

                          </td>

                        </tr>      

                        <tr style="display:none;">

                          <td width="179"  align="right" valign="middle"  class="text_gre1"><?php echo $this->lang->line('txt_Department');?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="512" align="left" class="text_gre">

                            <input name="department" class="text_gre1" id="department" size="30"  value="<?php echo $this->input->post('department');?>"/>

                          </td>

                        </tr>                   
                        <tr style="display:none;">

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_skills');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="skills" rows="3" id="skills" style="width:50%;"><?php echo $this->input->post('skills');?></textarea>

                          </td>

                        </tr>
                        

                        <tr>

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Status');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="status" rows="3" id="status" style="width:50%;"><?php echo $this->input->post('status');?></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          <td align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="address1" rows="3" id="address1" style="width:50%;"><?php echo $this->input->post('status');?></textarea></td>

                        </tr>

                        <tr style="display:none;">

                          <td align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left" class="text_gre1">

                            <input name="phone" class="text_gre1" id="phone" size="30" value="<?php echo $this->input->post('phone');?>"/>                </td>

                        </tr>

                        <tr>

                          <td align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>

                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left">

                            <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $this->input->post('mobile');?>"/></td>

                        </tr>                     

                        <tr style="display:none;">

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="otherMember" rows="3" id="otherMember" style="width:50%;"><?php echo $this->input->post('otherMember');?></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_as');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                                <select name="userGroup" id="userGroup" onchange="changeUserRole(this)">



                      				<option value="1"><?php echo $this->lang->line('txt_Employee');?></option>

                                    <option value="0"><?php echo $this->lang->line('txt_Guest');?></option>



                    			</select>

                          </td>

                        </tr>

                        

                         <tr>

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('assign_space_txt'); ?> 'Try Teeme'</td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="radio" name="createDefaultSpace" id="createDefaultSpace1" value="1" checked="checked" />Yes<input type="radio" name="createDefaultSpace" id="createDefaultSpace0" <?php if($this->input->post('createDefaultSpace') && $this->input->post('createDefaultSpace')=='0'){?> checked="checked"<?php }?> value="0" />No</td>

                        </tr> 

                        <tr>

                          <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_as_place_manager');?></td>

                          <td align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
                              
                              <input type="radio" name="isPlaceManager" id="isPlaceManager1" value="1" <?php if( $this->input->post('isPlaceManager') == 1 ) { echo 'checked'; }?>>Yes</input>
                              <input type="radio" name="isPlaceManager" id="isPlaceManager0" value="0" <?php if( $this->input->post('isPlaceManager') != 1 ) { echo 'checked'; }?>>No</input>

                          </td>

                        </tr>
						
						 <tr>

                          <td align="right" valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre"><input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>

                            	<input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Create');?>"/></td>

                        </tr>

                        



                        

                        <tr>

                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                        </tr>

                      </tbody>

                    </table>

                    </td>

                </tr>

              </table>

		      </form>

			  

			 </div>

			<!--Added by Dashrath- load notification side bar-->
			<?php $this->load->view('common/notification_sidebar.php');?>
			<!--Dashrath- code end-->

			</div>  

				

    
<?php $this->load->view('common/foot.php');?>
<?php //$this->load->view('common/footer');?>
</body>
</html>