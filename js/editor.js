var editorArray=new Array();

function chnage_textarea_to_editor(textareaId)

{

	// for Teeme editor

	editorArray[textareaId]= new Teemeeditor(textareaId ,'100%','300','') ;

	editorArray[textareaId].BasePath = baseUrl+"teemeeditor/" ;

	editorArray[textareaId].ReplaceTextarea() ;

	// 

	 

}

function getvaluefromEditor(editorId){

	// for Teeme editor

	var oEditor = TeemeeditorAPI.GetInstance(editorId) ;

	 return oEditor.GetXHTML( true );

	// 

}

function GetXmlHttpObject2()

{

	if (window.XMLHttpRequest)

	  {

	  // code for IE7+, Firefox, Chrome, Opera, Safari

		  return new XMLHttpRequest();

	  }

	if (window.ActiveXObject)

	  {

	  // code for IE6, IE5

	 	 return new ActiveXObject("Microsoft.XMLHTTP");

	  }

	return null;

}



function editor_code(val,ename,pId){

	

	if(document.getElementById(ename)){

		

	}else{

		var newInput = document.createElement('textarea');

		var inputName = ename;

		newInput.setAttribute('name',inputName);

		newInput.setAttribute('id',inputName);

		newInput.setAttribute('rows','5');

		newInput.setAttribute('cols','45');

		newInput.value=val;

		document.getElementById(pId).appendChild(newInput);

		var newInput1 = document.createElement('span');

		inputName1=inputName+'sp';

		newInput1.setAttribute('id',inputName1);

		document.getElementById(pId).appendChild(newInput1);



	}

	

	//return '<textarea rows="10" cols="90" name="'+ename+'" id="'+ename+'">'+val+'</textarea>';

}



function hideShowSeed(treeId) 

{

	var seedId = 'normalViewTree'+treeId;			

	if(document.getElementById(seedId).style.display == "none")

	{

		document.getElementById(seedId).style.display="";

	}

	else

	{

		document.getElementById(seedId).style.display="none";

	}

}





function addFirstLeaf(treeId, leafOrder){

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}

	

	

	document.getElementById('editStatus').value = 1;

	hideall();

	document.getElementById('leafAddFirst').style.display="";

	editor_code('<div id="Idea#1-span"><p>.</p></div>','editorLeafContentsAddFirst1','leafAddFirst');

	 

	//hideall();

	 document.getElementById('editorLeafContentsAddFirst1'+'sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="firstLeafSave('+treeId+','+leafOrder+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="cancelFirstLeaf('+treeId+','+leafOrder+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

	 chnage_textarea_to_editor('editorLeafContentsAddFirst1');

}

function firstLeafSave(treeId, leafOrder) 

{		

	var editorId 	= "editorLeafContentsAddFirst1";

	var getvalue	= getvaluefromEditor(editorId);//document.getElementById(editorId).value;	

	 

	 document.frmEditLeaf.curLeaf.value 		= leafOrder;	

	document.frmEditLeaf.curContent.value 	= getvalue;

	document.frmEditLeaf.curLeafOrder.value = leafOrder;

	document.frmEditLeaf.curOption.value 	= 'addFirst';			

	document.frmEditLeaf.submit();

	return true;		

}

// this is a js function used to cancel to add the first leaf 

function cancelFirstLeaf( treeId, leafOrder) 

{

  	 document.getElementById('leafAddFirst').style.display="none";	

	 document.getElementById('editStatus').value = 0;		

}	

function addLeaf(leafId,treeId, leafOrder){
	
	//alert ('ok');

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}

	document.getElementById('editStatus').value = 1;

 	document.getElementById('addleaf'+leafOrder).style.display="";

	editor_code('<div id="Idea#1-span"><p>.</p></div>','editorLeafContentsAdd'+leafOrder+'1','addleaf'+leafOrder);

	 hideall();

	document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

	chnage_textarea_to_editor('editorLeafContentsAdd'+leafOrder+'1');

}

function cancelnewLeaf( leafId,treeId, leafOrder) 

{

  	 document.getElementById('addleaf'+leafOrder).style.display="none";	

	 document.getElementById('editStatus').value = 0;		

}

