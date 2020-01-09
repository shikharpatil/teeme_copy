<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document > New</title>
<?php $this->load->view('common/view_head');?>
<script>
var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
var workSpace_name='<?php echo $workSpaceId;?>';
var workSpace_user='<?php echo $_SESSION['userId'];?>';
</script>
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
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container" style="width:87.3%" >
  <div id="content"> 
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
			?>
    <!-- Main Body -->
    <form action="<?php echo base_url();?>process_document" name="frmDocument" id="frmDocument" method="post" enctype="multipart/form-data">
      <span class="docLabel"><?php echo $this->lang->line('txt_Document_Title');?>: </span><span id="docTitle">
      <div class="docTextDiv"><br />
        <textarea name="documentTitle" id="documentTitle"  ></textarea>
      </div>
      </span></a>
      <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>
      <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
      <?php
	}
	?>
      <br />
      <br />
      <input type="hidden" name="saveOption1" value="0" id="saveOption1">
      <input type="hidden" name="titleOption" value="0" id="titleOption">
      <input type="hidden" name="nextPage" value="exit" id="nextPage">
      <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
      <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
      <input type="hidden" name="nodeId" value="<?php echo $nodeId;?>" id="nodeId">
      <input type="hidden" name="nodeType" value="<?php echo $nodeType;?>" id="nodeType">
      <input type="hidden" name="linkType_vk" value="<?php echo $linkType_vk;?>" id="linkType_vk">
      <input name="editorContents" id="editorContents" value='' type="hidden" />
      <div class="docTextDiv">
        <?php
				  	if($_SESSION['editor']==2)
					{
					?>
        <input type="button" value="<?php echo $this->lang->line('txt_Done');?>" onClick="return saveDocument2();" class="button01"/>
        <?php 	
					}
					else
					{
					?>
        <input type="button" value="<?php echo $this->lang->line('txt_Done');?>" onClick="return saveDocument();" class="button01"/>
        <?php
					}
					?>
        <input type="button" name="cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="document.location='<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';" class="button01"/>
      </div>
    </form>
  </div>
</div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
<script>

//chnage_textarea_to_editor('documentTitle','simple');

</script>