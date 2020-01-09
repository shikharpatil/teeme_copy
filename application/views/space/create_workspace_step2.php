<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>
<?php $this->load->view('common/view_head.php');?>


	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

function showFilteredManagers()
{

	//alert ('Here');

	var toMatch = document.getElementById('showManagers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

			<?php
			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	
			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="mngrs" name="workSpaceManagers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMan').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>


}

function showFilteredMembers()

{

	//alert ('Here');

	var toMatch = document.getElementById('showMembers').value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			

			foreach($workPlaceMembers as $keyVal=>$workPlaceMemberData)	

			{

				if ($workPlaceMemberData['userId'] != $_SESSION['userId'])

				{

			?>
//Manoj: replace mysql_escape_str function
			var str = '<?php echo $this->db->escape_str($workPlaceMemberData['tagName']); ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" class="mngrs" name="workSpaceMembers[]" value="<?php echo $workPlaceMemberData['userId'];?>"/><?php echo $workPlaceMemberData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

}
</script>

</head>

<body>
			<?php $this->load->view('common/header'); ?>
			<?php $this->load->view('common/wp_header'); ?>
			

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
			//if ($_SESSION['workPlacePanel'] != 1)
			//{
				$this->load->view('common/artifact_tabs', $details);

			//}
			?>

			

		<div id="container" style="padding:20px 0px 40px">

		<div id="content">
		
				<div class="menu_new" >

           

						<ul class="tab_menu_new1">
						<!--Manoj: Tabs are showing to placemanager only-->
						<?php
						if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
						?>

						<li><a href="<?php echo base_url()?>manage_workplace"><span><?php echo $this->lang->line('txt_View_Workspaces');?></span></a></li>

						<?php 
						}
						?>
						<!--Manoj: Tabs are showing to placemanager only end-->
						
						<li><a href="<?php echo base_url()?>create_workspace" class="active"><span><?php echo $this->lang->line('txt_Create_Workspace');?></span></a></li>

						<!--Manoj: Tabs are showing to placemanager only-->
						<?php
						if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
						?>
						<li><a href="<?php echo base_url()?>view_workplace_members"><span><?php echo $this->lang->line('txt_View_Members');?></span></a></li>

						<li><a href="<?php echo base_url()?>add_workplace_member"><span><?php echo $this->lang->line('txt_Create_Member');?></span></a></li>

						<?php if($_COOKIE['istablet']==0){?>

                            <li><a href="<?php echo base_url()?>add_workplace_member/registrations"  ><span><?php echo $this->lang->line('txt_Bulk_Registrations');?></span></a></li>

                            <?php

							}?>

							<li><a href="<?php echo base_url()?>view_metering/metering"  ><span><?php echo $this->lang->line('txt_Stats');?></span></a></li>
							
							<li><a href="<?php echo base_url()?>place_backup"><span><?php echo $this->lang->line('txt_Backups');?></span></a></li>
							
						<?php 
						}
						?>
						<!--Manoj: Tabs are showing to placemanager only end-->

                        	<li><a href="<?php echo base_url()?>help/place_manager"><span><?php echo $this->lang->line('txt_Help');?></span></a></li>

						</ul>		

					<div class="clr"></div>

					</div>		

				<form id="frmCreateTree" name="frmCreateTree" action="<?php echo base_url();?>create_workspace/create_tree" method="post">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<?php

				

				if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	
				
				<?php

				

				if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

				{

				?>

                <tr>

				    <td class="tdSpace"><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>

                </tr>

				<?php

				}

				

				?>	

				  

				<tr>

                    <td class="subHeading">Step 2 of 2: <?php echo $this->lang->line('txt_Create_Trees');?></td>

		      	</tr>

				 <tr>

				   <td class="tdSpace">					

					<table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#111111" class="text_gre1" id="table12" style="border-collapse: collapse;" align="center">               
                       <tr>

                         <td width="100" align="right" valign="middle" class="text_gre1"><?php echo $this->lang->line('txt_Select_Tree_Type');?><span class="text_red">*</span></td>

                         <td width="5" align="center" valign="middle" class="text_gre"><strong>:</strong></td>

                         <td width="485" align="left" class="text_gre">
						   	<select name="treeType" id="treeType">
								<option value="document"><?php echo $this->lang->line('txt_Document');?></option>
								<option value="discuss"><?php echo $this->lang->line('txt_Discuss');?></option>
								<option value="task"><?php echo $this->lang->line('txt_Task');?></option>
								<option value="notes"><?php echo $this->lang->line('txt_Notes');?></option>
								<?php /* <option value="contact"><?php echo $this->lang->line('txt_Contact');?></option> */ ?>
							</select>
                         </td>
                       	</tr> 
						
						<tr>

                         <td align="right" valign="top" class="text_gre1"><?php echo $this->lang->line('txt_Tree_Title');?><span class="text_red">*</span></td>

                         <td width="5" align="center" valign="top" class="text_gre"><strong>:</strong></td>

                         <td align="left" class="text_gre"><textarea id="treeTitle" name="treeTitle"/></textarea></td>

                       </tr>                  
                   </table>

							 

				   </td>

			    </tr>



			    <tr>

				  	<td align="left">
						<div style="padding:0 0 0 320px;">
							<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">
							<input type="hidden" name="workSpaceType" value="1">
							<input name="submit" type="button" id="submit" value="<?php echo $this->lang->line('txt_Create');?>" onclick="createTree();">
							<input name="spaceFinish" type="button" id="spaceFinish" value="Finish" onclick="gotoDashboard();">
						
							<span id="createTreeStatus" style="padding:0 0 0 10px;"></span>
						</div>
					</td>

			    </tr>

			  </table>		

		 			 </form>

					 

				</div></div>	 
				<?php $this->load->view('common/foot.php');?>
			<!-- Footer -->	

				<?php $this->load->view('common/footer');?>

			<!-- Footer -->

    

</body>

</html>
<script>
function gotoDashboard()
{
	if (document.getElementById("spaceFinish")!=null)
	{
		location.href = "<?php echo base_url();?>dashboard/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1";
		return false;
	}
}
function createTree(){
    $.ajax({
    type: "POST",
    url: baseUrl+"create_workspace/create_tree",
    data: jQuery("#frmCreateTree").serialize(),
    cache: false,
    success:  function(data){
       /* alert(data); if json obj. alert(JSON.stringify(data));*/
	  // $('#createTreeStatus').html(data);
	  jAlert(data);
	  $('#treeTitle').val('');
    }
  });
}
</script>
