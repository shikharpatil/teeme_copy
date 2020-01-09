var leafId1;

function reply(id)

{ 

	divid = 'reply_teeme'+id;

	//alert ('divid= ' + divid);

	document.getElementById(divid).style.display='';

	detailId	= 'detail'+id;

	document.getElementById(detailId).style.display='none';

	//parent.frames[id].gk.EditingArea.focus();

	rameid=id;	

	chnage_textarea_to_editor('replyDiscussion','simple');

	tinymce.execCommand('mceFocus',false,'replyDiscussion');

}

function addTask(id, nodeId)

{	

	divid='add_task'+id;

	document.getElementById(divid).style.display='';

	if(nodeId == 0)

	{

		detailId='detail'+id;

		document.getElementById(detailId).style.display='none';		

	}

	else

	{		

		detailId='normalView'+nodeId;

		document.getElementById(detailId).style.display='none';

	}

	

	frameid=id;	

	chnage_textarea_to_editor('newTask'+nodeId,'simple');

	tinymce.execCommand('mceFocus',false,'newTask'+nodeId);



}

function addTaskFrame(id, nodeId,workSpaceId,workSpaceType, treeId, position)

{	

	var iframeid= 'iframeIdTask'+id;

	var spanTaskView = 'spanTaskView'+id;



	document.getElementById(iframeid).src = baseUrl+'new_task/new_task1/'+nodeId+'/index/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId+'/'+position;

	document.getElementById(iframeid).style.display = '';

	

	document.getElementById(spanTaskView).style.display='';

}





var leafOrder1;

var treeId1;

var nodeId1;

var xmlHttp;

var xmlHttpTree;

var workSpaceId1;

var workSpaceType1;

var position1;

var iframeid1;

var spanTaskView1;



function editthisFrame(id, nodeId,workSpaceId,workSpaceType, treeId, position)

{	

  

	 //leafId1=leafId;

	 //leafId2=leafId;

	// leafOrder1=leafOrder;

	 treeId1=treeId;

	 nodeId1=nodeId;

	 workSpaceId1=workSpaceId;

	 workSpaceType1=workSpaceType;

	 position1=position;



	// alert(nodeId);

	var temp=editLeafTask(nodeId1,position1,treeId1,nodeId1);

	

	 iframeid= 'iframeIdTaskEdit'+id;

	 spanTaskView = 'spanTaskEditView'+id;

	 iframeid1=iframeid;

	 spanTaskView1=spanTaskView;

	 

/*

	

*/	

	

}



function editLeafTask(leafId, leafOrder,treeId,nodeId) 

{  

	//alert ('leafId= ' + leafId + 'leafOrder= ' + leafOrder + 'treeId= ' + treeId + 'nodeId= ' +nodeId);

	//alert (document.getElementById('editStatus').value);

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}



	

	 initialleafcontentId='initialleafcontent'+leafOrder1;

	 hideall();

	 //alert(document.getElementById(initialleafcontentId).value);

	 

	 

	 

/*	xmlHttp=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

	xmlHttp.onreadystatechange = handleLockLeafEdit;				

	xmlHttp.open("GET", url, true);

	xmlHttp.send(null);*/

	

	

			xmlHttpTree=GetXmlHttpObject2();

			var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

			xmlHttpTree.onreadystatechange = handleTaskTreeVersion;

	

			xmlHttpTree.open("GET", url, true);

			xmlHttpTree.send(null);

}

function handleTaskTreeVersion(){

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

					//alert (isLatest);

					if(isLatest==0)

					{

						jAlert ('This leaf can not be edited because new version of this tree has been created.','Alert');

						return false;

						

						

					}

					else

					{

						//document.frmEditLeaf.submit();

						//return true;

						xmlHttp=GetXmlHttpObject2();

						var url =baseUrl+'lock_leaf'+"/index/leafId/"+nodeId1;

						xmlHttp.onreadystatechange = handleTaskLockLeafEdit;				

						xmlHttp.open("GET", url, true);

						xmlHttp.send(null);

					}



		}					

	}

}	

function handleTaskLockLeafEdit(){

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;		

			

			if(strResponseText == 0)

			{

				document.getElementById(iframeid).src = baseUrl+'new_task/leaf_edit_Task/'+nodeId1+'/index/'+workSpaceId1+'/type/'+workSpaceType1+'/'+treeId1+'/'+position1;

				document.getElementById(iframeid).style.display = 'block';

				

				document.getElementById(spanTaskView).style.display='block';

				/* Fetching last version of leaf */

             	/* comment By arun */

				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+nodeId1;

				

				xmlHttpLast.onreadystatechange=function() {

					if (xmlHttpLast.readyState==4) {

						//alert (url);

						// editing new leaf

						document.getElementById('editStatus').value = 1;

					}

				}

						

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);

				

				

				

				

			}else{	

				alert(strResponseText);					

			}					

		}

	}

}





function addSubTask(id, nodeId)

{	

	var divid='add_sub_task'+id;



	document.getElementById(divid).style.display='';



	if(nodeId == 0)

	{

		detailId='detail'+id;

		document.getElementById(detailId).style.display='none';		

	}

	else

	{		

		detailId='normalView'+nodeId;

		document.getElementById(detailId).style.display='none';

	}

	rameid=id;	



}

function hideTaskView (id,nodeId)

{ 

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+nodeId;

		

		

		tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+nodeId);

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	//location.reload(true);

	location.href = location.href;

}



function hideTaskView1New(leafId,cNodeId)

{

	//tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+leafId);

	var INSTANCE_NAME = $("#edittask"+leafId).attr('name');

	getUpdatedContents(cNodeId,2);
	
	setTagAndLinkCount(cNodeId,2);
	
	getSimpleColorTag(cNodeId,2);

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

	

	document.getElementById('editStatus').value= 0;

	//code for releasing lock on leaf	

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+leafId;

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

	editorClose("edittask"+leafId);
	
	

//close code for releasing lock	

	$(".taskFormContainer").html('');

	

	$(".clsEditTask").html('');
	
	//alert (document.getElementById('yearDropDown'));

	if(document.getElementById('yearDropDown'))

	{

	   closeCalendar(); /*Deepti : To close the calender*/

	}
	
	getTreeLeafUserStatus('',cNodeId,4);
	
	//Manoj: froala editor show task leaf content on cancel
	if(document.getElementById('taskLeafContent'+cNodeId))
	{
		document.getElementById('taskLeafContent'+cNodeId).style.display="block";
	}

	/*Added by Dashrath- add class for ui issue after editor shift below task div*/
	if($('.subTasks'+cNodeId).css('display') != 'block')
	{ 
		$('#taskLeafContentNew'+cNodeId).addClass("seedBackgroundColorNew");
	}
	/*Dashrath- code end*/

	document.getElementById('subTaskLeafContent'+cNodeId).style.display="block";

}

/*Added by Surbhi IV*/

function hideTaskView1New_newTask(nodeId)

{

	//tinyMCE.execCommand('mceRemoveControl', true, 'newTask'+nodeId);

	var INSTANCE_NAME = $("#newTask"+nodeId).attr('name');

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

	 editorClose(INSTANCE_NAME);

	//code for releasing lock on leaf	
	
	document.getElementById('editStatus').value= 0;

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+nodeId;

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

//close code for releasing lock	
	//alert('test');
	$(".taskFormContainer").html('');

	 

	$(".clsEditTask").html('');

	

	if(document.getElementById('yearDropDown'))

	{

		 closeCalendar(); /*Deepti : To close the calender*/

	}

}

function hideTaskView1New_replyDiscussion(nodeId)

{
	//tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion');
	//Manoj: sub task cancel for mobile
	var INSTANCE_NAME = $("#replyDiscussion").attr('name');
	editorClose(INSTANCE_NAME);
	
	document.getElementById('editStatus').value= 0;
	
	$(".taskFormContainer").html('');
	
	//Manoj: sub task cancel for mobile end
	//CKEDITOR.instances.replyDiscussion.destroy();

	var INSTANCE_NAME = $("#replyDiscussion"+nodeId).attr('name');
	editorClose(INSTANCE_NAME);

	if(document.getElementById('yearDropDown'))

	{

		 closeCalendar(); /*Deepti : To close the calender*/

	}

	//close code for releasing lock	

	$(".taskFormContainer").html('');

	 

	$(".clsEditTask").html('');
	
	//editorClose('replyDiscussion');
	


}

/*End of Added by Surbhi IV*/

function hideTaskView1 (id)

{ 



	document.getElementById("calStart"+id).style.display = 'none';

		document.getElementById("starttime").style.color	 = "#626262";	

		document.getElementById("starttime").style.backgroundColor = "#CCCCCC";	

		

		document.getElementById("calEnd"+id).style.display = 'none';

		document.getElementById("endtime").style.color	 = "#626262";	

		document.getElementById("endtime").style.backgroundColor = "#CCCCCC";	



	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+nodeId;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	//location.reload(true);

	location.href = location.href;

}

function hideTaskViewEditor (id)

{  

	//alert(id);

	//alert(nodeId);

	// document.getElementById('iframeIdTaskEdit'+id).src="none";

//	document.getElementById('spanTaskView'+id).style.display="";

	

	

	//location.reload(true);

	location.href = location.href;

}





function addSubTaskFrame(id, nodeId,workSpaceId,workSpaceType, treeId)

