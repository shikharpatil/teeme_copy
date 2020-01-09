<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php 
/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
			{
				$languages = $this->identity_db_manager->GetSelectedLanguageDetails(); 
			}
			/*Added for checking device type end*/
?>
<div id="footer-wrap">
	<div id="footer-container" <?php if($deviceName=='tablet') { ?> style="height:75px;" <?php } ?> >
		<input id="usrtagname" type="hidden" value="<?php echo $_SESSION['userTagName']; ?>" />
		<div id="footer" <?php if($deviceName=='tablet') { ?> style="padding:5px 0;" <?php } else { ?> style="padding:18px 0;" <?php } ?> >
			<!--Manoj: code start from here-->
			<div class="ftop fleft">
            <ul>
			<li>
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

						//echo $tmpWorkSpaceId.'===='.$workSpaceId.'===='.$subWorkSpaceId;
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
				</li>
            <li>
            <?php
						if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
						{
			?>				<!--Manoj: Manage file(s) icon code commented-->
							<a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><!--<img class="clsFooterImg" src="<?php //echo base_url(); ?>images/import-icon.png" style="float:left" />&nbsp;--><?php echo $this->lang->line('txt_Manage_Files');?></a>
			<?php
						}
            ?>
			</li>
            <?php
						if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) && $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
						{
			?>
			<li>&nbsp;|&nbsp;<a href="<?php echo base_url();?>create_workspace/index/<?php echo $workSpaceId;?>"><?php echo $this->lang->line('txt_Create_Workspace');?></a></li>
			<?php
						}
            ?>
		    <li>
			<?php
						if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
						{
			?>	
						&nbsp;|&nbsp;<a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	
			<?php
						}
			?>
			</li>
           <?php
						if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
			?>
							<li>&nbsp;|&nbsp;<a target="_blank" href="<?php echo base_url();?>manage_workplace"><?php echo $this->lang->line('txt_Manage_Place');?></a></li>
			<?php 		}
			
			?>
					
           
            </ul>
            </div>
			<div class="fright">
			<?php if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
			{ ?>
			<?php /*?><span>
				<a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="english" title="english" ></a>&nbsp;
				<?php 
					if(!empty($languages))
					{
						foreach($languages['config_value'] as $languageName)
						{
							?>
							<a href="javascript:void(0)" onClick="changeLang('<?php echo $languageName; ?>','')"><img src="<?php echo base_url();?>images/<?php echo $languageName.'.png'; ?>" class="clsFooterImg" alt="<?php echo $languageName; ?>" title="<?php echo $languageName; ?>" ></a>&nbsp;
							<?php
						}
					}
					?>
			</span><?php */?>
			<?php } ?>
			
			<?php if($deviceName!='tablet') { ?>		
			
					<span class="postTimeStamp"><?php echo $this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?></span>
			
			<?php } ?>
			</div>
			<div class="clr"></div>
			<!--For tablet -->
			<?php if($deviceName=='tablet') { ?>
			<div class="fmiddle" >
		<span class="postTimeStamp"><?php echo $this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?></span>
			</div>
			<div class="clr"></div>
			<?php } ?>
			<!--tablet code end-->
			<!--Manoj: code end here-->
			<?php /*?><div class="fdown">
			<div class="fleft">
            <ul>
			
							<li><a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="English" title="English" ></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/japanese.png" class="clsFooterImg" alt="Japanese" title="Japanese" ></a></li>
			
           
            </ul>
            </div>
            <div class="fright">
<?php echo ($_COOKIE['ismobile']==1 || $_COOKIE['ismobile_place']==1 || $_COOKIE['ismobile_admin']==1)?$this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile'):$this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?>
			</div>
			</div>
			<div class="clr"></div><?php */?>
        	
			</div>
			
	</div>
</div>
<div class="clr"></div>
<!--Manoj: added scroll to bottom button-->
<a href="#" id="scroll_bottom" title="Scroll to Bottom" style="display: none;">Bottom<span></span></a>

<!--Manoj: added scroll to top button-->
<a href="#" id="scroll_top" title="Scroll to Top" style="display: none;">Top<span></span></a>
