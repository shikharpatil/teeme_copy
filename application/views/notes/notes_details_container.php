<?php

				$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

				$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

				

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





<?php 

				

				if ($treeId == $this->uri->segment(8))

					$nodeBgColor = 'nodeBgColorSelect';

				else

					$nodeBgColor = 'seedBgColor';

		?>	 

			

				<div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"   >

					 

<?php			$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);

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

                              $opt = $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId, $workSpaceType);	

								if ($opt)

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
								<li  class="talk"><a id="liTalk<?php echo $leafTreeId?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $leafTreeId ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','1','')" title="<?php echo $latestTalk ?>" border="0" ><?php echo $total; ?></a></li>
								<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $leafTreeId ?>"/>
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

							<div style="float:left;"><a  style="margin-right:25px; float:left" id="aAddNewNote" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock2"';}else { echo 'class="disnone2"' ; } ?> href="javascript:void(0);" onClick="reply(0,0);"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a>	</div>

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

					{	 

						$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

						$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);

						$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);			

						

						if ($arrVal['nodeId'] == $this->uri->segment(8))

							$nodeBgColor = 'nodeBgColorSelect';

						else

							$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

							

							

							

									  

				?>	

				

						<div class="clr"></div> 

					 <div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onmouseout="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor" id="noteLeafContent<?php echo $arrVal['nodeId']; ?>" > 

					<div style="height:30px; padding-bottom:0px;" ><ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; display:none" class="content-list ulNodesHeader">

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

					<div  >    

					<div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >   

								<div  class="autoNumberContainer"  ><p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p></div>

                                

								<div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?></div>

					</div>			

								

							 <div class="clr"></div> 

							<div style="height:30px;" > 

							 <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none"    >

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

							<div class="editDocumentOption <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  >

						

						<a style="margin-right:25px;"  href="javascript:editNotesContents_1(<?php echo $position;?>,<?php echo $focusId;?>,<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,'<?php echo $this->lang->line('txt_Done');?>',<?php echo $arrVal['successors'];?>,<?php echo $arrVal['leafid'];?>)" ><img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0"></a>	

						

					

						

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
						<?php /*?><div class="talkformnote">
						<div id="editleaf<?php echo $position;?>" style="display:none;"></div>
						</div><?php */?>

						</div>

						

					<div class="divEditLaef" >
					<div class="talkformnote">
							<div id="addleaf<?php echo $position;?>" style="display:none;"></div>
					</div>

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

				?>

				

				</div>	