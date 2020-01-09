<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script> 	

	 <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></LINK>

	<SCRIPT type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>

</head>

<body>

<script language="JavaScript1.2">mmLoadMenus();</script>

<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">

  <tr>

    <td valign="top">

        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td align="left" valign="top">

			<!-- header -->	

			<?php $this->load->view('common/header'); ?>

			<!-- header -->	

			</td>

          </tr>

          <tr>

            <td align="left" valign="top">

				<?php $this->load->view('common/wp_header'); ?>

			</td>

          </tr>

          <tr>

            <td align="left" valign="top">

			<!-- Main menu -->

			<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

			 $this->load->view('common/artifact_tabs', $details); ?>

			<!-- Main menu -->	

			</td>

          </tr>

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="76%" height="8" align="left" valign="top"></td>

                  <td width="24%" align="left" valign="top"></td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<span id="tagSpan"></span>

	<script>

function changeNav(curNav)

{	

	var leftNavVal 	= parseInt(document.getElementById('topLeftNav').value);

	var rightNavVal = parseInt(document.getElementById('topRightNav').value);

	var totalNavVal = parseInt(document.getElementById('totalNav').value);

	var leftImgId 	= 'navLeftImg';	

	var rightImgId 	= 'navRightImg';

	if(curNav == 1)

	{

		document.getElementById('curNav').style.display = 'none';

		//alert(leftNavVal);			

		document.getElementById('topRightNav').value = (parseInt(leftNavVal)+1);

		document.getElementById(rightImgId).style.display = '';	

		if(leftNavVal > 1)

		{

			document.getElementById('topLeftNav').value = leftNavVal-1;	

			for(var i=1; i<=totalNavVal;i++)

			{

				

				if(i == leftNavVal)

				{						

					document.getElementById('nav'+i).style.display = '';

				}	

				else

				{	

					document.getElementById('nav'+i).style.display = 'none';

				}		

			}						

		}	

		else

		{

			for(var i =1; i<=totalNavVal;i++)

			{

				if(i == leftNavVal)

				{	

					document.getElementById('nav'+i).style.display = '';

				}	

				else

				{	

					document.getElementById('nav'+i).style.display = 'none';

				}		

			}			

			document.getElementById(leftImgId).style.display = 'none';			

		}

	}

	else if(curNav == 2)

	{		

		document.getElementById('topLeftNav').value = rightNavVal-1;

		document.getElementById(leftImgId).style.display = '';	

		if(rightNavVal < totalNavVal)

		{

			document.getElementById('topRightNav').value = rightNavVal+1;

			for(var i =1; i<=totalNavVal;i++)

			{

				if(i == rightNavVal)

				{	

					document.getElementById('nav'+i).style.display = '';

				}	

				else

				{	

					document.getElementById('nav'+i).style.display = 'none';

				}		

			}			

		}	

		else

		{

			for(var i =1; i<=totalNavVal;i++)

			{

				if(i == rightNavVal)

				{	

					document.getElementById('nav'+i).style.display = '';

				}	

				else

				{	

					document.getElementById('nav'+i).style.display = 'none';

				}		

			}			

			document.getElementById(rightImgId).style.display = 'none';

		}

	}		

			

	

}

function addActivity(id, nodeId)

{

	divid='add_activity'+id;

	document.getElementById(divid).style.display='';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

	//parent.frames[id].gk.EditingArea.focus();

	rameid=id;	

}

function addActivityClose(id, nodeId)

{

	divid='add_activity'+id;

	document.getElementById(divid).style.display='none';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='';

	

}

function validate_activity(replyDiscussion,formname){

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	/*replyDiscussion1=replyDiscussion+'1';

	if(document.getElementById(replyDiscussion1).value=='<DIV id=1-span><P>&nbsp;</P></DIV>'){

		error+='Please Enter your reply for discussion.\n';

	}*/

	

	if(formname.titleStatus.value == 1)

	{

		if(trim(formname.title.value) =='' )

		{

			jAlert('<?php echo $this->lang->line('enter_title'); ?>');

			formname.title.focus();			

		}

		else		

		{

			formname.submit();

		}

	}

	else

	{

		if(formname.starttime.value!='' && formname.endtime.value!='' ){

			/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

				error+=' Please check start time and end time.';

			}*/

		}

		if(error==''){

			formname.submit();

		}else{

			jAlert(error);

		}

	}

	

}	



function calStartCheck(thisVal, pos, formName)

{

	var callStartId = 'calStart'+pos;

	if(thisVal.checked == true)

	{			

		document.getElementById(callStartId).style.display = "";	

		formName.starttime.style.color = "#000000";	

		formName.starttime.style.backgroundColor = "#FFFFFF";	

	}

	else

	{		

		document.getElementById(callStartId).style.display = 'none';

		formName.starttime.style.color = "#626262";	

		formName.starttime.style.backgroundColor = "#CCCCCC";	

	}

}

function calEndCheck(thisVal, pos, formName)

