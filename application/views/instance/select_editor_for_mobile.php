<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<?php $this->load->view('common/admin_header_for_mobile'); 

	

?>
<!-- Begin Top Links -->			
					<?php 
					$this->load->view('instance/common/top_links_for_mobile');
					?>     
					<!-- End Top Links -->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top" style="background-image:url(<?php echo base_url();?>images/logo-bg.gif); background-repeat:repeat-x">
			<!-- header -->	
			
			<!-- header -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        
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
                				<li><a href="<?php echo base_url()?>instance/home/select_editor" class="current"><span style="padding:0 5px;">Select Editor</span></a></li>
                				<li><a href="<?php echo base_url()?>instance/home/editor_options/tinyadvance"><span style="padding:0 5px;">Tiny Advance</span></a></li>
								<li><a href="<?php echo base_url()?>instance/home/editor_options/tinysimple"><span style="padding:0 5px;">Tiny Simple</span></a></li>
            					<li><a href="<?php echo base_url()?>instance/home/editor_options/fckadvance"><span style="padding:0 5px;">FCK Advance</span></a></li>
            					<li><a href="<?php echo base_url()?>instance/home/editor_options/fcksimple"><span style="padding:0 5px;">FCK Simple</span></a></li>
            				</ul>
                        </td>
					</tr>
              		<?php 
						if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
						{
					?>
              				<tr>
                				<td colspan="2" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
                                </td>
              				</tr>
              		<?php } ?>
                    <tr>
                    	<td align="left" colspan="2" valign="top"><h1>Select Editor</h1></td>
                    </tr>
                    <tr>
                    	<td style="font-weight:bold;">Advance Editor:</td>
                        <td style="font-weight:bold;">Simple Editor:</td>
                    </tr>
                    <?php 	if(count($editorDetails) > 0)
							{
					?>
                    <form name="frmSelectEditor" action="<?php echo base_url();?>instance/home/select_editor" method="post">
                    <tr>
                    	<td align="left" width="50%">
                    <?php 	foreach($editorDetails as $keyVal=>$editorData)
							{ 
								if ($editorData['editorId'] < 3)
								{
					?>

						<input type="radio" name="editor_adv" value="<?php echo $editorData['editorId']; ?>" <?php if($editorData['editorStatus']) echo "checked"; ?> /><?php echo $editorData['editorName']; ?><br>

                    <?php
								}
							}
					?>
                        </td>
                        <td>
                    <?php 	if(count($editorDetails) > 0)
							{
 							foreach($editorDetails as $keyVal=>$editorData)
							{ 
								if ($editorData['editorId'] > 2)
								{
					?>

						<input type="radio" name="editor_simple" value="<?php echo $editorData['editorId']; ?>" <?php if($editorData['editorStatus']) echo "checked"; ?> /><?php echo $editorData['editorName']; ?><br>

                    <?php
								}
							}
							}
					?>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2" valign="bottom" align="left"><input type="submit" name="Submit" value="Activate" /></td>
                    </tr>
                     </form>
                    <?php		
					}
					else
					{
					?>
					 <tr>
                		<td colspan="2">No editors found !!!!!</td>
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
				
			<!-- Footer -->
			</td>
          </tr>
        </table>
		<?php $this->load->view('common/footer');?>
    
</body>
</html>
