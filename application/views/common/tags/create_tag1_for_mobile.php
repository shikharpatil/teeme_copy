<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Teeme</title>
		<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />
		<?php $this->load->view('editor/editor_js.php');?>
		<script>
		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
		var workSpace_name='<?php echo $workSpaceId;?>';
		var workSpace_user='<?php echo $_SESSION['userId'];?>';
		var node_lock=0;
	</script>
		<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
		<?php 	if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)
		{
	?>
		<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>
		<?php
		}         
	?>
		<!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
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
		<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/validation.js"></script>
		<script type="text/javascript" language="JavaScript1.2">mmLoadMenus();</script>
		<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
		<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>
		<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
		<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
		
		
	 	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>
		
		<script type="text/javascript">

function edit_action_tag(workSpaceId,workSpaceType,artifactId,artifactType,sequenceTagId,tagOption,tagId)
{
	
		var xmlHttpRequest = GetXmlHttpObject2();
		urlm=baseUrl+'add_tag/editActionTag/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType+'/'+sequenceTagId+'/'+tagOption+'/'+tagId;	 
		var iframeId='iframeId0';
		var liTag='liTag';
		if(artifactType==2)
		{
		  	iframeId="iframeId"+artifactId;
			
			liTag='liTag'+artifactId;
			
		}
		xmlHttpRequest.open("POST", urlm, true);
		 
		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xmlHttpRequest.onreadystatechange = function()
		{
			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)
			{
				  
				 document.getElementById("divActionTagContainer").innerHTML=xmlHttpRequest.responseText;
				 
				 //Manoj: showing mobile datepicker when edit action tag 
				  $("#dtBox_tag").DateTimePicker();
	
						
			}
		}     
		xmlHttpRequest.send(); 
		
	}


		</script>
		</head>
		<body>
<div id="clearTagUpdateBox">		
<div class="boxtext">
          <div class="menu_new h2_class">
    <ul class="tab_tag_link">
              <li  id="tabTagsList" class="tabs_tags_select"> <a   href="javaScript:void(0)" onclick="showHideTagsView('')" ><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; </li>
              <?php 
			
			
			  if(($latestVersion==1 && ($latestTreeVersion==1 || $artifactType==1) && ($nodeSuccessor === 0 || $successorLeafStatus == 'draft' || $treeType!=1 || $artifactType==1) && ($currentLeafStatus!='discarded' || $artifactType==1) && $leafDraftReserveStatus!=1 && $spaceMoved!=1) || ($latestVersion==1 && $currentTreeId==0))
			 {
			   $_SESSION['set_doc_latest_version']=0; 
			 ?>
              <li  id="tabTagsSet" class="tabs_tags"> <a href="javaScript:void(0)" onclick="showHideTagsView('add')" ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="add new tag" border="0" ></a> </li>
              <?php 
			      }
			?>
            </ul>
			<div style="float:right">
				<div class="closeLoader"></div>
			</div>
  </div>
          <div class="clr" ></div>
        </div>
<ul class="navigation" id="tagsNavigation" style="display:none;  padding-left:15px;" >
          <li style="margin-right:5px;"  >
    <select name="groupTags" id="groupTags" onchange="getTagView(this.value)" style="width:140px;">
              <option value="2" <?php if($tagOption == 2) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Simple');?></option>
              <option value="3" <?php if($tagOption == 3) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Response');?></option>
              <option value="5" <?php if($tagOption == 5) { ?>SELECTED <?php } ?>><?php echo $this->lang->line('txt_Contact');?></option>
            </select>
  </li>
        </ul>
