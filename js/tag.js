//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.

 /***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: tag.js
* Description 		  	: This is a js file having lot of js functions to handle the teeme tag functionalities.
* Global Variables	  	: baseUrl
* 
* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 28-Nov-2008				Nagalingam						Created the file.
*
**********************************************************************************************************/

	// this is a js function used for edit the current selected leaf

	var tagSpanId = '';

	var divSelectId	= '';

	var artifactTagSpanId = '';

	function viewTag(tagTypeId, spanId, categoryId) 

	{		

		var url = baseUrl+'view_tags';		

		tagSpanId = spanId;  

		createXMLHttpRequest();

		queryString =   url; 		

		queryString = queryString+"/index/tagTypeId/"+tagTypeId+"/"+categoryId;		

		xmlHttp.onreadystatechange = handleTagResponse;				

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);		

	}

	

	//This is a JS function used to get the response and ahow the same in the corresponding page

	function handleTagResponse() 

	{			

		document.getElementById(tagSpanId).innerHTML = xmlHttp.responseText;

	}



	// this is the js function used to set the deafult time to tag start time and end time

	function setDefaultCalendarTime(startField, endField)

	{



		var date = new Date();

		if(date.getYear() < 1700)

		{

			var getYear1 = date.getYear()+1900;

		}

		else

		{

			var getYear1 = date.getYear();

		}

		var curDate = getYear1+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes();

		if(startField.value == "")

		{

			startField.value 	= curDate;		

			endField.value 		= curDate;	 

		}		

	}

	// this function used to change the tag dynamically using ajax

	function changeTag( categoryId, getDivId, workSpaceId, workSpaceType ) 

	{

		divSelectId = getDivId;

		document.getElementById('optionFields').innerHTML = '<input type="text" name="selectionOptionsAction"  >'+"<br>";

		document.frmTag.noOfOptions.value = 2;

		if(categoryId.value != 0)

		{

			if(categoryId.value == 3)

			{

				document.getElementById('voteTag').style.display = "";

				document.getElementById('selectionTag').style.display = "none";

				

				document.getElementById('deadline_todo').style.display = "none";

				document.getElementById('deadline_select').style.display = "none";

				document.getElementById('deadline_vote').style.display = "";

				document.getElementById('deadline_authorize').style.display = "none";

				

				//document.getElementById('voteEnd').style.display = "";

			}

			else if(categoryId.value == 2)

			{

				document.getElementById('voteTag').style.display = "none";

				//document.getElementById('voteEnd').style.display = "none";

				document.getElementById('selectionTag').style.display = "";

				

				document.getElementById('deadline_todo').style.display = "none";

				document.getElementById('deadline_select').style.display = "";

				document.getElementById('deadline_vote').style.display = "none";

				document.getElementById('deadline_authorize').style.display = "none";

			}

			

			else

			{

				document.getElementById('voteTag').style.display = "none";

				document.getElementById('selectionTag').style.display = "none";	

				

				if (categoryId.value == 4)

				{

					document.getElementById('deadline_todo').style.display = "none";

					document.getElementById('deadline_select').style.display = "none";

					document.getElementById('deadline_vote').style.display = "none";

					document.getElementById('deadline_authorize').style.display = "";					

				}

				else

				{

					document.getElementById('deadline_todo').style.display = "";

					document.getElementById('deadline_select').style.display = "none";

					document.getElementById('deadline_vote').style.display = "none";

					document.getElementById('deadline_authorize').style.display = "none";					

				}

				//document.getElementById('voteEnd').style.display = "none";

			}

			

			

			//document.getElementById(getDivId).options.length = 1;

			//document.getElementById(getDivId).options[0] = new Option("--Select--","0");

			/*var url = baseUrl+'change_tag';	
			createXMLHttpRequest();
			queryString =   url; 		
			queryString = queryString+"/index/"+categoryId.value+'/'+workSpaceId+'/'+workSpaceType;
			xmlHttp.onreadystatechange = handleSelectionChange;	
			xmlHttp.open("GET", queryString, true);
			xmlHttp.send(null);*/

		}	

		else

		{

			document.getElementById(divSelectId).options.length	= 1;     

			document.getElementById(divSelectId).options[i] = new Option('--Select--', 0);		

		}				

	}

	function handleSelectionChange() 

	{

		if(xmlHttp.readyState == 4) 

		{

			if(xmlHttp.status == 200) 

			{

			  parseResults();

			}

		}

	}

	function parseResults() 

	{

		if(xmlHttp.responseText == 0)

		{

			jAlert('Contacts are not available in this workspace','Alert');

			document.frmTag.tagType[0].selected = true;

		}	

		else

		{	

			var returnElements=xmlHttp.responseText.split("||");

			//Process each of the elements 	

			for ( var i=0; i<returnElements.length; i++ )

			{	

				if(returnElements[i]!="")

				{			

					valueLabelPair = returnElements[i].split(";")

					document.getElementById(divSelectId).options.length	= returnElements.length;     

					document.getElementById(divSelectId).options[i] = new Option(valueLabelPair[0], valueLabelPair[1]);			

				} 

			}

		}

	}



	function showFocus(whoFocus)

	{

		parent.frames[whoFocus].gk.EditingArea.focus();

	}

	function showTag(item1, artifactId, artifactType) 

	{		

		obj1 	= document.getElementById(item1);

		document.getElementById('artifactId').value = artifactId;	

		document.getElementById('artifactType').value = artifactType;

		obj1.style.display = "";	

	}

	function showTagResponse(item1, tagTypeId) 

	{

		obj1 	= document.getElementById(item1);	

		document.getElementById('tagCategory').value = tagTypeId;	

		obj1.style.display = "";	

	}

	function hideTag(item1) 

	{

		obj1 	= document.getElementById(item1);	

		obj1.style.display = "none";	

	}

	

	function addOptions(spanId)

	{

		var foo = document.getElementById(spanId);

		//Create an input type dynamically.

    	var element1 = document.createElement("input");

		var element2 = document.createElement("br");

 

    	//Assign different attributes to the element.

    	element1.setAttribute("type", 'text');

    	element1.setAttribute("value", '');

    	element1.setAttribute("name", 'selectionOptionsAction');

		

		

		

		foo.appendChild(element1);

		foo.appendChild(element2);

		

		var noOfOptions = document.frmTag.noOfOptions.value;



		var currentFields = document.getElementById(spanId).innerHTML;



		//document.getElementById(spanId).innerHTML = currentFields+'<input type="text" name="selectionOptions[]" id="selectionOptions[]">'+"<br>";

	

		document.frmTag.noOfOptions.value = parseInt(noOfOptions)+1;

	}



	function changeDrop()

	{

		document.frmTag.actionDate[0].selected = true;

	}

	function changeDropTag()

	{

		document.frmTag.tag[0].selected = true;

	}

	

	function getTimings() 

	{

		if(document.frmTag.endTime.value != 0)

		{

			document.frmTag.endTime.value = '';

		}		

	}

	

