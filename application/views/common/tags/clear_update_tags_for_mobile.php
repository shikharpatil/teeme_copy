<div class="boxtext">
          <div class="menu_new h2_class">
    <ul class="tab_tag_link">
              <li  id="tabTagsList" class="tabs_tags_select"> <a   href="javaScript:void(0)" onclick="showHideTagsView('')" ><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; </li>
              <?php 
			
			
			 if($latestVersion==1 )
			 {
			   $_SESSION['set_doc_latest_version']=0; 
			 ?>
              <li  id="tabTagsSet" class="tabs_tags"> <a href="javaScript:void(0)" onclick="showHideTagsView('add')" ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="add new tag" border="0" ></a> </li>
              <?php 
			      }
			?>
            </ul>
			<div style="float:right">
				<div class="closeLoader"></div>
			</div>
  </div>
          <div class="clr" ></div>
        </div>
<ul class="navigation" id="tagsNavigation" style="display:none;  padding-left:15px;" >
          <li style="margin-right:5px;"  >
    <select name="groupTags" id="groupTags" onchange="getTagView(this.value)" style="width:140px;">
              <option value="2" <?php if($tagOption == 2) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Simple');?></option>
              <option value="3" <?php if($tagOption == 3) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Response');?></option>
              <option value="5" <?php if($tagOption == 5) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Contact');?></option>
            </select>
  </li>
        </ul>
<div id="divAllTags">
          <div id="tags_container" class="slider-content" style="padding: 0px 10px 0px 10px" >
    <p>
              <?php
			if($leafClearStatus == 1 && $leafClearStatus != '' && $latestVersion==1 && $artifactType==2)
			{
				?>
				<div class="clearMsgPadding"><?php echo $this->lang->line('txt_clear_prev_tag_obj_msg'); ?></div>
			<?php
			}		
						 
			
			if((count($viewTags)+count($actTags)+count($contactTags)+count($userTags))>0)
			{
			
			if($leafClearStatus == 0 && $leafClearStatus != '' && $latestVersion==1 && $leafOwnerData['userId']==$_SESSION['userId'])
			{
			?>
			<div>
				<input type="button" name="clear" value="<?php echo $this->lang->line('txt_clear_prev_tag_obj'); ?>" onclick="clearTags('<?php echo $artifactId ?>');" style="margin-bottom:10px;" /> 
			</div>
			
			<div class="clearLoader" id="clearLoader"></div>
			
			<?php
			}	
			
			if(count($viewTags)>0)
			{		 
						       
				$tag_container.=$this->lang->line('txt_Simple_Tag').' : <span>';
				$i=0;
				 foreach($viewTags as $simpleTag)
				 {
				 	if($i>0)
					{	
						$tag_container.= ", ";
					}
				 	$tag_container.=$simpleTag['tagName'];
					$i++;
				 }
				 $tag_container.='</span><br/>';
			}
			
				 
		 
		 		
							
			if(count($actTags) > 0)
			{
				$tag_container.=$this->lang->line('txt_Response_Tag').' : <span>';
				$tagAvlStatus = 1;	
				$i=0;	
				foreach($actTags as $tagData)
				{	$dispResponseTags='';
					if($i>0)
					{	
						$dispResponseTags.= ", ";
					}
					$dispResponseTags = $tagData['comments'].' [';							
					$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
					if(!$response)
					{  
						
						if ($tagData['tag']==1)
							$dispResponseTags .= '<a href="javascript:void(0)"  onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						if ($tagData['tag']==2)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
						if ($tagData['tag']==3)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
						if ($tagData['tag']==4)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
					}
					$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
										
					$dispResponseTags .= '] ';
					
					$tag_container.=$dispResponseTags;
					$i++;
				}
				$tag_container.='</span><br/>';
			}
			
			$tag_container.='<div id="actionTagResponse"></div>';
			if(count($contactTags) > 0)
				{
				    $tag_container.=$this->lang->line('txt_Contact_Tag').' : <span>';
					$tagAvlStatus = 1;
					$i=0;	
					foreach($contactTags as $tagData)
					{
			
						if($i>0)
						{	
							$tag_container.= ", ";
						}
						$tag_container .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a> ';	
						$i++;
													
					}
					 $tag_container.='</span><br>';
				}		
		
		 
		
		 
		 }
		 else
		 {
		      $tag_container.='<div style="padding-left:3px;">'.$this->lang->line('txt_None').'</div>';
		 }
			echo  $tag_container;					
						?>
            </p>
  </div>
        </div>
