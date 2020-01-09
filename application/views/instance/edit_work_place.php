<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Edit Place</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

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

</head>

<body>

<?php $this->load->view('common/admin_header'); ?>



        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

          

          <?php /*?><tr>

            <td align="left" valign="top">&nbsp;</td>

          </tr><?php */?>

        

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links');

					?>     

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

				<!-- Main Body -->

			  <form name="frmWorkPlaceEdit" id="frmWorkPlaceEdit" action="<?php echo base_url();?>instance/home/update_work_place" enctype="multipart/form-data" method="post" onSubmit="return validate_Work_Place_Edit(this)">

              <table width="100%" border="0" cellspacing="3" cellpadding="3">

                                  <tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">

					<?php /*	

                        	<ul class="rtabs">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>

            				</ul>

							*/

						?>	

							

							<div class="menu_new" >

            <ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places" ><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>
								
								<li><a href="<?php echo base_url()?>instance/home/edit_work_place/<?php echo  $workPlaceDetails['workPlaceId'];?>" class="active"><span><?php echo $this->lang->line('txt_Edit_Place');?></span></a></li>

            				</ul>

			<div class="clr"></div>

        </div>

                        </td>

					</tr>

                <?php
				//print_r ($workPlaceDetails);

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

                  <td class="heading" colspan="4"><?php echo $this->lang->line('txt_Edit_Place'); ?></td>

                </tr>

                
				<tr>

                  <td colspan="4"><b><?php echo $this->lang->line('txt_Workplace').': ';?></b><?php echo $workPlaceDetails['companyName'];?></td>

                </tr>

                <?php /*?><tr>

                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Details');?></td>

                </tr><?php */?>

                <tr>

                  <td colspan="4" class="tdSpace">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Workplace_Name');?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
						  
							<input type="hidden" name="companyName" class="text_gre1" id="companyName2" value="<?php echo $workPlaceDetails['companyName'];?>"/>
                            <input size="30" value="<?php echo $workPlaceDetails['companyName'];?>" disabled="disabled"/>

                          </td>

                        </tr>
                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('database_server_host'); ?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="server" class="text_gre1" id="server" size="30" value="<?php echo ($workPlaceDetails['server']); ?>" disabled="disabled"/></td>

                        </tr>

                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('database_server_user'); ?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="server_username" class="text_gre1" id="server_username" size="30" value="<?php echo  ($workPlaceDetails['server_username']); ?>" disabled="disabled"/></td>

                        </tr>


                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('instance_name_txt'); ?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="instance_name1" class="text_gre1" id="instance_name1" size="30" value="<?php echo $this->config->item('instanceName');?>" disabled="disabled"/></td>

                        </tr>

						<tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

<select name="timezone" id="timezone">

	<option value='0' <?php if($workPlaceDetails['placeTimezone']==0) {echo "selected";}?>> <?php echo $this->lang->line('select_time_zone_txt'); ?></option>

	<?php
	foreach($timezoneDetails as $timezoneData)
	{
	?>
	<option <?php if($workPlaceDetails['placeTimezone']==$timezoneData['timezoneid']) {echo "selected";}?> value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
	<?php	
	}
	?>

