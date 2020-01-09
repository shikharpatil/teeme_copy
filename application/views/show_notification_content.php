<?php 
echo '<pre>';
print_r($tree_contents); 
?>

<?php /*?><div class="contents">
<h3>Leaf Content</h3>
<h3>Tree Name</h3>
<?php
//echo '<pre>';
//print_r($tree_contents); 
foreach($tree_contents as $content)
{ ?>
	<div> <?php if($content->contents==NULL){echo "no content";}else print_r($content->contents); ?> </div>
	<div> <?php print_r($content->name); ?> </div>
	<div style="clear:both"></div>

<?php }
?>
</div><?php */?>