/*	function checkTag(tagName) 
	{		
		var url = baseUrl+'check_tags';		
		tagSpanId = spanId;  
		createXMLHttpRequest();
		queryString =   url; 		
		queryString = queryString+"/index/tagName/"+tagName;		
		xmlHttp.onreadystatechange = handleCheckTag;				
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);		
	}
	
	function handleCheckTag() 
	{			
		return (xmlHttp.responseText);
	}*/

	function validateTag() 

	{

		var obj = document.frmTag;	



		if(obj.tagOption.value == 1 || obj.tagOption.value == 2)

		{

			if(trim(obj.tag.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}



		else if(obj.tagOption.value == 3)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tagComments.focus();

				return false;

			}

			if(trim(obj.voteQuestion.value) == '')

			{

				jAlert('Please enter the voting question','Alert');

				obj.voteQuestion.focus();

				return false;

			}

			if (trim(obj.actionDate.value)=='' && trim(obj.endTime.value)=='')

			{

				jAlert('Please enter the end date','Alert');

				obj.actionDate.focus();

				return false;				

			}

		}		

		else if(obj.tagOption.value == 4)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the task name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}	

		else if(obj.tagOption.value == 5)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}

		else if(obj.tagOption.value == 6)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}				

		/*if(document.frmTag.sequence.value == 0)
		{		
			if(document.frmTag.tagType.value == 0)
			{
				alert('Please select the tag type');
				return false;
			}	
		}
		*/	

		return true;		

	}

	

	function validateTag2() 

	{

		var obj = document.frmTag2;	

		

		if(obj.tagOption.value == 1 || obj.tagOption.value == 2)

		{

			if(trim(obj.tag.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

			

		}	

		else if(obj.tagOption.value == 3)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the comments for tag','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}		

		else if(obj.tagOption.value == 4)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the task name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}	

		else if(obj.tagOption.value == 5)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}

		else if(obj.tagOption.value == 6)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}				

		/*if(document.frmTag.sequence.value == 0)
		{		
			if(document.frmTag.tagType.value == 0)
			{
				alert('Please select the tag type');
				return false;
			}	
		}
		*/	

		return true;		

	}





	function validateTag3() 

	{

		var obj = document.frmTag;	

		

		if(obj.tagOption.value == 1 || obj.tagOption.value == 2)

		{

			if(trim(obj.tag.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

			

		}	

		else if(obj.tagOption.value == 3)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}		

		else if(obj.tagOption.value == 4)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the task name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}	

		else if(obj.tagOption.value == 5)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}

		else if(obj.tagOption.value == 6)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}				

		/*if(document.frmTag.sequence.value == 0)
		{		
			if(document.frmTag.tagType.value == 0)
			{
				alert('Please select the tag type');
				return false;
			}	
		}
		*/	

		//return true;

		

		

		

	  	



	}







	function updateSequence() 

	{

		document.frmTag.sequence.value = 1;

	}



	function checkTagOrder(curVal, existOrder) 

	{

		var curVal1 = parseInt(curVal.value);

		var allowOrder = document.frmTag.countTags.value;

		if(isNaN(curVal.value) || curVal.value <= 0)

		{

			jAlert('Please enter the valid number','Alert');	

			curVal.value = existOrder;

			return false;

		} 	

		if(curVal1 > allowOrder)

		{

			var msg = 'The number should not exceed '+allowOrder;

			jAlert(msg,'Alert');	

			curVal.value = existOrder;

			return false; 

		}

	}



	function updateOrder() 

	{

		var allowOrder = document.frmTag.countTags.value;		

		var total_length = document.frmTag.elements.length;

		for (i = 0; i < total_length; i++)

		{

			if(document.frmTag.elements[i].name=='tagOrders[]')

			{

				if(isNaN(document.frmTag.elements[i].value) || parseInt(document.frmTag.elements[i].value) <= 0)

				{

					jAlert('Please enter the valid number','Alert');	

					document.frmTag.elements[i].select();

					return false;

				} 	

				if(parseInt(document.frmTag.elements[i].value) > allowOrder)

				{

					var msg = 'The order should not exceed '+allowOrder;

					jAlert(msg,'Alert');	

					document.frmTag.elements[i].select();

					return false; 

				}				

			}

		}		

		document.frmTag.updateStatus.value = 1;

		document.frmTag.submit();

	}



	function closePopWindow()

	{

		window.opener.location.reload();

		window.close();

	}

	function goUrl(url)

	{

		

		window.opener.location = url;

		window.refresh();

		//window.close();

	}

	function goUrlByClick(url)

	{

		

		window.location = url;

		

	}	

	function viewTagResponses(spanId)

	{	

		if(document.getElementById(spanId).style.display == 'none')

		{		

			document.getElementById(spanId).style.display = "";

		}

		else

		{		

			document.getElementById(spanId).style.display = "none";

		}

		//window.close();

	}

	function hideTagView(nodeId, workspaceId, workspaceType, artifactId, artifactType)

	{	

		//alert ('nodeId= ' + nodeId);

		var spanId1 	= 'spanTagView'+nodeId;

		

		var spanId2 	= 'normalView'+nodeId;

		var iframeId 	= 'iframeId'+nodeId;		

		var artifactTagSpanId = 'spanTagViewInner'+nodeId;	

		var spanTagNew 	= 'spanTagNew'+nodeId;	

		document.getElementById(spanTagNew).style.display = "";

		document.getElementById(spanId1).style.display = "none";

		if(nodeId != '0' && document.getElementById(spanId2))

		{

			document.getElementById(spanId2).style.display = "";		

		}

		document.getElementById(iframeId).style.display = "none";

		document.getElementById(iframeId).src = '';

		//window.location.reload(true);

		location.href = location.href;

/*		var url = baseUrl+'artifact_tags/index/'+nodeId+'/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;		  
		createXMLHttpRequest();
		queryString =   url; 			
		xmlHttp.onreadystatechange = handleArtifactTags;				
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);	*/	

	}

	

	function hideTagViewNew(nodeId)

	{	

		xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/resetFlagForTagView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.send(null);

	

		var iframeId 	= 'iframeId'+nodeId;		

		

		//document.getElementById(iframeId).style.display = "none";

		document.getElementById(iframeId).innerHTML = "";

	

	}

	

	function hideTagViewLeaf(nodeId, workspaceId, workspaceType, artifactId, artifactType)

	{	

	

		//alert ('nodeId= ' + nodeId);

		var spanId1 	= 'spanTagViewLeaf'+nodeId;

		

		var spanId2 	= 'normalView'+nodeId;

		var iframeId 	= 'iframeId'+nodeId;		

		var artifactTagSpanId = 'spanTagViewInner'+nodeId;	

		var spanTagNew 	= 'spanTagNew'+nodeId;	

		var iframeId = 'iframeIdLeaf'+nodeId;	

		document.getElementById(iframeId).style.display = "none";

		document.getElementById(iframeId).src = '';

		//document.getElementById(spanTagNew).style.display = "";

		document.getElementById(spanId1).style.display = "none";

		if(nodeId != '0' && document.getElementById(spanId2))

		{

			document.getElementById(spanId2).style.display = "";		

		}



		

/*		var url = baseUrl+'artifact_tags/index/'+nodeId+'/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;		  
		createXMLHttpRequest();
		queryString =   url; 			
		xmlHttp.onreadystatechange = handleArtifactTags;				
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);	*/	

	}	

	//This is a JS function used to get the artifact tags and ahow the same in the corresponding page

	function handleArtifactTags() 

	{		

		//alert (xmlHttp.responseText);

		//document.getElementById(artifactTagSpanId).innerHTML = xmlHttp.responseText;

	}

	

	function hideall(leafOrder)

	{

		if (document.getElementById('allnodesOrders'))

		{

			var arrLeafIds = new Array();

			arrLeafIds = document.getElementById('allnodesOrders').value.split(',');

		

			//alert ('arrleafids' + arrLeafIds);

			for(var i=0;i<arrLeafIds.length;i++)

			{

				if (leafOrder!=arrLeafIds[i])

				{

					document.getElementById('leafOptions'+arrLeafIds[i]).style.display = 'none';

				}

			}

		}	

		if (document.getElementById('leafAddFirst'))

		{

			document.getElementById('leafAddFirst').style.display="none";	

		}

	}



	function showTagView(nodeId,position)

	{	

		xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/setFlagForTagView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.onreadystatechange = function()

		{

			 if (xmlHttpTree.readyState==4 && xmlHttpTree.status==200)

			{

			    if(xmlHttpTree.responseText=='false')

				{ 

					jAlert("Please save or close the current tag  view before accessing another tag view",'Alert');

					return false;

					

				}

				else

				{

					xmlHttpTree2=GetXmlHttpObject2();

					var url2 =baseUrl+'create_tag1/resetFlagForTagView/';

					xmlHttpTree2.open("GET", url2, true); 

					xmlHttpTree2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

					xmlHttpTree2.send(null);

					

					//alert ('pos tag= ' + position);

		//alert ('nodeOrder= ' + nodeId);

		if (position)

		{

			showdetail (position);	

		}

		

		var spanId1 = 'spanTagView'+nodeId;

		var spanId2 = 'normalView'+nodeId;

		//var spanId3 = 'spanTagViewLeaf'+nodeId;

		var spanArtifactLinks = 'spanArtifactLinks'+nodeId;	

		//document.getElementById(spanArtifactLinks).style.display = 'none';	

		//document.getElementById(spanId3).style.display = "none";

		

		if(document.getElementById(spanId1).style.display == "")

		{

				document.getElementById(spanId1).style.display="none";

				document.getElementById(spanId2).style.display="none";

			}

			else

			{

					document.getElementById(spanId1).style.display="";

					document.getElementById(spanId2).style.display="";

				}

				



		if(nodeId != '0' && document.getElementById(spanId2))

		{

			document.getElementById(spanId2).style.display = "";		

		}	

		hideall();

					

					

					

					}

			}

		}

				

		xmlHttpTree.send(null);

	

		

	}

	

	function showTagViewLeaf(nodeId)

	{	

	  

		var spanId1 = 'spanTagViewLeaf'+nodeId;

		var spanId2 = 'normalView'+nodeId;

		var spanArtifactLinks = 'spanArtifactLinks'+nodeId;	

		//document.getElementById(spanArtifactLinks).style.display = 'none';			

		document.getElementById(spanId1).style.display = "";		

		if(nodeId != '0' && document.getElementById(spanId2))

		{

				document.getElementById(spanId2).style.display = "";		

		}	

		hideall();

	}

	function showNewTag_old(nodeId, workspaceId, workspaceType, artifactId, artifactType, tagId, option,nodeorder)

	{		

		//alert ('nodeorder= ' + nodeorder);

		//alert ('nodeId= ' +nodeId);

		var spanId1 = 'spanTagView'+nodeorder;

		var spanId2 = 'normalView'+nodeorder;		

		var iframeId = 'iframeId'+nodeorder;	

		var spanTagNew = 'spanTagNew'+nodeorder;	

		//document.getElementById(spanTagNew).style.display = "none";	



		//alert(baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType);

		if(option == 1)

		{ 

			document.getElementById(iframeId).src = baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;

		}

		else if(option == 2)

		{

			document.getElementById(iframeId).src = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/3/'+tagId;	

		}

		else if(option == 3)

		{

			document.getElementById(iframeId).src = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/1/'+tagId;	

		}

		//document.getElementById(spanId2).style.display = "none";	

		document.getElementById(spanId1).style.display = "";

		document.getElementById(iframeId).style.display = "";	

	}

	

	function showNewTag_old2(nodeId, workspaceId, workspaceType, artifactId, artifactType, tagId, option,nodeorder)

	{		

		

		xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/setFlagForTagView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.onreadystatechange = function()

		{

			 if (xmlHttpTree.readyState==4 && xmlHttpTree.status==200)

			{

			    if(xmlHttpTree.responseText=='true')

				{

					

					//alert ('nodeorder= ' + nodeorder);

		//alert ('nodeId= ' +nodeId);

		var spanId1 = 'spanTagView'+nodeorder;

		var spanId2 = 'normalView'+nodeorder;		

		var iframeId = 'iframeId'+nodeorder;	

		var spanTagNew = 'spanTagNew'+nodeorder;	

		//document.getElementById(spanTagNew).style.display = "none";	

		//alert(option);

		

		

		var httpDoc = getHTTPObjectm();

		

		if(option == 1)

		{ 

			urlm = baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;

		}

		else if(option == 2)

		{

			urlm=  baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/3/'+tagId;		

		}

		else if(option == 3)

		{

			urlm = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/1/'+tagId;		

		}

		 data='nodeorder='+nodeorder;

			   

		httpDoc.open("POST", urlm, true); 

		httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

							

						document.getElementById(spanId1).style.display = "";

		               	document.getElementById(iframeId).style.display = "";	

						//document.getElementById('iframeId0').innerHTML=httpDoc.responseText;

						document.getElementById(iframeId).innerHTML=httpDoc.responseText;

						

						

						}

					  }     

		httpDoc.send(data);	

					

					

				}

				else

				{

					jAlert("Please save or close the tag view before accessing another tag view","Alert");

					return false;

				}

			}

		}

	

		xmlHttpTree.open("GET", url, true);

		xmlHttpTree.send(null);

		

		

		



		//alert(baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType);

		

		//document.getElementById(spanId2).style.display = "none";	

			

	}

	function showNewTag(nodeId, workspaceId, workspaceType, artifactId, artifactType, tagId, option,nodeorder)

	{		

		

		var spanId1 = 'spanTagView'+nodeorder;

		var spanId2 = 'normalView'+nodeorder;		

		var iframeId = 'iframeId'+nodeorder;	

		var spanTagNew = 'spanTagNew'+nodeorder;	

		//document.getElementById(spanTagNew).style.display = "none";	

		//alert(option);

		

		

		var httpDoc = getHTTPObjectm();

		

		if(option == 1)

		{ 

			urlm = baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;

		}

		else if(option == 2)

		{

			urlm=  baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/3/'+tagId;		

		}

		else if(option == 3)

		{

			urlm = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/1/'+tagId;		

		}

		 data='nodeorder='+nodeorder;

			   

		httpDoc.open("POST", urlm, true); 

		httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

							

						document.getElementById(spanId1).style.display = "";

		               	document.getElementById(iframeId).style.display = "";	

						//document.getElementById('iframeId0').innerHTML=httpDoc.responseText;

						document.getElementById(iframeId).innerHTML=httpDoc.responseText;

						

						

						}

					  }     

		httpDoc.send(data);	

					

					

				

		//alert(baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType);

		

		//document.getElementById(spanId2).style.display = "none";	

			

	}

	

