<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Language</title>

<!--Manage place js css file-->
<?php $this->load->view('common/view_head.php');?>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>

</head>

<body>


<div id="wrap1">
  <div id="header-wrap">
			<!-- header -->	

			<?php  $this->load->view('common/header'); 
			//$this->load->view('common/header_place_panel');
			?>

			<!-- header -->	



<?php $this->load->view('common/wp_header'); ?>

 

			<!-- Main menu -->

			<?php
			/*
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

			if ($_SESSION['workPlacePanel'] != 1)

			{

				//$this->load->view('common/artifact_tabs', $details);

			}
			*/
			 

			 ?>

			<!-- Main menu -->	

</div>
</div>         
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
<?php
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

				<div class="menu_new" >

           

						  <ul class="tab_menu_new1">

						<li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
						
						<!--<li><a href="<?php echo base_url()?>create_workspace"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

						<li><a href="<?php echo base_url()?>view_workplace_members" ><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

						<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>language" class="active"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
						
						<li><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
						<li><a href="<?php echo base_url()?>manage_workplace/configuration" ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>

						<?php /*?><li><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
						
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=place" target="_blank">
								<img src="<?php echo base_url()?>images/help_new.png" title="help" class="help_icon">
						</a>
						</div>
						<!--Manoj: code end-->



                  		</ul>

					<div class="clr"></div>

					</div>	

			

			

				 <div style="width:90%">

			<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

           

              <!-- <td width="7%">&nbsp;</td>-->

			

           <span class="errorMsg" style="margin-left:10px;"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            

            <?php

				}

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

           

              <!-- <td width="7%">&nbsp;</td>-->

			

           <span class="successMsg" style="margin-left:10px;"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span>

            

            <?php

				}

				?>
			</div>

            <div style="width:90%; margin:10px;">

            <?php
			
		if(count($files) > 0)
		{

		?>

        	 <!-- <td width="7%">&nbsp;</td>-->
			<form name="languageForm" action="<?php echo base_url()?>language/addLanguage" method="post">
			<div>
             <div class="flLt languageView"> <strong><?php echo $this->lang->line('txt_Language');?></strong></div>

             <div class="flLt" style="margin-left:3%;"> <strong><?php echo $this->lang->line('txt_Action');?></strong></div>
			</div>
            <div class="clr"></div>
			<div style="margin-top:10px;">
            <?php

			$i = 1;
			
			foreach($files as $file)

			{ 

			?>

           

              <!--<td>&nbsp;</td>-->

              <div class="flLt languageView"><?php echo ucwords($file);?></div>

			  <div class="flLt" style="margin-left:3%;">
			  
			  	<input type="checkbox" name="language[]" class="languageName" value="<?php echo $file;?>" <?php if(in_array($file,$selectedLanguageDetails['config_value'])){  echo 'checked';  } ?> disabled="disabled" />

              </div>

              <div class="clr"></div>

           

            <?php

			  

				$i++;					

			}
			
			?>
			<div class="flLt" style="margin-top:1%;">
			
			<input type="submit" name="submit" value="<?php if(!empty($selectedLanguageDetails['config_value'])){ echo $this->lang->line('txt_Update'); } else { echo $this->lang->line('txt_Add'); } ?>" class="button01">
			</div>
			</div>
			</form>
			
			<?php

		}

		else

		{

		?>

            <?php echo $this->lang->line('txt_None');?>

            

            <?php

		}

		?>

		</div> 

		 

</div>

	<!--Added by Dashrath- load notification side bar-->
	<?php $this->load->view('common/notification_sidebar.php');?>
	<!--Dashrath- code end-->
</div>			

		

				<?php //$this->load->view('common/footer');?>
				<?php $this->load->view('common/foot.php');?>

</body>
</html>