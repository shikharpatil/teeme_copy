<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

      

	<div class="menu_new">

            <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm3">

        	

            	<li style="margin:0px!important;width:60px!important;"><a <?php if($this->uri->segment(3)=='view_work_places' || $this->uri->segment(3)=='create_work_place' || $this->uri->segment(3)=='edit_work_place' ){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_Places');?></span></a></li>

                 <!-- Editor configuration option hidden as now only one editor is in use i.e. ckeditor and backup module not used - Changed by Monika-->

                 

                <!--<li style="margin:0px!important;width:60px!important;"><a <?php if($this->uri->segment(3)=='select_editor' || $this->uri->segment(3)=='editor_options' ){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/select_editor"><span><?php echo $this->lang->line('txt_Editors');?></span></a></li>

                

				<li style="margin:0px!important;width:72px!important;"><a <?php if($this->uri->segment(3)=='backup'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>-->

				

				

				<?php 

				if($_SESSION['superAdmin'] == 1)

				{

				?>

                	<li style="margin:0px!important;width:85px!important;"><a <?php if($this->uri->segment(3)=='view_admin' || $this->uri->segment(3)=='add_admin' ){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/view_admin"><span><?php echo $this->lang->line('txt_Instance_Managers_Mobile');?></span></a></li>

            		<li style="margin:0px!important;width:105px!important;"><a  <?php if($this->uri->segment(3)=='edit_super_admin'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/edit_super_admin"><span><?php echo $this->lang->line('super_admin_txt'); ?><?php //echo $this->lang->line('txt_Super_Instance_Manager_Password_Mobile');?></span></a></li>

            		<?php

				}

				?>

				<li style="margin:0px!important;width:55px!important;"><a <?php if($this->uri->segment(3)=='metering'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/metering"><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>

                <?php if($_COOKIE['ismobile_admin']) { ?>

                <?php /*?><li style="margin:0px!important;width:55px!important;"><a <?php if($this->uri->segment(3)==''){ echo 'class="active"';} ?> href="<?php echo base_url();?>help/instance_manager_for_mobile"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
				<!--Manoj: created help icon-->
				<li style="margin:0px!important;width:55px!important;">	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=instance" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon" style="margin:-2px 0;">
						</a>
						</div>
				</li>
				<!--Manoj: code end-->

                <?php } else { ?>

                  <?php /*?><li style="margin:0px!important;width:45px!important;"><a <?php if($this->uri->segment(3)==''){ echo 'class="active"';} ?> href="<?php echo base_url();?>help/instance_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
				  <!--Manoj: created help icon-->	
				  <li style="margin:0px!important;width:45px!important;">
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=instance" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon" style="margin:-2px 0;">
						</a>
						</div>
					</li>
				<!--Manoj: code end-->

                <?php } ?>

            </ul>

			<div class="clr"></div>

        </div>

      