<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>

<div id="footer-wrap">
  <div id="footer-container" style="height:35px;">
  <!--Manoj: code start from here-->
			
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
        <!--Manoj: Commented Manage space old code-->
        <?php /*
						if(isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
						{
			?>	
						<a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	
			<?php
						}*/
			?>
       
		
        <?php echo $this->lang->line('txt_Copyright_Mobile').' '.$this->lang->line('txt_Teeme_Company_Name_Mobile');?></div></div>
      <div class="clr"></div>
    </div>
  </div>
</div>
<div class="clr"></div>
<!--Manoj: added scroll to bottom button-->
<a href="#" id="scroll_bottom" title="Scroll to Bottom" style="display: none;">Bottom<span></span></a>

<!--Manoj: added scroll to top button-->
<a href="#" id="scroll_top" title="Scroll to Top" style="display: none;">Top<span></span></a>