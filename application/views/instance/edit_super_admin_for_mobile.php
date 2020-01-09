<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Edit Super Admin </title>

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



<script>

function validatePass(){

	var email = document.getElementById('email').value;

	var oldPassword = document.getElementById('oldPassword').value;

	var newPass = document.getElementById('newPassword').value;

	var confirmPassword = document.getElementById('confirmPassword').value;

	var err='';
	
	if(email.trim().length==0){

		err = "<?php echo $this->lang->line('enter_email'); ?>";

	}	
	
	else if(validateEmail(email)==false)
	{
		err = "<?php echo $this->lang->line('enter_valid_email'); ?>";
	}

	else if(oldPassword.trim().length==0){

		err = "<?php echo $this->lang->line('enter_old_password'); ?>";

	}

	else if(newPass.trim().length==0){

		err = "<?php echo $this->lang->line('enter_new_password'); ?>";

	}

	else if(confirmPassword.trim().length==0){

		err = "<?php echo $this->lang->line('enter_confirm_password'); ?>";

	}

	else if(confirmPassword.trim()!=newPass.trim()){

		err = "<?php echo $this->lang->line('new_and_confirm_password_same'); ?>";

	}

	

	if(err!=''){

		jAlert (err,'Alert');

		return false;

	}

	return true;

}

</script>

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>

<?php 

	$this->load->view('instance/common/top_links_for_mobile');

?>  



        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

         

          <tr>

            <td align="left" valign="top">&nbsp;</td>

          </tr>

        

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					   

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="98%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td height="5px"></td>

              </tr>

              <tr>

                <td align="left" class="subHeading" ><?php echo $this->lang->line('edit_super_admin_txt'); ?></td>

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

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>
				 <tr>

                <td height="12 px" align="left" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

              </tr>

              <?php

				}
            	?>

              <tr>

                <td align="center" valign="top">

                  <form name="frmchangepass" method="post" action="<?php echo base_url();?>instance/home/update_super_admin" onsubmit="return validatePass();">

                    <table width="95%" border="0" cellpadding="1" cellspacing="2" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="135" align="left" valign="middle">&nbsp;</td>

                          <td align="center" valign="middle">&nbsp;</td>

                          <td width="492" align="left">&nbsp;</td>

                        </tr>
                        <tr>

                          <td width="45%" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?> </td>

                          <td width="5%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="50%" align="left" valign="top" class="text_gre1">

                            <input name="email" type="text" id="email" value="<?php echo $superAdminDetails['adminUserName']?>" /></td>

                        </tr>
                        <tr>

                          <td width="45%" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Current_Password');?> </td>

                          <td width="5%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="40%" align="left" valign="top" class="text_gre1">

                            <input name="oldPassword" type="password" id="oldPassword" /></td>

                        </tr>

                        <tr>

                          <td width="45%" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_New_Password');?> </td>

                          <td  width="5%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="40%" align="left" valign="top" class="text_gre1">

                            <input name="newPassword" type="password" id="newPassword" /></td>

                        </tr>

                        <tr>

                          <td width="45%" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password_New');?> </td>

                          <td width="5%%" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="50%" align="left" valign="top" class="text_gre1">

                            <input name="confirmPassword" type="password" id="confirmPassword" /></td>

                        </tr>

                        <?php /*?><tr>

                          <td align="left" class="text_gre1">&nbsp;</td>

                          <td align="center" class="text_gre1">&nbsp;</td>

                          <td align="left" class="text_gre1">&nbsp;</td>

                        </tr><?php */?>

                        <tr>

                          <td align="left" class="text_gre1">&nbsp;</td>

                          <td align="center" class="text_gre1">&nbsp;</td>

                          <td align="left" class="text_gre1">
						  <input type="hidden" name="adminId" value="<?php echo $superAdminDetails['adminId']?>" />
						  <input  type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Update');?>">

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

         

        </table>

		

		<?php $this->load->view('common/footer');?>

   

</body>

</html>