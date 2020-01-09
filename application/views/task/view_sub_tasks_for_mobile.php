<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<?php  

   

			if ($this->uri->segment(8))

			{

			?>	



				

				

			<!--<div id="subTasks<?php echo $arrVal['nodeId'];?>"    >	-->

			<?php 

			}

			else

			{

			/*

			 

			    ?>

		   

			<div id="subTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)){ echo 'style="display:block" '; } else { echo 'style="display:none" ';  }  ?>  >				

				<?php*/

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

			

             $subDisplay=0;

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

				//echo "<li>arrstart= " .$arrDiscussions['starttime'];		
				//echo "<li>timediff= " .$_SESSION['timeDiff'];			

				$arrStartTime 		= explode('-',$arrDiscussions['starttime']);

				$arrEndTime 		= explode('-',$arrDiscussions['endtime']);
				
				$arrDiscussions['starttime']		= $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['starttime'], $this->config->item('date_format'));
				
				$arrDiscussions['endtime'] = $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['endtime'], $this->config->item('date_format'));
				
				//echo "<li>after= " .$arrDiscussions['starttime'];	
				//echo "<hr>";

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

				

				

					if ($arrDiscussions['nodeId'] == $this->uri->segment(8) ){

						$nodeBgColor = 'nodeBgColorSelect';

					}

					else{

						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	

					}

					

				?>

		<?php
			if (in_array($this->uri->segment(8),$successor_array))
			{
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
		?>		
		<!--Removed onclick function-->
		<div style="width:100%;display:<?php echo $display;?>;" onmouseover="showTaskNodeOptions(<?php echo $arrDiscussions['nodeId'];?>,'<?php echo $arrDiscussions['predecessor'];?>')"  onmouseout="hideTaskNodeOptions(<?php echo $arrDiscussions['nodeId'];?>,'<?php echo $arrDiscussions['predecessor'];?>')"    class="<?php echo $nodeBgColor."1";?> handCursor subTasks<?php echo $arrVal['nodeId'];?>" id="subTaskLeafContent<?php echo $arrDiscussions['nodeId']; ?>" >		

			<div style="width:97%; height:20px; " > 

				
		
				<div id="ulNodesHeader<?php echo $arrDiscussions['nodeId']; ?>" class=" ulNodesHeader" style="display:none">


			<div style="float:left; width:100%;" >
				

					<ul  style="float:right;  margin-bottom:0px; " class="content-list">

					<?php



					// arun put tag name  here

					//$headerContent='<div style="float:left;"><div style="float:left;">'.$leafData->tagName.'&nbsp;</div><div style="float:left;">';

					$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrDiscussions["nodeId"]); 

					

					if($totalVersion > 0)

					{	

					$headerContent='';

					

                  ?>

					<li><a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrDiscussions["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')"  title="<?php echo $this->lang->line('txt_History');?>"  ></a></li>

				

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

					

					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrDiscussions['nodeId'], 2);			

					

					

						

				

						

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

								$tag_container=substr($tag_container, 0, -2)."

"; 

							 

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

									

									$tag_container=substr($tag_container, 0, -2)."

"; 

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

			<li><a id="liTag<?php echo $arrDiscussions['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrDiscussions['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>	

			

				<?php				

				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);

				

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

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							}	

							

							

							 if(count($docTrees3)>0)

						   {

								$appliedLinks.=$this->lang->line('txt_Chat').': ';	

								foreach($docTrees3 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							}	

							

							if(count($docTrees4)>0)

							{

							

								$appliedLinks.=$this->lang->line('txt_Task').': ';	

								foreach($docTrees4 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							}	

							

							if(count($docTrees6)>0)

							{

								$appliedLinks.=$this->lang->line('txt_Notes').': ';	

								foreach($docTrees6 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

								}

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							}

							

							if(count($docTrees5)>0)

							{

							

								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	

								foreach($docTrees5 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							

							}

							

							if(count($docTrees7)>0)

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

								$appliedLinks=substr($appliedLinks, 0, -2)."

"; 

							}	

							

							if(count($docTrees9	)>0)

									{

									

										$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	

										foreach($docTrees9 as $key=>$linkData)

									   {

											 $appliedLinks.=$linkData['title'].", ";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2);

									

									}

						

					}

					

					?>	

					

					<li  ><a id="liLink<?php echo $arrDiscussions['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrDiscussions['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 690, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>	

					

					

				<?php

				

				    $total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

					/*<!--Added by Surbhi IV -->	*/

					$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

					if(strip_tags($talk[0]->contents))

					{

						$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

						$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

					}

					else

					{

						$latestTalk='Talk';

					}

					/*<!--End of Added by Surbhi IV -->	*/

					if($total==0)

					{

						$total='';

					}

					

					//if (!empty($leafTreeId) && ($isTalkActive==1))

					{		

						/*<!--changed by Surbhi IV -->	*/

						echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';

						/*<!--End of cahnged by Surbhi IV -->	*/

					}



					$lastnode=$arrVal['nodeId'];



					?>

				<input type="hidden" value="<?php echo $arrDiscussions['predecessor'];?>" name="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>" id="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>"/>

				   

			            </ul>

		    

				</div>

			<div class="clr"></div>

			</div>

            </div>

			<div class="clr"></div>

				<div id="latestcontent<?php echo $arrDiscussions['leafId'];?>">

                

					<span id="img<?php echo $position;?>"></span>

					<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> </span> 

            

					

					

		<div style="width:100%; max-height:2%;">

				<div style="float:left;padding-left:3%;padding-right:4%;" >

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

					

				<div id="editcontent<?php echo $position;?>" style="width:63%; float:left; font-size:0.8em; " class="handCursor <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);">

					<?php																

 						echo stripslashes($arrDiscussions['contents']);

					?>

                </div>

				

				
		<div class="clr"></div>
				<div id="TaskInfo<?php echo $arrDiscussions['nodeId'];?>"  style=" font-style:italic " class="TaskInfo" ><?php

if(!$checksucc)

{

	

	if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')

	{

	

	?>

	  <div  style="min-height:20px;">

	  <?php

	

	if($arrStartTime[0] != '00')

	{
		?>

		&nbsp;&nbsp;&nbsp;

		<span class="style2" style="float:left; width:180px;" >

		<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 

			<?php echo $arrDiscussions['starttime'];?>&nbsp;</span>

	<?php

	}

	if($arrEndTime[0] != '00')

	{

	?>

		&nbsp;&nbsp;&nbsp;

		<span class="style2" style="float:left; width:180px;" >

		<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 

		<?php echo $arrDiscussions['endtime'];?>&nbsp;</span>

	<?php

	}

	?> 

	</div>

	<?php

	}

}

else

{



	if($subListTime['listStartTime'] != '' || $subListTime['listEndTime'] != '' )

	{

	    ?>

		<div  style="min-height:20px; margin-left:5%;">

		<?php

			if($subListTime['listStartTime'] != '')

			{

				?>

			&nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:100%;">

			

			<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 

			<?php

				echo $subListTime['listStartTime'];?></span>

			<?php

			}

			if($subListTime['listEndTime'] != '')

			{

				?>

			&nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:100%;">

			<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 

			<?php

				echo $subListTime['listEndTime'];?></span>

			<?php

			}

			

			?></div><?php

			}

	

}

?>





			

			

			<?php

if(!$checksucc && count($contributorsTagName)>0)

{

 echo "<div class='clr'></div>";



      if(count($contributorsTagName)>8)

	  {

	   echo '<div class="label2" style="width:80%;" >';

	  	echo '<div  >';

		echo '<div style="display:block; float:left; padding-top:5px; font-size:11px; " class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrDiscussions['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

		

	  

	 

	  

	 	echo '</div>';

	 	echo '</div>';

	  }

	  else

	  {
?>
			<!--Start Manoj: Create Assignee list hyperlinked -->
			
			<div style="margin-top:10px; margin-left:1%;">
			<?php echo '<div class="style2" style=" width:auto;" >'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].'</div>';
			
			if(count($contributorsTagName)>1)
			 {
			 	?>
				<a id="seeAll<?php echo $arrDiscussions['nodeId']; ?>" style="padding: 0 4%; font-size: .8em; width: 85%;" onclick="show_assignee(<?php echo $arrDiscussions['nodeId']; ?>)"> <?php echo $this->lang->line('see_all_txt'); ?> </a>
			  <?php
			  // echo implode(', ',$contributorsTagName);
			 }
			
			?>
	  		

			<div class="style2<?php echo $arrDiscussions['nodeId']; ?>" style="margin-left:5px; display:none; color: #999999; font-size: .8em; width: 85%;"  >
			<?php
			 
			 array_shift($contributorsTagName);
			 echo implode(', ',$contributorsTagName);
			
			?>
			
			</div>
			
			</div>
		
			<!--End Manoj: Create Assignee list hyperlinked -->
<?php
			// echo '<div class="label2" style="margin-left:7%; width:80%;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</div>';

		

	  }

   



}

