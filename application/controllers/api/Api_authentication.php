<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_authentication extends MY_Controller
{
    public function __construct() 
	{
        parent::__construct();
    }    
    
    //get user login details
    function user_login_details_post()
    {
        $this->load->model('dal/identity_db_manager');
        $objIdentity = $this->identity_db_manager;

        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $userName = trim($obj['data']['userName']);
        $password = trim($obj['data']['userPassword']);
        $placeName = trim($obj['data']['placeName']);
        $validPlaceNameStatus = $objIdentity->validatePlace($placeName);
        if($validPlaceNameStatus==1)
        {    
            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_'.$placeName;
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);
            
            $workPlaceId = $objIdentity->getWorkPlaceIdByWorkPlaceName($placeName);
            $contName    = $placeName;   
            $workPlaceStatus = $objIdentity->getWorkPlaceStatus($workPlaceId);

            $UserInfo = $objIdentity->getUserDetailsByUsername($userName,'0',$workPlaceId);
           
        if(count($UserInfo)>0)
        {
            $userGroup = $this->identity_db_manager->getUserGroupByMemberId($UserInfo['userId']);
            $workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId); 
            
            if($workPlaceData['status']==0){
                $error = $this->lang->line('place_not_active');  
                echo json_encode($error);
                exit;            
            }
            elseif($UserInfo['status']==1){
                $error = $this->lang->line('user_not_active');   
                echo json_encode($error);
                exit;            
            }
            else
            {
                if ($this->identity_db_manager->verifySecurePassword($password,$UserInfo['password']))  
                {
                    $hasSpace = $this->identity_db_manager->hasWorkspace($UserInfo['userId']);
                    $countWorkspace = $this->identity_db_manager->countWorkspace($UserInfo['userId']);
                    $workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $workPlaceId,$UserInfo['userId'] );

                    if($countWorkspace==1 && $userGroup==0)
                            {
                                foreach($workSpaces as $keyVal=>$workSpaceData)
                                {
                                    if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$UserInfo['userId']) && $workSpaceData['status']>0)
                                    {
                                        if($workSpaceData['workSpaceId']==1)
                                        {
                                            $error = $this->lang->line('txt_No_Space_Assigned');             
                                            //redirect('/'.$contName, 'location');    
                                        }
                                    }
                                }
                            }

                            if ($userGroup!=0 || ($userGroup==0 && $hasSpace>0))
                            {
                                            if($userGroup!=0)
                                            {
                                                if ($UserInfo['needPasswordReset']==1)
                                                {
                                                    $needPasswordReset =1;
                                                }
                                            }


                                            if($UserInfo['nickName']!='')
                                            {
                                                $userTagName  = $UserInfo['nickName'];
                                            }
                                            else
                                            {
                                                $userTagName  = $UserInfo['tagName'];
                                            }    

                                            $userdetails = array("userdetails" => (array(array(
                                                "status"=>"1",
                                                "workPlaceId"=> $workPlaceId,
                                                "contName"=> $contName,
                                                "userId"=> $UserInfo['userId'],
                                                "userName"=> $UserInfo['userName'],
                                                "firstName"=> $UserInfo['firstName'],
                                                "lastName"=> $UserInfo['lastName'],
                                                "photo"=> $UserInfo['photo'],
                                                "userGroup"=> $UserInfo['userGroup'],
                                                "userTagName"=> $userTagName,
                                            )
                                            ))); 
                            
                                $error = '';
                                
                            }
                            else
                            {
                                $error = $this->lang->line('txt_No_Space_Assigned');             
                                //redirect('/'.$contName, 'location');    
                            }   
                            $defaultSpace = $UserInfo['defaultSpace'];

                            if($needPasswordReset==1)
                            {
                                //redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
                                //redirect('dashboard/password_reset/0/type/1', 'location');
                            }
                            else
                            {

                            if ($userGroup==0 && $hasSpace>0 && $defaultSpace==0)
                                {
                                    foreach($workSpaces as $keyVal=>$workSpaceData)
                                    {
                                        if($workSpaceData['workSpaceId']!=1)
                                        {
                                            
                                            if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$UserInfo['userId']) && $workSpaceData['status']>0)
                                            {    
                                                //redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
                                                echo json_encode('first');
                                                exit;
                                            }
                                            
                                        }
                                    }
                                }
                                
                                if ($defaultSpace!=0)
                                {
                                    if ($this->identity_db_manager->isWorkSpaceMember($defaultSpace,$UserInfo['userId']))
                                    {    
                                         //   redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
                                            //$success = '1';
                                            //echo json_encode($success);
                                            echo json_encode($userdetails);
                                            exit;
                                    }
                                    else
                                    {
                                        if ($userGroup!=0)
                                        {
                                            //redirect('dashboard/index/0/type/1', 'location');
                                            echo json_encode('third');
                                            exit;
                                        }
                                        else
                                        {
                                            foreach($workSpaces as $keyVal=>$workSpaceData)
                                            {
                                                if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$UserInfo['userId']) && $workSpaceData['status']>0)
                                                {    
                                                    //redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
                                                    echo json_encode('fourth');
                                                    exit;
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                //redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
                                $success = 'Login successfully'; 
                                echo json_encode($success);
                                exit;
                            }
                        }
                        else
                        {
                            $error = $this->lang->line('Error_invalid_password'); 
                            echo json_encode($error);
                            exit;   
                            //redirect('/'.$contName, 'location');
                        }     
                }

            }
            else
            {
                $error = $this->lang->line('msg_login_error');   
                echo json_encode($error);
                exit; 
                //redirect('/'.$contName, 'location');
            }

        }
        else
        {
            $error = $this->lang->line('invalid_place_name'); 
            echo json_encode($error);
            exit;   
            //redirect('/'.$contName, 'location');
        }    
        //$validPlaceName = $objIdentity->validatePlace($placeName);
        //$test = 'hello';
        $userdetails['userName'] = $userName;
        $userdetails['userPassword'] = $userPassword;
        $userdetails['placeName'] = $placeName;
        
        echo json_encode($userdetails);
    }

    //get user place lists
    function user_place_get()
    {
        $this->load->model('dal/identity_db_manager');
        $objIdentity = $this->identity_db_manager;
        
        echo json_encode('');
    }

    //get user place details
    function place_details_get()
    {
        $this->load->model('dal/identity_db_manager');
        $objIdentity = $this->identity_db_manager;
        
        echo json_encode('');
    }

	//Test react native ajax calling 
	function ajax_test_post()
	{
		$array = array("users" => (array(array(
            "id"=> "1", "name"=> "John Doe", "createddate"=> "14 nov 2018"
        ),array(
            "id"=> "2", "name"=> "Paul Smith", "createddate"=> "11 nov 2018"
        ),array(
            "id"=> "3", "name"=> "Mary Robson", "createddate"=> "08 nov 2018"
        ),array(
            "id"=> "4", "name"=> "Peter Johnson", "createddate"=> "13 oct 2018"
        ),array(
            "id"=> "5", "name"=> "John paul", "createddate"=> "04 oct 2018"
        ),
    	))); 
		echo json_encode($array);
	}
    //Get document tree list
    function get_document_list_post()
    {       
            $this->load->model('dal/time_manager'); 
            $this->load->model('dal/identity_db_manager');      
            $this->load->model('dal/tag_db_manager');                   
            $this->load->model('container/document');
            $this->load->model('dal/document_db_manager');      

            $objIdentity    = $this->identity_db_manager;
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';
            $arrDetails['workSpaceType']    = $workSpaceType;   
            $arrDetails['workSpaceId']      = $workSpaceId;

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   
    
           
                $arrDetails['workSpaceDetails']     = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);                                   
               
                $sortOrder  = 1;
                $sortBy     = 3;
                  
                $arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType, 1, $sortBy, $sortOrder);      
                //$arrDocuments = $this->document_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType, 1, $sortBy, $sortOrder);    
                //$arrDetails['arrDocuments'] = (object)$arrDocuments;
                //$arrDocViewPage['documentContributors'] = $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
                
                //echo json_encode($arrDetails);
                
                $i = 0;
                foreach ($arrDetails['arrDocuments'] as $keys=>$data)
                {
                     unset($arrDetails['arrDocuments'][$keys]);
                     $arrDetails['arrDocuments'][$i] = $data;
                     $userDetails = $this->document_db_manager->getUserDetailsByUserId($data['userId']); 
                     $arrDetails['arrDocuments'][$i]['usrtagname']= $userDetails['userTagName'];
                     $treedate = $this->time_manager->getUserTimeFromGMTTime($data['editedDate'], 'm-d-Y h:i A');   
                     $arrDetails['arrDocuments'][$i]['treedate'] = $treedate;   
                     $arrDetails['arrDocuments'][$i]['treeId'] = $keys;
                     $i++;
                } 

                echo json_encode($arrDetails);
                exit;            
    }   
    //Get space(s) list
    function get_space_list_post()
    {       
            $this->load->model('dal/time_manager'); 
            $this->load->model('dal/identity_db_manager');      
            $this->load->model('dal/tag_db_manager');                   
            $this->load->model('container/document');
            $this->load->model('dal/document_db_manager');      
            $objIdentity    = $this->identity_db_manager;
            
            $userId = '1';
            $workPlaceId    = '65';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   
               
            $workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $workPlaceId, $userId );

            $i=0;
            foreach($workSpaces as $keyVal=>$workSpaceData)
            {
                if($workSpaceData['workSpaceManagerId'] == 0)
                {
                    $workSpaces[$i]['workSpaceManager'] = $this->lang->line('txt_Not_Assigned');
                }
                else
                {                   
                    $arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
                    $workSpaces[$i]['workSpaceManager'] = $arrUserDetails['userName'];
                }

                if ($workSpaceData['status']>0)
                    {
                                     if ($this->identity_db_manager->isDefaultPlaceManagerSpace($workSpaceData['workSpaceId'],$workPlaceId))
                                     {
                                        if (($this->identity_db_manager->isPlaceManager($workPlaceId,$userId) == $userId))
                                        {
                                            if (($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$userId)) || ($this->identity_db_manager->checkManager($userId,$workSpaceData['workSpaceId'],3))) 
                                            {    
                                                $workSpaces[$i]['selectedWorkSpaceName'] = $workSpaceData['workSpaceName'];    
                                            }
                                            else
                                            {
                                                $workSpaces[$i]['selectedWorkSpaceName'] = '';
                                            }
                                        }
                                     }
                                     else
                                     {
                                           if (($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$userId)) || ($this->identity_db_manager->checkManager($userId,$workSpaceData['workSpaceId'],3))) 
                                            {  
                                                $workSpaces[$i]['selectedWorkSpaceName'] = $workSpaceData['workSpaceName'];
                                            }
                                            else
                                            {
                                                $workSpaces[$i]['selectedWorkSpaceName'] = '';
                                            }
                                     }
                    }    
                    $i++;
            }     
                 
            $workSpaces['workspacedetails'] = $workSpaces;
            echo json_encode($workSpaces);
            exit;            
    } 
    //Get tree leaf(s)
    function get_document_leaf_list_post()
    {
            $this->load->model('dal/identity_db_manager');  
            $this->load->model('dal/discussion_db_manager');    
            $this->load->model('dal/time_manager');
            $this->load->model('dal/tag_db_manager');
            $this->load->model('dal/notes_db_manager');                     
            $objIdentity    = $this->identity_db_manager;   
            $this->load->model('container/document');
            $this->load->model('dal/document_db_manager');  
            $this->load->model('dal/chat_db_manager');  
    
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $treeId = trim($obj['data']['treeId']);    

            $spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
            if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
            {
                $treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceId);
                if($treeTypeStatus==1)
                {
                    $error = $this->lang->line('msg_no_access_space');
                    echo json_encode($error);
                    exit;
                }
            }

            if ($workSpaceId!=0)
            {
                if ($workSpaceType==1)
                {
                    if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$userId) && !$objIdentity->checkManager($userId,$workSpaceId ,3))
                    {
                        $error = $this->lang->line('msg_no_access_space');
                        echo json_encode($error);
                        exit;
                    }
                }
                else if ($workSpaceType==2)
                {
                    if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$userId))
                    {
                        $error = $this->lang->line('msg_no_access_subspace');
                        echo json_encode($error);
                        exit;
                    }   
                }
            }
            else
            {
                if ($objIdentity->isShared($treeId))
                {
                    $sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);   
                    if (!in_array($userId,$sharedMembers))
                    {
                        $error = $this->lang->line('msg_no_access_space');
                        echo json_encode($error);
                        exit;      
                    }
                }
                else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $userId)
                {
                    $error = $this->lang->line('msg_no_access_space');
                    echo json_encode($error);
                    exit;          
                }
            }

            $this->document_db_manager->setTreeUpdateCount($treeId);
                
            $arrDocViewPage['documentDetails']  = $this->document_db_manager->getDocumentFromDB($treeId);   
            $arrDocumentDetails = $this->document_db_manager->getDocumentDetailsByTreeId($treeId);      
            foreach ($arrDocViewPage['documentDetails'] as $key=>$leafData)
            {
                //echo $key.'=='.$leafData->tagName;
                //echo '<br>';
                if($arrDocumentDetails['latestVersion']==1)
                {
                    $url = base_url().'workplaces';
                    $leafContent = str_replace('/bugs_teeme/workplaces', $url, $leafData->contents);
                    //less content
                        $leafStripContent=strip_tags($leafData->contents);
                        if (strlen($leafStripContent) > 65) 
                        {
                            $leafTitle = '<p>'.substr($leafStripContent, 0, 65) . "... <span>see more</span></p>"; 
                        }
                        else
                        {
                            $leafTitle = $leafContent;
                        }
                    $arrDocViewPage['documentDetails'][$key]->leafTitle = $leafTitle;    
                    //less content
                    $arrDocViewPage['documentDetails'][$key]->contents = $leafContent;                        
                    $treeTime = '';
                    $usrTagName = '';
                    if($leafData->nickName!='')
                    {
                        $usrTagName = $leafData->nickName;
                    }
                    else
                    {
                        $usrTagName = $leafData->tagName;
                    }
                    $arrDocViewPage['documentDetails'][$key]->usrtagname = $usrTagName;

                    $leafTime='';
                    if($leafData->editedDate[0]==0)
                    {
                        $leafTime=$leafData->createdDate;
                    }   
                    else
                    {
                        $leafTime=$leafData->editedDate;
                    }    
                    $treeTime =  $this->time_manager->getUserTimeFromGMTTime($leafTime, $this->config->item('date_format'));
                    $arrDocViewPage['documentDetails'][$key]->treedate = $treeTime;
                    $arrDocViewPage['documentDetails'][$key]->treeId = $treeId;
                }
            }   

            //$arrDocViewPage['documentContributors'] = $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
            
            echo json_encode($arrDocViewPage);
            exit;   
    }
    //Get leaf previous version data
    function get_document_previous_leaf_post()
    {
            $this->load->model('dal/identity_db_manager');  
            $this->load->model('dal/time_manager');
            $objIdentity    = $this->identity_db_manager;   
            $this->load->model('dal/document_db_manager');  
            
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $predecessorId = trim($obj['data']['predecessor']);    
           
            $nodeId = '1581';
            $predecessor = '1582';
            $leafVersion = '2';
            $leafId = '1581';
            $nodeOrder = '1';
            $treeId = '1751';
            $nodeBgColor = 'row1';

            $arrParams['leafParentId']  = '1574';
            $arrParams['leafId']        = '1581';
            $arrParams['curLeafId']     = '1581';
            $arrParams['leafOrder']     = '2';
            $arrParams['treeId']        = '1751';
            $arrParams['workSpaceId']   = $workSpaceId;
            $arrParams['workSpaceType'] = $workSpaceType;
            $arrParams['bgcolor']       = 'row1'; 
            $arrParams['nodeId']        = '1581';      

            /*1581,1574,2,'1581',1,1751,15,1,'row1','1581'
            showLeafPrevious('.nodeId1.','.predecessor.','.leafVersion.',\''.leafId.'\','.nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.nodeId1.'\')*/

            //$arrDocViewPage['leafDetails']  = $this->document_db_manager->getLeafPreviousContentsByLeafId($arrParams); 
            //$arrDocViewPage['documentContributors'] = $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
            $arrDocViewPage['leafDetails']  = $this->document_db_manager->getPerentInfo($predecessorId);
            $url = base_url().'workplaces';
            $leafContent = str_replace('/copy_teeme/workplaces', $url, $arrDocViewPage['leafDetails']['contents']);
            $arrDocViewPage['leafDetails']['contents'] = $leafContent;              
            echo json_encode($arrDocViewPage);
            exit;   
    }
    //Get leaf next version data
    function get_document_next_leaf_post()
    {
            $this->load->model('dal/identity_db_manager');  
            $this->load->model('dal/time_manager');
            $objIdentity    = $this->identity_db_manager;   
            $this->load->model('dal/document_db_manager');  
            
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $successorsId = trim($obj['data']['successors']);    
           
            $nodeId = '1581';
            $successor = '1583';
            $leafVersion = '2';
            $leafId = '1581';
            $nodeOrder = '1';
            $treeId = '1751';
            $nodeBgColor = 'row1';

            $arrParams['leafParentId']  = '1574';
            $arrParams['leafId']        = '1581';
            $arrParams['curLeafId']     = '1581';
            $arrParams['leafOrder']     = '2';
            $arrParams['treeId']        = '1751';
            $arrParams['workSpaceId']   = $workSpaceId;
            $arrParams['workSpaceType'] = $workSpaceType;
            $arrParams['bgcolor']       = 'row1'; 
            $arrParams['nodeId']        = '1581';      

            /*1581,1574,2,'1581',1,1751,15,1,'row1','1581'
            showLeafPrevious('.nodeId1.','.predecessor.','.leafVersion.',\''.leafId.'\','.nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$nodeBgColor.'\',\''.nodeId1.'\')*/

            //$arrDocViewPage['leafDetails']  = $this->document_db_manager->getLeafPreviousContentsByLeafId($arrParams); 
            //$arrDocViewPage['documentContributors'] = $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
            $arrDocViewPage['leafDetails']  = $this->document_db_manager->getPerentInfo($successorsId);
            $url = base_url().'workplaces';
            $leafContent = str_replace('/copy_teeme/workplaces', $url, $arrDocViewPage['leafDetails']['contents']);
            $arrDocViewPage['leafDetails']['contents'] = $leafContent;                 
            
            
            echo json_encode($arrDocViewPage);
            exit;   
    }
    //Get notification(s) by tree type id
    function get_notification_list_post()
    {
            $this->load->model('dal/notification_db_manager');   
            $this->load->model('dal/identity_db_manager');  
            $this->load->model('dal/time_manager'); 
            $objIdentity    = $this->identity_db_manager;   
            $objTime    = $this->time_manager;
            $modeId = '1';

            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $successorsId = trim($obj['data']['successors']);    
           
            //Notification code start here
            $allNotificationEvents  = $this->notification_db_manager->get_all_app_notification_events($modeId,$userId);
            
            if(count($allNotificationEvents)>0)
            {   $i=0;
                foreach($allNotificationEvents as $notificationEventDetails)
                {
                    $notificationEventData = $this->notification_db_manager->get_notification_events_data($notificationEventDetails['notification_event_id'],'',$workSpaceId);
                    foreach($notificationEventData as $notificationEventContent)
                    {
                        $object_instance_id=$notificationEventContent['object_instance_id'];
                        $object_id=$notificationEventContent['object_id'];
                        $action_id=$notificationEventContent['action_id'];
                        $notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
                                'object_id' => $notificationEventContent['object_id'],
                                'action_id' => $notificationEventContent['action_id'],
                                'object_instance_id' => $notificationEventContent['object_instance_id'],
                                'action_user_id' => $notificationEventContent['action_user_id'],
                                'workSpaceId' => $notificationEventContent['workSpaceId'],
                                'workSpaceType' => $notificationEventContent['workSpaceType'],
                                'url' => $notificationEventContent['url'],
                                'created_date' => $notificationEventContent['created_date']
                        );
                    }
                    $i++;
                }
                if(count($notificationEventsDataArray)>0)
                {
                    foreach($notificationEventsDataArray as $key=>$objectInstanceData)
                    {
                        foreach($objectInstanceData as $objectInstanceValue)
                        {
                            foreach($objectInstanceValue as $objectContent)
                            {
                                $objectContent=array_reverse($objectContent);
                                $i=0;
                                foreach($objectContent as $objectValue)
                                {
                                    $objectInstanceId=$objectValue['object_instance_id'];
                                    $objectId=$objectValue['object_id'];
                                    $actionId=$objectValue['action_id'];
                                    $action_user_ids[]=$objectValue['action_user_id'];
                                    $workSpaceId=$objectValue['workSpaceId'];
                                    $workSpaceType=$objectValue['workSpaceType'];
                                    $url=$objectValue['url'];
                                    $created_date=$objectValue['created_date'];
                                    $i++;
                                    $action_count = $i;
                                }
                                
                                //notification start here
                                    //Condition for object and action id start
                                    $treeId='0';
                                    $leafData='';
                                    $treeContent='';
                                    $talkContent='';
                                    $treeName='';
                                    $postFollowStatus='';
                                    $personalize_status='';
                                    if($objectId==1)
                                    {
                                        $treeId=$objectInstanceId;  
                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                    }
                                    if($objectId==2)
                                    {   
                                        $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);  
                                        $leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                    }
                                    if($objectId==3)
                                    {   
                                        $treeId=0;
                                        $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
                                        if($actionId==13)
                                        {
                                            $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
                                        }
                                    }
                                    if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
                                    {
                                        if($actionId==4 || $actionId==13)
                                        {
                                            //$leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
                                            $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                            $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
                                        }
                                        if($url=='')
                                        {
                                            $treeId=$objectInstanceId;
                                            $treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
                                        }
                                        else
                                        {
                                            $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);
                                            $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
                                            if($treeId==0)
                                            {
                                                $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
                                                if($postFollowStatus==1)
                                                {
                                                    $personalize_status='1';
                                                }
                                                $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,'3');
                                                $treeType = 'post';  
                                                $treeName = 'post_tree.png';
                                            }
                                        }
                                        //print_r($leafData);
                                        //exit;
                                        /*if(count($leafData)==0 || empty($leafData))
                                        {
                                            $treeId = $objectInstanceId;
                                            $treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
                                        }*/
                                    }
                                    if($objectId==8)
                                    {
                                        $treeId=$objectInstanceId;  
                                        $talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                        $talkContent=strip_tags($talkContent);
                                        if(strlen($talkContent) > 25)
                                        {
                                            $talkContent = substr($talkContent, 0, 25) . "..."; 
                                        }
                                    }
                                    if($objectId==9)
                                    {
                                        $fileName='';
                                        $fileDetails = $this->notification_db_manager->getImportedFileNameById($objectInstanceId);
                                        if($fileDetails['docCaption']!='')
                                        {
                                            $fileName = $fileDetails['docCaption'];
                                        }
                                    }
                                    if($objectId==14 || $objectId==1 || $objectId==2 || $objectId==3)
                                    {
                                        if($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17)
                                        {
                                            $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                            $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
                                            $currentUserName='';
                                            $currentUserDetails = $this->identity_db_manager->getUserDetailsByUserId($userId);
                                            if($currentUserDetails['firstName']!='' && $currentUserDetails['lastName']!='')
                                            {
                                                $currentUserName = $currentUserDetails['firstName'].' '.$currentUserDetails['lastName'];
                                            }
                                            $summarizeData = str_replace($currentUserName,"You",$summarizeData);
                                            //echo $summarizeData; exit;
                                            if($summarizeData=='' && ($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17))
                                            {
                                                $summarizeData='You';
                                            }
                                        }
                                        if($objectId!=2)
                                        {
                                            $treeId=$objectInstanceId;  
                                            $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                        }
                                    }
                                    if($objectId==15 || $objectId==16)
                                    {
                                        $memberName='';
                                        $memberDetails = $this->identity_db_manager->getUserDetailsByUserId($objectInstanceId);
                                        if($memberDetails['userTagName']!='')
                                        {
                                            $memberName = $memberDetails['userTagName'];
                                        }
                                    }
                                    
                                    if($treeContent!='')
                                    {
                                        $treeContent=strip_tags($treeContent);
                                        if(strlen($treeContent) > 25)
                                        {
                                            $treeContent = substr($treeContent, 0, 25) . "..."; 
                                        }
                                    }                                       
                                    if(count($leafData)>0)
                                    {
                                        $leafdataContent=strip_tags($leafData['contents']);
                                        if (strlen($leafdataContent) > 25) 
                                        {
                                            $leafTitle = substr($leafdataContent, 0, 25) . "..."; 
                                        }
                                        else
                                        {
                                            $leafTitle = $leafdataContent;
                                        }
                                        if($leafTitle=='')
                                        {
                                            $leafTitle = $this->lang->line('content_contains_only_image');
                                        }
                                    }
                                    
                                    //Condition for object and action id end
                                    
                                    if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
                                    {
                                        if($treeContent!='')
                                        {
                                            $leafTitle = $treeContent;
                                        }
                                    }
                                    
                                    if(count($action_user_ids)>0)
                                    {
                                        //Set notification dispatch data start
                                        if($workSpaceId==0)
                                        {
                                            //$workSpaceMembers = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
                                            if($workSpaceType == 0 || $workSpaceType == '')
                                            {                   
                                                $work_space_name = '';
                                            }
                                            else
                                            {
                                                $work_space_name = $this->lang->line('txt_My_Workspace');
                                            }
                                        }
                                        else
                                        {
                                            if($workSpaceType == 1)
                                            {                   
                                                $workSpaceDetails   = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
                                                $work_space_name = $workSpaceDetails['workSpaceName'];
                                            }
                                            else if($workSpaceType == 2)
                                            {               
                                                $workSpaceDetails   = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
                                                $work_space_name = $workSpaceDetails['subWorkSpaceName'];
                                            }
                                        }
                                        
                                        $getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", array_reverse($action_user_ids))));
                                        foreach($getSummarizationUserIds as $key =>$user_id)
                                        {
                                            if($user_id==$userId || $user_id==0)
                                            {
                                                unset($getSummarizationUserIds[$key]);
                                            }
                                        }
                                        $recepientUserName='';
                                                                        
                                        $i=0;
                                        $otherTxt='';
                                        if(count($getSummarizationUserIds)>2)
                                        {
                                            $totalUsersCount = count($getSummarizationUserIds)-2;   
                                            $otherTxt=str_replace('{userName}', $totalUsersCount ,$this->lang->line('txt_summarize_msg'));
                                        }
                                        foreach($getSummarizationUserIds as $user_id)
                                        {
                                            if($i<2)
                                            {
                                                $getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
                                                if($getUserName['userTagName']!='')
                                                {
                                                    //$recepientUserNameArray[] = $getUserName['firstName'].' '.$getUserName['lastName'];
                                                    $recepientUserNameArray[] = $getUserName['userTagName'];
                                                }
                                            }
                                            $i++;
                                        }   
                                        $recepientUserName=implode(', ',$recepientUserNameArray).' '.$otherTxt; 
                                        unset($recepientUserNameArray);
                                        
                                        //Summarize data start here
                                    
                                        /*if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
                                        {*/
                                            //get user language preference
                                            $userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userId);
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
                                            $getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId);
                                            $getNotificationTemplate=trim($getNotificationTemplate);
                                            $tagType='';
                                            $userType='';
                                            $tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
                                            if ($tree_type_val==1){ $treeType = 'document'; $treeName = 'document_tree.png';}
                                            if ($tree_type_val==3){ $treeType = 'discuss';  $treeName = 'discuss_tree.png'; }
                                            if ($tree_type_val==4){ $treeType = 'task';    $treeName = 'task_tree.png'; }
                                            if ($tree_type_val==6) { $treeType = 'notes';      $treeName = 'notes_tree.png';}   
                                            if ($tree_type_val==5) { $treeType = 'contact';  $treeName = 'contact_tree.png'; }
                                            if ($objectId==3) { $treeType = 'post';  $treeName = 'post_tree.png';}
                                            if($treeName!='')
                                            {
                                                $treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';
                                            }
                                            $leafIcon='<img title="leaf" src="'.base_url().'images/tab-icon/leaf_icon.png"/>';
                                            if($objectId==4){ $tagType = 'simple tag'; }
                                            if($objectId==5){ $tagType = 'action tag'; }
                                            if($objectId==6){ $tagType = 'contact tag';}
                                            if($objectId==15 || $objectId==14 || $objectId==1 || $objectId==2){ $userType = 'user'; }
                                            if($objectId==16){ $userType = 'place manager'; }
                                            if(tagType!='')
                                            {
                                                $tagIcon='<img alt="image" title="'.$tagType.'" src="'.base_url().'images/tab-icon/tag_icon.png"/>';
                                            }
                                            $linkIcon='<img alt="image" title="link" src="'.base_url().'images/tab-icon/link_icon.png"/>';
                                            $talkIcon='<img alt="image" title="talk" src="'.base_url().'images/tab-icon/talk_tree.png"/>';
                                            $fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';
                                            if($userType!='')
                                            {
                                                $userIcon='<img alt="image" title="'.$userType.'" src="'.base_url().'images/tab-icon/user.png"/>';
                                            }
                                            $user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}");
                                            $user_translate_template   = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count);
                                                                            
                                            $notificationContent=array();
                                            $notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
                                            
                                            
                                            if(($objectId =='2' && $actionId=='1') || $actionId=='4' || $actionId=='14' || $actionId=='5' || $actionId=='6')
                                            {
                                                $personalize_status ='';
                                                if($treeId != '' && $treeId != '0')
                                                {
                                                    $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
                                                }
                                                if($objectFollowStatus['preference']==1)
                                                {
                                                    $personalize_status='1';
                                                }
                                                
                                            }                                           
                                                                                        
                                            if($actionId=='2' || $actionId=='11' || $actionId=='13')
                                            {
                                                $personalize_status ='';
                                                $originatorUserId=$this->notification_db_manager->get_object_originator_id($objectId,$objectInstanceId);
                                                if($treeId != '' && $treeId != '0')
                                                {
                                                    $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
                                                }
                                                if($originatorUserId==$userId || $postFollowStatus==1 || $objectFollowStatus['preference']==1)
                                                {
                                                    $personalize_status='1';
                                                }
                                                
                                            }
                                            if($tree_type_val==1)
                                            {    
                                                $notificationContentArray[] = array(
                                                    'notification_data' => $notificationContent['data'],
                                                    'url' => $url,
                                                    'create_time' => $created_date,
                                                    'objectId' => $objectId,
                                                    'actionId' => $actionId,
                                                    'personalize_status' => $personalize_status,
                                                    'treeType' => $tree_type_val,
                                                    'work_space_name' => $work_space_name,
                                                    'tree_type_space_id' => $workSpaceId
                                                );
                                            }
                                        /*}*/
                                        //Summarize data end here
                                    }
                                        unset($action_user_ids);
                                    //notification end here
                            }
                        }
                    }
                }
            }
            foreach ($notificationContentArray as $key => $node) {
                $timestamps[$key]=strtotime($node['create_time']) ;
            }
            array_multisort($timestamps, SORT_DESC, $notificationContentArray);
            
            $notificationDataArray['notificationData']=$notificationContentArray;
            //Notification code end here
            
            echo json_encode($notificationDataArray);
            exit;   
    }
    //Get tree tags details
    function get_tag_details_post()
    {
            $this->load->model('dal/time_manager');
            $this->load->model('dal/tag_db_manager');       
            $this->load->model('dal/document_db_manager');                  
            $this->load->model('dal/identity_db_manager');
            $objIdentity    = $this->identity_db_manager;   
            $this->load->model('dal/notes_db_manager');
            $this->load->model('dal/contact_list'); 

            $workPlaceId    = '65';                
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            
            $nodeId = trim($obj['data']['nodeId']);
            $nodeType = trim($obj['data']['nodeType']);

            $artifactId     = $nodeId;
            $artifactType   = $nodeType;
            
            //by arun
            $treeId = trim($obj['data']['treeId']);;
            $arrTag['treeId']=$treeId;
            $arrTag['artifactId']   = $artifactId;
         
            $arrTag['latestVersion']= '1';
            
            $arrTag['artifactType'] = $artifactType;
            $arrTag['workSpaceId'] = $workSpaceId;
            $arrTag['workSpaceType'] = $workSpaceType;    

            //Check latest version of tree
            $nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($artifactId);
            $currentLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($artifactId);
            $arrTag['nodeSuccessor']=$nodeSuccessor;
            $arrTag['successorLeafStatus']='';
            $arrTag['currentLeafStatus']=$currentLeafStatus['leafStatus'];
            if($nodeSuccessor!=0 && $nodeSuccessor!='')
            {
                $successorLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeSuccessor);
                $arrTag['successorLeafStatus']=$successorLeafStatus['leafStatus'];
            }
            
            $currentTreeId = $objIdentity->getTreeIdByNodeId_identity($artifactId);
            $latestTreeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($currentTreeId);
            $arrTag['latestTreeVersion']=$latestTreeVersion;
        
            
            if($arrTag['workSpaceId'] == 0)
            {       
                $arrTag['workSpaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($workPlaceId);
        
            }
            else
            {
                if($arrTag['workSpaceType'] == 1)
                {                   
                    $arrTag['workSpaceMembers'] = $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTag['workSpaceId']);
                }
                else
                {               
                    $arrTag['workSpaceMembers'] = $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrTag['workSpaceId']); 
                    //$arrTag['workSpaceId']    = $objIdentity->getWorkSpaceBySubWorkSpaceId($arrTag['workSpaceId']);   
                }
            }
        
            $arrTag['tagCategories']    = $this->tag_db_manager->getTagCategories();    
            
            $arrTag['sequenceTagId']    = 0;
                       
            $arrTag['tagOption'] = 2;
            if($this->uri->segment(8) > 0)
            {
                $arrTag['tagOption']    = $this->uri->segment(8);
            }
            $arrTag['addNewOption'] = 1;
            
            if ($this->uri->segment(9))
                $arrTag['tagId'] = $this->uri->segment(9);
                
                //by A1
                
            #************************ End Tag Changes *********************************************
            
            $arrTag['viewTags']     = $this->tag_db_manager->getTags(2, $userId, $treeId, $artifactType);
            $arrTag['actTags']  = $this->tag_db_manager->getTags(3, $userId, $treeId, $artifactType);               
            $arrTag['contactTags']= $this->tag_db_manager->getTags(5, $userId, $treeId, $artifactType);
            $arrTag['userTags'] = $this->tag_db_manager->getTags(6, $userId, $treeId, $artifactType);   
            
            $arrTag['leafClearStatus']  = $this->identity_db_manager->getLeafClearStatus($artifactId,'clear_tag');
            
            $treeType = $this->identity_db_manager->getTreeTypeByTreeId($currentTreeId);
            $arrTag['treeType'] = $treeType;
            $arrTag['currentTreeId']=$currentTreeId;
            
            if($artifactId !='')
            {
                if($artifactType==1)
                {
                    $arrTag['leafTreeId']   = $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
                }
                else
                {
                    $arrTag['leafOwnerData']    = $this->identity_db_manager->getLeafIdByNodeId($artifactId);
                    $arrTag['leafId'] = $arrTag['leafOwnerData']['id'];
                    if($treeType == 1)
                    {
                        $arrTag['leafTreeId']   = $this->document_db_manager->getLeafTreeIdByLeafId($arrTag['leafOwnerData']['id']);
                    }
                    else
                    {
                        $arrTag['leafTreeId']   = $this->document_db_manager->getLeafTreeIdByLeafId($artifactId);
                    }
                }
            }
            
            //Check leaf status start
            if($artifactType==1)
            {
                $treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
            }
            else
            {
                $treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($currentTreeId);
            }
            $contactStatus = '';
            if($treeType==5)
            {
                $Contactdetail = $this->contact_list->getlatestContactDetails($currentTreeId);
                $contactStatus = $Contactdetail['sharedStatus'];
            }
            
            if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $contactStatus!=1)     
            {
                $arrTag['spaceMoved'] = '1';
            }
            
            if($treeType==1 && $artifactType==2)
            {
                $arrTag['leafAlertNo'] = '';
                $arrTag['leafAlertMsg'] = '';
            
                $currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($artifactId);
                $arrTag['currentNodeOrder'] = $currentNodeOrder;
                $leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($currentTreeId, $currentNodeOrder);
                
                $contributors               = $this->document_db_manager->getDocsContributors($currentTreeId);
    
                $contributorsUserId         = array();  
                foreach($contributors  as $userData)
                {
                    $contributorsUserId[]   = $userData['userId'];  
                }
        
                //Get leaf reserved users
                $reservedUsers  = $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
                $arrTag['parentLeafId'] = $leafParentData['parentLeafId'];
                $resUserIds = array();
                if(count($reservedUsers)>0)
                {
                    foreach($reservedUsers  as $resUserData)
                    {
                        $resUserIds[] = $resUserData['userId']; 
                    }
                }
                
                //Check leaf new version is created or not
                if($nodeSuccessor>0)
                {
                    $arrTag['leafAlertNo'] = 2;
                    $arrTag['leafAlertMsg'] = $this->lang->line('txt_new_version_leaf_created');
                }   
                
                //Check user resevation status
                if ((!in_array($userId, $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
                {
                    $arrTag['leafAlertNo'] = 1;
                    $arrTag['leafAlertMsg'] = $this->lang->line('txt_remove_from_reserved_list');
                    $arrTag['leafDraftReserveStatus'] = 1;
                    
                }
                
                //Check leaf discard status
                if($currentLeafStatus['leafStatus']=='discarded')
                {
                    $arrTag['leafAlertNo'] = 3;
                    $arrTag['leafAlertMsg'] = $this->lang->line('txt_leaf_has_discarded');
                }   
                
                
                if($latestTreeVersion != 1)
                {
                    $arrTag['leafAlertNo'] = 6;
                    $arrTag['leafAlertMsg'] = $this->lang->line('txt_new_version_tree_created');
                }
            }
            
            echo json_encode($arrTag);
            exit;
        //exit               
    }
    //Get leaf tags details
    function get_leaf_tag_details_post()
    {
            $this->load->model('dal/time_manager');
            $this->load->model('dal/tag_db_manager');       
            $this->load->model('dal/document_db_manager');                  
            $this->load->model('dal/identity_db_manager');
            $objIdentity    = $this->identity_db_manager;   
            $this->load->model('dal/notes_db_manager');
            $this->load->model('dal/contact_list'); 

            $workPlaceId    = '65';                
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            
            $nodeId = trim($obj['data']['nodeId']);
            $nodeType = trim($obj['data']['nodeType']);

            $artifactId     = $nodeId;
            $artifactType   = $nodeType;
            $treeType = '1';
            //by arun
            $treeId = trim($obj['data']['treeId']);;
            $arrTag['treeId']=$treeId;
            $arrTag['artifactId']   = $artifactId;
         
            $arrTag['latestVersion']= '1';
            
            $arrTag['artifactType'] = $artifactType;
            $arrTag['workSpaceId'] = $workSpaceId;
            $arrTag['workSpaceType'] = $workSpaceType;    

            if($arrTag['workSpaceId'] == 0)
            {       
                $arrTag['workSpaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($workPlaceId);
        
            }
            else
            {
                if($arrTag['workSpaceType'] == 1)
                {                   
                    $arrTag['workSpaceMembers'] = $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTag['workSpaceId']);
                }
                else
                {               
                    $arrTag['workSpaceMembers'] = $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrTag['workSpaceId']); 
                    //$arrTag['workSpaceId']    = $objIdentity->getWorkSpaceBySubWorkSpaceId($arrTag['workSpaceId']);   
                }
            }
        
                
            #************************ End Tag Changes *********************************************
            
            $arrTag['viewTags']     = $this->tag_db_manager->getTags(2, $userId, $nodeId, $artifactType);
            $arrTag['actTags']  = $this->tag_db_manager->getTags(3, $userId, $nodeId, $artifactType);               
            $arrTag['contactTags']= $this->tag_db_manager->getTags(5, $userId, $nodeId, $artifactType);
            $arrTag['userTags'] = $this->tag_db_manager->getTags(6, $userId, $nodeId, $artifactType);   
            
            echo json_encode($arrTag);
            exit;
        //exit               
    }
    //Get leaf links details
    function get_leaf_link_details_post()
    {
            $this->load->model('dal/identity_db_manager');      
            $this->load->model('dal/tag_db_manager');   
            $this->load->model('dal/document_db_manager');
            $this->load->model('dal/notes_db_manager');     
            $this->load->model('dal/contact_list');
            $objIdentity            = $this->identity_db_manager;   
            
            $workPlaceId    = '65';                
            $workspaceId    = '15';
            $workspaceType  = '1';
            $userId = '1';

            $nodeOrder              = '1';
            $latestVersion          = '1';   
            $open                   = $this->uri->segment(10);  
            
            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            
            $nodeId = trim($obj['data']['nodeId']);
            $nodeType = trim($obj['data']['nodeType']);

            $artifactId     = $nodeId;
            $artifactType   = $nodeType;
            $linkType = $artifactType;
            $treeType = '1';
            //by arun
            $treeId = trim($obj['data']['treeId']);;
            $arrDetails['treeId']=$treeId;
            $arrDetails['artifactId']   = $artifactId;
         
            $arrDetails['latestVersion']= '1';
            
            $arrDetails['artifactType'] = $artifactType;
            $arrDetails['workSpaceId'] = $workSpaceId;
            $arrDetails['workSpaceType'] = $workSpaceType;    

            //link code start
            $linkSpanOrder          = $nodeOrder;                       
            $artifactLinks          = array();
            $arrDetails             = array();
            $docArtifactLinks       = array();
            $docArtifactLinks2      = array();
            $docArtifactLinks3      = array();
            $docArtifactNotLinks    = array();
            $docArtifactNotLinks2   = array();
            $disArtifactLinks       = array();
            $disArtifactLinks2      = array();
            $disArtifactLinks3      = array();
            $disArtifactNotLinks    = array();
            $disArtifactNotLinks2   = array();
            $chatArtifactLinks      = array();
            $chatArtifactLinks2     = array();
            $chatArtifactLinks3     = array();
            $chatArtifactNotLinks   = array();
            $chatArtifactNotLinks2  = array();
            $activityArtifactLinks  = array();
            $activityArtifactLinks2 = array();  
            $activityArtifactLinks3 = array();      
            $activityArtifactNotLinks   = array();
            $activityArtifactNotLinks2  = array();  
            $notesArtifactLinks     = array();
            $notesArtifactLinks2    = array();
            $notesArtifactLinks3    = array();  
            $notesArtifactNotLinks  = array();
            $notesArtifactNotLinks2 = array();
            $arrDocNotTreeIds = array();    
            $arrDisNotTreeIds = array();
            $arrChatNotTreeIds = array();
            $arrActivityNotTreeIds = array();   
            $arrNotesNotTreeIds = array();  
            $artifactNewLink        = '';   
            $dispLabel = '';
            $mainTreeId =$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId); 

            $docTrees   = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 1, $linkType);
            
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $docCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 1, $linkType,$lastLogin);

            $arrDocTreeIds = array();   
            if(count($docTrees) > 0)
            {
                $i = 1; 
                foreach($docTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrDocTreeIds[] = $data['treeId']; 
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Document');
                    }                   
                    $docArtifactLinks[] = html_entity_decode(strip_tags($treeName));   
            
                    $docArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                   
            }
            if(count($docCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($docCurrentTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrDocTreeIds[] = $data['treeId']; 
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Document');
                    }                   
                    $docArtifactLinks3[] = html_entity_decode(strip_tags($treeName));
                    
                    $i++;
                }                   
            }
    
            $arrDocTreeIds[sizeof($arrDocTreeIds)] =0;
            $docNotLinkedTrees  = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(1, $workspaceId, $workspaceType, $arrDocTreeIds,$mainTreeId);   
            if(count($docNotLinkedTrees) > 0)
            {
                $i = 1;     
                $show = 0;      
                foreach($docNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree
    
                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']); 
                        
                        if ((in_array($userId,$sharedMembers)))
                        {
                            $arrDocNotTreeIds[] = $data['treeId'];              
                            $docArtifactNotLinks[] = html_entity_decode(strip_tags($data['name']));   

                            $docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
                            $docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
                        }
                    }
                    else
                    {
                        $arrDocNotTreeIds[] = $data['treeId'];              
                        $docArtifactNotLinks[] = html_entity_decode(strip_tags($data['name']));   

                        $docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
                        $docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
                    }
                    $i++;
                }   
                asort ($docArtifactNotLinks2);      
            }  

            //Discuss tree link start
            $disTrees   = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 2, $linkType);
            
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $disCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 2, $linkType,$lastLogin);
            
            $arrDisTreeIds = array();
            if(count($disTrees) > 0)
            {
                $i = 1; 
                foreach($disTrees as $data)
                {   
                    $treeName = $data['name'];  
                    $arrDisTreeIds[] = $data['treeId'];
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Discussion');
                    }                                                   
                    $disArtifactLinks[] = html_entity_decode(strip_tags($treeName));    

                    $disArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                   
            }
            
            if(count($disCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($disCurrentTrees as $data)
                {   
                    $treeName = $data['name'];  
                    $arrDisTreeIds[] = $data['treeId'];
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Discussion');
                    }                                                   
                    $disArtifactLinks3[] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                   
            }

            $arrDisTreeIds[sizeof($arrDisTreeIds)] =0;
            $disArtifactNewLink         = '<a href="'.base_url().'new_discussion/start_Discussion/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                     
            $disNotLinkedTrees  = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(2, $workspaceId, $workspaceType, $arrDisTreeIds,$mainTreeId);   
            if(count($disNotLinkedTrees) > 0)
            {
                $i = 1; 
                foreach($disNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree

                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
                        if ((in_array($_SESSION['userId'],$sharedMembers)))
                        {
                            $treeName = $data['name'];
                            $arrDisNotTreeIds[] = $data['treeId'];      
                            if(trim($data['name']) == '')
                            {
                                $treeName = $this->lang->line('txt_Discussion');    
                            }           
                            $disArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));   

                            $disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                        }
                    }
                    else
                    {
                        $treeName = $data['name'];
                        $arrDisNotTreeIds[] = $data['treeId'];      
                        if(trim($data['name']) == '')
                        {
                            $treeName = $this->lang->line('txt_Discussion');    
                        }           
                        $disArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));   

                        $disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    }

                    $i++;
                }
                asort ($disArtifactNotLinks2);                      
            }       

            $chatTrees  = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 3, $linkType);
            
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $chatCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 3, $linkType,$lastLogin);
            
            $arrChatTreeIds = array();
            if(count($chatTrees) > 0)
            {
                $i = 1; 
                foreach($chatTrees as $data)
                {
                    $treeName = $data['name'];  
                    $arrChatTreeIds[] = $data['treeId'];    
                    if(trim($data['name']) == '')
                    {
                        $treeName = $this->lang->line('txt_Chat');  
                    }                                   
                    $chatArtifactLinks[] = html_entity_decode(strip_tags($treeName));    

                    $chatArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    
                    $i++;
                }                       
            }
            
            if(count($chatCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($chatCurrentTrees as $data)
                {
                    $treeName = $data['name'];  
                    $arrChatTreeIds[] = $data['treeId'];    
                    if(trim($data['name']) == '')
                    {
                        $treeName = $this->lang->line('txt_Chat');  
                    }                                   
                    $chatArtifactLinks3[] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                       
            }

            $arrChatTreeIds[sizeof($arrChatTreeIds)] =0;
            $chatArtifactNewLink    = '<a href="'.base_url().'new_chat/start_Chat/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                     
            $chatNotLinkedTrees     = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(3, $workspaceId, $workspaceType, $arrChatTreeIds,$mainTreeId);  
            if(count($chatNotLinkedTrees) > 0)
            {
                $i = 1; 
                foreach($chatNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree
                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
                        if ((in_array($_SESSION['userId'],$sharedMembers)))
                        {
                            $treeName = $data['name'];  
                            $arrChatNotTreeIds[] = $data['treeId'];     
                            if(trim($data['name']) == '')
                            {
                                $treeName = $this->lang->line('txt_Chat');  
                            }           
                            $chatArtifactNotLinks[] = html_entity_decode(strip_tags($treeName)); 
                            $chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                        }
                    }
                    else
                    {
                        $treeName = $data['name'];  
                        $arrChatNotTreeIds[] = $data['treeId'];     
                        if(trim($data['name']) == '')
                        {
                            $treeName = $this->lang->line('txt_Chat');  
                        }           
                        $chatArtifactNotLinks[] = html_entity_decode(strip_tags($treeName)); 
                        $chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    }
                    $i++;
                }
                asort ($chatArtifactNotLinks2);                         
            }       
            //Discuss tree link end 

            //Task tree link start
            $activityTrees  = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 4, $linkType);
            
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $activityCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 4, $linkType,$lastLogin);
            
            $arrActivityTreeIds = array();      
            if(count($activityTrees) > 0)
            {
                $i = 1; 
                foreach($activityTrees as $data)
                {
                    $treeName = $data['name'];  
                    $arrActivityTreeIds[] = $data['treeId'];        
                    if(trim($data['name']) == '')
                    {
                        $treeName = $this->lang->line('txt_Activity');  
                    }                                                           
                    $activityArtifactLinks[] = html_entity_decode(strip_tags($treeName));   
                    $activityArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                       
            }
            if(count($activityCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($activityCurrentTrees as $data)
                {
                    $treeName = $data['name'];  
                    $arrActivityTreeIds[] = $data['treeId'];        
                    if(trim($data['name']) == '')
                    {
                        $treeName = $this->lang->line('txt_Activity');  
                    }                                                           
                    $activityArtifactLinks3[] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                       
            }

            $arrActivityTreeIds[sizeof($arrActivityTreeIds)] = 0;
            $activityArtifactNewLink    = '<a href="'.base_url().'new_task/start_Task/'.$nodeId.'/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                     
            $activityNotLinkedTrees     = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(4, $workspaceId, $workspaceType, $arrActivityTreeIds,$mainTreeId);  
            if(count($activityNotLinkedTrees) > 0)
            {
                $i = 1; 
                foreach($activityNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree

                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
                            if ((in_array($_SESSION['userId'],$sharedMembers)))
                            {
                                $treeName = $data['name'];  
                                $arrActivityNotTreeIds[] = $data['treeId']; 
                                if(trim($data['name']) == '')
                                {
                                    $treeName = $this->lang->line('txt_Activity');  
                                }           
                                $activityArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));  

                                $activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                            }
                    }
                    else
                    {
                        $treeName = $data['name'];  
                        $arrActivityNotTreeIds[] = $data['treeId']; 
                        if(trim($data['name']) == '')
                        {
                            $treeName = $this->lang->line('txt_Activity');  
                        }           
                        $activityArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));  

                        $activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    }

                    $i++;
                }
                asort ($activityArtifactNotLinks2);                         
            }
            //Task tree link end

            //Notes tree link start
            $arrNotesTreeIds = array();         
            $notesTrees     = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 6, $linkType);
            
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $notesCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 6, $linkType,$lastLogin);
            
            if(count($notesTrees) > 0)
            {
                $i = 1; 
                foreach($notesTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrNotesTreeIds[] = $data['treeId'];   
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Notes');
                    }                                           
                    $notesArtifactLinks[] = html_entity_decode(strip_tags($treeName));     

                    $notesArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }   
                                    
            }
            
            if(count($notesCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($notesCurrentTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrNotesTreeIds[] = $data['treeId'];   
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Notes');
                    }                                           
                    $notesArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
                    $i++;
                }                       
            }
            

            $arrNotesTreeIds[sizeof($arrNotesTreeIds)] =0;
            $notesArtifactNewLink   = '<a href="'.base_url().'notes/New_Notes/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                       
            $notesNotLinkedTrees    = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(6, $workspaceId, $workspaceType, $arrNotesTreeIds,$mainTreeId); 
            if(count($notesNotLinkedTrees) > 0)
            {
                $i = 1; 
                foreach($notesNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree
                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
                            if ((in_array($_SESSION['userId'],$sharedMembers)))
                            {
                                $treeName = $data['name'];  
                                $arrNotesNotTreeIds[] = $data['treeId'];
                                if(trim($data['name']) == '')
                                {
                                    $treeName = $this->lang->line('txt_Notes'); 
                                }           
                                $notesArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));     

                                $notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                            }
                    }
                    else
                    {
                        $treeName = $data['name'];  
                        $arrNotesNotTreeIds[] = $data['treeId'];
                        if(trim($data['name']) == '')
                        {
                            $treeName = $this->lang->line('txt_Notes'); 
                        }           
                        $notesArtifactNotLinks[] = html_entity_decode(strip_tags($treeName));     

                        $notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    }
                    
                    $i++;
                }
                asort ($notesArtifactNotLinks2);                            
            }   
            //Notes tree link end

            //Contact tree link start
            $arrContactTreeIds = array();          
            $contactTrees   = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 5, $linkType);

            $lastLogin = $this->identity_db_manager->getLastLogin();
            $contactCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 5, $linkType,$lastLogin);
            
            if(count($contactTrees) > 0)
            {
                $i = 1; 
                foreach($contactTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrContactTreeIds[] = $data['treeId']; 
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Contacts');
                    }                                           
                    $contactArtifactLinks[] = html_entity_decode(strip_tags($treeName));  

                    $contactArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    $i++;
                }                       
            }
            
            if(count($contactCurrentTrees) > 0)
            {
                $i = 1; 
                foreach($contactCurrentTrees as $data)
                {   
                    $treeName = $data['name'];
                    $arrContactTreeIds[] = $data['treeId']; 
                    if(trim($treeName) == '')
                    {
                        $treeName = $this->lang->line('txt_Contacts');
                    }                                           
                    $contactArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
                    $i++;
                }                       
            }
            

            $arrContactTreeIds[sizeof($arrContactTreeIds)] =0;
            $contactArtifactNewLink = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                       
            //$contactNotLinkedTrees  = $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(5, $workspaceId, $workspaceType, $arrContactTreeIds,$mainTreeId);   

            if(count($contactNotLinkedTrees) > 0)
            {
                $i = 1; 
                foreach($contactNotLinkedTrees as $data)
                {       
                    // Parv - Allowing linking to current tree

                    if ($data['isShared']==1)
                    {
                        $sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
                            if ((in_array($_SESSION['userId'],$sharedMembers)))
                            {
                                $treeName = $data['name'];  
                                $arrContactNotTreeIds[] = $data['treeId'];
                                if(trim($data['name']) == '')
                                {
                                    $treeName = $this->lang->line('txt_Contacts');  
                                }           
                                $contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>';   
                                $contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                            }
                    }
                    else
                    {
                        $treeName = $data['name'];  
                        $arrContactNotTreeIds[] = $data['treeId'];
                        if(trim($data['name']) == '')
                        {
                            $treeName = $this->lang->line('txt_Contacts');  
                        }           
                        $contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>';   

                        $contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
                    }
                    
                    $i++;
                }
                asort ($contactArtifactNotLinks2);                      
            }    
            //Contact tree link end

            //Import files and url start
            $arrImportFileIds = array();            
            $importFile     = $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($nodeId,$linkType);
            $lastLogin = $this->identity_db_manager->getLastLogin();
            $importCurrentFile = $this->identity_db_manager->getCurrentLinkedExternalDocsByArtifactNodeId($nodeId,$linkType,$lastLogin);
            
            if(count($importFile) > 0)
            {
                $i = 1; 
                foreach($importFile as $data)
                {   
                    $docName = $data['docName'];
                    $arrImportFileIds[] = $data['docId'];   
                    if(trim($docName) == '')
                    {
                        $docName = $this->lang->line('txt_Imported_Files');
                    }                                           
                    
                    $importArtifactLinks[] = $docName.'_v'.$data['version'];
                    $importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];
                    $i++;
                }                       
            }
            
            if(count($importCurrentFile) > 0)
            {
                $i = 1; 
                foreach($importCurrentFile as $data)
                {   
                    $docName = $data['docName'];
                    $arrImportFileIds[] = $data['docId'];   
                    if(trim($docName) == '')
                    {
                        $docName = $this->lang->line('txt_Imported_Files');
                    }                                           
                    $importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName)).'_v'.$data['version']."</option>";
                    $i++;
                }                       
            }
            
            $arrImportFileIds[sizeof($arrImportFileIds)] =0;
            $importArtifactNewLink  = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';                       
            $importNotLinkedFile    = $this->identity_db_manager->getNotLinkedExternalDocsByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFileIds); 
            

            if(count($importNotLinkedFile) > 0)
            {
                $i = 1; 
                foreach($importNotLinkedFile as $data)
                {       
                    // Parv - Allowing linking to current tree
                    $docName = $data['docName'];    
                    $arrImportNotFileIds[] = $data['docId'];
                    if(trim($data['docName']) == '')
                    {
                        $fileName = $this->lang->line('txt_Imported_Files');    
                    }           
                    $importArtifactNotLinks[] = $docName.'_v'.$data['version'];     
                    $importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];
                    $i++;
                }
                asort ($importArtifactNotLinks2);       
            }               

            $arrImportedUrls    = $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($nodeId,$artifactType);
            
            $indivisualUrl = array();
            if(count($arrImportedUrls) > 0)
            {
                foreach($arrImportedUrls as $key=>$value)
                {
                    $indivisualUrl[]= $value['title'];
                    $importedUrlsIds[] = $key;
                }
            }
            //Import files and url end

            $arrDetails['docArtifactLinks']         = $docArtifactLinks;
            $arrDetails['docArtifactLinks2']        = $docArtifactLinks2;
            $arrDetails['docArtifactLinks3']        = $docArtifactLinks3;
            $arrDetails['docArtifactNotLinks']      = $docArtifactNotLinks;     
            $arrDetails['docArtifactNotLinks2']     = $docArtifactNotLinks2;    
            
            $arrDetails['disArtifactLinks']         = $disArtifactLinks;
            $arrDetails['disArtifactLinks2']        = $disArtifactLinks2;
            $arrDetails['disArtifactLinks3']        = $disArtifactLinks3;
            $arrDetails['disArtifactNotLinks']      = $disArtifactNotLinks;
            $arrDetails['disArtifactNotLinks2']     = $disArtifactNotLinks2;    
            $arrDetails['chatArtifactLinks']        = $chatArtifactLinks;
            $arrDetails['chatArtifactLinks2']       = $chatArtifactLinks2;
            $arrDetails['chatArtifactLinks3']       = $chatArtifactLinks3;
            $arrDetails['chatArtifactNotLinks']     = $chatArtifactNotLinks;
            $arrDetails['chatArtifactNotLinks2']    = $chatArtifactNotLinks2;

            $arrDetails['activityArtifactLinks']    = $activityArtifactLinks;
            $arrDetails['activityArtifactLinks2']   = $activityArtifactLinks2;
            $arrDetails['activityArtifactLinks3']   = $activityArtifactLinks3;
            $arrDetails['activityArtifactNotLinks'] = $activityArtifactNotLinks;
            $arrDetails['activityArtifactNotLinks2'] = $activityArtifactNotLinks2;

            $arrDetails['notesArtifactLinks']       = $notesArtifactLinks;
            $arrDetails['notesArtifactLinks2']      = $notesArtifactLinks2;
            $arrDetails['notesArtifactLinks3']      = $notesArtifactLinks3;
            $arrDetails['notesArtifactNotLinks']    = $notesArtifactNotLinks;
            $arrDetails['notesArtifactNotLinks2']   = $notesArtifactNotLinks2;

            $arrDetails['contactArtifactLinks']         = $contactArtifactLinks;
            $arrDetails['contactArtifactLinks2']        = $contactArtifactLinks2;
            $arrDetails['contactArtifactLinks3']        = $contactArtifactLinks3;
            $arrDetails['contactArtifactNotLinks']  = $contactArtifactNotLinks;
            $arrDetails['contactArtifactNotLinks2']     = $contactArtifactNotLinks2;

            $arrDetails['importArtifactLinks']      = $importArtifactLinks;
            $arrDetails['importArtifactLinks2']         = $importArtifactLinks2;
            $arrDetails['importArtifactLinks3']         = $importArtifactLinks3;
            $arrDetails['importArtifactNotLinks']   = $importArtifactNotLinks;
            $arrDetails['importArtifactNotLinks2']  = $importArtifactNotLinks2;

            $arrDetails['importedUrls']             = $indivisualUrl;   
                                                                
            $arrDetails['docArtifactNewLink']       = $docArtifactNewLink;    
            $arrDetails['disArtifactNewLink']       = $disArtifactNewLink;
            $arrDetails['chatArtifactNewLink']      = $chatArtifactNewLink;
            $arrDetails['activityArtifactNewLink']  = $activityArtifactNewLink;
            $arrDetails['notesArtifactNewLink']     = $notesArtifactNewLink;
            $arrDetails['contactArtifactNewLink']       = $contactArtifactNewLink;
                                    
            $arrDetails['workspaceId'] = $workspaceId;
            $arrDetails['workspaceType'] = $workspaceType;
            $arrDetails['nodeId'] = $nodeId;
            $arrDetails['linkType'] = $linkType;
            $arrDetails['nodeOrder'] = $nodeOrder;  
            $arrDetails['linkSpanOrder'] = $linkSpanOrder;

            $arrDetails['arrDocTreeIds'] = $arrDocNotTreeIds;  
            $arrDetails['arrDisTreeIds'] = $arrDisNotTreeIds;       
            $arrDetails['arrChatTreeIds'] = $arrChatNotTreeIds; 
            $arrDetails['arrActivityTreeIds'] = $arrActivityNotTreeIds; 
            $arrDetails['arrNotesTreeIds'] = $arrNotesNotTreeIds;
            $arrDetails['arrContactTreeIds'] = $arrContactNotTreeIds;
            $arrDetails['arrImportFileIds'] = $arrImportNotFileIds;
                                   
            $arrDetails['latestVersion']=$latestVersion; 
            $arrDetails['mainTreeId'] = $mainTreeId;
            $arrDetails['open'] = $open;
            $arrDetails['treeId']=$treeId;
            $arrDetails['artifactType']=$artifactType; 
            
            //link code end
            
            echo json_encode($arrDetails);
            exit;
        //exit               
    }
    //Get leaf talk details
    function get_leaf_talk_details_post()
    {
            $this->load->model('dal/time_manager');     
            $this->load->model('dal/identity_db_manager');
            $this->load->model('dal/tag_db_manager');                       
            $objIdentity    = $this->identity_db_manager;   
            $objIdentity->updateLogin();                
            $this->load->model('container/discussion_container');
            $this->load->model('dal/document_db_manager');
            $this->load->model('dal/discussion_db_manager');

            $workPlaceId    = '65';                
            $workSpaceId    = '15';
            $workSpaceType  = '1';
            $userId = '1';

            $config['hostname'] = base64_decode($this->config->item('hostname'));
            $config['username'] = base64_decode($this->config->item('username'));
            $config['password'] = base64_decode($this->config->item('password'));
            $config['database'] = $this->config->item('instanceDb').'_test';
            $config['dbdriver'] = $this->db->dbdriver;
            $config['dbprefix'] = $this->db->dbprefix;
            $config['pconnect'] = FALSE;
            $config['db_debug'] = $this->db->db_debug;
            $config['cache_on'] = $this->db->cache_on;
            $config['cachedir'] = $this->db->cachedir;
            $config['char_set'] = $this->db->char_set;
            $config['dbcollat'] = $this->db->dbcollat;    
            $this->db = $this->load->database($config, TRUE);   

            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            
            $nodeId = trim($obj['data']['nodeId']);
            $talknodeId = $nodeId;
            $leafId = trim($obj['data']['leafId']);
            $nodeType = trim($obj['data']['nodeType']);

            $artifactId     = $nodeId;
            $artifactType   = $nodeType;
            $treeType = '1';
            //by arun
            $doctreeId = trim($obj['data']['treeId']);;
            $arrTag['treeId']=$treeId;
            $arrTag['artifactId']   = $artifactId;
         
            $arrTag['latestVersion']= '1';
            
            $arrTag['artifactType'] = $artifactType;
            $arrTag['workSpaceId'] = $workSpaceId;
            $arrTag['workSpaceType'] = $workSpaceType;    

            $talkData = array();  
            //Get talk details start
            $treeId  = $this->document_db_manager->getLeafTreeIdByLeafId($leafId);
            
            if($treeId)
            {        
                $arrDiscussions1=$this->discussion_db_manager->getTalkNodesByTreeRealTalk($treeId,'');
               
                $talkTimeStamp = $this->time_manager->getGMTTime();
                $arrDiscussionDetails   = $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
    
                $arrDocumentDetails = $this->document_db_manager->getDocumentDetailsByTreeId($arrDiscussionDetails['parentTreeId']);
    
                // Update talk tree name by it's attached leaf or seed id
                $isSeedTalk = '';
                
                $treeType = $this->identity_db_manager->getTreeTypeByTreeId($arrDiscussionDetails['parentTreeId']); 
    
                $leafId = $this->discussion_db_manager->getLeafIdByLeafTreeId ($treeId);
                
                //echo "isseedtalk= " .$isSeedTalk; exit;
                
                if ($isSeedTalk==1)
                {
                    //echo "here bhenchod= " .$leafId; exit;
                    $this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,1);
                }
                else if ($isSeedTalk=='')
                {
/*                      echo "<li>leafid= " .$leafId; 
                        echo "<li>treeId= " .$treeId; 
                        echo "<li>treeType= " .$treeType; 
                        exit;*/
                    $this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,0,$treeType);
                }
                // Update talk tree name by it's attached leaf or seed id

            
                $pId=$arrDiscussionDetails['nodes'];
                if($pId) {
                    $DiscussionPerent1=$this->discussion_db_manager->getDiscussionPerent($pId);
                    $arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
                }
                
                $arrDiscussionViewPage['pnodeId']=$pId;
                $arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
                $arrDiscussionViewPage['arrDocumentDetails']=$arrDocumentDetails;
                $arrDiscussionViewPage['treeId']=$treeId;
                $arrDiscussionViewPage['isSeedTalk']=$isSeedTalk;
                $arrDiscussionViewPage['position']=0;
                $arrDiscussionViewPage['workSpaceId'] = $workSpaceId; 
                $arrDiscussionViewPage['workSpaceType'] = $workSpaceType;   
                if($arrDiscussionViewPage['workSpaceType'] == 1)
                {   
                    $arrDiscussionViewPage['workSpaceMembers']  = $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);                        
                }
                else
                {   
                    $arrDiscussionViewPage['workSpaceMembers']  = $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);              
                }
                $arrDiscussionViewPage['tagCategories'] = $this->tag_db_manager->getTagCategories();
                
                        
                // Parv - Set Tree Update Count from database
                $this->identity_db_manager->setTreeUpdateCount($treeId);    
                    
                $showOption = 1;
                if($showOption == 1)
                {
                    $realTimeTalkDivIds = array();
                    $count = 0;
                    $talkData = array();
                    if(count($arrDiscussions1) > 0)
                    {   
                        $i = 0;
                        foreach($arrDiscussions1 as $keyVal=>$arrVal)
                        {
                            $totalTalkNodes[] = $arrVal['nodeId'];
                                    $userDetails            = $this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);              
                                    $checksucc              = $this->discussion_db_manager->checkSuccessors($arrVal['nodeId']);
                                    $this->discussion_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$userId);          
                                    $viewCheck=$this->discussion_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$userId);        
                                    

                            $realTimeTalkCommentDivIds=explode(",",$realTimeTalkDivIds);
                            //print_r($realtimeChatDivIds);
                            if(!in_array($arrVal['nodeId'],$realTimeTalkCommentDivIds)) 
                            {
                                    $talkData[$i]['contents'] = stripslashes($arrVal['contents']);
                                    $talkData[$i]['tagname']  = $userDetails['userTagName'];
                                    $talkData[$i]['talktime'] = $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'],$this->config->item('date_format'));
                                    $focusId = $focusId+2;
                                    $count++;
                                    $i++;
                            }
                        }
                    }    
                }
                
            }    
            //Get talk details end  
            $talkData['talkData']= $talkData;
            echo json_encode($talkData);
            exit;
        //exit               
    }
}