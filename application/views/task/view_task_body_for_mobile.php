<?php

    $totalNodes = array();

	

	$rowColor1='row1';

	$rowColor2='row2';	

	$i = 1;

	$SeedContributorsUserId=$contributorsUserId;

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

			$arrStartTime 			= explode('-',$arrVal['starttime']);

			$arrEndTime 			= explode('-',$arrVal['endtime']);

			//Manoj: get user time
			$arrVal['starttime'] = $this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],  $this->config->item('date_format'));
			
			$arrVal['endtime'] = $this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'], $this->config->item('date_format'));
			//Manoj: code end
			
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

			

			

				if ($arrVal['nodeId'] == $this->uri->segment(8) || $arrVal['nodeId'] == $this->input->get('node'))

					$nodeBgColor = 'nodeBgColorSelect';

				else

					$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

			?>



<div class="clr"></div>

<!--Changed by SurbhiIV-->

<div class="<?php echo $nodeBgColor; ?> handCursor" style="border:none;" >
  <!-- Manoj: comment onmouseover method -->
  <div <?php /*?>onclick="clickMobTaskNodesOptions('<?php echo $arrVal['nodeId']; ?>','')"<?php */?> onmouseout="hideTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','')"  onmouseover="clickMobTaskNodesOptions('<?php echo $arrVal['nodeId']; ?>','');" id="taskLeafContent<?php echo $arrVal['nodeId']; ?>" > 

    <!--End of Changed by Surbhi IV-->

    <div style="height:20px; padding-bottom:0px;" >

      <div id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" class=" ulNodesHeader" style="display:none;width:100% ">

        <div style="float:left; width:15%;">&nbsp;</div>

        <div style="float:left; width:85%;">

          <ul style="float:right; margin:0 0;" class="content-list">

            <?php	

			

			

			//Code for view history

					

				$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrVal["nodeId"]); 

								

				

				if($totalVersion > 0)

				{					

					$headerContent='';	

				?>

            <li><a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrVal["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')" title="<?php echo $this->lang->line('txt_History');?>"    ></a></li>

            <?php					

				}

				// close code for view history

			?>

            <?php

					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);

					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);

					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);

					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);	

					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);

					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);

					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);

					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);

					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);

					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);

					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);	

				

					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);	

						

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

            <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>

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

            <li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>

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

						/*<!--changed title by Surbhi IV -->	*/

						echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';

						/*<!--End of Changed title by Surbhi IV -->	*/

					}



					$lastnode=$arrVal['nodeId'];



					?>

          </ul>

        </div>

        <div class="clr"></div>

      </div>

    </div>

    <div class="clr"></div>

    <div>

      <div <?php /*?>onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"<?php */?>>

        <div >

          <div class="autoNumberContainer"  >

            <p>

              <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?>

              <?php

	if(!$checksucc)

	{

		$taskTitle = $this->lang->line('txt_Task');

		$editStatus = 0;	

	?>

              &nbsp;&nbsp; <img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">

              <?php

	}

	else

	{

	?>

              &nbsp;&nbsp;

              <?php
			  
		$successor_array = array();	
		$successor_array = explode (",",$arrVal['successors']);	  

		//if ($this->uri->segment(8))
		if ($this->uri->segment(8)==$arrVal['nodeId'] || in_array($this->uri->segment(8),$successor_array))
		{

		

		?>

              <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>"  <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:block;"' ; else echo 'style="display:none;"' ;   ?> class="expandSubTasks" > <img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span> <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"';  else echo 'style="display:block;"';   ?> > <img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>

              <?php

		}

		else

		{

		?>

              <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"' ;   ?> class="expandSubTasks" > <img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span> <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']!=$this->uri->segment(7)) echo 'style="display:none;"' ;   ?>> <img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>

              <?php

		}

		?>

              <?php

    }

	?>

            </p>

          </div>

          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>"><?php echo stripslashes($arrVal['contents']); ?></div>

          <div class="clr"></div>

        </div>

        <div class="clr"></div>

        <div id="TaskInfo<?php echo $arrVal['nodeId'];?>" style=" width:90%; margin-left:2%; font-style:italic " class="TaskInfo" >

          <?php

if(!$checksucc)

