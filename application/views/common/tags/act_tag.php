<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
	if($artifactType == 2)
	{
		if($artifactId!='')
		{
			$draftLeafData = $this->identity_db_manager->getLeafIdByNodeId($artifactId);
			if($draftLeafData['id']!='')
			{
				$dLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($draftLeafData['id']);
				//echo $dLeafStatus.'==';
				if($dLeafStatus == 'draft')
				{
					//echo $leafParentData['parentLeafId'];
					$draftNodeData = $this->identity_db_manager->getNodeDetailsByNodeId($artifactId);
			
					$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($draftNodeData['treeId'], $draftNodeData['nodeOrder']);	
				
					$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
					$draftResUserIds = array();
					foreach($draftReservedUsers  as $draftResUserData)
					{
						$draftResUserIds[] = $draftResUserData['userId']; 
					}
				}
			}
			/*print_r($draftResUserIds);
			echo '==';*/
		}
		
	}
	if ($editTagId)
	{  
	    
		$arrTagDetails1 = $this->tag_db_manager->getTagDetailsByTagId ($editTagId);	
		$tagOptions = $this->tag_db_manager->getSelectionOptions ($editTagId);
		$taggedUsers = $this->tag_db_manager->getTaggedUsersByTagId ($editTagId);
		$votingTopic = $this->tag_db_manager->getVotingTopic ($editTagId);
		
		
	}
$appliedTagIds = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTagIds[] = $tagData['tagId'];
	}
}

$appliedTags = implode(',',$appliedTagIds);

?>
<?php $this->load->view("common/datepicker_js");?>
<script>
function showTags()
{
	var toMatch = document.getElementById('searchTags').value;
	var val = '';
	
		
		if (1)
		{
		var count = '';
		var sectionChecked = '';
		<?php

		foreach($tags as $tagData)	
		{
		?>
			var str = '<?php echo $tagData['comments']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			
			
			if (str.match(pattern))
			{
			
				count = count + ','+<?php echo $tagData['tagId']; ?>;
				
				<?php if (in_array($tagData['tagId'],$appliedTagIds)) { ?>
				sectionChecked = sectionChecked + ','+<?php echo $tagData['tagId']; ?>;
				<?php } ?>
				
				<?php
					$dateNow = date('Y-m-d H:i:s');
					if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
					{
				?>
						val +=  '<input type="checkbox" name="unAppliedTags[]" value="<?php echo $tagData['tagId'];?>" <?php //if (in_array($tagData['tagId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['comments'];?>&nbsp;<a href="<?php echo base_url();?>add_tag/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $artifactId; ?>/<?php echo $artifactType; ?>/<?php echo $sequenceTagId; ?>/<?php echo $tagOption;?>/<?php echo $tagData['tagId'];?>" title="<?php echo $this->lang->line('txt_Edit');?>"><?php echo $this->lang->line('txt_Edit');?></a><br>';
						document.getElementById('showTagsAction').innerHTML = val;
				<?php
					}
				?>
		
			}
        
		<?php
        }
        ?>
			if (count!='')
			{
				document.getElementById('sectionTagIds').value = count;
			}
			if (sectionChecked!='')
			{
				document.getElementById('sectionChecked').value = sectionChecked;
			}
		
			document.getElementById('showTagsAction').style.display = 'block';
		}
		else
		{
			document.getElementById('showTagsAction').style.display = 'none';
		}

}


function showFilteredMembers()
{
	var toMatch = document.getElementById('showMembers').value;
	var val = '';
		if (1)
		{
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" class="users" name="taggedUsers" id="taggedUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php

			
			if ($workSpaceId != 0)
			{	
				?>		
			
				<?php
				foreach($workSpaceMembers as $arrData)	
				{
					if (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)))
					{
						?>
						var str = '<?php echo $arrData['tagName']; ?>';
						
						var pattern = new RegExp('\^'+toMatch, 'gi');
						
						if (str.match(pattern))
						{
							val +=  '<input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
							document.getElementById('showMem').innerHTML = val;
						}
						<?php
					}
				}
				
				foreach($workSpaceMembers as $arrData)	
				{
					if (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)))
					{
						?>
						var str = '<?php echo $arrData['tagName']; ?>';
						
						var pattern = new RegExp('\^'+toMatch, 'gi');
			
						if (str.match(pattern))
						{
							val +=  '<input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
							document.getElementById('showMem').innerHTML = val;
						}
						<?php
					}
				}
			}
			else
			{

				if (count($sharedMembers)!=0)
				{
			?>
		
			<?php
				}	
				foreach($workSpaceMembers as $arrData)	
				{
					if (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)))
					{
						?>
						var str = '<?php echo $arrData['tagName']; ?>';
						
						var pattern = new RegExp('\^'+toMatch, 'gi');
						
						
			
						if (str.match(pattern))
						{
							val +=  '<input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
							document.getElementById('showMem').innerHTML = val;
						}
					
						<?php
					}
				}
				
				foreach($workSpaceMembers as $arrData)	
				{
					if (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)))
					{
						?>
						var str = '<?php echo $arrData['tagName']; ?>';
						
						var pattern = new RegExp('\^'+toMatch, 'gi');
			
						if (str.match(pattern))
						{
							val +=  '<input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
							document.getElementById('showMem').innerHTML = val;
						}
					
						<?php
					}
				}
			}
        	?>

		}
}

