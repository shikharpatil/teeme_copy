<!--<div id="divChats" name="divChats" class="post_web_tab_menu_tab">-->
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
			?>
		<!--</div>-->