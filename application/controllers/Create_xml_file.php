<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_xml_file.php
	* Description 		  	: A class file used to create the xml file for document.
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 18-02-2009				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to create the new version of tree
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Create_xml_file extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{		
		ob_start();	
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
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/notes_db_manager');	
			
			$objDBDocument 	= $this->document_db_manager;			
			$objTime		= $this->time_manager;
			
			$parentTreeId 		= $this->uri->segment(3);
			
			$treeType = $this->identity_db_manager->getTreeTypeByTreeId($parentTreeId);
			
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($parentTreeId);
			//$nodeDetails		= $this->document_db_manager->getTopNodesByTreeId($parentTreeId, $arrDocumentDetails['treeVersion']);
			if($treeType=='1')
			{
				$treeData = $this->document_db_manager->getDocumentFromDB($parentTreeId);	
			}
			$documentName = $arrDocumentDetails['name'];
			$version = $arrDocumentDetails['version'];
			$treeName = $this->lang->line('txt_Document_Tree');
			$treeVersiontxt = $this->lang->line('txt_Version').':';
			
			if($treeType=='6')
			{
				$nodeDetails  = $this->notes_db_manager->getTopNodesByTreeId($parentTreeId, $arrDocumentDetails['treeVersion']);
				$version = '';
				$treeName = $this->lang->line('txt_Notes_Tree');
				$treeVersiontxt = '';
			}
			
			
			$html = "
			<html>
			<head>
    		<title>".strip_tags($documentName)."</title>
			</head>
			<body>";
			$html .= "<h3>".strip_tags($documentName) ."</h3>";
				$i = 1;
				//foreach($nodeDetails as $keyVal=>$leafVal)
				if($treeType=='1')
				{
					foreach ($treeData as $leafData)
					{	
						//Added by Dashrath : code start
						//check leaf content blank condition for deleted leaf feature
						if($leafData->leafStatus != 'deleted'){	
						// Dashrath : code end
						$docLeafStatus = '';
						if($treeType=='1')
						{
							//Add draft reserved users condition
								/*$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafVal['leafId']);
								$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafVal['treeIds'], $leafVal['nodeOrder']);
								$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafVal['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);	
							
								//Get reserved users
								$reservedUsers = '';
								$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
								$resUserIds = array();			
								foreach($reservedUsers  as $resUserData)
								{
									$resUserIds[] = $resUserData['userId']; 
								}*/
								
								$nextLeafStatus = $this->document_db_manager->getNextLeafPublishStatus($leafData->treeIds, $leafData->nodeOrder, $leafData->leafId1);
								
						//Code end
						}		
						//if(((in_array($_SESSION['userId'], $resUserIds) || $emptyReservedList==1) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $treeType=='6')
						//if($docLeafStatus == 'publish' || $treeType=='6')
						if(($leafData->successors == '0' && $leafData->leafStatus == 'publish') || ($leafData->successors > '0' && $leafData->leafStatus == 'publish' && $nextLeafStatus=='draft'))
						{	
						
						//$treeContent=strip_tags($leafVal['contents']);
						$treeContent=strip_tags($leafData->contents, '<img>');
						$treeAllContent = strip_tags($leafData->contents, '<img><br><p>');
						
					
						if($treeContent=='')
						{
							//$treeLeafData = $this->lang->line('content_contains_only_image');
							//$contents = stripslashes($treeLeafData);
							
							preg_match_all('/<img (.+)>/', $leafData->contents, $image_matches, PREG_SET_ORDER);
							if(!empty($image_matches))
							{
								$contents = stripslashes($leafData->contents);
							}
							else
							{
								$treeLeafData = $this->lang->line('content_contains_only_audio_video');
								$contents = stripslashes($treeLeafData);
							}
						}	
						else
						{
							$contents = stripslashes($treeAllContent);
						}						 
						
						$html .= '<div style="padding:8px 0px;">'.$contents.'</div>';
						
						//$html .= '<div style="border-top:0.5px solid gray;"></div>';
						//$html .= "<hr>";
						}

						//Added by Dashrath : code start
						}
						// Dashrath : code end
						
						$i++;						
					}	
				}
				if($treeType=='6')
				{
					foreach($nodeDetails as $keyVal=>$leafVal)
					{
						//Added by Dashrath : code start
						//check leaf content blank condition for deleted leaf feature
						if($leafVal['leafStatus'] != 'deleted'){	
						// Dashrath : code end
						$docLeafStatus = '';
						if($treeType=='1')
						{
							//Add draft reserved users condition
								$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafVal['leafId']);
								$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafVal['treeIds'], $leafVal['nodeOrder']);
								$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafVal['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);	
							
								//Get reserved users
								$reservedUsers = '';
								$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
								$resUserIds = array();			
								foreach($reservedUsers  as $resUserData)
								{
									$resUserIds[] = $resUserData['userId']; 
								}
						//Code end
						}		
						//if(((in_array($_SESSION['userId'], $resUserIds) || $emptyReservedList==1) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $treeType=='6')
						if($docLeafStatus == 'publish' || $treeType=='6')
						{	
						
						//$treeContent=strip_tags($leafVal['contents']);
						$treeContent=strip_tags($leafVal['contents'], '<img>');
						$treeAllContent = strip_tags($leafVal['contents'], '<img><br><p>');
						
					
						if($treeContent=='')
						{
							//$treeLeafData = $this->lang->line('content_contains_only_image');
							//$contents = stripslashes($treeLeafData);
							
							preg_match_all('/<img (.+)>/', $leafVal['contents'], $image_matches, PREG_SET_ORDER);
							if(!empty($image_matches))
							{
								$contents = stripslashes($leafVal['contents']);
							}
							else
							{
								$treeLeafData = $this->lang->line('content_contains_only_audio_video');
								$contents = stripslashes($treeLeafData);
							}
						}	
						else
						{
							$contents = stripslashes($treeAllContent);
						}						 
						
						$html .= '<div style="padding:8px 0px;">'.$contents.'</div>';
						
						//$html .= '<div style="border-top:0.5px solid gray;"></div>';
						//$html .= "<hr>";
						}

						//Added by Dashrath : code start
						}
						// Dashrath : code end
						
						$i++;						
					}
				}
			$html .= "
			</body>
			</html>
			";
			
			//Create image full path 
			$doc = new DOMDocument();
			$baseUrl=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
			$doc->loadHTML($html);
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
			$html = $doc->saveHTML();
			
			//Code end
			
			$fileName = strip_tags($arrDocumentDetails['name']);
			
			if (strlen($fileName) > 25) 
			{
				$fileName = substr($fileName, 0, 25); 
			}
				
			$fileName = str_replace(' ', '_', $fileName);
			
			$fileName = $fileName.'_'.$arrDocumentDetails['version'].'.html';

			/* Disabled by Parv $xml_string = $doc->saveXML();	*/

			header("Content-type: text/html");
			header("Content-Disposition: attachment; filename=\"".$fileName."\"");

			echo $html;

		}	
	}
	
}
?>