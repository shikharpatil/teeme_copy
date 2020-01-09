<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Timeline</title>
<?php $this->load->view('common/view_head.php');?>
<?php $this->load->view('common/scroll_to_top'); ?>
</head>
<body class="bodyNewBackgroundColor">
<div id="wrap1">
  	<div id="header-wrap">
	    <?php $this->load->view('common/header'); ?>
	    <?php $this->load->view('common/wp_header'); ?>
	    
	    <!-- remove common/artifact_tabs view-->
 	</div>
</div>
<div id="container">
	<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
	</div>
  	<div id="rightSideBar">
  		<div id="divSeed" class="seedBackgroundColorNew shareSeedDivHeight">
	  		<!-- Div contains tabs start-->
			<?php $this->load->view('document/document_seed_header'); ?>
		    <!-- Div contains tabs end-->
	    	<div class="clsNoteTreeHeader handCursor">
              	<div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
		            <?php
		            echo strip_tags(stripslashes($arrDocumentDetails['name']),'<b><em><span><img>'); 
		            ?>
          		</div>
              	<?php
	            if (!empty($arrDocumentDetails['old_name']))
	            {
	                echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDocumentDetails['old_name']),'<span><img>').')</div>';
	            }
			  	?>
            </div>
		</div>

		<div>
			<?php
			foreach($finalNotificationData as $filterNotification)
			{
			?>
				<?php
				if(count($filterNotification['filterNotificationData'])>0)
				{
				?>
					<div>
						<p style="color: #90949c; font-size: 15px; text-align: center; font-weight: bold">
							<?php echo $filterNotification['title']; ?>
						</p>
					</div>
					<div class="rightSideContentDiv">
						<?php
						foreach($filterNotification['filterNotificationData'] as $filterNotification)
						{
						?>
							<div style="margin-top:20px; padding:0px !important" id="allNotificationsBody">
								<?php
								if(count($filterNotification['notificationData'])>0)
								{ 
								?>
									<div class="notification_head">
										<p style="color: #666; font-size: 14px;">
											<?php echo $filterNotification['title']; ?>
										</p>
									</div>
								<?php
									foreach($filterNotification['notificationData'] as $notification)
									{	
										$imgName='';
										$imageName='';
										
										if ($notification['objectId']=='1') $imageName = 'tree_icon.png';
										if ($notification['objectId']=='2') $imageName = 'leaf_icon.png';
										if ($notification['objectId']=='4' || $notification['objectId']=='5' || $notification['objectId']=='6') $imageName = 'tag_icon.png';
										if ($notification['objectId']=='7') $imageName = 'link_icon.png';
										
										if($notification['tree_type_space_id']!='')
										{
											$spaceTreeDetails = $this->identity_db_manager->get_space_tree_type_id($notification['tree_type_space_id']);
										}
										?>
										<div class="all_notification_url">
											<a class="notificatonUrl" <?php if ($notification['url']!=''){ ?> href="<?php echo base_url().$notification['url']; ?>" <?php } ?> ><?php echo $notification['notification_data']; ?>
											</a>
											<p class="postTimeStamp">
												<span>
												<?php echo $this->time_manager->getUserTimeFromGMTTime($notification['create_time'],$this->config->item('date_format')); ?>
												</span>
												<?php
												if ($notification['treeType']==1) $imgName = 'document_tree.png';
												if ($notification['treeType']==3) $imgName = 'discuss_tree.png';	
												if ($notification['treeType']==4) $imgName = 'task_tree.png';	
												if ($notification['treeType']==6) $imgName = 'notes_tree.png';	
												if ($notification['treeType']==5) $imgName = 'contact_tree.png';
												if ($notification['treeType']=='' && $notification['objectId']=='3') $imgName = 'post_tree.png';
												if ($notification['objectId']=='8') $imgName = 'talk_tree.png';	
												if ($notification['objectId']=='14' || $notification['objectId']=='15' || $notification['objectId']=='16') $imgName = 'user.png';	
												if ($notification['objectId']=='9') $imgName = 'file_import.png';
												if ($notification['objectId']=='5' && $notification['actionId']=='13') $imgName = '';	
													
												?>
												<?php
												if($notification['work_space_name']!='')
												{
												?>
													<span class="notificationSpaceName"><?php echo $notification['work_space_name']; ?></span>
												<?php
												}
												?>
												<?php 
												if($notification['personalize_status']==1)
												{ 
												?> 
													<span style="margin-left:10px; padding:1px 4px; background:#294277; color:#fff;">
														<?php  echo $this->lang->line('txt_personalize_email_notification'); ?>
													</span>
												<?php 
												} 
												?>
											</p>
										</div>
									<?php 
									}
								}
								?>
							</div>
						<?php
						}
						?>
					</div>
				<?php
				}
				?>
			<?php
			}
			?>	
		</div>
  	</div>
</div>
<?php $this->load->view('common/foot');?>
<!-- remove common/footer view--> 
</body>
</html>
<script type="text/javascript">
	$(window).scroll(function(){
      // if ($(this).scrollTop() > 60) {
      //     $('#divSeed').addClass('documentTreeFixed');
      // } else {
      //     $('#divSeed').removeClass('documentTreeFixed');
      // }

      //call addAndRemoveClassOnSeed function
	  addAndRemoveClassOnSeed($(this).scrollTop());
  	});
</script>