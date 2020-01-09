<?php if($arrAllTagsCount > 0){ ?>
<?php if($_COOKIE['ismobile']){ ?>
<div class="dashboard_row dashboard_tag" style="width:100%;">
<?php } else { ?>
	<div class="dashboard_row dashboard_tag" style="width:33.3%; float:left;">
<?php } ?>
		<div class="dashboard_col" >
			<!-- Updated tags start -->
			<div class="dashboard_wrap">
			<div class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_Tags'); ?>' title='<?php echo $this->lang->line('txt_Tags');?>' border=0> <?php echo $this->lang->line('txt_Tags'); ?></div> 
			<?php /*?><div class="clsLabel">s=<?php echo $this->lang->line('txt_Simple_Tag');?>, a=<?php echo $this->lang->line('txt_Response_Tag');?>, c=<?php echo $this->lang->line('txt_Contact_Tag');?></div><?php */?>
			<div style="margin:8px 0;">
			
			<?php //echo "<li>total tags= " .count($arrTags); ?>
	
			<!-- Andy: Commented because total tags are not filtered by space so shows total tags in the place
			<span><a id="more_tags" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_tags');">See all.....</a></span>-->
	
					  <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
					<input type="hidden" name="page" value="" />
					<?php	
						$applied=0;$due=0;$list=0;$usersString=0;
						if(count($arrTags) > 0)
						{
							$rowColor1='row-active-middle1';
							$rowColor2='row-active-middle2';
							$i = 1;
							
							$counter = 0;
				?>
				<div class="simple_tag">
				<div style="padding: 0.5% 0;">Simple Tag:</div>
				<?php
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
													
							  ?>
				
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									
									if ($total_nodes > 0)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
													 <span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//print_r($arrTreeDetails);
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														if ($tagData['treeType']==1)
														{
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==2)
														{
														  
															
														
															echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==4)
														{ 
															echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														$count++;
														if ($tagData['treeType']==1)
														{ 
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&node='.$tagData["artifactId"].'&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==2)
														{
														
															if($tagData['predecessor'] != 0)
															{
																echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																	
															}
															else
															{
															
															echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
															
															}
															
													
														}
													
														if ($tagData['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==4)
														{
															echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													?>
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								?>
								
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post simple tag public start here
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
								//echo $tagData["tag"].'=======<br>';
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
				
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
								 	$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic('0', '0', 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									
									if ($total_nodes > 0)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic('0', '0', 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//echo '<pre>';
										//print_r($arrTreeDetails);
										
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														//echo 'testing=========='.$tagData['treeType'].'<br>';
														
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													?>
													<?php if ($tagData['treeType']==''){ ?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<?php } ?>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								?>
								
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post simple tag public end here
							
							//Timeline post simple tag start here
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
								//echo $tagData["tag"].'=======<br>';
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
															
							  ?>
				
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
								 	$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									
									if ($total_nodes > 0)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//echo '<pre>';
										//print_r($arrTreeDetails);
										
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														//echo 'testing=========='.$tagData['treeType'].'<br>';
														
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													?>
													<?php if ($tagData['treeType']==''){ ?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<?php } ?>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								?>
								
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							
							//Timeline simple post tag end here
							?>
							</div>
							<div class="action_tag">
							<div style="padding: 0.5% 0;">Action Tag:</div>
							<?php
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
				  
								
								<?php
								
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															if ($tagData3['treeType']==1)
															{
																echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==2)
															{
															  
																echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==3)
															{
																echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==4)
															{ 
																echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==5)
															{
																echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==6)
															{
																echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															if ($tagData3['treeType']==1)
															{ 
																echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&node='.$tagData3["artifactId"].'&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==2)
															{
															
																if($tagData3['predecessor'] != 0)
																{
																	echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData3['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData3['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																		
																}
																else
																{
																
																echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData3['tagComment'].'</a>'; 
																
																}
																
														
															}
														
															if ($tagData3['treeType']==3)
															{
																echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==4)
															{
																echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==5)
															{
																echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==6)
															{
																echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 ?>
								 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post public action tag start here
							
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
	
															
							  ?>

				  
								
								<?php
								
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic('0', '0', 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														

											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic ('0', '0', 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
																
															}
															
															
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															}
															
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 ?>
								 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post public action tag end here
							
							//Timeline post action tag start here
							
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
	
															
							  ?>

				  
								
								<?php
								
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline ($workSpaceId, $workSpaceType, 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline ($workSpaceId, $workSpaceType, 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
																
															}
															
															
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															}
															
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 ?>
								 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post action tag end here
							?>
							</div>
							<div class="contact_tag">
							<div style="padding: 0.5% 0;">Contact Tag:</div>
							<?php
							//echo '<pre>';
							//print_r($arrTags);
							//exit;
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>

				   
								 
								 <?php
								 
								 if($tagData['tagType']==5) //for contact tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														if ($tagData2['treeType']==1)
														{
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==2)
														{
														  
															
														
															echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==4)
														{ 
															echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData2['artifactType']==2)
													{
														$count++;
														if ($tagData2['treeType']==1)
														{ 
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&node='.$tagData2["artifactId"].'&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==2)
														{
														
															if($tagData2['predecessor'] != 0)
															{
																echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData2['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData2['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																	
															}
															else
															{
															
															echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
															
															}
															
													
														}
													
														if ($tagData2['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==4)
														{
															echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													?>
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
							 ?>
							 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post public contact tag start here
							
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
								if($tagData['workSpaceId']==$workSpaceId)
								{
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				   
								 
								 <?php
								 
								 if($tagData['tagType']==5) //for contact tag
								 {
								 	//echo $tagData['tagType'].'<br>';
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic ('0', '0', 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic ('0', '0', 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
											//echo $tagData["tag"];
											
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													
													if ($tagData2['artifactType']==2)
													{
													
														
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
														
													}
													?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
							 ?>
			<?php
							}
							$i++;
							
							}
							
							
							//Timeline post public contact tag end here
							
							//Timeline post contact tag start here
							
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
								
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				   
								 
								 <?php
								 
								 if($tagData['tagType']==5) //for contact tag
								 {
								 	//echo $tagData['tagType'].'<br>';
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline ($workSpaceId, $workSpaceType, 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 0)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline ($workSpaceId, $workSpaceType, 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
											//echo $tagData["tag"];
											
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													
													if ($tagData2['artifactType']==2)
													{
													
														
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
														
													}
													?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
							 ?>
			<?php
							
							$i++;
							}
							
							//Timeline post contact tag end here
							?>
					</div>
					<?php
					}
					else
					{
						 ?>
			<div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
			<?php
					}
								?>
				  </form>
				  </div>
			</div>
			<!-- Updated tags end -->	
		</div>
	</div>	
<?php } ?>	