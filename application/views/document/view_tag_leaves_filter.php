<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

$tagId = $_GET['tagId'];
$tagResponseId = $_GET['tagResponseId'];
$nodeId = $_GET['node'];
$tagType = $_GET['tagType'];
$usr = $_GET['usr'];

if(!isset($_GET['tagResponseId']))unset($_SESSION['tagLeaves']);

if(array_key_exists($tagResponseId,$_SESSION['tagLeaves'])){
	if(isset($_GET['rem']) && $_GET['rem']==1){
		unset($_SESSION['tagLeaves'][$tagResponseId]);
	}
}
else if(!isset($_GET['rem']) || $_GET['rem']!=1){
	$_SESSION['tagLeaves'][$tagResponseId][0] = $tagId;
	$_SESSION['tagLeaves'][$tagResponseId][1] = $nodeId;
	$_SESSION['tagLeaves'][$tagResponseId][2] = $tagType;
}

if($usr!='' && !$_GET['remUsr']){
	$_SESSION['usrLeaves'][$usr]=$usr; 
}

if(isset($_GET['remUsr']) && $_GET['remUsr']!=0){
	unset($_SESSION['usrLeaves'][$usr]);
}


$nd = 0;
$countTags = count($_SESSION['tagLeaves']);

foreach($_SESSION['tagLeaves'] as $key=>$val){
	
	$tagId = $val[0];
	$tagResponseId = $key;
	$nodeId = $val[1];
	$tagType = $val[2];

	if($tagId || $nodeId)
	{
		if ($nodeId == $treeId){
			$nodeBgColor = 'seedBgColor';
			$nd++;
		}
		else{
			$nodeBgColor = '';
		}

		if (!empty($nodeBgColor) && $nd==$countTags)
		{
			if($nd==0){
				$nd++;	
			}
			if(!empty($_SESSION['usrLeaves']) && (in_array($arrDocumentDetails['userId'],$_SESSION['usrLeaves'])) || empty($_SESSION['usrLeaves'])){
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="<?php echo $nodeBgColor;?>">
    <td id="<?php echo $position++;?>" class="handCursor" style="padding:10px;"><?php 
                    echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'.strip_tags($this->identity_db_manager->formatContent($arrDocumentDetails['name'],250,1)).'</a>';
                ?>
      <br></td>
  </tr>
</table>
<?php
			}
		}
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
		$totalNodes = array();
		$nodeBgColor = '';

		if(count($documentDetails) > 0)
		{	
			foreach($documentDetails as $keyVal=>$arrVal)
			{
				if((!empty($_SESSION['usrLeaves']) && in_array($arrVal['userId'],$_SESSION['usrLeaves'])) || !$_SESSION['usrLeaves']){
					
				$attachedTags = $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);

				$count = 0;
				foreach($attachedTags  as $key => $arrTagData)
				{	
					// 2= simple tags
					// 3 = response tags
					// 5= contact tags															
					foreach($arrTagData  as $key1 => $tagData)
					{	
						if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag
						{
							$tagComment = $this->tag_db_manager->getTagCommentByTagId($tagResponseId);
							if ($tagData['comments']==$tagComment)
								$count++;					
						}
						else if ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag
							$count++;
					}
				}	

				if ($count != 0)
					$nodeBgColor = 'seedBgColor';
				else
					$nodeBgColor = '';				
	
				
				$totalNodes[] = $arrVal['nodeId'];
	
			?>
<tr>
  <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <?php
				if (!empty($nodeBgColor))
				{?>
      <tr class="<?php echo $nodeBgColor;?>">
        <td colspan="3" id="<?php echo $position++;?>" class="handCursor" style="padding:10px;"><?php 
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
						echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrVal["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'.strip_tags($this->identity_db_manager->formatContent($arrVal['contents'],250)).'</a>';
						?>
          <br></td>
      </tr>
      <?php
				}
				?>
    </table>
    <div style="padding-left:20px;">
      <?php
				$_SESSION['succ'] = 0;
				$checkSuccessor =  $this->document_db_manager->getSuccessors($arrVal['nodeId']);
	
			if ($checkSuccessor != 0)
			{
				$sArray=array();
				$sArray=explode(',',$checkSuccessor);
				$counter=0;
				while($counter < count($sArray))
				{
					$arrDocuments	= $this->document_db_manager->getPerentInfo($sArray[$counter]);
					$totalNodes[] = $arrDocuments['nodeId'];	 
	
					$userDetails	= $this->document_db_manager->getUserDetailsByUserId($arrDocuments['userId']);
					$checksucc 		= $this->document_db_manager->checkSuccessors($arrDocuments['nodeId']);				

	
					$attachedTags2 	= $this->tag_db_manager->getLeafTagsByLeafIds($arrDocuments['nodeId'], 2);

					$count = 0;
					foreach($attachedTags2  as $key => $arrTagData)
					{																	
						foreach($arrTagData  as $key1 => $tagData)
						{	
							// 2= simple tags
							// 3 = response tags
							// 5= contact tags
							if ($tagData['tagTypeId']==3 && $tagData['tagTypeId']==$tagType) // if response tag
							{
								$tagComment = $this->tag_db_manager->getTagCommentByTagId($tagResponseId);
								if ($tagData['comments']==$tagComment)
									$count++;					
							}
							else if ($tagData['tag'] == $tagId && $tagData['tagTypeId']==$tagType) // if simple or contact tag
								$count++;

						}
					}	
						if ($count != 0)
							$nodeBgColor = 'seedBgColor';
						else
							$nodeBgColor = '';	
					?>
      
        <tr>
          <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
              <?php
				if (!empty($nodeBgColor))
				{
				?>
              <tr class="<?php echo $nodeBgColor; ?>">
                <td id="<?php echo $position++;?>" colspan="3" class="handCursor" style="padding:10px;"><?php
						$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDocuments['nodeId'], 2);
						$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDocuments['nodeId'], 2);
						$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDocuments['nodeId'], 2);
						$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDocuments['nodeId'], 2);
					
						$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 1, 2);
						$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 2, 2);
						$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 3, 2);
						$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 4, 2);
						$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 5, 2);
						$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDocuments['nodeId'], 6, 2);
						$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDocuments['nodeId'], 2);		
						?>
                  <?php 
							echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrDocuments["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'.strip_tags($this->identity_db_manager->formatContent($arrDocuments['contents'],250)).'</a>';
						
						?>
                  <br></td>
              </tr>
              <?php
				}
				?>
            </table></td>
        </tr>
        <?php
					$counter++;
				}			
			}		
			?>
    </div></td>
</tr>
<?php
			
				}
			}
		}
		 
	?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
</div>
<?php
	}
}


if(!empty($_SESSION['usrLeaves']) && !$tagId && !$nodeId){
	
	$nodeId = $_GET['nodeId'];
	if(in_array($arrDocumentDetails['userId'],$_SESSION['usrLeaves']))
	{?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="seedBgColor">
    <td id="" colspan="5" class="handCursor" style="padding:10px;"><?php 
                    echo '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=1 " style="text-decoration:none; color:#000;">'.strip_tags($this->identity_db_manager->formatContent($arrDocumentDetails['name'],250,1)).'</a>';
                ?>
      <br></td>
  </tr>
</table>
<?php
	}
	foreach($documentDetails as $keyVal=>$arrVal){
	
		if(in_array($arrVal['userId'],$_SESSION['usrLeaves'])){
		?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="seedBgColor">
    <td id="<?php echo $position++;?>" colspan="5" class="handCursor" style="padding:10px;"><?php
		echo '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=1" style="text-decoration:none; color:#000;">'.strip_tags($this->identity_db_manager->formatContent($arrVal['contents'],250)).'</a>';?>
      <br /></td>
  </tr>
</table>
<?php
		}
	}
}
?>
