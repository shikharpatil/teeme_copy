<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><select name="select" class="white-border" onChange="goWorkSpace(this)">
		
	<option value=""><?php echo $this->lang->line('field_Select_Workspace');?></option>
	<option value="0"><?php echo $this->lang->line('field_My_Workspace');?></option>
	<?php
	$i = 1;
	foreach($workSpaces as $keyVal=>$workSpaceData)
	{				
		if($workSpaceData['workSpaceManagerId'] == 0)
		{
			$workSpaceManager = $this->lang->line('txt_Not_Assigned');
		}
		else
		{					
			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
			$workSpaceManager = $arrUserDetails['userName'];
		}
		?>		
	<option value="<?php echo $workSpaceData['workSpaceId'];?>"><?php echo $workSpaceData['workSpaceName'];?></option>
	<?php
	}
	?>
</select>