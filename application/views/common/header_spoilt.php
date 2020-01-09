<?php $this->load->view('common/view_head.php');



?>

<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=10.0; user-scalable=1;" />

<div id="header-container">

  <div id="header">

    <div id="left">

      <ul>

        <li id="logoImg"><a href="<?php echo base_url().'workspace_home2/trees/0/type/1';?>" id="logoImgA"><img src="<?php echo base_url();?>images/logo.png"  /></a></li>

        <li><img src="<?php echo base_url();?>images/sep.png" /></li>

        <li>

        <?php   

		if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))

		{   

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

		?>

        <div style="float:left; background-color:#FFF;padding:4px 4px 4px 4px; width:200px;"><?php echo $this->lang->line('txt_Select_Workspace');?>↓<!--<img style="float: right;height: 19px;width: 19px;" src="<?php echo base_url();?>images/drop_down.png" />--></div>

        <div id="dropdown-1" class="dropdown dropdown-tip">

            <ul class="dropdown-menu">

                <li><a href="#1">Item 1</a></li>

                <li><a href="#2">Item 2</a></li>

                <li><a href="#3">Item 3</a></li>

                <li class="dropdown-divider"></li>

                <li><a href="#4">Item 4</a></li>

                <li><a href="#5">Item 5</a></li>

                <li><a href="#5">Item 6</a></li>

            </ul>

        </div>

        

       

        <?php 

		if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

		{

		?>

            <li><a href="#1" id="space_0"><?php echo $this->lang->line('txt_My_Workspace');?></a></li>

            

           

            <?php

			$i = 1;

	

	foreach($workSpaces as $keyVal=>$workSpaceData)

	{				

		if($workSpaceData['workSpaceName']=='Learn Teeme'){

			$s=$keyVal;

		}

		else{

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			?>

            

            <li><a href="#1" id="space_<?php echo $workSpaceData['workSpaceId'];?>"><?php echo $workSpaceData['workSpaceName'];?></a></li>

				<option value="" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>></option>

			<?php

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

			//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

			//if(($workSpaceId > 0))

			if(count($subWorkspaceDetails) > 0)

			{

				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

				{	

					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

					{		

						if($workSpaceData['subWorkSpaceManagerId'] == 0)

						{

							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

						}

						else

						{					

							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

							$subWorkSpaceManager = $arrUserDetails['userName'];

						}

					}

				?>

				<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>>

					<?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?>

                </option>

				<?php

				}

			}

		}

	 }

	 //learn teeme check not applying working on it

	 if(isset($s)){

		$workSpaceData=$workSpaces[$s];

		if($workSpaceData['workSpaceManagerId'] == 0)

		{

			$workSpaceManager = $this->lang->line('txt_Not_Assigned');

		}

		else

		{					

			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

			$workSpaceManager = $arrUserDetails['userName'];

		}

		?>

        <option disabled="disabled">---------------</option>

        <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

        <?php	 

	 }

  }

	else

	{

	?>

            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

            <?php

    $i = 1;



	foreach($workSpaces as $keyVal=>$workSpaceData)

	{				

		if($workSpaceData['workSpaceManagerId'] == 0)

		{

			$workSpaceManager = $this->lang->line('txt_Not_Assigned');

		}

		else

		{					

			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

			$workSpaceManager = $arrUserDetails['userName'];

		}

		if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

		{

		?>

            <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

            <?php

		}

		$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

			//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

			//if(($workSpaceId > 0))

			if(count($subWorkspaceDetails) > 0)

			{

				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

				{	

					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

					{		

						if($workSpaceData['subWorkSpaceManagerId'] == 0)

						{

							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

						}

						else

						{					

							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

							$subWorkSpaceManager = $arrUserDetails['userName'];

						}

					}

					if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))

					{

				?>

            <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

            <?php

					}

				}

			}

	}

    

	}

    ?>

          </select>

        

        

        

        

        

          <!--<select name="spaceSelect" id="spaceSelect" onChange="javascript:goWorkSpace(this);" class="selbox-min" >

        <?php 

		if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

		{

		?>

            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

            <option value="0" <?php if($workSpaceId == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>

            <option disabled="disabled">---------------</option>

            <?php

	$i = 1;



	

	

	foreach($workSpaces as $keyVal=>$workSpaceData)

	{				

		if($workSpaceData['workSpaceName']=='Learn Teeme'){

			$s=$keyVal;

		}

		else{

			if($workSpaceData['workSpaceManagerId'] == 0)

			{

				$workSpaceManager = $this->lang->line('txt_Not_Assigned');

			}

			else

			{					

				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

				$workSpaceManager = $arrUserDetails['userName'];

			}

			?>

				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

			<?php

			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

			//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

			//if(($workSpaceId > 0))

			if(count($subWorkspaceDetails) > 0)

			{

				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

				{	

					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

					{		

						if($workSpaceData['subWorkSpaceManagerId'] == 0)

						{

							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

						}

						else

						{					

							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

							$subWorkSpaceManager = $arrUserDetails['userName'];

						}

					}

				?>

				<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

				<?php

				}

			}

		}

	 }

	 //learn teeme check not applying working on it

	 if(isset($s)){

		$workSpaceData=$workSpaces[$s];

		if($workSpaceData['workSpaceManagerId'] == 0)

		{

			$workSpaceManager = $this->lang->line('txt_Not_Assigned');

		}

		else

		{					

			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

			$workSpaceManager = $arrUserDetails['userName'];

		}

		?>

        <option disabled="disabled">---------------</option>

        <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>

        <?php	 

	 }

  }

	else

	{

	?>

            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>

            <?php

    $i = 1;



	foreach($workSpaces as $keyVal=>$workSpaceData)

	{				

		if($workSpaceData['workSpaceManagerId'] == 0)

		{

			$workSpaceManager = $this->lang->line('txt_Not_Assigned');

		}

		else

		{					

			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);

			$workSpaceManager = $arrUserDetails['userName'];

		}

		if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))

		{

		?>

            <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>

            <?php

		}

		$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);

			//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)

			//if(($workSpaceId > 0))

			if(count($subWorkspaceDetails) > 0)

			{

				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)

				{	

					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	

					{		

						if($workSpaceData['subWorkSpaceManagerId'] == 0)

						{

							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');

						}

						else

						{					

							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);

							$subWorkSpaceManager = $arrUserDetails['userName'];

						}

					}

					if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))

					{

				?>

            <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>

            <?php

					}

				}

			}

	}

    

	}

    ?>

          </select>-->

          <?php

}

