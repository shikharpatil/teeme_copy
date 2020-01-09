<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<?php $this->load->view('common/datepicker_js.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

	

	

$(function() {

	

	$('#fromDate').datepicker({dateFormat: "dd-mm-yy"});

	$('#toDate').datepicker({dateFormat: "dd-mm-yy"});





});

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

</script>



<script language="JavaScript1.2">mmLoadMenus();</script>

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
			<!-- Main menu -->

			<?php

			//$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

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

			

					<span id="tagSpan"></span>

	<?php
	$_SESSION['taskSearchDate'] 	= 0;
	$_SESSION['taskFromDate'] 	= '';
	$_SESSION['taskToDate'] 	= '';	
//echo "<li>searchDate= " .$this->input->post('searchDate');	

//echo "<li>taskSearchDate= " .$_SESSION['taskSearchDate'];

if($this->input->post('searchDate') != '')

{

	$_SESSION['taskSearchDate'] = $this->input->post('searchDate');

	if($this->input->post('searchDate') == 0)

	{	

		if($this->input->post('fromDate') != '')

		{

			$sd1 = explode("-",$this->input->post('fromDate')); 

			$searchDate1	= $sd1[2]."-".$sd1[1]."-".$sd1[0];
			
			$_SESSION['taskFromDate'] 	= $searchDate1;
			
		}
		
		if($this->input->post('toDate') != '')

		{					

			$sd2 = explode("-",$this->input->post('toDate'));

			$searchDate2	= $sd2[2]."-".$sd2[1]."-".$sd2[0];

			$_SESSION['taskToDate'] 	= $searchDate2;		

		}

	}

}

else if(isset($_SESSION['taskSearchDate']) && $_SESSION['taskSearchDate'] != '')

{

	$_SESSION['taskSearchDate'] = $_SESSION['taskSearchDate'];

	if($_SESSION['taskSearchDate'] == 0)

	{	

		if($_SESSION['taskFromDate'] != '')

		{

			$searchDate1	= $_SESSION['taskFromDate'];
		

		}
		
		if($_SESSION['taskToDate'] != '')

		{


			$searchDate2	= $_SESSION['taskToDate'];					

		}

	}

}

else

{

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

	$_SESSION['taskSearchDate'] 	= 1;

	$_SESSION['taskFromDate'] 	= '';

	$_SESSION['taskToDate'] 		= '';

}

//echo "<li>taskSearchDate= " .$_SESSION['taskSearchDate'];

if($_SESSION['taskSearchDate'] == 0)

{	

		if($_SESSION['taskFromDate'] != '')

		{

			$searchDate1	= $_SESSION['taskFromDate'];
		

		}
		
		if($_SESSION['taskToDate'] != '')

		{


			$searchDate2	= $_SESSION['taskToDate'];					

		}

}



if($_SESSION['taskSearchDate'] == 1)

{

	/*Changed by Surbhi IV */

	/*$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));*/

	$searchDate1	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d')-1,date('Y')));

	$searchDate2	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d'),date('Y')));

    /*End of Changed by Surbhi IV */

}	

if($_SESSION['taskSearchDate'] == 2)

{		

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));

}	

if($_SESSION['taskSearchDate'] == 3)

{		

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1)-7,date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N'))-7,date('Y')));

}

if($_SESSION['taskSearchDate'] == 4)

{

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y')));

}

if($_SESSION['taskSearchDate'] == 5)

{

	$lastDayOfMonth = date('t',mktime(0,0,0,date('m')-1,1,date('Y')));

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m')-1,$lastDayOfMonth,date('Y')));	 

}





$sortUrl = base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/2';
$arrNodeIds = array();

//echo "<li>sd1= " .$searchDate1;
//echo "<li>sd2= " .$searchDate2;
	if ($searchDate1!='' || $searchDate2!='')
	{
		$arrNodeIds = $this->identity_db_manager->getNodesByDateTimeView($treeId, $searchDate1, $searchDate2);	
	}
$arrDetails['arrNodeIds'] = $arrNodeIds;

//print_r($arrNodeIds);die;



?>

<form name="frmCal" action="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">

<?php

$day 	= date('d');

$month 	= date('m');

$year	= date('Y');	