function validateTagUpdate ()
{
	if (document.getElementById('searchTags').value=='')
	{
		jAlert ('<?php echo $this->lang->line('select_tags_update'); ?>');
		return false;
	}
}

$(document).ready(function(){
		//$("#endTime").datepicker({dateFormat:"dd-mm-yy"});
		loadDatePicker();

	});

</script>

<!--Changed by Dashrath- Add background-color in inline css-->
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" class="tabBg" style="background-color: #E9EBEE;">
  <tr>
    <td valign="top">
		<!--<form name="frmTag0" method="post" action="<?php echo base_url();?>create_tag1">-->
		<form name="frmTag0" method="post">
        <input type="hidden" id="treeIdDelete" name="treeIdDelete" value="<?php echo $treeId; ?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
          <tr>
            <td valign="top" width="35%"><?php echo $this->lang->line('txt_Search_Tags');?>: </td>
            <td><input type="text" id="searchTagsAction" name="searchTagsAction" onkeyup="show_action_Tags(<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>)"/></td>
          </tr>
          <tr>
            <td valign="top" colspan="2"><?php echo $this->lang->line('txt_Applied_Tags');?>: </td>
          </tr>
          <tr>
            <td colspan="2"><div id="showTagsAction" style="display:block;width: 250px; height: 180px; overflow:auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
                <?php
			$count = '';
			$sectionChecked = '';
			//print_r($tags);
			foreach($tags as $tagData)	
			{  
				$count .= ',' .$tagData['tagId'];
				
				if (in_array($tagData['tagId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagId'];
 				} 
				$dateNow = date('Y-m-d H:i:s');
				//echo "<li>end= " .$tagData['endTime'];
				if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
				{
			?>
                <input type="checkbox" name="unAppliedTagsActionDelete" value="<?php echo $tagData['tagId'];?>" <?php //if (in_array($tagData['tagId'],$appliedTagIds)) {echo 'checked="checked"';}?>/>
                <?php echo $tagData['comments'];?>&nbsp;<a href="javaScript:void(0)" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,<?php echo $tagData['tagId'];?>)" title="Edit"><?php echo $this->lang->line('txt_Edit');?></a><br />
                <?php
				}
        	}

			if (!$tags)
			{

				echo $this->lang->line('txt_None');
			}
        	?>
              </div>
              <br />
              <input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Delete');?>" class="button01" onClick="submit_action_tags_form()" />
              <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
              <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
              <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
              <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
              <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
              <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceId;?>">
              <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">
              <input type="hidden" name="tagOption"  id="tagOption" value="<?php echo $tagOption;?>">
              <input type="hidden" id="sectionTagIds" name="sectionTagIds" value="<?php echo $count;?>">
              <input type="hidden" id="sectionCheckedAction" name="sectionCheckedAction" value="<?php echo $sectionChecked;?>">
              <input type="hidden"  id="appliedTags" name="appliedTags" value="<?php echo $appliedTags;?>">
              <input type="hidden" name="addOption" id="addOption" value="update">
			  <div class="actionDeleteTagLoader" id="actionDeleteTagLoader"></div>
			  </td>
          </tr>
        </table>
      </form></td>
    <td><?php
