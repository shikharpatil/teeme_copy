<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<?php //echo "workspaceId= " .$workSpaceId; exit;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';		

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

</head>

<body>

<script language="JavaScript1.2">mmLoadMenus();</script>

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

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

          <td align="left" valign="top" bgcolor="#FFFFFF">

          	<table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" height="8" align="left" valign="top"></td>

                <td width="24%" align="left" valign="top"></td>

              </tr>

              <tr>

                <td colspan="2" align="left" valign="top">

                  <!-- Main Body -->

					<span id="fullView">

                  <table width="100%" border="0" cellspacing="2" cellpadding="2">

                    <tr>

                      <td width="50%" valign="top" class="grbg">

                      <table width="100%"  border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td>

							<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Tasks'); ?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalTask','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consTask','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalTask','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrTasks) > 0)

								{	

									$i = 0;										 

									foreach($arrTasks as $treeId=>$treeName)

									{	

										if($i == 5)

										{

											break;

										}

										$i++;

										if(substr_count($treeName,'untitle') > 0)

										{		

											$taskName = trim ($this->document_db_manager->getFirstLeafInfoByTreeId($treeId));															

										?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($taskName);?> </a></td>

									</tr>

									<?php

										}		

										else

										{	

											?>

											<tr>

												<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($treeName);?> </a></td>

											</tr>

											<?php

										}									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table>



						</td>

                        </tr>

                        <tr>

                          <td>

							<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Contacts');?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalContact','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consContact','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalContact','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrContacts) > 0)

								{		

									$i = 0;											 

									foreach($arrContacts as $treeId=>$treeName)

									{		

										if($i == 5)

										{

											break;

										}

										$i++;												

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($treeName,'<b><em><span>');?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table>



						</td>

                        </tr>

                        <tr>

                          <td>

						

						<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Documents');?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalDoc','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consDoc','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalDoc','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrDocuments) > 0)

								{	

									$i = 0;										 

									foreach($arrDocuments as $treeId=>$treeName)

									{	

										if($i == 5)

										{

											break;

										}

										$i++;												

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&amp;doc=exist" class="blue-link-underline"><?php echo strip_tags($treeName,'<b><em><span>'); ?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table></td>

                        </tr>

                      </table>                      

                      </td>

                      <td valign="top" class="grbg"><table width="100%"  border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td>



						<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Chats');?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalChat','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consChat','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalChat','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrChats) > 0)

								{	

									$i = 0;														 

									foreach($arrChats as $treeId=>$treeName)

									{	

										if($i == 5)

										{

											break;

										}

										$i++;													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($treeName,'<b><em><span>');?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table>

						</td>

                        </tr>

                        <tr>

                          <td>

						<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Discussions');?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalDis','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consDis','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalDis','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrDiscussions) > 0)

								{	

									$i = 0;												 

									foreach($arrDiscussions as $treeId=>$treeName)

									{	

										if($i == 5)

										{

											break;

										}

										$i++;													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($treeName,'<b><em><span>');?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table>



						</td>

                        </tr>

                        <tr>

                          <td>

							<table width="100%"  border="0" cellspacing="1" cellpadding="2">

							<tr>

                              <td bgcolor="#FFFFFF">

							<table width="100%"  border="0" cellspacing="0" cellpadding="0">	

                            <tr>

                              <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Notes');?></td>

                              <td align="right" bgcolor="#FFFFFF">

								<?php

								if($workSpaceId == 0)

								{	

								?>	

									<a href="javascript:void(0)" onclick="showHideContents('normalNotes','fullView')"><?php echo $this->lang->line('txt_All');?></a> | 

									<a href="javascript:void(0)" onclick="showHideContents('consNotes','fullView')"><?php echo $this->lang->line('txt_Consolidated_View');?></a>

								<?php

								}

								else

								{

								?>

									<a href="javascript:void(0)" onclick="showHideContents('normalNotes','fullView')"><?php echo $this->lang->line('txt_All');?></a>

								<?php

								}

								?>									

								</td>

                            </tr>

							</table>

							</td>

						</tr>

						 <tr>

                              <td colspan="2" bgcolor="#FFFFFF">

								

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<?php

								if(count($arrNotes) > 0)

								{

									$i = 0;												 

									foreach($arrNotes as $treeId=>$treeName)

									{		

										if($i == 5)

										{

											break;

										}

										$i++;																

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags($treeName,'<b><em><span>');?> </a></td>

									</tr>

									<?php									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								

								

						</td></tr>				

                          </table>				

						</td>

                        </tr>

                      </table></td>

                    </tr>

                    <tr>

                      <td colspan="2" valign="top" class="grbg"><table width="100%"  border="0" cellspacing="1" cellpadding="2">

                          <tr>

                            <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Tags');?></td>

                          </tr>

                          <?php

						if(count($treeTags) > 0)

						{												

							foreach($treeTags as $tagData)

							{				

								$tagLink	= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	

								if(count($tagLink) > 0)

								{			

									?>

                          <tr>

                            <td bgcolor="#FFFFFF"><a href="<?php echo base_url().$tagLink[0];?>" class="blue-link-underline"><?php echo $tagData['comments'];?></a></td>

                          </tr>

                          <?php

								}	

							}	

						}					

						else

						{									

						?>

                          <tr>

                            <td bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

                          </tr>

                          <?php

						}				

						?>

                      </table></td>

                    </tr>

                  </table>

				</span>	

				<?php

								if($workSpaceId == 0)

								{	

								?>	

									<span id="consTask" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Tasks');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consTask')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsTasks) > 0)

									{											 

										foreach($arrConsTasks as $treeId=>$data)

										{													

											if(substr_count($data['name'],'untitle') > 0)

											{		

												$taskName = $this->document_db_manager->getFirstLeafInfoByTreeId($treeId);															

											?>

												<tr>

													<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo strip_tags($taskName,'<b><em><span>');?> </a></td>

												</tr>

										<?php

											}		

											else

											{	

												?>

												<tr>

													<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo $data['name'];?> </a></td>

												</tr>

												<?php

											}									

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>		

									<span id="consContact" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Contacts');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consContact')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsContacts) > 0)

									{											 

										foreach($arrConsContacts as $treeId=>$data)

										{													

										?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo $data['name'];?> </a></td>

										</tr>

										<?php

										

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>		

									<span id="consDoc" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Documents');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consDoc')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsDocuments) > 0)

									{											 

										foreach($arrConsDocuments as $treeId=>$data)

										{													

										?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><a href="<?php echo base_url();?>view_document/index/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>/?treeId=<?php echo $treeId;?>&amp;doc=exist" class="blue-link-underline"><?php echo $data['name'];?> </a></td>

										</tr>

										<?php

										

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>

									<span id="consChat" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Chats');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consChat')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsChats) > 0)

									{											 

										foreach($arrConsChats as $treeId=>$data)

										{													

										?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo $data['name'];?> </a></td>

										</tr>

										<?php

										

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>		

									<span id="consDis" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Discussions');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consDis')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsDiscussions) > 0)

									{											 

										foreach($arrConsDiscussions as $treeId=>$data)

										{													

										?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_discussion/node/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo $data['name'];?> </a></td>

										</tr>

										<?php

										

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>		

									<span id="consNotes" style="display:none;">

									<table width="100%" border="0" cellspacing="1" cellpadding="2">

									 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Consolidated_Notes');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'consNotes')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

									<?php

									if(count($arrConsNotes) > 0)

									{											 

										foreach($arrConsNotes as $treeId=>$data)

										{													

										?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>notes/Details/<?php echo $treeId;?>/<?php echo $data['workspaceId'];?>/type/<?php echo $data['workspaceType'];?>"><?php echo $data['name'];?> </a></td>

										</tr>

										<?php

										

										}

									}

									else

									{

									

									?>

										<tr>

										<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

										</tr>

									<?php

									}

									

									?>

									</table>

									</span>				

								<?php

								}

								?>		

								<span id="normalTask" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Tasks');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalTask')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>

								<?php

								if(count($arrTasks) > 0)

								{											 

									foreach($arrTasks as $treeId=>$treeName)

									{	

										if(substr_count($treeName,'untitle') > 0)

										{		

											$taskName = $this->document_db_manager->getFirstLeafInfoByTreeId($treeId);															

										?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $taskName;?> </a></td>

									</tr>

									<?php

										}		

										else

										{	

											?>

											<tr>

												<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $treeName;?> </a></td>

											</tr>

											<?php

										}									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>				

								<span id="normalContact" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Contacts');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalContact')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>		

								<?php

								if(count($arrContacts) > 0)

								{											 

									foreach($arrContacts as $treeId=>$treeName)

									{													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $treeName;?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>	

								<span id="normalDoc" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								 <tr>

									  <td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Documents');?></td>

									  <td align="right" bgcolor="#FFFFFF">										

											<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalDoc')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>		

								<?php

								if(count($arrDocuments) > 0)

								{											 

									foreach($arrDocuments as $treeId=>$treeName)

									{													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&amp;doc=exist" class="blue-link-underline"><?php echo $treeName;?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>	

								<span id="normalChat" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

									<tr>

										<td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Chats');?></td>

										<td align="right" bgcolor="#FFFFFF">										

										<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalChat')"><?php echo $this->lang->line('txt_Close');?></a>																								

										</td>

									</tr>		

								<?php

								if(count($arrChats) > 0)

								{											 

									foreach($arrChats as $treeId=>$treeName)

									{													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $treeName;?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>	

								<span id="normalDis" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<tr>

									<td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Discussions');?></td>

									<td align="right" bgcolor="#FFFFFF">										

									<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalDis')"><?php echo $this->lang->line('txt_Close');?></a>																								

									</td>

								</tr>				

								<?php

								if(count($arrDiscussions) > 0)

								{											 

									foreach($arrDiscussions as $treeId=>$treeName)

									{													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $treeName;?> </a></td>

									</tr>

									<?php

									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>	

								



								<span id="normalNotes" style="display:none;">

								<table width="100%" border="0" cellspacing="1" cellpadding="2">

								<tr>

									<td bgcolor="#FFFFFF" class="selectbg"><?php echo $this->lang->line('txt_Recent_Notes');?></td>

									<td align="right" bgcolor="#FFFFFF">										

									<a href="javascript:void(0)" onclick="showHideContents('fullView', 'normalNotes')"><?php echo $this->lang->line('txt_Close');?></a>																								

									</td>

								</tr>				

								<?php

								if(count($arrNotes) > 0)

								{											 

									foreach($arrNotes as $treeId=>$treeName)

									{													

									?>

									<tr>

									<td colspan="2" bgcolor="#FFFFFF"><a class="blue-link-underline" href="<?php echo base_url();?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo $treeName;?> </a></td>

									</tr>

									<?php									

									}

								}

								else

								{

								

								?>

								<tr>

								<td colspan="2" bgcolor="#FFFFFF"><?php echo $this->lang->line('txt_None');?></td>

								</tr>

								<?php

								}

								

								?>

								</table>

								</span>	

					

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

    </table></td>

  </tr>

  <tr>

    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

</table>

</body>

</html>

