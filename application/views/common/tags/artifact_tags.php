<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$timeTags 	= $this->tag_db_manager->getTags(1, $_SESSION['userId'], $artifactId, $artifactType);
$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);
$createTags	= $this->tag_db_manager->getTags(4, $_SESSION['userId'], $artifactId, $artifactType);
$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $artifactId, $artifactType);
$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $artifactId, $artifactType);
$dispTags	= '';	
?>
<table width="100%">	
	
	<tr><td>					
		<?php	
		$tagAvlStatus = 0;				
		if(count($timeTags) > 0)
		{
			$tagAvlStatus = 1;
			$dispTags = '';			
			foreach($timeTags as $tagData)
			{
				if (empty($dispTags))
					$dispTags = $tagData['tagName'];	
				else											
					$dispTags .= ', ' .$tagData['tagName'];						 
			}
		}
		if(count($viewTags) > 0)
		{
			$tagAvlStatus = 1;	
			$dispTags .= $this->lang->line('txt_Simple_Tags') .": ";
			$count = 0 ;
			foreach($viewTags as $tagData)
			{													
				if ($count==0)
					$dispTags .= $tagData['tagName'];			
				else											
					$dispTags .= ', ' .$tagData['tagName'];		
					
				$count++;			 
			}
			$dispTags .= "<br><br>";
		}	
		if(count($createTags) > 0)
		{
			$tagAvlStatus = 1;	
			foreach($createTags as $tagData)
			{
				$taskId = 0;
				if($tagData['tag'] == 17)
				{
					$date   = date('Y-m-d');
					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
				}
				else if($tagData['tag'] == 18)
				{			
					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));
					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
				}
				else if($tagData['tag'] == 19)
				{
					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));
					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
				}
				else if($tagData['tag'] == 20)
				{
					$date   = date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);
				}
				else if($tagData['tag'] == 0)
				{
					$taskCreateDate   = $this->tag_db_manager->getTaskCreateTagByTagId($tagData['tagId']);
					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$taskCreateDate);
				}
				if($taskId == 0)
				{
					$url = base_url().'Notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['tagId'].'/'.$tagData['comments'].'/'.$tagData['ownerId'].'/'.$tagData['tag'];
				}
				elseif($taskId > 0)
				{
					$url = base_url().'Notes/Details/'.$taskId.'/'.$workSpaceId.'/type/'.$workSpaceType;
				}
				if($tagData['tag'] == 0)
				{
					$arrTaskDate = explode('-', $taskCreateDate);	
					$taskDate = date('Y-m-d', mktime(0,0,0,$arrTaskDate[1],$arrTaskDate[2],$arrTaskDate[0]));
					$curDate  = date('Y-m-d');
					if($taskDate <= $curDate)
					{								
						$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';
					}										
				}
				else
				{
					$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';			
				}									
			}
		}

		if(count($userTags) > 0)
		{
			$tagAvlStatus = 1;	
			foreach($userTags as $tagData)
			{
				$dispTags .= $tagData['userTagName'].', ';						
			}
		}
		if(count($actTags) > 0)
		{

					$tagAvlStatus = 1;	
					$dispTags .= $this->lang->line('txt_Response_Tags') .": ";
					$count = 0;
					foreach($actTags as $tagData)
					{
						if ($count==0)
							$dispTags .= $tagData['comments'].' [';	
						else
							$dispTags .= ', ' .$tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
						
							if ($tagData['tag']==1)
								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',2,'.$nodeOrder.')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',2,'.$nodeOrder.')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',2,'.$nodeOrder.')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',2,'.$nodeOrder.')">'.$this->lang->line('txt_Authorize').'</a>,  ';					
							
						}
						$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',3,'.$nodeOrder.')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispTags .= ']';
					
						$count++;
					}
					$dispTags .= "<br><br>";
		}
		if(count($contactTags) > 0)
		{
			$tagAvlStatus = 1;	
			$dispTags .= $this->lang->line('txt_Contact_Tags') .": ";
			foreach($contactTags as $tagData)
			{
				$dispTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
			}
			
		}
		echo substr($dispTags, 0, strlen( $dispTags )-2);		
		?>
		</td></tr>
		<?php					
		if($tagAvlStatus == 0)
		{
		?>			
			<tr><td><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td></tr>	
		<?php
		}
		?>		

			
</table>
