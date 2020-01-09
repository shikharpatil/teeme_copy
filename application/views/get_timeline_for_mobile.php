<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<div>
<?php 
//echo '<pre>';
//print_r($arrTimeline); 
?>
</div>
<div class="talkformchat">

  <?php
	$totalNodes = array();
	
	
	
	$rowColor1='row';
	$rowColor2='row';	
	$i = 1;	
	
	
	if(count($arrTimeline) > 0)
	{				 
		foreach($arrTimeline as $keyVal=>$arrVal)
		{
		
			//post search by user start
			if($userPostSearch == '' || $userPostSearch==$arrVal['userId'])
			{
			
			$postLinkedTreeCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'tree');
			$treeLinkedArray[$arrVal['nodeId']]=$postLinkedTreeCount;
			$postLinkedFileCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'file');
			$fileLinkedArray[$arrVal['nodeId']]=$postLinkedFileCount;
			$postLinkedUrlCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'url');
			$urlLinkedArray[$arrVal['nodeId']]=$postLinkedUrlCount;
			$postTaggedCount = $this->identity_db_manager->getTaggedPostByNodeId($arrVal['nodeId']);
			$taggedNodesArray[$arrVal['nodeId']]=$postTaggedCount;
		
			$originatorUserId=$this->identity_db_manager->get_tree_originator_id('3',$arrVal['nodeId']);
			
			$postSharedMembers = $this->identity_db_manager->getPostSharedMembersByNodeId($arrVal['nodeId']);
			
			$postSharedMembersList = implode(",",$postSharedMembers);
		
			if ($arrVal['nodeId'] == $this->uri->segment(9))
			{
				$nodeBggreenColor = 'nodeBgColorSelect';
			}
			else
			{
				$nodeBggreenColor = '';
			}
