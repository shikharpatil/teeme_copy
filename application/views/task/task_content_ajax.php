<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php if( $arrDiscussions['latestContent']){?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="editcontent"><?php echo stripslashes($arrDiscussions['contents']);?></td>
  </tr>
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="editthis(<?php echo $arrDiscussions['leafId'];?>);"><?php echo $this->lang->line('txt_Edit');?></a>&nbsp;&nbsp;&nbsp;<?php if( $arrDiscussions['leafParentId']){?><a href="javascript:void(0);" onClick="getnext(<?php echo $arrDiscussions['leafParentId'];?>,'<?php echo $cid;?>');"><img border="0" src="<?php echo base_url();?>images/left.gif" ></a><?php }?>&nbsp;</td>
  </tr>
</table>
<?php }else{?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo stripslashes($arrDiscussions['contents']);?></td>
  </tr>
  <tr>
    <td align="right"><?php if( $arrDiscussions['leafParentId']){?><a href="javascript:void(0);" onClick="getnext(<?php echo $arrDiscussions['leafParentId'];?>,'<?php echo $cid;?>');"><img border="0" src="<?php echo base_url();?>images/left.gif" ></a><?php }?>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="getnew(<?php echo $arrDiscussions['leafId'];?>,'<?php echo $cid;?>');"><img border="0" src="<?php echo base_url();?>images/right.gif" ></a>&nbsp;</td>
  </tr>
</table>
<?php }?>