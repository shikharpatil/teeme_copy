<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
	<script language="javascript"  language="javascript" src="<?php echo base_url();?>js/identity.js"></script> 
	<script language="javascript"  language="javascript" src="<?php echo base_url();?>js/ajax.js"></script> 
	<script language="javascript"  language="javascript" src="<?php echo base_url();?>js/tag.js"></script> 
	<script language="JavaScript"  language="javascript" src="<?php echo base_url();?>js/pop_menu.js"></script> 
	<script language="JavaScript"  language="javascript" src="<?php echo base_url();?>js/mm_menu.js"></script> 
	<script type="text/javascript" language="javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery-ui-1.8.10.custom.min.js"></script>
	 <!--/*Changed By surbhi IV*/-->
    <!--<script type="text/javascript" language="javascript" src="js/modal-window.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
    <!--/*End of Changed By surbhi IV*/-->
	<script language="JavaScript1.2">mmLoadMenus();</script>
</head>
<body>

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
                  <td colspan="2" align="left" valign="top">
					<!-- Main Body -->
					
	<?php
	//print_r ($NotesList);
	if(count($NotesList) > 0)
	{	
		$count = 0 ;
		foreach($NotesList as $keyVal=>$arrVal)
		{
			$userDetails = $this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			if ($arrVal['isShared']==1)
			{
				$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($arrVal['id']);	

			}
			if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
			{
				$count++;
			}
		}
		
		if ($count!=0)
		{
	?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="rowHeading header">
        <td width="1%" align="left" valign="top">
    		<img src="<?php echo base_url();?>images/tab_left.png" alt="tab_left" width="9" height="24" />
    	</td>
		<td width="45%"><span><a href="<?php echo base_url();?>notes/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Notes');?></a></span></td>
        <td width="30%"><span><a href="<?php echo base_url();?>notes/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><?php echo $this->lang->line('txt_Created_By');?></a></span></td>
        <td width="23%"><span><a href="<?php echo base_url();?>notes/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><?php echo $this->lang->line('txt_Modified_Date');?></a></span></td>
        <td width="1%" align="right" valign="top">
    		<img src="<?php echo base_url();?>images/tab_right.png" alt="tab_left" width="8" height="24" />
    	</td>
      </tr>
       
	<?php
/*	$this->load->helper('form'); 
	$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post');	
	echo form_open('', $attributes);*/
	
	$rowColor1='rowColor1';
	$rowColor2='rowColor2';	
	$i = 1;	
						 
		foreach($NotesList as $keyVal=>$arrVal)
		{
			$userDetails = $this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			//echo "userId= " .$arrVal['userId'];
			if ($arrVal['isShared']==1)
			{
				$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($arrVal['id']);	
				//echo "shared= "; print_r ($sharedMembers);
			}
			if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
			{
				
				$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	
		?>			
	  <tr class="<?php echo $rowColor;?>">
        <td align="left" colspan="2">
            <?php
            if ($arrVal['isShared']==1)
			{
			?>
            	<img src="<?php echo base_url();?>images/share.gif" alt="Shared" border="0"/>
            <?php
			}
			?>
            
        	<!--<a class="blue-link-underline" href="<?php echo base_url();?>notes/Details/<?php echo $arrVal['id'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags(stripslashes($arrVal['name']));?> </a> -->
			asdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdf asdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdfasdfa sdfasdfja dfasdfkja sdfasd fkajsdf asdf
        </td>
        <td align="left"><?php echo $userDetails['userTagName'];?></td>
        <td align="left" colspan="2"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></td>
      </tr>
		<?php
			}
			$i++;
		}
		//echo form_close();
	?>
    </table>
    <?php
		}
		else
		{
	?>	
      		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  		<tr>
				<td align="left" valign="top" bgcolor="#FFFFFF" colspan="5"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></td>       
	  		</tr>
      		</table>
	<?php
		}	
	}
	else
	{
	?>	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left" valign="top" bgcolor="#FFFFFF" colspan="5"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></td>       
	  </tr>
      </table>
	<?php
	}	
	?>


				<!-- Main Body -->
				<!-- Right Part-->			
				<!-- end Right Part -->
				</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copy">
			<!-- Footer -->	
				
			<!-- Footer -->
			</td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php $this->load->view('common/footer');?>
</body>
</html>
