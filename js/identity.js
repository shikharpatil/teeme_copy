//Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.

 /***********************************************************************************************************

*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

************************************************************************************************************

* Filename				: identity.js

* Description 		  	: This is a js file having lot of js functions to handle the teeme identity management.

* Global Variables	  	: baseUrl

* 

* Modification Log

* 	Date                	 Author                       		Description

* ---------------------------------------------------------------------------------------------------------

* 07-Oct-2008				Nagalingam						Created the file.

*

**********************************************************************************************************/

//this functrion used to open the user registration form according to community name

var spanCommunityName = '';

var spanId = '';

var spanArtifactLinks = '';

var linkUpdateStatus = '';

var nodeOptionsVisible= -1;

var clickEvent=-1;

var test=-1;



var istablet = (/ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));



if(istablet==true)

{

   document.cookie = "istablet=1;path='/'";

}

else

{

   document.cookie="istablet=0;path='/'";

}





function validateEmail(email)

{

	if(email!="")

	{	

		var matcharray = email.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/) 

		if(matcharray == null)

		{	

			return false;

		}

		else 

		{

			return true;

		}

	}

	return true;		

}

function openRegisterForm(thisVal)

{	

	var communityArray = new Array();	

	if(thisVal.value == 1)

	{

		document.getElementById('otherUserName').value = '';

		document.getElementById('teemeCommunity').style.display = '';

		document.getElementById('otherCommunity').style.display = 'none';

	}

	else if(thisVal.value == '')

	{

		document.getElementById('teemeCommunity').style.display = 'none';

		document.getElementById('otherCommunity').style.display = 'none';			

	}

	else

	{		

		document.getElementById('userName').value = '';

		document.getElementById('teemeCommunity').style.display = 'none';

		document.getElementById('otherCommunity').style.display = '';

		var url = baseUrl+'get_community_name';		  

		createXMLHttpRequest();

		queryString =   url; 

		queryString = queryString + '/index/communityId/'+thisVal.value;

		xmlHttp.onreadystatechange = responseCommunityName;		

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);					

	}	

}





function openRegisterForm2(thisVal)

{	

	

	var communityArray = new Array();	

	if(thisVal.value == 1)

	{

		document.getElementById('pass1').style.display = '';

		document.getElementById('pass2').style.display = '';

	}

	else

	{		

		document.getElementById('pass1').style.display = 'none';

		document.getElementById('pass2').style.display = 'none';				

	}	

}

// this is a js function used to get the user community name throught AJAX

function responseCommunityName() 

{

	

	if(xmlHttp.readyState == 4) 

	{		

		if(xmlHttp.status == 200) 

		{			

			document.getElementById('otherCommunityName').innerHTML		= xmlHttp.responseText;

			//document.getElementById('otherCommunityName1').innerHTML	= xmlHttp.responseText;								

		}

	}

}



//this function used to check whether user name is available

function checkUserName(thisVal, workPlaceId)
{
	if(trim(thisVal.value) != '')
	{
		//var communityId	= document.getElementById('communityId').value;		
		var communityId = 1;

		if(trim(thisVal.value) != '' && communityId != '')

		{

			var tempUserName = thisVal.value.split('@');

			var userName = tempUserName[0];

			var domain = tempUserName[1];

			var url = baseUrl+'check_user_name';		

			createXMLHttpRequest();

			if(communityId == 1)

			{

				spanId = 'userNameStatusText';

			}

			else

			{

				spanId = 'userNameStatus1';

			}		

			queryString =   url; 

			queryString = queryString + '/index/'+userName+'/'+domain+'/communityId/'+communityId+'/workPlaceId/'+workPlaceId;

			xmlHttp.onreadystatechange = responseUserStatus;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

	}	

	else

	{

		document.getElementById(spanId).innerHTML	= '';

	}					

}



// this is a js function used to get the user community name throught AJAX

function responseUserStatus() 

{	

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{					

			if(xmlHttp.responseText	== 0)

			{

				document.getElementById(spanId).style.color = 'red';		

				document.getElementById(spanId).innerHTML	= 'Email already exist';

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;

			}

			else	

			{

				//alert('inside');	

				document.getElementById(spanId).style.color = 'green';

				document.getElementById(spanId).innerHTML	= 'Email available';	

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;	

			}								

		}

	}

}







//this function used to check whether user name is available

function checkTagName(thisVal, workPlaceId, placeManager)
{
	spanId = 'tagNameStatusText';
	
		if (typeof(placeManager)==='undefined') 
		{
			placeManager = 0;
		}
		else
		{
			placeManager = 1;
		}

		if(trim(thisVal.value) != '')
	
		{
	
				var tagName = thisVal.value;
	
				var url = baseUrl+'check_tag_name';		
	
				createXMLHttpRequest();
	
				queryString =   url; 
	
				queryString = queryString + '/index/'+tagName+'/'+workPlaceId+'/'+placeManager;
	
				xmlHttp.onreadystatechange = responseTagNameStatus;		
	
				xmlHttp.open("GET", queryString, true);
	
				xmlHttp.send(null);
	
		}	
	
		else
	
		{
	
			document.getElementById(spanId).innerHTML	= '';
	
		}					

}





function checkTagName2(thisVal, workPlaceId)

{

	spanId = 'tagNameStatusText';

	

	if(thisVal != '')

	{

			var tagName = thisVal;

			var url = baseUrl+'check_tag_name';		

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString + '/index/'+tagName+'/'+workPlaceId;

			xmlHttp.onreadystatechange = responseTagNameStatus2;		

			xmlHttp.open("GET", queryString, false);

			xmlHttp.send(null);

	}	

	else

	{

		document.getElementById(spanId).innerHTML	= '';

	}					

}



// this is a js function used to get the user community name throught AJAX

function responseTagNameStatus() 
{	
	//alert (xmlHttp.responseText	);
	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{					

			if(xmlHttp.responseText	== 0)

			{

				document.getElementById(spanId).style.color = 'red';		

				document.getElementById(spanId).innerHTML	= 'Tag Name already exist';

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;

			}

			else	

			{

				document.getElementById(spanId).style.color = 'green';

				document.getElementById(spanId).innerHTML	= 'Tag Name available';	

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;	

			}								

		}

	}

}



function responseTagNameStatus2() 

{	

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{		

			alert ('Response= ' + xmlHttp.responseText);

			return xmlHttp.responseText;						

		}

	}

}





function getTagName(firstName, lastName)

{

	spanId = 'tagNameStatusText';

	

	if(trim(thisVal.value) != '')

	{

			var tagName = thisVal.value;

			var url = baseUrl+'check_tag_name';		

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString + '/index/'+tagName+'/'+workPlaceId;

			xmlHttp.onreadystatechange = responseTagNameStatus;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

	}	

	else

	{

		document.getElementById(spanId).innerHTML	= '';

	}					

}



//this function used to check whether work place name is available

function checkWorkPlace(thisVal)
{	
	var reAlphanumeric = /^[a-z0-9_@.]+$/;

	if(trim(thisVal.value).length < 2){

		document.getElementById('workPlaceStatusText').style.color = 'red';		

		document.getElementById("workPlaceStatusText").innerHTML	= 'Place name is too short.';

		document.getElementById('workPlaceStatus').value = 0;	

	}
	else if(reAlphanumeric.test(thisVal.value)==false)
	{
		document.getElementById('workPlaceStatusText').style.color = 'red';		

		document.getElementById("workPlaceStatusText").innerHTML	= 'Lower case letters and numbers only';

		document.getElementById('workPlaceStatus').value = 0;	
			
	}
	else if(trim(thisVal.value) != '')

	{		

		var url = baseUrl+'check_work_place';		

		createXMLHttpRequest();		

		queryString =   url; 

		spanId = 'workPlaceStatusText';

		queryString = queryString + '/index/workPlaceName/'+thisVal.value;

		xmlHttp.onreadystatechange = responseWorkPlaceStatus;		

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}	

	else

	{

		document.getElementById(spanId).innerHTML	= '';

	}		

}

//this function used to edit work place 

function validate_Work_Place_Edit (obj)

{



	var timezone = obj.timezone.value;

	//Manoj: assign variable of number of users
	
	var numOfUsers = obj.num_of_users.value;
	
	//var securityAnswer = obj.securityAnswer.value;

	//var securityAnswer = obj.securityAnswer.value;

	//var securityAnswerStored = obj.securityAnswerStored.value;

	//var communityId = obj.communityId.value;

	var reAlphanumeric = /^[a-zA-Z0-9_@.]+$/;

	var err='';





	if(timezone == '0')

	{

		err += 'Please enter the timezone \n';	

	}

	

	//Manoj: Check number Of Users is numeric or not
	if(numOfUsers != '')

	{
		if(numOfUsers=='0')
		{
			err += "Number of users can not be 0<br/>";
		}
		var value = numOfUsers.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		var intRegex = /^\d+$/;
		if(!intRegex.test(value)) {
			err += "Number of users must be numeric<br/>";
		}

	}
	//Manoj: code end


/*	if (securityAnswer == '')

	{

		err += 'Please enter security answer \n';	

	}*/

	

	if (err == '')

	{

		return true;	

	}

	else

	{

		jAlert (err,'Alert');

		return false;	

	}

}



//this function used to check whether work place name is available

function validateWorkPlace(obj)
{
	//var fname = obj.firstName.value;

	//var lname = obj.lastName.value;

	//var email = obj.email.value;

	//var password = obj.password.value;

	//var confirmPassword = obj.confirmPassword.value;
	
	//var communityId = obj.communityId.value;
	
	var companyName = obj.companyName.value;

	var server = obj.server.value;

	var server_username = obj.server_username.value;
	
	var timezone = obj.timezone.value;
	
	//Manoj: assign variable of number of users
	
	var numOfUsers = obj.num_of_users.value;
	
	//var securityAnswer = obj.securityAnswer.value;


	var reAlphanumeric = /^[a-z0-9_@.]+$/;

	var reAlphanumericName = /^[a-zA-Z_@.]+$/;

	var err='';


	if(companyName.length == 0)

	{

		err = 'Please enter Place Name \n';	

	}	

	else

	{	

		if(reAlphanumeric.test(companyName)==false)

		{

			err += 'Please enter valid Place Name \n';

		}
	}

	if(server == '')

	{

		err += 'Please enter Database Server Host\n';	

	}

	if(server_username == '')

	{

		err += 'Please enter Database Server Username \n';	

	}

	if(timezone == '0')

	{

		err += 'Please enter Timezone \n';	

	}
	//Manoj: Check number Of Users is numeric or not
	if(numOfUsers != '')

	{
		if(numOfUsers=='0')
		{
			err += "Number of users can not be 0<br/>";
		}
		var value = numOfUsers.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		var intRegex = /^\d+$/;
		if(!intRegex.test(value)) {
			err += "Number of users must be numeric<br/>";
		}

	}
	//Manoj: code end


   

/*	
	if (securityAnswer == '')

	{

		err += 'Please enter Security Answer \n';	

	}

	if(fname == '')

	{

		err += 'Please enter the First Name \n';	

	}

	if(fname!="")

	{	

		if(reAlphanumericName.test(fname)==false)

		{

			err += 'Please enter valid First Name \n';

		}

	}

	if(lname == '')

	{

		err += 'Please enter the Last Name \n';	

	}

	if(lname!="")

	{	

		if(reAlphanumericName.test(lname)==false)

		{

			err += 'Please enter valid Last Name \n';

		}

	}



	if (email == '')

	{

			err += 'Please enter email \n';	

	}

	if (email != '')

	{

		if(validateEmail(email)==false)

		{

			err += 'Please enter valid email \n';

		}	

	}



	if (password == '')

	{

		err += 'Please enter the password \n';	

	}

	if (password != confirmPassword)

	{

			err += 'Password and Confirm Password do not match \n'; 	

	}
	*/



	if (err == '')

	{

		return true;	

	}

	else

	{

		jAlert (err,'Alert');

		return false;	

	}

}

function validatePlaceManager (obj)
{
	var fname = obj.firstName.value;

	var lname = obj.lastName.value;
	
	//var tagName = obj.tagName.value;

	var email = obj.email.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;
	
	var nickName = obj.nickName.value;
	
	//var communityId = obj.communityId.value;
	
//	var companyName = obj.companyName.value;

//	var server = obj.server.value;

//	var server_username = obj.server_username.value;

	var timezone = obj.timezone.value;

//	var securityAnswer = obj.securityAnswer.value;


	var reAlphanumeric = /^[a-z0-9_@.]+$/;

	var reAlphanumericName = /^[a-zA-Z_@. ]+$/;

	var err='';


/*	if(companyName.length == 0)

	{

		err = 'Please enter Place Name \n';	

	}	

	else

	{	

		if(reAlphanumeric.test(companyName)==false)

		{

			err += 'Please enter valid Place Name \n';

		}

	}

	if(server == '')

	{

		err += 'Please enter database server host\n';	

	}

	if(server_username == '')

	{

		err += 'Please enter database server username \n';	

	}

	if(timezone == '0')

	{

		err += 'Please enter timezone \n';	

	}
	
	if (securityAnswer == '')

	{

		err += 'Please enter security answer \n';	

	}*/

	if(fname == '')

	{

		err += 'Please enter First Name \n';	

	}

	if(fname!="")

	{	

		if(reAlphanumericName.test(fname)==false)

		{

			err += 'Please enter valid First Name \n';

		}

	}

	if(lname == '')

	{

		err += 'Please enter Last Name \n';	

	}

	if(lname!="")

	{	

		if(reAlphanumericName.test(lname)==false)

		{

			err += 'Please enter valid Last Name \n';

		}

	}
	
	var regNickName = /^[^0-9][a-zA-Z0-9-_]+$/;
	
	if(nickName != '')

	{
		if (nickName.search(regNickName) == -1)
		{
			err += 'Please enter valid nickname \n';	
		}
	}
	
	if(timezone == '0')

	{

		err += 'Please enter timezone \n';	

	}
	
/*	if(tagName == '')

	{

		err += 'Please enter Tag Name \n';	

	}*/

	if (email == '')

	{

			err += 'Please enter Email \n';	

	}

	if (email != '')

	{

		if(validateEmail(email)==false)

		{

			err += 'Please enter valid Email \n';

		}	

	}



	if (password == '')

	{

		err += 'Please enter Password \n';	

	}

	if (password != confirmPassword)

	{

			err += 'Password and Confirm Password do not match \n'; 	

	}
	
	if (err == '')

	{

		return true;	

	}

	else

	{

		jAlert (err,'Alert');

		return false;	

	}	
}