function showNewTagResponse(nodeId, workspaceId, workspaceType, artifactId, artifactType, tagId, option,nodeorder)

	{		

		

		var httpDoc = getHTTPObjectm();

		

		if(option == 1)

		{ 

			urlm = baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;

		}

		else if(option == 2)

		{

			urlm=  baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/3/'+tagId;		

		}

		else if(option == 3)

		{

			urlm = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/1/'+tagId;		

		}

		 data='nodeorder='+nodeorder;

			   

		httpDoc.open("POST", urlm, true); 

		httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

						

							document.getElementById("actionTagResponse").innerHTML=httpDoc.responseText;

						

						}

					  }     

		httpDoc.send(data);	

	

	}	

	function getTagesPage(workSpaceId,workSpaceType,artifactId,artifactType,flag,tagType,nodeorder)

	{

		

		var httpDoc = getHTTPObjectm();

		var iframeId = 'iframeId'+nodeorder;	

		alert(iframeId);

		//urlm=baseUrl+'add_tag/index/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+ artifactType+'/'+flag+'/'+tagType+'/'+nodeorder;

		urlm=baseUrl+'add_tag/index/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+ artifactType+'/'+flag+'/'+tagType+'/';

		

		 data='nodeorder='+nodeorder;	   

		httpDoc.open("POST", urlm, true); 

		httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

		document.getElementById(iframeId).style.display = "";	

						//alert(httpDoc.responseText);

						document.getElementById(iframeId).innerHTML=httpDoc.responseText;

						

						

						

						}

					  }     

		httpDoc.send(data);



		//alert(baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType);

		

		//document.getElementById(spanId2).style.display = "none";	

			

	

		

		}

	

	function showNewTagLeaf(nodeId, workspaceId, workspaceType, artifactId, artifactType, tagId, option,nodeorder)

	{		

		//alert ('nodeorder= ' + nodeorder);

		//alert ('tagid= ' +tagId);

		//var spanId1 = 'spanTagViewLeaf'+nodeorder;

		var spanId2 = 'normalView'+nodeorder;		

		var iframeId = 'iframeIdLeaf'+nodeorder;	



		//var spanTagNew = 'spanTagNewLeaf'+nodeorder;	

		//document.getElementById(spanTagNew).style.display = "none";	



		//alert(baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType);

		if(option == 1)

		{ 

			document.getElementById(iframeId).src = baseUrl+'add_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType;

		}

		else if(option == 2)

		{

			document.getElementById(iframeId).src = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/3/'+tagId;	

		}

		else if(option == 3)

		{

			document.getElementById(iframeId).src = baseUrl+'act_tag/index/'+workspaceId+'/'+workspaceType+'/'+artifactId+'/'+artifactType+'/0/3/1/'+tagId;	

		}

		//document.getElementById(spanId2).style.display = "none";	

		//document.getElementById(spanId1).style.display = "";

		document.getElementById(iframeId).style.display = "";	

	}	

	function refreshParentWindow()

	{	

		window.opener.location.reload();

	}

	//Change the background of the tag when clicking the tag

	function changeBackgroundSpan(tagId)

	{

		var tagSpanId = 'tagSpan'+tagId;		

		if(trim(document.getElementById(tagSpanId).style.backgroundColor ) == '#6699ff')

		{ 			

			document.getElementById(tagSpanId).style.backgroundColor  = '';

		}

		else

		{

			document.getElementById(tagSpanId).style.backgroundColor  = '#6699ff';

		}

		if(document.getElementById('tag').value == 0)

		{

			document.getElementById('tag').value = tagId;

		}

		else

		{		

				

			var tagIds = new Array();			

			var curTagIds = document.getElementById('tag').value.split(',');

					

			var addedStatus = 0;		

			var j = 0;			

			for(var i=0; i<curTagIds.length; i++)

			{		

				if(tagId == curTagIds[i])

				{				

					addedStatus = 1;				

				}

				if(tagId != curTagIds[i])

				{								

					tagIds[j] = curTagIds[i];

					j++;	

				}						

			}	

			

			if(addedStatus == 0)

			{

				tagIds[j] = tagId;

			}	

			if(tagIds.length > 0)

			{

				document.getElementById('tag').value = tagIds.join();

			}

			else

			{

				document.getElementById('tag').value = 0;

			}

		}			

	}

function loadDatePicker()
{
	$("#endTime").datepicker({dateFormat:"dd-mm-yy"});
}	



function validateTagForm()

{

	//document.frmTag.sequence.value = 1;


		var obj = document.frmTag;	
		//alert(obj.tagOption.value);

		if(obj.tagOption.value == 1 || obj.tagOption.value == 2)

		{

			if(trim(obj.tag.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

			

		}	

		else if(obj.tagOption.value == 3)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tagComments.focus();
								
				return false;

			}
			
			//Manoj: Check end date with current date start 
			var current_date = new Date();
			var curr_date = ('0'+current_date.getDate()).slice(-2);
			var current_mnth=current_date.getMonth()+1;
			var curr_month = ('0'+current_mnth).slice(-2);
			var curr_year = current_date.getFullYear();
			var currentTime= curr_month + "," + curr_date + "," + curr_year;
			var current_time = new Date(currentTime);
			
			var endTime = document.getElementById('endTime').value;
			var entTimeArray = endTime.split('-');
			var End_Time = entTimeArray[1] + "," + entTimeArray[0] + "," + entTimeArray[2];
			var end_time = new Date(End_Time);
			
			if(current_time > end_time && endTime!="")
			{
				jAlert("Tags should not be allowed for prior date!");
				return false;
			}
			//Manoj: Check end date with current date end
			
			

		}		

		else if(obj.tagOption.value == 4)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the task name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}	

		else if(obj.tagOption.value == 5)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}

		else if(obj.tagOption.value == 6)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}				

		/*if(document.frmTag.sequence.value == 0)
		{		
			if(document.frmTag.tagType.value == 0)
			{
				alert('Please select the tag type');
				return false;
			}	
		}
		*/	

		//return true;		

	   

	    //obj.submit();

	    var xmlHttpRequest = GetXmlHttpObject2();

		var treeId=document.getElementById('treeId1').value; 
		//alert (treeId);

	  	var tag=document.getElementById('tagType').value; 

	  	var tagComments=document.getElementById('tagComments').value; 

		

	  	var voteQuestion=document.getElementById('voteQuestion').value; 

		

	  	var noOfOptions=document.getElementById('noOfOptions').value; 

	  	//var selectionOptions=document.getElementById('selectionOptions').value; 

	  	var showMembers=''; 

	  	//var taggedUsers=document.getElementById('taggedUsers').value; 

	  	var actionDate=document.getElementById('actionDate').value; 

	  	var endTime=document.getElementById('endTime').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

		var artifactType=document.getElementById('artifactType').value;

		var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

		var sequenceTagId=document.getElementById('sequenceTagId').value;

		var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

		var tagOption=3;

		

		var selectionOptions1 = new Array; 

		//array to store checked checkboxes value]]

		

		$('[name=selectionOptionsAction]').each(function()

		{  

			if($(this).val()!='')

			{									 

		   		selectionOptions1.push($(this).val());

			}

			

							

		 });

	    

		

		var taggedUsers1 = new Array;

		

		$('[name=taggedUsers]').each(function()

		{  

			if(this.checked)

			{									 

		   		taggedUsers1.push($(this).val());

			}

			

							

		 });
		
		//Manoj: Checked selected user at edit time start
		if(taggedUsers1==0)
		{
			jAlert('Please select at least one user','Alert');				

			return false;
		}
		//Manoj: Checked selected user at edit time end
		

 		

	  	//addOption='new';

	  	$('#popCloseBox', window.parent.document).hide();
		
		$(".actionTagLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		urlm=baseUrl+'create_tag1';

		

		if(getUrlVars()["doc"]){

			var doc=1;

		}

		else{

			var doc=0;

		}

		//alert (document.referrer);

		data='tag='+tag+'&tagComments='+encodeURIComponent(tagComments)+'&voteQuestion='+encodeURIComponent(voteQuestion)+'&noOfOptions='+noOfOptions+'&selectionOptions='+selectionOptions1+'&showMembers='+showMembers+'&taggedUsers='+taggedUsers1+'&actionDate='+actionDate+'&endTime='+endTime+'&artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&returnUrl='+encodeURIComponent(document.referrer)+'&doc='+doc;

		

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

		{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{  

			     /*Added by Surbhi IV*/

				 $('[name=selectionOptionsAction]').each(function()

				 {  

					 if($(this).val()!='')

					 {									 

						$(this).val('');

					 }

				 });

                 document.getElementById("tagComments").value='';

				 edit_action_tag(document.getElementById("workSpaceId").value,document.getElementById("workSpaceType").value,document.getElementById("artifactId").value,document.getElementById("artifactType").value,document.getElementById("sequenceTagId").value,document.getElementById("tagType").value,'');

				 

				 /*End of Added by Surbhi IV*/

				 var temp=xmlHttpRequest.responseText.split('|||@||');//alert(xmlHttpRequest.responseText);return;
				//alert (temp);
				 //for new ui

				 document.getElementById("showTagsAction").innerHTML=temp[0];

				 //document.getElementById("ActionMessage").innerHTML='<p>'+temp[1]+'<p>';

                

                 var xmlHttptagRequest1 = GetXmlHttpObject2();

				 

				 urlmTag=baseUrl+'create_tag1/countAllTagsByTreeId/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType;


				 xmlHttptagRequest1.open("POST", urlmTag, true);

		 

				 xmlHttptagRequest1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				

				 xmlHttptagRequest1.onreadystatechange = function()

				 										 {

															if (xmlHttptagRequest1.readyState==4 && xmlHttptagRequest1.status==200)

															{

																
																//alert ('Hello');
																var temp2=xmlHttptagRequest1.responseText.split("|||@||");

																//alert (temp2);

																if(temp2[1]!='')

																{
																		//alert ('Here');

																	document.getElementById("tags_container").innerHTML='<p>'+temp2[1]+'</p>';	

																	<!--Added by Surbhi IV -->

																	document.getElementById("tagComments").value='';

																	<!--End of Added by Surbhi IV -->

																	setTagAndLinkCount(artifactId,artifactType);

																	setTagsAndLinksInTitle(artifactId,artifactType);
																	
																	$(".actionTagLoader").html("");
				
																	$('#popCloseBox', window.parent.document).show();
																	
																	//Alert message Code start
																	var currentTreeId = $('#currentTreeId').val();
																	var nodeId = $('#nodeId').val();
																	var leafId = $('#leafId').val();
																	var leafOrder = $('#leafOrder').val();
																	var parentLeafId = $('#parentLeafId').val();
																	var treeLeafStatus = $('#treeLeafStatus').val();
																	var treeType = $('#treeType').val();
																	//var artifactType = $('#artifactType').val();
																	var successorLeafStatus = $('#successorLeafStatus').val();
																	if(treeType==1 && artifactType==2)
																	{						              																															//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
																	getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
																	}
																	if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
																	{
																		getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
																	}
																	//Code end
																	
																	//loadDatePicker();
																	

																}

																

															}

														 }

				 xmlHttptagRequest1.send();
				 

			}

		}     

		xmlHttpRequest.send(data);

}


