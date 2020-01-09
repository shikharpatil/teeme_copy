<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

<script>

$(document).ready(function(){
		//Manoj: showing mobile datepicker when add action tag 
		$("#dtBoxSearch").DateTimePicker({
			dateFormat: "yyyy-MM-dd"
		});
		
		//Change dropdown value when 'From or To' date selected
		
		$("#from_date").focus(function() {
			document.frmCal.searchDate.value = 0;
		});
		
		$("#to_date").focus(function() {
			document.frmCal.searchDate.value = 0;
		});
});

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

<?php $this->load->view('common/header_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile">



		<div id="content">

        

			<!-- Main menu -->

			<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

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

//echo "<li>searchDate= " .$this->input->post('searchDate');	

//echo "<li>taskSearchDate= " .$_SESSION['taskSearchDate'];

if($this->input->post('searchDate') != '')

{

	$_SESSION['taskSearchDate'] = $this->input->post('searchDate');

	if($this->input->post('searchDate') == 0)

	{	

		if($this->input->post('fromDate') != '')

		{

			$searchDate1	= $this->input->post('fromDate');

			$_SESSION['taskFromDate1'] 	= $this->input->post('fromDate');

			
		}
		
		if($this->input->post('toDate') != '')

		{					

			
			$searchDate2	= $this->input->post('toDate');

			$_SESSION['taskToDate1'] 	= $this->input->post('toDate');	
			

		}

	}

}

else if(isset($_SESSION['taskSearchDate']) && $_SESSION['taskSearchDate'] != '')

{
	
	$_SESSION['taskSearchDate'] = $_SESSION['taskSearchDate'];

	if($_SESSION['taskSearchDate'] == 0)

	{	

		if($_SESSION['taskFromDate1'] != '')

		{

			$searchDate1	= $_SESSION['taskFromDate1'];

		}
		
		if($_SESSION['taskToDate1'] != '')

		{

			$searchDate2	= $_SESSION['taskToDate1'];					

		}

	}
	
}

else

{

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

	$_SESSION['taskSearchDate'] 	= 1;

	$_SESSION['taskFromDate1'] 	= '';

	$_SESSION['taskToDate1'] 		= '';
	
	

}

//echo "<li>taskSearchDate= " .$_SESSION['taskSearchDate'];

if($_SESSION['taskSearchDate'] == 0)

{	
	
	if($_SESSION['taskFromDate1'] != '')

	{

		$searchDate1	= $_SESSION['taskFromDate1'];

		$searchDate2	= $_SESSION['taskToDate1'];

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
	if ($searchDate1!='' || $searchDate2!='')
	{

		$arrNodeIds = $this->identity_db_manager->getNodesByDateTimeView($treeId, $searchDate1, $searchDate2);	

	}
$arrDetails['arrNodeIds'] = $arrNodeIds;





?>

<form name="frmCal" action="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">

<?php

$day 	= date('d');

$month 	= date('m');

$year	= date('Y');	

?>



				<div class="menu_new" >
				
				<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait task_tab_for_potrait">
			
				<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</ul>
        <!--follow and sync icon code end -->

				

            <ul class="tab_menu_new_for_mobile task_tab_menu_for_mob">
			
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

				<div class="tab_for_landscape task_tab_for_landscape">

				<?php /*?><li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li><?php */?>
				
				<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
</div>
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

              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?> <br /><?php echo $this->lang->line('txt_From_Date');?>:&nbsp; 
			  <?php /*?><input type="text" name="fromDate" size="10" value="<?php if($_SESSION['taskFromDate1'] != '') { echo $_SESSION['taskFromDate1']; } ?>"
	readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			<!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date" value="<?php if($_SESSION['taskFromDate1'] != '') { echo $this->input->post('fromDate'); } ?>"  readonly>  
					<div id="dtBoxSearch"></div>
					<!--Manoj:end-->
	&nbsp;&nbsp;<br />

			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*?><input type="text" name="toDate" size="10" value="<?php if($_SESSION['taskToDate1'] != '') { echo $_SESSION['taskToDate1']; } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
			       <!--Manoj:Added to date input field-->
				   <input name="toDate" type="text" size="10" data-field="date" id="to_date" value="<?php if($_SESSION['taskToDate1'] != '') { echo $this->input->post('toDate'); } ?>" readonly> 
				   <!--Manoj: code end-->

			&nbsp;&nbsp;<br /><input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

                <?php

				}

				else

				{

				?>

              &nbsp;&nbsp;<?php //echo $this->lang->line('txt_Or');?><br /><?php echo $this->lang->line('txt_From_Date');?>:&nbsp; 
			  <?php /*?><input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			  <!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date" value="<?php if($_SESSION['taskFromDate1'] != '') { echo $this->input->post('fromDate'); } ?>" readonly>  
					<div id="dtBoxSearch"></div>
			  <!--Manoj:end-->
			  &nbsp;&nbsp;<br />

			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
			<!--Manoj:Added to date input field-->
				   <input name="toDate" type="text" size="10" data-field="date" id="to_date" value="<?php if($_SESSION['taskToDate1'] != '') { echo $this->input->post('toDate'); } ?>" readonly> 
			<!--Manoj: code end-->
			&nbsp;&nbsp;<br/><input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

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

              &nbsp;&nbsp;<span><?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp; </span><br />
			  <div style="margin-top:4%;">
			  <?php echo $this->lang->line('txt_From_Date');?>:&nbsp; 
			  <?php /*?><input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			   	<input name="fromDate" type="text" size="10" data-field="date" id="from_date"  readonly>  
					<div id="dtBoxSearch"></div>
					</div>
			  &nbsp;&nbsp;<br />
<div>
			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'><img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
				   <input name="toDate" type="text" size="10" data-field="date" id="to_date" readonly> 
				   </div>
			<br />

			<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

             <?php

			 }

			 ?>

			</td>

          </tr>

     </table>



</form>



<table width="100%" border="0" cellspacing="0" cellpadding="0" >

      <?php 

	if($arrDiscussionDetails['name'] != 'untitled')

	{



	?>

      <tr>

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">

		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">

		  <tr class="seedBgColor">

			   

			    <td height="21" align="left" ><strong> <?php echo $arrDiscussionDetails['name'];?></strong></td>

			   

	      </tr>

		  </table>		

          </td>

        </tr>

	<?php



	}

	?>

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





?>				

      <tr>

       

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">		

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

			

			  <tr>

				

				<td width="90%"> 

	

<table width="100%">

<tr class="<?php echo $nodeBgColor;?>">

<td>

<div style="width:100%; margin-top: 2%;">

	 <div style=" float:left; padding:0% 5.5%" class="<?php echo $nodeBgColor;?>">   

    	
			<?php if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i; }	?>



			&nbsp;&nbsp;<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
			
			<?php //echo stripslashes($arrVal['contents']);

			echo '<a class="treeLeafView" href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'#taskLeafContent'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;vertical-align:top;">'.stripslashes(substr($arrVal['contents'],0,250)).'</a>';

			$lastnode = $arrVal['nodeId'];

	

	?>		

		

	</div>

	<?php /*?><div style="float:left;width:850px; margin-top:7px; " > 

	<?php //echo stripslashes($arrVal['contents']);

			echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;vertical-align:top;">'.$arrVal['contents'].'</a>';

			$lastnode = $arrVal['nodeId'];

	

	?>		

	</div><?php */?>

	<div class="clr"></div>

	</div>

			

		<?php 	

			?>

			

			

	<div style="width:89%; float:left; font-size:0.8em; padding:0% 5.5%;" class="<?php echo $nodeBgColor;?>">
<div>
<?php 


echo  $userDetails1['userTagName'];
if(strlen($userDetails1['userTagName'])>21)
{

?>
</div>
<div>
<?php
}

		if($arrVal['editedDate'][0]==0)

		{ 

			echo ' '.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));

		}	

		else

		{

			echo ' '.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));

		}	







