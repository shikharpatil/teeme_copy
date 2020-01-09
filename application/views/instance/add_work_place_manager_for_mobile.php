<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme > Add Place Manager</title>

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

<script>

function changeTagName (val)

{

	document.getElementById('tagName').value = val.value;

	checkTagName(val,<?php echo $workPlaceId;?>,1);

}

function showUserTagName ()

{

	var first_name 	= document.getElementById('firstName').value;

	var last_name 	= document.getElementById('lastName').value;

	

	if (first_name!='' && last_name!='')

	{

		var suggestion1 = first_name+'_'+last_name;

		var suggestion2 = last_name+'_'+first_name;

		var suggestion3 = first_name+last_name;

		var suggestion4 = last_name+first_name;

		var val='';
		

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion1+'"/>'+suggestion1+'&nbsp;';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion2+'"/>'+suggestion2+'<br>';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion3+'"/>'+suggestion3+'&nbsp;';

		val +=  '<input type="radio" name="userTagName" onclick="javascript:changeTagName(this);" value="'+suggestion4+'"/>'+suggestion4+'<br>';

		

		document.getElementById('userTagName').innerHTML = val;

		



	}

	else

	{

		document.getElementById('userTagName').innerHTML = '';

	}

}





function displayname(){

/*	if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__')

	{

		document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

	}*/

			//document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

			var suggestion1 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;

			var suggestion2 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value+'_01';

			var suggestion3 = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value+'_02';

			var suggestion4 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value;

			var suggestion5 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value+'_01';

			var suggestion6 = document.getElementById('last_name').value+'_'+document.getElementById('first_name').value+'_02';

			var suggestion7 = document.getElementById('first_name').value+document.getElementById('last_name').value;

			var suggestion8 = document.getElementById('first_name').value+document.getElementById('last_name').value+'_01';

			var suggestion9 = document.getElementById('first_name').value+document.getElementById('last_name').value+'_02';

			var suggestion10 = document.getElementById('last_name').value+document.getElementById('first_name').value;

			var suggestion11 = document.getElementById('last_name').value+document.getElementById('first_name').value+'_01';

			var suggestion12 = document.getElementById('last_name').value+document.getElementById('first_name').value+'_02';

			

			

			var suggestions = suggestion1+', '+suggestion2+', '+suggestion3+', '+suggestion4+', '+suggestion5+', '+suggestion6+', '+suggestion7+', '+suggestion8+', '+suggestion9+', '+suggestion10+', '+suggestion11+', '+suggestion12;

			

			document.getElementById('tagNameSuggestions').innerHTML=suggestions;



}

</script>

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>