function submitAppliedTags()

{
	
		var httpDoc1    = GetXmlHttpObject2();

		var searchTags  = document.getElementById('searchTags').value; 		

	  	var artifactId  = document.getElementById('artifactId').value; 

	  	var artifactType= document.getElementById('artifactType').value; 

	  	var sequence= document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

	  	var sequenceTagId=document.getElementById('sequenceTagId').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var tagOption=document.getElementById('tagOption').value; 

	  	var sectionTagIds=document.getElementById('sectionTagIds').value; 

	  	var sectionChecked=document.getElementById('sectionChecked').value; 

		var treeId=document.getElementById('treeId').value;

		var countAppliedTags=document.getElementById('countAppliedTags1').value;

		var unAppliedTags1 = new Array; 

		var systemTagVal = 0;		        

		 var unAppliedTags1 = [];

		 var unChecked1 = [];

		$('[name=unAppliedTags]').each(function()
		{
			//alert (this.value);
			//alert ($(this).hasClass('colorTags'));
			if(this.checked)

			{	

			    if($(this).hasClass('colorTags')){

					systemTagVal = $(this).next().html().toLowerCase();		

				}

		   		unAppliedTags1.push($(this).val());

				

			}

			else

			{  

				unChecked1.push($(this).val());

				

			}

							

		});

		

		document.getElementById('countAppliedTags1').value=unAppliedTags1.length;

		if( (unAppliedTags1.length <1 ) && (countAppliedTags < 1) )

		{

			document.getElementById('simpleTagMessage').innerHTML='<p>Please select simple(s) you wish to tag.</p>';

			//alert("hi");

			return false;

		}
		
		$('#popCloseBox', window.parent.document).hide();
		
		$(".simpleTagLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

	  	appliedTags=document.getElementById('appliedTags').value;

	  

	  	addOption='update';

	  
		
		urlm=baseUrl+'create_tag1/index';
		//alert (urlm);
		

		if(getUrlVars()["doc"]){

			var doc=1;

		}

		else{

			var doc=0;

		}

		

		data='treeId='+treeId+'&searchTags='+searchTags+'&artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&sectionChecked='+sectionChecked+'&sectionTagIds='+sectionTagIds+'&appliedTags='+appliedTags+'&addOption='+addOption+'&unAppliedTags='+unAppliedTags1+'&unChecked='+unChecked1+'&returnUrl='+encodeURIComponent(document.referrer)+'&doc='+doc;

		

		httpDoc1.open("POST", urlm, true);

		 

		httpDoc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		httpDoc1.onreadystatechange = function()

		{

			if (httpDoc1.readyState==4 && httpDoc1.status==200)

			{  

				//alert(httpDoc1.responseText);return;

				var temp=httpDoc1.responseText.split("|||@||");

					

				if(temp[0]!='')

				{

					/*
					$.each(unAppliedTags1, function(key, value) {
												
  						$("#span_"+value).addClass("clsCheckedTags");				
							});
					*/

				

					/*document.getElementById('simpleTagMessage').innerHTML='<p>'+temp[2]+'</p>'; */

					document.getElementById('tags_container').innerHTML=temp[1];

					showTagsAjax(1);

					$("#showTagsSimple").scrollTop(0);

					setTagAndLinkCount(artifactId,artifactType);

					setTagsAndLinksInTitle(artifactId,artifactType);

					

						//alert ('systemtag= ' + systemTagVal);
						//alert ('blockid= ' + blockId);
					

						if(systemTagVal){

							if(blockId==0){
								
								var treeContentLength = $("#treeContent",parent.document).length;

								$("#treeContent",parent.document).removeClass();

								$("#treeContent",parent.document).addClass(systemTagVal+'_systemTag');		

								//alert($(".clsNoteTreeHeader > div:nth-child(1)",parent.document).attr('class'));
								if(treeContentLength===0)
								{
								$(".clsNoteTreeHeader > div",parent.document).removeClass();

								$(".clsNoteTreeHeader > div",parent.document).addClass(systemTagVal+'_systemTag');

								$(".clsNoteTreeHeader > div",parent.document).addClass('seedBgColor');

								$(".clsNoteTreeHeader > div:nth-child(1)",parent.document).addClass("handCursor");

								$(".clsNoteTreeHeader > div:nth-child(1)",parent.document).addClass("seedHeading");
								}

							}

							else{

								$("#leaf_contents"+blockId,parent.document).removeClass();

								$("#leaf_contents"+blockId,parent.document).addClass('contentContainer');

								$("#leaf_contents"+blockId,parent.document).addClass(systemTagVal+'_systemTag');

								

								id = $("#latestcontent"+blockId+" > div > div:nth-child(2)",parent.document).attr('id');

								

								$("#"+id,parent.document).removeClass();

								$("#"+id,parent.document).addClass('handCursor');

								$("#"+id,parent.document).addClass(systemTagVal+'_systemTag');
								
								//For subtask
								var subtaskdivid = $('.leaf_contents'+blockId,parent.document).attr("id");
								$('#'+subtaskdivid,parent.document).removeAttr('class');
								$('#'+subtaskdivid,parent.document).addClass("handCursor "+systemTagVal+"_systemTag leaf_contents"+blockId);

							}

						

						}

						else{

							if(blockId==0){

								$("#treeContent",parent.document).removeClass();

								$(".clsNoteTreeHeader > div",parent.document).removeClass();

								$(".clsNoteTreeHeader > div",parent.document).addClass('seedBgColor');

								$(".clsNoteTreeHeader > div:nth-child(1)",parent.document).addClass("handCursor");

								$(".clsNoteTreeHeader > div:nth-child(1)",parent.document).addClass("seedHeading");

							}

							else{

								$("#leaf_contents"+blockId,parent.document).removeClass();

								$("#leaf_contents"+blockId,parent.document).addClass('contentContainer');

								

								id = $("#latestcontent"+blockId+" > div > div:nth-child(2)",parent.document).attr('id');

								

								$("#"+id,parent.document).removeClass();

								$("#"+id,parent.document).addClass('handCursor');
								
								//For subtask
								var subtaskdivid = $('.leaf_contents'+blockId,parent.document).attr("id");
								$('#'+subtaskdivid,parent.document).removeAttr('class');
								$('#'+subtaskdivid,parent.document).addClass("handCursor leaf_contents"+blockId);

							}

						}

						

						

					

				}
				
				$(".simpleTagLoader").html("");
				
				$('#popCloseBox', window.parent.document).show();
				
				//Alert message Code start
				var currentTreeId = $('#currentTreeId').val();
				var nodeId = $('#nodeId').val();
				var leafId = $('#leafId').val();
				var leafOrder = $('#leafOrder').val();
				var parentLeafId = $('#parentLeafId').val();
				var treeLeafStatus = $('#treeLeafStatus').val();
				var treeType = $('#treeType').val();
				//var artifactType = $('#artifactType').val();
				var successorLeafStatus = $('#successorLeafStatus').val();
				if(treeType==1 && artifactType==2)
				{
					//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
					getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
				}
				if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
				{
					//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
					getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
				}
				//Code end
				

			}

		}     

		httpDoc1.send(data);

}



function createSimpleTag()

{

		if(trim(document.getElementById('tag').value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

	

	  	var httpDoc1 = GetXmlHttpObject2();

		var tag=document.getElementById('tag').value; 		

	  	var artifactId=document.getElementById('artifactId').value; 

	  	var artifactType=document.getElementById('artifactType').value; 

	  	var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

	  	var sequenceTagId=document.getElementById('sequenceTagId').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var tagOption=document.getElementById('tagOption').value; 

	  	var sectionTagIds=document.getElementById('sectionTagIds').value; 

	  	var sectionChecked=document.getElementById('sectionChecked').value; 

		var treeId=document.getElementById('treeId').value;

		var unAppliedTags1 = new Array; 
		
		var systemTagVal = 0;	        

		 var unAppliedTags1 = [];

		 var unChecked1 = [];		

		//array to store checked checkboxes value

		

		$('[name=unAppliedTags]').each(function()

		{

			if(this.checked)
			{									 
			    if($(this).hasClass('colorTags')){

					systemTagVal = $(this).next().html().toLowerCase();		

				}
		   		unAppliedTags1.push($(this).val());

			}
			else
			{
				unChecked1.push($(this).val());
			}

			

		});

	 

	  	appliedTags=document.getElementById('appliedTags').value;

	  

	  	addOption='new';

	  

		urlm=baseUrl+'create_tag1/index';

		

		data='treeId='+treeId+'&tag='+tag+'&artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&sectionChecked='+sectionChecked+'&sectionTagIds='+sectionTagIds+'&appliedTags='+appliedTags+'&addOption='+addOption+'&unAppliedTags='+unAppliedTags1+'&unChecked='+unChecked1;

		

		

		httpDoc1.open("POST", urlm, true);

		 

		httpDoc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		httpDoc1.onreadystatechange = function()

		{

			if (httpDoc1.readyState==4 && httpDoc1.status==200)

			{

				var temp=httpDoc1.responseText.split('|||@||');

				if(temp[0]!='')

				{
					//alert (temp[0]);
					document.getElementById('showTagsSimple').innerHTML=temp[0];

				}

				document.getElementById('simpleTagMessage').innerHTML='<p>'+temp[1]+'</p>';

				document.getElementById('tag').value='';
				
				
				//Alert message Code start
						var currentTreeId = $('#currentTreeId').val();
						var nodeId = $('#nodeId').val();
						var leafId = $('#leafId').val();
						var leafOrder = $('#leafOrder').val();
						var parentLeafId = $('#parentLeafId').val();
						var treeLeafStatus = $('#treeLeafStatus').val();
						var treeType = $('#treeType').val();
						var artifactType = $('#artifactType').val();
						var successorLeafStatus = $('#successorLeafStatus').val();
						if(treeType==1 && artifactType==2)
						{	
							//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
							getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
						}
						if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
						{
							getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
						}
				//Code end
				

			}

		}     

		httpDoc1.send(data);

}



//function delete_action_tags()

function submit_tags_form()

{

		

		var httpDoc1 = GetXmlHttpObject2();

		var treeId=document.getElementById('treeId').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

	  	var artifactType=document.getElementById('artifactType').value; 

	  	var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

	  	var sequenceTagId=document.getElementById('sequenceTagId').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var tagOption=document.getElementById('tagOption').value; 

	  	var sectionTagIds=document.getElementById('sectionTagIds').value; 

	  	var sectionChecked=document.getElementById('sectionChecked').value; 

		var appliedTags=document.getElementById('appliedTags').value; 

		var sectionTagIds123=document.getElementById('sectionTagIds').value; 

		var addOption=document.getElementById('addOption').value; 

		

		var divContactTags='divContactTags0';

		var contactTags='contactTags0';

		var iframeId='iframeId0';

		var liTag='liTag';

	

		if(artifactType==2)

		{

		  	contactTags="contactTags"+artifactId;

			divContactTags="divContactTags"+artifactId;

			iframeId='iframeId'+artifactId;

			liTag='liTag'+artifactId;

			

		}

		//alert(sectionTagIds);

	

		var unAppliedTags1 = new Array; 

		//array to store checked checkboxes value

		

	

 		 for(var i = 0; i < document.frmTag0.unAppliedTags.length; i++)

		 {

    			if(document.frmTag0.unAppliedTags[i].checked)

				{

       				unAppliedTags1.push(document.frmTag0.unAppliedTags[i].value);

  				}

		

		}

		

		urlm=baseUrl+'create_tag1';

		

		var data='artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&unAppliedTags='+unAppliedTags1+'&appliedTags='+appliedTags+'&addOption='+addOption+'&sectionChecked='+sectionChecked+'&sectionTagIds='+sectionTagIds123;

		

		

		httpDoc1.open("POST", urlm, true);

		 

		httpDoc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		httpDoc1.onreadystatechange = function()

		{

			  document.getElementById(iframeId).innerHTML=httpDoc1.responseText;

			if (httpDoc1.readyState==4 && httpDoc1.status==200)

			{

				

				document.getElementById(iframeId).innerHTML=httpDoc1.responseText;

			

				var httpDoc2 = GetXmlHttpObject2();

				 

				urlm2=baseUrl+'create_tag1/countAllTagsByTreeId/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType;

				

				httpDoc2.open("POST", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{   var temp=httpDoc2.responseText.split("|||@||");

						

						if(temp[3]!='')

						{

						document.getElementById(contactTags).innerHTML=temp[3];	

						document.getElementById(divContactTags).style.display='';

						document.getElementById(liTag).setAttribute("class", "tag disblock");

						document.getElementById(liTag).innerHTML='<strong>'+temp[0]+'</strong>';

						}

						else

						{

						document.getElementById(divContactTags).style.display='none';

						document.getElementById(liTag).setAttribute("class", "tag disnone");

						}

					}

				}

				httpDoc2.send(); 



			}

		}     

		httpDoc1.send(data); 

   

}



//function for contact tags

function submit_tags_form_ajax()

{

		var httpDoc1 = GetXmlHttpObject2();

		var treeId=document.getElementById('treeId123').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

	  	var artifactType=document.getElementById('artifactType').value; 

	  	var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

	  	var sequenceTagId=document.getElementById('sequenceTagId').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var tagOption=5; 

	  	var sectionTagIds=document.getElementById('sectionTagIds').value; 

	  	var sectionChecked=document.getElementById('sectionChecked').value; 

		var appliedTags=document.getElementById('appliedTags').value; 

		var sectionTagIds123=document.getElementById('sectionTagIds').value; 

		var addOption=document.getElementById('addOption').value; 

		var countAppliedTags=document.getElementById('countAppliedTags1').value; 

		

		//alert(sectionTagIds);

	

		var unAppliedTags1 = []; 

		var unChecked1=[];

		//array to store checked checkboxes value

		

		$('[name=unAppliedTagsContact]').each(function()

		{

			if(this.checked)

			{									 

		   		unAppliedTags1.push($(this).val());

			}

			else

			{  

				unChecked1.push($(this).val());

				

				}

							

		 });

		

		document.getElementById('countAppliedTags1').value=unAppliedTags1.length;

		if( (unAppliedTags1.length <1 ) && (countAppliedTags < 1) )

		{

			document.getElementById('contactMessage').innerHTML='<p>Please select contact(s) you wish to tag.</p>';

			//alert("hi");

			return false;

			}

	
		
		$('#popCloseBox', window.parent.document).hide();
		
		$(".contactTagLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		

		urlm=baseUrl+'create_tag1';

		

		

		if(getUrlVars()["doc"]){

			var doc=1;

		}

		else{

			var doc=0;

		}

		

		

		var data='artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&unAppliedTags='+unAppliedTags1+'&appliedTags='+appliedTags+'&addOption='+addOption+'&sectionChecked='+sectionChecked+'&sectionTagIds='+sectionTagIds123+'&unChecked='+unChecked1+'&returnUrl='+encodeURIComponent(document.referrer)+'&doc='+doc;

		

		httpDoc1.open("POST", urlm, true);

		 

		httpDoc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		httpDoc1.onreadystatechange = function()

		{

			if (httpDoc1.readyState==4 && httpDoc1.status==200)

			{  

				

				search_contact_tags_contact();

				

				$("#divshowTagsContact").scrollTop(0);

				

				//alert(httpDoc1.responseText);

				var temp=httpDoc1.responseText.split('|||@||');

				

				

				

				document.getElementById('divshowTagsContact').innerHTML=temp[0];

				/*	document.getElementById('contactMessage').innerHTML='<p>'+temp[1]+'</p>'; */

			

				var httpDoc2 = GetXmlHttpObject2();

				 

				urlm2=baseUrl+'create_tag1/countAllTagsByTreeId/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType;

				

				httpDoc2.open("GET", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{ 

						setTagAndLinkCount(artifactId,artifactType);

						setTagsAndLinksInTitle(artifactId,artifactType);

						

						var temp2 = new Array();

					  // alert(httpDoc2.responseText);

					   var temp2=httpDoc2.responseText.split("|||@||");

					//	alert(temp2);

						if(temp2[1]!='')

						{

							document.getElementById("tags_container").innerHTML=temp2[1];

						}

						$(".contactTagLoader").html("");
				
						$('#popCloseBox', window.parent.document).show();
						
						//Alert message Code start
						var currentTreeId = $('#currentTreeId').val();
						var nodeId = $('#nodeId').val();
						var leafId = $('#leafId').val();
						var leafOrder = $('#leafOrder').val();
						var parentLeafId = $('#parentLeafId').val();
						var treeLeafStatus = $('#treeLeafStatus').val();
						var treeType = $('#treeType').val();
						//var artifactType = $('#artifactType').val();
						var successorLeafStatus = $('#successorLeafStatus').val();
						if(treeType==1 && artifactType==2)
						{	
							//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
							getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
						}
						if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
						{
							getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
						}
						//Code end
						

					}

				}

				httpDoc2.send(); 



			}

		}     

		httpDoc1.send(data); 

   

}



//function delete_action_tags()

function submit_action_tags_form()

{      

		

		var httpDoc1 = GetXmlHttpObject2();

		var treeId=document.getElementById('treeIdDelete').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

	  	var artifactType=document.getElementById('artifactType').value; 

	  	var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

	  	var sequenceTagId=document.getElementById('sequenceTagId').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var tagOption=3; 

	  	var sectionTagIds=document.getElementById('sectionTagIds').value; 

	  	var sectionChecked=document.getElementById('sectionCheckedAction').value; 

		var appliedTags=document.getElementById('appliedTags').value; 

		var sectionTagIds123=document.getElementById('sectionTagIds').value; 

		var addOption=document.getElementById('addOption').value; 

	

		var unAppliedTags1 = new Array; 

		//array to store checked checkboxes value

		
		$('#popCloseBox', window.parent.document).hide();
		
		$(".actionDeleteTagLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		

		$('[name=unAppliedTagsActionDelete]').each(function()

		{

			if(this.checked)

			{									 

		   		unAppliedTags1.push($(this).val());

			}

			

							

		 });


		
		urlm=baseUrl+'create_tag1';

		

		var data='artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+'&unAppliedTags='+unAppliedTags1+'&appliedTags='+appliedTags+'&addOption='+addOption+'&sectionChecked='+sectionChecked+'&sectionTagIds='+sectionTagIds123;

		

		

		httpDoc1.open("POST", urlm, true);

		 

		httpDoc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		httpDoc1.onreadystatechange = function()

		{  

		    

			if (httpDoc1.readyState==4 && httpDoc1.status==200)

			{   

				

				var temp= httpDoc1.responseText.split("|||@||");

				//alert(temp);

				document.getElementById('showTagsAction').innerHTML=temp[0];

				//document.getElementById('ActionMessage').innerHTML='<p>'+temp[1]+'</p>';

				var httpDoc2 = GetXmlHttpObject2();

				 

				urlm2=baseUrl+'create_tag1/countAllTagsByTreeId/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType;

				

				httpDoc2.open("POST", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{  

						var temp2=httpDoc2.responseText.split("|||@||");

						

						if(temp2[1]!='')

						{

							document.getElementById("tags_container").innerHTML='<p>'+temp2[1]+'</p>';	

							setTagAndLinkCount(artifactId,artifactType);

							setTagsAndLinksInTitle(artifactId,artifactType);

						    

						}

						

						$(".actionDeleteTagLoader").html("");
				
						$('#popCloseBox', window.parent.document).show();

					}

				}

				httpDoc2.send(); 



			}

		}     

		httpDoc1.send(data); 

   

}











function editActionForm() 

{

	document.frmTag.sequence.value = 1;

	

	

		var obj = document.frmTag;	

		

		

		if(obj.tagOption.value == 1 || obj.tagOption.value == 2)

		{

			if(trim(obj.tag.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tag.focus();

				return false;

			}

			

		}	

		else if(obj.tagOption.value == 3)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the tag name','Alert');

				obj.tagComments.focus();

				return false;

			}
			
			//Manoj: Check end date with current date start 
			var current_date = new Date();
			var curr_date = ('0'+current_date.getDate()).slice(-2);
			var current_mnth=current_date.getMonth()+1;
			var curr_month = ('0'+current_mnth).slice(-2);
			var curr_year = current_date.getFullYear();
			var currentTime= curr_month + "," + curr_date + "," + curr_year;
			var current_time = new Date(currentTime);
			
			var endTime = document.getElementById('endTime').value;
			var entTimeArray = endTime.split('-');
			var End_Time = entTimeArray[1] + "," + entTimeArray[0] + "," + entTimeArray[2];
			var end_time = new Date(End_Time);
			
			if(current_time > end_time && endTime!="")
			{
				jAlert("Tags should not be allowed for prior date!");
				return false;
			}
			//Manoj: Check end date with current date end

		}		

		else if(obj.tagOption.value == 4)

		{

			if(trim(obj.tagComments.value) == '')

			{

				jAlert('Please enter the task name','Alert');

				obj.tagComments.focus();

				return false;

			}				

		}	

		else if(obj.tagOption.value == 5)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}

		else if(obj.tagOption.value == 6)

		{

			if(document.getElementById('tag').value == 0)

			{

				jAlert('Please select the tag to apply','Alert');				

				return false;

			}					

		}				

		

	    

		var xmlHttpRequest = GetXmlHttpObject2();

		

		var treeId=document.getElementById('treeId').value; 

	  	var tag=document.getElementById('tagType').value; 

		selectionOptions1 = new Array; 

		var voteQuestion='';

		var noOfOptions='';

	  	var tagComments=document.getElementById('tagComments').value; 

		if(tag==3 && document.getElementById('voteQuestion'))

		{

			voteQuestion=document.getElementById('voteQuestion').value; 

		

		

	  		// noOfOptions=document.getElementById('noOfOptions').value; 

		}

	

		else if(tag==2 && obj.selectionOptions)

		{

			

			

				

				//array to store checked checkboxes value

			

			   

				 for(var i = 0; i < obj.selectionOptions.length; i++)

				 {

						

							selectionOptions1.push(obj.selectionOptions[i].value);

						

				}

			

		}

	  	var showMembers='';

	  	//var showMembers=document.getElementById('showMembers').value; 

	  	var editTagId=document.getElementById('editTagId').value; 

	  	var actionDate=document.getElementById('actionDate').value; 

	  	var endTime=document.getElementById('endTime').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

		var artifactType=document.getElementById('artifactType').value;

		var sequence=document.getElementById('sequence').value; 

	  	var sequenceOrder=document.getElementById('sequenceOrder').value; 

		var sequenceTagId=document.getElementById('sequenceTagId').value;

		var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

		var tagOption=3;

		

		

		var taggedUsers1 = new Array;

		

		$('[name=taggedUsers]').each(function()

		{  

			if(this.checked)

			{									 

		   		taggedUsers1.push($(this).val());

			}

		});
		
		//Manoj: Checked selected user at edit time start
		if(taggedUsers1==0)
		{
			jAlert('Please select at least one user','Alert');				

			return false;
		}
		//Manoj: Checked selected user at edit time end

		var selectionOptions1 = new Array; 

		//array to store checked checkboxes value]]

		

		$('[name=selectionOptionsAction]').each(function()

		{  

			if($(this).val()!='')

			{									 

		   		selectionOptions1.push($(this).val());

			}

			

							

		 });

	 

	  	//addOption='new';

	  

		urlm=baseUrl+'create_tag1';

		

		data='tag='+tag+'&tagComments='+encodeURIComponent(tagComments)+'&voteQuestion='+encodeURIComponent(voteQuestion)+'&noOfOptions='+noOfOptions+'&selectionOptions='+selectionOptions1+'&showMembers='+showMembers+'&taggedUsers='+taggedUsers1+'&actionDate='+actionDate+'&endTime='+endTime+'&artifactId='+artifactId+'&artifactType='+artifactType+'&sequence='+sequence+'&sequenceOrder='+sequenceOrder+'&sequenceTagId='+sequenceTagId+'&sequenceTagId='+sequenceTagId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagOption='+tagOption+"&addOption=edit&tagType="+tag+"&editTagId="+editTagId;

		

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

		{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				 

				 

				  var temp=xmlHttpRequest.responseText.split('|||@||');

				 //for new ui

				 /*Added by Surbhi IV*/

				 $('[name=selectionOptionsAction]').each(function()

				 {  

					 if($(this).val()!='')

					 {									 

						$(this).val('');

					 }

				 });

                 //document.getElementById("tagComments").value='';

				// document.getElementById("tagType").disabled='';

				// alert(document.getElementById("tagType").value);

				  edit_action_tag(document.getElementById("workSpaceId").value,document.getElementById("workSpaceType").value,document.getElementById("artifactId").value,document.getElementById("artifactType").value,document.getElementById("sequenceTagId").value,document.getElementById("tagType").value,document.getElementById("tagId").value);

				 /*End of Added by Surbhi IV*/

				 document.getElementById("showTagsAction").innerHTML=temp[0];

				 document.getElementById("ActionMessage").innerHTML='<p>'+temp[1]+'<p>';

				

				// document.getElementById(iframeId).innerHTML=xmlHttpRequest.responseText;

				/* 
				 var xmlHttptagRequest = GetXmlHttpObject2();
				 
				 urlmTag=baseUrl+'act_tag/getUserTags';
				 
				 dataTag="treeId="+treeId;
				 
				 xmlHttptagRequest.open("POST", urlmTag, true);
		 
				xmlHttptagRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				
				xmlHttptagRequest.onreadystatechange = function()
				{
					if (xmlHttptagRequest.readyState==4 && xmlHttptagRequest.status==200)
					{
						
				 		document.getElementById("divActionTagContainer").innerHTML=xmlHttptagRequest.responseText;
					}
				}
				 xmlHttptagRequest.send(dataTag);
				 */



			}

		}     

		xmlHttpRequest.send(data);

}



function getSearchedLinksByKeywords(nodeOrder, nodeId, artifactType, workspaceId, workspaceType, linkType,latestVersion,position,documentType)

{	

	//alert ('nodeOrder= ' + nodeOrder);

	//alert ('latestVersion= ' + latestVersion);

	if (position)

	{

		showdetail (position);	

	}

	spanArtifactLinks = 'spanArtifactLinks'+nodeOrder;

	var linkIframeId = 'linkIframeId'+nodeOrder;

	var url = baseUrl+'show_artifact_links';

	var spanTagId1 = 'spanTagView'+nodeOrder;	

	//document.getElementById(spanTagId1).style.display = 'none';

	//alert ('linkIframeId= ' + linkIframeId);

	//alert("hi";)

	//document.getElementById(linkIframeId).innerHTML;

	

	var httpDoc = getHTTPObjectm();

	

	var urlm= baseUrl+'show_artifact_links/searchLinksByKeyword/'+nodeId+'/'+artifactType+'/'+workspaceId+'/'+workspaceType+'/'+linkType+'/'+nodeOrder+'/'+latestVersion+'/search';

	

	if(documentType=='docs')

	{ 

		searchLinks=	document.getElementById('searchLinksDoc').value;

		

	}

	if(documentType=='chat')

	{ 

		searchLinks=	document.getElementById('searchLinksChat').value;

		

	}

	else if(documentType=='activity')

	{

		searchLinks=	document.getElementById('searchLinksActivity').value;	

	}

	else if(documentType=='notes')

	{

		searchLinks=	document.getElementById('searchLinksNotes').value;	

	}

	else if(documentType=='contact')

	{

		searchLinks=	document.getElementById('searchLinksContact').value;	

	}

	else if(documentType=='import')

	{

		searchLinks=	document.getElementById('searchLinksImport').value;	

	}

	else if(documentType=='importFolder')
	{

		searchLinks = document.getElementById('importFolderSearchField').value;	

	}

	

	

	data='documentType='+documentType+'&searchLinks='+searchLinks;

	

	

	//document.getElementById(linkIframeId).style.display = "block";

	

	httpDoc.open("POST", urlm, true); 

	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

						

							if(documentType=='docs')

							{

								document.getElementById('showLinksDoc').innerHTML=httpDoc.responseText;

							}

							else if(documentType=='chat')

							{ 

							   document.getElementById('showLinksChat').innerHTML=httpDoc.responseText;

								

							}

							else if(documentType=='activity')

							{ 

							   document.getElementById('showLinksActivity').innerHTML=httpDoc.responseText;

								

							}

							else if(documentType=='notes')

							{ 

							   document.getElementById('showLinksNotes').innerHTML=httpDoc.responseText;

								

							}

							else if(documentType=='contact')

							{ 

							   document.getElementById('showLinksContact').innerHTML=httpDoc.responseText;

								

							}

							else if(documentType=='import')

							{ 

							   document.getElementById('showLinksImport').innerHTML=httpDoc.responseText;

							   /*Added by Dashrath- show selected folder files*/
							   var selectedFolderId = document.getElementById("oldFolderId").value;
							   $('.folId'+selectedFolderId).css('display','inline'); 
							   /*Dashrath - code end*/
								

							}

							else if(documentType=='importFolder')
							{ 
							   document.getElementById('showLinksImportFolder').innerHTML=httpDoc.responseText;
							}

						

						

						}

					  }     

		httpDoc.send(data);



	

	hideall();



	

}



