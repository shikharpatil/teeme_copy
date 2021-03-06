<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
				    <tr>
				      <td colspan="4" class="tdSpace">
					    <ul class="rtabs">
					    <li><a href="<?php echo base_url().'admin/admin_help';?>"><span><?php echo $this->lang->line('txt_View_Topics');?></span></a></li>
					    <li><a href="<?php echo base_url().'admin/admin_help/create_topic';?>"><span><?php echo $this->lang->line('txt_Create_Topic');?></span></a></li>		
						 <li><a href="<?php echo base_url().'admin/admin_help/view_sub_topic';?>"  class="current"><span><?php echo $this->lang->line('txt_View_Sub_Topics');?></span></a></li>			
					    <li><a href="<?php echo base_url().'admin/admin_help/create_sub_topic';?>"><span><?php echo $this->lang->line('txt_Create_Sub_Topic');?></span></a></li>
					    </ul>				
				      </td>
				    </tr>
				    <tr>
				      <td class="subHeading" colspan="4">&nbsp;</td>
				    </tr>
                    
              
                    <tr>
                      <td class="subHeading" colspan="4"><table width="99%"  border="0">
                        <tr>
                          <td colspan="2"><strong><?php echo $this->lang->line('txt_Sub_Topic_Details');?> </strong></td>
                        </tr>
						   <tr>
                          <td width="22%"><?php echo $this->lang->line('txt_Topic_Name');?> </td>
                          <td><?php echo $arrSubTopics['topicName'];?></td>
                        </tr>
                        <tr>
                          <td width="22%"><?php echo $this->lang->line('txt_Sub_Topic_Name');?> </td>
                          <td><?php echo $arrSubTopics['subTopicName'];?></td>
                        </tr>
                   	  <tr>
                          <td width="22%"><?php echo $this->lang->line('txt_Contents');?> </td>
                          <td><?php echo $arrSubTopics['contents'];?></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong><?php echo $this->lang->line('txt_Sub_Topic');?>: (<?php echo $this->lang->line('txt_Other_Languages');?>)</strong></td>
                        </tr>
						<?php 
						if(count($arrLangSubTopics) > 0)		
						{
							foreach($arrLangSubTopics as $data)
							{
							?>
							<tr>
							  <td colspan="2"><strong><?php echo $languages[$data['langCode']];?></strong> - <a href="<?php echo base_url();?>admin/admin_help/edit_lang_sub_topic/<?php echo $data['subTopicId'];?>/<?php echo strtolower($data['langCode']);?>"><?php echo $this->lang->line('txt_Edit');?></a></td>
							</tr>	
							<tr>
								  <td><?php echo $this->lang->line('txt_Sub_Topic_Name');?>:</td>
							  <td><?php echo $data['subTopicText'];?></td>
							</tr>
							<tr>
								  <td><?php echo $this->lang->line('txt_Contents');?></td>
							  <td><?php echo $data['contents'];?></td>
							</tr>
							<tr>
							  <td colspan="2"><hr /></td>
							</tr>
							<?php
							}
						}
						else
						{		
						?>
							<tr>
							  <td colspan="2"><?php echo $this->lang->line('txt_None');?></td>
							</tr>
							<tr>
							  <td colspan="2"><hr /></td>
							</tr>
						<?php
						}
						?>	
                        <tr>
                          <td colspan="2">
							<?php 
							if(count($arrLangSubTopics) < count($languages))
							{?>

							<a href="<?php echo base_url();?>admin/admin_help/create_lang_sub_topic/<?php echo $arrSubTopics['subTopicId'];?>"><?php echo $this->lang->line('txt_Add_Language');?></a> 
							<?php
							}
							?>
						</td>
                        </tr>
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
