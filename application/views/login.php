<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head'); ?>

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		//var workSpaceId		= '<?php //echo $workSpaceId;?>';

		//var workSpaceType	= '<?php //echo $workSpaceType;?>';

	</script>



	<script language="javascript">

		//var errmsg 		= '<?php echo base_url();?>';	

		//var workSpaceId		= '<?php //echo $workSpaceId;?>';

		//var workSpaceType	= '<?php //echo $workSpaceType;?>';

	</script>

	

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

</div>

</div>

<div id="container">

<div id="content" >

	<?php
		if($_COOKIE['place'])
		{
			$placeName = $_COOKIE['place'];
		}
		else
		{
			$placeName = '';
		}
	?>

	<span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?><br /><a href="<?php echo base_url().$placeName;?>"><?php echo $this->lang->line('txt_Login');?></a></span>

</div>

</div>

<div>

<?php $this->load->view('common/footer');?>

</div>

</body>

</html>

<?php $this->load->view('common/foot'); ?>