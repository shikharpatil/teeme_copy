<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
					$this->load->view('instance/common/left_links');
					?>     
				<!-- end Right Part -->
					</td>
                  <td align="left" valign="top">
				<!-- Main Body -->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
				    <tr>
				      <td colspan="4" class="tdSpace">
					    <ul class="rtabs">
					    <li><a href="<?php echo base_url().'admin/admin_help';?>" class="current"><span><?php echo $this->lang->line('txt_View_Topics');?></span></a></li>
					    <li><a href="<?php echo base_url().'admin/admin_help/create_topic';?>"><span><?php echo $this->lang->line('txt_Create_Topic');?></span></a></li>		
						 <li><a href="<?php echo base_url().'admin/admin_help/view_sub_topic';?>"><span><?php echo $this->lang->line('txt_View_Sub_Topics');?></span></a></li>			
					    <li><a href="<?php echo base_url().'admin/admin_help/create_sub_topic';?>"><span><?php echo $this->lang->line('txt_Create_Sub_Topic');?></span></a></li>
					    </ul>				
				      </td>
				    </tr>
				    <tr>
				      <td class="subHeading" colspan="4">&nbsp;</td>
				    </tr>
                    
              
                    <tr>
                      <td class="subHeading" colspan="4"><table width="99%"  border="0">
						<?php
						if(count($arrTopics) > 0)
						{
						?>
                        <tr>
                          <td width="2%">&nbsp;</td>
                          <td nowrap="nowrap"><strong><?php echo $this->lang->line('txt_Topic_Name');?></strong></td>
                          <!--td width="26%"><strong><?php echo $this->lang->line('txt_Created_By');?> </strong></td>
                          <td width="15%"><strong><?php echo $this->lang->line('txt_Modified_Date');?></strong></td>
                          <td width="33%" align="center"><strong><?php echo $this->lang->line('txt_View_Topics');?></strong></td-->
						  <!--td><strong><?php echo $this->lang->line('txt_Topic_Trees');?> </strong></td-->
						  <td width="45" align="center"><strong>Document</strong></td>
						  <td width="45" align="center"><strong>Discussion</strong></td>
						  <td width="45" align="center"><strong>Chat</strong></td>
						  <td width="45" align="center"><strong>Activity</strong></td>
						  <td width="45" align="center"><strong>Notes</strong></td>
						  <td width="45" align="center"><strong>Contact</strong></td>
						  <td width="45" align="center"><strong>Tag</strong></td>
						   <td width="45" align="center"><strong>Other</strong></td>
                        </tr>
							<?php
							foreach($arrTopics as $data)
							{
							$arrSelectedTrees = explode('|', $data['trees']);
							?>		
							<tr>
							  <td>&nbsp;</td>
							  <td nowrap="nowrap"><a href="<?php echo base_url().'admin/admin_help/view_topic_details/'.$data['topicId'];?>"><?php echo $data['topicName'];?></a></td>
							  <!--td><?php echo $data['userName'];?></td>
							  <td><?php echo $this->time_manager->getUserTimeFromGMTTime($data['modifiedDate'], $this->config->item('date_format'));?></td>
							  <td align="center"><a href="<?php echo base_url().'admin/admin_help/edit_topic/'.$data['topicId'];?>"><img src="<?php echo base_url(); ?>images/edit.gif" alt="Edit" border="0" /></a>&nbsp;&nbsp;<a href="#" onclick="return confirmDelete()"><img src="<?php echo base_url(); ?>images/delete.gif" alt="Delete" border="0" /></a></td-->
							   <td width="45" align="center"><?php 
							/*$arrTreeNames = array();	
							$arrTrees =  array('DOC'=>'Document', 'DIS'=>'Discussion', 'CHAT'=>'Chat', 'ACT'=>'Activity', 'NOT'=>'Notes', 'CON'=>'Contact', 'TAG'=>'Tag', 'Oth'=>'Other');
							$arrSelectedTrees = explode('|', $data['trees']);
							foreach($arrSelectedTrees as $arrData)
							{
								$arrTreeNames[] = 	$arrTrees[$arrData];	
							}
							echo implode(', ', $arrTreeNames);	*/
							if(in_array('DOC',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							   <td width="45" align="center"><?php 
						if(in_array('DIS',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							      <td width="45" align="center"><?php 
						if(in_array('CHAT',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							      <td width="45" align="center"><?php 
						if(in_array('ACT',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							      <td width="45" align="center"><?php 
						if(in_array('NOT',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							      <td width="45" align="center"><?php 
						if(in_array('CON',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							      <td width="45" align="center"><?php 
						if(in_array('TAG',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?></td>
							    <td width="45" align="center"><?php 
						if(in_array('Oth',$arrSelectedTrees)){?><img src="<?php echo base_url(); ?>images/checkbox.gif" />
							<?php }	else{
							?><img src="<?php echo base_url(); ?>images/checkbox_blank.gif" />
							<?php
							}
						?> </td>
							</tr>
							<?php
							}
						}
						else
						{
						?>
                        <tr>
                          <td colspan="9"><?php echo $this->lang->line('msg_topics_not_available');?></td>                        
                        </tr>
						<?php
						}
						?>		
                     
                      </table></td>
                    </tr>
                  
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
