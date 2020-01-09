<li>
	<a class="printpage" onclick="printDiv('container_for_mobile')" style="cursor:pointer;"><?php echo $this->lang->line('print_txt'); ?></a>
	<?php /*?><img class="printpage"  onclick="printDiv('container_for_mobile')" src="<?php echo base_url();?>images/print.png" style="float:right; cursor:pointer; "/><?php */?>
</li>
<?php /*?><?php if($treeName=='docs' || $treeName=='notes'){?>
<li><a id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'exportFile',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Export_File');?></a></li>
<?php } ?>
<li>
	<a href="<?php echo base_url();?>pdf_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('pdf_txt'); ?></a>
</li><?php */?>
<?php /*?><li >
	<a href="<?php echo base_url();?>doc_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('txt_export_word_doc'); ?></a>
</li><?php */?>

<li><a id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'export',<?php echo $treeId; ?>,'<?php echo $treeName; ?>')" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Export');?></a></li>