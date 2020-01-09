<meta name="viewport" content="user-scalable=no"/>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=10.0; user-scalable=0;"/>
<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lib/skins/tango/skin.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/lib/jquery.jcarousel.min.js"></script>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="application/javascript" src="<?php echo base_url();?>js/function_tablet.js"></script>
<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<div id="header-container_for_mobile">
  <div id="header">
    <div id="left_for_mobile">
      <ul>
        <li><a href="<?php echo base_url().'workspace_home2/trees/0/type/1';?>"><img src="<?php echo base_url();?>images/logo1_for_mobile.png" style="width:21px;"  /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>
      </ul>
    </div>
    <div id="right_admin_for_mobile">
      <ul>
        <li style="padding-right:1em;">
          <?php
			if(isset($_SESSION['adminUserName']) && $_SESSION['adminUserName']!='')
			{
			?>
          <?php echo $this->lang->line('txt_Hi');?>,
          <?php $tmp = explode('@',$_SESSION['adminUserName']); echo $tmp[0];?>
          | <a href="<?php echo base_url();?>instance/admin_logout/"><?php echo $this->lang->line('txt_Sign_Out');?></a>
          <?php
		}
		
		$def = ($this->uri->segment(3)=='view_work_places' || $this->uri->segment(3)=='create_work_place' || $this->uri->segment(3)=='edit_work_place')?1:(($this->uri->segment(3)=='view_admin' || $this->uri->segment(3)=='add_admin' || $this->uri->segment(3)=='edit_admin')?2:(($this->uri->segment(3)=='change_password')?3:5));
		?>
        </li>
      </ul>
    </div>
    <div class="clr"></div>
  </div>
</div>
<div style="width:100%">
  <div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>
  <div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>
</div>
<br />
<script type="text/javascript">
$(document).ready(function() {
    $('#jsddm3').jcarousel({
		start:<?php echo $def;?>,
		visible:3,
		scroll:1
	});
		window.addEventListener("orientationchange", function() {
	});
});

</script> 