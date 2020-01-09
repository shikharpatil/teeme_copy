<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?>
<?php 
if(count($ContactNotes)){


	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php  
  $count=0;
while($start < $end){
$userDetails	= $this->contact_list->getUserDetailsByUserId($ContactNotes[$start]['userId']);

?>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="1" style="border:#999999; border:thin;">
        <tr>
          <td><?php echo $this->lang->line('txt_By').' '.$userDetails['userTagName'].'&nbsp; '.$this->lang->line('txt_on').' &nbsp;'.$this->time_manager->getUserTimeFromGMTTime($ContactNotes[$start]['createdDate'], 'm-d-Y H:i A');?></td>
        </tr>
        <tr>
          <td><div style="height:100px; overflow:scroll;"> <?php echo $ContactNotes[$start]['contents'];?></div></td>
        </tr>
      </table></td>
  </tr>
  <?php 
      $start++;
	  $count++;
  }
 
  
  ?>
  <tr>
    <td align="right">&nbsp;
      <table width="50" border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
          <td align="right" nowrap="nowrap"><?php  if ( $start < $totalcontact){?>
            <a href="javascript:viewOldnotes(<?php echo $start;?>)"><img src="<?php echo base_url();?>images/left.gif" border="0"  /></a>
            <?php }?>
            &nbsp;</td>
          <td align="left" nowrap="nowrap">&nbsp;
            <?php if($start >5 ){?>
            <a href="javascript:viewOldnotes(<?php  if (($actual-$count) < 1 ) {echo '0';}else{
	echo ($actual-$count);
	}?>)"> <img src="<?php echo base_url();?>images/right.gif" border="0"  /></a>
            <?php }?></td>
          <td align="left" width="35">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 		

}?>
