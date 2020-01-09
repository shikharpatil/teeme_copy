<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
$tagTypes		= $this->tag_db_manager->getTagTypes();	
if($this->uri->segment(1) == 'Notes')
{	
	$artifactType = 6;
}
elseif($this->uri->segment(1) == 'view_Activity')
{	
	$artifactType = 4;
}
?>	

<table width="100%" border="0" cellspacing="0" cellpadding="0">              
	<tr>
		<td>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" class="blue-border">
                    <tr>
                      <td height="19" class="bg-light-blue"><strong> </strong></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top"><table width="95%" border="0" cellspacing="2" cellpadding="2">
	<!--
                          <tr>
                            <td align="left" class="bottom-border-blue">
							<strong>
								<?php 
								if($this->uri->segment(1) == 'calendar')
								{	
								?>	
									<a href="<?php echo base_url();?><?php printf($artifactFormat, $artifactTreeId);?>" class="black-link"><?php echo $this->lang->line('txt_Normal_View');?></a>
								<?php
								}
								else
								{
								?>
									<a href="<?php echo base_url().'calendar/index/0/0/0/0/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactType.'/'.$artifactTreeId;?>" class="black-link"><?php echo $this->lang->line('txt_Calendar_View');?></a>
								<?php
								}
								?>						
							</strong>
							</td>
                          </tr>-->
                          <tr>
                            <td align="left" class="bottom-border-blue"><strong>
              
              <a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="black-link">External Files</a>
             
            </strong></td>
                          </tr>
                        
							
                          
                      </table></td>
                    </tr>
          </table>


</td>
	</tr>
	 
</table>
  <table><tr><td>&nbsp;</td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="blue-border">
                    <tr>
                      <td class="bg-light-blue"><img src="<?php echo base_url();?>images/tag-icon.jpg" width="20" height="19" align="absmiddle" /><strong> My Tags</strong></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top"><table width="95%" border="0" cellspacing="2" cellpadding="2">
	
                          <tr>
                            <td align="left" class="bottom-border-blue"><a href="javascript:void(0)" onClick="viewTag('today','tagSpan')" class="black-link">Today</a></td>
                          </tr>
                          <tr>
                            <td align="left" class="bottom-border-blue"><a href="javascript:void(0)" onClick="viewTag('tomorrow','tagSpan')" class="black-link">Tommorrow</a></td>
                          </tr>
                          <tr>
                            <td align="left" class="bottom-border-blue"><a href="javascript:void(0)" onClick="viewTag('this_week','tagSpan')" class="black-link">This week </a></td>
                          </tr>
                          <tr>
                            <td align="left" class="bottom-border-blue"><a href="javascript:void(0)" onClick="viewTag('this_month','tagSpan')" class="black-link">This Month</a></td>
                          </tr>
							<?php													
							foreach($tagTypes as $tagData)
							{
							?>									
							  <tr>
								<td align="left" class="bottom-border-blue"><a href="javascript:void(0)" onClick="viewTag('<?php echo $tagData['tagTypeId'];?>','tagSpan',<?php echo $tagData['categoryId'];?>)" class="black-link"><?php echo $tagData['tagType'];?></a></td>
							  </tr>
                        	<?php
							}
							?>         
                          
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
             
</table>