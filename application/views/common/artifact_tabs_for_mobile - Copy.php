<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
$total_documents			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 1); 
$total_discussions			=$this->identity_db_manager->getTreeCountByTreeDiscussion($workSpaceId, $workSpaceType,$_SESSION['userId'], 2);
$total_chats			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 3 );
$total_tasks			=$this->identity_db_manager->getTreeCountByTreeTask($workSpaceId, $workSpaceType,$_SESSION['userId'] ,4,2 );
$total_notes			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 6 );
$total_contacts			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 5 );

if($workSpaceType==1)
{
$treeAccess				=$this->identity_db_manager->getTreeAccessByWorkSpaceId($workSpaceId,$workSpaceType);
}
else
{

$subWorkSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);

$submemberIds = array();
					foreach($subWorkSpaceMembers as $submembersData)
					{
						$submemberIds[] = $submembersData['userId'];
					}


}
$total_messages			=$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true,$workSpaceType,$workSpaceId );


$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
foreach($workSpaceManagers as $managersData)
{
	$managerIds[] = $managersData['managerId'];
}


?> 
<div id="artifact_tabs_for_smart_phone" style="display:none;">
	<div id="menu-nav1_for_mobile">
	
	<ul id="jsddm" class="jcarousel-skin-tango">
		<li id="menuHome" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="workspace_home2")?"home1_active":"home1";?>"   ><h1>
		
					<!--<a href="<?php echo base_url();?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Home');?></a>-->
					
					<a id="1" href="javaScript:void(0)"><?php //echo $this->lang->line('txt_Home');?></a>
					
					</h1></span>
			<ul  >
				<li ><a href="<?php echo base_url(); ?>workspace_home2/updated_trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><?php echo $this->lang->line('txt_Updated_Trees');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Talks');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/updated_links/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Links');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/recent_tags/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Tags');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/my_tasks/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_My_Tasks');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/my_tags/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_My_Tags');?></a></li>
				
				<li><a href="<?php echo base_url(); ?>workspace_home2/trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Advance_Search');?></a></li>
			</ul>
		</li>
		
		<li id="menuDocument" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="document_home")?"doc_active":"doc";?>"><h1>
					
					
					<?php $temp=  ($total_documents!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_documents."</span>":" "; ?>
					
					<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/icon_document.png" />--><?php //echo $this->lang->line('txt_Document')."".$temp ;?></a>
					
					
					</h1></span>
			<ul>
				<?php if($total_documents) { ?>
				<li><a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
				<?php } ?>
		
				<?php  
				// treeAccess ==1 for all members of work spaces
				if(($workSpaceType==1 && ($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds)))) || (in_array($_SESSION['userId'],$submemberIds)) ){ ?>
				<li><a href="<?php echo base_url();?>document_new/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
				<?php } ?>
				
				<li><a href="javaScript:void(0)" onClick="help('doc','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
			</ul>
		
		</li>
		
		<li id="menuDiscuss" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="chat")?"dis_active":"dis";?>"><h1>
					
			<?php $temp=  ($total_chats!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_chats."</span>":" "; ?>		
					
					<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/tab-icon/discuss-view1.png" />--><?php //echo $this->lang->line('txt_Chat')."".$temp; ?></a>
					
					</h1></span>
			<ul>
				
				<?php if($total_chats) { ?>
				<li><a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
				<?php } ?>
				<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
				<li><a href="<?php echo base_url();?>new_chat/start_Chat/0/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
				<?php } ?>
				<li><a href="javaScript:void(0)" onClick="help('chat','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
			</ul>
		</li>
		
		<li id="menuTask" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="view_task")?"task_active":"task";?>">
				<?php $temp=  ($total_tasks!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_tasks."</span>":" "; ?>		
					
					<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/icon_task1.png" />--><?php //echo $this->lang->line('txt_Task')."".$temp;?></a>
					
				</span>
			<ul>
				<?php if($total_tasks) { ?>
				<li><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
				<?php } ?>
				
				<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
				<li><a href="<?php echo base_url();?>new_task/start_Task/0/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
				<?php } ?>
				
				<li><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0"><?php echo $this->lang->line('txt_Calendar');?></a></li>
				
				<li><a href="javaScript:void(0)" onClick="help('task','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
			</ul>
		</li>
		
		<li id="menuNotes" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="notes" || $this->uri->segment(1)=="periodic_notes")?"notes_active":"notes";?>">
				
				<?php $temp=  ($total_notes!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_notes."</span>":" "; ?>
				
				<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/tab-icon/notes-view1.png" />--><?php //echo $this->lang->line('txt_Notes')."".$temp;?></a>
				
				</span>
			<ul>
				
				<?php if($total_notes){ ?>
				<li><a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
				<?php } ?>
				
				<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
				<li><a href="<?php echo base_url();?>notes/New_Notes/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
				<?php } ?>
				
				<li><a href="javaScript:void(0)" onClick="help('notes','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
			</ul>
		</li>
		
		<li id="menuContact" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="contact")?"contact_active":"contact";?>">
		<?php $temp=  ($total_contacts!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_contacts."</span>":" "; ?>			
					
					<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/tab-icon/contact-view1.png" />--><?php //echo $this->lang->line('txt_Contact')."".$temp;?></a>
					
					</span>
			<ul>
				<?php if($total_contacts){ ?>
				<li><a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="width:15%"><?php echo $this->lang->line('txt_List');?></a></li>
				<?php } ?>
				
				<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
				<li><a href="<?php echo base_url();?>contact/editContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="width:15%"><?php echo $this->lang->line('txt_Create');?></a></li>
				<?php } ?>
				
				<li><a href="javaScript:void(0)" onClick="help('contacts','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')" style="width:15%"><?php echo $this->lang->line('txt_Help');?></a></li>	
			</ul>
		</li>
		
		<li id="menuMembers" style="width:40px!important;"><span class="<?php echo ($this->uri->segment(1)=="profile")?"member1_active":"member1";?>">
		
		<?php $temp=  ($total_messages!=0)?"<span  class='clsCountTrees_for_mobile'>".$total_messages."</span>":" "; ?>		
				
				<a href="javaScript:void(0)" ><!--<img src="<?php //echo base_url(); ?>images/message_gray_btn.png" />--><?php //echo $this->lang->line('txt_Messages')."".$temp;?></a>
				
				</span>
			<ul>
			
			<li><a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php //echo $workSpaceId;?>0/<?php echo $workSpaceType;?>/all" style="width:9%"><?php echo $this->lang->line('txt_View');?></a></li>
				
				<li><a href="javaScript:void(0)" onClick="help('members','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')" style="width:9%"><?php echo $this->lang->line('txt_Help');?></a></li>	
			</ul>
		</li>
	<div class="clr"></div>
	</ul>
	
	</div>
<div class="clr"></div>


</div>



