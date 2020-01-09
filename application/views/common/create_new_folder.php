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
		<?php 
		$workSpaceId = $this->uri->segment(3);
		$workSpaceType = $this->uri->segment(4);
		?>
		<div style="margin: 15px 25px 25px 25px;">
			<div>
				<span style="color: #222; font-size: 20px;"><?php echo $this->lang->line('txt_new_folder'); ?></span>
			</div>
			<br/>
			<div style="overflow: auto;">
				<input id="cf_input" style="width: 98%; height: 25px;" type="text" name="folderName" />
				<br/>
				<span id="loaderCreateFolder" style="display: none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></span>
				<span id="cf_error_message" class="errorMsg"></span>
				<span id="cf_success_message" class="successMsg"></span>
			</div>
			<br/>
			<div style="text-align: right;" class="btn-group">
				<div id="beforCreateFolder" style="display: inline;">
					<span class="upload-btn-wrapper">
						<button class="upload-file-btn" onclick="createNewFolder('<?php echo $workSpaceId; ?>', '<?php echo $workSpaceType; ?>')"><?php echo $this->lang->line('txt_Create'); ?></button>
					</span>
					<span class="upload-btn-wrapper">
						<button class="cancel-file-btn" onclick="cfPopupHide()"><?php echo $this->lang->line('txt_Cancel'); ?></button>
					</span>
				</div>
				
			</div>
		</div>
 	</body>
 </html>
 <script type="text/javascript">
 	// $(document).ready(function() { 
 	// 	window.localStorage.removeItem('create_folder_yes');
 	// });
 	// $("#popCloseBox",parent.document).click(function(){

 	// 	var reloadWin = window.localStorage.getItem('create_folder_yes');
 	// 	if(reloadWin == 'yes')
 	// 	{
 	// 		var baseUrl = '<?php echo base_url(); ?>';
 	// 		var workSpaceId = '<?php echo $this->uri->segment(3); ?>';
 	// 		var workSpaceType = '<?php echo $this->uri->segment(4); ?>';
 	// 		var folderId = '<?php echo $this->uri->segment(6); ?>';
 	// 		window.top.location.href = baseUrl+"external_docs/index/"+workSpaceId+"/type/"+workSpaceType+"/1"; 
 	// 	}
 		
 	// });
 	function cfPopupHide()
 	{
 		$('#popupMask',parent.document).remove();
		$('#popupContainer',parent.document).remove();
 	}

	function createNewFolder(workSpaceId, workSpaceType)
	{
		document.getElementById('cf_error_message').innerHTML="";

		document.getElementById('loaderCreateFolder').style.display="inline";

		var folderName = document.getElementById('cf_input').value;
		if(folderName.trim() == "")
		{
			document.getElementById('loaderCreateFolder').style.display = "none";
			document.getElementById('cf_error_message').innerHTML="Folder name cannot be empty.";
		}
		else
		{	
			var letters = /^[a-zA-Z]/;
			if(folderName.match(letters))
			{
				
				var baseUrl = '<?php echo base_url(); ?>';

				folder_data='folderName='+folderName+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType;

				var request = $.ajax({

				    url: baseUrl+"external_docs/createNewFolder/"+workSpaceId+"/type/"+workSpaceType,

				    type: "POST",

				    data: folder_data,

				    dataType: "json",
				  
				    //async:false,
				    async:true,

				    success:function(result)
				    { 
				    	document.getElementById('loaderCreateFolder').style.display = "none";
				        if(result['message'] == "success"){
				        	document.getElementById('beforCreateFolder').style.display = "none";
				        	window.localStorage.setItem('create_folder_id', result['folderId']);
				        	document.getElementById('cf_success_message').innerHTML="Folder has been created successfully.";

				        	var workSpaceDetails 	= result['workSpaceDetails'];
				        	var workPlaceDetails 	= result['workPlaceDetails'];
				        	var folderId 			= result['folderId'];
				        	var foldersDetailDocs 	= result['foldersDetailDocs'];
				        	var externalDocs 		= result['externalDocs'];
				        	var folName 			= result['folName'];

				        	//var editFolderName 		= result['editFolderName'];
				        	var editFolderName = result['rootFolderName'];
					        var rootFolderId = result['rootFolderId'];
					        var rootFolderTitleName = result['rootFolderTitleName'];

				        	if(folderId == "" || folderId == 0)
					        {
					        	var folderActive = "folderActive";
					        	folderId = 0;
					        }
					        else
					        {
					        	var folderActive = "";
					        }
					        var folderData = '<span class="folderSpan '+folderActive+'"><a href="<?php echo base_url()?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+rootFolderId+'" title="'+rootFolderTitleName+'"><img src="<?php echo base_url();?>images/folder_icon_new.png" alt="" title="" border="0"> <p class="folder-name-text">'+ editFolderName +'</p></a></span>&nbsp;&nbsp;&nbsp;&nbsp;';

					        if(foldersDetailDocs.length > 1)
					        {
					        	folderData += '<span class="folderSepraterIcon">&#10148;</span>&nbsp;&nbsp;&nbsp;';
					        }

					        for(i = 0; i < foldersDetailDocs.length; i++)
					        {
					        	var docDataFolderId = foldersDetailDocs[i]['folderId'];
					        	if(rootFolderId!=docDataFolderId)
					        	{
						        	var docDataName 	= foldersDetailDocs[i]['name'];

						        	var editFolderName  = foldersDetailDocs[i]['editFolderName'];

						        	var folderOrignatorId 	= foldersDetailDocs[i]['userId'];

						        	var logInUserId = '<?php echo $_SESSION['userId']; ?>';

						        	var sessionWPManagerAccess = "<?php echo $_SESSION['WPManagerAccess']; ?>";
					        		var wsManagerAccess = result['wsManagerAccess']; 


						        	if(folderId == docDataFolderId)
							        {
							        	var folderActive = "folderActive";
							        }
							        else
							        {
							        	var folderActive = "folderInactive";
							        }

							        var folderRenameUrl = "'"+baseUrl+"external_docs/folder_delete_rename_popup/"+workSpaceId+"/"+workSpaceType+"/"+docDataFolderId+"'";

						        	folderData += '<span class='+folderActive+' style="display:inline-block; margin-top:10px;" ><a href="<?php echo base_url()?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+docDataFolderId+'" title="'+docDataName+'"><img src="<?php echo base_url();?>images/folder_icon_new.png" alt="" title="" border="0"> <p class="folder-name-text">'+editFolderName+'</p></a>';


						        	if(sessionWPManagerAccess || wsManagerAccess ||folderOrignatorId == logInUserId)
						        	{

						        		folderData += '<a class="folderActionBut" onclick="showPopWin('+folderRenameUrl+', 320, 200, null)"><img src="<?php echo base_url();?>images/dot_action_1.png" alt="" title="Edit" border="0"></a>';
						        	}

						        	folderData += '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						        }
					        }

					        var fileData = '<div><span class="fileFolderLabel"><?php echo $this->lang->line('txt_files');?> ('+externalDocs.length+')</span><span class="fileSearchBox"><form name="searchForm" method="post" action="<?php echo base_url()?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'" enctype="multipart/form-data" onSubmit="return validateExternalDocs()"><input type="text" name="searchDocs" value="<?php echo $searchDocs;?>" maxlength="100" size="50" class="fileSearchInput" placeholder="Search '+folName+'" >&nbsp;<input type="submit" name="Search" value="<?php echo $this->lang->line("txt_Search");?>" class="button01"></form></span></div><br/>';

					        if(externalDocs.length > 0)
					        {
					        	fileData += '<div class="file-row-active-header"><span class="file-row-active-header-inner1"></span><span class="file-row-active-header-inner2"> <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/1"><?php echo $this->lang->line("txt_Name");?></a></span> </span><span class="file-row-active-header-inner3"><span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/2"><?php echo $this->lang->line("txt_By");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/3"><?php echo $this->lang->line("txt_Date");?></a></span> </span><span class="file-row-active-header-inner6"><span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/4"><?php echo $this->lang->line("txt_Order");?></a></span> </span><span class="file-row-active-header-inner5"><span class="action-heading-grey"><a href="JavaScript:void(0);"><?php echo $this->lang->line("txt_Action");?></a></span></span></div>';

					        	var rowColor1	= "file-row-active-middle1";
								var rowColor2	= "file-row-active-middle2";	
								var k = 1;

								for(i = 0; i < externalDocs.length; i++)
					        	{
					        		if(externalDocs[i]['is_image'] == 1)
					        		{
					        			var fileInfo = '<br/><span class="fileInfo">'+externalDocs[i]["size"]+' '+externalDocs[i]["size_type"]+'&nbsp;&nbsp;'+externalDocs[i]["width"]+' x '+externalDocs[i]["height"]+' pixels</span>';
					        		}
					        		else
					        		{
					        			var fileInfo = '<br/><span class="fileInfo">'+externalDocs[i]["size"]+externalDocs[i]["size_type"]+'</span>';
					        		}

					        		var fileOrder = "NA";
					        		if(externalDocs[i]["fileOrder"]>0)
					        		{
					        			fileOrder = externalDocs[i]["fileOrder"];
					        		}
					        		
					        		var rowColor = k%2 ? rowColor1 : rowColor2;

					        		var url = "'"+baseUrl+"workplaces/"+workPlaceDetails["companyName"]+"/"+externalDocs[i]['docPath']+externalDocs[i]['docName']+"'";

					        		fileData += '<div class='+rowColor+'><span class="file-row-active-header-inner1"><img src='+externalDocs[i]['thumbnailUrl']+' border="0"></span><span class="file-row-active-header-inner2" style="word-wrap: break-word;" ><a href='+url+' target="_blank">'+externalDocs[i]['docName']+'</a>'+fileInfo+'</span><span class="file-row-active-header-inner3"><span>'+externalDocs[i]["userTagName"]+'</span></span><span class="file-row-active-header-inner4"><span>'+externalDocs[i]["docCreatedDate"]+'</span> </span><span class="file-row-active-header-inner6"><span>'+fileOrder+'</span></span><span class="file-row-active-header-inner5"><a href="javascript:void(0)" onClick="fileUrlCopy('+url+')" title="<?php echo $this->lang->line("txt_copy_url"); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/copy_icon_new.png" alt="<?php echo $this->lang->line("txt_copy_url"); ?>" title="<?php echo $this->lang->line("txt_copy_url"); ?>" border="0"></a>';						

					        		var sessionWPManagerAccess = "<?php echo $_SESSION['WPManagerAccess']; ?>";
					        		var wsManagerAccess = result['wsManagerAccess']; 

					        		var fileOrignatorId = externalDocs[i]['userId'];

						        	var logInUserId = '<?php echo $_SESSION['userId']; ?>';

									if(sessionWPManagerAccess || workSpaceId == 0 || wsManagerAccess || fileOrignatorId == logInUserId)
									{
										var deleteUrl = "'"+baseUrl+"external_docs/delete_file_popup/"+workSpaceId+"/"+workSpaceType+"/"+externalDocs[i]["docId"]+"/"+externalDocs[i]["folderId"]+"'";

										fileData += '&nbsp;&nbsp;<span style="cursor: pointer;"><img src="<?php echo base_url();?>images/trash.gif" alt="<?php echo $this->lang->line("txt_Delete");?>" title="<?php echo $this->lang->line("txt_Delete");?>" border="0" onclick="showPopWin('+deleteUrl+',300,160,null)"></span>';
									}
								
									fileData += '</span></div><div class="clr"></div>';

									k++;
					        	}
					        }
					        else
							{
								fileData += '<div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line("txt_None");?></span></div>';
							}

				        	$("#folderDataDiv",parent.document).html(folderData);

				        	$("#fileDataDiv",parent.document).html(fileData);

				        	$("#folCountDis",parent.document).html(foldersDetailDocs.length);
				   			// $('#popupMask',parent.document).remove();
							// $('#popupContainer',parent.document).remove();
				        }
				        else if(result['message'] == "already_exist")
				        {
				        	document.getElementById('cf_error_message').innerHTML="Folder already exists.";
				        }
				        else if(result['message'] == "blank")
				        {
				        	document.getElementById('cf_error_message').innerHTML="Folder name cannot be empty.";
				        }
				        else if(result['message'] == "fail")
				        {
				        	document.getElementById('cf_error_message').innerHTML="Folder not created.";
				        }
				        else
				        {
				           document.getElementById('cf_error_message').innerHTML="Internal server error.";
				        }
				    }
			    });

				return true; 

			}
			else
			{
				document.getElementById('loaderCreateFolder').style.display = "none";
				document.getElementById('cf_error_message').innerHTML="Folder name start with character.";
			}
		}
	}
</script>