if (!$editTagId)
{

?>
      <form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" >
	  <input value="<?php echo $_SESSION['userId'];?>" id="list" type="hidden" />
        <input type="hidden" id="treeId1" name="treeId1" value="<?php echo $treeId; ?>" />
		
        <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center"  class="blue-border">
          <tr>
            <td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Type');?>: </td>
            <td colspan="2" align="left" valign="top"><?php
	if($sequenceTagId == 0)
	{
	?>
              <select name="tagType" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
                <option value="1" selected><?php echo $this->lang->line('txt_ToDo');?></option>
                <option value="2"><?php echo $this->lang->line('txt_Select');?></option>
                <option value="3"><?php echo $this->lang->line('txt_Vote');?></option>
                <option value="4"><?php echo $this->lang->line('txt_Authorize');?></option>
              </select>
              <?php
	}
	else
	{
	?>
              <select name="tag" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
                <option value="4"><?php echo $this->lang->line('txt_Authorize');?></option>
              </select>
              <?php
	}
	?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Name');?>: </td>
            <td colspan="2" align="left" valign="top"><input name="tagComments" type="text" id="tagComments" maxlength="255"></td>
          </tr>
          <tr>
            <td colspan="3"><span id="voteTag" style="display:none;">
              <table width="100%">
                <tr>
                  <td align="left" valign="middle" width="30%"><?php echo $this->lang->line('msg_voting_question');?>: </td>
                  <td colspan="2" align="left" valign="top"><input type="text" name="voteQuestion" id="voteQuestion"></td>
                </tr>
              </table>
              </span> <span id="selectionTag" style="display:none;">
              <table width="100%">
                <tr>
                  <td width="30%" align="left" valign="top"><?php echo $this->lang->line('msg_enter_options');?>: </td>
                  <td align="left" valign="top"><input type="hidden" id="noOfOptions" name="noOfOptions" value="2">
                    <span id="optionFields"> 
                    <!--<input type="text" name="selectionOptions[]" id="selectionOptions[]"> -->
                    <input type="text"   name="selectionOptionsAction"  >
                    </span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><a href="javascript:void(0)" onClick="addOptions('optionFields')"><?php echo $this->lang->line('txt_Add_More');?></a></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table>
              </span></td>
          </tr>
          <tr>
            <td align="left" valign="top" colspan="3"><?php echo $this->lang->line('txt_Action_Required_On');?>: </td>
          <tr>
            <td align="left" valign="top"><?php echo $this->lang->line('txt_Search_Users');?>: </td>
            <td colspan="2" align="left" valign="top"><input type="text" id="showMembers1" name="showMembers1" onkeyup="showFilteredMembers1(0,'<?php echo $treeId; ?>','<?php echo $artifactId; ?>')"/>
              <br />
              <?php
			  //echo count($draftReservedUsers);
			  
							if($workSpaceId==0)
							{  
								
								if (count($sharedMembers)!=0)
								{
 								?>
              <input type="checkbox" class="allcheck" name="taggedUsers" value="0"/>
              <?php echo $this->lang->line('txt_All');?><br />
              <?php
								}
								?>
              <div id="showMem31" style="height:110px;overflow:auto; width:45%;" class="usersList">
              <input type="checkbox" id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>
              <?php echo $this->lang->line('txt_Me');?><br />
              <?php
								foreach($workSpaceMembers as $arrData)
								{
									if (($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers) && ((!empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds)) || count($draftReservedUsers)==0) && $dLeafStatus=='draft') || ($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers) && $dLeafStatus!='draft'))
									{
							?>
              <input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" />
              <?php echo $arrData['tagName'];?><br />
              <?php
									}
								}
							}
							else
							{
							?>
              <input type="checkbox" class="allcheck" name="taggedUsers" value="0"/>
              <?php echo $this->lang->line('txt_All');?><br />
              <div id="showMem31" style="height:110px;overflow:auto; width:45%;" class="usersList">
                <input type="checkbox" id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>
                <?php echo $this->lang->line('txt_Me');?><br />
                <?php
							
                            	foreach($workSpaceMembers as $arrData)
								{
									if (($arrData['userId'] != $_SESSION['userId'] && ((!empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds)) || count($draftReservedUsers)==0) && $dLeafStatus=='draft') || ($arrData['userId'] != $_SESSION['userId'] && $dLeafStatus!='draft'))
									{
							?>
                <input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" />
                <?php echo $arrData['tagName'];?><br />
                <?php
									}
								}
							}
							?>
              </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span id="deadline_todo" style="display:block;"> <?php echo $this->lang->line('txt_Action_By');?>: </span> <span id="deadline_select" style="display:none;"> <?php echo $this->lang->line('txt_Select_By');?>: </span> <span id="deadline_vote" style="display:none;"> <?php echo $this->lang->line('txt_Voting_ends_on');?>: </span> <span id="deadline_authorize" style="display:none;"> <?php echo $this->lang->line('txt_Authorize_By');?>: </span></td>
            <td colspan="2" align="left" valign="top"><select name="actionDate" id="actionDate" onChange="getTimings()">
                <option value="0">--<?php echo $this->lang->line('txt_Select');?>--</option>
                <option value="1" selected><?php echo $this->lang->line('txt_Today');?></option>
                <option value="2"><?php echo $this->lang->line('txt_Tomorrow');?></option>
                <option value="3"><?php echo $this->lang->line('txt_This_Week');?></option>
                <option value="4"><?php echo $this->lang->line('txt_This_Month');?></option>
                <option value="5"><?php echo $this->lang->line('txt_This_Year');?></option>
              </select>
              or
              <input name="endTime" id="endTime" type="text" size="14" maxlength="10" value="" readonly=""/></td>
          </tr>
          <?php

