<?php

    $totalNodes = array();

	

	//$rowColor1='row1';

	//$rowColor2='row2';

	$rowColor1='seedBackgroundColorNew';

	$rowColor2='seedBackgroundColorNew';

		

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
			
			$arrVal['starttime']		= $this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],  $this->config->item('date_format'));
			
			$arrVal['endtime'] = $this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'], $this->config->item('date_format'));
			
			$editStartTime 		= $this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'], 'd-m-Y H:i');
			
			$editEndTime = $this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'], 'd-m-Y H:i');

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

			
				//Manoj: added extra condition of nodeid for search result link
					$searchOffset = '';
					if ($arrVal['nodeId'] == $this->input->get('node'))
					{
						$searchOffset = 'searchOffset';
					}
				
				if ($arrVal['nodeId'] == $this->uri->segment(8) || $arrVal['nodeId'] == $this->input->get('node'))

					$nodeBgColor = 'nodeBgColorSelect';

				else

					$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

			?>



<div class="clr"></div>

<!--Changed by Surbhi IV-->
<div class="treeLeafRowStyle2"></div>

<!--Changed by Dashrath- add tabindex in div for focus-->
<div id="taskLeafContentNew<?php echo $arrVal['nodeId']; ?>" class="<?php echo $nodeBgColor; ?> handCursor <?php echo $searchOffset; ?>" tabindex="0">
	<!-- Manoj: Removed onclick=clickTaskNodesOptions method -->

  <!-- Changed by Dashrath- div change for new ui-->
  <!-- <div onmouseout="hideTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','')"  onmouseover="showTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','');" id="taskLeafContent<?php echo $arrVal['nodeId']; ?>">  -->

  	<div id="taskLeafContent<?php echo $arrVal['nodeId']; ?>" tabindex="0"> 

    <!--End of Changed by Surbhi IV-->

    <!-- <div style="height:20px; padding-bottom:0px;" >

      <div id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" class=" ulNodesHeader" style="display:inline;width:100% ">

        <div style="float:left; width:36%;">&nbsp;</div>

        <div style="float:left; width:64%;">

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

						
					$total = 0;
					$tag_container = '';
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

            <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo trim(strip_tags($tag_container,'')); ?>"  ><strong><?php echo $total; ?></strong></a></li>

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

            <li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>

            <?php

				

				    $total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

					

					$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

					if(strip_tags($talk[0]->contents))

					{

						$userDetailsTalk = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

						$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetailsTalk['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

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

						
							$leafdataContent=strip_tags($arrVal['contents']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['contents'], ENT_QUOTES);

					?>
						<li  class="talk"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrVal['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
						<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
					<?php
						

					}



					$lastnode=$arrVal['nodeId'];



					?>

          </ul>
			
			<div id="versionLoader<?php echo $arrVal['nodeId']; ?>" style="float:right; margin-right:20px;"></div>

        </div>

        <div class="clr"></div>

      </div>

    </div>
 -->
    <div class="clr"></div>

    <div  >

      <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >

        <div >

          <div  class="autoNumberContainer autoNumberContainerNewUi"  >

            <p>

              <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?>

              <!-- <?php

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

		if ($this->uri->segment(8)==$arrVal['nodeId'] || in_array($this->uri->segment(8),$successor_array))

		{

			?>

              <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>"  <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:block;"' ; else echo 'style="display:none;"';?>> 
			  <img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"></span> 
			  <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"';  else echo 'style="display:block;"';?>>
			  <img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>
            <?php

		}

		else
		{
		?>

              <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"' ;?>>
			  <img src="<?php echo base_url();?>images/icon_expand.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"></span>
			  <span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']!=$this->uri->segment(7)) echo 'style="display:none;"';?>>
			  <img src="<?php echo base_url();?>images/icon_collapse.gif" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>
              <?php

		}

		?>

              <?php

    }

	?>
 -->
            </p>

          </div>

          <!--Added by Dashrath- show task complete icon-->
          <div style="float: left;">
          	<!--task complete show button start-->
			<?php
			if(!$checksucc)
			{
			?>
			<span class="commonSeedLeafSpanLeft">
				<?php
					$taskTitle = $this->lang->line('txt_Task');

					$editStatus = 0;	
				?>
			    <img class="taskCompleteStatusIcon" src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
			    
			</span>
			<?php
			}
			?>
			<!-- task complete show button end -->
          </div>
          <!--Dashrath- code end-->

          <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>"  style="margin-left: 0%;">
          		<!-- Added by Dashrath : check delete leaf -->
		        <?php 
		        if($arrVal['leafStatus'] !='deleted'){
		          	/*Commented old code and add new code below for audio icon show when content is audio*/
		          	// echo stripslashes($arrVal['contents']);

		          	/*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
					$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrVal['contents']);
					$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrVal['contents']);
					
					if($audioContainsMatch1 && $audioContainsMatch2)
					{
					?>	
						<span class="cursor" onclick="audioContentHideShow('<?php echo $arrVal['nodeId'];?>')">
							<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
						</span>
						<span id='audio_contents<?php echo $arrVal['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrVal['contents']);?></span>
					<?php
					}
					else
					{
						echo stripslashes($arrVal['contents']);
					}
					/*Dashrath- code end*/
		        }else{ ?>
		          <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
		        <?php 
		    	} ?>
	    		<!-- Dashrath : code end -->
          	</div>

          <div class="clr"></div>

        </div>

        <div class="clr"></div>

       <!--  <div id="TaskInfo<?php echo $arrVal['nodeId'];?>" style=" width:53%;margin-left:9%; font-style:italic " class="TaskInfo" >

          <?php
//echo "<li>checksucc= " .$checksucc;
if(!$checksucc)

{

	//echo "<li>Here";

	if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')

	{

	  ?>

          <div  style="min-height:20px">

            <?php

	  

		if($arrStartTime[0] != '00')

		{

		?>

            &nbsp;&nbsp;&nbsp; <span class="style2" style="float:left; width:180px;" > <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $arrVal['starttime'];?> </span>

            <?php

		}

		if($arrEndTime[0] != '00')

		{

		?>

            &nbsp;&nbsp;&nbsp; <span class="style2" style="float:left; width:180px;" > <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $arrVal['endtime'];?></span>

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
		//echo "<li>Here";

	    ?>

          <div  style="min-height:20px">

            <?php

		if($subListTime['listStartTime'] != '')

		{

			?>

            &nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:180px;"> <img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />

            <?php

			echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listStartTime'],  $this->config->item('date_format'));?>

            </span>

            <?php

		}

		if($subListTime['listEndTime'] != '')

		{

			?>

            &nbsp;&nbsp;&nbsp;<span class="style2" style="float:left;width:180px;"> <img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" />

            <?php

			echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listEndTime'],  $this->config->item('date_format'));?>

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



// echo "<div class='clr'></div>";

      if(count($contributorsTagName)>4)

	  {

	 //    echo '<div class="style2"  >';

	 //  	echo '<div >';

		// echo '<div style="display:block; float:left; padding-top:5px; maring-left:5px; " class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrVal['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

		

	  

	 

	  

	 //  echo '</div>';

	 // echo '</div>';

	  }

	  else

	  {

			 // echo '<div class="style2" style="margin-left:5px;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</div>';

		

		}

   



}

?>

        </div>
 -->
      </div>

      <div class="clr"></div>

<!--       <div style="height:20px;" >

        <div class="taskdottedLine" style="float:left;width:43%; height:20px; margin-left:9%;">

          <div style=" margin-top:12px;border-bottom:1px dotted gray; "></div>

        </div>

        <div class="lblNotesDetails normalView tasknormalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:inline; width:48%;">

          <div class="clsLabel"  style="float:left; width:76%;"> <?php echo $userDetails['userTagName'];?>&nbsp;&nbsp;

            <?php if($arrVal['editedDate'][0]==0)

				{

					echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format')).'<br/>';

				}

				else

				{

				 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')).'<br/>';

				}

				?>

          </div>

           <div style="width:20%" class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  >

            <a style="margin-right:35px; cursor:pointer;"  onclick="getEditTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['leafId']; ?>)"  ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a> </div> 

          <div class="clr" ></div>

        </div>

      </div> -->


        <!-- task leaf footer start -->
		<div class="commonSeedFooter">
			<!-- footer left content start -->
			<div class="commonSeedFooterLeftTask">

				<!--Commented by Dashrath- Comment icon because this is shift before task content-->
				<!--task complete show button start-->
				<!-- <?php
				if(!$checksucc)
				{
				?>
				<span class="commonSeedLeafSpanLeft">
					<?php
						$taskTitle = $this->lang->line('txt_Task');

						$editStatus = 0;	
					?>
				    <img src="<?php echo base_url();?>images/<?php echo $compImages[$nodeTaskStatus];?>">
				    
				</span>
				<?php
				}
				?> -->
				<!-- task complete show button end -->

				<!--Commented by Dashrath- comment task add icon because task add only from seed-->
				<!-- add task span start-->
				<!-- <span class="commonSeedLeafSpanLeft">
					<div id="taskOption<?php echo $arrVal['nodeId']; ?>" style="border:none;"   >

				        <div class="" id="addOption<?php echo $arrVal['nodeId']; ?>" style="display:inline;" >

				        	<div class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "addLeafIconDisBlock2" ;}else { echo "addLeafIconDisNone2" ; } ?> " style="float:left" >

				         		<a  style="cursor:pointer; float:left"  class="anchorAddTask" onclick="submitForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a> 
				     		</div>
				        </div>

				        <div class="clr"></div>
		    		</div>
				</span> -->
				<!-- add task span end-->
				<!--Dashrath- comment end-->

				<!-- add sub task span start-->
				<span class="commonSeedLeafSpanLeft">
					<div id="taskOption<?php echo $arrVal['nodeId']; ?>" style="border:none;"   >

				        <div class="" id="addOption<?php echo $arrVal['nodeId']; ?>" style="display:inline;" >

				        	<div class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "addLeafIconDisBlock2" ;}else { echo "addLeafIconDisNone2" ; } ?> " style="float:left" >

				         		<!-- <a  style="margin-right:35px;   cursor:pointer; float:left"  class="anchorAddTask" onclick="submitForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a> --> 

				         		<!--Commented by Dashrath- comment sub task add icon old code and add new code below for open form in popup-->
				         		<!-- <a style="cursor:pointer; float:left" onclick="submitSubTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"   ><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a>  -->


				         		<!--Added by Dashrath- change onclick function for sub task add form open in popup-->
				         		<a style="cursor:pointer; float:left" onclick="submitSubTaskFormNew(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"   ><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a>
				         		<!--Dashrath- code end--> 
				     		</div>
				        </div>

				        <div class="clr"></div>
		    		</div>
				</span>
				<!-- add sub task span end-->

				<!-- edit task span start -->
		        <span class="commonSeedLeafSpanLeft">

		        	<?php if($treeDetail['autonumbering']==1) 
		        	{ 
		        		$editIconDiv = 'editIconDiv1'; 
		        	}
		        	else
		        	{
		        		$editIconDiv = 'editIconDiv2'; 
		        	}
		        	?>

		        	<!-- <div class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  > -->

		        	<div class="editDocumentOption <?php echo $editIconDiv;?> <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  >

		        		<!--Commented by Dashrath- comment old code and new code below with onclick funtion change for editor open in popup-->
            			<!-- <a style="cursor:pointer;"  onclick="getEditTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['leafId']; ?>)"  ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>  -->

            			<!--Added by Dashrath- change onclick function for popup because make new function in task js -->
            			<a style="cursor:pointer;"  onclick="getEditTaskFormNew(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>,<?php echo $arrVal['leafId']; ?>)"  ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>
            			<!--Dashrath- code end--> 
            		</div>
		        </span>
		        <!-- edit task span end -->

		        <?php
				if($checksucc)
				{
				?>
				<!--subtask open button start-->
				<span class="commonSeedLeafSpanLeft">
			        <?php
					$successor_array = array();	
					$successor_array = explode (",",$arrVal['successors']);

					if ($this->uri->segment(8)==$arrVal['nodeId'] || in_array($this->uri->segment(8),$successor_array))
					{
					?>
			            <span id="expandSubTasks<?php echo $arrVal['nodeId'];?>"  <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:block;"' ; else echo 'style="display:none;"';?>>

			              <!--Changed by Dashrath- change expand icon--> 
						  <img src="<?php echo base_url();?>images/expand_icon_new.png" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"></span> 
						<span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"';  else echo 'style="display:block;"';?>>
						  <!--Changed by Dashrath- change collapse icon-->
						  <img src="<?php echo base_url();?>images/collapse_icon_new.png" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>
			        <?php
					}
					else
					{
					?>
			           	<span id="expandSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']==$this->uri->segment(7)) echo 'style="display:none;"' ;?>>
			           	  <!--Changed by Dashrath- change expand icon--> 
						  <img src="<?php echo base_url();?>images/expand_icon_new.png" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"></span>
						<span id="collapseSubTasks<?php echo $arrVal['nodeId'];?>" <?php if($arrVal['nodeId']!=$this->uri->segment(7)) echo 'style="display:none;"';?>>
						  <!--Changed by Dashrath- change collapse icon-->
						  <img src="<?php echo base_url();?>images/collapse_icon_new.png" border="0" onclick="showHideSubTasks(<?php echo $arrVal['nodeId'];?>);" style="cursor:pointer"> </span>
			              <?php
					}
					?>
				        
				</span>
				<?php
    			}
				?>
				<!-- subtask open button end -->

				<span>
					&nbsp;
				</span>


			</div>
			<!-- footer left content end -->

			<!-- footer right content start -->
			<div class="commonSeedFooterRightTask">
				<!-- tag link talk content start-->
      			<span class="commonSeedLeafSpanRight">
          			<ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; margin:0 0 0 0;" class="content-list ulNodesHeader">
           		 		<!-- <?php	
           		 		//Code for view history
						$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrVal["nodeId"]); 

						if($totalVersion > 0)
						{					
							$headerContent='';	

						?>
			            	<li class="tagLinkTalkSeedLeafIcon">
			            		<a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrVal["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')" title="<?php echo $this->lang->line('txt_History');?>">
			            		</a>
			            	</li>

		            	<?php					
						}
						// close code for view history
						?>
 						-->
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

						/*Added by Dashrath- used for display linked folder count*/
						$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($arrVal['nodeId'], 2);
						/*Dashrath- code end*/	

						$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);	

							
						$total = 0;
						$tag_container = '';
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
								{	
									$dispResponseTags='';

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
	            			<a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo trim(strip_tags($tag_container,'')); ?>"  ><strong><?php echo $total; ?></strong></a>
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
		            		<a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a>
		            	</li>

		            	<?php

				    	$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

						/*<!--Added by Surbhi IV -->	*/

						$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

						if(strip_tags($talk[0]->contents))
						{

							$userDetailsTalk = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

							$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetailsTalk['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

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
					
						//echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
							$leafdataContent=strip_tags($arrVal['contents']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['contents'], ENT_QUOTES);

						?>
						<li  class="talk tagLinkTalkSeedLeafIcon">
							<a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrVal['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?>
								
							</a>
						</li>
						<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
					<?php
						/*<!--End of Changed title by Surbhi IV -->	*/

					}

						$lastnode=$arrVal['nodeId'];

						?>

          			</ul>
			
					<div id="versionLoader<?php echo $arrVal['nodeId']; ?>" style="float:right;"></div>
				</span>
      			<!-- tag link talk content end-->

      			<!-- delete button start-->
          		<span class="commonSeedLeafSpanRight" id="deleteLeafSpan<?php echo $arrVal['nodeId'];?>">
				<?php 
				if(($arrVal['leafStatus'] != 'deleted') && ($arrVal['userId'] == $_SESSION['userId']))
				{ 
				?>
					<?php
					if($checksucc)
					{
						$taskWithSubTask = 'task_sub_task';
					}
					else
					{
						$taskWithSubTask = 'task';
					}
					?>

					<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrVal['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', '<?php echo $taskWithSubTask;?>')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
					</a>

					
				<?php 
				} 
				?>
				</span>
				<!-- delete button end-->

          		<!-- start time and end time or contributor content start-->
          		<!-- <span class="commonSeedLeafSpanRight"> -->
          		<span class="">
          			<div id="TaskInfo<?php echo $arrVal['nodeId'];?>" class="TaskInfo" >
          				<?php
						if(!$checksucc && count($contributorsTagName)>0)
						{
							// echo "<div class='clr'></div>";

							//Changed by Dashrath- change >2 to >0
						    if(count($contributorsTagName)>0)
							{
							    echo '<span class="commonSeedLeafSpanRight tagStyleNew"  >';

							  	echo '<div >';

								// echo '<div style="display:block;" class="clsLabel">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].','.$contributorsTagName[2].','.$contributorsTagName[3].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrVal['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

								// echo '<div style="display:block;">'.$this->lang->line('txt_Assigned_To').': '.$contributorsTagName[0].','.$contributorsTagName[1].'<a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrVal['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)"  >...see all</a></div>';

								echo '<div style="display:block;"><a   onClick="showPopWin(\''.base_url().'comman/listAllContributors/'.$arrVal['nodeId'].'\',500,200,null,\'\');"    href="javaScript:void(0)" title="see all"  >'.$this->lang->line('txt_Assigned_To').' ('.count($contributorsTagName).')</a></div>';


							  	echo '</div>';

							 	echo '</span>';
							}
							else
							{
								echo '<span class="commonSeedLeafSpanRight tagStyleNew"  >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';

							}
						}
						?>
				        <?php
						//echo "<li>checksucc= " .$checksucc;
						if(!$checksucc)
						{
							//echo "<li>Here";
							if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
							{
							 ?>
						        <span>
							        <?php

							        if($arrEndTime[0] != '00')
									{
									?>
							            <span class="commonSeedLeafSpanRight tagStyleNew" style="" > <img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <span><?php echo $arrVal['endtime'];?></span></span>

							        <?php
									}

									if($arrStartTime[0] != '00')
									{
									?>
					            		<span class="commonSeedLeafSpanRight tagStyleNew" style="" > <img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <span><?php echo $arrVal['starttime'];?> </span></span>

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
								//echo "<li>Here";
							?>
						        <span>
						           	<?php

						           	if($subListTime['listEndTime'] != '')
									{
									?>

							            <span class="commonSeedLeafSpanRight tagStyleNew" style=""> <img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" />
							            <span>
							            <?php

										echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listEndTime'],  $this->config->item('date_format'));?>
										</span>
							            </span>

							        <?php
									}

									if($subListTime['listStartTime'] != '')
									{
									?>
							            <span class="commonSeedLeafSpanRight tagStyleNew" style=""> <img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
							            <span>
							            <?php

										echo $this->time_manager->getUserTimeFromGMTTime($subListTime['listStartTime'],  $this->config->item('date_format'));?>
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
       		 		//Code for view history
					$totalVersion=$this->task_db_manager->getTaskTreeLatestVersionByTreeId($treeId,$arrVal["nodeId"]); 

					if($totalVersion > 0)
					{					
						$headerContent='';	

					?>
	            		<a class="clsHistory" href="javascript:void(0);" onclick="showPopWin('<?php echo base_url() ; ?>view_task/task_history/<?php echo $arrVal["nodeId"] ; ?>/<?php echo  $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo  $treeId; ?>',710,420,null,'')" title="<?php echo $this->lang->line('txt_History');?>">
	            		</a>
	            	<?php					
					}
					// close code for view history
					?>
				</span>
				<!-- history icon code end-->

          		<!-- create date start-->
          		<span class="commonSeedLeafSpanRight tagStyleNew" id="normalView<?php echo $arrVal['nodeId'];?>">
          			<?php if($arrVal['editedDate'][0]==0)
					{
						echo $this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format'));
					}
					else
					{
					 	echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
					}

					?>
          		</span>
	          	<!-- create date end-->

          		<!-- tag name start-->
				<span class="commonSeedLeafSpanRight tagStyleNew" id="normalView<?php echo $arrVal['nodeId'];?>"> 	  
					<?php echo $userDetails['userTagName'];?>
          		</span>
          		<!-- tag name end-->
	       
			</div>
			<!-- footer right content end -->

		</div>
		<!-- task leaf footer end -->

		<!--Commented by Dashrath- Add this hr in subtask-->
		<!-- <hr style="float: left;width: 100%;" class="hrNewUi"> -->

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

  <!--Commented by dashrath- add new task section comment for this section is open below subtask-->
  <!-- <div class="taskFormContainer" id="formContainer<?php echo $arrVal['nodeId']; ?>"  name="formContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div> -->

 
  <!--End of Changed by Surbhi IV-->

  

  <?php

			/******* Parv - Start Sub Tasks  ***********/

			if ($checksucc)

			{ 

				require('view_sub_tasks.php');

			}

			/******* Parv - Finish Sub Tasks ***********/

			?>

  <!--/*Changed by surbhi IV*/-->

  <!--Added by Dashrath- Add task section below subtask-->
  <!--Commented by Dashrath- comment add task editor code and shift below for open editor outside of task-->
  <!-- <div class="taskFormContainer" id="formContainer<?php echo $arrVal['nodeId']; ?>"  name="formContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div> -->
  <!--Dashrath- code end-->

  <!-- Changed by Dashrath- for new ui -->
 <!--  <div style="height:29px;" onmouseout="hideTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','')"  onmouseover="showTaskNodeOptions('<?php echo $arrVal['nodeId']; ?>','');"> -->

 	<!-- <div style="height:29px;">

	    <div id="taskOption<?php echo $arrVal['nodeId']; ?>" class="<?php echo $nodeBgColor; ?> taskOption " style="padding:0px 0px 0 ; border:none;"   >

	        <div class="lblNotesDetails normalView" id="addOption<?php echo $arrVal['nodeId']; ?>" style="display:inline;" >

	        	<div class="editDocumentOption <?php if($arrDiscussionDetails['name'] != 'untitled' && in_array($_SESSION['userId'], $SeedContributorsUserId) ) {echo "disblock2" ;}else { echo "disnone2" ; } ?> " style="float:left" >

	         		<a  style="margin-right:35px;   cursor:pointer; float:left"  class="anchorAddTask" onclick="submitForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a> 

	         		<a style="margin-left:10px;cursor:pointer; float:left" onclick="submitSubTaskForm(<?php echo $arrVal['nodeId']; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"   ><img src="<?php echo  base_url(); ?>images/subtask-icon.png"  title="<?php echo "+ ".$this->lang->line("txt_Sub_Task"); ?>" border="0"  ></a> 
	     		</div>
	        </div>

	       <div class="clr"></div>
	    </div>
  	</div>
 -->
 <!--/*End of Changed by surbhi IV*/-->

	<!--Commented by Dashrath- comment add sub task editor code and shift below for open editor outside of task body-->
 <!--  <div class="taskFormContainer" id="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>"  name="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div>-->

<!--Commented by Dashrath- comment add task loader code and shift below for outside of task body-->
<!--<div id="loader<?php echo $arrVal['nodeId']; ?>"></div> -->

</div>
 
  <!--Dashrath- shift this code from above for add sub task editor open outside of task body-->
  <div class="taskFormContainer" id="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>"  name="formSubTaskContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div>
  <!--Dashrath- code end-->

 <!--Dashrath- shift this code from above for add task editor open outside of task-->
 <div class="taskFormContainer" id="formContainer<?php echo $arrVal['nodeId']; ?>"  name="formContainer<?php echo $arrVal['nodeId']; ?>" style="display:none" ></div>
 <!--Dashrath- code end-->

 <!--Dashrath- shift this code from above for show loader outside of task body-->
 <div id="loader<?php echo $arrVal['nodeId']; ?>"></div>
 <!--Dashrath- code end-->

<!--Manoj: edit leaf content -->

<!-- Changed by Dashrath- remove nodeBbColor class for new ui-->
<!-- <div class="<?php echo $nodeBgColor; ?> handCursor"> -->
<div class="handCursor">
<div id="editleaf<?php echo $position;?>" style="display:none;"></div>
</div>
<?php

		$i++;

		?>

<?php

		}		

	}

	?>

