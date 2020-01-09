<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
$timeTags 	= $this->tag_db_manager->getWorkspaceTags(1, $_SESSION['userId'], $workSpaceId);
$viewTags 	= $this->tag_db_manager->getWorkspaceTags(2, $_SESSION['userId'], $workSpaceId);
$actTags 	= $this->tag_db_manager->getWorkspaceTags(3, $_SESSION['userId'], $workSpaceId);
$createTags	= $this->tag_db_manager->getWorkspaceTags(4, $_SESSION['userId'], $workSpaceId);
$contactTags= $this->tag_db_manager->getWorkspaceTags(5, $_SESSION['userId'], $workSpaceId);
$userTags	= $this->tag_db_manager->getWorkspaceTags(6, $_SESSION['userId'], $workSpaceId);
$dispTags	= '';	
?>
<table width="100%">	
	<tr><td><hr></td></tr>
	<tr><td>					
		<?php	
		$tagAvlStatus = 0;				
		if(count($timeTags) > 0)
		{
			$tagAvlStatus = 1;			
			foreach($timeTags as $tagData)
			{													
				$dispTags .= $tagData['tagName'].', ';						 
			}
		}
		if(count($viewTags) > 0)
		{
			$tagAvlStatus = 1;	
			foreach($viewTags as $tagData)
			{													
				$dispTags .= $tagData['tagName'].', ';						 
			}
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
		if(count($contactTags) > 0)
		{
			$tagAvlStatus = 1;	
			foreach($contactTags as $tagData)
			{
				$dispTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
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
			foreach($actTags as $tagData)
			{
				$dispTags .= $tagData['comments'].' [';							
				$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
				if(!$response)
				{
					$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeId.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',2)">'.$this->lang->line('txt_Act').'</a>,  ';						
				}
				if($tagData['ownerId'] == $_SESSION['userId'])
				{	
					$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeId.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';					
				}
				else if($tagData['tag'] == 2)
				{		
					$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeId.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';											
				}
				else if($tagData['tag'] == 3)
				{		
					$dispTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$nodeId.','.$workSpaceId.','.$workSpaceType.','.$artifactId.','.$artifactType.','.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';						
				}
				$dispTags .= '], ';
			}
		}
		echo substr($dispTags, 0, strlen( $dispTags )-2);		
		?>
		</td></tr>
		<?php					
		if($tagAvlStatus == 0)
		{
		?>			
			<tr><tr><td><?php echo $this->lang->line('msg_tags_not_available');?></td></tr>	
		<?php
		}
		?>		
		<tr>
			<td align="right"><a href="javascript:void(0)" onClick="hideTagView(<?php echo $nodeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $artifactId;?>,<?php echo $artifactType;?>)"><?php echo $this->lang->line('txt_Done');?></a> &nbsp;&nbsp; <a href="javascript:void(0)" onClick="showNewTag(<?php echo $nodeId; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $artifactId; ?>,<?php echo $artifactType;?>,0,1)"><?php echo $this->lang->line('txt_New');?></a></td>
		</tr>		
</table>