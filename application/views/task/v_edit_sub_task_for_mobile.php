<?php  //echo "test=- ".$nodeId;

				$editStartTimeStyle = '';

				$editEndTimeStyle = '';

				$editStartCalVisible = '';

				$editEndCalVisible = '';

				$editStartCheck = 'checked';

				$editEndCheck = 'checked';

				$arrStartTime 			= explode('-',$start_time);
				
				$arrEndTime 			= explode('-',$end_time);

				$arrStartTime 			= explode('-',$start_time);
				
				$arrEndTime 			= explode('-',$end_time);

				 //$editStartTime = $start_time; 
				 $editStartTime = $this->time_manager->getUserTimeFromGMTTime($start_time, 'd-m-Y H:i');
				
				

				//echo "ss".$editStartTime[0];

				

				

				$taskUsers = $this->task_db_manager->getTaskUsers($nodeId, 2);
				
				//print_r($taskUsers);die;

				if($arrStartTime[0] == '00')

				{ 

					//$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');
					//Manoj: added for subtask start time date format 
					$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

					$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';

					$editStartCalVisible = 'style="display:none"';

					$editStartCheck 	= '';	

				}

				

				//$editEndTime = $end_time;

				$editEndTime = $this->time_manager->getUserTimeFromGMTTime($end_time, 'd-m-Y H:i');

				if($arrEndTime[0] == '00')

				{

					//$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');
					//Manoj: added for subtask end time date format 
					$editEndTime =	$this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');
					
					$editEndTimeStyle 	= ' style="background-color:#CCCCCC; color:#626262;"';

					$editEndCalVisible 	= 'style="display:none"';

					$editEndCheck		= '';	

				}

				?>

<?php

        /*

		Comment this code after implementing new UI.

		if (!empty($_SESSION['errorMsg']))

		{

			echo '<b>'.$_SESSION['errorMsg'].'</b>'; 	

			$_SESSION['errorMsg'] = '';

		}

		*/

		

		?>				

<div style="margin-left:5%;" >		