if(count($sequenceTags) > 0)
{
?>
          <tr>
            <td colspan="3"><strong><?php echo $this->lang->line('txt_Added_Tags');?></strong></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%">
                <tr>
                  <td><strong><?php echo $this->lang->line('txt_Tag_Name');?></strong></td>
                  <td><strong><?php echo $this->lang->line('txt_Comments');?></strong></td>
                  <td><strong><?php echo $this->lang->line('txt_Order');?><a href="javascript:void(0)" onClick="updateOrder()"><img src="<?php echo base_url().'images/update.png';?>" alt="Update Order" border="0"></a></strong></td>
                </tr>
                <?php	
				
				foreach($sequenceTags as $tagData)
				{					
					$tagName = $this->tag_db_manager->getTagName( $tagData['tagCategory'], $tagData['tagType'] );					
				?>
                <tr>
                  <td><?php echo $tagName;?></td>
                  <td><?php echo $tagData['comments'];?></td>
                  <td><input type="hidden" name="tagIds" value="<?php echo $tagData['tagId'];?>">
                    <input type="text" name="tagOrders" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3"></td>
                </tr>
                <?php
					$sequenceOrder = $tagData['sequenceOrder'];
				}
				$sequenceOrder = $sequenceOrder+1;
				?>
              </table>
              <input type="hidden" name="countTags" value="<?php echo count($sequenceTags);?>">
              <input type="hidden" name="updateStatus" value="0"></td>
          </tr>
          <?php
}
?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input name="add_more" type="button" value="<?php   echo $this->lang->line('txt_Apply');?>" onClick="validateTagForm()" class="button01"/>
              <input name="cancel" type="reset" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="document.getElementById('selectionTag').style.display='none';document.getElementById('voteTag').style.display='none';" class="button01" />
              <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
              <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
              <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
              <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
              <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
              <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceId;?>">
              <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">
              <input type="hidden" name="tagOption" id="tagOption" value="<?php echo $tagOption;?>">
			  <div class="actionTagLoader" id="actionTagLoader"></div>	
			  </td>
          </tr>
        </table>
      </form>
      <?php
}
else
{


?>
      <form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()">
	    
        <input type="hidden" id="treeId" name="treeId" value="<?php echo $treeId; ?>" />
        <input type="hidden"   id="editTagId" name="editTagId" value="<?php echo $editTagId;?>">
        <?php
 
	if ($arrTagDetails1['tagType']=='Ask')
		$tagType = 1;
	if ($arrTagDetails1['tagType']=='Select')
		$tagType = 2;
	if ($arrTagDetails1['tagType']=='Vote')
		$tagType = 3;
	if ($arrTagDetails1['tagType']=='Authorize')
		$tagType = 4;
		
?>
        <input type="hidden" name="tagType" value="<?php echo $tagType;?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#ffffff;" align="center"  class="blue-border">
          <tr>
            <td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Type');?>: </td>
            <td colspan="2" align="left" valign="top"><?php
	if($sequenceTagId == 0)
	{		
		//print_r ($arrTagDetails1);
	?>
              <select disabled="disabled" name="tagType" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
                <option value="1" <?php if ( $arrTagDetails1['tagType']=='Ask') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_ToDo');?></option>
                <option value="2" <?php if ( $arrTagDetails1['tagType']=='Select') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select');?></option>
                <option value="3" <?php if ( $arrTagDetails1['tagType']=='Vote') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Vote');?></option>
                <option value="4" <?php if ( $arrTagDetails1['tagType']=='Authorize') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Authorize');?></option>
              </select>
              <?php
	}
	else
	{
	?>
              <select name="tagType" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
                <option value="4"><?php echo $this->lang->line('txt_Authorize');?></option>
              </select>
              <?php
	}
	?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Name');?>: </td>
            <td colspan="2" align="left" valign="top"><input name="tagComments" type="text" id="tagComments" maxlength="255" value="<?php if ($arrTagDetails1['tagComments']) { echo $arrTagDetails1['tagComments'];}?>"></td>
          </tr>
          <tr>
            <td colspan="3"><?php
    	if ($votingTopic)
        {
		?>
              <span id="voteTag" style="display:block;">
              <table width="100%">
                <tr>
                  <td align="left" valign="middle" width="30%"><?php echo $this->lang->line('msg_voting_question');?>: </td>
                  <td colspan="2" align="left" valign="top"><input type="text" name="voteQuestion" id="voteQuestion" value="<?php if ($votingTopic) { echo $votingTopic;}?>"></td>
                </tr>
              </table>
              </span>
              <?php
        }
		?>
              <?php
		//if ($tagOptions)
		if ($arrTagDetails1['tagType']=='Select')
		{
		?>
              <span id="selectionTag" style="display:block;">
              <table width="100%">
                <tr>
                  <td width="30%" align="left" valign="top"><?php echo $this->lang->line('msg_enter_options');?>: </td>
                  <td align="left" valign="top"><input type="hidden" name="noOfOptions" value="<?php echo count($tagOptions);?>">
                    <span id="optionFields">
                    <?php
				foreach($tagOptions as $key=>$value)
				{
				?>
                    <input type="text"  name="selectionOptionsAction"  value="<?php echo $value;?>">
                    <br />
                    <?php
				}
				?>
                    </span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td width="30%" align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top" colspan="2"><a href="javascript:void(0)" onClick="addOptions('optionFields')"><?php echo $this->lang->line('txt_Add_More');?></a></td>
                </tr>
              </table>
              </span>
              <?php
		}
		?></td>
          </tr>
          <tr>
            <td align="left" valign="top" colspan="3"><?php echo $this->lang->line('txt_Action_Required_On');?>: </td>
          <tr>
            <td align="left" valign="top"><?php echo $this->lang->line('txt_Search_Users');?>: </td>
            <td colspan="2" align="left" valign="top"><input type="text" id="showMembers1" name="showMembers1" onkeyup="showFilteredMembers1('<?php echo $editTagId ?>','<?php echo $treeId ?>','<?php echo $artifactId; ?>')"/><br />
              <?php
							if ($workSpaceId != 0)
							{  

			?>
								  <input type="checkbox" class="allcheck" name="taggedUsers" value="0"/>
								  <?php echo $this->lang->line('txt_All');?><br />

								  <div id="showMem31" style="height:110px;overflow:auto; width:45%;" class="usersList">
								  <!--Manoj: Removed class -->
								  <input type="checkbox" class="users"  id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
								  <?php echo $this->lang->line('txt_Me');?><br />
								  <?php
								
								
					
												
													foreach($workSpaceMembers as $arrData)
													{
														if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
														{ 
												?>
								  <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
								  <?php echo $arrData['tagName'];?><br />
								  <?php
														}
													}
												
													foreach($workSpaceMembers as $arrData)
													{
														if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
														{
												?>
								  <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
								  <?php echo $arrData['tagName'];?><br />
								  <?php	
														}
													}
							}
							else
							{
								if (count($sharedMembers)!=0)
								{
							?>
              						<input type="checkbox" name="taggedUsers" class="allcheck" value="0"/>
              						<?php echo $this->lang->line('txt_All');?><br />
							<?php
								}
							?>
              <div id="showMem31" style="height:110px;overflow:auto; width:45%;" class="usersList">
                <input type="checkbox"  id="taggedUsers" name="taggedUsers" class="users" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
                <?php echo $this->lang->line('txt_Me');?><br />
                <?php
								foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{
								?>
                <input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
                <?php echo $arrData['tagName'];?><br />
                <?php
									}
								}
							
								foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{
								?>
                <input type="checkbox" class="users" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
                <?php echo $arrData['tagName'];?><br />
                <?php	
									}
								}
							}
							?>
              </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><?php
			//echo $arrTagDetails1['endTime'];
				if ($tagType==1)
					echo $this->lang->line('txt_Action_By') .': ';
				else if ($tagType==2)
					echo $this->lang->line('txt_Select_By') .': ';
				else if ($tagType==3)
					echo $this->lang->line('txt_Voting_ends_on') .': ';
				else if ($tagType==4)
					echo $this->lang->line('txt_Authorize_By') .': ';				
				
			?></td>
            <td colspan="2" align="left" valign="top"><select name="actionDate" id="actionDate" onChange="getTimings()">
                <option value="0" selected="selected">--<?php echo $this->lang->line('txt_Select');?>--</option>
                <option value="1"><?php echo $this->lang->line('txt_Today');?></option>
                <option value="2"><?php echo $this->lang->line('txt_Tomorrow');?></option>
                <option value="3"><?php echo $this->lang->line('txt_This_Week');?></option>
                <option value="4"><?php echo $this->lang->line('txt_This_Month');?></option>
                <option value="5"><?php echo $this->lang->line('txt_This_Year');?></option>
              </select>
              or
              <input name="endTime" id="endTime" type="text" size="14" maxlength="10" value="<?php echo date("d-m-Y", strtotime(substr($arrTagDetails1['endTime'],0,10))); //echo substr($arrTagDetails1['endTime'],0,10);?>"  readonly="" />
			  </td>
          </tr>
          <?php

