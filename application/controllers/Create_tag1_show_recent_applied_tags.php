<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/

	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_tag.php
	* Description 		  	: A class file used to add the tag details to database
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/tag/tag.php,models/tag/request_tag.php, models/dal/tag_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 27-11-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/

class Create_tag1 extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the page create  the teeme workspace
	
	function index()
	{		 		
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
		  
		   
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;				
			$objIdentity->updateLogin();				
			$this->load->model('identity/work_space_members');
			$objWorkSpaceMembers = $this->work_space_members;
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;		
			$this->load->model('tag/tag');			
			$this->load->model('tag/sequence_tag');
						
			$workPlaceId  = $_SESSION['workPlaceId'];	
			
			$artifactId		= $this->input->post('artifactId');
			$artifactType 	= $this->input->post('artifactType');
			//echo "artifactid = " .$artifactId; exit;
			$sequence		= $this->input->post('sequence');
			$sequenceOrder	= $this->input->post('sequenceOrder');
			$sequenceTagId 	= $this->input->post('sequenceTagId');
			$workSpaceId	= $this->input->post('workSpaceId');	
			$workSpaceType	= $this->input->post('workSpaceType');	
			$tagOption		= $this->input->post('tagOption');			
			$ownerId		= $_SESSION['userId'];
			//$tagType		= $this->input->post('tagType');
			//$tag			= $this->input->post('tag');
			$tagComments	= $this->input->post('tagComments');
			$tagCreatedDate	= $this->time_manager->getGMTTime();
			//echo "today= " .date('Y-m-d H:i:s');	exit;
			//echo "datem= " .date('m'); exit;
			$monthDays		= cal_days_in_month( CAL_GREGORIAN, date('m'), date('y') );
			$wDay			= date('w');
			if($this->input->post('updateStatus') == 1)
			{
				$tagOrders 	= $this->input->post('tagOrders');
				$tagIds		= $this->input->post('tagIds');	
				$tmpTagArray = array();
				for($i=0;$i<count($tagOrders);$i++)
				{					
					$tmpTagArray[$tagIds[$i]] = $tagOrders[$i]; 						
				}
				asort($tmpTagArray);
				$i = 1;
				foreach($tmpTagArray as $key=>$val)
				{
					$this->tag_db_manager->updateSequenceOrder($key, $i);
					$i++;
				}
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption.'/2', 'location');					
			}
			if($tagOption	!= 2 &&  $tagOption	!= 1 &&  $tagOption	!= 4 && $tagOption	!= 5 && $tagOption	!= 6)
			{	
				if( $_POST['actionDate'] == 0 )
				{
					//$this->input->post( 'startTime' );
					//$startTime = explode(' ',$this->input->post( 'startTime' ));
					//$tagStartTime 	= $startTime[0].' 00:00:00';	
					//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));	
					$tagStartTime	= date('Y-m-d H:i:s');	
					//if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					if(trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime = $tagStartTime;
						//$tagEndTime 	= $startTime[0].' 23:59:00';		
					}	
						
					//$tagStartTime	= $this->time_manager->getGMTTimeFromUserTime( $startTime1, 'Y-m-d H:i:s' );		
					//$tagEndTime		= $this->time_manager->getGMTTimeFromUserTime( $endTime, 'Y-m-d H:i:s' );									
				}
				else if( $_POST['actionDate'] == 1 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s');	
					//$this->input->post( 'startTime' );				
					//if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					if(trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));				
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d'),date('Y')));	
						//echo "tagendtime= " .$tagEndTime; exit;	
					}			
				}
				else if( $_POST['actionDate'] == 2 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s');				
					//if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					if(trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+1,date('Y')));	
					}			
				}
				else if($_POST['actionDate'] == 3)
				{	
					$tagStartTime	= date('Y-m-d H:i:s');		
					if($wDay == 1)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-0,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+6,date('Y')));
					}
					else if($wDay == 2)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-1,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+5,date('Y')));
					}		
					else if($wDay == 3)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-2,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+4,date('Y')));
					}	
					else if($wDay == 4)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-3,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+3,date('Y')));
					}	
					else if($wDay == 5)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-4,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+2,date('Y')));
					}	
					else if($wDay == 6)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-5,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+1,date('Y')));
					}		
					else if($wDay == 0)
					{
						//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-6,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+0,date('Y')));
					}																							
					//$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));				
					//if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					if(trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
						
					}	
					else
					{
						//$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+$wDay,date('Y')));
						$tagEndTime		= $tagEndTime;
					}
				}
				else if($_POST['actionDate'] == 4)
				{					
					$tagStartTime	= date('Y-m-d H:i:s');				
					//if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					if(trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23, 59, 0,date('m'), $monthDays, date('Y')));
						//echo "tagendtime= " .$tagEndTime; exit;
					}
				}
				
				else if($_POST['actionDate'] == 5)
				{					
					$tagStartTime	= date('Y-m-d H:i:s');			
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23, 59, 0, 12, $monthDays, date('Y')));
					}
				}		
			}
			if($tagOption	== 1) // User Tags - Not used anymore
			{
				$addOption = $this->input->post('addOption');
				if($addOption == 'apply')
				{
					$objTag	= $this->tag;
					$tag	= $this->input->post('tag');					
					$objTag->setTagOwnerId( $ownerId );				
					$objTag->setTagType( $tagOption );
					$objTag->setTag( $tag );				
					$objTag->setTagArtifactId( $artifactId );
					$objTag->setTagArtifactType( $artifactType );	
					$objTag->setTagCreatedDate( $tagCreatedDate );	
					$objTag->setTagStartTime( $tagStartTime );	
					$objTag->setTagEndTime( $tagEndTime );	
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );				
					$objTagManager->insertRecord( $objTag );	
					$_SESSION['errorMsg'] = $this->lang->line('msg_time_tag_apply');			
				}
				else if($addOption == 'new')
				{	
					$tagType = $this->input->post('tag');							
					$objTagManager->insertTagType( $tagOption, $tagType, $workPlaceId );	
					$_SESSION['errorMsg'] = $this->lang->line('msg_time_tag_add');			
				}
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');					
			}							
			if($tagOption	== 2) // Simple Tags
			{   
				$simpleTagStartTime = '0000-00-00 00:00:00';
				$simpleTagEndTime = '0000-00-00 00:00:00';
			
				$status = 'true';
				$unAppliedTags = $this->input->post('unAppliedTags');
				$unAppliedTags = explode(',',$unAppliedTags);
				
				$unChecked = $this->input->post('unChecked');
				$unChecked = explode(',',$unChecked);
				
				
				$sectionTagIds = $this->input->post('sectionTagIds');
				$sectionTagIds2 = array();
				$sectionTagIds2 = explode(',',$sectionTagIds);

				//$appliedTagIds = array();
				//$appliedTagIds = explode(',',$this->input->post('appliedTags'));
				
				//arun
				$tags = $this->tag_db_manager->getTags(2, $_SESSION['userId'], $_POST['artifactId'], $_POST['artifactType']);
				if(count($tags) > 0)
				{
					foreach($tags as $tagData)
					{
						$appliedTagIds[] = $tagData['tag'];
					}
				}
				// close arun
				$sectionChecked = array();
				$sectionChecked = explode(',',$this->input->post('sectionChecked'));

				$addOption = $this->input->post('addOption');	
               
				$recentAppliedTags = array();
				if($addOption == 'update')
				{   
					$objTag	= $this->tag;
					//$tag	= $this->input->post('tag');
					//$arrTags = explode(',',$tag);
					
					foreach($unAppliedTags as $key=>$value)
					{	 			
						$tag = $value;
						//$temp.=$key."ss";
                        
						if (!in_array($tag,$appliedTagIds))
						{
							//echo "<li>tag= " .$tag;
							$objTag->setTagOwnerId( $ownerId );				
							$objTag->setTagType( $tagOption );
							$objTag->setTag( $tag );				
							$objTag->setTagArtifactId( $artifactId );
							$objTag->setTagArtifactType( $artifactType );	
							$objTag->setTagCreatedDate( $tagCreatedDate );	
							$objTag->setTagStartTime( $simpleTagStartTime );	
							$objTag->setTagEndTime( $simpleTagEndTime );
							$objTag->setSequenceTagId( $sequenceTagId );	
							$objTag->setSequenceOrder( $sequenceOrder );
							$objTagManager->insertRecord( $objTag );
							
							$recentAppliedTags[]=$this->tag_db_manager->getTagName(2,$tag);
							
							
						}
					}
					
					
					$recentUnAppliedTags=array();
					// get Tag name which are recently unchecked 			
					foreach($unChecked as $key=>$value)
					{					
						$tag = $value;

						if ((!empty($tag)) && (in_array($tag,$appliedTagIds)))
						{
							$recentUnAppliedTags[]=$this->tag_db_manager->getTagName(2,$tag);
							
						}
					}
					
					//close code here

					foreach($sectionTagIds2 as $key=>$value)
					{					
						$tag = $value;

						if ((!empty($tag)) && (in_array($tag,$unChecked)))
						{
							
							//echo "fordeletetag = " .$tag;
							$objTagManager->deleteTag( $tag, $artifactId,$artifactType );
						}
					}	
					
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $_POST['artifactId'],  $_POST['artifactType']);
					
					$dispViewTags='';
					$tagAvlStatus = 0;				
					if(count($viewTags) > 0)
					{
						$tagAvlStatus = 1;	
						foreach($viewTags as $tagData)
						{													
							$dispViewTags .= $tagData['tagName'].', ';						 
						}
					}
		
		$treeId=$this->input->post('treeId');	
		//$_SESSION['errorMsg']="Simple tag applied succesfully";
		
		$_SESSION['errorMsg']='';
		if(count($recentAppliedTags)>0 || count($recentUnAppliedTags)>0 )
		{
					if(count($recentAppliedTags)>0)
			{	
				$_SESSION['errorMsg'] .=$this->lang->line('txt_Applied_Tags')." : ";
				$_SESSION['errorMsg'] .= implode(",", $recentAppliedTags)."<br/>";
				//$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
			}
			if(count($recentUnAppliedTags)>0)
			{	
				$_SESSION['errorMsg'] .=$this->lang->line('txt_Un_Applied_Tags')." : ";
				$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
				//$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
			}
		}
		else
		{
		      $_SESSION['errorMsg'] .= $this->lang->line('Error_msg_simple_tags');
		}		

		$this->countAllTagsByTreeId($treeId,$workSpaceId,$workSpaceType,$artifactId,$artifactType); 
				
		$_SESSION['errorMsg']='';				
				}			
				if($addOption == 'apply')
				{
					$objTag	= $this->tag;
					$tag	= $this->input->post('tag');
					$arrTags = explode(',',$tag);
					foreach($arrTags as $tag)
					{					
						$objTag->setTagOwnerId( $ownerId );				
						$objTag->setTagType( $tagOption );
						$objTag->setTag( $tag );				
						$objTag->setTagArtifactId( $artifactId );
						$objTag->setTagArtifactType( $artifactType );	
						$objTag->setTagCreatedDate( $tagCreatedDate );	
						$objTag->setTagStartTime( $simpleTagStartTime );	
						$objTag->setTagEndTime( $simpleTagEndTime );
						$objTag->setSequenceTagId( $sequenceTagId );	
						$objTag->setSequenceOrder( $sequenceOrder );				
						$objTagManager->insertRecord( $objTag );
						
					}								
				}
				else if($addOption == 'new')
				{	 
					$tagType = $this->input->post('tag');
												
					if (!($objTagManager->insertTagType($tagOption, $tagType, $workPlaceId )))
					{
						$status = 'false';						
					}
				
				if ($status=='true')
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_view_tag_add');				
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_already_exist');		
				}
				
			$count = '';
			$str='';
			$viewTags2 = $this->tag_db_manager->getTagsByCategoryId2(2);
			$appliedTagIds = array();
			if(count($tags) > 0)
			{
				foreach($tags as $tagData)
				{
					$appliedTagIds[] = $tagData['tag'];
				}
			}
			foreach($viewTags2 as $tagData)	
			{
				if (in_array($tagData['tag'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tag'];
				
				if (in_array($tagData['tag'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tag'];
 				} 
				
				if (in_array($tagData['tag'],$appliedTagIds))
				{
				$str.='<input type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" checked="checked"/>'.$tagData['tagName'].'<br />';
				 
				}
				else
				{
				$str.='<input type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" />'.$tagData['tagName'].'<br />';
				}
			
				}
        	}
			//$count = '';
			//$sectionChecked = '';
			foreach($viewTags2 as $tagData)	
			{
				if (!in_array($tagData['tag'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tag'];
				
				if (in_array($tagData['tag'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tag'];
 				} 
				if (in_array($tagData['tag'],$appliedTagIds)) 
				{
				$str.='<input type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" checked="checked"/>'.$tagData['tagName'].'<br />';
				}
				else
				{
				$str.='<input type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" />'.$tagData['tagName'].'<br />';
				}
				
			
				}
				
				
        	}
			
			echo $str."|||@||".$_SESSION['errorMsg'];	
			
			$_SESSION['errorMsg']='';
        	}
				
				
			
							
			}
			elseif($tagOption	== 3) // Response Tags
			{
			   
				$addOption = $this->input->post('addOption'); 
				$tagType = $this->input->post('tagType');
				$tagId = $this->input->post('editTagId');
				$tag = $this->input->post('tagType');
             
				if($addOption == 'edit')
				{      
						
						$objTag	= $this->tag;	
						$objTag->setTagId ($tagId);			
						$objTag->setTagOwnerId( $ownerId );				
						$objTag->setTagType( $tagOption );			
						$objTag->setTag( $tag );
						$objTag->setTagComments( $tagComments );
						$objTag->setTagArtifactId( $artifactId );
						$objTag->setTagArtifactType( $artifactType );	
						$objTag->setTagCreatedDate( $tagCreatedDate );	
						$objTag->setTagStartTime( $tagStartTime );	
						$objTag->setTagEndTime( $tagEndTime );		
						$objTag->setSequenceTagId( $sequenceTagId );	
						$objTag->setSequenceOrder( $sequenceOrder );
						//echo "here"; exit;
						$objTagManager->updateRecord( $objTag );
						
						if ($tagType==2)
						{

							$this->load->model('tag/selection_tag');	
							$selectionOptions = $this->input->post('selectionOptions');	
							$selectionOptions = explode(",",$selectionOptions);
							//echo "tagid= " .$tagId; exit;
							$this->tag_db_manager->deleteSelectionOptionsByTagId($tagId);
							foreach( $selectionOptions as $selectionOption )
							{
								if(trim($selectionOption) != '')
								{		
									$objSelection	= $this->selection_tag;	
									$objSelection->setTagId( $tagId );	
									$objSelection->setSelectionOption( $selectionOption );	
									$objTagManager->updateRecord( $objSelection );	
								}
							}
								
						}
						
						if($tagType == 3)
						{
							$this->load->model('tag/vote_tag');	
							$objVote	= $this->vote_tag;
							$objVote->setTagId($tagId);	
							$objVote->setVotingTopic($this->input->post('voteQuestion'));	
							$objTagManager->updateRecord( $objVote );					
						}
					
						$this->load->model('tag/tagged_users');	
						$this->tag_db_manager->deleteTaggedUsersByTagId($tagId);
						$taggedUsers=$this->input->post('taggedUsers',true);
						if($taggedUsers!='')
						{
							$taggedUsers=explode(",",$taggedUsers);
						}
							
						if(count($taggedUsers) > 0 && !in_array(0,$taggedUsers))
						{		
							if (in_array($_SESSION['userId'],$taggedUsers))
							{
									$objTaggedUsers = $this->tagged_users;
									$objTaggedUsers->setTagId( $tagId );
									$objTaggedUsers->setTaggedUserId($_SESSION['userId']);					
									$objTagManager->updateRecord( $objTaggedUsers );									
							}		
							foreach($taggedUsers as $userIds)
							{
								
								if ($userIds != $_SESSION['userId'])
								{
									$objTaggedUsers = $this->tagged_users;
									$objTaggedUsers->setTagId( $tagId );
									$objTaggedUsers->setTaggedUserId( $userIds );					
									$objTagManager->updateRecord( $objTaggedUsers );		
								}
							}
						}
						else if(count($taggedUsers) > 0 && in_array(0,$taggedUsers))
						{
							if($this->input->post('workSpaceId') == 0)
							{	
							
								if ($artifactType==2) // if leaf
								{
									$treeId = $objIdentity->getTreeIdByNodeId_identity ($artifactId);
								}
								else //if tree
								{
									$treeId = $artifactId;
								}
							
								$workPlaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
								$sharedMembers	 = $objIdentity->getSharedMembersByTreeId($treeId);
								$workSpaceMembers = array();
								foreach($workPlaceMembers as $userData)
								{
									if (in_array($userData['userId'],$sharedMembers))
									{
										$workSpaceMembers[] = $userData; 
									}		

								}	
								//$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							}
							else
							{			
								if($this->input->post('workSpaceType') == 1)
								{	
									$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
								}
								else
								{	
									$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
								}
							}					
							foreach($workSpaceMembers as $userData)
							{
								$objTaggedUsers = $this->tagged_users;
								$objTaggedUsers->setTagId( $tagId );
								$objTaggedUsers->setTaggedUserId( $userData['userId'] );					
								$objTagManager->updateRecord( $objTaggedUsers );		
							}
						}
						else if(count($taggedUsers) == 0)
						{					
							$objTaggedUsers = $this->tagged_users;
							$objTaggedUsers->setTagId( $tagId );
							$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
							$objTagManager->updateRecord( $objTaggedUsers );					
						}
			
					$_SESSION['errorMsg'] = $this->lang->line('msg_act_tag_edit');	
	               
					$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);	
			
			$str='';
			foreach($tags as $tagData)	
			{  
				$count .= ',' .$tagData['tagId'];
				
				if (in_array($tagData['tagId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagId'];
 				} 
				$dateNow = date('Y-m-d H:i:s');
				if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
				{
			
				
			   /*
			   <input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tagId'];?>" <?php //if (in_array($tagData['tagId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['comments'];?>&nbsp;<a href="javaScript:void(0)" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,<?php echo $tagData['tagId'];?>)" title="Edit"><?php echo $this->lang->line('txt_Edit');?></a><br />
			   */
				
				$str.='<input type="checkbox" name="unAppliedTagsActionDelete" value="'.$tagData['tagId'].'" />'.$tagData['comments'].'&nbsp<a href="javaScript:void(0)" onclick="edit_action_tag('. $workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','. $sequenceTagId.','.$tagOption.','.$tagData['tagId'].')" title="Edit">'.$this->lang->line('txt_Edit').'</a><br />';
				
				}
        	}

			if (!$tags)
			{

				$str.= $this->lang->line('txt_None');
			}
        	
			echo $str.='|||@||'.$_SESSION['errorMsg'];	
			$_SESSION['errorMsg']='';
			 die;	
				} // End Edit
				
						
				//echo "here"; exit;
				$unAppliedTags = $this->input->post('unAppliedTags');
				$sectionTagIds = $this->input->post('sectionTagIds');
				$sectionTagIds2 = array();
				$sectionTagIds2 = explode(',',$sectionTagIds);
				

				$appliedTagIds = array();
				$appliedTagIds = explode(',',$this->input->post('appliedTags'));
				
				$sectionChecked = array();
				$sectionChecked = explode(',',$this->input->post('sectionChecked'));
				
				
/*				echo "<li>Already applied= ";
				print_r ($appliedTagIds);
								echo "<li>Newly applied= ";
				print_r ($unAppliedTags);
								echo "<li>Sections= ";
				print_r ($sectionTagIds2);
				
								echo "<li>SectionChecked= ";
				print_r ($sectionChecked);
				
				exit;*/
				
				
				//echo "<li>addoptions= " .count($unAppliedTags); exit;
					
				
				if($addOption == 'update')
				{  
				
					$unAppliedTags = $this->input->post('unAppliedTags');
					$unAppliedTags = explode(',',$unAppliedTags);
					$objTag	= $this->tag;
					//print_r($unAppliedTags);die;
					//print_r($sectionChecked);die;
					foreach($sectionChecked as $key=>$value)
					{					
						$tag = $value;
                        
						if ((!empty($tag)) && (in_array($tag,$unAppliedTags)))
						{
							//echo "fordeletetag = " .$tag;
							$objTagManager->deleteResponseTag( $tag );
						}
					}
					
					$_SESSION['errorMsg'] = $this->lang->line('msg_act_tag_deleted');
					
					$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);	
			
			$str='';
			foreach($tags as $tagData)	
			{  
				$count .= ',' .$tagData['tagId'];
				
				if (in_array($tagData['tagId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagId'];
 				} 
				$dateNow = date('Y-m-d H:i:s');
				if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
				{
			
				
			   /*
			   <input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tagId'];?>" <?php //if (in_array($tagData['tagId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['comments'];?>&nbsp;<a href="javaScript:void(0)" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,<?php echo $tagData['tagId'];?>)" title="Edit"><?php echo $this->lang->line('txt_Edit');?></a><br />
			   */
				
				$str.='<input type="checkbox" name="unAppliedTagsActionDelete" value="'.$tagData['tagId'].'" />'.$tagData['comments'].'&nbsp<a href="javaScript:void(0)" onclick="edit_action_tag('. $workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','. $sequenceTagId.','.$tagOption.','.$tagData['tagId'].')" title="Edit">'.$this->lang->line('txt_Edit').'</a><br />';
				
				}
        	}

			if (!$tags)
			{

				$str.= $this->lang->line('txt_None');
			}
        	
			echo $str.='|||@||'.$_SESSION['errorMsg'];	 die;		
				}

				//$_SESSION['errorMsg'] = $this->lang->line('msg_contact_tag_add');	
				//redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							

				$tag	= $this->input->post('tag');				
							
				if($tag != 4 && $tag!='')
				{
					$objTag	= $this->tag;				
					$objTag->setTagOwnerId( $ownerId );				
					$objTag->setTagType( $tagOption );			
					$objTag->setTag( $tag );
					$objTag->setTagComments( $tagComments );
					$objTag->setTagArtifactId( $artifactId );
					$objTag->setTagArtifactType( $artifactType );	
					$objTag->setTagCreatedDate( $tagCreatedDate );	
					$objTag->setTagStartTime( $tagStartTime );	
					$objTag->setTagEndTime( $tagEndTime );		
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );	
					$objTagManager->insertRecord( $objTag );
					$tagId = $this->db->insert_id();					
					if($this->input->post('tag') == 2)
					{
						$this->load->model('tag/selection_tag');	
						$selectionOptions = $this->input->post('selectionOptions');	
						foreach( $selectionOptions as $selectionOption )
						{
							if(trim($selectionOption) != '')
							{		
								$objSelection	= $this->selection_tag;	
								$objSelection->setTagId( $tagId );	
								$objSelection->setSelectionOption( $selectionOption );	
								$objTagManager->insertRecord( $objSelection );	
							}
						}									
					}		
					if($this->input->post('tag') == 3)
					{
						$this->load->model('tag/vote_tag');	
						$objVote	= $this->vote_tag;
						$objVote->setTagId($tagId);	
						$objVote->setVotingTopic($this->input->post('voteQuestion'));	
						$objTagManager->insertRecord( $objVote );					
					}	
				}
				//echo "<li>tag= " .$this->input->post('tag') ."<li>sequence= " .$this->input->post('sequence')."<li>sequenceid= " .$sequenceTagId; exit;
				if($this->input->post('tag') == 4 && $this->input->post('sequence') == 0 && $sequenceTagId == 0)
				{		
				//echo "here1"; exit;		
					$sequenceOrder = 1;
					$objSequenceTag = $this->sequence_tag;
					$objSequenceTag->setSequenceTagCreatedDate( $tagCreatedDate );
					$objSequenceTag->setUserId( $_SESSION['userId'] );
					$objTagManager->insertRecord( $objSequenceTag );
					$sequenceTagId = $this->db->insert_id();	
					$objTag	= $this->tag;				
					$objTag->setTagOwnerId( $ownerId );				
					$objTag->setTagType( $tagOption );			
					$objTag->setTag( $tag );
					$objTag->setTagComments( $tagComments );
					$objTag->setTagArtifactId( $artifactId );
					$objTag->setTagArtifactType( $artifactType );	
					$objTag->setTagCreatedDate( $tagCreatedDate );	
					$objTag->setTagStartTime( $tagStartTime );	
					$objTag->setTagEndTime( $tagEndTime );		
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );	
					$objTagManager->insertRecord( $objTag );
					$tagId = $this->db->insert_id();							
				}
				else if($this->input->post('tag') == 4 && $this->input->post('sequence') == 1 && $sequenceTagId >= 0)
				{
					//echo "here2"; exit;
					$updStatus = 0;
					$sequenceOrder = $this->input->post('sequenceOrder');						
					$objTag	= $this->tag;				
					$objTag->setTagOwnerId( $ownerId );				
					$objTag->setTagType( $tagOption );			
					$objTag->setTag( $tag );
					$objTag->setTagComments( $tagComments );
					$objTag->setTagArtifactId( $artifactId );
					$objTag->setTagArtifactType( $artifactType );	
					$objTag->setTagCreatedDate( $tagCreatedDate );	
					$objTag->setTagStartTime( $tagStartTime );	
					$objTag->setTagEndTime( $tagEndTime );		
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );	
					$objTagManager->insertRecord( $objTag );
					$tagId = $this->db->insert_id();			
					//echo "tagid= " .$tagId; exit;			
				}	
				/*else if($this->input->post('sequence') == 1 && $sequenceTagId > 0 && $this->input->post('tagType') == 0)
				{
					redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/1', 'location');	
				}*/
				/*else if($this->input->post('sequence') == 0 && $sequenceTagId == 0)
				{
					$updStatus = 1;
					$tagSequenceOrder = $this->input->post('sequenceOrder');
				}*/
				
				
				$this->load->model('tag/tagged_users');	
				$taggedUsers=$this->input->post('taggedUsers',true);
				if($taggedUsers!='')
				{
					$taggedUsers=explode(",",$taggedUsers);
				}	
				
				
				if(count($taggedUsers) > 0 && !in_array(0,$taggedUsers))
				{			
					foreach($taggedUsers as $userIds)
					{ 
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userIds );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($taggedUsers) > 0 && in_array(0,$taggedUsers))
				{ 
					if($this->input->post('workSpaceId') == 0)
					{	
							if ($artifactType==2) // if leaf
							{
								$treeId = $objIdentity->getTreeIdByNodeId_identity ($artifactId);
							}
							else //if tree
							{
								$treeId = $artifactId;
							}
							
							$workPlaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							$sharedMembers	 = $objIdentity->getSharedMembersByTreeId($treeId);
							$workSpaceMembers = array();
								foreach($workPlaceMembers as $userData)
								{
									if (in_array($userData['userId'],$sharedMembers))
									{
										$workSpaceMembers[] = $userData; 
									}		

								}
						//$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					}
					else
					{			
						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userData['userId'] );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($taggedUsers) == 0)
				{					
					$objTaggedUsers = $this->tagged_users;
					$objTaggedUsers->setTagId( $tagId );
					$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
					$objTagManager->insertRecord( $objTaggedUsers );					
				}				
				$_SESSION['errorMsg'] = $this->lang->line('msg_act_tag_add');		
			
				
			$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);	
			
			$str='';
			foreach($tags as $tagData)	
			{  
				$count .= ',' .$tagData['tagId'];
				
				if (in_array($tagData['tagId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagId'];
 				} 
				$dateNow = date('Y-m-d H:i:s');
				if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
				{
			
				
			   /*
			   <input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tagId'];?>" <?php //if (in_array($tagData['tagId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['comments'];?>&nbsp;<a href="javaScript:void(0)" onclick="edit_action_tag(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType; ?>,<?php echo $sequenceTagId; ?>,<?php echo $tagOption;?>,<?php echo $tagData['tagId'];?>)" title="Edit"><?php echo $this->lang->line('txt_Edit');?></a><br />
			   */
				
				$str.='<input type="checkbox" name="unAppliedTagsActionDelete" value="'.$tagData['tagId'].'" />'.$tagData['comments'].'&nbsp<a href="javaScript:void(0)" onclick="edit_action_tag('. $workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','. $sequenceTagId.','.$tagOption.','.$tagData['tagId'].')" title="Edit">'.$this->lang->line('txt_Edit').'</a><br />';
				
				}
        	}

			if (!$tags)
			{

				$str.= $this->lang->line('txt_None');
			}
        	
			echo $str.='|||@||'.$_SESSION['errorMsg']; 
			
			$_SESSION['errorMsg']='';
			
			die;
				
				//old code
				//redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');					
	
			}	
			elseif($tagOption	==  4)
			{			
				$objTag	= $this->tag;		
				$tag	= $this->input->post('tag');					
				$objTag->setTagOwnerId( $ownerId );				
				$objTag->setTagType( $tagOption );			
				$objTag->setTag( $tag );
				$objTag->setTagComments( $tagComments );							
				$objTag->setTagArtifactId( $artifactId );
				$objTag->setTagArtifactType( $artifactType );	
				$objTag->setTagCreatedDate( $tagCreatedDate );	
				$objTagManager->insertRecord( $objTag );
				$tagId = $this->db->insert_id();
				if($tag == 0)
				{
					$taskCreateDate	= $this->input->post('startTime');	
					$objTagManager->insertCreateTagDate( $tagId, $taskCreateDate );
				}
				$this->load->model('tag/tagged_users');	
				if(count($taggedUsers) > 0 && !in_array(0,$taggedUsers))
				{				
					foreach($taggedUsers as $userIds)
					{
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userIds );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($taggedUsers) > 0 && in_array(0,$taggedUsers))
				{
					if($this->input->post('workSpaceId') == 0)
					{		
							if ($artifactType==2) // if leaf
							{
								$treeId = $objIdentity->getTreeIdByNodeId_identity ($artifactId);
							}
							else //if tree
							{
								$treeId = $artifactId;
							}
							
							$workPlaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							$sharedMembers	 = $objIdentity->getSharedMembersByTreeId($treeId);
							$workSpaceMembers = array();
								foreach($workPlaceMembers as $userData)
								{
									if (in_array($userData['userId'],$sharedMembers))
									{
										$workSpaceMembers[] = $userData; 
									}		

								}
						//$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					}
					else
					{		
						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userData['userId'] );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($taggedUsers) == 0)
				{					
					$objTaggedUsers = $this->tagged_users;
					$objTaggedUsers->setTagId( $tagId );
					$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
					$objTagManager->insertRecord( $objTaggedUsers );					
				}				
				$_SESSION['errorMsg'] = $this->lang->line('msg_create_tag_add');	
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}	
			elseif($tagOption	== 5) // Contact Tags
			{			
			     
				$contactTagStartTime = '0000-00-00 00:00:00';
				$contactTagEndTime = '0000-00-00 00:00:00';
				
				$unAppliedTags = $this->input->post('unAppliedTags');
				$unAppliedTags = explode(',',$unAppliedTags);
				$sectionTagIds = $this->input->post('sectionTagIds');
				$sectionTagIds2 = array();
				$sectionTagIds2 = explode(',',$sectionTagIds);
				
				$unChecked = $this->input->post('unChecked');
				$unChecked = explode(',',$unChecked);
				

				$appliedTagIds = array();
				$appliedTagIds = explode(',',$this->input->post('appliedTags'));
				
				$sectionChecked = array();
				$sectionChecked = explode(',',$this->input->post('sectionChecked'));
				
/*				echo "<li>Already applied= ";
				print_r ($appliedTagIds);
								echo "<li>Newly applied= ";
				print_r ($unAppliedTags);
								echo "<li>Sections= ";
				print_r ($sectionTagIds2);
				
								echo "<li>SectionChecked= ";
				print_r ($sectionChecked);
				
				exit;*/
				
				
				//echo "<li>addoptions= " .count($unAppliedTags); exit;
				$addOption = $this->input->post('addOption');
				
				
				/* **********
				$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $_SESSION['artifactId'], $_SESSION['artifactType']);
			
			$viewTags2 = array(); 
$viewTags2 = $this->tag_db_manager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);			
$appliedTagIds = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTagIds[] = $tagData['tag'];
	}
}
//echo count($viewTags2); exit;
$allTags = array();
$allTags = array_merge ($tags,$viewTags2);
			
				
			$count = '';
			$sectionChecked = '';
			foreach($viewTags2 as $tagData)	
			{
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			
				}
        	}
			foreach($viewTags2 as $tagData)	
			{
				if (!in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			
				}
        	}
        	 
			 */
			
			 
			 $tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $_POST['artifactId'], $_POST['artifactType']);
				if(count($tags) > 0)
				{
					foreach($tags as $tagData)
					{
						$appliedTagIds[] = $tagData['tag'];
					}
				}
				
				$recentAppliedTags = array();	
				if($addOption == 'update')
				{
					$objTag	= $this->tag;
					//$tag	= $this->input->post('tag');
					//$arrTags = explode(',',$tag);
					
					foreach($unAppliedTags as $key=>$value)
					{					
						$tag = $value;
						
						if (!in_array($tag,$appliedTagIds))
						{
							//echo "<li>tag= " .$tag;
							$objTag->setTagOwnerId( $ownerId );				
							$objTag->setTagType( $tagOption );
							$objTag->setTag( $tag );				
							$objTag->setTagArtifactId( $artifactId );
							$objTag->setTagArtifactType( $artifactType );	
							$objTag->setTagCreatedDate( $tagCreatedDate );	
							$objTag->setTagStartTime( $contactTagStartTime );	
							$objTag->setTagEndTime( $contactTagEndTime );
							$objTag->setSequenceTagId( $sequenceTagId );	
							$objTag->setSequenceOrder( $sequenceOrder );
							$objTagManager->insertRecord( $objTag );
							
							$recentAppliedTags[]=$this->tag_db_manager->getTagName(5,$tag);
						}
					}	
					//$sectionChecked=array();
					//print_r($unAppliedTags);die;
					//print_r($sectionTagIds);die;
					
					
					// get Tag name which are recently unchecked 
					$recentUnAppliedTags=array();			
					foreach($unChecked as $key=>$value)
					{					
						$tag = $value;

						if ((!empty($tag)) && (in_array($tag,$appliedTagIds)))
						{
							$recentUnAppliedTags[]=$this->tag_db_manager->getTagName(5,$tag);
							
						}
					}
					
					//close code here
					
					
					foreach($unChecked as $key=>$value)
					{					
						 $tag = $value;
						
                       
						if ((!empty($tag)))
						{  
							//echo "fordeletetag = " .$tag; die;
							$objTagManager->deleteTag( $tag,$artifactId,$artifactType );
						}
						
					}		
						
				}
			
//				$objTag	= $this->tag;		
//				$tag	= $this->input->post('tag');
//				$arrTags = explode(',',$tag);
				/*$arrTag	= $this->input->post('tag');	*/
//				if(count($arrTags) > 0)
//				{
//					foreach($arrTags as $tag)
//					{		
//						$objTag->setTagOwnerId( $ownerId );				
//						$objTag->setTagType( $tagOption );			
//						$objTag->setTag( $tag );						
//						$objTag->setTagArtifactId( $artifactId );
//						$objTag->setTagArtifactType( $artifactType );	
//						$objTag->setTagCreatedDate( $tagCreatedDate );							
//						$objTag->setSequenceTagId( $sequenceTagId );	
//						$objTag->setSequenceOrder( $sequenceOrder );	
//						$objTagManager->insertRecord( $objTag );
//						$tagId = $this->db->insert_id();
//						$this->load->model('tag/tagged_users');	
						/*if(count($taggedUsers) > 0 && !in_array(0,$taggedUsers))
						{				
							foreach($taggedUsers as $userIds)
							{
								$objTaggedUsers = $this->tagged_users;
								$objTaggedUsers->setTagId( $tagId );
								$objTaggedUsers->setTaggedUserId( $userIds );					
								$objTagManager->insertRecord( $objTaggedUsers );		
							}
						}
						else if(count($taggedUsers) > 0 && in_array(0,$taggedUsers))
						{
							if($this->input->post('workSpaceId') == 0)
							{		
								$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							}
							else
							{			
								if($this->input->post('workSpaceType') == 1)
								{	
									$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
								}
								else
								{	
									$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
								}
							}					
							foreach($workSpaceMembers as $userData)
							{
								$objTaggedUsers = $this->tagged_users;
								$objTaggedUsers->setTagId( $tagId );
								$objTaggedUsers->setTaggedUserId( $userData['userId'] );					
								$objTagManager->insertRecord( $objTaggedUsers );		
							}
						}
						else if(count($taggedUsers) == 0)
						{*/					
//						$objTaggedUsers = $this->tagged_users;
//						$objTaggedUsers->setTagId( $tagId );
//						$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
//						$objTagManager->insertRecord( $objTaggedUsers );					
						//}				
					//}	
				//}
				//$_SESSION['errorMsg'] = $this->lang->line('msg_contact_tag_add');	
				
				$_SESSION['errorMsg']='';
		if(count($recentAppliedTags)>0 || count($recentUnAppliedTags)>0 )
		{
					if(count($recentAppliedTags)>0)
			{	
				$_SESSION['errorMsg'] .=$this->lang->line('txt_Applied_Tags')." : ";
				$_SESSION['errorMsg'] .= implode(",", $recentAppliedTags)."<br/>";
				//$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
			}
			if(count($recentUnAppliedTags)>0)
			{	
				$_SESSION['errorMsg'] .=$this->lang->line('txt_Un_Applied_Tags')." : ";
				$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
				//$_SESSION['errorMsg'] .= implode(",", $recentUnAppliedTags);
			}
		}
		else
		{
		      $_SESSION['errorMsg'] .= $this->lang->line('Error_msg_contact_tags');
		}	
				
			$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $artifactId, $artifactType);	
			$viewTags2 = array(); 
			$viewTags2 = $this->tag_db_manager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);			
			$appliedTagIds = array();
			if(count($tags) > 0)
			{
				foreach($tags as $tagData)
				{
					$appliedTagIds[] = $tagData['tag'];
				}
			}	
			$sectionChecked = '';
			foreach($viewTags2 as $tagData)	
			{
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			?>
				
				<input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagType'];?><br />

			<?php
				}
        	}
			foreach($viewTags2 as $tagData)	
			{
				if (!in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			?>
				
				<input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagType'];?><br />

			<?php
				}
        	}
        
        	
			echo $str.='|||@||'.$_SESSION['errorMsg'];	
			$_SESSION['errorMsg']='';	
				
				//old_code
				//redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}	
			elseif($tagOption	== 6)
			{			
				$objTag		= $this->tag;					
				$tag	= $this->input->post('tag');
				$arrUsers = explode(',',$tag);
				
				if(!empty($arrUsers))
				{
					foreach($arrUsers as $tag)
					{		
						$objTag->setTagOwnerId( $ownerId );				
						$objTag->setTagType( $tagOption );			
						$objTag->setTag( $tag );						
						$objTag->setTagArtifactId( $artifactId );
						$objTag->setTagArtifactType( $artifactType );	
						$objTag->setTagCreatedDate( $tagCreatedDate );							
						$objTag->setSequenceTagId( $sequenceTagId );	
						$objTag->setSequenceOrder( $sequenceOrder );	
						$objTagManager->insertRecord( $objTag );											
					}	
				}
				else	
				{
					$objTag->setTagOwnerId( $ownerId );				
					$objTag->setTagType( $tagOption );			
					$objTag->setTag( $_SESSION['userId'] );						
					$objTag->setTagArtifactId( $artifactId );
					$objTag->setTagArtifactType( $artifactType );	
					$objTag->setTagCreatedDate( $tagCreatedDate );							
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );	
					$objTagManager->insertRecord( $objTag );		
				}
				$_SESSION['errorMsg'] = $this->lang->line('msg_user_tag_add');	
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}				
		}
	}
	
	
	//function for conuting all tages of tree by treeId
 public function countAllTagsByTreeId($treeId,$workSpaceId,$workSpaceType,$artifactId,$artifactType)
 {
        
 		$this->load->model("dal/tag_db_manager");
 		$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'],  $artifactId, $artifactType);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'],  $artifactId, $artifactType);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'],  $artifactId, $artifactType);
		
		if((count($viewTags)+count($actTags)+count($contactTags)+count($userTags))>0)
		{	
			
			if(count($viewTags)>0)
			{		 
						       
				$tag_container.='Simple Tag : <span>';
				
				 foreach($viewTags as $simpleTag)
				 $tag_container.=$simpleTag['tagName'].", ";
				 
				 $tag_container.='</span><br/>';
			}
			
				 
		 
		 		
							
			if(count($actTags) > 0)
			{
				$tag_container.='Action Tag : <span>';
				$tagAvlStatus = 1;	
				foreach($actTags as $tagData)
				{	$dispResponseTags='';
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
										
					$dispResponseTags .= '], ';
					
					$tag_container.=$dispResponseTags;
				}
				$tag_container.='</span><br/>';
			}
			
			$tag_container.='<div id="actionTagResponse"></div>';
			if(count($contactTags) > 0)
				{
				    $tag_container.='Contact Tag : <span>';
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						//$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';	
						
						$tag_container .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';	
						
													
					}
					 $tag_container.='</span><br>';
				}		
		
		 
		
		 
		 }
		else
		{
		 	$tag_container.= $this->lang->line('txt_None');
		} 
		echo count($viewTags)+count($actTags)+count($contactTags)+count($userTags).'|||@||'.$tag_container.'|||@||'.$_SESSION['errorMsg'];
		
		
		$_SESSION['errorMsg']='';
		
 }	
 
 	//a.function lock tag view 
   function setFlagForTagView()
   {
   
   			if($_SESSION['tagFlag']==1)
			{
			   echo "false";
			}
			else
			{
				$_SESSION['tagFlag']=1;
				echo "true";
			}
   }
   
    function resetFlagForTagView()
   {
		$_SESSION['tagFlag']=0;
			
   }
   
   //a.function lock tag view 
   function setFlagForLinkView()
   {
   
   			if($_SESSION['linkFlag']==1)
			{
			   echo "false";
			}
			else
			{
				$_SESSION['linkFlag']=1;
				echo "true";
			}
   }
   
    function resetFlagForLinkView()
   {
		$_SESSION['linkFlag']=0;
			
   }
   
   
   	//function for conuting all tages of tree by treeId
 public function countTagsAndLinks($artifactId,$artifactType)
 {
         
		 
 		$this->load->model("dal/tag_db_manager");
		$this->load->model("dal/identity_db_manager");
 		$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'],  $artifactId, $artifactType);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'],  $artifactId, $artifactType);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'],  $artifactId, $artifactType);
		
		$totalTags=count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
		
		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 1, $artifactType);
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 2, $artifactType);
		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 3, $artifactType);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 4, $artifactType);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 5, $artifactType);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 6, $artifactType);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($artifactId, $artifactType);	
		
		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($artifactId, $artifactType);	
		
		$totalLinks=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
		
		echo $totalTags.'|||@||'.$totalLinks;
		
		
 }	
 
 function setTagsAndLinksInTitle($artifactId,$artifactType)
 {
 
 		$this->load->model("dal/tag_db_manager");
		$this->load->model("dal/identity_db_manager");
 		$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'],  $artifactId, $artifactType);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'],  $artifactId, $artifactType);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'],  $artifactId, $artifactType);
		
		$totalTags=count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
		
		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 1, $artifactType);
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 2, $artifactType);
		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 3, $artifactType);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 4, $artifactType);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 5, $artifactType);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($artifactId, 6, $artifactType);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($artifactId, $artifactType);	
		
		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($artifactId, $artifactType);	
		
		
		// get  tags
		
		
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
											 $appliedLinks.=strip_tags($linkData['name']).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
									}	
									
									
									 if(count($docTrees3)>0)
								   {
										$appliedLinks.=$this->lang->line('txt_Chat').': ';	
										foreach($docTrees3 as $key=>$linkData)
									   {
											 $appliedLinks.=strip_tags($linkData['name']).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
									}	
									
									if(count($docTrees4)>0)
									{
									
										$appliedLinks.=$this->lang->line('txt_Task').': ';	
										foreach($docTrees4 as $key=>$linkData)
									   {
											 $appliedLinks.=strip_tags($linkData['name']).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
									}	
									
									if(count($docTrees6)>0)
									{
										$appliedLinks.=$this->lang->line('txt_Notes').': ';	
										foreach($docTrees6 as $key=>$linkData)
									   {
											 $appliedLinks.=strip_tags($linkData['name']).", ";
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
									}
									
									if(count($docTrees5)>0)
									{
									
										$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
										foreach($docTrees5 as $key=>$linkData)
									   {
											 $appliedLinks.=strip_tags($linkData['name']).", ";
											
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
												$appliedLinks=substr($appliedLinks, 0, -2);
											
											}
								}
		
		
		echo $tag_container.'|||@||'.$appliedLinks;
		
		
		
 
 }
   
 	
}
?>