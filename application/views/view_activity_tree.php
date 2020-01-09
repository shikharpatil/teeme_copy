<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

</script>



    <?php 	if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)

		{

	?>

		<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>

	<?php

		}         

	?>



    <script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

    

<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>	

<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></LINK>

<SCRIPT type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>

<script>

function reply(id)

{

	divid		= 'reply_teeme'+id;

	alert ('divid= ' + divid);

	document.getElementById(divid).style.display='';

	detailId	= 'detail'+id;

	document.getElementById(detailId).style.display='none';

	//parent.frames[id].gk.EditingArea.focus();

	rameid=id;	

}

function addActivity(id, nodeId)

{	

	divid='add_activity'+id;

	document.getElementById(divid).style.display='';

	if(nodeId == 0)

	{

		detailId='detail'+id;

		document.getElementById(detailId).style.display='none';		

	}

	else

	{		

		detailId='normalView'+nodeId;

		document.getElementById(detailId).style.display='none';

	}

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

function reply_close(id){

	divid='reply_teeme'+id;

 	document.getElementById(divid).style.display='none';

}



function vksfun(id){

	var fId=id;

	rameid=fId;

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

	var curNode		= 'detail'+id;

	var added		= 'add'+id;

	var allNodes 	= document.getElementById('totalNodes').value;

	var arrNodes 	= new Array();

	arrNodes 		= allNodes.split(',');

	for(var i = 0;i<arrNodes.length;i++)

	{		

		var nodeId = 'detail'+arrNodes[i];	

		var curAddId = 'add'+arrNodes[i]; 	

		if(id != arrNodes[i])

		{			

			document.getElementById(nodeId).style.display='none';	

			document.getElementById(curAddId).style.display='none';	

		}

	} 

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



function editthis(lid, nodeId){

var spanId='latestcontent'+lid;

var editorId='editThis'+lid;



document.getElementById(spanId).style.display='none';

document.getElementById(editorId).style.display='';

detailId	= 'normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

 }

function editthis1(lid)

{	

	var editorId='editThis'+lid;



	document.getElementById(editorId).style.display='';

	detailId	= 'detail'+lid;

	document.getElementById(detailId).style.display='none';

 }

function edit_close(lid, nodeId){

var spanId='latestcontent'+lid;

var editorId='editThis'+lid;

document.getElementById(spanId).style.display='';

document.getElementById(editorId).style.display='none';

var detailId='normalView'+lid;

document.getElementById(detailId).style.display='';

}

function edit_close1(lid){

var editorId='editThis'+lid;

document.getElementById(editorId).style.display='none';

detailId	= 'detail'+lid;

document.getElementById(detailId).style.display='';

}

function getnext(pid,id){

	var url='<?php echo base_url();?>view_activity/activity_content_p/'+pid+'/'+id;

	 

	ajax_request(url,id);

}

function getnew(lid,id){

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

		document.getElementById(id).innerHTML=xmlHttp.responseText 

	}

}

 

xmlHttp.open("GET", url, true); 

//xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

xmlHttp.send(null);

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

		formName.endtime.style.color	 = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

	}

}

	var baseUrl='<?php echo base_url();?>';

	var lastframeid=0;

	var rameid=0;

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



	function validate_title(formname)

	{

		var error=''	

		if(trim(formname.activityTitle.value) =='' )

		{

			jAlert('<?php echo $this->lang->line('enter_title'); ?>');

			formname.activityTitle.focus();			

		}

		else		

		{

			formname.submit();

		}	

	}

	function validate_dis(replyDiscussion,formname){

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

		if(error==''){

			formname.submit();

		}else{

			jAlert(error);

		}

	}

	

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

			if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

				error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';

			}

		}

		if(error==''){

			formname.submit();

		}else{

			jAlert(error);

		}

	}

	

}	

</script>

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

					<span id="tagSpan"></span></td>

          </tr>

<?php

$day 	= date('d');

$month 	= date('m');

$year	= date('Y');	

