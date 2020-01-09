                <div id="contributorsMsg" style="margin-bottom:10px;" ></div>
					
						<div style="margin-top:10px;">
							
							<div style="width:auto; color:#000;"  ><?php if($reservedTree==1) { echo $this->lang->line('txt_leaf_reserved_users').': '; } else { echo $this->lang->line('txt_Contributors').': '; }?>
							<?php
							 if(count($contributorsTagName)>3)
							 {
								?>
								<a id="seeAll"  style="cursor:pointer; padding: 0 1%; font-size: 1em;" onclick="javascript:show_assignee('tree_more_contributors');"><?php echo $this->lang->line('see_all_txt'); ?></a>
							  <?php
							 }
							
							?> 
							</div>
							<div class="docContributors" id="docContributors"  style="margin-bottom:15px; font-size: 1em; width: 100%;"  >
							
							<?php
								$i=0;
								$contributorsCount = count($contributorsTagName);
								
								
								//foreach($arrPostsTimeline as $keyVal=>$arrVal)
								for($i=0; $i<$contributorsCount; $i++)
								{
										if ($i<3)
										{
											$display='block';
											$class = 'tree_contributors';
										} 
										else 
										{
											$display='none';
											$class = 'tree_more_contributors';
										}	
									?>
										
										<span class="<?php echo $class;?>" style="float:left; display:<?php echo $display;?>">
											<?php echo $contributorsTagName[$i].', &nbsp;'; ?>
										</span>
								<?php
								}
								?>
							
							</div>
							
							</div>
						
						  <div style="float:right">
						</div>	