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
			
								<!--follow and sync icon code start -->
							<ul class="tab_menu_new_for_mobile tab_for_potrait">
								
								<?php 
							/*Code for follow button*/
								$treeDetails['seedId']=$treeId;
								$treeDetails['treeName']='doc';	
								$this->load->view('follow_object_for_mobile',$treeDetails); 
							/*Code end*/
							?>	
							</ul>
							<!--follow and sync icon code end -->

								<ul class="tab_menu_new_for_mobile">

									<li class="notes-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Notes_View');?>" ></a></li>

                				<li class="time-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>" ></a></li>

								<li  class="tag-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>" ></a></li>

            					<li  class="link-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>"></a></li>

								 <li  class="talk-view_sel"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" class="active" title="<?php echo $this->lang->line('txt_Talk_View');?>"  ></a></li>

            					<?php

								if (($workSpaceId==0))

								{

								?>

                					<li class="share-view"><a href="<?php echo base_url()?>notes/Details/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>

                				<?php

								}

								?> 
<div class="tab_for_landscape">		
                                <li id="treeUpdate" style="font-weight:normal;" class="update-tree" ></li>
								
								<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
</div>
								<div class="clr"></div>						

								</ul>

   			 </div>



			<div class="clr"></div>

			

				<?php

				//$nodeBgColor = 'nodeBgColorSelect1';

				$nodeBgColor = 'seedBgColor';



				$temp_array=array();

				$main_array=array();

				

				

						

				 

		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

		{

		?> 

			<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">

            	<span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            </div><div class="clr"></div>

		<?php

		}

	

		$focusId = 3;

	

		

		$i = 1;

		

		if(count($talkDetails) > 0)

		{		//print_r($talkDetails);				 

			foreach($talkDetails as $keyVal=>$arrVal)

			{	

			 	if($this->identity_db_manager->isTalkActive($arrVal['id']))

				{

				  

					

				$content='';

				$content=$this->identity_db_manager->formatContent(stripslashes($arrVal['name']),250);

				$tr = ($arrVal['type']==1)?1:0;

				$temp_array=array("id"=>"".$arrVal["id"]."","content"=>"$content","editedDate"=>"".$arrVal["editedDate"]."","leaf_id"=>"".$arrVal["leaf_id"]."","isTree"=>$tr);

				array_push($main_array,$temp_array);

				}

			 } 

		}	

			

		//Sorting array by diffrence 

		foreach ($main_array as $key => $row)

		{

				$diff[$key]  = $row['editedDate'];

        }

		array_multisort($diff,SORT_DESC,$main_array);

			

				//print_r($main_array);	

?>

						 

<?php		foreach($main_array as $keyVal=>$arrVal)

		{	 

		 
			$talk=$this->discussion_db_manager->getLastTalkByTreeId($arrVal['id']);
				
			$talk_commentor = $this->notes_db_manager->getUserDetailsByUserId($talk[0]->userId);
?>	

					

			<?php //echo $this->config->item('page_width')-50;?>

	<div style="width:250px; background-color:#FFFFFF;">		 <!-- Leaf Container Starts here -->

		

		

			<div style="width:100%; float:left; margin-bottom:2px; padding:0px !important;" onClick="showNotesNodeOptions(<?php echo $position;?>);" class="<?php echo $nodeBgColor;?> handCursor">

				<div style="width:100%; float:left; " class="<?php echo $nodeBgColor;?>" >	

				

					<?php

					

				  if($arrVal['isTree']==1)

				  {

					

					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$arrVal['leaf_id'].'/1\' ,\'\',\'width=850,height=600,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>';

					}

					else

					{

					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>';

					

					}

					



					?>

			

           

    		

				</div>

           <?php /*?> <div style="width:70px; float:left" class="<?php echo $nodeBgColor;?>">

            	<p><?php //if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p>

            </div><?php */?>
<?php //echo $this->config->item('page_width')-120;?>
    		<div style="width:100%; float:left;  padding: 9px 15px 5px 15px;" class="<?php echo $nodeBgColor;?>">

				<div id='leaf_contents<?php echo $position; ?>' >

				

				<?php

				 if($arrVal['isTree']==1)

				  {

				  

				 ?> 

				<?php echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['id'].'/1 style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>'; 
				?>
				 <div class="clr"></div>
				  <div class="userLabelNoFloat flLt" style="margin-top:5px;"><?php echo  $talk_commentor['userTagName']."&nbsp;"; ?><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> </div>	
				<div class="clr"></div>
				  <?php
				

				  }else

				  {

				  

				  echo '<a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['leaf_id'].' style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>'; 
				  ?>
				  <div class="clr"></div>
				  <div class="userLabelNoFloat flLt" style="margin-top:5px;"><?php echo  $talk_commentor['userTagName']."&nbsp;"; ?> <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> </div>	
				<div class="clr"></div>
				  <?php
					}

				

				?>

				

				

				

				

				

			

            </div>

				

			</div>

            </div>

				

               

				<span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span>	                

                

				<span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;">

				<span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">

				<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">

				

				<?php	

				$tagAvlStatus = 0;				

				

							

				

				

				

				

				

							

				?>	

				</div>

				</span>

					

                   

                </span>								

				<?php	

				#*********************************************** Tags ********************************************************																		

				?>

				

				

				

			

        	

        </div> <!-- Leaf Container ends here -->

		<?php $i++; }  ?>

														

														

	

		

			

	</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>

<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>