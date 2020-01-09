//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.// JavaScript Document



function showProfileDetails()
{		

	
	if (document.getElementById('profileDetails'))
	{

		var obj = document.getElementById('profileDetails'); 
	
		//var obj1 = document.getElementById('profileDetailsEdit'); 
	
		//var objHideShow = document.getElementById('hideShowDetails');
	
		//document.getElementById('0notes').style.display='none';
	
			if(obj.style.display == 'none')
			{
		
				obj.style.display = '';
		
				//obj1.style.display = 'none';
		
				//objHideShow.innerHTML = '<img border="0" title="Hide Details" src="'+baseUrl+'/images/hide_icon.png">';
			}
		
			else
			{
		
				obj.style.display = 'none';
		
				//obj1.style.display = 'none';
		
				//objHideShow.innerHTML = '<img border="0" title="View Full Details" src="'+baseUrl+'/images/show_icon.png">';	
			}
	}
	
	document.getElementById('det').style.display='none'; 
	

}



function changViewProfileLabel()
{		
	if (document.getElementById('hideShowDetails'))
	{	
		var obj = document.getElementById('hideShowDetails'); 
	
		if(obj.innerHTML == '<img title="Hide Details" src="'+baseUrl+'/images/hide_icon.png" border="0">')
		{
			obj.innerHTML = '<img border="0" title="View Full Details" src="'+baseUrl+'/images/show_icon.png">';
		}
	}
}



function profileEdit()

{	

	var obj = document.getElementById('profileDetailsEdit'); 

	var obj1 = document.getElementById('profileDetails'); 

	var objHideShow = document.getElementById('hideShowDetails');

	document.getElementById('0notes').style.display='none';

	

	

	if(obj.style.display == 'none')

	{

		obj.style.display = '';

		obj1.style.display = 'none';

		objHideShow.innerHTML = '<img title="Hide Details" src="'+baseUrl+'/images/hide_icon.png" border="0">';

		

	}

	else

	{

		obj.style.display = 'none';

		obj1.style.display = 'none';

		objHideShow.innerHTML = '<img title="Hide Details" src="'+baseUrl+'/images/hide_icon.png" border="0">';	

	}

	changViewProfileLabel();

	

}



function reply(id, focusId, workSpaceId)

{	

	divid=id+'notes';

	

	//document.getElementById('notesFocus').value = id;

	//document.getElementById('profileDetailsEdit').style.display='none';

	//document.getElementById('profileDetails').style.display='none';

	document.getElementById('viewMore').style.display='none';

	//document.getElementById('det').style.display='block';

	if(CKEDITOR.instances['replyDiscussion0']){

		editorClose('replyDiscussion0');

	}

	

	//document.getElementById('profileDetails').style.display='none';

	if(document.getElementById(divid).style.display=='block')

	{

	   document.getElementById(divid).style.display= 'none';

	   document.getElementById('allComment').style.display='block';

	   if(workSpaceId==0)

	   {

	       if($('#curr').hasClass('active'))

		   {

				$('#curr').removeClass('active');

		   }

		   if($('#add').hasClass('active'))

		   {

			   $('#add').removeClass('active');

		   }

		   $('#all').addClass('active');

	   }

	   else

	   {

		   if($('#all').hasClass('active'))

		   {

				$('#all').removeClass('active');

		   }

		   if($('#add').hasClass('active'))

		   {

			   $('#add').removeClass('active');

		   }

		   $('#curr').addClass('active');	

	   }

	}

	else

	{

	   $('.allComment').hide();

	   document.getElementById(divid).style.display='block';

	   if($('#all').hasClass('active'))

	   {

		    $('#all').removeClass('active');

			$('#all').css({'bacground':'none'});

	   }

	   if($('#curr').hasClass('active'))

	   {

		   $('#curr').removeClass('active');

	   }

	   $('#add').addClass('active');

	   changViewProfileLabel();

	}



	

	

	// ----------------------------------------------------------- Commented by arun --------------------------------- /*

	

	/*

	parent.frames[focusId].gk.EditingArea.focus();

	whofocus=focusId;

	rameid=id;	

	frameIndex = focusId;

	document.getElementById('currentMenus').style.display = '';

	document.getElementById('searchSpan').innerHTML = '<div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div>&nbsp;<img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,'+frameIndex+');" src="'+baseURL+'/images/icon-replace.jpg" height="19"   /><div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText1" id="searchText1'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Replace_With_caption+': <input type="text" size="7" name="replaceText" id="replaceText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType1" id="sType1'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="checkbox" name="rType1" id="rType1'+frameIndex+'" value="1" /> '+Replace_All_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Replace_caption+'"  onclick="gotoReplace('+frameIndex+',document.getElementById(\'searchText1'+frameIndex+'\').value,document.getElementById(\'replaceText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div>';

	

	document.getElementById('saveOption').innerHTML = '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td colspan="2" align="center"><a href="#" onClick="return saveNotes()"><img src="'+baseUrl+'images/done-btn.jpg" border="0" /></a></td></tr><tr><td colspan="2" align="center"><a href="javascript:void(0)" onClick="reply_close('+id+')"><img src="'+baseUrl+'images/btn-cancel.jpg" width="52" height="16" border="0" /></a></td></tr><tr><td colspan="2" align="center">&nbsp;</td></tr></table>';

	*/ 

		chnage_textarea_to_editor('replyDiscussion0');

	

}

function reply_close(id)

{

	divid	= id+'notes';

 	document.getElementById(divid).style.display = 'none';

	document.getElementById('currentMenus').style.display = 'none';

	document.getElementById('saveOption').innerHTML = '';

	

}

// This is a js function used to submit the notes form to save

function saveNotes()

{

	var frm = parseInt(document.getElementById('notesFocus').value);	

	var replyDiscussion1	= 'replyDiscussion'+frm+'1';

	if(document.getElementById(replyDiscussion1).value=='<DIV id=1-span><P>&nbsp;</P></DIV>')

	{

		jAlert('Please enter the note','Alert');

		return false;

	}

	else

	{

		frm = frm+1;

		document.forms[frm].submit();

	}

}



function vksfun(focusId)

{

	

	whofocus=focusId;

}

function showNotesNodeOptions(position)

{		

	if(position > 0)

	{

		document.getElementById('normalView0').style.display = "none";

	}

	

	var notesId = 'normalView'+position;		

	if(document.getElementById(notesId).style.display == "none")

	{			

		document.getElementById(notesId).style.display = "";

	}

	else

	{

		document.getElementById(notesId).style.display = "none";

	}

	var allNodes 	= document.getElementById('totalNodes').value;

	var arrNodes 	= new Array();

	arrNodes 		= allNodes.split(',');



	for(var i = 0;i<arrNodes.length;i++)

	{		

		if(position != arrNodes[i])

		{

			var notesId = 'normalView'+arrNodes[i];	

			document.getElementById(notesId).style.display = "none";

		}

	}

	

}





	

function confirmConvertMessageToDiscuss ()

	{

		

		if (confirm("Are you sure you want to convert comment into discuss ?"))

		{

			return true;

		}

		else

		{

			return false ;

		}

	}	

	

function confirmDeleteMessageComment()

{

	if (confirm("Are you sure you want to Delete Comment ?"))

	{

		return true;

	}

	else

	{

		return false ;

	}



}



function removeSearh()

{

	if(document.getElementById('search').value=='Search')

	document.getElementById('search').value='';

}

	

function writeSearh()

{

	if(document.getElementById('search').value=='')

		document.getElementById('search').value='Search';

}	





