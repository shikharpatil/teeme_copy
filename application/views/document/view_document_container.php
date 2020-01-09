<!------------ Main Body of the document ------------------------->

<div id="mainContentProof">
  <?php
	$arrDetails['viewOption'] = 'htmlView';
	$arrDetails['doc'] = $this->input->get('doc');	
		


	/*$memc = new Memcached;
	$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
	//Manoj: get memcache object	
	$memc=$this->identity_db_manager->createMemcacheObject();
	$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;	

	$memc->delete($memCacheId); 
	$value = $memc->get( $memCacheId );
	

	if(!$value)
	{	
		$tree = $this->document_db_manager->getDocumentFromDB($treeId);
		

		$memc->set($memCacheId, $tree, MEMCACHE_COMPRESSED);	
		$value = $memc->get($memCacheId);

			if ($value == '')
			{
				$value = $tree;
			}
	}					
	if ($value)
	{	 
		$arrDetails['value'] = 	$value;
		/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{
			$this->load->view('document/document_body_for_mobile', $arrDetails);	
		}
		else
		{
			$this->load->view('document/document_body', $arrDetails);			
		}
		/*Manoj : code end*/
	}
	else
	{
	?>
  <input type="hidden" id="allLeafs" value="">
  <?php
					}				
				?>
  <input type="hidden" name="curFocus" value="0" id="curFocus">
  <input type="hidden" name="curLeaf" value="0" id="curLeaf">
  <input type="hidden" name="editStatus" value="0" id="editStatus">
  <input type="hidden" name="curContent" value="0" id="curContent">
  <input type="hidden" name="curNodeId" value="0" id="curNodeId">
  <input type="hidden" name="treeId" value="<?php echo $this->input->get('treeId');?>" id="treeId">
  <input type="hidden" name="curLeafOrder" value="0" id="curLeafOrder">
  <input type="hidden" name="curOption" value="edit" id="curOption">
  <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
  <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

  	<!--Added by dashrath- used this data for content auto save feature-->
	<input type="hidden" name="draftCurLeafId" value="0" id="draftCurLeafId">
	<input type="hidden" name="draftCurLeafOrder" value="0" id="draftCurLeafOrder">
	<input type="hidden" name="draftCurNodeId" value="0" id="draftCurNodeId">
	<input type="hidden" name="draftCurrentLeafMode" value="0" id="draftCurrentLeafMode">
	<!--Added by dashrath- code end-->

 	<!--Added by dashrath- used this data for content auto save feature-->
    <input type="hidden" name="openEditorId" value="" id="openEditorId">
    <input type="hidden" name="addDraftLeafNodeId" value="0" id="addDraftLeafNodeId">
    <input type="hidden" name="addDraftLeafOldContent" value="" id="addDraftLeafOldContent">
    <input type="hidden" name="addDraftLeafId" value="0" id="addDraftLeafId">
    <input type="hidden" name="addDraftNodeOrder" value="0" id="addDraftNodeOrder">
    <input type="hidden" name="addDraftLeafSaveType" value="" id="addDraftLeafSaveType">
    <input type="hidden" name="editorActionWithoutAutoSave" value="0" id="editorActionWithoutAutoSave">
    <input type="hidden" name="editLeafOldContent" value="" id="editLeafOldContent">
    <input type="hidden" name="autoSaveMethodCalling" value="0" id="autoSaveMethodCalling">

    <!--Used in edit auto save when call edit auto save method-->
    <input type="hidden" name="editAutoSaveMethodCalling" value="0" id="editAutoSaveMethodCalling">
    <!--Used for new leaf created in draft mode when call edit auto save method-->
    <input type="hidden" name="newDraftLeafNodeId" value="0" id="newDraftLeafNodeId">
    <!--Used for check if action is running by editor for edit auto save-->
    <input type="hidden" name="editEditorActionWithoutAutoSave" value="0" id="editEditorActionWithoutAutoSave">
    <!--Added by dashrath- code end-->

</div>
<div id="editLeaf"></div>
<div id="contentSearchDiv" handlefor="contentSearchDiv" style="display:none; border:1px solid BLACK; position:absolute; width:350px; height:100px; z-index:2; left: 300px; top: 110px;"> Please enter the text to search:
  <input type="text" name="leafSearch" id="leafSearch">
  <input type="button" name="search" value="<?php echo $this->lang->line('txt_Done');?>" onClick="searchText(<?php echo $treeId;?>)">
  &nbsp;&nbsp;
  <input type="button" value="<?php echo $this->lang->line('txt_Close');?>" onClick="hideSearch('contentSearchDiv')">
</div>
