<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Create Tree</title>
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

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

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
<div id="wrap1">
  <div id="header-wrap">
			<?php $this->load->view('common/header_for_mobile'); ?>
			<?php $this->load->view('common/wp_header'); ?>
			<?php $this->load->view('common/artifact_tabs_for_mobile');?>
  </div>
</div>			

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
			//if ($_SESSION['workPlacePanel'] != 1)
			//{
				
			//}
			
				$docTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceId,1);
				$chatTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceId,1);
				$taskTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceId,1);
				$notesTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceId,1);
				$conTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceId,1);
				//echo $docTreeTypeStatus.'===';
				if($docTreeTypeStatus!=1 || $workSpaceId==0 || ($workSpaceDetails['workSpaceName']=='Try Teeme' && $workSpaceType==1))
				{
					$docShow = 1;
				}
				else if($docTreeTypeStatus==1 && $chatTreeTypeStatus!=1)
				{
					$chatShow = 1;
				}
				else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus!=1)
				{
					$taskShow = 1;
				}
				else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus!=1)
				{
					$notesShow = 1;
				}
				else if($docTreeTypeStatus==1 && $chatTreeTypeStatus==1 && $taskTreeTypeStatus==1 && $notesTreeTypeStatus==1 && $conTreeTypeStatus!=1)
				{
					$conShow = 1;
				}
			
			?>

			

		<div id="container_for_mobile">

		<div id="content">
		<?php
				if($workSpaceId!=0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2)) {
					$treeTypeEnabled = 1;	
				}
			 if(!empty($spaceTreeDetails) || $workSpaceId==0 || ($workSpaceDetails['workSpaceName']=='Try Teeme' && $workSpaceType==1)){ ?>
			<div>
				<form id="frmCreateTree" name="frmCreateTree" action="<?php echo base_url();?>new_tree/create_tree" method="post">
				<input value="<?php echo $_SESSION['userId'];?>" id="list" type="hidden" />
				<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

				 <tr>

				   <td class="tdSpace">					

					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center">               
                       
					    <tr>
					   
					     <th colspan="3" align="left" valign="middle" class="text_gre1 createNewTreeTxtMob"><img src="<?php echo base_url();?>images/addnew.png"  title="Notes" style="margin-top:5px;cursor:pointer;height:15px;border:0px;" /> <?php echo $this->lang->line('txt_Create_Tree');?><strong>:</strong></th>

						</tr>
						
						<tr>
					   		 <th width="100" height="15" align="left" valign="middle" class="text_gre1"></th>
						</tr>
										   
					   <tr>
					   
					     <td width="20%" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Select_Tree_Type');?><span class="text_red"></span></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td width="75%" align="left" class="text_gre">
						   	<?php /*?><select name="treeType" id="treeType" onchange="getTreeTypeVal();">
								
								<option <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" disabled="disabled" <?php } ?> value="document"><?php echo $this->lang->line('txt_Document');?></option>
								
								<option <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" disabled="disabled" <?php } ?> value="discuss"><?php echo $this->lang->line('txt_Discuss');?></option>
								
								<option <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" disabled="disabled" <?php } ?> value="task"><?php echo $this->lang->line('txt_Task');?></option>
								
								<option <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" disabled="disabled" <?php } ?> value="notes"><?php echo $this->lang->line('txt_Notes');?></option>
								
								<option <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" disabled="disabled" <?php } ?> value="contact"><?php echo $this->lang->line('txt_Contact');?></option>
							
							</select><?php */?>
							
							<div <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?> ><input type="radio" name="treeType" id="treeType" value="document" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Document');?></div>
							
							<div <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="discuss" onClick="getTreeTypeVal(this)"   ><?php echo $this->lang->line('txt_Discuss');?></div>
							<div <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="task" onClick="getTreeTypeVal(this)"   ><?php echo $this->lang->line('txt_Task');?></div>
							<?php if($notesAllowStatus==1){ ?>
							<div <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="notes" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Notes');?></div>
							<?php } ?>
							<div <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="contact" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Contact');?></div>
							
                         </td>
                       	</tr> 
						
						<tr class="treeBtn" style="display:none;" >

                         <td width="20%" align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Tree_Title');?><span class="text_red"></span></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td width="75%" align="left" class="text_gre"><textarea style="width:95%;" id="treeTitle" name="treeTitle"/></textarea></td>

                       </tr>   
					   
					   <?php 
					  if($workSpaceId!=0){ 
					  ?>
					   <tr class="newTreeContributors" style="display:none;" >
					   		<td align="right" valign="top" class="text_gre1">Contributors</td>
							<td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>
							<td align="left" class="text_gre">
							
							<!--Contributors view start-->
			
								<div>
				
								<div>
				
								<div id="edit_notes" class="<?php echo $seedBgColor;?>" style="width:100%;float:left;" >
				
									<?php //echo $this->lang->line('txt_Search'); ?> 
				
										<form name="frmedit_notes" id="frmedit_notes" method="post" action="">
										
										
										<div style="margin-bottom:10px;">
										<?php echo $this->lang->line('txt_Search'); ?> :
				
										<input type="text" id="showMembers" name="showMembers" onKeyUp="showCreateTreeContributors()"/> 
										</div>
										
				
										<?php /*?><input type="text" id="showMembers" name="showMembers" onKeyUp="showSearchContributors('<?php echo $treeId; ?>')"/> <?php */?>
				
										<input type="hidden" id="myId" name="myId" value="<?php echo $_SESSION['userId'] ;  ?>" />
				
										
				
										<?php
				
										$members='';
				
										/*if ($workSpaceId != 0)
				
										{*/
				
										?>
										<!--Manoj: added if else condition for select all UI for notes and task contributors -->
										<input type="checkbox" name="notesUsers" value="0"  <?php if ($selectAll==1){ echo 'checked="checked"'; echo 'class="allUncheck"';} else { echo 'class="allcheck"';}?> /> <?php echo $this->lang->line('txt_All');?><br>
				
										<?php
				
										//}
				
										?>
				
										<?php	
				
										if($workSpaceId==0)
										{						
				
											foreach($workSpaceMembers as $arrData)
					
											{
					
												if($_SESSION['userId'] != $arrData['userId'] && $arrData['userGroup']>0)
					
												{						
					
													$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"/>'.$arrData['tagName'].'<br>';
					
										   
					
												}
					
											}
				
										}
				
										else
										{
											foreach($workSpaceMembers as $arrData)
											{
												
												if($_SESSION['userId'] != $arrData['userId'])
												{						
													$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"/>'.$arrData['tagName'].'<br>';
												}
											}
				
										}
				
										?>
				
										<div id="showMem" style="max-height: 150px; width:90%;overflow:auto;" class="usersList">
				
										
				
				 
				
									   <input checked="checked"  type="checkbox" id="notesUsers" class="users" name="notesUsers" value="<?php echo $_SESSION['userId'];?>" /> <?php echo $this->lang->line('txt_Me');?><br>
				
									   <?php echo $members;?>
				
										</div> 
				
										<br>
				
										<input name="notesId" id="notesId" type="hidden" value="<?php echo $treeId; ?>"> 
				
										</form>
				
								</div>
				
							</div>
						
							</div>	
			
	
							<!--Contributors view end-->
							
							</td>
					   </tr>
					   <?php } ?>
					   
					                  
                   </table>

							 

				   </td>

			    </tr>



			    <tr class="treeBtn" style="display:none;">

				  	<td align="left" >
						<div class="newTreeCreateBtnMob">
							<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
							<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
							<input name="submit" type="button" id="submit" value="<?php echo $this->lang->line('txt_Create');?>" onclick="createTree();">
							<?php /*?><input name="spaceFinish" type="button" id="spaceFinish" value="Finish" onclick="gotoDashboard();"><?php */?>
						
							<span id="createTreeStatus" style="padding:0 0 0 10px;"></span>
						</div>
					</td>

			    </tr>

			  </table>		

		 	</form>
			
			<!--Contact tree form start here-->
			
			<form id="contactNewForm" name="contactNewForm" method="post" action="<?php echo base_url();?>new_tree/createContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="margin-left:20px; display:none;">
                  
				 
				 <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td colspan="2" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="width:23%"><strong><?php echo $this->lang->line('txt_Company_Details');?></strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_user_full_name');?><span class="text_red">*</span>:</td>
                      <td><input name="company" type="text" id="company_name" value="<?php echo $Contactdetail['company'];?>">
                        </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Website');?>:</td>
                      <td><input name="website" type="text" id="website" value="<?php echo $Contactdetail['website'];?>"></td>
                    </tr>
					<tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Address');?>:</td>
                      <td><textarea name="address" rows="3" id="address" style="width:90%;"><?php echo $Contactdetail['address'];?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Contact'); /*echo $this->lang->line('txt_Personal_Details');*/?> </strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Title');?>: </td>
                      <td align="left"><input name="title" type="text" id="title" value="<?php echo $Contactdetail['title'];?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span>:</td>
                      <td><input name="firstname" type="text" id="first_name" onBlur="displayname();" value="<?php echo $Contactdetail['firstname'];?>">
                        </td>
                    </tr>
                    <tr style="display:none;">
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Middle_Name');?>:</td>
                      <td><input name="middlename" type="text" id="middle_name" onBlur="displayname();" value="<?php echo $Contactdetail['middlename'];?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span>:</td>
                      <td><input name="lastname" type="text" id="last_name" onBlur="displayname();" value="<?php echo $Contactdetail['lastname'];?>">
                        </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Tag_Name');?><span class="text_red">*</span>:</td>
                      <td><input name="display_name" type="text" id="display_name" value="<?php echo $Contactdetail['name'];?>" <?php if($treeId){?> readonly=""<?php }?>>
                        </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Role');?>:</td>
                      <td><input name="designation" type="text" id="designation" value="<?php echo $Contactdetail['designation'];?>"></td>
                    </tr>
					<tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Email');?>:</td>
                      <td><input name="email" type="text" id="email" value="<?php echo $Contactdetail['email'];?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Fax');?>:</td>
                      <td><input name="fax" type="text" id="fax" value="<?php echo $Contactdetail['fax'];?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Mobile');?>:</td>
                      <td><input name="mobile" type="text" id="mobile" maxlength="20" value="<?php echo $Contactdetail['mobile'];?>"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php echo $this->lang->line('txt_Contact_Mobile'); /*echo $this->lang->line('txt_Telephone');*/ ?>:</td>
                      <td><input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>"></td>
                    </tr>
                    
                    
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Status');?></strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php //echo $this->lang->line('txt_Status');?></td>
                      <td style="width:77%" align="left"><textarea name="comments" id="comments" style="width:90%;"><?php echo $Contactdetail['comments'];?></textarea></td>
                    </tr>
                    <?php /*?><tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Contact_Details');?>:</strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Email');?>:</td>
                      <td><input name="email" type="text" id="email" value="<?php echo $Contactdetail['email'];?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Fax');?>:</td>
                      <td><input name="fax" type="text" id="fax" value="<?php echo $Contactdetail['fax'];?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Mobile');?>:</td>
                      <td><input name="mobile" type="text" id="mobile" maxlength="20" value="<?php echo $Contactdetail['mobile'];?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Contact_Mobile');  ?>:</td>
                      <td><input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>"></td>
                    </tr><?php */?>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_contact_notes');?></strong>(Max Length 250 Characters)</td>
                    </tr>
					<tr>
                      <td align="left" valign="top" height="10"></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php //echo $this->lang->line('txt_Other');?></td>
                      <td><textarea name="other" id="other" style="width:90%;"><?php echo $Contactdetail['other'];?></textarea></td>
                    </tr>
                    
					<?php
		  if ($workSpaceId>0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2))
		  {
		  ?>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Access');?></strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">&nbsp;</td>
                      <td colspan="2"><input type="radio" name="sharedStatus" value="2" checked="checked">
                        <?php echo $this->lang->line('txt_Private');?> (<?php echo $this->lang->line('txt_Access_current_space');?>)
						<br />
                        <input type="radio" name="sharedStatus" value="1">
                        <?php echo $this->lang->line('txt_Public');?> (<?php echo $this->lang->line('txt_Access_current_place');?>) 
					</td>
                    </tr>
                    <?php
		  }
		  ?>
					
					<tr>
                      <td align="right" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top">&nbsp;</td>
                      <td><input type="button" name="Submit" value="<?php echo $this->lang->line('txt_Create');?>" class="button01" onclick="validateContactForm();">
						<?php /*?><input type="button" name="cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="document.location='<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';" class="button01"/><?php */?>
                        <input name="reply" type="hidden" id="reply" value="1">
                        <?php
		  		if ($workSpaceId==0 || ($workSpaceDetails['workSpaceName']=='Try Teeme' && $workSpaceType==1))
		  		{
		  		?>
                        <input type="hidden" name="sharedStatus" value="2" >
                        <?php
				}
				?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>

                  </table>
				 
                </form>
			
			<!--Contact tree form end here-->		
				</div>
				<?php } else { ?>
			 <div>
			 	<div class="errorMsg"><?php echo $this->lang->line('txt_Tree_not_allowed'); ?></div>
			 </div>
			<?php } ?>
			</div>
			 <!--Latest tree list start-->
				 <div class="treeList">  
				 </div>
				    <!--Latest tree list end-->	
			</div>	 

				</div></div>	 
				<?php $this->load->view('common/foot_for_mobile');?>
			<!-- Footer -->	

				<?php $this->load->view('common/footer_for_mobile');?>

			<!-- Footer -->

    

