<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Teeme</title><br />
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
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
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#BBBBBB">
  <tr>
    <td valign="top" style="background-image:url(<?php echo base_url();?>images/body-bg.gif); background-repeat:repeat-x">
        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top" style="background-image:url(<?php echo base_url();?>images/logo-bg.gif); background-repeat:repeat-x">
			<!-- header -->	
			<?php $this->load->view('common/admin_header'); ?>
			<!-- header -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="24%" height="8" align="left" valign="top"></td>
                  <td width="76%" align="left" valign="top"></td>
                </tr>
                <tr>
                  <td align="left" valign="top">
					<!-- Left Part-->			
					<?php 
					$this->load->view('admin/common/left_links');
					?>     
				<!-- end Right Part -->
					</td>
                  <td align="left" valign="top">
				<!-- Main Body -->
			  <form name="frmWorkPlaceEdit" id="frmWorkPlaceEdit" action="<?php echo base_url();?>admin/admin_home/update_work_place" method="post" onSubmit="return validateWorkPlaceEdit(this)">
              <table width="100%" border="0" cellspacing="3" cellpadding="3" style="border-left:1px solid #bbbbbb;" >
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
                  <td class="heading" colspan="4"><?php echo $this->lang->line('txt_Company_Registration');?></td>
                </tr>
                <tr>
                  <td colspan="4" class="tdSpace">&nbsp;</td>
                </tr>
                <tr>
                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Details');?></td>
                </tr>
                <tr>
                  <td colspan="4" class="tdSpace">
                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Workplace_Name');?></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="companyName" class="text_gre1" id="companyName2" size="30" value="<?php echo $workPlaceDetails['companyName'];?>" readonly="readonly"/>
                          </td>
                        </tr>
<tr>
                          <td width="135" align="left" valign="middle" class="text_gre1">Time zone<span class="text_red">*</span></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
