<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_tag2.php
	* Description 		  	: A class file used to add the tag details to database
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/tag/tag.php,models/tag/request_tag.php, models/dal/tag_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 20-01-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Create_tag2 extends CI_Controller 
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
			$objWorkSpaceMembers	= $this->work_space_members;
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;		
			$this->load->model('tag/tag');			
			$this->load->model('tag/sequence_tag');
						
			$workPlaceId  = $_SESSION['workPlaceId'];	
			
			$artifactId		= $this->input->post('artifactId');
			$artifactType 	= $this->input->post('artifactType');
			$sequence		= $this->input->post('sequence');
			$sequenceOrder	= $this->input->post('sequenceOrder');
			$sequenceTagId 	= $this->input->post('sequenceTagId');
			$workSpaceId	= $this->input->post('workSpaceId');	
			$workSpaceType	= $this->input->post('workSpaceType');	
			$tagOption		= $this->input->post('tagOption');			
			$ownerId		= $_SESSION['userId'];
		
			$tagComments	= $this->input->post('tagComments');
			$tagCreatedDate	= $this->time_manager->getGMTTime();
			$monthDays		= cal_days_in_month( CAL_GREGORIAN, 11, 2008 );
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
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption.'/2', 'location');					
			}
			if($tagOption	!= 2 &&  $tagOption	!= 1 &&  $tagOption	!= 4 && $tagOption	!= 5 && $tagOption	!= 6)
			{	
			#***************************** Date **********************************************************8
				if( $_POST['actionDate'] == 0 )
				{
					$this->input->post( 'startTime' );
					$startTime = explode(' ',$this->input->post( 'startTime' ));
					$tagStartTime 	= $startTime[0].' 00:00:00';		
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime 	= $startTime[0].' 23:59:00';		
					}	
						
		
				}
				else if( $_POST['actionDate'] == 1 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));
					$this->input->post( 'startTime' );				
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));				
						$tagEndTime		= $endTime[0].' 23:59:00';	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d'),date('Y')));		
					}			
				}
				else if( $_POST['actionDate'] == 2 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')+1,date('Y')));				
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
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
					if($wDay == 1)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-0,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+6,date('Y')));
					}
					else if($wDay == 2)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-1,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+5,date('Y')));
					}		
					else if($wDay == 3)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-2,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+4,date('Y')));
					}	
					else if($wDay == 4)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-3,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+3,date('Y')));
					}	
					else if($wDay == 5)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-4,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+2,date('Y')));
					}	
					else if($wDay == 6)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-5,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+1,date('Y')));
					}		
					else if($wDay == 0)
					{
						$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-6,date('Y')));
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+0,date('Y')));
					}																							
		
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					{
						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	
						
					}	
					else
					{
		
						$tagEndTime		= $tagEndTime;
					}
				}
				else if($_POST['actionDate'] == 4)
				{					
					$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));				
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
				#***************************** End Date **************************************************************				
				
			}
			if($tagOption	== 1)
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
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );				
					$objTagManager->insertRecord( $objTag );	
					$_SESSION['errorMsg'] = $this->lang->line('msg_time_tag_apply');				
				}
				else if($addOption == 'new')
				{	
					$tagType = $this->input->post('tag');							
					$objTagManager->insertTagType( $tagOption, $tagType );	
					$_SESSION['errorMsg'] = $this->lang->line('msg_time_tag_add');			
				}
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');					
			}							
			if($tagOption	== 2)
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
					$objTag->setSequenceTagId( $sequenceTagId );	
					$objTag->setSequenceOrder( $sequenceOrder );				
					$objTagManager->insertRecord( $objTag );								
				}
				else if($addOption == 'new')
				{	
					$tagType = $this->input->post('tag');							
					$objTagManager->insertTagType( $tagOption, $tagType );								
				}
				$_SESSION['errorMsg'] = $this->lang->line('msg_view_tag_add');								
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');					
			}
			elseif($tagOption	== 3)
			{
				$tag	= $this->input->post('tag');				
				if($this->input->post('tag') != 4)
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
				if($this->input->post('tag') == 4 && $this->input->post('sequence') == 0 && $sequenceTagId == 0)
				{				
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
				else if($this->input->post('tag') == 4 && $this->input->post('sequence') == 1 && $sequenceTagId > 0)
				{
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
				}	
		
				$this->load->model('tag/tagged_users');	
				if(count($this->input->post('taggedUsers')) > 0 && !in_array(0,$this->input->post('taggedUsers')))
				{				
					foreach($this->input->post('taggedUsers') as $userIds)
					{
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userIds );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($this->input->post('taggedUsers')) > 0 && in_array(0,$this->input->post('taggedUsers')))
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
				else if(count($this->input->post('taggedUsers')) == 0)
				{					
					$objTaggedUsers = $this->tagged_users;
					$objTaggedUsers->setTagId( $tagId );
					$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
					$objTagManager->insertRecord( $objTaggedUsers );					
				}				
				$_SESSION['errorMsg'] = $this->lang->line('msg_act_tag_add');		
				if($this->input->post('tag') == 4)
				{			
					redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption.'/2', 'location');			
				}
				else
				{
					redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');					
				}		
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
				$this->load->model('tag/tagged_users');	
				if(count($this->input->post('taggedUsers')) > 0 && !in_array(0,$this->input->post('taggedUsers')))
				{				
					foreach($this->input->post('taggedUsers') as $userIds)
					{
						$objTaggedUsers = $this->tagged_users;
						$objTaggedUsers->setTagId( $tagId );
						$objTaggedUsers->setTaggedUserId( $userIds );					
						$objTagManager->insertRecord( $objTaggedUsers );		
					}
				}
				else if(count($this->input->post('taggedUsers')) > 0 && in_array(0,$this->input->post('taggedUsers')))
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
				else if(count($this->input->post('taggedUsers')) == 0)
				{					
					$objTaggedUsers = $this->tagged_users;
					$objTaggedUsers->setTagId( $tagId );
					$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
					$objTagManager->insertRecord( $objTaggedUsers );					
				}					
				$_SESSION['errorMsg'] = $this->lang->line('msg_create_tag_add');	
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}	
			elseif($tagOption	== 5)
			{			
				$objTag	= $this->tag;		
				$arrTag	= $this->input->post('tag');	
				if(count($arrTag) > 0)
				{
					foreach($arrTag as $tag)
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
						$tagId = $this->db->insert_id();
						$this->load->model('tag/tagged_users');	
						if(count($this->input->post('taggedUsers')) > 0 && !in_array(0,$this->input->post('taggedUsers')))
						{				
							foreach($this->input->post('taggedUsers') as $userIds)
							{
								$objTaggedUsers = $this->tagged_users;
								$objTaggedUsers->setTagId( $tagId );
								$objTaggedUsers->setTaggedUserId( $userIds );					
								$objTagManager->insertRecord( $objTaggedUsers );		
							}
						}
						else if(count($this->input->post('taggedUsers')) > 0 && in_array(0,$this->input->post('taggedUsers')))
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
						else if(count($this->input->post('taggedUsers')) == 0)
						{					
							$objTaggedUsers = $this->tagged_users;
							$objTaggedUsers->setTagId( $tagId );
							$objTaggedUsers->setTaggedUserId( $_SESSION['userId'] );					
							$objTagManager->insertRecord( $objTaggedUsers );					
						}
					}	
				}
				$_SESSION['errorMsg'] = $this->lang->line('msg_contact_tag_add');	
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}	
			elseif($tagOption	== 6)
			{			
				$objTag		= $this->tag;		
				$arrUsers	= $this->input->post('taggedUsers');	
				if(count($arrUsers) > 0)
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
				redirect('tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$tagOption, 'location');							
			}				
		}
	}		
}
?>