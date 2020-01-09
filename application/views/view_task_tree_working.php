<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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



<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></link>

<script type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>

<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>



<script language="javascript">



function hidedetail(id){

	var image='img'+id;

	var added='add'+id;

	var details='detail'+id;

	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(added).style.display='none';

	document.getElementById(details).style.display='none';

	

}

function getnext(pid,id){

	var url='<?php echo base_url();?>view_task/task_content_p/'+pid+'/'+id;

	 

	ajax_request(url,id);

}

function getnew(lid,id){

	var url='<?php echo base_url();?>view_task/task_content_n/'+lid+'/'+id;

	 

	ajax_request(url,id);

}

function showFilteredMembers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showMembers').value;

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

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

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

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

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

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

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

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

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

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

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

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMemAddTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

</script>





</head>



<body>



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

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			

			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId);

			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);			

			

			

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

            <td align="left" valign="top" bgcolor="#FFFFFF">

            	<table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="76%" height="8" align="left" valign="top"></td>

                  <td width="24%" align="left" valign="top"></td>

                </tr>

                <tr>

                  <td align="left" valign="top" colspan="2">

					<!-- Main Body -->

					<span id="tagSpan"></span>

                  </td>

          		</tr>

				<?php

					$day 	= date('d');$month 	= date('m');$year = date('Y');	

				?>

	  <tr>

		<td colspan="2" valign="top">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">      

      	<tr>

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">

		<table width="100%">

        <tr>

            <td align="left" valign="top" class="tdSpace">

            	<ul class="navigation">

                <li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Task_View');?></span></a></li>

                <li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>

            	<li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>"><span><?php echo $this->lang->line('txt_Calendar_View');?></span></a></li>

                <li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"><span><?php echo $this->lang->line('txt_Task_Search');?></span></a></li>

            	<?php

					if (($workSpaceId==0))

					{

				?>

                <li><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6"><span><?php echo $this->lang->line('txt_Share');?></span></a></li>

                <?php

					}

				?> 

                <li id="treeUpdate"></li>               

                </ul>

        	</td>

       	</tr>        

     	</table>

			<?php

			if ($treeId == $this->uri->segment(8))

				$nodeBgColor = 'nodeBgColorSelect';

			else

				$nodeBgColor = 'seedBgColor';

			?>	        

		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px;">			

		<tr>

			<td class="<?php echo $nodeBgColor; ?>">

            	<span id="add<?php echo $position;?>" style="display:none;"></span>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<tr>

						<td onClick="showdetail(<?php echo $position;?>, 0);" class="seedHeading handCursor">

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

					echo '<a href=javascript:void(0) onClick=showTagView(0,0)><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';

				}

				else

				{

					if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 

					{

						echo '&nbsp;&nbsp;';

					}

				}

				if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	

				{//echo '[L]&nbsp;';

            		echo '<a href=javascript:void(0) onClick=showArtifactLinks(0,'.$treeId.',2,'.$workSpaceId.','.$workSpaceType.',1,1,0)><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';

				}	

				if (!empty($leafTreeId) && ($isTalkActive==1))

				{		

					echo '<a href='.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/1 target="_blank"><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';

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

                        

                       	<td align="right">

             	

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

                		<a href="javascript:void(0);" onClick="window.location.reload();"><img src="<?php echo base_url(); ?>images/update.gif" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a>

              			</td>

					</tr>

                    <tr id="edit_doc" style="display:none;" class="<?php echo $seedBgColor;?>">

        	

            <td colspan="2">

            <form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/task" onSubmit="return validateDocumentName();">

            	<!--<input name="documentName" id="documentName" type="text" value="<?php //echo $arrDocumentDetails['name'];?>" size="50">-->

                <textarea name="documentName" id="documentName"><?php echo $arrDiscussionDetails['name'];?></textarea><br>

               

            	<a href="javascript:void(0)" onClick="docTitleSave();"><img src="<?php echo base_url(); ?>images/done-btn.jpg" border="0"></a>

                <a href="javascript:void(0)" onClick="docTitleCancel();"><img src="<?php echo base_url(); ?>images/btn-cancel.jpg" border="0"></a>

              

                <input type="hidden" name="treeId" value="<?php echo $treeId; ?>">

            </form>

            <script>chnage_textarea_to_editor('documentName','simple');</script>

            </td>

        	</tr>

		</table>

<?php				

	$userDetails = $this->task_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:none;">

  	<tr>

    	<td align="left" colspan="2">

			<?php 

			$arrStartTime = explode('-',$arrDiscussionDetails['starttime']);

			echo '<span class="style1">'.$userDetails['userTagName'].'</span>';

			?>

		</td>  

  	</tr>

  	<tr>

    	<td align="left" colspan="2">

    	<span id="normalViewTree<?php echo $treeId;?>">

		<a href="javascript:void(0)" onClick="hideBottomMenus(0),showArtifactLinks('0',<?php echo $treeId;?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,1,1)"><?php echo $this->lang->line('txt_Links');?></a>

		&nbsp;&nbsp;<a href="javascript:void(0)" onClick="hideBottomMenus(0),showTagView('0')"><?php echo $this->lang->line('txt_Tags');?></a>

		&nbsp;&nbsp;<a href="javascript:reply(0);"><?php echo $this->lang->line('txt_Add_Task'); ?></a>

        <?php

		if (!empty($leafTreeId))

		{

		?>

        	<a href="<?php echo base_url(); ?>view_talk_tree/node/<?php echo $leafTreeId; ?>/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/ptid/<?php echo $treeId;?>/1" target="_blank"><?php echo $this->lang->line('txt_Talk');?></a>

        <?php

		}

		?>        

        

        </span>

		</td>    

	</tr>

</table>        

        	

<span id="editThis0" style="display:none;  margin-top:0px; margin-left:20px;">

<form name="form30" method="post" action="<?php echo base_url();?>new_task/edit_list_title/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td> <?php echo $this->lang->line('txt_List_Title');?>:</td>

		<td>  <textarea name="taskTitle" id="taskTitle"><?php echo stripslashes($arrDiscussionDetails['name']);?></textarea></td>	

	</tr>	

	<tr>

		<td>&nbsp; </td>

		<td>

				<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_title(document.form30);" class="button01"> 

				&nbsp;&nbsp;&nbsp;&nbsp;

				<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close1(0);" class="button01">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="editStatus" value="1" id="editStatus">		

		</td>	

	</tr>

</table>                

</form>			

</span>								

<div id="reply_teeme0" style="display:none; margin-top:0px; margin-left:20px;">

<form name="form1" method="post" action="<?php echo base_url();?>new_task/node_Task/<?php echo $treeId;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

	<?php if($arrDiscussionDetails['name'] == 'untitled'){?>

	<tr>

		<td id="chat_title">	

			<?php echo $this->lang->line('txt_Task_Title');?>:

		</td>

		<td>

        	<input name="title" type="text" size="40" maxlength="255">

			<input name="titleStatus" type="hidden" value="1">

		</td>	

	</tr>

	 <?php  }

else

{

?>

	<tr>

		<td valign="top">

		<?php echo $this->lang->line('txt_Task');?>: 

		</td>

		<td><textarea name="replyDiscussion" id="replyDiscussion"></textarea></td>

	</tr> 

	<tr>

		<td id="chat_title"> 			

			<?php echo $this->lang->line('txt_Start_Time');?>: 			

		</td>

		<td>

			<input name="titleStatus" type="hidden" value="0">

			<input type="checkbox" name="startCheck" onClick="calStartCheck(this, 0, document.form1,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="starttime" type="text" id="starttime0"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

		</td>

	</tr>

	<tr>

		<td id="chat_title">

		<?php echo $this->lang->line('txt_End_Time');?>: 

		</td>

		<td><input type="checkbox" name="endCheck" onClick="calEndCheck(this, 0, document.form1, '<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="endtime" type="text" id="endtime0" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></td>

	</tr>

    <tr>

    	<td valign="top"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

		<td align="left">

			<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/>                    

		</td>               

    </tr>  

<tr>

    <td valign="top">&nbsp;</td>

    <td valign="top">

    <div id="showMem" style="height:150px; width:300px;overflow:auto;">

        	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/> <?php echo $this->lang->line('txt_Me');?><br />

            <?php

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

			<?php	

                }

            ?>



            <?php	

			if($workSpaceId==0)

			{						

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

						<?php echo $arrData['tagName'];?><br />

			<?php

					}

				}

			}

			else

			{

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

						<?php echo $arrData['tagName'];?><br />

			<?php

					}

				}

			}	

			?>

    </div>

	</td> 

  </tr>

	<tr id="mark_calender0" style="display:none;">

		<td  valign="top">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

		</td>

	    <td  valign="top">&nbsp;

          	<input type="radio" name="calendarStatus" value="Yes">

          	<?php echo $this->lang->line('txt_Yes');?> &nbsp;

          	<input name="calendarStatus" type="radio" value="No" checked>

          	<?php echo $this->lang->line('txt_No');?> 

        </td>

	</tr>

