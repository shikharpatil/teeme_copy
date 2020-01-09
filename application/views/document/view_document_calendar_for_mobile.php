<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head');?>
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
	<script>
	$(document).ready(function(){
		//Manoj: showing mobile datepicker when add action tag 
		$("#dtBoxSearch").DateTimePicker({
			dateFormat: "yyyy-MM-dd"
		});
		
		//Change dropdown value when 'From or To' date selected 
		
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
    
    <div>
          <?php
if($this->input->post('searchDate') != '')
{
	$_SESSION['docSearchDate'] = $this->input->post('searchDate');
	
	if($this->input->post('searchDate') == 0)
	{	
		if($this->input->post('fromDate') != '')
		{
		
			$searchDate1	= $this->input->post('fromDate');
			
			$_SESSION['docFromDate'] 	= $this->input->post('fromDate');
			
			
		}
		if($this->input->post('toDate') != '')

		{					

			$searchDate2	= $this->input->post('toDate');

			$_SESSION['docToDate'] 		= $this->input->post('toDate');	
			
		}
	}
}
else if(isset($_SESSION['docSearchDate']) && $_SESSION['docSearchDate'] != '')
{

	if($_SESSION['docSearchDate'] == 0)
	{	
	
		if($_SESSION['docFromDate'] != '')
		{
		
			$searchDate1	= $_SESSION['docFromDate'];
						
		
		}
		
		if($_SESSION['docToDate'] != '')

		{

			$searchDate2	= $_SESSION['docToDate'];				

		}
	
	}

}
else
{

	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	
	$_SESSION['docSearchDate'] 	= 1;
	
	$_SESSION['docFromDate'] 	= '';
	
	$_SESSION['docToDate'] 		= '';

}

if($_SESSION['docSearchDate'] == 0)
{
	
	if($_SESSION['docFromDate'] != '')
	{
	
		$searchDate1	= $_SESSION['docFromDate'];
		$searchDate2	= $_SESSION['docToDate'];
	
	}

}

if($_SESSION['docSearchDate'] == 1)
{

	/*Changed by Surbhi IV */
	
	$searchDate1	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d')-1,date('Y')));
	
	$searchDate2	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d'),date('Y')));
    
	/*End of Changed by Surbhi IV */

}
	
if($_SESSION['docSearchDate'] == 2)
{
		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));

	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));

}	

if($_SESSION['docSearchDate'] == 3)
{		
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1)-7,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N'))-7,date('Y')));
}
if($_SESSION['docSearchDate'] == 4)
{
	$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
	$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y')));
}
if($_SESSION['docSearchDate'] == 5)
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

$treeMainVersion 	= $arrDocumentDetails['version'];
$leftVersionLink	= '';
$rightVersionLink	= '';	
			$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId);	
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
					