</select>

                          

                          </td>

                        </tr>
                        <tr>

                          	<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Company_Logo');?></td>

                          	<td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          	<td align="left" class="text_gre">
							<?php
								if ($workPlaceDetails['companyLogo']!='noimage.jpg')
								{
							?>
									<img class="clsCompanyImageThumb" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/place_logo/<?php echo $workPlaceDetails['companyLogo'];?>">
                          	<?php
								}
								else
								{
							?>
									<img class="clsCompanyImageThumb" src="<?php echo base_url();?>images/<?php echo $workPlaceDetails['companyLogo'];?>">
							<?php
								}
							?>
							<input type="file" name="companyLogo" class="text_gre1" id="companyLogo" size="30" value="" /><span class="clsLabel">(jpg, jpeg, png, gif only)</span> 

							</td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                          	<!--<input name="companyAddress1" class="text_gre1" id="companyAddress1" size="30" value="" />-->

                          	<textarea name="companyAddress1" rows="3" id="companyAddress1" style="width:50%;"><?php echo $workPlaceDetails['companyAddress1'];?></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="companyPhone" class="text_gre1" id="companyPhone" size="30" value="<?php echo $workPlaceDetails['companyPhone'];?>" /></td>

                        </tr>


                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="companyOther" rows="3" id="companyOther" style="width:50%;"><?php echo $workPlaceDetails['companyOther'];?></textarea>

                          </td>

                        </tr>
						<!--Manoj: No of users text field added-->
						 <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('number_of_users_txt'); ?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

               			<input name="num_of_users" class="text_gre1" id="num_of_users" size="2" value="<?php echo $workPlaceDetails['numOfUsers']; ?>" />	
						<span id="workPlaceStatusText" class="clsLabel"><?php echo $this->lang->line('leave_blank_for_unlimited_users'); ?>  <?php echo $this->lang->line('add_any_number_txt'); ?>	</span>																						                        
						 </td>

                        </tr>
						<!--Manoj: Code end-->
						
						<!--Manoj: Place expiration field added-->
						<?php /*?><tr>
							<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('place_Expire_Date_No_Limit');?></td>
							 <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
							 <td align="left" class="text_gre">
							 <input type="checkbox" id="expNoLimit" name="expNoLimit" onClick="calExpireCheck(this)">
							 </td>
						</tr><?php */?>
						<?php 
						$placeExpire=$workPlaceDetails['placeExpireDate'];
						if($placeExpire!='0000-00-00'){
							$placeExpireDate = $this->time_manager->getUserTimeFromGMTTime($placeExpire,'d-m-Y');
						}
						?>
						<tr>
						<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_place_Expire_Date');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

						<td align="left" class="text_gre">
						
						<input name="place_exp_date" type="text"  id="place_exp_date" class="expDate" value="<?php echo $placeExpireDate; ?>" readonly>
						<span id="workPlaceStatusText" class="clsLabel"><?php echo $this->lang->line('leave_blank_for_no_expiry'); ?> </span>	
						
						</td>
						</tr>
						<!--Manoj: code end-->
						
						<?php
						/*
						// Andy - Security question and answer don't make sense since the place is created by admins 
                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Security_Question');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

						    <select name="securityQuestion" class="text_gre1" id="securityQuestion"/>

                            	<option value="<?php echo $this->lang->line('txt_Security_Question_1');?>" <?php if ($workPlaceDetails['securityQuestion']==$this->lang->line('txt_Security_Question_1')) {echo "selected";}?>><?php echo $this->lang->line('txt_Security_Question_1');?>

                                <option value="<?php echo $this->lang->line('txt_Security_Question_2');?>" <?php if ($workPlaceDetails['securityQuestion']==$this->lang->line('txt_Security_Question_2')) {echo "selected";}?>><?php echo $this->lang->line('txt_Security_Question_2');?>

                            	<option value="<?php echo $this->lang->line('txt_Security_Question_3');?>" <?php if ($workPlaceDetails['securityQuestion']==$this->lang->line('txt_Security_Question_3')) {echo "selected";}?>><?php echo $this->lang->line('txt_Security_Question_3');?>

                            </select>

                          </td>

                        </tr>     

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Answer');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="text" name="securityAnswer" id="securityAnswer" value="<?php echo $workPlaceDetails['securityAnswer'];?>" /></td>

                        </tr> 
						*/
						?>

                      </tbody>

                  </table></td>

                </tr>

                <tr>

                  <td colspan="2">&nbsp;</td>

                  <td colspan="2"><input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Update');?>"></td>

                </tr>

              </table>

              <input type="hidden" name="communityId" id="communityId" value="<?php echo $userDetails['userCommunityId'];?>">

              <input type="hidden" name="workPlaceId" value="<?php echo $workPlaceDetails['workPlaceId'];?>">

              <input type="hidden" name="companyCreatedDate" value="<?php echo $workPlaceDetails['companyCreatedDate'];?>">

              <input type="hidden" name="workPlaceManagerId" value="<?php echo $workPlaceDetails['workPlaceManagerId'];?>">

              <input type="hidden" name="userId" value="<?php echo $userDetails['userId'];?>">

              <input type="hidden" id="securityAnswerStored" name="securityAnswerStored" value="<?php echo $workPlaceDetails['securityAnswer'];?>">

              <input type="hidden" name="userRegisteredDate" value="<?php echo $userDetails['registeredDate'];?>">

            </form>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

          <tr>

            <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>

          </tr>

         

        </table>

   

<?php $this->load->view('common/footer');?>
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
</script>