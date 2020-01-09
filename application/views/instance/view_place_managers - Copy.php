<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<script>

//Global js variable used to store the site URL

var baseUrl = '<?php echo base_url();?>';	

</script>

<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/login_check.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

</head>

<body>

<?php $this->load->view('common/admin_header'); ?>



        <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0">

          

          <tr>

            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="<?php echo $this->config->item('page_width')-55;?>" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					<?php 

					$this->load->view('instance/common/top_links');

					?>     

					<!-- End Top Links -->

                  </td>

                </tr>



                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="99%"  border="0">

              		<tr>

                        <td colspan="4" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

            <ul class="tab_menu_new1">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>

                                                <li><a href="<?php echo base_url()?>instance/home/view_place_managers/<?php echo $workPlaceId;?>" class="active"><span><?php echo $this->lang->line('txt_View_Place_Managers');?></span></a></li>

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

                <td colspan="3" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              </tr>

              <?php

				}

				

				?>

            

	  			<?php

					if(count($placeManagerDetails) > 0)

					{

				?>   

			  <tr>		         

                <td width="4%">&nbsp;</td>

                <td width="29%"><strong>&nbsp;<?php //echo $this->lang->line('txt_User_Name');?></strong></td>               

                <td width="13%" align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

              </tr>

              <?php

			$i = 1;

			foreach($placeManagerDetails as $keyVal=>$placeManagerData)

			{				

			?>

              <tr>

                <td>&nbsp;</td>

                <td><?php echo $placeManagerData['userName'];?></td>               

                <td align="center"><a href="<?php echo base_url();?>instance/home/edit_admin/<?php echo $placeManagerData['userId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="Change Password" border="0"></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>instance/home/delete_admin/<?php echo $placeManagerData['userId'];?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="Delete" border="0"></a></td>

              </tr>

              <?php

				$i++;					

			}

		}

		else

		{

		?>

              <tr>

                <td colspan="5"><?php echo $this->lang->line('msg_managers_not_assigned');?></td>

              </tr>

              <?php

		}

		?>

            </table>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table></td>

          </tr>

          

        </table>

    

<?php $this->load->view('common/footer');?>

</body>

</html>

