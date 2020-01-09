<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/scroll_date_time/dist/DateTimePicker.css" />
		<script type="text/javascript" src="<?php echo base_url();?>js/scroll_date_time/dist/DateTimePicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/scroll_date_time/dist/i18n/DateTimePicker-i18n.js"></script>
		
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
<script>
function showTags()
{
	var toMatch = document.getElementById('searchTags').value;
	var val = '';
	
		//if (toMatch!='')
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
						val +=  '<input type="checkbox" name="unAppliedTags[]" value="<?php echo $tagData['tagId'];?>" /><?php echo $tagData['comments'];?>&nbsp;<a href="<?php echo base_url();?>add_tag/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $artifactId; ?>/<?php echo $artifactType; ?>/<?php echo $sequenceTagId; ?>/<?php echo $tagOption;?>/<?php echo $tagData['tagId'];?>" title="<?php echo $this->lang->line('txt_Edit');?>"><?php echo $this->lang->line('txt_Edit');?></a><br>';
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
					val +=  '<input type="checkbox" name="taggedUsers" id="taggedUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php

			
			if ($workSpaceId != 0)
			{	
			?>		
				val +=  '<input type="checkbox" name="taggedUsers" value="0"/><?php echo $this->lang->line('txt_All');?><br>';
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
				val +=  '<input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
				val +=  '<input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
					val +=  '<input type="checkbox" name="taggedUsers" value="0"/><?php echo $this->lang->line('txt_All');?><br>';
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
				val +=  '<input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
				val +=  '<input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
</script>

<br />
<div class="searchTagDiv">
  <form name="frmTag0" method="post" action="<?php echo base_url();?>create_tag1">
    <input type="hidden" id="treeIdDelete" name="treeIdDelete" value="<?php echo $treeId; ?>" />
    <div style="float:left;"> <?php echo $this->lang->line('txt_Search_Tags');?>: </div>
    <div style="float:left;">
      <input type="text" id="searchTagsAction" name="searchTagsAction" onkeyup="show_action_Tags(<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>)"/>
    </div>
    <div style="float:left;"> <?php echo $this->lang->line('txt_Applied_Tags');?>: </div>
    <div id="showTagsAction" style="width:100%; max-height: 100px; display:block;float:left;overflow:auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
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
    <?php
			if ($tags)
			{?>
    <div style="float:left; padding: 10% 0%;">
      <input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Delete');?>" class="button01" onClick="submit_action_tags_form()" />
    </div>
    <?php
			}?>
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
  </form>
  <div style="clear:both;"></div>
</div>

<!--end of first table-->

<div class="tagActionBlock">
<?php
if (!$editTagId)
{

?>
<div>
  <form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" >
  <input value="<?php echo $_SESSION['userId'];?>" id="list" type="hidden" />
    <input type="hidden" id="treeId1" name="treeId1" value="<?php echo $treeId; ?>" />
    <div class="tagsDivs"> <?php echo $this->lang->line('txt_Tag_Type');?>: </div>
    <div class="tagsDivs">
      <?php
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
    </div>
    <div class="tagsDivs">
      <select name="tag" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
        <option value="4"><?php echo $this->lang->line('txt_Authorize');?></option>
      </select>
      <?php
	}
	?>
    </div>
    <div class="tagsDivs"> <?php echo $this->lang->line('txt_Tag_Name');?>: </div>
    <div class="tagsDivs">
      <input name="tagComments" type="text" id="tagComments" maxlength="255">
    </div>
    <div class="tagsDivs"> <span id="voteTag" style="display:none;">
      <div style="float:left;"> <?php echo $this->lang->line('msg_voting_question');?>: </div>
      <div style="float:left;">
        <input type="text" name="voteQuestion" id="voteQuestion">
      </div>
      </span> <span id="selectionTag" style="display:none;">
      <div style="float:left;width:100%"> <?php echo $this->lang->line('msg_enter_options');?>: </div>
      <div style="float:left;width:100%">
        <input type="hidden" id="noOfOptions" name="noOfOptions" value="2">
      </div>
      <div style="float:left;width:100%"> <span id="optionFields">
        <input type="text"   name="selectionOptionsAction"  >
        </span> </div>
      <div style="float:left;width:100%"> <a href="javascript:void(0)" onClick="addOptions('optionFields')"><?php echo $this->lang->line('txt_Add_More');?></a> </div>
      </span> </div>
    <div class="tagsDivs"> <?php echo $this->lang->line('txt_Action_Required_On');?>: </div>
    <div class="tagsDivs"> <?php echo $this->lang->line('txt_Search_Users');?>: </div>
    <div class="tagsDivs">
      <input type="text" id="showMembers1" name="showMembers1" onkeyup="showFilteredMembers1(0,'<?php echo $treeId; ?>')"/>
    </div>
	<!--Manoj: code edited -->
	<?php
	if($workSpaceId==0)
							{  
								if (count($sharedMembers)!=0)
								{
 								?>
      <input type="checkbox" name="taggedUsers" value="0" class="allcheck"/>
      <?php echo $this->lang->line('txt_All');?><br />
      <?php
								}
								?>
      <div id="showMem31" style="height:100px;overflow:auto;float:left;">
      <input type="checkbox" id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>
      <?php echo $this->lang->line('txt_Me');?><br />
      <?php

							
								foreach($workSpaceMembers as $arrData)
								{
									if (($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers) && ((!empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds)) || count($draftReservedUsers)==0) && $dLeafStatus=='draft') || ($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers) && $dLeafStatus!='draft'))
									{
							?>
		<!--Manoj: added class users -->
      <input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" class="users" />
      <?php echo $arrData['tagName'];?><br />
      <?php
									}
								}
							}
							else
							{
							?>
      <input type="checkbox" name="taggedUsers" value="0" class="allcheck"/>
      <?php echo $this->lang->line('txt_All');?><br />
	  <div id="showMem31" style="height:110px;overflow:auto;float:left;">
	  <input type="checkbox" id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" checked="checked"/>
      <?php echo $this->lang->line('txt_Me');?><br />
      <?php
							
                            	foreach($workSpaceMembers as $arrData)
								{
									if (($arrData['userId'] != $_SESSION['userId'] && ((!empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds)) || count($draftReservedUsers)==0) && $dLeafStatus=='draft') || ($arrData['userId'] != $_SESSION['userId'] && $dLeafStatus!='draft'))
									{
							?>
							<!--Manoj: added class users -->
      <input type="checkbox" name="taggedUsers" value="<?php echo $arrData['userId'];?>" class="users" />
      <?php echo $arrData['tagName'];?><br />
      <?php
									}
								}
							}
							?>
							</div>
    </div>
    <div class="tagsDivs"> <span id="deadline_todo" style="display:block;"> <?php echo $this->lang->line('txt_Action_By');?>: </span> <span id="deadline_select" style="display:none;"> <?php echo $this->lang->line('txt_Select_By');?>: </span> <span id="deadline_vote" style="display:none;"> <?php echo $this->lang->line('txt_Voting_ends_on');?>: </span> <span id="deadline_authorize" style="display:none;"> <?php echo $this->lang->line('txt_Authorize_By');?>: </span> </div>
    <div style="float:left;width:50%">
      <select name="actionDate" id="actionDate" onChange="getTimings()">
        <option value="0">--<?php echo $this->lang->line('txt_Select');?>--</option>
        <option value="1" selected><?php echo $this->lang->line('txt_Today');?></option>
        <option value="2"><?php echo $this->lang->line('txt_Tomorrow');?></option>
        <option value="3"><?php echo $this->lang->line('txt_This_Week');?></option>
        <option value="4"><?php echo $this->lang->line('txt_This_Month');?></option>
        <option value="5"><?php echo $this->lang->line('txt_This_Year');?></option>
      </select>
    </div>
    <div class="tagsDivs"> or </div>
    <div class="tagsDivs"> D&nbsp;
      <?php /*?><select name="endDay" id="endDay" class="enterCal endCal" timing='end' style="width:43px;">
        <?php
            $dy = date("d",strtotime("last day of this month"));
            for($i=1;$i<=$dy;$i++){?>
        <option <?php echo ($i==date("d"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>
        <?php
            }?>
      </select>
      M&nbsp;
      <select name="endMonth" id="endMonth" class="enterCal endCal changeMonth" timing='end' style="width:43px;">
        <?php
		for($i=1;$i<=12;$i++){?>
        <option <?php echo ($i==date("m"))?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>
        <?php
		}?>
      </select>
      Y&nbsp;
      <select name="endYear" id="endYear" class="enterCal endCal changeMonth" timing='end' style="width:52px;">
        <?php
		$yr = date("Y",strtotime("last year"));
		for($i=$yr-1;$i<=$yr+20;$i++){?>
        <option <?php echo ($i==date("Y"))?"SELECTED":"";?>><?php echo $i;?></option>
        <?php
		}?>
      </select>
      <input name="endTime" id="endTime" type="hidden" value=""/>
	  <?php */?>
	  <!--Manoj: added mobile datepicker for action tag-->
			<input name="endTime" type="text" data-field="date" class="end_time" id="endTime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?>"  readonly>  


			<div id="dtBox_tag" ></div>
		<!--Manoj: code end-->
    </div>
    <?php

