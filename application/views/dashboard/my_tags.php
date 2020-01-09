<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > My Tags</title>
<?php $this->load->view('common/view_head'); ?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
<script language="JavaScript1.2">


function showHideResponse30()
{
	if (document.getElementById('expand').style.display == '')
	{
		document.getElementById('expand').style.display = 'none';
		document.getElementById('collapse').style.display = '';
		document.getElementById('response30').style.display = '';
	}
	else
	{
		document.getElementById('expand').style.display = '';
		document.getElementById('collapse').style.display = 'none';
		document.getElementById('response30').style.display = 'none';
	}
}

function showHideAllTags()
{
	if (document.getElementById('expandAllTags').style.display == '')
	{
		document.getElementById('expandAllTags').style.display = 'none';
		document.getElementById('collapseAllTags').style.display = '';
		document.getElementById('allTags').style.display = '';
	}
	else
	{
		document.getElementById('expandAllTags').style.display = '';
		document.getElementById('collapseAllTags').style.display = 'none';
		document.getElementById('allTags').style.display = 'none';
	}
}
function showHideResponseByMe30()
{
	if (document.getElementById('expandByMe').style.display == '')
	{
		document.getElementById('expandByMe').style.display = 'none';
		document.getElementById('collapseByMe').style.display = '';
		document.getElementById('responseByMe30').style.display = '';
	}
	else
	{
		document.getElementById('expandByMe').style.display = '';
		document.getElementById('collapseByMe').style.display = 'none';
		document.getElementById('responseByMe30').style.display = 'none';
	}
}

