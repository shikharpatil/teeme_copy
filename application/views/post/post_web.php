<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Post</title>
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';		
	</script>
<script>
$(document).ready(function() 
{
	/*var tablet_view = (/ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(tablet_view==true)
	{
		$('#table_view').show();
	}
	else
	{
		$('#desktop_view').show();
	}*/
});
</script>
<!--Manoj: Back to top scroll script-->
<?php //$this->load->view('common/scroll_to_top'); ?>
<!--Manoj: code end-->
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php //$this->load->view('common/artifact_tabs'); ?>
	<?php
	foreach($arrTimeline as $keyVal=>$arrUsers)
	{
		$arrayUsers[] = $arrUsers['userId'];
	}
	$arrayUsers = array_unique($arrayUsers);
	//echo '<pre>';
	//print_r($arrayUsers);
	//exit;
	
		$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
		if ($workSpaceType==2)
		{
			$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
		}
		else
		{
			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
		}		
		if($workSpaceType==1)
		{
			$treeAccess	= $this->identity_db_manager->getTreeAccessByWorkSpaceId($workSpaceId);
			$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
		}
		else
		{		
			$treeAccess	= $this->identity_db_manager->getTreeAccessByWorkSpaceId($workSpaceDetails['workSpaceId']);
			$subWorkSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
			$submemberIds = array();
				foreach($subWorkSpaceMembers as $submembersData)
				{
					$submemberIds[] = $submembersData['userId'];
				}
			$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceDetails['workSpaceId'], 3);
		}
		foreach($workSpaceManagers as $managersData)
		{
			$managerIds[] = $managersData['managerId'];
		}
	//	$totalSpacePosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'space');
		//$totalSpacePosts = $this->timeline_db_manager->getPostCountTimeline($workSpaceId, $workSpaceType, 0, 'space');
		//echo $totalSpacePosts;exit;
		//$totalPublicPosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'public');
		//$allPosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'all');
		//$getAllPosts = $this->timeline_db_manager->get_timeline('0', $workSpaceId, $workSpaceType, '1');
		//$allPosts = count($getAllPosts);	
		$allBookmarkSpace='3';
		//$bookmarkPosts	= $this->timeline_db_manager->get_timeline('0',$workSpaceId,$workSpaceType,$allBookmarkSpace);
		//$totalBookmarkPosts = count($bookmarkPosts);
		//$totalBookmarkPosts = count($bookmarkedPosts);
		//echo count($bookmarkPosts).'===='; exit;
		//echo $totalSpacePosts.'======'.$totalPublicPosts;exit;
		/*$postType=0;
		if($this->uri->segment(8)=='all')
		{
			$postType='all';
		}
		else if($this->uri->segment(8)=='public')
		{
			$postType='public';
		}
		else if($this->uri->segment(8)=='bookmark')
		{
			$postType='bookmark';
		}*/
	?>
  </div>
