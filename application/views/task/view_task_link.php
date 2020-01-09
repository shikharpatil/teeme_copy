<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

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

	<?php 

	if($this->input->get('doc') == 'new')

	{

	?>

		<body onUnload="return bodyUnload()" onLoad="showFocus(<?php echo $whoFocus;?>)">	

	<?php

	}

	else

	{	

		echo '<body onUnload="return bodyUnload()">';	

	}

	?>

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

			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

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

			

			$day 	= date('d');

			$month 	= date('m');

			$year	= date('Y');	

			 ?>

			

<div class="menu_new" >

            <ul class="tab_menu_new">

				<li class="task-view"><a class="1tab" href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task_View');?>" ></a></li>

				<li class="time-view"><a   href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2"  title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>

				

				<li class="tag-view" ><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>

						

    			<li class="link-view_sel"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5"   class="active"   title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>

				

				 <li class="talk-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>" ></a></li>	

				

				<li class="task-calendar"><a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar_View');?>"  ></a></li>

				

                <li class="task-search"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>"  ></a></li>

				

				

				

					

            	<?php

				if (($workSpaceId==0))

				{

				?>

                 <li  class="share-view"><a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6" title="<?php echo $this->lang->line('txt_Share');?>"></a></li>

                <?php

				}

				?>

				

				<li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li>
				
														<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='task';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>

            </ul>

			<div class="clr"></div>

        </div>                

					

            

              <?php	

                $nodeBgColor = 'nodeBgColor';

                if($this->input->get('tagId') != '' && $this->input->get('node') == '')

                {

                    $nodeBgColor = 'seedBgColor';

                }

                ?>		      

         

        

        

        

        <?php

        if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

        {

        ?> 

        

        <div class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></div>

                    

        <?php

        }

        ?>

                    

        <table width="100%" border="0" cellspacing="0" cellpadding="0">			

                    <tr>

                      <td  colspan="2"><?php echo $this->lang->line('txt_Links_Applied');?>:<br><br></td>

                  </tr>

                                                

                    <tr>

                      <td  colspan="2">

                        <?php 

                            $arrNodeIds = array();

                            $arrOldTreeVersions = array();

                            

                            //echo "treeid= " .$treeId; exit;

                            

                            $arrNodeIds = $this->task_db_manager->getNodeIdsByTreeId($treeId);

                            //print_r ($arrNodeIds); exit;

