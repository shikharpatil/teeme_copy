<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Teeme</title>
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jcalendar/calendar.css?random=20051112" media="screen"></link>
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
	<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>
	<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
    </style>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
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
<?php $this->load->view('common/float_menu');?>
<!-- Float Menu Bar -->                                      
</p>
</layer>

<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>
<table width="825" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><!--header part--><?php $this->load->view('common/header');?><!--header part--></td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
  </tr>
  
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><?php 
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
		$this->load->view('common/artifact_tabs',$details);?></td>
      </tr>
      <tr>
        <td height="18" bgcolor="#96C2EC">&nbsp;</td>
      </tr>
      <tr>
        <td height="250" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="8">
          <tr>
            <td valign="top">
			<!-- body-->
			<span id="tagSpan"></span>
	<script>function showFocus()
	{
		//parent.frames[0].gk.EditingArea.focus();
	}</script>




<script type="text/javascript">



var request_refresh_point=1;
var nodeId='';
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

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

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

function validate_dis(){
	var error=''
	if(!document.form1.title.value){
		
	  	error+='<?php echo $this->lang->line('enter_title_for_chat'); ?>\n';
		
	}
	 
	//alert(compareDates(document.getElementById('starttime').value,document.getElementById('endtime').value));
	if(compareDates(document.getElementById('starttime').value,document.getElementById('endtime').value) == 1){
	 	error+='<?php echo $this->lang->line('check_start_time_end_time'); ?>';
	}
	if(error==''){
		request_refresh_point=0;
		document.form1.submit();
		//request_send();
	}else{
		jAlert(error);
	}
	
}
 


</script><!--webbot bot="HTMLMarkup" endspan i-checksum="29191" -->
     
<table width="88%" border="1" align="center" cellpadding="0" cellspacing="0">
 
	  <tr>
		<td colspan="2" valign="top">
		  <form name="form1" method="post" action="<?php echo base_url();?>personal_chat/start_Chat/<?php echo $chat_member;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="chat_title"> 
 
			<?php echo $this->lang->line('txt_Chat_Title');?>:<input name="title" type="text" size="40" maxlength="255"><br>
			<?php echo $this->lang->line('txt_Start_Time');?>: <input name="starttime" type="text" id="starttime"  value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(),'Y-m-d H:i');?>" readonly><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.starttime,'yyyy-mm-dd hh:ii',this,true)" />
			<?php echo $this->lang->line('txt_End_Time');?>: <input name="endtime" type="text" id="endtime" value="<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(),'Y-m-d H:i');?>" readonly><img src="<?php echo base_url();?>images/cal.gif"  onclick="displayCalendar(document.form1.endtime,'yyyy-mm-dd hh:ii',this,true)" />
</td>
  </tr>
  <tr>
    <td valign="top"><?php echo $this->lang->line('txt_With');?> : <?php //print_r($chat_member_info);
	echo $chat_member_info['firstName'].' '.$chat_member_info['lastName'].'( '.$chat_member_info['userName'].' )';	?></td>
  </tr>
  <tr>
    <td>
		        <input name="reply" type="hidden" id="reply" value="1">
		        <input type="button" name="Replybutton" value="Send" onClick="validate_dis();">
				 
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				</td>
  </tr>
</table>

	
                
		</form>
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

  <!-- body--></td>
            <td width="24%" align="left" valign="top">
			
			<!-- Right Part-->
			
			<?php $rightArray=array();
			$rightArray['pagename']=$this->uri->segment(1);
			$this->load->view('common/right',$rightArray);?>
			
			<!-- Right Part --></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="txtwhite">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="txtwhite"><!-- Footer part --><?php
		 $this->load->view('common/footer');?><!-- Footer part --></td>
  </tr>
</table>
</body>
</html>