</div>
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
  <div id="rightSideBar"> 
  <!--Online users code start here-->
  <div id="desktop_view">
  	<div id="TimelineLeftContent2">
		<!--Space and place section start here-->
		<div>
		<!--
		<div>
		
		<select name="postTypeSelect" id="postTypeSelect" class="selbox-post" onChange="javascript:selectPostType(this,'<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>');">
			
			<?php if ($myProfileDetail['userGroup']>0) { ?>
		
		<option value="space"><a style="margin-top: 9px;padding-left:11px;<?php if(!$_SESSION['all'] && !$_SESSION['public']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>"><span>

          <?php 

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

          <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a></option>
		  <?php } else if ($workSpaceId>0){ ?>
		<option value="space"><a style="margin-top: 9px; padding-left:11px;<?php if(!$_SESSION['all']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>"><span>

          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

          <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a></option>
		  <?php } ?>
		  
		<?php if ($workSpaceDetails['workSpaceName']!="Try Teeme") { ?>
        <option value="all" <?php if($this->uri->segment(8)=='all') echo 'selected';?> ><a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/all" style="margin-top: 9px;padding-left:11px;  <?php if($_SESSION['all']) { ?>background:#ECECEC;" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a></option>
		<?php } ?>
		

		<option value="public" <?php if($this->uri->segment(8)=='public') echo 'selected';?>>
			<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/public" style="margin-top: 9px;padding-left:11px;  <?php if($_SESSION['public']) { ?>background:#ECECEC;" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>
		</option>
		
		<option value="bookmark" <?php if($this->uri->segment(8)=='bookmark') echo 'selected';?>>
			<a style="margin-top: 9px;padding-left:11px;" id="bookmark"><?php echo $this->lang->line('txt_post_starred').' ('.$totalBookmarkPosts.')'; ?></a>
			
		</option>
			
		</select>

  <div class="clr"></div>

        </div>
		-->
		</div><?php ?>
		<!--Space and place section end here-->	
		<!--
		<div class="post_web_sidebar_header post_web_sidebar_row">
			<div class="post_web_sidebar_col1">
				<div class="post_web_sidebar_profile_pic">					
				<?php
					if ($myProfileDetail['photo']!='noimage.jpg' && $myProfileDetail['photo']!='') {?>
						<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $myProfileDetail['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
                          	<?php
					}
					else {?>
						<img alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45" id="imgName"> 
						<?php
					} ?>
				</div>
			</div>
			<div class="post_web_sidebar_col2">
				<div class="post_web_sidebar_user_time">
					<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
					<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $myProfileDetail['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($myProfileDetail['tagName'],true); ?> </a>
				</div>
			</div>	
			<div class="clr"></div>  		
		</div>
		-->
          <?php
				//online user list view
				
				//echo "<li>searchuser= " .$workSpaceId_search_user ."<li>".count($workSpaceMembers);exit;
				//if ($workSpaceId_search_user == 0)
				if(0)
				{
					?>
					<div class="post_web_search">
					<?php
					if ($_SESSION['all'])
					{
						if ($myProfileDetail['userGroup']>0)
							$showSearchBox = 1;
						else
							$showSearchBox = 0;
					}
					else
					{
						$showSearchBox = 1;
					}
					if ($showSearchBox)	
					{
					?>
						<input type="text" name="search" id="search" value="" placeholder="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:98%"/>
					<?php
					}
					?>

					  <div class="clr"></div>
				</div>

					
					<?php

					if(count($workSpaceMembers) > 0)

					{

						$rowColor1='rowColor6';

						$rowColor2='rowColor5';	

						$i = 1;

						?>

                        <div id="divSearchUser" name="divSearchUser">

                        <?php 	

						//show online users	
						
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
							foreach($workSpaceMembers  as $keyVal=>$arrVal)
							{
								/*if(in_array($arrVal['userId'],$arrayUsers))
								{*/
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
	
								//shows only online users on top
								
									if ($_SESSION['all'])
									{
										if ($myProfileDetail['userGroup']>0)
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
								?>
									<!--
									<div id="row1" class="<?php echo $rowColor;?>"> 
										<?php echo '<img src="'.base_url().'images/online_user.gif"  width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
										<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
										<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"  class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>	
										<div class="clr"></div>	
									</div>
									-->

									<div class="post_web_sidebar_row">
												<div class="post_web_sidebar_col1">
													<div class="post_web_sidebar_profile_pic">					
													<?php
														if ($arrVal['photo']!='noimage.jpg' && $arrVal['photo']!='') {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
																<?php
														}
														else {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45" id="imgName"> 
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
												<div class="clr"></div>
											</div>

									
								<?php
									}
									$i++;
	
								} 
	
								 
	
							/*}*/
							}//close online users 
	
							
	
							//shows remaining offline users
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
	
							{
								/*if(in_array($arrVal['userId'],$arrayUsers))
								{*/
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	
	
									if ($_SESSION['all'])
									{
										if ($myProfileDetail['userGroup']>0)
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
	
								//condition for showing (remaining)offline users	
	
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
									?>
									<!--	
										<div id="row1" class="<?php echo $rowColor;?>" style="float:left;width:100%"> <?php echo '<span><img src="'.base_url().'images/offline_user.gif" width="15" height="16" style="margin-top:5px;float:left;" /></span>';?> 
											<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
											<span style="float:left; width:1%;"><a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a></span>
											<div class="clr"></div>
										</div>
									-->
									<div class="post_web_sidebar_row">
												<div class="post_web_sidebar_col1">
													<div class="post_web_sidebar_profile_pic">					
													<?php
														if ($arrVal['photo']!='noimage.jpg' && $arrVal['photo']!='') {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
																<?php
														}
														else {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45" id="imgName"> 
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
												<div class="clr"></div>
											</div>
									<?php
									}
									$i++;
	
								 }
	
							/*}*/
							}
						}
						

					  ?>

      </div>

          <?php

					}

				if(1)

				{

				?>

          <span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span>

          <?php

				}

				 ?>

          <?php 

			}

			else

			{

			?>

				<div id="row1" class="post_web_search">

				<?php
				if ($_SESSION['all'])
				{
					if ($myProfileDetail['userGroup']>0)
						$showSearchBox = 1;
					else
						$showSearchBox = 0;
				}
				else
				{
					$showSearchBox = 1;
				}
				if ($showSearchBox)	
				{
				?>
					<input type="text" name="search" id="search" value="" placeholder="Search..."  onKeyUp="showSearchUser()" onclick="removeSearh()" onblur="writeSearh()" style="width:95%"/>
				<?php
				}
				?>

				<div class="clr"></div>

      			</div>

				<div class="clr"></div>
				<div id="divSearchResult"></div>
				<div class="clr"></div>
				<div class="post_web_tab_menu">
					<ul class="post_web_tab_menu_list">
						<li class="active"><a href="#divChats">Live feed</a></li>
						<li><a href="#divSearchUser">Users</a></li>
						<?php if ($_SESSION['active_view']!='space'){?>
							<li><a href="#divSpaces">Spaces</a></li>
						<?php } ?>
						<!--<li><a href="#divGroups">Groups</a></li>-->
					</ul>
					<div class="clr"></div>
				</div>

		
		<div id="post_web_sidebar_loader" class="loader" style="display:none;"><span><img src='<?php echo base_url();?>images/ajax-loader-add.gif'></span></div>
		<div id="divChats" name="divChats" class="post_web_tab_menu_tab" style="display:block;">
			<?php //echo "<pre>"; print_r($userActivePosts);?>
			<?php 	
					if (count($userActivePosts)>0) {
						foreach($userActivePosts as $keyVal=>$arrVal){
							?>
							<div class="post_web_sidebar_row" id="row_<?php echo $arrVal['last_post_id'];?>">
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
													<span class="postTimeStamp"><a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a></span>

												<?php											
											}?>
											<?php /*else if ($arrVal['post_type_id']==2) {?>
											<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/space/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a>
											<?php } else if ($arrVal['post_type_id']==3) { ?>
												<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/subspace/<?php echo $arrVal['sender_id']; ?>" class="blue-link-underline" title="<?php echo $arrVal['sender_name']; ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['sender_name'],true); ?> </a>
											<?php } */?>
										</span>									
										<div><span class="post_web_sidebar_secondary spaceNameAllPost"><?php echo $arrVal['space_name'];?></span></div>
									</div>
									-->
									<div class="post_web_sidebar_data">
										<span class="post_web_sidebar_secondary post_web_sidebar_username_data" style="width:50%;"><a onclick="postHighlight('<?php echo $arrVal['last_post_id'];?>','<?php echo $arrVal['last_post_id'];?>','<?php echo $active_view;?>');" href="<?php echo base_url().$arrVal['url'];?>"><?php echo $arrVal['last_post_data']; ?></a></span>
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
		</div>
		<div id="divSpaces" name="divSpaces" class="post_web_tab_menu_tab" style="display:none;width:25%;">
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
			?>

		</div>
		<div id="divGroups" name="divGroups" class="post_web_tab_menu_tab" style="display:none;">Groups feature not currently available</div>
		<div class="clr"></div>

		<?php		
			$arrActiveMembers = array();
				if ($_SESSION['active_view']=='space'){
					$arrActiveMembers = $workSpaceMembers;
				}	
				else{
					$arrActiveMembers = $workPlaceMembers;
				}	
				//if(count($workSpaceMembers) > 0)
				//if(count($workPlaceMembers) > 0)
				if(count($arrActiveMembers) > 0)
				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;



						?>

						  <div id="divSearchUser" name="divSearchUser" class="post_web_tab_menu_tab" style="display:none;width:25%;">
						  

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
	
							//foreach($workSpaceMembers as $keyVal=>$arrVal)
							//foreach($workPlaceMembers as $keyVal=>$arrVal)
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

											<div class="post_web_sidebar_row">
												<div class="post_web_sidebar_col1">
													<div class="post_web_sidebar_profile_pic">					
													<?php
														if ($arrVal['photo']!='noimage.jpg' && $arrVal['photo']!='') {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
																<?php
														}
														else {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45" id="imgName"> 
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
												<div class="clr"></div>
											</div>
	
										<?php
										}
								$i++;
	
								}
	
							/*}*/
							}

							//foreach($workSpaceMembers as $keyVal=>$arrVal)
							//foreach($workPlaceMembers as $keyVal=>$arrVal)
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

										<div class="post_web_sidebar_row">
											<div class="post_web_sidebar_col1">
												<div class="post_web_sidebar_profile_pic">					
													<?php
														if ($arrVal['photo']!='noimage.jpg' && $arrVal['photo']!='') {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
																<?php
														}
														else {?>
															<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="30" id="imgName"> 
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
											<div class="clr">
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

      </div>

          <?php 

				}

				?>

        
  </div>
  </div>
  <!--Online users code end here-->
  <div id="TimelineRightContent2">
  <!--Tab section start here-->
	
  	<div id="postTabUI" class="postTabUI">
	  	<div class="leftTabUl">
		<!--Plus icon for public post start here-->
		<?php /*if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds) || isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')*/
		//echo $_SESSION['WSManagerAccess'].'===='.$_SESSION['workPlaceManagerName'];
		/*
		if((isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1) || (isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')) 
		{ 
			//if($_SESSION['public'] == 'public')
			if($this->uri->segment('5') == 'public')
			{
		?>
			
				<div class="postAddIcon">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
				</div>
			
		<?php
			}
		}
		*/
		if($this->uri->segment('5') == 'one')
		{
			if($this->uri->segment('6')==$_SESSION['userId']) 
			{ 
		?>
		
			<div class="postAddIcon" id="myBtn">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
			</div>	
		<?php
			}
		}
		else if(($this->uri->segment('5') == 'space' || $this->uri->segment('5') == 'space_ex' || $this->uri->segment('5') == 'subspace') && ($this->uri->segment('6')==$workSpaceId))
		{
			if($this->uri->segment('6')>0)
			{ 				
				if ($this->uri->segment('5') == 'subspace'){
					$wsDetails = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($this->uri->segment('6'));
					$wsId = $wsDetails['workSpaceId'];
					if($isSubSpaceProfileMember){$allowAddPost=1;}
					else{$allowAddPost=0;}
				}
				else if ($this->uri->segment('5') == 'space_ex'){
					$wsId =$this->uri->segment('6');
					if ($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $wsId, 3)){
						$allowAddPost=1;
					}
					else{
						$allowAddPost=0;
					}
				}
				else{
					$wsId =$this->uri->segment('6');
					if($isSpaceProfileMember){$allowAddPost=1;}
					else{$allowAddPost=0;}
				}
				//if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1)
				//echo 'wsid= ' .$wsId; exit;
				//if($wsId!='-1' && $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $wsId, 3))
				if($allowAddPost)
				{
					?>		
					<div class="postAddIcon" id="myBtn">
					<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
					</div>	
					<?php
				}
			}
			else if(($this->uri->segment('5') == 'space') && ($this->uri->segment('6') == 0) && ($workSpaceId==0)) {
			?>
				<div class="postAddIcon" id="myBtn">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
				</div>	
			<?php
			}
		}
		elseif($this->uri->segment('5') == 'public')
		{
			//if((isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1) || (isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')) 
			if((isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')) 
			{ 
		?>
		
			<div class="postAddIcon" id="myBtn">
			<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
			</div>	
		<?php
			}
		}
		else{
		?>
			<div class="postAddIcon" id="myBtn">
			<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
			</div>
		<?php
		}
		?>
		<!--Plus icon for public post end here-->
		
		<?php 			
		/*
		if(!$_SESSION['all'] && !$_SESSION['public']){ ?>
			<?php if($this->uri->segment('8')!='bookmark'){ ?>
				<div class="postAddIcon">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
				</div>
			<?php 
			} 
		} 
		*/
		/*
		if(!$_SESSION['all'] && !$_SESSION['public']){ ?>
			<?php //if($this->uri->segment('5')!='bookmark' && $_SESSION['userId']==$post_type_object_id){ 
				if($this->uri->segment('5')!='bookmark'){
				?>
				<div class="postAddIcon">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
				</div>
			<?php 
			} 
		} 	
		*/
		/*		
		if($_SESSION['all'] && !$_SESSION['public'] && $this->uri->segment('5')!='bookmark' && $this->uri->segment('5')!='space' && $this->uri->segment('5')!='one'){ 			
		?>
			<?php //if($this->uri->segment('5')!='bookmark' && $_SESSION['userId']==$post_type_object_id){ 
				?>
				<div class="postAddIcon" id="myBtn">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
				</div>
			<?php 
		} 
		*/			
		?>
		<!--Plus icon end here-->
		</div>
		<?php /* if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>
		<div class="rightTabUl">
			<ul class="tab_menu_new" style="float:right;">
				<li>

					<!--<a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a>-->
					
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/one/<?php echo $_SESSION['userId']?>/bookmark<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='bookmark') { ?>" class="active <?php } ?>" id="bookmark"><?php echo $this->lang->line('txt_post_starred').' ('.$totalBookmarkPosts.')'; ?></a>
					
				</li>

				<li>

				<!--<a href="javascript:void(0);" id="profile" style="padding-left:12px;margin-left:17px;" title="profile" class="<?php if($profileForm=='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#profile').addClass('active');$('#passwordForm').removeClass('active');$('#notification').removeClass('active');$('#password_form').hide();$('#notificationSection').hide();$('#profileForm').show(); clearSessionMsg();"><?php echo $this->lang->line('profile_txt'); ?></a>-->
					
					<?php if ($workSpaceDetails['workSpaceName']!="Try Teeme") { ?>
					<!--<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/1/all<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>-->
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/home" style="padding-left:12px;margin-left:17px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>				
				<?php } ?>

				</li>
			</ul>
		</div>
		<?php } */?>
		<div class="leftTabUl">
			<!--Parv: Uncomment this for tab menu instead. Also disable the javascript for the dropdown in the scripts section at the bottom. Search by 'drop_down_menu'.
			<ul class="tab_menu_new">
			-->
			<?php //if ($_SESSION['active_view']!='space' && $post_type_id!=2 && $post_type_id!=3 && $post_type_id!=9){ ?>
			<?php if ((($post_type_id!=2 && $post_type_id!=3 && $post_type_id!=9) || $post_type_object_id==0)){ ?>
			<!-- Shikhar : added div with id="dropCount" below, for updating the post count in the dropdown after the post is created.  -->
			<div id="dropCount">
			<ul class="drop_menu_new">
			<li><a href="javascript:void(0);">--Select--</a><li>
			<?php if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>
			<li>
				<?php /*?> <a href="javascript:void(0);" id="profile" style="padding-left:12px;margin-left:17px;" title="profile" class="<?php if($profileForm=='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#profile').addClass('active');$('#passwordForm').removeClass('active');$('#notification').removeClass('active');$('#password_form').hide();$('#notificationSection').hide();$('#profileForm').show(); clearSessionMsg();"><?php echo $this->lang->line('profile_txt'); ?></a><?php */?>
				
				<?php // if ($workSpaceDetails['workSpaceName']!="Try Teeme" && $_SESSION['active_view']!='space') { ?>
				<?php if ($workSpaceDetails['workSpaceName']!="Try Teeme") { ?>
				<!--<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/1/all<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>-->
				<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/home" style="padding-left:12px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>				
				<?php } ?>
			</li>
			<?php } ?>
			<li>
            <?php /*?><a href="javascript:void(0);" style="padding-left:12px;margin-left:2px;" id="notification" title="notification" class="<?php if($profileForm!='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#notification').addClass('active');$('#profile').removeClass('active');$('#passwordForm').removeClass('active');$('#profileForm').hide();$('#password_form').hide();$('#notificationSection').show(); clearSessionMsg();">
			</a><?php */?>
			
			<?php 
			if ($workSpaceType==1){
				$link = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/space/".$workSpaceId;
			}
			else{
				$link = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/subspace/".$workSpaceId;
			}
			/*
			if ($myProfileDetail['userGroup']>0) { ?>
		
			<!--<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && !$_SESSION['public'] && $this->uri->segment(8)!='bookmark') { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?><?php if($this->uri->segment(10)!=''){ echo '/0/0/'.$userPostSearch; }?>">-->
			<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && !$_SESSION['public'] && $this->uri->segment(5)!='bookmark' && (($this->uri->segment(5)=='space' || $this->uri->segment(5)=='subspace') && $this->uri->segment(6)==$workSpaceId)) { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo $link;?>">

			<span>

			<!--<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $_SESSION['userId']; ?>"-->
			//$_SESSION['all'] condition for hiding option for all tab

			if($workSpaceId){ ?>

			<?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

			<?php } else { ?>

			<?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

			<?php } ?>

			</span></a>
		  <?php } 
		  else if ($workSpaceId>0){ ?>
			<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && $this->uri->segment(5)!='bookmark') { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>"><span>
          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

          <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a>
		  <?php } */?>

        	</li>	
		
				<?php //if($workSpaceDetails['workSpaceName']!="Try Teeme" && $_SESSION['active_view']!='space'){ ?>
				<?php if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>

				<?php if($myProfileDetail['userGroup']>0){ ?>
				<li>

				<?php /*?><a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a><?php */?>
				
				<!--<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/public<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px;  <?php if($_SESSION['public']) { ?>" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>-->
				<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/public/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;  <?php if($_SESSION['public']) { ?>" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>

				</li>
				<?php } ?>	
				<li>

					<?php /*?><a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a><?php */?>
					
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/bookmark/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='bookmark') { ?>" class="active <?php } ?>" id="bookmark"><?php echo $this->lang->line('txt_post_starred').' ('.$totalBookmarkPosts.')'; ?></a>
					
				</li>	
				<?php } ?>
				<!--
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/one/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='one' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'My Posts'.' ('.$totalMyPosts.')'; ?></a>
				</li>
				-->
				<?php //if($_SESSION['active_view']!='space'){?>
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/parked/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='parked' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Parked'.' ('.$totalParkedPosts.')'; ?></a>
				</li>
				<?php //} ?>
				<li>
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/drafts" style="padding-left:12px; <?php if($this->uri->segment(5)=='drafts') { ?>" class="active <?php } ?>" id="drafts"><?php echo 'Drafts ('.$totalDraftPosts.')'; ?></a>	
				</li>
				<!--	
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/following/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='following' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Following'; ?></a>
				</li>
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/followers/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='followers' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Followers'; ?></a>
				</li>
				-->
		
			<?php /*?><li>

				<a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="preferences" title="preferences" class="" onclick="$('#preferences').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#editorChoice').show();"><?php echo $this->lang->line('preferences_txt'); ?></a>

			</li><?php */?>

		
			</ul>
			</div>
			<?php } ?>
		</div>
		<div class="clr"></div>
	</div>
	
	<!--Tab section end here-->		
	
				
	<div class="timelineTopContent"> 
  		<!--Timeline profile start here-->
		<!--<div id="TimelineProfile"  style=" display: <?php if($this->uri->segment(10)==''){ echo 'none';}else{ echo 'block';}?> ">-->
		<div id="TimelineProfile">
			<?php
			if($post_type_id==1 && count($Profiledetail)>0){
			?>
			<div class="timelineProfImg">
				<?php
				if ($Profiledetail['photo']!='noimage.jpg' && $Profiledetail['photo']!='')
				{
				?>
					<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $Profiledetail['photo'];?>" width="65" height="65" id="imgName"> 
                <?php
				}
				else
				{
				?>
					<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" width="65" height="65" id="imgName"> 
				<?php
				}
				?>					
			</div>
			<div class="postUserDetailsBox">
				<div class="profileLeftLabel" style="padding:3px 0;">
					<span>
						<?php //if($Profiledetail['firstName']!='' && $Profiledetail['lastName']!='') { echo $Profiledetail['firstName'].' '.$Profiledetail['lastName']; } ?>
						<?php if($Profiledetail['editUserTagName']!='') { echo $Profiledetail['editUserTagName']; } ?>
					</span>
						<?php
							$treeDetails['seedId']=$Profiledetail['userId']; 
							$treeDetails['object_id']=15; // 15 is for user object. Look in notification_objects table for reference
							$this->load->view('common/section_follow_post',$treeDetails);
						?>
				</div>
				<div style="padding:3px 0;">											
					<span>
						<?php //if($Profiledetail['editUserTagName']!='') { echo $Profiledetail['editUserTagName']; } ?>
						<?php echo "<b>Status:</b> "; if($Profiledetail['statusUpdate']!='') { echo $Profiledetail['statusUpdate']; } ?>
					</span>
				</div>
				<div style="padding:3px 0;">
					<a id="divProfileLink" href="#divProfile">Show Profile</a>
				</div>
			</div>
			<!--
			<div class="" style="float:right; padding-top:0px; margin-right: 60px;">
				<?php /*?>Expiry Date: <input name="timeline_exp_date" type="text"  id="timeline_exp_date" class="timelineExpDate" value="" readonly><?php */?>
				<?php /*?><div><img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location.reload(true);' style="cursor:pointer; padding-top:0px;"></div><?php */?>
			</div>
			-->
			<?php 
			} // end if a user profile
			// if a space or subspace profile
			
			else if ($post_type_id==2 && count($Profiledetail)>0){				
				?>				
				<div class="timelineProfImg">
					<img class="rounded_profile_pic" id="imgName" alt="image" src="<?php echo base_url();?>images/noimage.jpg" width="65" height="65">
				</div>
				<div class="postUserDetailsBox">
					<span class="profileLeftLabel">
						<?php echo $Profiledetail['workSpaceName'] .' (space)'; ?>
						<?php
						/*
							if(!$isSpaceProfileMember){
								$treeDetails['seedId']=$post_type_object_id; 
								$treeDetails['object_id']=10; // 10 is for space object. Look in notification_objects table for reference
								$this->load->view('common/section_follow_post',$treeDetails);
							}
						*/
						?>
					</span>
					<!--
					<div>
						<span>Created on:<?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['workSpaceCreatedDate'],$this->config->item('date_format')); ?></span>
						<span>Created by:<?php echo $Profiledetail['workSpaceCreatorUsername']; ?></span>
					</div>
					-->
				</div>
				<?php
			}
			else if ($post_type_id==3 && count($Profiledetail)>0){				
				?>
				<div class="timelineProfImg">
					<img class="rounded_profile_pic" id="imgName" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45">
				</div>
				<div class="postUserDetailsBox">
					<span class="profileLeftLabel">
						<?php echo $Profiledetail['subWorkSpaceName'] .' (sub-space)'; ?>
						<?php
						/*
						if(!$isSubSpaceProfileMember){
							$treeDetails['seedId']=$post_type_object_id; 
							$treeDetails['object_id']=11; // 11 is for sub-space object. Look in notification_objects table for reference
							$this->load->view('common/section_follow_post',$treeDetails);
						}*/
						?>
					</span>
					<!--
					<div>
						<span>Created on:<?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['subWorkSpaceCreatedDate'],$this->config->item('date_format')); ?></span>
						<span>Created by:<?php echo $Profiledetail['subWorkSpaceCreatorUsername']; ?></span>
					</div>
					-->
				</div>
				<?php
			}
			else if ($post_type_id==7){				
				?>
				<div class="timelineProfImg">
					<img class="rounded_profile_pic" id="imgName" alt="image" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="45" height="45">
				</div>
				<div class="postUserDetailsBox">
					<span class="profileLeftLabel">Public</span>
				</div>
				<?php
			}
			/*
			else {
				echo "Nothing found";
			}
			*/
			?> 
			<div class="clr"></div>
		</div>	
		
			<?php
			/*
			if($post_type_id!=5){
			?>
				<div class="post_web_tab_menu_2 main_tabs">
					<ul class="post_web_tab_menu_list_2">
						<li class="active"><a href="#TimelinePost">Internal</a></li>
						<li><a href="#divProfile">External</a></li>						
					</ul>
					<div class="clr"></div>
				</div>

			<?php 
			} */?>
			<?php 
			if (($post_type_id==2 || $post_type_id==9) && $post_type_object_id>0){
				$link1 = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/space/".$post_type_object_id;
				$link2 = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/space_ex/".$post_type_object_id;
				if ($myProfileDetail['userGroup']>0) { ?>
					<div class="post_web_tab_menu_2 main_tabs">
						<ul class="post_web_tab_menu_list_2">
							<li <?php if($this->uri->segment(5)=='space'){ echo 'class="active"'; }?>><a href="<?php echo $link1;?>">Internal</a></li>
							<li <?php if($this->uri->segment(5)=='space_ex'){ echo 'class="active"'; }?>><a href="<?php echo $link2;?>">External</a></li>						
						</ul>
						<div class="clr"></div>
					</div>
				<?php
				}
			}/*
			else{
				$link = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/subspace/".$workSpaceId;
			}*/
			

			/*
			if(count($Profiledetail)>0){
			?>
				<div style="float:left;width:100%;height:30px;">
					<div style="margin-top:12px;border-bottom:1px dotted gray;margin-left:0%" ></div>
				</div>
				<div class="clr"></div>
			<?php
			} */?>
		<!--Timeline profile end here-->
	<div>
		<div class="leftAddBox">
		</div>		
		<div class="rightAddBox">
					<div style="float:right;">
					<!--Show all post(s) created by user-->
							<?php 
								if($this->uri->segment(10)!='')
								{
								
										if($Profiledetail['editNickName']!='') 
										{
											$postUserName = $Profiledetail['editNickName'];
										}
										else
										{
											$postUserName = $Profiledetail['editUserTagName'];
										}
										?>
										<span style="padding-right:30px;">
										<?php
										echo $this->lang->line('txt_show_all_user_post').$postUserName;
										?>
										</span>
										<span>
										<?php
											if($this->uri->segment('8')=='public')
											{
												$showAllUrl = '/0/1/public';
											}
											else if($this->uri->segment('8')=='bookmark')
											{
												$showAllUrl = '/0/1/bookmark';
											}
											else if($this->uri->segment('8')=='all')
											{
												$showAllUrl = '/0/1/all';
											}
											else
											{
												$showAllUrl = '/'.$workSpaceId.'/'.$workSpaceType;
											}
										?>
										<a style="float:right;" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType.$showAllUrl; ?>"><?php echo $this->lang->line('txt_show_all_post'); ?></a>
										</span>
										<?php
									}
								?>
				<!--code end-->
			</div>
		</div>
	</div>
	<div class="clr"></div>
		</div>
		<div class="clr"></div>
								<div id="divProfile" class="post_web_tab_menu_tab_2" <?php if($this->uri->segment('5')=='space_ex'){ ?> style="display:block;"<?php } else {?> style="display:none;"<?php } ?>>
			<div class="divProfileContainer">
				<?php if ($post_type_id==1) {?>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Name</b></span><span class="divProfileColumn2"><?php if($Profiledetail['firstName']!='' && $Profiledetail['lastName']!='') { ?><?php echo $Profiledetail['firstName'].' '.$Profiledetail['lastName']; ?><?php } ?></span></div>														
				<div class="divProfileRow"><span class="divProfileColumn1"><b>User tag</b></span><span class="divProfileColumn2"><?php if($Profiledetail['editUserTagName']!='') { ?><?php echo $Profiledetail['editUserTagName'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Email</b></span><span class="divProfileColumn2"><?php if($Profiledetail['userName']!='') { ?><?php echo $Profiledetail['userName'];?><?php } ?></span></div>				
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Registration date</b></span><span class="divProfileColumn2"><?php if($Profiledetail['registeredDate']!='') { ?><?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['registeredDate'],$this->config->item('date_format'));?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Last logged in</b></span><span class="divProfileColumn2"><?php if($Profiledetail['lastLoginTime']!='') { ?><?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['lastLoginTime'],$this->config->item('date_format'));?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Status</b></span><span class="divProfileColumn2"><?php if($Profiledetail['statusUpdate']!='') { ?> <?php echo $Profiledetail['statusUpdate'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Nick name</b></span><span class="divProfileColumn2"><?php if($Profiledetail['editNickName']!='') { ?><?php echo $Profiledetail['editNickName'];?><?php } ?></span></div>				
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Role</b></span><span class="divProfileColumn2"><?php if($Profiledetail['role']!='') { ?><?php echo $Profiledetail['role'];?><?php } ?></span></div>	
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Mobile no.</b></span><span class="divProfileColumn2"><?php if($Profiledetail['mobile']!='') { ?><?php echo $Profiledetail['mobile'];?><?php } ?></span></div>	
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Address line 1</b></span><span class="divProfileColumn2"><?php if($Profiledetail['address1']!='') { ?><?php echo $Profiledetail['address1'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Address line 2</b></span><span class="divProfileColumn2"><?php if($Profiledetail['address2']!='') { ?><?php echo $Profiledetail['address2'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>City</b></span><span class="divProfileColumn2"><?php if($Profiledetail['city']!='') { ?><?php echo $Profiledetail['city'];?><?php } ?></span></div>	
				<div class="divProfileRow"><span class="divProfileColumn1"><b>State</b></span><span class="divProfileColumn2"><?php if($Profiledetail['state']!='') { ?><?php echo $Profiledetail['state'];?><?php } ?></span></div>	
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Country</b></span><span class="divProfileColumn2"><?php if($Profiledetail['country']!='') { ?><?php echo $Profiledetail['country'];?><?php } ?></span></div>	
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Zip</b></span><span class="divProfileColumn2"><?php if($Profiledetail['zip']!='') { ?><?php echo $Profiledetail['zip'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Other</b></span><span class="divProfileColumn2"><?php if($Profiledetail['other']!='') { ?><?php echo $Profiledetail['other'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Skills</b></span><span class="divProfileColumn2"><?php if($Profiledetail['skills']!='') { ?><?php echo $Profiledetail['skills'];?><?php } ?></span></div>
				<div class="divProfileRow"><span class="divProfileColumn1"><b>Department</b></span><span class="divProfileColumn2"><?php if($Profiledetail['department']!='') { ?><?php echo $Profiledetail['department'];?><?php } ?></span></div>
				<?php } else if ($post_type_id==9) {?>
					<div style="display:flex;width:100%;margin:1em 0;">
						<div class="timelineProfImg">
							<img class="rounded_profile_pic" id="imgName" alt="image" src="<?php echo base_url();?>images/noimage.jpg" width="65" height="65">
						</div>
						<div class="postUserDetailsBox">
							<span class="profileLeftLabel">
								<?php echo $Profiledetail['workSpaceName'] .' (space)'; ?>
								<?php
									if(!$isSpaceProfileMember){
										$treeDetails['seedId']=$post_type_object_id; 
										$treeDetails['object_id']=10; // 10 is for space object. Look in notification_objects table for reference
										$this->load->view('common/section_follow_post',$treeDetails);
									}
								?>
							</span>
							<!--
							<div>
								<span>Created on:<?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['workSpaceCreatedDate'],$this->config->item('date_format')); ?></span>
								<span>Created by:<?php echo $Profiledetail['workSpaceCreatorUsername']; ?></span>
							</div>
							-->
						</div>
					</div>
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Space name</b></span><span class="divProfileColumn2"><?php if($Profiledetail['workSpaceName']!='') { ?><?php echo $Profiledetail['workSpaceName']; ?><?php } ?></span></div>														
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Created on</b></span><span class="divProfileColumn2"><?php if($Profiledetail['workSpaceCreatedDate']!='') { ?><?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['workSpaceCreatedDate'],$this->config->item('date_format'));?><?php } ?></span></div>
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Created by</b></span><span class="divProfileColumn2"><?php if($Profiledetail['workSpaceCreatorUsername']!='') { ?><?php echo $Profiledetail['workSpaceCreatorUsername']; ?><?php } ?></span></div>														
					<?php 
					//echo "<pre>";print_r($spaceProfileMembers);
					/*
					if (count($spaceProfileMembers )>0){
						echo "<div class='profileLeftLabel' style='align:left;'>Members</div>";
						foreach($spaceProfileMembers as $keyVal=>$arrVal){
						?>
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
										<?php //echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
										<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>
									</div>
								</div>	  		
								<div class="clr"></div>
							</div>
						<?php 
						} 
					}*/?>
				<?php } else if ($post_type_id==3) {?>
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Sub-space name</b></span><span class="divProfileColumn2"><?php if($Profiledetail['subWorkSpaceName']!='') { ?><?php echo $Profiledetail['subWorkSpaceName']; ?><?php } ?></span></div>														
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Created on</b></span><span class="divProfileColumn2"><?php if($Profiledetail['subWorkSpaceCreatedDate']!='') { ?><?php echo $this->time_manager->getUserTimeFromGMTTime($Profiledetail['subWorkSpaceCreatedDate'],$this->config->item('date_format'));?><?php } ?></span></div>
					<div class="divProfileRow"><span class="divProfileColumn1"><b>Created by</b></span><span class="divProfileColumn2"><?php if($Profiledetail['subWorkSpaceCreatorUsername']!='') { ?><?php echo $Profiledetail['subWorkSpaceCreatorUsername']; ?><?php } ?></span></div>														
					<?php 
					//echo "<pre>";print_r($spaceProfileMembers);
					if (count($subSpaceProfileMembers )>0){
						echo "<div class='profileLeftLabel' style='align:left;'>Members</div>";
						foreach($subSpaceProfileMembers as $keyVal=>$arrVal){
						?>
							<div class="post_web_sidebar_row">
								<div class="post_web_sidebar_col1">
									<div class="post_web_sidebar_profile_pic">					
										<?php
										if ($arrVal['photo']!='noimage.jpg' && $arrVal['photo']!='') {?>
											<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $arrVal['photo'];?>" border="0"  width="49px" height="49px" id="imgName"> 
										<?php
										}
										else {?>
											<img class="rounded_profile_pic" alt="image" src="<?php echo base_url();?>images/noimage.jpg" width="45" height="45" id="imgName"> 
										<?php
										} ?>
									</div>
								</div>
								<div class="post_web_sidebar_col2">
									<div class="post_web_sidebar_user_time">
										<?php //echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
										<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/one/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>
									</div>
								</div>	  		
								<div class="clr"></div>
							</div>
						<?php 
						} 
					}?>
				<?php } ?>
			</div>	
		</div>

		<!--
		<div id="divPhotos" class="post_web_tab_menu_tab_2" style="display:none;">Photos</div>
		<div id="divVideos" class="post_web_tab_menu_tab_2" style="display:none;" >Videos</div>
				-->
		<div id="TimelinePost" class="post_web_tab_menu_tab_2">
			
		<!--Timeline editor start here-->
		<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
		<!-- Parv: uncomment below two lines for modal UI instead of talk window UI
			<div id="TimelineEditor" class="timeline_editor modal" style="display:none;">			
			<form name="formTimeline" class="modal-content" id="formTimeline" method="post" action="">-->
			<div id="TimelineEditor" style="display:none;">			
			<form name="formTimeline" id="formTimeline" method="post" action="">
				<!--<span class="close">&times;</span>-->
				<span id="postFormHeader"></span>				
				<textarea name="replyDiscussion" id="replyDiscussion"></textarea>
				<input name="list" value="" id="list" type="hidden" />
				<input name="listSpaces" value="" id="listSpaces" type="hidden" />
				<input name="listSubSpaces" value="" id="listSubSpaces" type="hidden" />
				<input name="listGroup" value="" id="listGroup" type="hidden" />
				<!--Myspace select recepient code start-->
				 
				 
				<?php
				
				//if((($workSpaceId=='0' && $post_type_id==2) || $_SESSION['all']) && !$_SESSION['public'])
				if(1)
				{
				?>		
					<div id="multiSend">							
						<!--Group feature start here-->
						<?php /* if(count($groupList)>0){ ?>
						<div style="margin-top:3%;">
							<div style="width:40%; float:left;">						
								<?php
								echo $this->lang->line('txt_Select_Group')." : <br><br>"; 
								echo $this->lang->line('txt_Search')." : "; 
								?>
								<input type="text" id="searchGroup" name="searchGroup" onKeyUp="searchGroups()" size="50"/>						
								<div id="showManGroup" style="height:150px;margin-left:50px; overflow:scroll; margin-bottom:30px; margin-top:20px; width:65%; ">
									<?php if(count($groupList)>0){ ?>			
									<input type="checkbox" name="checkAllGroup" id="checkAllGroup" onclick="checkAllGroups();" />		
									<?php echo $this->lang->line('txt_All');?><br />
						
									<?php } 			
									$i=1;						
									foreach($groupList as $keyVal=>$groupData)
									{						
										$groupAllUsersList	= $this->identity_db_manager->getGroupUsersListByGroupId($groupData['groupId']);							
										?>
										<input type="checkbox" name="groupRecipients[]" id="<?php echo 'groupRecipients_'.$i ; ?>" value="<?php echo $groupData['groupId'];?>" class="clsCheckGroup removeGroup<?php echo $groupData['groupId'];?>"  data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>"  />							
										<?php echo $groupData['groupName'];?><br />							
										<?php
											$i++;
									}		
									?>
								</div>
							</div>
							<!--Select user div end-->
							<div style="float:left; width:60%;">
								<div class="sol-current-selection-groups" style="max-height:250px; overflow-y:scroll;"></div>
							</div>
							<!--Select user label end-->
							<div class="clr"></div>
							</div>
						<?php } */?>			
						<!--Group feature end here-->
						<!--Space and subspace selection start here-->
						<?php if(count($userAllSpaces)>0){ ?>
						<div style="margin-top:1%;">
							<div style="width:50%; float:left;">						
								<?php
								//echo "Send to multiple spaces: "; 
								?>
								<input type="text" id="searchSpaces" name="searchSpaces" onclick="searchUserSpaces()" onkeyup="searchUserSpaces()" size="50" placeholder="Send to multiple spaces..."/>						
								<div id="showManSpaces">
									<?php if(count($userAllSpaces)>0){ ?>			
									<input type="checkbox" name="checkAllSpaces" id="checkAllSpaces" onclick="checkAllUserSpaces();" />		
									<?php echo $this->lang->line('txt_All');?><br />
						
									<?php } 			
									$i=1;						
									foreach($userAllSpaces as $keyVal=>$arrVal)
									{													
										?>
										<input type="checkbox" name="spaceRecipients[]" id="<?php echo 'spaceRecipients_'.$i ; ?>" value="<?php echo $arrVal['workSpaceId'];?>" class="clsCheckSpace removeSpace<?php echo $arrVal['workSpaceId'];?>"  data-myval="<?php echo $arrVal['workSpaceName'];?>"/>							
										<?php echo $arrVal['workSpaceName'];?><br />							
										<?php
											$i++;
									}		
									?>
								</div>
							</div>
							<!--Select user div end-->
							<div id="multipleSpaceRecipientArea">
								<div class="sol-current-selection-spaces"></div>
							</div>
							<!--Select user label end-->
							<div class="clr"></div>
						</div>
						<?php } ?>			
						<!--Space and subspace selection end here-->
						
						<div style="margin-top:1%;">
							<div style="width:50%; float:left;">
						
								<?php
								//echo 'Send to multiple: '." : <br><br>"; 
								//echo $this->lang->line('txt_Search')." : "; 
								//echo "Send to multiple users: "; 
								?>
								<input type="text" id="searchTags" name="searchTags" onKeyUp="showTags()" onclick="showTags()" size="50" placeholder="Send to multiple users..."/>
							
								<div id="showMan">
							
								<?php if(count($workSpaceMembers_search_user)>0){ ?>
				
								<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunctions();" />
				
								<?php echo $this->lang->line('txt_All');?><br />
				
								<?php } ?>
				
								<?php
				
								$i=1;			
				
								foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
								{
										if ($_SESSION['all'])
										{
											if ($workPlaceMemberData['userGroup']>0)
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
											if ($workPlaceMemberData['userGroup']>0)
												$showGuestUser = 1;
											else
												$showGuestUser = 0;
										}	
									if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] && $showGuestUser){						
										?>

										<input type="checkbox" name="recipients[]" id="<?php echo 'recipients_'.$i ; ?>" value="<?php echo $workPlaceMemberData['userId'];?>" class="clsChecks remove<?php echo $workPlaceMemberData['userId'];?>"  data-myval="<?php echo $workPlaceMemberData['tagName'];?>" />

										<?php echo $workPlaceMemberData['tagName'];?><br />

										<?php

												$i++;

									}

								}
						
								?>

							</div>
						</div>
						<!--Select user div end-->
						<div id="multipleRecipientArea">
							<div class="sol-current-selection"></div>
						</div>
						<!--Select user label end-->
						<div class="clr"></div>
						</div>
					</div>	
					<?php	
				}
				
				 ?>
				 <!--Myspace select recepient code end-->
				<input type="checkbox" name="disableInteractions" id="disableInteractions"/>Disable interactions
				<div id="buttons"></div>
				<div class="replyCancelButtons">
					<?php
					if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['public'] == 'public')
					{
					?>
					<input type="button" id="postSubmitButton" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="insertTimeline('publish');" style="float:left; margin-top:-1%;" >		 
					<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="showTimelineEditor();" style="float:left; margin-left:1%;margin-top:-1%;" >				
					<?php 
					}
					else
					{ ?>
					<input type="button" id="postSubmitButton" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="insertTimeline('publish');" style="float:left; margin-top:-1%;" >		 
					<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="showTimelineEditor('close');" style="float:left; margin-left:1%;margin-top:-1%;" >	
					<?php
					}
					?>
				 </div>
				 <input type="button" id="postDraftButton" name="draftButton" value="<?php echo 'Save as draft';?>" onClick="insertTimeline('draft');" style="float:left; margin-left:1%; margin-top:-1%;" >		 
				 <input name="reply" id="reply" type="hidden" value="1">
				 <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
          		 <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				 <input type="hidden" name="publicPost" value="<?php echo $_SESSION['public']; ?>" id="publicPost">
				 <input type="hidden" name="post_type_id" value="<?php echo $post_type_id;?>" id="post_type_id">
				 <input type="hidden" name="post_type_object_id" value="<?php echo $post_type_object_id;?>" id="post_type_object_id">
				 <input type="hidden" name="isForward" value="0" id="isForward">
				 <input type="hidden" name="isDraft" value="0" id="isDraft">
				 <input type="hidden" name="post_id" value="0" id="post_id">
				 <input name="editorname1" id="editorname1" type="hidden"  value="replyDiscussion">
				 <input type="hidden" id="previousLiveFeedClickId" name="previousLiveFeedClickId" value="0" >
				<?php /*?><div class="timelineExpiryDate" style="float:left; padding-left:20px;">
					Expiry Date: <input name="timeline_exp_date" type="text"  id="timeline_exp_date" class="timelineExpDate" value="" readonly>
				 </div><?php */?>
			 </form>
		</div>
	
		<div class="clr"></div>	
		<!--Timeline editor end here-->
			<!--New post and comment message start-->		
			<div id="newPostCommentMessage" style="display:none;">
				<a href="" class="newPostMsg"><span><?php echo $this->lang->line('txt_new_post_found'); ?></span></a>
			</div>	
			<div class="clr"></div>		
			<!--New post and comment message end-->
		
			<!--Timeline post start here-->
			<div id="postArea">
				<?php
				if($workSpaceDetails['workSpaceName']=="Try Teeme" && ($this->uri->segment(8)=='bookmark' || $this->uri->segment(8)=='public' || $this->uri->segment(8)=='all'))
				{
					?><div style="color:red;"><?php echo $this->lang->line('txt_msg_no_access_to_post'); ?></div><?php
				}
				else
				{
					$this->load->view('post/get_timeline_web'); 
				}
				?>
			</div>
		</div>
		<!--Timeline post end here-->
		</div>
		<div class="clr"></div>
	</div>
	
	</div>

	<!--Added by Dashrath- load notification side bar-->
	<?php $this->load->view('common/notification_sidebar.php');?>
	<!--Dashrath- code end-->
	
</div>
<?php $this->load->view('common/foot');?>
<?php //$this->load->view('common/footer');?>
<?php //$this->load->view('common/datepicker_js.php'); ?>
<script>
$(document).ready(function(){
	//alert(location.hash);
	if(location.hash!=''){
		$(location.hash).addClass('nodeBgColorSelect');
	}
	$("#showMan").hide();
	$("#showManSpaces").hide();
	<?php 
		if($_SESSION['active_view']=='space'){?>
			setLeftMenuSideBarCookie(1);
			leftMenuHideShow();
	<?php }
		if (isset($_SESSION['public']))  {?>
			$("#multiSend").hide();	
			document.getElementById("postArea").style.width = '73%';
	<?php } ?>

	$(window).scroll(function(){
      if ($(this).scrollTop() > 60) {
          	$('#postTabUI').addClass('postTabUIFixed');
          	setPostTabBarWidth();
      } else {
      	  removePostTabBarWidth();
          $('#postTabUI').removeClass('postTabUIFixed');
      }
  	});
	

	
	$(".post_web_tab_menu_list li a").click(function(e){
     e.preventDefault();
  	});

  	$(".post_web_tab_menu_list li").click(function(){
		var tabid = $(this).find("a").attr("href");
		$(".post_web_tab_menu_list li,.post_web_tab_menu div.post_web_tab_menu_tab").removeClass("active");   // removing active class from tab

		$(".post_web_tab_menu_tab").hide();   // hiding open tab
			if(tabid=='#divChats')
			{
				$("#post_web_sidebar_loader").show();
				getPostUserStatus();
			}
		$(tabid).show(); // show tab
		$(this).addClass("active"); //  adding active class to clicked tab
		//$("#post_web_sidebar_loader").show();
  });



/*
  $(".post_web_tab_menu_list_2 li a").click(function(e){
     e.preventDefault();
  	});

  	$(".post_web_tab_menu_list_2 li").click(function(){
		//console.log (this);
		var tabid = $(this).find("a").attr("href");
		$(".post_web_tab_menu_list_2 li,.post_web_tab_menu_2 div.post_web_tab_menu_tab_2").removeClass("active");   // removing active class from tab

		$(".post_web_tab_menu_tab_2").hide();   // hiding open tab
		$(tabid).show(); // show tab
		$(this).addClass("active"); //  adding active class to clicked tab
		//$("#post_web_sidebar_loader").show();
  });
  */

  $(".postUserDetailsBox li a").click(function(e){
     e.preventDefault();
  	});

  	$("#divProfileLink").click(function(){
		//console.log (this);
		//var tabid = $(this).find("a").attr("href");
		//$(".post_web_tab_menu_list_2 li,.post_web_tab_menu_2 div.post_web_tab_menu_tab_2").removeClass("active");   // removing active class from tab

		//$(".post_web_tab_menu_tab_2").hide();   // hiding open tab
		//$(tabid).show(); // show tab
		//$(this).addClass("active"); //  adding active class to clicked tab
		//$("#post_web_sidebar_loader").show();
		if($('#divProfile').is(':visible')){
			$("#divProfile").hide();
			$("a#divProfileLink").text('Show Profile');
		}
		else{
			$("#divProfile").show();
			$("a#divProfileLink").text('Hide Profile');
			return false;
		}
		
  });

  //leftMenuHideShow();
  //document.getElementById("leftSideBar").style.display = "none";
  //document.getElementById("rightSideBar").style.width = "100%";

$('ul.drop_menu_new').each(function(){
var obj = document.createElement('select');
obj.style.cssText = 'height:33px';
var list=$(this),
    select=$(obj).insertBefore($(this).hide()).change(function(){
		  window.location.href=$(this).val();	 
	});
	
$('>li a', this).each(function(){
  var option=$(document.createElement('option'))
   .appendTo(select)
   .val(this.href)
   .html($(this).html()); 
  if($(this).attr('class') === 'active '){
	option.attr('selected',true);	
  }
});


list.remove();
});


  	var workSpaceId = '<?php echo $workSpaceId;?>';
	var workSpaceType = '<?php echo $workSpaceType;?>';
	<?php 
		if($workSpaceType==1 && $this->uri->segment(5)=='space' && $workSpaceId==$this->uri->segment(6)){
			$active_view = 'space';
		}
		else{
			$active_view = 'global';
		}
	?>
	var active_view = '<?php echo $active_view;?>';
	if(active_view!='space'){
		document.getElementById("leftSideBar").style.display = "none";
  		document.getElementById("rightSideBar").style.width = "100%";
	}
	else{
		document.getElementById("leftSideBar").style.display = "block";
  		//document.getElementById("rightSideBar").style.width = "100%";
	}
	/*$('.timelineExpDate').datepicker({
			
			minDate:0,

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

	});*/
	var post_type     ='<?php echo $this->uri->segment(5);?>';
	if(post_type=='space_ex')
	{
		document.getElementById('postArea').style.height='calc(100% - 394px)';
	}
	else if(post_type=='public')
	{
		document.getElementById('postArea').style.height='calc(100% - 194px)';
	}
	else if(post_type=='one')
	{
		document.getElementById('postArea').style.height='calc(100% - 214px)';
	}
	else if(post_type=='space')
	{
		if(workSpaceId!=='0')
		{
			document.getElementById('postArea').style.height='calc(100% - 254px)';
		}
	}

});


//Change textarea as editor
//chnage_textarea_to_editor('replyDiscussion','simple');
//showTimelineEditor();
//Insert timeline post content
function insertTimeline(postStatus='publish')
{  
	var error	= '';
	var replyDiscussion = 'replyDiscussion'; 
    var INSTANCE_NAME = $("#replyDiscussion").attr('name');
	var post_type     ='<?php echo $this->uri->segment(5);?>';
	
	var getvalue = getvaluefromEditor('replyDiscussion');
	
	if (getvalue == ''){
		error+='<?php echo $this->lang->line('txt_enter');?>';
	}
	
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		$("#buttons").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		request_refresh_point=0;
	
		//ajax code starts here
       
		var data_user =$("#formTimeline").serialize();
		if(document.getElementById("list"))
		{
			var recipients=document.getElementById("list").value.split(",");
		}
		if(document.getElementById("listGroup"))
		{
			var groupRecipients=document.getElementById("listGroup").value.split(",");
		}
		if(document.getElementById("listSpaces"))
		{
			var spaceRecipients=document.getElementById("listSpaces").value.split(",");
		}
		var is_forward = document.getElementById("isForward").value;
		if(is_forward =="1")
		{
			// alert("is");
			if(recipients=="" && spaceRecipients=="" )
			{
				// alert("Select space or user to forward the post");
				$("#buttons").html("<p style='color:red;'>Select space or user to forward the post</p>");
				return false;
			}
		}
		var is_draft = document.getElementById("isDraft").value;
		var post_id = document.getElementById("post_id").value;
		var post_status = postStatus;
			if($('#disableInteractions').prop('checked')==true){
				var disable_interactions = 1;
			}else{
				var disable_interactions = 0;
			}
		//alert(disable_interactions); return false;
		//alert (recipients); return false;
		//data_user = data_user+'&replyDiscussion='+encodeURIComponent(getvalue)+'&recipients='+recipients+'&groupRecipients='+groupRecipients; 
		data_user = data_user+'&replyDiscussion='+encodeURIComponent(getvalue)+'&recipients='+recipients+'&groupRecipients='+groupRecipients+'&spaceRecipients='+spaceRecipients+'&is_forward='+is_forward+'&post_status='+post_status+'&is_draft='+is_draft+'&post_id='+post_id+'&disable_interactions='+disable_interactions+'&post_type='+post_type; 
		//var pnodeId=$("#pnodeId").val();
		var request = $.ajax({
			  url: baseUrl+"post/insert_timeline_web/",
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result)
			  {
			  	  //$("#buttons").html("");
				 if(result!='' && result!='0')
				 {
					// $('#TimelinePost').html(result);
					$('#postArea').html(result);
					//$("#showMan").hide();
					//$("#showManSpaces").hide();
					
					 if($('#TimelineEditor').is(':visible'))
					 {
						$("#TimelineEditor").hide();
						$("#searchTags").val("");
						$(".fr-element").html("");
						$("#buttons").html("");
						document.getElementById('formTimeline').reset();
						$('#checkAll').prop("checked",false);
						$('#checkAllSpaces').prop("checked",false);
						$('.clsChecks').prop("checked",false);
						$('.clsCheckSpace').prop("checked",false);
						$('.sol-current-selection').html('');
						//$('.sol-current-selection-groups').html('');
						$('.sol-current-selection-spaces').html('');


						$("#showMan").hide();
						$("#showManSpaces").hide();
						$("#multipleRecipientArea").hide();
						$("#multipleSpaceRecipientArea").hide();
						$("#list").val('');
						$("#listSpaces").val('');
						$("#listSubSpaces").val('');
						$('#isForward').prop("value", "0");
						$('#isDraft').prop("value", "0");
						$('#post_id').prop("value", "0");
						$('#post_type_id').prop("value", "<?php echo $post_type_id;?>");
						$('#post_type_object_id').prop("value", "<?php echo $post_type_object_id;?>");
					 }
					 closeNewPostWindow();

					/** Added by Shikhar : this function call 'get_dropdown_post_count();' is for getting the post count */ 
					// this if case checks for the #dropCount exists or not.This #dropCount not visible on internal nad external post interface 
					 if($('#dropCount').length)
						{
							get_dropdown_post_count();
						}
					//alert ('Here');
					return true;
				 }
				  /*if(result=='0'){
				  	jAlert('No Post Found');return;
				  }
				  
				  var error	= '';
				  window.location.reload();*/
				  /*$("#TimelinePost").html(result);
				  $("#buttons").html("");
				  $(".fr-element").html("");
				  if($('#TimelineEditor').is(':visible'))
				  {
					$("#TimelineEditor").hide();
				  }*/
				 
				}
			});
	
	}
	else
	{
		jAlert(error);
	}	
}

function get_dropdown_post_count()
{
	var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
		var post_type     ='<?php echo $this->uri->segment(5);?>';
		var post_type_object_id='<?php echo $this->uri->segment(6);?>';
	
    $.ajax({
			  url: baseUrl+"post/get_dropdown_post_count/",
			  type: "POST",
			  data:{workSpaceId:workSpaceId,workSpaceType:workSpaceType,post_type_object_id:post_type_object_id,post_type:post_type},
			  dataType: "html",
              success:function(result)
              {
                if(result!='' && result!='0')
				 {
                     $("#dropCount").html(result);
                 }
              }
            });
}

function insertTimelineComment(nodeId)
{	
	//alert(nodeId);
	if(document.getElementById("totalTimelineCommentNodes"+nodeId))
	{
		realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
	}
	//console.log(realTimeTimelineDivIds);
	//$("#totalTimelineCommentNodes"+nodeId).remove();
	//return false;
	chatReplyNodeId = nodeId;
	var error	= ''
	//var editorname1 =$("#editorname1").val();	
	//var nodeId =$("#nodeId").val();	
	var replyDiscussion = 'replyTimelineComment'+nodeId;
	var INSTANCE_NAME = $("#replyTimelineComment"+nodeId).attr('name');
	var getvalue	= getvaluefromEditor(INSTANCE_NAME);
	//alert(getvalue+'/'+INSTANCE_NAME);
	//return false;
	//var getvalue=$('#timelineDivNodeId'+nodeId).find( ".fr-element" ).html();
	
	
	if (getvalue == ''){
		jAlert("<?php echo $this->lang->line('txt_enter');?>","Alert");
		return false;
	}
	//document.getElementById('editorLeafContents'+nodeId+'1sp').innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";


	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		document.getElementById('editStatus').value == 0;
		request_refresh_point=0;
		//ajax code starts here
        //treeId=$('#treeId').val();
		treeId='0';
		var data_user =$("#form"+nodeId).serialize();
		data_user = data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue); 
		
		//var pnodeId=$("#pnodeId").val();
			  var request = $.ajax({
			  url: baseUrl+"post/insert_timeline_comment/"+treeId+"/1/"+nodeId+'?realTimeTimelineDivIds='+realTimeTimelineDivIds,
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result){
			    //alert('testing'+result);
				//return false;
			    //$("#TimelinePost").html(result);
				//$(".talkTreeComments"+nodeId).html(result);
				$("#totalTimelineCommentNodes"+nodeId).remove();
				$(".timeline_comments_box"+nodeId).append(result);				
				$("#buttons").html("");
				$(".fr-element").html("");
				$('.focusText').focus();
				/*$('.timelineExpDate').datepicker({
			
							minDate:0,
				
							timeFormat: "HH:mm",
				
							dateFormat: "dd-mm-yy"
				
				});*/
			  // editorClose(INSTANCE_NAME);
			  // $("#data_container").html(result);
			}
			});
	}
	else
	{
		jAlert(error);
	}	
}
//Insert post comment start

function insertPostComment(nodeId,mainPostNodeId=0,is_nested=0)
{	
	
	//alert(mainPostNodeId);
	//alert(document.getElementById('reply').value);
	//return false;

	if(document.getElementById("totalTimelineCommentNodes"+nodeId))
	{
		realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
	}
	//console.log('realTimeTimelineDivIds= '+realTimeTimelineDivIds);
	chatReplyNodeId = nodeId;
	var error	= ''

	var replyDiscussion = 'replyTimelineComment'+nodeId;
	var INSTANCE_NAME = $("#replyTimelineComment"+nodeId).attr('name');	

	var getvalue	= getvaluefromEditor(INSTANCE_NAME);
	var postType = '<?php echo $this->uri->segment(5)?>';
	if(postType=='one'){
		postTypeId = 1;
	}
	else if(postType=='space'){
		postTypeId = 2;
	}
	else if(postType=='subspace'){
		postTypeId = 3;
	}
	else if(postType=='drafts'){
		postTypeId = 10;
	}
	else if(postType=='bookmark'){
		postTypeId = 6;
	}
	else if(postType=='space_ex')
	{
		postTypeId = 9;
	}
	var postTypeObjectId = '<?php echo $this->uri->segment(6)?>';
	//console.log('postTypeId= '+postTypeId);
	//console.log('postTypeObjectId= '+postTypeObjectId);
	
	if (getvalue == ''){
		jAlert("<?php echo $this->lang->line('txt_enter');?>","Alert");
		return false;
	}
	//alert(getvalue);
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		$('#commentLoader'+nodeId).html("<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
	
		document.getElementById('editStatus').value = 0;
		request_refresh_point=0;
		
		treeId='0';
			if(is_nested==1){
				var data_user =$("#form"+mainPostNodeId).serialize();
			}
			else{
				var data_user =$("#form"+nodeId).serialize();
			}
		
		data_user = data_user+'&post_type_id='+postTypeId+'&post_type_object_id='+postTypeObjectId+'&is_nested='+is_nested+'&mainPostNodeId='+mainPostNodeId;
		data_user = data_user+'&replyDiscussion='+encodeURIComponent(getvalue); 
		//alert('data user= '+data_user);
		
		//var pnodeId=$("#pnodeId").val();
		//url: baseUrl+"post/insert_timeline_comment/"+treeId+"/1/"+nodeId+'?realTimeTimelineDivIds='+realTimeTimelineDivIds,
			  var request = $.ajax({
			  url: baseUrl+"post/insert_timeline_comment_web/"+treeId+"/1/"+nodeId+'?realTimeTimelineDivIds='+realTimeTimelineDivIds,
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result){
			  // console.log('result= '+result);
				//return false;
				if(is_nested==0){
					$("#totalTimelineCommentNodes"+nodeId).remove();
					$("#commentRefreshDiv"+nodeId).append(result);		
					//$("#commentRefreshDiv"+nodeId).html(result);				
					$('.CommentTextBox'+nodeId+' .fr-element').html("");
					//$('.CommentTextBox'+nodeId+' .fr-element').focus();
					$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
					$('#commentLoader'+nodeId).html("");
					//$('.focusText').focus();
					
					//Added by Dashrath- for add comment image -->
					$("#commentButtonPost"+nodeId).css("display", "block");
					$("#CommentTextBox"+nodeId).css("display", "none");
				}
				else{
					$("#totalTimelineCommentNodes"+nodeId).remove();
					//$("#nestedCommentsSection"+nodeId).append(result);	
					$("#nestedCommentsSection"+nodeId).html(result);					
					$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
					$('#commentLoader'+nodeId).html("");
					$('#nestedCommentTextBox'+nodeId+' .fr-element').html("");
					$("#nestedCommentTextBox"+nodeId).css("display", "none");
					$("#nestedCommentLeafSpan"+nodeId).css("display", "block");
				}
				
			}
			});
	}
	else
	{
		jAlert(error);
	}	
}

//Insert post comment end

function showAllTimelineComments(nodeId)
{
	if($('.showAllLink'+nodeId).hasClass('hideAllLink'+nodeId))
	{
		//alert('hide');
		$('#moreComments'+nodeId).hide();
		$('.showAllLink'+nodeId).html('<?php echo $this->lang->line('view_more_comment_txt'); ?>');
		$('.showAllLink'+nodeId).removeClass('hideAllLink'+nodeId);
	}
	else
	{
		//alert('show');
		$('#moreComments'+nodeId).show();
		$('.showAllLink'+nodeId).html('<?php echo $this->lang->line('less_comment_txt'); ?>');
		$('.showAllLink'+nodeId).addClass('hideAllLink'+nodeId);
	}
}
function showCommentEditor(nodeId)
{
	$('.CommentTextBox'+nodeId).show();
	chnage_textarea_to_editor('replyTimelineComment'+nodeId,'comment');
}

function removeSearh()

{

	if(document.getElementById('search').value=='Search')

	document.getElementById('search').value='';

}

function writeSearh()

{

	/*if(document.getElementById('search').value=='')

		document.getElementById('search').value='Search';*/

}

function showTimelineEditor(data='',post_type_id=0)
{
	if(data=='close')
	{
		if($('#TimelineEditor').is(':visible'))
		{
		$("#TimelineEditor").hide();
		$("#searchTags").val("");
		showTags();
		$(".fr-element").html("");
		document.getElementById('formTimeline').reset();
		$('#checkAll').prop("checked",false);
		$('#checkAllSpaces').prop("checked",false);
		$('.clsChecks').prop("checked",false);
		$('.clsCheckSpace').prop("checked",false);
		$('.sol-current-selection').html('');
		$('.sol-current-selection-spaces').html('');
		$("#showMan").hide();
		$("#showManSpaces").hide();
		$("#multipleRecipientArea").hide();
		$("#multipleSpaceRecipientArea").hide();
		$("#list").val('');
		$("#listSpaces").val('');
		$("#listSubSpaces").val('');
		$('#isForward').prop("value", "0");
		$('#isDraft').prop("value", "0");
		$('#post_id').prop("value", "0");
		$('#post_type_id').prop("value", "<?php echo $post_type_id;?>");
		$('#post_type_object_id').prop("value", "<?php echo $post_type_object_id;?>");
		$("#buttons").html("");
		closeNewPostWindow();
		}
		else
		{
			
			$("#searchTags").val("");
		showTags();
		$(".fr-element").html("");
		document.getElementById('formTimeline').reset();
		$('#checkAll').prop("checked",false);
		$('#checkAllSpaces').prop("checked",false);
		$('.clsChecks').prop("checked",false);
		$('.clsCheckSpace').prop("checked",false);
		$('.sol-current-selection').html('');
		$('.sol-current-selection-spaces').html('');
		$("#showMan").hide();
		$("#showManSpaces").hide();
		$("#multipleRecipientArea").hide();
		$("#multipleSpaceRecipientArea").hide();
		$("#list").val('');
		$("#listSpaces").val('');
		$("#listSubSpaces").val('');
		$('#isForward').prop("value", "0");
		$('#isDraft').prop("value", "0");
		$('#post_id').prop("value", "0");
		$('#post_type_id').prop("value", "<?php echo $post_type_id;?>");
		$('#post_type_object_id').prop("value", "<?php echo $post_type_object_id;?>");
		$("#buttons").html("");
		closeNewPostWindow();
		$(".post_chat_size").html('<b>_ </b>&nbsp;&nbsp;');
			$(".post_content").show();
		}
	}
	else
	{
		$("#newPostCommentMessage").hide();	
		$("#TimelineEditor").show();
		$("#showMan").hide();
		$("#showManSpaces").hide();
		$("#list").val('');
		$("#listSpaces").val('');
		$("#listSubSpaces").val('');
		//$("#listGroups").val('');

		chnage_textarea_to_editor('replyDiscussion');

		if(data!=''){
			setValueIntoEditor('replyDiscussion',data);
			if(post_type_id!=7){
				$("#multiSend").show();
			}else{
				$("#multiSend").hide();
			}		
		}
		else{
			$("#postFormHeader").html('<b>New post</b><br><br>');	
			$('#postSubmitButton').prop("value", "Post");
			$(".shortTitle").html('<b>New post</b>');
			$("#replyDiscussion").froalaEditor('edit.on');
			$("#replyDiscussion").froalaEditor('toolbar.show');
			$('#isForward').prop("value", "0");
			$('#isDraft').prop("value", "0");
			$('#post_id').prop("value", "0");
			setValueIntoEditor('replyDiscussion','');
			<?php if($_SESSION['active_view']=='space'){?>
				$("#multiSend").hide();
			<?php } ?>
		}
		//alert('Here');return false;
		openNewPostWindow();
		$("#myBtn").hide();
	}
	
	
}

function forwardPost(post_id){
	//console.log('data= '+data);	
	//alert(document.getElementById('post_content'+post_id).value);
	//return false;
	var data = document.getElementById('post_content'+post_id).value;
	showTimelineEditor(atob(data));
	$("#replyDiscussion").froalaEditor('edit.off');
	$("#replyDiscussion").froalaEditor('toolbar.hide');
	$("#postFormHeader").html('<b>Forward post</b>');	
	$(".shortTitle").html('<b>Forward post</b><br><br>');	
	$('#postSubmitButton').prop("value", "Forward");
	$('#isForward').prop("value", "1");//Yes it's a forward
	$('#post_type_id').prop("value", "5");//Global post
	$('#post_type_object_id').prop("value", "");//Global post
}
//check all function start

function editDraft(post_type_id,post_type_object_id,post_id=0,interactions=0){
	//console.log('data= '+data);	
	//console.log ('post type id= ' + post_type_id);
	//console.log ('post type object id= ' + post_type_object_id);
	//alert(interactions);
	//return false;
	var data = document.getElementById('post_content'+post_id).value;
	showTimelineEditor(data,post_type_id);
	$("#postFormHeader").html('<b>Edit draft</b>');	
	$(".shortTitle").html('<b>Edit draft</b><br><br>');	
	$('#postSubmitButton').prop("value", "Post");
	$('#isForward').prop("value", "0");//No it's not a forward
	$('#isDraft').prop("value", "1");//Yes it's a draft
	$('#post_id').prop("value", post_id);//Set post id if it's a draft 
	$('#post_type_id').prop("value", post_type_id);
	$('#post_type_object_id').prop("value", post_type_object_id);
		if (interactions==1){
			$('#disableInteractions').prop('checked',true);
		}else{
			$('#disableInteractions').prop('checked',false);
		}

	// Get saved participant list (members and spaces) if not a public draft
	if (post_type_id!=7){
		var data_user = 'post_id='+post_id;
		var request = $.ajax({
			url: baseUrl+"post/get_post_participants/",
			type: "POST",
			data: data_user,
			dataType: "html",
			  	success:function(result){
					var obj = JSON.parse(result);
					//console.log(obj);
					//console.log('members= '+ obj.members);
					//console.log('spaces= '+ obj.spaces);
					if (obj.memberCount>0){
						checkMembers(obj.members);
					}
					if (obj.spaceCount>0){
						checkSpaces(obj.spaces);
					}
				}
		});
	}
}

function deleteDraft(post_type_id,post_type_object_id,post_id){
	var r=confirm("Do you really want to discard this draft?");
	if (r==true){
		var data_user = 'post_id='+post_id;
		var request = $.ajax({
			url: baseUrl+"post/delete_draft/",
			type: "POST",
			data: data_user,
			dataType: "html",
			  	success:function(result){
					$("#form"+post_id).hide();
					get_dropdown_post_count();
				}
		});
	}
}

function checkMembers(members){
	$("#multipleRecipientArea").show();
	var htmlContent='';
		$("#showMan").show();
			$(".clsChecks").each(function(){			
				if (jQuery.inArray($(this).val(), members)!='-1'){
					//$('.clsChecks').prop("checked",true);
					$(this).prop('checked',true);
					value = $("#list").val();
					val1 = value.split(",");	
					if(val1.indexOf($(this).val())==-1){
						$("#list").val(value+","+$(this).val());
					}
					//Show checked label at top
						var data = $(this).data('myval');
						var value = $(this).val();
						htmlContent += '<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
					//Code end
				}
			});			
			$('.sol-current-selection').html(htmlContent);
}

function checkSpaces(spaces){
	$("#multipleSpaceRecipientArea").show();
	var htmlContent='';	
	$("#showManSpaces").show();
		$(".clsCheckSpace").each(function(){
			if (jQuery.inArray($(this).val(), spaces)!='-1'){
				//$('.clsCheckSpace').prop("checked",true);
				$(this).prop('checked',true);
				value = $("#listSpaces").val();
				val1 = value.split(",");	
				if(val1.indexOf($(this).val())==-1){
					$("#listSpaces").val(value+","+$(this).val());
				}
				//Show checked label at top
					var data = $(this).data('myval');
					//var usersData = $(this).data('myusers');
					var value = $(this).val();
					htmlContent += '<div class="sol-head sol-selected-display-item sol_check_space'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemSpace('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
					
					//htmlContent += '<div class="sol-selected-display-item sol_check_space'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>';
				//Code end
			}
		});		
	$('.sol-current-selection-spaces').html(htmlContent);
}
//check all function start

function checkAllFunction(nodeId){
	

		if($("#checkAll"+nodeId).prop("checked")==true){

			$('.clsCheck'+nodeId).prop("checked",true);

			$(".clsCheck"+nodeId).each(function(){

				value = $("#list"+nodeId).val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list"+nodeId).val(value+","+$(this).val());

				}

			});

		}

		else{

			//change prop to attr for server - Monika

			$('.clsCheck'+nodeId).prop("checked",false);

			$(".clsCheck"+nodeId).each(function(){

				value = $("#list"+nodeId).val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",");

				$("#list"+nodeId).val(arr);

			});

		}

	}

//Check all function end

//My space search recepients start

function showMySpaceTags(nodeId,originatorUserId,currentUserId)
{
	//alert(originatorUserId+'======='+currentUserId);
	
	
   	var toMatch = document.getElementById('searchTags'+nodeId).value;
	
	if(originatorUserId != currentUserId)
	{
		var val = '<input disabled="disabled" type="checkbox" name="checkAll" id="checkAll'+nodeId+'" onclick="checkAllFunction('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}
	else
	{
		var val = '<input type="checkbox" name="checkAll" id="checkAll'+nodeId+'" onclick="checkAllFunction('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}

	//if (toMatch!='')

	if(1)

	{

		var count = '';

		var sectionChecked = '';

		<?php

		$i=1;

		foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
		{
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
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
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
			if($workPlaceMemberData['userId']!=$_SESSION['userId'] && $workPlaceMemberData['userId']!=$this->uri->segment(3) && $showGuestUser){?>

				var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

				

				var pattern = new RegExp('\^'+toMatch, 'gi');

				

				if (str.match(pattern))

				{
					if(originatorUserId != currentUserId)
					{
						val +=  '<input disabled="disabled" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients'+nodeId+'[]" value="<?php echo $workPlaceMemberData['userId'];?>" onclick="getRecepientName(this,'+nodeId+')" /><?php echo $workPlaceMemberData['tagName'];?><br>';
					}
					else
					{
						val +=  '<input class="clsCheck'+nodeId+'" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients'+nodeId+'[]" value="<?php echo $workPlaceMemberData['userId'];?>" onclick="getRecepientName(this,'+nodeId+')" /><?php echo $workPlaceMemberData['tagName'];?><br>';
					}
					
				}

				<?php

				$i++;	

			}

		

			?>
			<?php

		}?>

		document.getElementById('showMan'+nodeId).innerHTML = val;

		document.getElementById('showMan'+nodeId).style.display = 'block';

		var list = $("#list"+nodeId).val();

		var val1 = list.split(",");

		

		$(".clsCheck"+nodeId).each(function(){

			 if(val1.indexOf($(this).val())!=-1){

				$(this).attr("checked",true);

			 }

		});

	}

	else

	{

		document.getElementById('showMan'+nodeId).style.display = 'none';

	}



}

//Search multiple recipients
function showTags()
{
	if(document.getElementById('searchTags') !== null)
	{
		var toMatch = document.getElementById('searchTags').value;
		var val = '';
		val += '<div class="dashboard_fee_right_title">Users</div>';
		val += '<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunctions();" /><?php echo $this->lang->line('txt_All');?><br />';
		//if (toMatch!='')
		//if(1){
			var count = '';
			var sectionChecked = '';
			var gotMatch=0;
			<?php
			$i=1;
			foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
			{
				if ($_SESSION['all']){
					if ($workPlaceMemberData['userGroup']>0) $showGuestUser = 1;
					else $showGuestUser = 0;
				}
				else if ($workSpaceId>0) {
					$showGuestUser = 1;
				}
				else {
					if ($workPlaceMemberData['userGroup']>0) $showGuestUser = 1;
						else $showGuestUser = 0;
				}	
				if($workPlaceMemberData['userId']!=$_SESSION['userId'] && $workPlaceMemberData['userId']!=$this->uri->segment(3) && $showGuestUser){?>
					var str = '<?php echo $workPlaceMemberData['tagName']; ?>';
					var pattern = new RegExp('\^'+toMatch, 'gi');
					if (str.match(pattern)) {
						val +=  '<input class="clsChecks remove<?php echo $workPlaceMemberData['userId'];?>" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients[]" value="<?php echo $workPlaceMemberData['userId'];?>"  data-myval="<?php echo $workPlaceMemberData['tagName'];?>" /><?php echo $workPlaceMemberData['tagName'];?><br>';
						gotMatch=1;
					}
					<?php
					$i++;	
				}
				?>
				<?php
			}?>
			if(gotMatch==0)
			{
				val ='<div class="dashboard_fee_right_title">No Users found</div>';
			}
			document.getElementById('showMan').innerHTML = val;
			document.getElementById('showMan').style.display = 'block';

			var list = $("#list").val();
			var val1 = list.split(",");

			$(".clsChecks").each(function(){

				if(val1.indexOf($(this).val())!=-1){

					$(this).attr("checked",true);

				}

			});
		//}
		/*
		else
		{
			document.getElementById('showMan').style.display = 'none';
		}
		*/
	}
}


//My space search recepients end

function showSearchUser()
{

	var toMatch = document.getElementById('search').value;
	
	/*
	$(".post_web_tab_menu_list li,.post_web_tab_menu div.post_web_tab_menu_tab").removeClass("active");   // removing active class from current active tab
	$(".post_web_tab_menu_tab").hide();   // hiding open tabs
	$("#divSearchUser").show(); // show tab
	$("li:has(a[href='#divSearchUser']):first()").addClass("active"); // add active class to users tab
	*/

	var post_type = '<?php echo $this->uri->segment(5);?>';
	var post_type_object_id = '<?php echo $this->uri->segment(6);?>';

	if (workSpaceType==1 && post_type=='space' && workSpaceId==post_type_object_id){
		var active_view = 'space';
	}
	else{
		var active_view = 'global';
	}
	if (toMatch!=''){
		$.ajax({
		type: "POST",
		url: baseUrl+"post/getPostUserStatusWeb/"+workSpaceId+"/type/"+workSpaceType+"/search/"+active_view,
		data: 'search='+toMatch,
		dataType: 'html',
		success:  function(data){
			//$('#divSearchUser').html(data);
			var res = data.split("|@#$%^&|");
			$("#post_web_sidebar_loader").hide();
			//$('#divChats').html(res[1]);		
			/*$('#divSearchUser').html(res[0]);*/
			//console.log('results= '+res[2]);

            $('#divChats').hide();
			$('.post_web_tab_menu').hide();
			$('#divSearchResult').html('<b>Search results</b><br>'+res[2]);
		}
		});
	}
	else{
		$('#divChats').show();
		$('.post_web_tab_menu').show();
		$('#divSearchResult').html('');
	}

}
	
//On single checkbox click myspace start

//$('.clsCheck').live("click",function()
$(document).on('click', '.clsCheck', function(){

		val = $("#list"+nodeId).val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#list"+nodeId).val()==''){

				$("#list"+nodeId).val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){

					$("#list"+nodeId).val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list"+nodeId).val(arr);

		}

	});
	