{

	var callEndId = 'calEnd'+pos;	

	if(thisVal.checked == true)

	{		

		document.getElementById(callEndId).style.display = '';

		formName.endtime.style.color = "#000000";	

		formName.endtime.style.backgroundColor = "#FFFFFF";	

	}

	else

	{		

		document.getElementById(callEndId).style.display = 'none';

		formName.endtime.style.color = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

	}

}

	var mystart='<?php echo $this->time_manager->getUserTimeFromGMTTime($arrparent['starttime'], 'Y-m-d h:i A');?>';

	var myend='<?php echo $this->time_manager->getUserTimeFromGMTTime($arrparent['endtime'], 'Y-m-d h:i A');?>';

	function changes_date(newsdate,newedate){

		mystart=newsdate;

		myend=newedate;

	}

	function compareDates (dat1, dat2) {

   var date1, date2;

   var month1, month2;

   var year1, year2;

	 value1 = dat1.substring (0, dat1.indexOf (" "));

	  value2 = dat2.substring (0, dat2.indexOf (" "));

	  time1= dat1.substring (1, dat1.indexOf (" "));

	  time2= dat2.substring (1, dat2.indexOf (" "));

	  

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



	var baseUrl='<?php echo base_url();?>';

	var lastframeid=0;

	var rameid=0;

	function blinkIt() {

	 if (!document.all) return;

	 else {

	   for(i=0;i<document.all.tags('blink').length;i++){

		  s=document.all.tags('blink')[i];

		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';

	   }

	 }
	 
	 //Add SetTimeOut 
	 setTimeout("blinkIt()", 500);

	}

	function showFocus()

	{

	//setInterval('blinkIt()',500);
	
	//Add SetTimeOut 
	setTimeout("blinkIt()", 500);

	//alert(lastframeid);

		//parent.frames[lastframeid].gk.EditingArea.focus();

	

	}

	function validate_dis(replyDiscussion,formname){

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	replyDiscussion1=replyDiscussion+'1';

	/*if(document.getElementById(replyDiscussion1).value=='<DIV id=1-span><P>&nbsp;</P></DIV>'){

		error+='Please Enter your reply for discussion.\n';

	}*/

	if(formname.editStatus.value == 0)

	{

		if(formname.starttime.value!='' && formname.endtime.value!='' ){

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

	

	</script></td>

          </tr>

	  <tr>

		<td colspan="2" valign="top">

<?php

$day 	= date('d');

$month 	= date('m');

$year	= date('Y');	

?>

	<table width="100%">

          <tr>

            <td colspan="4" align="left" valign="top" class="tdSpace">

			<ul class="rtabs">

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>

				 <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>"><span><?php echo $this->lang->line('txt_Calendar_View');?></span></a></li>

            </ul>

			</td>

          </tr>

        

          <tr>

            <td colspan="4" align="left" valign="top" class="tdSpace"><hr></td>

          </tr>

          <tr>

            <td colspan="3" align="left" valign="top" class="tdSpace">

			<?php

			 

							$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrparent['nodeId'], 2);

							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrparent['nodeId'], 2);

							$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrparent['nodeId'], 2);

							$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrparent['nodeId'], 2);

							

							$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 1, 2);

							$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 2, 2);

							$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 3, 2);

							$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 4, 2);

							$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 5, 2);

							$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 6, 2);

							$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrparent['nodeId'], 2);

			if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)

				{//echo '[T]&nbsp;';

			?>

            	<img src="<?php echo base_url();?>images/tag.gif" alt="<?php echo $this->lang->line('txt_Tags');?>" title="<?php echo $this->lang->line('txt_Tags');?>" border="0">&nbsp;

			<?php

				}

			else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 

				{echo '&nbsp;&nbsp;';}}

			if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	

				{//echo '[L]&nbsp;';

			?>

            

				<img src="<?php echo base_url();?>images/link.gif" alt="<?php echo $this->lang->line('txt_Links');?>" title="<?php echo $this->lang->line('txt_Links');?>" border="0"> &nbsp;<br>

			<?php	

				}

			

			 echo $treeDetails['name'];?>			

			</td>

			<td align="right"><a href="javascript:void(0);" onClick="window.location.reload();"><img src="<?php echo base_url(); ?>images/update.gif" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a></td>	

          </tr>

          <tr>

            <td colspan="4" align="left" valign="top">

			<table width="100%">

				<tr>

				<td align="left"><a href="<?php echo base_url();?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/empty-tri.gif" alt="Home" border="0"></a>

				<?php

				$split = 20;

				$totalNodes = count($_SESSION['nodes']);

				if($totalNodes > $split)

				{

					?>

					<span id="navLeftImg"><img src="<?php echo base_url();?>images/left.gif" border="0" onClick="changeNav(1)"></span>	

					<?php	

					$nav = 1;

					for($i = 0;$i<$totalNodes; $i++)

					{

						$spanClose = 0;	

						if($i%$split == 0)

						{

						?>

							<span id="nav<?php echo $nav;?>" style="display:none;">

						<?php

							$nav++;

						}

						?>						

						<a href="<?php echo base_url();?>view_activity/node_activity/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>

						<?php			

						if(($i+1)%$split == 0)

						{

							$spanClose = 1;

						?>

							</span>

						<?php

						}

						?>			

								

					<?php	

					}	

					if($spanClose == 0)

					{

					?>

						</span>

					<?php

					}	

					?>

					<span id="curNav">

					<?php

					for($i = $totalNodes-$split;$i<$totalNodes; $i++)

					{

					?>

						<a href="<?php echo base_url();?>view_activity/node_activity/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>

					<?php	

					}

					?>

					</span>	

					<span id="navRightImg" style="display:none;"><img src="<?php echo base_url();?>images/right.gif" border="0" onClick="changeNav(2)"></span>	

				<?php	

				}

				else

				{

					for($i = 0;$i<$totalNodes; $i++)

					{

					?>

						<a href="<?php echo base_url();?>view_activity/node_activity/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>

					<?php	

					}	

				}

				?>	

				<input type="hidden" name="topLeftNav" id="topLeftNav" value="<?php echo ($nav-2);?>">	

				<input type="hidden" name="topRightNav" id="topRightNav" value="<?php echo $nav-1;?>">

				<input type="hidden" name="totalNav" id="totalNav" value="<?php echo $nav-1;?>">													

				</td>

				</tr>

			</table>

			</td>

          </tr>

     </table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" >

      

      <tr>

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">



		<?php 

				$arrTotalNodes = array();

				$arrTotalNodes[] = $arrparent['nodeId'];

				$userDetails	= $this->activity_db_manager->getUserDetailsByUserId($arrparent['userId']);

				$checkPre =$this->activity_db_manager->checkPredecessor($arrparent['nodeId']);

				$arrActivities = array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');

				$arrNodeActivityUsers 	= $this->activity_db_manager->getActivityUsers($arrparent['nodeId'], 2);

				$nodeActivityStatus 	= $this->activity_db_manager->getActivityStatus($arrparent['nodeId']);

				$contributors 				= $this->activity_db_manager->getActivityContributors($arrparent['nodeId']);

				$contributorsTagName		= array();

				$contributorsUserId			= array();	

				foreach($contributors  as $userData)

				{

					$contributorsTagName[] 	= $userData['userTagName'];

					$contributorsUserId[] 	= $userData['userId'];	

				}		

				if($arrparent['successors'])

				{

					$arrNodes = $this->activity_db_manager->getNodesBySuccessor($arrparent['successors']);					

					$allNodes = implode(',', $arrNodes);

					$listTime = $this->activity_db_manager->getSubListTime($allNodes);		

				}		



		?>

		

		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; ">

			

			  <tr>

				<td width="26">&nbsp;</td>

				<td>

				



