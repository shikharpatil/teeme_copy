<!--Myspace select recepient code start-->

<?php $this->load->view('common/view_head.php');?>

				<?php
					$originatorUserId=$this->identity_db_manager->get_tree_originator_id('3',$nodeId);
			
					$postSharedMembers = $this->identity_db_manager->getPostSharedMembersByNodeId($nodeId);
					
					$postSharedMembersList = implode(",",$postSharedMembers);
					
					$groupSharedIds = $this->identity_db_manager->getGroupSharedIdsByNodeId($nodeId);
					
					$postSharedIdsList = implode(",",$groupSharedIds);
				?>
				<form>
				 <div id="postShare<?php echo $nodeId; ?>" class="postShareBox" style="margin-left:8px;">
				 <?php
					if($workSpaceId=='0' && $_SESSION['public'] != 'public' && $_SESSION['all'] != 'all' && $this->uri->segment(8)!='bookmark')
					{
						?>
						<input value="<?php echo $postSharedMembersList ?>" id="list<?php echo $nodeId; ?>" type="hidden" />
						
						<input value="<?php echo $postSharedIdsList ?>" id="listGroup<?php echo $nodeId; ?>" type="hidden" />
						
						<!--Group feature start here-->
						<?php if(count($groupList)>0){ ?>						
						<div style="margin-top:1%;">
						
						<div class="postSharedMsg" style="color:#099731; margin-left:5px; margin-top:5px;"></div>
						
						<?php
				 		echo $this->lang->line('txt_Select_Group')." : <br><br>"; 
						echo $this->lang->line('txt_Search')." : "; 
						?>
						<input type="text" id="searchEditGroup<?php echo $nodeId; ?>" name="searchEditGroup" onKeyUp="searchEditGroups('<?php echo $nodeId; ?>','<?php echo $originatorUserId; ?>','<?php echo $_SESSION['userId']; ?>')" size=30"/>
						
						<div id="showManGroup<?php echo $nodeId; ?>" style="max-height:120px; overflow:scroll; margin-bottom:30px; margin-top:20px; width:70%; ">

						<?php if(count($groupList)>0){ ?>
			
						<input type="checkbox" name="checkAllGroup" id="checkAllGroup<?php echo $nodeId; ?>" onclick="checkAllGroupsEdit('<?php echo $nodeId; ?>');" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';} ?> />
			
						<?php echo $this->lang->line('txt_All');?><br />
			
						<?php } ?>
			
						<?php
			
						$i=1;			
			
						foreach($groupList as $keyVal=>$groupData)
						{
							if (in_array($groupData['groupId'],$groupSharedIds))
							{
								$groupAllUsersList	= $this->identity_db_manager->getGroupUsersListByGroupId($groupData['groupId']);
						?>

					<input type="checkbox" name="groupRecipients<?php echo $nodeId; ?>[]" id="<?php echo 'groupRecipients_'.$i ; ?>" <?php if (in_array($groupData['groupId'],$groupSharedIds)) { echo 'checked="checked"';}?> value="<?php echo $groupData['groupId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?> class="clsCheckGroup<?php echo $nodeId; ?> removeGroup<?php echo $groupData['groupId'];?>" <?php } ?> onclick="getGroupName(this,'<?php echo $nodeId; ?>')" data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>"/>
					
<?php
if ($originatorUserId==$_SESSION['userId'])
{
$groupContent .= '<div class="sol-head sol-selected-display-item sol_check_group'.$groupData['groupId'].'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItemGroupEdit('.$groupData['groupId'].','.$nodeId.',1); ">x</span><span class="sol-selected-display-item-text">'.$groupData['groupName'].'</span></div><div style="clear:both"></div>';
$groupContent .= '<div class="sol-selected-display-item sol_check_group'.$groupData['groupId'].'"><span class="sol-selected-display-item-text">'.$groupAllUsersList.'</span></div><div style="clear:both"></div>';
}
?>

<?php echo $groupData['groupName'];?><br />
					
					<?php

						$i++;
		
							
						}
						}
						
						foreach($groupList as $keyVal=>$groupData)
						{
							if (!in_array($groupData['groupId'],$groupSharedIds))
							{
								$groupAllUsersList	= $this->identity_db_manager->getGroupUsersListByGroupId($groupData['groupId']);
						?>

					<input type="checkbox" name="groupRecipients<?php echo $nodeId; ?>[]" id="<?php echo 'groupRecipients_'.$i ; ?>" <?php if (in_array($groupData['groupId'],$groupSharedIds)) { echo 'checked="checked"';}?> value="<?php echo $groupData['groupId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?> class="clsCheckGroup<?php echo $nodeId; ?> removeGroup<?php echo $groupData['groupId'];?>" <?php } ?> onclick="getGroupName(this,'<?php echo $nodeId; ?>')" data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>" />
					
<?php echo $groupData['groupName'];?><br />
					
					<?php

						$i++;
		
							
						}
						}
		
						?>

					  </div>
					  
					  <!--Select user div end-->
					  <div >
						<div class="sol-current-selection-groups" style="max-height:135px; overflow-y:auto;"></div>
					  </div>
					  <!--Select user label end-->
					  <div class="clr"></div>
					</div>
					<?php } ?>							
						<!--Group feature end here-->
						
						<div style="margin-top:8%;">
						<?php
				 		echo $this->lang->line('txt_Select_Recepient(s)')." : <br><br>"; 
						echo $this->lang->line('txt_Search')." : "; 
						?>
						<input type="text" id="searchTags<?php echo $nodeId; ?>" name="searchTags" onKeyUp="showMySpaceTags('<?php echo $nodeId; ?>','<?php echo $originatorUserId; ?>','<?php echo $_SESSION['userId']; ?>')" size=30"/>
						
						<div id="showMan<?php echo $nodeId; ?>" style="max-height:120px;overflow:scroll; margin-bottom:30px; margin-top:20px; width:70%;">

						<?php if(count($workSpaceMembers_search_user)>0){ ?>
			
						<input type="checkbox" name="checkAll" id="checkAll<?php echo $nodeId; ?>" onclick="checkAllFunction('<?php echo $nodeId; ?>');" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';} ?> />
			
						<?php echo $this->lang->line('txt_All');?><br />
			
						<?php } ?>
			
						<?php
			
							$i=1;			
			
							foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
							{
								 if (in_array($workPlaceMemberData['userId'],$postSharedMembers))
								 {
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
					if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] && $showGuestUser){						
				
				?>

<input type="checkbox" name="recipients<?php echo $nodeId; ?>[]" id="<?php echo 'recipients_'.$i ; ?>" <?php if (in_array($workPlaceMemberData['userId'],$postSharedMembers)) { echo 'checked="checked"';}?> value="<?php echo $workPlaceMemberData['userId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?>class="clsCheck<?php echo $nodeId; ?> remove<?php echo $workPlaceMemberData['userId'];?> " <?php } ?> onclick="getRecepientName(this,'<?php echo $nodeId; ?>')" data-myval="<?php echo $workPlaceMemberData['tagName'];?>">

<?php
if ($originatorUserId==$_SESSION['userId'])
{
$content .= '<div class="sol-selected-display-item sol_check'.$workPlaceMemberData['userId'].'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('.$workPlaceMemberData['userId'].','.$nodeId.',1); ">x</span><span class="sol-selected-display-item-text">'.$workPlaceMemberData['tagName'].'</span></div>';
}
?>

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}
				}
				
				foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
				{
					 if (!in_array($workPlaceMemberData['userId'],$postSharedMembers))
					{
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
					if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] && $showGuestUser){						
				
				?>

<input type="checkbox" name="recipients<?php echo $nodeId; ?>[]" id="<?php echo 'recipients_'.$i ; ?>" <?php if (in_array($workPlaceMemberData['userId'],$postSharedMembers)) { echo 'checked="checked"';}?> value="<?php echo $workPlaceMemberData['userId'];?>" <?php if ($originatorUserId!=$_SESSION['userId']) { echo 'disabled="disabled"';}else{?>class="clsCheck<?php echo $nodeId; ?>  remove<?php echo $workPlaceMemberData['userId'];?>" <?php } ?> onclick="getRecepientName(this,'<?php echo $nodeId; ?>')" data-myval="<?php echo $workPlaceMemberData['tagName'];?>">

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}
				}

				?>
				

          </div>
		  
		  <!--select user list end-->
					<div style="margin-top:5%;">
						<div class="sol-current-selection" style="max-height:135px; overflow-y:auto;"></div>
					</div>
				<!--Show selected user label end-->
				<div class='clr'></div>
				<div style="margin-bottom:15%; margin-top:5%;">
		  			<?php if ($originatorUserId==$_SESSION['userId']) { 
					?>
		  			 <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Ok');?>" onclick="addPostShareUsers('<?php echo $nodeId; ?>')" style="margin-left:5px; float:left;">
					 <input type="reset" name="Replybutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;" onclick="clearUserLabels()" >			
					<?php } ?>	
				</div>
					<div style="clear:both;"></div>
					<div class="postLoader"></div>
						</div>
						
					<?php	
					}
				 ?>
					
				 </div>
				 </form>
				<div class='clr'></div>
				 
				 <!--Myspace select recepient code end-->
