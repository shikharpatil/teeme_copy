<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<?php
/*echo '<pre>';
print_r($value);
exit;*/

/*$status = $this->document_db_manager->getNextLeafPublishStatus(68,1,78);
echo $status;
exit;*/

if ($value)
{			
	$strContents	= '';
	$totalRows  	= 0;
	$arrNodeOrder	= array();
	// Get information of particular document
	$allLeafIds = '';
	$allnodesOrders='';
	$rowColor1='treeLeafRowStyle';
	$rowColor2='treeLeafRowStyle';	
	$i = 1;
	$vk=0;	

	/*Added by Dashrath- use in show add icon condition*/
	$y=0;
	$inew = 1;

	$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
	foreach ($value as $leafData)
	{	
		//increment
		$y++;

		$leafParentData = array();
		$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
		
		//$leafReserveStatus = $this->document_db_manager->getLeafReserveStatus($leafData->treeIds,$leafParentData['parentLeafId']);
		$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafData->treeIds, $leafParentData['parentLeafId'],$_SESSION['userId']);
		
		$draftPubLeafIds = $this->document_db_manager->getDraftStatusByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
		
		//print_r($draftPubLeafIds);
		$draftResUserIds = array();
		$saveBtnDisable = '';
		if($leafParentData['parentLeafId'])
		{
			//$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($draftPubLeafIds['draftLeafId']);
			$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
			if(count($draftReservedUsers)>0)
			{
				$saveBtnDisable = 1;
			}
			//echo count($draftReservedUsers).'==';
			foreach($draftReservedUsers  as $draftResUserData)
			{
				$draftResUserIds[] = $draftResUserData['userId']; 
			}
		}	
		
		//Get user previous draft reservation
		$prevPulishedLeafStatus = '';
		//if(!in_array($_SESSION['userId'], $draftResUserIds) && $emptyReservedList!=1)
		if(!in_array($_SESSION['userId'], $draftResUserIds))
		{
				/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/
				// if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				// {
				// 	$prevPulishedLeafStatus = 1;
				// }

				// if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				// {
				// 	if(count($draftResUserIds)==0 && in_array($_SESSION['userId'], $contributorsUserId))
				// 	{
				// 		$prevPulishedLeafStatus = '';
				// 	}
				// 	else
				// 	{
				// 		$prevPulishedLeafStatus = 1;
				// 	}
					
				// }

				if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				{
					if($draftPubLeafIds['draftLeafUserId'] == $_SESSION['userId'])
					{
						$prevPulishedLeafStatus = '';
					}
					else
					{
						$prevPulishedLeafStatus = 1;
					}
						
				}
				
			/*$prevDraftLeafId = $this->document_db_manager->getPrevDraftDataByUserId($leafData->treeIds, $leafData->nodeOrder, $draftPubLeafIds['draftLeafId'], $_SESSION['userId'],$draftPubLeafIds['prevPublishLeafId']);
			
			if($prevDraftLeafId!='')
			{	
				if($prevDraftLeafId == $leafData->leafId1 && $leafData->successors > '0' && $prevDraftLeafId!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				{
					$prevPulishedLeafStatus = 1;
				}
			}
			else
			{
				if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				{
					$prevPulishedLeafStatus = 1;
				}
			}*/
			
		}	
		
		//echo $stats.'=='.$leafData->nodeOrder.'==='.$leafData->contents.'<br>';
		$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
		$resUserIds = array();
		foreach($reservedUsers  as $resUserData)
		{
			$resUserIds[] = $resUserData['userId']; 
		}
		//$leafData->userId == $_SESSION['userId']
		//if(($leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds) || $emptyReservedList==1)))

		/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/
		// if(($leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'deleted') || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))))

		// if(($leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'deleted') || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))) || ($leafData->leafStatus == 'draft' && count($resUserIds)==0 && (in_array($_SESSION['userId'],$contributorsUserId))))

		if(($leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'deleted') || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))) || ($leafData->leafStatus == 'draft' && $leafData->userId == $_SESSION['userId']))
		{
		$leafTime='';
		if($leafData->editedDate[0]==0)
		{
			$leafTime=$leafData->createdDate;
		}	
		else
		{
			$leafTime=$leafData->editedDate;
		}	
		//echo $leafTime; exit;	
		if(($leafData->nodeId1 == $this->input->get('node')) || ($leafData->leafId1 == $leafData->leafId  && $leafData->successors == '0' && !in_array($leafData->nodeOrder, $arrNodeOrder)) || $prevPulishedLeafStatus == 1)
		{
			//echo $prevPulishedLeafStatus.'==';
			//print_r($leafParentData);
					
			$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($leafData->treeIds);
			$showLeafObjects = '';
			if($prevPulishedLeafStatus == 1 && $leafData->leafStatus == 'draft')
			{
				$latestVersion = 0;
			}
			if($prevPulishedLeafStatus == 1 && $leafData->leafStatus == 'publish')
			{
				$showLeafObjects = 1;
			}
			//echo $prevPulishedLeafStatus.'===='.$showLeafObjects.'==';
			
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId);
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
	
			$arrNodeOrder[] = $leafData->nodeOrder;				
			$allLeafIds = $allLeafIds.$leafData->leafId1.',';
			$allnodesOrders.=$leafData->nodeOrder.',';
			if($viewOption == 'htmlView')
			{					
				$xdoc 			= new DomDocument('1.0', 'iso-8859-1');
				$tmpText		= str_replace('<o:p>','',$leafData->contents);
				$tmpText		= str_replace('</o:p>','',$tmpText);	
				$tmpText		= str_replace('<p><TABLE','<TABLE',$tmpText);
				$tmpText		= str_replace('</TABLE></p>','</TABLE>',$tmpText);
				$tmpText		= str_replace('</TABLE></p>','</TABLE>',$tmpText);
				
				$strData		= '<div id="'.$leafData->tag.'">'.htmlspecialchars_decode($tmpText).'</div>';
				$strData		= str_replace('&gt;','',$strData);	
				$strData		= str_replace('&lt;','',$strData);
				$xml 			= $xdoc->loadHTML($strData);
			
				$plainText		= $xdoc->getElementsByTagName('div')->item(0)->nodeValue;						
				$nodeVal  		= substr($xdoc->getElementsByTagName('div')->item(0)->nodeValue, 0, 700);
				?>
<?php							
				$vk = $vk+2;
				$editFocus = $vk;
				$vk = $vk+1;
				$addFocus = $vk;	
			

					//Manoj: added extra condition of nodeid for search result link
					$searchOffset = '';
					if ($leafData->nodeId1 == $this->input->get('node'))
					{
						$nodeBgColor = 'nodeBgColorSelect';
						$searchOffset = 'searchOffset';
					}
					else
					{
						$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;	
					}

				?>

<div class="clr"></div>
<div id="talk_msg_test"></div>
<div class="<?php echo $nodeBgColor; ?> handCursor <?php echo $nodeBggreenColor; ?> <?php echo $searchOffset; ?> " id="docLeafContent<?php echo $leafData->nodeId1; ?>" tabindex="0">
  <div  >
    <div onClick="showNotesNodeOptions(<?php echo $leafData->nodeId1;?>);"  >
      <div  class="autoNumberContainer autoNumberContainerNewUi">
        <p>
          <!--Commented by Dashrath- Comment this code and add new code below-->
          <!-- <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?> -->

          <!--Added by Dashrath- Add code for display numbering-->
          <?php if ($treeDetail['autonumbering']==1) 
          { 
          	if($_SESSION['document_refresh']==1)
          	{
          		echo "# ".$i;
          		// $_SESSION['autonumbering_i_value'] = $i;
          		// $_SESSION['node_i_value'.$leafData->nodeId1] = 0;
          		// $_SESSION['node_i_value_count'] = 0;
          		$_SESSION['autonumbering_i_value_'.$treeId] = $i;
          		$_SESSION['node_i_value'.$leafData->nodeId1] = 0;
          		$_SESSION['node_i_value_count_'.$treeId] = 0;
          	}
          	else
          	{
	          	if($_SESSION['node_i_value'.$leafData->nodeId1] > 0)
	          	{
	          		echo "# ".$_SESSION['node_i_value'.$leafData->nodeId1];
	          	}
	          	else
	          	{
	          		echo "# ".$inew;
	          		$inew++;
	          	}
          	}
          }
          ?>
          <!--Dashrath- code end-->

          <?php $viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $leafData->nodeId1, 2);?>
        </p>
      </div>
      <div id='leaf_contents<?php echo $leafData->nodeId1;?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" style="margin-left: 0%; margin-bottom: 15px; max-width: 100%;">
        <!-- Added by Dashrath : code start
        	check condition for check blank content for delete feature -->
	      <?php 
	      if($leafData->leafStatus !='deleted'){

	      	/*Commented old code and add new code below for audio icon show when content is audio*/
	        // echo stripslashes($leafData->contents);

	      	/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
	      	$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $leafData->contents);
	      	$audioContainsMatch2 = (bool) preg_match( '/<audio/', $leafData->contents);
	      	
	      	if($audioContainsMatch1 && $audioContainsMatch2)
	      	{
	      	?>	
	      		<span class="cursor" onclick="audioContentHideShow('<?php echo $leafData->nodeId1;?>')">
	      			<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
	      		</span>
	      		<span id='audio_contents<?php echo $leafData->nodeId1;?>' style="display: none;"><?php echo stripslashes($leafData->contents);?></span>
	      	<?php
	      	}
	      	else
	      	{
	      		echo stripslashes($leafData->contents);
	      	}
	      	/*Dashrath- code end*/
	        
	      }else{ ?>
	       <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
	      <?php } ?>
	    <!-- Dashrath : code end -->
      </div>
      <input name="initialleafcontent<?php echo $leafData->nodeOrder;?>" id="initialleafcontent<?php echo $leafData->nodeOrder;?>" value="<?php echo htmlentities(stripslashes('$leafData->contents'));?>" type="hidden" />
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
    <div>
    	<!-- document leaf footer start -->
		<div class="commonSeedFooter">
			<!-- footer left content start -->
			<div class="commonSeedFooterLeft">
		        <?php 
				if(($latestVersion == 1 && $leafData->successors == 0) || $prevPulishedLeafStatus==1 )
				{
				?>
		        	<!--/*Updated by Surbhi IV for checking version */--> 
					<!--Manoj: Added contributor condition-->
					<!--Commented by Dashrath- Add below new code with position condition-->
		          	<!-- <span class="commonSeedLeafSpanLeft"><a href="javascript:void(0)" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="addLeafIconDisBlock2"';}else { echo 'class="addLeafIconDisNone2"';} ?> onClick="addLeafNew(<?php echo $leafData->leafId1; ?>,<?php echo $treeId ;?>,<?php echo  $leafData->nodeOrder ; ?>,'<?php echo $arrDocumentDetails["version"]; ?>')">
		          		<img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a>
		          	</span>  -->
		          	<!--/*End of Updated by Surbhi IV for checking version */-->

		          	<!--Added by Dashrath- check if condition for show add icon according position-->
		          	<?php
					if (in_array($_SESSION['userId'],$contributorsUserId)) 
					{
						// if($arrDocumentDetails['position']==1)
						// {
						// 	$addIconForLeaf = 'addLeafIconDisBlock2';
						// }
						// else if($arrDocumentDetails['position']==3 || $arrDocumentDetails['position']==4)
						// {
						// 	if(count($value)==$y)
						// 	{
						// 		$addIconForLeaf = 'addLeafIconDisBlock2';
						// 	}
						// 	else
						// 	{
						// 		$addIconForLeaf = 'addLeafIconDisNone2';
						// 	}
						// }
						// else
						// {
						// 	$addIconForLeaf = 'addLeafIconDisNone2';
						// }

						if($arrDocumentDetails['position']==1)
						{
							$addIconForLeaf = 'addLeafIconDisBlock2';
						}
						else
						{
						 	$addIconForLeaf = 'addLeafIconDisNone2';
						}
				    }
			    	else
			    	{
			    		$addIconForLeaf = 'addLeafIconDisNone2';
			    	}
			    	?>

			    	<?php 
			    	if($arrDocumentDetails['position']==2)
			    	{
			    		$addIconImage = 'add_top.png';
			    		
			    	}
			    	else if($arrDocumentDetails['position']==3)
			    	{
			    		$addIconImage = 'add_bottom.png';
			    	}
			    	else
			    	{
			    		$addIconImage = 'addnew.png';
			    	}
			    	?>

			    	<span class="commonSeedLeafSpanLeft"><a href="javascript:void(0)" class="<?php echo $addIconForLeaf;?>" onClick="addLeafNew(<?php echo $leafData->leafId1; ?>,<?php echo $treeId ;?>,<?php echo  $leafData->nodeOrder ; ?>,'<?php echo $arrDocumentDetails["version"]; ?>')">
		          		<img src="<?php echo  base_url(); ?>images/<?php echo $addIconImage;?>"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a>
		          	</span>
		          	<!--Dashrath- code end -->

		          	<!--Added by Dashrath- Add this code for get last leaf node id-->
		          	<span class="lastLeafNodeId" id="<?php echo $leafData->nodeId1; ?>"></span>
		          	<!--Dashrath- code end-->

		        <?php 
				}
				?>
				<?php 
				if($latestVersion == 1 && $leafData->successors == 0 )
				{
				?>
		        	<span id="editDocumentOption<?php echo $leafData->nodeId1; ?>" class="editDocumentOption <?php if (1==1) {echo "addLeafIconDisBlock2" ;}else { echo "addLeafIconDisNone2" ; } ?> "  style="float: left; margin-left: 0%"> 

					  	<?php 
					  	/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/
					  	// if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $draftResUserIds) || ($leafData->leafStatus != 'draft' && count($draftResUserIds)==0))) 

					  	/*Commented by Dashrath- add new code below with some changes in if statement*/
					  	// if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $draftResUserIds) || ($leafData->leafStatus != 'draft' && count($draftResUserIds)==0) || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'],$contributorsUserId))))

					  	if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $draftResUserIds) || ($leafData->leafStatus != 'draft' && count($draftResUserIds)==0) || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'],$contributorsUserId) && count($draftResUserIds)==0))) 
					  	{
							$displayClass = 'disblock3';
					  	}
					 	else 
					  	{ 
							$displayClass = 'addLeafIconDisNone2';
					  	} 
				  	
					  	$latestLeafClass = '';
					  	if($leafData->successors==0)
					  	{
					  		$latestLeafClass = 'latestLeafShow';
					  	}
					  	?>
		          		<span class="commonSeedLeafSpanLeft">
		          			<a class="<?php echo $displayClass.' '.$latestLeafClass; ?>" id="docEditBtn<?php echo $leafData->nodeId1; ?>" href="javascript:void(0)" onClick="editLeaf(<?php echo $leafData->leafId1; ?>,<?php echo  $leafData->nodeOrder ; ?>,<?php echo $treeId ;?>,<?php echo $leafData->nodeId1;?>,'<?php echo $arrDocumentDetails["version"]; ?>','<?php echo $leafData->leafStatus; ?>','<?php echo $leafParentData['parentLeafId']; ?>')" title="<?php echo $this->lang->line('txt_Edit_this_idea'); ?>" >
		          				<img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0">
		          			</a>
		          		</span> 
		          		<!--/*End of Updated by Surbhi IV for checking version */--> 
		        	</span>
		        <?php
				}
				?>
				&nbsp;
			</div>
			<!-- footer left content end -->

			<!-- footer right content start -->
			<div class="commonSeedFooterRight">
				<!-- before click on move icon show content start -->
          		<span style="display: inline;" id="hideDivIcon<?php echo $leafData->leafId; ?>">
          			<span class="commonSeedLeafSpanRight">
	          			<ul id="ulNodesHeader<?php echo $leafData->nodeId1; ?>" style="float:left; margin: 0 0 0 0;" class="content-list ulNodesHeader">
							<!-- <?php
							if($leafData->leafStatus == 'draft')
							{
							?> 
								<li class="draftLi" id="draftTxt<?php echo $leafData->nodeId1;?>">
									<span class="draft_txt"><?php echo $this->lang->line("txt_draft"); ?>
									</span>
								</li>
							<?php
							} 
							?> -->

							<?php
							$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $leafData->nodeId1, 2);
							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'],$leafData->nodeId1, 2);
							$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $leafData->nodeId1, 2);
							$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'],$leafData->nodeId1, 2);	
							$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 1, 2);
							$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 2, 2);
							$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 3, 2);
							$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 4, 2);
							$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 5, 2);
							$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 6, 2);
							$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($leafData->nodeId1, 2);

							/*Added by Dashrath- used for display linked folder count*/
							$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($leafData->nodeId1, 2);
							/*Dashrath- code end*/
								
						
							$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($leafData->nodeId1, 2);	
					
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
									$tag_container.=$simpleTag['tagName'].", ";
									$tag_container=substr($tag_container, 0, -2)."
									";  
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

				 			/*Added by Surbhi IV*/			
	             			if($arrDocumentDetails['latestVersion']==1 && ($prevPulishedLeafStatus !=1 || $showLeafObjects==1))
				 			{
				 			?>
	      						<!-- /*End of Added by Surbhi IV*/	-->
	      						<li class="tagLinkTalkSeedLeafIcon">
	      							<a id="liTag<?php echo $leafData->nodeId1; ?>" class="tag" onClick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $leafData->nodeId1 ; ?>/2/<?php echo $latestVersion; ?>', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong>
	      							</a>
	      						</li>
	      						<!-- /*Added by Surbhi IV*/	-->
	      					<?php				
							}	
							else
							{
								if($total)
								{
								?>
	      							<!-- /*End of Added by Surbhi IV*/	-->
	      							<li class="tagLinkTalkSeedLeafIcon">
	      								<a id="liTag<?php echo $leafData->nodeId1; ?>" class="tag" onClick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $leafData->nodeId1 ; ?>/2/<?php echo $latestVersion; ?>', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong>
	      								</a>
	      							</li>
	      							<!-- /*Added by Surbhi IV*/	-->
	      						<?php 
								} 
							}
							/*End of Added by Surbhi IV*/

							/*Changed by Dashrath- add $docTrees10 for total*/
							$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);
					
							$appliedLinks=' ';
					
							if($total==0)
							{
								$total='';
								$appliedLinks=$this->lang->line('txt_Links_None') ;
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
									$appliedLinks .=$this->lang->line('txt_Files').': ';	
									foreach($docTrees7 as $key=>$linkData)
								    {
										if($linkData['docName']=='')
										{
										    $appliedLinks.=$this->lang->line('txt_Files')."_v".$linkData['version'].", ";
										}
										else
										{
											/*Changed by Dashrath- Comment old code and add new below after changes */
										 	// $appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
										 	$appliedLinks.=$linkData['docName'].", ";
										}
									}

									$appliedLinks=substr($appliedLinks, 0, -2)."
									"; 
								}

								/*Added by Dashrath- used for display linked folder name*/
								if(count($docTrees10)>0)
								{
									$appliedLinks .=$this->lang->line('txt_Folders').': ';	
									foreach($docTrees10 as $key=>$linkData)
								    {
										if($linkData['folderName']!='')
										{
										  
										 	$appliedLinks.=$linkData['folderName'].", ";
										}
									}

									$appliedLinks=substr($appliedLinks, 0, -2)."
									"; 
								}
								/*Dashrath- code end*/		
								
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
								
								$appliedLinks=substr($appliedLinks, 0, -2); 
							
							}

					    	/*Added by Surbhi IV*/	
							if($arrDocumentDetails['latestVersion']==1 && ($prevPulishedLeafStatus !=1 || $showLeafObjects==1))
							{
							?>
	      						<!-- /*End of Added by Surbhi IV*/	-->
	      						<li class="tagLinkTalkSeedLeafIcon">
	      							<a id="liLink<?php echo $leafData->nodeId1; ?>" class="link disblock" onClick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $leafData->nodeId1; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/<?php echo  $latestVersion; ?>', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong>
	      							</a>
	      						</li>
	      						<!-- /*Added by Surbhi IV*/	-->
	      					<?php
					   		}
					   		else
					   		{ 
					      		if($total)
						  		{
						  		?>
	      							<!-- /*End of Added by Surbhi IV*/	-->
	      							<li class="tagLinkTalkSeedLeafIcon">
	      								<a id="liLink<?php echo $leafData->nodeId1; ?>" class="link disblock" onClick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $leafData->nodeId1; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/<?php echo  $latestVersion; ?>', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong>
	      								</a>
	      							</li>
	      							<!-- /*Added by Surbhi IV*/	-->
	      						<?php 
					      		}
					  		}

					  		/*End of Added by Surbhi IV*/	
					    	$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
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

							if($total==0)
							{
								$total='';
							}
						
							/*Added by Surbhi IV*/
							if($arrDocumentDetails['latestVersion']==1 && ($prevPulishedLeafStatus !=1 || $showLeafObjects==1))
							/*End of Added by Surbhi IV*/	
							{
								$leafdataContent=strip_tags($leafData->contents);
								if (strlen($leafdataContent) > 10) 
								{
										$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
								}
								else
								{
									$talkTitle = $leafdataContent;
								}
								$leafhtmlContent=htmlentities($leafData->contents, ENT_QUOTES);
								?>
								<li  class="talk tagLinkTalkSeedLeafIcon"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $leafData->nodeId1; ?>',2, 1)" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
								<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
							<?php
							/*Added by Surbhi IV*/		
						    }
						    else
						    { 
						        if($total)
								{
									$leafdataContent=strip_tags($leafData->contents);
									if (strlen($leafdataContent) > 10) 
									{
		   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
									}
									else
									{
										$talkTitle = $leafdataContent;
									}
									$leafhtmlContent=htmlentities($leafData->contents, ENT_QUOTES);
									?>
									<li  class="talk tagLinkTalkSeedLeafIcon">
										<a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $leafData->nodeId1; ?>',2, 1)" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a>
									</li>
									<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
								<?php  
								}
						    	/*End of Added by Surbhi IV*/
						    }
		                    	
							$lastnode=$arrVal['nodeId'];
							?>		
						</ul>
					</span>

					<!-- copy button start-->
					<span class="commonSeedLeafSpanRight" id="copyLeafSpan<?php echo $leafData->nodeId1;?>">
						<a href="javascript:void(0)" onClick="newLeafCopy('<?php echo $leafData->leafId; ?>')" title="<?php echo $this->lang->line('txt_copy'); ?>" border="0" >
							<img src="<?php echo  base_url(); ?>images/copy_icon_new.png" alt="<?php echo $this->lang->line("txt_copy"); ?>" title="<?php echo $this->lang->line("txt_copy"); ?>" border="0">
						</a>
					</span>
					<!-- copy button start-->

					<!-- move button start-->
					<span class="commonSeedLeafSpanRight" id="moveLeafSpan<?php echo $leafData->nodeId1;?>">
					<?php 
					if((count($value) > 1) && ($leafData->userId == $_SESSION['userId'])) 
					{?>
						
						<a href="javascript:void(0)" onClick="newLeafMove('<?php echo $leafData->leafId; ?>',<?php echo $leafTreeId?>)" title="<?php echo $this->lang->line('txt_move'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/move_icon_new.png" alt="<?php echo $this->lang->line("txt_move"); ?>" title="<?php echo $this->lang->line("txt_move"); ?>" border="0">
						</a>
						
					<?php 
					} 
					?>
					</span>
					<!-- move button end-->

					<!-- delete button start-->
	          		<span class="commonSeedLeafSpanRight" id="deleteLeafSpan<?php echo $leafData->nodeId1;?>">
					<?php 
					if(($leafData->leafStatus != 'deleted') && ($leafData->userId == $_SESSION['userId']))
					{ 
					?>
						
						<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $leafData->leafId; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
						</a>
						
					<?php 
					} 
					?>
					</span>
					<!-- delete button end-->
          		
	          		<!-- <div  style="float:right; margin-right:0px;  text-align:right; vertical-align:bottom" >  -->
		
					<!-- <span  id="leafOptions<?php echo $leafData->leafId1;?>"> -->
					<span>
	  				<?php

						// $headerContent='<div  id="divDocNodeVersion'.$leafData->nodeId1.'"  style="display:inline" class="clsDocNodeVersion" >';
					
						$reserveImg = '';
						$resTitle = '';
						
						if(count($draftReservedUsers)==0)
						{
							$reserveImg = '<img src="'.base_url().'images/emptyReserve.png" border="0">';
							$resTitle = 'Unreserved';
						}
						else
						{
							$reserveImg = '<img src="'.base_url().'images/reserve.png" border="0">';
							$resTitle = 'Reserved';
						}
						
						if(($_SESSION['userId']==$treeOriginatorId && count($draftReservedUsers)==0) || (count($draftReservedUsers)!=0))
						{
							$display = 'display:block;';
						}
						else
						{
							$display = 'display:none;';
						}
						$reserveHeaderContent = '<span class=" commonSeedLeafSpanRight" ><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="'.$resTitle.'" border="0" style="'.$display.'" >'.$reserveImg.'</a></span>';

						$headerContent='<span class="commonSeedLeafSpanRight" id="divDocNodeVersion'.$leafData->nodeId1.'"  style="display:inline" class="clsDocNodeVersion" >';
						
						if($leafData->leafVersion <10)
						{
							//$leafVersion = '00'.$leafData->leafVersion;
							$leafVersion = $leafData->leafVersion;		
						}
						else if($leafData->leafVersion >=10 && $leafData->leafVersion <100)
						{
							//$leafVersion = '0'.$leafData->leafVersion;
							$leafVersion = $leafData->leafVersion;		
						}
						else
						{
							$leafVersion = $leafData->leafVersion;	
						}

						if($leafData->predecessor > 0)
						{	
							if($leafData->leafStatus=='draft')
							{											
								$headerContent.='<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.$leafData->nodeId1.'\')"><img src="'.base_url().'images/left.gif" border="0" style="margin-bottom: 2px;"> </a> <span class="clsLabel" style="font-style: normal; "></span>';
							}
							else
							{
								$headerContent.='<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.$leafData->nodeId1.'\')"><img src="'.base_url().'images/left.gif" border="0" style="margin-bottom: 2px;"> </a> <span class="clsLabel" style="font-style: normal; ">&nbsp;&nbsp;Version '.$leafVersion.'</span>';
							}					
						}
						else
						{	
							if($leafData->leafStatus=='draft')
							{											
								$headerContent.= '<span class="clsLabel" style="font-style: normal;"></span>';
							}
							else
							{
								$headerContent.= '<span class="clsLabel" style="font-style: normal;">Version '.$leafVersion.'</span>';
							}
						}

						if($leafData->successors != 0 && $prevPulishedLeafStatus !=1)
						{
							$childLeafId = $leafData->successors;		
							 											
							$headerContent.='&nbsp;&nbsp;<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafNext('.$leafData->leafId1.','.$childLeafId.','.$leafData->version.',\''.$leafData->leafId1.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.$leafData->nodeId1.'\')"><img src="'.base_url().'images/right.gif" style="margin-bottom: 2px;" border="0"></a>';													
						}

						$headerContent.='</span>';

						$strContents='<span id="spanFooterLeaf'.$leafData->nodeOrder.'" align="left">';	

						$strContents.= '<div ><span id="leafOptionsHeader'.$leafData->nodeOrder.'">';
					
						$strContents.= ''.$headerContent.'</span></div></span>';

						//echo $strContents;

						// echo $reserveHeaderContent;
						?>
	      			</span>
	      			<!-- </div> -->

	      			<!-- show reserved or unreserved button start-->
	          		<span id="reservedUnreserved<?php echo $leafData->nodeId1;?>">
	          		<?php 

	          			/*Commented by Dashrath- comment if condition for show R icon for all user and all status*/
	          			//if($_SESSION['userId'] == $treeOriginatorId || $leafData->leafStatus != 'publish')
	      				// {
	          			// 		echo $reserveHeaderContent;
	          			//}

	          			echo $reserveHeaderContent;
	          			
	          			
	          		?>
	          		</span>
	          		<!-- show reserved or unreserved button end -->

	          		<!-- Draft text show start-->
	          		<span id="draftTxt<?php echo $leafData->nodeId1;?>" class="draft_txt commonSeedLeafSpanRight">
          			<?php
					if($leafData->leafStatus == 'draft')
					{
					?> 
						<?php echo $this->lang->line("txt_draft"); ?>
					<?php
					} 
					?>
					</span>
	          		
	          		<!-- Draft text show end-->

	          		<!-- version text start-->
	          		
	          		<span id="leafOptions<?php echo $leafData->leafId1;?>">
	          			<?php echo $strContents; ?>
	          		</span>
	          		
	          		<!-- version text end-->


	      			<div id="versionLoader<?php echo $leafData->nodeId1; ?>" style="float:right; margin-right:20px;"></div>

	          		

					
		
					<!-- create date start-->
	          		<span id="dateTime<?php echo $leafData->nodeId1;?>" class="commonSeedLeafSpanRight tagStyleNew">
	          			<?php 
						 	echo $this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format')).'<br/>';
						?>
	          		</span>
	          		<!-- create date end-->

	          		<!-- tag name start-->
					<span id="author<?php echo $leafData->nodeId1;?>" class="commonSeedLeafSpanRight tagStyleNew"> 	  <?php 
						if($leafData->nickName!='')
						{
						 	echo $leafData->nickName;
						}
						else
						{
						 	echo $leafData->tagName;
						}		 
						?>
	          		</span>
	          		<!-- tag name end-->

	      			
	          	</span>
	          	<!-- before click on move icon show content end -->

          		<!-- move leaf message content start -->
          		<span style="float:right; display: none;" id="showMoveMessage<?php echo $leafData->leafId; ?>" class="commonSeedLeafSpanRight">
  					Select position to move &nbsp;&nbsp; 
  					<a href="javascript:void(0)" style="text-decoration:none" onclick="clearLeafMoveData('<?php echo $leafData->leafId; ?>')"  title="<?php echo $this->lang->line('txt_cancel_move'); ?>" border="0"><?php echo $this->lang->line('txt_cancel_move'); ?>
  						
  					</a>
				</span>	
				<!-- move leaf message content end -->

				<!--Manoj: log for audio recorder-->
	  			<pre id="log" style="margin-top:5%; display:none;"></pre>

			</div>
			<!-- footer right content end -->

		</div>
		<!-- document leaf footer end -->
    </div>

