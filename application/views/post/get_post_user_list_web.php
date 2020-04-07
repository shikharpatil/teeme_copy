<?php
				//echo "<pre>"; print_r($workSpaceMembers); exit;
				if(count($workSpaceMembers) > 0)

				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;

						?>

          			<div id="divSearchUser" name="divSearchUser">

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
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
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
													<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>
												</div>
											</div>	  		
										</div>
					</div>
	
										<?php
										}
								$i++;
	
								}
	
							/*}*/
							}
	
							
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
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
														<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>					
													</div>
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

        			<span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span>

        		<?php

				}

				?>
