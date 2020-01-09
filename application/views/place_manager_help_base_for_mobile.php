<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>



<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/lib/skins/tango/skin.css" />

    <script type="text/javascript" src="<?php echo base_url();?>js/lib/jquery.jcarousel.min.js"></script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 

	 <script language="JavaScript1.2">mmLoadMenus();</script>	

</head>

<body>
<!--Manoj: Load header_place_panel_for_mobile view-->
<?php $this->load->view('common/header_place_panel_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>



     

			<!-- Main menu -->

			<?php

			$workPlaceDetails = $this->identity_db_manager->getWorkPlaceDetails ($_SESSION['workPlaceId']);

			

			

			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId2( $_SESSION['workPlaceId']);

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			$details['workSpaces']		= $workSpaces;

			$details['workSpaceId'] 	= $workSpaceId;

			if($workSpaceId > 0)

			{				

				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];

			}

			else

			{

				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	

			}

			?>

				<div id="container_for_mobile" style="padding:0px 0px 40px">



				<div id="content">

			

				

             

                      <div class="menu_new">

           			  <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">
						<?php 
						  if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						  {
						?>
                        	<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

							<!--Manoj: Commented create space code-->
                        	<!--<li style="margin:0px!important;width:110px!important;"><a href="<?php //echo base_url()?>create_workspace"><span><?php //echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

                        	<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

                        	<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

							<!--<li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

							<li style="margin:0px!important;width:45px!important;"><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<?php
						  }
						  ?>
							
                        	<li style="margin:0px!important;width:45px!important;"><a href="<?php echo base_url()?>help/place_manager" class="active"><span><?php echo $this->lang->line('txt_Help');?></span></a></li>

                      	</ul>

					<div class="clr"></div>

					</div>		

                	

				

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

              	<tr>

                	<td colspan="3">

						<?php 

							$this->load->view('help/place_manager_help_for_mobile');

						?>

					</td>

              	</tr>

            	</table>

				

				</div>

				</div>

<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>

