<link href="<?php echo base_url();?>css/jquery.hoverscroll.css" type="text/css" rel="stylesheet" />
	
	
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.hoverscroll.js"></script>
	
	<script type="text/javascript">
	
	$(document).ready(function() {
        // Creating hoverscroll with fixed arrows
		$('#jsddm').hoverscroll({
            fixedArrows: true,
            rtl: false,
			width: 1100
        });
        // Starting the movement automatically at loading
        // @param direction: right/bottom = 1, left/top = -1
        // @param speed: Speed of the animation (scrollPosition += direction * speed)
        var direction =0,
            speed = 3;
        $("#jsddm")[0].startMoving(direction, speed);
	});
	
	</script>
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
			// treeAccess ==1 for all members of work spaces
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