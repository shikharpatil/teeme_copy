<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
$position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
?>

<div style="width:100%;">
  <?php
	$totalNodes = array();
	if(count($arrDiscussions) > 0)
	{
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);			
			$checksucc 		=	$this->chat_db_manager->checkSuccessors($arrVal['nodeId']);			
			$this->chat_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			
			$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
				if($arrVal['predecessor'] > 0)
				{
					$chatBgColor = 'chatBgColor1';
				}
				else
				{
					$chatBgColor = 'chatBgColor2';
				}

			if ($arrVal['chatSession']==0)
			{
		?>
<!--Manoj: padding left default 50 in if condition-->
  <div style="padding-left:<?php if ($arrVal['predecessor']>0) {echo 0;} else {echo 0;}?>px; margin-top:10px;">
    <div id="<?php echo $position++; ?>" style=" padding-left:10px;" class="<?php echo $chatBgColor;?> handCursor" <?php if($arrVal['predecessor'] == 0) { if($timmer) { ?> onclick="showReply(0,<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>; parent.replay_target=0;" <?php }	 } else {if($timmer) { ?> onclick="showReply(0,<?php echo $arrVal['predecessor'];?>),nodeId=<?php echo $arrVal['predecessor'];?>; parent.replay_target=0;" <?php } } ?> >
    <a href="<?php  echo base_url(); ?>view_chat/node1/<?php echo $treeId; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/1/<?php echo $arrVal['nodeId'];?> " style="text-decoration:none" > <?php echo stripslashes($arrVal['contents']); ?> </a>
    <div style="width:100%; padding-left:0px; margin-top:5px;" class="<?php echo $chatBgColor;?> handCursor"> <font color="#006699" size="1"><i><?php echo $userDetails1['userTagName'] .'  '.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;?></i></font> </div>
  </div>
  <div id="normalView<?php echo $arrVal['nodeId'];?>" style="width:100%; padding-left:10px; display:none;" class="<?php echo $chatBgColor;?> handCursor">
    <?php 					
					if($arrVal['predecessor'] == 0)
					{
						if($timmer){?>
    <a href="javascript:void(0);" ><?php echo $this->lang->line('txt_Reply');?></a>
    <?php }
					}
					else
					{
						if($timmer){?>
    <a href="javascript:void(0);" ><?php echo $this->lang->line('txt_Reply');?></a>
    <?php }
					}
					?>
  </div>
  <?php 				
			if($arrVal['predecessor'] > 0)
			{
			?>
  <div style="width:100%;" class="<?php echo $chatBgColor;?> handCursor"> <?php echo '<i><font size="1">'.$this->lang->line('txt_Topic').': '.$this->identity_db_manager->formatContent(strip_tags($this->chat_db_manager->getTopicByNodeId($treeId, $arrVal['predecessor'])),130,1).'</font></i>'; ?> </div>
  <?php
			}
			?>
  <div style="float:left; ">
    <?php			
			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);			
			?>
  </div>
  <?php
		
			} // end if
			else
			{
				if ($arrVal['chatSession']==2)
					$chatSessionBGColor = 'chatSessionBGStop';
				else
					$chatSessionBGColor = 'chatSessionBGStart';
			?>
  <div style="width:99%; margin-left:0px;" class="<?php echo $chatSessionBGColor; ?>">
    <?php 
									if ($arrVal['chatSession']==2)
									{
										echo $this->lang->line('txt_Stopped_At') .' ' .$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;
									}
									else
									{
										echo $this->lang->line('txt_Started_At') .' ' .$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;
									}
								?>
  </div>
  <?php	
			}
			?>
</div>
<?php
		}
	}
?>
</div>
<?php 
$totalNodes[] = 0;
?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<a id="focusDown" href="javascript:void(0);" style="color:#FFFFFF;"></a> 
<script>

function getHTTPObjectm() { 
	var xmlhttp; 
	if(window.XMLHttpRequest){ 
		xmlhttp = new XMLHttpRequest(); 
	}else if(window.ActiveXObject){ 
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		if(!xmlhttp){ 
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
		} 
	} 
	return xmlhttp; 
} 

var http2 = getHTTPObjectm();
function showReply(focusId, nodeId)
{
	var replySpanId = 'reply'+focusId;
	var contentEditorId = 'replyDiscussion'+focusId;
	parent.document.getElementById(replySpanId).style.display = '';		
	if(nodeId == 0)
	{
		
		parent.document.getElementById('butReply').style.display 		= 'none';
		parent.document.getElementById('butTopic').style.display 		= '';
		parent.document.getElementById('butCancel').style.display 		= 'none';
		parent.document.getElementById('butTopicCancel').style.display = '';
		parent.document.getElementById('chatTopic').innerHTML			= '';
		parent.document.getElementById('contentArea').innerHTML		= 'Topic';
		parent.document.getElementById('chatTopicMsg').style.display	= 'none';
	}
	else
	{	
		
		parent.document.getElementById('butReply').style.display 		= '';
		parent.document.getElementById('butTopic').style.display 		= 'none';
		parent.document.getElementById('butCancel').style.display 		= '';
		parent.document.getElementById('butTopicCancel').style.display = 'none';	
		parent.document.getElementById('contentArea').innerHTML		= '';	
	}
	parent.document.getElementById('replyDiscussion0').value = '';
	parent.document.getElementById(contentEditorId).focus();
	if(nodeId > 0)
	{
		parent.nodeId=nodeId;
		url='<?php echo base_url();?>view_chat/show_topic/<?php echo $treeId;?>/'+nodeId+'/type/<?php echo $workSpaceType;?>';	
		http2.open("GET", url,true); 
		http2.onreadystatechange = handleHttpResponseTopic; 
		http2.send(null);
	}
}
function handleHttpResponseTopic() 
{    
	if(http2.readyState == 4)
	{ 
		if(http2.status==200) 
		{ 
			var results=http2.responseText; 
			parent.document.getElementById('chatTopicMsg').style.display	= '';	
			parent.document.getElementById('chatTopic').innerHTML			= results;			
		}
	}
}

</script>