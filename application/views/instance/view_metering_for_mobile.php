<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Stats</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js">

</script>

<script>

function confirmDeleteWorkPlace ()

{

	var msg = '<?php echo $this->lang->line('msg_place_delete');?>';

	if (confirm(msg) == 1)

	{

		return true;

	}

	else

	{

		return false;

	}

}

</script>

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>

	<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links_for_mobile');

					?>     

					<!-- End Top Links -->

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                 

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF">

            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="99%"  border="0">

                    <?php /*?><tr>

                        <td colspan="5" align="left" valign="top" class="tdSpace">

						

							<form id="frmPlaces" name="frmPlaces" method="post" action="<?php echo base_url(); ?>instance/home/metering" >

							<?php echo $this->lang->line('txt_Select_Place');?>					

                        	<select  name="places" id="places"  onchange="document.frmPlaces.submit()" >

							<option value=""  >Select</option>

							<?php $result = $this->metering_db_manager->getAllPlaces(); 

							

									foreach($result as $row)

							       { 

							

							?>

							

								<option value='<?php echo $row['workPlaceId'] ;?>' <?php if($placeId == $row['workPlaceId']) { echo 'selected'; } ?>  ><?php echo str_replace("_"," ",$row['companyName'])  ?></option>

							<?PHP } ?>

							

							</select>

							</form>

                        </td>

					</tr><?php */?>

              <?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

              <tr>

                <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              </tr>

              <?php

				}

				

				?>

          <?php     

		if(count($db_details) > 0)

		{

			$totalDbSize=0;

			$totalImportedFileSize=0;

		?>		

          <tr>

           <?php /*?> <td width="20%"><strong><?php echo $this->lang->line('txt_Month');?></strong></td>

            <td width="20%" align="left"><strong><?php echo $this->lang->line('txt_Data_Base_Size');?></strong></td>

            <td width="20%" align="left"><strong><?php echo $this->lang->line('txt_Total_Imported_File_Size');?> </strong></td>

          	<td width="20%" align="left"><strong><?php echo $this->lang->line('txt_Total_members');?></strong></td><?php */?>
			
			<td width="15%" align="left"><strong><?php echo $this->lang->line('txt_Workplace_Name'); ?></strong></td>
			
            <td width="28%" align="left"><strong><?php echo $this->lang->line('total_db_size_txt'); ?></strong></td>

            <td width="28%" align="left"><strong><?php echo $this->lang->line('total_imported_file_size_txt'); ?></strong></td>

          	<td width="28%" align="left" style="padding:0px;"><strong><?php echo $this->lang->line('total_members_txt'); ?></strong></td>

          </tr>
		  
		   <?php 
		  	foreach($db_details as $keyVal=>$data)
			{
			?>
			<tr style="line-height:22px;">
				<td nowrap width="15%"><?php echo $data['dbPlaceName']; ?></td>
				<td nowrap width="31%"><?php echo $data['dbSize']; ?></td>
				<td nowrap width="32%"><?php echo $data['importedFileSize']; ?></td>
	          	<td nowrap width="18%"><?php echo $data['membersCount']; ?></td>
			</tr>
			<?php
			}	  
		  ?>
		  

			<?php

			

			/*foreach($db_details as $keyVal=>$data)

			{

			

			   $totalDbSize=$totalDbSize+	$data['dbSize'];

			   $totalImportedFileSize=	$totalImportedFileSize+$data['importedFileSize'];		

			*/	

			?>		

			  <tr>

				<?php /*?><td><?php echo $data['month'];?></td>

				<td align="left"><?php echo $data['dbSize'];?></td>

				<td align="left"><?php echo $data['importedFileSize'];?></td>

			  	<td align="left"><?php echo $data['membersCount'];?></td><?php */?>
				
				<td align="left"><?php echo $db_details['dbSize'];?></td>

				<td align="left"><?php echo $db_details['importedFileSize'];?></td>

			  	<td align="left"><?php echo $db_details['membersCount'];?></td>

			  </tr>

		<?php

								

		/*	}*/

			

			?>		

			  <tr>

			 

				<?php /*?><td align="left"><strong><?php echo $this->lang->line('txt_Total');?></strong></td>

				<td align="left"><strong><?php echo $totalDbSize;?></strong></td>

				<td align="left"><strong><?php  echo  $totalImportedFileSize ;?></strong></td>

			  	<td align="left">&nbsp;</td>
<?php */?>
			  </tr>

		<?php

			

		}

		else

		{

		?>	

          <tr>

            <td colspan="4"><?php echo $this->lang->line('txt_None');?></td>          

          </tr>

		<?php

		}

		?>

            </table>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

         

        </table>

		<?php $this->load->view('common/footer');?>

   

</body>

</html>

