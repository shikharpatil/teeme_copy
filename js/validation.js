//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.// JavaScript Document
/***********************************************************************************************************
*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
************************************************************************************************************
* Filename				: validation.js
* Description 		  	: Functions are defined for validating the html form fields

* Modification Log
* 	Date                	 Author                       		Description
* ---------------------------------------------------------------------------------------------------------
* 12-Oct-2007				Nagalingam						Created the file.
*
**********************************************************************************************************/

//remove the white sapces from the beginning & end of the string
function trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}

//This is the JS function to validate whether the input is not a empty, 
//if the input is non empty then it will passed to further process else the required input will be ask to the end user
function fieldBlank(fieldName,msg)
{	
	if(trim(fieldName.value)=="")
	{
		jAlert(msg,'Alert');
		fieldName.focus();
		return false;
	}
	else
	{
		return true;
	}	
}

//This is the JS function to validate whether the input is a valid numeric characters, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validNumeric(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		var objRegExp  =  /(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/; 
		if(objRegExp.test(fieldName.value)==true)
		{
			return true;
		}
		else
		{
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
	}
	return true;	
}

//This is the JS function to validate whether the input is a valid format, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function isFormat(str)
{
	strvalue = str;
	var objRegExp = /^\d{3}RR\d{3}$/	 // Sample Format 123RR345
	if (objRegExp.test(strvalue))	
	{				
		return true;		
	}
	else
	{			
		return false;
	}
}

//This is the JS function to validate whether the input is a valid email format, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validEmail(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		var email = fieldName.value;
		var matcharray = email.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/) 
		if(matcharray == null)
		{	
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
		else 
		{
			return true;
		}
	}
	return true;		
}



//This is the JS function to validate whether the input is a valid alphabetic characters, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validAlpha(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		var reAlpha = /^[a-zA-Z ]+$/;	
		if(reAlpha.test(fieldName.value)==true)
		{
			return true;
		}
		else
		{
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
	}
	return true;	
}

//This is the JS function to validate whether the input is a valid alphanumeric characters, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validAlphaNumeric(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		var reAlphanumeric = /^[a-zA-Z0-9_ ]+$/;
		if(reAlphanumeric.test(fieldName.value)==true)
		{
			return true;
		}
		else
		{
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}	
	}
	return true;
}

//This is the JS function to validate whether the input is a valid URL Format, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validURL(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		str = trim(fieldName.value);
		var re;
		re = new RegExp("(http|ftp|https)://[-A-Za-z0-9_/]+[.][-A-Za-z0-9._/]+");
		re1 = new RegExp("[www]+[.][-A-Za-z0-9._/]+");
		if(re.test(str)==false && re1.test(str)==false)
		{			
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
		posOfAtSign = str.indexOf(".")
		if (posOfAtSign == -1)
		{		
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
	}
	return true;
}

//This is the JS function to validate whether the input is a valid Domain Name, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validDomain(fieldName,msg)
{	
	var strURL = trim(fieldName.value);
	if(strURL!="")
	{
		var is_protocol_ok=strURL.indexOf('www');
		var is_dot_ok = strURL.indexOf('.');
		if (((is_protocol_ok==-1) && (is_dot_ok!=-2)) || ((is_protocol_ok!=-1) && (is_dot_ok==-1)))
		{ 
			jAlert(msg+"\n www.test.com","Alert");
			fieldName.focus();
			return false;
		}	
	}
	return true;
}

//This is the JS function to validate whether the input is a valid Phone Number or Fax Number, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validPhoneFax(fieldName,msg)
{
	if(trim(fieldName.value)!="")
	{	
		var regexp=/^(\d{3}-\d{3}-\d{4}|\d{10}|\(\d{3}\)\d{3}-\d{4}|\d{6}|\d{7}|\d{8})$/;
		x = trim(fieldName.value);
		if(!(regexp.test(x)))
		{
			var str = "";
			str = str + msg;
			str = str +  "\n The correct forms are : ";
			str = str + "\n xxx-xxx-xxxx";
			str = str + "\n (xxx)xxx-xxxx";
			str = str + "\n xxxxxxxxxx (10 digits no)";
			str = str + "\n xxxxxx (6 digits no)";
			str = str + "\n xxxxxxx (7 digits no)";
			str = str + "\n xxxxxxxx (8 digits no)";
			jAlert(str,'Alert');
			fieldName.select();
			return false; 
		}
	}
	return true;
}

