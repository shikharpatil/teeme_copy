<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php 
	if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
	{
		$languages = $this->identity_db_manager->GetSelectedLanguageDetails(); 
	}
?>
<div id="footer-wrap">
  <div id="footer-container" style=" <?php if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0)){ echo 'height: 75px;'; } else { echo 'height: 72px;'; } ?> ">
  <!--Manoj: code start from here-->
  			<input id="usrtagname" type="hidden" value="<?php echo $_SESSION['userTagName']; ?>" />
			<div class="ftop">
			<div class="top-menu">
    		<div class="top-menu-main">
            <ul class="demo-menu">
			
			<?php
				
					if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
					{	
						if($subWorkSpaceId > 0)
						{
							//$tmpWorkSpaceId = $subWorkSpaceId;
							$tmpWorkSpaceType = 2;
							$tmpWorkSpaceId = $this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($subWorkSpaceId);
							$tmpSubWorkSpaceId = $subWorkSpaceId;
						}
						else if($workSpaceType == 2)
						{
							//$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 2;
							$tmpWorkSpaceId = $this->identity_db_manager->getWorkSpaceBySubWorkSpaceId($workSpaceId);
							$tmpSubWorkSpaceId = $workSpaceId;
						}
						else
						{
							$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 1;
						}

						if($tmpWorkSpaceId > 0)
						{
							if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
							{
								
								$_SESSION['WSManagerAccess'] = 1;
								if($tmpWorkSpaceType == 1)
								{
									$wsUrl = base_url().'edit_workspace/index/'.$tmpWorkSpaceId.'/1';
								}
								else if($tmpWorkSpaceType == 2)
								{			
									$wsDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($tmpSubWorkSpaceId);
									$wsUrl = base_url().'edit_sub_work_space/index/'.$wsDetails['workSpaceId'].'/'.$tmpSubWorkSpaceId;
								}
							}
							else
							{		
								$_SESSION['WSManagerAccess'] = 0;
							}
						}
						else
						{
							$_SESSION['WSManagerAccess'] = 0;
						}
					
					}
					?>
				
            
            <?php
						if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
						{
			?>				<!--Manoj: Manage file(s) icon code commented-->
							<li><a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><!--<img class="clsFooterImg" src="<?php //echo base_url(); ?>images/import-icon.png" style="float:left" />&nbsp;--><?php echo $this->lang->line('txt_Manage_Files');?></a></li>
			<?php
						}
            ?>
			
			<?php
						if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) && $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
			?>
			<li><a href="<?php echo base_url();?>create_workspace/index/<?php echo $workSpaceId;?>"><?php echo $this->lang->line('txt_Create_Workspace');?></a></li>
			<?php
						}
            ?>
           
			<?php
						if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
						{
			?>	
						 <li><a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	</li>
			<?php
						}
			?>
			
            <?php
						if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
			?>
							<li><a target="_blank" href="<?php echo base_url();?>manage_workplace"><?php echo $this->lang->line('txt_Manage_Place');?></a></li>
			<?php 		}
			
			?>
					
           
            </ul>
			
            <a class="menu-item-text" style="color:#ffffff;"><span class="menuIcon"><div class="menu_br"></div><div class="menu_br"></div><div class="menu_br"></div></span> </a>
			
            </div>
			</div></div>
			<div class="clr"></div>
			<!--Manoj: code end here-->
    <div id="footer" class="footer_mob" style="margin:0px; margin-top:-2%; ">
	
	  <div class="fdown_for_mobile">
      <div class="fleft">
        <?php /*?><ul>
          <li><a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="English" ></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/japanese.png" class="clsFooterImg" alt="Japanese" ></a></li>
         </ul><?php */?>
      </div>
	  <div class="fright">
			<?php if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
			{ ?>
			
				<?php /*?><a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="english" title="english" ></a>
				<?php 
					if(!empty($languages))
					{
						foreach($languages['config_value'] as $languageName)
						{
							?>
							<a href="javascript:void(0)" onClick="changeLang('<?php echo $languageName; ?>','')"><img src="<?php echo base_url();?>images/<?php echo $languageName.'.png'; ?>" class="clsFooterImg" alt="<?php echo $languageName; ?>" title="<?php echo $languageName; ?>" ></a>
							<?php
						}
					}
					?>
				<?php */?>
			
			<?php } ?>
			</div>
			 <div class="clr"></div>
      <div class="fright">
        <!--Manoj: Commented Manage space old code-->
        <?php /*
						if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
						{
			?>	
						<a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	
			<?php
						}*/
			?>
       
		
       <span class="postTimeStamp"> <?php echo $this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile');?></span></div></div>
      <div class="clr"></div>
    </div>
  </div>
</div>
<div class="clr"></div>
<!--Manoj: added scroll to bottom button-->
<a href="#" id="scroll_bottom" title="Scroll to Bottom" style="display: none;">Bottom<span></span></a>

<!--Manoj: added scroll to top button-->
<a href="#" id="scroll_top" title="Scroll to Top" style="display: none;">Top<span></span></a>