</body>

</html>
<script>

var baseUrl 		= '<?php echo base_url();?>';	
var workSpaceId		= '<?php echo $workSpaceId;?>';
var workSpaceType	= '<?php echo $workSpaceType;?>';

function gotoDashboard()
{
	if (document.getElementById("spaceFinish")!=null)
	{
		location.href = "<?php echo base_url();?>dashboard/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1";
		return false;
	}
}

function getTreeTypeVal(thisVal)
{
	var treeType=thisVal.value;
	//var treeType=$("#treeType option:selected").val();
	//alert(treeType);document task notes
	if(treeType=='document' || treeType=='task' || treeType=='notes')
	{
		$("#contactNewForm").hide();
		$(".newTreeContributors").show();
		$(".treeBtn").show();
	}
	else if(treeType=='contact')
	{
		$(".treeBtn").hide();
		$(".newTreeContributors").hide();
		$("#contactNewForm").show();
	}
	else
	{
		$("#contactNewForm").hide();
		$(".newTreeContributors").hide();
		$(".treeBtn").show();
	}
	
	//Clear value of text editor on change tree type
	$("#treeTitle").val('');
	if(document.getElementById('contactNewForm') !== null)
	{
		document.getElementById('contactNewForm').reset();
	}
}

function createTree(){

	//Getting contributors id
	var treeType='';
	//treeType = document.getElementById('treeType').value;
	treeType = $("input[name='treeType']:checked").val();
	var error='';
	if(document.getElementById('treeTitle').value.trim()==''){
			error+='<?php echo $this->lang->line('title_not_empty'); ?>\n';
	}	
	if(error){
			alert(error);
			return false;
	}
	else
	{
	
	var confirmMsg = '<?php echo $this->lang->line('confirm_Msg_Create_Tree');?>';
	var msg = confirmMsg.replace("{treetype}", treeType);

	if (confirm(msg) == 1)
	{

	//var notesId =	document.getElementById('notesId').value;
	var chkedVals = new Array; 
	if(workSpaceId!=0)
	{
		if(document.getElementById('myId').value)
		{
			var myId    =   document.getElementById('myId').value;
		}
		var flag=0;
	
		$('[name=notesUsers]').each(function()
	
			{  
	
				if(this.checked)
	
				{	 
	
					chkedVals.push($(this).val());
	
					if(myId==$(this).val())
	
					flag=1;
	
				}
	
		});
	}
	
	var userslist = $('#list').val();
	
	//Getting contributors id

    $.ajax({
    type: "POST",
    url: baseUrl+"new_tree/create_tree",
    data: jQuery("#frmCreateTree").serialize()+"&editNotes=1&notesUsers="+userslist,
    cache: false,
    success:  function(data){
       /* alert(data); if json obj. alert(JSON.stringify(data));*/
	  // $('#createTreeStatus').html(data);
	  //alert(data);
	  //$('#treeTitle').val('');
	  if(data==1)
	  {
	  	  $('#treeTitle').val('');
		  document.getElementById("frmCreateTree").reset();
		  $("#contactNewForm").hide();
		  $(".newTreeContributors").hide();
		  $(".treeBtn").hide();
		  showTreeList();
	  }
	  else
	  {
	  	  alert(data);
		  return false;
	  }
	  
    }
  });
  }
  else
  {
  	document.getElementById("frmCreateTree").reset();
	$("#contactNewForm").hide();
	$(".newTreeContributors").hide();
	$(".treeBtn").hide();
	return false;
  }
  }
}

