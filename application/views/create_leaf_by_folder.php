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
	<form name="createLeafForm" id="createLeafForm">	
		<div id="spanMoveTree" style="display:block; margin-left:2%">
			<div>
				<div class="lblMoveTree" ><?php echo $this->lang->line('txt_select_folder'); ?></div>
				<div class="floatLeft">
					<select name="select" id="selFolderId">
						<option value=""><?php echo $this->lang->line('txt_select_folder'); ?></option>
						<?php
						foreach($folders as $folder)
						{
						?>
							<option value="<?php echo $folder['folderId'];?>"><?php echo $folder['name']; ?></option>
						<?php
						}
						?>
					</select>     
				</div>
			</div>
	        <div style="clear: both;"></div>
			<div style="margin:5px 0 0 0;">
				<div class="lblMoveTree"><?php echo $this->lang->line('txt_select_position'); ?></div>
				<div class="floatLeft">
					<select name="select" id="selPos">
						<option value="top"><?php echo $this->lang->line('txt_Top'); ?></option>
						<option value="bottom"><?php echo $this->lang->line('txt_Bottom'); ?></option>
					</select>     
				</div>
			</div>
	        <div style="clear: both;"></div>
			<div style="margin:5px 0 0 0;">
				<div class="lblMoveTree"><?php echo $this->lang->line('txt_select_order'); ?></div>
				<div class="floatLeft">
					<select name="select" id="selOrder">
						<option value="alphabetical">A-Z</option>
						<option value="reverse_alphabetical">Z-A</option>
						<option value="chronological">Date ascending</option>
						<option value="reverse_chronological">Date descending</option>
						<option value="order_ascending">Order ascending</option>
						<option value="order_descending">Order descending</option>
					</select>     
				</div>
			</div>
			<div style="clear: both;"></div>
			<div style="margin:5px 0 0 0;"> 
				<div class="lblMoveTree"> 
					<?php echo $this->lang->line('txt_Add_caption');?>
				</div>
				<div class="floatLeft">
					<input type="checkbox" checked="checked" name="addCaption" id="addCaption"> (<?php echo $this->lang->line('txt_Yes');?>)
				</div>
			</div>
	        <div style="clear: both;"></div>
		    <div style="margin:10px 0 0 0;">
		    	<span id="buttonCreateLeaf">
					<input name="createLeaf" type="button" onclick="createLeafByFolder('<?php echo $treeId; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>')" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"> 
					<input name="cancelCreateLeaf" type="button" onclick="resetCreateLeafForm();" value="<?php echo $this->lang->line('txt_Cancel');?>"  class="button01">
				</span>
				<span id="loaderCreateLeaf" style="display:none;">
					<img src="<?php echo base_url();?>images/ajax-loader-add.gif">
				</span>
			</div>
			<div style="clear: both;"></div>
			<br/>
			<div class="floatLeft">
				<span id="createLeafErrorMessage" style="color: red;"></span>
			</div>
		</div>
	</form>
</body>	
</html>	
<script>
function resetCreateLeafForm()
{
	if(document.getElementById('createLeafForm') !== null)
	{
		document.getElementById('createLeafForm').reset();
	}
	document.getElementById('createLeafErrorMessage').innerHTML="";
}
</script>