<?php 
$objectFollowStatus	= $this->identity_db_manager->get_follow_status($_SESSION['userId'],$seedId,'',$object_id);
//$originatorUserId=$this->identity_db_manager->get_tree_originator_id('1',$seedId);
/*if($originatorUserId!=$_SESSION['userId'])
{*/
if($object_id==15 && $seedId==$_SESSION['userId']){
    // show nothing
} 
else{
?>
    <span class="followBtn<?php echo $seedId; ?> followBtnDiv2">
	    <?php if($objectFollowStatus['preference']==1){ ?>
		
		<a style="" class="bookmarked2 follow_object blue_following marked<?php echo $seedId; ?>" onclick="add_object_follow('<?php echo $seedId; ?>','unfollow','<?php echo $object_id; ?>')" onmouseover="changeFollowStatusOver('<?php echo $seedId; ?>')" onmouseout="changeFollowStatusOut('<?php echo $seedId; ?>')"><?php echo $this->lang->line('txt_object_following'); ?></a>
	
	    <?php }
		else
		{ ?>
		<a style="font-size:0.8em" class="bookmark2 follow_object" onclick="add_object_follow('<?php echo $seedId; ?>','follow','<?php echo $object_id; ?>')"><?php echo $this->lang->line('txt_object_follow'); ?></a>
		
    <?php } ?>
    </span>
<?php /*}*/ 
}?>
<div class="clr"></div>