<?php

}

?>

	<tr>

		<td valign="top">&nbsp;</td>

		<td><input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);" class="button01"></td>

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

</div>

<script>chnage_textarea_to_editor('replyDiscussion','simple');</script>



<iframe id="linkIframeId0" width="100%" height="450" scrolling="auto" frameborder="0" style="display:none;"></iframe>

<span id="spanArtifactLinks0" style="display:none;">

</span>	

				<?php		

				/********************************************* Tags *******************************************************/

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

							//$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==1)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';							

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

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

                

                <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(0,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $treeId;?>,1)" />

                <span id="spanTagNew0"><input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(0, <?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" /></span>

				<iframe id="iframeId0" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>

				</span>								

				<?php	

				#*********************************************** Tags ********************************************************			

				?>



				</td>

			  </tr>

		  </table>		

	</td>

        </tr>

	<?php	

	$totalNodes = array();

	

	$rowColor1='rowColor3';

	$rowColor2='rowColor4';	

	$i = 1;

	

	if(count($arrDiscussions) > 0)

	{					 

		foreach($arrDiscussions as $keyVal=>$arrVal)

		{

			$editVisibility = 'none';

			$menusVisibility = 'none';	

/*			if($arrVal['nodeId'] == $selectedNodeId)

			{

				$editVisibility = '';

				$menusVisibility = '';

			}*/			

			$arrActivities 			= array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');

			$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

			$arrNodeTaskUsers 		= $this->task_db_manager->getTaskUsers($arrVal['nodeId'], 2);

			$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

			$position++;

			$totalNodes[] 			= $position;

			$userDetails			= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);				

			$checksucc 				= $this->task_db_manager->checkSuccessors($arrVal['nodeId']);

			$arrStartTime 			= explode('-',$arrVal['starttime']);

			$arrEndTime 			= explode('-',$arrVal['endtime']);

			$this->task_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			

			$viewCheck=$this->task_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);

			$contributorsTagName		= array();

			$contributorsUserId			= array();

			

			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);

			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);

			

			foreach($contributors  as $userData)

			{

				$contributorsTagName[] 	= $userData['userTagName'];

				$contributorsUserId[] 	= $userData['userId'];	

			}

			

			$_SESSION['tmpcount'] = 0;

			$arrNodes = array();	

			$this->task_db_manager->arrNodes = array();			

			if($checksucc)

			{

				$arrNodes = $this->task_db_manager->getNodesBySuccessor($checksucc);			

				$allNodes = implode(',', $arrNodes);

				$subListTime = $this->task_db_manager->getSubListTime($allNodes);					

			}	

			$taskTitle = $this->lang->line('txt_Task');	

			$editStatus = 1;		

			

			

				if ($arrVal['nodeId'] == $this->uri->segment(8))

					$nodeBgColor = 'nodeBgColorSelect';

				else

					$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

			?>			

      <tr>

 		<td width="100%" colspan="5" align="left" valign="top" bgcolor="#FFFFFF">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

			<tr>

				<td>

