<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>
<script type="text/javascript">
	//Checking Update
	$(document).ready(function(){
		$('.update_content').hide();
		$(".set-pre-icon").fadeIn("slow");
		$("#check_for_update").html('<?php echo $this->lang->line('checking_updates_txt'); ?>');
		setTimeout(function() {
         	$('.update_content').show();
			$("#check_for_update").html('');
    	}, 1000);
		
	});

	
	//Showing loading icon on button click
	/*function loadImg()
	{
		$(".set-pre-icon").fadeIn("slow");
	}*/
	
	//For download update
	function download_update(version)
	{	
		
		//alert(version);
		version = version.split(",");
		$(".set-pre-icon").show();
		var fail;
		for(var i=0;i<version.length;i++) 
		{
			   
			 //alert(version[i]);
			 $.ajax({

				  url: baseUrl+'instance/auto_update/download_update/'+version[i],

				  success:function(result)
				 {
				  	//alert(result);
					if(result=='download_fail')
					{
						fail=1;
						var downloaded_ver = version.slice(0, i);
						var download_msg;
						if(downloaded_ver!='')
						{
							download_msg = '<span style="color:#099731"> version ('+downloaded_ver+')<?php echo ' '.$this->lang->line('txt_Update_download').'.<br>'; ?></span>';
						}
						else
						{
							download_msg='';
						}
						var failed_ver = version.slice(i, version.length);
						var failed_msg= 'version ('+failed_ver+')<?php echo ' '.$this->lang->line('txt_Download_Aborted'); ?>';
						
						$('.download_fail').html(download_msg+''+failed_msg);
					}
				 }
				  , 
				  async: false

		});
			if(fail==1)
			{
				break;
			}
		}
		$(".set-pre-icon").fadeOut("slow");
		if(fail!=1)
		{
			$(".download_saved").show();
			$("#download_result").show();
			$("#download_update").hide();
			$(".update_found").hide();
		}
					
		
		
		
	}
	//For install update 
	function install_update(version)
	{
		//alert(version);
		if (!confirm("<?php echo $this->lang->line('sure_to_install_updates'); ?>"))
		{
		  return false;
		}
		
		version = version.split(",");
		//return false;
		$(".set-pre-icon").show();
		var fail;
		for(var i=0;i<version.length;i++) 
		{
			
			//alert(version[i]);
			$.ajax({

				  url: baseUrl+'instance/auto_update/install_update/'+version[i],

				  success:function(result)
				  {
				  	//alert(result);
					//return false;
					if(result=='install_fail')
					{
						fail=1;
						var install_ver = version.slice(0, i);
						var install_msg;
						if(install_ver!='')
						{
							install_msg = '<span style="color:#099731"> version ('+install_ver+')<?php echo ' '.$this->lang->line('txt_Update_install').'.<br>'; ?></span>';
						}
						else
						{
							install_msg='';
						}
						var failed_ver = version.slice(i, version.length);
						var failed_msg= 'version ('+failed_ver+')<?php echo ' '.$this->lang->line('txt_Install_Aborted'); ?>';
						
						$('.install_fail').html(install_msg+''+failed_msg);
						return false;
					}
					else
					{
						//$(".set-pre-icon").fadeOut("slow");
				  		$(".success").html('<?php echo $this->lang->line('txt_Updated'); ?>'+' '+version[i]);
						$("#ajaxVersionHistory").html(result);
					}
				  
				  }, 
				 async: false

			});
			if(fail==1)
			{
				break;
			}
		}
		$(".set-pre-icon").fadeOut("slow");
		if(fail!=1)
		{
			//$("#install_result").html(result);
			$("#install_update").hide();
			$(".success").show();
			$(".download_detail").hide();
			$(".install_ready").hide();
			$(".current_ver").hide();
			$("#VersionHistory").hide();
			$("#ajaxVersionHistory").show();
		}
		
	}
	
	//No update : when user click on no button
	
	//For install update 
	function no_update(version)
	{
		version = version.split(",");
		//return false;
		$(".set-pre-icon").show();
		for(var i=0;i<version.length;i++) 
		{
			
			//alert(version[i]);
			$.ajax({

				  url: baseUrl+'instance/auto_update/no_update/'+version[i],

				  success:function(result)
				  {
				 	//$(".set-pre-icon").fadeOut("slow");
				  	//alert(result);
					$("#ajaxVersionHistory").html(result);
				  
				 }, 
				 async: false

			});
		}
		$(".set-pre-icon").fadeOut("slow");
		//$("#install_result").html(result);
		$("#install_update").hide();
		//$(".success").show();
		$(".download_detail").hide();
		$(".install_ready").hide();
		$(".current_ver").show();
		$("#VersionHistory").hide();
		$("#ajaxVersionHistory").show();
		
	}
	
	//For notify user about update installation
	function calNotifyUpdateCheck(thisVal)
	{
		if(thisVal.checked == true)
		{
			$(".notifyUpdateDate").datepicker("option", "disabled", false);
		}
		if (thisVal.checked!=true)
		{
			$(".notifyUpdateDate").datepicker("option", "disabled", true);
			$(".notifyUpdateDate").val('');
		}
	}
	
	function Notify_users(version)
	{
		var selected = $('#notify_users option:selected');
	
    	var notify_val = selected.val();
		//alert(notify_val);
		
		var dateVal=$('.notifyUpdateDate').val();
		//alert(dateVal);
		version = version.split(",");
		
		for(var i=0;i<version.length;i++) 
		{
			
			//alert(version[i]);
			$.ajax({

				  url: baseUrl+'instance/auto_update/notify_users/'+version[i],
				
				  type:'POST',
				  
				  data:{datetime: dateVal,notify_val: notify_val},

				  success:function(result)
				  {
				 	//alert(result);
					$("#ajaxVersionHistory").html(result);
				  }, 
				 async: false

			});
		}
		$("#install_update").hide();
		$(".download_detail").hide();
		$(".install_ready").hide();
		$(".current_ver").show();
		$("#VersionHistory").hide();
		$("#ajaxVersionHistory").show();
		
	}
	
	//For cancel install update notification 
	
	function cancel_notification(version)
	{
    	//alert(version);
		
			//alert(version[i]);
			$.ajax({

				  url: baseUrl+'instance/auto_update/cancel_notify/'+version,
				
				  success:function(result)
				  {
				 	//alert(result);
					$("#ajaxVersionHistory").html(result);
					$(".cancelNotifyTxt").html('<?php echo $this->lang->line('notification_cancel_successfully'); ?>');
				  }, 
				 async: false

			});
		$("#VersionHistory").hide();
		$("#ajaxVersionHistory").show();
	}
	
	// Wait for window load
	$(window).load(function()
	{
		$(".set-pre-icon").fadeOut("slow");
	});
	
