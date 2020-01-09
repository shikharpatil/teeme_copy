<?php
	
	//Manoj: code for adding tree data in pdf
	
	$htmlcontent .= '<style>'.file_get_contents($this->config->item('absolute_path').'css/style_new.css').'</style>';
	
	//Document tree
	
	if($treeName=='docs')
	{	
				
		$htmlcontent .='<h3>'.$seedName['name'].'</h3><div></div>'; 
		//$htmlcontent .= '<div class="user_tag">'.$arrUser['userTagName'].'  '.$this->time_manager->getUserTimeFromGMTTime($seedName['documentCreatedDate'], $this->config->item('date_format')).'</div><p></p><div class="hrline"></div><p></p>';
		
		foreach ($treeData as $leafData)
		{	
			//Add draft reserved users condition
				/*$draftPubLeafIds = $this->document_db_manager->getDraftStatusByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
				
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafData->treeIds, $leafData->nodeOrder);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafData->treeIds, $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
				
				$prevPulishedLeafStatus = '';
				if(!in_array($_SESSION['userId'], $resUserIds) && $emptyReservedList!=1)
				{
						if($draftPubLeafIds['prevPublishLeafId'] == $leafData->leafId1 && $leafData->successors > '0' && $draftPubLeafIds['prevPublishLeafId']!='')
						{
							$prevPulishedLeafStatus = 1;
						}
				}*/
				
				$nextLeafStatus = $this->document_db_manager->getNextLeafPublishStatus($leafData->treeIds, $leafData->nodeOrder, $leafData->leafId1);
				
			//Code end		
			/*if(((in_array($_SESSION['userId'], $resUserIds) || $emptyReservedList==1) && $leafData->leafStatus != 'discarded') || $leafData->leafStatus == 'publish')
			{*/
				//added leaf contents not blank condition by dashrath for deleted feature
				//if($leafData->successors == '0' || $prevPulishedLeafStatus==1)
				if((($leafData->successors == '0' && $leafData->leafStatus == 'publish') || ($leafData->successors > '0' && $leafData->leafStatus == 'publish' && $nextLeafStatus=='draft')) && ($leafData->leafStatus != 'deleted'))
				{
					//$treeContent=strip_tags($leafData->contents);
					$treeContent=strip_tags($leafData->contents, '<img>');
					$treeAllContent = strip_tags($leafData->contents, '<img><br><p>');
					
					if($treeContent=='')
					{
						preg_match_all('/<img (.+)>/', $leafData->contents, $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							//Commented by Dashrath- Add new code below for replace image width
							//$htmlcontent .= '<div>'.stripslashes($leafData->contents).'</div>';

							//Added by Dashrath- Add for replace image width
							$replaceLeafContent = str_replace('style="width: 100%;"','',$leafData->contents);
							$htmlcontent .= '<div>'.stripslashes($replaceLeafContent).'</div>';
							//Dashrath- code end
						}
						else
						{
							$treeLeafData = $this->lang->line('content_contains_only_audio_video');
							$htmlcontent .= '<div>'.stripslashes($treeLeafData).'</div>';
						}
					}	
					else
					{
						//$htmlcontent .= '<div>'.stripslashes($leafData->contents).'</div>';

						//Commented by Dashrath- Add new code below for replace image width
						// $htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';

						//Added by Dashrath- Add for replace image width
						preg_match_all('/<img (.+)>/', $treeAllContent, $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							$replaceLeafContent = str_replace('style="width: 100%;"','',$treeAllContent);
							$htmlcontent .= '<div>'.stripslashes($replaceLeafContent).'</div>';
						}
						else
						{
							$htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';
						}
						//Dashrath- code end
					}
				
					
					//$htmlcontent .= '<div>'.$leafData->tagName.'</div>';
					
					$leafTime='';
					if($leafData->editedDate[0]==0)
					{
						$leafTime=$leafData->createdDate;
					}	
					else
					{
						$leafTime=$leafData->editedDate;
					}
					//$htmlcontent .= '<div class="user_tag">'.$leafData->tagName.'   '.$this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format')).'</div><p></p><div class="hrline"></div><p></p>';
					//$htmlcontent .= '<div class="hrline"></div>';
				}
			//}//Code end
			
		}
	}
	
	//Notes,contact,chat,task Tree
	
	if($treeName=='notes' || $treeName=='contact' || $treeName=='chat' || $treeName=='task')
	{	
		if($treeName=='contact')
		{
			$htmlcontent .='<h3>'.$seedName['firstname'].' '.$seedName['lastname'].'</h3><div></div>'; 
		}
		if($treeName=='notes' || $treeName=='chat' || $treeName=='task')
		{
			$htmlcontent .='<h3>'.$seedName['name'].'</h3><div></div>'; 
		}
		if($treeName=='notes' || $treeName=='task')
		{
			//$htmlcontent .= '<div class="user_tag">'.$arrUser['tagName'].'  '.$this->time_manager->getUserTimeFromGMTTime($seedName['editedDate'], $this->config->item('date_format')).'</div><p></p><div class="hrline"></div><p></p>';
		}
		if($treeName=='chat' || $treeName=='contact')
		{
			//$htmlcontent .= '<div class="user_tag">'.$arrUser['userTagName'].'  '.$this->time_manager->getUserTimeFromGMTTime($seedName['createdDate'], $this->config->item('date_format')).'</div><p></p><div class="hrline"></div><p></p>';
		}
		
	
		foreach ($treeData as $keyVal=>$leafData)
		{	
			//Get completion status of task
		
			if($treeName=='task')
			{	
				/*Changed by Dashrath- add if condition for check delete status */
				if($leafData['leafStatus'] != 'deleted')
				{			
					$compImages 	= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
					$nodeTaskStatus = $this->task_db_manager->getTaskStatus($leafData['nodeId']);
					$htmlcontent .= '<div><table><tr><td width="2%"><img src="'.$this->config->item('base_url').'images/'.$compImages[$nodeTaskStatus].'"></td>';

				
					//$treeContent=strip_tags($leafData['contents']);
					$treeContent=strip_tags($leafData['contents'], '<img>');
					$treeAllContent = strip_tags($leafData['contents'], '<img><br><p>');
					
					if($treeContent=='')
					{
						preg_match_all('/<img (.+)>/', $leafData['contents'], $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							//Commented by Dashrath- Add new code below for replace image width
							// $htmlcontent .= '<td width="95%">'.stripslashes($leafData['contents']).'</td></tr></table></div>';

							//Added by Dashrath- Add for replace image width
							$replaceLeafContent = str_replace('style="width: 100%;"','',$leafData['contents']);
							$htmlcontent .= '<td width="95%">'.stripslashes($replaceLeafContent).'</td></tr></table></div>';
							//Dashrath- code end
						}
						else
						{
							$treeLeafData = $this->lang->line('content_contains_only_audio_video');
							$htmlcontent .= '<td width="95%">'.$treeLeafData.'</td></tr></table></div>';
						}
					}	
					else
					{
						//$htmlcontent .= '<td width="95%">'.$leafData['contents'].'</td></tr></table></div>';

						//Commented by Dashrath- Add new code below for replace image width
						// $htmlcontent .= '<td width="95%">'.stripslashes($treeAllContent).'</td></tr></table></div>';

						//Added by Dashrath- Add for replace image width
						preg_match_all('/<img (.+)>/', $treeAllContent, $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							$replaceLeafContent = str_replace('style="width: 100%;"','',$treeAllContent);
							$htmlcontent .= '<td width="95%">'.stripslashes($replaceLeafContent).'</td></tr></table></div>';
						}
						else
						{
							$htmlcontent .= '<td width="95%">'.stripslashes($treeAllContent).'</td></tr></table></div>';
						}
						//Dashrath- code end
					}
				}
				
				
			}

			if($treeName=='notes' || $treeName=='contact' || $treeName=='chat')
			{
				/*Changed by Dashrath- add if condition for check delete status */
				if($leafData['leafStatus'] != 'deleted')
				{
					//$treeContent=strip_tags($leafData['contents']);
					$treeContent=strip_tags($leafData['contents'], '<img>');
					$treeAllContent = strip_tags($leafData['contents'], '<img><br><p>');
				
					if($treeContent=='')
					{
						preg_match_all('/<img (.+)>/', $leafData['contents'], $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							//Commented by Dashrath- Add new code below for replace image width
							// $htmlcontent .= '<div>'.stripslashes($leafData['contents']).'</div>';

							//Added by Dashrath- Add for replace image width
							$replaceLeafContent = str_replace('style="width: 100%;"','',$leafData['contents']);
							$htmlcontent .= '<div>'.stripslashes($replaceLeafContent).'</div>';
							//Dashrath- code end
						}
						else
						{
							$treeLeafData = $this->lang->line('content_contains_only_audio_video');
							$htmlcontent .= '<div>'.$treeLeafData.'</div>';
						}
					}	
					else
					{
						//$htmlcontent .= '<div>'.stripslashes($leafData['contents']).'</div>';

						//Commented by Dashrath- Add new code below for replace image width
						// $htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';

						//Added by Dashrath- Add for replace image width
						preg_match_all('/<img (.+)>/', $treeAllContent, $image_matches, PREG_SET_ORDER);
						if(!empty($image_matches))
						{
							$replaceLeafContent = str_replace('style="width: 100%;"','',$treeAllContent);
							$htmlcontent .= '<div>'.stripslashes($replaceLeafContent).'</div>';
						}
						else
						{
							$htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';
						}
						//Dashrath- code end
					}
				}
				
			}

			//$userTagName = $this->identity_db_manager->getUserDetailsByUserId($leafData['userId']);
			
			//Get tree created date
			
			if($leafData['editedDate'][0]==0)
			{
				$leafTime = $leafData['createdDate'];
			}
			else
			{
				$leafTime = $leafData['editedDate'];
			}
			
			//Start time and end time for task tree
			
			if($treeName=='task')
			{
				/*Changed by Dashrath- add if condition for check delete status */
				if($leafData['leafStatus'] != 'deleted')
				{
					$arrStartTime 			= explode('-',$leafData['starttime']);
		
					$arrEndTime 			= explode('-',$leafData['endtime']);
					
					$leafData['starttime']	= $this->time_manager->getUserTimeFromGMTTime($leafData['starttime'],  $this->config->item('date_format'));
					
					$leafData['endtime'] = $this->time_manager->getUserTimeFromGMTTime($leafData['endtime'], $this->config->item('date_format'));
					
					if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
		
					{
						if($arrStartTime[0] != '00')
						{
							$htmlcontent .= '<div class="user_tag"><table width="20%"><tr><td><img src="'.$this->config->item('base_url').'images/greennew.png"/>'.$leafData['starttime'].'</td>';
						}
						if($arrEndTime[0] != '00')
						{
							 $htmlcontent .= '<td><img src="'.$this->config->item('base_url').'images/rednew.png"/>'.$leafData['endtime'].'</td></tr></table></div>';
						}
				
					}
				}	
				
			} 
			
			//Get user tag name and timestamp of all tree	
							
			//$htmlcontent .= '<div class="user_tag">'.$userTagName['userTagName'].' '.$this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format')).'</div><p></p><div class="hrline"></div><p></p>';
			
				//For sub tasks
				
				if($treeName=='task')
				{/*
			
					$checksucc 	= $this->task_db_manager->checkSuccessors($leafData['nodeId']);
					
					if($checksucc)
					{
						$counter = 0;
						$arrChildNodes = $this->task_db_manager->getChildNodes($leafData['nodeId'], $treeId);
						$sArray = $arrChildNodes;
						
						while($counter < count($sArray))
						{
							$arrDiscussions =$this->task_db_manager->getPerentInfo($sArray[$counter]);
							
							$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrDiscussions['nodeId']);
							//$htmlcontent .= '<div><img src="'.$this->config->item('base_url').'images/'.$compImages[$nodeTaskStatus].'"></div>';
							
							$treeContent=strip_tags($arrDiscussions['contents']);
				
							if($treeContent=='')
							{
								$treeLeafData = $this->lang->line('content_contains_only_image');
								$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div><table><tr><td width="2%"><img src="'.$this->config->item('base_url').'images/'.$compImages[$nodeTaskStatus].'"></td><td width="95%">'.$treeLeafData.'</td></tr></table></div>';
							}	
							else
							{
								$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div><table><tr><td width="2%"><img src="'.$this->config->item('base_url').'images/'.$compImages[$nodeTaskStatus].'"></td><td width="95%">'.$arrDiscussions['contents'].'</td></tr></table></div>';
							}
							
							
							
							//Sub task start and end time
							
							$arrStartTime = explode('-',$arrDiscussions['starttime']);

							$arrEndTime   = explode('-',$arrDiscussions['endtime']);
							
							$arrDiscussions['starttime']  = $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['starttime'], $this->config->item('date_format'));
							
							$arrDiscussions['endtime'] = $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['endtime'], $this->config->item('date_format'));
							
							if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
	
							{
								if($arrStartTime[0] != '00')
								{
									$htmlcontent .= '<div class="user_tag"><table width="20%"><tr><td><img src="'.$this->config->item('base_url').'images/greennew.png"/>'.$arrDiscussions['starttime'].'</td>';
								}
								if($arrEndTime[0] != '00')
								{
									$htmlcontent .= '<td><img src="'.$this->config->item('base_url').'images/rednew.png"/>'.$arrDiscussions['endtime'].'</td></tr></table></div>';
								}
						
							}
							//start and end time end
							
							//$htmlcontent .= '<div class="user_tag">'.$userDetails['userTagName'].' '.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['editedDate'], $this->config->item('date_format')).'</div><div class="hrline"></div></td></tr></table></div>';
							
							$counter++;
						}
						
					}
				
				*/}
			
			//Get discuss tree comments start
			
			if($treeName=='chat')
			{
				/*Changed by Dashrath- add if condition for check delete status */
				if($leafData['leafStatus'] != 'deleted')
				{
					$arrparent=  $this->chat_db_manager->getPerentInfo($leafData['nodeId']);
						
					if($arrparent['successors'])
					{
						$sArray=array();
						$sArray=explode(',',$arrparent['successors']);
						$counter=0;
						while($counter < count($sArray))
						{
							$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);
							$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
							
							/*Changed by Dashrath- add if condition for check delete status */
							if($arrDiscussions['leafStatus'] != 'deleted')
							{
								//$treeContent=strip_tags($arrDiscussions['contents']);
								$treeContent=strip_tags($arrDiscussions['contents'], '<img>');
								$treeAllContent = strip_tags($arrDiscussions['contents'], '<img><br><p>');
						
								if($treeContent=='')
								{
									preg_match_all('/<img (.+)>/', $arrDiscussions['contents'], $image_matches, PREG_SET_ORDER);
									if(!empty($image_matches))
									{
										//Commented by Dashrath- Add new code below for replace image width
										// $htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($arrDiscussions['contents']).'</div></td></tr></table></div>';

										//Added by Dashrath- Add for replace image width
										$replaceLeafContent = str_replace('style="width: 100%;"','',$arrDiscussions['contents']);
										$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($replaceLeafContent).'</div></td></tr></table></div>';
										//Dashrath- code end
									}
									else
									{
										$treeLeafData = $this->lang->line('content_contains_only_audio_video');
										$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.$treeLeafData.'</div></td></tr></table></div>';
									}
								}	
								else
								{
									//$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.$arrDiscussions['contents'].'</div></td></tr></table></div>';

									//Commented by Dashrath- Add new code below for replace image width
									// $htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($treeAllContent).'</div></td></tr></table></div>';

									//Added by Dashrath- Add for replace image width
									preg_match_all('/<img (.+)>/', $treeAllContent, $image_matches, PREG_SET_ORDER);
									if(!empty($image_matches))
									{
										$replaceLeafContent = str_replace('style="width: 100%;"','',$treeAllContent);
										$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($replaceLeafContent).'</div></td></tr></table></div>';
									}
									else
									{
										$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($treeAllContent).'</div></td></tr></table></div>';
									}
									//Dashrath- code end
								}
								
								
								//$htmlcontent .= '<div class="user_tag">'.$userDetails['userTagName'].' '.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format')).'</div><div class="hrline"></div></td></tr></table></div>';
							}
								
							$counter++;
						}
					}

				}
			
			}
			
			//discuss tree comments end
			/*Changed by Dashrath- add if condition for check delete status */
			if($leafData['leafStatus'] != 'deleted')
			{
				//$htmlcontent .= '<div class="hrline"></div>';
			}
		}
	}
	
	//Manoj: code end
	
	//Test code start
	/*print_r($htmlcontent);
	exit;*/
	//Test code end
	
	if($treeName=='contact')
	{
		$treeSeedName = $seedName['firstname'].' '.$seedName['lastname'];
	}
	if($treeName=='docs' || $treeName=='notes' || $treeName=='chat' || $treeName=='task')
	{
		$treeSeedName = $seedName['name'];
	}
	
	$fileName = strip_tags($treeSeedName);
	
	if (strlen($fileName) > 25) 
	{
		$fileName = substr($fileName, 0, 25); 
	}
	
	$fileName = $fileName.'.pdf';
	

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT,'LETTER' , true, 'UTF-8', false);    
 
   
    $pdf->SetCreator(PDF_CREATOR);
 
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
	{
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }   
 
   
    $pdf->setFontSubsetting(true);   
    $pdf->SetFont('dejavusans', '', 5, '', true);   
	
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
	$pdf->setImageScale(3);
	//$pdf->SetMargins(50, 0, 0, true);
 
    $pdf->AddPage();
	
	//$pdf->multiCell($a-lot-of-params); 
 
  
	$pdf->writeHTMLCell(0, 0, '', '', $htmlcontent, 0, 1, 0, true, '', true);   
 
    
    $pdf->Output($fileName, 'D'); 
   
?>