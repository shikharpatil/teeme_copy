<script>

function validate_dis(replyDiscussion,formname)

	{  

		var error='';



	//replyDiscussion1=replyDiscussion+'1';

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

	

	//var getvalue=CKEDITOR.instances[INSTANCE_NAME].getData();

	var getvalue = getvaluefromEditor(INSTANCE_NAME);

	

	if(getvalue == ''){

		error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error=='')

	{ 

		$("[name=Replybutton]").hide();

		$("[name=Replybutton1]").hide();

		//$("#loader").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		$("#loaderSeed").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

	

		var replyDiscussion0=getvalue;

		//var replyDiscussion0=CKEDITOR.instances[INSTANCE_NAME].getData();

		var editorname1 = document.getElementById('editorname1').value;

		var predecessor = document.getElementById('seedpredecessor').value;

		var successors = document.getElementById('seedsuccessors').value;

		var reply = document.getElementById('reply').value;

		var treeId = document.getElementById('treeId').value;

		var httpNote1 = GetXmlHttpObject2();

		var urlm=baseUrl+'notes/addMyNotesAjax/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

		var data='replyDiscussion0='+encodeURIComponent(replyDiscussion0)+'&reply='+reply+'&predecessor='+predecessor+'&successors='+successors+'&editorname1='+editorname1; 

		httpNote1.open("POST", urlm, true); 

		node_lock=0;

		httpNote1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpNote1.onreadystatechange = function()

		{

			if (httpNote1.readyState==4 && httpNote1.status==200)

			{

				//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

				//CKEDITOR.instances[INSTANCE_NAME].destroy();

				editorClose(INSTANCE_NAME);

			    document.getElementById('datacontainer').innerHTML=httpNote1.responseText;

				$("[name=Replybutton]").show();

				$("[name=Replybutton1]").show();

				//$("#loader").html("");
				$("#loaderSeed").html("");

				editorCheck();

				//document.getElementById('divNodeContainer').innerHTML=httpNote1.responseText;

				//document.getElementById('0notes').style.display='none';

			}

		}     

		httpNote1.send(data);

		//formname.submit();

	}

	else

	{

		jAlert(error);

	}

	

	}

	

	function reply_close12(id){

	

	node_lock=0;

	divid=id+'notes';

	

	//CKEDITOR.instances.replyDiscussion0.destroy();

	editorClose('replyDiscussion0');

	

	if( document.getElementById('containerseed'))

	{

	  var objEditleaf = document.getElementById('containerseed');



				  while (objEditleaf.hasChildNodes()) {

								objEditleaf.removeChild(objEditleaf.lastChild);

							}

	}

	//tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion0');

	//setValueIntoEditor('replyDiscussion0');

 	document.getElementById(divid).style.display='none';

}



function reply(id,focusId)

