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
<!--Manoj: Back to top scroll script-->
<?php $this->load->view('common/scroll_to_top'); ?>
<!--Manoj: code end-->
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile');?>
	<?php
	
		foreach($arrTimeline as $keyVal=>$arrUsers)
		{
			$arrayUsers[] = $arrUsers['userId'];
		}
		$arrayUsers = array_unique($arrayUsers);
		//echo '<pre>';
		//print_r($arrayUsers);
		//exit;
	
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
		$totalSpacePosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'space');
		$totalPublicPosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'public');
		//$allPosts = $this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0, 'all');	
		$getAllPosts = $this->timeline_db_manager->get_timeline('0', $workSpaceId, $workSpaceType, '1');
		$allPosts = count($getAllPosts);
		$allBookmarkSpace='3';
		$bookmarkPosts	= $this->timeline_db_manager->get_timeline('0',$workSpaceId,$workSpaceType,$allBookmarkSpace);
		$totalBookmarkPosts = count($bookmarkPosts);
	?>
  </div>
</div>
<div id="container_for_mobile">
  <div id="content">
  <!--Online users code start here-->
  <div>
  <!--For online user and posts icon start-->
  
  	<div>
                <ul class="tab_menu_new_for_mobile" style="z-index:1000;margin-left:5px;">

                	<li>

                    	<a style="padding:10px 18px;" href="javascript:void(0);" id="tabm1" class="active" onclick="$('#TimelineRightContentForMobile').show();$('#onlineUsersForMob').hide();$('#tabm2').removeClass('active'); $('#tabm1').addClass('active');"><img src="<?php echo base_url();?>images/message_gray_btn.png" /></a>

                    </li>

                	<li>

                		<a style="padding:10px 18px;" href="javascript:void(0);" id="tabm2" onclick="$('#TimelineRightContentForMobile').hide();$('#onlineUsersForMob').show();$('#tabm1').removeClass('active'); $('#tabm2').addClass('active');"><img src="<?php  echo base_url().'images/list_icon.png'; ?>" style="margin-bottom:5px;" /></a>

                    </li>		

                </ul>
		</div>
		<?php /*?><div style="float:left;width:100%;height:30px;" >
            <div  style="margin-top:12px;border-bottom:1px dotted gray;margin-left:0%" ></div>
        </div><?php */?>
		
  	<div class="clr"></div>
  <!--For online user and posts icon end-->
  	<div style="width:100%;">
		
		<div id="onlineUsersForMob" style="display:none; border-top:1px solid #ccc;">
		
		<div class="postTimeStamp" style="padding:2%;">
			<?php 
			if($workSpaceId==0)
			{
				echo $this->lang->line('txt_users_in_place'); 
			}	
			else
			{
				echo $this->lang->line('txt_users_in_space');
			}
			?>
		</div>
		
          <?php

				//online user list view

				if ($workSpaceId_search_user == 0)

				{

					

				?>

          <?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
			<?php /*href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" */ ?>
          <a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $myProfileDetail['userId']; ?>" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($myProfileDetail['tagName'],true); ?> </a>

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
			<input type="text" name="search" id="search" value="" placeholder="Search" onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:95%"/>
        	<!--<input type="text" name="search" id="search" value="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:95%"/>-->
		<?php
		}
		?>

          <div class="clr"></div>

          <?php

					

					if(count($workSpaceMembers) > 0)

					{

						$rowColor1='rowColor6';

						$rowColor2='rowColor5';	

						$i = 1;

						?>

                        <div id="divSearchUser" name="divSearchUser" >

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
	
									<div id="row1" class="<?php echo $rowColor;?>"> 
										<?php echo '<img src="'.base_url().'images/online_user.gif"  width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
										<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
										<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true); ?> </a>	
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
	
										<div id="row1" class="<?php echo $rowColor;?>" style="float:left;width:100%"> <?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16" style="margin-top:5px;float:left;" />';?> 
										<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
										<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a>
		
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

				else

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

        <div id="row1" >

        <?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
		<?php /* href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" */ ?>
        <a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $myProfileDetail['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;margin-left:10px;"><?php echo wordwrap($myProfileDetail['tagName'],true); ?> </a>


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
        	<input type="text" name="search" id="search" value="" placeholder="Search" onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:95%"/>
		<?php
		}
		?>

        <div class="clr"></div>

      </div>

          <?php

					
				if(count($workSpaceMembers) > 0)

				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;



						?>

          <div id="divSearchUser" name="divSearchUser" >

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
	
											<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />';  ?> 
											<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
											<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a>
									
											<div class="clr"></div>
									
											</div>
	
										<?php
										}
								$i++;
	
								}
	
							}
	
							
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
							{
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
	
											<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16"  style="margin-top:5px;float:left;" />';?> 
											<?php /* href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" */ ?>
											<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="<?php //echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],20,true);?> </a>
									
											<div class="clr"></div>
									
											</div>
										<?php
										}
								$i++;
	
								}
	
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
  <div id="TimelineRightContentForMobile" style="width:100%;" >
  <div class="timelineTopContent">
  
  		<!--Space and place section start here-->
		<div style="margin-bottom:5%;">
		<div class="menu_new" style="background:white;">
		
		  
		  <select name="postTypeSelect" id="postTypeSelect" class="selbox-post-mob" onChange="javascript:selectPostType(this,'<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>');">
			
			<?php if ($myProfileDetail['userGroup']>0) { ?>
		
		<option value="space"><a style="margin-top: 9px;padding-left:11px;<?php if(!$_SESSION['all'] && !$_SESSION['public']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?><?php if($this->uri->segment(10)!=''){ echo '/0/0/'.$userPostSearch; }?>"><span>

          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

           <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a></option>
		  <?php } else if ($workSpaceId>0){ ?>
		<option value="space"><a style="margin-top: 9px; padding-left:11px;<?php if(!$_SESSION['all']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>"><span>

          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

         <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a></option>
		  <?php } ?>
		  <?php if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>
		  <?php if($myProfileDetail['userGroup']>0){ ?>
		 <!--For public posts start-->
		<option value="public" <?php if($this->uri->segment(8)=='public') echo 'selected';?>>
			<a href="<?php echo base_url(); ?>post/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/public<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="margin-top: 9px;padding-left:11px;  <?php if($_SESSION['public']) { ?>background:#ECECEC;" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>
		</option>		  
		  <?php } ?>
		<option value="bookmark" <?php if($this->uri->segment(8)=='bookmark') echo 'selected';?>>
			<a style="margin-top: 9px;padding-left:11px;" id="bookmark"><?php echo $this->lang->line('txt_post_starred').' ('.$totalBookmarkPosts.')'; ?></a>
		</option>
		
		
        <option value="all" <?php if($this->uri->segment(8)=='all') echo 'selected';?> ><a href="<?php echo base_url(); ?>post/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/all<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="margin-top: 9px;padding-left:11px;  <?php if($_SESSION['all']) { ?>background:#ECECEC;" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a></option>
		<?php } ?>
		
		</select>
		
		<div class="clr"></div>

        </div>
		</div>
		<!--Space and place section end here-->	
		
		<!--Timeline profile start here-->
		<div id="TimelineProfile" style=" display: <?php if($this->uri->segment(10)==''){ echo 'none';}else{ echo 'block';}?> ">
			<div style="float:left; width:100%;">
				<div class="timelineProfImg" style="float:left; width:55px !important;">
					
							<?php
								if ($Profiledetail['photo']!='noimage.jpg')
								{
							?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $Profiledetail['photo'];?>" border="0"  width="45" height="45" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $Profiledetail['photo'];?>" border="0"  width="45" height="45" id="imgName"> 
							<?php
								}
							?>
					
				</div>
				
				<table style="font-size:0.8em; width:70%; float:left;">
				<?php if($Profiledetail['firstName']!='' && $Profiledetail['lastName']!='') { ?>
					<tr>
			<td style="padding-bottom:5px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_user_full_name');?>:
			</td>
			<td style="padding-bottom:5px;">
				<?php echo $Profiledetail['firstName'].' '.$Profiledetail['lastName']; ?>
			</td>
			</tr>
			<?php } ?>
			<?php if($Profiledetail['editNickName']!='') { ?>
			<tr>
			<td style="padding-bottom:5px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_nick_name');?>:
			</td>
			<td style="padding-bottom:5px;">
				<?php echo $Profiledetail['editNickName'];?>
			</td>
			</tr>
			<?php } ?>
			<?php if($Profiledetail['statusUpdate']!='') { ?>
				<tr>
				<td style="padding-bottom:5px;" class="profileLeftLabel">
					<?php echo $this->lang->line('txt_Status');?>:
				</td>
				<td style="padding-bottom:5px;">
					 <?php echo $Profiledetail['statusUpdate'];?>
				</td>
				</tr>
			<?php } ?>
			<?php if($Profiledetail['role']!='') { ?>
				<tr>
				<td style="" class="profileLeftLabel">	
					<?php echo $this->lang->line('txt_Role');?>:
				</td>
				<td>
						<?php echo $Profiledetail['role'];?>
				</td>
				</tr>
			<?php } ?>
			<?php if($Profiledetail['mobile']!='') { ?>
				<tr>
				
				</tr>
				<tr> 
				<td style="padding-bottom:5px;" class="profileLeftLabel">
					<?php echo $this->lang->line('txt_Mobile');?>:
				</td>			
	
				<td style="padding-bottom:5px;">
					 <?php echo $Profiledetail['mobile'];?>
				</td>
				</tr>
			<?php } ?>	
			<?php if($Profiledetail['userName']!='') { ?>
			<tr>
			<td style="padding-bottom:5px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_Email');?>:
			</td>
			<td style="padding-bottom:5px;">
				<?php echo $Profiledetail['userName'];?>
			</td>
			</tr>
			<?php } ?>
			<?php if($Profiledetail['editUserTagName']!='') { ?>
			<tr>
			<td style="padding-bottom:5px;" class="profileLeftLabel">
				<?php echo $this->lang->line('txt_user_profile_tag_name');?>:
			</td>
			<td style="padding-bottom:5px;">
				<?php echo $Profiledetail['editUserTagName'];?>
			</td>
			</tr>
			<?php } ?>
				</table>
				
				<?php /* ?>
				<div class="timelineProfname" style="padding-left:70px; padding-top:2px; font-size:12px;">
					<b><?php echo strip_tags($Profiledetail['firstName'].' '.$Profiledetail['lastName'],'<b><em><span><img>'); ?></b>
				</div>
				<?php if($Profiledetail['statusUpdate']!='') { ?>
				<div class="timelineProfname" style="padding-left:77px; padding-top:6px; font-size:0.8em;">
					<div style="width:18%; float:left;"><b><?php echo $this->lang->line('txt_Status').':'; ?></b></div> <div><?php echo strip_tags($Profiledetail['statusUpdate'],'<b><em><span><img>'); ?></div>
				</div>
				<div class="clear"></div>
				<?php } ?>
				<?php if($Profiledetail['mobile']!='') { ?>
				<div class="timelineProfname" style="padding-left:77px; padding-top:6px; font-size:0.8em;">
					<div style="width:18%; float:left;"><b><?php echo $this->lang->line('txt_Mobile').':'; ?></b></div> <div><?php echo strip_tags($Profiledetail['mobile'],'<b><em><span><img>'); ?></div>					
				</div>
				<div class="clear"></div>
				<?php } ?>
				<?php if($Profiledetail['role']!='') { ?>
				<div class="timelineProfname" style="padding-left:77px; padding-top:6px; font-size:0.8em;">
					<div style="width:18%; float:left;"><b><?php echo $this->lang->line('txt_Role').':'; ?></b></div> <div><?php echo strip_tags($Profiledetail['role'],'<b><em><span><img>'); ?></div>
				</div>
				<div class="clear"></div>
				<?php } */ ?>
			
			
			<div class="" style="float:left; padding-top:0px;">
				<?php /*?>Expiry Date: <input name="timeline_exp_date" type="text"  id="timeline_exp_date" class="timelineExpDate" value="" readonly><?php */?>
				<?php /*?><div><img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location.reload(true);' style="cursor:pointer; padding-top:0px;"></div><?php */?>
			</div>
			</div>
		</div>
		<?php /*?><div style="float:left;width:100%;height:30px;" >
            <div  style="margin-top:12px;border-bottom:1px dotted gray;margin-left:0%" ></div>
        </div><?php */?>
		<div class="clr"></div>
		<!--Timeline profile end here-->
		
		<!--Plus icon for public post start here-->
		<?php /*if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds) || isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='') */
		if((isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1) || (isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')) 
		{ 
			if($_SESSION['public'] == 'public')
			{
		?>
			<div style="margin-top:4%;">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
			</div>
		<?php	
			}
		}
		?>
		<!--Plus icon for public post end here-->
			<?php if(!$_SESSION['all'] && !$_SESSION['public']){ ?>
			<?php if($this->uri->segment('8')!='bookmark'){ ?>
			<div style="margin-top:4%;">
				<a id="add" style="cursor:pointer;" onclick="showTimelineEditor();"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a>
			</div>
			<?php } } ?>
		<!--Plus icon end here-->
		
		<div style="font-size:0.8em; margin-top:4%;">
					
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
										<div style="padding-right:30px;">
										<?php
										echo $this->lang->line('txt_show_all_user_post').$postUserName;
										?>
										</div>
										<div style="margin-top:1%;">
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
										<a href="<?php echo base_url(); ?>post/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType.$showAllUrl; ?>"><?php echo $this->lang->line('txt_show_all_post'); ?></a>
										</div>
										<?php
									}
								?>
				<!--code end-->
					
				</div>
				
		<!--Timeline editor start here-->
		<div id="TimelineEditor" style="width:98%; padding:1%; display:none;" >
			<form name="formTimeline" id="formTimeline" method="post" action="" >
				 <textarea name="replyDiscussion" id="replyDiscussion"></textarea>
				 <input value="" id="list" type="hidden" />
				 <input value="" id="listGroup" type="hidden" />
				 <!--Myspace select recepient code start-->
				 
				 <?php
					if($workSpaceId=='0')
					{
						?>
						
						<!--Group feature start here-->
						<?php if(count($groupList)>0){ ?>
						<div style="margin-top:3%;">
						
						
						<?php
				 		echo $this->lang->line('txt_Select_Group')." : <br><br>"; 
						echo $this->lang->line('txt_Search')." : "; 
						?>
						<input type="text" id="searchGroup" name="searchGroup" onKeyUp="searchGroups()" size="20"/>
						
						<div id="showManGroup" style="height:120px;margin-left:50px; overflow:scroll; margin-bottom:0px; margin-top:20px; ">

						<?php if(count($groupList)>0){ ?>
			
						<input type="checkbox" name="checkAllGroup" id="checkAllGroup" onclick="checkAllGroups();" />
			
						<?php echo $this->lang->line('txt_All');?><br />
			
						<?php } ?>
			
						<?php
			
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
				  <!--Select user div end-->
				 <div style="float:left; width:98%; margin-top:5%;">
					<div class="sol-current-selection-groups" style="max-height:135px; overflow-y:auto;"></div>
				  </div>
				  <!--Select user label end-->
				  <div class="clr"></div>
			</div>
			<?php } ?>				
						<!--Group feature end here-->
						
						<div style="margin-top:8%;">
						<?php
				 		echo $this->lang->line('txt_Select_Recepient(s)')." : <br><br>"; 
						echo $this->lang->line('txt_Search')." : "; 
						?>
						<input type="text" id="searchTags" name="searchTags" onKeyUp="showTags()" size="20"/>
						
						<div id="showMan" style="height:120px;margin-left:50px; overflow:scroll; margin-bottom:0px; margin-top:20px; ">

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

<input type="checkbox" name="recipients[]" id="<?php echo 'recipients_'.$i ; ?>" value="<?php echo $workPlaceMemberData['userId'];?>" class="clsChecks remove<?php echo $workPlaceMemberData['userId'];?>" data-myval="<?php echo $workPlaceMemberData['tagName'];?>" >

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}

				?>

          </div>
		  <!--Select user div end-->
		  <div style="float:left; width:98%; margin-top:5%; ">
				<div class="sol-current-selection" style="max-height:135px; overflow-y:auto;"></div>
		  </div>
		 <div class="clr"></div>
						</div>
						
					<?php	
					}
				 ?>
				 <!--Myspace select recepient code end-->
				 
				 
				 <div id="buttons"></div>
				 <br />
				 <?php
				 if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['public'] == 'public')
				 {
				 ?>
				 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="insertTimeline();" style="float:left;" >		 
				 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="showTimelineEditor();" style="float:left; margin-left:1%;" >				
				 <?php 
				 }
				 else
				 { ?>
				 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="insertTimeline();" style="float:left;" >		 
				 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="showTimelineEditor();" style="float:left; margin-left:1%;" >	
				 <?php
				 }
				 ?>
				 <input name="reply" id="reply" type="hidden"  value="1">
				 <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
          		 <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				 <input type="hidden" name="publicPost" value="<?php echo $_SESSION['public']; ?>" id="publicPost">
				 <input name="editorname1" id="editorname1" type="hidden"  value="replyDiscussion">
				<?php /*?><div class="timelineExpiryDate" style="float:left; padding-left:20px;">
					Expiry Date: <input name="timeline_exp_date" type="text"  id="timeline_exp_date" class="timelineExpDate" value="" readonly>
				 </div><?php */?>
			 </form>
			 
		</div>
		<div class="clr"></div>
		
		</div>
		<!--Timeline editor end here-->
		
		
		
		<!--New post and comment message start-->
		
		<div id="newPostCommentMessage" style="display:none; margin-top:3%;">
			<a href="" class="newPostMsg"><span><?php echo $this->lang->line('txt_new_post_found'); ?></span></a>
		</div>
		
		<!--New post and comment message end-->
		
		
		<!--Timeline post start here-->
		<div id="TimelinePost" style="margin-top:6%;">
			<?php
			 $this->load->view('get_timeline_for_mobile'); 
			?>
		</div>
		<!--Timeline post end here-->
		</div>
		<div class="clr"></div>
	</div>
  </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