if(count($sequenceTags) > 0)
{
?>
          <tr>
            <td colspan="3"><strong><?php echo $this->lang->line('txt_Added_Tags');?></strong></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%">
                <tr>
                  <td><strong><?php echo $this->lang->line('txt_Tag_Name');?></strong></td>
                  <td><strong><?php echo $this->lang->line('txt_Comments');?></strong></td>
                  <td><strong><?php echo $this->lang->line('txt_Order');?><a href="javascript:void(0)" onClick="updateOrder()"><img src="<?php echo base_url().'images/update.png';?>" alt="Update Order" border="0"></a></strong></td>
                </tr>
                <?php	
				
				foreach($sequenceTags as $tagData)
				{					
					$tagName = $this->tag_db_manager->getTagName( $tagData['tagCategory'], $tagData['tagType'] );					
				?>
                <tr>
                  <td><?php echo $tagName;?></td>
                  <td><?php echo $tagData['comments'];?></td>
                  <td><input type="hidden" name="tagIds" value="<?php echo $tagData['tagId'];?>">
                    <input type="text" name="tagOrders" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3"></td>
                </tr>
                <?php
					$sequenceOrder = $tagData['sequenceOrder'];
				}
				$sequenceOrder = $sequenceOrder+1;
				?>
              </table>
              <input type="hidden" name="countTags" value="<?php echo count($sequenceTags);?>">
              <input type="hidden" name="updateStatus" value="0"></td>
          </tr>
          <?php
}
?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><?php
			/*
            <span class="bottom-border-blue">
			<input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_New');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/>
			</span>
            */
			?>
              <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
              <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
              <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
              <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
              <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
              <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceId;?>">
              <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">
              <input type="hidden" name="tagOption" id="tagOption" value="<?php echo $tagOption;?>">
              <input type="hidden" name="tagId" id="tagId" value="<?php echo $tagId;?>">
              <input type="hidden" name="addOption" id="addOption" value="edit">
              <input name="add_more" type="button" value="<?php  echo $this->lang->line('txt_Apply');?>" onClick="editActionForm()" class="button01" />
              <input name="cancel" type="button" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,0)" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" /></td>
          </tr>
        </table>
      </form>
      <?php
}
?></td>
  </tr>
</table>
<script>
/*    $(function() {
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
	
});*/

//$(document).on("click", "input[type='checkbox']", function(){
 $(function() {
	$("input[type='checkbox']").click(function(){
		if($(this).hasClass('allcheck')){
			$(this).removeClass('allcheck');
			$(this).addClass('allUncheck');
			$(".users").attr( "checked" ,true);
		}
		else if($(this).hasClass('allUncheck')){
			$(this).removeClass('allUncheck');
			$(this).addClass('allcheck');
			$(".users").attr('checked',false);
		}
});
});

//On single checkbox click myspace start

$('.users').live("click",function(){
		//alert('dfsd');
		val = $("#list").val();
		
		val1 = val.split(",");	

		if($(this).attr("checked")==true){

			if($("#list").val()==''){

				$("#list").val($(this).val());

			}

			else{
			
				if(val1.indexOf($(this).val())==-1){
				
					$("#list").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#list").val(arr);
			}

		}

	});
    
    </script> 