{ 

	var divid=id+'notes';

	

	if(node_lock==1)

	{

		jAlert('<?php echo $this->lang->line('save_cancel_current_leaf'); ?>');

		//return false;

	}

	else

	{
	
	document.getElementById('loader'+id).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

	node_lock=1;
	
	//Manoj: First display block then add editor start
	document.getElementById(divid).style.display='block';
	//Manoj: First display block then add editor end
	
	editor_code('','replyDiscussion0','containerseed');
	//Manoj: remove version simple
	chnage_textarea_to_editor('replyDiscussion0','');
	
	document.getElementById('loader'+id).innerHTML =" ";

	//document.getElementById(divid).style.display='block';
	
	//setValueIntoEditor('replyDiscussion0','');	

	//tinyMCE.execCommand('mceFocus',false,'replyDiscussion0'); 

	//setValueIntoEditor('replyDiscussion'+id,'');

	}

	

}


	function addLeaf(leafId,treeId, leafOrder,nodeId,successors){ 
	//alert ('Here');
	//if(document.getElementById('editStatus').value == 1)

	if(node_lock==1)

	{

		jAlert('<?php echo $this->lang->line('save_cancel_current_leaf'); ?>');

		//return false;

	}

	else

	{
	
	document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";	

	node_lock=1;

 	document.getElementById('addleaf'+leafOrder).style.display="";

	

	if( document.getElementById('addleaf'+leafOrder))

								{

								  var objEditleaf = document.getElementById('addleaf'+leafOrder);

							

											  while (objEditleaf.hasChildNodes()) {

															objEditleaf.removeChild(objEditleaf.lastChild);

														}

								}

	

	//tinyMCE.execCommand('mceRemoveControl', true, 'editorLeafContentsAdd'+leafOrder+'1');

	editor_code('','editorLeafContentsAdd'+leafOrder+'1','addleaf'+leafOrder);

	hideall();
	
	const recordVal = "'note'";
	
	//document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div style="width:785px; float:left; padding:10px;"><form id="form2" name="form2" method="post" enctype = "multipart/form-data" action="notes/editNotesContents1/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'"  ><input name="totalNodes" id="totalNodes" type="hidden"  value="'+parseInt(leafOrder-1)+'"><input type="hidden" name="curFocus" value="0" id="curFocus"><input type="hidden" name="curLeaf" value="0" id="curLeaf"><input type="hidden" name="editStatus" value="0" id="editStatus"><input type="hidden" name="curContent" value="0" id="curContent"><input type="hidden" name="reply" value="1" id="reply"><input type="hidden" name="successors" value="0" id="successors"><input type="hidden" name="curNodeId" value="0" id="curNodeId"><input type="hidden" name="treeId" value="'+treeId+'" id="treeId"><input type="hidden" name="curLeafOrder" value="0" id="curLeafOrder"><input type="hidden" name="curOption" value="add" id="curOption"><input type="hidden" name="workSpaceId" value="'+workSpaceId+'" id="workSpaceId"><input type="hidden" name="workSpaceType" value="'+workSpaceType+'" id="workSpaceType"><div id="loader" style="width:18%; float:left;">	<a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+','+nodeId+','+successors+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Done');  ?>" /></a> <a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+','+nodeId+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Cancel');  ?>" /></a></div><div id="audioRecordBox"><div style="float:left;margin-top:0.7%"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:2%; margin-top:0%; float:left;"><input onClick="startRecording(this,'+recordVal+');" type="button"  class="button01" value="Record"   /><input onClick="stopRecording(this);" type="button"  class="button01" value="Stop" disabled  /></div></div></form></div>';
	
	document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div style=""><form id="form2" name="form2" method="post" enctype = "multipart/form-data" action="notes/editNotesContents1/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'"  ><input name="totalNodes" id="totalNodes" type="hidden"  value="'+parseInt(leafOrder-1)+'"><input type="hidden" name="curFocus" value="0" id="curFocus"><input type="hidden" name="curLeaf" value="0" id="curLeaf"><input type="hidden" name="editStatus" value="0" id="editStatus"><input type="hidden" name="curContent" value="0" id="curContent"><input type="hidden" name="reply" value="1" id="reply"><input type="hidden" name="successors" value="0" id="successors"><input type="hidden" name="curNodeId" value="0" id="curNodeId"><input type="hidden" name="treeId" value="'+treeId+'" id="treeId"><input type="hidden" name="curLeafOrder" value="0" id="curLeafOrder"><input type="hidden" name="curOption" value="add" id="curOption"><input type="hidden" name="workSpaceId" value="'+workSpaceId+'" id="workSpaceId"><input type="hidden" name="workSpaceType" value="'+workSpaceType+'" id="workSpaceType"><div id="loader" style="float:left;">	<a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+','+nodeId+','+successors+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Done');  ?>" /></a> <a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+','+nodeId+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Cancel');  ?>" /></a></div><div id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div></form></div>';



	chnage_textarea_to_editor('editorLeafContentsAdd'+leafOrder+'1');
	
	document.getElementById('loader'+nodeId).innerHTML =" ";

	//setValueIntoEditor('editorLeafContentsAdd'+leafOrder+'1','');

	//tinymce.execCommand('mceFocus',false,'editorLeafContentsAdd'+leafOrder+'1');

	}

}



