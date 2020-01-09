<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Dashboard</title>
	<?php $this->load->view('common/view_head'); ?>
	<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';	
		

function showHideDashBoard(className)
{
	var divsToHide = document.getElementsByClassName(className);
	
	for(var i = 0; i < divsToHide.length; i++)
    {
		if (divsToHide[i].style.display=='block')
		{
    		divsToHide[i].style.display='none';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = 'See all.....';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = 'See all.....';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = 'See all.....';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = 'See all.....';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = 'See all.....';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = 'See all.....';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = 'See all.....';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = 'See all.....';
				}								
		}
		else
		{
			divsToHide[i].style.display='block';
				if (className=='dashboard_content_more_trees')
				{
					document.getElementById('more_trees').innerHTML = 'See less.....';
    			}
				if (className=='dashboard_content_more_talks')
				{
					document.getElementById('more_talks').innerHTML = 'See less.....';
				}
				if (className=='dashboard_content_more_links')
				{
					document.getElementById('more_links').innerHTML = 'See less.....';
				}	
				if (className=='dashboard_content_more_tags')
				{
					document.getElementById('more_tags').innerHTML = 'See less.....';
				}	
				if (className=='dashboard_content_more_tasks')
				{
					document.getElementById('more_tasks').innerHTML = 'See less.....';
				}				
				if (className=='dashboard_content_more_messages')
				{
					document.getElementById('more_messages').innerHTML = 'See less.....';
				}	
				if (className=='dashboard_content_more_files')
				{
					document.getElementById('more_files').innerHTML = 'See less.....';
				}	
				if (className=='dashboard_content_more_users')
				{
					document.getElementById('more_users').innerHTML = 'See less.....';
				}								
		}
		
	}
}
	</script>
</head>
<body>
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
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
			
			$this->load->view('common/artifact_tabs', $details);

	?>
  </div>
</div>
<div id="container">
<div id="content">
    <?php 
	if(isset($_SESSION['errorMsg']) &&  $_SESSION['errorMsg']!='' )
	{ 
	?>
		<div class="error">
		<?php if(isset($_SESSION['errorMsg'])) { echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] =''; }?>
		</div>
    <?php 
	} 
	?>
<div><h1>Dashboard<span style="float:right;"><img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location="<?php echo base_url()?>dashboard/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"' style="cursor:pointer" ></span></h1></div>
<div class="clr"></div>

