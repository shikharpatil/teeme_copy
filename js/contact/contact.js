//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.// JavaScript Document



function showContactDetails()

{	

   

	var obj = document.getElementById('contactDetails'); 

	var obj1 = document.getElementById('contactDetailsEdit'); 

	var objHideShow = document.getElementById('hideShowDetails');

	if(obj.style.display == 'none')

	{

		obj.style.display = 'block';

		obj1.style.display = 'none';

		/*Commented by Dashrath- comment old button code and add new code below with expand icon*/
		// objHideShow.innerHTML = '<input type="button" name="view_details" value="Hide Details">';

		/*Added by Dashrath- Add new code for show expand icon*/
		objHideShow.innerHTML = '<input type="image" name="view_details" src="'+baseUrl+'images/collapse_icon_new.png">';	
		/*Dashrath- code end*/


	}

	else

	{

		obj.style.display = 'none';

		obj1.style.display = 'none';

		/*Commented by Dashrath- comment old button code and add new code below with expand icon*/
		// objHideShow.innerHTML = '<input type="button" name="view_details" value="View Details">';

		/*Added by Dashrath- Add new code for show expand icon*/
		objHideShow.innerHTML = '<input type="image" name="view_details" src="'+baseUrl+'images/expand_icon_new.png">';	
		/*Dashrath- code end*/
	}

	

}

function showContactDetails_new()

{	

   

	var obj = document.getElementById('contactDetails'); 

	var obj1 = document.getElementById('contactDetailsEdit'); 

	var objHideShow = document.getElementById('hideShowDetails');

	if(obj.style.display == 'none')

	{

		obj.style.display = '';

		obj1.style.display = 'none';

		objHideShow.innerHTML = 'Hide Details';

	}

	else

	{

		obj.style.display = 'none';

		obj1.style.display = 'none';

		objHideShow.innerHTML = 'View Details';	

	}

	

}



function contactEdit()

{	

	var obj = document.getElementById('contactDetailsEdit'); 

	var obj1 = document.getElementById('contactDetails'); 

	var objHideShow = document.getElementById('hideShowDetails');

	

	if(obj.style.display == 'none')

	{

		obj.style.display = '';

		obj1.style.display = 'none';

		/*Commented by Dashrath- comment old Hide Details code and add new code below with collapse icon*/
		// objHideShow.innerHTML = 'Hide Details';

		/*Added by Dashrath- Add new code for show collapse icon*/
		objHideShow.innerHTML = '<input type="image" name="view_details" src="'+baseUrl+'images/collapse_icon_new.png">';	
		/*Dashrath- code end*/

	}

	else

	{

		obj.style.display = 'none';

		obj1.style.display = '';

		/*Commented by Dashrath- comment old Hide Details code and add new code below with collapse icon*/
		// objHideShow.innerHTML = 'Hide Details';	

		/*Added by Dashrath- Add new code for show collapse icon*/
		objHideShow.innerHTML = '<input type="image" name="view_details" src="'+baseUrl+'images/collapse_icon_new.png">';	
		/*Dashrath- code end*/

	}
	
	//Reset contact edit form on cancel button
	
	document.getElementById('contactDetailsEditForm').reset();

	

}



function reply(id, focusId)