?>

	  <tr>

		<td colspan="2" valign="top">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

      

      <tr>

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">

		<table width="100%">

          <tr>

            <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="rtabs">

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>"><span><?php echo $this->lang->line('txt_Calendar_View');?></span></a></li>

            	<li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>

           </ul></td>

          </tr>

        

          <tr>

            <td colspan="4" align="left" valign="top" class="tdSpace"><hr></td>

          </tr>

     </table>		

	<?php 

	//if($arrDiscussionDetails['name'] != 'untitled')

	//{

				

	?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px;">			

		<tr>

			<td width="26">&nbsp;</td>

			<td><span id="add<?php echo $position;?>" style="display:none;"></span>

				

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr class="seedBgColor">

						<td onClick="showdetail(<?php echo $position;?>, 0);" class="handCursor">

							<?php	

							$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);

							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				

							$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);

							$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);

							

							$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);

							$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);

							$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);

							$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);

							$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);

							$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);

							$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);

							

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

							//if($arrDiscussionDetails['name']!='untitled')

							//{

							//echo $arrDiscussionDetails['name'];

							echo strip_tags($arrDiscussionDetails['name'],'<b><em><span><img>'); 

							//}	

							

							if (!empty($arrDiscussionDetails['old_name']))

			 				{

			 					echo '<br>(<b>Previous Name:</b> ' .strip_tags($arrDiscussionDetails['old_name'],'<b><em><span><img>').')';

			 				}			

							?>

						</td>

                        

                       	<td align="left">

             	

                		<?php

             				if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])

                			{

						?>

             

             				<a href="javascript:void(0);" onClick="if(document.getElementById('edit_doc').style.display=='none') { document.getElementById('edit_doc').style.display='block';} else { document.getElementById('edit_doc').style.display='none';}"><img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit_Document_Name');?>" title="<?php echo $this->lang->line('txt_Edit_Document_Name');?>" border="0"></a>

                

                		<?php

							}

							else

							{

						?>

                			&nbsp;

                		<?php

							}

						?>

                

              			</td>

					</tr>

                    <tr id="edit_doc" style="display:none;" class="<?php echo $seedBgColor;?>">

        	

            <td colspan="3">

            <form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/activity" onSubmit="return validateDocumentName();">

            	<!--<input name="documentName" id="documentName" type="text" value="<?php //echo $arrDocumentDetails['name'];?>" size="50">-->

                <textarea name="documentName" id="documentName"><?php echo $arrDiscussionDetails['name'];?></textarea><br>

               

            	<a href="javascript:void(0)" onClick="docTitleSave();"><img src="<?php echo base_url(); ?>images/done-btn.jpg" border="0"></a>

                <a href="javascript:void(0)" onClick="docTitleCancel();"><img src="<?php echo base_url(); ?>images/btn-cancel.jpg" border="0"></a>

              

                        <input type="hidden" name="treeId" value="<?php echo $treeId; ?>">

            </form>

            <script>chnage_textarea_to_editor('documentName','simple')</script>

            </td>

			



        			</tr>

				</table>	



<span id="editThis0" style="display:none;  margin-top:0px; margin-left:20px;">

<form name="form30" method="post" action="<?php echo base_url();?>new_activity/edit_list_title/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td> <?php echo $this->lang->line('txt_List_Title');?>:</td>

		<td>  <textarea name="activityTitle" id="activityTitle" rows="3" cols="35"><?php echo html_entity_decode(stripslashes($arrDiscussionDetails['name']));?></textarea></td>	

	</tr>	

		<tr>

		<td>&nbsp; </td>

		<td>

<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_title(document.form30);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close1(0);">

		

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="editStatus" value="1" id="editStatus">		

		</td>	

	</tr>

</table>                

</form>			

</span>				

					

<div id="reply_teeme0" style="display:none; margin-top:0px; margin-left:20px;"><p onMouseOver="vksfun(0);">

<form name="form1" method="post" action="<?php echo base_url();?>new_activity/node_Activity/<?php echo $treeId;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

<?php if($arrDiscussionDetails['name'] == 'untitled'){?>

	<tr>

	<td id="chat_title">	

		<?php echo $this->lang->line('txt_Activity_Title');?>:

	</td>

		<td><input name="title" type="text" size="40" maxlength="255">

<input name="titleStatus" type="hidden" value="1">

	</td>	

	</tr>

	 <?php  }

else

