<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$timeTags = $this->tag_db_manager->getTagsByCategoryId(1);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
<tr>
	<td colspan="2" align="left" class="bottom-border-blue"></td>
</tr>
<tr>
	<td align="left" class="bg-light-blue"><?php echo $this->lang->line('txt_Created_Tasks');?></td>
    <td align="right" class="bg-light-blue"><a href="<?php echo base_url().'tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactId.'/'.$artifactType.'/0/'.$tagOption.'/2';?>" class="newTagLink"><?php echo $this->lang->line('txt_New');?></a></td>
</tr>
<?php
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$taskId = 0;
		if($tagData['tag'] == 17)
		{
			$date   = date('Y-m-d');
			$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
		}
		else if($tagData['tag'] == 18)
		{			
			$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));
			$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
		}
		else if($tagData['tag'] == 19)
		{
			$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));
			$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
		}
		else if($tagData['tag'] == 20)
		{
			$date   = date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
			$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
		}
		if($taskId == 0)
		{
			$url = base_url().'Notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['tagId'].'/'.$tagData['comments'].'/'.$tagData['ownerId'].'/'.$tagData['tag'];
		}
		elseif($taskId > 0)
		{
			$url = base_url().'Notes/Details/'.$taskId.'/'.$workSpaceId.'/type/'.$workSpaceType;
		}
		
	?>			
		<tr>
			<td colspan="2" align="left" class="bottom-border-blue"><a href="<?php echo $url;?>" class="black-link"><?php echo $tagData['comments'];?></a></td>
		</tr> 
	 <?php
	}
}
else
{
?>
	<tr>
		<td colspan="2" align="left" class="bottom-border-blue"><?php echo $this->lang->line('msg_tasks_not_available');?></td>
	</tr> 
<?php
}
?>
</table>
