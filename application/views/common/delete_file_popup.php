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
		$docId = $this->uri->segment(5);
		$folderId = $this->uri->segment(6);
		?>
		<div style="margin: 15px 25px 25px 25px;">
			<div>
				<span id="confimationMessage" style="color: #222; font-size: 20px; display: inline;"><?php echo $this->lang->line('txt_delete_file_confirmation_message'); ?></span>
				<br/>
				<span id="loaderFileDelete" style="display:none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></span>
				<span id="df_message" class="successMsg"></span>
			</div>
			<br/>
			<div style="text-align: right;" class="btn-group">
				<div id="beforFileDelete" style="display: inline;">
					<span class="upload-btn-wrapper">
						<button class="upload-file-btn" onclick="deleteFile('<?php echo $workSpaceId; ?>', '<?php echo $workSpaceType; ?>', '<?php echo $docId; ?>', '<?php echo $folderId; ?>')"><?php echo $this->lang->line('txt_Yes'); ?></button>
					</span>
					<span class="upload-btn-wrapper">
						<button class="cancel-file-btn" onclick="dfPopupHide()"><?php echo $this->lang->line('txt_No'); ?></button>
					</span>
				</div>
			</div>
		</div>
 	</body>
 </html>
 <script type="text/javascript">
 	// $(document).ready(function() { 
 	// 	window.localStorage.removeItem('delete_yes');
 	// });
 	// $("#popCloseBox",parent.document).click(function(){

 	// 	var reloadWin = window.localStorage.getItem('delete_yes');
 	// 	if(reloadWin == 'yes')
 	// 	{
 	// 		var baseUrl = '<?php echo base_url(); ?>';
 	// 		var workSpaceId = '<?php echo $this->uri->segment(3); ?>';
 	// 		var workSpaceType = '<?php echo $this->uri->segment(4); ?>';
 	// 		var folderId = '<?php echo $this->uri->segment(6); ?>';
 	// 		window.top.location.href = baseUrl+"external_docs/index/"+workSpaceId+"/type/"+workSpaceType+"/1/"+folderId; 
 	// 	}
 		
 	// });

 	function dfPopupHide()
 	{
 		$('#popupMask',parent.document).remove();
		$('#popupContainer',parent.document).remove();	
 	}

	function deleteFile(workSpaceId, workSpaceType, docId, folderId)
	{
		document.getElementById('df_message').innerHTML="";

		document.getElementById('beforFileDelete').style.display = "none";

		document.getElementById('loaderFileDelete').style.display = "inline";

		var baseUrl = '<?php echo base_url(); ?>';

		folder_data='';

		var request = $.ajax({

		    url: baseUrl+"delete_ext_file/index/"+workSpaceId+"/"+workSpaceType+"/"+docId+"/"+folderId,

		    type: "POST",

		    data: folder_data,

		    dataType: "json",
		  
		    // async:false,
		    async:true,

		    success:function(result)
		    { 
		    	// window.localStorage.setItem('delete_yes', 'yes');
		    	document.getElementById('loaderFileDelete').style.display = "none";
		    	document.getElementById('confimationMessage').style.display = "none"; 
		        if(result['message'] == "success"){
		        	
		        	document.getElementById('df_message').innerHTML="File has been deleted successfully.";

			        var workPlaceDetails 	= result['workPlaceDetails'];
			        var externalDocs 		= result['externalDocs'];
			        var folName 			= result['folName'];

		        	var fileData = '<div><span class="fileFolderLabel"><?php echo $this->lang->line('txt_files');?> ('+externalDocs.length+')</span><span class="fileSearchBox"><form name="searchForm" method="post" action="<?php echo base_url()?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'" enctype="multipart/form-data" onSubmit="return validateExternalDocs()"><input type="text" name="searchDocs" value="<?php echo $searchDocs;?>" maxlength="100" size="50" class="fileSearchInput" placeholder="Search '+folName+'" >&nbsp;<input type="submit" name="Search" value="<?php echo $this->lang->line("txt_Search");?>" class="button01"></form></span></div><br/>';

			        if(externalDocs.length > 0)
			        {
			        	fileData += '<div class="file-row-active-header"><span class="file-row-active-header-inner6"><span class="<?php if ($_SESSION["sortBy"]==4) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/4"><?php echo $this->lang->line("txt_Order");?></a></span> </span><span class="file-row-active-header-inner1"></span></span><span class="file-row-active-header-inner2"> <span class="<?php if ($_SESSION["sortBy"]==1) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/1"><?php echo $this->lang->line("txt_Name");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION["sortBy"]==3) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/3"><?php echo $this->lang->line("txt_Uploaded_Date");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION["sortBy"]==5) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/5"><?php echo $this->lang->line("txt_Last_Modified_Date");?></a></span> </span><span class="file-row-active-header-inner3"><span class="<?php if ($_SESSION["sortBy"]==2) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/2"><?php echo $this->lang->line("txt_By");?></a></span> </span><span class="file-row-active-header-inner5"><span class=""><a href="JavaScript:void(0);"><?php echo $this->lang->line("txt_Action");?></a></span></span></div>';

			        	fileData += '<div id="fileList" class="sortable">';
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

			        		var fileId = externalDocs[i]['docId'];

			        		fileData += '<div class='+rowColor+' id='+fileId+'><span class="file-row-active-header-inner6"><span id="fileOrder'+fileId+'">'+fileOrder+'</span></span><span class="file-row-active-header-inner1"><img src='+externalDocs[i]['thumbnailUrl']+' border="0"></span><span class="file-row-active-header-inner2" style="word-wrap: break-word;" ><a href='+url+' target="_blank">'+externalDocs[i]['docName']+'</a>'+fileInfo+'</span><span class="file-row-active-header-inner4"><span>'+externalDocs[i]["docCreatedDate"]+'</span> </span><span class="file-row-active-header-inner4"><span>'+externalDocs[i]["orig_modified_date"]+'</span> </span><span class="file-row-active-header-inner3"><span>'+externalDocs[i]["userTagName"]+'</span></span><span class="file-row-active-header-inner5"><a href="javascript:void(0)" onClick="fileUrlCopy('+url+')" title="<?php echo $this->lang->line("txt_copy_url"); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/copy_icon_new.png" alt="<?php echo $this->lang->line("txt_copy_url"); ?>" title="<?php echo $this->lang->line("txt_copy_url"); ?>" border="0"></a>';						

			        		var sessionWPManagerAccess = "<?php echo $_SESSION['WPManagerAccess']; ?>";
			        		var wsManagerAccess = result['wsManagerAccess'];

			        		var fileOrignatorId = externalDocs[i]['userId'];

					        var logInUserId = '<?php echo $_SESSION['userId']; ?>'; 

							if(sessionWPManagerAccess || workSpaceId == 0 || wsManagerAccess || fileOrignatorId==logInUserId)
							{
								var deleteUrl = "'"+baseUrl+"external_docs/delete_file_popup/"+workSpaceId+"/"+workSpaceType+"/"+externalDocs[i]["docId"]+"/"+externalDocs[i]["folderId"]+"'";

								fileData += '&nbsp;&nbsp;<span style="cursor: pointer;"><img src="<?php echo base_url();?>images/trash.gif" alt="<?php echo $this->lang->line("txt_Delete");?>" title="<?php echo $this->lang->line("txt_Delete");?>" border="0" onclick="showPopWin('+deleteUrl+',300,160,null)"></span>';
							}
						
							fileData += '</span></div>';

							// fileData += '<div class="clr"></div>';

							k++;
			        	}

			        	fileData += '</div>';
			        }
			        else
					{
						fileData += '<div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line("txt_None");?></span></div>';
					}

		        	$("#fileDataDiv",parent.document).html(fileData);

		        	parent.attachDragDrop();
		        }
		        else
		        {
		           document.getElementById('df_message').innerHTML="Internal server error.";
		        }
		    }
	    });

		return true; 
		
	}
</script>