function apply_link(divId,artifactType)

{	
		$('#popCloseBox', window.parent.document).hide();

		var sectionType=document.getElementById('sectionType').value;
		
		if(sectionType != '')
		{
			$(".linkApplyLoader_"+sectionType).html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		}
		else if(sectionType == '')
		{
			$(".linkApplyLoader_import").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		}


		var obj=document.frmTag0;

		

		

		var doclinks1 = [];

		 var importlinks1 = [];

		/*Added by Dashrath- used for folder link*/
		var importFolderlinks1 = [];

		$('[name=doclinks]').each(function()

		{

			if(this.checked)

			{									 

		   		doclinks1.push($(this).val());

			}

			

							

		 });

		

		$('[name=importlinks]').each(function()

		{

			if(this.checked)

			{									 

		   		importlinks1.push($(this).val());

			}

			

							

		 });

		/*Added by Dashrath- used for folder link*/
		$('[name=importFolderlinks]').each(function()
		{
			if(this.checked)
			{									 
		   		importFolderlinks1.push($(this).val());
			}
		});
		/*Dashrath- code end*/

			var nodeId=document.getElementById('nodeId').value;

			var treeId=document.getElementById('mainTreeId').value;

			var linkType=document.getElementById('linkType').value; 

			var linkSpanOrder=document.getElementById('linkSpanOrder').value; 

	        

			var workSpaceId=document.getElementById('workSpaceId').value;

	

		

			var workSpaceType=document.getElementById('workSpaceType').value; 

	  		var latestVersion=document.getElementById('latestVersion').value; 

			var sectionType=document.getElementById('sectionType').value;

			var importSectionLinkIds=document.getElementById('importSectionLinkIds').value; 

			/*Added by Dashrath- used for folder link*/
			var importSectionLinkFolderIds=document.getElementById('importSectionLinkFolderIds').value;
			/*Dashrath- code end*/

			var sectionLinkIds=document.getElementById('sectionLinkIds').value; 

	  		var docSectionLinkIds=document.getElementById('docSectionLinkIds').value; 

	  		var disSectionLinkIds=document.getElementById('disSectionLinkIds').value; 

			var chatSectionLinkIds=document.getElementById('chatSectionLinkIds').value;

			var notesSectionLinkIds=document.getElementById('notesSectionLinkIds').value; 

	  		var activitySectionLinkIds=document.getElementById('activitySectionLinkIds').value; 

			var contactSectionLinkIds=document.getElementById('contactSectionLinkIds').value;
			
			//Manoj: Get selected tree value based on device type for link
			//var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
			var ismobile = (/iphone|ipod|Mobile|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
			var isipad = (/ipad/i.test(navigator.userAgent.toLowerCase()));
			//alert(ismobile+'==='+isipad);

			if(ismobile==true && isipad!=true)
			{
				var val = $('select[name="tree"]').val();
			}
			else
			{
				var val = $('input:radio[name=tree]:checked').val();
			}
			
			//Manoj: code end
			
			if(val==1)

			{

				documentType='docs';

			}

			else if(val==2)

			{

				documentType='';	

			}

			else if(val==3)

			{

				documentType='chat';	

			}

			else if(val==4)

			{

				documentType='activity';	

			}

			else if(val==5)

			{

				documentType='notes';	

			}

			else if(val==6)

			{

				documentType='contact';	

			}

			else if(val==7)

			{

				documentType='import';	

			}	

			else if(val==10)
			{
				documentType='importFolder';	
			}		

		

		var sectionChecked=document.getElementById('sectionChecked').value; 

	  	var appliedDocLinkIds=document.getElementById('appliedDocLinkIds').value; 

		/* 
		var docTreeIds0=document.getElementById('docTreeIds'+linkSpanOrder).value;
		
		var disTreeIds0=document.getElementById('disTreeIds'+linkSpanOrder).value; 
		var chatTreeIds0=document.getElementById('chatTreeIds'+linkSpanOrder).value;
		var activityTreeIds0=document.getElementById('activityTreeIds'+linkSpanOrder).value; 
	  	var notesTreeIds0=document.getElementById('notesTreeIds'+linkSpanOrder).value; 
		var contactTreeIds0=document.getElementById('contactTreeIds'+linkSpanOrder).value;
		var importFileIds0=document.getElementById('importFileIds+'linkSpanOrder).value;
		*/

		

		var urlm=baseUrl+'show_artifact_links/apply';

		

		

		if(getUrlVars()["doc"]){

			var doc=1;

		}

		else{

			var doc=0;

		}

		

		

				 
		/*Changed by Dashrath- Add importFolderlinks and importSectionLinkFolderIds for folder link*/
		data='sectionType='+sectionType+'&doclinks='+doclinks1+'&nodeId='+nodeId+'&linkType='+linkType+'&linkSpanOrder='+linkSpanOrder+'&importlinks='+importlinks1+'&importFolderlinks='+importFolderlinks1+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&latestVersion='+latestVersion+'&sectionType='+sectionType+'&sectionLinkIds='+sectionLinkIds+'&docSectionLinkIds='+docSectionLinkIds+'&disSectionLinkIds='+disSectionLinkIds+'&chatSectionLinkIds='+chatSectionLinkIds+'&notesSectionLinkIds='+notesSectionLinkIds+'&activitySectionLinkIds='+activitySectionLinkIds+'&contactSectionLinkIds='+contactSectionLinkIds+'&sectionChecked='+sectionChecked+'&appliedDocLinkIds='+appliedDocLinkIds+'&importSectionLinkIds='+importSectionLinkIds+'&importSectionLinkFolderIds='+importSectionLinkFolderIds+'&returnUrl='+encodeURIComponent(document.referrer)+'&doc='+doc+'&linkTypeId='+documentType;

		

		

		var xmlHttpRequest = GetXmlHttpObject2();

		

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

											{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				//alert(xmlHttpRequest.responseText);return;

				getSearchedLinksByKeywords(0, nodeId, artifactType, workSpaceId, workSpaceType, linkType,latestVersion,0,documentType);

				// $("#showLinksDoc").scrollTop(0);

				

				$(".clsAllLinks").scrollTop(0);

				 

				var httpDoc2 = GetXmlHttpObject2();

				 

				urlm2=baseUrl+'show_artifact_links/getAppliedLinks/'+nodeId+'/'+artifactType+'/'+workSpaceId+'/'+workSpaceType+'/'+linkType+'/'+linkSpanOrder+'/'+latestVersion;

				

				httpDoc2.open("POST", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{   

						

						//if(httpDoc2.responseText!=0)

						{

						
						setTagAndLinkCount(nodeId,artifactType);

						setTagsAndLinksInTitle(nodeId,artifactType);						

						document.getElementById("divAppliedLinks").innerHTML=httpDoc2.responseText;
						
						if(sectionType != '')
						{
							$(".linkApplyLoader_"+sectionType).html("");
						}
						else if(sectionType == '')
						{
							$(".linkApplyLoader_import").html("");
						}
						
						$('#popCloseBox', window.parent.document).show();

						//document.getElementById("spanLinkMessage").innerHTML="Links applied sucessfully.";

						

						}
						
						//Alert message Code start
						var currentTreeId = $('#currentTreeId').val();
						//var nodeId = $('#nodeId').val();
						var leafId = $('#leafId').val();
						var leafOrder = $('#leafOrder').val();
						var parentLeafId = $('#parentLeafId').val();
						var treeLeafStatus = $('#treeLeafStatus').val();
						var treeType = $('#treeType').val();
						//var artifactType = $('#artifactType').val();
						var successorLeafStatus = $('#successorLeafStatus').val();
						if(treeType==1 && artifactType==2)
						{	
							//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
							getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
						}
						if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
						{
							getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
						}
						//Code end

						//setTagAndLinkCount(nodeId,artifactType);

						//setTagsAndLinksInTitle(nodeId,artifactType);

					}

				}

				httpDoc2.send(); 

				

			}

		}     

		xmlHttpRequest.send(data);

	

	}

	

	function responseTag()

	{

		//alert ('Here'); return false;

	  	//var taggedUsers=document.getElementById('taggedUsers').value; 

	  	var workSpaceId=document.getElementById('workSpaceId').value; 

	  	var workSpaceType=document.getElementById('workSpaceType').value; 

	  	var artifactId=document.getElementById('artifactId').value; 

		var artifactType=document.getElementById('artifactType').value;

		var confirm1=document.getElementById('confirm').value; 

	  	var tagId=document.getElementById('tagId').value; 

		var responseOption=document.getElementById('responseOption').value;

		var tagCategory=document.getElementById('tagCategory').value;

		var url='';

		

		if(tagCategory==1)

		{

				var tagComments=document.getElementById('tagComments').value; 

				url='&tagComments='+encodeURIComponent(tagComments);

		}

		else if(tagCategory==2  || tagCategory==3 || tagCategory==4 )

		{

				

				for (i = 0; i < document.frmTagResponse.tagResponse.length; i++) {

				if (document.frmTagResponse.tagResponse[i].checked) {

				

				var tagResponse=document.frmTagResponse.tagResponse[i].value; 

				}

				}

          

			

			url='&tagResponse='+tagResponse;

			

			if(tagCategory==4)

			{

				var tagComments=document.getElementById('tagComments').value; 

				url+='&tagComments='+encodeURIComponent(tagComments);

			}

		}

		

			  

		urlm=baseUrl+'tag_response';

		

		data='artifactId='+artifactId+'&artifactType='+artifactType+'&confirm='+confirm1+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagId='+tagId+'&responseOption='+responseOption+'&tagCategory='+tagCategory+url;

	//data='&artifactId='+artifactId+'&artifactType='+artifactType+'&confirm='+confirm1+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&tagId='+tagId+'&responseOption='+responseOption+'&tagCategory='+tagCategory+url;

		

		var xmlHttpRequest = GetXmlHttpObject2();

		

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

		{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				// alert(xmlHttpRequest.responseText);

				 document.getElementById("actionTagResponse").innerHTML=xmlHttpRequest.responseText;

				 

				 



			}

		}     

		xmlHttpRequest.send(data);

		

		}