<span id="latestcontent<?php echo $arrVal['leafId'];?>" style="display:;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo $nodeBgColor;?>">

  <tr>

  		<td colspan="2" width="100%" id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);" class="handCursor">

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

					echo '<a href=javascript:void(0) onClick=showTagView('.$arrVal["nodeId"].')><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';

				}

				else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 

				{echo '&nbsp;&nbsp;';}}

				if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	

				{//echo '[L]&nbsp;';

            		echo '<a href=javascript:void(0) onClick=showArtifactLinks(\''.$arrVal["nodeId"].'\','.$arrVal["nodeId"].',2,'.$workSpaceId.','.$workSpaceType.',2,1)><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';

				}					

				if (!empty($leafTreeId) && ($isTalkActive==1))

				{		

					echo '<a href='.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.' target="_blank"><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';

				}				

			?>

        </td>

  </tr>

  <tr>

  	<td width="4%">

	<?php

	if(!$checksucc)

	{

		$taskTitle = $this->lang->line('txt_Task');

		$editStatus = 0;	

	?>

		&nbsp;&nbsp;

		<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">

		<?php

	}

	else

	{

	?>

    	&nbsp;&nbsp;

        <?php

		if ($this->uri->segment(8))

		{

		?>

        <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>" style="display:none;">

			<img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer">

		</span>

        <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>">

			<img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer">

        </span>

        <?php

		}

		else

		{

		?>

        <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>">

			<img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer">

		</span>

        <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" style="display:none;">

			<img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer">

        </span>        

        <?php

		}

		?>

	<?php

    }

	?>

    </td>

    <td width="96%" id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);" class="handCursor">

 		<?php 

			echo stripslashes($arrVal['contents']); 

		?>

	</td>

  </tr>

</table>



<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:<?php echo $menusVisibility;?>;" class="<?php echo $nodeBgColor;?>">

<tr>

	<td align="left">

<?php 

echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';

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

		<td align="left"><?php echo '<span class="style1">'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?></td>

	</tr>

<?php

}

?>

</table>

</span>

<span class="style1" id="add<?php echo $position;?>" style="display:none;">

<span id="normalView<?php echo $arrVal['nodeId'];?>">



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo $nodeBgColor;?>">

<?php

if(!$checksucc)

