<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>



<?php 

session_start();
//session_destroy();

if($_SESSION['workPlaceId'] && $_SESSION['contName1']){

	header("location:dashboard/index/0/type/1");

}

$this->load->view('common/view_head.php');?>

<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

//Manoj: Check place expiry date 

$(document).ready(function(){
		
		var placeName = '<?php echo $this->uri->segment(1); ?>';
		
		$.ajax({

		  url: "<?php echo base_url();?>instance/home/expire_work_place/<?php echo $workPlaceId; ?>",

		  success: function(data){
				
				if(data){
				
					$("#exp_error").html( data );
				
				}
		},

		});
});

//Manoj: code end

</script>

</head>

<body>

<div id="wrap1">

  <div id="header-wrap" style="width:100% !important;">
  
  	<?php
	/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			
	/*Added for checking device type end*/
	?>

    <?php 
	if($deviceName=='mobile')
	{
		$this->load->view('common/header_for_mobile'); 
	}
	else
	{
		$this->load->view('common/header'); 
	}
	?>
	
    <?php
	$offline_mode = $this->identity_db_manager->get_maintenance_mode();  
	//$workPlaceDetails 	= $this->identity_db_manager->getWorkPlaces('ASC');
	?>   

  </div>

</div>

<div id="<?php if($deviceName=='mobile'){ echo 'container_for_mobile'; } else { echo 'container'; } ?>">

  <div id="content" align="center"   >

    <div class="clsMarginBottom10"  ><strong><?php //echo $this->lang->line('txt_User_Login');?></strong></div>

    <?php

		if (isset($_SESSION['userId']) && $_SESSION['userId']!='')

		{

			redirect('dashboard/index/0/type/1', 'location');

		}

		//print_r($_SESSION);die;

		$this->load->helper('form'); 

		$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheckSpace();');	

		//echo form_open('/login_check', $attributes);
		echo form_open('/login_check', $attributes);

	if($this->uri->segment(1)){

?>

    <div id="teeme_login">

      <div class="clsMarginBottom10" ><span id="exp_error"></span><br /><span class="error"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';unset( $_SESSION['errorMsg']);?></span></div>

      <div class="padClass">
	  
	  	<table cellpadding="4px">
			<tr>
				<td class="leftLogin"><span class="loginLable"><?php echo $this->lang->line('txt_Email');?>: </span> </td>
				<td class="rightLogin"><span>
          <?php 

			$data = array(

						  'name'      => 'userName',

						  'id'        => 'userName',

						  'type'      => 'email',		

						  'class'   => 'loginInput text_gre'																		

						);															

			echo form_input($data);

			?>

          </span></td>
			</tr>
			<tr>
				<td class="leftLogin"><span class="loginLable"  align="left" ><?php echo $this->lang->line('txt_Password');?>: </span></td>
				<td class="rightLogin"><span>
          <?php 

			$data = array(

						  'name'      => 'userPassword',

						  'id'        => 'userPassword',

						  'type'      => 'password',		

						  'class'   => 'loginInput text_gre'																		

						);															

			echo form_input($data);

			?>

          </span></td>
			</tr>

			<!--Added by Dashrath- Keep me logged in-->
			<tr>
				<td class="leftLogin"></td>
				<td class="rightLogin">
					<input type="checkbox" name="remember" id="remember"/>
					<label for="remember-me">Keep me logged in</label>
				</td>
			</tr>
			<!--Dashrath- code end-->

			<tr>
				<td class="leftLogin"></td>
				<td class="rightLogin"><span>
			<input type="hidden" name="workPlaceId" value="<?php echo $workPlaceId;?>" />

      		<input type="hidden" name="contName" value="<?php echo $contName;?>" />

      		<input type="hidden" id="timeDiff" name="timeDiff" value="0" />
			
			<input type="hidden" id="timezoneName" name="timezoneName" value="" />
				
		  	<?php 
	
			$data = array(
	
						  'name'     => 'action',
	
						  'id'       => 'action',
	
						  'type'     => 'hidden',		
	
						  'value'    => 'userLogin'																		  				);															
	
			echo form_input($data);
	
			$data = array(
	
						  'name'    => 'Submit',
	
						  'id'      => 'Submit',
	
						  'type'    => 'submit',		
	
						  'value'   => $this->lang->line('txt_Login')															  				
						  );															
	
			echo form_input($data);
	
			?>
			
			<?php echo form_close() ;?>
		
			<?php $return_server = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME']; ?>
			</span>
			<span>
			<a href="<?php echo base_url();?>forgot_password/index/<?php echo $contName;?>/u">Forgot password?</a></br>
			</span></td>
			</tr>
			<tr>
				<td>
					
				</td>
				<td >
					<div id="loginLoader"></div>
				</td>
			</tr>
		</table>

        <?php /*?><div class="clsMarginBottom10"> 
		<span class="loginLable"><?php echo $this->lang->line('txt_Email');?>: </span> 
		<span>
          <?php 

			$data = array(

						  'name'      => 'userName',

						  'id'        => 'userName',

						  'type'      => 'email',		

						  'class'   => 'loginInput text_gre'																		

						);															

			echo form_input($data);

			?>

          </span>

          <div class='clr' ></div>

        </div>

        <div class="clsMarginBottom10"> 
		<span class="loginLable"  align="left" ><?php echo $this->lang->line('txt_Password');?>: </span>
		<span>
          <?php 

			$data = array(

						  'name'      => 'userPassword',

						  'id'        => 'userPassword',

						  'type'      => 'password',		

						  'class'   => 'loginInput text_gre'																		

						);															

			echo form_input($data);

			?>

          </span>

          <div class='clr'></div>

        </div>
		
		<!--div for editor option choice in mobile-->
		<div class="clsMarginBottom10">
		<div style="margin-left:22%;">
			<span>
			<input type="hidden" name="workPlaceId" value="<?php echo $workPlaceId;?>" />

      		<input type="hidden" name="contName" value="<?php echo $contName;?>" />

      		<input type="hidden" id="timeDiff" name="timeDiff" value="0" />
			
			<input type="hidden" id="timezoneName" name="timezoneName" value="" />
				
		  	<?php 
	
			$data = array(
	
						  'name'     => 'action',
	
						  'id'       => 'action',
	
						  'type'     => 'hidden',		
	
						  'value'    => 'userLogin'																		  				);															
	
			echo form_input($data);
	
			$data = array(
	
						  'name'    => 'Submit',
	
						  'id'      => 'Submit',
	
						  'type'    => 'submit',		
	
						  'value'   => $this->lang->line('txt_Login')															  				
						  );															
	
			echo form_input($data);
	
			?>
			
			<?php echo form_close() ;?>
		
			<?php $return_server = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME']; ?>
			</span>
			<span>
			<a href="<?php echo base_url();?>forgot_password/index/<?php echo $contName;?>/u">Forgot password?</a></br>
			</span>
			</div>
			</div><?php */?>
			<div class="clsMarginBottom10">
			<?php /*?><a href="<?php echo base_url();?>forgot_password/index/<?php echo $contName;?>/u">Forgot password?</a></br><?php */?>
			
<!--			
			  <div id="socialLogin"> 
			  
		  	<span class="flLt">Login using &nbsp;</span> <span class="flLt">
		
				<form method="POST" action="<?php echo $return_server ?>/openId/" name="gmailForm" id="gmailForm" onsubmit="return setSession();">
		
				  <input type="hidden" name="module" value="login" />
		
				  <input type="hidden" name="domain" value="https://www.google.com/accounts/o8/id" />
		
				  <a title="GMAIL" class='cursor' onclick="openlogin('gmail');">Google</a>
		
				</form>
		
				</span> <span class="flLt">,&nbsp;</span> <span class="flLt">
		
				<form method="POST" action="<?php echo $return_server ?>/openId/" name="yahooForm" id="yahooForm" onsubmit="return setSession();">
		
				  <input type="hidden" name="module" value="login" />
		
				  <input type="hidden" name="domain" value="http://me.yahoo.com" />
		
				  <a title="YAHOO" class="cursor" onclick="openlogin('yahoo');">Yahoo</a>
		
				</form>
		
				</span> <span class="flLt">&nbsp;or&nbsp;</span> <span  class="flLt">
		
				<form method="POST" action="<?php echo $return_server ?>/openId/facebook.php" name="facebookForm" id="facebookForm" onsubmit="return setSession();">
		
				  <a title="FACEBOOK" class="cursor" onclick="openlogin('fb');">Facebook</a>
		
				</form>
		
				</span>
		
				<div class="clr"></div>
		
			  </div>
		-->
			  <div class="clr"></div>
		
			</div>
      </div>

    </div>



    <?php

	}

	else{

	 ?> 

     <div style="width:37%;" id="rootBlock">

     <span class="error" id="er"></span><br />

     <div class="flLt" style="width:95%;">

         <strong class="flLt" style="width:35%;text-align:left;">Admin 

         </strong>

         

          <div class="flRt" style="width:60%;text-align:right"><strong class="flLt userPlaceName" style="width:80%;text-align:right;"><?php echo ucfirst($this->config->item("instanceName"));?></strong><button id="instanceGo">Go</button>

          </div>

         <div class="clr"></div>

     </div>

<!--     <div class="flLt" style="width:95%;">

    	<strong class="flLt" style="width:35%;text-align:left;">Place Manager  </strong>

        <div class="flRt" style="width:60%;text-align:right;">

        <input type="text" name="place_name" id="place_name" value="" placeholder="Enter place name" onkeypress="if(event.keyCode == 13){goto('place_name');}" />

        <button onclick="goto('place_name');return false;">Go</button>

        </div>

        <div class="clr"></div>

     </div>-->
<?php if($offline_mode!='1'){ ?>
     <div class="flLt" style="width:95%;">

     <strong class="flLt" style="width:30%;text-align:left;"><?php echo $this->lang->line('txt_User'); ?> </strong>

     <div class="flRt" style="width:65%;text-align:right;">
	 <!--Manoj: added return false-->
     <input type="text" name="place_name1" id="place_name1" value="" placeholder="Enter place name" onkeypress="if(event.keyCode == 13){goto('place_name1'); return false;}" size="14" />
	
     <button onclick="goto('place_name1');return false;"><?php echo $this->lang->line('txt_go'); ?></button>

     </div>

     </div>
<?php } ?>

     <div class="clr"></div>

     

  <div class="clr"></div>

</div>

	 <?php

	}?>

  </div>

</div>

<div>

  <?php //$this->load->view('common/foot.php');?>

  <?php $this->load->view('common/footer');?>

</div>

</body>

</html>

<script language="javascript">
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
	var tz = jstz.determine(); // Determines the time zone of the browser client
	var timezoneName = tz.name(); //'Asia/Kolkata' for Indian Time.
	document.getElementById('timezoneName').value = timezoneName;

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

	$.post('<?php echo base_url();?>login_check/validatePlace',{'placename':placename},function(data){

		if(data!=0){

			if(type=='place_name'){

				window.top.location='<?php echo base_url();?>place/'+placename;

			}

			else{

				window.top.location='<?php echo base_url();?>'+placename;

			}

		}

		else{

			$('#er').html("Invalid place name.");

		}

	});

}



function loginCheckSpace(){

	var userName = $('#userName').val();

	var userPass = $('#userPassword').val();

	var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;

	var err='';

	if(userName==''){

		err +="Please enter email<br />";

	}

	else if(emailTest.test(userName)==false){

		err +="Please enter valid email<br />";

	}

	if(userPass==''){

		err +="Please enter password.";

	}

	if(err==''){
	
		$('#loginLoader').html("<div id='overlay' ><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");

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