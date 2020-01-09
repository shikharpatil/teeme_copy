<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php


$viewTags2 = array(); 
$viewTags2 = $this->tag_db_manager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);	
	
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

?>
<script>

function validateTagUpdate ()
{
	if (document.getElementById('searchTags').value=='')
	{
		jAlert ('<?php echo $this->lang->line('select_tags_update'); ?>');
		return false;
	}
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" >
  <tr>
    <td colspan="2">
		<!--<form name="frmTagContact0" method="post" action="<?php echo base_url();?>create_tag1">-->
		<form name="frmTagContact0" method="post">
        <input type="hidden" id="treeId123" name="treeId123" value="<?php echo $treeId; ?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
          <tr>
            <td width="20%"><?php echo $this->lang->line('txt_Search_Tags');?>: </td>
            <td><input type="text" id="searchTagsContact" name="searchTagsContact" onkeyup="search_contact_tags_contact()" size="46"/></td>
          </tr>
          <tr>
            <td valign="top" width="20%"><?php echo $this->lang->line('txt_Tag_List');?>: </td>
            <td><div id="divshowTagsContact" style="display:block;width: 300px; height: 240px; overflow: scroll; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
                <?php
			$count = '';
			$sectionChecked = '';
			foreach($viewTags2 as $tagData)	
			{
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			?>
                <input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/>
                <span <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'class="clsCheckedTags"';}?>  ><?php echo $tagData['tagType'];?></span><br />
                <?php
				}
        	}
			foreach($viewTags2 as $tagData)	
			{
				if (!in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
					$sectionChecked .= ',' .$tagData['tagTypeId'];
 				} 
			?>
                <input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/>
                <span <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'class="clsCheckedTags"';}?>  ><?php echo $tagData['tagType'];?></span><br />
                <?php
				}
        	}
        	?>
              </div>
              <br />
              <input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Apply');?>" class="button01" onclick="submit_tags_form_ajax()" />
              <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
              <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
              <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
              <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
              <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
              <input type="hidden" id="workSpaceId" name="workSpaceId" value="<?php echo $workSpaceId;?>">
              <input type="hidden" id="workSpaceType" name="workSpaceType" value="<?php echo $workSpaceType;?>">
              <input type="hidden" id="tagOption" name="tagOption" value="<?php echo $tagOption;?>">
              <input type="hidden" id="sectionTagIds" name="sectionTagIds" value="<?php echo trim($count);?>">
              <input type="hidden" id="sectionChecked" name="sectionChecked" value="<?php echo $sectionChecked;?>">
              <input type="hidden" id="appliedTags" name="appliedTags" value="<?php echo $appliedTags;?>">
              <input type="hidden" id="addOption" name="addOption" value="update">
              <input type="hidden" id="countAppliedTags1" name="countAppliedTags1" value="<?php echo count($appliedTagIds);?>">
			  <div class="contactTagLoader" id="contactTagLoader"></div>	
			  </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
