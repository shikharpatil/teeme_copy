<script>

$(document).ready(function(){

	//	Manoj: Added date time picker for mobile
    //$("#dtBox").DateTimePicker();
});

function cancelTask(url)

{

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


function calStartCheck(thisVal, pos, formName, currentTime)

{	
	//	Manoj: Added date time picker for mobile
     $("#dtBox").DateTimePicker();
	 
	//alert ('pos= ' +formName);

	//var callStartId = 'calStart'+pos;

	if(thisVal.checked == true)

	{			

		formName.starttime.style.color = "#000000";	

		formName.starttime.style.backgroundColor = "#FFFFFF";

			
		document.getElementById('mark_calender').style.display = "";
		
		//Manoj: Make disabled false 
		//$('.startCal').attr('disabled', false);
		$( "#starttime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", false );
	}

	else

	{		
		$( "#starttime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", true );

		formName.starttime.style.color = "#626262";	

		formName.starttime.style.backgroundColor = "#CCCCCC";	

		formName.starttime.value = currentTime;

		

		if (formName.endCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

	}

	if($("#endCheck").prop('checked') == true)
	{
			$( "#endtime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", false );
	}
	else
	{
			$( "#endtime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", true );
	}	

		
	

}


function calEndCheck(thisVal, pos, formName, currentTime)

{
	//	Manoj: Added date time picker for mobile
     $("#dtBox").DateTimePicker();
	 
	if(thisVal.checked == true)

	{		
	
		formName.endtime.style.color = "#000000";	

		formName.endtime.style.backgroundColor = "#FFFFFF";	
		
		document.getElementById('mark_calender').style.display = "";
		
		//$('.endCal').attr('disabled', false);

		$( "#endtime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", false );

	}

	else

	{		
	
		$( "#endtime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", true );

		formName.endtime.style.color	 = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

		formName.endtime.value = currentTime;

		if (formName.startCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

	}
	
	if($("#startCheck").prop('checked') == true)
	{
			$( "#starttime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", false );
	}
	else
	{
			$( "#starttime<?php echo $this->uri->segment(9);?>" ).prop( "disabled", true );
	}

}
/*
function calStartCheck(thisVal)

{

	if(thisVal.checked == true)

	{			

		document.getElementById('mark_calender').style.display = "";

		$('.startCal').attr('disabled','');

	}

	else

	{		

		$('.startCal').attr('disabled','disabled');

		if ($('#endCheck').attr('checked')==false)

		{

			document.getElementById('mark_calender').style.display = "none";

		}

	}

}

function calEndCheck(thisVal)

{

	if(thisVal.checked == true)

	{		$('.endCal').attr('disabled','');

		document.getElementById('mark_calender').style.display = "";

	}

	else

	{		

		$('.endCal').attr('disabled','disabled');

		if ($('#startCheck').attr('checked')==false)

		{

			document.getElementById('mark_calender').style.display = "none";

		}

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
/*
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

} */

function compareDates (dat1, dat2) {
		//alert ('Here'); return 1;

   		var date1, date2;

   		var month1, month2;

   		var year1, year2;
		
		

	 	value1 = dat1.substring (0, dat1.indexOf (" "));

	  	value2 = dat2.substring (0, dat2.indexOf (" "));

	  	time1= dat1.substring (16, dat1.indexOf (" "));

	  	time2= dat2.substring (16, dat2.indexOf (" "));
	  

	  	hours1= time1.substring (0, time1.indexOf (":"));

	  //	minites1= time1.substring (1, time1.indexOf (":"));
	  minites1 = time1.substring(time1.lastIndexOf (":")+1, time1.length);

	  

	  	hours2= time2.substring (0, time2.indexOf (":"));

	 	//minites2= time2.substring (1, time2.indexOf (":"));
		minites2 = time2.substring(time2.lastIndexOf (":")+1, time2.length);

	  

   		date1 = value1.substring (0, value1.indexOf ("-"));

   		month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));

   		year1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);



   		date2 = value2.substring (0, value2.indexOf ("-"));

   		month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));

   		year2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

	



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
   
   else if (minites1 == minites2) return 1;

   else return 0;

}