<!--Commented by Dashrath- comment editor code and shift below for open editor outside of leaf-->
<!-- <div class="talkformdoc">
    <span id="addleaf<?php echo $leafData->nodeOrder;?>" style="display:none;"></span>
</div> -->

    <?php
				#******************************* * * * * * * * * * * * * * * Tags * * * * * * * * ************************************************88
							
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;
				?>
    <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>"> </span>
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
    <div class="divEditLaef" >
      <div id="addleaf<?php echo $position;?>" style="display:none;"></div>
    </div>
    <div class="clr"></div>
  </div>
</div>

<!--Dashrath- shift this code from above for editor open outside of leaf-->
<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
<div class="talkformdoc handCursor">
    <span id="addleaf<?php echo $leafData->nodeOrder;?>" style="display:none;" class="addLeafEditor"></span>
</div>
<!--Dashrath- code end-->

<div id="loader<?php echo $leafData->nodeOrder; //$leafData->nodeId1; ?>"></div>
<div id="addloader<?php echo $leafData->leafId1; ?>"></div>
<!--Manoj: edit leaf content-->
<div class="treeLeafRowStyle2 handCursor">
<span id="leafPasteLoader<?php echo $leafData->leafId;?>"></span>
<div class="talkformdoc">
<!-- Added by Dashrath- Add div for leaf edit autofocus-->
<div id="leafAutoFocus<?php echo $leafData->nodeOrder;?>"  tabindex="0">
<span id="editleaf<?php echo $leafData->nodeOrder;?>" style="display:none;"></span>
</div>
</div>
</div>
<!-- <hr style="height: 1px;  border: none; background-color: #c6c6c6;" /> -->
<?php						
			}				
			$i++;
		}		
	}//End draft publish condition
	}
	$allLeafIds = substr($allLeafIds,0,strlen($allLeafIds)-1);
	$allnodesOrders = substr($allnodesOrders,0,strlen($allnodesOrders)-1);
	?>

	<?php
	/*Added by Dashrath- used in auto numbering dispaly logic*/
	$_SESSION['document_refresh'] = 0;
	/*Dashrath- code end*/
	?>

<input type="hidden" name="tagLinks" id="tagLinks" value="0">
<input type="hidden" id="allLeafs" value="<?php echo $allLeafIds;?>">
<input type="hidden" id="allnodesOrders" value="<?php echo $allnodesOrders;?>">
<?php 
}
?>
