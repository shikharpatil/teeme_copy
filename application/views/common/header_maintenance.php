<?php 
if($_COOKIE['ismobile'])
{
   $this->load->view('common/view_head.php');
}	
?>
<div id="header-container">
  <div id="header">
    <div id="left">
      <ul>
        <li><a href="<?php echo base_url();?>manage_workplace"><img class="logoImg" src="<?php echo base_url();?>images/logo.png"  /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>
	 </ul>
    </div>

    <div class="clr"></div>
  </div>
</div>
<div style="width:<?php echo $this->config->item('page_width')-50;?>px;">
  <div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>
  <div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>
</div>
<br />