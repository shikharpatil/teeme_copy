<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teeme</title>
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
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
</div>
<div id="container_for_mobile" >
  <div id="content"> 
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
    
    <div class="menu_new_for_mobile" >
      <ul class="tab_menu_new_for_mobile">
        <li class="discuss-view"><a class="1tab" href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
        <li class="stop-time-view"><a   href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
        <li class="tag-view" ><a  href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a   href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view_sel"><a  class="active" href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
      </ul>
      <div class="clr"></div>
    </div>
    <span class="errorMsg" style="font-weight:normal; height:200px;" > &nbsp;
    <?php
			if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
			{
			?>
    <?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?>
    <?php
			}
			?>
    </span>
    <?php       
						if($this->input->post('users') != '')
						{
							$by = $this->input->post('users');
						}	
						
					?>
    <script>
function showFilteredMembers()
{
	var toMatch = document.getElementById('showMembers').value;
	var val = '';
		if (1)
		{
			<?php
			if ($workPlaceMembers==0)
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_All');?><br>';
				}
			<?php
			}

			foreach($workPlaceMembers as $arrData)	
			{
				if (in_array($arrData['userId'],$sharedMembers))
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
			
			foreach($workPlaceMembers as $arrData)	
			{
				if (!in_array($arrData['userId'],$sharedMembers))
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
        	?>

		}
}
</script> 
    <!-- Main Body -->
    <form name="frmCal" action="<?php echo base_url()?>view_chat/share_paused/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post">
      <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
          <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Members');?>: </td>
          <td width="85%" align="left" valign="top" class="tdSpace"><input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></td>
        </tr>
        <tr>
          <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
          <td width="85%" align="left" valign="top" class="tdSpace"><div id="showMem" style="height:120px; width:300px; overflow:scroll;">
              <input type="checkbox" name="users[]" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/>
              <?php echo $this->lang->line('txt_All');?><br />
              <?php	
											
				foreach($workPlaceMembers as $arrData)
				{
					if (in_array($arrData['userId'],$sharedMembers))
					{						
				?>
              <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/>
              <?php echo $arrData['tagName'];?><br />
              <?php
					}
				}
				
				foreach($workPlaceMembers as $arrData)
				{
					if (!in_array($arrData['userId'],$sharedMembers))
					{						
				?>
  <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}?>/>
  <?php echo $arrData['tagName'];?><br />
  <?php
					}
				}
				?>
            </div></td>
        </tr>
        <tr>
          <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
          <td width="85%" align="left" valign="top" class="tdSpace"><input type="hidden" name="treeId" value="<?php echo $treeId; ?>" />
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId; ?>" />
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType; ?>" />
            <?php
			if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
			{
				?>
				<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_Ok');?>" class="button01">
				<input type="button" name="Clear" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearForm(this.form);">
				<?php
			}
			?></td>
        </tr>
      </table>
    </form>
    <!-- Main Body --> 
    
  </div>
</div>
<?php $this->load->view('common/footer_for_mobile');?>
<?php $this->load->view('common/foot_for_mobile');?>
</body>
</html>