function newLeafSave(leafId, treeId,leafOrder) 

{		

	var editorId = "editorLeafContentsAdd"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;
	

	document.frmEditLeaf.curLeaf.value = leafId;	

	document.frmEditLeaf.curContent.value = getvalue;

	document.frmEditLeaf.curLeafOrder.value = leafOrder;

	document.frmEditLeaf.curOption.value = 'add';			

	document.frmEditLeaf.submit();

	return true;		

}

var leafId1;

var leafOrder1;

var treeId1;

var nodeId1;

var xmlHttp;





function editLeaf(leafId, leafOrder,treeId,nodeId) 

{

	//alert ('leafId= ' + leafId + 'leafOrder= ' + leafOrder + 'treeId= ' + treeId + 'nodeId= ' +nodeId);

	//alert (document.getElementById('editStatus').value);

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}

	



	 leafId1=leafId;

	 leafId2=leafId;

	 leafOrder1=leafOrder;

	 treeId1=treeId;

	 nodeId1=nodeId;

	 initialleafcontentId='initialleafcontent'+leafOrder1;

	 hideall();

	 //alert(document.getElementById(initialleafcontentId).value);

	xmlHttp=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

	xmlHttp.onreadystatechange = handleLockLeafEdit;				

	xmlHttp.open("GET", url, true);

	xmlHttp.send(null);

}

function handleLockLeafEdit(){

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;				

			if(strResponseText == 0)

			{

				//////////////////////////////////fetching last version of leaf///////////////////////////

				

				

				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'Current_leaf'+"/index/leafId/"+leafId1;

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

							

								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("|");

									// alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);

									leafId1=arrNode[1];

									leafId2=arrNode[1];

									//leafOrder1=arrNode[2];

									treeId1=arrNode[3];

									nodeId1=arrNode[0];

									document.getElementById('initialleafcontent'+leafOrder1).value=arrNode[4];

									

								}

								

								////// editing new leaf

								/////////////////////////////////////////////////////////////

								document.getElementById('editStatus').value = 1;

								var val=document.getElementById('initialleafcontent'+leafOrder1).value

								document.getElementById('editleaf'+leafOrder1).style.display="";

								document.getElementById('leafContent'+leafOrder1).style.display="none";

								

								//alert ('val= ' + val);

								editor_code('<div id="Idea#'+leafOrder1+'-span">'+val+'</div>','editorLeafContents'+leafOrder1+'1','editleaf'+leafOrder1)

								 

								document.getElementById('editorLeafContents'+leafOrder1+'1sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="canceleditLeaf('+leafId1+','+treeId1+','+leafOrder1+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

								chnage_textarea_to_editor('editorLeafContents'+leafOrder1+'1');

								

								////////

						}

					}

						

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);

				

				

				

				

			}else{	

				jAlert('This leaf is already in edit mode','Alert');					

			}					

		}

	}

}



function canceleditLeaf(leafId, treeId, leafOrder) 

{

  	 document.getElementById('editleaf'+leafOrder).style.display="none";

	document.getElementById('leafContent'+leafOrder).style.display="";

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, true);

		xmlHttp1.send(null);	

}

function editLeafSave(leafId, treeId,leafOrder,nodeId) 

{		

	var editorId = "editorLeafContents"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;				

	document.frmEditLeaf.curContent.value = getvalue;

	document.frmEditLeaf.curLeaf.value = leafId;	

	document.frmEditLeaf.curLeafOrder.value = leafOrder;

	document.frmEditLeaf.curNodeId.value = nodeId;	

	document.frmEditLeaf.curOption.value = 'edit';			

	document.frmEditLeaf.submit();		

	return true;		

}

function hideall(){

	var arrLeafIds = new Array();

		arrLeafIds = document.getElementById('allnodesOrders').value.split(',');

		for(var i=0;i<arrLeafIds.length;i++)

		{

			 

			 document.getElementById('leafOptions'+arrLeafIds[i]).style.display = 'none';

 				

 		}	

		 document.getElementById('leafAddFirst').style.display="none";	

		

}

