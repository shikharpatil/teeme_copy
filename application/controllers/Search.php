<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<?php
class Search extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
	//this function used for showing timeline 
	/*function index()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
		}
		else
		{	
		}
	}*/
	
	function text()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->view('login');
		}
		else
		{	
			$this->load->library('pagination');
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/document_db_manager');
		
			$arrDetails=array();
			$arrDetails['workSpaceType'] 	= $this->uri->segment(5);	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$arrDetails['type']   			= $this->uri->segment(6);
			//$arrDetails['query']	   		= $this->input->get('Query', TRUE);
			$arrDetails['query']	   		= $this->uri->segment(7);
			
			$arrDetails['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			//Check if search query has more than 2 letters start
			
			if(strlen(trim($arrDetails['query']))>2)
			{
				$_SESSION['searchText']=urldecode(trim($arrDetails['query']));
						
			//Pagination code start here
				
				$arrDetails['searchResultCount'] = $this->identity_db_manager->getSearchResultCount($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$arrDetails['type'], $arrDetails['query']);
				
				$arrDetails['treeSearchResultCount'] = $this->identity_db_manager->getSearchResultCount($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'tree', $arrDetails['query']);
				$arrDetails['leafSearchResultCount'] = $this->identity_db_manager->getSearchResultCount($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'leaf', $arrDetails['query']);
				$arrDetails['postSearchResultCount'] = $this->identity_db_manager->getSearchResultCount($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'post', $arrDetails['query']);
				$arrDetails['userSearchResultCount'] = $this->identity_db_manager->getSearchResultCount($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'user', $arrDetails['query']);	
			
				$config = array();
				$config["base_url"] = base_url() . "search/text/".$arrDetails['workSpaceId']."/type/".$arrDetails['workSpaceType']."/".$arrDetails['type']."/".$arrDetails['query'];
				$total_row = $arrDetails['searchResultCount'];
				$config["total_rows"] = $total_row;
				$config["per_page"] = 20;
				$config['use_page_numbers'] = TRUE;
				$config['num_links'] = $total_row;
				$config['cur_tag_open'] = '&nbsp;<a class="current">';
				$config['cur_tag_close'] = '</a>';
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				
				$this->pagination->initialize($config);
				if($this->uri->segment(8))
				{
					$page = ($this->uri->segment(8)) ;
				}
				else
				{
					$page = 1;
				}
				$arrDetails['searchResult'] = $this->identity_db_manager->getSearchResult($arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$arrDetails['type'], $arrDetails['query'],'20',$page);	
				$str_links = $this->pagination->create_links();
				$arrDetails["links"] = explode('&nbsp;',$str_links );
			}
			else
			{
				$_SESSION['searchText']=urldecode(trim($arrDetails['query']));
			}
			//Pagination code end here
			//Check for search query more than 2 letters end
			
			//get space tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($arrDetails['workSpaceId']);
			
			$this->load->view('search',$arrDetails);		
		}
	}
}	