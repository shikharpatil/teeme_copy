<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!--html start-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Teeme > Messages</title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

	

	<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

		function showDivOnlineUsers1(divId)

		{

		    if(document.getElementById(divId).style.display=='none')

			{

			   document.getElementById(divId).style.display='table-row';

			   document.getElementById('divSearchUser').style.display='table';

			}

			else

			{

			   document.getElementById(divId).style.display='none';

			   document.getElementById('divSearchUser').style.display='none';

			}   

		}

	</script>

	

		



</head>

<body>

<div id="container_for_mobile">



		<div id="content">



<!--webbot bot="HTMLMarkup" startspan -->







       <!-- <div style="float:right;padding-bottom:10px;" id="reloadMsg">

                	<a href="javascript:void(0);" onClick="window.location.reload();"><img src="<?php echo base_url(); ?>images/new-version.png" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a>

                	</div>-->

    

           

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;" >

              <tr>

                <td valign="top" width="18%" >			

			    <?php

				if ($workSpaceId_search_user == 0)

				{	

				?>

					<table cellpadding="0" cellspacing="0" >	

                  	<tr height="30"   >

				  		<td align="left" valign="top" bgcolor="#FFFFFF" colspan="3" >

							

                            <input type="text" name="search" id="search" value="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()"  size="25" />

                        </td>        

				  	</tr>	

                    <tr  class="rowColor3" id="onlineUsers1" style="float:left;">

                          	<td width="1%" align="left" valign="top">&nbsp;</td>

							<td width="20px" align="left" valign="top" >

							<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;"  />'; ?>

							</td>

							<td width="180" >

								<a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>"><?php echo wordwrap($myProfileDetail['tagName'],20,"<br />\n",true); ?> </a>

								

							</td>

							

					</tr>

					</table>

                  

					<?php

					if(count($workSpaceMembers) > 0)

					{

					

						$rowColor1 = 'rowColor6';

						$rowColor2 = 'rowColor5';	

						$i = 1;

						?> 

						

                        <table cellpadding="0" cellspacing="0" id="divSrchUser"><?php 	

						//show online users	

							 

						foreach($workSpaceMembers  as $keyVal=>$arrVal)

						{

							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		

							 //shows only online users on top

							 if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

							 {

						?>

						 <!-- <tr><td ><a onclick="showDivOnlineUsers1('onlineUsers3');"><img src="<?php  echo base_url().'images/list_icon.png'; ?>" style="margin-bottom:5px;" /></a></td></tr>-->

                          	<tr id="onlineUsers3" class="<?php echo $rowColor;?>" style="display:block; float:left;" >

                          	<td width="1%" align="left" valign="top">&nbsp;</td>

							<td width="20px" align="left" valign="top" ><?php echo '<img src="'.base_url().'images/online_user.gif"  width="15" height="16" style=" margin-top:5px;"  />'; ?></td>

							<td width="180"  >

								<a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true); ?> </a>

                           </td>

						  </tr>

						<?php

							$i++;

							 } 

							 

							} //close online users 

						

						//shows remaining offline users	 

						foreach($workSpaceMembers as $keyVal=>$arrVal)

						{

							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	

							

							//condition for showing (remaining)offline users	

							 if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

							 {

												

						?>			

						  <tr id="row1" class="<?php echo $rowColor;?>" style="float:left;">

                          	<td width="1%" align="left" valign="top">&nbsp;</td>

							<td width="20px" align="left" valign="top" ><?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16" style="margin-top:5px;" />';?>

							</td>

							<td width="180"  >

								

							<a href="javascript:void(0);" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" onclick="window.top.location='<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>'"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a>

                           							

                            </td>

							

						  </tr>

						<?php

							$i++;

							 }

							 

						}

						

					  ?>	 <?php

					}

				else

				{

				?>

					<tr>

						<td align="left" valign="top" bgcolor="#FFFFFF" colspan="3"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></td>       

					</tr>		

				<?php

				}

				 ?> </table> <?php 

				}

				else

				{

				

				?>	

				<table cellpadding="0" cellspacing="0" >

                  <tr height="30">

				  		<td align="left" valign="top" bgcolor="#FFFFFF" colspan="3">

                  		<input type="text" name="search" id="search" value="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()"  size="25" />							

                           

                        </td>        

				  </tr>	

				   <tr><td ><a <?php /*?>onclick="showDivOnlineUsers1('onlineUsers2');"<?php */?> ><img src="<?php  echo base_url().'images/list_icon.png'; ?>" style="margin-bottom:5px;" /></a></td></tr>

				   <tr id="onlineUsers2" class="rowColor1" style="display:block;">

                          	<td width="1%" align="left" valign="top">&nbsp;</td>

							<td width="20px" align="left" valign="top" >

							<?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;"  />'; ?>

							</td>

							<td width="180" >

								<a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" ><?php echo wordwrap($myProfileDetail['tagName'],20,"<br />\n",true); ?> </a>

								                            	

                           </td>

							

						  </tr>	

						 </table> 

                  

					<?php

					

				if(count($workSpaceMembers) > 0)

				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;

						

						?>

						

						<table cellpadding="0" cellspacing="0" id="divSrchUser" name="divSrchUser" class="on"> 

						

						<?php

						

						foreach($workSpaceMembers as $keyVal=>$arrVal)

						{

						

							//shows only online users on top

							 if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

							 {

								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						

						?>	

                       <?php /*?>  <tr><td ><a onclick="showDivOnlineUsers1('onlineUsers4');"><img src="<?php  echo base_url().'images/list_icon.png'; ?>" style="margin-bottom:5px;" /></a></td></tr>		<?php */?>

						  		<tr id="onlineUsers4" class="<?php echo $rowColor;?>" style="display:block;">

                           		<td width="1%" align="left" valign="top">&nbsp;</td>

								<td width="20px" align="left" valign="top" ><?php echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;"  />';  ?></td>

								<td width="180"  >

							 			<a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" ><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a>

								</td>

						  		</tr>

						<?php

							$i++;

							}

						}

						

						foreach($workSpaceMembers as $keyVal=>$arrVal)

						{

							//shows only offline users 

							 if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

							 {

							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						

						?>			

						  <tr id="row1" class="<?php echo $rowColor;?>" style="float:left;">

                            <td width="1%" align="left" valign="top">&nbsp;</td>

							<td width="20px" align="left" valign="top" ><?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16"  style="margin-top:5px;" />';?>

							</td>

							<td width="180"  >



							<a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" ><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a> 

							

							</td>

							

						  </tr>

						<?php

							$i++;

							}

						}

						 

						

				}

				else

				{

				?>

					<tr>

						<td align="left" valign="top" bgcolor="#FFFFFF" colspan="3"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></td>       

					</tr>		

				<?php

				}

				?> </table><?php 

				}

				?>    

                </td></tr>

            </table>

			

         

   



