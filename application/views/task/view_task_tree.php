<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

   

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

</script>

<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->

<script language="javascript">



function hidedetail(id){

	var image='img'+id;

	var added='add'+id;

	var details='detail'+id;

	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(added).style.display='none';

	document.getElementById(details).style.display='none';

}

function getnext(pid,id){

	var url='<?php echo base_url();?>view_task/task_content_p/'+pid+'/'+id;

	 

	ajax_request(url,id);

}

function getnew(lid,id){

	var url='<?php echo base_url();?>view_task/task_content_n/'+lid+'/'+id;

	 

	ajax_request(url,id);

}



function showFilteredMembers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showMembers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			

			if ($workSpaceId != 0)

			{	

				foreach($workSpaceMembers as $arrData)	

				{

					if ($arrData['userId'] != $_SESSION['userId'])

					{

						?>

						var str = '<?php echo $arrData['tagName']; ?>';

						

						var pattern = new RegExp('\^'+toMatch, 'gi');

						

						

			

						if (str.match(pattern))

						{

							val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

							document.getElementById('showMem').innerHTML = val;

						}

						<?php

					}

				}

			}

			else

			{

				foreach($workSpaceMembers as $arrData)	

				{

					if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

					{

						?>

						var str = '<?php echo $arrData['tagName']; ?>';

						

						var pattern = new RegExp('\^'+toMatch, 'gi');

						

						if (str.match(pattern))

						{

							val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

							document.getElementById('showMem').innerHTML = val;

						}

					

						<?php

					}

				}

			}

        	?>



		}

}

function showFilteredMembersAddTask(nodeId)

{

	//alert (document.getElementById('showMembersEditTask').value);

	var toMatch = document.getElementById('showMembersAddTask'+nodeId).value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

					//val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			if ($workSpaceId != 0)

			{	

				foreach($workSpaceMembers as $arrData)	

				{

					if ($arrData['userId'] != $_SESSION['userId'])

					{

						?>

						var str = '<?php echo $arrData['tagName']; ?>';

						

						var pattern = new RegExp('\^'+toMatch, 'gi');

			

						if (str.match(pattern))

						{

							val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php //if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

							document.getElementById('showMemAddTask'+nodeId).innerHTML = val;

						}

					

						<?php

					}

				}

			}

			else

			{

				foreach($workSpaceMembers as $arrData)	

				{

					if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

					{

				?>

				var str = '<?php echo $arrData['tagName']; ?>';

				

				var pattern = new RegExp('\^'+toMatch, 'gi');

	

				if (str.match(pattern))

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php //if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

					document.getElementById('showMemAddTask'+nodeId).innerHTML = val;

				}

			

				<?php

					}

				}

			}

        	?>



		}

}

</script>

<script language="javascript">

function showFilteredMembers()

{

	var toMatch = document.getElementById('showMembers').value;

	var val = '';



		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

					//val +=  '<input type="checkbox" name="notesUsers[]" value="0" checked/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			if ($workSpaceId != 0)

			{	

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

			else

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

</script>

<script >



function showOptions()

	{

			$(".editDocumentOption").show();

	}	

	function hideOptions()

	{

			$(".editDocumentOption").hide();

	}	



</script>

<?php  include_once('new_task1_js.php');?>

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container" class="taskLeafTimestamp">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
			<!-- Main menu -->
			<?php

			//$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			//$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			

			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);

			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);	
			


			 $userDetails = $this->task_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']); 

			

			$details['workSpaces']		= $workSpaces;

			$details['workSpaceId'] 	= $workSpaceId;

			if($workSpaceId > 0)

			{				

				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];

			}

			else

			{

				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	

			}

			?>

			<!-- Main menu -->	
		<?php $day = date('d');$month 	= date('m');$year = date('Y'); ?> 

        <span id="tagSpan"></span>

		<!-- <div class="menu_new" >

            <ul class="tab_menu_new">

				<li class="task-view_sel"><a class="active 1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>

				<li class="time-view"><a  href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				

				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

						

    			<li class="link-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>	

				

				 <li class="talk-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

				

				<li class="task-calendar"><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar_View');?>"  ><span></span></a></li>

				

                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" ></a></li>

            	<?php

				if (($workSpaceId==0))

				{

				?>

                 <li class="share-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6"></a></li>

                <?php

				}

				?>

				 <li id="treeUpdate" class="update-view" title="<?php echo $this->lang->line('txt_Update_Version'); ?>" ></li>       

				<li style="float:right;"><img id="updateImage" title="<?php echo $this->lang->line('txt_Update');?>" src="<?php echo base_url()?>images/new-version.png" onclick='window.location="<?php echo base_url(); ?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"'   style=" cursor:pointer" ></li>
				
				<?php 
														
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='task';	
															$this->load->view('follow_object',$treeDetails); 
														
														?>
			
			</ul>

			<div class="clr"></div>

        </div>
 -->
		<?php

			if ($treeId == $this->uri->segment(8) || $treeId == $this->input->get('node'))

				$nodeBgColor = 'nodeBgColorSelect';

			else

				//$nodeBgColor = 'seedBgColor';
				$nodeBgColor = 'seedBackgroundColorNew';

		?>	

		<!---------  Seed div starts here ----> 
		<!-- <div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   > -->
			<div id="divSeed" class="<?php echo $nodeBgColor; ?>"   >

			 	<!-- Div contains tabs start-->
				<?php $this->load->view('task/task_seed_header'); ?>
				<!-- Div contains tabs end-->

