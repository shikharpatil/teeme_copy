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
			  <form name="frmAdmin" id="frmAdmin" action="<?php echo base_url();?>admin/admin_home/insert_admin" method="post" onSubmit="return validateAdmin()">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:1px solid #bbbbbb;" >
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
                  <td class="subHeading" colspan="4"><?php echo $this->lang->line('txt_Admin_Details');?></td>
                </tr>
                <tr>
                  <td colspan="2" class="tdSpace">&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4" class="tdSpace">
                    <table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="163" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Name');?> </td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td width="302" align="left" class="text_gre">
                            <input name="userName" class="text_gre1" id="userName" size="30" value=""/>
            &nbsp;<span id="workPlaceStatusText"></span> </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Password');?></td>
                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input type="password" name="password" class="text_gre1" id="password" size="30" value="" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input type="password" name="confirmPassword" class="text_gre1" id="confirmPassword" size="30" value="" /></td>
                        </tr>         
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Security_Question');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre">
                          	<select name="securityQuestion" class="text_gre1" id="securityQuestion"/>
                            	<option value="<?php echo $this->lang->line('txt_Security_Question_1');?>"><?php echo $this->lang->line('txt_Security_Question_1');?>
                                <option value="<?php echo $this->lang->line('txt_Security_Question_2');?>"><?php echo $this->lang->line('txt_Security_Question_2');?>
                            	<option value="<?php echo $this->lang->line('txt_Security_Question_3');?>"><?php echo $this->lang->line('txt_Security_Question_3');?>
                            </select>
                          </td>
                        </tr>     
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Answer');?></td>
                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" class="text_gre"><input type="text" name="securityAnswer" id="securityAnswer" value="" /></td>
                        </tr>         
                      </tbody>
                  </table></td>
                </tr>                
                <tr>
                  <td width="26%">&nbsp;</td>
                  <td width="0%">&nbsp;</td>
                  <td colspan="2"><input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Done');?>"></td>
                </tr>
              </table>            
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
