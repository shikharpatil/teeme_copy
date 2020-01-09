<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php
//$_SESSION['sortOrder']
$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $_SESSION['sortBy'], '2');
?>
<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>
<?php 
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?>

<div><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div>
<?php
	}
	?>
<?php 
	if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")
	{
	?>

<div><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></div>
<?php
	}
	?>
<div><span><?php echo $this->lang->line('txt_files');?></span></div>
<?php
		if(count($externalDocs) > 0)
		{
		?>
<div class="row-active-header">
  <div class="row-active-header-inner1" style="width:30%;" > <span class="rowHeaderFont" > <a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/1"><?php echo $this->lang->line('txt_File_Name');?></a></span> </div>
  <div class="row-active-header-inner2" style="width:18%;"  > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/2"><?php echo $this->lang->line('txt_By');?></a></span> </div>
  <div class="row-active-header-inner3"  style="width:12%;"   > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/3"><?php echo $this->lang->line('txt_Date');?></a></span> </div>
  <div class="row-active-header-inner3" style="width:24%;"   > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/4"><?php echo $this->lang->line('txt_Url');?></a></span> </div>
  <?php
									$wsManagerAccess = $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceId,3);
									if($_SESSION['WPManagerAccess'] || $workSpaceId == 0 || $wsManagerAccess)
									{
									?>
  <div class="row-active-header-inner3" style="width:6%;"   > <span class="heading-grey"><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/5"><?php echo $this->lang->line('txt_Action');?></a></span> </div>
  <?php
									}
									?>
</div>
<?php
								$rowColor1='row-active-middle1';
								$rowColor2='row-active-middle2';	
								$i = 1;	
								

								//Added by Dashrath : code start
								$folderName = base64_decode($this->uri->segment(7));

								//used for delete url
								$encodedFoldername = $this->uri->segment(7);
								//Dashrath : code end
						
								foreach($externalDocs as $docData)
								{	
									//Added by Dashrath : code start
									$pathArray = explode('/', $docData['docPath']);
									
									
									if(count($pathArray) > 0 && $pathArray[2] == $folderName)
									
									{
									//Dashrath : code end
									$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($docData['userId']);
									$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
									
									$arrFileUrl	= $this->identity_db_manager->getExternalFileDetailsById( $docData['docId']);		
									//$url = base_url().$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];		
									$url = base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].$arrFileUrl['docName'];												
								?>
<div class="<?php echo $rowColor; ?> ">
  <div class="row-active-header-inner1" style="width:30%; word-wrap: break-word;" > <a href="<?php echo $url;?>" target="_blank">
    <?php 
												echo $docData['docCaption'].'_v'.$docData['version'];
											?>
    </a> </div>
  <div class="row-active-header-inner2"  style="width:18%;" > <span><?php echo $userDetails['userTagName'];?></span> </div>
  <div class="row-active-header-inner3" style="width:12%;"  > <span><?php echo $this->time_manager->getUserTimeFromGMTTime($docData['docCreatedDate'], 'm-d-Y h:i A');?></span> </div>
  <div class="row-active-header-inner3" style="width:24%;"   > <span class="rowHeaderFont" >
    <input id="copy_url<?php echo $docData['docId'];?>" type="text" readonly="readonly" value="<?php echo $url;?>" onClick="SelectAll('copy_url<?php echo $docData['docId'];?>');"  style=" width:92%"/>
    </span> </div>
  <?php
										if($_SESSION['WPManagerAccess'] || $workSpaceId == 0 || $wsManagerAccess)
										{
										?>
		<!--Manoj: added anchor tag-->
		<!-- Dashrath : added encoded folder name in href link -->
  <div class="row-active-header-inner3" style="width:6%; text-align:center"><a href="<?php echo base_url();?>delete_ext_file/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $docData['docId'];?>/<?php echo $encodedFoldername; ?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0"></a></div>
  <?php
										}
										?>
  <div class="clr"></div>
</div>
<?php
									$i++;
									//Added by Dashrath : code start
									}
									//end if condition
									//Dashrath : code end
								}
								?>
<?php
		}
		else
		{
		?>
<div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
<?php
		}
		?>
