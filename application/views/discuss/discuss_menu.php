<div class="menu_new" >
  <ul class="tab_menu_new">
    <li class="discuss-view_sel"><a class="active 1tab" href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Chat_View');?>" ></a></li>
    <li class="time-view-o"><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Real_Time_View');?>"></a></li>
    <li class="tag-view" ><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
    <li class="link-view"><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
    <?php
	if (($workSpaceId==0))
	{
	?>
    <li  class="share-view"><a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
    <?php
	}
	?>
    <li id="treeUpdate" style="float:right;"><img id="updateImage" title="<?php echo $this->lang->line('txt_Update');?>" src="<?php echo base_url()?>images/new-version.png" onclick="window.location=('<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1')" style=" cursor:pointer" ></li>
		<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='chat';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>	
  </ul>
  <div class="clr"></div>
</div>
