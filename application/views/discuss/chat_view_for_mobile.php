<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Discuss ><?php echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>') ?></title>
<!--/*End of Changed by Surbhi IV*/-->
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
<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->
<script type="text/javascript">
var chatReplyNodeId = '';
function compareDates (dat1, dat2) 
{
	var date1, date2;
	var month1, month2;
	var year1, year2;
	value1 	= dat1.substring (0, dat1.indexOf (" "));
	value2 	= dat2.substring (0, dat2.indexOf (" "));
	time1	= dat1.substring (1, dat1.indexOf (" "));
	time2	= dat2.substring (1, dat2.indexOf (" "));	
	hours1	= time1.substring (0, time1.indexOf (":"));
	minites1= time1.substring (1, time1.indexOf (":"));	
	hours2	= time2.substring (0, time2.indexOf (":"));
	minites2= time2.substring (1, time2.indexOf (":"));	  
	year1	= value1.substring (0, value1.indexOf ("-"));
	month1 	= value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
	date1 	= value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 	= value2.substring (0, value2.indexOf ("-"));
   month2 	= value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 	= value2.substring (value2.lastIndexOf ("-")+1, value2.length);

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
function validate_dis_old(nodeId,formname)
{
	chatReplyNodeId = nodeId;
	var error	= ''	
	var replyDiscussion = 'replyDiscussion'+nodeId;

	if (getvaluefromEditor(replyDiscussion,'simple') == ''){
		error+='<?php echo $this->lang->line('txt_enter');?>';
	}

	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		request_refresh_point=0;
		formname.submit();
	}
	else
	{
		jAlert(error);
	}	
}
function setValueIntoCKEditor(nm,val1)
{
	//Manoj: clear froala editor 
	$(".fr-element").html("");
	//setValueIntoEditor('replyDiscussion0','');
}
function validate_dis(nodeId,formname)
{ 
	treeId=$('#treeId').val();
		
		if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId=&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=3";
					$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							
							//alert(result);
							
							result = result.split("|||");
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else
							{
	chatReplyNodeId = nodeId;
	var error	= ''	
	var replyDiscussion = 'replyDiscussion'+nodeId; 
    var INSTANCE_NAME = $("#replyDiscussion").attr('name');
	
	var getvalue	= getvaluefromEditor('replyDiscussion0');
	$('#replyDiscussion0').val('');
	//Manoj: commented code 
	//chnage_textarea_to_editor('replyDiscussion0');
	
	if (getvalue == ''){
		error+='<?php echo $this->lang->line('txt_enter');?>';
	}
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{	
		$("#buttons").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		request_refresh_point=0;
		//ajax code starts here
       
		var data_user =$("#form101").serialize();
		data_user = data_user+'&replyDiscussion='+encodeURIComponent(getvalue) ; 
		
		var pnodeId=$("#pnodeId").val();
				var request = $.ajax({
			  url: baseUrl+"new_chat/start_ChatNew/"+pnodeId,
			  type: "POST",
			   data: data_user,
			  dataType: "html",
			  success:function(result){
			   if(result=='0'){
				  	jAlert('This duscission has been stopped. You cannot submit a new topic.');return;
				  }
			  
				/*Added by Surbhi IV*/
				chatReplyNodeId = nodeId;
				var error	= ''
				var editorname1 =$("#editorname1").val();	
				var nodeId =$("#nodeId").val();	
				var replyDiscussion = 'editorLeafContents'+nodeId+'1';
				
				/*End of Added by Surbhi IV*/
					   
			   $("#data_container").html(result);
			   //Manoj: code for reset textarea 
			   setValueIntoEditor('replyDiscussion0','');
			   $("#buttons").html("");
			   $(".fr-element").html("");
				}
			});
	
	}
	else
	{
		jAlert(error);
	}
	} //else end
	} //success end
	});		
}

function validate_dis1_old(nodeId,formname)
{
	
	chatReplyNodeId = nodeId;
	var error	= ''	
	var replyDiscussion = 'editorLeafContents'+nodeId+'1';

	if (getvaluefromEditor(replyDiscussion,'simple') == ''){
		error+='<?php echo $this->lang->line('txt_enter_chat');?>';
	}
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		document.getElementById('editStatus').value == 0;
		request_refresh_point=0;
	
		formname.submit();
	}
	else
	{
		jAlert(error);
	}	
}

