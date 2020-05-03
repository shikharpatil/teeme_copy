<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Create Space</title>
<?php $this->load->view('common/view_head.php');?>


	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

function showFilteredManagers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showManagers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

			<?php
			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	
			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'] && $workPlaceMemberData['userGroup']>0)

				{

			?>

					var str = '<?php echo $workPlaceMemberData['tagName']; ?>';
		
					
		
					var pattern = new RegExp('\^'+toMatch, 'gi');
		
					if (str.match(pattern))
		
					{
		
						val +=  '<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';
		
						document.getElementById('showMan').innerHTML = val;
		
					}

        

			<?php

				}

        	}

        	?>
			var list = $("#managerslist").val();
			var val1 = list.split(",");
			
			$(".mngrs").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});


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

			

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>
//Manoj: replace mysql_escape_str function
			var str = '<?php echo $this->db->escape_str($workPlaceMemberData['tagName']); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

}

</script>

</head>

<body>
		<!--Added by Dashrath- Add two div -->
		<div id="wrap1">
		    <div id="header-wrap">
				<?php $this->load->view('common/header'); ?>
				<?php $this->load->view('common/wp_header'); ?>
			</div>
		</div>

			<!-- Main menu -->

			<?php
			/*

			$workSpaces = $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			
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
			//if ($_SESSION['workPlacePanel'] != 1)
			//{
				//$this->load->view('common/artifact_tabs', $details);

			//}
			$this->load->view('common/artifact_tabs', $details);
			*/
			?>

			
