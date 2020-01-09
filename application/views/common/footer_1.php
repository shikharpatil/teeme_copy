<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<div id="footer-wrap">
	<div id="footer-container">
		<div id="footer">
			<div class="fleft">
            <ul>
			<li>
			<?php
					if((isset($_SESSION['userId']) && $_SESSION['userId'] > 0))
					{	
						if($subWorkSpaceId > 0)
						{
							$tmpWorkSpaceId = $subWorkSpaceId;
							$tmpWorkSpaceType = 2;
						}
						else if($workSpaceType == 2)
						{
							$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 2;
						}
						else
						{
							$tmpWorkSpaceId = $workSpaceId;
							$tmpWorkSpaceType = 1;
						}
						if($tmpWorkSpaceId > 0)
						{
							//echo "<li>tmpws= " .$tmpWorkSpaceId;
							if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
							{
								$_SESSION['WSManagerAccess'] = 1;
								if($tmpWorkSpaceType == 1)
								{
									$wsUrl = base_url().'view_sub_work_spaces/index/'.$tmpWorkSpaceId.'/1';
								}
								else if($tmpWorkSpaceType == 2)
								{			
									$wsDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($tmpWorkSpaceId);
									$wsUrl = base_url().'edit_sub_work_space/index/'.$wsDetails['workSpaceId'].'/'.$tmpWorkSpaceId;
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
				?>
							<a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><img class="clsFooterImg" src="<?php echo base_url(); ?>images/import-icon.png" style="float:left" />&nbsp;<?php echo $this->lang->line('txt_Manage_Files');?></a>
				<?php
						}
				?>
			</li>
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
            <li>
			<?php
						if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
						{
			?>
						
						<a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="English" ></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/japanese.png" class="clsFooterImg" alt="Japanese" ></a>
						
			<?php 		}
			
			?>
				</li>
           
            </ul>
            
            
            </div>
            <div class="fright">06_02_2014_1187<br />
<?php echo ($_COOKIE['ismobile']==1 || $_COOKIE['ismobile_place']==1 || $_COOKIE['ismobile_admin']==1)?$this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile'):$this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?></div>
			<div class="clr"></div>
        </div>
	</div>
</div>
<div class="clr"></div>