function showFocus()

	{

		//parent.frames[0].gk.EditingArea.focus();

	} 

	 



 

var request_refresh_point=1;

var nodeId='';

function validate_dis(pnodeId,workSpaceId,workSpaceType,linkType,formname){

	var error='';

	

    //var replyDiscussionValue	= CKEDITOR.instances.replyDiscussion.getData();

    var replyDiscussionValue	= getvaluefromEditor('replyDiscussion');

	

	//var formname=document.form1;

	

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
	
		$("#loader1").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

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

										 //CKEDITOR.instances.replyDiscussion.destroy();
										 
										 $("#loader1").html("");

									  	$("#divNodeContainer").html(result);
										
										document.getElementById('editStatus').value= 0;	

			                          }

			});

		

		//document.form1.submit();

		//request_send();

	}else{

		alert(error);

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





function assignTo(){

	$('#showMem').html($('#popupInner').html());

	$('#showMem > #popupTitleBar').replaceWith('');

	var a = '';

	var x=0;

	$('#popupInner > .showMem1 > input:checkbox').each(function(){

		var n=$(this).val();
		//Manoj: Remove true and added is checked
		if($(this).is(':checked')){

			if(n==<?php echo $_SESSION['userId'];?>){

				x=1;

			}

			if(a!='')

			{

				a=a+',';

			}

			$('#showMem > .showMem1 > input[value="'+n+'"]').attr('checked','checked');

			a = a+$(this).next().html();

		}

		else{

			$('#showMem > .showMem1 > input[value="'+n+'"]').removeAttr('checked');

		}

	});

	/*if(x==0 && a!='')

	{

		$('#showMem > .showMem1 > input[value="<?php echo $_SESSION['userId'];?>"]').removeAttr('checked');

	}

	else if(x==0 && a==''){

		a='Me';

		$('#showMem > .showMem1 > input[value="<?php echo $_SESSION['userId'];?>"]').attr('checked','checked');

	}*/

	$('#namesDiv').html(a);

	$('#popupInner').html(popWin);

	$('#popupFrame').attr('src','');

	curId='';

	initPopUp();

	hidePopWin(false);

}





var assign='';

function showFilteredMembers()

{
	//Manoj: commented tomatch code for search issue on popup mask 
	//var toMatch = document.getElementById('showMembers').value;
	
	var toMatch = $("#popupInner #showMembers").val();

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

					val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onclick="selectAllCheck(this)" /><?php echo $this->lang->line('txt_All');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

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

				val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><span><?php echo $arrData['tagName'];?></span><br>';

				//document.getElementById('showMem1').innerHTML = val;

				$('#popupInner >.showMem1').html(val);

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

				val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><span><?php echo $arrData['tagName'];?></span><br>';

				$('#popupInner > .showMem1').html(val);

			}

        

			<?php

				}

        	}

			}

        	?>



		}

		assign=val;

}

</script>