</div>

</div>

<div>

<?php //$this->load->view('common/foot_for_mobile');?>

<?php //$this->load->view('common/footer_for_mobile');?>

</div>

</body>

</html>

 <script language="javascript" src="<?php echo base_url();?>js/profile.js"></script>

<script>









	var http2 = getHTTPObjectm();

	//upload image using ajax 

 

// check all items

	function getHTTPObjectm() 

	{ 

		var xmlhttp; 

		if(window.XMLHttpRequest){ 

			xmlhttp = new XMLHttpRequest(); 

		}else if(window.ActiveXObject){ 

			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 

			if(!xmlhttp){ 

				xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 

			} 

		} 

		return xmlhttp; 

	} 



			

	</script>

	<script language="javascript">

	function displayname(){

		if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__'){

			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;

		}

	}

	function validate(){

		var error='';

		if(document.getElementById('company_name').value==''){

			error+='<?php echo $this->lang->line('req_company_name'); ?>\n';

		}		

		if(document.getElementById('first_name').value==''){

			error+='<?php echo $this->lang->line('req_first_name'); ?>\n';

		}

		if(document.getElementById('last_name').value==''){

			error+='<?php echo $this->lang->line('req_last_name'); ?>\n';

		}

		if(document.getElementById('display_name').value==''){

			error+='<?php echo $this->lang->line('req_tag_name'); ?>\n';

		}

		if(error){

			jAlert(error);

			return false;

		}else{

			return true;

		}

	}

	function reply_remove(id,focusId)

	{

		var divid=id+'notes';

		document.getElementById(divid).style.display='';

		document.getElementById('profileDetails').style.display='none';

		document.getElementById('profileDetailsEdit').style.display='none';

	}

	function message_reply(id,focusId)

	{

		var divid=id+'msgnotes';

		document.getElementById(divid).style.display='';

	}

	function reply_close(id,workSpaceId)

	{

		divid=id+'notes';

 		document.getElementById(divid).style.display='none';

		document.getElementById('allComment').style.display='block';

		

		//CKEDITOR.instances.replyDiscussion0.setData('');

		setValueIntoEditor('replyDiscussion0','');

		

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

	

	function hideBlock(hideDivId,url)

	{

		

 		document.getElementById(hideDivId).style.display='none';

	    var userId=document.getElementById('userId').value;

		var request1 = $.ajax({

			  url: url,

			  type: "POST",

			  data: 'userId='+userId,

			  //data: '',

			  dataType: "html",



			  success:function(result)

			  { 

				

				$("#workPlaceDiv").html(result);

			  }

	   });

	   changViewProfileLabel();

	}

	

	

	function hideBlock(hideDivId)

	{

		

 		document.getElementById(hideDivId).style.display='none';

	    var userId=document.getElementById('userId').value;

		

	   changViewProfileLabel();

	}

	

	function editNotesContents(id,focusId)

	{

		var divid=id+'edit_notes';

		//alert (divid);

		document.getElementById(divid).style.display='';

	}

	

function showNotesNodeOptions(position)

{	

	//alert ('Pos= ' + position);	

	var notesId = 'normalView'+position;	

	if(position > 0)

	{

		document.getElementById('normalView0').style.display = "none";

	}	

	if(document.getElementById(notesId).style.display == "none")

	{			

		document.getElementById(notesId).style.display = "";

	}

	else

	{

		document.getElementById(notesId).style.display = "none";

	}

	/*

	var totalNodes = document.getElementById('totalNodes').value;

	//alert (totalNodes);

	var nodesArray = totalNodes.split(",");

	

	//alert ('counter= ' +nodesArray.length);

	for(var i=0; i<nodesArray.length; i++)

	{

		if(nodesArray[i] != position)

		{

			notesId = 'normalView'+nodesArray[i];	

			//alert (notesId);

			document.getElementById(notesId).style.display = "none";

		}

	}

	*/

}

function validate_dis(replyDiscussion,formname,url,nodeOrder)

{

	var error='';

    //alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	//replyDiscussion1=replyDiscussion+'1';

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

	

	var getValue= getvaluefromEditor(INSTANCE_NAME);

	//var getValue=CKEDITOR.instances[INSTANCE_NAME].getData();

	

	if(getValue == '')

	{

		error+='<?php echo $this->lang->line('enter_your_comment'); ?>\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error=='')

	{

	     /*Changed by surbhi IV*/

		//formname.submit();

		 var urgent=document.getElementById('urgent').checked; 

		 if(urgent)

		 {

		    urgent=1;

		 }

		 else

		 {

		    urgent='';

		 }

		 var recipientsCount=document.getElementsByName("recipients[]").length;

		 var recipients=new Array();

		 for(var i=1;i<=recipientsCount;i++)

		 {

		     if(document.getElementById("recipients_"+i).checked)

			 {

			    recipients[i]=document.getElementById("recipients_"+i).value;

			 }	

		 }

		 var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: 'editorname1=replyDiscussion0&reply=1&nodeOrder'+nodeOrder+'&urgent='+urgent+'&recipients='+recipients+'&replyDiscussion0='+encodeURIComponent(getValue),

				  //data: '',

				  dataType: "html",

				  success:function(result)

				  {

					  //document.getElementById('userDetailContainer').innerHTML= result;

					  //tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion0');

					  //CKEDITOR.instances[INSTANCE_NAME].destroy();

					  

					  getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

				  }

		   });

		   /*End of Changed by surbhi IV*/

	}

	else

	{

		jAlert(error);

	}	

}

