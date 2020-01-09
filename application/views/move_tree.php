<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
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
	
	<?php $this->load->view('common/view_head.php');?>
	
	<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	
	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script> 

	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script>
	
</head>

<body>
<form name="moveSpaceForm" id="moveSpaceForm">	
<div id="spanMoveTree" style="display:block; margin-left:2%">
            <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
            <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
            <div class="lblMoveTree" style="width:135px;"><?php  echo 'Move '.$treeType.' to';?></div>
            <div class="floatLeft">
                  <?php   
							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
							{   
								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
							?>
                  <select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >
                <?php 
						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{				
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
					
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) /*echo 'disabled';*/?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
						
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1)
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) /*echo 'disabled';*/?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
									}
									}
								}
							}
						}
						else
						{
						?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
                <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{				
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							/*if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))
							{*/
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
							?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
					}
							/*}*/
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
						
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										/*if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
										{*/
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1)
										{
									?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
					}
										/*}*/
									}
								}
							}
						
						}
						?>
              </select>
			      <?php
					}
					?>
                </div>
				<div  class="floatLeft" id="divselectMoveToUser"  > </div>
				<div style="clear:both;"></div>
				<br/>
				<!-- Added by Dashrath : code start -->
				<div> 
					<span> Keep a copy of the current <?php echo $treeType;?> in the current space?</span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked" name="copyTree" id="copyTree" onclick="textAreaOpenHide(<?php echo $treeId; ?>)"> &nbsp;&nbsp;&nbsp;(<?php echo $this->lang->line('txt_Yes');?>)</div>
				<div style="clear:both;"></div>
				<br/>
				<div>
					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center">
						<tr class="treeCopyTitle">

	                        <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Tree_Title');?><span class="text_red"></span></td>

	                        <td align="left" valign="top" class="text_gre"><strong>:</strong></td>

	                        <td align="left" class="text_gre"><textarea id="treeTitle" name="treeTitle" class="new_tree_textarea" style="width:45%;"/><?php echo $treeTitle; ?></textarea></td>

	                    </tr>
					</table>
				</div>
				<!-- Dashrath : code end -->

				<!--Added by Dashrath- for used in show confirmation alert message-->
				<input type="hidden" name="treeType" id="treeType" value="<?php echo $treeType; ?>">
				<!--Dashrath- code end-->

            <div style="margin-top:3%;">
			 <input name="moveSpaceTree" type="button"  onclick="moveTree(document.getElementById('OriginatorIdValue'),<?php echo $treeId; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" value="<?php echo $this->lang->line('txt_Move');?>" class="button01"> 
			  <input name="cancelMoveSpaceTree" type="button" onclick="resetMoveForm();" value="<?php echo $this->lang->line('txt_Cancel');?>"  class="button01">
			</div>
            <?php /*?><img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> <?php */?>
</div>
<input type="hidden" value="" id="OriginatorIdValue" />
</form>
</body>	
</html>	
<script>
function resetMoveForm()
{
	if(document.getElementById('moveSpaceForm') !== null)
	{
		document.getElementById('moveSpaceForm').reset();
		$("#OriginatorIdValue").val('');
		$("#divselectMoveToUser").html('');
	}
}

/*Commented by Dashrath- treeTitle get from common controller*/
// $(document).ready(function(){

// 	var treeId = "<?php echo $treeId; ?>";
	
//     var request = $.ajax({

// 	url: baseUrl+"comman/getTreeNameByTreeId",

// 	type: "POST",

// 	data: 'treeId='+treeId,

// 	dataType: "html",

// 	success:function(result){
// 	  document.getElementById("treeTitle").value = result;
// 	  $(".treeCopyTitle").show();
// 	  }
// 	});
// });
/*Dashrath- code end*/
</script>