<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Notes > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

<?php //$this->load->view('editor/editor_js.php');?>

	<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

<!--webbot bot="HTMLMarkup" startspan -->

</head>





<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>

<?php 

	if($this->input->get('doc') == 'new')

	{

	?>

		<body onUnload="return bodyUnload()" onLoad="showFocus(<?php echo $whoFocus;?>)">	

	<?php

	}

	else

	{	

		echo '<body onUnload="return bodyUnload()">';	

	}

	?>





<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile">



	



		<div id="content">







			<div class="menu_new">
			
			
								<!--follow and sync icon code start -->
							<ul class="tab_menu_new_for_mobile tab_for_potrait">
								
								<?php 
							/*Code for follow button*/
								$treeDetails['seedId']=$treeId;
								$treeDetails['treeName']='doc';	
								$this->load->view('follow_object_for_mobile',$treeDetails); 
							/*Code end*/
							?>	
							</ul>
							<!--follow and sync icon code end -->

								<ul class="tab_menu_new_for_mobile">

									 <li class="notes-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Notes_View');?>" ></a></li>

									 

                <li class="time-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"  title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				<li class="tag-view_sel"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" class="active"  title="<?php echo $this->lang->line('txt_Tag_View');?>"></a></li>

            	<li  class="link-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"  title="<?php echo $this->lang->line('txt_Link_View');?>"></a></li>

				 <li class="talk-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7"  title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

            	<?php

				if (($workSpaceId==0))

				{

				?>

                	<li class="share-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>

                <?php

				}

				?>

<div class="tab_for_landscape">		
					<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
								</div>						

								</ul>

								 <div class="clr"></div>

   			 </div>

			 

			 <div class="clr"></div>

			 <div>

						<div style=" width:150px;"> <?php echo $this->lang->line('txt_Tags_Applied');?>

                        	

                       </div>

						<div >

							

                                    		<?php 

												

												$arrdispTags = array();

												$arrNodeIds 	= $this->tag_db_manager->getNodeIdsByTreeId($treeId);

												



													$treeTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1, $searchDate1, $searchDate2);

													//sort ($treeTags);				

													$nodeIds		= implode(',', $arrNodeIds);

												

												if ($nodeIds)

												{	

													$leafTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($nodeIds, 2, $searchDate1, $searchDate2);	

												}

												//sort ($leafTags);										

												$simpleTags 	= array();

												$responseTags 	= array();

												$contactTags 	= array();

												$userTags		= array();	

												$tagStatus		= 0;	



												//print_r ($leafTags); exit;

												if(count($treeTags) > 0)

												{												

													foreach($treeTags as $key => $arrTagData)

													{

														foreach($arrTagData as $key1 => $tagData)

														{		
															$tag=($tagData["tagTypeId"]==3)?$tagData['tagId']:$tagData['tag'];																														

															$tagLink	= $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tag, $tagData['artifactId'], $tagData['artifactType'] );	

															//echo "here"; exit;

															if(count($tagLink) > 0)

															{		

																if($key == 'simple')

																{	

																	if (!in_array($tagData['comments'],$simpleTagsStore))	

																	{											

																		$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}

																	$simpleTagsStore[] = $tagData['comments'];

																}

																if($key == 'response')

																{	

																	if (!in_array($tagData['comments'],$responseTagsStore))	

																	{												

																		$responseTags[] = '<a href="'.base_url().$tagLink[0].'/" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}

																	$responseTagsStore[] = $tagData['comments'];

																}

																if($key == 'contact')

																{	

																	if (!in_array($tagData['comments'],$contactTagsStore))

																	{												

																		$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}

																	$contactTagsStore[] = $tagData['comments'];

																}

																if($key == 'user')

																{													
 
																	$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																}					

															}

														} 													

													}													

												}

												//echo "here= " .count($leafTags); exit;														

												if(count($leafTags) > 0)

												{												

													foreach($leafTags as $key => $arrTagData)

													{																	

														foreach($arrTagData as $key1 => $tagData)

														{																														

															$tag=($tagData["tagTypeId"]==3)?$tagData['tagId']:$tagData['tag'];
															
															$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tag, $tagData['artifactId'], $tagData['artifactType'] );	

															if(count($tagLink) > 0)

															{		

																if($key == 'simple')

																{	

																	if (!in_array($tagData['comments'],$simpleTagsStore))

																	{																											

																		$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}	

																	$simpleTagsStore[] = $tagData['comments'];

																}

																if($key == 'response')

																{

																	if (!in_array($tagData['comments'],$responseTagsStore))	

																	{							
																																							

																		$responseTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}

																	$responseTagsStore[] = $tagData['comments'];

																}

																if($key == 'contact')

																{	

																	if (!in_array($tagData['comments'],$contactTagsStore))	

																	{											

																		$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																	}

																	$contactTagsStore[] = $tagData['comments'];

																}

																if($key == 'user')

																{													

																	$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline tagm '.$high.'" rem="'.$rem.'">'.$tagData['comments'].'</a>'; 														

																}					

															}

														} 															

													}													

												}

										
									if(!empty($notesContributors))

									{
						
										foreach($notesContributors as $usr){
						
											$userTags[]="<a href='".base_url()."notes/Details/".$treeId."/".$workSpaceId."/type/".$workSpaceType."/3/0/0/".$usr['authors']."/".$tag."' remUsr='0' class='blue-link-underline userTag tagm'>".$usr['tagName']."</a>";
						
										}
						
									}	
										

									if(count($simpleTags) > 0)		

									{

										?>			

										<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Simple_Tags').': '.implode(', ', $simpleTags);?> </div>

										<?php	

										$tagStatus	= 1;			

									}

									if(count($responseTags) > 0)		

									{

										?>			

										<div style="margin-top:10px;">

											<?php echo $this->lang->line('txt_Response_Tags').': '.implode(', ', $responseTags);?> 

										</div>

										<?php	

										$tagStatus	= 1;				

									}

									if(count($contactTags) > 0)		

									{

										?>			

										<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Contact_Tags').': '.implode(', ', $contactTags);?> </div>

										<?php	

										$tagStatus	= 1;				

									}
									
									if(count($userTags) > 0)		

									{

										?>			

										<div style="margin-top:10px;"><?php echo $this->lang->line('txt_User_Tags').': '.implode(', ', $userTags);?></div>

										<?php	

										$tagStatus	= 1;					

									}

									if($tagStatus == 0)		

									{

										?>			

										<div style="margin-top:10px;"><?php echo $this->lang->line('txt_None');?> </div>

										<?php																

									}		

									?>			

                                   

                                  			

                        </div>                     

                   </div>

				   <div class="clr"></div>

				   

				   

					<?php 



