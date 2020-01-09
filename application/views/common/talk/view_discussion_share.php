<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
  <tr>
    <td valign="top"><table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="top"><!-- header -->
            
            <?php $this->load->view('common/header'); ?>
            
            <!-- header --></td>
        </tr>
        <tr>
          <td align="left" valign="top"><?php $this->load->view('common/wp_header'); ?></td>
        </tr>
        <tr>
          <td align="left" valign="top"><!-- Main menu -->
            
            <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
			 $this->load->view('common/artifact_tabs', $details); ?>
            
            <!-- Main menu --></td>
        </tr>
        <tr>
          <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0" class="dashboard_bg">
              <tr>
                <td height="8" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="tdSpace"><ul class="navigation">
                    <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
                    <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
                    <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
                    <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>
                    <?php
					if (($workSpaceId==0))
					{
				?>
                    <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" class="current"><span><?php echo $this->lang->line('txt_Share');?></span></a></li>
                    <?php
					}
				?>
                  </ul></td>
              </tr>
              <?php
			if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
			{
			?>
              <tr>
                <td><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
              </tr>
              <?php
			}
			?>
              <tr>
                <td align="left" valign="top"><?php       
						if($this->input->post('users') != '')
						{
							$by = $this->input->post('users');
						}	
						
					?>
                  <script>
function showFilteredMembers()
{

	var toMatch = document.getElementById('showMembers').value;

	var val = '';

		if (1)
		{
			<?php
			if ($workPlaceMembers==0)
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_All');?><br>';
				}
			<?php
			}

			foreach($workPlaceMembers as $arrData)	
			{
				if (in_array($arrData['userId'],$sharedMembers))
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
			
			foreach($workPlaceMembers as $arrData)	
			{
				if (!in_array($arrData['userId'],$sharedMembers))
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
        	?>

		}
}
</script> 
                  <!-- Main Body -->
                  
                  <form name="frmCal" action="<?php echo base_url()?>view_discussion/share/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post">
                    <table width="100%" border="0" cellspacing="3" cellpadding="3">
                      <tr>
                        <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Members');?>: </td>
                        <td width="85%" align="left" valign="top" class="tdSpace"><input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></td>
                      </tr>
                      <tr>
                        <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                        <td width="85%" align="left" valign="top" class="tdSpace"><div id="showMem" style="height:120px; width:300px; overflow:scroll;">
                            <input type="checkbox" name="users[]" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/>
                            <?php echo $this->lang->line('txt_All');?><br />
                            <?php	
											
							foreach($workPlaceMembers as $arrData)
							{
								if (in_array($arrData['userId'],$sharedMembers))
								{						
							?>
                            <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId'] || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/>
                            <?php echo $arrData['tagName'];?><br />
                            <?php
								}
							}
							foreach($workPlaceMembers as $arrData)
							{
								if (!in_array($arrData['userId'],$sharedMembers))
								{						
							?>
                            <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId'] || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/>
                            <?php echo $arrData['tagName'];?><br />
                            <?php
								}
							}
							?>
                          </div></td>
                      </tr>
                      <tr>
                        <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                        <td width="85%" align="left" valign="top" class="tdSpace"><input type="hidden" name="treeId" value="<?php echo $treeId; ?>" />
                          <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId; ?>" />
                          <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType; ?>" />
                          <?php
							if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
							{
							?>
                          <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_Ok');?>" class="button01">
                          <input type="button" name="Clear" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearForm(this.form);">
                          <?php
							}
							?></td>
                      </tr>
                    </table>
                  </form>
                  
                  <!-- Main Body --></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td align="center" valign="top" class="copy"><!-- Footer -->
            
            <?php $this->load->view('common/footer');?>
            
            <!-- Footer --></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