<form class="formTask" name="formAddSubTask<?php echo $pnodeId;?>" id="formAddSubTask<?php echo $pnodeId;?>" method='post' action='<?php echo base_url();?>new_task/start_sub_task/<?php echo $pnodeId;?>/0/ <?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>'>

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

  <div class="subTaskMobile fieldsetBottom">

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

    <textarea name="replyDiscussion"rows="3" id="replyDiscussion"></textarea>

  </div>

  

  <div class="subTaskMobile"> <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span> <!--<input type="checkbox" name="startCheck" id="startCheck" onClick="calStartCheck(this)" style="float:left">--></div>
  
	
		<input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
	<input name="starttime" type="text" style="background-color:#CCCCCC;color:#626262;" data-field="datetime" class="date-input-start" id="starttime<?php echo $this->uri->segment(9);?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>"  readonly> 
	
	<div id="dtBox"></div>	

    <?php /*?><div class="subTaskMobile" >

    	<input name="starttime" type="hidden" id="starttime" size="16"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>">



   

        D&nbsp;<select name="startDay" id="startDay" class="enterCal startCal" disabled="disabled" timing='start' style="width:44px">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==date("d"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="startMonth" id="startMonth" class="enterCal changeMonth startCal" disabled="disabled" timing='start' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==date("m"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    Y&nbsp;<select name="startYear" id="startYear" disabled="disabled" class="enterCal startCal changeMonth" timing='start' style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>

			<option <?php echo ($i==date("Y"))?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

    </div>

    <div class="subTaskMobile fieldsetBottom">

    H&nbsp;<select name="startHours" id="startHours" disabled="disabled" class="enterCal startCal" timing='start' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==date("H"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="startMins" id="startMins" disabled="disabled" class="enterCal startCal" timing='start' style="width:44px;">

    <?php

	for($i=0;$i<=59;$i++){?>

    	<option <?php echo ($i==date("i"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    </div><?php */?>

  <div class="subTaskMobile"> <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <span style="vertical-align:top" > <?php echo $this->lang->line('txt_End_Time');?>:</span> <!--<input type="checkbox" name="endCheck" id="endCheck" onClick="calEndCheck(this)" style="float:left;">--></div>

		<input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
		<input name="endtime" type="text" style="background-color:#CCCCCC;color:#626262;" data-field="datetime" class="date-input-end" id="endtime<?php echo $this->uri->segment(9);?>" class="edp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>"  readonly >


 <?php /*?> <div class="subTaskMobile" >

   

   <input name="endtime" type="hidden" id="endtime" size="16" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>">

  

    D&nbsp;<select name="endDay" id="endDay" disabled="disabled" class="enterCal endCal" timing='end' style="width:44px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==date("d"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="endMonth" id="endMonth" disabled="disabled" class="enterCal endCal changeMonth" timing='end' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==date("m"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    

    Y&nbsp;<select name="endYear" id="endYear" disabled="disabled" class="enterCal endCal changeMonth" timing='end' style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>

			<option <?php echo ($i==date("Y"))?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

    </div>

    <div class="subTaskMobile fieldsetBottom" >

    H&nbsp;<select name="endHours" id="endHours" disabled="disabled" class="enterCal endCal" timing='end' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==date("H"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="endMins" id="endMins" disabled="disabled" class="enterCal endCal" timing='end' style="width:44px;">

    <?php

	for($i=0;$i<=59;$i++){?>

    	<option <?php echo ($i==date("i"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select><?php */?>

    </div>

    

  

  <div class="subTaskMobile fieldsetBottom"><?php echo $this->lang->line('txt_Assigned_To');?>:<a href="javascript:void(0);" onclick="popup()">Click to Assign</a><div id="namesDiv"></div></div>

  

  

  

  <div id="showMem" class="subTaskMobile" style="display:none;">

    <input type="text" id="showMembers" name="showMembers" onKeyUp="showFilteredMembers()"/>

    <div class="showMem1">

     <?php	

			if($workSpaceId==0)

			{					
			
				//Manoj: Code for select all task users
				if (count($sharedMembers)!=0)

				{

			?>
	
      <input type="checkbox" name="taskUsers[]" value="0"  class="allcheck" onclick="selectAllCheck(this)"/>

      <span><?php echo $this->lang->line('txt_All');?></span><br />
	  

      <?php	

                }	
				//Manoj: code end	
				?>
			<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked" class="users"/>

      		<span><?php echo $this->lang->line('txt_Me');?></span><br />		
				<?php
				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

    <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" class="users"/>

    <span><?php echo $arrData['tagName'];?></span><br />

    <?php

					}

				}

			}

			else

			{
		?>
		
		<input type="checkbox" name="taskUsers[]" value="0"  class="allcheck" onclick="selectAllCheck(this)"/>

      	<span><?php echo $this->lang->line('txt_All');?></span><br />
	  	<!--Manoj: code paste here for txt_me-->
	  	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked" class="users"/>

      	<span><?php echo $this->lang->line('txt_Me');?></span><br />		
	  
		<?php
				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

    <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" class="users"/>

    <span><?php echo $arrData['tagName'];?></span><br />

    <?php

					}

				}

			}

			?>

            </div>

            <button class="button01 assignToBtn" onclick="assignTo();">Ok</button>

  </div>

  

  <div class="subTaskMobile fieldsetBottom" style="display:none;" id="mark_calender"> <span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>

    <input type="radio" name="calendarStatus" value="Yes">

    <?php echo $this->lang->line('txt_Yes');?> &nbsp;

    <input name="calendarStatus" type="radio" value="No" checked>

    <?php echo $this->lang->line('txt_No');?> </div>

  <div class="subTaskMobile"> <?php echo $this->lang->line('txt_Completion_Status');?>: 

      <select name="completionStatus" style="width:30%;"> 

    	<option value="0">0%</option>

        <option value="1">25%</option>

        <option value="2">50%</option>

        <option value="3">75%</option>

        <option value="4">Completed</option>

    </select>

     </div>

  <div class="subTaskMobile">

    <?php

