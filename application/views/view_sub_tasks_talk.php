<?php
if ($this->uri->segment(8))
{
?>
<div id="subTasks<?php echo $arrVal['nodeId'];?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left; margin-bottom:10px;">
<?php
}
else
{
?>
<div id="subTasks<?php echo $arrVal['nodeId'];?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left; margin-bottom:2px;  ">
<?php
}
?>
	<?php 
	if($checksucc)
	{		//print_r($arrparent);	
			$counter = 0;
			
			$rowColor3='rowColor3';
			$rowColor4='rowColor4';	
			$j = 1;
				if ($arrVal['nodeId'])
				{
					$selectedNodeId = $arrVal['nodeId'];
				}		
			$arrChildNodes = $this->task_db_manager->getChildNodes($arrVal['nodeId'], $treeId);	
			$sArray = array();
			//$sArray=explode(',',$arrparent['successors']);
			$sArray = $arrChildNodes;

			while($counter < count($sArray)){

				$arrDiscussions=$this->task_db_manager->getPerentInfo($sArray[$counter]);
				//print_r($arrDiscussions);
				//echo "<li>";
				//print_r ($arrDiscussions);
				$editVisibility = 'none';
				$menusVisibility = 'none';	
/*				if($arrDiscussions['nodeId'] == $selectedNodeId)
				{
					$editVisibility = '';
					$menusVisibility = '';
				}*/
				$position++;
				$totalNodes[] = $position;
				$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc =$this->task_db_manager->checkSuccessors($arrDiscussions['nodeId']);
				$arrActivities = array('Not Completed', '25% Completed', '50% Completed', '75% Completed', 'Completed');
				$arrNodeTaskUsers 	= $this->task_db_manager->getTaskUsers($arrDiscussions['nodeId'], 2);
				$nodeTaskStatus 	= $this->task_db_manager->getTaskStatus($arrDiscussions['nodeId']);
				//	$this->task_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
				//	$viewCheck	= $this->task_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
				$arrNodes = array();	
				$this->task_db_manager->arrNodes = array();		
				
				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrDiscussions['nodeId']);
				$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);				
				
				
				if($checksucc)
				{
					$arrNodes = $this->task_db_manager->getNodesBySuccessor($checksucc);					
					$allNodes = implode(',', $arrNodes);
					$subListTime = $this->task_db_manager->getSubListTime($allNodes);											
				}
									
				
				
				
				
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	
						
						if (!empty($leafTreeId) && ($isTalkActive==1))
						{	
				?>
			<div class="nodeBgColorSelect" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:10px;">
				<span id="latestcontent<?php echo $arrDiscussions['leafId'];?>">
                <div class="nodeBgColorSelect" style="width:<?php echo $this->config->item('page_width')-100;?>px" class="<?php echo $nodeBgColor;?>">
					<span id="img<?php echo $position;?>"></span>
					<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> </span> 
            
					<?php
					
					
					
					
					
						
						
								
							echo '<a href='.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.' target="_blank" class="example7"><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';
										
				
					?>	
				</div>
                <div class="nodeBgColorSelect"  style="width:70px; float:left" class="<?php echo $nodeBgColor;?>">
                	<p>
            		<?php if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i .".".$j; }	?>
					<?php
					if(!$checksucc)
					{		
					?>
						&nbsp;&nbsp;
						
					<?php
					}
					?>
                    </p>
                </div>
				<div   id="editcontent<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-170;?>px; float:left; " class="nodeBgColorSelect handCursor" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);">
					<?php																
 						echo stripslashes($arrDiscussions['contents']);
					?>
                </div>
			</span>
			<div style="clear:both"></div>



<?php
				#********************************************* Tags ********************************************************88
				
                
				
				?>
				</div>
				<?php
				
				}
				 
				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];
				$counter++;
				$j++;
			}		
	}	
	?>
	
</div>