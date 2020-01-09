<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"> </script>
<?php $this->load->view('editor/editor_js.php');?>
	<script>
		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
		var workSpace_name='<?php echo $workSpaceId;?>';
		var workSpace_user='<?php echo $_SESSION['userId'];?>';
		var node_lock=0;

		var rootFolderName='<?php echo $rootFolderName;?>';
		var rootFolderId='<?php echo $rootFolderId;?>';
	</script>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
		var urlParent = (window.location != window.parent.location) ? document.referrer: document.location;
		urlParent = urlParent.split('/');
		var len = urlParent.length;
		if(urlParent[len-5]=="Details"){
			var treeId = urlParent[len-4];
		}
		else{
			var treeId = urlParent[len-3];
		}//alert("#doclinks"+treeId);
		//$("#doclinks"+treeId).next(".hideThis").hide();
		document.getElementById("doclinks"+treeId).style.display="none";
	</script>
    
    <?php 	if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)
		{
	?>
		<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>
	<?php
		}         
	?>
    
    <script language="JavaScript" src="<?php echo base_url();?>js/document.js"></script>
    <script language="JavaScript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/validation.js"></script>
    <script type="text/javascript" language="JavaScript1.2">mmLoadMenus();</script>
    
    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>
	
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 
	
    <!--Added by Dashrath- Add showFiles function-->
    <script type="text/javascript">
    $( document ).ready(function() {
    	// document.getElementById("folderId_0").style.backgroundColor = "#345191";
    	// document.getElementById("folderId_0").style.color = "#ffffff";
    	// $('.folId0').css('display','inline');
    	document.getElementById("folderId_"+rootFolderId).style.backgroundColor = "#345191";
    	document.getElementById("folderId_"+rootFolderId).style.color = "#ffffff";
    	$('.folId'+rootFolderId).css('display','inline');
	});

	function showFiles(currentFolderId)
	{
		var oldFolderId = document.getElementById("oldFolderId").value;

		if(oldFolderId!=currentFolderId)
		{
			document.getElementById("folderId_"+oldFolderId).style.backgroundColor = "";
			document.getElementById("folderId_"+oldFolderId).style.color = "";
			document.getElementById("folderId_"+currentFolderId).style.backgroundColor = "#345191";
			document.getElementById("folderId_"+currentFolderId).style.color = "#ffffff";
	
			$('.folId'+oldFolderId).css('display','none');
			$('.folId'+currentFolderId).css('display','inline'); 

			document.getElementById("oldFolderId").value = currentFolderId;
		} 
	}
    </script>
    <!--Dashrath- code end-->   
		
	</head>
	<body>
	<div id="clearLinkUpdateBox">		
<?php
	
		$treeSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workspaceId);	
		if($workspaceId!=0 && $treeSpaceDetails['workSpaceName']!='Try Teeme') {
			$treeTypeEnabled = 1;	
		}
		
		$docTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workspaceId);
		$chatTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workspaceId);
		$taskTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workspaceId);
		$notesTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workspaceId);
		$conTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workspaceId);
		
		if($this->uri->segment(10)!='set')
		{
			if($docTreeTypeStatus!=1 || $workspaceId==0 || $treeSpaceDetails['workSpaceName']=='Try Teeme')
			{
				$docShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus!=1)
			{
				$chatShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus!=1)
			{
				$taskShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus!=1)
			{
				$notesShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus==1 && $conTreeTypeStatus!=1)
			{
				$conShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus==1 && $conTreeTypeStatus==1)
			{
				$impShow = 1;
			}
			else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus==1 && $conTreeTypeStatus==1)
			{
				$folShow = 1;
			}
		}
		
		
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

		/*Added by Dashrath- used for link folder*/
		if(count($importArtifactLinksFolder2) > 0)
		{
			foreach($importArtifactLinksFolder2 as $key=>$value)
			{
				$importSectionLinkFolderIds[] = $key;
				$sectionCheckedFolder[] = $key;
			}
		}
		if(count($importArtifactNotLinksFolder2) > 0)
		{
			foreach($importArtifactNotLinksFolder2 as $key=>$value)
			{
				$importSectionLinkFolderIds[] = $key;
			}
		}
		/*Dashrath- code end*/
		?>	
 
    
