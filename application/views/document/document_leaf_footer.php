<!-- leaf document footer start -->
<div class="documentSeedFooter">
	<!-- footer left content start -->
	<div class="documentSeedFooterLeft">
        <?php 
		if(($latestVersion == 1 && $leafData->successors == 0) || $prevPulishedLeafStatus==1 )
		{
		?>
        	<!--/*Updated by Surbhi IV for checking version */--> 
			<!--Manoj: Added contributor condition-->
          	<span style="float:left;">&nbsp;&nbsp;<a style="margin-right:8px;" href="javascript:void(0)" <?php if (in_array($_SESSION['userId'],$contributorsUserId)) {echo 'class="disblock3"';}else { echo 'class="disnone2"';} ?> onClick="addLeafNew(<?php echo $leafData->leafId1; ?>,<?php echo $treeId ;?>,<?php echo  $leafData->nodeOrder ; ?>,'<?php echo $arrDocumentDetails["version"]; ?>')">
          		<img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ></a>
          	</span> 
          	<!--/*End of Updated by Surbhi IV for checking version */-->
        <?php 
		}
		?>
		<?php 
		if($latestVersion == 1 && $leafData->successors == 0 )
		{
		?>
        	<span id="editDocumentOption<?php echo $leafData->nodeId1; ?>" class="editDocumentOption <?php if (1==1) {echo "disblock2" ;}else { echo "disnone2" ; } ?> "  style="float: left; margin-left: 0%"> 

			  	<?php 
			  	if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $draftResUserIds) || ($leafData->leafStatus != 'draft' && count($draftResUserIds)==0))) 
			  	{
					$displayClass = 'disblock3';
			  	}
			 	else 
			  	{ 
					$displayClass = 'disnone2';
			  	} 
		  	
			  	$latestLeafClass = '';
			  	if($leafData->successors==0)
			  	{
			  		$latestLeafClass = 'latestLeafShow';
			  	}
			  	?>
          		<span>
          			<a  style="float: left; margin-left: 8px;" class="<?php echo $displayClass.' '.$latestLeafClass; ?>" id="docEditBtn<?php echo $leafData->nodeId1; ?>" href="javascript:void(0)" onClick="editLeaf(<?php echo $leafData->leafId1; ?>,<?php echo  $leafData->nodeOrder ; ?>,<?php echo $treeId ;?>,<?php echo $leafData->nodeId1;?>,'<?php echo $arrDocumentDetails["version"]; ?>','<?php echo $leafData->leafStatus; ?>','<?php echo $leafParentData['parentLeafId']; ?>')" title="<?php echo $this->lang->line('txt_Edit_this_idea'); ?>" >
          				<img src="<?php echo  base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_Edit"); ?>" title="<?php echo $this->lang->line("txt_Edit"); ?>" border="0">
          			</a>
          		</span> 
          		<!--/*End of Updated by Surbhi IV for checking version */--> 
        	</span>
        <?php
		}
		?>
	</div>
	<!-- footer left content end -->

	<!-- footer right content start -->
	<div class="documentSeedFooterRight">

	</div>
	<!-- footer right content end -->
</div>
<!-- leaf document footer end -->