//This is the JS function to validate whether the alphabetic characters input within the specified length, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validAlphaLength(fieldName,msg,start,end)
{	
	if(trim(fieldName.value)!="")
	{	
		if(validAlpha(fieldName,'Please enter the only alphabetic characters')==true)
		{
			if(end!=null && start!=null)
			{
				if(fieldName.value.length>=start && fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else if(end!=null && start==null)
			{
				if(fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else
			{
				if(fieldName.value.length>=start)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}		
		}
		else
		{			
			return false;
		}
	}
	return true;
}

//This is the JS function to validate whether the alphanumeric characters input within the specified length, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validAlphaNumericLength(fieldName,msg,start,end)
{	
	if(trim(fieldName.value)!="")
	{	
		if(validAlphaNumeric(fieldName,'Please enter only alphanumeric characters')==true)
		{
			if(end!=null && start!=null)
			{
				if(fieldName.value.length>=start && fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else if(end!=null && start==null)
			{
				if(fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else
			{
				if(fieldName.value.length>=start)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}		
		}
		else
		{			
			return false;
		}	
	}
	return true;
}

//This is the JS function to validate whether the Numeric characters input within the specified length, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validNumericLength(fieldName,msg,start,end)
{
	if(trim(fieldName.value)!="")
	{		
		if(validNumeric(fieldName,'Please enter only numeric characters')==true)
		{
			if(end!=null && start!=null)
			{
				if(fieldName.value.length>=start && fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else if(end!=null && start==null)
			{
				if(fieldName.value.length<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else
			{
				if(fieldName.value.length>=start)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}		
		}
		else
		{			
			return false;
		}
	}
	return true;	
}

//This is the JS function to validate whether the input within the specified length, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validFieldLength(fieldName,msg,start,end)
{
	if(trim(fieldName.value)!="")
	{		
		if(end!=null && start!=null)
		{
			if(fieldName.value.length>=start && fieldName.value.length<=end)
			{
				return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName.select();
				return false;				
			}
		}
		else if(end!=null && start==null)
		{
			if(fieldName.value.length<=end)
			{
				return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName.select();
				return false;				
			}
		}
		else
		{
			if(fieldName.value.length>=start)
			{
				return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName.select();
				return false;				
			}
		}		
		
	}
	return true;	
}

//This is the JS function to validate whether the intger & float numbers input within the specified length, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validRange(fieldName,msg,start,end)
{

	if(trim(fieldName.value)!="")
	{	
		if(validInteger(fieldName,null)==true || validFloat(fieldName,null)==true)
		{
			if(end!=null && start!=null)
			{
				if(fieldName.value>=start && fieldName.value<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else if(end!=null && start==null)
			{
				if(fieldName.value<=end)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}
			else
			{
				if(fieldName.value>=start)
				{
					return true;
				}
				else
				{
					jAlert(msg,'Alert');
					fieldName.select();
					return false;				
				}
			}	
		}
		else
		{				
			jAlert('Please enter valid integer or float number','Alert');
			fieldName.select();
			return false;								
		}
	}
	return true;	
}

//This is the JS function to compare the two fields input, 
//if the result is valid it will be passed to further process else the required input will be ask to the end user
function compareFields(fieldName1,fieldName2,cmp,msg)
{

	if(trim(fieldName1.value)!="" && trim(fieldName1.value)!="")
	{
			
		if(cmp=="=")
		{
			if(fieldName1.value==fieldName2.value)
			{				
				return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName1.select();
				return false;				
			}
		}
		else if(cmp==">")
		{
			if(fieldName1.value>fieldName2.value)
			{
				
					return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName1.select();
				return false;				
			}
		}
		else if(cmp=="<")
		{
			if(fieldName1.value<fieldName2.value)
			{
				
					return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName1.select();
				return false;				
			}
		}
		else if(cmp=="<=")
		{
			if(fieldName1.value<=fieldName2.value)
			{
				
					return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName1.select();
				return false;				
			}
		}
		else if(cmp==">=")
		{
			if(fieldName1.value>=fieldName2.value)
			{
				
					return true;
			}
			else
			{
				jAlert(msg,'Alert');
				fieldName1.select();
				return false;				
			}
		}	
		
			
	}
	return true;	
}

//This is the JS function to validate whether the file is in the specified format, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validFileFormat(fieldName,format)
{	
	var valid = 0;
	var msg = "";
	var farray = format.split('|');
	//alert(farray);
	if(fieldName.value.length>0)
	{		
		fname = fieldName.value.split('.')
		var length = fname.length;		
		for(var i=0;i<farray.length;i++)
		{	
			if(farray.length>0)
			{	
				if(fname[length-1] == farray[i])
				{
					valid=valid+1;						
				}		
				else
				{
					if(i!=(farray.length-1))
					{
						msg = msg+farray[i]+", ";
					}
					else
					{
						msg = msg+farray[i];
					}	
				}		
				
			}
			else
			{
				msg=msg+farray[i];
			}
		}			
		if(valid==0)
		{
			msg = "Please attach "+msg+" format file only";
			jAlert(msg,'Alert');
			fieldName.select();
			return false;
		}
		else
		{
			return true;
		}			
	}
	return true;	
}

//This is the JS function to validate whether the input is a floating point number, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validFloat(fieldName,msg)
{
	re= /^((\d+(\.\d*)?)|((\d*\.)?\d+))$/;
	if(trim(fieldName.value)!="")
	{	
		if(re.test(fieldName.value)==false)
		{
			if(msg!=null)
			{
				jAlert(msg,'Alert');
			}
			fieldName.select();
			return false;
		}
	}
	return true;
}

//This is the JS function to validate whether the input is a valid integer number, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function validInteger(fieldName,msg)
{
	re = /^\d+$/;
	if(trim(fieldName.value)!="")
	{	
		if(re.test(fieldName.value)==false)
		{
			if(msg!=null)
			{
				jAlert(msg,'Alert');
			}
			fieldName.select();
			return false;
		}
	}
	return true;
}

//This is the JS function to validate whether the radio button is selected, 
//if the input is valid it will be passed to further process else the required input will be ask to the end user
function chkRadio(fieldName,msg)
{	
	var cnt = -1;
    for (var i=fieldName.length-1; i > -1; i--) 
	{
        if (fieldName[i].checked) 
		{
			cnt = i; 
			i = -1;
		}
    }
    if (cnt > -1) 
	{
		
		return true;
	}
	else
	{
		jAlert(msg,'Alert');		
		return false;				
	}
	
}