<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Updated Tags</title>
	<?php $this->load->view('common/view_head'); ?>
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
	$this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
    </div>
<div id="container_for_mobile">
      <div id="content" >
    <div class="main_menu btm-border"  >
          <div id="menu2_for_mobile">
        <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm2">
              <li style="width:118px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
              <li style="width:116px!important;"><a   href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
              <li style="width:115px!important;"><a   href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
              <li style="width:114px!important;"><a class="active"  href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
              <li style="width:80px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
              <li style="width:82px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
              <li style="width:130px!important;"><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
            </ul>
      </div>
        </div>
    <div class="clr"></div>
    <div style="margin-top:10px">
          <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
        <input type="hidden" name="page" value="" />
        <?php if($arrTreeDetails){ ?>
        <div  class="row-active-header">
              <div class="row-active-header-inner1" style="width:60%;"> <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Updated_Tags');?></span> </div>
              <div class="row-active-header-inner2"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Tag_Type');?></span> </div>
              <div class="clr"></div>
            </div>
        <div class="clr"></div>
        <?php } ?>
        <?php	
					$applied=0;$due=0;$list=0;$usersString=0;
					 if(count($arrTreeDetails) > 0)
					{	
									$rowColor1='row-active-middle1';
									$rowColor2='row-active-middle2';
									$i = 1;
									
									$counter = 0;
									foreach($arrTreeDetails as $treeId=>$tagData)
									{
			
									$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
									  ?>
        <div class="<?php echo $rowColor; ?> ">
              <div class="row-active-header-inner1" style="width:60%;">
            <?php
										 if($tagData['tagType']==2 ) //for simple tag
										 {
										 echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
										 }
										  if($tagData['tagType']==3) //for response tag
										 {
										 echo  '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
										 	$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $tagData['artifactId'], 1);
							
										 $dispResponseTags .= ' [';							
										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
										if(!$response)
										{
											if ($tagData['tag']==1 )
											$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7"  >'.$this->lang->line('txt_ToDo').'</a>,  ';									
											if ($tagData['tag']==2)
											$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'"  target="_blank" class="example7" >'.$this->lang->line('txt_Select').'</a>,  ';	 
											if ($tagData['tag']==3)
											$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Vote').'</a>,  ';
											if ($tagData['tag']==4)
											$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/3/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_Authorize').'</a>,  ';														
										}
										$dispResponseTags .= '<a href="'.base_url().'act_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData['artifactId'].'/'.$tagData['artifactType'].'/0/3/1/'.$tagData['tagId'].'" target="_blank" class="example7" >'.$this->lang->line('txt_View_Responses').'</a>';	
						
								$dispResponseTags .= '], ';
								  echo "&nbsp;".substr($dispResponseTags, 0, strlen( $dispResponseTags )-2).'<br>';	 
									  $dispResponseTags='';
										 
										 
										 }
										  if($tagData['tagType']==5) //for contact tag
										 {
										 echo  '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';
										 
										 }
									 ?>
          </div>
              <div class="row-active-header-inner2"  >
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
          </div>
              <div class="clr"></div>
            </div>
        <?php
									$i++;
									}
				}
				else
				{
					 ?>
        <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
        <?php
				}
					?>
      </form>
          <div style="margin-top:20px;" align="right" ><?php echo $this->pagination->create_links();?></div>
        </div>
  </div>
      <!-- close div id content --> 
    </div>
<!-- close div id container -->
<div>
      <?php $this->load->view('common/foot_for_mobile'); ?>
      <?php $this->load->view('common/footer_for_mobile');?>
    </div>
</body>
</html>
<script type="text/javascript">

    jQuery('#jsddm2').jcarousel({});
</script>