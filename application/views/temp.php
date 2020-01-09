<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META HTTP-EQUIV="CACHE-CONTROL">
	<title>Teeme Documents</title>
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
	<script language="javascript">
	var baseUrl = '<?php echo base_url();?>';	
	</script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	</head>	
<body>
<table width="88%" border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" align="left" valign="top"><img src="<?php echo base_url();?>images/logo.gif" alt="logo" width="157" height="75" /></td>
					<td colspan="2" align="right" valign="middle">				<strong>
					<?php
					echo $_SESSION['workPlaceManagerName'];
					?>
					<br>
					[ <?php echo anchor('admin/admin_logout/work_place', $this->lang->line('txt_Sign_Out'));?> ]</strong></td>
				</tr>			
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/blue-corner.gif" width="8" height="30" /></td>
				    <td width="40%" colspan="3" align="left" valign="middle" nowrap bgcolor="#67a7e3"><a href="<?php echo base_url();?>admin/admin_work_place" class="menuitembig"><?php echo str_replace('_',' ',$_SESSION['contName']);?></a></td>
				    <td width="60%" align="right" valign="middle" bgcolor="#67a7e3"><div id="dropfile" class="dropmenudiv">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>	
					<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/blue-corner-r.gif" width="8" height="30" /></td>
				</tr>
			</table>
		</td>
	</tr>	 
	<tr>
		<td width="20%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="0" >
          <?php
		if($_SESSION['WPManagerAccess'])
		{
		?>
          <tr>
            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/manage_users.gif" width="15" height="16" /></td>
                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('workPlaceMemberExtendLinks')">Manage Members</a></h1></td>
                </tr>
              </table>
                <span id="workPlaceMemberExtendLinks" style="display:none;">
                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_users.gif" width="15" height="16" /></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/view_work_place_members">View Members</a></h1></td>
                  </tr>
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/add_user.gif" width="15" height="16" /></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/add_work_place_member">Add New Member </a></h1></td>
                  </tr>
                </table>
              </span> </td>
          </tr>
          <?php
			}
			?>
          <tr>
            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/manage_work_space.gif" width="15" height="16" /></td>
                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('workSpaceExtendLinks')">Manage Work Spaces</a></h1></td>
                </tr>
              </table>
                <span id="workSpaceExtendLinks">
                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/view_work_spaces">View Work Spaces </a></h1></td>
                  </tr>
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/create_work_space">Create Work Space </a></h1></td>
                  </tr>
                </table>
              </span> </td>
          </tr>
          <!--<tr>
            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/change_password.gif" width="15" height="16" /></td>
                  <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/change_password">Change Password</a></h1></td>
                </tr>
            </table></td>
          </tr>-->
          <tr>
            <td class="padding">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td class="padding">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
        </table></td>
	    <td width="61%" valign="top">
		<span id="tagSpan">
			<table width="98%"  border="0">
			  <?php
			if(count($tags) > 0)
			{		
				foreach($tags as $tagData)
				{				
					//$userDetails 	= $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
					$ownerDetails	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['ownerId'] );
					$userDetails 	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['userId'] );
					$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
					//print_r($tagLink);
					//$artifactDetails	= 
					if(count($tagLink) > 0)
					{	
					?>
				  <tr>
					<td><a href="<?php echo $tagLink[0];?>"> <?php echo $tagLink[1];?>  </a></td><td><a href="<?php echo $tagLink[0];?>"> <?php echo $tagData['tagType'];?></a></td>
				  </tr>
				  <?php
					}
				}
			}
			?>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>
		  </tr>
        </table>
		</span>
		</td>
	<td width="19%" valign="top"><table width="98%"  border="0">
		<?php
		foreach($tagTypes as $tagData)
		{
		?>		
			<tr>
				<td><a href="javascript:void(0)" onClick="viewTag('<?php echo $tagData['tagTypeId'];?>','tagSpan')"><?php echo $tagData['tagType'];?></a></td>
			</tr>
		<?php
		}
		?>	
		<tr> 
			<td><a href="javascript:void(0)" onClick="viewTag('today','tagSpan')">Today</a></td>
		</tr>     
		<tr> 
			<td><a href="javascript:void(0)" onClick="viewTag('tomorrow','tagSpan')">Tomorrow</a></td>
		</tr>
		<tr> 
			<td><a href="javascript:void(0)" onClick="viewTag('this_week','tagSpan')">This Week</a></td>
		</tr>
		<tr> 
			<td><a href="javascript:void(0)" onClick="viewTag('this_month','tagSpan')">This Month</a></td>
		</tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
	</tr>	
</table>
</body>
</html>