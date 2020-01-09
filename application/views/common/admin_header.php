<meta name="viewport" content="user-scalable=no"/>

<?php /*?><meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=2.5" /><?php */?>

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

<!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<div id="header-container">

		<div id="header">

			<div id="left">

			<ul>

				<li><a href="<?php echo base_url().'workspace_home2/trees/0/type/1';?>"><img class="logoImg" src="<?php echo base_url();?>images/logo.png"  /></a></li>

			

				<li><img src="<?php echo base_url();?>images/sep.png" /></li>

				

				

			</ul>

			</div>

			<div id="right">

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

		?>

								

						</li>

				</ul>

</div>

<div class="clr"></div>

</div></div>

<div style="width:<?php echo $this->config->item('page_width')-50;?>px;">

	<div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>

	<div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>

	

</div>

<br />



