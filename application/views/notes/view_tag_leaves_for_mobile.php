<?php

$tagId = $this->uri->segment(8);//tag type id

$treeId = $this->uri->segment(3);

$tagType = $this->uri->segment(9);

$usr = $this->uri->segment(10);

$tag = $this->uri->segment(11);





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



if(!empty($_SESSION['tagLeaves'])){		

	$attachedTags = $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1);

	$details      = $this->chat_db_manager->getPerentInfo($treeId);

	

	if(!empty($attachedTags) && (in_array($treeDetail['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

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

	        <div class="seedBgColor treeLeafView" style="margin:3px;">

            <?php
				/*$this->identity_db_manager->formatContent( $treeDetail['name'],1000,1)*/
                echo '<a href="'.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'/'.$tag.'/'.$tagId.'/'.$tagType.'" style="text-decoration:none; color:#000;">'.stripslashes(substr($treeDetail['name'],0,250)).'</a>';

            ?>

            </div>

        <?php

    	}

	}

	?>

				

	<?php

    

    

    if(count($Contactdetail) > 0)

    {	

		$i=1;

        foreach($Contactdetail as $keyVal=>$arrVal)

        {

            $userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

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

					<div class="<?php echo $nodeBgColor;?> views_div treeLeafView" style="margin:9% 0%;">

				

						<?php
							/*$this->identity_db_manager->formatContent( $arrVal['contents'],1000,1)*/
							 echo '<div><a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrVal['contents'],0,250)).'</a></div>';

						?>

                         <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;"; ?> <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>

						</div>

					<?php

					}

           	 }

            ?>

        

      <div style="padding-left:20px;">

    <?php

            

?>

</div>

<?php

		}



	}

}

else{

	$details=$this->chat_db_manager->getPerentInfo($treeId);

	if(in_array($treeDetail['userId'],$_SESSION['usrLeaves'])){

		?>

        <div class="seedBgColor treeLeafView" style="margin:3px;">

			<?php
			/*$this->identity_db_manager->formatContent($treeDetail['name'],1000,1)*/
            echo '<a href="'.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.'/'.$tag.'/'.$tagId.'/'.$tagType.'" style="text-decoration:none; color:#000;">'.stripslashes(substr($treeDetail['name'],0,250)).'</a>';

        	?>

        </div>

		<?php

	}

	

	if(count($Contactdetail) > 0)

    {	

        foreach($Contactdetail as $keyVal=>$arrVal)

        {

			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	

           if(in_array($arrVal['userId'],$_SESSION['usrLeaves'])){

			$nodeBgColor = ($i%2)?'row1':'row2';

			$i++;?>

				<div class="<?php echo $nodeBgColor;?> views_div treeLeafView" style="margin:9% 0%;">

				

                <?php
					/*$this->identity_db_manager->formatContent($arrVal['contents'],1000,1)*/
                     echo '<div><a href='.base_url().'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrVal['contents'],0,250)).'</a></div>';

                ?>

                 <div class="userLabel" style="margin-top:5px;"><?php echo  $userDetails1['userTagName']."&nbsp;"; ?> <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>

                </div>

				<?php

           }

		}



	}

	

	

}



?>