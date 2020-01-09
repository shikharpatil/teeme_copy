<div class="documentSeedFooter">
	<!-- footer left content start -->
	<div class="documentSeedFooterLeft">
		<?php
		if($arrDocumentDetails['latestVersion']==1)
		{
		?>
        	<!--/*Added by Surbhi IV for checking version */-->
			<!--Manoj: Added contributor condition-->
            <span class="documentSeedLeafSpanLeft">
            	<a id="aAddNewNote"  <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="addLeafIconDisBlock2"';}else { echo 'class="addLeafIconDisNone2"';} ?> <?php if($arrDocumentDetails['latestVersion']==1) {echo 'class="addLeafIconDisBlock2"';}else { echo 'class="addLeafIconDisNone2"' ; } ?> href="javascript:void(0);" onClick="addFirstLeaf(<?php echo $treeId;?>,0,'<?php echo $arrDocumentDetails['version']; ?>')">
            		<img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" >
            	</a>
            </span>
             <!--/*End of Added by Surbhi IV for checking version */-->
        <?php 
		}
		?>
        <?php 
		if ($arrDocumentDetails['userId'] == $_SESSION['userId'] 
			&& $latestVersion==1)
		{
		?>
			<span class="documentSeedLeafSpanLeft">
                <a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','<?php echo $arrDocumentDetails['version']; ?>')"  style="margin-right:25px; float:left" >
                	<img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0">
                </a>
            </span>
        <?php 	
		}
		?>       
	</div>
	<!-- footer left content end -->

	<!-- footer right content start -->
	<div class="documentSeedFooterRight">
		
		<!-- tag link talk content start -->
		<span id="ulNodesHeader0" class="ulNodesHeader documentSeedLeafSpanRight" style="display:inline; <?php if($arrDocumentDetails['latestVersion'] != 1){ echo "margin-right:3%;"; } ?> ">

			<ul class="content-list" style="float:left; margin: 0 0 0 0">
            	<?php	
				$tag_container='';
				$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);

				if($total==0)
				{
					$total='';
					$tag_container=$this->lang->line('txt_Tags_None');
				}
				else
				{	
					if(count($viewTags)>0)
					{
						$tag_container='Simple Tag : ';
						foreach($viewTags as $simpleTag)
						{
							$tag_container.=$simpleTag['tagName'].", ";
						}
						$tag_container=substr($tag_container, 0, -2)." 
						";		 
					}
											
					if(count($actTags) > 0)
					{
						$tag_container.='Action Tag : ';
						$tagAvlStatus = 1;	
						foreach($actTags as $tagData)
						{	
							$dispResponseTags='';
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

            	<!--Added by Surbhi IV -->
            	<?php if($latestVersion!=1 && !$total) {  } 
            	else 
            	{ ?>
            	<!--End of Added by Surbhi IV -->
            	<li class="tagLinkTalkSeedLeafIcon">
            		<a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/<?php echo $latestVersion; ?>', 710, 500, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong>
            		</a>
            	</li>
            	<!--Added by Surbhi IV -->
            	<?php 
            	} ?>
            	<!--End of Added by Surbhi IV -->
            
            	<?php	
				//count totoal number of links
            	$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
						
				if($total==0)
				{
					$total='';
					$appliedLinks=$this->lang->line('txt_Links_None');
				}
				else
				{
					$appliedLinks='';
			
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
								
						$appliedLinks=substr($appliedLinks, 0, -2).""; 
					}	
							
					if(count($docTrees4)>0)
					{
						$appliedLinks.=$this->lang->line('txt_Task').': ';	
						foreach($docTrees4 as $key=>$linkData)
						{
							$appliedLinks.=$linkData['name'].", ";
						}

						$appliedLinks=substr($appliedLinks, 0, -2).""; 
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
							if($linkData['docName']=='')
							{
								$appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
							}
							else
							{
								$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
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
						$appliedLinks=substr($appliedLinks, 0, -2)."
						"; 
						
					} 
				}	
				?>
            	<!--Added by Surbhi IV -->
            	<?php if($latestVersion!=1 && !$total) {  } 
            	else 
            	{ ?>
            	<!--End of Added by Surbhi IV -->
	            	<li class="tagLinkTalkSeedLeafIcon">
	            		<a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/<?php echo $latestVersion; ?>', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" >
	            			<strong><?php echo $total; ?></strong>
	            		</a>
	            	</li>
            	<!--Added by Surbhi IV -->
            	<?php 
        		} ?>
            	<!--End of Added by Surbhi IV -->
            	<?php			
				// $leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
				$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
				/*<!--Added by Surbhi IV -->	*/
				$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);
				if(strip_tags($talk[0]->contents))
				{
					$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
					$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
				}
				else
				{
					$latestTalk='Talk';
				}
				/*<!--End of Added by Surbhi IV -->	*/
				if($total==0)
				{
			  		$total='';
				}?>
            	<!--Added by Surbhi IV -->
            	<?php if($latestVersion!=1 && !$total) {  } 
            	else 
            	{ ?>
            		<!--End of Added by Surbhi IV -->
            		<?php
					$leafdataContent=strip_tags($arrDocumentDetails['name']);
					if (strlen($leafdataContent) > 10) 
					{
   						$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
					}
					else
					{
						$talkTitle = $leafdataContent;
					}
					$leafhtmlContent=htmlentities($arrDocumentDetails['name'], ENT_QUOTES);
					?>
					<li  class="talk tagLinkTalkSeedLeafIcon">
						<a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a>
					</li>
				
					<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
					<?php
					/*<!--End of Changed title by Surbhi IV -->	*/
					?>
            		<!--Added by Surbhi IV -->
            	<?php 
            	} ?>
            	<!--End of Added by Surbhi IV -->
          	</ul>
        </span>
        <!-- tag link talk content end -->

		<!-- version content start -->
		<span class="documentSeedLeafSpanRight">
			<!-- <span class="clsLabel">
				<?php echo $this->lang->line('txt_Version');?>&nbsp;
			</span> -->
			<span class="clsLabel"><?php echo $leftVersionLink.' '.$this->lang->line('txt_Version').' '.$arrDocumentDetails['version'].' '.$rightVersionLink;?>
			</span>
		</span>
		<!-- version content end -->

        <!--dropdown content start -->
		<span class="newListSelected"  tabindex="0" style="position: relative;outline:none;">
			<div style="float:left; margin-right:0px;" class="selCont">
				<div class="selectedTxt documentSeedLeafSpanRight" onclick="showTreeOptions()">
				</div>
			 	<ul id="ulTreeOption"   style="font-style: normal;text-align:left; visibility: visible; <?php if($arrDocumentDetails['latestVersion'] == 1){echo "width: 160px;";}?> top: 19px; left: 0pt; display: none;" class="newList">
                	<?php 
					if ($workSpaceId==0)
					{
						if ($arrDocumentDetails['userId'] == $_SESSION['userId'])
						{
							$opt = 1;
						}
						else
						{
							$opt = 0;
						}
					}
					else
					{	
						$opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'],$workSpaceDetails['workSpaceId'], $workSpaceDetails['workSpaceType']);
					}
					if ($opt)
					{
					?>
                		<li>
                			<a id="aMove" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a>
                		</li>
                	<?php
					}
					?>

					<li>
						<a id="aCreateLeaf" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'create_leaf_by_folder',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_create_leaf_by_folder')?>
							
						</a>
					</li>
				
					<li>
						<a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Document');?></a>
					</li>
                	<?php
					if($arrDocumentDetails['latestVersion'] == 1 && $arrDocumentDetails['userId'] == $_SESSION['userId'])
					{
					?>
                		<li>
                			<a id="acreateVersion" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'createVersion',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Create_Version');?>
                				
                			</a>
                		</li>
                	<?php
					}
					?>
               
					<!--Manoj: Added contributor in list start-->
				
					<li>
						<a id="aContributors" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'contributors',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Contributors'); ?>
						</a>
					</li>
					<!--Manoj: Added contributor in list end-->
				
					<?php 
					//Manoj: code for showing tree data in pdf file
					$treeName['treeName']='docs';		
					$this->load->view('common/printPage',$treeName);
					//Manoj: code end
					?>
              	</ul>
            </div>
		</span>
		<!--dropdown content end -->

		<!--create date start-->
		<span class="documentSeedLeafSpanRight tagStyleNew" style="margin-right: 20px;">
			<?php echo $this->time_manager->getUserTimeFromGMTTime($arrDocumentDetails['documentCreatedDate'], $this->config->item('date_format'));?>
		</span>
		<!--create date end-->

		<!--tag name start-->
		<span class="documentSeedLeafSpanRight tagStyleNew">
			<?php echo $arrUser['userTagName'];?> 
		</span>
		<!--tag name end-->
	</div>
	<!-- footer right content end -->
</div>