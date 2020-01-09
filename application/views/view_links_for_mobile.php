<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<?php //echo "workspaceId= " .$workSpaceId; exit;?>

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

<script language="JavaScript1.2">

mmLoadMenus();



function showTreeLinks()

{

	if (document.getElementById('treeLinks').style.display=='none')

	{

		document.getElementById('treeLinks').style.display='';

		document.getElementById('leafLinks').style.display='none';

		document.getElementById('navTreeLinks').className = 'current';

		document.getElementById('navLeafLinks').className = '';

	}

}



function showLeafLinks()

{

	if (document.getElementById('leafLinks').style.display=='none')

	{

		document.getElementById('leafLinks').style.display='';

		document.getElementById('treeLinks').style.display='none';

		document.getElementById('navTreeLinks').className = '';

		document.getElementById('navLeafLinks').className = 'current';

	}

}

</script>



<!-- scripts for menu --->

	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>

	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>

	 <!--/*Changed By surbhi IV*/-->

    <!--<script type="text/javascript" language="javascript" src="js/modal-window.min.js"></script>-->

	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>

    <!--/*End of Changed By surbhi IV*/-->

	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 

<!-- close here -->





</head>

<body>

<div id="wrap1">

<div id="header-wrap" style="width:100%;">

<?php $this->load->view('common/header_for_mobile'); ?>
<?php $this->load->view('common/wp_header'); ?>

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
			
			//get space tree list
			$spaceTreeDetails = $this->identity_db_manager->get_space_tree_type_id($workSpaceId);

			//$this->load->view('common/artifact_tabs_for_mobile');?>

</div>

</div>



<div id="container_for_mobile">



		<div id="content">







          	<table width="100%;" border="0"  cellpadding="3" cellspacing="3" class="dashboard_bg">

            <tr>

            	<td align="left" valign="top"><?php echo "<p style='font-size: 18px;'>" .$this->lang->line('msg_link_applied_to') .":</p>";?></td>

            </tr>

                   

            <tr>

                <td align="left" valign="top">

                  <!-- Main Body -->

                  <span id="treeLinks">

					<?php

					$count = 0;

					echo "<b>".$this->lang->line('txt_Tree')." :</b>";

					//print_r($arrNodeIds);

					foreach ($arrNodeIds as $artifactId=>$artifactType)

					{

						if ($artifactType==1)

						{

							$count++;

							$arrNodeDetails = array();

							$arrNodeDetails = $this->identity_db_manager->getLinkedArtifactDetailsByNodeId ($artifactId,$artifactType);

						//	print_r($arrNodeDetails);
						
						
								//Manoj: Timeline post link start
								
								if ($arrNodeDetails['treeType']=='')

								{

									echo '<a href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$artifactId.'#form'.$artifactId.'" target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>'; 

									echo "<hr>";

								}
								
								//Manoj: Timeline post link end 

							

								if ($arrNodeDetails['treeType']==1)

								{ 

								     if($artifactType==1)

									{

									$treeAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrNodeDetails["treeId"].'&doc=exist&node='.$artifactId.'&curVersion='.$curVersion.'&option=1 target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';

									//echo "<hr>";

									}

									else

									{

									$treeAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrNodeDetails["treeId"].'&doc=exist&node='.$artifactId.'&curVersion='.$curVersion.'&option=1 target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';                             

									//echo "<hr>";

									

									}

									

								}

								

								if ($arrNodeDetails['treeType']==2)

								{

									$treeAllContents = '<a href='.base_url().'view_discussion/node/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==3)

								{

									$treeAllContents = '<a href='.base_url().'view_chat/chat_view/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==4)

								{

									$treeAllContents = '<a href='.base_url().'view_task/node/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==5)

								{

									$treeAllContents = '<a href='.base_url().'contact/contactDetails/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><br/><br/><hr>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==6)

								{

									$treeAllContents = '<a href='.base_url().'notes/Details/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a><hr>';

									//echo "<hr>";

								}
								
								//Space tree type code start
										if(in_array($arrNodeDetails['treeType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') 
										{
											 echo $treeAllContents;
										}
								//space tree type code end

						}

						

					}

					

					if ($count==0)

					{

						echo $this->lang->line('txt_None');;

					}

					//echo "<hr>";

				  	?>

					

                  </span>   

                  <span id="leafLinks" >

					<?php 

					

					$count = 0;

					 echo "<b>".$this->lang->line('txt_Leaf')." :</b>";

					foreach ($arrNodeIds as $artifactId=>$artifactType)

					{  

						if ($artifactType==2)

						{

							$count++;

							$arrNodeDetails = array();

							$arrNodeDetails = $this->identity_db_manager->getLinkedArtifactDetailsByNodeId ($artifactId,$artifactType);

							 

							//print_r ($arrNodeDetails);

							
								//Manoj: Timeline post link start
								
								if ($arrNodeDetails['treeType']=='')

								{
								
									if($arrNodeDetails['workSpaceType']=='0')
									{
										echo '<a href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$artifactId.'/#form'.$artifactId.'" target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>'; 
	
										echo "<hr>";
									}
									else
									{
										echo '<a href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$artifactId.'/#form'.$artifactId.'" target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>'; 
	
										echo "<hr>";
									}
									
									

								}
								
								//Manoj: Timeline post link end 
							

								if ($arrNodeDetails['treeType']==1)

								{
								
									//Document link draft filter code start
										$active = 1;
										if($arrNodeDetails['treeType']==1)
										{
											
											$leafNodeData = $this->identity_db_manager->getNodeDetailsByNodeId($artifactId);
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
									
									if(((in_array($_SESSION['userId'], $resUserIds)) && $arrNodeDetails['treeType']==1 && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $active == 1)	
									{	
										

									 if($artifactType==1)

									{

									$leafAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrNodeDetails["treeId"].'&doc=exist&node='.$artifactId.'&curVersion='.$curVersion.'&option=1 target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

									}

									else

									{

									$leafAllContents = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrNodeDetails["treeId"].'&doc=exist&node='.$artifactId.'&curVersion='.$curVersion.'&option=1#docLeafContent'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>'; 

									//echo "<hr>";

									}
								}

								}

								

								if ($arrNodeDetails['treeType']==2)

								{ 

									//$checkSuccessor =  $this->discussion_db_manager->getSuccessors($arrVal['nodeId']);

								     

									$leafAllContents = '<a href='.base_url().'view_discussion/node/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.'  target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==3)

								{

									$leafAllContents = '<a href='.base_url().'view_chat/chat_view/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.'#discussLeafContent'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

								} 

								

								if ($arrNodeDetails['treeType']==4)

								{

									$leafAllContents = '<a href='.base_url().'view_task/node/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.'#taskLeafContent'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==5)

								{

									$leafAllContents = '<a href='.base_url().'contact/contactDetails/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.'#contactLeafContent'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

								}

								

								if ($arrNodeDetails['treeType']==6)

								{

									$leafAllContents = '<a href='.base_url().'notes/Details/'.$arrNodeDetails["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$artifactId.' target="_blank">'.$this->identity_db_manager->formatContent($arrNodeDetails['contents'],250).'</a>';

									//echo "<hr>";

								}
								
								//Space tree type code start
										if(in_array($arrNodeDetails['treeType'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') 
										{
											 echo $leafAllContents;
										}
								//space tree type code end

						}

					}

					if ($count==0)

					{

						echo $this->lang->line('txt_None');;

					}

				  	?>

                  </span>           



                  <!-- Main Body -->

                </td>

			</tr>

          </table>

          

</div>

</div>

<div>

<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>

</div>

</body>

</html>