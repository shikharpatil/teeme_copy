<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Teeme Discussions</title>

	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>

 	

	<style type="text/css">

<!--

.style1 {font-size: 10px}

.style2 {font-size: 11px}

.style4 {font-size: 11px; font-weight: bold; }

-->

    </style><script>

	var baseUrl='<?php echo base_url();?>';

	var lastframeid=0;

	var rameid=0;

	function blinkIt() {

	 if (!document.all) return;

	 else {

	   for(i=0;i<document.all.tags('blink').length;i++){

		  s=document.all.tags('blink')[i];

		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';

	   }

	 }
	 
	 //Add SetTimeOut 
	 setTimeout("blinkIt()", 500);

	}

	function showFocus()

	{

	//setInterval('blinkIt()',500);
	
	//Add SetTimeOut 
	setTimeout("blinkIt()", 500);

	//alert(lastframeid);

		//parent.frames[lastframeid].gk.EditingArea.focus();

	}</script>

	</head>	

	<body onLoad="showFocus();">

<!--webbot bot="HTMLMarkup" startspan -->



<script>

 



function validate_dis(replyDiscussion,formname){

	var error=''

//	alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	replyDiscussion1=replyDiscussion+'1';

	if(document.getElementById(replyDiscussion1).value=='<DIV id=1-span><P>&nbsp;</P></DIV>'){

		error+='<?php echo $this->lang->line('enter_your_reply_discussion'); ?>\n';

	}

	if(error==''){

		formname.submit();

	}else{

		jAlert(error);

	}

	

}

</script>



<!--webbot bot="HTMLMarkup" startspan -->

<p>

<script>

if (!document.layers)

{

	document.write('<div id="divStayTopLeft" style="position:absolute">')

}

</script>

</p>

<layer id="divStayTopLeft">

<!-- Float Manu Bar -->

<?php $this->load->view('common/float_menu');?>

<!-- Float Menu Bar -->                                      

</p>

</layer>



<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>

     

<table width="88%" border="1" align="center" cellpadding="0" cellspacing="0">

<tr>

		<td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

			  <td width="231" align="left" valign="top"><img src="<?php echo base_url();?>images/logo.gif" alt="logo" width="157" height="75" /></td>

			  <td colspan="2" align="right" valign="middle">				<strong>

					<?php

					echo $_SESSION['workPlaceManagerName'];

					?>

					<br>

					[ <?php echo anchor('admin/admin_logout/work_place', $this->lang->line('txt_Sign_Out'));?> ]</strong></td>

			</tr>

			<tr>

			  <td width="231" colspan="2" align="left" valign="top" nowrap class="tdSpace"><span class="style2"><?php echo $this->lang->line('txt_Discussion');?></span>: <?php echo $DiscussionTitle;?></td>

			  <td width="234" align="left" valign="middle"><span class="style2"><?php echo $this->lang->line('txt_Date');?></span>: <?php echo $DiscussionCreatedDate;?></td>

		  </tr>

		</table></td>

	  </tr>

	  <tr>

		<td colspan="2" valign="top"><script>var vkidList=new Array();</script>

		<?php if($perentId){?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">

			  <tr>

				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

				<td height="21" align="left" valign="bottom" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;"> <?php // print_r( $myperentId);?><?php  if(count($myperentId) > 0){

				?> <span class="style4"><a href="<?php echo base_url();?>view_discussion/Discussion/<?php echo $myperentId['id'] ;?>"><img src="<?php echo base_url();?>images/left.gif" alt="Up" vspace="0" border="0" /></a> 

                </span><?php }?>&nbsp; <span id="newvk123" class="style1" style="text-decoration:blink; color:#FF0000;"></span></td>

				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

		  </tr>

			  <tr>

				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>

				<td><?php echo stripslashes($DiscussionPerent['contents']);?><br>

			<div id="reply_teeme" style="display:none; position:fixed; margin-top:0px; margin-left:20px;">	<p onMouseOver="vksfun(-1);">



		<form name="form1" method="post" action="<?php echo base_url();?>new_discussion/index">

	&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('replyDiscussion', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); 

	//document.frames[frameIndex].gk.EditingArea.focus();

	</script>

		  <!--textarea name="replyDiscussion" cols="54" rows="5" id="replyDiscussion"></textarea-->

                <input type="button" name="Replybutton" value="Reply" onClick="validate_dis('replyDiscussion',document.form1);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close('reply_teeme');">

		        <input name="reply" type="hidden" id="reply" value="1">

				 <input name="editorname1" type="hidden"  value="replyDiscussion">

		        <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">

			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

		</form>

		

		&nbsp;</p></div>