<!--Changed by Dashrath- remove inline style="padding:20px 0px 40px" from container div-->
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">

			<?php
			//echo "<pre>members= "; print_r ($workPlaceMembers); exit;	
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

				<div class="menu_new" >

           

						  <ul class="tab_menu_new1">
						<!--Manoj: Tabs are showing to placemanager only-->
						<?php
						/*if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
						?>

						<li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>
						
						<?php 
						}*/
						?>
						<!--Manoj: Tabs are showing to placemanager only end-->
						<li><a href="<?php echo base_url()?>create_workspace" class="active"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>
	
						<!--Manoj: Tabs are showing to placemanager only-->
						<?php
						/*if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
						?>
						<li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

							<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
						<?php 
						}*/
						?>
						<!--Manoj: Tabs are showing to placemanager only end-->

                        	<?php /*?><li><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>

						</ul>		

					<div class="clr"></div>

					</div>

				<?php
				//}
				?>	
				
				

				<form name="frmWorkPlace" action="<?php echo base_url();?>create_workspace/add" method="post" onSubmit="return validateWorkSpace(this)">

				<input value="<?php echo $_SESSION['userId'];?>" id="managerslist" type="hidden" name="managerslist" />
				<?php if($allowStatus==1){ ?>
				<input value="1,3,4,6,5" id="treeTypeList" type="hidden" name="treeTypeList" />
				<?php }else{ ?>
				<input value="1,3,4,5" id="treeTypeList" type="hidden" name="treeTypeList" />
				<?php } ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:1%;">
				
				
				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	
				
				<?php

				

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	
			  
			  	<?php if(!isset($_SESSION['workPlacePanel'])){ ?>

				<tr>
					<!--Step 1 of 2: -->
                    <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Create_Workspace').':';?></td>

		      	</tr>
				<?php } ?>		  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center" >

                     <tbody>
				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td colspan="3" class="tdSpace"><span class="errorMsg">Error: <?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>						                  

                       <tr>

                         <td width="100" align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Workspace_Name');?><span class="text_red">*</span></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="485" align="left" class="text_gre">

                           <input name="workSpaceName" class="text_gre1" id="workSpaceName" size="30" value=""/>&nbsp;<span id="workPlaceStatusText"></span>
							
                         </td>

                       	</tr>
						<?php /*?><tr>
							<td colspan="3">
								<div class="spacedottedLine">
									<div class="spaceHrLine"></div>
								</div>
							</td>
						</tr><?php */?>
						
						<!--Manoj: comment remove start-->
							<tr>
	
							 <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Workspace_Managers');?></td>
	
							 <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
	
							 <td align="left" class="text_gre">
	
								<input type="text" id="showManagers" name="showManagers" onkeyup="showFilteredManagers()"/> 
	
							 </td>
	
							</tr>
							
							<!--Manoj: comment remove end-->
							<!--Manoj: comment code start-->
						<?php
						
						/*
						   <tr>
	
							 <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Space_Members');?><span class="text_red">*</span></td>
	
							 <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>
	
							 <td align="left" class="text_gre">
	
								<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/> 
	
							 </td>
	
						   </tr>
						<?php
						}*/
						?>
					   <!--Manoj: comment code end-->

                       <tr>

                       	<td align="right" valign="top" class="text_gre1">&nbsp;</td>

                        <td width="5" align="center" valign="middle" class="text_gre">&nbsp;</td>

                        <td align="left" class="text_gre">
						
						<input type="checkbox" name="members" value="0"  class="allcheck" id="checkAll"/> <?php echo $this->lang->line('txt_All');?><br />
						
						 <!--Manoj: comment remove start-->
						 			<input type="hidden" class="mngrs" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>"/> 
                    				<input type="checkbox" class="mngrs originatorUser" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked" disabled="disabled" /> 
									<?php echo $currentUserDetails['tagName'];?><br />    
							<div id="showMan" style="height:120px; width:300px; overflow:scroll;">

            				<?php	

							//echo "<pre>members= "; print_r ($workPlaceMembers); exit;				

							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)

							{

								//if((in_array($workPlaceMemberData['userId'],$managerIds)))
								if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $workPlaceMemberData['userGroup']>0)

								{						

							?>

                    				<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>" <?php if(in_array($workPlaceMemberData['userId'],$managerIds)) { echo 'checked'; } ?>/> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								}

							}

							?>

    						</div>
							<!--Manoj: comment remove start-->
							<!--Manoj: comment code start-->
						<?php
						
						/*
						else
						{
						?>
									<input type="hidden" class="mngrs" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>"/> 
						 			<input type="hidden" class="mngrs" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>"/> 
                    				<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked" disabled="disabled" /> 
									<?php echo $currentUserDetails['tagName'];?><br />                        

                        <div id="showMem" style="height:120px; width:300px; overflow:scroll;">

	           				<?php			
							
							foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)
							{

								if($_SESSION['userId'] != $workPlaceMemberData['userId'])

								{						

							?>

                    				<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/> 

									<?php echo $workPlaceMemberData['tagName'];?><br />

							<?php

								}

							}

							?>

    					</div> 
						<?php
						}*/
						?>
						<!--Manoj: comment code end-->
                        </td>

                       </tr>
					   
					   <?php /*?><tr>
								<td colspan="3">
									<div class="spacedottedLine">
										<div class="spaceHrLine"></div>
									</div>
								</td>
						</tr><?php */?>
					   
					   
					   <?php

						//if(isset($_SESSION['workPlacePanel']))

						//{

						?>
						

					    <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Content_can_be_created');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="radio" name="treeAccess" value="0"  <?php  if($workSpaceDetails['treeAccess']==0 ) echo 'checked="checked"'; ?>   /><?php echo $this->lang->line('txt_Space_Managers');?>

							<input type="radio" name="treeAccess" value="1" <?php  if($workSpaceDetails['treeAccess']==1 ) echo 'checked="checked"'; ?>  /><?php echo $this->lang->line('txt_All_Members');?>

							

                         </td>

                       </tr>
					   
					   <!--Space tree configuration start-->
						
						 <tr style="margin-top:1%;">

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Content_that_can_be_created');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">
							<div style="width:410px; height:23px;">
								<?php /*?><div><input type="checkbox" name="checkAllTreeTypes" id="checkAllTreeTypes" onclick="checkAllTreeTypes();"><?php echo $this->lang->line('txt_All');?></div><?php */?>
								<span><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="1" checked="checked"/><?php echo $this->lang->line('txt_Document');?></span>
								<span><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="3" checked="checked"/><?php echo $this->lang->line('txt_Discussion');?></span>
								<span><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="4" checked="checked"/><?php echo $this->lang->line('txt_Task');?></span>
								<?php if($allowStatus==1){ ?>
								<span><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="6" checked="checked"/><?php echo $this->lang->line('txt_Notes');?></span>
								<?php } ?>
								<span><input type="checkbox" class="spaceTreeCls" name="spaceTreeOptions[]" value="5" checked="checked"/><?php echo $this->lang->line('txt_Contact');?> </span>						
							</div>
                         </td>

                       </tr>
					   
					  <?php /*?> <tr style="margin-top:2%;">

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Show_content_disabled_tree');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">
							<div >
								<div><input type="checkbox" class="showTreeContent" name="showTreeContent" value="1" /><span class="clsLabel"><?php echo $this->lang->line('txt_check_to_show');?></span></div>
							</div>
                         </td>

                       </tr><?php */?>
						
						<!--Space tree configuration end-->
					   
					   	<?php /*?><tr>
								<td colspan="3">
									<div class="spacedottedLine">
										<div class="spaceHrLine"></div>
									</div>
								</td>
						</tr><?php */?>

					   <?php // } ?>