$tagId = $this->uri->segment(8);

$nodeId = $this->uri->segment(9);

$tagType = $this->uri->segment(11);



if($tagId || $nodeId)

{

				if ($nodeId == $treeId)

					$nodeBgColor = 'seedBgColor';

				else

					$nodeBgColor = '';

			

		if (!empty($nodeBgColor))

		{										

?>		

		<table width="100%" border="0" cellspacing="0" cellpadding="0">	

			<tr class="<?php echo $nodeBgColor;?>">				

				<td id="<?php echo $position++;?>" class="handCursor">

					<?php //echo stripslashes($arrDiscussionDetails['name']); 

					echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($treeDetail['name'],250,1).'</a>';

					

					?><br>

				</td>

			</tr>

        </table>

<?php

		}

?>        



	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<?php

	$totalNodes = array();

	$nodeBgColor = '';

	if(count($Contactdetail) > 0)

	{		//print_r($arrDiscussions);					 

		foreach($Contactdetail as $keyVal=>$arrVal)

		{

			//echo "<li>nodeId= " .$arrVal['nodeId'];

			//print_r ($arrVal);

			$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);

			

			//print_r ($attachedTags);

			$count = 0;

			foreach($attachedTags  as $key => $arrTagData)

			{																	

				foreach($arrTagData  as $key1 => $tagData)

				{	

					// 2= simple tags

					// 3 = response tags

					// 5= contact tags

					if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag

					{

						//if ($tagData['tagId'] == $this->uri->segment(10))

							//$count++;		

						$tagComment = $this->tag_db_manager->getTagCommentByTagId($this->uri->segment(10));

						if ($tagData['comments']==$tagComment)

							$count++;					

					}

					else if ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag

					{	

							$count++;

					}

				}

			}		

			

				if ($count != 0)

					$nodeBgColor = 'seedBgColor';

				else

					$nodeBgColor = '';				

			//echo "<li>nodeBgColor= " .$nodeBgColor;

			//print_r ($attachedTags);	

			

			$totalNodes[] = $arrVal['nodeId'];

		?>			

      <tr>

       

        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">		

		<table width="100%" border="0" cellspacing="2" cellpadding="2">

			<?php

			if (!empty($nodeBgColor))

			{

			?>

			<tr class="<?php echo $nodeBgColor;?>">				

				<td colspan="3" id="<?php echo $position++;?>" class="handCursor">

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



					?>                   

					<?php

					echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';



					?><br>

				</td>

			</tr>

            <?php

			}

            ?>



			</table>

	

		</td>

        </tr>

		

		<?php

		}

	}

	 

?>

    </table>



</div>

<?php

}

?>

			 

			 

		

			
<div class="clr"></div>

        <div> <input type="button" value="Go" id="go" class="buttonLogin" /> <input type="button" value="Clear" id="clear" class="buttonLogin" /></div>

   		<div id="leaves">

		<?php 

        

		$tagId = $this->uri->segment(8);

		$nodeId = $this->uri->segment(9);

		$tagResponseId = $this->uri->segment(10);

		$tagType = (isset($_GET['tagType']))?$_GET['tagType']:0;

		$usr = (isset($_GET['usr']))?$_GET['usr']:0;



		

		if(!isset($tagResponseId))unset($_SESSION['tagLeaves']);



		if(array_key_exists($tagResponseId,$_SESSION['tagLeaves'])){

			if(isset($_GET['rem']) && $_GET['rem']==1){

				unset($_SESSION['tagLeaves'][$tagResponseId]);

			}

		}

		else if(!isset($_GET['rem']) || $_GET['rem']!=1){

			$_SESSION['tagLeaves'][$tagResponseId][0] = $tagId;

			$_SESSION['tagLeaves'][$tagResponseId][1] = $nodeId;

			$_SESSION['tagLeaves'][$tagResponseId][2] = $tagType;

		}

		

		if($usr!='' && !$_GET['remUsr']){

			$_SESSION['usrLeaves'][$usr]=$usr; 

		}

		

		if(isset($_GET['remUsr']) && $_GET['remUsr']!=0){

			unset($_SESSION['usrLeaves'][$usr]);

		}

			
				
			   $this->load->view("notes/view_tag_leaves_for_mobile");

				?>





		</div><!--leaves div end-->
				

																

														

	

		

			

	</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>

<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>