<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Contact > New</title>
<!--/*End of Changed by Surbhi IV*/-->
<?php $this->load->view('common/view_head.php');?>
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
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
    
    <div class="menu_new" >
      <ul class="tab_menu_new">
        <li class="contact-view_sel"><a class="active 1tab" href="<?php echo base_url()?>contact/editContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" title="<?php echo $this->lang->line('txt_Create');?>" ></a></li>
        <?php /* <li><a href="<?php echo base_url()?>contact/importContact/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" title="<?php echo $this->lang->line('txt_Bulk_Contacts');?>"><?php echo $this->lang->line('txt_Bulk_Contacts');?></a></li> */ ?>
      </ul>
      <div class="clr"></div>
    </div>
    <?php
				if ($error!='')
				{
				?>
    <span class="text_red"><?php echo $error;?></span>
    <?php
				}
				?>
    <table width="<?php echo (($this->config->item('page_width')/10)+10);?>%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo (($this->config->item('page_width')/10)+10);?>%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" align="left" valign="top"><!-- Main Body --> 
                <span id="tagSpan"></span>
                <form name="form1" method="post" action="<?php echo base_url();?>contact/editContact/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" onSubmit="return validate();">
                  <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td colspan="2" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="width:23%"><strong><?php echo $this->lang->line('txt_Company_Details');?>:</strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Company_Name');?>:</td>
                      <td><input name="company" type="text" id="company_name" value="<?php echo $Contactdetail['company'];?>">
                        *</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Website');?>:</td>
                      <td><input name="website" type="text" id="website" value="<?php echo $Contactdetail['website'];?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Personal_Details');?> </strong></td>
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
                    <tr>
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
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Address');?>:</td>
                      <td><textarea name="address" rows="3" id="address" style="width:50%;"><?php echo $Contactdetail['address'];?></textarea></td>
                    </tr>
                    <?php
		  if ($workSpaceId>0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2))
		  {
		  ?>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Access');?>:</strong></td>
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
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Status');?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Status');?>:</td>
                      <td style="width:77%" align="left"><textarea name="comments" id="comments" style="width:50%;"><?php echo $Contactdetail['comments'];?></textarea></td>
                    </tr>
                    <tr>
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
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Telephone');?>:</td>
                      <td><input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong><?php echo $this->lang->line('txt_Other_Details');?></strong></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->lang->line('txt_Other');?>(Max Length 250 Characters):</td>
                      <td><textarea name="other" id="other" style="width:50%;"><?php echo $Contactdetail['other'];?></textarea></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right" valign="top">&nbsp;</td>
                      <td><input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Done');?>" class="button01">
						<input type="button" name="cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="document.location='<?php echo base_url();?>contact/index/0/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';" class="button01"/>
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
                
                <!-- Main Body --> 
                <!-- Right Part--> 
                <!-- end Right Part --></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="8" align="left" valign="top" bgcolor="#FFFFFF"></td>
      </tr>
    </table>
  </div>
</div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
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
	    var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;
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
		if(error){
			jAlert(error);
			return false;
		}else{
			return true;
		}
	
	}
	
</script>