<div class="dashboard_row" style="width:100%;">
	<div class="dashboard_col" style="float:left;width:50%">
		<!-- Updated trees start -->
		<div class="dashboard_wrap">
		<?php
			if(count($arrDocuments) > 0)
			{
							$count = 0 ;
							foreach($arrDocuments as $keyVal=>$arrVal)
							{
							
								if ($arrVal['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
								}
								if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
								{
									$count++;
								}
							}	
			}	
		?>
		
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_document_sel15.png alt='<?php echo $this->lang->line('txt_Document'); ?>' title='<?php echo $this->lang->line('txt_Document');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_discuss_sel15.png alt='<?php echo $this->lang->line('txt_Discuss'); ?>' title='<?php echo $this->lang->line('txt_Discuss');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_task_sel15.png alt='<?php echo $this->lang->line('txt_Task'); ?>' title='<?php echo $this->lang->line('txt_Task');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_notes_sel15.png alt='<?php echo $this->lang->line('txt_Notes'); ?>' title='<?php echo $this->lang->line('txt_Notes');?>' border=0> <img src=<?php echo base_url(); ?>images/icon_contact_sel15.png alt='<?php echo $this->lang->line('txt_Contact'); ?>' title='<?php echo $this->lang->line('txt_Contact');?>' border=0> <?php echo $this->lang->line('txt_Trees');?> </span> 
		<?php 
		if ($count > 5)
		{
		?>
			<span><a id="more_trees" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_trees');">See all.....</a></span>
		<?php
		}
		?>
			<div class="clr"></div>
			<div style="margin-top:10px;" >
				  <?php
						if(count($arrDocuments) > 0)
						{	
/*							$count = 0 ;
							foreach($arrDocuments as $keyVal=>$arrVal)
							{
							
								if ($arrVal['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
								}
								if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
								{
									$count++;
								}
							}*/
							if ($count!=0)
							{ 
							?>
							<div class="clr"></div>
				  <?php
								//$rowColor1='row-active-middle1';
								//$rowColor2='row-active-middle2';
								$i = 1;	
								
						
				foreach($arrDocuments as $keyVal=>$arrVal)
				{
					  /* Added by Surbhi IV*/
					  $arrUser= $this->identity_db_manager->getUserDetailsByUserId($arrVal['userId']);
					  /*End of Added by Surbhi IV*/
						if ($arrVal['isShared']==1)
						{
							$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($keyVal);	
						}	
						if ((($arrVal['isShared']==1) && (in_array($_SESSION['userId'],$sharedMembers))) || ($arrVal['isShared']==0) || ($arrVal['userId']==$_SESSION['userId']))	
						{
							$rowColor = ($i % 2) ? $rowColor1 : $rowColor2; 	
								//echo "<li>i= " .$i;
								if ($i<6)
								{
									$display='block';
									$class = 'dashboard_content_trees';
								} 
								else 
								{
									$display='none';
									$class = 'dashboard_content_more_trees';
								}
								?>
				<div class=<?php echo $class;?> style="margin:10px 0 10px; display:<?php echo $display;?>">
					<div>
							<?php
							if ($arrVal['isShared']==1)
							{
							?>
							<img src="<?php echo base_url();?>images/share.gif" alt="Shared" border="0"/>
							<?php
							
							 }
							?>
							<?php
							
							if ($arrVal['type']==1)
							{
								$href='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$keyVal.'&doc=exist';
								$txt_tree_type=$this->lang->line('txt_Document');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'" />';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==2)
							{
								
								$href='view_discussion/node/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Discussion');
								
							}
							if ($arrVal['type']==3)
							{
								if($arrVal['status']==1)
								{
									$href='view_chat/chat_view/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
									
								}
								else
								{
									$href='view_chat/node1/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								}
								$txt_tree_type=$this->lang->line('txt_Chat');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
									
							}
							if ($arrVal['type']==4)
							{
							
								$href='view_task/node/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Task');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==5)
							{
								//index
								$href='contact/contactDetails/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Contact');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
							if ($arrVal['type']==6)
							{
								//index
								$href='notes/Details/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$txt_tree_type=$this->lang->line('txt_Notes');
								/*Added by Surbhi IV*/
								$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$txt_tree_type.'"/>';
								/*End of Added by Surbhi IV*/
							}
				
							?>
						  <!--/*Added by Surbhi IV*/	--> 
						  <?php echo $icon; ?> 
						  <!--/*End of Added by Surbhi IV*/	--> 
						  <a href="<?php echo base_url().''.$href; ?>" title="<?php echo $this->identity_db_manager->formatContent($arrVal['name'],0,1);?>"><?php echo $this->identity_db_manager->formatContent($arrVal['name'],60,1); 			 
														if (!empty($arrVal['old_name']))
														{
															echo '<br>(<i>'.$this->lang->line("txt_Previous_Title").':</i> ' .$this->identity_db_manager->formatContent($arrVal['old_name'],60,1).')';
														}?> </a> 
					</div>
				<!--/* Added by Surbhi IV*/-->
				<div><span class="clsLabel"><?php  echo $this->lang->line('txt_Created_By').": ";?><?php echo $arrUser["firstName"]." ".$arrUser["lastName"];?></span> <span class="clsLabel"><?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></span></div>
				<div class="clr"></div>
				
			  </div>
				  <?php
									}
									
									$i++;
								}
								
								?>
				  </form>
				  	
				  <?php
							}
							else
							{	
							?>
				  <div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
				  <?php
							}
						}
						else
						{
						?>
				  <div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
				  <?php
						}	
						?>
				</div>
			</form>
		</div>	
		<!-- Updated trees end -->  	
	</div>
	<div class="dashboard_col" style="float:right;width:50%">
		<!-- Updated talks start -->
		<div class="dashboard_wrap">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/talk-view-sel.png alt='<?php echo $this->lang->line('txt_Talk'); ?>' title='<?php echo $this->lang->line('txt_Talk');?>' border=0> Talks</span> 
		<?php 
		if (count($arrTalks) > 5)
		{
		?>
			<span><a id="more_talks" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_talks');">See all.....</a></span>
		<?php
		}
		?>
				  <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
				<input type="hidden" name="page" value="" />
				<?php					
							if(count($arrTalks) > 0)
							{	
								$rowColor1='row-active-middle1';
								$rowColor2='row-active-middle2';
								$i = 1;
								
								if($this->input->post('treeType')=='')
								{
									echo '';			 
								}
								else
								{
									$count = 0;
									foreach($arrTalks as $treeId=>$data)
									{
										$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
				
										if ($treeType != '' && in_array($parentTreeType,$treeType))
											$count++;
									}				
									
			
								}
								
								foreach($arrTalks as $treeId=>$data)
								{	 
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($data['userId']);
									$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
									$treeName = $this->identity_db_manager->getTreeNameByTreeId ($data['parentTreeId']);
									
									$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
										if ($i<6)
										{
											$display='block';
											$class = 'dashboard_content_talks';
										} 
										else 
										{
											$display='none';
											$class = 'dashboard_content_more_talks';
										}
									
									if ($treeType != '' && in_array($parentTreeType,$treeType))
									{
									
																			
										
							?>
					<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
					<div>
					<?php 
											
						echo '<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/tab-icon/talk-view-sel.png alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;'	;		
											
														if ($parentTreeType==1)
														{
													?>
					<?php
														 if($data['treeType']==1)	
														 {
		echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&tagId=1 target="_blank" class="example7">' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>';
															}
															else
															{
		echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&node='.$data['leaf_id'].'&tagId=1 target="_blank" class="example7">' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>';													
															}
		
		
		 ?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php echo $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php echo $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php	echo '<a href='.base_url().'view_task/node/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php	echo '<a href='.base_url().'contact/contactDetails/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php	echo '<a href='.base_url().'notes/Details/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
													?>
					</div>
					<div>
					<?php 
														if ($parentTreeType==1)
														{
													?>
					<?php echo $this->lang->line('txt_Document');?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php echo $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php echo $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php echo $this->lang->line('txt_Task');?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php echo $this->lang->line('txt_Contact');?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php echo $this->lang->line('txt_Notes');?>
					<?php
														}
													?>
				  </div>
					  <div><span><?php echo $this->lang->line('txt_Modified_Date');?>: </b><?php echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['editedDate']),'m-d-Y h:i A'); ?></span> </div>
					  <div class="clr"></div>
					</div>
				<?php
								}
								else if($this->input->post('treeType')=='')
								{
							?>
				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
					  <div>
					<?php 
										
								echo 	'<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/tab-icon/talk-view-sel.png alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;'	;			
										
														if ($parentTreeType==1)
														{
													?>
					<?php
																 if($data['treeType']==1)
																 {
																	echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&option=1&tagId=1  >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>';                                                
																	}
																	else
																	{
																	
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["parentTreeId"].'&doc=exit&node='.$data['leaf_id'].'&option=1&tagId=1  >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>';  		
																	}
														?>
					<?php
														}
														if ($parentTreeType==2)
														{
													?>
					<?php echo $this->lang->line('txt_Discussions');?>
					<?php
														}
														if ($parentTreeType==3)
														{
													?>
					<?php echo $this->lang->line('txt_Chat');?>
					<?php
														}
														if ($parentTreeType==4)
														{
													?>
					<?php	echo '<a href='.base_url().'view_task/node/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
														if ($parentTreeType==5)
														{
													?>
					<?php	echo '<a href='.base_url().'contact/contactDetails/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
														if ($parentTreeType==6)
														{
													?>
					<?php	echo '<a href='.base_url().'notes/Details/'.$data["parentTreeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$data['leaf_id'].' >' .$this->identity_db_manager->formatContent($data['name'],50,1). '</a>'; ?>
					<?php
														}
													?>
													<span class="clsLabel">(<?php echo $treeName;?>)</span>
					</div>
					<div>
						<span class="clsLabel">
					<?php 
														if ($parentTreeType==1)
														{
															$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Document').'" />';
													?>
					<?php //echo $this->lang->line('txt_Document');?>
					<?php
														}
														if ($parentTreeType==4)
														{
															$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Task').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Task');?>
					<?php
														}
														if ($parentTreeType==5)
														{
															$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Contact').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Contact');?>
					<?php
														}
														if ($parentTreeType==6)
														{
															$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Notes').'"/>';
													?>
					<?php //echo $this->lang->line('txt_Notes');?>
					<?php
														}
													?>
						<span><?php echo $icon;?></span> <span><?php echo $this->lang->line('txt_Modified_Date').": ";?><?php  echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['editedDate']),'m-d-Y h:i A'); ?></span>
						</span> 
					</div>
					  <div class="clr"></div>
					</div>
				<?php	
								}
								
								$i++;
								}
							}
							?>
			  </form>
		</div>
		<!-- Updated talk end -->  
	</div>
