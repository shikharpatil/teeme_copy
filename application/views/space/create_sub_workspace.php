<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Teeme > Create Sub Space</title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

</script>



<script language="JavaScript1.2">



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

			if ($workPlaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}



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

				val +=  '<input type="checkbox" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

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

				/*if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/><?php echo $this->lang->line('txt_Me');?><br>';

				}*/

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					//val +=  '<input type="checkbox" class="mngrs originatorUser" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked"/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}



			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			

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

			var list = $("#managerslist").val();
			var val1 = list.split(",");
			
			$(".mngrs").each(function(){
				 if(val1.indexOf($(this).val())!=-1){
					$(this).attr("checked",true);
				 }
			});

		}

}

</script>	

	

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>



<!-- Main menu -->

			<?php
			/*
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
			*/
			//space managers list
			
			/*$managerIds = array();

					foreach($workSpaceManagers as $managersData)

					{

						$managerIds[] = $managersData['managerId'];

					}*/

			 ?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
	<?php
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

					<form name="frmWorkSpace" action="<?php echo base_url();?>create_sub_work_space/add" method="post"  onSubmit="return validateSubWorkSpace(this)">

				
					<input value="<?php echo $_SESSION['userId'];?>" id="managerslist" type="hidden" name="managerslist" />
					
					<?php if($allowStatus==1){ ?>
					<input value="1,3,4,6,5" id="treeTypeList" type="hidden" name="treeTypeList" />
					<?php }else{ ?>
					<input value="1,3,4,5" id="treeTypeList" type="hidden" name="treeTypeList" />
					<?php } ?>
					
					
				 	

							<div class="menu_new" >

            				<ul class="tab_menu_new1">

							 <li><a href="<?php echo base_url()?>edit_workspace/index/<?php echo $workSpaceId;?>"><span><?php echo $this->lang->line('txt_Edit_Workspace');?></span></a></li>

                        		<li><a href="<?php echo base_url()?>view_sub_work_spaces/index/<?php echo $workSpaceId;?>/1"><span><?php echo $this->lang->line('txt_View_Sub_Workspaces');?></span></a></li>

                        		<li><a href="<?php echo base_url();?>create_sub_work_space/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>"  class="active"><span><?php echo $this->lang->line('txt_Create_Sub_Workspace');?></span></a></li>

   						      <?php /*?>	<li><a href="<?php echo base_url()?>help/space_manager/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Help');?></span></a></li><?php */?>
							  
						<!--Manoj: created help icon-->	
						<div class="help_box">
						<a href="<?php echo $this->config->item('help_doc_url'); ?>?lang=<?php echo $_COOKIE['lang']; ?>&id=space" target="_blank">
								<img src="<?php echo base_url()?>images/help_new.png" title="help" class="help_icon">
						</a>
						</div>
						<!--Manoj: code end-->

                            </ul>

						<div class="clr"></div>

						</div>

						

					

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:1%;">		

				<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

					  <tr>

				    <td colspan="2" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td><td width="55%">&nbsp;</td></tr>

				<?php

				}

				

				?>	

				  

				  <tr>

                    <td class="subHeading" colspan="3"><?php echo $this->lang->line('txt_Sub_Space_Details');?></td>

		      </tr>

				  				

				<tr>

					<td width="25%" class="tdSpace">&nbsp;</td>

					<td>&nbsp;</td>	

				</tr>

				 <tr>

				   <td colspan="3" class="tdSpace">					

					<table width="90%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                     <tbody>                    

                       <tr>

                         <td width="29%" align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Sub_Space_Name');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="69%" align="left" class="text_gre">

                           <input name="workSpaceName" class="text_gre1" id="workSpaceName" size="30" value="" />&nbsp;<span id="workPlaceStatusText"></span>

                         </td>

                       </tr>

                       

                       <tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Assign_Sub_Space_Members');?></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre">

                         	<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/> 

                         </td>

                       </tr>

                       <tr>

                         <td align="left" valign="middle" class="text_gre1">&nbsp;</td>

                         <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                         <td align="left" class="text_gre">

                         <?php

						 /*

                         <select name="workSpaceMembers[]" id="workSpaceMembers[]" multiple>   

						<option value="<?php echo $_SESSION['userId'];?>" selected><?php echo $this->lang->line('txt_Me');?></option>                      

						<?php						

						foreach($workSpaceMembers as $keyVal=>$workSpaceMemberData)

						{	

							if($workPlaceMemberData['userId'] != $_SESSION['userId'])

							{	

							?>

								<option value="<?php echo $workSpaceMemberData['userId'];?>"><?php echo $workSpaceMemberData['userTagName'];?></option>

					   		<?php

							}		

						}

						?>

                         </select>

						 */

						 ?>



                        <input type="checkbox" name="members" value="0"  class="allcheck" id="checkAll"/> <?php echo $this->lang->line('txt_All');?><br />
						
						<input type="checkbox" class="mngrs originatorUser" name="workSpaceMembers[]" value="<?php echo $_SESSION['userId'];?>" checked="checked" disabled="disabled"/> <?php echo $this->lang->line('txt_Me');?><br />

                        <div id="showMem" style="height:120px; width:300px; overflow:scroll;">

        					

            				<?php	

											

							foreach($workSpaceMembers as $keyVal=>$workPlaceMemberData)

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

						 </td>

                       </tr>

					   
						<!--Subspace tree configuration start-->
						
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
					   
					   <!--Subspace tree configuration end-->

					   <tr>

                         <td align="left" valign="top" class="text_gre1"></td>

                         <td width="5" align="center" valign="middle" class="text_gre"></td>

                         <td align="left" class="text_gre"><input name="Submit" type="submit" id="Submit" value="Add" class="button01">
						 
						  <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-1)">

						 <input type="hidden" name="workSpaceId" id="workSpaceId" value="<?php echo $workSpaceDetails['workSpaceId'];?>">

		<input type="hidden" name="workSpaceType" id="workSpaceType" value="<?php echo $workSpaceType;?>">	

	    </form>

                         

                         </td>

                       </tr>

                     </tbody>

                   </table>

							 

				   </td>

			    </tr>

				 <tr>

				   <td class="subHeading" colspan="3">&nbsp;</td>

		      </tr>

				

			   

			  </table>		

		

				<!-- Main Body -->

				

    

</div>

		<!--Added by Dashrath- load notification side bar-->
		<?php $this->load->view('common/notification_sidebar.php');?>
		<!--Dashrath- code end-->
</div>

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

</body>
</html>		
<script>
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

//Code end	
</script>