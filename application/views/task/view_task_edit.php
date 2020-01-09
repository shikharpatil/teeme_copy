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

alert('test');

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

}*/ 





</script>



    	<?php

		/*comment this after implementing new UId

		if (!empty($_SESSION['errorMsg']))

		{

			echo '<b>'.$_SESSION['errorMsg'].'</b>'; 	

			

			

			//$_SESSION['errorMsg'] = '';

		}

		*/

		

		?>
<!--Manoj: code copy from here for task users showFilteredMembersEditTask() -->


</head>

<body>

<form name="form3<?php echo $arrVal['leafId'];?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $arrVal['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">





		<table border="0" cellspacing="6" cellpadding="2" width="87%" style="margin-left:8%;" >

<?php 



$editStartTimeStyle = '';

$editEndTimeStyle = '';

$editStartCalVisible = '';

$editEndCalVisible = '';

$editStartCheck = 'checked';

$editEndCheck = 'checked';

//$editStartTime = $arrVal['editStarttime'];

$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($arrVal['editStarttime'], 'd-m-Y H:i');

//$editEndTime = $arrVal['editEndtime'];

$editEndTime = $this->time_manager->getUserTimeFromGMTTime($arrVal['editEndtime'], 'd-m-Y H:i');

//echo "<li>nodeId= " .$arrVal['nodeId'];

$taskUsers = $this->task_db_manager->getTaskUsers ($arrVal['nodeId'],2);

$checksucc 				= $this->task_db_manager->checkSuccessors($arrVal['nodeId']);

$arrStartTime 			= explode('-',$arrVal['starttime']);

$arrEndTime 			= explode('-',$arrVal['endtime']);

$arrNodeTaskUsers 		= $this->task_db_manager->getTaskUsers($arrVal['nodeId'], 2);

$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

//echo "<li>taskusers= "; print_r ($taskUsers);

//print_r ($arrStartTime);

if($arrStartTime[0] == '00')

{

	$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

	$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262; max-width:20%;"';

	$editStartCalVisible = 'style="display:none"';

	$editStartCheck 	= '';	

}
else
{
	$editStartTimeStyle = '';
}



if($arrEndTime[0] == '00')

{

	$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

	$editEndTimeStyle 	= ' style="background-color:#CCCCCC; color:#626262; max-width:20%;"';

	$editEndCalVisible 	= 'style="display:none"';

	$editEndCheck		= '';	

}
else
{
	$editEndTimeStyle = '';
}
//echo "<li>style= " .$editStartTimeStyle;

/*Added by Dashrath- deleted leaf content blank for show in editor*/
if($arrVal['leafStatus']=='deleted')
{
	$arrVal['contents'] = '';
}
/*Added by Dashrath- code end*/

?>

	<tr>
		<td width="20%"><span style="vertical-align:top"><?php if($checksucc){ echo $this->lang->line('txt_Task_Lists');}else{echo $this->lang->line('txt_Task');}?>:</span></td>
		<td width="80%"> 
		<div class="talkform<?php echo $arrVal['leafId'];?>">
		<textarea name="edittask<?php echo $arrVal['leafId'];?>" id="edittask<?php echo $arrVal['leafId'];?>"><?php echo stripslashes($arrVal['contents']);?></textarea></td>	
		</div>
	</tr>

	<?php

	if(!$checksucc)

	{

		

	?>

	<tr>

		<td style="margin:0px ; padding:0px; white-space:20%;"><img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /><span style="vertical-align:top"> <?php echo $this->lang->line('txt_Start_Time');?>:</span></td>

		<td width="80%">  <input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i'); ?>')" <?php echo $editStartCheck;?>> <input name="starttime" class="sdp" type="text" id="starttime<?php echo $arrVal['leafId'];?>" readonly value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?> <?php if(empty($editStartTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> > </td>



	</tr>

	<tr>

		<td style="margin:0px ; padding:0px;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" />  <span style="vertical-align:top"><?php echo $this->lang->line('txt_End_Time');?>:</span></td>

		<td> <input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editEndCheck;?>><input name="endtime" class="edp" type="text" id="endtime<?php echo $arrVal['leafId'];?>" readonly value="<?php echo $editEndTime;?>" <?php echo $editEndTimeStyle;?> <?php if(empty($editEndTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> ></td>	

	</tr>

   <?php

	if ($editStartCheck || $editEndCheck)

	{

	?>	

    <tr id="mark_calender<?php echo $arrVal['leafId'];?>">

    <?php

	}

	else

	{

	?>

    <tr id="mark_calender<?php echo $arrVal['leafId'];?>" style="display:none;">

    <?php

	}

	?>	

		<td  valign="top" style="margin:0px ; padding:0px;">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

		</td>

	    <td  valign="top"  style="margin:0px; padding:0px;">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes" <?php if($arrVal['viewCalendar'] == 1) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" <?php if($arrVal['viewCalendar'] == 0) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_No');?> 

		</td>	   

	</tr>

<tr>



	<tr>

   	 	<td valign="top" style="margin:0px ; padding:0px;"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

		<td align="left" colspan="2">

			<input type="text" id="showMembersEditTask<?php echo $arrVal['nodeId'];?>" name="showMembersEditTask<?php echo $arrVal['nodeId'];?>" onKeyUp="showFilteredMembersEditTask(<?php echo $arrVal['nodeId'];?>)"/>                    

		</td>               

	</tr>    

    <tr>

    	<td valign="top" style="margin:0px ; padding:0px;">&nbsp;</td>

    	<td valign="top">

    		

        	



            <?php	

			$members='';

			if($workSpaceId==0)

			{	

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" class="allcheck" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

			<?php	

                }							

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

						$members .='<input type="checkbox" name="taskUsers[]" class="users" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$taskUsers))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br />';

			

					}

				}

			}

			else

			{

			?>

            	<input type="checkbox" name="taskUsers[]" class="allcheck" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

            <?php

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

						$members .='<input type="checkbox" name="taskUsers[]" class="users" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$taskUsers))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br />';

					}

				}

			}

			?>

            <div id="showMemEditTask<?php echo $arrVal['nodeId'];?>" style="height:120px; width:300px;overflow:auto;" class="usersList">

            	<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> <?php echo $this->lang->line('txt_Me');?><br />

                <?php echo $members;?>

    		</div> 

		</td>

    </tr> 



