
<div name="divSearchUser" style="padding:5px 0;">
<div>Users</div>
				<?php
				//echo "<pre>"; print_r($workSpaceMembers); exit;
				//echo "<pre>"; print_r($workPlaceMembers); exit;
				//echo "active view= ".$active_view; exit;
				$arrActiveMembers = array();
				if ($active_view=='space'){
					$arrActiveMembers = $workSpaceMembers;
				}	
				else{
					$arrActiveMembers = $workPlaceMembers;
				}	
				?>

				<?php
				if(count($arrActiveMembers) > 0)
				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;

						?>


							<?php
							if ($_SESSION['all'])
							{
								if ($myProfileDetail['userGroup']>0)
									$showMemberList = 1;
								else
									$showMemberList = 0;
							}
							else
							{
								$showMemberList = 1;
							}	
							if ($showMemberList)
							{		
	
							foreach($arrActiveMembers as $keyVal=>$arrVal)
							{
							
								/*if(in_array($arrVal['userId'],$arrayUsers))
								{*/
									if ($_SESSION['all'])
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
								//shows only online users on top
	
								 if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
								 {
										if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
										{
											if ($arrVal['isPlaceManager']==1)
											{
												$showOnlyPlaceManagersForGuests = 1;
											}
											else
											{
												$showOnlyPlaceManagersForGuests = 0;
											}
										}
										else
										{
											$showOnlyPlaceManagersForGuests = 1;
										}	
										
										if ($showOnlyPlaceManagersForGuests)
										{
													
											$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
										?>
										<!--
											<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />';  ?> 
											<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
											<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"  class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a>
									
											<div class="clr"></div>
										-->
										<div class="post_web_sidebar_row">
											<div class="post_web_sidebar_col1">
												<div class="post_web_sidebar_profile_pic">					
												<?php
													if ($arrVal['photo']!='noimage.jpg') {?>
														<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
															<?php
													}
													else {?>
														<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/<?php echo $arrVal['photo'];?>" border="0"  width="45" height="45" id="imgName"> 
														<?php
													} ?>
												</div>
											</div>
											<div class="post_web_sidebar_col2">
												<div class="post_web_sidebar_user_time">
													<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
													<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>
												</div>
											</div>	  		
										</div>
									
	
										<?php
									}
									$i++;
								}
	
								/*}*/
							}
	
							
	
								foreach($arrActiveMembers as $keyVal=>$arrVal)
								{
									/*if(in_array($arrVal['userId'],$arrayUsers)){*/
									if ($_SESSION['all'])
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
									//shows only offline users 
	
								 	if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
								 	{
											if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
											{
												
												if ($arrVal['isPlaceManager']==1)
												{
													$showOnlyPlaceManagersForGuests = 1;
												}
												else
												{
													$showOnlyPlaceManagersForGuests = 0;
												}
											}
											else
											{
												$showOnlyPlaceManagersForGuests = 1;
											}	
										
											if ($showOnlyPlaceManagersForGuests)
											{
												$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						
		
											?>
											<!--
												<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<span><img src="'.base_url().'images/offline_user.gif" width="15" height="16"  style="margin-top:5px;float:left;" /></span>';?> 
												<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
												<span style="width:1%; float:left;"><a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a></span>
										
												<div class="clr"></div>
											-->
											<div class="post_web_sidebar_row">
												<div class="post_web_sidebar_col1">
													<div class="post_web_sidebar_profile_pic">					
														<?php
														if ($arrVal['photo']!='noimage.jpg') {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
																<?php
														}
														else {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/<?php echo $arrVal['photo'];?>" border="0"  width="45" height="45" id="imgName"> 
															<?php
														} ?>
													</div>
												</div>
												<div class="post_web_sidebar_col2">
													<div class="post_web_sidebar_user_time">
														<?php  echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
														<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>					
													</div>
												</div>	  		
											</div>
									
										
										<?php
										}
									$i++;
	
								}
	
							/*}*/
							}
	
						}

						

				}

				else

				{

				?>

        			<span class="postTimeStamp"><?php echo $this->lang->line('txt_None');?></span>

        		<?php

				}

				?>
