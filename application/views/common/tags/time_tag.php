<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
$timeTags = $this->tag_db_manager->getTagsByCategoryId(1);
?>
<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
	<tr>
		<td height="8" colspan="3"></td>
	</tr> 	
	<tr>
	<td width="30%" align="left" valign="middle"><?php echo $this->lang->line('txt_Select_Tag');?> </td>
		<td colspan="2" align="left" valign="top">
			<select name="tag" id="tag">
			<?php
			$i = 0;	
			foreach($timeTags as $tagData)	
			{	
			?>		
			<option value="<?php echo $tagData['tagTypeId'];?>" <?php if($i ==0) { echo 'selected'; } ?>><?php echo $tagData['tagType'];?></option>
			<?php
				$i++;		
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
			<input name="cancel" type="button" class="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:window.close()" />
			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">	
			<input type="hidden" name="addOption" value="apply">					
		</td>
	</tr> 
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
<tr>
	<td align="left" class="bottom-border-blue"></td>
</tr>
<tr>
		<td align="left" class="bg-light-blue"><?php echo $this->lang->line('txt_Select_Tag');?></td>
	</tr>
<?php
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
	?>			
		
		<tr>
			<td align="left" class="bottom-border-blue"><?php echo $tagData['tagName'];?></td>
		</tr> 
	 <?php
	}
}
else
{
?>
	<tr>
		<td colspan="2" align="left" class="bottom-border-blue"><?php echo $this->lang->line('msg_tags_not_available');?></td>
	</tr>
<?php
}
?>	
</table>	


</form>