<?php //$this->load->view('common/datepicker_js.php'); ?>
<script>
$(document).ready(function(){

	/*$('.timelineExpDate').datepicker({
			
			minDate:0,

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

	});*/

});
//Change textarea as editor
//chnage_textarea_to_editor('replyDiscussion','talk2');

//Insert timeline post content
function insertTimeline()
{  
	var error	= ''	
	var replyDiscussion = 'replyDiscussion'; 
    var INSTANCE_NAME = $("#replyDiscussion").attr('name');
	
	var getvalue = getvaluefromEditor('replyDiscussion');
	//alert(getvalue);
	//$('#replyDiscussion').val('');
	//setValueIntoCKEditor('replyDiscussion','');
	//$(".fr-element").html("");
		
	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1){
		error+='<?php //echo $this->lang->line('txt_enter');?>';
	}*/
	
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
		data_user = data_user+'&replyDiscussion='+encodeURIComponent(getvalue)+'&recipients='+recipients+'&groupRecipients='+groupRecipients; 
		//var pnodeId=$("#pnodeId").val();
		var request = $.ajax({
			  url: baseUrl+"post/insert_timeline/",
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result)
			  {
			  	  //$("#buttons").html("");
				  //alert(result);
				  //return false;
				   if(result!='' && result!='0')
				 {
					 $('#TimelinePost').html(result);
					 if($('#TimelineEditor').is(':visible'))
					 {
						$("#TimelineEditor").hide();
						$("#searchTags").val("");
						$(".fr-element").html("");
						$("#buttons").html("");
						document.getElementById('formTimeline').reset();
						$('#checkAll').prop("checked",false);
						$('.clsChecks').prop("checked",false);
						$('.sol-current-selection').html('');
						$('.sol-current-selection-groups').html('');
					 }
				 }
				  /*if(result=='0'){
				  	alert('No Post Found');return;
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
				  /*$('.timelineExpDate').datepicker({
			
							minDate:0,
				
							timeFormat: "HH:mm",
				
							dateFormat: "dd-mm-yy"
				
					});*/
		
				 
			  	}
			});
	
	}
	else
	{
		jAlert(error);
	}	
}

