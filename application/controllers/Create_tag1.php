<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 

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
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
		    $this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;				
			$objIdentity->updateLogin();				
			$objNotification = $this->notification_db_manager;
			$this->load->model('identity/work_space_members');
			$objWorkSpaceMembers = $this->work_space_members;
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;		
			$this->load->model('tag/tag');			
			$this->load->model('tag/sequence_tag');
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/document_db_manager');		
						
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
		
			$monthDays		= cal_days_in_month( CAL_GREGORIAN, date('m'), date('y') );
			$wDay			= date('w');
			
			
		//	echo "<li>endtime= " .$this->input->post('endTime'); exit;
			
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
					$tagStartTime	= date('Y-m-d H:i:s');	
				
					if(trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";					
						
					}	
					else
					{
						$tagEndTime = $tagStartTime;
			
					}
				}
				else if( $_POST['actionDate'] == 1 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s');	
					
					if(trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));				
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d'),date('Y')));	
				
					}			
				}
				else if( $_POST['actionDate'] == 2 )
				{					
					$tagStartTime	= date('Y-m-d H:i:s');				
					
					if(trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";	
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
					
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+6,date('Y')));
					}
					else if($wDay == 2)
					{
					
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+5,date('Y')));
					}		
					else if($wDay == 3)
					{
				
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+4,date('Y')));
					}	
					else if($wDay == 4)
					{
				
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+3,date('Y')));
					}	
					else if($wDay == 5)
					{
				
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+2,date('Y')));
					}	
					else if($wDay == 6)
					{
				
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+1,date('Y')));
					}		
					else if($wDay == 0)
					{
				
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+0,date('Y')));
					}																							
			
					if(trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";	
						
					}	
					else
					{
						$tagEndTime		= $tagEndTime;
					}
				}
				else if($_POST['actionDate'] == 4)
				{					
					$tagStartTime	= date('Y-m-d H:i:s');				
					if(trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";	
					}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23, 59, 0,date('m'), $monthDays, date('Y')));
					}
				}
				
				else if($_POST['actionDate'] == 5)
				{					
					$tagStartTime	= date('Y-m-d H:i:s');			
					if($this->input->post('tagType') == 2 && trim($this->input->post('endTime')) != '')
					{
/*						$endTime 		= explode(' ',$this->input->post( 'endTime' ));			
						$tagEndTime		= $endTime[0].' 23:59:00';	*/
						$et=explode(" ",$this->input->post('endTime'));
						$edt = explode("-",$et[0]);					
						//$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);	
						$tagEndTime = $edt[2]."-".$edt[1]."-".$edt[0]." 23:59:00";						}	
					else
					{
						$tagEndTime		= date('Y-m-d H:i:s', mktime(23, 59, 0, 12, $monthDays, date('Y')));
					}
				}
			}
			//echo "TagOption= " .$tagOption; exit;
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
			if($tagOption == 2) // Simple Tags
			{   
				//echo 'Addoption= ' .$addOption; exit;
				$simpleTagStartTime = '0000-00-00 00:00:00';
				$simpleTagEndTime = '0000-00-00 00:00:00';
			
				$status = 'true';
				$unAppliedTags = $this->input->post('unAppliedTags');
				$unAppliedTags = explode(',',$unAppliedTags);
				
				//echo "unapplied tags= "; print_r($unAppliedTags); return;
				
				$unChecked = $this->input->post('unChecked');
				$unChecked = explode(',',$unChecked);
				//echo "unchecked= "; print_r($unChecked); return;
				
				$sectionTagIds = $this->input->post('sectionTagIds');
				$sectionTagIds2 = array();
				$sectionTagIds2 = explode(',',$sectionTagIds);

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
				
				//notification email code start
				
				/*$membersList = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				
				if(!empty($unAppliedTags)){
					foreach($membersList as $mem){
						$userId = $mem['userId'];	
						$notifySubscriptions 	= $objNotification->getUserSubscriptions(5,$userId);
						if($notifySubscriptions['types']){
							$notificationMail 		= $objNotification->getNotificationTypes(5);
							
							$userDetail = $objIdentity->getUserDetailsByUserId($userId);
							
							$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
							
							$subject = $notificationMail[0]["template_subject"];
							$body    = $notificationMail[0]["template_body"];
							$treeId=$this->input->post('treeId');	
							//$body    = $body."</ br>"."<a href='".base_url()."view_document/index/$workSpaceId/type/1/&treeId=$treeId&doc=exist'>Click here</a> to view";						
							
							$returnUrl = $_POST['returnUrl'];
							
							if($_POST['doc']!=0){
								$returnUrl = $returnUrl."&treeId=$treeId&doc=exist";
							}
							
							$url = "<a href='$returnUrl'>$returnUrl</a>";
							//$url = "<a href='".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."'>".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."</a>";
							$body = str_replace ('{$url}',$url,$body);
							//$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
							//$body  = $body."</ br>"."<a href='".base_url()."'>Click here</a> to view";
							$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$userId,'workspaceId'=>$workSpaceId);
							$notification  = $objNotification->addNotification($params);
							$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
							//$objNotification->sendNotification($param);
												
						}
					}
				}*/
				//notification email code end
				
				
				$sectionChecked = array();
				$sectionChecked = explode(',',$this->input->post('sectionChecked'));

				$addOption = $this->input->post('addOption');	
               
				
				if($addOption == 'update')
				{   
					//echo count($unAppliedTags); exit;
				
					$objTag	= $this->tag;
				
					
					foreach($unAppliedTags as $key=>$value)
					{	 			
						$tag = $value;
		
		                if ($tag!='')
						{
							if (!in_array($tag,$appliedTagIds))
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
								$simple_tag_create='1';
							}
						}
					}
					
					//echo "sectionTagIds2= "; print_r($sectionTagIds2);echo "unchecked= "; print_r($unChecked); return;
					//$count=0;
					foreach($sectionTagIds2 as $key=>$value)
					{					
						$tag = $value;
						
						if ((!empty($tag)) && (in_array($tag,$unChecked)))
						{
							//$deletedTagId .= ",".$tag;
							$objTagManager->deleteTag( $tag, $artifactId,$artifactType, $tagOption );
							// $simple_tag_delete='1';
							/*Added by Dashrath- get tag comments by tagId*/
							if (in_array($tag,$appliedTagIds))
							{
								$getTagName2 = $this->notification_db_manager->getTagNameByTagId($tag);
								$getTagName2=strip_tags($getTagName2);
								
								$simpleTagComments[] = $getTagName2;

								$simple_tag_delete='1';
							}
							/*Dashrath- code end*/
						}
					}	
					
					//echo "deletedTagId= " .$deletedTagId; return;
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
					$_SESSION['errorMsg']="Simple tag applied succesfully";
					$this->countAllTagsByTreeId($treeId,$workSpaceId,$workSpaceType,$artifactId,$artifactType); 
							
					$_SESSION['errorMsg']='';
						
						//Manoj: Insert simple tag apply notification start
								//print_r($unAppliedTags); exit;
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								
								//Add post tag change details start
								if($treeId==0)
								{
										//3 for add tag in post change table
										$change_type=3;
										$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$artifactId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
										$postOrderChange = $this->timeline_db_manager->change_post_order($artifactId,$objTime->getGMTTime());
								}
								//Add post tag change details end
								
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								if($simple_tag_create==1)
								{
									$notificationDetails['object_id']='4';
									$notificationDetails['action_id']='4';

									/*Added by Dashrath- Check object is tree or leaf*/
									if($artifactType==1)
									{
										$notificationDetails['parent_object_id']='1';
										$notificationDetails['parent_tree_id']=$this->input->post('treeId');
									}
									else if($artifactType==2)
									{
										if($treeId==0)
										{
											$notificationDetails['parent_object_id']='3';
										}
										else
										{
											if($treeId==0)
											{
												$notificationDetails['parent_object_id']='3';
											}
											else
											{
												$notificationDetails['parent_object_id']='2';
												$notificationDetails['parent_tree_id']=$treeId;
											}
										}
										
									}
									/*Dashrath- code end*/
								}
														
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
								
								
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								//Add simple tag data
										$tagIdArray=array_reverse($unAppliedTags);
										$i=0;
										if(count($tagIdArray)>2)
										{
											$totalTagCount = count($tagIdArray)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalTagCount ,$this->lang->line('txt_notification_count'));
										}
										foreach($unAppliedTags as $tag_id)
										{
											if($i<2)
											{
												$getTagName = $this->notification_db_manager->getTagNameByTagId($tag_id);
												$getTagName=strip_tags($getTagName);
												if(strlen($getTagName) > 20)
												{
													$getTagName = substr($getTagName, 0, 20) . "..."; 
												}
												if($getTagName!='')
												{
													$TagNameArray[] = '"'.$getTagName.'"';
												}
											}
											$i++;
										}	
										$simpleTagName=implode(', ',$TagNameArray).' '.$otherTxt;
										//echo $simpleTagName.'===test==';
										
										
										$notificationData['data']=$simpleTagName;

										if($simple_tag_create==1)
										{
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										}

										$notificationDetails['notification_data_id']=$notification_data_id;
							//Add simple tag data end	
								
								
								/*if($notificationDetails['url']!='')	
								{*/	
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
									//echo $notification_id; exit;
									if($notification_id!='')
									{
										//get originator id
									
										foreach($unAppliedTags as $key=>$value)
										{	 			
											$tag = $value;
											if (!in_array($tag,$appliedTagIds))
											{
												$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tag);
												if($originatorUserId!='')
												{
													$originatorIdArray[] = $originatorUserId;
												}
											}
										}
										


										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
							
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										
										if(count($workSpaceMembers)!=0)
										{	
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);
												
													//get user object action preference
													/* //$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($objectFollowStatus['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$com_dat = $notificationDetails['object_id'].', '.$notificationDetails['action_id'];
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($treeType=='') $tree_type = 'post';
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																/*if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
															}
													
															 
														//}
													//}
													
												
												//Summarized feature start here
												//Summarized feature end here 
												
													}
												}//reserve check end
											}
											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
										}
										//Set notification dispatch data end
			// Parv: Add a system generated comment in the post when a simple tag is applied
			$post_id = $node_id;
			//$comment_data = $notificationContent['data'];

															//get notification template using object and action id
															//$getNotificationTemplate=trim($this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']));
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$tree_type = 'post';
															//$user_template = array("{username}", "{treeType}", "{spacename}");
														//	$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);															
															//Serialize notification data
															//$notificationContent=array();
															//$comment_data=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$comment_data = $notificationData['data']." tag(s) applied by " .$recepientUserName;
															

			$comment_originator_id = 0;
			$postCommentCreatedDate=$objTime->getGMTTime();
			$treeId =0;
			$mainPostNodeId = 0;
			$postCommentNodeId	= $this->timeline_db_manager->insertTimelineComment($post_id,$comment_data,$comment_originator_id,$postCommentCreatedDate,$treeId,$workSpaceId,$workSpaceType,'','',1,1,$mainPostNodeId);
			//$_SESSION['errorMsg'] = "commentid=".$postCommentNodeId;
									}
								/*}*/	
								//Manoj: Insert simple tag apply notification end
								
								//Manoj: Insert simple tag delete notification start
								
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								$notificationDetails['object_id']='';
								$notificationDetails['action_id']='';
								
								/*Changed by Dashrath- remove and condition from if statement*/
								if($simple_tag_delete==1)
								{
									$notificationDetails['object_id']='4';
									$notificationDetails['action_id']='3';

									/*Added by Dashrath- Check object is tree or leaf*/
									if($artifactType==1)
									{
										$notificationDetails['parent_object_id']='1';
										$notificationDetails['parent_tree_id']=$this->input->post('treeId');
									}
									else if($artifactType==2)
									{
										if($treeId==0)
										{
											$notificationDetails['parent_object_id']='3';
										}
										else
										{
											$notificationDetails['parent_object_id']='2';
											$notificationDetails['parent_tree_id']=$treeId;
										}
									}
									/*Dashrath- code end*/
								}
														
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								
								/*if($notificationDetails['url']!='' && $notificationDetails['object_id']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}

									/*Added by Dashrath- Add data in events_data table*/
									if($simple_tag_delete==1)
									{
										if(count($simpleTagComments)>0)
										{
											if(count($simpleTagComments)==1)
											{
												$notificationData['data'] = $simpleTagComments[0];
											}
											else if(count($simpleTagComments)==2)
											{
												$notificationData['data'] = $simpleTagComments[0].','.$simpleTagComments[1];
											}
											else
											{
												$moreTagCount = count($simpleTagComments)-2;
												$notificationData['data'] = $simpleTagComments[0].','.$simpleTagComments[1].' and '.$moreTagCount.' more';
											}

										}
									
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
									}
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										//$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$node_id);


										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
					
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($treeType=='') $tree_type = 'post';
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert simple tag delete notification end
									
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
					//echo "here"; exit;
					$tagType = $this->input->post('tag');
												
					if (!($objTagManager->insertTagType($tagOption, $tagType, $workPlaceId )))
					{
						$status = 'false';						
					}
				
					if ($status=='true')
					{
						$_SESSION['errorMsg'] = '<div class="successMsg">'.$this->lang->line('msg_view_tag_add').'</div>';	
						
						//Manoj: Insert simple tag create notification start
								
								$simpleTagId = $this->db->insert_id();
						
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='4';
								$notificationDetails['action_id']='1';

								/*Added by Dashrath- Check object is tree or leaf*/
								if($artifactType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$this->input->post('treeId');
								}
								else if($artifactType==2)
								{
									if($treeId==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$treeId;
									}
								}
								/*Dashrath- code end*/
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
								
								/*if($notificationDetails['url']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}

									/*Added by Dashrath- Add data in events_data table*/
									$notificationData['data'] = $tagType;
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
									$notificationDetails['notification_data_id']=$notification_data_id;
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										//$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$node_id);

										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))	
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($treeType=='') $tree_type = 'post';
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert simple tag create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$simpleTagId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
						
									
					}
					else
					{
						$_SESSION['errorMsg'] = '<div class="errorMsg">'.$this->lang->line('msg_tag_already_exist').'</div>';		
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
						if (in_array($tagData['tag'],$appliedTagIds)) 
						{ 
							$count .= ',' .$tagData['tag'];
							
							if (in_array($tagData['tag'],$appliedTagIds)) { 
								$sectionChecked .= ',' .$tagData['tag'];
							} 
							
							if (in_array($tagData['tag'],$appliedTagIds))
							{
								$cls1 = ($tagData['systemTag']==1)?'colorTags':'';
								$cls = ($tagData['systemTag']==1)?'italics':'';
								$tagName=($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];
								$str.='<input class="simpleTagCheckbox chek '.$cls1.'" type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" checked="checked"/><span class="clsCheckedTags '.$cls.'" >'.$tagName.'</span><br />';
							 
							}
							else
							{
								$cls1 = ($tagData['systemTag']==1)?'colorTags':'';
								$cls = ($tagData['systemTag']==1)?'italics':'';
								$tagName=($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];
								$str.='<input class="simpleTagCheckbox '.$cls1.'" type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" /><span class="'.$cls.'" >'.$tagName.'</span><br />';
							}
					
						}
					}
				
					foreach($viewTags2 as $tagData)	
					{
						if (!in_array($tagData['tag'],$appliedTagIds)) { 
							$count .= ',' .$tagData['tag'];
							
							if (in_array($tagData['tag'],$appliedTagIds)) { 
								$sectionChecked .= ',' .$tagData['tag'];
							} 
							if (in_array($tagData['tag'],$appliedTagIds)) 
							{
								$cls1 = ($tagData['systemTag']==1)?'colorTags':'';
								$cls = ($tagData['systemTag']==1)?'italics':'';
								$tagName=($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];
								$str.='<input class="simpleTagCheckbox check '.$cls1.'" type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" checked="checked"/><span class="'.$cls.'" >'.$tagName.'</span><br />';
							}
							else
							{
								$cls1 = ($tagData['systemTag']==1)?'colorTags':'';
								$cls = ($tagData['systemTag']==1)?'italics':'';
								$tagName=($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];
								$str.='<input class="simpleTagCheckbox '.$cls1.'" type="checkbox" name="unAppliedTags" value="'.$tagData['tag'].'" /><span class="'.$cls.'" >'.$tagName.'</span><br />';
							}
						}
						
						
					}

					echo $str."|||@||".$_SESSION['errorMsg'];	
					
					$_SESSION['errorMsg']='';
				}
					
					
			
							
			}
			elseif($tagOption	== 3) // Response Tags
			{
			  // echo "<li>addOption= " .$addOption; exit;
				$addOption = $this->input->post('addOption'); 
				$tagType = $this->input->post('tagType');
				$tagId = $this->input->post('editTagId');
				$tag = $this->input->post('tagType');
             
				if($addOption == 'edit')
				{      
						/*Added by Dashrath- Get previous action tag name*/
						$previousActionTagName = $this->tag_db_manager->getResponseTag($tagId);
						/*Dashrath- code end*/
						
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
						$objTagManager->updateRecord( $objTag );
						
						if ($tagType==2)
						{

							$this->load->model('tag/selection_tag');	
							$selectionOptions = $this->input->post('selectionOptions');	
							$selectionOptions = explode(",",$selectionOptions);
							
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
						
						//Manoj: Insert action tag edit notification start
						
								//get tagged users list
								$taggedUsers=$this->input->post('taggedUsers',true);
								$taggedUsersArray=explode(',',$taggedUsers);
				
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								
								$notificationDetails['object_id']='5';
								$notificationDetails['action_id']='2';
								

								/*Added by Dashrath- Check object is tree or leaf*/
								if($artifactType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$artifactId;
								}
								else if($artifactType==2)
								{
									if($treeId==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$treeId;
									}
								}
								/*Dashrath- code end*/
													
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								
								/*if($notificationDetails['url']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}

									/*Added by Dashrath- Add action tag in events data table*/
									$notificationDispatchDetails['data']=$previousActionTagName;
									//Set notification data 
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

									if($notification_data_id!='')
									{
										$notificationDetails['notification_data_id']= $notification_data_id;
									}
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tagId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
							
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
					
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($tree_type_val=='') $tree_type = 'post';
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}	
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end

									}
								/*}*/	
								
								//Manoj: Insert action tag edit notification end
			
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
				
				$unAppliedTags = $this->input->post('unAppliedTags');
				$sectionTagIds = $this->input->post('sectionTagIds');
				$sectionTagIds2 = array();
				$sectionTagIds2 = explode(',',$sectionTagIds);
				

				$appliedTagIds = array();
				$appliedTagIds = explode(',',$this->input->post('appliedTags'));
				
				$sectionChecked = array();
				$sectionChecked = explode(',',$this->input->post('sectionChecked'));
				
				
				if($addOption == 'update')
				{  
					
					$unAppliedTags = $this->input->post('unAppliedTags');
					$unAppliedTags = explode(',',$unAppliedTags);
					$objTag	= $this->tag;
			
					foreach($sectionChecked as $key=>$value)
					{					
						$tag = $value;
                        
						if ((!empty($tag)) && (in_array($tag,$unAppliedTags)))
						{
							/*Added by Dashrath- get tag comments by tagId*/
							$tagComment = $objTagManager->getResponseTag($tag);
							$tagComments[] = $tagComment;
							/*Dashrath- code end*/

							$objTagManager->deleteResponseTag( $tag );
						}
					}
					
					//Manoj: Insert action tag delete notification start
				
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								
								$notificationDetails['object_id']='5';
								$notificationDetails['action_id']='3';
								
								/*Added by Dashrath- Check object is tree or leaf*/
								if($artifactType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$artifactId;
								}
								else if($artifactType==2)
								{
									if($treeId==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$treeId;
									}
								}
								/*Dashrath- code end*/
														
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								
								/*if($notificationDetails['url']!='')	
								{*/	
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}

									/*Added by Dashrath- Add talk in events data table*/
									if(count($tagComments)>0)
									{
										if(count($tagComments)==1)
										{
											$notificationDispatchDetails['data'] = $tagComments[0];
										}
										else if(count($tagComments)==2)
										{
											$notificationDispatchDetails['data'] = $tagComments[0].','.$tagComments[1];
										}
										else
										{
											$moreTagCount = count($tagComments)-2;
											$notificationDispatchDetails['data'] = $tagComments[0].','.$tagComments[1].' and '.$moreTagCount.' more';
										}

									}

									//Set notification data 
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

									if($notification_data_id!='')
									{
										$notificationDetails['notification_data_id']= $notification_data_id;
									}
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;	
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										//$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tagId);
										
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';
															if ($tree_type_val=='') $tree_type = 'post';	
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}	
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert action tag delete notification end
					
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
					
						
						$str.='<input type="checkbox" name="unAppliedTagsActionDelete" value="'.$tagData['tagId'].'" />'.$tagData['comments'].'&nbsp<a href="javaScript:void(0)" onclick="edit_action_tag('. $workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','. $sequenceTagId.','.$tagOption.','.$tagData['tagId'].')" title="Edit">'.$this->lang->line('txt_Edit').'</a><br />';
						
						}
					}
		
					if (!$tags)
					{
		
						$str.= $this->lang->line('txt_None');
					}
					
					echo $str.='|||@||'.$_SESSION['errorMsg'];	 die;		
				}

				$tag	= $this->input->post('tag');	
				
				//echo "tag= " .$tag; die;			
							
				if($tag != 4 && $tag!='')
				{
					//echo "<li>the end time= " .$tagEndTime; exit;
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
						
					if($this->input->post('tag') == 2)
					{
						$this->load->model('tag/selection_tag');	
						/*changed by Surbhi IV*/
						$selectionOptions = explode(',',$this->input->post('selectionOptions'));
						/*End of changed by Surbhi IV*/
						foreach($selectionOptions as $selectionOption)
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
				else if($this->input->post('tag') == 4 && $this->input->post('sequence') == 1 && $sequenceTagId >= 0)
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
				
				//Manoj: Insert action tag apply notification start
				
				if($this->input->post('tag') == 1 || $this->input->post('tag') == 2 || $this->input->post('tag') == 3 || $this->input->post('tag') == 4  )
				{
							//get tagged users list
							$taggedUsers=$this->input->post('taggedUsers',true);
							$taggedUsersArray=explode(',',$taggedUsers);
							
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								
								//Add post tag change details start
								if($treeId==0)
								{
										//3 for add tag in post change table
										$change_type=3;
										$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$artifactId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
										$postOrderChange = $this->timeline_db_manager->change_post_order($artifactId,$objTime->getGMTTime());
								}
								//Add post tag change details end
								
								$node_id=$artifactId;
								$notificationDetails=array();
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								//Add ation tag data
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}
				
					
										$tagData = $this->notification_db_manager->getActionTagNameByInstanceId($objectInstanceId,'3',$this->input->post('tag'),$artifactType);
								
										$i=0;
										if(count($tagData)>2)
										{
											$totalTagCount = count($tagData)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalTagCount ,$this->lang->line('txt_notification_count'));
										}
										foreach($tagData as $tagContent)
										{
											if($i<2)
											{
												$tagContent['tagName']=strip_tags($tagContent['tagName']);
												if(strlen($tagContent['tagName']) > 20)
												{
													$tagContent['tagName'] = substr($tagContent['tagName'], 0, 20) . "..."; 
												}
												if($tagContent['tagName']!='')
												{
													$TagNameArray[] = '"'.$tagContent['tagName'].'"';
												}
											}
											$i++;
										}	
										$actionTagName=implode(', ',$TagNameArray).' '.$otherTxt;
										//echo $actionTagName.'===test==';
										//exit;
										$notificationData['data']=$actionTagName;
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
								//Add action tag data end
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								
								$notificationDetails['object_id']='5';
								$notificationDetails['action_id']='4';

								/*Added by Dashrath- Check object is tree or leaf*/
								if($artifactType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$artifactId;
								}
								else if($artifactType==2)
								{
									if($treeId==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$treeId;
									}
								}
								/*Dashrath- code end*/
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								
								/*if($notificationDetails['url']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$node_id);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($tree_type_val=='') $tree_type = 'post';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																/*if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
															}
													
															 
														/*}
													}*/
													
												
												
												//Summarized feature start here
												//Summarized feature end here
												
												}
												}//reserve check end
											}
											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
										}
										//Set notification dispatch data end
									}
								/*}*/	
			// Parv: Add a system generated comment in the post
			$post_id = $node_id;
			//$comment_data = $notificationContent['data'];

															//get notification template using object and action id
															//$getNotificationTemplate=trim($this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']));
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$tree_type = 'post';
															//$user_template = array("{username}", "{treeType}", "{spacename}");
														//	$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);															
															//Serialize notification data
															//$notificationContent=array();
															//$comment_data=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$comment_data = $notificationData['data']." tag(s) applied by " .$recepientUserName;
															

			$comment_originator_id = 0;
			$postCommentCreatedDate=$objTime->getGMTTime();
			$treeId =0;
			$mainPostNodeId = 0;
			$postCommentNodeId	= $this->timeline_db_manager->insertTimelineComment($post_id,$comment_data,$comment_originator_id,$postCommentCreatedDate,$treeId,$workSpaceId,$workSpaceType,'','',1,1,$mainPostNodeId);

								}
								//Manoj: Insert action tag apply notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$tagId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
				
				
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
				/* <!--Changed by Surbhi IV -->*/	
			    $_SESSION['errorMsg'] = '';		
				/* <!--End of Changed by Surbhi IV -->*/
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
				$str.='<input type="checkbox" name="unAppliedTagsActionDelete" value="'.$tagData['tagId'].'" />'.$tagData['comments'].'&nbsp<a href="javaScript:void(0)" onclick="edit_action_tag('. $workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','. $sequenceTagId.','.$tagOption.','.$tagData['tagId'].')" title="Edit">'.$this->lang->line('txt_Edit').'</a><br />';
				
				}
        	}

			if (!$tags)
			{

				$str.= $this->lang->line('txt_None');
			}
			else{
				//notification email code start
				
				/*$membersList = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				//print_r($membersList);die;
					foreach($membersList as $mem){
						$userId = $mem['userId'];	
						$notifySubscriptions 	= $objNotification->getUserSubscriptions(6,$userId);
						if($notifySubscriptions['types']){
							$notificationMail 		= $objNotification->getNotificationTypes(6);
							
							$userDetail = $objIdentity->getUserDetailsByUserId($userId);
							
							$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
							
							$subject = $notificationMail[0]["template_subject"];
							$body    = $notificationMail[0]["template_body"];
							$treeId=$this->input->post('treeId');	
							//$body    = $body."</ br>"."<a href='".base_url()."view_document/index/$workSpaceId/type/1/&treeId=$treeId&doc=exist'>Click here</a> to view";
							
							$returnUrl = $_POST['returnUrl'];
							if($_POST['doc']!=0){
								$returnUrl = $returnUrl."&treeId=$treeId&doc=exist";
							}
							$url = "<a href='$returnUrl'>$returnUrl</a>";
							$body = str_replace ('{$url}',$url,$body);
							//$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
							//$body  = $body."</ br>"."<a href='".base_url()."'>Click here</a> to view";
							$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$userId,'workspaceId'=>$workSpaceId);
							$notification  = $objNotification->addNotification($params);
							$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
							//$objNotification->sendNotification($param);
												
						}
					}*/
				//notification email code end
				
			}
        	
			echo $str.='|||@||'.$_SESSION['errorMsg']; 
			
			$_SESSION['errorMsg']='';
			
			die;
				
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
				
				
			
				$addOption = $this->input->post('addOption');
				
			    $tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $_POST['artifactId'], $_POST['artifactType']);
				if(count($tags) > 0)
				{
					foreach($tags as $tagData)
					{
						$appliedTagIds[] = $tagData['tag'];
					}
				}
					
				if($addOption == 'update')
				{
					$objTag	= $this->tag;
		
					
					foreach($unAppliedTags as $key=>$value)
					{					
						$tag = $value;
						
						if (!in_array($tag,$appliedTagIds))
						{
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
							$contact_tag_create='1';
						}
					}
					
					//notification code
						/*$membersList = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
						if(!empty($unAppliedTags)){
							foreach($membersList as $mem){
								$userId = $mem['userId'];	
								$notifySubscriptions 	= $objNotification->getUserSubscriptions(7,$userId);
								if($notifySubscriptions['types']){
									$notificationMail 		= $objNotification->getNotificationTypes(7);
									
									$userDetail = $objIdentity->getUserDetailsByUserId($userId);
									
									$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
									
									$subject = $notificationMail[0]["template_subject"];
									$body    = $notificationMail[0]["template_body"];
									$treeId=$this->input->post('treeId');	
									//$body    = $body."</ br>"."<a href='".base_url()."view_document/index/$workSpaceId/type/1/&treeId=$treeId&doc=exist'>Click here</a> to view";						
									
									$returnUrl = $_POST['returnUrl'];
									
									if($_POST['doc']!=0){
										$returnUrl = $returnUrl."&treeId=$treeId&doc=exist";
									}
									
									$url = "<a href='$returnUrl'>$returnUrl</a>";
									//$url = "<a href='".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."'>".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."</a>";
									$body = str_replace ('{$url}',$url,$body);
									//$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
									//$body  = $body."</ br>"."<a href='".base_url()."'>Click here</a> to view";
									$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$userId,'workspaceId'=>$workSpaceId);
									$notification  = $objNotification->addNotification($params);
									$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
									//$objNotification->sendNotification($param);
													
								}
							}
						}*/
							
					//$sectionChecked=array();
				
					foreach($unChecked as $key=>$value)
					{					
						 $tag = $value;
						
                       
						if ((!empty($tag)))
						{

							$objTagManager->deleteTag( $tag,$artifactId,$artifactType );
							//$contact_tag_delete='1';

							/*Added by Dashrath- get tag comments by tagId*/
							if (in_array($tag,$appliedTagIds))
							{
								$getTagName1 = $this->notification_db_manager->getTreeNameByTreeId($tag);
								$getTagName1=strip_tags($getTagName1);
								if(strlen($getTagName1) > 20)
								{
									$getTagName1 = substr($getTagName1, 0, 20) . "..."; 
								}
								$contactTagComments[] = $getTagName1;

								$contact_tag_delete='1';
							}
							/*Dashrath- code end*/
						}
						
					}		
						
				}
			

			$_SESSION['errorMsg'] = $this->lang->line('msg_contact_tag_add');	
			
			
			//Manoj: Insert contact tag apply notification start
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								
								//Add post tag change details start
								if($treeId==0)
								{
										//3 for add tag in post change table
										$change_type=3;
										$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$artifactId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
										$postOrderChange = $this->timeline_db_manager->change_post_order($artifactId,$objTime->getGMTTime());
								}
								//Add post tag change details end
								
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								if($contact_tag_create==1)
								{
									$notificationDetails['object_id']='6';
									$notificationDetails['action_id']='4';

									/*Added by Dashrath- Check object is tree or leaf*/
									if($artifactType==1)
									{
										$notificationDetails['parent_object_id']='1';
										$notificationDetails['parent_tree_id']=$artifactId;
									}
									else if($artifactType==2)
									{
										if($treeId==0)
										{
											$notificationDetails['parent_object_id']='3';
										}
										else
										{
											$notificationDetails['parent_object_id']='2';
											$notificationDetails['parent_tree_id']=$treeId;
										}
									}
									/*Dashrath- code end*/
								}
														
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								//Add contact tag data
										//print_r($unAppliedTags);
										$tagIdArray=array_reverse($unAppliedTags);
										$i=0;
										if(count($tagIdArray)>2)
										{
											$totalTagCount = count($tagIdArray)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalTagCount ,$this->lang->line('txt_notification_count'));
										}
										foreach($unAppliedTags as $tag_id)
										{
											if($i<2)
											{
												$getTagName = $this->notification_db_manager->getTreeNameByTreeId($tag_id);
												$getTagName=strip_tags($getTagName);
												if(strlen($getTagName) > 20)
												{
													$getTagName = substr($getTagName, 0, 20) . "..."; 
												}
												if($getTagName!='')
												{
													$TagNameArray[] = '"'.$getTagName.'"';
												}
											}
											$i++;
										}	
										$contactTagName=implode(', ',$TagNameArray).' '.$otherTxt;
										//echo $simpleTagName.'===test==';
										//exit;
										
										$notificationData['data']=$contactTagName;

										if($contact_tag_create==1)
										{
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										}
										$notificationDetails['notification_data_id']=$notification_data_id;
							//Add contact tag data end
								
								
								/*if($notificationDetails['url']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										//$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$node_id);

										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($tree_type_val=='') $tree_type = 'post';
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																/*if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
															}
													
															 
														/*}
													}*/
													
												//Summarized feature start here
												//Summarized feature end here
												
												}
												}//reserve check end
											}											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
										}
										//Set notification dispatch data end
			// Parv: Add a system generated comment in the post
			$post_id = $node_id;
			//$comment_data = $notificationContent['data'];

															//get notification template using object and action id
															//$getNotificationTemplate=trim($this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']));
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$tree_type = 'post';
															//$user_template = array("{username}", "{treeType}", "{spacename}");
														//	$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);															
															//Serialize notification data
															//$notificationContent=array();
															//$comment_data=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$comment_data = $notificationData['data']." tag(s) applied by " .$recepientUserName;
															

			$comment_originator_id = 0;
			$postCommentCreatedDate=$objTime->getGMTTime();
			$treeId =0;
			$mainPostNodeId = 0;
			$postCommentNodeId	= $this->timeline_db_manager->insertTimelineComment($post_id,$comment_data,$comment_originator_id,$postCommentCreatedDate,$treeId,$workSpaceId,$workSpaceType,'','',1,1,$mainPostNodeId);
									}
								/*}*/	
								//Manoj: Insert contact tag apply notification end
								
								//Manoj: Insert contact tag delete notification start
								
								$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
								$node_id=$artifactId;
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								$notificationDetails['object_id']='';
								$notificationDetails['action_id']='';
								
								/*Changed by Dashrath- remove and condition from if statement $contact_tag_create!=1*/
								if($contact_tag_delete==1)
								{
									$notificationDetails['object_id']='6';
									$notificationDetails['action_id']='3';

									/*Added by Dashrath- Check object is tree or leaf*/
									if($artifactType==1)
									{
										$notificationDetails['parent_object_id']='1';
										$notificationDetails['parent_tree_id']=$artifactId;
									}
									else if($artifactType==2)
									{
										if($treeId==0)
										{
											$notificationDetails['parent_object_id']='3';
										}
										else
										{
											$notificationDetails['parent_object_id']='2';
											$notificationDetails['parent_tree_id']=$treeId;
										}
									}
									/*Dashrath- code end*/
								}
														
								
								if($treeType=='1')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
								}	
								if($treeType=='3')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
								}
								if($treeType=='5')
								{
									$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
								}
								if($treeType=='')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
								}
								
								if($artifactType==1)
								{
									$treeId=$artifactId;
									$notification_url='';
								}
								
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
									}
								}
								
								$notificationDetails['url'] = $notification_url;	
										/*
										http://localhost/teeme/contact/contactDetails/2445/44/type/1/?node=3044#contactLeafContent3044
										http://localhost/teeme/notes/Details/2613/44/type/1/?node=3043#noteLeafContent3043
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3042#taskLeafContent3042
										http://localhost/teeme/view_chat/chat_view/2203/44/type/1/1/?node=3041#discussLeafContent3041
										http://localhost/teeme/view_task/node/2611/44/type/1/?node=3045#subTaskLeafContent3045
										http://localhost/teeme/view_document/index/44/type/1/?treeId=2609&doc=exist&node=3040#docLeafContent3040
										*/
								
								
								/*if($notificationDetails['url']!='' && $notificationDetails['object_id']!='')	
								{*/		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}

									/*Added by Dashrath- Add data in events_data table*/
									if($contact_tag_delete==1)
									{
										if(count($contactTagComments)>0)
										{
											if(count($contactTagComments)==1)
											{
												$notificationData['data'] = $contactTagComments[0];
											}
											else if(count($contactTagComments)==2)
											{
												$notificationData['data'] = $contactTagComments[0].','.$contactTagComments[1];
											}
											else
											{
												$moreTagCount = count($contactTagComments)-2;
												$notificationData['data'] = $contactTagComments[0].','.$contactTagComments[1].' and '.$moreTagCount.' more';
											}

										}
									
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
									}
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$objectInstanceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										//$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$node_id);

										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
						
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
				
											}
										}
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															if ($tree_type_val=='') $tree_type = 'post';
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}	
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								/*}*/	
								
								//Manoj: Insert contact tag delete notification end

			
				
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
		$this->load->model("dal/identity_db_manager");
		$this->load->model('dal/document_db_manager');
 		$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'],  $artifactId, $artifactType);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'],  $artifactId, $artifactType);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'],  $artifactId, $artifactType);
		
		
		$leafClearStatus	= $this->identity_db_manager->getLeafClearStatus($artifactId,'clear_tag');
		
		
		if($leafClearStatus == 1 && $leafClearStatus != '')
		{
			$tag_container.= '<div class="clearMsgPadding">'.$this->lang->line('txt_clear_prev_tag_obj_msg').'</div>';
		}		
		
		if((count($viewTags)+count($actTags)+count($contactTags)+count($userTags))>0)
		{	
			
			
			if($artifactId !='')
			{
				$leafOwnerData = $this->identity_db_manager->getLeafIdByNodeId($artifactId);
			}
			
			if($leafClearStatus == 0 && $leafClearStatus != '' && $leafOwnerData['userId']==$_SESSION['userId'])
			{
				$tag_container.= '<div><input type="button" name="clear" value="'.$this->lang->line('txt_clear_prev_tag_obj').'" onclick="clearTags('.$artifactId.');" style="margin-bottom:10px;" /></div><div class="clearLoader" id="clearLoader"></div>';
			}
			
			
			if(count($viewTags)>0)
			{		 
						       
				$tag_container.='<div class="paddingTopBottom">'.$this->lang->line('txt_Simple_Tag').' :';
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
				 $tag_container.='</div>';
			}
			
							
			if(count($actTags) > 0)
			{
				$tag_container.='<div class="paddingTopBottom">'.$this->lang->line('txt_Response_Tag').' :';
				$tagAvlStatus = 1;
				$i=0;
				foreach($actTags as $tagData)
				{	
					$dispResponseTags='';
					if($i>0)
					{	
						$dispResponseTags.= ", ";
					}
					$dispResponseTags .= $tagData['comments'].' [';							
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
				$tag_container.='</div>';
			}
			
			$tag_container.='<div id="actionTagResponse"></div>';
			if(count($contactTags) > 0)
			{
				$tag_container.='<div class="paddingTopBottom">'.$this->lang->line('txt_Contact_Tag').' :';
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
				 $tag_container.='</div>';
			}		
		
		}
		else
		{
		 	$tag_container.= $this->lang->line('txt_None');
		} 
		echo count($viewTags)+count($actTags)+count($contactTags)+count($userTags).'|||@||'.$tag_container.'|||@||'.$_SESSION['errorMsg'];
		//echo "Action tags count= " .count($actTags);
		
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
		
		/*Added by Dashrath- used for display linked folder count*/
		$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($artifactId, $artifactType);
		/*Dashrath- code end*/

		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($artifactId, $artifactType);	
		
		/*Changed by Dashrath- add $docTrees10 for totalLinks*/
		$totalLinks=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);
		
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

		/*Added by Dashrath- used for display linked folder count*/
		$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($artifactId, $artifactType);
		/*Dashrath- code end*/

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
								/*Changed by Dashrath- add $docTrees10 for total*/
								$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);
								
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
											 $appliedLinks.="\n - ".trim(html_entity_decode(strip_tags($linkData['name']))).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
									}	
									
									
									 if(count($docTrees3)>0)
								   {
										$appliedLinks.=$this->lang->line('txt_Chat').': ';	
										foreach($docTrees3 as $key=>$linkData)
									   {
											 $appliedLinks.="\n - ".trim(html_entity_decode(strip_tags($linkData['name']))).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
									}	
									
									if(count($docTrees4)>0)
									{
									
										$appliedLinks.=$this->lang->line('txt_Task').': ';	
										foreach($docTrees4 as $key=>$linkData)
									   {
											 $appliedLinks.="\n - ".trim(html_entity_decode(strip_tags($linkData['name']))).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
									}	
									
									if(count($docTrees6)>0)
									{
										$appliedLinks.=$this->lang->line('txt_Notes').': ';	
										foreach($docTrees6 as $key=>$linkData)
									   {
											 $appliedLinks.="\n - ".trim(html_entity_decode(strip_tags($linkData['name']))).", ";
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
									}
									
									if(count($docTrees5)>0)
									{
									
										$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
										foreach($docTrees5 as $key=>$linkData)
									   {
											 $appliedLinks.="\n - ".trim(html_entity_decode(strip_tags($linkData['name']))).", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
									
									}
									
									if(count($docTrees7)>0)
									{
									
										$appliedLinks .=$this->lang->line('txt_Files').': ';	
										foreach($docTrees7 as $key=>$linkData)
									   {
											 
											if($linkData['docName']=='')
											 {
												$appliedLinks.="\n - ".$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
											 }
											 else
											 {
											 	/*Changed by Dashrath- Comment old code and add new below after changes */
												//$appliedLinks.="\n - ".$linkData['docName']."_v".$linkData['version'].", ";
												$appliedLinks.=$linkData['docName'].", ";
											 }
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 
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
													 $appliedLinks.="\n - ".$linkData['title'].", ";
													
												}
												$appliedLinks=substr($appliedLinks, 0, -2);
											
											}
								}
		
		
		echo $tag_container.'|||@||'.$appliedLinks;
		
		
		
 
 }
   
 	
}
?>