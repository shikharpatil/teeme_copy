<li>
	<?php
	/*Added by Dashrath- Added for checking device type start*/
	$deviceName = '';
	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	$devicesTypes = array(
		"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
		"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
	);
	foreach($devicesTypes as $deviceType => $devices) {           
		foreach($devices as $device) {
			if(preg_match("/" . $device . "/i", $userAgent)) {
				$deviceName = $deviceType;
			}
		}
	}
	/*Dashrath- Added for checking device type end*/
	?>

	<?php 
  	if($deviceName != 'tablet') 
  	{
  	?>
		<a class="printpage NewListHover seedDropDown" onclick="printDiv('rightSideBar')"><?php echo $this->lang->line('print_txt'); ?></a>
	<?php
	}
	?>
	
	<?php /*?><img class="printpage"  onclick="printDiv('container')" src="<?php echo base_url();?>images/print.png" style="float:right; cursor:pointer; "/><?php */?>
</li>
<?php /*?>
<?php if($treeName=='docs' || $treeName=='notes'){?>
 <li><a style="cursor:pointer;" id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'exportFile',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Export_File');?></a></li>
<?php } ?>
<li >
	<a class="NewListHover seedDropDown" href="<?php echo base_url();?>pdf_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('pdf_txt'); ?></a>
</li>
<li >
	<a class="NewListHover seedDropDown" href="<?php echo base_url();?>doc_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('txt_export_word_doc'); ?></a>
</li><?php */?>

<li><a style="cursor:pointer;" id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'export',<?php echo $treeId; ?>,'<?php echo $treeName; ?>')" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Export');?></a></li>