function showTreeList()
{
	$.ajax({
    type: "POST",
    url: baseUrl+"new_tree/create_tree_list/"+workSpaceId+"/"+workSpaceType,
    success:  function(data){
		//alert(data);
		//return false;
		$('.treeList').html(data);
		
	}
  });
}

//Contact tree validate function
function displayname(){
		/*if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__'){
			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;
		}*/
		
		document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;
}
function validateContactForm()
{
		var treeType='';
		//treeType = document.getElementById('treeType').value;
		treeType = $("input[name='treeType']:checked").val();
		var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;
		var phoneno = /^(?=.*?[1-9])[0-9()+-]+$/;
		var error='';
		if(document.getElementById('company_name').value.trim()==''){
			error+='<?php echo $this->lang->line('req_company_name'); ?>\n';
		}		
		else if(document.getElementById('first_name').value.trim()==''){
			error+='<?php echo $this->lang->line('req_first_name'); ?>\n';
		}
		else if(document.getElementById('last_name').value.trim()==''){
			error+='<?php echo $this->lang->line('req_last_name'); ?>\n';
		}
		else if(document.getElementById('display_name').value.trim()==''){
			error+='<?php echo $this->lang->line('req_tag_name'); ?>\n';
		}
		else if (document.getElementById('email').value!='')
		{
			if(emailTest.test(document.getElementById('email').value.trim())==false){
				error+="Please enter valid email\n";
			}		
		}

		else {
			var other= getvaluefromEditor ('other');
	
			if(other.length>250){
				error+='<?php echo $this->lang->line('other_details_too_long'); ?>\n';
			}
	
		}
		/*Phone number validation*/
			if (document.getElementById('fax').value!='')
			{
				 if(!(document.getElementById('fax').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid fax number\n";     
				 }
			} 
			if (document.getElementById('mobile').value!='')
			{ 
				 if(!(document.getElementById('mobile').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid phone number\n";     
				 }
			} 
			if (document.getElementById('landlineno').value!='')
			{
				 if(!(document.getElementById('landlineno').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid mobile number\n";     
				 } 
			}
		if(error){
			alert(error);
			return false;
		}else{
		var confirmMsg = '<?php echo $this->lang->line('confirm_Msg_Create_Tree');?>';
		var msg = confirmMsg.replace("{treetype}", treeType);
		if (confirm(msg) == 1)
		{
		
				$.ajax({
					type: "POST",
					url: baseUrl+"new_tree/createContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>",
					data: jQuery("#contactNewForm").serialize(),
					cache: false,
					success:  function(data){
					   /* alert(data); if json obj. alert(JSON.stringify(data));*/
					  // $('#createTreeStatus').html(data);
					  //alert(data);
					   if(data==1)
	  				  {
						  $('#treeTitle').val('');
						  document.getElementById("contactNewForm").reset();
						  document.getElementById("frmCreateTree").reset();
						  $("#contactNewForm").hide();
						  $(".newTreeContributors").hide();
						  $(".treeBtn").hide();
						  showTreeList();
					  }
					  else
					  {	
					  	  alert(data);
		  				  return false;
					  }
					}
				  });
			//return true;
			}
			else
		 	{
				document.getElementById("contactNewForm").reset();
				document.getElementById("frmCreateTree").reset();
				$("#contactNewForm").hide();
				$(".newTreeContributors").hide();
				$(".treeBtn").hide();
				return false;
		  	}
		}
	
}
</script>
<!--Contributors select checkbox script-->
<script>

    $(function() {

	$("input[type='checkbox']").click(function(){
	
		if($(this).hasClass('allcheck')){
			
			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".users").prop( "checked" ,true);

		}

		else if($(this).hasClass('allUncheck')){
			
			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".users").attr('checked',false);

		}

	});

	

});

//On single checkbox click myspace start

//$('.users').live("click",function()
$(document).on('click', '.users', function(){
		//alert('dfsd');
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

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#list").val(arr);
			}

		}

	});


</script>
