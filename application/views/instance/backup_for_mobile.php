<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Backups</title>

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

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>

<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links_for_mobile');

					?>     

					<!-- End Top Links -->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

  <tr>

    <td valign="top">

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td align="left" valign="top">

			<!-- header -->	

			

			<!-- header -->	

			</td>

          </tr>

          <tr>

            <td align="left" valign="top">&nbsp;</td>

          </tr>

        

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="99%" border="0" cellpadding="6" cellspacing="6">

                    

                    <tr>

                		<td colspan="5" align="left">

						<?php //echo $this->lang->line('msg_workplaces_not_available');?>

                    	<form method="post" action="">

                    		<input type="submit" name="backup" value="Create New Backup" onclick="document.getElementById('please_wait').style.display='';" />

                    	</form>

                    

                    	<span id="please_wait" style="display:none;">

                    		Please wait while the backup is being created. Don't refresh or close this page. This could take a while.....

                    	</span>

                		</td>

              		</tr>

                    

                <?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

              	<tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              	</tr>

              	<?php

				}

				if ($success==1)

				{

/*					header('Content-Type: application/octet-stream');

					header('Content-Length: '.$filesize);

					header('Content-Disposition: attachment; filename='.$filename);

					header('Content-Transfer-Encoding: binary');

					readfile($filename);*/

				?>

              	<tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg">Total size of the backup = <?php echo $filesize;?> MB</span></td>

              	</tr>	

              	<?php

				}

				?>

            <?php

			if(count($backupDetails) > 0)

			{

			?>

              <tr>

                <td><strong><?php echo 'Backup Id';?></strong></td>

                <td><strong><?php echo 'Backup Name'; ?> </strong></td>

                <td><strong><?php echo 'Backup Size';?> </strong></td>

                <td><strong><?php echo 'Backup Date';?> </strong></td>

                <td align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

              </tr>

              <?php

			$i = 1;

			foreach($backupDetails as $keyVal=>$backupData)

			{				

			?>

              <tr>

                <td><?php echo $backupData['backupId'];?></td>

                <td><?php echo $backupData['filename'];?></td>

                <td><?php echo $backupData['filesize'];?> MB</td>

                <td><?php echo $this->time_manager->getUserTimeFromGMTTime($backupData['createdDate'], 'm-d-Y h:i A');?></td>

                <td align="center">

                	<a href="<?php echo base_url();?>instance/home/downloadBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/download.gif" alt="<?php echo $this->lang->line('txt_Download');?>" title="<?php echo $this->lang->line('txt_Download');?>" border="0" style="cursor:pointer;"></a>

					&nbsp;<a href="<?php echo base_url();?>instance/home/deleteBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0" style="cursor:pointer;"></a>

                </td>

              </tr>

              <?php

				$i++;					

			}

		}

		?>





            </table>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

          

          

        </table>

    </td>

  </tr>

</table>

<?php $this->load->view('common/footer');?>

</body>

</html>

