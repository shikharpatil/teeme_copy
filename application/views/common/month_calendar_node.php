<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$tmpd 		= getdate(mktime(0,0,0,$month,1,$year));
$firstwday	= $tmpd["wday"]-1;					
$lastday 	= $this->time_manager->getLastDayofMonth($month, $year);

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="blue-border">
  <tr>
	<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="bg-light-blue-txt-white">		
		  <td width="15%" align="center"><?php echo $this->lang->line('monday_txt'); ?></td>
		  <td width="14%" align="center"><?php echo $this->lang->line('tuesday_txt'); ?></td>
		  <td width="17%" align="center"><?php echo $this->lang->line('wednesday_txt'); ?></td>
		  <td width="14%" align="center"><?php echo $this->lang->line('thursday_txt'); ?></td>
		  <td width="14%" align="center"><?php echo $this->lang->line('friday_txt'); ?></td>
		  <td width="13%" align="center"><?php echo $this->lang->line('saturday_txt'); ?></td>
		  <td width="13%" align="center"><?php echo $this->lang->line('sunday_txt'); ?></td>
		</tr>
	</table></td>
  </tr>
  <tr>
	<td valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php  
	$d = 1;
	$wday = $firstwday;
	$firstweek = true;				  			 
	/*== loop through all the days of the month ==*/
	while ( $d <= $lastday) 
	{
		$day = $d;	
		#************************************************** Checking the Tags *********************************************************************	
		$curDate = date('Y-m-d H:i:s',mktime(1,0,0,$month,$d,$year));
		
		
		$actionLink = '';	
		
		if(count($arrTags) > 0)
		{
			$actionLink.= '<a href="'.base_url().'calendar/index/3/'.$d.'/'.$month.'/'.$year.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactType.'" style="text-decoration:none;">Actions';	
		}		
		#************************************************** End Checking the Tags *********************************************************************					
		/*== set up blank days for first week ==*/
		if($firstweek) 
		{			
			echo '<tr align="center">';
			
			if($firstwday == -1)
			{
				for ($i=1; $i<=6; $i++) 
				{
					echo '<td valign="top" class="calendar-box"><font size=2>&nbsp;</font></td>'; 
				}
			}
			for ($i=1; $i<=$firstwday; $i++) 
			{
				echo '<td valign="top" class="calendar-box"><font size=2>&nbsp;</font></td>'; 
			}
			$firstweek = false;
		}					
		/*== Sunday start week with <tr> ==*/
		if ($wday==0) 
		{
			echo '<tr align="center">'; 
		}		
		
		if ($d<10) 
		{ 
			$d	= "0".$d; 
		}
		$dat=$year."-".$month."-".$d;
		$datnew=$month."-".$d."-".$year;
		$cdate = $month."-".$d;	
		
		
		$dayname 			= date('l',mktime(0,0,0,$month,$d,$year));
		$dateNow 			= date('Y-m-d',mktime(0,0,0,$month,$d,$year));
		
		
/*		echo "<li>month= " .$month;
		echo "<li>day= " .$d;
		echo "<li>year= " .$year;
		echo "<li>current datetime 2= " .$dateNow; exit;*/
		$activities 		= $this->task_db_manager->getNodesByTreeDate($artifactTreeId, $dateNow, 1, $workSpaceId, $workSpaceType);		
		$endActivities 		= $this->task_db_manager->getNodesByTreeEndDate($artifactTreeId, $dateNow, 1, $workSpaceId, $workSpaceType);
		$sameDayActivities 	= $this->task_db_manager->getNodesByTreeSameDate($artifactTreeId, $dateNow, 1, $workSpaceId, $workSpaceType);			
				
		$arrSameDayActivities = array();	
		$i = 1;	
		/*echo "<li>datenow01= " .$dateNow;*/
		
		foreach($sameDayActivities as $data)
		{
			/*echo "<li>endtime01= " .$data['endtime'];*/
			if ($dateNow==$this->time_manager->getUserTimeFromGMTTime($data['starttime'],'Y-m-d') && $dateNow==$this->time_manager->getUserTimeFromGMTTime($data['endtime'],'Y-m-d'))
			{	
				if($data['predecessor'] > 0)
				{									
					$arrSameDayActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;"><img border=0 style=cursor:hand src='.base_url().'images/icon_Green.gif>'.$this->identity_db_manager->formatContent($data['contents'],100,1).'<img border=0 style=cursor:hand src='.base_url().'images/icon_Red.gif></a>';				
				}
				else
				{
					$arrSameDayActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;"><img border=0 style=cursor:hand src='.base_url().'images/icon_Green.gif>'.$this->identity_db_manager->formatContent($data['contents'],100,1).'<img border=0 style=cursor:hand src='.base_url().'images/icon_Red.gif></a>';				
				}	
			}	
			$i++;
		}
		$arrActivities = array();	
		$i = 1;	
		foreach($activities as $data)
		{	
/*			echo "<li>originalstarttime01= " .$data['starttime'];
			echo "<li>convertedstarttime01= " .$this->time_manager->getUserTimeFromGMTTime($data['starttime'],'Y-m-d');*/
			
			if ($dateNow==$this->time_manager->getUserTimeFromGMTTime($data['starttime'],'Y-m-d'))
			{			
				if($data['predecessor'] > 0)
				{		
					$arrActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;"><img border=0 style=cursor:hand src='.base_url().'images/icon_Green.gif>'.$this->identity_db_manager->formatContent($data['contents'],100,1).'</a>';				
				}
				else
				{
					$arrActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;"><img border=0 style=cursor:hand src='.base_url().'images/icon_Green.gif>'.$this->identity_db_manager->formatContent($data['contents'],100,1).'</a>';				
				}
			}
			$i++;
		}
		$arrEndActivities = array();	
		$i = 1;		
		foreach($endActivities as $data)
		{			
			/*echo "<li>endtime02= " .$data['endtime'];*/
			
			if ($dateNow==$this->time_manager->getUserTimeFromGMTTime($data['endtime'],'Y-m-d'))
			{	
				if($data['predecessor'] > 0)
				{		
					$arrEndActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;">'.$this->identity_db_manager->formatContent($data['contents'],100,1).'<img border=0 style=cursor:hand src='.base_url().'images/icon_Red.gif></a>';				
				}
				else
				{
					$arrEndActivities[] = '<a href="'.base_url().'view_task/node/'.$data['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['nodeId'].'" target="_blank" style="text-decoration:none;">'.$this->identity_db_manager->formatContent($data['contents'],100,1).'<img border=0 style=cursor:hand src='.base_url().'images/icon_Red.gif></a>';					
				}
			}
			$i++;
		}
		
		$j = 0;												
		if($dayname == 'Sunday')
		{
			print "<td valign='top' class='calendar-box' bgcolor='#D9E3F2' align='left'>";
		}	
		else
		{
			echo '<td valign="top" class="calendar-box" bgcolor="#ffffff" align="left">';
		}	
		//echo date('m');
		if($d == date('d') && $month == date('m'))
		{			
			echo "<b><a href='".base_url()."calendar/index/3/".$d."/".$month."/".$year."/".$workSpaceId."/".$workSpaceType."/".$artifactType."/".$artifactTreeId."' style='text-decoration:none;'><font color='orange'>$d</font></a></b><br>";
			if(count($arrSameDayActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrSameDayActivities);
			}
			if(count($arrActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrActivities);
			}
			if(count($arrEndActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrEndActivities);
			}	
		}
		else
		{
			echo "<a href='".base_url()."calendar/index/3/".$d."/".$month."/".$year."/".$workSpaceId."/".$workSpaceType."/".$artifactType."/".$artifactTreeId."' style='text-decoration:none;'><font color='black'>$d</font></a><br>";
			if(count($arrSameDayActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrSameDayActivities);
			}
			if(count($arrActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrActivities);
			}
			if(count($arrEndActivities) > 0)
			{
				echo '<hr>'.implode('<hr width="100%">',$arrEndActivities);
			}	
		}							
		echo "</td>";
		/*== Saturday end week with </tr> ==*/
		if ($wday==6) 
		{ 
			print "</tr>"; 
		}	
		if($d == $lastday && $wday<6)
		{
			for($i = $wday;$i<6; $i++)
			{
				echo '<td valign="top" class="calendar-box">&nbsp;</td>';
			}	
			echo '</tr>';		
		}						
		$wday++;
		$wday = $wday % 7;
		$d++;
	}
?>		
	</table>
	</td>
  </tr>  
</table>
