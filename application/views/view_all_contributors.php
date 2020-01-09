<?php //echo "workspaceId= " .$workSpaceId; exit;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div  class="clsLabel" style=" padding: 0px 10px;" >
<?php
echo $this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName);

 ?>	

</body>
</html>