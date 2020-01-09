<div style="font-family: Helvetica, Arial, sans-serif; font-size:0.9375em;">
<h4 style="margin-left:38px;"><?php echo $this->lang->line('txt_Group_users');?></h4>
<ul class="userGroupList" style="list-style:none; height:60%; width:70%; overflow-y:auto;"> 
<?php
//print_r($GroupUsers);
foreach($GroupUsers as $groupData)
{	
	$userDetails = $this->identity_db_manager->getUserTagNameByUserId($groupData['userId']);
	?>
	<li>
		<?php echo $userDetails['tagName']; ?>
	</li>
	<?php
}				
?>
</ul>
</div>