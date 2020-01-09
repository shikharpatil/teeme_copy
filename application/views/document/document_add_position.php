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
	<form name="documentAddPosForm" id="documentAddPosForm">	
		<div id="spanMoveTree" style="display:block; margin-left:2%">
			<div style="margin:5px 0 0 0;">
				<div class="lblMoveTree"><?php echo $this->lang->line('txt_select_position'); ?></div>
				<div class="floatLeft">
					<select name="select" id="selPos">
						<option value="1" <?php if($position == 1) echo 'selected';?>><?php echo $this->lang->line('txt_Anywhere'); ?></option>
						<option value="2" <?php if($position == 2) echo 'selected';?>><?php echo $this->lang->line('txt_At_Top'); ?></option>
						<option value="3" <?php if($position == 3) echo 'selected';?>><?php echo $this->lang->line('txt_At_Bottom'); ?></option>
						<!-- <option value="4" <?php if($position == 4) echo 'selected';?>><?php echo $this->lang->line('txt_Top_and_bottom'); ?></option> -->
					</select>     
				</div>
			</div>
	        <div style="clear: both;"></div>

		    <div style="margin:10px 0 0 0;">
		    	<span id="buttonDocumentAddPos">
					<input name="createLeaf" type="button" onclick="documentAddPosition('<?php echo $treeId; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>')" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"> 
					<input name="cancelCreateLeaf" type="button" onclick="resetdocumentAddPosForm();" value="<?php echo $this->lang->line('txt_Cancel');?>"  class="button01">
				</span>
				<span id="loaderDocumentAddPos" style="display:none;">
					<img src="<?php echo base_url();?>images/ajax-loader-add.gif">
				</span>
			</div>
			<div style="clear: both;"></div>
			<br/>
			<div class="floatLeft">
				<span id="documentAddPosErrorMessage" style="color: red;"></span>
			</div>
		</div>
	</form>
</body>	
</html>	
<script>
function resetdocumentAddPosForm()
{
	if(document.getElementById('documentAddPosForm') !== null)
	{
		document.getElementById('documentAddPosForm').reset();
	}
	document.getElementById('documentAddPosErrorMessage').innerHTML="";
}
</script>