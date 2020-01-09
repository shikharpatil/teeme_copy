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
				<!-- Start Main Body -->
					<table width="99%" border="0">
              		<?php
						if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
						{
					?>
              				<tr>
                				<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
                                </td>
              				</tr>
              		<?php } ?>
                    
                    <tr>
                    	<td align="center" valign="top" height="50"><h1>Editor Options (<?php echo $editorName; ?>)</h1></td>
                    </tr>
                    <?php 	if(count($editorDetails) > 0)
							{
					?>
                    <form name="frmSelectEditor" action="<?php echo base_url();?>admin/admin_home/editor_options" method="post">

                    <tr>
                    	<td align="left">
                        

                        
                        	<table width="100%" border="0">
	                            <?php 	$count=0;
								foreach($editorDetails as $keyVal=>$editorData)
								{
								?>	
        
        						<?php if ($count%2 ==0) { ?>
                            	<tr>

                                	
                                	<td>
                        
                        		<input type="checkbox" name="<?php echo $editorData['optionId']; ?>" value="<?php echo $editorData['optionName']; ?>" <?php if($editorData['optionAllowed']) echo "checked"; ?> /><?php echo $editorData['optionName']; ?>
                                
                     
                        			</td>
                                 <? } else { ?>
                                    <td>
                        
                        		<input type="checkbox" name="<?php echo $editorData['optionId']; ?>" value="<?php echo $editorData['optionName']; ?>" <?php if($editorData['optionAllowed']) echo "checked"; ?> /><?php echo $editorData['optionName']; ?>
                                
                     
                        			</td>
                                  

                                </tr>
                                  <? } ?>
                               <?php
								$count++;
								}
								?>                                
					
                            </table>

                        
                        </td>
                    </tr>

                    
                    <tr>
                    	<td height="50" valign="bottom" align="left">
                        	<input type="hidden" name="editor_id" value="<?php echo $editorId; ?>" />
                            <input type="hidden" name="editor_name" value="<?php echo $editorName; ?>" />
                        	<input type="submit" name="Submit" value="Update" />
                            
                        </td>
                    </tr>
                     </form>
                    <?php		
							}
							else
							{
					?>
					 <tr>
                		<td>No Options found !!!!!</td>
              		</tr>
                   	<?php
							}
					?>
              
              	

            		</table>
				<!-- End Main Body -->
				
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
