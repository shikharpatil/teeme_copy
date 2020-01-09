<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
	</script>
<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>
<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script>
<script Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>
<script>
function hidedetail(id){
	var image='img'+id;

	var details='detail'+id;
	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(details).style.display='none';
	
}
function showdetail(id){
	var image='img'+id;

	var details='detail'+id;
	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/minus.gif" onClick="hidedetail('+id+');">';

	document.getElementById(details).style.display='';
}
</script>
</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script> 
<!--webbot bot="HTMLMarkup" startspan -->
<p> 
  <script>
if (!document.layers)
{
	document.write('<div id="divStayTopLeft" style="position:absolute">')
}
</script> 
</p>
<layer id="divStayTopLeft"> 
<!-- Float Manu Bar -->
<?php //$this->load->view('common/float_menu_artifacts');?>
<!-- Float Menu Bar -->
</p>
</layer> 
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
                <td colspan="2" align="left" valign="top"><!-- Main Body -->
                  
                  <table width="100%">
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="rtabs">
                          <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
                          <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" class="current"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
                        </ul></td>
                    </tr>
                    <tr>
                      <td colspan="4" align="left" valign="top" class="tdSpace"><hr></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                    <tr>
                      <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">
                          <tr>
                            <td height="21" >&nbsp;</td>
                            <td height="21" align="left" ><strong><?php echo $this->lang->line('txt_Discussion_Title');?>: <?php echo $arrDiscussionDetails['name'];?></strong></td>
                            <td height="21" >&nbsp;</td>
                          </tr>
                        </table>
                        <?php
