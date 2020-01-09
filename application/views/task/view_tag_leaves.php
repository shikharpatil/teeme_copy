<?php 
/*$tagId = $this->uri->segment(8);

$nodeId = $this->uri->segment(9);

$tagType = $this->uri->segment(11);*/

$tagId = $this->uri->segment(8);//tag type id

$treeId = $this->uri->segment(3);

$tagType = $this->uri->segment(9);

$usr = $this->uri->segment(10);

//unset($_SESSION['tagLeaves']);



if(!$tagType && !$usr)unset($_SESSION['tagLeaves']);



//if(array_key_exists($nodeId,$_SESSION['tagLeaves'])){

if(isset($_GET['rem']) && $_GET['rem']==1){

	if($tagType==2){//simple tag

		unset($_SESSION['tagLeaves'][1][$tagId]);

		if(empty($_SESSION['tagLeaves'][1])){

			unset($_SESSION['tagLeaves'][1]);

		}

	}

	elseif($tagType==3){//action tag

		unset($_SESSION['tagLeaves'][2][$tagId]);

		if(empty($_SESSION['tagLeaves'][2])){

			unset($_SESSION['tagLeaves'][2]);

		}

	}

	else{

		unset($_SESSION['tagLeaves'][3][$tagId]);

		if(empty($_SESSION['tagLeaves'][3])){

			unset($_SESSION['tagLeaves'][3]);

		}

	}

}

//}

else if((!isset($_GET['rem']) || $_GET['rem']!=1) && $tagId){

	if($tagType==2){//simple tag

		$_SESSION['tagLeaves'][1][$tagId]=$tagId;

	}

	elseif($tagType==3){//action tag

		$_SESSION['tagLeaves'][2][$tagId]=$tagId;

	}

	else{

		$_SESSION['tagLeaves'][3][$tagId] = $tagId;

	}

	//unset($_SESSION['usrLeaves']);

}

if(empty($_SESSION['usrLeaves']) || $usr==''){

	unset($_SESSION['usrLeaves']);

}

if($usr!=0 && !$_GET['remUsr']){

	//deselect other tags on selecting user tag

	/*if(empty($_SESSION['usrLeaves'])){

		unset($_SESSION['tagLeaves']);

	}*/

	//comment this line for multiple user select

	unset($_SESSION['usrLeaves']);

	$_SESSION['usrLeaves'][$usr]=$usr;

}



if(isset($_GET['remUsr']) && $_GET['remUsr']!=0){

	unset($_SESSION['usrLeaves'][$usr]);

}

//print_r($_SESSION['tagLeaves']);die;



if(!empty($_SESSION['tagLeaves']))

