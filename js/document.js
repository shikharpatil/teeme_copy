//Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.

 /***********************************************************************************************************

*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

************************************************************************************************************

* Filename				: document.js

* Description 		  	: This is a js file having lot of js functions to handle the teeme docuemnt module functionalities.

* Global Variables	  	:leafHeaderId,leafContentId ,expandSpanId, hiddenId,spanFooterId1, nodeId1, leafId1, treeId1, leafOrder1, whofocus1, timeOut, timeInit, curLeafId1

* 

* Modification Log

* 	Date                	 Author                       		Description

* ---------------------------------------------------------------------------------------------------------

* 14-August-2008				Nagalingam						Created the file.

*

**********************************************************************************************************/

	var leafHeaderId = ""; //Global js variable used to store the span id for leaf header information

	var leafContentId = "";//Global js variable used to store the span id for leaf content information

	var expandSpanId = ""; //Global js variable used to store the expand id for leaf

	var hiddenId = "";//Global js variable used to store the leaf content hidden field id

	var spanFooterId1 = "";//Global js variable used to store the span id of each footer

	var nodeId1 = "";//Global js variable used to store the node id of current selected leaf

	var leafId1 = "";//Global js variable used to store the leaf id of current leaf

	var treeId1 = "";//Global js variable used to store the tree id of selected leaf

	var leafOrder1 = "";//Global js variable used to store the leaf order of current selected leaf

	var whofocus1 = "";	//Global js variable used to store the frame id of current selected leaf	

	var timeOut = 0;//Global js variable used to store the timeour status for auto leaf saving feature

	var timeInit = 0;//Global js variable used to store the timeour status for auto leaf saving feature

	var curLeafId1 = "";//Global js variable used to store the current selected leaf id

	var curNodeOrder = 1;

	// this is a js function used to add the new leaf just after the selected leaf

	function addLeaf_old2(leafId, treeId, leafOrder, spanFooterId, nodeId,whofocus) 

	{	

		document.getElementById('leafAddFirst').style.display="none";	

		document.getElementById('saveOption').innerHTML = '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="newLeafSave(\''+leafOrder+'\',\''+leafId+'\',\''+treeId+'\',\''+nodeId+'\')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td></tr><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="cancelNewLeaf(\''+leafId+'\',\''+leafOrder+'\',\''+spanFooterId+'\',\''+treeId+'\',\''+nodeId+'\',\''+whofocus+'\')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

		who_focus = whofocus;		

		document.getElementById('currentMenus').style.display = '';

		/*document.getElementById('currentMenus').innerHTML = '<img src="'+baseUrl+'images/bold.jpg" name="Boldcmd" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" alt="Bold" onclick="parent.frames['+whofocus+'].gk.editing(\'Bold\');"><img id="Italiccmd" name="Italiccmd" src="'+baseUrl+'images/italic.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Italic" onclick="parent.frames['+whofocus+'].gk.editing(\'Italic\');" class="editorCursor"><br><img id="Underlinecmd" name="Underlinecmd"  src="'+baseUrl+'images/underline.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Underline" onclick="parent.frames['+whofocus+'].gk.editing(\'Underline\');" class="editorCursor"><img id="Copycmd" name="Copycmd"  src="'+baseUrl+'images/copy.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Copy" onclick="parent.frames['+whofocus+'].gk.editing(\'Copy\');" class="editorCursor"><br><img src="'+baseUrl+'images/ref-l.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Undo" onclick="parent.frames['+whofocus+'].gk.undofunction();" id="undocmd" class="editorCursor"><img src="'+baseUrl+'images/ref-r.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Redo" onclick="parent.frames['+whofocus+'].gk.redofunction();" id="redoccmd" class="editorCursor"><br><img id="Cutcmd" name="Cutcmd" src="'+baseUrl+'images/del.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Cut" onclick="parent.frames['+whofocus+'].gk.editing(\'Cut\');" class="editorCursor"><img id="Pastecmd" name="Pastecmd"  src="'+baseUrl+'images/paste.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Paste" onclick="parent.frames['+whofocus+'].gk.editing(\'Paste\');" class="editorCursor"><br><img id="tablecmd" name="tablecmd" onclick="parent.frames['+whofocus+'].gk.tableHandle();" src="'+baseUrl+'editor/images/toolbar/table.gif" hspace="4" vspace="3" height="19" width="23" alt="Insert Table"><img id="backcolorcmd" name="backcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'backcolor\');" src="'+baseUrl+'images/background-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Set Background Color"/><br><img id="fontcolorcmd" name="fontcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'forecolor\');" src="'+baseUrl+'images/text-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Text Color"><img id="subscriptcmd" name="subscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'subscript\');" src="'+baseUrl+'images/subscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Subscript"/><br><img id="superscriptcmd" name="superscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'superscript\');" src="'+baseUrl+'images/superscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Superscript"><img id="strikethroughcmd" name="strikethroughcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'strikethrough\');" src="'+baseUrl+'images/strikethrough.jpg" hspace="4" vspace="3" height="19" width="23" alt="Strikethrough"/><br><img id="indentcmd" name="indentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'indent\');" src="'+baseUrl+'images/indent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Indent"><img id="outdentcmd" name="outdentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'outdent\');" src="'+baseUrl+'images/outdent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Outdent"/><br><img id="olcmd" name="olcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertorderedlist\');" src="'+baseUrl+'images/number-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Numbered Bullets"><img id="uolcmd" name="uolcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertunorderedlist\');" src="'+baseUrl+'images/round-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Bullets"/><br><img id="justifyfullcmd" name="justifyfullcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyfull\');" src="'+baseUrl+'images/justifyfull.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify"><img id="justifyleftcmd" name="justifyleftcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyleft\');" src="'+baseUrl+'images/justifyleft.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Left"/><br><img id="justifycentercmd" name="justifycentercmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifycenter\');" src="'+baseUrl+'images/justifycenter.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Center"><img id="justifyrightcmd" name="justifyrightcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyright\');" src="'+baseUrl+'images/justifyright.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Right"/><br><img id="insertImagecmd" name="insertImagecmd" onclick="parent.frames['+whofocus+'].gk.insertImage();" src="'+baseUrl+'images/insertImage.jpg" hspace="4" vspace="3" height="19" width="23" alt="Insert Image"><img id="WPastecmd" name="WPastecmd" onclick="parent.frames['+whofocus+'].gk.copyfromWord();" src="'+baseUrl+'images/copyfromWord.jpg" hspace="4" vspace="3" height="19" width="23" alt="Copy from Word"/><div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv0"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText10"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText0"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType10" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType10" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\'0\',document.getElementById(\'searchText10\').value,document.getElementById(\'replaceText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\'0\');" ></td></tr></table></div><br><img id="makeLinkcmd" name="makeLinkcmd" onclick="parent.frames['+whofocus+'].gk.makeLink();" src="'+baseUrl+'images/makeLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Create Link"><img id="unLinkcmd" name="unLinkcmd" onclick="parent.frames['+whofocus+'].gk.unLink1();" src="'+baseUrl+'images/unLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Unlink"/><br><img id="findtextcmd" name="findtextcmd" onclick="findtextbox(1,\'0\')" src="'+baseUrl+'images/icon-search.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find"><img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,\'0\')" src="'+baseUrl+'images/icon-replace.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find & Replace"/><div style="position:absolute; margin-top:-80px; margin-left:-75px; border:#666666; width:150px;border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'" onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div><br>';*/

		//document.getElementById('saveOption').innerHTML = '<a href="#" onclick="leafSave(\''+leafOrder1+'\',\''+leafId1+'\',\''+treeId1+'\',\''+nodeId1+'\')">Done</a><br><a href="javascript:void(0)" onclick="cancelEdit(\''+leafId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+treeId1+'\',\''+nodeId1+'\',\''+whofocus1+'\')">Cancel</a>&nbsp;&nbsp;&nbsp; <span id="saveId" class="savedText"></span>';		

		document.getElementById(spanFooterId).innerHTML = '';	

		document.getElementById('discuss'+leafOrder).style.display = 'none';

		document.getElementById('chat'+leafOrder).style.display = 'none';

		document.getElementById('tag'+leafOrder).style.display = 'none';

		var arrLeafIds = new Array();

		arrLeafIds = document.getElementById('allLeafs').value.split(',');

		var iframeId = 'editorLeafContentsAdd'+leafOrder;

		for(var i=0;i<arrLeafIds.length;i++)

		{			

			var spanFooterLeafId = 'spanFooterLeaf'+arrLeafIds[i];

			var expandSpanId = 'expandId'+arrLeafIds[i];

			var leafHeaderId = 'leafHeader'+arrLeafIds[i];

			var leafContentId = 'leafContent'+arrLeafIds[i];

			var editId = 'leafEdit'+arrLeafIds[i];	

			var leafAddId = 'leafAdd'+arrLeafIds[i];	

			var spanArtifactLinks = 'spanArtifactLinks'+arrLeafIds[i];			

			var obj1 = document.getElementById(spanFooterLeafId);

			var obj2 = document.getElementById(expandSpanId);

			var obj3 = document.getElementById(leafHeaderId);

			var obj4 = document.getElementById(editId);		

			var obj5 = document.getElementById(leafContentId);

			var obj6 = document.getElementById(leafAddId);

			var obj7 = document.getElementById(spanArtifactLinks);											

			obj1.style.display = "none"; 	

			obj2.style.display = "none"; 

			obj3.style.display = "none"; 

			obj4.style.display = "none";

			obj5.style.display = "";	

			obj6.style.display = "none";	

			obj7.style.display = "none";						 

		}		

		var divId = 'leafAdd'+leafOrder;

		obj=document.getElementById(divId);

		obj.style.display="";

		parent.frames[whofocus].gk.EditingArea.focus();

		document.getElementById(iframeId).src = baseURL+'/editor/TeemeEditor.php?textAreaName=editorLeafContentsAdd'+leafOrder+'&id=0&idea=0';	

		

	}

	// this is a js function used for edit the current selected leaf

	function editLeaf(leafId, leafOrder, spanFooterId, treeId, nodeId, whofocus) 

	{	

		

		document.getElementById('leafAddFirst').style.display="none";			

		if(document.getElementById('editStatus').value == 1)

		{

			jAlert('Please save or close the current leaf before accessing another leaf','Alert');

			return false;

		}

		var editorId = "editorLeafContents"+leafOrder+"1";		

		var getvalue=document.getElementById(editorId).value;	

		//var tmpId = 'curContent'+nodeId;

		//alert(document.getElementById(tmpId).value);

		leafId1 = leafId;	

		nodeId1 = nodeId;		

		treeId1 = treeId;

		

		leafOrder1 = leafOrder;

		whofocus1 = whofocus;	

		var arrLeafIds = new Array();

		arrLeafIds = document.getElementById('allLeafs').value.split(',');

		for(var i=0;i<arrLeafIds.length;i++)

		{

			if(arrLeafIds[i] != leafOrder1)

			{

				var spanFooterLeafId = 'spanFooterLeaf'+arrLeafIds[i];

				var expandSpanId = 'expandId'+arrLeafIds[i];

				var leafHeaderId = 'leafHeader'+arrLeafIds[i];

				var leafContentId = 'leafContent'+arrLeafIds[i];

				var editId = 'leafEdit'+arrLeafIds[i];				

				var leafAddId = 'leafAdd'+arrLeafIds[i];	

				var spanArtifactLinks = 'spanArtifactLinks'+arrLeafIds[i];			

				var obj1 = document.getElementById(spanFooterLeafId);

				var obj2 = document.getElementById(expandSpanId);

				var obj3 = document.getElementById(leafHeaderId);

				var obj4 = document.getElementById(editId);		

				var obj5 = document.getElementById(leafContentId);

				var obj6 = document.getElementById(leafAddId);	

				var obj7 = document.getElementById(spanArtifactLinks);									

				obj1.style.display = "none"; 	

				obj2.style.display = "none"; 

				obj3.style.display = "none"; 

				obj4.style.display = "none";

				obj5.style.display = "";	

				obj6.style.display = "none";	

				obj7.style.display = "none";									

			}	 

		}	

		who_focus = whofocus;		

		document.getElementById('currentMenus').style.display = '';

		/*document.getElementById('currentMenus').innerHTML = '<img src="'+baseUrl+'images/bold.jpg" name="Boldcmd" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" alt="Bold" onclick="parent.frames['+whofocus+'].gk.editing(\'Bold\');"><img id="Italiccmd" name="Italiccmd" src="'+baseUrl+'images/italic.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Italic" onclick="parent.frames['+whofocus+'].gk.editing(\'Italic\');" class="editorCursor"><br><img id="Underlinecmd" name="Underlinecmd"  src="'+baseUrl+'images/underline.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Underline" onclick="parent.frames['+whofocus+'].gk.editing(\'Underline\');" class="editorCursor"><img id="Copycmd" name="Copycmd"  src="'+baseUrl+'images/copy.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Copy" onclick="parent.frames['+whofocus+'].gk.editing(\'Copy\');" class="editorCursor"><br><img src="'+baseUrl+'images/ref-l.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Undo" onclick="parent.frames['+whofocus+'].gk.undofunction();" id="undocmd" class="editorCursor"><img src="'+baseUrl+'images/ref-r.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Redo" onclick="parent.frames['+whofocus+'].gk.redofunction();" id="redoccmd" class="editorCursor"><br><img id="Cutcmd" name="Cutcmd" src="'+baseUrl+'images/del.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Cut" onclick="parent.frames['+whofocus+'].gk.editing(\'Cut\');" class="editorCursor"><img id="Pastecmd" name="Pastecmd"  src="'+baseUrl+'images/paste.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Paste" onclick="parent.frames['+whofocus+'].gk.editing(\'Paste\');" class="editorCursor"><br><img id="tablecmd" name="tablecmd" onclick="parent.frames['+whofocus+'].gk.tableHandle();" src="'+baseUrl+'editor/images/toolbar/table.gif" hspace="4" vspace="3" height="19" width="23" alt="Insert Table"><img id="backcolorcmd" name="backcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'backcolor\');" src="'+baseUrl+'images/background-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Set Background Color"/><br><img id="fontcolorcmd" name="fontcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'forecolor\');" src="'+baseUrl+'images/text-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Text Color"><img id="subscriptcmd" name="subscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'subscript\');" src="'+baseUrl+'images/subscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Subscript"/><br><img id="superscriptcmd" name="superscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'superscript\');" src="'+baseUrl+'images/superscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Superscript"><img id="strikethroughcmd" name="strikethroughcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'strikethrough\');" src="'+baseUrl+'images/strikethrough.jpg" hspace="4" vspace="3" height="19" width="23" alt="Strikethrough"/><br><img id="indentcmd" name="indentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'indent\');" src="'+baseUrl+'images/indent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Indent"><img id="outdentcmd" name="outdentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'outdent\');" src="'+baseUrl+'images/outdent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Outdent"/><br><img id="olcmd" name="olcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertorderedlist\');" src="'+baseUrl+'images/number-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Numbered Bullets"><img id="uolcmd" name="uolcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertunorderedlist\');" src="'+baseUrl+'images/round-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Bullets"/><br><img id="justifyfullcmd" name="justifyfullcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyfull\');" src="'+baseUrl+'images/justifyfull.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify"><img id="justifyleftcmd" name="justifyleftcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyleft\');" src="'+baseUrl+'images/justifyleft.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Left"/><br><img id="justifycentercmd" name="justifycentercmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifycenter\');" src="'+baseUrl+'images/justifycenter.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Center"><img id="justifyrightcmd" name="justifyrightcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyright\');" src="'+baseUrl+'images/justifyright.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Right"/><br><img id="insertImagecmd" name="insertImagecmd" onclick="parent.frames['+whofocus+'].gk.insertImage();" src="'+baseUrl+'images/insertImage.jpg" hspace="4" vspace="3" height="19" width="23" alt="Insert Image"><img id="WPastecmd" name="WPastecmd" onclick="parent.frames['+whofocus+'].gk.copyfromWord();" src="'+baseUrl+'images/copyfromWord.jpg" hspace="4" vspace="3" height="19" width="23" alt="Copy from Word"/><div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv0"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText10"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText0"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType10" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType10" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\'0\',document.getElementById(\'searchText10\').value,document.getElementById(\'replaceText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\'0\');" ></td></tr></table></div><br><img id="makeLinkcmd" name="makeLinkcmd" onclick="parent.frames['+whofocus+'].gk.makeLink();" src="'+baseUrl+'images/makeLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Create Link"><img id="unLinkcmd" name="unLinkcmd" onclick="parent.frames['+whofocus+'].gk.unLink1();" src="'+baseUrl+'images/unLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Unlink"/><br><img id="findtextcmd" name="findtextcmd" onclick="findtextbox(1,\'0\')" src="'+baseUrl+'images/icon-search.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find"><img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,\'0\')" src="'+baseUrl+'images/icon-replace.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find & Replace"/><div style="position:absolute; margin-top:-80px; margin-left:-75px; border:#666666; width:150px;border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'" onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div><br>';*/

		var url = baseUrl+'lock_leaf';	  

		createXMLHttpRequest();

		queryString =   url; 		

		queryString = queryString+"/index/leafId/"+leafId;		

		xmlHttp.onreadystatechange = handleLockLeafEdit;				

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

		timeInit = 1;

		show();

		

	}



	// this is a js function used to add the new leaf at first

	function addFirstLeaf(treeId, leafOrder, whofocus) 

	{		

       

		document.getElementById('saveOption').innerHTML = '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="firstLeafSave(\''+treeId+'\',\''+leafOrder+'\')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td></tr><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="cancelFirstLeaf(\''+treeId+'\',\''+leafOrder+'\',\''+whofocus+'\')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

		who_focus = whofocus;		

		document.getElementById('currentMenus').style.display = '';

		/*document.getElementById('currentMenus').innerHTML = '<img src="'+baseUrl+'images/bold.jpg" name="Boldcmd" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" alt="Bold" onclick="parent.frames['+whofocus+'].gk.editing(\'Bold\');"><img id="Italiccmd" name="Italiccmd" src="'+baseUrl+'images/italic.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Italic" onclick="parent.frames['+whofocus+'].gk.editing(\'Italic\');" class="editorCursor"><br><img id="Underlinecmd" name="Underlinecmd"  src="'+baseUrl+'images/underline.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Underline" onclick="parent.frames['+whofocus+'].gk.editing(\'Underline\');" class="editorCursor"><img id="Copycmd" name="Copycmd"  src="'+baseUrl+'images/copy.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Copy" onclick="parent.frames['+whofocus+'].gk.editing(\'Copy\');" class="editorCursor"><br><img src="'+baseUrl+'images/ref-l.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Undo" onclick="parent.frames['+whofocus+'].gk.undofunction();" id="undocmd" class="editorCursor"><img src="'+baseUrl+'images/ref-r.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Redo" onclick="parent.frames['+whofocus+'].gk.redofunction();" id="redoccmd" class="editorCursor"><br><img id="Cutcmd" name="Cutcmd" src="'+baseUrl+'images/del.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Cut" onclick="parent.frames['+whofocus+'].gk.editing(\'Cut\');" class="editorCursor"><img id="Pastecmd" name="Pastecmd"  src="'+baseUrl+'images/paste.jpg" hspace="4" vspace="3" height="19" width="23" border="0" alt="Paste" onclick="parent.frames['+whofocus+'].gk.editing(\'Paste\');" class="editorCursor"><br><img id="tablecmd" name="tablecmd" onclick="parent.frames['+whofocus+'].gk.tableHandle();" src="'+baseUrl+'editor/images/toolbar/table.gif" hspace="4" vspace="3" height="19" width="23" alt="Insert Table"><img id="backcolorcmd" name="backcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'backcolor\');" src="'+baseUrl+'images/background-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Set Background Color"/><br><img id="fontcolorcmd" name="fontcolorcmd" onclick="parent.frames['+whofocus+'].gk.textcolor(\'forecolor\');" src="'+baseUrl+'images/text-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Text Color"><img id="subscriptcmd" name="subscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'subscript\');" src="'+baseUrl+'images/subscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Subscript"/><br><img id="superscriptcmd" name="superscriptcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'superscript\');" src="'+baseUrl+'images/superscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Superscript"><img id="strikethroughcmd" name="strikethroughcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'strikethrough\');" src="'+baseUrl+'images/strikethrough.jpg" hspace="4" vspace="3" height="19" width="23" alt="Strikethrough"/><br><img id="indentcmd" name="indentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'indent\');" src="'+baseUrl+'images/indent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Indent"><img id="outdentcmd" name="outdentcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'outdent\');" src="'+baseUrl+'images/outdent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Outdent"/><br><img id="olcmd" name="olcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertorderedlist\');" src="'+baseUrl+'images/number-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Numbered Bullets"><img id="uolcmd" name="uolcmd" onclick="parent.frames['+whofocus+'].gk.makeol(\'insertunorderedlist\');" src="'+baseUrl+'images/round-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Bullets"/><br><img id="justifyfullcmd" name="justifyfullcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyfull\');" src="'+baseUrl+'images/justifyfull.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify"><img id="justifyleftcmd" name="justifyleftcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyleft\');" src="'+baseUrl+'images/justifyleft.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Left"/><br><img id="justifycentercmd" name="justifycentercmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifycenter\');" src="'+baseUrl+'images/justifycenter.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Center"><img id="justifyrightcmd" name="justifyrightcmd" onclick="parent.frames['+whofocus+'].gk.editing(\'justifyright\');" src="'+baseUrl+'images/justifyright.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Right"/><br><img id="insertImagecmd" name="insertImagecmd" onclick="parent.frames['+whofocus+'].gk.insertImage();" src="'+baseUrl+'images/insertImage.jpg" hspace="4" vspace="3" height="19" width="23" alt="Insert Image"><img id="WPastecmd" name="WPastecmd" onclick="parent.frames['+whofocus+'].gk.copyfromWord();" src="'+baseUrl+'images/copyfromWord.jpg" hspace="4" vspace="3" height="19" width="23" alt="Copy from Word"/><div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv0"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText10"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText0"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType10" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType10" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\'0\',document.getElementById(\'searchText10\').value,document.getElementById(\'replaceText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\'0\');" ></td></tr></table></div><br><img id="makeLinkcmd" name="makeLinkcmd" onclick="parent.frames['+whofocus+'].gk.makeLink();" src="'+baseUrl+'images/makeLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Create Link"><img id="unLinkcmd" name="unLinkcmd" onclick="parent.frames['+whofocus+'].gk.unLink1();" src="'+baseUrl+'images/unLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Unlink"/><br><img id="findtextcmd" name="findtextcmd" onclick="findtextbox(1,\'0\')" src="'+baseUrl+'images/icon-search.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find"><img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,\'0\')" src="'+baseUrl+'images/icon-replace.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find & Replace"/><div style="position:absolute; margin-top:-80px; margin-left:-75px; border:#666666; width:150px;border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv'+frameIndex+'">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText'+frameIndex+'">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType'+frameIndex+'" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch('+frameIndex+',document.getElementById(\'searchText'+frameIndex+'\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'" onclick="findtextbox(0,'+frameIndex+');" >&nbsp;&nbsp;</div><br>';*/

		var iframeId = 'editorLeafContentsAddFirst';		

		if(document.getElementById('allLeafs').value != '')

		{

			var arrLeafIds = new Array();

			arrLeafIds = document.getElementById('allLeafs').value.split(',');

			

			for(var i=0;i<arrLeafIds.length;i++)

			{			

				var spanFooterLeafId = 'spanFooterLeaf'+arrLeafIds[i];

				var expandSpanId = 'expandId'+arrLeafIds[i];

				var leafHeaderId = 'leafHeader'+arrLeafIds[i];

				var leafContentId = 'leafContent'+arrLeafIds[i];

				var editId = 'leafEdit'+arrLeafIds[i];	

				var leafAddId = 'leafAdd'+arrLeafIds[i];				

				var obj1 = document.getElementById(spanFooterLeafId);

				var obj2 = document.getElementById(expandSpanId);

				var obj3 = document.getElementById(leafHeaderId);

				var obj4 = document.getElementById(editId);		

				var obj5 = document.getElementById(leafContentId);

				var obj6 = document.getElementById(leafAddId);										

				obj1.style.display = "none"; 	

				obj2.style.display = "none"; 

				obj3.style.display = "none"; 

				obj4.style.display = "none";

				obj5.style.display = "";	

				obj6.style.display = "none";						 

			}

		}		

		var divId = 'leafAddFirst';

		obj=document.getElementById(divId);

		obj.style.display="";	

		parent.frames[whofocus].gk.EditingArea.focus();

		document.getElementById(iframeId).src = baseURL+'/editor/TeemeEditor.php?textAreaName=editorLeafContentsAddFirst&id=0&idea=0';	

		

	}



	// this is a js function used for save the leaf details automatically every 60 secs while leaf in edit mode

	function show()

	{			

		if(timeInit == 1)

		{	

			document.getElementById('saveId1').innerHTML = '';

			timeInit = 0;

			setTimeout("show()",30000);

		}

		else if(timeInit == 0)

		{

			var editorId = "editorLeafContents"+leafOrder1+"1";		

			var getvalue=document.getElementById(editorId).value;	

			var contentId = "curContent"+leafOrder1;

			var leafContentId = "leafContent"+leafOrder1;		

			document.getElementById(contentId).value = getvalue;		

			document.getElementById('saveId1').innerHTML = 'Auto Saved';

			document.getElementById(leafContentId).innerHTML = '<table width="100%"  border="0"><tr align="right"><td colspan="6" align="left">'+getvalue+'</td></tr></table>';

			timeInit = 1;

			setTimeout("show()",30000);

		}		

		else

		{

			document.getElementById('saveId1').innerHTML = '';			

		}		

	}		

	// this is a js function used for show the leaf previous version contents

	function showLeafPrevious(nodeId, leafParentId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType) 

	{	

		

		nodeId1 = nodeId;

		nodeId_vk= nodeId;

		curLeafId1 = curLeafId;

		curNodeOrder = leafOrder;

		var url = baseUrl+'view_leaf_previous_contents';  

		createXMLHttpRequest();

		queryString =   url; 

		queryString = queryString+'?leafParentId='+leafParentId+'&leafId='+nodeId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;				

		xmlHttp.onreadystatechange = handleStateChange1;

		

		leafHeaderId = 'leafHeader'+curNodeOrder

		leafContentId = 'leafContent'+curNodeOrder;

		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}

	// this is a js function used to show the leaf next version contents from the current version

	function showLeafNext(leafId, leafChildId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType) 

	{

		curLeafId1 = curLeafId;	

		nodeId_vk= leafId;

		curNodeOrder = leafOrder;

		var url = baseUrl+'view_leaf_next_contents';		

		createXMLHttpRequest();

		queryString =   url; 

		queryString = queryString+'?leafChildId='+leafChildId+'&leafId='+leafId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;		

		xmlHttp.onreadystatechange = handleStateChange1;

		leafHeaderId = 'leafHeader'+curNodeOrder

		leafContentId = 'leafContent'+curNodeOrder;

		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);

	}

	// this is a js function used to hide the whole leaf contents and show only 5 line contents

	function hideLeafContents(nodeOrder) 

	{ 

		hiddenId = 'hiddenId'+nodeOrder;

		var divId1 = 'leafContent'+nodeOrder;	

		var expandSpanId = 'expandId'+nodeOrder;

		var currentHiddenVal = document.getElementById(hiddenId).value;		

		document.getElementById(hiddenId).value = document.getElementById(divId1).innerHTML;						

		document.getElementById(divId1).innerHTML = currentHiddenVal;

		document.getElementById(expandSpanId).innerHTML = '<a href="javascript:void(0)" onClick="expandLeafContents(\''+nodeOrder+'\')" style="text-decoration:none"><img src="'+baseUrl+'images/down.jpg" border="0"></a>'; 		

	}

	// this is a js function used to show the whole leaf contents

	function expandLeafContents(nodeOrder) 

	{ 

		var divId1 = 'leafContent'+nodeOrder;		

		var expandSpanId = 'expandId'+nodeOrder;			

		var hiddenId = 'hiddenId'+nodeOrder;

		var currentHiddenVal = document.getElementById(hiddenId).value;

		document.getElementById(hiddenId).value = document.getElementById(divId1).innerHTML;		

		document.getElementById(divId1).innerHTML = currentHiddenVal;

		//document.getElementById(expandSpanId).innerHTML = '<a href="javascript:void(0)" onClick="hideLeafContents(\''+nodeOrder+'\')" style="text-decoration:none"><img src="'+baseUrl+'images/up.jpg" border="0"></a>'; 		

	}	

	

	// this is a js function used to save the leaf contents to database

	function leafSave(leafOrder, leafId, treeId, nodeId) 

	{

		var editorId = "editorLeafContents"+leafOrder+"1";		

		var getvalue=document.getElementById(editorId).value;				

		document.frmEditLeaf.curContent.value = getvalue;

		document.frmEditLeaf.curLeaf.value = leafId;	

		document.frmEditLeaf.curLeafOrder.value = leafOrder;

		document.frmEditLeaf.curNodeId.value = nodeId;	

		document.frmEditLeaf.curOption.value = 'edit';			

		document.frmEditLeaf.submit();		

		return true;		

	}

	// this is a js function used to search the contents in the documents according the search test

	function searchText(treeId) 

	{		

		var searchText = document.getElementById('leafSearch').value;				

		window.location = baseUrl+"view_document?doc=exist&treeId="+treeId+"&searchText="+searchText;	

		return true;		

	}			

	// this is a js function used to save the leaf contents temporary location 

	function leafSaveOnly(leafOrder, leafId, treeId, nodeId) 

	{							

		var editorId = "editorLeafContents"+leafOrder+"1";		

		var getvalue=document.getElementById(editorId).value;

	//	alert(getvalue);

		getvalue=getvalue.replace(' <br /><P','<P');

	 	getvalue=getvalue.replace(' <br /><p','<p');

		var contentId = "curContent"+leafOrder;

		var leafContentId = 'leafContent'+leafOrder;		

		document.getElementById(contentId).value = getvalue;			

		document.getElementById('saveId1').innerHTML = 'Auto Saved';

		document.getElementById(leafContentId).innerHTML = '<table width="100%"  border="0"><tr align="right"><td colspan="6" align="left">'+getvalue+'</td></tr></table>';

		return false;		

	}	

	// this is a js function used to save the new leaf 

	function newLeafSave(leafOrder, leafId, treeId) 

	{

		var editorId = "editorLeafContentsAdd"+leafOrder+"1";

		var getvalue=document.getElementById(editorId).value;

		document.frmEditLeaf.curLeaf.value = leafId;	

		document.frmEditLeaf.curContent.value = getvalue;

		document.frmEditLeaf.curLeafOrder.value = leafOrder;

		document.frmEditLeaf.curOption.value = 'add';			

		document.frmEditLeaf.submit();

		return true;		

	}



	// this is a js function used to save the new leaf 

	function firstLeafSave(treeId, leafOrder) 

	{		

		var editorId 	= "editorLeafContentsAddFirst1";

		var getvalue	= document.getElementById(editorId).value;		

		//document.frmEditLeaf.curLeaf.value 		= leafId;	

		document.frmEditLeaf.curContent.value 	= getvalue;

		document.frmEditLeaf.curLeafOrder.value = leafOrder;

		document.frmEditLeaf.curOption.value 	= 'addFirst';			

		document.frmEditLeaf.submit();

		return true;		

	}



	// this is a js function used to cancel to add the first leaf 

	function cancelFirstLeaf( treeId, leafOrder, whofocus) 

	{

		document.getElementById('currentMenus').style.display = 'none';	

		document.getElementById('saveOption').innerHTML = '';	

		document.getElementById('editorLeafContentsAddFirst').value == '';	

		document.getElementById('leafAddFirst').style.display="none";				

	}



	// this is a js function used to cancel the new leaf 

	function cancelNewLeaf(leafId, leafOrder, spanFooterId, treeId, nodeId, whofocus) 

	{	

		whofocusedit = 	whofocus-1;

		whofocusadd = 	whofocus;

		//parent.frames[whofocusadd].gk.EditingArea.blur();

		document.getElementById(spanFooterId).innerHTML = '<a href="javascript:void(0)" onClick="editLeaf(\''+leafId+'\',\''+leafOrder+'\',\''+spanFooterId+'\',\''+treeId+'\',\''+nodeId+'\',\''+whofocusedit+'\')">Edit this Leaf</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="addLeaf(\''+leafId+'\',\''+treeId+'\',\''+leafOrder+'\',\''+spanFooterId+'\',\''+nodeId+'\',\''+whofocusadd+'\')">Add new Leaf</a>';

		document.getElementById('currentMenus').style.display = 'none';	

		document.getElementById('saveOption').innerHTML = '';	

		var divId = 'leafAdd'+leafOrder;

		obj=document.getElementById(divId);

		obj.style.display="none";



		var spanFooterLeafId = 'spanFooterLeaf'+leafOrder;

		var expandSpanId = 'expandId'+leafOrder;

		var leafHeaderId = 'leafHeader'+leafOrder;	



		var obj3 = document.getElementById(spanFooterLeafId);

		var obj4 = document.getElementById(expandSpanId);

		var obj5 = document.getElementById(leafHeaderId);

				

		obj3.style.display = "none"; 	

		obj4.style.display = "none"; 

		obj5.style.display = "none"; 				

		

	}

	// this is a js function used to cancel the edit function 

	function cancelEdit(leafId, leafOrder, spanFooterId, treeId, nodeId, whofocus) 

	{	

		document.getElementById('editStatus').value = 0;		

		document.getElementById('discuss'+leafOrder).style.display = 'none'

		document.getElementById('chat'+leafOrder).style.display = 'none'

		document.getElementById('tag'+leafOrder).style.display = 'none'

		timeInit = -1;

		show();

		whofocusedit = 	whofocus;

		whofocusadd = 	parseInt(whofocus)+1;

		document.getElementById('currentMenus').style.display = 'none';	

		document.getElementById('saveOption').innerHTML = '';		

		document.getElementById(spanFooterId).innerHTML = '<a href="javascript:void(0)" onClick="editLeaf(\''+leafId+'\',\''+leafOrder+'\',\''+spanFooterId+'\',\''+treeId+'\',\''+nodeId+'\',\''+whofocusedit+'\')">Edit this Leaf</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="addLeaf(\''+leafId+'\',\''+treeId+'\',\''+leafOrder+'\',\''+spanFooterId+'\',\''+nodeId+'\',\''+whofocusadd+'\')">Add new Leaf</a>';

		var divId1 = 'leafContent'+leafOrder;

		var divId2 = 'leafEdit'+leafOrder;			

		obj1=document.getElementById(divId1);

		obj2=document.getElementById(divId2);

		obj1.style.display="";	  

		obj2.style.display="none";	



		var spanFooterLeafId = 'spanFooterLeaf'+leafOrder;

		var expandSpanId = 'expandId'+leafOrder;

		var leafHeaderId = 'leafHeader'+leafOrder;

		var obj3 = document.getElementById(spanFooterLeafId);

		var obj4 = document.getElementById(expandSpanId);

		var obj5 = document.getElementById(leafHeaderId);

				

		obj3.style.display = "none"; 	

		obj4.style.display = "none"; 

		obj5.style.display = "none"; 	

		

		var url = baseUrl+'unlock_leaf';		  

		createXMLHttpRequest();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);	

		

	}	

	// this is a js function used to show the form to enter the search text

	function showSearch(divId)

	{

		var obj = document.getElementById(divId);		

		obj.style.display = ""; 		  

	}

	// this is a js function used to hide the document search form

	function hideSearch(divId)

	{

		var obj = document.getElementById(divId);		

		obj.style.display = "none"; 		  

	}

	// this is a js function used to show the side menu links

	function viewMenuLinks(divId, divId1)

	{

		var obj = document.getElementById(divId);		

		var obj1 = document.getElementById(divId1);	

		if(obj.style.display == "none")

		{

			obj.style.display = "";

			obj1.style.display = "none";

		}

		else

		{

			obj.style.display = "none";

			obj1.style.display = "";

		} 		  

	}

	// this is a js function used to strore 

	function curValue(thisVal)

	{

		document.getElementById("editorLeafContents").innerHTML = thisVal.value;

	}

	// this is a js function used to get the contents throught AJAX

	function handleStateChange1() 

	{

		if(xmlHttp.readyState == 4) 

		{

			if(xmlHttp.status == 200) 

			{					

				arrResponseText = new Array();

									

				arrResponseText = xmlHttp.responseText.split("|||");				

				document.getElementById(leafHeaderId).innerHTML			= arrResponseText[0];

				document.getElementById(leafContentId).innerHTML		= arrResponseText[1];				

				document.getElementById(hiddenId).value					= arrResponseText[2];	

				document.getElementById('discuss'+curNodeOrder).innerHTML	= arrResponseText[3];

				document.getElementById('chat'+curNodeOrder).innerHTML	= arrResponseText[4];	

				document.getElementById('tag'+curNodeOrder).innerHTML		= arrResponseText[5];

				document.getElementById('spanTagViewInner'+curNodeOrder).innerHTML	= arrResponseText[6];

				// alert('<li><a href="javascript:void(0)" onClick="showNewTag('+curNodeOrder+','+workSpaceId+','+workSpaceType+','+arrResponseText[7]+',2,0,1)"><span>Apply tag</span></a></li>');

				document.getElementById('spanTagNew'+curNodeOrder).innerHTML	= '<a href="javascript:void(0)" onClick="showNewTag('+curNodeOrder+','+workSpaceId+','+workSpaceType+','+arrResponseText[7]+',2,0,1)"><span>Apply tag</span></a>';

				//	alert(document.getElementById('spanTagNew'+curNodeOrder).innerHTML);

				var expandSpanId = 'expandId'+curNodeOrder;				

/*				if(arrResponseText[2].length > 500)

				{						

					document.getElementById(expandSpanId).innerHTML = '<a href="javascript:void(0)" onClick="hideLeafContents(\''+curNodeOrder+'\')" style="text-decoration:none"><img src="'+baseUrl+'images/up.jpg" border="0"></a>'; 	

				}

				else

				{

					document.getElementById(expandSpanId).innerHTML = "";

				}*/				

			}

		}

	}

	// this is a js function used to unlock all the leafs of current logged in user while un load the page

	function bodyUnload() 

	{

		var url = baseUrl+'unlock_leafs';		  

		createXMLHttpRequest();

		queryString =   url; 		

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);	

	}

	// this is a js function used to hide and show the document seed menus

	function hideShowSeed(treeId) 

	{

		var seedId = 'normalViewTree'+treeId;			

		if(document.getElementById(seedId).style.display == "none")

		{

			document.getElementById(seedId).style.display="";

		}

		else

		{

			document.getElementById(seedId).style.display="none";

		}

	}

	// this is a js function used to display the information of each leaf

	function showLeafOptions(leafId, leafOrder, treeId, nodeId, whofocus)

	{

		var seedId = 'normalViewTree'+treeId;	

		document.getElementById(seedId).style.display="none";	

		document.getElementById('leafAddFirst').style.display="none";

		document.getElementById('spanArtifactLinks0').style.display = 'none';	

		if(document.getElementById('editStatus').value == 1)

		{

			alert('Please click Save & Exit or Close button before accessing new leaf');

			var editorFocus = document.getElementById('curFocus').value;

			parent.frames[editorFocus].gk.EditingArea.focus();	

			return false;

		}		

		leafId1 	= leafId;	

		nodeId1 	= nodeId;		

		treeId1 	= treeId;

		leafOrder1 	= leafOrder;

		whofocus1 	= whofocus;	

		timeInit 	= -1;

		show();

		document.getElementById('saveId1').innerHTML = '';			

		var arrLeafIds = new Array();

		arrLeafIds = document.getElementById('allLeafs').value.split(',');

		for(var i=0;i<arrLeafIds.length;i++)

		{

			if(arrLeafIds[i] != leafOrder1)

			{

				var spanFooterLeafId = 'spanFooterLeaf'+arrLeafIds[i];

				var expandSpanId = 'expandId'+arrLeafIds[i];

				var leafHeaderId = 'leafHeader'+arrLeafIds[i];

				var leafContentId = 'leafContent'+arrLeafIds[i];

				var editId = 'leafEdit'+arrLeafIds[i];	

				var leafAddId = 'leafAdd'+arrLeafIds[i];

				var spanArtifactLinks = 'spanArtifactLinks'+arrLeafIds[i];				

				var obj1 = document.getElementById(spanFooterLeafId);

				var obj2 = document.getElementById(expandSpanId);

				var obj3 = document.getElementById(leafHeaderId);

				var obj4 = document.getElementById(editId);		

				var obj5 = document.getElementById(leafContentId);

				var obj6 = document.getElementById(leafAddId);	

				var obj7 = document.getElementById(spanArtifactLinks);	

				document.getElementById('discuss'+arrLeafIds[i]).style.display = 'none';

				document.getElementById('chat'+arrLeafIds[i]).style.display = 'none';	

				document.getElementById('tag'+arrLeafIds[i]).style.display = 'none';											

				obj1.style.display = "none"; 	

				obj2.style.display = "none"; 

				obj3.style.display = "none"; 

				obj4.style.display = "none";

				obj5.style.display = "";	

				obj6.style.display = "none";

				obj7.style.display = "none";

								

			}	 

		}			

		

		var url = baseUrl+'check_locking/index/'+leafId;	

		 

		createXMLHttpRequest();

		queryString =   url; 

		//queryString = queryString + "?leafId="+leafId;

		xmlHttp.onreadystatechange = handleLockLeaf;		

		xmlHttp.open("GET", queryString, true);

		xmlHttp.send(null);			

	}



	//This is a JS function used to check the leaf lock while clicking the edit link

	function handleLockLeafEdit() 

	{

		if(xmlHttp.readyState == 4) 

		{				

			if(xmlHttp.status == 200) 

			{					

				strResponseText = xmlHttp.responseText;							

				var editId = 'leafEdit'+leafOrder1;						

				var spanFooterLeafId = 'spanFooterLeaf'+leafOrder1;

				var expandSpanId = 'expandId'+leafOrder1;

				var leafHeaderId = 'leafHeader'+leafOrder1;

				var leafContentId = 'leafContent'+leafOrder1;

				var curContentId = 'curContent'+leafOrder1;

				var editorId = "editorLeafContents"+leafOrder1+"1";	

				var spanArtifactLinks = 'spanArtifactLinks'+leafOrder1;		

				//var leafContentId = 'leafContent'+nodeId1;

				var obj1 = document.getElementById(spanFooterLeafId);

				var obj2 = document.getElementById(expandSpanId);

				var obj3 = document.getElementById(leafHeaderId);

				var obj4 = document.getElementById(editId);		

				var obj5 = document.getElementById(leafContentId);

				var obj6 = document.getElementById(spanArtifactLinks);	

				var iframeId = 'editorLeafContents'+leafOrder1;					

				if(strResponseText == 0)

				{									

					document.getElementById('editStatus').value = 1;							

					obj1.style.display = "";					 	

					obj2.style.display = "none"; 

					obj3.style.display = "none"; 

					obj4.style.display = "";

					obj5.style.display = "none";	

					obj6.style.display = "none";

					document.getElementById(editorId).value = document.getElementById(curContentId).value;

					document.getElementById('saveOption').innerHTML = '<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="#" onclick="leafSave(\''+leafOrder1+'\',\''+leafId1+'\',\''+treeId1+'\',\''+nodeId1+'\')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td></tr><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="cancelEdit(\''+leafId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+treeId1+'\',\''+nodeId1+'\',\''+whofocus1+'\')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a><span id="saveId" class="savedText"></span></td></tr></table>';		

					document.getElementById(spanFooterLeafId).innerHTML = '';			

					document.getElementById('discuss'+leafOrder1).style.display = 'none';		

					document.getElementById('chat'+leafOrder1).style.display = 'none';		

					document.getElementById('tag'+leafOrder1).style.display = 'none';					

					document.getElementById(iframeId).src = baseURL+'/editor/TeemeEditor.php?textAreaName=editorLeafContents'+leafOrder1+'&id=0&idea=0';

					parent.frames[whofocus1].gk.EditingArea.innerHTML = document.getElementById(curContentId).value;		

					parent.frames[whofocus1].gk.EditingArea.focus();

					document.getElementById('curFocus').value = whofocus1;						

								

				}

				else

				{							

					alert('This leaf is already in edit mode');					

					obj1.style.display = "none"; 	

					obj2.style.display = "none"; 

					obj3.style.display = "none";

					obj4.style.display = "none";

					obj6.style.display = "none";

					document.getElementById('discuss'+leafOrder1).style.display = 'none';	

					document.getElementById('chat'+leafOrder1).style.display = 'none';		

					document.getElementById('tag'+leafOrder1).style.display = 'none';	

					obj5.style.display = "";

					whofocusedit = whofocus1;

					whofocusadd  = parseInt(whofocus1)+1;	

					document.getElementById(spanFooterLeafId).innerHTML = '<a href="javascript:void(0)" onClick="editLeaf(\''+nodeId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+treeId1+'\',\''+nodeId1+'\',\''+whofocusedit+'\')">Edit this Leaf</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="addLeaf(\''+nodeId1+'\',\''+treeId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+nodeId1+'\',\''+whofocusadd+'\')">Add new Leaf</a>';

					document.getElementById('saveOption').innerHTML = "";					

				}		

			}

		}

	}

	

	//This is a JS function used to check the leaf lock while opening the leaf by single click

	function handleLockLeaf() 

	{		

		if(xmlHttp.readyState == 4) 

		{			

			if(xmlHttp.status == 200) 

			{									

				strResponseText = xmlHttp.responseText;				

				var editId = 'leafEdit'+leafOrder1;						

				var spanFooterLeafId = 'spanFooterLeaf'+leafOrder1;

				var expandSpanId = 'expandId'+leafOrder1;

				var leafHeaderId = 'leafHeader'+leafOrder1;

				var leafContentId = 'leafContent'+leafOrder1;

				var leafAddId = 'leafAdd'+leafOrder1;

				var spanArtifactLinks = 'spanArtifactLinks'+leafOrder1;

				

				var obj1 = document.getElementById(spanFooterLeafId);

				var obj2 = document.getElementById(expandSpanId);

				var obj3 = document.getElementById(leafHeaderId);

				var obj4 = document.getElementById(editId);		

				var obj5 = document.getElementById(leafAddId);

				var obj6 = document.getElementById(spanArtifactLinks);							

				if(strResponseText == 0)

				{					

					whofocusedit = whofocus1;

					whofocusadd  = parseInt(whofocus1)+1;	

					document.getElementById('discuss'+leafOrder1).style.display = '';	

					document.getElementById('chat'+leafOrder1).style.display = '';		

					document.getElementById('tag'+leafOrder1).style.display = '';												

					if(obj4.style.display != 'none' || obj5.style.display != 'none')

					{						

						obj1.style.display = "none";

						document.getElementById('discuss'+leafOrder1).style.display = 'none'; 

						document.getElementById('chat'+leafOrder1).style.display = 'none';

						document.getElementById('tag'+leafOrder1).style.display = 'none';  		

					}

					else

					{						

						document.getElementById('saveOption').innerHTML = "";

						document.getElementById('currentMenus').style.display = 'none';

						document.getElementById(spanFooterLeafId).innerHTML = '<a href="javascript:void(0)" onClick="editLeaf(\''+leafId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+treeId1+'\',\''+nodeId1+'\',\''+whofocusedit+'\')">Edit</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="addLeaf(\''+leafId1+'\',\''+treeId1+'\',\''+leafOrder1+'\',\''+spanFooterLeafId+'\',\''+nodeId1+'\',\''+whofocusadd+'\')">Add new Idea</a>';			

						if(obj1.style.display == 'none')

						{		

							obj1.style.display = ""; 	

							obj2.style.display = ""; 

							obj3.style.display = "";

							document.getElementById('discuss'+leafOrder1).style.display = ''; 

							document.getElementById('chat'+leafOrder1).style.display = '';

							document.getElementById('tag'+leafOrder1).style.display = '';

						}

						else

						{

							obj1.style.display = "none"; 	

							obj2.style.display = "none"; 

							obj3.style.display = "none"; 

							obj6.style.display = "none"; 

							document.getElementById('discuss'+leafOrder1).style.display = 'none';

							document.getElementById('chat'+leafOrder1).style.display = 'none';

							document.getElementById('tag'+leafOrder1).style.display = 'none';

						}	

					}			

				}

				else

				{	

					if(obj4.style.display != '')

					{				

						alert('This leaf is already in edit mode');					

					}

				}					

			}

		}



	}



	function saveDocument()

	{							

		var getvalue = document.frmDocument.editorContents.value;

		

		document.frmDocument.editorContents.value = getvalue;		

		var docTitle = document.getElementById('documentTitle').value	

		if(trim(docTitle) =="")

		{

			alert("Please enter the document title");

			document.getElementById('documentTitle').focus();

			return false;

		}		

		document.frmDocument.submit();		

		return true;	

	}	

	

	function submitNewDocument()

	{

		document.page.nextPage.value = "new";

		if(document.page.documentTitle.value == 'Untitled')

		{	

			alert('Please create the document title before creating the new leaf');

			document.page.saveOption1.value = "1";

			window.open(baseUrl+'get_document_title1','','width=450,height=120,toolbar=no,scrollbars=yes,resizable=no,top=170,left=200');

			return false;			

		}	

		else

		{

			document.page.submit();

		}

		return true;

	}	

	function showFocus()

	{

		parent.frames[0].gk.EditingArea.focus();

	}

	//this function is used to validate the document name

	function validateDocumentName()

	{

		var getvalue = getvaluefromEditor('documentTitle');

		//var docTitle = document.getElementById('documentName').value;

		if(getvalue == "")

		{

			alert("Please enter the document title");

			document.getElementById('documentName').focus();

			return false;

		}

		//this.form.submit();

		return true;

	}



	

	