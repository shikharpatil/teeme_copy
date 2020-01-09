<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Task > Calendar</title>
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head');?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
	
</head>
<body>
<div id="wrap1">
<div id="header-wrap">
<?php $this->load->view('common/header_for_mobile'); ?>
<?php $this->load->view('common/wp_header'); ?>
<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
</div>
</div>
<div id="container_for_mobile">

		<div id="content">


       
          
          
         
			<!-- Main menu -->
			<?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
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
		
		
		  
		  
            
					<?php 
			$option = 3;
			$day 	= date('d');
			$month 	= date('m');
			$year	= date('Y');	
			$nodeView = 0;
			$artifactTreeId = 0;
			if($this->uri->segment(10) != '' && $this->uri->segment(10) != 0)
			{
				$nodeView = 1;
				$artifactTreeId = $this->uri->segment(10);
			}			
			if($this->uri->segment(3) != '' && $this->uri->segment(3) != 0)
			{	
				$option = $this->uri->segment(3);	
			}			
			if($this->uri->segment(4) != '' && $this->uri->segment(4) != 0)
			{	
				$day = $this->uri->segment(4);	
			}	
			if($this->uri->segment(5) != '' && $this->uri->segment(5) != 0)
			{	
				$month = $this->uri->segment(5);	
			}					 
			if($this->uri->segment(6) != '' && $this->uri->segment(6) != 0)
			{	
				$year = $this->uri->segment(6);	
			}							
			if($month <10 ) 
			{ 
				$month1	= '0'.$month; 
			}			
			$tmpd 		= getdate(mktime(0, 0, 0, $month, 1, $year));
			$disMonth 	= $tmpd["month"]; 			
			?>
			
              
                
		<?php
			if($treeId > 0)
			{
			?>	
			
			<div class="menu_new" >
			
			<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait task_tab_for_potrait">
			
				<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</ul>
        <!--follow and sync icon code end -->
			
            <ul class="tab_menu_new_for_mobile task_tab_menu_for_mob">
				<li class="task-view"><a class="1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>
				<li class="time-view"><a   href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"  title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
				
				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
						
    			<li class="link-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"    title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>	
				
				 <li class="talk-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>
				
				<li class="task-calendar_sel"><a  class="active"  href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>"    ></a></li>
				
                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" ></a></li>
				
				
				
					
            	<?php
				if (($workSpaceId==0))
				{
				?>
                 <li  class="share-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6" title="<?php echo $this->lang->line('txt_Share');?>"></a></li>
                <?php
				}
				?>
				<div class="tab_for_landscape task_tab_for_landscape">
				<?php /*?><li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li><?php */?>
				
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
        
            	
          
		<?php
			}
			?>				
    
            
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <?php
			  if ($option==1)
			  {
			  ?>
              <tr>
                <td colspan="2" align="left"><img src="<?php echo base_url();?>images/calendar-icon.jpg" width="24" height="23" hspace="3" vspace="3" align="absmiddle" />
				<strong>
				<a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $day;?>/<?php echo (($month-1)<1) ? 12 : $month-1 ?>/<?php echo (($month-1)<1) ? $year-1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/left.gif" width="10" height="11" border="0"></a>	
				<?php echo $disMonth.' '.$year;?><a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $day;?>/<?php echo (($month+1)>12) ? 1 : $month+1 ?>/<?php echo (($month+1)>12) ? $year+1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/right.gif" border="0"></a>
				</strong>

				</td>
              </tr>
              <?php
			  }
			  ?>
              <?php
			  if ($option==2)
			  {
			  ?>
              <tr>
                <td colspan="2" align="left">
                <?php
				$lastday 	= $this->time_manager->getLastDayofMonth($month, $year);

				if ($this->uri->segment(4)==0)
				{
					$day = $lastday;
				}

				
				if($day < $lastday)
				{ 
					$curWeekDay = date('w',mktime(0, 0, 0, $month, $day-1, $year)); 
				}
				else
				{
					$curWeekDay = date('w',mktime(0, 0, 0, $month, 1, $year)); 
				}				

				if($day <= $lastday)
				{	
					$dispDate	= date('F jS, Y l',mktime(0,0,0,$month,$day,$year));
					$curDate 	= date('Y-m-d H:i:s',mktime(1,0,0,$month,$day,$year));
					$curDate1 	= date('Y-m-d',mktime(0,0,0,$month,$day,$year));
				}
				else
				{
					$dispDate	= date('F jS, Y l',mktime(0,0,0,$month,1,$year));
					$curDate 	= date('Y-m-d H:i:s',mktime(1,0,0,$month,1,$year));
					$curDate1 	= date('Y-m-d',mktime(0,0,0,$month,$day,$year));
				}
				
				if ($day>$lastday)
					$nextday = 1;
				else if ($day ==0 )
					$nextday = $lastday;
				else
					$nextday = $day;

				?>
                <img src="<?php echo base_url();?>images/calendar-icon.jpg" width="24" height="23" hspace="3" vspace="3" align="absmiddle" />
				<strong>
				<a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $nextday-7 ;?>/<?php echo (($month-1)<1) ? 12 : $month ?>/<?php echo (($month-1)<1) ? $year-1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/left.gif" width="10" height="11" border="0"></a>	
				<?php echo $dispDate;?><a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $nextday+7;?>/<?php echo (($month+1)>12) ? 1 : $month ?>/<?php echo (($month+1)>12) ? $year+1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/right.gif" border="0"></a>
				</strong>

				</td>
              </tr>
              <?php
              }
              ?>

              <?php
			  if ($option==3)
			  {
			  ?>
              <tr>
                <td colspan="2" align="left">
                <?php

				$lastday 	= $this->time_manager->getLastDayofMonth($month, $year);

				if ($this->uri->segment(4)==0)
				{
					$day = $lastday;
				}

				
				if($day < $lastday)
				{ 
					$curWeekDay = date('w',mktime(0, 0, 0, $month, $day-1, $year)); 
				}
				else
				{
					$curWeekDay = date('w',mktime(0, 0, 0, $month, 1, $year)); 
				}				

				if($day <= $lastday)
				{	
					$dispDate	= date('F jS, Y l',mktime(0,0,0,$month,$day,$year));
					$curDate 	= date('Y-m-d H:i:s',mktime(1,0,0,$month,$day,$year));
					$curDate1 	= date('Y-m-d',mktime(0,0,0,$month,$day,$year));

				}
				else
				{
					$dispDate	= date('F jS, Y l',mktime(0,0,0,$month,1,$year));
					$curDate 	= date('Y-m-d H:i:s',mktime(1,0,0,$month,1,$year));
					$curDate1 	= date('Y-m-d',mktime(0,0,0,$month,$day,$year));
				}
				
				if ($day>$lastday)
				{
					$nextday = 1;
				}
				else if ($day ==0 )
					$nextday = $lastday;
				else
					$nextday = $day;

				?>
                <img src="<?php echo base_url();?>images/calendar-icon.jpg" width="24" height="23" hspace="3" vspace="3" align="absmiddle" />
				<strong>
				<a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $nextday-1 ;?>/
				<?php 
				if (($month-1)<1) 
				{
					echo 12;
				} 
				else 
				{
					echo $month;
				} ?>/<?php echo (($month-1)<1) ? $year-1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/left.gif" width="10" height="11" border="0"></a>	
				<?php echo $dispDate;?><a href="<?php echo base_url()?>calendar/index/<?php echo $option;?>/<?php echo $nextday+1;?>/
				<?php 
						if (($month+1)>12)
						{
							echo 1;
						}
						else
						{
							echo $month;
						}
				?>
				/<?php echo (($month+1)>12) ? $year+1 : $year ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>"><img src="<?php echo base_url();?>images/right.gif" border="0"></a>
				</strong>

				</td>
              </tr>
              <?php
              }
              ?>
              <tr>
             
                <td align="right">
				
				<div class="menu_new" >
            <ul class="tab_menu_new">
				
				<?php /*?><li class="task-day-view" ><a  href="<?php echo base_url()?>calendar/index/3/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>" <?php if($option == 3) { ?>class="active" <?php } ?> style="padding:7px 3px 10px 3px!important;"><span>Day View</span></a></li>
				
				<li class="task-time-view"><a href="<?php echo base_url()?>calendar/index/2/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>" <?php if($option == 2) { ?>class="active" <?php } ?> title="Week View" style="padding:7px 3px 10px 3px!important;"><span>Week View</span></a></li>
				<?php */?>
				
				<li class="task-month-view " ><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactType;?>/<?php echo $artifactTreeId;?>" <?php if($option == 1) { ?>class="active" <?php } ?> title="Month View"  style="padding:7px 3px 10px 3px!important;">Month View</a></li>		
    			
            </ul>
			<div class="clr"></div>
        </div>
		
                	
                </td>
              </tr>
              <tr>
                <td colspan="2">
				<?php 
				$arrCalDetails['option'] = $option;
				$arrCalDetails['day'] = $day; 
				$arrCalDetails['month'] = $month; 
				$arrCalDetails['year'] = $year; 
 				$arrCalDetails['artifactTreeId'] = $artifactTreeId;
				if($artifactType == 1)
				{
					$artifactName 		= $this->lang->line('documents');	
					$artifactHeading 	= $this->lang->line('txt_Document');
					$artifactFormat		= 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId=%d&doc=exist';
					if($artifactTreeId > 0)
					{
						$artifactFormat		= 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId=%d&doc=exist';	
					}
					else
					{			
						$artifactFormat		= 'document_home/index/'.$workSpaceId.'/type/'.$workSpaceType;	
					}						
				}	
				elseif($artifactType == 2)
				{
					$artifactName 		= $this->lang->line('discussions');
					$artifactHeading 	= $this->lang->line('disucssion');
					$artifactFormat		= 'view_Discussion/node/%d/'.$workSpaceId.'/type/'.$workSpaceType;
					if($artifactTreeId > 0)
					{
						$artifactFormat		= 'view_Discussion/node/%d/'.$workSpaceId.'/type/'.$workSpaceType;	
					}
					else
					{			
						$artifactFormat		= 'Discussion/index/%d/'.$workSpaceId.'/type/'.$workSpaceType;	
					}							
								
				}
				elseif($artifactType == 3)
				{
					$artifactName 		= $this->lang->line('chats');
					$artifactHeading 	= $this->lang->line('chat_name');
					$artifactFormat		= 'view_Chat/node1/%d/'.$workSpaceId.'/type/'.$workSpaceType;	
				}	
				elseif($artifactType == 4)
				{
					$artifactName 		= $this->lang->line('txt_Tasks');
					$artifactHeading 	= $this->lang->line('txt_Task');
					$artifactFormat		= 'view_task/node/%d/'.$workSpaceId.'/type/'.$workSpaceType;	
					if($artifactTreeId > 0)
					{
						$artifactFormat		= 'view_task/node/%d/'.$workSpaceId.'/type/'.$workSpaceType;	
					}
					else
					{			
						$artifactFormat		= 'view_task/View_All/%d/'.$workSpaceId.'/type/'.$workSpaceType;
					}								
				}	
				elseif($artifactType == 5)
				{
					$artifactName		= $this->lang->line('txt_Contacts');		
					$artifactHeading 	= $this->lang->line('txt_Contact_Name');
					$artifactFormat		= 'contact/contactDetails/%d/'.$workSpaceId.'/type/'.$workSpaceType;
					
				}
				elseif($artifactType == 6)
				{
					$artifactName 		= $this->lang->line('txt_Notes');
					$artifactHeading 	= $this->lang->line('txt_Notes');
					if($artifactTreeId > 0)
					{
						$artifactFormat		= 'Notes/Details/%d/'.$workSpaceId.'/type/'.$workSpaceType;
					}
					else
					{			
						$artifactFormat		= 'Notes/index/%d/'.$workSpaceId.'/type/'.$workSpaceType;
					}										
				}	
								
 				$arrCalDetails['artifactName'] 	= $this->lang->line('txt_Tasks');
				$arrCalDetails['artifactType'] 	= 4;
				$arrCalDetails['artifactHeading'] = $artifactHeading;
				$arrCalDetails['artifactFormat'] = $artifactFormat;
				$arrCalDetails['artifactTreeId'] = $artifactTreeId;
				
				switch($option)
				{
					case 1:
						if($nodeView == 0)
						{										
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/month_calendar_node_for_mobile', $arrCalDetails); 
						}
						else
						{
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/month_calendar_node_for_mobile', $arrCalDetails); 		
						}		
						break;	
					case 2:	

						if($nodeView == 0)
						{										
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/week_calendar_node', $arrCalDetails);
						}
						else
						{
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/week_calendar_node', $arrCalDetails); 		
						}						
						break;	
					case 3:	
						if($nodeView == 0)
						{										
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/day_calendar_node', $arrCalDetails);
						}
						else
						{
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/day_calendar_node', $arrCalDetails); 		
						}						
						break;	
					default:	
						if($nodeView == 0)
						{										
							$this->load->view('common/day_calendar', $arrCalDetails); 
						}
						else
						{
							$arrCalDetails['artifactTreeId'] = $artifactTreeId;
							$this->load->view('common/day_calendar_node', $arrCalDetails); 		
						}						
						break;	
				}			
				?>
				</td>
              </tr>
            </table>
			
               
    
</div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>				