/*Add post share users start*/
function addPostShareUsers(nodeId)
{
		if(document.getElementById("list"+nodeId))
		{
			var recipients=document.getElementById("list"+nodeId).value.split(",");
		}
		//alert('share'+recipients);
		//return false;
		data_user = 'nodeId='+nodeId+'&recipients='+recipients; 
		
		$(".postLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		//var pnodeId=$("#pnodeId").val();
		var request = $.ajax({
			  url: baseUrl+"post/insert_post_shared_users/",
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result)
			  {
			  	  if(result==1)
				  {
				  	alert('Post shared successfully!');
					$(".postLoader").html("");
				  }
				   $(".postLoader").html("");
				  //return false;
			  }
			});
}
/*Add post share users end*/

function insertTimelineComment(nodeId)
{	
	//alert(nodeId);
	if(document.getElementById("totalTimelineCommentNodes"+nodeId))
	{
		realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
	}
	//alert(realTimeTimelineDivIds);
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
		alert("<?php echo $this->lang->line('txt_enter');?>","Alert");
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
		alert(error);
	}	
}

//Insert post comment start

function insertPostComment(nodeId)
{	
	//alert(nodeId);
	//return false;
	if(document.getElementById("totalTimelineCommentNodes"+nodeId))
	{
		realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
	}
	chatReplyNodeId = nodeId;
	var error	= ''
	
	var replyDiscussion = 'replyTimelineComment'+nodeId;
	var INSTANCE_NAME = $("#replyTimelineComment"+nodeId).attr('name');
	var getvalue	= getvaluefromEditor(INSTANCE_NAME);
	
	if (getvalue == ''){
		jAlert("<?php echo $this->lang->line('txt_enter');?>","Alert");
		return false;
	}
	
	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		$('#commentLoader'+nodeId).html("<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
	
		document.getElementById('editStatus').value == 0;
		request_refresh_point=0;
		
		treeId='0';
		var data_user =$("#form"+nodeId).serialize();
		data_user = data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue); 
		
		//var pnodeId=$("#pnodeId").val();
		//url: baseUrl+"post/insert_timeline_comment/"+treeId+"/1/"+nodeId+'?realTimeTimelineDivIds='+realTimeTimelineDivIds,
			  var request = $.ajax({
			  url: baseUrl+"post/insert_timeline_comment/"+treeId+"/1/"+nodeId+'?realTimeTimelineDivIds='+realTimeTimelineDivIds,
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result){
			    //alert('testing'+result);
				//return false;
			    //$("#totalTimelineCommentNodes"+nodeId).remove();
				//$("#commentRefreshDiv"+nodeId).append(result);		
				//$("#commentRefreshDiv"+nodeId).html(result);				
				$('.CommentTextBox'+nodeId+' .fr-element').html("");
				//$('.CommentTextBox'+nodeId+' .fr-element').focus();
				$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
				$('#commentLoader'+nodeId).html("");
				//$('.focusText').focus();
				
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

function showTimelineEditor()
{
	if($('#TimelineEditor').is(':visible'))
	{
		$("#TimelineEditor").hide();
		$("#searchTags").val("");
		showTags();
		$(".fr-element").html("");
		document.getElementById('formTimeline').reset();
		$('.clsChecks').prop("checked",false);
		$('#checkAll').prop("checked",false);
		$('.sol-current-selection').html('');
	}
	else
	{
		$("#newPostCommentMessage").hide();
		$("#TimelineEditor").show();
		chnage_textarea_to_editor('replyDiscussion','simple');
		$('.fr-toolbar').show();
		$(".fr-toolbar").removeClass("fr-sticky-on");
		$(".fr-toolbar").addClass("fr-sticky-off");
	}
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

//check all function start

function checkAllFunctions(){

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

		

			?>document.getElementById('showMan'+nodeId).innerHTML = val;

			document.getElementById('showMan'+nodeId).style.display = 'block';

			<?php

		}?>

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

//My space search recepients start

function showTags()

{
	if(document.getElementById('searchTags') !== null)
	{

   	var toMatch = document.getElementById('searchTags').value;

	var val = '<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunctions();" /><?php echo $this->lang->line('txt_All');?><br />';

	

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

					val +=  '<input class="clsChecks remove<?php echo $workPlaceMemberData['userId'];?>" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients[]" value="<?php echo $workPlaceMemberData['userId'];?>" data-myval="<?php echo $workPlaceMemberData['tagName'];?>" /><?php echo $workPlaceMemberData['tagName'];?><br>';

				}

				<?php

				$i++;	

			}

		

			?>

			<?php

		}?>

		document.getElementById('showMan').innerHTML = val;

		document.getElementById('showMan').style.display = 'block';

		var list = $("#list").val();

		var val1 = list.split(",");

		

		$(".clsChecks").each(function(){

			 if(val1.indexOf($(this).val())!=-1){

				$(this).attr("checked",true);

			 }

		});

	}

	else

	{

		document.getElementById('showMan').style.display = 'none';

	}

	}

}


