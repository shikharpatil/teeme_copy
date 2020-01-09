<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > Installation</title>



<?php 

session_start();
//session_destroy();

if($_SESSION['workPlaceId'] && $_SESSION['contName1']){

	header("location:dashboard/index/0/type/1");

}

$this->load->view('common/view_head.php');?>


<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>
<style>
.flLt
{
	width:12%;
	text-align:left;
}
</style>
</head>

<body>

<div id="wrap1">

  <div id="header-wrap">

    <?php $this->load->view('common/header'); ?>

       

  </div>

</div>

<div id="container" style="padding-top:50px;">

  <div id="content" align="center"   >

    <div class="clsMarginBottom10"  ><strong><?php //echo $this->lang->line('txt_User_Login');?></strong></div>

    <?php

		if (isset($_SESSION['userId']) && $_SESSION['userId']!='')

		{

			redirect('dashboard/index/0/type/1', 'location');

		}

		//print_r($_SESSION);die;

		$this->load->helper('form'); 

		
	if($this->uri->segment(1)){

?>
<form name="frmInstallation" id="frmInstallation" action="<?php echo base_url();?>installation" method="post" enctype="multipart/form-data">

    <?php /*?><div class="clsMarginBottom10" ><span class="error"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';unset( $_SESSION['errorMsg']);?></span></div><?php */?>

		<div class="clsMarginBottom10" ><span class="error" style="color:#099731;"><?php if($_SESSION['errorMsg']!=''){ echo $_SESSION['errorMsg'];?> <a style="color:#099731;" href="<?php echo base_url();?>instance/login"><?php echo $this->lang->line('txt_here'); ?></a> <?php $_SESSION['errorMsg'] ='';unset( $_SESSION['errorMsg']); } ?></span></div>

        <?php /*?><div class="clsMarginBottom10 flLt"> 
		<span><?php echo $this->lang->line('txt_Select_Installation_Type');?>: </span> 
		<span>
		<!-- Manoj: added checked property -->
            <input type="radio" value="Clean" name="installation_type" checked="checked"/>&nbsp;<?php echo $this->lang->line('txt_Fresh');?>
          	<input type="radio" value="Backup" name="installation_type"/>&nbsp;<?php echo $this->lang->line('txt_Restore_Backup');?>

          </span>
		</div><?php */?>
		
		<div class='clr' ></div>
        <div class="clsMarginBottom10"> 
		
						<div style="float:left; font-size:1.2em; margin-bottom:1%;"><?php echo $this->lang->line('set_up_new_instance_txt'); ?></div>

					 	<div class='clr' ></div> 

                        <div class="flLt"><?php echo $this->lang->line('database_server_host'); ?><span class="text_red">*</span></div>

                        <div class="flLt"> <input name="server" class="text_gre1" id="server" size="30" value="<?php echo base64_decode ($this->config->item('hostname')); ?>"/></div>
						 <div class='clr' ></div>  

                        <div class="flLt"><?php echo $this->lang->line('database_server_user'); ?><span class="text_red">*</span></div>

                            <div class="flLt"><input name="server_username" class="text_gre1" id="server_username" size="30" value="<?php echo base64_decode ($this->config->item('username')); ?>"/></div>
						<div class='clr' ></div> 	
						<div class="flLt"><?php echo $this->lang->line('database_server_password'); ?><span class="text_red">*</span></div>

                            <div class="flLt"><input name="server_password" class="text_gre1" type="password" id="server_password" size="30" value="<?php echo base64_decode ($this->config->item('password')); ?>"/></div>
<div class='clr' ></div> 
                        <div class="flLt"><?php echo $this->lang->line('database_name'); ?><span class="text_red">*</span></div>
               

                            <div class="flLt"><input name="instance_name" type="text" id="instance_name" size="30" value="<?php echo $this->config->item('instanceName');?>"/></div>
						<div class='clr' ></div> 

						<!--Manoj: Added auto update path url field-->
						
						<?php /*?><div class="flLt"><?php echo $this->lang->line('auto_update_server_path'); ?><span class="text_red">*</span></div>
               

                            <div class="flLt"><input name="autoupdate_path" type="text" id="autoupdate_path" size="30" value="<?php echo $this->config->item('auto_update_client_path');?>"/></div>
						<div class='clr' ></div> <?php */?>
						
						<!--Manoj: code end-->					
				
				
					 <div class="flLt"> <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Create');?>">
		
					<?php $return_server = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME']; ?>
					</div>
			</div>
			<!--Manoj: code for restore bckup-->
			<div id="clean_div" style="display:none;"></div>
			<div id="backup_div" style="display:none;"></div>
			<!--Manoj: code end-->
    </div>

	</form>

    <?php

	}

	else{

	 ?> 

     <div style="width:37%;" id="rootBlock">

     <span class="error" id="er"></span><br />

     <div class="flLt" style="width:95%;">

         <strong class="flLt" style="width:35%;text-align:left;"><?php echo $this->lang->line('txt_Instance_Manager'); ?> 

         </strong>

         

          <div class="flRt" style="width:60%;text-align:right"><strong class="flLt" style="width:70%;text-align:right;"><?php echo ucfirst($this->config->item("instanceName"));?></strong><button id="instanceGo"><?php echo $this->lang->line('txt_go'); ?></button>

          </div>

         <div class="clr"></div>

     </div>

     <div class="flLt" style="width:95%;">

    	<strong class="flLt" style="width:35%;text-align:left;"><?php echo $this->lang->line('txt_Place_Manager'); ?> </strong>

        <div class="flRt" style="width:60%;text-align:right;">

        <input type="text" name="place_name" id="place_name" value="" placeholder="Enter place name" onkeypress="if(event.keyCode == 13){goto('place_name');}" />

        <button onclick="goto('place_name');return false;"><?php echo $this->lang->line('txt_go'); ?></button>

        </div>

        <div class="clr"></div>

     </div>

     <div class="flLt" style="width:95%;">

     <strong class="flLt" style="width:35%;text-align:left;"><?php echo $this->lang->line('txt_User'); ?> </strong>

     <div class="flRt" style="width:60%;text-align:right;">

     <input type="text" name="place_name1" id="place_name1" value="" placeholder="Enter place name"onkeypress="if(event.keyCode == 13){goto('place_name1');}" />

     <button onclick="goto('place_name1');return false;"><?php echo $this->lang->line('txt_go'); ?></button>

     </div>

     </div>

     <div class="clr"></div>

     

  <div class="clr"></div>

</div>

	 <?php

	}?>

  </div>

