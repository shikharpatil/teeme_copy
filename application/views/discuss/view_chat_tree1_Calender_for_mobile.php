<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Teeme</title>
	<?php $this->load->view('common/view_head.php');?>
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
	<body>
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile" >
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
    <!-- Main menu --> 
    
    <!-- Main Body --> 
    
    <script type="text/javascript">
var chatReplyNodeId = '';
function compareDates (dat1, dat2) 
{
	var date1, date2;
	var month1, month2;
	var year1, year2;
	value1 = dat1.substring (0, dat1.indexOf (" "));
	value2 = dat2.substring (0, dat2.indexOf (" "));
	time1= dat1.substring (1, dat1.indexOf (" "));
	time2= dat2.substring (1, dat2.indexOf (" "));	
	hours1= time1.substring (0, time1.indexOf (":"));
	minites1= time1.substring (1, time1.indexOf (":"));	
	hours2= time2.substring (0, time2.indexOf (":"));
	minites2= time2.substring (1, time2.indexOf (":"));	  
	year1 = value1.substring (0, value1.indexOf ("-"));
	month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
	date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
   else return 0;
} 

var request_refresh_point=1;
var nodeId='';
function validate_dis(nodeId)
{
	chatReplyNodeId = nodeId;
	var error=''	
	var replyDiscussion = 'replyDiscussion'+nodeId;
	if (getvaluefromEditor(replyDiscussion,'simple') == ''){
		error+='Please Enter your chat';
	}


	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		request_refresh_point=0;
		request_send();
	}
	else
	{
		alert(error);
	}	
}
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
var http1 = getHTTPObjectm();
var replay_target=1;
var start_chat_val=1;
function handleHttpResponsem1() 
{    
	if(http1.readyState == 4) { 
		if(http1.status==200) { 
			var results=http1.responseText; 

			document.getElementById('replyDiscussion'+chatReplyNodeId).value='';

			request_refresh_point=1;
			window.parent.frames[0].location.reload();

		}
	}
}
function request_send()
{	

	if(replay_target)
	{		
		urlm='<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>/1';
		data='reply=1&vks=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+getvaluefromEditor('replyDiscussion0','simple');
	}
	else
	{		
		urlm='<?php echo base_url();?>new_chat/index/<?php echo $treeId;?>/1';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+getvaluefromEditor('replyDiscussion0','simple');
	}		
	http1.open("POST", urlm, true); 
	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.onreadystatechange = handleHttpResponsem1;     
	http1.send(data);

}
function getfocus()
{
	document.getElementById('focusDown').focus();
}
var http2 = getHTTPObjectm();
function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText;
			
			document.getElementById('chat_msg').innerHTML= results;
			
			getfocus();		
		}
	}
}

