<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Configuration</title>


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

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script language="JavaScript1.2">mmLoadMenus();</script>

</head>

<body>

<?php  //$this->load->view('common/header'); 
	$this->load->view('common/header_place_panel_for_mobile');
?>

<?php $this->load->view('common/wp_header'); ?>

 

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

			if ($_SESSION['workPlacePanel'] != 1)

			{

				//$this->load->view('common/artifact_tabs', $details);

			}

			 

			 ?>

			<!-- Main menu -->	

</div>
</div>         

			<div id="container_for_mobile" style="padding:0px 0px 40px">



				<div id="content">

				<div class="menu_new" >

           

						  <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm4">

						<li style="margin:0px!important;width:105px!important;"><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

						<!--Manoj: Commented create space code-->
						<!--<li style="margin:0px!important;width:110px!important;"><a href="<?php //echo base_url()?>create_workspace"><span><?php //echo $this->lang->line('txt_Create_Workspace');?></span></a></li>-->

						<li style="margin:0px!important;width:118px!important;"><a href="<?php echo base_url()?>view_workplace_members" ><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li style="margin:0px!important;width:124px!important;"><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<!--<li><a href="<?php //echo base_url()?>add_workplace_member/registrations"  ><span><?php //echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>-->

						<li style="margin:0px!important;width:50px!important;"><a href="<?php echo base_url()?>view_metering/metering"><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
						
						<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>language" ><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
						
						<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>user_group"><span><?php echo $this->lang->line('txt_user_group');?></span></a></li>
						
						<li style="margin:0px!important;width:100px!important;"><a href="<?php echo base_url()?>manage_workplace/configuration" class="active" ><span><?php echo $this->lang->line('configuration_txt');?></span></a></li>


						<?php /*?><li style="margin:0px!important;width:45px!important;"><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
						
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=place" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon_mob">
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

            <div class="flLt" style="line-height:35px;"> <strong><?php echo $this->lang->line('allow_notes_tree_txt');?></strong></div>
			
			<div class="rightSection flLt" style="margin-left:2%;">
					<label class="switch">
					  <input class="switch-input" id="switch-input" name="tree_create" type="checkbox" value="6" <?php if($allowStatus=='1'){ ?> checked <?php } ?> onchange="manageTreeType();" >
					  <span class="switch-label" data-on="On" data-off="Off"></span> 
					  <span class="switch-handle"></span> 
					</label>
			</div>

		</div> 

		 

</div>
</div>			

		

				<?php $this->load->view('common/foot_for_mobile');?>
				<?php $this->load->view('common/footer_for_mobile');?>

			

  </body>

</html>
<script>
	function manageTreeType(){
			var allowStatus = '';
            if ($('#switch-input').is(":checked")) 
			{
				if(!confirm('<?php echo $this->lang->line('sure_to_allow_tree_type_txt'); ?>'))
				{       
					$("#switch-input").removeAttr('checked');
					return false;
				}
				else 
				{
					allowStatus = 1;
					$("#switch-input").attr("checked", "checked");
				}
               	
            } 
			else 
			{
				
				allowStatus = 0;
				$("#switch-input").removeAttr('checked');
				
			}
			
			var treeType=6; //Notes tree
			
			$.ajax({

				  url: baseUrl+'manage_workplace/setTreeTypeStatus',
				  type:'POST',
				  data: { allowStatus : allowStatus, treeType : treeType},
				  success:function(result)
				  {
				 	//alert(result);
					if(result==1)
					{
						//$(".formSuccessMsg").show();
					}
				  } 
			});
			
     }
</script>