<form class="formTask" name="form3<?php echo $leafId;?>" id="form3<?php echo $leafId;?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $leafId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">





		<div class="subTaskMobile" id="divedittast<?php echo $leafId;?>" ><?php echo "Sub-Task";?>:</div>

		

		<div class="subTaskMobile fieldsetBottom">

            <textarea id="edittask<?php echo $leafId;?>"  name="edittask<?php echo $leafId;?>" ><?php echo stripslashes($content->contents); ?></textarea>

		</div>

		<div style="clear:both"></div>

	

	<?php

	if(!$checksucc)

	{		

	?>

		<div class="subTaskMobile">
			
        	<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
			<span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span><br />
			
		
			
			<input type="checkbox" name="startCheck" id="startCheck"  onClick="calStartCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editStartCheck;?>>
			<input name="starttime" data-field="datetime" class="date-input-start" type="text" id="starttime<?php echo $leafId;?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>  <?php if(empty($editStartTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly  >
			
			<div id="dtBox"></div>	
			

        	<?php /*?><input type="checkbox" name="startCheck" id="startCheck"  onClick="calStartCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editStartCheck;?>>

        </div>

		<div class="subTaskMobile">

        	<!--<input name="starttime" type="text" id="starttime<?php echo $leafId;?>" readonly="readonly"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>>

            <span id="calStart<?php echo $leafId;?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $leafId;?>.starttime<?php echo $leafId;?>,'yyyy-mm-dd hh:ii',this,true)" /></span>-->

            

		</div>

        

        <div class="subTaskMobile">

        <?php

		$var = explode(' ',$editStartTime);

		$dateVar = explode('-',$var[0]);

		$timeVar = explode(':',$var[1]);

		?>

    <input name="starttime" type="hidden" id="starttime" value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>>



   

        D&nbsp;<select name="startDay" id="startDay" class="enterCal startCal" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> timing='start' style="width:44px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==$dateVar[2])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="startMonth" id="startMonth" class="enterCal changeMonth startCal" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> timing='start' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==$dateVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    Y&nbsp;<select name="startYear" id="startYear" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal changeMonth" timing='start'  style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>

			<option <?php echo ($i==$dateVar[0])?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

    </div>

    <div class="subTaskMobile fieldsetBottom">

    H&nbsp;<select name="startHours" id="startHours" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal" timing='start' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="startMins" id="startMins" <?php if($editStartCheck==''){?> disabled="disabled"<?php }?> class="enterCal startCal" timing='start' style="width:44px;">

    <?php

	for($i=0;$i<=59;$i++){?>

    	<option <?php echo ($i==$timeVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select><?php */?>

    

        </div>

		<div class="subTaskMobile">

        	<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /><span style="vertical-align:top" ><?php echo $this->lang->line('txt_End_Time');?>:</span><br />
		
		
			<input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editEndCheck;?>>
			<input name="endtime" type="text" id="endtime<?php echo $leafId;?>" data-field="datetime" class="date-input-end"  value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?> <?php if(empty($editEndTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly >

        	<?php /*?><input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editEndCheck;?>>

        </div>

		<div class="subTaskMobile">

       <?php

	   $var = explode(' ',$editEndTime);

		$dateVar = explode('-',$var[0]);

		$timeVar = explode(':',$var[1]);

	   ?> 	

            

            <input name="endtime" type="hidden" id="endtime" value="<?php echo $editEndTime;?>">

		

         D&nbsp;<select name="endDay" id="endDay" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' style="width:44px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==$dateVar[2])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="endMonth" id="endMonth" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal changeMonth" timing='end' style="width:44px;">

    	<?php

		for($i=1;$i<=12;$i++){?>

        	<option <?php echo ($i==$dateVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

        <?php

		}?>

    </select>

    Y&nbsp;<select name="endYear" id="endYear" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal changeMonth" timing='end' style="width:52px;">

    	<?php

		$yr = date("Y",strtotime("last year"));

		for($i=$yr-1;$i<=$yr+20;$i++){?>

			<option <?php echo ($i==$dateVar[0])?"SELECTED":"";?>><?php echo $i;?></option>

		<?php

		}?>

    </select>

        

        </div>

<div class="subTaskMobile fieldsetBottom" >

    H&nbsp;<select name="endHours" id="endHours" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' style="width:44px;">

    <?php

	for($i=0;$i<=23;$i++){?>

    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="endMins" id="endMins" <?php if($editEndCheck==''){?> disabled="disabled"<?php }?> class="enterCal endCal" timing='end' style="width:44px;">

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

    	<div id="mark_calender<?php echo $leafId;?>">

    <?php

	}

	else

	{

	?>

		<div id="mark_calender<?php echo $leafId;?>" style="display:none;">

	<?php

    }

	?>

			<div class="subTaskMobile"><?php echo $this->lang->line('txt_Mark_to_calendar');?>:</div>

            <div class="subTaskMobile fieldsetBottom">

				&nbsp;<input type="radio" name="calendarStatus" value="Yes" <?php if($calendarStatus == 1) { echo 'checked'; }?>>

				<?php echo $this->lang->line('txt_Yes');?> &nbsp;

				<input name="calendarStatus" type="radio" value="No" <?php if($calendarStatus == 0) { echo 'checked'; }?>>

				<?php echo $this->lang->line('txt_No');?> 

			</div>

    

	</div>

	<div class="clr"></div>

			

			<div class="subTaskMobile showMem" style="display:none;" id="showMem<?php echo $nodeId;?>">

            	<input type="text" id="showMembersEditSubTask<?php echo $nodeId;?>" name="showMembersEditSubTask<?php echo $nodeId;?>" onKeyUp="showFilteredMembersEditSubTask(<?php echo $nodeId;?>)"/>                    

   			

			

    		<div id="showMemEditSubTask<?php echo $nodeId ;?>" class="showMem1">

                 

			<?php	

			$names = '';

			if (in_array($_SESSION['userId'],$taskUsers)) { $names = $this->lang->line('txt_Me').',';}

			

			if($workSpaceId==0)

			{	

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onclick="selectAllCheck(this)"/> 
					<span><?php echo $this->lang->line('txt_All');?></span><br />

                    

			<?php	

					

                }	

				//print_r($workSpaceMembers);	
				?>
				<!--Manoj: code paste here for txt_me-->
				<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
				<span><?php echo $this->lang->line('txt_Me');?></span><br /> 
				<?php
									

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 

						<span><?php echo $arrData['tagName'];?></span><br />

			<?php

						if (in_array($arrData['userId'],$taskUsers)) {$names .= $arrData['tagName'].','; }

						

					}

				}

			}

			else

			{

			?>



            	<input type="checkbox" name="taskUsers[]" value="0" class="allcheck" onclick="selectAllCheck(this)"/> 
				<?php echo $this->lang->line('txt_All');?><br />
				<!--Manoj: code paste here for txt_me-->
				<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
				<span><?php echo $this->lang->line('txt_Me');?></span><br /> 

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

            <button class="button01 assignToBtn" onclick="assignTo(<?php echo $nodeId;?>);">Ok</button> 

        </div>

        <div class="subTaskMobile"><?php echo $this->lang->line('txt_Assigned_To');?>:<a href="javascript:void(0);" onclick="popup(<?php echo $nodeId;?>)">Click to assign</a><div id="namesDiv<?php echo $nodeId;?>"><?php echo $names;?></div></div>

		<div class="subTaskMobile"><?php echo $this->lang->line('txt_Completion_Status');?>:

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

	?>

			<div class="subTaskMobile">
			
			<div id="loaderImage"></div>
				<!--Manoj: change done to add -->
				<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Save'); //$this->lang->line('txt_Done');?>" onClick="validateSubTaskEdit11('edittask<?php echo $leafId;?>',document.form3<?php echo $leafId;?>,<?php echo $leafId;?>,<?php echo $nodeId; ?>);" class="button01"> 

				<?php /*

				<input type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="edit_Cancel11(<?php echo $leafId;?>,<?php echo $nodeId;?>);" class="button01">

				 */?>

				<input style="float:left;" type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New(<?php echo $leafId;?>,<?php echo $nodeId;?>);" class="button01">

		        <input name="reply" type="hidden" id="reply" value="1">

				<input name="editorname1" type="hidden" value="edittask<?php echo $leafId;?>">

				<input name="nodeId" type="hidden"  value="<?php echo $nodeId;?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="taskId" value="<?php echo $nodeId;?>"> 

				<input type="hidden" name="editStatus" value="0" id="editStatus">	

                <input type="hidden" name="isSubTask" value="1" id="isSubTask">	

				<input type="hidden" name="leafId" value="<?php echo $leafId;?>" id="leafId">

				<input type="hidden" name="selNodeId" value="<?php echo $selNodeId;?>" id="selNodeId">
				

				<div id="audioRecordBox"><div style="float:left;margin-top:5px"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $nodeId;?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $nodeId;?>" style="display:none; margin-left:0%; margin-top:0%; float:left;"></div></div>

			</div>

</form>

</div>

<script>

function showFilteredMembersEditSubTask(nodeId)

{
	//Manoj: commented tomatch code for search issue on popup mask 
	//var toMatch = document.getElementById('showMembersEditSubTask'+nodeId).value;
	var toMatch = $("#popupInner #showMembersEditSubTask"+nodeId).val();

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

					val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

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
				//document.getElementById('showMemEditSubTask'+nodeId).innerHTML = val;
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
				//document.getElementById('showMemEditSubTask'+nodeId).innerHTML = val;
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

<script>

chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');

set_sub_task_content(<?php echo $leafId;?>);



/*function calStartCheck(thisVal)

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

}
*/
$(document).ready(function(){

	//	Manoj: Added date time picker for mobile
    $("#dtBox").DateTimePicker();
});

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
		$( "#starttime<?php echo $leafId;?>" ).prop( "disabled", false );

	}

	else

	{		

		$( "#starttime<?php echo $leafId;?>" ).prop( "disabled", true );

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
		$( "#endtime<?php echo $leafId;?>" ).prop( "disabled", false );
		

	}

	else

	{		
		$( "#endtime<?php echo $leafId;?>" ).prop( "disabled", true );

		formName.endtime.style.color	 = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

		formName.endtime.value = currentTime;

		if (formName.startCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

	}

	


}



function set_sub_task_content(leafId)

{



xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+leafId;

				

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

							//alert ('Nodedetails= ' + nodeDetails);

								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");

									//alert ('leafOrder1= ' + leafOrder1);

									// alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);

									if (arrNode[0]!='onlyContents')

									{

										leafId1=arrNode[1];

										leafId2=arrNode[1];

										//leafOrder1=arrNode[2];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										content=arrNode[4];

									}

									else

									{

										//alert ('contents1= ' + arrNode[1]);

										content=arrNode[1];

										

									}

									

								}

//alert(content);

//editor_code(content,'edittask'+leafId,'divedittask'+leafId);

//chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');



//chnage_textarea_to_editor('edittask<?php //echo $leafId;?>','simple');

	// setValueIntoEditor('edittask<?php echo $leafId;?>','ss');	

}

				}

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);

}				

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

