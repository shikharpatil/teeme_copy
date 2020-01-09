<?php 

//arun - variable used for fetch data for real time talk from data base

$_SESSION['commentTimeStamp']='0'; 



//arun-This variable contains last comment of message for not repeate commaint again in message comments list

$_SESSION['lastCommentId']=0;



//arun-varialbe used for real time chat view

$_SESSION['i']=1;

?>

<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="viewport" content="width=device-width, user-scalable=no" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>

<?php $this->load->view('editor/editor_js.php');?>

</head>

<body style="background-color:#FFFFFF;" onload="request_refresh();getWidth();">

<div class="fixedDiv" style="max-height:100px; width:98%;">

  <div class="seedBgColor talkTitleDiv" style="width:97%;"> <span id="msgTitle"> 

    <span id="short">

    <?php

		echo $this->identity_db_manager->formatContent($msgDetail->comment,200,1);

	if(strlen($msgDetail->comment)>200 && strpos($msgDetail->comment,"<img")==-1){

  ?>

    </span>

    <a id="textShort"  href="javascript:showHideContent('textShort')">...More</a> 

    <span id="full" style="display:none;">

    <?php

		echo stripslashes($msgDetail->comment);

  ?>

    </span><a  style="display:none;" id="textlong" href="javascript:showHideContent('textlong')">Less</a> </span>

    <?php

		}?>
	
	</div>

    <div style="padding-left:36px; background:#dedfe2;">

      <?php  echo $seedUserDetail['userTagName'];?>

      &nbsp;&nbsp;

      <span>

      	<?php

		echo $this->time_manager->getUserTimeFromGMTTime($msgDetail->commentTime,$this->config->item('date_format'));

		?>

      </span>

      <?php 

		//Arun- only message originator edits messages.

		if($this->uri->segment(4)==$_SESSION['userId']){?>

            <span> 

                <a href="javascript:void(0)" onclick="editComment()" ><img border="0" title="Edit" src="<?php echo base_url(); ?>/images/editnew.png">

                    <?php //echo $this->lang->line('txt_Edit'); ?>

                </a> 

            </span>

      <?php

		}

		?>

    </div>

</div>

<div class="clr"></div>

<div class="commentDiv talkTreeComments" style="top:100px; margin-top:25px;" >

  <div id="divEditComment" style=" margin-top:0px; display:none">

    <form name="form0" method="post" id="frmEditComment" action="" >

      &nbsp;&nbsp;&nbsp;

      <textarea name="editComment" id="editComment"><?php echo stripslashes($msgDetail->comment); ?></textarea>

      <input type="button" name="editComment" value="<?php echo $this->lang->line('txt_Post');?>" onClick="validate_edit_comment('<?php echo base_url(); ?>profile/editMessage');" class="button01">

      

      <!--<input type="button" name="editCommentCancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="setValueIntoEditor('editComment','<?php echo  str_replace(chr(10),"",stripslashes($msgDetail->comment));?>')" class="button01"> -->

      <input type="button" name="editCommentCancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="document.getElementById('divEditComment').style.display='none';" class="button01">

      <input type="hidden" id="commentId" name="commentId" value="<?php echo $this->uri->segment(3);?>" >

      <input type="hidden" id="commenterId" name="commenterId" value="<?php echo $this->uri->segment(4);?>" >

    </form>

  </div>

  <?php	

	$focusId = 2;

	$totalNodes = array();

	$rowColor1='rowColor3';

	$rowColor2='rowColor4';	

	$i = 1;	

	?>

  <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

  <div style="width:100%; overflow:auto"> <span id="comment_msg"></span> </div>

  <div id="reply_teeme10" style=" margin-top:0px;margin-left:15px; "> <br><br>

    <b><?php echo $this->lang->line('txt_Add_comment');?>:</b><br>

    <form name="form0" method="post" >

      &nbsp;&nbsp;&nbsp;

      <div class="msgCmntsDiv">

        <textarea name="replyDiscussion" id="replyDiscussion"></textarea>

      </div>

      <div class="msgCmntsDiv">

        <input style="float:left;" type="button" id="Replybutton" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="validate_dis();" class="button01">

        <input style="float:left;" type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Clear');?>" onClick="setValueIntofroalaEditor('replyDiscussion','');" class="button01">
		
		<div id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>

      </div>

      <input type="hidden" id="commentId" name="commentId" value="<?php echo $this->uri->segment(3);?>" >

      <input type="hidden" id="commenterId" name="commenterId" value="<?php echo $this->uri->segment(4);?>" >
	  
	  

    </form>
	<div style="clear:both"></div>
	

  </div>

  

  <!-- Main Body -->

  <?php $this->load->view('common/foot.php');?>

