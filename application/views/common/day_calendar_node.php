<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$lastday 	= $this->time_manager->getLastDayofMonth($month, $year);
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
$tasks 		= $this->task_db_manager->getNodesByTreeDate($artifactTreeId, $curDate1);
$endTasks 		= $this->task_db_manager->getNodesByTreeEndDate($artifactTreeId, $curDate1);
$sameDayTasks 	= $this->task_db_manager->getNodesByTreeSameDate($artifactTreeId, $curDate1);

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">                  
  <tr>
	<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr align="center">
		  <td width="100%" align="left" valign="top" class="bg-light-blue-txt-white">
				<strong>
			<?php		
				echo 'Tasks for '.$dispDate;				
			?>
			</strong>
			</td>
	    </tr>
		<tr align="left">
		  <td valign="top" class="style1">
			<table width="98%"  border="0">          
			<?php
			if(count($tasks) > 0 || count($endTasks) > 0 || count($sameDayTasks) > 0)
			{
				if(count($tasks) > 0)
				{					
						?>	
						<tr>
							<td valign="top" class="bg-light-grey">							
								<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
								<?php
									$k = 1;						 
									foreach($tasks as $arrVal)
									{
										$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);
										
								?>		
									<tr>
										<td width="12%">Created By: <?php echo $userDetails['userTagName'];?></td>
										<td width="21%">
                                        	<span class="heading-grey">
												<?php
													if (substr($arrVal['starttime'],0,10) != '0000-00-00')
													{ 
														echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'], 'm-d-Y h:i A');
													}
													if (substr($arrVal['endtime'],0,10) != '0000-00-00')
													{
														echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'], 'm-d-Y h:i A');
                                            		}
												?>
                                            </span>
                                        </td>
									</tr>
										
										<tr id="row1">
											<td colspan="2" align="left" class="bg-white"><?php echo '<a href="'.base_url().'view_task/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['nodeId'].'" target="_blank" style="text-decoration:none;"><img border=0 style=cursor:hand src='.base_url().'images/icon_Green.gif> '.$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';?></td>
										</tr>
										<tr id="row1">
										  <td colspan="2" align="left" class="bg-white"><hr></td>
									 </tr>
									<?php
									$k++;
									}								
								?>                   
							  </table>
							</td>
						</tr>           
						<?php						
				}
				if(count($endTasks) > 0)
				{
					
						?>	
						<tr>
							<td valign="top" class="bg-light-grey">							
								<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D0D0D7">
								<?php
									$k = 1;						 
									foreach($endTasks as $arrVal)
									{
										$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);
										
										?>		
									<tr>
										<td width="12%" class="bg-grey-img">Created By: <?php echo $userDetails['userTagName'];?></td>
										<td width="21%" class="bg-grey-img"><span class="heading-grey"><?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'], 'm-d-Y h:i A').'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'], 'm-d-Y h:i A');?></span></td>
									</tr>
										
										<tr id="row1">
											<td colspan="2" align="left" class="bg-white"><?php echo '<a href="'.base_url().'view_task/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['nodeId'].'" target="_blank" style="text-decoration:none;">' .$this->identity_db_manager->formatContent($arrVal['contents'],250,1).' <img border=0 style=cursor:hand src='.base_url().'images/icon_Red.gif></a>';?></td>
										</tr>
										<tr id="row1">
										  <td colspan="2" align="left" class="bg-white"><hr></td>
									 </tr>
									<?php
									$k++;
									}								
								?>                   
							  </table>
							</td>
						</tr>           
						<?php					
					
				}
				if(count($sameDayTasks) > 0)
				{					
				?>	
						<tr>
							<td valign="top" class="bg-light-grey">							
								<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D0D0D7">
									<?php
									$k = 1;						 
									foreach($sameDayTasks as $arrVal)
									{
										$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);										
										?>		
										<tr>
											<td width="12%" class="bg-grey-img"><?php echo $this->lang->line('txt_Originator').': '.$userDetails['userTagName'];?></td>
											<td width="21%" class="bg-grey-img"><span class="heading-grey"><?php echo $this->lang->line('txt_Start').': '.$arrVal['starttime1'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('txt_End').': '.$arrVal['endtime1'];?></span></td>
										</tr>										
										<tr id="row1">
											<td colspan="2" align="left" class="bg-white"><?php echo '<a href="'.base_url().'view_task/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['nodeId'].'" target="_blank" style="text-decoration:none;">' .$this->identity_db_manager->formatContent($arrVal['contents'],250,1).'</a>';?></td>
										</tr>
										<tr id="row1">
											<td colspan="2" align="left" class="bg-white"><hr></td>
										</tr>
										<?php
									$k++;
									}								
								?>                   
							  </table>
							</td>
						</tr>           
						<?php					
					
				}				
			}
			else
			{
			?>
            <tr>
              <td><?php echo $artifactName.' are not available';?></td>
            </tr>
			<?php
			}
			?>           
          </table>	
		</td>
		  </tr>
	</table></td>
  </tr>  
</table>

