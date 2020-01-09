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

	<!--Added by Dashrath- seperate subtask -->
	<hr style="float: left;width: 100%;" class="hrNewUi">
	<!--Dashrath- code end-->

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

		
			/*Added by Dashrath- sub task nodeId Array sort according starttime and endtime*/
			if(count($arrChildNodes) > 0)
			{
				$arrChildNodes = $this->task_db_manager->subTaskNodeIdArraySortAccordingDatetime($arrChildNodes);
			}
			/*Dashrath- code end*/

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

				
					//Manoj: added extra condition of nodeid for search result link
					$searchOffset = '';
					if ($arrDiscussions['nodeId'] == $this->input->get('node'))
					{
						$searchOffset = 'searchOffset';
					}
				

					if ($arrDiscussions['nodeId'] == $this->uri->segment(8) || $arrDiscussions['nodeId'] == $this->input->get('node')){

						$nodeBgColor = 'nodeBgColorSelect';

					}

					else{

						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	

					}

					

				?>

		<?php
			if (in_array($this->uri->segment(8),$successor_array) || in_array($this->input->get('node'),$successor_array))
			{
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
		?>		
		<!--Removed onclick function-->
		<!-- changed by dashrath- change div for new ui-->
		<!-- <div style="width:100%;display:<?php echo $display;?>;" onmouseover="showTaskNodeOptions(<?php echo $arrDiscussions['nodeId'];?>,'<?php echo $arrDiscussions['predecessor'];?>')"  onmouseout="hideTaskNodeOptions(<?php echo $arrDiscussions['nodeId'];?>,'<?php echo $arrDiscussions['predecessor'];?>')"    class="<?php echo $nodeBgColor."1";?> handCursor subTasks<?php echo $arrVal['nodeId'];?> <?php echo $searchOffset; ?>" id="subTaskLeafContent<?php echo $arrDiscussions['nodeId']; ?>" > -->

		<!--Changed by Dashrath- add padding:0 in div inline css for ui issue when subtask highlight from calendar-->
		<div style="width:100%;display:<?php echo $display;?>; padding: 0;" class="<?php echo $nodeBgColor."1";?> handCursor subTasks<?php echo $arrVal['nodeId'];?> <?php echo $searchOffset; ?>" id="subTaskLeafContent<?php echo $arrDiscussions['nodeId']; ?>" tabindex="0">		

			<!-- <div style="width:97%; height:20px; " > 

				
		
				<div id="ulNodesHeader<?php echo $arrDiscussions['nodeId']; ?>" class=" ulNodesHeader" style="display:inline;">


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

					

					if($total==0)

					{

						$total='';

					}

					

					//if (!empty($leafTreeId) && ($isTalkActive==1))

					{		

						

						//echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
						
							$leafdataContent=strip_tags($arrDiscussions['contents']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrDiscussions['contents'], ENT_QUOTES);

					?>
					
					<li  class="talk"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrDiscussions['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
					<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
					<input type="hidden" value="<?php echo $arrDiscussions['predecessor'];?>" name="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>" id="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>"/>
					<?php

						

					}



					$lastnode=$arrVal['nodeId'];



					?>

				

				   

			            </ul>

		    

				</div>

			<div class="clr"></div>

			</div>

            </div> -->

			<div class="clr"></div>

				<div id="latestcontent<?php echo $arrDiscussions['leafId'];?>">

                

					<span id="img<?php echo $position;?>"></span>

					<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> </span> 

            

					

					
		 <!--Changed by Dashrath- change width:100% to width:97% in div inline css for content ui issue--> 
		<div style="width:97%; max-height:2%; padding-left:3%;">

				<div style="float:left; padding-right: 20px;" >

            		<?php if ($arrDiscussionDetails['autonumbering']==1) { echo "# ".$i .".".$j; }	?>

					<!-- <?php

					if(!$checksucc)

					{		

					?>

						&nbsp;&nbsp;

						<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">

					<?php

					}

					?> -->

                    </div>

                    <!--Added by Dashrath- show completion status icon-->
                    <div style="float:left; padding-right: 20px;" >
						<?php
							if(!$checksucc)
							{		
							?>
								<img class="taskCompleteStatusIcon" src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
							<?php
							}
							?>
					</div>
					<!--Dashrath- code end-->

					
                <!--Changed by Dashrath- remove width:63% from div inline css for image stretch issue in comments-->
                <!--Changed by Dashrath- remove font-size:0.8em; and add max-width: 90%;from div inline css-->  
				<div id="editcontent<?php echo $position;?>" style="float:left; max-width: 90%;" class="handCursor <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?> leaf_contents<?php echo $arrDiscussions['nodeId'];?>" onClick="showdetail(<?php echo $position;?>,<?php echo $arrDiscussions['nodeId'];?>);">

					<!-- Added by Dashrath : check delete leaf -->
			        <?php 
			        if($arrDiscussions['leafStatus'] !='deleted'){
			        	/*Commented old code and add new code below for audio icon show when content is audio*/
			          	// echo stripslashes($arrDiscussions['contents']);
			          	
			          	/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
						$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrDiscussions['contents']);
						$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrDiscussions['contents']);
						
						if($audioContainsMatch1 && $audioContainsMatch2)
						{
						?>	
							<span class="cursor" onclick="audioContentHideShow('<?php echo $arrDiscussions['nodeId'];?>')">
								<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
							</span>
							<span id='audio_contents<?php echo $arrDiscussions['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrDiscussions['contents']);?></span>
						<?php
						}
						else
						{
							echo stripslashes($arrDiscussions['contents']);
						}
						/*Dashrath- code end*/
			        }else{ ?>
			          <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
			        <?php 
			    	} ?>
		    		<!-- Dashrath : code end -->

                </div>

				

				
		<div class="clr"></div>

				<!-- <div id="TaskInfo<?php echo $arrDiscussions['nodeId'];?>"  style=" margin-left:5%; font-style:italic " class="TaskInfo" ><?php

