<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<?php

if ($value)
{			
	$strContents	= '';
	$totalRows  	= 0;
	$arrNodeOrder	= array();
	// Get information of particular document
	$allLeafIds = '';
	$allnodesOrders='';
	$i = 1;
	$vk=0;		
	$o=0;
	//echo "here"; exit;
	//echo stripslashes($leafData['contents']);
	foreach ($value as $leafData)
	{		
		//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafData['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafData['treeIds'], $leafData['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafData['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);	
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
		//Code end		
		if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
		{
		if(($leafData['nodeId1'] == $this->input->get('node')) || ($leafData['leafId1'] == $leafData['leafId']  && $leafData['successors'] == '0' && !in_array($leafData['nodeOrder'], $arrNodeOrder)))
		{
		
			//echo "<li>nodeid= " .$leafData['contents'];
	
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData['leafId']);
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
			
			$arrNodeOrder[] = $leafData->nodeOrder;				
			$allLeafIds = $allLeafIds.$leafData['leafId1'].',';
			$allnodesOrders.=$leafData->nodeOrder.',';
			
			
			if($viewOption == 'htmlView')
			{	
				//echo "<li>NodeId= " .$leafData['nodeId1'];				
				$xdoc 			= new DomDocument('1.0', 'iso-8859-1');
				$tmpText		= str_replace('<o:p>','',$leafData['contents']);
				$tmpText		= str_replace('</o:p>','',$tmpText);	
				$tmpText		= str_replace('<p><TABLE','<TABLE',$tmpText);
				$tmpText		= str_replace('</TABLE></p>','</TABLE>',$tmpText);
				$tmpText		= str_replace('</TABLE></p>','</TABLE>',$tmpText);
				
				$strData		= '<div id="'.$leafData->tag.'">'.htmlspecialchars_decode($tmpText).'</div>';
				$strData		= str_replace('&gt;','',$strData);	
				$strData		= str_replace('&lt;','',$strData);
				$xml 			= $xdoc->loadHTML($strData);
			
				$plainText		= $xdoc->getElementsByTagName('div')->item(0)->nodeValue;						
				$nodeVal  		= substr($xdoc->getElementsByTagName('div')->item(0)->nodeValue, 0, 700);
				?>

<input type="hidden" id="hiddenId<?php echo $leafData->nodeOrder;?>" value="<?php echo $nodeVal;?>">
<?php							
				$vk = $vk+2;
				$editFocus = $vk;
				$vk = $vk+1;
				$addFocus = $vk;					
				?>
<span id="leaf_start<?php echo $leafData['leafId1'];?>"> <span id="leafContent<?php echo $leafData['nodeOrder'];?>" align="left" class="handCursor">
<?php
                $nodeBgColor = '';		
				if(in_array($leafData['nodeId1'], $arrNodeIds))
				{
					$nodeBgColor = ($i%2)?'row1':'row2';
				}
				if (!empty($nodeBgColor))
				{
					//echo "<li>content= " .$leafData['contents'];
					$nodeBgColor = ($i%2)?'row1':'row2';
					$o++;
				?>
<div class="<?php echo $nodeBgColor;?> views_div">

					<a style="text-decoration:none; color:#000;max-width:95%;float:left;" href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&node=<?php echo $leafData['nodeId1'];?>#docLeafContent<?php echo $leafData['nodeId1'];?>"><?php /*echo $this->identity_db_manager->formatContent($leafData['contents'],1000,1);*/ echo stripslashes($leafData['contents']); ?></a>
			
  <?php	
						//echo '<a href=view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$leafData['nodeId1'].' style="text-decoration:none; color:#000;max-width:95%;float:left;">'.$this->identity_db_manager->formatContent($leafData['contents'],1000,1).'</a>';	
					
					echo  "<div class='userLabel'>".$leafData['tagName']."&nbsp;&nbsp;";
					
					
					echo $this->time_manager->getUserTimeFromGMTTime($leafData['orderingDate'], $this->config->item('date_format'))."</div><div class='clr'></div>";
						
			?>
</div>
<?php
				}
		?>
</span>
<input name="initialleafcontent<?php echo $leafData->nodeOrder;?>" id="initialleafcontent<?php echo $leafData->nodeOrder;?>" value="<?php echo htmlspecialchars($leafData->contents);?>" type="hidden" />
</span>
<?php						
			}				
			$i++;
		
		}
		}		
	}
	$allLeafIds = substr($allLeafIds,0,strlen($allLeafIds)-1);
	$allnodesOrders = substr($allnodesOrders,0,strlen($allnodesOrders)-1);
	?>
<input type="hidden" id="allLeafs" value="<?php echo $allLeafIds;?>">
<input type="hidden" id="allnodesOrders" value="<?php echo $allnodesOrders;?>">
<?php	 
}
?>
