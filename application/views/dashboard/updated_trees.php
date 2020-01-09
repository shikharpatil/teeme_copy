<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Home > Updated Trees</title>
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
    <div class=" btm-border" >
          <div style="display:none;" id="menu2_for_web">
        <ul class="tab_menu_new_up">
              <li><a class="active" href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><?php echo $this->lang->line('txt_Updated_Trees');?></a></li>
              <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
            </ul>
      </div>
          <div style="display:none;" id="menu2_for_mobile">
        <ul class="tab_menu_new_up jcarousel-skin-tango" id="jsddm2">
              <li><a class="active" href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><?php echo $this->lang->line('txt_Updated_Trees');?></a></li>
              <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" ><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
              <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
            </ul>
      </div>
        </div>
    <div class="clr"></div>
    <div style="margin-top:10px;" >
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
					if ($count!=0)
					{ 
					?>
          <div  class="row-active-header">
        <div class="row-active-header-inner1" > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Updated_Trees');?></span> </div>
        <!--/* Added by Surbhi IV*/-->
        <div class="row-active-header-inner2"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Created_By');?></span> </div>
        
        <!--/* End of Added by Surbhi IV*/-->
        <div class="row-active-header-inner3"  > <span class="rowHeaderFont" ><?php echo $this->lang->line('txt_Modified_Date');?></span> </div>
        <div class="clr"></div>
      </div>
          <div class="clr"></div>
          <?php
						$rowColor1='row-active-middle1';
						$rowColor2='row-active-middle2';
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

						?>
          <div class="<?php echo $rowColor; ?> ">
        <div class="row-active-header-inner1" >
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
					$icon='<img src="'.base_url().'/images/icon_document_sel15.png" style="margin-right:5px;" />';
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
					/*Added by Surbhi IV*/
					$icon='<img src="'.base_url().'/images/icon_discuss_sel15.png" style="margin-right:5px;" />';
					/*End of Added by Surbhi IV*/
					$txt_tree_type=$this->lang->line('txt_Chat');	
				}
				if ($arrVal['type']==4)
				{
				
					$href='view_task/node/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$txt_tree_type=$this->lang->line('txt_Task');
					/*Added by Surbhi IV*/
					$icon='<img src="'.base_url().'/images/icon_task_sel15.png" style="margin-right:5px;" />';
					/*End of Added by Surbhi IV*/
				}
				if ($arrVal['type']==5)
				{
					//index
					$href='contact/contactDetails/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$txt_tree_type=$this->lang->line('txt_Contact');
					/*Added by Surbhi IV*/
					$icon='<img src="'.base_url().'/images/icon_contact_sel15.png" style="margin-right:5px;" />';
					/*End of Added by Surbhi IV*/
				}
				if ($arrVal['type']==6)
				{
					//index
					$href='notes/Details/'.$keyVal.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$txt_tree_type=$this->lang->line('txt_Notes');
					/*Added by Surbhi IV*/
					$icon='<img src="'.base_url().'/images/icon_notes_sel15.png" style="margin-right:5px;" />';
					/*End of Added by Surbhi IV*/
				}
	
				?>
              <!--/*Added by Surbhi IV*/	--> 
              <?php echo $icon; ?> 
              <!--/*End of Added by Surbhi IV*/	--> 
              <a href="<?php echo base_url().''.$href; ?>" title="<?php echo $this->identity_db_manager->formatContent($arrVal['name'],0,1);?>" class="blue-link-underline"><?php echo $this->identity_db_manager->formatContent($arrVal['name'],60,1); 			 
											if (!empty($arrVal['old_name']))
											{
												echo '<br>(<i>'.$this->lang->line("txt_Previous_Title").':</i> ' .$this->identity_db_manager->formatContent($arrVal['old_name'],60,1).')';
											}?> </a> </div>
        <!--/* Added by Surbhi IV*/-->
        <div class="row-active-header-inner2"  > <span>
          <?php  echo  $arrUser["firstName"]." ".$arrUser["lastName"];		?>
          </span> </div>
        
        <!--/*End of Added by Surbhi IV*/-->
        <div class="row-active-header-inner3"  > <span><?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], 'm-d-Y h:i A');?></span> </div>
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
          <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
          <?php
					}
				}
				else
				{
				?>
          <div class="row-active-header"><span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span></div>
          <?php
				}	
				?>
        </div>
    <div style="margin-top:20px;" align="right" ><?php echo $this->pagination->create_links();?></div>
    </form>
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