{

?>

  <tr>

    <td width="90%" align="left">

	<a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a>	

	&nbsp;&nbsp;<a href="javascript:void(0)" onClick="showTagView('<?php echo $arrVal['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="editthis(<?php echo $arrVal['leafId'];?>, <?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>

    &nbsp;&nbsp;<a href="javascript:addTask(<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>)"><?php echo $this->lang->line('txt_Add_Task');?></a>&nbsp;&nbsp;

	<?php

	if($arrDiscussionDetails['name'] != 'untitled')

	{	

	?>

	<a href="javascript:addSubTaskFrame(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $treeId;?>);"><?php echo $this->lang->line('txt_Add_Sub_Task');?></a>&nbsp;&nbsp;

	<?php

	}

	?>

	<?php

	if (!empty($leafTreeId))

	{

	?>

          <a href="<?php echo base_url(); ?>view_talk_tree/node/<?php echo $leafTreeId; ?>/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/ptid/<?php echo $treeId;?>" target="_blank"><?php echo $this->lang->line('txt_Talk');?></a>

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

	<a href="javascript:void(0)" onClick="hideBottomMenus(<?php echo $arrVal['nodeId'];?>), showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a>	

	&nbsp;&nbsp;

	<a href="javascript:void(0)" onClick="hideBottomMenus(<?php echo $arrVal['nodeId'];?>),showTagView('<?php echo $arrVal['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;

	<a href="javascript:void(0);" onClick="editthis(<?php echo $arrVal['leafId'];?>,<?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;

	<a href="javascript:addTask(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Add_Task');?></a>&nbsp;&nbsp;

	<a href="javascript:addSubTaskFrame(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $treeId;?>);"><?php echo $this->lang->line('txt_Add_Sub_Task');?></a>&nbsp;&nbsp;

	<?php

	if (!empty($leafTreeId))

	{

	?>

          <a href="<?php echo base_url(); ?>view_talk_tree/node/<?php echo $leafTreeId; ?>/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/ptid/<?php echo $treeId;?>" target="_blank"><?php echo $this->lang->line('txt_Talk');?></a>

    <?php

	}

	?> 	

    

    </td><td align="right" style="padding-right:10px;"></td>

    <td align="right"></td>

  </tr>

<?php

}

?>

</table>

</span>



<div id="editThis<?php echo $arrVal['leafId'];?>" style="display:<?php echo $editVisibility;?>; margin-top:0px; margin-left:20px;">

<script>

function showFilteredMembersEditTask(nodeId)

{



	var toMatch = document.getElementById('showMembersEditTask'+nodeId).value;

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

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

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

				document.getElementById('showMemEditTask'+nodeId).innerHTML = val;

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

				document.getElementById('showMemEditTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

</script>

<form name="form3<?php echo $arrVal['leafId'];?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $arrVal['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5" class="<?php echo $nodeBgColor;?>">

  <tr>

    <td valign="top">

		<table border="0" width="100%">

<?php 

$editStartTimeStyle = '';

$editEndTimeStyle = '';

$editStartCalVisible = '';

$editEndCalVisible = '';

$editStartCheck = 'checked';

$editEndCheck = 'checked';

$editStartTime = $arrVal['editStarttime'];

$taskUsers = $this->task_db_manager->getTaskUsers ($arrVal['nodeId'],2);

//echo "<li>taskusers= "; print_r ($taskUsers);

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

		<td> <?php echo $taskTitle;?>:</td>

		<td> <textarea name="edittask<?php echo $arrVal['leafId'];?>" id="edittask<?php echo $arrVal['leafId'];?>"><?php echo stripslashes($arrVal['contents']);?></textarea></td>	

	</tr>

	<?php

	if(!$checksucc)

	{

		

	?>

	<tr>

		<td> <?php echo $this->lang->line('txt_Start_Time');?>:</td>

		<td>  <input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editStartCheck;?>> <input name="starttime" type="text" id="starttime<?php echo $arrVal['leafId'];?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>><span id="calStart<?php echo $arrVal['leafId'];?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrVal['leafId'];?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>



	</tr>

	<tr>

		<td> <?php echo $this->lang->line('txt_End_Time');?>:</td>

		<td> <input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $arrVal['leafId'];?>', document.form3<?php echo $arrVal['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $arrVal['leafId'];?>" value="<?php echo $editEndTime;?>" <?php echo $editEndTimeStyle;?>><span id="calEnd<?php echo $arrVal['leafId'];?>" <?php echo $editEndCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrVal['leafId'];?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>	

	</tr>

   <?php

	if ($editStartCheck || $editEndCheck)

	{

	?>	

    <tr id="mark_calender<?php echo $arrVal['leafId'];?>">

    <?php

	}

	else

	{

	?>

    <tr id="mark_calender<?php echo $arrVal['leafId'];?>" style="display:none;">

    <?php

	}

	?>	

		<td  valign="top">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

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

   	 	<td valign="top"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

		<td align="left" colspan="2">

			<input type="text" id="showMembersEditTask<?php echo $arrVal['nodeId'];?>" name="showMembersEditTask<?php echo $arrVal['nodeId'];?>" onkeyup="showFilteredMembersEditTask(<?php echo $arrVal['nodeId'];?>)"/>                    

		</td>               

	</tr>    

    <tr>

    	<td valign="top">&nbsp;</td>

    	<td valign="top">

    		<div id="showMemEditTask<?php echo $arrVal['nodeId'];?>" style="height:150px; width:300px;overflow:auto;">

        	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> <?php echo $this->lang->line('txt_Me');?><br />

        	<?php

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

			<?php	

                }

            ?>



            <?php	

			if($workSpaceId==0)

			{								

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

		</td>

    </tr> 



<tr>

	<td align="left">

		

	<?php echo $this->lang->line('txt_Completion_Status');?>:</td>

	<td align="left">

	 <input type="radio" name="completionStatus" value="1" <?php if($nodeTaskStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeTaskStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeTaskStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeTaskStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;

	</td>

	  </tr>

	<?php

		

	}

	?>	

		<tr>

		<td>&nbsp; </td>

		<td>

        	<?php

        	if(!$checksucc)

			{

			?>

         	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('edittask<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close(<?php echo $arrVal['leafId'];?>, <?php echo $arrVal['nodeId'];?>);" class="button01">

			<?php

			}

			else

			{

			?>

         	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_title('edittask<?php echo $arrVal['leafId'];?>',document.form3<?php echo $arrVal['leafId'];?>);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="edit_close(<?php echo $arrVal['leafId'];?>, <?php echo $arrVal['nodeId'];?>);" class="button01">

            <?php

			}

			?>

            

            <input name="reply" type="hidden" id="reply" value="1">

			<input name="editorname1" type="hidden" value="edittask<?php echo $arrVal['leafId'];?>">

			<input name="nodeId" type="hidden"  value="<?php echo $arrVal['nodeId'];?>">

			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

			<input type="hidden" name="treeId" value="<?php echo $treeId;?>" id="treeId">

			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

			<input type="hidden" name="titleStatus" value="0" id="titleStatus">

			<input type="hidden" name="editStatus" value="<?php echo $editStatus;?>" id="editStatus">

			<input type="hidden" name="urlToGo" value="view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

			<input type="hidden" name="taskId" value="<?php echo $arrVal['nodeId'];?>"> 				

		</td>	

	</tr>

</table>

</td>

  </tr> 

</table>                

</form>

</div>



<!-- This is only for New task -->

<?php 

if($arrDiscussionDetails['name'] == 'untitled')

{

?>

<div id="reply_teeme0" style="display:none;  margin-top:0px; margin-left:20px;">

<form name="form1" method="post" action="<?php echo base_url();?>new_task/node_Task/<?php echo $treeId;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

	<tr>

	<td id="chat_title">	

		<?php echo $this->lang->line('txt_Task_Title');?>:

	</td>

	<td>

       	<input name="title" type="text" size="40" maxlength="255">

		<input name="titleStatus" type="hidden" value="1">

	</td>	

	</tr>

	

	<tr>

		<td valign="top">&nbsp;</td>

		<td><input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_title(replyDiscussion,document.form1);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);" class="button01"></td>

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

</div>

<?php

}

?>



<div id="add_task<?php echo $position;?>" style="display:none; margin-top:0px; margin-left:20px;">

<form name="formAddTask<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_task/new_task1/<?php echo $treeId;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

<tr>

    <td valign="top">

		<?php echo $this->lang->line('txt_Task');?>: 

	</td>

    <td>

		<textarea name="newTask<?php echo $arrVal['nodeId'];?>" id="newTask<?php echo $arrVal['nodeId'];?>" rows="5" cols="40"></textarea>

	</td>

</tr>

<tr>

    <td> 

			<?php echo $this->lang->line('txt_Start_Time');?>: 

	</td>

	<td>

		<input type="checkbox" id="startCheckAddTask" name="startCheckAddTask" onClick="calStartCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')">

        <input name="starttime" type="text" id="starttime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">

        <span id="calStart<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAddTask<?php echo $position;?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr>

<tr>

	<td> 

		<?php echo $this->lang->line('txt_End_Time');?>: 

	</td>

	<td>

		<input type="checkbox" id="endCheckAddTask" name="endCheckAddTask" onClick="calEndCheck(this, <?php echo $position;?>, document.formAddTask<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAddTask<?php echo $position;?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span>

    </td>

</tr> 

    <tr>

    	<td valign="top"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

		<td align="left">

			<input type="text" id="showMembersAddTask<?php echo $arrVal['nodeId'];?>" name="showMembersAddTask<?php echo $arrVal['nodeId'];?>" onkeyup="showFilteredMembersAddTask(<?php echo $arrVal['nodeId'];?>)"/>                    

		</td>               

    </tr> 

<tr>

    <td valign="top">&nbsp;</td>

    <td valign="top">

    <div id="showMemAddTask<?php echo $arrVal['nodeId'];?>" style="height:150px; width:300px;overflow:auto;">

        	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/> <?php echo $this->lang->line('txt_Me');?><br />

        	<?php

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

			<?php	

                }

            ?>

            <?php	

			

			if($workSpaceId==0)

			{							

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

						<?php echo $arrData['tagName'];?><br />

			<?php

					}

				}

			}

			else

			{

				foreach($workSpaceMembers as $arrData)

				{

					if($_SESSION['userId'] != $arrData['userId'])

					{						

			?>

                    	<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

						<?php echo $arrData['tagName'];?><br />

			<?php

					}

				}

			}

			?>

    </div>     

	</td>

</tr>

<tr id="mark_calender<?php echo $position;?>" style="display:none;">

	<td valign="top">

		<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

	</td>

	<td valign="top">&nbsp;

		<input type="radio" name="calendarStatus" value="Yes">

		<?php echo $this->lang->line('txt_Yes');?> &nbsp;

		<input name="calendarStatus" type="radio" value="No" checked>

		<?php echo $this->lang->line('txt_No');?> 

	</td>	   

</tr>

<tr>

	<td>&nbsp;</td>

	<td>

		<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_task('newTask<?php echo $arrVal['nodeId'];?>',document.formAddTask<?php echo $position;?>);" class="button01"> <input type="button" name="Replybutton1" value="Cancel" onClick="addTaskClose(<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>);" class="button01">

    	<input name="reply" type="hidden" id="reply" value="1">

		<input name="editorname1" type="hidden" value="newTask<?php echo $arrVal['nodeId'];?>">

		<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

		<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

		<input type="hidden" name="titleStatus" value="0" id="titleStatus">

		<input name="nodeId" type="hidden" value="<?php echo $arrVal['nodeId'];?>">

		<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

		<input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

		<input name="parentNode" type="hidden" id="parentNode" value="0">

	</td>

</tr>

</table>

</form>



</div>



<!-- End This is only for New task -->



<span id="spanSubTaskView<?php echo $position;?>" style="display:none;">

	<ul class="rtabs">

    	<li><a href="javascript:void(0)" onClick="hideSubTaskView(<?php echo $position;?>);" class="current"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>

    </ul>

</span>

<iframe id="iframeIdSubTask<?php echo $position;?>" align="left" width="700" height="600" scrolling="auto" frameborder="0" style="display:none;"></iframe>



			<?php

				#********************************************* Tags ********************************************************88

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;		

			?>

                <iframe id="linkIframeId<?php echo $arrVal['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>



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

							//$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==1)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';						

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	

						

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

                

                	<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,2)" />

					<span id="spanTagNew<?php echo $arrVal['nodeId'];?>"><input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" /></span>



				<iframe id="iframeId<?php echo $arrVal['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>

				</span>								

				<?php	

				#*********************************************** Tags *******************************************************

				?>

				</td>

			</tr>

            </table>

		</td>

        </tr>

<?php

/******* Parv - Start Sub Tasks  ***********/

if ($this->uri->segment(8))

{

?>

<tr id="subTasks<?php echo $arrVal['nodeId'];?>">

<?php

}

else

{

?>

<tr id="subTasks<?php echo $arrVal['nodeId'];?>" style="display:none;">

<?php

}

?>

	<td width="5%" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>

	<td width="95%" colspan="4" align="left" valign="top" bgcolor="#FFFFFF">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<?php 

	if($checksucc)

	{		//print_r($arrparent);	

			$counter = 0;

			

			$rowColor3='rowColor3';

			$rowColor4='rowColor4';	

			$j = 1;

				if ($arrVal['nodeId'])

				{

					$selectedNodeId = $arrVal['nodeId'];

				}		

			$arrChildNodes = $this->task_db_manager->getChildNodes($arrVal['nodeId'], $treeId);	

			$sArray = array();

			//$sArray=explode(',',$arrparent['successors']);

			$sArray = $arrChildNodes;



			while($counter < count($sArray)){



				$arrDiscussions=$this->task_db_manager->getPerentInfo($sArray[$counter]);

				//echo "<li>";

				//print_r ($arrDiscussions);

				$editVisibility = 'none';

				$menusVisibility = 'none';	

/*				if($arrDiscussions['nodeId'] == $selectedNodeId)

				{

					$editVisibility = '';

					$menusVisibility = '';

				}*/

				$position++;

				$totalNodes[] = $position;

				$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);

				$checksucc =$this->task_db_manager->checkSuccessors($arrDiscussions['nodeId']);

				$arrActivities = array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');

				$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

				$arrNodeTaskUsers 	= $this->task_db_manager->getTaskUsers($arrDiscussions['nodeId'], 2);

				$nodeTaskStatus 	= $this->task_db_manager->getTaskStatus($arrDiscussions['nodeId']);

				//	$this->task_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 

				//	$viewCheck	= $this->task_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);

				$arrNodes = array();	

				$this->task_db_manager->arrNodes = array();		

				

				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrDiscussions['nodeId']);

				$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);				

				

				

				if($checksucc)

				{

					$arrNodes = $this->task_db_manager->getNodesBySuccessor($checksucc);					

					$allNodes = implode(',', $arrNodes);

					$subListTime = $this->task_db_manager->getSubListTime($allNodes);											

				}

									

				$arrStartTime 		= explode('-',$arrDiscussions['starttime']);

				$arrEndTime 		= explode('-',$arrDiscussions['endtime']);

				$contributors 				= $this->task_db_manager->getTaskContributors($arrDiscussions['nodeId']);

				$contributorsTagName		= array();

				$contributorsUserId			= array();	

				foreach($contributors  as $userData)

				{

					$contributorsTagName[] 	= $userData['userTagName'];

					$contributorsUserId[] 	= $userData['userId'];	

				}	

				$taskTitle = $this->lang->line('txt_Task');	

				$editStatus = 0;	

				

				

					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))

						$nodeBgColor = 'nodeBgColorSelect';

					else

						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;		

				?>



	<tr>

		<td width="26">&nbsp;</td>

		<td>

			<span id="latestcontent<?php echo $arrDiscussions['leafId'];?>">

            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo $nodeBgColor;?>">

            <tr>

			<td colspan="2">		

			<span id="img<?php echo $position;?>">

			<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> </span> 

			<?php

			$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

			$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

			$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

			$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);

				

			$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1, 2);

			$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2, 2);

			$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3, 2);

			$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4, 2);

			$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5, 2);

			$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6, 2);

			$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'], 2);		

					

					

				if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)

				{//echo '[T]&nbsp;';			

					echo '<a href=javascript:void(0) onClick=showTagView('.$arrDiscussions["nodeId"].')><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';

				}

				else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 

					{echo '&nbsp;&nbsp;';}}

				if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	

				{//echo '[L]&nbsp;';

            		echo '<a href=javascript:void(0) onClick=showArtifactLinks(\''.$arrDiscussions["nodeId"].'\','.$arrDiscussions["nodeId"].',2,'.$workSpaceId.','.$workSpaceType.',2,1)><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';

				}

				if (!empty($leafTreeId) && ($isTalkActive==1))

				{		

					echo '<a href='.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.' target="_blank"><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';

				}				

				

			?>	

 			</td>

            </tr>

		  	<tr>	

			<td width="4%" class="handCursor">		

			<?php

			if(!$checksucc)

			{

			?>

				&nbsp;&nbsp;

				<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">

			<?php

			}

			?>

            </td>

            <td width="96%" id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);" class="handCursor">

				<?php																

 					echo stripslashes($arrDiscussions['contents']);

				?>

 			</td>

  			</tr>  

