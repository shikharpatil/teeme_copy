<script>

function validate_dis(replyDiscussion,formname)

	{

		var error='';



	//replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion) == ''){

		error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error=='')

	{

		var replyDiscussion0=getvaluefromEditor(replyDiscussion);

		var editorname1 = document.getElementById('editorname1').value;

		var predecessor = document.getElementById('seedpredecessor').value;

		var successors = document.getElementById('seedsuccessors').value;

		var reply = document.getElementById('reply').value;

		var treeId = document.getElementById('treeId').value;

		var httpNote1 = GetXmlHttpObject2();

		var urlm=baseUrl+'notes/addMyNotesAjax/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

		var data='replyDiscussion0='+encodeURIComponent(replyDiscussion0)+'&reply='+reply+'&predecessor='+predecessor+'&successors='+successors+'&editorname1='+editorname1; 

		httpNote1.open("POST", urlm, true); 

	

		httpNote1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		httpNote1.onreadystatechange = function()

		{

			if (httpNote1.readyState==4 && httpNote1.status==200)

			{

			    document.getElementById('datacontainer').innerHTML=httpNote1.responseText;

				//document.getElementById('divNodeContainer').innerHTML=httpNote1.responseText;

				//document.getElementById('0notes').style.display='none';

			}

		}     

		httpNote1.send(data);

		//formname.submit();

	}

	else

	{

		alert(error);

	}

	

	}

	

	function reply_close12(id){

	

	divid=id+'notes';

	//setValueIntoEditor('replyDiscussion0');

 	document.getElementById(divid).style.display='none';

}



function reply(id,focusId)

{ 

	var divid=id+'notes';

	

	editor_code('','replyDiscussion0','containerseed');

	chnage_textarea_to_editor('replyDiscussion0');

	document.getElementById(divid).style.display='block';

	//setValueIntoEditor('replyDiscussion'+id,'');

			

	

}



function edit_action_tag(workSpaceId,workSpaceType,artifactId,artifactType,sequenceTagId,tagOption,tagId)

{

	 alert("hi");

		var xmlHttpRequest = GetXmlHttpObject2();

		urlm=baseUrl+'add_tag/index/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType+'/'+sequenceTagId+'/'+tagOption+'/'+tagId;	 

		var iframeId='iframeId0';

		var liTag='liTag';

		if(artifactType==2)

		{

		  	iframeId="iframeId"+artifactId;

			

			liTag='liTag'+artifactId;

			

		}

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

		{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				 

				 document.getElementById(iframeId).innerHTML=xmlHttpRequest.responseText;

						

			}

		}     

		xmlHttpRequest.send(); 

	}

	

	

	function addLeaf(leafId,treeId, leafOrder,nodeId,successors){ 
	//alert ('Here');
	

	if(document.getElementById('editStatus').value == 1)

	{

		alert('Please save or close the current leaf before accessing another leaf');

		//return false;

	}

	else

	{

	

	

	document.getElementById('editStatus').value = 1;

 	document.getElementById('addleaf'+leafOrder).style.display="";

	editor_code('','editorLeafContentsAdd'+leafOrder+'1','addleaf'+leafOrder);

	hideall();

	

		

	

	document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div style="width:785px; float:left; padding:10px;"><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+','+nodeId+','+successors+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a> <a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+','+nodeId+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></div>';



	chnage_textarea_to_editor('editorLeafContentsAdd'+leafOrder+'1');

	setValueIntoEditor('editorLeafContentsAdd'+leafOrder+'1','');

	}

}



function newLeafSave(leafId, treeId,leafOrder,nodeId,successors) 