{

?>

	<tr>

		<td valign="top"><span id="vk12345"></span><br>

		<?php echo $this->lang->line('txt_Activity');?>: 

		</td>

		<td><textarea name="replyDiscussion" id="replyDiscussion" rows="3" cols="35"></textarea></td>

	</tr> 

	<tr>

		<td id="chat_title"> 			

			<?php echo $this->lang->line('txt_Start_Time');?>: 			

		</td>

		<td>

			<input name="titleStatus" type="hidden" value="0">

			<input type="checkbox" name="startCheck" onClick="calStartCheck(this, 0, document.form1)"><input name="starttime" type="text" id="starttime0"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

		</td>

	</tr>

	<tr>

		<td id="chat_title">

		<?php echo $this->lang->line('txt_End_Time');?>: 

		</td>

		<td><input type="checkbox" name="endCheck" onClick="calEndCheck(this, 0, document.form1)"><input name="endtime" type="text" id="endtime0" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></td>

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

<?php

}

?>

	<tr>

		<td valign="top">&nbsp;</td>

		<td><input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);"></td>

	</tr>



  <tr>

    <td>

		        <input name="reply" type="hidden" id="reply" value="1">

		        <input name="editorname1" type="hidden"  value="replyDiscussion">

				 <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				 <input type="hidden" name="editStatus" value="0" id="editStatus">

				</td>

	<td>&nbsp;</td>

  </tr>

</table>



	

                

		</form>

		

		</p></div>

        



	

<?php

				

$userDetails = $this->activity_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);

			?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:none;">

  <tr>

    <td align="left" colspan="2"><?php 

$arrStartTime = explode('-',$arrDiscussionDetails['starttime']);

echo '<span class="style1">'.$userDetails['userTagName'].'</span>';

/*if($arrStartTime[0] != '00')

{

?>

	&nbsp;&nbsp;&nbsp;<span class="style1">&nbsp; <?php echo $this->lang->line('txt_Start').': '.$arrDiscussionDetails['starttime'];?></span>&nbsp;&nbsp;&nbsp;<span class="style1"> <?php echo $this->lang->line('txt_End').': '.$arrDiscussionDetails['endtime'];?>&nbsp;</span>

<?php

}*/

?>



</td>

  

  </tr>

	 <tr>

    <td align="left" colspan="2"><span id="normalViewTree<?php echo $treeId;?>">

<a href="javascript:void(0)" onClick="hideBottomMenus(0),showArtifactLinks('0',<?php echo $treeId;?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,1)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

<a href="javascript:reply(0);">

<?php 

/*if($arrDiscussionDetails['name'] == 'untitled')

{

	echo $this->lang->line('txt_Make_Activity_List');

}

else

{

	echo $this->lang->line('txt_Add_Activity');

}*/

echo $this->lang->line('txt_Add_Activity');

?></a>&nbsp;&nbsp;<a href="javascript:void(0)" onClick="hideBottomMenus(0),showTagView('0')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="editthis1(0);"><?php echo $this->lang->line('txt_Edit');?></a>

<a href="javascript:void(0);" onClick="window.location.reload();"><img src="<?php echo base_url(); ?>images/update.gif" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a>

</span></td>

    

  </tr>





	

</table>



<span id="spanArtifactLinks0" style="display:none;">