/*Added by surbhi IV*/

function updateStatus(url)

{

   var memberId=document.getElementById('memberId').value;

   var workSpaceId=document.getElementById('workSpaceId').value;

   var workSpaceType=document.getElementById('workSpaceType').value;

   var workSpaceId_search_user=document.getElementById('workSpaceId_search_user').value;

   var workSpaceType_search_user=document.getElementById('workSpaceType_search_user').value;

   var statusUpdate=document.getElementById('statusUpdate1').value;

   var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: 'memberId='+memberId+'&workSpaceId='+workSpaceId+'&workSpaceType'+workSpaceType+'&workSpaceId_search_user='+workSpaceId_search_user+'&workSpaceType_search_user='+workSpaceType_search_user+'&statusUpdate='+statusUpdate,

				  //data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

				  }

		   });

}  

function confirmDeleteComment(url)

{

	if (confirm("<?php echo $this->lang->line('sure_to_delete_message'); ?>"))

	{

		//return true;

		var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

				  }

		   });

	}

	else

	{

		return false ;

	}

}

function confirmDeleteComment1(url)

{ 

	if (confirm("<?php echo $this->lang->line('sure_to_delete_message'); ?>"))

	{

		//return true;

		var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 $('#msgDiv').html(result);

				  }

		   });

	}

	else

	{

		return false ;

	}

}

