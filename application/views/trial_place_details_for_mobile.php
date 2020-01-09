<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme</title>

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

<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

</head>

<body>

<?php $this->load->view('common/admin_header_for_mobile'); ?>
<div id="container" style="padding-top:5px; width:89%;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr> 

    <td valign="top">

        <table width="100%" border="0" cellpadding="0" cellspacing="0">

                 

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
				
				 	<table width="100%" border="0" cellspacing="3" cellpadding="3" style="padding:0%;">
					<tr><td colspan="2"><div class="successMsg"><?php echo $this->lang->line('place_created_successfully');?></div></td></tr>
					<?php /*?><tr><td colspan="2" class="heading">Teeme - Trial Place Details</td></tr><?php */?>
					<tr><td class="heading" colspan="2" style="padding-top:2%;"><?php echo $this->lang->line('txt_Workplace_Details');?></td></tr>
					<?php if(isset($_SESSION['placeUrl']) && $_SESSION['placeUrl'] !=	""){ ?>
					<tr><td width="200">Place Url:</td><td><a href="<?php echo $_SESSION['placeUrl'];?>"> <?php echo $_SESSION['placeUrl']; $_SESSION['placeUrl']=''; ?></a></td></tr>
					<?php } ?>
					<?php if(isset($_SESSION['placeName']) && $_SESSION['placeName'] !=	""){ ?>
					<tr><td>Place Name:</td><td> <?php echo $_SESSION['placeName']; $_SESSION['placeName']=''; ?></td></tr>
					<?php } ?>
					<?php if(isset($_SESSION['expiry']) && $_SESSION['expiry'] !=	""){ ?>
					<tr><td>Expiry Date:</td><td> <?php echo $_SESSION['expiry']; $_SESSION['expiry']=''; ?></td></tr>
					<?php } ?>
					<?php if(isset($_SESSION['numberOfUsers']) && $_SESSION['numberOfUsers'] !=	""){ ?>
					<tr><td>Number Of Users:</td><td> <?php echo $_SESSION['numberOfUsers']; $_SESSION['numberOfUsers']=''; ?></td></tr>
					<?php } ?>
					
					<tr><td class="heading" colspan="4" style="padding-top:3%;"><?php echo $this->lang->line('txt_Workplace_Manager_Details');?></td></tr>
					<?php if(isset($_SESSION['fName']) && $_SESSION['fName'] !=	""){ ?>
					<tr><td>First Name: </td><td><?php echo $_SESSION['fName']; $_SESSION['fName']=''; ?></td></tr>
					<?php } ?>
					<?php if(isset($_SESSION['lName']) && $_SESSION['lName'] !=	""){ ?>
					<tr><td>Last Name:</td><td> <?php echo $_SESSION['lName'];  $_SESSION['lName']=''; ?></td></tr>
					<?php } ?>
					<?php if(isset($_SESSION['email']) && $_SESSION['email'] !=	""){ ?>
					<tr><td>Email:</td><td> <?php echo $_SESSION['email']; $_SESSION['email']=''; ?></td></tr>
					<?php } ?>
					</table>
				

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

        </table>

    </td>

  </tr>



</table>
</div>

<!-- Footer -->	
<?php  $this->load->view('common/footer');?>


</body>

</html>