//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.
 /***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: ajax.js
* Description 		  	: This is a js file having lot of js functions to handle the ajax functionalities.
* Global Variables	  	: divId
* 
* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 02-August-2008				Nagalingam						Created the file.
*
**********************************************************************************************************/
var xmlHttpTimeZone = '';
function createXMLHttpRequestTimeZone() 
{
	if (window.ActiveXObject) 
	{
		xmlHttpTimeZone = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	else if (window.XMLHttpRequest) {
		xmlHttpTimeZone = new XMLHttpRequest();
	}
	
}
function responseTime()
{
	alert ('state= ' + xmlHttpTimeZone.readyState);
	if(xmlHttpTimeZone.readyState == 4) 
	{			
		if(xmlHttpTimeZone.status == 200) 
		{
			alert (xmlHttpTimeZone.responseText);	
		}
	}	
}
function updateTimeZone()
{	
	var now = new Date();
	var offset = (now.getTimezoneOffset() / 60)*-1;
	var url = baseUrl+'index.php/update_time_zone';		
	var queryString = url+ '/index/'+offset;	
	
	createXMLHttpRequestTimeZone();
	//alert ('xmlObject= ' + xmlHttp);
	//alert ('qry= ' + queryString);
	xmlHttpTimeZone.onreadystatechange = responseTime;		
	xmlHttpTimeZone.open("GET", queryString, true);
	xmlHttpTimeZone.send(null);	
}

updateTimeZone ();