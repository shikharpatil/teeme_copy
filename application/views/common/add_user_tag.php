<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$appliedTagIds = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTagIds[] = $tagData['tag'];
	}
}
?>
<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
	<tr>
		<td height="8" colspan="3"></td>
	</tr> 
	<?php
	if(count($workSpaceMembers) > 0)
	{
		$i = 0;	
		$dispTags = array();		
		foreach($workSpaceMembers as $tagData)	
		{
			if(!in_array($tagData['userId'],$appliedTagIds))
			{	
				if(in_array($tagData['userId'],$onlineUsers))
				{
					$dispTags[] = '<img src="'.base_url().'images/online_user.gif" alt="User is in online"><span style="cursor:pointer;" id="tagSpan'.$tagData['userId'].'" onClick="changeBackgroundSpan('.$tagData['userId'].')">'.$tagData['tagName'].'</span>';		
				}
				else
				{				
					$dispTags[] = '<span style="cursor:pointer;" id="tagSpan'.$tagData['userId'].'" onClick="changeBackgroundSpan('.$tagData['userId'].')">'.$tagData['tagName'].'</span>';			
				}	
			}
			$i++;		
		}
		if(count($dispTags) > 0)
		{
			?>		
			<tr>
			  <td align="left" valign="middle"><?php echo $this->lang->line('txt_Select_Users');?>: </td>
			  <td colspan="2" align="left" valign="top">
				<?php
				echo implode(', ', $dispTags);		
				?>
				<input type="hidden" name="tag" id="tag" value="0">
				</td>
		  </tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
			  <td>&nbsp;</td>
				<td colspan="2">			
					<input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>"/>
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
	<?php
		}
		else
		{
		?>
			<tr>
				<td align="left" class="bottom-border-blue" colspan="3"><?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
			</tr>
		<?php	
		}			
	}
	else
	{	
	?>
		<tr>
			<td align="left" class="bottom-border-blue" colspan="3"><?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
		</tr>
	<?php
	}
	?>		
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC; " align="center"  class="blue-border">
<tr>
	<td align="left" class="bg-light-blue">&nbsp;</td>
</tr>
<?php
$appliedTags = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTags[] = $tagData['userTagName'];
	}
	?>			
		<tr>
			<td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied_Tags');?> - <?php echo implode(', ',$appliedTags); ?>&nbsp;</td>
		</tr> 
 <?php	
}
else
{
?>
	<tr>
		<td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Applied_Tags');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td>
	</tr> 
<?php
}
?>
</table>	
</form>