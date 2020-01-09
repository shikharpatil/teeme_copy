<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > Advance Search > Applied Tags</title>
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
    <?php $this->load->view('common/header'); ?>
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
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content">
    <div class="main_menu btm-border" >
      <div style="display:none;" id="menu2_for_web">
        <ul class="tab_menu_new_up">
          <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
      <div style="display:none;" id="menu2_for_mobile">
        <ul class="tab_menu_new_up jcarousel-skin-tango" id="jsddm2">
          <li><a href="<?php echo base_url()?>workspace_home2/updated_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Trees');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/updated_talk_trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Talks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/updated_links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Links');?></span></a></li>
          <li><a  href="<?php echo base_url()?>workspace_home2/recent_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_Updated_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tasks');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/my_tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1"><span><?php echo $this->lang->line('txt_My_Tags');?></span></a></li>
          <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Advance_Search');?></span></a></li>
        </ul>
      </div>
      <div class="clr" ></div>
    </div>
    <!-- close div class tab_menu_new -->
    
    <div class="clr"></div>
    <div class="heading-home" style="margin-top:10px; margin-bottom: 10px; " > <img src=<?php echo base_url(); ?>images/search.gif alt='<?php echo $this->lang->line('txt_Search'); ?>' title='<?php echo $this->lang->line('txt_Search');?>' border=0> <?php echo $this->lang->line('txt_Advance_Search');?> </div>
    <div class="main_menu btm-border" >
      <ul class="tab_menu_new_up">
        <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Trees');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Applied_Tags');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/links/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Applied_Links');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/tasks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Tasks');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/talks/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Talks');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/files/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Imported_Files');?></span></a></li>
        <?php 
							if ($workSpaceId==0)
							{
						?>
        <li><a href="<?php echo base_url()?>workspace_home2/sharedTrees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Shared_Trees');?></span></a></li>
        <?php
							}
						?>
      </ul>
    </div>
    <table width="150%" border="0" cellpadding="3" cellspacing="3" class="dashboard_bg">
      <tr>
        <td align="left" valign="top"><?php       
					
						if($this->input->post('tagType') != '')
						{
							$tagType = $this->input->post('tagType');
						}						
						if($this->input->post('responseTagType') != '')
						{
							$responseTagType = $this->input->post('responseTagType');
							$responseTagTypeString = implode (',',$responseTagType);
						}
						if($this->input->post('applied') != '')
						{
							$applied = $this->input->post('applied');
						}	
						else
						{
							$applied = 0;
						}
						if($this->input->post('due') != '')
						{
							$due = $this->input->post('due');
						}	
						else
						{
							$due = 0;
						}
						if($this->input->post('list') != '')
						{
							$list = $this->input->post('list');
						}	
						else
						{
							$list = 'asc';
						}
						if($this->input->post('users') != '')
						{
							$users = $this->input->post('users');
							$usersString = implode (',',$users);
						}	
						else
						{
							$usersString = -1;
						}
						
						
					    if($this->input->post('searched') != '')
						{     
							$arrTreeDetails = $this->identity_db_manager->getTagDetailsBySearchOptions($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, $list, $users);	
							
						}
						
						
					?>
          <script>