/*End of Added by surbhi IV*/

</script>



<script>

		function edit_close(pos,nodeId){



		var divId=pos+'edit_notes';

		var editorId = 'editDiscussion'+nodeId;



		document.getElementById(editorId).style.display='none';

		document.getElementById(divId).style.display='none';

		}

	</script>

	<script>

	var msgId1;

	var userId1;

	var textDone1;

	var commenterId1;

	function editNotesContents_1(msgId,userId,textDone,commenterId)

	{



		msgId1=msgId;

	 	userId1=userId;

	  	textDone1=textDone;

		commenterId1=commenterId;

	 

	 	if(document.getElementById('editStatus').value == 1)

		{

			jAlert('<?php echo $this->lang->line('save_close_current_reply'); ?>');

			//return false;

		}

		else

		{

			// position1=position;

			var temp=handleNoteLockLeafEdit();

		}

	

	}



function editLeafNote(leafId, leafOrder,treeId,nodeId) 

{  

	

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

						jAlert ('<?php echo $this->lang->line('can_not_edited'); ?>');

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

function handleNoteLockLeafEdit()

{

				

				document.getElementById('editStatus').value = 1;

				//var val=document.getElementById('initialleafcontent'+leafOrder1).value;

				document.getElementById('editleaf'+msgId1).style.display="";

				//document.getElementById('editStatus').value = 1;

								

				editor_code('','editorLeafContents'+msgId1+'1','editleaf'+msgId1);

				//var contents=document.getElementById('leaf_contents'+id1).innerHTML;

	

				document.getElementById('editorLeafContents'+msgId1+'1sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="editLeafSave1('+msgId1+','+commenterId1+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="canceleditLeaf1('+msgId1+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

				

				chnage_textarea_to_editor('editorLeafContents'+msgId1+'1');

				setValueIntoEditor('editorLeafContents'+msgId1+'1',contents);	

				xmlHttpLast11=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+nodeId1;

				xmlHttpLast11.onreadystatechange=function() {

				if (xmlHttpLast11.readyState==4) {

					

					document.getElementById('editStatus').value = 1;

								

						}

					}

						

				xmlHttpLast11.open("GET", url, true);

				xmlHttpLast11.send(null);

					

}



function canceleditLeaf1(msgId) 

{

  	 

		document.getElementById('editleaf'+msgId).style.display="none";

		document.getElementById('editStatus').value= 0;		

	

}



function editLeafSave1(msgId,commenterId) 

{	

  //document.getElementById('editleaf'+leafOrder).style.display="none";

	document.getElementById('editStatus').value= 0;		

		

	var editorId = "editorLeafContents"+msgId+"1"; 

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value; 

		if (getvalue=='')

		{

			jAlert ('<?php echo $this->lang->line('enter_your_reply'); ?>');

			return false;

		}

	

	//var originalContents = document.getElementById('initialleafcontent'+leafOrder).value;

	//document.form2.curContent.value = getvalue;

	document.form2.msgId.value = msgId;	

	document.form2.commenterId.value = commenterId;

			

	document.form2.submit();		

	return true;

}



function showTags()

{

    

	var toMatch = document.getElementById('searchTags').value;

	var val = '<input type="checkbox" name="checkAll" id="checkAll" /><?php echo $this->lang->line('txt_All');?><br />';

	

		//if (toMatch!='')

		if(1)

		{

		var count = '';

		var sectionChecked = '';

		<?php

       

		foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)

		{

		  if($workPlaceMemberData['userId']!=$_SESSION['userId'] && $workPlaceMemberData['userId']!=$this->uri->segment(3) ){

		?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			

			

			if (str.match(pattern))

			{	

				val +=  '<input class="clsCheck" type="checkbox" name="recipients[]" value="<?php echo $workPlaceMemberData['userId'];?>" /><?php echo $workPlaceMemberData['tagName'];?><br>';

			}

        

		<?php

			

        }

		

        ?>document.getElementById('showMan').innerHTML = val;

			

			

			document.getElementById('showMan').style.display = 'block';

		<?php 	} ?>

		}

		else

		{

			document.getElementById('showMan').style.display = 'none';

		}



}



// Arun- function returns search users 

function showSearchUser()

{

     

	var toMatch = document.getElementById('search').value;

	var val='';

	

		//if (toMatch!='')

		if (1)

		{

		

		var count = '';

		var sectionChecked = '';

		

		var rowColor1='rowColor2';

		var rowColor2='rowColor1';	

		var rowColor;

		var i = 1;

		//val+='<table cellpadding="0" cellspacing="0" id="divSrchUser">';

		<?php

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;		

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				val+='<tr id="row1" class="'+ rowColor+'"><td width="1%" align="left" valign="top">&nbsp;</td><td width="20" align="left" valign="top" ><?php echo "<img src=\' ".base_url()."images/online_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?></td><td ><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo  str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></td></tr>';

				 i++;

			}

        

		<?php

			

			

        }

		}

		

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;	

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				

				

				val+='<tr id="row1" class="'+rowColor+'"><td width="1%" align="left" valign="top">&nbsp;</td><td width="20px" align="left" valign="top" ><?php echo "<img src=\' ".base_url()."images/offline_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?></td><td ><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></td></tr>';

						  

				i++;	 

				

			}

		<?php

			

        }

		}

		

        ?>

		

			val+='';

			//$('#divSrchUser').html(val);

			document.getElementById('divSrchUser').innerHTML=val;

			

			//document.getElementById('divSrchUser').style.display = 'block';

		

		}

		else

		{

			//document.getElementById('divSrchUser').style.display = 'none';

		}



}

	