//My space search recepients end

function showSearchUser()

{

     

	var toMatch = document.getElementById('search').value;

	$.ajax({
			type: "POST",
			url: baseUrl+"post/getPostUserStatus/"+workSpaceId+"/type/"+workSpaceType+"/search",
			data: 'search='+toMatch,
			dataType: 'html',
			success:  function(data){
			 	//alert(data);
				$('#divSearchUser').html(data);
			}
	});



}
	
//On single checkbox click myspace start

//$('.clsChecks').live("click",function()
$(document).on('click', '.clsChecks', function(){

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

/*setInterval(function () {
	findNewPostComment()		
}, 10000);*/

//Add SetTimeOut 
setTimeout("findNewPostComment()", 10000);

//On single checkbox click myspace end	

function selectPostType(postType,workSpaceId,workSpaceType)
{
	var postSpaceType=postType.value;
	
	//alert(postSpaceType);
	
	var url;
	
	if(postSpaceType=="space")
	{
		url = baseUrl+'post/index/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId+'/'+workSpaceType<?php if($this->uri->segment(10)!=''){ echo '/0/0/'.$userPostSearch; }?>;
	}
	else if(postSpaceType=="all")
	{
		url = baseUrl+'post/index/'+workSpaceId+'/type/'+workSpaceType+'/0/1/all<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>';
	}
	else if(postSpaceType=="public")
	{
		url = baseUrl+'post/index/'+workSpaceId+'/type/'+workSpaceType+'/0/1/public<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>';
	}
	else if(postSpaceType=="bookmark")
	{
		url = baseUrl+'post/index/'+workSpaceId+'/type/'+workSpaceType+'/0/1/bookmark<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>';
	}
	
	//alert(postSpaceType+'==='+url);
	
	window.location = url;

}

//Manoj: code end

//Manoj: code for check new post/comments for update

	
//setInterval("postCommentUpdate()", 5000);

//Add SetTimeOut 
setTimeout("postCommentUpdate()", 5000);

function postCommentUpdate()
{
	if(document.getElementById("totalNodes"))
	{
		var realTimePostIds=document.getElementById('totalNodes').value;
	}
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
	var postType = '<?php echo $this->uri->segment(8)?>';
	
	$.ajax({
		type: "POST",
		url: baseUrl+"post/getNewPostComment/"+workSpaceId+"/type/"+workSpaceType+"/"+postType,
		data: jQuery("#totalPostNodes").serialize(),
		dataType: 'json',
		cache: false,
		success:  function(data){
		  if(data!=null && data!=undefined)
		  {
			  $.each(data, function(i, node) {
					postCommentRefresh(node);
			  });
			  //$('#treeTitle').val('');
		  }
		  
		  //Add SetTimeOut 
		  setTimeout("postCommentUpdate()", 5000);
		  
		}
	});
}

function findNewPostComment()
{
	if(document.getElementById("totalNodes"))
	{
		var realTimePostIds=document.getElementById('totalNodes').value;
	}
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
	var postType = '<?php echo $this->uri->segment(8)?>';
	var userPostSearch = '<?php echo $this->uri->segment(10)?>';
	/*if(userPostSearch=='')
	{*/
		$.ajax({
			type: "POST",
			url: baseUrl+"post/findNewPostComment/"+workSpaceId+"/type/"+workSpaceType+"/"+postType+"/"+userPostSearch,
			data: jQuery("#totalPostNodes").serialize(),
			dataType: 'json',
			cache: false,
			success:  function(data){
			 if($('#TimelineEditor').is(':hidden'))
			 {
				 if(data!=0)
				 {
					$("#newPostCommentMessage").show();				
					$.each(data, function(i, node) {
						//alert(node);
						$('#form'+node).css({'background':'#eee'});
						$('#form'+node+' .discussionComments').css({'background-color':'#eee'});
					});
					//$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
				  }
			  }
			  //$('#treeTitle').val('');
			  
			  //Add SetTimeOut 
			  setTimeout("findNewPostComment()", 10000);
			  
			}
		});
	/*}*/
}

//Manoj: code end

//Manoj: Post comment refresh start
var http2 = getHTTPObjectm();

function postCommentRefresh(nodeId){

		//alert(nodeId);
		
		var realTimeTimelineDivIds;
		
		var treeId='0';
		
		var workSpaceId = '<?php echo $workSpaceId;?>';
		var workSpaceType = '<?php echo $workSpaceType;?>';
		
		if(document.getElementById("totalTimelineCommentNodes"+nodeId))
		{
			realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
		}
		
		var request = $.ajax({
			  url: baseUrl+"post/getRealTimePostComment/"+treeId+"/1/"+nodeId+"/"+workSpaceId+"/"+workSpaceType+"?realTimeTimelineDivIds="+realTimeTimelineDivIds,
			  type: "POST",
			  dataType: "html",
			  success:function(result){
			    //alert('testing'+result);
				//return false;
			    $("#totalTimelineCommentNodes"+nodeId).remove();
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
						$('.bookmarkBtn'+nodeId).html('<a class="bookmarkMob" onclick="add_bookmark('+nodeId+',\'bookmark\')"><img style="cursor:pointer;height:20px;border:0px;"  src="<?php echo base_url();?>images/bookmark.png"></a>');
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
							$('.bookmarkBtn'+nodeId).html('<a class="bookmarkedMob marked'+nodeId+'" onclick="add_bookmark('+nodeId+',\'unbookmark\')"><img style="cursor:pointer;height:20px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png"></a>');
						}
					  }
					}
				});
		  }

}

