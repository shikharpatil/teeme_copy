<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Contact ><?php echo strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname'],'<b><em><span><img>');?></title>
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
	<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->
<script>
function edit_close(pos,nodeId){
	
	var divId=pos+'edit_notes';
	var editorId = 'editDiscussion'+nodeId;
	
	document.getElementById(editorId).style.display='none';
	document.getElementById(divId).style.display='none';
}
function edit_close_1(pos,nodeId){
	document.form2.editStatus.value = 0;	
	var divId=pos+'edit_contacts';
	var INSTANCE_NAME = $("#editorLeafContents"+pos+"1").attr('name');
	
	editorClose(INSTANCE_NAME);
	
	//Manoj: froala editor show contact leaf content on cancel
	
	document.getElementById('contactLeafContent'+nodeId).style.display="block";
	
	document.getElementById(divId).style.display='none';
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
<div id="container_for_mobile" class="contactWrapper">
  <div id="content"> 
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			
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
    
    <?php
				if ($treeId == $this->uri->segment(8)|| $treeId == $this->input->get('node'))
					$nodeBgColor = 'nodeBgColorSelect1';
				else
					$nodeBgColor = 'seedBgColor';
			?>
    <?php $nodeOrder = 1;?>
    <div class="menu_new" >
	
		<!--follow and sync icon code start -->
		<ul class="tab_menu_new_for_mobile tab_for_potrait">
			 <li id="treeUpdate" style="float:right;"><img id="updateImage"  src="<?php echo base_url()?>images/new-version.png" onclick='window.location="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"' style=" cursor:pointer" ></li>
		
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
        <li class="contact-view_sel"><a class="active 1tab" href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Contact_View');?>" ></a></li>
        <li class="time-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
        <li class="tag-view" ><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <li class="talk-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>"  ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
				<div class="tab_for_landscape">
        <li id="treeUpdate"></li>
        <li id="treeUpdate" style="float:right;"><img id="updateImage"  src="<?php echo base_url()?>images/new-version.png" onclick='window.location="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"' style=" cursor:pointer" ></li>
		
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
    
    <!---------  Seed div starts here ---->
    
    <div  onclick="clickNodesOptions(0)"   onmouseout="hideNotesNodeOptions(0)"  onmouseover="showNotesNodeOptions(0);" id="divSeed" class="<?php echo $nodeBgColor; ?>"  style="min-height:200px;"  >
      <?php	$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
		$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				
		$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);
		$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);

		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 1, 1);
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 2, 1);
		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 3, 1);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 4, 1);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 5, 1);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($treeId, 6, 1);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($treeId, 1);	
		$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($treeId, 1);	
		
		$total=0;	
