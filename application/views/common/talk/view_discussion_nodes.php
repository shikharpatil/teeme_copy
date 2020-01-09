<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
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
<script language="JavaScript1.2">mmLoadMenus();</script>
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
	var error=''
 	replyDiscussion1=replyDiscussion+'1';
	
	
	if(getvaluefromEditor(replyDiscussion) == ''){
		error+='<?php echo $this->lang->line('msg_enter_reply');?>';
	}
	
	if(error==''){
	
		formname.submit();
	}else{
		jAlert(error);
	}
	
}
	

function changeNav(curNav)
{	
	var leftNavVal 	= parseInt(document.getElementById('topLeftNav').value);
	var rightNavVal = parseInt(document.getElementById('topRightNav').value);
	var totalNavVal = parseInt(document.getElementById('totalNav').value);
	var leftImgId 	= 'navLeftImg';	
	var rightImgId 	= 'navRightImg';
	if(curNav == 1)
	{
		document.getElementById('curNav').style.display = 'none';
		
		document.getElementById('topRightNav').value = (parseInt(leftNavVal)+1);
		document.getElementById(rightImgId).style.display = '';	
		if(leftNavVal > 1)
		{
			document.getElementById('topLeftNav').value = leftNavVal-1;	
			for(var i=1; i<=totalNavVal;i++)
			{
				
				if(i == leftNavVal)
				{						
					document.getElementById('nav'+i).style.display = '';
				}	
				else
				{	
					document.getElementById('nav'+i).style.display = 'none';
				}		
			}						
		}	
		else
		{
			for(var i =1; i<=totalNavVal;i++)
			{
				if(i == leftNavVal)
				{	
					document.getElementById('nav'+i).style.display = '';
				}	
				else
				{	
					document.getElementById('nav'+i).style.display = 'none';
				}		
			}			
			document.getElementById(leftImgId).style.display = 'none';			
		}
	}
	else if(curNav == 2)
	{		
		document.getElementById('topLeftNav').value = rightNavVal-1;
		document.getElementById(leftImgId).style.display = '';	
		if(rightNavVal < totalNavVal)
		{
			document.getElementById('topRightNav').value = rightNavVal+1;
			for(var i =1; i<=totalNavVal;i++)
			{
				if(i == rightNavVal)
				{	
					document.getElementById('nav'+i).style.display = '';
				}	
				else
				{	
					document.getElementById('nav'+i).style.display = 'none';
				}		
			}			
		}	
		else
		{
			for(var i =1; i<=totalNavVal;i++)
			{
				if(i == rightNavVal)
				{	
					document.getElementById('nav'+i).style.display = '';
				}	
				else
				{	
					document.getElementById('nav'+i).style.display = 'none';
				}		
			}			
			document.getElementById(rightImgId).style.display = 'none';
		}
	}		
}

