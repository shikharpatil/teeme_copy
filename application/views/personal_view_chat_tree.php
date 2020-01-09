<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php $position=0;?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
      
      <tr>
        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">
			  <tr>
			    <td height="21" >&nbsp;</td>
			    <td height="21" align="left" ><strong><?php echo $this->lang->line('txt_Chat_Title');?>: <?php echo $arrDiscussionDetails['name'];?></strong></td>
			    <td height="21" >&nbsp;</td>
	      </tr>
		  <?php
				if($pnodeId){?>
			  <tr>
				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="21" align="left" valign="bottom" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;">&nbsp; </td>
				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
		  </tr>
			  <tr>
				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
				<td id="<?php echo $position++;?>"><?php
				if($pnodeId){ echo stripslashes($DiscussionPerent['contents']);}else{
					echo $arrDiscussionDetails['name'];
				}
				 ?><br>			</td>
				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right">&nbsp; </td>
				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
		<?php	  }else{$position++;}
				 ?>
		  </table>		Â 
		</td>
        </tr></table>
		<div style="width:100%; height:250px; overflow:scroll;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	
	if(count($arrDiscussions) > 0)
	{		//print_r($arrDiscussions);					 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
		//echo $arrVal['userId'];
	 
			$userDetails1	= 	$this->personal_chat->getUserDetailsByUserId($arrVal['userId']);	
			
			$checksucc 		=	$this->personal_chat->checkSuccessors($arrVal['nodeId']);
			
			 
			
			 
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
    <td width="90%" align="left"><span class="style1"><?php echo $this->lang->line('txt_By');?><?php  echo $userDetails1['userTagName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'],'m-d-Y h:i A');?></span>&nbsp;&nbsp;<a href="javascript:void(0)" onClick="window.open('<?php echo base_url().'';?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $arrVal['nodeId'];?>/2','','width=650,height=450,toolbar=no,scrollbars=yes,resizable=no,top=170,left=200')"><?php echo $this->lang->line('txt_Tag');?></a> </td><td align="right" style="padding-right:10px;"></td>
    <td align="right"></td>
  </tr>
</table>
</td>
				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
				<td id="<?php echo $position++;?>"><?php echo stripslashes($arrVal['contents']);?><br>
</td>
				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right">&nbsp;<?php if($timmer){?><a href="javascript:;" onclick="nodeId=<?php echo $arrVal['nodeId'];?>; replay_target=<?php echo $arrVal['nodeId'];?>; document.getElementById('vk12345').innerHTML='<a href=\'javascript:;\' onclick=\'nodeId=0; replay_target=0;\'>Repaly To main</a>'"><?php echo $this->lang->line('txt_Reply');?></a><?php }?></td>
				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			 
			</table>
			<div style="padding-left:20px;">
			<?php
			 //echo $arrVal['nodeId']; 
			$arrparent=  $this->personal_chat->getPerentInfo($arrVal['nodeId']);
				// print_r($arrparent);
				
		if($arrparent['successors'])
		{
			/////////////////////////////////////////////////////////////////////////////////
			
					  //print_r($arrparent);	
		
			$sArray=array();
			$sArray=explode(',',$arrparent['successors']);
			//print_r($sArray);
			$counter=0;
			while($counter < count($sArray))
			{
				$arrDiscussions	= $this->personal_chat->getPerentInfo($sArray[$counter]);			 
				$userDetails	= $this->personal_chat->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc 		= $this->personal_chat->checkSuccessors($arrDiscussions['nodeId']);				
			//	$this->personal_chat->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
				//$viewCheck=$this->personal_chat->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
				?>
				 <tr>
        <td width="30" align="left" valign="top" bgcolor="#FFFFFF">		</td>
        <td width="29" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">
		
		
		
		<table width="90%" border="0" cellspacing="0" cellpadding="0" align="right">
			  <tr>
				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td align="left" height="21" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90%" align="left"><span class="style1"><?php echo $this->lang->line('txt_By');?><?php  echo $userDetails['userTagName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],'m-d-Y h:i A');?>&nbsp;&nbsp;<a href="javascript:void(0)" onClick="window.open('<?php echo base_url().'';?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $arrDiscussions['nodeId'];?>/2','','width=650,height=450,toolbar=no,scrollbars=yes,resizable=no,top=170,left=200')"><?php echo $this->lang->line('txt_Tag');?></a></span></td>
    <td align="right" style="padding-right:10px;"></td>
    <td align="right"></td>
  </tr>
</table></td>
				<td width="25"  height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
				<td id="<?php echo $position++;?>"><?php echo stripslashes($arrDiscussions['contents']);?><br>
</td>
				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right">&nbsp;</td>
				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>
			  </tr>
			</table>		</td>
        </tr>
				
				
				<?php
				$counter++;
			}			
			/////////////////////////////////////////////////////////////////////////////////
		}
		
		?><span id="meFocus" > </span>
			</div>	
		</td>
        </tr>
		<?php
		}
	}
	 
?>
    </table>
 
</div>