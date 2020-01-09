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
<?php
		if(count($externalDocs) > 0)
		{
		?>
<div class="row-active-header" style="margin-top:3%;">
  <div class="row-active-header-inner1" style="width:50% !important;" > <span class="rowHeaderFont" > <a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/1"><?php echo $this->lang->line('txt_File_Name');?></a></span> </div>
  <div class="row-active-header-inner2" style="width:25% !important;"  > <span class="rowHeaderFont" ><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/2"><?php echo $this->lang->line('txt_By');?></a></span> </div>
  <?php
									$wsManagerAccess = $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceId,3);
									if($_SESSION['WPManagerAccess'] || $workSpaceId == 0 || $wsManagerAccess)
									{
									?>
  <div class="row-active-header-inner3" style="width:6% !important;"   > <span class="heading-grey"><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/5"><?php echo $this->lang->line('txt_Action');?></a></span> </div>
  <?php
									}
									?>
</div>
<?php
								$rowColor1='row-active-middle1';
								$rowColor2='row-active-middle2';	
								$i = 1;	
								
								
						
								foreach($externalDocs as $docData)
								{	
									$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($docData['userId']);
									$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
									
									$arrFileUrl	= $this->identity_db_manager->getExternalFileDetailsById( $docData['docId']);		
									//$url = base_url().$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];	
									//Manoj: added new url and comment old url for download file(s)	
									$url = base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];													
								?>
<div class="<?php echo $rowColor; ?> ">
  <div class="row-active-header-inner1" style="width:50% !important;; word-wrap: break-word;" > <a href="<?php echo $url;?>" target="_blank">
    <?php 
												echo $docData['docCaption'].'_v'.$docData['version'];
											?>
    </a> </div>
  <div class="row-active-header-inner2"  style="width:30% !important;;" > <span><?php echo $userDetails['userTagName'];?></span> </div>
  <?php
                if($_SESSION['WPManagerAccess'] || $workSpaceId == 0 || $wsManagerAccess)
                {
                ?>
  <div class="row-active-header-inner3" style="width:6% !important;; text-align:center"   > <span class="heading-grey"><a href="<?php echo base_url();?>delete_ext_file/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $docData['docId'];?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" title="<?php echo $this->lang->line('txt_Delete');?>" border="0"></a></span></div>
  <?php
                }
                ?>
  <div class="clr"></div>
</div>
<?php
									$i++;
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