//$this->load->helper('form'); 
//$attributes = array('name' => 'form'.$arrVal['nodeId'], 'id' => 'form'.$arrVal['nodeId'], 'method' => 'post', 'enctype' => 'multipart/form-data');	
//echo form_open('post/index/'.$treeId.'/1', $attributes);
?>
<form enctype="multipart/form-data" name="form<?php echo $arrVal['nodeId']; ?>" id="form<?php echo $arrVal['nodeId']; ?>" method="post" action="" class="offset" >
<div > <!-- Leaf Container starts -->
	<?php	
	
			//for all posts section space name
			if ($arrVal['commentWorkSpaceId']==0)
			{
				$spaceStatus = 1;
				$isSpaceMember = 1;
			}
			else
			{	
				if ($arrVal['commentWorkSpaceType']==2)
				{
					$workSpaceDetails1	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($arrVal['commentWorkSpaceId']);
					$workSpaceDetails1['workSpaceName'] = $workSpaceDetails1['subWorkSpaceName'];
					
					$isSpaceMember = $this->identity_db_manager->isSubWorkSpaceMember($arrVal['commentWorkSpaceId'],$_SESSION['userId']);
				}
				else
				{
					$workSpaceDetails1	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrVal['commentWorkSpaceId']);	
					
					$isSpaceMember = $this->identity_db_manager->isWorkSpaceMember($arrVal['commentWorkSpaceId'],$_SESSION['userId']);
				}	
			}
			//code end
	
	
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			
			$checksucc 		=	$this->chat_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$TimelineProfiledetail = $this->profile_manager->getUserDetailsByUserId($arrVal['userId']);
			
			//$this->chat_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
			//$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			 
			if ($arrVal['nodeId'] == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
				
			if ($arrVal['chatSession']==0)
			{?>
  
  <!-- new node -->
  
  <div class="clr"></div>
  <div id="timelinePostContents" style="word-wrap:break-word;" class="<?php echo $nodeBggreenColor; ?>" >
  
   <!--Post share view start here-->
 					 <?php
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
						?>
  						<?php /*?><div>
			<ul class="tab_menu_new">
	
				<li>
				<a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="tab1m<?php echo $arrVal['nodeId']; ?>" class="active" onclick="$('#tab1m<?php echo $arrVal['nodeId']; ?>').addClass('active');$('#postData<?php echo $arrVal['nodeId']; ?>').show();$('#tab2m<?php echo $arrVal['nodeId']; ?>').removeClass('active');$('#postShare<?php echo $arrVal['nodeId']; ?>').hide();"><img src="<?php echo base_url();?>images/message_gray_btn.png" title="post" style="height:20px; margin-left:3px; width:22px;" /></a>
				</li>
			
				<li>
				<a href="javascript:void(0);" style="padding-left:12%;margin-left:9%;" id="tab2m<?php echo $arrVal['nodeId']; ?>" onclick="$('#tab2m<?php echo $arrVal['nodeId']; ?>').addClass('active');$('#postShare<?php echo $arrVal['nodeId']; ?>').show();$('#tab1m<?php echo $arrVal['nodeId']; ?>').removeClass('active');$('#postData<?php echo $arrVal['nodeId']; ?>').hide();"><img src="<?php  echo base_url().'images/tab-icon/post_share.png'; ?>" title="share" style="height:15px;  margin-left:6px; margin-top: 4px;" /></a>
				</li>

    		</ul>
			</div><?php */?>
			<div class="clr"></div>
			<?php } ?>
  		
  
  			<!--Myspace select recepient code start-->
				 <div id="postShare<?php echo $arrVal['nodeId']; ?>" style="display:none;">
				 <?php
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
						?>
						<input value="<?php echo $postSharedMembersList ?>" id="list<?php echo $arrVal['nodeId']; ?>" type="hidden" />
						<div style="margin-top:1%;">
						<?php
				 		echo $this->lang->line('txt_Select_Recepient(s)')." : <br><br>"; 
						echo $this->lang->line('txt_Search')." : "; 
						?>
						<input type="text" id="searchTags<?php echo $arrVal['nodeId']; ?>" name="searchTags" onKeyUp="showMySpaceTags('<?php echo $arrVal['nodeId']; ?>','<?php echo $originatorUserId; ?>','<?php echo $_SESSION['userId']; ?>')" size="20"/>
						
						<div id="showMan<?php echo $arrVal['nodeId']; ?>" style="height:120px;margin-left:50px; overflow:scroll; margin-bottom:10px; margin-top:20px; width:60%;">

						<?php if(count($workSpaceMembers_search_user)>0){ ?>
			
						<input type="checkbox" name="checkAll" id="checkAll<?php echo $arrVal['nodeId']; ?>" onclick="checkAllFunction('<?php echo $arrVal['nodeId']; ?>');" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';} ?> />
			
						<?php echo $this->lang->line('txt_All');?><br />
			
						<?php } ?>
			
						<?php
			
							$i=1;			
			
							foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
							{
								 if (in_array($workPlaceMemberData['userId'],$postSharedMembers))
								 {
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
					if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] && $showGuestUser){						
				
				?>

<input type="checkbox" name="recipients<?php echo $arrVal['nodeId']; ?>[]" id="<?php echo 'recipients_'.$i ; ?>" <?php if (in_array($workPlaceMemberData['userId'],$postSharedMembers)) { echo 'checked="checked"';}?> value="<?php echo $workPlaceMemberData['userId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?>class="clsCheck<?php echo $arrVal['nodeId']; ?>" <?php } ?> onclick="getRecepientName(this,'<?php echo $arrVal['nodeId']; ?>')" >

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}
				}
				
				foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
				{
					 if (!in_array($workPlaceMemberData['userId'],$postSharedMembers))
					{
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
					if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] && $showGuestUser){						
				
				?>

<input type="checkbox" name="recipients<?php echo $arrVal['nodeId']; ?>[]" id="<?php echo 'recipients_'.$i ; ?>" <?php if (in_array($workPlaceMemberData['userId'],$postSharedMembers)) { echo 'checked="checked"';}?> value="<?php echo $workPlaceMemberData['userId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?>class="clsCheck<?php echo $arrVal['nodeId']; ?>" <?php } ?> onclick="getRecepientName(this,'<?php echo $arrVal['nodeId']; ?>')" >

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}
				}

				?>
				

          </div>
		  			<?php if ($originatorUserId==$_SESSION['userId']) { 
					?>
		  			 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Ok');?>" onclick="addPostShareUsers('<?php echo $arrVal['nodeId']; ?>')" style="margin-left:50px; float:left;">
					 <input type="reset" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;" >			
					<?php } ?>	
						</div>
						
					<?php	
					}
				 ?>
					
				 </div>
				 <!--Myspace select recepient code end-->
  <!--Post share view end here-->
  
  <!--get post change details start here-->
