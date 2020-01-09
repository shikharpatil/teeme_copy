<?php 

//arun - variable used for fetch data for real time talk from data base
$_SESSION['talkTimeStamp']=''; 

//arun-varialbe used for real time chat view
$_SESSION['i']=1;

$_SESSION['commentIdContainer']= array(); 


?>
<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="viewport" content="width=device-width, user-scalable=no" />
<title></title>
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
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

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
	
function request_refresh_once(){ 
	var request_refresh_point=1;
		if(request_refresh_point){
		
		var leafTreeId=document.getElementById('leafTreeId').value;
		
		$(".talkLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	
		url='<?php echo base_url();?>view_talk_tree/real_talk/'+leafTreeId+'/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/ptid/<?php echo $treeId; ?>/<?php echo $isSeedTalk; ?>';
		
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem_once; 
		http2.send(null); 
	}
}

function handleHttpResponsem_once() 
{   
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText;		
		
						var isContents = results.indexOf("TalktxtComments");
						if(isContents > -1)
						{
							//alert(isContents);
							document.getElementById('talk_msg').innerHTML= results;
							$(".talkLoader").html("");
							document.getElementById("talk_msg").scrollTop =document.getElementById("talk_msg").scrollHeight;
							$('.focusText').focus();
						}
						else
						{
							$("#talk_msg").html(results);
							//$('.talkEmpty').html('<?php echo $this->lang->line('txt_no_comments_msg') ?>'); 
							$(".talkLoader").html("");
						}
		
			/*document.getElementById('talk_msg').innerHTML= results;
			$(".talkLoader").html("");
			document.getElementById("talk_msg").scrollTop =document.getElementById("talk_msg").scrollHeight;
			$('.focusText').focus();*/
		
		}
		else
		{
			$(".talkLoader").html("");
		}
	}
	else
	{
		$(".talkLoader").html("");
	}
}

function request_refresh(){
		var request_refresh_point=1;
		if(request_refresh_point){
		var leafTreeId=document.getElementById('leafTreeId').value;
	
		url='<?php echo base_url();?>view_talk_tree/real_talk/'+leafTreeId+'/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/ptid/<?php echo $treeId; ?>/<?php echo $isSeedTalk; ?>';
	
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null);

	}
}

function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText;
	
			//alert(results);
			//$("#talk_msg").append(results);
			document.getElementById('talk_msg').innerHTML += results;
			
			document.getElementById("talk_msg").scrollTop =document.getElementById("talk_msg").scrollHeight;
		
			chnage_textarea_to_editor('replyDiscussion0','');
			
			//Add SetTimeOut 
			setTimeout("request_refresh()", 5000);
		}
	}
}


</script>
<style type="text/css">
<!--
.style1 {
	font-size: 10px
}
.style2 {
	font-size: 11px
}
.style4 {
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
<script>
	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;

	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	}
 	
	var mystart='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	var myend='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	function changes_date(newsdate,newedate){
		mystart=newsdate;
		myend=newedate;
	}
	function compareDates (dat1, dat2) {
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

	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;
	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	 //Add SetTimeOut 
	 setTimeout("blinkIt()", 500);
	}

	//setInterval('blinkIt()',500);
	//Add SetTimeOut 
	setTimeout("blinkIt()", 500);

	function validate_dis_old(replyDiscussion,formname){
	var error='';

	if(getvaluefromEditor(replyDiscussion) == ''){
		error+='<?php echo $this->lang->line('msg_enter_comment');?>';
	}


	if(error==''){
		formname.submit();
	}else{
		jAlert(error);
	}
	
}
var pnodeId1;
function validate_dis_talk(pnodeId,treeId) 
{   
	//alert('sdf');
	pnodeId1=pnodeId;

	//var INSTANCE_NAME = 'replyDiscussion';
	var INSTANCE_NAME = 'replyDiscussion'+pnodeId;
	
	
	//var getvalue = (disableEditor==0)?CKEDITOR.instances[INSTANCE_NAME].getData():$('#replyDiscussion').val();
	var getvalue = $('#'+INSTANCE_NAME).froalaEditor('html.get');
	
	//alert ('getvalue= ' + getvalue);

	var error=''	
	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1){
		error+='<?php //echo $this->lang->line('enter_your_comment'); ?>';
	}*/
	if (getvalue == ''){
		error+='<?php echo $this->lang->line('enter_your_comment'); ?>';
	}


	
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		$("#loaderTalk"+pnodeId).html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		request_refresh_point=0;
		request_send(pnodeId,treeId);
		setValueIntoEditor(INSTANCE_NAME,"");
	}
	else
	{
		jAlert(error);
	} 	
}



var http1 = getHTTPObjectm();
var replay_target=1;
var start_chat_val=1;