?>

</div></div>

				<div class="clr"></div>

				<div style="height:20px;" >

				<div style="float:left; width:80%; height:30px;margin-left:5%;">

					<div style=" margin-top:12px; border-bottom:1px dotted gray; "></div>

					

					</div>

                <div class=" lblNotesDetails normalView" id="normalView<?php echo $arrDiscussions['nodeId'];?>" style=" width:88%; text-align:right;  float:left; text-align:right; display:none;">				
					<div style="float:left;width:100%;">
						<span  class="clsLabel" style="clear:both;float:left;margin-left:3%;">
						<div>
						<?php echo $userDetails['userTagName'];
						 if(strlen($userDetails['userTagName'])>15)
					  {
					  ?>
					  </div>
					  <div style="text-align: left; margin-top: 5px; margin-bottom: 10px;">
					  
					  <?php }
						
						 //Start Manoj: Remove date suffix and current year
						 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
						 $Create_date = explode(' ',$Create_date);
						 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
						 $current_year = date("y");
						 if($current_year == $Create_date[2])
						 {
							$Create_date[2]=" ";
						 }
						 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
						 
						 //End Manoj: Remove date suffix
							
					//echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['editedDate'], $this->config->item('date_format'));
					?>
						</div>
						
	
						</span>
						<div>
						<?php
							if(in_array($_SESSION['userId'], $SeedContributorsUserId) )
							{
							?>	
								&nbsp;&nbsp;<a onclick="editSubTask(<?php echo $arrDiscussions['leafId']; ?>,<?php echo $arrDiscussions['nodeId'];?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['nodeId'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>
					
						<?php } ?>
						</div>
					</div>
				</div>

				<div class="clr"></div>

				

				</div>

				

				</div>

			
			<div style="clear:both"></div>



			<?php	

				#*********************************************** Tags ********************************************************	

				

				?>

				</div>
				<div id="divEditSubTask<?php echo $arrDiscussions['leafId']; ?>"  name="divEditSubTask<?php echo $arrDiscussions['leafId']; ?>" class="clsEditTask" style="display:none" ></div>
				
				<div id="loader<?php echo $arrDiscussions['nodeId']; ?>"></div>
				
				<?php

				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];

				$counter++;

				

				$j++;

			}		

	}	

	?><!--</div>-->

	

