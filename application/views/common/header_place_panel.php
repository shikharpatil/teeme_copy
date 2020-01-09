<div id="header-container">
  <div id="header">
    <div id="left">
      <ul>
        <li><a href="<?php echo base_url();?>manage_workplace"><img class="logoImg" src="<?php echo base_url();?>images/logo.png"  /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>
		<?php 
			if ($_SESSION['workPlaceId']!='') 
			{
				$workPlaceDetails 	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
					if ($workPlaceDetails['companyLogo']!='noimage.jpg')
					{
		?>
						<li><img class="companyLogoMain" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/place_logo/<?php echo $workPlaceDetails['companyLogo'];?>"></li>
						<li><img src="<?php echo base_url();?>images/sep.png" /></li>
		<?php
					}
			}
		?>

      </ul>
    </div>
    <div id="right">
      <ul>
        <li id="imgUsername">
          <?php
			//if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='' && $_SESSION['workPlacePanel'] != 1)
			//{
			if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
			{
				?>
			  
			  <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); 
				?>
			  <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
			  <!--<img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >-->
			  <img class="clsHeaderUserImage" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $_SESSION['photo'];?>" >
			  <?php } 
			   else
			  { ?>
			  	 <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/<?php echo $_SESSION['photo'];?>" >
			  <?php }
			  ?>
			  <div class="UserFirstLastName">
			  <?php
				 // echo $this->lang->line('txt_Hi').", ";	
				  
				  //echo $_SESSION['firstName'] .' '.$_SESSION['lastName'] ;
				   echo $_SESSION['userTagName'];
				   ?>
			   </div>
			  <?php
			}
			/*
			else if ($_SESSION['workPlacePanel'] == 1)
			{
			?>
          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >
          <?php } ?>
          <?php echo $this->lang->line('txt_Hi');?>,
          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo ucfirst($tmp[0]);?>
          <?php
			}
			*/
			?>
        </li>
        <li class="unbordered">
          <?php
			   /*
				if ($_SESSION['workPlacePanel'] == 1)
				{
			?>
          <a href="<?php echo base_url();?>instance/admin_logout/place_manager"><?php echo $this->lang->line('txt_Sign_Out');?></a>
          <?php	
				}
				*/
				//else if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				//{ 
				if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				{
					?>
				  	<a title="Sign Out" href="<?php echo base_url();?>instance/admin_logout/work_place"><span id="logoutTxt"><?php //echo $this->lang->line('txt_Sign_Out');?></span> <img class="" style="height: 16px;margin-top: 15px;padding: 7px 0 7px 12px;width: 16px;border: medium none;" src="<?php echo base_url();?>images/logout.png" ></a>				  
				 	 <?php
				}
			?>
        </li>
      </ul>
    </div>
    <div class="clr"></div>
  </div>
</div>
<?php /*width:<?php echo $this->config->item('page_width')-50;?>px;*/ ?>
<div style="width:50%;">
  <div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>
  <div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>
</div>
<br />