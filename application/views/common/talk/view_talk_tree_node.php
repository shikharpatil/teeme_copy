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
</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script> 
<!--webbot bot="HTMLMarkup" startspan --> 

<script language="JavaScript" src="<?php echo base_url();?>js/float_menu.js"></script>
<table width="<?php echo $this->config->item('page_width');?>" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#D9E3F2">
  <tr>
    <td valign="top"><table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="top"><!-- header -->
            
            <?php $this->load->view('common/header'); ?>
            
            <!-- header --></td>
        </tr>
        <tr>
          <td align="left" valign="top"><?php $this->load->view('common/wp_header'); ?></td>
        </tr>
        <tr>
          <td align="left" valign="top"><!-- Main menu -->
            
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
            
            <!-- Main menu --></td>
        </tr>
        <tr>
          <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" height="8" align="left" valign="top"></td>
                <td width="24%" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><!-- Main Body --> 
                  <span id="tagSpan"></span> 
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

	

</script></td>
              </tr>
              <tr>
                <td colspan="2" valign="top"><table width="100%">
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="rtabs">
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="current"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
                        </ul></td>
                    </tr>
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><hr></td>
                    </tr>
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><?php echo $treeDetails['name'];?></td>
                    </tr>
                    <tr>
                      <td colspan="4" align="left" valign="top"><table width="100%">
                          <tr>
                            <td align="left"><a href="<?php echo base_url();?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/empty-tri.gif" alt="Home" border="0"></a>
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
                              <a href="<?php echo base_url();?>view_discussion/Discussion_reply/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>
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
                              <a href="<?php echo base_url();?>view_discussion/Discussion_reply/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>
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
                              <a href="<?php echo base_url();?>view_discussion/Discussion_reply/<?php echo $_SESSION['nodes'][$i];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="text-decoration:none;"><img src="<?php echo base_url();?>images/fill-tri.gif" alt="<?php echo $i+1;?>" border="0"></a>
                              <?php	
					}	
				}
				?>
                              <input type="hidden" name="topLeftNav" id="topLeftNav" value="<?php echo ($nav-2);?>">
                              <input type="hidden" name="topRightNav" id="topRightNav" value="<?php echo $nav-1;?>">
                              <input type="hidden" name="totalNav" id="totalNav" value="<?php echo $nav-1;?>"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                    <tr>
                      <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><?php 
				$arrTotalNodes = array();
				$arrTotalNodes[] = $arrparent['nodeId'];
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrparent['userId']);
				$checkPre =$this->discussion_db_manager->checkPredecessor($arrparent['nodeId']);
				
		?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; ">
                          <tr>
                            <td width="26">&nbsp;</td>
                            <td><span id="img<?php echo $position;?>">
                              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td onClick="showdetail(<?php echo $position;?>);" class="handCursor"><span class="style1">
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
                                    </span>
                                    <?php
echo stripslashes($arrparent['contents']);?></td>
                                </tr>
                              </table>
                              <div id="reply_teeme0" style="display:none;  margin-top:0px; margin-left:20px;">
                                <p onMouseOver="vksfun(0);">
                                <form name="form1" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $arrparent['treeIds'];?>">
                                  <input name="nodeId" type="hidden" value="<?php echo $arrparent['nodeId'];?>">
                                  <textarea name="replyDiscussion" id="replyDiscussion"></textarea>
                                  &nbsp;&nbsp;&nbsp; <script language="javascript">
	chnage_textarea_to_editor('replyDiscussion');
		<!--document.write( '<div><iframe id="replyDiscussion" name="replyDiscussion" src="'+baseURL+'/editor/TeemeEditor.php?textAreaName=replyDiscussion&id=0&idea=1" width="90%" height="90%" frameborder="0" scrolling="no" style="border:solid; border-color:#C4C6D0;" ></iframe></div><input name="replyDiscussion" id="replyDiscussion1" value="<DIV id=1-span><P>&nbsp;</P></DIV>" type="hidden" />');-->
	</script> 
                                  <!--textarea name="replyDiscussion" cols="54" rows="5" id="replyDiscussion"></textarea-->
                                  <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion',document.form1);">
                                  &nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(0);">
                                  <input name="reply" type="hidden" id="reply" value="1">
                                  <input name="editorname1" type="hidden"  value="replyDiscussion">
                                  <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
                                  <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
                                </form>
                                </p>
                              </div>
                              <span id="normalView<?php echo $arrparent['nodeId'];?>">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:none;">
                                <tr>
                                  <td align="left" colspan="2"><span class="style1" id="add<?php echo $position;?>" style="display:none;">
                                    <?php
