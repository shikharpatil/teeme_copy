<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
	<tr>
		<td align="left" class="bg-light-blue">&nbsp;</td>
	</tr>
<?php
$dispTags = array();	
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$dispTags[] = $tagData['contactName'];
	}
	?>			
	<tr>
		<td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo implode(', ',$dispTags); ?>&nbsp;</td>
	</tr> 
	 <?php	
}
else
{
?>
	<tr>
		<td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td>
	</tr> 
<?php
}
?>
</table>	
