<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Updated Links</title>
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
    <div class="main_menu btm-border" >
          <div style="display:none;" id="menu2_for_web">
        <ul class="tab_menu_new_up">
              <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
              <li><a   href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
              <li><a  class="active"  href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
            </ul>
      </div>
          <div style="display:none;" id="menu2_for_mobile">
        <ul class="tab_menu_new_up jcarousel-skin-tango" id="jsddm2">
              <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
              <li><a   href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
              <li><a  class="active"  href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
            </ul>
      </div>
        </div>
    <div class="clr"></div>
    <div style="margin-top:10px">
          <form name="record_list" method="post" action="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"  id="record_list">
        <input type="hidden" name="page" value="" />
        <?php if($arrTreeDetails){ ?>
        <div  class="row-active-header">
              <div class="row-active-header-inner1" > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Updated_Links');?></span> </div>
              <div class="row-active-header-inner2"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Link_Type');?></span> </div>
              <div class="row-active-header-inner3"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Modified_Date');?></span> </div>
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
						
						$counter = 0;
						foreach($arrTreeDetails as $data)
						{
						
						$treeId=$data[id];
						$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;
						  ?>
        <div class="<?php echo $rowColor; ?> ">
              <div class="row-active-header-inner1" >
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
              <div class="row-active-header-inner2"  >
            <?php 
						
							   if($data['type']==1)
							   {
									echo $this->lang->line('txt_Document');
								}
								elseif($data['type']==2)
							   {
									echo $this->lang->line('txt_Discussion');
								}
								elseif($data['type']==3)
							   {
									echo $this->lang->line('txt_Chat');
								}	
								elseif($data['type']==4)
							   {
									echo $this->lang->line('txt_Task');
								}	
								elseif($data['type']==5)
							   {
									echo $this->lang->line('txt_Notes');
								}	
								elseif($data['type']==6)
							   {
									echo $this->lang->line('txt_Contact');
								}	
								
								elseif($data['linkType']=='external')
							   {
									echo $this->lang->line('txt_Imported_Files');
								}				 
						?>
          </div>
              <div class="row-active-header-inner3"  > <span>
                <?php
									 echo $data['createdDate'];
							?>
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
      <?php $this->load->view('common/foot'); ?>
      <?php $this->load->view('common/footer');?>
    </div>
</body>
</html>
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