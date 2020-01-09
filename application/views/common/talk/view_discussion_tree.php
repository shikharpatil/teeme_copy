<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Teeme</title>
	<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
	<?php $this->load->view('editor/editor_js.php');?>
	<script>
		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
		var workSpace_name='<?php echo $workSpaceId;?>';
		var workSpace_user='<?php echo $_SESSION['userId'];?>';
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
	<script language="javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/document.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
	<script>
	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;

	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	}
 	
	var mystart='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	var myend='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	function changes_date(newsdate,newedate){
		mystart=newsdate;
		myend=newedate;
	}
	function compareDates (dat1, dat2) {
   var date1, date2;
   var month1, month2;
   var year1, year2;
	 value1 = dat1.substring (0, dat1.indexOf (" "));
	  value2 = dat2.substring (0, dat2.indexOf (" "));
	  time1= dat1.substring (1, dat1.indexOf (" "));
	  time2= dat2.substring (1, dat2.indexOf (" "));
	  
	  hours1= time1.substring (0, time1.indexOf (":"));
	  minites1= time1.substring (1, time1.indexOf (":"));
	  
	  hours2= time2.substring (0, time2.indexOf (":"));
	  minites2= time2.substring (1, time2.indexOf (":"));
	  
   year1 = value1.substring (0, value1.indexOf ("-"));
   month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
   date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
   else return 0;
} 

	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;
	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	 //Add SetTimeOut 
	 setTimeout("blinkIt()", 500);
	}
	function showFocus()
	{
		//setInterval('blinkIt()',500);
		
		//Add SetTimeOut 
		setTimeout("blinkIt()", 500);
	}
	function validate_dis(replyDiscussion,formname){

	var error='';

	if(getvaluefromEditor(replyDiscussion) == ''){
		error+='<?php echo $this->lang->line('msg_enter_topic');?>';
	}

	if(error==''){
		formname.submit();
	}else{
		jAlert(error);
	}
	
	}
	</script>
	<script language="JavaScript1.2">mmLoadMenus();</script>
	</head>
	<body>
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; background-color:#D9E3F2; margin: 0 auto;">
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> 
        <!-- header -->
        <?php $this->load->view('common/header'); ?>
        <!-- header --> 
      </div>
      <div style="float:left;"> 
        <!-- Main menu -->
        <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
			 $this->load->view('common/artifact_tabs', $details); 
			?>
        <!-- Main menu --> 
      </div>
      <div style="width:<?php echo $this->config->item('page_width')-10;?>px; float:left; padding-bottom:10px; padding-left:10px; background-color:#FFFFFF"> 
        <!-- Main Body -->
        <?php
			$seedBgColor = 'seedBgColor';
				if ($this->uri->segment(8)==$treeId)
				{
					$seedBgColor = 'nodeBgColorSelect';
				}
			?>
        <span id="tagSpan"></span>
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding:10px;">
          <ul class="navigation">
            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>
            <?php
					if (($workSpaceId==0))
					{
				?>
            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"><span><?php echo $this->lang->line('txt_Share');?></span></a></li>
            <?php
					}
				?>
            <li id="treeUpdate"></li>
          </ul>
        </div>
        <span id="add<?php echo $position;?>" style="display:none;"></span>
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;">
          <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
            <?php
                        	$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				
							$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);
							$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);
							
							
							$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);
							$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);
							$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);
							$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);
							$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);
							$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);
							$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);

						if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)
						{ 
							echo '<a href=javascript:void(0) onClick=showTagView(0,0)><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';
						}
						else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 
						{echo '&nbsp;&nbsp;';}}
						if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	
						{ 
            				echo '<a href=javascript:void(0) onClick=showArtifactLinks(0,'.$treeId.',2,'.$workSpaceId.','.$workSpaceType.',1,1)><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';
						}
						?>
          </div>
          <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-50;?>px;">
            <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;" onClick="showdetail(<?php echo $position;?>);" class="<?php echo $seedBgColor;?> handCursor"> <span class="seedHeading">
              <?php
							if($pnodeId)
							{ 
							
								echo strip_tags(stripslashes($DiscussionPerent['contents']),'<b><em><span><img>'); 
							}
							else
							{
							
								echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>'); 
							}
							?>
              </span>
              <?php
							if (!empty($arrDiscussionDetails['old_name']))
			 				{
			 					echo '<br>(Previous Name: ' .strip_tags(stripslashes($arrDiscussionDetails['old_name'])).')';
			 				}
							?>
              <div style="float:right;"> <a href="javascript:void(0);" onClick="window.location.reload();"><img src="<?php echo base_url(); ?>images/update.gif" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a> </div>
              <?php
             				if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
                			{
							?>
              <div style="float:right;"> <a href="javascript:void(0);" onClick="if(document.getElementById('edit_doc').style.display=='none') { document.getElementById('edit_doc').style.display='block';} else { document.getElementById('edit_doc').style.display='none';}"><img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit_Document_Name');?>" title="<?php echo $this->lang->line('txt_Edit_Document_Name');?>" border="0"></a> </div>
              <?php
							}
							?>
            </div>
          </div>
          <div id="edit_doc" class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px; float:left; display:none;">
            <form name="frmDocument" method="post" action="<?php echo base_url();?>edit_document/update/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/discussion" onSubmit="return validateDocumentName();">
              <textarea name="documentName" id="documentName"><?php echo stripslashes($arrDiscussionDetails['name']);?></textarea>
              <br>
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="docTitleSave();" />
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Cancel');?>" onclick="docTitleCancel();" />
              <input type="hidden" name="treeId" value="<?php echo $treeId; ?>">
            </form>
            <script>chnage_textarea_to_editor('documentName','simple');</script> 
          </div>
        </div>
        <?php $userDetails = $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']); ?>
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px; display:none;" id="detail<?php echo $position;?>">
          <div class="seedBgColor" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> <?php echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;<span class="style2">'.$this->lang->line('txt_Date').'</span>:'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['createdDate'],$this->config->item('date_format'));?> </div>
          <div class="seedBgColor" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;" id="normalViewTree<?php echo $treeId;?>"> <a href="javascript:void(0)" onClick="showTagView('0','0')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; <a href="javascript:void(0)" onClick="showArtifactLinks('0',<?php echo $treeId;?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,1,1)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp; </div>
        </div>
        <span id="spanArtifactLinks0" style="display:none;"></span>
        <?php		
				#********************************************* Tags ********************************************************88
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
        <span id="spanTagView0" style="display:none;"> <span id="spanTagViewInner0">
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
          <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}					
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
							
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';						
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				if($dispViewTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';
					$nodeTagStatus = 1;		
					?>
          </div>
          <?php				
				}		
				if($dispResponseTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					
					$nodeTagStatus = 1;
					?>
          </div>
          <?php	
				}		
				if($dispContactTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					
					$nodeTagStatus = 1;	
					?>
          </div>
          <?php	
				}		
				if($dispUserTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?>
          </div>
          <?php		
				}	
							
				if($nodeTagStatus == 0)	
				{
				?>
          <div> <?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?> </div>
          <?php
				}
				?>
          <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
            <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(0,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $treeId;?>,1)" />
            <span id="spanTagNew0">
            <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(0, <?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" />
            </span>
            <iframe id="iframeId0" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
          </div>
        </div>
        </span> </span>
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
          <iframe id="linkIframeId0" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
        </div>
        <?php #*********************************************** Tags ******************************************************** ?>
        <?php
		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
		{
		?>
        <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span> </div>
        <?php
		}
		?>
        <?php	
	$focusId = 2;
	$totalNodes = array();
	
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	$i = 1;
	
	if(count($arrDiscussions) > 0)
	{					 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
					
			$seedBgColor = 'seedBgColor';
			
			if ($this->uri->segment(8)==$arrVal['nodeId'])
			{
				$seedBgColor = 'nodeBgColorSelect';
			}
			else
			{
				$seedBgColor = ($i % 2) ? $rowColor1 : $rowColor2;	
			}

			$position++;
			$allPositions.=$position.',';
			$totalNodes[] 			= $position;
			$userDetails			= $this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);				
			$checksucc 				= $this->discussion_db_manager->checkSuccessors($arrVal['nodeId']);
			$this->discussion_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			
			$viewCheck=$this->discussion_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			?>
        <div id="latestcontent<?php echo $arrVal['leafId'];?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:50px;">
          <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
            <?php
			if($checksucc)
			{
				echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$arrVal['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" title="'.$this->lang->line("Msg_Topic_has_replies").'" /></a>';
			}

			$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
			$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
			$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
			$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);
			
			$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
			$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
			$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
			$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
			$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
			$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
			$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);
		
				if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)
				{ 
					echo '<a href=javascript:void(0) onClick=showTagView('.$arrVal["nodeOrder"].','.$position.')><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';
				}
				else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 
				{echo '&nbsp;&nbsp;';}}
				if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	
				{ 
            		echo '<a href=javascript:void(0) onClick=showArtifactLinks(\''.$arrVal["nodeId"].'\','.$arrVal["nodeId"].',2,'.$workSpaceId.','.$workSpaceType.',2,1)><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';
				} 

				?>
          </div>
          <div id="editcontent<?php echo $position;?>" class="<?php echo $seedBgColor;?> handCursor" onClick="showdetail(<?php echo $position;?>);" style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
            <?php 
					echo stripslashes($arrVal['contents']);
				?>
          </div>
        </div>
        <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; display:none;" id="add<?php echo $position;?>">
          <div id="detail<?php echo $position;?>" class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-85;?>px; float:left; display:none;">
            <?php 
					echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;<span class="style2">'.$this->lang->line('txt_Date').'</span>:'.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'],$this->config->item('date_format'));
				?>
          </div>
          <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-85;?>px; float:left;"> <a href="javascript:void(0)" onClick="showTagView('<?php echo $arrVal['nodeOrder'];?>',<?php echo $position;?>)"><?php echo $this->lang->line('txt_Tags');?></a> &nbsp;&nbsp;<a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrVal['nodeId'];?>',<?php echo $arrVal['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1)"><?php echo $this->lang->line('txt_Links');?></a> 
            <!--&nbsp;&nbsp;<a href="javascript:newTopic(<?php echo $arrVal['nodeOrder'];?>,<?php echo $focusId;?>,<?php echo $position;?>);"><?php echo $this->lang->line('txt_Add_New_Topic');?></a>--> 
            &nbsp;&nbsp;<!--<a href="javascript:reply(<?php echo $position;?>,<?php echo $focusId;?>,<?php echo $arrVal['nodeId'];?>);"><?php echo $this->lang->line('txt_Reply');?></a>--> 
            <a href="<?php echo base_url().'view_discussion/Discussion_reply/'.$arrVal['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType;?>"><?php echo $this->lang->line('txt_Reply');?></a> </div>
        </div>
        <div id="reply_teeme<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left; display:none;">
          <form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $treeId;?>">
            <input name="nodeId" type="hidden" value="<?php echo $arrVal['nodeId'];?>">
            &nbsp;&nbsp;&nbsp;
            <textarea name="replyDiscussion<?php echo $arrVal['nodeId'];?>" id="replyDiscussion<?php echo $arrVal['nodeId'];?>"></textarea>
            <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion<?php echo $arrVal['nodeId'];?>',document.form12<?php echo $position;?>);" class="button01">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(<?php echo $position;?>);" class="button01">
            <input name="reply" type="hidden" id="reply" value="1">
            <input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrVal['nodeId'];?>">
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
          </form>
        </div>
        <div id="newTopic<?php echo $arrVal['nodeOrder'];?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left; display:none;">
          <form name="form<?php echo $arrVal['nodeOrder'];?>" method="post" action="<?php echo base_url();?>new_discussion/start_Discussion/<?php echo $pnodeId;?>">
            &nbsp;&nbsp;&nbsp;
            <textarea name="replyDiscussion<?php echo $arrVal['nodeOrder'];?>" id="replyDiscussion<?php echo $arrVal['nodeOrder'];?>"></textarea>
            <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion<?php echo $arrVal['nodeOrder'];?>',this.form);" class="button01">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Replybutton1" value="Cancel" onClick="newTopicClose(<?php echo $arrVal['nodeOrder'];?>);" class="button01">
            <input name="reply" type="hidden" id="reply" value="1">
            <input name="editorname1" type="hidden" value="replyDiscussion<?php echo $arrVal['nodeOrder'];?>">
            <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
            <input type="hidden" name="nodeOrder" value="<?php echo $arrVal['nodeOrder'];?>" id="nodeOrder">
          </form>
        </div>
        <?php
				#********************************************* Tags ********************************************************88
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
        <span id="spanArtifactLinks<?php echo $arrVal['nodeOrder'];?>" style="display:none;"> </span> <span id="spanTagView<?php echo $arrVal['nodeOrder'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeOrder'];?>">
        <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
          <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}					
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
						
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeOrder'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeOrder'].')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeOrder'].')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeOrder'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							
						
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrVal['nodeOrder'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				if($dispViewTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';
					$nodeTagStatus = 1;		
					?>
          </div>
          <?php				
				}		
				if($dispResponseTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					
					$nodeTagStatus = 1;
					?>
          </div>
          <?php	
				}		
				if($dispContactTags != '')		
				{
					?>
          <div>
            <?php
					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					
					$nodeTagStatus = 1;	
					?>
          </div>
          <?php	
				}		
				if($dispUserTags != '')		
				{
				?>
          <div>
            <?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?>
          </div>
          <?php		
				}								
				if($nodeTagStatus == 0)	
				{
				?>
          <div> <?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?> </div>
          <?php
				}
				?>
        </div>
        </span>
        <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrVal['nodeOrder'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,2)" />
          <span id="spanTagNew<?php echo $arrVal['nodeOrder'];?>">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeOrder']; ?>)" />
          </span>
          <iframe id="iframeId<?php echo $arrVal['nodeOrder'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
        </div>
        </span>
        <?php #*********************************************** Tags ******************************************************** ?>
        <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
          <iframe id="linkIframeId<?php echo $arrVal['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
        </div>
        <?php
			$focusId = $focusId+2;
			$i++;
		}
	}
