<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Dashboard</title>
	<?php $this->load->view('common/view_head'); ?>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';	
	</script>
	<script>
		function showHideFeedRightData(id1, id2)
		{
			if($('#'+id2).css('display') == 'none')
			{
				document.getElementById(id2).style.display = "inline";
				// document.getElementById(id1).innerHTML = '<img src="<?php echo base_url();?>images/collapse_close_icon_1.png">';
				document.getElementById(id1).innerHTML = '<img src="<?php echo base_url();?>images/collapse_icon_new.png">';
			}
			else
			{
				document.getElementById(id2).style.display = "none";
				// document.getElementById(id1).innerHTML = '<img src="<?php echo base_url();?>images/collapse_open_icon_1.png">';
				document.getElementById(id1).innerHTML = '<img src="<?php echo base_url();?>images/expand_icon_new.png">';
			}
			
		}
	</script>
</head>
<body>
	<div id="wrap1">
	    <div id="header-wrap">
	    	<?php $this->load->view('common/header'); ?>
	    	<?php $this->load->view('common/wp_header'); ?>
	  	</div>
	</div>
	<!-- start div id container -->
	<div id="container">
		<!--left sidebar div start-->
		<div id="leftSideBar" class="leftSideBar">
			<?php $this->load->view('common/left_menu_bar'); ?>
		</div>
		<!--left sidebar div end-->

		<!--right sidebar div start-->
		<div id="rightSideBar">

			<div>
				<!--error or success message display section start-->
				<?php 
				if(isset($_SESSION['errorMsg']) || isset($_SESSION['successMsg']) )
				{ 
				?>
					<div class="error">
					<?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?>
					</div>
					<div class="successMsg">
					<?php if(isset($_SESSION['successMsg'])) { echo $_SESSION['successMsg']; $_SESSION['successMsg'] =''; }?>
					</div>
			    <?php 
				} 
				?>
				<!--error or success message display section end-->

				<!--dashboard title and update icon div start-->
				<div>
					<h1>
						Dashboard
						<span style="float:right;">
							<img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location="<?php echo base_url()?>dashboard/feed/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"' style="cursor:pointer" >
						</span>
					</h1>
				</div>
				<!--dashboard title and update icon div end-->
				
				<div id="dashboardFeedLeftContent">
					<!--feed id div start-->
					<div id="feed">
						<?php 
							$this->load->view('dashboard/feed_content.php');
						?>
					</div>
					<!--feed id div end-->

					<!--loader div start-->
					<div class="scrollNotifyLoader"></div>
					<!--loader div end-->
				</div>
				<div id="dashboardFeedRightContent">
					<?php 
						if($workSpaceId!=0 && $workSpaceDetails['workSpaceName']!='Try Teeme') {
							$treeTypeEnabled = 1;	
						}
					?>

				
					<!--dashboard mytask section start-->
					<div id="dashboardMyTask" style="<?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php }  ?> ">

			
						<div class="dashboard_fee_right_title">
							<img src=<?php echo base_url(); ?>images/icon_task_sel.png alt='<?php echo $this->lang->line('txt_Tasks'); ?>' title='<?php echo $this->lang->line('txt_Tasks');?>' border=0> <?php echo $this->lang->line('txt_Tasks');?>
							<span id="dashboardMyTaskCollapseIcon" onclick="showHideFeedRightData('dashboardMyTaskCollapseIcon', 'dashboardMyTaskCollapseData')" class="feedRightCollapseIcon">
								<img src="<?php echo base_url();?>images/expand_icon_new.png">
							</span>
						</div>
						
						<div id="dashboardMyTaskCollapseData" style="display: none;">
							<div>
								<!--Commented by Dashrath- hide for only show overdue in red-->
								<!-- <span class="color_box" style="background-color:#999999;"></span><span class="flLt clsLabel"><?php echo $this->lang->line('txt_Due_Within_15');?></span> -->

								<span class="color_box" style="background-color:#FF0000;"></span>
								<span class="flLt clsLabel">
									<?php echo $this->lang->line('txt_Overdue');?>	
								</span>

								<!--Commented by Dashrath- hide for only show overdue in red-->
								<!-- 	<span class="color_box" style="background-color:#006600;"></span><span class="flLt clsLabel"><?php echo $this->lang->line('txt_Starting_Within_15');?></span> -->					
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

								// echo '<pre>';
								// print_r($arrTreeDetails);die;	
										
								//$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
								$arrTreeDetails15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 15, $list, $users, $usersAssigned, $for_by);

								// echo '<pre>';
								// print_r($arrTreeDetails15);die;	
									
								//$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
										
								$arrTreeDetailsStarting15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 15, $due, $list, $users, $usersAssigned, $for_by);

								// echo '<pre>';
								// print_r($arrTreeDetailsStarting15);die;	
									
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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/
										
											$userDetails = array();
											$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrTagData['userId']);
											
											$end_date = substr ($arrTagData['endtime'],0,10);
											$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);

											
											
											$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

											
											$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData["id"]);
											
											
											if (!$checksucc)
											{
												echo "<div style='margin: 10px 0px;'>";
												$daysAfter = "+15 days";
									
												$daysAfter = strtotime ($daysAfter);
								
												$daysAfter = date("Y-m-d",$daysAfter);	
												
												if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
												{
													/*Changed by Dashrath- remove class="gray_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
												}
												else
												{
													/*Changed by Dashrath- remove class="green_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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

													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->

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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/

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
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->
												<?php
												}
												else if (($end_date<$today) && ($end_date!='0000-00-00'))
												{
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->
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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/

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
													/*Changed by Dashrath- remove class="green_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
												}
												else
												{
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->

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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/

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
													/*Changed by Dashrath- remove class="gray_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
												}
												else
												{
													/*Changed by Dashrath- remove class="green_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
													
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->

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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/

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
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->

												<?php
					
												}
												else if (($end_date<$today) && ($end_date!='0000-00-00'))
												{
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->
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
											/*Added by Dashrath- trim task content*/
											if (strlen($arrTagData['contents']) > 150) 
		                                    {
		                                        $arrTagData['contents'] = substr($arrTagData['contents'], 0, 150) . "..."; 
		                                    }
		                                    /*Dashrath- code end*/

		                                    /*Added by Dashrath- used in display start time and endtime*/
		                                    $arrStartTime = explode('-',$arrTagData['starttime']);
											$arrEndTime = explode('-',$arrTagData['endtime']);
											/*Dashrath- code end*/

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
													/*Changed by Dashrath- remove class="green_link" from link tag*/
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/												
												}
												else
												{
													// echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';

													/*Changed by Dashrath- add #taskLeafContent818(node id) in url for task focus*/
													echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'> <a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'/#taskLeafContent'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
													/*Dashrath- code end*/
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


													<!--Added by Dashrath- used for display starttime and endtime-->
													<?php
													if($arrStartTime[0] != '00' || $arrEndTime[0] != '00')
													{
													 ?>
												        <span>
													        <?php
													        if($arrStartTime[0] != '00')
															{
															?>
											            		<span class="tagStyleNew" style="" > 
											            			<span class="startTimeIconCls">
											            				<img src="<?php echo base_url();?>images/greennew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   />
											            			</span>
											            			<span>
											            				<?php echo $arrTagData['starttime'];?> 
											            			</span>
											            		</span>
											            	<?php
															}

													        if($arrEndTime[0] != '00')
															{
															?>
													            <span class="tagStyleNew" style="" > 
													            	<span class="endTimeIconCls">
													            		<img src="<?php echo base_url();?>images/rednew.png" style=""  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 
													            	</span>
													            	<span>
													            		<?php echo $arrTagData['endtime'];?>
													            	</span>
													            </span>
													        <?php
															}
															?>
										          		</span>
										          	<?php
													}
													?>
													<!--Dashrath- code end-->
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
						
					
					</div>
					<!--dashboard mytask section end-->
					

					<div class="clr"></div>

					<!--dashboard my action tag section start-->
					<div id="dashboardMyActionTag">
						<div>
							<span class="dashboard_fee_right_title">
								<img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_Action_Tags'); ?>' title='<?php echo $this->lang->line('txt_Action_Tags');?>' border=0> <?php echo $this->lang->line('txt_Action_Tags');?>
							</span>
							<span class="clsLabel"><?php echo ' ('.$this->lang->line('txt_Due_Within_15').')';?>
							</span>
							<span id="dashboardMyActionTagCollapseIcon" onclick="showHideFeedRightData('dashboardMyActionTagCollapseIcon', 'dashboardMyActionTagCollapseData')" class="feedRightCollapseIcon">
								<img src="<?php echo base_url();?>images/expand_icon_new.png">
							</span>
						</div>

						<div id="dashboardMyActionTagCollapseData" style="display: none;">
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
										
									
									echo "<div><b>".$this->lang->line('txt_For_me')." :</b></div>";
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
									 echo "<div><b>".$this->lang->line('txt_By_me')." :</b></div>";
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
						</div>

					</div>
					<!--dashboard my action tag section end-->
					
					<div class="clr"></div>

					<!--dashboard users section start-->
					<div id="dashboardUsers">
						<div>
							<span class="dashboard_fee_right_title"><img src=<?php echo base_url(); ?>images/view_users.gif alt='<?php echo $this->lang->line('txt_User'); ?>' title='<?php echo $this->lang->line('txt_User');?>' border=0> Users</span>
						
							<span class="postTimeStamp" style="padding:2%;">
								<?php 
								if($workSpaceId==0)
								{
									echo $this->lang->line('txt_users_in_place'); 
								}	
								else
								{
									echo $this->lang->line('txt_users_in_space');
								}
								?>
							</span>
							<span id="dashboardUsersCollapseIcon" onclick="showHideFeedRightData('dashboardUsersCollapseIcon', 'dashboardUsersCollapseData')" class="feedRightCollapseIcon">
								<img src="<?php echo base_url();?>images/collapse_icon_new.png">
							</span>
						</div>
						<div id="dashboardUsersCollapseData" style="display: inline;">
							<div style="max-height:700px; overflow-y:scroll; border-top:1px solid #ccc; padding-top:5px;">

		         				<?php
								//online user list view
								if ($workSpaceId_search_user == 0)
								{
								?>
		          					<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
					
		          					<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $myProfileDetail['userId']; ?>" title="" style="word-wrap:break-word;float:left;">
		          						<?php echo wordwrap($myProfileDetail['tagName'],true); ?> 
		          					</a>

									<?php
									if ($_SESSION['all'])
									{
										if ($myProfileDetail['userGroup']>0)
											$showSearchBox = 1;
										else
											$showSearchBox = 0;
									}
									else
									{
										$showSearchBox = 1;
									}
									if ($showSearchBox)	
									{
									?>
							        	<input type="text" name="search" id="search" value="" placeholder="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:98%"/>
									<?php
									}
									?>

		          					<div class="clr"></div>

		          					<?php
		          					if($workSpaceId==0)
		          					{
		          						$workSpaceMembers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
		          						$onlineUsers	= $this->identity_db_manager->getOnlineUsersByPlaceId();
		          					} 
		          					?>
		          					<?php
									if(count($workSpaceMembers) > 0)
									{
										$rowColor1='rowColor6';
										$rowColor2='rowColor5';	
										$i = 1;
									?>

		                        		<div id="divSearchUser" name="divSearchUser" >
		                        			<?php 	

											//show online users	
											if ($_SESSION['all'])
											{
												if ($myProfileDetail['userGroup']>0)
													$showMemberList = 1;
												else
													$showMemberList = 0;
											}
											else
											{
												$showMemberList = 1;
											}
								
											if ($showMemberList)
											{
												foreach($workSpaceMembers  as $keyVal=>$arrVal)
												{
													/*if(in_array($arrVal['userId'],$arrayUsers))
													{*/
													$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
						
													//shows only online users on top
													
														if ($_SESSION['all'])
														{
															if ($myProfileDetail['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}
														else if ($workSpaceId>0)
														{
															$showGuestUser = 1;
														}
														else
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}	
						
														if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)	
														{
															if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
															{
																if ($arrVal['isPlaceManager']==1)
																{
																	$showOnlyPlaceManagersForGuests = 1;
																}
																else
																{
																	$showOnlyPlaceManagersForGuests = 0;
																}
															}
															else
															{
																$showOnlyPlaceManagersForGuests = 1;
															}
															if ($showOnlyPlaceManagersForGuests)
															{
															?>
							
																<div id="row1" class="<?php echo $rowColor;?>"> 
																	<?php echo '<img src="'.base_url().'images/online_user.gif"  width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
																
																	<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"  class="blue-link-underline" title="" style="word-wrap:break-word;float:left;">
																		<?php echo wordwrap($arrVal['tagName'],true); ?> 
																	</a>	
																	<div class="clr"></div>	
																</div>
															<?php
															}
															$i++;
														} 
					
													/*}*/
												}//close online users 
						
												//shows remaining offline users
												foreach($workSpaceMembers as $keyVal=>$arrVal)
												{
													/*if(in_array($arrVal['userId'],$arrayUsers))
													{*/
													$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	
						
														if ($_SESSION['all'])
														{
															if ($myProfileDetail['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}
														else if ($workSpaceId>0)
														{
															$showGuestUser = 1;
														}
														else
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}	
						
														//condition for showing (remaining)offline users	
						
													 	if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
													 	{
															if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
															{
																if ($arrVal['isPlaceManager']==1)
																{
																	$showOnlyPlaceManagersForGuests = 1;
																}
																else
																{
																	$showOnlyPlaceManagersForGuests = 0;
																}
															}
															else
															{
																$showOnlyPlaceManagersForGuests = 1;
															}	
														
															if ($showOnlyPlaceManagersForGuests)
															{
															?>
																<div id="row1" class="<?php echo $rowColor;?>" style="float:left;width:100%"> 
																	<?php echo '<span><img src="'.base_url().'images/offline_user.gif" width="15" height="16" style="margin-top:5px;float:left;" /></span>';?> 
															
																	<span style="float:left; width:1%;">
																		<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],true);?> </a>
																	</span>
								
																  <div class="clr"></div>
								
																</div>
							
															<?php
															}
															$i++;
														}
													/*}*/
												}
											}
							  				?>
		      							</div>
		          					<?php
									}
									else
									{
									?>
		          						<span class="infoMsg">
		          							<?php echo $this->lang->line('txt_None');?>	
		          						</span>
		          					<?php
									}
						 			?>
		          				<?php 
								}
								else
								{
								?>
		        					<div id="row1">

		        						<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
				
		       							<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $myProfileDetail['userId']; ?>" class="blue-link-underline" title="" style="word-wrap:break-word;float:left;margin-left:10px;">
		       								<?php echo wordwrap($myProfileDetail['tagName'],true); ?> 
		       							</a>

										<?php
										if ($_SESSION['all'])
										{
											if ($myProfileDetail['userGroup']>0)
												$showSearchBox = 1;
											else
												$showSearchBox = 0;
										}
										else
										{
											$showSearchBox = 1;
										}
										if ($showSearchBox)	
										{
										?>
								        	<input type="text" name="search" id="search" value="" placeholder="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:98%"/>
										<?php
										}
										?>
		        						<div class="clr"></div>
		      						</div>

		          					<?php
									if(count($workSpaceMembers) > 0)
									{
										$rowColor1='rowColor2';
										$rowColor2='rowColor1';	
										$i = 1;
										?>

		          						<div id="divSearchUser" name="divSearchUser" >

					        				<?php
											if ($_SESSION['all'])
											{
												if ($myProfileDetail['userGroup']>0)
													$showMemberList = 1;
												else
													$showMemberList = 0;
											}
											else
											{
												$showMemberList = 1;
											}

											if ($showMemberList)
											{		
												foreach($workSpaceMembers as $keyVal=>$arrVal)
												{
													/*if(in_array($arrVal['userId'],$arrayUsers))
													{*/
														if ($_SESSION['all'])
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}
														else if ($workSpaceId>0)
														{
															$showGuestUser = 1;
														}
														else
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}	
														//shows only online users on top
						
													 	if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
													 	{
															if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
															{
																if ($arrVal['isPlaceManager']==1)
																{
																	$showOnlyPlaceManagersForGuests = 1;
																}
																else
																{
																	$showOnlyPlaceManagersForGuests = 0;
																}
															}
															else
															{
																$showOnlyPlaceManagersForGuests = 1;
															}	
															
															if ($showOnlyPlaceManagersForGuests)
															{		
																$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
																?>
						
																<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />';  ?> 
															
																	<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>"  class="blue-link-underline" title="" style="word-wrap:break-word;float:left;">
																		<?php echo wordwrap($arrVal['tagName'],true);?> 
																	</a>
																	<div class="clr"></div>				
																</div>
						
															<?php
															}
															$i++;
														}
													/*}*/
												}
						
												foreach($workSpaceMembers as $keyVal=>$arrVal)
												{
													/*if(in_array($arrVal['userId'],$arrayUsers))
													{*/
														if ($_SESSION['all'])
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}
														else if ($workSpaceId>0)
														{
															$showGuestUser = 1;
														}
														else
														{
															if ($arrVal['userGroup']>0)
																$showGuestUser = 1;
															else
																$showGuestUser = 0;
														}	
														//shows only offline users 
						
													 	if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
													 	{
															if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
															{
																
																if ($arrVal['isPlaceManager']==1)
																{
																	$showOnlyPlaceManagersForGuests = 1;
																}
																else
																{
																	$showOnlyPlaceManagersForGuests = 0;
																}
															}
															else
															{
																$showOnlyPlaceManagersForGuests = 1;
															}	
															
															if ($showOnlyPlaceManagersForGuests)
															{
																$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						
															?>
						
																<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<span><img src="'.base_url().'images/offline_user.gif" width="15" height="16"  style="margin-top:5px;float:left;" /></span>';?> 
																
																	<span style="width:1%; float:left;">
																		<a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $arrVal['userId']; ?>" class="blue-link-underline" title="" style="word-wrap:break-word;float:left;">
																			<?php echo wordwrap($arrVal['tagName'],true);?> 
																		</a>
																	</span>
																	<div class="clr"></div>
																</div>
															<?php
															}
															$i++;
														}
													/*}*/
												}
											}
											?>
										</div>
									<?php								
									}
									else
									{
									?>
		        						<span class="infoMsg">
		        							<?php echo $this->lang->line('txt_None');?>	
		        						</span>
		        					<?php
									}
									?>
		      						
		          				<?php 
								}
								?>
		  					</div>
	  					</div>
					</div>
					<!--dashboard users section end-->
				</div>
			</div>
			
		</div>
		<!--right sidebar div end-->

		<!--notification sidebar start-->
		<!--Added by Dashrath- load notification side bar-->
    	<?php $this->load->view('common/notification_sidebar.php');?>
    	<!--Dashrath- code end-->
    	<!--notification sidebar end-->
	</div>
	<!-- close div id container -->

	<div>
		<?php $this->load->view('common/foot'); ?>
	</div>
