<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
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


//echo "wsid= " .$workSpaceType; exit;
//echo "<li>Total docs= " .$total_documents; exit;

//echo "wstype= " .$workSpaceType; exit;

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
$total_messages			=$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true,$workSpaceType,$workSpaceId );

$userGroup= $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
	if ($userGroup==0 && $workSpaceId==0)
	{
		redirect('instance/admin_logout/work_place', 'location');
		exit;
	}
	//echo "treeaccess= " .$treeAccess; exit;
?> 
<div id="artifact_tabs_for_web" style="display:none;">
<div id="menu-nav1">
<!--<div id="cssmenu">-->
<ul id="jsddm1">
<!--<ul>-->
	<li id="menuHome"><span class="home"><h1>
				
				<a id="1" href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><?php echo $this->lang->line('txt_Home');?></a>
				
				</h1></span>
		<ul>

		</ul>
	</li>
	
	<li id="menuDocument" ><span ><h1>
				
				
				<?php $temp=(is_numeric($total_documents) && $total_documents>0)?$total_documents:"0"; ?>
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Document')." <span class='clsCountTrees' id='docCount'>".$temp."</span>"; ?></a>
				
				
		</h1></span>
		<ul>
			<?php if($total_documents) { $display = 'inline'; } else {$display='none';}?>
			<li id="doc_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>

	
			<?php  
			// treeAccess ==1 for all members of work spaces
			if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<li><a href="<?php echo base_url();?>document_new/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('doc','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	
	</li>
	
	<li id="menuDiscuss" ><span><h1>
				
		<?php $temp=  (is_numeric($total_chats) && $total_chats>0)?$total_chats:"0"; ?>		
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Chat')." <span class='clsCountTrees' id='disCount'>".$temp."</span>"; ?></a>
				
				</h1></span>
		<ul>
			
			<?php if($total_chats) { $display = 'inline'; } else {$display='none';} ?>
			<li id="discuss_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>

			<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<li><a href="<?php echo base_url();?>new_chat/start_Chat/0/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			<li><a href="javaScript:void(0)" onclick="help('chat','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
	<li id="menuTask" ><span><h1>
			<?php $temp=  (is_numeric($total_tasks) && $total_tasks>0)?$total_tasks:"0"; ?>		
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Task')." <span class='clsCountTrees' id='taskCount'>".$temp."</span>";?></a>
				
			</h1></span>
		<ul>
			<?php if($total_tasks) { $display = 'inline'; } else {$display='none';}?>
			<li id="task_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			
			<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<li><a href="<?php echo base_url();?>new_task/start_Task/0/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0"><?php echo $this->lang->line('txt_Calendar');?></a></li>
			
			<li><a href="javaScript:void(0)" onclick="help('task','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
    <li id="menuNotes" ><span><h1>
			
			<?php $temp=  (is_numeric($total_notes) && $total_notes>0)?$total_notes:"0"; ?>
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Notes')." <span class='clsCountTrees' id='notesCount'>".$temp."</span>";?></a>
			
			</h1></span>
		<ul>
			
			<?php if($total_notes){ $display = 'inline'; } else {$display='none';}?>
			<li id="notes_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			
			<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<li><a href="<?php echo base_url();?>notes/New_Notes/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('notes','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>
		</ul>
	</li>
	
    <li id="menuContact" ><span><h1>
	<?php $temp=  (is_numeric($total_contacts) && $total_contacts>0)?$total_contacts:"0"; ?>			
				
				<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Contact')." <span class='clsCountTrees' id='contCount'>".$temp."</span>";?></a>
				
				</h1></span>
		<ul>
			<?php if($total_contacts){ $display = 'inline'; } else {$display='none';}?>
			<li id="contact_menu" style="display:<?php echo $display;?>"><a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_List');?></a></li>
			
			<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
			<li><a href="<?php echo base_url();?>contact/editContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $this->lang->line('txt_Create');?></a></li>
			<?php } ?>
			
			<li><a href="javaScript:void(0)" onclick="help('contacts','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	
		</ul>
	</li>
	
	<li id="menuMembers" ><span class="members"><h1>
	
	<?php $temp=  (is_numeric($total_messages) && $total_messages>0)?$total_messages:"0"; ?>		
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Messages')." <span class='clsCountTrees' id='msgCount'>".$temp."</span>";?></a>
			
			</h1></span>
		<ul>
		
		<li><a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?><?php if ($workSpaceId<1 && $userGroup<1) echo '/all';?>"><?php echo $this->lang->line('txt_View');?></a></li>
			
			<li><a href="javaScript:void(0)" onclick="help('members','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	
		</ul>
	</li>
<div class="clr"></div>
</ul>

</div>
<div class="clr"></div>



</div>
<script>
setInterval('getTreeUpdates()',10000);
function getTreeUpdates(){
	var url= "<?php echo base_url();?>workspace_home2/getTreeCountAjax/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>";
	$.post(url,{dataString:'<?php echo $total_documents.",".$total_chats.",".$total_tasks.",".$total_notes.",".$total_contacts.",".$total_messages;?>'},function(data){console.log(data);
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
			}
		}
		//discuss
		if(obj[1].trim()!=0){//alert(obj[1]);
			$('#disCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[1].trim()))
			{ 
				$('#disCount').html(obj[1].trim());
				$('#discuss_menu').css('display', 'inline');
			}
		}
		//tasks
		if(obj[2]!=0){//alert(obj[2]);
			 $('#taskCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[2].trim()))
			{ 
			 	$('#taskCount').html(obj[2].trim());
				$('#task_menu').css('display', 'inline');
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
			 }
		}
		//contacts
		if(obj[4]!=0){//alert(obj[4]);
			 $('#contCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[4].trim()))
			{ 
				$('#contCount').html(obj[4].trim());
			 	$('#contact_menu').css('display', 'inline');
			}
		}
		//messages
		if(obj[5]!=0){//alert(obj[5]);
			 $('#msgCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[5].trim()))
			{ 
			 $('#msgCount').html(obj[5].trim());
			 }
		}
	});
}
</script>