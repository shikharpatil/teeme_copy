<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></LINK>
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
    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
   
<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>
<?php  		$editStartTimeStyle = '';
				$editEndTimeStyle = '';
				$editStartCalVisible = '';
				$editEndCalVisible = '';
				$editStartCheck = 'checked';
				$editEndCheck = 'checked';
				
				
				 $editStartTime = $start_time; 
				
				
				$taskUsers = $this->task_db_manager->getTaskUsers($nodeId, 2);
				if($editStartTime[0] == '0')
				{ 
					$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');
					$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';
					$editStartCalVisible = 'style="display:none"';
					$editStartCheck 	= '';	
				}
				
				$editEndTime = $end_time;
				
				if($editEndTime[0] == '0')
				{
					$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');
					$editEndTimeStyle 	= ' style="background-color:#CCCCCC; color:#626262;"';
					$editEndCalVisible 	= 'style="display:none"';
					$editEndCheck		= '';	
				}
				?>
<?php
		if (!empty($_SESSION['errorMsg']))
		{
			echo '<b>'.$_SESSION['errorMsg'].'</b>'; 	
			$_SESSION['errorMsg'] = '';
		}
		
		?>				
				
<form name="form3<?php echo $leafId;?>" id="form3<?php echo $leafId;?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $leafId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">


		<div style="width:110px; float:left; margin-top:20px; margin-left:20px" id="divedittast<?php echo $leafId;?>" ><?php echo "Title";?>:</div> <br/><br/>
		
		<div    name="divedittask<?php echo $leafId;?>" id="divedittask<?php echo $leafId;?>" style="width:<?php echo $this->config->item('page_width')-300;?>px;float:left"  ></div>		
		<div style="clear:both"></div>
	
	<?php
	if(!$checksucc)
	{		
	?>
		<div style="width:110px; margin-left:20px; margin-top:20px;  float:left;"><?php echo $this->lang->line('txt_Start_Time');?>:</div>
		<div style="width:<?php echo $this->config->item('page_width')-300;?>px; float:left; margin-top:20px; ">
        	<input type="checkbox" name="startCheck" id="startCheck"  onClick="calStartCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editStartCheck;?>><input name="starttime" type="text" id="starttime<?php echo $leafId;?>" readonly="readonly"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>><span id="calStart<?php echo $leafId;?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $leafId;?>.starttime<?php echo $leafId;?>,'yyyy-mm-dd hh:ii',this,true)" /></span>
		</div>
		<div style="width:110px;margin-top:20px; margin-left:20px; float:left;"><?php echo $this->lang->line('txt_End_Time');?>:</div>
		<div style="width:<?php echo $this->config->item('page_width')-300;?>px;margin-top:20px; float:left;">
        	<input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $leafId;?>', document.form3<?php echo $leafId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $leafId;?>" readonly="readonly"  value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?>><span id="calEnd<?php echo $leafId;?>" <?php echo $editEndCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $leafId;?>.endtime<?php echo $leafId;?>,'yyyy-mm-dd hh:ii',this,true)" /></span>	
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
			<div style="width:100px; margin-left:20px; margin-top:20px; float:left;"><?php echo $this->lang->line('txt_Mark_to_calendar');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-300;?>px; float:left; margin-top:20px;">
				&nbsp;<input type="radio" name="calendarStatus" value="Yes" <?php if($arrDiscussions['viewCalendar'] == 1) { echo 'checked'; }?>>
				<?php echo $this->lang->line('txt_Yes');?> &nbsp;
				<input name="calendarStatus" type="radio" value="No" <?php if($arrDiscussions['viewCalendar'] == 0) { echo 'checked'; }?>>
				<?php echo $this->lang->line('txt_No');?> 
			</div>
   
	</div>
			<div style="width:110px ; margin-top:20px;margin-left:20px; float:left;"><?php echo $this->lang->line('txt_Assigned_To');?>:</div>
			<div style="width:<?php echo $this->config->item('page_width')-300;?>px; float:left;margin-top:20px; ">
            	<input type="text" id="showMembersEditSubTask<?php echo $nodeId;?>" name="showMembersEditSubTask<?php echo $nodeId;?>" onkeyup="showFilteredMembersEditSubTask(<?php echo $nodeId;?>)"/>                    
   			</div>
			
            <div style="width:110px; float:left; margin-left:20px; margin-top:20px;">&nbsp;</div>
    		<div id="showMemEditSubTask<?php echo $nodeId;?>" style="width:<?php echo $this->config->item('page_width')-300;?>px; height:150px; overflow:auto; margin-top:20px; float:left;">
            	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> <?php echo $this->lang->line('txt_Me');?><br />           
			<?php	
			if($workSpaceId==0)
			{	
				if (count($sharedMembers)!=0)
				{
			?>
            		<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />
			<?php	
                }	
				foreach($workSpaceMembers as $arrData)
				{
					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
					{						
			?>
                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
						<?php echo $arrData['tagName'];?><br />
			<?php
					}
				}
			}
			else
			{
			?>

            	<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />
            <?php
				foreach($workSpaceMembers as $arrData)
				{
					if($_SESSION['userId'] != $arrData['userId'])
					{						
			?>
                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> 
						<?php echo $arrData['tagName'];?><br />
			<?php
					}
				}	
			}
			?>
    		</div> 
        

			<div style="width:110px; margin-left:20px; margin-top:20px; float:left;"><?php echo $this->lang->line('txt_Completion_Status');?>:</div>
			<div style="width:<?php echo $this->config->item('page_width')-300;?>px; margin-top:20px; float:left;">
            	<input type="radio" name="completionStatus" value="0" <?php if($nodeTaskStatus == 0) { echo 'checked'; }?>>0% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="1" <?php if($nodeTaskStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeTaskStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeTaskStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeTaskStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;
			</div>
	<?php
	}
	?>
			<div style="width:110px; margin-left:20px; float:left;">&nbsp;</div>
            <div style="width:<?php echo $this->config->item('page_width')-300;?>px; float:left; margin-top:10px">
				<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validateSubTaskEdit11('edittask<?php echo $leafId;?>',document.form3<?php echo $leafId;?>);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="edit_Cancel11(<?php echo $leafId;?>,<?php echo $nodeId;?>);" class="button01">
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
			</div>
