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
$total_messages			=$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true,0,0 );

$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
foreach($workSpaceManagers as $managersData)
{
	$managerIds[] = $managersData['managerId'];
}


?> 
<div id="menu-nav1">
<ul id="jsddm">
	<li id="menuHome"><span class="home"   ><h1>
	
				<!--<a href="<?php echo base_url();?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Home');?></a>-->
				
				<a id="1" href="javaScript:void(0)"><?php echo $this->lang->line('txt_Home');?></a>
				
				</h1></span>
		<ul  >
			<li><a href="<?php echo base_url(); ?>workspace_home2/updated_trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><?php echo $this->lang->line('txt_Updated_Trees');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Talks');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/updated_links/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Links');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/recent_tags/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Updated_Tags');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/my_tasks/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_My_Tasks');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/my_tags/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_My_Tags');?></a></li>
			
			<li><a href="<?php echo base_url(); ?>workspace_home2/trees/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Advance_Search');?></a></li>
		</ul>
	</li>
	
	<li id="menuDocument" ><span ><h1>
				
				
				<?php $temp=  ($total_documents!=0)?"<span  class='clsCountTrees'>".$total_documents."</span>":" "; ?>
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Document')."".$temp ;?></a>
				
				
				</h1></span>
		<ul>
			<?php if($total_documents) { ?>
			<li><a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			<?php } ?>
	
			<?php  
		
			if(($workSpaceType==1 && ($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds)))) || (in_array($_SESSION['userId'],$submemberIds)) ){ ?>
			<li><a href="<?php echo base_url();?>document_new/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('doc','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	
	</li>
	
	<li id="menuDiscuss" ><span><h1>
				
		<?php $temp=  ($total_chats!=0)?"<span  class='clsCountTrees'>".$total_chats."</span>":" "; ?>		
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Chat')."".$temp; ?></a>
				
				</h1></span>
		<ul>
			
			<?php if($total_chats) { ?>
			<li><a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			<?php } ?>
			<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
			<li><a href="<?php echo base_url();?>new_chat/start_Chat/0/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			<li><a href="javaScript:void(0)" onclick="help('chat','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
	<li id="menuTask" ><span><h1>
			<?php $temp=  ($total_tasks!=0)?"<span  class='clsCountTrees'>".$total_tasks."</span>":" "; ?>		
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Task')."".$temp;?></a>
				
			</h1></span>
		<ul>
			<?php if($total_tasks) { ?>
			<li><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			<?php } ?>
			
			<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
			<li><a href="<?php echo base_url();?>new_task/start_Task/0/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0"><?php echo $this->lang->line('txt_Calendar');?></a></li>
			
			<li><a href="javaScript:void(0)" onclick="help('task','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
    <li id="menuNotes" ><span><h1>
			
			<?php $temp=  ($total_notes!=0)?"<span  class='clsCountTrees'>".$total_notes."</span>":" "; ?>
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Notes')."".$temp;?></a>
			
			</h1></span>
		<ul>
			
			<?php if($total_notes){ ?>
			<li><a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			<?php } ?>
			
			<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
			<li><a href="<?php echo base_url();?>notes/New_Notes/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('notes','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
    <li id="menuContact" ><span><h1>
	<?php $temp=  ($total_contacts!=0)?"<span  class='clsCountTrees'>".$total_contacts."</span>":" "; ?>			
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Contact')."".$temp;?></a>
				
				</h1></span>
		<ul>
			<?php if($total_contacts){ ?>
			<li><a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			<?php } ?>
			
			<?php  if($treeAccess==1  ||  $workSpaceId==0  || (in_array($_SESSION['userId'],$managerIds))){ ?>
			<li><a href="<?php echo base_url();?>contact/editContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('contacts','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	
		</ul>
	</li>
	
	<li id="menuMembers" ><span class="members"><h1>
	
	<?php $temp=  ($total_messages!=0)?"<span  class='clsCountTrees'>".$total_messages."</span>":" "; ?>		
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Messages')."".$temp;?></a>
			
			</h1></span>
		<ul>
		
		<li><a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_View');?></a></li>
			
			<li><a href="javaScript:void(0)" onclick="help('members','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	
		</ul>
	</li>
<div class="clr"></div>
</ul>

</div>
<div class="clr"></div>

<!--
  jQuery library
-->

<!--
  jCarousel library
-->
<script type="text/javascript" src="<?php echo base_url();?>js/lib/jquery.jcarousel.min.js"></script>
<!--
  jCarousel skin stylesheet
-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lib/skins/tango/skin.css" />

<script type="text/javascript">

$(document).ready(function() {
    $('#jsddm').jcarousel();
});

</script>