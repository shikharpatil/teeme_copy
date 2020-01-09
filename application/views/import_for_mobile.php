<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

</head>

<body onUnload="return bodyUnload()">	

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile">



		<div id="content">





       

          

          

         

			<!-- Main menu -->

			<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

			<!-- Main menu -->	

		

		  

		 

				

                

                	<div class="menu_new" >

			

			<ul class="tab_menu_new_up_for_mobile">

						<li style="width:125px;"><a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Imported_Files');?></span></a></li>

          				<!--Manoj: Code for import files -->

          				<li><a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Import_File');?></span></a></li>
						
						<!--Manoj: code end-->

          				<li style="width:45px;"><a href="<?php echo base_url()?>help/import/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Help');?></span></a></li>



                    </ul>

					<div class="clr"></div>

					</div>

                	

				

				

				

						<?php 

							$this->load->view('help/import_help');

						?>

					

				

 

</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>	