<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Teeme</title>
		<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
	</head>
	<body>

		<?php

		$editStartTimeStyle = '';

		$editEndTimeStyle = '';

		$editStartCalVisible = '';

		$editEndCalVisible = '';

		$editStartCheck = 'checked';

		$editEndCheck = 'checked';

		$editStartTime = $this->time_manager->getUserTimeFromGMTTime($start_time, 'd-m-Y H:i');
		
		$editEndTime = $this->time_manager->getUserTimeFromGMTTime($end_time, 'd-m-Y H:i');
		
		$arrStartTime 			= explode('-',$start_time);
		
		$arrEndTime 			= explode('-',$end_time);

		$taskUsers = $this->task_db_manager->getTaskUsers($nodeId, 2);

		if($arrStartTime[0] == '00')
		{ 
			/*Commented by Dashrath- comment old code and new code for start time start 9:00*/
			// $editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

			$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y 09:00');

			$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';

			$editStartCalVisible = 'style="display:none"';

			$editStartCheck 	= '';	
		}

		if($arrEndTime[0] == '00')
		{
			/*Commented by Dashrath- comment old code and new code for end time start 17:00*/
			// $editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');

			$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y 17:00');

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

		<div style="margin-left:9%;" >		

			<form name="form3<?php echo $leafId;?>" id="form3<?php echo $leafId;?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $leafId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

				<div style="width:17%; margin-left:0px; margin-top:10px;  float:left;" id="divedittast<?php echo $leafId;?>" ><?php echo "Sub-Task";?>:</div>

				<div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%;float:left;">
					<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
					<div class="talkform<?php echo $leafId;?> taskEditorWidth handCursor">
						<textarea id="edittask<?php echo $leafId;?>"  name="edittask<?php echo $leafId;?>" ><?php echo stripslashes($content->contents); ?></textarea>
					</div>
				</div>

				<div class="clr"></div>

				<?php

				if(!$checksucc)
				{		
				?>
					<div style="width:17%; margin-left:0px; margin-top:10px;  float:left;"><img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /><?php echo $this->lang->line('txt_Start_Time');?>:</div>

					<div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; float:left; margin-top:10px; ">

						<!--Commented by Dashrath- comment old code and new code for start time start 09:00-->
	        			<!-- <input type="checkbox" name="startCheck" id="startCheck"  onClick="calStartCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editStartCheck;?>><input name="starttime" class="sdp" type="text" id="starttime<?php echo $leafId;?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?> <?php if(empty($editStartTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly > -->

	        			<input type="checkbox" name="startCheck" id="startCheck"  onClick="calStartCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y 09:00');?>')" <?php echo $editStartCheck;?>><input name="starttime" class="sdp" type="text" id="starttime<?php echo $leafId;?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?> <?php if(empty($editStartTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly >

					</div>

					<div class="clr"></div>

					<div style="width:17%;margin-top:10px; margin-left:0px; float:left;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /><?php echo $this->lang->line('txt_End_Time');?>:</div>

					<div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%;margin-top:10px; float:left;">

						<!--Commented by Dashrath- comment old code and new code for end time start 17:00-->
	        			<!-- <input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $leafId;?>" class="edp"  value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?> <?php if(empty($editEndTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly > -->

	        			<input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y 17:00');?>')" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $leafId;?>" class="edp"  value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?> <?php if(empty($editEndTimeStyle)==1){ echo 'enabled';} else{echo 'disabled';} ?> readonly >

					</div>

					<div class="clr"></div>

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

						<div style="width:17%; margin-left:0px; margin-top:10px; float:left;"><?php echo $this->lang->line('txt_Mark_to_calendar');?>:</div>

			            <div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; float:left; margin-top:10px;">

							&nbsp;<input type="radio" name="calendarStatus" value="Yes" <?php if($calendarStatus == 1) { echo 'checked'; }?>>

							<?php echo $this->lang->line('txt_Yes');?> &nbsp;

							<input name="calendarStatus" type="radio" value="No" <?php if($calendarStatus == 0) { echo 'checked'; }?>>

							<?php echo $this->lang->line('txt_No');?> 

						</div>
					</div>

					<div class="clr"></div>

					<div style="width:17% ; margin-top:10px;margin-left:0px; float:left;"><?php echo $this->lang->line('txt_Assigned_To');?>:</div>

					<div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; float:left;margin-top:10px; ">

		            	<input type="text" id="showMembersEditSubTask<?php echo $nodeId;?>" name="showMembersEditSubTask<?php echo $nodeId;?>" onKeyUp="showFilteredMembersEditSubTask(<?php echo $nodeId;?>)"/>                    

		   			</div>

					<div class="clr"></div>	

				

	            	<div style="width:17%; float:left; margin-left:0px; margin-top:10px;">&nbsp;</div>

				 	<div  style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; height:140px;  margin-top:10px; float:left;" >

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

							//print_r($workSpaceMembers);						

							foreach($workSpaceMembers as $arrData)
							{

								if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
								{						
									$members .='<input type="checkbox" class="users" name="taskUsers[]" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$taskUsers))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br />';
								}

							}
						}
						else
						{
						?>
			            	<input type="checkbox" class="allcheck" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

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

			            <div id="showMemEditSubTask<?php echo $nodeId;?>" style="width:250px;height:100px; overflow:auto;" class="usersList" >

			            	<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> <?php echo $this->lang->line('txt_Me');?><br /> 

			           	 	<?php echo $members;?>

			    		</div> 

			        </div>

					<div class="clr"></div>

					<div style="width:17%; margin-left:0px; margin-top:10px; float:left;"><?php echo $this->lang->line('txt_Completion_Status');?>:</div>

					<div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; margin-top:10px; float:left;">

		            	<input type="radio" name="completionStatus" value="0" <?php if($nodeTaskStatus == 0) { echo 'checked'; }?>>0% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="1" <?php if($nodeTaskStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeTaskStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeTaskStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeTaskStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;

					</div>
					<div class="clr"></div>

					<?php

				}

				?>

				<div style="width:17%; margin-left:0px; float:left;">&nbsp;</div>

	            <div style="width:<?php echo (($this->config->item('page_width')-300)/10)+20;?>%; float:left; margin-top:10px">

		            <div id="loaderImage"></div>
					<!--Manoj: change done to add -->
					<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Save'); //$this->lang->line('txt_Done');?>" onClick="validateSubTaskEdit11('edittask<?php echo $leafId;?>',document.form3<?php echo $leafId;?>,<?php echo $leafId;?>,<?php echo $nodeId; ?>);closeCalendar();" class="button01"> 

					<?php /*

					

					<input type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="edit_Cancel11(<?php echo $leafId;?>,<?php echo $nodeId;?>);" class="button01">

					 */

					 ?>

					<!--  <input style="float:left;" type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New(<?php echo $leafId;?>,<?php echo $nodeId;?>);closeCalendar();" class="button01"> -->
					 <input style="float:left;" type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New1(<?php echo $leafId;?>,<?php echo $nodeId;?>);closeCalendar();" class="button01">

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

					<div id="audioRecordBox"><div style="float:left;margin-top:0.4%; margin-left:1%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $nodeId;?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $nodeId;?>" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>

				</div>
				<div class="clr"></div>

			</form>
		</div>

		<?php 
		$this->load->view('common/foot_new_task.php');
		?>

	</body>
</html>
<script>

function showFilteredMembersEditSubTask(nodeId)
{
	var toMatch = document.getElementById('showMembersEditSubTask'+nodeId).value;

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
				val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
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

						document.getElementById('showMemEditSubTask'+nodeId).innerHTML = val;
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

						document.getElementById('showMemEditSubTask'+nodeId).innerHTML = val;
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
//chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');
set_sub_task_content(<?php echo $leafId;?>);

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

			chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');

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

function edit_Cancel11(leafId1, nodeId)
{
	//window.location = url;
	location.reload ();
	set_sub_task_content(<?php echo $leafId;?>);
}

function validateSubTaskEdit11(replyDiscussion,formname,leafId,cNodeId)
{ 
	
	//document.getElementById('editThis<?php echo $leafId; ?>').style.display='none';

	/*Added by Surbhi IV for checking content */

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('id');

	var getvalue	= getvaluefromEditor(INSTANCE_NAME);

	var error=''

	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1){

		jAlert('<?php //echo $this->lang->line('enter_subtask_title'); ?> \n');return;

	}*/
	if (getvalue == ''){

		jAlert('<?php echo $this->lang->line('enter_subtask_title'); ?> \n');return;

	}

	$("[name=Replybutton]").hide();

	$("[name=Replybutton1]").hide();

	$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

	//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData(); 

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

				//alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

				//replyDiscussion1=replyDiscussion+'1';

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

				    var INSTANCE_NAME1 = $("#edittask"+<?php echo $leafId;?>).attr('id');

					//var getvalue1	= CKEDITOR.instances[INSTANCE_NAME1].getData();

					var getvalue1	= getvalue;

					var request = $.ajax({

					  	url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

					  	type: "POST",

					  	data: data_user+'&edittask<?php echo $leafId;?>='+encodeURIComponent(getvalue1),

					  	dataType: "html",

						success:function(result){
						  	//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion); 

						  	//CKEDITOR.instances[INSTANCE_NAME].destroy();

                          	editorClose("edittask"+<?php echo $leafId;?>);

						  	$("[name=Replybutton]").show();

						  	$("[name=Replybutton1]").show();

						  	//$("#divNodeContainer").html(result);
						  	$("#divNodeContainer",parent.document).html(result);

						  	/*Add for leafid value 0 when close edit popup*/
							$("#task_sub_task_edit",parent.document).val("0");

							//Manoj: froala editor show subtask leaf content on cancel
							var subTaskPredecessorVal = $("#subTaskPredecessor"+cNodeId).val();
							$('#expandSubTasks'+subTaskPredecessorVal).hide();
							$('#collapseSubTasks'+subTaskPredecessorVal).show();
							$('.subTasks'+subTaskPredecessorVal).show();
							//document.getElementById('subTaskLeafContent'+cNodeId).style.display="block";
							
						  	//parent.location.href=parent.location.href;

						  	$('#popupMask',parent.document).remove();
							$('#popupContainer',parent.document).remove();
						}
					});

					//formname.submit();
				}

				/*Added by Surbhi IV for checking content */

			//}

		}
	});
	/*End of Added by Surbhi IV*/
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
</script>

<script>
	
	var ismobile = (/iphone|ipod|Mobile|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
														
	if(ismobile==true)

	{
	   		$("#dtBox").DateTimePicker();
	}
	//Manoj: added condition for edit sub task calendar end
				
	$('.edp').datetimepicker({

		timeFormat: "HH:mm",

		dateFormat: "dd-mm-yy"

	});

	$('.sdp').datetimepicker({

		timeFormat: "HH:mm",

		dateFormat: "dd-mm-yy"

	});

	if(disableEditor==1){

		$("#edittask<?php echo $leafId;?>").hide();

		$("#divedittast<?php echo $leafId;?>").hide();

	}

	chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');
</script>