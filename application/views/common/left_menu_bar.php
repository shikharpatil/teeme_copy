<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
$typeForActive = $this->uri->segment(1);
$treeType = $this->uri->segment(6);
$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
if ($workSpaceType==1)
{
	$workSpaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
}
else
{
	$workSpaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
}
$workSpaces 			=$this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
$total_documents		=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 1); 
$total_discussions		=$this->identity_db_manager->getTreeCountByTreeDiscussion($workSpaceId, $workSpaceType,$_SESSION['userId'], 2);
$total_chats			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 3 );
$total_tasks			=$this->identity_db_manager->getTreeCountByTreeTask($workSpaceId, $workSpaceType,$_SESSION['userId'] ,4,2 );
$total_notes			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 6 );
$total_contacts			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 5 );
$total_posts		    =$this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0);
//space tree config 
$treeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
$treeWorkSpaceName = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
if($workSpaceId!=0 && $treeWorkSpaceName['workSpaceName']!='Try Teeme') {
$treeTypeEnabled = 1;	
}
$newtreeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId,$workSpaceType,1);

if($workSpaceType==1)
{
	$treeAccess	= $this->identity_db_manager->getTreeAccessByWorkSpaceId($workSpaceId);
	$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
}
else
{		
	$treeAccess	= $this->identity_db_manager->getTreeAccessByWorkSpaceId($workSpaceDetails['workSpaceId']);
	$subWorkSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
	$submemberIds = array();
		foreach($subWorkSpaceMembers as $submembersData)
		{
			$submemberIds[] = $submembersData['userId'];
		}
	$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceDetails['workSpaceId'], 3);
}
foreach($workSpaceManagers as $managersData)
{
	$managerIds[] = $managersData['managerId'];
}	

//print_r ($managerIds); exit;
//$total_messages			=$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true,$workSpaceType,$workSpaceId );

$userGroup= $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
if ($userGroup==0 && $workSpaceId==0)
{
	//redirect('instance/admin_logout/work_place', 'location');
	//exit;
}
//echo "treeaccess= " .$treeAccess; exit;
?>

<!--Added by Dashrath- add loader in left menu bar for left menu bar show then hide when page refresh if left menu hide-->
<div id='leftMenuBarLoader' style='margin:1% 0;padding-left:7px;'>
	<img src='<?php echo base_url();?>/images/ajax-loader-add.gif'>
</div>
<!--Dashrath- code end-->