if(count($sequenceTags) > 0)
{
?>
    <div class="tagsDivs"> <strong><?php echo $this->lang->line('txt_Added_Tags');?></strong> </div>
    <div class="tagsDivs"> <strong><?php echo $this->lang->line('txt_Tag_Name');?></strong> <strong><?php echo $this->lang->line('txt_Comments');?></strong> <strong><?php echo $this->lang->line('txt_Order');?><a href="javascript:void(0)" onClick="updateOrder()"><img src="<?php echo base_url().'images/update.png';?>" alt="Update Order" border="0"></a></strong> </div>
    <div class="tagsDivs">
      <?php	
				
				foreach($sequenceTags as $tagData)
				{					
					$tagName = $this->tag_db_manager->getTagName( $tagData['tagCategory'], $tagData['tagType'] );					
				?>
    </div>
    <div class="tagsDivs"> <?php echo $tagName;?> </div>
    <div class="tagsDivs"> <?php echo $tagData['comments'];?> </div>
    <div class="tagsDivs">
      <input type="hidden" name="tagIds" value="<?php echo $tagData['tagId'];?>">
      <input type="text" name="tagOrders" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3">
    </div>
    <?php
					$sequenceOrder = $tagData['sequenceOrder'];
				}
				$sequenceOrder = $sequenceOrder+1;
				?>
    <input type="hidden" name="countTags" value="<?php echo count($sequenceTags);?>">
    <input type="hidden" name="updateStatus" value="0">
    <?php
}
?>
    <!--<input name="add_more" type="Submit" value="<?php // echo $this->lang->line('txt_Apply');?>" onClick="updateSequence()" class="button01"/> -->
    <div class="tagsDivs">
      <input name="add_more" type="button" value="<?php   echo $this->lang->line('txt_Apply');?>" onClick="validateTagForm()" class="button01"/>
      <input name="cancel" type="reset" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="document.getElementById('selectionTag').style.display='none';document.getElementById('voteTag').style.display='none';" class="button01" />
    </div>
    <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
    <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
    <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
    <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
    <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
    <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceId;?>">
    <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">
    <input type="hidden" name="tagOption" id="tagOption" value="<?php echo $tagOption;?>">
	<div class="actionTagLoader" id="actionTagLoader" style="margin-top:1%;"></div>	
  </form>
  <?php
}
else
{
?>
  <div>
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
      <div style="float:left;width:100%"> <?php echo $this->lang->line('txt_Tag_Type');?>: </div>
      <div style="float:left;width:100%">
        <?php
	if($sequenceTagId == 0)
	{		
		
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
	?>
      </div>
      <div style="float:left;width:100%"> <?php echo $this->lang->line('txt_Tag_Name');?>: </div>
      <div style="float:left;width:100%">
        <input name="tagComments" type="text" id="tagComments" maxlength="255" value="<?php if ($arrTagDetails1['tagComments']) { echo $arrTagDetails1['tagComments'];}?>">
      </div>
      <div style="float:left;width:100%">
        <?php
    	if ($votingTopic)
        {
		?>
        <span id="voteTag" style="display:block;"> <?php echo $this->lang->line('msg_voting_question');?>:
        </td>
        <div style="float:left;width:100%">
          <input type="text" name="voteQuestion" id="voteQuestion" value="<?php if ($votingTopic) { echo $votingTopic;}?>">
        </div>
        </span>
        <?php
        }
		?>
        <?php
	
		if ($arrTagDetails1['tagType']=='Select')
		{
		?>
        <span id="selectionTag" style="display:block;">
        <div style="float:left;width:100%"> <?php echo $this->lang->line('msg_enter_options');?>:
          <input type="hidden" name="noOfOptions" value="<?php echo count($tagOptions);?>">
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
          </span> </div>
        <a href="javascript:void(0)" onClick="addOptions('optionFields')"><?php echo $this->lang->line('txt_Add_More');?></a> </span>
        <?php
		}
		?>
      </div>
      <div style="float:left;"> <?php echo $this->lang->line('txt_Action_Required_On');?>: </div>
      <div style="float:left;"> <?php echo $this->lang->line('txt_Search_Users');?>: </div>
      <div style="float:left;width:100%">
        <input type="text" id="showMembers1" name="showMembers1" onkeyup="showFilteredMembers1('<?php echo $editTagId ?>','<?php echo $treeId ?>')"/>
      </div>
	  <!--Manoj: code edited -->
      <div style="float:left;width:100%">
	  <?php
							if ($workSpaceId != 0)
							{  
								
							?>
							<!--Manoj: added class and onclick-->
          <input type="checkbox" name="taggedUsers" value="0" class="allcheck" />
          <?php echo $this->lang->line('txt_All');?><br />
        <div id="showMem31" style="height:110px;overflow:auto;float:left;width:100%;">
          <input type="checkbox" class="users"  id="taggedUsers" name="taggedUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
          <?php echo $this->lang->line('txt_Me');?><br />
          
          <?php
								
							foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{ 
							?>
							<!--Manoj: added class users-->
          <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?> />
          <?php echo $arrData['tagName'];?><br />
          <?php
									}
								}
							
								foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{
							?>
							<!--Manoj: added class users-->
          <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
          <?php echo $arrData['tagName'];?><br />
          <?php	
									}
								}
							}
							else
							{
							?> 
          <input type="checkbox" name="taggedUsers" value="0" class="allcheck" />
          <?php echo $this->lang->line('txt_All');?><br />
          <?php
								foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{
								?>
								<!--Manoj: added class users-->
          <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
          <?php echo $arrData['tagName'];?><br />
          <?php
									}
								}
							
								foreach($workSpaceMembers as $arrData)
								{
									if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
									{
								?>
								<!--Manoj: added class users-->
          <input type="checkbox" name="taggedUsers" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$taggedUsers)) { echo 'checked="checked"';}?>/>
          <?php echo $arrData['tagName'];?><br />
          <?php	
									}
								}
							}
							?>
        </div>
      </div>
      <div style="float:left;width:100%">
        <?php
				if ($tagType==1)
					echo $this->lang->line('txt_Action_By') .': ';
				else if ($tagType==2)
					echo $this->lang->line('txt_Select_By') .': ';
				else if ($tagType==3)
					echo $this->lang->line('txt_Voting_ends_on') .': ';
				else if ($tagType==4)
					echo $this->lang->line('txt_Authorize_By') .': ';				
				
			?>
      </div>
      <div style="float:left;width:100%">
        <select name="actionDate" id="actionDate" onChange="getTimings()">
          <option value="0" selected="selected">--<?php echo $this->lang->line('txt_Select');?>--</option>
          <option value="1"><?php echo $this->lang->line('txt_Today');?></option>
          <option value="2"><?php echo $this->lang->line('txt_Tomorrow');?></option>
          <option value="3"><?php echo $this->lang->line('txt_This_Week');?></option>
          <option value="4"><?php echo $this->lang->line('txt_This_Month');?></option>
          <option value="5"><?php echo $this->lang->line('txt_This_Year');?></option>
        </select>
      </div>
      <div style="float:left;width:100%"> or </div>
	  <!--Manoj: code for get edit time-->
	  	<?php
	  		$var = explode(' ',$arrTagDetails1['endTime']);

			$dateVar = explode('-',$var[0]);
			
	  	?>
	  <!--Manoj: code end-->
	  
      <div style="float:left;width:100%"> D&nbsp;
       <?php /*?> <select name="endDay" id="endDay" class="enterCal endCal" timing='end' style="width:43px;">
          <?php
            $dy = date("d",strtotime("last day of this month"));
            for($i=1;$i<=$dy;$i++){?>
          <option <?php echo ($i==$dateVar[2])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>
          <?php
            }?>
        </select>
        M&nbsp;
        <select name="endMonth" id="endMonth" class="enterCal endCal changeMonth" timing='end' style="width:43px;">
          <?php
		for($i=1;$i<=12;$i++){?>
          <option <?php echo ($i==$dateVar[1])?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>
          <?php
		}?>
        </select>
        Y&nbsp;
        <select name="endYear" id="endYear" class="enterCal endCal changeMonth" timing='end' style="width:52px;">
          <?php
		$yr = date("Y",strtotime("last year"));
		for($i=$yr-1;$i<=$yr+20;$i++){?>
          <option <?php echo ($i==$dateVar[0])?"SELECTED":"";?>><?php echo $i;?></option>
          <?php
		}?>
        </select>
		<!--Manoj: change date format at edit time-->
        <input name="endTime" id="endTime" type="hidden" value="<?php echo date("d-m-Y", strtotime(substr($arrTagDetails1['endTime'],0,10))); ?>"/>
		<?php */?>
		<!--Manoj: added mobile datepicker for action tag-->
				<input name="endTime" type="text" data-field="date" class="end_time" id="endTime" value="<?php echo date("d-m-Y", strtotime(substr($arrTagDetails1['endTime'],0,10))); ?>"  readonly>  


			<div id="dtBox_tag" ></div>
		<!--Manoj: code end-->
      </div>
      <div style="float:left;width:100%;">
        <?php