<span id="editThis<?php echo $arrparent['leafId'];?>" style="display:none;  margin-top:0px; margin-left:20px;">

<form name="form3<?php echo $arrparent['leafId'];?>" method="post" action="<?php echo base_url();?>new_activity/leaf_edit_Activity/<?php echo $arrparent['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td> <?php echo $this->lang->line('txt_Sub_List_Title');?>:</td>

		<td>  <textarea name="editactivity<?php echo $arrparent['leafId'];?>" id="editactivity<?php echo $arrparent['leafId'];?>" rows="3" cols="35"><?php echo html_entity_decode(stripslashes($arrparent['contents']));?></textarea></td>	

	</tr>	

		<tr>

		<td>&nbsp; </td>

		<td>

<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('editactivity<?php echo $arrparent['leafId'];?>',document.form3<?php echo $arrparent['leafId'];?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close1(<?php echo $arrparent['leafId'];?>, <?php echo $arrparent['nodeId'];?>);">

		        <input name="reply" type="hidden" id="reply" value="1">

				<input name="editorname1" type="hidden"  value="editactivity<?php echo $arrparent['leafId'];?>">

				<input name="nodeId" type="hidden"  value="<?php echo $arrparent['nodeId'];?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_activity/node_activity/<?php echo $arrparent['nodeId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $arrparent['treeIds'];?>">

				<input type="hidden" name="activityId" value="<?php echo $arrparent['nodeId'];?>"> 

				<input type="hidden" name="editStatus" value="1" id="editStatus">		

		</td>	

	</tr>





</table>



	

                

		</form>

			

			

			</span>





  <span id="img<?php echo $position;?>">

<table width="100%" cellpadding="0" cellspacing="0" border="0">

	<tr><td onClick="showdetail(<?php echo $position;?>, <?php echo $arrparent['nodeId'];?>)" class="handCursor">

<span class="style1">

	<?php

	if($checkPre)

	{

		echo '<a href="'.base_url().'view_activity/node_activity/'.$checkPre.'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';

	}

	else

	{

		echo '<a href="'.base_url().'view_activity/node/'.$arrparent['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';

	}

	?>

</span>

<?php

echo html_entity_decode(stripslashes($arrparent['contents']));?>

	</td></tr>

</table>



			<div id="reply_teeme0" style="display:none;  margin-top:0px; margin-left:20px;">	<p onMouseOver="vksfun(0);">



		

		<form name="form1" method="post" action="<?php echo base_url();?>new_activity/node_new_Activity/<?php echo  $arrparent['treeIds'];?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">

<tr><td>

		<span id="vk12345"></span><?php echo $this->lang->line('txt_Activity');?>:

	</td>

	<td>

	<textarea name="replyDiscussion" id="replyDiscussion" rows="3" cols="35"></textarea>

	</td>

</tr>

	<tr>

		<td id="chat_title">		

			<?php echo $this->lang->line('txt_Start_Time');?>:

		</td>

		<td><input type="checkbox" name="startCheck" onClick="calStartCheck(this, 0, document.form1)"><input name="starttime" type="text" id="starttime0"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>

	</tr>

<tr><td>

		<?php echo $this->lang->line('txt_End_Time');?>:

	</td>

	<td>

	<input type="checkbox" name="endCheck" onClick="calEndCheck(this, 0, document.form1)"><input name="endtime" type="text" id="endtime0" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr>



	<tr>

		<td valign="top"><?php echo $this->lang->line('txt_Assignees');?></td>

		<td valign="top">

		<select name="activityUsers[]" multiple>

		<option value="<?php echo $_SESSION['userId'];?>" selected><?php echo $this->lang->line('txt_Me');?></option>

		<option value="0"><?php echo $this->lang->line('txt_All');?></option>

		<?php	

		foreach($workSpaceMembers as $arrData)

		{

			if($_SESSION['userId'] != $arrData['userId'])

			{		

			?>

				<option value="<?php echo $arrData['userId'];?>"><?php echo $arrData['tagName'];?></option>

			<?php

			}

		}		

		?>

		</select>

		</td>	

	</tr>

	<tr>

		<td  valign="top">

			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span>

		</td>

		<td  valign="top">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes">

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" checked>

			<?php echo $this->lang->line('txt_No');?>

		</td>	   

	</tr>

	<tr>

		<td>&nbsp;</td>

		<td valign="top"> 

		<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0,<?php echo $arrparent['nodeId'];?>);">

		<input name="reply" type="hidden" id="reply" value="1">

		<input name="editorname1" type="hidden"  value="replyDiscussion">

		<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

		<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

		<!--&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('replyDiscussion', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); </script>-->

		<input name="nodeId" type="hidden" value="<?php echo $arrparent['nodeId'];?>">

		<input name="treeId" type="hidden" id="treeId" value="<?php echo $arrparent['treeIds'];?>">

		<input type="hidden" name="editStatus" value="0" id="editStatus">				

		</td>		

	</tr>

</table>



	

                

		</form>

		</p></div>

<span id="normalView<?php echo $arrparent['nodeId'];?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:none;">

  <tr>

     <td align="left" colspan="2"><span class="style1" id="add<?php echo $position;?>" style="display:none;">	

<?php

echo '<span class="style1">'.$this->lang->line('txt_Originator').': '.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';

?></span>

<?php 



$arrStartTime 	= explode('-',$arrparent['starttime']);

$arrEndTime 	= explode('-',$arrparent['starttime']);

if($listTime['listStartTime'] != '')

{

?>

	&nbsp;&nbsp;&nbsp;<span class="style1"><?php echo $this->lang->line('txt_Start').': '.$listTime['listStartTime'];?></span>

<?php

}

if($listTime['listEndTime'] != '')

{

?>

	&nbsp;&nbsp;&nbsp;<span class="style1"> <?php echo $this->lang->line('txt_End').': '.$listTime['listEndTime'];?>&nbsp;</span>

<?php

}

?>

</td>

   

  </tr>

<tr>

     <td align="left" colspan="2">

		<a href="javascript:void(0)" onClick="hideBottomMenus(<?php echo $arrparent['nodeId'];?>),showArtifactLinks('<?php echo $arrparent['nodeId'];?>',<?php echo $arrparent['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

		<a href="javascript:void(0);" onClick="editthis1(<?php echo $arrparent['leafId'];?>,<?php echo $arrparent['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>

		<a href="javascript:reply(0, <?php echo $arrparent['nodeId'];?>);">Add Activity</a>

		<a href="javascript:void(0);" onClick="hideBottomMenus(<?php echo $arrparent['nodeId'];?>),showTagView('<?php echo $arrparent['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp;

		



</td>

   

  </tr>

	

</table>





</span>



<?php

				#********************************************* Tags ********************************************************88

				

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;		

				?>

				<span id="spanArtifactLinks<?php echo $arrparent['nodeId'];?>" style="display:none;">

				</span>	

				<span id="spanTagView<?php echo $arrparent['nodeId'];?>" style="display:none;">

				<span id="spanTagViewInner<?php echo $arrparent['nodeId'];?>">

				<table width="100%">						

				<?php	

				$tagAvlStatus = 0;				

				if(count($viewTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($viewTags as $tagData)

					{													

						$dispViewTags .= $tagData['tagName'].', ';						 

					}

				}					

				if(count($contactTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($contactTags as $tagData)

					{

						$dispContactTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									

					}

				}

				if(count($userTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($userTags as $tagData)

					{

						$dispUserTags .= $tagData['userTagName'].', ';						

					}

				}

				if(count($actTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($actTags as $tagData)

					{

						$dispResponseTags .= $tagData['comments'].' [';							

						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

						if(!$response)

						{

							$dispResponseTags .= '<a href="javascript:void(0);" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

						}

						$dispResponseTags .= '<a href="javascript:void(0);" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispResponseTags .= '], ';

					}

				}

				if($dispViewTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';

					$nodeTagStatus = 1;		

					?>

					</td></tr>	

					<?php				

				}		

				if($dispResponseTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					

					$nodeTagStatus = 1;

					?>

					</td></tr>	

					<?php	

				}		

				if($dispContactTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					

					$nodeTagStatus = 1;	

					?>

					</td></tr>	

					<?php	

				}		

				if($dispUserTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';

					$nodeTagStatus = 1;			

					?>

					</td></tr>	

					<?php		

				}	

							

				if($nodeTagStatus == 0)	

				{

				?>			

					<tr><tr><td><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td></tr>	

				<?php

				}

				?>				

				

				<tr>

					<td align="right" class="border_dotted">&nbsp;</td>

				</tr>	

				</table>

				</span>

				<ul class="rtabs">

					<li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrparent['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrparent['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>

					<span id="spanTagNew<?php echo $arrparent['nodeId'];?>"><li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrparent['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrparent['nodeId']; ?>,2,0,1)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li></span>

				</ul>	

				<iframe id="iframeId<?php echo $arrparent['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>				

				<hr color="#666666">

				</span>								

				<?php	

				#*********************************************** Tags ********************************************************	

	?>																	

</td>

				<td width="25">&nbsp;</td>

			  </tr>

			<tr>

				<td colspan="3"></td>

			  </tr>		

			  <tr>

				<td colspan="3"><hr></td>

			  </tr>

		  </table>		</td>

        </tr>

	<?php 

	$totalNodes = array();

	if($arrparent['successors'])

	{		 //print_r($arrparent);	

		

			$arrChildNodes = $this->activity_db_manager->getChildNodes($arrparent['nodeId'], $arrparent['treeIds']);	

			$sArray = array();

			//$sArray=explode(',',$arrparent['successors']);

			$sArray = $arrChildNodes;

			

			while($counter < count($sArray)){

				$arrDiscussions=$this->activity_db_manager->getPerentInfo($sArray[$counter]);

				$editVisibility = 'none';

				$menusVisibility = 'none';	

				if($arrDiscussions['nodeId'] == $selectedNodeId)

				{

					$editVisibility = '';

					$menusVisibility = '';

				}

				$position++;

				$totalNodes[] = $position;

				$userDetails	= $this->activity_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);

				$checksucc =$this->activity_db_manager->checkSuccessors($arrDiscussions['nodeId']);

				$arrActivities = array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');

				$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

				$arrNodeActivityUsers 	= $this->activity_db_manager->getActivityUsers($arrDiscussions['nodeId'], 2);

				$nodeActivityStatus 	= $this->activity_db_manager->getActivityStatus($arrDiscussions['nodeId']);

				//	$this->activity_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 

				//	$viewCheck	= $this->activity_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);

				$arrNodes = array();	

				$this->activity_db_manager->arrNodes = array();		

				if($checksucc)

				{

					$arrNodes = $this->activity_db_manager->getNodesBySuccessor($checksucc);					

					$allNodes = implode(',', $arrNodes);

					$subListTime = $this->activity_db_manager->getSubListTime($allNodes);											

				}

									

				$arrStartTime 		= explode('-',$arrDiscussions['starttime']);

				$arrEndTime 		= explode('-',$arrDiscussions['starttime']);

				$contributors 				= $this->activity_db_manager->getActivityContributors($arrDiscussions['nodeId']);

				$contributorsTagName		= array();

				$contributorsUserId			= array();	

				foreach($contributors  as $userData)

				{

					$contributorsTagName[] 	= $userData['userTagName'];

					$contributorsUserId[] 	= $userData['userId'];	

				}	

				$activityTitle = $this->lang->line('txt_Sub_List_Title');	

				$editStatus = 1;			

				?>

				 <tr>

        <td width="5%" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>

       

        <td colspan="4" width="95%" align="left" valign="top" bgcolor="#FFFFFF">

		

		

		

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td width="26">&nbsp;</td>

		<td>

		<span id="latestcontent<?php echo $arrDiscussions['leafId'];?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

			<td id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);" class="handCursor">		

			<span id="img<?php echo $position;?>">

<?php

if(!$checksucc)

{

?>

	&nbsp;&nbsp;

	<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeActivityStatus];?>">

	<?php

}

?>

<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> <?php //if(!$viewCheck){ echo '<blink>'.$this->lang->line('txt_New').'</blink>';	}?></span> <?php if($checksucc){

	echo '<a href="'.base_url().'view_activity/node_activity/'.$arrDiscussions['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';

	}?>&nbsp;&nbsp;

<?php																

 echo html_entity_decode(stripslashes($arrDiscussions['contents']));?></td>

  </tr>

  

</table>



</span>

<div id="editThis<?php echo $arrDiscussions['leafId'];?>" style="display:<?php echo $editVisibility;?>;  margin-top:0px; margin-left:20px;">

<p onMouseOver="vksfun(<?php echo $arrDiscussions['leafId'];?>);">

<form name="form3<?php echo $arrDiscussions['leafId'];?>" method="post" action="<?php echo base_url();?>new_activity/leaf_edit_Activity/<?php echo $arrDiscussions['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">

 

  <tr>

    <td valign="top">

<table>

<?php 

$editStartTimeStyle = '';

$editEndTimeStyle = '';

$editStartCalVisible = '';

$editEndCalVisible = '';

$editStartCheck = 'checked';

$editEndCheck = 'checked';

$editStartTime = $arrDiscussions['editStarttime'];

if($arrStartTime[0] == '00')

{

	$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');

	$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';

	$editStartCalVisible = 'style="display:none"';

	$editStartCheck 	= '';	

}

$editEndTime = $arrDiscussions['editEndtime'];

if($arrEndTime[0] == '00')

{

	$editEndTime = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');

	$editEndTimeStyle 	= ' style="background-color:#CCCCCC; color:#626262;"';

	$editEndCalVisible 	= 'style="display:none"';

	$editEndCheck		= '';	

}

	?>

	<tr>

		<td> <?php echo $activityTitle;?>:</td>

		<td>  <textarea name="editactivity<?php echo $arrDiscussions['leafId'];?>" id="editactivity<?php echo $arrDiscussions['leafId'];?>" rows="3" cols="35"><?php echo html_entity_decode(stripslashes($arrDiscussions['contents']));?></textarea></td>	

	</tr>	

	<?php

	if(!$checksucc)

	{

		

	?>

	<tr>

		<td> <?php echo $this->lang->line('txt_Start_Time');?>:</td>

		<td>  <input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo 'Edit'.$position;?>', document.form3<?php echo $arrDiscussions['leafId'];?>)" <?php echo $editStartCheck;?>><input name="starttime" type="text" id="starttime<?php echo $arrDiscussions['leafId'];?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>><span id="calStartEdit<?php echo $position;?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrDiscussions['leafId'];?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>



	</tr>

	<tr>

		<td> <?php echo $this->lang->line('txt_End_Time');?>:</td>

		<td><input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo 'Edit'.$position;?>', document.form3<?php echo $arrDiscussions['leafId'];?>)" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $arrDiscussions['leafId'];?>" value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?>><span id="calEndEdit<?php echo $position;?>" <?php echo $editEndCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrDiscussions['leafId'];?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>	

	</tr>	

	<tr>

		<td  valign="top">

			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span>

		</td>

	    <td  valign="top">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes" <?php if($arrDiscussions['viewCalendar'] == 1) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" <?php if($arrDiscussions['viewCalendar'] == 0) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_No');?> 

		</td>	   

	</tr>

<tr>

	<td align="left">

	<?php echo $this->lang->line('txt_Completion_Status');?>:</td>

	<td align="left">

	<input type="radio" name="completionStatus" value="1" <?php if($nodeActivityStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeActivityStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeActivityStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeActivityStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;

	</td>

</tr>

<?php

}

?>

<tr>

		<td>&nbsp; </td>

		<td>

<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('editactivity<?php echo $arrDiscussions['leafId'];?>',document.form3<?php echo $arrDiscussions['leafId'];?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close(<?php echo $arrDiscussions['leafId'];?>,<?php echo $arrDiscussions['nodeId'];?>);">

		        <input name="reply" type="hidden" id="reply" value="1">

				<input name="editorname1" type="hidden"  value="editactivity<?php echo $arrDiscussions['leafId'];?>">

				<input name="nodeId" type="hidden"  value="<?php echo $arrDiscussions['nodeId'];?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_activity/node_activity/<?php echo $myPid;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $arrparent['treeIds'];?>">

				<input type="hidden" name="activityId" value="<?php echo $arrDiscussions['nodeId'];?>"> 

				<input type="hidden" name="editStatus" value="<?php echo $editStatus;?>" id="editStatus">		

		</td>	

	</tr>





</table>

</td>

  </tr>

  <tr>

    <td>

	 

				

				</td>

  </tr>

</table>



	

                

		</form>

			</p>

			

			</div>





<!--<div id="reply_teeme<?php echo $position;?>" style="display:none;   margin-top:0px; margin-left:20px;">

			<p onMouseOver="vksfun(<?php echo $position;?>);">

<form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_activity/node_new_Activity/<?php echo $arrparent['treeIds'];?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">

 <tr>

	<td><span id="vk12345"></span><?php echo $this->lang->line('txt_Sub_Activity');?>:</td>

    <td valign="top"><textarea name="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>" id="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>" rows="3" cols="35"></textarea>

 </td>

</tr>

  <tr>

    <td id="chat_title">			

			<?php echo $this->lang->line('txt_Start_Time');?>:</td>

	<td> <input type="checkbox" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.form12<?php echo $position;?>)"><input name="starttime" type="text" id="starttime<?php echo $position;?>"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form12<?php echo $position;?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr><tr>

<td><?php echo $this->lang->line('txt_End_Time');?>:</td>

<td> <input type="checkbox" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.form12<?php echo $position;?>)"><input name="endtime" type="text" id="endtime<?php echo $position;?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form12<?php echo $position;?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>

</tr>



<tr>

    <td valign="top"><?php echo $this->lang->line('txt_Assignees');?></td>

    <td valign="top">

	<select name="activityUsers[]" multiple>

		<option value="<?php echo $_SESSION['userId'];?>" selected><?php echo $this->lang->line('txt_Me');?></option>

		<option value="0"><?php echo $this->lang->line('txt_All');?></option>

		<?php	

		foreach($workSpaceMembers as $arrData)

		{

			if($_SESSION['userId'] != $arrData['userId'])

			{		

			?>

				<option value="<?php echo $arrData['userId'];?>"><?php echo $arrData['tagName'];?></option>

			<?php

			}

		}		

		?>

	</select>

	</td>

   

  </tr>

	<tr>

		<td  valign="top">

			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span>

				</td>

	    <td  valign="top">&nbsp;

          <input type="radio" name="calendarStatus" value="Yes">

          <?php echo $this->lang->line('txt_Yes');?> &nbsp;

          <input name="calendarStatus" type="radio" value="No" checked>

          <?php echo $this->lang->line('txt_No');?> </td>

	   

	</tr>

 

<tr>

<td>&nbsp;</td>

<td>

<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>',document.form12<?php echo $position;?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(<?php echo $position;?>);">

<input name="reply" type="hidden" id="reply" value="1">

<input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>">

<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

<input name="nodeId" type="hidden" value="<?php echo $arrDiscussions['nodeId'];?>">

<input name="treeId" type="hidden" id="treeId" value="<?php echo $arrparent['treeIds'];?>">

<input type="hidden" name="editStatus" value="0" id="editStatus">

</td>

</tr>

		

  

</table>



	

                

		</form>

		</p>

			

			</div>-->



<div id="add_activity<?php echo $position;?>" style="display:none;  margin-top:0px; margin-left:20px;">

<p onMouseOver="vksfun(<?php echo $position;?>);">







<form name="formAdd<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_activity/new_activity1/<?php echo $arrparent['treeIds'];?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">

<tr>

    <td valign="top"><span id="vk12345"></span><br>

<?php echo $this->lang->line('txt_Activity');?>: 

	</td><td>

<textarea name="newActivity" rows="3" cols="35"></textarea>

</td>

</tr>

  <tr>

    <td id="chat_title"> 



			

			<?php echo $this->lang->line('txt_Start_Time');?>: 

</td>

<td>

<input type="checkbox" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.formAdd<?php echo $position;?>)"><input name="starttime" type="text" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAdd<?php echo $position;?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr>

	<tr>

		<td> 

			<?php echo $this->lang->line('txt_End_Time');?>: 

		</td>

		<td>

			<input type="checkbox" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.formAdd<?php echo $position;?>)"><input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAdd<?php echo $position;?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span>

		</td>

  </tr>

  

<tr>

    <td valign="top"><?php echo $this->lang->line('txt_Assignees');?></td>

    <td valign="top">

	<select name="activityUsers[]" multiple>

		<option value="<?php echo $_SESSION['userId'];?>" selected><?php echo $this->lang->line('txt_Me');?></option>

		<option value="0"><?php echo $this->lang->line('txt_All');?></option>

		<?php	

		foreach($workSpaceMembers as $arrData)

		{

			if($_SESSION['userId'] != $arrData['userId'])

			{		

			?>

				<option value="<?php echo $arrData['userId'];?>"><?php echo $arrData['tagName'];?></option>

			<?php

			}

		}		

		?>

	</select>

	</td>

   

  </tr>

	<tr>

		<td  valign="top">

			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span>

		</td>

	    <td  valign="top">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes">

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" checked>

			<?php echo $this->lang->line('txt_No');?> 

		</td>	   

	</tr>

<tr><td>&nbsp;</td>

<td>

	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_activity('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>',document.formAdd<?php echo $position;?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="addActivityClose(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);">

    <input name="reply" type="hidden" id="reply" value="1">

	<input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>">

	<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

	<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

	<input type="hidden" name="titleStatus" value="0" id="titleStatus">

	<input name="nodeId" type="hidden" value="<?php echo $arrDiscussions['nodeId'];?>">

	<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

	<input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

	<input name="parentNode" type="hidden" id="parentNode" value="<?php echo $arrparent['nodeId'];?>">

</td></tr>



		

  

</table>

                

		</form>

			</p>

			

			</div>

<span id="normalView<?php echo $arrDiscussions['nodeId'];?>">



<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:<?php echo $menusVisibility;?>;">

	 <tr>

    <td width="90%" align="left" colspan="2"><span class="style1" id="add<?php echo $position;?>" style="display:none;">

<?php  

echo '<span class="style1">'.$this->lang->line('txt_Originator').': '.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';



if(!$checksucc)

{

	echo '<span class="style1">'.$this->lang->line('txt_Assignees').': '.implode(', ',$contributorsTagName).'</span>';

}

?></span>

<?php 

if(!$checksucc)

{

	if($arrStartTime[0] != '00')

	{

		?>

	&nbsp;&nbsp;&nbsp;<span class="style1">

	<?php

		echo $this->lang->line('txt_Start').': '.$arrDiscussions['starttime'];?></span>

	<?php

	}

	if($arrEndTime[0] != '00')

	{

		?>

	&nbsp;&nbsp;&nbsp;<span class="style1">

	<?php

		echo $this->lang->line('txt_End').': '.$arrDiscussions['endtime'];?></span>

	<?php

	}

}

else

{

	if($subListTime['listStartTime'] != '')

	{

		?>

	&nbsp;&nbsp;&nbsp;<span class="style1">

	<?php

		echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>

	<?php

	}

	if($subListTime['listEndTime'] != '')

	{

		?>

	&nbsp;&nbsp;&nbsp;<span class="style1">

	<?php

		echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>

	<?php

	}

}

?>



</td><td align="right" style="padding-right:10px;"></td>

    

  </tr>

<?php

if(!$checksucc)

{

?>

	<tr>

		<td width="90%" align="left" colspan="2"> 

		<a href="javascript:void(0);" onClick="hideBottomMenus(<?php echo $arrDiscussions['nodeId'];?>),showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

		<a href="javascript:void(0);" onClick="hideBottomMenus(<?php echo $arrDiscussions['nodeId'];?>),showTagView('<?php echo $arrDiscussions['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp;

		<a href="<?php echo base_url();?>new_activity/start_sub_activity/<?php echo $arrDiscussions['nodeId'];?>/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Add_Sub_Activity');?></a>&nbsp;&nbsp;

		<a href="javascript:addActivity(<?php echo $position;?>, <?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Add_Activity');?></a>&nbsp;&nbsp;

		<a href="javascript:void(0);" onClick="editthis(<?php echo $arrDiscussions['leafId'];?>, <?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;&nbsp;<?php if( $arrDiscussions['leafParentId']){?><a href="javascript:void(0);" onClick="getnext(<?php echo $arrDiscussions['leafParentId'];?>,'latestcontent<?php echo $arrDiscussions['leafId'];?>');"><img border="0" src="<?php echo base_url();?>images/left.gif" ></a><?php }?>&nbsp;</td><td align="right" style="padding-right:10px;"></td>

			

	</tr>

	<?php

	//if(in_array($_SESSION['userId'],$arrNodeActivityUsers))

	//{

	

	

}

else

{

?>

	<tr>

		<td width="90%" align="left" colspan="2"> 

		<a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

		<a href="javascript:void(0);" onClick="showTagView('<?php echo $arrDiscussions['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp;

		<a href="javascript:void(0);" onClick="editthis(<?php echo $arrDiscussions['leafId'];?>,<?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>

		<a href="javascript:addActivity(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Add_Activity');?></a>&nbsp;&nbsp;

	</td><td align="right" style="padding-right:10px;"></td>		

	</tr>



<?php

}

?>



</table>

</span>



<?php

				#********************************************* Tags ********************************************************88

				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;		

				?>

				<span id="spanArtifactLinks<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"></span>	

				<span id="spanTagView<?php echo $arrDiscussions['nodeId'];?>" style="display:none;">

				<span id="spanTagViewInner<?php echo $arrDiscussions['nodeId'];?>">

				<table width="100%">						

				<?php	

				$tagAvlStatus = 0;				

				if(count($viewTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($viewTags as $tagData)

					{													

						$dispViewTags .= $tagData['tagName'].', ';						 

					}

				}					

				if(count($contactTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($contactTags as $tagData)

					{

						$dispContactTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									

					}

				}

				if(count($userTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($userTags as $tagData)

					{

						$dispUserTags .= $tagData['userTagName'].', ';						

					}

				}

				if(count($actTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($actTags as $tagData)

					{

						$dispResponseTags .= $tagData['comments'].' [';							

						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

						if(!$response)

						{

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispResponseTags .= '], ';

					}

				}

				if($dispViewTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';

					$nodeTagStatus = 1;		

					?>

					</td></tr>	

					<?php				

				}		

				if($dispResponseTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					

					$nodeTagStatus = 1;

					?>

					</td></tr>	

					<?php	

				}		

				if($dispContactTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					

					$nodeTagStatus = 1;	

					?>

					</td></tr>	

					<?php	

				}		

				if($dispUserTags != '')		

				{

					?>			

					<tr><tr><td><?php

					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';

					$nodeTagStatus = 1;			

					?>

					</td></tr>	

					<?php		

				}	

							

				if($nodeTagStatus == 0)	

				{

				?>			

					<tr><tr><td><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td></tr>	

				<?php

				}

				?>				

				<tr>

					<td align="right">

						</td>

				</tr> 

				<tr>

					<td align="right" class="border_dotted">&nbsp;</td>

				</tr>	

				</table>

				</span>

				<ul class="rtabs">

					<li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>

					<span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>"><li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li></span>

				</ul>				

				<iframe id="iframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>

				

				<hr color="#666666">

				</span>								

				<?php	

				#*********************************************** Tags ********************************************************	

?>

</td>

				<td width="25">&nbsp;</td>

			  </tr>



			  <tr>

				<td colspan="3"><hr></td>

				

			  </tr>

			</table>

		

		

		

		

		

		</td>

        </tr>

				

				

				<?php

				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];

				$counter++;

			}

		

	}

	else

	{

	?>	

	  <tr>

		<td align="left" valign="top" bgcolor="#FFFFFF" colspan="5"><span class="infoMsg"><?php echo $this->lang->line('msg_activities_not_available');?></span></td>       

	  </tr>

	<?php

	}	

	

?>

    </table>    

<input type="hidden" id="totalNodes" value="<?php echo implode(',', $totalNodes);?>">

<input type="hidden" id="allNodeIds" value="<?php echo implode(',', $arrTotalNodes);?>">



<script language="javascript">

function vksfun(id){

	var fId=id;

	rameid=fId;

}

</script>

<script>

function reply(id, nodeId)

{

	

	divid='reply_teeme'+id;

	document.getElementById(divid).style.display='';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

	//parent.frames[id].gk.EditingArea.focus();

	rameid=id;	

}

function reply_close(id, nodeId){

	divid='reply_teeme'+id;

 	document.getElementById(divid).style.display='none';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='';

}

function vksfun(id){

whofocus=id;

}

//this function used to hide the bottom menu when accessing other manus

function hideBottomMenus(nodeId)

{

	if(nodeId == 0)

	{

		detailId='detail'+nodeId;

		document.getElementById(detailId).style.display='none';		

	}

	else

	{		

		detailId='normalView'+nodeId;

		document.getElementById(detailId).style.display='none';

	}	

}

function hidedetail(id){

	var image='img'+id;

	var added='add'+id;

	var details='detail'+id;

	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(added).style.display='none';

	document.getElementById(details).style.display='none';

	

}

function showdetail(id, curNodeId)

{	



	var curNode='detail'+id;		

	var added='add'+id;

	var allNodes = document.getElementById('totalNodes').value;

	var arrNodes = new Array();

	arrNodes = allNodes.split(',');

	var allNodeIds = document.getElementById('allNodeIds').value;

	var arrNodeIds = new Array();

	arrNodeIds = allNodeIds.split(',');

	var nodeId 		= 'detail0';	

	var curAddId 	= 'add0'; 	

	document.getElementById(nodeId).style.display='none';	

	document.getElementById(curAddId).style.display='none';



	for(var i = 0;i<arrNodes.length;i++)

	{		

		var nodeId = 'detail'+arrNodes[i];	

		var curAddId = 'add'+arrNodes[i];

		var artLinks = 'spanArtifactLinks'+arrNodes[i]; 

		if(id != arrNodes[i])

		{			

			document.getElementById(nodeId).style.display='none';	

			document.getElementById(curAddId).style.display='none';	

			//document.getElementById(artLinks).style.display='none';	

		}

	} 

	/*for(var i = 0;i<arrNodes.length;i++)

	{		

		var nodeId = 'detail'+arrNodes[i];	

		var curAddId = 'add'+arrNodes[i];

		alert(arrNodes[i]);	 	

		var artLinks = 'spanArtifactLinks'+arrNodes[i]; 

		if(id != arrNodes[i])

		{			

			document.getElementById(nodeId).style.display='none';	

			document.getElementById(curAddId).style.display='none';	

			//document.getElementById(artLinks).style.display='none';	

		}

	} */

	if(document.getElementById(curNode).style.display=='')		

	{

		document.getElementById(curNode).style.display='none';

		document.getElementById(added).style.display='none';	

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='none';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='none';

		}

	}

	else

	{

		document.getElementById(curNode).style.display='';

		document.getElementById(added).style.display='';

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='';

		}

	}

}





function editthis(lid, nodeId)

{

	var spanId='latestcontent'+lid;

	var editorId='editThis'+lid;

	document.getElementById(spanId).style.display='none';

	document.getElementById(editorId).style.display='';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

 }

function editthis1(lid, nodeId)

{	

	var editorId='editThis'+lid;	

	document.getElementById(editorId).style.display='';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

 }

function edit_close(lid, nodeId){

var spanId='latestcontent'+lid;

var editorId='editThis'+lid;

document.getElementById(spanId).style.display='';

document.getElementById(editorId).style.display='none';

detailId='normalView'+nodeId;

document.getElementById(detailId).style.display='';

}

function edit_close1(lid, nodeId){

var editorId='editThis'+lid;

document.getElementById(editorId).style.display='none';

detailId='normalView'+nodeId;

document.getElementById(detailId).style.display='';

}

function getnext(pid,id){

	var url='<?php echo base_url();?>view_activity/activity_content_p/'+pid+'/'+id;

	 

	ajax_request(url,id);

}

function getnew(lid,id)

{

	var url='<?php echo base_url();?>view_activity/activity_content_n/'+lid+'/'+id;	 

	ajax_request(url,id);

}

function ajax_request(url,id)

{

	var xmlHttp;

	try

	{

		// Firefox, Opera 8.0+, Safari

		xmlHttp=new XMLHttpRequest();

	}

	catch (e)

	{

		// Internet Explorer

		try

		{

			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");

		}

		catch (e)

		{

			try

			{

				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch (e)

			{

				jAlert("<?php echo $this->lang->line('your_browser_not_support_ajax'); ?>","Alert");

				return false;

			}

		}

	}

	 

	xmlHttp.onreadystatechange=function()

	{

		if(xmlHttp.readyState==4)

		{

			document.getElementById(id).innerHTML=xmlHttp.responseText;	

		}

	}

	// alert(url);

	//data='reply=1&replyDiscussion'+document.getElementById('replyDiscussion1').value;

	xmlHttp.open("GET", url, true); 

	//xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	xmlHttp.send(null);

}

</script>



				<!-- Main Body -->

				<!-- Right Part-->			

				<!-- end Right Part -->

				</td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>

          </tr>

          <tr>

            <td align="center" valign="top" class="copy">

			<!-- Footer -->	

				<?php $this->load->view('common/footer');?>

			<!-- Footer -->

			</td>

          </tr>

        </table>

    </td>

  </tr>

  <tr>

    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

</table>



</body>

</html>

