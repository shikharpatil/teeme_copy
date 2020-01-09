<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
<tr>
		<td align="left" class="bg-light-blue"><?php echo $this->lang->line('txt_Applied_Tags');?></td>
	    <td align="right" class="bg-light-blue">&nbsp;</td>
</tr>
<?php
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		if($tagData['artifactId'] > 0)
		{				
			$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );
			if(count($tagLink) > 0)
			{
				$tagUrl = base_url().$tagLink[0];
			}
			else
			{
				$tagUrl = 'javascript:void(0)';
			}				
		}
		else
		{
			$tagUrl = 'javascript:void(0)';
		}			
				
	?>			
		<tr>
			<td align="left" class="bottom-border-blue"><a href="<?php echo $tagUrl;?>" class="black-link"><?php echo $tagData['comments'];?></a>
		<?php
		
		$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
		if(!$response)
		{
		?>
			<a href="<?php echo base_url()?>tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/3/3/<?php echo $tagData['tagId'];?>"><?php echo $this->lang->line('txt_Act');?></a>		
		<?php
		}
		if($tagData['ownerId'] == $_SESSION['userId'])
		{	
		?>
			<a href="javascript:void(0)" onClick="viewTagResponses('spanTagResponse<?php echo $tagData['tagId'];?>')"><?php echo $this->lang->line('txt_View_Responses');?></a>	
		<?php
		}
		else if($tagData['tag'] == 2)
		{
		?>
			<a href="javascript:void(0)" onClick="viewTagResponses('spanTagResponse<?php echo $tagData['tagId'];?>')"><?php echo $this->lang->line('txt_View_Responses');?></a>	
		<?php
		}
		else if($tagData['tag'] == 3)
		{			
		?>
			<a href="javascript:void(0)" onClick="viewTagResponses('spanTagResponse<?php echo $tagData['tagId'];?>')"><?php echo $this->lang->line('txt_View_Responses');?> </a>	
		<?php
		}
		if($tagData['tag'] == 1 || $tagData['tag'] == 4)
		{
			$simpleResponse = array();
			$simpleResponse = $this->tag_db_manager->getSimpleTagResponse($tagData['tagId']);
		?>
			<span id="spanTagResponse<?php echo $tagData['tagId'];?>" style="display:none;">
				<table>
					
					<tr>
					  <td align="left" valign="middle" colspan="3">
						<table>
							<?php 
							if(count($simpleResponse) > 0)
							{
								foreach( $simpleResponse as $responseData)
								{	
								?>	
									<tr>
										<td><?php echo $responseData['userTagName'];?>:</td><td><?php echo $responseData['comments'];?></td>
									</tr>
									
									
								<?php
								}
							}
							else
							{
							?>	
								<tr>
									<td colspan="2"><?php echo $this->lang->line('msg_responses_not_available');?></td>
								</tr>	
							<?php
							}
							?>
		</table>
	</td>	
	</tr>	
				</table>
			  </span>
		<?php
		}
		if($tagData['tag'] == 3)
		{
			$yesPercentage	= 0;
			$noPercentage	= 0;
			$voteQuestion 	= $this->tag_db_manager->getVotingTopic($tagData['tagId']);
			$simpleResponse = array();			
			$totalUsers		= $this->tag_db_manager->getTotalUsersByTagId($tagData['tagId']);
			$totalUsersYes	= $this->tag_db_manager->getTotalUsersYesByTagId($tagData['tagId']);
			$totalUsersNo	= $this->tag_db_manager->getTotalUsersNoByTagId($tagData['tagId']);
			$totalResponders = $totalUsersYes+$totalUsersNo;
			if($totalResponders > 0)
			{
				$yesPercentage	= number_format(($totalUsersYes/$totalResponders)*100,2);
				$noPercentage	= number_format(($totalUsersNo/$totalResponders)*100,2);
			}
		?>
			<span id="spanTagResponse<?php echo $tagData['tagId'];?>" style="display:none;">
				<table>
					<tr>
						<td width="35%" align="left" valign="middle" colspan="3"><span class="text_blue"><strong><?php echo $this->lang->line('txt_Voting_Topic');?>: <?php echo $voteQuestion;?> </strong></span></td>	    
					</tr>	
					<tr>
						<td align="left" valign="middle" colspan="3"><?php echo $this->lang->line('txt_Total_Voters');?>: <?php echo $totalUsers;?></td>
					</tr>
					<tr>
						<td align="left" valign="middle" colspan="3"><?php echo $this->lang->line('txt_Total_Users_Voted');?>: <?php echo $totalResponders;?></td>
					</tr>
					<tr>
						<td align="left" valign="middle" colspan="3"><?php echo $this->lang->line('txt_Yes');?>: <?php echo $totalUsersYes.' ('.$yesPercentage.' %)';?></td>
					</tr>
					<tr>
						<td align="left" valign="middle" colspan="3"><?php echo $this->lang->line('txt_No');?>: <?php echo $totalUsersNo.' ('.$noPercentage.' %)';?></td>
					</tr>	
				</table>
			  </span>
		<?php
		}
		if($tagData['tag'] == 2)
		{
			$selectionOptions = $this->tag_db_manager->getSelectionOptions($tagData['tagId']);
			$simpleResponse = array();
		?>			
			<span id="spanTagResponse<?php echo $tagData['tagId'];?>" style="display:none;">
			<table>					
				<tr>
					<td width="35%" align="left" valign="middle" colspan="3"><span class="text_blue"><strong><?php echo $this->lang->line('txt_Options');?>:  </strong></span></td>	    
				</tr>
				<?php
				foreach($selectionOptions as $selId=>$selVal)
				{
					$totalUsers		= $this->tag_db_manager->getTotalUsersBySelectionId($tagData['tagId'], $selId);
					?>
					<tr>
						<td align="left" valign="middle" colspan="3"><?php echo $selVal.' ('.$totalUsers.' Users)';?></td>
					</tr>
				<?php
				}
				?>				
			</table>
			</span>
		<?php
		}
		?>
				
		</td>
	        <td align="left" valign="top" class="bottom-border-blue"><?php if($response) { ?><a href="<?php echo base_url().'delete_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactId.'/'.$artifactType.'/0/'.$tagOption.'/'.$tagData['tagId'].'/1';?>" class="newTagLink" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/delete.gif" alt="Delete" border="0"></a><?php } else { echo '&nbsp;'; }?></td>
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
