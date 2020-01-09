<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
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
class Create_tag extends CI_Controller 
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
			$sequenceTagId = $this->input->post('sequenceTagId');
			$ownerId		= $_SESSION['userId'];
			$tagType		= $this->input->post('tagType');
			$tag			= $this->input->post('tag');
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
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId, 'location');	
				
			}			
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
			
			$updStatus = 0;
			if($this->input->post('sequence') == 1 && $sequenceTagId == 0)
			{				
				$tagSequenceOrder = 1;
				$objSequenceTag = $this->sequence_tag;
				$objSequenceTag->setSequenceTagCreatedDate( $tagCreatedDate );
				$objSequenceTag->setUserId( $_SESSION['userId'] );
				$objTagManager->insertRecord( $objSequenceTag );
				$sequenceTagId = $this->db->insert_id();				
			}
			else if($this->input->post('sequence') == 1 && $sequenceTagId > 0 && $this->input->post('tagType') == 0)
			{
				redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/1', 'location');	
			}
			else if($this->input->post('sequence') == 0 && $sequenceTagId == 0)
			{
				$updStatus = 1;
				$tagSequenceOrder = $this->input->post('sequenceOrder');
			}
			else if($this->input->post('sequence') == 1 && $sequenceTagId > 0)
			{
				$updStatus = 0;
				$tagSequenceOrder = $this->input->post('sequenceOrder');
			}
			
			$objTag	= $this->tag;				
			$objTag->setTagOwnerId( $ownerId );				
			$objTag->setTagType( $tagType );
			$objTag->setTag( $tag );
			$objTag->setTagComments( $tagComments );
			$objTag->setTagArtifactId( $artifactId );
			$objTag->setTagArtifactType( $artifactType );	
			$objTag->setTagCreatedDate( $tagCreatedDate );	
			$objTag->setTagStartTime( $tagStartTime );	
			$objTag->setTagEndTime( $tagEndTime );		
			$objTag->setSequenceTagId( $sequenceTagId );	
			$objTag->setSequenceOrder( $tagSequenceOrder );				
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
				if($this->input->post('workSpaceType') == 1)
				{	
					$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
				}
				else
				{	
					$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
				}					
				foreach($workSpaceMembers as $userData)
				{
					$objTaggedUsers = $this->tagged_users;
					$objTaggedUsers->setTagId( $tagId );
					$objTaggedUsers->setTaggedUserId( $userData['userId'] );					
					$objTagManager->insertRecord( $objTaggedUsers );		
				}
			}	
			if($this->input->post('tagType') == 2)
			{
				$this->load->model('tag/vote_tag');	
				$objVote	= $this->vote_tag;
				$objVote->setTagId($tagId);	
				$objVote->setVotingTopic($this->input->post('voteQuestion'));	
				$objTagManager->insertRecord( $objVote );					
			}
			if($this->input->post('tagType') == 3)
			{
				$this->load->model('tag/selection_tag');	
				$selectionOptions = $this->input->post('selectionOptions');	
				foreach( $selectionOptions as $selectionOption )
				{
					$objSelection	= $this->selection_tag;	
					$objSelection->setTagId( $tagId );	
					$objSelection->setSelectionOption( $selectionOption );	
					$objTagManager->insertRecord( $objSelection );	
				}								
			}
	
			if($this->input->post('treeId') > 0)
			{		
				$treeType = $this->tag_db_manager->getTreeTypeByTreeId( $this->input->post('treeId') );		
			}
			else
			{
				$treeType = 0;
			}
			redirect('add_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$artifactId.'/'.$artifactType.'/'.$sequenceTagId.'/'.$updStatus, 'location');		
		}
	}	

			
}
?>