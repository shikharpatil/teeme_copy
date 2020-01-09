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

/*function compareDates (dat1, dat2) {



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
*/




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

<form class="formTask" name="form3<?php echo $arrVal['leafId'];?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $arrVal['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">





<?php 



$editStartTimeStyle = '';

$editEndTimeStyle = '';

$editStartCalVisible = '';

$editEndCalVisible = '';

$editStartCheck = 'checked';

$editEndCheck = 'checked';

//$editStartTime = $arrVal['editStarttime'];
$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($arrVal['editStarttime'], 'd-m-Y H:i');




//echo "<li>nodeId= " .$arrVal['nodeId'];

$taskUsers = $this->task_db_manager->getTaskUsers ($arrVal['nodeId'],2);

$checksucc 				= $this->task_db_manager->checkSuccessors($arrVal['nodeId']);

$arrStartTime 			= explode('-',$arrVal['starttime']);

$arrEndTime 			= explode('-',$arrVal['endtime']);

$arrNodeTaskUsers 		= $this->task_db_manager->getTaskUsers($arrVal['nodeId'], 2);

$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

//echo "<li>taskusers= "; print_r ($taskUsers);

if($arrStartTime[0] == '00')

{
	//Manoj: Changed the date format Y-m-d to d-m-y
	$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

	$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';

	$editStartCalVisible = 'style="display:none"';

	$editStartCheck 	= '';	

}

//$editEndTime = $arrVal['editEndtime'];
$editEndTime = $this->time_manager->getUserTimeFromGMTTime($arrVal['editEndtime'], 'd-m-Y H:i');

if($arrEndTime[0] == '00')

{
	//Manoj: Changed the date format Y-m-d to d-m-y
	$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

	$editEndTimeStyle 	= ' style="background-color:#CCCCCC; color:#626262;"';

	$editEndCalVisible 	= 'style="display:none"';

	$editEndCheck		= '';	

}

