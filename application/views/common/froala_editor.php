<!-- Include Editor style. -->
<link href='<?php echo base_url();?>froala_editor/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
<link href='<?php echo base_url();?>froala_editor/css/froala_style.min.css' rel='stylesheet' type='text/css' />
<?php /*?><link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_style.min.css' rel='stylesheet' type='text/css' /><?php */?>

<!--Include js and css file for audio record -->
<script type='text/javascript' src="<?php echo base_url();?>froala_editor/recordmp3.js"></script>
<!--<link rel="stylesheet" href="<?php //echo base_url();?>froala_editor/audio/css/style.css" rel="stylesheet" />-->

<!-- Include JS file. -->
<?php /*?><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script><?php */?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php /*?><script src="<?php echo base_url();?>froala_editor/js/jquery.min.js"></script><?php */?>

<?php /*?><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script><?php */?>
<?php
//Check ios device and add froala editor js file for image upload 
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
if( $iPod || $iPhone || $iPad ){
?>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.min.js'></script>
<?php }
else
{ ?>
	<script type='text/javascript' src='<?php echo base_url();?>froala_editor/js/froala_editor.min.js'></script>
<?php } ?>


<!-- Include Editor plugins CSS style. -->
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/froala_style.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/char_counter.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/code_view.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/colors.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/emoticons.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/file.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/fullscreen.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/image.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/image_manager.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/line_breaker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/quick_insert.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/special_characters.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/table.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/plugins/video.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php /*?><link rel="stylesheet" href="<?php echo base_url();?>froala_editor/css/font-awesome.min.css"><?php */?>
<!-- Include Code Mirror CSS. -->
<?php /*?><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css"><?php */?>

<!-- Include the plugins JS files. -->
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/file.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/save.min.js"></script>
<?php /*?><script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/special_characters.min.js"></script><?php */?>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>froala_editor/js/plugins/word_paste.min.js"></script>
<script>

//$.FroalaEditor.DEFAULTS.key = 'EKF1KXDA1INBc1KPc1TK==';
$.FroalaEditor.DEFAULTS.key = '2C3A6D7C4fA4A3D3B3F2B6C4C4C3A2yIBEVFBOHH1d1UNYVM==';

</script>
<!-- Include Code Mirror JS. -->
<?php /*?><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script><?php */?>