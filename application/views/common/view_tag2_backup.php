<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
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

//print_r ($allTags); exit;

//echo "<li>countTags= " .count($tags);
//echo "<li>countViewTags= " .count($viewTags2);
//echo "<li>countAllTags= " .count($allTags);


?>
<script>
function showTags()
{
	var toMatch = document.getElementById('searchTags').value;
	var val = '';
	
		if (toMatch!='')
		{
		var count = '';
		var sectionChecked = '';
		<?php

		foreach($viewTags2 as $tagData)	
		{
		?>
			var str = '<?php echo $tagData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			
			
			if (str.match(pattern))
			{
			
				count = count + ','+<?php echo $tagData['tag']; ?>;
				
				<?php if (in_array($tagData['tag'],$appliedTagIds)) { ?>
				sectionChecked = sectionChecked + ','+<?php echo $tagData['tag']; ?>;
				<?php } ?>
				
				val +=  '<input type="checkbox" name="unAppliedTags[]" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagName'];?>&nbsp;&nbsp;';
				document.getElementById('showTags').innerHTML = val;
				
				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');
			}
        
		<?php
        }
        ?>
			if (count!='')
			{
				document.getElementById('sectionTagIds').value = count;
			}
			if (sectionChecked!='')
			{
				document.getElementById('sectionChecked').value = sectionChecked;
			}
			//alert (document.getElementById('sectionTagIds').value );
			document.getElementById('showTags').style.display = 'block';
		}
		else
		{
			document.getElementById('showTags').style.display = 'none';
		}

}
function validateTagUpdate ()
{
	if (document.getElementById('searchTags').value=='')
	{
		jAlert ('<?php echo $this->lang->line('select_tags_update'); ?>');
		return false;
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
<tr>
<td>
	<form name="frmTag0" method="post" action="<?php echo base_url();?>create_tag1" onsubmit="return validateTagUpdate();">

	Search Tags: <input type="text" id="searchTags" name="searchTags" onkeyup="showTags()"/>
    <input id="confirm" name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Update');?>"/></li>
	<div id="showTags" style="display:none;width: 650px; height: 50px; overflow:scroll; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">

	</div>
		
			

			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">	
            <input type="hidden" id="sectionTagIds" name="sectionTagIds" value="0">
            <input type="hidden" id="sectionChecked" name="sectionChecked" value="0">
            <input type="hidden" name="appliedTags" value="<?php echo $appliedTags;?>">			
			<input type="hidden" name="addOption" value="update">	
	</form>
</td>
</tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">

<tr>
	<td>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
	<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()">

	<?php
	$dispTags = array();
	if(count($viewTags) > 0)
	{
		$i = 0;	
		$dispTags = array();
		$dispTags2 = array();
		foreach($viewTags as $tagData)	
		{
			if(!in_array($tagData['tagTypeId'],$appliedTagIds))
			{					
				$dispTags[] = '<span style="cursor:pointer;" id="tagSpan'.$tagData['tagTypeId'].'" onClick="changeBackgroundSpan('.$tagData['tagTypeId'].')">'.$tagData['tagType'].'</span>';			
				$dispTags2[] = "<option id=tagSpan".$tagData['tagTypeId']." value=".$tagData['tagTypeId'].">".$tagData['tagType']."</option>";
			}
			$i++;		
		}
		if(count($dispTags) > 0)
		{
		?> 	
		<tr>
			<td align="left" valign="top">
            	<?php echo $this->lang->line('txt_Select_Tag');?>:<br /><br />
				<?php
				
				//echo implode(', ', $dispTags);	
				?>	
               <select name="displayTags[]" id="displayTags[]" onchange="changeBackgroundSpan(this.value)" multiple size="5">
                         <?php for($i=0;$i<count($dispTags2);$i++)
									{
										echo $dispTags2[$i];
									}
							
						?>
                </select>
				
				<input type="hidden" name="tag" id="tag" value="0">
			</td>
	  </tr>			
		<tr>
			<td>			
				<input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>"/>
                <?php
				/*
				<input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_Tag');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/>
				*/
				?>
				<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
				<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
				<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
				<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
				<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
				<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">	
				<input type="hidden" name="addOption" value="apply">					
			</td>
		</tr>
		<?php
		}
		else
		{	
		?>
        
			<tr>
				<td align="left" class="bottom-border-blue">
                <input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_Tag');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/><br /><?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
			</tr>
		<?php
		}
		?>		 
	<?php
	}
	else
	{	
	?>

		<tr>
			<td align="left" class="bottom-border-blue"><input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_Tag');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/><br /><?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
		</tr>

	<?php
	}
	?>		
</table>    	
	</td>
<td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
<?php
$appliedTags = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTags[] = $tagData['tagName'];
	}

	?>	
		<tr>

			<?php /* echo $this->lang->line('txt_Tags_Applied');?> - <?php echo implode(', ',$appliedTags); */?>
            
            <td align="left" class="bottom-border-blue">
            <?php echo $this->lang->line('txt_Tags_Applied');?>: <br /><br />
                    <select name="simpleTags[]" id="simpleTags[]" onchange="changeBackgroundSpan4(this.value)" multiple size="5">
					<?php			

						foreach($tags as $tagData)
						{													
							//$dispViewTags .= $tagData['tagName'].', ';	
							echo "<option id=tag".$tagData['tagId']." value=".$tagData['tagId'].">".$tagData['tagName']."</option>";					 
						}
		
					?>	
            		</select>

            
            </td>
		</tr> 
       	<tr>
			<td align="left" class="bottom-border-blue">                    
            	<ul class="rtabs">
					<li><a href="javascript:void(0)" onClick="removeTags()" class="current"><span><?php echo $this->lang->line('txt_Remove');?></span></a></li>
				</ul>
            </td>
		</tr>
	 <?php
	
}
else
{
?>
	<tr>
		<td align="left" class="bottom-border-blue">
			<?php echo $this->lang->line('txt_Tags_Applied');?>: <br /><br />
			<?php echo $this->lang->line('msg_tags_not_available');?>
        </td>
	</tr>
<?php
}
?>	
</table>
</td>
<td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
<?php
$appliedTags = array();
if(count($currentTags) > 0)
{
	foreach($currentTags as $tagData)
	{
		$appliedTags[] = $tagData['tagName'];
	}

	?>	
		<tr>
			<?php /* echo $this->lang->line('txt_Tags_Applied');?> - <?php echo implode(', ',$appliedTags); */?>

            <td align="left" class="bottom-border-blue">
            
            	<?php echo $this->lang->line('txt_Tags_Applied_Now');?>:<br /><br />
                    <select name="simpleTags[]" id="simpleTags[]" onchange="changeBackgroundSpan4(this.value)" multiple size="5">
					<?php			

						foreach($currentTags as $tagData)
						{													
							//$dispViewTags .= $tagData['tagName'].', ';	
							echo "<option id=tag".$tagData['tagId']." value=".$tagData['tagId'].">".$tagData['tagName']."</option>";					 
						}
		
					?>	
            		</select>

            
            </td>
		</tr> 
        <tr>
			<td align="left" class="bottom-border-blue">                    
                    <ul class="rtabs">
						<li><a href="javascript:void(0)" onClick="removeTags()" class="current"><span><?php echo $this->lang->line('txt_Remove');?></span></a></li>
					</ul>
            </td>
		</tr>
	 <?php
	
}
else
{
?>
	<tr>
		<td align="left" class="bottom-border-blue">
			<?php echo $this->lang->line('txt_Tags_Applied_Now');?>: <br /><br />
			<?php echo $this->lang->line('msg_tags_not_available');?>
        </td>
	</tr>
<?php
}
?>	
<input type="hidden" name="tagLinks" id="tagLinks" value="0">
</form>
</table>

</td>
</tr>
<tr>
<td colspan="3">
<form name="frmTag2" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag2()">
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
	<tr>
	  	<td align="left" valign="middle"><?php echo $this->lang->line('txt_Create_Tag');?>:<br /><br />
        
	  		<input name="tag" type="text" id="tag" maxlength="255">

			<input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Add');?>"/></li>

			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
			<input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">		
			<input type="hidden" name="addOption" value="new">	
					
		</td>
  </tr> 
</table>
</form>
</td>
</tr>

</table>











