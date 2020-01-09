<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
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
    <!-- Main menu --> 
    
    <!-- Main Body --> 
    
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
function validate_dis(){
	var error=''
	if(!document.form1.title.value){
		
	  	error+='<?php echo $this->lang->line('enter_title_for_discussion'); ?>\n';
		
	}
	if (getvaluefromEditor('replyDiscussion','simple') == ''){
		error+='<?php echo $this->lang->line('enter_your_chat') ?>';
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
    <div class="menu_new" >
          <ul class="tab_menu_new">
        <li class="document-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1"  title="<?php echo $this->lang->line('txt_Document_View');?>" ></a></li>
        <li class="time-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=2" title="<?php echo $this->lang->line('txt_Time_View');?>" ><span></span></a></li>
        <li class="tag-view_sel"><a class="active" href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=3" title="<?php echo $this->lang->line('txt_Tag_View');?>" ><span></span></a></li>
        <li class="link-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=4" title="<?php echo $this->lang->line('txt_Link_View');?>" ><span></span></a></li>
        <li class="talk-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=7" title="<?php echo $this->lang->line('txt_Talk_View');?>"><span></span></a></li>
        <?php
			
		if (($workSpaceId==0))
		{?>
        <li class="share-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" ><span></span></a></li>
        <?php
		}
		?>
        <li id="treeUpdate"></li>
		<?php 
					/*Code for follow button*/
						$treeDetails['seedId']=$treeId;
						$treeDetails['treeName']='doc';	
						$this->load->view('follow_object',$treeDetails); 
					/*Code end*/
					?>
        <div class="clr"></div>
      </ul>
        </div>
    <?php 
			
			$tagId = ($_GET['tagId'])?$_GET['tagId']:0; 
			$treeId = ($_GET['treeId'])?$_GET['treeId']:0; 
			$tagType = ($_GET['tagType'])?$_GET['tagType']:0; 
			$usr = ($_GET['usr'])?$_GET['usr']:0; 
			$curVersion=($_GET['curVersion'])?$_GET['curVersion']:0; 
			
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
						$tag=($tagData["tagTypeId"]==3)?$tagData['tagId']:$tagData['tag'];
						$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tag, $tagData['artifactId'], $tagData['artifactType'] );
			
						if($_SESSION['tagLeaves'][$tagData['tagId']]){
							$high = "highlight";
							$rem  = 1;
						}
						else{
							$high = "";
							$rem  = 0;
						}
						
						if(count($tagLink) > 0)
						{		
							if($key == 'simple')
							{	
								if (!in_array($tagData['comments'],$simpleTagsStore))	
								{											
									$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" rem="0" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 
								}
								$simpleTagsStore[] = $tagData['comments'];
							}
							if($key == 'response')
							{	
								if (!in_array($tagData['comments'],$responseTagsStore))	
								{												
									$responseTags[] = '<a href="'.base_url().$tagLink[0].'","'.$tagData['comments'].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 
																							
								}
								$responseTagsStore[] = $tagData['comments'];
							}
							if($key == 'contact')
							{	
								if (!in_array($tagData['comments'],$contactTagsStore))
								{												
									$contactTags[] = '<a href="'.base_url().$tagLink[0].'","'.$tagData['comments'].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 
								}
								$contactTagsStore[] = $tagData['comments'];
							}
						}
					} 													
				}													
			}
			
			if(!empty($documentContributors))
			{
				foreach($documentContributors as $usr){
					$userTags[]="<a href='".base_url()."view_document/index/$workSpaceId/type/$workSpaceType/?treeId=$treeId&doc=exist&option=".$_GET['option']."&rem=".$_GET['rem']."&tagResponseId=".$tagResponseId."&usr=".$usr['authors']."'  remUsr='0' class='blue-link-underline userTag tagm'>".$usr['tagName']."</a>";
				}
			}
	
			if(count($leafTags) > 0)
			{												
				foreach($leafTags as $key => $arrTagData)
				{																	
					foreach($arrTagData as $key1 => $tagData)
					{	
						$tag=($tagData["tagTypeId"]==3)?$tagData['tagId']:$tagData['tag'];																												
						$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tag, $tagData['artifactId'], $tagData['artifactType'] );	
						
						if($_SESSION['tagLeaves'][$tagData['tagId']]){
							$high = "highlight";
							$rem  = 1;
						}
						else{
							$high = "";
							$rem  = 0;
						}
						
						if(count($tagLink) > 0)
						{		
							if($key == 'simple')
							{	
								if (!in_array($tagData['comments'],$simpleTagsStore))
								{																											
									$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														
								}	
								$simpleTagsStore[] = $tagData['comments'];
							}
							if($key == 'response')
							{	
								if (!in_array($tagData['comments'],$responseTagsStore))	
								{																														
									$responseTags[]  = '<a href="'.base_url().$tagLink[0].'","'.$tagData['comments'].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 
								}
								$responseTagsStore[] = $tagData['comments'];
							}
							if($key == 'contact')
							{	
								if (!in_array($tagData['comments'],$contactTagsStore))	
								{											
									$contactTags[]  = "<a href='".base_url().$tagLink[0]."' class='blue-link-underline tagm ".$high."' rem='".$rem."'>".$tagData['comments']."</a>"; 
								}
								$contactTagsStore[] = $tagData['comments'];
							}
						}
					} 															
				}		
												
			}
			
?>
    <table width="100%">
          <tr>
        <td colspan="4"><?php echo $this->lang->line('txt_Tags_Applied');?></td>
      </tr>
          <tr>
        <td colspan="4"><table>
            <?php
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
    <div>
          <input type="button" value="Go" id="go" class="buttonLogin" />
          <input type="button" value="Clear" id="clear" class="buttonLogin" />
        </div>
    <div id="leaves" style="width:100%">
          <?php $this->load->view("document/view_tag_leaves");?>
        </div>
  </div>
    </div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
