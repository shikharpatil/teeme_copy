<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<META HTTP-EQUIV="CACHE-CONTROL">

	<title>Teeme Documents</title>

	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	</head>	

<body>

<table width="88%" border="1" align="center" cellpadding="0" cellspacing="0">

	<tr>

		<td colspan="2" valign="top">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td colspan="2" align="left" valign="top"><img src="<?php echo base_url();?>images/logo.gif" alt="logo" width="157" height="75" /></td>

					<td colspan="2" align="right" valign="middle">				<strong>

					<?php 

					echo $_SESSION['adminUserName'];

					?>

					<br>

					[ <?php echo anchor('admin/admin_logout/', 'Sign Out');?> ]</strong></td>

				</tr>			

			</table>

		</td>

	</tr>

	<tr>

		<td colspan="2" valign="top">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/blue-corner.gif" width="8" height="30" /></td>

				    <td width="40%" colspan="3" align="left" valign="middle" nowrap bgcolor="#67a7e3">&nbsp;</td>

				    <td width="60%" align="right" valign="middle" bgcolor="#67a7e3"><div id="dropfile" class="dropmenudiv">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>	

					<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/blue-corner-r.gif" width="8" height="30" /></td>

				</tr>

			</table>

		</td>

	</tr>	 

	<tr>

		<td width="20%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="0" >

          <tr>

            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                <tr>

                  <td width="1%" align="left">&nbsp;</td>

                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/item.gif" width="15" height="16" /></td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('companyExtendLinks')"><?php echo $this->lang->line('manage_work_place_txt'); ?> </a></h1></td>

                </tr>				 

            </table>

			<span id="companyExtendLinks" style="display:none;">

			<table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">

				<tr>

					<td width="1%" align="left">&nbsp;</td>

					<td width="2%" align="left"><img src="<?php echo base_url();?>images/item.gif" width="15" height="16" /></td>

					<td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/view_work_places"><?php echo $this->lang->line('view_work_places_txt'); ?> </a></h1></td>

				</tr>	

				<tr>

					<td width="1%" align="left">&nbsp;</td>

					<td width="2%" align="left"><img src="<?php echo base_url();?>images/item.gif" width="15" height="16" /></td>

					<td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/create_work_place"><?php echo $this->lang->line('create_work_place_txt'); ?> </a></h1></td>

				</tr>	

				 

            </table>

			</span>	