<?php
/*
                        <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_tree_access');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="radio" name="treeAccess" value="0"  checked="checked" /><?php echo $this->lang->line('txt_Space_Managers');?>

							<input type="radio" name="treeAccess" value="1" /><?php echo $this->lang->line('txt_All_Members');?>

							

                         </td>

                       </tr>
				   
                        <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Create_Trees');?></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

							<div style="font-size:22px; padding:10px 0;"><a class="active" href="#">Document</a></div>
							<div class="docLabel">Document Title:</div>
							<div class="docTextDiv"><textarea id="documentTitle"></textarea></div>
							<div style="padding-left:40px;" class="clr"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a><span style="padding:0 0 0 5px;"><a href="#">Add more..</a></span></div>
							<div style="font-size:22px; padding:10px 0;" class="clr"><a href="#">Discuss</a></div>
							<div class="docLabel">Discuss Title:</div>
							<div class="docTextDiv"><textarea id="discussTitle"></textarea></div>
							<div style="padding-left:40px;" class="clr"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a><span style="padding:0 0 0 5px;"><a href="#">Add more..</a></span></div>
							<div style="font-size:22px; padding:10px 0" class="clr"><a href="#">Task</a></div>
							<div style="font-size:22px; padding:10px 0"><a href="#">Notes</a></div>
							<div style="font-size:22px; padding:10px 0"><a href="#">Contact</a></div>					

							

                         </td>

                       </tr>
*/
?>	
                       
					    <tr>
				   			<td align="right" valign="top" class="text_gre1"></td>

                         	<td width="5" align="center" valign="middle" class="text_gre"></td>

                         	<td align="left" class="text_gre">
								<div>
									<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
									<input name="submit" type="submit" id="submit" value="<?php echo $this->lang->line('txt_Done');?>">
									<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
								</div>
				  			</td>

			    		</tr>

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				<!--Comment for old button view-->

			    <?php /*?><tr>
				  <td></td>
				  <td >
				  	<div>
						<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
						<input name="submit" type="submit" id="submit" value="<?php echo $this->lang->line('txt_Done');?>">
						<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(0)">
					</div>
				  </td>

			    </tr><?php */?>

			  </table>		

		 			 </form>

					 

				</div>

			<!--Added by Dashrath- load notification side bar-->
			<?php $this->load->view('common/notification_sidebar.php');?>
			<!--Dashrath- code end-->


			</div>	 
				<?php $this->load->view('common/foot.php');?>
			<!-- Footer -->	

				<?php //$this->load->view('common/footer');?>

			<!-- Footer -->

    

</body>
</html>
<script>
//On single checkbox click myspace start

//$('.mngrs').live("click",function()
$(document).on('click', '.mngrs', function(){
		//alert('dfsd');
		val = $("#managerslist").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#managerslist").val()==''){

				$("#managerslist").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#managerslist").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#managerslist").val(arr);
			}

		}

	});
<!--Space tree type config script start-->
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
//Space tree config all check
function checkAllTreeTypes()
{
	
		if($("#checkAllTreeTypes").prop("checked")==true){

			$('.spaceTreeCls').prop("checked",true);

			$(".spaceTreeCls").each(function(){

				value = $("#treeTypeList").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#treeTypeList").val(value+","+$(this).val());

				}
			});
		}
		else{

			//change prop to attr for server - Monika

			$('.spaceTreeCls').prop("checked",false);

			$(".spaceTreeCls").each(function(){

				value = $("#treeTypeList").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#treeTypeList").val(arr);

			});
		}

}
<!--Space tree type config script end-->

$(function() {

	$("input[type='checkbox']").click(function(){

		if($(this).hasClass('allcheck')){
			
			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".mngrs").prop( "checked" ,true);
			
			$(".mngrs").each(function(){

				value = $("#managerslist").val();

				val1 = value.split(",");	
				
				if(val1.indexOf($(this).val())==-1){

					$("#managerslist").val(value+","+$(this).val());

				}
			});

		}

		else if($(this).hasClass('allUncheck')){
			
			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".mngrs").prop('checked',false);
			
			$(".mngrs").each(function(){

				value = $("#managerslist").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#managerslist").val(arr);

			});
			
			$("#managerslist").val('<?php echo $_SESSION['userId']; ?>');
			
			$(".originatorUser").prop('checked',true);

		}

	});

	

});

</script>