function validateWorkPlaceEdit (obj)

{



	var timezone = obj.timezone.value;

	var fname = obj.firstName.value;

	var lname = obj.lastName.value;

	var email = obj.email.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;

	//var securityAnswer = obj.securityAnswer.value;

	//var securityAnswerStored = obj.securityAnswerStored.value;

	//var communityId = obj.communityId.value;

	var reAlphanumeric = /^[a-zA-Z0-9_@.]+$/;

	var err='';





	if(timezone == '0')

	{

		err += 'Please enter the timezone \n';	

	}

	if(fname == '')

	{

		err += 'Please enter the First Name \n';	

	}

	if(fname!="")

	{	

		if(reAlphanumeric.test(fname)==false)

		{

			err += 'Please enter valid First Name \n';

		}

	}

	if(lname == '')

	{

		err += 'Please enter the Last Name \n';	

	}

	if(lname!="")

	{	

		if(reAlphanumeric.test(lname)==false)

		{

			err += 'Please enter valid Last Name \n';

		}

	}



	if (email == '')

	{

			err += 'Please enter email \n';	

	}

	if (email != '')

	{

		if(validateEmail(email)==false)

		{

			err += 'Please enter valid email \n';

		}	

	}

	if (password != confirmPassword)

	{

			err += 'Password and Confirm Password do not match \n'; 	

	}

/*	if (securityAnswer == '')

	{

		err += 'Please enter security answer \n';	

	}*/

	

	if (err == '')

	{

		return true;	

	}

	else

	{

		jAlert (err,'Alert');

		return false;	

	}

}



//this function used to validate the work place form

/*function validateWorkPlaceEdit(frm)

{	

	obj = document.getElementById;		

	if(obj('communityId').value != 1)

	{

		if(trim(obj('otherUserName').value) == '')

		{		

			alert('Please enter the user name');		

			return false;		

		}

		res = validEmail(obj('otherUserName'),'Please enter the valid email id for user name');

		if(!res)

		{

			return res;

		}

	}

	else

	{		

		var userName = obj('userName');	

		res = fieldBlank(obj('userName'),'Please enter the user Name');

		if(!res)

		{

			return res;

		}		

		if(!validEmail(userName,'Please enter the valid email id for user name'))	

		{

			return false;

		}

		res = fieldBlank(obj('email'),'Please enter the email');

		if(!res)

		{

			return res;

		}	

		res = validEmail(obj('email'),'Please enter the valid email address');

		if(!res)

		{

			return res;

		}

		if(trim(obj('password').value) != '' || trim(obj('confirmPassword').value) != '')

		{			

			res = fieldBlank(obj('password'),'Please enter the password');

			if(!res)

			{

				return res;

			}	

			res = fieldBlank(obj('confirmPassword'),'Please enter the confirm password');

			if(!res)

			{

				return res;

			}	

			if(obj('password').value != obj('confirmPassword').value)

			{

				alert('Password and confirm password are mismatching');		

				return false;	

			}

		}		

	}

	return true;

}*/



//this function used to validate the work place member form

/*function validateWorkPlaceMember(frm)

{	

	obj = document.getElementById;	

	if(obj('communityId').value == 1)

	{		

		if(trim(obj('firstName').value) == '')

		{			

			alert('Please enter the first name');

			obj('firstName').focus();			

			return false;		

		}

		if(trim(obj('lastName').value) == '')

		{		

			alert('Please enter the last name');

			obj('lastName').focus();			

			return false;		

		}

		if(trim(obj('userName').value) == '')

		{		

			alert('Please enter the user name');

			obj('userName').focus();			

			return false;		

		}

		var userName = obj('userName');		

		if(!validEmail(userName,'Please enter the valid email id for user name'))	

		{

			return false;

		}		

		res = fieldBlank(obj('password'),'Please enter the password');

		if(!res)

		{

			return res;

		}	

		res = fieldBlank(obj('confirmPassword'),'Please enter the confirm password');

		if(!res)

		{

			return res;

		}	

		if(obj('password').value != obj('confirmPassword').value)

		{

			alert('Password and confirm password are mismatching');		

			obj('password').select();	

			return false;	

		}

		if(trim(obj('tagName').value) == '')

		{		

			alert('Please enter the user tag name');

			obj('tagName').focus();			

			return false;		

		}

	}

	else

	{

		if(trim(obj('otherUserName').value) == '')

		{		

			alert('Please enter the user name');

			obj('otherUserName').focus();			

			return false;		

		}

		var userName = obj('otherUserName');		

		if(!validEmail(userName,'Please enter the valid email id for user name'))	

		{

			return false;

		}	

		if(trim(obj('tagName1').value) == '')

		{		

			alert('Please enter the user tag name');

			obj('tagName1').focus();			

			return false;		

		}

			

	}

	

	return true;

}*/



function validateWorkPlaceMember(obj)

{

	//alert (obj);



	var fname = obj.firstName.value;

	var lname = obj.lastName.value;

	var email = obj.userName.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;

	// var tagName = obj.tagName.value;

	var status = obj.status.value;

	var otherMember = obj.otherMember.value;

	var address1 = obj.address1.value;

	var timezone = obj.timezone.value;
	
	var nickName = obj.nickName.value;

	//var securityAnswer = obj.securityAnswer.value;

	//var communityId = obj.communityId.value;

	var reAlphanumeric = /^[a-zA-Z0-9_@. ]+$/;

	var reSpecial = /^[a-zA-Z0-9- ,_@. ]+$/;

	var err='';

	emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;


	if (email == '')

	{

			err += 'Please enter Email \n';	

	}

	if (email != '')

	{

		if(emailTest.test(email)==false)

		{

			err += 'Please enter valid Email \n';

		}	

	}



	if (password == '')

	{

		err += 'Please enter the Password \n';	

	}

	else if (confirmPassword!='')

	{

		if(password != confirmPassword){

			err += 'Password and Confirm Password do not match \n'; 	

		}

	}

	else{

		err += 'Please enter Confirm Password \n';	

	}

	

	if(fname == '')

	{

		err += 'Please enter the First Name \n';	

	}



	if(lname == '')

	{

		err += 'Please enter the Last Name \n';	

	}
	
	var regNickName = /^[^0-9][a-zA-Z0-9-_]+$/;
	
	if(nickName != '')

	{
		if (nickName.search(regNickName) == -1)
		{
			err += 'Please enter valid nickname \n';	
		}
	}
	
	if(timezone == '0')

	{

		err += 'Please enter timezone \n';	

	}
	
	

	
/*
	if (tagName == '')

	{

		err += 'Please enter a Tag Name \n';	

	}

	

	if(reSpecial.test(status) == false && status!='')

	{

		err += 'Special characters are not allowed in status. \n';	

	}

	if(reSpecial.test(otherMember) == false && otherMember!=''){

		err += 'Special characters are not allowed in other details. \n';

	}

	if(reSpecial.test(address1) == false && address1!=''){

		err += 'Special characters are not allowed in address. \n';

	}*/

	if (err == '')

	{

		return true;	

	}

	else

	{

		//jAlert (err,'Alert');
		alert(err);
		return false;	

	}

}

//Validation for edit work place member
function validateWorkPlaceMemberEditPlace(obj)

{
	var nickName = obj.nickName.value;

	var timezone = obj.timezone.value;

	var err='';
	
	var regNickName = /^[^0-9][a-zA-Z0-9-_]+$/;
	
	if(nickName != '')

	{
		if (nickName.search(regNickName) == -1)
		{
			err += 'Please enter valid nickname \n';	
		}
	}


	if(timezone == '0')

	{

		err += 'Please enter timezone \n';	

	}

	if (err == '')

	{

		return true;	

	}

	else

	{

		alert(err);
		return false;	

	}

}



function validateWorkPlaceMemberEdit(obj,url,url1)

{
	
	var obj=document.frmWorkPlace;

    var fname = obj.firstName.value;

	var lname = obj.lastName.value;

	var email = obj.userName.value;

	var nickName = obj.nickName.value;

	/*var currPass = obj.currentPassword.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;*/
	
	//var timezone = obj.timezone.value;

	//alert(password+"   "+confirmPassword);return;

	//var userPassword = obj.userPassword.value;

	//var currentPassword = obj.currentPassword.value;

	

	//var securityAnswer = obj.securityAnswer.value;

	//var communityId = obj.communityId.value;

	var reAlphanumeric = /^[a-zA-Z0-9_@.]+$/;

	var err='';



	if(fname == '')

	{

		//err += 'Please enter the First Name \n';	

	}

	if(fname!="")

	{	

		if(reAlphanumeric.test(fname)==false)

		{

			//err += 'Please enter valid First Name \n';

		}

	}

	if(lname == '')

	{

		//err += 'Please enter the Last Name \n';	

	}

	if(lname!="")

	{	

		if(reAlphanumeric.test(lname)==false)

		{

			//err += 'Please enter valid Last Name \n';

		}

	}

	/*if(timezone == '0')

	{

		//err += 'Please enter timezone \n';	

	}*/


	if (email == '')

	{

	    //err += 'Please enter Email \n';	

	}

	if (email != '')

	{

		if(validateEmail(email)==false)

		{

			//err += 'Please enter valid Email \n';

		}	

	}
	
	var regNickName = /^[^0-9][a-zA-Z0-9-_]+$/;
	
	if(nickName != '')

	{
		if (nickName.search(regNickName) == -1)
		{
			err += 'Please enter valid nickname \n';	
		}
	}


	var phoneno = /^(?=.*?[1-9])[0-9()+-]+$/;
	
	var mobile = obj.mobile.value;
	
	if (mobile!='')
	{
		 if(!(mobile.trim().match(phoneno)))  
		 {  
			   err+="Please enter valid phone number\n";     
		 }
	} 

	

	/*if (((password != '') || (confirmPassword != '')))

	{

		if(currPass==''){

			err += 'Please enter current password!'; 	

		}

		else if(password == ''){

			err += 'Please enter new password!'; 	

		}

		else if(confirmPassword == ''){

			err += 'Please confirm new password!'; 	

		}

		else if(password!=confirmPassword)

		{

			err += 'Password and Confirm Password do not match \n'; 	

		}

	}*/



	if (err == '')

	{

		obj.submit();

/*	if(obj.photo.value)

	{

		$.ajaxFileUpload({

				url:url1, 

				secureuri:false,

				fileElementId:'photo',

				dataType: 'json',

				success: function (data, status)

				{

					if(typeof(data.error) != 'undefined')

					{

						if(data.error != '' && data.error!='123')

						{

							jAlert(data.error,'Alert');

						}

						else

						{

							if(data.error=='123')

							{

							   jAlert("! Invalid image type","Alert");

							}

							else

							{

								var src=$("#imgName").attr('src');

								var pos=src.lastIndexOf('/');

								var str1=src.substring(0,pos);

								$("#imgName").attr('src',str1+'/'+data.name);

								var currentPassword=document.getElementById('currentPassword').value;

								var password=document.getElementById('password').value;

								var confirmPassword=document.getElementById('confirmPassword').value;

								var firstName=document.getElementById('firstName').value;

								var lastName=document.getElementById('lastName').value;

								var tagName=document.getElementById('tagName').value;

								var role=document.getElementById('role').value;

								var department=document.getElementById('department').value;

								var address1=document.getElementById('address1').value;

								var phone=document.getElementById('phone').value;

								var mobile=document.getElementById('mobile').value;

								var otherMember=document.getElementById('otherMember').value;

								//var communityId=document.getElementById('communityId').value;

								var userName=document.getElementById('userName').value;

								var tagName=document.getElementById('tagName').value;

								//var userCommunity=document.getElementById('userCommunity').value;

								var userId=document.getElementById('userId').value;

								var workSpaceId=document.getElementById('workSpaceId').value;

								var workSpaceType=document.getElementById('workSpaceType').value;

								var userPassword=document.getElementById('userPassword').value;

								var request1 = $.ajax({

									  url: url,

									  type: "POST",

									  data: 'currentPassword='+currentPassword+'&password='+password+'&confirmPassword'+confirmPassword+'&firstName='+firstName+'&lastName='+lastName+'&tagName='+tagName+'&role='+role+'&department='+department+'&address1='+address1+'&phone='+phone+'&mobile='+mobile+'&otherMember='+otherMember+'&userName='+userName+'&tagName'+tagName+'&userId='+userId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&userPassword='+userPassword,

									  //data: '',

									  dataType: "html",

									  success:function(result)

									  { 

									    top.location.reload();

										//$("#userDetail").html("Tag Name: "+tagName+" Email: "+userName+" Telephone: "+phone+" Mobile: "+mobile); 

										profileEdit();

									  }

							   });

							}

						}

					}

				},

				error: function (data, status, e)

				{

					e.preventDefault();

					alert(e);

				}

			}

		)

		return false;

	}

	else

	{

		

								var currentPassword=document.getElementById('currentPassword').value;

								var password=document.getElementById('password').value;

								var confirmPassword=document.getElementById('confirmPassword').value;

								var firstName=document.getElementById('firstName').value;

								var lastName=document.getElementById('lastName').value;

								var tagName=document.getElementById('tagName').value;

								var role=document.getElementById('role').value;

								var department=document.getElementById('department').value;

								var address1=document.getElementById('address1').value;

								var phone=document.getElementById('phone').value;

								var mobile=document.getElementById('mobile').value;

								var otherMember=document.getElementById('otherMember').value;

								//var communityId=document.getElementById('communityId').value;

								var userName=document.getElementById('userName').value;

								var tagName=document.getElementById('tagName').value;

								//var userCommunity=document.getElementById('userCommunity').value;

								var userId=document.getElementById('userId').value;

								var workSpaceId=document.getElementById('workSpaceId').value;

								var workSpaceType=document.getElementById('workSpaceType').value;

								var userPassword=document.getElementById('userPassword').value;

								var request1 = $.ajax({

									  url: url,

									  type: "POST",

									  data: 'currentPassword='+currentPassword+'&password='+password+'&confirmPassword'+confirmPassword+'&firstName='+firstName+'&lastName='+lastName+'&tagName='+tagName+'&role='+role+'&department='+department+'&address1='+address1+'&phone='+phone+'&mobile='+mobile+'&otherMember='+otherMember +'&userName='+userName+'&tagName'+tagName+'&userId='+userId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&userPassword='+userPassword,

									  //data: '',

									  dataType: "html",

									  success:function(result)

									  {

										 top.location.reload();

										 //$("#userDetail").html("Tag Name: "+tagName+" Email: "+userName+" Telephone: "+phone+" Mobile: "+mobile); 

										 profileEdit();

									  }

							   });

							

	}

*/

	}

	else

	{

		alert (err);

		return false;	

	}

	

}

