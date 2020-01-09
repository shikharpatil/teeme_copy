<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
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
<?php $this->load->view('common/admin_header_for_mobile'); ?>
  	<!-- Begin Top Links -->			
					<?php 
					$this->load->view('instance/common/top_links_for_mobile');
					?>     
					<!-- End Top Links -->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          
         
        
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" align="left" valign="top">
                
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top">
					<!-- Start Main Body -->
					<table width="99%" border="0">
					<tr>
                        <td colspan="2" align="left" valign="top" class="tdSpace">
                        	<ul class="rtabs">
                				<li><a href="<?php echo base_url()?>instance/home/select_editor"><span style="padding:0 5px;">Select Editor</span></a></li>
                				<li><a href="<?php echo base_url()?>instance/home/editor_options/tinyadvance" <?php if ($editorName=='tinyadvance') {echo 'class=current';}?>><span style="padding:0 5px;">Tiny Advance</span></a></li>
								<li><a href="<?php echo base_url()?>instance/home/editor_options/tinysimple" <?php if ($editorName=='tinysimple') {echo 'class=current';}?>><span style="padding:0 5px;">Tiny Simple</span></a></li>
            					<li><a href="<?php echo base_url()?>instance/home/editor_options/fckadvance" <?php if ($editorName=='fckadvance') {echo 'class=current';}?>><span style="padding:0 5px;">FCK Advance</span></a></li>
            					<li><a href="<?php echo base_url()?>instance/home/editor_options/fcksimple" <?php if ($editorName=='fcksimple') {echo 'class=current';}?>><span style="padding:0 5px;">FCK Simple</span></a></li>
            				</ul>
                        </td>
					</tr>
                    
                    <?php
					if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
					{
					?>
              		<tr>
                		<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
              		</tr>
              		<?php } ?>
                    
                    <tr>
                    	<td align="center" valign="top" height="50"><h1>Editor Options (<?php echo $editorName; ?>)</h1></td>
                    </tr>
                    <?php 	if(count($editorDetails) > 0)
							{
					?>
                    <form name="frmSelectEditor" action="<?php echo base_url();?>instance/home/editor_options" method="post">

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
                                 <?php } else { ?>
                                    <td>
                        
                        		<input type="checkbox" name="<?php echo $editorData['optionId']; ?>" value="<?php echo $editorData['optionName']; ?>" <?php if($editorData['optionAllowed']) echo "checked"; ?> /><?php echo $editorData['optionName']; ?>
                                
                     
                        			</td>
                                  

                                </tr>
                                  <?php } ?>
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
         
        </table>
    
<?php $this->load->view('common/footer');?>
</body>
</html>