</div>

</body>

</html>

<script>setInterval("request_refresh()", 4000);</script>

<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

		

	</script>

<script language="javascript">

	chnage_textarea_to_editor('editComment','simple');</script>

<script>

	function getHTTPObjectm() { 

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



	var http2 = getHTTPObjectm();

function request_refresh(){

	var commentId=document.getElementById('commentId').value;

	var commenterId=document.getElementById('commenterId').value;

	url='<?php echo base_url();?>profile/getReplyByCommentId/'+commentId+'/'+commenterId;

	

	http2.open("GET", url,true); 

	http2.onreadystatechange = handleHttpResponsem2; 

	http2.send(null);



}

	var baseUrl='<?php echo base_url();?>';

	var lastframeid=0;

	var rameid=0;

/*	function blinkIt() {

	 if (!document.all) return;

	 else {

	   for(i=0;i<document.all.tags('blink').length;i++){

		  s=document.all.tags('blink')[i];

		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';

	   }

	 }

	}*/

 	

	var mystart='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';

	var myend='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';

	function changes_date(newsdate,newedate){

		mystart=newsdate;

		myend=newedate;

	}

	



	var baseUrl='<?php echo base_url();?>';

	var lastframeid=0;

	var rameid=0;

	/*function blinkIt() {

	 if (!document.all) return;

	 else {

	   for(i=0;i<document.all.tags('blink').length;i++){

		  s=document.all.tags('blink')[i];

		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';

	   }

	 }

	}

	function showFocus()

	{

	setInterval('blinkIt()',500);

	

	}*/

	function validate_dis_old(replyDiscussion,formname){

		var error='';

		

		if(getvaluefromEditor(replyDiscussion) == ''){

			error+='<?php echo $this->lang->line('msg_enter_comment');?>';

		}

	

	

		if(error==''){

			formname.submit();

		}else{

			jAlert(error);

		}

	}

	var pnodeId1;



function validate_edit_comment(url) 

{  

	var error=''

		

	//var getValue=CKEDITOR.instances.editComment.getData();

	var getValue=getvaluefromEditor('editComment');

	

	if (getValue == ''){

		error+='<?php echo $this->lang->line('enter_your_msg'); ?>';

	}

	

	if(error=='')

	{

		//document.getElementById('frmEditComment').submit();

		   var commentId=document.getElementById('commentId').value;

		   var commenterId=document.getElementById('commenterId').value;

		   

		   var request1 = $.ajax({

						  url: url,

						  type: "POST",

						  data: 'commentId='+commentId+'&commenterId='+commenterId+'&editComment='+encodeURIComponent(getValue),

						  //data: '',

						  dataType: "html",

						  success:function(result)

						  {

							var r=result.split('#########$##########');

							document.getElementById('divEditComment').style.display='none';

							$("#msgTitle").html(r[0]);

						}

				   });

	}

	else

	{

		jAlert(error);

	} 	

}

function validate_dis() 

{  

	

	var error=''	

	//var getValue=CKEDITOR.instances.replyDiscussion.getData();

	var getValue=getvaluefromEditor('replyDiscussion');

	setValueIntoEditor('replyDiscussion','');

	

	if (getValue == ''){

		error+='<?php echo $this->lang->line('enter_your_comment'); ?>';

	}

	

	if(error=='')

	{

		request_refresh_point=0;

		request_send(getValue);

	}

	else

	{

		jAlert(error);

	} 	

}



var http1 = getHTTPObjectm();

var replay_target=1;

var start_chat_val=1;

$('.commentDiv').css('top',$('.fixedDiv').css('height'));

function request_send(getValue)

{	

	

	replay_target=1;

	if(replay_target)

	{

		var replyDiscussion='replyDiscussion';

		var jsData = getValue;

		//var jsData = getvaluefromEditor(replyDiscussion,'simple');

		var commentId=document.getElementById('commentId').value;

		var commenterId=<?php echo $_SESSION['userId']; ?>;

		urlm='<?php echo base_url();?>profile/insertMessageReplyFromTalk';

		data='workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&commentId='+commentId+'&commenterId='+commenterId+'&replyDiscussion='+encodeURIComponent(jsData);

		

	}

	http1.open("POST", urlm, true); 

	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http1.onreadystatechange = handleHttpResponsem1;     

	http1.send(data);

	

}



function handleHttpResponsem1() 

{    

	if(http1.readyState == 4) { 

		if(http1.status==200) { 

			var results=http1.responseText; 

			//window.opener.getUserDetail('<?php echo $_SESSION['userId'];?>','<?php echo $_SESSION['workSpaceId1'] ;?>','<?php echo $_SESSION['workSpaceType1'] ;?>','1','1'); 

			//document.getElementById('comment_msg').innerHTML +=results;

			

			document.getElementById('replyDiscussion').value='';

			

			//setValueIntoEditor ('replyDiscussion','','simple');

			//CKEDITOR.instances.replyDiscussion.setData('');

			// chnage_textarea_to_editor('replyDiscussion','simple');

			 

			//window.top.location='#msgCmntsDiv';

			$(".fr-element").html("");
	

			request_refresh_point=1;

			

		}

	}

}



function handleHttpResponsem2() 

{    

	if(http2.readyState == 4) { 

		if(http2.status==200) { 

			var results=http2.responseText;

			

			document.getElementById('comment_msg').innerHTML += results;

			

			document.getElementById("comment_msg").scrollTop =document.getElementById("comment_msg").scrollHeight;

			$("p > img").css({"height":"60px","width":"70px"});

			

		}

	}

}

chnage_textarea_to_editor('replyDiscussion');

function editComment()

{



	if(document.getElementById('divEditComment').style.display=='none')

		{ document.getElementById('divEditComment').style.display='block';}

	 else 

	 { document.getElementById('divEditComment').style.display='none';}

	 var val1=document.getElementById('msgTitle').innerHTML;

	 //setValueIntoEditor('editComment','<?php echo  str_replace(chr(10),"",stripslashes($msgDetail->comment));?>');

	 

	 //CKEDITOR.instances.editComment.setData(val1);

	 

	 setValueIntoEditor('editComment',val1);

	

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

					 //request_refresh();

					 var commentId=document.getElementById('commentId').value;

					 var commenterId=document.getElementById('commenterId').value;

					 var url1='<?php echo base_url();?>profile/getReplyByCommentId/'+commentId+'/'+commenterId;

		             var request1 = $.ajax({

							  url: url1,

							  type: "POST",

							  data: '',

							  dataType: "html",

							  success:function(result1)

							  {

								$("#msgDiv").html(result1);

							  }

					   });

				  }

		   });

	}

	else

	{

		return false ;

	}

}



function showHideContent(obj){

	if(obj =='textShort'){

		document.getElementById('short').style.display='none';document.getElementById('full').style.display='block';document.getElementById('textShort').style.display='none';document.getElementById('textlong').style.display='block';

	}

	else if(obj =='textlong'){

		document.getElementById('short').style.display='block';document.getElementById('full').style.display='none';document.getElementById('textShort').style.display='block';document.getElementById('textlong').style.display='none';

	}

	$('.commentDiv').css('top',$('.fixedDiv').css('height'));

}

function getWidth(){

	$("#short > img").css({"height":"60px","width":"70px"});

}
//Manoj: clear froala editor 
function setValueIntofroalaEditor()
{
	$(".fr-element").html("");
}

</script>

<!--<script language="JavaScript1.2">mmLoadMenus();</script>-->