<script language="javascript" src="<?php  echo base_url();?>js/identity.js"></script>		
<script>
/*Add post share users start*/
function addPostShareUsers(nodeId)
{
		if(document.getElementById("list"+nodeId))
		{
			var recipients=document.getElementById("list"+nodeId).value.split(",");
		}
		if(document.getElementById("listGroup"+nodeId))
		{
			var groupRecipients=document.getElementById("listGroup"+nodeId).value.split(",");
		}
		data_user = 'nodeId='+nodeId+'&recipients='+recipients+'&groupRecipients='+groupRecipients; 
		
		$(".postLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		
		//var pnodeId=$("#pnodeId").val();
		var request = $.ajax({
			  url: baseUrl+"post/insert_post_shared_users/",
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result)
			  {
			  	  if(result==1)
				  {
				  	//jAlert('Post shared successfully!');
					$('.postSharedMsg').html('<?php echo $this->lang->line('txt_post_shared_msg'); ?>');
					$(".postLoader").html("");
				  }
				  $(".postLoader").html("");
				  //return false;
			  }
			});
}
/*Add post share users end*/
	
function getRecepientName(checkid,nodeId)
{
		//show label start
		var data = $(checkid).data('myval');
		var value = $(checkid).val();
		//show label end

		val = $("#list"+nodeId).val();

		val1 = val.split(",");	

		if($(checkid).prop("checked")==true){

			if($("#list"+nodeId).val()==''){

				$("#list"+nodeId).val($(checkid).val());

			}

			else{

				if(val1.indexOf($(checkid).val())==-1){

					$("#list"+nodeId).val(val+","+$(checkid).val());

				}

			}
			
			addSelectionDisplayItem(data,value,checkid,nodeId);

		}

		else{

			var index = val1.indexOf($(checkid).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list"+nodeId).val(arr);
			
			removeSelectionDisplayItem(value);

		}
}
//check all function start

function checkAllFunction(nodeId){

		var htmlContent='';
	

		if($("#checkAll"+nodeId).prop("checked")==true){

			$('.clsCheck'+nodeId).prop("checked",true);

			$(".clsCheck"+nodeId).each(function(){

				value = $("#list"+nodeId).val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list"+nodeId).val(value+","+$(this).val());

				}
				
				//Show checked label at top
					var data = $(this).data('myval');
					var value = $(this).val();
					htmlContent += '<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+','+nodeId+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
				//Code end

			});
			
			$('.sol-current-selection').html(htmlContent);

		}

		else{

			//change prop to attr for server - Monika

			$('.clsCheck'+nodeId).prop("checked",false);

			$(".clsCheck"+nodeId).each(function(){

				value = $("#list"+nodeId).val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",");

				$("#list"+nodeId).val(arr);

			});
			
			$('.sol-current-selection').html('');

		}

	}

