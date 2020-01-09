<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Teeme</title>
		<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
		<!-- <link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" /> -->
	</head>
	<body>
		<div id="loader0">
			<div id='overlay' style="margin-left: 8%"><br>
				<img src='<?php echo base_url();?>/images/ajax-loader-add.gif'><br>
			</div>
		</div>
		<div class="taskFormContainer" id="formContainerSeed<?php echo $treeId; ?>"  name="formContainer<?php echo $treeId; ?>">	
			<form name="formAddTask<?php echo $position;?>" id="formAddTask<?php echo $position;?>" method="post" >

				<table width="87%" border="0" cellspacing="2" cellpadding="2" style="margin-left:8%; ">
					<tr>
					    <td valign="top" style="margin:0px; padding:0px;" class="taskTd" >

							<?php echo $this->lang->line('txt_Task');?>: 
						</td>
					    <td style="width:80%">
					    	<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
							<div class="talkform<?php echo $nodeId;?> taskEditorWidth handCursor">
								<textarea name="newTask<?php echo $nodeId;?>" id="newTask<?php echo $nodeId;?>" rows="5" cols="40"></textarea>
							</div>
						</td>
					</tr>

					<tr>
					    <td style="margin:0px; padding:0px; " > 
							<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
							<span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span> 
						</td>

						<td style="margin:0px; padding:0px; " >

							<!--Commented by Dashrath- comment old code and new code for start time start 9:00-->
							<!-- <input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
							
							<input name="starttime" type="text" style="background-color:#CCCCCC;color:#626262;" class="sdp" id="starttime<?php echo $this->uri->segment(9);?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>"  readonly>   -->


							<input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 09:00')">
							
							<input name="starttime" type="text" style="background-color:#CCCCCC;color:#626262;" class="sdp" id="starttime<?php echo $this->uri->segment(9);?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 09:00"  readonly>  
						</td>
					</tr>

					<tr>
						<td style="margin:0px; padding:0px; " >

							<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 

							<span style="vertical-align:top" ><?php echo $this->lang->line('txt_End_Time');?>:</span>

						</td>

						<td style="margin:0px; padding:0px; " >

							<!--Commented by Dashrath- comment old code and new code for end time start 17:00-->
							<!-- <input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
							
							<input name="endtime" type="text" style="background-color:#CCCCCC;color:#626262;" id="endtime<?php echo $this->uri->segment(9);?>" class="edp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>" readonly> -->

							<input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 17:00')">
							
							<input name="endtime" type="text" style="background-color:#CCCCCC;color:#626262;" id="endtime<?php echo $this->uri->segment(9);?>" class="edp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 17:00" readonly>
					    </td>

					</tr> 

					<tr id="mark_calender<?php echo $position;?>" style="display:none;">

						<td valign="top"  style="margin:0px ; padding:0px;" width="16%">
							<?php echo $this->lang->line('txt_Mark_to_calendar');?>:
						</td>

						<td valign="top" style="margin:0px; padding:0px">&nbsp;

							<!--Commented by Dashrath- comment old code and add new code below for by default show in calendar-->
							<!-- <input type="radio" name="calendarStatus" value="Yes">
							<?php echo $this->lang->line('txt_Yes');?> &nbsp;
							<input name="calendarStatus" type="radio" value="No" checked>
							<?php echo $this->lang->line('txt_No');?>  -->
							<!--Dashrath- comment code end-->

							<!--Added by Dashrath- By default mark to calendar (Yes) checked-->
							<input type="radio" name="calendarStatus" value="Yes" checked>
							<?php echo $this->lang->line('txt_Yes');?> &nbsp;
							<input name="calendarStatus" type="radio" value="No">
							<?php echo $this->lang->line('txt_No');?> 
							<!--Dashrath- code end-->

						</td>	   

					</tr>

				    <tr>
				    	<td valign="top" style="margin:0px ; padding:0px;"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

						<td align="left">
							<input type="text" id="showMembersAddTask<?php echo $nodeId;?>" name="showMembersAddTask<?php echo $nodeId;?>" onKeyUp="showFilteredMembersAddTask(<?php echo $nodeId;?>)"/>                    
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
				            		<input type="checkbox" name="taskUsers[]" class="allcheck" value="0"/> <?php echo $this->lang->line('txt_All');?><br />
								<?php	
				                }

								foreach($workSpaceMembers as $arrData)
								{

									if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
									{						
										$members .='<input type="checkbox" name="taskUsers[]" class="users" value="'.$arrData['userId'].'"/>'.$arrData['tagName'].'<br />';
									}
								}
							}
							else
							{
							?>
				            	<input type="checkbox" name="taskUsers[]" value="0" class="allcheck"/> <?php echo $this->lang->line('txt_All');?><br />

				            	<?php

								foreach($workSpaceMembers as $arrData)
								{
									if($_SESSION['userId'] != $arrData['userId'])
									{						
										$members .='<input type="checkbox" name="taskUsers[]" class="users" value="'.$arrData['userId'].'"/> 

										'.$arrData['tagName'].'<br />';
									}

								}
							}

							?>
				            <div id="showMemAddTask<?php echo $nodeId;?>" style="height:100px; width:300px;overflow:auto;" class="usersList">

				            	<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/> <?php echo $this->lang->line('txt_Me');?><br />

				            	<?php echo $members;?>
				        	</div>
						</td>

					</tr>

					<tr>
						<td align="left" style="margin:0px ; padding:0px;">

						<?php echo $this->lang->line('txt_Completion_Status');?>:</td>
						<td align="left" >
							<input type="radio" name="completionStatus" value="0" checked="checked" >0% &nbsp;&nbsp;&nbsp; 

							<input type="radio" name="completionStatus" value="1" >25% &nbsp;&nbsp;&nbsp;

							<input type="radio" name="completionStatus" value="2" >50%	&nbsp;&nbsp;&nbsp;

							<input type="radio" name="completionStatus" value="3" >75%	&nbsp;&nbsp;&nbsp;

							<input type="radio" name="completionStatus" value="4" >Completed	&nbsp;&nbsp;

						</td>

					</tr>

					<tr>
						<td>&nbsp;</td>
						<td align="left" style="margin:0px ; padding:0px;">
							<div id="loader2"></div>
							<!--Manoj: change done to add -->
					        <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Add');?>" onClick="validate_task('newTask<?php echo $nodeId;?>',<?php echo $treeId; ?>,document.formAddTask<?php echo $position;?>);" class="button01">

					        <!--Commented by Dashrath- comment old code and add new code below-->
							<!-- <input style="float:left;" type="reset" name="Replybutton1" value="Cancel" onClick="hideTaskView1New_newTask('<?php echo $nodeId;?>');" class="button01"> -->

							<!--Added by Dashrath- change onclick function for add task popup close-->
							<input style="float:left;" type="reset" name="Replybutton1" value="Cancel" onClick="closeAddNewTaskPopup('<?php echo $nodeId;?>');" class="button01">
							<!--Dashrath- code end-->
							

					    	<input name="reply" type="hidden" id="reply" value="1">

							<input name="editorname1" type="hidden" value="newTask<?php echo $nodeId;?>">

							<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

							<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

							<input type="hidden" name="titleStatus" value="0" id="titleStatus">

							<input name="nodeId" type="hidden" value="<?php echo $nodeId;?>">

							<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

							<input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

							<input name="parent" type="hidden" id="parent" value="0">
							
							<div id="audioRecordBox"><div style="float:left;margin-top:0.4%; margin-left:1%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'<?php echo $nodeId;?>');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record<?php echo $nodeId;?>" style="display:none; margin-left:2%; margin-top:0%; float:left;"></div></div>


							
						</td>
					</tr>
				</table>
			</form>
		</div>
		<?php 
		$this->load->view('common/foot_new_task.php');
		?>
	</body>
