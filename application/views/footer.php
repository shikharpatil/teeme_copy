<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<div style="width:100%;">

	<div style="float:left"><img src="<?php echo base_url();?>images/footer_left.gif" alt="logo" width="16" height="85" /></div>

    <div style="float:left; background-image:url(<?php echo base_url();?>images/footer_center.gif); background-repeat:repeat-x;  " >



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

	<div style="width:<?php echo $this->config->item('page_width')-32;?>px; height:85px;">

	<div style="width:<?php echo $this->config->item('page_width')-590;?>px; float:left; text-align:left; padding-top:10px;" class="header">

		<?php

		if (($_SESSION['workPlacePanel'] != 1) && (isset($_SESSION['userId']) && $_SESSION['userId'] > 0))

		{

		?>

        	<a href="<?php echo base_url();?>external_docs/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><img src="<?php echo base_url();?>images/icon_import.png" alt="import" border="0" height="16" width="16">&nbsp;<?php echo $this->lang->line('txt_Manage_Files');?></a>

		<?php

		}

		if(

		isset($_SESSION['WSManagerAccess']) && $_SESSION['WSManagerAccess'] == 1 && $_SESSION['workPlacePanel'] != 1)

		{

		?>	

			&nbsp;|&nbsp;<a href="<?php echo $wsUrl;?>"><?php echo $this->lang->line('txt_Manage_Space');?></a>	

		<?php

		}

		?>

        <?php

		/* Language selection disabled for now

		if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')

		{

		?>

		<a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.gif" alt="English" border="0"></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/french.gif" alt="French" border="0"></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('german','GER')"><img src="<?php echo base_url();?>images/german.gif" alt="German" border="0"></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('spanish','SPA')"><img src="<?php echo base_url();?>images/spanish.gif" alt="Spanish" border="0"></a>

		<?php

		}

		else

		{

			echo '&nbsp;'; 

		}

		*/	

		if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='')

		{

		?>

		

		<a href="javascript:void(0)" onClick="changeLang('english','ENG')"><img src="<?php echo base_url();?>images/english.gif" alt="English" border="0"></a>&nbsp;<a href="javascript:void(0)" onClick="changeLang('french', 'FRE')"><img src="<?php echo base_url();?>images/japan.jpeg" alt="French" border="0"></a>

		

		<?php }

		?>

    </div>

    <div  style="width:<?php echo $this->config->item('page_width')-540;?>px; text-align:center; float:left; padding-top:10px; margin-top:50px; ">

		<h3><?php echo $this->lang->line('txt_Copyright').' ' .date('Y') .'. ' .$this->lang->line('txt_Teeme_Company_Name');?> </h3>    

    </div>

    <div style="width:<?php echo $this->config->item('page_width')-720;?>px; text-align:right; float:right; padding-top:10px ; margin-top:50px;">

		<h4>9_12_2013_1161</h4>  

    </div>

</div>

 

    </div>

    <div style="float:left;"><img src="<?php echo base_url();?>images/footer_right.gif" alt="logo" width="16" height="85" /></div>

</div>







