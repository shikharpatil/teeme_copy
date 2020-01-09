	<?php
    $totalNodes = array();
	
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	$i = 1;
	
	if(count($arrDiscussions) > 0)
	{					 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			$editVisibility = 'none';
			$menusVisibility = 'none';	
/*			if($arrVal['nodeId'] == $selectedNodeId)
			{
				$editVisibility = '';
				$menusVisibility = '';
			}*/			
			$arrActivities 			= array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');
			$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
			$arrNodeTaskUsers 		= $this->task_db_manager->getTaskUsers($arrVal['nodeId'], 2);
			$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($arrVal['nodeId']);
			$position++;
			$totalNodes[] 			= $position;
			$userDetails			= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);				
			$checksucc 				= $this->task_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$this->task_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			
			$viewCheck=$this->task_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
			$contributorsTagName		= array();
			$contributorsUserId			= array();
			
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);
			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);
			
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
			
			$_SESSION['tmpcount'] = 0;
			$arrNodes = array();	
			$this->task_db_manager->arrNodes = array();			
			if($checksucc)
			{
				$arrNodes = $this->task_db_manager->getNodesBySuccessor($checksucc);			
				$allNodes = implode(',', $arrNodes);
				$subListTime = $this->task_db_manager->getSubListTime($allNodes);					
			}	
			$taskTitle = $this->lang->line('txt_Task');	
			$editStatus = 1;		
			
			
				
					$nodeBgColor = 'nodeBgColorSelect';
				
			?>	
<div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;"> <!-- Leaf Container starts -->
<span id="latestcontent<?php echo $arrVal['leafId'];?>">
<div style="width:<?php echo $this->config->item('page_width')-50;?>px" class="<?php echo $nodeBgColor;?>">
	<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; margin-top:2px;" id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);" class="<?php echo $nodeBgColor;?> handCursor">
		
		<?php
		if (!empty($leafTreeId) && ($isTalkActive==1))
				{		
					echo '<a href='.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.' target="_blank" class="example7"><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';
				}
			?>	
					
    </div>
	
<?php  if($isTalkActive) {?>	
    <div style="width:70px; float:left" class="<?php echo $nodeBgColor;?>">   
    <p>
	<?php if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i; }	?>
	<?php
	if(!$checksucc)
	{
		$taskTitle = $this->lang->line('txt_Task');
		$editStatus = 0;	
	?>
		&nbsp;&nbsp;
		
		<?php
	}
	else
	{
	?>
    	&nbsp;&nbsp;
        
	<?php
    }
	?>
    </p>
    </div>
    <div style="width:<?php echo $this->config->item('page_width')-120;?>px; float:left;" id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>, <?php echo $arrVal['nodeId'];?>);" class="<?php echo $nodeBgColor;?> handCursor">
 		<?php 
			echo stripslashes($arrVal['contents']); 
		?>
    </div>
    


<?php } ?>
</div>
</span>
<span class="style1" id="add<?php echo $position;?>" style="display:none;"> 
<span id="normalView<?php echo $arrVal['nodeId'];?>">

<div style="width:<?php echo $this->config->item('page_width')-50;?>px;" class="<?php echo $nodeBgColor;?>">
<?php
if(!$checksucc)
{}
else
{
?>    
    
<?php
}
?>
</div>
</span>
</span>



<!-- This is only for New task -->
<?php 
if($arrDiscussionDetails['name'] == 'untitled')
{
?>

<?php
}
?>
			<?php
				#********************************************* Tags ********************************************************88
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
			?>
            	
				
				
				
				
                
					
						
									
				<?php	
				#*********************************************** Tags *******************************************************
				?>

        </div> 
			<?php
			/******* Parv - Start Sub Tasks  ***********/
			if ($checksucc)
			{ 
				require('view_sub_tasks_talk.php');
			}
			/******* Parv - Finish Sub Tasks ***********/
			?>    
		<?php
		$i++;
		
		}		
	}
	?>
	