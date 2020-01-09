<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />	

<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

	<script type="text/javascript" src="<?php echo base_url();?>js/ajax.js"></script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>js/validation.js"></script>		

	<script type="text/javascript" src="<?php echo base_url();?>js/identity.js"></script>

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

					echo $_SESSION['workPlaceManagerName'];

					?>

					<br>

					[ <?php echo anchor('admin/admin_logout/work_place', $this->lang->line('txt_Sign_Out'));?> ]</strong></td>

				</tr>			

			</table>

		</td>

	</tr>

	<tr>

		<td colspan="2" valign="top">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/blue-corner.gif" width="8" height="30" /></td>

				    <td width="40%" colspan="3" align="left" valign="middle" nowrap bgcolor="#67a7e3"><a href="<?php echo base_url();?>admin/admin_work_place" class="menuitembig"><?php echo str_replace('_',' ',$_SESSION['contName']);?></a>  <a href="<?php echo base_url();?>admin/work_space/index/<?php echo $workSpaceDetails['workSpaceId'];?>" class="menuitembig"> --> <?php echo $workSpaceDetails['workSpaceName'];?></a></td>

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

                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/manage_work_place.gif" width="15" height="16" /></td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('subWorkPlaceExtendLinks')">Manage Sub Work Spaces</a></h1></td>

                </tr>

              </table>

                <span id="subWorkPlaceExtendLinks">

                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/work_place.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/view_sub_work_spaces/index/<?php echo $workSpaceId;?>">View Sub Work Spaces </a></h1></td>

                  </tr>

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/work_place.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/create_sub_work_space/index/<?php echo $workSpaceId;?>">Create Sub Work Space</a></h1></td>

                  </tr>

                </table>

              </span> </td>

          </tr>

          <tr>

            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                <tr>

                  <td width="1%" align="left">&nbsp;</td>

                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/manage_work_space.gif" width="15" height="16" /></td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('workSpaceExtendLinks')">Manage Document</a></h1></td>

                </tr>

              </table>

                <span id="workSpaceExtendLinks" style="display:none;">

                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceDetails['workSpaceId'];?>/type/1">View Documents </a></h1></td>

                  </tr>

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>document_new/index/<?php echo $workSpaceDetails['workSpaceId'];?>/type/1">Add Document </a></h1></td>

                  </tr>

                </table>

              </span> </td>

          </tr>

          <tr>

            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                <tr>

                  <td width="1%" align="left">&nbsp;</td>

                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/item.gif" width="15" height="16" /></td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('discussionExtendLinks')">Discussions</a></h1></td>

                </tr>

              </table>

                <span id="discussionExtendLinks" style="display:none;">

                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>Discussion/index/0/<?php echo $workSpaceDetails['workSpaceId'];?>/type/1">View Discussion </a></h1></td>

                  </tr>

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/view_work_space.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>new_Discussion/start_Discussion/0/index/<?php echo $workSpaceId;?>/type/1">Add New Discussion</a></h1></td>

                  </tr>

                </table>

              </span> </td>

          </tr>

          <tr>

            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                <tr>

                  <td width="1%" align="left">&nbsp;</td>

                  <td width="2%" align="left"><img src="<?php echo base_url();?>images/manage_users.gif" width="15" height="16" /></td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('userExtendLinks')">Work Space Members </a></h1></td>

                </tr>

              </table>

                <span id="userExtendLinks">

                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">

                  <?php 

					if(count($onlineUsers) > 0)

					{

						foreach($onlineUsers as $userId)

						{

							$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($userId);

						?>

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/online_user.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" style="text-decoration:none;"><?php echo $userDetails['userName'];?> </a></h1></td>

                  </tr>

                  <?php

						}

					}

					if(count($workSpaceMembers) > 0)

					{		

						foreach($workSpaceMembers as $arrVal)

						{

							if(!in_array($arrVal['userId'],$onlineUsers))

							{ 

									$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);

								?>

                  <tr>

                    <td width="1%" align="left">&nbsp;</td>

                    <td width="2%" align="left"><img src="<?php echo base_url();?>images/offline_user.gif" width="15" height="16" /></td>

                    <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" style="text-decoration:none;"><?php echo $userDetails['userName'];?> </a></h1></td>

                  </tr>

                  <?php

							}		

						}

					}	

					?>

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

            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                <tr>

                  <td width="1%" align="left">&nbsp;</td>

                  <td width="2%" align="left">&nbsp;</td>

                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('chatExtendLinks')">Current Chats</a></h1></td>

                </tr>

              </table>

                <span id="chatExtendLinks">

                

              </span> </td>

          </tr>

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

	  <td width="80%" valign="top">

		<form name="frmWorkSpace" action="<?php echo base_url();?>admin/create_sub_work_space/add" method="post"  onSubmit="return validateWorkSpace(this)">

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:1px solid #D9E3F2;" >

				<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

					  <tr>

				    <td colspan="2" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td><td width="55%">&nbsp;</td></tr>

				<?php

				}

				

				?>	

				  

				  <tr>

                    <td class="subHeading" colspan="3">Create Tag </td>

		      </tr>

				  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                     <tbody>                    

                       <tr>

                         <td align="left" valign="middle" class="text_gre1">Tag Type </td>

                         <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                         <td align="left" class="text_gre"><select name="select">

                         </select></td>

                       </tr>

                       <tr>

                         <td width="205" align="left" valign="middle" class="text_gre1">Tag Content</td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="485" align="left" class="text_gre">

                           <input name="workSpaceName" class="text_gre1" id="workSpaceName" size="30" value="" //>&nbsp;<span id="workPlaceStatusText"></span>

                         </td>

                       </tr>

                       <tr>

                         <td align="left" valign="middle" class="text_gre1">Assign Work Space Managers </td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre"><select name="workSpaceManagers[]" id="workSpaceManagers[]" multiple>

                         <?php						

						foreach($workSpaceMembers as $keyVal=>$workSpaceMemberData)

						{	

						?>

                           <option value="<?php echo $workSpaceMemberData['userId'];?>"><?php echo $workSpaceMemberData['userName'];?></option>

					   <?php

						}

						?>

                         </select></td>

                       </tr>

                       <tr>

                         <td align="left" valign="middle" class="text_gre1">Add Work Space Members </td>

                         <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre"><select name="workSpaceMembers[]" id="workSpaceMembers[]" multiple>                         

						<?php						

						foreach($workSpaceMembers as $keyVal=>$workSpaceMemberData)

						{	

						?>

                           <option value="<?php echo $workSpaceMemberData['userId'];?>"><?php echo $workSpaceMemberData['userName'];?></option>

					   <?php

						}

						?>

                         </select></td>

                       </tr>

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				 <tr>

				   <td class="subHeading" colspan="3">&nbsp;</td>

		      </tr>

				

			    <tr><td>&nbsp;</td>

				  <td><input name="Submit" type="submit" id="Submit" value="Add"></td>

			    </tr>

			  </table>		

		<input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceDetails['workSpaceId'];?>">

	    </form>

		</td>

	</tr>	

</table>

<script language="javascript">

	showOnlineUsers( <?php echo $workSpaceDetails['workSpaceId'];?>, 1, 'userExtendLinks' );

</script>

</body>

</html>