<div id="allTagViews" style="padding:0px 5px 0px 5px;"> 
          
          <!-- ------------------ Simple tags starts here-------------------------- -->
          
          <div id="divSimpleView" style="display:none">
    <div class="clr"></div>
    <div class="slider-content">
              <?php
		
				
					$tags = $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
					$arrTagDetails['tags'] = $tags;
							
					$lastLogin = $this->identity_db_manager->getLastLogin();
					$currentTags = $this->tag_db_manager->getCurrentTags(2, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
					$arrTagDetails['currentTags'] = $currentTags;
					
					$arrTagDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
					
					
					$arrTagDetails['treeId'] = $treeId;
					
					//This session uses to  show tag in simple tage view
					$_SESSION['artifactId'] = $artifactId;
					$_SESSION['artifactType'] = $artifactType;
					
					$arrTagDetails['createUrl'] = $createUrl;
			
					if($addNewOption == 1)
					{	
					   $this->load->view('common/tags/view_tag2_for_mobile', $arrTagDetails); 
					}	
					else
					{	
						$this->load->view('common/tags/add_view_tag', $arrTagDetails); 
					}
					
					
				?>
            </div>
  </div>
          
          <!-- simple tags closes here ------------------------------------>
          <!--Manoj: Reduced min width 250 from 500 -->
          <div id="divActionView"  style="display:none;overflow:visible;min-width:250px;padding-bottom:10px;">
    <div class="clr"></div>
    <div class="slider-content" id="divActionTagContainer" >
              <?php
				    $tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);
					$arrTagDetails['tags'] = $tags;						
								
					$lastLogin = $this->identity_db_manager->getLastLogin();
					$currentTags = $this->tag_db_manager->getCurrentTags(3, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
					$arrTagDetails['currentTags'] = $currentTags;
					$arrTagDetails['tagOption'] = 3;
							
					$arrTagDetails['createUrl'] = $createUrl;
					
						if ($artifactType==2) // if leaf
						{
							$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity ($artifactId);
						}
						else //if tree
						{
							$treeId = $artifactId;
						}
					$arrTagDetails['sharedMembers'] = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
							
				
							
							if ($tagId)
							{
				
								$arrTagDetails['editTagId'] = $tagId;

							}
							$arrTagDetails['treeId']=$treeId;
					
							if($addNewOption == 1)
							{	
								$this->load->view('common/tags/act_tag_for_mobile', $arrTagDetails);  
							}	
							else if($addNewOption == 3)
							{	
								$arrTagDetails['tagId'] = $this->uri->segment(10);	
								$this->load->view('common/tags/act_response_for_mobile', $arrTagDetails); 
							}			
							else
							{	
								$this->load->view('common/tags/add_act_tag', $arrTagDetails); 
							}	
							
						
							?>
            </div>
  </div>
          
          <!-- Action tag closes here - -->
          
          <div id="divContactView" style="display:none;">
    <div class="clr"></div>
    <div class="slider-content">
              <?php
							$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $artifactId, $artifactType);
							$arrTagDetails['tags'] = $tags;
							$arrTagDetails['treeId'] = $treeId;
						
							$lastLogin = $this->identity_db_manager->getLastLogin();
							$currentTags = $this->tag_db_manager->getCurrentTags(5, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
							$arrTagDetails['currentTags'] = $currentTags;
							
							$arrTagDetails['tagOption']=5;
								
							if($addNewOption == 1)
							{	
						
								$this->load->view('common/tags/add_contact_tag_for_mobile', $arrTagDetails); 
							}	
							else
							{	
								$this->load->view('common/tags/add_contact_tag_for_mobile', $arrTagDetails); 
							}	
																		
							
				?>
            </div>
  </div>
        </div>