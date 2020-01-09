<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Dashboard</title>
	<?php //$this->load->view('common/view_head'); ?>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';	
		

function showHideDashBoard(className)
{
	var divsToHide = document.getElementsByClassName(className);
	
	for(var i = 0; i < divsToHide.length; i++)
    {
		if (divsToHide[i].style.display=='block')
		{
    		divsToHide[i].style.display='none';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}								
		}
		else
		{
			divsToHide[i].style.display='block';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}								
		}
		
	}
}
	</script>
</head>
<body>
<div id="wrap1">
      <div id="header-wrap">
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
			
			$this->load->view('common/artifact_tabs_for_mobile', $details);
			
			if($workSpaceId!=0 && $workSpaceDetails['workSpaceName']!='Try Teeme') {
				$treeTypeEnabled = 1;	
			}

	?>
  </div>
</div>
<div id="container_for_mobile">
<div id="content">
    <?php 
	if(isset($_SESSION['errorMsg']) &&  $_SESSION['errorMsg']!='' )
	{ 
	?>
		<div class="error">
		<?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?>
		</div>
    <?php 
	} 
	?>
<div><h1>Dashboard<span style="float:right;"><img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location="<?php echo base_url()?>dashboard/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"' style="cursor:pointer" ></span></h1></div>
<div class="clr"></div>
<?php if(count($arrDocuments) > 0){ ?>
<div class="dashboard_row" style="width:100%;">
	<div class="dashboard_col" >
		<!-- Updated trees start -->
		<div class="dashboard_wrap">
		<?php
			if(count($arrDocuments) > 0)
			{
							$count = 0 ;
							foreach($arrDocuments as $keyVal=>$arrVal)
							{
							
								if ($arrVal['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
								}
								if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
								{
									$count++;
								}
							}	
			}	
		?>
		
		<span class="dashboard_title">
		
		<img src=<?php echo base_url(); ?>images/icon_document_sel15.png alt='<?php echo $this->lang->line('txt_Document'); ?>' title='<?php echo $this->lang->line('txt_Document');?>' border=0 <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?>> 
		
		<img src=<?php echo base_url(); ?>images/icon_discuss_sel15.png alt='<?php echo $this->lang->line('txt_Discuss'); ?>' title='<?php echo $this->lang->line('txt_Discuss');?>' border=0 <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?>> 
		
		<img src=<?php echo base_url(); ?>images/icon_task_sel15.png alt='<?php echo $this->lang->line('txt_Task'); ?>' title='<?php echo $this->lang->line('txt_Task');?>' border=0 <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?>> 
		
		<img src=<?php echo base_url(); ?>images/icon_notes_sel15.png alt='<?php echo $this->lang->line('txt_Notes'); ?>' title='<?php echo $this->lang->line('txt_Notes');?>' border=0 <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?>> 
		
		<img src=<?php echo base_url(); ?>images/icon_contact_sel15.png alt='<?php echo $this->lang->line('txt_Contact'); ?>' title='<?php echo $this->lang->line('txt_Contact');?>' border=0 <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php }  ?>> <?php echo $this->lang->line('txt_Trees');?> </span> 
		<?php 
		if ($count > 5)
		{
		?>
			<span><a id="more_trees" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_trees');">See all.....</a></span>
		<?php
		}
		?>
			<div class="clr"></div>
			<div style="margin-top:10px;" >
				  <?php
						if(count($arrDocuments) > 0)
						{	
/*							$count = 0 ;
							foreach($arrDocuments as $keyVal=>$arrVal)
							{
							
								if ($arrVal['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
								}
								if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
								{
									$count++;
								}
							}*/
							if ($count!=0)
							{ 
							?>
							<div class="clr"></div>
				  <?php
								//$rowColor1='row-active-middle1';
								//$rowColor2='row-active-middle2';
								$i = 1;	
				
						
				foreach($arrDocuments as $keyVal=>$arrVal)
				{
					//echo "<li>"; print_r($arrVal);
					  /* Added by Surbhi IV*/
					  $arrUser= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);
					  /*End of Added by Surbhi IV*/
						if ($arrVal['isShared']==1)
						{
							$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
						}	
						if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
						{
							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
								//echo "<li>i= " .$i;
								if ($i<6)
								{
									$display='block';
									$class = 'dashboard_content_trees';
								} 
								else 
								{
									$display='none';
									$class = 'dashboard_content_more_trees';
								}
								?>
				<div class=<?php echo $class;?> style="margin:10px 0 10px; display:<?php echo $display;?>">
					<div>
							<?php
							if ($arrVal['isShared']==1)
							{
							?>
							<img src="<?php echo base_url();?>images/share.gif" alt="Shared" border="0"/>
							<?php
							
							 }
							?>
							<?php
							
							if ($arrVal['type']==1)
							{
								$href='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$keyVal.'&doc=exist';
								$txt_tree_type=$this->lang->line('txt_Document');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'" />';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==2)
							{
								
								$href='view_discussion/node/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Discussion');
								
							}
							if ($arrVal['type']==3)
							{
								if($arrVal['status']==1)
								{
									$href='view_chat/chat_view/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
									
								}
								else
								{
									$href='view_chat/node1/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								}
								$txt_tree_type=$this->lang->line('txt_Chat');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
									
							}
							if ($arrVal['type']==4)
							{
							
								$href='view_task/node/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Task');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==5)
							{
								//index
								$href='contact/contactDetails/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Contact');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==6)
							{
								//index
								$href='notes/Details/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Notes');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
				
							?>
							<!--Space tree type validation start-->	
							<?php if(in_array($arrVal['type'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') { ?>
						  <!--/*Added by Surbhi IV*/	--> 
						  <?php echo $icon; ?> 
						  <!--/*End of Added by Surbhi IV*/	--> 
						  <a href="<?php echo base_url().''.$href; ?>" title="<?php echo $this->identity_db_manager->formatContent($arrVal['name'],0,1);?>"><?php echo $this->identity_db_manager->formatContent($arrVal['name'],60,1); 			 
														if (!empty($arrVal['old_name']))
														{
															echo '<br>(<i>'.$this->lang->line("txt_Previous_Title").':</i> ' .$this->identity_db_manager->formatContent($arrVal['old_name'],60,1).')';
														}?> </a> 
						<span class="clsLabel"><?php // echo $this->lang->line('txt_Created_By').": ";?><?php //echo $arrUser["userTagName"];?></span> <span class="clsLabel"><?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></span>
					<?php } ?>
						<!--Space tree type validation end-->
					</div>
				<!--/* Added by Surbhi IV*/-->

				<div class="clr"></div>
				
			  </div>
				  <?php
									}
									
									$i++;
								}
								
								?>
				  </form>
				  	
				  <?php
							}
							else
							{	
							?>
				  <div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
				  <?php
							}
						}
						else
						{
						?>
				  <div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
				  <?php
						}	
						?>
				</div>
			</form>
		</div>	
		<!-- Updated trees end -->  	
	</div>
