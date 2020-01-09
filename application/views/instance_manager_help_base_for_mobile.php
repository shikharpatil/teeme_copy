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
<?php $this->load->view('common/admin_header_for_mobile'); ?>
<?php 
					$this->load->view('instance/common/top_links_for_mobile');
					?>  
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" align="left" valign="top">
                  	<!-- Begin Top Links -->			
					   
					<!-- End Top Links -->
                  </td>
                </tr>
                <tr>
                	<td>
						<?php 
							$this->load->view('help/instance_manager_help_for_mobile');
						?>
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