function edit_Cancel11(leafId1, nodeId){

	

	//window.location = url;

	

	location.reload ();

	set_sub_task_content(<?php echo $leafId;?>);

}

function validateSubTaskEdit11(replyDiscussion,formname,leafId,cNodeId){ 

	//alert("sss");

	//document.getElementById('editThis<?php echo $leafId; ?>').style.display='none';

	/*Added by Surbhi IV for checking content */

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

	  //var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData(); 

		var getvalue	= getvaluefromEditor(INSTANCE_NAME); 
		
		$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

		

			 var request1 = $.ajax({

					  url: baseUrl+'new_task/getOldContentByTreeId/'+leafId,

					  type: "POST",

					  //data: 'treeId='+treeId+'&version='+version,

					  data: '',

					  dataType: "html",

					  success:function(result)

					  {

						   

						   

						   /*if(result==getvalue)

						   {

								jAlert("<?php echo $this->lang->line('content_not_changed'); ?>","Alert");

								return false;

						   }

						   else

						   {*//*End of Added by Surbhi IV*/

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');





	//replyDiscussion1=replyDiscussion+'1';

	

	if(getvalue == ''){

		error+='<?php echo $this->lang->line('enter_subtask_title'); ?> \n';

	}

//alert(editStatus);

if(formname.editStatus.value == 0)

	{

					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){

						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

							

							error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';

						}

					}

	}

	if(error==''){

	



		var data_user =$(formname).serialize();

		    var INSTANCE_NAME1 = $("#edittask"+<?php echo $leafId;?>).attr('name');

			//var getvalue1	= CKEDITOR.instances[INSTANCE_NAME1].getData();

			var getvalue1	= getvaluefromEditor(INSTANCE_NAME1);

			 

			var request = $.ajax({

			  url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

			  type: "POST",

			  data: data_user+'&edittask<?php echo $leafId;?>='+encodeURIComponent(getvalue1),

			  dataType: "html",

			  success:function(result){

			                           

									  //tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion); 

									  //CKEDITOR.instances[INSTANCE_NAME].destroy();

									  

			                          $("#divNodeContainer").html(result);
									  
									  //Manoj: froala editor show subtask leaf content on cancel
									  	var subTaskPredecessorVal = $("#subTaskPredecessor"+cNodeId).val();
										$('#expandSubTasks'+subTaskPredecessorVal).hide();
										$('#collapseSubTasks'+subTaskPredecessorVal).show();
										$('.subTasks'+subTaskPredecessorVal).show();
									  //document.getElementById('subTaskLeafContent'+cNodeId).style.display="block";

									  //parent.location.href=parent.location.href;

			                          }

			});

	

		//formname.submit();

	}else{

		alert(error);
		return false;

	}

	/*Added by Surbhi IV for checking content */

						   //}

					   }

					});

				

			    /*End of Added by Surbhi IV*/

	}

</script>

<script>

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



	$('.changeMonth').change(function(){

		var t = $(this).attr('timing');

		var dy = $('#'+t+'Day').val();

		var yr = $('#'+t+'Year').val();

		var mn = $('#'+t+'Month').val();

		$.post(baseUrl+"new_task/getMonthDays/"+t+"/"+mn+"/"+dy+"/"+yr,{},function(data){

			$('#'+t+'Day').replaceWith(data);

		});

	});



	$('.enterCal').change(function(){

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

			$('#showMem'+curId).html($('#popupInner').html());

			$('#showMem'+curId+' > #popupTitleBar').replaceWith('');

			$('#popupInner').html(popWin);

			//$('#popupFrame').attr('src','');

			curId = '';

		}

		initPopUp();

		hidePopWin(false);

	});

});

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

