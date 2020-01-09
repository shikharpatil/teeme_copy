<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<span id="userExtendLinks1">
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="right">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" class="blue-border">
        <tr>
          <td class="bg-light-blue"><img src="<?php echo base_url();?>images/group_user.gif" width="15" height="16" /><strong> <?php echo $this->lang->line('txt_Online_Users');?> </strong></td>
        </tr>
        <tr>
          <td align="center" valign="top" class="grbg"><table width="100%" border="0" cellspacing="1" cellpadding="1" align="right">
              <?php 
							/*$objMemCache = new Memcached;
							$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
							//Manoj: get memcache object	
							$this->load->model('dal/identity_db_manager');
							$objMemCache=$this->identity_db_manager->createMemcacheObject();
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
								?>
              <tr>
                <td width="2%" align="left" bgcolor="#FFFFFF"><img src="<?php echo base_url();?>images/online_user.gif" width="15" height="16" /></td>
                <td width="97%" align="left" class="one" bgcolor="#FFFFFF"><h1><a href="<?php echo base_url();?>personal_Chat/start_Chat/<?php echo $userId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><?php echo $userName;?> </a></h1></td>
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
                <td width="2%" align="left" bgcolor="#FFFFFF"><img src="<?php echo base_url();?>images/offline_user.gif" width="15" height="16" /></td>
                <td width="97%" align="left" class="one" bgcolor="#FFFFFF"><h1><a href="<?php echo base_url();?>personal_Chat/start_Chat/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;" target="_blank"><?php echo $userDetails['userTagName'];?></a></h1></td>
              </tr>
              <?php
								
									}		
								}
								}	
								?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</span> 
<script language="javascript">
	showOnlineUsers( <?php echo $workSpaceId;?>, 1, 'userExtendLinks1' );
</script>