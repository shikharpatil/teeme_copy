<?php
		if(count($docArtifactLinks2) > 0)
		{
			foreach($docArtifactLinks2 as $key=>$value)
			{
				$docSectionLinkIds[] = $key;
			}
		}
		if(count($docArtifactNotLinks2) > 0)
		{
			foreach($docArtifactNotLinks2 as $key=>$value)
			{
				$docSectionLinkIds[] = $key;
			}
		}
		
		
		if(count($disArtifactLinks2) > 0)
		{
			foreach($disArtifactLinks2 as $key=>$value)
			{
				$disSectionLinkIds[] = $key;
			}
		}
		if(count($disArtifactNotLinks2) > 0)
		{
			foreach($disArtifactNotLinks2 as $key=>$value)
			{
				$disSectionLinkIds[] = $key;
			}
		}
		if(count($chatArtifactLinks2) > 0)
		{
			foreach($chatArtifactLinks2 as $key=>$value)
			{
				$chatSectionLinkIds[] = $key;
			}
		}
		if(count($chatArtifactNotLinks2) > 0)
		{
			foreach($chatArtifactNotLinks2 as $key=>$value)
			{
				$chatSectionLinkIds[] = $key;
			}
		}

		if(count($activityArtifactLinks2) > 0)
		{
			foreach($activityArtifactLinks2 as $key=>$value)
			{
				$activitySectionLinkIds[] = $key;
			}
		}
		if(count($activityArtifactNotLinks2) > 0)
		{
			foreach($activityArtifactNotLinks2 as $key=>$value)
			{
				$activitySectionLinkIds[] = $key;
			}
		}
		
		
		
		if(count($notesArtifactLinks2) > 0)
		{
			foreach($notesArtifactLinks2 as $key=>$value)
			{
				$notesSectionLinkIds[] = $key;
			}
		}
		if(count($notesArtifactNotLinks2) > 0)
		{
			foreach($notesArtifactNotLinks2 as $key=>$value)
			{
				$notesSectionLinkIds[] = $key;
			}
		}
		
		
		if(count($contactArtifactLinks2) > 0)
		{
			foreach($contactArtifactLinks2 as $key=>$value)
			{
				$contactSectionLinkIds[] = $key;
			}
		}
		if(count($contactArtifactNotLinks2) > 0)
		{
			foreach($contactArtifactNotLinks2 as $key=>$value)
			{
				$contactSectionLinkIds[] = $key;
			}
		}

		if(count($importArtifactLinks2) > 0)
		{
			foreach($importArtifactLinks2 as $key=>$value)
			{
				$importSectionLinkIds[] = $key;
				$sectionChecked[] = $key;
			}
		}
		if(count($importArtifactNotLinks2) > 0)
		{
			foreach($importArtifactNotLinks2 as $key=>$value)
			{
				$importSectionLinkIds[] = $key;
			}
		}
		?>	
 
    
<style type="text/css">

body {
	background-color: #FFFFFF;
}

</style>


<div class="boxtext">

				<div class="menu_new h2_class">
			
			
			<ul class="tab_tag_link">
			<li  id="tabLinksList" <?php if($this->uri->segment(10)!='set'){ echo  'class="tabs_tags_select"'; }else{ echo 'class="tabs_tags"'; } ?> >
			
			<a href="javaScript:void(0)" onclick="showHideLinksView('')" ><?php echo $this->lang->line('txt_Links');?></a>
			</li>
			<?php 
			if($latestVersion==1)
			     {
				 	$_SESSION['set_doc_latest_version']=0;
			?>	 
              			<li id="tabLinksSet" <?php if($this->uri->segment(10)=='set'){ echo  'class="tabs_tags_select"'; }else{ echo 'class="tabs_tags"'; } ?> >
			<a href="javaScript:void(0)" onclick="showHideLinksView('add')" ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="add new tag" border="0" ></a>  </li>
			 <?php 
			      }
			?>	  
			
			</ul>
			
			</div>
			<div class="clr"></div>
			</div>


