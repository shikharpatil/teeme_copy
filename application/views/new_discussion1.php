<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme Documents</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>
<script language="javascript">
var baseUrl 		= '<?php echo base_url();?>';	
var workSpaceId		= '<?php echo $workSpaceId;?>';
var workSpaceType	= '<?php echo $workSpaceType;?>';
</script>
<script language="JavaScript" src="<?php echo base_url();?>js/ajax.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/identity.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/tag.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/document.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
<body onLoad="showFocus()">
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
    <td align="left"><?php $this->load->view('common/header');?></td>
  </tr>
  <tr>
    <td height="30" align="right">&nbsp;</td>
  </tr>
  
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><?php 
		$details['workSpaces']		= $workSpaces;
		$details['workSpaceId'] 	= $this->uri->segment(3);
		if($this->uri->segment(3) > 0)
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
        <td height="18" bgcolor="#FFFFFF"><table width="98%"><tr>
			  <td width="30%" align="left" valign="top" class="tdSpace"><span class="style2">Document</span>: <a href="#" class="blueText" onClick="window.open('<?php echo base_url();?>'+'get_document_title','','width=450,height=120,toolbar=no,scrollbars=yes,resizable=no,top=170,left=200')">
				  <span id="docTitle">
				<?php				
				if(isset($_SESSION['documentTitle']) && $_SESSION['documentTitle'] !=	"")
				{
					echo $_SESSION['documentTitle'];	
				}
				else
				{
					echo 'Untitled';
				}
				?>	
					
				  </span></a></td>
			  <td width="15%" align="left" valign="top"><span class="style2">Version</span>: 1 </td>
			  <td width="25%" align="left" valign="middle"><span class="style2">Originator</span>: <?php echo $_SESSION['userName'];//echo $_SESSION['userFirstName'].' '.$_SESSION['userLastName'];?> </td>
		  <td width="30%" align="right" valign="middle"><span class="style2">Date</span>: <?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(),'m-d-Y H:i A');?></td>
		  </tr>
		</table></td>
      </tr>
		 <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?> 
		<td height="18"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
		
	<?php
	}
	?>
      <tr>
        <td height="250" valign="top" bgcolor="#FFFFFF"><form name="form1" method="post" action="<?php echo base_url();?>new_discussion/start_Discussion/<?php echo $pnodeId;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
<?php if(isset($title)){?>
			  Discussion Title:<input name="title" type="text" size="50" maxlength="255"> <?php  }?></td>
  </tr>
  <tr>
    <td>Content:<br>
 &nbsp; <script> editorTeeme('replyDiscussion', '90%', '90%', 0, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); </script></td>
  </tr>
  <tr>
    <td><input type="button" name="Replybutton" value="Start Discussion" onClick="validate_dis();">
		        <input name="reply" type="hidden" id="reply" value="1">
		        <input name="editorname1" type="hidden"  value="replyDiscussion">
				 <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
				<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
				<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
				</td>
  </tr>
</table>

	
                
		</form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="txtwhite">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="txtwhite"><?php $this->load->view('common/footer');?></td>
  </tr>
</table>  

<script>
parent.document.getElementById('Boldcmd').src='<?php echo base_url();?>images/bold.jpg';
parent.document.getElementById('Italiccmd').src='<?php echo base_url();?>images/italic.jpg';
parent.document.getElementById('Underlinecmd').src='<?php echo base_url();?>images/underline.jpg';
</script>
</body>
</html>
