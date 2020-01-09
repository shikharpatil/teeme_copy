<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Teeme</title>
	<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
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
	<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
	<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
      <tr>
    <td valign="top"><table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="top" style="background-image:url(<?php echo base_url();?>images/logo-bg.gif); background-repeat:repeat-x"><!-- header -->
            
            <?php $this->load->view('common/header'); ?>
            
            <!-- header --></td>
        </tr>
        <tr>
          <td align="left" valign="top"><?php $this->load->view('common/wp_header'); ?></td>
        </tr>
        <tr>
          <td align="left" valign="top"><!-- Main menu -->
            
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
					 $this->load->view('common/artifact_tabs', $details); ?>
            
            <!-- Main menu --></td>
        </tr>
        <tr>
          <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" height="8" align="left" valign="top"></td>
                <td width="24%" align="left" valign="top"></td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="top"><!-- Main Body --> 
                  
                  <script type="text/javascript">
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
//alert(date1);
   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);
//alert(date2);
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
function validate_dis(){
	var error=''
	if(!document.form1.title.value){
		
	  	error+='<?php echo $this->lang->line('enter_title_for_discussion'); ?>\n';
		
	}
	if (getvaluefromEditor('replyDiscussion','simple') == ''){
		error+='<?php echo $this->lang->line('enter_your_chat'); ?>';
	}

	var thisdate = new Date();

	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();


 
	if(error==''){
		request_refresh_point=0;
		request_send();
	}else{
		jAlert(error);
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
			document.getElementById('chat_msg').innerHTML=results;
			document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;
			document.getElementById('replyDiscussion').value='';
			if(start_chat_val){
				document.getElementById('chat_title').innerHTML='<input name="title" type="hidden" value=" "><input name="starttime" type="hidden" id="starttime"  value=" "><input name="endtime" type="hidden" id="endtime" value=" ">';
				start_chat_val=0;
			}
			request_refresh_point=1;
		}
	}
}
function request_send(){
	if(replay_target){
		urlm='<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>';
		data='reply=1&vks=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&title='+document.getElementById('title').value+'&replyDiscussion='+document.getElementById('replyDiscussion').value+'&starttime='+document.getElementById('starttime').value+'&endtime='+document.getElementById('endtime').value;
	}else{
		urlm='<?php echo base_url();?>new_chat/index/<?php echo $treeId;?>';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+document.getElementById('replyDiscussion').value;

	}
	
		
	http1.open("POST", urlm, true); 
	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.onreadystatechange = handleHttpResponsem1;     
	http1.send(data);
}
var http2 = getHTTPObjectm();
function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText; 
			document.getElementById('chat_msg').innerHTML=results;
	
			document.getElementById('meFocus').focus();
		}
	}
}
function request_refresh()
{
	if(request_refresh_point)
	{
		url='<?php echo base_url();?>view_chat/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
		http2.open("GET", url,true); 
		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}
function showNotesNodeOptions(position)
{			
	var notesId = 'normalView'+position;		
	if(document.getElementById(notesId).style.display == "none")
	{			
		document.getElementById(notesId).style.display = "";
	}
	else
	{
		document.getElementById(notesId).style.display = "none";
	}
	var allNodes 	= document.getElementById('totalNodes').value;
	var arrNodes 	= new Array();
	arrNodes 		= allNodes.split(',');
	
	for(var i = 0;i<arrNodes.length;i++)
	{		
		if(position != arrNodes[i])
		{
			var notesId = 'normalView'+arrNodes[i];	
			document.getElementById(notesId).style.display = "none";
		}
	}
	
}
</script>
                  <table width="100%">
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="navigation">
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" class="current"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>
                          <?php
				if (($workSpaceId==0))
				{
				?>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"><span><?php echo $this->lang->line('txt_Share');?></span></a></li>
                          <?php
				}
				?>
                          <li id="treeUpdate"></li>
                        </ul></td>
                    </tr>
                    <tr>
                      <td colspan="4"><?php echo $this->lang->line('txt_Tags_Applied');?></td>
                    </tr>
                    <tr>
                      <td  colspan="4"><table>
                          <?php 
												
												$arrdispTags = array();
												$arrNodeIds 	= $this->tag_db_manager->getNodeIdsByTreeId($treeId);
												

													$treeTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1, $searchDate1, $searchDate2);
										
													$nodeIds		= implode(',', $arrNodeIds);
												
												if ($nodeIds)
												{	
													$leafTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($nodeIds, 2, $searchDate1, $searchDate2);	
												}
										
												$simpleTags 	= array();
												$responseTags 	= array();
												$contactTags 	= array();
												$userTags		= array();	
												$tagStatus		= 0;	

										
												if(count($treeTags) > 0)
												{												
													foreach($treeTags as $key => $arrTagData)
													{
														foreach($arrTagData as $key1 => $tagData)
														{	
											
															$tagLink	= $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
											
															if(count($tagLink) > 0)
															{		
																if($key == 'simple')

																{	
																	if (!in_array($tagData['comments'],$simpleTagsStore))	
																	{											
																		$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}
																	$simpleTagsStore[] = $tagData['comments'];
																}
																if($key == 'response')
																{	
																	if (!in_array($tagData['comments'],$responseTagsStore))	
																	{												
																		$responseTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}
																	$responseTagsStore[] = $tagData['comments'];
																}
																if($key == 'contact')
																{	
																	if (!in_array($tagData['comments'],$contactTagsStore))
																	{												
																		$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}
																	$contactTagsStore[] = $tagData['comments'];
																}
																if($key == 'user')
																{													
																	$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																}					
															}
														} 													
													}													
												}
										
												if(count($leafTags) > 0)
												{												
													foreach($leafTags as $key => $arrTagData)
													{																	
														foreach($arrTagData as $key1 => $tagData)
														{																														
															$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
															if(count($tagLink) > 0)
															{		
																if($key == 'simple')
																{	
																	if (!in_array($tagData['comments'],$simpleTagsStore))
																	{																											
																		$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}	
																	$simpleTagsStore[] = $tagData['comments'];
																}
																if($key == 'response')
																{
																	if (!in_array($tagData['comments'],$responseTagsStore))	
																	{																														
																		$responseTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}
																	$responseTagsStore[] = $tagData['comments'];
																}
																if($key == 'contact')
																{	
																	if (!in_array($tagData['comments'],$contactTagsStore))	
																	{											
																		$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																	}
																	$contactTagsStore[] = $tagData['comments'];
																}
																if($key == 'user')
																{													
																	$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
																}					
															}
														} 															
													}													
												}

									if(count($simpleTags) > 0)		
									{
										?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Simple_Tags').': '.implode(', ', $simpleTags);?></td>
                          </tr>
                          <?php	
										$tagStatus	= 1;			
									}
									if(count($responseTags) > 0)		
									{
										?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Response_Tags').': '.implode(', ', $responseTags);?></td>
                          </tr>
                          <?php	
										$tagStatus	= 1;				
									}
									if(count($contactTags) > 0)		
									{
										?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Contact_Tags').': '.implode(', ', $contactTags);?></td>
                          </tr>
                          <?php	
										$tagStatus	= 1;				
									}
									if(count($userTags) > 0)		
									{
										?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_User_Tags').': '.implode(', ', $userTags);?></td>
                          </tr>
                          <?php	
										$tagStatus	= 1;					
									}
									if($tagStatus == 0)		
									{
										?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_None');?></td>
                          </tr>
                          <?php																
									}		
									?>
                        </table></td>
                    </tr>
                  </table>
                  <?php 


