<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$arrTagDetails	= array();
$sequenceTags 	= array();
$sequenceOrder 	= 0;	
$styleDisplay 	= '';
$sequence 		= 0;
if($sequenceTagId > 0)
{
	$styleDisplay 	= '';
	$sequence 		= 1;
	$sequenceTags 	= $this->tag_db_manager->getSequenceTagsBySequenceId($sequenceTagId);	
}
$arrTagDetails['sequenceTags']	= $sequenceTags;
$arrTagDetails['sequenceOrder']	= $sequenceOrder;
$arrTagDetails['sequence']		= $sequence;
$option = $this->uri->segment(6);		
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td align="left" valign="top"><table width="30%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 2) { ?>bg-left.gif<?php }else{?>bg-left-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
				<td width="100%" align="center" valign="top" style="background-image:url(<?php echo base_url();?>images/<?php if($tagOption == 2) { ?>bg-bg.gif<?php }else{?>bg-bg-dn.gif<?php }?>); background-repeat:repeat-x"><h1 ><a href="<?php echo base_url()?>tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/2" <?php if($tagOption == 2) { ?>class="up" <?php } ?>><?php echo $this->lang->line('txt_Simple');?></a></h1></td>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 2) { ?>bg-rgt.gif<?php }else{?>bg-rgt-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
			  </tr>
		  </table></td>
		  <td align="left" valign="top">&nbsp;</td>
		  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 3) { ?>bg-left.gif<?php }else{?>bg-left-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
				<td width="100%" align="center" valign="top" style="background-image:url(<?php echo base_url();?>images/<?php if($tagOption == 3) { ?>bg-bg.gif<?php }else{?>bg-bg-dn.gif<?php }?>); background-repeat:repeat-x"><h1><a href="<?php echo base_url()?>tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/3" <?php if($tagOption == 3) { ?>class="up" <?php } ?>><?php echo $this->lang->line('txt_Response');?></a></h1></td>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 3) { ?>bg-rgt.gif<?php }else{?>bg-rgt-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
			  </tr>
		  </table></td>
		  <td align="left" valign="top">&nbsp;</td>
		  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 5) { ?>bg-left.gif<?php }else{?>bg-left-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
				<td width="100%" align="center" valign="top" style="background-image:url(<?php echo base_url();?>images/<?php if($tagOption == 5) { ?>bg-bg.gif<?php }else{?>bg-bg-dn.gif<?php }?>); background-repeat:repeat-x"><h1><a href="<?php echo base_url()?>tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/5" <?php if($tagOption == 5) { ?>class="up" <?php } ?>><?php echo $this->lang->line('txt_Contact');?></a></h1></td>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 5) { ?>bg-rgt.gif<?php }else{?>bg-rgt-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
			  </tr>
		  </table></td>
		  <td align="left" valign="top">&nbsp;</td>
		  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 6) { ?>bg-left.gif<?php }else{?>bg-left-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
				<td width="100%" align="center" valign="top" style="background-image:url(<?php echo base_url();?>images/<?php if($tagOption == 6) { ?>bg-bg.gif<?php }else{?>bg-bg-dn.gif<?php }?>); background-repeat:repeat-x"><h1><a href="<?php echo base_url()?>tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/6" <?php if($tagOption == 6) { ?>class="up" <?php } ?>><?php echo $this->lang->line('txt_User');?></a></h1></td>
				<td width="0%" align="left" valign="top"><img src="<?php echo base_url();?>images/<?php if($tagOption == 6) { ?>bg-rgt.gif<?php }else{?>bg-rgt-dn.gif<?php }?>" alt="bg" width="5" height="23" /></td>
			  </tr>
		  </table></td>
		</tr>
	</table></td>
  </tr>
<?php
if(trim($_SESSION['errorMsg']) != '')
{		
?>
  <tr>
	<td align="left">
	<?php echo $_SESSION['errorMsg'];
	$_SESSION['errorMsg'] = '';
	?></td>                  
  </tr>
<?php
}
?>	
 
  <tr>
	<td align="left" valign="top" class="grbg " ><table width="100%" border="0" cellspacing="1" cellpadding="2">
		<tr>
		  <td bgcolor="#FFFFFF" class="selectbg">
			<?php					
			switch($tagOption)
			{				
				case 2:					
				
					if($addNewOption == 1)
					{	
						$this->load->view('common/tags/view_tag1', $arrTagDetails); 
					}	
					else
					{	
						$this->load->view('common/tags/add_view_tag1', $arrTagDetails); 
					}				
					break;					
				case 3:							
					$tags = $this->tag_db_manager->getTagsByUserId(3, $_SESSION['userId']);
					$arrTagDetails['tags'] = $tags;
					if($addNewOption == 1)
					{	
						$this->load->view('common/tags/act_tag1', $arrTagDetails);  
					}	
					else if($addNewOption == 3)
					{	
						$arrTagDetails['tagId'] = $this->uri->segment(10);	
						$this->load->view('common/tags/act_response1', $arrTagDetails); 
					}			
					else
					{	
						$this->load->view('common/tags/add_act_tag1', $arrTagDetails); 
					}																
					break;	
				case 4:		
					
					$tags = $this->tag_db_manager->getTagsByUserId(4, $_SESSION['userId']);
					$arrTagDetails['tags'] = $tags;
					if($addNewOption == 1)
					{	
						$this->load->view('common/tags/view_create_tag1', $arrTagDetails);  
					}	
					else
					{	
						$this->load->view('common/tags/add_create_tag1', $arrTagDetails); 
					}															
					break;	 								
					
				case 5:		
					$tags = $this->tag_db_manager->getTagsByUserId(5, $_SESSION['userId']);
					$arrTagDetails['tags'] = $tags;							
					$this->load->view('common/tags/contact_tag1', $arrTagDetails); 													
					break;	
				case 6:		
					$tags = $this->tag_db_manager->getTagsByUserId(6, $_SESSION['userId']);
					$arrTagDetails['tags'] = $tags;							
					$this->load->view('common/tags/user_tag1', $arrTagDetails);														
					break;
				default:	
					$this->load->view('common/tags/act_tag', $arrTagDetails); 								
					break;	
			}			
				?>
			</td>
		</tr>
		
	</table></td>
  </tr>
</table>