echo '<span class="style1">'.$this->lang->line('txt_Originator').': '.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';
?>
                                    </span></td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="2"><a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrparent['nodeId'];?>',<?php echo $arrparent['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp; <a href="javascript:reply(0,0);"><?php echo $this->lang->line('txt_Reply');?></a> <a href="javascript:void(0);" onClick="showTagView('<?php echo $arrparent['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp; <a href="javascript:void(0);" onClick="window.location.reload();"><?php echo $this->lang->line('txt_Update_Tree');?></a></td>
                                </tr>
                              </table>
                              </span>
                              <?php
				#********************************************* Tags ********************************************************88
				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrparent['nodeId'], 2);
				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrparent['nodeId'], 2);
				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrparent['nodeId'], 2);
				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrparent['nodeId'], 2);
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
                              <span id="spanArtifactLinks<?php echo $arrparent['nodeId'];?>" style="display:none;"> </span> <span id="spanTagView<?php echo $arrparent['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrparent['nodeId'];?>">
                              <table width="100%">
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
						$dispContactTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
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
							$dispResponseTags .= '<a href="javascript:void(0);" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						}
						$dispResponseTags .= '<a href="javascript:void(0);" onClick="showNewTag('.$arrparent['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrparent['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				if($dispViewTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';
					$nodeTagStatus = 1;		
					?></td>
                                </tr>
                                <?php				
				}		
				if($dispResponseTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					
					$nodeTagStatus = 1;
					?></td>
                                </tr>
                                <?php	
				}		
				if($dispContactTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					
					$nodeTagStatus = 1;	
					?></td>
                                </tr>
                                <?php	
				}		
				if($dispUserTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?></td>
                                </tr>
                                <?php		
				}	
							
				if($nodeTagStatus == 0)	
				{
				?>
                                <tr>
                                <tr>
                                  <td><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td>
                                </tr>
                                <?php
				}
				?>
                                <tr>
                                  <td align="right" class="border_dotted">&nbsp;</td>
                                </tr>
                              </table>
                              </span>
                              <iframe id="iframeId<?php echo $arrparent['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>
                              <ul class="rtabs">
                                <li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrparent['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrparent['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>
                                <span id="spanTagNew<?php echo $arrparent['nodeId'];?>">
                                <li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrparent['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrparent['nodeId']; ?>,2,0,1,0)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li>
                                </span>
                              </ul>
                              <hr color="#666666">
                              </span>
                              <?php	
				#*********************************************** Tags ********************************************************	
	?></td>
                            <td width="25">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"></td>
                          </tr>
                          <tr>
                            <td colspan="3"><hr></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php 
	$focusId = 2;
	$totalNodes = array();
	if($arrparent['successors'])
	{		
	
			$arrChildNodes = $this->discussion_db_manager->getChildNodes($arrparent['nodeId'], $arrparent['treeIds']);	
			$sArray = array();

			$sArray = $arrChildNodes;
			
			while($counter < count($sArray)){
				$arrDiscussions=$this->discussion_db_manager->getPerentInfo($sArray[$counter]);
				$position++;
				$totalNodes[] = $position;
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc =$this->discussion_db_manager->checkSuccessors($arrDiscussions['nodeId']);
				
				
				?>
                    <tr>
                      <td width="5%" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                      <td colspan="4" width="95%" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="26">&nbsp;</td>
                            <td><span id="latestcontent<?php echo $arrDiscussions['leafId'];?>">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td id="editcontent<?php echo $position;?>" onClick="showdetail(<?php echo $position;?>);" class="handCursor"><span id="img<?php echo $position;?>"> <span id="new<?php echo $position;?>" class="style1" style="text-decoration:blink; color:#FF0000;">
                                    <?php //if(!$viewCheck){ echo '<blink>'.$this->lang->line('txt_New').'</blink>';	}?>
                                    </span>
                                    <?php if($checksucc){
	echo '<a href="'.base_url().'view_discussion/Discussion_reply/'.$arrDiscussions['nodeId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'"><img src="'.base_url().'images/right.gif" alt="Up" vspace="0" border="0" /></a>&nbsp;&nbsp;';
	}?>
                                    &nbsp;&nbsp;
                                    <?php																
 echo stripslashes($arrDiscussions['contents']);?></td>
                                </tr>
                              </table>
                              </span>
                              <div id="reply_teeme<?php echo $position;?>" style="display:none;  margin-top:0px; margin-left:20px;">
                                <p onMouseOver="vksfun(<?php echo $position;?>);">
                                <form name="form12<?php echo $position;?>" method="post" action="<?php echo base_url();?>new_discussion/index/<?php echo $arrparent['treeIds'];?>">
                                  <input name="nodeId" type="hidden" value="<?php echo $arrDiscussions['nodeId'];?>">
                                  &nbsp;&nbsp;&nbsp;
                                  <textarea name="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>" id="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>"></textarea>
                                  <script language="javascript">
			chnage_textarea_to_editor('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>');
			</script>
                                  <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion<?php echo $arrDiscussions['nodeId'];?>',document.form12<?php echo $position;?>);">
                                  &nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="button" name="Replybutton1" value="Cancel" onClick="reply_close(<?php echo $position;?>);">
                                  <input name="reply" type="hidden" id="reply" value="1">
                                  <input name="editorname1" type="hidden"  value="replyDiscussion<?php echo $arrDiscussions['nodeId'];?>">
                                  <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
                                  <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
                                </form>
                                </p>
                              </div>
                              <span id="normalView<?php echo $arrDiscussions['nodeId'];?>">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $position;?>" style="display:none;">
                                <tr>
                                  <td width="90%" align="left" colspan="2"><span class="style1" id="add<?php echo $position;?>" style="display:none;">
                                    <?php  
echo '<span class="style1">'.$this->lang->line('txt_Originator').': '.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;';


?>
                                    </span></td>
                                  <td align="right" style="padding-right:10px;"></td>
                                </tr>
                                <tr>
                                  <td width="90%" align="left" colspan="2"><a href="javascript:void(0)" onClick="showArtifactLinks('<?php echo $arrDiscussions['nodeId'];?>',<?php echo $arrDiscussions['nodeId'];?>,2,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,2)"><?php echo $this->lang->line('txt_Links');?></a>&nbsp;&nbsp; <a href="javascript:void(0);" onClick="showTagView('<?php echo $arrDiscussions['nodeId'];?>')"><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;&nbsp; <a href="javascript:reply(<?php echo $position;?>,<?php echo $focusId;?>);"><?php echo $this->lang->line('txt_Reply');?></a>&nbsp;&nbsp; </td>
                                  <td align="right" style="padding-right:10px;"></td>
                                </tr>
                              </table>
                              </span>
                              <?php
				#********************************************* Tags ********************************************************88
				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrDiscussions['nodeId'], 2);
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
                              <span id="spanArtifactLinks<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrDiscussions['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrDiscussions['nodeId'];?>">
                              <table width="100%">
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
						$dispContactTags .= '<a href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
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
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrDiscussions['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrDiscussions['nodeId'].',2,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				if($dispViewTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Simple_Tags').': '.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'<br>';
					$nodeTagStatus = 1;		
					?></td>
                                </tr>
                                <?php				
				}		
				if($dispResponseTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Response_Tags').': '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';					
					$nodeTagStatus = 1;
					?></td>
                                </tr>
                                <?php	
				}		
				if($dispContactTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_Contact_Tags').': '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'<br>';					
					$nodeTagStatus = 1;	
					?></td>
                                </tr>
                                <?php	
				}		
				if($dispUserTags != '')		
				{
					?>
                                <tr>
                                <tr>
                                  <td><?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?></td>
                                </tr>
                                <?php		
				}	
							
				if($nodeTagStatus == 0)	
				{
				?>
                                <tr>
                                <tr>
                                  <td><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></td>
                                </tr>
                                <?php
				}
				?>
                                <tr>
                                  <td align="right"></td>
                                </tr>
                                <tr>
                                  <td align="right" class="border_dotted">&nbsp;</td>
                                </tr>
                              </table>
                              </span>
                              <iframe id="iframeId<?php echo $arrDiscussions['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>
                              <ul class="rtabs">
                                <li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrDiscussions['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrDiscussions['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>
                                <span id="spanTagNew<?php echo $arrDiscussions['nodeId'];?>">
                                <li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrDiscussions['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrDiscussions['nodeId']; ?>,2,0,1,0)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li>
                                </span>
                              </ul>
                              <hr color="#666666">
                              </span>
                              <?php	
				#*********************************************** Tags ********************************************************	
?></td>
                            <td width="25">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><hr></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php
				$arrTotalNodes[] = 	$arrDiscussions['nodeId'];
				$counter++;
				$focusId = $focusId+2;	
			}
		
	}
	else
	{
	?>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF" colspan="5"><span class="infoMsg"><?php echo $this->lang->line('msg_activities_not_available');?></span></td>
                    </tr>
                    <?php
	}	
	
?>
                  </table>
                  <input type="hidden" id="totalNodes" value="<?php echo implode(',', $totalNodes);?>">
                  <input type="hidden" id="allNodeIds" value="<?php echo implode(',', $arrTotalNodes);?>">
                  <script>
function reply(id, focusId){
	whofocus=focusId;	
	frameIndex = focusId;
	var divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';
 	
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
function showdetail(id)
{	

	var curNode='detail'+id;		
	var added='add'+id;
	var allNodes = document.getElementById('totalNodes').value;
	var arrNodes = new Array();
	arrNodes = allNodes.split(',');
	var allNodeIds = document.getElementById('allNodeIds').value;
	var arrNodeIds = new Array();
	arrNodeIds = allNodeIds.split(',');
	var nodeId 		= 'detail0';	
	var curAddId 	= 'add0'; 	
	document.getElementById(nodeId).style.display='none';	
	document.getElementById(curAddId).style.display='none';

	for(var i = 0;i<arrNodes.length;i++)
	{		
		var nodeId = 'detail'+arrNodes[i];	
		var curAddId = 'add'+arrNodes[i];		
		var artLinks = 'spanArtifactLinks'+arrNodes[i]; 
		if(id != arrNodes[i])
		{			
			document.getElementById(nodeId).style.display='none';	
			document.getElementById(curAddId).style.display='none';	
	
		}
	} 


	if(document.getElementById(curNode).style.display=='')		
	{
		document.getElementById(curNode).style.display='none';
		document.getElementById(added).style.display='none';	
	}
	else
	{
		document.getElementById(curNode).style.display='';
		document.getElementById(added).style.display='';
	}
}

</script> 
                  <!-- Main Body --></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td align="center" valign="top" class="copy"><!-- Footer -->
            
            <?php $this->load->view('common/footer');?>
            
            <!-- Footer --></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
