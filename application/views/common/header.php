<div id="header-container" class="desktopHead">
  <div id="header">
    <div id="left">
      <ul>

      	<!--Added by Dashrath- used for hide show left menu bar-->
      	<li>
      		<img id="leftMenuToggleIcon" onClick="leftMenuHideShow()" src="<?php echo base_url();?>images/toggle_icon_white.png"/>
      	</li>
      	<!--Dashrath- code end-->

        <li><a href="<?php echo base_url().'dashboard/index/'.$workSpaceId.'/type/1';?>"><img class="logoImg" src="<?php echo base_url();?>images/logo_white.png"  /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>

        <!--Commented by Dashrath- comment place logo -->
		<!-- <?php 
			if ($_SESSION['workPlaceId']!='') 
			{
				$workPlaceDetails 	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
					if ($workPlaceDetails['companyLogo']!='noimage.jpg')
					{
		?>
						<li><a href="<?php echo base_url().'dashboard/index/'.$workSpaceId.'/type/1';?>"><img class="companyLogoMain" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/place_logo/<?php echo $workPlaceDetails['companyLogo'];?>"></a></li>
						<li><img src="<?php echo base_url();?>images/sep.png" /></li>
		<?php
					}
					else
					{
					?>
						<li style="margin-left: 54px;">&nbsp;</li>
					<?php
					}
			}
		?> -->

		<!--Teeme search Start-->
		<?php
		if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
		{
		?>
		<li>
		<!--Manoj: check if it search page or not-->
		
		<?php 
			if($this->uri->segment(1)!='search')
			{
				$_SESSION['searchText']='';
			}
		?>
		
		<!--Manoj: checking for search page end-->
			<input class="headSearch" type="text" onblur="this.placeholder = 'search'" onfocus="this.placeholder = ''"  onkeyup="" <?php if(isset($_SESSION['searchText']) && $_SESSION['searchText']!=''){?>value="<?php echo  $_SESSION['searchText']; ?>" <?php }else { ?>value=""<?php } ?> placeholder="search" id="headSearch" name="headSearch">
			<input type="hidden" id="searchMsg" name="searchMsg" value="<?php echo $this->lang->line('txt_search_query_short'); ?>">
		</li>
		<?php
		
			$userStatusDetails = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
		}
		?>
		
		<!--Teeme search end--> 
      </ul>
    </div>
    <div id="right">
	<!--status popup start-->
	<?php
		if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
		{
		?>	
	<div id="statusPopup" class="gen_comment">
        <div id="list_preview">
		<form id="userStatusForm">
			<textarea id="userStatus"><?php echo $userStatusDetails['statusUpdate']; ?></textarea>
		</form>
		</div>
		<div class="statusUpdateMsg" style="color:#099731;"></div>
        <input type="button" value="Update" onclick="updateUserStatus()" style="margin-top:5px;">
		<input type="button" value="Cancel" onclick="cancelStatusPopup()" style="margin-top:5px;">
	</div>		
	<?php
		}
	?>
	<!--Status popup end-->
      <ul>
	  	<!--All tree icons start-->
		<?php
		if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
		{
		
		/*$workSpaces 			=$this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
		$total_documents		=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 1); 
		$total_discussions		=$this->identity_db_manager->getTreeCountByTreeDiscussion($workSpaceId, $workSpaceType,$_SESSION['userId'], 2);
		$total_chats			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 3 );
		$total_tasks			=$this->identity_db_manager->getTreeCountByTreeTask($workSpaceId, $workSpaceType,$_SESSION['userId'] ,4,2 );
		$total_notes			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 6 );
		$total_contacts			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 5 );*/
		//$total_notification		=$this->identity_db_manager->get_total_notification_count($_SESSION['userId']); 
		//$notificationData		=$this->identity_db_manager->get_notification_data($_SESSION['userId']); 
		/*echo '<pre>';
		print_r($notificationData);
		exit;*/
				
		?>
		
		
		<li class="unbordered notifyIcon">
          <?php
			   /*
				if ($_SESSION['workPlacePanel'] == 1)
				{
			?>
          <a href="<?php echo base_url();?>instance/admin_logout/place_manager"><?php echo $this->lang->line('txt_Sign_Out');?></a>
          <?php	
				}
				*/
				//else if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				//{ 
				if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				{
					?>
					
					<!--For notification icon-->
					<?php //$temp=  (is_numeric($total_notification) && $total_notification>0)?$total_notification:"0"; ?>
					<span style="margin:0 5px;"><a title="<?php echo $this->lang->line('txt_Home'); ?>" href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><img title="<?php echo $this->lang->line('txt_Home'); ?>" src="<?php echo base_url();?>images/icon_home.png"  class="left-menu-icon" /></a></span>
					<span style="margin:0 5px;"><a target="_blank" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/home" style="color:#fff; cursor: pointer;"><img title="<?php echo $this->lang->line('txt_Post'); ?>" src="<?php echo base_url();?>images/icon_chat.png"  class="left-menu-icon" /></a>
</span>
					<div class="notify_box">
					<a id="notificationLink" onclick="seenAllNotification()">
				  	<img src="<?php echo base_url();?>images/notification.png"  title="Notification" style="margin-top:19px;cursor:pointer;height:21px;border:0px;" />  
				  	</a>	
					<span class="button__badge" id='notificationCount' style="display:none;"><?php //echo $temp; ?></span>
					</div>				
					<div id="notificationContainer">
					<div id="notificationTitle"><?php echo $this->lang->line('txt_notifications'); ?></div>
					<div id="allNotificationData">
					<div id="notificationsBody" class="notifications">
						<div class="notificationContent">
							<div class="notifyLoader"></div>
							<?php if(count($notificationData)>0)
							/*{ 
							 	foreach($notificationData as $notification)
								{	
									?>
									<div class="notification_url">
										<?php echo $notification['notification_data']; ?>
									</div>
									<?php
								}
							?>
							<?php }
							else { ?>
							<?php echo $this->lang->line('txt_notification_not_found');
							}*/
							 ?>
						</div>
					</div>
					<!-- Added by Dashrath- Add div for scroll loader-->
					<div class="scrollNotifyLoader"></div>

					<?php /*?><span id="loading"><img src="<?php echo base_url();?>images/loader-64x/ajax-loader.gif"  style="margin:4px; cursor:pointer; height:12px; border:0px;" /> </span><?php */?>
					</div>
					
					<!--Commented by Dashrath- comment this code and add new code below-->
					<!-- <div id="notificationFooter"><a href="<?php echo base_url(); ?>notifications/setDispatchNotification/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>" style="color:#000;"><?php echo $this->lang->line('txt_see_all'); ?></a>
					</div> -->
					
					<!--Added by Dashrath- replace below code-->
					<div id="notificationFooter"><a onclick="seeAllNotificationData('<?php echo $workSpaceId;?>','<?php echo $workSpaceType; ?>')" style="color:#000; cursor: pointer;"><?php echo $this->lang->line('txt_see_all'); ?></a>
					</div>
					<!--Dashrath- code end-->

					</div>

					<!--Notification icon end-->
					
					
					<!--For task calendar icon-->
					<a <?php if(!(in_array('4',$treeTypeIds)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?> href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0">
				  	<img class="taskCalendarIcon" src="<?php echo base_url();?>images/task_calendar.png"  title="Calendar" style="margin-top:19px;cursor:pointer;height:21px;border:0px; padding-left:8px;" />  
				  	</a>
					
					<a href="<?php echo base_url();?>preference/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>">
				  	<img src="<?php echo base_url();?>images/settings.png"  title="Preferences" style="margin-top:19px;cursor:pointer;height:21px;border:0px; padding-left:4px;" />  
				  	</a>
					
					<?php } ?>
				</li>
					<!--Task calendar icon end-->
			
		
		
		<li id="imgUsername">
          <?php
			//if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='' && $_SESSION['workPlacePanel'] != 1)
			//{
			if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
			{
				?>
			  <a>
			  <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); 
				?>
			  <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
			  <!--<img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >-->
			  <img class="clsHeaderUserImage rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $_SESSION['photo'];?>" >
			  <?php }
			  else
			  { ?>
			  	 <img class="clsHeaderUserImage rounded_profile_pic" src="<?php echo base_url();?>images/<?php echo $_SESSION['photo'];?>" >
			  <?php } ?>
			   </a>
			  <?php /*?> <div> <?php */ ?>
			  <div class="UserFirstLastName">
			  <a target="_blank" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $_SESSION['userId'];?>" class="showreranks" style="cursor:pointer;" title="<?php echo trim($userStatusDetails['statusUpdate']); ?>">
			  <?php
				  //echo $this->lang->line('txt_Hi').", ";	
				  //echo $_SESSION['firstName'] .' '.$_SESSION['lastName'] ;
				  echo $_SESSION['userTagName'];
			  ?>
			  </a>
			  </div>
			 <?php /*?> </div><?php */?>
<!--			  <div>
			  	<a class="showreranks" style="cursor:pointer; margin-left:20px;">status</a>
			  </div>-->
			  <?php /*?></div><?php */?>
			  
			 
			  <?php
			}
			/*
			else if ($_SESSION['workPlacePanel'] == 1)
			{
			?>
          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >
          <?php } ?>
          <?php echo $this->lang->line('txt_Hi');?>,
          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo ucfirst($tmp[0]);?>
          <?php
			}
			*/
			?>
        </li>
		
		<?php /*?><li class="" >
			<a href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1">
				<img src="<?php echo base_url();?>images/header_icons/home.png"  title="Dashboard" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
		</li>
		
		
		<li class="treeIcons" >
			<a href="<?php echo base_url();?>new_tree/index/<?php echo $workSpaceId; ?>">
				<img src="<?php echo base_url();?>images/header_icons/add_new_tree.png"  title="Create new tree" style="margin-top:18px;cursor:pointer;height:22px;border:0px;" /> 
			</a>
		</li>
		
		
		<?php $temp=(is_numeric($total_documents) && $total_documents>0)?$total_documents:"0"; ?>
		<li class="treeIcons" >
			<div class="notify_box">
			<a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
				<img src="<?php echo base_url();?>images/header_icons/icon_document_sel.png"  title="Document" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
			<span class="button__badge" id='docCount'><?php echo $temp; ?></span>
			</div>
		</li>
		
		<?php $temp=  (is_numeric($total_chats) && $total_chats>0)?$total_chats:"0"; ?>
		<li class="treeIcons" >
			<div class="notify_box">
			<a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
				<img src="<?php echo base_url();?>images/header_icons/discuss-view.png"  title="Discuss" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
			<span class="button__badge" id='disCount'><?php echo $temp; ?></span>
			</div>
		</li>	
		
		<?php $temp=  (is_numeric($total_tasks) && $total_tasks>0)?$total_tasks:"0"; ?>			
		<li class="treeIcons" >
			<div class="notify_box">
			<a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
				<img src="<?php echo base_url();?>images/header_icons/icon_task_sel.png"  title="Task" style="margin-top:21px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
			<span class="button__badge" id='taskCount'><?php echo $temp; ?></span>
			</div>
		</li>
		
		<?php $temp=  (is_numeric($total_notes) && $total_notes>0)?$total_notes:"0"; ?>
		<li class="treeIcons" >
			<div class="notify_box">
			<a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
				<img src="<?php echo base_url();?>images/header_icons/notes-view-sel.png"  title="Notes" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
			<span class="button__badge" id='notesCount'><?php echo $temp; ?></span>
			</div>
		</li>
		
		<?php $temp=  (is_numeric($total_contacts) && $total_contacts>0)?$total_contacts:"0"; ?>
		<li class="treeIcons">
			<div class="notify_box">
			<a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
				<img src="<?php echo base_url();?>images/header_icons/contact-view_sel.png"  title="Contact" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
			<span class="button__badge" id='contCount'><?php echo $temp; ?></span>
			</div>
		</li>
		<li>
			<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>">
				<img src="<?php echo base_url();?>images/header_icons/post_notify.png"  title="Post" style="margin-top:19px;cursor:pointer;height:20px;border:0px;" /> 
			</a>
		</li><?php */?>
		<?php } ?>
		<!--All tree icons end-->
	  
        
        <li class="unbordered">
          <?php
			   /*
				if ($_SESSION['workPlacePanel'] == 1)
				{
			?>
          <a href="<?php echo base_url();?>instance/admin_logout/place_manager"><?php echo $this->lang->line('txt_Sign_Out');?></a>
          <?php	
				}
				*/
				//else if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				//{ 
				if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				{
					?>
					
					<!--Timeline post icon start-->
					
					<?php /*?><a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>" target="_blank">
				  	<img src="<?php echo base_url();?>images/header_icons/help.png"  title="Help" style="border: medium none; height: 19px; margin-top: 15px; padding: 4px 0 3px 12px; width: 20px;" /> 
				  	</a><?php */?>
					<!--Timeline post icon start-->
					
				  	<a title="Sign Out" href="<?php echo base_url();?>instance/admin_logout/work_place"><span id="logoutTxt"><?php //echo $this->lang->line('txt_Sign_Out');?></span> <img class="" style="height: 16px;margin-top: 15px;padding: 7px 0 4px 2px;width: 16px;border: medium none;" src="<?php echo base_url();?>images/logout.png" ></a>				  
				 	 <?php
				}
			?>
        </li>
      </ul>
    </div>
    <div class="clr"></div>
  </div>
</div>