<tr>

	<td align="left" style="margin:0px ; padding:0px;">

		

	<?php echo $this->lang->line('txt_Completion_Status');?>:</td>

	<td align="left" >

	<input type="radio" name="completionStatus" value="0" <?php if($nodeTaskStatus == 0) { echo 'checked'; }?>>0% &nbsp;&nbsp;&nbsp; <input type="radio" name="completionStatus" value="1" <?php if($nodeTaskStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeTaskStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeTaskStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeTaskStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;

	</td>

	  </tr>

	<?php

		

	}

	?>	

		<tr>

		<td style="margin:0px ; padding:0px;">&nbsp; </td>

		<td>

        <div id="loaderImage"></div>

        	<?php 

        	if(!$checksucc)

			{

			?>
			<!--Manoj: change done to add -->
         	<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Save'); //$this->lang->line('txt_Done');?>" onClick="validate_dis_edit_task('edittask<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);" class="button01"> <input style="float:left;" type="button" name="Replybutton1" value="Cancel" onClick="hideTaskView1New(<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);" class="button01">
			
			<?php

			}

			else

			{

			?>

         	<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Save');?>" onClick="validate_title_edit_task('edittask<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['leafId']; ?>,<?php echo $arrVal['nodeId'];?>);closeCalendar();" class="button01"> 

		<?php  /*	<input type="button" name="Replybutton1" value="Cancel" onClick="hideTaskViewEditor(<?php echo $position;?>,<?php echo $arrVal['nodeId']; ?>);" class="button01">

		    */

		?>	

		<input style="float:left;" type="button" name="Replybutton1" value="Cancel" onClick="hideTaskView1New(<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);closeCalendar();" class="button01">

            <?php

			}

			?>

            

            <input name="reply" type="hidden" id="reply" value="1">

			<input name="editorname1" type="hidden" value="edittask<?php echo $arrVal['leafId'];?>">

			<input name="nodeId" type="hidden"  value="<?php echo $arrVal['nodeId'];?>">

			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

			<input type="hidden" name="treeId" value="<?php echo $treeId;?>" id="treeId">

			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

			<input type="hidden" name="titleStatus" value="0" id="titleStatus">

			<input type="hidden" name="editStatus" value="<?php echo $editStatus;?>" id="editStatus">

			<input type="hidden" name="urlToGo" value="view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

			<input type="hidden" name="taskId" value="<?php echo $arrVal['nodeId'];?>">

            <input type="hidden" name="position" value="<?php echo $position;?>"> 	
			
			<div id="audioRecordBox"><div style="float:left;margin-top:0.4%; margin-left:1%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $arrVal['nodeId'];?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $arrVal['nodeId'];?>" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>		

		</td>	

	</tr>

</table>

             

</form>

<!--code paste here for task users -->
<script>

function showFilteredMembersEditTask(nodeId)

{



	var toMatch = document.getElementById('showMembersEditTask'+nodeId).value;

	//alert ('toMatch= ' +toMatch);

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

					val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

					//val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

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

				val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMemEditTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

			else

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMemEditTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

</script>
<!--Code paste here end -->

<script>


editorClose ('edittask<?php echo $arrVal['leafId'];?>');
chnage_textarea_to_editor('edittask<?php echo $arrVal['leafId'];?>','simple');



$(function() {

	$("input[type='checkbox']").click(function(){

		if($(this).hasClass('allcheck')){

			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".users").prop( "checked" ,true);

		}

		else if($(this).hasClass('allUncheck')){

			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".users").attr('checked',false);

		}

	});

	

});



</script>

