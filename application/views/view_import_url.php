<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/style_new.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/modal-window.css" type="text/css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" />

<?php $this->load->view('editor/editor_js.php');?>

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

    

    <?php 	if ($_COOKIE['editor']==1 || $_COOKIE['editor']==3)

		{

	?>

		<script type="text/javascript" src="<?php echo base_url();?>teemeeditor/teemeeditor.js"></script>

	<?php

		}         

	?>

    

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

    

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>

	

	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>

	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>

	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script> 

	

	

    <script type="text/javascript">



function edit_action_tag(workSpaceId,workSpaceType,artifactId,artifactType,sequenceTagId,tagOption,tagId)

{

	

		var xmlHttpRequest = GetXmlHttpObject2();

		urlm=baseUrl+'add_tag/editActionTag/'+workSpaceId+'/'+workSpaceType+'/'+artifactId+'/'+artifactType+'/'+sequenceTagId+'/'+tagOption+'/'+tagId;	 

		var iframeId='iframeId0';

		var liTag='liTag';

		if(artifactType==2)

		{

		  	iframeId="iframeId"+artifactId;

			

			liTag='liTag'+artifactId;

			

		}

		xmlHttpRequest.open("POST", urlm, true);

		 

		xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		

		xmlHttpRequest.onreadystatechange = function()

		{

			if (xmlHttpRequest.readyState==4 && xmlHttpRequest.status==200)

			{

				  

				 document.getElementById("divActionTagContainer").innerHTML=xmlHttpRequest.responseText;

						

			}

		}     

		xmlHttpRequest.send(); 

	}





		</script>

		

		

	</head>

	<body>

	

	<div class="boxtext">

			<div class="menu_new h2_class">

			

			

			<ul class="tab_tag_link">

			<li  id="tabTagsList" class="tabs_tags_select">

			<a   href="javaScript:void(0)" onclick="showHideTagsView('')" ><?php echo $this->lang->line('txt_Tags');?></a>&nbsp;&nbsp;

			</li>

			<li  id="tabTagsSet" class="tabs_tags">

			<a href="javaScript:void(0)" onclick="showHideTagsView('add')" ><img src="<?php echo  base_url(); ?>images/addnew.png"  title="add new tag" border="0" ></a>

			</li>

			</ul>

			

			</div>

			<div class="clr" ></div>

			</div>

		

			<ul class="navigation" id="tagsNavigation" style="display:none;  padding-left:5px;" >                  

					<li style="margin-right:25px;"  ><input type="radio" id="2"  name="groupTags"  <?php if($tagOption == 2) { ?>checked="checked" <?php } ?> onclick="getTagView(2)" ><span><?php echo $this->lang->line('txt_Simple');?></span></li>

					

					<li style="margin-right:25px;"   ><input type="radio" id="3" name="groupTags"  <?php if($tagOption == 3) { ?>checked="checked" <?php } ?> onclick="getTagView(3)"  /><span><?php echo $this->lang->line('txt_Response');?></span></li>

					

					<li style="margin-right:25px;"   ><input type="radio" id="5" name="groupTags"  <?php if($tagOption == 5) { ?>checked="checked" <?php } ?> onclick="getTagView(5)" /><span><?php echo $this->lang->line('txt_Contact');?></span></li>

		</ul>

		<br/>

			

			<div id="divAllTags">

				

						<div id="tags_container" class="slider-content" style="padding: 0px 10px 0px 10px" >
						 <?php

						 

			

			if((count($viewTags)+count($actTags)+count($contactTags)+count($userTags))>0)

			{			 

						       

		$tag_container='Simple Tag : <span>';

		

		 foreach($viewTags as $simpleTag)

		 $tag_container.=$simpleTag['tagName'].", ";

		 

		 $tag_container.='</span><br/>Action Tag : <span>';

							

		if(count($actTags) > 0)

			{

				$tagAvlStatus = 1;	

				foreach($actTags as $tagData)

				{	$dispResponseTags='';

					$dispResponseTags = $tagData['comments'].' [';							

					$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

					if(!$response)

					{  

						

						if ($tagData['tag']==1)

							$dispResponseTags .= '<a href="javascript:void(0)"  onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									

						if ($tagData['tag']==2)

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	

						if ($tagData['tag']==3)

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';

						if ($tagData['tag']==4)

							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															

					}

					$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTagResponse(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	

										

					$dispResponseTags .= '], ';

					

					$tag_container.=$dispResponseTags;

				}

			}

			

			$tag_container.='</span><br/><div id="actionTagResponse"></div>Contact Tag : <span>';

			if(count($contactTags) > 0)

				{

					$tagAvlStatus = 1;	

					foreach($contactTags as $tagData)

					{

						//$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';	

						

						$tag_container .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';	

						

													

					}

				}		

		 $tag_container.='</span><br>';

		 

		

		 

		 }

		 else

		 {

		      $tag_container.=$this->lang->line('txt_None');

		 }

			echo  $tag_container;					

						?>		


						</div>

			</div>

			

	<div id="allTagViews" style="padding:0px 5px 0px 5px;">

			

<!-- ------------------ Simple tags starts here-------------------------- -->		



			<div id="divSimpleView" style="display:none">

				

				<div class="clr"></div>

				<div class="slider-content">

				<div id="simpleTagMessage"  style="height:25px; padding-left:5px;" ></div>

				<?php

				

				   // $artifactId=$this->uri->segment(5);

			     	//$artifactType=$this->uri->segment(6);

					

					$tags = $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);

					$arrTagDetails['tags'] = $tags;

							

					$lastLogin = $this->identity_db_manager->getLastLogin();

					$currentTags = $this->tag_db_manager->getCurrentTags(2, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);

					$arrTagDetails['currentTags'] = $currentTags;

					

					$arrTagDetails['treeId'] = $treeId;

					

					//This session uses to  show tag in simple tage view

					$_SESSION['artifactId'] = $artifactId;

					$_SESSION['artifactType'] = $artifactType;

					

					$arrTagDetails['createUrl'] = $createUrl;

					//echo "addnew= " .$addNewOption; exit;

					if($addNewOption == 1)

					{	

					   $this->load->view('common/tags/view_tag2', $arrTagDetails); 

					}	

					else

					{	

						$this->load->view('common/tags/add_view_tag', $arrTagDetails); 

					}

					

					

				?>					

				</div>

			</div>

			

