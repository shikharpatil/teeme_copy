<?php if(count($arrLinks) > 0){ ?>	
<?php if($_COOKIE['ismobile']){ ?>
<div class="dashboard_row dashboard_link" style="width:100%;">
<?php } else { ?>
	<div class="dashboard_row dashboard_link" style="width:33.3%; float:left;">
<?php } ?>	
		<div class="dashboard_col" >
			<!-- Updated links start -->
			<div class="dashboard_wrap">
			<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/link-view-sel.png alt='<?php echo $this->lang->line('txt_Links'); ?>' title='<?php echo $this->lang->line('txt_Links');?>' border=0> <?php echo $this->lang->line('txt_Links');?> </span> 
			<?php 
			if (count($arrLinks) > 5)
			{
			?>
			<span><a id="more_links" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_links');">See all.....</a></span>
			<?php
			}
			?>
					<form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
					<input type="hidden" name="page" value="" />
					<?php	
					
								 if(count($arrLinks) > 0)
								 {	
									$rowColor1='row-active-middle1';
									$rowColor2='row-active-middle2';
									$i = 1;
									
									$counter = 0;
									foreach($arrLinks as $data)
									{
										//echo "<li>"; print_r ($data);
										$view_link = '';
										$treeId=$data[id];
										$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
												if ($i<6)
												{
													$display='block';
													$class = 'dashboard_content_links';
												} 
												else 
												{
													$display='none';
													$class = 'dashboard_content_more_links';
												}
										  ?>
						<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
							  <div>
							<span class="clsLabel">
							<?php 
												
											   if($data['type']==1)
											   {
													//echo $this->lang->line('txt_Document');
													$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Document').'" />';
													$view_link='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["id"].'&doc=exist';
												}
												elseif($data['type']==2)
											   {
													//echo $this->lang->line('txt_Discussion');
													$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
													$view_link='view_discussion/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}
												elseif($data['type']==3)
											   {
													//echo $this->lang->line('txt_Chat');
													$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
														if($data['status']==1)
														{
															$view_link='view_chat/chat_view/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
															
														}
														else
														{
															$view_link='view_chat/node1/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
														}
												}	
												elseif($data['type']==4)
											   {
													//echo $this->lang->line('txt_Task');
													$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Task').'"/>';
													$view_link='view_task/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												elseif($data['type']==5)
											   {
													//echo $this->lang->line('txt_Notes');
													$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Contact').'"/>';
													$view_link='contact/contactDetails/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												elseif($data['type']==6)
											   {
													//echo $this->lang->line('txt_Contact');
													$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Notes').'"/>';
													$view_link='notes/Details/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												
												elseif($data['linkType']=='external')
											   {
													//echo $this->lang->line('txt_Imported_Files');
													$icon='<img src="'.base_url().'/images/icon_import.png" style="margin-right:5px;" title="'.$this->lang->line('txt_File').'"/>';
													$view_link = 'workplaces/'.$workPlaceDetails['companyName'].'/'.$data['path'].$data['name'];	
												}	
												elseif($data['linkType']=='url')
											   {
													//echo $this->lang->line('txt_Imported_Files');
													$icon='<img src="'.base_url().'/images/tab-icon/link_icon.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Url').'"/>';
													$view_link = $data['url'];	
												}	
			 
										?>
						  </span>
						  
						  <!--Space tree type validation start-->	
							<?php if(in_array($data['type'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme' || $data['linkType']=='external') { ?>
										<?php
										if($data['linkType']!='url')
										{
										   echo $icon;
											 if($data['linkType']=='external')
											   {
											   
													 echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].'/external target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';  
											   }
											   else
											   {
																			  
													echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].' target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';													
												}
											
											 ?>
											 <span>(<a target="_blank" href="<?php echo base_url().''.$view_link; ?>" title="<?php echo $this->identity_db_manager->formatContent($data['name'],60,1);?>"><?php echo $this->lang->line('txt_View_Link');?></a>)</span>
		
						  <span class="clsLabel">
								<?php //echo $icon; echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($data['createdDate'], $this->config->item('date_format'));?>
						  </span> 
						  <?php }} ?>
						  <?php if($data['linkType']=='url') { ?>
										<?php
										   echo $icon;
											 if($data['linkType']=='url')
											   {
											   
													 echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].'/url target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';  
											   }
											 ?>
											 <span>(<a target="_blank" href="<?php echo $view_link; ?>" title="<?php echo $this->identity_db_manager->formatContent($data['name'],60,1);?>"><?php echo $this->lang->line('txt_View_Link');?></a>)</span>
		
						  <span class="clsLabel">
								<?php echo $this->time_manager->getUserTimeFromGMTTime($data['createdDate'], $this->config->item('date_format'));?>
						  </span> 
						  <?php } ?>
						  </div>
							  <div class="clr"></div>
							</div>
						<?php
										
										$i++;
									}
											 
			
												   
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
			<!-- Updated links end -->	
		</div>
	</div>
<?php } ?>