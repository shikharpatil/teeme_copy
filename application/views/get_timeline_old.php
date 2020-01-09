<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<div>
<?php 
//echo '<pre>';
//print_r($arrTimeline); 
?>
</div>
<div class="talkformchat">
<?php
$this->load->helper('form'); 
$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('new_chat/index/'.$treeId.'/1', $attributes);
?>

<div > <!-- Leaf Container starts -->
  <?php
	$totalNodes = array();
	
	
	
	$rowColor1='row1';
	$rowColor2='row2';	
	$i = 1;	
	
	
	if(count($arrTimeline) > 0)
	{				 
		foreach($arrTimeline as $keyVal=>$arrVal)
		{
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			
			$checksucc 		=	$this->chat_db_manager->checkSuccessors($arrVal['nodeId']);
			
			//$this->chat_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
			//$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			 
			if ($arrVal['nodeId'] == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
				
			if ($arrVal['chatSession']==0)
			{?>
  
  <!-- new node -->
  
  <div class="clr"></div>
  <div >
    <div class="<?php echo $nodeBgColor."1"; ?> handCursor"  >
      
      
      <div>
        <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"   >
          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?> </div>
        </div>
        <div class="clr"></div>
        <div style="height:18px;" >
          <div class="clr"></div>
        </div>
        </div>
    </div>
</div>
  <?php
		}
		
		
		$i++;
		}
	}
	 
?>
</div>
<input name="reply" type="hidden" id="reply" value="1">
<input name="editStatus" type="hidden" id="editStatus" value="0">
<input name="editorname1" id="editorname1" type="hidden"  value="">
<input name="nodeId" type="hidden" id="nodeId" value="">
<input name="vks" type="hidden" id="vks" value="1">
<input name="chat_view" type="hidden" id="chat_view" value="1">
<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
</form>
</div>
<?php 
$totalNodes[] = 0;
?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