if(!$checksucc)

{

	

	if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')

	{

	

	?>

	  <div  style="min-height:20px; margin-left:50px;">

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

 // echo "<div class='clr'></div>";



      if(count($contributorsTagName)>8)

	  {

	 //    echo '<div class="label2" style="width:80%;" >';

	 //  	echo '<div  >';

		// echo '<div style="display:block; float:left; padding-top:5px; " class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrDiscussions['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

		

	  

	 

	  

	 	// echo '</div>';

	 	// echo '</div>';

	  }

	  else

	  {

			 // echo '<div class="label2" style="margin-left:7%; width:80%;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</div>';

		

		}

   



}

?>









					

			</div> -->
		</div>

				<div class="clr"></div>

				<!-- <div style="height:20px;" >

				<div class="subtaskdottedLine" style="float:left;width:<?php echo ($_COOKIE['ismobile'])?"25%":"70%";?>;height:30px;margin-left:5%;">

					<div style=" margin-top:12px; border-bottom:1px dotted gray; "></div>

					

					</div>

                <div class=" lblNotesDetails normalView subtasknormalView" id="normalView<?php echo $arrDiscussions['nodeId'];?>" style=" width:<?php echo ($_COOKIE['ismobile'])?"70%":"25%";?>; text-align:right;  float:left; text-align:right; display:inline;">				
					<div style="float:left;width:100%;">
						<span  class="clsLabel" style="clear:both;float:left;margin-left:9%;">
						<?php echo $userDetails['userTagName'];?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['editedDate'], $this->config->item('date_format'));?>
						<?php
							if(in_array($_SESSION['userId'], $SeedContributorsUserId) )
							{
							?>	
								&nbsp;&nbsp;<a style="cursor:pointer;" onclick="editSubTask(<?php echo $arrDiscussions['leafId']; ?>,<?php echo $arrDiscussions['nodeId'];?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['nodeId'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>
					
						<?php } ?>
	
						</span>
					</div>
				</div>

				<div class="clr"></div>

				

				</div> -->

				

				</div>

			
			<div style="clear:both"></div>


		<!-- task leaf footer start -->
		<div class="commonSeedFooter">
			<!-- footer left content start -->
			<div class="commonSeedFooterLeftTask" style="width:13%;margin-left:3%;">

				<!--Commented by Dashrath- comment completion status icon because this is shift before subtask starting-->
				<!-- task status show image start-->
		        <!-- <span class="commonSeedLeafSpanLeft">
		        	<?php
					if(!$checksucc)
					{		
					?>
						<img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
					<?php
					}
					?>
		        </span> -->
		        <!-- task status show image end-->

				<!-- edit task span start -->
		        <span class="commonSeedLeafSpanLeft">

		        	<?php if($treeDetail['autonumbering']==1) 
		        	{ 
		        		$editIconDiv = 'editIconDiv3'; 
		        	}
		        	else
		        	{
		        		$editIconDiv = 'editIconDiv4'; 
		        	}
		        	?>


		        	<div class="normalView subtasknormalView <?php echo $editIconDiv;?>" id="normalView<?php echo $arrDiscussions['nodeId'];?>" style="display:inline;">

        				<?php
						if(in_array($_SESSION['userId'], $SeedContributorsUserId) )
						{
						?>	
							<!--Commented by Dashrath- comment old code and add new code below for edit sub task open in popup with onclick function change-->
							<!-- <a style="cursor:pointer;" onclick="editSubTask(<?php echo $arrDiscussions['leafId']; ?>,<?php echo $arrDiscussions['nodeId'];?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['nodeId'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a> -->

							<!--Added by Dashrath- Add new code with onclick function change-->
							<a style="cursor:pointer;" onclick="editSubTaskNew(<?php echo $arrDiscussions['leafId']; ?>,<?php echo $arrDiscussions['nodeId'];?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['nodeId'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>
							<!--Dashrath- code end-->
				
						<?php 
						}
						else
						{
						?>
						&nbsp;
						<?php
						} 
						?>
            		</div>
		        </span>
		        <!-- edit task span end -->

			</div>
			<!-- footer left content end -->

			<!-- footer right content start -->
			<div class="commonSeedFooterRightTask">
				<!-- tag link talk content start-->
      			<span class="commonSeedLeafSpanRight">
					<ul id="ulNodesHeader<?php echo $arrDiscussions['nodeId']; ?>" class="content-list ulNodesHeader" style="display:inline; float: right;margin: 0 0 0 0;">
           		 		<!-- <?php

						$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrDiscussions["nodeId"]); 

						if($totalVersion > 0)
						{	

							$headerContent='';
	                  	?>

							<li class="tagLinkTalkSeedLeafIcon">
								<a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrDiscussions["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')"  title="<?php echo $this->lang->line('txt_History');?>"  ></a>
							</li>

						<?php					
						}	
			 			?>	 -->

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

						/*Added by Dashrath- used for display linked folder count*/
						$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($arrDiscussions['nodeId'], 2);
						/*Dashrath- code end*/

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

						<li class="tagLinkTalkSeedLeafIcon">
							<a id="liTag<?php echo $arrDiscussions['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrDiscussions['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong>
							</a>
						</li>	

						<?php				
						/*Changed by Dashrath- add $docTrees10 for total*/
						$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);

				
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

								$appliedLinks .=$this->lang->line('txt_Files').': ';	

								foreach($docTrees7 as $key=>$linkData)
							    {

									if($linkData['docName']=='')
									{

									    $appliedLinks.=$this->lang->line('txt_Files')."_v".$linkData['version'].", ";

									}
									else
									{
										/*Changed by Dashrath- Comment old code and add new below after changes */
									 	//$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 	$appliedLinks.=$linkData['docName'].", ";

									}

								}

								$appliedLinks=substr($appliedLinks, 0, -2)."
								"; 

							}

							/*Added by Dashrath- used for display linked folder name*/
							if(count($docTrees10)>0)
							{
								$appliedLinks .=$this->lang->line('txt_Folders').': ';	
								foreach($docTrees10 as $key=>$linkData)
							    {
									if($linkData['folderName']!='')
									{
									  
									 	$appliedLinks.=$linkData['folderName'].", ";
									}
								}

								$appliedLinks=substr($appliedLinks, 0, -2)."
								"; 
							}
							/*Dashrath- code end*/	

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

						<li  class="tagLinkTalkSeedLeafIcon">
							<a id="liLink<?php echo $arrDiscussions['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrDiscussions['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 690, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong>
							</a>
						</li>	

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

							//echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
							
								$leafdataContent=strip_tags($arrDiscussions['contents']);
								if (strlen($leafdataContent) > 10) 
								{
	   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
								}
								else
								{
									$talkTitle = $leafdataContent;
								}
								$leafhtmlContent=htmlentities($arrDiscussions['contents'], ENT_QUOTES);

						?>
						
						<li  class="talk tagLinkTalkSeedLeafIcon">
							<a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrDiscussions['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?>
							</a>
						</li>

						<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
						<input type="hidden" value="<?php echo $arrDiscussions['predecessor'];?>" name="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>" id="subTaskPredecessor<?php echo $arrDiscussions['nodeId']; ?>"/>
						<?php

							/*<!--End of cahnged by Surbhi IV -->	*/

						}

						$lastnode=$arrVal['nodeId'];

						?>
          			</ul>
					<div id="versionLoader<?php echo $arrVal['nodeId']; ?>" style="float:right;"></div>
				</span>
      			<!-- tag link talk content end-->

      			<!-- delete button start-->
          		<span class="commonSeedLeafSpanRight" id="deleteLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
				<?php 
				if(($arrDiscussions['leafStatus'] != 'deleted') && ($arrDiscussions['userId'] == $_SESSION['userId']))
				{ 
				?>
					
					<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrDiscussions['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'sub_task')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
					</a>
					
				<?php 
				} 
				?>
				</span>
				<!-- delete button end-->
				

          		<!-- start time and end time or contributor content start-->
          		<!-- <span class="commonSeedLeafSpanRight"> -->
          		<span class="">
          			<div id="TaskInfo<?php echo $arrDiscussions['nodeId'];?>" class="TaskInfo" >

          				<?php

						if(!$checksucc && count($contributorsTagName)>0)
						{
						 	// echo "<div class='clr'></div>";

							//Changed by Dashrath- change >4 to >2
							//Changed by Dashrath- change >2 to >0
						    if(count($contributorsTagName)>0)
							{
							    echo '<span class="commonSeedLeafSpanRight tagStyleNew">';

							  	echo '<div  >';

								// echo '<div style="display:block; float:left; padding-top:5px; " class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrDiscussions['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';
								// echo '<div style="display:block;">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrDiscussions['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';
								echo '<div style="display:block;"><a onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrDiscussions['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  title="see all">'.$this->lang->line('txt_Assigned_To').' ('.count($contributorsTagName).')</a></div>';


							 	echo '</div>';

							 	echo '</span>';

							}
							else
							{
								echo '<span class="commonSeedLeafSpanRight tagStyleNew">'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';

							}

						}
						?>


          				<?php
						if(!$checksucc)
						{
							if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
							{
							?>
	  							<span>
		  							<?php

		  							if($arrEndTime[0] != '00')
									{
									?>
										<span class="commonSeedLeafSpanRight tagStyleNew" style="" >
											<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
											<span>
											<?php echo $arrDiscussions['endtime'];?>
											</span>
										</span>

									<?php
									}

									if($arrStartTime[0] != '00')
									{
									?>
										<span class="commonSeedLeafSpanRight tagStyleNew" style="" >

											<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 
											<span>
											<?php echo $arrDiscussions['starttime'];?>
											</span>
										</span>
									<?php
									}

									
									?> 
								</span>
							<?php
							}
						}
						else
						{
							if($subListTime['listStartTime'] != '' || $subListTime['listEndTime'] != '' )
							{
							?>
								<span>
									<?php
									if($subListTime['listEndTime'] != '')
									{
									?>
										<span class="commonSeedLeafSpanRight tagStyleNew" style="">
											<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
											<span>
											<?php echo $subListTime['listEndTime'];?>
											</span>
									    </span>
									<?php
									}
									
									if($subListTime['listStartTime'] != '')
									{
									?>
										<span class="commonSeedLeafSpanRight tagStyleNew" style="">
											<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 
											<span>
											<?php echo $subListTime['listStartTime'];?>
											</span>
										</span>
									<?php
									}

									
									?>
								</span>
							<?php
							}
						}
						?>
						
					</div>
          		</span>
          		<!-- start time and end time or contributor content end-->

          		<!-- history icon code start-->
				<span class="commonSeedLeafSpanRight">
					<?php

					$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrDiscussions["nodeId"]); 

					if($totalVersion > 0)
					{	

						$headerContent='';
                  	?>
						<a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrDiscussions["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')"  title="<?php echo $this->lang->line('txt_History');?>"  >
						</a>
					<?php					
					}	
		 			?>	
				</span>
				<!-- history icon code end-->

          		<!-- create date start-->
          		<span class="commonSeedLeafSpanRight tagStyleNew" id="normalView<?php echo $arrDiscussions['nodeId'];?>">
          			<?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['editedDate'], $this->config->item('date_format'));?>
          		</span>
	          	<!-- create date end-->

          		<!-- tag name start-->
				<span class="commonSeedLeafSpanRight tagStyleNew" id="normalView<?php echo $arrDiscussions['nodeId'];?>"> 	  
					<?php echo $userDetails['userTagName'];?>
          		</span>
          		<!-- tag name end-->
	       
			</div>
			<!-- footer right content end -->



		</div>
		<!-- task leaf footer end -->

		<div class='clr'></div>
		<hr style="float: left;width: 97%; margin-left: 3%;" class="hrNewUi">
		<div class='clr'></div>

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

	

