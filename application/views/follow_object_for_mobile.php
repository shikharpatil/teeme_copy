<?php 
$objectFollowStatus	= $this->identity_db_manager->get_follow_status($_SESSION['userId'],$seedId);
$originatorUserId=$this->identity_db_manager->get_tree_originator_id('1',$seedId);
if($originatorUserId!=$_SESSION['userId'])
{
?>
<li style="float:right;">
	<div class="followBtn<?php echo $seedId; ?>">
	<?php if($objectFollowStatus['preference']==1){ ?>
		
		<a class="bookmarkedMob follow_object_mob marked<?php echo $seedId; ?>" onclick="add_object_follow('<?php echo $seedId; ?>','unfollow')" onmouseover="changeFollowStatusOver('<?php echo $seedId; ?>')" onmouseout="changeFollowStatusOut('<?php echo $seedId; ?>')"><img style="cursor:pointer;height:25px;border:0px;margin-top:4px;" src="<?php echo base_url();?>images/following.png"></a>
	
	<?php }
		else
		{ ?>
		<a class="bookmarkMob follow_object_mob" onclick="add_object_follow('<?php echo $seedId; ?>','follow')"><img style="cursor:pointer;height:25px;border:0px;margin-top:4px;" src="<?php echo base_url();?>images/follow.png"></a>
		
  <?php } ?>
  	</div>
</li>
<?php } ?>
<div class="clr"></div>
