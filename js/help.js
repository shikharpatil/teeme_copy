//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.
 /***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: help.js
* Description 		  	: This is a js file having lot of js functions to handle the teeme help syatem.
* Global Variables	  	: baseUrl
* 
* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 22-May-2009				Nagalingam						Created the file.
*
**********************************************************************************************************/
//this functrion used to open the user registration form according to community name
var spanSubTopic = '';
function showSubTopics(topicId)
{		
	spanSubTopic = 'subTopic'+topicId;
	
	if(document.getElementById(spanSubTopic).style.display == 'none')
	{		
		document.getElementById(spanSubTopic).style.display = '';
		var url = baseUrl+'help/sub_topic/'+topicId;		  
		createXMLHttpRequest();
		queryString =   url; 	
		xmlHttp.onreadystatechange = responseHelp;		
		xmlHttp.open("GET", queryString, true);
		xmlHttp.send(null);
	}	
	else
	{
		document.getElementById(spanSubTopic).innerHTML = '';
		document.getElementById(spanSubTopic).style.display = 'none';
	}	
}

// this is a js function used to get the user community name throught AJAX
function responseHelp() 
{	
	
	if(xmlHttp.readyState == 4) 
	{		
		if(xmlHttp.status == 200) 
		{			
			document.getElementById(spanSubTopic).innerHTML		= xmlHttp.responseText;									
		}
	}
}

function showTopicContents(subTopicId)
{		
	
	var url = baseUrl+'help/sub_topic_contents/'+subTopicId;		  
	createXMLHttpRequest();
	queryString =   url; 	
	xmlHttp.onreadystatechange = responseHelpContents;		
	xmlHttp.open("GET", queryString, true);
	xmlHttp.send(null);		
}

// this is a js function used to get the user community name throught AJAX
function responseHelpContents() 
{	
	if(xmlHttp.readyState == 4) 
	{		
		if(xmlHttp.status == 200) 
		{			
			document.getElementById('helpContents').innerHTML		= xmlHttp.responseText;									
		}
	}
}

