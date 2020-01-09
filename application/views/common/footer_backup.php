<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
if(isset($_SESSION['userId']) && $_SESSION['userId'] > 0)
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
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">	
		<tr>
		 
		  <td width="100%" align="left" valign="top">			
		<?php
		/*
		if(isset($_SESSION['WPManagerAccess']) && $_SESSION['WPManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
		{
		?>		
			<a href="<?php echo base_url()?>view_workspaces"><?php echo $this->lang->line('txt_Manage_Place');?></a>
	  <?php
		}
		*/
		if(
		isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)
		{
		?>	
			<a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	
		<?php
		}
		if ($this->uri->segment(1)!='view_talk_tree' && $_SESSION['workPlacePanel'] != 1)
		{
		?>
		<a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><?php echo $this->lang->line('txt_Import_File');?></a>
		<?php
		}
		?>
        </td>
		<td valign="bottom" align="right"></td>		
		</tr>
	</table>
<?php
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center" valign="middle"><h6><?php echo $this->lang->line('txt_site_footer');?></h4></td></tr>
<tr><td align="right" valign="bottom"><font size="-2">27_08_2010_1034</font></td></tr></table>