function showTagsAjax(update)

{  

   var toMatch='';

   

	toMatch = document.getElementById('searchTags').value;



	var val = '';

  

	urlm=baseUrl+'tag_response/searchSimpleTags';

	

	if(typeof(update)!=='undefined'){

   		urlm = urlm+"/1";

    }

   

	

	data='toMatch='+toMatch;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

		if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

		{

			 var response1 = xmlHttpRequest.responseText;

			 //alert(response1);

			 if(!update){

				 if(response1.length!=0){

					 

					 sought1 = response1.split(",");

					 

					 if(sought1.length!=0){

						 //$("input[type=checkbox]").css({visibility:"hidden",position:"absolute"});//hide();//.css({visibility:"hidden",position:"absolute",top:""});

						 //$("input[type=checkbox]").next().css({visibility:"hidden",position:"absolute"});//.hide();//.css({visibility:"hidden",position:"absolute",top:""});
						 
						 $(".simpleTagCheckbox").css({visibility:"hidden",position:"absolute"});//hide();//.css({visibility:"hidden",position:"absolute",top:""});

						 $(".simpleTagCheckbox").next().css({visibility:"hidden",position:"absolute"});//.hide();//.css({visibility:"hidden",position:"absolute",top:""});

					 }

					 if(sought1.length >= 1){

						 for(i=0;i < sought1.length;i++){

							 $("input[value=" + sought1[i] +"]").css({visibility:"visible",position:""});

							 $("input[value=" + sought1[i] +"]").next().css({visibility:"visible",position:""});

						 }

					 }

				 }

				 else{

					/*$("input[value=" + sought1 +"]").css({"visibility":"visible","position":""});
					$("input[value=" + sought1 +"]").next().css({"visibility":"visible","position":""});*/

					$("input[type=checkbox]").css({visibility:"visible",position:""});

					$("input[type=checkbox]").next().css({visibility:"visible",position:""});

				 }

				 

			 }

			 else{

				document.getElementById("showTagsSimple").innerHTML=xmlHttpRequest.responseText;

				document.getElementById('searchTags').value="";

			 }

		 

		}

	}

	

	xmlHttpRequest.send(data);

		

}

	