</html> 

<script>

chnage_textarea_to_editor('newTask<?php echo $nodeId;?>','simple');

//tinymce.execCommand('mceFocus',false,'newTask<?php echo $nodeId;?>');

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



/*function calStartCheck(thisVal, pos, formName, currentTime)
{
	//alert ('pos= ' +formName);
	var callStartId = 'calStart'+pos;
	if(thisVal.checked == true)
	{			
		document.getElementById(callStartId).style.display = "";	
		formName.starttime.style.color = "#000000";	
		formName.starttime.style.backgroundColor = "#FFFFFF";
		document.getElementById('mark_calender'+pos).style.display = "";
	}
	else
	{		
		document.getElementById(callStartId).style.display = 'none';
		formName.starttime.style.color = "#626262";	
		formName.starttime.style.backgroundColor = "#CCCCCC";	
		formName.starttime.value = currentTime;
		if(document.getElementById('yearDropDown'))
		{
			closeCalendar(); //Deepti : To close the calender
		}

		if (formName.endCheck.checked!=true)
		{
			document.getElementById('mark_calender'+pos).style.display = "none";
		}
	}
}
*/

function showFilteredMembersAddTask(nodeId)
{
	//alert (document.getElementById('showMembersEditTask').value);
	var toMatch = document.getElementById('showMembersAddTask'+nodeId).value;
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
				val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

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
						val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php //if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

						document.getElementById('showMemAddTask'+nodeId).innerHTML = val;
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
						val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php //if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

						document.getElementById('showMemAddTask'+nodeId).innerHTML = val;
					}
					<?php
				}
			}
		}
    	?>
	}
}

window.onload = function () {
  document.getElementById("loader0").style.display="none"; 
}
</script>