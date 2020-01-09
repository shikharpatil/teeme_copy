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
					    <li><a href="<?php echo base_url().'admin/admin_help';?>"><span><?php echo $this->lang->line('txt_View_Topics');?></span></a></li>
					    <li><a href="<?php echo base_url().'admin/admin_help/create_topic';?>"><span><?php echo $this->lang->line('txt_Create_Topic');?></span></a></li>		
						 <li><a href="<?php echo base_url().'admin/admin_help/view_sub_topic';?>" class="current"><span><?php echo $this->lang->line('txt_View_Sub_Topics');?></span></a></li>			
					    <li><a href="<?php echo base_url().'admin/admin_help/create_sub_topic';?>"><span><?php echo $this->lang->line('txt_Create_Sub_Topic');?></span></a></li>
					    </ul>				
				      </td>
				    </tr>
				    <tr>
				      <td class="subHeading" colspan="4"><strong><?php echo $this->lang->line('txt_Sub_Topic_Details');?>:</strong></td>
				    </tr>
                    
              
                    <tr>
                      <td class="subHeading" colspan="4">
						<form name="frmTopic" action="<?php echo base_url().'admin/admin_help/edit_sub_topic/'.$arrSubTopics['subTopicId'];?>" method="post">
						<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">
                        <tbody>
                          <tr>
                            <td width="179" align="left" valign="middle"><?php echo $this->lang->line('txt_Topic');?>:<span class="text_red">*</span></td>
                            <td align="center" valign="top" class="text_gre">&nbsp;</td>
                            <td align="left" valign="top" class="text_gre1">
							<?php echo $arrSubTopics['topicName'];?>
							</td>
                          </tr>
                          <tr>
                            <td width="179" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Sub_Topic_Name');?>:<span class="text_red">*</span></td>
                            <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>
                            <td width="512" align="left" valign="top" class="text_gre1">
                              <input name="subTopic" class="text_gre1" id="topic" size="30" value="<?php echo $arrSubTopics['subTopicName'];?>"/>                             
                            </td>
                          </tr>
                          <tr>
                            <td width="179" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Contents');?>:<span class="text_red">*</span></td>
                            <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>
                            <td width="512" align="left" valign="top" class="text_gre1">
                             <textarea rows="7" cols="60" name="contents"><?php echo $arrSubTopics['contents'];?></textarea>                           
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="text_gre1">&nbsp;</td>
                            <td align="center" valign="middle" class="text_gre">&nbsp;</td>
                            <td align="left" class="text_gre"><input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Done');?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
						</form>
						</td>
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
