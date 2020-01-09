<?php 
	$typeForActive = $this->uri->segment(1);
	$option = $this->input->get('option'); 

	/*Added by Dashrath- Add code for show draft leaf icon*/
	if (in_array($_SESSION['userId'],$contributorsUserId)) 
	{
		$draftLeafs = $this->identity_db_manager->getDraftLeafsByTreeId($treeId);
		//Used in update draft icon in seed header
		$_SESSION['draftLeafCount'.$treeId.$_SESSION['userId']] = count($draftLeafs);
	}
	else
	{
		$draftLeafs = array();
	}
	/*Dashrath- code end*/
?>
<div class="commonSeedHeader">
    <ul>
    <li>
    	<a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=1" class="active" title="<?php echo $this->lang->line('txt_Document');?>" >
    		<?php 
			if($typeForActive=='view_document' &&  ($option==1 || $option ==''))
			{ 
			?>
				<img src="<?php echo base_url();?>images/icon_document_sel.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img src="<?php echo base_url();?>images/icon_document.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
    	</a>
    </li>
    <li class="time-view">
    	<a onclick="getTimelineData('<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>', '<?php echo $treeId;?>', 'document')" title="<?php echo $this->lang->line('txt_Timeline');?>" >
    		<?php 
			if($typeForActive=='tree_timeline')
			{ 
			?>
				<img src="<?php echo base_url();?>images/timeline_icon_sel.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img src="<?php echo base_url();?>images/timeline_icon_new.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
    	</a>
    </li>

    <!--Added by Dashrath- Add code for show draft leaf icon -->
    <li class="time-view" id="draftLeafHeaderIcon" style="<?php if (count($draftLeafs) > 0) {echo "display: block;" ;}else { echo "display: none;" ; } ?>">
    	<a onclick="getDraftLeafData('<?php echo $treeId;?>')" title="<?php echo $this->lang->line('txt_Your_Drafts');?>" >

			<img id="draftLeafUpdateImage" src="<?php echo base_url();?>images/draft_icon.png"  class="seedTopMenuBar" />
			
    	</a>
    </li>
    <!--Dashrath- code end -->
  
    <?php
    if (($workSpaceId==0))
    {?>
    <li class="share-view">
    	<a href="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&option=5" title="<?php echo $this->lang->line('txt_Share');?>" >
    		<?php 
			if($typeForActive=='view_document' && $option==5)
			{ 
			?>
				<img id="shareUpdateImage" src="<?php echo base_url();?>images/share_sel_16_16.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img id="shareUpdateImage" src="<?php echo base_url();?>images/share_icon_16_16.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
    	</a>
    </li>
    <?php
    }
    ?>

    <!-- <li class="update-view" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>" ></li> -->

	<li id="treeUpdate" class="seedHeaderUpdateIcon">
		<img id="updateImage" src="<?php echo base_url()?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" onclick='window.location="<?php echo base_url()?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>"' class="seedHeaderSyncIcon">
	</li>
	<?php 
	/*Code for follow button*/
		$treeDetails['seedId']=$treeId;
		$treeDetails['treeName']='doc';	
		$this->load->view('follow_object',$treeDetails); 
	/*Code end*/
	?>
	</ul>
    <div class="clr"></div>
</div>