function request_refresh(){
		if(request_refresh_point){
		url='<?php echo base_url();?>view_chat/node_calendar_time_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}

function showReply(focusId, nodeId)
{
	var replySpanId = 'reply'+focusId;
	var contentEditorId = 'replyDiscussion'+focusId;
	document.getElementById(replySpanId).style.display = '';		
	if(nodeId == 0)
	{

		document.getElementById('butReply').style.display 		= 'none';
		document.getElementById('butTopic').style.display 		= '';
		document.getElementById('butCancel').style.display 		= 'none';
		document.getElementById('butTopicCancel').style.display = '';
		document.getElementById('chatTopic').innerHTML			= '';
		document.getElementById('contentArea').innerHTML		= '<?php echo $this->lang->line('txt_Add_Topic');?>:';
		document.getElementById('chatTopicMsg').style.display	= 'none';
	}
	else
	{

		document.getElementById('butReply').style.display 		= '';
		document.getElementById('butTopic').style.display 		= 'none';
		document.getElementById('butCancel').style.display 		= '';
		document.getElementById('butTopicCancel').style.display = 'none';	
		document.getElementById('contentArea').innerHTML		= '';	
	}
	document.getElementById('replyDiscussion0').value = '';

	if(nodeId > 0)
	{
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
			document.getElementById('chatTopicMsg').style.display	= '';	
			document.getElementById('chatTopic').innerHTML			= results;
		
		}
	}
}
function hideReply(nodeId)
{
	var replySpanId = 'reply'+nodeId;
	document.getElementById(replySpanId).style.display = 'none';			
}
function cancel ()
{

		setValueIntoEditor ('replyDiscussion0','','simple');
		
		replay_target=1;
		document.getElementById('butReply').style.display 		= 'none';
		document.getElementById('butTopic').style.display 		= '';
		document.getElementById('butCancel').style.display 		= 'none';
		document.getElementById('butTopicCancel').style.display = '';
		document.getElementById('chatTopic').innerHTML			= '';
		document.getElementById('contentArea').innerHTML		= '<?php echo $this->lang->line('txt_Add_Topic');?>:';
		document.getElementById('chatTopicMsg').style.display	= 'none';
}
</script><!--webbot bot="HTMLMarkup" endspan i-checksum="29191" -->
    
    <div class="menu_new_for_mobile" >
          <ul class="tab_menu_new_for_mobile">
        <li class="discuss-view"><a class="1tab" href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
        <li class="stop-time-view_sel"><a class="active" href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
        <li class="tag-view" ><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a  href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
      </ul>
          <div class="clr"></div>
        </div>
    <?php $position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);

			if ($treeId == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = 'seedBgColor';
?>
    <!---------  Seed div starts here ---->
    
    <div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >
          <div  style="height:30px; "> 
        
        <!--       my tyest           -->
        
        <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " >
              <div style="float:left; margin-right:10px;" class="selCont">
            <div class="newListSelected" tabindex="0" style="position: relative; ">
                  <div class="selectedTxt" onclick="showTreeOptions()" ></div>
                  <ul id="ulTreeOption" style="visibility: visible; width: 50px; top: 19px; left: 0pt;  display: none;" class="newList">
                <li><a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'start_real_talk',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Start'); ?></a></li>
              </ul>
                </div>
          </div>
            </div>
        <div class="clr"></div>
      </div>
          <div>
        <div   class="clsNoteTreeHeader handCursor"  >
              <div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
            <?php
								echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>');  
						?>
          </div>
              <?php
								if (!empty($arrDiscussionDetails['old_name']))
			 					{
										echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDiscussionDetails['old_name']),'<span><img>').')</div>';
			 					}
						?>
            </div>
        <div class="clsNoteTreeHeaderLeft" >
              <div id="divAutoNumbering" style="display:none; float:right " > </div>
              
              <!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->
              <div id="spanMoveTree" style="float:right; text-align:right" >
            <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
            <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
            <div class="lblMoveTree" > Move tree to:</div>
            <div class="floatLeft">
                  <?php   
							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
							{   
								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
							?>
                  <select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >
                <?php 
						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{				
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
							
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
									}
								}
						}
						}
						else
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{				
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))
							{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
							
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
										}
									}
								}
						}
						
						}
						?>
              </select>
                  <?php
					}
					?>
                </div>
            <div  class="floatLeft" id="divselectMoveToUser"  > </div>
            &nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
              
              <!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- --> 
              
            </div>
        <div style="height:65px;">
              <div id="normalView0" class="normalView" style="display:none"  >
            <div class="lblNotesDetails"   >
                  <div class="style2" style="100%" ><?php echo $userDetails['userTagName'];?>&nbsp;&nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['editedDate'], $this->config->item('date_format'));?> </div>
                </div>
          </div>
              <div class=" lblTagName"     > </div>
            </div>
      </div>
          <div class="divLinkFrame" >
        <div id="linkIframeId0"    style="display:none;"></div>
      </div>
          <span id="spanArtifactLinks0" style="display:none;"></span>
          <?php
		
				#********************************************* Tags ********************************************************88
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;	
				?>
          <div id="spanTagView0" style="display:none;">
        <div id="spanTagViewInner0">
              <div style="width:100%; float:left; ">
            <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}					
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				
				
				?>
          </div>
            </div>
        <div class="divTagsButton" style="width:auto" >
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(0)" />
              <span id="spanTagNew0">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(0,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" />
          </span> </div>
      </div>
          <?php	
				#*********************************************** Tags ********************************************************																		
				?>
          <div class="clr"></div>
        </div>
    
    <!---------  Seed div closes here ---->
    
    <div style="height:300; width:100%; overflow:auto">
          <div  id="chat_msg" style="width:100%" >&nbsp;</div>
        </div>
    <br>
    <span id="reply0">
        <form name="form10" method="post" action="<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
          <td valign="top" width="10%"><span id="chatTopicMsg" style="display:none;"> <?php echo $this->lang->line('txt_Reply_To');?>: </span></td>
          <td valign="top"><span id="chatTopic"></span></td>
        </tr>
          </table>
    </form>
        </span> 
    
    <!-- Main Body --> 
    <!-- Right Part--> 
    <!-- end Right Part --> 
    
    <script>

request_refresh();

setInterval("request_refresh()", 10000);
</script> 
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
