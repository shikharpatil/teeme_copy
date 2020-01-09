<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Bulk Registrations</title>

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

<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu1.js"></script>

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

<?php
			/*
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
			*/
			//if ($_SESSION['workPlacePanel'] != 1)

			//{

				//$this->load->view('common/artifact_tabs', $details);

			//}

			 

			 ?>

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

        <li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

        <li><a href="<?php echo base_url()?>add_workplace_member" ><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

        <li><a href="<?php echo base_url()?>add_workplace_member/registrations" class="active" ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

        <li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
		
		<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
		
		<li><a href="<?php echo base_url()?>language"><span><?php echo $this->lang->line('txt_Language');?></span></a></li>
		
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

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <?php

				if(isset($_SESSION['messgage']) && $_SESSION['messgage'] !=	"")

				{

				?>

      <tr>

        <td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['messgage']; $_SESSION['messgage'] ='';?></span></td>

      </tr>

      <?php

				}

				

				?>
				
	 <?php

				if(isset($_SESSION['successMessage']) && $_SESSION['successMessage'] !=	"")

				{

				?>

      <tr>

        <td colspan="4" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMessage']; $_SESSION['successMessage'] ='';?></span></td>

      </tr>

      <?php

				}

				

				?>

      <!-- <tr>

                  <td class="heading" colspan="4"><?php //echo $this->lang->line('txt_Enter_Member_Details');?></td>

                </tr>

                <tr>-->

      <tr>

        <td class="subHeading" colspan="4">&nbsp;</td>

      </tr>

	  <!--Manoj: for number of users error-->
	  <tr>
	  	<td colspan="4" style="color:#ff0000">
			<?php if(isset($_SESSION['errormessage'])){ echo $_SESSION['errormessage']; $_SESSION['errormessage']=''; } ?>
		</td>
	  </tr>
	  <!-- Manoj: code end-->

      <tr>

        <td colspan="4"><?php if(isset($_SESSION['errorMsg'])){ echo $_SESSION['errorMsg']; $_SESSION['errorMsg']=''; } ?>

          <form method="post" action="<?php echo base_url(); ?>add_workplace_member/registrations" enctype="multipart/form-data" >

            <div id="image_msg1"> <?php echo $this->lang->line('Msg_Please_upload_csv_file');?>

              <input  type="file" name="contact"  id="contact" />

              <input type="submit" value="Upload">

            </div>

          </form></td>

      </tr>

        <tr>

        <td colspan="4"><br /><?php echo $this->lang->line('format_of_csv_txt'); ?> <br />

        <strong><?php echo $this->lang->line('column_txt'); ?> 1-</strong><?php echo $this->lang->line('txt_First_Name'); ?><br />

        <strong><?php echo $this->lang->line('column_txt'); ?> 2-</strong><?php echo $this->lang->line('txt_Last_Name'); ?><br />

        <strong><?php echo $this->lang->line('column_txt'); ?> 3-</strong><?php echo $this->lang->line('txt_Email'); ?><br />
		
		<strong><?php echo $this->lang->line('column_txt'); ?> 4-</strong><?php echo $this->lang->line('user_tag_name_preference_txt'); ?> (Use <strong>f_l</strong> <?php echo $this->lang->line('for_first_last_name_txt'); ?>, use <strong>l_f</strong> <?php echo $this->lang->line('for_last_first_name_txt'); ?>)<br /><br />
		
		<strong><?php echo $this->lang->line('first_line_should_be_txt'); ?></strong><br />
		<?php echo $this->lang->line('bulk_registration_fields_txt'); ?>     

        </td>

        </tr>
		
        <tr>

        <td colspan="4"><br /><strong><?php echo $this->lang->line('example_valid_file_txt'); ?></strong><br />
		
        <?php echo $this->lang->line('bulk_registration_fields_txt'); ?><br />
		John,Doe,john.doe@teeme.net,l_f

        </td>

        </tr>		

      <?php if($total_records){ ?>

      <tr>

        <td colspan="4"><?php    echo '<br><b>'.$this->lang->line('Msg_Total_records_in_file')." ".$total_records.'</b>';  ?></td>

      </tr>

      <?php } ?>

      <tr>

        <td colspan="4"><?php  $success_records=$total_records- $failed_records; if($total_records){echo '<br><b>'.$this->lang->line('Msg_successful_registrations').' '.$success_records.'</b>'; }  ?></td>

      </tr>

        <tr>

      

        <td colspan="4">

      

      <?php   if(count($successUserRecords)>0) { ?>

      <table width="700px">

        <?php			$temp='';

							$userDetail=explode("\n",$successUserRecords);

							foreach($userDetail as $record)

							{

								 $feild=explode(",",$record);

								 

								 $temp.= '<tr><td>'.$feild[0].'</td><td>'.$feild[1].'</td><td>'.$feild[2].'</td><td>'.$feild[3].'</td><td style="color:green">'.$feild[4].'</td></tr>';

								 

							}

						

							if($successUserRecords){

				?>

        <tr style="font-weight:bold" height="30px">

          <td width="100px;"><?php echo $this->lang->line('txt_First_Name');?></td>

          <td width="100px;"><?php echo $this->lang->line('txt_Last_Name');?></td>
		  
		  <td width="200px;"><?php echo $this->lang->line('txt_User_Tag_Name');?></td>

          <td width="200px;"><?php echo $this->lang->line('txt_Email');?></td>

          <td width="100px;"><?php echo $this->lang->line('txt_Password');?></td>

          <td></td>

        </tr>

        <?php		

				             }

							echo $temp."</table>";	

								

				  } ?>

          </td>

        

          </tr>

        

        <tr>

          <td colspan="6"><?php   if($failedUser) { ?>

            <form  id="csvfile" name="csvfile" method="post" action="<?php echo base_url(); ?>add_workplace_member/downloads" >

              <?php  echo '<br><b>'.$this->lang->line('Msg_Total_failed_registrations')." ".$failed_records.'</b>';  ?>

              <input type="hidden" name="contents" id="contents" value="<?php echo "First Name,Last Name,Email,User Tag Name Preference,Error \n".$failedUser; ?>"  />

              <a href="javaScript:void(0)" onclick="document['csvfile'].submit();"  ><?php echo $this->lang->line('download_csv_file_txt'); ?></a>

            </form>

            <?php } ?></td>

        </tr>

      

          <tr>

        

          <td colspan="6">

        

        <?php   if(count($failedUser)>0) { ?>

        <table width="750px" >

          <?php 

				 			$temp='';

							$userDetail=explode("\n",$failedUser);

							foreach($userDetail as $record)

							{

								 $feild=explode(",",$record);

								 

								 $temp.='<tr><td>'.$feild[0].'</td><td>'.$feild[1].'</td><td>'.$feild[2].'</td><td>'.$feild[3].'</td><td style="color:red " >';

								if($feild[4]!='')

								  $temp.='ERROR';

								  $temp.='</td></tr>';

								 

							}

							

							if($failedUser){

					?>

          <tr style="font-weight:bold" height="30px">

            <td width="100px;"><?php echo $this->lang->line('txt_First_Name');?></td>

            <td width="100px;"><?php echo $this->lang->line('txt_Last_Name');?></td>

            <td width="200px;"><?php echo $this->lang->line('txt_Email');?></td>

            <td width="100px;"><?php echo $this->lang->line('txt_Password');?></td>

            <td>Error</td>

          </tr>

          <?php	

					   }	

							echo $temp."</table>";	

								

				  } ?>

            </td>

          

            </tr>

          

          <tr>

            <td colspan="4"><br/></td>

          </tr>

        </table>

        

        <!-- Main Body -->

        

          </td>

        

          </tr>

        

      </table>

        </td>

      

        </tr>

      

    </table>

  </div>

  	<!--Added by Dashrath- load notification side bar-->
	<?php $this->load->view('common/notification_sidebar.php');?>
	<!--Dashrath- code end-->

</div>



<!-- Footer -->

<?php //$this->load->view('common/footer');?>
<?php $this->load->view('common/foot.php');?>

<!-- Footer --> 

</body>
</html>
<script type="text/javascript" >
if(mobile_detect("", "1", ''))

{

	$("#image_msg1").html('To upload file use web services.<br><br>');

	$("#image_msg1").css('color','#FF0000');

}



</script>

