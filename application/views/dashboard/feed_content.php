<?php 
foreach($feeds as $feed)
{
?>
	<!--feed content div start-->
	<div class="feedContent" id="<?php echo $feed['notification_event_id']; ?>">
		<!--feed content header div start-->
		<div class="feedContentHeader">
			<span class="feedTitle">
				<?php echo $feed['object_history'][0]['feedTitle'];?>
			</span>
			<?php if ($feed['object_history'][0]['url']!='')
			{ 
			?> 
				<span class="feedUrlClickIcon">
					<a href="<?php echo base_url().$feed['object_history'][0]['url']; ?>">
						View
						<!-- <img style="vertical-align: middle;" src="<?php echo base_url();?>images/go_to_icon_15.png" /> -->
					</a> 
				</span>
			<?php 
			} 
			?>
		</div>
		<div class="clr"></div> 
		<!--feed content header div end-->

		<!--feed content footer div start-->
		<div class="feedContentFooter">
			<!--feed left content div start-->
			<div class="feedLeftContent">
			  	<div class="floatLeft">
			  		<!--user profile section start-->
					<?php
					if ($feed['object_history'][0]['photo']!='noimage.jpg')
					{
					?>
						<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $feed['object_history'][0]['photo'];?>" border="0"  width="35" height="35" id="imgName" class="feedUserActionImage"> 
	              	<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/<?php echo $feed['object_history'][0]['photo'];?>" border="0"  width="35" height="35" id="imgName" class="feedUserActionImage"> 
					<?php
					}
					?>
					<!--user profile section end-->	
				</div>

				<div class="floatLeft" style="margin-left:5px; ">
					<p class="feedUserDetailsDiv">
						<!--show use online or offline icon section start-->
						<?php 
						if($feed['object_history'][0]['isOnlie']==1)
						{
						?>
							<img src="<?php echo base_url();?>images/online_user.gif" width="15" height="15" />
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url();?>images/offline_user.gif" width="15" height="15" />
						<?php
						}
						?>
						<!--show use online or offline icon section end-->	
						
						<!--show user tag name-->
						<b><?php echo strip_tags($feed['object_history'][0]['userTagName'],'<b><em><span><img>'); ?></b>
					</p>

					<!--timestamp section start-->
					<p class="postTimeStamp" style="margin-top: 5px;">
						<span>
						<?php echo $this->time_manager->getUserTimeFromGMTTime($feed['object_history'][0]['create_time'],$this->config->item('date_format')); ?>
						</span>	
					</p>
					<!--timestamp section end-->
				</div>
			</div>
			<!--feed left content div end-->

			<!--feed middle content div start-->
			<div class="feedMiddleContent">
				<?php 
				if($feed['object_history'][0]['feedDescription']!="")
				{
				?>
					<div class="feedDetail">
						<?php echo $feed['object_history'][0]['feedDescription']; ?>
					</div>
				<?php
				}
				?>
			</div>
			<!--feed middle content div end-->

			<?php 
			if(count($feed['object_history'])>1)
			{
			?>
			<!--feed right content div start-->
			<div class="feedRightContent">
				<hr  class="feedEventHistoryHr" />
				<span class="EventHistoryTitle">Event History:</span>
				<br/>
				<span class="feedEventHistoryTitle">
					<?php 
					$j=0;
					$feedUserCount = count($feed['object_history']);
					?>

					<?php
					foreach($feed['object_history'] as $feedActionUserHistory)
					{
						if($j<4 && $j>0){
					?>
						<span>
							<?php echo $feedActionUserHistory['user_action_content'];?>
							<span class="postTimeStamp">
							<?php echo $this->time_manager->getUserTimeFromGMTTime($feedActionUserHistory['create_time'],$this->config->item('date_format')); ?>
							</span>
						</span>
						<br/>
					<?php
						}
					$j++;	
					}
					?>

					<?php
					if($feedUserCount>4)
					{
					?>
						<span id="see_more_button_<?php echo $feed['notification_event_id']?>" onclick="seeMoreFeed('<?php echo $feed['notification_event_id'];?>')" style="display: inline; cursor: default;color: #0645ad;">See More <br/></span>

						<!-- <span id="see_less_button_<?php echo $feed['notification_event_id']?>" onclick="seeLessFeed('<?php echo $feed['notification_event_id'];?>')" style="display: none;cursor: default;color: #0645ad;">See Less <br/></span> -->

						<span id="see_more_feed_<?php echo $feed['notification_event_id']; ?>" style="display: none;">
							<?php 
							for($k=4; $k<count($feed['object_history']);$k++)
							{
							?>
								<?php echo $feed['object_history'][$k]['user_action_content'];?>
								<span class="postTimeStamp">
								<?php echo $this->time_manager->getUserTimeFromGMTTime($feed['object_history'][$k]['create_time'],$this->config->item('date_format')); ?>
								</span>
								<br/>
							<?php 
							}
							?>
						</span>
					<?php
					} 
					?>
					<span id="see_less_button_<?php echo $feed['notification_event_id']?>" onclick="seeLessFeed('<?php echo $feed['notification_event_id'];?>')" style="display: none;cursor: default;color: #0645ad;">See Less <br/></span>
				</span>
			</div>
			<!--feed right content div end-->

			<?php 
			}
			?>
		</div>
		<!--feed content footer div end-->

		<div class="clr"></div> 
	</div>
	<!--feed content div end-->
<?php
}
?>