$tagId = $this->uri->segment(8);
$nodeId = $this->uri->segment(9);
$tagType = $this->uri->segment(11);


if($tagId || $nodeId)
{
				if ($nodeId == $treeId)
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = '';
			
		if (!empty($nodeBgColor))
		{										
?>
                  <table width="100%" border="0" cellspacing="3" cellpadding="0">
                    <tr class="<?php echo $nodeBgColor;?>">
                      <td id="<?php echo $position++;?>" class="handCursor"><?php
						echo '<a href='.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],250,1).'</a>';
					?>
                        <br></td>
                    </tr>
                  </table>
                  <?php
		}
?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php
	$totalNodes = array();
	$nodeBgColor = '';

	if(count($discussionDetails) > 0)
	{			 
		foreach($discussionDetails as $keyVal=>$arrVal)
		{
			$attachedTags = $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);
			
			$count = 0;
			foreach($attachedTags as $key => $arrTagData)
			{																
				foreach($arrTagData as $key1 => $tagData)
				{						
					// 2= simple tags
					// 3 = response tags
					// 5= contact tags
					
					if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag
					{
						$tagComment = $this->tag_db_manager->getTagCommentByTagId($this->uri->segment(10));
						if ($tagData['comments']==$tagComment)
							$count++;			
					}
					else if ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag
					{
						$count++;
					}

				}
			}		
				if ($count != 0)
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = '';				
			
			$totalNodes[] = $arrVal['nodeId'];

		?>
                    <tr>
                      <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                          <?php
			if (!empty($nodeBgColor))
			{
			?>
                          <tr class="<?php echo $nodeBgColor;?>">
                            <td colspan="3" id="<?php echo $position++;?>" class="handCursor"><?php 
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);

					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);		

					?>
                              <?php
					echo '<a href='.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';

					?>
                              <br></td>
                          </tr>
                          <?php
			}
            ?>
                        </table>
                        <div style="padding-left:20px;">
                          <?php
			$_SESSION['succ'] = 0;
			$checkSuccessor =  $this->discussion_db_manager->getSuccessors($arrVal['nodeId']);

		if ($checkSuccessor != 0)
		{
			$sArray=array();
			$sArray=explode(',',$checkSuccessor);
			$counter=0;
			while($counter < count($sArray))
			{
				$arrDiscussions	= $this->discussion_db_manager->getPerentInfo($sArray[$counter]);	
				$predecessor = 	$this->discussion_db_manager->checkPredecessor($arrDiscussions['nodeId']);	
				$totalNodes[] = $arrDiscussions['nodeId'];	 
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc 		= $this->discussion_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
				
				
				$attachedTags2 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrDiscussions['nodeId'], 2);
				
					// 2= simple tags
					// 3 = response tags
					// 5= contact tags

				$count = 0;
				foreach($attachedTags2  as $key => $arrTagData)
				{																	
					foreach($arrTagData  as $key1 => $tagData)
					{	
						if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag
						{	
							$tagComment = $this->tag_db_manager->getTagCommentByTagId($this->uri->segment(10));
							if ($tagData['comments']==$tagComment)
								$count++;					
						}
						elseif ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag
							$count++;
					}
				}	
					if ($count != 0)
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = '';	
				?>
                          
                            <tr>
                              <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="3" cellpadding="3" align="left">
                                  <?php
			if (!empty($nodeBgColor))
			{
			?>
                                  <tr class="<?php echo $nodeBgColor; ?>">
                                    <td id="<?php echo $position++;?>" colspan="3" class="handCursor"><?php
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				
					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'], 2);		
					
					
					?>
                                      <?php
					echo '<a href='.base_url().'view_discussion/Discussion_reply/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$arrDiscussions["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussions['contents'],250).'</a>';
					
					?>
                                      <br></td>
                                  </tr>
                                  <?php
			}
			?>
                                </table></td>
                            </tr>
                            <?php
				$counter++;
			}			
		}		
		?>
                        </div></td>
                    </tr>
                    <?php
		}
	}
	 
?>
                  </table>
                  <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
                  </div>
                  <?php
}
?>
                  
                  <!-- Main Body --></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td align="center" valign="top" class="copy"><!-- Footer -->
            
            <?php $this->load->view('common/footer');?>
            
            <!-- Footer --></td>
        </tr>
      </table></td>
  </tr>
    </table>
</body>
</html>
