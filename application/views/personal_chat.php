<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
		var replay_target=0;
	</script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>
	<style type="text/css">
<!--
.style1 {font-size: 10px;}
-->
    </style>
</head>

<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
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
<?php $this->load->view('common/float_menu_artifacts');?>
<!-- Float Menu Bar -->                                      
</p>
</layer>

<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
  <tr>
    <td valign="top">
        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">
			<!-- header -->	
			<?php $this->load->view('common/header'); ?>
			<!-- header -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">
				<?php $this->load->view('common/wp_header'); ?>
			</td>
          </tr>
          <tr>
            <td align="left" valign="top">
			<!-- Main menu -->
			<?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
			 $this->load->view('common/artifact_tabs', $details); ?>
			<!-- Main menu -->	
			</td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="76%" height="8" align="left" valign="top"></td>
                  <td width="24%" align="left" valign="top"></td>
                </tr>
                <tr>
                  <td align="left" valign="top">
					<!-- Main Body -->
					<script>function showFocus()
	{
		//parent.frames[0].gk.EditingArea.focus();
	}</script>
	 



<script type="text/javascript">
function compareDates (dat1, dat2) {
   var date1, date2;
   var month1, month2;
   var year1, year2;
	 value1 = dat1.substring (0, dat1.indexOf (" "));
	  value2 = dat2.substring (0, dat2.indexOf (" "));
	  time1= dat1.substring (1, dat1.indexOf (" "));
	  time2= dat2.substring (1, dat2.indexOf (" "));
	  
	  hours1= time1.substring (0, time1.indexOf (":"));
	  minites1= time1.substring (1, time1.indexOf (":"));
	  
	  hours2= time2.substring (0, time2.indexOf (":"));
	  minites2= time2.substring (1, time2.indexOf (":"));
	  
   year1 = value1.substring (0, value1.indexOf ("-"));
   month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
   date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);
//alert(date1);
   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);
//alert(date2);
   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
   else return 0;
} 



var request_refresh_point=1;
var nodeId='';
function validate_dis(){
	var error=''
	
	if(document.getElementById('replyDiscussion').value==''){
	 	error+=' ';
	}
	var thisdate = new Date();

	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
// alert(curr_datetouse + document.getElementById('endtime').value);
if(compareDates(curr_datetouse,'<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>') == 1){
	error+='<?php echo $this->lang->line('chat_expire'); ?>';
}
 
	if(error==''){
		request_refresh_point=0;
		request_send();
	}else{
		jAlert(error);
	}
	
}
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
var http1 = getHTTPObjectm();
var replay_target=0;
var start_chat_val=1;
 function handleHttpResponsem1() 
{    
	if(http1.readyState == 4) { 
		if(http1.status==200) { 
			var results=http1.responseText; 
		 	document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;
			document.getElementById('replyDiscussion').value='';
			request_refresh_point=1;
		}
	}
}
function request_send(){
	urlm='<?php echo base_url();?>personal_chat/reply_Chat/<?php echo $treeId;?>';
	 
 		data='reply=1&vks=1&editorname1=replyDiscussion&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+document.getElementById('replyDiscussion').value+'&replay_target='+replay_target;
	 
 	http1.open("POST", urlm, true); 
	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.onreadystatechange = handleHttpResponsem1;     
	http1.send(data);
}
var http2 = getHTTPObjectm();
function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText; 
			document.getElementById('chat_msg').innerHTML=results;
			//document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;
			document.getElementById('meFocus').focus();
		}
	}
}
function request_refresh(){
	if(request_refresh_point){
		url='<?php echo base_url();?>personal_chat/Chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
	//	alert(url);
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}
</script><!--webbot bot="HTMLMarkup" endspan i-checksum="29191" -->
     <div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

			<tr>
			  <td width="231" colspan="2" align="left" valign="top" class="tdSpace">			  </td>
			  <td width="234" align="left" valign="middle"><span class="style2"><?php echo $this->lang->line('txt_Date');?></span>: <?php echo $this->time_manager->getUserTimeFromGMTTime($DiscussionCreatedDate, 'm-d-Y h:i A');?></td>
		  </tr>
		</table>
		<span id="chat_msg">&nbsp;</span>
		</div>
	<?php	if($access){?>
	<!--span id="title_chat"></span--> 
	  	<form name="form1" method="post" action="<?php echo base_url();?>personal_chat/reply_Chat/<?php echo $pnodeId;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="chat_title"> 

			<input name="title" type="hidden" value=" "> <br>
			 <input name="starttime" type="hidden" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>">
			  <input name="endtime" type="hidden" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d H:i');?>">
</td>
  </tr>
  <tr>
    <td valign="top"><br>
<?php echo $this->lang->line('txt_Content');?>: 
 &nbsp; <textarea name="replyDiscussion" id="replyDiscussion" rows="3" cols="35"></textarea><input type="button" name="Replybutton"  onClick="validate_dis();" value="Send"><span id="vk12345"></span></td>
  </tr>
  <tr>
    <td>
		        <input name="reply" type="hidden" id="reply" value="1">
		        <input name="editorname1" type="hidden"  value="replyDiscussion">
				 <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				</td>
  </tr>
</table>

	
                
		</form>
<script>
request_refresh();
 setInterval("request_refresh()", 10000);
</script>
<?php }else{
	echo 'Invalid Access';
}?>
				<!-- Main Body -->
					</td>
                  <td align="left" valign="top">
				<!-- Right Part-->			
				<?php $rightArray=array();
				$rightArray['pageName']=$this->uri->segment(1);
				$rightArray['artifactType'] = 1;		
				$rightArray['artifactTreeId'] = 0;
				$this->load->view('common/right',$rightArray);	
								
				?>				
				<!-- end Right Part -->
				</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copy">
			<!-- Footer -->	
				<?php $this->load->view('common/footer');?>
			<!-- Footer -->
			</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>