<!-- simple tags closes here ------------------------------------>			

			

			

			<div id="divActionView"  style="display:none">

			

				<div class="clr"></div>

				<div class="slider-content" id="divActionTagContainer" >

				<div id='ActionMessage' style="height:25px;" ></div>

				<?php

				   

					$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);

								

					$arrTagDetails['tags'] = $tags;						

								

					$lastLogin = $this->identity_db_manager->getLastLogin();

					$currentTags = $this->tag_db_manager->getCurrentTags(3, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);

					$arrTagDetails['currentTags'] = $currentTags;

					$arrTagDetails['tagOption'] = 3;

							

					$arrTagDetails['createUrl'] = $createUrl;

					

						if ($artifactType==2) // if leaf

						{

							$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity ($artifactId);

						}

						else //if tree

						{

							$treeId = $artifactId;

						}

					$arrTagDetails['sharedMembers'] = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	

							

							//echo "<li>wp_member= ";

							//print_r ($workSpaceMembers);

							

							if ($tagId)

							{

								//$arrTagDetails['tagId'] = $tagId;

								//$tags = $this->tag_db_manager->getTagsByTagId ($tagId);

								$arrTagDetails['editTagId'] = $tagId;

								

								

								

								

								//echo "count= " .count($tags); exit;

							}

							$arrTagDetails['treeId']=$treeId;

							//echo "addnew= " .$addNewOption;

							if($addNewOption == 1)

							{	

								$this->load->view('common/tags/act_tag', $arrTagDetails);  

							}	

							else if($addNewOption == 3)

							{	

								$arrTagDetails['tagId'] = $this->uri->segment(10);	

								$this->load->view('common/tags/act_response', $arrTagDetails); 

							}			

							else

							{	

								$this->load->view('common/tags/add_act_tag', $arrTagDetails); 

							}	

							

						

							?>

				

				</div>

			</div>

			

			

			

<!-- Action tag closes here - -->	

	

            <div id="divContactView" style="display:none">

			<div class="clr"></div>

			<div class="slider-content">

			 

					

					<div id='contactMessage' style="height:25px;" ></div>

							

							 <?php

							$tags = $this->tag_db_manager->getTags(5, $_SESSION['userId'], $artifactId, $artifactType);

							$arrTagDetails['tags'] = $tags;

							$arrTagDetails['treeId'] = $treeId;

							

							$lastLogin = $this->identity_db_manager->getLastLogin();

							$currentTags = $this->tag_db_manager->getCurrentTags(5, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);

							$arrTagDetails['currentTags'] = $currentTags;

							

							$arrTagDetails['tagOption']=5;

							

							if($addNewOption == 1)

							{	

								//$this->load->view('common/contact_tag', $arrTagDetails); 

								$this->load->view('common/tags/add_contact_tag', $arrTagDetails); 

							}	

							else

							{	

								$this->load->view('common/tags/add_contact_tag', $arrTagDetails); 

							}	

																		

							

				?>

					</div>

					

			</div>

			</div>

		</div>

		

	</body>

</html>

