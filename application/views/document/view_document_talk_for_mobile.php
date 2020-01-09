<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Document ><?php echo strip_tags(stripslashes($arrDocumentDetails['name'])); ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head');?>
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
	<body onUnload="return bodyUnload()">
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
    
    <?php
			$treeMainVersion 	= $arrDocumentDetails['version'];			
			 
			$leftLink			= '';
			$rightLink			= '';
			$leftVersionLink	= '';
			$rightVersionLink	= '';	
			
			$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
			$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);
			

			?>
    <div class="menu_new" >
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
        <li class="document-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1"  title="<?php echo $this->lang->line('txt_Document_View');?>" ></a></li>
        <li class="time-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=2" title="<?php echo $this->lang->line('txt_Time_View');?>" ><span></span></a></li>
        <li class="tag-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=3"  title="<?php echo $this->lang->line('txt_Tag_View');?>" ><span></span></a></li>
        <li class="link-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=4"  title="<?php echo $this->lang->line('txt_Link_View');?>" ><span></span></a></li>
        <li class="talk-view_sel"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=7"  class="active"title="<?php echo $this->lang->line('txt_Talk_View');?>"><span></span></a></li>
        <?php
					if (($workSpaceId==0))
					{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" ><span></span></a></li>
        <?php
					}
				?>
		<div class="tab_for_landscape">		
        <li id="treeUpdate"></li>
       <?php /*?> <li style="float:right;"><img  src="<?php echo base_url()?>images/new-version.png" onclick="location.reload()" style=" cursor:pointer" ></li><?php */?>
		
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
    <?php

				$nodeBgColor = 'seedBgColor';

				$temp_array=array();
				$main_array=array();
				
				
						
				 
		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
		{
		?>
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span> </div>
    <?php
		}
			
			
						
			
           
            $focusId = 3;
	
		
		$i = 1;
		
		if(count($talkDetails) > 0)
		{
			
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
			
		foreach($main_array as $keyVal=>$arrVal)
		{	 
		 
		 	$leafNodeData = $this->document_db_manager->getNodeDataByLeafId($arrVal['leaf_id']);
					//Add draft reserved users condition
					$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrVal['leaf_id']);
					$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafNodeData['treeId'], $leafNodeData['nodeOrder']);	
					$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($leafNodeData['treeId'], $leafParentData['parentLeafId'],$_SESSION['userId']);
					//Get reserved users
					$reservedUsers = '';
					$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
					$resUserIds = array();			
					foreach($reservedUsers  as $resUserData)
					{
						$resUserIds[] = $resUserData['userId']; 
					}
					//Code end	
					if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
					{
		 
		 $talk=$this->discussion_db_manager->getLastTalkByTreeId($arrVal['id']);
		 $talk_commentor = $this->notes_db_manager->getUserDetailsByUserId($talk[0]->userId);
		
		 
?>
    <div style=" background-color:#FFFFFF;"> <!-- Leaf Container Starts here -->
          
          <div style="width:100%; float:left; margin-bottom:2px;" onClick="showNotesNodeOptions(<?php echo $position;?>);" class="<?php echo $nodeBgColor;?> handCursor">
        <div style="width:100%; float:left;" class="<?php echo $nodeBgColor;?>">
              <?php
					
				  if($arrVal['isTree']==1)
				  {
					
					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$arrVal['leaf_id'].'/1\' ,\'\',\'width=850,height=500,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';
					}
					else
					{
					echo '<a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;';
					
					}
					

					?>
					
					
            </div>
        <div style="width:100%;" class="<?php echo $nodeBgColor;?>">
              <div id='leaf_contents<?php echo $position; ?>' class="treeLeafView">
            <?php
				 if($arrVal['leaf_id']==$treeId)
				  {
				  
				 ?>
            <?php  echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exit1&option=1&node='.$arrVal['leaf_id'].'&tagId=1#docLeafContent'.$arrVal['leaf_id'].' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrVal['content'],0,250)).'</a>'; 
				
				  }else
				  {
				  
				  $nodeId=$this->identity_db_manager->getNodeIdByLeafId($arrVal['leaf_id']); 

				 echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exit1&option=1&node='.$nodeId.'&tagId=1#docLeafContent'.$nodeId.' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrVal['content'],0,250)).'</a>'; 
				  
				  }
				
				?>
          </div>
		   <div class="userLabelNoFloat flLt" style="padding:1% 0%;"><?php echo $talk_commentor['userTagName']; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> </div>
					 <div class="clr"></div>
            </div>
      </div>
          <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
          <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
            <?php	
				$tagAvlStatus = 0;				
				
							
				
				
				
				
				
							
				?>
          </div>
          </span> </span>
          <?php	
				#*********************************************** Tags ********************************************************																		
				?>
        </div>
    <?php 
	}//code end
	}
	 ?>
    <div id="contentSearchDiv" handlefor="contentSearchDiv" style="display:none; border:1px solid BLACK; position:absolute; width:350px; height:100px; z-index:2; left: 300px; top: 110px;"> Please enter the text to search:
          <input type="text" name="leafSearch" id="leafSearch">
          <input type="button" name="search" value="<?php echo $this->lang->line('txt_Done');?>" onClick="searchText(<?php echo $treeId;?>)">
          &nbsp;&nbsp;
          <input type="button" value="<?php echo $this->lang->line('txt_Close');?>" onClick="hideSearch('contentSearchDiv')">
        </div>
  </div>
    </div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>
<script>
		// Keep Checking for tree updates every 5 second
		<!--Updated by Surbhi IV-->
		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','<?php echo $arrDocumentDetails['version']; ?>')", 10000);	
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','<?php echo $arrDocumentDetails['version']; ?>')", 20000);
		<!--End of Updated by Surbhi IV-->
</script>