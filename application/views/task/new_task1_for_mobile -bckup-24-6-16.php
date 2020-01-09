<form name="formAddTask<?php echo $position;?>" id="formAddTask<?php echo $position;?>" method="post" >

  <div class="subTaskMobile"> <?php echo $this->lang->line('txt_Task');?>: </div>

  <div class="subTaskMobile fieldsetBottom">

    <textarea name="newTask<?php echo $nodeId;?>" id="newTask<?php echo $nodeId;?>" rows="5" cols="40"></textarea>

  </div>
<?php
	//Add code for get current hour and minute start
	$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');
	
	$var = explode(' ',$editStartTime);

	$dateVar = explode('-',$var[0]);

	$timeVar = explode(':',$var[1]);
	//Add code for get current hour and minute end
?>
<div class="subTaskMobile"> <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span> <input type="checkbox" name="startCheck" id="startCheck" onClick="calStartCheck(this)" style="float:left"></div>

    <div class="subTaskMobile" >
		
		<!--Manoj: Changed the date format Y-m-d to d-m-y-->
    	<input name="starttime" type="hidden" id="starttime" size="16"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');?>">



   

        D&nbsp;<select name="startDay" id="startDay" class="enterCal startCal" disabled="disabled" timing='start' style="width:43px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==date("d"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="startMonth" id="startMonth" class="enterCal changeMonth startCal" disabled="disabled" timing='start' style="width:43px;">

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

    <div class="subTaskMobile fieldsetBottom" >

    H&nbsp;<select name="startHours" id="startHours" disabled="disabled" class="enterCal startCal" timing='start' style="width:43px;">

    <?php
	
	for($i=0;$i<=23;$i++){?>
		<!--Manoj: Add $timeVar[0] for current time(hours)-->
    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="startMins" id="startMins" disabled="disabled" class="enterCal startCal" timing='start' style="width:43px;">

    <?php

	for($i=0;$i<=59;$i++){?>
		<!--Manoj: Add $timeVar[1] for current time(hours)-->
    	<option <?php echo ($i==$timeVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    </div>

  <div class="subTaskMobile"> <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <span style="vertical-align:top" > <?php echo $this->lang->line('txt_End_Time');?>:</span> <input type="checkbox" name="endCheck" id="endCheck" onClick="calEndCheck(this)" style="float:left;"></div>



  <div class="subTaskMobile" >

   
	<!--Manoj: Changed the date format Y-m-d to d-m-y-->
   <input name="endtime" type="hidden" id="endtime" size="16" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');?>">

  

    D&nbsp;<select name="endDay" id="endDay" disabled="disabled" class="enterCal endCal" timing='end' style="width:43px;">

            <?php

            $dy = date("d",strtotime("last day of this month"));

            for($i=1;$i<=$dy;$i++){?>

                <option <?php echo ($i==date("d"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

            <?php

            }?>

    	</select>

    M&nbsp;<select name="endMonth" id="endMonth" disabled="disabled" class="enterCal endCal changeMonth" timing='end' style="width:43px;">

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

    H&nbsp;<select name="endHours" id="endHours" disabled="disabled" class="enterCal endCal" timing='end' style="width:43px;">

    <?php

	for($i=0;$i<=23;$i++){?>
		<!--Manoj: Add $timeVar[0] for current time(hours)-->
    	<option <?php echo ($i==$timeVar[0])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    M&nbsp;<select name="endMins" id="endMins" disabled="disabled" class="enterCal endCal" timing='end' style="width:43px;">

    <?php

	for($i=0;$i<=59;$i++){?>
		<!--Manoj: Add $timeVar[1] for current time(mins)-->
    	<option <?php echo ($i==$timeVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>

    <?php

	}?>

    </select>

    </div>

    

  





<!--  <div class="subTaskMobile"> <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span>

    <input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')">

  </div>

  

  

  <div class="subTaskMobile">

    <input name="starttime" type="text" id="starttime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

    <span id="calStart<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAddTask<?php echo $position;?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span> </div>

  

  

  <div class="subTaskMobile"> <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <span style="vertical-align:top" ><?php echo $this->lang->line('txt_End_Time');?>: </span>

    <input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')">

  </div>

  

  

  <div class="subTaskMobile">

    <input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

    <span id="calEnd<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAddTask<?php echo $position;?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span> </div>

  -->

  <div class="subTaskMobile fieldsetBottom"><?php echo $this->lang->line('txt_Assigned_To');?>:<a href="javascript:void(0);" onclick="popup()">Click to Assign</a><div id="namesDiv"></div></div>

    

  

  <div id="showMem" class="subTaskMobile" style="display:none;">

   <input type="text" id="showMembersAddTask<?php echo $nodeId;?>" name="showMembersAddTask<?php echo $nodeId;?>" onKeyUp="showFilteredMembersAddTask(<?php echo $nodeId;?>)"/>

    <div class="showMem1" id="showMemAddTask<?php echo $nodeId;?>">

   

      <input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>

      <span><?php echo $this->lang->line('txt_Me');?></span>

      <?php	

			if($workSpaceId==0)

			{	

				if (count($sharedMembers)!=0)

				{

			?>

      <input type="checkbox" name="taskUsers[]" value="0"/>

      <span><?php echo $this->lang->line('txt_All');?></span>

      <?php	

                }						

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

      <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/>

      <span><?php echo $arrData['tagName'];?></span>

      <?php

					}

				}

			}

			else

			{

			?>

      <input type="checkbox" name="taskUsers[]" value="0"/>

      <span><?php echo $this->lang->line('txt_All');?></span>

      <?php

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

      <input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/>

      <span><?php echo $arrData['tagName'];?></span>

      <?php

					}

				}

			}

			?>

    </div>

    <button class="button01" onclick="assignTo();">Ok</button>

  </div>

  

  <div class="subTaskMobile fieldsetBottom" id="mark_calender" style="display:none;"> <span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>

    <input type="radio" name="calendarStatus" value="Yes">

    <?php echo $this->lang->line('txt_Yes');?> &nbsp;

    <input name="calendarStatus" type="radio" value="No" checked>

    <?php echo $this->lang->line('txt_No');?> 

  </div>

  <div class="subTaskMobile"> <?php echo $this->lang->line('txt_Completion_Status');?>: </div>

  

  <div class="subTaskMobile">

      <select name="completionStatus">

    	<option value="0">0%</option>

        <option value="1">25%</option>

        <option value="2">50%</option>

        <option value="3">75%</option>

        <option value="4">Completed</option>

    </select>

     </div>

  

  <div class="subTaskMobile">

    <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_task('newTask<?php echo $nodeId;?>',<?php echo $treeId; ?>,document.formAddTask<?php echo $position;?>);" class="button01">

    &nbsp;&nbsp;&nbsp;&nbsp;

    <input type="reset" name="Replybutton1" value="Cancel" onClick="hideTaskView1New_newTask('<?php echo $nodeId;?>');" class="button01">

  </div>

 

  <input name="reply" type="hidden" id="reply" value="1">

  <input name="editorname1" type="hidden" value="newTask<?php echo $nodeId;?>">

  <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

  <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

  <input type="hidden" name="titleStatus" value="0" id="titleStatus">

  <input name="nodeId" type="hidden" value="<?php echo $nodeId;?>">

  <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

  <input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

  <input name="parent" type="hidden" id="parent" value="0">

</form>

<script>
//Manoj: add version simple
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



var curId='';



function popup()

{

	initPopUp();

	showPopWin('your_url_here.html',480, 340,'');

	popWin = $('#popupInner').html();

	curId = 'showMem';

	$('#popupFrame').replaceWith($('#showMem').html());

	$('#showMem').html('');

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


	//Manoj: Changed method click to change 
	$('.enterCal').change(function(){
		
		var t = $(this).attr('timing');

		var d = $('#'+t+'Day').val();

		var y = $('#'+t+'Year').val();

		var mins = $('#'+t+'Mins').val();

		var h = $('#'+t+'Hours').val();

		var m = $('#'+t+'Month').val();

		
		//Manoj: Change date format (Y-m-d to d-m-y)
		
		$('#'+t+'time').val(d+'-'+m+'-'+y+' '+h+':'+mins);

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



function calStartCheck(thisVal)

{

	if(thisVal.checked == true)

	{			

		document.getElementById('mark_calender').style.display = "";
		
		//Manoj: Make disabled false 
		$('.startCal').attr('disabled', false);

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

	{
		//Manoj: Make disabled false 	
		$('.endCal').attr('disabled', false);

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



function assignTo(){

	$('#showMem').html($('#popupInner').html());

	$('#showMem > #popupTitleBar').replaceWith('');

	var a = '';

	var x=0;

	$('#popupInner > .showMem1 > input:checkbox').each(function(){

		var n=$(this).val();

		if($(this).attr('checked')==true){

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





</script>