</div>

<div>

  <?php $this->load->view('common/foot.php');?>

  <?php $this->load->view('common/footer');?>

</div>

</body>

</html>

<script language="javascript">

$(document).ready(function(){
$("#clean_div").show();
    $('input[type=radio][name=installation_type]').change(function() {
        if (this.value == 'Clean') {
            $("#backup_div").hide();
			$("#clean_div").show();
        }
        else if (this.value == 'Backup') {
            $("#backup_div").show();
			$("#clean_div").hide();
        }
    });
});



	if (document.getElementById("instanceGo")!=null)
	{
		document.getElementById("instanceGo").onclick = function () {
			location.href = "<?php echo base_url();?>instance/login";
			return false;
		};
	}

//this function used to update the time difference between client machine and GMT time

function updateTimeZone()

{	

	var now = new Date();

	var offset = (now.getTimezoneOffset() / 60)*-1;

	document.getElementById('timeDiff').value = offset;

	//setCookie ('time_diff',offset);

}

updateTimeZone();

</script>

<script>

var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));

if(ismobile && /mobile/i.test(navigator.userAgent.toLowerCase()))

{

   document.cookie = "ismobile=1";

   $('.socialIconInner').attr('class','socialIconInnerMobile');

   $("#rootBlock").css({'width':'100%'});

}

else

{

   document.cookie="ismobile=0";

}





function goto(type){

	var placename 	= $('#'+type).val();

	$.post('<?php echo base_url();?>/login_check/validatePlace',{'placename':placename},function(data){

		if(data!=0){

			if(type=='place_name'){

				window.top.location='<?php echo base_url();?>place/'+placename;

			}

			else{

				window.top.location='<?php echo base_url();?>'+placename;

			}

		}

		else{

			$('#er').html("<?php echo $this->lang->line('invalid_place_name'); ?>");

		}

	});

}



function loginCheckSpace(){

	var userName = $('#userName').val();

	var userPass = $('#userPassword').val();

	var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;

	var err='';

	if(userName==''){

		err +="<?php echo $this->lang->line('enter_email'); ?><br />";

	}

	else if(emailTest.test(userName)==false){

		err +="<?php echo $this->lang->line('enter_valid_email'); ?><br />";

	}

	if(userPass==''){

		err +="<?php echo $this->lang->line('enter_password'); ?>";

	}

	if(err==''){

		$.ajax({

		  type: 'POST',

		  url: "<?php echo base_url();?>login_check/setSessionForSpace",

		  data: {"contName":"<?php echo $contName;?>","workPlaceId":"<?php echo $workPlaceId;?>","contName1":"<?php echo $contName;?>"},

		  success: function(data){

			  if(data){

					return true;

				}

				else{

					return false;

				}	

			},

		  async:false

		});

	}else{

		jAlert (err,'Alert');

		return false;

	}

}



function openlogin(type){

	$.ajax({

		  type: 'POST',

		  url: "<?php echo base_url();?>login_check/setSessionForSpace",

		  data: {"contName":"<?php echo $contName;?>","workPlaceId":"<?php echo $workPlaceId;?>","contName1":"<?php echo $contName;?>"},

		  success: function(data){

			  if(data){

					if(type=='fb'){

						document.facebookForm.submit();

					}

					else if(type=='yahoo'){

						document.yahooForm.submit();

					}

					else if(type=='gmail'){

						document.gmailForm.submit();

					}

				}

				else{

					return false;

				}	

			},

		  async:false

		});

}



</script>

﻿