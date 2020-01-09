<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$viewTags = $this->tag_db_manager->getTagsByCategoryId(2);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
<tr>
	<td colspan="2" align="left" class="bottom-border-blue"></td>
</tr>
<tr>
		<td align="left" class="bg-light-blue"><?php echo $this->lang->line('txt_Tags_Applied');?></td>
	    <td align="right" class="bg-light-blue">&nbsp;</td>
</tr>
<?php
if(count($viewTags) > 0)
{
	$i = 0;	
	foreach($viewTags as $tagTypeData)	
	{
	?>	
		<tr>
			<td colspan="2" align="left" class="bottom-border-blue">	
			<b><?php echo $tagTypeData['tagType'];?></b>
			</td>
		</tr> 
	<?PHP 
		$tags = $this->tag_db_manager->getTagsByTagType(2, $tagTypeData['tagTypeId'], $_SESSION['userId']);	         	
		if(count($tags) > 0)
		{
			foreach($tags as $tagData)
			{				
				$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
				if(count($tagLink) > 0)
				{	
				?>	
				<tr>
					<td colspan="2" align="left" class="bottom-border-blue">	
				<a href="<?php echo base_url().$tagLink[0];?>" class="blue-link-underline"><?php echo $tagLink[1];?></a>
					</td>
				</tr>           
				<?php
				} 
				
			}
		}
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