</script>
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
  </div>
  <div style="width:<?php echo $this->config->item('page_width')-10;?>px; float:left; padding-bottom:10px; padding-left:10px; background-color:#FFFFFF"> 
    <!-- Main Body --> 
    
    <span id="tagSpan"></span>
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px; padding-top:10px;">
      <ul class="navigation">
        <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
        <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
        <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
        <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4"><span><?php echo $this->lang->line('txt_Link_View');?></span></a></li>
        <li id="treeUpdate"></li>
      </ul>
    </div>
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;">
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;" class="seedBgColor seedHeading"> <?php echo stripslashes($treeDetails['name']);?> </div>
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;" class="seedBgColor">
        <?php
			
				$split = 20;
				$totalNodes = count($_SESSION['nodes']);
			
				if($totalNodes > $split)
				{
					?>
        <span id="navLeftImg"><img src="<?php echo base_url();?>images/left.gif" border="0" onClick="changeNav(1)"></span>
        <?php	
					$nav = 1;
					for($i = 0;$i<$totalNodes; $i++)
					{
						$spanClose = 0;	
						if($i%$split == 0)
						{
						?>
        <span id="nav<?php echo $nav;?>" style="display:none;">
        <?php
							$nav++;
						}
						?>
        <?php			
						if(($i+1)%$split == 0)
						{
							$spanClose = 1;
						?>
        </span>
        <?php
						}
						?>
        <?php	
					}	
					if($spanClose == 0)
					{
					?>
        </span>
        <?php
					}	
					?>
        <span id="curNav">
        <?php
					for($i = $totalNodes-$split;$i<$totalNodes; $i++)
					{
					?>
        <?php	
					}
					?>
        </span> <span id="navRightImg" style="display:none;"><img src="<?php echo base_url();?>images/right.gif" border="0" onClick="changeNav(2)"></span>
        <?php	
				}
				else
				{
					for($i = 0;$i<$totalNodes; $i++)
					{
					?>
        <?php	
					}	
				}
				?>
        <input type="hidden" name="topLeftNav" id="topLeftNav" value="<?php echo ($nav-2);?>">
        <input type="hidden" name="topRightNav" id="topRightNav" value="<?php echo $nav-1;?>">
        <input type="hidden" name="totalNav" id="totalNav" value="<?php echo $nav-1;?>">
      </div>
      <div class="seedBgColor" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
        <?php
							$arrTotalNodes = array();
							$arrTotalNodes[] = $arrparent['nodeId'];
							$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrparent['userId']);
							$checkPre =$this->discussion_db_manager->checkPredecessor($arrparent['nodeId']);
							
							$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrparent['nodeId'], 2);
							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrparent['nodeId'], 2);
							$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrparent['nodeId'], 2);
							$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrparent['nodeId'], 2);
				
							$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 1, 2);
							$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 2, 2);
							$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 3, 2);
							$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 4, 2);
							$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 5, 2);
							$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrparent['nodeId'], 6, 2);
							$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrparent['nodeId'], 2);				
							if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)
							{ 		
								echo '<a href=javascript:void(0) onClick=showTagView('.$arrparent["nodeId"].','.$position.')><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';
							}
							else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 
							{echo '&nbsp;&nbsp;';}}
							if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	
							{ 
            					echo '<a href=javascript:void(0) onClick=showArtifactLinks(\''.$arrparent["nodeId"].'\','.$arrparent["nodeId"].',2,'.$workSpaceId.','.$workSpaceType.',2,1,'.$position.')><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';
							}	
						
							?>
        <span class="style1">
        <?php
							if($checkPre)
							{
								echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$checkPre.'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
							}
							else
							{
								echo '<a href="'.base_url().'view_discussion/node/'.$arrparent['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/left.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
							}
							?>
        </span> </div>
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;" onClick="showdetail(<?php echo $position;?>);" class="seedBgColor handCursor"> <?php echo stripslashes($arrparent['contents']);?> </div>
      <div id="detail<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; display:none;">
        <div id="add<?php echo $position;?>" class="seedBgColor style1" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; display:none;">
          <?php 
						echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;<span class="style2">'.$this->lang->line('txt_Date').'</span>:'.$this->time_manager->getUserTimeFromGMTTime($arrparent['DiscussionCreatedDate'],$this->config->item('date_format'));?>
        </div>
        <div class="seedBgColor" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> <a href="javascript:void(0);" onClick="showTagView('<?php echo $arrparent['nodeId'];?>','<?php echo $position;?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; <a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrparent['nodeId'];?>',<?php echo $arrparent['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1,'<?php echo $position;?>')"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp; </div>
      </div>
      <?php
				#********************************************* Tags ********************************************************
				
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
      <span id="spanArtifactLinks<?php echo $arrparent['nodeId'];?>" style="display:none;"> </span> <span id="spanTagView<?php echo $arrparent['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrparent['nodeId'];?>">
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
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrparent['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrparent['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrparent['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrparent['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							
						}
						$dispResponseTags .= '<a href="javascript:void(0);" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
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
        <div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>
        <?php
				}
				?>
      </div>
      </span>
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
        <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrparent['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrparent['nodeId'];?>,2)" />
        <span id="spanTagNew<?php echo $arrparent['nodeId'];?>">
        <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrparent['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrparent['nodeId']; ?>,2,0,1,<?php echo $arrparent['nodeId']; ?>)" />
        </span> </div>
      </span>
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
        <iframe id="iframeId<?php echo $arrparent['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
      </div>
      <div style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:10px;  float:left;">
        <iframe id="linkIframeId<?php echo $arrparent['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
      </div>
    </div>
    <?php	
				
				#*********************************************** Tags ********************************************************	
				?>
    <?php	
	$focusId = 2;
	$totalNodes = array();
	
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	$i = 1;
	
	if($arrparent['successors'])
	{		
			$arrChildNodes = $this->discussion_db_manager->getChildNodes($arrparent['nodeId'], $arrparent['treeIds']);	
			$sArray = array();
			
			$sArray = $arrChildNodes;
			
			while($counter < count($sArray)){
			
				$seedBgColor = '';
 				
				$arrDiscussions=$this->discussion_db_manager->getPerentInfo($sArray[$counter]);		
				
				
				if($this->uri->segment(7)==$arrDiscussions['nodeId'] && $this->uri->segment(7)!='' && $arrDiscussions['nodeId']!='' )
				{
					$seedBgColor = 'nodeBgColorSelect';
				}
				else
				{
					$seedBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
				}

				

				$position++;
				$totalNodes[] = $position;
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc =$this->discussion_db_manager->checkSuccessors($arrDiscussions['nodeId']);	
			
			?>
    <div id="latestcontent<?php echo $arrVal['leafId'];?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; padding-left:50px;">
      <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
        <?php
				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);


					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrDiscussions['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrDiscussions['nodeId'], 2);				
				if(count($viewTags) > 0||count($actTags) > 0||count($contactTags) > 0||count($userTags) > 0)
				{ 		
					echo '<a href=javascript:void(0) onClick=showTagView('.$arrDiscussions["nodeId"].','.$position.')><img src='.base_url().'images/tag.gif alt='.$this->lang->line('txt_Tags').' title='.$this->lang->line("txt_Tags").' border=0></a>';
				}
				else{if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7)) 
				{echo '&nbsp;&nbsp;';}}
				if(sizeof($docTrees1)||sizeof($docTrees2)||sizeof($docTrees3)||sizeof($docTrees4)||sizeof($docTrees5)||sizeof($docTrees6)||sizeof($docTrees7))	
				{ 
            		echo '<a href=javascript:void(0) onClick=showArtifactLinks(\''.$arrDiscussions["nodeId"].'\','.$arrDiscussions["nodeId"].',2,'.$workSpaceId.','.$workSpaceType.',2,1,'.$position.')><img src='.base_url().'images/link.gif alt='.$this->lang->line("txt_Links").' title='.$this->lang->line("txt_Links").' border=0></a>';
				}										
				?>
        <span id="img<?php echo $position;?>">
        <?php 
					if($checksucc)
					{
						echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$arrDiscussions['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
					}
				?>
        </span> </div>
      <div id="latestcontent<?php echo $arrDiscussions['leafId'];?>">
        <div id="editcontent<?php echo $position;?>" class="<?php echo $seedBgColor;?> handCursor" onClick="showdetail(<?php echo $position;?>);" style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
          <?php 
					
					echo stripslashes($arrDiscussions['contents']); 
					?>
        </div>
      </div>
    </div>
    <div id="detail<?php echo $position;?>" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; display:none;">
      <div id="add<?php echo $position;?>" class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-85;?>px; float:left; display:none;">
        <?php 
					echo '<span class="style1">'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;<span class="style2">'.$this->lang->line('txt_Date').'</span>:'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format'));?>
      </div>
      <div class="<?php echo $seedBgColor;?>" style="width:<?php echo $this->config->item('page_width')-85;?>px; float:left;"> <a href="javascript:void(0);" onClick="showTagView('<?php echo $arrDiscussions['nodeId'];?>','<?php echo $position;?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2,1,'<?php echo $position;?>')"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp; </div>
    </div>
    <?php
				#********************************************* Tags ********************************************************88

				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
    <span id="spanArtifactLinks<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrDiscussions['nodeId'];?>">
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
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrDiscussions['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
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
      <div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>
      <?php
				}
				?>
    </div>
    </span>
    <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
      <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onclick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)" />
      <span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>">
      <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onclick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1,<?php echo $arrDiscussions['nodeId']; ?>)"/>
      </span> </div>
    </span>
    <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
      <iframe id="iframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
    </div>
    <div style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left;">
      <iframe id="linkIframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="450" scrolling="yes" frameborder="0" style="display:none;"></iframe>
    </div>
    <?php	
				#*********************************************** Tags ********************************************************	