function validateWorkPlaceMemberPasswordEdit(obj,url,url1)

{
	//alert(obj);
	var obj=document.frmWorkPlace1;

   	var currPass = obj.currentPassword.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;
	
	
	var reAlphanumeric = /^[a-zA-Z0-9_@.]+$/;

	var err='';


	if (((password != '') || (confirmPassword != '')))

	{

		if(currPass==''){

			err += 'Please enter current password!'; 	

		}

		else if(password == ''){

			err += 'Please enter new password!'; 	

		}

		else if(confirmPassword == ''){

			err += 'Please confirm new password!'; 	

		}

		else if(password!=confirmPassword)

		{

			err += 'Password and Confirm Password do not match \n'; 	

		}

	}
	
	if(currPass=='' && password=='' && confirmPassword=='')
	{
		err += 'Please enter password\n'; 	
	}
	
	if(currPass!='' && password=='' && confirmPassword=='')
	{
		err += 'Please enter new password\n'; 	
	}

	if (err == '')

	{

		obj.submit();


	}

	else

	{

		alert (err);

		return false;	

	}

	

}





//this function used to validate work Space

function validateWorkSpace(frm)

{	

	var wsName = document.getElementById('workSpaceName').value;

	var reAlphanumericName = /^[A-Za-z0-9 ]{3,20}$/;
	

	if(wsName=='')

	{

		jAlert("Please enter the space name",'Alert');

		return false;

	}	


	else if(reAlphanumericName.test(wsName)==false){

		jAlert("Please enter valid space name",'Alert');

		return false;

	}

	else if($('.mngrs:checked').length==0){

		//jAlert('Please select at least one space manager.','Alert');

		//return false;

	}	
	
	else
	{
		if($('.spaceTreeCls:checked').length==0)
		{
			var placeEditSpace = $('#placePanel').val();
			if(placeEditSpace!=1)
			{
				var EditSpace = $('#editWorkSpace').val();
				var msg= '';
				if(EditSpace==1)
				{
					msg = "Are you sure you want to update space without any tree type?";
				}
				else
				{
					msg = "Are you sure you want to create space without any tree type?";
				}
			
				var agree = confirm(msg);
				if(!agree)
				{
					return false;
				}
			}
		}
		
		$.ajax({
		type: "POST",
		url: baseUrl+"create_workspace/check_space_name",
		data: jQuery("#frmCreateTree").serialize(),
		cache: false,
		success:  function(data){
		   /* alert(data); if json obj. alert(JSON.stringify(data));*/
		   $('#createTreeStatus').html(data);
		}
	  	});	
	}

	return true;

}

function validateSubWorkSpace (frm)
{
	var wsName = document.getElementById('workSpaceName').value;

	var reAlphanumericName = /^[A-Za-z0-9 ]{3,20}$/;
	

	if(wsName=='')

	{

		jAlert("Please enter sub work space name",'Alert');

		return false;

	}	


	else if(reAlphanumericName.test(wsName)==false){

		jAlert("Please enter valid sub work space name",'Alert');

		return false;

	}
	
	if($('.spaceTreeCls:checked').length==0)
	{
			var EditSpaceAlert = $('#editSubWorkSpaceAlert').val();
			var EditSpace = $('#editSubWorkSpace').val();
			var msg= '';
			if(EditSpace==1)
			{
				if(EditSpaceAlert==1)
				{
					msg = "Are you sure you want to update subspace without any tree type?";
				}
				else if(EditSpaceAlert==0)
				{
					msg = "Are you sure you want to update subspace?";
				}
			}
			else
			{
				msg = "Are you sure you want to create subspace without any tree type?";
			}
			var agree = confirm(msg);
			if(!agree)
			{
				return false;
			}
			else
			{
				return true;
			}
	}

	return true;	
}

//this function used to validate work Space

function validateExternalDocs()

{	

	obj = document.getElementById;
	

	res = fieldBlank(obj('workSpaceDoc'),'Please attach the file to upload');

	if(!res)

	{

		return res;

	}	

	res = fieldBlank(obj('docCaption'),'Please enter the caption');

	if(!res)

	{

		obj('docCaption').focus();	

		return res;

	}	

	return true;

}



/*Added by Surbhi IV*/

function setImportedFile(artifactId,artifactType)
{
   setTagAndLinkCount(artifactId,artifactType);

   setTagsAndLinksInTitle(artifactId,artifactType);

}

/*End of Added by Surbhi IV*/



// this is a js function used to get the user community name throught AJAX

function responseWorkPlaceStatus() 

{	

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{			

			if(xmlHttp.responseText	== 0)

			{

				document.getElementById(spanId).style.color = 'red';		

				document.getElementById(spanId).innerHTML	= 'Place already exists';

				document.getElementById('workPlaceStatus').value = 0;	

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;

			}

			else	

			{

				//alert('inside');	

				document.getElementById(spanId).style.color = 'green';

				document.getElementById(spanId).innerHTML	= 'Place available';

				document.getElementById('workPlaceStatus').value = 1;	

				//document.getElementById('userNameStatus').innerHTML	= xmlHttp.responseText;	

			}								

		}

	}



}



//this function used to extend the side link menus

function extendMenus(divId)

{	

	if(document.getElementById(divId).style.display == 'none')

	{

		document.getElementById(divId).style.display = '';

	}

	else

	{

		document.getElementById(divId).style.display = 'none';

	}	

}



//this function used to confirm before deleting the item

function confirmDelete() 

{
	//Changes by Dashrath : code start
	// msg= "Are you sure you want to delete this record?";
	msg= "Are you sure you want to delete this file?";
	//Dashrath : code end

	var agree = confirm(msg);

	if (agree)

	{

		return true;

	}

	else

	{

		return false ;

	}

}



// this is a js function used to show the work Space online users

function showOnlineUsers( workSpaceId, workSpaceType, spanFieldId )

{	

	var url = baseUrl+'get_online_users';		

	createXMLHttpRequest();		

	queryString =   url; 

	spanId = spanFieldId;

	queryString = queryString + '/index/'+workSpaceId+'/'+workSpaceType;

	xmlHttp.onreadystatechange = responseOnlineUsersStatus;		

	xmlHttp.open("GET", queryString, true);

	xmlHttp.send(null);	

	setTimeout("showOnlineUsers("+workSpaceId+","+workSpaceType+",'"+spanFieldId+"')",3000);

	

}	



// this is a js function used to get the online users throught AJAX

function responseOnlineUsersStatus() 

{	

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{

			var arrResponse =new Array();

			arrResponse = xmlHttp.responseText.split('|||');			

			document.getElementById(spanId).innerHTML = arrResponse[0];

			//document.getElementById('chatExtendLinks').innerHTML	= arrResponse[1];				

		}

	}

}	



//this function used to change the user WorkSpace

function goWorkSpace(workSpaceId)

{	



	//alert (workSpaceId.value);

	if(workSpaceId.value != '')

	{		

		if(workSpaceId.value.substring(0,1) == 's')

		{

			//alert ('here');

			var tmpArray = workSpaceId.value.split(',');

			var url = baseUrl+'dashboard/index/'+tmpArray[1]+'/type/2/1';

			//alert (url);

		}



		else

		{

			var url = baseUrl+'dashboard/index/'+workSpaceId.value+'/type/1/1';	

		}	

		window.location = url;

	}

}







function setUserList(object,currentWorkSpaceId,currentWorkSpaceType)

{

	
	if(object.value!='')
	{	

			var selWorkSpaceId;

			var seleWorkSpaceType;	

			if(object.value==0)

			{

				selWorkSpaceId=0;

				seleWorkSpaceType=1;
				
				document.getElementById('selWorkSpaceType').value=1;

				/*if(!confirm("Are you sure you want to move tree ?"))

				return false;
				*/
			}

			else

			{

			

				if(object.value.substring(0,1) == 's')

				{

					var tmpArray = object.value.split(',');

					selWorkSpaceId =tmpArray[1];

					seleWorkSpaceType=2;

					document.getElementById('selWorkSpaceType').value=2;

				}

				else

				{

					selWorkSpaceId=object.value;

					seleWorkSpaceType=1;

					document.getElementById('selWorkSpaceType').value=1;

				}	

			}

			treeId=document.getElementById('seltreeId').value;

			var url = baseUrl+'dashboard';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/getWorkSpaceUser/'+selWorkSpaceId+'/'+seleWorkSpaceType+'/'+treeId+'/'+currentWorkSpaceId+'/'+currentWorkSpaceType; 

			

			xmlHttp.onreadystatechange = function(){

				if (xmlHttp.readyState == 4) {

					if($.isNumeric(xmlHttp.responseText))

					{
						//alert(xmlHttp.responseText);
						
						$("#OriginatorIdValue").val(xmlHttp.responseText);
						
						$("#divselectMoveToUser").html('');

						//window.location=baseUrl+'workspace_home2/trees/'+currentWorkSpaceId+'/type/'+currentWorkSpaceType;
						
						//window.location=baseUrl+'dashboard/index/'+currentWorkSpaceId+'/type/'+currentWorkSpaceType;

						//window.location.reload( true );

					}

					else

					{
						//alert(xmlHttp.responseText);

						document.getElementById('divselectMoveToUser').innerHTML = xmlHttp.responseText;
						
						$("#OriginatorIdValue").val('');

					}

				}

			}	

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send();

	}
	else
	{
		$("#OriginatorIdValue").val('');
		$("#divselectMoveToUser").html('');
	}

}





//This function is used to move the tree to a workspace

function moveTree(object,treeId,currentWorkSpaceId,currentWorkSpaceType)

{
	//$("#popupContainer").html('test');
	
	if(object.value=="" || object.value=="0")

	{
		if($("#selectMoveToUser").is(":visible"))
		{
		  alert("Please Select User");
		}
		else
		{
		  alert("Please Select Space");
		}
	}

	else

	{
		/*Added by Dashrath- used in alert message*/
		var treeType = document.getElementById('treeType').value;

		if(confirm("Are you sure you want to move this "+treeType+" ?"))

		{				

			var url = baseUrl+'dashboard';

			var selWorkSpaceId=document.getElementById('selWorkSpaceId').value;

			var selWorkSpaceType=document.getElementById('selWorkSpaceType').value;

			//Added by Dashrath : code start
			var checkBox=document.getElementById('copyTree');

			var treeName = document.getElementById('treeTitle').value.trim();

			if (checkBox.checked == true)
			{
			   var copyTree = 1;

			   if(document.getElementById('treeTitle').value.trim()==''){
					alert('Title can not be empty');
					return false;	
				}		
			} 
			else 
			{
			   var copyTree = 0;
			}
			//Dashrath : code end

			//alert(selWorkSpaceType);

			var temp=selWorkSpaceId.split(',');

			//alert(temp);

			if(temp[0]=='s')

			{

				selWorkSpaceId=temp[1];

				//currentWorkSpaceId=temp[1];

				//currentWorkSpaceType=2;

			} 

				// queryString = url; 

				// queryString = queryString+'/moveTree/'+selWorkSpaceId+'/'+selWorkSpaceType+'/'+treeId+'/'+object.value+'/'+currentWorkSpaceId+'/'+currentWorkSpaceType+'/'+copyTree;

				

				// //window.location = queryString;
				// //alert(parent.location);
				// //window.opener.location.href="http://localhost/bugs_teeme/dashboard/index/23/type/1/1";
	   //    		//$("#popupContainer").html('test');
				// window.top.location.href = queryString; 

			/* Added by Dashrath : code start */

		 	user_data="workSpaceId="+selWorkSpaceId+"&workSpaceType="+selWorkSpaceType+"&treeId="+treeId+"&userId="+object.value+"&currentWorkSpaceId="+currentWorkSpaceId+"&currentWorkSpaceType="+currentWorkSpaceType+"&keepCopy="+copyTree+"&treeName="+treeName;

		    var request = $.ajax({

		      url: baseUrl+"dashboard/moveTree",

		      type: "POST",

		      data: user_data,

		      dataType: "html",

		      async:false,

		      success:function(result)
		         { 
		          if(result){
		          	window.top.location.href = baseUrl+result; 
		          }
		          else
		          {
		            document.getElementById('docErrorMsg').innerHTML="error";
		          }
		         }

		     });

  			return true;

			/* Dashrath : code end */

		}

	
	}

}





//This function is used to copy the tree to the same workspace



function copyTree(workSpaceId, workSpaceType,treeId)

{



	var url = baseUrl+'workspace_home/copyTree/'+workSpaceId+'/'+treeId+'/'+workSpaceType+'';	



	window.location = url;



}

//Calendar view for all artifacts

function changeDropCal()

{

	document.frmCal.searchDate[0].selected = true;

}

//Calendar view for all artifacts	

function getTimingsCal(thisVal) 