echo '<br/><span class="style1">'.$userDetails['userTagName'].'</span>';
?>
</div>
<?php
if(!$checksucc)

{

	

	if($arrVal['starttime'][0] != '0')

	{

	?>

		

		<div class="style1" style="width:100%; margin-top: 2%;">
			<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start');?>"   />
			<?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>

		</div>
		

	<?php

	}

	if($arrVal['endtime'][0] != '0')

	{

	?>

		

		<div class="style1"  style="width:100%;">
		<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End');?>" />
		<?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;
		</div>

	<?php

	}

}

else

{

	if($subListTime['listStartTime'] != '')

	{

		?>

	<div class="style1"  style="width:100%; margin-top: 2%;">
	<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start');?>"   />
	<?php
		
		echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?>
		
	</div>

	<?php

	}

	if($subListTime['listEndTime'] != '')

	{

		?>

	<div class="style1"  style="width:100%;">
	<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End');?>" />
	<?php

		echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?>
	
	</div>

	<?php

	}

	

}

?>

    

<?php

if(!$checksucc)

{

?>

    
<!--Manoj: Added see all link if contributor value more than one-->

    	<?php 
		
			echo '<div class="style1" style="display:block; margin-top: 2%; margin-bottom:2.5%;" >'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0];
		
			if(count($contributorsTagName)>1)
			 {
			 	?>
				<a id="seeAll<?php echo $arrVal['nodeId']; ?>" style="padding: 0 4%; " onclick="show_assignee(<?php echo $arrVal['nodeId']; ?>)">See all..</a>
			  <?php
			  // echo implode(', ',$contributorsTagName);
			 }
		?>
		</div>
		<div class="style2<?php echo $arrVal['nodeId']; ?>" style="display:none; "  >
			<?php
			
			   array_shift($contributorsTagName);
			   echo implode(', ',$contributorsTagName);
			?>
			
		</div>
<!--Manoj : code end-->
   

<?php

}

?>



</div>					

		<?php			

			//echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));

						

	?>

</td>

</tr>

</table>

				

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $arrVal['nodeId'];?>" style="display:none;">

  <tr>

    <td align="left" colspan="2"><span class="style1">



<?php echo $userDetails1['userTagName'];?>&nbsp;&nbsp;&nbsp;&nbsp; 

</td>

  

  </tr>



</table>

				

		

				</td>

				

			  </tr>

			</table>		

            </td>

        </tr>

     

 

		<?php

		}

		$i++;

		}

	}

 

?>



     <tr>

        <td align="left" valign="top" bgcolor="#FFFFFF"><input type="hidden" id="totalNodes" name="totalNodes" value="<?php echo implode(',', $totalNodes);?>"></td>

        <td align="left" valign="top" bgcolor="#FFFFFF"></td>

        <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>

      </tr>



    </table>

	

			

              

        

   

</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>	

<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>