</td>

				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>

			  </tr>

			  <tr>

				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right"><a href="javascript:reply1('reply_teeme');"><?php echo $this->lang->line('txt_Reply');?></a>&nbsp;</td>

				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

			  </tr>

		  </table>

		  <script>//markread(<?php echo $perentId;?>,'vk123');</script>

		<?php 

		}?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" >

		<tr><td width="7%">&nbsp;</td><td>

		<?php

		$lastframeid=0;

		if(count($DiscussionReply) > 0)

		{							 

		

			foreach($DiscussionReply  as $keyVal=>$arrVal)

			{

			

			$user_leaf=$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);

			$treeIDforLeaf=$this->chat_db_manager->gettreeByLeaf($arrVal['leafId']);

			$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['leafId'], $_SESSION['userId']);

			//echo $arrVal['leafId'];

			//print_r($treeIDforLeaf);	

			?>

				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;" id="table<?php echo $position;?>">

			  <tr>

				<td width="26" height="21" background="<?php echo base_url();?>images/topleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

				<td align="left" height="21" background="<?php echo base_url();?>images/topbg.jpg" style="background-repeat:repeat-x;"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="90%" align="left" onClick="detail(<?php echo $position;?>,<?php echo $arrVal['leafId'];?>);"><span class="style1"><?php echo $this->lang->line('txt_By').' '.$user_leaf['firstName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], 'm-d-Y h:i A');?></span>&nbsp;&nbsp;<span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;"> <?php if(!$viewCheck){ echo '<blink>'.$this->lang->line('txt_New').'</blink>';

	}?></span></td><td align="right" style="padding-right:10px;"><?php 

 				if(count($treeIDforLeaf)){

				?><a href="<?php echo base_url();?>view_discussion/Discussion/<?php echo $treeIDforLeaf['id'];?>"><img src="<?php echo base_url();?>images/right.gif" alt="Down" border="0" /></a><?php } ?></td>

    <td align="right"><img src="<?php echo base_url();?>images/plus.gif" id="img<?php echo $position;?>" alt="Detail" border="0" onClick="detail(<?php echo $position;?>,<?php echo $arrVal['leafId'];?>);" /><?php

	if(count($treeIDforLeaf)){?><!--a href="<?php echo base_url();?>view_Discussion/Discussion/<?php echo $treeIDforLeaf['id'];?>"><img src="<?php echo base_url();?>images/down.jpg" alt="Down" border="0" /></a--><?php }else{?><!--a href="javascript:reply('reply_teeme<?php echo $position;?>',<?php echo $position;?>);">Reply</a--><?php }?></td>

  </tr>

</table>

</td>

				<td width="25" height="21" background="<?php echo base_url();?>images/topright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

			  </tr>

			  <tr style="visibility:hidden;" id="con<?php echo $position;?>" onClick="rameid=<?php echo $lastframeid;?>;">

				<td width="26" background="<?php echo base_url();?>images/leftbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>

				<td><?php echo stripslashes($arrVal['contents']);?><br>

<div id="reply_teeme<?php echo $position;?>" style="display:none; position:fixed; margin-top:0px; margin-left:20px;">

			<p onMouseOver="vksfun(<?php echo $position;?>);">

<?php if(count($treeIDforLeaf)){?>

			<form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_discussion/index">

			<input name="treeId" type="hidden" value="<?php echo $treeIDforLeaf['id'];?>"><?php }else{?>

			<form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_discussion/start_Discussion/<?php echo $arrVal['leafId'];?>">

			<input name="title" type="hidden" value="  ">

			<?php }?>

	&nbsp;&nbsp;&nbsp;	 <script> editorTeeme('replyDiscussion<?php echo $arrVal['nodeId'];?>', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); </script>

                 <input type="button" name="Replybutton" value="Reply" onClick="validate_dis('replyDiscussion<?php echo $arrVal['nodeId'];?>',document.form12<?php echo $position;?>);"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Replybutton1" value="Cancel" onClick="reply_close('reply_teeme<?php echo $position;?>');">

		        <input name="reply" type="hidden" id="reply" value="1">

				 <input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrVal['nodeId'];?>">

				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">

				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">

		        <?php // echo $arrVal['leafId'];?>

		</form></p>

			<?php  $lastframeid++;?></script>

			</div></td>

				<td width="25" background="<?php echo base_url();?>images/rightbg.jpg" style="background-repeat:repeat-y;">&nbsp;</td>

			  </tr>

			  <tr style="visibility:hidden;" id="footer<?php echo $position;?>">

				<td width="26" height="27" background="<?php echo base_url();?>images/botleft.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

				<td height="27" background="<?php echo base_url();?>images/botbg.jpg" style="background-repeat:repeat-x;" align="right">&nbsp;<a href="javascript:reply('reply_teeme<?php echo $position;?>',<?php echo $position;?>,<?php echo $arrVal['leafId'];?>);"><?php echo $this->lang->line('txt_Reply');?></a></td>

				<td width="25" height="27" background="<?php echo base_url();?>images/botright.jpg" style="background-repeat:no-repeat;">&nbsp;</td>

			  </tr>

			</table>

			

			<script>

			vkidList[<?php echo $position;?>]=0;

			lastleafId=<?php echo $arrVal['leafId'];?>;

			</script>					

			<?php

			$position++;			

			 }

		}?>

		

		</td></tr></table>