{	

	

	var iframeid= 'iframeIdSubTask'+id;

	var spanSubTaskView = 'spanSubTaskView'+id;

	document.getElementById(iframeid).src = baseUrl+'new_task/start_sub_task/'+nodeId+'/index/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId;

	document.getElementById(iframeid).style.display = 'block';

	

	document.getElementById(spanSubTaskView).style.display='block';

}



function hideSubTaskView (id,nodeId)

{

		

	//location.reload(true);

	location.href = location.href;

}

function cancelSubTask(id, nodeId)

{

	divid='add_sub_task'+id;

	document.getElementById(divid).style.display='none';

}

function addTaskClose(id, nodeId)

{

	divid='add_task'+id;

	document.getElementById(divid).style.display='none';

	detailId='normalView'+nodeId;

	document.getElementById(detailId).style.display='';

	

}

function reply_close(id){

	divid='reply_teeme'+id;

	document.getElementById("starttime0").style.backgroundColor='#cccccc';

	document.getElementById("endtime0").style.backgroundColor='#cccccc';

	document.getElementById("calStart0").style.display='none';

	document.getElementById("calEnd0").style.display='none';

 	document.getElementById(divid).style.display='none';

}



function vksfun(id){

	var fId=id;

	rameid=fId;

}



function showdetail(id, curNodeId)

{	

	var curNode		= 'detail'+id;

	var added		= 'add'+id;

	var allNodes 	= document.getElementById('totalNodes').value;

	var arrNodes 	= new Array();

	arrNodes 		= allNodes.split(',');

	for(var i = 0;i<arrNodes.length;i++)

	{		

		var nodeId = 'detail'+arrNodes[i];	

		var curAddId = 'add'+arrNodes[i]; 	

		if(id != arrNodes[i])

		{			

			document.getElementById(nodeId).style.display='none';	

			document.getElementById(curAddId).style.display='none';	

		}

	} 

	if(document.getElementById(curNode).style.display=='')		

	{

		document.getElementById(curNode).style.display='none';

		document.getElementById(added).style.display='none';	

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='none';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='none';

		}

	}

	else

	{

		document.getElementById(curNode).style.display='';

		document.getElementById(added).style.display='';

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='';

		}

	}

}

function showHideSubTaskdetail(id, curNodeId)

{	

	var curNode		= 'detail'+id;

	var added		= 'add'+id;



	if(document.getElementById(curNode).style.display=='')		

	{

		document.getElementById(curNode).style.display='none';

		document.getElementById(added).style.display='none';	

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='none';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='none';

		}

	}

	else

	{

		document.getElementById(curNode).style.display='';

		document.getElementById(added).style.display='';

		if(curNodeId == 0)

		{

			detailId='detail'+curNodeId;

			document.getElementById(detailId).style.display='';		

		}

		else

		{		

			detailId='normalView'+curNodeId;

			document.getElementById(detailId).style.display='';

		}

	}

}

function editthis(lid, nodeId){







	var spanId='latestcontent'+lid;

	var editorId='editThis'+lid;

	//document.getElementById(spanId).style.display='none';

	document.getElementById(editorId).style.display='';

	detailId	= 'normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

	chnage_textarea_to_editor('edittask'+lid,'simple');

	tinymce.execCommand('mceFocus',false,'edittask'+lid);

}

function editthis12(leafId,position ,treeId,nodeId,workSpaceId,workSpaceType){

	leafId1=leafId;

	 treeId1=treeId;

	 nodeId1=nodeId;

	 //alert(nodeId1)

	 workSpaceId1=workSpaceId;

	 workSpaceType1=workSpaceType;

	 position1=position;

	 

	

	

	

	var temp=editLeafSubTask(leafId1,position1,treeId1,nodeId1);

	

	 iframeid= 'iframeIdSubTaskEdit'+position;

	 spanTaskView = 'editThis'+position;

	 iframeid1=iframeid;

	 spanTaskView1=spanTaskView;

 

	

	

	





	/*var spanId='latestcontent'+lid;

	var editorId='editThis'+lid;

	//document.getElementById(spanId).style.display='none';

	document.getElementById(editorId).style.display='';

	detailId	= 'normalView'+nodeId;

	document.getElementById(detailId).style.display='none';

	chnage_textarea_to_editor('edittask'+lid,'simple');

	tinymce.execCommand('mceFocus',false,'edittask'+lid);*/

}





function editLeafSubTask(leafId, leafOrder,treeId,nodeId) 

{  

	//alert ('leafId= ' + leafId + 'leafOrder= ' + leafOrder + 'treeId= ' + treeId + 'nodeId= ' +nodeId);

	//alert (document.getElementById('editStatus').value);

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}



	

	 initialleafcontentId='initialleafcontent'+leafOrder1;

	 hideall();

	 //alert(document.getElementById(initialleafcontentId).value);

	 

	 

	 

/*	xmlHttp=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

	xmlHttp.onreadystatechange = handleLockLeafEdit;				

	xmlHttp.open("GET", url, true);

	xmlHttp.send(null);*/

	



	xmlHttp=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId;

	xmlHttp.onreadystatechange = handleSubTaskLockLeafEdit;				

	xmlHttp.open("GET", url, true);

	xmlHttp.send(null);

}

function handleSubTaskLockLeafEdit()

