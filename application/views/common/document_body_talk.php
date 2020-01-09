<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php

if ($value)
{			
	$strContents	= '';
	$totalRows  	= 0;
	$arrNodeOrder	= array();
	// Get information of particular document
	$allLeafIds = '';
	$allnodesOrders='';
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	$i = 1;
	$vk=0;	

	foreach ($value as $leafData)
	{	
			
		if(($leafData->nodeId1 == $this->input->get('node')) || ($leafData->leafId1 == $leafData->leafId  && $leafData->successors == '0' && !in_array($leafData->nodeOrder, $arrNodeOrder)))
		{

			$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($leafData->treeIds);
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId);
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
			$arrNodeOrder[] = $leafData->nodeOrder;				
			$allLeafIds = $allLeafIds.$leafData->leafId1.',';
			$allnodesOrders.=$leafData->nodeOrder.',';
								
										
				$vk = $vk+2;
				$editFocus = $vk;
				$vk = $vk+1;
				$addFocus = $vk;					

					if ($leafData->nodeId1 == $this->input->get('node'))
						$nodeBgColor = 'nodeBgColorSelect';
					else
					{
						$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;	
					}
				?>
<div id="leaf_start<?php echo $leafData->leafId1;?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; padding:10px;">	                
	<span id="leafContent<?php echo $leafData->nodeOrder;?>" align="left" onclick="showLeafOptions(<?php echo $leafData->leafId1;?>,<?php echo $leafData->nodeOrder;?>,<?php echo $treeId.','.$leafData->nodeId1;?>);" onDblClick="editLeaf(<?php echo $leafData->leafId1;?>,<?php echo $leafData->nodeOrder;?>,<?php echo $treeId.','.$leafData->nodeId1;?>)" >
		
				
			<?php			
					
			if (!empty($leafTreeId) && ($isTalkActive==1))
			{ 
			
			?>
			 
			   <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; margin-bottom:2px;" class="nodeBgColorSelect">
				<?php	
				
				echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') " ><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>';
				
				echo stripslashes($leafData->contents);	
			 ?>
			  </div>
			 <?php 	
			}
			?>
            
           
					
       
	</span>
	

	
			
			<?php	/* Tags */
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>

									
				<?php	
				#*********************************************** Tags ********************************************************?>
</div>
				
                
				
               
              
                
               
	<?php	
		$i++;	
		}		
	}
	
	?>
    
	<?php 
}
?>