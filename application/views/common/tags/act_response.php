<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
$tagDetail = $this->tag_db_manager->getTagDetailsByTagId1($tagId);
$checkResponse = $this->tag_db_manager->checkTagResponse($tagId,$_SESSION['userId']);
if (!$checkResponse)
{
?>
<span id="act_response">
<form name="frmTagResponse" method="post" action="<?php echo base_url();?>tag_response">
<table width="100%" border="0" cellspacing="0" cellpadding="5"  class="blue-border">
	
	<tr>
		<td height="8" colspan="3"></td>
	</tr> 
	<?php	
	
	if($tagDetail['tag'] == 1 )
	{	
		echo $this->lang->line('msg_act_tag_response');
			
	?>       
	<tr>
	  <td align="left" valign="middle" colspan="3"><?php echo $tagDetail['comments'] ;?></td>
	  
    </tr>	
	<tr>
	  <td align="left" valign="middle"><?php echo $this->lang->line('txt_Enter_Your_comments');?></td>
	  <td colspan="2" align="left" valign="top"><textarea name="tagComments"  id="tagComments" rows="3" style="width:50%;"></textarea></td>
    </tr>		
	<?php
	}
	elseif($tagDetail['tag'] == 3)
	{	
		$voteQuestion = $this->tag_db_manager->getVotingTopic($tagId); 
	?>	
		<tr>
		<td width="35%" align="left" valign="middle"><span class="text_blue"><strong><?php echo $voteQuestion;?> </strong></span></td>
	    <td colspan="2" align="left" valign="top">
		<input type="radio"  name="tagResponse" value="1" checked="checked" ><?php echo $this->lang->line('txt_Yes');?>
        <input type="radio" name="tagResponse" value="0"><?php echo $this->lang->line('txt_No');?>
		
		</td>
	</tr>
	
	
	<?php
	}
	elseif($tagDetail['tag'] == 2)
	{	
		$selectionOptions = $this->tag_db_manager->getSelectionOptions( $tagId ); 
	?>	
		<tr>
		<td align="left" valign="middle" colspan="3"><span class="text_blue"><strong><?php echo $this->lang->line('msg_select_options');?> </strong></span></td>
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
	elseif($tagDetail['tag'] == 4 )
	{		
		echo $this->lang->line('msg_authorize_tag_response');			
		?>       
		<tr>
		  <td align="left" valign="middle" colspan="3"><?php echo $tagDetail['comments'] ;?></td>		  
    </tr>	
		<tr>
		<td width="35%" align="left" valign="middle"><span class="text_blue"><strong><?php echo $this->lang->line('txt_Authorized');?></strong></span></td>
	    <td colspan="2" align="left" valign="top">
		<input type="radio" name="tagResponse" value="1" checked="checked"  ><?php echo $this->lang->line('txt_Yes');?><input type="radio" name="tagResponse" value="0"><?php echo $this->lang->line('txt_No');?>
		</td>
	</tr>
		<tr>
		  <td align="left" valign="middle"><?php echo $this->lang->line('txt_Enter_Your_Comments');?></td>
		  <td colspan="2" align="left" valign="top"><textarea id="tagComments" name="tagComments" rows="3" style="width:50%;"></textarea></td>
    </tr>		
	<?php
	}
	

	?>	
	<tr><td colspan="3">		
    		<?php	
    		if (empty($tagDetail['tag']))
			{
				echo $this->lang->line('msg_tag_not_exist');
			}
			?>
    	</td></tr>
	<tr>
	  <td>&nbsp;</td>
		<td colspan="2">
        
        	<?php

			if (!empty($tagDetail['tag']))
			{
			?>
			
			<input name="workSpaceId" id="workSpaceId" type="hidden" value="<?php echo $workSpaceId;?>"/>	
			<input name="workSpaceType" id="workSpaceType" type="hidden" value="<?php echo $workSpaceType;?>"/>		
			<input name="artifactId" id="artifactId" type="hidden" value="<?php echo $artifactId;?>"/>	
			<input name="artifactType" id="artifactType" type="hidden" value="<?php echo $artifactType;?>"/>					
	
    		
			<input name="confirm" id="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Done');?>" onclick="responseTag();" />
			
			<input name="cancel" type="button" class="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:document.getElementById('actionTagResponse').innerHTML='';" />			
			<input type="hidden"  id="tagId" name="tagId" value="<?php echo $tagId;?>">		
			<input type="hidden" id="responseOption" name="responseOption" value="1">	
			<input type="hidden" name="tagCategory" id="tagCategory" value="<?php echo $tagDetail['tag'];?>">		
            
            <?php
			}
			?>
		</td>
  </tr> 
</table>
</form>
<?php
}
else
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="blue-border" style="background-color:#E9F3FC;">
<tr>
	<td>
    	<?php echo $this->lang->line('msg_response_not_allowed'); ?>
    </td>
</tr>
</table>
<?php
}
?>
</span>