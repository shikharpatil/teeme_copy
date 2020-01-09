<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<!--Manoj: code for contributors start-->

<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

		var node_lock=0;

</script>

<!--Manoj: code for contributors end-->

<?php $this->load->view('common/view_head.php');?>

<script language="javascript" src="<?php  echo base_url();?>js/identity.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>


	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

</head>

<body>
<div id="wrap1">
  <div id="header-wrap">
		<?php $this->load->view('common/header'); ?>
		<?php $this->load->view('common/wp_header'); ?>
</div>
</div>			
	
		<div id="container" style="padding:0px 0px 40px">
		<div id="content" style="margin-top:1%; width:96%;">
		<form method="post" action="">
			<div style="font-size:1.7em;">
				<?php //echo $this->lang->line('txt_head_terms'); ?>
			</div>
			<div style="text-align:justify;">
			<?php
				$lang='english';
				$lang=$_COOKIE['lang'];
				$this->load->view('terms/terms_'.$lang.'.php');
			?>
			</div>
			<?php /*?><div style="margin-top:15px;">
				<input type="checkbox" id="acceptTerms" class="acceptTerms" name="acceptTerms" onchange=""/>
				<span><?php echo $this->lang->line('txt_agreed_terms'); ?></span>
			</div><?php */?>
			<div style="margin-top:2%;">
				<input name="terms" value="<?php echo $this->lang->line('txt_agreed_terms_btn'); ?>" class="terms" type="submit">
				<input name="cancel" value="<?php echo $this->lang->line('txt_Cancel'); ?>" class="cancel" type="button" onclick="cancelTerms()">
			</div>
		</form>
		</div>
		</div>	
			 
		<?php //$this->load->view('common/foot.php');?>
		<?php $this->load->view('common/footer');?>
</body>
</html>
<script>
function cancelTerms()
{
	window.location.href = "<?php echo base_url() ?>instance/admin_logout/work_place";
}
function termsCheck()
{/*
	var err='';

	var checked = $("#acceptTerms").is(':checked');
	
    if(!checked) 
	{
		err +="Please accept terms and conditions.";
    }
	
	if(err!=''){
		alert (err);
		return false;
	}
	else
	{
		return true;
	}

*/}
</script>