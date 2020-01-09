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
$total_posts		    =$this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0);
//space tree config 
$treeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
$treeWorkSpaceName = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
if($workSpaceId!=0 && $treeWorkSpaceName['workSpaceName']!='Try Teeme') {
	$treeTypeEnabled = 1;	
}
$newtreeTypeIds = $this->identity_db_manager->get_space_tree_type_id($workSpaceId,$workSpaceType,1);
//print_r($total_posts); exit;

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
		//redirect('instance/admin_logout/work_place', 'location');
		//exit;
	}
	//echo "treeaccess= " .$treeAccess; exit;
?> 
<!--Manoj: Showing update notification of place-->

<div class="updateNotifyUsers"></div>

<!--Manoj: code end-->
<div id="artifact_tabs_for_web" style="display:none;">

<div id="menu-nav1">

<ul id="jsddm1">


	<?php if($treeAccess==1  ||  $workSpaceId==0  || in_array($_SESSION['userId'],$managerIds)){ ?>
		<?php if(!empty($newtreeTypeIds) || $workSpaceId==0 || ($treeWorkSpaceName['workSpaceName']=='Try Teeme' && $workSpaceType==1)){ ?>
	<li id="menuCreate" style="width:40px" >
		<span class="home"><h1>
			<a style="padding-left:20%;" id="1" title="<?php echo $this->lang->line('txt_Create_Tree'); ?>" href="<?php echo base_url();?>new_tree/index/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" ><?php //echo $this->lang->line('txt_Create');?>
			<img src="<?php echo base_url();?>images/addnew.png"  title="<?php echo $this->lang->line('txt_Create_Tree'); ?>" style="margin:11px 0 0 10%;cursor:pointer;height:18px;border:0px;" /> 
			</a>
		</h1></span>
	</li>
	<?php }
		else
		{
			$homeClass="home";
		}
	 }
	else
	{
		$homeClass="home";
	} ?>

	<li id="menuHome" class="jsddm1Li"><span class="<?php echo $homeClass; ?>"><h1>
				
				<a href="<?php echo base_url(); ?>dashboard/index/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType ; ?>/1"><?php echo $this->lang->line('txt_Home');?></a>
				
				</h1></span>
	</li>
	<li id="menuDocument" class="jsddm1Li" <?php if(!(in_array('1',$treeTypeIds)) && $treeTypeEnabled==1 || $total_documents==0) { ?> style="display:none;" <?php }  ?> ><span ><h1>
				
				
				<?php $temp=(is_numeric($total_documents) && $total_documents>0)?$total_documents:"0"; ?>
				
				<a href="<?php echo base_url();?>document_home/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Document')." <span class='clsCountTrees' id='docCount'>".$temp."</span>"; ?></a>
				
				
		</h1></span>
	</li>
	
	<li id="menuDiscuss" class="jsddm1Li" <?php if(!(in_array('3',$treeTypeIds)) && $treeTypeEnabled==1 || $total_chats==0) { ?> style="display:none;" <?php } ?> ><span><h1>
				
		<?php $temp=  (is_numeric($total_chats) && $total_chats>0)?$total_chats:"0"; ?>		
				
				<a href="<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Chat')." <span class='clsCountTrees' id='disCount'>".$temp."</span>"; ?></a>
				
				</h1></span>
	</li>
	
	<li id="menuTask" class="jsddm1Li" <?php if(!(in_array('4',$treeTypeIds)) && $treeTypeEnabled==1 || $total_tasks==0) { ?> style="display:none;" <?php }?> ><span><h1>
			<?php $temp=  (is_numeric($total_tasks) && $total_tasks>0)?$total_tasks:"0"; ?>		
				
				<a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Task')." <span class='clsCountTrees' id='taskCount'>".$temp."</span>";?></a>
				
			</h1></span>
		<?php /*?><ul>
			
			<li><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0"><?php echo $this->lang->line('txt_Calendar');?></a></li>
			
		</ul><?php */?>
	</li>
	
    <li id="menuNotes" class="jsddm1Li" <?php if(!(in_array('6',$treeTypeIds)) && $treeTypeEnabled==1 || $total_notes==0) { ?> style="display:none;" <?php }?>><span><h1>
			
			<?php $temp=  (is_numeric($total_notes) && $total_notes>0)?$total_notes:"0"; ?>
			
			<a href="<?php echo base_url();?>periodic_notes/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Notes')." <span class='clsCountTrees' id='notesCount'>".$temp."</span>";?></a>
			
			</h1></span>
		
	</li>
	
    <li id="menuContact" class="jsddm1Li" <?php if(!(in_array('5',$treeTypeIds)) && $treeTypeEnabled==1 || $total_contacts==0) { ?> style="display:none;" <?php } ?>><span><h1>
	<?php $temp=  (is_numeric($total_contacts) && $total_contacts>0)?$total_contacts:"0"; ?>			
				
				<a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" ><?php echo $this->lang->line('txt_Contact')." <span class='clsCountTrees' id='contCount'>".$temp."</span>";?></a>
				
				</h1></span>
		
	</li>
	
	<li id="menuPost" class="jsddm1Li">
		<span><h1>
		<?php $temp=  (is_numeric($total_posts) && $total_posts>0)?$total_posts:"0"; ?>
			<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>" ><?php echo $this->lang->line('txt_Post')." <span class='clsCountTrees' id='postCount'>".$temp."</span>";?></a>
			<?php /*?><a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $_SESSION['userId']; ?>" ><?php echo $this->lang->line('txt_Post')." <span class='clsCountTrees' id='postCount'>".$temp."</span>";?></a><?php */?>
		</h1></span>
	</li>
	
	<li id="menuHelp" style="width:40px;">
		<span><h1>
			<a style="padding-left:20%;" title="Help" href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>" target="_blank" ><?php //echo $this->lang->line('txt_Help');?>
			<img src="<?php echo base_url();?>images/help_icon.png"  title="Help" style="margin:11px 0 0 10%;cursor:pointer;height:18px;border:0px;" />
			</a>
		</h1></span>
	</li>
	
	<!--Message start here-->
	<?php /*?><li id="menuMembers" ><span class="members"><h1>
	
	<?php $temp=  (is_numeric($total_messages) && $total_messages>0)?$total_messages:"0"; ?>		
			
			<a href="javaScript:void(0)" ><?php echo $this->lang->line('txt_Messages')." <span class='clsCountTrees' id='msgCount'>".$temp."</span>";?></a>
			
			</h1></span>
		<ul>
		
		<li><a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?><?php if ($workSpaceId<1 && $userGroup<1) echo '/all';?>"><?php echo $this->lang->line('txt_View');?></a></li>
			
			<li><a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=msg" target="_blank" onclick="help('members','<?php echo $workSpaceId;?>','<?php echo $workSpaceType;?>')"><?php echo $this->lang->line('txt_Help');?></a></li>	
		</ul>
	</li><?php */?>
	<!--Message end here-->
	
<div class="clr"></div>
</ul>

</div>
<div class="clr"></div>



</div>

<!--Manoj: code end-->


<script>
//setInterval('getTreeUpdates()',10000);
/*$(document).ready(function() {
   checkUpdateStatus();
});*/

/*setInterval(function () {
	getTreeUpdates()
	//checkUpdateStatus()		
}, 10000);*/

//Add SetTimeOut 
setTimeout("getTreeUpdates()", 10000);

/*setInterval(function () {
    //getTreeUpdates();
}, 5000);
*/

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
		
		//messages
		/*if(obj[5]!=0){//alert(obj[5]);
			$('#msgCount').css({'background': 'none repeat scroll 0 0 green','color':'white'});
			if (!isNaN(obj[5].trim()))
			{ 
			 $('#msgCount').html(obj[5].trim());
			 }
		}*/
		//Add SetTimeOut 
		setTimeout("getTreeUpdates()", 10000);
	});
}
//Manoj: Check update for notify users

/*setInterval(function () {
    //checkUpdateStatus();
}, 5000);*/

function checkUpdateStatus()
{
	 $.ajax({

				url: baseUrl+'auto_update/check_update',

				success:function(result)
				{
					//alert(result);
					
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