if(count($sequenceTags) > 0)
{
?>
        <strong><?php echo $this->lang->line('txt_Added_Tags');?></strong> <strong><?php echo $this->lang->line('txt_Tag_Name');?></strong> <strong><?php echo $this->lang->line('txt_Comments');?></strong> <strong><?php echo $this->lang->line('txt_Order');?><a href="javascript:void(0)" onClick="updateOrder()"><img src="<?php echo base_url().'images/update.png';?>" alt="Update Order" border="0"></a></strong>
        <?php	
				
				foreach($sequenceTags as $tagData)
				{					
					$tagName = $this->tag_db_manager->getTagName( $tagData['tagCategory'], $tagData['tagType'] );					
				?>
        <?php echo $tagName;?> <?php echo $tagData['comments'];?>
        <input type="hidden" name="tagIds" value="<?php echo $tagData['tagId'];?>">
        <input type="text" name="tagOrders" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3">
        <?php
					$sequenceOrder = $tagData['sequenceOrder'];
				}
				$sequenceOrder = $sequenceOrder+1;
				?>
        <input type="hidden" name="countTags" value="<?php echo count($sequenceTags);?>">
        <input type="hidden" name="updateStatus" value="0">
        <?php
}
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
        <input name="cancel" type="button" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,0)" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" />
      </div>
    </form>
    <?php
}
?>
  </div>
