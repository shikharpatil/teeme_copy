<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Teeme</title>
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
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
	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	
</head>

<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
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
<script>
function reply(id)
{
	divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
	//parent.frames[id].gk.EditingArea.focus();
	rameid=id;	
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}</script>
</body>
</html>