?>


		
		<div class="subTaskMobile" id="labelMobile<?php echo $arrVal['leafId'];?>">
		
		<?php 
		//Manoj: Change label of task and task list
		if(!$checksucc)		
		{
			echo $this->lang->line('txt_Task');
		}
		else
		{
			echo $this->lang->line('txt_Task_Lists');
		}
		//Manoj: code end
		?>:
		
		
		</div>

		 <div class="subTaskMobile fieldsetBottom"><textarea name="edittask<?php echo $arrVal['leafId'];?>" id="edittask<?php echo $arrVal['leafId'];?>"><?php echo stripslashes($arrVal['contents']);?></textarea></div>

	<?php

	if(!$checksucc)

	{
	
	?>

	<div class="subTaskMobile">

    	<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />

        <span style="vertical-align:top"> <?php echo $this->lang->line('txt_Start_Time');?>:</span> 
	</div>
	
		<input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editStartCheck;?>> 
		<input name="starttime" data-field="datetime" class="date-input-start" type="text" id="starttime<?php echo $arrVal['leafId'];?>" readonly value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>  <?php if(empty($editStartTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> >
		<!--Manoj: added curious calendar -->
		<div id="dtBox"></div>	
		
		<!-- Manoj: Changed the date format Y-m-d to d-m-y -->
        <?php /*?><input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editStartCheck;?>> 

    </div>

    <div class="subTaskMobile">

      <?php
		//Manoj: get user time from gmt time
		$editStartTime = $this->time_manager->getUserTimeFromGMTTime($editStartTime, 'd-m-Y H:i');

		$var = explode(' ',$editStartTime);

		$dateVar = explode('-',$var[0]);

		$timeVar = explode(':',$var[1]);

		?>



     <input name="starttime" type="hidden" id="starttime<?php echo $arrVal['leafId'];?>" value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>>

     <!--<span id="calStart<?php echo $arrVal['leafId'];?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrVal['leafId'];?>.starttime,'yyyy-mm-dd hh:ii',this,true)" />-->

     

    

        D&nbsp;<select name="startDay" id="startDay" class="enterCal startCal" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> timing='start' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>
				<!--Manoj changed index no. of datevar-->
                <option <?php echo ($i==$dateVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="startMonth" id="startMonth" class="enterCal changeMonth startCal" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> timing='start' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==$dateVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    Y&nbsp;<select name="startYear" id="startYear" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal changeMonth" timing='start' lid='<?php echo $arrVal['leafId'];?>' style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>
			<!--Manoj changed index no. of datevar-->
			<option <?php echo ($i==$dateVar[2])?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

    </div>

    <div class="subTaskMobile fieldsetBottom">

    H&nbsp;<select name="startHours" id="startHours" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal" timing='start' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="startMins" id="startMins" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal" timing='start' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    <?php

	for($i=0;$i<=59;$i++){?>

    	<option <?php echo ($i==$timeVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select><?php */?>

     

      

      

      <div class="subTaskMobile">

		<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" />  
		<span style="vertical-align:top"><?php echo $this->lang->line('txt_End_Time');?>:</span>
	 </div>
		
		<input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editEndCheck;?>>
		<input name="endtime" data-field="datetime" class="date-input-end" type="text" id="endtime<?php echo $arrVal['leafId'];?>" readonly value="<?php echo $editEndTime;?>" <?php echo $editEndTimeStyle;?> <?php if(empty($editEndTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> >
		
		<!-- Manoj: Changed the date format Y-m-d to d-m-y -->
        <?php /*?><input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editEndCheck;?>>

        </div>

        <div class="subTaskMobile">

         <?php
		//Manoj: get user time from gmt time
		$editEndTime = $this->time_manager->getUserTimeFromGMTTime($editEndTime, 'd-m-Y H:i');

        $var = explode(' ',$editEndTime);

		$dateVar = explode('-',$var[0]);

		$timeVar = explode(':',$var[1]);

	   ?> 	

        <input name="endtime" type="hidden" id="endtime<?php echo $arrVal['leafId'];?>" value="<?php echo $editEndTime;?>" <?php echo $editEndTimeStyle;?>>

            

         D&nbsp;<select name="endDay" id="endDay" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>
				<!--Manoj changed index no. of datevar-->
                <option <?php echo ($i==$dateVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="endMonth" id="endMonth" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal changeMonth" timing='end' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==$dateVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    Y&nbsp;<select name="endYear" id="endYear" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal changeMonth" timing='end' lid='<?php echo $arrVal['leafId'];?>' style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>
			<!--Manoj changed index no. of datevar-->
			<option <?php echo ($i==$dateVar[2])?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

        

        </div>

<div class="subTaskMobile fieldsetBottom">

    H&nbsp;<select name="endHours" id="endHours" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="endMins" id="endMins" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' lid='<?php echo $arrVal['leafId'];?>' style="width:44px;">

    <?php

	for($i=0;$i<=59;$i++){?>

    	<option <?php echo ($i==$timeVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select><?php */?>

        

        

</div>

   <?php

	if ($editStartCheck || $editEndCheck)

	{

	?>	

    <div id="mark_calender<?php echo $arrVal['leafId'];?>" style="border-bottom:1px dotted gray;padding-bottom:5px;">

    <?php

	}

	else

	{

	?>

    <div id="mark_calender<?php echo $arrVal['leafId'];?>" style="display:none;" class="fieldsetBottom">

    <?php

	}

	?>	

		<div class="subTaskMobile">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

		</div>

	    <div class="subTaskMobile">

			<input type="radio" name="calendarStatus" value="Yes" <?php if($arrVal['viewCalendar'] == 1) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" <?php if($arrVal['viewCalendar'] == 0) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_No');?> 

		</div>

     </div>







<div class="subTaskMobile showMem fieldsetBottom" style="display:none;" id="showMem<?php echo $nodeId;?>">

            	<input type="text" id="showMembersEditTask<?php echo $arrVal['nodeId'];?>" name="showMembersEditTask<?php echo $arrVal['nodeId'];?>" onKeyUp="showFilteredMembersEditTask(<?php echo $arrVal['nodeId'];?>)"/>   			

			

    		<div id="showMemEditSubTask<?php echo $nodeId ;?>" class="showMem1">

            	        

			<?php	

			$names = '';

			if (in_array($_SESSION['userId'],$taskUsers)) { $names = $this->lang->line('txt_Me').',';}

			

			if($workSpaceId==0)

			{	

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onClick="selectAllCheck(this)"/> 
					<span><?php echo $this->lang->line('txt_All');?></span><br />

                    

			<?php	

					

                }	?>
	
		<!--Manoj: code paste here for txt_me-->
		<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" class="users" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
		
		<span><?php echo $this->lang->line('txt_Me');?></span> <br />  
		<?php
				//print_r($workSpaceMembers);						

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?> /> 

						<span><?php echo $arrData['tagName'];?></span><br />

			<?php

						if (in_array($arrData['userId'],$taskUsers)) {$names .= $arrData['tagName'].','; }

						

					}

				}

			}

			else

			{

			?>



            	<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onClick="selectAllCheck(this)"/> 
				<?php echo $this->lang->line('txt_All');?><br />
				<!--Manoj: code paste here for txt_me-->
				<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" class="users" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
		
				<span><?php echo $this->lang->line('txt_Me');?></span> <br />  

            <?php

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 

						<span><?php echo $arrData['tagName'];?></span><br />  

			<?php

						if (in_array($arrData['userId'],$taskUsers)) {$names .= $arrData['tagName'].','; }

					}

				}	

			}

			$names = substr($names,0,-1);

			?>

    		</div>

            <button class="button01 assignToBtn" onClick="assignTo(<?php echo $nodeId;?>);">Ok</button> 

        </div>