#************************************************* Tags ***************************************************************
?>
                        <table>
                          <?php 
	$arrdispTags = array();
	$arrNodeIds 	= $this->tag_db_manager->getNodeIdsByTreeId($treeId);
	$treeTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1, $searchDate1, $searchDate2);
					
	$nodeIds		= implode(',', $arrNodeIds);		
	$leafTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($nodeIds, 2, $searchDate1, $searchDate2);	
											
	$simpleTags 	= array();
	$responseTags 	= array();
	$contactTags 	= array();
	$userTags		= array();	
	$tagStatus		= 0;		
	if(count($treeTags) > 0)
	{												
		foreach($treeTags as $key => $arrTagData)
		{
			foreach($arrTagData as $key1 => $tagData)
			{																														
				$tagLink	= $this->tag_db_manager->getLinkByTagIdTagView( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
				if(count($tagLink) > 0)
				{		
					if($key == 'simple')
					{													
						$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'response')
					{													
						$responseTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'contact')
					{													
						$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'user')
					{													
						$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}					
				}
			} 													
		}													
	}													
	if(count($leafTags) > 0)
	{												
		foreach($leafTags as $key => $arrTagData)
		{																	
			foreach($arrTagData as $key1 => $tagData)
			{																														
				$tagLink	= $this->tag_db_manager->getLinkByTagIdTagView( $tagData['tagId'], $tagData['artifactId'], $tagData['artifactType'] );	
				if(count($tagLink) > 0)
				{		
					if($key == 'simple')
					{													
						$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'response')
					{													
						$responseTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'contact')
					{													
						$contactTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}
					if($key == 'user')
					{													
						$userTags[] = '<a href="'.base_url().$tagLink[0].'" class="blue-link-underline">'.$tagData['comments'].'</a>'; 														
					}					
				}
			} 															
		}													
	}
	
if(count($simpleTags) > 0)		
{
?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Simple_Tags').': '.implode(', ', $simpleTags);?></td>
                          </tr>
                          <?php	
$tagStatus	= 1;			
}
if(count($responseTags) > 0)		
{
?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Response_Tags').': '.implode(', ', $responseTags);?></td>
                          </tr>
                          <?php	
$tagStatus	= 1;				
}
if(count($contactTags) > 0)		
{
?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_Contact_Tags').': '.implode(', ', $contactTags);?></td>
                          </tr>
                          <?php	
$tagStatus	= 1;				
}
if(count($userTags) > 0)		
{
?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_User_Tags').': '.implode(', ', $userTags);?></td>
                          </tr>
                          <?php	
$tagStatus	= 1;					
}
if($tagStatus == 0)		
{
?>
                          <tr>
                            <td><?php echo $this->lang->line('txt_None');?></td>
                          </tr>
                          <?php																
}		
?>
                        </table>
                        <?php
#************************************************** Tag ********************************************************88
?></td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" class="tdSpace" colspan="5"><hr></td>
                    </tr>
                    <?php
if($tagId > 0)
{	

	
	if(count($discussionDetails) > 0)
	{		 
		foreach($discussionDetails as $keyVal=>$arrVal)
		{	 
			$userDetails1	= 	$this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			$nodeBgColor = 'nodeBgColor';
			if($this->uri->segment(9) == $arrVal['nodeId'])
			{
				$nodeBgColor = 'nodeBgColorSelect';
			}
?>
                    <tr>
                      <td width="30" align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td width="29" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="26">&nbsp;</td>
                            <td><table width="100%">
                                <tr>
                                  <td class="<?php echo $nodeBgColor;?>"><span id="img<?php echo $arrVal['nodeId'];?>"><img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail(<?php echo $arrVal['nodeId'];?>);"></span> <?php echo stripslashes($arrVal['contents']);
				$lastnode	= $arrVal['nodeId'];
				?></td>
                                </tr>
                              </table>
                              <?php
				#********************************************* Tags ********************************************************88
				$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;		
				?>
                              <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"> </span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
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
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',3)">'.$this->lang->line('txt_View_Responses').'</a>';	
						
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
                                  <td align="right"><ul class="rtabs">
                                      <li><a href="javascript:void(0)" onClick="hideTagView(<?php echo $arrVal['nodeId'];?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['nodeId'];?>,2)"><span><?php echo $this->lang->line('txt_Done');?></span></a></li>
                                      <span id="spanTagNew<?php echo $arrVal['nodeId']; ?>">
                                      <li><a href="javascript:void(0)" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1)"><span><?php echo $this->lang->line('txt_Apply_tag');?></span></a></li>
                                      </span>
                                    </ul></td>
                                </tr>
                                <tr>
                                  <td align="right" class="border_dotted">&nbsp;</td>
                                </tr>
                              </table>
                              </span>
                              <iframe id="iframeId<?php echo $arrVal['nodeId'];?>" width="100%" height="400" scrolling="yes" frameborder="0" style="display:none;"></iframe>
                              <hr color="#666666">
                              </span>
                              <?php	
				#*********************************************** Tags ********************************************************																		

?>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail<?php echo $arrVal['nodeId'];?>" style="display:none;">
                                <tr>
                                  <td align="left" colspan="2"><span class="style1"><?php echo $userDetails1['userTagName'];?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="2"><?PHP 
	if($arrVal['predecessor'] > 0)
	{
		echo '<a href="'.base_url().'view_talk_tree/Discussion_reply/'.$arrVal['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Reply').'</a>';
		echo '<a href="'.base_url().'view_talk_tree/Discussion_reply/'.$arrVal['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Tags').'</a>';
		echo '<a href="'.base_url().'view_talk_tree/Discussion_reply/'.$arrVal['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Links').'</a>';
	}
	else
	{
		echo '<a href="'.base_url().'view_talk_tree/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Reply').'</a>';
		echo '<a href="'.base_url().'view_talk_tree/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Tags').'</a>';
		echo '<a href="'.base_url().'view_talk_tree/node/'.$arrVal['treeIds'].'/'.$workSpaceId.'/type/'.$workSpaceType.'">'.$this->lang->line('txt_Links').'</a>';	
	}
	?></td>
                                </tr>
                              </table></td>
                            <td width="25">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><hr></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php
		
		}
	}
	
} 
?>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                  </table>
                  <script language="javascript">

</script> 
                  <!-- Main Body --> 
                  <!-- Right Part--> 
                  <!-- end Right Part --></td>
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
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>
