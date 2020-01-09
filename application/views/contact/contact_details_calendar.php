<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Contact ><?php echo strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname'],'<b><em><span><img>');?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head.php');?>
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
	<script>
	$(window).scroll(function(){
	      // if ($(this).scrollTop() > 60) {
	      //     $('#divSeed').addClass('documentTreeFixed');
	      // } else {
	      //     $('#divSeed').removeClass('documentTreeFixed');
	      // }
	      
	      //call addAndRemoveClassOnSeed function
	  	  addAndRemoveClassOnSeed($(this).scrollTop());
	  });
	</script>
	</head>
	<body>
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php //$this->load->view('common/artifact_tabs', $details); ?>
  </div>
    </div>
<div id="container">
    <div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
    </div>
      <!-- Commented by Dashrath- change div id-->
      <!-- <div id="content">  -->
      <div id="rightSideBar"> 
      <!-- Dashrath -->
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
	$_SESSION['contactSearchDate'] 	= 0;
	$_SESSION['contactFromDate'] 	= '';
	$_SESSION['contactToDate'] 		= '';	
if($this->input->post('searchDate') != '')
{
	$_SESSION['contactSearchDate'] = $this->input->post('searchDate');
	if($this->input->post('searchDate') == 0)
	{	
		if($this->input->post('fromDate') != '')
		{
			$sd1 = explode("-",$this->input->post('fromDate')); 
			$searchDate1	= $sd1[2]."-".$sd1[1]."-".$sd1[0];
			$_SESSION['contactFromDate'] 	= $searchDate1;
		}
		
		if($this->input->post('toDate') != '')
		{

			$sd2 = explode("-",$this->input->post('toDate'));
			$searchDate2	= $sd2[2]."-".$sd2[1]."-".$sd2[0];
			$_SESSION['contactToDate'] 		= $searchDate2;		
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
    <!-- <div class="menu_new" >
          <ul class="tab_menu_new">
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
														<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='contact';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>
      </ul>
          <div class="clr"></div>
        </div> -->

    <div id="divSeed" class="seedBackgroundColorNew" >

    	<!-- Div contains tabs start-->
        <?php $this->load->view('contact/contact_seed_header'); ?>
        <!-- Div contains tabs end-->
        <div > <?php echo '<a style="text-decoration:none; color:#000;" href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'>'.$Contactdetail['firstname'].' '.$Contactdetail['lastname'].'</a>'; ?> </div>

    </div>

    <form name="frmCal" action="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">
          <table width="100%">
          <tr>
        <td colspan="4" align="left" valign="top" class="tdSpace"><?php
			if($this->input->post('Go') != '' )
			{
			?>
              <select name="searchDate" onChange="getTimingsCal(this)">
            <option value="0" <?php if($_SESSION['contactSearchDate'] == 0 || $this->input->post('fromDate') != '' || $this->input->post('toDate') != '') { echo 'selected'; } ?>>--select--</option>
            <option value="1" <?php if($_SESSION['contactSearchDate'] == 1 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Today</option>
            <option value="2" <?php if($_SESSION['contactSearchDate'] == 2 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>This Week</option>
            <option value="3" <?php if($_SESSION['contactSearchDate'] == 3 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Last Week</option>
            <option value="4" <?php if($_SESSION['contactSearchDate'] == 4 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>This Month</option>
            <option value="5" <?php if($_SESSION['contactSearchDate'] == 5 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>>Last Month</option>
          </select>
              <?php 
				if($this->input->post('searchDate') == 0 )
				{
				?>
              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
              <input type="text" name="fromDate" id="fromDate" size="10" value="<?php if($_SESSION['contactFromDate'] != '') { echo $this->input->post('fromDate'); } ?>" onchange="clearSearchDropdown()" readonly="">
              <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
              <input type="text" name="toDate" size="10" value="<?php if($_SESSION['contactToDate'] != '') { echo $this->input->post('toDate'); } ?>" id="toDate" onchange="clearSearchDropdown()" readonly="">
              &nbsp;&nbsp;
              <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
              <?php
				}
				else
				{
				?>
              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
              <input type="text" name="fromDate" id="fromDate" size="10" onchange="clearSearchDropdown()" readonly="">
              <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
              <input type="text" name="toDate" size="10" id="toDate" onchange="clearSearchDropdown()" readonly="">
              &nbsp;&nbsp;
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
              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp;
              <input type="text" name="fromDate" size="10" id="fromDate" onchange="clearSearchDropdown()" readonly="">
              <?php echo $this->lang->line('txt_To_Date');?>: &nbsp;
              <input type="text" name="toDate" id="toDate" size="10" onchange="clearSearchDropdown()" readonly="">
              &nbsp;&nbsp;
              <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
              <?php
			 }
			 ?></td>
      </tr>
          <tr>
        <td colspan="4">
    </form>
    <!-- <div class="seedBgColor views_div"> <?php echo '<a style="text-decoration:none; color:#000;" href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'>'.$Contactdetail['firstname'].' '.$Contactdetail['lastname'].'</a>'; ?> </div> -->
    <?php 
$focusId = 3;
$totalNodes = array();
if(count($ContactNotes) > 0)
{ 
?>
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
				$nodeBgColor = ($i%2)?'row1':"row2";
			}	
			if (!empty($nodeBgColor))
			{	
			?>
    <div class="<?php echo $nodeBgColor;?> views_div">
	
					<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#contactLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>
	
          <?php
					
					//echo '<a style="text-decoration:none; color:#000;" href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>';
					
					$lastnode=$arrVal['nodeId'];
					$i++;
					
					?>
          <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
        </div>
    <?php  
  			}
	$focusId = $focusId+2;	
	$position++;
	    
  }  
  ?>
    <?php 		
}
?>
    <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
    </td>
    </tr>
    </table>
  </div>
    </div>
<?php $this->load->view('common/foot.php');?>
<?php //$this->load->view('common/footer');?>
<?php $this->load->view('common/datepicker_js.php');?>
</body>
</html>