function getRecepientName(checkid,nodeId)
{
		val = $("#list"+nodeId).val();

		val1 = val.split(",");	

		if($(checkid).prop("checked")==true){

			if($("#list"+nodeId).val()==''){

				$("#list"+nodeId).val($(checkid).val());

			}

			else{

				if(val1.indexOf($(checkid).val())==-1){

					$("#list"+nodeId).val(val+","+$(checkid).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(checkid).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list"+nodeId).val(arr);

		}
}
setTimeout("findNewPostComment()", 10000);
//On single checkbox click myspace end	

function selectPostType(postType,workSpaceId,workSpaceType)
{
	var postSpaceType=postType.value;
	
	//alert(postSpaceType);
	
	var url;
	
	if(postSpaceType=="space")
	{
		url = baseUrl+'post/web/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId+'/'+workSpaceType;
	}
	else if(postSpaceType=="all")
	{
		url = baseUrl+'post/web/'+workSpaceId+'/type/'+workSpaceType+'/0/1/all';
	}
	else if(postSpaceType=="public")
	{
		url = baseUrl+'post/web/'+workSpaceId+'/type/'+workSpaceType+'/0/1/public';
	}
	else if(postSpaceType=="bookmark")
	{
		url = baseUrl+'post/web/'+workSpaceId+'/type/'+workSpaceType+'/0/1/bookmark';
	}
	
	//alert(postSpaceType+'==='+url);
	
	window.location = url;

}

//Manoj: code end

//Manoj: code for check new post/comments for update

/*setInterval(function () {
	postCommentUpdate()		
}, 5000);*/

setTimeout("postCommentUpdate()", 10000);

function postCommentUpdate()
{
	if(document.getElementById("totalNodes"))
	{
		var realTimePostIds=document.getElementById('totalNodes').value;
	}
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
	//var postType = '<?php echo $this->uri->segment(8)?>';
	var postType = '<?php echo $this->uri->segment(5)?>';
	if(postType=='one'){
		postTypeId = 1;
	}
	else if(postType=='space'){
		postTypeId = 2;
	}
	else if(postType=='subspace'){
		postTypeId = 3;
	}
	else if(postType=='group'){
		postTypeId = 4;
	}
	else if(postType=='home'){
		postTypeId = 5;
	}
	else if(postType=='bookmark'){
		postTypeId = 6;
	}
	else if(postType=='space_ex')
	{
		postTypeId = 9;
	}
	var postTypeObjectId = '<?php echo $this->uri->segment(6)?>';
	
	$.ajax({
		type: "POST",
		//url: baseUrl+"post/getNewPostCommentWeb/"+workSpaceId+"/type/"+workSpaceType+"/"+postType,
		url: baseUrl+"post/getNewPostCommentWeb/"+workSpaceId+"/"+workSpaceType+"/"+postTypeId+"/"+postTypeObjectId,
		data: jQuery("#totalPostNodes").serialize(),
		dataType: 'json',
		cache: false,
		success:  function(data){
		  if(data!=null && data!=undefined)
		  {
			  $.each(data, function(i, node) {
				 // console.log('Before postCommentRefresh');
					postCommentRefresh(node,postTypeId,postTypeObjectId);
			  });
			  //$('#treeTitle').val('');
		  }
		  setTimeout("postCommentUpdate()", 10000);
		}
	});
}

function findNewPostComment()
{
	if(document.getElementById("totalNodes"))
	{
		var realTimePostIds=document.getElementById('totalNodes').value;
	}
	//alert (realTimePostIds);
	//console.log('First= '+realTimePostIds);
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
	var postType = '<?php echo $this->uri->segment(5)?>';
	if(postType=='one'){
		postTypeId = 1;
	}
	else if(postType=='space'){
		postTypeId = 2;
	}
	else if(postType=='subspace'){
		postTypeId = 3;
	}
	else if(postType=='group'){
		postTypeId = 4;
	}
	else if(postType=='home'){
		postTypeId = 5;
	}	
	else if(postType=='drafts'){
		postTypeId = 10;
	}
	else if(postType=='bookmark'){
		postTypeId = 6;
	}
	else if(postType=='space_ex')
	{
		postTypeId = 9;
	}	
	//var userPostSearch = '<?php echo $this->uri->segment(10)?>';
	var postTypeObjectId = '<?php echo $this->uri->segment(6)?>';
	//console.log('Post type id= '+postTypeId);
	//console.log('Post type object id= '+postTypeObjectId);
	/*if(userPostSearch=='') {*/
		$.ajax({
			type: "POST",
			//url: baseUrl+"post/findNewPostCommentWeb/"+workSpaceId+"/"+workSpaceType+"/"+postType+"/"+userPostSearch,
			url: baseUrl+"post/findNewPostCommentWeb/"+workSpaceId+"/"+workSpaceType+"/"+postTypeId+"/"+postTypeObjectId,
			data: jQuery("#totalPostNodes").serialize(),
			dataType: 'json',
			cache: false,
			success:  function(data){
			//console.log('Second= '+data);
			 //if($('#TimelineEditor').is(':hidden'))
			// {
				 //console.log('data= '+data);
				 if(data!=0)
				 {
					$("#newPostCommentMessage").show();	
					/*			
					$.each(data, function(i, node) {
						//alert(node);
						//console.log('index= '+i+' Nodecomment= '+node);
						$('#form'+node).css({'background':'#eee'});
						$('#form'+node+' .discussionComments').css({'background-color':'#eee'});
					});
					*/
					//console.log('count what= '+data['countIncrease']);
					if(data['countIncrease']=='posts'){
						$('.newPostMsg').html('<span>New posts are available</span>');
					}else if(data['countIncrease']=='comments'){
						$('.newPostMsg').html('<span>New comments are available</span>');
					}else if(data['countIncrease']=='tags'){
						$('.newPostMsg').html('<span>New tags are available</span>');
					}else if(data['countIncrease']=='links'){
						$('.newPostMsg').html('<span>New links are available</span>');
					}else if(data['countIncrease']=='tags-links'){
						$('.newPostMsg').html('<span>New tags and links are available</span>');
					}else if(data['countIncrease']=='comments-tags'){
						$('.newPostMsg').html('<span>New comments and tags are available</span>');
					}else if(data['countIncrease']=='comments-links'){
						$('.newPostMsg').html('<span>New comments and links are available</span>');
					}else if(data['countIncrease']=='posts-tags'){
						$('.newPostMsg').html('<span>New posts and tags are available</span>');
					}else if(data['countIncrease']=='posts-links'){
						$('.newPostMsg').html('<span>New posts and links are available</span>');
					}else if(data['countIncrease']=='posts-comments'){
						$('.newPostMsg').html('<span>New posts and comments are available</span>');
					}else if(data['countIncrease']=='posts-comments-links'){
						$('.newPostMsg').html('<span>New posts, comments and links are available</span>');
					}else if(data['countIncrease']=='posts-comments-tags'){
						$('.newPostMsg').html('<span>New posts, comments and tags are available</span>');
					}else if(data['countIncrease']=='posts-links-tags'){
						$('.newPostMsg').html('<span>New posts, links and tags are available</span>');
					}else if(data['countIncrease']=='comments-links-tags'){
						$('.newPostMsg').html('<span>New comments, links and tags are available</span>');
					}else if(data['countIncrease']=='all'){
						$('.newPostMsg').html('<span>New posts, comments, links and tags are available</span>');
					}
					//console.log('nodes= '+data['nodes']);
					$.each(data['nodes'], function(i, node) {
						//alert(node);
						//console.log('index= '+i+' Nodecomment= '+arrComments);
						//console.log('Count_status= '+val);
							//console.log('Node= ' +node);
							$('#form'+node).css({'background':'#eee'});
							$('#form'+node+' .discussionComments').css({'background-color':'#eee'});

					});
					//$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
				  }
			 // }
			  //$('#treeTitle').val('');
			  //Changed by Dashrath - change time 50000 to 10000
			  setTimeout("findNewPostComment()", 10000);
			}
		});
	/*}*/
}

//Manoj: Post comment refresh start
var http2 = getHTTPObjectm();

function postCommentRefresh(nodeId,postTypeId,postTypeObjectId){
		//console.log('here');
		//console.log('posttypeid= '+postTypeId+'posttypeobjectid= '+postTypeObjectId);
		
		var realTimeTimelineDivIds;
		
		var treeId='0';
		
		var workSpaceId = '<?php echo $workSpaceId;?>';
		var workSpaceType = '<?php echo $workSpaceType;?>';
		
		if(document.getElementById("totalTimelineCommentNodes"+nodeId))
		{
			realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
		}
		
		var request = $.ajax({
			//url: baseUrl+"post/getRealTimePostCommentWeb/"+treeId+"/1/"+nodeId+"/"+workSpaceId+"/"+workSpaceType+"?realTimeTimelineDivIds="+realTimeTimelineDivIds,
			url: baseUrl+"post/getRealTimePostCommentWeb/"+treeId+"/1/"+nodeId+"/"+workSpaceId+"/"+workSpaceType+"/"+postTypeId+"/"+postTypeObjectId+"?realTimeTimelineDivIds="+realTimeTimelineDivIds,
			  type: "POST",
			  dataType: "html",
			  success:function(result){
			   //console.log('Result= ' +result);
			    $("#totalTimelineCommentNodes"+nodeId).remove();
				//$("#commentRefreshDiv"+nodeId).prepend(result);
				$("#commentRefreshDiv"+nodeId).append(result);		
			}
		});
		
}
function handleHttpResponsem2(nodeId) 
{    
	//alert(nodeId+'======');
	if(http2.readyState == 4 || http2.readyState == 0) { 
		if(http2.status==200) { 
				var results=http2.responseText;
				//alert(results);
				//$("#totalTimelineCommentNodes<?php //echo $nodeId; ?>").remove();
				//$(".timeline_comments_box<?php //echo $nodeId; ?>").append(results);
				//alert(nodeId);
				$("#totalTimelineCommentNodes"+nodeId).remove();
				$("#commentRefreshDiv"+nodeId).append(result);					
		}
		
	}
}

//Manoj: Post comment refresh end

//Manoj: code start for bookmark posts

function add_bookmark(nodeId,$bookmarkStatus)
{
	//alert(nodeId);
	//return false;
	
	/*var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(ismobile==true || istablet==true)
	{*/
		if($bookmarkStatus=='unbookmark')
		{
			/*msg= '<?php //echo $this->lang->line('txt_confirm_unbookmark'); ?>';
	
			var agree = confirm(msg);
		
			if (agree)
		
			{*/
		
				$.ajax({
				type: "POST",
				url: baseUrl+"post/add_bookmark/"+nodeId,
				cache: false,
				success:  function(result){
				  //alert(nodeId);
				  if(result==1)
				  {
					if($bookmarkStatus=='unbookmark')
					{
						$('.bookmarkBtn'+nodeId).html('<a class="bookmark" onclick="add_bookmark('+nodeId+',\'bookmark\')"><img style="cursor:pointer;height:18px;border:0px;"  src="<?php echo base_url();?>images/bookmark.png"><?php //echo $this->lang->line('txt_object_follow'); ?></a>');
						get_dropdown_post_count();
					}
				  }
				}
				});
		   /*}
		   else
		   {
				return false ;
		   }*/
		  }
		  else
		  {
		  	/*msg= '<?php echo $this->lang->line('txt_confirm_bookmark'); ?>';
			var agree = confirm(msg);
			if (agree)
			{*/
				$.ajax({
					type: "POST",
					url: baseUrl+"post/add_bookmark/"+nodeId,
					cache: false,
					success:  function(result){
					  //alert(nodeId);
					  if(result==1)
					  {
						if($bookmarkStatus=='bookmark')
						{
							$('.bookmarkBtn'+nodeId).html('<a class="bookmarked marked'+nodeId+'" onclick="add_bookmark('+nodeId+',\'unbookmark\')"><img style="cursor:pointer;height:18px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png"><?php //echo $this->lang->line('txt_object_following'); ?></a>');
							get_dropdown_post_count();
						}
					  }
					}
				});
			/*}*/
		  }
		
	/*}
	else
	{
		msg= '<?php //echo $this->lang->line('txt_confirm_bookmark'); ?>';
		var agree = confirm(msg);
		//alert(seedId);
		//return false;
		if (agree)
		{
		$.ajax({
			type: "POST",
			url: baseUrl+"post/add_bookmark/"+nodeId,
			cache: false,
			success:  function(result){
			  //alert(nodeId);
			  if(result==1)
			  {
				if($bookmarkStatus=='unbookmark')
				{
					$('.bookmarkBtn'+nodeId).html('<a class="bookmark" onclick="add_bookmark('+nodeId+',\'bookmark\')"><img style="cursor:pointer;height:30px;border:0px;"  src="<?php //echo base_url();?>images/bookmark.png"><?php //echo $this->lang->line('txt_object_follow'); ?></a>');
				}
				else if($bookmarkStatus=='bookmark')
				{
					$('.bookmarkBtn'+nodeId).html('<a class="bookmarked marked'+nodeId+'" onclick="add_bookmark('+nodeId+',\'unbookmark\')"><img style="cursor:pointer;height:30px;border:0px;"  src="<?php //echo base_url();?>images/bookmarked.png"><?php //echo $this->lang->line('txt_object_following'); ?></a>');
				}
			  }
			}
		});
		}
	}*/
	
}
//On mouse hover change bookmark button color and text
function changeBookmarkStatusOver(nodeId)
{
	var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(ismobile!=true && istablet!=true)
	{
		$('.marked'+nodeId).css("background-color", "#CA2055");
		$('.marked'+nodeId).text('<?php echo $this->lang->line('txt_object_unfollow') ?>');
	}
}
function changeBookmarkStatusOut(nodeId)
{
	var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(ismobile!=true && istablet!=true)
	{
		$('.marked'+nodeId).css("background-color", "#999999");
		$('.marked'+nodeId).text('<?php echo $this->lang->line('txt_post_starred') ?>');
	}
}
//check all function start

function checkAllFunctions(){
	$("#multipleRecipientArea").show();
		var htmlContent='';
		
		if($("#checkAll").prop("checked")==true){

			$('.clsChecks').prop("checked",true);

			$(".clsChecks").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(value+","+$(this).val());

				}
				//Show checked label at top
					var data = $(this).data('myval');
					var value = $(this).val();
					htmlContent += '<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
				//Code end

			});
			
			$('.sol-current-selection').html(htmlContent);

		}

		else{

			//change prop to attr for server - Monika

			$('.clsChecks').prop("checked",false);

			$(".clsChecks").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#list").val(arr);

			});
			
			$('.sol-current-selection').html('');

		}

	}
	
		
	//On single checkbox click start
	//$('.clsChecks').live("click",function()
	$(document).on('click', '.clsChecks', function(){
		$("#multipleRecipientArea").show();
		val = $("#list").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#list").val()==''){

				$("#list").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list").val(arr);

		}

		//Showing user label on check checkbox
		var data = $(this).data('myval');
		var value = $(this).val();
		if ($(this).prop('checked')) 
		{
		   addSelectionDisplayItem(data,value,$(this));
        }
		else
		{
		   removeSelectionDisplayItem(value);
        }

	});
	
	function openCommentEditor(nodeId)
	{
		//alert ('here'+nodeId);
		//Added by Dashrath- for add comment image -->
		$("#commentButtonPost"+nodeId).css("display", "none");
		$("#CommentTextBox"+nodeId).css("display", "block");

		chnage_textarea_to_editor('replyTimelineComment'+nodeId,'comment');
		//alert (nodeId);
		$('.CommentTextBox'+nodeId+' .fr-element').focus();
	}	
	function openNestedCommentEditor(nodeId){
		$("#nestedCommentLeafSpan"+nodeId).css("display", "none");
		$("#nestedCommentTextBox"+nodeId).css("display", "block");
		chnage_textarea_to_editor('replyTimelineComment'+nodeId,'comment');
		$('.nestedCommentTextBox'+nodeId+' .fr-element').focus();
	}	

	function cancelPostEditor(nodeId,is_nested=0)
	{
		if(is_nested==0){
			//Added by Dashrath- for add comment image -->
			$("#commentButtonPost"+nodeId).css("display", "block");
			$("#CommentTextBox"+nodeId).css("display", "none");

			//alert('cancel');
			$('.CommentTextBox'+nodeId+' .fr-element').html("");
			$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
		}
		else{
			$('#nestedCommentTextBox'+nodeId+' .fr-element').html("");
			$("#nestedCommentTextBox"+nodeId).css("display", "none");
			$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
			$("#nestedCommentLeafSpan"+nodeId).css("display", "block");
		}
	}

	
	function addSelectionDisplayItem(data,value,changedItem)
	{
		$('.sol-current-selection').append('<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>');
		
	}
	
	function removeSelectionDisplayItem(value,uncheck)
	{
		$('.sol_check'+value).remove();
		
		if(uncheck=='1')
		{
		
			$('.remove'+value).prop('checked', false);
			
			val = $("#list").val();
	
			val1 = val.split(",");
			
			var index = val1.indexOf($('.remove'+value).val());
	
			val1.splice(index, 1);
	
			var arr = val1.join(",");
	
			$("#list").val(arr);
		}
		
	}
	
	function getAllChecks()
	{
			var favorite = [];
            $.each($("input[name='character']:checked"), function(){            
                favorite.push($(this).val());
            });
            alert(favorite.join(", "));
	}