</div>
<?php
if ($active_view!='space'){
?>
	<div name="divSpaces" style="padding:5px 0;">
		<div>Spaces/subspaces:</div>
				<?php 	
						if (count($userAllSpaces)>0) {
							foreach($userAllSpaces as $keyVal=>$arrVal){
								?>
								<div class="post_web_sidebar_row">
									<div class="post_web_sidebar_col1">
										<div class="post_web_sidebar_profile_pic">					
											<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0" width="45" height="45" id="imgName"> 
										</div>
									</div>
									<div class="post_web_sidebar_col2">
										<div class="post_web_sidebar_user_time">
											<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/space/<?php echo $arrVal['workSpaceId']; ?>" class="blue-link-underline" title="<?php echo $arrVal['workSpaceName']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['workSpaceName'],true); ?> </a>
										</div>
									</div>	  		
									<div class="clr"></div>
								</div>
								<?php	
								if (count($userAllSubSpaces)>0) {							
									foreach($userAllSubSpaces as $keyVal2=>$arrVal2){
										if ($arrVal['workSpaceId']==$arrVal2['workSpaceId']){
										?>
											<div class="post_web_sidebar_row">
												<div class="post_web_sidebar_col1">
													<div class="post_web_sidebar_profile_pic">					
														<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0" width="45" height="45" id="imgName"> 
													</div>
												</div>
												<div class="post_web_sidebar_col2">
													<div class="post_web_sidebar_user_time">
														<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/subspace/<?php echo $arrVal2['subWorkSpaceId']; ?>" class="blue-link-underline" title="<?php echo $arrVal2['subWorkSpaceName']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal2['subWorkSpaceName'],true); ?> </a>
													</div>
												</div>	  		
												<div class="clr"></div>
											</div>
										<?php
										}	
									}
								}
							}
						}
						else

						{
		
						?>
		
							<span class="postTimeStamp"><?php echo $this->lang->line('txt_None');?></span>
		
						<?php
		
						}
				?>

	</div>			
<?php } ?>
<div name="divChats" class="post_web_tab_menu_tab">
<div>Posts:</div>
<?php //echo "<pre>"; print_r($userActivePosts);?>
			<?php 	
					if (count($userActivePosts)>0) {
						foreach($userActivePosts as $keyVal=>$arrVal){
							?>
							<div class="post_web_sidebar_row">
								<!--
								<div class="post_web_sidebar_col1">
									<div class="post_web_sidebar_profile_pic">	
										<?php
										if ($arrVal['photo']!='noimage.jpg') {?>
											<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
												<?php
										}
										else {?>
											<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/<?php echo $arrVal['photo'];?>" border="0"  width="45" height="45" id="imgName"> 
											<?php
										} 
										?>				
									</div>
								</div>
								-->
								<div class="post_web_sidebar_col2">
									<!--
									<div class="post_web_sidebar_user_time">
										<span class="post_web_sidebar_username_data post_web_sidebar_secondary">
										<?php if ($arrVal['post_type_id']==1 || $arrVal['post_type_id']==2 || $arrVal['post_type_id']==3 || $arrVal['post_type_id']==5 || $arrVal['post_type_id']==7 || $arrVal['post_type_id']==9) {
										?>
											<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a>

										<?php											
										} /*else if ($arrVal['post_type_id']==2) {?>
										<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/space/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a>
										<?php } else if ($arrVal['post_type_id']==3) { ?>
											<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/subspace/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a>
										<?php } */?>
										</span>
										<div><span class="post_web_sidebar_secondary spaceNameAllPost"><?php echo $arrVal['space_name'];?></span></div>
									</div>
									-->
									<div class="post_web_sidebar_data">
										<span class="post_web_sidebar_secondary post_web_sidebar_username_data"><a href="<?php echo base_url().$arrVal['url'];?>"><?php echo $arrVal['last_post_data']; ?></a></span>
										<?php if($arrVal['unseen_post_count']>0){?>
										<div><span class="post_web_post_count"><?php echo $arrVal['unseen_post_count']; ?></span></div>
										<?php } ?>
										<div><span class="post_web_sidebar_secondary spaceNameAllPost"><?php echo $arrVal['space_name'];?></span></div>
									</div>
									<div class="post_web_sidebar_data">
										<?php if ($arrVal['post_type_id']==1 || $arrVal['post_type_id']==2 || $arrVal['post_type_id']==3 || $arrVal['post_type_id']==5 || $arrVal['post_type_id']==7 || $arrVal['post_type_id']==9) {
											?>
												<span class="post_web_sidebar_timestamp postTimeStamp"><a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a></span>

											<?php											
										}?>
										<span class="post_web_sidebar_username_data postTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['last_post_timestamp'],$this->config->item('date_format')); ?></span>
										<div><span class="postTimeStamp"><?php if($arrVal['change_detail']!=''){echo $arrVal['change_detail'];}?></span></div>
									</div>							
								</div>	  		
								<div class="clr"></div>
							</div>
							<?php	
						}
					}
					else

					{
	
					?>
	
						<span class="postTimeStamp"><?php echo $this->lang->line('txt_None');?></span>
	
					<?php
	
					}
			
			?>
		</div>