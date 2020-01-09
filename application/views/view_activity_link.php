<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	<script language="javascript" src="<?php echo base_url();?>js/document.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>	

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	</head>	

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

	

<script language="JavaScript1.2">mmLoadMenus();</script>

<!--webbot bot="HTMLMarkup" startspan --><script>

if (!document.layers)

document.write('<div id="divStayTopLeft" style="position:absolute">')

</script>

<layer id="divStayTopLeft">



<!--EDIT BELOW CODE TO YOUR OWN MENU-->



<?php $this->load->view('common/float_menu_view_doc');?>



<!--END OF EDIT-->

                                      

</p>

</layer>



<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>

		

<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">

  <tr>

    <td valign="top">

        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td align="left" valign="top">

			<!-- header -->	

			<?php $this->load->view('common/header'); ?>

			<!-- header -->	

			</td>

          </tr>

          <tr>

            <td align="left" valign="top">

				<?php $this->load->view('common/wp_header'); ?>

			</td>

          </tr>

          <tr>

            <td align="left" valign="top">

			<!-- Main menu -->

			<?php

			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

			 $this->load->view('common/artifact_tabs', $details); ?>

			<!-- Main menu -->	

			</td>

          </tr>

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="76%" height="8" align="left" valign="top"></td>

                  <td width="24%" align="left" valign="top"></td>

                </tr>

                <tr>

                  <td colspan="2" align="left" valign="top">

					<!-- Main Body -->

					<table width="100%" border="0" cellspacing="0" cellpadding="0">

								<tr>

								  <td height="18" colspan="2" bgcolor="#FFFFFF">

									

									

										<table width="100%">

											<tr>

												<td align="left" valign="top" class="tdSpace">

												<ul class="rtabs">

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>

                <li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>

				<li><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>"><span><?php echo $this->lang->line('txt_Calendar_View');?></span></a></li>

            	<li><a href="<?php echo base_url()?>view_activity/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" class="current"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>	

                                                </ul>

												</td>

											<td align="right" valign="middle" class="tdSpace">&nbsp;</td>

											</tr>

											<tr>

	<td align="right" valign="middle" class="tdSpace" colspan="2"><hr></td>

</tr>

										</table> 

									

									  <?php	

										$nodeBgColor = 'nodeBgColor';

										if($this->input->get('tagId') != '' && $this->input->get('node') == '')

										{

											$nodeBgColor = 'nodeBgColorSelect';

										}

										?>		      

								  </td>

								</tr>

								<?php

								if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

								{

								?> 

								<tr><td height="18" colspan="2"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td></tr>

											

								<?php

								}

								?>

								<tr>

								  <td  colspan="2"><?php echo $this->lang->line('txt_Links_Applied');?>:<br><br></td>

							  </tr>

															

								<tr>

								  <td  colspan="2"><table>

                                    <?php 

										$arrNodeIds = array();

										$arrOldTreeVersions = array();

										

										//echo "treeid= " .$treeId; exit;

										

										$arrNodeIds = $this->activity_db_manager->getNodeIdsByTreeId($treeId);

										//print_r ($arrNodeIds); exit;