{ var content;

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;		

			

			if(strResponseText == 0)

			{

				//alert("gg"+nodeId);

				document.getElementById(iframeid1).src = baseUrl+'new_task/edit_sub_task/'+leafId1+'/'+nodeId1+'/'+workSpaceId1+'/type/'+workSpaceType1+'/'+treeId1+'/'+position1;

	document.getElementById(iframeid1).style.display = 'block';

	

	//document.getElementById(spanTaskView1).style.display='block'; 

				

				

				/* Fetching last version of leaf */

                

				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+leafId1;

				

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

							//alert ('Nodedetails= ' + nodeDetails);

								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");

									//alert ('leafOrder1= ' + leafOrder1);

									// alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);

									if (arrNode[0]!='onlyContents')

									{

										leafId1=arrNode[1];

										leafId2=arrNode[1];

										//leafOrder1=arrNode[2];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										content=arrNode[4];

									}

									else

									{

										//alert ('contents1= ' + arrNode[1]);

										content=arrNode[1];

									}

									

								}

				//alert(content);						//setValueIntoEditor('edittask'+leafId1,content);				

				var spanId='latestcontent'+leafId1;

				var editorId='editThis'+leafId1;

				//document.getElementById(spanId).style.display='none';

				document.getElementById(editorId).style.display='';

				detailId	= 'normalView'+nodeId1;

				document.getElementById(detailId).style.display='none';

				//chnage_textarea_to_editor('edittask'+leafId1,'simple');

				//tinymce.execCommand('mceFocus',false,'edittask'+leafId1);

				//setValueIntoEditor('edittask'+leafId1,content);	

				

				editor_code(content,'edittask'+leafId1,'divEdit'+leafId1);

				chnage_textarea_to_editor('edittask'+leafId1,'simple');

			    //alert("sss");		

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



function editthis1(lid)

{	

	var editorId='editThis'+lid;



	document.getElementById(editorId).style.display='';

	detailId	= 'detail'+lid;

	document.getElementById(detailId).style.display='none';

}

function edit_close(lid, nodeId){

	var spanId='latestcontent'+lid;

	var editorId='editThis'+lid;

	var detailId='normalView'+lid;

	

	document.getElementById(spanId).style.display='';

	document.getElementById(editorId).style.display='none';

	//document.getElementById(detailId).style.display='';

}

function edit_close1(lid){

	var editorId='editThis'+lid;

	document.getElementById(editorId).style.display='none';

	detailId	= 'detail'+lid;

	document.getElementById(detailId).style.display='';

}



function ajax_request(url,id)

{

	var xmlHttp;

	try

	{

	// Firefox, Opera 8.0+, Safari

	xmlHttp=new XMLHttpRequest();

	}

	catch (e)

	{

	  // Internet Explorer

	try

	{

		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");

	}

	catch (e)

	{

		try

		{

			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");

		}

		catch (e)

		{

			jAlert("Your browser does not support AJAX!","Alert");

			return false;

		}

	}

}

 

xmlHttp.onreadystatechange=function()

{

	if(xmlHttp.readyState==4)

	{

		document.getElementById(id).innerHTML=xmlHttp.responseText; 

	}

}

xmlHttp.open("GET", url, true); 

//xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

xmlHttp.send(null);

}

//this function used to hide the bottom menu when accessing other manus

function hideBottomMenus(nodeId)

{

	if(nodeId == 0)

	{

		detailId='detail'+nodeId;

		document.getElementById(detailId).style.display='none';		

	}

	else

	{		

		detailId='normalView'+nodeId;

		document.getElementById(detailId).style.display='none';

	}	

}

function calStartCheck(thisVal, pos, formName, currentTime)

{	
	//alert("test");

	//alert ('pos= ' +formName);

	//var callStartId = 'calStart'+pos;

	if(thisVal.checked == true)

	{			

		formName.starttime.style.color = "#000000";	

		formName.starttime.style.backgroundColor = "#FFFFFF";

		

		document.getElementById('mark_calender'+pos).style.display = "";
		
		//$(".sdp").datepicker("option", "disabled", false);
		$( "#starttime"+pos ).prop( "disabled", false );
		
		
	}

	else

	{		
		$( "#starttime"+pos ).prop( "disabled", true );
		//$(".sdp").datepicker("option", "disabled", true);

		formName.starttime.style.color = "#626262";	

		formName.starttime.style.backgroundColor = "#CCCCCC";	

		formName.starttime.value = currentTime;

		

		if (formName.endCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}

	}

		/*$('.edp').datetimepicker({

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

		});*/

		$('.sdp').datetimepicker({

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

		});

		
	

}

function calEndCheck(thisVal, pos, formName, currentTime)

{
	if(thisVal.checked == true)

	{		

		formName.endtime.style.color = "#000000";	

		formName.endtime.style.backgroundColor = "#FFFFFF";	

		document.getElementById('mark_calender'+pos).style.display = "";
		
		//$(".edp").datepicker("option", "disabled", false);
		
		$( "#endtime"+pos ).prop( "disabled", false );

	}

	else

	{		
		$( "#endtime"+pos ).prop( "disabled", true );

		formName.endtime.style.color	 = "#626262";	

		formName.endtime.style.backgroundColor = "#CCCCCC";	

		formName.endtime.value = currentTime;

		if (formName.startCheck.checked!=true)

		{

			document.getElementById('mark_calender'+pos).style.display = "none";

		}
		
		//$(".edp").datepicker("option", "disabled", true);
		

	}

	$('.edp').datetimepicker({

			timeFormat: "HH:mm",

			dateFormat: "dd-mm-yy"

		});

}

	var lastframeid=0;

	var rameid=0;

	function compareDates (dat1, dat2) {
		//alert ('Here'); return 1;
		
		var date1, date2;

   		var month1, month2;

   		var year1, year2;
		
		var startDate, endDate;
		
		value1 = dat1.substring (0, dat1.indexOf (" "));

	  	value2 = dat2.substring (0, dat2.indexOf (" "));

	  	time1= dat1.substring (16, dat1.indexOf (" "));

	  	time2= dat2.substring (16, dat2.indexOf (" "));
	  

	  	hours1= time1.substring (0, time1.indexOf (":"));

	  //	minites1= time1.substring (1, time1.indexOf (":"));
	  minites1 = time1.substring(time1.lastIndexOf (":")+1, time1.length);

	  

	  	hours2= time2.substring (0, time2.indexOf (":"));

	 	//minites2= time2.substring (1, time2.indexOf (":"));
		minites2 = time2.substring(time2.lastIndexOf (":")+1, time2.length);

	  

   		date1 = value1.substring (0, value1.indexOf ("-"));

   		month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));

   		year1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);



   		date2 = value2.substring (0, value2.indexOf ("-"));

   		month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));

   		year2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

	
	
   if (year1 > year2) return 1;

   else if (year1 < year2) return -1;

   else if (month1 > month2) return 1;

   else if (month1 < month2) return -1;

   else if (date1 > date2) return 1;

   else if (date1 < date2) return -1;

   else if (hours1 > hours2) return 1;

   else if (hours1 < hours2) return -1;

   else if (minites1 > minites2) return 1;

   else if (minites1 < minites2) return -1;
   
   else if (minites1 == minites2) return 1;
   
   

   else return 0;

} 

	function blinkIt() {

	 if (!document.all) return;

	 else {

	   for(i=0;i<document.all.tags('blink').length;i++){

		  s=document.all.tags('blink')[i];

		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';

	   }

	 }

	}

	

	function showFocus()

	{

		setInterval('blinkIt()',500);

	}

	function validate_title(replyDiscussion,formname,leafId)

	{

		//alert (replyDiscussion.id);

		var error=''	

		if(getvaluefromEditor(replyDiscussion,'simple') == '')

		{

			jAlert('Please enter the title','Alert');

			formname.title.focus();		

			return false;	

		}

		else		

		{  

			formname.submit();

		}	

	}

	function validate_dis(replyDiscussion,formname,treeId){
			//alert ('O Hello');

		var error='';

            var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

			

	        //var getValue=CKEDITOR.instances[INSTANCE_NAME].getData();

			var getValue=getvaluefromEditor(INSTANCE_NAME);

			

			/*if ($("<p>"+getValue+"</p>").text().trim()=='' && getValue.indexOf("<img")==-1)

			{

				jAlert('Please enter the title','Alert');

				formname.title.focus();	

				return false;	

			}*/
			if (getValue == '')

			{

				jAlert('Please enter the title','Alert');

				formname.title.focus();	

				return false;	

			}

			

					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){

						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

							

							error+=' Please check start time and end time.';

							alert (error);

							return false;

						}

						}

						 var data_user =$(formname).serialize();

		         data_user=  data_user+'&replyDiscussion='+encodeURIComponent(getValue) ;  

				 

				var request = $.ajax({

			  url: baseUrl+"new_task/node_Task_ajax/"+treeId,

			  type: "POST",

			  data: data_user,

			  dataType: "html",

			  success:function(result){

				  //CKEDITOR.instances[INSTANCE_NAME].destroy();

				  //tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

				  document.getElementById("divNodeContainer").innerHTML=result;

				   $("#reply_teeme0").hide();

				          //parent.location.href=parent.location.href;

			  							}

			});

					

						

				

	}

	function validate_subTask(replyDiscussion,formname){

	var error='';

	replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion,'simple') == ''){

		error+='Please Enter SubTask \n';

	}

	var val = getvaluefromEditor(replyDiscussion,'simple');

	//alert ('Val= ' + val);

	if(formname.editStatus.value == 0)

	{

		if(formname.starttime.value!='' && formname.endtime.value!='' ){

			if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

				error+=' Please check start time and end time.';

			}

		}

	}

	if(error==''){

		formname.submit();

	}else{

		alert(error);

	}	

	}

	function validateSubTaskEdit(replyDiscussion,formname){

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion,'simple') == ''){

		error+='Please Enter SubTask Title \n';

	}

	

	

	

	if(formname.editStatus.value == 0)

	{

					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){

						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

							

							error+=' Please check start time and end time.';

						}

					}

	}

	if(error==''){

		formname.submit();

	}else{

		alert(error);

	}

	

	}

	

	function validateSubTaskEdit1(replyDiscussion,formname){ 

	

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId1;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion,'simple') == ''){

		error+='Please Enter SubTask Title \n';

	}

	

	

	

	if(formname.editStatus.value == 0)

	{

					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){

						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

							

							error+=' Please check start time and end time.';

						}

					}

	}

	if(error==''){

		formname.submit();

	}else{

		alert(error);

	}

	

	}

	

	function edit_close12(lid, nodeId,treeId,workSpaceId,workSpaceType){

		

		document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+lid;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

var spanId='latestcontent'+lid;

var editorId='editThis'+lid;

var detailId='normalView'+lid;



//document.getElementById(spanId).style.display='';

//document.getElementById(editorId).style.display='none';

//document.getElementById(detailId).style.display='';



window.location.href = baseUrl+'view_task/node/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

}



function validate_task(newTask,treeId,formname){

	var error='';

	var INSTANCE_NAME = $("#"+newTask).attr('id');

	//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();

	

	var getvalue	= getvaluefromEditor(INSTANCE_NAME);
	//alert (getvalue); return false;
	

	/*if ($(getvalue).text().trim()=='' && getvalue.indexOf("<img")==-1)

	{

		alert('Please enter the task','Alert');

		formname.title.focus();	

		return false;

	}*/
	if (getvalue == '')

	{

		alert('Please enter the task','Alert');

		formname.title.focus();	

		return false;

	}



	if(formname.startCheck.checked==true && formname.endCheck.checked==true ){

		if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

			error+=' Please check start time and end time.';

		}

	}

	

	if(error==''){

		

		$("[name=Replybutton]").hide();

		$("[name=Replybutton1]").hide();

		$("#loader2").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

		

		var data_user =$(formname).serialize();

		

		var request = $.ajax({

		  url: baseUrl+"new_task/new_task1/"+treeId,

		  type: "POST",

		  data: data_user+'&'+newTask+'='+encodeURIComponent(getvalue),

		  dataType: "html",

		  success:function(result){

			   //setValueIntoEditor(newTask,'');	
			  
			   //CKEDITOR.instances[INSTANCE_NAME].destroy();
			   editorClose(INSTANCE_NAME);

			   //$(".taskFormContainer").hide();
			   //Manoj:added for mobile curious calendar 
				$(".taskFormContainer").html('');
				
			   $("#divNodeContainer",parent.document).html(result);
			   
			   /*Commented by Dashrath- comment for popup functionality*/
			   //document.getElementById('editStatus').value= 0;	

			  //parent.location.href=parent.location.href;

			    $("[name=Replybutton]").show();

				$("[name=Replybutton1]").show();

				$("#loader2").html("");

				/*Added by Dashrath- call taskHighlight function for task hig*/
			   	window.parent.taskHighlight(treeId);
			   	/*Dashrath- code end*/

			   	/*Added by Dashrath- add new task popup remove*/
			  	$('#popupMask',parent.document).remove();
				$('#popupContainer',parent.document).remove();
				/*Dashrath- code end*/

			  }

		});

		

		

		

		//formname.submit();

		//parent.location.href=parent.location.href;

	}else{

		alert(error);

	}

}	