<!--Changed by Dashrath- add style="display: none" in div inline css-->
<div id="left-menu-nav1" style="display: none">
	<div class="placeLabel"><b><?php echo $this->lang->line('txt_Workplace');?>:</b> <?php echo $_SESSION['contName'];?></div>
	<ul id="newjsddml">
		<!-- <li> -->
			<!-- <h3><?php echo $this->lang->line('txt_Select_space');?></h3> -->
			<select name="spaceSelect" id="spaceSelect" onChange="javascript:goWorkSpace(this);" class="left-bar-selbox-min" >
            <?php 
			if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
			{          
			?>
	        	<option value="0" <?php if($workSpaceId == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>
	        	<?php
	        	$i = 1;

				foreach($workSpaces as $keyVal=>$workSpaceData)
				{				
					if($workSpaceData['workSpaceName']=='Learn Teeme'){
						$s=$keyVal;
					}
					else
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

	                    if (($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) || ($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) 
	                    {    
	                        $enable_disable = '';
	                    }
						else
						{
							//$enable_disable = 'disabled';
							$enable_disable = 'none';
						}

						if ($workSpaceData['status']>0)
						{
							if ($this->identity_db_manager->isDefaultPlaceManagerSpace($workSpaceData['workSpaceId'],$_SESSION['workPlaceId']))
							{
								if (($this->identity_db_manager->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId']) == $_SESSION['userId']))
								{
									if($enable_disable!='none')
									{
									?>
									<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?> style="display:<?php echo $enable_disable;?>"><?php echo $workSpaceData['workSpaceName'];?></option>	
									<?php	
									}
								}
							}
							else
							{
							 	if($enable_disable!='none')
								{
								?>
									<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?> style="display:<?php echo $enable_disable;?>"><?php echo $workSpaceData['workSpaceName'];?></option>
								<?php
								}
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
								if ($workSpaceData['status']>0)
								{
									if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
									{
								?>
								<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'style="display:none"';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
								<?php
									}
								}
							}
						}
					}
		 		}
				//learn teeme check not applying working on it
				if(isset($s))
				{
					$workSpaceData=$workSpaces[$s];
					if($workSpaceData['workSpaceManagerId'] == 0)
					{
						$workSpaceManager = $this->lang->line('txt_Not_Assigned');
					}
					else
					{					
						$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
						$workSpaceManager = $arrUserDetails['userName'];
					}
					?>
					<option disabled="disabled">---------------</option>
					<?php
					if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) || $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))
					{
					?>
						<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
					<?php
					}	 
				}	
	  		}
			else
			{
			?>
		            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>
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
					if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
					{
						if($workSpaceData['workSpaceId']!=1)
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
							if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2) && $workSpaceData['status']>0)
							{
								?>
								<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
								<?php
							}
						}
					}
				}
		    
			}
		    ?>
			</select>
		<!-- </li> -->
		<!-- <li id="menuCreate" class="newjsddm1Li" >
			<span class="home">
				<h1>
				<a id="1" title="<?php echo $this->lang->line('txt_Create_Tree_Label'); ?>" href="<?php echo base_url();?>new_tree/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" ><img src="<?php echo base_url();?>images/addnew.png" class="left-menu-icon" /> <?php echo $this->lang->line('txt_Create_Tree_Label');?>
				</a>
				</h1>
			</span>
		</li> -->
		
		<li id="menuHome" class="newjsddm1Li <?php if($typeForActive=='dashboard'){ echo 'active';}?>">
			<span class="<?php echo $homeClass; ?>">
				<h1>
				<a title="<?php echo $this->lang->line('txt_Home'); ?>" href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1">
					<?php 
					if($typeForActive=='dashboard')
					{ 
					?>
						<img src="<?php echo base_url();?>images/home_blue_btn.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Home');?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/home_gray_btn.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Home');?>
					<?php
					}
					?>
				</a>
				</h1>
			</span>
		</li>
		
		<li id="menuDocument" class="newjsddm1Li <?php if($typeForActive=='document_home' || $typeForActive=='view_document' || ($typeForActive=='tree_timeline' && $treeType=='document')){ echo 'active';}?>" <?php if(!(in_array('1',$treeTypeIds)) && $treeTypeEnabled==1 || $total_documents==0) { ?> style="display:none;" <?php }    ?> >
			<span >
				<h1>
				<?php $temp=(is_numeric($total_documents) && $total_documents>0)?$total_documents:"0"; ?>
				
				<a title="<?php echo $this->lang->line('txt_Document'); ?>" href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" >
					<?php 
					if($typeForActive=='document_home' || $typeForActive=='view_document' || ($typeForActive=='tree_timeline' && $treeType=='document'))
					{ 
					?>
						<img src="<?php echo base_url();?>images/icon_document_sel.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Document')." <span class='clsCountTrees' id='docCount'>".$temp."</span>"; ?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/icon_document.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Document')." <span class='clsCountTrees' id='docCount'>".$temp."</span>"; ?>
					<?php
					}
					?>
				</a>
				</h1>
			</span>
		</li>
		<li id="menuDiscuss" class="newjsddm1Li <?php if($typeForActive=='chat' || $typeForActive=='view_chat' || ($typeForActive=='tree_timeline' && $treeType =='discuss')){ echo 'active';}?>" <?php if(!(in_array('3',$treeTypeIds)) && $treeTypeEnabled==1 || $total_chats==0) { ?> style="display:none;" <?php } ?> >
			<span>
				<h1>	
				<?php $temp=  (is_numeric($total_chats) && $total_chats>0)?$total_chats:"0"; ?>	
				<a title="<?php echo $this->lang->line('disucssion'); ?>" href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" >
					<?php 
					if($typeForActive=='chat' || $typeForActive=='view_chat' || ($typeForActive=='tree_timeline' && $treeType =='discuss'))
					{ 
					?>
						<img src="<?php echo base_url();?>images/tab-icon/discuss-view-sel.png"  class="left-menu-icon" /><?php echo $this->lang->line('disucssion')." <span class='clsCountTrees' id='disCount'>".$temp."</span>"; ?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/tab-icon/discuss-view.png"  class="left-menu-icon" /><?php echo $this->lang->line('disucssion')." <span class='clsCountTrees' id='disCount'>".$temp."</span>"; ?>
					<?php
					}
					?>
				</a>
				
				</h1>
			</span>
		</li>
		
		<li id="menuTask" class="newjsddm1Li <?php if($typeForActive=='view_task' || $typeForActive=='calendar' || ($typeForActive=='tree_timeline' && $treeType =='task')){ echo 'active';}?>" <?php if(!(in_array('4',$treeTypeIds)) && $treeTypeEnabled==1 || $total_tasks==0) { 	?> style="display:none;" <?php }?> >
			<span>
				<h1>
				<?php $temp=  (is_numeric($total_tasks) && $total_tasks>0)?$total_tasks:"0"; ?>		
					
					<a title="<?php echo $this->lang->line('txt_Task'); ?>" title="<?php echo $this->lang->line('txt_Task'); ?>" href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" >

						<?php 
						if($typeForActive=='view_task' || $typeForActive=='calendar' || ($typeForActive=='tree_timeline' && $treeType =='task'))
						{ 
						?>
							<img src="<?php echo base_url();?>images/icon_task_sel1.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Task')." <span class='clsCountTrees' id='taskCount'>".$temp."</span>";?>
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url();?>images/icon_task1.png"  class="left-menu-icon" /><?php echo $this->lang->line('txt_Task')." <span class='clsCountTrees' id='taskCount'>".$temp."</span>";?>
						<?php
						}
						?>
					</a>
					
				</h1>
			</span>
		</li>
	    <!-- <li id="menuNotes" class="newjsddm1Li" <?php if(!(in_array('6',$treeTypeIds)) && $treeTypeEnabled==1 || $total_notes==0) { ?> style="display:none;" <?php }?>>
	    	<span>
	    		<h1>
				<?php $temp=  (is_numeric($total_notes) && $total_notes>0)?$total_notes:"0"; ?>
				<a title="<?php echo $this->lang->line('txt_Notes'); ?>" href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><img src="<?php echo base_url();?>images/notes-view1.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Notes')." <span class='clsCountTrees' id='notesCount'>".$temp."</span>";?></a>
				</h1>
			</span>
			
		</li> -->

	    <li id="menuContact" class="newjsddm1Li <?php if($typeForActive=='contact' || ($typeForActive=='tree_timeline' && $treeType=='contact')){ echo 'active';}?>" <?php if(!(in_array('5',$treeTypeIds)) && $treeTypeEnabled==1 || $total_contacts==0) { ?> style="display:none;" <?php } ?>>
	    	<span>
	    		<h1>
				<?php $temp=  (is_numeric($total_contacts) && $total_contacts>0)?$total_contacts:"0"; ?>	
					<a title="<?php echo $this->lang->line('txt_Contact'); ?>" href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" >

						<?php 
						if($typeForActive=='contact' || ($typeForActive=='tree_timeline' && $treeType=='contact'))
						{ 
						?>
							<img src="<?php echo base_url();?>images/contact_icon_sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Contact')." <span class='clsCountTrees' id='contCount'>".$temp."</span>";?>
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url();?>images/contact_icon.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Contact')." <span class='clsCountTrees' id='contCount'>".$temp."</span>";?>
						<?php
						}
						?>
					</a>
					</h1>
				</span>
		</li>
		
		<li id="menuPost" class="newjsddm1Li <?php if($typeForActive=='post'){ echo 'active';}?>">
			<span>
				<h1>
				<?php $temp=  (is_numeric($total_posts) && $total_posts>0)?$total_posts:"0"; ?>
				<!--<a title="<?php echo $this->lang->line('txt_Post'); ?>" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" >-->
				<?php if ($workSpaceType==1){
					?>
									<a title="<?php echo $this->lang->line('txt_Post'); ?>" target="_blank" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/space/<?php echo $workSpaceId;?>" >
					<?php
					}else{
						?>
						<a title="<?php echo $this->lang->line('txt_Post'); ?>" target="_blank" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>/subspace/<?php echo $workSpaceId;?>" >
						<?php
					}?>

				
					<?php 
					if($typeForActive=='post')
					{ 
					?>
						<img src="<?php echo base_url();?>images/history-icon-sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Post')." <span class='clsCountTrees' id='postCount'>".$temp."</span>";?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/history-icon.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Post')." <span class='clsCountTrees' id='postCount'>".$temp."</span>";?>
					<?php
					}
					?>
				</a>
				</h1>
			</span>
		</li>
		
	</ul>
	<hr style="height: 1px;  border: none; background-color: #c6c6c6;"/>
	<ul id="newjsddml">	
		
		<?php
		if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
		{	
			if($subWorkSpaceId > 0)
			{
				//$tmpWorkSpaceId = $subWorkSpaceId;
				$tmpWorkSpaceType = 2;
				$tmpWorkSpaceId = $this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($subWorkSpaceId);
				$tmpSubWorkSpaceId = $subWorkSpaceId;
			}
			else if($workSpaceType == 2)
			{
				//$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 2;
				$tmpWorkSpaceId = $this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);
				$tmpSubWorkSpaceId = $workSpaceId;
			}
			else
			{
				$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 1;
			}

			if($tmpWorkSpaceId > 0)
			{
				if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
				{
					
					$_SESSION['WSManagerAccess'] = 1;
					if($tmpWorkSpaceType == 1)
					{
						$wsUrl = base_url().'edit_workspace/index/'.$tmpWorkSpaceId.'/1';
					}
					else if($tmpWorkSpaceType == 2)
					{			
						$wsDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($tmpSubWorkSpaceId);
						$wsUrl = base_url().'edit_sub_work_space/index/'.$wsDetails['workSpaceId'].'/'.$tmpSubWorkSpaceId;
					}
				}
				else
				{		
					$_SESSION['WSManagerAccess'] = 0;
				}
			}
			else
			{
				$_SESSION['WSManagerAccess'] = 0;
			}
			
		}
		?>

		<li id="menuCreate" class="newjsddm1Li <?php if($typeForActive=='new_tree'){ echo 'active';}?>" >
			<span class="home">
				<h1>
				<a id="1" title="<?php echo $this->lang->line('txt_Create'); ?>" href="<?php echo base_url();?>new_tree/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" >

					<?php 
					if($typeForActive=='new_tree')
					{ 
					?>
						<!-- <img src="<?php echo base_url();?>images/addnew_sel.png" class="left-menu-icon" /> <?php echo $this->lang->line('txt_Create_Tree_Label');?> -->
						<img src="<?php echo base_url();?>images/addnew_sel.png" class="left-menu-icon" /> <?php echo $this->lang->line('txt_Create');?>
					<?php
					}
					else
					{
					?>
						<!-- <img src="<?php echo base_url();?>images/addnew.png" class="left-menu-icon" /> <?php echo $this->lang->line('txt_Create_Tree_Label');?> -->
						<img src="<?php echo base_url();?>images/addnew.png" class="left-menu-icon" /> <?php echo $this->lang->line('txt_Create');?>
					<?php
					}
					?>
				</a>
				</h1>
			</span>
		</li>
		
        <li class="newjsddm1Li <?php if($typeForActive=='external_docs'){ echo 'active';}?>">
            <?php
			if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
			{
			?>	
			<h1>			
				<a title="<?php echo $this->lang->line('txt_Manage_Files'); ?>" href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1">

					<?php 
					if($typeForActive=='external_docs')
					{ 
					?>
						<img src="<?php echo base_url();?>images/manage_file_sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Files');?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/manage_file.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Files');?>
					<?php
					}
					?>
				</a>
			</h1>
			<?php
			}
            ?>
		</li>
    	<?php
		if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) && $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
		{
		?>
			<li class="newjsddm1Li <?php if($typeForActive=='create_workspace'){ echo 'active';}?>">
				<h1>
					<a title="<?php echo $this->lang->line('txt_Create_Workspace'); ?>" href="<?php echo base_url();?>create_workspace/index/<?php echo $workSpaceId;?>">

						<?php 
						if($typeForActive=='create_workspace')
						{ 
						?>
							<img src="<?php echo base_url();?>images/workspace_icon_sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Create_Workspace');?>
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url();?>images/workspace_icon_new.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Create_Workspace');?>
						<?php
						}
						?>
					</a>
				</h1>
			</li>
		<?php
		}
        ?>
		<li class="newjsddm1Li <?php if($typeForActive=='edit_workspace' || $typeForActive=='view_sub_work_spaces' || $typeForActive=='create_sub_work_space' || $typeForActive=='edit_sub_work_space'){ echo 'active';}?>">
			<?php
			if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
			{
			?>	<h1>
				<a title="<?php echo $this->lang->line('txt_Manage_Space'); ?>" href="<?php echo $wsUrl;?>">
					<?php 
					if($typeForActive=='edit_workspace' || $typeForActive=='view_sub_work_spaces' || $typeForActive=='create_sub_work_space' || $typeForActive=='edit_sub_work_space')
					{ 
					?>
						<img src="<?php echo base_url();?>images/workspace_icon_sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Space');?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/workspace_icon_new.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Space');?>
					<?php
					}
					?>
				</a>
				</h1>	
			<?php
			}
			?>
		</li>
        <?php
		if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
		{
		?>
		<li class="newjsddm1Li <?php if($typeForActive=='manage_workplace' || $typeForActive=='view_workplace_members' || $typeForActive=='add_workplace_member' || $typeForActive=='view_metering' || $typeForActive=='place_backup' || $typeForActive=='language' || $typeForActive=='user_group' || $typeForActive=='edit_workplace_member'){ echo 'active';}?>">
			<h1>
				<a title="<?php echo $this->lang->line('txt_Manage_Place'); ?>" href="<?php echo base_url();?>manage_workplace">
					<?php 
					if($typeForActive=='manage_workplace' || $typeForActive=='view_workplace_members' || $typeForActive=='add_workplace_member' || $typeForActive=='view_metering' || $typeForActive=='place_backup' || $typeForActive=='language' || $typeForActive=='user_group' || $typeForActive=='edit_workplace_member')
					{ 
					?>
						<img src="<?php echo base_url();?>images/workplace_icon_sel.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Place');?>
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url();?>images/workplace_icon_new.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Manage_Place');?>
					<?php
					}
					?>
				</a>
			</h1>
		</li>
		<?php 		
		}
		?>
		<li id="menuHelp" class="newjsddm1Li">
			<span>
				<h1>
				<a title="<?php echo $this->lang->line('txt_Help'); ?>" href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>" target="_blank" ><img src="<?php echo base_url();?>images/help_icon.png" class="left-menu-icon" /><?php echo $this->lang->line('txt_Help');?>
				</a>
				</h1>
			</span>
		</li>
					
    </ul>
    <hr style="height: 1px;  border: none; background-color: #c6c6c6;"/>
    <span class="postTimeStamp">Copyright © Team Beyond Borders Pty Ltd.</span>