</span>	

				<?php		

				#********************************************* Tags ********************************************************88

				

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;		

				?>

				<span id="spanTagView0" style="display:none;">

				<span id="spanTagViewInner0">

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

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

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

							<li><a href="javascript:void(0)" onClick="hideTagView(0,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $treeId;?>,1)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>

							<span id="spanTagNew0"><li><a href="javascript:void(0)" onClick="showNewTag(0, <?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li></span>

						</ul>

				<iframe id="iframeId0" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>

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

		<?php

		//}

		?>	

		

	</td>

        </tr>

	<?php	

	$totalNodes = array();

	if(count($arrDiscussions) > 0)

	{					 

		foreach($arrDiscussions as $keyVal=>$arrVal)

		{

			$editVisibility = 'none';

			$menusVisibility = 'none';	

			if($arrVal['nodeId'] == $selectedNodeId)

			{

				$editVisibility = '';

				$menusVisibility = '';

			}			

			$arrActivities 			= array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');

			$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

			$arrNodeActivityUsers 	= $this->activity_db_manager->getActivityUsers($arrVal['nodeId'], 2);

			$nodeActivityStatus 	= $this->activity_db_manager->getActivityStatus($arrVal['nodeId']);

			$position++;

			$totalNodes[] 			= $position;

			$userDetails			= $this->activity_db_manager->getUserDetailsByUserId($arrVal['userId']);				

			$checksucc 				= $this->activity_db_manager->checkSuccessors($arrVal['nodeId']);

			$arrStartTime 			= explode('-',$arrVal['starttime']);

			$arrEndTime 			= explode('-',$arrVal['endtime']);

			$this->activity_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			

			$viewCheck=$this->activity_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			$contributors 				= $this->activity_db_manager->getActivityContributors($arrVal['nodeId']);

			$contributorsTagName		= array();

			$contributorsUserId			= array();

			

			foreach($contributors  as $userData)

			{

				$contributorsTagName[] 	= $userData['userTagName'];

				$contributorsUserId[] 	= $userData['userId'];	

			}

			$_SESSION['tmpcount'] = 0;

			$arrNodes = array();	

			$this->activity_db_manager->arrNodes = array();			

			if($checksucc)

			{

				$arrNodes = $this->activity_db_manager->getNodesBySuccessor($checksucc);			

				$allNodes = implode(',', $arrNodes);

				$subListTime = $this->activity_db_manager->getSubListTime($allNodes);					

			}	

			$activityTitle = $this->lang->line('txt_Sub_List_Title');	

			$editStatus = 1;		

			?>			

      <tr>

        <td width="5%" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>       

        <td width="95%" colspan="4" align="left" valign="top" bgcolor="#FFFFFF">

		

		

		

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

			  

			  <tr>

				<td width="26">&nbsp;</td>

				<td>

				



<span id="latestcontent<?php echo $arrVal['leafId'];?>" style="display:;"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);" class="handCursor">

	<?php

	if(!$checksucc)

	{

		$activityTitle = $this->lang->line('txt_Activity');

		$editStatus = 0;	

	?>

		&nbsp;&nbsp;

		<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeActivityStatus];?>">

		<?php

	}



	if($checksucc)

	{

		echo '<a href="'.base_url().'view_activity/node_activity/'.$arrVal['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';

	}

	?>

 <?php 

				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);



				$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);

				$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);

				$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);

				$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);

				$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);

				$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);

				$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);

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

echo html_entity_decode(stripslashes($arrVal['contents']));?>

	



	</td>

  </tr>

 

</table>



</span>



<div id="editThis<?php echo $arrVal['leafId'];?>" style="display:<?php echo $editVisibility;?>;  margin-top:0px; margin-left:20px;">

			<p onMouseOver="vksfun(<?php echo $arrVal['leafId'];?>);">







<form name="form3<?php echo $arrVal['leafId'];?>" method="post" action="<?php echo base_url();?>new_activity/leaf_edit_Activity/<?php echo $arrVal['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">



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

$editStartTime = $arrVal['editStarttime'];

if($arrStartTime[0] == '00')

{

	$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');

	$editStartTimeStyle = 'style="background-color:#CCCCCC; color:#626262;"';

	$editStartCalVisible = 'style="display:none"';

	$editStartCheck 	= '';	

}

