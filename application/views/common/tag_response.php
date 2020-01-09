<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><div id="showTagResponse" style="display:none; background-color:#E9F3FC; border:1px solid BLACK; overflow:scroll; position:absolute; width:550px; height:350px; z-index:2; left: 340px; top: 120px;">   
<form name="frmTagResponse" method="post" action="<?php echo base_url();?>tag_response">
<table width="95%" border="0" cellspacing="0" cellpadding="5" >
	
	<tr>
		<td height="8" colspan="3"></td>
	</tr> 
	<?php	
	
	if($tagDetail['tagCategory'] == 1 )
	{	
		if($tagDetail['tagType'] == 'Review' || $tagDetail['tagType'] == 'Approve' || $tagDetail['tagType'] == 'contact')
		{
			if($tagDetail['tagType'] == 'Review' || $tagDetail['tagType'] == 'contact')
			{
				$text = 'Have you reviewed?';
			}
			else
			{
				$text = 'Have you approved?';
			}
		}	
	?>       
	<tr>
		<td width="35%" align="left" valign="middle"><span class="text_blue"><strong><?php echo $text;?> </strong></span></td>
	    <td colspan="2" align="left" valign="top">
		<input type="radio" name="tagResponse" value="1" checked>Yes<input type="radio" name="tagResponse" value="0">No
		</td>
	</tr>
	<tr>
	  <td align="left" valign="middle">Enter your comments</td>
	  <td colspan="2" align="left" valign="top"><textarea name="tagComments" rows="5"></textarea></td>
 	 </tr>		
	<?php
	}
	elseif($tagDetail['tagCategory'] == 2 )
	{	
		$voteQuestion = $this->tag_db_manager->getVotingTopic($this->input->get('tagId')); 
	?>	
		<tr>
		<td width="35%" align="left" valign="middle"><span class="text_blue"><strong><?php echo $voteQuestion;?> </strong></span></td>
	    <td colspan="2" align="left" valign="top">
		<input type="radio" name="tagResponse" value="1" checked>Yes<input type="radio" name="tagResponse" value="0">No
		</td>
	</tr>
	
	
	<?php
	}
	elseif($tagDetail['tagCategory'] == 3 )
	{	
		$selectionOptions = $this->tag_db_manager->getSelectionOptions($this->input->get('tagId')); 
	?>	
		<tr>
		<td align="left" valign="middle" colspan="3"><span class="text_blue"><strong>Please select a option from the below options </strong></span></td>
		</tr>
		<tr>
	    <td colspan="3" align="left" valign="top">
		<?php
		foreach($selectionOptions as $key=>$optionVal)
		{
		?>
		<input type="radio" name="tagResponse" value="<?php echo $key;?>"><?php echo $optionVal;?>
		<br>
		<?php
		}
		?>	
		</td>
	</tr>	
	<?php
	}
	elseif($tagDetail['tagCategory'] == 5 )
	{	
		
	?>	
		<tr>
		<td align="left" valign="middle" colspan="3"><span class="text_blue"><strong>Contact <?php echo $tagDetail['tagType'];?> was tagged for this content </strong></span></td>
		</tr>
		<tr>
	    <td colspan="3" align="left" valign="top">
		
		</td>
	</tr>
		<tr>
		<td width="35%" align="left" valign="middle"><span class="text_blue"><strong>Have you reviewed? </strong></span></td>
	    <td colspan="2" align="left" valign="top">
		<input type="radio" name="tagResponse" value="1" checked>Yes<input type="radio" name="tagResponse" value="0">No<?php echo $treeId;?>
		</td>
	</tr>	
	<?php
	}
	?>	
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td>&nbsp;</td>
		<td colspan="2">
			
			<input name="workSpaceId" type="hidden" value="<?php echo $workSpaceId;?>"/>	
			<input name="workSpaceType" type="hidden" value="<?php echo $workSpaceType;?>"/>		
			<input name="treeId" type="hidden" value="<?php echo $treeId;?>"/>	
			<input name="confirm" type="Submit" class="button" value="Submit"/>
			<input name="cancel" type="button" class="button" value="Cancel" onClick="hideTag('showTagResponse')" />			
			<input type="hidden" name="tagId" value="<?php echo $this->input->get('tagId');?>">		
			<input type="hidden" name="responseOption" value="1">	
			<input type="hidden" name="tagCategory" id="tagCategory" value="<?php echo $tagDetail['tagCategory'];?>">		
		</td>
  </tr> 
</table>
</form>
</div>