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
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
  <tr>
    <td valign="top">
        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">
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
					<table width="99%"  border="0">
              <?php
				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
				{
				?>
              <tr>
                <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
              </tr>
              <?php
				}
				
				?>
              <?php
		if(count($workPlaceDetails) > 0)
		{
		?>
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="22%"><strong><?php echo $this->lang->line('txt_Workplace_Name');?></strong></td>
                <td width="26%"><strong><?php echo $this->lang->line('txt_Workplace_Manager_Id');?> </strong></td>
                <td width="15%"><strong><?php echo $this->lang->line('txt_Created_Date');?> </strong></td>
                <td width="33%" align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>
              </tr>
              <?php
			$i = 1;
			foreach($workPlaceDetails as $keyVal=>$workPlaceData)
			{				
				if($workPlaceData['workPlaceManagerId'] == 0)
				{
					$workPlaceManager = $this->lang->line('txt_Not_Assigned');
				}
				else
				{					
					$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workPlaceData['workPlaceManagerId']);
					$workPlaceManager = $arrUserDetails['userName'];
				}
			?>
              <tr>
                <td>&nbsp;</td>
                <td><?php echo $workPlaceData['companyName'];?></td>
                <td><?php echo $workPlaceManager;?></td>
                <td><?php echo $this->time_manager->getUserTimeFromGMTTime($workPlaceData['companyCreatedDate'], 'm-d-Y h:i A');?></td>
                <td align="center">
                <?php
                	if($workPlaceData['status'] == 0)
					{
				?>
			    	<a href="<?php echo base_url();?>admin/admin_home/activateWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer;"></a>
				<?php
					}
					else
					{
				?>
                	<a href="<?php echo base_url();?>admin/admin_home/suspendWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer;"></a>
                <?php
					}
				?>
                <a href="<?php echo base_url();?>admin/admin_home/edit_work_place/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="Edit" border="0"></a>&nbsp;&nbsp;
                
                <?php
				/*
                <a href="<?php echo base_url();?>admin/admin_home/delete_work_place/<?php echo $workPlaceData['workPlaceId'];?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/delete.gif" alt="Delete" border="0"></a>
                */
				?>
                </td>
              </tr>
              <?php
				$i++;					
			}
		}
		else
		{
		?>
              <tr>
                <td colspan="5"><?php echo $this->lang->line('msg_workplaces_not_available');?></td>
              </tr>
              <?php
		}
		?>
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
