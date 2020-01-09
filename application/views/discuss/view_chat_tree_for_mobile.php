<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<?php
$position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
?>
<div class="talkformchat">
<?php
$this->load->helper('form'); 
$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('new_chat/index/'.$treeId.'/1', $attributes);
?>

<div > <!-- Leaf Container starts -->
  <?php
	$totalNodes = array();
	
	
	
	$rowColor1='row1';
	$rowColor2='row2';	
	$i = 1;	
	
	
	if(count($arrDiscussions) > 0)
	{				 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			
			$checksucc 		=	$this->chat_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$this->chat_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
			$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			 
			if ($arrVal['nodeId'] == $this->uri->segment(8)||  $arrVal['nodeId'] == $this->input->get('node'))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				//$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
				$nodeBgColor = ($i % 2 == 0) ? $rowColor1 : $rowColor2;
				
			if ($arrVal['chatSession']==0)
			{?>
  
  <!-- new node -->
  
  <div class="clr"></div>
  <div  id="discussLeafContent<?php echo $arrVal['nodeId']; ?>" onclick="showCommentButton(<?php echo $arrVal['nodeId']; ?>)" onmouseover="mouseOverCommentButton(<?php echo $arrVal['nodeId']; ?>)" onmouseout="mouseOutCommentButton(<?php echo $arrVal['nodeId']; ?>)" >
    <div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onmouseout="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor"  >
      <div style="height:30px; padding-bottom:0px;">
        <ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; display:none" class="content-list ulNodesHeader">
          <?php
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);	
					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);
					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);		
						
					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
					if($total==0)
					{
						$total='';
						$tag_container=$this->lang->line('txt_None');
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
											
											$tag_container .= $tagData['contactName'].", ";	
											
										}
										
										$tag_container=substr($tag_container, 0, -2); 
									}		
							
					}
						

				?>
          <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo $tag_container; ?>"  ><strong><?php echo $total; ?></strong></a></li>
          <?php				
						
					
					
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
				
				$appliedLinks=' ';
				
				if($total==0)
					{
						$total='';
						$appliedLinks=$this->lang->line('txt_None') ;
					}
					else
					{
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							
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
							
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees9	)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
								foreach($docTrees9 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['url'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
						
					}
					
					?>
          <li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
        </ul>
      </div>
      <div class="clr"></div>
      <div>
        <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"   >
		<div  class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p></div>
          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?> </div>
        </div>
        <div class="clr"></div>
        <div style="height:18px;" >
          <div style="max-width:63%;height:15px;min-width:45%;"  >
            <div  style="margin-top:12px;border-bottom:1px dotted gray;margin-left:5%" ></div>
          </div>
          <div class=" lblNotesDetails1 normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none; float:left;min-width:100%;"    >
            
			<div class="style2"  style="text-align:left; margin-left: 3%;" > 
			<div>
			<?php 
				echo $userDetails1['userTagName'];
				if(strlen($userDetails1['userTagName'])>21)
		  		{
			?>
			</div>
			<div style="margin-top: 5px;">
			<?php 
				}
				
			 		//Start Manoj: Remove date suffix and current year
					 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));
					 $Create_date = explode(' ',$Create_date);
					 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
					 $current_year = date("y");
					 if($current_year == $Create_date[2])
					 {
						$Create_date[2]=" ";
					 }
					 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
					 //End Manoj: Remove date suffix	
			
					//echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));
			
			?> 
			</div>
			</div>
			
            <div class="editDocumentOption <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  > <a style="margin-right:25px;"  href="javascript:editNotesContents_1(<?php echo $position;?>,<?php echo $focusId;?>,<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,'<?php echo $this->lang->line('txt_Done');?>',<?php echo $arrVal['successors'];?>,<?php echo $arrVal['leafid'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a> <a style="margin-right:25px;"  href="javascript:addLeaf(<?php echo $arrVal['leafid'];?>,<?php echo $treeId;?>,<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>,<?php echo $arrVal['successors'];?>);"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a> </div>
          </div>
          <div class="clr"></div>
        </div>
        <?php
				#******************************* * * * * * * * * * * * * * * Tags * * * * * * * * ************************************************88
							
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;
				?>
        <div class="divLinkFrame">
          <div id="linkIframeId<?php echo $arrVal['nodeId']; ?>"    style="display:none;"></div>
        </div>
        <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
        <div class="commonDiv"> </div>
        </span>
        <div class="commonDiv">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(<?php echo $arrVal['nodeId'];?>)" />
          <span id="spanTagNew<?php echo $arrVal['nodeId'];?>">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" />
          </span> </div>
        </span>
        <?php	
				#*********************************************** Tags ********************************************************																		
				?>
        <div class="divEditLaef" > 
          <!------------ Main Body of the document ------------------------->
          <div id="editleaf<?php echo $position;?>" style="display:none;"></div>
        </div>
        <div class="divEditLaef" >
          <div id="addleaf<?php echo $position;?>" style="display:none;"></div>
        </div>
        <div class="clr"></div>
      </div>
    </div>
    <?php

				//$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
    			$nodeBgColor = ($i % 2 == 0) ? $rowColor1 : $rowColor2;
		?>
    <!-- close node-->
    
    <div class="discussionComments" style="width:100%;background-color:#FFFFFF;  ">
      <div id="<?php echo $position++;?>" style=" float:left; width:100%;padding-left:0px;" onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>)" class="<?php echo $nodeBgColor;?> handCursor">
        <?php 
                $viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
                $actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
                $contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
                $userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);
    
                $docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
                $docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
                $docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
                $docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
                $docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
                $docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
                $docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);
					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);	
            ?>
        <div id="normalView<?php echo $arrVal['nodeId'];?>" style="float:left;display:none;" class="<?php echo $nodeBgColor;?>"> <a href="javascript:void(0)" onClick="showTagView(<?php echo $arrVal['nodeId'];?>)"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; <a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a> &nbsp;&nbsp; <?php echo $userDetails1['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));?> </div>
        <?php
				#********************************************* Tags ********************************************************88

				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
        <div style="width:80%; float:left;"> </div>
        <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>"> </span>
        <div style="width:80%; float:left;">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,2)" />
          <span id="spanTagNew<?php echo $arrVal['nodeId'];?>">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" />
          </span> </div>
        </span>
        <?php	
				#*********************************************** Tags ********************************************************																		
				?>
        <!-- <div style="padding-left:20px;"> -->
        <div >
          <?php

			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
			
			$rowColor3='chatBgColor1';
			$rowColor4='rowColor4';	
			$j = 1;
			
			
				
			if($arrparent['successors'])
			{
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				$counter=0;
				while($counter < count($sArray))
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
		
					$totalNodes[] = $arrDiscussions['nodeId'];	 
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8) || $arrDiscussions['nodeId'] == $this->input->get('node'))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						//$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;
						$nodeBgColor = ($i % 2 == 1) ? $rowColor3 : $rowColor4;	 		
					?>
          <div id="<?php echo $position++;?>" style="width:80%;float:left; padding-left: 20%;  " onClick="clickNodesOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseover="showNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseout="hideNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"    class="<?php echo $nodeBgColor;?> handCursor" >
            <div style="height:30px;width:96%;" >
              <ul id="ulNodesHeader<?php echo $arrDiscussions['nodeId']; ?>" style="float:right; display:none " class="content-list ulNodesHeader">
                <?php
						$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
						$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
						$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
						$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					
						$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1, 2);
						$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2, 2);
						$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3, 2);
						$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4, 2);
						$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5, 2);
						$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6, 2);
						$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'], 2);		
						$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrDiscussions['nodeId'], 2);		
						
							
					
							
						$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
						if($total==0)
						{
							$total='';
							$tag_container=$this->lang->line('txt_None');
						}
						else
						{
							
								 if(count($viewTags)>0)
								 {
									$tag_container='Simple Tag : ';
									foreach($viewTags as $simpleTag)
									$tag_container.=$simpleTag['tagName'].", ";
									$tag_container=substr($tag_container, 0, -2).
	""; 
								 
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
										
										$tag_container=substr($tag_container, 0, -2).
	""; 
									}
									
									
									if(count($contactTags) > 0)
										{
											$tag_container.='Contact Tag : ';
											$tagAvlStatus = 1;	
											foreach($contactTags as $tagData)
											{
												
												$tag_container .= $tagData['contactName'].", ";	
												
											}
											
											$tag_container=substr($tag_container, 0, -2); 
										}		
								
						}
							
					?>
                <!--Changed by Surbhi IV -->
                <li><a id="liTag<?php echo $arrDiscussions['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrDiscussions['nodeId'] ; ?>/2/1', 710, 420, null, '');" href="javascript:void(0);" title="<?php echo $tag_container; ?>"  ><strong><?php echo $total; ?></strong></a></li>
                <!-- End of Changed by Surbhi IV -->
                <?php				
					$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
				
					$appliedLinks=' ';
					
					if($total==0)
					{
						$total='';
						$appliedLinks=$this->lang->line('txt_None') ;
					}
					else
					{
							 
							   
							   if(count($docTrees1)>0)
							   {
								   $appliedLinks .= $this->lang->line('txt_Document').': ';
								   foreach($docTrees1 as $key=>$linkData)
								   {
										 $appliedLinks.=$linkData['name'].", ";
										
									}
								}	
								
								
								 if(count($docTrees3)>0)
							   {
									$appliedLinks.=$this->lang->line('txt_Chat').': ';	
									foreach($docTrees3 as $key=>$linkData)
								   {
										 $appliedLinks.=$linkData['name'].", ";
										
									}
								}	
								
								if(count($docTrees4)>0)
								{
								
									$appliedLinks.=$this->lang->line('txt_Task').': ';	
									foreach($docTrees4 as $key=>$linkData)
								   {
										 $appliedLinks.=$linkData['name'].", ";
										
									}
								}	
								
								if(count($docTrees6)>0)
								{
									$appliedLinks.=$this->lang->line('txt_Notes').': ';	
									foreach($docTrees6 as $key=>$linkData)
								   {
										 $appliedLinks.=$linkData['name'].", ";
									}
								}
								
								if(count($docTrees5)>0)
								{
								
									$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
									foreach($docTrees5 as $key=>$linkData)
								   {
										 $appliedLinks.=$linkData['name'].", ";
										
									}
								
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
								}	
								
								if(count($docTrees9	)>0)
								{
								
									$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
									foreach($docTrees9 as $key=>$linkData)
								    {
										 $appliedLinks.=$linkData['title'].", ";
										
									}
								
								}
							
								
								
								$appliedLinks=substr($appliedLinks, 0, -2); 
							
						}
						
						?>
                <!--Changed by Surbhi IV -->
                <li  ><a id="liLink<?php echo $arrDiscussions['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrDiscussions['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo $appliedLinks; ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
                
                <!--End of Changed by Surbhi IV -->
                
              </ul>
            </div>
			<div class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i.".".$j; }?></p></div>
            <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>"  style="font-size:0.8em;text-align:justify; width:78%;">
              <?php  echo $arrDiscussions['contents'];?>
            </div>
            <!-- display none -->
            <div class="clr"></div>
            <div style="height:30px" >
              <div style="height:18px;max-width:70%;min-width:45%;" class="grayLine"  >
                <div  style=" margin-top:12px;border-bottom:1px dotted gray;" ></div>
              </div>
              
			  <div class="lblNotesDetails1 style2 normalView"  id="normalView<?php echo $arrDiscussions['nodeId'];?>"  style="float:left; height:15px;display:none;text-align:left;max-width:100%; margin-left:3%;"    >
			  <div>
			   <?php
			    echo $userDetails['userTagName'];
				if(strlen($userDetails['userTagName'])>21)
		  		{
			  ?>
			</div>
			<div style="margin-top: 5px;">
			   <?php 
			   }
			   		//Start Manoj: Remove date suffix and current year
					 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format'));
					 $Create_date = explode(' ',$Create_date);
					 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
					 $current_year = date("y");
					 if($current_year == $Create_date[2])
					 {
						$Create_date[2]=" ";
					 }
					 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
					 //End Manoj: Remove date suffix
			   
			        //echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format'));
			   ?> 
			   </div>
			  </div>
			  
              <div class="clr"></div>
            </div>
            <?php
					#********************************************* Tags ********************************************************88
	
					$dispViewTags = '';
					$dispResponseTags = '';
					$dispContactTags = '';
					$dispUserTags = '';
					$nodeTagStatus = 0;		
					?>
            <span id="spanArtifactLinks<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"> </span> <span id="spanTagView<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrDiscussions['nodeId'];?>"> </span>
            <div style=" float:left;">
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)" />
              <span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>">
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1,<?php echo $arrDiscussions['nodeId']; ?>)" />
              </span> </div>
            </span> </div>
          <?php	
	
					#*********************************************** Tags ********************************************************																		
					?>
          <div style="clear:both;"></div>
          <?php
					$counter++;
					$j++;
				}			
		}		
		?>
          <div  class="<?php echo $nodeBgColor; ?>" style="float:left;height:20px; padding-left:40px;padding-bottom:10px;margin-top:-3px ; width:100%;">
            <?php if($timmer){?>
            <img src="<?php echo base_url(); ?>images/subtask-icon_new.png" id="divCommentButton<?php echo $arrVal['nodeId']; ?>"  onclick="showReply1(<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>; replay_target=0;" title="Add Comment" style="display:none;" />
            <?php }?>
          </div>
		  
		  <div id="loader<?php echo $arrVal['nodeId']; ?>"></div>
		  
          <div  id="reply<?php echo $arrVal['nodeId'];?>" style="float:left; display:none;padding:0px 10px 0px; width:95%;">
		  	 <b><img src="<?php echo base_url();?>images/addnew.png" style="padding-top:5px;"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ><span style="margin-left:5px" ><?php echo $this->lang->line('txt_Comment');?>:</span></b><br><br>
            <div id="txt_reply<?php echo $arrVal['nodeId'];?>" ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
		}
		
		
		$i++;
		}
	}
	 
?>
</div>
<input name="reply" type="hidden" id="reply" value="1">
<input name="editStatus" type="hidden" id="editStatus" value="0">
<input name="editorname1" id="editorname1" type="hidden"  value="">
<input name="nodeId" type="hidden" id="nodeId" value="">
<input name="vks" type="hidden" id="vks" value="1">
<input name="chat_view" type="hidden" id="chat_view" value="1">
<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
</form>
</div>
<?php 
$totalNodes[] = 0;
?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