<div id="divAllTags">
          <div id="tags_container" class="slider-content" style="padding: 0px 10px 0px 10px" >
    <p>
               <?php
			if($leafClearStatus == 1 && $leafClearStatus != '' && $latestVersion==1 && $artifactType==2)
			{
				?>
				<div class="clearMsgPadding"><?php echo $this->lang->line('txt_clear_prev_tag_obj_msg'); ?></div>
			<?php
			}	
						 
			
			if((count($viewTags)+count($actTags)+count($contactTags)+count($userTags))>0)
			{
			
			if($leafClearStatus == 0 && $leafClearStatus != '' && $latestVersion==1 && $leafOwnerData['userId']==$_SESSION['userId'])
			{
			?>
			<div>
				<input type="button" name="clear" value="<?php echo $this->lang->line('txt_clear_prev_tag_obj'); ?>" onclick="clearTags('<?php echo $artifactId ?>');" style="margin-bottom:10px;" /> 
			</div>
			
			<div class="clearLoader" id="clearLoader"></div>
			
			<?php
			}	
			
			if(count($viewTags)>0)
			{		 
						       
				$tag_container.=$this->lang->line('txt_Simple_Tag').' : <span>';
				$i=0;
				 foreach($viewTags as $simpleTag)
				 {
				 	if($i>0)
					{	
						$tag_container.= ", ";
					}
				 	$tag_container.=$simpleTag['tagName'];
					$i++;
				 }
				 $tag_container.='</span><br/>';
			}
			
				 
		 
		 		
							
			if(count($actTags) > 0)
			{
				$tag_container.=$this->lang->line('txt_Response_Tag').' : <span>';
				$tagAvlStatus = 1;	
				$i=0;
				foreach($actTags as $tagData)
				{	$dispResponseTags='';
					if($i>0)
					{	
						$dispResponseTags.= ", ";
					}
					$dispResponseTags = $tagData['comments'].' [';							
					$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
					if(!$response)
					{  
						
						if ($tagData['tag']==1)
							$dispResponseTags .= '<a href="javascript:void(0)"  onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						if ($tagData['tag']==2)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
						if ($tagData['tag']==3)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
						if ($tagData['tag']==4)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
					}
					$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
										
					$dispResponseTags .= '] ';
					
					$tag_container.=$dispResponseTags;
					$i++;
				}
				$tag_container.='</span><br/>';
			}
			
			$tag_container.='<div id="actionTagResponse"></div>';
			if(count($contactTags) > 0)
				{
				    $tag_container.=$this->lang->line('txt_Contact_Tag').' : <span>';
					$tagAvlStatus = 1;	
					$i=0;
					foreach($contactTags as $tagData)
					{
						if($i>0)
						{	
							$tag_container.= ", ";
						}
						
						$tag_container .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a> ';	
						
						$i++;								
					}
					 $tag_container.='</span><br>';
				}		
		
		 
		
		 
		 }
		 else
		 {
		      $tag_container.='<div style="padding-left:3px;">'.$this->lang->line('txt_None').'</div>';
		 }
			echo  $tag_container;					
						?>
            </p>
  </div>
        </div>
