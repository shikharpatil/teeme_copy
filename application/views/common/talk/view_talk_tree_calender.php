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
	<script language="javascript">
	function hidedetail(id){
	var image='img'+id;

	var details='detail'+id;
	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(details).style.display='none';
	
}
function showdetail(id){
	

	var curNode='detail'+id;

	var allNodes = document.getElementById('totalNodes').value;
	var arrNodes = new Array();
	arrNodes = allNodes.split(',');
	for(var i = 0;i<arrNodes.length;i++)
	{		
		var nodeId = 'detail'+arrNodes[i];		
		if(id != arrNodes[i])
		{			
			document.getElementById(nodeId).style.display='none';	
		}
	} 
	if(document.getElementById(curNode).style.display=='')		
	{
		document.getElementById(curNode).style.display='none';
	}
	else
	{
		document.getElementById(curNode).style.display='';
	}
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
                  
                  <?php
$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
if($this->input->post('searchDate') == 0)
{	
	if($this->input->post('fromDate') != '')
	{
		$searchDate1	= $this->input->post('fromDate');
		$searchDate2	= $this->input->post('toDate');
	}
}
if($this->input->post('searchDate') == 1)
{
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
}	
if($this->input->post('searchDate') == 2)
{		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));
}	
if($this->input->post('searchDate') == 3)
{		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1)-7,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N'))-7,date('Y')));
}
if($this->input->post('searchDate') == 4)
{
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y')));
}
if($this->input->post('searchDate') == 5)
{
	$lastDayOfMonth = date('t',mktime(0,0,0,date('m')-1,1,date('Y')));
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m')-1,$lastDayOfMonth,date('Y')));
}
$arrNodeIds = $this->identity_db_manager->getNodesByDate($treeId, $searchDate1, $searchDate2);	
$arrDetails['arrNodeIds'] = $arrNodeIds;
?>
                  <form name="frmCal" action="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">
                    <table width="100%">
                      <tr>
                        <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="rtabs">
                            <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Normal_View');?></span></a></li>
                            <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" class="current"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
                            <li><a href="<?php echo base_url()?>view_talk_tree/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3"><span><?php echo $this->lang->line('txt_Tag_View');?></span></a></li>
                          </ul></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="left" valign="top" class="tdSpace"><select name="searchDate" onChange="getTimingsCal(this)">
                            <option value="0" <?php if($this->input->post('searchDate') == 0) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select'); ?></option>
                            <option value="1" <?php if($this->input->post('searchDate') == 1 || $this->input->post('fromDate') == '') { echo 'selected'; } ?>><?php $this->lang->line('txt_Today'); ?></option>
                            <option value="2" <?php if($this->input->post('searchDate') == 2) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Week'); ?></option>
                            <option value="3" <?php if($this->input->post('searchDate') == 3) { echo 'selected'; } ?>><?php echo $this->lang->line('last_week'); ?></option>
                            <option value="4" <?php if($this->input->post('searchDate') == 4) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Month'); ?></option>
                            <option value="5" <?php if($this->input->post('searchDate') == 5) { echo 'selected'; } ?>><?php echo $this->lang->line('last_month'); ?></option>
                          </select>
                          &nbsp;&nbsp;<?php echo $this->lang->line('txt_On');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
                          <input type="text" name="fromDate" size="10" value="<?php if($this->input->post('fromDate') != '') { echo $this->input->post('fromDate'); } ?>"
	readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                          <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
                          <input type="text" name="toDate" size="10" value="<?php if($this->input->post('toDate') != '') { echo $this->input->post('toDate'); } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                          <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'> &nbsp;&nbsp;
                          <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="bg-light-blue"></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="left" valign="top" class="tdSpace"><hr></td>
                      </tr>
                    </table>
                  </form>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                    <tr>
                      <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-left:0px; position:relative;">
                          <tr>
                            <td height="21" >&nbsp;</td>
                            <td height="21" align="left" ><?php echo $arrDiscussionDetails['name'];?></td>
                            <td height="21" >&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><hr></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php	
	$totalNodes = array();
	if(count($discussionDetails) > 0)
	{					 
		foreach($discussionDetails as $keyVal=>$arrVal)
		{	 
			$userDetails1	= 	$this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			$nodeBgColor = 'nodeBgColor';
			if(in_array($arrVal['nodeId'], $arrNodeIds))
			{				
				$nodeBgColor = 'nodeBgColorSelect';			
				$totalNodes[] = $arrVal['nodeId'];					
			}
			else
			{
				continue;
			}	
					
?>
                    <tr>
                      <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="26">&nbsp;</td>
                            <td width="90%"><table width="100%">
                                <tr>
                                  <td class="<?php echo $nodeBgColor;?>" onClick="showdetail(<?php echo $arrVal['nodeId'];?>);"><?php echo stripslashes($arrVal['contents']);
				$lastnode	= $arrVal['nodeId'];
				?></td>
                                </tr>
                              </table>
                              <?php
				#********************************************* Tags ********************************************************88
				$viewTags 		= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$actTags 		= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$contactTags	= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$userTags		= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);
				$dispViewTags 	= '';
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
                                  <td align="left" colspan="2"><span class="style1"> <?php echo $userDetails1['userTagName'];?>&nbsp;&nbsp;&nbsp;&nbsp; </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="2"><?php
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
 
?>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF"><input type="hidden" id="totalNodes" name="totalNodes" value="<?php echo implode(',', $totalNodes);?>"></td>
                      <td align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF"></td>
                      <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                      <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                  </table>
                  
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