<div class="subTaskMobile fieldsetBottom"><?php echo $this->lang->line('txt_Assigned_To');?>:<a href="javascript:void(0);" onClick="popup(<?php echo $nodeId;?>)">Click to assign</a><div id="namesDiv<?php echo $nodeId;?>"><?php echo $names;?></div></div>

	

     

     <div class="subTaskMobile">

		

	<?php echo $this->lang->line('txt_Completion_Status');?>:

    

	<select name="completionStatus" style="width:30%">

    	<option value="0" <?php echo ($nodeTaskStatus == 0)?"SELECTED":"";?>>0%</option>

        <option value="1" <?php echo ($nodeTaskStatus == 1)?"SELECTED":"";?>>25%</option>

        <option value="2" <?php echo ($nodeTaskStatus == 2)?"SELECTED":"";?>>50%</option>

        <option value="3" <?php echo ($nodeTaskStatus == 3)?"SELECTED":"";?>>75%</option>

        <option value="4" <?php echo ($nodeTaskStatus == 4)?"SELECTED":"";?>>Completed</option>

    </select>

	</div>

     

    

	<?php

		

	}

	?>	<div class="subTaskMobile">

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

         	<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Save');?>" onClick="validate_title_edit_task('edittask<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['leafId']; ?>,<?php echo $arrVal['nodeId'];?>);" class="button01"> 

		<?php  /*	<input type="button" name="Replybutton1" value="Cancel" onClick="hideTaskViewEditor(<?php echo $position;?>,<?php echo $arrVal['nodeId']; ?>);" class="button01">

		    */

		?>	

		<input style="float:left;" type="button" name="Replybutton1" value="Cancel" onClick="hideTaskView1New(<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);" class="button01">

            <?php

			}

			?>
			
			<span id="audioRecordBox"><div style="float:left;margin-top:5px;margin-left:0%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $arrVal['nodeId'];?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $arrVal['nodeId'];?>" style="display:none; margin-left:0%; margin-top:0%; float:left;"></div></span>

        </div>    

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
			
			

             

</form>

<!--code paste here for task users -->
<script>

function showFilteredMembersEditTask(nodeId)

