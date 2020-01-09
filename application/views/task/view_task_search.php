<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>



<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

<script>

function sortTask(thisVal, url)

{

	window.location = url+'/'+thisVal.value;

}



function enableReorder(curOption)

{	

	if(curOption == 1)

	{

		if(document.frmCal.toDate.value != '')

		{		

			document.getElementById('reOrder').style.display = '';

		}	

		else

		{

			document.getElementById('reOrder').style.display = 'none';

		}		

	}

	else if(curOption == 2)

	{

		if(document.frmCal.fromDate.value != '')

		{

			document.getElementById('reOrder').style.display = '';

		}	

		else

		{

			document.getElementById('reOrder').style.display = 'none';

		}

	}

	else if(curOption == 3)

	{

		//alert (document.frmCal.fromDate.value);

		if(document.frmCal.toDate.value != '')

		{

			document.getElementById('sortStart').style.display = '';

		}	

		if(document.frmCal.fromDate.value != '')

		{

			document.getElementById('sortEnd').style.display = '';

		}	

	}	

	else if(curOption == 4)

	{

		//alert (document.frmCal.fromDate.value);

		if(document.frmCal.fromDate.value != '')

		{

			document.getElementById('sortStart').style.display = '';

		}	

		if(document.frmCal.toDate.value != '')

		{

			document.getElementById('sortEnd').style.display = '';

		}	

	}	

}

function hidedetail(id){

	var image='img'+id;

	//var added='add'+id;

	var details='detail'+id;

	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	//document.getElementById(added).style.display='none';

	document.getElementById(details).style.display='none';

	

}

function showdetail(id){

	

	//var added='add'+id;

	var curNode='detail'+id;

	//document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/minus.gif" onClick="hidedetail('+id+');">';

	//document.getElementById(added).style.display='';

	var allNodes = document.getElementById('totalNodes').value;

	var arrNodes = new Array();

	arrNodes = allNodes.split(',');

	for(var i = 0;i<arrNodes.length;i++)

	{		

		var nodeId = 'detail'+arrNodes[i];		

		if(id != arrNodes[i])

		{			

			document.getElementById(nodeId).style.display='none';	

		}

	} 

	if(document.getElementById(curNode).style.display=='')		

	{

		document.getElementById(curNode).style.display='none';

	}

	else

	{

		document.getElementById(curNode).style.display='';

	}

}



function showTasksToday()

{

	var c1 = document.getElementById('tasksToday');

	var c2 = document.getElementById('tasksSeven');

	var c3 = document.getElementById('tasksOverdue');

	var c4 = document.getElementById('taskSearch');

	c1.className = 'active';

	c2.className = '';

	c3.className = '';

	c4.className = '';

	document.getElementById('spanTasksToday').style.display = '';

	document.getElementById('spanTasksSeven').style.display = 'none';

	document.getElementById('spanTasksOverdue').style.display = 'none';	

	document.getElementById('spanTaskSearch').style.display = 'none';	

}

function showTasksSeven()

{

	var c1 = document.getElementById('tasksToday');

	var c2 = document.getElementById('tasksSeven');

	var c3 = document.getElementById('tasksOverdue');

	var c4 = document.getElementById('taskSearch');

	c1.className = '';

	c2.className = 'active';

	c3.className = '';

	c4.className = '';

	document.getElementById('spanTasksToday').style.display = 'none';

	document.getElementById('spanTasksSeven').style.display = '';

	document.getElementById('spanTasksOverdue').style.display = 'none';	

	document.getElementById('spanTaskSearch').style.display = 'none';	

}

function showTasksOverdue()

{

	var c1 = document.getElementById('tasksToday');

	var c2 = document.getElementById('tasksSeven');

	var c3 = document.getElementById('tasksOverdue');

	var c4 = document.getElementById('taskSearch');

	c1.className = '';

	c2.className = '';

	c3.className = 'active';

	c4.className = '';

	document.getElementById('spanTasksToday').style.display = 'none';

	document.getElementById('spanTasksSeven').style.display = 'none';

	document.getElementById('spanTasksOverdue').style.display = '';	

	document.getElementById('spanTaskSearch').style.display = 'none';	

}

function showTaskSearch()

{

	var c1 = document.getElementById('tasksToday');

	var c2 = document.getElementById('tasksSeven');

	var c3 = document.getElementById('tasksOverdue');

	var c4 = document.getElementById('taskSearch');

	c1.className = '';

	c2.className = '';

	c3.className = '';

	c4.className = 'active';

	document.getElementById('spanTasksToday').style.display = 'none';

	document.getElementById('spanTasksSeven').style.display = 'none';

	document.getElementById('spanTasksOverdue').style.display = 'none';	

	document.getElementById('spanTaskSearch').style.display = '';	

	

	//removeSortOptions ();

}



function calCheck(thisVal,formName)

