<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<script>
	var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
	var workSpace_name='<?php echo $workSpaceId;?>';
	var workSpace_user='<?php echo $_SESSION['userId'];?>';
	</script>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';		
	</script>
	<?php $this->load->view('common/view_head');?>
	<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->
	</head>
	<body onUnload="return bodyUnload()">
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile">
      <div id="content"> 
    
    <!-- Main menu -->
    <?php
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
			?>
    <!-- Main menu -->
    <?php
			$treeMainVersion 	= $arrDocumentDetails['version'];			
			 
			$leftLink			= '';
			$rightLink			= '';
			$leftVersionLink	= '';
			$rightVersionLink	= '';	
			
			$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
			
			if($treeMainVersion != 1 && $arrDocumentDetails['parentTreeId'] > 0)
			{	
				$leftVersionLink = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrDocumentDetails['parentTreeId'].'&doc&version" style="text-decoration:none"><img src="'.base_url().'images/left.gif" border="0"></a>';
			}
			if($arrDocumentDetails['latestVersion'] != 1)
			{	
				$childTreeId = $this->document_db_manager->getChildTreeIdByTreeId( $treeId );													
				$rightVersionLink = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$childTreeId.'&doc=exist&version" style="text-decoration:none"><img src="'.base_url().'images/right.gif" border="0"></a>';	
			}
			?>
    <!-- Div contains tabs -->
    <div class="menu_new" >
		
		<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait">
			 <li id="treeUpdate"  style="float:right;"><img  id="updateImag" src="<?php echo base_url()?>images/new-version.png" border="0"  onclick='window.location="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist"'  style=" cursor:pointer" ></li>
		
		<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</ul>
        <!--follow and sync icon code end -->
	
          <ul class="tab_menu_new_for_mobile">
        <li class="document-view_sel"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1" class="active" title="<?php echo $this->lang->line('txt_Document_View');?>" ></a></li>
        <li class="time-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=2" title="<?php echo $this->lang->line('txt_Time_View');?>" ><span></span></a></li>
        <li class="tag-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=3" title="<?php echo $this->lang->line('txt_Tag_View');?>" ><span></span></a></li>
        <li class="link-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=4" title="<?php echo $this->lang->line('txt_Link_View');?>" ><span></span></a></li>
        <li class="talk-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=7" title="<?php echo $this->lang->line('txt_Talk_View');?>"><span></span></a></li>
        <?php
					if (($workSpaceId==0))
					{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" ><span></span></a></li>
        <?php
					}
				?>
        <li class="update-view" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>" ></li>
        <div class="tab_for_landscape">
		<li id="treeUpdate"  style="float:right;"><img  id="updateImage" src="<?php echo base_url()?>images/new-version.png" border="0"  onclick='window.location="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist"'  style=" cursor:pointer" ></li>
		
		<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</div>
      </ul>
          <div class="clr"></div>
        </div>
    <?php	
			$nodeBgColor = 'seedBgColor';
			if(($this->input->get('tagId') != '' && $this->input->get('node') == '') || $this->input->get('node')==$treeId)
			{
				$nodeBgColor = 'nodeBgColorSelect';
			}
			else if ($this->input->get('node')==$treeId)
			{
				$nodeBgColor = 'nodeBgColorSelect';
			}
			else
			{
				$nodeBgColor = 'seedBgColor';
			}
			?>
    
    <!---------  Seed div starts here ---->
    
    <div  onclick="clickDocumentOptions(0)" onmouseout="hideDocumentNodeOptions(0)" onmouseover="showDocumentNodeOptions(0)" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >
          <?php	$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);
		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);
		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);	
		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	
		$total=0;	
