<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title></title>

<head>

<?php require('common/view_head.php');?>

<script>

function cancelTask(url)

{

	//window.location = url;

	location.reload (true);

}

function changeOption(thisVal)

{	

	document.getElementById('curOption').value = thisVal;

	if(thisVal == 1 && document.getElementById('treeStatus').value == 1 && trim(document.getElementById('replyDiscussion').value)=='')

	{

		window.location = baseUrl+'view_task/node_task/'+document.getElementById('nodeId').value+'/'+workSpaceId+'/type/'+workSpaceType;

	}

}

function calStartCheck(thisVal)

{

	if(thisVal.checked == true)

	{			

		document.getElementById('calStart').style.display = "";	

		document.getElementById('starttime').style.color = "#000000";	

		document.getElementById('starttime').style.backgroundColor = "#FFFFFF";	

		document.getElementById('mark_calender').style.display = "";

	}

	else

	{		

		document.getElementById('calStart').style.display = 'none';

		document.getElementById('starttime').style.color = "#626262";	

		document.getElementById('starttime').style.backgroundColor = "#CCCCCC";	

		

		if ((document.getElementById('calStart').style.display == 'none') && (document.getElementById('calEnd').style.display == 'none'))

		{

			document.getElementById('mark_calender').style.display = "none";

			//document.form1.calendarStatus.checked = false;

		}		

	}

}

function calEndCheck(thisVal)

{

	if(thisVal.checked == true)

	{		

		document.getElementById('calEnd').style.display = '';

		document.getElementById('endtime').style.color = "#000000";	

		document.getElementById('endtime').style.backgroundColor = "#FFFFFF";	

		document.getElementById('mark_calender').style.display = "";

	}

	else

	{		

		document.getElementById('calEnd').style.display = 'none';

		document.getElementById('endtime').style.color = "#626262";	

		document.getElementById('endtime').style.backgroundColor = "#CCCCCC";	

		

		if ((document.getElementById('calStart').style.display == 'none') && (document.getElementById('calEnd').style.display == 'none'))

		{

			document.getElementById('mark_calender').style.display = "none";

			//document.form1.calendarStatus.checked = false;

		}

	}

}

function changeMode(thisVal)

{

	if(thisVal.value == 'Yes')

	{

		document.getElementById('trTaskTitle').style.display = '';

		document.getElementById('butAddMore').style.display = '';

		

	}

	else

	{

		document.getElementById('trTaskTitle').style.display = 'none';

		document.getElementById('butAddMore').style.display = 'none';

		

		

	}

}

