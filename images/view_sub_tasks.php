<?php
				if ($this->uri->segment(8))
					{
				?>	

				
				
			<div id="subTasks<?php echo $arrVal['nodeId'];?>"  >	
			<?php 
			}
			else
			{
			    ?>
		
			<div id="subTasks<?php echo $arrVal['nodeId'];?>" style="display:none"  >				
				<?php
			}
			?>

	<?php 
	if($checksucc)
	{		//print_r($arrparent);	
			$counter = 0;
			
			$rowColor3=$nodeBgColor;
			$rowColor4=$nodeBgColor;	
			$j = 1;
			if ($arrVal['nodeId'])
			{
				$selectedNodeId = $arrVal['nodeId'];
			}		
			$arrChildNodes = $this->task_db_manager->getChildNodes($arrVal['nodeId'], $treeId);
			
			//$sArray = array();
			//$sArray=explode(',',$arrparent['successors']);
			
			$sArray = $arrChildNodes;
			
             
			while($counter < count($sArray)){

				$arrDiscussions=$this->task_db_manager->getPerentInfo($sArray[$counter]);
				
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
				$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

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
									
				$arrStartTime 		= explode('-',$arrDiscussions['starttime']);
				$arrEndTime 		= explode('-',$arrDiscussions['endtime']);
				$contributors 				= $this->task_db_manager->getTaskContributors($arrDiscussions['nodeId']);
				$contributorsTagName		= array();
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsTagName[] 	= $userData['userTagName'];
					$contributorsUserId[] 	= $userData['userId'];	
				}	
				$taskTitle = $this->lang->line('txt_Task');	
				$editStatus = 0;	
				
				
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;		
				?>
				
		<div   style="width:935px; padding-left:40px; float:left; border-bottom:2px dotted #ffffff; " onClick="showNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseover="showNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"  onmouseout="hideNotesNodeOptions(<?php echo $arrDiscussions['nodeId'];?>)"    class="<?php echo $nodeBgColor."1";?> handCursor" >		
			<div style="width:930px; height:25px; " > 
				
				
					<ul id="ulNodesHeader<?php echo $arrDiscussions['nodeId']; ?>" style="float:right; display:none " class="content-list ulNodesHeader">
					
					
					<?php

					// arun put tag name  here
					//$headerContent='<div style="float:left;"><div style="float:left;">'.$leafData->tagName.'&nbsp;</div><div style="float:left;">';
	$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrDiscussions["nodeId"]); 
					
					if($totalVersion > 0)
				{	
					$headerContent='';
					
                  ?>
					<li><a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrDiscussions["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,480,null,'')"  title="<?php echo $this->lang->line('txt_History');?>"  ></a></li>
				
				<?php					
				
					
				}	
			 ?>	
			 
			
			<?php
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				
					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'], 2);		
					
					
						
				
						
					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
					if($total==0)
					{
						$total='';
						$tag_container=$this->lang->line('txt_None');
					}
					else
					{
						
						     if(count($viewTags)>0)
							 {
								$tag_container='Simple Tag : ';
								foreach($viewTags as $simpleTag)
								$tag_container.=$simpleTag['tagName'].", ";
								$tag_container=substr($tag_container, 0, -2).
""; 
							 
							}
							
												
							if(count($actTags) > 0)
								{
								   $tag_container.='Action Tag : ';
									$tagAvlStatus = 1;	
									foreach($actTags as $tagData)
									{	$dispResponseTags='';
										$dispResponseTags = $tagData['comments']."[";							
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if(!$response)
										{  
											
											if ($tagData['tag']==1)
												$dispResponseTags .= $this->lang->line('txt_ToDo');									
											if ($tagData['tag']==2)
												$dispResponseTags .= $this->lang->line('txt_Select');	
											if ($tagData['tag']==3)
												$dispResponseTags .= $this->lang->line('txt_Vote');
											if ($tagData['tag']==4)
												$dispResponseTags .= $this->lang->line('txt_Authorize');															
										}
										$dispResponseTags .= "], ";	
															
										
										
										$tag_container.=$dispResponseTags;
									}
									
									$tag_container=substr($tag_container, 0, -2).
""; 
								}
								
								
								if(count($contactTags) > 0)
									{
										$tag_container.='Contact Tag : ';
										$tagAvlStatus = 1;	
										foreach($contactTags as $tagData)
										{
											
											$tag_container .= strip_tags($tagData['contactName'],'').", ";	
											
										}
										
										$tag_container=substr($tag_container, 0, -2); 
									}		
							
					}
						
				?>
			<li><a id="liTag<?php echo $arrDiscussions['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrDiscussions['nodeId'] ; ?>/2', 710, 480, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>	
			
				<?php				
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7);
				
				$appliedLinks=' ';
				
				if($total==0)
					{
						$total='';
						$appliedLinks=$this->lang->line('txt_None') ;
					}
					else
					{
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
							}	
							
							
							 if(count($docTrees3)>0)
						   {
								$appliedLinks.=$this->lang->line('txt_Chat').': ';	
								foreach($docTrees3 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
							}	
							
							if(count($docTrees4)>0)
							{
							
								$appliedLinks.=$this->lang->line('txt_Task').': ';	
								foreach($docTrees4 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
							}	
							
							if(count($docTrees6)>0)
							{
								$appliedLinks.=$this->lang->line('txt_Notes').': ';	
								foreach($docTrees6 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
								}
							}
							
							if(count($docTrees5)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
								foreach($docTrees5 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
							
							}
							
							if(count($docTrees7)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
									 
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
							         
									 if($linkData['docName']=='')
									 {
									    $appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
									 }
									 else
									 {
									 	$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 }
									
								}
							
								}
							}	
							
							$appliedLinks=substr($appliedLinks, 0, -2); 
						
					}
					
					?>	
					
					<li  ><a id="liLink<?php echo $arrDiscussions['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrDiscussions['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/0', 750, 430, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>	
					
					
				<?php
				
				    $total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
					if($total==0)
					{
						$total='';
					}
					
					//if (!empty($leafTreeId) && ($isTalkActive==1))
					{		
						echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.$this->lang->line("txt_Talk").'" border="0" >'.$total.'</a></li>';
					}

					$lastnode=$arrVal['nodeId'];

					?>
				
				   
			            </ul>
		    
				</div>
				<div id="latestcontent<?php echo $arrDiscussions['leafId'];?>">
                
					<span id="img<?php echo $position;?>"></span>
					<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> </span> 
            
					
					
		<div style="width:800px; min-height:20px;">
				<div style="float:left;width:70px; margin-left:30px;" >
            		<?php if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i .".".$j; }	?>
					<?php
					if(!$checksucc)
					{		
					?>
						&nbsp;&nbsp;
						<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
					<?php
					}
					?>
                    </div>
					
					<div id="editcontent<?php echo $position;?>" style="width:px; float:left;  " class="handCursor" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);">
					<?php																
 						echo stripslashes($arrDiscussions['contents']);
					?>
                </div>
				</div>
				
				<div style="height:35px;" >
                <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrDiscussions['nodeId'];?>"  style="  width:900px;"    >&nbsp;
					 <div id="normalView<?php echo $arrDiscussions['nodeId']; ?>"   style="width:900px;   " >
					<span style="margin-right:30px;" >
					<?php echo $userDetails['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['editedDate'], $this->config->item('date_format'));?>
					</span>
					
					
					<?php
		if(in_array($_SESSION['userId'], $SeedContributorsUserId) )
		{
		
	/*onclick="showPopWin('<?php echo base_url(); ?>new_task/leaf_edit_Task/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>', 750, 430, null, '');" 
	*/
	
	/* privious code- function call for edit sub task 
	
	onClick="editthis12(<?php echo $arrDiscussions['leafId'];?>, <?php echo $position ;?>, <?php echo $treeId;?>, <?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>);"
	
	*/
	
	
	
	?>	
		<a  onclick="showPopWin('<?php echo base_url(); ?>new_task/edit_sub_task/<?php echo $arrDiscussions['leafId']; ?>/<?php echo $arrDiscussions['nodeId'];?>/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>', 750, 430, null, '');"   ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>
       
		
		
		<?php } ?>
						 
				</div>
				
				
				</div>
				</div>
			</div>
			<div style="clear:both"></div>

<div id="normalView<?php echo $arrDiscussions['nodeId'];?>">
<div id="detail<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; display:<?php echo $menusVisibility;?>;" class="<?php echo $nodeBgColor;?>">
	<div id="add<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left; display:none;" class="<?php echo $nodeBgColor;?> style1">
<?php


if(!$checksucc)
{
	echo '<span class="style1">'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';
}
?>

<?php 
if(!$checksucc)
{
	if($arrStartTime[0] != '00')
	{
		?>
	&nbsp;&nbsp;&nbsp;<span class="style1">
	<?php
		echo $this->lang->line('txt_Start').': '.$arrDiscussions['starttime'];?></span>
	<?php
	}
	if($arrEndTime[0] != '00')
	{
		?>
	&nbsp;&nbsp;&nbsp;<span class="style1">
	<?php
		echo $this->lang->line('txt_End').': '.$arrDiscussions['endtime'];?></span>
	<?php
	}
}
else
{
	if($subListTime['listStartTime'] != '')
	{
		?>
	&nbsp;&nbsp;&nbsp;<span class="style1">
	<?php
		echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>
	<?php
	}
	if($subListTime['listEndTime'] != '')
	{
		?>
	&nbsp;&nbsp;&nbsp;<span class="style1">
	<?php
		echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>
	<?php
	}
}
?>  
    </div>



</div>
</div>

                
				
												
				<?php	
				#*********************************************** Tags ********************************************************	
				
				?>
				</div>
				<?php
				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];
				$counter++;
				
				$j++;
			}		
	}	
	?></div>
	
