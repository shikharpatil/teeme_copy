<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Contact > Bulk Contacts</title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head.php');?>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
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

<div class="menu_new" >
      <ul class="tab_menu_new">
    <li class="contact-view"><a  href="<?php echo base_url()?>contact/editContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" title="<?php echo $this->lang->line('txt_Create');?>" ></a></li>
    <li class="contact-view-bulk_sel"  ><a class="active 1tab" href="<?php echo base_url()?>contact/importContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" title="<?php echo $this->lang->line('txt_Bulk_Contacts');?>"><?php echo $this->lang->line('txt_Bulk_Contacts');?></a></li>
  </ul>
      <div class="clr"></div>
    </div>
<?php
				if ($error!='')
				{
				?>
<span class="text_red"><?php echo $error;?></span>
<?php
				}
				?>
<span class="errorMsg"  style="font-weight:normal; height:30px;" >
    <?php
				if(isset($_SESSION['message']) && $_SESSION['message'] !=	"")
				{
				?>
    <?php echo $_SESSION['message']; $_SESSION['message'] ='';?>
    <?php
				}
				
				?>
    &nbsp;</span>
<table width="<?php echo $this->config->item('page_width')-25;?>" border="0" cellpadding="0" cellspacing="0" style="margin-top:40px;" >
<tr>
      <td colspan="4"><?php if(isset($_SESSION['errorMsg'])){ echo $_SESSION['errorMsg']; $_SESSION['errorMsg']=''; } ?>
    <form method="post" action="<?php echo base_url(); ?>contact/importContact/0/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>" enctype="multipart/form-data" >
          <div id="image_msg" style="color:#FF0000;"></div>
          <script type="text/javascript" >

if(mobile_detect("", "1", ''))
{
	document.getElementById("image_msg").innerHTML = 'To upload file use web services.<br><br>';
	
}

</script> 
          <?php echo $this->lang->line('Msg_Please_upload_csv_or_vcf_file');?>&nbsp;
          <input  type="file" name="contact"  id="contact" />
          <input type="submit" value="submit"  >
        </form></td>
    </tr>
<?php if($total_records){ ?>
<tr>
      <td colspan="4"><?php    echo '<br><b>'.$this->lang->line('Msg_Total_contacts_in_file')." ".$total_records.'</b>';  ?></td>
    </tr>
<?php } ?>
<tr>
      <td colspan="4"><?php  $success_records=$total_records- $failed_records; if($total_records){echo '<br><b>'.$this->lang->line('Msg_Total_imported_contacts').' '.$success_records.'</b>'; }  ?></td>
    </tr>
<tr>
<td colspan="4">
<?php   if(count($successUserRecords)>0) { ?>
<table width="800px" >
      <?php			
							$userDetail=explode("\n",$successUserRecords);
							foreach($userDetail as $record)
							{
							   
								 $feild=explode(",",$record);
								 if($feild[0]!='')
								 {
								 $temp.= '<tr><td>'.$feild[0].'</td><td>'.$feild[1].'</td><td>'.$feild[2].'</td><td>'.$feild[4].'</td><td>'.$feild[5].'</td><td>'.$feild[6].'</td><td style="color:green " >'.$this->lang->line('txt_Success').'</td></tr>';
								 }
							}
						
							if($successUserRecords){
				?>
      <tr style="font-weight:bold" height="30px">
    <td width="100px;"><?php echo $this->lang->line('txt_Company_Name');?></td>
    <td width="100px;"><?php echo $this->lang->line('txt_First_Name');?></td>
    <td width="100px;"><?php echo $this->lang->line('txt_Last_Name');?></td>
    <td width="100px;"><?php echo $this->lang->line('txt_Email');?></td>
    <td width="100px;"><?php echo $this->lang->line('txt_Telephone');?></td>
    <td width="100px;"><?php echo $this->lang->line('txt_Mobile');?></td>
    <td><?php echo $this->lang->line('txt_Success');?></td>
  </tr>
      <?php		
				             }
							echo $temp."</table>";	
								
				  } ?>
        </td>
      
        </tr>
      
      <tr>
    <td colspan="4"><?php   if($failedUser) { ?>
          <form  id="csvfile" name="csvfile" method="post" action="<?php echo base_url(); ?>contact/downloads" >
        <?php  echo '<br><b>'.$this->lang->line('Msg_Total_failed_registrations')." ".$failed_records.'</b>';  ?>
        <input type="hidden" name="contents" id="contents" value="<?php echo "Company Name,First Name,Last Name,Error \n".$failedUser; ?>"  />
        <a href="javaScript:void(0)" onclick="document['csvfile'].submit();"  >Download csv file</a>
      </form>
          <?php } ?></td>
  </tr>
        <tr>
      
        <td colspan="4">
      
      <?php   if(count($failedUser)>0) { ?>
      <table width="800px" >
    <?php 
				 			$temp='';
							$userDetail=explode("\n",$failedUser);
							foreach($userDetail as $record)
							{
								 $feild=explode(",",$record);
								 
								$temp.= '<tr><td>'.$feild[0].'</td><td>'.$feild[1].'</td><td>'.$feild[2].'</td><td>'.$feild[4].'</td><td>'.$feild[5].'</td><td>'.$feild[6].'</td><td style="color:red " >';
								if($feild[7]!='')
								  $temp.='ERROR';
								  $temp.='</td></tr>';
								 
							}
							
							if($failedUser){
					?>
    <tr style="font-weight:bold" height="30px">
          <td width="100px;"><?php echo $this->lang->line('txt_Company_Name');?></td>
          <td width="100px;"><?php echo $this->lang->line('txt_First_Name');?></td>
          <td width="100px;"><?php echo $this->lang->line('txt_Last_Name');?></td>
          <td width="100px;"><?php echo $this->lang->line('txt_Email');?></td>
          <td width="100px;"><?php echo $this->lang->line('txt_Telephone');?></td>
          <td width="100px;"><?php echo $this->lang->line('txt_Mobile');?></td>
          <td>Error</td>
        </tr>
    <?php	
					   }	
							echo $temp."</table>";	
								
				  } ?>
      </td>
    
      </tr>
    
  </table>
        </td>
      
        </tr>
      
    </table>
</div>
</div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
</body>
</html>