if($treeMainVersion != 1 && $arrDocumentDetails['parentTreeId'] > 0)
{	
	$leftVersionLink = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$arrDocumentDetails['parentTreeId'].'&doc" style="text-decoration:none"><img src="'.base_url().'images/left.gif" border="0"></a>';
}
if($arrDocumentDetails['latestVersion'] != 1)
{	
	$childTreeId = $this->document_db_manager->getChildTreeIdByTreeId( $treeId );													
	$rightVersionLink = '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$childTreeId.'&doc=exist" style="text-decoration:none"><img src="'.base_url().'images/right.gif" sborder="0"></a>';	
}
?>
          <form name="frmCal" action="<?php echo base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=2';?>" method="post" onSubmit="return validateCal()">
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
            <li class="document-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1"  title="<?php echo $this->lang->line('txt_Document_View');?>" ></a></li>
            <li class="time-view_sel"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=2" class="active" title="<?php echo $this->lang->line('txt_Time_View');?>" ><span></span></a></li>
            <li class="tag-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=3" title="<?php echo $this->lang->line('txt_Tag_View');?>" ><span></span></a></li>
            <li class="link-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=4" title="<?php echo $this->lang->line('txt_Link_View');?>" ><span></span></a></li>
            <li class="talk-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=7" title="<?php echo $this->lang->line('txt_Talk_View');?>"><span></span></a></li>
            <?php
					if (($workSpaceId==0))
					{
				?>
            <li class="share-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" ><span></span></a></li>
            <?php
					}
				?>
				<div class="tab_for_landscape">
            <li id="treeUpdate"></li>
			
			<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
			</div>
            <div class="clr"></div>
          </ul>
            </div>
        <table width="100%">
              <tr>
            <td colspan="4" align="left" valign="top" class="tdSpace"><?php
			if($this->input->post('Go') != '' )
			{
			?>
                  <select name="searchDate" onChange="getTimingsCal(this)">
                <option value="0" <?php if($_SESSION['docSearchDate'] == 0) { echo 'selected'; } ?>>--select--</option>
                <option value="1" <?php if($_SESSION['docSearchDate'] == 1 || $_SESSION['docFromDate'] == '') { echo 'selected'; } ?>>Today</option>
                <option value="2" <?php if($_SESSION['docSearchDate'] == 2) { echo 'selected'; } ?>>This Week</option>
                <option value="3" <?php if($_SESSION['docSearchDate'] == 3) { echo 'selected'; } ?>>Last Week</option>
                <option value="4" <?php if($_SESSION['docSearchDate'] == 4) { echo 'selected'; } ?>>This Month</option>
                <option value="5" <?php if($_SESSION['docSearchDate'] == 5) { echo 'selected'; } ?>>Last Month</option>
              </select>
                  <?php 
				if($this->input->post('searchDate') == 0 )
				{
				?>
                  <span> &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?></span><br /><span> <?php echo $this->lang->line('txt_From_Date');?>:&nbsp;</span>
                  <?php /*?><input type="text" name="fromDate" size="10" value="<?php if($_SESSION['docFromDate'] != '') { echo $_SESSION['docFromDate']; } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><span>&nbsp;&nbsp;<?php */?>  &nbsp;</span>
				  
				  <!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date" value="<?php if($_SESSION['docFromDate'] != '') { echo $_SESSION['docFromDate']; } ?>"  readonly>  
					<div id="dtBoxSearch"></div>
					<!--Manoj:end-->
				  &nbsp;&nbsp;

			<br />
			<?php echo $this->lang->line('txt_To_Date');?>:
                  <?php /*?><input type="text" name="toDate" size="10" value="<?php if($_SESSION['docToDate'] != '') { echo $_SESSION['docToDate']; } ?>" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
				   <!--Manoj:Added to date input field-->
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="toDate" type="text" size="10" data-field="date" id="to_date" value="<?php if($_SESSION['docToDate'] != '') { echo $_SESSION['docToDate']; } ?>" readonly> 
				   <!--Manoj: code end-->
				    &nbsp;&nbsp;
                  <?php
				}
				else
				{
				?>
                  <span> &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?></span><br /><span><?php echo $this->lang->line('txt_From_Date');?>:&nbsp;</span>
                 <?php /*?> <input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
				  
				  <!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date"  readonly>  
					<div id="dtBoxSearch"></div>
					<!--Manoj:end-->
				  
				  &nbsp;&nbsp;

			<br />
				  <span><?php echo $this->lang->line('txt_To_Date');?>: &nbsp;</span>
                  <?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?>
				   <!--Manoj:Added to date input field-->
				    &nbsp;&nbsp; &nbsp;<input name="toDate" type="text" size="10" data-field="date" id="to_date"  readonly>  &nbsp;&nbsp;
                 	<!--Manoj: code end-->
				  <?php
				}
				?><br />
                  <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
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
                  <span>&nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;</span><br />
				  <div style="margin-top:4%;">
              <?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
                  <?php /*?><input type="text" name="fromDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.fromDate, document.frmCal.fromDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.fromDate, "yyyy-mm-dd")' value='select'><?php */?>
				  
				  <!--Manoj:Added from date input field-->
					<input name="fromDate" type="text" size="10" data-field="date" id="from_date"  readonly>  
					<div id="dtBoxSearch"></div>
					</div>
					<!--Manoj:end-->
				  
				  <span>&nbsp;&nbsp; <br />
				  <div>
              <?php echo $this->lang->line('txt_To_Date');?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                  <?php /*?><input type="text" name="toDate" size="10" readonly onClick='changeDropCal(),popUpCalendar(document.frmCal.toDate, document.frmCal.toDate, "yyyy-mm-dd")'>
                  <img style="cursor:hand" src="<?php echo base_url();?>images/cal.gif" onclick='changeDropCal(),popUpCalendar(this, document.frmCal.toDate, "yyyy-mm-dd")' value='select'><?php */?> 
				  <!--Manoj:Added from date input field-->
				  <input name="toDate" type="text" size="10" data-field="date" id="to_date"  readonly> 
				  <!--Manoj: code end-->
				  </div>
				  &nbsp;&nbsp;&nbsp;&nbsp;
				  <br />
				  
                  <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                  <?php
			 }
			 ?></td>
          </tr>
            </table>
        <?php	
			$seedBgColor = 'seedBgColor';
			if($this->input->get('node') != '' && $this->input->get('node') == '')
			{
				$seedBgColor = 'seedBgColorSelect';
			}
			?>
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
              <tr class="<?php echo $seedBgColor;?>">
            <td align="left" valign="top" class="handCursor" ><?php
					echo '<a href=view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId.' style="text-decoration:none; color:#000;">'.$arrDocumentDetails['name'].'</a>'; 
				?></td>
          </tr>
            </table>
      </form>
        </div>
    <div>
          <?php
$this->load->helper('form'); 
$attributes = array('name' => 'frmEditLeaf', 'id' => 'frmEditLeaf', 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('edit_leaf_save/index/doc/'.$this->input->get('doc'), $attributes);
?>
          <div id="mainContentProof">
		<?php
			$arrDetails['viewOption'] = 'htmlView';
			$arrDetails['doc'] = $this->input->get('doc');
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
			//Manoj: get memcache object	
			$memc=$this->identity_db_manager->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;	
			$memc->delete($memCacheId);
			$value = $memc->get( $memCacheId );
			
			if(!$value)
			{						
				$tree = $this->document_db_manager->getDocumentFromDbTimeView($treeId);
				
				//arun-  start  code for sorting
				//Sorting array by diffrence 
				foreach ($tree as $key => $row)
				{
					$diff[$key]  = $row['orderingDate'];
				}

	
				array_multisort($diff,SORT_DESC,$tree);
	
				//arun- end code of sorting
				
				$memc->set($memCacheId, $tree, MEMCACHE_COMPRESSED);	
				$value = $memc->get($memCacheId);	
					if ($value == '')
					{
						$value = $tree;
					}		
			}	
						
			if ($value)
			{	
				$arrDetails['value'] = 	$value;				
				$this->load->view('document/document_body_cal_for_mobile', $arrDetails);			
			}	
		?>
        <input type="hidden" name="curFocus" value="0" id="curFocus">
        <input type="hidden" name="curLeaf" value="0" id="curLeaf">
        <input type="hidden" name="editStatus" value="0" id="editStatus">
        <input type="hidden" name="curContent" value="0" id="curContent">
        <input type="hidden" name="curNodeId" value="0" id="curNodeId">
        <input type="hidden" name="treeId" value="<?php echo $this->input->get('treeId');?>" id="treeId">
        <input type="hidden" name="curLeafOrder" value="0" id="curLeafOrder">
        <input type="hidden" name="curOption" value="edit" id="curOption">
        <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
        <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
      </div>
          </form>
        </div>
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
