<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > New</title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

<script>

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

        	?>



		}

}

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

    <!-- Main Body -->

    <form name="form1" method="post" action="<?php echo base_url();?>new_task/start_Task/<?php echo $pnodeId;?>/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>">
    <?php 

$treeStatus = 0;

if($this->uri->segment(8) != '' && $this->uri->segment(8) > 0)

{

	$treeStatus = 1;

	$treeId		= $this->uri->segment(8);

	$treeDetail = $this->task_db_manager->getDiscussionDetailsByTreeId( $treeId );

	$arrDiscussions	= $this->task_db_manager->getNodesByTree($treeId);

	if(count($arrDiscussions) > 0)

	{	

		?>

      <span class="style1"><?php echo $treeDetail['name'];?></span>

      <hr>

      <?php					 

		foreach($arrDiscussions as $keyVal=>$arrVal)

		{

			?>

      <?php echo $arrVal['contents'];?>

      <?php

					

		}

		?>

      <?php		

	}	

}

?>

      <?php

	if($treeStatus == 0)

	{	

	?>
	      <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>
      <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
      <?php
	}
	?>        <span class="taskLabel">

	  <?php echo $this->lang->line('txt_Task_Title');?>

      </span>

      <span class="taskTextDiv">

      <textarea id="title" name="title"></textarea>

      </span>

     <!-- <span class="taskLabel">

      <?php echo $this->lang->line('txt_Contributors');?>: 

      </span>

      <span class="taskTextDiv">

      <?php echo $this->lang->line('txt_Search');?>&nbsp;&nbsp;:

      </span>

      <span class="taskLabel">&nbsp;</span>

      <span class="taskTextDiv">

      <input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></span>

      <span class="taskLabel">&nbsp;</span>

      <span class="taskTextDiv">

      <div id="showMem" style="max-height:150px; max-width:300px;overflow:auto;">

        <input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>"/>

        <?php echo $this->lang->line('txt_Me');?><br />

        <?php

						if ($workSpaceId != 0)

						{

						?>

        <input type="checkbox" name="notesUsers[]" value="0" checked="checked"/>

        <?php echo $this->lang->line('txt_All');?><br />

        <?php

						}

						?>

        <?php	

											

						foreach($workSpaceMembers as $arrData)

						{

							if($_SESSION['userId'] != $arrData['userId'])

							{						

						?>

        <input type="checkbox" name="notesUsers[]" value="<?php echo $arrData['userId'];?>"/>

        <?php echo $arrData['tagName'];?><br />

        <?php

					   		}

						}

						?>

      </div>

      </span>-->

     <!-- <span class="taskLabel">

      <?php echo $this->lang->line('txt_Numbered_Tasks');?>&nbsp;&nbsp;:

      </span>

      <span class="taskTextDiv">

      <input type="checkbox" name="autonumbering"/><br />

      <a href="javascript:void(0);" onclick="showAllOptions();"><?php echo $this->lang->line('txt_Add_Task');?></a>

      </span>-->

      <?php

	}

	?>

  <!--    <div id="allOptions" style="display:none;"> <span id="vk12345"></span><br>

      <span class="taskLabel">

        <?php echo $this->lang->line('txt_Task');?>: &nbsp;

        </span>

        <span class="taskTextDiv">

        <textarea name="replyDiscussion" id="replyDiscussion"></textarea>

        </span>

        <span class="taskLabel">

		<?php echo $this->lang->line('txt_Start_Time');?>&nbsp;&nbsp;:

        </span>

        <span class="taskTextDiv">

        <input type="checkbox" name="startCheck" onClick="calStartCheck(this)">

        <input name="starttime" type="text" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

        <span id="calStart" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span> 

        </span>

		<span class="taskLabel">

		<?php echo $this->lang->line('txt_End_Time');?>:

        </span>

        <span class="taskTextDiv">

        <input type="checkbox" name="endCheck" onClick="calEndCheck(this)">

        <input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

        

        <span id="calEnd" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span> </span>

		<span class="taskLabel">

		<?php echo $this->lang->line('txt_Assigned_To');?>&nbsp;:

        </span>

       <span class="taskTextDiv">

        <input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></span>

        <span class="taskLabel">&nbsp;</span>

        <span class="taskTextDiv">

        <div id="showMem" style="max-height:150px; max-width:300px;overflow:auto;">

          <input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>

          <?php echo $this->lang->line('txt_Me');?><br />

          <input type="checkbox" name="taskUsers[]" value="0"/>

          <?php echo $this->lang->line('txt_All');?><br />

          <?php	

											

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

			?>

        </div>

        </span>

        <div id="mark_calender" style="display:none;"> 

        <span id="vk12345" class="taskLabel">

		<?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>

        <span class="taskTextDiv">

          <input type="radio" name="calendarStatus" value="Yes">

          <?php echo $this->lang->line('txt_Yes');?> &nbsp;

          <input name="calendarStatus" type="radio" value="No" checked>

          <?php echo $this->lang->line('txt_No');?> </span></div>

          

      </div>-->

      <?php

	$addMoreDisplay = '';

	if($treeStatus == 0)

	{

		$addMoreDisplay = 'none';

	}

	$cancelUrl = base_url().'view_task/View_All/0/'.$workSpaceId.'/type/'.$workSpaceType;

	?>

     <span class="taskLabel">&nbsp;</span>

    <span class="taskTextDiv">

      <span id="butAddMore" style="display:<?php echo $addMoreDisplay;?>;">

      <input type="button" value="<?php echo $this->lang->line('txt_Add_More');?>" onClick="changeOption(2),validate_dis();" class="button01">

      </span> <span id="butDone">

      <input type="button" value="<?php echo $this->lang->line('txt_Done');?>" onClick="return changeOption(1),validate_dis();closeCalendar();" class="button01"/>

      </span> <span id="butCancel">

      <input type="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="cancelTask('<?php echo $cancelUrl;?>');closeCalendar();" class="button01"/>

      </span>

      </span>

      <input name="reply" type="hidden" id="reply" value="1">

      <input name="editorname1" type="hidden"  value="replyDiscussion">

      <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

      <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

      <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

      <input type="hidden" name="curOption" id="curOption" value="1">

      <input type="hidden" name="treeStatus" id="treeStatus" value="<?php echo $treeStatus;?>">

    </form>

    <!-- Main Body -->

  </div>

