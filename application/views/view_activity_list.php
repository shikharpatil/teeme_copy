<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
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
                  <td width="78%" height="8" align="left" valign="top"></td>
                  <td width="22%" align="left" valign="top"></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">
					<!-- Main Body -->
					<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#D0D0D7">
      <tr>
        <td colspan="3"  align="left" bgcolor="#FFFFFF"><ul class="rtabs">
          <li><a href="<?php echo base_url()?>view_activity/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" <?php if($option == 1) { ?>class="current" <?php } ?>><span><?php echo $this->lang->line('txt_Activities');?></span></a></li>
          <li><a href="<?php echo base_url()?>view_activity/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" <?php if($option == 2) { ?>class="current" <?php } ?>><span><?php echo $this->lang->line('txt_Activity_Lists');?></span></a></li>
          </ul></td>
        </tr>
	<?php
	if(count($arrDiscussions) > 0)
	{			
	?>
	 <tr>
        <td colspan="3"  align="left"  class="bg-grey-img"></td>
        </tr>
      <tr>
      <td  align="left"  class="bg-grey-img"><span class="heading-grey"><a href="<?php echo base_url();?>view_activity/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $option;?>/1"><?php echo $this->lang->line('txt_Activity_Lists');?></a> </span></td>
        <td  class="bg-grey-img"><span class="heading-grey"><a href="<?php echo base_url();?>view_activity/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $option;?>/2"><?php echo $this->lang->line('txt_Originator');?></a></span></td>

        <td class="bg-grey-img"><span class="heading-grey"><a href="<?php echo base_url();?>view_activity/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $option;?>/3"><?php echo $this->lang->line('txt_Modified_Date');?></a></span></td>
      </tr>     
	<?php
	$this->load->helper('form'); 
	$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post');	
	echo form_open('', $attributes);
	//print_r($arrDiscussions);
				 
	foreach($arrDiscussions as $keyVal=>$arrVal)
	{
		$userDetails	= $this->activity_db_manager->getUserDetailsByUserId($arrVal['userId']);			
	?>			
      <tr>
  
        <td align="left" valign="top"  class="bg-white"><a href="<?php echo base_url();?>view_activity/node/<?php echo $keyVal;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="blue-link-underline"><?php echo $arrVal['name'];?> </a></td>
        <td align="left" valign="top" class="bg-white"><?php echo $userDetails['userTagName'];?></td>
       <td align="left" valign="top" class="bg-white"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></td>
      </tr>
		<?php
		echo form_close();	
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
	
?>
 
    </table>
				<!-- Main Body -->
				<!-- Right Part-->			
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
