<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: admin_help.php
	* Description 		  	: A class file used to manage the teeme help system
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 20-05-2009				Nagalingam						Created the file.			
	**********************************************************************************************************/
/*
* this class is used to manage the teeme help system
*/
class admin_help extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is default function used to call the admin home page
	function index()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$arrDetails['arrTopics'] = $this->help_db_manager->getAllTopics();						
			$this->load->view('admin/view_help_topic', $arrDetails);		
		}
	}	

	// this is a function used to create the topic
	function create_topic()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('topic') != '')
			{
				$this->load->model('help/topic');			
				$topic  = $this->input->post('topic');
				if(count($this->input->post('trees')) > 0)
				{
					$trees	= implode('|',$this->input->post('trees'));
				}	
				$this->topic->setTopicName($topic);	
				$this->topic->setTopicTrees($trees);
				$this->topic->setTopicCreatedDate($this->time_manager->getGMTTime());	
				$this->topic->setTopicCreatedBy($_SESSION['adminId']);
				$this->topic->setTopicModifiedDate($this->time_manager->getGMTTime());	
				$this->topic->setTopicStatus(1);	
				if($this->help_db_manager->insertRecord($this->topic))
				{			
					redirect('admin/admin_help','location');
				}
				else
				{
					redirect('admin/admin_help/create_topic','location');
				}	
			}
			else
			{
				$this->load->view('admin/create_topic', $arrDetails);	
			}			
		}	
	}

	// this is a function used to create the topic in different languages
	function create_lang_topic($topicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('topic') != '')
			{
				$this->load->model('help/lang_topic');			
				$topic  	= $this->input->post('topic');
				$langCode 	= $this->input->post('langCode');
				$this->lang_topic->setTopicId($topicId);		
				$this->lang_topic->setTopicText($topic);	
				$this->lang_topic->setTopicLangCode($langCode);
				
				if($this->help_db_manager->insertRecord($this->lang_topic))
				{			
					redirect('admin/admin_help/view_topic_details/'.$topicId,'location');
				}
				else
				{
					redirect('admin/admin_help/create_topic','location');
				}	
			}
			else
			{
				$arrDetails['languages'] = $this->help_db_manager->getLanguages();	
				$arrDetails['langCodes'] = $this->help_db_manager->getLangCodesByTopicId($topicId);	
				$arrDetails['arrTopics'] 		= $this->help_db_manager->getTopicDetailsByTopicId($topicId);	
				$arrDetails['topicId'] = $topicId;
				$this->load->view('admin/create_lang_topic', $arrDetails);	
			}			
		}	
	}

	// this is a function used to edit the topic for different languages
	function edit_lang_topic($topicId, $langCode)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$langCode = strtoupper($langCode);			
			if($this->input->post('topic') != '')
			{
				$this->load->model('help/lang_topic');			
				$topic  	= $this->input->post('topic');				
				$this->lang_topic->setTopicId($topicId);		
				$this->lang_topic->setTopicText($topic);	
				$this->lang_topic->setTopicLangCode($langCode);
				
				if($this->help_db_manager->updateRecord($this->lang_topic))
				{			
					redirect('admin/admin_help/view_topic_details/'.$topicId,'location');
				}
				else
				{
					redirect('admin/admin_help/edit_lang_topic/'.$topicId.'/'.$langCode,'location');
				}	
			}
			else
			{
				$arrDetails['languages'] = $this->help_db_manager->getLanguages();	
				$arrDetails['langCodes'] = $this->help_db_manager->getLangCodesByTopicId($topicId);	
							
				if(!in_array($langCode, $arrDetails['langCodes']))
				{
					redirect('admin/admin_help/view_topic_details/'.$topicId, 'location');	
				}
				else
				{	
					$arrDetails['arrLangTopics'] = $this->help_db_manager->getLangTopicDetailsByTopicId($topicId, $langCode);	
					$arrDetails['arrTopics'] = $this->help_db_manager->getTopicDetailsByTopicId($topicId);					
					$arrDetails['topicId'] 	= $topicId;
					$arrDetails['langCode'] = $langCode;
					$this->load->view('admin/edit_lang_topic', $arrDetails);
				}			
			}			
		}	
	}
	//this is a function used to delete the topic
	function delete_topic($topicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->help_db_manager->deleteRecord($topicId))
			{			
				redirect('admin/admin_help','location');
			}
			else
			{
				redirect('admin/admin_help/edit_topic/'.$topicId,'location');
			}
		}
	}
	
	// this is a function used to edit the topic
	function edit_topic($topicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('topic') != '')
			{
				$this->load->model('help/topic');			
				$topic  = $this->input->post('topic');
				if(count($this->input->post('trees')) > 0)
				{
					$trees	= implode('|',$this->input->post('trees'));
				}
				$this->topic->setTopicId($topicId);		
				$this->topic->setTopicName($topic);	
				$this->topic->setTopicTrees($trees);					
				$this->topic->setTopicModifiedDate($this->time_manager->getGMTTime());	
				$this->topic->setTopicStatus(1);	
				if($this->help_db_manager->updateRecord($this->topic))
				{			
					redirect('admin/admin_help','location');
				}
				else
				{
					redirect('admin/admin_help/edit_topic/'.$topicId,'location');
				}	
			}
			else
			{
				$arrDetails['arrTopics'] = $this->help_db_manager->getTopicDetailsByTopicId($topicId);	
				$this->load->view('admin/edit_topic', $arrDetails);	
			}			
		}	
	}

	// this is function used to show the sub topic details
	function view_sub_topic()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$arrDetails['arrSubTopics'] = $this->help_db_manager->getAllSubTopics();						
			$this->load->view('admin/view_help_sub_topic', $arrDetails);		
		}
	}	

	// this is a function used to create the topic in different languages
	function create_lang_sub_topic($subTopicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('subTopic') != '')
			{
				$this->load->model('help/lang_sub_topic');			
				$subTopic  	= $this->input->post('subTopic');
				$langCode 	= $this->input->post('langCode');
				$contents 	= addslashes($this->input->post('contents'));
				$this->lang_sub_topic->setSubTopicId($subTopicId);		
				$this->lang_sub_topic->setSubTopicText($subTopic);	
				$this->lang_sub_topic->setSubTopicLangCode($langCode);
				$this->lang_sub_topic->setSubTopicContents($contents);
				
				if($this->help_db_manager->insertRecord($this->lang_sub_topic))
				{			
					redirect('admin/admin_help/view_sub_topic_details/'.$subTopicId,'location');
				}
				else
				{
					redirect('admin/admin_help/view_sub_topic_details/'.$subTopicId,'location');
				}	
			}
			else
			{
				$arrDetails['languages'] = $this->help_db_manager->getLanguages();	
				$arrDetails['langCodes'] = $this->help_db_manager->getLangCodesBySubTopicId($subTopicId);	
				$arrDetails['subTopicId'] = $subTopicId;
				$this->load->view('admin/create_lang_sub_topic', $arrDetails);	
			}			
		}	
	}

	// this is a function used to edit the topic for different languages
	function edit_lang_sub_topic($subTopicId, $langCode)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$langCode = strtoupper($langCode);			
			if($this->input->post('subTopic') != '')
			{
				$this->load->model('help/lang_sub_topic');			
				$subTopic  	= $this->input->post('subTopic');
				$contents 	= addslashes($this->input->post('contents'));					
				$this->lang_sub_topic->setSubTopicId($subTopicId);		
				$this->lang_sub_topic->setSubTopicText($subTopic);	
				$this->lang_sub_topic->setSubTopicLangCode($langCode);		
				$this->lang_sub_topic->setSubTopicContents($contents);					
				if($this->help_db_manager->updateRecord($this->lang_sub_topic))
				{			
					redirect('admin/admin_help/view_sub_topic_details/'.$subTopicId,'location');
				}
				else
				{
					redirect('admin/admin_help/edit_lang_sub_topic/'.$subTopicId.'/'.$langCode,'location');
				}	
			}
			else
			{
				$arrDetails['languages'] = $this->help_db_manager->getLanguages();	
				$arrDetails['langCodes'] = $this->help_db_manager->getLangCodesBySubTopicId($subTopicId);	
							
				if(!in_array($langCode, $arrDetails['langCodes']))
				{
					redirect('admin/admin_help/view_sub_topic_details/'.$subTopicId, 'location');	
				}
				else
				{	
					$arrDetails['arrLangSubTopics'] = $this->help_db_manager->getLangSubTopicDetailsBySubTopicId($subTopicId, $langCode);					
					$arrDetails['subTopicId'] 	= $subTopicId;
					$arrDetails['langCode'] 	= $langCode;
					$this->load->view('admin/edit_lang_sub_topic', $arrDetails);
				}			
			}			
		}	
	}
	// this is a function used to create the sub topic
	function create_sub_topic()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('subTopic') != '')
			{
				$this->load->model('help/sub_topic');	
				$subTopicName  	= $this->input->post('subTopic');		
				$topicId  		= $this->input->post('topic');
				$contents  		= addslashes(trim($this->input->post('contents')));
				$this->sub_topic->setSubTopicName($subTopicName);	
				$this->sub_topic->setTopicId($topicId);	
				$this->sub_topic->setSubTopicContents($contents);
				$this->sub_topic->setSubTopicCreatedDate($this->time_manager->getGMTTime());	
				$this->sub_topic->setSubTopicCreatedBy($_SESSION['adminId']);
				$this->sub_topic->setSubTopicModifiedDate($this->time_manager->getGMTTime());	
				$this->sub_topic->setSubTopicStatus(1);	
				if($this->help_db_manager->insertRecord($this->sub_topic))
				{			
					redirect('admin/admin_help/view_sub_topic','location');
				}
				else
				{
					redirect('admin/admin_help/create_sub_topic','location');
				}	
			}
			else
			{
				$arrDetails['arrTopics'] = $this->help_db_manager->getAllTopics();	
				$this->load->view('admin/create_sub_topic', $arrDetails);	
			}			
		}	
	}	
	// this is a function used to edit the sub topic
	function edit_sub_topic($subTopicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			if($this->input->post('subTopic') != '')
			{
				$this->load->model('help/sub_topic');			
				$subTopic  = $this->input->post('subTopic');
				$contents  = addslashes(trim($this->input->post('contents')));
				$this->sub_topic->setSubTopicId($subTopicId);		
				$this->sub_topic->setSubTopicName($subTopic);	
				$this->sub_topic->setSubTopicContents($contents);					
				$this->sub_topic->setSubTopicModifiedDate($this->time_manager->getGMTTime());	
				$this->sub_topic->setSubTopicStatus(1);	
				if($this->help_db_manager->updateRecord($this->sub_topic))
				{			
					redirect('admin/admin_help/view_sub_topic','location');
				}
				else
				{
					redirect('admin/admin_help/edit_sub_topic/'.$subTopicId,'location');
				}	
			}
			else
			{
				$arrDetails['arrSubTopics'] = $this->help_db_manager->getSubTopicDetailsBySubTopicId($subTopicId);	
				$this->load->view('admin/edit_sub_topic', $arrDetails);	
			}			
		}	
	}
	// this is a function used to show the topic details
	function view_topic_details($topicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$arrDetails['languages'] 		= $this->help_db_manager->getLanguages();;					
			$arrDetails['arrTopics'] 		= $this->help_db_manager->getTopicDetailsByTopicId($topicId);	
			$arrDetails['arrLangTopics'] 	= $this->help_db_manager->getLangTopicsByTopicId($topicId);	
				
			$this->load->view('admin/view_topic_details', $arrDetails);						
		}	
	}	

	// this is a function used to show the sub topic details
	function view_sub_topic_details($subTopicId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$arrDetails = array();	
			$this->load->model('dal/help_db_manager');
			$this->load->model('dal/time_manager');	
			$arrDetails['languages'] 			= $this->help_db_manager->getLanguages();;					
			$arrDetails['arrSubTopics'] 		= $this->help_db_manager->getSubTopicDetailsBySubTopicId($subTopicId);	
			$arrDetails['arrLangSubTopics'] 	= $this->help_db_manager->getLangSubTopicsBySubTopicId($subTopicId);	
				
			$this->load->view('admin/view_sub_topic_details', $arrDetails);						
		}	
	}			
}
?>