<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Teeme > Task</title>

<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

</script>
<!--Manoj: Back to top scroll script-->
<?php $this->load->view('common/scroll_to_top'); ?>
<!--Manoj: code end-->
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
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar"> 

 

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

			

		 

	<?php

	if(count($arrDiscussions) > 0)

	{		

			$count = 0 ;

			foreach($arrDiscussions as $keyVal=>$arrVal)

			{

				$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);



					if ($arrVal['isShared']==1)

					{

						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	

					}

					if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	

					{

						$count++;

					}

			}	

			

			if ($count!=0)

			{	

	

		

	?>

	

	

	 <div class="row-active-header">

                <!-- Changed By Surbhi IV-->

		 		<div class="row-active-header-inner1_2" >

					<span class="rowHeaderFont" ><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/1"><?php echo $this->lang->line('txt_Task');?></a></span>

				</div>

				

				<div class="row-active-header-inner2"  >

					<span class="rowHeaderFont" ><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/2"><?php echo $this->lang->line('txt_Created_By');?></a></span>

				</div>

				

				<div class="row-active-header-inner3"  >

					<span class="rowHeaderFont" ><a href="<?php echo base_url();?>view_task/View_All/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/3"><?php echo $this->lang->line('txt_Date_Modified');?></a></span>

				</div>

				<!-- End of Changed By Surbhi IV-->

		 </div>

	

     

	<?php

	

	$rowColor1='row-active-middle1';

	$rowColor2='row-active-middle2';	

	$i = 1;	

				 

	foreach($arrDiscussions as $keyVal=>$arrVal)

	{

		$userDetails	= $this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);	

		

			if ($arrVal['isShared']==1)

			{

				$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	

			}	

			if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	

			{

				$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;

	?>			

      

	  

	  			<div class="<?php echo $rowColor; ?> ">

		 		<div class="row-active-header-inner1_2" >

				 <?php

            if ($arrVal['isShared']==1)

			{

			?>

					<img src="<?php echo base_url();?>images/share.gif" alt="Shared" border="0"/>

			<?php

			

			 }

			?>		

					<a class="blue-link-underline" href="<?php echo base_url();?>view_task/node/<?php echo $keyVal;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><?php echo strip_tags(stripslashes($arrVal['name']));?></a>

		

				</div>

				

				<div class="row-active-header-inner2"  >

					<span><?php echo $userDetails['userTagName'];?></span>

				</div>

				

				<div class="row-active-header-inner3"  >

					<span><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></span>

				</div>

				

				<div class="clr"></div>

		 </div>

		<?php

			}

			$i++;

		}

	}

	else

	{
		//redirect('dashboard/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1', 'location');	
		//exit;	?>	

	  <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>

	<?php

	}	

}	

else

{
		//redirect('dashboard/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1', 'location');	
		//exit;
?>	

	<div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>

<?php

}	

?>

 

   

   

</div>

	<!--Added by Dashrath- load notification side bar-->
    <?php $this->load->view('common/notification_sidebar.php');?>
    <!--Dashrath- code end-->

</div>

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

</body>
</html>	
<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>