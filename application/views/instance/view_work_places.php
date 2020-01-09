<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

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

<?php $this->load->view('common/admin_header');?>

<table width="900px" border="0" align="center" cellpadding="0" cellspacing="0">
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

                        <td colspan="5" align="left" valign="top" class="tdSpace">

                        	<div class="menu_new" >

            <ul class="tab_menu_new1">

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

                <td colspan="4" class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

              </tr>

              <?php

				}			


				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

              <tr>

                <td colspan="4" class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

              </tr>

              <?php

				}			


		if(count($workPlaceDetails) > 0)

		{

		?>

              <tr>

                <td width="1%">&nbsp;</td>

                <td width="30%"><strong><?php echo $this->lang->line('txt_Workplace_Name');?></strong></td>

<!--                <td width="26%"><strong><?php //echo $this->lang->line('txt_Manager');?> </strong></td>-->

                <td width="21%"><strong><?php echo $this->lang->line('txt_Created_Date');?> </strong></td>

                <td width="39%" align="center"><strong><?php echo $this->lang->line('txt_Action');?></strong></td>

              </tr>

              <?php

			$i = 1;

			foreach($workPlaceDetails as $keyVal=>$workPlaceData)

			{				


			?>

              <tr>

                <td>
				<?php 
				if($workPlaceData['workPlaceManagerId'] == 0)

				{

					$workPlaceManager = $this->lang->line('txt_Not_Assigned');

				}

				else if ($i<29)

				{	
				
					//echo "<li>i= " .$i;
                    $workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceData['workPlaceId']);
					$place_name = mb_strtolower($workPlaceData['companyName']);
                    $config['hostname'] = $workPlaceData['server'];
                    $config['username'] = $workPlaceData['server_username'];
                    $config['password'] = $workPlaceData['server_password'];
                                                                $config['database'] = $this->config->item('instanceDb').'_'.$place_name;
                                                                $config['dbdriver'] = $this->db->dbdriver;
                                                                $config['dbprefix'] = $this->db->dbprefix;
                                                                $config['pconnect'] = FALSE;
                                                                $config['db_debug'] = $this->db->db_debug;
                                                                $config['cache_on'] = $this->db->cache_on;
                                                                $config['cachedir'] = $this->db->cachedir;
                                                                $config['char_set'] = $this->db->char_set;
                                                                $config['dbcollat'] = $this->db->dbcollat;									

					$arrUserDetails = $this->identity_db_manager->getPlaceManagerDetailsByPlaceManagerId($workPlaceData['workPlaceManagerId'],$config);

					$workPlaceManager = $arrUserDetails['firstName'] .' ' .$arrUserDetails['lastName'];

				} ?></td>

                <td><?php echo $workPlaceData['companyName'];?></td>

<!--                <td><?php //echo $workPlaceManager;?></td>-->

                <td><?php echo $this->time_manager->getUserTimeFromGMTTime($workPlaceData['companyCreatedDate'], 'm-d-Y h:i A');?></td>

                <td align="center">

                <?php

                	if($workPlaceData['status'] == 0)

					{

				?>

			    	<span style="margin-right:7px;"><a href="<?php echo base_url();?>instance/home/activateWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0" style="cursor:pointer;"></a></span>

				<?php

					}

					else

					{

				?>

                	<span style="margin-right:7px;"><a href="<?php echo base_url();?>instance/home/suspendWorkPlace/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0" style="cursor:pointer;"></a></span>

                <?php

					}

				?>

                <span style="margin-right:7px;"><a href="<?php echo base_url();?>instance/home/edit_work_place/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/edit.gif" title="<?php echo $this->lang->line('txt_Edit');?>" alt="<?php echo $this->lang->line('txt_Edit');?>" border="0"></a></span>

                <span style="margin-right:7px;"><a href="<?php echo base_url();?>instance/home/delete_work_place/<?php echo $workPlaceData['workPlaceId'];?>/<?php echo $workPlaceData['companyName'];?>"><img src="<?php echo base_url();?>images/icon_delete.gif" title="<?php echo $this->lang->line('txt_Delete');?>" alt="<?php echo $this->lang->line('txt_Delete');?>" border="0"></a></span>

                <span style="margin-right:7px;"><a href="<?php echo base_url()?>instance/home/add_work_place_manager/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/addnew.png" title="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" alt="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" border="0"></a></span>

               <span><a href="<?php echo base_url()?>instance/home/view_place_managers/<?php echo $workPlaceData['workPlaceId'];?>"><img src="<?php echo base_url();?>images/manage_users.gif" title="<?php echo $this->lang->line('txt_View_Place_Managers');?>" alt="<?php echo $this->lang->line('txt_Add_Place_Manager');?>" border="0"></a></span>

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

                <td colspan="4"><?php echo $this->lang->line('msg_workplaces_not_available');?></td>

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

