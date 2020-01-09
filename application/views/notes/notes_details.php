<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<?php $_SESSION['tagFlag']=0;

		$_SESSION['linkFlag']=0;

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Notes > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<?php //$this->load->view('editor/editor_js.php');?>

<script>

	var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

	var workSpace_name='<?php echo $workSpaceId;?>';

	var workSpace_user='<?php echo $_SESSION['userId'];?>';

	var node_lock=0;

</script>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

</script>
<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->
</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

	

<?php //$this->load->view('common/wp_header'); ?>

<?php

	$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

	//$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

	

	$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);

	$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);

	

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

<?php $this->load->view('common/artifact_tabs', $details); ?>

<script>

	$(document).ready(function(){

		$('p > img').css({'max-width':'600px','max-height':'500px'});

		//Examples of how to assign the ColorBox event to elements

		//$(".example7").colorbox({width:"<?php //echo $this->config->item('page_width')+50;?>px", height:"500px", iframe:true});

	});

</script>

</div>

</div>



<div id="container">



		<div id="content">

				

			<!-- Div contains tabs -->	

			<div class="menu_new" >



                <ul class="tab_menu_new">

                

                    <li class="notes-view_sel"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Notes_View');?>" class="active 1tab"></a></li>

                    

                    <li class="time-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" class="2tab" title="<?php echo $this->lang->line('txt_Time_View');?>" ></a></li>

                    

                    <li class="tag-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

                    

                    <li class="link-view" ><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>"  ><span></span></a></li>

                    

                    <li class="talk-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>"  ></a></li>

                    <?php

                    if (($workSpaceId==0))

                    {

                    ?>

                        <li class="share-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>

                    <?php

                    }

                    ?> 

                    <li id="treeUpdate" class="update-view" style="font-weight:normal;"  title="<?php echo $this->lang->line('txt_Update_Tree'); ?>" ></li>

                    

                    <li style="float:right;"><img  id="updateImage" src="<?php echo base_url()?>images/new-version.png" onclick="window.location='<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1'" title="<?php echo $this->lang->line('txt_Update');?>" style=" cursor:pointer" ></li>
					<?php 
					/*Code for follow button*/
						$treeDetails['seedId']=$treeId;
						$treeDetails['treeName']='notes';	
						$this->load->view('follow_object',$treeDetails); 
					/*Code end*/
					?>
				</ul>

                <div class="clr" ></div>

   			 </div>

		

			<div id="datacontainer" >

					 

		<?php

			if ($treeId == $this->uri->segment(8) || $treeId == $this->input->get('node'))

				$nodeBgColor = 'nodeBgColorSelect';

			else

				$nodeBgColor = 'seedBgColor';

		?>	 

					 

					<!---------  Seed div starts here ----> 

					

				<div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >

					 

<?php				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);

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

					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	

					$total=0;	

