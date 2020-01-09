<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Teeme > Contact</title>
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
	<!--Manoj: Back to top scroll script-->
<?php $this->load->view('common/scroll_to_top'); ?>
<!--Manoj: code end-->
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
    
    <!--webbot bot="HTMLMarkup" startspan --> 
    
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
				 
				if(count($contact_list) > 0)
				{
				
					$count = 0 ;
					foreach($contact_list as $keyVal=>$arrVal)
					{
						$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);	

						if ($arrVal['isShared']==1)
						{
							$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($arrVal['id']);
						}
						if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
						{
							$count++;
						}
					}
					
					if ($count!=0)
					{
				?>
    <div class="row-active-header" > 
          <!-- Changed By Surbhi IV-->
          <div class="row-active-header-inner1"  style="width:60%; padding:0;"  > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Contact');?></a></span> (<?php echo count($contact_list); ?>) </div>
          
		  <!--Manoj: comment for created by text-->
		  <?php /*?><div class="row-active-header-inner2" style="width:40%;" > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"><?php echo $this->lang->line('txt_Created_By');?></a></span> </div><?php */?>
          
          <!--End of Changed By Surbhi IV--> 
        </div>
    <?php
						$rowColor1='row-active-middle1';
						$rowColor2='row-active-middle2';	
						$i = 1;	
											 
						foreach($contact_list as $keyVal=>$arrVal)
						{
							$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);
								
									
							if ($arrVal['isShared']==1)
							{
								$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($arrVal['id']);	
							}
							if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
							{
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						
						?>
    <div class="<?php echo $rowColor; ?> "  style="margin:3% 0; padding:3%;" > <!--Manoj: Add margin padding-->
          <div class="row-active-header-inner1" style="width:60%; padding:0;" >
        <?php
						if ($arrVal['isShared']==1)
						{
						?>
        <img src="<?php echo base_url();?>images/share.gif" alt="Shared" border="0"/>
        <?php
						
						 }
						?>
        <a href="<?php echo base_url();?>contact/contactDetails/<?php echo $arrVal['id'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="blue-link-underline"><?php echo $arrVal['firstname'].' '.$arrVal['lastname'];?> </a> </div>
			
			<!--Manoj: Add created date width fontsize color-->
          <div class="row-active-header-inner2"  style="width:50%; font-size:12px; color:#666666;"  > <span><?php echo $userDetails['userTagName'];?></span> </div>
		  <div class="row-active-header-inner3" style="width:50%; font-size:12px; color:#666666;" ><span><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></span></div>
		  <!--Manoj: code end-->
		  
          <div class="clr"></div>
        </div>
    <?php
							}
							$i++;
							
						}
					}
					else
					{
					?>
    <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
    <?php
					}
		}
		else
		{
		?>
    <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
    <?php
		}
		?>
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
