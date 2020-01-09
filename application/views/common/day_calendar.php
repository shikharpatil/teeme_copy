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
$treeIds 	= $this->document_db_manager->getTreeIdsByWorkSpaceId($workSpaceId, $workSpaceType,$artifactType);
$artifacts 	= $this->document_db_manager->getTreesByDate($workSpaceId, $workSpaceType,$artifactType,$curDate1);
$arrTags = array();		
foreach($treeIds as $treeId)
{
	$tmpTags = $this->tag_db_manager->getTagsByArtifactId($treeId, 1, $curDate);
	if(count($tmpTags) > 0)
	{
		$arrTags[] = $tmpTags;
	}
}	
			
		?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="blue-border">                  
  <tr>
	<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr align="center">
		  <td width="100%" align="left" valign="top" class="bg-light-blue-txt-white">
				<strong>
			<?php		
				echo $artifactName.' added on '.$dispDate;				
			?>
			</strong>
			</td>
	    </tr>
		<tr align="left">
		  <td valign="top" class="style1">
			<table width="98%"  border="0">          
			<?php
			if(count($artifacts) > 0)
			{
				
					?>	
					<tr>
						<td valign="top" class="bg-light-grey">							
							<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#D0D0D7">
								<tr>
									<td width="12%" class="bg-grey-img"><span class="heading-grey">S.No</span></td>
									<td width="41%" class="bg-grey-img"><span class="heading-grey"><?php echo $artifactHeading;?></span></td>
									<td width="26%" class="bg-grey-img"><span class="heading-grey">Created By</span> </td>
									<td width="21%" class="bg-grey-img"><span class="heading-grey">Date Created</span></td>
								</tr>
								<?php
								$k = 1;						 
								foreach($artifacts as $treeId=>$arrVal)
								{
									$userDetails	= $this->document_db_manager->getUserDetailsByUserId($arrVal['userId']);
									
									?>			
									<tr id="row1">
										<td align="center" class="bg-white"><?php echo $k;?></td>
										<td class="bg-white"><a href="<?php echo base_url();?><?php printf($artifactFormat, $treeId);?>" class="blue-link-underline"><?php echo $arrVal['name'];?> </a></td>
										<td class="bg-white"><?php echo $userDetails['userTagName'];?></td>
										<td class="bg-white"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], 'm-d-Y h:i A');?></td>
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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="blue-border">                  
  <tr>
	<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr align="center">
		  <td width="100%" align="left" valign="top" class="bg-light-blue-txt-white">
			<?php 
			echo 'Actions on '.$dispDate;		
			
		?></td>
	    </tr>
		<tr align="left">
		  <td valign="top" class="style1">
			
			<table width="98%"  border="0">
           
			<?php
			if(count($arrTags) > 0)
			{
				foreach($arrTags as $tags)
				{	
					foreach($tags as $tagData)
					{	
						
						$ownerDetails	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['ownerId'] );
						$userDetails 	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['userId'] );
						$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
						if(count($tagLink) > 0)
						{	
						?>	
						<tr>
							<td valign="top" class="bg-light-grey">		
								<a href="<?php echo base_url().$tagLink[0];?>" class="blue-link-underline"> 
								<?php 
								echo $tagLink[1];								
								if(trim($tagData['comments']) != '')
								{	
									echo ' - '.$tagData['comments'];
								}
								?></a>
							</td>
						</tr>           
						<?php
						}
					}
				}
			}
			else
			{
			?>
            <tr>
              <td>No actions</td>
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