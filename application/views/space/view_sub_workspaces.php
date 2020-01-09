<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Teeme > View Sub Spaces</title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container" >
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">

			<!-- Main menu -->

			<?php

			//$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			//$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

						<div class="menu_new" >

            <ul class="tab_menu_new1">

						<li><a href="<?php echo base_url()?>edit_workspace/index/<?php echo $workSpaceId;?>"><span><?php echo $this->lang->line('txt_Edit_Workspace');?></span></a></li>

                        <li><a href="<?php echo base_url()?>view_sub_work_spaces/index/<?php echo $workSpaceId;?>/1" class="active"><span><?php echo $this->lang->line('txt_View_Sub_Workspaces');?></span></a></li>

                        <li><a href="<?php echo base_url();?>create_sub_work_space/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Create_Sub_Workspace');?></span></a></li>

				      	<?php /*?><li><a href="<?php echo base_url()?>help/space_manager/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
						
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=space" target="_blank">
								<img src="<?php echo base_url()?>images/help_new.png" title="help" class="help_icon">
						</a>
						</div>
						<!--Manoj: code end-->



                        </ul>

						<div class="clr"></div>

						</div>

                <?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                  

                    <tr>

                      <td colspan="7" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                    </tr>

                    <?php

				}

				
				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

                  

                    <tr>

                      <td colspan="7" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

                    </tr>

                    <?php

				}
				
				?>

				

                    <?php

					if(count($subWorkSpaces) > 0)

					{

					?>

					

                            
						<!--Changed by Dashrath- remove inline style="padding: 9px 1.4% 0;" from div-->
                        <div class="row-active-header">

                                 

                        <div class="row-active-header-inner1" style="width:6%;" >

                            <span class="rowHeaderFont" ><strong>#</strong></span>

                        </div>

                                 
                        <!--Changed by Dashrath- change inline style="width:35.5%;" to 35%-->
                        <div class="row-active-header-inner1" style="width:35%;" >

                            <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Sub_Workspaces');?></span>

                        </div>

                        

                        <div class="row-active-header-inner2"  >

                            <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Created_Date');?></span>

                        </div>

                        

                        <div class="row-active-header-inner3" style="text-align:center" >

                            <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Action');?></span>

                        </div>

                        

                 </div>

					<div class="clr"></div>	

						<?php

						$rowColor1='row-active-middle1';

						$rowColor2='row-active-middle2';	

						$i = 1;

						

						foreach($subWorkSpaces as $keyVal=>$workSpaceData)

						{				

							if($workSpaceData['subWorkSpaceManagerId'] == 0)

							{

								$workSpaceManager = 'Not Assigned';

							}

							else

							{					

								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

								$workSpaceManager = $arrUserDetails['firstName'] .' '. $arrUserDetails['lastName'];

							}

							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	

						?>

						

						
						<!--Changed by Dashrath- remove inline style="padding: 2px 1.4% 0;" from container div-->
						 <div class="<?php echo $rowColor; ?> ">

						 

				
				<!--Changed by Dashrath- change inline style="width:6.5%;" to 6%-->
				<div class="row-active-header-inner1" style="width:6%;" >

					<span class="rowHeaderFont" ><?php echo $i;?></span>

				</div>		 

						 

						 

		 		<div class="row-active-header-inner1" style="width:35%;;" >

				

					<?php echo $workSpaceData['subWorkSpaceName'];?>

		

				</div>

				

				<div class="row-active-header-inner2"  >

					<span><?php echo $this->time_manager->getUserTimeFromGMTTime($workSpaceData['subWorkSpaceCreatedDate'], 'm-d-Y h:i A');?></span>

				</div>

				

				<div class="row-active-header-inner3"  style="text-align:center" >

					<span>
						<a href="<?php echo base_url();?>edit_sub_work_space/index/<?php echo $workSpaceDetails['workSpaceId'];?>/<?php echo $workSpaceData['subWorkSpaceId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="Edit" border="0"></a>	
					</span>
					<span>
						<!--<a href="<?php echo base_url();?>delete_sub_workspace/index/<?php echo $workSpaceData['workSpaceId'];?>/<?php echo $workSpaceData['subWorkSpaceId'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="Delete" border="0"></a>-->
						<?php
		
						if($workSpaceData['status'] == 0)
		
						{
		
						?>
		
							<a href="<?php echo base_url();?>edit_sub_work_space/activate/<?php echo $workSpaceData['subWorkSpaceId'];?>/<?php echo $workSpaceDetails['workSpaceId'];?>/<?php echo $workSpaceType;?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer;"></a>
		
						<?php
		
						}
		
						else
		
						{
		
						?>
		
							<a href="<?php echo base_url();?>edit_sub_work_space/suspend/<?php echo $workSpaceData['subWorkSpaceId'];?>/<?php echo $workSpaceDetails['workSpaceId'];?>/<?php echo $workSpaceType;?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer;"></a>
		
						<?php
		
						}
		
						?>
					</span>

				</div>

				

				<div class="clr"></div>

		 </div>

				

                	

								<?php

							$i++;					

						}

					}

					else

					{

					?>

								 <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>

								<?php

					}

					?>

						   

					<input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceDetails['workSpaceId'];?>">

				

    

</div>


<!--Added by Dashrath- load notification side bar-->
<?php $this->load->view('common/notification_sidebar.php');?>
<!--Dashrath- code end-->

</div>

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

</body>
</html>	