<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><span id="tagSpan"><table width="100%" border="0" cellspacing="1" cellpadding="0">
						  		
				<?php
				if(count($tags) > 0)
				{
					
					foreach($tags as $tagData)
					{	
						$ownerDetails	= $this->identity_db_manager->getUserDetailsByUserId( $tagData['ownerId'] );
						$tagLink		= $this->tag_db_manager->getLinkByTagId( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
						if(count($tagLink) > 0)
						{	
						?>	
						<tr>
							<td valign="top" class="bg-light-grey">		
						  <a href="<?php echo base_url().$tagLink[0];?>" class="blue-link-underline"> <?php echo $tagLink[1];?></a>
							</td>
			  			</tr>           
						<?php
						}
					}
				}
				?>
						</table>
					</span>