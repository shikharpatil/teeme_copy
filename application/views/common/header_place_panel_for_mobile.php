<?php $this->load->view('common/view_head.php');
?>
<div id="header-container_for_mobile">
  <div id="header">
    <div id="left_for_mobile">
      <ul>
         <li id="logoImg"><a href="<?php echo base_url().'dashboard/index/'.$workSpaceId.'/type/1';?>" id="logoImgA"><img src="<?php echo base_url();?>images/logo1_for_mobile.png" style="width:21px;" /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>
	  </ul>
    </div>
    <div id="right_for_mobile">
      <ul>
         <li class="unbordered">
          <?php
			if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				{
					?>
					 <a href="<?php echo base_url();?>instance/admin_logout/work_place"><img class="log-out_image_for_mobile" src="<?php echo base_url();?>images/logout_for_mobile.png" style="padding-left:0px;" ></a>			  
				 	 <?php
				}
			?>
        </li>
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