{

	$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1);

	//echo "<pre>";print_r($attachedTags);die;

	//error_reporting(E_ALL);

	if(!empty($attachedTags) && (in_array($arrDiscussionDetails['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

		//print_r($_SESSION['tagLeaves'][1]);die;

		$arrTag=array();

		$flag=1;//for checking nonexistent tag in node

		foreach($attachedTags['simple'] as $val){

			$arrTag[]=$val['tag'];

		}

		$a = array_diff($_SESSION['tagLeaves'][1],$arrTag);

		if(empty($a)){

			$flag=0;	

		}

		

		if($flag==0){

			$arrTag=array();

			foreach($attachedTags['response'] as $val){

				$arrTag[]=$val['tagId'];

			}

			$a = array_diff($_SESSION['tagLeaves'][2],$arrTag);

			if(empty($a)){

				$flag=0;	

			}

			else{

				$flag=1;

			}

		}

		

		if($flag==0){

			$arrTag=array();

			foreach($attachedTags['contact'] as $val){

				$arrTag[]=$val['tag'];

			}

			$a = array_diff($_SESSION['tagLeaves'][3],$arrTag);

			if(empty($a)){

				$flag=0;	

			}

			else{

				$flag=1;

			}

		}

		

		

		if($flag==0){?>

			<div class="seedBgColor" style="margin:3px;"><?php
				/*$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],1000,1)*/
				echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDiscussionDetails['name'],0,1000)).'</a>';?>

			</div>

		<?php

		}

	}

?>        

	

	<?php

	$totalNodes = array();

	$nodeBgColor = '';

	if(count($discussionDetails) > 0)

	{	

		$i=1;	 

		foreach($discussionDetails as $keyVal=>$arrVal)

		{

			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			
			$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
			
			$contributorsTagName		= array();

			$contributorsUserId			= array();
			
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
			}	

			$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);

			$arrTag=array();

				//echo "<pre>";print_r($attachedTags);print_r($_SESSION['tagLeaves']);die;

				if(!empty($attachedTags) && (in_array($arrVal['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

					$arrTag=array();

					$flag=1;//for checking nonexistent tag in node

					foreach($attachedTags['simple'] as $val){

						$arrTag[]=$val['tag'];

					}

					$a = array_diff($_SESSION['tagLeaves'][1],$arrTag);

					if(empty($a)){

						$flag=0;	

					}

					

					if($flag==0){

						$arrTag=array();

						foreach($attachedTags['response'] as $val){

							$arrTag[]=$val['tagId'];

						}

						$a = array_diff($_SESSION['tagLeaves'][2],$arrTag);

						if(empty($a)){

							$flag=0;	

						}

						else{

							$flag=1;

						}

					}

					

					if($flag==0){

						$arrTag=array();

						foreach($attachedTags['contact'] as $val){

							$arrTag[]=$val['tag'];

						}

						$a = array_diff($_SESSION['tagLeaves'][3],$arrTag);

						if(empty($a)){

							$flag=0;	

						}

						else{

							$flag=1;

						}

					}

			

					if($flag==0){

					$nodeBgColor = ($i%2)?'row1':'row2';

					$i++;?>

					<div class="<?php echo $nodeBgColor;?> views_div">

						<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent( $arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>				 

						<?php //echo stripslashes($arrVal['contents']); 

                        //echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent( $arrVal['contents'],1000,1).'</a>';

        

                    ?>

                    

                     <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
					 
			<?php
            if(!$checksucc && count($contributorsTagName)>0)

            {

            ?>

                

                    <?php echo '<span class="style1" style="display:block; margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;  " >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>

               

            <?php

            }
			
            ?>

                    </div>

					<?php

					}

			}

            ?>

		

		<?php

		}

	}

	 

?>

<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

 

</div>

<?php

	}

else{


	$this->load->model("dal/task_db_manager");

	$details=$this->task_db_manager->getPerentInfo($treeId);


	if(count($discussionDetails) > 0)

	{	
	
		$i=1;	 

		foreach($discussionDetails as $keyVal=>$arrVal)

		{

			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$checksucc = $this->task_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
			
			$contributorsTagName		= array();

			$contributorsUserId			= array();
			
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
			}	
			
			$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
			$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);

			if(in_array($arrVal['userId'],$_SESSION['usrLeaves'])){

			$nodeBgColor = ($i%2)?'row1':'row2';

			$i++;?>

				<div class="<?php echo $nodeBgColor;?> views_div">

				<?php
				echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%">';
				?>

				<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent( $arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>             

				<?php 
				echo '</div>';
				
				//echo stripslashes($arrVal['contents']); 

				//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent( $arrVal['contents'] ,1000,1).'</a></div>';



			?>
			<div class="clr"></div>
            <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
			<?php
			if(!$checksucc)

			{

				

				if($arrVal['starttime'][0] != '0')

				{

				?>

					

					<span class="style1" style="margin-left:2%;">

						<img src="<?php echo base_url();?>images/greennew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_Start_Time');?>"   /> <?php echo $this->lang->line('txt_Start').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['starttime'],$this->config->item('date_format'));?>

					</span>

					

				<?php

				}

				if($arrVal['endtime'][0] != '0')

				{

				?>

					

					<span class="style1" style="margin-left:2%;"><img src="<?php echo base_url();?>images/rednew.png" style="margin-right:5px;"  border="none" alt="<?php echo $this->lang->line('txt_End_Time');?>" /> <?php echo $this->lang->line('txt_End').': '.$this->time_manager->getUserTimeFromGMTTime($arrVal['endtime'],$this->config->item('date_format'));?>&nbsp;</span>

				<?php

				}

			}

			else

			{

				if($subListTime['listStartTime'] != '')

				{

					?>

                    &nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">

                    <?php

                        echo $this->lang->line('txt_Start').': '.$subListTime['listStartTime'];?></span>

                    <?php

				}

				if($subListTime['listEndTime'] != '')

				{

					?>

				&nbsp;&nbsp;&nbsp;<span class="style1" style="margin-left:2%;">

				<?php

					echo $this->lang->line('txt_End').': '.$subListTime['listEndTime'];?></span>

				<?php

				}

				

			}
			?> 
			
			
			<?php
            if(!$checksucc && count($contributorsTagName)>0)

            {

            ?>

                

                    <?php echo '<span class="style1" style="display:block;margin-left:3%; font-size:0.8em; font-style:italic; color:#999999;" >'.$this->lang->line('txt_Assigned_To').': '.implode(', ',$contributorsTagName).'</span>';?>

               

            <?php

            }
			
            ?>	
			
					 

            </div>

			<?php

			}

		}

	}

	 

		

}



?>