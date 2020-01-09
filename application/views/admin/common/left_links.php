<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><table width="100%" border="0" cellspacing="2" cellpadding="0" >
          <tr>
            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="2%" align="left"></td>
                  <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('companyExtendLinks')"><?php echo $this->lang->line('txt_Manage_Workplaces');?></a></h1></td>
                </tr>
              </table>
                <span id="companyExtendLinks" style="display:'';">
                <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/view_work_places"><?php echo $this->lang->line('txt_View_Workplaces');?> </a></h1></td>
                  </tr>
                  <tr>
                    <td width="1%" align="left">&nbsp;</td>
                    <td width="2%" align="left"></td>
                    <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/create_work_place"><?php echo $this->lang->line('txt_Create_Workplace');?> </a></h1></td>
                  </tr>
                </table>
              </span> </td>
          </tr>
          
          <tr>
            <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                  <td width="1%" align="left">&nbsp;</td>
                  <td width="2%" align="left"></td>
                  <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/select_editor"><?php echo 'Select Editor';?></a></h1></td>
                </tr>
            </table></td>
          </tr>
              
              
              <!--  /////////////////////////////////////////         -->
               <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="javascript:void(0)" onClick="extendMenus('editorOptionsLinks')"><?php echo 'Editor Options';?></a></h1></td>
                    </tr>
                  </table>
                    <span id="editorOptionsLinks" style="display:'';">
                    <table width="93%" border="0" cellspacing="1" cellpadding="1" align="right">
                      <tr>
                        <td width="1%" align="left">&nbsp;</td>
                        <td width="2%" align="left"></td>
                        <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/editor_options/tinyadvance"><?php echo 'Tiny Advance';?> </a></h1></td>
                      </tr>
                      <tr>
                        <td width="1%" align="left">&nbsp;</td>
                        <td width="2%" align="left"></td>
                        <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/editor_options/tinysimple"><?php echo 'Tiny Simple';?> </a></h1></td>
                      </tr>
                      <tr>
                        <td width="1%" align="left">&nbsp;</td>
                        <td width="2%" align="left"></td>
                        <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/editor_options/fckadvance"><?php echo 'FCK Advance';?> </a></h1></td>
                      </tr>
                      
                       <tr>
                        <td width="1%" align="left">&nbsp;</td>
                        <td width="2%" align="left"></td>
                        <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/editor_options/fcksimple"><?php echo 'FCK Simple';?> </a></h1></td>
                      </tr>
                    </table>
                  </span> </td>
              </tr>
              
              <!--  /////////////////////////////////////////         -->
			<tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_help"><?php echo $this->lang->line('txt_Help_System');?></a></h1></td>
                    </tr>
                </table></td>
              </tr>
			<?php 
			if($_SESSION['superAdmin'] == 1)
			{
			?>
			 <tr>
                <td style="background-image:url(<?php echo base_url();?>images/blue-bg.gif); background-repeat:repeat-x" class="padding"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                   
                    <tr>
                      <td width="1%" align="left">&nbsp;</td>
                      <td width="2%" align="left"></td>
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/view_admin"><?php echo $this->lang->line('txt_View_by_Add_Admin');?></a></h1></td>
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
                      <td width="97%" align="left" class="one"><h1><a href="<?php echo base_url();?>admin/admin_home/change_password"><?php echo $this->lang->line('txt_Change_Password');?></a></h1></td>
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