</div>
<div class="clr"></div>
<div class="dashboard_row" style="width:100%;">
	<div class="dashboard_col" style="float:left;width:50%">
		<!-- Updated links start -->
		<div class="dashboard_wrap">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/link-view-sel.png alt='<?php echo $this->lang->line('txt_Links'); ?>' title='<?php echo $this->lang->line('txt_Links');?>' border=0> Links</span> 
		<?php 
		if (count($arrLinks) > 5)
		{
		?>
		<span><a id="more_links" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_links');">See all.....</a></span>
		<?php
		}
		?>
				<form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
				<input type="hidden" name="page" value="" />
				<?php	
				
							 if(count($arrLinks) > 0)
							 {	
								$rowColor1='row-active-middle1';
								$rowColor2='row-active-middle2';
								$i = 1;
								
								$counter = 0;
								foreach($arrLinks as $data)
								{
								
								$treeId=$data[id];
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
										if ($i<6)
										{
											$display='block';
											$class = 'dashboard_content_links';
										} 
										else 
										{
											$display='none';
											$class = 'dashboard_content_more_links';
										}
								  ?>
				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
					  <div>
					<?php
								   
								   if($data['linkType']=='external')
									   {
									   
									 echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].'/external target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';  
									   }
									   else
									   {
																	  
									echo  '<a href='.base_url().'view_links/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$data["id"].' target=_blank>' .$this->identity_db_manager->formatContent($data['name'],60,1). '</a>';
									}
									
									 ?>
				  </div>
				  <div>
					<span class="clsLabel">
					<?php 
								
									   if($data['type']==1)
									   {
											//echo $this->lang->line('txt_Document');
											$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Document').'" />';
										}
										elseif($data['type']==2)
									   {
											//echo $this->lang->line('txt_Discussion');
											$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
										}
										elseif($data['type']==3)
									   {
											//echo $this->lang->line('txt_Chat');
											$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Discuss').'"/>';
										}	
										elseif($data['type']==4)
									   {
											//echo $this->lang->line('txt_Task');
											$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Task').'"/>';
										}	
										elseif($data['type']==5)
									   {
											//echo $this->lang->line('txt_Notes');
											$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Notes').'"/>';
										}	
										elseif($data['type']==6)
									   {
											//echo $this->lang->line('txt_Contact');
											$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" title="'.$this->lang->line('txt_Contact').'"/>';
										}	
										
										elseif($data['linkType']=='external')
									   {
											//echo $this->lang->line('txt_Imported_Files');
											$icon='<img src="'.base_url().'/images/icon_import.png" style="margin-right:5px;" title="'.$this->lang->line('txt_File').'"/>';
										}				 
								?>
				  </span>
				  <span class="clsLabel">
						<?php echo $icon; echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($data['createdDate'], $this->config->item('date_format'));?>
				  </span> </div>
					  <div class="clr"></div>
					</div>
				<?php
								
								$i++;
								}
										 
		
											   
						}
						else
						{
								?>
				<div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
				<?php
						
						}
							?>
			  </form>
		</div>
		<!-- Updated links end -->	
	</div>
	<div class="dashboard_col" style="float:right;width:50%">
		<!-- Updated tags start -->
		<div class="dashboard_wrap">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_Tags'); ?>' title='<?php echo $this->lang->line('txt_Tags');?>' border=0> Tags</span> 

		<!--<span><a id="more_tags" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_tags');">See all.....</a></span>-->

				  <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
				<input type="hidden" name="page" value="" />
				<?php	
					$applied=0;$due=0;$list=0;$usersString=0;
					if(count($arrTags) > 0)
					{
						$rowColor1='row-active-middle1';
						$rowColor2='row-active-middle2';
						$i = 1;
						
						$counter = 0;
						foreach($arrTags as $treeId=>$tagData)
						{
					
						$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
/*										if ($i<6)
										{
											$display='block';
											$class = 'dashboard_content_tags';
										} 
										else 
										{
											$display='none';
											$class = 'dashboard_content_more_tags';
										}	*/	
											$display='block';
											$class = 'dashboard_content_tags';				
						  ?>
			<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
			  <div>
			<?php
							 if($tagData['tagType']==2 ) //for simple tag
							 {
							 	$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
								//echo "total nodes= " .$total_nodes;
							 		//echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
								//echo "<li>total nodes= " .$total_nodes;
								if ($total_nodes > 1)
								{
							 		echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
												?>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php
								}
								else
								{
									//echo "<li>here";
									$arrTreeDetails = array();
									$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 2, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
									//print_r($arrTreeDetails);
						
									$arrDetails['arrTreeDetails'] = $arrTreeDetails;
									$arrDetails['workSpaceId'] = $workSpaceId;	
									$arrDetails['workSpaceType'] = $workSpaceType;	
										foreach($arrTreeDetails as $key => $arrTagData)
										{ 
											foreach($arrTagData as $key1 => $tagData)
											{
												if ($tagData['artifactType']==1)
												{
													$count++;
													if ($tagData['treeType']==1)
													{
														echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==2)
													{
													  
														
													
														echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==3)
													{
														echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==4)
													{ 
														echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==5)
													{
														echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==6)
													{
														echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												}
												
												if ($tagData['artifactType']==2)
												{
													$count++;
													if ($tagData['treeType']==1)
													{ 
														echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData["treeId"].'&doc=exist&node='.$tagData["artifactId"].'&tagId='.$tagData["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==2)
													{
													
														if($tagData['predecessor'] != 0)
														{
															echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																
														}
														else
														{
														
														echo '<a href='.base_url().'view_discussion/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
														
														}
														
												
													}
												
													if ($tagData['treeType']==3)
													{
														echo '<a href='.base_url().'view_chat/chat_view/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==4)
													{
														echo '<a href='.base_url().'view_task/node/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==5)
													{
														echo '<a href='.base_url().'contact/contactDetails/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData['treeType']==6)
													{
														echo '<a href='.base_url().'notes/Details/'.$tagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												}
												?>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php
											}
										}
									}
							 }
							
							 if($tagData['tagType']==3) //for response tag
							 {
							 	$total_nodes = 0;
							 	$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 3,$tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
								//echo "total nodes= " .$total_nodes;
									if ($total_nodes > 1)
									{
							 			echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
										$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
									
										$dispResponseTags .= ' [';							
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if(!$response)
										{
											if ($tagData['tag']==1 )
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
											if ($tagData['tag']==2)
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
											if ($tagData['tag']==3)
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
											if ($tagData['tag']==4)
											//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
											$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
										}
										//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
										
										$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
						
						
								$dispResponseTags .= '], ';
								  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';	 
									  $dispResponseTags='';
												?>
												<div class="clr"></div>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php
									}
									else
									{
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 3, $tagData["tagComment"], $applied, $due, $list, $usersString ,$tagData["tag"]);	
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
												foreach($arrTagData as $key1 => $tagData3)
												{
													
													if ($tagData3['artifactType']==1)
													{
														$count++;
														if ($tagData3['treeType']==1)
														{
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==2)
														{
														  
															
														
															echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==4)
														{ 
															echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
													
													if ($tagData3['artifactType']==2)
													{
														$count++;
														if ($tagData3['treeType']==1)
														{ 
															echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData3["treeId"].'&doc=exist&node='.$tagData3["artifactId"].'&tagId='.$tagData3["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==2)
														{
														
															if($tagData3['predecessor'] != 0)
															{
																echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData3['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData3['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																	
															}
															else
															{
															
															echo '<a href='.base_url().'view_discussion/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData3['tagComment'].'</a>'; 
															
															}
															
													
														}
													
														if ($tagData3['treeType']==3)
														{
															echo '<a href='.base_url().'view_chat/chat_view/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==4)
														{
															echo '<a href='.base_url().'view_task/node/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==5)
														{
															echo '<a href='.base_url().'contact/contactDetails/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													
														if ($tagData3['treeType']==6)
														{
															echo '<a href='.base_url().'notes/Details/'.$tagData3["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData3["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
															
														}
													}
							$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
						
							$dispResponseTags .= ' [';							
							$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
							if(!$response)
							{
								if ($tagData['tag']==1 )
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';	
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7">'.$this->lang->line('txt_ToDo').'</a>,  ';									
								if ($tagData['tag']==2)
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	
								if ($tagData['tag']==3)
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
								if ($tagData['tag']==4)
								//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';	
								$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
							}
							//$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
							
							$dispResponseTags .= '<a href="javascript:void(0);" onclick="showPopWin(\''.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'\',710, 500, null);" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
			
			
					$dispResponseTags .= '], ';
					  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';	 
						  $dispResponseTags='';
												?>
												<div class="clr"></div>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php
												}
											}

									}

							 
							 
							 }
							 if($tagData['tagType']==5) //for contact tag
							 {
							 	$total_nodes = 0;
							 	$total_nodes = $this->identity_db_manager->getNodeCountByTag ($workSpaceId, $workSpaceType, 5,0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
								//echo "total nodes= " .$total_nodes;
								
									if ($total_nodes > 1)
									{
							 			echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';
												?>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php										
										
									}
									else
									{
										$arrTreeDetails = array();
										$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions ($workSpaceId, $workSpaceType, 5, 0, $applied, $due, $list, $usersString ,$tagData["tag"]);	
							
										$arrDetails['arrTreeDetails'] = $arrTreeDetails;
										$arrDetails['workSpaceId'] = $workSpaceId;	
										$arrDetails['workSpaceType'] = $workSpaceType;	
											foreach($arrTreeDetails as $key => $arrTagData)
											{ 
											foreach($arrTagData as $key1 => $tagData2)
											{
												
												if ($tagData2['artifactType']==1)
												{
													$count++;
													if ($tagData2['treeType']==1)
													{
														echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==2)
													{
													  
														
													
														echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==3)
													{
														echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==4)
													{ 
														echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==5)
													{
														echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==6)
													{
														echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												}
												
												if ($tagData2['artifactType']==2)
												{
													$count++;
													if ($tagData2['treeType']==1)
													{ 
														echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tagData2["treeId"].'&doc=exist&node='.$tagData2["artifactId"].'&tagId='.$tagData2["tagId"].'&curVersion='.$curVersion.'&option=1 target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==2)
													{
													
														if($tagData2['predecessor'] != 0)
														{
															echo  '<a href="'.base_url().'view_discussion/Discussion_reply/'.$tagData2['predecessor'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData2['artifactId'].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
																
														}
														else
														{
														
														echo '<a href='.base_url().'view_discussion/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>'; 
														
														}
														
												
													}
												
													if ($tagData2['treeType']==3)
													{
														echo '<a href='.base_url().'view_chat/chat_view/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==4)
													{
														echo '<a href='.base_url().'view_task/node/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==5)
													{
														echo '<a href='.base_url().'contact/contactDetails/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												
													if ($tagData2['treeType']==6)
													{
														echo '<a href='.base_url().'notes/Details/'.$tagData2["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$tagData2["artifactId"].' target="_blank">'.$tagData['tagComment'].'</a>';
														
													}
												}
												?>
												 <div>
													<span class="clsLabel"><?php echo $this->lang->line('txt_Tag_Type').": ";?>
													<?php 
															
																   if($tagData['tagType']==2)
																   {
																		echo $this->lang->line('txt_Simple_Tag');
																	}
																	elseif($tagData['tagType']==3)
																   {
																		echo $this->lang->line('txt_Response_Tag');
																	}
																	elseif($tagData['tagType']==5)
																   {
																		echo $this->lang->line('txt_Contact_Tag');
																	}	
													?>
													</span>
													<span class="clsLabel">
														<?php echo $this->lang->line('txt_Modified_Date').": ";?><?php echo $this->time_manager->getUserTimeFromGMTTime($tagData['createdDate'], $this->config->item('date_format'));?>
													</span> 
												</div>
												<div class="clr"></div>
												<?php
											}
											}
											
									}
							 
							 }
						 ?>
		  </div>

			</div>
		<?php
						
						$i++;
						}
				}
				else
				{
					 ?>
		<div><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
		<?php
				}
							?>
			  </form>
		</div>
		<!-- Updated tags end -->	
	</div>
</div>
<div class="clr"></div>
<div class="dashboard_row" style="width:100%;">
	<div class="dashboard_col" style="float:left;width:50%">
		<!-- My tags start -->
		<div class="dashboard_wrap">
			<div class="dashboard_title"><img src=<?php echo base_url(); ?>images/tab-icon/tag-view-sel.png alt='<?php echo $this->lang->line('txt_My_Tags'); ?>' title='<?php echo $this->lang->line('txt_My_Tags');?>' border=0> <?php echo $this->lang->line('txt_My_Tags');?></div>
			<div style="float:left; width:50%;">
			  <?php       
							
								if($this->input->post('tagType') != '')
								{
									$tagType = $this->input->post('tagType');
								}						
								if($this->input->post('responseTagType') != '')
								{
									$responseTagType = $this->input->post('responseTagType');
									$responseTagTypeString = implode (',',$responseTagType);
								}
								if($this->input->post('applied') != '')
								{
									$applied = $this->input->post('applied');
								}	
								else
								{
									$applied = 0;
								}
								if($this->input->post('due') != '')
								{
									$due = $this->input->post('due');
								}	
								else
								{
									$due = 0;
								}
								if($this->input->post('list') != '')
								{
									$list = $this->input->post('list');
								}	
								else
								{
									$list = '0';
								}
								if($this->input->post('users') != '')
								{
									$users = $this->input->post('users');
									$usersString = implode (',',$users);
								}	
								else
								{
									$usersString = -1;
								}
								
							
								echo "<div><b>".$this->lang->line('txt_For_me')." :</b></div>";
									$for_by = 1;
								
								$arrTreeDetails='';
								$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
									
								$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 15, $list, $users, $for_by);	
		
		
							/* Due within 30 */
							
							if((count($arrTreeDetailsResponseTags30)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_15').'(0 tags):</span></div>';
							}
		
							else if(count($arrTreeDetailsResponseTags30) > 0)
							{	
								$totalTagCount = 0;
								foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
								{
									$totalTagCount += count($arrTagData);
								}
								$count = 0;
								$responseTagsFull = array();
								$responseTags = array();
								$responseTags2 = array();
								$responseTagsStore = array ();
		
								foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
								{
									foreach($arrTagData as $key1 => $tagData)
									{	
										$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
										$end_date = substr ($tagData['endTime'],0,10);
									
										if($key == 'response')
										{
											$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
		
											if (!in_array($tagData['tagComment'],$responseTagsStore))	
											{
												$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
		
												if (!$response)
												{
												
													$daysAfter = "+7 days";
							
													$daysAfter = strtotime ($daysAfter);
						
													$daysAfter = date("Y-m-d",$daysAfter);
													
													if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
													else
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
												}
												else
												{
												
													$daysAfter = "+7 days";
							
													$daysAfter = strtotime ($daysAfter);
						
													$daysAfter = date("Y-m-d",$daysAfter);
													
													if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
													else
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
												}
											}	
											$responseTagsStore[] = $tagData['tagComment'];
										}
		
									}
								}	
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_15').' ('.$count.' tags):</span></div>';			 
		
								?>
			  <table id="response30" style="display:block;" width="100%" border="0" cellspacing="6" cellpadding="6">
				<?php
		
											if(count($responseTags2) > 0)		
											{
												?>
				<tr>
				  <td><?php echo implode(', ', $responseTags2);?></td>
				</tr>
				<?php	
					
											}
		
								?>
			  </table>
			  <?php
							}
			  ?>
		</div>
		<div style="float:left; width:50%">
							<?php						
							 echo "<div><b>".$this->lang->line('txt_By_me')." :</b></div>";
							$for_by = 2;
								
		$arrTreeDetails=array();
		$arrTreeDetailsResponseTags30='';
		$totalCount=0;
								$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
								
								$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 15, $list, $users, $for_by);	
		
							
		
							/* Due within 30 */
							
							if((count($arrTreeDetailsResponseTags30)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_15').'(0 tags):</span></div>';
							}
		
							else if(count($arrTreeDetailsResponseTags30) > 0)
							{	
								$totalTagCount = 0;
								foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
								{
									$totalTagCount += count($arrTagData);
								}
							
								$count = 0;
								$responseTagsFull = array();
								$responseTags = array();
								$responseTags2 = array();
								$responseTagsStore = array ();
		
								foreach($arrTreeDetailsResponseTags30 as $key => $arrTagData)
								{
									foreach($arrTagData as $key1 => $tagData)
									{	
										$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	
										$end_date = substr ($tagData['endTime'],0,10);
									
										if($key == 'response')
										{
											$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
		
											if (!in_array($tagData['tagComment'],$responseTagsStore))	
											{
												$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
		
												if (!$response)
												{
												
													$daysAfter = "+7 days";
							
													$daysAfter = strtotime ($daysAfter);
						
													$daysAfter = date("Y-m-d",$daysAfter);
													
													if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
													else
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
												}
												else
												{
												
													$daysAfter = "+7 days";
							
													$daysAfter = strtotime ($daysAfter);
						
													$daysAfter = date("Y-m-d",$daysAfter);
													
													if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
													else
													{
														$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank">'.$tagData['tagComment'].'</a>';					
														$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank">'.$tagData['tagComment'].'</a>';						
														$count++;
													}
												}
											}	
											$responseTagsStore[] = $tagData['tagComment'];
										}
		
									}
								}	
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_15').' ('.$count.' tags):</span></div>';			 
		
								?>
			  <table id="responseByMe30" style="display:block;" width="100%" border="0" cellspacing="6" cellpadding="6">
				<?php
		
											if(count($responseTags2) > 0)		
											{
												?>
				<tr>
				  <td><?php echo implode(', ', $responseTags2);?></td>
				</tr>
				<?php	
					
											}
		
								?>
			  </table>
			  <?php
							}
			  ?>
			</div>
		</div>
		<!-- My tags end -->  	
	</div>
	<div class="dashboard_col" style="float:left;width:50%">
		<!-- My tasks start -->
		<div class="dashboard_wrap">
			<div class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_task_sel.png alt='<?php echo $this->lang->line('txt_My_Tasks'); ?>' title='<?php echo $this->lang->line('txt_My_Tasks');?>' border=0> <?php echo $this->lang->line('txt_My_Tasks');?></div>
			<div style="margin:8px 0; float:left; width:50%">
			  <?php       
		
								if($this->input->post('created') != '')
								{
									$created = $this->input->post('created');
								}	
								if($this->input->post('starting') != '')
								{
									$starting = $this->input->post('starting');
								}						
								if($this->input->post('due') != '')
								{
									$due = $this->input->post('due');
								}	
								if($this->input->post('list') != '')
								{
									$list = $this->input->post('list');
								}	
								if($this->input->post('users') != '')
								{
									$users = $this->input->post('users');
								}	
								if($this->input->post('usersAssigned') != '')
								{
									$usersAssigned = $this->input->post('usersAssigned');
								}
		  
		  
								echo "<div><b>".$this->lang->line('txt_For_me')." :</b></div>";
								
									$for_by = 1;
								
								$arrTreeDetails = array();
								$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
								
								//$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
								$arrTreeDetails15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 15, $list, $users, $usersAssigned, $for_by);
							
								//$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
								
								$arrTreeDetailsStarting15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 15, $due, $list, $users, $usersAssigned, $for_by);
							
							
							if((count($arrTreeDetails15)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_15').' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetails15) > 0)
							{	
								// This loop is for count only
								$c = 0;
								foreach($arrTreeDetails15 as $key => $arrTagData)
								{
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										$c++;
									}
								}
							
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_15').' ('.$c.' tasks):</span></div>';			 
								
								// This loop is for rendering
								?>
			  <span id="due30" style="display:block;">
			  <?php
								foreach($arrTreeDetails15 as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAfter = "+7 days";
							
										$daysAfter = strtotime ($daysAfter);
						
										$daysAfter = date("Y-m-d",$daysAfter);	
										
										if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										else
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
									}
								}						
								?>
			  </span>
			  <?php
							}
										
							/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
							
							if((count($arrTreeDetails)==0))
							{
								echo '<div><span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetails) > 0)
							{	
								// This loop is for count only
								$c = 0;
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	
		
								$today = $year."-".$month."-".$day;
								
								foreach($arrTreeDetails as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
									
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										if (($end_date<$today) && ($end_date!='0000-00-00'))
										{
											$c++;
										}
									}
								}
							
								echo '<div><span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' ('.$c.' tasks):</span></div>';			 
								?>
			  <span id="overdue" style="display:block;">
			  <?php
								// This loop is for rendering
								foreach($arrTreeDetails as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
		
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAgo = "-7 days";
							
										$daysAgo = strtotime ($daysAgo);
						
										$daysAgo = date("Y-m-d",$daysAgo);	
										
										if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
			
										}
										else if (($end_date<$today) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
			
										}
		
									}
								}						
								?>
			  </span>
			  <?php
							}
							
		
							/////////////////////// Starting within ///////////////////////////////////////////////////////////////
							
							if((count($arrTreeDetailsStarting15)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_15').' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetailsStarting15) > 0)
							{	
								// This loop is for count only
								$c = 0;
								foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
								{
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										$c++;
									}
								}
							
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_15').' ('.$c.' tasks):</span></div>';			 
								?>
			  <span id="starting30" style="display:block;">
			  <?php
								// This loop is for rendering
								foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
								{
									$start_date = substr ($arrTagData['starttime'],0,10);
								
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAfter = "+7 days";
							
										$daysAfter = strtotime ($daysAfter);
						
										$daysAfter = date("Y-m-d",$daysAfter);	
										
										if (($start_date<$daysAfter) && ($start_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										else
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										
									}
								}	
								?>
			  </span>
			  <?php
							}
		
			  ?>
		 </div>
		 <div style="margin:8px 0; float:left; width:50%">     
			  <!--------------- arun --->
			  <?php 
							
		
							  echo "<div><b>".$this->lang->line('txt_By_me')." :</b></div>";
							 
							$for_by = 2;
								
								
								$arrTreeDetails = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, $due, 'asc', $users, $usersAssigned, $for_by);	
								
								//$arrTreeDetails30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 30, $list, $users, $usersAssigned, $for_by);
								$arrTreeDetails15 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, $starting, 15, $list, $users, $usersAssigned, $for_by);
							
							
								//$arrTreeDetailsStarting30 = $this->identity_db_manager->getMyTasks ($workSpaceId, $workSpaceType, $created, 30, $due, $list, $users, $usersAssigned, $for_by);
						
						
							if((count($arrTreeDetails15)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_15').' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetails15) > 0)
							{	
								// This loop is for count only
								$c = 0;
								foreach($arrTreeDetails15 as $key => $arrTagData)
								{
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										$c++;
									}
								}
							
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Due_Within_15').' ('.$c.' tasks):</span></div>';			 
								
								// This loop is for rendering
								?>
			  <span id="dueByMe30" style="display:block;">
			  <?php
								foreach($arrTreeDetails15 as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAfter = "+7 days";
							
										$daysAfter = strtotime ($daysAfter);
						
										$daysAfter = date("Y-m-d",$daysAfter);	
										
										if (($end_date<$daysAfter) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										else
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
									}
								}						
								?>
			  </span>
			  <?php
							}
					
							/////////////////////// Overdue ///////////////////////////////////////////////////////////////////////
							
							if((count($arrTreeDetails)==0))
							{
								echo '<div><span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetails) > 0)
							{	
								// This loop is for count only
								$c = 0;
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	
		
								$today = $year."-".$month."-".$day;
								
								foreach($arrTreeDetails as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
									
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										if (($end_date<$today) && ($end_date!='0000-00-00'))
										{
											$c++;
										}
									}
								}
		
							
								echo '<div><span class="heading-search">' .$this->lang->line('txt_Tasks_Overdue') .' ('.$c.' tasks):</span></div>';			 
								?>
			  <span id="overdueByMe" style="display:block;">
			  <?php
								// This loop is for rendering
								foreach($arrTreeDetails as $key => $arrTagData)
								{
									$end_date = substr ($arrTagData['endtime'],0,10);
		
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAgo = "-7 days";
							
										$daysAgo = strtotime ($daysAgo);
						
										$daysAgo = date("Y-m-d",$daysAgo);	
										
										if (($end_date>$daysAgo) && ($end_date<$today) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
			
										}
										else if (($end_date<$today) && ($end_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="gray_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
			
										}
		
									}
								}						
								?>
			  </span>
			  <?php
							}
							
		
							/////////////////////// Starting within ///////////////////////////////////////////////////////////////
							
							if((count($arrTreeDetailsStarting15)==0))
							{
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_15').' (0 tasks):</span></div>';
							}
		
							else if(count($arrTreeDetailsStarting15) > 0)
							{	
								// This loop is for count only
								$c = 0;
								foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
								{
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									if (!$checksucc)
									{
										$c++;
									}
								}
							
								echo '<div><span class="heading-search">'.$this->lang->line('txt_Tasks_Starting_Within_30').' ('.$c.' tasks):</span></div>';			 
								?>
			  <span id="startingByMe30" style="display:block;">
			  <?php
								// This loop is for rendering
								foreach($arrTreeDetailsStarting15 as $key => $arrTagData)
								{
									$start_date = substr ($arrTagData['starttime'],0,10);
								
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
									
										$daysAfter = "+7 days";
							
										$daysAfter = strtotime ($daysAfter);
						
										$daysAfter = date("Y-m-d",$daysAfter);	
										
										if (($start_date<$daysAfter) && ($start_date!='0000-00-00'))
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="red_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										else
										{
											echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a class="green_link" target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a><br>';
										}
										
									}
								}	
								?>
			  </span>
			  <?php
							}
		
			  ?>
			</div>
			<div class="clr"></div>					
		</div>
		<!-- My tasks end -->	
	</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
<div class="dashboard_row" style="width:100%;">

<!-- All tasks start -->
<div class="dashboard_col" style="float:left;width:50%">
		<div class="dashboard_wrap">
			<?php
				if(count($arrTasks) > 0)
				{
					// This loop is for count only
					$c = 0;
						foreach($arrTasks as $key => $arrTagData)
						{
							$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
								if (!$checksucc)
								{
									$c++;
								}
						}
				}
				else
				{
					$c = 0;
				}

			?>
			<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_task_sel.png alt='<?php echo $this->lang->line('txt_My_Tasks'); ?>' title='<?php echo $this->lang->line('txt_Tasks');?>' border=0> <?php echo $this->lang->line('txt_Tasks');?></span> <span> (<?php echo $c;?>)</span>
			  	<?php         
				if($c > 5)
				{																	
			  	?>			
			 		<span><a id="more_tasks" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_tasks');">See all.....</a></span>
				<?php
				}
				?>
			<div class="dashboard_wrap">
			  <?php         
							if(count($arrTasks) > 0)
							{									
								
			  ?>
			 					<div>
			  					<?php
								$i=1;
								// This loop is for rendering
								foreach($arrTasks as $key => $arrTagData)
								{
									if ($i<6)
									{
										$display='block';
										$class = 'dashboard_content_tasks';
									} 
									else 
									{
										$display='none';
										$class = 'dashboard_content_more_tasks';
									}

									$end_date = substr ($arrTagData['endtime'],0,10);
									$checksucc = $this->identity_db_manager->checkSuccessors($arrTagData["id"]);
									
									$compImages = array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');
									$nodeTaskStatus = $this->task_db_manager->getTaskStatus($arrTagData['id']);
									
									if (!$checksucc)
									{
										?>
										<div class=<?php echo $class;?> style="margin:10px 0 10px; display:<?php echo $display;?>">
										<?php
										echo '<img border=0 style=cursor:hand src='.base_url().'images/'.$compImages[$nodeTaskStatus].'><a target="_blank" href='.base_url().'view_task/node/'.$arrTagData["treeId"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrTagData["id"].'>'.strip_tags($arrTagData['contents']).'</a>';
										?>
										</div>
										<?php
										$i++;
									}
								}						
								?>
			  					</div>
			  <?php
							}
		
			  ?>
			</div>
			<div class="clr"></div>					
		</div>
	</div>	
<!-- All tasks end -->
	
<!-- Recent messages start -->
<div class="dashboard_col" style="float:right;width:50%">
		<div><span class="dashboard_title"><img src=<?php echo base_url(); ?>images/message_blue_btn.png alt='<?php echo $this->lang->line('txt_Messages'); ?>' title='<?php echo $this->lang->line('txt_Messages');?>' border=0> Messages</span> 
		<?php         
		if(count($arrMessages) > 5)
		{																	
		?>			
			<span><a id="more_messages" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_messages');">See all.....</a></span>
		<?php
		}
		?>
		</div>
		<?php
		$i=1;

		foreach($arrMessages as $keyVal=>$arrVal)
		{
			if ($i<6)
			{
				$display='block';
				$class = 'dashboard_content_messages';
			} 
			else 
			{
				$display='none';
				$class = 'dashboard_content_more_messages';
			}	
			$userDetails = array();
			$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($arrVal['commenterId']);
		?>
			<div class="<?php echo $class;?>" style="margin:10px 0 35px;display:<?php echo $display;?>">
				<div>
					
					<?php echo '<a style="text-decoration:none; color:#000;" href='.base_url().'profile/index/'.$_SESSION['userId'].'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$arrVal["commentWorkSpaceId"].'/'.$arrVal["commentWorkSpaceType"].'/0/0/'.$arrVal["id"].'>'.stripslashes($arrVal['comment']).'</a>'; ?>
				</div>
				<div class='clsLabel'>
					<span><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['commentTime'],$this->config->item('date_format'),1);?></span>
					<span><a href="<?php echo base_url();?>profile/index/<?php echo $userDetails['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?><?php if ($workSpaceId<1 && $userDetails['userGroup']<1) echo '/all';?>"><?php echo $userDetails['userTagName'];?></a>
					
					<?php //echo $userDetails['userTagName'];?></span>
				</div>
			</div>
		<?php
			
			$i++;
		}
		?>
	</div>
</div>
<div class="clr"></div>
<!-- Recent messages end -->
<div class="dashboard_row" style="width:100%;">

	<!-- Recent users start -->
	<div class="dashboard_col" style="float:left;width:50%">
		<span class="dashboard_title"><img src=<?php echo base_url(); ?>images/view_users.gif alt='<?php echo $this->lang->line('txt_User'); ?>' title='<?php echo $this->lang->line('txt_User');?>' border=0> Users</span> 
		<?php         
		if(count($workSpaceMembers) > 5)
		{																	
		?>				
		<span><a id="more_users" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_users');">See all.....</a></span>
		<?php
		}
		?>
		<div class="dashboard_wrap">
			<?php
			$i=1;
			//print_r ($workSpaceMembers);
			foreach($workSpaceMembers as $keyVal=>$workPlaceMemberData)
			{
				if ($i<6)
				{
					$display='block';
					$class = 'dashboard_content_users';
				} 
				else 
				{
					$display='none';
					$class = 'dashboard_content_more_users';
				}	
			?>
				<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
				<span>
			<?php
				//echo $workPlaceMemberData['firstName']. " ".$workPlaceMemberData['lastName'];
			?>
			<a href="<?php echo base_url();?>profile/index/<?php echo $workPlaceMemberData['userId']; ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?><?php if ($workSpaceId<1 && $workPlaceMemberData['userGroup']<1) echo '/all';?>"><?php echo $workPlaceMemberData['firstName']. " ".$workPlaceMemberData['lastName'];?></a>
				</span>
				<span class='clsLabel'>(Joined: <?php echo$this->time_manager->getUserTimeFromGMTTime($workPlaceMemberData['registeredDate'],$this->config->item('date_format'),1);?>)</span>
				</div>
			<?php
				$i++;
			}
			?>
		</div>
	</div>
	<!-- Recent users end -->

	<div class="dashboard_col" style="float:right;width:50%">
	<!-- Recent importedfiles start -->
	<div><span class="dashboard_title"><img src=<?php echo base_url(); ?>images/icon_import.png alt='<?php echo $this->lang->line('txt_Imported_Files'); ?>' title='<?php echo $this->lang->line('txt_Imported_Files');?>' border=0> Files</span> 
		<?php         
		if(count($externalDocs) > 5)
		{																	
		?>	
	<span><a id="more_files" class="blue-link-underline2" href="javascript:void(0);" onclick="javascript:showHideDashBoard('dashboard_content_more_files');">See all.....</a></span>
		<?php
		}
		?>
	</div>	
	<?php
	$i=1;
	foreach($externalDocs as $docData)
	{
			if ($i<6)
			{
				$display='block';
				$class = 'dashboard_content_files';
			} 
			else 
			{
				$display='none';
				$class = 'dashboard_content_more_files';
			}		
		$userDetails = array();	
		$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($docData['userId']);
		$arrFileUrl	= $this->identity_db_manager->getExternalFileDetailsById( $docData['docId']);		
		//$url = base_url().$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];	
		$url = base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];	
	?>
		<div class="<?php echo $class;?>" style="margin:10px 0 10px;display:<?php echo $display;?>">
			<div>
				<a href='<?php echo $url;?>'><?php echo $docData['docCaption'].'_v'.$docData['version'];?></a>
			</div>
			<div class='clsLabel'>
				<span><?php echo $this->time_manager->getUserTimeFromGMTTime($docData['docCreatedDate'], $this->config->item('date_format'));?></span>
				<span><?php echo $userDetails['userTagName'];?>
				
				
				<?php //echo $userDetails['userTagName'];?></span>
			</div>
		</div>
	<?php
		$i++;
	}
	?>
	
	<!-- Recent imported files end -->		
	</div>
	<div class="clr"></div>
</div>

</div>
<!-- close div id content --> 
</div>
<!-- close div id container -->
	<div>
		  <?php $this->load->view('common/foot'); ?>
		  <?php $this->load->view('common/footer');?>
	</div>
</body>
</html>
<script>
		// Keep Checking for total tree count every 5 second
		setInterval("checkTotalTreeCount(<?php  echo $workSpaceId;?>,<?php echo $workSpaceType;?>)", 10000);
</script>
<script type="text/javascript">


	if($(window).width()<760)
	{
		$("#menu2_for_mobile").css('display','inline'); 
		$("#menu2_for_web").css('display','none');
	}
	else
	{
	    $("#menu2_for_mobile").css('display','none'); 
		$("#menu2_for_web").css('display','inline'); 
	}
	window.addEventListener("orientationchange", function() {
		  var t=setTimeout(function(){
				if($(window).width()<760)
				{ 
				   $("#menu2_for_mobile").css('display','inline'); 
		           $("#menu2_for_web").css('display','none');
				}
				else
				{
				   $("#menu2_for_mobile").css('display','none'); 
		           $("#menu2_for_web").css('display','inline'); 
				}
		  },200)
	}, false);
	

   // jQuery('#jsddm2').jcarousel({ });
	


</script>