<div id="postData<?php echo $arrVal['nodeId']; ?>" style="margin-top:1%;">
  <div class="postChangeHeading">
		<?php	
			$postChangeDetails = $this->timeline_db_manager->get_post_change_details($arrVal['nodeId']);
			if(!empty($postChangeDetails))
			{
				$postChangeUserProfiledetail = $this->profile_manager->getUserDetailsByUserId($postChangeDetails['change_user_id']);
				//$postChangeUserName = strip_tags($postChangeUserProfiledetail['firstName'].' '.$postChangeUserProfiledetail['lastName'],'<b><em><span><img>');
				$postChangeUserName = strip_tags($postChangeUserProfiledetail['userTagName'],'<b><em><span><img>');
				if($postChangeDetails['change_type']==2)
				{
					echo str_replace("{username}",$postChangeUserName,$this->lang->line('txt_new_comment_added'));
				}
				else if($postChangeDetails['change_type']==3)
				{
					echo str_replace("{username}",$postChangeUserName,$this->lang->line('txt_tag_added'));
				}
				else if($postChangeDetails['change_type']==4)
				{
					echo str_replace("{username}",$postChangeUserName,$this->lang->line('txt_link_added'));
				}
			}
			else
			{
				//$newPostUserName = strip_tags($TimelineProfiledetail['firstName'].' '.$TimelineProfiledetail['lastName'],'<b><em><span><img>');
				$newPostUserName = strip_tags($TimelineProfiledetail['userTagName'],'<b><em><span><img>');
				echo str_replace("{username}",$newPostUserName,$this->lang->line('txt_new_post_added'));
			}
			?>
	</div>
	<!--get post change details end here-->
  <div class="clr"></div>
  <!--Add profile pic start-->
  <div>
  <div style="margin-top:10px;">
  <div style="float:left;">
							<?php
								if ($TimelineProfiledetail['photo']!='noimage.jpg')
								{
							?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfiledetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $TimelineProfiledetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px;">
		<p style="margin:0; font-size:12px;"><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"><b><?php echo strip_tags($TimelineProfiledetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
		<p class="postTimeStamp" style="margin:2px 0 15px;"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['TimelineCreatedDate'],$this->config->item('date_format')); ?></p>
	</div>
	
	<!--Showing all posts section space name start-->
	<div style="width:40%; float:right;">
	<div class="allPostsSpaceName" style="float:right;">
	<?php 
	/*if($this->uri->segment(8)=='all')
	{*/
	?>
	
	 <span style="font-size:0.8em;font-style:italic;" class="spaceNameAllPost"><?php if($arrVal['commentWorkSpaceId']==0 && $arrVal['commentWorkSpaceType']==1){echo $this->lang->line('txt_My_Workspace');}else if($arrVal['commentWorkSpaceId']==0 && $arrVal['commentWorkSpaceType']==0){ echo $this->lang->line('txt_Public');}else{echo $workSpaceDetails1['workSpaceName'];}?></span>
	
	<?php /*}*/ ?>
	<!--Add bookmark button here-->
	<?php /*?><div class="bookmarkBtn<?php echo $arrVal['nodeId']; ?> bookmarkBtn">
	<?php if(in_array($arrVal['nodeId'],$bookmarkedPosts)){ ?>
	
		<a class="bookmarkedMob marked<?php echo $arrVal['nodeId']; ?>" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','unbookmark')"><?php //echo $this->lang->line('txt_object_following'); ?><img style="cursor:pointer;height:30px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png"></a>
	
	<?php }else{ ?>
	
		<a class="bookmarkMob" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','bookmark')"><?php //echo $this->lang->line('txt_object_follow'); ?><img style="cursor:pointer;height:30px;border:0px;" src="<?php echo base_url();?>images/bookmark.png"></a>
	
	<?php } ?>
	</div><?php */?>
	
	<!--Bookmark code end-->
	</div>
	</div>
	
	<!--Showing all posts section space name end-->
	
	</div>
	<div>
			
	</div>
	</div>
	 <div class="clr"></div>
  <!--Add profile pic end-->
  <!--Timeline post content start-->
  <?php $viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2); ?>
    <div class="<?php echo $nodeBgColor."1"; ?> handCursor" style="border-bottom: 1px solid #ccc; padding: 10px 0;" >
      <div>
        <div>
          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?> TimelineLeafContents" style="word-wrap:break-word; overflow:hidden;" ><?php echo stripslashes($arrVal['contents']); ?> </div>
        </div>
        <div class="clr"></div>
        </div>
    </div>
  <!--Timeline post content end here-->
  
  <!--Tag section start here-->
  <div style="border-bottom: 1px solid #ccc;">
  	<div style="height:30px; padding-bottom:0px; margin-top:15px; width:87%; float:left;">
        <ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:left; display:block;" class="content-list ulNodesHeader">
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
		  
		  <!--Talk start here-->
		  
		  <!--Talk end here-->
		  
		  <!--Comment icon start here-->
		  <?php /* onclick="showCommentEditor('<?php echo $arrVal['nodeId']; ?>')"; */ 
		  					$leafdataContent=strip_tags($arrVal['contents']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['contents'], ENT_QUOTES);
		  
		  ?>
		   <?php /*?> <li style="cursor:pointer;">
			<?php echo '<img title="Add Comment" onClick="window.open(\''.base_url() .'post/get_timeline_comment/' .$arrVal['nodeId'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\')"  id="divCommentButton'.$arrVal['nodeId'].'" src="'.base_url().'images/subtask-icon_new.png">';
			?>
			</li><?php */?>
		  
		  <!--Comment icon end here-->
		  
		   <!--shared tab start here-->
		   <?php
			if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
			{
		   ?>
		 		 <li>
				<a href="javascript:void(0);" style="" id="tab2m<?php echo $arrVal['nodeId']; ?>" onclick="showPopWin('<?php echo base_url();?>post/share/0/type/1/0/1/<?php echo $arrVal['nodeId']; ?>', 800, 450, null, '');"><img src="<?php  echo base_url().'images/tab-icon/post_share.png'; ?>" title="share" style="height:12px;  margin-top: 4px;" /></a>
				</li>
				
			<?php
		 } ?> 
		  
		  <!--Shared tab end here-->
		  
        </ul>
      </div>
	  
	  <div>
	  <!--Add star button here-->
	<div class="postIconsRight">
	<div class="bookmarkBtn<?php echo $arrVal['nodeId']; ?> bookmarkBtn">
	<?php if(in_array($arrVal['nodeId'],$bookmarkedPosts)){ ?>
	<?php /*onmouseover="changeBookmarkStatusOver('<?php echo $arrVal['nodeId']; ?>')" onmouseout="changeBookmarkStatusOut('<?php echo $arrVal['nodeId']; ?>')"*/ ?>
	
		<a class="bookmarked marked<?php echo $arrVal['nodeId']; ?>" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','unbookmark')"><?php //echo $this->lang->line('txt_object_following'); ?><img style="cursor:pointer;height:20px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png"></a>
	
	<?php }else{ ?>
	
		<a class="bookmark" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','bookmark')"><?php //echo $this->lang->line('txt_object_follow'); ?><img style="cursor:pointer;height:20px;border:0px;" src="<?php echo base_url();?>images/bookmark.png"></a>
	
	<?php } ?>
	</div>
	</div>
	<!--Star button code end-->
	  </div>
	  <div class="clr"></div>
	  
	  </div>
	  
  <!--Tag section end here-->
   <div class="clr"></div>
  <!--Comment section start here-->
    <div class="discussionComments" style="width:100%;background-color:#FFFFFF;  ">
      <div id="<?php echo $position++;?>" style=" width:100%; padding-left:0px;"  class="<?php echo $nodeBgColor."1";?> handCursor">
       
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
        <div id="commentRefreshDiv<?php echo $arrVal['nodeId']; ?>">
          <?php

			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
			
			$rowColor3='chatBgColor1';
			$rowColor4='rowColor4';	
			$j = 1;
			
			if($arrparent['successors'])
			{
				$totalTimelineCommentNodes = array();
			
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				if(count($sArray)>3)
				{
				?>
				<div style="margin-top:12px; font-size:12px;">
				<a class="showAllLink<?php echo $arrVal['nodeId']; ?>" onclick="showAllTimelineComments('<?php  echo $arrVal['nodeId']; ?>');"><?php echo $this->lang->line('view_more_comment_txt'); ?></a>
				</div>
				<?php
				}
				?>
				
				<!--Condition for more than 3 comments-->
				<div id="moreComments<?php echo $arrVal['nodeId'];?>" style="display:none;">
				<?php
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				$totalCommentsCount=count($sArray);
				//$sArray=array_reverse($sArray);
				$counter=0;
				while($counter < count($sArray))
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
					$totalTimelineCommentNodes[] = $arrDiscussions['nodeId'];
					$TimelineProfileCommentdetail = $this->profile_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$totalNodes[] = $arrDiscussions['nodeId'];	 
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	 		
					?>
					<?php //if($counter>2)
					if($counter<($totalCommentsCount-3)){
					 ?>
          <div id="<?php echo $position++;?>" style="width:94%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor" >
		  	
			 <!--Add comment profile pic start-->
  <div style="width:100%;">
  <div>
  <div style="float:left;">
							<?php
								if ($TimelineProfileCommentdetail['photo']!='noimage.jpg')
								{
							?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px; font-size:12px;">
		<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
		<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
	</div>
	</div>
	<div>
			
	</div>
	</div>
	
  	<!--Add comment profile pic end-->
		  	
		  <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>"  style="font-size:0.8em;text-align:justify; width:80%; overflow:hidden; margin-top:12px;">
              <?php  echo $arrDiscussions['contents'];?>
            </div>
            <!-- display none -->
            <div class="clr"></div>
           
			</div>
		   	<?php
			}
			?>
          <div style="clear:both;"></div>
          <?php
					$counter++;
					$j++;
				}
				?>
				</div>			
				 <!--Condition for more than 3 comments end here-->
				
				<?php
				
			
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				//$sArray=array_reverse($sArray);
				$totalCommentsCount=count($sArray);
				$counter=0;
				while($counter < count($sArray))
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
					$TimelineProfileCommentdetail = $this->profile_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$totalNodes[] = $arrDiscussions['nodeId'];	 
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	 		
					?>
			<?php //if($counter<3)
			if($counter>($totalCommentsCount-4)){
			 ?>		
          <div id="<?php echo $position++;?>" style="width:94%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor" >
		  	
			 <!--Add comment profile pic start-->
  <div style="width:100%;">
  <div>
  <div style="float:left;">
							<?php
								if ($TimelineProfileCommentdetail['photo']!='noimage.jpg')
								{
							?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px; font-size:12px;">
		<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
		<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
	</div>
	</div>
	<div>
			
	</div>
	</div>
	
  	<!--Add comment profile pic end-->
		  	
		  <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>"  style="font-size:0.8em;text-align:justify; width:80%; overflow:hidden; margin-top:12px;">
              <?php  echo $arrDiscussions['contents'];?>
            </div>
            <!-- display none -->
            <div class="clr"></div>
            
			
		 
           </div>
		   <?php } ?>
          <div style="clear:both;"></div>
          <?php
					$counter++;
					$j++;
				}
				
		}		
		?>
          <?php /*?><div  class="<?php echo $nodeBgColor."1"; ?>" style="float:left;height:20px; padding-left:40px;padding-bottom:10px;margin-top:-3px ; width:100%;">
            <?php if($timmer){?>
            <img src="<?php echo base_url(); ?>images/subtask-icon_new.png" id="divCommentButton<?php echo $arrVal['nodeId']; ?>"  onclick="showReply1(<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>; replay_target=0;" title="Add Comment" style="display:none;" />
            <?php }?>
          </div><?php */?>
          <div  id="reply<?php echo $arrVal['nodeId'];?>" style="float:left; display:none;padding:15px 40px 0px; width:85%;">
            <div id="txt_reply<?php echo $arrVal['nodeId'];?>"></div>
          </div>
        </div>
      </div>
    </div>
	</div>
  <!--Comment section end here-->  
  
  <!--Textarea start here-->
  	<div class="clr"></div>
	<?php /*?><div class="CommentTextBox<?php echo $arrVal['nodeId']; ?>" style="display:none;">
		<textarea name="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" id="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" ></textarea>
		<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="insertTimelineComment('<?php echo $arrVal['nodeId']; ?>');" >
	</div><?php */?>
  <!--Textarea end here-->
  
   <!--Textarea start here-->
  	<div class="clr"></div>
	<div class="CommentTextBox<?php echo $arrVal['nodeId']; ?> commentEditorWrapper" style="display:block;">
		<div>
		<textarea class="postCommentTextBox" name="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" id="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" onclick="openCommentEditor('<?php echo $arrVal['nodeId']; ?>')" placeholder="Your comment here..."></textarea>
		</div>
		<div style="margin-top:8px;">
		<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="insertPostComment('<?php echo $arrVal['nodeId']; ?>');" style="float:left;">
		<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;"  onclick="cancelPostEditor('<?php echo $arrVal['nodeId']; ?>');">
		<div class="clr"></div>
		<div id="commentLoader<?php echo $arrVal['nodeId']; ?>"></div>
		</div>
	</div>
  <!--Textarea end here-->
  