</div>

<script>
//Add SetTimeOut 
setTimeout("getTreeUpdates()", 10000);

function getTreeUpdates(){
	var url= "<?php echo base_url();?>workspace_home2/getTreeCountAjax/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>";
	$.post(url,{dataString:'<?php echo $total_documents.",".$total_chats.",".$total_tasks.",".$total_notes.",".$total_contacts.",".$total_posts;?>'},function(data){console.log(data);
		var obj = data.split(',');
		//documents
		if(obj[0].trim()!=0){//alert(obj[0]);
			 $('#docCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			// $('#docCount').html(parseInt(obj[0])+parseInt(<?php echo $total_documents;?>));
			if (!isNaN(obj[0].trim()))
			{ 
				$('#docCount').html(obj[0].trim());
				$('#doc_menu').css('display', 'inline');
				//$('#doc_menu').show();
				if($('#menuDocument').is(':hidden'))
				{
					$('#menuDocument').show();
				}
			}
		}
		//discuss
		if(obj[1].trim()!=0){//alert(obj[1]);
			$('#disCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[1].trim()))
			{ 
				$('#disCount').html(obj[1].trim());
				$('#discuss_menu').css('display', 'inline');
				if($('#menuDiscuss').is(':hidden'))
				{
					$('#menuDiscuss').show();
				}
			}
		}
		//tasks
		if(obj[2]!=0){//alert(obj[2]);
			 $('#taskCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[2].trim()))
			{ 
			 	$('#taskCount').html(obj[2].trim());
				$('#task_menu').css('display', 'inline');
				if($('#menuTask').is(':hidden'))
				{
					$('#menuTask').show();
				}
			}
		}
		//notes
		if(obj[3]!=0){//alert(obj[3]);
			 $('#notesCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[3].trim()))
			{ 
				//alert(obj[3]);
				$('#notesCount').html(obj[3].trim());
				$('#notes_menu').css('display', 'inline');
				if($('#menuNotes').is(':hidden'))
				{
					$('#menuNotes').show();
				}
			 }
		}
		//contacts
		if(obj[4]!=0){//alert(obj[4]);
			 $('#contCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[4].trim()))
			{ 
				$('#contCount').html(obj[4].trim());
			 	$('#contact_menu').css('display', 'inline');
				if($('#menuContact').is(':hidden'))
				{
					$('#menuContact').show();
				}
			}
		}
		
		//posts
		if(obj[5]!=0){//alert(obj[5]);
			$('#postCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[5].trim()))
			{ 
			 $('#postCount').html(obj[5].trim());
			 }
		}
		
		//Add SetTimeOut 
		setTimeout("getTreeUpdates()", 10000);
	});
}

function checkUpdateStatus()
{
	 $.ajax({
			url: baseUrl+'auto_update/check_update',

			success:function(result)
			{
				$('.updateNotifyUsers').html(result);
				//$('#artifact_tabs_for_web').prepend('<div class="updateNotifyUsers">'+result+'</div>');
			  	
				if(result.trim()!='')
				{
					$('.updateNotifyUsers').css({'margin-bottom':'1%'});
					$('#container').css({'padding-top': '115px'});
				}
				else
				{
					$old_padding=$('#container').css('padding-top');
					$('.updateNotifyUsers').css({'margin-bottom':'0%'});
					$('#container').css({'padding-top': $old_padding});
				}
			}
			, 
			async: true

		});
}
//Manoj: code end
</script>
