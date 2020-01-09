<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no"/>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>



<title>Teeme > View Places</title>



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

<?php 

					$this->load->view('instance/common/top_links_for_mobile');

					?>   

      

            	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>

                  <td width="100%" align="left" valign="top">

                  	<!-- Begin Top Links -->			

					  

					<!-- End Top Links -->

                  </td>

                </tr>

                <tr>

                  <td align="left" valign="top">

					<!-- Main Body -->

					<table width="99%"  border="0">

                    <tr>

                        <td colspan="5" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

            <ul class="tab_menu_new_up_for_mobile">

                				<li><a href="<?php echo base_url()?>instance/home/view_work_places" class="active"><span><?php echo $this->lang->line('txt_View_Workplaces');?></span></a></li>

                				<li><a href="<?php echo base_url()?>instance/home/create_work_place"><span><?php echo $this->lang->line('txt_Create_Workplace');?></span></a></li>

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

                <td colspan="5" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              </tr>

              <?php

				}

				

				?>

              <?php

		if(count($workPlaceDetails) > 0)

		{

		?>

              <tr>

                <td width="1%">&nbsp;</td>

                <td width="20%"><strong><?php echo $this->lang->line('txt_Workplace_Name');?></strong></td>

               <?php /*?> <td width="33%"><strong><?php echo $this->lang->line('txt_Manager');?> </strong></td><?php */?>

               <td width="35%"><strong><?php echo $this->lang->line('txt_Created_Date');?> </strong></td>

                <td width="40%" align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

              </tr>

              <?php

			$i = 1;

			foreach($workPlaceDetails as $keyVal=>$workPlaceData)

			{				

				if($workPlaceData['workPlaceManagerId'] == 0)

				{

					$workPlaceManager = $this->lang->line('txt_Not_Assigned');

				}

				else

				{					

					$arrUserDetails = $this->identity_db_manager->getPlaceManagerDetailsByPlaceManagerId($workPlaceData['workPlaceManagerId']);

					$workPlaceManager = $arrUserDetails['firstName'] .' ' .$arrUserDetails['lastName'];

				}

			?>

              <tr >

                <td >&nbsp;</td>

                <td style="font-size:0.85em;  padding-top: 5%;" ><?php echo $workPlaceData['companyName'];?></td>

               <?php /*?> <td><?php //echo $workPlaceManager;?></td><?php */?>
				
                <td style="font-size:0.85em; padding-top: 5%;" ><?php echo $this->time_manager->getUserTimeFromGMTTime($workPlaceData['companyCreatedDate'], 'm-d-Y h:i A');?></td>

                <td style="padding-top: 5%;">

                <?php

                	if($workPlaceData['status'] == 0)

					{

				?>

			    	<a href="<?php echo base_url();?>instance/home/activateWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer;"></a>

				<?php

					}

					else

					{

				?>

                	<a href="<?php echo base_url();?>instance/home/suspendWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer;"></a>

                <?php

					}

				?>

                <a href="<?php echo base_url();?>instance/home/edit_work_place/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/edit.gif" alt="<?php echo $this->lang->line('txt_Edit');?>" border="0"></a>&nbsp;&nbsp;

                <a href="<?php echo base_url();?>instance/home/delete_work_place/<?php echo $workPlaceData['workPlaceId'];?>/<?php echo $workPlaceData['companyName'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" alt="<?php echo $this->lang->line('txt_Delete');?>" border="0"></a>&nbsp;&nbsp;

	<a href="<?php echo base_url()?>instance/home/add_work_place_manager/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/addnew.png" title="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" alt="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" border="0"></a>
	
 <a href="<?php echo base_url()?>instance/home/view_place_managers/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/manage_users.gif" title="<?php echo $this->lang->line('txt_View_Place_Managers');?>" alt="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" border="0"></a>
                <?php

				/*

                <a href="<?php echo base_url();?>instance/home/delete_work_place/<?php echo $workPlaceData['workPlaceId'];?>" onClick="return confirmDelete()"><img src="<?php echo base_url();?>images/delete.gif" alt="Delete" border="0"></a>

                */

				?>

                </td>

              </tr>

              <?php

				$i++;					

			}

		}

		else

		{

		?>

              <tr>

                <td colspan="5"><?php echo $this->lang->line('msg_workplaces_not_available');?></td>

              </tr>

              <?php

		}

		?>

            </table>

				<!-- Main Body -->

				

				</td>

                </tr>

            </table>

   



<?php $this->load->view('common/footer');?>

</body>

</html>

