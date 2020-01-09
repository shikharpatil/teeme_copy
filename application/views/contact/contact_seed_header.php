<?php 
  $typeForActive = $this->uri->segment(1);
  $option = $this->uri->segment(7);
?>   

<div class="commonSeedHeader" >
  <ul>
    <li>
      <a class="active 1tab" href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Contact');?>" >
        <?php 
        if($typeForActive=='contact' &&  ($option==1 || $option ==''))
        { 
        ?>
          <img src="<?php echo base_url();?>images/contact_icon_sel.png"  class="seedTopMenuBar" />
        <?php
        }
        else
        {
        ?>
          <img src="<?php echo base_url();?>images/contact_icon.png"  class="seedTopMenuBar" />
        <?php
        }
        ?>
      </a>
    </li>
    <li class="time-view">
      <a onclick="getTimelineData('<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>', '<?php echo $treeId;?>', 'contact')" title="<?php echo $this->lang->line('txt_Timeline');?>" >
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
   <!--  <li class="time-view">
      <a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>">
        <?php 
        if($typeForActive=='contact' && $option==2)
        { 
        ?>
          <img src="<?php echo base_url();?>images/tab-icon/time-view-sel.png"  class="seedTopMenuBar" />
        <?php
        }
        else
        {
        ?>
          <img src="<?php echo base_url();?>images/tab-icon/time-view.png"  class="seedTopMenuBar" />
        <?php
        }
        ?>
      </a>
    </li> -->
    <!-- <li class="tag-view" >
      <a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  >
      </a>
    </li>
    <li class="link-view">
      <a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" >
      </a>
    </li>
    <li class="talk-view">
      <a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>"  >
      </a>
    </li> -->
    <?php
		if (($workSpaceId==0))
		{
		?>
      <li class="share-view">
        <a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" >
          <?php 
          if($typeForActive=='contact' && $option==5)
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
   <!--  <li id="treeUpdate"></li> -->
   <?php 
    if($option!=2)
    {?>
      <li id="treeUpdate" class="seedHeaderUpdateIcon">
        <img id="updateImage" title="<?php echo $this->lang->line('txt_Update');?>" src="<?php echo base_url()?>images/new-version.png" onclick='window.location="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"' class="seedHeaderSyncIcon" >
      </li>
    <?php
    }
    ?>
	
		<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='contact';	
			$this->load->view('follow_object',$treeDetails); 
		/*Code end*/
		?>
  </ul>
  <div class="clr"></div>
</div>