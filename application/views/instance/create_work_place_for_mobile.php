<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<title>Teeme > Create Place</title>

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

<?php $this->load->view('common/admin_header_for_mobile'); ?>

	<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links_for_mobile');

					?>     

					<!-- End Top Links -->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr> 

    <td valign="top">

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                 

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"> 

            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  

                  </td>

                </tr>

                <tr>

                	<td align="left" valign="top">

					<!-- Main Body -->

			  		<form name="frmWorkPlace" id="frmWorkPlace" action="<?php echo base_url();?>instance/home/add_work_place" method="post" enctype="multipart/form-data" onSubmit="return validateWorkPlace(this)">

              		<table width="100%" border="0" cellspacing="3" cellpadding="3">

              		<tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">

                        	<div class="tab_menu_new_up_for_mobile" >

            <ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place" class="active"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>

            				</ul>

			<div class="clr"></div>

        </div>

                        </td>

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

                  <td class="heading" colspan="3"><?php echo $this->lang->line('txt_Create_Workplace');?></td>

                </tr>

                

                <?php /*?><tr>

                  <td colspan="3" class="tdSpace">&nbsp;</td>

                </tr>

                <tr>

                  <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Workplace_Details');?></td>

                </tr><?php */?>

                <tr>

                  <td colspan="3" class="tdSpace">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="135" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Workplace') .' / ' .$this->lang->line('txt_Company_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre" valign="top">

                            <input name="companyName" class="text_gre1" id="companyName" size="20" value="" onKeyUp="checkWorkPlace(this)"/>

            &nbsp;<span id="workPlaceStatusText" style="font-size:11px"><?php echo $this->lang->line('lower_case_numbers_only_txt'); ?></span> </td>

                        </tr>

                        <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('database_server_host'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="server" class="text_gre1" id="server" size="20" value="<?php echo base64_decode ($this->config->item('hostname')); ?>"/></td>

                        </tr>

                         <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('database_server_user'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="server_username" class="text_gre1" id="server_username" size="20" value="<?php echo base64_decode ($this->config->item('username')); ?>"/></td>

                        </tr>

                         <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('database_server_password'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="server_password" class="text_gre1" id="server_password" type="password" size="20" value="<?php echo base64_decode ($this->config->item('password')); ?>"/></td>

                        </tr>

                         <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('instance_name_txt'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                          <input name="instance_name" id="instance_name" size="30" value="<?php echo $this->config->item('instanceName');?>" type="hidden"/>

                            <input name="instance_name" class="text_gre1" id="instance_name" size="20" value="<?php echo $this->config->item('instanceName');?>" disabled="disabled"/></td>

                        </tr>

                          <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

<select name="timezone" id="timezone" style="width:100%;">

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

                        <?php /*?> <tr>

                          	<td width="135" align="left" valign="middle" class="text_gre1"><?php //echo $this->lang->line('txt_Company_Logo');?></td>

                          	<td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          	<td align="left" class="text_gre">

                          	<input type="file" name="companyLogo" class="text_gre1" id="companyLogo" size="20" value="" /> 

							</td>

                        </tr><?php */?>
						
						
						 <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                          	<!--<input name="companyAddress1" class="text_gre1" id="companyAddress1" size="30" value="" />-->

                          	<textarea name="companyAddress1" rows="3" id="companyAddress1" style="width:90%;"></textarea>

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="companyPhone" class="text_gre1" id="companyPhone" size="20" value="" /></td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="companyOther" rows="3" id="companyOther" style="width:90%;"></textarea>

                          </td>

                        </tr>
						<?php /*?> <tr>

                          	<td width="135" align="left" valign="middle" class="text_gre1">Restore place from a backup</td>

                          	<td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          	<td align="left" class="text_gre">
							<input type="file" name="restorePlace" class="text_gre1" id="restorePlace" size="30" value="" /> (Upload a place backup file)

							</td>

                        </tr><?php */?>
						
						 <tr>

                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                        </tr>
						
						<!--Manoj: No of users text field added-->
						 <tr>

                          <td width="135" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('number_of_users_txt'); ?></td>

                          <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

               			<input name="num_of_users" class="text_gre1" id="num_of_users"  value="" />	<span style="font-size:11px"> <?php echo $this->lang->line('leave_blank_for_unlimited_users'); ?>  <?php echo $this->lang->line('add_any_number_txt'); ?>	</span>																			                        
						 </td>

                        </tr>
						<!--Manoj: Code end-->
						
						  <!--Manoj: place expiration field added-->
						 <?php /*?> <tr>
							<td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('place_Expire_Date_No_Limit');?></td>
							 <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
							 <td align="left" class="text_gre">
							 <input type="checkbox" id="expNoLimit" name="expNoLimit" onClick="calExpireCheck(this)">
							 </td>
						</tr><?php */?>
						<tr>
						<td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_place_Expire_Date');?></td>

                        <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

						<td>
						<input name="place_exp_date" type="text"  id="place_exp_date" class="expDate" data-field="date" value="" readonly>
						<span style="font-size:11px"><?php echo $this->lang->line('leave_blank_for_no_expiry'); ?> </span>
						
						</td>
						</tr>
						<div id="dtBoxPlace"></div>
						<!--Manoj: code end-->



                        <tr>

                          <td colspan="2">&nbsp;</td>

                          <td>

                                <input type="hidden" name="communityId" value="1" id="communityId">

                                <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Create_Place');?>" class="buttonLogin">

                          </td>

                        </tr>

                      </tbody>

                    </table>

                    <?php

					/*

				 	<table width="80%" border="0" cellpadding="3" cellspacing="3" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>                      

						 <tr>

                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="tagName" type="text" class="text_gre1" id="tagName" size="30" /></td>

                        </tr>

                      </tbody>

                    </table>

					*/

					?>

			 </td>

                </tr>

                

              </table>

              <input type="hidden" name="workPlaceStatus" value="1" id="workPlaceStatus">

            </form>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

          <tr>

            <td align="center" valign="top" class="copy">

			<!-- Footer -->	

				<?php $this->load->view('common/footer');?>

			<!-- Footer -->

			</td>

          </tr>

        </table>

    </td>

  </tr>



</table>
<!--Manoj: Added script of datepicker using load view -->
<?php $this->load->view('common/curious_calendar_for_mobile');?>

</body>

</html>

<script>
//Manoj: Added date picker for expire date of place
$(document).ready(function(){
	
	$("#dtBoxPlace").DateTimePicker();

});
function calExpireCheck(thisVal)

{
	if(thisVal.checked == true)

	{
		document.getElementById("place_exp_date").disabled = true;
	}
	if (thisVal.checked!=true)
	{
		document.getElementById("place_exp_date").disabled = false;
	}
}
//Manoj: Code end
</script>