<style type="text/css">

body {
	/*background-color: #FFFFFF;*/
	background-color: #E9EBEE;
}

</style>


<div class="boxtext">

				<div class="menu_new h2_class">
			
			
			<ul class="tab_tag_link">
			<li  id="tabLinksList" <?php if($this->uri->segment(10)!='set'){ echo  'class="tabs_tags_select"'; }else{ echo 'class="tabs_tags"'; } ?> >
			
			<a href="javaScript:void(0)" onclick="showHideLinksView('')" ><?php echo $this->lang->line('txt_Links');?></a>
			</li>
			<?php 
			//echo $nodeSuccessor.'=='.$successorLeafStatus.'=='.$currentLeafStatus;
			if(($latestVersion==1 && ($latestTreeVersion==1 || $artifactType==1) && ($nodeSuccessor === 0 || $successorLeafStatus == 'draft' || $treeType!=1 || $artifactType==1) && ($currentLeafStatus!='discarded' || $artifactType==1) && $leafDraftReserveStatus!=1 && $spaceMoved!=1) || ($latestVersion==1 && $currentTreeId==0))
			     {
				 	$_SESSION['set_doc_latest_version']=0;
			?>	 
              			<li id="tabLinksSet" <?php if($this->uri->segment(10)=='set'){ echo  'class="tabs_tags_select"'; }else{ echo 'class="tabs_tags"'; } ?> >
			<a href="javaScript:void(0)" onclick="showHideLinksView('add')" ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="add new tag" border="0" ></a>  </li>
			 <?php 
			      }
			?>	  
			
			</ul>
			
			<div style="float:right">
				<div class="closeLoader"></div>
			</div>
			
			</div>
			<div class="clr"></div>
			</div>


