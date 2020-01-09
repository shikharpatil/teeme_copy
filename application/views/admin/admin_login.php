<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
<!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

</head>
<body onLoad="updateTimeZone()">
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#BBBBBB">
  <tr>
    <td valign="top" style="background-image:url(<?php echo base_url();?>images/body-bg.gif); background-repeat:repeat-x">
        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top" style="background-image:url(<?php echo base_url();?>images/logo-bg.gif); background-repeat:repeat-x">
			<!-- header -->	
			<?php $this->load->view('common/admin_header1');?>
			<!-- header -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
         
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="76%" height="8" align="left" valign="top"></td>
                  <td width="24%" align="left" valign="top"></td>
                </tr>
                <tr>
                  <td align="center" valign="top" colspan="2">
					<!-- Main Body -->
					<?php
$this->load->helper('form'); 
$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheck(this)');	
echo form_open('admin/admin_login/loginCheck', $attributes);
?>
            <table width="50%" height="171" border="0" cellpadding="3" cellspacing="0">

														<tr align="center">
															<td height="20" colspan="4" class="text_marroon1"><strong>Admin Login </strong></td>
													  </tr>
														<tr align="center">
															<td height="23" colspan="4"><span class="style1"><?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?></span></td>
													  </tr>
														<tr>
															<td class="text_gre1">&nbsp;</td>
															<td height="22" align="right" class="text_gre1">Username </td>
															<td align="center" class="text_gre1">:</td>
															<td align="left" class="text_gre1">																					
															<?php 
															$data = array(
																		  'name'      => 'userName',
																		  'id'        => 'userName',
																		  'type'      => 'text',		
																		  'size'      => '20',
																		  'class'   => 'text_gre'																		
																		);															
															echo form_input($data);
															?>															
															</td>
														</tr>
														<tr>
															<td class="text_gre1">&nbsp;</td>
															<td height="22" align="right" class="text_gre1">Password</td>
															<td align="center" class="text_gre1">:</td>
															<td align="left" class="text_gre1">
															<?php 
															$data = array(
																		  'name'      => 'userPassword',
																		  'id'        => 'userPassword',
																		  'type'      => 'password',		
																		  'size'      => '20',
																		  'class'   => 'text_gre'																		
																		);															
															echo form_input($data);
															?>												
														  </td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td height="40">&nbsp;</td>
															<td align="left">&nbsp;</td>
														  <td align="left" valign="top">
															<?php 
															$data = array(
																		  'name'      => 'action',
																		  'id'        => 'action',
																		  'type'      => 'hidden',		
																		  'value'      => 'userLogin'																		  																		
																		);															
															echo form_input($data);
															$data = array(
																		  'name'      => 'Submit',
																		  'id'        => 'Submit',
																		  'type'      => 'submit',		
																		  'value'      => 'Login'																		  																		
																		);															
															echo form_input($data);
															?>	
														  </td>
														</tr>
													</table>	
<?php
echo form_close();
?>																
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