<?php					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);

						$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				

						$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);

						$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);

				



						$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);

						$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);

						$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);

						$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);

						$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);

						$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);

						$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);

						/*Added by Dashrath- used for display linked folder count*/
						$docTrees10 =$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($treeId, 1);
						/*Dashrath- code end*/	

						$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	

						$total=0;	

?>							 
			 <!-- <div  style="height:30px; ">

			

					<div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:inline; margin-right:8px; " >

								  

								  

					<div style="float:left; margin-right:10px;" class="selCont">

					

									   <div class="newListSelected" tabindex="0" style="position: relative;outline:none;">

												 <div class="selectedTxt" onclick="showTreeOptions()" ></div>

												  <ul id="ulTreeOption" style="visibility: visible; width: 130px; top: 19px; left: 0pt;  display: none;" class="newList">

												  

						  	<?php 
							if ($workSpaceId==0)
							{
								if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
								{
									$opt = 1;
								}
								else
								{
									$opt = 0;
								}
							}
							else
							{
                          		$opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'],$workSpaceDetails['workSpaceId'], $workSpaceDetails['workSpaceType']);	
							}
							if ($opt)

							{?>

								<li><a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>

							<?php

							}?>

							

												  

							 <li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Tasks');?></a></li>

							 

							 <li><a id="aContributors" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'contributors',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Contributors');?></a></li>

							<?php 
							//Manoj: code for showing tree data in pdf file
								$treeName['treeName']='task';	
								$this->load->view('common/printPage',$treeName);
							//Manoj: code end
							?>

													</ul>

													</div>

								</div>

					

								  

					<ul  class="content-list" style="float:left" >

		<?php

								

								$tag_container='';

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

								

						<li><a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/1', 710, 500, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong></a></li>		

						<?php	

								//count totoal number of links

								$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);

								

								if($total==0)

								{

								  $total='';

								  $appliedLinks=$this->lang->line('txt_None');

								}

								else

								{

								

									

								   $appliedLinks='';

								 

								   

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

					

						<li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 710,500,null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>		

						<?php			

								$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

								

								$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

								if(strip_tags(stripslashes($talk[0]->contents)))

								{

									$userDetailsTalk = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

						            $latestTalk=substr(strip_tags(stripslashes($talk[0]->contents)),0,300)."\n".$userDetailsTalk['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

								}

								else

								{

									$latestTalk='Talk';

								}

								

								if($total==0)

								{

								  $total='';

								}

								
									
							$leafdataContent=strip_tags($treeDetail['name']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($treeDetail['name'], ENT_QUOTES);	
								
									?>
									
									<li  class="talk"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
									<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
									<?php

							?>

									</ul>
					</div>

					<div class="clr"></div>		

			</div> -->

					

			<div style="min-height:35px;width:100%">

					  

            	<div   class="clsNoteTreeHeader handCursor" style=" margin-bottom:5px;max-width:79%"  >

					

				      

				        <div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">

						

                		<?php

								echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>'); 

						?>

						</div>

						<?php

						if (!empty($treeDetail['old_name']))

						{

							echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($treeDetail['old_name']),'<span><img>').')</div>';

						}

						?>

						

				  		</div>	

				  <div class="clsNoteTreeHeaderLeft" style="width:450px;" >

				  		

					<div id="divAutoNumbering" style="display:none; float:right " >

                        <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>view_task/node/<?php echo $treeId; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" >



                  

						

						<?php /**************** MOVE TREE CODE START *******************/ ?>

				

				<?php 

					

							if($workSpaceType==2 )

							{

								$placeType=$workSpaceType+1;

								$workSpaceId1=$this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);

								

							

							}

							else

							{

								$placeType=$workSpaceType+2;

							   $workSpaceId1=$workSpaceId;

							}

					

					

					?>

				

				<?php /**************** MOVE TREE CODE CLOSE *******************/ ?>

                        <div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Tasks');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

							<input type="hidden" name="autonumbering_submit" value="1" />

							</div>

							<div style="float:left">	

								<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideDivAutoNumbering()" style="margin-top:-2px;"  border="0"  /> 

							</div>	

								</form> 

							</div>

					

					

						<!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->

					<div id="spanMoveTree" style="float:right; text-align:right" >

					<input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />

					<input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />

					   <div class="lblMoveTree" ><?php echo $this->lang->line('move_tree_to_txt'); ?></div> 

					   <div class="floatLeft">

						 <?php   

							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))

							{   

								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

							?>

							<select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >

						<?php 

						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

						{

						?>

							<option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

							<?php if($workSpaceId){ ?>

							<option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>

							<?php } ?>

						<?php

						$i = 1;

					

						foreach($workSpaces as $keyVal=>$workSpaceData)

						{				

							if($workSpaceData['workSpaceManagerId'] == 0)

							{

								$workSpaceManager = $this->lang->line('txt_Not_Assigned');

							}

							else

							{					

								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

								$workSpaceManager = $arrUserDetails['userName'];

							}
							
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{

							?>		

						<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

						<?php
						
							}

							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

								//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

								//if(($workSpaceId > 0))

								if(count($subWorkspaceDetails) > 0)

								{

									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

									{	

										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

										{		

											if($workSpaceData['subWorkSpaceManagerId'] == 0)

											{

												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

											}

											else

											{					

												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

												$subWorkSpaceManager = $arrUserDetails['userName'];

											}

										}
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['subWorkSpaceId'],2);
							if($treeTypeStatus!=1)
							{

									?>		

											<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

									<?php
									}

									}

								}

						}

						}

						else

						{

						?>

							<option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

							<?php if($workSpaceId){ ?>

							<option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>

							<?php } ?>

						<?php

						$i = 1;

					

						foreach($workSpaces as $keyVal=>$workSpaceData)

						{				

							if($workSpaceData['workSpaceManagerId'] == 0)

							{

								$workSpaceManager = $this->lang->line('txt_Not_Assigned');

							}

							else

							{					

								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

								$workSpaceManager = $arrUserDetails['userName'];

							}

							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

							{
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{

							?>	

								<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

						

							<?php
							}

							}

							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

								//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

								//if(($workSpaceId > 0))

								if(count($subWorkspaceDetails) > 0)

								{

									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

									{	

										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

										{		

											if($workSpaceData['subWorkSpaceManagerId'] == 0)

											{

												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

											}

											else

											{					

												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

												$subWorkSpaceManager = $arrUserDetails['userName'];

											}

										}

										if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))

										{
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['subWorkSpaceId'],2);
							if($treeTypeStatus!=1)
							{

									?>		

											<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

									<?php
									}

										}

									}

								}

						}

						

						}

						?>

					</select>

					<?php

					}

					?>

					</div>

					<div  class="floatLeft" id="divselectMoveToUser"  >

					</div>

					

					&nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> 

									</div>

				