//Check all function end
//My space search recepients start

function showMySpaceTags(nodeId,originatorUserId,currentUserId)
{
	//alert(originatorUserId+'======='+currentUserId);
	
	
   	var toMatch = document.getElementById('searchTags'+nodeId).value;
	
	if(originatorUserId != currentUserId)
	{
		var val = '<input disabled="disabled" type="checkbox" name="checkAll" id="checkAll'+nodeId+'" onclick="checkAllFunction('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}
	else
	{
		var val = '<input type="checkbox" name="checkAll" id="checkAll'+nodeId+'" onclick="checkAllFunction('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}

	//if (toMatch!='')

	if(1)

	{

		var count = '';

		var sectionChecked = '';

		<?php

		$i=1;

		foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
		{
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
			if($workPlaceMemberData['userId']!=$_SESSION['userId'] && $workPlaceMemberData['userId']!=$this->uri->segment(3) && $showGuestUser){?>

				var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

				

				var pattern = new RegExp('\^'+toMatch, 'gi');

				

				if (str.match(pattern))

				{
					if(originatorUserId != currentUserId)
					{
						val +=  '<input disabled="disabled" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients'+nodeId+'[]" value="<?php echo $workPlaceMemberData['userId'];?>" onclick="getRecepientName(this,'+nodeId+')" data-myval="<?php echo $workPlaceMemberData['tagName'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';
					}
					else
					{
						val +=  '<input class="clsCheck'+nodeId+' remove<?php echo $workPlaceMemberData['userId'];?>" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients'+nodeId+'[]" value="<?php echo $workPlaceMemberData['userId'];?>" onclick="getRecepientName(this,'+nodeId+')" data-myval="<?php echo $workPlaceMemberData['tagName'];?>" /><?php echo $workPlaceMemberData['tagName'];?><br>';
					}
					
				}

				<?php

				$i++;	

			}

		

			?>

			<?php

		}?>

		document.getElementById('showMan'+nodeId).innerHTML = val;

		document.getElementById('showMan'+nodeId).style.display = 'block';

		var list = $("#list"+nodeId).val();

		var val1 = list.split(",");

		

		$(".clsCheck"+nodeId).each(function(){

			 if(val1.indexOf($(this).val())!=-1){

				$(this).attr("checked",true);

			 }

		});

	}

	else

	{

		document.getElementById('showMan'+nodeId).style.display = 'none';

	}



}
	
