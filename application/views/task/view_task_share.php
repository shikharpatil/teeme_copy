<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<?php //echo "workspaceId= " .$workSpaceId; exit;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';		

</script>



</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php //$this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container">



	<div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
	</div>
  	<!-- Commented by Dashrath- change div id-->
      <!-- <div id="content">  -->
      <div id="rightSideBar"> 



            <?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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
			
			$day 	= date('d');

			$month 	= date('m');

			$year	= date('Y');

?>

          	

            

			

<!-- 			<div class="menu_new" >

            <ul class="tab_menu_new">

				<li class="task-view"><a class="1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>

				<li class="time-view"><a   href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"  title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				

				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

						

    			<li class="link-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"      title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>

					

				 <li class="talk-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

				 

				<li class="task-calendar"><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar_View');?>" ></a></li>

				

                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" ></a></li>

				

				

				

					

            	<?php

				if (($workSpaceId==0))

				{

				?>

                 <li  class="share-view_sel"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6" class="active" title="<?php echo $this->lang->line('txt_Share');?>"></a></li>

                <?php

				}

				?>

				

				<li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li>
				
				<?php 
														/*Code for follow button*/
															/*$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='task';	
															$this->load->view('follow_object',$treeDetails); */
														/*Code end*/
														?>

            </ul>

			<div class="clr"></div>

        </div> -->

        <div id="divSeed" class="seedBackgroundColorNew shareSeedDivHeight">
	  		<!-- Div contains tabs start-->
			<?php $this->load->view('task/task_seed_header'); ?>
		    <!-- Div contains tabs end-->
	    	<div class="clsNoteTreeHeader handCursor">
              	<div style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
		            <?php
		            echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>'); 
		            ?>
          		</div>
              	<?php
	            if (!empty($arrDiscussionDetails['old_name']))
	            {
	                echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDiscussionDetails['old_name']),'<span><img>').')</div>';
	            }
			  	?>
            </div>
		</div> 
		<div class="treeLeafRowStyle2"></div>
		<div class="rightSideContentDiv">

			
			<!--Added by Dashrath- Add for close share ui-->
			<div>
				<a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Close');?>" class="shareCloseIcon">
					<img src="<?php echo  base_url(); ?>images/close.png">
				</a>
			</div>
			<!--Dashrath- code end-->

			 <!--Changed by Dashrath- remove dashboard_bg class from table tag-->
			 <table width="100%" border="0"  cellpadding="0" cellspacing="0" class="" style="padding-top:1%;">
      <?php
			if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
			{
			?>
      <tr>
        <td><span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
      </tr>
      <?php
			}
			
			?>
		<?php
			if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")
			{
			?>
      <tr>
        <td><span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>
      </tr>
      <?php
			}
			
			?>
      <tr>
        <td align="left" valign="top" style="width:35%;"><?php       
						if($this->input->post('users') != '')
						{
							$by = $this->input->post('users');
						}	
						
					?>  

<script>

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

			if ($workPlaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="users[]" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_All');?><br>';

				}

				<?php

			}



			foreach($workPlaceMembers as $arrData)	

			{

				if (in_array($arrData['userId'],$sharedMembers) && $arrData['userGroup']>0)

				{

					?>

					var str = '<?php echo $arrData['tagName']; ?>';

					

					var pattern = new RegExp('\^'+toMatch, 'gi');

					

					

		

					if (str.match(pattern))

					{

						val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';

						document.getElementById('showMem').innerHTML = val;

					}

				

					<?php
					
					//Get checked userlabel
						if ($arrDiscussionDetails['userId']==$_SESSION['userId'])
						{
							if($arrDiscussionDetails['userId']!=$arrData['userId'])
							{
								$content .= '<div class="sol-selected-display-item sol_check'.$arrData['userId'].'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('.$arrData['userId'].',1); ">x</span><span class="sol-selected-display-item-text">'.$arrData['tagName'].'</span></div>';
							}
						}
						//Code end

				}

        	}

			

			foreach($workPlaceMembers as $arrData)	

			{

				if (!in_array($arrData['userId'],$sharedMembers) && $arrData['userGroup']>0)

				{

					?>

					var str = '<?php echo $arrData['tagName']; ?>';

					

					var pattern = new RegExp('\^'+toMatch, 'gi');

					

					

		

					if (str.match(pattern))

					{
						/*Commented by Dashrath- comment input field old code and add new code below with some changes for by default show checked orignator*/
						// val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';

						val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if ($arrDiscussionDetails['userId']==$arrData['userId']) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';

						document.getElementById('showMem').innerHTML = val;

					}

				

					<?php

				}

        	}

        	?>

			var list = $("#list").val();

			var val1 = list.split(",");

			

			$(".clsCheck").each(function(){

				 if(val1.indexOf($(this).val())!=-1){

					$(this).attr("checked",true);

				 }

			});

			

		}

}

