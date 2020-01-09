<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
					<form action="<?php echo base_url();?>add_workplace_member/add" method="post" name="frmWorkPlace" id="frmWorkPlace" onsubmit="return validateWorkPlaceMember(this)">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
				 <tr>
                  <td colspan="4" class="tdSpace">
					<ul class="rtabs">
					<li><a href="<?php echo base_url()?>admin_help/view_topics"><span><?php echo $this->lang->line('txt_View_Topics');?></span></a></li>
					<li><a href="<?php echo base_url()?>admin_help/add_topic"><span><?php echo $this->lang->line('txt_Add_Topic');?></span></a></li>
					<li><a href="<?php echo base_url()?>admin_help/add_sub_topic"><span><?php echo $this->lang->line('txt_Add_Sub_Topic');?></span></a></li>
					<li><a href="<?php echo base_url()?>add_workplace_member" class="current"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>
				</ul>				
					</td>
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
                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Workplace_member_details');?></td>
                </tr>
                <tr>
                  <td class="subHeading" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td width="24%" valign="middle"><?php echo $this->lang->line('txt_Authentication_By');?> </td>
                  <td width="2%" align="center" valign="middle" bordercolor="#111111" class="text_gre"><strong>:</strong></td>
                  <td colspan="2" class="subHeading"><span class="text_gre">
                    <select name="communityId" id="communityId" onchange="openRegisterForm(this)">
                      <?php
						
					foreach( $communityDetails as $communityData )
					{
					?>
                      <option value="<?php echo $communityData['communityId'];?>" <?php if( $communityData['communityId'] == 1 ) { echo 'selected'; }?>><?php echo $communityData['communityName'];?></option>
                      <?php
					}
					?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td class="subHeading" colspan="4"><span id="teemeCommunity">
                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="179" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="512" align="left" valign="top" class="text_gre1">
                            <input name="firstName" class="text_gre1" id="firstName" size="30" value="" />
                            <input type="hidden" name="userTitle" id="userTitle" value="" />
                          </td>
                        </tr>
                        <tr>
                          <td width="179" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="512" align="left" class="text_gre">
                            <input name="lastName" class="text_gre1" id="lastName" size="30"  value=""/>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?>1</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="address1" class="text_gre1" id="address1" size="30"  value=""/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"> <?php echo $this->lang->line('txt_Address');?>2</td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                            <input name="address2" class="text_gre1" id="address2" size="30" value=""/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_City');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="city" class="text_gre1" id="city" size="30" value="" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_State');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="state" class="text_gre1" id="state" size="30" value="" />
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
                              <option value="<?php echo $countryData['countryId'];?>"><?php echo $countryData['countryName'];?></option>
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
                            <input name="zip" class="text_gre1" id="zip" size="30" value=""/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>
                          <td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left" class="text_gre1">
                            <input name="phone" class="text_gre1" id="phone" size="30" value=""/>                </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>
                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left">
                            <input name="mobile" class="text_gre1" id="mobile" size="30" value=""/></td>
                        </tr>                     
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Fax');?> </td>
                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>
                          <td align="left">
                            <input name="fax" class="text_gre1" id="fax2" size="30" value=""/></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1">&nbsp;</td>
                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>
                          <td align="left" class="text_gre">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?>/<?php echo $this->lang->line('txt_User_Name');?><span class="text_red">*</span> </td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="userName" class="text_gre1" id="userName" size="30" onkeyup="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)"/>
&nbsp;<span id="userNameStatusText"></span></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><span class="text_red"><?php echo $this->lang->line('txt_Password');?>*</span> </td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="30" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Retype_Password');?><span class="text_red">*</span> </td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" /></td>
                        </tr>
						 <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span> </td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="tagName" type="text" class="text_gre1" id="tagName" size="30" /></td>
                        </tr>
                        <tr>
                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                    </span> <span id="otherCommunity" style="display:none;">
                    <table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="31%" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Please_enter');?> <span id="otherCommunityName">yahoo</span> <?php echo $this->lang->line('txt_User_Name');?></td>
                          <td width="2%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="67%" align="left" class="text_gre">
                            <input type="text" name="otherUserName" class="text_gre1" id="otherUserName" size="30" value="" onkeyup="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)"/>
                            <span id="userNameStatus1"></span> </td>
                        </tr>
						 <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span> </td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input name="tagName1" type="text" class="text_gre1" id="tagName1" size="30" /></td>
                        </tr>
                      </tbody>
                    </table>
                    </span>
                    <table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="31%" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Assign_as_a_manager');?></td>
                          <td width="2%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="67%" align="left" class="text_gre">
                            <input name="managerStatus" type="radio" value="1" />
                <?php echo $this->lang->line('txt_Yes');?>
                <input name="managerStatus" type="radio" value="0" checked="checked" />
                <?php echo $this->lang->line('txt_No');?> </td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td colspan="2"><input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Add');?>" /></td>
                </tr>
              </table>
				   <input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>
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