</table>

</span>

<div id="editThis<?php echo $arrDiscussions['leafId'];?>" style="display:<?php echo $editVisibility;?>; margin-top:0px; margin-left:20px;">

<?php 

$editStartTimeStyle = '';

$editEndTimeStyle = '';

$editStartCalVisible = '';

$editEndCalVisible = '';

$editStartCheck = 'checked';

$editEndCheck = 'checked';

$editStartTime = $arrDiscussions['editStarttime'];

$taskUsers = $this->task_db_manager->getTaskUsers($arrDiscussions['nodeId'], 2);

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

<form name="form3<?php echo $arrDiscussions['leafId'];?>" method="post" action="<?php echo base_url();?>new_task/leaf_edit_Task/<?php echo $arrDiscussions['leafId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

    <td valign="top">

<table border="0" width="100%">



	<tr>

		<td> <?php echo $taskTitle;?>:</td>

		<td> <textarea name="edittask<?php echo $arrDiscussions['leafId'];?>" id="edittask<?php echo $arrDiscussions['leafId'];?>" rows="3" cols="35"><?php echo stripslashes($arrDiscussions['contents']);?></textarea></td>	

	</tr>	

	<?php

	if(!$checksucc)

	{		

	?>

	<tr>

		<td><?php echo $this->lang->line('txt_Start_Time');?>:</td>

		<td><input type="checkbox" name="startCheck" onClick="calStartCheck(this, '<?php echo $arrDiscussions['leafId'];?>', document.form3<?php echo $arrDiscussions['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editStartCheck;?>><input name="starttime" type="text" id="starttime<?php echo $arrDiscussions['leafId'];?>"  value="<?php echo $editStartTime;?>" <?php echo $editStartTimeStyle;?>><span id="calStart<?php echo $arrDiscussions['leafId'];?>" <?php echo $editStartCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrDiscussions['leafId'];?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>



	</tr>

	<tr>

		<td> <?php echo $this->lang->line('txt_End_Time');?>:</td>

		<td><input type="checkbox" name="endCheck" onClick="calEndCheck(this, '<?php echo $arrDiscussions['leafId'];?>', document.form3<?php echo $arrDiscussions['leafId'];?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')" <?php echo $editEndCheck;?>><input name="endtime" type="text" id="endtime<?php echo $arrDiscussions['leafId'];?>" value="<?php echo $editEndTime;?>"  <?php echo $editEndTimeStyle;?>><span id="calEnd<?php echo $arrDiscussions['leafId'];?>" <?php echo $editEndCalVisible;?>><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form3<?php echo $arrDiscussions['leafId'];?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span></td>	

	</tr>

    <?php

	if ($editStartCheck || $editEndCheck)

	{

	?>	

    <tr id="mark_calender<?php echo $arrDiscussions['leafId'];?>">

    <?php

	}

	else

	{

	?>

	<tr id="mark_calender<?php echo $arrDiscussions['leafId'];?>" style="display:none;">

	<?php

    }

	?>

		<td valign="top">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

		</td>

	    <td  valign="top">&nbsp;

			<input type="radio" name="calendarStatus" value="Yes" <?php if($arrDiscussions['viewCalendar'] == 1) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_Yes');?> &nbsp;

			<input name="calendarStatus" type="radio" value="No" <?php if($arrDiscussions['viewCalendar'] == 0) { echo 'checked'; }?>>

			<?php echo $this->lang->line('txt_No');?> 

		</td>	   

	</tr>

	<tr>

   	 	<td valign="top"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

		<td align="left" colspan="2">

			<input type="text" id="showMembersEditSubTask<?php echo $arrDiscussions['nodeId'];?>" name="showMembersEditSubTask<?php echo $arrDiscussions['nodeId'];?>" onkeyup="showFilteredMembersEditSubTask(<?php echo $arrDiscussions['nodeId'];?>)"/>                    

		</td>               

	</tr>    

    <tr>

    	<td valign="top">&nbsp;</td>

    	<td valign="top">

    		<div id="showMemEditSubTask<?php echo $arrDiscussions['nodeId'];?>" style="height:150px; width:300px;overflow:auto;">

        	<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taskUsers)) { echo 'checked="checked"';}?>/> <?php echo $this->lang->line('txt_Me');?><br />           

            <?php

				if (count($sharedMembers)!=0)

				{

			?>

            		<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

			<?php	

                }

            ?>

            <?php	

			if($workSpaceId==0)

			{								

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

		</td>

    </tr> 	        

	<tr>

	<td align="left">

	<?php echo $this->lang->line('txt_Completion_Status');?>:</td>

	<td align="left">

	<input type="radio" name="completionStatus" value="1" <?php if($nodeTaskStatus == 1) { echo 'checked'; }?>>25% &nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="2" <?php if($nodeTaskStatus == 2) { echo 'checked'; }?>>50%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="3" <?php if($nodeTaskStatus == 3) { echo 'checked'; }?>>75%	&nbsp;&nbsp;&nbsp;<input type="radio" name="completionStatus" value="4" <?php if($nodeTaskStatus == 4) { echo 'checked'; }?>>Completed	&nbsp;&nbsp;

	</td>

	</tr>

	<?php

	}

	?>

