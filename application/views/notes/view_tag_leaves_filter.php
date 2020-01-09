<?php 

$tagId = $this->uri->segment(8);
$nodeId = $this->uri->segment(9);
$tagType = $this->uri->segment(11);

if($tagId || $nodeId)
{
	
				if ($nodeId == $treeId)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';
			
		if (!empty($nodeBgColor))
		{										
?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="<?php echo $nodeBgColor;?>">
            <td id="<?php echo $position++;?>" class="handCursor"><?php //echo stripslashes($arrDiscussionDetails['name']); 
                        echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($treeDetail['name'],250,1).'</a>';
                    
            ?>
		    <br></td>
      		</tr>
          </table>
    <?php
		}
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php
	$totalNodes = array();
	$nodeBgColor = '';
	if(count($Contactdetail) > 0)
	{		//print_r($arrDiscussions);					 
		foreach($Contactdetail as $keyVal=>$arrVal)
		{
			//echo "<li>nodeId= " .$arrVal['nodeId'];
			//print_r ($arrVal);
			$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);
			
			//print_r ($attachedTags);
			$count = 0;
			foreach($attachedTags  as $key => $arrTagData)
			{																	
				foreach($arrTagData  as $key1 => $tagData)
				{	
					// 2= simple tags
					// 3 = response tags
					// 5= contact tags
					if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag
					{
						//if ($tagData['tagId'] == $this->uri->segment(10))
							//$count++;		
						$tagComment = $this->tag_db_manager->getTagCommentByTagId($this->uri->segment(10));
						if ($tagData['comments']==$tagComment)
							$count++;					
					}
					else if ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag
					{	
							$count++;
					}
				}
			}		
			
				if ($count != 0)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';				
			//echo "<li>nodeBgColor= " .$nodeBgColor;
			//print_r ($attachedTags);	
			
			$totalNodes[] = $arrVal['nodeId'];
		?>
          <tr>
        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="2" cellpadding="2">
            <?php
			if (!empty($nodeBgColor))
			{
			?>
            <tr class="<?php echo $nodeBgColor;?>">
              <td colspan="3" id="<?php echo $position++;?>" class="handCursor"><?php 
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);

					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);		

					?>
                <?php
					echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';

					?>
                <br></td>
            </tr>
            <?php
			}
            ?>
          </table></td>
      </tr>
          <?php
		}
	}
	 
?>
        </table>
  </div>
      <?php
}
?>