function request_send(pnodeId,treeId)
{	
	replay_target=1;
	if(replay_target)
	{
		//var replyDiscussion='replyDiscussion';
		var replyDiscussion='replyDiscussion'+pnodeId;

		var jsData = getvaluefromEditor(replyDiscussion);
		
		var ptid=document.getElementById('ptid').value;
		var seedTalk=document.getElementById('seedTalk').value;
	
	
		urlm='<?php echo base_url();?>new_talk_tree/start_Discussion/'+pnodeId1;
	
		var getvalue = jsData;
		
		if (!(getvalue.match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/))) {
      			getvalue='<p>'+getvalue+'<br></p>';
   		}
	
		data='reply=1&vks=1&editorname1='+replyDiscussion+'&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&ptid='+ptid+'&seedTalk='+seedTalk+'&pnodeId='+pnodeId1+'&replyDiscussion='+encodeURIComponent(getvalue);
	}
	
	
	http1.open("POST", urlm, true); 
	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.onreadystatechange = handleHttpResponsem1;     
	http1.send(data);

}

function handleHttpResponsem1() 
{    
	if(http1.readyState == 4) { 
		if(http1.status==200) { 
			var results=http1.responseText;

			leafTreeId=document.getElementById('leafTreeId').value;
			//setTalkCount(leafTreeId);
					
			setLastTalk(leafTreeId);
			
			document.getElementById('talk_msg').innerHTML +=results;
			
			var httpDoc = getHTTPObjectm();
	
			urlm=baseUrl+'view_talk_tree/setTalkCount/'+leafTreeId;
			
			httpDoc.open("POST", urlm, true); 
			httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			httpDoc.onreadystatechange = function()
			{ 
			   if (httpDoc.readyState==4 && httpDoc.status==200)
			   {
					var result = '';
					result = httpDoc.responseText;	   
					if(result==0)
					{
						result='';
					}
			   		//document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
					window.opener.$("#liTalk"+leafTreeId).html(result);
					//window.opener.document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
			   }
			}     
			httpDoc.send();
			
			
			$(".fr-element").html("");
			$("#loaderTalk"+pnodeId1).html("");
			$('.focusText').focus();
			//alert(pnodeId1);
			//document.getElementById('replyDiscussion'+pnodeId1).value='';
			//document.getElementById('replyDiscussion'+nodeId1).value='';
			
			
	
			request_refresh_point=1;
	
		}
	}
}




/*	function request_refresh(){
		request_refresh_point=1;
			if(request_refresh_point){
			url='<?php echo base_url();?>view_talk_tree/real_talk/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
			http2.open("GET", url,true); 
			http2.onreadystatechange = handleHttpResponsem2; 
			http2.send(null);
			}	
	}

function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText;
			document.getElementById('talk_msg').innerHTML += results;
			
			document.getElementById("talk_msg").scrollTop =document.getElementById("talk_msg").scrollHeight;
			chnage_textarea_to_editor('replyDiscussion'+nodeId1,'');
		}
	}
}*/

function setTalkCount(leafTreeId)
{
		
	var httpDoc = getHTTPObjectm();
	
	urlm=baseUrl+'view_talk_tree/setTalkCount/'+leafTreeId;
	
	httpDoc.open("POST", urlm, true); 
	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpDoc.onreadystatechange = function()
	{ 
	   if (httpDoc.readyState==4 && httpDoc.status==200)
	   {
			window.opener.document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
	   }
	}     
	httpDoc.send();

	
}
/*<!--Added by Surbhi IV -->	*/
function setLastTalk(leafTreeId)
{
	//alert ('Hello, Hello');
	var httpDoc = getHTTPObjectm();
	urlm=baseUrl+'view_talk_tree/setLastTalk/'+leafTreeId;
	httpDoc.open("POST", urlm, true); 
	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpDoc.onreadystatechange = function()
	{ 
	   if (httpDoc.readyState==4 && httpDoc.status==200)
	   {
		  window.opener.document.getElementById("liTalk"+leafTreeId).setAttribute('title',httpDoc.responseText);
	   }
	}     
	httpDoc.send();
}
/*<!--End of Added by Surbhi IV -->	*/
function countTalk()
{
	alert("hi");
}

</script>
<?php /*?><script language="JavaScript1.2">mmLoadMenus();</script><?php */?>
</head>
<body style="background-color:#FFFFFF;">
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile">
      <div id="content"> 