</div>
<div class="clr"></div>
<?php } ?>
	<div class="dashboard_row dashboard_my_task" style="width:100%; display:none; <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php }  ?>">
	<div class="dashboard_col" >
			<!-- My tasks start -->
			<div class="dashboard_wrap">
				<div class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_task_sel.png alt='<?php echo $this->lang->line('txt_My_Tasks'); ?>' title='<?php echo $this->lang->line('txt_My_Tasks');?>' border=0> <?php echo $this->lang->line('txt_My_Tasks');?></div>
				<div>
					<span class="color_box" style="background-color:#999999;"></span><span class="flLt clsLabel"><?php echo $this->lang->line('txt_Due_Within_15');?></span>
					<span class="color_box" style="background-color:#FF0000;"></span><span class="flLt clsLabel"><?php echo $this->lang->line('txt_Overdue');?></span>
					<span class="color_box" style="background-color:#006600;"></span><span class="flLt clsLabel"><?php echo $this->lang->line('txt_Starting_Within_15');?></span>					
				</div>
				<div class="clr"></div>
				<div style="margin:8px 0;">
				  <?php       
			
									if($this->input->post('created') != '')
									{
										$created = $this->input->post('created');
									}	
									if($this->input->post('starting') != '')
									{
										$starting = $this->input->post('starting');
									}						
									if($this->input->post('due') != '')
									{
										$due = $this->input->post('due');
									}	
									if($this->input->post('list') != '')
									{
										$list = $this->input->post('list');
									}	
									if($this->input->post('users') != '')
									{
										$users = $this->input->post('users');
									}	
									if($this->input->post('usersAssigned') != '')
									{
										$usersAssigned = $this->input->post('usersAssigned');
									}
			  
			  
									echo "<div><b>".$this->lang->line('txt_For_me').":</b></div>";
									
										$for_by = 1;
									
									$arrTreeDetails = array();
									$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
									
									//$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
									$arrTreeDetails15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 15, $list, $users, $usersAssigned, $for_by);
								
									//$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
									
									$arrTreeDetailsStarting15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 15, $due, $list, $users, $usersAssigned, $for_by);
								
								//echo "<li>due= " .count($arrTreeDetails15);
								
								//My tasks count start
								if(count($arrTreeDetails15)==0 && count($arrTreeDetailsStarting15)==0)
								{
									$forMeCount = 1;
								}
								//echo count($arrTreeDetails).'=='.count($arrTreeDetails15).'=='.count($arrTreeDetailsStarting15);
								//My tasks count end
								
								/////////////////////// Due within ///////////////////////////////////////////////////////////////
								if((count($arrTreeDetails15)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').' (0 tasks):</span></div>';
									//echo '<div style="margin: 8px 0px;"><b>'.$this->lang->line('txt_For_me').': </b>'.$this->lang->line('txt_None').'</div>';
								}
			
								else if(count($arrTreeDetails15) > 0)
								{	
									// This loop is for count only
									$c = 0;
									foreach($arrTreeDetails15 as $key => $arrTagData)
									{
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											$c++;
										}
									}
								
									//echo '<div><b>'.$this->lang->line('txt_For_me').'</b> ('.$c.' tasks):</div>';	
									//echo '<div><b>'.$this->lang->line('txt_For_me').':</b></div>';			 
									
									// This loop is for rendering
									?>
				  <span id="due30" style="display:block;">
				  <?php
									foreach($arrTreeDetails15 as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$end_date = substr ($arrTagData['endtime'],0,10);
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAfter = "+15 days";
								
											$daysAfter = strtotime ($daysAfter);
							
											$daysAfter = date("Y-m-d",$daysAfter);	
											
											if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
											else
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											echo "</div>";
										}
									}						
									?>
				  </span>
				  <?php
								}
											
								/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
								//echo "<li>overdue= " .count($arrTreeDetails);
								if((count($arrTreeDetails)==0))
								{
									//echo '<div><span class="heading-search">' .$this->lang->line('txt_Overdue') .' (0 tasks):</span></div>';
								}
			
								else if(count($arrTreeDetails) > 0)
								{	
									// This loop is for count only
									$c = 0;
									$day 	= date('d');
									$month 	= date('m');
									$year	= date('Y');	
			
									$today = $year."-".$month."-".$day;
									
									//echo "<li>today= " .$today;
									
									foreach($arrTreeDetails as $key => $arrTagData)
									{
										$end_date = substr ($arrTagData['endtime'],0,10);
										
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											if (($end_date<$today) && ($end_date!='0000-00-00'))
											{
												$c++;
											}
										}
									}
									
									if($c>0)
									{
										$forMeCount = 2;
									}
								
									//echo '<div><span class="heading-search">' .$this->lang->line('txt_Overdue') .' ('.$c.' tasks):</span></div>';			 
									?>
				  <span id="overdue" style="display:block;">
				  <?php
									// This loop is for rendering
									foreach($arrTreeDetails as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$end_date = substr ($arrTagData['endtime'],0,10);
			
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc && $nodeTaskStatus!=4)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAgo = "-15 days";
								
											$daysAgo = strtotime ($daysAgo);
							
											$daysAgo = date("Y-m-d",$daysAgo);	
											
											//echo "<li>End date= " .$end_date;
											//echo "<li>Days ago= " .$daysAgo;
											
											if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
				
											}
											else if (($end_date<$today) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											}
											echo "</div>";
										}
									}						
									?>
				  </span>
				  <?php
								}
								
						
								/////////////////////// Starting within ///////////////////////////////////////////////////////////////
								//echo "<li>start= " .count($arrTreeDetailsStarting15); print_r ($arrTreeDetailsStarting15);
								if((count($arrTreeDetailsStarting15)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Starting_Within_15').' (0 tasks):</span></div>';
								}
			
								else if(count($arrTreeDetailsStarting15) > 0)
								{	
									// This loop is for count only
									$c = 0;
									foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
									{
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											$c++;

										}
									}
								
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Starting_Within_15').' ('.$c.' tasks):</span></div>';			 
									?>
				  <span id="starting30" style="display:block;">
				  <?php
									// This loop is for rendering
									foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$start_date = substr ($arrTagData['starttime'],0,10);
									
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAfter = "+15 days";
								
											$daysAfter = strtotime ($daysAfter);
							
											$daysAfter = date("Y-m-d",$daysAfter);	
											
											//echo "<li>startdate= " .$start_date;
											//echo "<li>daysAfter= " .$daysAfter;
											
											if (($start_date!='0000-00-00') && ($start_date>=$today) && ($start_date<=$daysAfter))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
											else
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											echo "</div>";
										}
									}	
									?>
				  </span>
				  <?php
								}
			
				  ?>
			 </div>
			 <div style="margin:8px 0;">     
				  <!--------------- arun --->
				  <?php 
								
			
								  echo "<div><b>".$this->lang->line('txt_By_me').":</b></div>";
								 
								$for_by = 2;
									
									
									$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
									
									//$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
									$arrTreeDetails15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 15, $list, $users, $usersAssigned, $for_by);
									
									$arrTreeDetailsStarting15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 15, $due, $list, $users, $usersAssigned, $for_by);
								
								
									//$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
								
								//My tasks count start
								if(count($arrTreeDetails15)==0 && count($arrTreeDetailsStarting15)==0)
								{
									$byMeCount = 1;
								}
								//echo count($arrTreeDetails).'=='.count($arrTreeDetails15).'=='.count($arrTreeDetailsStarting15);
								
								//My tasks count end
								
								/////////////////////// Due within ///////////////////////////////////////////////////////////////
							
								if((count($arrTreeDetails15)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').' (0 tasks):</span></div>';
									//echo '<div style="margin: 8px 0px;"><b>'.$this->lang->line('txt_By_me').': </b>'.$this->lang->line('txt_None').'</div>';
								}
			
								else if(count($arrTreeDetails15) > 0)
								{	
									// This loop is for count only
									$c = 0;
									foreach($arrTreeDetails15 as $key => $arrTagData)
									{
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											$c++;
										}
									}
								
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').' ('.$c.' tasks):</span></div>';		
									//echo "<div><b>".$this->lang->line('txt_By_me').":</b></div>";	 
									
									// This loop is for rendering
									?>
				  <span id="dueByMe30" style="display:block;">
				  <?php
									foreach($arrTreeDetails15 as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$end_date = substr ($arrTagData['endtime'],0,10);
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAfter = "+15 days";
								
											$daysAfter = strtotime ($daysAfter);
							
											$daysAfter = date("Y-m-d",$daysAfter);	
											
											if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
											else
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
												
											}
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											echo "</div>";
										}
									}						
									?>
				  </span>
				  <?php
								}
						
								/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
								
								if((count($arrTreeDetails)==0))
								{
									//echo '<div><span class="heading-search">' .$this->lang->line('txt_Overdue') .' (0 tasks):</span></div>';
								}
			
								else if(count($arrTreeDetails) > 0)
								{	
									// This loop is for count only
									$c = 0;
									$day 	= date('d');
									$month 	= date('m');
									$year	= date('Y');	
			
									$today = $year."-".$month."-".$day;
									
									foreach($arrTreeDetails as $key => $arrTagData)
									{
										$end_date = substr ($arrTagData['endtime'],0,10);
										
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											if (($end_date<$today) && ($end_date!='0000-00-00'))
											{
												$c++;
											}
										}
									}
									
									if($c>0)
									{
										$byMeCount = 2;
									}
			
								
									//echo '<div><span class="heading-search">' .$this->lang->line('txt_Overdue') .' ('.$c.' tasks):</span></div>';			 
									?>
				  <span id="overdueByMe" style="display:block;">
				  <?php
									// This loop is for rendering
									foreach($arrTreeDetails as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$end_date = substr ($arrTagData['endtime'],0,10);
			
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc && $nodeTaskStatus!=4)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAgo = "-15 days";
								
											$daysAgo = strtotime ($daysAgo);
							
											$daysAgo = date("Y-m-d",$daysAgo);	
											
											if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
				
											}
											else if (($end_date<$today) && ($end_date!='0000-00-00'))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											}
											echo "</div>";
										}
									}						
									?>
				  </span>
				  <?php
								}
								
			
								/////////////////////// Starting within ///////////////////////////////////////////////////////////////
								
								if((count($arrTreeDetailsStarting15)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Starting_Within_15').' (0 tasks):</span></div>';
								}
			
								else if(count($arrTreeDetailsStarting15) > 0)
								{	
									// This loop is for count only
									$c = 0;
									foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
									{
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										if (!$checksucc)
										{
											$c++;
										}
									}
								
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Starting_Within_15').' ('.$c.' tasks):</span></div>';			 
									?>
				  <span id="startingByMe30" style="display:block;">
				  <?php
									// This loop is for rendering
									foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										
										$start_date = substr ($arrTagData['starttime'],0,10);
									
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc)
										{
											echo "<div style='margin: 10px 0px;'>";
											$daysAfter = "+15 days";
								
											$daysAfter = strtotime ($daysAfter);
							
											$daysAfter = date("Y-m-d",$daysAfter);	
											
											if (($start_date!='0000-00-00') && ($start_date>=$today) && ($start_date<=$daysAfter))
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';												
											}
											else
											{
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
											}
										?>	
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											<?php
											echo "</div>";
										}
									}	
									?>
				  </span>
				  <?php
								}
			
				  ?>
				</div>
				<div class="clr"></div>					
			</div>
			<!-- My tasks end -->	
		</div>
		<?php if($forMeCount==1 && $byMeCount==1){ $blank=1; } ?>
		<input type="hidden" value="<?php echo $blank; ?>" id="myTasksCount" />
	</div>
	<div class="clr"></div>
	<div class="dashboard_row dashboard_my_tag" style="width:100%; display:none;">
		<div class="dashboard_col" >
			<!-- My action tags start -->
			<div class="dashboard_wrap">
				<div><span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_My_Action_Tags'); ?>' title='<?php echo $this->lang->line('txt_My_Action_Tags');?>' border=0> <?php echo $this->lang->line('txt_My_Action_Tags');?></span><span class="clsLabel"><?php echo ' ('.$this->lang->line('txt_Due_Within_15').')';?></span></div>
				<div style="margin:8px 0;">
				<div>
				  <?php       
								
									if($this->input->post('tagType') != '')
									{
										$tagType = $this->input->post('tagType');
									}						
									if($this->input->post('responseTagType') != '')
									{
										$responseTagType = $this->input->post('responseTagType');
										$responseTagTypeString = implode (',',$responseTagType);
									}
									if($this->input->post('applied') != '')
									{
										$applied = $this->input->post('applied');
									}	
									else
									{
										$applied = 0;
									}
									if($this->input->post('due') != '')
									{
										$due = $this->input->post('due');
									}	
									else
									{
										$due = 0;
									}
									if($this->input->post('list') != '')
									{
										$list = $this->input->post('list');
									}	
									else
									{
										$list = '0';
									}
									if($this->input->post('users') != '')
									{
										$users = $this->input->post('users');
										$usersString = implode (',',$users);
									}	
									else
									{
										$usersString = -1;
									}
									
								
									echo "<div style='margin:8px 0;'><b>".$this->lang->line('txt_For_me')." :</b></div>";
										$for_by = 1;
									
									$arrTreeDetails='';
									$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
										
									$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 15, $list, $users, $for_by);	
			
			
								/* Due within 15 */
								//echo "<li>count= ";print_r($arrTreeDetailsResponseTags30);
								if((count($arrTreeDetailsResponseTags30)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').'(0 tags):</span></div>';
									//echo '<div style="margin: 8px 0px;"><b>'.$this->lang->line('txt_For_me').': </b>'.$this->lang->line('txt_None').'</div>';
								}
			
								else if(count($arrTreeDetailsResponseTags30) > 0)
								{	
									$totalTagCount = 0;
									foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
									{
										$totalTagCount += count($arrTagData);
									}
									$count = 0;
									$responseTagsFull = array();
									$responseTags = array();
									$responseTags2 = array();
									$responseTagsStore = array ();
			
									foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
									{
										foreach($arrTagData as $key1 => $tagData)
										{	
											$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
											$end_date = substr ($tagData['endTime'],0,10);
											
												/* Andy - For todo and response */	
										
												$dispResponseTags .= ' [';							
												$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
													if(!$response)
													{
														if ($tagData['tag']==1 )
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
														if ($tagData['tag']==2)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
														if ($tagData['tag']==3)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
														if ($tagData['tag']==4)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
													}
													//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
												
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								
												$dispResponseTags .= '], ';
												 // echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
												 $addActionReponse = "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	
													  $dispResponseTags='';	
											  
											  /* Andy - For todo and response */
												
											if($key == 'response')
											{
												$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
												$tagURL = '';
												
												if (!in_array($tagData['tagComment'],$responseTagsStore))	
												{
													$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
			
													if (!$response)
													{
													
														$daysAfter = "+7 days";
								
														$daysAfter = strtotime ($daysAfter);
							
														$daysAfter = date("Y-m-d",$daysAfter);
														
														if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';
															$tagURL = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';				
															$count++;
														}
														else
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';	
															$tagURL = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															$count++;
														}
														$responseTags2[] = $tagURL.$addActionReponse;
													}
													else
													{
													
														$daysAfter = "+7 days";
								
														$daysAfter = strtotime ($daysAfter);
							
														$daysAfter = date("Y-m-d",$daysAfter);
														
														if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';
															$tagURL = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';				
															$count++;
														}
														else
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';
															$tagURL = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															$count++;
														}
														$responseTags2[] = $tagURL.$addActionReponse;
													}
												
													
												}	
												$responseTagsStore[] = $tagData['tagComment'];
											}
			
										}
									}	
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').' ('.$count.' tags):</span></div>';	
									//echo '<div><b>'.$this->lang->line('txt_For_me').' ('.$count.' tags): </b></div>';		
									//echo "<li>count= " .count($responseTags2); 
			
									?>
				  <table id="response30" style="display:block;" width="100%" border="0" cellspacing="6" cellpadding="6">
					<?php
			
												if(count($responseTags2) > 0)		
												{
													?>
					<tr>
					  <td><?php echo implode(', ', $responseTags2);?></td>
					</tr>
					<?php	
						
												}
			
									?>
				  </table>

				  <?php
								}
								//My tags count start
								if(count($responseTags2)==0)
								{
									$forMeTagCount = 1;
								}
								//echo count($arrTreeDetailsResponseTags30);
								//My tags count end
				  ?>
			</div>
			<div>
								<?php						
								 echo "<div style='margin:8px 0;'><b>".$this->lang->line('txt_By_me')." :</b></div>";
								$for_by = 2;
									
			$arrTreeDetails=array();
			$arrTreeDetailsResponseTags30='';
			$totalCount=0;
									$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
									
									$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 15, $list, $users, $for_by);	
			
								
			
								/* Due within 15 */
								
								if((count($arrTreeDetailsResponseTags30)==0))
								{
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').'(0 tags):</span></div>';
									//echo '<div style="margin: 8px 0px;"><b>'.$this->lang->line('txt_By_me').': </b>'.$this->lang->line('txt_None').'</div>';
									
								}
			
								else if(count($arrTreeDetailsResponseTags30) > 0)
								{	
									$totalTagCount = 0;
									foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
									{
										$totalTagCount += count($arrTagData);
									}
								
									$count = 0;
									$responseTagsFull = array();
									$responseTags = array();
									$responseTags2 = array();
									$responseTagsStore = array ();
			
									foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
									{
										foreach($arrTagData as $key1 => $tagData)
										{	
											$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
											$end_date = substr ($tagData['endTime'],0,10);
											
												/* Andy - For todo and response */	
										
												$dispResponseTags .= ' [';							
												$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
													if(!$response)
													{
														if ($tagData['tag']==1 )
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
														if ($tagData['tag']==2)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
														if ($tagData['tag']==3)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
														if ($tagData['tag']==4)
														//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
														$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
													}
													//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
												
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								
												$dispResponseTags .= '], ';
												 // echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
												 $addActionReponse = "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	
													  $dispResponseTags='';	
											  
											  /* Andy - For todo and response */
										
											if($key == 'response')
											{
												$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';	
												$tagURL = '';				
			
												if (!in_array($tagData['tagComment'],$responseTagsStore))	
												{
													$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
			
													if (!$response)
													{
													
														$daysAfter = "+7 days";
								
														$daysAfter = strtotime ($daysAfter);
							
														$daysAfter = date("Y-m-d",$daysAfter);
														
														if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';	
															$tagURL = 	'<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';				
															$count++;
														}
														else
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';	
															$tagURL = 	'<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															$count++;
														}
														$responseTags2[] = $tagURL.$addActionReponse;
													}
													else
													{
													
														$daysAfter = "+7 days";
								
														$daysAfter = strtotime ($daysAfter);
							
														$daysAfter = date("Y-m-d",$daysAfter);
														
														if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';	
															$tagURL = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';				
															$count++;
														}
														else
														{
															$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															//$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';	
															$tagURL = 	'<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';					
															$count++;
														}
														$responseTags2[] = $tagURL.$addActionReponse;
													}
												}	
												$responseTagsStore[] = $tagData['tagComment'];
											}
			
										}
									}	
									//echo '<div><span class="heading-search">'.$this->lang->line('txt_Due_Within_15').' ('.$count.' tags):</span></div>';	
									//echo '<div><b>'.$this->lang->line('txt_By_me').' ('.$count.' tags): </b></div>';		 
			
									?>
				  <table id="responseByMe30" style="display:block;" width="100%" border="0" cellspacing="6" cellpadding="6">
					<?php
			
												if(count($responseTags2) > 0)		
												{
													?>
					<tr>
					  <td><?php echo implode(', ', $responseTags2);?></td>
					</tr>
					<?php	
						
												}
			
									?>
				  </table>
				  <?php
								}
								//My tags count start
								if(count($responseTags2)==0)
								{
									$byMeTagCount = 1;
								}
								//echo count($arrTreeDetailsResponseTags30);
								//My tags count end
				  ?>
				</div>
				</div>
				<?php if($forMeTagCount==1 && $byMeTagCount==1){ $tagblank=1; } ?>
				<input type="hidden" value="<?php echo $tagblank; ?>" id="myTagsCount" />
			</div>
			<!-- My action tags end -->  
			<div class="clr"></div>	
		</div>
	</div>	
	<div class="clr"></div>	
