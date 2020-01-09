<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document > New</title>
<?php $this->load->view('common/view_head');?>
<?php $this->load->view('editor/editor_js.php');?>
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
<body >
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
</div>
<div id="container_for_mobile" style="width:87.3%" >
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
     <!--Manoj: Commented version date -->
	  <?php /*?><span class="docLabel"><?php echo $this->lang->line('txt_Version');?>:&nbsp;&nbsp;1</span> <br />
      <span class="docLabel"><?php echo $this->lang->line('txt_Originator');?>:&nbsp;&nbsp;<?php echo $_SESSION['userTagName'];//echo $_SESSION['userFirstName'].' '.$_SESSION['userLastName'];?> </span><br />
      <span class="docLabel"><?php echo $this->lang->line('txt_Date');?>: &nbsp;&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(),'m-d-Y h:i A');?></span> <br><?php */?>
	  <!--Manoj: Commented version date -->
      <span class="docLabel"><?php echo $this->lang->line('txt_Document_Title');?>: </span>
	  <!--Manoj: added class TextMob and TitleMob-->
      <div class="docTextDiv TextMob">
        <textarea name="documentTitle" id="documentTitle" class="TitleMob"  ></textarea>
      </div>
      </a>
      <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>
      <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
      <?php
	}
	?>
     <!-- <span class="docLabel"><?php //echo $this->lang->line('txt_Idea');?>:</span>-->
      <input type="hidden" name="saveOption1" value="0" id="saveOption1">
      <input type="hidden" name="titleOption" value="0" id="titleOption">
      <input type="hidden" name="nextPage" value="exit" id="nextPage">
      <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
      <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
      <input type="hidden" name="nodeId" value="<?php echo $nodeId;?>" id="nodeId">
      <input type="hidden" name="nodeType" value="<?php echo $nodeType;?>" id="nodeType">
      <input type="hidden" name="linkType_vk" value="<?php echo $linkType_vk;?>" id="linkType_vk">
      <br>
	  <!--Manoj: Commented editor-->
     <!-- <div class="docTextDiv">
        <textarea id="editorContents2" name="editorContents2"></textarea>
      </div>-->
	  <!--Manoj: Commented editor-->
	 
      <input name="editorContents" id="editorContents" value='' type="hidden" />
      <div class="docLabel">
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
					//Manoj: Added cancel url
					$cancelUrl = base_url().'document_home/index/'.$workSpaceId.'/type/'.$workSpaceType;
					?>
        <input type="button" name="cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="cancelDocument('<?php echo $cancelUrl; ?>');" class="button01"/>
      </div>
	  <div class="clr"></div>
    </form>
  </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
<script>
//chnage_textarea_to_editor('editorContents2');
//chnage_textarea_to_editor('documentTitle','simple');
//Manoj: Redirect page on cancel
function cancelDocument(url)

{

	window.location = url;

}
//Manoj: Redirect page on cancel end

</script>