function showHideAllTagsByMe()
{
	if (document.getElementById('expandAllTagsByMe').style.display == '')
	{
		document.getElementById('expandAllTagsByMe').style.display = 'none';
		document.getElementById('collapseAllTagsByMe').style.display = '';
		document.getElementById('allTagsByMe').style.display = '';
	}
	else
	{
		document.getElementById('expandAllTagsByMe').style.display = '';
		document.getElementById('collapseAllTagsByMe').style.display = 'none';
		document.getElementById('allTagsByMe').style.display = 'none';
	}
}
</script>
</head>

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
			 $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content" >
    <div class="main_menu btm-border">
      <div style="display:none;" id="menu2_for_web">
        <ul class="tab_menu_new_up">
          <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li><a   href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="active"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
      <div style="display:none;" id="menu2_for_mobile">
        <ul class="tab_menu_new_up jcarousel-skin-tango" id="jsddm2">
          <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li><a   href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="active"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
    </div>
    <div class="clr"></div>
    <div style="margin-top:10px">
      <div> <img src=<?php echo base_url(); ?>images/tag.gif alt='<?php echo $this->lang->line('txt_My_Tags'); ?>' title='<?php echo $this->lang->line('txt_My_Tags');?>' border=0> <?php echo $this->lang->line('txt_My_Tags');?> </div>
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
						
						
						echo "<b>".$this->lang->line('txt_For_me')." :</b><br/><br/>";
							$for_by = 1;
						
						$arrTreeDetails='';
						$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
							
						$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 30, $list, $users, $for_by);	


					/* Due within 30 */
					
					if((count($arrTreeDetailsResponseTags30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_30').'(0 tags):</span><hr>';
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
									$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					

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
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="red_italic_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
											else
											{
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="green_italic_link">'.$tagData['tagComment'].'</a>';						
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
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="red_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
											else
											{
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="green_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
										}
									}	
									$responseTagsStore[] = $tagData['tagComment'];
								}

							}
						}	
						echo '<span id="expand"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideResponse30();" style="cursor:pointer;"></span><span id="collapse" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideResponse30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_30').' ('.$count.' tags):</span><hr>';			 

						?>
      <table id="response30" style="display:none;" width="100%" border="0" cellspacing="6" cellpadding="6">
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

					/* All Tags */
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_All_Tags') .' (0 tags)</span><hr>';
					}
					

					else if(count($arrTreeDetails) > 0)
					{	
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$totalTagCount += count($arrTagData);
						}
						$count = 0;
						$responseTagsFull = array();
						$responseTags = array();
						$responseTags2 = array();
						$responseTagsStore = array ();

						foreach($arrTreeDetails as $key => $arrTagData)
						{
							foreach($arrTagData as $key1 => $tagData)
							{	
							
								$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	

								if($key == 'simple')
								{
									$simpleTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						

									if (!in_array($tagData['tagComment'],$simpleTagsStore))
									{
										$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$simpleTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
									}
									$simpleTagsStore[] = $tagData['tagComment'];
								}
								if($key == 'response')
								{
									$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
									if (!in_array($tagData['tagComment'],$responseTagsStore))	
									{
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if (!$response)
										{
											$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
											$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="italic_blue_link">'.$tagData['tagComment'].'</a>';						
											$count++;
										}
										else
										{
											$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
											$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';						
											$count++;
										}
									}	
									$responseTagsStore[] = $tagData['tagComment'];
								}
								if($key == 'contact')
								{
									$contactTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';								

									if (!in_array($tagData['tagComment'],$contactTagsStore))	
									{
										$contactTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$contactTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
									}
									$contactTagsStore[] = $tagData['tagComment'];
								}
							}
						}	
						echo '<span id="expandAllTags"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideAllTags();" style="cursor:pointer;"></span><span id="collapseAllTags" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideAllTags();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_All_Tags') .' ('.$count.' tags)</span><hr>';			 

											

						?>
      <table id="allTags" style="display:none;" width="100%" border="0" cellspacing="6" cellpadding="6">
        <?php
									if(count($simpleTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Simple_Tags').'('.count($simpleTags2).'): '.implode(', ', $simpleTags2);?></td>
        </tr>
        <?php	
									}
									if(count($responseTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Response_Tags').'('.count($responseTags2).'): '.implode(', ', $responseTags2);?></td>
        </tr>
        <?php	
			
									}
									if(count($contactTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Contact_Tags').'('.count($contactTags2).'): '.implode(', ', $contactTags2);?></td>
        </tr>
        <?php	
			
									}
						?>
      </table>
      <?php
					}
					
					
					///////////////////////////// arun //////////////////
					
					 echo "<b>".$this->lang->line('txt_By_me')." :</b><br/><br/>";
					$for_by = 2;
						
$arrTreeDetails=array();
$arrTreeDetailsResponseTags30='';
$totalCount=0;
						$arrTreeDetails = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, 'asc', $users, $for_by);	
						
						$arrTreeDetailsResponseTags30 = $this->identity_db_manager->getMyTags($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, 30, $list, $users, $for_by);	

					

					/* Due within 30 */
					
					if((count($arrTreeDetailsResponseTags30)==0))
					{
						echo '<span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_30').'(0 tags):</span><hr>';
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
									$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					

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
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="red_italic_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
											else
											{
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="green_italic_link">'.$tagData['tagComment'].'</a>';						
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
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="red_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
											else
											{
												$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
												$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'/'.$tagData["artifactType"].'" target="_blank" class="green_link">'.$tagData['tagComment'].'</a>';						
												$count++;
											}
										}
									}	
									$responseTagsStore[] = $tagData['tagComment'];
								}

							}
						}	
						echo '<span id="expandByMe"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideResponseByMe30();" style="cursor:pointer;"></span><span id="collapseByMe" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideResponseByMe30();" style="cursor:pointer;"></span> <span class="heading-search">'.$this->lang->line('txt_Response_Tags_Due_Within_30').' ('.$count.' tags):</span><hr>';			 

						?>
      <table id="responseByMe30" style="display:none;" width="100%" border="0" cellspacing="6" cellpadding="6">
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

					/* All Tags */
					if((count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_All_Tags') .' (0 tags)</span><hr>';
					}

					else if(count($arrTreeDetails) > 0)
					{	
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$totalTagCount += count($arrTagData);
						}

						$count = 0;
						$responseTagsFull = array();
						$responseTags = array();
						$responseTags2 = array();
						$responseTagsStore = array ();
						$simpleTags2 = array();
						$simpleTagsFull=array();
						$simpleTags = array();
						$contactTags2 = array();
						$simpleTagsStore=array();
						$contactTagsStore=array();

						foreach($arrTreeDetails as $key => $arrTagData)
						{
							foreach($arrTagData as $key1 => $tagData)
							{	
						
								$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	

								if($key == 'simple')
								{
									$simpleTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						

									if (!in_array($tagData['tagComment'],$simpleTagsStore))
									{
										$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$simpleTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
										
									}
									$simpleTagsStore[] = $tagData['tagComment'];
								}
								
								if($key == 'response')
								{
									$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
									if (!in_array($tagData['tagComment'],$responseTagsStore))	
									{
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if (!$response)
										{
											$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
											$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="italic_blue_link">'.$tagData['tagComment'].'</a>';						
											$count++;
											
										}
										else
										{
											$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
											$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank">'.$tagData['tagComment'].'</a>';						
											$count++;
											
										}
									}	
									$responseTagsStore[] = $tagData['tagComment'];
								}
								if($key == 'contact')
								{
									$contactTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';								

									if (!in_array($tagData['tagComment'],$contactTagsStore))	
									{
										$contactTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$contactTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
										
									}
									$contactTagsStore[] = $tagData['tagComment'];
									
								}
							}
						}	
						echo '<span id="expandAllTagsByMe"><img src="'.base_url().'images/icon_expand.gif" border="0" onclick="showHideAllTagsByMe();" style="cursor:pointer;"></span><span id="collapseAllTagsByMe" style="display:none;"><img src="'.base_url().'images/icon_collapse.gif" border="0" onclick="showHideAllTagsByMe();" style="cursor:pointer;"></span> <span class="heading-search">' .$this->lang->line('txt_All_Tags') .' ('.$count.' tags)</span><hr>';			 

											

						?>
      <table id="allTagsByMe" style="display:none;" width="100%" border="0" cellspacing="6" cellpadding="6">
        <?php
									if(count($simpleTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Simple_Tags').'('.count($simpleTags2).'): '.implode(', ', $simpleTags2);?></td>
        </tr>
        <?php	
									}
									if(count($responseTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Response_Tags').'('.count($responseTags2).'): '.implode(', ', $responseTags2);?></td>
        </tr>
        <?php	
			
									}
									if(count($contactTags2) > 0)		
									{
										?>
        <tr>
          <td><?php echo $this->lang->line('txt_Contact_Tags').'('.count($contactTags2).'): '.implode(', ', $contactTags2);?></td>
        </tr>
        <?php	
			
									}
						?>
      </table>
      <?php
					}
					///////////////////////////// arun //////////////////

					?>
    </div>
  </div>
  <!-- close div id content --> 
</div>
<!-- close div id container -->
<div>
  <?php $this->load->view('common/foot'); ?>
  <?php $this->load->view('common/footer');?>
</div>
</body></html>
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
	


    jQuery('#jsddm2').jcarousel({
    	
    });
	


</script>