</form>
<script>
function showFilteredMembersEditSubTask(nodeId)
{
	var toMatch = document.getElementById('showMembersEditSubTask'+nodeId).value;
	//alert ('toMatch= ' +toMatch);
	var val = '';
		if (1)
		{
			<?php
			if ($workSpaceMembers==0)
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
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
				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taskUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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


set_sub_task_content(<?php echo $leafId;?>);

function set_sub_task_content(leafId)
{

xmlHttpLast=GetXmlHttpObject2();
				var url =baseUrl+'current_leaf'+"/index/leafId/"+leafId;
				
				
					xmlHttpLast.onreadystatechange=function() {
						if (xmlHttpLast.readyState==4) {
							var arrNode = Array ();
							var nodeDetails = xmlHttpLast.responseText;

								if (nodeDetails != 0)
								{

									arrNode = nodeDetails.split("~!@");

									if (arrNode[0]!='onlyContents')
									{
										leafId1=arrNode[1];
										leafId2=arrNode[1];

										treeId1=arrNode[3];
										nodeId1=arrNode[0];
										content=arrNode[4];
									}
									else
									{
										content=arrNode[1];
										
									}
									
								}

editor_code(content,'edittask'+leafId,'divedittask'+leafId);
chnage_textarea_to_editor('edittask<?php echo $leafId;?>','simple');
}
				}
				xmlHttpLast.open("GET", url, true);
				xmlHttpLast.send(null);
}				
function reply(id)
{
	divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';

	rameid=id;	
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}
function edit_Cancel11(leafId1, nodeId){
	

	
	location.reload ();
	set_sub_task_content(<?php echo $leafId;?>);
}
function validateSubTaskEdit11(replyDiscussion,formname){ 
	
	document.getElementById('editStatus').value= 0;		
	var url = baseUrl+'unlock_leaf';		  
		xmlHttp1=GetXmlHttpObject2();
		queryString =   url; 
		queryString = queryString + '/index/leafId/'+leafId1;
		
		
		xmlHttp1.open("GET", queryString, false);
		xmlHttp1.send(null);
		xmlHttp1.onreadystatechange = function(){}
	var error=''

	if(getvaluefromEditor(replyDiscussion,'simple') == ''){
		error+='<?php echo $this->lang->line('enter_subtask_title'); ?>\n';
	}

if(formname.editStatus.value == 0)
	{
					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){
						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){
							
							error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';
						}
					}
	}
	if(error==''){
		formname.submit();
	}else{
		jAlert(error);
	}
	
	}
</script>