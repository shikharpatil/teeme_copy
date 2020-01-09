<?php
	//print_r($treeList);
	//exit;
	$count = count($treeList);
?>
<div class="dashboard_tree create_all_tree_lists">
						<div class="dashboard_col">
							<!-- Updated trees start -->
							<div class="dashboard_wrap">
							
							<span class="dashboard_title" style="font-size: 1.032em; font-weight: bold;"><?php /*?><img src=<?php echo base_url(); ?>images/icon_document_sel15.png alt='<?php echo $this->lang->line('txt_Document'); ?>' title='<?php echo $this->lang->line('txt_Document');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_discuss_sel15.png alt='<?php echo $this->lang->line('txt_Discuss'); ?>' title='<?php echo $this->lang->line('txt_Discuss');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_task_sel15.png alt='<?php echo $this->lang->line('txt_Task'); ?>' title='<?php echo $this->lang->line('txt_Task');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_notes_sel15.png alt='<?php echo $this->lang->line('txt_Notes'); ?>' title='<?php echo $this->lang->line('txt_Notes');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_contact_sel15.png alt='<?php echo $this->lang->line('txt_Contact'); ?>' title='<?php echo $this->lang->line('txt_Contact');?>' border=0><?php */?> <!-- <?php echo $this->lang->line('txt_trees_created');?> --> <?php echo $this->lang->line('txt_Created');?></span> 
							<?php 
							/*if ($count > 5)
							{
							?>
								<span><a id="more_trees" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_trees');">See all.....</a></span>
							<?php
							}*/
							?>
								<div class="clr"></div>
								<div style="margin-top:10px;" >
									  <?php
								if($count > 0)
								{
												
								$i = 1;	
				
						
								foreach($treeList as $arrVal)
								{
										$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
												//echo "<li>i= " .$i;
												/*if ($i<6)
												{
													$display='block';
													$class = 'dashboard_content_trees';
												} 
												else 
												{
				
													$display='none';
													$class = 'dashboard_content_more_trees';
												}*/
												?>
								<div style="margin:10px 0 10px;">
									<div>
											
											<?php
											
											if ($arrVal['tree_type']==1)
											{
												$href='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrVal['treeId'].'&doc=exist';
												$txt_tree_type=$this->lang->line('txt_Document');
												$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'" />';
											}
											if ($arrVal['tree_type']==2)
											{
												$href='view_discussion/node/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												$txt_tree_type=$this->lang->line('txt_Discussion');
												
											}
											if ($arrVal['tree_type']==3)
											{
												if($arrVal['status']==1)
												{
													$href='view_chat/chat_view/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}
												else
												{
													$href='view_chat/node1/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}
												$txt_tree_type=$this->lang->line('txt_Chat');
												$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
												
													
											}
											if ($arrVal['tree_type']==4)
											{
											
												$href='view_task/node/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												$txt_tree_type=$this->lang->line('txt_Task');
												$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
												
											}
											if ($arrVal['tree_type']==5)
											{
												$href='contact/contactDetails/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												$txt_tree_type=$this->lang->line('txt_Contact');
												$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
											}
											if ($arrVal['tree_type']==6)
											{
												$href='notes/Details/'.$arrVal['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;
												$txt_tree_type=$this->lang->line('txt_Notes');
												$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
											}
								
											?>
										 
										  <?php echo $icon; ?> 
										  
										  <a href="<?php echo base_url().''.$href; ?>" title="<?php echo $this->identity_db_manager->formatContent($arrVal['tree_title'],0,1);?>"><?php echo $this->identity_db_manager->formatContent($arrVal['tree_title'],150,1); 			 
										  ?> </a> 
										<span class="clsLabel"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['created_date'], 'm-d-Y h:i A');?></span>
									</div>
								<!--/* Added by Surbhi IV*/-->
				
								<div class="clr"></div>
								
							  </div>
								  <?php
													
													
													$i++;
												}
								
								
											}
											else
											{
											?>
										  <?php /*?><div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div><?php */?>
										  <?php
											}	
											?>
									</div>
							</div>	
							<!-- Updated trees end -->  	
						</div>
					</div>

<!--Latest tree list end-->
</div>	
							<!-- Updated trees end -->  	
						</div>
					</div>
