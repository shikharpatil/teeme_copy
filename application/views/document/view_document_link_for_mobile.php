<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head');?>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
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
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile" style="font-size:1em;">
      <div id="content">
      
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
			 ?>
      <!-- Main menu -->
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
    
      <td align="left" valign="top" bgcolor="#FFFFFF">
	  <?php //echo $this->config->item('page_width')-55;?>
    <table width="100%"  border="0"  cellpadding="0" cellspacing="0">
          <tr>
        <td colspan="2" align="left" valign="top"><!-- Main Body -->
              
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                  <td height="18" colspan="2" bgcolor="#FFFFFF"><table width="100%">
                      <tr>
                      <td align="left" valign="top" class="tdSpace"><div class="menu_new" >
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
                          <li class="document-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1"  title="<?php echo $this->lang->line('txt_Document_View');?>" ></a></li>
                          <li class="time-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=2" title="<?php echo $this->lang->line('txt_Time_View');?>" ><span></span></a></li>
                          <li class="tag-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=3"  title="<?php echo $this->lang->line('txt_Tag_View');?>" ><span></span></a></li>
                          <li class="link-view_sel"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=4" class="active" title="<?php echo $this->lang->line('txt_Link_View');?>" ><span></span></a></li>
                          <li class="talk-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=7" title="<?php echo $this->lang->line('txt_Talk_View');?>"><span></span></a></li>
                          <?php
					if (($workSpaceId==0))
					{
				?>
                          <li class="share-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" ><span></span></a></li>
                          <?php
					}
				?>
				<div class="tab_for_landscape">
                          <li id="treeUpdate"></li>
						  
						  <?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>				
		</div>		  
                          <div class="clr"></div>
                        </ul>
                        </div></td>
                      <td align="right" valign="middle" class="tdSpace">&nbsp;</td>
                    </tr>
                    </table>
                <?php	
										$nodeBgColor = 'nodeBgColor';
										if($this->input->get('tagId') != '' && $this->input->get('node') == '')
										{
											$nodeBgColor = 'seedBgColor';
										}
										?></td>
                </tr>
            <?php
								if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
								{
								?>
            <tr>
                  <td height="18" colspan="2"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
                </tr>
            <?php
								}
								?>
            <tr>
                  <td  colspan="2"><?php echo $this->lang->line('txt_Links_Applied');?>:<br>
                <br></td>
                </tr>
            <tr>
                  <td  colspan="2"><?php 
										$arrNodeIds = array();
										$arrOldTreeVersions = array();
										
										$arrNodeIds = $this->document_db_manager->getNodeIdsByTreeId($treeId);
							
										
										$nodeIds = implode(',', $arrNodeIds);
										
										if (!empty($nodeIds))
											$nodeIds		.= ','.$treeId;
										else
											$nodeIds		= $treeId;
										
										$arrNewNodeIds = explode (',',$nodeIds);
										$arrDocTreeIds = array();	
										
                                
										
										foreach($arrNewNodeIds as $key => $value)
										{
											$getTrees = $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 1);
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
													if (!in_array(strip_tags($treeName),$docLinksStore))
													{				
														$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>'; 	
													}
													$docLinksStore[] = strip_tags($treeName);
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
													if (!in_array(strip_tags($treeName),$disLinksStore))
													{					
														$disArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>';   	
													}
													$disLinksStore[] = strip_tags($treeName);
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
													if (!in_array(strip_tags($treeName),$chatLinksStore))
													{				
														$chatArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>';  	
													}
													$chatLinksStore[] = strip_tags($treeName);
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
													if (!in_array(strip_tags($treeName),$activityLinksStore))				
													{
														$activityArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>'; 	
													}
													$activityLinksStore[] = strip_tags($treeName);
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
													if (!in_array(strip_tags($treeName),$contactLinksStore))	
													{					
														$contactArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>';  	
													}
													$contactLinksStore[] = strip_tags($treeName);
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
													if (!in_array(strip_tags($treeName),$notesLinksStore))					
													{
														$notesArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["treeId"].'&option=4">'.wordwrap(strip_tags($treeName),15,"\n",true).'</a>';  	
													}
													$notesLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($value,'');	
												
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
													
						
													if (!in_array($docName.'_v'.$data['version'],$importLinksStore))	
													{
							
														$importArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data["docId"].'&option=4">'.$docName.'_v'.$data["version"].'</a>'; 
													}
													$importLinksStore[] = $docName.'_v'.$data['version'];
													$i++;
													}						
												}	
											}	
											
											
											$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($value,'' );	
											
											
											if (!empty($docTrees9))
											{	
												$docTrees = $docTrees9;
												
												if(count($docTrees) > 0)
												{
												$i = 1;	
													foreach($docTrees as $data)
													{	
													$urlName = $data['title'];
													$urlTreeIds[] = $data['artifactId'];	
													
													if(trim($urlName) == '')
													{
														$urlName = $this->lang->line('txt_URL');
													}	
													if (!in_array(strip_tags($urlName),$urlNameStore))					
													{
														
														$urlStore[] = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&linkedTreeId='.$data['urlId'].'&option=4">'.strip_tags($urlName).'</a>'; 
															
													}
													$urlNameStore[] = strip_tags($urlName);
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
											echo $this->lang->line('txt_Task').': '.implode(', ',$activityArtifactLinks).'<br><br>';
										if ($notesArtifactLinks)
											echo $this->lang->line('txt_Notes').': '.implode(', ',$notesArtifactLinks).'<br><br>';
										if ($contactArtifactLinks)
											echo $this->lang->line('txt_Contacts').': '.implode(', ',$contactArtifactLinks).'<br><br>';
										if ($importArtifactLinks)
											echo $this->lang->line('txt_Imported_Files').': '.implode(', ',$importArtifactLinks).'<br><br>';
										if ($urlStore)
											echo $this->lang->line('txt_Imported_URL').': '.implode(', ',$urlStore).'<br><br>';
										

											if(count($importArtifactLinks) == 0 && count($contactArtifactLinks)==0 && count($notesArtifactLinks)==0 
											&& count($activityArtifactLinks)==0 && count($chatArtifactLinks)==0 && count($disArtifactLinks)==0 
											&& count($docArtifactLinks)==0 && count($urlStore)==0 )	
											{
												echo $this->lang->line('msg_tags_not_available');
											}
	
										?></td>
                </tr>
          </table>
              <?php 
	
$linkId = $_GET['linkedTreeId'];

if(1)
{
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1,1);
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2,1);
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3,1);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4,1);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5,1);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6,1);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId,1);			
			$docTrees9 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	
		
			$count = 0;
			if (!empty($docTrees))
			{												
					foreach($docTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			
			if (!empty($disTrees))
			{												
					foreach($disTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}	
			if (!empty($chatTrees))
			{												
					foreach($chatTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($activityTrees))
			{												
					foreach($activityTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($contactTrees))
			{												
					foreach($contactTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}			
			if (!empty($notesTrees))
			{												
					foreach($notesTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($externalTrees))
			{												
					foreach($externalTrees as $data)
					{		
						if ($data['docId'] == $linkId)
							$count++;
					}
			}
			if (!empty($docTrees9))
			{												
					foreach($docTrees9 as $data)
					{		
						if ($data['urlId'] == $linkId )
							$count++;
					}
			}											
				if ($count != 0)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';
					
			if (!empty($nodeBgColor))
			{		
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;" >
            <tr class="<?php echo $nodeBgColor;?>">
                  <td id="<?php echo $position++;?>" class="handCursor treeLeafView"><?php
				  		/*$this->identity_db_manager->formatContent($arrDocumentDetails['name'],250,1)*/
						echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId.'&option=1 style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDocumentDetails['name'],0,250)).'</a>';
					
					?>
                <br></td>
                </tr>
          </table>
              <?php
		}
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing:2px;">
            <?php
	$totalNodes = array();
	$nodeBgColor = '';
	if(count($documentDetails) > 0)
	{
		 
		foreach($documentDetails as $keyVal=>$arrVal)
		{
		
			//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrVal['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $arrVal['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($treeId, $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{
			
		
			$docTrees 		= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1,2);
			$disTrees 		= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2,2);
			$chatTrees 		= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3,2);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4,2);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5,2);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6,2);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'],2);
			$docTrees9 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], '2');				
						
			$count = 0;
			if (!empty($docTrees))
			{												
					foreach($docTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			
			if (!empty($disTrees))
			{												
					foreach($disTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}	
			if (!empty($chatTrees))
			{												
					foreach($chatTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($activityTrees))
			{												
					foreach($activityTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($contactTrees))
			{												
					foreach($contactTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}			
			if (!empty($notesTrees))
			{												
					foreach($notesTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($externalTrees))
			{												
					foreach($externalTrees as $data)
					{		
						if ($data['docId'] == $linkId)
							$count++;
					}
			}	
			
			if (!empty($docTrees9))
			{		
			   								
					foreach($docTrees9 as $data)
					{		
						if ($data['urlId'] == $linkId)
							$count++;
					}
			}									
				if ($count != 0)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';				

			
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->document_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$checksucc 		=	$this->document_db_manager->checkSuccessors($arrVal['nodeId']);
	
			?>
            <tr>
                  <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php
			if (!empty($nodeBgColor))
			{
			?>
                      <tr class="<?php echo $nodeBgColor;?>">
                      <td colspan="3" id="<?php echo $position++;?>" class="handCursor treeLeafView"><?php
					  	/*$this->identity_db_manager->formatContent($arrVal['contents'],250)*/
						echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrVal["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1#docLeafContent'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrVal['contents'],0,250)).'</a>';

					?>
					<div style="font-size:0.65em; margin-top:8px;" class="userLabel tagNameMob"><?php echo  $userDetails1['userTagName']; ?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?></div>
                          <br></td>
						  
						<?php /*?><tr class="<?php echo $nodeBgColor;?>"><td class="userLabel" style="float:left;"><?php echo  $userDetails1['userTagName']; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?></td></tr>  <?php */?>
						
                    </tr>
                      <?php
			}
            ?>
                    </table>
                <div style="padding-left:20px;">
                      <?php

			$_SESSION['succ'] = 0;
			$checkSuccessor =  $this->document_db_manager->getSuccessors($arrVal['nodeId']);
				
		if ($checkSuccessor != 0)
		{
			$sArray=array();
			$sArray=explode(',',$checkSuccessor);
			$counter=0;
			while($counter < count($sArray))
			{
				$arrDocuments	= $this->document_db_manager->getPerentInfo($sArray[$counter]);	
				
				//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrDocuments['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($arrDocuments['treeIds'], $arrDocuments['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($arrDocuments['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{	
					
				$totalNodes[] = $arrDocuments['nodeId'];	 
				$userDetails	= $this->document_db_manager->getUserDetailsByUserId($arrDocuments['userId']);
				$checksucc 		= $this->document_db_manager->checkSuccessors($arrDocuments['nodeId']);				
				
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 1,2);
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 2,2);
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 3,2);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 4,2);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 5,2);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 6,2);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDocuments['nodeId'],2);	
	
			$count = 0;
			if (!empty($docTrees))
			{												
					foreach($docTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			
			if (!empty($disTrees))
			{												
					foreach($disTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}	
			if (!empty($chatTrees))
			{												
					foreach($chatTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($activityTrees))
			{												
					foreach($activityTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}
			if (!empty($contactTrees))
			{												
					foreach($contactTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}			
			if (!empty($notesTrees))
			{												
					foreach($notesTrees as $data)
					{		
						if ($data['treeId'] == $linkId)
							$count++;
					}
			}	
			if (!empty($externalTrees))
			{												
					foreach($externalTrees as $data)
					{		
						if ($data['docId'] == $linkId)
							$count++;
					}
			}							
				if ($count != 0)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';	
				?>
                      
                    <tr>
                          <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                              <?php
			if (!empty($nodeBgColor))
			{
			?>
                              <tr class="<?php echo $nodeBgColor; ?>">
                              <td id="<?php echo $position++;?>" colspan="3" class="handCursor treeLeafView"><?php
						/*$this->identity_db_manager->formatContent($arrDocuments['contents'],250)*/
						echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrDocuments["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1#docLeafContent'.$arrDocuments["nodeId"].' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDocuments['contents'],0,250)).'</a>';
					
					?>
					<div style="font-size:0.65em; margin-top:8px;" class="userLabel tagNameMob"><?php echo  $userDetails1['userTagName']; ?>&nbsp;<?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?></div>
                                  <br></td>
								  
								<?php /*?> <tr class="<?php echo $nodeBgColor;?>"><td class="userLabel" style="float:left;"><?php echo  $userDetails1['userTagName']; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?></td></tr><?php */?>
								 
                            </tr>
                              <?php
			}
			?>
                            </table></td>
                        </tr>
                    <?php
					}
				$counter++;
			}			

		}		
		?>
                </div></td>
                </tr>
            <?php
		}//Code end
		}
		
	}
	 
?>
          </table>
              <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
            </div>
          
          <?php
}
?>
          <!-- Main Body -->
          
            </td>
          
            </tr>
          
        </table>
      </td>
    
      </tr>
    
  </table>
    </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