</body>
</html>
<script>
	//Add SetTimeOut 
	setTimeout("checkTotalFeedCount(<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);

	function seeMoreFeed($id)
	{
		document.getElementById("see_more_feed_"+$id).style.display = "inline";
		document.getElementById("see_less_button_"+$id).style.display = "inline";
		document.getElementById("see_more_button_"+$id).style.display = "none";
	}
	function seeLessFeed($id)
	{
		document.getElementById("see_more_feed_"+$id).style.display = "none";
		document.getElementById("see_less_button_"+$id).style.display = "none";
		document.getElementById("see_more_button_"+$id).style.display = "inline";
	}

	function showSearchUser()
	{
		var toMatch = document.getElementById('search').value;
		
		$.ajax({
				type: "POST",
				url: baseUrl+"post/getPostUserStatus/"+workSpaceId+"/type/"+workSpaceType+"/search",
				data: 'search='+toMatch,
				dataType: 'html',
				success:  function(data){
				 	//alert(data);
					$('#divSearchUser').html(data);
				}
		});
	}

	function removeSearh()
	{
		if(document.getElementById('search').value=='Search')
		{
			document.getElementById('search').value='';
		}
	}
	function writeSearh()
	{
		/*if(document.getElementById('search').value=='')

			document.getElementById('search').value='Search';*/
	}

</script>
<script>
	$(window).scroll(function() {
		if(workSpaceId!='' && workSpaceType!='')
		{
			if($(window).scrollTop() + $(window).height() > $("#container").height())
		  	{
			  	var lastId = $(".feedContent:last").attr("id");
			  	
			  	if(lastId>0)
			  	{
			  		$(".scrollNotifyLoader").html("<div id='overlay' style='margin:1% 0;padding-left:7px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
				  	$.ajax({
							url: baseUrl+'dashboard/feed/'+workSpaceId+'/type/'+workSpaceType+'/scroll/'+lastId,
							type: 'GET',
							async:false,
							success:function(result)
							{
								if(result!='')
								{
									$('#feed').append(result);
								}

								$(".scrollNotifyLoader").html("");
							}
						});
			  	}
			}
		}
	});
</script>