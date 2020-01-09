<div id="msgDiv">
<?php
			   	
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	  
	if($replyArray)
	{
?>
		<div class="<?php echo $nodeBgColor;?>">
<?php

			foreach($replyArray as $reply)
			{
				if($_SESSION['lastCommentId']!=$reply['id'])	
				{
				  $replyerUserDetails	= 	$this->profile_manager->getUserDetailsByUserId($reply['commenterId']);
					 
				  $nodeBgColor 			= 	$_SESSION['i'] % 2 ? $rowColor1: $rowColor2;

?>
					<div class="<?php echo $nodeBgColor;?> msgCmntsDiv" ><?php echo stripslashes($reply['comment']); ?></div>
						
					<div style="font-style:italic;" class="msgCmntsDiv <?php echo $nodeBgColor;?>">&nbsp;
					
					<?php echo $replyerUserDetails['userTagName'];?>
					
					<?php
						echo $this->time_manager->getUserTimeFromGMTTime($reply['commentTime'],$this->config->item('date_format'));
					?>
					
					<?php 
					
					//Arun- only message originator delete comments
					if($this->uri->segment(4)==$_SESSION['userId'] || $reply['commenterId']== $_SESSION['userId']  ){   ?>	
					
                 &nbsp;&nbsp;<a href="javascript:void(0);" onClick="confirmDeleteComment1('<?php echo base_url();?>profile/deleteComment1/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $reply['id']; ?>');" style="font-style:normal" ><img border="0" style="cursor:pointer;" title="Delete" alt="Delete" src="<?php echo base_url(); ?>images/icon_delete.gif"><?php //echo $this->lang->line('txt_Delete');?></a>         
                	<?php 
					}
					?>
			</div> 
			<?php
					$_SESSION['i']=$_SESSION['i']+1;
					$_SESSION['lastCommentId']=$reply['id']; 
				  }
				 } 
			 	 
				  ?>
				  <div class="msgCmntsDiv <?php echo $nodeBgColor1;?>"></div>
				 </div>
				  <?php
				
				}	
				
			  ?>

</div> 		