<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<div>
<?php 
//echo '<pre>';
//print_r($bookmarkedPosts); 
//exit;
?>
</div>
<div class="talkformchat">

  <?php
  
  	$totalNodes = array();
	
	$rowColor1='row';
	$rowColor2='row';	
	$i = 1;	
	//echo '<pre>';
	//print_r($arrTimeline);
	//exit;
	
	//echo "<li>count= " .count($arrTimeline);print_r($arrTimeline);exit;
	if(count($arrTimeline) > 0)
	{			
			 
		foreach($arrTimeline as $keyVal=>$arrVal)
		{
			//echo "<li>";
			//print_r($arrVal);
			//echo "<hr>";
			//post search by user start
			//echo "<li>userpostsearch= " .$userPostSearch;
			//echo "<li>userId= " .$arrVal['userId'];

			//if($userPostSearch == '' || $userPostSearch==$arrVal['userId'])
			if (1)
			{
			//echo "here";
			$postLinkedTreeCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'tree');
			$treeLinkedArray[$arrVal['nodeId']]=$postLinkedTreeCount;
			$postLinkedFileCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'file');
			$fileLinkedArray[$arrVal['nodeId']]=$postLinkedFileCount;
			$postLinkedUrlCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'url');
			$urlLinkedArray[$arrVal['nodeId']]=$postLinkedUrlCount;
			$postTaggedCount = $this->identity_db_manager->getTaggedPostByNodeId($arrVal['nodeId']);
			$taggedNodesArray[$arrVal['nodeId']]=$postTaggedCount;

			/*Added by Dashrath- get folder linked count*/
			$postLinkedFolderCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'folder');
			$folderLinkedArray[$arrVal['nodeId']]=$postLinkedFolderCount;
			/*Dashrath- code end*/
			
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
  <!--Added by Dashrath- timelinePostContentsNewUi new class add for new ui changes -->
  <div id="timelinePostContents" class="timelinePostContentsNewUi" >
  
  <!--Post share view start here-->
 					 <?php
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
						?>
  					<?php /*?>	<div>
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
						<input type="text" id="searchTags<?php echo $arrVal['nodeId']; ?>" name="searchTags" onKeyUp="showMySpaceTags('<?php echo $arrVal['nodeId']; ?>','<?php echo $originatorUserId; ?>','<?php echo $_SESSION['userId']; ?>')" size="50"/>
						
						
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

 <!-- Changed by Dashrath- change margin-top 1% to 0% for new ui -->
<div id="postData<?php echo $arrVal['nodeId']; ?>" style="margin-top:0%;">
<div class="postHeadingBox">
  <div class="postChangeHeading postChangeHeadingNewUi">
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
	<!--Comment notification start here-->
	<div class="newCommentNotification newComment<?php echo $arrVal['nodeId']; ?>">
	</div>
	<div class="clr"></div>
</div>
	<!--Comment notification end here-->

  
  <!--Add profile pic start-->
  <div class="postTopUserImg">
  <div class="postLeftBox">
  <div style="float:left;">
							<?php
								if ($TimelineProfiledetail['photo']!='noimage.jpg')
								{
							?>
									<img class="rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfiledetail['photo'];?>" border="0"  width="35" height="35" id="imgName" style="margin-top:0px;"> 
                          	<?php
								}
								else
								{
							?>
									<img class="rounded_profile_pic" src="<?php echo base_url();?>images/<?php echo $TimelineProfiledetail['photo'];?>" border="0"  width="35" height="35" id="imgName" style="margin-top:0px;"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px; ">
		<p style="margin:0; font-size:0.8em;"><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"><b><?php echo strip_tags($TimelineProfiledetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
		<p class="postTimeStamp" style="margin:2px 0 15px;"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['TimelineCreatedDate'],$this->config->item('date_format')); ?></p>
	</div>
	</div>
	<!--Showing all posts section space name start-->
	<div class="postRightBox">
	<div class="allPostsSpaceName">
	<?php 
	/*if($this->uri->segment(8)=='all')
	{*/
	?>
	
	<div style="font-size:0.8em;font-style:italic; <?php /*?>margin-left:60%;<?php */?>" ><span class="spaceNameAllPost"><?php if($arrVal['commentWorkSpaceId']==0 && $arrVal['commentWorkSpaceType']==1){echo $this->lang->line('txt_My_Workspace');}else if($arrVal['commentWorkSpaceId']==0 && $arrVal['commentWorkSpaceType']==0){ echo $this->lang->line('txt_Public');}else{echo $workSpaceDetails1['workSpaceName'];}?></span></div>
	
	<?php /*}*/ ?>
	
	</div>
	</div>
	
	<!--Showing all posts section space name end-->
	<div>
			
	</div>
	</div>
	 <div class="clr"></div>
  <!--Add profile pic end-->
  <!--Timeline post content start-->
  <?php $viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2); ?>
  	<!-- Changed by Dashrath- remove inline css -->
    <!-- <div class="<?php echo $nodeBgColor."1"; ?> handCursor" style="border-bottom: 1px solid #ccc; padding: 10px 0;" > -->
    <div class="<?php echo $nodeBgColor."1"; ?> handCursor">
      <div>
        <div>
          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?> TimelineLeafContents" style="word-wrap:break-word; overflow:hidden;" >
          	 	<!-- Added by Dashrath : check delete leaf -->
		        <?php 
		        if($arrVal['leafStatus'] !='deleted'){
		        	/*Commented old code and add new code below for audio icon show when content is audio*/
		           	// echo stripslashes($arrVal['contents']);

		           	/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
					$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrVal['contents']);
					$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrVal['contents']);
					
					if($audioContainsMatch1 && $audioContainsMatch2)
					{
					?>	
						<span class="cursor" onclick="audioContentHideShow('<?php echo $arrVal['nodeId'];?>')">
							<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio" style="width: 50px !important; height: 50px !important;">
						</span>
						<span id='audio_contents<?php echo $arrVal['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrVal['contents']);?></span>
					<?php
					}
					else
					{
						echo stripslashes($arrVal['contents']);
					}
					/*Dashrath- code end*/ 
		        }else{ ?>
		          <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
		        <?php 
		    	} ?>
	    		<!-- Dashrath : code end -->
          	 
          </div>
        </div>
        <div class="clr"></div>
        </div>
    </div>
  <!--Timeline post content end here-->
  
  <!--Tag section start here-->
 <!--  <div style="border-bottom: 1px solid #ccc;">
  	<div style="height:30px; padding-bottom:0px; margin-top:15px;" class="postIcons">
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
		  
		  <?php //shared tab start here ?>
		   <?php
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
						?>
		 <li>
				<a href="javascript:void(0);" style="" id="tab2m<?php echo $arrVal['nodeId']; ?>" onclick="showPopWin('<?php echo base_url();?>post/share/0/type/1/0/1/<?php echo $arrVal['nodeId']; ?>', 710, 600, null, '');"><img src="<?php  echo base_url().'images/tab-icon/post_share.png'; ?>" title="share" style="height:12px;  margin-top: 4px;" /></a>
		 </li>	 
		 <?php
		 } ?> 
		  
		  <?php //Shared tab end here ?>
		  
		 
		  
		  <?php //Comment icon start here ?>
		  <?php 
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
		   
		  
		  <?php //Comment icon end here ?>
		  
        </ul>
      </div>
	  
	  <div>
	  <?php //Add star button here ?>
	<div class="postIconsRight">
	<div class="bookmarkBtn<?php echo $arrVal['nodeId']; ?> bookmarkBtn">
	<?php if(in_array($arrVal['nodeId'],$bookmarkedPosts)){ ?>
	
	
		<a class="bookmarked marked<?php echo $arrVal['nodeId']; ?>" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','unbookmark')"><?php //echo $this->lang->line('txt_object_following'); ?><img style="cursor:pointer;height:23px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png"></a>
	
	<?php }else{ ?>
	
		<a class="bookmark" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','bookmark')"><?php //echo $this->lang->line('txt_object_follow'); ?><img style="cursor:pointer;height:23px;border:0px;" src="<?php echo base_url();?>images/bookmark.png"></a>
	
	<?php } ?>
	</div>
	</div>
	<?php //Star button code end ?>
	  </div>
	  <div class="clr"></div>
	  </div> -->
	  
  <!--Tag section end here-->

  <!-- Added by Dashrath- add post footer for tag section -->
  <div class="commonSeedFooter">
  		<!-- footer left content start -->
		<div class="commonSeedFooterLeft">
			<span>
			  	<div class="commentButtonPostNewUi" id="commentButtonPost<?php echo $arrVal['nodeId']; ?>" style="display: block;">
					<img src="<?php echo base_url(); ?>images/subtask-icon_new.png" onclick="openCommentEditor('<?php echo $arrVal['nodeId']; ?>')" title="Add Comment" />
				</div>
			</span>
			<span>
				&nbsp;
			</span>
		</div>
		<!-- footer left content end -->

		<!-- footer right content start -->
		<div class="commonSeedFooterRight">
			<!--tag link content start-->
			<span class="commonSeedLeafSpanRight">
				<ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:left; display:block; margin: 0 0 0 0;" class="content-list ulNodesHeader">
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

					/*Added by Dashrath- used for display linked folder count*/
					$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($arrVal['nodeId'], 2);
					/*Dashrath- code end*/

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

          			<li class="tagLinkTalkSeedLeafIcon">
          				<a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo $tag_container; ?>"  ><strong><?php echo $total; ?></strong>
          				</a>
          			</li>

          			<?php				
					/*Changed by Dashrath- add $docTrees10 for total*/		
					$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);
				
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
						
							$appliedLinks .=$this->lang->line('txt_Files').': ';	
							foreach($docTrees7 as $key=>$linkData)
						    {
								 
								$appliedLinks .=$this->lang->line('txt_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							    {
							         
									if($linkData['docName']=='')
									{
									    $appliedLinks.=$this->lang->line('txt_Files')."_v".$linkData['version'].", ";
									}
									else
									{
										/*Changed by Dashrath- Comment old code and add new below after changes */
									 	//$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 	$appliedLinks.=$linkData['docName'].", ";
									}
								}
						
							}
							$appliedLinks=substr($appliedLinks, 0, -2)."
							"; 
						}

						/*Added by Dashrath- used for display linked folder name*/
						if(count($docTrees10)>0)
						{
							$appliedLinks .=$this->lang->line('txt_Folders').': ';	
							foreach($docTrees10 as $key=>$linkData)
						    {
								if($linkData['folderName']!='')
								{
								  
								 	$appliedLinks.=$linkData['folderName'].", ";
								}
							}

							$appliedLinks=substr($appliedLinks, 0, -2)."
							"; 
						}
						/*Dashrath- code end*/	
							
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
          			<li  class="tagLinkTalkSeedLeafIcon">
          				<a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong>
          				</a>
          			</li>
		  
		  			<!--shared tab start here-->
					   <?php
					   /*
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
					?>
					 	<li class="tagLinkTalkSeedLeafIcon">
							<a href="javascript:void(0);" style="" id="tab2m<?php echo $arrVal['nodeId']; ?>" onclick="showPopWin('<?php echo base_url();?>post/share/0/type/1/0/1/<?php echo $arrVal['nodeId']; ?>', 710, 600, null, '');"><img src="<?php  echo base_url().'images/tab-icon/post_share.png'; ?>" title="share" style="height:12px;  margin-top: 4px;" /></a>
					 	</li>	 
		 			<?php
		 			} */?> 
		  
		  			<!--Shared tab end here-->
		  
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
				   <?php /*?> <li style="cursor:pointer;"><img title="Add Comment" onClick="CommentBoxOpen('<?php echo $arrVal['nodeId'] ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','<?php echo $leafhtmlContent; ?>')" id="divCommentButton<?php echo $arrVal['nodeId']; ?>" src="<?php echo base_url(); ?>images/subtask-icon_new.png"></li><?php */?>
				  
				  <!--Comment icon end here-->
		  
        		</ul>
			</span>
			<!--tag link content end-->

			<!--bookmark content start-->
			<span class="commonSeedLeafSpanRight">
				<!--Add star button here-->
				<div class="postIconsRight" style="margin-top:0px;">
					<div class="bookmarkBtn<?php echo $arrVal['nodeId']; ?> bookmarkBtn">
					<?php if(in_array($arrVal['nodeId'],$bookmarkedPosts)){ ?>
					<?php /*onmouseover="changeBookmarkStatusOver('<?php echo $arrVal['nodeId']; ?>')" onmouseout="changeBookmarkStatusOut('<?php echo $arrVal['nodeId']; ?>')"*/ ?>
					
						<a class="bookmarked marked<?php echo $arrVal['nodeId']; ?>" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','unbookmark')" style="padding: 0% !important;"><?php //echo $this->lang->line('txt_object_following'); ?>

							<!--Changed by Dashrath- height changed 23 px to 18 px for new ui-->
							<img style="cursor:pointer;height:18px;border:0px;"  src="<?php echo base_url();?>images/bookmarked.png">
						</a>
					
					<?php }else{ ?>
					
						<a class="bookmark" onclick="add_bookmark('<?php echo $arrVal['nodeId']; ?>','bookmark')" style="padding: 0% !important;"><?php //echo $this->lang->line('txt_object_follow'); ?>

							<!--Changed by Dashrath- height changed 23 px to 18 px for new ui-->
							<img style="cursor:pointer;height:18px;border:0px;" src="<?php echo base_url();?>images/bookmark.png">
						</a>
					
					<?php } ?>
					</div>
				</div>
				<!--Star button code end-->
			</span>
			<!-- bookmark content end-->

			<!-- delete button start-->
      		<span class="commonSeedLeafSpanRight" id="deleteLeafSpan<?php echo $arrVal['nodeId'];?>">
				<?php 
				if(($arrVal['leafStatus'] != 'deleted') && ($arrVal['userId'] == $_SESSION['userId']))
				{ 
				?>
					
					<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrVal['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'post')" title="<?php echo "Delete Content"; ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo "Delete Content"; ?>" border="0">
					</a>
					
				<?php 
				} 
				?>
			</span>
			<span class="commonSeedLeafSpanRight" id="updatePostSeenStatusSpan<?php echo $arrVal['nodeId'];?>">
				<?php 
				if(($arrVal['seen_status'] == 0))
				{ 
				?>
					
					<a href="javascript:void(0)" onClick="updatePostSeenStatus('<?php echo $arrVal['leafId']; ?>','<?php echo $_SESSION['userId']; ?>', 1)" title="<?php echo 'Park'; ?>" border="0" ><img width="15" height="15" src="<?php echo  base_url(); ?>images/p_letter.png" alt="<?php echo 'Park'; ?>" title="<?php echo 'Park'; ?>">
					</a>
					
				<?php 
				} 
				else{
					?>
					
					<a href="javascript:void(0)" onClick="updatePostSeenStatus('<?php echo $arrVal['leafId']; ?>','<?php echo $_SESSION['userId']; ?>', 0)" title="<?php echo 'Park'; ?>" border="0" ><img width="15" height="15" src="<?php echo  base_url(); ?>images/u_letter.png" alt="<?php echo 'Park'; ?>" title="<?php echo 'Park'; ?>">
					</a>
					
				<?php 					
				}
				?>
			</span>
			<!-- delete button end-->
			<!-- Forward a post start -->
			<?php if($arrVal['leafStatus']=='publish'){?>
				<span class="commonSeedLeafSpanRight" id="draftForward<?php echo $arrVal['nodeId'];?>"><a href="javascript:void(0)" onclick="forwardPost('<?php echo $arrVal['nodeId'];?>');">Forward</a></span>
			<?php } ?>
			<!-- Forward a post end -->
			<!-- Edit draft start -->
			<?php if($arrVal['leafStatus']=='draft'){?>
				<span class="commonSeedLeafSpanRight" id="draftEdit<?php echo $arrVal['nodeId'];?>"><a href="javascript:void(0)" onclick="editDraft('<?php echo $arrVal['post_type_id'];?>','<?php echo $arrVal['post_type_object_id'];?>','<?php echo $arrVal['nodeId'];?>');">Edit draft</a></span>
			<?php } ?>
			<!-- Edit draft end -->
			<!-- Delete draft start -->
			<?php if($arrVal['leafStatus']=='draft'){?>
				<span class="commonSeedLeafSpanRight" id="draftDelete<?php echo $arrVal['nodeId'];?>"><a href="javascript:void(0)" onclick="deleteDraft('<?php echo $arrVal['post_type_id'];?>','<?php echo $arrVal['post_type_object_id'];?>','<?php echo $arrVal['nodeId'];?>');">Discard draft</a></span>
			<?php } ?>
			<!-- Delete draft end -->
		</div>
		<!-- footer right content end -->
  </div>
  <!-- end post footer for tag section -->

   <div class="clr"></div>
   <hr class="hrNewUi" />
  <!--Textarea start here-->
  	<!-- <div class="clr"></div>

	<div id="CommentTextBox<?php echo $arrVal['nodeId']; ?>" class="CommentTextBox<?php echo $arrVal['nodeId']; ?> commentEditorWrapper" style="display:none;">
		<div>
		<textarea class="postCommentTextBox" name="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" id="replyTimelineComment<?php echo $arrVal['nodeId']; ?>"></textarea>
		</div>
		<div style="margin-top:8px;">
		<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="insertPostComment('<?php echo $arrVal['nodeId']; ?>');" style="float:left;">
		<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;"  onclick="cancelPostEditor('<?php echo $arrVal['nodeId']; ?>');">
		
		<div class="clr"></div>
		<div id="commentLoader<?php echo $arrVal['nodeId']; ?>"></div>
		</div>
	</div> -->
  <!--Textarea end here-->
  <div class="clr"></div>
  <!--Comment section start here-->
    <div class="discussionComments" style="width:100%;background-color:#FFFFFF;">

      <!-- Changed by Dashrath- change padding-left:0px; to padding:0px; in inline css for new ui-->
      <!--<div id="<?php echo $position++;?>" style=" width:100%; padding:0px;"  class="<?php echo $nodeBgColor."1";?> handCursor">-->
	  <div id="comment<?php echo $arrVal['nodeId'];?>" style=" width:100%; padding:0px;"  class="<?php echo $nodeBgColor."1";?> handCursor">
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
		
		<?php
		$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
			if($arrparent['successors'])
			{
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				
				if(count($sArray)>3)
				{
				?>
				<div style="margin-top:12px; font-size:12px; cursor:pointer">
				<a class="showAllLink<?php echo $arrVal['nodeId']; ?>" onclick="showAllTimelineComments('<?php  echo $arrVal['nodeId']; ?>');"><?php echo $this->lang->line('view_more_comment_txt'); ?></a>
				</div>
				<?php
				}
			}
		?>
        <div id="commentRefreshDiv<?php echo $arrVal['nodeId']; ?>">
          <?php
			
			$rowColor3='chatBgColor1';
			$rowColor4='rowColor4';	
			$j = 1;
			
			if($arrparent['successors'])
			{
				?>
				<!--Condition for more than 3 comments-->
				<div id="moreComments<?php echo $arrVal['nodeId'];?>" style="display:none;">
				<?php
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				//$sArray=array_reverse($sArray);
				$totalCommentsCount=count($sArray);
				// $counter=3;
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

					//if($counter<3)
					//if($counter>2)
					 if($counter<($totalCommentsCount-3))
					 { ?>
					 	<!--Changed by Dashrath- change width 94% to 100% in inline css-->		
						<!--<div id="<?php echo $position++;?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor">-->
						<div id="comment<?php echo $arrDiscussions['nodeId'];?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor">
							<!--Add comment profile pic start-->
							<div style="width:30%;" class="commentUserName">
								<div style="float:left;">
									<?php
										if ($TimelineProfileCommentdetail['photo']!='noimage.jpg')
										{
									?>
											<img class="rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
									<?php
										}
										else
										{
									?>
											<img class="rounded_profile_pic" src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
									<?php
										}
									?>
								</div>
								<div style="float:left; margin-left:5px; font-size:0.8em;">
									<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
									<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
								</div>
							</div>
							<!--Added by Dashrath- clr div for image stretch issue-->
							<div class="clr"></div>
							<!--Add comment profile pic end-->

						<!--Changed by Dashrath- remove width:68% from div inline css for image stretch issue-->
						<div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>  commentUserNameContents"  style="font-size:0.8em;text-align:justify; overflow:hidden;" >
							<!-- Added by Dashrath : check delete leaf -->
							<span id="delete_content_hide_<?php echo $arrDiscussions['leafId'];?>" style="display: inline;">
						        <?php 
						        if($arrDiscussions['leafStatus'] !='deleted'){

						        	/*Commented old code and add new code below for audio icon show when content is audio*/
						            // echo $arrDiscussions['contents'];

						            /*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
									$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrDiscussions['contents']);
									$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrDiscussions['contents']);
									
									if($audioContainsMatch1 && $audioContainsMatch2)
									{
									?>	
										<span class="cursor" onclick="audioContentHideShow('<?php echo $arrDiscussions['nodeId'];?>')">
											<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
										</span>
										<span id='audio_contents<?php echo $arrDiscussions['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrDiscussions['contents']);?></span>
									<?php
									}
									else
									{
										echo stripslashes($arrDiscussions['contents']);
									}
									/*Dashrath- code end*/
						        }else{ ?>
						          <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
						        <?php 
						    	} ?>
					    	</span>
					    	<span id="delete_content_show_<?php echo $arrDiscussions['leafId'];?>" style="display: none;" class="clearedLeafContent">
					    		<?php echo $this->lang->line('txt_content_deleted'); ?>
					    	</span>
	    					<!-- Dashrath : code end -->						  
						</div>

						<!-- delete button start-->
			      		<span class="postCommentDelete" id="deleteLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
			      			<span id="deleteLeafIcon<?php echo $arrDiscussions['leafId'];?>">
								<?php 
								if(($arrDiscussions['leafStatus'] != 'deleted') && ($arrDiscussions['userId'] == $_SESSION['userId']))
								{
								?>
									
									<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrDiscussions['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'post_comment')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
									</a>
									
								<?php 
								} 
								?>
							</span>
						</span>
						<!-- delete button end-->

						<div class="clr"></div>
					</div>

					<?php } //if ends?>
			<div style="clear:both;"></div>
			<?php
				$counter++;
				$j++;
			} // while ends
			?>
				</div>			
				 <!--Condition for more than 3 comments end here-->
				 <?php
				$totalTimelineCommentNodes = array();

				// Latest 3 comments start
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
					<?php //if($counter<3)
					//if($counter>2)
					if($counter>($totalCommentsCount-4))
					{ ?>
						<!--Changed by Dashrath- change width 94% to 100% in inline css-->
          				<!--<div id="<?php echo $position++;?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor">-->
						<div id="comment<?php echo $arrDiscussions['nodeId'];?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?>">
							<!--Add comment profile pic start-->					
							<div style="width:30%;" class="commentUserName">
							<div style="float:left;">
								<?php
									if ($TimelineProfileCommentdetail['photo']!='noimage.jpg')
									{
								?>
										<img class="rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
								<?php
									}
									else
									{
								?>
										<img class="rounded_profile_pic" src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
								<?php
									}
								?>
								</div>
								<div style="float:left; margin-left:5px; font-size:0.8em;">
									<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
									<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
								</div>
							</div>
							<!--Added by Dashrath- clr div for image stretch issue-->
							<div class="clr"></div>
							<!--Add comment profile pic end-->

							<!--Changed by Dashrath- remove width:68% from div inline css for image stretch issue-->
							<div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?> commentUserNameContents"  style="font-size:0.8em;text-align:justify; overflow:hidden;" >

							<!-- Added by Dashrath : check delete leaf -->
							<span id="delete_content_hide_<?php echo $arrDiscussions['leafId'];?>" style="display: inline;">
								<?php 
								if($arrDiscussions['leafStatus'] !='deleted'){
									/*Commented old code and add new code below for audio icon show when content is audio*/
									// echo $arrDiscussions['contents'];

									/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
									$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrDiscussions['contents']);
									$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrDiscussions['contents']);
										
									if($audioContainsMatch1 && $audioContainsMatch2)
									{
									?>	
										<span class="cursor" onclick="audioContentHideShow('<?php echo $arrDiscussions['nodeId'];?>')">
											<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
										</span>
										<span id='audio_contents<?php echo $arrDiscussions['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrDiscussions['contents']);?></span>
									<?php
									}
									else
									{
										echo stripslashes($arrDiscussions['contents']);
									}
								}else{ ?>
									<span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
									<?php 
								} ?>
							</span>
							<span id="delete_content_show_<?php echo $arrDiscussions['leafId'];?>" style="display: none;" class="clearedLeafContent">
								<?php echo $this->lang->line('txt_content_deleted'); ?>
							</span>
							</div>
							<!-- Nested comment start-->
							<span class="postCommentDelete" id="nestedCommentLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
			      			<span id="nestedCommentLeafIcon<?php echo $arrDiscussions['leafId'];?>">
								<?php 
								if(($arrDiscussions['leafStatus'] != 'deleted') && ($arrDiscussions['userId'] == $_SESSION['userId']))
								{ 
								?>
									
									<a href="javascript:void(0)" onClick="openNestedCommentEditor('<?php echo $arrDiscussions['leafId']; ?>')" title="<?php echo $this->lang->line('txt_comment'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/subtask-icon_new.png" alt="<?php echo $this->lang->line("txt_comment"); ?>" title="<?php echo $this->lang->line("txt_comment"); ?>">
									</a>
									
								<?php 
								} 
								?>
							</span>
							</span>
							<!-- Nested comment end-->
							<!-- delete button start-->
							<span class="postCommentDelete" id="deleteLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
								<span id="deleteLeafIcon<?php echo $arrDiscussions['leafId'];?>">
									<?php 
									if(($arrDiscussions['leafStatus'] != 'deleted') && ($arrDiscussions['userId'] == $_SESSION['userId']))
									{ 
									?>
										
										<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrDiscussions['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'post_comment')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
										</a>
										
									<?php 
									} 
									?>
								</span>
							</span>
							<!-- delete button end-->
							<div class="clr"></div>
           				</div>
				<?php
					// Parv: Start nested comment here
					//$arrNestedComments	= $this->chat_db_manager->getPerentInfo($arrDiscussions['nodeId']);	
					//echo "<pre>nodes"; print_r($arrDiscussions);
					$sArray2=array();
					$sArray2=explode(',',$arrDiscussions['successors']);
					$totalCommentsCount2=count($sArray2);
					//echo "<pre>totalCommentsCount2= " .$totalCommentsCount2;
					?>
					<div id="nestedCommentsSection<?php echo $arrDiscussions['nodeId'];?>" class="nestedCommentsSection">
						<?php
						if($totalCommentsCount2>0 && $sArray2[0]!=0){
							$counter2=0;
							while($counter2 < count($sArray2)){
								$arrDiscussions2	= $this->chat_db_manager->getPerentInfo($sArray2[$counter2]);	
								$TimelineProfileCommentdetail2 = $this->profile_manager->getUserDetailsByUserId($arrDiscussions2['userId']);
								?>
								<div id="comment<?php echo $arrDiscussions2['nodeId'];?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?>">
									<!--Add comment profile pic start-->					
									<div style="width:30%;" class="commentUserName">
										<div style="float:left;">
											<?php
												if ($TimelineProfileCommentdetail2['photo']!='noimage.jpg')
												{
											?>
													<img class="rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail2['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
											<?php
												}
												else
												{
											?>
													<img class="rounded_profile_pic" src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail2['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
											<?php
												}
											?>
										</div>
										<div style="float:left; margin-left:5px; font-size:0.8em;">
											<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail2['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail2['userTagName'],'<b><em><span><img>'); ?></b></a></p>
											<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions2['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
										</div>
									</div>
									<!--Added by Dashrath- clr div for image stretch issue-->
									<div class="clr"></div>
									<!--Add comment profile pic end-->

									<!--Changed by Dashrath- remove width:68% from div inline css for image stretch issue-->
									<div id='leaf_contents<?php echo $arrDiscussions2['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?> commentUserNameContents"  style="font-size:0.8em;text-align:justify; overflow:hidden;" >
										<!-- Added by Dashrath : check delete leaf -->
										<span id="delete_content_hide_<?php echo $arrDiscussions2['leafId'];?>" style="display: inline;">
											<?php 
											if($arrDiscussions2['leafStatus'] !='deleted'){
												/*Commented old code and add new code below for audio icon show when content is audio*/
												// echo $arrDiscussions['contents'];

												/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
												$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrDiscussions2['contents']);
												$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrDiscussions2['contents']);
														
												if($audioContainsMatch1 && $audioContainsMatch2)
												{
												?>	
													<span class="cursor" onclick="audioContentHideShow('<?php echo $arrDiscussions2['nodeId'];?>')">
														<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
													</span>
													<span id='audio_contents<?php echo $arrDiscussions2['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrDiscussions2['contents']);?></span>
												<?php
												}
												else
												{
													echo stripslashes($arrDiscussions2['contents']);
												}
											}else{ ?>
												<span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
												<?php 
											} ?>
										</span>
										<span id="delete_content_show_<?php echo $arrDiscussions2['leafId'];?>" style="display: none;" class="clearedLeafContent">
											<?php echo $this->lang->line('txt_content_deleted'); ?>
										</span>
									</div>
										<!-- delete button start-->
									<div>
										<span class="postCommentDelete" id="deleteLeafSpan<?php echo $arrDiscussions2['nodeId'];?>">
											<span id="deleteLeafIcon<?php echo $arrDiscussions2['leafId'];?>">
												<?php 
												if(($arrDiscussions2['leafStatus'] != 'deleted') && ($arrDiscussions2['userId'] == $_SESSION['userId']))
												{ 
												?>
													
													<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrDiscussions2['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'post_comment')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
													</a>
													
												<?php 
												} 
												?>
											</span>
										</span>
										<!-- delete button end-->
									</div>
									<div class="clr"></div>
								</div>									
								<?php
								$counter2++;
							} // end while counter2
						} // end if
						?>
					</div> <!-- Nested comments section end -->
					<?php	
					}
				?>
          		<div class="clr"></div>
     
 <!-- Nested comment textarea start here-->
<div id="nestedCommentTextBox<?php echo $arrDiscussions['nodeId']; ?>" class="CommentTextBox<?php echo $arrDiscussions['nodeId']; ?> commentEditorWrapper" style="display:none;">
	<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
	<div class="handCursor">
	<textarea class="postCommentTextBox" name="replyTimelineComment<?php echo $arrDiscussions['nodeId']; ?>" id="replyTimelineComment<?php echo $arrDiscussions['nodeId']; ?>"></textarea>
	</div>
	<div style="margin-top:8px;">
	<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="insertPostComment('<?php echo $arrDiscussions['nodeId']; ?>','<?php echo $arrVal['nodeId']; ?>','1');" style="float:left;">
	<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;"  onclick="cancelPostEditor('<?php echo $arrDiscussions['nodeId']; ?>','1');">
	<input type="hidden" id="totalTimelineCommentNodes<?php echo $arrDiscussions['nodeId']; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">
	<div class="clr"></div>
	<div id="commentLoader<?php echo $arrDiscussions['nodeId']; ?>"></div>
	</div>
</div>
<!--Nested comment end here-->
          		<?php
					$counter++;
					$j++;
				}
				// Latest 3 comments end
				?>

	
				 <?php
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

     <!--Textarea start here-->
  	<div class="clr"></div>

	<div id="CommentTextBox<?php echo $arrVal['nodeId']; ?>" class="CommentTextBox<?php echo $arrVal['nodeId']; ?> commentEditorWrapper" style="display:none;">
		<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
		<div class="handCursor">
		<textarea class="postCommentTextBox" name="replyTimelineComment<?php echo $arrVal['nodeId']; ?>" id="replyTimelineComment<?php echo $arrVal['nodeId']; ?>"></textarea>
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
  <!--Comment section end here-->  
  <div class="clr"></div>
 
</div>


<!--Added by Dashrath- for space in two post -->
<div class="treeLeafRowStyle2"></div>


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
<input name="post_content<?php echo $arrVal['nodeId']; ?>" type="hidden" id="post_content<?php echo $arrVal['nodeId']; ?>" value="<?php echo stripslashes($arrVal['contents']); ?>">
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

<!--Added by Dashrath- folder linked count-->
<input type="hidden" id="totalFolderLinkedNodes" name="totalFolderLinkedNodes" value="<?php echo htmlspecialchars(serialize($folderLinkedArray)); ?>">
<!--Dashrath- code end-->
</form>