</script>
</head>
<body>
<!-- Header -->
<?php $this->load->view('common/admin_header'); ?>
<table width="900px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" align="left" valign="top"><!-- Begin Top Links -->
      <?php 
	$this->load->view('instance/common/top_links');
?>
    </td>
  </tr>
  <tr>
    <td><div id="load_img" class="set-pre-icon"></div>
      <div id="check_for_update"></div>
      <div class="contents">
        <div class="update_content">
          <?php 
ini_set('max_execution_time',300);
?>
<div class="current_ver"><?php echo $this->lang->line('current_version_txt').$current_version; ?></div>
<?php
//Get version history 

//$version_history  = $this->identity_db_manager->getVersionHistory();	
foreach($version_history as $version_num)
{
	$version_num_arr[]=$version_num['versionNumber'];
}	
//print_r($version_num_arr);

//Start of chekcing empty file
if ($getVersion != '')
{	
	$getVersion=trim($getVersion);
	$versionList = explode("\n", $getVersion);	
	$version_arr = array();
	foreach ($versionList as $aV)
	{	
		
		$aV=trim($aV);
		//Start checking greator version
		
		if ( $aV > $current_version) {
			
			$version_install_arr[]=$aV;
			$found = true;			
			
		}
		//End of checking greator version
	 }
		
		if(count($version_install_arr)>1)
		{
			foreach($version_install_arr as $aV)
			{
				$newUpdate = file_get_contents($server_url.'TEEME-'.$aV.'.zip');
				$updateFileSize = round(((strlen($newUpdate))/1048576),2).' MB'; 
				if ( !in_array($aV, $version_num_arr) ) 
				{
					$version_download_arr[]=$aV;
				?>
          <div class="update_found">
            <p>New Update Found: <?php echo $aV.'  ('.$updateFileSize.')'; ?> </p>
          </div>
          <?php
		 		}
			}
			$version_download_str = implode(",", $version_download_arr);
			$version_install_str = implode(",", $version_install_arr);
			//Download The File If We Do Not Have It
			
			if (count($version_download_arr)>0) 
			{
				?>
          <div class="download_detail">
            <?php /*?><p>New Update Found: <?php echo $aV.'  ('.$updateFileSize.')'; ?> </p><?php */?>
            <a onclick="download_update('<?php echo $version_download_str; ?>')" id="download_update"><?php if (count($version_download_arr)==1) { ?>Download Update <?php }else
			{ ?>Download Updates<?php } ?></a>
            <div class="download_saved" style="display:none;"><?php if (count($version_download_arr)==1) { echo 'Update '; } else { echo 'Updates '; } echo '('.implode(",", $version_download_arr).')';  echo ' '.$this->lang->line('txt_Update_download'); ?></div>
            <div id="download_result" style="display:none;">
              <p class="install_ready"> <?php echo $this->lang->line('txt_Installs'); ?>
				  <a onclick="install_update('<?php echo $version_install_str; ?>')" id="install_update" class="install_option"> Yes</a>
				  <a class="install_option" onclick="no_update('<?php echo $version_install_str; ?>')"> Later</a>
				  <span id="notification_sec">
				  <span class="or_operate">OR</span>
				  </span>
				 
				  <div class="notify_user_txt"><?php echo $this->lang->line('txt_notify_update'); ?>
				  <span class="errorMsg"><?php //echo $this->lang->line('backup_Warning'); ?></span>
				  <input type="checkbox" name="install_notify_user" class="install_notify_user" onclick="calNotifyUpdateCheck(this)" />
				  <input name="nofify_update_date" type="text"  id="nofify_update_date" class="notifyUpdateDate" value="" readonly disabled="disabled">
				  </div>
				  
				  <div class="notify_user_txt"><?php echo $this->lang->line('txt_notify_users'); ?>
				  <select name="notify_users" id="notify_users">
				  	<option value="0">No</option>
					<option value="1">Yes</option>
				  </select>
				  </div>
				  <div class="notify_user_txt">
				  <a class="install_option" style="margin:0%;" onclick="Notify_users('<?php echo $version_download_str; ?>')"><?php echo $this->lang->line('txt_Done'); ?></a>
				  </div>
				 
			  </p>
            </div>
          </div>
		  <div class="download_fail"></div>
          <?php
			}
			
			//Download end
			//Installation process start (zip extract)
			else
			{
		  ?>
         <?php /*?> <p class="install_ready"> <?php echo $this->lang->line('txt_Installs'); ?><a onclick="install_update('<?php echo $version_install_str; ?>')" id="install_update" class="install_option"> Yes</a><a class="install_option" onclick="no_update('<?php echo $version_install_str; ?>')">No</a><span class="errorMsg"><?php //echo $this->lang->line('backup_Warning'); ?></span></p>
          <div id="install_result"></div><?php */?>
          <?php
				
				//Installation end
			}
			
			//End of else condition
			//break;
		}
		else 
		{
			if(count($version_install_arr)!=0)
			{
			//Download The File If We Do Not Have It
			$newUpdate = file_get_contents($server_url.'TEEME-'.$aV.'.zip');
			$updateFileSize = round(((strlen($newUpdate))/1048576),2).' MB'; 
			
			if ( !in_array($aV, $version_num_arr)) 
			{
			?>
          <div class="update_found">
            <p>New Update Found: <?php echo $aV.'  ('.$updateFileSize.')'; ?> </p>
          </div>
          <div class="download_detail"> <a onclick="download_update('<?php echo $aV; ?>')" id="download_update"><?php echo $this->lang->line('download_update_txt'); ?></a>
		  <div class="download_saved" style="display:none;"><?php echo 'Update '.$aV.' '; echo $this->lang->line('txt_Update_download'); ?></div>
            <div id="download_result" style="display:none;">
              <p class="install_ready"> <?php echo $this->lang->line('txt_Install'); ?>
				  <a onclick="install_update('<?php echo $aV; ?>')" id="install_update" class="install_option"> Yes</a>
				  <a class="install_option" onclick="no_update('<?php echo $aV; ?>')">Later</a>
				  <span class="or_operate">OR</span>
				  
				  <div class="notify_user_txt"><?php echo $this->lang->line('txt_notify_update'); ?>
				  <input type="checkbox" name="install_notify_user" class="install_notify_user" onclick="calNotifyUpdateCheck(this)" />
				  <input name="nofify_update_date" type="text"  id="nofify_update_date" class="notifyUpdateDate" value="" readonly disabled="disabled">
				  <span class="errorMsg"><?php //echo $this->lang->line('backup_Warning'); ?></span>
				  </div>
				  
				  <div class="notify_user_txt"><?php echo $this->lang->line('txt_notify_users'); ?>
				   <select name="notify_users" id="notify_users">
				  	<option value="0">No</option>
					<option value="1">Yes</option>
				  </select>
				  </div>
				  <div class="notify_user_txt">
				   <a class="install_option" style="margin:0%;" onclick="Notify_users('<?php echo $aV; ?>')"><?php echo $this->lang->line('txt_Done'); ?></a>
				  </div>
			 </p>
            </div>
          </div>
		   <div class="download_fail"></div>
          <?php
			}
			
			//Download end
			//Installation process start (zip extract)
			else
			{
		  ?>
          <?php /*?><p>Update already downloaded.</p>	<?php */?>
         <?php /*?> <p class="install_ready"> <?php echo $this->lang->line('txt_Install'); ?><a onclick="install_update('<?php echo $aV; ?>')" id="install_update" class="install_option"> Yes</a><a class="install_option" onclick="no_update('<?php echo $aV; ?>')">No</a><span class="errorMsg"><?php //echo $this->lang->line('backup_Warning'); ?></span></p>
          <div id="install_result"></div><?php */?>
          <?php
				
				//Installation end
			}
			
			//End of else condition
			
			//break;
			}
		}
	
	//End of foreach loop
	?>
          <p class="success" style="display:none;"></p><!--Teeme is now up to date.-->
          <?php
	
	if ($found != true)
	{
	?>
         <?php /*?> <p>Current version : <?php echo $current_version; ?> <br><?php */?>
            <?php echo $this->lang->line('txt_Uptodate'); ?> </p>
          <?php
	}
}
//End of checking empty file 
?>
</div>
<div id="ajaxVersionHistory" style="display:none;"></div>
<div id="VersionHistory">    
<?php
//Start showing of version history
$this->load->view('instance/getVersionHistory'); 
//End of version history
?>
</div>
      </div></td>
  </tr>
</table>
<!-- Footer -->
<?php  $this->load->view('common/footer');?>
<!--Added date time picker script here-->
<?php $this->load->view('common/datepicker_js.php');?>

</body>
</html>
<script>
//Manoj: Added date picker for user notification about install update

$(document).ready(function(){
	
	$('.notifyUpdateDate').datetimepicker({
			
			minDate:0,

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

	});
	
});
</script>