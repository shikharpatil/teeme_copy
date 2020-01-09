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
	<script language="JavaScript1.2">mmLoadMenus();</script>
	</head>
	<body>
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
$arrNodeIds = $this->identity_db_manager->getNodesByDateTimeView($treeId, $searchDate1, $searchDate2);	
$arrDetails['arrNodeIds'] = $arrNodeIds;
?>
                    <form name="frmCal" action="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">
                    <table width="100%">
                        <tr>
                        <td colspan="4" align="left" valign="top" class="tdSpace"><ul class="navigation">
                            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Discussion_View');?></span></a></li>
                            <li><a href="<?php echo base_url()?>view_discussion/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" class="current"><span><?php echo $this->lang->line('txt_Time_View');?></span></a></li>
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
                          </ul></td>
                      </tr>
                        <tr>
                        <td colspan="4" align="left" valign="top" class="tdSpace"><?php
			if($this->input->post('Go') != '' )
			{
			?>
                            <select name="searchDate" onChange="getTimingsCal(this)">
                            <option value="0" <?php if($this->input->post('searchDate') == 0) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select'); ?></option>
                            <option value="1" <?php if($this->input->post('searchDate') == 1 || $this->input->post('fromDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Today'); ?></option>
                            <option value="2" <?php if($this->input->post('searchDate') == 2) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Week'); ?></option>
                            <option value="3" <?php if($this->input->post('searchDate') == 3) { echo 'selected'; } ?>><?php echo $this->lang->line('last_week'); ?></option>
                            <option value="4" <?php if($this->input->post('searchDate') == 4) { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Month'); ?></option>
                            <option value="5" <?php if($this->input->post('searchDate') == 5) { echo 'selected'; } ?>><?php echo $this->lang->line('last_month'); ?></option>
                          </select>
                            <?php 
				if($this->input->post('searchDate') == 0 )
				{
				?>
                            &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
                            <input type="text" name="fromDate" size="10" value="<?php if($this->input->post('fromDate') != '') { echo $this->input->post('fromDate'); } ?>"
	readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
                            <input type="text" name="toDate" size="10" value="<?php if($this->input->post('toDate') != '') { echo $this->input->post('toDate'); } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'> &nbsp;&nbsp;
                            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                            <?php
				}
				else
				{
				?>
                            &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
                            <input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
                            <input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'> &nbsp;&nbsp;
                            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                            <?php
				}
				?>
                            <?php
			 }
			 else
			 {
			 ?>
                            <select name="searchDate" onChange="getTimingsCal(this)">
                            <option value="0"><?php echo $this->lang->line('txt_Select'); ?></option>
                            <option value="1"><?php echo $this->lang->line('txt_Today'); ?></option>
                            <option value="2"><?php echo $this->lang->line('txt_This_Week'); ?></option>
                            <option value="3"><?php echo $this->lang->line('last_week'); ?></option>
                            <option value="4"><?php echo $this->lang->line('txt_This_Month'); ?></option>
                            <option value="5"><?php echo $this->lang->line('last_month'); ?></option>
                          </select>
                            &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
                            <input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
                            <input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'> &nbsp;&nbsp;
                            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                            <?php
			 }
			 ?></td>
                      </tr>
                      </table>
                  </form>
                    <table width="100%" border="0" cellpadding="1" >
                    <tr>
                        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr class="seedBgColor seedHeading">
                            <td width="2%" >&nbsp;</td>
                            <td width="98%" align="left" ><?php echo $this->identity_db_manager->formatContent($arrDiscussionDetails['name'],250);?></td>
                          </tr>
                          </table></td>
                      </tr>
                    <?php	
	$totalNodes = array();
	
	//if(count($discussionDetails) > 0)
	if (1)
	{		
		 
		foreach($discussionDetails as $keyVal=>$arrVal)
		{	 
		
			$userDetails1	= 	$this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			$nodeBgColor = '';
			if(in_array($arrVal['nodeId'], $arrNodeIds))
			{				
				$nodeBgColor = 'nodeBgColorSelect';			
				$totalNodes[] = $arrVal['nodeId'];					
			}
			
	?>
                    <tr>
                        <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><?php
			if (!empty($nodeBgColor))
			{
			?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo $nodeBgColor;?>">
                            <tr>
                            <td width="100%"><?php 
		if ($arrVal['predecessor'] == 0)
			echo '<a style="text-decoration:none; color:#000;" href='.base_url().'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';
		else
			echo '<a style="text-decoration:none; color:#000;" href='.base_url().'view_discussion/Discussion_Reply/'.$arrVal["predecessor"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],250).'</a>';
		
				$lastnode	= $arrVal['nodeId'];
				?></td>
                          </tr>
                          </table>
                        <?php
			}
			?>
                        <div style="padding-left:20px;">
                            <?php
		
			$arrparent=  $this->discussion_db_manager->getPerentInfo($arrVal['nodeId']);
		
		if($arrparent['successors'])
		{
			$sArray=array();
			$sArray=explode(',',$arrparent['successors']);
			$counter=0;
			while($counter < count($sArray))
			{
				$arrDiscussions	= $this->discussion_db_manager->getPerentInfo($sArray[$counter]);		
				$totalNodes[] = $arrDiscussions['nodeId'];	 
				$userDetails	= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
				$checksucc 		= $this->discussion_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
			
				$nodeBgColor = '';
				if(in_array($arrDiscussions['nodeId'], $arrNodeIds))
				{				
					$nodeBgColor = 'nodeBgColorSelect';			
					$totalNodes[] = $arrDiscussions['nodeId'];					
				}				

				?>
                            
                            <tr>
                                <td colspan="5" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                                    <?php
			if (!empty($nodeBgColor))
			{
			?>
                                    <tr class="<?php echo $nodeBgColor; ?>">
                                    <td width="5%" >&nbsp;</td>
                                    <td width="95%" id="<?php echo $position++;?>" class="handCursor"><?php
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

					?>
                                        <?php 
					
					echo '<a href='.base_url().'view_discussion/Discussion_reply/'.$arrVal["nodeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$arrDiscussions["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussions['contents'],250).'</a>';
					
					?>
                                        <br></td>
                                  </tr>
                                    <?php
			}
			?>
                                  </table></td>
                              </tr>
                            <?php
				$counter++;
			}			
		}		
		?>
                        </div></td>
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
                  </table>
                    
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