<!--/*End of Changed by Surbhi IV*/-->
<div class="fixedDiv">
  <div class="menu_new h2_class" style="background-color:#FFF;">
    <ul class="tab_tag_link">
      <li class="tabs_tags_select"><a href="javascript:void(0);"><span><?php echo $this->lang->line('txt_Talk');?></span></a></li>
    </ul>
    <?php /*?><a href="javascript:void(o)" style="float:right;padding:4px;" onclick="window.reload()" ><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" border="none" ></a><?php */?> </div>
  <span id="add<?php echo $position;?>" style="display:none;"></span>
  <div class="clr"></div>
  <div class="seedBgColor talkTitleDiv" onClick="showdetail(<?php echo $position;?>);" >
    <div style="float:left;">
      <?php
		echo stripslashes($DiscussionPerent['name']); 
	?>
    </div>
    <div class="commenterTalk">
      <?php 
									
	$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
	
	$arrStartTime = explode('-',$arrDiscussionDetails['starttime']);
	//.$this->lang->line('txt_Date').' : '
	echo '<span>'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['createdDate'],$this->config->item('date_format')).'</span>';
	?>
    </div>
    <div class="clr"></div>
  </div>
</div>
<div class="talkTreeComments">
  <?php
	$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
	$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
	
	if($this->uri->segment(8))
	
	$latestVersion 			= $this->discussion_db_manager->getTreeLatestVersionByTreeId($this->uri->segment(8));
	
	$leafClearStatus	= $this->identity_db_manager->getLeafClearStatus($treeId,'clear_talk');
	
	if($talkClearNodeId !='')
	{
		$leafOwnerData	= $this->identity_db_manager->getLeafIdByNodeId($talkClearNodeId);
	}
		
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
  <span id="tagSpan"></span>
  <?php	
	$focusId = 2;
	$totalNodes = array();
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	$i = 1;	
	?>
  <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
  <div style="width:100%; overflow:auto">
  	<div class="talkEmpty"></div>
    <div id="talk_msg"><div class="talkLoader"></div></div>
  </div>
  <form name="form0" method="post" action="<?php echo base_url();?>new_talk_tree/start_Discussion/<?php echo $pnodeId;?>">
    <?php
	if ($latestVersion == 1 && ($nodeSuccessor === 0 || $successorLeafStatus == 'draft' || $treeType!=1 || $artifactType==1) && $currentLeafStatus!='discarded' && $leafDraftReserveStatus!=1 && $spaceMoved!=1)
	{?>
    <div id="reply_teeme" <?php if(isset($latest)&& $latest==0) echo 'class="disnone"';  ?>  style=" width:100%; margin-top:0px;"> <br>
      <b><?php echo "<div><div style='float:left' ><img  'style=\'float:left\'' src='".base_url()."images/addnew.png'    border='0'><span style='margin-left:5px; font-weight:bold;'>".$this->lang->line('txt_Comment')." : </span></div></div>"; ?></b><br>
      <div class="clr"></div>
      &nbsp;&nbsp;&nbsp;
      <textarea name="replyDiscussion" id="replyDiscussion<?php echo $this->uri->segment(3);?>"></textarea>
      <br />
	  <div style="padding-left:2%;">
	  <?php /* onClick="javascript:window.close()" */ ?>
	  <div id="loaderTalk<?php echo $this->uri->segment(3);?>"></div>
	  <div class="clearLoader" id="clearLoader" style="padding-bottom:5px;"></div>
	  	<div>
        <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="validate_dis_talk('<?php echo $this->uri->segment(3);?>','<?php echo $treeId;?>');" style="float:left;" >
		<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;" >
		</div>
		<!--Clear leaf talk object(s) start-->
		<div style="margin-top:10%;">
		<?php
	 	//echo $latestLeafVersion.'==';
			if($leafClearStatus == 1 && $leafClearStatus != '' && $latestLeafVersion == 1)
			{
				?>
				<div><?php echo $this->lang->line('txt_clear_prev_talk_obj_msg'); ?></div>
			<?php
			}		
			
		if($leafClearStatus == 0 && $leafClearStatus != '' && $leafOwnerData['userId']==$_SESSION['userId'])
		{
		?>
		<div class="clearTalkBTN<?php echo $this->uri->segment(3);?>">
		<input type="button" name="clear" value="<?php echo $this->lang->line('txt_clear_prev_talk_obj'); ?>" onclick="clearTalks('<?php echo $treeId ?>',<?php echo $talkNodeId; ?>);"  style=""/>
		</div>
		<?php
		}
		?>
		</div>
		<!--Clear leaf talk object(s) end-->
		<input type="button" style="opacity:0;" class="focusText" value="focus"/>
		<span id="audioRecordBox"><span style="float:left;margin-top:1.8%"><span id="drop" style="margin-left:15px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $this->uri->segment(3);?>');"><span class="fa fa-microphon"></span></a></span></span><span id="3audio_record<?php echo $this->uri->segment(3);?>" style="display:none; margin-left:2%; margin-top:0%; float:left;"></span></span>
        &nbsp;&nbsp;&nbsp;&nbsp;
       <?php /*?> <input type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Clear');?>" onClick="setValueIntoEditor('replyDiscussion','');"><?php */?>
      </div>
      <script language="javascript">chnage_textarea_to_editor('replyDiscussion0');</script> 
    </div>
    <?php
	}?>
    <input name="reply" type="hidden" id="reply" value="1">
    <input name="editorname1" type="hidden"  value="replyDiscussion">
    <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
    <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
    <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
    <input type="hidden" name="nodeOrder" value="0" id="nodeOrder">
    <input type="hidden" name="ptid" value="<?php echo $this->uri->segment(8);?>" id="ptid">
    <input type="hidden" name="seedTalk" value="<?php echo $this->uri->segment(9);?>" id="seedTalk">
    <input type="hidden" id="leafTreeId" name="leafTreeId" value="<?php echo $this->uri->segment(3);?>" >
  </form>