{



	var callStartId = 'calStart';

	var callEndId = 'calEnd';

	if(thisVal.checked == true)

	{			

		document.getElementById(callStartId).style.display = "";	

		formName.fromDate.style.color = "#000000";	

		formName.fromDate.style.backgroundColor = "#FFFFFF";	

		

		document.getElementById(callEndId).style.display = '';

		formName.toDate.style.color = "#000000";	

		formName.toDate.style.backgroundColor = "#FFFFFF";	

	}

	else

	{	

		document.getElementById(callStartId).style.display = 'none';

		formName.fromDate.style.color = "#626262";	

		formName.fromDate.style.backgroundColor = "#CCCCCC";

		

		document.getElementById(callEndId).style.display = 'none';

		formName.toDate.style.color	 = "#626262";	

		formName.toDate.style.backgroundColor = "#CCCCCC";		

		

		document.getElementById('sortStart').style.display = 'none';	

		document.getElementById('sortEnd').style.display = 'none';	

	}

}



function calendarStartCheck(thisVal, formName)

{

	var callStartId = 'calStart';	

	if(thisVal.checked == true)

	{			

		$("#fromDate").datepicker({dateFormat:"dd-mm-yy"});

		//document.getElementById(callStartId).style.display = "";	

		formName.fromDate.style.color = "#000000";	

		formName.fromDate.style.backgroundColor = "#FFFFFF";

		formName.showAll.checked=false;	

	}

	else

	{		

		//document.getElementById(callStartId).style.display = 'none';

		formName.fromDate.style.color = "#626262";	

		formName.fromDate.style.backgroundColor = "#CCCCCC";	

		formName.fromDate.value = '';

		document.getElementById('sortStart').style.display = 'none';

		formName.taskSort.value = 3;

	}

}

function calendarEndCheck(thisVal, formName)

{

	var callEndId = 'calEnd';

	if(thisVal.checked == true)

	{		

		$("#toDate").datepicker({dateFormat:"dd-mm-yy"});

		//document.getElementById(callEndId).style.display = '';

		formName.toDate.style.color = "#000000";	

		formName.toDate.style.backgroundColor = "#FFFFFF";	

		formName.showAll.checked=false;

	}

	else

	{		

		//document.getElementById(callEndId).style.display = 'none';

		formName.toDate.style.color	 = "#626262";	

		formName.toDate.style.backgroundColor = "#CCCCCC";	

		formName.toDate.value = '';

		document.getElementById('sortEnd').style.display = 'none';

		formName.taskSort.value = 3;

	}

}

function showHideAllOptions (thisVal,formName)

{

	var callStartId = 'calStart';

	var callEndId = 'calEnd';

	if(thisVal.checked == true)

	{

		//document.getElementById('allOptions').style.display = 'none';

		//document.getElementById('sortStart').style.display = 'none';

		//document.getElementById('sortEnd').style.display = 'none';

		//document.getElementById(callStartId).style.display = 'none';

		//document.getElementById(callEndId).style.display = 'none';

		

		formName.startCheck.checked = false;

		formName.endCheck.checked = false;



		formName.fromDate.style.color = "#626262";	

		formName.fromDate.style.backgroundColor = "#CCCCCC";	

		formName.fromDate.value = '';

				

		formName.toDate.style.color	 = "#626262";	

		formName.toDate.style.backgroundColor = "#CCCCCC";	

		formName.toDate.value = '';

	}

	else

	{

		document.getElementById('allOptions').style.display = '';

	}

}



function validate_dis(formname){

	var error='';



	if(formname.fromDate.value!='' && formname.toDate.value!='' ){

		if(compareDates(formname.fromDate.value,formname.toDate.value) == 1){

			

			error+='<?php echo $this->lang->line('check_from_date_to_date'); ?>';

			jAlert (error);

			return false;

		}

		else

		{

			formname.submit();

		}

	}

}



function compareDates (dat1, dat2) {

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

   else return 0;

}





/*function removeSortOptions ()

{

	var theSelect = document.getElementById("taskSort");

    var theOption1 = document.getElementById("sortStart");

	var theOption2 = document.getElementById("sortEnd");

	alert ('remove');

    theSelect.removeChild(theOption1);

	theSelect.removeChild(theOption2);

}



function addSortOptions ()

{

	alert ('add');

	var theSelect = document.getElementById("taskSort");

    var theOption1 = document.getElementById("sortStart");

	var theOption2 = document.getElementById("sortEnd");

    theSelect.appendChild(theOption1);

	theSelect.appendChild(theOption2);

}*/


function disableAny()
{
	if ($('input[id="completion0"]:checked').length == 0 && $('input[id="completion25"]:checked').length == 0 && $('input[id="completion50"]:checked').length == 0 && $('input[id="completion75"]:checked').length == 0 && $('input[id="completion100"]:checked').length == 0)
	{
		
		$("#any").attr("disabled", false);	
		$("#any").prop( "checked" ,true);
	}
	else
	{
		$("#any").attr("checked", false);
		$("#any").attr("disabled", true);
	}

}


