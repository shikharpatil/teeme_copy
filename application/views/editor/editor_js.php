<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php //if( trim($_COOKIE['mylanguage']) != ''){
	$mylang= $_SESSION['lang'];
?>
<script>
var languageList='<select style="position-top:-4px;" name="languaget" id="languaget" onchange="chnagelanguage(this.value)"><option value="english" <?php if( $mylang=='english') echo 'selected';?>>english</option><option value="xyz" <?php if( $mylang=='xyz') echo 'selected';?>>xyz</option></select>';
</script>
<script src="<?php echo base_url();?>editor/language/<?php echo $mylang;?>.js" type="text/javascript"></script>
 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>