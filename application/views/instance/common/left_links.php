<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
			<table width="100%" border="0" cellspacing="2" cellpadding="0" >
            <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding">
                	<table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/view_work_places"><?php echo $this->lang->line('txt_Manage_Workplaces');?></a></h1></td>
                    </tr>
                  	</table>
				</td>
            </tr>
              
            <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/select_editor"><?php echo 'Manage Editor';?></a></h1></td>
                    </tr>
                </table></td>
            </tr>
            
            <?php 
			/* Parv - Help system temperorily disabled
			<tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/admin_help"><?php echo $this->lang->line('txt_Help_System');?></a></h1></td>
                    </tr>
                </table></td>
            </tr>
			*/
			?>
			<?php 
			if($_SESSION['superAdmin'] == 1)
			{
			?>
			 <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                   
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/view_admin"><?php echo $this->lang->line('txt_View_by_Add_Admin');?></a></h1></td>
                    </tr>
                </table></td>
              </tr>
			<?php
			}
			?>		
              <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>instance/home/change_password"><?php echo $this->lang->line('txt_Change_Password');?></a></h1></td>
                    </tr>
                </table></td>
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
            </table>