<?php 
	$this->load->view('instance/common/top_links_for_mobile');
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr> 

    <td valign="top">

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                 

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"> 

            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php 

					//$this->load->view('instance/common/top_links');

					?>     

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                	<td align="left" valign="top">

					<!-- Main Body -->

			  		<form name="frmWorkPlace" id="frmWorkPlace" action="<?php echo base_url();?>instance/home/add_work_place_manager/<?php echo $workPlaceId;?>" method="post" enctype="multipart/form-data" onSubmit="return validatePlaceManager(this);">

              		<table width="100%" border="0" cellspacing="3" cellpadding="3">

              		<tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

            <ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>
                				
                                <li><a href="<?php echo base_url()?>instance/home/add_work_place_manager/<?php echo $workPlaceId;?>" class="active"><span><?php echo $this->lang->line('txt_Add_Place_Manager');?></span></a></li>

            				</ul>

			<div class="clr"></div>

        </div>

                        </td>

					</tr>

                <?php 

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

                  <td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

                <?php

				}

				

				?>

                <tr>

                  <td class="heading" colspan="4"><?php echo $this->lang->line('txt_Workplace_Manager_Details');?></td>

                </tr>

                

                <tr>

                  <td colspan="4" class="tdSpace">&nbsp;</td>

                </tr>


                <tr>

                  <td colspan="4">

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;">

                      <tbody>

                        <tr>

                          <td width="195" align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span></td>

                          <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" valign="top" class="text_gre1">

                            <input name="firstName" class="text_gre1" id="firstName" size="20" value="" onkeyup="showUserTagName();" />

                            <input type="hidden" name="userTitle" id="userTitle" value="">

                          </td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="lastName" class="text_gre1" id="lastName" size="20"  value="" onkeyup="showUserTagName();" />

                          </td>

                        </tr>
						
						<!--Nickname field start-->
						<tr>
						
						  <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_nick_name');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <input name="nickName" class="text_gre1" id="nickName" size="20"  value="" />

                          </td>

                        </tr>
						<!--Nickname field end-->
                        
						<tr>

                            <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_User_Tag_Name_Preference');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">
						  
						  <?php
							/*
                          pm_ <input name="tagName" type="text" autocapitalize="off" class="text_gre1" id="tagName" size="30" onfocus="checkTagName(this,<?php echo $workPlaceId;?>,1)" onkeyup="checkTagName(this,<?php echo $workPlaceId;?>,1)" value="<?php echo $this->input->post('tagName');?>"/>&nbsp;<span id="tagNameStatusText"></span><br /><span style="color:#006600" id="tagNameSuggestions"></span>
							*/
							?>
							
						      <input type="radio" name="tagNamePreference" value="f_l" <?php if( $this->input->post('tagNamePreference') != 'l_f' ) { echo 'checked'; }?>>firstname_lastname</input>
                              <input type="radio" name="tagNamePreference" value="l_f" <?php if( $this->input->post('tagNamePreference') == 'l_f' ) { echo 'checked'; }?>>lastname_firstname</input>


                          </td>

                        </tr>
						
						
						<!--User time zone view start here-->
						
						  <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('time_zone_txt'); ?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

							<select name="timezone" id="timezone" style="width:93%;">
							
								<option value='0' selected><?php echo $this->lang->line('select_time_zone_txt'); ?></option>
							
								<?php
								foreach($timezoneDetails as $timezoneData)
								{
								?>
								<option value='<?php echo $timezoneData['timezoneid']; ?>'><?php echo $timezoneData['timezone_name']; ?></option>
								<?php	
								}
								?>
							
							</select>

                          

                          </td>

                        </tr>
						
						<!--User time zone view end here-->
						
						<?php
						/*
                          
                        <tr>

                          <td align="left"  valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">

                          <div id="userTagName">

                          </div>

                          </td>

                        </tr>
						*/
						?>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Address');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="address1" rows="3" id="address1" style="width:90%;"></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          	<td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Telephone');?></td>

                          	<td align="center" valign="middle" class="text_gre1"><span class="text_gre"><strong>:</strong></span></td>

                          	<td align="left" class="text_gre1">

                            	<input name="phone" class="text_gre1" id="phone" size="20" value=""/>

                			</td>

                        </tr>

                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Mobile');?></td>

                          <td align="center" valign="middle"><span class="text_gre"><strong>:</strong></span></td>

                          <td align="left">

                            <input name="mobile" class="text_gre1" id="mobile" size="20" value=""/></td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Other_Details');?></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre">

                            <textarea name="otherManager" rows="3" id="otherManager" style="width:90%;"></textarea>

                          </td>

                        </tr>

                        <tr style="display:none;">

                          <td align="left" valign="middle" class="text_gre1">&nbsp;</td>

                          <td align="center" valign="middle" class="text_gre">&nbsp;</td>

                          <td align="left" class="text_gre">&nbsp;</td>

                        </tr>


                        <tr>

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Email');?> <span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="email" class="text_gre1" id="email" size="20" onKeyUp="checkUserName(this,<?php echo $workPlaceId;?>)"/>

&nbsp;<span id="userNameStatusText"></span></td>

                        </tr>

                        <tr id="pass1">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Password');?><span class="text_red">*</span> </td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="password" type="password" class="text_gre1" id="password" size="20" /></td>

                        </tr>

                        <tr id="pass2">

                          <td align="left" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Confirm_Password');?><span class="text_red">*</span></td>

                          <td align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                          <td align="left" class="text_gre"><input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="20" /></td>

                        </tr>	
					
						<tr>

                          <td colspan="3" align="left" valign="middle" class="text_gre1">&nbsp;</td>

                        </tr>

                        <tr>

                  <td colspan="2">&nbsp;</td>

                  <td >

                      <input type="hidden" name="communityId" value="1" id="communityId">

                      <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Add_Place_Manager');?>">

                  </td>

                </tr>

                      </tbody>

                    </table>

                  

			 </td>

                </tr>

                

              </table>

              <input type="hidden" name="workPlaceStatus" value="1" id="workPlaceStatus">

            </form>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

        </table>

    </td>

  </tr>
</table>
<!-- Footer -->	
<?php  $this->load->view('common/footer');?>
<!-- Footer -->


</body>
</html>