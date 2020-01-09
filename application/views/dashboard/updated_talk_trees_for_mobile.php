<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > Updated Talks</title>
<?php $this->load->view('common/view_head'); ?>
<script language="javascript">
		var baseUrl 		= '<?php echo base_url();?>';	
		var workSpaceId		= '<?php echo $workSpaceId;?>';
		var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
</head>

<dody>
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
    <div class="main_menu btm-border" >
      <div id="menu2_for_mobile">
        <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm2">
          <li style="width:118px!important;"><a  href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li style="width:116px!important;"><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" class="active" ><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li style="width:115px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li style="width:114px!important;"><a href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li style="width:82px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li style="width:80px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li style="width:130px!important;"><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
    </div>
    <div class="clr"></div>
    <div style="margin-top:10px;" >
      <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
        <input type="hidden" name="page" value="" />
        <?php if($arrTreeDetails){ ?>
        <div  class="row-active-header">
          <div class="row-active-header-inner1" style="width:65%;"> <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Updated_Talks');?></span> </div>
          <div class="row-active-header-inner2"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Tree_Type');?></span> </div>
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
        <?php } ?>
        <?php	
					
					if(count($arrTreeDetails) > 0)
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
							foreach($arrTreeDetails as $treeId=>$data)
							{
								$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
		
								if ($treeType != '' && in_array($parentTreeType,$treeType))
									$count++;
							}				
							
	
						}
					
						foreach($arrTreeDetails as $treeId=>$data)
						{	 
							$userDetails = $this->identity_db_manager->getUserDetailsByUserId($data['userId']);
							$parentTreeType = $this->identity_db_manager->getTreeTypeByTreeId ($data['parentTreeId']);
							$treeName = $this->identity_db_manager->getTreeNameByTreeId ($data['parentTreeId']);
						
							$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
							
							if ($treeType != '' && in_array($parentTreeType,$treeType))
							{
							
							
								
					?>
        <div class="<?php echo $nodeBgColor; ?> ">
          <div class="row-active-header-inner1" style="width:65%;">
            <?php 
									
				echo 	'<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;'	;		
									
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
          <div class="row-active-header-inner2"  >
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
          <div class="clr"></div>
        </div>
        <?php
						}
						else if($this->input->post('treeType')=='')
						{
					?>
        <div class="<?php echo $nodeBgColor; ?> ">
          <div class="row-active-header-inner1" style="width:65%;">
            <?php  
                
        echo 	'<a href='.base_url().'view_talk_tree/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$data["parentTreeId"].' target="_blank" class="example7" ><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title='.$this->lang->line("txt_Talk").' border=0></a>&nbsp;'	;			
                
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
          </div>
          <div class="row-active-header-inner2"  >
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
          <div class="clr"></div>
        </div>
        <?php	
						}
						$i++;
						}
					}
					?>
        <div><?php echo $this->pagination->create_links();?></div>
      </form>
    </div>
  </div>
  <!-- close div id content --> 
</div>
<!-- close div id container -->
<div>
  <?php $this->load->view('common/foot_for_mobile'); ?>
  <?php $this->load->view('common/footer_for_mobile');?>
</div>
</body></html>
<script type="text/javascript">
   jQuery('#jsddm2').jcarousel({});
</script>