?>
    <?php
				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];
				$counter++;
				$focusId = $focusId+2;
				$i++;
		}
	}
?>
    <div id="reply_teeme0" style="width:<?php echo $this->config->item('page_width')-100;?>px; padding-left:50px; float:left; margin-top:20px;"> <b><?php echo $this->lang->line('txt_Add_Reply');?>:</b><br>
      <br>
      <form name="form1" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $arrparent['treeIds'];?>">
        <input name="nodeId" type="hidden" value="<?php echo $arrparent['nodeId'];?>">
        <textarea name="replyDiscussion" id="replyDiscussion"></textarea>
        <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);" class="button01">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="Replybutton1" value="Cancel" onClick="setValueIntoEditor('replyDiscussion','');" class="button01">
        <input name="reply" type="hidden" id="reply" value="1">
        <input name="editorname1" type="hidden"  value="replyDiscussion">
        <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
        <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
      </form>
      <script language="javascript">chnage_textarea_to_editor('replyDiscussion');</script> 
    </div>
    <input type="hidden" id="totalNodes" value="<?php echo implode(',', $totalNodes);?>">
    <input type="hidden" id="allNodeIds" value="<?php echo implode(',', $arrTotalNodes);?>">
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
function reply(id, focusId, nodeId){
	whofocus=focusId;	
	frameIndex = focusId;
	
	var divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
	
	showdetail (id);
	chnage_textarea_to_editor('replyDiscussion'+nodeId);

	
}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}

function vksfun(id){
	var fId=id;
	rameid=fId;
}
function hidedetail(id){
	var image='img'+id;
	var added='add'+id;
	var details='detail'+id;
	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';
	document.getElementById(added).style.display='none';
	document.getElementById(details).style.display='none';
	
}

		// Parv - Keep Checking for tree updates every 5 second
		<!--Updated by Surbhi IV-->
		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);	
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);
		
		<!--End of Updated by Surbhi IV-->	
</script>