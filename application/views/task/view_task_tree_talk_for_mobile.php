<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Task > <?php echo strip_tags(stripslashes($treeDetail['name']),'<b><em><span><img>');?></title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

<script language="javascript">

	var baseUrl 		= '<?php echo base_url();?>';	

	var workSpaceId		= '<?php echo $workSpaceId;?>';

	var workSpaceType	= '<?php echo $workSpaceType;?>';

	

</script>

   



<script language="javascript">



function hidedetail(id){

	var image='img'+id;

	var added='add'+id;

	var details='detail'+id;

	document.getElementById(image).innerHTML='<img src="<?php echo base_url();?>images/plus.gif" onClick="showdetail('+id+');">';

	document.getElementById(added).style.display='none';

	document.getElementById(details).style.display='none';

	

}

function getnext(pid,id){

	var url='<?php echo base_url();?>view_task/task_content_p/'+pid+'/'+id;

	 

	ajax_request(url,id);

}

function getnew(lid,id){

	var url='<?php echo base_url();?>view_task/task_content_n/'+lid+'/'+id;

	 

	ajax_request(url,id);

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

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			if ($workSpaceId != 0)

			{	

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

			else

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



		}

}

function showFilteredMembersAddTask(nodeId)

{

	//alert (document.getElementById('showMembersEditTask').value);

	var toMatch = document.getElementById('showMembersAddTask'+nodeId).value;

	//alert ('toMatch= ' +toMatch);

	var val = '';

		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

					val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}

			if ($workSpaceId != 0)

			{	

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMemAddTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

			else

			{

			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)))

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMemAddTask'+nodeId).innerHTML = val;

			}

        

			<?php

				}

        	}

			}

        	?>



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





			<!-- Main menu -->

			<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

			

			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);

			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);			

			

			

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

			?>

			<!-- Main menu -->	

			

			

	

    

	

		<?php $day = date('d');$month 	= date('m');$year = date('Y'); ?> 

        <span id="tagSpan"></span>

		

		

		<div class="menu_new" >
		
		
			<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait task_tab_for_potrait">
			
				<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</ul>
        <!--follow and sync icon code end -->

            <ul class="tab_menu_new_for_mobile task_tab_menu_for_mob">

				<li class="task-view"><a class=" 1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>

				

				<li class="time-view"><a  href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				

				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

						

    			<li class="link-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>	

				

				 <li class="talk-view_sel"><a class="active" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>

				

				<li class="task-calendar"><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar_View');?>" ></a></li>

				

                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" ></a></li>

				

				

				

					

            	<?php

				if (($workSpaceId==0))

				{

				?>

                 <li class="share-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6"></a></li>

                <?php

				}

				?>
				<div class="tab_for_landscape task_tab_for_landscape">

				 <li id="treeUpdate"></li>       

				<?php /*?><li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li><?php */?>
				
				<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='doc';	
			$this->load->view('follow_object_for_mobile',$treeDetails); 
		/*Code end*/
		?>
		</div>

            </ul>

			<div class="clr"></div>

        </div>

        

         

         

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

		foreach($main_array as $keyVal=>$arrVal)

		{	 

		 

?>	

       <div style="width:100%;  padding-left:10px; background-color:#FFFFFF;"> <!-- Leaf Container Starts here -->

		

			<div style="width:100%; float:left; margin-bottom:2px;" onClick="showNotesNodeOptions(<?php echo $position;?>);" class="<?php echo $nodeBgColor;?> handCursor">

				<div style="width:100%; float:left;" class="<?php echo $nodeBgColor;?>">

					<?php

					

				  if($arrVal['isTree']==1)

				  {

					

					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$arrVal['leaf_id'].'/1\' ,\'\',\'width=850,height=600,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';

					}

					else

					{

					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=600,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';

					

					}

					



					?>

			</div>

           <?php /*?> <div style="width:70px; float:left" class="<?php echo $nodeBgColor;?>">

            	<p><?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?></p>

            </div><?php */?>
			<!-- Manoj: code for showing user tag name and date time -->
			<div style="width:87%; font-size:0.7em; padding-left: 6%;">
			<div>
			<?php 
				$talk=$this->discussion_db_manager->getLastTalkByTreeId($arrVal['id']);
				
				$talk_commentor = $this->notes_db_manager->getUserDetailsByUserId($talk[0]->userId);
				echo $talk_commentor['userTagName'];
				if(strlen($talk_commentor['userTagName'])>24)
				{
				?>
				</div>
				<div>
				<?php
				}
				
				echo ' '.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
			?>
			</div>
			</div>
			<!--Manoj: code end-->

    		<div style="width:90%; float:left;" class="<?php echo $nodeBgColor;?>">

				<div id='leaf_contents<?php echo $position; ?>' >

				

				<?php

				 if($arrVal['isTree']==1)

				  {

				  

				 ?> 

				<?php echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['leaf_id'].'#taskLeafContent'.$arrVal["leaf_id"].' style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>'; 

				

				  }else

				  {

				  

				 echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['leaf_id'].'#taskLeafContent'.$arrVal["leaf_id"].' style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>'; 

				

				  

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

				

				

				

			

        	

        </div>    

			

					

		

		<?php $i++; } ?>	



				

                

			

   

   

</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>	

<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>

<script>

		// Tree updates every 5 second

		<!--Updated by Surbhi IV-->

		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);

		<!--End of Updated by Surbhi IV-->

</script>