/*										$oldTreeVersions = $this->document_db_manager->hasparent($treeId);





                            if ($oldTreeVersions!=0)

                            {

                                $arrOldTreeVersions = explode(',',$oldTreeVersions);



                                $arrNewNodeIds = array();



                                foreach ($arrOldTreeVersions as $key=>$treeId)

                                {	

                                    $newNodeIds = $this->document_db_manager->getNodeIdsByTreeId($treeId);

                                    $arrNodeIds = array_merge($arrNodeIds, $newNodeIds);

                                                            

                                }



                            }

*/

                            //print_r ($arrNodeIds); exit;

                            

                            $nodeIds = implode(',', $arrNodeIds);

                            

                            if (!empty($nodeIds))

                                $nodeIds		.= ','.$treeId;

                            else

                                $nodeIds		= $treeId;

                                

                            //echo "<li>nodeids= " .$nodeIds ."<li>"; exit;



                            //$leafLinks $this->document_db_manager->getLeafLinksByLeafIds($nodeIds, 2);

                            

                            $arrNewNodeIds = explode (',',$nodeIds);

                            $arrDocTreeIds = array();	

                            



                            $linkId = $this->uri->segment(8);

                            

                            foreach($arrNewNodeIds as $key => $value)

                            {

                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 1);	

								//echo $value."<pre>";print_r($getTrees);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                        $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Document');

                                        }	

                                        if (!in_array(strip_tags($treeName),$docLinksStore))

                                        {				

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $docArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>'; 	

                                        }

                                        $docLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }

                                

                                

                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 2);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Discussion');

                                        }

                                        if (!in_array(strip_tags($treeName),$disLinksStore))

                                        {					

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $disArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>';  	

                                        }

                                        $disLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }	

                                

                                

                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 3);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Chat');

                                        }	

                                        if (!in_array(strip_tags($treeName),$chatLinksStore))

                                        {				

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $chatArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>'; 	

                                        }

                                        $chatLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }

                                

                                

                                

                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 4);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Task');

                                        }	

                                        if (!in_array(strip_tags($treeName),$activityLinksStore))				

                                        {

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $activityArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>';  	

                                        }

                                        $activityLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }										





                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 5);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Contacts');

                                        }

                                        if (!in_array(strip_tags($treeName),$contactLinksStore))	

                                        {					

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $contactArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>';  	

                                        }

                                        $contactLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }	

                                

                                

                                $getTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 6);

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $treeName = $data['name'];

                                        $arrDocTreeIds[] = $data['treeId'];	

                                        

                                        if(trim($treeName) == '')

                                        {

                                            $treeName = $this->lang->line('txt_Notes');

                                        }	

                                        if (!in_array(strip_tags($treeName),$notesLinksStore))					

                                        {

                                            $class="";

                                            if($linkId==$data['treeId']){

                                                $class='class="highlight"';

                                            }

                                            $notesArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['treeId'].'" '.$class.'>'.strip_tags($treeName).'</a>';  	

                                        }

                                        $notesLinksStore[] = strip_tags($treeName);

                                        $i++;

                                        }					

                                    }

                                }

                                

                                

                                $getTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($value,'');			

                                if (!empty($getTrees))

                                {	

                                    $docTrees = $getTrees;

                                    if(count($docTrees) > 0)

                                    {

                                        $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $docName = $data['docName'];

                                        $arrImportFileIds[] = $data['docId'];	

                                        if(trim($docName) == '')

                                        {

                                            $docName = $this->lang->line('txt_Imported_Files');

                                        }											

                                        

                                        //$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";

                                        if (!in_array($docName.'_v'.$data['version'],$importLinksStore))	

                                        {

                                            $class="";

                                            if($linkId==$data['docId']){

                                                $class='class="highlight"';

                                            }

                                            $importArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['docId'].'" '.$class.'>'.$docName.'_v'.$data['version'].'</a>'; 

                                        }

                                        $importLinksStore[] = $docName.'_v'.$data['version'];

                                        $i++;

                                        }						

                                    }	

                                }

                                $docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($value,'' );

                                if (!empty($docTrees9))

                                {	

                                    $docTrees = $docTrees9;

                                    

                                    if(count($docTrees) > 0)

                                    {

                                    $i = 1;	

                                        foreach($docTrees as $data)

                                        {	

                                        $urlName = $data['title'];

                                        $urlTreeIds[] = $data['artifactId'];	

                                        

                                        if(trim($urlName) == '')

                                        {

                                            $urlName = $this->lang->line('txt_URL');

                                        }	

                                        if (!in_array(strip_tags($urlName),$urlNameStore))					

                                        {

                                            $class="";

                                            if($linkId==$data['urlId']){

                                                $class='class="highlight"';

                                            }

                                            $urlStore[] = '<a href="'.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5/'.$data['urlId'].'" '.$class.'>'.strip_tags($urlName).'</a>'; 

                                        }

                                        $urlNameStore[] = strip_tags($urlName);

                                        $i++;

                                        }					

                                    }

                                }												

                            }

                            if ($docArtifactLinks)

                                echo $this->lang->line('txt_Document').': '.implode(', ',$docArtifactLinks).'<br><br>';

                            if ($disArtifactLinks)

                                echo $this->lang->line('txt_Discussions').': '.implode(', ',$disArtifactLinks).'<br><br>';

                            if ($chatArtifactLinks)

                                echo $this->lang->line('txt_Chat').': '.implode(', ',$chatArtifactLinks).'<br><br>';

                            if ($activityArtifactLinks)

                                echo $this->lang->line('txt_Task').': '.implode(', ',$activityArtifactLinks).'<br><br>';

                            if ($notesArtifactLinks)

                                echo $this->lang->line('txt_Notes').': '.implode(', ',$notesArtifactLinks).'<br><br>';

                            if ($contactArtifactLinks)

                                echo $this->lang->line('txt_Contacts').': '.implode(', ',$contactArtifactLinks).'<br><br>';

                            if ($importArtifactLinks)

                                echo $this->lang->line('txt_Imported_Files').': '.implode(', ',$importArtifactLinks).'<br><br>';

                            if ($importedUrl)

                                echo $this->lang->line('txt_Imported_URL').': '.implode(', ',$importedUrl).'<br><br>';

                            if ($urlStore)

                                echo $this->lang->line('txt_Imported_URL').': '.implode(', ',$urlStore).'<br><br>';	



                                if(count($importArtifactLinks) == 0 && count($contactArtifactLinks)==0 && count($notesArtifactLinks)==0 

                                && count($activityArtifactLinks)==0 && count($chatArtifactLinks)==0 && count($disArtifactLinks)==0 

                                && count($docArtifactLinks)==0 && count($urlStore)==0)	

                                {

                                    echo $this->lang->line('msg_tags_not_available');

                                }



                            ?>			

                                   

                                  </td>

							  </tr>

		

					</table>                