<tr>

		<td>&nbsp; </td>

		<td>

				<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validateSubTaskEdit('edittask<?php echo $arrDiscussions['leafId'];?>',document.form3<?php echo $arrDiscussions['leafId'];?>);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="edit_close(<?php echo $arrDiscussions['leafId'];?>,<?php echo $arrDiscussions['nodeId'];?>);" class="button01">

		        <input name="reply" type="hidden" id="reply" value="1">

				<input name="editorname1" type="hidden" value="edittask<?php echo $arrDiscussions['leafId'];?>">

				<input name="nodeId" type="hidden"  value="<?php echo $arrDiscussions['nodeId'];?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="urlToGo" value="view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="urlToGo">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="taskId" value="<?php echo $arrDiscussions['nodeId'];?>"> 

				<input type="hidden" name="editStatus" value="<?php echo $editStatus;?>" id="editStatus">		

		</td>	

	</tr>

</table>

</td>

</tr>

</table>

</form>

</div>



<div id="add_task<?php echo $position;?>" style="display:none;  margin-top:0px; margin-left:20px;">

<form name="formAdd<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_task/new_task1/<?php echo $treeId;?>"><table width="100%" border="0" cellspacing="0" cellpadding="5">

<tr>

    <td valign="top">

<?php echo $this->lang->line('txt_Task');?>: 

	</td><td>

		<textarea id="newTask" name="newTask"></textarea>