function addMoreSubTasks(leafId,nodeId,workSpaceId,workSpaceType,treeId,treeStatus,formname)

{

	var subTaskTitle = getvaluefromEditor('title'+leafId,'simple');

	var subTaskContents = getvaluefromEditor('replyDiscussion'+leafId,'simple');

}



function showHideSubTasks (nodeId)

{ 

	$('.subTasks'+nodeId).toggle();

	$('#collapseSubTasks'+nodeId).toggle();

	$('#expandSubTasks'+nodeId).toggle();

	/*if (document.getElementById('subTasks'+nodeId).style.display=='none')

	{ 

		document.getElementById('subTasks'+nodeId).style.display='';

		document.getElementById('expandSubTasks'+nodeId).style.display='none';

		document.getElementById('collapseSubTasks'+nodeId).style.display='';

	}

	else

	{

		document.getElementById('subTasks'+nodeId).style.display='none';

		document.getElementById('expandSubTasks'+nodeId).style.display='';

		document.getElementById('collapseSubTasks'+nodeId).style.display='none';

	}*/

}



/*function edit_Cancel(leafId1, nodeId){

		

		/*document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+lid;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

var spanId='latestcontent'+lid;

var editorId='editThis'+lid;

var detailId='normalView'+lid;



document.getElementById(spanId).style.display='';

document.getElementById(editorId).style.display='none';

//document.getElementById(detailId).style.display=''; 





xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+leafId1;

				

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

							//alert ('Nodedetails= ' + nodeDetails);

								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");

									//alert ('leafOrder1= ' + leafOrder1);

									// alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);

									if (arrNode[0]!='onlyContents')

									{

										leafId1=arrNode[1];

										leafId2=arrNode[1];

										//leafOrder1=arrNode[2];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										content=arrNode[4];

									}

									else

									{

										//alert ('contents1= ' + arrNode[1]);

										content=arrNode[1];

									}

									

								}

								//alert(content);

				//setValueIntoEditor('edittask'+leafId1,content);				

				//var spanId='latestcontent'+leafId1;

				//var editorId='editThis'+leafId1;

				//document.getElementById(spanId).style.display='none';

				//document.getElementById(editorId).style.display='';

			//	detailId	= 'normalView'+nodeId1;

				//document.getElementById(detailId).style.display='none';

				//chnage_textarea_to_editor('edittask'+leafId1,'simple');

				//tinymce.execCommand('mceFocus',false,'edittask'+leafId1);

				setValueIntoEditor('edittask'+leafId1,content);	

						

				}

				}

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);



}*/



function edit_Cancel(leafId1, nodeId){

	var start_time;

	var end_time;

	//alert(leafId1);

	//var formname="form3"+leafId1;xmlHttpLast=GetXmlHttpObject2();

				

								

	

	xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf_task_time'+"/index/leafId/"+leafId1;

				

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

						//alert(nodeDetails);

								if (nodeDetails != 0)

								{

									var arr=nodeDetails.split("/"); 

									

									 start_time=arr[0].split(" ");

									 start_time1=start_time[0];

									 

									 end_time=arr[1].split(" ");

									 end_time1=end_time[0];

									//alert(start_time);

									//var end_time=nodeDetails->endtime;

									

								}

								

								

						

						

						 //alert ('pos= ' +formName);

	var callStartId = 'calStart'+leafId1;

	if(start_time1 != '00-00-0000')

	{	

		document.getElementById(callStartId).style.display = "";	

		document.getElementById("starttime"+leafId1).style.color = "#000000";	

		document.getElementById("starttime"+leafId1).style.backgroundColor = "#FFFFFF";

			

		document.getElementById('mark_calender'+leafId1).style.display = "";

	}

	else

	{		

		document.getElementById(callStartId).style.display = 'none';

		document.getElementById("starttime"+leafId1).style.color = "#626262";	

		document.getElementById("starttime"+leafId1).style.backgroundColor = "#CCCCCC";	

		//document.getElementById("starttime"+leafId1).value = currentTime;

		

		if (end_time1!='')

		{

			document.getElementById('mark_calender'+leafId1).style.display = "none";

		}

	}

	

	

	

		

		var callEndId = 'calEnd'+leafId1;	

		

	if(end_time1 != '00-00-0000')

	{	

		document.getElementById(callEndId).style.display = '';

		document.getElementById("endtime"+leafId1).style.color = "#000000";	

		document.getElementById("endtime"+leafId1).style.backgroundColor = "#FFFFFF";	

		document.getElementById('mark_calender'+leafId1).style.display = "";

	}

	else

	{	

		document.getElementById(callEndId).style.display = 'none';

		document.getElementById("endtime"+leafId1).style.color	 = "#626262";	

		document.getElementById("endtime"+leafId1).style.backgroundColor = "#CCCCCC";	

		//document.getElementById("endtime"+leafId1).value = currentTime;

		if (start_time1 != '00-00-0000')

		{

			document.getElementById('mark_calender'+leafId1).style.display = "none";

		}

	}

		

		

	

	

	

								

						}}

	xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);



	

	/*if(document.getElementById("startCheck").checked==true)

	alert("hi");

	else

	alert("bye");

	return true;*/

}





function validate_dis_edit_task(replyDiscussion,formname,leafId,cNodeId){

		var error='';

        var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

		

		//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();

		var getvalue	= getvaluefromEditor(INSTANCE_NAME);

		

			if(getvalue == '' )

			{

				jAlert('Please enter the title','Alert');

				formname.title.focus();	

				return false;	

			}

			else		

			{

					if(formname.startCheck.checked==true && formname.endCheck.checked==true ){
						//alert ('starttime= ' +formname.starttime.value);
						//alert ('endtime= ' +formname.endtime.value);

						if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

							

							error+=' Please check start time and end time.';

							alert (error);

							return false;

						}

						else

						{  
							//alert ("here");

							//code for releasing lock on leaf	

								var url = baseUrl+'unlock_leaf';		  

								xmlHttp1=GetXmlHttpObject2();

								queryString =   url; 

								queryString = queryString + '/index/leafId/'+leafId;

								xmlHttp1.open("GET", queryString, false);

								xmlHttp1.send(null);

							//close code for releasing lock	

							$("[name=Replybutton]").hide();

							$("[name=Replybutton1]").hide();

							$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

						

							var data_user =$(formname).serialize();

			

							var request = $.ajax({

			 					url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

			  					type: "POST",

			  					data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

			  					dataType: "html",

			  					success:function(result){

									editorClose(replyDiscussion);

									//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

									//CKEDITOR.instances[INSTANCE_NAME].destroy();
									
									$("#divNodeContainer").html(result);
									
										

									//Manoj: froala editor show task leaf content on cancel
									document.getElementById('taskLeafContent'+cNodeId).style.display="block";

			                          }

								});

							//formname.submit();

						}

					}

					else

					{  

					

					    //code for releasing lock on leaf	

						var url = baseUrl+'unlock_leaf';		  

						xmlHttp1=GetXmlHttpObject2();

						queryString =   url; 

						queryString = queryString + '/index/leafId/'+leafId;

						xmlHttp1.open("GET", queryString, false);

						xmlHttp1.send(null);

						//close code for releasing lock	

						var data_user =$(formname).serialize();

							$("[name=Replybutton]").hide();

							$("[name=Replybutton1]").hide();

							$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

						

			               

						var request = $.ajax({

							url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

							type: "POST",

							data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

							dataType: "html",

							success:function(result){

							editorClose(replyDiscussion);

							//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

							//CKEDITOR.instances[INSTANCE_NAME].destroy();

							$("#divNodeContainer").html(result);

							

								  }

						});

					

						//formname.submit();

					}

			}	
			
			document.getElementById('editStatus').value= 0;	
			

	}

	

	function validate_title_edit_task(replyDiscussion,formname,leafId,cNodeId)

	{

		//alert (replyDiscussion.id);

		var error='';

		 var INSTANCE_NAME = $("#"+replyDiscussion).attr('id');

		//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();

		var getvalue	= getvaluefromEditor(INSTANCE_NAME);

		

		/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1)

		{

			jAlert('Please enter the title','Alert');

			formname.title.focus();		

			return false;	

		}*/
		
		if (getvalue == '')

		{

			jAlert('Please enter the title','Alert');

			formname.title.focus();		

			return false;	

		}

		else		

		{  

		

			$("[name=Replybutton]").hide();

			$("[name=Replybutton1]").hide();

			$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

		    /*Added by Surbhi IV for checking content */

			 var request1 = $.ajax({

					  url: baseUrl+'new_task/getOldContentByTreeId/'+leafId,

					  type: "POST",

					  //data: 'treeId='+treeId+'&version='+version,

					  data: '',

					  dataType: "html",

					  success:function(result)

					  {

						   if(result==getvalue)

						   {

								jAlert("Contents not changed","Alert");

								/*Added by Dashrath- When content not changed loader continue show and both button hide*/
								$("[name=Replybutton]").show();
								$("[name=Replybutton1]").show();
								$("#loaderImage").html("");
								/*Dashrath- code end*/

								return false;

						   }

						   else

						   {/*End of Added by Surbhi IV*/

								//code for releasing lock on leaf	

								var url = baseUrl+'unlock_leaf';		  

								xmlHttp1=GetXmlHttpObject2();

								queryString =   url; 

								queryString = queryString + '/index/leafId/'+leafId;

								xmlHttp1.open("GET", queryString, false);

								xmlHttp1.send(null);

								//close code for releasing lock	

							    var data_user =$(formname).serialize();

								var request = $.ajax({

								 url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

								  type: "POST",

								  data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

								  dataType: "html",

								  success:function(result){

														  //parent.location.href=parent.location.href;

														//  tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

								 //CKEDITOR.instances[INSTANCE_NAME].destroy();

									editorClose(INSTANCE_NAME);

														  $("#divNodeContainer").html(result);

														  }

								});

			                    //formname.submit();

						   /*Added by Surbhi IV for checking content */

						   }

					   }

					});

				

			    /*End of Added by Surbhi IV*/

		}	
		document.getElementById('editStatus').value= 0;	

	}

	

	function TaskTitleSaveNew ()

