<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Discuss > New</title>
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head.php');?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';
</script>
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
	var error='';

	//var getvalue	= getvaluefromEditor('title');
	var getvalue = document.getElementById('title').value;
	
	/*if(getvalue.indexOf("<img")!=-1)
	{
		error+="<?php //echo $this->lang->line('not_use_image_in_title'); ?>";
	}
	else if($("<p>"+getvalue+"</p>").text().trim()=='')
	{
		error+="<?php //echo $this->lang->line('enter_title'); ?>";
	}*/
	if(getvalue == '')
	{
		error+="<?php echo $this->lang->line('not_use_image_in_title'); ?>";
	}

	if(error==''){
		request_refresh_point=0;
		document.form1.submit();
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
var replay_target=1;
var start_chat_val=1;
 function handleHttpResponsem1() 
{    
	if(http1.readyState == 4) { 
		if(http1.status==200) { 
			var results=http1.responseText; 
			document.getElementById('chat_msg').innerHTML=results;
			document.getElementById("chat_msg").scrollTop =document.getElementById("chat_msg").scrollHeight;
			document.getElementById('replyDiscussion').value='';
			if(start_chat_val){
				document.getElementById('chat_title').innerHTML='<input name="title" type="hidden" value=" "><input name="starttime" type="hidden" id="starttime"  value=" "><input name="endtime" type="hidden" id="endtime" value=" ">';
				start_chat_val=0;
			}
			request_refresh_point=1;
		}
	}
}
function request_send(){
	if(replay_target){
		urlm='<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>';
		data='reply=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&title='+document.getElementById('title').value+'&replyDiscussion='+document.getElementById('replyDiscussion').value+'&starttime='+document.getElementById('starttime').value+'&endtime='+document.getElementById('endtime').value;
	}else{
		urlm='<?php echo base_url();?>new_chat/index/<?php echo $treeId;?>';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+document.getElementById('replyDiscussion').value;
	}
	
		
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
			 document.getElementById("meFocus").scrollTop =document.getElementById("meFocus").scrollHeight;
		}
	}
}
function request_refresh(){
	if(request_refresh_point){
		url='<?php echo base_url();?>view_chat/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null); 
	}
}
</script>
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content"> 
    
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
			
			?>
    <!-- Main menu -->
    <form name="form1" method="post" action="<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>/0/<?php echo $workSpaceType;?>/type/<?php echo $workSpaceId;?>/<?php echo $linkType;?>">
	      <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>
      <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>
      <?php
	}
	?>
      <span class="docLabel"><?php echo $this->lang->line('txt_Chat_Title');?>&nbsp;&nbsp;: </span>
      <div class="docTextDiv">
        <textarea name="title" id="title"></textarea>
      </div>
      <br>
      <br>
      <div class="docTextDiv">
        <input type="button" value="<?php echo $this->lang->line('txt_Done');?>" onClick="return validate_dis();" class="button01"/>
        <input type="button" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="document.location='<?php echo base_url();?>chat/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';" class="button01"/>
      </div>
      <input name="reply" type="hidden" id="reply" value="1">
      <input name="editorname1" type="hidden"  value="replyDiscussion">
      <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
      <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
      <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
      <input type="hidden" name="linkType_vk" value="<?php echo $linkType_vk;?>" id="linkType_vk">
    </form>
    
    <!-- Main Body -->
    
    <?php   
		$rightArray=array();
		$rightArray['pageName']=$this->uri->segment(1);
		$rightArray['artifactType'] = 1;		
		$rightArray['artifactTreeId'] = 0;
		$this->load->view('common/right',$rightArray);	
	?>
  </div>
</div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
<script>
 //chnage_textarea_to_editor('title','simple');
</script>