//Manoj: code end

function openCommentEditor(nodeId)
{
	chnage_textarea_to_editor('replyTimelineComment'+nodeId,'comment');
	$('.CommentTextBox'+nodeId+' .fr-element').focus();
}	

function cancelPostEditor(nodeId)
{
	//alert('cancel');
	$('.CommentTextBox'+nodeId+' .fr-element').html("");
	$('#replyTimelineComment'+nodeId).froalaEditor('destroy');
}


//Showing user label on check checkbox
//$('.clsChecks').live("click",function()
$(document).on('click', '.clsChecks', function(){
		//alert($(this).attr('value'));
		//alert($(this).data('myval'));
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

setTimeout("getPostUserStatus()", 5000);
function getPostUserStatus()
{
	var workSpaceId = '<?php echo $workSpaceId;?>';
	var workSpaceType = '<?php echo $workSpaceType;?>';
	var toMatch = document.getElementById('search').value;
	//alert(workSpaceId+'===='+workSpaceType+'====<?php //echo $this->uri->segment(8) ?>');
		$.ajax({
			type: "POST",
			url: baseUrl+"post/getPostUserStatus/"+workSpaceId+"/type/"+workSpaceType,
			data: 'search='+toMatch,
			dataType: 'html',
			success:  function(data){
			 	//alert(data);
				$('#divSearchUser').html(data);
			 	setTimeout("getPostUserStatus()", 5000);
			}
		});
}
//Code end
</script>
</body>
</html>