<select name="place_timezone">
	<option value='0' selected> Select Time zone</option>
	<option value='1'>(GMT-12:00) International Date Line West</option>
	<option value='2'>(GMT-11:00) Midway Island Samoa</option>
	<option value='3'>(GMT-10:00) Hawaii</option>
	<option value='4'>(GMT-09:00) Alaska</option>
	<option value='5'>(GMT-08:00) Pacific Time (US & Canada); Tijuana</option>
	<option value='6'>(GMT-07:00) Arizona</option>
	<option value='7'>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
	<option value='8'>(GMT-07:00) Mountain Time (US & Canada)</option>
	<option value='9'>(GMT-06:00) Central America</option>
	<option value='10'>(GMT-06:00) Central Time (US & Canada)</option>
	<option value='11'>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
	<option value='12'>(GMT-06:00) Saskatchewan</option>
	<option value='13'>(GMT-05:00) Bogota, Lime, Quito</option>
	<option value='14'>(GMT-05:00) Eastern Time (US & Canada)</option>
	<option value='15'>(GMT-05:00) Indiana (East)</option>
	<option value='16'>(GMT-04:00) Atlantic Time (Canada)</option>
	<option value='17'>(GMT-04:00) Caracas, La Paz</option>
	<option value='18'>(GMT-04:00) Santiago</option>
	<option value='19'>(GMT-03:30) Newfoundland</option>
	<option value='20'>(GMT-03:00) Brasilia</option>
	<option value='21'>(GMT-03:00) Buenos Aires, Georgetown</option>
	<option value='22'>(GMT-03:00) Greenland</option>
	<option value='23'>(GMT-02:00) Mid-Atlantic</option>
	<option value='24'>(GMT-01:00) Azores</option>
	<option value='25'>(GMT-01:00) Cape Verde Is.</option>
	<option value='26'>(GMT) Casablanca, Monrovia</option>
	<option value='27'>(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
	<option value='28'>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
	<option value='29'>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
	<option value='30'>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
	<option value='31'>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
	<option value='32'>(GMT+01:00) West Central Africa</option>
	<option value='33'>(GMT+02:00) Athens, Istanbul, Minsk</option>
	<option value='34'>(GMT+02:00) Bucharest</option>
	<option value='35'>(GMT+02:00) Cairo</option>
	<option value='36'>(GMT+02:00) Harare, Pretoria</option>
	<option value='37'>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
	<option value='38'>(GMT+02:00) Jerusalem</option>
	<option value='39'>(GMT+03:00) Baghdad</option>
	<option value='40'>(GMT+03:00) Kuwait, Riyadh</option>
	<option value='41'>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
	<option value='42'>(GMT+03:00) Nairobi</option>
	<option value='43'>(GMT+03:30) Tehran</option>
	<option value='44'>(GMT+04:00) Abu Dhabi, Muscat</option>
	<option value='45'>(GMT+04:00) Baku, Tbilisi, Yerevan</option>
	<option value='46'>(GMT+04:30) Kabul</option>
	<option value='47'>(GMT+05:00) Ekaterinburg</option>
	<option value='48'>(GMT+05:00) Islamabad, Karachi, Tashkent</option>
	<option value='49'>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
	<option value='50'>(GMT+05.75) Kathmandu</option>
	<option value='51'>(GMT+06:00) Almaty, Novosibirsk</option>
	<option value='52'>(GMT+06:00) Astana, Dhaka</option>
	<option value='53'>(GMT+06:00) Sri Jayawardenepura</option>
	<option value='54'>(GMT+06:30) Rangoon</option>
	<option value='55'>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
	<option value='56'>(GMT+07:00) Krasnoyarsk</option>
	<option value='57'>(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi</option>
	<option value='58'>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
	<option value='59'>(GMT+08:00) Kuala Lumpur, Singapore</option>
	<option value='60'>(GMT+08:00) Perth</option>
	<option value='61'>(GMT+08:00) Taipei</option>
	<option value='62'>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
	<option value='63'>(GMT+09:00) Seoul</option>
	<option value='64'>(GMT+09:00) Yakutsk</option>
	<option value='65'>(GMT+09:30) Adelaide</option>
	<option value='66'>(GMT+09:30) Darwin</option>
	<option value='67'>(GMT+10:00) Brisbane</option>
	<option value='68'>(GMT+10:00) Canberra, Melbourne, Sydney</option>
	<option value='69'>(GMT+10:00) Guam, Port Moresby</option>
	<option value='70'>(GMT+10:00) Hobart</option>
	<option value='71'>(GMT+10:00) Vladivostok</option>
	<option value='72'>(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
	<option value='73'>(GMT+12:00) Auckland, Wellington</option>
	<option value='74'>(GMT+12:00) Figi, Kamchatka, Marshall Is.</option>
	<option value='75'>(GMT+13:00) Nuku'alofa</option>
</select>
                          
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?>1</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyAddress1" class="text_gre1" id="companyAddress1" size="30" value="<?php echo $workPlaceDetails['companyAddress1'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?>2</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyAddress2" class="text_gre1" id="companyAddress2" size="30" value="<?php echo $workPlaceDetails['companyAddress2'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_City');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyCity" class="text_gre1" id="companyCity" size="30" value="<?php echo $workPlaceDetails['companyCity'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_State');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyState" class="text_gre1" id="companyState" size="30" value="<?php echo $workPlaceDetails['companyState'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Country');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <select name="companyCountry" id="companyCountry">
                              <option label="select" value="">--Select--</option>
                              <?php								
								foreach( $countryDetails as $countryData )
								{
								?>
                              <option value="<?php echo $countryData['countryId'];?>" <?php if($countryData['countryId'] == $workPlaceDetails['companyCountry']) { echo 'selected'; }?>><?php echo $countryData['countryName'];?></option>
                              <?php
								}
								?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Zip');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyZip" class="text_gre1" id="companyZip" size="30" value="<?php echo $workPlaceDetails['companyZip'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyPhone" class="text_gre1" id="companyPhone" size="30" value="<?php echo $workPlaceDetails['companyPhone'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Fax');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="companyFax" class="text_gre1" id="companyFax" size="30" value="<?php echo $workPlaceDetails['companyFax'];?>" /></td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Manager_Details');?></td>
                </tr>
                <tr>
                  <td width="135" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Community_Name');?> </td>
                  <td width="5" align="center" valign="middle" bordercolor="#111111" class="text_gre"><strong>:</strong></td>
                  <td colspan="2"><span class="text_gre">
                    <select name="commId" onChange="openRegisterForm(this)" id="commId" disabled="disabled">
                      <?php
						
					foreach( $communityDetails as $communityData )
					{
					?>
                      <option value="<?php echo $communityData['communityId'];?>" <?php if( $communityData['communityId'] == $userDetails['userCommunityId'] ) { echo 'selected'; }?>><?php echo $communityData['communityName'];?></option>
                      <?php
					}
					?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td colspan="4">
                    <?php
					if($userDetails['userCommunityId'] == 1)
					{	
					?>
                    <span id="teemeCommunity">
                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="135" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" valign="top" class="text_gre1">
                            <input name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $userDetails['firstName'];?>" />
                            <input type="hidden" name="userTitle" id="userTitle" value="">
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $userDetails['lastName'];?>"/>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?>1</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="address1" class="text_gre1" id="address1" size="30"  value="<?php echo $userDetails['address1'];?>"/>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"> <?php echo $this->lang->line('txt_Address');?>2</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="address2" class="text_gre1" id="address2" size="30" value="<?php echo $userDetails['address2'];?>"/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_City');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="city" class="text_gre1" id="city" size="30" value="<?php echo $userDetails['city'];?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_State');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="state" class="text_gre1" id="state" size="30" value="<?php echo $userDetails['state'];?>" />
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Country');?></td>
                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left">
                            <select name="country" id="country">
                              <option label="select" value="">--Select--</option>
                              <?php								
								foreach( $countryDetails as $countryData )
								{
								?>
                              <option value="<?php echo $countryData['countryId'];?>" <?php if($countryData['countryId'] == $userDetails['country']) { echo 'selected'; }?>><?php echo $countryData['countryName'];?></option>
                              <?php
								}
								?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Zip');?></td>
                          <td align="center" valign="middle" class="text_gre1"> <span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="zip" class="text_gre1" id="zip" size="30" value="<?php echo $userDetails['zip'];?>"/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="phone" class="text_gre1" id="phone" size="30" value="<?php echo $userDetails['phone'];?>"/>
                (xxx-xxx-xxxx) </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>
                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left">
                            <input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $userDetails['mobile'];?>"/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1">&nbsp;</td>
                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>
                          <td align="left" class="text_gre">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Name');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="userName" class="text_gre1" id="userName" size="30" value="<?php echo $userDetails['userName'];?>" readonly="readonly"/>
&nbsp;<span id="userNameStatus"></span></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Password');?><span class="text_red">*</span></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="30" />
                              <input type="hidden" name="userPassword" value="<?php echo $userDetails['password'];?>"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?><span class="text_red">*</span></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span></td>
                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left">
                            <input name="email" class="text_gre1" id="email" size="30" value="<?php echo $userDetails['email'];?>"/></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Security_Question');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><?php echo $workPlaceDetails['securityQuestion'];?>
                          </td>
                        </tr>     
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Answer');?><span class="text_red">*</span></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input type="text" name="securityAnswer" id="securityAnswer" value="" /></td>
                        </tr> 
						<tr>
							<td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?></td>
							<td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
							<td align="left" class="text_gre"><input name="tagName" type="text" class="text_gre1" size="30" value="<?php echo $userDetails['tagName'];?>" readonly="readonly"/></td>
						</tr>  
						      
                        <tr>
                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                    </span>
                    <?php
					}
					else
					{
					?>
                    <span id="otherCommunity">
                    <table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="31%" align="left" valign="middle" class="text_gre1"> <span id="otherCommunityName">yahoo</span><?php echo ' ' .$this->lang->line('txt_Email');?></td>
                          <td width="2%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="67%" align="left" class="text_gre">
                            <input type="text" name="otherUserName" class="text_gre1" id="otherUserName" size="30" value="<?php echo $userDetails['userName'];?>" onKeyUp="checkUserName(this)"/>
                            <span id="userNameStatus1"></span> </td>
                        </tr>
						   <tr>
                         <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span> </td>
                         <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                         <td align="left" class="text_gre"><input name="tagName" type="text" class="text_gre1"  size="30" value="<?php echo $userDetails['tagName'];?>" readonly="readonly"/> </td>
                       </tr>      
                      </tbody>
                    </table>
                    </span>
                    <?php
					}
					?>
                  </td>
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
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>