?>
        <div id="reply_teeme0" style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px; float:left; margin-top:0px;"> <b><br>
          <?php echo $this->lang->line('txt_Add_New_Topic');?>:</b><br>
          <br>
          <form name="form0" method="post" action="<?php echo base_url();?>new_discussion/start_Discussion/<?php echo $pnodeId;?>">
            &nbsp;&nbsp;&nbsp;
            <textarea name="replyDiscussion" id="replyDiscussion"></textarea>
            <script language="javascript">chnage_textarea_to_editor('replyDiscussion');</script>
            <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',this.form);" class="button01">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Replybutton1" value="Cancel" onClick="setValueIntoEditor('replyDiscussion','');" class="button01">
            <input name="reply" type="hidden" id="reply" value="1">
            <input name="editorname1" type="hidden"  value="replyDiscussion">
            <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
            <input type="hidden" name="nodeOrder" value="0" id="nodeOrder">
          </form>
        </div>
        <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
      </div>
      <div style="float:left" class="copy"> 
        <!-- Footer -->
        <?php $this->load->view('common/footer');?>
        <!-- Footer --> 
      </div>
    </div>
</body>
</html>
<script>
// Parv - Keep Checking for tree updates every 5 second
<!--Updated by Surbhi IV-->
//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);		

//Add SetTimeOut 
setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);

<!--End of Updated by Surbhi IV-->

function hideallMenus(position){
	var arrLeafIds = new Array();
		arrLeafIds = document.getElementById('allnodesOrders').value.split(',');
		
		//alert ('arrleafids' + arrLeafIds);
		for(var i=0;i<arrLeafIds.length;i++)
		{
			if (leafOrder!=arrLeafIds[i])
			{
				document.getElementById('leafOptions'+arrLeafIds[i]).style.display = 'none';
			}
		}	
		 document.getElementById('leafAddFirst').style.display="none";	
		
}


function reply(id,focusId,nodeId)
{
	
	chnage_textarea_to_editor('replyDiscussion'+nodeId);
	
	whofocus=focusId;	
	frameIndex = focusId;
	var divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
	
	showdetail (id);	

}
function newTopic(id,focusId,position)
{


	chnage_textarea_to_editor('replyDiscussion'+id);
	
	whofocus=focusId;	
	frameIndex = focusId;
	var divid='newTopic'+id;
	document.getElementById(divid).style.display='';
	
	showdetail (position);
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}
function newTopicClose(id){
	divid='newTopic'+id;
 	document.getElementById(divid).style.display='none';
}
function vksfun(focusId){
whofocus=focusId;
}
</script>