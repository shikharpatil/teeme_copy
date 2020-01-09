<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Teeme > Manage File(s)</title>
<!-- <style type="text/css">
	input::placeholder {
	  color: #968d8a;
	  font-size: 1.2em;
	  font-style: italic;
	}
</style> -->
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';
</script>

<script type="text/javascript">

	function getExistsData(filesData, workSpaceId, workSpaceType, selFolderName)
	{
		// var selFolderName = document.getElementById("hidden_folder_name").value;
		var userId = '<?php echo $_SESSION["userId"]; ?>';
		var placeName = '<?php echo $_COOKIE["place"]; ?>';

		if(selFolderName!='')
		{
			var cookieSetDataArray = {
				placeName:placeName,
				workSpaceId:workSpaceId,
				workSpaceType:workSpaceType,
				userId:userId,
				selFolderName:selFolderName,
				filesData:filesData
			};

			selFolderName = selFolderName.replace(/ /g,"_");
			
			var cookieName = placeName+'_'+workSpaceId+'_'+workSpaceType+'_user_'+userId+'_folder_'+selFolderName;
			
			var cookieData = getCookie(cookieName);

			var daysToExpire = 1;
			var date = new Date();
			date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));

			if(cookieData=='')
			{
	        	document.cookie = cookieName + "=" + JSON.stringify(cookieSetDataArray) + "; expires=" + date.toGMTString();
	        	return 'cookie_blank';
			}
			else
			{
				var filesRes = ""
				
				var request = $.ajax({

					url: baseUrl+"external_docs/checkFilesInFolder",

					type: "POST",

					data: 'workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&userId='+userId+'&selFolderName='+selFolderName,

					dataType: "json",

					async:false,

					success:function(result)
					{
						filesRes = result['filesData'];
					}
				});

				 return filesRes; 

	        	// document.cookie = cookieName + "=" + JSON.stringify(cookieSetDataArray) + "; expires=" + date.toGMTString();


				// cookieData = JSON.parse(cookieData);
				// alert('else');
				// alert('placeName='+cookieData.placeName);
				// alert('workSpaceId='+cookieData.workSpaceId);
				// alert('workSpaceType='+cookieData.workSpaceType);
				// alert('userId='+cookieData.userId);
				// alert('selFolderName='+cookieData.selFolderName);
				// alert('filesData='+cookieData.filesData);
				// for (i = 0; i < cookieData.filesData.length; i++) 
				// {
				// 	alert(cookieData.filesData[i]);
				// }
			}
		}	
	}

	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	    if (bytes == 0) return '0 Byte';
	    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	    if (i == 0) return bytes + ' ' + sizes[i];
		return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];

	   // var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   // if (bytes == 0) return '0 Byte';
	   // var i = (Math.floor(Math.log(bytes) / Math.log(1024)));
	   // return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	};

	$(document).ready(function() { 
 		window.localStorage.removeItem('create_folder_id');
 	});

	function SelectAll(id)
	{
	    document.getElementById(id).focus();
	    document.getElementById(id).select();
	}

	function selectFolder(e, workSpaceId, workSpaceType) {
	    var theFiles = e.target.files;
	    var relativePath = theFiles[0].webkitRelativePath;
	    var folder = relativePath.split("/");
	    document.getElementById("hidden_folder_name").value = folder[0];

	    //call uploadFiles function
	    uploadFiles(workSpaceId, workSpaceType);
	}

	function uploadFiles(workSpaceId, workSpaceType)
	{
		var fileCount1 = document.getElementById('fileId');

		// var fileCount2 = document.getElementById('folderId');

		if(document.getElementById('folderId'))
		{
			var fileCount2 = document.getElementById('folderId');
			var fileCount  = +fileCount1.files.length + +fileCount2.files.length;
		}
		else
		{
			var fileCount  = +fileCount1.files.length;
		}

		localStorage.setItem("failureCount", 0);
		localStorage.setItem("successCount", 0);

		if(fileCount > 1)
		{
			var uploadTitle = 'Uploading '+fileCount+' files';
		}
		else
		{
			var uploadTitle = 'Uploading '+fileCount+' file';
		}


		if(fileCount1.files.length > 0)
       	{
       		var filesData = fileCount1;
       	}
       	else
       	{
       		var filesData = fileCount2;
       	}

       	var newData = "<div id='progressBarPopup' style='display:inline;'>";

       	var filesNameArray = [];

       	//Used for file last modified date
       	var filesLastModifiedArray = [];

       	var totalFileSize = 0;
       	var totalfileSizeInMb = 0;

    	for (i = 0; i < filesData.files.length; i++) 
		{
			//Used for file last modified date
			if(filesData.files[i].lastModified != undefined && filesData.files[i].lastModified != '')
			{
				var lastModDateTime= new Date(filesData.files[i].lastModified);

				filesLastModifiedArray[i] = (lastModDateTime.toISOString().split('T')[0] + ' '  
                        + lastModDateTime.toTimeString().split(' ')[0]);
			}


			filesNameArray[i] = filesData.files[i].name;

        	var fileName = filesData.files[i].name;
        	var fileSize = bytesToSize(filesData.files[i].size);

        	totalFileSize += filesData.files[i].size;

        	newData += "<br/><span style='border-bottom: solid 1px #eee; padding-bottom: 10px; display: block;'><span style='width:65%; padding-left: 3%;padding-right: 3%; display: inline-block; padding-bottom: 10px;'><span style='word-wrap: break-word;' class=''> "+fileName+" </span></span><span style='width:13%; display: inline-block;'><span>"+fileSize+"</span></span>&nbsp;&nbsp;<span style='width:13%; display: inline-block;'><span style='display:none; margin-left: 30%;' id='failMessageIconShow"+i+"'><img src='<?php echo base_url();?>images/icon_delete.gif' border='0'></span><span style='display:none; margin-left: 30%;' id='successMessageIconShow"+i+"'><img src='<?php echo base_url();?>images/icon_correct.gif' border='0'></span><span style='display:inline;' id='progressBar"+i+"' class='progressBarNewUi'>0%</span></span><br/><span style='word-wrap: break-word; padding-left: 3%;padding-right: 3%; display:none;' class='errorMsg' id='progressMessHide"+i+"'></span><span style='word-wrap: break-word; padding-left: 3%;padding-right: 3%; display:none;' class='successMsg' id='fileAlrMessShow"+i+"'>file already exists</span></span>";

        }

        newData += "</div>";

        //Used for file last modified date
        document.getElementById("last_modified_date").value = filesLastModifiedArray;

        totalfileSizeInMb = (totalFileSize/1024/1024);

        //when totalfileSizeInMb is greater than 128mb
        if(totalfileSizeInMb>128)
        {
        	$(".file_folder_mesage").remove();
        	
        	var newData1 = "<div id='progressBarPopup' style='display:inline;'>";
        	newData1 += '<br/><br/><span class="errorMsg" style="padding-left: 3%;">Total upload file size can not be more than 128MB.</span><br/>';

        	newData1 += "</div>";

        	$('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs progressPopupNewUi" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle" id="shortTitleMess"><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 30px;"><span><br/></span>'+newData1+'</div></div>');

        	document.getElementById("shortTitleMess").innerHTML = '<b>'+uploadTitle+'</b>';

        	$('#fileForm input').val('');

        }
        else
        {
        	
	        //get selected folder name
	        var selFolderName = document.getElementById("hidden_folder_name").value;
	        var resFileData = '';
	        if(selFolderName!='')
	        {
	        	//get data if already exists by getExistsData
	       		resFileData = getExistsData(filesNameArray, workSpaceId, workSpaceType, selFolderName);
	        }
	      
		  	// var r=confirm("Do you really want to upload this files?")
		  	// if (r==true)
		  	// {
		  		//remove old message popup
		  		$(".file_folder_mesage").remove();
		
		  		// $('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle"><b>'+uploadTitle+'</b><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 50px; margin-left: 13px;"><span><br/></span><span id="loaderExternalFile" style="display:none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></span></div></div>');
		  		
		  		// document.getElementById('loaderExternalFile').style.display = "inline";


		  		// $('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs progressPopupNewUi" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle" id="shortTitleMess"><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 30px;"><span><br/></span>'+newData+'</div></div>');

		  		// document.getElementById("shortTitleMess").innerHTML = '<b>'+uploadTitle+'</b>';
	      		
	      		var createFolderId = window.localStorage.getItem('create_folder_id');
	 			if(createFolderId > 0)
	 			{
	 				document.getElementById("hidden_folder_id").value = createFolderId;
	 			}

		  		var formObj = $('#fileForm');
		        var formData = new FormData(formObj[0]);

		        var j = 0;

		        //total file count
		        var uploadedFilesCount = 0;
		        var alreadyExistsFilesCount = 0;
		        if(resFileData!='cookie_blank' && resFileData.length>0 && resFileData!='')
				{
					// var alreadyExistsFilesCount = 0;
					for (a=0; a < filesData.files.length; a++) 
					{
						//space replace by _
						var replaceFileName = (filesData.files[a].name).replace(/ /g,"_");

						for (b=0; b < resFileData.length; b++) 
						{
							if(replaceFileName==resFileData[b].docName)
							{
								alreadyExistsFilesCount++;
								break;
							}
						}
					}
					uploadedFilesCount = filesData.files.length - alreadyExistsFilesCount;
					
				}
				else
				{
					uploadedFilesCount = filesData.files.length;
				}

				//add popup for create new version
				var createFileVersion = '';
				if(alreadyExistsFilesCount>0)
				{
					

					newData += "<div id='createVersionPopup' style='display:none;'><br/><span style='padding-left: 3%;'>Some file(s) already exist, do you want to create new copies?</span></br></br><span style='padding-left: 3%;'><input name='createVersionYes' type='button' onclick='uploadFiles1(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,"+JSON.stringify(formData)+","+createFolderId+","+uploadedFilesCount+","+JSON.stringify(filesNameArray)+","+JSON.stringify(resFileData)+",1)' value='<?php echo $this->lang->line('txt_Yes');?>' class='button01'>&nbsp;&nbsp;&nbsp;<input name='createVersionNo' type='button' onclick='uploadFiles1(<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,"+JSON.stringify(formData)+","+createFolderId+","+uploadedFilesCount+","+JSON.stringify(filesNameArray)+","+JSON.stringify(resFileData)+",2)' value='<?php echo $this->lang->line('txt_No');?>'  class='button01'></span></div>";

					$('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs progressPopupNewUi" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle" id="shortTitleMess"><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 30px;"><span><br/></span>'+newData+'</div></div>');

		  			document.getElementById("shortTitleMess").innerHTML = '<b>'+uploadTitle+'</b>';

		  			document.getElementById("progressBarPopup").style.display = "none";

		  			document.getElementById("createVersionPopup").style.display = "inline";



					// var altMessage = 'Some file(s) already exist, do you want to create new copies?';
					// var createVersion = confirm(altMessage);
					// if(createVersion)
					// {
					// 	uploadedFilesCount = filesData.files.length;
					// 	createFileVersion = 1;
					// }
				}
				else
				{
					$('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs progressPopupNewUi" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle" id="shortTitleMess"><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 30px;"><span><br/></span>'+newData+'</div></div>');

		  			document.getElementById("shortTitleMess").innerHTML = '<b>'+uploadTitle+'</b>';

					uploadFiles1(workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount,filesData, resFileData, createFileVersion);

					return true;

				}



				
		  //       for (j=0; j < filesData.files.length; j++) 
				// {
				// 	if(resFileData!='cookie_blank' && resFileData.length>0 && resFileData!='' && createFileVersion=='')
				// 	{
				// 		//space replace by _
				// 		var replaceFileName = (filesData.files[j].name).replace(/ /g,"_");

				// 		var fileAlreadyExist = 0;
				// 		for (m=0; m < resFileData.length; m++) 
				// 		{
				// 			if(replaceFileName==resFileData[m].docName)
				// 			{
				// 				document.getElementById("progressBar"+j).style.display = "none";
				// 				document.getElementById("fileAlrMessShow"+j).style.display = "inline";
								
				// 				fileAlreadyExist = 1;
				// 				break;
				// 			}
				// 		}

				// 		if(fileAlreadyExist!=1)
				// 		{
				// 			uploadRequest(j, workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount);
				// 		}
				// 	}
				// 	else
				// 	{
				// 		uploadRequest(j, workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount);
				// 	}
				// }
				
				// return true;


			// }
			// else
			// {
			// 	return false;
			// }  
		}
	}

	function uploadFiles1(workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount,filesData, resFileData, createFileVersion)
	{
		/*Added by Dashrath- add for set parameter default value*/
		if(createFileVersion === undefined) {
		    createFileVersion = '';
		}
		/*Dashrath- code end*/

		//1 for create version yes, 2 for create version no
		if(createFileVersion==1)
		{
			var formObj = $('#fileForm');
	   		var formData = new FormData(formObj[0]);

			uploadedFilesCount = filesData.length;

			totalFileCount = filesData.length;

	  		document.getElementById("createVersionPopup").style.display = "none";
	  		document.getElementById("progressBarPopup").style.display = "inline";
		}
		else if(createFileVersion==2)
		{
			var formObj = $('#fileForm');
	   		var formData = new FormData(formObj[0]);

			uploadedFilesCount = uploadedFilesCount;

			totalFileCount = filesData.length;

			document.getElementById("createVersionPopup").style.display = "none";
	  		document.getElementById("progressBarPopup").style.display = "inline";
		}
		else
		{
			totalFileCount = filesData.files.length;
		}

		var j = 0;

		for (j=0; j < totalFileCount; j++) 
		{
			if(resFileData!='cookie_blank' && resFileData.length>0 && resFileData!='' && createFileVersion==2)
			{
				if(createFileVersion=='')
				{
					//space replace by _
					var replaceFileName = (filesData.files[j].name).replace(/ /g,"_");
				}
				else
				{
					//space replace by _
					var replaceFileName = (filesData[j]).replace(/ /g,"_");
				}
				

				var fileAlreadyExist = 0;
				for (m=0; m < resFileData.length; m++) 
				{
					if(replaceFileName==resFileData[m].docName)
					{
						document.getElementById("progressBar"+j).style.display = "none";
						document.getElementById("fileAlrMessShow"+j).style.display = "inline";
						
						fileAlreadyExist = 1;
						break;
					}
				}

				if(fileAlreadyExist!=1)
				{
					uploadRequest(j, workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount);
				}
			}
			else
			{
				uploadRequest(j, workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount);
			}
		}
	}


	function uploadRequest(j,workSpaceId, workSpaceType, formData, createFolderId, uploadedFilesCount)
	{
		var request = $.ajax({
			    
				    url: baseUrl+"external_docs/add/"+workSpaceId+"/type/"+workSpaceType+"/"+j+"/"+uploadedFilesCount,

				    type: "POST",

				    data: formData,

				    //dataType: "html",
				    dataType: "json",

				    processData: false,

	       			contentType: false,

				    async:true,

				    xhr: function(){
			    		
						//upload Progress
						var xhr = $.ajaxSettings.xhr();

						if (xhr.upload) {
							xhr.upload.addEventListener('progress', function(event) {
								
								var percent = 0;
								var position = event.loaded || event.position;
								var total = event.total;
								if (event.lengthComputable) {
									percent = Math.ceil(position / total * 100);
								}

								//update progressbar
								document.getElementById("progressBar"+j).innerHTML = percent +"%";
							}, true);
						}

						
						
						return xhr;
					}

			    }).done(function(resultData)
			    { 
				    	//value clear
				    	$('#fileForm input').val('');
				    	var result = resultData['sessionMessage'];

				    	var z = resultData['z'];
				    	var t = resultData['t'];
				    	var uploadedFileCount1 = resultData['uploadedFileCount'];
				    	
				    	var fileCount =  resultData['fileCount'];

				        if(result){
				        	//location.reload();
				          	//window.top.location.href = baseUrl+result; 
				        	var data = "";
							var i;
							//var successCount = 0;
							//var failureCount = 0;
							// for (i = 0; i < result.length; i++) 
							// {

								document.getElementById("progressBar"+z).style.display = "none";

								if(result[z]['success'] == 0)
								{
									// data += "<span class='errorMsg'> "+result[i]['file_name']+": " + result[i]['message'] + "</span><br>";
									// data += "<br/><span style='border-bottom: solid 1px #eee; padding-bottom: 10px; display: block;'><span style='width:87%; margin-left: 13px; display: inline-block; padding-bottom: 10px;'><span style='word-wrap: break-word;' class=''> "+result[i]['file_name']+" </span></span><span style='width:8%; display: inline-block;'><img src='<?php echo base_url();?>images/icon_delete.gif' border='0'></span><br/><span style='word-wrap: break-word; margin-left: 13px;' class='errorMsg'>error : "+result[i]['message']+"</span></span>";

									document.getElementById("progressMessHide"+z).style.display = "inline";

									document.getElementById("progressMessHide"+z).innerHTML = "error : "+result[z]['message'];
									
									
									document.getElementById("failMessageIconShow"+z).style.display = "inline";

									var failureCount = localStorage.getItem("failureCount");
									failureCount++;
									localStorage.setItem("failureCount", failureCount);

									//failureCount++;
								}
								else
								{
									// data += "<br/><span style='border-bottom: solid 1px #eee; padding-bottom: 10px; display: block;'><span style='width:87%; margin-left: 13px; display: inline-block; padding-bottom: 10px;'><span style='word-wrap: break-word;' class=''> "+result[i]['file_name']+" </span></span><span style='width:8%; display: inline-block;'><img src='<?php echo base_url();?>images/icon_correct.gif' border='0'></span></span>";

									document.getElementById("successMessageIconShow"+z).style.display = "inline";
									
									var successCount = localStorage.getItem("successCount");
									successCount++;
									localStorage.setItem("successCount", successCount);
									//successCount++;
								}
							// } //loop end

							// $(".file_folder_mesage").remove();

				   //        	$('.otherarea').append('<div style="min-height:250px; max-height:600px; overflow:auto; margin-bottom: 12px;" class="file_folder_mesage abs" id="file_folder_mesage"><div class="abs_head talk_head"><div class="talktxtTitle"><span class="shortTitle"><b> '+successCount+' successful '+failureCount+' failed</b><span class="tooltip"></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeMessageWindow('+workSpaceId+','+workSpaceType+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size" onclick="hideMessageWindow()"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="talk_content" style="margin-top: 20px;"><span><br/></span>'+data+'</div></div>');


				   			if(uploadedFileCount1==t)
				         	{
				         		var failureCount1 = localStorage.getItem("failureCount");
				         		var successCount1 = localStorage.getItem("successCount");
				         		if(failureCount1=='' || failureCount1==null)
				         		{
				         			failureCount1 = 0;
				         		}
				         		if(successCount1=='' || successCount1==null)
				         		{
				         			successCount1 = 0;
				         		}

							 	//change title
							 	document.getElementById("shortTitleMess").innerHTML = "<b> "+successCount1+" successful "+failureCount1+" failed</b>";

							 	localStorage.removeItem("failureCount");
							 	localStorage.removeItem("successCount");
							}
				          
				        }
				        else
				        {
				           document.getElementById('docErrorMsg').innerHTML="error";
				        }


				  //       if(fileCount===(+j+1))
			   //       	{
			   //       		var failureCount1 = localStorage.getItem("failureCount");
			   //       		var successCount1 = localStorage.getItem("successCount");
			   //       		if(failureCount1=='' || failureCount1==null)
			   //       		{
			   //       			failureCount1 = 0;
			   //       		}
			   //       		if(successCount1=='' || successCount1==null)
			   //       		{
			   //       			successCount1 = 0;
			   //       		}

						//  	//change title
						//  	document.getElementById("shortTitleMess").innerHTML = "<b> "+successCount1+" successful "+failureCount1+" failed</b>";

						//  	localStorage.removeItem("failureCount");
						//  	localStorage.removeItem("successCount");
						// }
				        

				        var workSpaceDetails 	= resultData['workSpaceDetails'];

				        // var editFolderName = resultData['editFolderName'];
				        var editFolderName = resultData['rootFolderName'];
				        var rootFolderId = resultData['rootFolderId'];
				        var rootFolderTitleName = resultData['rootFolderTitleName'];

				        var workPlaceDetails 	= resultData['workPlaceDetails'];

				        if(createFolderId > 0)
				        {
				        	var folderId 		= createFolderId;
				        }
				        else
				        {
				        	// var folderId 		= "<?php echo $this->uri->segment(7); ?>";
				        	var folderId 		= resultData['folderId'];
				        	if(folderId > 0)
				        	{
				        		document.getElementById("hidden_folder_id").value = folderId;
				        	}
				        }

				        var foldersDetailDocs 	= resultData['foldersDetailDocs'];
				        var externalDocs 		= resultData['externalDocs'];
				        var folName 			= resultData['folName'];

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
				        		var wsManagerAccess = resultData['wsManagerAccess'];

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

					        	if(sessionWPManagerAccess || wsManagerAccess || folderOrignatorId == logInUserId)
					        	{
					        		folderData +='<a class="folderActionBut" onclick="showPopWin('+folderRenameUrl+', 320, 200, null)"><img src="<?php echo base_url();?>images/dot_action_1.png" alt="" title="Edit" border="0"></a>';
					        	}

					        	folderData +='</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					        }
				        }


				        var fileData = '<div><span class="fileFolderLabel"><?php echo $this->lang->line('txt_files');?> ('+externalDocs.length+')</span><span class="fileSearchBox"><form name="searchForm" method="post" action="<?php echo base_url()?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'" enctype="multipart/form-data" onSubmit="return validateExternalDocs()"><input type="text" name="searchDocs" value="<?php echo $searchDocs;?>" maxlength="100" size="50" class="fileSearchInput" placeholder="Search '+folName+'" >&nbsp;<input type="submit" name="Search" value="<?php echo $this->lang->line("txt_Search");?>" class="button01"></form></span></div><br/>';

				        if(externalDocs.length > 0)
				        {
				        	// fileData += '<div class="file-row-active-header"><span class="file-row-active-header-inner6"><span class="<?php if ($_SESSION["sortBy"]==4) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/4"><?php echo $this->lang->line("txt_Order");?></a></span> </span><span class="file-row-active-header-inner1"></span></span><span class="file-row-active-header-inner2"> <span class="<?php if ($_SESSION["sortBy"]==1) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/1"><?php echo $this->lang->line("txt_Name");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION["sortBy"]==3) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/3"><?php echo $this->lang->line("txt_Uploaded_Date");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION["sortBy"]==5) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/5"><?php echo $this->lang->line("txt_Last_Modified_Date");?></a></span> </span><span class="file-row-active-header-inner3"><span class="<?php if ($_SESSION["sortBy"]==2) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/2"><?php echo $this->lang->line("txt_By");?></a></span> </span><span class="file-row-active-header-inner5"><span class=""><a href="JavaScript:void(0);"><?php echo $this->lang->line("txt_Action");?></a></span></span></div>';

				        	fileData += '<div class="file-row-active-header"><span class="file-row-active-header-inner6"><span><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/4"><?php echo $this->lang->line("txt_Order");?></a></span> </span><span class="file-row-active-header-inner1"></span></span><span class="file-row-active-header-inner2"> <span><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/1"><?php echo $this->lang->line("txt_Name");?></a></span> </span><span class="file-row-active-header-inner4"> <span class="rowHeaderFont rowHeaderFileLabel"><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/3"><?php echo $this->lang->line("txt_Uploaded_Date");?></a></span> </span><span class="file-row-active-header-inner4"> <span><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/5"><?php echo $this->lang->line("txt_Last_Modified_Date");?></a></span> </span><span class="file-row-active-header-inner3"><span><a href="<?php echo base_url();?>external_docs/index/'+workSpaceId+'/type/'+workSpaceType+'/1/'+folderId+'/2"><?php echo $this->lang->line("txt_By");?></a></span> </span><span class="file-row-active-header-inner5"><span class=""><a href="JavaScript:void(0);"><?php echo $this->lang->line("txt_Action");?></a></span></span></div>';

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
				        		var wsManagerAccess = resultData['wsManagerAccess']; 

				        		var fileOrignatorId = externalDocs[i]['userId'];

					        	var logInUserId = '<?php echo $_SESSION['userId']; ?>';

								if(sessionWPManagerAccess || workSpaceId == 0 || wsManagerAccess || fileOrignatorId == logInUserId)
								{
									var deleteUrl = "'"+baseUrl+"external_docs/delete_file_popup/"+workSpaceId+"/"+workSpaceType+"/"+externalDocs[i]["docId"]+"/"+externalDocs[i]["folderId"]+"'";

									fileData += '&nbsp;&nbsp;<span style="cursor: pointer;"><img src="<?php echo base_url();?>images/trash.gif" alt="<?php echo $this->lang->line("txt_Delete");?>" title="<?php echo $this->lang->line("txt_Delete");?>" border="0" onclick="showPopWin('+deleteUrl+',300,160,null)"></span>';
								}
							
								fileData += '</span></div>';
								// fileData +='<div class="clr"></div>';

								k++;
				        	}

				        	fileData += '</div>';
				        }
				        else
						{
							fileData += '<div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line("txt_None");?></span></div>';
						}


						$("#folderDataDiv").html(folderData);

						$("#fileDataDiv").html(fileData);	

						$("#folCountDis").html(foldersDetailDocs.length);
						

						attachDragDrop();
				    
			    });
	}

	function closeMessageWindow(workSpaceId, workSpaceType)
	{
		$(".file_folder_mesage").remove();
		// var baseUrl = '<?php echo base_url(); ?>';
		// window.top.location.href = baseUrl+"external_docs/index/"+workSpaceId+"/type/"+workSpaceType+"/1";
	}

	function hideMessageWindow()
	{
		if($(".talk_content").is(":visible"))
		{
			$(".talk_content").hide();	
			$(".talk_chat_size").html('<i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp;&nbsp;');
			$("#tooltiptext").removeClass('tooltiptext').addClass('tooltiptextBottom');	
			document.getElementById("file_folder_mesage").style.minHeight = "25px";
		}
		else
		{
			$(".talk_content").show();
			$(".talk_chat_size").html('<b>_ </b>&nbsp;&nbsp;');
			$("#tooltiptext").removeClass('tooltiptextBottom').addClass('tooltiptext');
			$(".talk_head").removeClass('talkBlink');
			document.getElementById("file_folder_mesage").style.minHeight = "250px";
		}
		
	}

	function fileUrlCopy(fileUrl)
	{
		var inp =document.createElement('input');
		document.body.appendChild(inp)
		inp.value =fileUrl
		inp.select();
		document.execCommand('copy',false);
		inp.remove();
		jAlert("Copied!","Alert");
	}
	
