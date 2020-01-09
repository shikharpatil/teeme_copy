//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.
 /***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: login_check.js
* Description 		  	: Function is defined for validating the user login form fields

* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 18-Aug-2008				Nagalingam						Created the file.
*
**********************************************************************************************************/
//This is the JS function to validate whether the user login inputs are valid 
function loginCheck(frm)
{		
	var obj = frm;		
	res = fieldBlank(obj.userName,'Please enter the user name');
	if(!res)
	{
		return res;
	}	
	
	res = fieldBlank(obj.userPassword,'Please enter the password');
	if(!res)
	{
		return res;
	}
	
}