{

	   // var getvalue = CKEDITOR.instances.documentName.getData();

		//var getvalue = getvaluefromEditor('documentName');
		var getvalue = document.getElementById('documentName').value;

		var treeId = document.getElementById('treeId').value;

		

		//var docTitle = document.getElementById('documentName').value;

		if(getvalue == "")

		{

			jAlert("Please enter the task title",'Alert');

			document.getElementById('documentName').focus();

			return false;

		}

		

		$("[value=Done]").hide();

		$("[value=Cancel]").hide();

		$("#loader").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

		

		var httpDoc = getHTTPObjectm();

		

	

		var documentName='documentName';

		//var jsData = getvaluefromEditor(documentName,'simple');

		var jsData = getvalue;

		urlm=baseUrl+'edit_document/updateNew/'+workSpaceId+'/type/'+workSpaceType+'/task';

		data='treeId='+treeId+'&documentName='+encodeURIComponent(jsData);

		

	   

		httpDoc.open("POST", urlm, true); 

		httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

						//CKEDITOR.instances.documentName.destroy();	

						document.getElementById("treeContent").innerHTML=getvalue;

						if(document.getElementById("oldNameContainer"))

						{

						document.getElementById("oldNameContainer").innerHTML=httpDoc.responseText+')';

						}

						$("[value=Done]").show();

						$("[value=Cancel]").show();

						$("#loader").html("");

						//editorClose("documentName");

						document.getElementById("edit_doc").style.display='none';

						

						}

					  }     

		httpDoc.send(data);

		

		

}



function showAssignedTaskUser(id)

{ 

	if(document.getElementById("assigneUserLimited"+id).style.display=='block')

	{

		document.getElementById("assigneUserLimited"+id).style.display='none';	

		document.getElementById("assigneUserAll"+id).style.display='block';

		document.getElementById("assignedText"+id).innerHTML='hide';

		}

	else

	{	document.getElementById("assignedText"+id).innerHTML='see all';

			document.getElementById("assigneUserAll"+id).style.display='none';

			document.getElementById("assigneUserLimited"+id).style.display='block';

		

		}

	}

	

	function showTaskNodeOptions(position,pId)

{	
		
   // if(nodeOptionsVisible!=position )

	//{

		var notesId = 'normalView'+position;

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		

		if(document.getElementById("taskOption"+position))

		{

		document.getElementById("taskOption"+position).style.display = "block";

		}

		if(document.getElementById("addOption"+position))

		{

		document.getElementById("addOption"+position).style.display = "block";

		}

		if(pId>0)

		{ 

			document.getElementById("taskOption"+pId).style.display = "block";

			document.getElementById("addOption"+pId).style.display = "block";

		}

		//document.getElementById("TaskInfo"+position).style.display = "block";

		//clickEvent=position;

		

		

	//}

	/*

	else if(nodeOptionsVisible!=position)

	{

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		}

	*/

	

}



function hideTaskNodeOptions(position,pId)

{	

	if(nodeOptionsVisible!=position)

	{

		var notesId = 'normalView'+position;	

	

		document.getElementById(notesId).style.display = "none";

		document.getElementById("ulNodesHeader"+position).style.display = "none";

		

		if(document.getElementById("taskOption"+position))

		{

		document.getElementById("taskOption"+position).style.display = "none";

		}

		if(document.getElementById("addOption"+position))

		{

		document.getElementById("addOption"+position).style.display = "none";

		}

		

		//document.getElementById("TaskInfo"+position).style.display = "none";

		

		//nodeOptionsVisible= -1;

	}

	if(pId>0)

	{ 

		document.getElementById("addOption"+pId).style.display = "block";

	}

			

	

		

	

}
//Manoj: added new method to resolve cancel issue on mobile
function clickMobTaskNodesOptions(position,pId)

{ 	

		nodeOptionsVisible=position;

		var notesId = 'normalView'+position;	

		$('.normalView').hide();

		$('.ulNodesHeader').hide();

		$('.addOption').hide();

		$('.taskOption').hide();

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		

		if(document.getElementById("taskOption"+position))

		{

		document.getElementById("taskOption"+position).style.display = "block";

		}

		if(document.getElementById("addOption"+position))

		{

		document.getElementById("addOption"+position).style.display = "block";

		}

		if(pId>0)

		{ 
			document.getElementById("taskOption"+pId).style.display = "block";
			document.getElementById("addOption"+pId).style.display = "block";
		}

	}
//Manoj: code end

function clickTaskNodesOptions(position,pId)

