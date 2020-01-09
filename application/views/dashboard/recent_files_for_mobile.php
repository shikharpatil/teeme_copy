<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > Advance Search > Imported File(s)</title>
<?php $this->load->view('common/view_head');?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
</head>
<body>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header_for_mobile'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php
        
			$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
			
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);
			$isTalkActive 	= $this->identity_db_manager->isTalkActive($leafTreeId);
			
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
?>
    <?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>
  </div>
</div>
<div id="container_for_mobile">
  <div id="content">
    <div class="main_menu btm-border" >
      <div id="menu2_for_mobile">
        <ul class="tab_menu_new_up_for_mobile jcarousel-skin-tango" id="jsddm2">
          <li style="width:118px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li style="width:116px!important;"><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li style="width:115px!important;"><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li style="width:114px!important;"><a  href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li style="width:82px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li style="width:80px!important;"><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li style="width:130px!important;"><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
      <div class="clr" ></div>
    </div>
    <!-- close div class tab_menu_new -->
    
    <div class="clr"></div>
    <div class="heading-home" style="margin-top:10px; margin-bottom: 10px; " > <img src=<?php echo base_url(); ?>images/search.gif alt='<?php echo $this->lang->line('txt_Search'); ?>' title='<?php echo $this->lang->line('txt_Search');?>' border=0> <?php echo $this->lang->line('txt_Advance_Search');?> </div>
    <div class="main_menu btm-border" >
      <ul class="tab_menu_new_up_for_mobile">
        <li style="width:52px!important;"><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Trees');?></span></a></li>
        <li style="width:106px!important;"><a href="<?php echo base_url()?>workspace_home2/tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Applied_Tags');?></span></a></li>
        <li style="width:108px!important;"><a href="<?php echo base_url()?>workspace_home2/links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Applied_Links');?></span></a></li>
        <li style="width:52px!important;"><a href="<?php echo base_url()?>workspace_home2/tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Tasks');?></span></a></li>
        <li style="width:52px!important;"><a href="<?php echo base_url()?>workspace_home2/talks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Talks');?></span></a></li>
        <li style="width:126px!important;"><a href="<?php echo base_url()?>workspace_home2/files/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Imported_Files');?></span></a></li>
        <?php 
							if ($workSpaceId==0)
							{
						?>
        <li style="width:110px!important;"><a href="<?php echo base_url()?>workspace_home2/sharedTrees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Shared_Trees');?></span></a></li>
        <?php
							}
						?>
      </ul>
    </div>
    <table width="150%" border="0"  cellpadding="3" cellspacing="3" class="dashboard_bg">
      <tr>
        <td align="left" valign="top"><?php       
						
			if($this->input->post('imported') != '')
			{
				$imported = $this->input->post('imported');
			}
			if($this->input->post('list') != '')
			{
				$list = $this->input->post('list');
			}	
			if($this->input->post('users') != '')
			{
				$by = $this->input->post('users');
			}	
			
			
			if($this->input->post('searched') != '')
			{     
				$arrTreeDetails = $this->identity_db_manager->getExternalDocsBySearchOptions($workSpaceId, $workSpaceType, $imported, $list, $by);	
				
				
			}
			
			
		?>
          <script>
function showFilteredMembers()
{
	
	var toMatch = document.getElementById('showMembers').value;

	var val = '';

		if (1)
		{
			<?php
			if ($workSpaceMembers==0)
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$by)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
					val +=  '<input type="checkbox" name="users[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';
				}
			<?php
			}

			foreach($workSpaceMembers as $arrData)	
			{
				if ($arrData['userId'] != $_SESSION['userId'])
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$by)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
        	?>

		}
}
</script> 
          <!-- Main Body -->
          
          <form name="frmCal" action="<?php echo base_url()?>workspace_home2/files/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post" onSubmit="return validateCal()">
            <table width="100%" border="0" cellspacing="3" cellpadding="3">
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Imported_Within');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><?php
							if ($imported != '')
							{
							?>
                  <input type="radio" name="imported" value="1" <?php if ($imported==1) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="imported" value="2" <?php if ($imported==2) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="imported" value="7" <?php if ($imported==7) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="imported" value="30" <?php if ($imported==30) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="imported" value="365" <?php if ($imported==365) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							else
							{
							?>
                  <input type="radio" name="imported" value="1"/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="imported" value="2"/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="imported" value="7"/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="imported" value="30"/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="imported" value="365"/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							?></td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_List');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><input type="radio" name="list" value="asc" <?php if ($list=='asc') { echo 'checked="checked"';}?>/>
                  A - Z
                  <input type="radio" name="list" value="desc" <?php if ($list=='desc') { echo 'checked="checked"';}?>/>
                  Z - A </td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_By');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                <td width="85%" align="left" valign="top" class="tdSpace"><div id="showMem" style="height:120px; width:300px; overflow:scroll;">
                    <input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$by)) { echo 'checked="checked"';}?>/>
                    <?php echo $this->lang->line('txt_Me');?><br />
                    <input type="checkbox" name="users[]" value="0"/>
                    <?php echo $this->lang->line('txt_All');?><br />
                    <?php	
											
					foreach($workSpaceMembers as $arrData)
					{
						if($_SESSION['userId'] != $arrData['userId'])
						{						
									?>
                    <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$by)) { echo 'checked="checked"';}?>/>
                    <?php echo $arrData['tagName'];?><br />
                    <?php
						}
					}
					?>
                  </div></td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                <td width="85%" align="left" valign="top" class="tdSpace"><input type="hidden" name="searched" value="searched">
                  <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                  <input type="button" name="Clear" value="<?php echo $this->lang->line('txt_Clear');?>" class="button01" onclick="clearForm(this.form);"></td>
              </tr>
            </table>
          </form>
          <?php	
					
					if(($this->input->post('searched') != '') && (count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' (0 files found)</span><hr>';
					}

					else if(count($arrTreeDetails) > 0)
					{	
						$rowColor1='rowColor3';
						$rowColor2='rowColor4';	
						$i = 1;
						
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' ('.count($arrTreeDetails).' files found)</span><hr>';			 
						foreach($arrTreeDetails as $treeId=>$data)
						{	 
							$userDetails = $this->identity_db_manager->getUserDetailsByUserId($data['userId']);
							$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
					?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%" align="left"><table width="100%">
                  <tr class="<?php echo $nodeBgColor;?>">
                    <td><b><?php echo $this->lang->line('txt_File_Name');?>: </b> <a href="<?php echo base_url().'ext_file/index/'.$data['docId'];?>" target="_blank">
                      <?php 
						echo $data['docCaption'].'_v'.$data['version'];
					?>
                      </a><br />
                      <b><?php echo $this->lang->line('txt_Created_Date');?>: </b><?php echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['docCreatedDate']),'m-d-Y h:i A'); ?><br />
                      <b><?php echo $this->lang->line('txt_Created_By');?>: </b><?php echo strip_tags($userDetails['userTagName']); ?><br /></td>
                  </tr>
                </table></td>
              <td width="25">&nbsp;</td>
            </tr>
          </table>
          <?php
						$i++;
						}
					}
					?>
          
          <!-- Main Body --></td>
      </tr>
    </table>
  </div>
</div>
<div>
  <?php $this->load->view('common/foot_for_mobile');?>
  <?php $this->load->view('common/footer_for_mobile');?>
</div>
</body>
</html>
<script type="text/javascript">
   jQuery('#jsddm2').jcarousel({});
</script>