</td>

</tr>

<tr>

    <td id="chat_title"> 

		<?php echo $this->lang->line('txt_Start_Time');?>: 

	</td>

	<td>

		<input type="checkbox" name="startCheck" onClick="calStartCheck(this, <?php echo $position;?>, document.formAdd<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="starttime" type="text" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAdd<?php echo $position;?>.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr>

<tr>

	<td> 

		<?php echo $this->lang->line('txt_End_Time');?>: 

	</td>

	<td>

		<input type="checkbox" name="endCheck" onClick="calEndCheck(this, <?php echo $position;?>, document.formAdd<?php echo $position;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd<?php echo $position;?>" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.formAdd<?php echo $position;?>.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span>

	</td>

</tr>  

<tr>

    <td valign="top"><?php echo $this->lang->line('txt_Assigned_To');?></td>

    <td valign="top">

	<select name="taskUsers[]" multiple>

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

	<tr id="mark_calender<?php echo $position;?>" style="display:none;">

		<td valign="top">

			<?php echo $this->lang->line('txt_Mark_to_calendar');?>:

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

	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_task('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>',document.formAdd<?php echo $position;?>);" class="button01"> <input type="button" name="Replybutton1" value="Cancel" onClick="addTaskClose(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);" class="button01">

    <input name="reply" type="hidden" id="reply" value="1">

	<input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>">

	<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

	<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

	<input type="hidden" name="titleStatus" value="0" id="titleStatus">

	<input name="nodeId" type="hidden" value="<?php echo $arrDiscussions['nodeId'];?>">

	<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

	<input name="nodePosition" type="hidden" id="nodePosition" value="<?php echo $position;?>">

	<input name="parentNode" type="hidden" id="parentNode" value="<?php echo $arrVal['nodeId'];?>">

