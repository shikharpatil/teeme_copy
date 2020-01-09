<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$createTags = $this->tag_db_manager->getTagsByCategoryId(4);
?>
<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
	<tr>
		<td height="8" colspan="3"></td>
	</tr> 	
	<tr>
	<td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Enter_Task');?></td>
		<td colspan="2" align="left" valign="top">
			<input type="text" name="tagComments">
		</td>
  </tr>	
	<tr>
	<td width="30%" align="left" valign="middle"><?php echo $this->lang->line('msg_task_create');?></td>
		<td colspan="2" align="left" valign="top"><?php $i = 0;	?>
			<select name="tag" id="tag" onChange="getTimings()">
			<option value="0" <?php if($i ==0) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select'); ?></option>
			<?php
			
			foreach($createTags as $tagData)	
			{	
			?>		
			<option value="<?php echo $tagData['tagTypeId'];?>"><?php echo $tagData['tagType'];?></option>
			<?php
				$i++;		
			}
			?>		
			</select>
			or <input name="startTime" id="startTime" type="text" size="14" maxlength="10" value="" readonly onClick='changeDropTag(),popUpCalendar(document.frmTag.startTime, document.frmTag.startTime, "yyyy-mm-dd")'/>		
			<img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropTag(),popUpCalendar(this, document.frmTag.startTime, "yyyy-mm-dd")' value='select'>
		</td>
  </tr>			
<tr>
	<td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Task_By');?></td>
		
			 <td colspan="2" align="left" valign="top">
				<select name="taggedUsers[]" multiple>
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
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td>&nbsp;</td>
		<td colspan="2">			
			<input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>"/>
			<input name="cancel" type="button" class="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-1)" />
			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">											
		</td>
	</tr> 
</table>
</form>