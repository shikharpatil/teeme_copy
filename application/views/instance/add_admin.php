<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Add New Admin</title>

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

			  <form name="frmAdmin" id="frmAdmin" action="<?php echo base_url();?>instance/home/insert_admin" method="post" onSubmit="return validateAdmin()">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

              	<tr>

                    	<td colspan="4" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

            					<ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_admin"><span><?php echo $this->lang->line('view_admins_txt'); ?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/add_admin" class="active"><span><?php echo $this->lang->line('add_new_admin_txt'); ?></span></a></li>

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

                  <td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                  </tr>

                <?php

				}

				

				?>

               

                <tr>

                  <td class="subHeading" colspan="4"><?php //echo $this->lang->line('txt_Admin_Details');?></td>

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

                          <td width="163" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?> </td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="302" align="left" class="text_gre">

                            <input name="first_name" class="text_gre1" id="first_name" size="30" value=""/>
							</td>

                        </tr>
						
                        <tr>

                          <td width="163" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?> </td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="302" align="left" class="text_gre">

                            <input name="last_name" class="text_gre1" id="last_name" size="30" value=""/>
							</td>

                        </tr>

                        <tr>

                          <td width="163" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="302" align="left" class="text_gre">

                            <input name="userName" class="text_gre1" id="userName" size="30" value=""/>

            &nbsp;<span id="workPlaceStatusText"></span> </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Password');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="password" name="password" class="text_gre1" id="password" size="30" value="" /></td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input type="password" name="confirmPassword" class="text_gre1" id="confirmPassword" size="30" value="" /></td>

                        </tr>  
						
						<?php
						/*       
						// Andy - Security question and answer don't make sense since the place is created by admins 
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
						*/
						?>      

                      </tbody>

                  </table></td>

                </tr>                

                <tr>

                  <td width="26%">&nbsp;</td>

                  <td width="0%">&nbsp;</td>

                  <td colspan="2">
				  
				  <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Done');?>">
				  
				  <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-1)">
				  
				  </td>

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

         

        </table>

  <?php $this->load->view('common/footer');?>

</body>

</html>

