<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

</head>

<body>

<?php

/* else if($this->uri->segment(3)=='1')
				 { ?>
				 	<table width="100%" border="0" cellspacing="3" cellpadding="3" style="padding:3%;">
					<tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">
				 				<div class="successMsg"><?php echo $this->lang->line('txt_trial_place_url_email_sent');?></div>
						</td>
					</tr>
				</table>
				<?php
 }
*/
?>

<?php $this->load->view('common/admin_header'); ?>
<div id="container" style="padding-top:5px; width:89%;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr> 

    <td valign="top">

        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" cellpadding="0" cellspacing="0">

                 

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"> 

            	<table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php 

					//$this->load->view('instance/common/top_links');

					?>     

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                	<td align="left" valign="top">

					<!-- Main Body -->
				<?php if(($user_trial_place_status==1 || $trial_place_url_status==1) && $this->uri->segment(3)!='1')
				{
				 ?>
				 <table width="100%" border="0" cellspacing="3" cellpadding="3" style="padding:3%;">
					<tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">
				 				<div class="errorMsg"><?php echo $this->lang->line('txt_trial_place_already_create');?></div>
						</td>
					</tr>
				</table>
				 <?php 
				 }
				 else
				 { ?>
			  		<form name="frmWorkPlace" id="frmWorkPlace" action="<?php echo base_url();?>trial/add_trial" method="post" enctype="multipart/form-data" onSubmit="return validateTrialPlace(this);">

              		<table width="100%" border="0" cellspacing="3" cellpadding="3">

              		<tr>

                       <?php /*?>  <td colspan="4" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

           <ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place" class="active"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>

            				</ul>

			<div class="clr"></div>

        </div>

                        </td><?php */?>

					</tr>
					
					 <tr>

					  <td style="padding-bottom:2%;" colspan="4"><h1><?php echo $this->lang->line('txt_start_trial_heading');?></h1></td>
	
					</tr>


                <?php 

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

                  <td colspan="4" class="tdSpace"><div class="errorMsg"><div><b>Error(s):</b></div><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></div></td>

                </tr>

                <?php

				}

				

				?>

                <tr>

                  <td class="heading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Details');?></td>

                </tr>

				<?php /*?>  <tr>

                  <td colspan="4" class="tdSpace">&nbsp;</td>

                </tr><?php */?>

               <?php /*?> <tr>

                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Details');?></td>

                </tr><?php */?>

                <tr>

                  <td colspan="4" class="tdSpace">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Workplace_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="companyName" class="text_gre1" id="companyName" size="30" value="" onKeyUp="checkWorkPlace(this)"/>

            &nbsp;<span id="workPlaceStatusText" class="clsLabel"><?php echo $this->lang->line('lower_case_numbers_only_txt'); ?></span> </td>

                        </tr>

                       

                            <input type="hidden" name="server" class="text_gre1" id="server" size="30" value="<?php echo base64_decode ($this->config->item('hostname')); ?>"/>

                       
                            <input type="hidden" name="server_username" class="text_gre1" id="server_username" size="30" value="<?php echo base64_decode ($this->config->item('username')); ?>"/>

                            <input type="hidden" name="server_password" class="text_gre1" type="password" id="server_password" size="30" value="<?php echo base64_decode ($this->config->item('password')); ?>"/>

							<input type="hidden" name="instance_name" id="instance_name" size="30" value="<?php echo $this->config->item('instanceName');?>" type="hidden"/>

                            <input type="hidden" name="instance_name1" class="text_gre1" id="instance_name1" size="30" value="<?php echo $this->config->item('instanceName');?>" disabled="disabled"/>

                       

                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

								<select name="place_timezone" id="place_timezone">
								
									<option value='0' selected><?php echo $this->lang->line('select_time_zone_txt'); ?></option>
								
									<?php
									foreach($timezoneDetails as $timezoneData)
									{
									?>
									<option value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
									<?php	
									}
									?>
								
								</select>

                          

                          </td>

                        </tr>
						
                         <input type="hidden" name="createDefaultSpace" id="createDefaultSpace1" value="1" />

                        <tr>

                          	<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Company_Logo');?></td>

                          	<td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          	<td align="left" class="text_gre">

                          	<input type="file" name="companyLogo" class="text_gre1" id="companyLogo" size="30" value="" /> 
							&nbsp;
							<span id="workPlaceStatusText" class="clsLabel">(jpg, jpeg, png, gif only)</span>

							</td>

                        </tr>
						
						 <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                          	<!--<input name="companyAddress1" class="text_gre1" id="companyAddress1" size="30" value="" />-->

                          	<textarea name="companyAddress1" rows="3" id="companyAddress1" style="width:50%;"></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="companyPhone" class="text_gre1" id="companyPhone" size="30" value="" /></td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="companyOther" rows="3" id="companyOther" style="width:50%;"></textarea>

                          </td>

                        </tr>
                         
						<?php /*?><tr>

                          	<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('restore_place_txt'); ?></td>

                          	<td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          	<td align="left" class="text_gre">
							<input type="file" name="restorePlace" class="text_gre1" id="restorePlace" size="30" value="" /> 
							&nbsp;
							<span id="workPlaceStatusText" class="clsLabel"><?php echo $this->lang->line('upload_place_backup_file_txt'); ?></span>
							

							</td>

                        </tr><?php */?>
						
						
               			<input type="hidden" name="num_of_users" class="text_gre1" id="num_of_users" size="2" value="3" />	  
							
						
						<?php /*?><tr>
						
						<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_place_Expire_Date');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

						<td align="left" class="text_gre">
						
						<input name="place_exp_date" type="text"  id="place_exp_date" class="expDate" value="" readonly> <span id="workPlaceStatusText" class="clsLabel"><?php echo $this->lang->line('leave_blank_for_no_expiry'); ?> </span>
						
						</td>
						</tr><?php */?>
						
                          
                       <?php /*?> <tr>

                            <td colspan="2">&nbsp;</td>

                            <td >

                                <input type="hidden" name="communityId" value="1" id="communityId">

                                <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Create_Place');?>">
								

                            </td>

                        </tr><?php */?>

                      </tbody>

                  </table>
				  
				  <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse; margin-top:2%;" >

                      <tbody>
					  
					   <tr>

						  <td class="heading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Manager_Details');?></td>
		
						</tr>

						<tr>
						<td colspan="4" class="tdSpace" style="height:6px;">
						</td>
						</tr>
                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" valign="top" class="text_gre1">

                            <input name="firstName" class="text_gre1" id="firstName" size="30" value="" onkeyup="showUserTagName();" />

                            <input type="hidden" name="userTitle" id="userTitle" value="">

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="lastName" class="text_gre1" id="lastName" size="30"  value="" onkeyup="showUserTagName();" />

                          </td>

                        </tr>
						
						<!--Nickname field start-->
						<tr>
						
						  <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_nick_name');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="nickName" class="text_gre1" id="nickName" size="30"  value="" />

                          </td>

                        </tr>
						<!--Nickname field end-->
                         
						<tr>

                            <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name_Preference');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
						  
						  <?php
							/*
                          pm_ <input name="tagName" type="text" autocapitalize="off" class="text_gre1" id="tagName" size="30" onfocus="checkTagName(this,<?php echo $workPlaceId;?>,1)" onkeyup="checkTagName(this,<?php echo $workPlaceId;?>,1)" value="<?php echo $this->input->post('tagName');?>"/>&nbsp;<span id="tagNameStatusText"></span><br /><span style="color:#006600" id="tagNameSuggestions"></span>
							*/
							?>
							
						      <input type="radio" name="tagNamePreference" value="f_l" <?php if( $this->input->post('tagNamePreference') != 'l_f' ) { echo 'checked'; }?>>firstname_lastname</input>
                              <input type="radio" name="tagNamePreference" value="l_f" <?php if( $this->input->post('tagNamePreference') == 'l_f' ) { echo 'checked'; }?>>lastname_firstname</input>


                          </td>

                        </tr>
						
						<!--User time zone view start here-->
						
						  <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

							<select name="user_timezone" id="user_timezone">
							
								<option value='0' selected><?php echo $this->lang->line('select_time_zone_txt'); ?></option>
							
								<?php
								foreach($timezoneDetails as $timezoneData)
								{
								?>
								<option value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
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

                          <td align="left"  valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">

                          <div id="userTagName">

                          </div>

                          </td>

                        </tr>
						*/
						?>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="address1" rows="3" id="address1" style="width:50%;"></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          	<td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          	<td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>

                          	<td align="left" class="text_gre1">

                            	<input name="phone" class="text_gre1" id="phone" size="30" value=""/>

                			</td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>

                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left">

                            <input name="mobile" class="text_gre1" id="mobile" size="30" value=""/></td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="otherManager" rows="3" id="otherManager" style="width:50%;"></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">&nbsp;</td>

                        </tr>


                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?> <span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="hidden" name="email" class="text_gre1" id="email" size="30" value="<?php echo $email; ?>"/>
						  	   <input name="email1" class="text_gre1" id="email1" size="30" value="<?php echo $email; ?>" disabled="disabled"/>
							<input type="hidden" name="random_string" value="<?php echo $random_string; ?>" />
&nbsp;<span id="userNameStatusText"></span></td>

                        </tr>

                        <tr id="pass1">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Password');?><span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="30" /></td>

                        </tr>

                        <tr id="pass2">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" /></td>

                        </tr>	
					
						<tr>

                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                        </tr>

                        <tr>

                  <td colspan="2">&nbsp;</td>

                  <td >

                      <input type="hidden" name="communityId" value="1" id="communityId">

                      <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Create');?>"  />
					  
					  <input type="reset" name="reset" value="<?php echo $this->lang->line('txt_Cancel');?>"  />

                  </td>

                </tr>

                      </tbody>

                    </table>
				  
				  </td>

                </tr>

              </table>

              <input type="hidden" name="workPlaceStatus" value="1" id="workPlaceStatus">

            </form>
			<?php } ?>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

        </table>

    </td>

  </tr>



</table>
</div>

<!-- Footer -->	
<?php  $this->load->view('common/footer');?>
<!-- Footer -->
<!--Manoj: Added script of datepicker using load view-->
<?php $this->load->view('common/datepicker_js.php');?>

</body>

</html>
<script>
//Manoj: Added date picker for expire date of place
$(document).ready(function(){

	$('.expDate').datepicker({
			
			minDate:0,

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

		});

});
function calExpireCheck(thisVal)

{
	if(thisVal.checked == true)

	{
		$(".expDate").datepicker("option", "disabled", true);

		formName.starttime.style.color = "#000000";	

	}
	if (thisVal.checked!=true)
	{
		$(".expDate").datepicker("option", "disabled", false);
	}
}
//Manoj: Code end


function changeTagName (val)

{

	document.getElementById('tagName').value = val.value;

	checkTagName(val,<?php echo $workPlaceId;?>,1);

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