<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > My Tasks</title>
<?php $this->load->view('common/view_head'); ?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
<script language="JavaScript1.2">

function showHideDue30()
{
	if (document.getElementById('expandDue30').style.display == '')
	{
		document.getElementById('expandDue30').style.display = 'none';
		document.getElementById('collapseDue30').style.display = '';
		document.getElementById('due30').style.display = '';
	}
	else
	{
		document.getElementById('expandDue30').style.display = '';
		document.getElementById('collapseDue30').style.display = 'none';
		document.getElementById('due30').style.display = 'none';
	}
}

function showHideDueByMe30()
{
	if (document.getElementById('expandDueByMe30').style.display == '')
	{
		document.getElementById('expandDueByMe30').style.display = 'none';
		document.getElementById('collapseDueByMe30').style.display = '';
		document.getElementById('due30').style.display = '';
	}
	else
	{
		document.getElementById('expandDueByMe30').style.display = '';
		document.getElementById('collapseDueByMe30').style.display = 'none';
		document.getElementById('due30').style.display = 'none';
	}
}


function showHideOverdue()
{
	if (document.getElementById('expandOverdue').style.display == '')
	{
		document.getElementById('expandOverdue').style.display = 'none';
		document.getElementById('collapseOverdue').style.display = '';
		document.getElementById('overdue').style.display = '';
	}
	else
	{
		document.getElementById('expandOverdue').style.display = '';
		document.getElementById('collapseOverdue').style.display = 'none';
		document.getElementById('overdue').style.display = 'none';
	}
}
function showHideOverdueByMe()
{
	if (document.getElementById('expandOverdueByMe').style.display == '')
	{
		document.getElementById('expandOverdueByMe').style.display = 'none';
		document.getElementById('collapseOverdueByMe').style.display = '';
		document.getElementById('overdueByMe').style.display = '';
	}
	else
	{
		document.getElementById('expandOverdueByMe').style.display = '';
		document.getElementById('collapseOverdueByMe').style.display = 'none';
		document.getElementById('overdueByMe').style.display = 'none';
	}
}

function showHideStarting30()
{
	if (document.getElementById('expandStarting30').style.display == '')
	{
		document.getElementById('expandStarting30').style.display = 'none';
		document.getElementById('collapseStarting30').style.display = '';
		document.getElementById('starting30').style.display = '';
	}
	else
	{
		document.getElementById('expandStarting30').style.display = '';
		document.getElementById('collapseStarting30').style.display = 'none';
		document.getElementById('starting30').style.display = 'none';
	}
}
function showHideStartingByMe30()
{
	if (document.getElementById('expandStartingByMe30').style.display == '')
	{
		document.getElementById('expandStartingByMe30').style.display = 'none';
		document.getElementById('collapseStartingByMe30').style.display = '';
		document.getElementById('startingByMe30').style.display = '';
	}
	else
	{
		document.getElementById('expandStartingByMe30').style.display = '';
		document.getElementById('collapseStartingByMe30').style.display = 'none';
		document.getElementById('startingByMe30').style.display = 'none';
	}
}


function showHideAllTasks()
{
	if (document.getElementById('expandAllTasks').style.display == '')
	{
		document.getElementById('expandAllTasks').style.display = 'none';
		document.getElementById('collapseAllTasks').style.display = '';
		document.getElementById('allTasks').style.display = '';
	}
	else
	{
		document.getElementById('expandAllTasks').style.display = '';
		document.getElementById('collapseAllTasks').style.display = 'none';
		document.getElementById('allTasks').style.display = 'none';
	}
}
function showHideAllTasksByMe()
{
	if (document.getElementById('expandAllTasksByMe').style.display == '')
	{
		document.getElementById('expandAllTasksByMe').style.display = 'none';
		document.getElementById('collapseAllTasksByMe').style.display = '';
		document.getElementById('allTasksByMe').style.display = '';
	}
	else
	{
		document.getElementById('expandAllTasksByMe').style.display = '';
		document.getElementById('collapseAllTasksByMe').style.display = 'none';
		document.getElementById('allTasksByMe').style.display = 'none';
	}
}