{	

	document.getElementById('editStatus').value = 0;		

	var editorId = "editorLeafContentsAdd"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);
	
	//alert (getvalue);

		if(getvalue == ''){

			alert('Please enter your note');

			return false;

		}

	

			

			xmlHttpTree=GetXmlHttpObject2();

			var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

			xmlHttpTree.onreadystatechange = function(){

			

			

				

				

				

				

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

					//alert (isLatest);

					if(isLatest==0)

					{

						alert ('New Idea can not be created because new version of the tree has been created.');

						

						return false;

						

						

					}

					else

					{ 

						//document.form2.submit();

						//return true;

						

					/*	document.form2.curLeaf.value = leafId;	

			

			document.form2.curLeafOrder.value = leafOrder;

			document.form2.curOption.value = 'add';	

			document.form2.curNodeId.value = nodeId;	

			document.form2.successors.value = successors;

			*/

						

						//var replyDiscussion0=getvaluefromEditor(replyDiscussion);

						var totalNodes = document.getElementById('totalNodes').value;

						var curFocus = document.getElementById('curFocus').value;

						var curLeaf = leafId;	

						var curContent = getvalue;

						var reply = document.getElementById('reply').value;

						//var successors = successors;

						var curNodeId = nodeId;

						var treeId = document.getElementById('treeId').value;

						var curLeafOrder = leafOrder;

						var curOption = 'add';

						var workSpaceId = document.getElementById('workSpaceId').value;

						var workSpaceType = document.getElementById('workSpaceType').value;

					//	var data='totalNodes='+totalNodes+'&curFocus='+curFocus+'&curLeaf='+curLeaf+'&curContent='+encodeURIComponent(curContent)+'&reply='+reply+'&successors='+successors+'&curNodeId='+curNodeId+'&treeId='+treeId+'&curLeafOrder='+curLeafOrder+'&curOption='+curOption+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;

					

		var data='totalNodes='+totalNodes+'&curFocus='+curFocus+'&curLeaf='+curLeaf+'&curContent='+encodeURIComponent(curContent)+'&reply='+reply+'&successors='+successors+'&curNodeId='+curNodeId+'&treeId='+treeId+'&curLeafOrder='+curLeafOrder+'&curOption='+curOption+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType;			

		var httpNote1 = GetXmlHttpObject2();

						

		var urlm=baseUrl+'notes/editNotesContents1New/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

						

						httpNote1.open("POST", urlm, true); 

					

						httpNote1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

						httpNote1.onreadystatechange = function()

						{

							if (httpNote1.readyState==4 && httpNote1.status==200)

							{

								

			

		document.getElementById('datacontainer').innerHTML=httpNote1.responseText;		

	//	document.getElementById('divNodeContainer').innerHTML=httpNote1.responseText;

	//							document.getElementById('0notes').style.display='none';

								

							}

						}     

						httpNote1.send(data);

						//formname.submit();

						

						

						

					}



		}					

	}



				

				

					

			

			

			}

	

			xmlHttpTree.open("GET", url, true);

			xmlHttpTree.send(null);

	

	//document.frmEditLeaf.submit();

	//return true;		

}



//function handleTreeVersion12(){}

function openEditTitleBox(content){

		if(document.getElementById('edit_doc').style.display=='none') 

		{ 	

			editor_code(content,'documentName','divEditDoc');

			chnage_textarea_to_editor('documentName','simple');

			document.getElementById('edit_doc').style.display='block';

			

		} 

		else

		 { document.getElementById('edit_doc').style.display='none';}

}



function editNotesContents_1(id,focusId,treeId,workSpaceId,workSpaceType,nodeId,textDone,successors,leafId)

{

leafId1=leafId;

	 treeId1=treeId;

	 nodeId1=nodeId;

	 workSpaceId1=workSpaceId;

	 workSpaceType1=workSpaceType;

	 id1=id;

	 successors1=successors;

	 textDone1=textDone;

	var temp=editLeafNote(leafId1,position1,treeId1,nodeId1);

	

}



function editLeafNote(leafId, leafOrder,treeId,nodeId) 

{  

	if(document.getElementById('editStatus').value == 1)

	{

		alert('Please save or close the current leaf before accessing another leaf');

		return false;

	}



	initialleafcontentId='initialleafcontent'+leafOrder1;

	hideall();

	

	xmlHttpTree=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

	xmlHttpTree.onreadystatechange = handleNoteTreeVersion;

	

	xmlHttpTree.open("GET", url, true);

	xmlHttpTree.send(null);

}

function handleNoteTreeVersion(){

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

					//alert (isLatest);

					if(isLatest==0)

					{

						alert ('This leaf can not be edited because new version of this tree has been created.');

						return false;

					}

					else

					{

						//document.frmEditLeaf.submit();

						//return true;

						xmlHttp=GetXmlHttpObject2();

						var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

						xmlHttp.onreadystatechange = handleNoteLockLeafEdit;				

						xmlHttp.open("GET", url, true);

						xmlHttp.send(null);

					}



		}					

	}

}

