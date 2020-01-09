<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
$viewTags = $this->tag_db_manager->getTagsByCategoryId(2);
$appliedTagIds = array();
if(count($tags) > 0)
{
	foreach($tags as $tagData)
	{
		$appliedTagIds[] = $tagData['tag'];
	}
}
?>

<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag()">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
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
          <td align="left" valign="top"><?php echo $this->lang->line('txt_Select_Tag');?>:<br />
            <br />
            <select name="displayTags[]" id="displayTags[]" onchange="changeBackgroundSpan(this.value)" multiple size="5">
              <?php for($i=0;$i<count($dispTags2);$i++)
									{
										echo $dispTags2[$i];
									}
							
						?>
            </select>
            <input type="hidden" name="tag" id="tag" value="0"></td>
        </tr>
        <tr>
          <td><input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Apply');?>"/>
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
            <input type="hidden" name="addOption" value="apply"></td>
        </tr>
        <?php
		}
		else
		{	
		?>
        <tr>
          <td align="left" class="bottom-border-blue"><input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_Tag');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/>
            <br />
            <?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
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
          <td align="left" class="bottom-border-blue"><input name="confirm" type="button" class="button" value="<?php echo $this->lang->line('txt_Create_Tag');?>" onClick="goUrlByClick('<?php echo $createUrl;?>')"/>
            <br />
            <?php echo $this->lang->line('msg_tags_not_available_apply');?></td>
        </tr>
        <?php
	}
	?>
      </table></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center" class="blue-border">
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
          <td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied');?>: <br />
            <br />
            <select name="simpleTags[]" id="simpleTags[]" onchange="changeBackgroundSpan4(this.value)" multiple size="5">
              <?php			

						foreach($tags as $tagData)
						{													
							echo "<option id=tag".$tagData['tagId']." value=".$tagData['tagId'].">".$tagData['tagName']."</option>";					 
						}
		
					?>
            </select></td>
        </tr>
        <tr>
          <td align="left" class="bottom-border-blue"><ul class="rtabs">
              <li><a href="javascript:void(0)" onClick="removeTags()" class="current"><span><?php echo $this->lang->line('txt_Remove');?></span></a></li>
            </ul></td>
        </tr>
        <?php
	
}
else
{
?>
        <tr>
          <td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied');?>: <br />
            <br />
            <?php echo $this->lang->line('msg_tags_not_available');?></td>
        </tr>
        <?php
}
?>
      </table></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
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
          <td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied_Now');?>:<br />
            <br />
            <select name="simpleTags[]" id="simpleTags[]" onchange="changeBackgroundSpan4(this.value)" multiple size="5">
              <?php			

						foreach($currentTags as $tagData)
						{													
							echo "<option id=tag".$tagData['tagId']." value=".$tagData['tagId'].">".$tagData['tagName']."</option>";					 
						}
		
					?>
            </select></td>
        </tr>
        <tr>
          <td align="left" class="bottom-border-blue"><ul class="rtabs">
              <li><a href="javascript:void(0)" onClick="removeTags()" class="current"><span><?php echo $this->lang->line('txt_Remove');?></span></a></li>
            </ul></td>
        </tr>
        <?php
	
}
else
{
?>
        <tr>
          <td align="left" class="bottom-border-blue"><?php echo $this->lang->line('txt_Tags_Applied_Now');?>: <br />
            <br />
            <?php echo $this->lang->line('msg_tags_not_available');?></td>
        </tr>
        <?php
}
?>
      </table>
      <input type="hidden" name="tagLinks" id="tagLinks" value="0">
</form>
</td>
</tr>
<tr>
  <td colspan="3"><form name="frmTag2" method="post" action="<?php echo base_url();?>create_tag1" onSubmit="return validateTag2()">
      <table width="100%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC;" align="center"  class="blue-border">
        <tr>
          <td align="left" valign="middle"><?php echo $this->lang->line('txt_Enter_Tag');?>:<br />
            <br />
            <input name="tag" type="text" id="tag" maxlength="255">
            <input name="confirm" type="Submit" class="button" value="<?php echo $this->lang->line('txt_Add');?>"/>
            </li>
            <input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
            <input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
            <input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
            <input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">
            <input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
            <input type="hidden" name="tagOption" value="<?php echo $tagOption;?>">
            <input type="hidden" name="addOption" value="new"></td>
        </tr>
      </table>
    </form></td>
</tr>
</table>
