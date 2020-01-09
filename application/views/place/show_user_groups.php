<table width="99%" border="0" align="center">

       <?php

		if(count($userGroupDetails) > 0)

		{

		?>		

          <tr>

            <td width="3%" align="left"><strong>Id</strong></td>

            <td width="16%" align="left"><strong><?php echo $this->lang->line('txt_Group_Name');?></strong></td>

            <td width="22%" align="left"><strong><?php echo $this->lang->line('txt_Created_By');?> </strong></td>
			
			<td width="22%" align="left"><strong><?php echo $this->lang->line('txt_Created_Date');?> </strong></td>
			
			<td width="22%" align="left"><strong><?php echo $this->lang->line('txt_Edited_Date');?> </strong></td>

          	<td width="15%" align="left"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

          </tr>

			<?php

			$i = 1;

			/*echo '<pre>';
			print_r($userGroupDetails);
			exit;*/

			foreach($userGroupDetails as $groupData)

			{				

			?>		

			  <tr>

				<td><?php echo $i; ?></td>

				<td align="left"><div style="width:80%; overflow:hidden; text-overflow: ellipsis;"><?php echo wordwrap(strip_tags(stripslashes($groupData['groupName'])),15,"\n",true);?></div></td>

                <td align="left">
					<?php 
						$userDetails = $this->identity_db_manager->getUserTagNameByUserId($groupData['placemanagerId']);
						echo $userDetails['tagName'];
					?>
				</td>
				
				<td align="left"><?php echo $this->time_manager->getUserTimeFromGMTTime($groupData['createdDate'],'m-d-Y h:i A');?></td>
				
				<td align="left">
					<?php 
					if($groupData['lastEditedDate'] != '0000-00-00 00:00:00')
					{
						echo $this->time_manager->getUserTimeFromGMTTime($groupData['lastEditedDate'],'m-d-Y h:i A');
					}
					?>
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

        </table>