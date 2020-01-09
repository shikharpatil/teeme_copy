//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.

 /***********************************************************************************************************

*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

************************************************************************************************************

* Filename				: chat.js

* Description 		  	: This is a js file having lot of js functions to handle the chat module functionalities.

* Global Variables	  	: 

* 

* Modification Log

* 	Date                	 Author                       		Description

* ---------------------------------------------------------------------------------------------------------

* 10-Sep-2008				Vinaykant Sahu						Created the file.

*

**********************************************************************************************************/

	function viewChat(curId, leafId, getDivId) 

	{ 

		var obj = document.getElementById(curId);		

		obj.style.backgroundColor = '#6666FF';	



		var leafDivId = 'leafa'+leafId;

		var obj1 = document.getElementById(leafDivId);	

		obj1.style.backgroundColor = '#6699FF';			



		var chatDivId = 'discussa'+leafId;

		var obj2 = document.getElementById(chatDivId);	

		obj2.style.backgroundColor = '#6699FF';			

			

		document.getElementById(getDivId).innerHTML = 'Loading...';		

		var url = 'view_chat.php';	  

		createXMLHttpRequest();

		queryString =   url; 	

		queryString = queryString + "?leafId="+leafId;

		xmlHttp.onreadystatechange = handleStateChange;

		divId = getDivId;

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}

	

	function treeOperationsChat(object,operation,treeId)

	{

		/*if(!(operation =='stop_real_talk' || operation =='start_real_talk') )  

		{

			document.getElementById('aMove').className='';

		}*/

		object.className="hiLite";

	    if(operation=='move')

	  	{

		  	document.getElementById('ulTreeOption').style.display='none';

		 	//document.getElementById('spanMoveTree').style.display='block';
			
			showPopWin(baseUrl+'comman/getMoveSpaceLists/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,450, 350, null, '');

		}

		 

		else if(operation=='stop' || operation=='stop_real_talk')

		{

			window.location=baseUrl+'chat/updateChat/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/0';

		}

			

			

		else if(operation=='start' || operation=='start_real_talk')

		{

			window.location=baseUrl+'chat/updateChat/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/1';

		}

		 

		else

		{

			  document.getElementById('divAutoNumbering').style.display='none';

			  document.getElementById('spanMoveTree').style.display='none';	

		 	  //return false;

		}

	}

		

		function showCommentButton(nodeId)

		{

			if(document.getElementById('divCommentButton'+nodeId).style.display=='none')

			{

				document.getElementById('divCommentButton'+nodeId).style.display='block';	

			}

			else

			{

					document.getElementById('divCommentButton'+nodeId).style.display='none';	

				}

		}

	

		function mouseOverCommentButton(nodeId)

		{

			document.getElementById('divCommentButton'+nodeId).style.display='block';

			}

			

		function mouseOutCommentButton(nodeId)

		{

			document.getElementById('divCommentButton'+nodeId).style.display='none';

			}

			

		