function addSelectionDisplayItem(data,value,changedItem,nodeId)
{
		$('.sol-current-selection').append('<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+','+nodeId+',1); ">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>');
		
}

function removeSelectionDisplayItem(value,nodeId,uncheck)
{
	$('.sol_check'+value).remove();
		
		if(uncheck=='1')
		{
			$('.remove'+value).prop('checked', false);
			
			val = $("#list"+nodeId).val();
			
			val1 = val.split(",");	
			
			var index = val1.indexOf($('.remove'+value).val());
			
			val1.splice(index, 1);	

			var arr = val1.join(",");
			
			$("#list"+nodeId).val(arr);
			
		}
		
}

$(document).ready(function(){
	$('.sol-current-selection').html('<?php echo $content; ?>');
	$('.sol-current-selection-groups').html('<?php echo $groupContent; ?>');
});

function clearUserLabels()
{
	$('.sol-current-selection').html('<?php echo $content; ?>');
	$('.sol-current-selection-groups').html('<?php echo $groupContent; ?>');
}		

//Group feature function start

function searchEditGroups(nodeId,originatorUserId,currentUserId)
{
	//alert(originatorUserId+'======='+currentUserId);
	
	
   	var toMatch = document.getElementById('searchEditGroup'+nodeId).value;
	
	if(originatorUserId != currentUserId)
	{
		var val = '<input disabled="disabled" type="checkbox" name="checkAll" id="checkAll'+nodeId+'" onclick="checkAllFunction('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}
	else
	{
		var val = '<input type="checkbox" name="checkAllGroup" id="checkAllGroup'+nodeId+'" onclick="checkAllGroupsEdit('+nodeId+');" /><?php echo $this->lang->line('txt_All');?><br />';
	}

	//if (toMatch!='')

	if(1)

	{

		var count = '';

		var sectionChecked = '';

		<?php

		$i=1;

		foreach($groupList as $keyVal=>$groupData)
		{
			$groupAllUsersList	= $this->identity_db_manager->getGroupUsersListByGroupId($groupData['groupId']);			
									
			?>

				var str = '<?php echo $groupData['groupName']; ?>';

				var pattern = new RegExp('\^'+toMatch, 'gi');
			

				if (str.match(pattern))

				{
					if(originatorUserId != currentUserId)
					{
						val +=  '<input disabled="disabled" type="checkbox" id="groupRecipients_<?php echo $i;?>" name="groupRecipients'+nodeId+'[]" value="<?php echo $groupData['groupId'];?>" onclick="getGroupName(this,'+nodeId+')" data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>"/><?php echo $groupData['groupName'];?><br>';
					}
					else
					{
						val +=  '<input class="clsCheckGroup'+nodeId+' removeGroup<?php echo $groupData['groupId'];?>" type="checkbox" id="groupRecipients_<?php echo $i;?>" name="groupRecipients'+nodeId+'[]" value="<?php echo $groupData['groupId'];?>" onclick="getGroupName(this,'+nodeId+')" data-myval="<?php echo $groupData['groupName'];?>" data-myusers="<?php echo $groupAllUsersList;?>"/><?php echo $groupData['groupName'];?><br>';
					}
					
				}

				<?php

				$i++;	

			?>

			<?php

		}?>

		document.getElementById('showManGroup'+nodeId).innerHTML = val;

		document.getElementById('showManGroup'+nodeId).style.display = 'block';

		var list = $("#listGroup"+nodeId).val();

		var val1 = list.split(",");

		

		$(".clsCheckGroup"+nodeId).each(function(){

			 if(val1.indexOf($(this).val())!=-1){

				$(this).attr("checked",true);

			 }

		});

	}

	else

	{

		document.getElementById('showManGroup'+nodeId).style.display = 'none';

	}



}

//Group feature function end	
	
</script>