<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#D0D0D7">
                  <tr>
                    <td class="bg-grey-img"><span class="heading-grey"><?php echo $this->lang->line('msg_artifact_action');?></span></td>
                  </tr>
				<tr>
					<td class="bg-light-grey">
<table width="100%" border="0" cellspacing="1" cellpadding="0">						  		
<?php

if(count($tags) > 0)
{		
	foreach($tags as $tagData)
	{	
		$ownerDetails	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['ownerId'] );
		$userDetails 	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['userId'] );
		$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
		if(count($tagLink) > 0)
		{	
		?>	
		<tr>
			<td valign="top" class="bg-light-grey">		
		  <a href="<?php echo $tagLink[0];?>" class="blue-link-underline"> <?php echo $tagLink[1];?></a>
			</td>
		</tr>           
		<?php
		}		
	}
}
else
{	
?>
<tr>
	<td colspan="2"><?php echo $this->lang->line('txt_Not_Available');?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>                 
</table>
<br>
	
