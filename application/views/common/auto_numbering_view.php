<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
	
	<?php $this->load->view('common/view_head.php');?>
	
	<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	
	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script> 

	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script>
	
</head>
<body>
	<form name="frmAutonumbering" id="frmAutonumbering">	
		<div id="spanMoveTree" style="display:block; margin-left:2%">
			<div style="margin:5px 0 0 0;">
				<div class="lblMoveTree"><?php echo $this->lang->line('txt_Use_numbering'); ?></div>
				<div class="floatLeft">
					<input type="checkbox" id="autonumbering" name="autonumbering" <?php  if($autonumbering==1) {echo 'checked';}?> onClick="autoNumberingUpdate(<?php echo $treeId; ?>);"/>   
				</div>
			</div>
		</div>
	</form>
</body>	
</html>	