{  

	divid=id+'notes';	

	document.getElementById('notesFocus').value = id;

	document.getElementById(divid).style.display='';



	parent.frames[focusId].gk.EditingArea.focus();

	whofocus=focusId;

	rameid=id;	

	frameIndex = focusId;

	document.getElementById('currentMenus').style.display = '';

	document.getElementById('searchSpan').innerHTML = '<div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div>&nbsp;<img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,'+frameIndex+');" src="'+baseURL+'/images/icon-replace.jpg" height="19"   /><div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText1" id="searchText1'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Replace_With_caption+': <input type="text" size="7" name="replaceText" id="replaceText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType1" id="sType1'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="checkbox" name="rType1" id="rType1'+frameIndex+'" value="1" /> '+Replace_All_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Replace_caption+'"  onclick="gotoReplace('+frameIndex+',document.getElementById(\'searchText1'+frameIndex+'\').value,document.getElementById(\'replaceText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div>';

	//document.write('<div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv'+whofocus+'"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText1'+whofocus+'"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText'+whofocus+'"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType1'+whofocus+'" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType1'+whofocus+'" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\''+whofocus+'\',document.getElementById(\'searchText1'+whofocus+'\').value,document.getElementById(\'replaceText'+whofocus+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\''+whofocus+'\');" ></td></tr></table></div>');

	//document.write('<div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+whofocus+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+whofocus+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+whofocus+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+whofocus+',document.getElementById(\'searchText'+whofocus+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="findtextbox(0,'+whofocus+');" >&nbsp;&nbsp;</div>&nbsp;');

	

			/*document.getElementById('currentMenus').innerHTML = '<img src="'+baseUrl+'images/bold.jpg" name="Boldcmd" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" alt="Bold" onclick="parent.frames['+whofocus+'].gk.editing(\'Bold\');"><img id="Italiccmd" name="Italiccmd" src="'+baseUrl+'images/italic.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Italic" onclick="parent.frames['+whofocus+'].gk.editing(\'Italic\');" class="editorCursor"><br><img id="Underlinecmd" name="Underlinecmd"  src="'+baseUrl+'images/underline.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Underline" onclick="parent.frames['+whofocus+'].gk.editing(\'Underline\');" class="editorCursor"><img id="Copycmd" name="Copycmd"  src="'+baseUrl+'images/copy.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Copy" onclick="parent.frames['+whofocus+'].gk.editing(\'Copy\');" class="editorCursor"><br><img src="'+baseUrl+'images/ref-l.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Undo" onclick="parent.frames['+whofocus+'].gk.undofunction();" id="undocmd" class="editorCursor"><img src="'+baseUrl+'images/ref-r.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Redo" onclick="parent.frames['+whofocus+'].gk.redofunction();" id="redoccmd" class="editorCursor"><br><img id="Cutcmd" name="Cutcmd" src="'+baseUrl+'images/del.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Cut" onclick="parent.frames['+whofocus+'].gk.editing(\'Cut\');" class="editorCursor"><img id="Pastecmd" name="Pastecmd"  src="'+baseUrl+'images/paste.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Paste" onclick="parent.frames['+whofocus+'].gk.editing(\'Paste\');" class="editorCursor"><br><img id="tablecmd" name="tablecmd" onclick="parent.frames['+whofocus+'].gk.tableHandle();" src="'+baseUrl+'editor/images/toolbar/table.gif" hspace="4" vspace="3" height="19" width="23" alt="Insert Table"><img id="backcolorcmd" name="backcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'backcolor\');" src="'+baseUrl+'images/background-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Set Background Color"/><br><img id="fontcolorcmd" name="fontcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'forecolor\');" src="'+baseUrl+'images/text-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Text Color"><img id="subscriptcmd" name="subscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'subscript\');" src="'+baseUrl+'images/subscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Subscript"/><br><img id="superscriptcmd" name="superscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'superscript\');" src="'+baseUrl+'images/superscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Superscript"><img id="strikethroughcmd" name="strikethroughcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'strikethrough\');" src="'+baseUrl+'images/strikethrough.jpg" hspace="4" vspace="3" height="19" width="23" alt="Strikethrough"/><br><img id="indentcmd" name="indentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'indent\');" src="'+baseUrl+'images/indent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Indent"><img id="outdentcmd" name="outdentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'outdent\');" src="'+baseUrl+'images/outdent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Outdent"/><br><img id="olcmd" name="olcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertorderedlist\');" src="'+baseUrl+'images/number-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Numbered Bullets"><img id="uolcmd" name="uolcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertunorderedlist\');" src="'+baseUrl+'images/round-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Bullets"/><br><img id="justifyfullcmd" name="justifyfullcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyfull\');" src="'+baseUrl+'images/justifyfull.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify"><img id="justifyleftcmd" name="justifyleftcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyleft\');" src="'+baseUrl+'images/justifyleft.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Left"/><br><img id="justifycentercmd" name="justifycentercmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifycenter\');" src="'+baseUrl+'images/justifycenter.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Center"><img id="justifyrightcmd" name="justifyrightcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyright\');" src="'+baseUrl+'images/justifyright.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Right"/><br><img id="insertImagecmd" name="insertImagecmd" onclick="parent.frames['+whofocus+'].gk.insertImage();" src="'+baseUrl+'images/insertImage.jpg" hspace="4" vspace="3" height="19" width="23" alt="Insert Image"><img id="WPastecmd" name="WPastecmd" onclick="parent.frames['+whofocus+'].gk.copyfromWord();" src="'+baseUrl+'images/copyfromWord.jpg" hspace="4" vspace="3" height="19" width="23" alt="Copy from Word"/><div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv0"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText10"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText0"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType10" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType10" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\'0\',document.getElementById(\'searchText10\').value,document.getElementById(\'replaceText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\'0\');" ></td></tr></table></div><br><img id="makeLinkcmd" name="makeLinkcmd" onclick="parent.frames['+whofocus+'].gk.makeLink();" src="'+baseUrl+'images/makeLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Create Link"><img id="unLinkcmd" name="unLinkcmd" onclick="parent.frames['+whofocus+'].gk.unLink1();" src="'+baseUrl+'images/unLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Unlink"/><br><img id="findtextcmd" name="findtextcmd" onclick="findtextbox(1,\'0\')" src="'+baseUrl+'images/icon-search.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find"><img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,\'0\')" src="'+baseUrl+'images/icon-replace.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find & Replace"/><div style="position:absolute; margin-top:-80px; margin-left:-75px; border:#666666; width:150px;border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'" onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div><br>';*/

	document.getElementById('saveOption').innerHTML = '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td colspan="2" align="center"><a href="#" onClick="return saveNotes()"><img src="'+baseUrl+'images/done-btn.jpg" border="0" /></a></td></tr><tr><td colspan="2" align="center"><a href="javascript:void(0)" onClick="reply_close('+id+')"><img src="'+baseUrl+'images/btn-cancel.jpg" width="52" height="16" border="0" /></a></td></tr><tr><td colspan="2" align="center">&nbsp;</td></tr></table>';	

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

		jAlert('Please enter the note',"Alert");

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
  // if(nodeOptionsVisible!=position )

	//{

		var notesId = 'normalView'+position;

		document.getElementById(notesId).style.display = "block";

		document.getElementById("ulNodesHeader"+position).style.display = "block";

		clickEvent=position;
	//}
/*	if(position > 0)

	{

		document.getElementById('normalView0').style.display = "none";

	}

	

	var notesId = 'normalView'+position;		
	//alert (notesId);

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

	}*/

	

}



function treeOperationsContact(object,operation,treeId)

	{  

	

	  	document.getElementById('aMove').className='';

		

	   	object.className="hiLite";

	    if(operation=='move')

	  	{

		  document.getElementById('ulTreeOption').style.display='none';

		  //document.getElementById('spanMoveTree').style.display='block';
		  
		  showPopWin(baseUrl+'comman/getMoveSpaceLists/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,450, 350, null, '');

		  

		 }

		 

		

	   

		

		 

		 else

		 {

			 

			  document.getElementById('spanMoveTree').style.display='none';	

		 //return false;

		 }

	

	}

	

