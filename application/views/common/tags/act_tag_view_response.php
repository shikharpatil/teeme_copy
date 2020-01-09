<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
	$tagData = $this->tag_db_manager->getTagDetailsByTagId1($tagId);
	$ownerDetails = $this->identity_db_manager->getUserDetailsByUserId($tagData['ownerId']);

?>

<span id="act_view_response">
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
  <tr>
    <td colspan="2" align="left" class="bg-light-blue"><?php echo $this->lang->line('txt_Responses');?></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><?php echo $tagData['comments'];?> (<?php echo '<b>'.$this->lang->line('txt_Tagged_By').':</b> '.$ownerDetails['userTagName'];?>)
      <?php
		
		$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
		
		if (1)
		{
		if($tagData['tag'] == 1 || $tagData['tag'] == 4)
		{
			$simpleResponse = array();
			$simpleResponse = $this->tag_db_manager->getSimpleTagResponse($tagData['tagId']);
		?>
      <span id="spanTagResponse<?php echo $tagData['tagId'];?>">
      <table>
        <tr>
          <td align="left" valign="middle" colspan="3"><table>
              <?php 
							if(count($simpleResponse) > 0)
							{
								foreach( $simpleResponse as $responseData)
								{	
									if ($responseData['status']==0)
										$status = $this->lang->line('txt_No');
									else
										$status =  $this->lang->line('txt_Yes');
								?>
              <tr>
                <td><b><?php echo $responseData['userTagName'];?> </b></td>
                <td><?php 
												if ($tagData['tag'] == 4)
												{											
 													echo ': ' .$responseData['comments'] .' ( ' .$status .' )';                     
												}
												else
												{
													echo ': ' .$responseData['comments'];
												}
											?></td>
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
            </table></td>
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
      <span id="spanTagResponse<?php echo $tagData['tagId'];?>">
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
      <span id="spanTagResponse<?php echo $tagData['tagId'];?>">
      <table>
        <tr>
          <td width="35%" align="left" valign="middle" colspan="3"><span class="text_blue"><strong><?php echo $this->lang->line('txt_Options');?>: </strong></span></td>
        </tr>
        <?php
				foreach($selectionOptions as $selId=>$selVal)
				{
					$totalUsers	= $this->tag_db_manager->getTotalUsersBySelectionId($tagData['tagId'], $selId);
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
		}
		else
		{
			if (empty($tagData['comments']))
				echo $this->lang->line('msg_tag_not_exist');
		}
		?></td>
  </tr>
  <tr>
    <td><ul class="rtabs">
        <li><a href="javascript:void(0)" onClick="javascript:document.getElementById('actionTagResponse').innerHTML='';" class="current"><span><?php echo $this->lang->line('txt_Ok');?></span></a></li>
      </ul></td>
    <td align="right" valign="top" class="bottom-border-blue">&nbsp;</td>
  </tr>
</table>
</span>