</div>

<?php $this->load->view('common/foot.php');?>

<?php $this->load->view('common/footer');?>

</body>

</html>

<script>





function showAllOptions ()

{

	if (document.getElementById('allOptions').style.display=='none')

	{

		document.getElementById('allOptions').style.display='block';

	}

	else

	{

		document.getElementById('allOptions').style.display='none';

	}

}

function cancelTask(url)

{

	window.location = url;

}

function changeOption(thisVal)

{

	document.getElementById('curOption').value = thisVal;

	if(thisVal == 1 && document.getElementById('treeStatus').value == 1 && trim(document.getElementById('replyDiscussion').value)=='')

	{

		window.location = baseUrl+'view_task/node/'+document.getElementById('treeId').value+'/'+workSpaceId+'/type/'+workSpaceType;

	}

}

/*

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

		document.getElementById('mark_calender').style.display = "none";

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

		document.getElementById('mark_calender').style.display = "none";	

	}

}*/

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



 

var request_refresh_point=1;

var nodeId='';

function validate_dis(){

	var error='';

	

	//var title=CKEDITOR.instances.title.getData();

	//var title = getvaluefromEditor('title');
	
	var title = document.getElementById('title').value;

	

	if(title.indexOf("<img")!=-1)

	{

		error+='Please do not use images in title';		

	}

	else if($("<p>"+title+"</p>").text().trim()=='')

	{

		error+="<?php echo $this->lang->line('enter_task_title'); ?>\n";

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



//chnage_textarea_to_editor('title','simple');

//tinymce.execCommand('mceFocus',false,'title');

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

}

</script>