function handleNoteLockLeafEdit(){

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;		

			

			if(strResponseText == 0)

			{

			 	

				/* Fetching last version of leaf */

				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/getLeafDetail/leafId/"+leafId1;

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

							//alert ('Nodedetails= ' + nodeDetails);

								if (nodeDetails != 0)

								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");

									//alert ('leafOrder1= ' + leafOrder1);

									// alert(arrNode[0]+' : '+arrNode[1]+' : '+arrNode[2]+' : '+arrNode[3]+' : '+arrNode[4]);

									if (arrNode[0]!='onlyContents')

									{

										leafId1=arrNode[1];

										leafId2=arrNode[1];

										//leafOrder1=arrNode[2];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										contents=arrNode[4];

									}

									else

									{

										//alert ('contents1= ' + arrNode[1]);

										contents=arrNode[1];

									}

									

								}

				

				

				//document.getElementById('editStatus').value = 1;

				//var val=document.getElementById('initialleafcontent'+leafOrder1).value;

				document.getElementById('editleaf'+id1).style.display="";

				document.getElementById('editStatus').value = 1;

								

				editor_code(contents,'editorLeafContents'+id1+'1','editleaf'+id1);

				

				document.getElementById('editorLeafContents'+id1+'1sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="editLeafSave1('+leafId1+','+treeId1+','+id1+','+nodeId1+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="canceleditLeaf1('+nodeId1+','+treeId1+','+id1+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

				chnage_textarea_to_editor('editorLeafContents'+id1+'1');

				setValueIntoEditor('editorLeafContents'+id1+'1',contents);	

				xmlHttpLast11=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+nodeId1;

				xmlHttpLast11.onreadystatechange=function() {

				if (xmlHttpLast11.readyState==4) {

					//alert (url);

					// editing new leaf

					document.getElementById('editStatus').value = 1;

								

						}

					}

						

				xmlHttpLast11.open("GET", url, true);

				xmlHttpLast11.send(null);

				

				}

				}

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);



			}

			else

			{	

				alert(strResponseText);					

			}					

		}

	}

}



function canceleditLeaf1(nodeId, treeId, leafOrder) 

{ 

  	document.getElementById('editleaf'+leafOrder).style.display="none";

	document.getElementById('normalView'+nodeId).style.display="none";

	document.getElementById('editStatus').value= 0;	

	

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, true);

		xmlHttp1.send(null);	

}



function editLeafSave1(leafId, treeId,leafOrder,nodeId) 

{	

 	document.getElementById('normalView'+nodeId).style.display="none";

  	var editorId = "editorLeafContents"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;

	

  	if (getvalue=='')

	{

			alert ('Please enter your note');

			return false;

	}

	

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);		

	

	

	var httpNote = GetXmlHttpObject2();

		

		

	var urlm=baseUrl+'notes/editNotesContents1/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType;

	var data='curContent='+encodeURIComponent(getvaluefromEditor(editorId,'simple'))+'&reply=1&curOption=edit&curLeafOrder='+leafOrder+'&curNodeId='+nodeId+'&curLeaf='+leafId;

	

	

	httpNote.open("POST", urlm, true); 

	httpNote.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	httpNote.onreadystatechange = function()

					  { 

					  

					  if (httpNote.readyState==4 )

						{

							

						document.getElementById('leaf_contents'+nodeId).innerHTML=getvalue;

						document.getElementById('editleaf'+leafOrder).style.display="none";

						document.getElementById('normalView'+leafOrder).style.display="none";

						

						}

					  }     

	httpNote.send(data);

	

}





	



function editLeafSave1_old(leafId, treeId,leafOrder,nodeId) 

{	

  //document.getElementById('editleaf'+leafOrder).style.display="none";

  

  	if (getvalue=='')

		{

			alert ('Please enter your note');

			return false;

		}

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+leafId;

		//xmlHttp.onreadystatechange = handleStateChange;

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);		

	var editorId = "editorLeafContents"+leafOrder+"1";

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value;

		

	

	//var originalContents = document.getElementById('initialleafcontent'+leafOrder).value;

	document.form2.curContent.value = getvalue;

	document.form2.curLeaf.value = leafId;	

	document.form2.curLeafOrder.value = leafOrder;

	document.form2.curNodeId.value = nodeId;	

	document.form2.curOption.value = 'edit';	



			

			document.form2.submit();		

			return true;

	



}



function validate_dis1(replyDiscussion,formname,nodeId)

	{

		var error='';



	//replyDiscussion1=replyDiscussion+'1';

	if(getvaluefromEditor(replyDiscussion) == ''){

		error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error==''){

	

		document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString + '/index/leafId/'+nodeId;

		

		

		

		//divId = 'editLeaf';

		xmlHttp1.open("GET", queryString, false);

		xmlHttp1.send(null);

		xmlHttp1.onreadystatechange = function(){}

	

		formname.submit();

	}else{

		alert(error);

	}	

}





function cancelnewLeaf( leafId,treeId, leafOrder,nodeId) 

{

  	 document.getElementById('addleaf'+leafOrder).style.display="none";	

	  document.getElementById('normalView'+nodeId).style.display="none";	

	 document.getElementById('editStatus').value = 0;		

}



function showTags()

