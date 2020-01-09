<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Contact ><?php echo strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname'],'<b><em><span><img>');?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head');?>
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
	<script>
	$(document).ready(function(){
		//Manoj: showing mobile datepicker when add action tag 
		$("#dtBoxSearch").DateTimePicker({
			dateFormat: "yyyy-MM-dd"
		});
		
		
		$("#from_date").focus(function() {
			document.frmCal.searchDate.value = 0;
		});
		
		$("#to_date").focus(function() {
			document.frmCal.searchDate.value = 0;
		});
		
	});
	</script>
	</head>
	<body>
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile">
      <div id="content"> 
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
			?>
    <!-- Main menu --> 
    
    <!-- Main Body -->
    <?php $nodeOrder = 1;

if($this->input->post('searchDate') != '')
{
	$_SESSION['contactSearchDate'] = $this->input->post('searchDate');
	if($this->input->post('searchDate') == 0)
	{	
		if($this->input->post('fromDate') != '')
		{
			$searchDate1	= $this->input->post('fromDate');
			
			$_SESSION['contactFromDate'] 	= $this->input->post('fromDate');
				
		}
		if($this->input->post('toDate') != '')
		{

			$searchDate2	= $this->input->post('toDate');	
			$_SESSION['contactToDate'] 		= $this->input->post('toDate');	
		}
	}
}
else if(isset($_SESSION['contactSearchDate']) && $_SESSION['contactSearchDate'] != '')
{
	$_SESSION['contactSearchDate'] = $_SESSION['contactSearchDate'];
	if($_SESSION['contactSearchDate'] == 0)
	{	
		if($_SESSION['contactFromDate'] != '')
		{
			$searchDate1	= $_SESSION['contactFromDate'];
							
		}
		if($_SESSION['contactToDate'] != '')
		{
			$searchDate2	= $_SESSION['contactToDate'];						
		}
	}
	
}
else
{
	
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$_SESSION['contactSearchDate'] 	= 1;
	$_SESSION['contactFromDate'] 	= '';
	$_SESSION['contactToDate'] 		= '';
	
	
}
if($_SESSION['contactSearchDate'] == 0)
{	
	if($_SESSION['contactFromDate'] != '')
	{
		$searchDate1	= $_SESSION['contactFromDate'];
		
	}
	if($_SESSION['contactToDate'] != '')
	{
		$searchDate2	= $_SESSION['contactToDate'];					
	}
}

if($_SESSION['contactSearchDate'] == 1)
{
	/*Changed by Surbhi IV */
	
	$searchDate1	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d')-1,date('Y')));
	$searchDate2	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d'),date('Y')));
	/*End of Changed by Surbhi IV */
}	
if($_SESSION['contactSearchDate'] == 2)
{		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));
}	
if($_SESSION['contactSearchDate'] == 3)
{		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1)-7,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N'))-7,date('Y')));
}
if($_SESSION['contactSearchDate'] == 4)
{
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y')));

}
if($_SESSION['contactSearchDate'] == 5)
{
	$lastDayOfMonth = date('t',mktime(0,0,0,date('m')-1,1,date('Y')));
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m')-1,$lastDayOfMonth,date('Y')));	 
}

	$arrNodeIds = array();
	
	if ($searchDate1!='' || $searchDate2!='')
	{
		$arrNodeIds = $this->identity_db_manager->getNodesByDateTimeView($treeId, $searchDate1, $searchDate2);
	}

	$arrDetails['arrNodeIds'] = $arrNodeIds;
