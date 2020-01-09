<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
					<table width="99%"  border="0">
              <?php
				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
				{
				?>
              <tr>
                <td colspan="3" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
              </tr>
              <?php
				}
				
				?>
				<tr>
                <td colspan="3" align="right"><a href="<?php echo base_url();?>admin/admin_home/add_admin">Add New</a></td>
                </tr>
            
	  <?php
		if(count($adminDetails) > 0)
		{
		?>   
			  <tr>		         
                <td width="4%">&nbsp;</td>
                <td width="29%"><strong><?php echo $this->lang->line('txt_User_Name');?></strong></td>               
                <td width="13%" align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>
              </tr>
              <?php
			$i = 1;
			foreach($adminDetails as $keyVal=>$adminData)
			{				
			?>
              <tr>
                <td>&nbsp;</td>
                <td><?php echo $adminData['adminUserName'];?></td>               
                <td align="center"><a href="<?php echo base_url();?>admin/admin_home/edit_admin/<?php echo $adminData['adminId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="Change Password" border="0"></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>admin/admin_home/delete_admin/<?php echo $adminData['adminId'];?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/delete.gif" alt="Delete" border="0"></a></td>
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