<div style="margin-left:10px;" id="divAppliedLinks" <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; } ?> >	

  	 <!--Leaf status message-->
		  <?php if($leafAlertMsg!=''){ ?>
		  	<?php /*?><div style="color:red;" class="clearMsgLinkPadding"><?php echo $leafAlertMsg; ?></div><?php */?>
		  <?php } ?>	
	 <!--Leaf status message-->

	 <?php
			if($leafClearStatus == 1 && $leafClearStatus != '' && $latestVersion==1 && $artifactType==2)
			{
				?>
				<div class="clearMsgLinkPadding"><?php echo $this->lang->line('txt_clear_prev_link_obj_msg'); ?></div>
			<?php
			}		
	
	/*Changed by Dashrath- Add $importArtifactLinksFolder in if condition for check count*/
	if((count($docArtifactLinks)+count($disArtifactLinks)+count($chatArtifactLinks)+count($activityArtifactLinks)+count($notesArtifactLinks)+count($contactArtifactLinks)+count($importArtifactLinks)+count($importedUrls)+count($importArtifactLinksFolder))>0)
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
	<div style="margin-top:10px; <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Document').': '.implode(',', $docArtifactLinks);?> </div>
	

	<?php
	}
			
	if(count($disArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px; <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Discussions').': '.implode(',', $disArtifactLinks);?> </div>
	<?php
	}
				
	if(count($chatArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px; <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Chat').': '.implode(',', $chatArtifactLinks);?> </div>
	
	<?php
	}	
			
	if(count($activityArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px; <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Task').': '.implode(',', $activityArtifactLinks);?> </div>
	
	<?php
	}
	if(count($notesArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px; <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Notes').': '.implode(',', $notesArtifactLinks);?> </div>
	
	<?php
	}
	if(count($contactArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px; <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> display:none; <?php } ?>" ><?php echo $this->lang->line('txt_Contacts').': '.implode(',', $contactArtifactLinks);?> </div>
	
	<?php
	}
	if(count($importArtifactLinks) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Files').': '.implode(',', $importArtifactLinks);?> </div>
	
	<?php
	}
	/*Added by Dashrath- used for display linked folder name*/
	if(count($importArtifactLinksFolder) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Folders').': '.implode(',', $importArtifactLinksFolder);?> </div>
	
	<?php
	}
	/*Dashrath- code end*/
	
	if(count($importedUrls) > 0)	
	{	
	?>
	<div style="margin-top:10px;"><?php echo $this->lang->line('txt_Imported_URL').': '.implode(',', $importedUrls);?> </div>
	
	<?php
	}
	
	}
	else
	{
	      echo $this->lang->line('txt_None');
	}
	?>
</div>	
<div id="linksContainer"   <?php if($this->uri->segment(10)=='set'){ echo  'class="disblock"'; } else{ echo  'class="disnone"';}  ?> >
	<table width="97%" border="0" style="margin:0px 10px  0px 10px " >
	<?php
	if(count($importArtifactLinks) == 0 && count($contactArtifactLinks)==0 && count($notesArtifactLinks)==0 
	&& count($activityArtifactLinks)==0 && count($chatArtifactLinks)==0 && count($disArtifactLinks)==0 
	&& count($docArtifactLinks)==0)	
	{	
	?>
	<tr align="right">
		<td align="left" valign="top">
	
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
				<tr  >
					
					<td valign="top" width="85%">
					<form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<span <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block; float:left;" <?php  } ?>><input type="radio" id="artTreeId" name="tree" value="1"  onClick="selectLinks(this,<?php echo $linkSpanOrder;?>);" <?php if($docShow==1){ ?> checked="checked" <?php } ?> ><?php echo $this->lang->line('txt_Document');?></span>

						<span <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block; float:left;" <?php  } ?>><input type="radio" name="tree" value="3" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($chatShow==1){ ?> checked="checked" <?php } ?> ><?php echo $this->lang->line('txt_Chat');?></span>

						<span <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block; float:left;" <?php  } ?>><input type="radio" name="tree" value="4" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($taskShow==1){ ?> checked="checked" <?php } ?>><?php echo $this->lang->line('txt_Task');?></span>
                        
						<!-- <span <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block; float:left;" <?php  } ?>><input type="radio" name="tree" value="5" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($notesShow==1){ ?> checked="checked" <?php } ?>><?php echo $this->lang->line('txt_Notes');?></span> -->
					
                    	<span <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block; float:left;" <?php  } ?>><input type="radio" name="tree" value="6" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($conShow==1){ ?> checked="checked" <?php } ?>><?php echo $this->lang->line('txt_Contacts');?></span>

                    	<input type="radio" name="tree" value="7" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($impShow==1){ ?> checked="checked" <?php } ?> ><?php echo $this->lang->line('txt_Files');?>

                    	<!--Added by Dashrath- used for folder link-->
                    	<input type="radio" name="tree" value="10" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)" <?php if($folShow==1){ ?> checked="checked" <?php } ?> ><?php echo $this->lang->line('txt_Folders');?>
                    	<!--Dashrath- code end-->
						
						<!-- <input type="radio" <?php if($this->uri->segment(10)=='set'){ echo  'checked="checked"'; }  ?> name="tree" value="8" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)"><?php echo $this->lang->line('txt_Import_New_Files');?> -->
						
						<input type="radio" name="tree" value="9" onClick="selectLinks(this,<?php echo $linkSpanOrder;?>)"><?php echo $this->lang->line('txt_Import_URL');?>
						
					
                    </td>
				</tr>
				<tr>
					<td valign="top">
                    	<div <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php  } ?> >
						<input type="hidden" id="documentType" name="documentType" value="docs"  />

						<span id="docList<?php echo $linkSpanOrder;?>"  <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; }   ?> >

                   <br />      
                        <input type="text" id="searchLinksDoc" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'docs')" size="40"/>
                        <div id="showLinksDoc" class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($docArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
							  
									foreach ($docArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />



						</span>
						</div>
						
						<div>
						<span id="disList<?php echo $linkSpanOrder;?>" style="display:none;">
                       <br />
                        
                       
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="disc"  />
						
						<input type="text" id="searchLinksDis" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'disc')" size="40"/>
						
                        <div id="showLinksDis" class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($disArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($disArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						</div>
						
						
						<div>
						<span id="chatList<?php echo $linkSpanOrder;?>" style=" <?php if($chatShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?> " ><br />
                        
                       
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="chat"  />
						
						<input type="text" id="searchLinksChat" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'chat')" size="40"/>
						
                        <div id="showLinksChat" class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($chatArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($chatArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						</div>
						
						<div>
						<span id="activityList<?php echo $linkSpanOrder;?>" style=" <?php if($taskShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?>">
                        <br />
                     
                      
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="activity"  />
						  <input type="text" id="searchLinksActivity" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'activity')" size="40"/>
						
                        <div id="showLinksActivity" class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($activityArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($activityArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						</div>
						
						<div>
						<span id="notesList<?php echo $linkSpanOrder;?>" style=" <?php if($notesShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?> "><br />
                        
                        
                        <input type="text" id="searchLinksNotes" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'notes')" size="40"/>
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
                        <div id="showLinksNotes"  class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
						<input type="hidden" id="documentType" name="documentType" value="notes"  />	
							<?php 
									foreach ($notesArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($notesArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						</div>
						
						<div>
                        <span id="contactList<?php echo $linkSpanOrder;?>" style=" <?php if($conShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?> "><br />
                        
                     
                        
                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
						<input type="hidden" id="documentType" name="documentType" value="contact"  />	
						<input type="text" id="searchLinksContact" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'contact')" size="40"/>
                        <div id="showLinksContact" class="clsAllLinks" style="display:block;width: 400px; height: 180px; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
							
							<?php 
									foreach ($contactArtifactLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
							<?php
									}
							 ?>			
							
							<?php 
									foreach ($contactArtifactNotLinks2 as $key=>$value)
									{
							?>
									<input type="checkbox" name="doclinks" id="doclinks<?php echo $key;?>" value="<?php echo $key;?>"/><span class="hideThis" ><?php echo $value;?></span><br />
							<?php
									}
							 ?>
                            
                        </div>
                        
                        <br /><br />


						</span>
						</div>
						
						
                        <span id="importList<?php echo $linkSpanOrder;?>" style=" <?php if($impShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?> " >
                      <br />
                        
                        <!--Changed by Dashrath- files show according selected folder-->
                        <div style="display: flex;">
                        	<!--used for hold old folder id-->
                        	<input type="hidden" name="oldFolderId" id="oldFolderId" value="<?php echo $rootFolderId; ?>" />

	                       	<div>
								<span class="fileFolderLabel"><?php echo $this->lang->line('txt_folders');?></span><br/>
								<span class="folderListImportFiles">
									<?php
										if($workspaceId > 0)
										{				
											$workSpaceName1 = $treeSpaceDetails['workSpaceName'];
										}
										else
										{
											$workSpaceName1 	= $this->lang->line('txt_Me');
										} 
									?>
									<span id="folderId_<?php echo $rootFolderId;?>" onclick="showFiles('<?php echo $rootFolderId;?>')"><?php echo $rootFolderName; ?></span><br/>

									<?php
		                       		foreach($foldersDetailDocs as $docData)
									{
									?>	
										<?php if($docData['folderId'] != $rootFolderId)
										{
										?>
		                       			<span id="folderId_<?php echo $docData['folderId'];?>" onclick="showFiles('<?php echo $docData['folderId'];?>')"><?php echo $docData['name']; ?></span><br/>
		                       			<?php
		                       			}
		                       			?>
		                       		<?php
		                       		}
		                       		?>
		                       	</span>
	                       	</div>
	                       	<div>
                       		
		                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
								<input type="hidden" id="documentType" name="documentType" value="import"  />	
								<span class="fileFolderLabel"><?php echo $this->lang->line('txt_files');?></span>
								 <input type="text" id="searchLinksImport" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'import')" size="40" class="importFileSearchField" placeholder="Search files"/>
		                        <div id="showLinksImport" class="clsAllLinks importFilesLinkList" style="display:block; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888; border: solid 1px gray; margin-top: 5px;">
									
									<?php 
											foreach ($importArtifactLinks2 as $key=>$value)
											{
												/*Added by Dashrath- get folder id by docId*/
												$folderId	= $this->identity_db_manager->getFolderIdByDocId($key);
									?>	
										<!--Added by Dashrath- add span tag for hide show according selected folder-->
										<span class="folId<?php echo $folderId;?>" style="display: none;">
											<input type="checkbox" name="importlinks" id="importlinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
										</span>
									<?php
											}
									 ?>			
									
									<?php 
											/*Added by Surbhi IV for sorting*/
											/*Commeted by Dashrath- file repeted by same name*/
											// $importArtifactNotLinks2_lowercase = array_map('strtolower', $importArtifactNotLinks2);
											// $importArtifactNotLinks2_lowercase1 = array_map('strtolower', $importArtifactNotLinks2);
											// array_multisort($importArtifactNotLinks2_lowercase, SORT_ASC, SORT_STRING, $importArtifactNotLinks2);
											/*End of Added by Surbhi IV for sorting*/
		                                    foreach ($importArtifactNotLinks2 as $key=>$value)
											{
											    /*Added by Surbhi IV for sorting*/
											    /*Commeted by Dashrath- file repeted by same name*/
												// $array_search=array_search(strtolower($value),$importArtifactNotLinks2_lowercase1);
												/*End of Added by Surbhi IV for sorting*/

												/*Added by Dashrath- get folder id by docId*/
												$folderId	= $this->identity_db_manager->getFolderIdByDocId($key);
									?>		<!--Added by Dashrath- add span tag for hide show according selected folder-->
											<span class="folId<?php echo $folderId;?>" style="display: none;">
											    <input type="checkbox" name="importlinks" id="importlinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
											</span>
									<?php
											}
									 ?>
								</div>
                        	</div>
                    	</div>
                        
                        <br /><br />


						</span>
						
						
						<!--Added by Dashrath- used for link folder-->
						<div id="importFolderList<?php echo $linkSpanOrder;?>" style=" <?php if($folShow==1){ ?> display:block; <?php } else { ?> display:none; <?php } ?> " >
	                       	<div>
		                        <form name="frmTag0" method="post" action="<?php echo base_url();?>show_artifact_links/apply">
									<input type="hidden" id="documentType" name="documentType" value="importFolder"  />	
									<br/>
									
									<!-- <span class="fileFolderLabel">
										<?php echo $this->lang->line('txt_folders');?>	
									</span> -->
									<span>
										<input type="text" id="importFolderSearchField" name="searchLinks" onKeyUp="getSearchedLinksByKeywords(<?php echo $nodeOrder; ?>,<?php echo $nodeId ; ?>,<?php echo $artifactType ;  ?>,<?php echo $workspaceId ; ?>,<?php echo $workspaceType ; ?>,<?php echo $linkType ; ?>,<?php echo $latestVersion ; ?>,0,'importFolder')" size="40" class="importFolderSearchField" placeholder="Search folders"/>
									</span>
									

		                        	<div id="showLinksImportFolder" class="clsAllLinks importFilesLinkList" style="display:block; overflow: auto; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888; border: solid 1px gray; margin-top: 5px;">
									
										<?php 
										foreach ($importArtifactLinksFolder2 as $key=>$value)
										{												
										?>	
											<input type="checkbox" name="importFolderlinks" id="importFolderlinks" value="<?php echo $key;?>" checked="checked"/><span class="clsCheckedTags"><?php echo $value;?></span><br />
										
										<?php
										}
									 	?>			
									
										<?php 											
		                                foreach ($importArtifactNotLinksFolder2 as $key=>$value)
										{
										?>		
											<input type="checkbox" name="importFolderlinks" id="importFolderlinks" value="<?php echo $key;?>"/><?php echo $value;?><br />
											
										<?php
										}
									 	?>
									</div>
                        	</div>
                    	</div>
                        <br/><br/>
						<!--Dashrath- code end-->
                        
						
						
						
                        <?php 
						
						$sectionChecked = implode (',',$sectionChecked);
						$count2 = implode (',',$importSectionLinkIds);

						/*Added by Dashrath- used in folder link*/
						$count3 = implode (',',$importSectionLinkFolderIds);
						/*Dashrath- code end*/

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
                        <div id="actionButtons" <?php if($this->uri->segment(10)=='set'){ echo  'class="disnone"'; }   ?> style="margin-top: -25px;">
                       
					    <input id="confirm" name="confirm" type="button" value="<?php echo $this->lang->line('txt_Apply');?>" class="button01"  onClick="apply_link(<?php echo $newNodeId; ?>,<?php echo $artifactType; ?>)" />
						
						<input id="cancel" type="button" name="cancel" onclick="$('input[name=\'tree\'][value=1]').click()" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01"/>
						
                        
                        
                        
                        </div>
						
						<div class="linkApplyLoader_doc" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_dis" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_chat" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_activity" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_notes" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_contact" id="linkApplyLoader"></div>
						<div class="linkApplyLoader_import" id="linkApplyLoader"></div>
						<!--Added by Dashrath- Add import folder loader-->
						<div class="linkApplyLoader_import_folder" id="linkApplyLoader"></div>
						<!--Dashrath- code end-->
						
                        <input type="hidden" name="nodeId" id="nodeId" value="<?php echo $nodeId;?>">
            			<input type="hidden" name="linkType" id="linkType" value="<?php echo $artifactType;?>">
						<input type="hidden" name="linkSpanOrder" id="linkSpanOrder" value="<?php echo $linkSpanOrder;?>">
						<input type="hidden" name="mainTreeId" id="mainTreeId" value="<?php echo $mainTreeId;?>">   
						
                        <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workspaceId;?>">
                        <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workspaceType;?>">
                        <input type="hidden" name="latestVersion" id="latestVersion" value="<?php echo $latestVersion;?>">
                        <input type="hidden" id="sectionType" name="sectionType" value="<?php if($docShow==1){ echo 'doc';} else if($chatShow==1) { echo 'chat'; } else if($taskShow==1) { echo 'activity'; } else if($notesShow==1) { echo 'notes'; } else if($conShow==1) { echo 'contact'; }?>">
                        <input type="hidden" id="sectionLinkIds" name="sectionLinkIds" value="<?php echo $count;?>">
                        <input type="hidden" id="docSectionLinkIds" name="docSectionLinkIds" value="<?php echo $docSectionLinkIds;?>">
                        <input type="hidden" id="disSectionLinkIds" name="disSectionLinkIds" value="<?php echo $disSectionLinkIds;?>">
                        <input type="hidden" id="chatSectionLinkIds" name="chatSectionLinkIds" value="<?php echo $chatSectionLinkIds;?>">
                        <input type="hidden" id="notesSectionLinkIds" name="notesSectionLinkIds" value="<?php echo $notesSectionLinkIds;?>">
                        <input type="hidden" id="activitySectionLinkIds" name="activitySectionLinkIds" value="<?php echo $activitySectionLinkIds;?>">
                        <input type="hidden" id="contactSectionLinkIds" name="contactSectionLinkIds" value="<?php echo $contactSectionLinkIds;?>">
                        <input type="hidden" id="importSectionLinkIds" name="importSectionLinkIds" value="<?php echo $count2;?>">

                        <!--Added by Dashrath- used for folder link-->
                        <input type="hidden" id="importSectionLinkFolderIds" name="importSectionLinkFolderIds" value="<?php echo $count3;?>">
                        <!--Dashrath- code end-->

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
						 <div id="urlList<?php echo $linkSpanOrder;?>" style="display:none; margin-bottom:20px;">
						
						
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
							    <div style="float:left; padding-right:5px; border-right:1px solid #999999"> 
								<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center" >
									<tr>
										<td colspan="2">
											<form name="frmTag0" id="frmTag0" method="post" >
									
									<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
									<tr>
										<td width="30%">
											Search URL : 
										</td>
										<td> 
										<input type="text" id="searchUrls" name="searchUrls" onkeyup="showUrlsAjax(<?php echo $nodeId ; ?>,<?php echo $artifactType; ?>)" size="40"/>
									   
										</td>
									</tr>
									<tr>
										<td valign="top" width="20%">&nbsp;
											
										</td>
										<td>
											<div id="divShowUrls" style="display:block;width: 285px; height: 200px; overflow: scroll; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
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
							   <div style="float:left; width:38%;">
								<table width="100%" cellpadding="5">		
									<tr>
				<td width="30%">
				<form name="frmTag2" method="post" action="<?php echo base_url();?>create_tag1" >
					<?php echo $this->lang->line('txt_New_URL');?>  :
				</td>
				<td>	
					<input name="txtUrl" type="text" size="24" id="txtUrl" maxlength="500">
				</td>
			</tr>
									<tr>
				 <td><?php echo $this->lang->line('txt_URL_Title');?>:</td>
				 <td><input name="title" type="text" id="title" size="24" maxlength="255"></td>
			</tr>
									<tr>
				 <td>&nbsp;</td>
				 <td><input name="confirm" type="button"  onclick="createImportUrl(<?php echo $nodeId; ?>,<?php  echo  $artifactType ?>,<?php echo $linkSpanOrder;?>,<?php echo $latestVersion;?>)" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"/>
						<input type="button" id="cancelTagButton" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="document.getElementById('title').value='';document.getElementById('txtUrl').value='';" />
			
			
						<input type="hidden" id="ownerId" name="ownerId" value="<?php echo $_SESSION['userId']; ?>" />
						 <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workspaceId;?>">
                        <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workspaceType;?>">
						</form></td>
			</tr>
								</table>
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

 <div>
  	<input type="hidden" id="currentTreeId" value="<?php echo $currentTreeId; ?>" />
	<input type="hidden" id="nodeId" value="<?php echo $nodeId; ?>" />
	<input type="hidden" id="leafId" value="<?php echo $leafId; ?>" />
	<input type="hidden" id="leafOrder" value="<?php echo $currentNodeOrder; ?>" />
	<input type="hidden" id="parentLeafId" value="<?php echo $parentLeafId; ?>" />
	<input type="hidden" id="treeLeafStatus" value="<?php echo $currentLeafStatus; ?>" />
	<input type="hidden" id="treeType" value="<?php echo $treeType; ?>" />
	<input type="hidden" id="artifactType" value="<?php echo $artifactType; ?>" />
	<input type="hidden" id="successorLeafStatus" value="<?php echo $successorLeafStatus; ?>" />
	
  </div>

</div>
  </body>
  </html> 
  <?php
  if($this->uri->segment(10)=='set')
  {
  ?>
	  <script>
	  setTagAndLinkCount(<?php echo $nodeId; ?>,<?php  echo  $artifactType ?>);
	  setTagsAndLinksInTitle(<?php echo $nodeId; ?>,<?php  echo  $artifactType ?>);
	  </script>
  <?php
  }
  ?>
  <script>
  function clearLinks(nodeId)
  {
  		msg = "Are you sure you want to clear previous leaf objects?";
	
		var agree = confirm(msg);
		if(agree)
		{
		
			$(".clearLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	  
			$.ajax({
	
				  url: baseUrl+"comman/clearLeafObjects/<?php echo $workspaceId;?>/type/<?php echo $workspaceType;?>/link/"+nodeId,
	
				  type: "POST",
	
				  success:function(result)
				  {
						if(result)
						{
							//alert(result);
							setTagAndLinkCount(nodeId,2);
							$('#clearLinkUpdateBox').html(result);
							$(".clearLoader").html("");
							setTagsAndLinksInTitle(nodeId,2);
							//parent.location.reload();
							//setTagAndLinkCount(nodeId,2);
							//setTagsAndLinksInTitle(nodeId,2);
						}
						
				  }
	
			});
		}
  }
  
$(document).ready(function(){
	var artifactId = '';
	var artifactType = '';
	artifactId = '<?php echo $nodeId; ?>';
	artifactType = '<?php echo $artifactType; ?>';
	//alert(artifactId+'==='+artifactType);
	setTagAndLinkCount(artifactId,artifactType);
	setTagsAndLinksInTitle(artifactId,artifactType);
	setTalkCountFromTagLink('<?php echo $leafTreeId; ?>');
	setLastTalk('<?php echo $leafTreeId; ?>');
	getSimpleColorTag(artifactId,artifactType);
	var openLink = '<?php echo $open; ?>';
	//alert(openLink);
	//Alert message Code start
			if(openLink=='set')
			{
						var currentTreeId = $('#currentTreeId').val();
						var nodeId = $('#nodeId').val();
						var leafId = $('#leafId').val();
						var leafOrder = $('#leafOrder').val();
						var parentLeafId = $('#parentLeafId').val();
						var treeLeafStatus = $('#treeLeafStatus').val();
						var treeType = $('#treeType').val();
						var artifactType = $('#artifactType').val();
						var successorLeafStatus = $('#successorLeafStatus').val();
						if(treeType==1 && artifactType==2)
						{
							//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+treeType+'=='+artifactType+'=='+successorLeafStatus);
							getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType);
						}
			}
	//Code end
	getTreeLeafObjectIconStatus('<?php echo $currentTreeId ?>', '<?php echo $nodeId ?>', '<?php echo $leafId ?>', '<?php echo $currentNodeOrder ?>', '<?php echo $parentLeafId ?>', '<?php echo $currentLeafStatus ?>', '<?php echo $workspaceId ?>', '<?php echo $artifactType ?>', '<?php echo $treeType ?>');
	
	if(artifactType==1)
	{
		getParentUpdatedSeedContents('<?php echo $nodeId ?>',1);
	}
	
	var treesType = '<?php echo $treeType ?>';
	if(treesType == 4 && artifactType==2)
	{
		getShowHideTreeLeafIconsStatus('<?php echo $currentTreeId ?>', '<?php echo $nodeId ?>', '<?php echo $treeType ?>');
	}
	$("#closePopupId",parent.document).removeAttr("href");
	
});

$("#popCloseBox",parent.document).click(function(){
	
	$(".closeLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

	var artifactId = '';
	var artifactType = '';
	artifactId = '<?php echo $nodeId; ?>';
	artifactType = '<?php echo $artifactType; ?>';
	//alert(artifactId+'=='+artifactType);
	blockId=0;

	if(artifactType==2)
	{
	  	blockId=artifactId;
	}
	
	setTalkCountFromTagLink('<?php echo $leafTreeId; ?>');
	
	setTagsAndLinksInTitle(artifactId,artifactType);
	
	setLastTalk('<?php echo $leafTreeId; ?>');
	
	getTreeLeafObjectIconStatus('<?php echo $currentTreeId ?>', '<?php echo $nodeId ?>', '<?php echo $leafId ?>', '<?php echo $currentNodeOrder ?>', '<?php echo $parentLeafId ?>', '<?php echo $currentLeafStatus ?>', '<?php echo $workspaceId ?>', '<?php echo $artifactType ?>', '<?php echo $treeType ?>');
	
	var treesType = '<?php echo $treeType ?>';
	if(treesType == 4 && artifactType==2)
	{
		getShowHideTreeLeafIconsStatus('<?php echo $currentTreeId ?>', '<?php echo $nodeId ?>', '<?php echo $treeType ?>');
	}
	
	$.ajax({
	
				  url: baseUrl+'create_tag1/countTagsAndLinks/'+artifactId+'/'+ artifactType,
	
				  type: "POST",
				  
				  async: false, 
	
				  success:function(result)
				  {
						var temp=result.split('|||@||'); 
						
						if(temp[0]==0)
			
						{
			
							temp[0]='';
			
						}
			
						if(temp[1]==0)
			
						{
			
							temp[1]='';
			
						}	
			
						$("#liTag"+blockId,parent.document).html(temp[0]);
			
						$("#liLink"+blockId,parent.document).html(temp[1]);
						
						//$(".closeLoader").html('');
						
						//alert('sdf');
				  }
	});
	
	getParentUpdatedContents(artifactId,artifactType);
	
	getSimpleColorTag(artifactId,artifactType);
	
	getSimpleColorTag(artifactId,artifactType);
	
    //setTagAndLinkCount(artifactId,artifactType);
	
	if(artifactType==1)
	{
		getParentUpdatedSeedContents('<?php echo $nodeId ?>',1);
	}
	
	setTimeout(function() 
	{ 
		hidePopup(); 
	}, 200);
	function hidePopup()
	{
		$('#popupMask',parent.document).remove();
		$('#popupContainer',parent.document).remove();
	}
	
}); 
  </script>