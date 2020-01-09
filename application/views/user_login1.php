<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

<link href="teeme.css">

<style type="text/css">

<!--

.style1 {color: #FF0000}

-->

</style>

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js">

</script>

<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />

</head>

<body onLoad="updateTimeZone()">

<?php

$_SESSION['contName'] = $this->uri->segment(1);

$this->load->helper('form'); 

$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheck(this)');	

echo form_open('/login_check', $attributes);

?>

<table width="891px" align="center">

	<tr>

		<td>		  <table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td width="21%"><img src="<?php echo base_url();?>images/teeme.jpg" width="205" height="72" /></td>

								<td width="46%">&nbsp;</td>

								<td width="33%" valign="top">&nbsp;</td>

							</tr>        

						</table>

					</td>

				</tr>

				<tr>

					<td background="images/menu-bg.gif">&nbsp;</td>

				</tr>          

        	</table>      

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td width="8%" valign="top">&nbsp;</td>

					<td width="92%" align="center" valign="top">

						<table width="98%" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td height="5px">&nbsp;</td>

							</tr>

							<tr>

								<td height="200" align="center">

									<table width="99%" height="150" border="0" cellpadding="0" cellspacing="0">

										<tr>

											<td align="center" background="images/login-bg.gif">													

													<table width="50%" height="150" border="0" cellpadding="3" cellspacing="0">

														<tr align="center">

															<td height="20" colspan="4" class="text_marroon1"><strong>User Login </strong></td>

													  </tr>

														<tr align="center">

															<td height="23" colspan="4"><span class="style1"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

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

														  <td class="text_gre1">&nbsp;</td>

														  <td height="22" align="right" class="text_gre1">Login As</td>

														  <td align="center" class="text_gre1">:</td>

														  <td align="left" class="text_gre1">

                                                            <select name="communityId" id="communityId">							

															<?php																

															foreach( $communityDetails as $communityData )

															{

															?>						

																<option value="<?php echo $communityData['communityId'];?>" <?php if( $communityData['communityId'] == 1 ) { echo 'selected'; }?>><?php echo $communityData['communityName'];?></option>											

															<?php

															}

															?>	

													 		</select>

                                                          </td>

													  </tr>

														<tr>

															<td>&nbsp;</td>

															<td height="40">&nbsp;</td>

															<td align="left">&nbsp;</td>

														  <td align="left" valign="top">

														<input type="hidden" name="workPlaceId" value="<?php echo $workPlaceId;?>">	

														<input type="hidden" name="contName" value="<?php echo $contName;?>">

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

																		  'value'     => 'Login'																		  																		

																		);															

															echo form_input($data);

															?>

															<!--<a href="<?php echo base_url();?>user_register" class="style2">Register</a>-->									

														  </td>

														</tr>

													</table>														 

											</td>

										</tr>

									</table>

								</td>

							</tr>        

						</table>

					</td>

				</tr>

   		  </table>      

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td height="5px"></td>

				</tr>

				<tr>

					<td class="link_bottom">&nbsp;</td>

				</tr>

				<tr>

					<td align="center" class="link_bottom">&nbsp;</td>

				</tr>

				<tr>

					<td align="center" class="text_marroon">&nbsp;</td>

				</tr>

		  </table>

		</td>

	</tr>

</table>

<?php

echo form_close();

?>

</body>

</html>