<div style="margin-left:10px;" id="divAppliedLinks" <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; } ?> >	

  

	 <?php
			if($leafClearStatus == 1 && $leafClearStatus != '' && $latestVersion==1 && $artifactType==2)
			{
				?>
				<div class="clearMsgLinkPadding"><?php echo $this->lang->line('txt_clear_prev_link_obj_msg'); ?></div>
			<?php
			}	
	
	if((count($docArtifactLinks)+count($disArtifactLinks)+count($chatArtifactLinks)+count($activityArtifactLinks)+count($notesArtifactLinks)+count($contactArtifactLinks)+count($importArtifactLinks)+count($importedUrls))>0)
	{
	
		if($leafClearStatus == 0 && $leafClearStatus != '' && $latestVersion==1 && $leafOwnerData['userId']==$_SESSION['userId'])
		{
		?>
		<div style="margin-top:1%;">
			<input type="button" name="clear" value="<?php echo $this->lang->line('txt_clear_prev_link_obj'); ?>" onclick="clearLinks('<?php echo $nodeId ?>');" /> 
		</div>
		
		<div class="clearLoader" id="clearLoader"></div>
		
		<?php
		}
			
	if(count($docArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Document').': '.implode(', ', $docArtifactLinks);?> </div>
	
	<?php
	}
			
	if(count($disArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Discussions').': '.implode(', ', $disArtifactLinks);?> </div>
	
	<?php
	}
				
	if(count($chatArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Chat').': '.implode(', ', $chatArtifactLinks);?> </div>
	<?php
	}	
			
	if(count($activityArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Task').': '.implode(', ', $activityArtifactLinks);?> </div>
	
	<?php
	}
	if(count($notesArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Notes').': '.implode(', ', $notesArtifactLinks);?> </div>
	
	<?php
	}
	if(count($contactArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Contacts').': '.implode(', ', $contactArtifactLinks);?> </div>
	
	<?php
	}
	if(count($importArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Imported_Files').': '.implode(', ', $importArtifactLinks);?> </div>
	
	<?php
	}
	
	if(count($importedUrls) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Imported_URL').': '.implode(', ', $importedUrls);?> </div>
	
	<?php
	}
	
	}
	else
	{
	      echo $this->lang->line('txt_None');
	}
	?>
</div>	
<div id="linksContainer"   <?php if($this->uri->segment(10)=='set'){ echo  'class="disblock"'; } else{ echo  'class="disnone"';}  ?>>
	<table width="97%" border="0" style="margin:0px 10px  0px 10px " >
	<?php
	if(count($importArtifactLinks) == 0 && count($contactArtifactLinks)==0 && count($notesArtifactLinks)==0 
	&& count($activityArtifactLinks)==0 && count($chatArtifactLinks)==0 && count($disArtifactLinks)==0 
	&& count($docArtifactLinks)==0)	
	{	
	?>
	<tr align="right">
		<td align="left" valign="top">
			<?php			
				//echo $this->lang->line('txt_Links_Applied');?>  <?php // echo $this->lang->line('msg_tags_not_available');
				//echo $this->lang->line('txt_Notes') .':<br><br>'; 			
			?>
		</td>
	</tr>

	<?php
	}
	?>


	<tr align="right">
	
		<td align="left" valign="top">
		</td>
	</tr>
	<tr>
		<td >
		<span id="linkNew<?php echo $linkSpanOrder;?>"  > 
        
			<table width="100%" cellpadding="0" cellspacing="1">
				<tr>
					
					<td valign="top" width="85%">
					<form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<select name="tree" onchange="selectLinks(this,<?php echo $linkSpanOrder;?>)">
                        	<option value="1"><?php echo $this->lang->line('txt_Document');?></option>
                            <option value="3"><?php echo $this->lang->line('txt_Chat');?></option>
                            <option value="4"><?php echo $this->lang->line('txt_Task');?></option>
                            <option value="5"><?php echo $this->lang->line('txt_Notes');?></option>
                            <option value="6"><?php echo $this->lang->line('txt_Contacts');?></option>
                            <option value="9"><?php echo $this->lang->line('txt_Import_URL');?></option>
                        </select>
                        
                        
                        
                        
                        
					
                    </td>
                    </tr>
                    <tr>
                    
					<td valign="top">
                    	
						<input type="hidden" id="documentType" name="documentType" value="docs"  />

						<span id="docList<?php echo $linkSpanOrder;?>"  <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; }   ?> >

                        <br />
                        
                        <input type="text" id="searchLinksDoc" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'docs')" size="25"/>
                        <div id="showLinksDoc" class="clsAllLinks" style="height:150px;display:block;overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									//for($i=0;$i<count($docArtifactLinks2);$i++)
									foreach ($docArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
							  
									//for($i=0;$i<count($docArtifactNotLinks2);$i++)
									foreach ($docArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />



						</span>
						<span id="disList<?php echo $linkSpanOrder;?>" style="display:none;">
                       <br />
                        
                       
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="disc"  />
						
						<input type="text" id="searchLinksDis" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'disc')" size="25"/>
						
                        <div id="showLinksDis" class="clsAllLinks" style="display:block; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($disArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($disArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						<span id="chatList<?php echo $linkSpanOrder;?>" style="display:none;"><br />
                        
                       
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="chat"  />
						
						<input type="text" id="searchLinksChat" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'chat')" size="25"/>
						
                        <div id="showLinksChat" class="clsAllLinks" style="display:block; height:150px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($chatArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($chatArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						<span id="activityList<?php echo $linkSpanOrder;?>" style="display:none;">
                        <br />
                     
                      
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="activity"  />
						  <input type="text" id="searchLinksActivity" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'activity')" size="25"/>
						
                        <div id="showLinksActivity" class="clsAllLinks" style="display:block; height:150px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0;max-width:165px; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($activityArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($activityArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						<span id="notesList<?php echo $linkSpanOrder;?>" style="display:none;">
                       <br />
                        
                        
                        <input type="text" id="searchLinksNotes" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'notes')" size="25"/>
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
                        <div id="showLinksNotes"  class="clsAllLinks" style="display:block; height:150px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
						<input type="hidden" id="documentType" name="documentType" value="notes"  />	
							<?php 
									foreach ($notesArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($notesArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
                        <span id="contactList<?php echo $linkSpanOrder;?>" style="display:none;">
                       <br />
                        
                     
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="contact"  />	
						<input type="text" id="searchLinksContact" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'contact')" size="25"/>
                        <div id="showLinksContact" class="clsAllLinks" style="display:block; height:150px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($contactArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($contactArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						
                        <span id="importList<?php echo $linkSpanOrder;?>" style="display:none;">
                       <br />
                        
                       
                       
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="import"  />	
						 <input type="text" id="searchLinksImport" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'import')" size="25"/>
                        <div id="showLinksImport" class="clsAllLinks" style="display:block; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($importArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="importlinks" id="importlinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									/*Added by Surbhi IV for sorting*/
									$importArtifactNotLinks2_lowercase = array_map('strtolower', $importArtifactNotLinks2);
									$importArtifactNotLinks2_lowercase1 = array_map('strtolower', $importArtifactNotLinks2);
									array_multisort($importArtifactNotLinks2_lowercase, SORT_ASC, SORT_STRING, $importArtifactNotLinks2);
									/*End of Added by Surbhi IV for sorting*/
                                    foreach ($importArtifactNotLinks2 as $key=>$value)
									{
									    /*Added by Surbhi IV for sorting*/
										$array_search=array_search(strtolower($value),$importArtifactNotLinks2_lowercase1);
										/*End of Added by Surbhi IV for sorting*/
							?>
									    <input type="checkbox" name="importlinks" id="importlinks" value="<?php echo $array_search;?>"/><?php echo $value;?><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						
						
                        
						
						
						
                        <?php 
						
						$sectionChecked = implode (',',$sectionChecked);
						$count2 = implode (',',$importSectionLinkIds);
						
						$docSectionLinkIds = implode (',',$docSectionLinkIds);
						$disSectionLinkIds = implode (',',$disSectionLinkIds);
						$notesSectionLinkIds = implode (',',$notesSectionLinkIds);
						$chatSectionLinkIds = implode (',',$chatSectionLinkIds);
						$activitySectionLinkIds = implode (',',$activitySectionLinkIds);
						$contactSectionLinkIds = implode (',',$contactSectionLinkIds);
						$newNodeId=0;
						if($artifactType==2)
						$newNodeId=$nodeId;
						
						
						
						?>
                        
						</ul>
                        <div id="actionButtons" <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; }   ?> >
               	   
					    <input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Apply');?>" class="button01"  onClick="apply_link(<?php echo $newNodeId; ?>,<?php echo $artifactType; ?>)" />
						
						<input id="cancel" name="cancel" type="reset" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01"/>
						</div>
						
						<div class="linkApplyLoader_doc" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_dis" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_chat" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_activity" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_notes" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_contact" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_import" id="linkApplyLoader"></div>
						
						
                        <input type="hidden" name="nodeId" id="nodeId" value="<?php echo $nodeId;?>">
            			<input type="hidden" name="linkType" id="linkType" value="<?php echo $artifactType;?>">
						<input type="hidden" name="linkSpanOrder" id="linkSpanOrder" value="<?php echo $linkSpanOrder;?>">
						<input type="hidden" name="mainTreeId" id="mainTreeId" value="<?php echo $mainTreeId;?>">   
						
                        <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workspaceId;?>">
                        <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workspaceType;?>">
                        <input type="hidden" name="latestVersion" id="latestVersion" value="<?php echo $latestVersion;?>">
                        <input type="hidden" id="sectionType" name="sectionType" value="doc">
                        <input type="hidden" id="sectionLinkIds" name="sectionLinkIds" value="<?php echo $count;?>">
                        <input type="hidden" id="docSectionLinkIds" name="docSectionLinkIds" value="<?php echo $docSectionLinkIds;?>">
                        <input type="hidden" id="disSectionLinkIds" name="disSectionLinkIds" value="<?php echo $disSectionLinkIds;?>">
                        <input type="hidden" id="chatSectionLinkIds" name="chatSectionLinkIds" value="<?php echo $chatSectionLinkIds;?>">
                        <input type="hidden" id="notesSectionLinkIds" name="notesSectionLinkIds" value="<?php echo $notesSectionLinkIds;?>">
                        <input type="hidden" id="activitySectionLinkIds" name="activitySectionLinkIds" value="<?php echo $activitySectionLinkIds;?>">
                        <input type="hidden" id="contactSectionLinkIds" name="contactSectionLinkIds" value="<?php echo $contactSectionLinkIds;?>">
                        <input type="hidden" id="importSectionLinkIds" name="importSectionLinkIds" value="<?php echo $count2;?>">
                        <input type="hidden" id="sectionChecked" name="sectionChecked" value="<?php echo $sectionChecked;?>"> 
                        <input type="hidden" id="appliedDocLinkIds" name="appliedDocLinkIds" value="<?php echo $appliedDocLinkIds;?>"> 
                        
                        
             <!-- Previous Links -->           
                        
            <input type="hidden" name="treeLinks<?php echo $linkSpanOrder;?>" id="treeLinks<?php echo $linkSpanOrder;?>" value="0">
            <input type="hidden" name="treeLinks2<?php echo $linkSpanOrder;?>" id="treeLinks2<?php echo $linkSpanOrder;?>" value="0">
			<input type="hidden" name="docTreeIds<?php echo $linkSpanOrder;?>" id="docTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrDocTreeIds);?>">
			<input type="hidden" name="disTreeIds<?php echo $linkSpanOrder;?>" id="disTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrDisTreeIds);?>">
			<input type="hidden" name="chatTreeIds<?php echo $linkSpanOrder;?>" id="chatTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrChatTreeIds);?>">
			<input type="hidden" name="activityTreeIds<?php echo $linkSpanOrder;?>" id="activityTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrActivityTreeIds);?>">
			<input type="hidden" name="notesTreeIds<?php echo $linkSpanOrder;?>" id="notesTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrNotesTreeIds);?>">
            <input type="hidden" name="contactTreeIds<?php echo $linkSpanOrder;?>" id="contactTreeIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrContactTreeIds);?>">				
			<input type="hidden" name="importFileIds<?php echo $linkSpanOrder;?>" id="importFileIds<?php echo $linkSpanOrder;?>" value="<?php echo implode(',',$arrImportFileIds);?>">	                
                        
                        </form>
						
						<div id="newImportFile<?php echo $linkSpanOrder;?>" <?php if($this->uri->segment(10)=='set'){ echo  'class="disblock"'; } else{ echo  'class="disnone"';}  ?> >
                 
                       
						 <?php  $data['appliedCheckBox']=true; 
						         $data['workSpaceId']=$workspaceId;
								 $data['workSpaceType']=$workspaceType; 
								 //tree id or node id
								 $data['nodeId']=$nodeId;
								 
								 $data['artifactType']=$artifactType;
								 $data['linkType']=$linkType;
								 $data['nodeOrder']=$nodeOrder;
								 $data['latestVersion']=$latestVersion;
								 
                        $this->load->view('common/links/add_external_docs',$data); ?> 	
                        <br /><br />


						</div>
						<br />
						 <div id="urlList<?php echo $linkSpanOrder;?>" style="display:none; margin-bottom:20px; min-width:250px; width:100%;">
						
						<?php 
						
						$allImportUrls = $this->identity_db_manager->getAllImportUrls();
					
						$appliedUrls=$this->identity_db_manager->getAppliedUrl($nodeId,$artifactType);
						$appliedUrlsIds=array();
						
						 $i=0;
						foreach($appliedUrls as $key)
						{
						 
						 	$appliedUrlsIds[]= $key['urlId'];
						}
						
						
						
						?>
							    <div style="float:left; padding-right:5px; <?php /*border-right:1px solid #999999;*/ ?> width:88%; " > 
								<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center" >
									<tr>
										<td colspan="2">
											<form name="frmTag0" id="frmTag0" method="post" >
									
									<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
									<tr>
										<td width="30%">
											Search URL : 
										</td>
                                     </tr>
                                     <tr>
										<td> 
										<input type="text" id="searchUrls" name="searchUrls" onkeyup="showUrlsAjax(<?php echo $nodeId ; ?>,<?php echo $artifactType; ?>)" size="25"/>
									   
										</td>
									</tr>
									<?php /*?><tr>
										<td valign="top" width="20%">&nbsp;
											
										</td>
                                    </tr><?php */?>
                                    <tr>
										<td>
											<div id="divShowUrls" style="display:block; height:80px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
												<?php
												$count = '';
												$sectionChecked = '';
												foreach($allImportUrls as $indivisualUrl)	
		{
												
			if (in_array($indivisualUrl['id'],$appliedUrlsIds))
			{
			?>
			<input type="checkbox" name="chkImportUrls" value="<?php echo $indivisualUrl['id']; ?>" checked="checked"  ><span class="clsCheckedTags"><?php echo $indivisualUrl['title']; ?></span><br />
			<?php
			}
			

		}
		foreach($allImportUrls as $indivisualUrl)	
		{
												
			if (!(in_array($indivisualUrl['id'],$appliedUrlsIds)))
			{
			?>
			
			<input type="checkbox" name="chkImportUrls" value="<?php echo $indivisualUrl['id']; ?>"   ><?php echo $indivisualUrl['title']; ?><br />
			<?php
			}	

		}
		?>
											</div>
												<br />
												
								<input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workspaceId;?>">
                        <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workspaceType;?>">
                        <input type="hidden" name="latestVersion" id="latestVersion" value="<?php echo $latestVersion;?>">
						<input type="hidden" name="linkSpanOrder" id="linkSpanOrder" value="<?php echo $linkSpanOrder;?>">				
												
												<input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Apply');?>" onclick="applyImportedUrls(<?php echo $nodeId ?>,<?php echo $artifactType; ?>)" class="button01"/>
												
												
									
										</td>
									</tr>
									</table>
									</form>
										</td>
									</tr>
									
                </table>
                </div>
                <div style="float:left;width:250px;">
				   <form name="frmTag2" method="post" action="<?php echo base_url();?>create_tag1" >
 	               <table width="100%" cellpadding="5">		
 	                   <tr>
						<td width="30%">
						<?php echo $this->lang->line('txt_New_URL');?>  :
						</td>
                        </tr>
                        <tr>
						<td>	
                            <input name="txtUrl" type="text" size="24" id="txtUrl" maxlength="500">
						</td>
						</tr>
					<tr>
					 <td><?php echo $this->lang->line('txt_URL_Title');?>:</td>
                     </tr>
                     <tr>
					 <td><input name="title" type="text" id="title" size="24" maxlength="255"></td>
					</tr>
					<tr>
					 <td><input name="confirm" type="button"  onclick="createImportUrl(<?php echo $nodeId; ?>,<?php  echo  $artifactType ?>,<?php echo $linkSpanOrder;?>,<?php echo $latestVersion;?>)" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"/>
						<input type="button" id="cancelTagButton" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="document.getElementById('title').value='';document.getElementById('txtUrl').value='';" />
			
			
						<input type="hidden" id="ownerId" name="ownerId" value="<?php echo $_SESSION['userId']; ?>" />
						<input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workspaceId;?>">
                        <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workspaceType;?>">
                    </td>
			</tr>
						</table>
						</form>
								</div>
								<div class="clr"></div>

						
                        </div>
                      


						</div>
						
					</td>
				</tr>
			</table>

        </span>
		</td>
	</tr>	

</table>