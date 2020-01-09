<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/subModal.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

<?php $this->load->view('editor/editor_js.php');
/*echo '<pre>';
print_r($reserveduserlist);
exit;*/
?>

	<script>

		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 

		var workSpace_name='<?php echo $workSpaceId;?>';

		var workSpace_user='<?php echo $_SESSION['userId'];?>';

		var node_lock=0;

	</script>

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

    

    <script language="JavaScript" src="<?php echo base_url();?>js/document.js"></script>

    <script language="JavaScript" src="<?php echo base_url();?>js/document_js.js"></script>

   

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document.js"></script>

    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/pop_menu.js"></script>

	<script type="text/javascript" language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>

	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/popcalendar.js"></script>

    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/validation.js"></script>

    <script type="text/javascript" language="JavaScript1.2">mmLoadMenus();</script>

    

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>

	

	<!--<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>-->

	

	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 

	

	<!-- for sub modal -->

	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script> 

	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script> 

    <script>

    $(function() {

	$("input[type='checkbox']").click(function(){

		if($(this).hasClass('allcheck')){

			$(this).removeClass('allcheck');

			$(this).addClass('allUncheck');

			$(".users").prop( "checked" ,true);
			
			$(".users").each(function(){

				value = $("#reserveduserlist").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#reserveduserlist").val(value+","+$(this).val());

				}
			});

		}

		else if($(this).hasClass('allUncheck')){

			$(this).removeClass('allUncheck');

			$(this).addClass('allcheck');

			$(".users").prop('checked',false);
			
			$(".users").each(function(){

				value = $("#reserveduserlist").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#reserveduserlist").val(arr);

			});
			
			//$("#reserveduserlist").val('<?php echo $_SESSION['userId']; ?>');
			
			//$(".originatorUser").prop('checked',true);

		}

	});

	

});

//Start Manoj : Show assignee on click
		function show_assignee(className){
			
			/*if($('.docContributors').is(':visible'))
			{
				$('.docContributors').hide();
				$("#seeAll").html('<?php echo $this->lang->line('see_all_txt'); ?>');
			}
			else
			{
				$('.docContributors').show();	
				$("#seeAll").html('<?php echo $this->lang->line('see_less_txt'); ?>');
			}*/
			var divsToHide = document.getElementsByClassName(className);
	
			for(var i = 0; i < divsToHide.length; i++)
			{
				if (divsToHide[i].style.display=='block')
				{
					divsToHide[i].style.display='none';
						if (className=='tree_more_contributors')
						{
							document.getElementById('seeAll').innerHTML = '<?php echo $this->lang->line('see_all_txt'); ?>';
						}
				}
				else
				{
					divsToHide[i].style.display='block';
						if (className=='tree_more_contributors')
						{
							document.getElementById('seeAll').innerHTML = '<?php echo $this->lang->line('see_less_txt'); ?>';
						}
				}
			}
		} 

//End Manoj : Show assignee on click



    

    </script>

</head>

<body>



<div >

<div style="margin-left:10px;" >