?>
		<!--Manoj: Increase height from 30-->
          <div  style="height:45px; "> 
        
        <!--       my tyest           -->
        
        <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none; <?php if($arrDocumentDetails['latestVersion'] != 1){ echo "margin-right:18%;"; } ?> " >
              <div style="float:left; margin-right:10px;" class="selCont">
            <div class="newListSelected"  tabindex="0" style="position: relative;outline:none;">
                  <div class="selectedTxt" onclick="showTreeOptions()" ></div>
                  <ul id="ulTreeOption"   style="visibility: visible; width: 155px; top: 19px; left: 0pt; display: none;" class="newList">
                <?php 	
						if ( $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId1, $placeType))
            			{
					?>
                <li><a id="aMove" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>
                <?php
						}
					?>
					<li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Document');?></a></li>
                <?php
					if($arrDocumentDetails['latestVersion'] == 1 && $arrDocumentDetails['userId'] == $_SESSION['userId'])
					{
					?>
                <li><a id="acreateVersion" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'createVersion',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Create_Version');?></a></li>
                <?php
					}
					?>
               <?php /*?> <li><a id="aexportFile" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'exportFile',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Export_File');?></a></li><?php */?>
				
				<!--Manoj: Added contributor in list start-->
				<li><a id="aContributors" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'contributors',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Contributors');?></a></li>
				<!--Manoj: Added contributor in list end-->
				
				<?php 
		
					$treeName['treeName']='docs';	
					$this->load->view('common/printPage_for_mobile',$treeName);	
				
				?>
				
              </ul>
                </div>
          </div>
              <ul  class="content-list" style="float:left" >
            <?php
						
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
						
				?>
            <!--Added by Surbhi IV -->
            <?php if($latestVersion!=1 && !$total) {  } else { ?>
            <!--End of Added by Surbhi IV -->
            <li><a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/<?php echo $latestVersion; ?>', 710, 420, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong></a></li>
            <!--Added by Surbhi IV -->
            <?php } ?>
            <!--End of Added by Surbhi IV -->
            
            <?php	
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
						 $appliedLinks.=$linkData['name'].", ";
				   }
					$appliedLinks=substr($appliedLinks, 0, -2)."
