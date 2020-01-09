<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head.php');?>
	<?php $this->load->view('editor/editor_js.php');?>
	<?php $this->load->view('common/datepicker_js.php');?>
	<script>
		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
		var workSpace_name='<?php echo $workSpaceId;?>';
		var workSpace_user='<?php echo $_SESSION['userId'];?>';
	</script>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
		
		$(function() {
	
			$('#fromDate').datepicker({dateFormat: "dd-mm-yy"});
			$('#toDate').datepicker({dateFormat: "dd-mm-yy"});
		
		
		});

	</script>
	</head>
	<body>
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
    </div>
<div id="container">
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
		  
	$_SESSION['docSearchDate'] 	= 0;
	$_SESSION['docFromDate'] 	= '';
	$_SESSION['docToDate'] 		= '';		  
//echo "<li>sd= " .$this->input->post('searchDate');
if($this->input->post('searchDate') != '')
{
	//echo "<li>Here";
	$_SESSION['docSearchDate'] = $this->input->post('searchDate');
	if($this->input->post('searchDate') == 0)
	{	
		if($this->input->post('fromDate') != '')
		{
			$sd1 = explode("-",$this->input->post('fromDate')); 
			$searchDate1	= $sd1[2]."-".$sd1[1]."-".$sd1[0];
		
			
			$_SESSION['docFromDate'] 	= $searchDate1;
		}
		if($this->input->post('toDate') != '')
		{
			$sd2 = explode("-",$this->input->post('toDate'));
			$searchDate2	= $sd2[2]."-".$sd2[1]."-".$sd2[0];

			$_SESSION['docToDate'] 		= $searchDate2;		
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

//echo "<li>from date= " .$_SESSION['docFromDate'] ;

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
//echo "<li>sd1= " .$searchDate1;
//echo "<li>sd2= " .$searchDate2;
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

//echo "<li>fromdate= " .$_SESSION['docFromDate'] ; exit;
?>
          <form name="frmCal" action="<?php echo base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=2';?>" method="post" onSubmit="return validateCal()">
        <div class="menu_new" >
              <ul class="tab_menu_new">
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
            <li id="treeUpdate"></li>
            <?php 
			/*Code for follow button*/
				$treeDetails['seedId']=$treeId;
				$treeDetails['treeName']='doc';	
				$this->load->view('follow_object',$treeDetails); 
			/*Code end*/
			?>
			<div class="clr"></div>
		</ul>
            </div>
        <table width="100%">
              <tr>
            <td colspan="4" align="left" valign="top" class="tdSpace"><?php
			if($this->input->post('Go') != '' )
			{
				//echo "<li>fromdate= " .$_SESSION['docFromDate']; exit;
			?>
                <select name="searchDate" onChange="getTimingsCal(this)">
                <option value="0" <?php if($_SESSION['docSearchDate'] == 0 || $this->input->post('fromDate') != '' || $this->input->post('toDate') != '') { echo 'selected'; } ?>>--select--</option>
                <option value="1" <?php if($_SESSION['docSearchDate'] == 1 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Today</option>
                <option value="2" <?php if($_SESSION['docSearchDate'] == 2 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>This Week</option>
                <option value="3" <?php if($_SESSION['docSearchDate'] == 3 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Last Week</option>
                <option value="4" <?php if($_SESSION['docSearchDate'] == 4 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>This Month</option>
                <option value="5" <?php if($_SESSION['docSearchDate'] == 5 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Last Month</option>
              </select>
                  <?php 
				if($this->input->post('fromDate') != '' || $this->input->post('toDate') != '')
				{
				?>
                  <span> &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?></span><span>&nbsp;&nbsp; <?php echo $this->lang->line('txt_From_Date');?>:&nbsp;</span>
                  <input type="text" name="fromDate" id="fromDate" size="10" value="<?php if($_SESSION['docFromDate'] != '') { echo $this->input->post('fromDate'); } ?>" onchange="clearSearchDropdown()" readonly="">
                  <span>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;</span>
                  <input type="text" name="toDate" id="toDate" size="10" value="<?php if($_SESSION['docToDate'] != '') { echo $this->input->post('toDate'); } ?>" onchange="clearSearchDropdown()" readonly="">
                  <?php
				}
				else
				{
				?>
                  <span> &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp; <?php echo $this->lang->line('txt_From_Date');?>:&nbsp;</span>
                  <input type="text" name="fromDate" id="fromDate" size="10" onchange="clearSearchDropdown()" readonly="">
                  <span>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;</span>
                  <input type="text" name="toDate" id="toDate" size="10" onchange="clearSearchDropdown()" readonly="">
                  <?php
				}
				?>
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
                  <span>&nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp; <?php echo $this->lang->line('txt_From_Date');?>:&nbsp;</span>
                  <input type="text" name="fromDate" id="fromDate" size="10" onchange="clearSearchDropdown()" readonly="">
                  <span>&nbsp;&nbsp; <?php echo $this->lang->line('txt_To_Date');?>:&nbsp;</span>
                  <input type="text" name="toDate" id="toDate" size="10" onchange="clearSearchDropdown()" readonly="">
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
        <div class="seedBgColor views_div">
              <?php
				echo '<a href=view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId.' style="text-decoration:none; color:#000;">'.strip_tags($arrDocumentDetails['name']).'</a>'; 
			?>
            </div>
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
					$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
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
					//echo "<li>value= "; print_r($value); exit;			
					if ($value)
					{	
						$arrDetails['value'] = 	$value;				
						$this->load->view('document/document_body_cal', $arrDetails);			
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
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
<?php $this->load->view('common/datepicker_js.php');?>
</body>
</html>
