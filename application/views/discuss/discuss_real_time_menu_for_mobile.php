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
    <li class="discuss-view"><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
    <li class="time-view-g_sel"><a  class="active" href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Real_Time_View');?>"></a></li>
    <li class="tag-view" ><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>" ></a></li>
    <li class="link-view" ><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
    <?php
	if (($workSpaceId==0))
	{
	?>
   		<li class="share-view" ><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
    <?php
	}
	?>
	<div class="tab_for_landscape">
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
