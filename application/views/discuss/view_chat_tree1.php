<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<?php

$_SESSION['chatTimeStamp1']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
</script>
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content"> 
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
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
    
    <div>
      <div class="menu_new" >
        <ul class="tab_menu_new">
          <li class="discuss-view_sel"><a class="active 1tab" href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
          <li class="stop-time-view"><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
          <li class="tag-view" ><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
          <li class="link-view"><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
          <?php
                    if (($workSpaceId==0))
                    {
                    ?>
          <li class="share-view"><a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
          <?php
                    }
                    ?>
          <li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick='window.location=("<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1")' style=" cursor:pointer" ></li>
        </ul>
        <div class="clr"></div>
      </div>
      <!-- Main Body -->
      <?php $position=0;
				$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
				?>
      <?php $position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);

			if ($treeId == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = 'seedBgColor';
?>
      
      <!---------  Seed div starts here ---->
      
      <div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >
        <?php									
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
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
        <div  style="height:30px; "> 
          
          <!--       my tyest           -->
          
          <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " >
            <div style="float:left; margin-right:10px;" class="selCont">
              <div class="newListSelected" tabindex="0" style="position: relative;">
                <div class="selectedTxt" onclick="showTreeOptions()" ></div>
                <ul id="ulTreeOption" style="visibility: visible; width: 140px; top: 19px; left: 0pt;  display: none;" class="newList">
                  <?php
					$opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId, $workSpaceType);
					if ($opt)
					{
                    ?>
                  <li><a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsChat(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>
                  <?php
					}
					?>
					<li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Discuss');?></a></li>
					
                  <li><a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'start',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Start'); ?></a></li>
                	<?php 
				//Manoj: code for showing tree data in pdf file
					$treeName['treeName']='chat';	
					$this->load->view('common/printPage',$treeName);	
				//Manoj: code end
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
											
											$tag_container .= strip_tags($tagData['contactName'],'').", ";	
											
										}
										
										$tag_container=substr($tag_container, 0, -2); 
									}		
							
					}
						
				?>
              <li><a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/1', 710, 420, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong></a></li>
              <?php	
						//count totoal number of links
            			$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees7);
						
						if($total==0)
						{
						  $total='';
						  $appliedLinks=$this->lang->line('txt_None');
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
              <li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 710,500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
            </ul>
          </div>
          <div class="clr"></div>
        </div>
        <div>
          <div   class="clsNoteTreeHeader handCursor"  >
            <div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
              <?php
								echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>');  
								
						?>
            </div>
            <?php
								if (!empty($arrDiscussionDetails['old_name']))
			 					{
			 						
										echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDiscussionDetails['old_name']),'<span><img>').')</div>';
			 					}
						?>
          </div>
          <div class="clsNoteTreeHeaderLeft" >
            <div id="divAutoNumbering" style="display:none; float:right " > 
			
			 <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1">

		

						  

								

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

							<div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Discuss');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

							<input type="hidden" name="autonumbering_submit" value="1" />

							</div>

							<div style="float:left">	

								<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideDivAutoNumbering()" style="margin-top:-2px;"  border="0"  /> 

							</div>	

								</form>
			
			</div>
            
            <!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->
            <div id="spanMoveTree" style="float:right; text-align:right" >
              <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
              <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
              <div class="lblMoveTree" > Move tree to:</div>
              <div class="floatLeft">
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
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
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
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1)
										{
									?>
                  <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                  <?php
				  						}
									}
								}
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
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
							?>
                  <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                  <?php
				  			}
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
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
											if($treeTypeStatus!=1)
											{
									?>
                  <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                  <?php
				  							}
										}
									}
								}
						}
						
						}
						?>
                </select>
                <?php
					}
					?>
              </div>
              <div  class="floatLeft" id="divselectMoveToUser"  > </div>
              &nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
            
            <!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- --> 
            
          </div>
          <div style="height:65px;">
            <div id="normalView0" class="normalView" style="display:none"  >
              <div class="lblNotesDetails"   >
                <div class="style2" style="width:100%" ><?php echo $userDetails['userTagName'];?>&nbsp;&nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['createdDate'], $this->config->item('date_format'));?> </div>
              </div>
            </div>
            <div class=" lblTagName"     > </div>
          </div>
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
            <div style="width:100%; float:left; ">
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
				#*********************************************** Tags ********************************************************																		
				?>
        
        <!--<span>John_Hill 001 &nbsp; <img align="right" width="21" height="18" src="images/right-arrow-icon.png"></span></p>-->
        
        <div class="clr"></div>
      </div>
      
      <!---------  Seed div closes here ---->
      <div > <!-- Leaf Container starts -->
        <?php
	$totalNodes = array();
	
	
	
	$rowColor1='row11';
	$rowColor2='row21';	
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

			 
			if ($arrVal['nodeId'] == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
				
			if ($arrVal['chatSession']==0)
			{	
		?>
        
        <!-- new node -->
        
        <div class="clr"></div>
        <div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onmouseout="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor"  >
          <div style="height:30px; padding-bottom:0px;" >
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
								
								$tag_container .= strip_tags($tagData['contactName'],'').", ";	
								
							}
							
							$tag_container=substr($tag_container, 0, -2); 
						}		
						
					}
						

				?>
              <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 420, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
              <?php				
						
					
					
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees7);
				
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
          <div   >
            <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >
			<div  class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p></div>
              <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?> </div>
            </div>
            <div class="clr"></div>
            <div style="height:30px;" >
			<div style="float:left;max-width:63%;height:30px;min-width:45%;"  >
            <div  style="margin-top:12px;border-bottom:1px dotted gray;margin-left:5%" ></div>
          </div>
              <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none"    >
                <div class="style2"  style="width:930px;" > <?php echo $userDetails1['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));?> </div>
                <div class="editDocumentOption <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  > <a style="margin-right:25px;"  href="javascript:editNotesContents_1(<?php echo $position;?>,<?php echo $focusId;?>,<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,'<?php echo $this->lang->line('txt_Done');?>',<?php echo $arrVal['successors'];?>,<?php echo $arrVal['leafid'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a> <a style="margin-right:25px;"  href="javascript:addLeaf(<?php echo $arrVal['leafid'];?>,<?php echo $treeId;?>,<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>,<?php echo $arrVal['successors'];?>);"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a> </div>
              </div>
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
        
        <!-- close node-->
        
        <div style="width:100%;  background-color:#FFFFFF;  ">
          <div id="<?php echo $position++;?>" style=" float:left; width:100%;" onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>)" class=" handCursor">
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
					
				
				?>
            <div id="normalView<?php echo $arrVal['nodeId'];?>" style="width:100%; float:left; display:none;" class="<?php echo $nodeBgColor;?>"> <a href="javascript:void(0)" onClick="showTagView(<?php echo $arrVal['nodeId'];?>)"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; <a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a> &nbsp;&nbsp; <?php echo $userDetails1['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format'));?> </div>
            <?php
				#********************************************* Tags ********************************************************88

				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
            <div style="width:100%; float:left;"> </div>
            <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>" style="display:none"> </span> </span>
            <?php	
				#*********************************************** Tags ********************************************************																		
				?>
            <div style="">
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
				
				?>
              <div id="<?php echo $position++;?>" style="width:100%; padding-left:8%; float:left; padding-bottom:20px;" onClick="showNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseover="showNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseout="hideNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"    class="<?php echo $nodeBgColor;?> handCursor">
                <div style="height:30px; width:89%; padding-bottom:10px;" >
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
										
										$tag_container .= strip_tags($tagData['contactName'],'').", ";	
										
									}
									
									$tag_container=substr($tag_container, 0, -2); 
								 }		
							
					}
						

				?>
                    <li><a id="liTag<?php echo $arrDiscussions['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrDiscussions['nodeId'] ; ?>/2', 710, 420, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
                    <?php				
						
					
					
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7);
				
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
							}	
							
							$appliedLinks=substr($appliedLinks, 0, -2); 
						
					}
					
					?>
                    <li  ><a id="liLink<?php echo $arrDiscussions['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrDiscussions['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/0', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
                  </ul>
                </div>
				<div class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i.".".$j; }?></p></div>
                <div style="font-size:78%;width:79%;text-align:justify;"  id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" >
                  <?php  echo stripslashes(strip_tags($arrDiscussions['contents']));?>
                </div>
                <!-- display none -->
				<div style="float:left;height:30px;max-width:70%;min-width:45%;" class="grayLine"  >
                <div  style=" margin-top:12px;border-bottom:1px dotted gray;" ></div>
              </div>
                <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style=" height:15px; "    >
                  <div id="normalView<?php echo $arrDiscussions['nodeId']; ?>" class="style2"  style=" display:none" > <?php echo $userDetails['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format'));?> </div>
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
                <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
                  <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)" />
                  <span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>">
                  <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1,<?php echo $arrDiscussions['nodeId']; ?>)" />
                  </span> </div>
                </span> </div>
              <?php	

				#*********************************************** Tags ********************************************************																		
				?>
              <span id="reply<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"></span>
              <?php
				$counter++;
				$j++;
			}			
		}		
		?>
              <?php if($timmer){?>
              <div  class="<?php echo $nodeBgColor; ?>" style="float:left; width:900px">
                <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Comment');?>" onclick="showReply1(<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>; replay_target=0;"/>
              </div>
              <?php }?>
              <div  id="reply<?php echo $arrVal['nodeId'];?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; display:none;">
                <div id="txt_reply<?php echo $arrVal['nodeId'];?>"></div>
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
      <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
    </div>
    <script language="javascript">
function showNotesNodeOptions_old(position)
{			
	var notesId = 'normalView'+position;		
	if(position > 0)
	{
		document.getElementById('normalView0').style.display = "none";
	}
	if(document.getElementById(notesId).style.display == "none")
	{			
		document.getElementById(notesId).style.display = "";
	}
	else
	{
		document.getElementById(notesId).style.display = "none";
	}
	var allNodes 	= document.getElementById('totalNodes').value;
	var arrNodes 	= new Array();
	arrNodes 		= allNodes.split(',');
	
	for(var i = 0;i<arrNodes.length;i++)
	{		
		if(position != arrNodes[i])
		{
			var notesId = 'normalView'+arrNodes[i];	
			document.getElementById(notesId).style.display = "none";
		}
	}
	
}
</script> 
    <!-- Main Body -->
    </td>
    </tr>
    </table>
  </div>
  <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
</div>
</div>
<?php $this->load->view('common/foot');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