?>



				<div class="menu_new" >

            <ul class="tab_menu_new">

				<li class="task-view"><a class="1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>

				<li class="time-view_sel"><a class="active"  href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"  title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				

				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"  title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

						

    			<li class="link-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>	

				

				<li class="talk-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

				

				<li class="task-calendar"><a  href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar_View');?>"  ></a></li>

				

                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" ></a></li>

				

				 

				

					

            	<?php

				if (($workSpaceId==0))

				{

				?>

                  <li  class="share-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6" title="<?php echo $this->lang->line('txt_Share');?>"></a></li>

                <?php

				}

				?>

				

				<li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li>
				
														<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='task';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>

            </ul>

			<div class="clr"></div>

        </div>



 

           

		   <table width="100%">

          <tr>

          	<td colspan="4" align="left" valign="top" class="tdSpace">

            <?php

			if($this->input->post('Go') != '' )

			{

			?>

			<select name="searchDate" id="searchDate" onChange="getTimingsCal(this)">

				<option value="0" <?php if($_SESSION['taskSearchDate'] == 0 || $this->input->post('fromDate') != '' || $this->input->post('toDate') != '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select'); ?></option>

				<option value="1" <?php if($_SESSION['taskSearchDate'] == 1 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Today'); ?></option>

				<option value="2" <?php if($_SESSION['taskSearchDate'] == 2 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Week'); ?></option>

				<option value="3" <?php if($_SESSION['taskSearchDate'] == 3 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('last_week'); ?></option>

				<option value="4" <?php if($_SESSION['taskSearchDate'] == 4 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Month'); ?></option>

				<option value="5" <?php if($_SESSION['taskSearchDate'] == 5 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('last_month'); ?></option>

			</select>

            	<?php 

				if($this->input->post('searchDate') == 0 )

				{

					?>

				  &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" id="fromDate" size="10" value="<?php if($_SESSION['taskFromDate'] != '') { echo $this->input->post('fromDate'); } ?>" onchange="clearSearchDropdown()" readonly="">

				<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" name="toDate" id="toDate" size="10" value="<?php if($_SESSION['taskToDate'] != '') { echo $this->input->post('toDate'); } ?>"  onchange="clearSearchDropdown()" readonly="">

				&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

					<?php

				}

				else

				{

					?>

				  &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" size="10"   id="fromDate" onchange="clearSearchDropdown()" readonly="">				<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" name="toDate" size="10"   id="toDate" onchange="clearSearchDropdown()" readonly="">

				&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

					<?php

				}

				?>

             <?php

			 }

			 else

			 {

			 ?>

			<select name="searchDate" onChange="getTimingsCal(this)">

				<option value="0"><?php echo $this->lang->line('txt_Select'); ?></option>

				<option value="1" selected="selected"><?php echo $this->lang->line('txt_Today'); ?></option>

				<option value="2"><?php echo $this->lang->line('txt_This_Week'); ?></option>

				<option value="3"><?php echo $this->lang->line('last_week'); ?></option>

				<option value="4"><?php echo $this->lang->line('txt_This_Month'); ?></option>

				<option value="5"><?php echo $this->lang->line('last_month'); ?></option>

			</select>

              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" size="10"   id="fromDate" onchange="clearSearchDropdown()" readonly="">			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" name="toDate" size="10"   id="toDate" onchange="clearSearchDropdown()" readonly="">

			&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

             <?php

			 }

			 ?>

			</td>

          </tr>

     </table>

 



</form>


	<?php	

	$totalNodes = array();

	//print_r ($discussionDetails);

	if(count($discussionDetails) > 0)

	{		 

	

		$i=1;		 

		foreach($discussionDetails as $keyVal=>$arrVal)

		{	 

			$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);

			$contributorsTagName		= array();

			$contributorsUserId			= array();

			

			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);

			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);

			$checksucc 				= $this->task_db_manager->checkSuccessors($arrVal['nodeId']); 

			foreach($contributors  as $userData)

			{

				$contributorsTagName[] 	= $userData['userTagName'];

				

			}

			

			$nodeBgColor = '';

			if(in_array($arrVal['nodeId'], $arrNodeIds))

			{				

				//$nodeBgColor = 'nodeBgColorSelect1';			

				$nodeBgColor = 'seedBgColor';

				$totalNodes[] = $arrVal['nodeId'];					

			}



			if (!empty($nodeBgColor))

			{



				$nodeBgColor = ($i%2)?'row1':'row2';

?>				

   			

    <div class="<?php echo $nodeBgColor?> views_div">

         <div style="float:left;width:3%">   

        	<?php /*if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i; }*/	?>



			<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">

		

	</div>

		 <div style="float:left;width:97%;text-align:justify" > 
		 
					<a style="text-decoration:none; color:#000;vertical-align:top;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> <?php echo stripslashes($arrVal['contents']); ?> </a>

	<?php //echo stripslashes($arrVal['contents']);

			//echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;vertical-align:top;">'.strip_tags($arrVal['contents']).'</a>';

			$lastnode = $arrVal['nodeId'];

	

	?>		

	</div>

	<div class="userLabel">		
	<?php 
  		echo  $userDetails1['userTagName']."&nbsp;&nbsp;";



		if($arrVal['editedDate'][0]==0)

		{ 

			echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));

		}	

		else

		{

			echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));

		}	

		?></div><?php

		echo '<br/><span class="style1">'.$userDetails['userTagName'].'</span> ';



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

                

                    <?php echo '<span class="style1" style="display:block; margin-left:3%; color:#999999; font-style:italic; font-size:0.8em;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>

               

            <?php

            }

            ?>

            

        <!--  		

        <div id="detail<?php echo $arrVal['nodeId'];?>"> 

            <?php echo $userDetails1['userTagName'];?> 

        </div>-->

     <div class="clr"></div>

			</div> 

		<?php

		}

		$i++;

		}

	}

 

?>



     <input type="hidden" id="totalNodes" name="totalNodes" value="<?php echo implode(',', $totalNodes);?>">

			

              

        

   

</div>

</div>

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

<?php $this->load->view('common/datepicker_js.php');?>

</body>
</html>	
<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>