function newLeafSave(leafId, treeId,leafOrder,nodeId,successors) 

{	

	var INSTANCE_NAME = $("#editorLeafContentsAdd"+leafOrder+"1").attr('name');

	

    //var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();

	var getvalue	= getvaluefromEditor(INSTANCE_NAME);

	//alert (getvalue);

	var editorId = "editorLeafContentsAdd"+leafOrder+"1";

	//var getvalue=getvaluefromEditor(editorId);

	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1){

		jAlert('<?php //echo $this->lang->line('enter_your_note'); ?>');

		return false;

	}*/
	if (getvalue == ''){

		jAlert('<?php echo $this->lang->line('enter_your_note'); ?>');

		return false;

	}

	else

	{

	 	node_lock=0;

	}

	

	document.getElementById("loader").innerHTML="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

			

	xmlHttpTree=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

	xmlHttpTree.onreadystatechange = function(){

			

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

					//alert (isLatest);

					if(isLatest==0)

					{

						jAlert ('<?php echo $this->lang->line('can_not_created_new_idea'); ?>');

						return false;

					}

					else

					{

						//var replyDiscussion0=getvaluefromEditor(replyDiscussion);

						var totalNodes = document.getElementById('totalNodes').value;

						var curFocus = document.getElementById('curFocus').value;

						var curLeaf = leafId;

						var curContent = escape(getvalue);

						var reply = document.getElementById('reply').value;

						//var successors = successors;

						var curNodeId = nodeId;

						var treeId = document.getElementById('treeId').value;

						var curLeafOrder = leafOrder;

						var curOption = 'add';

						var workSpaceId = document.getElementById('workSpaceId').value;

						var workSpaceType = document.getElementById('workSpaceType').value;

					

					

		var data='totalNodes='+totalNodes+'&curFocus='+curFocus+'&curLeaf='+curLeaf+'&curContent='+curContent+'&reply='+reply+'&successors='+successors+'&curNodeId='+curNodeId+'&treeId='+treeId+'&curLeafOrder='+curLeafOrder+'&curOption='+curOption+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;		

		var httpNote1 = GetXmlHttpObject2();

						

		var urlm=baseUrl+'notes/editNotesContents1New/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

		

		

		

		httpNote1.open("POST", urlm, true); 

	

		httpNote1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpNote1.onreadystatechange = function()

		{

		

			if (httpNote1.readyState==4 && httpNote1.status==200)

			{

				editorClose(INSTANCE_NAME);//CKEDITOR.instances[INSTANCE_NAME].destroy();

				//getNotesDetails(treeId,workSpaceId,workSpaceType);

				document.getElementById('datacontainer').innerHTML = httpNote1.responseText;	

				//$(".lblNotesDetails").hide();

				editorCheck();

				//tinyMCE.execCommand('mceRemoveControl', true, 'editorLeafContentsAdd'+leafOrder+'1');	

				

				//document.getElementById('divNodeContainer').innerHTML=httpNote1.responseText;

				//document.getElementById('0notes').style.display='none';

			}

		}     

		httpNote1.send(data);

		//formname.submit();

		

		

	}



		}					

	}



			

			}

	

			xmlHttpTree.open("GET", url, true);

			xmlHttpTree.send(null);

	

	//document.frmEditLeaf.submit();

	//return true;		

}







function editNotesContents_1(id,focusId,treeId,workSpaceId,workSpaceType,nodeId,textDone,successors,leafId)
{

		if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=6";
					$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							
							//alert(result);
							
							result = result.split("|||");
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else
							{

	leafId1=leafId;

	 treeId1=treeId;

	 nodeId1=nodeId;

	 workSpaceId1=workSpaceId;

	 workSpaceType1=workSpaceType;

	 id1=id;

	 successors1=successors;

	 textDone1=textDone;

	// position1=position;

	var temp=editLeafNote(leafId1,position1,treeId1,nodeId1);
	
	} //else end
	} //success end
	});

	

}



