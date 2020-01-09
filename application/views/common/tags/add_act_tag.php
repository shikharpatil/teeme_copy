<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>

<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()">
  <table width="100%" border="0" cellspacing="0" cellpadding="5"  align="center"  class="blue-border" height="400px;" >
    <tr>
      <td height="8" colspan="3"></td>
    </tr>
    <tr>
      <td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Type');?></td>
      <td colspan="2" align="left" valign="top"><?php
	if($sequenceTagId == 0)
	{
	?>
        <select name="tag" id="tag" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
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
        <select name="tag" id="tag" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
          <option value="4"><?php echo $this->lang->line('txt_Authorize');?></option>
        </select>
        <?php
	}
	?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><?php echo $this->lang->line('txt_Tag_Name');?></td>
      <td colspan="2" align="left" valign="top"><input name="tagComments" type="text" id="tagComments" maxlength="255"></td>
    </tr>
    <tr>
      <td colspan="3"><span id="voteTag" style="display:none;">
        <table width="100%">
          <tr>
            <td align="left" valign="middle" width="30%"><?php echo $this->lang->line('msg_voting_question');?></td>
            <td colspan="2" align="left" valign="top"><input type="text" name="voteQuestion" id="voteQuestion"></td>
          </tr>
        </table>
        </span> <span id="selectionTag" style="display:none;">
        <table width="100%">
          <tr>
            <td width="30%" align="left" valign="top"><?php echo $this->lang->line('msg_enter_options');?></td>
            <td align="left" valign="top"><input type="hidden" name="noOfOptions" value="2">
              <span id="optionFields">
              <input type="text" name="selectionOptions[]" id="selectionOptions[]">
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
      <td align="left" valign="middle"><?php echo $this->lang->line('txt_Action_Required_On');?></td>
      <td colspan="2" align="left" valign="top"><select name="taggedUsers[]" multiple>
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
        </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><?php echo $this->lang->line('txt_Action_By');?></td>
      <td colspan="2" align="left" valign="top"><select name="actionDate" onChange="getTimings()">
          <option value="0">--<?php echo $this->lang->line('txt_Select');?>--</option>
          <option value="1" selected><?php echo $this->lang->line('txt_Today');?></option>
          <option value="2"><?php echo $this->lang->line('txt_Tomorrow');?></option>
          <option value="3"><?php echo $this->lang->line('txt_This_Week');?></option>
          <option value="4"><?php echo $this->lang->line('txt_This_Month');?></option>
          <option value="5"><?php echo $this->lang->line('txt_This_Year');?></option>
        </select>
        or
        <input name="startTime" id="startTime" type="text" size="14" maxlength="10" value="" readonly onClick='changeDrop(),popUpCalendar(document.frmTag.startTime, document.frmTag.startTime, "yyyy-mm-dd")'/>
        <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDrop(),popUpCalendar(this, document.frmTag.startTime, "yyyy-mm-dd")' value='select'></td>
    </tr>
    <tr>
      <td align="left" valign="middle" colspan="3"><span id="voteEnd" style="display:none;">
        <table width="100%">
          <tr>
            <td align="left" valign="middle" width="30%"><?php echo $this->lang->line('txt_Voting_ends_on');?></td>
            <td colspan="2" align="left" valign="top"><input name="endTime" id="endTime" type="text" size="14" maxlength="10" value="" readonly onClick='popUpCalendar(document.frmTag.endTime, document.frmTag.endTime, "mm-dd-yyyy")'/>
              <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='popUpCalendar(this, document.frmTag.endTime, "yyyy-mm-dd")' value='select'></td>
          </tr>
        </table>
        </span></td>
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
            <td><input type="hidden" name="tagIds[]" value="<?php echo $tagData['tagId'];?>">
              <input type="text" name="tagOrders[]" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3"></td>
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
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input name="add_more" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>" onClick="updateSequence()"/>
        <span class="bottom-border-blue">
        <input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_New');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/>
        </span>
        <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
        <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
        <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
        <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
        <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
        <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
        <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
        <input type="hidden" name="tagOption" value="<?php echo $tagOption;?>"></td>
    </tr>
  </table>
</form>
