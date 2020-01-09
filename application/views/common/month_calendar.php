<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$tmpd 		= getdate(mktime(0,0,0,$month,1,$year));
$firstwday	= $tmpd["wday"]-1;					
$lastday 	= $this->time_manager->getLastDayofMonth($month, $year);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="blue-border">
  <tr>
	<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="bg-light-blue-txt-white">		
		  <td width="15%" align="center">Monday</td>
		  <td width="14%" align="center">Tuesday</td>
		  <td width="17%" align="center">Wednesday</td>
		  <td width="14%" align="center">Thursday</td>
		  <td width="14%" align="center">Friday</td>
		  <td width="13%" align="center">Saturday</td>
		  <td width="13%" align="center">Sunday</td>
		</tr>
	</table></td>
  </tr>
  <tr>
	<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
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
		$treeIds = $this->document_db_manager->getTreeIdsByWorkSpaceId($workSpaceId, $workSpaceType,$artifactType);
		$arrTags = array();		
		foreach($treeIds as $treeId)
		{
			$tmpTags = $this->tag_db_manager->getTagsByArtifactId($treeId, 1, $curDate);
			if(count($tmpTags) > 0)
			{
				$arrTags[] = $tmpTags;
			}
		}		
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
		$dayname = date('l',mktime(0,0,0,$month,$d,$year));
		$j = 0;												
		if($dayname == 'Sunday')
		{
			print "<td valign='top' class='calendar-box' bgcolor='#D9E3F2'>";
		}	
		else
		{
			echo '<td valign="top" class="calendar-box" bgcolor="#ffffff">';
		}	
		if($d == date('d') && $month == date('m'))
		{			
			echo "<b><a href='".base_url()."calendar/index/3/".$d."/".$month."/".$year."/".$workSpaceId."/".$workSpaceType."/".$artifactType."'><font color='orange'>$d</font></a></b><br>$actionLink";
		}
		else
		{
			echo "<a href='".base_url()."calendar/index/3/".$d."/".$month."/".$year."/".$workSpaceId."/".$workSpaceType."/".$artifactType."'>$d</a><br>$actionLink";		
		}							
		echo '<br><br>';
		echo "</td>\n";
		/*== Saturday end week with </tr> ==*/
		if ($wday==6) 
		{ 
			print "</tr>\n"; 
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

		
	</table></td>
  </tr>  
</table>