</div>

  <?php
		}
		$i++;
		?>
<script>
//chnage_textarea_to_editor('replyTimelineComment<?php //echo $arrVal['nodeId']; ?>','comment');
</script>
</div>
<input name="reply" type="hidden" id="reply" value="1">
<input name="editStatus" type="hidden" id="editStatus" value="0">
<input name="editorname1" id="editorname1" type="hidden"  value="replyTimelineComment<?php echo $arrVal['nodeId']; ?>">
<input name="nodeId" type="hidden" id="nodeId" value="<?php echo $arrVal['nodeId']; ?>">
<input name="vks" type="hidden" id="vks" value="1">
<input name="chat_view" type="hidden" id="chat_view" value="1">
<input name="treeId" type="hidden" id="treeId" value="<?php echo '0'; ?>">
<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
<input type="hidden" id="totalTimelineCommentNodes<?php echo $arrVal['nodeId']; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">
</form>
<?php		
		}//post search by user end
		}
	}
else
{
	if($this->uri->segment('8')=='bookmark')
	{
		?><div style="font-style:italic; color:#999999;"><?php echo $this->lang->line('txt_no_bookmark'); ?></div><?php
	}
	else
	{
		?><div style="font-style:italic; color:#999999;"><?php echo $this->lang->line('txt_no_post'); ?></div><?php
	}
} 
?>

</div>
<?php 
$totalNodes[] = 0;
?>
<form name="totalPostNodes" id="totalPostNodes" method="post">
<input type="hidden" id="totalNodes" name="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<input type="hidden" id="totalTreeLinkedNodes" name="totalTreeLinkedNodes" value="<?php echo htmlspecialchars(serialize($treeLinkedArray)); ?>">
<input type="hidden" id="totalFileLinkedNodes" name="totalFileLinkedNodes" value="<?php echo htmlspecialchars(serialize($fileLinkedArray)); ?>">
<input type="hidden" id="totalUrlLinkedNodes" name="totalUrlLinkedNodes" value="<?php echo htmlspecialchars(serialize($urlLinkedArray)); ?>">
<input type="hidden" id="totalTagNodes" name="totalTagNodes" value="<?php echo htmlspecialchars(serialize($taggedNodesArray)); ?>">
</form>