var workSpaceIdSearchUser;

var workSpaceIdSearchType;	

//this function used to change the user WorkSpace



function goWorkSpace_user(workSpaceId_search_user)

{	



	if(workSpaceId_search_user.value != '')

	{		

		if(workSpaceId_search_user.value.substring(0,1) == 's')

		{

			

			var tmpArray = workSpaceId_search_user.value.split(',');

			var url = baseUrl+'profile/index/<?php echo $this->uri->segment(3); ?>/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[1]+'/2';

			workSpaceIdSearchUser=tmpArray[1];

			workSpaceIdSearchType=2;

		}

        else

		{

			

			var url = baseUrl+'profile/index/<?php echo $this->uri->segment(3);  ?>/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId_search_user.value+'/1';

			workSpaceIdSearchUser=workSpaceId_search_user.value;

			workSpaceIdSearchType=1;

		}		

		

		window.location=url;

		

	}

}



var ie = (document.all) ? true : false;

function openConvertDiscussBlock(messageId)

{



		closeConvertDiscussBlock();



		document.getElementById('anchorMessage_'+messageId).style.display='none';

		document.getElementById('divMessage_'+messageId).style.display='block';



}



function closeConvertDiscussBlock()

{

		objClass='divMessage';

		var elements = (ie) ? document.all : document.getElementsByTagName('*');

  for (i=0; i<elements.length; i++){

    if (elements[i].className==objClass){

      elements[i].style.display="none"

    }

  }

  

  objClass='anchorMessage';

		var elements = (ie) ? document.all : document.getElementsByTagName('*');

  for (i=0; i<elements.length; i++){

    if (elements[i].className==objClass){

      elements[i].style.display="block"

    }

  }

		

}





function submitConvertMessageToDiscuss()

{

	if(document.getElementById('selectDiscussTree').value==0)

	{

		jAlert("<?php echo $this->lang->line('select_discuss'); ?>");

		return false;

		

	}

	

	if(confirm("<?php echo $this->lang->line('are_you_really_want_move_msg_discuss'); ?>"))

	{

		return true;

		

	}

		return false;

	

	



}



//Arun- function perform check/uncheck all user list in add new messages 

$(document).ready(function(){



	$("#checkAll").live('click',function(){

			if($('input[name=checkAll]').is(':checked'))

			{

				

				$('.clsCheck').attr('checked', true);

			}

			else

			{

				

				$('.clsCheck').attr('checked', false);

			}

	});

	

	

});



</script>

<script>

//Arun: get user details through ajax

getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

</script>





