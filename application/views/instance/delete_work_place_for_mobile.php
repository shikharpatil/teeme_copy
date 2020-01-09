<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>



<title>Teeme > Delete Place</title>



<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js">

</script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js">

</script>

<script>

function confirmDeleteWorkPlace ()

{

	var msg = '<?php echo $this->lang->line('msg_place_delete');?>';

	if (confirm(msg) == 1)

	{

		return true;

	}

	else

	{

		return false;

	}

}

</script>

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>



					

					  

      

            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php   $this->load->view('instance/common/top_links_for_mobile');?> 

					<!-- End Top Links -->

                  </td>

                </tr>

            </table>

               <!-- Main Body -->

        <div style="float:left;margin:5%;text-align:justify;">

						<?php

						$this->load->helper('form'); 

						$attributes = array('name' => 'frmlogin', 'method' => 'post', 'onsubmit' => 'return loginCheck(this)');	

						echo form_open('instance/home/delete_work_place/'.$workPlaceDetails['workPlaceId'].'/'.$this->uri->segment(5), $attributes);

						?>

                        <?php echo $this->lang->line('about_to_delete_place'); ?> <strong><?php echo $this->uri->segment(5);?></strong>. <?php echo $this->lang->line('to_confirm_delete_enter_password_txt'); ?> <br />

                            <span class="style1 errorMsg"><?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?></span>

                            <br />

                            Password:<br />

                                <?php 

                                $data = array(

                                              'name'      => 'userPassword',

                                              'id'        => 'userPassword',

                                              'type'      => 'password',		

                                              'size'      => '20',

                                              'class'   => 'text_gre'																		

                                            );															

                                echo form_input($data);

                                ?>												

                                

                                <?php 

                                $data = array(

                                              'name'      => 'Submit',

                                              'id'        => 'Submit',

                                              'type'      => 'submit',		

                                              'value'     => 'Confirm',

                                              'class'     => 'button01'																		  																		

                                            );															

                                echo form_input($data);

                                ?>	

                          

<?php

echo form_close();

?>																

				<!-- Main Body -->

</div>

<div class="clr"></div>				



   



<?php $this->load->view('common/footer');?>

</body>

</html>

