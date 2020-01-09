<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme > View Place Managers</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	 <script type="text/javascript" src="<?php echo base_url();?>editor/TeemeEditor.js"></script> 	

	 <script language="JavaScript1.2">mmLoadMenus();</script>

<script>

function confirmDeleteMember ()

{

	var msg = '<?php echo $this->lang->line('msg_member_deactivate');?>';

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



<?php $this->load->view('common/admin_header'); ?>

   


			<!-- Main menu -->	

         

			<?php /*?><div id="container" style="padding:20px 0px 40px">



				<div id="content"><?php */?>
                                
                                    <table width="<?php echo $this->config->item('page_width')-25;?>" border="0" align="center" cellpadding="0" cellspacing="0" class="admin_view_manager">
                                        <tr>
                                            <td width="100%" align="left" valign="top">
                                                <?php $this->load->view('instance/common/top_links');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" align="left" valign="top">
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
                                        <tr>
                                            <td width="100%" align="left" valign="top">
				 <div style="width:90%">

			<?php

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

           

              <!-- <td width="7%">&nbsp;</td>-->

			

           <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            

            <?php

				}

				

				?>

                        	<form name="frmSearch" action="<?php echo base_url()?>instance/home/view_place_managers/<?php echo $workPlaceId;?>" method="post" onsubmit="return checkValidMember(this);">
							
					<div style="margin-top:1%;">		

					<div class="flLt" style="margin-top:4px; margin-left:5px;">		

                            <input type="text" name="search1" value="<?php echo $this->input->post('search1');?>" id="search" /></div>

                    <div class="flLt">		        

				  		    <input type="submit" name="submit" style="margin-left:5px;padding:0px 5px;margin-top:6px;" value="<?php echo $this->lang->line('txt_Search');?>"/>

                    </div>

                    <div class="clr"></div>
					</div>

                            </form>

           </div>   

            <div style="width:90%; margin-left:1%;" >

            <?php

		if(count($placeManagerDetails) > 0)

		{

		?>

         <!-- <td width="7%">&nbsp;</td>-->
			 <div style="margin-top:1%;">
			 	<b><?php echo $this->lang->line('txt_Workplace').': ';?></b><?php echo $workPlaceDetails['companyName'];?>
			 </div>
			<div style="margin-top:1%;">
             <div class="flLt memberMobileView"> <strong><?php echo $this->lang->line('txt_Manager');?></strong></div>

             <div class="flLt memberMobileView" style="margin-left:3%;" > <strong><?php echo $this->lang->line('txt_Tag_Name');?></strong></div>

              

            <!--  <td width="28%"><strong><?php echo $this->lang->line('txt_Added_Date');?></strong></td>-->

             <div class="flLt" style="margin-left:3%;"> <strong><?php echo $this->lang->line('txt_Action');?></strong></div>

            <div class="clr"></div>
			</div>

            <?php

			$i = 1;

			foreach($placeManagerDetails as $keyVal=>$placeManagerData)

			{ 

				$this->load->model('dal/identity_db_manager');

				$objIdentity	= $this->identity_db_manager;							

			?>

           

            
			<div class="managerDetails" style="margin-top:0.8%;">
              <div class="flLt memberMobileView"><?php echo $placeManagerData['firstName'].' '.$placeManagerData['lastName'];?></div>
			  <div class="flLt memberMobileView" style="margin-left:3%;">       <?php echo ($placeManagerData['tagName'])?$placeManagerData['tagName']:"&nbsp;";?></div>
			  <div class="flLt" style="margin-left:3%;">


              	<?php

				if ($placeManagerData['status']==0)

				{

				?>

              	&nbsp;&nbsp;<a href="<?php echo base_url();?>instance/home/delete_place_member/<?php echo $placeManagerData['userId'];?>/1/<?php echo $workPlaceId;?>" onClick="return confirmDeleteMember();"><img src="<?php echo base_url();?>images/icon_pause.gif" alt="<?php echo $this->lang->line('txt_Suspend');?>" title="<?php echo $this->lang->line('txt_Suspend');?>" border="0"></a>

            	<?php

				}

				else

				{

				?>

                &nbsp;&nbsp;<a href="<?php echo base_url();?>instance/home/delete_place_member/<?php echo $placeManagerData['userId'];?>/0/<?php echo $workPlaceId;?>"><img src="<?php echo base_url();?>images/icon_correct.gif" alt="<?php echo $this->lang->line('txt_Activate');?>" title="<?php echo $this->lang->line('txt_Activate');?>" border="0"></a>

                <?php

				}

				?> </div>
				</div>
				<div class="clr"></div>

               

           

            <?php

			  

				$i++;					

			}

		}

		else

		{

		?>

            <?php echo $this->lang->line('txt_None');?>

            

            <?php

		}

		?>

		</div> 
                                            </td>
                                        </tr>
                                    </table>



			

			




		 

<?php /*?></div></div><?php */?>			

		

				<?php $this->load->view('common/footer');?>

			

  </body>

</html>

