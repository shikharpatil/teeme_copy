<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><form name="frmTag" method="post" action="<?php echo base_url();?>create_tag2" onSubmit="return validateTag()"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
		
	<tr>
		<td height="8" colspan="3"></td>
	</tr>        
	
	<tr>
	  <td align="left" valign="middle">&nbsp;</td>
	  <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
	<tr>
	  <td align="left" valign="middle"><?php echo $this->lang->line('txt_Enter_Tag');?></td>
	  <td colspan="2" align="left" valign="top"><input name="tag" type="text" id="tag" maxlength="255"></td>
    </tr>

	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td>&nbsp;</td>
		<td colspan="2">
			
			<input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>"/>
			<input name="cancel" type="button" class="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-1)" />
			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">		
			<input type="hidden" name="addOption" value="new">	
					
		</td>
  </tr> 
</table>
</form>