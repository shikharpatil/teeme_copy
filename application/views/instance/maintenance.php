<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script>
var baseUrl = '<?php echo base_url();?>';
</script>
<script>
function get_maintenance_mode()
{
	var selected = $('#maintenance_mode option:selected');
	
    //alert(selected.val()); 
	var mode_val = selected.val();
	
	if(mode_val==1)
	{
		if (!confirm("Do you want to put the site in offline mode?"))
		{
		  return false;
		}
	}
	
	 $.ajax({

				  url: baseUrl+'instance/maintenance/save_maintenance_mode/'+mode_val,

				  success:function(result)
				  {
				  	$(".applyModeTxt").html('');
				  	if(result=='1')
					{
						//$(".applyModeTxt").html('Maintenance mode applied successfully.');
					}
				  }
				  , 
				  async: false

		});
	
}
</script>
</head>
<body>
<!-- Header -->
<?php $this->load->view('common/admin_header'); ?>
<table width="900px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" align="left" valign="top"><!-- Begin Top Links -->
<?php 
	$this->load->view('instance/common/top_links');
	
?>
</td>
</tr>
<tr>
<td>
<div class="main_div">
<span class="error applyModeTxt"></span>
<div>Maintenance Mode:
 <select name="maintenance_mode" id="maintenance_mode">
  <option value="0" <?php if($offline_mode=='0'){echo 'selected'; } ?> >No</option>
  <option value="1" <?php if($offline_mode=='1'){echo 'selected'; } ?>>Yes</option>
 </select>
</div>
<div class="mode_btn">
 <button onclick="get_maintenance_mode()">Submit</button>
</div>
</div> 
</td>
</tr>
</table>
<!-- Footer -->
<?php  $this->load->view('common/footer');?>
</body>
</html>
