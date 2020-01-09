<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
//$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
	if ($workSpaceType==1)
	{
		$workSpaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
	}
	else
	{
		$workSpaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
	}
$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
$total_documents		=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 1); 
$total_discussions		=$this->identity_db_manager->getTreeCountByTreeDiscussion($workSpaceId, $workSpaceType,$_SESSION['userId'], 2);
$total_chats			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 3 );
$total_tasks			=$this->identity_db_manager->getTreeCountByTreeTask($workSpaceId, $workSpaceType,$_SESSION['userId'] ,4,2 );
$total_notes			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 6 );
$total_contacts			=$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 5 );
$total_posts		    =$this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0);

//space tree config start
$treeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
$treeWorkSpaceName = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
if($workSpaceId!=0 && $treeWorkSpaceName['workSpaceName']!='Try Teeme') {
	$treeTypeEnabled = 1;	
}
$newtreeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId,$workSpaceType,1);
//space tree config end

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
$total_messages			=$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true,$workSpaceType,$workSpaceId );


//$workSpaceManagers	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
foreach($workSpaceManagers as $managersData)
{
	$managerIds[] = $managersData['managerId'];
}


?> 
<!--Manoj: Showing update notification-->

<div class="updateNotifyUsers_mob"></div>

<!--Manoj: code end-->

