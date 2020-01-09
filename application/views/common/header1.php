<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="18%" align="left" background="<?php echo base_url();?>images/bg-top.jpg"><a href="<?php echo base_url().'workspace_home2/trees/0/type/1';?>"><img src="<?php echo base_url();?>images/left-corner-logo.jpg" width="167" height="51" border="0" /></a></td>
		<td width="81%" valign="top" background="<?php echo base_url();?>images/bg-top.jpg">
			<?php
			if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')
			{
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td align="right">&nbsp;</td>
				</tr>
				<tr>
					<td width="66%">&nbsp;</td>
					<td width="34%" align="right"><span class="toplink"><?php echo $this->lang->line('txt_Hi');?>, <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo $tmp[0];?>   |</span> <a href="<?php echo base_url();?>admin/admin_logout/work_place" class="toplink"><?php echo $this->lang->line('txt_Sign_Out');?></a></td>
				</tr>
			</table>
			<?php
			}
			?>		
		</td>
		<td width="1%" align="left"><img src="<?php echo base_url();?>images/top-right-corner.jpg" width="10" height="51" /></td>
	</tr>
</table>