{ 

		nodeOptionsVisible=position;

		var notesId = 'normalView'+position;	

		$('.normalView').hide();

		$('.ulNodesHeader').hide();

		$('.addOption').hide();

		$('.taskOption').hide();

		

		//$('.TaskInfo').hide();

		

	    

      	if(document.getElementById(notesId).style.display == "none")

	  	{

		  	document.getElementById(notesId).style.display = "block";

			document.getElementById("ulNodesHeader"+position).style.display = "block";

			//document.getElementById("taskOption"+position).style.display = "block";

			//document.getElementById("addOption"+position).style.display = "block";

			if(pId>0)

			{ 

			    document.getElementById("taskOption"+pId).style.display = "block";

				document.getElementById("addOption"+pId).style.display = "block";

			}

		}

	  	else if(clickEvent!=position)

	  	{ 

		  	document.getElementById(notesId).style.display = "none";

			document.getElementById("ulNodesHeader"+position).style.display = "none";

			document.getElementById("taskOption"+position).style.display = "none";

			document.getElementById("addOption"+position).style.display = "none";

			//nodeOptionsVisible= -1;

			if(pId>0)

			{ 

			   document.getElementById("taskOption"+pId).style.display = "block";

			   document.getElementById("addOption"+pId).style.display = "block";

			}

		}

	}

	

	newTask = 0; 

	

	//submit add task form 

	function submitForm(nodeId,treeId,position)
	{
		
		if(document.getElementById('editStatus').value == 1)

		{
	
			jAlert('Please save or close the current leaf before accessing another leaf','Alert');
	
			return false;
	
		}
		else
		{
			
		//Manoj: added for hide icon at bottom
		if(position=='0')
		{
		  	document.getElementById('loader'+position).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		}
		else
		{
			document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		}
		
		document.getElementById('editStatus').value = 1;
				
		//$("#taskOption"+nodeId).hide();
		
		//Manoj: code end
		  $(".taskFormContainer").html('');
		  $(".taskFormContainer").hide();			

		  
		  //Manoj: showing task form container for seed and leaf
		  if(position=='0')
		  {
		  	$("#formContainerSeed"+nodeId).show();
		  }
		  else
		  {
			$("#formContainer"+nodeId).show();
		  }
		  //Manoj: code end
		

			//  showPopWin('<?php echo base_url(); ?>new_task/new_task1/<?php echo $arrVal['nodeId']; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>'

//			tinyMCE.execCommand('mceRemoveControl', true, 'newTask'+nodeId);																			   

		var request = $.ajax({

		  url: baseUrl+"new_task/new_task1/"+nodeId+"/index/"+workSpaceId+'/type/'+workSpaceType+"/"+treeId+"/"+position,

		  type: "POST",

		  data: 'data=1',

		  dataType: "html",

		  async:false,

		  success:function(result)

				  {   

					//var editor = CKEDITOR.instances['newTask'+nodeId];

					//if (editor) {editorClose('newTask'+nodeId);}

					//Manoj: Add task content for seed and leaf 
					if(position=='0')
		  			{	
						$("#formContainerSeed"+nodeId).html(result);
						
						document.getElementById('loader'+position).innerHTML =" ";

						/*Added by Dashrath- add for page scroll for editor focus*/
                 		window.scrollTo(0, 0);
                 		/*Dashrath- code end*/
					}
					else
					{	
						$("#formContainer"+nodeId).html(result);
						
						document.getElementById('loader'+nodeId).innerHTML =" ";
					}
					//Manoj: code end
					
					//Manoj: added comment for showing calendar ui when click checkbox
			
					/*$('.edp').datetimepicker({

						timeFormat: "HH:mm",

						dateFormat: "dd-mm-yy"

					});

					$('.sdp').datetimepicker({

						timeFormat: "HH:mm",

						dateFormat: "dd-mm-yy"

					});*/

														

				  } 

			    });	
		
		//document.getElementById("ulNodesHeader"+nodeId).style.display = "none";
			
		//document.getElementById("normalView"+nodeId).style.display = "none";
		
		}
}

	

	//submit edit sub task form

	function submitSubTaskForm(nodeId,treeId,position)

	{
		
		if(document.getElementById('editStatus').value == 1)

		{
	
			jAlert('Please save or close the current leaf before accessing another leaf','Alert');
	
			return false;
	
		}
		else
		{
			
		//Manoj: added for hide right icon at bottom
		
		document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		
		document.getElementById('editStatus').value = 1;
		
		//$("#taskOption"+nodeId).hide();
		
		//Manoj: code end
		
		$(".taskFormContainer").hide();

	    $("#formSubTaskContainer"+nodeId).show();

																						   

		var request = $.ajax({

		  url: baseUrl+"new_task/start_sub_task/"+nodeId+"/index/"+workSpaceId+'/type/'+workSpaceType+"/"+treeId+"/"+position,

		  type: "POST",

		  data: 'data=1',

		  dataType: "html",

		  success:function(result)

		  { 

			//tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion');

			//var editor = CKEDITOR.instances['replyDiscussion'];

    		//if (editor) {editorClose('replyDiscussion');}

			$("#formSubTaskContainer"+nodeId).html(result);
			
			document.getElementById('loader'+nodeId).innerHTML =" ";

			//tinyMCE.execCommand('mceFocus', true, 'replyDiscussion');

		  }

		});	
		
		//document.getElementById("ulNodesHeader"+nodeId).style.display = "none";
			
		//document.getElementById("normalView"+nodeId).style.display = "none";
		
		}
}

	

	//submit edit task form
	function getEditTaskForm(nodeId,treeId,position,leafId)

	{
		//Manoj: Made form center when edit task
		
		/*$("#formContainer"+nodeId).animate({width:'350px'}, 100,function() {  
            $("html, body").animate({ scrollTop: $("#formContainer"+nodeId).offset().top-( $(window).height() - $("#formContainer"+nodeId).outerHeight(true) ) / 3 });  
        });*/
		
		updateLeafContents(nodeId,treeId);
		
		if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=4";
					$.ajax({
					   
						url: baseUrl+'comman/getTaskTreeLeafUserStatus',
			
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
						
		
		if(document.getElementById('editStatus').value == 1)
		{
			jAlert('Please save or close the current leaf before accessing another leaf','Alert');
			
			//updateLeafContents(nodeId,treeId);
			
			return false;
		}
		else
		{
		
		
		//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		
		document.getElementById('editStatus').value = 1;
		
		//Manoj: hide nodes icons when edit task in mobile 
		
		//document.getElementById("ulNodesHeader"+nodeId).style.display = "none";
			
		//Manoj: code end
	    $(".taskFormContainer").html('');
		$(".taskFormContainer").hide();			

		$("#formContainer"+nodeId).show();

		

		xmlHttp=GetXmlHttpObject2();

		

						var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId;

						xmlHttp.onreadystatechange = function()
						{
							if (xmlHttp.readyState==4)

							{
									if(xmlHttp.status == 200) 

										{									

											strResponseText = xmlHttp.responseText;				

											if(strResponseText == 0)

											{  // alert(baseUrl+"new_task/leaf_edit_Task/"+nodeId+"/index/"+workSpaceId+'/type/'+workSpaceType+"/"+treeId+"/"+position);

											//http://10.10.1.17/teeme/new_task/leaf_edit_Task/8293/index/1/type/1/790/13

											//http://10.10.1.17/teeme/new_task/leaf_edit_Task/3650/index/1/type/1/790/20
											
													document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

													var request = $.ajax({

													  url: baseUrl+"new_task/leaf_edit_Task/"+nodeId+"/index/"+workSpaceId+'/type/'+workSpaceType+"/"+treeId+"/"+position,

													  type: "POST",

													  data: 'data=1',

													  dataType: "html",

													  success:function(result)

															 { 

																//tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+leafId);
															
																//editorClose ('edittask'+leafId);
															
															$("#formContainer"+nodeId).html(result);
															
															document.getElementById('loader'+nodeId).innerHTML =" ";
															
															//Manoj: added condition for edit task calendar
															var ismobile = (/iphone|ipod|Mobile|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
															if(ismobile==true)

															{
 															   $("#dtBox").DateTimePicker();
															}
															//Manoj: added condition for edit task calendar end
															
															$('.edp').datetimepicker({

																	timeFormat: "HH:mm",

																	dateFormat: "dd-mm-yy"

																});

															$('.sdp').datetimepicker({

																	timeFormat: "HH:mm",

																	dateFormat: "dd-mm-yy"

																});
																
																
														

															//alert(leafId);

    														if(disableEditor==1){

																$("#edittask"+leafId).hide();

																$("#labelMobile"+leafId).hide();

															}//chnage_textarea_to_editor('newTask'+nodeId,'simple');

																 

																 }

														});	

													//document.getElementById("taskOption"+nodeId).style.display = "none";

													//document.getElementById("normalView"+nodeId).style.display = "none";		
		
													//Manoj: froala editor hide content on edit task leaf
													document.getElementById('taskLeafContent'+nodeId).style.display="none";

													/*Added by Dashrath- remove class for ui issue after editor shift below task div*/
													if($('.subTasks'+nodeId).css('display') != 'block')
  													{ 
  														$('#taskLeafContentNew'+nodeId).removeClass("seedBackgroundColorNew");
  													}
													/*Dashrath- code end*/

											}

											else

											{	

												jAlert(strResponseText,"Alert");
												
												//updateLeafContents(nodeId,treeId);
												
												document.getElementById('editStatus').value = 0;

											}	

								

										}

								

								

								}

							

						}

		

			  

																				   

			xmlHttp.open("GET", url, true);

				xmlHttp.send(null);																			 



		}
			} //else end
		} //success end
		});
	}

		

		

	//submit edit  sub  task form

	function editSubTask(leafId,nodeId,treeId,position,selNodeId)

	{

		//Manoj: Made form center when edit subtask
		 /*$("#divEditSubTask"+leafId).animate({width:'350px'}, 100,function() {  
            $("html, body").animate({ scrollTop: $("#divEditSubTask"+leafId).offset().top-( $(window).height() - $("#divEditSubTask"+leafId).outerHeight(true) ) / 3 });  
        });*/
		//Manoj: code end 
		updateLeafContents(nodeId,treeId);
		
		if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=4";
					$.ajax({
					   
						url: baseUrl+'comman/getTaskTreeLeafUserStatus',
			
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
		
		if(document.getElementById('editStatus').value == 1)
		{
			jAlert('Please save or close the current leaf before accessing another leaf','Alert');
			//updateLeafContents(nodeId,treeId);
			return false;
		}
		else
		{
		
		//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		
		document.getElementById('editStatus').value = 1;
		
		$(".clsEditTask").html('');

		$(".taskFormContainer").hide();	

		$(".clsEditTask").hide();		

		$("#divEditSubTask"+leafId).show();

		

		xmlHttp=GetXmlHttpObject2();

		

						var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId;

						xmlHttp.onreadystatechange = function()

						{

							

							

							if (xmlHttp.readyState==4)

							{

								

									if(xmlHttp.status == 200) 

										{									

											strResponseText = xmlHttp.responseText;				

											if(strResponseText == 0)

											{

		

												document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

		

												var request = $.ajax({

													  url: baseUrl+"new_task/edit_sub_task/"+leafId+"/"+nodeId+"/"+workSpaceId+'/type/'+workSpaceType+"/"+treeId+"/"+position+"/"+selNodeId,

													  type: "POST",

													  data: 'data=1',

													  dataType: "html",

													  success:function(result)

															 { 

																//tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+leafId);

																//var INSTANCE_NAME = $("#edittask"+leafId).attr('name');

																//CKEDITOR.instances[INSTANCE_NAME].destroy();
																
																$("#divEditSubTask"+leafId).html(result);
																
																 document.getElementById('loader'+nodeId).innerHTML =" ";
																
																 //Manoj: froala editor hide content on edit subtask leaf
																 document.getElementById('subTaskLeafContent'+nodeId).style.display="none";
																
																//Manoj: added condition for edit sub task calendar
																
																var ismobile = (/iphone|ipod|Mobile|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
																
																if(ismobile==true)

																{
 															   		$("#dtBox").DateTimePicker();
																}
																//Manoj: added condition for edit sub task calendar end
																
																 $('.edp').datetimepicker({

																	timeFormat: "HH:mm",

																	dateFormat: "dd-mm-yy"

																});

																$('.sdp').datetimepicker({

																	timeFormat: "HH:mm",

																	dateFormat: "dd-mm-yy"

																});

																 if(disableEditor==1){

																	$("#edittask"+leafId).hide();

																	$("#divedittast"+leafId).hide();

																 }

																 

																 chnage_textarea_to_editor('edittask'+leafId,'simple');
																 
																
																 

															}

														});		

											}

											else

											{	

												jAlert(strResponseText,"Alert");
												
												//updateLeafContents(nodeId,treeId);
												
												document.getElementById('editStatus').value = 0;

											}	

								

									}

							}

						}

		

			  

																				   

			xmlHttp.open("GET", url, true);

			xmlHttp.send(null);													 

		}
		
		} //else end
		} //success end
		});

}	
//Start Manoj : Show assignee on click
		function show_assignee(nodeId){
			if($('.style2'+nodeId).is(':visible'))
			{
				$('.style2'+nodeId).hide();
				$("#seeAll"+nodeId).html('See all');
			}
			else
			{
				$('.style2'+nodeId).show();	
				$("#seeAll"+nodeId).html('See less');
			}
		} 

