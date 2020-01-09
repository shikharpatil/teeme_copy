<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>

	<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

		var node_lock=0;

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

    

    <script language="JavaScript" src="<?php echo base_url();?>js/document.js"></script>

    <script language="JavaScript" src="<?php echo base_url();?>js/document_js.js"></script>

   

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document.js"></script>

    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>

    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/validation.js"></script>

    <script type="text/javascript" language="JavaScript1.2">mmLoadMenus();</script>

    

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>

	

	<!--<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>-->

	

	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 

	

	<!-- for sub modal -->

	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script> 

	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script> 
</head>

<body>

<div>
<div style="margin-left:10px;" >

<!--Export options code start here-->
<div style="width:90%;" >
<div style="margin-right:10px; float:left;" class="txtExportAs">
	<?php echo $this->lang->line('txt_Export_As'); ?>
</div>
<?php /*?>
<div class="newListSelected"  tabindex="0" style="position: relative; outline:none; margin-top:2px;">
<div class="selectedTxt" onclick="showTreeOptions()" ></div>
<ul id="ulTreeOption" style="display:none;" class="newList exportPopup">		
<?php if($treeName=='docs' || $treeName=='notes'){?>
 <li><a style="cursor:pointer;" id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'exportFile',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Html');?></a></li>
<?php } ?>
<li >
	<a class="NewListHover seedDropDown" href="<?php echo base_url();?>pdf_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('txt_Pdf'); ?></a>
</li>
<li >
	<a class="NewListHover seedDropDown" href="<?php echo base_url();?>doc_generator/index/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $treeName; ?>"><?php echo $this->lang->line('txt_Doc'); ?></a>
</li>
</ul>
</div>
<?php */?>
<div style="float:left;">
<?php if($treeName=='docs' || $treeName=='notes'){?>
<div><input type="radio" name="treeType" id="treeType" value="html,<?php echo $treeId ?>"  <?php /*?>onclick="documentTreeOperations(this,'exportFile',<?php echo $treeId; ?>)"<?php */?>  ><?php echo $this->lang->line('txt_Html');?></div>
<?php } ?>

<div><input type="radio" name="treeType" id="treeType" value="pdf,<?php echo $treeId ?>,<?php echo $treeName ?>" <?php /*?>onclick="documentTreeOperations(this,'exportPdf',<?php echo $treeId; ?>,'<?php echo $treeName; ?>')"<?php */?>  ><?php echo $this->lang->line('txt_Pdf');?></div>

<?php if($deviceName!='tablet' && $ismobile!=1){ ?>
<div><input type="radio" name="treeType" id="treeType" value="doc,<?php echo $treeId ?>,<?php echo $treeName ?>" <?php /*?>onclick="documentTreeOperations(this,'exportDoc',<?php echo $treeId; ?>,'<?php echo $treeName; ?>')"<?php */?>  ><?php echo $this->lang->line('txt_Doc');?> <span class="clsLabel"><?php echo $this->lang->line('txt_doc_export_compatible'); ?></span></div>
<?php } ?>

<div style="margin-top:5px;">
<input name="submit" id="submit" value="Done" onclick="exportTree();" type="button">
</div>
</div>
</div>
<?php /*?><div style="clear:both"></div>
<div style="float:left;">
<input name="submit" id="submit" value="Done" onclick="exportTree();" type="button">
</div><?php */?>
<!--Export Options code end-->
	
</div>
</div>			

</body>	
</html>	
<script>
	function exportTree()
	{
		var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
		var exportType = $("input[name='treeType']:checked").val();
		//alert(exportType+'=='+workSpaceId);
		
		if(exportType=='' || typeof(exportType)=='undefined')
		{
			jAlert('<?php echo $this->lang->line('txt_select_export_type') ?>');
			return false;
		}
		
		if(exportType!='' && typeof(exportType)!='undefined')
		{
			var tmpArray = exportType.split(',');
			if(tmpArray[0]=='html')
			{
				if(isios==true)
				{
					parent.window.open(baseUrl+'create_xml_file/index/'+tmpArray[1],"mywindow");
				}
				else
				{
					window.location = baseUrl+'create_xml_file/index/'+tmpArray[1];
				}
			}
			else if(tmpArray[0]=='pdf')
            {
				if(isios==true)
				{
					parent.window.open(baseUrl+'pdf_generator/index/'+tmpArray[1]+'/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[2],"mywindow");
				}
				else
				{
					window.location = baseUrl+'pdf_generator/index/'+tmpArray[1]+'/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[2];	
				}
			}
			else if(tmpArray[0]=='doc')
			{
				window.location = baseUrl+'doc_generator/index/'+tmpArray[1]+'/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[2];
			}
			
		}
	}
</script>		