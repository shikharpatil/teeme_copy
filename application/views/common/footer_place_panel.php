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
			/*Added for checking device type end*/
?>
<div id="footer-wrap">
	<div id="footer-container">
		<div id="footer">
			<!--Manoj: code start from here-->
			<div class="ftop">
           
            
            
            </div>
			<div class="clr"></div>
			<!--Manoj: code end here-->
			<div class="fdown">
			<div class="fleft">
            <?php /*?><ul>
			
							<li><a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.png" class="clsFooterImg" alt="English" ></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/japanese.png" class="clsFooterImg" alt="Japanese" ></a></li>
			
           
            </ul><?php */?>
            
            
            </div>
			<?php if($deviceName!='tablet') { ?>
            <div class="fright">
<?php echo ($_COOKIE['ismobile']==1 || $_COOKIE['ismobile_place']==1 || $_COOKIE['ismobile_admin']==1)?$this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile'):$this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?>
			</div>
			<?php } ?>
			</div>
			<div class="clr"></div>
			<!--For tablet -->
			<?php if($deviceName=='tablet') { ?>
			<div class="fmiddle" >
<?php echo ($_COOKIE['ismobile']==1 || $_COOKIE['ismobile_place']==1 || $_COOKIE['ismobile_admin']==1)?$this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile'):$this->lang->line('txt_Copyright').' '.$this->lang->line('txt_Teeme_Company_Name');?>
			</div>
			<div class="clr"></div>
			<?php } ?>
			<!--tablet code end-->
        </div>
	</div>
</div>
<div class="clr"></div>
<!--Manoj: added scroll to bottom button-->
<a href="#" id="scroll_bottom" title="Scroll to Bottom" style="display: none;">Bottom<span></span></a>

<!--Manoj: added scroll to top button-->
<a href="#" id="scroll_top" title="Scroll to Top" style="display: none;">Top<span></span></a>
