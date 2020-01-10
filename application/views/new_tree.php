<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Create</title>

<!--Manoj: code for contributors start-->

<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

		var node_lock=0;

</script>

<?php  include_once('notes/notes_js.php');?>

<!--Manoj: code for contributors end-->

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
				$this->load->view('common/artifact_tabs', $details);

			//}
			
				$docTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceId,$workSpaceType,1);
				$chatTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceId,$workSpaceType,1);
				$taskTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceId,$workSpaceType,1);
				$notesTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceId,$workSpaceType,1);
				$conTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceId,$workSpaceType,1);
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
				*/	
			
			?>
<div id="container">
<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?></div>
<div id="rightSideBar">
			<?php 
			//$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			//$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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
				$docTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceId,$workSpaceType,1);
				$chatTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceId,$workSpaceType,1);
				$taskTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceId,$workSpaceType,1);
				$notesTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceId,$workSpaceType,1);
				$conTreeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceId,$workSpaceType,1);
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
				if($workSpaceId!=0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2)) {
					$treeTypeEnabled = 1;	
				}
			 if(!empty($spaceTreeDetails) || $workSpaceId==0 || ($workSpaceDetails['workSpaceName']=='Try Teeme' && $workSpaceType==1) ){ ?>
			<div class="newTree">
		
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
					   
					     <th colspan="3" align="left" valign="middle" class="text_gre1 createNewTreeTxt">
					     	<!-- <img src="<?php echo base_url();?>images/addnew.png"  title="Notes"/> <?php echo $this->lang->line('txt_Create_Tree');?> -->
					     	<img src="<?php echo base_url();?>images/addnew.png"  title="Notes"/> <?php echo $this->lang->line('txt_Create');?>
					     	<strong>:</strong>

					     	<span>
					     		<span <?php if(!(in_array('1',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?> ><input type="radio" name="treeType" id="treeType" value="document" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Document');?></span>
							
								<span <?php if(!(in_array('3',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="discuss" onClick="getTreeTypeVal(this)"   ><?php echo $this->lang->line('disucssion');?></span>
								<span <?php if(!(in_array('4',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="task" onClick="getTreeTypeVal(this)"   ><?php echo $this->lang->line('txt_Task');?></span>
								<?php if($notesAllowStatus==1){ ?>
								<span <?php if(!(in_array('6',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="notes" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Notes');?></span>
								<?php } ?>
								<span <?php if(!(in_array('5',$spaceTreeDetails)) && $treeTypeEnabled==1) { ?> style="display:none;" <?php } ?>><input type="radio" name="treeType" id="treeType" value="contact" onClick="getTreeTypeVal(this)"  ><?php echo $this->lang->line('txt_Contact');?></span>
					     	</span>
					     </th>

						</tr>
						
						<tr>
					   		 <th width="200" height="15" align="left" valign="middle" class="text_gre1"></th>
						</tr>
										   
					<!--Added by Dashrath- Add number and position field-->   
					<!--
					<tr class="documentAddPosition" style="display: none;">
				   		<td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Add_position');?></td>
						<td align="left" valign="top" class="text_gre"><strong>:</strong></td>
						<td align="left" class="text_gre">
							<select name="selDocumentPos" id="selDocumentPos">
								<option value="1"><?php echo $this->lang->line('txt_Anywhere'); ?></option>
								<option value="2"><?php echo $this->lang->line('txt_At_Top'); ?></option>
								<option value="3"><?php echo $this->lang->line('txt_At_Bottom'); ?></option>
							</select>     
						</td>
				   	</tr>						
					-->
					<tr class="documentAddPosition" style="display: none;">
				   		<td align="left" valign="top" class="text_gre1"><?php echo "Create this document as"?></td>
						<td align="left" valign="top" class="text_gre"><strong>:</strong></td>
						<td align="left" class="text_gre">  
							<input type="radio" name="selDocumentPos" id="selDocumentPos" value="1" checked><?php echo "Document (Content can be added anywhere)" ?><br/>
							<input type="radio" name="selDocumentPos" id="selDocumentPos" value="2"><?php echo "To-do list from top (Content can be added at the top only)" ?><br/>
							<input type="radio" name="selDocumentPos" id="selDocumentPos" value="3"><?php echo "To-do list from bottom (Content can be added at the bottom only)" ?>
						</td>
				   	</tr>		
						<tr class="treeBtn" style="display:none;" >

                         <td align="left" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Tree_Title');?><span class="text_red"></span></td>

                         <td align="left" valign="top" class="text_gre"><strong>:</strong></td>

                         <!--changed by Dashrath- add width:97% in textarea-->
                         <td align="left" class="text_gre"><textarea placeholder="Maximum 255 characters" id="treeTitle" name="treeTitle" class="new_tree_textarea" style="width:85% !important;"/></textarea></td>

                       </tr> 
					  
					


				   	<tr class="numberedDocument" style="display: none;">
				   		<td align="left" valign="top" class="text_gre1 treeCreateTdLabel"><?php echo $this->lang->line('txt_Show_numbering');?></td>
						<td align="left" valign="top" class="text_gre"><strong>:</strong></td>
						<td align="left" class="text_gre">
							<input type="checkbox" name="autonumbering" checked/>  
						</td>
				   	</tr>
					<!--Dashrath- code end-->

					<?php 
					  if($workSpaceId!=0){ 
					  ?>
					   <tr class="newTreeContributors" style="display:none;" >
					   		<td align="left" valign="top" class="text_gre1">Contributors</td>
							<td align="left" valign="top" class="text_gre"><strong>:</strong></td>
							<td align="left" class="text_gre">
							
							<!--Contributors view start-->
			
								<div>
				
								<div>
				
								<div id="edit_notes" class="<?php echo $seedBgColor;?> contributorBox" style="width:49%;float:left;" >
				
									
				
										<form name="frmedit_notes" id="frmedit_notes" method="post" action="">
										
										<div style="margin-bottom:10px;">
										<?php echo $this->lang->line('txt_Search'); ?> :
				
										<input type="text" id="showMembers" name="showMembers" onKeyUp="showCreateTreeContributors()"/> 
										</div>
				
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

					   <tr class="treeBtn" style="display:none;" >
					   
					   	 <td align="left" valign="top" class="text_gre1"></td>

                         <td align="left" valign="top" class="text_gre"></td>

                         <td align="left" class="text_gre">
						 			<div class="newTreeCreateBtn">
									<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
									<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">
									<input name="submit" type="button" id="submit" value="<?php echo $this->lang->line('txt_Create');?>" onclick="createTree();">
									<?php /*?><input name="spaceFinish" type="button" id="spaceFinish" value="Finish" onclick="gotoDashboard();"><?php */?>
									<span id="createTreeStatus" style="padding:0 0 0 10px;"></span>
									</div>
						</td>
					   	
						</tr>
					                    
                 	 </table>

							 

				   </td>
				 

			    </tr>

				</table>		

		 	</form>
			
			<!--Contact tree form start here-->
			
			<form id="contactNewForm" name="contactNewForm" method="post" action="<?php echo base_url();?>new_tree/createContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" style="width:85%; display:none;  <?php /*?>margin-left:19%; padding-left: 4px;<?php */?> " >
                  <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td colspan="2" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="width:23%"><strong><?php echo $this->lang->line('txt_Company_Details');?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_user_full_name');?>:</td>
                      <td><input name="company" type="text" id="company_name" value="<?php echo $Contactdetail['company'];?>">
                        *</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Website');?>:</td>
                      <td><input name="website" type="text" id="website" value="<?php echo $Contactdetail['website'];?>"></td>
                    </tr>
					<tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Address');?>:</td>
                      <td><textarea name="address" rows="3" id="address" style="width:50%;"><?php echo $Contactdetail['address'];?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Contact'); /*echo $this->lang->line('txt_Personal_Details');*/?> </strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Title');?>: </td>
                      <td align="left"><input name="title" type="text" id="title" value="<?php echo $Contactdetail['title'];?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_First_Name');?>:</td>
                      <td><input name="firstname" type="text" id="first_name" onBlur="displayname();" value="<?php echo $Contactdetail['firstname'];?>">
                        *</td>
                    </tr>
                    <tr style="display:none;">
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Middle_Name');?>:</td>
                      <td><input name="middlename" type="text" id="middle_name" onBlur="displayname();" value="<?php echo $Contactdetail['middlename'];?>"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Last_Name');?>:</td>
                      <td><input name="lastname" type="text" id="last_name" onBlur="displayname();" value="<?php echo $Contactdetail['lastname'];?>">
                        *</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Tag_Name');?>:</td>
                      <td><input name="display_name" type="text" id="display_name" value="<?php echo $Contactdetail['name'];?>" <?php if($treeId){?> readonly=""<?php }?>>
                        *</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Role');?>:</td>
                      <td><input name="designation" type="text" id="designation" value="<?php echo $Contactdetail['designation'];?>"></td>
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
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Contact_Mobile'); /*echo $this->lang->line('txt_Telephone');*/ ?>:</td>
                      <td><input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>"></td>
                    </tr>
                    
                    
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Status');?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php //echo $this->lang->line('txt_Status');?></td>
                      <td style="width:77%" align="left"><textarea name="comments" id="comments" style="width:50%;"><?php echo $Contactdetail['comments'];?></textarea></td>
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
                      <td align="right" valign="top" height="10"></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php //echo $this->lang->line('txt_Other');?></td>
                      <td><textarea name="other" id="other" style="width:50%;"><?php echo $Contactdetail['other'];?></textarea></td>
                    </tr>
                    
					<?php
		  if ($workSpaceId>0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2))
		  {
		  ?>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Access');?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top">&nbsp;</td>
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
						 <!--Latest tree list start-->
				 <div class="treeList">  
				 </div>
				    <!--Latest tree list end-->	
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

	//Added by dashrath
	if(treeType=='document')
	{
		$(".documentAddPosition").show();
		$(".numberedDocument").show();
		
	}
	else
	{
		$(".documentAddPosition").hide();
		$(".numberedDocument").hide();
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
	//alert(treeType);
	var error='';
	if(document.getElementById('treeTitle').value.trim()==''){
			error+='<?php echo $this->lang->line('title_not_empty'); ?>\n';
	}	
	
	if(error){
			jAlert(error);
			return false;
	}
	else
	{
		//Added by dashrath- change message discuss to discussion
		if(treeType == 'discuss')
		{
			treeType = 'discussion';
		}
		//Dashrath- code end

		var confirmMsg = '<?php echo $this->lang->line('confirm_Msg_Create_Tree_New');?>';
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
		//alert(data);
		//return false;
       /* alert(data); if json obj. alert(JSON.stringify(data));*/
	  // $('#createTreeStatus').html(data);
	  //jAlert(data);
	  
	  if(data==1)
	  {
	  	  $('#treeTitle').val('');
		  document.getElementById("frmCreateTree").reset();
		  $("#contactNewForm").hide();
		  $(".newTreeContributors").hide();
		  $(".treeBtn").hide();

		  //Added by Dashrath
		  $(".documentAddPosition").hide();
		  $(".numberedDocument").hide();

		  showTreeList();
	  }
	  else
	  {
	  	  jAlert(data);
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

	//Added by Dashrath
	$(".documentAddPosition").hide();
	$(".numberedDocument").hide();

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
		
		/*if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value)
		{*/
			//document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;
			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;
		/*}*/
		
}
function validateContactForm()
{
		var treeType='';
		//treeType = document.getElementById('treeType').value;
		treeType = $("input[name='treeType']:checked").val();
		var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;
		//var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
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
			jAlert(error);
			return false;
		}else{
		var confirmMsg = '<?php echo $this->lang->line('confirm_Msg_Create_Tree_New');?>';
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
					  //jAlert(data);
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
					  	  jAlert(data);
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
			
			$(".users").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(value+","+$(this).val());

				}
			});

		}

		else if($(this).hasClass('allUncheck')){
			
			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".users").attr('checked',false);
			
			$(".users").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#list").val(arr);

			});

		}

	});

	

});

function showHideDashBoard(className)
{
	var divsToHide = document.getElementsByClassName(className);
	
	for(var i = 0; i < divsToHide.length; i++)
    {
		if (divsToHide[i].style.display=='block')
		{
    		divsToHide[i].style.display='none';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
				}								
		}
		else
		{
			divsToHide[i].style.display='block';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
				}								
		}
		
	}
}

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
