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

<script>

function get_maintenance_mode()
{

	//var ac=$('[name="maintenance_mode"]:checked').val();
		
	//var selected = $('#maintenance_mode option:selected');
	
    //alert(selected.val()); 
	//var mode_val = selected.val();
	
	var mode_val = $('[name="maintenance_mode"]:checked').val();
	
	if(mode_val==1)
	{
		if (!confirm("<?php echo $this->lang->line('offline_mode_confirm'); ?>"))
		{
		  return false;
		}
	}
	
	 $.ajax({

				  url: baseUrl+'instance/maintenance/save_maintenance_mode/'+mode_val,

				  success:function(result)
				  {
				  	$(".applyModeTxt").html('');
				  	if(result=='1')
					{
						//$(".applyModeTxt").html('Maintenance mode applied successfully.');
					}
				  }
				  , 
				  async: false

		});
	
}

function confirmAutoCheckbox(checkId,name,server)
{
	//alert(checkId);
	var checked = $("#"+checkId).is(':checked');
	
    if(checked) 
	{
		if(server=='remote')
		{
			if(!confirm('<?php echo $this->lang->line('sure_to_allow_txt'); ?>  '+name+' <?php echo $this->lang->line('remote_backup_txt'); ?>')){         
				$("#"+checkId).removeAttr('checked');
			}
			else 
			{
				$("#"+checkId).attr("checked", "checked");
			}
		}
		else
		{
			if(!confirm('<?php echo $this->lang->line('sure_to_activate_txt'); ?> '+name+' <?php echo $this->lang->line('automatic_backup_txt'); ?> ')){         
				$("#"+checkId).removeAttr('checked');
			}
			else 
			{
				$("#"+checkId).attr("checked", "checked");
			}
		}
    }
	else 
	{
       $("#"+checkId).removeAttr('checked');
    }
	
	var autoRemoteBackupStatus=$(".Auto_remote_backup").is(":checked");
	var manualRemoteBackupStatus=$(".Manual_remote_backup").is(":checked");
	var autoInstanceBackupStatus=$(".Auto_instance_backup").is(":checked");
	var autoPlaceBackupStatus=$(".Auto_place_backup").is(":checked");
		
	//alert(autoRemoteBackupStatus+'==='+manualRemoteBackupStatus+'==='+autoInstanceBackupStatus+'==='+autoPlaceBackupStatus);
	
	$.ajax({

				  url: baseUrl+'instance/home/add_backup_checks_status/',
				  type:'POST',
				  data: { auto_remote_status : autoRemoteBackupStatus, manual_remote_status : manualRemoteBackupStatus, 
				  autoInstanceBackupStatus : autoInstanceBackupStatus, autoPlaceBackupStatus : autoPlaceBackupStatus },
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

function addRemoteServerDetails() {

    // validation code here ...
		
		var ftp_host=$("#ftp_host").val();
		var ftp_user=$("#ftp_user").val();
		var ftp_backup_path=$("#ftp_backup_path").val();
		var ftp_pass=$("#ftp_password").val();
		
		if(ftp_host.length!=0 && ftp_user.length!=0 && ftp_backup_path.length!=0)
		{
			$.ajax({

				  url: baseUrl+'instance/home/add_remote_server_details/',
				  type:'POST',
				  data: { ftp_host : ftp_host, ftp_user : ftp_user, 
				  ftp_backup_path : ftp_backup_path, ftp_pass : ftp_pass },
				  success:function(result)
				  {
				 	//alert(result);
					if(result==1)
					{
						$(".formErrorMsg").hide();
						$(".formSuccessMsg").show();
					}
				  } 
			});
		}
		else
		{
			$(".formErrorMsg").html('<?php echo $this->lang->line('fill_Ftp_Details'); ?>');
			return false;
		}
}
</script>

</head>

<body>

<?php $this->load->view('common/admin_header'); ?>
<?php //print_r($remoteServerDetails); ?>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

  <tr>

    <td valign="top">

        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td align="left" valign="top">

			<!-- header -->	

			

			<!-- header -->	

			</td>

          </tr>

          <?php /*?><tr>

            <td align="left" valign="top">&nbsp;</td>

          </tr><?php */?>

        

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links');

					?>     

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="99%" border="0" cellpadding="6" cellspacing="6">

                    

                    <tr>

                		<td colspan="12" align="left">

						<?php //echo $this->lang->line('msg_workplaces_not_available');?>
				
						<?php /*?><table>
							<tr>
								<th style=" text-align: left;">
									<?php echo $this->lang->line('maintenance_mode_txt'); ?>
								</th>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('txt_maintenance_mode_label'); ?> 
									<span class="postTimeStamp">
									<?php echo '('.$this->lang->line('maintenance_mode_small_txt').')'; ?>
									</span>
								</td>
								<td>
									
							  <input type="radio" name="maintenance_mode" value="1" <?php if($offline_mode=='1') { echo 'checked'; }?> onchange="get_maintenance_mode()">Yes</input>
                              <input type="radio" name="maintenance_mode" value="0" <?php if($offline_mode=='0') { echo 'checked'; }?> onchange="get_maintenance_mode()">No</input>
								</td>
							</tr>
						</table>
						<div style="float:left;width:100%; height:20px; ">
								<div style=" margin-top:12px;border-bottom:1px dotted gray; "></div>
						</div><?php */?>
						<table>
							<tr>
								<th style=" text-align: left;">
								<?php if(!empty($remoteServerDetails))
								{ ?>
								<?php echo $this->lang->line('edit_remote_server_details'); ?>
								<?php } else { ?>
								<?php echo $this->lang->line('add_remote_server_details'); ?>
								<?php } ?>
								</th>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('host_name_txt'); ?>
								</td>
								<td>
									<input type="text" name="ftp_host" id="ftp_host" value="<?php echo $remoteServerDetails['config_value']['ftp_host']; ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('user_name_txt'); ?>
								</td>
								<td>
									<input type="text" name="ftp_user" id="ftp_user" value="<?php echo $remoteServerDetails['config_value']['ftp_user']; ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('password_txt'); ?>
								</td>
								<td>
									<input type="text" name="ftp_password" id="ftp_password" value="<?php echo $remoteServerDetails['config_value']['ftp_password']; ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('remote_server_path'); ?>
								</td>
								<td>
									<input type="text" name="ftp_backup_path" id="ftp_backup_path" value="<?php echo $remoteServerDetails['config_value']['ftp_backup_path']; ?>"/>
								</td>
							</tr>
							
							<tr>
								<td>
									<input type="button" onclick="addRemoteServerDetails();" id="addDetails" value="<?php if(!empty($remoteServerDetails)){ ?> <?php echo $this->lang->line('txt_Edit'); ?> <?php } else { ?> <?php echo $this->lang->line('txt_Add'); ?> <?php } ?> "/>
								</td>
							</tr>
							
							<tr>
								<td colspan="5">
                					<span class="formSuccessMsg" style="display:none;">
										<?php if(!empty($remoteServerDetails)){ echo $this->lang->line('remote_Server_Details_Updated'); } else { echo $this->lang->line('remote_Server_Details_Inserted'); } ?>
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="5">
                					<span class="formErrorMsg"></span>
								</td>
							</tr>
							</table>
                					<div style="float:left;width:100%; height:20px; ">
										<div style=" margin-top:12px;border-bottom:1px dotted gray; "></div>
									</div>
							<table>
							<tr>
								<th style=" text-align: left;">
                					<?php echo $this->lang->line('configuration_txt'); ?>
								</th>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('allow_manual_remote_backup'); ?>
								</td>
								<td>
									<input type="checkbox" id="manual_remote_backup" class="Manual_remote_backup" <?php if($backupChecksDetails['config_value']['manual_remote_backup_status']=='true'){ echo 'checked';} ?> onchange="confirmAutoCheckbox('manual_remote_backup','manual','remote');"/>
								</td>
								
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('allow_automatic_remote_backup'); ?>
								</td>
								<td>
									<input type="checkbox" id="auto_remote_backup" class="Auto_remote_backup" <?php if($backupChecksDetails['config_value']['auto_remote_backup_status']=='true'){ echo 'checked';} ?> onchange="confirmAutoCheckbox('auto_remote_backup','automatic','remote');"/>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('activate_automatic_instance_backup'); ?>
								</td>
								<td>
									<input type="checkbox" id="auto_instance_check" class="Auto_instance_backup" <?php if($backupChecksDetails['config_value']['autoInstanceBackupStatus']=='true'){ echo 'checked';} ?> onchange="confirmAutoCheckbox('auto_instance_check','instance');"/>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('activate_automatic_place_backup'); ?> 
								</td>
								<td>
									<input type="checkbox" id="auto_place_check" class="Auto_place_backup" <?php if($backupChecksDetails['config_value']['autoPlaceBackupStatus']=='true'){ echo 'checked';} ?> onchange="confirmAutoCheckbox('auto_place_check','place');"/>
								</td>
							</tr>
							
							</table>
                					<div style="float:left;width:100%; height:20px; ">
										<div style=" margin-top:12px;border-bottom:1px dotted gray; "></div>
									</div>
							<table>
							<tr>
								<th style=" text-align: left;">
									<?php echo $this->lang->line('backups_txt'); ?> 
								</th>
							</tr>
						
							</table>

                    	
						
						
						
						<form method="post" action="" style="margin-top:0%">
							
							<input type="submit" name="backup" value="Create New Backup" style="margin-top:1%;" onclick="document.getElementById('please_wait').style.display='';"/>

                    	</form>
                    <!--onclick="document.getElementById('please_wait').style.display='';"-->

                    	<span id="please_wait" style="display:none;">

                    		<?php echo $this->lang->line('please_wait_txt'); ?> 

                    	</span>

                		</td>

              		</tr>


				 <?php
				//Manoj: code to show the status of backup
				
				
				if( $Instance_Backup_Fail!='false' && $Remote_Backup_Fail=='false')
				{
				?>

              	<tr>
					<td colspan="5" class="tdSpace"><span class="successMsg"><?php echo  $this->lang->line('current_server_backup_success'); ?></span></td>
				</tr>
				<tr>
					<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('Remote_backup_failed'); ?></span></td>
				</tr>

              	<?php				
				}
				else if($Instance_Backup_Fail=='false' && $Remote_Backup_Fail=='false')

				{

				?>

              	<tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('current_server_backup_failed'); ?></span></td>
				</tr>
				<tr>
					<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('Remote_backup_failed'); ?></span></td>
				</tr>

              	<?php

				}
				else if($Instance_Backup_Fail=='false')

				{

				?>

              	<tr>
					<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $this->lang->line('current_server_backup_failed'); ?></span></td>
				</tr>
				
				<?php

				}
				else if($Remote_Backup_Sucess==1 && $Instance_Backup_Success==1)
				{
				?>

              	<tr>

                	<td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('current_server_backup_success'); ?></span></td>
				</tr>
				<tr>
					<td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('Remote_backup_success'); ?></span></td>

              	</tr>

              	<?php				
				}
				else if($Instance_Backup_Success==1)
				{
				?>

              	<tr>
					<td colspan="5" class="tdSpace"><span class="successMsg"><?php echo $this->lang->line('current_server_backup_success'); ?></span></td>
				</tr>
				
				<?php				
				}
				
				if(isset($_SESSION['ftpErrorMsg']) && $_SESSION['ftpErrorMsg'] !=	"")

				{

				?>

              	<tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['ftpErrorMsg']; $_SESSION['ftpErrorMsg'] ='';?></span></td>

              	</tr>

              	<?php

				}
				
				//Manoj: showing backup status end
				
				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

              	<?php /*?><tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg"><?php //echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              	</tr><?php */?>

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

              	<?php /*?><tr>

                	<td colspan="5" class="tdSpace"><span class="errorMsg">Total size of the backup = <?php echo $filesize;?> MB</span></td>

              	</tr><?php */?>	
				
				<?php

				}

				?>
				
            <?php

			if(count($backupDetails) > 0)

			{

			?>

              <tr>

                <td><strong><?php echo $this->lang->line('backup_id_txt'); ?></strong></td>

                <td><strong><?php echo $this->lang->line('backup_name_txt'); ?> </strong></td>

                <td><strong><?php echo $this->lang->line('backup_size_txt'); ?> </strong></td>

                <td><strong><?php echo $this->lang->line('backup_date_txt'); ?> </strong></td>
				
				<td><strong><?php echo $this->lang->line('backup_date_type'); ?> </strong></td>
				
				<td><strong><?php echo $this->lang->line('remote_server_txt'); ?> </strong></td>

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
			
				<!--Manoj: Showing backup type-->
				<td><?php 
					$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
					$path = $configBackupDir;
					if ($handle = opendir($path)) {
					
						while (false !== ($file = readdir($handle))) { 
							if($file==$backupData['filename'])
							{
								$val=$this->lang->line('automatic_txt');
								break;
							}
							else
							{
								$val=$this->lang->line('manual_txt');
							}	
						}
						echo $val;
					
						closedir($handle); 
					} ?></td>
					
					<td>
					<?php 
						echo $backupData['remoteServer']['ftp_host'];
					?>
					</td>
					<!--Manoj: code end-->

                <td align="center">

                	<a href="<?php echo base_url();?>instance/home/downloadBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/download.gif" alt="<?php echo $this->lang->line('txt_Download');?>" title="<?php echo $this->lang->line('txt_Download');?>" border="0" style="cursor:pointer;"></a>

					&nbsp;<a href="<?php echo base_url();?>instance/home/deleteBackup/<?php echo $backupData['filename'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" onClick="return confirmDelete()" border="0" style="cursor:pointer;"></a>

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

