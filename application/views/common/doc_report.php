<?php
error_reporting(0);

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
	
$fileName = str_replace(' ', '_', $fileName);

$fileName = $fileName.'.doc';

header("Content-type: application/vnd.ms-word; charset=utf-8");
header("Content-Disposition: attachment;Filename=".$fileName);
//header("Pragma: no-cache");
//header("Expires: 0");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body style='font-family:Helvetica, Arial, sans-serif; font-size:0.8em;'>";
//style='font-family:Helvetica, Arial, sans-serif; font-size:0.8em;'
//echo "<link href='http://localhost/bugs_teeme/css/style_new.css' rel='stylesheet' type='text/css'/>";

//Get tree content


	if($treeName=='docs')
	{	
				
		$htmlcontent .='<h3>'.$seedName['name'].'</h3><div></div>'; 
		
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
							$htmlcontent .= '<div>'.stripslashes($leafData->contents).'</div>';
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
						$htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';
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
					
					//$htmlcontent .= '<hr>';
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
							$htmlcontent .= '<td width="95%">'.stripslashes($leafData['contents']).'</td></tr></table></div>';
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
						$htmlcontent .= '<td width="95%">'.stripslashes($treeAllContent).'</td></tr></table></div>';
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
							$htmlcontent .= '<div>'.stripslashes($leafData['contents']).'</div>';
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
						$htmlcontent .= '<div>'.stripslashes($treeAllContent).'</div>';
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
										$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($arrDiscussions['contents']).'</div></td></tr></table></div>';
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
									$htmlcontent .= '<div><table><tr><td width="3%"></td><td width="96%"><div>'.stripslashes($treeAllContent).'</div></td></tr></table></div>';
								}
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
				//$htmlcontent .= '<hr>';
			}
		}
	}
	
	//Manoj: code end

//Create image full path 
$doc = new DOMDocument();
$baseUrl=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$doc->loadHTML($htmlcontent);
$tags = $doc->getElementsByTagName('img');
foreach ($tags as $tag) {
	$old_src = $tag->getAttribute('src');
	
	//encode image code start
	/*$image_parts = explode(";base64,", $old_src);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
	$image = imagecreatefromstring($image_base64);*/
	//encode image code end
	
	$url = parse_url($old_src);
	if($url['scheme'] != 'https' && $url['scheme'] != 'http'){
	   $new_src_url = $baseUrl.''.$old_src;
	   $tag->setAttribute('src', $new_src_url);
	}
}
$htmlcontent = $doc->saveHTML();

//Code end

//echo htmlentities($htmlcontent, ENT_QUOTES | ENT_IGNORE, "UTF-8");

echo preg_replace("/&#?[a-z0-9]+;/i","",$htmlcontent); 


echo "</body>";
echo "</html>";
?>