function showLeafOptions(leafId, leafOrder, treeId, nodeId)

	{

		var seedId = 'normalViewTree'+treeId;	

		 

		if(document.getElementById('editStatus').value == 1)

		{

			jAlert('Please click Save & Exit or Close button before accessing new leaf','Alert');

			 

			return false;

		}		

		leafId1 	= leafId;	

		nodeId1 	= nodeId;		

		treeId1 	= treeId;

		leafOrder1 	= leafOrder;

		 

		timeInit 	= -1;

		hideall();

		document.getElementById('leafOptions'+leafOrder).style.display = '';

		 

	}

	function handleLockLeaf() 

	{		

		if(xmlHttp.readyState == 4) 

		{			

			if(xmlHttp.status == 200) 

			{									

				strResponseText = xmlHttp.responseText;				

										

				if(strResponseText == 0)

				{}

				else

				{	

					jAlert('This leaf is already in edit mode','Alert');					

				}					

			}

		}



	}

	////////////////////////////////////////////////////////

	// this is a js function used for show the leaf previous version contents

	function showLeafPrevious(leafId, leafParentId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType) 

	{	

		

		nodeId1 = leafId;

		nodeId_vk= leafId;

		curLeafId1 = curLeafId;

		curNodeOrder = leafOrder;

		var url = baseUrl+'view_leaf_previous_contents';  

		xmlHttp=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString+'?leafParentId='+leafParentId+'&leafId='+leafId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;				

		xmlHttp.onreadystatechange = handleStateChange1;

		

		spanTagViewInnerId='spanTagViewInner'+leafOrder;	

		leafHeaderId = 'leafOptionsHeader'+leafOrder

		leafContentId = 'leafContent'+leafOrder;

		initialleafcontent='initialleafcontent'+leafOrder;

		spanTagNewId='spanTagNew'+leafOrder;

		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}

// this is a js function used to show the leaf next version contents from the current version

	function showLeafNext(leafId, leafChildId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType) 

	{

		curLeafId1 = curLeafId;	

		nodeId_vk= leafId;

		curNodeOrder = leafOrder;

		var url = baseUrl+'view_leaf_next_contents';		

		xmlHttp=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString+'?leafChildId='+leafChildId+'&leafId='+leafId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;		

		xmlHttp.onreadystatechange = handleStateChange1;

		leafHeaderId = 'leafOptionsHeader'+leafOrder

		leafContentId = 'leafContent'+leafOrder;

		initialleafcontent='initialleafcontent'+leafOrder;

		spanTagViewInnerId='spanTagViewInner'+leafOrder;

		spanTagNewId='spanTagNew'+leafOrder;

		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}

	function handleStateChange1() 

	{

		if(xmlHttp.readyState == 4) 

		{

			if(xmlHttp.status == 200) 

			{					

				arrResponseText = new Array();

						//alert(xmlHttp.responseText);			

				arrResponseText = xmlHttp.responseText.split("|||");				

				document.getElementById(leafHeaderId).innerHTML			= arrResponseText[0];

				document.getElementById(leafContentId).innerHTML		= arrResponseText[1];

				//document.getElementById(initialleafcontent).value= arrResponseText[2];

				document.getElementById(spanTagViewInnerId).value= arrResponseText[7];

				document.getElementById(spanTagNewId).value= arrResponseText[9];

				//      alert(arrResponseText[9])

				//alert(arrResponseText[7])

				//alert(arrResponseText[8])

						

			}

		}

		//alert(document.getElementById(initialleafcontent).value);

	}

	function saveDocument()

	{							

		var getvalue = getvaluefromEditor('editorContents2');

	//	alert(getvalue);

		document.frmDocument.editorContents.value = getvalue;		

		var docTitle = document.getElementById('documentTitle').value	

		if(trim(docTitle) =="")

		{

			jAlert("Please enter the document title","Alert");

			document.getElementById('documentTitle').focus();

			return false;

		}		

		document.frmDocument.submit();		

		return true;	

	}	

	function bodyUnload() 

	{

		var url = baseUrl+'unlock_leafs';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 		

		xmlHttp1.open("GET", queryString, true);

		xmlHttp1.send(null);	

		

	}

	

	////////////////////// tags/////////////////

	
