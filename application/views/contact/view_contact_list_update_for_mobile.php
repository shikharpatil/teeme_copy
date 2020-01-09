<?php 
		$focusId = 3;
		$totalNodes = array();

		$rowColor1='row1';
		$rowColor2='row2';	
		$i = 1;

		if(count($ContactNotes) > 0)
		{
          
			$count=0;

			foreach($ContactNotes as $keyVal=>$arrVal)
			{	 
				$userDetails1	= 	$this->contact_list->getUserDetailsByUserId($arrVal['userId']);		
				$nodeOrder++;
	
				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);
				$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);	
	
				if ($arrVal['nodeId'] == $this->uri->segment(8))
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
	
				$totalNodes[] = $arrVal['nodeId'];

		?>

<div class="clr"></div>
<div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onMouseOut="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor"  id="contactLeafContent<?php echo $arrVal['nodeId']; ?>">
  <div style="height:30px; padding-bottom:0px;" >
    <ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; display:none" class="content-list ulNodesHeader">
      <?php
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);	
					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);
					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);		
				
						
					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
					if($total==0)
					{
						$total='';
						$tag_container=$this->lang->line('txt_None');
					}
					else
					{
						
						     if(count($viewTags)>0)
							 {
								$tag_container='Simple Tag : ';
								foreach($viewTags as $simpleTag)
								$tag_container.=$simpleTag['tagName'].", ";
								$tag_container=substr($tag_container, 0, -2).""; 
							 
							}
							
												
							if(count($actTags) > 0)
								{
								   $tag_container.='Action Tag : ';
									$tagAvlStatus = 1;	
									foreach($actTags as $tagData)
									{	$dispResponseTags='';
										$dispResponseTags = $tagData['comments']."[";							
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if(!$response)
										{  
											
											if ($tagData['tag']==1)
												$dispResponseTags .= $this->lang->line('txt_ToDo');									
											if ($tagData['tag']==2)
												$dispResponseTags .= $this->lang->line('txt_Select');	
											if ($tagData['tag']==3)
												$dispResponseTags .= $this->lang->line('txt_Vote');
											if ($tagData['tag']==4)
												$dispResponseTags .= $this->lang->line('txt_Authorize');															

										}
										$dispResponseTags .= "], ";	
						
										$tag_container.=$dispResponseTags;
									}
									
									$tag_container=substr($tag_container, 0, -2)."
"; 
								}
								
								
								if(count($contactTags) > 0)
									{
										$tag_container.='Contact Tag : ';
										$tagAvlStatus = 1;	
										foreach($contactTags as $tagData)
										{
											
											$tag_container .= strip_tags($tagData['contactName'],'').", ";	
											
										}
										
										$tag_container=substr($tag_container, 0, -2); 
									}		
							
					}
						

				?>
      <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onClick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
      <?php				
						
					
					
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees7);
				
				$appliedLinks=' ';
				
				if($total==0)
					{
						$total='';
						$appliedLinks=$this->lang->line('txt_None') ;
						
					}
					else
					{
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							
							 if(count($docTrees3)>0)
						   {
								$appliedLinks.=$this->lang->line('txt_Chat').': ';	
								foreach($docTrees3 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees4)>0)
							{
							
								$appliedLinks.=$this->lang->line('txt_Task').': ';	
								foreach($docTrees4 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees6)>0)
							{
								$appliedLinks.=$this->lang->line('txt_Notes').': ';	
								foreach($docTrees6 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}
							
							if(count($docTrees5)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
								foreach($docTrees5 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
							
							if(count($docTrees7)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
									 
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
							         
									 if($linkData['docName']=='')
									 {
									    $appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
									 }
									 else
									 {
									 	$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 }
									
								}
							
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							 if(count($docTrees9	)>0)
									{
									
										$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
										foreach($docTrees9 as $key=>$linkData)
									   {
											 $appliedLinks.=$linkData['title'].", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2);
									
									}
						
					}
					
					?>
      <li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onClick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
      <?php
				
				    $ci =&get_instance();
					$ci->load->model('dal/discussion_db_manager');
					$total=$ci->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);  
			
				    $talk=$ci->discussion_db_manager->getLastTalkByTreeId($leafTreeId);  
			
					if(strip_tags($talk[0]->contents))
					{
			
						$userDetails = $ci->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
						$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
					}
					else
					{
						$latestTalk='Talk';
					}
					
					if($total==0)
					{
						$total='';
					}
					
		
					//echo '<li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
					
					$leafdataContent=strip_tags($arrVal['contents']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['contents'], ENT_QUOTES);
					
					?>
					<?php /*?><li  class="talk"><a id="liTalk<?php echo $leafTreeId; ?>" href="javaScript:void(0)" onClick="talkOpen('<?php echo $leafTreeId; ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrVal['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li><?php */?>
					
					<?php
						echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
					?>
					
					<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
					<?php
	
	
					$lastnode=$arrVal['nodeId'];


					?>
    </ul>
  </div>
  <div class="clr"></div>
  <div  >
    <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >
      <div  class="autoNumberContainer"  >
        <p>
          <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?>
        </p>
      </div>
      <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?></div>
    </div>
    <div class="clr"></div>
    <div style="height:30px;" >
      <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none; width:100%; margin:3%; padding: 4% 0%;" >
        <div class="style2" style="width:75%; text-align:left; "  >
		<div> 
		 <?php 
		 echo $userDetails1['userTagName'];
		 if(strlen($userDetails1['userTagName'])>16)
		  		{
			?>
				</div>
				<div style="margin-top: 5px;">
                <?php 
				}
				if($arrVal['editedDate'][0]==0)
				{
						//Start Manoj: Remove date suffix and current year
							 
							 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format'));
							 $Create_date = explode(' ',$Create_date);
							 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
							 $current_year = date("y");
							 if($current_year == $Create_date[2])
							 {
								$Create_date[2]=" ";
							 }
							 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
							 
						//End Manoj: Remove date suffix
				
					//echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format'));
				}
				else
				{
						//Start Manoj: Remove date suffix and current year
							 
							 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
							 $Create_date = explode(' ',$Create_date);
							 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
							 $current_year = date("y");
							 if($current_year == $Create_date[2])
							 {
								$Create_date[2]=" ";
							 }
							 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
							 
						//End Manoj: Remove date suffix
				
				    //echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
				}
				?>
		 </div>
        </div>
        <!--/*Changed by Surbhi IV*/-->
        <?php 
					if($_SESSION['userId'] == $arrVal['userId'])
					{
				?>
        <span style="width:20%;" class="editDocumentOption"><a href="javascript:editNotesContents1(<?php echo $position;?>,<?php echo $treeId;?>,<?php echo $arrVal['nodeId']; ?>,<?php echo $arrVal['successors']; ?>);"  style="margin-right:25px;" ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_View_Details"); ?>" title="<?php echo  $this->lang->line("txt_View_Details"); ?>" border="0"></a></span>
        <?php
					}
				?>
        <!--/*End of Changed by Surbhi IV*/--> 
        
      </div>
    </div>
    <?php
				#******************************* * * * * * * * * * * * * * * Tags * * * * * * * * ************************************************88
							
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;
				?>
    <div class="divLinkFrame">
      <div id="linkIframeId<?php echo $arrVal['nodeId']; ?>"    style="display:none;"></div>
    </div>
    <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
    <div class="commonDiv">
      <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}
							
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
				
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',3,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				
					?>
      <div id="divSimpleTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispViewTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >
        <?php

					echo $this->lang->line('txt_Simple_Tags').': <span id= "simpleTags'.$arrVal['nodeId'].'">'.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'</span><br>';				
					$nodeTagStatus = 1;		
					?>
      </div>
      <?php				
						
				//Response tag container	
					?>
      <div id="divResponseTags<?php echo $arrVal['nodeId'] ; ?>" <?php if($dispResponseTags!=''){ echo 'style="display:block"';} else { echo'style="display:none"' ; } ?> >
        <?php
					

					echo $this->lang->line('txt_Response_Tags').':<span id= "responseTags'.$arrVal['nodeId'].'"> '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'</span><br>';			
					$nodeTagStatus = 1;
					?>
      </div>
      <?php	
					
				 //Contact Tag container
					?>
      <div id="divContactTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispContactTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >
        <?php

					echo $this->lang->line('txt_Contact_Tags').':<span id= "contactTags'.$arrVal['nodeId'].'"> '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'</span><br>';
					$nodeTagStatus = 1;	
					?>
      </div>
      <?php	
					
				if($dispUserTags != '')		
				{
					?>
      <div>
        <?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?>
      </div>
      <?php		
				}	
							
				if($nodeTagStatus == 0)	
				{
				?>
      <div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>
      <?php
				}
				?>
    </div>
    </span>
    <div class="commonDiv">
      <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(<?php echo $arrVal['nodeId'];?>)" />
      <span id="spanTagNew<?php echo $arrVal['nodeId'];?>">
      <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" />
      </span> </div>
    <div class="commonDiv">
      <div id="iframeId<?php  echo $arrVal['nodeId'];?>"    style="display:none;"></div>
    </div>
    </span>
    <?php	
				#*********************************************** Tags ********************************************************																		
				?>
    <div class="clr"></div>
  </div>
  <div id="initialContent<?php echo $arrVal['nodeId'];?>" style="display:none" ><?php echo $arrVal['contents'];?>
    <input type="hidden" id="leafContent_<?php echo $arrVal['nodeId'];  ?>" value="<?php echo $arrVal['contents']; ?>"  />
  </div>
 <?php /*?> <div id="<?php echo $position;?>edit_contacts"  float:left; display:none;"> </div><?php */?>
  <div class="clr"></div>
</div>
<!--Manoj: edit leaf content-->
	<div class="<?php echo $nodeBgColor; ?> handCursor">
<div id="<?php echo $position;?>edit_contacts" style="width:92%;<?php //echo $this->config->item('page_width')-50; px ?> float:left; display:none;"> </div>
</div>
<div class="clr"></div>
<div id="loader<?php echo $arrVal['nodeId']; ?>"></div>

<?php  
		$position++;
		$focusId = $focusId+2;	
		$i++;
		} 
	}
	?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<input type="hidden" name="curLeaf" value="0" id="curLeaf">
<input type="hidden" name="editStatus" value="0" id="editStatus">
<input type="hidden" name="curContent" value="0" id="curContent">
<input type="hidden" name="editorname1" value="0" id="editorname1">
<input type="hidden" name="reply" value="1" id="reply">
<input type="hidden" name="nodeId" value="" id="nodeId">
