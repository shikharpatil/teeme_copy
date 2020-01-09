<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Discuss ><?php echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>') ?></title>
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head');?>
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
    <div class="menu_new" >
      <ul class="tab_menu_new_for_mobile">
        <li class="discuss-view"><a class="1tab" href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
        <li class="time-view-o"><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Real_Time_View');?>"></a></li>
        <li class="tag-view" ><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a  href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view_sel"><a class="active" href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
      </ul>
      <div class="clr"></div>
    </div>
    <?php
			if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
			{
			?>
    <div ><span class="errorMsg" style="font-weight:normal"  ><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></div>
    <?php
			}
			?>
	<?php
			if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")
			{
			?>
    <div ><span class="successMsg" style="font-weight:normal"  ><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></div>
    <?php
			}
			?>
    <?php       
			if($this->input->post('users') != '')
			{
				$by = $this->input->post('users');
			}	
                
            ?>
			
			<?php 
			
				$sharedMembersList = implode(",",$sharedMembers); 
						
			?>
    
    <!-- Main Body -->
    <form name="frmCal" action="<?php echo base_url()?>view_chat/share/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post">
      <table width="100%" border="0" cellspacing="3" cellpadding="3" style="padding:4% 0%;">
        <tr>
          <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Members');?>: </td>
          <td width="85%" align="left" valign="top" class="tdSpace"><input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></td>
        </tr>
        <tr>
          <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
          <td width="85%" align="left" valign="top" class="tdSpace"><div id="showMem" style="height:120px; width:300px; overflow:scroll;">
              <input type="checkbox" name="users[]" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/>
              <?php echo $this->lang->line('txt_All');?><br />
              <?php	
											
							foreach($workPlaceMembers as $arrData)
							{
								if (in_array($arrData['userId'],$sharedMembers))
								{						
							?>
              <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" />
              <?php echo $arrData['tagName'];?><br />
              <?php
			  				
							//Get checked userlabel
								if ($arrDiscussionDetails['userId']==$_SESSION['userId'])
								{
									if($arrDiscussionDetails['userId']!=$arrData['userId'])
									{
										$content .= '<div class="sol-selected-display-item sol_check'.$arrData['userId'].'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('.$arrData['userId'].',1); ">x</span><span class="sol-selected-display-item-text">'.$arrData['tagName'].'</span></div>';
									}
								}
								//Code end
			  
								}
							}
							foreach($workPlaceMembers as $arrData)
							{
								if (!in_array($arrData['userId'],$sharedMembers))
								{						
							?>
              <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" />
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
			<input type="hidden" name="list" id="list" value="<?php echo $sharedMembersList; ?>"/>
            <?php
							if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])
							{
							?>
            <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_Ok');?>" class="button01">
            <input type="reset" name="Clear" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearUserLabels();">
            <?php
							}
							?></td>
        </tr>
      </table>
    </form>
	
	<div>
		<div class="sol-current-selection" style="max-height:250px; overflow-y:scroll;"></div>
	</div>
    <!-- Main Body --> 
    
  </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
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
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_All');?><br>';
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
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';
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
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
        	?>
			
			var list = $("#list").val();
			var val1 = list.split(",");
			
			$(".clsCheck").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});

		}
}


	function checkAllFunction(){
		var htmlContent='';
	
		if($("#checkAll").prop("checked")==true){
			$('.clsCheck').prop("checked",true);
			$(".clsCheck").each(function(){
				value = $("#list").val();
				val1 = value.split(",");	
				if(val1.indexOf($(this).val())==-1){
					$("#list").val(value+","+$(this).val());
				}
				
				//Show checked label at top
					var data = $(this).data('myval');
					var value = $(this).val();
					htmlContent += '<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
				//Code end
				
			});
			$('.sol-current-selection').html(htmlContent);
		}
		else{
			//change prop to attr for server
			$('.clsCheck').prop("checked",false);
			$(".clsCheck").each(function(){
				value = $("#list").val();
				val1 = value.split(",");	
				var index = val1.indexOf($(this).val());
				val1.splice(index);	
				var arr = val1.join(",")
				$("#list").val(arr);
			});
			$('.sol-current-selection').html('');
		}
	}
	
	//$('.clsCheck').live("click",function(){
	$(document).on('click', '.clsCheck', function(){
	
		var data = $(this).data('myval');
		var value = $(this).val();
	
		val = $("#list").val();
		val1 = val.split(",");	
		if($(this).prop("checked")==true){
			if($("#list").val()==''){
				$("#list").val($(this).val());
			}
			else{
				if(val1.indexOf($(this).val())==-1){
					$("#list").val(val+","+$(this).val());
				}
			}
			addSelectionDisplayItem(data,value,$(this));
		}
		else{
			var index = val1.indexOf($(this).val());
			val1.splice(index, 1);
			var arr = val1.join(",");
			$("#list").val(arr);
			removeSelectionDisplayItem(value);
		}
	});
	
function addSelectionDisplayItem(data,value,changedItem)
{
		$('.sol-current-selection').append('<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1); ">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>');
		
}

function removeSelectionDisplayItem(value,uncheck)
{
	$('.sol_check'+value).remove();
		
		if(uncheck=='1')
		{
			$('.remove'+value).prop('checked', false);
			
			val = $("#list").val();
	
			val1 = val.split(",");
			
			var index = val1.indexOf($('.remove'+value).val());
	
			val1.splice(index, 1);
	
			var arr = val1.join(",");
	
			$("#list").val(arr);
			
		}
		
}

$(document).ready(function(){
	$('.sol-current-selection').html('<?php echo $content; ?>');
});

function clearUserLabels()
{
	$('.sol-current-selection').html('<?php echo $content; ?>');
}	

</script>