function editLeafNote(leafId, leafOrder,treeId,nodeId) 

{  

	//if(document.getElementById('editStatus').value == 1)

	if(node_lock==1)

	{

		jAlert('<?php echo $this->lang->line('save_cancel_current_leaf'); ?>');

		return false;

	}

	

	else

	{

		//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

		initialleafcontentId='initialleafcontent'+leafOrder1;

		hideall();

		

		xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

		xmlHttpTree.onreadystatechange = handleNoteTreeVersion;

		

		xmlHttpTree.open("GET", url, true);

		xmlHttpTree.send(null);

	}

}

function handleNoteTreeVersion(){

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

			//alert (isLatest);

			if(isLatest==0)

			{

				jAlert ('<?php echo $this->lang->line('can_not_edited'); ?>');

				return false;

			}

			else

			{

				//document.frmEditLeaf.submit();

				//return true;

				xmlHttp=GetXmlHttpObject2();

				var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

				xmlHttp.onreadystatechange = handleNoteLockLeafEdit;				

				xmlHttp.open("GET", url, true);

				xmlHttp.send(null);

			}



		}					

	}

}

function handleNoteLockLeafEdit(){

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;		

			//alert(strResponseText);

			if(strResponseText == 0)

			{

			 	
				document.getElementById('loader'+nodeId1).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
				

				/* Fetching last version of leaf */

				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/getLeafDetail/leafId/"+leafId1;

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;


								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");

									//alert ('leafOrder1= ' + leafOrder1);

									//alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);
									//alert(arrNode[0]);

									if (arrNode[0].match(/onlyContents/g))
									{
										contents=arrNode[1];
									}
									else
									{
										leafId1=arrNode[1];

										leafId2=arrNode[1];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										contents=arrNode[4];
									}
									

								}

				

				

				

				if( document.getElementById('editleaf'+id1))

				{

				  var objleafAddFirst = document.getElementById('editleaf'+id1);

			

							  while (objleafAddFirst.hasChildNodes()) {

											objleafAddFirst.removeChild(objleafAddFirst.lastChild);

										}

				}

				

				//tinyMCE.execCommand('mceRemoveControl', true, 'editorLeafContents'+id1+'1');

				//document.getElementById('editStatus').value = 1;

				//var val=document.getElementById('initialleafcontent'+leafOrder1).value;

				document.getElementById('editleaf'+id1).style.display="";

				//document.getElementById('editStatus').value = 1;

								

				editor_code(contents,'editorLeafContents'+id1+'1','editleaf'+id1);

				const recordVal = "'note'";

				//document.getElementById('editorLeafContents'+id1+'1sp').innerHTML='<table width="8%" border="0" align="center" cellpadding="2" cellspacing="0" style="float:left;"><tr><td colspan="4" align="left"><a href="javascript:void(0)" onclick="editLeafSave1('+leafId1+','+treeId1+','+id1+','+nodeId1+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Done');  ?>" /></a><a href="javascript:void(0)" onclick="canceleditLeaf1('+leafId1+','+nodeId1+','+treeId1+','+id1+')"><input type="button" class="button01" value="<?php echo  $this->lang->line('txt_Cancel');  ?>" /></a></td></tr></table><div id="audioRecordBox"><div style="float:left;margin-top:0.5%; margin-left:5px;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'+id1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+id1+'" style="display:none; margin-left:1%; margin-top:0.1%; float:left;"><button onClick="startRecording(this,'+recordVal+');">Record</button><button onClick="stopRecording(this);" disabled>Stop</button></div></div><div id="loaderImage"></div>';
				
				document.getElementById('editorLeafContents'+id1+'1sp').innerHTML='<div><a href="javascript:void(0)" onclick="editLeafSave1('+leafId1+','+treeId1+','+id1+','+nodeId1+')"><input style="float:left;" type="button" class="button01" value="<?php echo  $this->lang->line('txt_Done');  ?>" /></a><a href="javascript:void(0)" onclick="canceleditLeaf1('+leafId1+','+nodeId1+','+treeId1+','+id1+')"><input style="float:left;" type="button" class="button01" value="<?php echo  $this->lang->line('txt_Cancel');  ?>" /></a><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'+id1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+id1+'" style="display:none; margin-left:1%; margin-top:0.1%; float:left;"></div></span></div><div id="loaderImage"></div>';

				chnage_textarea_to_editor('editorLeafContents'+id1+'1');
				
				document.getElementById('loader'+nodeId1).innerHTML =" ";
				
				//Manoj: froala editor hide content on edit note leaf
				//alert('test'+nodeId1);
				document.getElementById('noteLeafContent'+nodeId1).style.display="none";

				setValueIntoEditor('editorLeafContents'+id1+'1',contents);	

				

				// lock for no othe lead can be edit or add untill this not realease...

				node_lock=1;

				xmlHttpLast11=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+nodeId1;

				xmlHttpLast11.onreadystatechange=function() {

				if (xmlHttpLast11.readyState==4) {

					//alert (url);

					// editing new leaf

					

								

						}

					}

						

				xmlHttpLast11.open("GET", url, true);

				xmlHttpLast11.send(null);

				

				}

				}

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);



			}

			else

			{	

				alert(strResponseText);					

			}					

		}

	}

}



