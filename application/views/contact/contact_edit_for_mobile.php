<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Contact > New</title>
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head');?>
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
</div>
<div id="container_for_mobile">
  <div id="content"> 
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
			?>
    <!-- Main menu -->
    <?php  // } ?>
    <?php
				if ($error!='')
				{
				?>
    <span class="text_red"><?php echo $error;?></span>
    <?php
				}
				?>
    <!-- Main Body --> 
    <span id="tagSpan"></span>
    <form name="form1" method="post" action="<?php echo base_url();?>contact/editContact/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" onSubmit="return validate();">
      <strong><?php echo $this->lang->line('txt_Company_Details');?>:</strong> <br />
      <span class="contactLabel"> <?php echo $this->lang->line('txt_Company_Name');?>: </span> <span class="contactTextDiv">
      <input name="company" type="text" id="company_name" value="<?php echo $Contactdetail['company'];?>">
      * </span> <span class="contactLabel"><?php echo $this->lang->line('txt_Website');?>:</span> <span class="contactTextDiv">
      <input name="website" type="text" id="website" value="<?php echo $Contactdetail['website'];?>">
      </span> <strong style="width:100%;float:left"><?php echo $this->lang->line('txt_Personal_Details');?> </strong> <br />
      <span class="contactLabel"> <?php echo $this->lang->line('txt_Title');?>: </span> <span class="contactTextDiv">
      <input name="title" type="text" id="title" value="<?php echo $Contactdetail['title'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_First_Name');?>: </span> <span class="contactTextDiv">
      <input name="firstname" type="text" id="first_name" onBlur="displayname();" value="<?php echo $Contactdetail['firstname'];?>">
      * </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Middle_Name');?>: </span> <span class="contactTextDiv">
      <input name="middlename" type="text" id="middle_name" onBlur="displayname();" value="<?php echo $Contactdetail['middlename'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Last_Name');?>: </span> <span class="contactTextDiv">
      <input name="lastname" type="text" id="last_name" onBlur="displayname();" value="<?php echo $Contactdetail['lastname'];?>">
      * </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Tag_Name');?>: </span> <span class="contactTextDiv">
      <input name="display_name" type="text" id="display_name" value="<?php echo $Contactdetail['name'];?>" <?php if($treeId){?> readonly=""<?php }?>>
      * </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Role');?>: </span> <span class="contactTextDiv">
      <input name="designation" type="text" id="designation" value="<?php echo $Contactdetail['designation'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Address');?>: </span> <span class="contactTextDiv">
      <textarea name="address" rows="3"id="address" ><?php echo $Contactdetail['address'];?></textarea>
      </span>
      <?php
		  if ($workSpaceId!=0)
		  {
		  ?>
      <strong style="width:100%;float:left"><?php echo $this->lang->line('txt_Access');?>:</strong> <br />
      <span class="contactLabel">&nbsp;</span> <span class="contactTextDiv">
      <input type="radio" name="sharedStatus" value="2" checked="checked">
      <?php echo $this->lang->line('txt_Private');?> (<?php echo $this->lang->line('txt_Access_current_space');?>)<br />
      <input type="radio" name="sharedStatus" value="1">
      <?php echo $this->lang->line('txt_Public');?> (<?php echo $this->lang->line('txt_Access_current_place');?>) </span>
      <?php
		  }
		  ?>
      <strong style="width:100%;float:left"><?php echo $this->lang->line('txt_Status');?></strong> <br />
      <span class="contactLabel"><?php echo $this->lang->line('txt_Status');?>:</span> <span class="contactTextDiv">
      <textarea name="comments" id="comments"><?php echo $Contactdetail['comments'];?></textarea>
      </span> <strong style="width:100%;float:left"><?php echo $this->lang->line('txt_Contact_Details');?>:</strong> <br />
      <span class="contactLabel"> <?php echo $this->lang->line('txt_Email');?>: </span> <span class="contactTextDiv">
      <input name="email" type="text" id="email" value="<?php echo $Contactdetail['email'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Fax');?>: </span> <span class="contactTextDiv">
      <input name="fax" type="text" id="fax" value="<?php echo $Contactdetail['fax'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Mobile');?>: </span> <span class="contactTextDiv">
      <input name="mobile" type="text" id="mobile" maxlength="20" value="<?php echo $Contactdetail['mobile'];?>">
      </span> <span class="contactLabel"> <?php echo $this->lang->line('txt_Telephone');?>: </span> <span class="contactTextDiv">
      <input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>">
      </span> <strong style="width:100%;float:left"><?php echo $this->lang->line('txt_Other_Details');?></strong> <span class="contactLabel"> <?php echo $this->lang->line('txt_Other');?>: </span> <span class="contactTextDiv">
      <textarea name="other" id="other"><?php echo $Contactdetail['other'];?></textarea>
      </span> <span class="contactTextDiv">
      <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Done');?>" class="button01">
      <input type="button" name="cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearForm(this.form);"/>
      <input name="reply" type="hidden" id="reply" value="1">
      <?php
		  		if ($workSpaceId==0)
		  		{
		  		?>
      <input type="hidden" name="sharedStatus" value="2" >
      <?php
				}
				?>
      </span> <span class="clr"></span>
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
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';
    //chnage_textarea_to_editor('comments','simple');
	//chnage_textarea_to_editor('other','simple');

	function displayname(){
		if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__'){
			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;
		}
	}
	function validate()
	{
	   
		var error='';
		if(document.getElementById('company_name').value==''){
			error+='<?php echo $this->lang->line('req_company_name'); ?>\n';
		}		
		else if(document.getElementById('first_name').value==''){
			error+='<?php echo $this->lang->line('req_first_name'); ?>\n';
		}
		else if(document.getElementById('last_name').value==''){
			error+='<?php echo $this->lang->line('req_last_name'); ?>\n';
		}
		else if(document.getElementById('display_name').value==''){
			error+='<?php echo $this->lang->line('req_tag_name'); ?>\n';
		}
		else {
			var other= getvaluefromEditor ('other');

			if(other.length>250){
				error+='<?php echo $this->lang->line('other_details_too_long'); ?>\n';
			}
		}
		if(error){
			jAlert(error);
			return false;
		}else{
			return true;
		}
	
	}
	
</script>