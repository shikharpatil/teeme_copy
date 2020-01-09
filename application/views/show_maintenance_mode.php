<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

</head>

<body>

<div id="wrap1">

  <div id="header-wrap" style="width:100%;">

    <?php $this->load->view('common/header_maintenance'); ?>
	
  </div>

</div>

<div id="container">

  <div id="content" align="center">
		<div class="offline_active"><?php echo $this->lang->line('offline_txt'); ?></div>
  </div>
  
</div>

<div>

  <?php //$this->load->view('common/foot.php');?>

  <?php $this->load->view('common/footer_maintenance');?>

</div>

</body>

</html>