?>							 

					<div  style="height:20px; ">

					

					<!--       my tyest           -->

							

							

							

                          <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " >

                          <div style="float:left; margin-right:10px;" class="selCont">

            				   <div class="newListSelected" tabindex="0" style="position: relative;outline:none;">

                                         <div class="selectedTxt" onclick="showTreeOptions()" ></div>

                                          <ul id="ulTreeOption" style="visibility: visible; width: 130px; top: 19px; left: 0pt; display: none;" class="newList">

                            <?php 	
							if ($workSpaceId==0)
							{
								if ($treeDetail['userId'] == $_SESSION['userId'])
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
                           		$opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceDetails['workSpaceId'], $workSpaceDetails['workSpaceType']);
							}
                            if($opt)

                            {

                        		?>

                                <li><a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>

                       			<?php

                            }

							?>

												  

							<li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Notes');?></a></li>

							<li><a id="aContributors" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'contributors',<?php echo $treeId; ?>)" onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Contributors');?></a></li>

							<?php 
							//Manoj: code for showing tree data in pdf file
								$treeName['treeName']='notes';	
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

								  $tag_container=$this->lang->line('txt_Tags_None');

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

								  $appliedLinks=$this->lang->line('txt_Links_None');

								}

								else

								{

								

									

								   $appliedLinks='';

								 

								   

								   if(count($docTrees1)>0)

								   {

									   $appliedLinks .= $this->lang->line('txt_Document').': ';

									   foreach($docTrees1 as $key=>$linkData)

									   {

											

											 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n" ; 

									}	

									

									

									 if(count($docTrees3)>0)

								   {

										$appliedLinks.=$this->lang->line('txt_Chat').': ';	

										foreach($docTrees3 as $key=>$linkData)

									   {

											 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

									}	

									

									if(count($docTrees4)>0)

									{

									

										$appliedLinks.=$this->lang->line('txt_Task').': ';	

										foreach($docTrees4 as $key=>$linkData)

									   {

											 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n" ; 

									}	

									

									if(count($docTrees6)>0)

									{

										$appliedLinks.=$this->lang->line('txt_Notes').': ';	

										foreach($docTrees6 as $key=>$linkData)

									   {

											 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n" ; 

									}

									

									if(count($docTrees5)>0)

									{

									

										$appliedLinks .=$this->lang->line('txt_Contacts').': ';	

										foreach($docTrees5 as $key=>$linkData)

									   {

											 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).", ";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n" ; 

									

									}

									

									if(count($docTrees7)>0)

									{

										$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	

										foreach($docTrees7 as $key=>$linkData)

									    {

											if($linkData['docName']=='')

											 {

												$appliedLinks.="\n - ".$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";

											 }

											 else

											 {

												$appliedLinks.="\n - ".$linkData['docName']."_v".$linkData['version'].", ";

											 }

										}

										$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

									}	

								   

								   if(count($docTrees9	)>0)

								   {

									

										$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	

										foreach($docTrees9 as $key=>$linkData)

										{

											 $appliedLinks.="\n - ".$linkData['title'].", ";

											

										}

										$appliedLinks=substr($appliedLinks, 0, -2);

									

									}

								}

							

						?>			

					

						<li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo html_entity_decode(strip_tags($appliedLinks,'')); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>		

							

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

									/*<!--Cahnged title by Surbhi IV -->	*/

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
							
							<li  class="talk"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','','<?php echo $arrVal['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
							<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId; ?>"/>
							<?php
									/*<!--End of Changed title by Surbhi IV -->	*/

								}	

								

							?>

							

							

									

									</ul>

									

									

				 </div>

							 

							 <div class="clr"></div>		

							</div>

							

							  

							  <div style="min-height:45px;">

							  

						<div   class="clsNoteTreeHeader handCursor"  >

							

							  

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

						  <div class="clsNoteTreeHeaderLeft" style="width:432px;" >

								

							<div id="divAutoNumbering" style="display:none; float:right;  " >

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

							<div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Notes');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

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

							   <div class="lblMoveTree" > <?php echo $this->lang->line('move_tree_to_txt'); ?></div> 

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
									$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceData['workSpaceId'],1);
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
												$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceData['subWorkSpaceId'],2);
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
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceData['workSpaceId'],1);
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
													$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceData['subWorkSpaceId'],2);
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

						  </div>

						  <div class="clr" ></div>

						  <div style="height:20px;">

							<div id="normalView0" class="normalView" style="display:none"  >

							

							<div class="lblNotesDetails"   >

							<div class="style2">

							 <!--Changed by Surbhi IV -->

							<div style="float:left;"><a  style="margin-right:25px; float:left" id="aAddNewNote" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock2"';}else { echo 'class="disnone2"' ; } ?> href="javascript:void(0);" onClick="reply(0,0);"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a></div>

                             <!--End of Changed by Surbhi IV -->

							<?php echo $arrUser['tagName'];?>&nbsp;&nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($treeDetail['editedDate'], $this->config->item('date_format'));?> </div>

							

							<div style="float:right; margin-left:5px;" class="editLeafMobile">

								 <?php 

								

									if ($treeDetail['userId'] == $_SESSION['userId'])

									{

								

								?>

                                <!--/*Added by Surbhi IV for checking version */-->	

							<a href="javascript:void(0);"  onClick="openEditTitleBox('<?php echo $treeId; ?>','');"  style="margin-right:25px; float:left" ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo  $this->lang->line("txt_Edit"); ?>" border="0"></a>

								<!--/*End of Added by Surbhi IV for checking version */-->	

							 <?php 	

									}

									?>

								

									

									

								</div>

							

						</div>

					

						 </div>

					  

						<div class=" lblTagName"     >

						

							

						</div>

						

					</div>

							 

							<div id="edit_doc" class="clsEditorbox1" style="display:none; width:96.5%;text-align:left;" > 

						<form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/document">

            		<div id="divEditDoc"></div>

                    <?php /*?><div id="loader"></div><?php */?>

               		<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="docTitleSaveNew(0,0);" />

                    <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="docTitleCancel();" />             

                	<input type="hidden" name="treeId" value="<?php echo $treeId; ?>">

            	</form>

            	

						

					</div>

							

						  

				

					<div id="0notes"   style="width:100%; float:left; display:none;" >

						<?php 

						$firstSuccessor = 0;

						if(count($Contactdetail) > 0)

						{

							$firstSuccessor = $Contactdetail[0]['nodeId'];			

						}

						?> 
						<div class="talkformnote">
						<form name="form10" id="form10" method="post" action="<?php echo base_url();?>notes/addMyNotes/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

							<div id="containerseed" name="containerseed" ></div>

							<span id='saveOption'></span>

							<div id="loaderSeed"></div>

							<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion0',document.form10);" class="button01"> <input style="float:left;" type="button" name="Replybutton1" value="Cancel" onClick="reply_close12(0);" class="button01">
							

							<input name="editorname1" id="editorname1" type="hidden"  value="replyDiscussion0">

							<input name="seedpredecessor" id="seedpredecessor" type="hidden"  value="0">

							<input name="seedsuccessors" id="seedsuccessors" type="hidden"  value="<?php echo $firstSuccessor;?>">

							<input name="reply" id="reply" type="hidden"  value="1">

                              <input type="hidden" name="treeId" id="treeId" value="<?php echo $treeId ?>" />
							  
							  <div id="audioRecordBox"><div style="float:left;margin-top:0.4%; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>

						</form>
						</div>
						

					</div>

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

					<div id="loader0"></div>

					

					

					<!---------  Seed div closes here ---->

		<div id="divNodeContainer" >			

					

					<?php

			  //  $this->load->helper('form'); 

		//$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post', 'enctype' => 'multipart/form-data');	

		

		// echo form_open('notes/editNotesContents1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, $attributes);

		?>

				<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?> 

					<div class="divErrorMsg" >

						<span class="errorMsg"><?php //echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

					</div>

				<?php

				}

			

				$focusId = 3;

			

				$rowColor1='row1';

				$rowColor2='row2';	

				$i = 1;

				if(count($Contactdetail) > 0)

				{		//echo "test";print_r($Contactdetail);				 

					foreach($Contactdetail as $keyVal=>$arrVal)

					{	 //echo $arrVal['userId'];

						if(!empty($arrVal))

						{

							$userDetails1	= 	$this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);	

							$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);

							$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);			

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

						 <div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onmouseout="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor <?php echo $searchOffset; ?>"  id="noteLeafContent<?php echo $arrVal['nodeId']; ?>"> 

						<div style="height:30px; padding-bottom:0px;" >
						
						<ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; display:none" class="content-list ulNodesHeader">

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

								

								$total		=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);

								$tag_container='';

								if($total==0)

								{

									$total='';

									$tag_container=$this->lang->line('txt_Tags_None');

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

									$appliedLinks=$this->lang->line('txt_Links_None') ;

								}

								else

								{

									 

									   

									   if(count($docTrees1)>0)

									   {

										   $appliedLinks .= $this->lang->line('txt_Document').': ';

										   foreach($docTrees1 as $key=>$linkData)

										   {

												 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

												

											}

											$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

									   }	

										

										

										 if(count($docTrees3)>0)

										 {

											$appliedLinks.=$this->lang->line('txt_Chat').': ';	

											foreach($docTrees3 as $key=>$linkData)

										   {

												 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

												

											}

											$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

										 }	

										

										if(count($docTrees4)>0)

										{

											$appliedLinks.=$this->lang->line('txt_Task').': ';	

											foreach($docTrees4 as $key=>$linkData)

											{

												 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

												

											}

											$appliedLinks=substr($appliedLinks, 0, -2)."\n";

										}	

										

										if(count($docTrees6)>0)

										{

											$appliedLinks.=$this->lang->line('txt_Notes').':';	

											foreach($docTrees6 as $key=>$linkData)

											{

												 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

											}

											$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

										}

										

										if(count($docTrees5)>0)

										{

										

											$appliedLinks .=$this->lang->line('txt_Contacts').': ';	

											foreach($docTrees5 as $key=>$linkData)

										   {

												 $appliedLinks.="\n - ".trim(strip_tags($linkData['name'])).",";

												

											}

											$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

										}

										

										if(count($docTrees7)>0)

										{

										

											

												 

											$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	

											foreach($docTrees7 as $key=>$linkData)

										   {

												 

												 if($linkData['docName']=='')

												 {

													$appliedLinks.="\n - ".$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";

												 }

												 else

												 {

													$appliedLinks.="\n - ".$linkData['docName']."_v".$linkData['version'].", ";

												 }

												

											}

										

											

											$appliedLinks=substr($appliedLinks, 0, -2)."\n"; 

										}	

										

										 if(count($docTrees9	)>0)

												{

												

													$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	

													foreach($docTrees9 as $key=>$linkData)

												   {

														 $appliedLinks.="\n - ".$linkData['title'].", ";

														

													}

													$appliedLinks=substr($appliedLinks, 0, -2);

												

												} 

									

								}

								

								?>	

								

								<li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 710, 500, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo html_entity_decode(strip_tags($appliedLinks));?>" border="0" ><strong><?php echo $total; ?></strong></a></li>	

								

								

							<?php

							

								if($leafTreeId)

								{

								   $total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);

								   $talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

								}

								else

								{

								   $total='';

								   $talk='';

								}   

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

								 /*<!--Changed by Surbhi IV -->	*/

									//echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
									//$leafdataFullContent=stripslashes($arrVal['contents']);
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
									
									<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId ?>"/>
									
									<?php

									//echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.strip_tags($arrVal['contents']).'" border="0" >'.$total.'</a></li>';

									/*<!--End of Changed by Surbhi IV -->	*/

								}

								$lastnode=$arrVal['nodeId'];

			

								?>

									</ul>

						</div>

						

					   <div class="clr"></div> 

						<div>    

						<div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >   

                            <div  class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p></div>

                            

                            <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?></div>

						</div>			

								 <div class="clr"></div> 

								 <div style="height:30px;" > 

								 <div class="lblNotesDetails normalView" id="normalView<?php echo $arrVal['nodeId'];?>" style="display:none;">

									 <div class="style2"  >
	
									 <!--Changed by Surbhi IV -->
	
									 <div style="float:left;"><a style="margin-right:25px;"  href="javascript:addLeaf(<?php echo $arrVal['leafid'];?>,<?php echo $treeId;?>,<?php echo $position;?>,<?php echo $arrVal['nodeId'];?>,<?php echo $arrVal['successors'];?>);" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock2"';}else { echo 'class="disnone2"';} ?>><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a></div>
	
									 <!--End of Changed by Surbhi IV -->
	
									 <?php echo $userDetails1['userTagName'];?>&nbsp;&nbsp; 
	
								
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
	
									<div class="editDocumentOption <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "disblock2" ;}else { echo "disnone2" ; } ?> ">
	
								
	
								<a style="margin-right:25px;" href="javascript:editNotesContents_1(<?php echo $position;?>,<?php echo $focusId;?>,<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,'<?php echo $this->lang->line('txt_Done');?>',<?php echo $arrVal['successors'];?>,<?php echo $arrVal['leafid'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>	
	
									</div>
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

								

							<span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span>	                

							

							<span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;">

							<span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">

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

								<div id="divResponseTags<?php echo $arrVal['nodeId'] ; ?>" <?php if($dispResponseTags!=''){ echo 'style="display:block"';} else { echo'style="display:none"' ; } ?> ><?php

								

							//	echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					

						echo $this->lang->line('txt_Response_Tags').':<span id= "responseTags'.$arrVal['nodeId'].'"> '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'</span><br>';			

								$nodeTagStatus = 1;

								?>

								</div>	

								<?php	

								

							 //Contact Tag container

								?>			

								<div id="divContactTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispContactTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> ><?php

							//	echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					

							echo $this->lang->line('txt_Contact_Tags').':<span id= "contactTags'.$arrVal['nodeId'].'"> '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'</span><br>';

								$nodeTagStatus = 1;	

								?>

								</div>

								<?php	

								

							if($dispUserTags != '')		

							{

								?>			

								<div><?php

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

									<span id="spanTagNew<?php echo $arrVal['nodeId'];?>"><input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" /></span>

								</div>

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

								<div class="talkformnote"><div id="addleaf<?php echo $position;?>" style="display:none;" ></div></div>

							</div>	

									<div class="clr"></div> 

						</div>

						</div>
						
						
						<!--Manoj: edit leaf content-->
					<div class="<?php echo $nodeBgColor; ?> handCursor">
					<div class="talkformnote">
					<div id="editleaf<?php echo $position;?>" style="display:none;"></div>
					</div>
					</div>
					
					<div id="loader<?php echo $arrVal['nodeId']; ?>"></div>

					<?php

							$focusId = $focusId+2;	

							$position++;

								$i++;

							}

							

					}

				}

				?>

				

				</div>	

				</div>	

	</div>