{  



  

	<?php

	  

		$viewTags = $this->tag_db_manager->getTagsByCategoryId(2);

		$viewTags2 = $this->tag_db_manager->getTagsByCategoryId2(2);

		

		$appliedTagIds = array();

		$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $_SESSION['artifactId'], $_SESSION['artifactType']);

		if(count($tags) > 0)

		{

			foreach($tags as $tagData)

			{

				$appliedTagIds[] = $tagData['tag'];

			}

		}

		$allTags = array();

		$allTags = array_merge ($tags,$viewTags2);

		$appliedTags = implode(',',$appliedTagIds);

		

	?>



	var toMatch = document.getElementById('searchTags').value;

	

	var val = '';

	

		//if (toMatch!='')

		if (1)

		{

		var count = '';

		var sectionChecked = '';

		<?php



		foreach($viewTags2 as $tagData)	

		{

			if (in_array($tagData['tag'],$appliedTagIds)) { 

		?>

			var str = '<?php echo $tagData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				

				count = count + ','+<?php echo $tagData['tag']; ?>;

				

				<?php if (in_array($tagData['tag'],$appliedTagIds)) { ?>

				sectionChecked = sectionChecked + ','+<?php echo $tagData['tag']; ?>;

				<?php } ?>

				

				val +=  '<input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagName'];?><br>';

				

				

			}

        

		<?php

			}

        }

		foreach($viewTags2 as $tagData)	

		{

			if (!in_array($tagData['tag'],$appliedTagIds)) { 

		?>

			var str = '<?php echo $tagData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

				

				count = count + ','+<?php echo $tagData['tag']; ?>;

				

				<?php if (in_array($tagData['tag'],$appliedTagIds)) { ?>

				sectionChecked = sectionChecked + ','+<?php echo $tagData['tag']; ?>;

				<?php } ?>

				

				val +=  '<input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagName'];?><br>';

				

				

			}

        

		<?php

			}

        }

        ?>

		document.getElementById('showTags').innerHTML = val;

			if (count!='')

			{

				document.getElementById('sectionTagIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			//alert (document.getElementById('sectionTagIds').value );

			document.getElementById('showTags').style.display = 'block';

		}

		else

		{

			document.getElementById('showTags').style.display = 'none';

		}



}



function search_contact_tags()

{



<?php

$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $_SESSION['artifactId'], $_SESSION['artifactType']);



$viewTags2 = array(); 

$viewTags2 = $this->tag_db_manager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);			

$appliedTagIds = array();

if(count($tags) > 0)

{

	foreach($tags as $tagData)

	{

		$appliedTagIds[] = $tagData['tag'];

	}

}

//echo count($viewTags2); exit;

$allTags = array();

$allTags = array_merge ($tags,$viewTags2);

//echo count($allTags); exit;

$appliedTags = implode(',',$appliedTagIds);



?>



 

	var toMatch = document.getElementById('searchTags').value;

	var val = '';

	

		//if (toMatch!='')

		if (1)

		{

		var count = '';

		var sectionChecked = '';

		<?php



		foreach($viewTags2 as $tagData)	

		{

			if (in_array($tagData['tagTypeId'],$appliedTagIds)) {

		?>

			var str = '<?php echo $tagData['tagType']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

			

				count = count + ','+<?php echo $tagData['tagTypeId']; ?>;

				

				<?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) { ?>

				sectionChecked = sectionChecked + ','+<?php echo $tagData['tagTypeId']; ?>;

				<?php } ?>

				

				val +=  '<input type="checkbox"  name="unAppliedTags" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagType'];?><br>';

				document.getElementById('showTags').innerHTML = val;

				

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

			}

        }

		foreach($viewTags2 as $tagData)	

		{

			if (!in_array($tagData['tagTypeId'],$appliedTagIds)) {

		?>

			var str = '<?php echo $tagData['tagType']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{

			

				count = count + ','+<?php echo $tagData['tagTypeId']; ?>;

				

				<?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) { ?>

				sectionChecked = sectionChecked + ','+<?php echo $tagData['tagTypeId']; ?>;

				<?php } ?>

				

				val +=  '<input type="checkbox"  name="unAppliedTags" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php echo $tagData['tagType'];?><br>';

				document.getElementById('showTags').innerHTML = val;

				

				//document.write('<input type="checkbox" name="unAppliedTags[]" value="<?php //echo $tagData['tag'];?>" <?php //if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?>/><?php //echo $tagData['tagName'];?><br />');

			}

        

		<?php

			}

        }

        ?>

			if (count!='')

			{

				document.getElementById('sectionTagIds').value = count;

			}

			if (sectionChecked!='')

			{

				document.getElementById('sectionChecked').value = sectionChecked;

			}

			//alert (document.getElementById('sectionTagIds').value );

			document.getElementById('showTags').style.display = 'block';

		}

		else

		{

			document.getElementById('showTags').style.display = 'none';

		}



}



</script>	