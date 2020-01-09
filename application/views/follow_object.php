<?php 
$objectFollowStatus	= $this->identity_db_manager->get_follow_status($_SESSION['userId'],$seedId);
$originatorUserId=$this->identity_db_manager->get_tree_originator_id('1',$seedId);
/*if($originatorUserId!=$_SESSION['userId'])
{*/
?>
<li style="float:right;">
	<div class="followBtn<?php echo $seedId; ?> followBtnDiv">
	<?php if($objectFollowStatus['preference']==1){ ?>
		
		<a style="" class="bookmarked follow_object blue_following marked<?php echo $seedId; ?>" onclick="add_object_follow('<?php echo $seedId; ?>','unfollow')" onmouseover="changeFollowStatusOver('<?php echo $seedId; ?>')" onmouseout="changeFollowStatusOut('<?php echo $seedId; ?>')"><?php echo $this->lang->line('txt_object_following'); ?></a>
	
	<?php }
		else
		{ ?>
		<a style="font-size:0.8em" class="bookmark blue_follow follow_object" onclick="add_object_follow('<?php echo $seedId; ?>','follow')"><?php echo $this->lang->line('txt_object_follow'); ?></a>
		
  <?php } ?>
  	</div>
</li>
<?php /*}*/ ?>
<div class="clr"></div>
