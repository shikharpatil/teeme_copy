<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Edit Sub Space</title>

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

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile" >



		<div id="content">

			<!-- Main menu -->

			

		

		  

		 

           

                

                

					<!-- Main Body -->

					<?php

					$memberIds = array();

					foreach($subWorkSpaceMembers as $membersData)

					{

						$memberIds[] = $membersData['userId'];

					}

					$managerIds = array();

					foreach($subWorkSpaceManagers as $managersData)

					{

						$managerIds[] = $managersData['managerId'];

					}
					
					//subworkspace originator id
					$originatorId = $subWorkSpaceDetails['subWorkSpaceManagerId'];
					
					//space tree config ids
					$treeTypeConfigIds = array();

					foreach($spaceTreeDetails as $spaceTreeData)

					{

						$treeTypeConfigIds[] = $spaceTreeData['tree_type_id'];

					}

					?>

    <script type="text/javascript">

	function showFilteredManagers()

	{

	//alert ('Here');

	var toMatch = document.getElementById('showManagers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" <?php if(in_array($_SESSION['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" <?php if(in_array($_SESSION['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}



			foreach($workSpaceMembers as $keyVal=>$workSpaceMemberData)	

			{

				if ($workSpaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>
			//Manoj: replace mysql_escape_str function
			var str = '<?php echo $this->db->escape_str($workSpaceMemberData['tagName']); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $workSpaceMemberData['userId'];?>" <?php if(in_array($workSpaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/><?php echo $workSpaceMemberData['tagName'];?><br>';

				document.getElementById('showMan').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

	}

	function showFilteredMembers()

	{

	//alert ('Here');

	var toMatch = document.getElementById('showMembers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workPlaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" <?php if(in_array($_SESSION['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($_SESSION['userId']==$originatorId) { echo 'disabled="disabled"'; } ?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" <?php if(in_array($_SESSION['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($_SESSION['userId']==$originatorId) { echo 'disabled="disabled"'; } ?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}



			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'] && (in_array($workPlaceMemberData['userId'],$memberIds)))

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			var pattern = new RegExp('\^'+toMatch, 'gi');



			if (str.match(pattern))

			{

				val +=  '<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($workPlaceMemberData['userId']==$originatorId) { echo 'disabled="disabled"'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'] && !(in_array($workPlaceMemberData['userId'],$memberIds)))

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($workPlaceMemberData['userId']==$originatorId) { echo 'disabled="disabled"'; } ?>/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>

			var list = $("#memberslist").val();
			var val1 = list.split(",");
			
			$(".members").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});

		}

	}

	</script>

			<form name="frmWorkSpace" action="<?php echo base_url();?>edit_sub_work_space/update" method="post"  onSubmit="return validateSubWorkSpace(this)">

            <?php 
			
			$spaceMembersList = implode(",",$memberIds); 
			
			$treeTypeConfigLists = implode(",",array_filter($treeTypeConfigIds)); 
			
			?>
			
			<input value="<?php echo $spaceMembersList ?>" id="memberslist" type="hidden" name="memberslist" />
			
			<input value="<?php echo $treeTypeConfigLists; ?>" id="treeTypeList" type="hidden" name="treeTypeList" />

				<?php

				if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId, 3))

				{

				?>

				 <div class="menu_new" >

           

						 <ul class="tab_menu_new1">

							 <li><a href="<?php echo base_url()?>edit_workspace/index/<?php echo $workSpaceId;?>"><span><?php echo $this->lang->line('txt_Edit_Workspace');?></span></a></li>

                        		<li><a href="<?php echo base_url()?>view_sub_work_spaces/index/<?php echo $workSpaceId;?>/1" class="active"><span><?php echo $this->lang->line('txt_View_Sub_Workspaces');?></span></a></li>

                        		<li><a href="<?php echo base_url();?>create_sub_work_space/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Create_Sub_Workspace');?></span></a></li>

				                	<!--<li><a href="<?php //echo base_url()?>contact/importContact/0/<?php //echo $workSpaceId;?>/type/<?php //echo $workSpaceType;?>"><span><?php //echo $this->lang->line('txt_Bulk_Contacts');?></span></a></li>-->

   						      	<?php /*?><li><a href="<?php echo base_url()?>help/space_manager/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
								
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=space" target="_blank">
								<img src="<?php echo base_url()?>images/help.gif" title="help" class="help_icon">
						</a>
						</div>
						<!--Manoj: code end-->

                            </ul>
				      </ul>

	

				<div class="clr"></div>

					</div>

				<?php

				}

				?>	

                <?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

                  <td colspan="2" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                  <td width="55%">&nbsp;</td>

                </tr>

                <?php

				}

				

				?>

				  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5%;">

                <tr>

                  <td class="subHeading" colspan="3"><?php echo $this->lang->line('subspace_details_txt'); ?></td>

                </tr>

                <tr>

                  <td width="25%" class="tdSpace">&nbsp;</td>

                  <td>&nbsp;</td>

                </tr>

                <tr>

                  <td colspan="3" class="tdSpace">

                    <table width="80%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="205" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('subspace_name_txt'); ?></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td width="485" align="left" class="text_gre">

                            <input name="workSpaceName" class="text_gre1" id="workSpaceName" size="20" value="<?php echo $subWorkSpaceDetails['subWorkSpaceName'];?>">

            &nbsp;<span id="workPlaceStatusText"></span> </td>

                        </tr>



                        

                       <tr>

                         <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Add_Workspace_Members');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/> 

                         </td>

                       </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">
						  
						  <input type="checkbox" name="members" value="0"  class="allcheck" id="checkAll"/> <?php echo $this->lang->line('txt_All');?><br />

                        	<div id="showMem" style="height:120px; width:300px; overflow:scroll;">

        					<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" <?php if(in_array($_SESSION['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($_SESSION['userId']==$originatorId) { echo "disabled='disabled'"; } ?> /> <?php echo $this->lang->line('txt_Me');?><br />

            				<?php	

											

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

							{

								if($_SESSION['userId'] != $workPlaceMemberData['userId'] && (in_array($workPlaceMemberData['userId'],$memberIds)))

								{						

							?>

                    				<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds)) { echo 'checked'; } ?> <?php if($workPlaceMemberData['userId']==$originatorId) { echo "disabled='disabled'"; } ?> /> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								}

							}



							foreach($workSpaceMembers as $keyVal=>$workPlaceMemberData)

							{

								if($_SESSION['userId'] != $workPlaceMemberData['userId'] && !(in_array($workPlaceMemberData['userId'],$memberIds)))

								{						

							?>

                    				<input class="members" type="checkbox" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$memberIds)) { echo 'checked'; } ?>/> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								}

							}

							

							?>

    						</div>

                          

                          </td>

                        </tr>
						
						<!--subspace tree configuration start-->
						<?php if($originatorId==$_SESSION['userId']) { ?>
						 <tr style="margin-top:1%;">

                         <td align="right" valign="top" class="text_gre1" style="padding-top:5%;"><?php echo $this->lang->line('txt_Assign_Workspace_Tree_Type');?></td>

                         <td width="5" align="center" valign="top" class="text_gre" style="padding-top:5%;"><strong>:</strong></td>

                         <td align="left" class="text_gre" style="padding-top:5%;">
							<div style="width:410px;">
								<?php /*?><div><input type="checkbox" name="checkAllTreeTypes" id="checkAllTreeTypes" onclick="checkAllTreeTypes();"><?php echo $this->lang->line('txt_All');?></div><?php */?>
								<?php 
														
								foreach($spaceTreeDetails as $keyVal=>$spaceTreeTypeIds)
								{
									$treeTypeIds[] = $spaceTreeTypeIds['tree_type_id'];
								}
								//print_r($treeTypeIds);
								?>
									<div <?php if(!(in_array('1',$treeTypeIds))) { ?> style="display:none;" <?php } ?> " ><input <?php if(in_array('1',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="1" /><?php echo $this->lang->line('txt_Document');?></div>
									<div <?php if(!(in_array('3',$treeTypeIds))) { ?> style="display:none;" <?php } ?> "><input <?php if(in_array('3',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="3" /><?php echo $this->lang->line('txt_Discuss');?></div>
									<div <?php if(!(in_array('4',$treeTypeIds))) { ?> style="display:none;" <?php } ?> "><input <?php if(in_array('4',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="4" /><?php echo $this->lang->line('txt_Task');?></div>
									<?php if($allowStatus==1){ ?>
									<div <?php if(!(in_array('6',$treeTypeIds))) { ?> style="display:none;" <?php } ?> "><input <?php if(in_array('6',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="6" /><?php echo $this->lang->line('txt_Notes');?></div>
									<?php } ?>
									<div <?php if(!(in_array('5',$treeTypeIds))) { ?> style="display:none;" <?php } ?> "><input <?php if(in_array('5',$treeTypeIds)) { echo 'checked'; } ?> type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="5" /><?php echo $this->lang->line('txt_Contact');?> </div>
									
									<div <?php if(!(in_array('1',$treeTypeIds))) { ?> style="display:block; " <?php } else { ?> style="display:none;" <?php } ?> ><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="1" /><?php echo $this->lang->line('txt_Document');?> </div>
									<div <?php if(!(in_array('3',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="3" /><?php echo $this->lang->line('txt_Discuss');?> </div>
									<div <?php if(!(in_array('4',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="4" /><?php echo $this->lang->line('txt_Task');?> </div>
									<?php if($allowStatus==1){ ?>
									<div <?php if(!(in_array('6',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="6" /><?php echo $this->lang->line('txt_Notes');?></div>
									<?php } ?>
									<div <?php if(!(in_array('5',$treeTypeIds))) { ?> style="display:block; " <?php }  else { ?> style="display:none;" <?php } ?>><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="5" /><?php echo $this->lang->line('txt_Contact');?> </div>
							</div>
                         </td>

                       </tr>
					   <?php } ?>
					   <!--subspace tree configuration start-->

                      </tbody>

                  </table></td>

                </tr>

                <tr>

                  <td class="subHeading" colspan="3">&nbsp;</td>

                </tr>

                <tr>

                  <td width="2%">&nbsp;</td>

				 <td width="2%">&nbsp;</td>

					
				  <td width="94%">
				  
				  <input name="Submit" type="submit" id="Submit" value="Update" class="button01">
				  
				  <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-2)">	
				  </td>

                </tr>

              </table>

              <input type="hidden" name="subWorkSpaceId" id="subWorkSpaceId" value="<?php echo $subWorkSpaceId;?>">

              <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $subWorkSpaceDetails['workSpaceId'];?>">

			 <input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">	
			 
			 <input value="1" id="editSubWorkSpace" type="hidden" name="editSubWorkSpace" />
			 
			 <input value="<?php if($originatorId==$_SESSION['userId']){ echo '1'; }else{ echo '0'; } ?>" id="editSubWorkSpaceAlert" type="hidden" name="editSubWorkSpaceAlert" />

            </form>

				<!-- Main Body -->

				<!-- Right Part-->			

				<!-- end Right Part -->

				

            

         

   

</div>

</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>	

<script>

//$('.members').live("click",function()
$(document).on('click', '.members', function(){
		//alert('dfsd');
		val = $("#memberslist").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#memberslist").val()==''){

				$("#memberslist").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#memberslist").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#memberslist").val(arr);
			}

		}

	});	
<!--subspace tree type config script start-->
//$('.spaceTreeCls').live("click",function()
$(document).on('click', '.spaceTreeCls', function(){
		//alert('dfsd');
		val = $("#treeTypeList").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#treeTypeList").val()==''){

				$("#treeTypeList").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#treeTypeList").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#treeTypeList").val(arr);
			}

		}

	});
	
//Select all checkbox code start

$(function() {

	$("input[type='checkbox']").click(function(){

		if($(this).hasClass('allcheck')){
			
			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".members").prop( "checked" ,true);
			
			$(".members").each(function(){

				value = $("#memberslist").val();

				val1 = value.split(",");	
				
				if(val1.indexOf($(this).val())==-1){

					$("#memberslist").val(value+","+$(this).val());

				}
			});

		}

		else if($(this).hasClass('allUncheck')){
			
			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".members").prop('checked',false);
			
			$(".members").each(function(){

				value = $("#memberslist").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#memberslist").val(arr);
				
				if($(this).is(":disabled")) 
				{
					$(this).prop('checked',true);
				}

			});
			
			$(".members").each(function(){
			
				if($(this).is(":disabled")) 
				{
					value = $("#memberslist").val();
	
					val1 = value.split(",");	
	
					if(val1.indexOf($(this).val())==-1){
	
						$("#memberslist").val(value+","+$(this).val());
	
					}
				}
			});
		}

	});

	

});

//Code end					

</script>	