function compareDates (dat1, dat2) {



	//alert ('date1= ' +dat1);

	//alert ('date2= ' +dat2);

   var date1, date2;

   var month1, month2;

   var year1, year2;

	 value1 = dat1.substring (0, dat1.indexOf (" "));

	  value2 = dat2.substring (0, dat2.indexOf (" "));

	  time1= dat1.substring (16, dat1.indexOf (" "));

	  time2= dat2.substring (16, dat2.indexOf (" "));

	  

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

   

   //alert ('hour1= ' + hours1);

   //alert ('hour2= ' + hours2);



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

function validate_dis(pnodeId,workSpaceId,workSpaceType,linkType){

	var error='';

    var replyDiscussionValue	= CKEDITOR.instances.replyDiscussion.getData();

    var formname=document.form1;

	//alert ('formstart= ' + formname.startCheck.checked);

	//alert ('formnend= ' + formname.endCheck.value);

	//var title = getvaluefromEditor('title','simple');

	//var replyDiscussionValue = getvaluefromEditor('replyDiscussion','simple');

	



/*		if(title=='')

		{			

			error+='Please Enter SubTask Title \n';			

		}*/

		if(replyDiscussionValue=='')

		{			

			error+='<?php echo $this->lang->line('enter_subtask'); ?>\n';			

		}		



	

	if(formname.starttime.value!='' && formname.endtime.value!='' && formname.startCheck.checked==true && formname.endCheck.checked==true){

		if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

			error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';

		}

	}

	if(error==''){

		request_refresh_point=0;

		

		

		var data_user =$(formname).serialize();

		

			var request = $.ajax({

			  url: baseUrl+"new_task/start_sub_task/"+pnodeId+'/0/'+workSpaceId+'/type/'+workSpaceType+'/'+linkType,

			  type: "POST",

			  data: data_user+'&replyDiscussion='+encodeURIComponent(replyDiscussionValue),

			  dataType: "html",

			  success:function(result){

			                         	// parent.location.href=parent.location.href;

										 //tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion');

										 CKEDITOR.instances.replyDiscussion.destroy();

									  	$("#divNodeContainer").html(result);

			                          }

			});

		

		//document.form1.submit();

		//request_send();

	}else{

		jAlert(error);

		return false;

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





function showFilteredMembers()

{

	var toMatch = document.getElementById('showMembers').value;

	var val = '';



		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			if ($workSpaceId != 0)

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

			else

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

</script>



</head>

<body>

<div>

  <form name='form1' method='post' action='<?php echo base_url();?>new_task/start_sub_task/<?php echo $pnodeId;?>/0/ <?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>'>

    <?php 

$treeStatus = 0;



$treeDetail = $this->task_db_manager->getDiscussionDetailsByNodeId( $pnodeId );

$treeId = $treeDetail['treeId'];

if($this->uri->segment(8) != '' && $this->uri->segment(8) > 0)

{

	$treeStatus = 1;

	$nodeId		= $this->uri->segment(8);	

	$arrDiscussions	= $this->task_db_manager->getNodesByPredecessor($nodeId);

}

?>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

      <?php

		if(0)

		{	

		?>

      <?php echo $this->lang->line('txt_Sub_List_Title');?>

      <div>

        <textarea name="title" id="title"><?php echo $treeDetail['contents']; ?></textarea>

      </div>

      <?php

		}

		?>

      <span id="vk12345"></span><br>

      <?php echo $this->lang->line('txt_Sub_Task');?>: &nbsp;

      <textarea name="replyDiscussion"rows="3" ></textarea>

    </div>

    <div style="clear:both;"></div>

    

    <div style="width:81%; padding-left:5%; padding-right:10%;background-color:transparent;">

    	<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 

    	<span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span>

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <input type="checkbox" name="startCheck" onClick="calStartCheck(this)">

    <input name="starttime" type="text" id="starttime" size="16"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

    <span id="calStart" style="display:none">

    <img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span> 

    </div>

    

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <span style="vertical-align:top" > <?php echo $this->lang->line('txt_End_Time');?>:</span>

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

        <input type="checkbox" name="endCheck" onClick="calEndCheck(this)">

        <input name="endtime" type="text" id="endtime" size="16" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

        <span id="calEnd" style="display:none;width:15%;"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span> 

	</div>

	

	<div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

	<?php echo $this->lang->line('txt_Assigned_To');?>:

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <input type="text" id="showMembers" name="showMembers" onKeyUp="showFilteredMembers()"/>

    </div>

    

    <div id="showMem" style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

      <input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>

      <?php echo $this->lang->line('txt_Me');?><br />

      <input type="checkbox" name="taskUsers[]" value="0"/>

      <?php echo $this->lang->line('txt_All');?><br />

      <?php	

			if($workSpaceId==0)

			{								

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

      <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/>

      <?php echo $arrData['tagName'];?><br />

      <?php

					}

				}

			}

			else

			{

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

      <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/>

      <?php echo $arrData['tagName'];?><br />

      <?php

					}

				}

			}

			?>

    </div>

    

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;display:none;" id="mark_calender">

    <span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>

    <input type="radio" name="calendarStatus" value="Yes">

    <?php echo $this->lang->line('txt_Yes');?> &nbsp;

    <input name="calendarStatus" type="radio" value="No" checked>

    <?php echo $this->lang->line('txt_No');?> 

    </div>

    

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <?php echo $this->lang->line('txt_Completion_Status');?>:

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <input type="radio" name="completionStatus" value="0" checked="checked" >

    0% &nbsp;&nbsp;&nbsp;

    <input type="radio" name="completionStatus" value="1" >

    25% &nbsp;&nbsp;&nbsp;

    <input type="radio" name="completionStatus" value="2" >

    50%	&nbsp;&nbsp;&nbsp;

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <input type="radio" name="completionStatus" value="3" >

    75% &nbsp;&nbsp;&nbsp;

    <input type="radio" name="completionStatus" value="4" >

    Completed	&nbsp;&nbsp;

    </div>

    <div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

	<?php

$addMoreDisplay = '';

if($treeStatus == 0)

{

	$addMoreDisplay = 'none';

}

$cancelUrl = base_url().'view_task/node_task/'.$pnodeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

?></div>

<div style="width:81%; padding-left:5%; padding-right:12%;background-color:transparent;">

    <span id="butDone">

    <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Add');?>" onClick="validate_dis(<?php echo $pnodeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $linkType;?>);" class="button01">

    &nbsp;&nbsp;&nbsp;&nbsp; </span> <span id="butCancel">

    

    <input type="button" id="cancel" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hidePopWin(false)" class="button01">

    </span></div></div>

    <input name="reply" type="hidden" id="reply" value="1">

    <input name="editorname1" type="hidden"  value="replyDiscussion">

    <input name="editorname2" type="hidden" value="title">

    <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

    <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

    <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

    <input type="hidden" name="curOption" id="curOption" value="1">

    <input type="hidden" name="treeStatus" id="treeStatus" value="<?php echo $treeStatus;?>">

    <input type="hidden" name="titleStatus" value="0" id="titleStatus">

    <input name="leafId" type="hidden" id="reply" value="<?php echo $treeDetail['leafId'];?>">

    <input name="nodeId" id="nodeId" type="hidden" value="<?php echo $pnodeId;?>">

  </form>



<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

<!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

<script Language="JavaScript" src="<?php echo base_url();?>js/document_js.js"></script>

<script Language="JavaScript" src="<?php echo base_url();?>jcalendar/calendar.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/common.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/subModal.js"></script>

<script>

//chnage_textarea_to_editor('title','simple');

chnage_textarea_to_editor('replyDiscussion','simple');

parent.document.getElementById('popupContainer').style.width='80%';

parent.document.getElementById('popupInner').style.width='100%';

parent.document.getElementById('popupFrame').style.width='99.5%';





//parent.document.getElementById('popupFrame').style.paddingRight='45%';

//parent.document.getElementById('popupFrame').style.border='2px solid red';

$(document).ready(function(){

	$('#calStart').click(function(){

		$('#calendarDiv').css({'left':'14.5%'});

		$('#calendarDiv').css({'top':'57%'});

	});

	$('#calEnd').click(function(){

		$('#calendarDiv').css({'left':'14.5%'});

		$('#calendarDiv').css({'top':'64.5%'});

	});

	$('#butCancel').click(function(){

		$('#popupMask').hide();

		$('#popupContainer').hide();

	});

	

});

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

}

</script>

</body>

</html>