</script>                                 

                  <!-- Main Body -->
				  
				   <?php 
			
					$sharedMembersList = implode(",",$sharedMembers); 
					//echo $sharedMembersList;
					
				   ?>
				  

					<form name="frmCal" action="<?php echo base_url()?>view_task/share/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post">

                  

					<table width="100%" border="0" cellspacing="3" cellpadding="3">



					<tr>

						<td width="15%" align="left" valign="top" class="tdSpace"> 

                        	<?php echo $this->lang->line('txt_Members');?>: 

                        </td>

						<td width="85%" align="left" valign="top" class="tdSpace"> 

							<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/>  

                        </td>                        

                    </tr> 

					<tr>

						<td width="15%" align="left" valign="top" class="tdSpace">&nbsp; 

                        	

                        </td>

						<td width="85%" align="left" valign="top" class="tdSpace"> 

							<div id="showMem" style="height:120px; width:300px; overflow:scroll;">

        					<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($arrDiscussionDetails['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/> <?php echo $this->lang->line('txt_All');?><br />



            				<?php	

							foreach($workPlaceMembers as $arrData)

							{

								if (in_array($arrData['userId'],$sharedMembers) && $arrData['userGroup']>0)

								{						

							?>

                    				<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /> 

									<?php echo $arrData['tagName'];?><br />

							<?php

								}

							}

							

							foreach($workPlaceMembers as $arrData)

							{

								if (!in_array($arrData['userId'],$sharedMembers) && $arrData['userGroup']>0)

								{						

							?>
									<!--Commented by Dashrath- comment input field old code and add new code below with some changes for by default show checked orignator-->
                    				<!-- <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" />  -->

                    				 <!--Added by Dashrath- Add for show by default checked orignator-->
                    				<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if ($arrDiscussionDetails['userId']==$arrData['userId']) { echo 'checked="checked"';}?> <?php if (($arrDiscussionDetails['userId']!=$_SESSION['userId']) || ($arrDiscussionDetails['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" />
                    				<!--Dashrath- code end--> 

									<?php echo $arrData['tagName'];?><br />

							<?php

								}

							}

							?>

    						</div> 

                        </td>  
						
						                   

                    </tr>   

					<tr>

						<td width="15%" align="left" valign="top" class="tdSpace">&nbsp; 

                        	 

                        </td>

						<td width="85%" align="left" valign="top" class="tdSpace">  

                        	<input type="hidden" name="treeId" value="<?php echo $treeId; ?>" /> 

                            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId; ?>" /> 

                            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType; ?>" />  

                             <input type="hidden" name="list" id="list" value="<?php echo $sharedMembersList; ?>"/> 

                            <?php

							if ($arrDiscussionDetails['userId'] == $_SESSION['userId'])

							{

							?>                

            				<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_Ok');?>" class="button01">

                            <input type="reset" name="Clear" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearUserLabels();">

                        	<?php

							}

							?>

                        </td>

                    </tr>

                    </table>                



                    </form>   
					</td>
					<td align="left" valign="top">
						<div class="sol-current-selection" style="max-height:250px; overflow-y:scroll;"></div>
					</td>
					</tr>
					</table>   

                  <!-- Main Body -->


              </div>

             

         

</div>

<!--Added by Dashrath- load notification side bar-->
<?php $this->load->view('common/notification_sidebar.php');?>
<!--Dashrath- code end-->

</div>

<?php $this->load->view('common/foot.php');?>

<?php //$this->load->view('common/footer');?>

</body>
</html>	
<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>
<script>
	function checkAllFunction(){
		
		var htmlContent='';

		if($("#checkAll").prop("checked")==true){

			$('.clsCheck').prop("checked",true);

			$(".clsCheck").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(value+","+$(this).val());

				}
				
				//Show checked label at top
					var data = $(this).data('myval');
					var value = $(this).val();
					htmlContent += '<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1)">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>';
				//Code end

			});
			
			$('.sol-current-selection').html(htmlContent);

		}

		else{

			//change prop to attr for server - Monika

			$('.clsCheck').prop("checked",false);

			$(".clsCheck").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#list").val(arr);

			});
			
			$('.sol-current-selection').html('');

		}

	}

	

	//$('.clsCheck').live("click",function()
	$(document).on('click', '.clsCheck', function(){
	
		var data = $(this).data('myval');
		var value = $(this).val();

		val = $("#list").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#list").val()==''){

				$("#list").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(val+","+$(this).val());

				}

			}
			addSelectionDisplayItem(data,value,$(this));

		}

		else{

			var index = val1.indexOf($(this).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list").val(arr);
			
			removeSelectionDisplayItem(value);

		}

	});
	
function addSelectionDisplayItem(data,value,changedItem)
{
		$('.sol-current-selection').append('<div class="sol-selected-display-item sol_check'+value+'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('+value+',1); ">x</span><span class="sol-selected-display-item-text">'+data+'</span></div>');
		
}

function removeSelectionDisplayItem(value,uncheck)
{
	$('.sol_check'+value).remove();
		
		if(uncheck=='1')
		{
			$('.remove'+value).prop('checked', false);
			
			val = $("#list").val();
	
			val1 = val.split(",");
			
			var index = val1.indexOf($('.remove'+value).val());
	
			val1.splice(index, 1);
	
			var arr = val1.join(",");
	
			$("#list").val(arr);
			
		}
		
}

$(document).ready(function(){
	$('.sol-current-selection').html('<?php echo $content; ?>');
});

function clearUserLabels()
{
	$('.sol-current-selection').html('<?php echo $content; ?>');
}	

</script>