</div>

<div>

<?php $this->load->view('common/foot.php');?>

<?php $this->load->view('common/footer');?>

</div>

</body>

</html>

<?php  include_once('notes_js.php');?>

<script language="javascript">



// Parv - Keep Checking for tree updates every 5 second

        <!--Updated by Surbhi IV-->

		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);	
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);

		<!--End of Updated by Surbhi IV-->



var leafOrder1;

var treeId1;

var nodeId1;

var xmlHttp;

var xmlHttp4;

var xmlHttpTree;

var workSpaceId1;

var workSpaceType1;

var position1;

var iframeid1;

var spanTaskView1;

var id1;

var textDone1;



function reply_1(id,focusId,treeId,workSpaceId,workSpaceType,nodeId,textDone,successors)

{ 

	var paras = document.getElementsByTagName('div');

		// create a for loop to iterate over the paras array

	for (var i =0; i < paras.length; i++)

	{

		// get the current paragraph in the array

		current_para = paras[i];

		// use indexOf to check if 'hide' is in the className string

		// indexOf returns -1 if no match is found - so if it doesn't equal -1, a match was found!

		if (current_para.className.indexOf('cls_leafcontents') != -1)

		{

			current_para.style.display = 'none';

		}

	}

	var divid=id+'notes';

	document.getElementById(divid).style.display='';

	document.getElementById(divid).innerHTML ='<form name="form1'+id+'" id="form1'+id+'" method="post" action="<?php echo base_url();?>notes/addMyNotes/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'"><textarea style="resize:none;"  rows="10" cols="95" name="replyDiscussion'+nodeId+'" id="replyDiscussion'+nodeId+'"></textarea><input type="button" name="Replybutton" value="'+textDone+'" onClick="validate_dis(\'replyDiscussion'+nodeId+'\',document.form1'+id+')"   class="button01"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close('+id+');" class="button01"><input name="editorname1" type="hidden"  value="replyDiscussion'+nodeId+'"/><input name="predecessor" type="hidden"  value="'+nodeId+'"/><input name="successors" type="hidden"  value="'+successors+'"/><input name="reply" type="hidden"  value="1"></form>';

	chnage_textarea_to_editor('replyDiscussion'+nodeId);
	

	document.getElementByClass('cls_leafcontents').style.display='';

	

	

							

}





	

function reply_close(id){

	divid=id+'notes';

 	document.getElementById(divid).style.display='none';

}





function editNotesContents(id,focusId)

{

	var divid=id+'edit_notes';

	//alert (divid);

	document.getElementById(divid).style.display='';

}

function edit_close(id){

	divid=id+'notes';

 	document.getElementById(divid).style.display='none';

}

function edit_close1(id,nodeId){



	//alert(nodeId);

	// document.getElementById('iframeIdTaskEdit'+id).src="none";

	//	document.getElementById('spanTaskView'+id).style.display="";

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+nodeId;

		

		

	//divId = 'editLeaf';

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

	xmlHttp1.onreadystatechange = function(){}

	divid=id+'notes';

 	document.getElementById(divid).style.display='none';

}



</script>



<script>



function validateTagUpdate ()

{

	if (document.getElementById('searchTags').value=='')

	{

		jAlert ('<?php echo $this->lang->line('select_tags_update'); ?>');

		return false;

	}

}

function showHideCreateTag ()

{

	if (document.getElementById('showCreateTag').style.display=='none')

	{

		document.getElementById('showCreateTag').style.display='block';

	}

	else

	{

		document.getElementById('showCreateTag').style.display='none';

	}

	if (document.getElementById('createTagButton').style.display=='none')

	{

		document.getElementById('createTagButton').style.display='block';

	}

	else

	{

		document.getElementById('createTagButton').style.display='none';

	}

}

</script>

<script>











	



</script>

<script>



function showLinks(artifact)

	{

	var toMatch = document.getElementById('searchLinks'+artifact).value;

	var val = '';

	

		//if (toMatch!='')

		if ((artifact=='Doc') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($docArtifactLinks2 as $key=>$value)

		{

		?>

			

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo $value;?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($docArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} //end if







		//if (toMatch!='')

		if ((artifact=='Dis') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($disArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($disArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

		

		

		

		//if (toMatch!='')

		if ((artifact=='Chat') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($chatArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($chatArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

		

		



		//if (toMatch!='')

		if ((artifact=='Activity') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($activityArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($activityArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

		



		//if (toMatch!='')

		if ((artifact=='Notes') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($notesArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($notesArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

		

		

		

		//if (toMatch!='')

		if ((artifact=='Contact') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($contactArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($contactArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="doclinks[]" id="doclinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('sectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

		

		

		//if (toMatch!='')

		if ((artifact=='Import') && (toMatch!='('))

		{

			var count = '';

			var sectionChecked = '';

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($importArtifactLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				<?php if (in_array($key,$appliedDocLinkIds)) { ?>

					if (sectionChecked=='')

					{

						sectionChecked = <?php echo $key; ?>;

					}

					else

					{

						sectionChecked = sectionChecked + ','+<?php echo $key; ?>;

					}

				<?php } ?>

				

				val += '<input type="checkbox" name="importlinks[]" id="importlinks[]" value="<?php echo $key;?>" checked="checked"/><?php echo addslashes($value);?><br />';

				//document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

		<?php



		//foreach($viewTags2 as $tagData)	

		foreach ($importArtifactNotLinks2 as $key=>$value)

		{

		?>

			var str = '<?php echo addslashes($value); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				count = count + ','+<?php echo $key; ?>;

				

				val += '<input type="checkbox" name="importlinks[]" id="importlinks[]" value="<?php echo $key;?>"/><?php echo addslashes($value);?><br />';

				document.getElementById('showLinks'+artifact).innerHTML = val;

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

        }

        ?>

		

			if (count!='')

			{

				document.getElementById('importSectionLinkIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			else

			{

				document.getElementById('sectionChecked').value = 0;

			}

		} // end if

	}

	

	





</script>



	

	 <script language="javascript">

		<?php 

			if ($open=='open')

			{

		?>

				newLink (<?php echo $linkSpanOrder; ?>);

		<?php

			}

		?>

</script>



    <!--<script language="javascript" src="<?php //echo base_url();?>js/task.js"></script>-->