function search_contact_tags()

{  

 

	var toMatch = document.getElementById('searchTags').value;

	

	var val = '';

  

	urlm=baseUrl+'tag_response/search_contact_tags/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				

				 document.getElementById("showTags").innerHTML=xmlHttpRequest.responseText;

				 

			}

	}     

	xmlHttpRequest.send(data);

		

}



function search_contact_tags_contact()

{  

 

	var toMatch = document.getElementById('searchTagsContact').value;

	

	var val = '';

  

	urlm=baseUrl+'tag_response/search_contact_tags/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

		if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

		{

			 document.getElementById("divshowTagsContact").innerHTML=xmlHttpRequest.responseText;

		}

	}     

	xmlHttpRequest.send(data);

		

}







function showFilteredMembers1(tagId,treeId,pnodeId)

{

	var artifactId = $('#artifactId').val();
	var artifactType = $('#artifactType').val();
	
	var toMatch = document.getElementById('showMembers1').value;

	

	var val = '';

  

	urlm=baseUrl+'tag_response/search_members/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch+'&tagId='+tagId+'&treeId='+treeId+'&artifactId='+artifactId+'&artifactType='+artifactType+'&pnodeId='+pnodeId;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				

				 document.getElementById("showMem31").innerHTML=xmlHttpRequest.responseText;
				 
				 var list = $("#list").val();
				 
				 var val1 = list.split(",");
	
				 $(".users").each(function(){
	
				 if(val1.indexOf($(this).val())!=-1){
	
					$(this).attr("checked",true);
	
				 }
	
				});

				 

			}

	}     

	xmlHttpRequest.send(data);

	

	

	}

	

	function show_action_Tags(artifactId,artifactType,sequenceTagId)

	{

		

	var toMatch = document.getElementById('searchTagsAction').value;

	

	var val = '';

  

	urlm=baseUrl+'tag_response/show_action_Tags/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch+'&artifactId='+artifactId+'&artifactType='+artifactType+'&sequenceTagId='+sequenceTagId;

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

		    

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				

			document.getElementById("showTagsAction").innerHTML=xmlHttpRequest.responseText;

				 

			}

	}     

	xmlHttpRequest.send(data);

		

		

		

		}