{	

	//if(thisVal.value != 0)

	//{

		

		document.frmCal.fromDate.value = '';

		document.frmCal.toDate.value = '';

	//}		

}

function clearSearchDropdown()
{
	document.frmCal.searchDate.value = 0;
}



	function compareDates1 (dat1, dat2) {

   		var date1, date2;

   		var month1, month2;

   		var year1, year2;

	 	value1 = dat1;

	  	value2 = dat2;



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

   else return 0;

} 

//This method is used to validate the calendar

function validateCal() 

{	
		
		if(document.frmCal.fromDate.value!='' && document.frmCal.toDate.value!='' ){

			if(compareDates1(document.frmCal.fromDate.value,document.frmCal.toDate.value) == 1){

				jAlert('"To Date" should be greater than or equal to "From Date"','Alert');	

				return false;

			}

		}
		
		/*if(document.frmCal.fromDate.value=='' && document.frmCal.toDate.value=='' )
		{

				//alert('Please fill "From Date" or "To Date"');	
				//return false;
		}*/

		return true;

		

}



//change the site language

function changeLang(thisVal, langCode)

{		

	var lang = thisVal;	

	var url = baseUrl+'change_language';		  

	createXMLHttpRequest();

	queryString =   url; 

	queryString = queryString + '/index/'+lang+'/'+langCode;

	xmlHttp.onreadystatechange = responseLanguage;		

	xmlHttp.open("GET", queryString, true);

	xmlHttp.send(null);					

	

}





function responseLanguage() 

{

	

	if(xmlHttp.readyState == 4) 

	{		

		if(xmlHttp.status == 200) 

		{			
			//window.location.reload();

			location.href = location.href;

			//document.getElementById('otherCommunityName1').innerHTML	= xmlHttp.responseText;								

		}

	}

}



//this function used to validate the admin fields

function validateAdmin()

{	

	var username = document.getElementById('userName').value;

	var password = document.getElementById('password').value;

	var confirmPassword = document.getElementById('confirmPassword').value;

	//var securityAnswer = document.getElementById('securityAnswer').value;

	var err= '';

	

	emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;



	if(username!='')

	{	

		if(emailTest.test(username)==false)

		{	

			err = 'Please enter valid Email \n';	

		}

	}

	else{

		err = 'Please enter Email \n';	

	}

	if(password == '')

	{		

		err += 'Please enter Password \n';	

	}

	else{

		if(confirmPassword == '')

		{	

			err += 'Please enter Confirm Password \n';	

		}	

		else if (password != confirmPassword)	

		{

			err += 'Password and Confirm Password do not match \n';	

		}

	}

/*	if(securityAnswer == '')

	{		

		err += 'Please enter the security answer';

	}*/

	if (err != '')

	{

		jAlert (err,'Alert');

		return false;

	}

	else

	{

		return true;

	}

}



//this function used to validate the admin fields

function validateAdminEdit()

{	

	var username = document.getElementById('username').value;

	var password = document.getElementById('password').value;

	var confirmPassword = document.getElementById('confirmPassword').value;

	//var securityAnswer = document.getElementById('securityAnswer').value;

	//var securityAnswerStored = document.getElementById('securityAnswerStored').value;

	var err= '';

	emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;
	
	if(username!='')

	{	

		if(emailTest.test(username)==false)

		{	

			err = 'Please enter valid Email \n';	

		}

	}

	else{

		err = 'Please enter Email \n';	

	}

	if(password == '')

	{		

		err += 'Please enter the password \n';	

	}

	if(confirmPassword == '')

	{	

		err += 'Please enter the confirm password \n';	

	}	

	if ((password != '') || (confirmPassword != ''))

	{

		if (password != confirmPassword)	

		{

			err += 'Password and Confirm Password do not match \n';	

		}

	}

/*	if(securityAnswer != securityAnswerStored)

	{		

		err += 'Wrong security answer';

	}*/

	if (err != '')

	{

		jAlert (err,'Alert');

		return false;

	}

	else

	{

		return true;

	}

}



function hideall(leafOrder){

	

	if (document.getElementById('allnodesOrders'))

	{

		//alert (document.getElementById('allnodesOrders').value);

		var arrLeafIds = new Array();

		arrLeafIds = document.getElementById('allnodesOrders').value.split(',');

		

		//alert ('arrleafids' + arrLeafIds.length);

		

		for(var i=0;i<arrLeafIds.length;i++)

		{

			if (leafOrder!=arrLeafIds[i])

			{

				//alert ('leafOptions'+arrLeafIds[i]);

				if (document.getElementById('leafOptions'+arrLeafIds[i]).style.display != 'none')

				{

					//alert ('here');

					document.getElementById('leafOptions'+arrLeafIds[i]).style.display = 'none';

				}

			}

		}

	}

	if (document.getElementById('leafAddFirst'))

	{

		 document.getElementById('leafAddFirst').style.display="none";	

	}



}







//this function used to display the artifact links by artifact node id

function showArtifactLinks(nodeOrder, nodeId, artifactType, workspaceId, workspaceType, linkType,latestVersion,position)

{

	

	xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/setFlagForLinkView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.onreadystatechange = function()

		{

			 if (xmlHttpTree.readyState==4 && xmlHttpTree.status==200)

			{

			    if(xmlHttpTree.responseText=='false')

				{ 

					jAlert("Please save or close the current link view before accessing another link view","Alert");

					return false;

					

				}

				else

				{

					xmlHttpTree2=GetXmlHttpObject2();

					var url2 =baseUrl+'create_tag1/resetFlagForLinkView/';

					xmlHttpTree2.open("GET", url2, true); 

					xmlHttpTree2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

					xmlHttpTree2.send(null);

					

	

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

	

	if(document.getElementById(linkIframeId).style.display == "")

	{

			document.getElementById(linkIframeId).style.display="none";

		}

	else{

	

	

	//document.getElementById(linkIframeId).innerHTML;

	

	var httpDoc = getHTTPObjectm();

	

	var urlm= baseUrl+'show_artifact_links/index/'+nodeId+'/'+artifactType+'/'+workspaceId+'/'+workspaceType+'/'+linkType+'/'+nodeOrder+'/'+latestVersion;

	document.getElementById(linkIframeId).style.display = "block";

	

	httpDoc.open("POST", urlm, true); 

	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpDoc.onreadystatechange = function()

					  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

						{

							

							document.getElementById(linkIframeId).style.display = "";	

							document.getElementById(linkIframeId).innerHTML=httpDoc.responseText;

						

						}

					  }     

		httpDoc.send();



	

	

	hideall();

	

	}

	

	}

			}

		}

				

		xmlHttpTree.send(null);



	

}





function responseArtifactLinks() 

{

	

	if(xmlHttp.readyState == 4) 

	{		

		if(xmlHttp.status == 200) 

		{

			

			//alert(xmlHttp.responseText);

			//alert(spanArtifactLinks);

			document.getElementById(spanArtifactLinks).style.display = 'block';		

			document.getElementById(spanArtifactLinks).innerHTML	= xmlHttp.responseText;								

		}

	}

}

	function showdetail(id)

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

				//alert (nodeId);

				document.getElementById(nodeId).style.display='none';	

				document.getElementById(curAddId).style.display='none';	

			}

		} 

		if(document.getElementById(curNode).style.display=='')		

		{

			document.getElementById(curNode).style.display='none';

			document.getElementById(added).style.display='none';	

		}

		else

		{

			document.getElementById(curNode).style.display='';

			document.getElementById(added).style.display='';

		}

	}

function newLink(nodeId)

{	



	xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/setFlagForLinkView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.onreadystatechange = function()

		{

			 if (xmlHttpTree.readyState==4 && xmlHttpTree.status==200)

			{

			    if(xmlHttpTree.responseText=='true')

				{

					

					var linkNew = 'linkNew'+nodeId;

					var spanLinkNew = 'spanLinkNew'+nodeId;

					document.getElementById(spanLinkNew).style.display = 'none';

					document.getElementById(linkNew).style.display = '';

					

				}

				else

				{

					jAlert("Please save or close the current link view before accessing another link view","Alert");

					return false;

				}

			}

		}

		xmlHttpTree.open("GET", url, true);

		xmlHttpTree.send(null);

	

}



function selectLinks(thisVal, nodeId)