</script>
</head>

<dody>
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
	 $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
</div>
<div id="container_for_mobile">
  <div id="content"   >
    <?php 
					if(isset($_SESSION['errorMsg']) &&  $_SESSION['errorMsg']!='' )
					{ 
				?>
    <div class="error">
      <?php 			if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?>
    </div>
    <?php 
					} 
				?>
    <div class="main_menu btm-border"  >
      <div id="menu2_for_mobile">
        <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm2">
          <li style="width:118px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li style="width:116px!important;"><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li style="width:115px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li style="width:114px!important;"><a  href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li style="width:82px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="active"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li style="width:80px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li style="width:130px!important;"><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
      <div class="clr" ></div>
    </div>
    <!-- close div class tab_menu_new -->
    
    <div> <img src=<?php echo base_url(); ?>images/icon_task.png alt='<?php echo $this->lang->line('txt_My_Tasks'); ?>' title='<?php echo $this->lang->line('txt_My_Tasks');?>' border=0> <?php echo $this->lang->line('txt_My_Tasks');?> </div>
    <div>
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


                echo "<b>".$this->lang->line('txt_For_me')." :</b><br/><br/>";
                
                $for_by = 1;
						
						
						$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
						$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
					
						$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
					
					
					if((count($arrTreeDetails30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_30').' (0 tasks):</span><hr>';
					}

					else if(count($arrTreeDetails30) > 0)
					{	
						// This loop is for count only
						$c = 0;
						foreach($arrTreeDetails30 as $key => $arrTagData)
						{
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandDue30"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideDue30();" style="cursor:pointer;"></span><span id="collapseDue30" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideDue30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_30').' ('.$c.' tasks):</span><hr>';			 
						
						// This loop is for rendering
						?>
      <span id="due30" style="display:none;">
      <?php
						foreach($arrTreeDetails30 as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
							
								$daysAfter = "+7 days";
					
								$daysAfter = strtotime ($daysAfter);
				
								$daysAfter = date("Y-m-d",$daysAfter);	
								
								if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
							}
						}						
						?>
      </span>
      <?php
					}
					
					
					/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
					
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' (0 tasks):</span><hr>';
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
					
						echo '<span id="expandOverdue"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideOverdue();" style="cursor:pointer;"></span><span id="collapseOverdue" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideOverdue();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="overdue" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);

							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
								$daysAgo = "-7 days";
								$daysAgo = strtotime ($daysAgo);
								$daysAgo = date("Y-m-d",$daysAgo);	
								if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}
								else if (($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}
							}
						}						
						?>
      </span>
      <?php
					}
					

					/////////////////////// Starting within ///////////////////////////////////////////////////////////////
					
					if((count($arrTreeDetailsStarting30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_30').' (0 tasks):</span><hr>';
					}

					else if(count($arrTreeDetailsStarting30) > 0)
					{	
						// This loop is for count only
						$c = 0;
						foreach($arrTreeDetailsStarting30 as $key => $arrTagData)
						{
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandStarting30"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideStarting30();" style="cursor:pointer;"></span><span id="collapseStarting30" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideStarting30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_30').' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="starting30" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetailsStarting30 as $key => $arrTagData)
						{
							$start_date = substr ($arrTagData['starttime'],0,10);
						
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
							
								$daysAfter = "+7 days";
					
								$daysAfter = strtotime ($daysAfter);
				
								$daysAfter = date("Y-m-d",$daysAfter);	
								
								if (($start_date<$daysAfter) && ($start_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								
							}
						}	
						?>
      </span>
      <?php
					}
					
					
					
					////////////////// All Tasks//////////////////////////////////////////////////////////////////////////
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_All_Tasks') .' (0 tasks):</span><hr>';
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
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandAllTasks"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideAllTasks();" style="cursor:pointer;"></span><span id="collapseAllTasks" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideAllTasks();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_All_Tasks') .' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="allTasks" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);

							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
							
								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
								
								if (($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="italic_blue_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
							}
						}	
						?>
      </span>
      <?php
					}

					?>
      
      <!--------------- arun --->
      <?php 
					
					  echo "<b>".$this->lang->line('txt_By_me')." :</b><br/><br/>";
					 
					$for_by = 2;
						
						
						$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
						$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
					
						$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
					
					if((count($arrTreeDetails30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_30').' (0 tasks):</span><hr>';
					}

					else if(count($arrTreeDetails30) > 0)
					{	
						// This loop is for count only
						$c = 0;
						foreach($arrTreeDetails30 as $key => $arrTagData)
						{
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandDueByMe30"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideDueByMe30();" style="cursor:pointer;"></span><span id="collapseDueByMe30" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideDueByMe30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_30').' ('.$c.' tasks):</span><hr>';			 
						
						// This loop is for rendering
						?>
      <span id="dueByMe30" style="display:none;">
      <?php
						foreach($arrTreeDetails30 as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
							
								$daysAfter = "+7 days";
					
								$daysAfter = strtotime ($daysAfter);
				
								$daysAfter = date("Y-m-d",$daysAfter);	
								
								if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
							}
						}						
						?>
      </span>
      <?php
					}
					
					/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
					
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' (0 tasks):</span><hr>';
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
					
						echo '<span id="expandOverdueByMe"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideOverdueByMe();" style="cursor:pointer;"></span><span id="collapseOverdueByMe" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideOverdueByMe();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="overdueByMe" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);

							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
							
								$daysAgo = "-7 days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
								
								if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}
								else if (($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}

							}
						}						
						?>
      </span>
      <?php
					}
					

					/////////////////////// Starting within ///////////////////////////////////////////////////////////////
					
					if((count($arrTreeDetailsStarting30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_30').' (0 tasks):</span><hr>';
					}

					else if(count($arrTreeDetailsStarting30) > 0)
					{	
						// This loop is for count only
						$c = 0;
						foreach($arrTreeDetailsStarting30 as $key => $arrTagData)
						{
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandStartingByMe30"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideStarting30();" style="cursor:pointer;"></span><span id="collapseStartingByMe30" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideStarting30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_30').' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="startingByMe30" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetailsStarting30 as $key => $arrTagData)
						{
							$start_date = substr ($arrTagData['starttime'],0,10);
						
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
							$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
							
							if (!$checksucc)
							{
							
								$daysAfter = "+7 days";
					
								$daysAfter = strtotime ($daysAfter);
				
								$daysAfter = date("Y-m-d",$daysAfter);	
								
								if (($start_date<$daysAfter) && ($start_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
								
							}
						}	
						?>
      </span>
      <?php
					}
					
					
					
					////////////////// All Tasks//////////////////////////////////////////////////////////////////////////
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_All_Tasks') .' (0 tasks):</span><hr>';
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
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
								$c++;
							}
						}
					
						echo '<span id="expandAllTasksByMe"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideAllTasksByMe();" style="cursor:pointer;"></span><span id="collapseAllTasksByMe" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideAllTasksByMe();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_All_Tasks') .' ('.$c.' tasks):</span><hr>';			 
						?>
      <span id="allTasksByMe" style="display:none;">
      <?php
						// This loop is for rendering
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$end_date = substr ($arrTagData['endtime'],0,10);

							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
							
							if (!$checksucc)
							{
							
								$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
								$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
								
								if (($end_date<$today) && ($end_date!='0000-00-00'))
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
	
								}
								else
								{
									echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="italic_blue_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
								}
							}
						}	
						?>
      </span>
      <?php
					}

					?>
    </div>
  </div>
  <!-- close div id content --> 
</div>
<!-- close div id container -->
<div>
  <?php $this->load->view('common/foot_for_mobile'); ?>
  <?php $this->load->view('common/footer_for_mobile');?>
</div>
</body></html>
<script type="text/javascript">
   jQuery('#jsddm2').jcarousel({});
</script>