<?php 

$linkId = $this->uri->segment(8);



if(1)

{

			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1,1);

			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2,1);

			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3,1);

			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4,1);

			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5,1);

			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6,1);

			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId,1);	

			$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId,1);		

			

			//$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($value, 1);

			

			$count = 0;

			if (!empty($docTrees))

			{												

					foreach($docTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			

			if (!empty($disTrees))

			{												

					foreach($disTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}	

			if (!empty($chatTrees))

			{												

					foreach($chatTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($activityTrees))

			{												

					foreach($activityTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($contactTrees))

			{												

					foreach($contactTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}			

			if (!empty($notesTrees))

			{												

					foreach($notesTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($externalTrees))

			{												

					foreach($externalTrees as $data)

					{		

						if ($data['docId'] == $linkId)

							$count++;

					}

			}

			if (!empty($docTrees9))

			{												

					foreach($docTrees9 as $data)

					{		

						if ($data['urlId'] == $linkId )

							$count++;

					}

			}

											

				if ($count != 0)

					$nodeBgColor = 'seedBgColor';

				else

					$nodeBgColor = '';

					

		if (!empty($nodeBgColor))

		{					

?>			<div class="seedBgColor views_div">

			<?php //echo stripslashes($arrDiscussionDetails['name']); 
			/*$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],1000,1)*/
            echo '<a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDiscussionDetails['name'],0,1000)).'</a>';

            

            ?>

            </div>

<?php

		}

?>         



	<?php

	$totalNodes = array();

	$nodeBgColor = '';

	if(count($discussionDetails) > 0)

	{			 

		$i=0;

		foreach($discussionDetails as $keyVal=>$arrVal)

		{

			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1,2);

			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2,2);

			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3,2);

			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4,2);

			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5,2);

			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6,2);

			$externalTrees 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'],2);	

			$docTrees9 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], '2');			

						

			$count = 0;

			if (!empty($docTrees))

			{												

					foreach($docTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			

			if (!empty($disTrees))

			{												

					foreach($disTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}	

			if (!empty($chatTrees))

			{												

					foreach($chatTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($activityTrees))

			{												

					foreach($activityTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($contactTrees))

			{												

					foreach($contactTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}			

			if (!empty($notesTrees))

			{												

					foreach($notesTrees as $data)

					{		

						if ($data['treeId'] == $linkId)

							$count++;

					}

			}

			if (!empty($externalTrees))

			{												

					foreach($externalTrees as $data)

					{		

						if ($data['docId'] == $linkId)

							$count++;

					}

			}

			

			if (!empty($docTrees9))

			{		

			   								

					foreach($docTrees9 as $data)

					{		

						if ($data['urlId'] == $linkId)

							$count++;

					}

			}										

				if ($count != 0)

					$nodeBgColor = 'seedBgColor';

				else

					$nodeBgColor = '';				



			

			$totalNodes[] = $arrVal['nodeId'];

			$userDetails1	= 	$this->task_db_manager->getUserDetailsByUserId($arrVal['userId']);	

			$checksucc 		=	$this->task_db_manager->checkSuccessors($arrVal['nodeId']);
			
			$contributors 				= $this->task_db_manager->getTaskContributors($arrVal['nodeId']);
			
			$contributorsTagName		= array();

			$contributorsUserId			= array();
			
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
			}	
			
			$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
			$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrVal['nodeId']);
			

			$this->task_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

			

			$viewCheck=$this->task_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);

		?>			

			<?php

			if (!empty($nodeBgColor))

			{

				$nodeBgColor = ($i%2)?'row1':'row2';

				$i++;

				?>

				<div class="<?php echo $nodeBgColor;?> views_div">	

					<?php
					echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%">';
					?>

					<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#taskLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent( $arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>							
					
					<?php 
					echo '</div>';
					//echo stripslashes($arrVal['contents']); 

					//echo '<div style="float:left;width:3%"><img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'></div><div style="float:left;width:87%"><a href='.base_url().'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a></div>';



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

            ?>             

			

		

		<?php

		}

	}

	 

?>



<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

 

</div>

<?php

}

?>                    



    

</div>

</div>

<?php $this->load->view('common/foot.php');?>

<?php $this->load->view('common/footer');?>

</body>

</html>	

<script Language="JavaScript" src="<?php echo base_url();?>js/task.js"></script>