<div id="artifact_tabs_for_smart_phone" style="display:none;">

	<!--<div id="menu-nav1_for_mobile">-->
	<div id="cssmenu">
	<!--<ul id="jsddm" class="jcarousel-skin-tango">-->
	<ul id="menuSlick">
	
		<?php if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
		{
		?> 
		<li id="menuUser" style="text-align:right;">
		<a>
			 <?php echo $_SESSION['userTagName'];?>	
		</a> 
		</li>
		<?php } ?>
		
		<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<?php if(!empty($newtreeTypeIds) || $workSpaceId==0 || ($treeWorkSpaceName['workSpaceName']=='Try Teeme' && $workSpaceType==1)){ ?>
		<li id="menuCreate">
				<!--<span class="home"><h1>-->
				
					<a id="1" href="<?php echo base_url();?>new_tree/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" ><?php echo $this->lang->line('txt_Create');?></a>
				
				<!--</h1></span>-->
		</li>
		<?php } } ?>
		<li id="menuHome">
				<!--<span class="home"><h1>-->
				
					<a id="1" href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><?php echo $this->lang->line('txt_Home');?></a>
				
				<!--</h1></span>-->
		</li>
	
	<li id="menuDocument" <?php if(!(in_array('1',$treeTypeIds)) && $treeTypeEnabled==1 || $total_documents==0) { ?> style="display:none;" <?php }  ?>>
		<!--<span ><h1>-->
				
				
				<?php $temp=(is_numeric($total_documents) && $total_documents>0)?$total_documents:"0"; ?>
				
				<a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Document')." <span class='clsCountTrees' id='docCount'>".$temp."</span>"; ?></a>
				
				
		<!--</h1></span>-->
	</li>
	
	<li id="menuDiscuss" <?php if(!(in_array('3',$treeTypeIds)) && $treeTypeEnabled==1 || $total_chats==0) { ?> style="display:none;" <?php } ?> >
		<!--<span><h1>-->
				
		<?php $temp=  (is_numeric($total_chats) && $total_chats>0)?$total_chats:"0"; ?>		
				
				<a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Chat')." <span class='clsCountTrees' id='disCount'>".$temp."</span>"; ?></a>
				
		<!--</h1></span>-->
	</li>
	
	<li id="menuTask" <?php if(!(in_array('4',$treeTypeIds)) && $treeTypeEnabled==1 || $total_tasks==0) { ?> style="display:none;" <?php }?> >
		<!--<span><h1>-->
			<?php $temp=  (is_numeric($total_tasks) && $total_tasks>0)?$total_tasks:"0"; ?>		
				
				<a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Task')." <span class='clsCountTrees' id='taskCount'>".$temp."</span>";?></a>
				
		<!--</h1></span>-->
		<?php /*?><ul>
			<?php if($total_tasks) { $display = 'inline'; } else {$display='none';}?>
			<li id="task_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			
			<li><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0"><?php echo $this->lang->line('txt_Calendar');?></a></li>
			
		</ul><?php */?>
	</li>
	
    <li id="menuNotes" <?php if(!(in_array('6',$treeTypeIds)) && $treeTypeEnabled==1 || $total_notes==0) { ?> style="display:none;" <?php }?> >
		<!--<span><h1>-->
			
			<?php $temp=  (is_numeric($total_notes) && $total_notes>0)?$total_notes:"0"; ?>
			
			<a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Notes')." <span class='clsCountTrees' id='notesCount'>".$temp."</span>";?></a>
			
		<!--</h1></span>-->
	</li>
	
    <li id="menuContact" <?php if(!(in_array('5',$treeTypeIds)) && $treeTypeEnabled==1 || $total_contacts==0) { ?> style="display:none;" <?php } ?> >
	
			<!--<span><h1>-->
				<?php $temp=  (is_numeric($total_contacts) && $total_contacts>0)?$total_contacts:"0"; ?>			
				
				<a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Contact')." <span class='clsCountTrees' id='contCount'>".$temp."</span>";?></a>
				
			<!--</h1></span>-->
	</li>
	
	<?php /*?><li id="menuMembers" >
	
		<!--<span class="members"><h1>-->
	
			<?php $temp=  (is_numeric($total_messages) && $total_messages>0)?$total_messages:"0"; ?>		
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Messages')." <span class='clsCountTrees' id='msgCount'>".$temp."</span>";?></a>
			
		<!--</h1></span>-->
		<ul>
		
			<li><a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?><?php if ($workSpaceId<1 && $userGroup<1) echo '/all';?>"><?php echo $this->lang->line('txt_View');?></a></li><?php */?>
			
			<?php /*?><li><a href="javaScript:void(0)" onclick="help('members','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	<?php */?>
			<?php /*?><li><a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=msg" target="_blank" ><?php echo $this->lang->line('txt_Help');?></a></li>	
			
		</ul>
	</li><?php */?>
	
	<!--Timeline post menu option start-->
	
	<li id="menuPost" >
		<?php $temp=  (is_numeric($total_posts) && $total_posts>0)?$total_posts:"0"; ?>
		
		<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" ><?php echo $this->lang->line('txt_Post')." <span class='clsCountTrees' id='contCount'>".$temp."</span>"; ?></a>
	</li>
	
	<!--Timeline post menu option end-->
	
	<!--Header icons start here-->
	<?php if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
	{
	?>
	<li id="menuCalendar" <?php if(!(in_array('4',$treeTypeIds)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?> >
	<a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0">
         <?php echo $this->lang->line('txt_Calendar');?>	
    </a> 
	</li>
	<li id="menuPreference" >
	 <a href="<?php echo base_url();?>preference/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>" id="config">
         <?php echo $this->lang->line('configuration_txt');?> 
     </a> 
	</li>
	<li id="menuLogout" >
	 <a href="<?php echo base_url();?>instance/admin_logout/work_place">
	 	<?php echo $this->lang->line('txt_Sign_Out');?>
	 </a>
	</li>
	<?php } ?>
	
	<li id="menuHelp" >
		<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>" target="_blank" ><?php echo $this->lang->line('txt_Help') ?></a>
	</li>
	<!--Header icons end here-->
	
<div class="clr"></div>
	</ul>
	
	</div>
<div class="clr"></div>


</div>
<script>
$(document).ready(function() {
	checkUpdateStatus();
});

/*setInterval(function () {
   //checkUpdateStatus();
}, 10000);*/

//Manoj: Check update for notify users
function checkUpdateStatus()
{
	 $.ajax({

				url: baseUrl+'auto_update/check_update',

				success:function(result)
				{
					//alert(result);
					//$('#container_for_mobile').before('<div id="notify_users_mob"></div>');
					$('#notify_users_mob').remove();
					$('#container_for_mobile').before('<div id="notify_users_mob">'+result+'</div>');
					
					//$('#artifact_tabs_for_web').prepend('<div class="updateNotifyUsers">'+result+'</div>');
				  	
					if(result!='')
					{
						//$('.updateNotifyUsers_mob').css({'margin-bottom':'1%'});
						//$('#container').css({'padding-top': '115px'});
					}
					else
					{
						//$('.updateNotifyUsers_mob').css({'margin-bottom':'0%'});
						//$('#container').css({'padding-top': '90px'});
					}
				}
				, 
				async: false

		});
}
//Manoj: code end
</script>
