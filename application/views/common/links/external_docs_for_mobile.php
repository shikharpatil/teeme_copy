<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Manage File(s)</title>
<!--/*End of Changed by Surbhi IV*/-->
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
			<!-- Main menu -->	
		
		  
		  
					<!-- Main Body -->
					<?php 
			$option = $this->uri->segment(6);		
			if($option == 1)
			{
			?>	
				<form name="form1" method="post" action="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" enctype="multipart/form-data" onSubmit="return validateExternalDocs()">
			<?php
			}
			?>
			<div class="menu_new" >
			
			<ul class="tab_menu_new_up_for_mobile">
						<li style="width:125px!important;"><a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  <?php if($option == 1) { ?>class="active" <?php } ?>><span><?php echo $this->lang->line('txt_Imported_Files');?></span></a></li>
						
						<!--Manoj: added import files code-->
							<li ><a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" <?php if($option == 2) { ?>class="active" <?php } ?>><span><?php echo $this->lang->line('txt_Import_File');?></span></a></li>
						<!--Manoj: code end-->
						
          				<?php /*?><li style="width:45px!important;"><a href="<?php echo base_url()?>help/import/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=import" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon_mob">
						</a>
						</div>
						<!--Manoj: code end-->

                    </ul>
					<div class="clr"></div>
                </div>
				<div class="clr"></div>
				<?php 
				if($option == 1)
				{					
				?>
				   <div style="margin-top:3%;">
				   <input type="test" name="searchDocs" value="<?php echo $searchDocs;?>" maxlength="50" size="15">
                   <input type="submit" name="Search" value="<?php echo $this->lang->line('txt_Search');?>" class="button01">
				   </div>
				<?php
				}
				?>				
				
				<?php 
				switch($option)
				{
					case 1:
						$this->load->view('common/links/view_external_documents_for_mobile');
						break;	
					//Manoj: Load view for import files
					case 2:						
						$this->load->view('common/links/add_external_docs'); 										
						break;
					//Manoj: Load view for import files end
					default:	
						$this->load->view('common/links/view_external_documents_for_mobile');
						break;	
				}			
					
				?>
			
			<?php	
			if($option == 1)
			{
			?>	
				</form>
			<?php
			}
			?>
				
   
</div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>	