</div>
<div style="clear:both;"></div>
<script>
$(document).ready(function(){
	$('.changeMonth').change(function(){
		var t = $(this).attr('timing');
		var dy = $('#endDay').val();
		var yr = $('#endYear').val();
		var mn = $('#endMonth').val();
		$.post(baseUrl+"new_task/getMonthDays/end/"+mn+"/"+dy+"/"+yr,{},function(data){
			$('#endDay').replaceWith(data);
		});
	});
	$('.enterCal').live('change',function(){
		var d = $('#endDay').val();
		var y = $('#endYear').val();
		var m = $('#endMonth').val();
		
		$('#endTime').val(d+'-'+m+'-'+y);
	});
	//Manoj: Code for select all at creating time
	$("input[type='checkbox']").click(function(){
	
		if($(this).hasClass('allcheck')){
			$(this).removeClass('allcheck');
			$(this).addClass('allUncheck');
			$(".users").prop( "checked" ,true);
		}
		else if($(this).hasClass('allUncheck')){
			$(this).removeClass('allUncheck');
			$(this).addClass('allcheck');
			$(".users").prop('checked',false);
		}
	});
	//Manoj: code end
});
//Manoj: Code for select all at editing time 
function selectAllCheck(obj){
		if($(obj).prop('class')=='allcheck'){
			$(obj).removeClass('allcheck');
			$(obj).addClass('allUncheck');
			$(".users").prop( "checked" ,true);
		}
		else if($(obj).prop('class')=='allUncheck'){
			$(obj).removeClass('allUncheck');
			$(obj).addClass('allcheck');
			$(".users").prop('checked',false);
		}
}
//Manoj: code end
</script> 
<script>
$(document).on("click", "input[type='checkbox']", function(){

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

//On single checkbox click myspace start

$('.users').live("click",function(){
		alert('dfsd');
		val = $("#list").val();
		
		val1 = val.split(",");	

		if($(this).attr("checked")==true){

			if($("#list").val()==''){

				$("#list").val($(this).val());

			}

			else{
			
				alert(val);
			
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