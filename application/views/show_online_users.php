<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><table width="95%" border="0" cellpadding="0" cellspacing="1" align="right">

	<tr>

		<td class="bg-light-blue"  bgcolor="#FFFFFF"><img src="<?php echo base_url();?>images/group_user.gif" width="15" height="16" /><strong> <?php echo $this->lang->line('txt_Online_Users');?> </strong></td>

	</tr>

	<tr>

		<td align="center" valign="top" class="grbg">

			<table width="100%" border="0" cellspacing="1" cellpadding="1" align="right">

				<?php 

				/*$objMemCache = new Memcached;

				$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
				
				//Manoj: get memcache object	
				$this->load->model('dal/identity_db_manager');
				$memc=$this->identity_db_manager->createMemcacheObject();

				if(count($onlineUsers) > 0)

				{

					foreach($onlineUsers as $userId)

					{			

						$memCacheId = 'wp'.$_SESSION['workPlaceId'].'user'.$userId;

						$userDetails = $objMemCache->get( $memCacheId );

						foreach($userDetails as $userData)

						{

							$userName = $userData->tagName;

						}

						//$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($userId);

					?>

					<tr>

						

						<td width="2%" align="left"  bgcolor="#FFFFFF"><img src="<?php echo base_url();?>images/online_user.gif" width="15" height="16" /></td>

						<td width="97%" align="left" class="one"  bgcolor="#FFFFFF"><?php echo $userName;?></td>

					</tr>

				<?php

					}

				}

				if(count($workSpaceMembers) > 0)

				{		

					foreach($workSpaceMembers as $arrVal)

					{

						if(!in_array($arrVal['userId'],$onlineUsers))

						{ 

								$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);

							?>

						<tr>

							

							<td width="2%" align="left"  bgcolor="#FFFFFF"><img src="<?php echo base_url();?>images/offline_user.gif" width="15" height="16" /></td>

							<td width="97%" align="left" class="one"  bgcolor="#FFFFFF"><?php echo $userDetails['userTagName'];?></td>

						</tr>

						<?php

							}		

						}

					}	

						?>

			</table>

		</td>

	</tr>

</table>