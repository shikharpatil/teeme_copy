<!--<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=10.0; user-scalable=0;" />maximum-scale=1.03 maximum-scale=1.54 -->
<?php
$userAgent = $_SERVER["HTTP_USER_AGENT"];
$devicesTypes = array(
	"iosDevice"   => array("ipad", "iphone", "ipod"),
);
foreach($devicesTypes as $deviceType => $devices) {           
	foreach($devices as $device) {
		if(preg_match("/" . $device . "/i", $userAgent)) {
			$deviceName = $deviceType;
		}
	}
}
if($deviceName=='iosDevice')
{
?>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.6" />
<?php
}
else
{
?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=2.5" />
<?php 
}
?>



<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lib/skins/tango/skin.css" />

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/stylish-select.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dropdown.css" />

<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen" />

<!-- CSSMenuMaker -->
<!--<link href="<?php //echo base_url();?>css/cssmenumaker.css" rel="stylesheet" type="text/css" />-->
<!-- CSSMenuMaker -->

<!-- slick nav menu css -->
<link href="<?php echo base_url();?>css/slicknav.css" rel="stylesheet" type="text/css" />
<!-- slick nav menu css -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/sol.css" />


<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>

<script>var baseUrl 		= '<?php echo base_url();?>';</script>

<script Language="JavaScript" src="<?php echo base_url();?>js/chat.js"></script>

<script Language="JavaScript" src="<?php echo base_url();?>js/jquery.dropdown.min.js"></script>

<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js"></script>