<div class="clsContributors " style="width:95%;" >

                <div id="contributorsMsg" style="margin-bottom:10px;" ></div>

						<?php /*?><div style="float:left;"><?php echo $this->lang->line('txt_Contributors');?>					

						 : </div> 	

						  <div style="float:left; " id='divContributors'>&nbsp;<?php echo implode(', ',$reservedUserTagName);?></div><?php */?>
						  
						  <!--Start Manoj: Create Assignee list hyperlinked -->
			
							<div style="margin-top:10px;">
							
							<div style="width:auto; color:#000;"  ><?php echo $this->lang->line('txt_leaf_reserved_users').': ';?>
							<?php
							 if(count($reservedUserTagName)>3)
							 {
								?>
								<a id="seeAll"  style="cursor:pointer; padding: 0 1%; font-size: 1em;" onclick="javascript:show_assignee('tree_more_contributors');"><?php echo $this->lang->line('see_all_txt'); ?></a>
							  <?php
							  // echo implode(', ',$reservedUserTagName);
							 }
							
							?> 
							</div>
							<div class="docContributors" id="docContributors"  style="margin-bottom:15px; font-size: 1em; width: 100%;"  >
							<?php
							
							   //array_shift($reservedUserTagName);
							   //echo implode(', ',$reservedUserTagName);
							?>
							
							<?php
								$i=0;
								$contributorsCount = count($reservedUserTagName);
								
								
								//foreach($arrPostsTimeline as $keyVal=>$arrVal)
								for($i=0; $i<$contributorsCount; $i++)
								{
										if ($i<3)
										{
											$display='block';
											$class = 'tree_contributors';
										} 
										else 
										{
											$display='none';
											$class = 'tree_more_contributors';
										}	
									?>
										
										<span class="<?php echo $class;?>" style="float:left; display:<?php echo $display;?>">
											<?php echo $reservedUserTagName[$i].', &nbsp;'; ?>
										</span>
								<?php
								}
								?>
							
							</div>
							
							</div>
						
						<!--End Manoj: Create Assignee list hyperlinked -->

						  <div style="float:right">
						</div>	

                </div>

				

				<?php if($_SESSION['userId']==$treeOriginatorId && $treeLatestVersion==1):
					//if($_SESSION['userId']==$leafOwnerData['userId'] && $treeLatestVersion==1):
					//if(in_array($_SESSION['userId'],$contributorsUserId) && $treeLatestVersion==1):
				 ?>

				

				<div id="edit_notes" class="<?php echo $seedBgColor;?>" style="width:90%;float:left;" >

                	<?php echo $this->lang->line('txt_Search'); ?> :

                       <?php 
			
							$reserveduserlist = implode(",",$reservedUserId); 
						
						?>
					   
					    <form name="frmedit_notes" id="frmedit_notes" method="post" action="<?php echo base_url();?>document_home/Edit_Docs/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>">


						<input value="<?php echo $reserveduserlist ?>" id="reserveduserlist" type="hidden" name="reserveduserlist" />
                      
						<!--Commented by Dashrath- comment old code and add new code below with disabled condition for disabled search field if current leaf status is draft-->
						<!-- <input type="text" id="showMembers" name="showMembers" onKeyUp="showSearchReservedUsers('<?php echo $treeId; ?>')"/>  -->

						<!--Added by Dashrath- add if else condition for disable checkbox-->
                        <?php 
                        if($currentLeafStatus == 'draft')
                        {
                        ?>
                        	<input type="text" id="showMembers" name="showMembers" onKeyUp="showSearchReservedUsers('<?php echo $treeId; ?>')" disabled /> 
                        <?php
                        }
                        else
                        {
                        ?>
                        	<input type="text" id="showMembers" name="showMembers" onKeyUp="showSearchReservedUsers('<?php echo $treeId; ?>')"/> 
                        <?php
                        } 
                        ?>
                        <!--Dashrath- code end-->
						

						<input type="hidden" id="myId" name="myId" value="<?php echo $_SESSION['userId'] ;  ?>" /><br />

                        

                        <?php

						$members='';

						/*if ($workSpaceId != 0)

						{*/

						?>
						<!--Manoj: added if else condition for select all UI for doc contributors -->

						<!--Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft-->
                        <!-- <input type="checkbox" name="notesUsers" value="0"  id="checkAll" <?php if ($selectAll==1){ echo 'checked="checked"'; echo 'class="allUncheck"';} else { echo 'class="allcheck"';}?> /> -->

                        <!--Added by Dashrath- add if else condition for disable checkbox-->
                        <?php 
                        if($currentLeafStatus == 'draft')
                        {
                        ?>
                        	<input type="checkbox" name="notesUsers" value="0"  id="checkAll" <?php if ($selectAll==1){ echo 'checked="checked"'; echo 'class="allUncheck"';} else { echo 'class="allcheck"';}?> disabled />
                        <?php
                        }
                        else
                        {
                        ?>
                        	<input type="checkbox" name="notesUsers" value="0"  id="checkAll" <?php if ($selectAll==1){ echo 'checked="checked"'; echo 'class="allUncheck"';} else { echo 'class="allcheck"';}?> />
                        <?php
                        } 
                        ?>
                        <!--Dashrath- code end-->

                        <?php echo $this->lang->line('txt_All');?>
                        <br>

						<?php

						//}

						?>

                        <?php	

						if($workSpaceId==0)
						{						

							foreach($contributorDetails as $arrData)
	
							{
								if(in_array($arrData['userId'],$reservedUserId))
								{
									if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
		
									{						
										/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/
										// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

										/*Added by Dashrath- add if else condition for disable checkbox*/
										if($currentLeafStatus == 'draft')
										{
											$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
										}
										else
										{
											$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
										}
										/*Dashrath- code end*/
		
							   
		
									}
								}
							}
							
							foreach($contributorDetails as $arrData)
	
							{
								if(!in_array($arrData['userId'],$reservedUserId))
								{
									if($_SESSION['userId'] != $arrData['userId'] && in_array($arrData['userId'],$sharedMembers))
		
									{						
										/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/
										// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

										/*Added by Dashrath- add if else condition for disable checkbox*/
										if($currentLeafStatus == 'draft')
										{
											$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
										}
										else
										{
											$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
										}
										/*Dashrath- code end*/
		
							   
		
									}
								}
							}

						}

						else
						{
							foreach($contributorDetails as $arrData)
							{
								if(in_array($arrData['userId'],$reservedUserId))
								{
									if ($arrUser['userGroup']==0)
									{
										if ($arrData['isPlaceManager']==1)
										{
											/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/
											// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

											/*Added by Dashrath- add if else condition for disable checkbox*/
											if($currentLeafStatus == 'draft')
											{
												$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											else
											{
												$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											/*Dashrath- code end*/
										}
									}
									else
									{
										if($_SESSION['userId'] != $arrData['userId'])
										{	
											/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/					
											// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

											/*Added by Dashrath- add if else condition for disable checkbox*/
											if($currentLeafStatus == 'draft')
											{
												$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											else
											{
												$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											/*Dashrath- code end*/
										}
									}
								}
							}
							
							foreach($contributorDetails as $arrData)
							{
								if(!in_array($arrData['userId'],$reservedUserId))
								{
									if ($arrUser['userGroup']==0)
									{
										if ($arrData['isPlaceManager']==1)
										{
											/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/
											// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

											/*Added by Dashrath- add if else condition for disable checkbox*/
											if($currentLeafStatus == 'draft')
											{
												$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											else
											{
												$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											/*Dashrath- code end*/
										}
									}
									else
									{
										if($_SESSION['userId'] != $arrData['userId'])
										{	
											/*Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft*/					
											// $members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';

											/*Added by Dashrath- add if else condition for disable checkbox*/
											if($currentLeafStatus == 'draft')
											{
												$members .='<input disabled type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											else
											{
												$members .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$reservedUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
											}
											/*Dashrath- code end*/
										}
									}
								}
							}

						}

						?>

                        <div id="showMem" style="height:150px; width:90%;overflow:auto;" class="usersList">

						

 
						<?php 
						if(in_array($_SESSION['userId'],$contributorsUserId))
						{
						?>
						<!--Commented by Dashrath- comment old code and add new code below with disabled condition for disabled checkbox if current leaf status is draft-->
                      <!--  <input   type="checkbox" id="notesUsers" class="users originatorUser" name="notesUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$reservedUserId)) {echo 'checked="checked"';}?>  <?php /*if($leafOwnerData['userId']==$_SESSION['userId']) {?> disabled="disabled" <?php }*/ ?> /> --> 

                      <!--Added by Dashrath- add if condition for disable checkbox-->
                       <input   type="checkbox" id="notesUsers" class="users originatorUser" name="notesUsers" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$reservedUserId)) {echo 'checked="checked"';}?>  <?php if($currentLeafStatus=='draft') {?> disabled="disabled" <?php } ?> />
                       <!--Dashrath- code end-->

                       <?php echo $this->lang->line('txt_Me');?><br>
					   <?php } ?>

                       <?php echo $members;?>

                        </div> 

                        <br>
						
						<?php  $leafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafOwnerData['id']); ?>

                        <input name="notesId" id="notesId" type="hidden" value="<?php echo $treeId; ?>"> 
						
						<input name="currentNodeId" id="currentNodeId" type="hidden" value="<?php echo $currentNodeId; ?>"> 
						
						<input name="currentLeafStatus" id="currentLeafStatus" type="hidden" value="<?php echo $currentLeafStatus; ?>">
						
						<input name="leafId" id="leafId" type="hidden" value="<?php echo $leafOwnerData['id']; ?>"> 
						
						<input name="leafOwnerId" id="leafOwnerId" type="hidden" value="<?php echo $leafOwnerData['userId']; ?>"> 

						<?php //if($_SESSION['userId']==$leafOwnerData['userId']):
							//if(in_array($_SESSION['userId'],$contributorsUserId)):
							if($_SESSION['userId']==$treeOriginatorId):
						 ?>

						<!--Commented by Dashrath- comment old code and add new code below with disabled condition for disabled apply button if current leaf status is draft-->
                        <!-- <input name="editNotes" type="button"  onclick="editDocsReservedUsers()" value="<?php echo $this->lang->line('txt_Apply');?>" class="button01"> -->
                        <input name="editNotes" type="button"  onclick="editDocsReservedUsers()" value="<?php echo $this->lang->line('txt_Apply');?>" class="button01" <?php if($currentLeafStatus == 'draft'){ echo disabled;}?>> 
						
						<!--<input name="cancelNotes" type="reset" value="<?php // echo $this->lang->line('txt_Cancel');?>" onClick="if(document.getElementById('edit_notes').style.display=='none') { document.getElementById('edit_notes').style.display='block';} else { document.getElementById('edit_notes').style.display='none';}" class="button01">  -->

						<input name="Clear" type="reset" value="<?php echo $this->lang->line('txt_Cancel');?>"  class="button01" onclick="resetReservationForm()"> 

						<div class="reserveLoader" id="reserveLoader"></div>
						
						<?php endif; ?>

						

                        </form>

                </div>

				

				<?php endif; ?>

	</div>

	</div>			

</body>	

</html>	
<script>
$('.users').live("click",function(){
		//alert('dfsd');
		val = $("#reserveduserlist").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#reserveduserlist").val()==''){

				$("#reserveduserlist").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){
				
					$("#reserveduserlist").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());
			
			if(index!=-1)
			{
				val1.splice(index, 1);
	
				var arr = val1.join(",");
				
				$("#reserveduserlist").val(arr);
			}

		}

	});	
	
//On cancel reset user list and form
function resetReservationForm()
{
	$("#reserveduserlist").val("<?php echo $reserveduserlist ?>");
	
	if($("#checkAll").prop("checked")==true)
	{
		$("#checkAll").removeClass('allUncheck');

		$("#checkAll").addClass('allcheck');
	}
}	

</script>		