</script>
</head>
<body onUnload="return bodyUnload()">	
	<div id="wrap1">
		<div id="header-wrap">
			<?php $this->load->view('common/header'); ?>
			<?php $this->load->view('common/wp_header'); ?>
			<!-- remove common/artifact_tabs view-->
		</div>
	</div>
	<div id="container" class="fileList">
		<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
			
		</div>
		<div id="rightSideBar"> 
		<?php
		$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
		$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
		$details['workSpaces']		= $workSpaces;
		$details['workSpaceId'] 	= $workSpaceId;

		//get folders details
		$foldersDetailDocs = $this->identity_db_manager->getFolders($workSpaceId, $workSpaceType);

		/*Added by Dashrath- get root folder details*/
		$rootFolderDetails = $this->identity_db_manager->getRootFolderDetails($workSpaceId, $workSpaceType);
		
		//folderId
		$folderId = $this->uri->segment(7);

		if(!$folderId>0)
		{
			$folderId = $rootFolderDetails['folderId'];
		}
		
		$sortingId = $this->uri->segment(8);
		if($sortingId > 0)
		{
			$sortBy 	= $_SESSION['sortBy'];
			$sortOrder  = $_SESSION['sortOrder'];
		}
		else
		{
			$sortBy 	= 4;
			$sortOrder  = 1;
		}

		if($folderId > 0)
		{
			$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy, $sortOrder, $folderId);

			$folName = $this->identity_db_manager->getFolderNameByFolderId($folderId);
		}
		else
		{

			$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy, $sortOrder,$folderId);
			// $folderId = 0;
			$folName = $workSpaceDetails['workSpaceName'];
		}
		
		
		if($workSpaceId > 0)
		{				
			$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
		}
		else
		{
			$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
		}

		/*Added by Dashrath- Added for checking device type start*/
		$deviceName = '';
		$userAgent = $_SERVER["HTTP_USER_AGENT"];
		$devicesTypes = array(
			"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
			"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
		);
		foreach($devicesTypes as $deviceType => $devices) {           
			foreach($devices as $device) {
				if(preg_match("/" . $device . "/i", $userAgent)) {
					$deviceName = $deviceType;
				}
			}
		}
		/*Dashrath- Added for checking device type end*/
		 
		?>

		<div>
			<div style="display: flex;">
				<label class="myLabelForFile">
			  		<span onclick="showPopWin('<?php  echo base_url();?>external_docs/create_folder_popup/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>', 320, 210, null, '')"><?php echo $this->lang->line('txt_New_folder'); ?></span>&nbsp;
			  	</label>
			  	<form name="fileForm" id="fileForm" method="post" enctype="multipart/form-data">
			  		<label class="myLabelForFile">
			  			<span><?php echo $this->lang->line('txt_upload_files'); ?></span>
				  		<input type="file" name="workSpaceDoc[]" id="fileId" onchange="uploadFiles('<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>')" multiple />
				  	</label>

				  	<?php 
				  	if($deviceName != 'tablet') 
				  	{
				  	?>
					  	<label class="myLabelForFile">
					  		<span><?php echo $this->lang->line('txt_upload_folder'); ?></span>					  	
					  		<input type="file" webkitdirectory mozdirectory  name="folderFiles[]" id="folderId" onchange="selectFolder(event, '<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>')" />
					  	</label>
					<?php
					}
					?>

				  	<input type="hidden" name="hidden_folder_name" id="hidden_folder_name" />
				  	<input type="hidden" name="hidden_folder_id" id="hidden_folder_id" value="<?php echo $folderId;?>" />

				  	<!-- Used for file last modified date -->
				  	<input type="hidden" name="last_modified_date" id="last_modified_date" value="" />
			  	</form>
			 
			  	<span class="infoShortTitle"><img src="<?php echo  base_url(); ?>images/info_icon.png" alt="Info" border=0>
				  	<span class="infoTooltip">
						<span class="infoTooltiptext"><!-- <b>Maximum upload file and folder size</b> 128MB. <br/> --> <b>Maximum number of files</b> 200. <br/><b>Allowed extensions</b> : gif, jpeg, jpg, png, txt, pdf, csv, doc, docx, xls, xlsx, ppt, odt, pptx, xps, docm, dotm, dotx, dot, xlsm, xlsb, xlw, pot, pptm, pub, rtf, mp4,  avi, flv, wmv, mov,  mp3,  m4a,  aac,  oga</span>
					</span>
			  	</span>
			  	<span class="maxfileSizeMessage">
			  		<b>Maximum upload file and folder size</b> 128MB.
			  	</span>
			  	
		  	</div>
		  	<span class="mangeFilesUpdateIcon">
				<img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"' style="cursor:pointer" >
			</span>
		</div> 
		<hr style="height: 1px;  border: none; background-color: #c6c6c6;" />
		<div>
			<div>
				<span class="fileFolderLabel">
					<?php echo $this->lang->line('txt_folders');?> (<span id="folCountDis"><?php echo count($foldersDetailDocs); ?></span>)
				</span>
			</div>
			<br/>
			<div class="folderActiveHover" id="folderDataDiv">
				<!-- <?php
					$editFolderName = $this->identity_db_manager->characterLimiter($details['workSpaceName'], 12,'workspacename');
				?> -->
				<span class="folderSpan <?php if($folderId == $rootFolderDetails['folderId']) { ?>folderActive <?php } ?>">
					<a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $rootFolderDetails['folderId']; ?>" title="<?php echo $rootFolderDetails['name'];?>"><img src="<?php echo base_url();?>images/folder_icon_new.png" alt="" title="" border="0"> <p class="folder-name-text"><?php echo $rootFolderDetails['editFolderName']; ?></p></a>
				</span>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
				
				if(count($foldersDetailDocs) >1)
				{
				?>
					<span class="folderSepraterIcon">&#10148;</span>&nbsp;&nbsp;&nbsp;
				<?php
				}

				foreach($foldersDetailDocs as $docData)
				{	
					if($rootFolderDetails['folderId'] != $docData['folderId'])
					{
						$editFolderName = $this->identity_db_manager->characterLimiter($docData['name'], 16);
					?>
						<span <?php if($folderId == $docData['folderId']) { ?>class="folderActive" <?php } ?>style="display:inline-block; margin-top:10px;" ><a href="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $docData['folderId'];?>" title="<?php echo $docData['name'];?>"><img src="<?php echo base_url();?>images/folder_icon_new.png" alt="" title="" border="0"> <p class="folder-name-text"><?php echo $editFolderName; ?></p></a><?php if($_SESSION['userId'] == $docData['userId']) { ?><a class="folderActionBut" onclick="showPopWin('<?php  echo base_url();?>external_docs/folder_delete_rename_popup/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $docData['folderId']; ?>', 320, 200, null, '')"><img src="<?php echo base_url();?>images/dot_action_1.png" alt="" title="Edit" border="0"></a><?php } ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
					} 	
				}
				?>
				
			</div>
		</div>
		<br/>
		<hr style="height: 1px;  border: none; background-color: #c6c6c6;" />
		<div id="fileDataDiv">
			<div>
				<span class="fileFolderLabel">
					<?php echo $this->lang->line('txt_files');?> (<?php echo count($externalDocs); ?>)
				</span>
				<span class="fileSearchBox"><form name="searchForm" method="post" action="<?php echo base_url()?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>" enctype="multipart/form-data" onSubmit="return validateExternalDocs()">
				   		<input type="text" name="searchDocs" value="<?php echo $searchDocs;?>" maxlength="100" size="50" class="fileSearchInput" placeholder="Search <?php echo $folName; ?>" onfocus="this.placeholder=''" onblur="this.placeholder='Search <?php echo $folName; ?>'">
                   		<input type="submit" name="Search" value="<?php echo $this->lang->line('txt_Search');?>" class="button01">
                   	</form></span>
			</div>
			<br/>
			<?php
			if(count($externalDocs) > 0)
			{
			?>
				<div class="file-row-active-header">
					<span class="file-row-active-header-inner6"> <span class="<?php if ($_SESSION['sortBy']==4) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" > <a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>/4"><?php echo $this->lang->line('txt_Order');?></a></span> </span>

					<span class="file-row-active-header-inner1"></span>
					
				  	<span class="file-row-active-header-inner2"> <span class="<?php if ($_SESSION['sortBy']==1) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" > <a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>/1"><?php echo $this->lang->line('txt_Name');?></a></span> </span>
				  	
				  	<span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION['sortBy']==3) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>/3"><?php echo $this->lang->line('txt_Uploaded_Date');?></a></span> </span>

				  	<span class="file-row-active-header-inner4"> <span class="<?php if ($_SESSION['sortBy']==5) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>/5"><?php echo $this->lang->line('txt_Last_Modified_Date');?></a></span> </span>

				  	<span class="file-row-active-header-inner3"> <span class="<?php if ($_SESSION['sortBy']==2) {echo "rowHeaderFont rowHeaderFileLabel" ;} ?>" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/<?php echo $folderId; ?>/2"><?php echo $this->lang->line('txt_By');?></a></span> </span>

				  	
				  
				  	<?php
					$wsManagerAccess = $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceId,3);
					?>
					  <span class="file-row-active-header-inner5"> <span class=""><a href="JavaScript:void(0);"><?php echo $this->lang->line('txt_Action');?></a></span> </span>
				</div>

				<div id="fileList" class="sortable">

				<?php
				$rowColor1='file-row-active-middle1';
				$rowColor2='file-row-active-middle2';	
				$i = 1;	
								
				foreach($externalDocs as $docData)
				{	
					//Added by Dashrath : code start
					
					//Dashrath : code end
					$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($docData['userId']);
					$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
					
					$arrFileUrl	= $this->identity_db_manager->getExternalFileDetailsById( $docData['docId']);		
					//$url = base_url().$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];		
					$url = base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].$arrFileUrl['docName'];

					//get thumbnail url
					$thumbnailUrl = $this->identity_db_manager->getThumbnailUrl($workPlaceDetails['companyName'],$arrFileUrl['docPath'],$arrFileUrl['docName']);

					$fileInfo = $this->identity_db_manager->getFileInformation($workPlaceDetails['companyName'],$arrFileUrl['docPath'],$arrFileUrl['docName']);
																	
					?>
					<div class="<?php echo $rowColor; ?> " id="<?php echo $docData['docId'];?>">

						<span class="file-row-active-header-inner6"> 
							<span id="fileOrder<?php echo $docData['docId'];?>">
								<?php 
								if($docData['fileOrder'])
									echo $docData['fileOrder'];
								else
									echo 'NA';
								?>
							</span> 
						</span>

						<span class="file-row-active-header-inner1"> 

								<img src="<?php echo $thumbnailUrl; ?>" border="0">

						</span>

						

						<span class="file-row-active-header-inner2" style="word-wrap: break-word;" >
							<a href="<?php echo $url;?>" target="_blank">
								<?php echo $docData['docName'];?>
							</a>
							<br/>
							<?php 
							if($fileInfo['is_image'] == 1)
							{
							?>
								<span class="fileInfo"><?php echo $fileInfo['size']; ?> <?php echo $fileInfo['size_type']; ?> &nbsp;&nbsp;<?php echo $fileInfo['width']; ?> x <?php echo $fileInfo['height']; ?> pixels</span>
							<?php
							}
							else
							{
							?>
								<span class="fileInfo"><?php echo $fileInfo['size']; ?> <?php echo $fileInfo['size_type']; ?></span>
							<?php
							}
							?>
						</span>
						
						<span class="file-row-active-header-inner4"> 
							<span><?php echo $this->time_manager->getUserTimeFromGMTTime($docData['docCreatedDate'], 'm-d-Y h:i A');?></span> 
						</span>

						<span class="file-row-active-header-inner4"> 
							<span><?php echo $this->time_manager->getUserTimeFromGMTTime($docData['orig_modified_date'], 'm-d-Y h:i A');?></span> 
						</span>

						<span class="file-row-active-header-inner3"> 
							<span><?php echo $userDetails['userTagName'];?></span> 
						</span>

						<span class="file-row-active-header-inner5">
							<a href="javascript:void(0)" onClick="fileUrlCopy('<?php echo $url; ?>')" title="<?php echo $this->lang->line('txt_copy_url'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/copy_icon_new.png" alt="<?php echo $this->lang->line("txt_copy_url"); ?>" title="<?php echo $this->lang->line("txt_copy_url"); ?>" border="0"></a>
						
						<?php


						if($_SESSION['WPManagerAccess'] || $workSpaceId == 0 || $wsManagerAccess || $docData['userId']==$_SESSION['userId'])
						{
						?>
						<!--Manoj: added anchor tag-->
						<!-- Dashrath : added encoded folder name in href link -->
							&nbsp;&nbsp;
							<span style="cursor: pointer;"><img src="<?php echo base_url();?>images/trash.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0" onclick="showPopWin('<?php  echo base_url();?>external_docs/delete_file_popup/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $docData['docId'];?>/<?php echo $docData['folderId']; ?>', 300, 160, null, '')"></span>
						

						<?php
						}
						?>
						</span> 
						
					</div>
					<!-- <div class="clr"></div> -->
					<?php
					$i++;
					
				}
				//loop end	

				?>
				</div>
				<?php
			}
			else
			{
			?>
				<div class="row-active-header">
					<span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span>
				</div>
			<?php
			}
			?>
		</div>

		</div> <!-- rightside bar end -->

		<!--Added by Dashrath- load notification side bar-->
		<?php $this->load->view('common/notification_sidebar.php');?>
		<!--Dashrath- code end-->
	</div>
	<?php $this->load->view('common/foot.php');?>
	<!-- remove common/footer view-->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>

	//Add SetTimeOut 
	setTimeout("checkTotalMangeFilesCount(<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);

	//call attachDragDrop
	$(document).ready(function() {
    	attachDragDrop();
	});

	// $(function(){
	function attachDragDrop()
	{
      $("#fileList").sortable({
        stop: function(){
          $.map($(this).find('div'), function(el) {
            var fileId = el.id;
            var fileIndex = $(el).index();
            
            //alert('fileId='+fileId);
            //alert('fileIndex='+fileIndex);

            if(fileId>0)
            {
	           	var request = $.ajax({

						url: baseUrl+"external_docs/updateFileOrderByDragAndDrop",

						type: "POST",

						data: 'workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&fileId='+fileId+'&fileIndex='+fileIndex,

						dataType: "html",

						success:function(res)
						{
							if(res=='1')
							{
								document.getElementById("fileOrder"+fileId).innerHTML = +fileIndex+1;
							}
							else
							{
								jAlert("Something went wrong!","Alert");
							}
						}
					});
           }

          });
        }
      });
  	}
    // });
</script>
</html>	