{

	var treeLinks = 'treeLinks'+nodeId;	

	var spanLinkNew = 'spanLinkNew'+nodeId;	

	var docList = 'docList'+nodeId;	

	var disList = 'disList'+nodeId;	

	var chatList = 'chatList'+nodeId;	

	var activityList = 'activityList'+nodeId;	

	var notesList = 'notesList'+nodeId;	

	var contactList = 'contactList'+nodeId;	

	var urlList = 'urlList'+nodeId;	

	var importList = 'importList'+nodeId;

	//Added by Dashrath- for folder link
	var importFolderList = 'importFolderList'+nodeId;

	var newImportFile ='newImportFile'+nodeId;

	document.getElementById(treeLinks).value = 0;

	document.getElementById('actionButtons').style.display = 'block';

	//document.getElementById(spanLinkNew).style.display = 'none';			

	if(thisVal.value == 1)

	{

		document.getElementById(docList).style.display = 'block';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById('sectionType').value = 'doc';
		
		$(".linkApplyLoader_doc").show();
		
		$(".linkApplyLoader_dis,.linkApplyLoader_chat,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_doc');

		var docTreeIds = new Array();

		docTreeIds = document.getElementById('docTreeIds'+nodeId).value.split(',');

		var docId = 'docTreeIds'+nodeId;

		for(var i=0; i<docTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+docTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}	

	}	

	else if(thisVal.value == 2)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'block';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById('sectionType').value = 'dis';
		
		$(".linkApplyLoader_dis").show();
		
		$(".linkApplyLoader_chat,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_dis');

		var disTreeIds = new Array();

		disTreeIds = document.getElementById('disTreeIds'+nodeId).value.split(',');

		var disId = 'docTreeIds'+nodeId;

		for(var i=0; i<disTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+disTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}	

	}	

	else if(thisVal.value == 3)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'block';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById('sectionType').value = 'chat';
		
		$(".linkApplyLoader_chat").show();
		
		$(".linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_chat');

		var chatTreeIds = new Array();

		chatTreeIds = document.getElementById('chatTreeIds'+nodeId).value.split(',');

		var chatId = 'chatTreeIds'+nodeId;

		for(var i=0; i<chatTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+chatTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}	

	}	

	else if(thisVal.value == 4)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'block';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById('sectionType').value = 'activity';
		
		$(".linkApplyLoader_activity").show();
		
		$(".linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_chat,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_activity');

		var activityTreeIds = new Array();

		activityTreeIds = document.getElementById('activityTreeIds'+nodeId).value.split(',');

		var activityId = 'activityTreeIds'+nodeId;

		for(var i=0; i<activityTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+activityTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}			

	}

	else if(thisVal.value == 5)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';

		document.getElementById(notesList).style.display = '';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('sectionType').value = 'notes';
		
		$(".linkApplyLoader_notes").show();
		
		$(".linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_chat,.linkApplyLoader_activity,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_notes');

		var notesTreeIds = new Array();

		notesTreeIds = document.getElementById('notesTreeIds'+nodeId).value.split(',');

		var notesId = 'notesTreeIds'+nodeId;

		for(var i=0; i<notesTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+notesTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}			

	}	

	else if(thisVal.value == 6)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = '';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById('sectionType').value = 'contact';
		
		$(".linkApplyLoader_contact").show();
		
		$(".linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_chat,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_import").hide();
		
		//$("#linkApplyLoader").attr('class', 'linkApplyLoader_contact');

		var contactTreeIds = new Array();

		contactTreeIds = document.getElementById('contactTreeIds'+nodeId).value.split(',');

		//alert ('contactTreeIds= ' + contactTreeIds);

		var contactId = 'contactTreeIds'+nodeId;

		for(var i=0; i<contactTreeIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+contactTreeIds[i];

			//document.getElementById(linkSpanId).style.backgroundColor  = '';

		}			

	}

	else if(thisVal.value == 7)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById(importList).style.display = '';
		
		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById('sectionType').value = '';
		
		$(".linkApplyLoader_import").show();
		
		$(".linkApplyLoader_chat,.linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact").hide();

		var importFileIds = new Array();

		

		importFileIds = document.getElementById('importFileIds'+nodeId).value.split(',');

		//alert (importFileIds);

		var importId = 'importFileIds'+nodeId;

		for(var i=0; i<importFileIds.length; i++)

		{	

			var linkSpanId = 'node'+nodeId+'linkTree'+importFileIds[i];

			//alert (linkSpanId);

			if (importFileIds[i] != '')

			{

				//document.getElementById(linkSpanId).style.backgroundColor  = '';

			}

		}			

	}

	

	else if(thisVal.value == 8)

	{

		if(mobile_detect("", "1", '')){

			

			jAlert("To upload file use web services.", 'Alert');

			document.getElementById("artTreeId").checked = true;

			selectLinks(1, nodeId)

			

		}else

		{		

			document.getElementById(docList).style.display = 'none';

			document.getElementById(disList).style.display = 'none';

			document.getElementById(chatList).style.display = 'none';

			document.getElementById(activityList).style.display = 'none';	

			document.getElementById(notesList).style.display = 'none';

			document.getElementById(contactList).style.display = 'none';

			document.getElementById(importList).style.display = 'none';

			//Added By Dashrath- used for folder import
			document.getElementById(importFolderList).style.display = 'none';

			document.getElementById(urlList).style.display = 'none';

			document.getElementById('actionButtons').style.display = 'none';

			document.getElementById(newImportFile).style.display = 'block';

		}
		
		$(".linkApplyLoader_chat,.linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();

				

	}

	

	else if(thisVal.value ==9)

	{

		

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = 'none';

		document.getElementById(urlList).style.display = 'block';

		document.getElementById('actionButtons').style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		
		$(".linkApplyLoader_chat,.linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
		

		

				

	}

	else if(thisVal.value == 10)

	{

		document.getElementById(docList).style.display = 'none';

		document.getElementById(disList).style.display = 'none';

		document.getElementById(chatList).style.display = 'none';

		document.getElementById(activityList).style.display = 'none';	

		document.getElementById(notesList).style.display = 'none';

		document.getElementById(contactList).style.display = 'none';

		document.getElementById(newImportFile).style.display = 'none';

		document.getElementById(urlList).style.display = 'none';

		document.getElementById('actionButtons').style.display = 'block';

		document.getElementById(importList).style.display = 'none';

		//Added By Dashrath- used for folder import
		document.getElementById(importFolderList).style.display = '';
		
		document.getElementById('sectionType').value = '';
		
		$(".linkApplyLoader_import_folder").show();
		
		$(".linkApplyLoader_chat,.linkApplyLoader_dis,.linkApplyLoader_doc,.linkApplyLoader_activity,.linkApplyLoader_notes,.linkApplyLoader_contact,.linkApplyLoader_import").hide();
	}


}







//Change the background of the tree when clicking the link

	function changeBackgroundSpan2(treeId,nodeId)

	{		

		if (treeId != '')

		{

		var linkSpanId = 'node'+nodeId+'linkTree'+treeId;

			

		var treeLinks = 'treeLinks'+nodeId;		

		

		if(document.getElementById(linkSpanId).style.backgroundColor == '#316AC5' || document.getElementById(linkSpanId).style.backgroundColor == 'rgb(102, 153, 255)')

		{ 			

			document.getElementById(linkSpanId).style.backgroundColor  = '';

		}

		else

		{

			document.getElementById(linkSpanId).style.backgroundColor  = '#316AC5';

		}



		if(document.getElementById(treeLinks).value == 0)

		{

			document.getElementById(treeLinks).value = treeId;

		}

		else

		{		

				

			var treeIds = new Array();			

			var curTreeIds = document.getElementById(treeLinks).value.split(',');

					

			var addedStatus = 0;		

			var j = 0;			

			for(var i=0; i<curTreeIds.length; i++)

			{		

				if(treeId == curTreeIds[i])

				{				

					addedStatus = 1;				

				}

				if(treeId != curTreeIds[i])

				{								

					treeIds[j] = curTreeIds[i];

					j++;	

				}						

			}	

			

			if(addedStatus == 0)

			{

				treeIds[j] = treeId;

			}	

			if(treeIds.length > 0)

			{

				document.getElementById(treeLinks).value = treeIds.join();

			}

			else

			{

				document.getElementById(treeLinks).value = 0;

			}

		}

		}

	}



//Change the background of the tree when clicking the link

	function changeBackgroundSpan3(treeId,nodeId)

	{		

		if (treeId != '')

		{

		var linkSpanId = 'node2'+nodeId+'linkTree'+treeId;

			

		var treeLinks = 'treeLinks2'+nodeId;		

		

		if(document.getElementById(linkSpanId).style.backgroundColor == '#316AC5' || document.getElementById(linkSpanId).style.backgroundColor == 'rgb(102, 153, 255)')

		{ 			

			document.getElementById(linkSpanId).style.backgroundColor  = '';

		}

		else

		{

			document.getElementById(linkSpanId).style.backgroundColor  = '#316AC5';

		}



		if(document.getElementById(treeLinks).value == 0)

		{

			document.getElementById(treeLinks).value = treeId;

		}

		else

		{		

				

			var treeIds = new Array();			

			var curTreeIds = document.getElementById(treeLinks).value.split(',');

					

			var addedStatus = 0;		

			var j = 0;			

			for(var i=0; i<curTreeIds.length; i++)

			{		

				if(treeId == curTreeIds[i])

				{				

					addedStatus = 1;				

				}

				if(treeId != curTreeIds[i])

				{								

					treeIds[j] = curTreeIds[i];

					j++;	

				}						

			}	

			

			if(addedStatus == 0)

			{

				treeIds[j] = treeId;

			}	

			if(treeIds.length > 0)

			{

				document.getElementById(treeLinks).value = treeIds.join();

			}

			else

			{

				document.getElementById(treeLinks).value = 0;

			}

		}

		}

	}

	

	

	//Change the background of the tag when clicking the link

	function changeBackgroundSpan4(tagId)

	{		

		if (tagId != '')

		{

		var tagSpanId = 'tag'+tagId;

		var tagLinks = 'tagLinks';	

		//var treeLinks = 'treeLinks2'+nodeId;		

		

		if(document.getElementById(tagSpanId).style.backgroundColor == '#316AC5' || document.getElementById(tagSpanId).style.backgroundColor == 'rgb(102, 153, 255)')

		{ 			

			document.getElementById(tagSpanId).style.backgroundColor  = '';

		}

		else

		{

			document.getElementById(tagSpanId).style.backgroundColor  = '#316AC5';

		}



		if(document.getElementById(tagLinks).value == 0)

		{

			document.getElementById(tagLinks).value = tagId;

		}

		else

		{		

				

			var tagIds = new Array();			

			var curTagIds = document.getElementById(tagLinks).value.split(',');

					

			var addedStatus = 0;		

			var j = 0;			

			for(var i=0; i<curTagIds.length; i++)

			{		

				if(tagId == curTagIds[i])

				{				

					addedStatus = 1;				

				}

				if(treeId != curTagIds[i])

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

				document.getElementById(tagLinks).value = tagIds.join();

			}

			else

			{

				document.getElementById(tagLinks).value = 0;

			}

			//alert (document.getElementById(tagLinks).value);

		}

		}

	}

	function removeTags ()

	{

		//linkUpdateStatus = 'linkUpdateStatus2'+nodeOrder;

		var tagLinks = 'tagLinks';	

		//alert (document.getElementById(tagLinks).value);

		if(document.getElementById(tagLinks).value != 0)

		{

			var appliedTags = document.getElementById(tagLinks).value;

			//alert ('appliedTags= ' + appliedTags);

			var url = baseUrl+'add_tag/removeTags';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/?tagIds='+appliedTags+'&del';

			//alert ('query= ' + queryString);

			xmlHttp.onreadystatechange = responseTagStatus;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

		else

		{

			jAlert('Please select the tags from the above list to remove the tags','Alert');

		}	

	}

	

	function responseTagStatus() 

	{

		

		if(xmlHttp.readyState == 4) 

		{		

			if(xmlHttp.status == 200) 

			{									

				if(xmlHttp.responseText == '1')

				{

					//document.getElementById(linkUpdateStatus).innerHTML = 'Links have been removed successfully';

					jAlert('Tags have been removed successfully','Alert');

				}								

			}

		}

	}

	//This function used to apply the links

	function applyLink(nodeId, nodeType, nodeOrder, treeId)

	{

		//alert ('treeid= ' + treeId);

		//alert ('nodeId= ' + nodeId);

		linkUpdateStatus = 'linkUpdateStatus'+nodeOrder;

		var treeLinks = 'treeLinks'+nodeOrder;

		if(document.getElementById(treeLinks).value != 0)

		{

			var appliedLinks = document.getElementById(treeLinks).value;

			var url = baseUrl+'add_links';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/index&linkIds='+appliedLinks+'&nodeId='+nodeId+'&nodeType='+nodeType+'&nodeOrder='+nodeOrder+'&treeId='+treeId;

			xmlHttp.onreadystatechange = responseLinkStatus;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

		else

		{

			jAlert('Please select the trees from the above list to create the link','Alert');

		}					

	}

	

	function applyExternalDocLink(nodeId, nodeType, nodeOrder, docId)

	{

		//alert ('nodeOrder= ' + nodeOrder);

		//alert ('nodeId= ' + nodeId);

		linkUpdateStatus = 'linkUpdateStatus'+nodeOrder;

		var treeLinks = 'treeLinks'+nodeOrder;

		if(document.getElementById(treeLinks).value != 0)

		{

			

			var appliedLinks = document.getElementById(treeLinks).value;

			//alert ('AppliedLinks= ' + appliedLinks);

			var url = baseUrl+'add_links/add_external';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/index?linkIds='+appliedLinks+'&nodeId='+nodeId+'&nodeType='+nodeType+'&nodeOrder='+nodeOrder+'&docId='+docId;

			xmlHttp.onreadystatechange = responseExternalLinkStatus;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

		else

		{

			jAlert('Please select the trees from the above list to create the link','Alert');

		}					

	}



	function responseLinkStatus() 

	{

		

		if(xmlHttp.readyState == 4) 

		{		

			if(xmlHttp.status == 200) 

			{									

				if(xmlHttp.responseText == '1')

				{

					document.getElementById(linkUpdateStatus).innerHTML = 'Links have been created successfully';

				}								

			}

		}

	}



	function responseExternalLinkStatus() 

	{

		

		if(xmlHttp.readyState == 4) 

		{		

			if(xmlHttp.status == 200) 

			{									

				if(xmlHttp.responseText == '1')

				{

					jAlert ("Links have been created successfully!!!!!","Info");

					//document.getElementById(linkUpdateStatus).innerHTML = 'Links have been created successfully';

				}								

			}

		}

	}

	

	

	//This function used to remove the links

	function removeLink(nodeId, nodeType, nodeOrder, treeId)

	{

		//alert ('treeid= ' + treeId);

		//alert ('nodeId= ' + nodeId);

		linkUpdateStatus = 'linkUpdateStatus2'+nodeOrder;

		var treeLinks = 'treeLinks2'+nodeOrder;

		if(document.getElementById(treeLinks).value != 0)

		{

			var appliedLinks = document.getElementById(treeLinks).value;

			var url = baseUrl+'add_links/removeLink';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/&linkIds='+appliedLinks+'&nodeId='+nodeId+'&nodeType='+nodeType+'&nodeOrder='+nodeOrder+'&treeId='+treeId;

			xmlHttp.onreadystatechange = responseLinkStatus2;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

		else

		{

			jAlert('Please select the trees from the above list to remove the links','Alert');

		}					

	}





	function removeExternalDocLink(nodeId, nodeType, nodeOrder, treeId)

	{

		

		linkUpdateStatus = 'linkUpdateStatus2'+nodeOrder;

		var treeLinks = 'treeLinks2'+nodeOrder;

		if(document.getElementById(treeLinks).value != 0)

		{

			var appliedLinks = document.getElementById(treeLinks).value;

			var url = baseUrl+'add_links/removeExternal';				

			createXMLHttpRequest();

			queryString =   url; 

			queryString = queryString+'/&linkIds='+appliedLinks+'&nodeId='+nodeId+'&nodeType='+nodeType+'&nodeOrder='+nodeOrder+'&treeId='+treeId;

			xmlHttp.onreadystatechange = responseExternalLinkStatus2;		

			xmlHttp.open("GET", queryString, true);

			xmlHttp.send(null);

		}

		else

		{

			jAlert('Please select the trees from the above list to remove the links','Alert');

		}					

	}

	

	

	function responseLinkStatus2() 

	{

		

		if(xmlHttp.readyState == 4) 

		{		

			if(xmlHttp.status == 200) 

			{									

				if(xmlHttp.responseText == '1')

				{

					//document.getElementById(linkUpdateStatus).innerHTML = 'Links have been removed successfully';

					jAlert('Links have been removed successfully','Alert');

				}								

			}

		}

	}



	function responseExternalLinkStatus2() 

	{

		

		if(xmlHttp.readyState == 4) 

		{		

			if(xmlHttp.status == 200) 

			{									

				if(xmlHttp.responseText == '1')

				{

					//document.getElementById(linkUpdateStatus).innerHTML = 'Links have been removed successfully';

					jAlert('Links have been removed successfully','Alert');

				}								

			}

		}

	}



	function hideArtifactLinks(nodeOrder,linkSpanOrder)

	{	

		var linkIframeId = 'linkIframeId'+nodeOrder;		

		parent.document.getElementById(linkIframeId).style.display = 'none';		

		var linkNew = 'linkNew'+linkSpanOrder;

		var linkUpdateStatus = 'linkUpdateStatus'+linkSpanOrder;

		document.getElementById(linkNew).style.display = 'none';

		document.getElementById(linkUpdateStatus).style.display = 'none';

		parent.location.href = parent.location.href;

		

	}

	function hideArtifactLinksNew(nodeOrder,linkSpanOrder)

	{	

		xmlHttpTree=GetXmlHttpObject2();

		var url =baseUrl+'create_tag1/resetFlagForLinkView/';

		xmlHttpTree.open("GET", url, true); 

		xmlHttpTree.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xmlHttpTree.send(null);

		var linkIframeId = 'linkIframeId'+nodeOrder;

		document.getElementById(linkIframeId).innerHTML = 'none';

		

		document.getElementById(linkIframeId).style.display = 'none';

		

	}

	//this method used to show the consolidated trees in user dashboard

	function showHideContents(showItem, hideItem)

	{	

		document.getElementById(showItem).style.display = '';		

		document.getElementById(hideItem).style.display = 'none';				

	}

	function clearForm(oForm) 

	{

    

  		var elements = oForm.elements; 

    

  		oForm.reset();



  		for(i=0; i<elements.length; i++) {

      

		field_type = elements[i].type.toLowerCase();

	

		switch(field_type) {

	

		case "text": 

		case "password": 

		case "textarea":

	        case "hidden":	

			

			elements[i].value = ""; 

			break;

        

		case "radio":

		case "checkbox":

  			if (elements[i].checked) {

   				elements[i].checked = false; 

			}

			break;



		case "select-one":

		case "select-multi":

            		elements[i].selectedIndex = -1;

			break;



		default: 

			break;

		}

    }

	}

	

	

	function handleTreeStateChangeWallAlert() 

	{

		if(xmlHttp.readyState == 4) 

		{

			if(xmlHttp.status == 200) 
			{  
			/*
				//alert (xmlHttp2.responseText);				
				if(xmlHttp.responseText!="no_message")

				{

					//document.getElementById('wallAlert').innerHTML=xmlHttp.responseText;
					//alert ('Here2');
					$('#reloadMsg').html(xmlHttp.responseText);

				}
				else
				{
					$('#reloadMsg').html("<img id='updateImage' src='"+base_url()+"/images/new-version.png' border='0' onclick='location.reload();' style='cursor:pointer'>");
				}*/
				$('#reloadMsg').html(xmlHttp2.responseText);

			}

		}

	}

	//Not working

	function checkWallAlerts(workSpaceId,workSpaceType)

	{

		//alert ('treeId= ' + treeId);

		var url = baseUrl+'profile/checkWallAlerts/'+workSpaceId+'/'+workSpaceType;	  

		//alert (url);

		//xmlHttp4=GetXmlHttpObject2();

		createXMLHttpRequest();	



		xmlHttp.onreadystatechange = handleTreeStateChangeWallAlert;	



		xmlHttp.open("GET", url, true);

		xmlHttp.send(null);



	}

	

	//arun-working condition

	function checkWallAlerts2(workSpaceId,workSpaceType)

	{

		

		var url = baseUrl+'profile/checkWallAlerts2/'+workSpaceId+'/'+workSpaceType;	  

		//alert (url);

		//xmlHttp4=GetXmlHttpObject2();

		createXMLHttpRequest();	



		xmlHttp.onreadystatechange = handleTreeStateChangeWallAlert;	



		xmlHttp.open("GET", url, true);

		xmlHttp.send(null);



	}

	

	//arun-working condition

	function messageNotification(workSpaceId,workSpaceType)

	{

		//alert ('treeId= ' + treeId);

		var url = baseUrl+'profile/messageNotification/'+workSpaceId+'/'+workSpaceType;	  

		//alert (url);

		//xmlHttp4=GetXmlHttpObject2();

		createXMLHttpRequest2();	



		xmlHttp2.onreadystatechange = handleMessageNotification;	



		xmlHttp2.open("GET", url, true);

		xmlHttp2.send(null);



	}

	

	function handleMessageNotification() 

	{

		if(xmlHttp2.readyState == 4) 

		{

			if(xmlHttp2.status == 200) 

			{
				/*	
				//alert (xmlHttp2.responseText);
				if(xmlHttp2.responseText!='no_message')

				{
				//alert ('Here1');
		
    				//document.getElementById('divMessageNotification').innerHTML=xmlHttp2.responseText;

					$('#reloadMsg').html(xmlHttp2.responseText);

				}
			else
				{
					$('#reloadMsg').html("<img id='updateImage' src='"+base_url()+"/images/new-version.png' border='0' onclick='location.reload();' style='cursor:pointer'>");
				}*/
				$('#reloadMsg').html(xmlHttp2.responseText);

			}

		}

	}

	

	





function editContributors() 

{	

   

	var HttpContributors  = GetXmlHttpObject2();

		

	var notesId =	document.getElementById('notesId').value;

	

	var myId    =   document.getElementById('myId').value

	var flag=0;

	 if(document.frmedit_notes.notesUsers.length)

	 { 

		 	var chkedVals = new Array; //array to store checked checkboxes value

 		 for(var i = 0; i < document.frmedit_notes.notesUsers.length; i++){

    			if(document.frmedit_notes.notesUsers[i].checked) {

       			chkedVals.push(document.frmedit_notes.notesUsers[i].value);

				if(myId==document.frmedit_notes.notesUsers[i].value)

				{

					flag=1;

					

					

				}

    		

  		       }

		}

	 }

	 else

	 {   

	       var chkedVals='';

	       if(document.getElementById('notesUsers').checked)

	 		{

		  		chkedVals=document.getElementById('notesUsers').value;

				if(myId==chkedVals)

				{

						flag=1;

					

				}

			}

			

		 }



 

  if(flag)

   {

	   	document.getElementById("aAddNewNote").style.display='block';

		$(".editDocumentOption").show();

					

	   }

	 else

	 {

		 	document.getElementById("aAddNewNote").style.display='none';

			$(".editDocumentOption").hide();

		 }

	 

	

	var urlm=baseUrl+'notes/Edit_Notes/'+workSpaceId+'/'+workSpaceType;

	

	var data='notesId='+notesId+'&editNotes=1&notesUsers='+chkedVals;

	

	HttpContributors.open("POST", urlm, true); 

	

	HttpContributors.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	

	HttpContributors.onreadystatechange = function()

	{

	  	if (HttpContributors.readyState==4 && HttpContributors.status==200)

			{

			    if(HttpContributors.responseText == 'none')

				{

						document.getElementById('divContributors').innerHTML='';   

					}

					else

					{

						document.getElementById('divContributors').innerHTML=HttpContributors.responseText;    
					}

				document.getElementById('edit_notes').style.display='none';

		

			}

	 }     

	HttpContributors.send(data);

	

}



function editContributorsNew() 

{	

   

	var HttpContributors  = GetXmlHttpObject2();

		

	var notesId =	document.getElementById('notesId').value;

	

	var myId    =   document.getElementById('myId').value

	var flag=0;

	var chkedVals = new Array; 

	$('[name=notesUsers]').each(function()

		{  

		    

			if(this.checked)

			{	 

			    

		   		chkedVals.push($(this).val());

				if(myId==$(this).val())

				flag=1;

			}

			

							

		 });

	

		var contributorslist = document.getElementById('contributorslist').value;
		
		if(contributorslist=='')
		{
			flag=1;
		}

	

	  if(flag)

	   {

			self.parent.document.getElementById("aAddNewNote").style.display='block';

			self.parent.showOptions();

			//$(".editDocumentOption").show();

						

		   }

		 else

		 {

				self.parent.document.getElementById("aAddNewNote").style.display='none';

				//$(".editDocumentOption").hide();

				self.parent.hideOptions();

				

			 }

	$(".contLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		
	var urlm=baseUrl+'notes/Edit_Notes/'+workSpaceId+'/'+workSpaceType;

	

	var data='notesId='+notesId+'&editNotes=1&notesUsers='+chkedVals+'&contributorslist='+contributorslist;

	

	HttpContributors.open("POST", urlm, true); 

	

	HttpContributors.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	

	HttpContributors.onreadystatechange = function()

	{

	  	if (HttpContributors.readyState==4 && HttpContributors.status==200)

			{

			    if(HttpContributors.responseText == 'none')

				{

						//document.getElementById('divContributors').innerHTML=''; 
						//$('#contributor_head').hide();  
						document.getElementById('vContributors').innerHTML='';
						document.getElementById('seeAll').innerHTML='';
						document.getElementById('contributor_head').innerHTML='';
						 
					}

					else

					{
							//document.getElementById('divContributors').innerHTML=HttpContributors.responseText;  
							$(".clsContributors").html(HttpContributors.responseText);
							//Manoj: code for append contributors name 
							/*var contributors_name=HttpContributors.responseText;
							if (contributors_name.indexOf(',') > -1)
							{
								//contributors_name = contributors_name.substring(contributors_name.indexOf(",")+1).trim();
								document.getElementById('vContributors').innerHTML=contributors_name; 
								document.getElementById('seeAllDiv').innerHTML='<a id="seeAll" class="seeAllTxt" onclick="show_assignee()">See all..</a>';
								document.getElementById('contributor_head').innerHTML='';
								$('#vContributors').hide();
							}
							else
							{
								document.getElementById('contributor_head').innerHTML=contributors_name; 
								document.getElementById('seeAllDiv').innerHTML=''; 
								document.getElementById('vContributors').innerHTML='';
								
							}*/
					}
					
				$(".contLoader").html("");	

				//document.getElementById('contributorsMsg').innerHTML="Contributers updated successfully."; 

				

			//Code for close pop up window	

			//window.top.hidePopWin(true);

		

			}

	 }     

	HttpContributors.send(data);

	

}



function treeOperations(object)

{  

     

	  if(object.value=='move')

	  {

		  document.getElementById('edit_notes').style.display='none';

		  document.getElementById('divAutoNumbering').style.display='none';

		  document.getElementById('spanMoveTree').style.display='block';

		  }

	 else if(object.value=='contributors')

	 {		

	 		document.getElementById('spanMoveTree').style.display='none';

			document.getElementById('divAutoNumbering').style.display='none';

			document.getElementById('edit_notes').style.display='block';

				

		 }

	else if(object.value=='autoNumbering')

	 {		

	 		document.getElementById('spanMoveTree').style.display='none';

			

			document.getElementById('edit_notes').style.display='none';

			document.getElementById('divAutoNumbering').style.display='block';

				

		 }

		 

	 else 

	 {

		 	document.getElementById('spanMoveTree').style.display='none';

			document.getElementById('edit_notes').style.display='none';

			document.getElementById('divAutoNumbering').style.display='none';

		 

		 }

	

	}

	

	

	function treeOperationsnew(object,operation,treeId)

	{  

		if(document.getElementById('aMove'))

		{

	  	document.getElementById('aMove').className='';

		}

		if(document.getElementById('aNumbered'))

		{

			document.getElementById('aNumbered').className='';

		}

		if(document.getElementById('aContributors'))

		{

			document.getElementById('aContributors').className='';

		}

	   	object.className="hiLite";

	    if(operation=='move')

	  	{

		  document.getElementById('ulTreeOption').style.display='none';

		  document.getElementById('divAutoNumbering').style.display='none';

		  //document.getElementById('spanMoveTree').style.display='block';
		  showPopWin(baseUrl+'comman/getMoveSpaceLists/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,450, 350, null, '');

		 }

		 

		else if(operation=='autoNumbering')

	 	{	

			document.getElementById('ulTreeOption').style.display='none';

	 		document.getElementById('spanMoveTree').style.display='none';	

			document.getElementById('divAutoNumbering').style.display='block';

				

		 }

	   

		 else if(operation=='contributors')

		 {

			 document.getElementById('ulTreeOption').style.display='none';

			 document.getElementById('divAutoNumbering').style.display='none';

			 document.getElementById('spanMoveTree').style.display='none';	

		 	 showPopWin(baseUrl+'comman/getcountributors/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,600, 350, null, '');

		 }

		 

		 else

		 {

			  document.getElementById('divAutoNumbering').style.display='none';

			  document.getElementById('spanMoveTree').style.display='none';	

		 //return false;

		 }

	

	}

	

	

	function showSearchContributors(treeId)

	{

		

	var toMatch = document.getElementById('showMembers').value;

	

	var val = '';

  

	urlm=baseUrl+'comman/search_Contributors/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch+'&treeId='+treeId;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				

				document.getElementById("showMem").innerHTML=xmlHttpRequest.responseText;
				 
				var list = $("#contributorslist").val();
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



function showNotesNodeOptions(position)
{
//alert ("here2");
  // if(nodeOptionsVisible!=position )

	//{

		var notesId = 'normalView'+position;

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		clickEvent=position;
		//alert (clickEvent);
	//}

	/*

	else if(nodeOptionsVisible!=position)

	{

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		}

	*/

	

}



function hideNotesNodeOptions(position)

{	

	if(nodeOptionsVisible!=position)

	{
		//alert ('Yah');
		var notesId = 'normalView'+position;	

	

		document.getElementById(notesId).style.display = "none";

		document.getElementById("ulNodesHeader"+position).style.display = "none";

		//nodeOptionsVisible= -1;

	}

		

	

		

	

}

function clickNodesOptions(position)

{ 

	nodeOptionsVisible=position;

	var notesId = 'normalView'+position;	

	$('.normalView').hide();

	$('.ulNodesHeader').hide();

	

	if(document.getElementById(notesId).style.display == "none")

	{

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		

	}

	else if(clickEvent!=position)

	{ 

		document.getElementById(notesId).style.display = "none";

		document.getElementById("ulNodesHeader"+position).style.display = "none";

		//nodeOptionsVisible= -1;

	}



}

function showOptions()

	{

			$(".editDocumentOption").show();
			$(".latestLeafShow").show();

	}	

	function hideOptions()

	{

			$(".editDocumentOption").hide();

	}	

	

function hideSpanMoveTree()

{

	 document.getElementById('spanMoveTree').style.display='none';

	}

	

function hideDivAutoNumbering()

{

	document.getElementById('divAutoNumbering').style.display='none';

	}

	

function showTreeOptions()

{

	 if(document.getElementById('ulTreeOption').style.display=='none')

	 {

		 document.getElementById('ulTreeOption').style.display='block';

		 }

	else

	{

		document.getElementById('ulTreeOption').style.display='none';

		}

}

function operationIn(object)

{ 

               //alert("hi")

			  if(object.className!='hiLite') 

             object.className="newListHover";

	}

function operationOut(object)

{ 

              if(object.className!='hiLite') 

             object.className="";

	}

	

function apply_url(artifactId,artifactType,linkSpanOrder,latestVersion)

{

	

	if($("#txtUrl").val()=='')

	{

		$("#urlMsg").html('Please enter URL.');

		return false;

		}

	

	{

	

	var myregex = new RegExp("^(http:\/\/|https:\/\/|ftp:\/\/){1}([0-9A-Za-z]+\.)");

	

	var txtUrl=$("#txtUrl").val();



		if(myregex.test(txtUrl) == false)

		{

		

		  $("#urlMsg").html("Please enter valid URL.");

		  

		  return false;

		

		}

		

		else

		{	

			var request = $.ajax({

			  url: baseUrl+"show_artifact_links/applyURL/"+artifactId+"/"+artifactType,

			  type: "POST",

			  data: 'txtUrl='+txtUrl,

			  dataType: "html",

			  success:function(result)

			         { 

					    

					    if(result)

						{

							

							 var httpDoc2 = GetXmlHttpObject2();

				 

				urlm2=baseUrl+'show_artifact_links/getAppliedLinks/'+artifactId+'/'+artifactType+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactType+'/'+linkSpanOrder+'/'+latestVersion;

				

				httpDoc2.open("POST", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{   

						

						//if(httpDoc2.responseText!=0)

						{

						

						

						document.getElementById("divAppliedLinks").innerHTML=httpDoc2.responseText;

						

						

						}

						setTagAndLinkCount(artifactId,artifactType);

						/*Added by Surbhi IV*/

						setTagsAndLinksInTitle(artifactId,artifactType);

						/*End of Added by Surbhi IV*/

					}

				}

				httpDoc2.send(); 

							

							

							

							$("#txtUrl").val(" ");

							 $("#urlMsg").html("URL added successfully.");

							}

						else

						{

							 $("#urlMsg").html("ERROR:Try again.");

							}

				 

			  		}

			});

			

			}

	}

	

}



function createImportUrl(artifactId,artifactType,linkSpanOrder,latestVersion)

{ 

	 	var title= document.getElementById('title').value;  

	     var txtUrl= document.getElementById('txtUrl').value;

		  var ownerId= document.getElementById('ownerId').value;

		  var workSpaceId= document.getElementById('workSpaceId').value;

		  var workSpaceType= document.getElementById('workSpaceType').value;

		 

		if(trim(title) == '')

			{

				jAlert('Please enter URL title','Alert');

				obj.tag.focus();

				return false;

			}

		else if(trim(txtUrl) == '')

			{

				jAlert('Please enter URL','Alert');

				obj.tag.focus();

				return false;

			}

			

		var myregex = new RegExp("^(http:\/\/|https:\/\/|ftp:\/\/){1}([0-9A-Za-z]+\.)");	

			

		 if(myregex.test(txtUrl) == false)

		{

		

		   jAlert("Please enter valid URL.","Alert");

		  

		   return false;

		

		}

		else

		{

			

			var request = $.ajax({

			url: baseUrl+"show_artifact_links/addURL/"+workSpaceId+"/"+workSpaceType,

			type: "POST",

			data: 'txtUrl='+encodeURIComponent(txtUrl)+'&title='+encodeURIComponent(title)+'&ownerId='+ownerId,

			dataType: "html",

			success:function(result)

			         {

						 

						 if(result)

						 {

							 

							 var request = $.ajax({

							  url: baseUrl+"show_artifact_links/searchUrls/"+artifactId+"/"+artifactType,

							  type: "POST",

							  dataType: "html",

							  success:function(result)

									 { 

										 $("#divShowUrls").html(result);

										 

										 }

								});

							 

							 

							 $("#title").val('');

							  $("#txtUrl").val('');

							 $("#urlMsg").html("URL added successfully.");

							 }

						 else

						 {

							  $("#urlMsg").html("ERROR:Try again.");

							 

							 }

						 
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
								//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
								getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
							}
							if((treeType==3 || treeType==4 || treeType==6 || treeType==5) && artifactType==2)
							{
								//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
								getTreeLeafUserStatus(currentTreeId,nodeId,treeType);
							}
							//Code end
						 

						 }

				});

			

			

			}

			

		

	

	  

}





function applyImportedUrls(artifactId,artifactType)

		{

			

				var allImportedUrls = [];

				var applyedUrls = [];

				var userId=$("#userId").val();

				$('[name=chkImportUrls]').each(function()

				{

					allImportedUrls.push($(this).val());

					if(this.checked)

					{									 

						applyedUrls.push($(this).val());

					}

	

				 });

				var workSpaceId=document.getElementById('workSpaceId').value;

				var workSpaceType=document.getElementById('workSpaceType').value;

				var request = $.ajax({

			  url: baseUrl+"show_artifact_links/applyURL/"+artifactId+"/"+artifactType+"/"+workSpaceId+"/"+workSpaceType,

			  type: "POST",

			  data: 'allImportedUrls='+allImportedUrls+'&applyedUrls='+applyedUrls,

			  dataType: "html",

			  success:function(result)

			         {

						 showUrlsAjax(artifactId,artifactType);

						 $("#divShowUrls").scrollTop(0);

						// $("#urlMsg").html("URL applied successfully.");

						 

							

						 var httpDoc2 = GetXmlHttpObject2();

				 var workSpaceId=document.getElementById('workSpaceId').value;

				  var workSpaceType=document.getElementById('workSpaceType').value;

				   var latestVersion=document.getElementById('latestVersion').value;

				    var linkSpanOrder=document.getElementById('linkSpanOrder').value;

				urlm2=baseUrl+'show_artifact_links/getAppliedLinks/'+artifactId+'/'+artifactType+'/'+workSpaceId+'/'+workSpaceType+'/'+artifactType+'/'+linkSpanOrder+'/'+latestVersion;

				

				httpDoc2.open("POST", urlm2, true);

		 

				httpDoc2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				 

				httpDoc2.onreadystatechange = function()

				{

					if (httpDoc2.readyState==4 && httpDoc2.status==200)

					{   

						

						//if(httpDoc2.responseText!=0)

						{

						

						

						document.getElementById("divAppliedLinks").innerHTML=httpDoc2.responseText;

						

						

						}

						setTagAndLinkCount(artifactId,artifactType);

						/*Added by Surbhi IV*/

						setTagsAndLinksInTitle(artifactId,artifactType);

						/*End of Added by Surbhi IV*/
						
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
							//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
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

				});

				

				

			

		}

		

	function showUrlsAjax(artifactId,artifactType)

	{

		var txtSearch=$("#searchUrls").val();

		

		var request = $.ajax({

			  url: baseUrl+"show_artifact_links/searchUrls/"+artifactId+"/"+artifactType,

			  type: "POST",

			  data: 'txtSearch='+txtSearch,

			  dataType: "html",

			  success:function(result)

			         { 

						 $("#divShowUrls").html(result);

						 

						 }

				});

		

		

		}

		

		

		function checkValidMember(obj){

			var str = obj.search1.value;

			var reAlphanumeric = /^[a-zA-Z0-9 _@.]+$/;

			if(str==''){

				alert("Please enter search string.","Alert");

				return false;

			}

			else if(reAlphanumeric.test(str)==false){

				alert("Please enter valid search string(Special characters not allowed.)","Alert");

				return false;

			}

			else{

				return true;

			}

		}
		
/*Manoj: Added Contributors in table start*/
function editDocsContributorsNew() 
{	

   

	var HttpContributors  = GetXmlHttpObject2();

		

	var notesId =	document.getElementById('notesId').value;

	

	var myId    =   document.getElementById('myId').value;

	var flag=0;

	var chkedVals = new Array; 

	$('[name=notesUsers]').each(function()

		{  

		    

			if(this.checked)

			{	 

			    

		   		chkedVals.push($(this).val());

				if(myId==$(this).val())

				flag=1;

			}

			

							

		 });

	

		var contributorslist = document.getElementById('contributorslist').value;
		
		if(contributorslist!='')
		{
			var numbersArray = contributorslist.split(',');
	
			$.each(numbersArray, function(index, value) { 
				  //alert(myId+'===='+value);
				  if(myId==value)
				  {
					flag=1;
				  }
			});
		}
		
		if(contributorslist=='')
		{
			flag=1;
		}

	

	  if(flag)

	   {

			self.parent.document.getElementById("aAddNewNote").style.display='block';

			self.parent.showOptions();

			//$(".editDocumentOption").show();

						

		   }

		 else

		 {

				self.parent.document.getElementById("aAddNewNote").style.display='none';

				//$(".editDocumentOption").hide();

				self.parent.hideOptions();

				

			 }
	
	$(".contLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		
	var urlm=baseUrl+'document_home/Edit_Docs/'+workSpaceId+'/'+workSpaceType;

	

	var data='notesId='+notesId+'&editNotes=1&notesUsers='+chkedVals+'&contributorslist='+contributorslist;

	

	HttpContributors.open("POST", urlm, true); 

	

	HttpContributors.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	

	HttpContributors.onreadystatechange = function()

	{

	  	if (HttpContributors.readyState==4 && HttpContributors.status==200)

			{

			    if(HttpContributors.responseText == 'none')

				{
						//document.getElementById('divContributors').innerHTML='';
						document.getElementById('docContributors').innerHTML='';
						document.getElementById('seeAll').innerHTML='';
						document.getElementById('contributor_head').innerHTML='';
						
				}

				else

				{
					//alert(HttpContributors.responseText);
					$(".clsContributors").html(HttpContributors.responseText);
					//document.getElementById('divContributors').innerHTML=HttpContributors.responseText;  
					//Manoj: code for append contributors name 
							/*var contributors_name=HttpContributors.responseText;
							if (contributors_name.indexOf(',') > -1)
							{
								//contributors_name = contributors_name.substring(contributors_name.indexOf(",")+1).trim();
								document.getElementById('docContributors').innerHTML=contributors_name; 
								document.getElementById('seeAllDiv').innerHTML='<a id="seeAll" class="seeAllTxt" onclick="show_assignee()">See all..</a>';
								document.getElementById('contributor_head').innerHTML='';
								$("#docContributors").hide();
							}
							else
							{
								document.getElementById('contributor_head').innerHTML=contributors_name; 
								document.getElementById('seeAllDiv').innerHTML=''; 
								document.getElementById('docContributors').innerHTML='';
							}*/  
					
				}
				
				$(".contLoader").html("");

				//document.getElementById('contributorsMsg').innerHTML="Contributers updated successfully."; 

				

			//Code for close pop up window	

			//window.top.hidePopWin(true);

		

			}

	 }     

	HttpContributors.send(data);

	

}
/*Manoj: Added Contributors in table end */

/*Manoj: Search Contributors start*/
function showSearchDocsContributors(treeId)

	{

		

	var toMatch = document.getElementById('showMembers').value;

	

	var val = '';

  

	urlm=baseUrl+'comman/searchDocsContributors/'+workSpaceId+'/'+workSpaceType;

	

	data='toMatch='+toMatch+'&treeId='+treeId;

	

	var xmlHttpRequest = GetXmlHttpObject2();

		

	xmlHttpRequest.open("POST", urlm, true);

		 

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

	xmlHttpRequest.onreadystatechange = function()

	{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				

				 document.getElementById("showMem").innerHTML=xmlHttpRequest.responseText;
				 
				 var list = $("#contributorslist").val();
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
/*Search Contributors end*/
/*Create new tree search function start*/

function showCreateTreeContributors()
{

	var toMatch = document.getElementById('showMembers').value;

	var val = '';

  	urlm=baseUrl+'new_tree/search_Contributors/'+workSpaceId+'/'+workSpaceType;

	data='toMatch='+toMatch;

	var xmlHttpRequest = GetXmlHttpObject2();

	xmlHttpRequest.open("POST", urlm, true);
	
	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xmlHttpRequest.onreadystatechange = function()
	{
			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)
			{

				 document.getElementById("showMem").innerHTML=xmlHttpRequest.responseText;
				 
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

/*Create new tree search function end*/

function validateTrialPlace(obj)
{
	var companyName = obj.companyName.value;

	var place_timezone = obj.place_timezone.value;
	
	var fname = obj.firstName.value;

	var lname = obj.lastName.value;

	var email = obj.email.value;

	var password = obj.password.value;

	var confirmPassword = obj.confirmPassword.value;
	
	var nickName = obj.nickName.value;
	
	var user_timezone = obj.user_timezone.value;

	var reAlphanumeric = /^[a-z0-9_@.]+$/;

	var reAlphanumericName = /^[a-zA-Z_@.]+$/;

	var err='';


	if(companyName.length == 0)

	{

		err = 'Please enter Place Name \n';	

	}	

	else

	{	

		if(reAlphanumeric.test(companyName)==false)

		{

			err += 'Please enter valid Place Name \n';

		}
	}

	if(place_timezone == '0')

	{

		err += 'Please select Place Time zone \n';	

	}
	
	//place manager checks
	
	if(fname == '')

	{

		err += 'Please enter First Name \n';	

	}

	if(fname!="")

	{	

		if(reAlphanumericName.test(fname)==false)

		{

			err += 'Please enter valid First Name \n';

		}

	}

	if(lname == '')

	{

		err += 'Please enter Last Name \n';	

	}

	if(lname!="")

	{	

		if(reAlphanumericName.test(lname)==false)

		{

			err += 'Please enter valid Last Name \n';

		}

	}
	
	var regNickName = /^[^0-9][a-zA-Z0-9-_]+$/;
	
	if(nickName != '')

	{
		if (nickName.search(regNickName) == -1)
		{
			err += 'Please enter valid nickname \n';	
		}
	}
	
	if(user_timezone == '0')

	{

		err += 'Please select User Time zone \n';	

	}
	
	/*if (email == '')

	{

			err += 'Please enter Email \n';	

	}

	if (email != '')

	{

		if(validateEmail(email)==false)

		{

			err += 'Please enter valid Email \n';

		}	

	}*/



	if (password == '')

	{

		err += 'Please enter Password \n';	

	}

	if (password != confirmPassword)

	{

			err += 'Password and Confirm Password do not match \n'; 	

	}
	   
	if (err == '')

	{

		return true;	

	}

	else

	{

		jAlert (err,'Alert');

		return false;	

	}		
}
//Group function start here
$('.clsCheckGroup').live("click",function(){
		//alert('dfsd');
		val = $("#listGroup").val();

		val1 = val.split(",");	
		
		var data = $(this).data('myval');
		var usersData = $(this).data('myusers');
		var value = $(this).val();

		if($(this).prop("checked")==true){

			if($("#listGroup").val()==''){

				$("#listGroup").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){

					$("#listGroup").val(val+","+$(this).val());

				}

			}
			addSelectionDisplayItemGroup(data,value,$(this),usersData);

		}

		else{

			var index = val1.indexOf($(this).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#listGroup").val(arr);
			
			removeSelectionDisplayItemGroup(value);

		}

});

$('.clsCheckSpace').live("click",function(){
	$("#multipleSpaceRecipientArea").show();
	val = $("#listSpaces").val();

	val1 = val.split(",");	
	
	var data = $(this).data('myval');
	//var usersData = $(this).data('myusers');
	var usersData = '';
	var value = $(this).val();

	if($(this).prop("checked")==true){

		if($("#listSpaces").val()==''){

			$("#listSpaces").val($(this).val());

		}

		else{

			if(val1.indexOf($(this).val())==-1){

				$("#listSpaces").val(val+","+$(this).val());

			}

		}
		addSelectionDisplayItemSpace(data,value,$(this),usersData);

	}

	else{

		var index = val1.indexOf($(this).val());

		val1.splice(index, 1);

		var arr = val1.join(",");

		$("#listSpaces").val(arr);
		
		removeSelectionDisplayItemSpace(value);

	}

});


function checkAllGroups(){

		var htmlContent='';
		
		if($("#checkAllGroup").prop("checked")==true){

			$('.clsCheckGroup').prop("checked",true);

			$(".clsCheckGroup").each(function(){

				value = $("#listGroup").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#listGroup").val(value+","+$(this).val());

				}
				//Show checked label at top
					var data = $(this).data('myval');
					var usersData = $(this).data('myusers');
					var value = $(this).val();
					htmlContent += '<div class="sol-head sol-selected-display-item sol_check_group'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemGroup('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div><div style="clear:both"></div>';
					
					htmlContent += '<div class="sol-selected-display-item sol_check_group'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>';
				//Code end

			});
			
			$('.sol-current-selection-groups').html(htmlContent);

		}

		else{

			//change prop to attr for server - Monika

			$('.clsCheckGroup').prop("checked",false);

			$(".clsCheckGroup").each(function(){

				value = $("#listGroup").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#listGroup").val(arr);

			});
			
			$('.sol-current-selection-groups').html('');

		}

}
function checkAllUserSpaces(){
	$("#multipleSpaceRecipientArea").show();
	var htmlContent='';
	
	if($("#checkAllSpaces").prop("checked")==true){

		$("#showManSpaces").show();

		$('.clsCheckSpace').prop("checked",true);

		$(".clsCheckSpace").each(function(){

			value = $("#listSpaces").val();

			val1 = value.split(",");	

			if(val1.indexOf($(this).val())==-1){

				$("#listSpaces").val(value+","+$(this).val());

			}
			//Show checked label at top
				var data = $(this).data('myval');
				//var usersData = $(this).data('myusers');
				var value = $(this).val();
				htmlContent += '<div class="sol-head sol-selected-display-item sol_check_space'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemSpace('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
				
				//htmlContent += '<div class="sol-selected-display-item sol_check_space'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>';
			//Code end

		});
		
		$('.sol-current-selection-spaces').html(htmlContent);

	}

	else{

		$("#showManSpaces").hide();

		//change prop to attr for server - Monika

		$('.clsCheckSpace').prop("checked",false);

		$(".clsCheckSpace").each(function(){

			value = $("#listSpaces").val();

			val1 = value.split(",");	

			var index = val1.indexOf($(this).val());

			val1.splice(index);	

			var arr = val1.join(",")

			$("#listSpaces").val(arr);

		});
		
		$('.sol-current-selection-spaces').html('');

	}

}

function addSelectionDisplayItemGroup(data,value,changedItem,usersData)
{
	$('.sol-current-selection-groups').append('<div class="sol-head sol-selected-display-item sol_check_group'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemGroup('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div><div style="clear:both"></div>');
	$('.sol-current-selection-groups').append('<div class="sol-selected-display-item sol_check_group'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>');
		
}
function addSelectionDisplayItemSpace(data,value,changedItem,usersData)
{
	$('.sol-current-selection-spaces').append('<div class="sol-head sol-selected-display-item sol_check_space'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemSpace('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>');
	//$('.sol-current-selection-spaces').append('<div class="sol-selected-display-item sol_check_space'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>');	
}
	
function removeSelectionDisplayItemGroup(value,uncheck)
{
		$('.sol_check_group'+value).remove();
		
		if(uncheck=='1')
		{
		
			$('.removeGroup'+value).prop('checked', false);
			
			val = $("#listGroup").val();
	
			val1 = val.split(",");
			
			var index = val1.indexOf($('.removeGroup'+value).val());
	
			val1.splice(index, 1);
	
			var arr = val1.join(",");
	
			$("#listGroup").val(arr);
		}
		
}
function removeSelectionDisplayItemSpace(value,uncheck)
{
	$('.sol_check_space'+value).remove();		
	if(uncheck=='1')
	{		
		$('.removeSpace'+value).prop('checked', false);			
		val = $("#listSpaces").val();
		val1 = val.split(",");			
		var index = val1.indexOf($('.removeSpace'+value).val());	
		val1.splice(index, 1);
		var arr = val1.join(",");	
		$("#listSpaces").val(arr);
	}		
}
	
//Edit group 
function checkAllGroupsEdit(nodeId){
		var htmlContent='';

		if($("#checkAllGroup"+nodeId).prop("checked")==true){

			$('.clsCheckGroup'+nodeId).prop("checked",true);

			$(".clsCheckGroup"+nodeId).each(function(){

				value = $("#listGroup"+nodeId).val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#listGroup"+nodeId).val(value+","+$(this).val());

				}
				//Show checked label at top
					var data = $(this).data('myval');
					var usersData = $(this).data('myusers');
					var value = $(this).val();
					htmlContent += '<div class="sol-head sol-selected-display-item sol_check_group'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemGroupEdit('+value+','+nodeId+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div><div style="clear:both"></div>';
					htmlContent += '<div class="sol-selected-display-item sol_check_group'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>';
				//Code end

			});
			$('.sol-current-selection-groups').html(htmlContent);

		}

		else{

			$('.clsCheckGroup'+nodeId).prop("checked",false);

			$(".clsCheckGroup"+nodeId).each(function(){

				value = $("#listGroup"+nodeId).val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",");

				$("#listGroup"+nodeId).val(arr);

			});
			$('.sol-current-selection-groups').html('');

		}

	}

//Check all function end

function getGroupName(checkid,nodeId)
{
		//show label start
		var data = $(checkid).data('myval');
		var usersData = $(checkid).data('myusers');
		var value = $(checkid).val();
		//show label end
		val = $("#listGroup"+nodeId).val();

		val1 = val.split(",");	

		if($(checkid).prop("checked")==true){

			if($("#listGroup"+nodeId).val()==''){

				$("#listGroup"+nodeId).val($(checkid).val());

			}

			else{

				if(val1.indexOf($(checkid).val())==-1){

					$("#listGroup"+nodeId).val(val+","+$(checkid).val());

				}
			}
			
			 addSelectionDisplayItemGroupEdit(data,value,checkid,nodeId,usersData);

		}

		else{

			var index = val1.indexOf($(checkid).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#listGroup"+nodeId).val(arr);
			
			removeSelectionDisplayItemGroupEdit(value);

		}
}

function addSelectionDisplayItemGroupEdit(data,value,changedItem,nodeId,usersData)
{
		$('.sol-current-selection-groups').append('<div class="sol-head sol-selected-display-item sol_check_group'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemGroupEdit('+value+','+nodeId+',1); ">x</span><span class="sol-selected-display-item-text">'+data+'</span></div><div style="clear:both"></div>');
		$('.sol-current-selection-groups').append('<div class="sol-selected-display-item sol_check_group'+value+'"><span class="sol-selected-display-item-text">'+usersData+'</span></div><div style="clear:both"></div>');
		
}

function removeSelectionDisplayItemGroupEdit(value,nodeId,uncheck)
{
	$('.sol_check_group'+value).remove();
		
		if(uncheck=='1')
		{
			$('.removeGroup'+value).prop('checked', false);
			
			val = $("#listGroup"+nodeId).val();
			
			val1 = val.split(",");	
			
			var index = val1.indexOf($('.removeGroup'+value).val());
			
			val1.splice(index, 1);	

			var arr = val1.join(",");
			
			$("#listGroup"+nodeId).val(arr);
			
		}
		
}

//Group function end here
//move tree originator id
function addMoveSpaceOriginatorId(object)
{
	if(object.value!='' && object.value!=0)
	{
		$("#OriginatorIdValue").val(object.value);
	}
}

/*Draft reserved users code start*/
function editDocsReservedUsers() 
{	

   	var HttpContributors  = GetXmlHttpObject2();

	var notesId =	document.getElementById('notesId').value;
	
	var leafId =	document.getElementById('leafId').value;	

	var myId    =   document.getElementById('myId').value;
	
	var currentNodeId =	document.getElementById('currentNodeId').value;
	
	var currentLeafStatus =	document.getElementById('currentLeafStatus').value;

	var flag=0;

	var chkedVals = new Array; 
	
	
	$('[name=notesUsers]').each(function()

		{  

		    if(this.checked)

			{	 

			    

		   		chkedVals.push($(this).val());

				if(myId==$(this).val())

				flag=1;

			}

			

							

		 });
		

	
		var reserveduserlist = document.getElementById('reserveduserlist').value;
		if(reserveduserlist!='')
		{
			var numbersArray = reserveduserlist.split(',');
	
			$.each(numbersArray, function(index, value) { 
				  //alert(myId+'===='+value);
				  if(myId==value)
				  {
					flag=1;
				  }
			});
		}
		
		var editBtnHide = '';
		if(reserveduserlist!=''&& flag!=1)
		{
			editBtnHide = 1;			
		}

		/*Commented by Dashrath- Comment code for show edit button if user is tree contributor*/
		// if(reserveduserlist=='' && currentLeafStatus=='draft')
		// {
		// 	editBtnHide = 1;			
		// }

	

	  if(flag)

	   {

			self.parent.document.getElementById("aAddNewNote").style.display='block';

			//self.parent.showOptions();

			//$(".editDocumentOption").show();

						

		   }

		 else

		 {

				self.parent.document.getElementById("aAddNewNote").style.display='none';

				//$(".editDocumentOption").hide();

				//self.parent.hideOptions();

				

			 }

	$(".reserveLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

		
	var urlm=baseUrl+'comman/updateReservedUsers/'+workSpaceId+'/'+workSpaceType;

	

	var data='notesId='+notesId+'&editNotes=1&notesUsers='+chkedVals+'&reserveduserlist='+reserveduserlist+'&leafId='+leafId+'&currentNodeId='+currentNodeId;

	

	HttpContributors.open("POST", urlm, true); 

	

	HttpContributors.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	

	HttpContributors.onreadystatechange = function()

	{

	  	if (HttpContributors.readyState==4 && HttpContributors.status==200)

			{
				
				//alert(HttpContributors.responseText);
				//return false;
				//alert(notesId+'===='+leafId);

			    if(HttpContributors.responseText == 'none')

				{
						//document.getElementById('divContributors').innerHTML='';
						$('#docContributors').html('');
						$('#seeAll').html('');
						//document.getElementById('contributor_head').innerHTML='';
						$("#liReserve"+leafId,parent.document).html("<img src='"+baseUrl+"/images/emptyReserve.png' border='0'>");
						$("#liReserve"+leafId,parent.document).prop('title', 'Unreserved');
				}

				else

				{
					$(".clsContributors").html(HttpContributors.responseText);
					$("#liReserve"+leafId,parent.document).html("<img src='"+baseUrl+"/images/reserve.png' border='0'>");
					$("#liReserve"+leafId,parent.document).prop('title', 'Reserved');
					//document.getElementById('divContributors').innerHTML=HttpContributors.responseText;  
					//Manoj: code for append contributors name 
							/*var contributors_name=HttpContributors.responseText;
							if (contributors_name.indexOf(',') > -1)
							{
								//contributors_name = contributors_name.substring(contributors_name.indexOf(",")+1).trim();
								document.getElementById('docContributors').innerHTML=contributors_name; 
								document.getElementById('seeAll').innerHTML='See all..';
								document.getElementById('contributor_head').innerHTML='';
								$("#docContributors").hide();
							}
							else
							{
								document.getElementById('contributor_head').innerHTML=contributors_name; 
								document.getElementById('seeAll').innerHTML=''; 
								document.getElementById('docContributors').innerHTML='';
							}  */
					
				}
				//alert('test');
				//alert(editBtnHide+'--'+currentNodeId);
				if(editBtnHide==1)
				{
					//alert('enter');
					$("#editDocumentOption"+currentNodeId,parent.document).hide();
				}
				else
				{
					$("#editDocumentOption"+currentNodeId,parent.document).show();
				}
				
				$(".reserveLoader").html("");

				//document.getElementById('contributorsMsg').innerHTML="Contributers updated successfully."; 

				

			//Code for close pop up window	

			//window.top.hidePopWin(true);

		

			}

	 }     

	HttpContributors.send(data);

	

}

function showSearchReservedUsers(treeId)
{

	var toMatch = document.getElementById('showMembers').value;
	
	var leafId = document.getElementById('leafId').value;
	
	var leafOwnerId = document.getElementById('leafOwnerId').value;

	var val = '';

  	urlm=baseUrl+'comman/searchDocsReservedUsers/'+workSpaceId+'/'+workSpaceType;

	data='toMatch='+toMatch+'&treeId='+treeId+'&leafId='+leafId+'&leafOwnerId='+leafOwnerId;

	var xmlHttpRequest = GetXmlHttpObject2();

	xmlHttpRequest.open("POST", urlm, true);

	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	xmlHttpRequest.onreadystatechange = function()

	{
			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				//alert(xmlHttpRequest.responseText);
				//return false;

				document.getElementById("showMem").innerHTML=xmlHttpRequest.responseText;
				 
				var list = $("#reserveduserlist").val();
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
/*Draft feature code end*/

/* Added by Dashrath : code start
This function is used for show hide tree title textarea */

function textAreaOpenHide(treeId)
{
	var checkBox=document.getElementById('copyTree');

	if (checkBox.checked == true)
	{
		if(treeId > 0)
		{
			var request = $.ajax({

			  url: baseUrl+"comman/getTreeNameByTreeId",

			  type: "POST",

			  data: 'treeId='+treeId,

			  dataType: "html",

			  success:function(result){
			  	document.getElementById("treeTitle").value = result;
			  	$(".treeCopyTitle").show();
			  }
			});
		}
		else
		{
			  jAlert("Something went wrong.","Alert");
		}
	} 
	else 
	{
	   $(".treeCopyTitle").hide();
	   document.getElementById("treeTitle").value = "";
	}
}
/* Dashrath : code end */