<div id="allTagViews" style="padding:0px 5px 0px 5px;"> 
          
          <!-- ------------------ Simple tags starts here-------------------------- -->
          
          <div id="divSimpleView" style="display:none">
    <div class="clr"></div>
    <div class="slider-content">
              <?php
		
				
					$tags = $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
					$arrTagDetails['tags'] = $tags;
							
					$lastLogin = $this->identity_db_manager->getLastLogin();
					$currentTags = $this->tag_db_manager->getCurrentTags(2, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
					$arrTagDetails['currentTags'] = $currentTags;
					
					$arrTagDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
					
					
					$arrTagDetails['treeId'] = $treeId;
					
					//This session uses to  show tag in simple tage view
					$_SESSION['artifactId'] = $artifactId;
					$_SESSION['artifactType'] = $artifactType;
					
					$arrTagDetails['createUrl'] = $createUrl;
			
					if($addNewOption == 1)
					{	
					   $this->load->view('common/tags/view_tag2_for_mobile', $arrTagDetails); 
					}	
					else
					{	
						$this->load->view('common/tags/add_view_tag', $arrTagDetails); 
					}
					
					
				?>
            </div>
  </div>
          
          <!-- simple tags closes here ------------------------------------>
          <!--Manoj: Reduced min width 250 from 500 -->
          <div id="divActionView"  style="display:none;overflow:visible;min-width:250px;padding-bottom:10px;">
    <div class="clr"></div>
    <div class="slider-content" id="divActionTagContainer" >
              <?php
				    $tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);
					$arrTagDetails['tags'] = $tags;						
								
					$lastLogin = $this->identity_db_manager->getLastLogin();
					$currentTags = $this->tag_db_manager->getCurrentTags(3, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
					$arrTagDetails['currentTags'] = $currentTags;
					$arrTagDetails['tagOption'] = 3;
							
					$arrTagDetails['createUrl'] = $createUrl;
					
						if ($artifactType==2) // if leaf
						{
							$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity ($artifactId);
						}
						else //if tree
						{
							$treeId = $artifactId;
						}
					$arrTagDetails['sharedMembers'] = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
							
				
							
							if ($tagId)
							{
				
								$arrTagDetails['editTagId'] = $tagId;

							}
							$arrTagDetails['treeId']=$treeId;
					
							if($addNewOption == 1)
							{	
								$this->load->view('common/tags/act_tag_for_mobile', $arrTagDetails);  
							}	
							else if($addNewOption == 3)
							{	
								$arrTagDetails['tagId'] = $this->uri->segment(10);	
								$this->load->view('common/tags/act_response_for_mobile', $arrTagDetails); 
							}			
							else
							{	
								$this->load->view('common/tags/add_act_tag', $arrTagDetails); 
							}	
							
						
							?>
            </div>
  </div>
          
          <!-- Action tag closes here - -->
          
          <div id="divContactView" style="display:none;">
    <div class="clr"></div>
    <div class="slider-content">
              <?php
							$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $artifactId, $artifactType);
							$arrTagDetails['tags'] = $tags;
							$arrTagDetails['treeId'] = $treeId;
						
							$lastLogin = $this->identity_db_manager->getLastLogin();
							$currentTags = $this->tag_db_manager->getCurrentTags(5, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
							$arrTagDetails['currentTags'] = $currentTags;
							
							$arrTagDetails['tagOption']=5;
								
							if($addNewOption == 1)
							{	
						
								$this->load->view('common/tags/add_contact_tag_for_mobile', $arrTagDetails); 
							}	
							else
							{	
								$this->load->view('common/tags/add_contact_tag_for_mobile', $arrTagDetails); 
							}	
																		
							
				?>
            </div>
  </div>
  <div>
  	<input type="hidden" id="currentTreeId" value="<?php echo $treeId; ?>" />
	<input type="hidden" id="nodeId" value="<?php echo $artifactId; ?>" />
	<input type="hidden" id="leafId" value="<?php echo $leafId; ?>" />
	<input type="hidden" id="leafOrder" value="<?php echo $currentNodeOrder; ?>" />
	<input type="hidden" id="parentLeafId" value="<?php echo $parentLeafId; ?>" />
	<input type="hidden" id="treeLeafStatus" value="<?php echo $currentLeafStatus; ?>" />
	<input type="hidden" id="treeType" value="<?php echo $treeType; ?>" />
	<input type="hidden" id="artifactType" value="<?php echo $artifactType; ?>" />
	<input type="hidden" id="successorLeafStatus" value="<?php echo $successorLeafStatus; ?>" />
	
  </div>
        </div>
</div>
</body>
</html>
<script>
function clearTags(nodeId)
  {
  		msg = "Are you sure you want to clear previous leaf objects?";
	
		var agree = confirm(msg);
		if(agree)
		{
		
			$(".clearLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	  
			$.ajax({
	
				  url: baseUrl+"comman/clearLeafObjects/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/tag/"+nodeId,
	
				  type: "POST",
	
				  success:function(result)
				  {
						//alert(result);
						if(result)
						{
							//alert(result);
							//alert(nodeId);
							setTagAndLinkCount(nodeId,2);
							setTagsAndLinksInTitle(nodeId,2);
							$('#clearTagUpdateBox').html(result);
							$("#leaf_contents"+nodeId,parent.document).removeClass();
							$("#leaf_contents"+nodeId,parent.document).addClass('contentContainer');
							$(".clearLoader").html("");
						
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
	artifactId = '<?php echo $artifactId; ?>';
	artifactType = '<?php echo $artifactType; ?>';
	//alert(artifactId+'==='+artifactType);
	setTagAndLinkCount(artifactId,artifactType);
	setTagsAndLinksInTitle(artifactId,artifactType);
	setTalkCountFromTagLink('<?php echo $leafTreeId; ?>');
	setLastTalk('<?php echo $leafTreeId; ?>');
	getSimpleColorTag(artifactId,artifactType);
	getTreeLeafObjectIconStatus('<?php echo $treeId ?>', '<?php echo $artifactId ?>', '<?php echo $leafId ?>', '<?php echo $currentNodeOrder ?>', '<?php echo $parentLeafId ?>', '<?php echo $currentLeafStatus ?>', '<?php echo $workSpaceId ?>', '<?php echo $artifactType ?>', '<?php echo $treeType ?>');
	if(artifactType==1)
	{
		getParentUpdatedSeedContents('<?php echo $treeId ?>',1);
	}
	var treesType = '<?php echo $treeType ?>';
	if(treesType == 4 && artifactType==2)
	{
		getShowHideTreeLeafIconsStatus('<?php echo $treeId ?>', '<?php echo $artifactId ?>', '<?php echo $treeType ?>');
	}
	
});

$("#popCloseBox",parent.document).click(function(){
	var artifactId = '';
	var artifactType = '';
	artifactId = '<?php echo $artifactId; ?>';
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
	
	$(".closeLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	
	getTreeLeafObjectIconStatus('<?php echo $treeId ?>', '<?php echo $artifactId ?>', '<?php echo $leafId ?>', '<?php echo $currentNodeOrder ?>', '<?php echo $parentLeafId ?>', '<?php echo $currentLeafStatus ?>', '<?php echo $workSpaceId ?>', '<?php echo $artifactType ?>', '<?php echo $treeType ?>');
	
	var treesType = '<?php echo $treeType ?>';
	if(treesType == 4 && artifactType==2)
	{
		getShowHideTreeLeafIconsStatus('<?php echo $treeId ?>', '<?php echo $artifactId ?>', '<?php echo $treeType ?>');
	}
	
	$.ajax({
	
				  url: baseUrl+'create_tag1/countTagsAndLinks/'+artifactId+'/'+artifactType,
	
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
						
						$(".closeLoader").html('');
						
						//alert('sdf');
				  }
	});
	
	getParentUpdatedContents(artifactId,artifactType);
	
	getSimpleColorTag(artifactId,artifactType);
	if(artifactType==1)
	{
		getParentUpdatedSeedContents('<?php echo $treeId ?>',1);
	}
	
    //setTagAndLinkCount(artifactId,artifactType);
	
}); 
</script>