?>
    <div class="menu_new" >
	
		<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait">
			
		<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</ul>
        <!--follow and sync icon code end -->
		
          <ul class="tab_menu_new_for_mobile">
        <li class="contact-view"><a  href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Contact_View');?>" ></a></li>
        <li class="time-view_sel"><a class="active " href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
        <li class="tag-view" ><a  href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <li class="talk-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>"  ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
				<div class="tab_for_landscape">
			<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>	
			</div>	
      </ul>
          <div class="clr"></div>
        </div>
    <form name="frmCal" action="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">
          <table width="100%">
        <tr>
              <td colspan="4" align="left" valign="top" class="tdSpace"><?php
			if($this->input->post('Go') != '' )
			{
			?>
            <select name="searchDate" onChange="getTimingsCal(this)">
                  <option value="0" <?php if($_SESSION['contactSearchDate'] == 0) { echo 'selected'; } ?>>--select--</option>
                  <option value="1" <?php if($_SESSION['contactSearchDate'] == 1 || $_SESSION['contactFromDate'] == '') { echo 'selected'; } ?>>Today</option>
                  <option value="2" <?php if($_SESSION['contactSearchDate'] == 2) { echo 'selected'; } ?>>This Week</option>
                  <option value="3" <?php if($_SESSION['contactSearchDate'] == 3) { echo 'selected'; } ?>>Last Week</option>
                  <option value="4" <?php if($_SESSION['contactSearchDate'] == 4) { echo 'selected'; } ?>>This Month</option>
                  <option value="5" <?php if($_SESSION['contactSearchDate'] == 5) { echo 'selected'; } ?>>Last Month</option>
                </select>
            <?php 
				if($this->input->post('searchDate') == 0 )
				{
				?>
            &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<br /><?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
           <?php /*?> <input type="text" name="fromDate" size="10" value="<?php if($_SESSION['contactFromDate'] != '') { echo $_SESSION['contactFromDate']; } ?>"
	readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			<!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date" value="<?php if($_SESSION['contactFromDate'] != '') { echo $_SESSION['contactFromDate']; } ?>"  readonly>  
					<div id="dtBoxSearch"></div>
			<!--Manoj:end--><br />
			 <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php /*?> <input type="text" name="toDate" size="10" value="<?php if($_SESSION['contactToDate'] != '') { echo $_SESSION['contactToDate']; } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?> 
			 <!--Manoj:Added to date input field-->
				   <input name="toDate" type="text" size="10" data-field="date" id="to_date" value="<?php if($_SESSION['contactToDate'] != '') { echo $_SESSION['contactToDate']; } ?>" readonly> 
			<!--Manoj: code end-->
			&nbsp;&nbsp;<br />
            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
            <?php
				}
				else
				{
				?>
            &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<br /><?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
           <?php /*?> <input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			<!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date"  readonly>  <br />
					<div id="dtBoxSearch"></div>
			<!--Manoj:end-->
			 <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
			 <!--Manoj:Added to date input field-->
				   <input name="toDate" type="text" size="10" data-field="date" id="to_date"  readonly> 
			<!--Manoj: code end-->
			 &nbsp;&nbsp;<br />
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
                  <option value="0">--select--</option>
                  <option value="1" selected="selected">Today</option>
                  <option value="2">This Week</option>
                  <option value="3">Last Week</option>
                  <option value="4">This Month</option>
                  <option value="5">Last Month</option>
                </select>
            &nbsp;&nbsp;<span><?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;</span><br />
			<div style="margin-top:4%;">
			<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
            <?php /*?><input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
			<!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date"  readonly>  
					<div id="dtBoxSearch"></div>
					</div>
			<!--Manoj:end-->
			<div style="margin-top:4%;">
			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
            <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?> 
			
			 <input name="toDate" type="text" size="10" data-field="date" id="to_date"  readonly> 
				   </div>
			<div style="margin:4% 0%;">
            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
			</div>
            <?php
			 }
			 ?></td>
            </tr>
      </table>
        </form>
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="seedBgColor">
          <tr>
        <td align="left" class="seedHeading handCursor"><?php echo '<a style="text-decoration:none; color:#000;" href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'>'.$Contactdetail['firstname'].' '.$Contactdetail['lastname'].'</a>'; ?></td>
      </tr>
        </table>
    <?php 
$focusId = 3;
$totalNodes = array();
if(count($ContactNotes) > 0)
{ 
?>
    <table width="100%" border="0" cellspacing="3" cellpadding="3" style="border-spacing:0px 12px;">
          <?php  
  $count=0;
$i=0;
foreach($ContactNotes as $keyVal=>$arrVal)
{	
	if(in_array($arrVal['nodeId'],$arrNodeIds))
	{
		$nodeBgColor = ($i%2)?'row1':"row2";
	}		
						 
	$userDetails1	= 	$this->contact_list->getUserDetailsByUserId($arrVal['userId']);		
	$nodeOrder++;
	
	$totalNodes[] 			= $arrVal['nodeId'];
	
			$nodeBgColor = '';
			if(in_array($arrVal['nodeId'],$arrNodeIds))
			{
				$nodeBgColor = 'nodeBgColorSelect';
			}	
			if (!empty($nodeBgColor))
			{	
?>
          <tr>
        <td class="<?php //echo $nodeBgColor;?> treeLeafView"><?php
			/*$this->identity_db_manager->formatContent($arrVal['contents'],250)*/
			echo '<a style="text-decoration:none; color:#000; width:100%;" href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'#contactLeafContent'.$arrVal["nodeId"].' >'.stripslashes(substr($arrVal['contents'],0,250)).'</a>';
			
			$lastnode=$arrVal['nodeId'];
			$i++;
			
			?>
			<div class="userLabelNoFloat flLt" style="margin-top:0px; float:right;"><?php echo  $userDetails1['userTagName']."&nbsp;"; ?><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
		<div class="clr"></div>
			<?php
			?></td>
      </tr>
          <?php  
  			}
	$focusId = $focusId+2;	
	$position++;
	    
  }  
  ?>
        </table>
    <?php 		
}
?>
    <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