{

	

	if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')

	{

	  ?>

          <div  style="min-height:20px">

            <?php

	  

		if($arrStartTime[0] != '00')

		{

		?>

            &nbsp;&nbsp;&nbsp; <span class="style2" style="float:left; width:170px;" > <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $arrVal['starttime'];?> </span>

            <?php

		}

		if($arrEndTime[0] != '00')

		{

		?>

            &nbsp;&nbsp;&nbsp; <span class="style2" style="float:left; width:170px;" > <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $arrVal['endtime'];?></span>

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

          <div  style="min-height:20px">

            <?php

		if($subListTime['listStartTime'] != '')

		{

			?>

            &nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:180px;"> <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />

            <?php
			//Manoj: added start time date format for subtask
			//echo $subListTime['listStartTime'];
			echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listStartTime'],  $this->config->item('date_format'));
			?>

            </span>

            <?php

		}

		if($subListTime['listEndTime'] != '')

		{

			?>

            &nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:180px;"> <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" />

            <?php
			//Manoj: added end time date format for subtask
			//echo $subListTime['listEndTime'];
			echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listEndTime'],  $this->config->item('date_format'));
			?>

            </span>

            <?php

		}

		?>

          </div>

          <?php

	}

	

}

?>

          <?php

if(!$checksucc && count($contributorsTagName)>0)

{

 

echo "<div class='clr'></div>";

      if(count($contributorsTagName)>4)

	  {

	    echo '<div class="style2" style="font-size:15px;" >';

	  	echo '<div  >';

		echo '<div style="display:block; float:left; padding-top:5px; maring-left:5px; " class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrVal['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

		

	  

	 

	  

	  echo '</div>';

	 echo '</div>';

	  }

	  else 

	  {
	  	?>
			<!--Start Manoj: Create Assignee list hyperlinked -->
			
			<div style="margin-top:10px;">
			
	  		<?php  
			
			echo '<div class="style2" style="width:auto;" >'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].'</div>';
			
			 if(count($contributorsTagName)>1)
			 {
			 	?>
				<a id="seeAll<?php echo $arrVal['nodeId']; ?>" style="padding: 0 4%; font-size: .8em; width: 85%;" onclick="show_assignee(<?php echo $arrVal['nodeId']; ?>)">See all..</a>
			  <?php
			  // echo implode(', ',$contributorsTagName);
			 }
			
			?> 

			<div class="style2<?php echo $arrVal['nodeId']; ?>" style="margin-left:5px; display:none; color: #999999; font-size: .8em; width: 85%;"  >
			<?php
			
			   array_shift($contributorsTagName);
			   echo implode(', ',$contributorsTagName);
			?>
			
			</div>
			
			</div>
		
			<!--End Manoj: Create Assignee list hyperlinked -->
			
	<?php		
			//echo '<div class="style2" style="margin-left:5px;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</div>';
	  }

   



}