function validate_dis1()
{
	
	chatReplyNodeId = nodeId;
	var error	= ''
	var editorname1 =$("#editorname1").val();	
	var nodeId =$("#nodeId").val();	
	var replyDiscussion = 'editorLeafContents'+nodeId+'1';
 
 	var getvalue	= getvaluefromEditor(replyDiscussion);
	
	if (getvalue == ''){
		error+='<?php echo $this->lang->line('txt_enter');?>';
	}
	
	document.getElementById('editorLeafContents'+nodeId+'1sp').innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		document.getElementById('editStatus').value == 0;
		request_refresh_point=0;
		//ajax code starts here
       treeId=$('#treeId').val();
		var data_user =$("#form2").serialize();
		data_user = data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue); 
		
		var pnodeId=$("#pnodeId").val();
				var request = $.ajax({
			  url: baseUrl+"new_chat/indexAjax/"+treeId+"/1",
			  type: "POST",
			   data: data_user,
			  dataType: "html",
			  success:function(result){
			  
			  $("#data_container").html(result);
			  
			  //Show topic editor if comment editor close
				$(".discussTopicEditor").show();
			  
			 	}
			});
	}
	else
	{
		jAlert(error);
	}	
}


function getHTTPObjectm() { 
	var xmlhttp; 

	if(window.XMLHttpRequest)
	{ 
		xmlhttp = new XMLHttpRequest(); 
	}
	else if(window.ActiveXObject)
	{ 
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		if(!xmlhttp)
		{ 
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
			document.getElementById('replyDiscussion'+chatReplyNodeId).value='';
			location.reload(true);
			request_refresh_point=1;
		}
	}
}
function request_send()
{
	if(replay_target)
	{	
		urlm='<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>';
		data='reply=1&vks=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+getvaluefromEditor('replyDiscussion'+nodeId,'simple');
	}
	else
	{
		
		urlm='<?php echo base_url();?>new_chat/index/<?php echo $treeId;?>';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+getvaluefromEditor('replyDiscussion'+nodeId,'simple');
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
		}
	}
}
function focusScroll()
{		
	document.getElementById('focusViewArea').focus();
}
function getfocus()
{
document.getElementById('focusDown').focus();
document.getElementById('replyDiscussion0').focus();
}
function request_refresh(){
		if(request_refresh_point){
		url='<?php echo base_url();?>view_chat/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';

		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}

function showReply(nodeId)
{
	var replySpanId = 'reply'+nodeId;
	var contentEditorId = 'replyDiscussion'+nodeId;
	document.getElementById(replySpanId).style.display = '';		
	document.getElementById(contentEditorId).focus();
	
	chnage_textarea_to_editor('replyDiscussion'+nodeId,'simple');
	
}

function edit_close_1(nodeId){
document.form2.editStatus.value = 0;	
var divId='reply'+nodeId;
var INSTANCE_NAME = $("#editorLeafContents"+nodeId+"1").attr('name'); 

editorClose(INSTANCE_NAME);
document.getElementById(divId).style.display='none';
//Show topic editor if comment editor close
	 $(".discussTopicEditor").show();
}

function showReply1(nodeId)
{
	if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		treeId = '';
		var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=3";
					$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							
							//alert(result);
							
							result = result.split("|||");
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else
							{
	if(document.getElementById('editStatus').value == 1)
		{
			 <!--Changed by Surbhi IV -->
			jAlert('<?php echo $this->lang->line('save_cancel_current_comment');?>');
			 <!--End of Changed by Surbhi IV -->
		}
		else
		{ 
		
			document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		  
			var divid='reply'+nodeId;
			document.getElementById(divid).style.display='';
			document.form2.nodeId.value = nodeId;	
			document.getElementById('editStatus').value = 1;
			document.form2.editorname1.value = 'editorLeafContents'+nodeId+'1';	
            editor_code('','editorLeafContents'+nodeId+'1','txt_reply'+nodeId);
			
			const recordVal = "'chat'";
			 
			//document.getElementById('editorLeafContents'+nodeId+'1sp').innerHTML='<table width="40%"  border="0" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="validate_dis1('+nodeId+',document.form2)"><input type="button" class="button01" value="Done"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="edit_close_1('+nodeId+')"><input type="button" class="button01" value="Cancel"></a></td></tr></table><div id="audioRecordBox"><div style="float:left;margin-top:0.7%"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+nodeId+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+nodeId+'" style="display:none; margin-left:2%; margin-top:0%; float:left;"><input onClick="startRecording(this,'+recordVal+');" type="button"  class="button01" value="Record"/><input onClick="stopRecording(this);" type="button"  class="button01" value="Stop" disabled  /></div></div>';
			
			document.getElementById('editorLeafContents'+nodeId+'1sp').innerHTML='<div><a href="javascript:void(0)" onclick="validate_dis1('+nodeId+',document.form2)"><input style="float:left;" type="button" class="button01" value="Done"></a><a href="javascript:void(0)" onclick="edit_close_1('+nodeId+')"><input style="float:left;" type="button" class="button01" value="Cancel"></a><span id="audioRecordBox"><div style="float:left;margin-top:5px"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+nodeId+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+nodeId+'" style="display:none; margin-left:2%; margin-top:0%; float:left;"></div></span></div>';
			
		chnage_textarea_to_editor('editorLeafContents'+nodeId+'1','');
		
		document.getElementById('loader'+nodeId).innerHTML =" ";
		
		/*<div style="float:left;margin-top:0.7%"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'+nodeId+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+nodeId+'" style="display:none; margin-left:2%; margin-top:0.4%; float:left;"><input onClick="startRecording(this);" type="button"  class="button01" value="Record"   /><input onClick="stopRecording(this);" type="button"  class="button01" value="Stop" disabled  /></div>*/
		
		//Hide topic editor if comment editor open
	 	$(".discussTopicEditor").hide();
	}
	 } //else end
	 } //success end
	 });				
}