setTimeout("getPostUserStatus()", 10000);
function getPostUserStatus()
{ 
	var workSpaceId = '<?php echo $workSpaceId;?>';
	var workSpaceType = '<?php echo $workSpaceType;?>';
	//var toMatch = document.getElementById('search').value;
	<?php 
		if($workSpaceType==1 && $this->uri->segment(5)=='space' && $workSpaceId==$this->uri->segment(6)){
			$active_view = 'space';
		}
		else{
			$active_view = 'global';
		}
	?>
	var active_view = '<?php echo $active_view;?>';
	//console.log('active_view= ' +active_view);
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
		$.ajax({
			type: "POST",
			url: baseUrl+"post/getPostUserStatusWeb/"+workSpaceId+"/type/"+workSpaceType+"/active_view/"+active_view,
			//data: 'search='+toMatch,
			dataType: 'html',
			async: true,
			success:  function(data){				
				var res = data.split("|@#$%^&|");
				$("#post_web_sidebar_loader").hide();
				$('#divChats').html(res[1]);		
				$('#divSearchUser').html(res[0]);								
			 	setTimeout("getPostUserStatus()", 10000);
			}
		});
}
function searchUserSpaces()
{
	if(document.getElementById('searchSpaces') !== null)
	{
		var toMatch = document.getElementById('searchSpaces').value;
		var val = '';
		val += '<div class="dashboard_fee_right_title">Spaces</div>';
		val += '<input type="checkbox" name="checkAllSpaces" id="checkAllSpaces" onclick="checkAllUserSpaces();" /><?php echo $this->lang->line('txt_All');?><br />';
		//if (toMatch!='')
		if(1)
		{
			var count = '';
			var sectionChecked = '';
			var gotMatch= 0;
			<?php
			$i=1;
			foreach($userAllSpaces as $keyVal=>$arrVal)
			{								
				?>
					var str = '<?php echo $arrVal['workSpaceName']; ?>';
					var pattern = new RegExp('\^'+toMatch, 'gi');
					if (str.match(pattern))
					{
						val +=  '<input class="clsCheckSpace removeSpace<?php echo $arrVal['workSpaceId'];?>" type="checkbox" id="spaceRecipients_<?php echo $i;?>" name="spaceRecipients[]" value="<?php echo $arrVal['workSpaceId'];?>"  data-myval="<?php echo $arrVal['workSpaceName'];?>"/><?php echo $arrVal['workSpaceName'];?><br>';
						gotMatch=1;
					}
					// else
					// {
					// 	val= '<div class="dashboard_fee_right_title"> No Spaces found</div>'
					// }
					<?php
					$i++;	
				?>
				<?php
			}?>
			if(gotMatch==0)
			{
				val= '<div class="dashboard_fee_right_title"> No Spaces found</div>';
			}
			document.getElementById('showManSpaces').innerHTML = val;
			document.getElementById('showManSpaces').style.display = 'block';
			var list = $("#listSpaces").val();
			var val1 = list.split(",");
			$(".clsCheckSpace").each(function(){
				if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				}
			});
		}
		else
		{
			document.getElementById('showManSpaces').style.display = 'none';
		}
	}
}

