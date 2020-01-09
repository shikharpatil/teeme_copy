<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$timeTags = $this->tag_db_manager->getTagsByCategoryId(1);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
<tr>
	<td align="left" class="bottom-border-blue"></td>
</tr>
<tr>
	<td align="left" bgcolor="#CCCCCC" class="bg-light-blue"><?php echo $this->lang->line('txt_Created_Tasks');?></td>
</tr>
<?php
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{		
	?>			
		<tr>
			<td align="left" class="bottom-border-blue"><?php echo $tagData['comments'];?></td>
		</tr> 
	 <?php
	}
}
else
{
?>
	<tr>
		<td align="left" class="bottom-border-blue"><?php echo $this->lang->line('msg_tasks_not_available');?></td>
	</tr> 
<?php
}
?>
</table>