</script>



<script language="JavaScript1.2">//mmLoadMenus();</script>

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header');//print_r($details);die;?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<!--container div start-->
<div id="container">
	<!--left menu bar div start-->
	<div id="leftSideBar" class="leftSideBar">
		<?php $this->load->view('common/left_menu_bar'); ?>
	</div>
	<!--left menu bar div end-->

	<!--right sidebar div start-->
	<div id="rightSideBar">

		<?php
    	//$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

    	//$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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
		<span id="tagSpan"></span>

		<?php

		if($this->input->post('originator') != '')
		{
			$originator = $this->input->post('originator');
		}	
		else
		{
			$originator = '';
		}	

		if($this->input->post('assigned_to') != '')
		{
			$assigned_to = $this->input->post('assigned_to');
		}	
		else
		{
			$assigned_to = '';
		}
		//echo "<li>From date= " .$this->input->post('fromDate');
		//echo "<li>To date= " .$this->input->post('toDate');
	
		if($this->input->post('fromDate') != '')
		{	
			//$searchDate1	= $this->input->post('fromDate');
			$frdt = $this->input->post('fromDate');
			$frdt =  explode("-",$frdt);
			$searchDate1 = $frdt[2]."-".$frdt[1]."-".$frdt[0];

			$_SESSION['taskFromDate'] 	= $this->input->post('fromDate');
		}
		else
		{
			$searchDate1				= '';
			$_SESSION['taskFromDate'] 	= '';
		}

		if($this->input->post('toDate') != '')
		{		
			//$searchDate2	= $this->input->post('toDate');
			$todt = $this->input->post('toDate');
			$todt =  explode("-",$todt);
			$searchDate2 = $todt[2]."-".$todt[1]."-".$todt[0];

			$_SESSION['taskToDate'] 		= $this->input->post('toDate');	
		}
		else
		{		
			$searchDate2				= '';
			$_SESSION['taskToDate'] 		= '';	
		}

		$completionStatus = $this->input->post('completionStatus');

		$sortUrl = base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/2';

		//$arrNodeIds = $this->identity_db_manager->getNodesByDate($treeId, $searchDate1, $searchDate2);	

		if ($this->input->post('showAll')=='on')
		{
			//$arrNodeIds = $this->identity_db_manager->getAllNodesByTreeId($treeId);	
			$arrNodeIds = $this->identity_db_manager->getNodesBySearchOptions($treeId, $searchDate1, $searchDate2, $originator, $assigned_to, implode(",",$completionStatus),1);
		}
		else
		{
			$arrNodeIds = $this->identity_db_manager->getNodesBySearchOptions($treeId, $searchDate1, $searchDate2, $originator, $assigned_to, implode(",",$completionStatus));	//print_r($arrNodeIds);
		}

		$arrDetails['arrNodeIds'] = $arrNodeIds;

		//print_r($arrNodeIds);

		$day 	= date('d');

		$month 	= date('m');

		$year	= date('Y');	

		$today = $year."-".$month."-".$day;
		?>

        <div id="divSeed" class="seedBackgroundColorNew shareSeedDivHeight" >
       		<?php $this->load->view('task/task_seed_header'); ?>
       		<div class="clsNoteTreeHeader handCursor"> 
       			<?php 
				if($arrDiscussionDetails['name'] != 'untitled')
				{
				?>
					<?php echo strip_tags($arrDiscussionDetails['name']);?>

				<?php
				}
				?>
       		</div>
    	</div>
		
		<table width="100%" border="0">
	        <tr>
	        	<td colspan="4" align="left" valign="top" height="20">&nbsp;</td>
	        </tr>

        	<tr>
            	<td colspan="4" align="left" valign="top" class="tdSpace">   
					<div class="menu_new" style="width:100%;" >
			            <ul class="tab_menu_new" >
							<li>
								<a href="javascript:void(0);" id="taskSearch" onclick="showTaskSearch();" >
									<span><?php echo $this->lang->line('txt_Task_Search');?></span>
								</a>
							</li>	
							<li>
								<a href="javascript:void(0);" id="tasksOverdue" onclick="showTasksOverdue();" >
									<span><?php echo $this->lang->line('txt_Tasks_Overdue');?></span>
								</a>
							</li>               
			                <li>
			                	<a href="javascript:void(0);" id="tasksToday" onclick="showTasksToday();" >
			                		<span><?php echo $this->lang->line('txt_Tasks_Today');?></span>
			                	</a>
			                </li>
			                <li>
			                	<a href="javascript:void(0);" id="tasksSeven" onclick="showTasksSeven();">
			                		<span><?php echo $this->lang->line('txt_Tasks_Seven');?></span>
			                	</a>
			                </li>
			            </ul>
						<div class="clr"></div>
			        </div>
				</td>
        	</tr>

        	<tr>
        		<td colspan="4" align="left" valign="top" class="tdSpace"> 
					<span id="spanTasksOverdue" style="display:none;">
	                    <?php
						//print_r($discussionDetails);
						if(count($discussionDetails) > 0)
						{	
							$count = 0 ;			 

							foreach($discussionDetails as $keyVal=>$arrVal)
							{	

								$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);
								$nodeBgColor = '';

								$end_date = substr ($arrVal['endtime'],0,10);

								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

								$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);
							
								//Manoj: Get all contributors for overdue tasks

								$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
							
								$contributorsTagName		= array();
				
								$contributorsUserId			= array();
							
								foreach($contributors  as $userData)
								{
									$contributorsTagName[] 	= $userData['userTagName'];
								}	
								//Manoj: code end

								if ((!$checksucc) && ($end_date<$today) && ($end_date!='0000-00-00') && ($nodeTaskStatus!=4))
								{

									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									//$nodeBgColor = ($count%2)?'row1':'row2';
									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/

									?>			

									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">

										<?php 
										if($checksucc)
										{
											?>
										
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/
												if($arrVal["leafStatus"] !='deleted'){  
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
										    	?>
											</a>
										
											<?php
											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Add searchTaskCompleteStatusIcon class for icon*/
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ ?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];										
										}
										?>
										<div class="clr"></div>
										<div class="userLabel">
											<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
										</div>
										<?php

										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
											    <?php
											}

											if($arrVal['endtime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;
												</span>
												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?>

										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
                    						<?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
							            ?>	    									
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->
									<?php
								}	

							}
						}
						?>

                    	<?php

						if ($count ==0)
						{
							?>
							<?php echo $this->lang->line('txt_None');?>		
							<?php
	                    }
						?>                 
                	</span> 

					<span id="spanTasksToday" style="display:none;">
                    	<?php
						if(count($discussionDetails) > 0)
						{	
							$count = 0 ;			 
							foreach($discussionDetails as $keyVal=>$arrVal)
							{	 
								$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);
								$nodeBgColor = '';

								$start_date = substr ($arrVal['starttime'],0,10);	

								$end_date = substr ($arrVal['endtime'],0,10);	

								/*echo "<li>today= " .$today;
								echo "<li>start= " .$start_date;
								echo "<li>end= " .$end_date;
								echo "<hr>";*/

								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

								$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);								
			
								$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
							
								$contributorsTagName		= array();
				
								$contributorsUserId			= array();
							
								foreach($contributors  as $userData)
								{
									$contributorsTagName[] 	= $userData['userTagName'];
								}	

								//	if ( (!$checksucc) && ($start_date==$today) && ($end_date==$today))
								if ( (!$checksucc) && ($start_date<=$today && $start_date!='0000-00-00') && ($end_date>=$today && $end_date!='0000-00-00'))
								{
									/*echo "<li>startdate1= " .$start_date;
									echo "<li>enddate1= " .$end_date;*/
									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/
									?>			

									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">
										<?php
										if ($checksucc)
										{
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250);*/
												if($arrVal["leafStatus"] !='deleted'){  
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ ?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?>
											</a>
											
											<?php
											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
										
											?>
										
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250);*/  

												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
											        <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
											    <?php 
											    }
												?> 
											</a>
										
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a></div>';

											$lastnode = $arrVal['nodeId'];								
										}

										?>
										<div class="clr"></div>
										<div class="userLabel">
											<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
										</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
												<?php
											}
											if($arrVal['endtime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;
												</span>
												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?>

										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>							         
							                <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
										
							            ?>	
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->
									<?php
								}

								//else if ((!$checksucc) && ($start_date==$today) && ($end_date!=$today))
								else if ((!$checksucc) && ($start_date<=$today && $start_date!='0000-00-00') && ($end_date=='0000-00-00'))
								{
									/*echo "<li>startdate2= " .$start_date;
									echo "<li>enddate2= " .$end_date;*/
									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/

									?>
									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">
										<?php 
										if ($checksucc)
										{	
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/

												if($arrVal["leafStatus"] !='deleted'){ 
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}	
												?> 
											</a>
											<?php
											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											
											?>
											
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 

												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											
											<?php
											
											echo '</div>';
											
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];						
										}

										?>
										<div class="clr"></div>
										<div class="userLabel">
											<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
										</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
											?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
												<?php
											}

											if($arrVal['endtime'][0] != '0')
											{
											?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>
												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?> 
			
										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
                    						<?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
            							?>
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->
									<?php		
								}

								//else if ((!$checksucc) && ($start_date!=$today) && ($end_date==$today))
								else if ((!$checksucc) && ($start_date=='0000-00-00') && ($end_date>=$today && $end_date!='0000-00-00'))
								{
									/*echo "<li>startdate3= " .$start_date;
									echo "<li>enddate3= " .$end_date;*/
									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/

									?>	

									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">

										<?php
										if ($checksucc)
										{
											?>
										
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/

												if($arrVal["leafStatus"] !='deleted'){ 
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											
											<?php

											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];

										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 

												if($arrVal["leafStatus"] !='deleted'){ 
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ ?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}	
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];					
										}

										?>
										<div class="clr"></div>
									 	<div class="userLabel">
									 		<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
									 	</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
												<?php
											}

											if($arrVal['endtime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>
												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?> 
			
										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
							                    <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
							            ?>
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->
									<?php		
								}	

							}
						}

						?>
	                    <?php
						if ($count ==0)
						{
						?>
							<?php echo $this->lang->line('txt_None');?>
							<?php
	                    }
						?>                 
               		</span>

                	<span id="spanTasksSeven" style="display:none;">
	                    <?php
						if(count($discussionDetails) > 0)
						{	
							$count = 0 ;			 
							foreach($discussionDetails as $keyVal=>$arrVal)
							{	 
								$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);

								$nodeBgColor = '';

								$start_date = substr ($arrVal['starttime'],0,10);

								$end_date = substr ($arrVal['endtime'],0,10);

								$day7 = "+7 days";

								$days7 = strtotime ($day7);

								$days7 = date("Y-m-d",$days7);		

								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

								$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);					

								$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
							
								$contributorsTagName		= array();
				
								$contributorsUserId			= array();
							
								foreach($contributors  as $userData)
								{
									$contributorsTagName[] 	= $userData['userTagName'];
								}	

								if ((!$checksucc) && (($start_date>$today) && ($start_date<=$days7)) && (($end_date>$today) && ($end_date<=$days7)))
								{

									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/

									?>			
									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">

										<?php 
										if ($checksucc)
										{
											?>
										
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/

												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
										
											<?php

											//echo '<a style="text-decoration:none; color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 

												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none; color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];					
										}

										?>
										<div class="clr"></div>
									 	<div class="userLabel">
									 		<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
									 	</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
												<?php
											}

											if($arrVal['endtime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>

												<?php
											}
										}		
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}

										}
										?> 
		
										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
							                <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
							            ?>	           
                                	</div>

	                                <!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->

									<?php

								}
								else if ((!$checksucc) && (($start_date>$today) && ($start_date<=$days7)) && (($end_date<$today) || ($end_date>=$days7)))
								{

									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/
									?>		

									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">

										<?php
										if ($checksucc)
										{
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php
											//echo '<a style="text-decoration:none; color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
										
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/  
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none; color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];								
										}

										?>
										<div class="clr"></div>
										<div class="userLabel">
											<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
										</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
												<?php
											}

											if($arrVal['endtime'][0] != '0')
											{
												?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>

												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?> 
										
										
										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
							                <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
							            ?>	           
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->							

                    				<?php    	
								}

								else if ((!$checksucc) && (($start_date<$today) || ($start_date>=$days7)) && (($end_date>$today) && ($end_date<=$days7)))
								{

									$count++;

									/*Commented by Dashrath- Comment old code and new code below for new ui*/
									// $nodeBgColor = ($count%2)?'row1':'row2';

									/*Added by Dashrath- add code for new ui*/
									$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
									/*Dashrath- code end*/

									?>	

									<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">

										<?php

										if ($checksucc)
										{
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php

											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];

										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
										
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none; color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];						
										}

										?>
										<div class="clr"></div>
										<div class="userLabel">
											<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
										</div>

										<?php
										if(!$checksucc)
										{
											if($arrVal['starttime'][0] != '0')
											{
											?>
												<span class="style1" style="margin-left:2%;">
													<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
												</span>
											<?php
											}

											if($arrVal['endtime'][0] != '0')
											{
											?>
												<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>
												<?php
											}
										}
										else
										{
											if($subListTime['listStartTime'] != '')
											{
												?>
							                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
							                    <?php
							                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
							                    <?php
											}

											if($subListTime['listEndTime'] != '')
											{
												?>
												&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
												<?php
												echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
												<?php
											}
										}
										?> 
										
										<?php
							            if(!$checksucc && count($contributorsTagName)>0)
							            {
							            	?>
							                <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
							            	<?php
							            }
							            ?>	           
									</div>

									<!--Added by Dashrath- Add for div seperater in new ui-->
									<div class="treeLeafRowStyle2"></div>
									<!--Dashrath- code end-->
									<?php		
								}
							}
						}
						?>

	                    <?php
						if ($count ==0)
						{
							?>
							<?php echo $this->lang->line('txt_None');?>
							<?php
	                    }
						?>                 
	                </span>  
            	</td>
       		</tr>
     	</table>

		<span id="spanTaskSearch" style="display:none;">

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
				<tr>
					<td align="left" valign="top" class="tdSpace"> 
						<form name="frmCal" action="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" method="post" id="frmCal" onSubmit="return validateCal()">
           					<span id="allOptions">
            					<p>
									<?php echo $this->lang->line('txt_By');?>:
									<select name="originator">
           								<option value="0">
           									<?php echo $this->lang->line('txt_Any');?>
           								</option>

										<?php	
										$uniqueUsers1 = array();
										foreach($discussionDetails as $keyVal=>$arrVal)
										{
											if (!in_array($arrVal['userId'],$uniqueUsers1))
											{
												$userDetails = $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);
												$username = $userDetails['userTagName'];
												?>

												<option value="<?php echo $arrVal['userId'];?>" <?php if($originator == $arrVal['userId']) { echo 'selected'; } ?>>
													<?php echo $username;?>
												</option>

												<?php
												$uniqueUsers1[] = $arrVal['userId'];
											}
										}		
										?>
									</select>	
								</p>

            					<p>
									<?php echo $this->lang->line('txt_Assigned_To');?>:
									<select name="assigned_to">
            							<option value="0">
            								<?php echo $this->lang->line('txt_Any');?>
            							</option>
										<?php	
										$uniqueUsers2 = array();

										foreach($discussionDetails as $keyVal=>$arrVal)
										{

											$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);

											$contributorsTagName		= array();

											$contributorsUserId			= array();

											foreach($contributors as $userData)
											{
												//$contributorsTagName[] 	= $userData['userTagName'];
												//$contributorsUserId[] 	= $userData['userId'];	

												if (!in_array($userData['userId'],$uniqueUsers2))
												{
													?>
													<option value="<?php echo $userData['userId'];?>" <?php if($assigned_to == $userData['userId']) { echo 'selected'; } ?>>
														<?php echo $userData['userTagName'];?>
													</option>

													<?php
													$uniqueUsers2[] = $userData['userId'];
												}
											}

										}		
										?>
									</select>	
            					</p>

            					<input type="checkbox" name="startCheck" onclick="calendarStartCheck(this,document.frmCal)" <?php if($_SESSION['taskFromDate'] != '') { echo 'checked="checked"'; } ?>/>		

                				<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" id="fromDate" readonly="readonly" size="10" value="<?php if($_SESSION['taskFromDate'] != '') { echo $_SESSION['taskFromDate']; } ?>">

                    			<input type="checkbox" name="endCheck" onclick="calendarEndCheck(this,document.frmCal)" <?php if($_SESSION['taskToDate'] != '') { echo 'checked="checked"'; } ?>/>	

								<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" name="toDate" id="toDate" readonly="readonly" size="10" value="<?php if($_SESSION['taskToDate'] != '') { echo $_SESSION['taskToDate']; } ?>">

                   				<p>

                    				<?php echo $this->lang->line('txt_Completion_Status');?>:&nbsp;<input type="checkbox" id="completion0" name="completionStatus[]" onclick="disableAny();" value="0" <?php if(in_array(0,$completionStatus)) { echo 'checked'; }?>>0% &nbsp;&nbsp;&nbsp; <input type="checkbox" id="completion25" name="completionStatus[]" onclick="disableAny();" value="1" <?php if(in_array(1,$completionStatus)) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="checkbox" id="completion50" name="completionStatus[]" onclick="disableAny();" value="2" <?php if(in_array(2,$completionStatus)) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="checkbox" id="completion75" name="completionStatus[]" onclick="disableAny();" value="3" <?php if(in_array(3,$completionStatus)) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="checkbox" id="completion100" name="completionStatus[]" onclick="disableAny();" value="4" <?php if(in_array(4,$completionStatus)) { echo 'checked'; }?>>Completed &nbsp;&nbsp;<input type="checkbox" id="any" name="completionStatus[]" value="5" <?php if(!in_array(0,$completionStatus) && !in_array(1,$completionStatus) && !in_array(2,$completionStatus) && !in_array(3,$completionStatus) && !in_array(4,$completionStatus)) { echo 'checked'; }?>>Any

                				</p>
                    		</span>

                    		<p>
                    			<input type="checkbox" name="showAll" onclick="showHideAllOptions(this,document.frmCal);" <?php if ($this->input->post('showAll')=='on') {echo 'checked';}?>/><?php echo $this->lang->line('txt_Show_All_Tasks');?>
                			</p>

                    		<p>
								<?php echo $this->lang->line('txt_Sort_by');?>: 
								<select name="taskSort" id="taskSort">
									<?php /* if($this->input->post('showAll')!='on'){?>
			                        <option value="1" <?php if($sortBy == 1) { echo 'selected'; } ?>>Date Asc</option>

									<option value="2" <?php if($sortBy == 2) { echo 'selected'; } ?>>Date Desc</option>
									
									<?php } */?>

	                        		<option value="3" <?php if($sortBy == 3) { echo 'selected'; } ?>>A - Z</option>

									<option value="4" <?php if($sortBy == 4) { echo 'selected'; } ?>>Z - A</option>
                    			</select>
							</p>

                   			<input type="hidden" name="searched" value="searched">

                    		<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="buttonLogin">

                     		<!--<input type="button" onclick="$('#frmCal').trigger('reset');" class="buttonLogin" value="Clear">-->	
							<input type="button" onclick="resetTaskSearchForm($('#frmCal')); " class="buttonLogin" value="Clear">
                    	</form>

            		</td>
          		</tr> 
            </table>


			<div id="taskSearchResults">
				<?php	
				$totalNodes = array();
				//echo "<li>count= " .count($discussionDetails);	
				//echo "<li>today= " .$today;
	
				if($this->input->post('Go') != '' && count($discussionDetails) > 0)
				{	
					$count=0;		
					//print_r($arrNodeIds);	 

					foreach($discussionDetails as $keyVal=>$arrVal)
					{	
						//echo "<li>count= " .$arrVal['nodeId'];
						$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);	

						$nodeBgColor = '';

						$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);
			
						$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
			
						$contributorsTagName		= array();

						$contributorsUserId			= array();
			
						foreach($contributors  as $userData)
						{
							$contributorsTagName[] 	= $userData['userTagName'];
							$contributorsUserId[] 	= $userData['userId'];
						}		
			
						$assigned = 1;
			
						if (!empty ($assigned_to))
						{
							if (!in_array($assigned_to, $contributorsUserId))
							{
								$assigned = 0;
							}
						}				

						if ($completionStatus!=0)
						{
							$taskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);
								if ($completionStatus==$taskStatus && in_array($arrVal['nodeId'], $arrNodeIds))
								//if ($completionStatus==$taskStatus)
								{
									$nodeBgColor = 'nodeBgColorSelect';			
									$totalNodes[] = $arrVal['nodeId'];	
								}	
						}
						else if(in_array($arrVal['nodeId'], $arrNodeIds))
						//else
						{				
							$nodeBgColor = 'nodeBgColorSelect';			
							$totalNodes[] = $arrVal['nodeId'];					
						}

						$taskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

						if ($completionStatus==$taskStatus && in_array($arrVal['nodeId'], $arrNodeIds) && $arrVal['successors']==0)
						//if ($completionStatus==$taskStatus && $arrVal['successors']==0)
						{

							$nodeBgColor = 'nodeBgColor';			

							$totalNodes[] = $arrVal['nodeId'];	

						}	

				

						if (!($checksucc) && ($arrVal['userId']==$originator || $originator==0) && in_array($arrVal['nodeId'],$arrNodeIds) && $assigned)
						//if (!($checksucc) && ($arrVal['userId']==$originator || $originator==0))
						{
							//echo "<li>nodeId= " .$arrVal['nodeId'];
							$count++;

							/*Commented by Dashrath- Comment old code and new code below for new ui*/
							//$nodeBgColor = ($count%2)?'row1':'row2';

							/*Added by Dashrath- add code for new ui*/
							$nodeBgColor = ($count%2)?'seedBackgroundColorNew':'seedBackgroundColorNew';
							/*Dashrath- code end*/

							?>				
							<div class="<?php echo $nodeBgColor;?> views_div searchTaskResultDiv">
								<?php		
								$start_date = substr ($arrVal['starttime'],0,10);	

								$end_date = substr ($arrVal['endtime'],0,10);	

								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

								//if ( (!$checksucc) && ($start_date==$today) && ($end_date==$today))
								if ( (!$checksucc) && ($start_date<=$today) && ($end_date>=$today))
								{
									//echo "<li>starttime1= " .$arrVal['starttime'];
									//echo "<li>endtime1= " .$arrVal['endtime']; 
									$count++;
									?>
									<span>
										<?php
										if ($checksucc)
										{
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250);*/
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250)); 
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	}
												?> 
											</a>
											<?php

											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';

											$lastnode = $arrVal['nodeId'];

										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
										
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250);*/
												if($arrVal["leafStatus"] !='deleted'){  
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php
											echo '</div>';

											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a></div>';

											$lastnode = $arrVal['nodeId'];						
										}
										?>
									</span>
									<?php
								}
								//else if ((!$checksucc) && ($start_date==$today) && ($end_date!=$today))
								else if ((!$checksucc) && ($start_date<=$today) && ($end_date!=$today))
								{
									//echo "<li>starttime2= " .$arrVal['starttime'];
									//echo "<li>endtime2= " .$arrVal['endtime']; 
									$count++;
									?>
									<span>
										<?php 
										if ($checksucc)
										{	
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php

											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];
										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 
												if($arrVal["leafStatus"] !='deleted'){
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ 
												?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];							
										}
										?>
									</span>
									<?php		
								}
								//else if ((!$checksucc) && ($start_date!=$today) && ($end_date==$today))
								else if ((!$checksucc) && ($start_date!=$today) && ($end_date>=$today))
								{
									//echo "<li>starttime3= " .$arrVal['starttime'];
									//echo "<li>endtime3= " .$arrVal['endtime']; 
									$count++;
									?>	
									<span>
										<?php
										if ($checksucc)
										{
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/
												if($arrVal["leafStatus"] !='deleted'){  
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ ?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php
											//echo '<a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';

											$lastnode = $arrVal['nodeId'];

										}
										else
										{
											/*Changed by Dashrath- Remove width:87% from div inline css*/
											echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
											?>
											<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
												<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/ 
												if($arrVal["leafStatus"] !='deleted'){ 
													echo stripslashes(substr($arrVal['contents'],0,250));
												}
												else{ ?>
										            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
										        <?php 
										    	} 
												?> 
											</a>
											<?php
											echo '</div>';
											//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';

											$lastnode = $arrVal['nodeId'];						
										}
										?>
									</span>
									<?php			
								}	
								else
								{
									//echo "<li>starttime4= " .$arrVal['starttime'];
									//echo "<li>endtime4= " .$arrVal['endtime'];
									/*Changed by Dashrath- Remove width:87% from div inline css*/ 
									echo '<div style="float:left;width:3%" class="searchTaskCompleteStatusIcon"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;">';
									?>
									<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> 
										<?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],250,1);*/  
										if($arrVal["leafStatus"] !='deleted'){
											echo stripslashes(substr($arrVal['contents'],0,250));
										}
										else{ ?>
								            <p class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></p> 
								        <?php 
								    	}
										?> 
									</a>
									<?php
									echo '</div>';
									//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a style="text-decoration:none;color:#000;" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a></div>';
			
									$lastnode = $arrVal['nodeId'];
								}
								?>
							
			
								<div class="clr"></div>
								<div class="userLabel">
									<?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> 
								</div>

								<!--Commented by Dashrath- Comment this code for shift below-->
								<!-- <?php
					            if(!$checksucc && count($contributorsTagName)>0)

					            {

					            ?>

					                

					                    <?php echo '<span class="style1" style="display:block;margin-left:2%;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>

					               

					            <?php

					            }
								
					            ?>
					 			-->
								<?php
								if(!$checksucc)
								{
									//echo "<li>starttime= " .$arrVal['starttime'];
									//echo "<li>endtime= " .$arrVal['endtime']; 
									if($arrVal['starttime'][0] != '0')
									{
										?>
										<span class="style1" style="margin-left:2%;">
											<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>
										</span>
										<?php
									}

									if($arrVal['endtime'][0] != '0')
									{
										?>
										<span class="style1" style="margin-left:2%;">
											<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;
										</span>
										<?php
									}
								}
								else
								{
									if($subListTime['listStartTime'] != '')
									{
										?>
					                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
					                    <?php
					                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
					                    <?php
									}

									if($subListTime['listEndTime'] != '')
									{
										?>
										&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">
										<?php
										echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
										<?php
									}
								}
								?>

								<!--Added by Dashrath- shift from above-->
								<?php
					            if(!$checksucc && count($contributorsTagName)>0)
					            {
					            	?>
					                <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>
					            	<?php
					            }
					            ?>
					            <!--Dashrath- code end-->

					        </div>
			
							<!--Added by Dashrath- Add for div seperater in new ui-->
							<div class="treeLeafRowStyle2"></div>
							<!--Dashrath- code end-->
							<?php
						}	

					}
					?>

					<?php
					if ($count == 0)
					{
					?>
						<hr><?php echo $this->lang->line('txt_No_Tasks_Found');?>		
			        <?php
					}
				}
				?>
			</div>
		</span>
	</div>
	<!--right sidebar div end-->

	<!--Added by Dashrath- load notification side bar-->
    <?php $this->load->view('common/notification_sidebar.php');?>
    <!--Dashrath- code end-->
</div>
<!--container div end-->

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

</body>

</html>	

<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>
<?php $this->load->view('common/datepicker_js.php');?>
<script>
showTaskSearch();

	if ($('input[id="completion0"]:checked').length == 0 && $('input[id="completion25"]:checked').length == 0 && $('input[id="completion50"]:checked').length == 0 && $('input[id="completion75"]:checked').length == 0 && $('input[id="completion100"]:checked').length == 0)
	{
		
		$("#any").attr("disabled", false);	
		$("#any").prop( "checked" ,true);
	}
	else
	{
		$("#any").attr("checked", false);
		$("#any").attr("disabled", true);
	}
</script>

<script>
$(window).scroll(function(){
      // if ($(this).scrollTop() > 60) {
      //     $('#divSeed').addClass('documentTreeFixed');
      // } else {
      //     $('#divSeed').removeClass('documentTreeFixed');
      // }

      //call addAndRemoveClassOnSeed function
	  addAndRemoveClassOnSeed($(this).scrollTop());
  });
</script>