<script>

var lastNode=<?php echo $position-1;?>;

vkidList[lastNode]=1;

</script>

</td>

	  </tr>

	 

	  <tr>

		<td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:1px solid #D9E3F2;border-right:1px solid #D9E3F2">

			<tr>

			  <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:1px solid #D9E3F2;" >

				

				  <tr>

				    <td class="tdSpace"></td>

			    </tr>

			  </table></td>

		    </tr>

		</table></td>

	  </tr>	

	 

	</table>     



<script>





function detail(id,leafIdview){

	var contentId='con'+id;

	var footerId='footer'+id;

	var tableId='table'+id;

	var imgId='img'+id;

	if(lastNode== id){

		document.getElementById(contentId).style.visibility='visible';

		document.getElementById(footerId).style.visibility='visible';

		document.getElementById(imgId).src='<?php echo base_url();?>images/minus.gif';

	}else{

		if(vkidList[id]){

			document.getElementById(contentId).style.visibility='hidden';

			document.getElementById(footerId).style.visibility='hidden';

			document.getElementById(imgId).src='<?php echo base_url();?>images/plus.gif';

			vkidList[id]=0;

		}else{

			document.getElementById(contentId).style.visibility='visible';

			document.getElementById(footerId).style.visibility='visible';

			document.getElementById(imgId).src='<?php echo base_url();?>images/minus.gif';

			vkidList[id]=1;

		}

	}

	var j=0;

	var marginh=0;

	 

	for( var i=1; i<=lastNode; i++){

		j=i-1;

		marginh=0;

		 

		if(vkidList[j]){

		

		}else{

			 tableId='table'+j;

			marginh=document.getElementById(tableId).scrollHeight;

			//alert(marginh);

			marginh=parseInt(marginh)-20;

			

		

		}

		tableId='table'+i;

		document.getElementById(tableId).style.marginTop='-'+marginh+'px';

	

	}

	markread(leafIdview,id);

}

var positionId;

function createXMLHttpRequest1() 

{

	if (window.ActiveXObject) 

	{

		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

	} 

	else if (window.XMLHttpRequest) {

		xmlHttp = new XMLHttpRequest();

	}

}

function handleStateChange1() 

{

	if(xmlHttp.readyState == 4) 

	{

		if(xmlHttp.status == 200) 

		{

			 if(xmlHttp.responseText!='unread'){

			 	document.getElementById(positionId).innerHTML='';

			 }else{

			 	document.getElementById(positionId).innerHTML='<blink>New</blink>';

			 }

		}

	}

}

function markread(leaf,posiId){

	var url = baseUrl+'view_discussion/readDiscussion/'+leaf;	  

		createXMLHttpRequest1();

		queryString =   url; 	

		positionId='new'+posiId;

		xmlHttp.onreadystatechange = handleStateChange1;	

		xmlHttp.open("GET", queryString, false);

		xmlHttp.send(null);

		//alert('leaf:'+leaf);

}

detail(lastNode,lastleafId);

function reply(divid,id,leafIdvk){

	var contentId='con'+id;

	var footerId='footer'+id;

	<?php if($perentId){?>

	var fId=id+1;

	<?php }else{?>

	var fId=id;

	<?php }?>

	vkidList[id]=0;

	//detail(id,leafIdvk);

	document.getElementById(divid).style.display='';

	parent.frames[fId].gk.EditingArea.focus();

	rameid=fId;

	//document.getElementById(contentId).style.visibility='visible';

	//document.getElementById(footerId).style.visibility='visible';

	

}

function vksfun(id){

var fId=id+1;

rameid=fId;

}

function reply1(divid){

	

	document.getElementById(divid).style.display='';

	parent.frames[0].gk.EditingArea.focus();

	rameid=0;

	

}

function reply_close(divid){

 	document.getElementById(divid).style.display='none';

}

</script>

 </body>

</html>