function focusComment(commentId=0,nodeId){

	var parent = $('#'+commentId).parent().attr('id');
	// alert(parent);
	if(parent=="moreComments"+nodeId)
	{
		// alert("hidden");
			var previous = $("#previousFocusedCommentId").val();
		$("#"+previous).removeClass('nodeBgColorSelect');
		$("#previousFocusedCommentId").val(commentId);	
		$("#"+commentId).addClass('nodeBgColorSelect');
		$("#"+commentId).focus();

		// $('html, body').animate({
		// 	scrollTop: $("#"+commentId).offset().top + 'px'
		// }, 'fast');

		var checkDisplay=document.getElementById('moreComments'+nodeId).style.display;
		if(checkDisplay=='none')
		{
			showAllTimelineComments(nodeId);

					var myElement = document.getElementById(commentId);
var topPos = myElement.offsetTop;
document.getElementById('postArea').scrollTop = topPos;
		}

		var myElement = document.getElementById(commentId);
var topPos = myElement.offsetTop;
document.getElementById('postArea').scrollTop = topPos;
		
	}
	else{
		// alert("visible");
		var previous = $("#previousFocusedCommentId").val();
	$("#"+previous).removeClass('nodeBgColorSelect');
	$("#previousFocusedCommentId").val(commentId);	
	$("#"+commentId).addClass('nodeBgColorSelect');
	$("#"+commentId).focus();

    // $('html, body').animate({
    //     scrollTop: $("#"+commentId).offset().top + 'px'
	// }, 'fast');
	var myElement = document.getElementById(commentId);
var topPos = myElement.offsetTop;
document.getElementById('postArea').scrollTop = topPos;
	}
	
}
function searchGroups()
{
	if(document.getElementById('searchGroup') !== null)
	{
   	var toMatch = document.getElementById('searchGroup').value;
	var val = '<input type="checkbox" name="checkAllGroup" id="checkAllGroup" onclick="checkAllGroups();" /><?php echo $this->lang->line('txt_All');?><br />';
	//if (toMatch!='')
	if(1)
	{
		var count = '';
		var sectionChecked = '';
		<?php
		$i=1;
		foreach($groupList as $keyVal=>$groupData)
		{
			$groupAllUsersList	= $this->identity_db_manager->getGroupUsersListByGroupId($groupData['groupId']);								
			?>
				var str = '<?php echo $groupData['groupName']; ?>';
				var pattern = new RegExp('\^'+toMatch, 'gi');
				if (str.match(pattern))
				{
					val +=  '<input class="clsCheckGroup removeGroup<?php echo $groupData['groupId'];?>" type="checkbox" id="groupRecipients_<?php echo $i;?>" name="groupRecipients[]" value="<?php echo $groupData['groupId'];?>"  data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>" /><?php echo $groupData['groupName'];?><br>';
				}
				<?php
				$i++;	
			?>
			<?php
		}?>
		document.getElementById('showManGroup').innerHTML = val;
		document.getElementById('showManGroup').style.display = 'block';
		var list = $("#listGroup").val();
		var val1 = list.split(",");
		$(".clsCheckGroup").each(function(){
			 if(val1.indexOf($(this).val())!=-1){
				$(this).attr("checked",true);
			 }
		});
	}
	else
	{
		document.getElementById('showManGroup').style.display = 'none';
	}
	}
}
/* Parv: Uncomment below for modal UI instead of talk window UI
// Get the modal
//var modal = document.getElementById("myModal");
var modal = document.getElementById("TimelineEditor");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
*/
</script>
</body>
</html>