?>

        </li>

      </ul>

    </div>

    <div id="right">

      <ul>

        <li id="imgUsername">

          <?php

			if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='' && $_SESSION['workPlacePanel'] != 1)

			{

			?>

          <a  href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>">

          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); 

			//echo ucfirst($tmp[0]); 

			?>

          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>

          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >

          <?php } ?>

          <?php

			  echo $this->lang->line('txt_Hi').", ";	

			  

			  echo $_SESSION['firstName'] .' '.$_SESSION['lastName'] ; ?>

          </a>

          <?php

			}

			else if ($_SESSION['workPlacePanel'] == 1)

			{

			?>

          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>

          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >

          <?php } ?>

          <?php echo $this->lang->line('txt_Hi');?>,

          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo ucfirst($tmp[0]);?>

          <?php

			}

			?>

        </li>

        <li class="unbordered">

          <?php

			   

				if ($_SESSION['workPlacePanel'] == 1)

				{

			?>

          <a href="<?php echo base_url();?>admin/admin_logout/place_manager"><?php echo $this->lang->line('txt_Sign_Out');?></a>

          <?php	

				}

				else if(isset($_SESSION['userId']) && $_SESSION['userId']!='')

				{ 

			?>

            <a href="javascript:void(0);" onclick="showPopWin('<?php echo base_url();?>workspace_home2/configure/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>', 470, 690, null, '');">

          <img src="<?php echo base_url();?>images/settings.png"  title="Configuration" style="margin-top:19px;cursor:pointer;height:21px;" />  

          </a>

          <a title="Sign Out" href="<?php echo base_url();?>admin/admin_logout/work_place"><span id="logoutTxt"><?php //echo $this->lang->line('txt_Sign_Out');?></span> <img class="" style="height: 16px;margin-top: 15px;padding: 7px 0 7px 12px;width: 16px;border: medium none;" src="<?php echo base_url();?>images/logout.png" ></a>

          

          <?php

				}

			?>

        </li>

      </ul>

    </div>

    <div class="clr"></div>

  </div>

</div>

<div style="width:<?php echo $this->config->item('page_width')-50;?>px;">

  <div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>

  <div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>

</div>

<br />