{

	//Manoj: commented tomatch code for search issue on popup mask 
	//var toMatch = document.getElementById('showMembersEditTask'+nodeId).value;
	var toMatch = $("#popupInner #showMembersEditTask"+nodeId).val();


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

					val +=  '<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onclick="selectAllCheck(this)" /><?php echo $this->lang->line('txt_All');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

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

				val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				//Manoj: code for task user assign search issue 
				//document.getElementById('showMemEditTask'+nodeId).innerHTML = val;
				$("#popupInner #showMemEditSubTask"+nodeId).html(val);

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

				val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				//Manoj: code for task user assign search issue 
				//document.getElementById('showMemEditTask'+nodeId).innerHTML = val;
				$("#popupInner #showMemEditSubTask"+nodeId).html(val);

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



chnage_textarea_to_editor('edittask<?php echo $arrVal['leafId'];?>','simple');



var popWin = '';

var curId = '';

function popup(id)

{

	initPopUp();

	showPopWin('your_url_here.html',480, 340,'');

	popWin = $('#popupInner').html();

	curId = id;

	$('#popupFrame').replaceWith($('#showMem'+id).html());

	//Manoj: commented for Assign users popup cancel issue 
	//$('#showMem'+id).html('');

}



function assignTo(id){

	$('#showMem'+id).html($('#popupInner').html());

	//$('#showMem'+id).html($('#popupInner').not('#popupTitleBar').html());

	$('#showMem'+id+' > #popupTitleBar').replaceWith('');

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

			$('#showMem'+id+' > .showMem1 > input[value="'+n+'"]').attr('checked','checked');

			a = a+$(this).next().html();

		}

		else{

			$('#showMem'+id+' > .showMem1 > input[value="'+n+'"]').removeAttr('checked');

		}

	});

	/*if(x==0 && a!='')

	{

		$('#showMem'+id+' > .showMem1 > input[value="<?php echo $_SESSION['userId'];?>"]').removeAttr('checked');

	}

	else if(x==0 && a==''){

		a='Me';

		$('#showMem'+id+' > .showMem1 > input[value="<?php echo $_SESSION['userId'];?>"]').attr('checked','checked');

	}*/

	$('#namesDiv'+id).html(a);

	$('#popupInner').html(popWin);

	$('#popupFrame').attr('src','');

	curId='';

	initPopUp();

	hidePopWin(false);

}



$(document).ready(function(){

	//	Manoj: Added date time picker for mobile
    $("#dtBox").DateTimePicker();

	$('.changeMonth').change(function(){

		var t = $(this).attr('timing');

		var dy = $('#'+t+'Day').val();

		var yr = $('#'+t+'Year').val();

		var mn = $('#'+t+'Month').val();

		$.post(baseUrl+"new_task/getMonthDays/"+t+"/"+mn+"/"+dy+"/"+yr,{},function(data){

			$('#'+t+'Day').replaceWith(data);

		});

	});


	//Manoj: Changed method click to change 
	$('.enterCal').change(function(){

		var t = $(this).attr('timing');

		var d = $('#'+t+'Day').val();

		var y = $('#'+t+'Year').val();

		var mins = $('#'+t+'Mins').val();

		var h = $('#'+t+'Hours').val();

		var m = $('#'+t+'Month').val();

		
		//Manoj: Change date format (Y-m-d to d-m-y)
		
		$('#'+t+'time'+$(this).attr('lid')).val(d+'-'+m+'-'+y+' '+h+':'+mins);

	});

	

	

	/*$('#popupControls').live('click',function(e){

		e.preventDefault();

		//var id = $('#popupInner >.showMem1').attr('id');

		if(curId!=''){

			$('#showMem'+curId).html($('#popupInner').html());

			$('#showMem'+curId+' > #popupTitleBar').replaceWith('');

			$('#popupInner').html(popWin);

			//$('#popupFrame').attr('src','');

			curId = '';

		}

		initPopUp();

		hidePopWin(false);

	});*/

});


function calStartCheck(thisVal, pos, formName, currentTime)

{	
	//alert ('pos= ' +formName);

	//var callStartId = 'calStart'+pos;
	
	//	Manoj: Added date time picker for mobile
     $("#dtBox").DateTimePicker();


	if(thisVal.checked == true)

	{			
		formName.starttime.style.color = "#000000";	

		formName.starttime.style.backgroundColor = "#FFFFFF";

			
		//document.getElementById('mark_calender').style.display = "";
		
		//Manoj: Make disabled false 
		//$('.startCal').attr('disabled', false);
		$( "#starttime<?php echo $arrVal['leafId'];?>" ).prop( "disabled", false );

	}

	else

	{		
		$( "#starttime<?php echo $arrVal['leafId'];?>" ).prop( "disabled", true );
		
		formName.starttime.style.color = "#626262";	

		formName.starttime.style.backgroundColor = "#CCCCCC";	

		formName.starttime.value = currentTime;

		

		if (formName.endCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

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
		
		//document.getElementById('mark_calender').style.display = "";
		
		//$('.endCal').attr('disabled', false);

		
		$( "#endtime<?php echo $arrVal['leafId'];?>" ).prop( "disabled", false );
	}

	else

	{		
		$( "#endtime<?php echo $arrVal['leafId'];?>" ).prop( "disabled", true );

		formName.endtime.style.color	 = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

		formName.endtime.value = currentTime;

		if (formName.startCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

	}



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