function showResponseTagOptions(thisVal)
{
	if(thisVal.checked == true)
	{
		document.getElementById('responseTagType').style.display = '';
		document.getElementById('due').style.display = '';
		document.getElementById('applied1').style.display = '';
		document.getElementById('applied2').style.display = '';
	}
	else
	{
		document.getElementById('responseTagType').style.display = 'none';
		document.getElementById('due').style.display = 'none';
		document.getElementById('applied1').style.display = 'none';
		document.getElementById('applied2').style.display = 'none';	
	}
}
function hideResponseTagOptions()
{
		document.getElementById('responseTagType').style.display = 'none';
		document.getElementById('due').style.display = 'none';
		document.getElementById('applied1').style.display = 'none';
		document.getElementById('applied2').style.display = 'none';	
}
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
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$users)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
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
				val +=  '<input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$users)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
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
          
          <form name="frmCal" action="<?php echo base_url()?>workspace_home2/tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post" onSubmit="return validateCal()">
            <table width="100%" border="0" cellspacing="3" cellpadding="3">
              <tr>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Tags');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><?php
							if ($tagType != '')
							{
							?>
                  <input type="checkbox" name="tagType[]" value="2" <?php if (in_array(2,$tagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Simple_Tags');?>
                  <input type="checkbox" name="tagType[]" onclick="showResponseTagOptions(this);" value="3" <?php if (in_array(3,$tagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Response_Tags');?>
                  <input type="checkbox" name="tagType[]" value="5" <?php if (in_array(5,$tagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Contact_Tags');?>
                  <?php
							}
							else
							{
							?>
                  <input type="checkbox" name="tagType[]" value="2" checked="checked"/>
                  <?php echo $this->lang->line('txt_Simple_Tags');?>
                  <input type="checkbox" name="tagType[]" onclick="showResponseTagOptions(this);" value="3" checked="checked"/>
                  <?php echo $this->lang->line('txt_Response_Tags');?>
                  <input type="checkbox" name="tagType[]" value="5" checked="checked"/>
                  <?php echo $this->lang->line('txt_Contact_Tags');?>
                  <?php
							}
							?></td>
              </tr>
              <?php
					if (in_array(3,$tagType) || $tagType=='')
					{
					?>
              <tr id="responseTagType">
                <?php
					}
					else
					{
					?>
              <tr id="responseTagType" style="display:none;">
                <?php
					}
					?>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Response_Tag_Type');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><?php
							if ((in_array(3,$tagType) || $tagType=='') && ($responseTagType==''))
							{
							?>
                  <input type="checkbox" name="responseTagType[]" value="1" checked="checked"/>
                  <?php echo $this->lang->line('txt_ToDo');?>
                  <input type="checkbox" name="responseTagType[]" value="2" checked="checked"/>
                  <?php echo $this->lang->line('txt_Select');?>
                  <input type="checkbox" name="responseTagType[]" value="3" checked="checked"/>
                  <?php echo $this->lang->line('txt_Vote');?>
                  <input type="checkbox" name="responseTagType[]" value="4" checked="checked"/>
                  <?php echo $this->lang->line('txt_Authorize');?>
                  <?php
							}
							else
							{
							?>
                  <input type="checkbox" name="responseTagType[]" value="1" <?php if (in_array(1,$responseTagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_ToDo');?>
                  <input type="checkbox" name="responseTagType[]" value="2" <?php if (in_array(2,$responseTagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Select');?>
                  <input type="checkbox" name="responseTagType[]" value="3" <?php if (in_array(3,$responseTagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Vote');?>
                  <input type="checkbox" name="responseTagType[]" value="4" <?php if (in_array(4,$responseTagType)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Authorize');?>
                  <?php
							}
							?></td>
              </tr>
              <tr>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Applied_Within');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><?php
							if ($applied != '')
							{
							?>
                  <input type="radio" name="applied" value="1" <?php if ($applied==1) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="applied" value="2" <?php if ($applied==2) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="applied" value="7" <?php if ($applied==7) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="applied" value="30" <?php if ($applied==30) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="applied" value="365" <?php if ($applied==365) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							else
							{
							?>
                  <input type="radio" name="applied" value="1"/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="applied" value="2"/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="applied" value="7"/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="applied" value="30"/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="applied" value="365"/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							?></td>
              </tr>
              <?php
					if (in_array(3,$tagType) || $tagType=='')
					{
					?>
              <tr id="due">
                <?php
					}
					else
					{
					?>
              <tr id="due" style="display:none;">
                <?php
					}
					?>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Due_Within');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><input type="radio" name="due" value="1" <?php if ($due==1) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="due" value="2" <?php if ($due==2) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="due" value="7" <?php if ($due==7) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="due" value="30" <?php if ($due==30) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="due" value="365" <?php if ($due==365) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Year');?></td>
              </tr>
              <tr>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_List');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><input type="radio" name="list" value="asc" <?php if ($list=='asc') { echo 'checked="checked"';}?>/>
                  A - Z
                  <input type="radio" name="list" value="desc" <?php if ($list=='desc') { echo 'checked="checked"';}?>/>
                  Z - A </td>
              </tr>
              <?php
					if (in_array(3,$tagType) || $tagType=='')
					{
					?>
              <tr id="applied1">
                <?php
					}
					else
					{
					?>
              <tr id="applied1" style="display:none;">
                <?php
					}
					?>
                <td width="20%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Applied_For');?>: </td>
                <td width="80%" align="left" valign="top" class="tdSpace"><input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/></td>
              </tr>
              <?php
					if (in_array(3,$tagType) || $tagType=='')
					{
					?>
              <tr id="applied2">
                <?php
					}
					else
					{
					?>
              <tr id="applied2" style="display:none;">
                <?php
					}
					?>
                <td width="20%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                <td width="80%" align="left" valign="top" class="tdSpace"><div id="showMem" style="height:120px; width:300px; overflow:scroll;">
                    <input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$users)) { echo 'checked="checked"';}?>/>
                    <?php echo $this->lang->line('txt_Me');?><br />
                    <input type="checkbox" name="users[]" value="0"/>
                    <?php echo $this->lang->line('txt_All');?><br />
                    <?php		
							foreach($workSpaceMembers as $arrData)
							{
								if($_SESSION['userId'] != $arrData['userId'])
								{						
							?>
                    <input type="checkbox" name="users[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$users)) { echo 'checked="checked"';}?>/>
                    <?php echo $arrData['tagName'];?><br />
                    <?php
								}
							}
							?>
                  </div></td>
              </tr>
              <tr>
                <td width="20%" align="left" valign="top" class="tdSpace">&nbsp;</td>
                <td width="80%" align="left" valign="top" class="tdSpace"><input type="hidden" name="searched" value="searched">
                  <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                  <input type="button" name="Clear" value="<?php echo $this->lang->line('txt_Clear');?>" class="button01" onclick="clearForm(this.form);hideResponseTagOptions();"></td>
              </tr>
            </table>
          </form>
          <?php	
					
					if(($this->input->post('searched') != '') && (count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' (0 tags found)</span><hr>';
					}

					else if(count($arrTreeDetails) > 0)
					{	
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							$totalTagCount += count($arrTagData);
						}
						$count = 0;
						foreach($arrTreeDetails as $key => $arrTagData)
						{
							foreach($arrTagData as $key1 => $tagData)
							{	
							
								$tagLink = $this->tag_db_manager->getLinkByTag( $tagData['tagId'], $tagData['tag'], $tagData['artifactId'], $tagData['artifactType'] );	

								if($key == 'simple')
								{
									$simpleTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						

									if (!in_array($tagData['tagComment'],$simpleTagsStore))
									{
										$simpleTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$simpleTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/2/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
									}
									$simpleTagsStore[] = $tagData['tagComment'];
								}
								if($key == 'response')
								{
									$responseTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					

									if (!in_array($tagData['tagComment'],$responseTagsStore))	
									{
										$responseTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';					
										$responseTags2[] = '<a href="'.base_url().'view_tags/showResponseTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/3/'.$this->identity_db_manager->encodeURLString($tagData["tagComment"]).'/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
									}	
									$responseTagsStore[] = $tagData['tagComment'];
								}
								if($key == 'contact')
								{
									$contactTagsFull[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						

									if (!in_array($tagData['tagComment'],$contactTagsStore))	
									{
										$contactTags[] = '<a href="'.base_url().$tagLink[0].'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$contactTags2[] = '<a href="'.base_url().'view_tags/showTagNodes/'.$workSpaceId.'/'.$workSpaceType.'/'.$tagData["tagId"].'/'.$tagData["tag"].'/5/0/'.$applied.'/'.$due.'/'.$list.'/'.$usersString.'" target="_blank" class="blue-link-underline">'.$tagData['tagComment'].'</a>';						
										$count++;
									}
									$contactTagsStore[] = $tagData['tagComment'];
								}
							}
						}	
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' ('.$count.' tags found)</span><hr>';			 

											

						?>
          <table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <?php
									if(count($simpleTags2) > 0)		
									{
										?>
            <tr>
              <td><?php echo $this->lang->line('txt_Simple_Tags').'('.count($simpleTags2).'): '.implode(', ', $simpleTags2);?></td>
            </tr>
            <?php	
									}
									if(count($responseTags2) > 0)		
									{
										?>
            <tr>
              <td><?php echo $this->lang->line('txt_Response_Tags').'('.count($responseTags2).'): '.implode(', ', $responseTags2);?></td>
            </tr>
            <?php	
			
									}
									if(count($contactTags2) > 0)		
									{
										?>
            <tr>
              <td><?php echo $this->lang->line('txt_Contact_Tags').'('.count($contactTags2).'): '.implode(', ', $contactTags2);?></td>
            </tr>
            <?php	
			
									}
						?>
          </table>
          <?php
					}
					?>
          
          <!-- Main Body --></td>
      </tr>
    </table>
  </div>
</div>
<div>
  <?php $this->load->view('common/foot');?>
  <?php $this->load->view('common/footer');?>
</div>
</body>
</html>
<script type="text/javascript">
 
	if($(window).width()<760)
	{
		$("#menu2_for_mobile").css('display','inline'); 
		$("#menu2_for_web").css('display','none');
	}
	else
	{
	    $("#menu2_for_mobile").css('display','none'); 
		$("#menu2_for_web").css('display','inline'); 
	}
	window.addEventListener("orientationchange", function() {
		  var t=setTimeout(function(){
				if($(window).width()<760)
				{ 
				   $("#menu2_for_mobile").css('display','inline'); 
		           $("#menu2_for_web").css('display','none');
				}
				else
				{
				   $("#menu2_for_mobile").css('display','none'); 
		           $("#menu2_for_web").css('display','inline'); 
				}
		  },200)
	}, false);
	
    jQuery('#jsddm2').jcarousel({
    	
    });
	


</script>