<!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- -->	

					

				  </div>

				  <div class="clr"></div>


				<!-- task seed footer start-->
				<div class="commonSeedFooter">
					<!-- footer left content start -->
					<div class="commonSeedFooterLeft">
						<!--Commented by Dashrath- comment old code and add new code below for add task editor show in popup-->
			           	<!--  <span class="commonSeedLeafSpanLeft">
			            	<a href="javascript:void(0);" id="aAddNewNote" class="anchorAddTask <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "addLeafIconDisBlock2";}else { echo "addLeafIconDisNone2" ; } ?>" onclick="submitForm(<?php  echo $treeId; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a>
			            </span> -->

			            <!--Added by Dashrath- onclick function change for open task add editor in popup -->
			             <span class="commonSeedLeafSpanLeft">
			            	<a href="javascript:void(0);" id="aAddNewNote" class="anchorAddTask <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "addLeafIconDisBlock2";}else { echo "addLeafIconDisNone2" ; } ?>" onclick="addNewTaskForm(<?php  echo $treeId; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a>
			            </span>
			            <!--Dashrath- code end-->
				       
				        <?php 
						if ($treeDetail['userId'] == $_SESSION['userId'])
						{
						?>
							<span class="commonSeedLeafSpanLeft">
				                
             					<a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','')"><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0"></a>
							</span>
				        <?php 	
						}
						else
						{
							echo '&nbsp';
						}
						?>       
					</div>
					<!-- footer left content end -->

					<!-- footer right content start -->
					<div class="commonSeedFooterRight">
						
						<!-- tag link talk content start -->
						<span id="ulNodesHeader0" class="ulNodesHeader commonSeedLeafSpanRight" >
							<ul  class="content-list" style="float:left; margin: 0 0 0 0;" >
							<?php
								$tag_container='';

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
									<a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/1', 710, 500, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong>
									</a>
								</li>		

								<?php	
								//count totoal number of links
								/*Changed by Dashrath- add $docTrees10 for total*/
								$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);

								if($total==0)
								{

								  $total='';

								  $appliedLinks=$this->lang->line('txt_None');

								}
								else
								{

								   $appliedLinks='';

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
									<a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 710,500,null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong>
									</a>
								</li>		

								<?php			

								$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

								/*<!--Added by Surbhi IV -->	*/

								$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

								if(strip_tags(stripslashes($talk[0]->contents)))
								{
									$userDetailsTalk = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

						            $latestTalk=substr(strip_tags(stripslashes($talk[0]->contents)),0,300)."\n".$userDetailsTalk['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

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

								//{		

									/*<!--Changed title by Surbhi IV -->	*/
								
									//echo '<li class="talk"><a id="liTalk'.$leafTreeId.'"  href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/1\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
									
								$leafdataContent=strip_tags($treeDetail['name']);
								if (strlen($leafdataContent) > 10) 
								{
	   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
								}
								else
								{
									$talkTitle = $leafdataContent;
								}
								$leafhtmlContent=htmlentities($treeDetail['name'], ENT_QUOTES);	
								
								?>
									
								<li  class="talk tagLinkTalkSeedLeafIcon">
									<a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?>
										
									</a>
								</li>
								<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
							</ul>
				        </span>
				        <!-- tag link talk content end -->

				        <!--dropdown content start -->
						<span id="ulNodesHeader0" class=" ulNodesHeader commonSeedLeafSpanRight">
							<div class="selCont">
								<div class="newListSelected" tabindex="0" style="position: relative;outline:none;">
									<div class="selectedTxt commonSeedLeafSpanRight" onclick="showTreeOptions()" ></div>
									<ul id="ulTreeOption" style="visibility: visible; width: 130px; top: 19px; left: 0pt;  display: none;" class="newList">

									  	<?php 
										if ($workSpaceId==0)
										{
											if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
											{
												$opt = 1;
											}
											else
											{
												$opt = 0;
											}
										}
										else
										{
			                          		$opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'],$workSpaceDetails['workSpaceId'], $workSpaceDetails['workSpaceType']);	
										}
										if ($opt)
										{?>
											<!-- <li>
												<a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?>
												</a>
											</li> -->
										<?php
										}?>

							 			<li>
							 				<!-- <a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Tasks');?>
							 				</a> -->

							 				<a id="aNumbered" href="JavaScript:void(0);"  onclick="documentTreeOperations(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Use_numbering')?>
							
											</a>
							 			</li>

							 			<li>
							 				<a id="aContributors" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'contributors',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Contributors');?>
							 				</a>
							 			</li>

										<?php 
										//Manoj: code for showing tree data in pdf file
											$treeName['treeName']='task';	
											$this->load->view('common/printPage',$treeName);
										//Manoj: code end
										?>

										<?php
										if ($opt)
										{?>
											<li>
												<a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?>
												</a>
											</li>
										<?php
										}?>

									</ul>
								</div>
							</div>
						</span>
						<!--dropdown content end -->

						<!--create date start-->
						<span class="commonSeedLeafSpanRight tagStyleNew">
							<?php echo $this->time_manager->getUserTimeFromGMTTime($treeDetail['editedDate'], $this->config->item('date_format'));?>
						</span>
						<!--create date end-->

						<!--tag name start-->
						<span class="commonSeedLeafSpanRight tagStyleNew">
							<?php  echo $userDetails['userTagName'];?>
						</span>
						<!--tag name end-->
					</div>
					<!-- footer right content end -->
				</div>
     			<!-- document seed footer end-->

				  </div>

				   <div class="clsNoteTreeHeaderLeft" >

				  		

					<div id="divAutoNumbering" style="display:none; float:right " >

                        <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>notes/Details/<?php echo $treeId; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">



                  

						

						<?php /**************** MOVE TREE CODE START *******************/ ?>

				

				<?php 

					

							if($workSpaceType==2 )

							{

								$placeType=$workSpaceType+1;

								$workSpaceId1=$this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);

								

							

							}

							else

							{

								$placeType=$workSpaceType+2;

							   $workSpaceId1=$workSpaceId;

							}

					

					

					?>

				

				<?php /**************** MOVE TREE CODE CLOSE *******************/ ?>

                        <?php echo $this->lang->line('txt_Numbered_Tasks');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

            			<input type="hidden" name="autonumbering_submit" value="1" />

						<input type="button" onclick="hideDivAutoNumbering()"  value="<?php echo $this->lang->line('txt_Cancel');?>"  class="button01"/>

                        </form> 

					</div>

					

					

						<!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->

					<div id="spanMoveTree" class="span_move_tree" style="float:right; text-align:right" >

					<input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />

					<input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />

					   <div class="lblMoveTree" ><?php echo $this->lang->line('move_tree_to_txt'); ?></div> 

					   <div class="floatLeft">

						 <?php   

							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))

							{   

								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

							?>

							<select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >

						<?php 

						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

						{

						?>

							<option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

							<?php if($workSpaceId){ ?>

							<option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>

							<?php } ?>

						<?php

						$i = 1;

					

						foreach($workSpaces as $keyVal=>$workSpaceData)

						{				

							if($workSpaceData['workSpaceManagerId'] == 0)

							{

								$workSpaceManager = $this->lang->line('txt_Not_Assigned');

							}

							else

							{					

								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

								$workSpaceManager = $arrUserDetails['userName'];

							}
							
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{

							?>		

						<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

						<?php
							}

							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

								//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

								//if(($workSpaceId > 0))

								if(count($subWorkspaceDetails) > 0)

								{

									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

									{	

										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

										{		

											if($workSpaceData['subWorkSpaceManagerId'] == 0)

											{

												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

											}

											else

											{					

												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

												$subWorkSpaceManager = $arrUserDetails['userName'];

											}

										}
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['subWorkSpaceId'],2);
							if($treeTypeStatus!=1)
							{

									?>		

											<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

									<?php
									}

									}

								}

						}

						}

						else

						{

						?>

							<option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

							<?php if($workSpaceId){ ?>

							<option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>

							<?php } ?>

						<?php

						$i = 1;

					

						foreach($workSpaces as $keyVal=>$workSpaceData)

						{				

							if($workSpaceData['workSpaceManagerId'] == 0)

							{

								$workSpaceManager = $this->lang->line('txt_Not_Assigned');

							}

							else

							{					

								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

								$workSpaceManager = $arrUserDetails['userName'];

							}

							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

							{
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{

							?>	

								<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

						

							<?php
							}

							}

							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

								//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

								//if(($workSpaceId > 0))

								if(count($subWorkspaceDetails) > 0)

								{

									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

									{	

										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

										{		

											if($workSpaceData['subWorkSpaceManagerId'] == 0)

											{

												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

											}

											else

											{					

												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

												$subWorkSpaceManager = $arrUserDetails['userName'];

											}

										}

										if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))

										{
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceData['subWorkSpaceId'],2);
							if($treeTypeStatus!=1)
							{

									?>		

											<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

									<?php
									}

										}

									}

								}

						}

						

						}

						?>

					</select>

					<?php

					}

					?>

					</div>

					<div  class="floatLeft" id="divselectMoveToUser"  >

					</div>

					

					&nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> 

									</div>

				