"; 				}	
				
				
				if(count($docTrees3)>0)
			    {
					$appliedLinks.=$this->lang->line('txt_Chat').': ';	
					foreach($docTrees3 as $key=>$linkData)
				   {
						 $appliedLinks.=$linkData['name'].", ";
						
					}
					
					$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
				}	
				
				if(count($docTrees4)>0)
				{
				
					$appliedLinks.=$this->lang->line('txt_Task').': ';	
					foreach($docTrees4 as $key=>$linkData)
				   	{
						 $appliedLinks.=$linkData['name'].", ";
						
					}
					$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
				}	
				
				if(count($docTrees6)>0)
				{
					$appliedLinks.=$this->lang->line('txt_Notes').': ';	
					foreach($docTrees6 as $key=>$linkData)
				   {
						 $appliedLinks.=$linkData['name'].", ";
					}
					$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
				}
				
				if(count($docTrees5)>0)
				{
				
					$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
					foreach($docTrees5 as $key=>$linkData)
				   {
						 $appliedLinks.=$linkData['name'].", ";
						
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
					$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
				
				}
				
			   
			  
			}
		
				?>
            <!--Added by Surbhi IV -->
            <?php if($latestVersion!=1 && !$total) {  } else { ?>
            <!--End of Added by Surbhi IV -->
            
            <li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/<?php echo $latestVersion; ?>', 680, 375, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
            
            <!--Added by Surbhi IV -->
            <?php } ?>
            <!--End of Added by Surbhi IV -->
            <?php			
						
						$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
						/*<!--Added by Surbhi IV -->	*/
						$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);
						if(strip_tags($talk[0]->contents))
						{
							$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
						    $latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
						}
						else
						{
							$latestTalk='Talk';
						}
						/*<!--End of Added by Surbhi IV -->	*/
						if($total==0)
						{
						  $total='';
						}?>
            <!--Added by Surbhi IV -->
            <?php if($latestVersion!=1 && !$total) {  } else { ?>
            <!--End of Added by Surbhi IV -->
            <?php 
			
							/*<!--Changed title by Surbhi IV -->	*/
							echo '<li class="talk"><a id="liTalk'.$leafTreeId.'"  href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/1\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
							/*<!--End of Changed title by Surbhi IV -->	*/
						
					?>
            <!--Added by Surbhi IV -->
            <?php } ?>
            <!--End of Added by Surbhi IV -->
            
          </ul>
            </div>
        <div style="float:right; margin-right:10px;" >
              <div class="clsLabel" style="float:left" ><?php echo $this->lang->line('txt_Version');?>&nbsp;</div>
              <div class="tdSpace" style="float:left"><?php echo $leftVersionLink.' '.$arrDocumentDetails['version'].' '.$rightVersionLink;?></div>
              <div class="clr"></div>
            </div>
        <div class="clr"></div>
      </div>
          <div>
        <div   class="clsNoteTreeHeader handCursor"  >
              <div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
            <?php
								echo strip_tags(stripslashes($arrDocumentDetails['name']),'<b><em><span><img>'); 
						?>
          </div>
              <?php
								if (!empty($arrDocumentDetails['old_name']))
			 					{
			 						
										echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDocumentDetails['old_name']),'<span><img>').')</div>';
			 					}
						?>
            </div>
        <div class="clsNoteTreeHeaderLeft" style="width:75%;">
              <div id="divAutoNumbering" style="display:none; float:right " >
            <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId; ?>&doc=exist">

		

						  

								

								<?php /**************** MOVE TREE CODE START *******************/ ?>

						

						<?php 

							

									if($workSpaceType==2 )

									{

										$placeType=$workSpaceType+1;

										$workSpaceId1=$this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);

										

									

									}

									else

									{

										$placeType=$workSpaceType+2;

									   $workSpaceId1=$workSpaceId;

									}

							

							

							?>

						

						<?php /**************** MOVE TREE CODE CLOSE *******************/ ?>

							<div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Document');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

							<input type="hidden" name="autonumbering_submit" value="1" />

							</div>

							<div style="float:left">	

								<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideDivAutoNumbering()" style="margin-top:-2px;"  border="0"  /> 

							</div>	

								</form>
          </div>
              
              <!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->
              <div id="spanMoveTree" style="float:left; text-align:left" >
            <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
            <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
            <div class="lblMoveTree" style="text-align:left;"><?php echo $this->lang->line('move_tree_to_txt'); ?></div>
            <div class="floatLeft" style="margin-top: 4%">
                  <?php   
							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
							{   
								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
							?>
                  <select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >
                <?php 
						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{	
							if($workSpaceData['workSpaceName']!='Try Teeme')
							{			
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
					
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
									}
								}
						} //try teeme restriction end
						}
						}
						else
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{	
							if($workSpaceData['workSpaceName']!='Try Teeme')
							{			
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))
							{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
				
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
										}
									}
								}
						} //try teeme restriction end
						}
						
						}
						?>
              </select>
                  <?php
					}
					?>
                </div>
            <div  class="floatLeft" id="divselectMoveToUser" style="margin: 3% 0%;"  > </div>
            &nbsp; <img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
              
              <!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- --> 
              
            </div>
        <div class="clr" ></div>
        <div style="height:20px;">
              <div id="normalView0" class="normalView" style="display:none"  >
            <div class="lblNotesDetails"   >
                  <div class="style2" style="width:100%; text-align:left; margin:1%;"> 
               	<div>
                <?php 
					echo $arrUser['userTagName'];
					if(strlen($arrUser['userTagName'])>25)
					{
				    ?>
				 
				    </div>
				    <div style="margin-top: 5px;">
				  
				    <?php } 
					
					//Start Manoj: Remove date suffix and current year
					 
					 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrDocumentDetails['documentCreatedDate'], $this->config->item('date_format'));
					 $Create_date = explode(' ',$Create_date);
					 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
					 $current_year = date("y");
					 if($current_year == $Create_date[2])
					 {
						$Create_date[2]=" ";
					 }
					 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
					 
					 //End Manoj: Remove date suffix
					
					//echo $this->time_manager->getUserTimeFromGMTTime($arrDocumentDetails['documentCreatedDate'], $this->config->item('date_format'));
				?> 
				</div>
			     </div>
                  <!--editLeafMobile class added to hide edit option for devices that do not support editor -->
                  
                  <div style="margin-top:12%; " class="editLeafMobile" >
				   
				   <!--Changed by Surbhi IV -->
                <?php
					if($arrDocumentDetails['latestVersion']==1)
					{
				?>
                <!--/*Added by Surbhi IV for checking version */-->
				<!--Manoj: Added contributor condition-->
                <div style="float:left;"><a  style="margin-right:25px;  float:left;" id="aAddNewNote" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock2"';}else { echo 'class="disnone2"';} ?> <?php if($arrDocumentDetails['latestVersion']==1) {echo 'class="disblock2"';}else { echo 'class="disnone2"' ; } ?> href="javascript:void(0);" onClick="addFirstLeaf(<?php echo $treeId;?>,0,'<?php echo $arrDocumentDetails['version']; ?>')"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a></div>
                <!--/*End of Added by Surbhi IV for checking version */-->
                <?php 
					
					 }
					 
					 ?>
                <!--end of Changed by Surbhi IV --> 
				  
				  
                <?php 
						
             				if ($arrDocumentDetails['userId'] == $_SESSION['userId'] && $latestVersion==1)
                			{
						
             			?>
                <a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','<?php echo $arrDocumentDetails['version']; ?>')"  style="float:right; " ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0"></a>
                <?php 	
							}
							
							?>
              </div>
                </div>
          </div>
              <div class=" lblTagName"     > </div>
            </div>
      </div>
          <div id="edit_doc" class="clsEditorbox1" style="display:none" >
        <form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/document">
              <div id="divEditDoc"></div>
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="docTitleSaveNew('<?php echo $arrDocumentDetails['version']; ?>','<?php echo $treeId; ?>');" />
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="docTitleCancel();" />
              <input type="hidden" name="treeId" value="<?php echo $treeId; ?>">
            </form>
      </div>
          <div id="0notes"   style="width:950px; height:240px; float:left; display:none;" >
        <?php 
				$firstSuccessor = 0;
				if(count($Contactdetail) > 0)
				{
					$firstSuccessor = $Contactdetail[0]['nodeId'];			
				}
				?>
        <form name="form10" id="form10" method="post" action="<?php echo base_url();?>notes/addMyNotes/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">
              <div id="containerseed" name="containerseed" ></div>
              <span id='saveOption'></span>
              <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion0',document.form10);" class="button01">
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input type="button" name="Replybutton1" value="Cancel" onClick="reply_close12(0);" class="button01">
              <input name="editorname1" id="editorname1" type="hidden"  value="replyDiscussion0">
              <input name="seedpredecessor" id="seedpredecessor" type="hidden"  value="0">
              <input name="seedsuccessors" id="seedsuccessors" type="hidden"  value="<?php echo $firstSuccessor;?>">
              <input name="reply" id="reply" type="hidden"  value="1">
              <input type="hidden" name="treeId" id="treeId" value="<?php echo $treeId ?>" />
            </form>
      </div>
          <div class="divLinkFrame" >
        <div id="linkIframeId0"    style="display:none;"></div>
      </div>
          <span id="spanArtifactLinks0" style="display:none;"></span>
          <?php
		
				#********************************************* Tags ********************************************************88
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;	
				?>
          <div id="spanTagView0" style="display:none;">
        <div id="spanTagViewInner0">
              <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; ">
            <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}					
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
				
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				
				
				?>
          </div>
            </div>
        <div class="divTagsButton" style="width:auto" >
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(0)" />
              <span id="spanTagNew0">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(0,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" />
          </span> </div>
      </div>
          <?php
$this->load->helper('form'); 
$attributes = array('name' => 'frmEditLeaf', 'id' => 'frmEditLeaf', 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('edit_leaf_save/index/doc/'.$this->input->get('doc'), $attributes);
?>
         <div class="talkformdoc"><div id="leafAddFirst" align="left" style="width:100%; padding-left:10px;float:left;display:none;"> </div></div>
          <?php	
				#*********************************************** Tags ********************************************************																		
				?>
          <div class="clr"></div>
        </div>
    <div id="loader0"></div>
    <!-- Seed div ends here -->
    
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
          <div id="docErrorMsg" class="errorMsg"></div>
        </div>
    <div id="datacontainer"> 
          <!------------ Main Body of the document ------------------------->
          
          <div id="mainContentProof">
        <?php
					$arrDetails['viewOption'] = 'htmlView';
					$arrDetails['doc'] = $this->input->get('doc');	
						
					/*$memc = new Memcached;
					$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
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
							
						$this->load->view('document/document_body_for_mobile', $arrDetails);			
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
      </div>
          <div id="editLeaf"></div>
          <div id="contentSearchDiv" handlefor="contentSearchDiv" style="display:none; border:1px solid BLACK; position:absolute; width:350px; height:100px; z-index:2; left: 300px; top: 110px;"> Please enter the text to search:
        <input type="text" name="leafSearch" id="leafSearch">
        <input type="button" name="search" value="<?php echo $this->lang->line('txt_Done');?>" onClick="searchText(<?php echo $treeId;?>)">
        &nbsp;&nbsp;
        <input type="button" value="<?php echo $this->lang->line('txt_Close');?>" onClick="hideSearch('contentSearchDiv')">
      </div>
        </div>
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
<script>
		// Keep Checking for tree updates every 5 second
		<!--Updated by Surbhi IV-->
		//setInterval("checktreeUpdateCount(<?php  echo $treeId; ?>,<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','<?php echo $arrDocumentDetails['version'] ?>')", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php  echo $treeId; ?>,<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','<?php echo $arrDocumentDetails['version'] ?>')", 20000);
		<!--End of Updated by Surbhi IV-->	
</script>