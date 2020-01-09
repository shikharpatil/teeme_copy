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
					<table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="5px"></td>
              </tr>
              <tr>
                <td align="left" class="subHeading"><?php echo $this->lang->line('txt_Change_Password');?></td>
              </tr>
              <?php
				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
				{
				?>
              <tr>
                <td height="12 px" align="left" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
              </tr>
              <?php
				}
				
				?>
              <tr>
                <td align="center" valign="top">
                  <form name="frmchangepass" method="post" action="<?php echo base_url();?>admin/admin_home/update_password">
                    <table width="95%" border="0" cellpadding="1" cellspacing="2" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                      <tbody>
                        <tr>
                          <td width="135" align="left" valign="middle">&nbsp;</td>
                          <td align="center" valign="middle">&nbsp;</td>
                          <td width="492" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Old_Password');?> </td>
                          <td width="10" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" valign="top" class="text_gre1">
                            <input name="oldPassword" type="password" id="oldPassword" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_New_Password');?> </td>
                          <td width="10" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" valign="top" class="text_gre1">
                            <input name="newPassword" type="password" id="newPassword" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?> </td>
                          <td width="10" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
                          <td align="left" valign="top" class="text_gre1">
                            <input name="confirmPassword" type="password" id="confirmPassword" /></td>
                        </tr>
                        <tr>
                          <td align="left" class="text_gre1">&nbsp;</td>
                          <td align="center" class="text_gre1">&nbsp;</td>
                          <td align="left" class="text_gre1">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" class="text_gre1">&nbsp;</td>
                          <td align="center" class="text_gre1">&nbsp;</td>
                          <td align="left" class="text_gre1"><input  type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Update');?>">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                </form></td>
              </tr>
              <tr>
                <td height="12 px" align="left"></td>
              </tr>
            </table>
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