<!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- -->	

					

				  </div>

				<!--   <div style="height:20px;  display:block;">

                  

 

 					<div id="normalView0" class="normalView" style="display:inline;"  >

					

					<div class="lblNotesDetails">

					 <div>

					<a  style="margin-right:25px;   cursor:pointer; float:left"  id="aAddNewNote" class="anchorAddTask <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "disblock";}else { echo "disnone2" ; } ?>" onclick="submitForm(<?php  echo $treeId; ?>,<?php  echo $treeId; ?>,<?php echo $position; ?>)"  ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo "+ ".$this->lang->line("txt_Task"); ?>" border="0"  ></a>

					</div> 

					 <div class="style2"><?php  echo $userDetails['userTagName'];?>&nbsp;&nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($treeDetail['editedDate'], $this->config->item('date_format'));?> </div> 

					

                     <div style="float:right; margin-left:5px;"  class="editLeafMobile">

						 <?php 

						

             				if ($treeDetail['userId'] == $_SESSION['userId'])

                			{

						

             			?>

                       

             			<a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','')"  style="margin-right:25px; float:left" ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0"></a>

                			

						

                	 <?php 	

							}

							


							?>
						</div>

					

                </div>

    		

            	&nbsp; 

	          

				

                

            </div>

				     </div> -->

					
				     <!--Commented by Dashrath- comment add task editor code and shift below for open editor outside of seed-->
					 <!-- <div class="taskFormContainer" id="formContainerSeed<?php echo $treeId; ?>"  name="formContainer<?php echo $treeId; ?>" style="padding-left:10px; float:left; display:none; width:100%;" ></div> 
 -->
					<div id="edit_doc" class="<?php echo $seedBgColor;?>" style="width:<?php echo (($this->config->item('page_width')/10)+10);?>%; padding-left:10px; float:left; display:none;">

            		<form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/task" onSubmit="return validateDocumentName();">

                	<div id="divEditDoc" style=""></div>

                    <div id="loader"></div>

						<input type="hidden" name="editStatus" value="0" id="editStatus">

						<input type="hidden" name="taskTree" value="1" id="taskTree">

               			<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="TaskTitleSaveNew();"  />

						<!-- onclick="docTitleSave();" -->

                    	<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="docTitleCancel_1();" />

              			<input type="hidden" id="treeId" name="treeId" value="<?php echo $treeId; ?>">

            		</form>

            		

    			</div>

					

			 

			<?php /* add mew task on same page  

		

            <div class="<?php echo $nodeBgColor; ?>" id="reply_teeme0" style="width:<?php echo $this->config->item('page_width')-60;?>px; padding-left:10px; float:left; display:none; margin-top:0px;">	

				<form name="form1" method="post" action="<?php echo base_url();?>new_task/node_Task/<?php echo $treeId;?>">

					<?php if($arrDiscussionDetails['name'] == 'untitled'){?>

							<div style="width:100px; float:left;"><?php echo $this->lang->line('txt_Task_Title');?>:</div>

        					<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

                            	<input name="title" type="text" size="40" maxlength="255">

								<input name="titleStatus" type="hidden" value="1">

                            </div>

	 				<?php  }

					else

					{

					?>

						<div style="width:100px; float:left;"><?php echo $this->lang->line('txt_Task');?>:</div>

						<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

							<textarea name="replyDiscussion" id="replyDiscussion"></textarea>

						</div>

                     	

                        <div style="width:100px; float:left;"><img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /><?php echo $this->lang->line('txt_Start_Time');?>:</div>			

						<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

							<input name="titleStatus" type="hidden" value="0">

							<input type="checkbox" name="startCheck" onClick="calStartCheck(this, 0, document.form1,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="starttime" type="text" id="starttime0"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calStart0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" /></span>

						</div>

                        

                        

						<div style="width:100px; float:left;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /><?php echo $this->lang->line('txt_End_Time');?>:</div>

						<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

                    		<input type="checkbox" name="endCheck" onClick="calEndCheck(this, 0, document.form1, '<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>')"><input name="endtime" type="text" id="endtime0" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'Y-m-d H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;"><span id="calEnd0" style="display:none"><img src="<?php echo base_url();?>images/cal.gif" onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" /></span>

						</div>

                        

						<div style="width:100px; float:left;"><?php echo $this->lang->line('txt_Assigned_To');?>:</div>

						<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

                    		<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/>                    

						</div>

                        

                        <div style="width:100px; float:left;">&nbsp;</div>

    					<div id="showMem" style="height:150px;width:<?php echo $this->config->item('page_width')-200;?>px; float:left;overflow:auto;">

        				<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/> <?php echo $this->lang->line('txt_Me');?><br />

            			<?php	

						if($workSpaceId==0)

						{		

							if (count($sharedMembers)!=0)

							{

						?>

            					<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

						<?php	

                			}		

							foreach($workSpaceMembers as $arrData)

							{

								if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))

								{						

						?>

                    				<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

									<?php echo $arrData['tagName'];?><br />

						<?php

								}

							}

						}

						else

						{

						?>

							<input type="checkbox" name="taskUsers[]" value="0"/> <?php echo $this->lang->line('txt_All');?><br />

						<?php	

                			foreach($workSpaceMembers as $arrData)

							{

								if($_SESSION['userId'] != $arrData['userId'])

								{						

						?>

                    				<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>"/> 

									<?php echo $arrData['tagName'];?><br />

						<?php

								}

							}

						}	

						?>

    				</div>

					<div id="mark_calender0" style="display:none;">

						<div style="width:100px; float:left;"><?php echo $this->lang->line('txt_Mark_to_calendar');?>:</div>

          				<div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">

                        	<input type="radio" name="calendarStatus" value="Yes">

                            <?php echo $this->lang->line('txt_Yes');?> &nbsp;

          					<input name="calendarStatus" type="radio" value="No" checked>

          					<?php echo $this->lang->line('txt_No');?> 

                        </div>

					</div>

				<?php

				}

				?>

                <div style="width:100px; float:left;">&nbsp;</div>

                <div style="width:<?php echo $this->config->item('page_width')-250;?>px; float:left;">

				<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1,<?php  echo $treeId; ?>);" class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Replybutton1" value="Cancel" onClick="reply_close(0);" class="button01">

		        <input name="reply" type="hidden" id="reply" value="1">

		        <input name="editorname1" type="hidden"  value="replyDiscussion">

				<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

				<input type="hidden" name="editStatus" value="0" id="editStatus">

                </div>

				</form>

				<script>chnage_textarea_to_editor('replyDiscussion','simple');</script>

			</div>

			

			*/ ?>

			

			

				<div class="divLinkFrame" >

                	

						

						<div id="linkIframeId0"    style="display:none;"></div>

						  

						

				</div>

				<span id="spanArtifactLinks0" style="display:none;"></span>	

				<?php

		

				#********************************************* Tags ********************************************************88

				

				$dispViewTags = '';

				$dispResponseTags = '';

				$dispContactTags = '';

				$dispUserTags = '';

				$nodeTagStatus = 0;	

				?>

				<div id="spanTagView0" style="display:none;"> 

				<div id="spanTagViewInner0">

				<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; ">

							

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

							//$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';		

							if ($tagData['tag']==1)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															

						}

						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispResponseTags .= '], ';

					}

				}

				

				

				?>		

				</div>

				</div>

                

                	<div class="divTagsButton" style="width:auto" >

                		<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(0)" />

                		<span id="spanTagNew0"><input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(0,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" /></span>

					</div>

                    <!--<div class="tagIframe">

						<div id="iframeId0"    style="display:none;">

						  

						</div>

					</div>-->

                </div>								

				<?php	

				#*********************************************** Tags ********************************************************																		

				?>

				

				

						<!--<span>John_Hill 001 &nbsp; <img align="right" width="21" height="18" src="images/right-arrow-icon.png"></span></p>-->

					

					<div class="clr"></div> 

			</div>

			<!--Dashrath- shift this code from above for add task editor open outside of seed-->
			<!--Commented by Dashrath- comment div for editor open in popup-->
			<!-- <div class="taskFormContainer" id="formContainerSeed<?php echo $treeId; ?>"  name="formContainer<?php echo $treeId; ?>" style="padding-left:10px; float:left; display:none; width:100%;" ></div>  -->
			<!--Dashrath- code end-->

			<!--Commented by Dashrath- comment loader because editor open in popup-->
			<!-- <div id="loader0"></div> -->
			<!--Dashrath- code end-->
			

			

		<!---------  Seed div closes here ----> 

        

        <span id="add<?php echo $position;?>" style="display:none;"></span>

        

         

		 <div id="divNodeContainer" >

		 

		<?php /*

		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

		{

		?> 

			<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; padding-left:10px;">

            	<span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            </div>

		<?php

		}

		

		*/

		?>

        

        <!-- Task body starts -->

		<?php	

		//echo "<li>count= " .count($arrDiscussions);

		if(count($arrDiscussions) > 0)

		{

			if($_COOKIE['ismobile']){

				require('view_task_body_for_mobile.php');

			}

			else{

				require('view_task_body.php');

			}

		}

		?> 

        <!-- Task body ends -->

		<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

		<!--Added by Dashrath- used for when close edit task and sub task popup by close icon then lock status is clear in db-->
		<input type="hidden" id="task_sub_task_edit" name="task_sub_task_edit" value="0">
		<!--Dashrath- code end-->

    

    </div>



</div>

    <!--Added by Dashrath- load notification side bar-->
    <?php $this->load->view('common/notification_sidebar.php');?>
    <!--Dashrath- code end-->

</div>

<?php 
$this->load->view('common/foot.php');
//$this->load->view('common/footer');
?>

</body>

</html>	

<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>

<script>
$(window).scroll(function(){
      // if ($(this).scrollTop() > 60) {
      //     $('#divSeed').addClass('documentTreeFixed');
      // } else {
      //     $('#divSeed').removeClass('documentTreeFixed');
      // }

      //call addAndRemoveClassOnSeed function
	  addAndRemoveClassOnSeed($(this).scrollTop());
  });


		// Tree updates every 5 second

		<!--Updated by Surbhi IV-->

		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);

		<!--End of Updated by Surbhi IV-->

		

		function docTitleCancel_1()

		{

				

			//CKEDITOR.instances.documentName.destroy();

			//editorClose('documentName');

			

			if( document.getElementById("divEditDoc"))

			{

			  	var objleafAddFirst = document.getElementById("divEditDoc");

		

						  while (objleafAddFirst.hasChildNodes()) {

										objleafAddFirst.removeChild(objleafAddFirst.lastChild);

									}

			}	

			//tinyMCE.execCommand('mceRemoveControl', false, 'documentName');

			document.getElementById('edit_doc').style.display='none';

			return false;

		}


		 /*Added by Dashrath- Task Highlight after add new task*/
		function taskHighlight(treeId)
		{
			var request = $.ajax({

			    url: baseUrl+"view_task/getLatestAddedTaskNodeId/"+treeId,

			    type: "GET",

			    dataType: "html",

			    async:false,

			    success:function(result){
					if(result > 0)
					{
						document.getElementById("taskLeafContentNew"+result).style.backgroundColor = "#CCFF33"; 

						document.getElementById('taskLeafContentNew'+result).focus();
					}
				}
		  });
		}
		/*Dashrath- code end*/

</script>

<?php $this->load->view('common/datepicker_js.php');?>