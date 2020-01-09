<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$arrTagDetails	= array();
$sequenceTags = array();
$sequenceOrder = 0;	
$styleDisplay = '';
$sequence = 0;
if($sequenceTagId > 0)
{
	$styleDisplay = '';
	$sequence = 1;
	$sequenceTags = $this->tag_db_manager->getSequenceTagsBySequenceId($sequenceTagId);

}
$arrTagDetails['sequenceTags']	= $sequenceTags;
$arrTagDetails['sequenceOrder']	= $sequenceOrder;
$arrTagDetails['sequence']	= $sequence;	
?>
	<?php $this->load->view('common/view_head.php');?>
    <link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
    <script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
		


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="250" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			<!-- body-->
			<?php 
			$option = $this->uri->segment(6);		
			?>
			<table width="100%" border="0" cellspacing="3" cellpadding="3">
                  <tr>
             
                    <td align="right">&nbsp;</td>
                  </tr>
				<?php
				if(trim($_SESSION['errorMsg']) != '')
				{		
				?>
                  <tr>
                    <td align="left" colspan="2">
					<span class="errorMsg">
					<?php echo $_SESSION['errorMsg'];
					$_SESSION['errorMsg'] = '';
					?></span></td>                  
                  </tr>
				<?php
				}
				?>
				
				<?php
				if(trim($_SESSION['successMsg']) != '')
				{		
				?>
                  <tr>
                    <td align="left" colspan="2">
					<span class="successMsg">
					<?php echo $_SESSION['successMsg'];
					$_SESSION['successMsg'] = '';
					?>
					</span>
					</td>                  
                  </tr>
				<?php
				}
				?>
                  <tr>
                <td align="left">
				<div id="actionTagResponse">
				<?php 	
				//echo "addNewOption= " .$addNewOption; exit;
					switch($tagOption)
					{							
						case 3:
							$tagId = $this->uri->segment(10);	
																
							$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);
							$arrTagDetails['tags'] = $tags;
						
							if($addNewOption == 1)
							{	 
								$arrTagDetails['tagId'] = $tagId;	
								$this->load->view('common/tags/act_tag_view_response', $arrTagDetails); 
							}	
							else if($addNewOption == 3)
							{	
								$arrTagDetails['tagId'] = $this->uri->segment(10);	
								$this->load->view('common/tags/act_response', $arrTagDetails); 
							}			
							else
							{	
								$this->load->view('common/tags/add_act_tag', $arrTagDetails); 
							}																
							break;						
						default:	
							$this->load->view('common/tags/act_tag', $arrTagDetails); 								
							break;	
					}			
				?>
				</div>
				</td>
				<td valign="top">
			
            	</td>
              </tr>				
            </table>			
			<!-- body-->			
			<!-- Right Part-->			
			<!-- Right Part --></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="txtwhite">&nbsp;</td>
  </tr>
</table>