</td></tr>

</table>

</form>

<script>chnage_textarea_to_editor('newTask','simple');</script>

</div>

<span id="normalView<?php echo $arrDiscussions['nodeId'];?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:<?php echo $menusVisibility;?>;">

	 <tr>

    <td width="90%" align="left" colspan="2"><span class="style1" id="add<?php echo $position;?>" style="display:none;">

<?php  

echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';



if(!$checksucc)

{

	echo '<span class="style1">'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';

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

		<a href="javascript:void(0);" onClick="hideBottomMenus(<?php echo $arrDiscussions['nodeId'];?>),showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

		<a href="javascript:void(0);" onClick="hideBottomMenus(<?php echo $arrDiscussions['nodeId'];?>),showTagView('<?php echo $arrDiscussions['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp;

		<a href="javascript:void(0);" onClick="editthis(<?php echo $arrDiscussions['leafId'];?>, <?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;&nbsp;<?php if( $arrDiscussions['leafParentId']){?><a href="javascript:void(0);" onClick="getnext(<?php echo $arrDiscussions['leafParentId'];?>,'latestcontent<?php echo $arrDiscussions['leafId'];?>');"><img border="0" src="<?php echo base_url();?>images/left.gif" ></a><?php }?>&nbsp;

        <?php

		if (!empty($leafTreeId))

		{

		?>

        	<a href="<?php echo base_url(); ?>view_talk_tree/node/<?php echo $leafTreeId; ?>/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/ptid/<?php echo $treeId;?>" target="_blank"><?php echo $this->lang->line('txt_Talk');?></a>

        <?php

		}

		?>        

       </td>

        <td align="right" style="padding-right:10px;"></td>			

	

    

    </tr>

	<?php

}

else

{

?>

	<tr>

		<td width="90%" align="left" colspan="2"> 

		<a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp;	

		<a href="javascript:void(0);" onClick="showTagView('<?php echo $arrDiscussions['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp;

		<a href="javascript:void(0);" onClick="editthis(<?php echo $arrDiscussions['leafId'];?>,<?php echo $arrDiscussions['nodeId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>

        <?php

		if (!empty($leafTreeId))

		{

		?>

        	<a href="<?php echo base_url(); ?>view_talk_tree/node/<?php echo $leafTreeId; ?>/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/ptid/<?php echo $treeId;?>" target="_blank"><?php echo $this->lang->line('txt_Talk');?></a>

        <?php

		}

		?> 	

    

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

                

                <iframe id="linkIframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>

                

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

							//$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';	

							if ($tagData['tag']==1)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';															

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	

						

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

                

                <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)" />

				<span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>"><input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1,<?php echo $arrDiscussions['nodeId']; ?>)"/></span>

                			

				<iframe id="iframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>

				</span>								

				<?php	

				#*********************************************** Tags ********************************************************	

				?>

	</td>

	<td width="25">&nbsp;</td>

</tr>



				<?php

				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];

				$counter++;

				$j++;

			}		

	}	

	?>

</table>

</td>

</tr>

<?php

/******* Parv - Finish Sub Tasks ***********/

?>        

		<?php

		$i++;

		}		

	}

?> 

<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

</table>

     

					<!-- Main Body -->

					</td>

              	</tr>

            	</table>

            </td>

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

</table>

</body>

</html>

<script>

		// Parv - Keep Checking for tree updates every 5 second

		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 20000);

		

</script>