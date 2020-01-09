<div>
	<span id="notRightSideBarCloseIcon" onclick="hideNotificationSidebar()"><img src="<?php echo  base_url(); ?>images/close.png"></span>
</div>
<div class="notfiDivBot">
	<!--Added by Dashrath- used for leaf content heighlight-->
	<input type="hidden" name="previousClickId" id="previousClickId" value="0" />
	<input type="hidden" name="previousLeafContentId" id="previousLeafContentId" value="0" />
	<input type="hidden" name="previousPredecessorId" id="previousPredecessorId" value="0" />
	<input type="hidden" name="dataType" id="dataType" value="timeline" />
	<!--Dashrath- code end-->
	<?php
	$i=1;
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


								<?php 

									$contentNodeId =  0;

									$contentUrlNodeId = 0;

									$urlData = explode('node=', $notification['url']);

									if(count($urlData)>0)
									{
										$contentNodeId = $urlData[0];

										$contentUrlNodeId = $urlData[0];

										if(count($urlData)>1)
										{
											$urlData1 = explode('#', $urlData[1]);

											$contentNodeId = $urlData1[0];

											$contentUrlNodeId = $urlData1[0];
										}

									}

									$isReserverd = 1;

									if($contentNodeId>0 && $treeType=='document')
									{
										//get latest leaf node id
										$contentLatestNodeId = $this->identity_db_manager->getLatestLeafNodeIdByNodeId($contentNodeId);

										if($contentLatestNodeId>0)
										{
											$contentNodeId = $contentLatestNodeId;
										}

										/*Added by Dashrath- check leaf is reserved or not if status is  draft*/
										
										if($notification['objectId']=='2')
										{
											if($contentNodeId>0)
											{
												$leafStatusDetail = $this->document_db_manager->getLeafStatusByNodeId($contentNodeId);

												if($leafStatusDetail['leafStatus'] == 'draft')
												{
													//Check leaf reserved users
													$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$contentNodeId);

													if(in_array($_SESSION['userId'], $reservedUsers))
													{
														$isReserverd = 1;
													}
													else
													{
														if($notification['actionId']=='2' && $contentUrlNodeId==$contentLatestNodeId)
														{
															$isReserverd = 0;
														}

														$predecessorId = $this->identity_db_manager->getNodePredecessorIdByNodeId($treeId,$contentNodeId);

														if($predecessorId > 0)
														{
															$contentNodeId = $predecessorId;
														}
														
													}
												}
											}
										}
										/*Dashrath- code end*/
									}

									if($notification['objectId']=='1' && $contentNodeId==$treeId)
									{
										$contentType = 'seed';
									}
									else if($notification['objectId']=='8' && $contentNodeId==$treeId && $notification['parent_object_id'] == '1')
									{
										$contentType = 'seed';
									}
									else if(($notification['objectId']=='4' || $notification['objectId']=='5' || $notification['objectId']=='6' || $notification['objectId']=='7') && $notification['objectInstanceId']==$treeId && $notification['parent_object_id'] == '1')
									{
										$contentType = 'seed';

										$contentNodeId = $notification['objectInstanceId'];
									}
									else
									{
										$contentType = 'other';
									}

									//used for check view type
									if($treeType == 'discuss' && $viewType==2)
									{
										$view_type = 'real_time';
									}
									else
									{
										$view_type = 'logical';
									}

									$predecessorId = 0;
									if($contentNodeId>0 && $treeType == 'task')
									{
										$this->load->model("dal/document_db_manager");
										//get latest leaf node id
										$checkPredecessor = $this->document_db_manager->checkPredecessor($contentNodeId);
										if($checkPredecessor>0)
										{
											$predecessorId = $checkPredecessor;
										}
									}
									
								?>

								<?php 
								if($isReserverd > 0)
								{
								?>
									<div class="all_notification_url timelineHandCursor" id="timeline_content_<?php echo $i;?>" <?php if ($contentNodeId>0){ ?> onClick="leafContentHighlight('<?php echo $contentNodeId;?>', '<?php echo $treeType; ?>', '<?php echo $i; ?>', '<?php echo $contentType;?>', '<?php echo $view_type;?>', '<?php echo $predecessorId;?>')" <?php } ?>>
										<!-- <a class="notificatonUrl" <?php if ($notification['url']!=''){ ?> href="<?php echo base_url().$notification['url']; ?>" <?php } ?> ><?php echo $notification['notification_data']; ?>
										</a> -->

										<a class="timelineContentClick" ><?php echo $notification['notification_data']; ?>
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
											<!-- <?php
											if($notification['work_space_name']!='')
											{
											?>
												<span class="notificationSpaceName"><?php echo $notification['work_space_name']; ?></span>
											<?php
											}
											?> -->
											<!-- <?php 
											if($notification['personalize_status']==1)
											{ 
											?> 
												<span style="margin-left:10px; padding:1px 4px; background:#294277; color:#fff;">
													<?php  echo $this->lang->line('txt_personalize_email_notification'); ?>
												</span>
											<?php 
											} 
											?> -->
										</p>
									</div>

								<?php
								}
								?>

								

							<?php 

								$i++;
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
  	
