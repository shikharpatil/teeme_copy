<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Teeme</title>
		<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

		<script>

			function cancelTask(url)
			{
				//window.location = url;
				location.reload (true);
			}

			function changeOption(thisVal)
			{	
				document.getElementById('curOption').value = thisVal;

				if(thisVal == 1 && document.getElementById('treeStatus').value == 1 && trim(document.getElementById('replyDiscussion').value)=='')
				{

					window.location = baseUrl+'view_task/node_task/'+document.getElementById('nodeId').value+'/'+workSpaceId+'/type/'+workSpaceType;
				}
			}

			function calendarStartCheck(thisVal)
			{
				if(thisVal.checked == true)
				{			
					document.getElementById('starttime').style.color = "#000000";	

					document.getElementById('starttime').style.backgroundColor = "#FFFFFF";	

					document.getElementById('mark_calender').style.display = "";
				}
				else
				{		
					document.getElementById('starttime').style.color = "#626262";	

					document.getElementById('starttime').style.backgroundColor = "#CCCCCC";	

					if ((document.getElementById('calStart').style.display == 'none') && (document.getElementById('calEnd').style.display == 'none'))
					{
						document.getElementById('mark_calender').style.display = "none";
						//document.form1.calendarStatus.checked = false;
					}		
				}

				$('.edp').datetimepicker({

					timeFormat: "HH:mm",

					dateFormat: "dd-mm-yy"

				});

				$('.sdp').datetimepicker({

					timeFormat: "HH:mm",

					dateFormat: "dd-mm-yy"

				});

			}

			function calendarEndCheck(thisVal)
			{
				if(thisVal.checked == true)
				{	
					document.getElementById('endtime').style.color = "#000000";	

					document.getElementById('endtime').style.backgroundColor = "#FFFFFF";	

					document.getElementById('mark_calender').style.display = "";
				}
				else
				{		
					document.getElementById('endtime').style.color = "#626262";	

					document.getElementById('endtime').style.backgroundColor = "#CCCCCC";	

					if ((document.getElementById('calStart').style.display == 'none') && (document.getElementById('calEnd').style.display == 'none'))
					{
						document.getElementById('mark_calender').style.display = "none";

						//document.form1.calendarStatus.checked = false;
					}

				}

				$('.edp').datetimepicker({

					timeFormat: "HH:mm",

					dateFormat: "yy-mm-dd"

				});
			}

			function changeMode(thisVal)
			{
				if(thisVal.value == 'Yes')
				{
					document.getElementById('trTaskTitle').style.display = '';

					document.getElementById('butAddMore').style.display = '';
				}
				else
				{
					document.getElementById('trTaskTitle').style.display = 'none';

					document.getElementById('butAddMore').style.display = 'none';
				}
			}

			function compareDates (dat1, dat2) 
			{
				//alert ('date1= ' +dat1);

				//alert ('date2= ' +dat2);

			   	var date1, date2;

			   	var month1, month2;

			   	var year1, year2;

				value1 = dat1.substring (0, dat1.indexOf (" "));

				value2 = dat2.substring (0, dat2.indexOf (" "));

				time1= dat1.substring (16, dat1.indexOf (" "));

				time2= dat2.substring (16, dat2.indexOf (" "));

				hours1= time1.substring (0, time1.indexOf (":"));

				minites1= time1.substring (1, time1.indexOf (":"));

				hours2= time2.substring (0, time2.indexOf (":"));

				minites2= time2.substring (1, time2.indexOf (":"));

			   	date1 = value1.substring (0, value1.indexOf ("-"));

			   	month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));

			   	year1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

			   	date2 = value2.substring (0, value2.indexOf ("-"));

			   	month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));

			   	year2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

			   	//alert ('hour1= ' + hours1);

			   	//alert ('hour2= ' + hours2);

			   	if (year1 > year2) return 1;

			   	else if (year1 < year2) return -1;

			   	else if (month1 > month2) return 1;

			   	else if (month1 < month2) return -1;

			   	else if (date1 > date2) return 1;

			   	else if (date1 < date2) return -1;

				else if(date1 == date2)
				{

					if (hours2 > hours1)
					{
						return -1;
					}
					else if(hours2 < hours1)
					{
						return 1;
					}
					else if(hours1 == hours2)
					{
						if(minites2 < minites1)
						{
							return 1;
						}	
						else
						{
							return -1;
						}
					}
				}
			   	else if (hours1 > hours2) return 1;

			   	else if (hours1 < hours2) return -1;

			   	else if (minites1 > minites2) return 1;

			   	else if (minites1 < minites2) return -1;
			   	else return 0;
			} 

			function showFocus()
			{
				//parent.frames[0].gk.EditingArea.focus();
			} 

			var request_refresh_point=1;

			var nodeId='';

			function validate_dis_new(pnodeId,workSpaceId,workSpaceType,linkType,formname)
			{
				var error='';

			    //var replyDiscussionValue	= CKEDITOR.instances.replyDiscussion.getData();

				var replyDiscussionValue	= getvaluefromEditor('replyDiscussion'+pnodeId);

				//alert (replyDiscussionValue); return false;

				//alert(replyDiscussionValue);return;

			    //var formname=document.form1;
				
				//var formname=document.form+'formAddSubTask'+pnodeId;
				//alert (formname);

				//alert ('formstart= ' + formname.startCheck.checked);

				//alert ('formnend= ' + formname.endCheck.value);

				//var title = getvaluefromEditor('title','simple');

				//var replyDiscussionValue = getvaluefromEditor('replyDiscussion','simple');

				/*	if(title=='')

				{			

					error+='Please Enter SubTask Title \n';			

				}*/

				/*if ($("<p>"+replyDiscussionValue+"</p>").text().trim()=='' && replyDiscussionValue.indexOf("<img")==-1)

				{			

					error+='<?php //echo $this->lang->line('enter_subtask'); ?>\n';			

				}*/
				if (replyDiscussionValue == '')
				{			
					error+='<?php echo $this->lang->line('enter_subtask'); ?>\n';			
				}

				if(formname.startCheck.checked==true && formname.endCheck.checked==true)
				{
					if(compareDates(formname.starttime.value,formname.endtime.value) == 1)
					{
						error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';
					}
				}

				if(error=='')
				{
					/*Added by Dashrath- get tree id from hidden field for task focus*/
			    	var treeId = $("#treeId").val();
			    	/*Dashrath- code end*/

					$("#butDone").hide();

					$("#butCancel").hide();

					$("#loader1").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

					request_refresh_point=0;

					var data_user =$(formname).serialize();

					
					var request = $.ajax({

					  	url: baseUrl+"new_task/start_sub_task/"+pnodeId+'/0/'+workSpaceId+'/type/'+workSpaceType+'/'+linkType,

					  	type: "POST",

					  	data: data_user+'&replyDiscussion='+encodeURIComponent(replyDiscussionValue),

					  	dataType: "html",

					  	success:function(result){

							editorClose('replyDiscussion');

							// parent.location.href=parent.location.href;

							//tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion');

							//CKEDITOR.instances.replyDiscussion.destroy();

							$("#butDone").show();

							$("#butCancel").show();

							$("#loader1").html("");

							//$("#divNodeContainer").html(result);
							$("#divNodeContainer",parent.document).html(result);
								
							//document.getElementById('editStatus').value= 0;	

							/*Added by Dashrath- call taskHighlight function for task hig*/
							//taskHighlight(treeId);
							window.parent.taskHighlight(treeId);
							/*Dashrath- code end*/

							$('#popupMask',parent.document).remove();
							$('#popupContainer',parent.document).remove();
						}

					});

					//document.form1.submit();

					//request_send();

				}else{

					jAlert(error);

					return false;

				}
			}

			function getHTTPObjectm() { 

				var xmlhttp; 

				if(window.XMLHttpRequest){ 

					xmlhttp = new XMLHttpRequest(); 

				}else if(window.ActiveXObject){ 

					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 

					if(!xmlhttp){ 

						xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 

					} 

				} 
				return xmlhttp; 
			} 

			var http1 = getHTTPObjectm();

			var replay_target=1;

			var start_chat_val=1;

			function handleHttpResponsem1() 
			{    
				if(http1.readyState == 4) { 

					if(http1.status==200) { 

						var results=http1.responseText; 

						document.getElementById('chat_msg').innerHTML=results;

						document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;

						document.getElementById('replyDiscussion').value='';

						if(start_chat_val){

							document.getElementById('chat_title').innerHTML='<input name="title" type="hidden" value=" "><input name="starttime" type="hidden" id="starttime"  value=" "><input name="endtime" type="hidden" id="endtime" value=" ">';

							start_chat_val=0;

						}

						request_refresh_point=1;

					}

				}

			}

			function request_send(){

				if(replay_target){

					urlm='<?php echo base_url();?>new_Chat/start_Chat/<?php echo $pnodeId;?>';

					var data='reply=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&title='+document.getElementById('title').value+'&replyDiscussion='+document.getElementById('replyDiscussion').value+'&starttime='+document.getElementById('starttime').value+'&endtime='+document.getElementById('endtime').value;

				}else{

					urlm='<?php echo base_url();?>new_Chat/index/<?php echo $treeId;?>';

					data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+document.getElementById('replyDiscussion').value;

					//alert(urlm+data);

				}	

				http1.open("POST", urlm, true); 

				http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				http1.onreadystatechange = handleHttpResponsem1;     

				http1.send(data);

			}

			var http2 = getHTTPObjectm();

			function handleHttpResponsem2() 

			{    

				if(http2.readyState == 4) { 

					if(http2.status==200) { 

						var results=http2.responseText; 

						document.getElementById('chat_msg').innerHTML=results;

						document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;

						

					}

				}

			}

			function request_refresh(){

				if(request_refresh_point){

					url='<?php echo base_url();?>view_Chat/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';

				//	alert(url);

					http2.open("GET", url,true); 

			 		http2.onreadystatechange = handleHttpResponsem2; 

					http2.send(null); 

				}

			}

			function showFilteredMembers()
			{

				var toMatch = document.getElementById('showMembers').value;

				var val = '';

				//if (toMatch!='')

				if (1)
				{
					<?php

					if ($workSpaceMembers==0)
					{
					?>
						if (toMatch=='')
						{
							val +=  '<input type="checkbox"  class="users" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';
						}

					<?php
					}
					else
					{
					?>
						if (toMatch=='')
						{
							val +=  '<input type="checkbox" name="taskUsers[]"  class="users" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

							//val +=  '<input type="checkbox" name="taskUsers[]" class="allcheck" value="0"/><?php echo $this->lang->line('txt_All');?><br>';
						}

					<?php
					}

					if ($workSpaceId != 0)
					{

						foreach($workSpaceMembers as $arrData)	
						{

							if ($arrData['userId'] != $_SESSION['userId'])
							{
							?>
								var str = '<?php echo $arrData['tagName']; ?>';

								var pattern = new RegExp('\^'+toMatch, 'gi');

								if (str.match(pattern))
								{
									val +=  '<input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

									document.getElementById('showMem').innerHTML = val;
								}

								<?php
							}
		        		}
					}
					else
					{
						foreach($workSpaceMembers as $arrData)	
						{
							if ($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers))
							{

							?>
								var str = '<?php echo $arrData['tagName']; ?>';

								var pattern = new RegExp('\^'+toMatch, 'gi');

								if (str.match(pattern))
								{

									val +=  '<input type="checkbox" name="taskUsers[]"  class="users" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

									document.getElementById('showMem').innerHTML = val;

								}
								<?php
							}
		        		}
					}
		        	?>
				}
			}
		</script>
	</head>

	<body>
		<form name="formAddSubTask<?php echo $pnodeId;?>" id="formAddSubTask<?php echo $pnodeId;?>" method="post" action="<?php echo base_url();?>new_task/start_sub_task/<?php echo $pnodeId;?>/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>">

			<?php 
			$treeStatus = 0;
			$treeDetail = $this->task_db_manager->getDiscussionDetailsByNodeId( $pnodeId );

			$treeId = $treeDetail['treeId'];

			if($this->uri->segment(8) != '' && $this->uri->segment(8) > 0)
			{

				$treeStatus = 1;

				$nodeId		= $this->uri->segment(8);	

				$arrDiscussions	= $this->task_db_manager->getNodesByPredecessor($nodeId);
			}
			?>


			<table width="75%" style="margin-left:70px;" border="0" cellspacing="6" cellpadding="1" class="tbl" >

				<?php
				if(0)
				{	
				?> 
					<tr>
						<td width="24%" style="margin:0px; padding:0px;"><?php echo $this->lang->line('txt_Sub_List_Title');?> </td>
						<td>  
			            	<textarea name="title" id="title"><?php echo $treeDetail['contents']; ?></textarea>
						</td>
						<td>&nbsp;</td>
					</tr>
				<?php
				}
				?>		

			    <tr>
			      <td valign="top" style="margin:0px; padding:0px; " width="24%" ><span id="vk12345"></span><br>

			          <?php echo $this->lang->line('txt_Sub_Task');?>: &nbsp;  </td>

			      <td valign="top" class="taskEditorWidth">
			      	<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
			      	<div class="talkform<?php echo $pnodeId;?> handCursor">
			      		<textarea name="replyDiscussion<?php echo $pnodeId;?>" id="replyDiscussion<?php echo $pnodeId;?>" rows="3" cols="35"></textarea>
			      	</div>
			      </td>

			      <td>&nbsp;</td>

			    </tr>

			    <tr>
				    <td style="margin:0px; padding:0px;"  >
							<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> 

							<span style="vertical-align:top" ><?php echo $this->lang->line('txt_Start_Time');?>:</span> 
					</td>

				    <td style="margin:0px; padding:0px;">
						<!--	<input type="checkbox" name="startCheck" onClick="calendarStartCheck(this)">
					<input name="starttime" type="text" id="starttime" class="sdp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');?>" readonly style="background-color:#CCCCCC;color:#626262;"> -->
						
						<!--Commented by Dashrath- comment old code and new code for start time start 9:00-->
						<!-- <input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
						<input name="starttime" type="text" style="background-color:#CCCCCC;color:#626262;" class="sdp" id="starttime<?php echo $this->uri->segment(9);?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>" readonly> --> 

						<input type="checkbox" id="startCheck" name="startCheck" onClick="calStartCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y 09:00');?>')">
						<input name="starttime" type="text" style="background-color:#CCCCCC;color:#626262;" class="sdp" id="starttime<?php echo $this->uri->segment(9);?>" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 09:00" readonly> 
					</td>

			    	<td>&nbsp;</td>
			  	</tr>

				<tr>

			    	<td style="margin:0px; padding:0px;">

						<img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> 

						<span style="vertical-align:top" >	<?php echo $this->lang->line('txt_End_Time');?>:</span> 
					</td>

			    	<td style="margin:0px; padding:0px;">
						<!--	<input type="checkbox" name="endCheck" onClick="calendarEndCheck(this)">
						<input name="endtime" type="text" class="edp" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'd-m-Y H:i');?>" readonly style="background-color:#CCCCCC; color:#626262;">-->
				
						<!-- <input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>')">
						<input name="endtime" type="text" style="background-color:#CCCCCC;color:#626262;" id="endtime<?php echo $this->uri->segment(9);?>" class="edp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y H:i');?>" readonly > -->

						<!--Commented by Dashrath- comment old code and new code for end time start 17:00-->
						<input type="checkbox" id="endCheck" name="endCheck" onClick="calEndCheck(this, <?php echo $pnodeId;?>, document.formAddSubTask<?php echo $pnodeId;?>,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 17:00')">
						<input name="endtime" type="text" style="background-color:#CCCCCC;color:#626262;" id="endtime<?php echo $this->uri->segment(9);?>" class="edp" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');?> 17:00" readonly >
					</td>

			    	<td>&nbsp;</td>
				</tr>

				<tr id="mark_calender<?php echo $pnodeId;?>" style="display:none;">
					<td width="24%" valign="top" style="margin:0px; padding:0px;">

						<span id="vk12345"><?php echo $this->lang->line('txt_Mark_to_calendar');?>: </span><br>

					</td>

				    <td width="66%" valign="top" style="margin:0px; padding:0px;">&nbsp;

				      <!--Commented by Dashrath- comment old code and add new code below for by default show in calendar-->
				      <!-- <input type="radio" name="calendarStatus" value="Yes">
			          <?php echo $this->lang->line('txt_Yes');?> &nbsp;
			          <input name="calendarStatus" type="radio" value="No" checked>
			          <?php echo $this->lang->line('txt_No');?> -->
			          <!--Dashrath- comment code end--> 

			          <!--Added by Dashrath- By default mark to calendar (Yes) checked-->
			          <input type="radio" name="calendarStatus" value="Yes" checked>
			          <?php echo $this->lang->line('txt_Yes');?> &nbsp;
			          <input name="calendarStatus" type="radio" value="No">
			          <?php echo $this->lang->line('txt_No');?>
			          <!--Dashrath- code end--> 

			      	</td>

				    <td valign="top">&nbsp;</td>

				</tr>

				<tr>

			    	<td valign="top" style="margin:0px; padding:0px;"><?php echo $this->lang->line('txt_Assigned_To');?>:</td>

					<td align="left" colspan="2">
						<input type="text" id="showMembers" name="showMembers" onKeyUp="showFilteredMembers()"/>                    
					</td>               
				</tr> 

				<tr>

			    	<td valign="top" style="margin:0px; padding:0px;">&nbsp;</td>

			    	<td valign="top">

			            <?php	

						$members='';

						if($workSpaceId==0)
						{								
							foreach($workSpaceMembers as $arrData)
							{
								if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
								{						
									$members .='<input type="checkbox" name="taskUsers[]"  class="users" value="'.$arrData['userId'].'"/>'.$arrData['tagName'].'<br />';	
								}
							}
						}
						else
						{
							foreach($workSpaceMembers as $arrData)
							{
								if($_SESSION['userId'] != $arrData['userId'])
								{						
									$members .='<input type="checkbox" name="taskUsers[]" class="users" value="'.$arrData['userId'].'"/>'.$arrData['tagName'].'<br />';
								}
							}
						}
						?>

				        <input type="checkbox" name="taskUsers[]" value="0" class="allcheck"/> <?php echo $this->lang->line('txt_All');?><br />

						<div id="showMem" style="height:100px; width:300px;overflow:auto;" class="usersList">

				        <input type="checkbox" name="taskUsers[]" class="users" value="<?php echo $_SESSION['userId'];?>" checked="checked"/> <?php echo $this->lang->line('txt_Me');?><br />

				        <?php echo $members;?></div>

				        <!--umwanted tag close-->
				    	<!-- </div> -->
					</td>

			    	<td valign="top">&nbsp;</td>
			 	</tr>

				<tr>
					<td align="left" style="margin:0px ; padding:0px;">

					<?php echo $this->lang->line('txt_Completion_Status');?>:</td>

					<td align="left" >&nbsp;<input type="radio" name="completionStatus" value="0" checked="checked" >0% &nbsp;&nbsp;&nbsp; 

						<input type="radio" name="completionStatus" value="1" >25% &nbsp;&nbsp;&nbsp;

						<input type="radio" name="completionStatus" value="2" >50%	&nbsp;&nbsp;&nbsp;

						<input type="radio" name="completionStatus" value="3" >75% &nbsp;&nbsp;&nbsp;

						<input type="radio" name="completionStatus" value="4" >Completed	&nbsp;&nbsp;

					</td>
				</tr>

				<!-- <tr> -->

				<tr>

				  	<td valign="top" style="margin:0px; padding:0px;">&nbsp;</td>

				  	<td valign="top" style="margin:0px; padding:0px;">

						<?php

						$addMoreDisplay = '';

						if($treeStatus == 0)
						{
							$addMoreDisplay = 'none';
						}

						$cancelUrl = base_url().'view_task/node_task/'.$pnodeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
						?>

						<div id="loader1"></div>

				    	<span id="butDone">

				    		<!--Commented by Dashrath- comment old code and add new code below with changes onclick function-->
				    		<!-- <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Add');?>" onClick="validate_dis(<?php echo $pnodeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $linkType;?>,formAddSubTask<?php echo $pnodeId;?>);" class="button01">  -->

				    		<!--Added by Dashrath- change onclick function in new code-->
				    		<input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Add');?>" onClick="validate_dis_new(<?php echo $pnodeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $linkType;?>,formAddSubTask<?php echo $pnodeId;?>);" class="button01"> 
				    		<!--Dashrath- code end-->

				    	</span>
					

						<span id="butCancel">   

				   			<?php /* <input type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="cancelTask('<?php echo $cancelUrl;?>');" class="button01">
				         	*/
							?>	

							<!--Commented by Dashrath- Comment old code and add new code below with onclick function change-->
							<!-- <input style="float:left;" type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New_replyDiscussion('<?php echo $nodeId;?>');closeCalendar();" class="button01"> -->

							<input style="float:left;" type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="hideTaskView1New_replyDiscussionNew('<?php echo $nodeId;?>');closeCalendar();" class="button01"> 
					 	</span>

						<div id="audioRecordBox"><div style="float:left;margin-top:0.4%; margin-left:1%;"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'<?php echo $pnodeId;?>');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record<?php echo $pnodeId;?>" style="display:none; margin-left:2%; margin-top:0%; float:left;"></div></div>
					

						<input name="reply" type="hidden" id="reply" value="1">

						<input name="editorname1" type="hidden"  value="replyDiscussion">

				        <!--<input name="editorname2" type="hidden" value="title">-->

						<input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

						<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

						<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

						<input type="hidden" name="curOption" id="curOption" value="1">

						<input type="hidden" name="treeStatus" id="treeStatus" value="<?php echo $treeStatus;?>">				

						<input type="hidden" name="titleStatus" value="0" id="titleStatus">

						<input name="leafId" type="hidden" id="reply" value="<?php echo $treeDetail['leafId'];?>">

						<input name="nodeId" id="nodeId" type="hidden" value="<?php echo $pnodeId;?>">	
					</td>

					<td valign="top">&nbsp;</td>

				</tr>
			</table>                
		</form>

		<?php 
		$this->load->view('common/foot_new_task.php');
		?>
	</body>
</html>

<script>
//chnage_textarea_to_editor('title','simple');

chnage_textarea_to_editor('replyDiscussion<?php echo $pnodeId;?>','simple');

function reply(id)
{
	divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
	//parent.frames[id].gk.EditingArea.focus();
	rameid=id;	
}

function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}

$(function() {

	$("input[type='checkbox']").click(function(){

		if($(this).hasClass('allcheck')){

			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".users").prop( "checked" ,true);

		}
		else if($(this).hasClass('allUncheck')){

			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".users").attr('checked',false);
		}

	});
});
</script>