/*										$oldTreeVersions = $this->document_db_manager->hasparent($treeId);





										if ($oldTreeVersions!=0)

										{

											$arrOldTreeVersions = explode(',',$oldTreeVersions);



											$arrNewNodeIds = array();



											foreach ($arrOldTreeVersions as $key=>$treeId)

											{	

												$newNodeIds = $this->document_db_manager->getNodeIdsByTreeId($treeId);

												$arrNodeIds = array_merge($arrNodeIds, $newNodeIds);

																		

											}



										}

*/

										//print_r ($arrNodeIds); exit;

										

										$nodeIds = implode(',', $arrNodeIds);

										

										if (!empty($nodeIds))

											$nodeIds		.= ','.$treeId;

										else

											$nodeIds		= $treeId;

											

										//echo "<li>nodeids= " .$nodeIds ."<li>"; exit;



										//$leafLinks 		= $this->document_db_manager->getLeafLinksByLeafIds($nodeIds, 2);

										

										$arrNewNodeIds = explode (',',$nodeIds);

										$arrDocTreeIds = array();	

										



										

										foreach($arrNewNodeIds as $key => $value)

										{

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 1);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Document');

													}					

													$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}

											

											

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 2);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Discussion');

													}					

													$disArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}	

											

											

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 3);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Chat');

													}					

													$chatArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}

											

											

											

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 4);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Activity');

													}					

													$activityArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}										

		

		

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 5);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Contacts');

													}					

													$contactArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}	

											

											

											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 6);

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												

												if(count($docTrees) > 0)

												{

												$i = 1;	

													foreach($docTrees as $data)

													{	

													$treeName = $data['name'];

													$arrDocTreeIds[] = $data['treeId'];	

													

													if(trim($treeName) == '')

													{

														$treeName = $this->lang->line('txt_Notes');

													}					

													$notesArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	



													$i++;

													}					

												}

											}

											

											

											$getTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($value);			

											if (!empty($getTrees))

											{	

												$docTrees = $getTrees;

												if(count($docTrees) > 0)

												{

													$i = 1;	

													foreach($docTrees as $data)

													{	

													$docName = $data['docName'];

													$arrImportFileIds[] = $data['docId'];	

													if(trim($docName) == '')

													{

														$docName = $this->lang->line('txt_Imported_Files');

													}											

				

													$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";

													$i++;

													}						

												}	

											}											

										}

										if ($docArtifactLinks)

											echo $this->lang->line('txt_Document').': '.implode(', ',$docArtifactLinks).'<br><br>';

										if ($disArtifactLinks)

											echo $this->lang->line('txt_Discussions').': '.implode(', ',$disArtifactLinks).'<br><br>';

										if ($chatArtifactLinks)

											echo $this->lang->line('txt_Chat').': '.implode(', ',$chatArtifactLinks).'<br><br>';

										if ($activityArtifactLinks)

											echo $this->lang->line('txt_Activity').': '.implode(', ',$activityArtifactLinks).'<br><br>';

										if ($notesArtifactLinks)

											echo $this->lang->line('txt_Notes').': '.implode(', ',$notesArtifactLinks).'<br><br>';

										if ($contactArtifactLinks)

											echo $this->lang->line('txt_Contacts').': '.implode(', ',$contactArtifactLinks).'<br><br>';

										if ($importArtifactLinks)

											echo $this->lang->line('txt_Imported_Files').': '.implode(', ',$importArtifactLinks).'<br><br>';





											if(count($importArtifactLinks) == 0 && count($contactArtifactLinks)==0 && count($notesArtifactLinks)==0 

											&& count($activityArtifactLinks)==0 && count($chatArtifactLinks)==0 && count($disArtifactLinks)==0 

											&& count($docArtifactLinks)==0)	

											{

												echo $this->lang->line('msg_tags_not_available');

											}

																						

/*										$allLinks 	= array();

										$linkStatus		= 0;	

														

											if(count($leafLinks) > 0)

											{												

												foreach($leafLinks as $key => $arrLinkData)

												{			

													

													foreach($arrLinkData as $key1 => $linkData)

													{

																								

														$linkLink = $this->document_db_manager->getLinkByLinkedTreeId( $linkData['treeId'] );	

													

														if(count($linkLink) > 0)

														{	

															if($key == 'response')

															{	

														

																$allLinks[] = '<a href="'.base_url().$linkLink[0].'" class="blue-link-underline">'.strip_tags($linkData['treeName']).'</a><br>'; 														

															}

														}

													} 

																											

												}													

											}

*/

									

									/*			

									if(count($allLinks) > 0)		

									{

										?>			

										<tr>

											<td><?php echo implode('<br>', $allLinks);?> </td>

										</tr>

										<?php	

										$linkStatus	= 1;			

										}



										if($linkStatus == 0)		

										{

										?>			

										<tr>

											<td><?php echo $this->lang->line('txt_None');?> </td>

										</tr>

										<?php																

									}	

									*/	

										?>			

                                   

                                  </table></td>

							  </tr>

								<tr>

	<td align="right" valign="middle" class="tdSpace" colspan="2"><hr></td>

</tr>

		

					</table>

				<!-- Main Body -->

				<!-- Right Part-->			

				<!-- end Right Part -->

				</td>

                </tr>

            </table></td>

          </tr>

          <tr>

            <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>

          </tr>

          <tr>

            <td align="center" valign="top" class="copy">

			<!-- Footer -->	

				<?php $this->load->view('common/footer');?>

			<!-- Footer -->

			</td>

          </tr>

        </table>

    </td>

  </tr>

  <tr>

    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

</table>

</body>

</html>

