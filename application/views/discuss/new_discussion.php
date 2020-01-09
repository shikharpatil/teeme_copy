<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />
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
<?php 	if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)
		{
	?>
<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>
<?php
		}         
	?>
<script language="javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/document.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/ajax.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/identity.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/tag.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>

<!-- script for menu item -->
<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
<!--/*Changed By surbhi IV*/-->

<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
<!--/*End of Changed By surbhi IV*/-->
<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
<!-- script close here --->
</head>
<body onLoad="showFocus()">
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content"> 
    
    <!-- Main menu -->
    <?php
	$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
	$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
    <table width="100%">
      <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>
      <tr>
        <td height="18"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
      </tr>
      <?php
	}
	?>
      <tr>
        <td height="250" valign="top" bgcolor="#FFFFFF"><form name="form1" method="post" action="<?php echo base_url();?>new_discussion/start_Discussion/<?php echo $pnodeId;?>/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php if(isset($title)){?>
                  <?php echo $this->lang->line('txt_Title');?>:
                  <textarea name="title" id="title"></textarea>
                  <?php  }?></td>
              </tr>
              <tr>
                <td><br>
                  <?php echo $this->lang->line('txt_Topic');?>:<br>
                  <textarea name="replyDiscussion" id="replyDiscussion"></textarea>
                  &nbsp; <script language="javascript">
 chnage_textarea_to_editor('title','simple');
 chnage_textarea_to_editor('replyDiscussion');

	</script></td>
              </tr>
              <tr>
                <td><input type="button" value="<?php echo $this->lang->line('txt_Done');?>" onClick="return validate_dis();" class="button01"/>
                  <input type="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="document.location='<?php echo base_url();?>discussion/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';" class="button01"/>
                  <input name="reply" type="hidden" id="reply" value="1">
                  <input name="editorname1" type="hidden"  value="replyDiscussion">
                  <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
                  <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
                  <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
                  <input type="hidden" name="linkType_vk" value="<?php echo $linkType_vk;?>" id="linkType_vk"></td>
              </tr>
            </table>
          </form></td>
      </tr>
    </table>
  </div>
</div>
<?php $this->load->view('common/footer');?>
</body>
</html>
<script>function showFocus()
	{
		parent.frames[0].gk.EditingArea.focus();
	} 
	 

 
function validate_dis(){
	var error=''
	if(getvaluefromEditor('title')==''){

	 	error+='<?php echo $this->lang->line('enter_discussion_title'); ?>\n';

	}
	if(getvaluefromEditor('replyDiscussion')==''){

	 	error+='<?php echo $this->lang->line('enter_topic'); ?>\n';

	}

	if(error==''){
		document.form1.submit();
	}else{
		jAlert(error);
	}
	
}
 
function reply(id)
{
	divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';

	rameid=id;	
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}</script>