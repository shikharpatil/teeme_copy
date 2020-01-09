<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$sequenceTags = array();
$sequenceOrder = 0;	
$styleDisplay = '';
$sequence = 0;
if($sequenceTagId > 0)
{
	$styleDisplay = '';
	$sequence = 1;
	$sequenceTags = $this->tag_db_manager->getSequenceTagsBySequenceId($sequenceTagId);

}
?>
 <html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Teeme Documents</title>	
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
	</head>	
<body>
<form name="frmTag" method="post" action="<?php echo base_url();?>create_tag" onSubmit="return validateTag()"> 
<table width="95%" border="0" cellspacing="0" cellpadding="5" style="background-color:#E9F3FC; border:1px solid BLACK;" align="center">
	<?php 
	if($this->uri->segment(8) == 1)
	{
	?>
		<tr>
		<td height="8" colspan="3">Tag has been created successfully</td>
	</tr>       
		<tr>
		<td height="8" colspan="3"><input name="cancel" type="button" class="button" value="Close Window" onClick="javascript:closePopWindow()" /></td>
	</tr>       
	<?php
	}
	else
	{
	?>
	
	<tr>
		<td height="8" colspan="3"></td>
	</tr>        
	<tr>
		<td width="25%" align="left" valign="middle"><span class="text_blue"><strong>Tag Type </strong></span></td>
	    <td width="75%" colspan="2" align="left" valign="top"><select name="tagType" id="tagType" onChange="changeTag(this,'tag','<?php echo $workSpaceId;?>')">
		
		<?php	
		$i = 0;
		foreach($tagCategories as $tagData)
		{			
			?>
				<option value="<?php echo $tagData['categoryId'];?>" <?php if($i == 0 ) { ?> selected <?php } ?>><?php echo $tagData['categoryName'];?></option>				
			<?php
			$i++;
		}
		?>
        </select></td>
	</tr>
	<tr>
	  <td align="left" valign="middle">Select Tag </td>
	  <td colspan="2" align="left" valign="top">
          <select name="tag" id="tag">
            <option value="1" selected>Review</option>
            <option value="2">Comment</option>
            <option value="3">Approve</option>
          </select>
      </td>
  </tr>
	<tr>
	  <td align="left" valign="middle">Comments</td>
	  <td colspan="2" align="left" valign="top"><input name="tagComments" type="text" id="tagComments" maxlength="255"></td>
    </tr>
	<tr><td colspan="3">
		<span id="voteTag" style="display:none;">
			<table>
			<tr>		
			<td align="left" valign="middle" width="35%">Enter the voting question </td>
			<td colspan="2" align="left" valign="top"><input type="text" name="voteQuestion" id="voteQuestion">
			</td>
			</tr></table>
		</span>
		<span id="selectionTag" style="display:none;">
			<table>
				<tr>		
				<td align="left" valign="top">Enter the no of options</td>
				<td colspan="2" align="left" valign="top"><select name="noOfOptions" id="noOfOptions" onChange="addOptions('optionFields')">
				<option value="">--Select--</option>
				<?php
				for($i = 1; $i<=10; $i++)
				{
				?>	
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
				}
				?>			
				</select>
				</td>
				</tr>
				<tr>		
				<td align="left" valign="top">Enter the options</td>
				<td colspan="2" align="left" valign="top"><span id="optionFields"><input type="text" name="selectionOptions[]" id="selectionOptions[]"></span>
				</td>
				</tr>
			</table>
		</span>
	</td></tr>
	
	<tr>
	  <td align="left" valign="middle">Action required on</td>
	  <td colspan="2" align="left" valign="top"><select name="taggedUsers[]" multiple>
	    <option value="<?php echo $_SESSION['userId'];?>" selected>me</option>
	    <option value="0">All</option>
		<?php	
		foreach($workSpaceMembers as $arrData)
		{
			if($_SESSION['userId'] != $arrData['userId'])
			{		
			?>
			<option value="<?php echo $arrData['userId'];?>"><?php echo $arrData['tagName'];?></option>
			<?php
			}
		}		
		?>		
      </select></td>
  </tr>
	<tr>
	  <td align="left" valign="middle">Action By </td>
	  <td colspan="2" align="left" valign="top"><select name="actionDate" onChange="getTimings()">
	    <option value="0">--select--</option>
	    <option value="1" selected>Today</option>
	    <option value="2">Tomorrow</option>
	    <option value="3">This week</option>
	    <option value="4">This Month</option>
	    <option value="5">This year</option>
                  </select> 
		or <input name="startTime" id="startTime" type="text" size="14" maxlength="10" value="" readonly onClick='changeDrop(),popUpCalendar(document.frmTag.startTime, document.frmTag.startTime, "yyyy-mm-dd")'/>			
		<img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDrop(),popUpCalendar(this, document.frmTag.startTime, "yyyy-mm-dd")' value='select'>
	</td>
  </tr> 
<tr>
	  <td align="left" valign="middle" colspan="3">
		<span id="voteEnd" style="display:none;">
			<table>
			<tr>		
			<td align="left" valign="middle" width="47%">Voting ends on </td>
			<td colspan="2" align="left" valign="top"><input name="endTime" id="endTime" type="text" size="14" maxlength="10" value="" readonly onClick='popUpCalendar(document.frmTag.endTime, document.frmTag.endTime, "mm-dd-yyyy")'/>			
			   
					<img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='popUpCalendar(this, document.frmTag.endTime, "yyyy-mm-dd")' value='select'>
				 		
			</td>
			</tr></table>
		</span> </td>
	
  </tr>  
<?php
if(count($sequenceTags) > 0)
{
?>	               
	<tr><td colspan="3"><strong>Added Tags</strong></td>
	</tr>
	<tr><td colspan="3">
			<table width="100%">
				<tr>
					<td><strong>Tag Name</strong></td>
					<td><strong>Commnets</strong></td>
					<td><strong>Order<a href="javascript:void(0)" onClick="updateOrder()"><img src="<?php echo base_url().'images/update.png';?>" alt="Update Order" border="0"></a></strong></td>
				</tr>
				<?php	
				
				foreach($sequenceTags as $tagData)
				{					
					$tagName = $this->tag_db_manager->getTagName( $tagData['tagCategory'], $tagData['tagType'] );					
				?>		
				<tr>
					<td><?php echo $tagName;?></td><td><?php echo $tagData['comments'];?></td><td><input type="hidden" name="tagIds[]" value="<?php echo $tagData['tagId'];?>"><input type="text" name="tagOrders[]" value="<?php echo $tagData['sequenceOrder'];?>" size="3" maxlength="3"></td>
				</tr>	
				<?php
					$sequenceOrder = $tagData['sequenceOrder'];
				}
				$sequenceOrder = $sequenceOrder+1;
				?>	
			</table>
			<input type="hidden" name="countTags" value="<?php echo count($sequenceTags);?>">
			<input type="hidden" name="updateStatus" value="0">
		</td>
	</tr>
<?php
}
?>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td>&nbsp;</td>
		<td colspan="2">
			
			<input name="confirm" type="Submit" class="button" value="Submit"/>
			<input name="add_more" type="Submit" class="button" value="Add More" onClick="updateSequence()"/>
			<input name="cancel" type="button" class="button" value="Cancel" onClick="javascript:window.close()" />
			<input type="hidden" name="artifactId" id="artifactId" value="<?php echo $artifactId;?>">
			<input type="hidden" name="artifactType" id="artifactType" value="<?php echo $artifactType;?>">
			<input type="hidden" name="sequence" id="sequence" value="<?php echo $sequence;?>">
			<input type="hidden" name="sequenceOrder" id="sequenceOrder" value="<?php echo $sequenceOrder;?>">	
			<input type="hidden" name="sequenceTagId" id="sequenceTagId" value="<?php echo $sequenceTagId;?>">	
			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
					
		</td>
  </tr> 
	
<?php
}
?>
</table>
</form>
</body>
</html>
