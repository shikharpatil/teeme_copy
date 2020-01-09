<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php 
		if (in_array($_SESSION['userId'],$workSpaceMembersId)) { ?>

		<div class="notify">
		<a id="treeNotify" href="javascript:void(0);" onclick="showPopWin('<?php  echo base_url();?>tree_notification/getNotifications/<?php echo $_SESSION['userId']; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>');" class="badge1" data-badge="<?php echo $countNotification; ?>">
			<img src="<?php echo base_url()?>images/notify.png" />
		</a>
		</div>

<?php  } ?>
