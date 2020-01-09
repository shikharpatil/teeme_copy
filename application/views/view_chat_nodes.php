<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">
		<?php $userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrparent['userId']);
				$checkPre =$this->chat_db_manager->checkPredecessor($arrparent['nodeId']);
		?>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">
			  <tr>
				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="21" align="left" valign="bottom" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90%" align="left"><span class="style1"><?php
	if($checkPre){
	echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$checkPre.'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
	}else{
		echo '<a href="'.base_url().'view_discussion/node/'.$arrparent['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
	}
	 echo $this->lang->line('txt_By');?> <?php  echo $userDetails['userTagName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$arrparent['DiscussionCreatedDate'];?></span>&nbsp;&nbsp;<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> <?php /*if(!$viewCheck){ echo '<blink>New</blink>';
	}*/?></span></td><td align="right" style="padding-right:10px;"></td>
    <td align="right"></td>
  </tr>
</table> </td>
				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
		  </tr>
			  <tr>
				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
				<td><?php
				 echo stripslashes($arrparent['contents']);?><br>
			<div id="reply_teeme0" style="display:none; position:fixed; margin-top:0px; margin-left:20px;">	<p onMouseOver="vksfun(0);">

		<form name="form1" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $arrparent['treeIds'];?>">
			<input name="nodeId" type="hidden" value="<?php echo $arrparent['nodeId'];?>">
	&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('replyDiscussion', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); 
	</script>
		  <!--textarea name="replyDiscussion" cols="54" rows="5" id="replyDiscussion"></textarea-->
                <input type="button" name="Replybutton" value="Reply" onClick="validate_dis('replyDiscussion',document.form1);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);">
		        <input name="reply" type="hidden" id="reply" value="1">
				 <input name="editorname1" type="hidden"  value="replyDiscussion">
		        <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType"> 
		</form>
		
		 </p></div></td>
				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right"><a href="javascript:reply(0);"><?php echo $this->lang->line('txt_Reply');?></a>&nbsp;</td>
				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
		  </table>		 </td>
        </tr>
	<?php 
	
	if($arrparent['successors'])
	{		 //print_r($arrparent);	
		
			$sArray=array();
			$sArray=explode(',',$arrparent['successors']);
			while($counter < count($sArray)){
				$arrDiscussions=$this->chat_db_manager->getPerentInfo($sArray[$counter]);
				$position++;
				$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc =$this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);
				
				 $this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
				 
				 $viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
				?>
				 <tr>
        <td width="30" align="left" valign="top" bgcolor="#FFFFFF">		</td>
        <td width="29" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">
		
		
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td align="left" height="21" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90%" align="left"><span class="style1"><?php echo $this->lang->line('txt_By');?> <?php  echo $userDetails['userTagName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$arrDiscussions['DiscussionCreatedDate'];?></span>&nbsp;&nbsp;<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> <?php if(!$viewCheck){ echo '<blink>'.$this->lang->line('txt_New').'</blink>';
	}?></span> <?php if($checksucc){
	echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$arrDiscussions['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
	}?></td><td align="right" style="padding-right:10px;"></td>
    <td align="right"></td>
  </tr>
</table></td>
				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
				<td><?php echo stripslashes($arrDiscussions['contents']);?><br>
<div id="reply_teeme<?php echo $position;?>" style="display:none; position:fixed; margin-top:0px; margin-left:20px;">
			<p onMouseOver="vksfun(<?php echo $position;?>);">
			<form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $arrparent['treeIds'];?>">
			<input name="nodeId" type="hidden" value="<?php echo $arrDiscussions['nodeId'];?>">
			
			
	&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); </script>
                 <input type="button" name="Replybutton" value="Reply" onClick="validate_dis('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>',document.form12<?php echo $position;?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(<?php echo $position;?>);">
		        <input name="reply" type="hidden" id="reply" value="1">
				 <input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>">
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
		</form></p>
			</div></td>
				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right">&nbsp;<a href="javascript:reply(<?php echo $position;?>);"><?php echo $this->lang->line('txt_Reply');?></a></td>
				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			</table>		</td>
        </tr>
				
				
				<?php
				$counter++;
			}
		
	}
	
	
?>
    </table>