$addMoreDisplay = '';

if($treeStatus == 0)

{

	$addMoreDisplay = 'none';

}

$cancelUrl = base_url().'view_task/node_task/'.$pnodeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

?>

  </div>

  <div class="subTaskControls"> 
  
  <div id="loader1"></div>
  
  <span id="butDone">

    <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Add');?>" onClick="validate_dis(<?php echo $pnodeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $linkType;?>,formAddSubTask<?php echo $pnodeId;?>);" class="button01">

     </span> <span id="butCancel">

    <input style="float:left;" type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New_replyDiscussion(this);" class="button01">

    </span>
	 <div id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:0%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $pnodeId;?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $pnodeId;?>" style="display:none; margin-left:0%; margin-top:0%; float:left;"></div></div>
	</div>

<div style="clear:both;"></div>

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

<script>

chnage_textarea_to_editor('replyDiscussion','simple');

var curId='';



function popup()

{

	initPopUp();

	showPopWin('your_url_here.html',480, 340,'');

	popWin = $('#popupInner').html();

	curId = 'showMem';

	$('#popupFrame').replaceWith($('#showMem').html());

	//Manoj: commented for Assign users popup cancel issue 
	//$('#showMem').html('');

}



$(document).ready(function(){



	$('.changeMonth').change(function(){

		var t = $(this).attr('timing');

		var dy = $('#'+t+'Day').val();

		var yr = $('#'+t+'Year').val();

		var mn = $('#'+t+'Month').val();

		$.post(baseUrl+"new_task/getMonthDays/"+t+"/"+mn+"/"+dy+"/"+yr,{},function(data){

			$('#'+t+'Day').replaceWith(data);

		});

	});



	$('.enterCal').click(function(){

		var t = $(this).attr('timing');

		var d = $('#'+t+'Day').val();

		var y = $('#'+t+'Year').val();

		var mins = $('#'+t+'Mins').val();

		var h = $('#'+t+'Hours').val();

		var m = $('#'+t+'Month').val();

		

		$('#'+t+'time').val(y+'-'+m+'-'+d+' '+h+':'+mins);

	});

	

	$('#popupControls').live('click',function(e){

		e.preventDefault();

		//var id = $('#popupInner >.showMem1').attr('id');

		if(curId!=''){

			$('#showMem').html($('#popupInner').html());

			$('#showMem > #popupTitleBar').replaceWith('');

			$('#popupInner').html(popWin);

			//$('#popupFrame').attr('src','');

			curId = '';

		}

		initPopUp();

		hidePopWin(false);

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

//Manoj: code for select all when assigned task to users

function selectAllCheck(obj){
		
		if($(obj).attr('class')=='allcheck'){
		
			$(obj).removeClass('allcheck');
			$(obj).addClass('allUncheck');
			$(".users").attr('checked',true);
			$(".users").prop('checked',true);
			$(obj).attr('checked',true);
		}
		else if($(obj).attr('class')=='allUncheck'){
			
			$(obj).removeClass('allUncheck');
			$(obj).addClass('allcheck');
			$(".users").attr('checked',false);
			$(obj).attr('checked',false);
		}
}


//Manoj: code end

</script>