?>
      <!-- container drop down ,tags,link,talk container -->
      <div  style="height:20px; ">
        <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " > 
          
          <!-- drop down container -->
          <div style="float:left; margin-right:10px;" class="selCont">
            <div class="newListSelected" tabindex="0" style="position: relative;outline:none;">
              <div class="selectedTxt" onclick="showTreeOptions()" ></div>
              <ul id="ulTreeOption" style="visibility: visible; width: 140px; top: 19px; left: 0pt;  display: none;" class="newList">
                <?php 	
						if ( $this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId1, $placeType))
            			{
					?>
                <li><a id="aMove" href="JavaScript:void(0);"  onclick="treeOperationsContact(this,'move',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Move')?></a></li>
                <?php
						}
					?>
                <?php /*?></li><?php */?>
				
				<?php /*?><li><a id="aNumbered" href="JavaScript:void(0);"  onclick="treeOperationsnew(this,'autoNumbering',<?php echo $treeId; ?>)"  onmouseout="operationOut(this)"  onmouseover="operationIn(this);" ><?php echo $this->lang->line('txt_Numbered_Contact');?></a></li><?php */?>
				
				<?php 
		
					$treeName['treeName']='contact';
					$this->load->view('common/printPage_for_mobile',$treeName);	
					
				?>
				
              </ul>
            </div>
          </div>
          <!--  close drop down container --> 
          
          <!-- icons of tags,link,talk -->
          <ul  class="content-list" style="float:left" >
            <?php
						
				$tag_container='';
				$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
				if($total==0)
				{
				  $total='';
				  $tag_container=$this->lang->line('txt_None');
				}
				else
				{
				
					 if(count($viewTags)>0)
					 {
						$tag_container=$this->lang->line('txt_Simple_Tag').' : ';
						foreach($viewTags as $simpleTag)
						$tag_container.=$simpleTag['tagName'].", ";
						$tag_container=substr($tag_container, 0, -2)." 
"; 
					 
					}
					
										
					if(count($actTags) > 0)
						{
						   $tag_container.=$this->lang->line('txt_Response_Tag').' : ';
							$tagAvlStatus = 1;	
							foreach($actTags as $tagData)
							{	$dispResponseTags='';
								$dispResponseTags = $tagData['comments']."[";							
								$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
								if(!$response)
								{  
									
									if ($tagData['tag']==1)
										$dispResponseTags .= $this->lang->line('txt_ToDo');									
									if ($tagData['tag']==2)
										$dispResponseTags .= $this->lang->line('txt_Select');	
									if ($tagData['tag']==3)
										$dispResponseTags .= $this->lang->line('txt_Vote');
									if ($tagData['tag']==4)
										$dispResponseTags .= $this->lang->line('txt_Authorize');															
								}
								$dispResponseTags .= "], ";	
													
								
								
								$tag_container.=$dispResponseTags;
							}
							
							$tag_container=substr($tag_container, 0, -2)."
"; 
						}
						
						
						if(count($contactTags) > 0)
						{
							$tag_container.=$this->lang->line('txt_Contact_Tag').' : ';
							$tagAvlStatus = 1;	
							foreach($contactTags as $tagData)
							{
								
								$tag_container .= strip_tags($tagData['contactName'],'').", ";	
								
							}
							
							$tag_container=substr($tag_container, 0, -2); 
						}		
							
					}
						
				?>
            <li><a id="liTag0" class="tag"  title="<?php echo $tag_container; ?>" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $treeId ; ?>/1/1', 710, 500, null, '');" href="javascript:void(0);"  ><strong><?php echo $total; ?></strong></a></li>
            <?php	
						//count totoal number of links
            			$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9);
						
						if($total==0)
						{
						  $total='';
						  $appliedLinks=$this->lang->line('txt_None');
						}
						else
						{
						
							
						   $appliedLinks='';
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							
							 if(count($docTrees3)>0)
						   {
								$appliedLinks.=$this->lang->line('txt_Chat').': ';	
								foreach($docTrees3 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees4)>0)
							{
							
								$appliedLinks.=$this->lang->line('txt_Task').': ';	
								foreach($docTrees4 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees6)>0)
							{
								$appliedLinks.=$this->lang->line('txt_Notes').': ';	
								foreach($docTrees6 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}
							
							if(count($docTrees5)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
								foreach($docTrees5 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
							
							if(count($docTrees7)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
							         
									if($linkData['docName']=='')
									 {
									    $appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
									 }
									 else
									 {
									 	$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 }
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
						   
						   if(count($docTrees9	)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
								foreach($docTrees9 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['title'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2);
							
							}
						}
					
				?>
            <li  ><a id="liLink0"  class="link disblock" onclick="getElementById('ulTreeOption').style.display='none';showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $treeId; ?>/1/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/1/0/1', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks,''); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
            <?php 
						
					$total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
					/*<!--Added by Surbhi IV -->	*/	
					$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);
					if(strip_tags($talk[0]->contents))
					{
						$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
						$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
					}
					else
					{
						$latestTalk='Talk';
					}	
					/*<!--End of Added by Surbhi IV -->	*/  
					if($total==0)
					{
						$total='';
					}
					
			
						/*<!--Cahnged title by Surbhi IV -->	*/
						echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)" class="talk"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/1\' ,\'\',\'width=850,height=600,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
						/*<!--End of Changed title by Surbhi IV -->	*/
				
				
					$lastnode=$arrVal['nodeId'];	
					?>
          </ul>
          <!-- close icons of tags,link,talk --> 
          
        </div>
        <div class="clr"></div>
      </div>
      ` <!--close container drop down ,tags,link,talk container -->
      
      <div class="clsNoteTreeHeader handCursor"  > 
        
        <!-- user name container -->
        <div style="width:100%; height:18px; float:left; font-size:1.2em;"  class="<?php echo $nodeBgColor;?> handCursor seedHeading <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
          <?php
						echo strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname'],'<b><em><span><img>');
					?>
        </div>
        <!-- close user name container --> 
        
        <!-- user details -->
        <div id="normalView0_old" class="<?php echo $nodeBgColor;?> <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" style="width:100%; float:left; font-weight:normal;">
         
		  <div style="margin-left:15px;width:100%;padding-bottom:5px;">
            	<div class="contactSeedDetails" > <?php echo $this->lang->line('txt_Tag_Name');?>:</div> 
				<div class="contactLabel2" style="float:left; margin-top:5px;"><?php echo $Contactdetail['name'];?> </div>
				<div class="clr"></div>
            	<div class="contactSeedDetails" > <?php echo $this->lang->line('txt_Company_Name');?>:</div>
				<div class="contactLabel2" style="float:left; margin-top:5px;"> <?php echo $Contactdetail['company'];?> </div>
				<div class="clr"></div>	
				<?php
				if ($Contactdetail['email']!='')
				{
				?>	
            	<div class="contactSeedDetails" > <?php echo $this->lang->line('txt_Email');?>:</div>
				<div class="contactLabel2" style="float:left; margin-top:5px;"> <?php echo $Contactdetail['email'];?> </div>
				<div class="clr"></div>
				<?php						
          		}
				?>
				<?php
				if ($Contactdetail['comments']!='')
				{
				?>	
            	<div class="contactSeedDetails" > <?php echo $this->lang->line('txt_Status');?>:</div>
				<div class="contactLabel2" style="float:left; margin-top:5px;"> <?php echo $Contactdetail['comments'];?> </div>
				<div class="clr"></div>		
				<?php						
          		}
				?>
            	<div class="contactSeedDetails"> <?php echo $this->lang->line('txt_Access');?>:</div>
				<div class="contactLabel2" style="float:left; margin-top:5px;"> <?php if($Contactdetail['sharedStatus'] == 2){echo $this->lang->line('txt_Private');}else{echo $this->lang->line('txt_Public');}?> </div>
				<div class="clr"></div>					
		  </div>
        </div>
        <a href="javascript:showContactDetails();"><span  style=" margin-left:15px;" id="hideShowDetails"><?php echo $this->lang->line('txt_View_Details');?></span></a> 
        
        <!-- close user details --> 
        
        <!-- -------- user information  -->
        <div id="contactDetails" class="<?php echo $nodeBgColor;?> <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" style="width:115%; float:left; display:none; padding-left:0px;">
          <?php 
				if(count($Contactdetail))
				{
				?>
			<!--Manoj: Added contactlabelmob class for alignment-->
		   <div class="contactLabel contactLabelMob" style="padding:5px 15px;"> <strong><?php echo $this->lang->line('txt_Company_Details');?></strong> </div>
		   <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_user_full_name');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['company'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Website');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['website'];?>&nbsp; </div>
                      <div class="clr"></div>
                     
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Address');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['address'];?>&nbsp; </div>
                      <div class="clr"></div>
				
                      <div class="contactLabel contactLabelMob" style="padding:5px 15px;"> <strong><?php echo $this->lang->line('txt_Contact'); /*echo $this->lang->line('txt_Personal_Details');*/?></strong> </div>
					   <div class="clr"></div>
                      <div class="contactLabel contactLabelMob" ><?php echo $this->lang->line('txt_Title');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['title'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_First_Name');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['firstname'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <?php /*?><div class="contactLabel"><?php echo $this->lang->line('txt_Middle_Name');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['middlename'];?>&nbsp; </div>
                      <div class="clr"></div><?php */?>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Last_Name');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['lastname'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Tag_Name');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['name'];?>&nbsp; </div>
                      <div class="clr"></div>
					   <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Role');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['designation'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <?php /*?><div class="contact_details_heading"> <strong><?php echo $this->lang->line('txt_Contact_Details');?></strong> </div>
                      <div class="clr"></div><?php */?>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Email');?>:</div>
                      <div class="contactLabel2"><?php echo $Contactdetail['email'];?>&nbsp;</div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Fax');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['fax'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Mobile');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['mobile'];?>&nbsp; </div>
                      <div class="clr"></div>
                      <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Contact_Mobile');?>:</div>
                      <div class="contactLabel2"> <?php echo $Contactdetail['landline'];?>&nbsp; </div>
                      <div class="clr"></div>
                     <?php /*?> <div class=""> <strong><?php echo $this->lang->line('txt_contact_notes');?></strong> </div>
                      <div class="clr"></div><?php */?>
					  <div class="contactLabel contactLabelMob"><strong><?php echo $this->lang->line('txt_contact_notes');?></strong></div>
                     <?php /*?> <div class="contactLabel contactLabelMob"><?php echo $this->lang->line('txt_Other');?>:</div><?php */?>
                      <div class="contactLabel2"> <?php echo $Contactdetail['other']; ?>&nbsp; </div>
                      <div class="clr"></div>	
			
			
         
          <div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
            <?php if($Contactdetail['predecessor']){?>
            <a href="javascript:viewOldContact(<?php echo $Contactdetail['predecessor'];?>)"><img src="<?php echo base_url();?>images/left.gif" border="0"  /></a>
            <?php }?>
            &nbsp;
            &nbsp;
            <?php if($Contactdetail['succesor']){?>
            <a href="javascript:viewOldContact(<?php echo $Contactdetail['succesor'];?>)"><img src="<?php echo base_url();?>images/right.gif" border="0" /></a>
            <?php }?>
          </div>
          <div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;">
            <input type="button" name="Edit" value="<?php echo $this->lang->line('txt_Edit');?>" onClick="contactEdit();" class="button01">
            <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="showContactDetails();" class="button01">
          </div>
          <?php
				}
				?>
        </div>
        <!-- -------- close user information  --> 
        
        <!-- -------- edit user information  -->
        <div id="contactDetailsEdit" class="<?php echo $nodeBgColor;?> <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; display:none;">
          <form name="form1" method="post" action="<?php echo base_url();?>contact/editContact/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" id="contactDetailsEditForm">
            <div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;"> <strong><?php echo $this->lang->line('txt_Company_Details');?></strong> </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_user_full_name');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="company" type="text" id="company_name" value="<?php echo $Contactdetail['company'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Website');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="website" type="text" id="website" value="<?php echo $Contactdetail['website'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Address');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <textarea name="address" rows="3" id="address" style="width:27%;"><?php echo $Contactdetail['address'];?></textarea>
                        </div>
            <div class="clr"></div>
            <div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;"> <strong><?php echo $this->lang->line('txt_Contact'); /*echo $this->lang->line('txt_Personal_Details');*/ ?> </strong> </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Title');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="title" type="text" id="title" value="<?php echo $Contactdetail['title'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_First_Name');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="firstname" type="text" id="first_name" onBlur="displayname();" value="<?php echo $Contactdetail['firstname'];?>" readonly="">
                           </div>
            <div class="clr"></div>
			<div style="display:none;">
            <div class="contactLabel"><?php echo $this->lang->line('txt_Middle_Name');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="middlename" type="text" id="middle_name" onBlur="displayname();" value="<?php echo $Contactdetail['middlename'];?>" readonly="">
                        </div>
            <div class="clr"></div>
			</div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Last_Name');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="lastname" type="text" id="last_name" onBlur="displayname();" value="<?php echo $Contactdetail['lastname'];?>" readonly="">
                          </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Tag_Name');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="display_name" type="text" id="display_name" value="<?php echo $Contactdetail['name'];?>" <?php if($treeId){?> readonly=""<?php }?>>
                           </div>
            <div class="clr"></div>
			 <div class="contactLabel"><?php echo $this->lang->line('txt_Role');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="designation" type="text" id="designation" value="<?php echo $Contactdetail['designation'];?>">
                        </div>
            <div class="clr"></div>
			<div class="contactLabel"><?php echo $this->lang->line('txt_Email');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="email" type="text" id="email" value="<?php echo $Contactdetail['email'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Fax');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="fax" type="text" id="fax" value="<?php echo $Contactdetail['fax'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Mobile');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="mobile" type="text" id="mobile" maxlength="20" value="<?php echo $Contactdetail['mobile'];?>">
                        </div>
            <div class="clr"></div>
            <div class="contactLabel"><?php echo $this->lang->line('txt_Contact_Mobile');?>:</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input name="landlineno" type="text" id="landlineno" maxlength="20" value="<?php echo $Contactdetail['landline'];?>">
                        </div>
            <div class="clr"></div>
           
            <div> <strong><?php echo $this->lang->line('txt_Status');?></strong> </div>
            <div class="clr"></div>
            <?php /*?><div class="contactLabel"><?php echo $this->lang->line('txt_Status');?>:</div><?php */?>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <textarea name="comments" id="comments" style="width:27%;"><?php echo $Contactdetail['comments'];?></textarea>
                        </div>
            <div class="clr"></div>
            <?php /*?><div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;"> <strong><?php echo $this->lang->line('txt_Contact_Details');?>:</strong> </div>
            <div class="clr"></div><?php */?>
            
            <div style="width:<?php echo $this->config->item('page_width')-100;?>px; float:left;"> <strong><?php echo $this->lang->line('txt_contact_notes');?></strong>(Max Length 250 Characters): </div>
            <div class="clr"></div>
           <?php /*?> <div class="contactLabel" ><?php echo $this->lang->line('txt_Other');?>:</div><?php */?>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <textarea name="other" id="other" style="width:27%;"><?php echo $Contactdetail['other'];?></textarea>
                        </div>
            <div class="clr"></div>
			 <?php
		  			if ($workSpaceId>0 && ($workSpaceDetails['workSpaceName']!='Try Teeme' || $workSpaceType==2))
		  			{
		  			?>
            <div class=""><strong><?php echo $this->lang->line('txt_Access');?></strong></div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left; font-weight:normal">
                          <input type="radio" name="sharedStatus" value="2" <?php if($Contactdetail['sharedStatus'] == 2) { echo 'checked'; }?>>
                          <?php echo $this->lang->line('txt_Private');?> (<?php echo $this->lang->line('txt_Access_current_space');?>)<br />
                          <input type="radio" name="sharedStatus" value="1" <?php if($Contactdetail['sharedStatus'] == 1) { echo 'checked'; }?>>
                          <?php echo $this->lang->line('txt_Public');?> (<?php echo $this->lang->line('txt_Access_current_place');?>) </div>
            <div class="clr"></div>
            <?php
		  			}
		  			?>
			
            <div class="contactLabel">&nbsp;</div>
            <div style="width:<?php echo $this->config->item('page_width')-200;?>px; float:left;">
                          <input type="submit" name="Submit" value="<?php echo $this->lang->line('txt_Save');?>" onClick="return validate();" class="button01">
                          <input type="button" name="Edit" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="contactEdit()" class="button01">
                          <?php
		  				if ($workSpaceId==0 || ($workSpaceDetails['workSpaceName']=='Try Teeme' && $workSpaceType==1))
		  				{
		  				?>
                          <input type="hidden" name="sharedStatus" value="2" >
                          <?php
						}
						?>
                          <input name="reply" type="hidden" id="reply" value="1">
                        </div>
          </form>
        </div>
        <!-- -------- edit close user information  --> 
        
      </div>
      <?php if($flag==0){ ?>
      <?php } else { ?>
      <script>showContactDetails();</script>
      <?php } ?>
      <div class="clsNoteTreeHeaderLeft" style="width:80%; padding-bottom:10%;" > 
        
		<div id="divAutoNumbering" style="display:none; float:right " >
            <form name="frmAutonumbering" method="post" action="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>">

		

						  

								

								<?php /**************** MOVE TREE CODE START *******************/ ?>

						

						<?php 

							

									if($workSpaceType==2 )

									{

										$placeType=$workSpaceType+1;

										$workSpaceId1=$this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);

										

									

									}

									else

									{

										$placeType=$workSpaceType+2;

									   $workSpaceId1=$workSpaceId;

									}

							

							

							?>

						

						<?php /**************** MOVE TREE CODE CLOSE *******************/ ?>

							<div style="float:left" >	<?php echo $this->lang->line('txt_Numbered_Contact');?>: <input type="checkbox" name="autonumbering" <?php  if($treeDetail['autonumbering']==1) {echo 'checked';}?> onClick="this.form.submit();"/>

							<input type="hidden" name="autonumbering_submit" value="1" />

							</div>

							<div style="float:left">	

								<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideDivAutoNumbering()" style="margin-top:-2px;"  border="0"  /> 

							</div>	

								</form>
          </div>
		  
        <!-- -------- move tree code starts  -->
        <div id="spanMoveTree" style="float:left; text-align:left" >
          <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
          <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
          <div class="lblMoveTree" style="text-align:left;" ><?php echo $this->lang->line('move_tree_to_txt'); ?></div>
		 
          <div class="floatLeft" style="margin-top: 4%; margin-bottom:2%;">
            <?php   
							if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
							{   
								$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
								$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
								$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
							?>
            <select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >
              <?php 
						if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
						?>
              <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
              <?php if($workSpaceId){ ?>
              <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
              <?php } ?>
              <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{				
							if($workSpaceData['workSpaceName']!='Try Teeme')
							{						
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
							?>
              <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
              <?php
			  				}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
						
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
										{
									?>
              <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
              <?php
			  							}	
									}
								}
						}//try teeme restriction end
						}
						}
						else
						{
						?>
              <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
              <?php if($workSpaceId){ ?>
              <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
              <?php } ?>
              <?php
						$i = 1;
					
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{	
							if($workSpaceData['workSpaceName']!='Try Teeme')
							{			
							if($workSpaceData['workSpaceManagerId'] == 0)
							{
								$workSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
								$workSpaceManager = $arrUserDetails['userName'];
							}
							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))
							{
								$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceData['workSpaceId'],1);
								if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
								{
							?>
              <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
              <?php
								}
							}
							$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
					
								if(count($subWorkspaceDetails) > 0)
								{
									foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
									{	
										if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
										{		
											if($workSpaceData['subWorkSpaceManagerId'] == 0)
											{
												$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
											}
											else
											{					
												$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
												$subWorkSpaceManager = $arrUserDetails['userName'];
											}
										}
										if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
										{
											$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceData['subWorkSpaceId'],2);
											if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
											{
									?>
              <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
              <?php
											}
										}
									}
								}
						}//try teeme restriction end
						}
						
						}
						?>
            </select>
            <?php
					}
					?>
          </div>
          <div  class="floatLeft" id="divselectMoveToUser" style="margin: 2% 0%;" > </div>
          &nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
        <!-- -------- move tree code close here  --> 
      </div>
      <div style="height:65px;">
        <div id="normalView0" class="normalView" style="display:none"  >
          <div class="lblNotesDetails"   > 
            <!--/*Changed by Surbhi IV*/-->
            <div style="float:left; margin-left:20px; margin-top:0px;"> <a href="javascript:reply(0,0);"  style="margin-right:25px;" ><img src="<?php echo base_url(); ?>images/addnew.png" alt="<?php echo $this->lang->line("Add"); ?>" title="<?php echo  $this->lang->line("Add"); ?>"  border="0"></a>&nbsp;&nbsp; </div>
            <!--/*End of Changed by Surbhi IV*/-->
            <div class="style2" style="width:70%;"> <?php echo $originator['userTagName'];?> <?php echo $this->time_manager->getUserTimeFromGMTTime($Contactdetail['createdDate'], $this->config->item('date_format'));?> </div>
          </div>
        </div>
        <div class=" lblTagName"     > </div>
      </div>
      <div id="0notes" class="<?php echo $seedBgColor;?>" style="width: 100%;float:left;display:none;">
        <?php 
						$firstSuccessor = 0;
					?>
        <form name="form10" method="post" action="" >
          <textarea name="replyDiscussion0" id="replyDiscussion0"></textarea>
		  <div id="loader"></div>
          <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Done');?>" onClick="validate_dis('replyDiscussion0',document.form10,'<?php echo base_url();?>contact/addMyNotes/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>','<?php echo $nodeOrder;?>');" class="button01">
          
          <input style="float:left;" type="reset" name="Replybutton1" value="Cancel" onClick="reply_close(0);" class="button01">
		  
          <input name="editorname1" type="hidden"  value="replyDiscussion0">
          <input name="reply" type="hidden" id="reply" value="1">
          <input name="nodeOrder" type="hidden" id="reply" value="<?php echo $nodeOrder;?>">
		  
		   <div id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>
		  
        </form>
		
      </div>
      <div class="divLinkFrame" >
        <div id="linkIframeId0"    style="display:none;"></div>
      </div>
      <span id="spanArtifactLinks0" style="display:none;"></span>
      <?php
		
				#********************************************* Tags ********************************************************88
				
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;	
				?>
      <div id="spanTagView0" style="display:none;">
        <div id="spanTagViewInner0">
          <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; ">
            <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}					
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
				
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				
				
				?>
          </div>
        </div>
        <div class="divTagsButton" style="width:auto" >
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(0)" />
          <span id="spanTagNew0">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(0,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" />
          </span> </div>
      </div>
      <?php	
				#*********************************************** Tags ********************************************************																		
				?>
      <div class="clr"></div>
    </div>
	
	<div id="loader0"></div>
	
    <?php
$this->load->helper('form'); 
$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('', $attributes);
?>
    <div id="contact_list_update">
      <?php 
		$focusId = 3;
		$totalNodes = array();

		$rowColor1='row1';
		$rowColor2='row2';	
		$i = 1;

		if(count($ContactNotes) > 0)
		{
          
			$count=0;

			foreach($ContactNotes as $keyVal=>$arrVal)
			{	 
				$userDetails1	= 	$this->contact_list->getUserDetailsByUserId($arrVal['userId']);		
				$nodeOrder++;
	
				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($arrVal['nodeId']);
				$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);	
	
				if ($arrVal['nodeId'] == $this->uri->segment(8)|| $arrVal['nodeId'] == $this->input->get('node'))
					$nodeBgColor = 'nodeBgColorSelect';
				else
					$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
	
				$totalNodes[] = $arrVal['nodeId'];

		?>
      <div class="clr"></div>
      <div  onclick="clickNodesOptions('<?php echo $arrVal['nodeId']; ?>')" onmouseout="hideNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>')"  onmouseover="showNotesNodeOptions('<?php echo $arrVal['nodeId']; ?>');" class="<?php echo $nodeBgColor; ?> handCursor"  id="contactLeafContent<?php echo $arrVal['nodeId']; ?>">
        <div style="height:30px; padding-bottom:0px;" >
          <ul id="ulNodesHeader<?php echo $arrVal['nodeId']; ?>" style="float:right; display:none" class="content-list ulNodesHeader">
            <?php
					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $arrVal['nodeId'], 2);
					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $arrVal['nodeId'], 2);	
					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 1, 2);
					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 2, 2);
					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 3, 2);
					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 4, 2);
					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 5, 2);
					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($arrVal['nodeId'], 6, 2);
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($arrVal['nodeId'], 2);
					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($arrVal['nodeId'], 2);		
				
						
					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);
					if($total==0)
					{
						$total='';
						$tag_container=$this->lang->line('txt_None');
					}
					else
					{
						
						     if(count($viewTags)>0)
							 {
								$tag_container=$this->lang->line('txt_Simple_Tag').' : ';
								foreach($viewTags as $simpleTag)
								$tag_container.=$simpleTag['tagName'].", ";
								$tag_container=substr($tag_container, 0, -2)."
"; 
							 
							}
							
												
							if(count($actTags) > 0)
								{
								   $tag_container.=$this->lang->line('txt_Response_Tag').' : ';
									$tagAvlStatus = 1;	
									foreach($actTags as $tagData)
									{	$dispResponseTags='';
										$dispResponseTags = $tagData['comments']."[";							
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if(!$response)
										{  
											
											if ($tagData['tag']==1)
												$dispResponseTags .= $this->lang->line('txt_ToDo');									
											if ($tagData['tag']==2)
												$dispResponseTags .= $this->lang->line('txt_Select');	
											if ($tagData['tag']==3)
												$dispResponseTags .= $this->lang->line('txt_Vote');
											if ($tagData['tag']==4)
												$dispResponseTags .= $this->lang->line('txt_Authorize');															
										}
										$dispResponseTags .= "], ";	
															
										
										
										$tag_container.=$dispResponseTags;
									}
									
									$tag_container=substr($tag_container, 0, -2)."
"; 
								}
								
								
								if(count($contactTags) > 0)
									{
										$tag_container=$this->lang->line('txt_Contact_Tag').' : ';
										$tagAvlStatus = 1;	
										foreach($contactTags as $tagData)
										{
											
											$tag_container .= strip_tags($tagData['contactName'],'').", ";	
											
										}
										
										$tag_container=substr($tag_container, 0, -2); 
									}		
							
					}
						

				?>
            <li><a id="liTag<?php echo $arrVal['nodeId']; ?>" class="tag" onclick="showPopWin('<?php  echo base_url();?>add_tag/index/<?php echo  $workSpaceId ; ?>/<?php echo  $workSpaceType ; ?>/<?php echo $arrVal['nodeId'] ; ?>/2/1', 710, 500, null, '');" href="javascript:void(0);" title="<?php echo strip_tags($tag_container,''); ?>"  ><strong><?php echo $total; ?></strong></a></li>
            <?php				
						
					
					
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees7);
				
				$appliedLinks=' ';
				
				if($total==0)
					{
						$total='';
						$appliedLinks=$this->lang->line('txt_None') ;
					}
					else
					{
						 
						   
						   if(count($docTrees1)>0)
						   {
							   $appliedLinks .= $this->lang->line('txt_Document').': ';
							   foreach($docTrees1 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							
							 if(count($docTrees3)>0)
						   {
								$appliedLinks.=$this->lang->line('txt_Chat').': ';	
								foreach($docTrees3 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees4)>0)
							{
							
								$appliedLinks.=$this->lang->line('txt_Task').': ';	
								foreach($docTrees4 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							if(count($docTrees6)>0)
							{
								$appliedLinks.=$this->lang->line('txt_Notes').': ';	
								foreach($docTrees6 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}
							
							if(count($docTrees5)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	
								foreach($docTrees5 as $key=>$linkData)
							   {
									 $appliedLinks.=$linkData['name'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}
							
							if(count($docTrees7)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
									 
								$appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	
								foreach($docTrees7 as $key=>$linkData)
							   {
							         
									 if($linkData['docName']=='')
									 {
									    $appliedLinks.=$this->lang->line('txt_Imported_Files')."_v".$linkData['version'].", ";
									 }
									 else
									 {
									 	$appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 }
									
								}
							
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							}	
							
							 if(count($docTrees9	)>0)
									{
									
										$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
										foreach($docTrees9 as $key=>$linkData)
									   {
											 $appliedLinks.=$linkData['title'].", ";
											
										}
										$appliedLinks=substr($appliedLinks, 0, -2);
									
									}
						
					}
					
					?>
            <li  ><a id="liLink<?php echo $arrVal['nodeId']; ?>" class="link disblock" onclick="showPopWin('<?php echo base_url(); ?>show_artifact_links/index/<?php echo $arrVal['nodeId']; ?>/2/<?php echo $workSpaceId; ?>/<?php echo  $workSpaceType; ?>/2/1/1', 680, 380, null, '');" alt="<?php echo $this->lang->line("txt_Links"); ?>" title="<?php echo strip_tags($appliedLinks); ?>" border="0" ><strong><?php echo $total; ?></strong></a></li>
            <?php
				
				    $total=$this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
					$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);
					if(strip_tags($talk[0]->contents))
					{
						$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
						$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
					}
					else
					{
						$latestTalk='Talk';
					}
					if($total==0)
					{
						$total='';
					}
							
					echo ' <li  class="talk"><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') " title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
					
					$lastnode=$arrVal['nodeId'];


					?>
          </ul>
        </div>
        <div class="clr"></div>
        <div  >
          <div onClick="showNotesNodeOptions(<?php echo $arrVal['nodeId'];?>);"  >
            <div  class="autoNumberContainer"  >
              <p>
                <?php if ($treeDetail['autonumbering']==1) { echo "# ".$i; }?>
              </p>
            </div>
            <div id='leaf_contents<?php echo $arrVal['nodeId'];?>'   class="contentContainer <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>" ><?php echo stripslashes($arrVal['contents']); ?></div>
          </div>
          <div class="clr"></div>
          <div style="height:30px;" >
            <div class=" lblNotesDetails normalView"  id="normalView<?php echo $arrVal['nodeId'];?>"  style="display:none; width:100%; margin:3%; padding: 4% 0%;"    >
              <div class="style2" style="width:75%; text-align:left; "  >
			  <div> 
			  <?php 
			    echo $userDetails1['userTagName'];
				if(strlen($userDetails1['userTagName'])>16)
		  		{
			?>
				</div>
				<div style="margin-top: 5px;">
                <?php 
					}
				if($arrVal['editedDate'][0]==0)
				{
				
						//Start Manoj: Remove date suffix and current year
							 
							 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format'));
							 $Create_date = explode(' ',$Create_date);
							 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
							 $current_year = date("y");
							 if($current_year == $Create_date[2])
							 {
								$Create_date[2]=" ";
							 }
							 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
							 
						//End Manoj: Remove date suffix
					
					//echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['createdDate'], $this->config->item('date_format'));
				}
				else
				{
						//Start Manoj: Remove date suffix and current year
							 
							 $Create_date=$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
							 $Create_date = explode(' ',$Create_date);
							 $date = preg_replace("/[^0-9,.]/", "", $Create_date[0]);
							 $current_year = date("y");
							 if($current_year == $Create_date[2])
							 {
								$Create_date[2]=" ";
							 }
							 echo ' '.$date.' '.$Create_date[1].' '.$Create_date[2].' '.$Create_date[3];
							 
						//End Manoj: Remove date suffix
				    
					//echo '&nbsp;&nbsp;'.$this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format'));
				}
				?>
				
			 </div>
              </div>
              <!--/*Changed by Surbhi IV*/-->
              <?php 
					if($_SESSION['userId'] == $arrVal['userId'])
					{
				       
				?>
              <span style="width:20%;" class="editLeafMobile"><a href="javascript:editNotesContents1(<?php echo $position;?>,<?php echo $treeId;?>,<?php echo $arrVal['nodeId']; ?>,<?php echo $arrVal['successors']; ?>);"  style="margin-right:25px;" ><img src="<?php echo base_url(); ?>images/editnew.png" alt="<?php echo $this->lang->line("txt_View_Details"); ?>" title="<?php echo  $this->lang->line("txt_View_Details"); ?>" border="0"></a></span>
              <?php
				
					}
				?>
              <!--/*End of Changed by Surbhi IV*/--> 
              
            </div>
          </div>
          <?php
				#******************************* * * * * * * * * * * * * * * Tags * * * * * * * * ************************************************88
							
				$dispViewTags = '';
				$dispResponseTags = '';
				$dispContactTags = '';
				$dispUserTags = '';
				$nodeTagStatus = 0;
				?>
          <div class="divLinkFrame">
            <div id="linkIframeId<?php echo $arrVal['nodeId']; ?>"    style="display:none;"></div>
          </div>
          <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
          <div class="commonDiv">
            <?php	
				$tagAvlStatus = 0;				
				if(count($viewTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
				}
							
				if(count($contactTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
				}
				if(count($userTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($userTags as $tagData)
					{
						$dispUserTags .= $tagData['userTagName'].', ';						
					}
				}
				if(count($actTags) > 0)
				{
					$tagAvlStatus = 1;	
					foreach($actTags as $tagData)
					{
						$dispResponseTags .= $tagData['comments'].' [';							
						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
						if(!$response)
						{
						
							if ($tagData['tag']==1)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_ToDo').'</a>,  ';									
							if ($tagData['tag']==2)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Select').'</a>,  ';	
							if ($tagData['tag']==3)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Vote').'</a>,  ';
							if ($tagData['tag']==4)
								$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',2,'.$tagData['tagId'].',2,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_Authorize').'</a>,  ';							
						}
						$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag('.$arrVal['nodeId'].','.$workSpaceId.','.$workSpaceType.','.$arrVal['nodeId'].',3,'.$tagData['tagId'].',3,'.$arrVal['nodeId'].')">'.$this->lang->line('txt_View_Responses').'</a>';	
						
						$dispResponseTags .= '], ';
					}
				}
				
					?>
            <div id="divSimpleTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispViewTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >
              <?php
					echo $this->lang->line('txt_Simple_Tags').': <span id= "simpleTags'.$arrVal['nodeId'].'">'.substr($dispViewTags, 0, strlen( $dispViewTags )-2).'</span><br>';				
					$nodeTagStatus = 1;		
					?>
            </div>
            <?php				
						
					//Response tag container	
					?>
            <div id="divResponseTags<?php echo $arrVal['nodeId'] ; ?>" <?php if($dispResponseTags!=''){ echo 'style="display:block"';} else { echo'style="display:none"' ; } ?> >
              <?php
					
					echo $this->lang->line('txt_Response_Tags').':<span id= "responseTags'.$arrVal['nodeId'].'"> '.substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'</span><br>';			
					$nodeTagStatus = 1;
					?>
            </div>
            <?php	
					
					//Contact Tag container
					?>
            <div id="divContactTags<?php echo $arrVal['nodeId']; ?>" <?php if($dispContactTags!=''){ echo 'style="display:block"'; } else { echo'style="display:none"' ; } ?> >
              <?php
					echo $this->lang->line('txt_Contact_Tags').':<span id= "contactTags'.$arrVal['nodeId'].'"> '.substr($dispContactTags, 0, strlen( $dispContactTags )-2).'</span><br>';
					$nodeTagStatus = 1;	
					?>
            </div>
            <?php	
					
				if($dispUserTags != '')		
				{
					?>
            <div>
              <?php
					echo $this->lang->line('txt_User_Tags').': '.substr($dispUserTags, 0, strlen( $dispUserTags )-2).'<br>';
					$nodeTagStatus = 1;			
					?>
            </div>
            <?php		
				}	
							
				if($nodeTagStatus == 0)	
				{
				?>
            <div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>
            <?php
				}
				?>
          </div>
          </span>
          <div class="commonDiv">
            <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(<?php echo $arrVal['nodeId'];?>)" />
            <span id="spanTagNew<?php echo $arrVal['nodeId'];?>">
            <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $arrVal['nodeId']; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $arrVal['nodeId']; ?>,2,0,1,<?php echo $arrVal['nodeId']; ?>)" />
            </span> </div>
          <div class="commonDiv">
            <div id="iframeId<?php  echo $arrVal['nodeId'];?>"    style="display:none;"></div>
          </div>
          </span>
          <?php	
				#*********************************************** Tags ********************************************************																		
				?>
          <div class="clr"></div>
        </div>
        <div id="initialContent<?php echo $arrVal['nodeId'];?>" style="display:none" ><?php echo $arrVal['contents'];?>
          <input type="hidden" id="leafContent_<?php echo $arrVal['nodeId'];  ?>" value="<?php echo $arrVal['contents']; ?>"  />
        </div>
        <?php /*?><div id="<?php echo $position;?>edit_contacts" style=" <?php //width: echo $this->config->item('page_width')-50; px; ?> float:left; display:none;"> </div><?php */?>
        <div class="clr"></div>
      </div>
	   <!--Manoj: edit leaf content-->
	<div class="<?php echo $nodeBgColor; ?> handCursor">
	  <div id="<?php echo $position;?>edit_contacts"  style="width:100%; float:left; display:none;"> </div>
	  </div>
	  
	  <div id="loader<?php echo $arrVal['nodeId']; ?>"></div>
	  
      <?php  
		$position++;
		$focusId = $focusId+2;	
		$i++;
		} 
	}
	?>
      <input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
      <input type="hidden" name="curLeaf" value="0" id="curLeaf">
      <input type="hidden" name="editStatus" value="0" id="editStatus">
      <input type="hidden" name="curContent" value="0" id="curContent">
      <input type="hidden" name="editorname1" value="0" id="editorname1">
      <input type="hidden" name="reply" value="1" id="reply">
      <input type="hidden" name="nodeId" value="" id="nodeId">
    </div>
    </form>
  </div>
</div>
<?php $this->load->view('common/foot_for_mobile');?>
<?php $this->load->view('common/footer_for_mobile');?>
</body>
</html>

<!--Manoj: Added script for view contact details for mobile-->
<script type="text/javascript" src="<?php echo base_url();?>js/contact/contact.js"></script>
<script language="javascript">

	//showOnlineUsers( <?php echo $workSpaceId;?>, <?php echo $workSpaceType;?>, 'userExtendLinks' );
	function displayname(){
		/*if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__'){
			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;
		}*/
		document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;	
	}
	function validate(){
		
		var error='';
		var emailTest = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z]+)*\.[A-Za-z]+$/;
		var phoneno = /^(?=.*?[1-9])[0-9()+-]+$/;
		if(document.getElementById('company_name').value==''){
			error+='<?php echo $this->lang->line('req_company_name'); ?>\n';
		}		
		if(document.getElementById('first_name').value==''){
			error+='<?php echo $this->lang->line('req_first_name'); ?>\n';
		}
		if(document.getElementById('last_name').value==''){
			error+='<?php echo $this->lang->line('req_last_name'); ?>\n';
		}
		if(document.getElementById('display_name').value==''){
			error+='<?php echo $this->lang->line('req_tag_name'); ?>\n';
		}
		if (document.getElementById('email').value!='')
		{
			if(emailTest.test(document.getElementById('email').value.trim())==false){
				error+="Please enter valid email\n";
			}		
		}
		if (document.getElementById('fax').value!='')
		{
				 if(!(document.getElementById('fax').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid fax number\n";     
				 }
		} 
		if (document.getElementById('mobile').value!='')
		{ 
				 if(!(document.getElementById('mobile').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid phone number\n";     
				 }
		} 
		if (document.getElementById('landlineno').value!='')
		{
				 if(!(document.getElementById('landlineno').value.trim().match(phoneno)))  
				 {  
				   error+="Please enter valid mobile number\n";     
				 } 
		}
		if(error){
			alert(error);
			return false;
		}else{
			return true;
		}
	}
	function reply(id,focusId)
	{
		document.getElementById('loader'+id).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		var divid=id+'notes';
		document.getElementById(divid).style.display='';
		document.getElementById('loader'+id).innerHTML =" ";
	}
	function reply_close(id){
		divid=id+'notes';

		setValueIntoEditor('replyDiscussion0','');
 		document.getElementById(divid).style.display='none';
	}
	function editNotesContents(id,focusId)
	{
		var divid=id+'edit_notes';

		document.getElementById(divid).style.display='';
	}
	var nodeId1	;
	var treeId1;
	var workSpaceId1;
	var workSpaceType1;
	var id1; 
	
	function editNotesContents1(position,treeId,nodeId,successors)
	{
		
	   updateLeafContents(nodeId,treeId);
	   
	    if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=5";
					$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							
							//alert(result);
							
							result = result.split("|||");
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else
							{
	  
	   if(document.getElementById('editStatus').value == 1)
		{
			jAlert('<?php echo $this->lang->line('save_cancel_current_leaf'); ?>');
			
			//updateLeafContents(nodeId,treeId);
			
		}
		else
		{
		
			document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
		
			var divid=position+'edit_contacts';
			document.getElementById(divid).style.display='';
			document.form2.editStatus.value = 1;
			contents=document.getElementById("leafContent_"+nodeId).value; 	
			 workSpaceId1=workSpaceId;
			 workSpaceType1=workSpaceType;
			 treeId1=treeId;
			 nodeId1=nodeId;
			 id1=position;
			 
			 if(document.getElementById('editorLeafContents'+id1+'1')){
				 document.getElementById('editorLeafContents'+id1+'1').value=contents;
			 }
			 else{
				 editor_code(contents,'editorLeafContents'+id1+'1',id1+'edit_contacts');
			 }
			
			 //document.getElementById('editorLeafContents'+id1+'1sp').innerHTML='<table width="8%" border="0" align="left" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="validate_dis1(\'editorLeafContents'+id1+'1\',document.form2)"><input type="button"  class="button01" value="<?php  echo  $this->lang->line("txt_Done"); ?>"   /></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="edit_close_1('+id1+','+nodeId+')"><input type="button"  class="button01" value="<?php  echo  $this->lang->line("txt_Cancel"); ?>"   /></a></td></tr></table><div style="clear:both;"></div><div id="audioRecordBox"><div style="float:left;margin-top:0.7%;margin-left:3px;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'+id1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+id1+'" style="display:none; margin-left:2%; margin-top:0.4%; float:left;"></div></div>';
			 
			 document.getElementById('editorLeafContents'+id1+'1sp').innerHTML='<div><div id="loaderImage"></div><a href="javascript:void(0)" onclick="validate_dis1(\'editorLeafContents'+id1+'1\',document.form2)"><input style="float:left;" type="button"  class="button01" value="<?php  echo  $this->lang->line("txt_Done"); ?>"   /></a><a href="javascript:void(0)" onclick="edit_close_1('+id1+','+nodeId+')"><input style="float:left;" type="button"  class="button01" value="<?php  echo  $this->lang->line("txt_Cancel"); ?>"   /></a><span id="audioRecordBox"><div style="float:left;margin-top:5px;margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(3,'+id1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+id1+'" style="display:none; margin-left:2%; margin-top:0%; float:left;"></div></span></div>';
			 			 
			 chnage_textarea_to_editor('editorLeafContents'+id1+'1');
			 
			 document.getElementById('loader'+nodeId).innerHTML =" ";
			 
			 //Manoj: froala editor hide content on edit contact leaf
			 document.getElementById('contactLeafContent'+nodeId).style.display="none";
		  }		
		  } //else end
		} //success end
		});	
	}	
	
	function showNotesNodeOptions_remove(position)
	{	
		var notesId = 'normalView'+position;	
		if(position > 0)
		{
			document.getElementById('normalView0').style.display = "none";
		}	
		if(document.getElementById(notesId).style.display == "none")
		{			
			document.getElementById(notesId).style.display = "";
		}
		else
		{
			document.getElementById(notesId).style.display = "none";
		}
		var totalNodes = document.getElementById('totalNodes').value;
		var nodesArray = totalNodes.split(",");
		
		for(var i=0; i<nodesArray.length; i++)
		{
			if(nodesArray[i] != position)
			{
				notesId = 'normalView'+nodesArray[i];	
				document.getElementById(notesId).style.display = "none";
			}
	
		}
	}

	function validate_dis(replyDiscussion,formname,url,nodeOrder){
		var error='';
		var getVal=getvaluefromEditor('replyDiscussion0');
		
	
		if(getVal == ''){
			error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';
		}
		if(error=='')
		{
			$("#loader").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		
			/*Added by Surbhi IV for checking content */
			var request1 = $.ajax({
				  url: url,
				  type: "POST",
				  data: 'editorname1=replyDiscussion0&reply=1&nodeOrder='+nodeOrder+'&replyDiscussion0='+encodeURIComponent(getVal),
				  dataType: "html",
				  success:function(result)
				  {
					  divid='0notes';
					  $("#loader").html("");
					  document.getElementById(divid).style.display='none';
					  $('#contact_list_update').html(result);
					  
					  $('#replyDiscussion0').val('');
					  //chnage_textarea_to_editor('replyDiscussion0');
					  setValueIntoEditor("replyDiscussion0","");
					  
					  chnage_textarea_to_editor('replyDiscussion0');
					  
					  return false;
				  }
			});
			/*End of Added by Surbhi IV*/
		}else{
			jAlert(error);
		}	
	}

	function validate_dis1(replyDiscussion,formname){
		var error='';
		var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');
		
		var getvalue	= getvaluefromEditor(INSTANCE_NAME);
		
		if(getvalue == ''){
			error+='<?php echo $this->lang->line('msg_enter_note');?>.\n';
		}
		if(error==''){  
		
		$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
	
			var request1 = $.ajax({
				  url: '<?php echo base_url().'contact/editNotesContents/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType; ?>',
				  type: "POST",
				  data: 'reply=1&editStatus=0&nodeId='+nodeId1+'&editorname1='+replyDiscussion+'&'+replyDiscussion+'='+encodeURIComponent(getvalue),
				  dataType: "html",
				  success:function(result)
				  { 
					$('#contact_list_update').html(result);
					var divId=id1+'edit_contacts';
					document.getElementById(divId).style.display='none';
					
					//Manoj: froala editor show note leaf content on cancel
	
					document.getElementById('contactLeafContent'+leafId).style.display="block";
					
					return false;
				  }
			});
	
			/*End of Added by Surbhi IV*/
			
		}else{
			jAlert(error);
		}	
	}
	
	// Parv - Keep Checking for tree updates every 5 second
	<!--Updated by Surbhi IV--> 
	
	//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 10000);	
	
	//Add SetTimeOut 
	setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,'','')", 20000);
	
	<!--End of Updated by Surbhi IV-->
</script>
<script language="javascript">
	//Manoj: add version simple
	chnage_textarea_to_editor('replyDiscussion0');
	//chnage_textarea_to_editor('comments','simple');
	//chnage_textarea_to_editor('other','simple');
</script>