?>

        </div>

      </div>

      <div class="clr"></div>

      <div style="height:20px;" >

        <div style="float:left;width:50%; height:20px; margin-left:2%;">

          <div style=" margin-top:12px;border-bottom:1px dotted gray; "></div>

        </div>

        <div class="lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none; width:100%;">

          <div class="clsLabel"  style="float:left; width:72%; margin-left:3%;"> 
		  <div style="text-align: left;">
		  <?php 
		  echo $userDetails['userTagName'];
		  if(strlen($userDetails['userTagName'])>15)
		  {
		  ?>
		  </div>
		  <div style="text-align: left; margin-top: 5px; margin-bottom: 10px;">
		  
          <?php }
		  		 if($arrVal['editedDate'][0]==0)

				{
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

					//echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format')).'<br/>';

				}

				else

				{
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
					 
					 
					// echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')).'<br/>';

				}

				?>
		  </div>
          </div>

          <div style="width:20%" class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  >

            <?php /*		

				<a style="margin-right:35px;"  onclick="showPopWin('<?php echo base_url(); ?>new_task/leaf_edit_Task/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>', 750, 480, null, '');"  ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>	

		

				*/

				

				

				?>
			<!--Manoj: showing edit button on collapsed view-->
            <a style=" padding:14px;<?php //echo ($arrNodes)?"display:none;":"";?>" onclick="getEditTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['leafId']; ?>)"  ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a> </div>

          <div class="clr" ></div>

        </div>

      </div>

      <?php

				#******************************* * * * * * * * * * * * * * * Tags * * * * * * * * ************************************************88

							

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;

				?>

      <div class="divLinkFrame">

        <div id="linkIframeId<?php echo $arrVal['nodeId']; ?>"    style="display:none;"></div>

      </div>

      <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">

      <div class="commonDiv">

        <?php	

				$tagAvlStatus = 0;				

				if(count($viewTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($viewTags as $tagData)

					{													

						$dispViewTags .= $tagData['tagName'].', ';						 

					}

				}

							

				if(count($contactTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($contactTags as $tagData)

					{

						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									

					}

				}

				if(count($userTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($userTags as $tagData)

					{

						$dispUserTags .= $tagData['userTagName'].', ';						

					}

				}

				if(count($actTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($actTags as $tagData)

					{

						$dispResponseTags .= $tagData['comments'].' [';							

						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

						if(!$response)

						{

							//$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',3,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==1)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',3,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispResponseTags .= '], ';

					}

				}

				

					?>

        <div id="divSimpleTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispViewTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >

          <?php

					//echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';

	echo $this->lang->line('txt_Simple_Tags').': <span id= "simpleTags'.$arrVal['nodeId'].'">'.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'</span><br>';				

					$nodeTagStatus = 1;		

					?>

        </div>

        <?php				

						

				//Response tag container	

					?>

        <div id="divResponseTags<?php echo $arrVal['nodeId'] ; ?>" <?php if($dispResponseTags!=''){ echo 'style="display:block"';} else { echo'style="display:none"' ; } ?> >

          <?php

					

				//	echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					

			echo $this->lang->line('txt_Response_Tags').':<span id= "responseTags'.$arrVal['nodeId'].'"> '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'</span><br>';			

					$nodeTagStatus = 1;

					?>

        </div>

        <?php	

					

				 //Contact Tag container

					?>

        <div id="divContactTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispContactTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >

          <?php

				//	echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					

				echo $this->lang->line('txt_Contact_Tags').':<span id= "contactTags'.$arrVal['nodeId'].'"> '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'</span><br>';

					$nodeTagStatus = 1;	

					?>

        </div>

        <?php	

					

				if($dispUserTags != '')		

				{

					?>

        <div>

          <?php

					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';

					$nodeTagStatus = 1;			

					?>

        </div>

        <?php		

				}	

							

				if($nodeTagStatus == 0)	

				{

				?>

        <div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>

        <?php

				}

				?>

      </div>

      </span>

      <div class="commonDiv">

        <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(<?php echo $arrVal['nodeId'];?>)" />

        <span id="spanTagNew<?php echo $arrVal['nodeId'];?>">

        <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" />

        </span> </div>

      <div class="commonDiv"> 

        <!--<iframe id="iframeId<?php // echo $arrVal['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe> -->

        <div id="iframeId<?php  echo $arrVal['nodeId'];?>"    style="display:none;"></div>

      </div>

      </span>

      <?php	

				#*********************************************** Tags ********************************************************																		

				?>

      <div class="divEditLaef" > 

        <!------------ Main Body of the document ------------------------->

        <?php /*?><div id="editleaf<?php echo $position;?>" style="display:none;"></div><?php */?>

      </div>

      <div class="divEditLaef" >

        <div id="addleaf<?php echo $position;?>" style="display:none;"></div>

      </div>

      <div class="clr"></div>

    </div>

    <!--Changed by Surbhi IV--> 

  </div>

  <div class="taskFormContainer" id="formContainer<?php echo $arrVal['nodeId']; ?>"  name="formContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div>

 
  <!--End of Changed by Surbhi IV-->

  

  <?php

			/******* Parv - Start Sub Tasks  ***********/

			if ($checksucc)

			{ 

				require('view_sub_tasks_for_mobile.php');

			}

			/******* Parv - Finish Sub Tasks ***********/

			?>

<!--Manoj: code copy from here of taskFormContainer -->

  <div style="height:21px;" onmouseout="hideTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','')"  onmouseover="showTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','');">

    <div id="taskOption<?php echo $arrVal['nodeId']; ?>" class="<?php echo $nodeBgColor; ?> taskOption " style="padding:0px 0px 0 ; border:none; width:975px;"   >

      <div class=" lblNotesDetails normalView" id="addOption<?php echo $arrVal['nodeId']; ?>" style="display:none" >

        <div class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> " style="float:left; margin-left:6px !important;" >

          <?php /*	<a style="margin-right:35px; margin-left:10px;  cursor:pointer; float:left"  onclick="showPopWin('<?php echo base_url(); ?>new_task/new_task1/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>', 750, 450, null, '');"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a>

		

		

		<a style="margin-left:10px;cursor:pointer; float:left"  onclick="showPopWin('<?php echo base_url(); ?>new_task/start_sub_task/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>', 750, 450, null, '');"  ><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a>

		

		*/

		?>

          <!--<a  style="margin-right:35px;   cursor:pointer; float:left"  class="anchorAddTask" onClick="submitForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a> <a style="margin-left:10px;cursor:pointer; float:left" onClick="showPopWin('<?php echo  base_url(); ?>new_task/start_sub_task/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php  echo $treeId; ?>/<?php echo $position; ?>', 300, 380, null, '');"><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a> </div>

      </div>-->

      <a  style="margin-right:35px;   cursor:pointer; float:left"  class="anchorAddTask" onclick="submitForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a> <a style="margin-left:10px;cursor:pointer; float:left" onclick="submitSubTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"   ><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a> </div>

      <div class="clr"></div>

    </div>

  </div>
  
</div>
<!--Manoj: code paste here for remove right icon from bottom of ui when add task and subtask-->
  <!--/*Changed by surbhi IV*/-->
 <!--/*End of Changed by surbhi IV*/-->

  <div class="taskFormContainer" id="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>"  name="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div>

 <div id="loader<?php echo $arrVal['nodeId']; ?>"></div>  
  
<!--Manoj: code end-->
</div>
<!--Manoj: edit leaf content -->
<div class="<?php echo $nodeBgColor; ?> handCursor">
<div id="editleaf<?php echo $position;?>" style="display:none;"></div>
</div>

<?php

		$i++;

		?>

<?php

		}		

	}

	?>