function canceleditLeaf1(leafId,nodeId, treeId, leafOrder) 

{ 

  	document.getElementById('editleaf'+leafOrder).style.display="none";

	document.getElementById('normalView'+nodeId).style.display="none";

	node_lock=0;

	//tinyMCE.execCommand('mceRemoveControl', true, 'editleaf'+leafOrder);

	var INSTANCE_NAME = $("#editorLeafContents"+leafOrder+"1").attr('name');

	getUpdatedContents(nodeId,2);

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

	editorClose(INSTANCE_NAME);

	//Manoj: froala editor show note leaf content on cancel
	
	document.getElementById('noteLeafContent'+nodeId).style.display="block";

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		

		xmlHttp1.open("GET", queryString, true);

		xmlHttp1.send(null);
		
		getTreeLeafUserStatus(treeId,nodeId,6);	

}



/*function editLeafSave1(leafId, treeId,leafOrder,nodeId) 

{	

   

	

 	document.getElementById('normalView'+nodeId).style.display="none";

  	var editorId = "editorLeafContents"+leafOrder+"1";

	var INSTANCE_NAME = $("#editorLeafContents"+leafOrder+"1").attr('name');

	

	//var getvalue=CKEDITOR.instances[INSTANCE_NAME].getData();

	var getvalue=getvaluefromEditor(INSTANCE_NAME);

	

	//var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;

	

  	if (getvalue=='')

	{

			jAlert ('<?php echo $this->lang->line('enter_your_note'); ?>');

			return false;

	}

	else

	{

		node_lock=0;

	

	

	

	//document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);		

	

	

	var httpNote = GetXmlHttpObject2();

		

		

	var urlm=baseUrl+'notes/editNotesContents1/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

	var data='curContent='+encodeURIComponent(getvalue)+'&reply=1&curOption=edit&curLeafOrder='+leafOrder+'&curNodeId='+nodeId+'&curLeaf='+leafId;

	

	

	httpNote.open("POST", urlm, true); 

	httpNote.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	httpNote.onreadystatechange = function()

	  { 

		    if (httpNote.readyState==4 )

			{

				//CKEDITOR.instances[INSTANCE_NAME].destroy();

				document.getElementById('leaf_contents'+nodeId).innerHTML=getvalue;

				document.getElementById('editleaf'+leafOrder).style.display="none";

				document.getElementById('normalView'+leafOrder).style.display="none";

				//tinyMCE.execCommand('mceRemoveControl', true, editorId);

			}

	  }     

	httpNote.send(data);

	alert(httpNote.response);

}



}

*/

	