//function set count of tags and links on parent page.

function setTagAndLinkCount(artifactId,artifactType)

{

	

	blockId=0;

	if(artifactType==2)

	{

		  	blockId=artifactId;

						

	}

		

	var httpDoc = getHTTPObjectm();

	

	urlm=baseUrl+'create_tag1/countTagsAndLinks/'+artifactId+'/'+ artifactType;

	  

	httpDoc.open("POST", urlm, true); 

	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	httpDoc.onreadystatechange = function()

	{ 

	   if (httpDoc.readyState==4 && httpDoc.status==200)

	   {

			var temp=httpDoc.responseText.split('|||@||'); 

			if(temp[0]==0)

			{

				temp[0]='';

			}

			if(temp[1]==0)

			{

				temp[1]='';

			}	

			

			$("#liTag"+blockId,parent.document).html(temp[0]);

			$("#liLink"+blockId,parent.document).html(temp[1]);

			

	   }

	}     

	httpDoc.send();

}



//function set count of tags and links on parent page.

function setTagsAndLinksInTitle(artifactId,artifactType)

{

	 

	blockId=0;

	if(artifactType==2)

	{

		  	blockId=artifactId;

						

	}

		

	var httpDoc = getHTTPObjectm();

	

	urlm=baseUrl+'create_tag1/setTagsAndLinksInTitle/'+artifactId+'/'+ artifactType;

	  

	httpDoc.open("POST", urlm, true); 

	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	httpDoc.onreadystatechange = function()

	{ 

	   if (httpDoc.readyState==4 && httpDoc.status==200)

	   {

		  

			var temp=httpDoc.responseText.split('|||@||'); 

			$("#liTag"+blockId,parent.document).attr("title",temp[0]);

			$("#liLink"+blockId,parent.document).attr("title",temp[1]);

	   }

	}     

	httpDoc.send();



	

}





function getTagView(tagOption)

{ 
	
	if(tagOption==2)

	{ 

		document.getElementById("divAllTags").style.display='none';

		document.getElementById("divActionView").style.display='none';

		document.getElementById("divContactView").style.display='none';

		document.getElementById("divSimpleView").style.display='block';

		}

	else if(tagOption==3)

	{

		document.getElementById("divAllTags").style.display='none';

		document.getElementById("divSimpleView").style.display='none';

		document.getElementById("divContactView").style.display='none';

		document.getElementById("divActionView").style.display='block';

		//Manoj: showing mobile datepicker when add action tag 
		$("#dtBox_tag").DateTimePicker();


		}

	else if(tagOption==5)

	{  

		document.getElementById("divAllTags").style.display='none';

		document.getElementById("divSimpleView").style.display='none';

		document.getElementById("divContactView").style.display='block';

		document.getElementById("divActionView").style.display='none';

		}

	

	}





function showHideTagsView(option)

{

	if(option=='add')

	{
		
		$('#groupTags').val('2').trigger('change');
		
		$('#2').attr('checked','checked');
		
		$('#3').attr('checked',false);
		
		$('#5').attr('checked',false);
		
		
		

		document.getElementById("divAllTags").style.display='none';

		document.getElementById("tagsNavigation").style.display='block';

		document.getElementById("allTagViews").style.display='block';

		document.getElementById("divSimpleView").style.display='block';

		document.getElementById("divActionView").style.display='none';

		document.getElementById("divContactView").style.display='none';

		//document.getElementById('2').checked = true;

		document.getElementById("tabTagsList").setAttribute("class", "tabs_tags");

		document.getElementById("tabTagsSet").setAttribute("class", "tabs_tags_select");

		

		

		

	}

	else

	{

		document.getElementById("divAllTags").style.display='block';

		document.getElementById("tagsNavigation").style.display='none';

		document.getElementById("allTagViews").style.display='none';

		document.getElementById("tabTagsSet").setAttribute("class", "tabs_tags");

		document.getElementById("tabTagsList").setAttribute("class", "tabs_tags_select");

		}

	

	}

	

	function showHideLinksView(option)

	{

		

		if(option=='add')

		{

			

		document.getElementById("divAppliedLinks").style.display='none';	

		document.getElementById("linksContainer").style.display='block';

		document.getElementById("tabLinksList").setAttribute("class", "tabs_tags");

		document.getElementById("tabLinksSet").setAttribute("class", "tabs_tags_select");

		

		

		

		

		}

		else

		{

			

		document.getElementById("linksContainer").style.display='none';	

		document.getElementById("divAppliedLinks").style.display='block';	

		document.getElementById("tabLinksSet").setAttribute("class", "tabs_tags");

		document.getElementById("tabLinksList").setAttribute("class", "tabs_tags_select");

		

		}

		

	}

	

	function getUrlVars() {

		var vars = {};

		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {

			vars[key] = value;

		});

		return vars;

	}

//Set talk count
function setTalkCount(leafTreeId)
{
		
	var httpDoc = getHTTPObjectm();
	
	urlm=baseUrl+'view_talk_tree/setTalkCount/'+leafTreeId;
	
	httpDoc.open("POST", urlm, true); 
	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpDoc.onreadystatechange = function()
	{ 
	   if (httpDoc.readyState==4 && httpDoc.status==200)
	   {
	   		var result = '';
			result = httpDoc.responseText;	   
	   		if(result==0)
			{
				result='';
			}
	   
	   		//document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
			document.getElementById("liTalk"+leafTreeId).innerHTML=result;
			//window.opener.document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
	   }
	}     
	httpDoc.send();

	
}
//get tag color
function getSimpleColorTag(artifactId,artifactType)
{
	$.ajax({
	
				  url: baseUrl+'comman/getSimpleTagClass/'+artifactId+'/'+artifactType,
	
				  type: "POST",
				  
				  async: false, 
	
				  success:function(result)
				  {
					if(result!='')
					{
						if(artifactType==1)
						{
							$("#treeContent",parent.document).removeClass();
							$("#treeContent",parent.document).addClass(result+'_systemTag');
						}
						else
						{
							$('#leaf_contents'+artifactId,parent.document).removeAttr('class');
							$('#leaf_contents'+artifactId,parent.document).addClass("contentContainer "+result+"_systemTag");
							//For subtask
							var subtaskdivid = $('.leaf_contents'+artifactId,parent.document).attr("id");
							$('#'+subtaskdivid,parent.document).removeAttr('class');
							$('#'+subtaskdivid,parent.document).addClass("handCursor "+result+"_systemTag leaf_contents"+artifactId);
						}
						
					}
					else
					{
						if(artifactType==1)
						{
							$("#treeContent",parent.document).removeClass();		
						}
						else
						{
							$('#leaf_contents'+artifactId,parent.document).removeAttr('class');
							$('#leaf_contents'+artifactId,parent.document).addClass("contentContainer");
							//For subtask
							var subtaskdivid = $('.leaf_contents'+artifactId,parent.document).attr("id");
							$('#'+subtaskdivid,parent.document).removeAttr('class');
							$('#'+subtaskdivid,parent.document).addClass("handCursor leaf_contents"+artifactId);
						}
					}
				  }
	});
}

//Set talk count
function setTalkCountFromTagLink(leafTreeId)
{
		
	var httpDoc = getHTTPObjectm();
	
	urlm=baseUrl+'view_talk_tree/setTalkCount/'+leafTreeId;
	
	httpDoc.open("POST", urlm, true); 
	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpDoc.onreadystatechange = function()
	{ 
	   if (httpDoc.readyState==4 && httpDoc.status==200)
	   {
	   		var result = '';
			result = httpDoc.responseText;	   
	   		if(result==0)
			{
				result='';
			}
	   
	   		//document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
			$("#liTalk"+leafTreeId,parent.document).html(result);
			//window.opener.document.getElementById("liTalk"+leafTreeId).innerHTML=httpDoc.responseText;
	   }
	}     
	httpDoc.send();

	
}
//Update content ajaxify

function getUpdatedContents(artifactId,artifactType)
{	
	$.ajax({
	
				  url: baseUrl+'comman/getUpdatedLeafContents/'+artifactId+'/'+artifactType,
	
				  type: "POST",
				  
				  async: true, 
	
				  success:function(result)
				  {
				  	 if(result!='')
					 {
					 	//alert(result+'=='+artifactId);
					 	$('#leaf_contents'+artifactId).html(result);
						$('.leaf_contents'+artifactId,parent.document).html(result);
					 	//$(".closeLoader").html('');
					 }
				  }
	});
}

function getParentUpdatedContents(artifactId,artifactType)
{
	$.ajax({
	
				  url: baseUrl+'comman/getUpdatedLeafContents/'+artifactId+'/'+artifactType,
	
				  type: "POST",
				  
				  async: false, 
	
				  success:function(result)
				  {
				  	 if(result!='')
					 {
					 	//alert(result+'=='+artifactId);
					 	$('#leaf_contents'+artifactId,parent.document).html(result);
						$('.leaf_contents'+artifactId,parent.document).html(result);
					 	//$(".closeLoader").html('');
					 }
				  }
	});
}

//Set talk title
function setLastTalk(leafTreeId)
{
	$.ajax({
	
				  url: baseUrl+'view_talk_tree/setLastTalk/'+leafTreeId,
	
				  type: "POST",
				  
				  success:function(result)
				  {
				  	 
					 $("#liTalk"+leafTreeId,parent.document).attr("title",result);
					 
				  }
	});
}
//Tree seed content ajaxify
function getParentUpdatedSeedContents(treeId,artifactType)
{
	$.ajax({
	
				  url: baseUrl+'comman/getUpdatedTreeSeedContents/'+treeId+'/'+artifactType,
	
				  type: "POST",
				  
				  async: false, 
	
				  success:function(result)
				  {
				  	 if(result!='')
					 {
					 	//alert(result+'=='+treeId+'=='+artifactType);
					 	$('#treeContent',parent.document).html(result);
						//$(".closeLoader").html('');
					 }
				  }
	});
}