//End Manoj : Show assignee on click

	
/*Added by Dashrath- addNewTaskForm used for open form in popup for add new task*/
function addNewTaskForm(nodeId,treeId,position)
{
	
	if(document.getElementById('editStatus').value == 1)
	{
		jAlert('Please save or close the current leaf before accessing another leaf','Alert');
		return false;
	}
	else
	{
		//Manoj: added for hide icon at bottom
		// if(position=='0')
		// {
		//   	document.getElementById('loader'+position).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		// }
		// else
		// {
		// 	document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		// }
		
		/*Commented by Dashrath- comment editStatus value 1 set when editor open for popup ui*/
		//document.getElementById('editStatus').value = 1;
			
		//$("#taskOption"+nodeId).hide();
	
		//Manoj: code end
	 	$(".taskFormContainer").html('');
	  	$(".taskFormContainer").hide();			

	  
		//Manoj: showing task form container for seed and leaf
		if(position=='0')
		{
			$("#formContainerSeed"+nodeId).show();
		}
		else
		{
			$("#formContainer"+nodeId).show();
		}
		//Manoj: code end

		// showPopWin('<?php echo base_url(); ?>new_task/new_task1/<?php echo $arrVal["nodeId"]; ?>/index/<?php echo $workSpaceId; ?>/type/<?php echo  $workSpaceType; ?>/<?php  echo $treeId; ?>/<?php echo $position; ?>');
		//	tinyMCE.execCommand('mceRemoveControl', true, 'newTask'+nodeId);																			   

		showPopWin(baseUrl+'new_task/new_task1/'+nodeId+'/index/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId+'/'+position+'/popup',600,600, null, '');
		
	
		//document.getElementById("ulNodesHeader"+nodeId).style.display = "none";
		//document.getElementById("normalView"+nodeId).style.display = "none";
	}
}
/*Dashrath- addNewTaskForm function end*/

/*Added by Dashrath- closeAddNewTaskPopup used for close add new task popup for add new task*/
function closeAddNewTaskPopup(nodeId)
{
	//tinyMCE.execCommand('mceRemoveControl', true, 'newTask'+nodeId);
	var INSTANCE_NAME = $("#newTask"+nodeId).attr('name');

	//CKEDITOR.instances[INSTANCE_NAME].destroy();
	editorClose(INSTANCE_NAME);

	/*Commented by Dashrath- comment for popup functionality*/
	//code for releasing lock on leaf	
	//document.getElementById('editStatus').value= 0;

	var url = baseUrl+'unlock_leaf';		  
	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+nodeId;

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

	//close code for releasing lock	
	//alert('test');
	$(".taskFormContainer").html('');
	$(".clsEditTask").html('');

	if(document.getElementById('yearDropDown'))
	{
		closeCalendar(); /*Deepti : To close the calender*/
	}

	$('#popupMask',parent.document).remove();
	$('#popupContainer',parent.document).remove();
}
/*Dashrath- closeAddNewTaskPopup function end*/

/*Added by Dashrath- getEditTaskFormNew used for edit new task form open in popup*/
function getEditTaskFormNew(nodeId,treeId,position,leafId)
{
	
	updateLeafContents(nodeId,treeId);
	
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}

	var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=4";
	$.ajax({
	   
		url: baseUrl+'comman/getTaskTreeLeafUserStatus',

		type: "POST",

		data: 'leaf_data='+leaf_data,
		
		dataType: "html",

		success:function(result)
		{
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
				if(document.getElementById('editStatus').value == 1)
				{
					jAlert('Please save or close the current leaf before accessing another leaf','Alert');
					return false;
				}
				else
				{
					/*Commented by Dashrath- Comment editStatus for popup changes*/
					//document.getElementById('editStatus').value = 1;

					//Manoj: code end
			   		$(".taskFormContainer").html('');
					$(".taskFormContainer").hide();			

					$("#formContainer"+nodeId).show();

					xmlHttp=GetXmlHttpObject2();

					var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId;

					xmlHttp.onreadystatechange = function()
					{
						if (xmlHttp.readyState==4)
						{
							if(xmlHttp.status == 200) 
							{									
								strResponseText = xmlHttp.responseText;				
								if(strResponseText == 0)
								{  	
									/*Added by Dashrath- used for when close edit task and sub task popup by close icon then lock status is clear in db*/
									document.getElementById('task_sub_task_edit').value = leafId;
									/*Dashrath- code end*/

									showPopWin(baseUrl+'new_task/leaf_edit_Task/'+nodeId+'/index/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId+'/'+position+'/popup',600,670, null, '');
								}
								else
								{	
									jAlert(strResponseText,"Alert");
									//updateLeafContents(nodeId,treeId);
									document.getElementById('editStatus').value = 0;
								}	
							}
						}
					}

					xmlHttp.open("GET", url, true);

					xmlHttp.send(null);																			 
				}
			} //else end
		} //success end
	});
}
/*Dashrath- getEditTaskFormNew function end*/

/*Added by Dashrath- editTaskView1New used for close edit task popup*/
function editTaskView1New(leafId,cNodeId)
{
	/*Add for leafid value 0 when close edit popup*/
	$("#task_sub_task_edit",parent.document).val("0");

	//tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+leafId);

	var INSTANCE_NAME = $("#edittask"+leafId).attr('name');

	getUpdatedContents(cNodeId,2);
	
	setTagAndLinkCount(cNodeId,2);
	
	getSimpleColorTag(cNodeId,2);

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

	document.getElementById('editStatus').value= 0;

	//code for releasing lock on leaf	

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+leafId;

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

	editorClose("edittask"+leafId);
	
	//close code for releasing lock	

	$(".taskFormContainer").html('');

	$(".clsEditTask").html('');
	
	//alert (document.getElementById('yearDropDown'));
	if(document.getElementById('yearDropDown'))
	{
	   closeCalendar(); /*Deepti : To close the calender*/
	}
	
	getTreeLeafUserStatus('',cNodeId,4);
	
	$('#popupMask',parent.document).remove();
	$('#popupContainer',parent.document).remove();

}
/*Dashrath- editTaskView1New function end*/


/*Added by Dashrath- validate_dis_edit_task_new used for edit task*/
function validate_dis_edit_task_new(replyDiscussion,formname,leafId,cNodeId)
{

	var error='';

    var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

	//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();
	var getvalue	= getvaluefromEditor(INSTANCE_NAME);

	if(getvalue == '' )
	{
		jAlert('Please enter the title','Alert');

		formname.title.focus();	

		return false;	
	}
	else		
	{
		if(formname.startCheck.checked==true && formname.endCheck.checked==true ){
			//alert ('starttime= ' +formname.starttime.value);
			//alert ('endtime= ' +formname.endtime.value);

			if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

				error+=' Please check start time and end time.';

				alert (error);

				return false;
			}
			else
			{  
				//alert ("here");
				//code for releasing lock on leaf	

				var url = baseUrl+'unlock_leaf';		  

				xmlHttp1=GetXmlHttpObject2();

				queryString =   url; 

				queryString = queryString + '/index/leafId/'+leafId;

				xmlHttp1.open("GET", queryString, false);

				xmlHttp1.send(null);

				//close code for releasing lock	

				$("[name=Replybutton]").hide();

				$("[name=Replybutton1]").hide();

				$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

				var data_user =$(formname).serialize();

				var request = $.ajax({

 					url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

  					type: "POST",

  					data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

  					dataType: "html",

  					success:function(result){

						editorClose(replyDiscussion);

						//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

						//CKEDITOR.instances[INSTANCE_NAME].destroy();
						
						//$("#divNodeContainer").html(result);
						$("#divNodeContainer",parent.document).html(result);

						/*Add for leafid value 0 when close edit popup*/
						$("#task_sub_task_edit",parent.document).val("0");
						
						//Manoj: froala editor show task leaf content on cancel
						//document.getElementById('taskLeafContent'+cNodeId).style.display="block";

						$('#popupMask',parent.document).remove();
						$('#popupContainer',parent.document).remove();
                    }

				});
				//formname.submit();
			}

		}
		else
		{  
		    //code for releasing lock on leaf	

			var url = baseUrl+'unlock_leaf';		  

			xmlHttp1=GetXmlHttpObject2();

			queryString =   url; 

			queryString = queryString + '/index/leafId/'+leafId;

			xmlHttp1.open("GET", queryString, false);

			xmlHttp1.send(null);

			//close code for releasing lock	

			var data_user =$(formname).serialize();

			$("[name=Replybutton]").hide();

			$("[name=Replybutton1]").hide();

			$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

			var request = $.ajax({

				url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

				type: "POST",

				data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

				dataType: "html",

				success:function(result){

					editorClose(replyDiscussion);

					//tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

					//CKEDITOR.instances[INSTANCE_NAME].destroy();

					//$("#divNodeContainer").html(result);
					$("#divNodeContainer",parent.document).html(result);

					$('#popupMask',parent.document).remove();
					$('#popupContainer',parent.document).remove();
				}

			});
			//formname.submit();
		}
	}	
	
	document.getElementById('editStatus').value= 0;	
}
/*Dashrath- validate_dis_edit_task_new function end*/

