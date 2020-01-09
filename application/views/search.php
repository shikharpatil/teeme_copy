<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Search</title>
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';		
	</script>
	<script>
		// $(window).scroll(function(){
	 //      if ($(this).scrollTop() > 60) {
	 //          $('#searchTabUIFixed').addClass('searchTabUIFixed');
	 //      } else {
	 //          $('#searchTabUIFixed').removeClass('searchTabUIFixed');
	 //      }
	 //  });
	</script>
<!--Manoj: Back to top scroll script-->
<?php $this->load->view('common/scroll_to_top'); ?>
<!--Manoj: code end-->
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <!--Commented by Dashrath- this tab is replace by left menu bar for new ui-->
    <?php /*$this->load->view('common/artifact_tabs');*/ ?>
	<?php
		if ($workSpaceType==2)
		{
			$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
		}
		else
		{
			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
		}
	?>
  </div>
</div>
<div id="container">
	<!--Added by Dashrath- add leftsidebar-->
	<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
			</div>
 <!--  <div id="content"> -->
<!--Search result box start-->
<div id="rightSideBar">

<div id="SearchContent">

<?php
if(strlen(trim($query))<3)
{
?>
<strong> <?php echo $this->lang->line('txt_search_query_short'); ?> </strong>
<?php
}
else
{
$_SESSION['searchText']=urldecode(trim($query));
?>
<!--Tab for search type start-->

		<div style="">
		<!--Changed by Dashrath- Remove background:white; and add border:none in inline style-->
		<!--Added by Dashrath- Add id searchTabUIFixed for menu fixed on tab when scroll-->
		<div id="searchTabUIFixed" class="menu_new" style="padding-right:10%; border: none;">

        <ul class="tab_menu_new">
		  
		 <!--Changed by Dashrath- Remove background:#ECECEC; to white in inline style-->
		<li class=""><a style="margin-top: 9px;padding-left:11px;<?php if($type=='tree') { ?> background:white;" class="active <?php } ?>" id="curr" href="<?php echo base_url();?>search/text/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/tree/<?php echo $query; ?>">
		<!--Changed by Dashrath- Change text Tree to Title-->
		<?php echo $this->lang->line('txt_Title').' ('.$treeSearchResultCount.')'; ?>
        </a></li>
		 <!--Changed by Dashrath- Remove background:#ECECEC; to white in inline style-->
		<li class=""><a style="margin-top: 9px; padding-left:11px;<?php if($type=='leaf') { ?> background:white;" class="active <?php } ?>" id="curr" href="<?php echo base_url();?>search/text/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/leaf/<?php echo $query; ?>">
		<!--Changed by Dashrath- Change text Leaf to Content-->
		<?php echo $this->lang->line('txt_Content').' ('.$leafSearchResultCount.')'; ?>
		</a></li>
		 <!--Changed by Dashrath- Remove background:#ECECEC; to white in inline style-->
        <li class="" ><a style="margin-top: 9px;padding-left:11px; <?php if($type=='post') { ?> background:white;" class="active <?php } ?>" id="curr" href="<?php echo base_url();?>search/text/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/post/<?php echo $query; ?>">
		<?php echo $this->lang->line('txt_Post').' ('.$postSearchResultCount.')'; ?>
		</a></li>
		<!--Changed by Dashrath- Remove background:#ECECEC; to white in inline style-->
		<li class="" ><a style="margin-top: 9px;padding-left:11px; <?php if($type=='user') { ?> background:white;" class="active <?php } ?>" id="curr" href="<?php echo base_url();?>search/text/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/user/<?php echo $query; ?>">
		<?php echo $this->lang->line('txt_search_user').' ('.$userSearchResultCount.')'; ?>
		</a></li>
		
		
		</ul>

          <div class="clr"></div>

        </div>
		</div>
		
<!--Tabs for search type end-->
<?php

if(count($searchResult)>0)
{
	?>
	<div class="searchResultCount" style="color: #777; margin-top:1%;">
		<strong><?php echo $searchResultCount.' '.$this->lang->line('txt_search_result_found'); ?></strong>				
	</div>
	<?php
	//echo count($searchResult);
	//echo '<pre>';
	//print_r($searchResult);
	foreach($searchResult as $keyVal=>$searchData)
	{
		//Tree section start here
		if($type=='tree')
		{
		$SearchSeedProfiledetail='';
		$SearchLeafProfiledetail='';
		if($searchData['seedUserId']!='')
		{	
			$SearchSeedProfiledetail = $this->chat_db_manager->getUserDetailsByUserId($searchData['seedUserId']);
		}
		if($searchData['leafUserId']!='')
		{
			$SearchLeafProfiledetail = $this->chat_db_manager->getUserDetailsByUserId($searchData['leafUserId']);
		}
		?>
			<?php 
					$seedDataContent=strip_tags($searchData['seed']);
					if (strlen($seedDataContent) > 520) 
					{
						$SeedPostTitle = substr($seedDataContent, 0, 520) . "..."; 
					}
					else
					{
						$SeedPostTitle = $seedDataContent;
					}
					if($SeedPostTitle=='')
					{
						$SeedPostTitle = $this->lang->line('content_contains_only_image');
					}		
					//echo $searchData['seedType'];	
					/*Changed by Dashrath- remove margin-top:19px;height:20px in image tag and change title in image tag*/
					if ($searchData['seedType']==1)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/icon_document_sel.png"  title="Document" style="cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$searchData['treeId'].'&doc=exist&node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==2)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/discuss-view-sel.png"  title="Document" style="cursor:pointer;heigh;border:0px;" />
						<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==3)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/discuss-view-sel.png"  title="Discussion" style="cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==4)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/icon_task_sel.png" title="Task" style="cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_task/node/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==5)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/contact-view_sel.png"  title="Contact" style="cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'contact/contactDetails/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==6)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/notes-view-sel.png"  title="Note" style="cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'notes/Details/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
			?>
			<?php if(in_array($searchData['seedType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') { ?>
			<div class="searchLeafContent">
			<div class="seedData">
			<?php 
				echo $treeAllContents;
				echo $SeedPostTitle;
			?>
			<p style="font-size: 0.8em;font-style: italic; color:#999999;"><?php if($searchData['seedCreatedDate']!=''){ echo '<span>'.$SearchSeedProfiledetail['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($searchData['seedCreatedDate'],$this->config->item('date_format')).'</span>';} ?></p>
			<!--a start in treeAllContents variable-->
			</a>
			</div>
			</div>
			<?php } ?>
			
			
		
		
		<?php
		}
		//Tree section end here
		
		//Leaf section start here
		if($type=='leaf')
		{
					$active = 1;
					if($searchData['seedType']==1)
					{
						//Add draft reserved users condition
						$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($searchData['leafId']);
						$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($searchData['treeId'], $searchData['nodeOrder']);	
						$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($searchData['treeId'], $leafParentData['parentLeafId'],$_SESSION['userId']);
						//Get reserved users
						$reservedUsers = '';
						$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
						$resUserIds = array();			
						foreach($reservedUsers  as $resUserData)
						{
							$resUserIds[] = $resUserData['userId']; 
						}
						$active = 0;
					}	
					//Code end	
					if(((in_array($_SESSION['userId'], $resUserIds)) && $searchData['seedType']==1 && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $active == 1)
					{
		
			$SearchSeedProfiledetail='';
			$SearchLeafProfiledetail='';
			if($searchData['seedUserId']!='')
			{	
				$SearchSeedProfiledetail = $this->chat_db_manager->getUserDetailsByUserId($searchData['seedUserId']);
			}
			if($searchData['leafUserId']!='')
			{
				$SearchLeafProfiledetail = $this->chat_db_manager->getUserDetailsByUserId($searchData['leafUserId']);
			}
			?>
			<!--leaf code start-->				
				<?php 
				if($searchData['leaf']!='')
				{
				?>
				
				<?php 
					$leafDataContent=strip_tags($searchData['leaf']);
					if (strlen($leafDataContent) > 520) 
					{
						$LeafPostTitle = substr($leafDataContent, 0, 520) . "<br><span class='dotContent'>..................................</span>"; 
					}
					else
					{
						$LeafPostTitle = $leafDataContent;
					}
					if($LeafPostTitle=='')
					{
						$LeafPostTitle = $this->lang->line('content_contains_only_image');
					}
					//echo $searchData['seedType'];
					if ($searchData['seedType']==1)
					{
						?>
						<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$searchData['treeId'].'&doc=exist&node='.$searchData['nodeId'].'#docLeafContent'.$searchData['nodeId'].'">';
						?>
						<?php //echo $LeafPostTitle; ?> 
					</a>	
					<?php
					}
					if ($searchData['seedType']==2)
					{
						if($searchData['predecessor']!=0)
						{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['nodeId'].'#discussCommentLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?> 
					<!-- </a> -->
					<?php
						}
						else
						{ ?>
						<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['nodeId'].'#discussLeafContent'.$searchData['nodeId'].'">';
						?>
						<?php //echo $LeafPostTitle; ?> 
						<!-- </a> -->
						<?php }
					}
					if ($searchData['seedType']==3)
					{
						if($searchData['predecessor']!=0)
						{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['nodeId'].'#discussCommentLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?> 
					<!-- </a> -->
					<?php
						}
						else
						{ ?>
						<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['nodeId'].'#discussLeafContent'.$searchData['nodeId'].'">';
						?>
						<?php //echo $LeafPostTitle; ?> 
						<!-- </a> -->
						<?php }
					}
					if ($searchData['seedType']==4)
					{
						if($searchData['predecessor']!=0)
						{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_task/node/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['nodeId'].'#subTaskLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?>
					<!-- </a> -->
					<?php
						}
						else
						{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'view_task/node/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['nodeId'].'#taskLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?>
					<!-- </a> -->
					<?php
						}	
					}
					if ($searchData['seedType']==5)
					{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['nodeId'].'#contactLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?> 
					<!-- </a> -->	
					<?php
					}
					if ($searchData['seedType']==6)
					{
					?>
					<?php $leafAllContents = '<a target="_blank" href="'.base_url().'notes/Details/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['nodeId'].'#noteLeafContent'.$searchData['nodeId'].'">';
					?>
						<?php //echo $LeafPostTitle; ?> 
					<!-- </a> -->	
					<?php
					}
					
				?>
						
				
				<!--seed code start-->
				<?php 
						$seedDataContent=strip_tags($searchData['seed']);
						if (strlen($seedDataContent) > 520) 
						{
							$SeedPostTitle = substr($seedDataContent, 0, 520) . "..."; 
						}
						else
						{
							$SeedPostTitle = $seedDataContent;
						}
						if($SeedPostTitle=='')
						{
							$SeedPostTitle = $this->lang->line('content_contains_only_image');
						}		
						//echo $searchData['seedType'];	
						if ($searchData['seedType']==1)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/icon_document_sel.png"  title="Document" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$searchData['treeId'].'&doc=exist&node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==2)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/discuss-view-sel.png"  title="Document" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==3)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/discuss-view-sel.png"  title="Discussion" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_chat/chat_view/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==4)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/icon_task_sel.png" title="Task" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'view_task/node/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==5)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/contact-view_sel.png"  title="Contact" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'contact/contactDetails/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
					if ($searchData['seedType']==6)
					{
						?>
						<?php $treeAllContents = '<img src="'.base_url().'images/tab-icon/notes-view-sel.png"  title="Note" style="margin-top:19px;cursor:pointer;border:0px;" />
						<a target="_blank" href="'.base_url().'notes/Details/'.$searchData['treeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$searchData['treeId'].'">';
						?>
						<?php
						//echo $SeedPostTitle; 
						?>
						<!-- </a> -->
					<?php	
					}
			?>
			<?php if(in_array($searchData['seedType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') { ?>
				<!--leaf datetime start-->
				<div class="searchLeafContent">
				<div class="leafData">
				<?php echo $leafAllContents; ?>
				<?php echo $LeafPostTitle; ?>
				<p style="font-size: 0.8em;font-style: italic; color:#999999;"><?php if($searchData['leafCreatedDate']!=''){ echo '<span>'.$SearchLeafProfiledetail['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($searchData['leafCreatedDate'],$this->config->item('date_format')).'</span>'; } ?></p>
				<!--a start in leafAllContents variable-->
				</a>
				</div>
				<!--tree datetime start-->
				<div class="seedData">
				<?php echo $treeAllContents; ?>
				<?php echo $SeedPostTitle; ?>
				<p style="font-size: 0.8em;font-style: italic; color:#999999;"><?php if($searchData['seedCreatedDate']!=''){ echo '<span>'.$SearchSeedProfiledetail['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($searchData['seedCreatedDate'],$this->config->item('date_format')).'</span>';} ?></p>
				<!--a start in treeAllContents variable-->
				</a>
				</div>
				</div>
				<?php } 
				} ?>
				
			
			
			<?php
		}//Code end
		}
		//Leaf section end here
		
		//Post section start here
		
		if($type=='post')	
		{
			//echo '<pre>';
			//print_r($searchData);
			$SearchLeafProfiledetail='';
			if($searchData['leafUserId']!='')
			{
				$SearchLeafProfiledetail = $this->chat_db_manager->getUserDetailsByUserId($searchData['leafUserId']);
			}
			?>
			<div class="searchLeafContent">
				
				<?php 
				if($searchData['leaf']!='')
				{
				?>
				<div class="leafPostData" style="padding-top: 1%;">
				<?php 
					$leafDataContent=strip_tags($searchData['leaf']);
					if (strlen($leafDataContent) > 520) 
					{
						$LeafPostTitle = substr($leafDataContent, 0, 520) . "<br><span class='dotContent'>..................................</span>"; 
					}
					else
					{
						$LeafPostTitle = $leafDataContent;
					}
					if($LeafPostTitle=='')
					{
						$LeafPostTitle = $this->lang->line('content_contains_only_image');
					}
					//echo $searchData['seedType'];
					//if($searchData['workSpaceId']==0 && $searchData['workSpaceType']==1 )
					
					if($searchData['predecessor']!=0)
					{
						$checkpredecessorSpaceId=$this->identity_db_manager->checkPublicPostComment($searchData['predecessor']);
						//Code to check post comment predecessor space id and type
						if($checkpredecessorSpaceId['workSpaceId']==0 && $checkpredecessorSpaceId['workSpaceType']==0){ ?>
						<a target="_blank" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/1/public/<?php echo $searchData['predecessor']; ?>/#form<?php echo $searchData['predecessor']; ?>">
						<?php echo $LeafPostTitle; ?> 
						</a>
						<?php } else{ ?>
					<a target="_blank" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/<?php echo $searchData['predecessor']; ?>/#form<?php echo $searchData['predecessor']; ?>">
						<?php echo $LeafPostTitle; ?> 
					</a>
					<?php
					}
					}
					else
					{ ?>
						<?php if($searchData['workSpaceId']==0 && $searchData['workSpaceType']==0){ ?>
						<a target="_blank" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/1/public/<?php echo $searchData['nodeId']; ?>/#form<?php echo $searchData['nodeId']; ?>">
						<?php echo $LeafPostTitle; ?> 
						</a>
						<?php } else { ?>
						<a target="_blank" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/<?php echo $searchData['nodeId']; ?>/#form<?php echo $searchData['nodeId']; ?>">
						<?php echo $LeafPostTitle; ?> 
						</a>
						<?php } ?>
						<?php 
					}
					
				?>
				<p style="font-size: 0.8em;font-style: italic; color:#999999;"><?php if($searchData['leafCreatedDate']!=''){ echo '<span>'.$SearchLeafProfiledetail['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($searchData['leafCreatedDate'],$this->config->item('date_format')).'</span>'; } ?></p>
				</div>
				
				<?php } ?>
				
			</div>
			
			<?php
		}
		
		//Post section end here
		
		//User section start here
		
		if($type=='user')
		{
			//echo '<pre>';
			//print_r($searchResult);
			//exit;
		?>
			
			<div class="searchLeafContent" style="overflow:hidden;">
				<div class="UserDetailsLeft">
					<div style=" overflow:hidden;">
					<div style="float:left;">
					<?php
								if ($searchData['photo']!='noimage.jpg')
								{
					?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $searchData['photo'];?>" border="0"  width="70" height="70" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $searchData['photo'];?>" border="0"  width="70" height="70" id="imgName"> 
					<?php
								}
					?>
					</div>
					<div style="float:left; margin-left:5px; font-size:0.8em;">
						<p><b><?php //echo strip_tags($searchData['firstName'].' '.$searchData['lastName'],'<b><em><span><img>'); ?></b></p>
					</div>
					</div>
					<div style="margin-top:5%;" class="UserSearchTagname">
						<div>
						<?php echo $this->lang->line('txt_Tag_Name');?> &nbsp;&nbsp; <?php echo ': '.$searchData['userTagName'];?>
						</div>
						<div>
						<?php echo $this->lang->line('txt_Email')?> &nbsp;&nbsp; <?php echo ': '.$searchData['userName'];?>
						</div>
					</div>
				</div>
				
				<div class="UserDetailsRight">
					
					<div style="margin-bottom:1.5%;"> <strong><?php echo $this->lang->line('txt_Personal_Details');?></strong> </div>
					 
					<div class="clr"></div>
					
					<div class="personalDetailsLeft">

					<?php /*?><div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Title');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['userTitle'];?>&nbsp;</div>
			
					<div class="clr"></div><?php */?>
			
					<div style="width:30%; float:left;"><?php echo $this->lang->line('txt_First_Name');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['firstName'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<div style="width:30%; float:left;"><?php echo $this->lang->line('txt_Last_Name');?>:</div>
			
					<div style="width:60%;float:left;"><?php echo $searchData['lastName'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<div style="width:30%; float:left;"><?php echo $this->lang->line('txt_Role');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['role'];?>&nbsp;</div>
			
					<div class="clr"></div>
					
					<div style="width:30%; float:left;"><?php echo $this->lang->line('txt_Mobile');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['mobile'];?>&nbsp;</div>
			
					<div class="clr"></div>
					
					<div style="width:30%; float:left;"><?php echo $this->lang->line('txt_Status');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['statusUpdate'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<?php /*?><div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Department');?>:</div>
			
					<div style="width:60%;float:left;"><?php echo $searchData['department'];?>&nbsp;</div>
			
					<div class="clr"></div>
					
					<div style="width:40%; float:left;"><?php echo $this->lang->line('txt_skills');?>:</div>
			
					<div style="width:60%;float:left;"><?php echo $searchData['skills'];?>&nbsp;</div>
			
					<div class="clr"></div><?php */?>
					
					</div>
					
					<div class="personalDetailsRight">
			
					
					<?php /*?><div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Mobile');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['mobile'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Telephone');?>:</div>
			
					<div style="width:60%; float:left;"><?php echo $searchData['phone'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Address');?>:</div>
			
					<div style="width:60%;float:left;"><?php echo $searchData['address1'];?>&nbsp;</div>
			
					<div class="clr"></div>
			
					<div style="width:40%; float:left;"><?php echo $this->lang->line('txt_Other');?>:</div>
			
					<div style="width:60%;float:left;"><?php echo $searchData['other'];?>&nbsp;</div>
			
					<div class="clr"></div><?php */?>
					 
					 </div>
					 
				</div>
				
			</div>
			<div style="clear:both"></div>
		<?php
		}
		
		//User section end here
	}
	?>
				<div id="pagination">
                    <ul class="tsc_pagination">
                        
                        <!-- Show pagination links -->
                        <?php foreach ($links as $link) {
                            echo $link;
                         } ?>
                </div>
	<?php
}
else
{
?><div style="color: #777; margin-top:1%;"><strong> <?php
	echo $this->lang->line('txt_no_search_result_found');
	?>
	</strong></div>
	<?php
}
}
?>

</div>

</div>
<!--Search result box end code-->
 <!-- </div> -->

 	<!--Added by Dashrath- load notification side bar-->
	<?php $this->load->view('common/notification_sidebar.php');?>
	<!--Dashrath- code end-->

</div>
<?php $this->load->view('common/foot');?>
<!--Commented by Dashrath- comment footer for new ui-->
<?php /*$this->load->view('common/footer');*/?>
</body>
</html>