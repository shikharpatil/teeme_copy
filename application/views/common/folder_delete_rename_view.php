<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
		<script Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"> </script>
	</head>
	<body>
		
		<div style="margin: 5px 25px 5px 25px;">
			<div>
				<div>
					<span style="color: #222; font-size: 18px;">
						Rename Folder
					</span>
					<span id="deleteFolderIcon">
						<span style="font-size: 20px; padding: 0 5px;">|</span>
						<span>
							<a href="javascript:void(0)" onClick="deleteFolderConfirm()" title="Delete folder" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="" title="Delete folder" border="0"></a>
						</span>
					</span>
				</div>
				<hr style="height: 1px;  border: none; background-color: #c6c6c6;"/>
				
				<div>
					
					<input style="height: 25px;" type="text" id="new_folder_name" name="new_folder_name" value="<?php echo $oldFolderName; ?>">
					
					<span id="doneButton" class="upload-btn-wrapper" style="padding-top: 5px; overflow:visible;">
						<button class="upload-file-btn" onclick="renameFolderUpdate('<?php echo $oldFolderName; ?>', '<?php echo $folderId; ?>', '<?php echo $workSpaceId; ?>', '<?php echo $workSpaceType; ?>')"><?php echo $this->lang->line('txt_Done'); ?></button>
					</span>
					<br/>
					<span id="fr_message" class="errorMsg"></span>
				</div>
				<br/>
			</div>
			<br/>
			<div>
				<div id="deleteFolderConfirmation" style="display: none;">
					<span style="font-size: 16px;"><?php echo $this->lang->line('txt_delete_folder_confirmation_message'); ?></span>
					<br/>
					<span class="upload-btn-wrapper">
						<button class="upload-file-btn" onclick="deleteFolder('<?php echo $folderId; ?>', '<?php echo $workSpaceId; ?>', '<?php echo $workSpaceType; ?>')"><?php echo $this->lang->line('txt_Yes'); ?></button>
					</span>
					<span class="upload-btn-wrapper">
						<button class="cancel-file-btn" onclick="deleteFolderCancel()"><?php echo $this->lang->line('txt_No'); ?></button>
					</span>
					<span id="loaderDeleteFolder" style="display: none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></span>
				</div>
				<br/>
				<span id="fd_message" class="errorMsg"></span>
			</div>
		</div>
 	</body>
 </html>
<script>
function renameFolderUpdate(oldFolderName, folderId, workSpaceId, workSpaceType)
{
	document.getElementById('fd_message').innerHTML="";
	var newFolderName = document.getElementById('new_folder_name').value;

	if(newFolderName.trim() == "")
	{
		document.getElementById('fr_message').innerHTML="Folder name cannot be empty.";
	}
	else
	{
		if(oldFolderName==newFolderName)
		{
			document.getElementById('fr_message').innerHTML="Folder name not change";
		}
		else
		{
			var letters = /^[a-zA-Z]/;
			if(newFolderName.match(letters))
			{
				var baseUrl = '<?php echo base_url(); ?>';

				folder_data='oldFolderName='+oldFolderName+"&newFolderName="+newFolderName+"&folderId="+folderId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType;

				var request = $.ajax({

				    url: baseUrl+"external_docs/folderRename",

				    type: "POST",

				    data: folder_data,

				    dataType: "html",
				  
				    success:function(result)
				    {
				    	if(result==1)
				    	{
				    		parent.location.reload();
				    	}
				    	else
				    	{
				    		document.getElementById('fr_message').innerHTML=result;
				    	}
				    }
				})
			}
			else
			{
				document.getElementById('fr_message').innerHTML="Folder name start with character.";
			}
		}
	}
}

function deleteFolderConfirm()
{
	document.getElementById('fr_message').innerHTML="";
	document.getElementById('deleteFolderIcon').style.display = "none";
	document.getElementById('deleteFolderConfirmation').style.display = "inline";
}
function deleteFolderCancel()
{
	document.getElementById('deleteFolderIcon').style.display = "inline";
	document.getElementById('deleteFolderConfirmation').style.display = "none";
}

function deleteFolder(folderId, workSpaceId, workSpaceType)
{
	document.getElementById('loaderDeleteFolder').style.display="inline";
	document.getElementById('deleteFolderConfirmation').style.display = "none";

	var baseUrl = '<?php echo base_url(); ?>';

	folder_data="folderId="+folderId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType;

	var request = $.ajax({

	    url: baseUrl+"external_docs/folderDelete",

	    type: "POST",

	    data: folder_data,

	    dataType: "html",
	  
	    success:function(result)
	    {

	    	if(result==1)
	    	{
	    		// parent.location.reload();
	    		window.top.location.href = baseUrl+'external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1';
	    	}
	    	else
	    	{
	    		document.getElementById('loaderDeleteFolder').style.display="none";
	    		document.getElementById('deleteFolderIcon').style.display = "inline";
	    		document.getElementById('fd_message').innerHTML=result;
	    	}
	    }
	})
}

</script>
