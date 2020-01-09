<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Notes > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

<?php //$this->load->view('editor/editor_js.php');?>

	<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

	

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

					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if ($treeDetail['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="users[]" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($treeDetail['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}



			foreach($workPlaceMembers as $arrData)	

			{

				if (in_array($arrData['userId'],$sharedMembers))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($treeDetail['userId']!=$_SESSION['userId']) || ($treeDetail['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			foreach($workPlaceMembers as $arrData)	

			{

				if (!in_array($arrData['userId'],$sharedMembers))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($treeDetail['userId']!=$_SESSION['userId']) || ($treeDetail['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /><?php echo $arrData['tagName'];?><br>';

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



</head>

<body>





<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile">



		<div id="content">







			<div class="menu_new">

								<ul class="tab_menu_new_for_mobile">

									<li  class="notes-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Notes_View');?>" ></a></li>

                				<li  class="time-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

								<li class="tag-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"></a></li>

            					<li  class="link-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>

								 <li  class="talk-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

            					<?php

								if (($workSpaceId==0))

								{

								?>

                					<li  class="share-view_sel"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" class="active"></a></li>

                				<?php

								}

								?> 

                                <li id="treeUpdate" style="font-weight:normal;" class="update-tree" ></li>

														

								</ul>

								<div class="clr"></div>

   			 </div>

			 <div class="clr"></div>

			 

			  <?php

			if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

			{

			?> 

			<span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            	

			<?php

			}

			?> 
			  <?php

			if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")

			{

			?> 

			<span class="successMsg"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span>

            	

			<?php

			}

			?> 

			<?php       

						if($this->input->post('users') != '')

						{

							$by = $this->input->post('users');

						}	

						

			?>  
			
			<?php 
			
				$sharedMembersList = implode(",",$sharedMembers); 
					
			?>

			<div style="padding-top:4%;">
			
			<form name="frmCal" action="<?php echo base_url()?>notes/share/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post">

                  

					

					<div>

						<div style="float:left ; width:150px;"> 

                        	<?php echo $this->lang->line('txt_Members');?>: 

                       </div>

						<div style="float:left">

							<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/>  

                        </div>                     

                   </div>

				   <div class="clr"></div>

				   

				   

					<div>

						<div style="float:left ; width:150px;">  &nbsp;   </div>

					   <div style="float:left">

						

							<div id="showMem" style="height:120px; width:300px; overflow:scroll;">
 
        					<input type="checkbox" name="users[]" id="checkAll" onclick="checkAllFunction();" value="0" <?php if ($treeDetail['userId']!=$_SESSION['userId']) { echo 'disabled="disabled"';}?>/> <?php echo $this->lang->line('txt_All');?><br />



            				<?php	

											

							foreach($workPlaceMembers as $arrData)

							{

								if (in_array($arrData['userId'],$sharedMembers))

								{						

							?>

                    				<input type="checkbox" name="users[]"  value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($treeDetail['userId']!=$_SESSION['userId']) || ($treeDetail['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /> 

									<?php echo $arrData['tagName'];?><br />

							<?php
							
									//Get checked userlabel
									if ($treeDetail['userId']==$_SESSION['userId'])
									{
										if($treeDetail['userId']!=$arrData['userId'])
										{
											$content .= '<div class="sol-selected-display-item sol_check'.$arrData['userId'].'"><span class="sol-quick-delete" onclick="removeSelectionDisplayItem('.$arrData['userId'].',1); ">x</span><span class="sol-selected-display-item-text">'.$arrData['tagName'].'</span></div>';
										}
									}
									//Code end

								}

							}

							foreach($workPlaceMembers as $arrData)

							{

								if (!in_array($arrData['userId'],$sharedMembers))

								{						

							?>

                    				<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$sharedMembers)) { echo 'checked="checked"';}?> <?php if (($treeDetail['userId']!=$_SESSION['userId']) || ($treeDetail['userId']==$arrData['userId'])) { echo 'disabled="disabled"';}else{echo ' class="clsCheck remove'.$arrData['userId'].'"';}?> data-myval="<?php echo $arrData['tagName'];?>" /> 

									<?php echo $arrData['tagName'];?><br />

							<?php

								}

							}

							?>

    						</div> 

						</div>	

						</div>

						<div  class="clr"></div>

						
						</div>
						

						<div style="margin-top:5px;" >

							<?php /*?><div style="float:left ; width:150px;"> &nbsp;

							</div><?php */?>

							<div  style="float:left">

                        

                        	<input type="hidden" name="treeId" value="<?php echo $treeId; ?>" /> 

                            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId; ?>" /> 

                            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType; ?>" />  

                            
							<input type="hidden" name="list" id="list" value="<?php echo $sharedMembersList; ?>"/>
                            

                            <?php

							if ($treeDetail['userId'] == $_SESSION['userId'])

							{

							?>                

            				<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_Ok');?>" class="button01">

                            <input type="reset" name="Clear" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="clearUserLabels();">

                        	<?php

							}

							?>

							</div>

                                    

                  </div>

                    </form>

			<div class="clr"></div>
		<div style="margin-top:5%;">
			<div class="sol-current-selection" style="max-height:250px; overflow-y:scroll;"></div>
		</div>


</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>
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
<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>