function hideReply(nodeId)
{
	var replySpanId = 'reply'+nodeId;
	document.getElementById(replySpanId).style.display = 'none';			
}
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
<div id="container_for_mobile">
  <div id="content"> 
    
    <!-- Main menu -->
    <?php
		$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
		$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
		$details['workSpaces']		= $workSpaces;
		$details['workSpaceId'] 	= $workSpaceId;
		if($workSpaceId > 0)
		{				
			$details['workSpaceName'] = $workSpaceDetails['workSpaceName'];
		}
		else
		{
			$details['workSpaceName'] = $this->lang->line('txt_Me');	
		}
		
	?>
    <!-- Main menu -->
    
    <?php $this->load->view('discuss/discuss_menu_for_mobile');  ?>
    <?php
		if ($treeId == $this->uri->segment(8)  || $treeId == $this->input->get('node'))
			$nodeBgColor = 'nodeBgColorSelect';
		else
			$nodeBgColor = 'seedBgColor';
	?>
    
    <!---------  Seed div starts here ---->
    
    <div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >
      <?php									
		$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);					

		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);

		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);	
		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	
		$total=0;	
?>
      <div  style="height:30px; "> 
        
        <!--       my tyest           -->
        
        <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " >
          <div style="float:left; margin-right:10px;" class="selCont">
            <div class="newListSelected" tabindex="0" style="position: relative;outline:none;">
              <div class="selectedTxt" onclick="showTreeOptions()" ></div>
              <ul id="ulTreeOption" style="visibility: visible; width: 140px; top: 19px; left: 0pt;  display: none;" class="newList">
                <?php 	
						if ( $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId1, $placeType))
            			{
					?>
                <li><a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsChat(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>
                <?php
						}
					?>
					<li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Discuss');?></a></li>
						<?php
					if($arrDiscussionDetails["userId"]==$_SESSION["userId"]){
					?>
                <li><a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'stop',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Stop'); ?></a></li>
				 <?php
					}
                ?>
				<?php 
	
					$treeName['treeName']='chat';	
					$this->load->view('common/printPage_for_mobile',$treeName);	
				
				?>
              
			  </ul>
            </div>
          </div>
          <ul  class="content-list" style="float:left" >
            <?php
						
			$tag_container='';
			$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
			if($total==0)
			{
			  $total='';
			  $tag_container=$this->lang->line('txt_None');
			}
			else
			{
				 if(count($viewTags)>0)
				 {
					$tag_container='Simple Tag : ';
					foreach($viewTags as $simpleTag)
					$tag_container.=$simpleTag['tagName'].", ";
					$tag_container=substr($tag_container, 0, -2)." 
					"; 	
				 }
							
												
				if(count($actTags) > 0)
				{
				   $tag_container.='Action Tag : ';
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{	$dispResponseTags='';
						$dispResponseTags = $tagData['comments']."[";							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{  
							
							if ($tagData['tag']==1)
								$dispResponseTags .= $this->lang->line('txt_ToDo');									
							if ($tagData['tag']==2)
								$dispResponseTags .= $this->lang->line('txt_Select');	
							if ($tagData['tag']==3)
								$dispResponseTags .= $this->lang->line('txt_Vote');
							if ($tagData['tag']==4)
								$dispResponseTags .= $this->lang->line('txt_Authorize');															
						}
						$dispResponseTags .= "], ";	
											
						
						
						$tag_container.=$dispResponseTags;
					}
					
					$tag_container=substr($tag_container, 0, -2)."
	"; 
				}
								
								
				if(count($contactTags) > 0)
				{
					$tag_container.='Contact Tag : ';
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						
						$tag_container .= strip_tags($tagData['contactName'],'').", ";	
						
					}
					
					$tag_container=substr($tag_container, 0, -2); 
				}		
						
			}
						
				?>
            <li><a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/1', 710, 420, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong></a></li>
            <?php	
						//count totoal number of links
            			$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
						
						if($total==0)
						{
						  $total='';
						  $appliedLinks=$this->lang->line('txt_None');
						}
						else
						{
						
							
						   $appliedLinks='';
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							
							 if(count($docTrees3)>0)
						   {
								$appliedLinks.=$this->lang->line('txt_Chat').': ';	
								foreach($docTrees3 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees4)>0)
							{
							
								$appliedLinks.=$this->lang->line('txt_Task').': ';	
								foreach($docTrees4 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees6)>0)
							{
								$appliedLinks.=$this->lang->line('txt_Notes').': ';	
								foreach($docTrees6 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}
							
							if(count($docTrees5)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
								foreach($docTrees5 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
							
							if(count($docTrees7)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
							         
									if($linkData['docName']=='')
									 {
									    $appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
									 }
									 else
									 {
									 	$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 }
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
						   
						   
						   if(count($docTrees9	)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
								foreach($docTrees9 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['title'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
						   
						}
					
				?>
            <li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 680, 375, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
          </ul>
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
        <div class="clsNoteTreeHeaderLeft" style="width:70%;">
          <div id="divAutoNumbering" style="display:none; float:right " > 
		  
		   <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1">

		

						  

								

								<?php /**************** MOVE TREE CODE START *******************/ ?>

						

						<?php 

							

									if($workSpaceType==2 )

									{

										$placeType=$workSpaceType+1;

										$workSpaceId1=$this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);

										

									

									}

									else

									{

										$placeType=$workSpaceType+2;

									   $workSpaceId1=$workSpaceId;

									}

							

							

							?>

						

						<?php /**************** MOVE TREE CODE CLOSE *******************/ ?>

							<div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Discuss');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

							<input type="hidden" name="autonumbering_submit" value="1" />

							</div>

							<div style="float:left">	

								<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideDivAutoNumbering()" style="margin-top:-2px;"  border="0"  /> 

							</div>	

								</form>		  
		  
		  </div>
          
          <!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->
          <div id="spanMoveTree" style="float:right; text-align:left" >
            <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
            <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
            <div class="lblMoveTree" ><?php echo $this->lang->line('move_tree_to_txt'); ?></div>
            <div class="floatLeft" style="margin-top: 4%">
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
							if($workSpaceData['workSpaceName']!='Try Teeme')
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
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
										}
									}
								}
						}//try teeme restriction end
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
							if($workSpaceData['workSpaceName']!='Try Teeme')
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
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
								if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
								{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
								}
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
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
										}
										}
									}
								}
						}//try teeme restriction end
						}
						
						}
						?>
              </select>
              <?php
					}
					?>
            </div>
            <div  class="floatLeft" id="divselectMoveToUser"  style="margin: 3% 0%;"> </div>
            &nbsp;&nbsp;&nbsp;&nbsp;<img title="Close"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
          
          <!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- --> 
          
        </div>
        <div class="clr"></div>
        <div style="height:20px;">
          <div id="normalView0" class="normalView" style="display:none"  >
            <div class="lblNotesDetails"   >
              <div class="style2" style="width:80%; margin-left:2%; text-align:left;">
             <div>
			  <?php 
			    echo $userDetails['userTagName'];
				if(strlen($userDetails['userTagName'])>17)
				{
			  ?>
				 
			   </div>
			   <div style="margin-top: 5px;">
				  
			  <?php 
				} 
			  	
					//Start Manoj: Remove date suffix and current year
					 
					 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['createdDate'], $this->config->item('date_format'));
					 $Create_date = explode(' ',$Create_date);
					 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
					 $current_year = date("y");
					 if($current_year == $Create_date[2])
					 {
						$Create_date[2]=" ";
					 }
					 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
					 
					 //End Manoj: Remove date suffix
					 
				//echo ' '.$this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['createdDate'], $this->config->item('date_format'));
			  ?> 
			 
			 </div>
              </div>
              <!--editLeafMobile class added to hide edit option for devices that do not support editor -->
              <div style="float:right; margin-left:5px; width:12%;" class="editLeafMobile">
                <?php 
						
             				//if ($treeDetail['userId'] == $_SESSION['userId'])
                			{
						
             			?>
                
                <!--/*Added by Surbhi IV for checking version */--> 
                <a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','')"  style="margin-right:25px; float:left" ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0"></a> 
                <!--/*End of Added by Surbhi IV for checking version */-->
                <?php 	
							}
							?>
              </div>
            </div>
          </div>
          <div class=" lblTagName"     > </div>
        </div>
      </div>
      <div id="edit_doc" class="<?php echo $seedBgColor;?>" style="width:<?php echo (($this->config->item('page_width')/10)+10);?>%; padding-left:10px; float:left; display:none;">
        <form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/chat" onSubmit="return validateDocumentName();">
          <div id="divEditDoc" ></div>
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="docTitleSaveNew(0,0);" />
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="docTitleCancel();" />
          <input type="hidden" name="treeId" value="<?php echo $treeId; ?>">
        </form>
      </div>
      <div id="0notes"   style="width:100%; height:240px; float:left; display:none;" >
        <?php 
				$firstSuccessor = 0;
				if(count($Contactdetail) > 0)
				{
					$firstSuccessor = $Contactdetail[0]['nodeId'];			
				}
				?>
        <form name="form10" id="form10" method="post" action="<?php echo base_url();?>notes/addMyNotes/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
          <div id="containerseed" name="containerseed" ></div>
          <span id='saveOption'></span>
          <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion0',document.form10);" class="button01">
          
          <input type="button" name="Replybutton1" value="Cancel" onClick="reply_close12(0);" class="button01">
          <input name="editorname1" id="editorname1" type="hidden"  value="replyDiscussion0">
          <input name="seedpredecessor" id="seedpredecessor" type="hidden"  value="0">
          <input name="seedsuccessors" id="seedsuccessors" type="hidden"  value="<?php echo $firstSuccessor;?>">
          <input name="reply" id="reply" type="hidden"  value="1">
          <input type="hidden" name="treeId" id="treeId" value="<?php echo $treeId ?>" />
        </form>
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
          <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; ">
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
        <!--<div class="tagIframe">
						<div id="iframeId0"    style="display:none;">
						  
						</div>
					</div>--> 
      </div>
      <?php	
				#*********************************************** Tags ********************************************************																		
				?>
      <div class="clr"></div>
    </div>
    
    <!---------  Seed div closes here ---->
    
    <div id="data_container"> <!-- Leaf Div -->
      <?php
				$arrDiscussions1		= $this->chat_db_manager->getNodesByTree($treeId);
			
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
				
			    $pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}				
				$this->load->view('discuss/view_chat_tree_for_mobile', $arrDiscussionViewPage); 
				?>
    </div>
    <div class="blockAddNewComment">
      <div  id="reply0" style="width:95%; padding-left:10px; float:left;  margin-top:20px;" class="discussTopicEditor">
        <div class="talkform<?php echo $treeId; ?>">
		<form name="form101" id="form101" method="post" action="<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>">
          <a name="focusContentArea"></a> <b><br>
          <img src="<?php echo  base_url(); ?>images/addnew.png" style="padding-top:5px;"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ><span style="margin-left:5px" ><span><?php echo $this->lang->line('txt_Topic');?>:</span></b><br>
          <br>
          <textarea name="replyDiscussion0" id="replyDiscussion0" rows="5" cols="40"></textarea>
		  <div id="buttons"></div>
          <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis(0,this.form);" class="button01">
         
          <input style="float:left;" type="button" name="Replybutton1"  value="Cancel" onClick="setValueIntoCKEditor('replyDiscussion0','');"  class="button01">
          <input name="reply" type="hidden" id="reply" value="1">
          <input name="editorname1" type="hidden"  value="replyDiscussion">
          <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
          <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
          <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
		  
		  <div id="audioRecordBox"> <div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record" style="display:none; margin-left:2%; margin-top:0.4%; float:left;"></div></div>
		  
        </form>
		</div>
		
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
<script>
//Manoj: add version simple
chnage_textarea_to_editor('replyDiscussion0','');
</script>
<script>
		 // Keep Checking for tree updates every 5 second
		<!--Updated by Surbhi IV-->
		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);
		<!--End of Updated by Surbhi IV-->	
</script>