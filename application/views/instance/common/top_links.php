<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>



	<div class="menu_new" >

            <ul class="tab_menu_new2">

        	

            	<li><a <?php if($this->uri->segment(3)=='view_work_places' || $this->uri->segment(3)=='create_work_place' || $this->uri->segment(3)=='edit_work_place' || $this->uri->segment(3)=='delete_work_place'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_Places');?></a></span></li>

               

               <!-- Editor configuration option hidden as now only one editor is in use i.e. ckeditor and backup module is not in use - Changed by Monika-->

               <!-- <li><a <?php if($this->uri->segment(3)=='select_editor' || $this->uri->segment(3)=='editor_options' ){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/select_editor"><span><?php echo $this->lang->line('txt_Editors');?></span></a></li>-->

				

				<?php 

				if($_SESSION['superAdmin'] == 1)

				{

				?>

                	<li><a <?php if($this->uri->segment(3)=='view_admin' || $this->uri->segment(3)=='add_admin' ){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/view_admin"><span><?php echo $this->lang->line('txt_Instance_Managers');?></span></a></li>

            		<li><a  <?php if($this->uri->segment(3)=='change_password'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/edit_super_admin"><span><?php echo $this->lang->line('super_admin_txt'); ?></span></a></li>

            	<?php

				}

				?>

				<li><a <?php if($this->uri->segment(3)=='metering'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/metering"><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
				
				<li><a <?php if($this->uri->segment(3)=='backup'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/home/backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>

               <?php /*?> <li><a <?php if($this->uri->segment(3)==''){ echo 'class="active"';} ?> href="<?php echo base_url();?>help/instance_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>

				<!--Manoj: code for update version -->
				<?php /*?><li><a <?php if($this->uri->segment(3)=='create_update'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/auto_update/create_update"><span><?php echo $this->lang->line('txt_About');?></span></a></li><?php */?>
				<!--Manoj: code end-->
				
				<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=instance" target="_blank">
								<img src="<?php echo base_url()?>images/help_new.png" title="help" class="help_icon">
						</a>
						</div>
				<!--Manoj: code end-->
				
				<!--Manoj: code for maintenance mode -->
				<?php /*?><li><a <?php if($this->uri->segment(3)=='select_mode'){ echo 'class="active"';} ?> href="<?php echo base_url();?>instance/maintenance/select_mode"><span><?php echo $this->lang->line('txt_Maintenance');?></span></a></li><?php */?>
				<!--Manoj: code end-->
				
            </ul>

			<div class="clr"></div>

        </div>

        