$editEndTime = $arrVal['editEndtime'];

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

		<td>  <textarea name="editactivity<?php echo $arrVal['leafId'];?>" id="editactivity<?php echo $arrVal['leafId'];?>" rows="3" cols="35"><?php echo html_entity_decode(stripslashes($arrVal['contents']));?></textarea></td>	

	</tr>

	<?php

	if(!$checksucc)

	{

		

	?>

	<tr>

		<td> <?php echo $this->lang->line('txt_Start_Time');?>:</td>

		<td>  <input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo 'Edit'.$position;?>', document.form3<?php echo $arrVal['leafId'];?>)" <?php echo $editStartCheck;?>> <input name="starttime" type="text" id="starttime<?php echo $arrVal['leafId'];?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>><span id="calStartEdit<?php echo $position;?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrVal['leafId'];?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>



	</tr>

	<tr>

		<td> <?php echo $this->lang->line('txt_End_Time');?>:</td>

		<td> <input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo 'Edit'.$position;?>', document.form3<?php echo $arrVal['leafId'];?>)" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $arrVal['leafId'];?>" value="<?php echo $editEndTime;?>" <?php echo $editEndTimeStyle;?>><span id="calEndEdit<?php echo $position;?>" <?php echo $editEndCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrVal['leafId'];?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>	

	</tr>	

	<tr>

		<td  valign="top">

			<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span>

		</td>

	    <td  valign="top">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes" <?php if($arrVal['viewCalendar'] == 1) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" <?php if($arrVal['viewCalendar'] == 0) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_No');?> 

		</td>	   

	</tr>

<tr>

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

		<td> <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('editactivity<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close(<?php echo $arrVal['leafId'];?>, <?php echo $arrVal['nodeId'];?>);">

			<input name="reply" type="hidden" id="reply" value="1">

			<input name="editorname1" type="hidden"  value="editactivity<?php echo $arrVal['leafId'];?>">

			<input name="nodeId" type="hidden"  value="<?php echo $arrVal['nodeId'];?>">

			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

			<input type="hidden" name="treeId" value="<?php echo $treeId;?>" id="treeId">

			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

			<input type="hidden" name="titleStatus" value="0" id="titleStatus">

			 <input type="hidden" name="editStatus" value="<?php echo $editStatus;?>" id="editStatus">

			<input type="hidden" name="urlToGo" value="view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

			<input type="hidden" name="activityId" value="<?php echo $arrVal['nodeId'];?>"> 				

		</td>	

	</tr>







				<!--&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('editactivity<?php echo $arrVal['leafId'];?>', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); </script>-->



</table>

</td>

  </tr>

  

</table>                

</form>

</p>

</div>

<script>

chnage_textarea_to_editor('editactivity<?php echo $arrVal['leafId'];?>','simple');

</script>

<!--------------------------------------This is only for activity --------------------------------------------->

<?php 

if($arrDiscussionDetails['name'] == 'untitled')

{

?>

<div id="reply_teeme0" style="display:none;  margin-top:0px; margin-left:20px;"><p onMouseOver="vksfun(0);">

<form name="form1" method="post" action="<?php echo base_url();?>new_activity/node_Activity/<?php echo $treeId;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

	<tr>

	<td id="chat_title">	

		<?php echo $this->lang->line('txt_Activity_Title');?>:

	</td>

		<td><input name="title" type="text" size="40" maxlength="255">

<input name="titleStatus" type="hidden" value="1">

	</td>	

	</tr>

	

	<tr>

		<td valign="top">&nbsp;</td>

		<td><input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);"></td>

	</tr>



  <tr>

    <td>

		        <input name="reply" type="hidden" id="reply" value="1">

		        <input name="editorname1" type="hidden"  value="replyDiscussion">

				 <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				 <input type="hidden" name="editStatus" value="0" id="editStatus">

				</td>

	<td>&nbsp;</td>

  </tr>

</table>                

</form>		

</p></div>

<?php

}

?>

<!------------------------------------End This is only for activity ------------------------------------------->



<div id="add_activity<?php echo $position;?>" style="display:none;  margin-top:0px; margin-left:20px;">

<p onMouseOver="vksfun(<?php echo $position;?>);">







<form name="formAdd<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_activity/new_activity1/<?php echo $treeId;?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">

<tr>

    <td valign="top"><span id="vk12345"></span><br>

<?php echo $this->lang->line('txt_Activity');?>: 

	</td><td>

<textarea name="newActivity" id="newActivity"></textarea>

<script>

chnage_textarea_to_editor('newActivity','simple');

</script>

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

	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_activity('replyDiscussion<?php echo $arrVal['nodeId'];?>',document.formAdd<?php echo $position;?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="addActivityClose(<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>);">

    <input name="reply" type="hidden" id="reply" value="1">

	<input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrVal['nodeId'];?>">

	<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

	<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

	<input type="hidden" name="titleStatus" value="0" id="titleStatus">

	<input name="nodeId" type="hidden" value="<?php echo $arrVal['nodeId'];?>">

	<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

	<input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

	<input name="parentNode" type="hidden" id="parentNode" value="0">

</td></tr>



		

  

</table>

                

		</form>

			</p>

			

			</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:<?php echo $menusVisibility;?>;">

  <tr>

     <td align="left">

<?php 

echo '<span class="style1">'.$this->lang->line('txt_Originator').': '.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';

if(!$checksucc)

{

	

	if($arrStartTime[0] != '00')

	{

	?>

		&nbsp;&nbsp;&nbsp;

		<span class="style1">&nbsp; 

			<?php echo $this->lang->line('txt_Start').': '.$arrVal['starttime'];?>

		</span>

	<?php

	}

	if($arrEndTime[0] != '00')

	{

	?>

		&nbsp;&nbsp;&nbsp;

		<span class="style1"><?php echo $this->lang->line('txt_End').': '.$arrVal['endtime'];?>&nbsp;</span>

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

</td>

   

  </tr>

<?php

if(!$checksucc)

{

?>

	<tr>

		<td align="left"><?php echo '<span class="style1">'.$this->lang->line('txt_Assignees').': '.implode(', ',$contributorsTagName).'</span>';?></td>

	</tr>

<?php

}

?>

</table>

<span class="style1" id="add<?php echo $position;?>" style="display:none;">

<span id="normalView<?php echo $arrVal['nodeId'];?>">



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php

if(!$checksucc)

{

?>

  <tr>

    <td width="90%" align="left">

	<a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>	

	&nbsp;&nbsp;<a href="javascript:void(0)" onClick="showTagView('<?php echo $arrVal['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="editthis(<?php echo $arrVal['leafId'];?>, <?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;

	<?php 

	//if($arrDiscussionDetails['name'] == 'untitled')

	//{

	?>

		<!--<a href="javascript:reply(0);"><?php //echo $this->lang->line('txt_Make_Activity_List'); ?></a>-->&nbsp;&nbsp;

	<?php

	//}

	//else

	//{

	?>

		<a href="javascript:addActivity(<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Add_Activity');?></a>&nbsp;&nbsp;

	<?php

	//}

	?>

	<a href="javascript:void(0);" onClick="window.location.reload();"><?php echo $this->lang->line('txt_Update_Tree');?></a>

	<!--<a href="javascript:reply(<?php //echo $position;?>);"><?php echo $this->lang->line('txt_Add_Sub_Activity');?></a>-->







<?php

if($arrDiscussionDetails['name'] != 'untitled')

{	

?>

	

	<a href="<?php echo base_url();?>new_activity/start_sub_activity/<?php echo $arrVal['nodeId'];?>/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Add_Sub_Activity');?></a>

<?php

}

?>

	</td><td align="right" style="padding-right:10px;"></td>

    <td align="right"></td>

  </tr>

<?php

}

else

{

?>

	<tr>

    <td width="90%" align="left">

	<a href="javascript:void(0)" onClick="hideBottomMenus(<?php echo $arrVal['nodeId'];?>), showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>	

	&nbsp;&nbsp;

	<a href="javascript:void(0)" onClick="hideBottomMenus(<?php echo $arrVal['nodeId'];?>),showTagView('<?php echo $arrVal['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;

	<a href="javascript:void(0);" onClick="editthis(<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;

	<?php 

	//if($arrDiscussionDetails['name'] == 'untitled')

	//{

	?>

		<!--<a href="javascript:reply(0);"><?php //echo $this->lang->line('txt_Make_Activity_List'); ?></a>&nbsp;&nbsp;-->

	<?php

	//}

	//else

	//{

	?>

		<a href="javascript:addActivity(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Add_Activity');?></a>&nbsp;&nbsp;

	<?php

	//}

	?>

	

	</td><td align="right" style="padding-right:10px;"></td>

    <td align="right"></td>

  </tr>

<?php

}

?>

</table>



</span>

			<?php

				#********************************************* Tags ********************************************************88

				/*$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);

				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);*/

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;		

				?>

				<span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;">

				</span>	

				<span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;">

				<span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">

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

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

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

					<li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>

					<span id="spanTagNew<?php echo $arrVal['nodeId'];?>"><li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li></span>

				</ul>

				<iframe id="iframeId<?php echo $arrVal['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>

				<hr color="#666666">

				</span>								

				<?php	

				#*********************************************** Tags ********************************************************																		



?>

</td>

				<td>&nbsp;</td>

			  </tr>

			<tr>

				<td colspan="3"><hr></td>

				

			</tr>

			</table>		

		</td>

        </tr>

		<?php

		}

	}

	

	

?>

<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

    </table>     



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

