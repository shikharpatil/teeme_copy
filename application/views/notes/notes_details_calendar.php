<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Notes > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head.php');?>

<?php $this->load->view('common/datepicker_js.php');?>

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

			

$(function() {

	

	$('#fromDate').datepicker({dateFormat: "dd-mm-yy"});

	$('#toDate').datepicker({dateFormat: "dd-mm-yy"});





});

	</script>

	

</head>

<body>





<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs', $details); ?>

</div>

</div>

<div id="container">



		<div id="content">

		

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

			 
	$_SESSION['notesSearchDate'] 	= 0;
	$_SESSION['notesFromDate'] 	= '';
	$_SESSION['notesToDate'] 		= '';	
	
						if($this->input->post('searchDate') != '')

						{

							$_SESSION['notesSearchDate'] = $this->input->post('searchDate');

							if($this->input->post('searchDate') == 0)

							{	

								if($this->input->post('fromDate') != '')

								{

									$sd1 = explode("-",$this->input->post('fromDate')); 

									$searchDate1	= $sd1[2]."-".$sd1[1]."-".$sd1[0];
									

									$_SESSION['notesFromDate'] 	= $searchDate1;


								}
								
								if($this->input->post('toDate') != '')

								{


									$sd2 = explode("-",$this->input->post('toDate'));

									$searchDate2	= $sd2[2]."-".$sd2[1]."-".$sd2[0];

									$_SESSION['notesToDate'] 	= $searchDate2;		

								}

							}

						}

						else if(isset($_SESSION['notesSearchDate']) && $_SESSION['notesSearchDate'] != '')

						{

							$_SESSION['notesSearchDate'] = $_SESSION['notesSearchDate'];

							if($_SESSION['notesSearchDate'] == 0)

							{	

								if($_SESSION['notesFromDate'] != '')

								{

									$searchDate1	= $_SESSION['notesFromDate'];
				

								}
								
								if($_SESSION['notesToDate'] != '')

								{


									$searchDate2	= $_SESSION['notesToDate'];					

								}

							}

						}

						else

						{

							$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

							$_SESSION['notesSearchDate'] 	= 1;

							$_SESSION['notesFromDate'] 	= '';

							$_SESSION['notesToDate'] 		= '';

						}

						if($_SESSION['notesSearchDate'] == 0)

						{	

								if($_SESSION['notesFromDate'] != '')

								{

									$searchDate1	= $_SESSION['notesFromDate'];
				

								}
								
								if($_SESSION['notesToDate'] != '')

								{


									$searchDate2	= $_SESSION['notesToDate'];					

								}

						}

						

						if($_SESSION['notesSearchDate'] == 1)

						{

							/*Changed by Surbhi IV */

							/*$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));*/

							$searchDate1	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d')-1,date('Y')));

							$searchDate2	= date('Y-m-d h:i:s',mktime(date("H"),date("i"),date("s"),date('m'),date('d'),date('Y')));

							/*End of Changed by Surbhi IV */

						}	

						if($_SESSION['notesSearchDate'] == 2)

						{		

							$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));

						}	

						if($_SESSION['notesSearchDate'] == 3)

						{		

							$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1)-7,date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N'))-7,date('Y')));

						}

						if($_SESSION['notesSearchDate'] == 4)

						{

							$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y')));

						}

						if($_SESSION['notesSearchDate'] == 5)

						{

							$lastDayOfMonth = date('t',mktime(0,0,0,date('m')-1,1,date('Y')));

							$searchDate1	= date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')));

							$searchDate2	= date('Y-m-d',mktime(0,0,0,date('m')-1,$lastDayOfMonth,date('Y')));	 

						}

						$arrNodeIds = array();
						
							if ($searchDate1!='' || $searchDate2!='')
							{
								$arrNodeIds = $this->identity_db_manager->getNodesByDateTimeView($treeId, $searchDate1, $searchDate2);	
							}
						$arrDetails['arrNodeIds'] = $arrNodeIds;

			?>

			<form name="frmCal" action="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" method="post" onSubmit="return validateCal()">

					<!-- Div contains tabs -->	

			<div class="menu_new">

								<ul class="tab_menu_new">

									<li class="notes-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  title="<?php echo $this->lang->line('txt_Notes_View');?>"></a></li>

														<li class="time-view_sel"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" class="active" title="<?php echo $this->lang->line('txt_Time_View');?>" ></a></li>

														<li class="tag-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"></a></li>

														<li  class="link-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>"></a></li>

														 <li class="talk-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

														<?php

														if (($workSpaceId==0))

														{

														?>

															<li class="share-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>"></a></li>

														<?php

														}

														?> 
														<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='notes';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>

										<div class="clr"></div>						

								</ul>

								<div class="clr"></div>		

   			 </div>

			<div class="clr"></div>		

			  <?php

			if($this->input->post('Go') != '' )

			{

			?>

			<select name="searchDate" onChange="getTimingsCal(this)">

				<option value="0" <?php if($_SESSION['notesSearchDate'] == 0 || $this->input->post('fromDate') != '' || $this->input->post('toDate') != '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Select'); ?></option>

				<option value="1" <?php if($_SESSION['notesSearchDate'] == 1 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_Today'); ?></option>

				<option value="2" <?php if($_SESSION['notesSearchDate'] == 2 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Week'); ?></option>

				<option value="3" <?php if($_SESSION['notesSearchDate'] == 3 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('last_week'); ?></option>

				<option value="4" <?php if($_SESSION['notesSearchDate'] == 4 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('txt_This_Month'); ?></option>

				<option value="5" <?php if($_SESSION['notesSearchDate'] == 5 && $this->input->post('fromDate') == '' && $this->input->post('toDate') == '') { echo 'selected'; } ?>><?php echo $this->lang->line('last_month'); ?></option>

			</select>

            	<?php 

				if($this->input->post('searchDate') == 0 )

				{

				?>

              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" id="fromDate" size="10" value="<?php if($_SESSION['notesFromDate'] != '') { echo $this->input->post('fromDate'); } ?>" onchange="clearSearchDropdown()" readonly="">

			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" name="toDate" id="toDate" size="10" value="<?php if($_SESSION['notesToDate'] != '') { echo $this->input->post('toDate'); } ?>" onchange="clearSearchDropdown()" readonly="">

			&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

                <?php

				}

				else

				{

				?>

              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" id="fromDate" size="10" onchange="clearSearchDropdown()" readonly="">

			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" id="toDate" name="toDate" size="10" onchange="clearSearchDropdown()" readonly="">

			&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

                <?php

				}

				?>

             <?php

			 }

			 else

			 {

			 ?>

			<select name="searchDate" onChange="getTimingsCal(this)">

				<option value="0"><?php echo $this->lang->line('txt_Select'); ?></option>

				<option value="1" selected="selected"><?php echo $this->lang->line('txt_Today'); ?></option>

				<option value="2"><?php echo $this->lang->line('txt_This_Week'); ?></option>

				<option value="3"><?php echo $this->lang->line('last_week'); ?></option>

				<option value="4"><?php echo $this->lang->line('txt_This_Month'); ?></option>

				<option value="5"><?php echo $this->lang->line('last_month'); ?></option>

			</select>

              &nbsp;&nbsp;<?php echo $this->lang->line('txt_Or');?>&nbsp;&nbsp;<?php echo $this->lang->line('txt_From_Date');?>:&nbsp; <input type="text" name="fromDate" id="fromDate" size="10" onchange="clearSearchDropdown()" readonly="">&nbsp;

			<?php echo $this->lang->line('txt_To_Date');?>: &nbsp;<input type="text" id="toDate" name="toDate" size="10" onchange="clearSearchDropdown()" readonly="">

			&nbsp;&nbsp;<input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">

             <?php

			 }

			 ?>

			

</form>



			<!-- Start Seed div -->										

			<div class="seedBgColor views_div">

                                        

                <?php 

                    echo '<a class="" style="text-decoration:none; color:#000;" href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'>'.$this->identity_db_manager->formatContent($treeDetail['name'],1000,1).'</a>';

                ?>

                                        

			</div>

			<!-- End seed div --->

			

			

	<?php

	$focusId = 3;

	$rowColor1='row2';

	$rowColor2='row1';	

	//print_r ($arrNodeIds);

	if(count($Contactdetail) > 0)

	{		//print_r($arrDiscussions);					 

		foreach($Contactdetail as $keyVal=>$arrVal)

		{	 

			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$nodeBgColor = '';

			if(in_array($arrVal['nodeId'],$arrNodeIds))

			{

				//$nodeBgColor = 'nodeBgColorSelect';

				$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

			}	

			if (!empty($nodeBgColor))

			{	

				$lastnode=$arrVal['nodeId'];		  

?>		

				<div class="<?php echo $nodeBgColor?> views_div">

											

					<a href="<?php echo base_url();?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#noteLeafContent<?php echo $arrVal["nodeId"];?>" style="float:left;text-decoration:none;color:#000;max-width:95%;"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes($arrVal['contents']); ?></a>										
					
					<?php //echo '<a style="float:left;text-decoration:none;color:#000;max-width:95%;" href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].'>'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>'; $i++;?>

        <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>

       <div class="clr"></div>

        

                    </div>

						

						

<?php

		}

		$focusId = $focusId+2;	

		$position++;

		}

	}

	 

?>

<input name="totalNodes" id="totalNodes" type="hidden"  value="<?php echo ($position-1);?>">														

														

	

		

			

	</div>

</div>

<?php $this->load->view('common/foot.php');?>

<?php $this->load->view('common/footer');?>

<?php $this->load->view('common/datepicker_js.php');?>

</body>

</html>

<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>