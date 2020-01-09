<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
    
    <?php if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)
		{
	?>
		<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>
	<?php
		}         
	?>
    
    <script language="javascript" src="<?php echo base_url();?>js/document.js"></script>
    <script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    
	<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<!--<script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> -->	
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></link>
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
  <tr>
    <td valign="top">
        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">
			<!-- header -->	
			<?php $this->load->view('common/header'); ?>
			<!-- header -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">
				<?php $this->load->view('common/wp_header'); ?>
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">
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
			 $this->load->view('common/artifact_tabs', $details); ?>
			<!-- Main menu -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="76%" height="8" align="left" valign="top"></td>
                  <td width="24%" align="left" valign="top"></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">
					<!-- Main Body -->
<script>
function cancelActivity(url)
{
	window.location = url;
}
function changeOption(thisVal)
{
	document.getElementById('curOption').value = thisVal;
	if(thisVal == 1 && document.getElementById('treeStatus').value == 1 && trim(document.getElementById('replyDiscussion').value)=='')
	{
		window.location = baseUrl+'view_activity/node/'+document.getElementById('treeId').value+'/'+workSpaceId+'/type/'+workSpaceType;
	}
}
function calStartCheck(thisVal)
{
	if(thisVal.checked == true)
	{			
		document.getElementById('calStart').style.display = "";	
		document.getElementById('starttime').style.color = "#000000";	
		document.getElementById('starttime').style.backgroundColor = "#FFFFFF";	
	}
	else
	{		
		document.getElementById('calStart').style.display = 'none';
		document.getElementById('starttime').style.color = "#626262";	
		document.getElementById('starttime').style.backgroundColor = "#CCCCCC";	
	}
}
function calEndCheck(thisVal)
{
	if(thisVal.checked == true)
	{		
		document.getElementById('calEnd').style.display = '';
		document.getElementById('endtime').style.color = "#000000";	
		document.getElementById('endtime').style.backgroundColor = "#FFFFFF";	
	}
	else
	{		
		document.getElementById('calEnd').style.display = 'none';
		document.getElementById('endtime').style.color = "#626262";	
		document.getElementById('endtime').style.backgroundColor = "#CCCCCC";	
	}
}
function changeMode(thisVal)
{
	if(thisVal.value == 'Yes')
	{
		document.getElementById('trActivityTitle').style.display = '';
		document.getElementById('butAddMore').style.display = '';
		
	}
	else
	{
		document.getElementById('trActivityTitle').style.display = 'none';
		document.getElementById('butAddMore').style.display = 'none';
		
	}
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
	else if(date1 == date2)
	{
		
		if (hours2 > hours1)
		{
			
			return -1;
		}
		else if(hours2 < hours1)
		{
			return 1;
		}
		else if(hours1 == hours2)
		{
			
			if(minites2 < minites1)
			{
				return 1;
			}	
			else
			{
				return -1;
			}
		}
	}
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
	
   else return 0;
} 

function showFocus()
	{
		//parent.frames[0].gk.EditingArea.focus();
	} 
	 

 
var request_refresh_point=1;
var nodeId='';
function validate_dis(){
	var error='';
	var title = getvaluefromEditor('title');
	var replyDiscussionValue = getvaluefromEditor('replyDiscussion');
	
	if(document.getElementById('curOption').value == 1 && document.getElementById('treeStatus').value == 1 && replyDiscussionValue=='')
	{
		window.location = baseUrl+'view_activity/node/'+document.getElementById('treeId').value+'/'+workSpaceId+'/type/'+workSpaceType;
		
	}
	else
	{
		if(title=='' && replyDiscussionValue=='')
		{			
			error+='<?php echo $this->lang->line('enter_title_activity_or_activity_detail'); ?>\n';			
		}
	}
//	if(document.getElementById('replyDiscussion').value==''){
	 	//error+=' ';
	//}
	var formname=document.form1;
	if(formname.starttime.value!='' && formname.endtime.value!='' ){
		if(compareDates(formname.starttime.value,formname.endtime.value) == 1){
			error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';
		}
	}
	if(error==''){
		request_refresh_point=0;
		document.form1.submit();
		//request_send();
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
		urlm='<?php echo base_url();?>new_Chat/start_Chat/<?php echo $pnodeId;?>';
		var data='reply=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&title='+document.getElementById('title').value+'&replyDiscussion='+document.getElementById('replyDiscussion').value+'&starttime='+document.getElementById('starttime').value+'&endtime='+document.getElementById('endtime').value;
	}else{
		urlm='<?php echo base_url();?>new_Chat/index/<?php echo $treeId;?>';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+document.getElementById('replyDiscussion').value;
		//alert(urlm+data);
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
			document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;
			
		}
	}
}
function request_refresh(){
	if(request_refresh_point){
		url='<?php echo base_url();?>view_Chat/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
	//	alert(url);
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}
</script>
					<form name="form1" method="post" action="<?php echo base_url();?>new_activity/start_Activity/<?php echo $pnodeId;?>/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="3">
<?php 
$treeStatus = 0;
if($this->uri->segment(8) != '' && $this->uri->segment(8) > 0)
{
	$treeStatus = 1;
	$treeId		= $this->uri->segment(8);
	$treeDetail = $this->activity_db_manager->getDiscussionDetailsByTreeId( $treeId );
	$arrDiscussions	= $this->activity_db_manager->getNodesByTree($treeId);
	if(count($arrDiscussions) > 0)
	{	
		?>
		<table width="100%">
		<tr><td>
			<span class="style1"><?php echo $treeDetail['name'];?></span>
			</td></tr>
		<tr><td>
			<hr>
			</td></tr>
		<?php					 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			?>
			<tr><td>
			<?php echo $arrVal['contents'];?>
			</td></tr>
			<tr><td><hr></td></tr>
			<?php
					
		}
		?>
		</table>
		<?php		
	}	
}



