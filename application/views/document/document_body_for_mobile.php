<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php

if ($value)
{			
	$strContents	= '';
	$totalRows  	= 0;
	$arrNodeOrder	= array();
	// Get information of particular document
	$allLeafIds = '';
	$allnodesOrders='';
	$rowColor1='row1';
	$rowColor2='row2';	
	$i = 1;
	$vk=0;	
	
	$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);

	foreach ($value as $leafData)
	{	
		$leafParentData = array();
		$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
		
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
				if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='' && !in_array($_SESSION['userId'], $draftResUserIds))
				{
					$prevPulishedLeafStatus = 1;
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
		if(($leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))))
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
			
		if(($leafData->nodeId1 == $this->input->get('node')) || ($leafData->leafId1 == $leafData->leafId  && $leafData->successors == '0' && !in_array($leafData->nodeOrder, $arrNodeOrder)) || $prevPulishedLeafStatus == 1)
		{

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

					if ($leafData->nodeId1 == $this->input->get('node'))
						$nodeBgColor = 'nodeBgColorSelect';
					else
					{
						$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;	
					}
				?>

<div class="clr"></div>
<div  onclick="clickDocumentOptions('<?php echo $leafData->nodeId1; ?>');" onMouseOut="hideDocumentNodeOptions('<?php echo $leafData->nodeId1; ?>');"  onmouseover="showDocumentNodeOptions('<?php echo $leafData->nodeId1; ?>');" class="<?php echo $nodeBgColor; ?> handCursor" id="docLeafContent<?php echo $leafData->nodeId1; ?>" >
  <div style="height:30px; padding-bottom:0px;" >
    <ul id="ulNodesHeader<?php echo $leafData->nodeId1; ?>" style="float:right; display:none" class="content-list ulNodesHeader">
     <?php
			if($leafData->leafStatus == 'draft')
			{
		?> 
			<li><span class="draft_txt"><?php echo $this->lang->line("txt_draft"); ?></span></li>
		<?php
			} 
		?>	 
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
             if($arrDocumentDetails['latestVersion']==1)
			 {?>
      <!-- /*End of Added by Surbhi IV*/	-->
      <li><a id="liTag<?php echo $leafData->nodeId1; ?>" class="tag" onClick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $leafData->nodeId1 ; ?>/2/<?php echo $latestVersion; ?>', 710, 420, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
      <!-- /*Added by Surbhi IV*/	-->
      <?php				
			}	
			else
			{
				if($total)
				{
				?>
      <!-- /*End of Added by Surbhi IV*/	-->
      <li><a id="liTag<?php echo $leafData->nodeId1; ?>" class="tag" onClick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $leafData->nodeId1 ; ?>/2/<?php echo $latestVersion; ?>', 710, 420, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
      <!-- /*Added by Surbhi IV*/	-->
      <?php 
				} 
			}
		/*End of Added by Surbhi IV*/	
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
				
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
							
							$appliedLinks=substr($appliedLinks, 0, -2); 
						
					}
				    /*Added by Surbhi IV*/	
					if($arrDocumentDetails['latestVersion']==1)
					{
					?>
      <!-- /*End of Added by Surbhi IV*/	-->
      <li  ><a id="liLink<?php echo $leafData->nodeId1; ?>" class="link disblock" onClick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $leafData->nodeId1; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/<?php echo  $latestVersion; ?>', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
      <!-- /*Added by Surbhi IV*/	-->
      <?php
				   }
				   else
				   { 
				      if($total)
					  {?>
      <!-- /*End of Added by Surbhi IV*/	-->
      <li  ><a id="liLink<?php echo $leafData->nodeId1; ?>" class="link disblock" onClick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $leafData->nodeId1; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/<?php echo  $latestVersion; ?>', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
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
					if($arrDocumentDetails['latestVersion']==1)
					/*End of Added by Surbhi IV*/	
					{
							echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'?talkNodeId='.$leafData->nodeId1.'\' ,\'\',\'width=850,height=500,scrollbars=yes\'); closeTalkChat('.$leafTreeId.','.$leafData->nodeId1.'); " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
					/*Added by Surbhi IV*/		
				    }
				    else
				    { 
				        if($total)
						{
				             echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'?talkNodeId='.$leafData->nodeId1.'\' ,\'\',\'width=850,height=500,scrollbars=yes\'); closeTalkChat('.$leafTreeId.','.$leafData->nodeId1.'); " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
						}
				    /*End of Added by Surbhi IV*/
				    }
                    	
					$lastnode=$arrVal['nodeId'];
					

					?>
    </ul>
    <div  style="float:right; margin-right:15px;  text-align:right; vertical-align:bottom" > 
	
	<span  id="leafOptions<?php echo $leafData->leafId1;?>" style="float:left;">
      <?php

				$headerContent='<div  id="divDocNodeVersion'.$leafData->nodeId1.'"  style="display:none" class="clsDocNodeVersion" >';
				
				/*if($leafData->leafStatus == 'draft'){ 
					
					$headerContent.='<span class="draft_txt" >'.$this->lang->line("txt_draft").'</span>';
					
				} */
				
				//if($arrDocumentDetails['latestVersion']==1 && $leafData->userId == $_SESSION['userId'] && $leafData->leafStatus == 'draft' && $leafData->successors == '0')
					$reserveImg = '';
					$resTitle = '';
					//if($leafReserveStatus==1)
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
				//if($leafParentData['parentLeafUserId']== $_SESSION['userId'])
				if(($_SESSION['userId']==$treeOriginatorId && count($draftReservedUsers)==0) || (count($draftReservedUsers)!=0))
				{
					
					$headerContent.= '<span class="reserve" ><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="Reserved User(s)" border="0" >'.$reserveImg.'</a></span>';
						
    			} 
				
				if($leafData->leafVersion <10)
				{
					$leafVersion = '00'.$leafData->leafVersion;	
				}
				else if($leafData->leafVersion >=10 && $leafData->leafVersion <100)
				{
					$leafVersion = '0'.$leafData->leafVersion;	
				}
				else
				{
					$leafVersion = $leafData->leafVersion;	
				}
				if($leafData->predecessor > 0)
				{												
					$headerContent.='<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.$leafData->nodeId1.'\')"><img src="'.base_url().'images/left.gif" border="0"> </a> '.$leafVersion;					
				}
				else
				{												
					$headerContent.=$leafVersion;
				}	
				if($leafData->successors != 0 && $prevPulishedLeafStatus !=1)
				{
					$childLeafId = $leafData->successors;		
					 											
					$headerContent.=' <a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafNext('.$leafData->leafId1.','.$childLeafId.','.$leafData->version.',\''.$leafData->leafId1.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.$leafData->nodeId1.'\')"><img src="'.base_url().'images/right.gif" border="0"></a>';													
				}
				$headerContent.='</div>';

				$strContents='
			    <span id="spanFooterLeaf'.$leafData->nodeOrder.'" align="left">';	

				$strContents.= '<div >
				<span id="leafOptionsHeader'.$leafData->nodeOrder.'">';
				
				$strContents.= ''.$headerContent.'</span></div></span>';
				echo $strContents;
				?>
      </span></div>
	  <div id="versionLoader<?php echo $leafData->nodeId1; ?>" style="float:right; margin-right:20px;"></div>
  </div>
  <div class="clr"></div>
  <div  >
    <div onClick="showNotesNodeOptions(<?php echo $leafData->nodeId1;?>);"  >
      <div  class="autoNumberContainer"  >
        <p>
          <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?>
        </p>
      </div>
      <div id='leaf_contents<?php echo $leafData->nodeId1;?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($leafData->contents); ?> </div>
      <input name="initialleafcontent<?php echo $leafData->nodeOrder;?>" id="initialleafcontent<?php echo $leafData->nodeOrder;?>" value="<?php echo htmlentities(stripslashes($leafData->contents));?>" type="hidden" />
      <div class="clr"></div>
      </div>
    <div class="clr"></div>
    <div style="height:30px;" >
      <div class="lblNotesDetails normalView"  id="normalView<?php echo $leafData->nodeId1;?>"  style="display:none">
        <div class="style2" style="float:none; text-align:left; margin: 5%;"> 
         <div id="author<?php echo $leafData->nodeId1;?>">
          <?php 
				//echo $leafData->tagName; 
				
				 if($leafData->nickName!='')
				 {
				 	echo $leafData->nickName;
				 }
				 else
				 {
				 	echo $leafData->tagName;
				 }
				
				if(strlen($leafData->tagName)>21 || strlen($leafData->nickName)>21)
		  		{
			?>
		 </div>
         <div style="margin-top: 5px;">
          <?php 
		  		}
		  			 //Start Manoj: Remove date suffix and current year
					 $Create_date=$this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format'));
					 $Create_date = explode(' ',$Create_date);
					 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
					 $current_year = date("y");
					 if($current_year == $Create_date[2])
					 {
						$Create_date[2]=" ";
					 }
					 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
					 //End Manoj: Remove date suffix
					
					 //echo $this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format')).'<br/>';
					 
					 ?>
		</div>
        </div>
        <?php 
                 if(($latestVersion == 1 && $leafData->successors == 0) || $prevPulishedLeafStatus==1 )
				{
				
				
				
				?>
       
		  
		   <!--Changed by Surbhi IV -->
          <?php 
					 if(($latestVersion == 1 && $leafData->successors == 0) || $prevPulishedLeafStatus==1 )
				     {
					 
					 ?>
          <!--/*Updated by Surbhi IV for checking version */--> 
		  <!--Manoj: Added contributor condition-->
          <span style="float:left;">&nbsp;&nbsp;<a style="margin-right:25px;" href="javascript:void(0)" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock3"';}else { echo 'class="disnone2"';} ?>  onClick="addLeafNew(<?php echo $leafData->leafId1; ?>,<?php echo $treeId ;?>,<?php echo  $leafData->nodeOrder ; ?>,'<?php echo $arrDocumentDetails["version"]; ?>')"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a></span> 
          <!--/*End of Updated by Surbhi IV for checking version */-->
          <?php 
					 }
					 ?>
          <!--End of Changed by Surbhi IV -->
		  
		  
		  <!--Manoj: Added contributor condition-->
		  <?php 
					 if($latestVersion == 1 && $leafData->successors == 0)
				     {
					 
					 ?>
		
		 <div id="editDocumentOption<?php echo $leafData->nodeId1; ?>" class="editDocumentOption <?php if (1==1) {echo "disblock2" ;}else { echo "disnone2" ; } ?> " style="float:none; margin-left: 2%;" > 
          <!--/*Updated by Surbhi IV for checking version */--> 
		    <?php if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $draftResUserIds) || ($leafData->leafStatus != 'draft' && count($draftResUserIds)==0))) 
		  {
		  	//echo 'class="disblock3"';
			//$display = 'display:block;';
			$displayClass = 'disblock3';
		  }
		  else 
		  { 
		  	//echo 'class="disnone2"';
			//$display = 'display:none;';
			$displayClass = 'disnone2';
		  } 
		  //echo $leafData->successors.'==';
		  $latestLeafClass = '';
		  if($leafData->successors==0)
		  {
		  	$latestLeafClass = 'latestLeafShow';
		  }
		  ?>
          <span>&nbsp;&nbsp;<a  style="float:right;" class="<?php echo $displayClass.' '.$latestLeafClass; ?>" href="javascript:void(0)" id="docEditBtn<?php echo $leafData->nodeId1; ?>" onClick="editLeaf(<?php echo $leafData->leafId1; ?>,<?php echo  $leafData->nodeOrder ; ?>,<?php echo $treeId ;?>,<?php echo $leafData->nodeId1;?>,'<?php echo $arrDocumentDetails["version"]; ?>','<?php echo $leafData->leafStatus; ?>','<?php echo $leafParentData['parentLeafId']; ?>')" title="<?php echo $this->lang->line('txt_Edit_this_idea'); ?>" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a></span> 
          <!--/*End of Updated by Surbhi IV for checking version */--> 
           
		   </div>
		   <?php 
					 }
					 ?>
        
        <?php
				}
				?>
      </div>
	  <!--Manoj: log for audio recorder-->
	   <pre id="log" style="margin-top:5%; display:none;"></pre>
    </div>
	<div class="clr"></div>
	<div>	
	<div class="talkformdoc">
	 <span id="addleaf<?php echo $leafData->nodeOrder;?>" style="display:none;"></span>
	</div>
	  <?php /*?><span id="editleaf<?php echo $leafData->nodeOrder;?>" style="display:none;"></span><?php */?>
	</div>
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

<div id="loader<?php echo $leafData->nodeOrder; //$leafData->nodeId1; ?>"></div>
<div id="addloader<?php echo $leafData->leafId1; ?>"></div>
<!--Manoj: edit leaf content-->
<div class="<?php echo $nodeBgColor; ?> handCursor">
<div class="talkformdoc">
<span id="editleaf<?php echo $leafData->nodeOrder;?>" style="display:none;"></span>
</div>
</div>
<?php						
			}				
			$i++;
		}
	}//End draft publish condition			
	}
	$allLeafIds = substr($allLeafIds,0,strlen($allLeafIds)-1);
	$allnodesOrders = substr($allnodesOrders,0,strlen($allnodesOrders)-1);
	?>
<input type="hidden" name="tagLinks" id="tagLinks" value="0">
<input type="hidden" id="allLeafs" value="<?php echo $allLeafIds;?>">
<input type="hidden" id="allnodesOrders" value="<?php echo $allnodesOrders;?>">
<?php 
}
?>