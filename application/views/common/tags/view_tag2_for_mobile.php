<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
$viewTags = $this->tag_db_manager->getTagsByCategoryId(2);
$viewTags2 = $this->tag_db_manager->getTagsByCategoryId2(2);
$appliedTagIds = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTagIds[] = $tagData['tag'];
	}
}
$allTags = array();
$allTags = array_merge ($tags,$viewTags2);
$appliedTags = implode(',',$appliedTagIds);

$managerIds = array();
foreach($workSpaceManagers as $managersData)
{
	$managerIds[] = $managersData['managerId'];
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" >
<tr>
	<td colspan="2">
    	<form name="frmTag0" id="frmTag0" method="post" >

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
<tr>
	<td width="40%">
		Search Tags: 
   	</td>
</tr>
<tr>
    <td> 
    <input type="text" id="searchTags" name="searchTags" onkeyup="showTagsAjax()" size="20"/>
   
    </td>
</tr>
<tr>
	<td valign="top" width="40%">
    	<?php echo $this->lang->line('txt_Tag_List');?>:
    </td>
</tr>
<tr>
    <td>
		<div id="showTagsSimple" style="height:150px;display:block;overflow: scroll; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
			<?php
			$count = '';
			$sectionChecked = '';
			foreach($viewTags2 as $tagData)	
			{
				if (in_array($tagData['tag'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tag'];
				
				if (in_array($tagData['tag'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tag'];
 				} 
			?>
				<div style="width:95%;float:left;">
				<input type="checkbox"   name="unAppliedTags" class="chek <?php echo ($tagData['systemTag']==1)?"colorTags":"";?>" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><span class="<?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'clsCheckedTags';}?> <?php echo ($tagData['systemTag']==1)?"italics":"";?>" ><?php echo ($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];?></span></div>

			<?php
				}
        	}
			
			foreach($viewTags2 as $tagData)	
			{
				if (!in_array($tagData['tag'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tag'];
				
				if (in_array($tagData['tag'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tag'];
 				} 
			?>
				<div style="width:95%;float:left;">
				<input type="checkbox" name="unAppliedTags" class="<?php echo ($tagData['systemTag']==1)?"colorTags":"";?>" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><span class="<?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'clsCheckedTags';}?>  <?php echo ($tagData['systemTag']==1)?"italics":"";?>" ><?php echo ($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];?></span></div>

			<?php
				}
        	}
        	?>
            <div style="clear:both;"></div>
		</div>
			<br />
			
			<input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Apply');?>" onclick="submitAppliedTags()" class="button01"/>
			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden"  name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden"  name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden"  name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
			<input type="hidden"  name="treeId" id="treeId" value="<?php echo $treeId;?>">		
			<input type="hidden"  name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" id="workSpaceId" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" id="workSpaceType" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" id="tagOption" name="tagOption" value="<?php echo $tagOption;?>">	
            <input type="hidden" id="sectionTagIds" name="sectionTagIds" value="<?php echo $count;?>">
            <input type="hidden" id="sectionChecked" name="sectionChecked" value="<?php echo $sectionChecked;?>">
            <input type="hidden" id="appliedTags" name="appliedTags" value="<?php echo $appliedTags;?>">
			<input type="hidden" id="countAppliedTags1" name="countAppliedTags1" value="<?php echo count($appliedTagIds);?>">			
			<input type="hidden" name="addOption" id="addOption" value="update">
			<div class="simpleTagLoader" id="simpleTagLoader"></div>	

	</td>
</tr>
</table>
</form>
    </td>
</tr>

<?php  if((in_array($_SESSION['userId'],$managerIds))){ ?>
<tr>
	<td width="20%">
    	<?php echo $this->lang->line('txt_New_Tag');?>:
    </td>
 </tr>
 <tr>
	<td valign="top">	
            <?php /*?>action="<?php echo base_url();?>create_tag1"<?php */?>
    		<form name="frmTag2" method="post" onSubmit="return false" >

	<input name="tag" type="text" id="tag"  style="margin-top:0px;"  maxlength="255">
	<div>
    <input name="confirm" type="button"  onclick="createSimpleTag()" value="<?php echo $this->lang->line('txt_Create');?>" class="button01"/>
    <input type="button" id="cancelTagButton" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="document.getElementById('tag').value='';" />
	</div>

		
		
	  		

		


			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">		
			<input type="hidden" name="addOption" value="new">	
					
			</form>

    </td>
</tr>
<?php } ?>

</table>
		
<script>
//code to prevent selection of multiple color (system) tags - Monika
$('.colorTags').click(function(){
	$('.colorTags').prop('checked',false);
		if($(this).hasClass('chek1')==true){
			$(this).removeClass('chek1');
			$(this).removeAttr('checked');
		}
		else{
			$('.colorTags').removeClass('chek1');
			$(this).prop('checked','true');
			$(this).addClass('chek1');
		}
});
</script>