?>
</td>
  
  </tr>
	<?php
	if($treeStatus == 0)
	{	
	?>
  <tr>
    <td><?php echo $this->lang->line('txt_Is_it_activity_list');?>? </td>
    <td>   <input type="radio" name="listStatus" value="Yes" onClick="changeMode(this)">
          <?php echo $this->lang->line('txt_Yes');?> &nbsp;
          <input name="listStatus" type="radio" value="No" checked onClick="changeMode(this)">
          <?php echo $this->lang->line('txt_No');?>
	</td>
    <td>&nbsp;</td>
  </tr>
	<tr id="trActivityTitle" style="display:none;">
    <td><?php echo $this->lang->line('txt_Activity_Title');?> </td>
    <td> 
    <textarea id="title" name="title"></textarea>	
	</td>
    <td>&nbsp;</td>
  </tr>
	<?php
}
	?>
    <tr>
      <td valign="top"><span id="vk12345"></span><br>
          <?php echo $this->lang->line('txt_Activity');?>: &nbsp; </td>
      <td valign="top"><textarea name="replyDiscussion" id="replyDiscussion" rows="3" cols="35"></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td>
			 
			<?php echo $this->lang->line('txt_Start_Time');?>: 
	</td>
    <td><input type="checkbox" name="startCheck" onClick="calStartCheck(this)"><input name="starttime" type="text" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>
    <td>&nbsp;</td>
  </tr>
	  <tr>
    <td>
			<?php echo $this->lang->line('txt_End_Time');?>: 
			
			
</td>
    <td><input type="checkbox" name="endCheck" onClick="calEndCheck(this)"><input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>
    <td>&nbsp;</td>
	  </tr>
  <tr>
    <td valign="top"><?php echo $this->lang->line('txt_Assignees');?></td>
    <td valign="top">
	<select name="activityUsers[]" multiple>
		<option value="<?php echo $_SESSION['userId'];?>" selected><?php echo $this->lang->line('txt_Me');?></option>
		<option value="0"><?php echo $this->lang->line('txt_All');?></option>
		<?php	
		foreach($workSpaceMembers as $arrData)
		{
			if($_SESSION['userId'] != $arrData['userId'])
			{		
			?>
				<option value="<?php echo $arrData['userId'];?>"><?php echo $arrData['tagName'];?></option>
			<?php
			}
		}		
		?>
	</select>
	</td>
    <td valign="top">&nbsp;</td>
  </tr>
	<tr>
		<td width="24%" valign="top">
			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>
				</td>
	    <td width="66%" valign="top">&nbsp;
          <input type="radio" name="calendarStatus" value="Yes">
          <?php echo $this->lang->line('txt_Yes');?> &nbsp;
          <input name="calendarStatus" type="radio" value="No" checked>
          <?php echo $this->lang->line('txt_No');?> </td>
	    <td width="10%" valign="top">&nbsp;</td>
	</tr>
	<tr>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">
<?php
$addMoreDisplay = '';
if($treeStatus == 0)
{
	$addMoreDisplay = 'none';
}
$cancelUrl = base_url().'view_activity/View_All/0/'.$workSpaceId.'/type/'.$workSpaceType;
?>
	<span id="butAddMore" style="display:<?php echo $addMoreDisplay;?>;">
    
   
    <a href="#" onClick="changeOption(2),validate_dis();"><img src="<?php  echo base_url();?>images/btn-addmore.gif" border="0"></a>
    </span>
<span id="butDone">
    <a href="#" onClick="changeOption(1),validate_dis();"><img src="<?php  echo base_url();?>images/done-btn.jpg" border="0"></a>
    </span>
	<span id="butCancel">    
    <a href="#" onClick="cancelActivity('<?php echo $cancelUrl;?>');"><img src="<?php  echo base_url();?>images/btn-cancel.jpg" width="52" border="0" height="16"></a></span>
	</td>
	  <td valign="top">&nbsp;</td>
	</tr>
  <tr>
    <td colspan="3">
		        <input name="reply" type="hidden" id="reply" value="1">
		        <input name="editorname1" type="hidden"  value="replyDiscussion">
				 <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				<input type="hidden" name="curOption" id="curOption" value="1">
				<input type="hidden" name="treeStatus" id="treeStatus" value="<?php echo $treeStatus;?>">
				</td>
  </tr>
</table>

	
                
		</form>
<script>
chnage_textarea_to_editor('title','simple');
chnage_textarea_to_editor('replyDiscussion','simple');


function reply(id)
{
	divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
	//parent.frames[id].gk.EditingArea.focus();
	rameid=id;	
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}</script>
				<!-- Main Body -->
				<!-- Right Part-->			
				<!-- end Right Part -->
				</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copy">
			<!-- Footer -->	
				<?php $this->load->view('common/footer');?>
			<!-- Footer -->
			</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>