</div>
</div>
</div>

<script>
function reply(id,focusId)
{
	whofocus=focusId;	
	frameIndex = focusId;
	var divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';

}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}
function newTopic(id,focusId,position)
{

	whofocus=focusId;	
	frameIndex = focusId;
	var divid='newTopic'+id;
	document.getElementById(divid).style.display='';
	
}
function newTopicClose(id){
	divid='newTopic'+id;
 	document.getElementById(divid).style.display='none';
}
function vksfun(focusId){
whofocus=focusId;
}
$(document).ready(function(){
	ht = parseInt($(".fixedDiv").css('height'))+10;
	$('.talkTreeComments').css('top',ht+'px');
});
$(window).resize(function(){
	ht = parseInt($(".fixedDiv").css('height'))+10;
	$('.talkTreeComments').css('top',ht);
});

</script>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
<script>
request_refresh_once();
//chnage_textarea_to_editor('replyDiscussion','');
chnage_textarea_to_editor('replyDiscussion<?php echo $this->uri->segment(3);?>','talk');
//setInterval("request_refresh()", 5000);
//Add SetTimeOut 
setTimeout("request_refresh()", 5000);
</script>
</body>
</html>
<script>
function clearTalks(nodeId)
  {
  		msg = "Are you sure you want to remove previous comments?";
	
		var agree = confirm(msg);
		if(agree)
		{
		
			$(".clearLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	  		//return false;
			$.ajax({
	
				  url: baseUrl+"comman/clearLeafObjects/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/talk/"+nodeId,
	
				  type: "POST",
	
				  success:function(result)
				  {
						//alert(result);
						if(result=='1')
						{
							$('.clearTalkBTN'+nodeId).hide();
							setTalkCount(nodeId);
							request_refresh_once();
							
							var httpDoc = getHTTPObjectm();
	
							urlm=baseUrl+'view_talk_tree/setTalkCount/'+nodeId;
							
							httpDoc.open("POST", urlm, true); 
							httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							httpDoc.onreadystatechange = function()
							{ 
							   if (httpDoc.readyState==4 && httpDoc.status==200)
							   {
									var result = '';
									result = httpDoc.responseText;	   
									if(result==0)
									{
										result='';
									}
									//document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
									window.opener.$("#liTalk"+nodeId).html(result);
									//window.opener.document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
							   }
							}     
							httpDoc.send();
							
							$(".clearLoader").html("");
							//parent.location.reload();
						}
				  }
	
			});
		}
  }
  
$(document).ready(function(){
	var artifactId = '';
	var artifactType = '';
	var talkartifactId = '';
	talkartifactId = '<?php echo $treeId; ?>'; 
	artifactId = '<?php echo $treeId; ?>';
	artifactType = 2;
	//alert(artifactId+'==='+artifactType);
	setTalkCount(talkartifactId);
	setLastTalk(talkartifactId);
	setTagAndLinkCount(artifactId,artifactType);
	setTagsAndLinksInTitle(artifactId,artifactType);
	getSimpleColorTag(artifactId,artifactType);
	getTreeLeafObjectIconStatus('<?php echo $currentTreeId ?>', '<?php echo $artifactId ?>', '<?php echo $leafId ?>', '<?php echo $currentNodeOrder ?>', '<?php echo $parentLeafId ?>', '<?php echo $currentLeafStatus ?>', '<?php echo $workSpaceId; ?>', '<?php echo $artifactType ?>', '<?php echo $treeType ?>');
	
	if(artifactType==1)
	{
		getParentUpdatedSeedContents('<?php echo $currentTreeId ?>',1);
	}
	
	var treesType = '<?php echo $treeType ?>';
	if(treesType == 4 && artifactType==2)
	{
		getShowHideTreeLeafIconsStatus('<?php echo $currentTreeId ?>', '<?php echo $artifactId ?>', '<?php echo $treeType ?>');
	}
});  
</script>