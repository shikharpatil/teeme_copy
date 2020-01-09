//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.
 /***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: discussion.js
* Description 		  	: This is a js file having lot of js functions to handle the discussion module functionalities.
* Global Variables	  	: 
* 
* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 18-Aug-2008				Vinaykant Sahu						Created the file.
*
**********************************************************************************************************/
	function editDiscussion(leafId, getDivId, treeId, expandDivId, count1) 
	{ 		 
		document.getElementById(getDivId).innerHTML = 'Loading...';		
		var url = 'edit_discussion.php';	  
		createXMLHttpRequest();
		queryString =   url; 	
		queryString = queryString + "?leafId="+leafId+"&treeId="+treeId+"&divId="+getDivId+"&expandId="+expandDivId+"&count="+count1;
		xmlHttp.onreadystatechange = handleStateChange;
		divId = getDivId;
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);
	}
	function viewDiscussion(curId, leafId, getDivId) 
	{ 
		var obj = document.getElementById(curId);		
		obj.style.backgroundColor = '#6666FF';	

		var leafDivId = 'leafa'+leafId;
		var obj1 = document.getElementById(leafDivId);	
		obj1.style.backgroundColor = '#6699FF';			

		var chatDivId = 'chata'+leafId;
		var obj2 = document.getElementById(chatDivId);	
		obj2.style.backgroundColor = '#6699FF';	 
		return false;
		/*document.getElementById(getDivId).innerHTML = 'Loading...';		
		var url = 'view_discussion.php';	  
		createXMLHttpRequest();
		queryString =   url; 	
		queryString = queryString + "?leafId="+leafId;
		xmlHttp.onreadystatechange = handleStateChange;
		divId = getDivId;
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);*/
	}
	function showDiscussionContents(getDivId, leafId, expandDivId, count1) 
	{ 
		if(count1 == 3)
		{
			document.getElementById(getDivId).innerHTML = 'This is a first 3rd discussion which we have added to test the prototype functionalities.\n The UI should be ale to show the tree structure as well as provide in-line UI elements to interact with the contents. Thus using a single window user should be able to navigate and interact with the Document, Discussion and Chat objects.  The overall structure of the tree should always be visible so that user knows where exactly the current information is in relation to overall tree ';
		}
		if(count1 == 2)
		{
			document.getElementById(getDivId).innerHTML = 'This is a first 2nd discussion which we have added to test the prototype functionalities.\n For testing some more contents.The UI should be ale to show the tree structure as well as provide in-line UI elements to interact with the contents. Thus using a single window user should be able to navigate and interact with the Document, Discussion and Chat objects.  The overall structure of the tree should always be visible so that user knows where exactly the current information is in relation to overall tree';
		}
/*		if(expandDivId.substring(0,3) != 'not')
		{
			document.getElementById(expandDivId).innerHTML = '<a href="javascript:void(0)" onClick="hideDiscussionContents(\''+getDivId+'\',\''+leafId+'\',\''+expandDivId+'\',\''+count1+'\')" style="text-decoration:none"><img src="images/up.jpg" border="0"></a>';		
		}*/
		
	}

	
	function hideDiscussionContents(getDivId, leafId, expandDivId, count1) 
	{ 
		if(count1 == 3)
		{
			document.getElementById(getDivId).innerHTML = 'This is a first 3rd discussion which we have added to test the prototype functionalities...';
		}
		if(count1 == 2)
		{
			document.getElementById(getDivId).innerHTML = 'This is a first 2nd discussion which we have added to test the prototype functionalities...';
		}
		if(count1 == 1)
		{
			document.getElementById(getDivId).innerHTML = 'This is a first test discussion which we have added to test the prototype functionalities';
		}
		
		
		if(expandDivId.substring(0,3) != 'not')
		{
			document.getElementById(expandDivId).innerHTML = '<a href="javascript:void(0)" onClick="showDiscussionContents(\''+getDivId+'\',\''+leafId+'\',\''+expandDivId+'\',\''+count1+'\')" style="text-decoration:none"><img src="images/down.jpg" border="0"></a>';		
		}		
	}

	

	function viewFullDiscussionDetails(getDivId, treeId, option) 
	{ 
		document.getElementById(getDivId).innerHTML = 'loading...';		
		var url = 'reload_document.php';	  
		createXMLHttpRequest();
		queryString =   url; 		
		queryString = queryString + "&treeId="+treeId+"&viewOption="+option;
		xmlHttp.onreadystatechange = handleStateChange;
		divId = getDivId;
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);
	}