/*Added by Dashrath- validate_title_edit_task_new used for edit task*/
function validate_title_edit_task_new(replyDiscussion,formname,leafId,cNodeId)
{
	//alert (replyDiscussion.id);
	var error='';

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('id');

	//var getvalue	= CKEDITOR.instances[INSTANCE_NAME].getData();
	var getvalue	= getvaluefromEditor(INSTANCE_NAME);

	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1)
	{
		jAlert('Please enter the title','Alert');
		formname.title.focus();		
		return false;	
	}*/
	
	if (getvalue == '')
	{
		jAlert('Please enter the title','Alert');
		formname.title.focus();		
		return false;	
	}
	else		
	{  
		$("[name=Replybutton]").hide();

		$("[name=Replybutton1]").hide();

		$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

	    /*Added by Surbhi IV for checking content */

		var request1 = $.ajax({

		  	url: baseUrl+'new_task/getOldContentByTreeId/'+leafId,

		  	type: "POST",

		 	//data: 'treeId='+treeId+'&version='+version,

		  	data: '',

		  	dataType: "html",

		 	success:function(result)
		  	{

			    if(result==getvalue)
			    {
					jAlert("Contents not changed","Alert");

					/*Added by Dashrath- When content not changed loader continue show and both button hide*/
					$("[name=Replybutton]").show();
					$("[name=Replybutton1]").show();
					$("#loaderImage").html("");
					/*Dashrath- code end*/

					return false;
			   	}
			   	else
			   	{/*End of Added by Surbhi IV*/

					//code for releasing lock on leaf	

					var url = baseUrl+'unlock_leaf';		  

					xmlHttp1=GetXmlHttpObject2();

					queryString =   url; 

					queryString = queryString + '/index/leafId/'+leafId;

					xmlHttp1.open("GET", queryString, false);

					xmlHttp1.send(null);

					//close code for releasing lock	

				    var data_user =$(formname).serialize();

					var request = $.ajax({

					 	url: baseUrl+"new_task/leaf_edit_Task/"+leafId+'/'+workSpaceId+'/type/'+workSpaceType,

					  	type: "POST",

					  	data: data_user+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),

					  	dataType: "html",

					  	success:function(result){

							//parent.location.href=parent.location.href;

							//  tinyMCE.execCommand('mceRemoveControl', true, replyDiscussion);

					 		//CKEDITOR.instances[INSTANCE_NAME].destroy();

							editorClose(INSTANCE_NAME);

							//$("#divNodeContainer").html(result);
							$("#divNodeContainer",parent.document).html(result);

							$('#popupMask',parent.document).remove();
							$('#popupContainer',parent.document).remove();

						}
					});

                    //formname.submit();
			   	/*Added by Surbhi IV for checking content */
			    }
		    }

		});
		/*End of Added by Surbhi IV*/
	}	
	document.getElementById('editStatus').value= 0;	
}
/*Dashrath- validate_title_edit_task_new function end*/

/*Added by Dashrath- submitSubTaskFormNew used for open form in popup for add sub task*/
function submitSubTaskFormNew(nodeId,treeId,position)
{
	if(document.getElementById('editStatus').value == 1)
	{
		jAlert('Please save or close the current leaf before accessing another leaf','Alert');
		return false;
	}
	else
	{
		//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		
		/*Commented by Dashrath- comment editStatus for popup changes*/
		//document.getElementById('editStatus').value = 1;
		
		$(".taskFormContainer").hide();

	    $("#formSubTaskContainer"+nodeId).show();

	    showPopWin(baseUrl+'new_task/start_sub_task/'+nodeId+'/index/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId+'/'+position+'/popup',600,620, null, '');
	}
}
/*Dashrath- submitSubTaskFormNew function end*/

/*Added by Dashrath- hideTaskView1New_replyDiscussionNew used for close add new sub task popup*/
function hideTaskView1New_replyDiscussionNew(nodeId)
{
	//tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion');
	//Manoj: sub task cancel for mobile
	var INSTANCE_NAME = $("#replyDiscussion").attr('name');
	editorClose(INSTANCE_NAME);
	
	//document.getElementById('editStatus').value= 0;
	
	$(".taskFormContainer").html('');
	
	//Manoj: sub task cancel for mobile end
	//CKEDITOR.instances.replyDiscussion.destroy();

	var INSTANCE_NAME = $("#replyDiscussion"+nodeId).attr('name');
	editorClose(INSTANCE_NAME);

	if(document.getElementById('yearDropDown'))
	{
		closeCalendar(); /*Deepti : To close the calender*/
	}

	//close code for releasing lock	

	$(".taskFormContainer").html('');

	$(".clsEditTask").html('');
	
	//editorClose('replyDiscussion');

	$('#popupMask',parent.document).remove();
	$('#popupContainer',parent.document).remove();
}
/*Dashrath- hideTaskView1New_replyDiscussionNew function end*/

/*Added by Dashrath- editSubTaskNew used for open edit sub task form in popup*/
function editSubTaskNew(leafId,nodeId,treeId,position,selNodeId)
{
	//Manoj: Made form center when edit subtask
	 /*$("#divEditSubTask"+leafId).animate({width:'350px'}, 100,function() {  
        $("html, body").animate({ scrollTop: $("#divEditSubTask"+leafId).offset().top-( $(window).height() - $("#divEditSubTask"+leafId).outerHeight(true) ) / 3 });  
    });*/
	//Manoj: code end 
	updateLeafContents(nodeId,treeId);
		
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}

	var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=4";
	$.ajax({
	   
		url: baseUrl+'comman/getTaskTreeLeafUserStatus',

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

				if(document.getElementById('editStatus').value == 1)
				{
					jAlert('Please save or close the current leaf before accessing another leaf','Alert');
					//updateLeafContents(nodeId,treeId);
					return false;
				}
				else
				{
					//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
					
					/*Commented by Dashrath- Comment editStatus for popup changes*/
					//document.getElementById('editStatus').value = 1;
				
					$(".clsEditTask").html('');

					$(".taskFormContainer").hide();	

					$(".clsEditTask").hide();		

					$("#divEditSubTask"+leafId).show();

					xmlHttp=GetXmlHttpObject2();

					var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId;

					xmlHttp.onreadystatechange = function()
					{
						if (xmlHttp.readyState==4)
						{
							if(xmlHttp.status == 200) 
							{									
								strResponseText = xmlHttp.responseText;	

								if(strResponseText == 0)
								{
									/*Added by Dashrath- used for when close edit task and sub task popup by close icon then lock status is clear in db*/
									document.getElementById('task_sub_task_edit').value = leafId;
									/*Dashrath- code end*/

									showPopWin(baseUrl+'new_task/edit_sub_task/'+leafId+'/'+nodeId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+treeId+'/'+position+'/'+selNodeId+'/popup',600,670, null, '');
								}
								else
								{	
									jAlert(strResponseText,"Alert");
									//updateLeafContents(nodeId,treeId);
										
									document.getElementById('editStatus').value = 0;

								}	
							}

						}

					}

					xmlHttp.open("GET", url, true);

					xmlHttp.send(null);													 
				}
		
			} //else end
		} //success end
	});
}
/*Dashrath- editSubTaskNew function end*/

/*Added by Dashrath- hideTaskView1New1 used for close edit sub task new sub task popup*/
function hideTaskView1New1(leafId,cNodeId)
{

	/*Add for leafid value 0 when close edit popup*/
	$("#task_sub_task_edit",parent.document).val("0");
	
	//tinyMCE.execCommand('mceRemoveControl', true, 'edittask'+leafId);
	var INSTANCE_NAME = $("#edittask"+leafId).attr('name');

	getUpdatedContents(cNodeId,2);
	
	setTagAndLinkCount(cNodeId,2);
	
	getSimpleColorTag(cNodeId,2);

	//CKEDITOR.instances[INSTANCE_NAME].destroy();

	//document.getElementById('editStatus').value= 0;

	//code for releasing lock on leaf	

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+leafId;

	xmlHttp1.open("GET", queryString, false);

	xmlHttp1.send(null);

	editorClose("edittask"+leafId);
	
	//close code for releasing lock	

	$(".taskFormContainer").html('');

	

	$(".clsEditTask").html('');
	
	//alert (document.getElementById('yearDropDown'));

	if(document.getElementById('yearDropDown'))

	{

	   closeCalendar(); /*Deepti : To close the calender*/

	}
	
	getTreeLeafUserStatus('',cNodeId,4);
	
	//Manoj: froala editor show task leaf content on cancel
	// if(document.getElementById('taskLeafContent'+cNodeId))
	// {
	// 	document.getElementById('taskLeafContent'+cNodeId).style.display="block";
	// }

	$('#popupMask',parent.document).remove();
	$('#popupContainer',parent.document).remove();
}
/*Dashrath- hideTaskView1New1 function end*/

/*Added by Dashrath- used for when close edit task and sub task popup by close icon then lock status is clear in db*/
$("#popCloseBox",parent.document).click(function(){
	var leafIdNew = $("#task_sub_task_edit",parent.document).val();

	if(leafIdNew > 0)
	{
		var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafIdNew;

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		$("#task_sub_task_edit",parent.document).val("0");
	}

});
/*Dashrath- code end*/