<?php if(count($arrTalks) > 0){ ?>			
<div class="dashboard_row" style="width:100%;">
	<div class="dashboard_col" >
		<!-- Updated talks start -->
		<div class="dashboard_wrap">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/talk-view-sel.png alt='<?php echo $this->lang->line('txt_Talk'); ?>' title='<?php echo $this->lang->line('txt_Talk');?>' border=0> Talks</span> 
		<?php 
		if (count($arrTalks) > 5)
		{
		?>
			<span><a id="more_talks" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_talks');">See all.....</a></span>
		<?php
		}
		?>
				  <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
				<input type="hidden" name="page" value="" />
				<?php					
							if(count($arrTalks) > 0)
							{	
								$rowColor1='row-active-middle1';
								$rowColor2='row-active-middle2';
								$i = 1;
								
								if($this->input->post('treeType')=='')
								{
									echo '';			 
								}
								else
								{
									$count = 0;
									foreach($arrTalks as $treeId=>$data)
									{
										$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
				
										if ($treeType != '' && in_array($parentTreeType,$treeType))
											$count++;
									}				
									
			
								}
								
								foreach($arrTalks as $treeId=>$data)
								{	 
									$leafDataContent=strip_tags($data['name']);
									if (strlen($leafDataContent) > 50) 
									{
										$leafPostTitle = substr($leafDataContent, 0, 50) . "..."; 
									}
									else
									{
										$leafPostTitle = $leafDataContent;
									}
									if($leafPostTitle=='')
									{
										$leafPostTitle = $this->lang->line('txt_img_audio_video');
									}		
								
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($data['userId']);
									$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
									$treeName = $this->identity_db_manager->getTreeNameByTreeId ($data['parentTreeId']);
									
									//Document draft filter code start
									$active = 1;
									if($parentTreeType == 1)
									{
										$leafNodeData = $this->document_db_manager->getNodeDataByLeafId($data['leaf_id']);
										//Add draft reserved users condition
										$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($data['leaf_id']);
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
									if(((in_array($_SESSION['userId'], $resUserIds)) && $parentTreeType == 1 && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish' || $active == 1)
									{
									//Code end
									
									
									$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
										if ($i<6)
										{
											$display='block';
											$class = 'dashboard_content_talks';
										} 
										else 
										{
											$display='none';
											$class = 'dashboard_content_more_talks';
										}
									
									if ($treeType != '' && in_array($parentTreeType,$treeType))
									{
										/* Start - Get last talk comment */
										$talk=$this->discussion_db_manager->getLastTalkByTreeId($data['id']);
										
										//echo "<li>"; print_r ($talk);
										if($talk[0]->userId != '')
										{
											$talk_commentor = $this->notes_db_manager->getUserDetailsByUserId($talk[0]->userId);
										}
						
														if(strip_tags($talk[0]->contents))
						
														{
						
															$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$talk_commentor['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
						
														}
						
														else
						
														{
						
															$latestTalk=$this->lang->line("txt_Talk");
						
														}
										/* End - Get last talk comment */	
																			
										
							?>
					<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
					<div>
					<?php 
											
						echo '<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/tab-icon/talk-view-sel.png alt='.$this->lang->line("txt_Talk").' title="'.$latestTalk.'" border=0></a>&nbsp;';		
											
														if ($parentTreeType==1)
														{
													?>
					<?php
														 if($data['treeType']==1)	
														 {
		echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&tagId=1 target="_blank" class="example7">' .$leafPostTitle. '</a>';
															}
															else
															{
		echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&node='.$data['leaf_id'].'&tagId=1 target="_blank" class="example7">' .$leafPostTitle. '</a>';													
															}
		
		
		 ?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php echo $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php echo $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php	echo '<a href='.base_url().'view_task/node/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php	echo '<a href='.base_url().'contact/contactDetails/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php	echo '<a href='.base_url().'notes/Details/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
													?>
					</div>
					<div>
					<?php 
														if ($parentTreeType==1)
														{
													?>
					<?php echo $this->lang->line('txt_Document');?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php echo $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php echo $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php echo $this->lang->line('txt_Task');?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php echo $this->lang->line('txt_Contact');?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php echo $this->lang->line('txt_Notes');?>
					<?php
														}
													?>
				  		<span><?php //echo $this->lang->line('txt_Modified_Date');?>: </b><?php echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['editedDate']),'m-d-Y h:i A'); ?></span> 
				  </div>
				
					  <div class="clr"></div>
					</div>
				<?php
								}
								else if($this->input->post('treeType')=='')
								{
							?>
				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
					  <div>
					<?php 
										/* Start - Get last talk comment */
										$talk=$this->discussion_db_manager->getLastTalkByTreeId($data['id']);
										
										//echo "<li>"; print_r ($talk);
										if($talk[0]->userId != '')
										{
											$talk_commentor = $this->notes_db_manager->getUserDetailsByUserId($talk[0]->userId);
										}
						
														if(strip_tags($talk[0]->contents))
						
														{
						
															$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$talk_commentor['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
						
														}
						
														else
						
														{
						
															$latestTalk=$this->lang->line("txt_Talk");
						
														}
										/* End - Get last talk comment */				
								//echo 	'<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/tab-icon/talk-view-sel.png alt='.$this->lang->line("txt_Talk").' title="'.$latestTalk.'" border=0></a>&nbsp;'	;			
			
														if ($parentTreeType==1)
														{
					?>
					
					<?php
																 if($data['treeType']==1)
																 {
																	$parentTreeContent = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&option=1&tagId=1  >' .$leafPostTitle. '</a>';                                                
																	}
																	else
																	{
																	
															$parentTreeContent = '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&node='.$data['leaf_id'].'&option=1&tagId=1#docLeafContent'.$data['leaf_id'].'  >' .$leafPostTitle. '</a>';  		
																	}
														?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php $parentTreeContent = $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php $parentTreeContent = $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php	$parentTreeContent = '<a href='.base_url().'view_task/node/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].'#taskLeafContent'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php	$parentTreeContent = '<a href='.base_url().'contact/contactDetails/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].'#contactLeafContent'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php	$parentTreeContent = '<a href='.base_url().'notes/Details/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$leafPostTitle. '</a>'; ?>
					<?php
														}
					?>
					<span class="clsLabel">
					<?php 
														if ($parentTreeType==1)
														{
															$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Document').'" />';
													?>
					<?php //echo $this->lang->line('txt_Document');?>
					<?php
														}
														if ($parentTreeType==4)
														{
															$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Task').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Task');?>
					<?php
														}
														if ($parentTreeType==5)
														{
															$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Contact').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Contact');?>
					<?php
														}
														if ($parentTreeType==6)
														{
															$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Notes').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Notes');?>
					<?php
														}
													?>
							<?php //echo $icon;?>
					</span>
							<!--Space tree type validation start-->	
							<?php if(in_array($parentTreeType,$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme') { ?>
													<a id="liTalk<?php echo $data['id'];?>" class="example7" href="javaScript:void(0)"  title="<?php echo $latestTalk ?>" border="0" ><img src='<?php echo base_url(); ?>images/tab-icon/talk-view-sel.png' alt='<?php echo $this->lang->line("txt_Talk");?>' title="<?php echo $latestTalk; ?>" border=0></a>&nbsp;
													<?php echo $parentTreeContent; ?>
													<span class="clsLabel">(<?php echo $icon .$treeName;?>)</span>

					 
						<span class="clsLabel"><?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php  echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['editedDate']),'m-d-Y h:i A'); ?></span>
						<?php } ?>
						<!--Space tree type validation end-->
					</div>
					  <div class="clr"></div>
					</div>
				<?php	
								}
								
								$i++;
								}//Code end
								}
							}
							?>
			  </form>
		</div>
		<!-- Updated talk end -->  
	</div>
</div>
<div class="clr"></div>	
<?php } ?>

<div class="dashboard_row dashboard_link" style="width:100%;">
	<div class="dashboard_col" >
	<div class="dashboard_wrap">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/link-view-sel.png alt='<?php echo $this->lang->line('txt_Links'); ?>' title='<?php echo $this->lang->line('txt_Links');?>' border=0> <?php echo $this->lang->line('txt_Links');?>
		</span> 
		<div class="linkLoader">
		</div>
	</div>
	</div>
</div>	

<?php if(count($arrLinks) > 0){ ?>	
	<div class="dashboard_row" style="width:100%; display:none;">
		<div class="dashboard_col" >
			<!-- Updated links start -->
			<div class="dashboard_wrap">
			<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/link-view-sel.png alt='<?php echo $this->lang->line('txt_Links'); ?>' title='<?php echo $this->lang->line('txt_Links');?>' border=0> Links</span> 
			<?php 
			if (count($arrLinks) > 5)
			{
			?>
			<span><a id="more_links" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_links');">See all.....</a></span>
			<?php
			}
			?>
					<form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
					<input type="hidden" name="page" value="" />
					<?php	
					
								 if(count($arrLinks) > 0)
								 {	
									$rowColor1='row-active-middle1';
									$rowColor2='row-active-middle2';
									$i = 1;
									
									$counter = 0;
									foreach($arrLinks as $data)
									{
										//echo "<li>"; print_r ($data);
										$view_link = '';
										$treeId=$data[id];
										$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
												if ($i<6)
												{
													$display='block';
													$class = 'dashboard_content_links';
												} 
												else 
												{
													$display='none';
													$class = 'dashboard_content_more_links';
												}
										  ?>
						<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
							  <div>
							<span class="clsLabel">
							<?php 
												
											   if($data['type']==1)
											   {
													//echo $this->lang->line('txt_Document');
													$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Document').'" />';
													$view_link='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["id"].'&doc=exist';
												}
												elseif($data['type']==2)
											   {
													//echo $this->lang->line('txt_Discussion');
													$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
													$view_link='view_discussion/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}
												elseif($data['type']==3)
											   {
													//echo $this->lang->line('txt_Chat');
													$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
														if($data['status']==1)
														{
															$view_link='view_chat/chat_view/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
															
														}
														else
														{
															$view_link='view_chat/node1/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
														}
												}	
												elseif($data['type']==4)
											   {
													//echo $this->lang->line('txt_Task');
													$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Task').'"/>';
													$view_link='view_task/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												elseif($data['type']==5)
											   {
													//echo $this->lang->line('txt_Notes');
													$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Contact').'"/>';
													$view_link='contact/contactDetails/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												elseif($data['type']==6)
											   {
													//echo $this->lang->line('txt_Contact');
													$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Notes').'"/>';
													$view_link='notes/Details/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType;
												}	
												
												elseif($data['linkType']=='external')
											   {
													//echo $this->lang->line('txt_Imported_Files');
													$icon='<img src="'.base_url().'/images/icon_import.png" style="margin-right:5px;" title="'.$this->lang->line('txt_File').'"/>';
													$view_link = 'workplaces/'.$workPlaceDetails['companyName'].'/'.$data['path'].'/'.$data['name'];	
												}	
			 
										?>
						  </span>
						  <!--Space tree type validation start-->	
							<?php if(in_array($data['type'],$spaceTreeDetails) || $workSpaceId==0 || $workSpaceDetails['workSpaceName']=='Try Teeme' || $data['linkType']=='external') { ?>
										<?php
										   echo $icon;
											 if($data['linkType']=='external')
											   {
											   
													 echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].'/external target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';  
											   }
											   else
											   {
																			  
													echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].' target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';													
												}
											
											 ?>
											 <span>(<a href="<?php echo base_url().''.$view_link; ?>" title="<?php echo $this->identity_db_manager->formatContent($data['name'],60,1);?>"><?php echo $this->lang->line('txt_View_Link');?></a>)</span>
		
						  <span class="clsLabel">
								<?php //echo $icon; echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($data['createdDate'], $this->config->item('date_format'));?>
						  </span> 
						  <?php } ?>
						  </div>
							  <div class="clr"></div>
							</div>
						<?php
										
										$i++;
									}
											 
			
												   
							}
							else
							{
									?>
					<div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
					<?php
							
							}
								?>
				  </form>
			</div>
			<!-- Updated links end -->	
		</div>
	</div>
	<div class="clr"></div>
<?php } ?>
<?php if(count($arrTasks) > 0){ ?>	
<div class="dashboard_row" style="width:100%; <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php }  ?>">
	<!-- All tasks start -->
	<div class="dashboard_col" >
			<div class="dashboard_wrap">
				<?php
					if(count($arrTasks) > 0)
					{
						// This loop is for count only
						$c = 0;
							foreach($arrTasks as $key => $arrTagData)
							{
								$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									if (!$checksucc)
									{
										$c++;
									}
							}
					}
					else
					{
						$c = 0;
					}
	
				?>
				<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_task_sel.png alt='<?php echo $this->lang->line('txt_My_Tasks'); ?>' title='<?php echo $this->lang->line('txt_Tasks');?>' border=0> <?php echo $this->lang->line('txt_Tasks');?></span> <span> (<?php echo $c;?>)</span>
					<?php         
					if($c > 5)
					{																	
					?>			
						<span><a id="more_tasks" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_tasks');">See all.....</a></span>
					<?php
					}
					?>
				<div class="dashboard_wrap">
				  <?php         
								if(count($arrTasks) > 0)
								{									
									
				  ?>
									<div>
									<?php
									$i=1;
									// This loop is for rendering
									foreach($arrTasks as $key => $arrTagData)
									{
										$userDetails = array();
										$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
										if ($i<6)
										{
											$display='block';
											$class = 'dashboard_content_tasks';
										} 
										else 
										{
											$display='none';
											$class = 'dashboard_content_more_tasks';
										}
	
										$end_date = substr ($arrTagData['endtime'],0,10);
										$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
										
										$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
										$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
										
										if (!$checksucc)
										{
											?>
											<div class=<?php echo $class;?> style="margin:10px 0 10px; display:<?php echo $display;?>">
												<?php
												
												$taskdataContent=strip_tags($arrTagData['contents']);
												if (strlen($taskdataContent) > 120) 
												{
													$taskTitle = substr($taskdataContent, 0, 120) . "..."; 
												}
												else
												{
													$taskTitle = $taskdataContent;
												}
												
												echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.$taskTitle.'</a>';
												?>
												<span class='clsLabel'>
												 
												<?php
												echo $userDetails['userTagName'];
												if($arrTagData['editedDate'][0]==0)
												{
								
													echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['createdDate'], $this->config->item('date_format')).'<br/>';
								
												}
								
												else
								
												{
								
												 echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrTagData['editedDate'], $this->config->item('date_format')).'<br/>';
								
												}
												?>
												</span>
											</div>
											<?php
											$i++;
										}
									}						
									?>
									</div>
				  <?php
								}
			
				  ?>
				</div>
				<div class="clr"></div>					
			</div>
		</div>	
	</div>
	<!-- All tasks end -->
	<div class="clr"></div>	
<?php } ?>	

<div class="dashboard_row dashboard_tag" style="width:100%;">
	<div class="dashboard_col" >
	<div class="dashboard_wrap">
	<div class="dashboard_title">
		<img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_Tags'); ?>' title='<?php echo $this->lang->line('txt_Tags');?>' border=0> <?php echo $this->lang->line('txt_Tags'); ?>
	</div>
		<div class="tagLoader">
		</div>
	</div>
	</div>
</div>

<?php //echo $arrAllTagsCount.'==='; 
if($arrAllTagsCount > 0){ ?>
	<div class="dashboard_row" style="width:100%; display:none;">
		<div class="dashboard_col" >
			<!-- Updated tags start -->
			<div class="dashboard_wrap">
			<div class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_Tags'); ?>' title='<?php echo $this->lang->line('txt_Tags');?>' border=0> <?php echo $this->lang->line('txt_Tags'); ?></div> 
			<?php /*?><div class="clsLabel">s=<?php echo $this->lang->line('txt_Simple_Tag');?>, a=<?php echo $this->lang->line('txt_Response_Tag');?>, c=<?php echo $this->lang->line('txt_Contact_Tag');?></div><?php */?>
			<div style="margin:8px 0;">
			
			<?php //echo "<li>total tags= " .count($arrTags); ?>
	
			<!-- Andy: Commented because total tags are not filtered by space so shows total tags in the place
			<span><a id="more_tags" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_tags');">See all.....</a></span>-->
	
					  <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
					<input type="hidden" name="page" value="" />
					<?php	
						$applied=0;$due=0;$list=0;$usersString=0;
						if(count($arrTags) > 0)
						{
							$rowColor1='row-active-middle1';
							$rowColor2='row-active-middle2';
							$i = 1;
							
							$counter = 0;
							?>
				<div class="simple_tag" style="margin:10% 0%;">
				<div style="padding: 3% 0;">Simple Tag:</div>
				<?php
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										//echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
									//echo "<li>total nodes= " .$total_nodes;
									if ($total_nodes > 1)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
															//echo "(";	
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
																//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//print_r($arrTreeDetails);
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														if ($tagData['treeType']==1)
														{
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==2)
														{
														  
															
														
															echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==4)
														{ 
															echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														$count++;
														if ($tagData['treeType']==1)
														{ 
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&node='.$tagData["artifactId"].'&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==2)
														{
														
															if($tagData['predecessor'] != 0)
															{
																echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																	
															}
															else
															{
															
															echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
															
															}
															
													
														}
													
														if ($tagData['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==4)
														{
															echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													?>
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
																//echo "(";
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
																//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								
								
							 ?>
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post simple tag public start here
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
								//echo $tagData["tag"].'=======<br>';
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				 
				
				
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
								 	$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic('0', '0', 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										//echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
									//echo "<li>total nodes= " .$total_nodes;
									if ($total_nodes > 1)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic('0', '0', 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//echo '<pre>';
										//print_r($arrTreeDetails);
										
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														//echo 'testing=========='.$tagData['treeType'].'<br>';
														
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													?>
													<?php if ($tagData['treeType']==''){ ?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<?php } ?>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								?>
								
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post simple tag public end here
							
							//Timeline post simple tag start here
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
								//echo $tagData["tag"].'=======<br>';
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				 
				
				
				<?php
								 if($tagData['tagType']==2 ) //for simple tag
								 {
								 	$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										//echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
									//echo "<li>total nodes= " .$total_nodes;
									if ($total_nodes > 1)
									{
										echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
													<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
									}
									else
									{
										//echo "<li>here";
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
										//echo '<pre>';
										//print_r($arrTreeDetails);
										
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData)
												{
													if ($tagData['artifactType']==1)
													{
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData['artifactType']==2)
													{
														//echo 'testing=========='.$tagData['treeType'].'<br>';
														
														$count++;
														
														if ($tagData['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													?>
													<?php if ($tagData['treeType']==''){ ?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<?php } ?>
													<!--<div class="clr"></div>-->
													<?php
												}
											}
										}
								 }
								?>
								
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							
							//Timeline simple post tag end here
							
							?>
							</div>
							<div class="action_tag" style="margin:10% 0%;">
				<div style="padding: 3% 0;">Action Tag:</div>
				<?php
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				<?php
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
															//echo "(";	
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
																//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															if ($tagData3['treeType']==1)
															{
																echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==2)
															{
															  
																
															
																echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==3)
															{
																echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==4)
															{ 
																echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==5)
															{
																echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==6)
															{
																echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															if ($tagData3['treeType']==1)
															{ 
																echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&node='.$tagData3["artifactId"].'&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==2)
															{
															
																if($tagData3['predecessor'] != 0)
																{
																	echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData3['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData3['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																		
																}
																else
																{
																
																echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData3['tagComment'].'</a>'; 
																
																}
																
														
															}
														
															if ($tagData3['treeType']==3)
															{
																echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==4)
															{
																echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==5)
															{
																echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														
															if ($tagData3['treeType']==6)
															{
																echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
																
															}
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
															//echo "(";
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
															//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 
								 
								
							 ?>
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post public action tag start here
							
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				  
								
								<?php
								
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic('0', '0', 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic ('0', '0', 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
																
															}
															
															
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															}
															
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 ?>
								 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							//Timeline post public action tag end here
							
							//Timeline post action tag start here
							
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				  
								
								<?php
								
								 if($tagData['tagType']==3) //for response tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline ($workSpaceId, $workSpaceType, 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
											$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
										
											$dispResponseTags .= ' [';							
											$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
											if(!$response)
											{
												if ($tagData['tag']==1 )
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
												if ($tagData['tag']==2)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
												if ($tagData['tag']==3)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
												if ($tagData['tag']==4)
												//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
												$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
											}
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
											
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							
									$dispResponseTags .= '], ';
									  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
										  $dispResponseTags='';
													?>
	
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline ($workSpaceId, $workSpaceType, 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
													foreach($arrTagData as $key1 => $tagData3)
													{
														
														if ($tagData3['artifactType']==1)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
																
															}
															
															
														}
														
														if ($tagData3['artifactType']==2)
														{
															$count++;
															
															if ($tagData3['treeType']=='')
															{ 
																echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															}
															
														}
								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
								$dispResponseTags .= ' [';							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{
									if ($tagData['tag']==1 )
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
									if ($tagData['tag']==2)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
									if ($tagData['tag']==3)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
									if ($tagData['tag']==4)
									//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
									$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
								}
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
								
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
				
				
						$dispResponseTags .= '], ';
						  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2);	 
							  $dispResponseTags='';
													?>
													
													<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
													}
												}
	
										}
	
								 
								 
								 }
								 ?>
								 
							
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post action tag end here
							
							?>
							</div>
							<div class="contact_tag" style="margin:10% 0%;">
				<div style="padding: 3% 0;">Contact Tag:</div>
				<?php
							foreach($arrTags as $treeId=>$tagData)
							{
						
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*		Andy: Commented because total tags are not filtered by space so shows total tags in the place								
											if ($i<6)
											{
												$display='block';
												$class = 'dashboard_content_tags';
											} 
											else 
											{
												$display='none';
												$class = 'dashboard_content_more_tags';
											}	*/	
															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				<?php
								if($tagData['tagType']==5) //for contact tag
								 {
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
																//echo "(";
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
																//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														if ($tagData2['treeType']==1)
														{
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==2)
														{
														  
															
														
															echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==4)
														{ 
															echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData2['artifactType']==2)
													{
														$count++;
														if ($tagData2['treeType']==1)
														{ 
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&node='.$tagData2["artifactId"].'&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==2)
														{
														
															if($tagData2['predecessor'] != 0)
															{
																echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData2['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData2['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																	
															}
															else
															{
															
															echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
															
															}
															
													
														}
													
														if ($tagData2['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==4)
														{
															echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData2['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													?>
													
														<span class="clsLabel"><?php //echo $this->lang->line('txt_Tag_Type').": ";?>
														<?php 
																//echo "(";
																	   if($tagData['tagType']==2)
																	   {
																			//echo $this->lang->line('txt_Simple_Tag');
																			//echo "s";
																		}
																		elseif($tagData['tagType']==3)
																	   {
																			//echo $this->lang->line('txt_Response_Tag');
																			//echo "a";
																		}
																		elseif($tagData['tagType']==5)
																	   {
																			//echo $this->lang->line('txt_Contact_Tag');
																			//echo "c";
																		}	
																//echo ")";
														?>
														</span>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
								
							 ?>
<!--			  </div>
	
				</div>-->
			<?php
							
							$i++;
							}
							
							//Timeline post public contact tag start here
							
							
							foreach($arrTagsTimelinepublic as $treeId=>$tagData)
							{
								if($tagData['workSpaceId']==$workSpaceId)
								{
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				   
								 
								 <?php
								 
								 if($tagData['tagType']==5) //for contact tag
								 {
								 	//echo $tagData['tagType'].'<br>';
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimelinePublic ('0', '0', 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/public" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic ('0', '0', 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
											//echo $tagData["tag"];
											//echo '<pre>';
											//print_r($arrTreeDetails);
											//exit;
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													
													if ($tagData2['artifactType']==2)
													{
													
														
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
														
													}
													?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
							 ?>
			<?php
							}
							$i++;
							}
							
							
							//Timeline post public contact tag end here
							
							//Timeline post contact tag start here
							
							foreach($arrTagsTimeline as $treeId=>$tagData)
							{
								
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

															
							  ?>
<!--				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				  <div>-->
				   
								 
								 <?php
								 
								 if($tagData['tagType']==5) //for contact tag
								 {
								 	//echo $tagData['tagType'].'<br>';
									$total_nodes = 0;
									$total_nodes = $this->identity_db_manager->getNodeCountByTagTimeline ($workSpaceId, $workSpaceType, 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//echo "total nodes= " .$total_nodes;
									
										if ($total_nodes > 1)
										{
											echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/post" target="_blank">'.$tagData['tagComment'].'</a>';
													?>
													 
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php										
											
										}
										else
										{
											$arrTreeDetails = array();
											$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline ($workSpaceId, $workSpaceType, 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
											//echo $tagData["tag"];
											//echo '<pre>';
											//print_r($arrTreeDetails);
											//exit;
								
											$arrDetails['arrTreeDetails'] = $arrTreeDetails;
											$arrDetails['workSpaceId'] = $workSpaceId;	
											$arrDetails['workSpaceType'] = $workSpaceType;	
												foreach($arrTreeDetails as $key => $arrTagData)
												{ 
												foreach($arrTagData as $key1 => $tagData2)
												{
													
													if ($tagData2['artifactType']==1)
													{
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
													}
													
													if ($tagData2['artifactType']==2)
													{
													
														
														$count++;
														
														if ($tagData2['treeType']=='')
														{ 
															echo '<a target="_blank" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'">'.$tagData['tagComment'].'</a>';
															
														}
														
														
													}
													?>
														<span class="clsLabel">
															<?php //echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
														</span> 
														<span> | </span>
													<!--<div class="clr"></div>-->
													<?php
												}
												}
												
										}
								 
								 }
							 ?>
			<?php
							
							$i++;
							}
							
							//Timeline post contact tag end here
							
							?>
							</div>
							<?php
					}
					else
					{
						 ?>
			<div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
			<?php
					}
								?>
				  </form>
				  </div>
			</div>
			<!-- Updated tags end -->	
		</div>
	</div>	
	<div class="clr"></div>
<?php } ?>	
	<!--Timeline first five post start here-->
<?php if(count($arrPostsTimeline) > 0){ ?>		
	<div class="dashboard_row" style="width:100%;">
		<!-- Recent messages start -->
		<div class="dashboard_col" >
				<div style="margin-bottom: 15px;"><span class="dashboard_title"><img src=<?php echo base_url(); ?>images/message_blue_btn.png alt='<?php echo $this->lang->line('post_txt'); ?>' title='<?php echo $this->lang->line('post_txt');?>' border=0> <?php echo $this->lang->line('post_txt'); ?></span> 
				<?php
				//echo '<pre>';   
				//print_r($arrPostsTimeline);
				//exit;      
				if(count($arrPostsTimeline) > 5)
				{																	
				?>			
					<span><a id="more_messages" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_messages');">See all.....</a></span>
				<?php
				}
				?>
				</div>
				<?php
				$i=1;
				
				foreach($arrPostsTimeline as $keyVal=>$arrVal)
				{
					
						if ($i<6)
						{
							$display='block';
							$class = 'dashboard_content_messages';
						} 
						else 
						{
							$display='none';
							$class = 'dashboard_content_more_messages';
						}	
						$userDetails = array();
						$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);
						
											
															
					?>
						
						<div class="<?php echo $class;?>" style="margin:10px 0 35px;display:<?php echo $display;?>">
							<div>
								<?php 
								$leafdataContent=strip_tags($arrVal['contents']);
								if (strlen($leafdataContent) > 120) 
								{
									$PostTitle = substr($leafdataContent, 0, 120) . "..."; 
								}
								else
								{
									$PostTitle = $leafdataContent;
								}
								if($PostTitle=='')
								{
									$PostTitle = $this->lang->line('post_contains_only_image');
								}
								
								$icon='<img src="'.base_url().'/images/message_blue_btn16.png" style="margin-right:5px;" title="'.$latestComment.'" />';
								?>
								<div class="flLt" style="margin-top:0px;"><?php echo $icon;?></div>
								<div class="flLt"><?php echo '<a target="_blank" style="text-decoration:none; color:#000;" href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/'.$workSpaceType.'/0/'.$arrVal["nodeId"].'/#form'.$arrVal["nodeId"].'" >'.$PostTitle.'</a>'; ?></div>
								<div class="clr"></div>
				
							</div>
							<div class='clsLabel' style="margin-top:10px;">
								
								<span><a><?php echo $userDetails['userTagName'];?></a>
								<span><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['TimelineCreatedDate'],$this->config->item('date_format'),1);?></span>
								<?php //echo $userDetails['userTagName'];?></span>
							</div>
							
						</div>
				<?php
					
					
					$i++;
				}
				?>
			</div>
		</div>
		<!-- Recent messages end -->
	
	<div class="clr"></div>
	
	<!--Timeline first five post end here-->
<?php } ?>	
<?php if(count($externalDocs) > 0){ ?>		
	<div class="dashboard_row" style="width:100%;">
		<div class="dashboard_col" >
		<!-- Recent importedfiles start -->
		<div><span class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_import.png alt='<?php echo $this->lang->line('txt_Imported_Files'); ?>' title='<?php echo $this->lang->line('txt_Imported_Files');?>' border=0> Files</span> 
			<?php         
			if(count($externalDocs) > 5)
			{																	
			?>	
		<span><a id="more_files" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_files');">See all.....</a></span>
			<?php
			}
			?>
		</div>	
		<?php
		$i=1;
		foreach($externalDocs as $docData)
		{
				if ($i<6)
				{
					$display='block';
					$class = 'dashboard_content_files';
				} 
				else 
				{
					$display='none';
					$class = 'dashboard_content_more_files';
				}		
			$userDetails = array();	
			$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($docData['userId']);
			$arrFileUrl	= $this->identity_db_manager->getExternalFileDetailsById( $docData['docId']);		
			//$url = base_url().$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];	
			$url = base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];	
		?>
			<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				<div>
					<span><a href='<?php echo $url;?>'><?php echo $docData['docCaption'].'_v'.$docData['version'];?></a></span>
					<span class='clsLabel'>
						<span><?php echo $userDetails['userTagName'];?></span>
						<span><?php echo $this->time_manager->getUserTimeFromGMTTime($docData['docCreatedDate'], $this->config->item('date_format'));?></span>			
					</span>
				</div>
			</div>
		<?php
			$i++;
		}
		?>
		
		<!-- Recent imported files end -->		
		</div>
	</div>
	<div class="clr"></div>	
<?php } ?>
<?php if(count($workSpaceMembers) > 0){ ?>		
	<div class="dashboard_row" style="width:100%;">
		<!-- Recent users start -->
		<div class="dashboard_col" >
			<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/view_users.gif alt='<?php echo $this->lang->line('txt_User'); ?>' title='<?php echo $this->lang->line('txt_User');?>' border=0> Users</span> 
			<?php         
			if(count($workSpaceMembers) > 5)
			{																	
			?>				
			<span><a id="more_users" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_users');">See all.....</a></span>
			<?php
			}
			?>
			<div class="dashboard_wrap">
				<?php
				$i=1;
				//print_r ($workSpaceMembers);
				foreach($workSpaceMembers as $keyVal=>$workPlaceMemberData)
				{
					if ($i<6)
					{
						$display='block';
						$class = 'dashboard_content_users';
					} 
					else 
					{
						$display='none';
						$class = 'dashboard_content_more_users';
					}	
				?>
					<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
						<span>
							<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $workPlaceMemberData['userId']; ?>"><?php if($workSpaceType==2){ echo $workPlaceMemberData['tagName']; } else { echo $workPlaceMemberData['userTagName']; } ?><?php /*echo $workPlaceMemberData['firstName']. " ".$workPlaceMemberData['lastName']; */ ?></a>
							<span class='clsLabel'><?php /*echo $workPlaceMemberData['userTagName'];?>)<?php echo "&nbsp;"; */ ?>(Last Login: <?php if($workPlaceMemberData['lastLoginTime']!=''){ echo $this->time_manager->getUserTimeFromGMTTime($workPlaceMemberData['lastLoginTime'],$this->config->item('date_format'),1); } else { echo 'NA'; } ?>)</span>
						</span>
					</div>
				<?php
					$i++;
				}
				?>
			</div>
		</div>
		<!-- Recent users end -->
	</div>
	<div class="clr"></div>	
<?php } ?>	
</div>
</div>
<!-- close div id content --> 
</div>
<!-- close div id container -->
	<div>
		<?php $this->load->view('common/foot_for_mobile');?>		
		<?php $this->load->view('common/footer_for_mobile');?>
	</div>
</body>
</html>
<script>
		// Keep Checking for total tree count every 5 second
		//setInterval("checkTotalTreeCount(<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);
		
		//Add SetTimeOut 
		setTimeout("checkTotalTreeCount(<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);
		
</script>
<script type="text/javascript">


	if($(window).width()<760)
	{
		$("#menu2_for_mobile").css('display','inline'); 
		$("#menu2_for_web").css('display','none');
	}
	else
	{
	    $("#menu2_for_mobile").css('display','none'); 
		$("#menu2_for_web").css('display','inline'); 
	}
	window.addEventListener("orientationchange", function() {
		  var t=setTimeout(function(){
				if($(window).width()<760)
				{ 
				   $("#menu2_for_mobile").css('display','inline'); 
		           $("#menu2_for_web").css('display','none');
				}
				else
				{
				   $("#menu2_for_mobile").css('display','none'); 
		           $("#menu2_for_web").css('display','inline'); 
				}
		  },200)
	}, false);
	

   // jQuery('#jsddm2').jcarousel({ });
	
//Get Tag content using ajax

function getDashboardTags()
{
	$(".tagLoader").html("<div id='overlay' style='margin:2% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		$.ajax({

			  url: baseUrl+"dashboard/getDashboardTags/"+workSpaceId+"/type/"+workSpaceType,

			  type: "POST",

			  success:function(result){

					if(result!='')
					{
						//$(".dashboard_tag").show();
						$(".dashboard_tag").replaceWith(result);
					}
					else
					{
						$(".dashboard_tag").remove();
					}

				}

		});
}

function getDashboardLinks()
{
	$(".linkLoader").html("<div id='overlay' style='margin:2% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		$.ajax({

			  url: baseUrl+"dashboard/getDashboardLinks/"+workSpaceId+"/type/"+workSpaceType,

			  type: "POST",

			  success:function(result){
					if(result!='')
					{
						//$(".dashboard_tag").show();
						$(".dashboard_link").replaceWith(result);
					}
					else
					{
						$(".dashboard_link").remove();
					}

				}

		});
}

$(document).ready(function(){
	getDashboardLinks();
	getDashboardTags();
});

//Code end

</script>