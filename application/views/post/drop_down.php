
			<ul class="drop_menu_new">
			<li><a href="javascript:void(0);">--Select--</a><li>
			<?php if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>
			<li>
				<?php /*?> <a href="javascript:void(0);" id="profile" style="padding-left:12px;margin-left:17px;" title="profile" class="<?php if($profileForm=='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#profile').addClass('active');$('#passwordForm').removeClass('active');$('#notification').removeClass('active');$('#password_form').hide();$('#notificationSection').hide();$('#profileForm').show(); clearSessionMsg();"><?php echo $this->lang->line('profile_txt'); ?></a><?php */?>
				
				<?php // if ($workSpaceDetails['workSpaceName']!="Try Teeme" && $_SESSION['active_view']!='space') { ?>
				<?php if ($workSpaceDetails['workSpaceName']!="Try Teeme") { ?>
				<!--<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/1/all<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>-->
				<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/home" style="padding-left:12px; <?php if($_SESSION['all']) { ?>" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_post_txt').' ('.$allPosts.')'; ?></a>				
				<?php } ?>
			</li>
			<?php } ?>
			<li>
            <?php /*?><a href="javascript:void(0);" style="padding-left:12px;margin-left:2px;" id="notification" title="notification" class="<?php if($profileForm!='1' && $passwordForm!='1'){ ?> active <?php } ?>" onclick="$('#notification').addClass('active');$('#profile').removeClass('active');$('#passwordForm').removeClass('active');$('#profileForm').hide();$('#password_form').hide();$('#notificationSection').show(); clearSessionMsg();">
			</a><?php */?>
			
			<?php 
			if ($workSpaceType==1){
				$link = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/space/".$workSpaceId;
			}
			else{
				$link = base_url()."post/web/".$workSpaceId."/".$workSpaceType."/subspace/".$workSpaceId;
			}
			/*
			if ($myProfileDetail['userGroup']>0) { ?>
		
			<!--<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && !$_SESSION['public'] && $this->uri->segment(8)!='bookmark') { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?><?php if($this->uri->segment(10)!=''){ echo '/0/0/'.$userPostSearch; }?>">-->
			<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && !$_SESSION['public'] && $this->uri->segment(5)!='bookmark' && (($this->uri->segment(5)=='space' || $this->uri->segment(5)=='subspace') && $this->uri->segment(6)==$workSpaceId)) { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo $link;?>">

			<span>

			<!--<a href="<?php echo base_url();?>post/web/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $_SESSION['userId']; ?>"-->
			//$_SESSION['all'] condition for hiding option for all tab

			if($workSpaceId){ ?>

			<?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

			<?php } else { ?>

			<?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

			<?php } ?>

			</span></a>
		  <?php } 
		  else if ($workSpaceId>0){ ?>
			<a style="padding-left:12px;margin-left:2px;<?php if(!$_SESSION['all'] && $this->uri->segment(5)!='bookmark') { ?>" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>"><span>
          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName.' ('.$totalSpacePosts.')'; ?>

          <?php } else { ?>

          <?php echo $this->lang->line('txt_My_Workspace').' ('.$totalSpacePosts.')'; ?>

          <?php } ?>

          </span></a>
		  <?php } */?>

        	</li>	
		
				<?php //if($workSpaceDetails['workSpaceName']!="Try Teeme" && $_SESSION['active_view']!='space'){ ?>
				<?php if($workSpaceDetails['workSpaceName']!="Try Teeme"){ ?>

				<?php if($myProfileDetail['userGroup']>0){ ?>
				<li>

				<?php /*?><a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a><?php */?>
				
				<!--<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/type/<?php echo $workSpaceType; ?>/0/1/public<?php if($this->uri->segment(10)!=''){ echo '/0/'.$userPostSearch; }?>" style="padding-left:12px;margin-left:17px;  <?php if($_SESSION['public']) { ?>" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>-->
				<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/public/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;  <?php if($_SESSION['public']) { ?>" class="active <?php } ?>" id="public"><?php echo $this->lang->line('public_txt').' ('.$totalPublicPosts.')'; ?></a>

				</li>
				<?php } ?>	
				<li>

					<?php /*?><a href="javascript:void(0);" id="passwordForm" style="padding-left:12px;margin-left:17px;" title="password" class="<?php if($passwordForm=='1'){ ?> active <?php } ?>" onclick="$('#passwordForm').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#password_form').show(); clearSessionMsg();"><?php echo $this->lang->line('txt_Password'); ?></a><?php */?>
					
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/bookmark/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($post_type=='bookmark') { ?>" class="active <?php } ?>" id="bookmark"><?php echo $this->lang->line('txt_post_starred').' ('.$totalBookmarkPosts.')'; ?></a>
					
				</li>	
				<?php } ?>
				<!--
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/one/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='one' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'My Posts'.' ('.$totalMyPosts.')'; ?></a>
				</li>
				-->
				<?php //if($_SESSION['active_view']!='space'){?>
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/parked/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($post_type=='parked' && $post_type_object_id==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Parked'.' ('.$totalParkedPosts.')'; ?></a>
				</li>
				<?php //} ?>
				<li>
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/drafts" style="padding-left:12px; <?php if($post_type=='drafts') { ?>" class="active <?php } ?>" id="drafts"><?php echo 'Drafts ('.$totalDraftPosts.')'; ?></a>	
				</li>
				<!--	
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/following/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='following' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Following'; ?></a>
				</li>
				<li>			
					<a href="<?php echo base_url(); ?>post/web/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/followers/<?php echo $_SESSION['userId']?>" style="padding-left:12px;margin-left:17px;<?php if($this->uri->segment(5)=='followers' && $this->uri->segment(6)==$_SESSION['userId']) { ?>" class="active <?php } ?>"><?php echo 'Followers'; ?></a>
				</li>
				-->
		
			<?php /*?><li>

				<a href="javascript:void(0);" style="padding-left:12%;margin-left:2%;" id="preferences" title="preferences" class="" onclick="$('#preferences').addClass('active');$('#profile').removeClass('active');$('#notification').removeClass('active');$('#profileForm').hide();$('#notificationSection').hide();$('#editorChoice').show();"><?php echo $this->lang->line('preferences_txt'); ?></a>

			</li><?php */?>

		
			</ul>
<script>

$('ul.drop_menu_new').each(function(){
var obj = document.createElement('select');
obj.style.cssText = 'height:33px';
var list=$(this),
    select=$(obj).insertBefore($(this).hide()).change(function(){
		  window.location.href=$(this).val();	 
	});
	
$('>li a', this).each(function(){
  var option=$(document.createElement('option'))
   .appendTo(select)
   .val(this.href)
   .html($(this).html()); 
  if($(this).attr('class') === 'active '){
	option.attr('selected',true);	
  } 
  
});
list.remove();
});
</script>