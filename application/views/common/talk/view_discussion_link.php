<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
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
            	<ul class="navigation">
				<li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
				<li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
				<li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>		
            	<li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" class="current"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>		
            	<?php
				if (($workSpaceId==0))
				{
				?>
                	<li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"><span><?php echo $this->lang->line('txt_Share');?></span></a></li>
                <?php
				}
				?>
                <li id="treeUpdate"></li>
            	</ul>
												</td>
											<td align="right" valign="middle" class="tdSpace">&nbsp;</td>
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
								  <td  colspan="2">
                                    <?php 
										$arrNodeIds = array();
										$arrOldTreeVersions = array();
										
									
										$arrNodeIds = $this->discussion_db_manager->getNodeIdsByTreeId($treeId);
										
										
									
										
										$nodeIds = implode(',', $arrNodeIds);
				
						
										$arrNewNodeIds = explode (',',$nodeIds);
										$arrDocTreeIds = array();	
										

										
										foreach($arrNewNodeIds as $key => $value)
										{
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 1,2);
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
														$docArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>'; 	
													}
													$docLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	
													
													if (!in_array(strip_tags($treeName),$docLinksStore))
													{				
														$docArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>'; 	
													}
													$docLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 2,2);
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
														$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$disLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}	
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	
													

													if (!in_array(strip_tags($treeName),$disLinksStore))
													{					
														$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$disLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											
											
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 3,2);
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
														$chatArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>'; 	
													}
													$chatLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	
													
													if (!in_array(strip_tags($treeName),$chatLinksStore))
													{				
														$chatArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>'; 	
													}
													$chatLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 4,2);
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
														$activityArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$activityLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}	
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	

													if (!in_array(strip_tags($treeName),$activityLinksStore))				
													{
														$activityArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$activityLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}									
		
		
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 5,2);
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
														$contactArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$contactLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	
													

													if (!in_array(strip_tags($treeName),$contactLinksStore))	
													{					
														$contactArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$contactLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}	
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 6,2);
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
														$notesArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$notesLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											$getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6,1);
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												
												if(count($docTrees) > 0)
												{
													foreach($docTrees as $data)
													{	
													$treeName = $data['name'];
													$arrDocTreeIds[] = $data['treeId'];	
													
													if (!in_array(strip_tags($treeName),$notesLinksStore))					
													{
														$notesArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['treeId'].'">'.strip_tags($treeName).'</a>';  	
													}
													$notesLinksStore[] = strip_tags($treeName);
													$i++;
													}					
												}
											}
											
											
											$getTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($value,2);			
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
														$importArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['docId'].'">'.$docName.'_v'.$data['version'].'</a>'; 
													}
													$importLinksStore[] = $docName.'_v'.$data['version'];
													$i++;
													}						
												}	
											}
											$getTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId,1);			
											if (!empty($getTrees))
											{	
												$docTrees = $getTrees;
												if(count($docTrees) > 0)
												{

													foreach($docTrees as $data)
													{	
													$docName = $data['docName'];
													$arrImportFileIds[] = $data['docId'];	
										
													if (!in_array($docName.'_v'.$data['version'],$importLinksStore))	
													{
														$importArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/4/'.$data['docId'].'">'.$docName.'_v'.$data['version'].'</a>'; 
													}
													$importLinksStore[] = $docName.'_v'.$data['version'];
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
	
										?>			
                                   
                                 	</td>
							  </tr>
		
					</table>                  
<?php 


$linkId = $this->uri->segment(8);


if(1)
{
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1,1);
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2,1);
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3,1);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4,1);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5,1);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6,1);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId,1);			
		
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
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = '';
					
			if (!empty($nodeBgColor))
			{		
?>		

		<table width="100%" border="0" cellspacing="3" cellpadding="0">	
			<tr class="<?php echo $nodeBgColor;?>">				
				<td id="<?php echo $position++;?>" class="handCursor">
					<?php 
					
					echo '<a href='.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],250,1).'</a>';
					
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
	if(count($discussionDetails) > 0)
	{			 
		foreach($discussionDetails as $keyVal=>$arrVal)
		{
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1,2);
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2,2);
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3,2);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4,2);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5,2);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6,2);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'],2);			
						
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
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = '';				

			
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$checksucc 		=	$this->discussion_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$this->discussion_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
			$viewCheck=$this->discussion_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
		?>			
      <tr>
       
        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">		
		<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<?php
			if (!empty($nodeBgColor))
			{
			?>
			<tr class="<?php echo $nodeBgColor;?>">				
				<td colspan="3" id="<?php echo $position++;?>" class="handCursor">
                 
					<?php 
					
					echo '<a href='.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';

					?><br>
				</td>
			</tr>           
            <?php
			}
            ?>            

			</table>

			<div style="padding-left:20px;">
			<?php
			
			$_SESSION['succ'] = 0;
			$checkSuccessor =  $this->discussion_db_manager->getSuccessors($arrVal['nodeId']);
			
				
		if ($checkSuccessor != 0)
		{

			$sArray=array();
			$sArray=explode(',',$checkSuccessor);
			$counter=0;
			while($counter < count($sArray))
			{
				$arrDiscussions	= $this->discussion_db_manager->getPerentInfo($sArray[$counter]);		
				$predecessor = 	$this->discussion_db_manager->checkPredecessor($arrDiscussions['nodeId']);	
				$totalNodes[] = $arrDiscussions['nodeId'];	 
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc 		= $this->discussion_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
		
				
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1,2);
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2,2);
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3,2);
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4,2);
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5,2);
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6,2);
			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'],2);	
		
			
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
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = '';	
				?>
				 <tr>
      
       
        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">
		
		
		
		<table width="100%" border="0" cellspacing="3" cellpadding="0" align="left">
        	<?php
			if (!empty($nodeBgColor))
			{
			?>			
			  <tr class="<?php echo $nodeBgColor; ?>">
				
				<td id="<?php echo $position++;?>" colspan="3" class="handCursor">
			
					<?php 
					
					echo '<a href='.base_url().'view_discussion/Discussion_reply/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$arrDiscussions["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussions['contents'],250).'</a>';
					
					?><br>
				</td>				
			  </tr>
			<?php
			}
			?>					

			</table></td>
        </tr>				

				
				<?php
				$counter++;
			}			

		}		
		?>
			</div>	
		</td>
        </tr>
		
		<?php
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
</table>
</body>
</html>