function editLeafSave1(leafId, treeId,leafOrder,nodeId) {

		

   

	

 	document.getElementById('normalView'+nodeId).style.display="none";

  	var editorId = "editorLeafContents"+leafOrder+"1";

	var INSTANCE_NAME = $("#editorLeafContents"+leafOrder+"1").attr('name');

	

	//var getvalue=CKEDITOR.instances[INSTANCE_NAME].getData();

	var getvalue=getvaluefromEditor(INSTANCE_NAME);

	

	//var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;

	

  	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1)

	{

		jAlert ('<?php //echo $this->lang->line('enter_your_note'); ?>');

		return false;

	}*/
	if (getvalue == '')

	{

		jAlert ('<?php echo $this->lang->line('enter_your_note'); ?>');

		return false;

	}

	else

	{

		node_lock=0;

	

	

	

	//document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);		

	

	$("[value=Done]").hide();

		$("[value=Cancel]").hide();

		$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

	var httpNote = GetXmlHttpObject2();

		

		

	var urlm=baseUrl+'notes/editNotesContents1/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

	

	$.post(urlm,{'curContent':getvalue,'reply':1,'curOption':'edit','curLeafOrder':leafOrder,'curNodeId':nodeId,'curLeaf':leafId},function(data){

		//alert($('#normalView'+nodeId+" > .style2").text());

		//CKEDITOR.instances[INSTANCE_NAME].destroy();

		editorClose(INSTANCE_NAME);

		$("[value=Done]").show();

		$("[value=Cancel]").show();

		document.getElementById('leaf_contents'+nodeId).innerHTML=getvalue;

		document.getElementById('editleaf'+leafOrder).style.display="none";

		var content = $('#normalView'+nodeId+" > .style2 > div").html();

		

		$('#normalView'+nodeId+" > .style2").html("<div style='float:left'>"+content+"</div>"+data);

		//Manoj: froala editor show content on edit note leaf
		document.getElementById('noteLeafContent'+nodeId).style.display="block";
		
		hideNotesNodeOptions(nodeId);
		
		//tinyMCE.execCommand('mceRemoveControl', true, editorId);

		

	});

}

	

}



function editLeafSave1_old(leafId, treeId,leafOrder,nodeId) 

{	

  //document.getElementById('editleaf'+leafOrder).style.display="none";

  

  	if (getvalue=='')

	{

		jAlert ('<?php echo $this->lang->line('enter_your_note'); ?>');

		return false;

	}

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);		

	var editorId = "editorLeafContents"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;

		

	

	//var originalContents = document.getElementById('initialleafcontent'+leafOrder).value;

	document.form2.curContent.value = getvalue;

	document.form2.curLeaf.value = leafId;	

	document.form2.curLeafOrder.value = leafOrder;

	document.form2.curNodeId.value = nodeId;	

	document.form2.curOption.value = 'edit';	



			

			document.form2.submit();		

			return true;

	



}



function validate_dis1(replyDiscussion,formname,nodeId)

	{

		var error='';



	//replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion) == ''){

		error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error==''){

	

		document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+nodeId;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	

		formname.submit();

	}else{

		jAlert(error);

	}	

}





function cancelnewLeaf( leafId,treeId, leafOrder,nodeId) 

{

	//tinyMCE.execCommand('mceRemoveControl', true, 'editorLeafContentsAdd'+leafOrder+'1');

	var INSTANCE_NAME = $("#editorLeafContentsAdd"+leafOrder+"1").attr('name');

	

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

  	 editorClose(INSTANCE_NAME);

	 document.getElementById('addleaf'+leafOrder).style.display="none";	

	 document.getElementById('normalView'+nodeId).style.display="none";	

	 node_lock=0;

}



function getNotesDetails(treeId,workSpaceId,workSpaceType){


	$.post(baseUrl+'/notes/DetailsAjax/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,{"treeId":treeId},function(data){

		if(data){

			

			$('#datacontainer').html(data);

			//$(".lblNotesDetails").hide();

		}

	});

}



</script>	