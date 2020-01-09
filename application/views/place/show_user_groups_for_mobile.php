<?php
$rowColor1='row-active-middle1';
						$rowColor2='row-active-middle2';	
						$i = 1;	
foreach($userGroupDetails as $groupData)
{
						$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 
						$userDetails = $this->identity_db_manager->getUserTagNameByUserId($groupData['placemanagerId']);
						//echo $userDetails['tagName'];
					
								
						?>
    <div class="<?php echo $rowColor; ?> " style="margin:3% 0; padding:3%;"> <!--Manoj: Add margin padding-->
          <div class="row-active-header-inner1" style="width:50%; padding:0;">
        
        <a style="color:#000;"><?php echo wordwrap(strip_tags(stripslashes($groupData['groupName'])),15,"\n",true); 			 
							?> </a> </div>
			<div style="width:40%; float:right;">
				<?php 

				

			if($_SESSION['WPManagerAccess'] == true)

			{

			?>
			
				<a href="javascript:void(0);" onclick="showPopWin('<?php echo base_url();?>user_group/view/<?php echo $groupData['groupId'];?>',710,420,null,'')">
				<img src="<?php echo base_url();?>images/manage_users.gif" alt="<?php echo $this->lang->line('txt_View');?>" title="<?php echo $this->lang->line('txt_View');?>"border="0" >
				</a>

				<a href="<?php echo base_url();?>user_group/update/<?php echo $groupData['groupId'];?>">
				<img style="padding-left:8px;" src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>" title="<?php echo $this->lang->line('txt_Edit');?>" border="0">						                </a>
				<a href="<?php echo base_url();?>user_group/delete/<?php echo $groupData['groupId'];?>">
				<img style="padding-left:8px;" src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" onClick="return confirmDelete()" border="0" >
				</a>

			<?php

			}

			?>	
			</div>				
			<!--Manoj:  Add created date width fontsize color-->
          <div class="row-active-header-inner2" style="width:50%; font-size:12px; color:#666666;"> <span><?php echo $userDetails['tagName'];?></span> </div>
		  <div class="row-active-header-inner3" style="width:40%; font-size:12px; color:#666666; float:right;"> <span><?php echo $this->time_manager->getUserTimeFromGMTTime($groupData['createdDate'],'m-d-Y h:i A'); ?></span> </div>
		   <!--Manoj: code end-->
          <div class="clr"></div>
        </div>
    <?php
							
							$i++;
						
}
?>

<?php /*?>
<table width="99%" border="0" align="center">

       <?php

		if(count($userGroupDetails) > 0)

		{

		?>		

          <tr>

            <td width="7%" align="left"><strong>Id</strong></td>

            <td width="35%" align="left"><strong><?php echo $this->lang->line('txt_Group_Name');?></strong></td>

            <td width="25%" align="left"><strong><?php echo $this->lang->line('txt_Created_By');?> </strong></td>
			
			<td width="40%" align="left"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

          </tr>

			<?php

			$i = 1;

			foreach($userGroupDetails as $groupData)

			{				

			?>		

			  <tr>

				<td><?php echo $i; ?></td>

				<td align="left"><?php echo $groupData['groupName'];?></td>

                <td align="left" >
					<div style="width:110px; overflow:hidden; text-overflow: ellipsis;">
					<?php 
						$userDetails = $this->identity_db_manager->getUserTagNameByUserId($groupData['placemanagerId']);
						echo $userDetails['tagName'];
					?>
					</div>
				</td>
				
				<td align="left">

			<?php 

				

			if($_SESSION['WPManagerAccess'] == true)

			{

			?>
			
				<a href="javascript:void(0);" onclick="showPopWin('<?php echo base_url();?>user_group/view/<?php echo $groupData['groupId'];?>',710,420,null,'')">
				<img src="<?php echo base_url();?>images/manage_users.gif" alt="<?php echo $this->lang->line('txt_View');?>" title="<?php echo $this->lang->line('txt_View');?>"border="0" >
				</a>

				<a href="<?php echo base_url();?>user_group/update/<?php echo $groupData['groupId'];?>">
				<img style="padding-left:8px;" src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>" title="<?php echo $this->lang->line('txt_Edit');?>" border="0">						                </a>
				<a href="<?php echo base_url();?>user_group/delete/<?php echo $groupData['groupId'];?>">
				<img style="padding-left:8px;" src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" onClick="return confirmDelete()" border="0" >
				</a>

			<?php

			}

			?>	

			</td>

			  </tr>

		<?php

				$i++;					

			}

		}

		?>

        </table><?php */?>