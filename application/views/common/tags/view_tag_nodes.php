<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/stylish-select.css" />
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

<!-- scripts for menu --->
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
	 <!--/*Changed By surbhi IV*/-->
    <!--<script type="text/javascript" language="javascript" src="js/modal-window.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
    <!--/*End of Changed By surbhi IV*/-->
	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 
	<!-- close here -->
	
	<script language="JavaScript1.2">
mmLoadMenus();

function showTreeTags()
{
	if (document.getElementById('treeTags').style.display=='none')
	{
		document.getElementById('treeTags').style.display='';
		document.getElementById('leafTags').style.display='none';
		document.getElementById('navTreeTags').className = 'current';
		document.getElementById('navLeafTags').className = '';
	}
}

function showLeafTags()
{
	if (document.getElementById('leafTags').style.display=='none')
	{
		document.getElementById('leafTags').style.display='';
		document.getElementById('treeTags').style.display='none';
		document.getElementById('navTreeTags').className = '';
		document.getElementById('navLeafTags').className = 'current';
	}
}
</script>
</head>
<body>

</head>
<body>
<div id="wrap1">
<div id="header-wrap">
<?php $this->load->view('common/header'); ?>
<?php $this->load->view('common/wp_header'); ?>
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
			//get space tree list
			$spaceTreeDetails = $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
?>			
<?php $this->load->view('common/artifact_tabs', $details); ?>
</div>
</div>

<div id="container">

		<div id="content">


      <table width="<?php echo $this->config->item('page_width')-25;?>" border="0"  cellpadding="0" cellspacing="0">
        
        
        
        <tr>
        	<td align="left" valign="top" bgcolor="#FFFFFF">
          	<table width="<?php echo $this->config->item('page_width')-55;?>" border="0"  cellpadding="3" cellspacing="3" class="dashboard_bg">
            <tr>
            	<td align="left" valign="top">                    
					<?php
						echo "<h2>" .$this->lang->line('msg_tag_applied_to') .":</h2>";
					?>
                </td>
            </tr>
            
            <tr>
                <td align="left" valign="top">
                    <!-- Main Body  -->
                    <span id="treeTags">
                    <?php	
						$count = 0;
						echo "<b>".$this->lang->line('txt_Tree')." :</b>";
						foreach($arrTreeDetails as $key => $arrTagData)
						{ 
							foreach($arrTagData as $key1 => $tagData)
							{
								
								if ($tagData['artifactType']==1)
								{
									$count++;
									
									if ($tagData['treeType']==1)
									{
										$treeAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==2)
									{
									  
										
									
										$treeAllContents = '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==3)
									{
										$treeAllContents = '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==4)
									{ 
										$treeAllContents = '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==5)
									{
										$treeAllContents = '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==6)
									{
										$treeAllContents = '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
									//Space tree type code start
										if(in_array($tagData['treeType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') 
										{
											 echo $treeAllContents;
										}
									//space tree type code end
								}
								
							}
						}
						if ($count==0)
						{
							echo "</br></br>".$this->lang->line('txt_None');;
						}
				  	?>
                    </span>
				
                	<span id="leafTags" >
                    <?php	
						//print_r($arrTreeDetails);
						$count = 0;
						 echo "<b>".$this->lang->line('txt_Leaf')." :</b>";
						foreach($arrTreeDetails as $key => $arrTagData)
						{
						     
							foreach($arrTagData as $key1 => $tagData)
							{ 
								if ($tagData['artifactType']==2)
								{
									$count++;
									
									$leafAllContents = '';
									
									if ($tagData['treeType']=='')
									{ 
										if($tagData['workSpaceType']=='0')
										{
											echo '<a href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'" target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a>';
											echo "<hr>";
										}
										else
										{
											echo '<a href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'" target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a>';
											echo "<hr>";
										}
									}
									
									
									if ($tagData['treeType']==1)
									{ 
									
										//Document link draft filter code start
										$active = 1;
										if($tagData['treeType']==1)
										{
											$leafNodeData = $this->identity_db_manager->getNodeDetailsByNodeId($tagData["artifactId"]);
											//Add draft reserved users condition
											$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafNodeData['leafId']);
											$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafNodeData['treeId'], $leafNodeData['nodeOrder']);	
											$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafNodeData['treeId'], $leafParentData['parentLeafId'],$_SESSION['userId']);
											//Get reserved users
											$reservedUsers = '';
											$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
											$resUserIds = array();			
											foreach($reservedUsers  as $resUserData)
											{
												$resUserIds[] = $resUserData['userId']; 
											}
											$active = 0;
										}
										if(((in_array($_SESSION['userId'], $resUserIds)) && $tagData['treeType']==1 && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $active == 1)	
										{		
									
										$leafAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&node='.$tagData["artifactId"].'&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1#docLeafContent'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
										}
									}
								
									if ($tagData['treeType']==2)
									{
									
										if($tagData['predecessor'] != 0)
										{
											$leafAllContents = '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['artifactId'].'" target="_blank" class="blue-link-underline">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
											//echo "<hr>";	
										}
										else
										{
										
										$leafAllContents = '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>'; 
										//echo "<hr>";
										}
										
								
									}
								
									if ($tagData['treeType']==3)
									{
										$leafAllContents = '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].'#discussLeafContent'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==4)
									{
										$leafAllContents = '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].'#taskLeafContent'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==5)
									{
										$leafAllContents = '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].'#contactLeafContent'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									if ($tagData['treeType']==6)
									{
										$leafAllContents = '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$this->identity_db_manager->formatContent($tagData['contents'],250).'</a><hr>';
										//echo "<hr>";
									}
								
									//Space tree type code start
										if(in_array($tagData['treeType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') 
										{
											 echo $leafAllContents;
										}
									//space tree type code end
								}
								
							}
						}
						if ($count==0)
						{
							echo "</br></br>".$this->lang->line('txt_None');
						}
				  	?>
                    </span>
                    
                                

                  <!-- Main Body -->
                </td>
			</tr>
          </table>
          </td>
        </tr>
        <tr>
          <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
        </tr>
        
    </table>
</div>
</div>
<div>
<?php $this->load->view('common/footer');?>
</div>
</body>
</html>