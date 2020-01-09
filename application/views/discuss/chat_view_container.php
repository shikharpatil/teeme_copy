<?php
	$arrDiscussions1		= $this->chat_db_manager->getNodesByTree($treeId);

	$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
	$gettimmerval = $arrDiscussionDetails['status'];
	
	$pId=$arrDiscussionDetails['nodes'];
	if($pId) {
		$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
		$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
	}
	
	$arrDiscussionViewPage['pnodeId']=$pId;
	$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
	$arrDiscussionViewPage['treeId']=$treeId;
	
	$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
	$arrDiscussionViewPage['position']=0;
	$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
	$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
	$arrDiscussionViewPage['arrparent']=array();
	$arrDiscussionViewPage['userDetails1']=array();
	$arrDiscussionViewPage['counter']=0;
	if($gettimmerval){
		$arrDiscussionViewPage['timmer']=1;
	}else{
		$arrDiscussionViewPage['timmer']=0;
	}
	
	$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
	
	/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{
			$this->load->view('discuss/view_chat_tree_for_mobile', $arrDiscussionViewPage);	
		}
		else
		{				
			$this->load->view('discuss/view_chat_tree', $arrDiscussionViewPage); 
		}
	/*Manoj : code end*/
?>
