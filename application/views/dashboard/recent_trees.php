<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--/*Changed by Surbhi IV*/-->
<title>Home > Advance Search > Trees</title>
<?php $this->load->view('common/view_head');?>
<script language="javascript">
	var baseUrl 		= '<?php echo base_url();?>';	
	var workSpaceId		= '<?php echo $workSpaceId;?>';
	var workSpaceType	= '<?php echo $workSpaceType;?>';		
</script>
<?php
	$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
	$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
<!-- scripts for menu --->
<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
<!--/*Changed By surbhi IV*/-->
<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
<!--/*End of Changed By surbhi IV*/-->
<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
<!-- close here -->

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
					val +=  '<input type="checkbox" name="users[]" value="<?php echo $_SESSION['userId'];?>" <?php if (in_array($_SESSION['userId'],$by)) { echo 'checked="checked"';}?>/><?php echo $this->lang->line('txt_Me');?><br>';
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
</head>

<dody>
<div id="wrap1">
  <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
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
			 $this->load->view('common/artifact_tabs', $details); ?>
  </div>
</div>
<div id="container">
  <div id="content"   >
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
        <li><a href="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" class="active"><span><?php echo $this->lang->line('txt_Trees');?></span></a></li>
        <li><a href="<?php echo base_url()?>workspace_home2/tags/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"><span><?php echo $this->lang->line('txt_Applied_Tags');?></span></a></li>
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
    <table>
      <tr>
        <td align="left" valign="top"><?php       
					
						if($this->input->post('tree') != '')
						{
							$treeTypes = $this->input->post('tree');
						}						
						if($this->input->post('created') != '')
						{
							$created = $this->input->post('created');
						}
						if($this->input->post('modified') != '')
						{
							$modified = $this->input->post('modified');
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
							$arrTreeDetails = $this->identity_db_manager->getTreeDetailsBySearchOptions($workSpaceId, $workSpaceType, $treeTypes, $created, $modified, $list, $by);	
						}
						
					?>
          
          <!-- Main Body -->
          
          <form name="frmCal" action="<?php echo base_url()?>workspace_home2/trees/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" method="post" onSubmit="return validateCal()">
            <table width="150%" border="0" cellspacing="3" cellpadding="3">
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Tree');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><?php
							if ($treeTypes != '')
							{
							?>
                  <input type="checkbox" name="tree[]" value="1" <?php if (in_array(1,$treeTypes)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Document');?>
                  <input type="checkbox" name="tree[]" value="3" <?php if (in_array(3,$treeTypes)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Chat');?>
                  <input type="checkbox" name="tree[]" value="4" <?php if (in_array(4,$treeTypes)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Tasks');?>
                  <input type="checkbox" name="tree[]" value="6" <?php if (in_array(6,$treeTypes)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Notes');?>
                  <input type="checkbox" name="tree[]" value="5" <?php if (in_array(5,$treeTypes)) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_Contacts');?>
                  <?php
							}
							else
							{
							?>
                  <input type="checkbox" name="tree[]" value="1" checked="checked"/>
                  <?php echo $this->lang->line('txt_Document');?>
                  <input type="checkbox" name="tree[]" value="3" checked="checked"/>
                  <?php echo $this->lang->line('txt_Chat');?>
                  <input type="checkbox" name="tree[]" value="4" checked="checked"/>
                  <?php echo $this->lang->line('txt_Tasks');?>
                  <input type="checkbox" name="tree[]" value="6" checked="checked"/>
                  <?php echo $this->lang->line('txt_Notes');?>
                  <input type="checkbox" name="tree[]" value="5" checked="checked"/>
                  <?php echo $this->lang->line('txt_Contacts');?>
                  <?php
							}
							?></td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Created_Within');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><?php
							if ($created != '')
							{
							?>
                  <input type="radio" name="created" value="1" <?php if ($created==1) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="created" value="2" <?php if ($created==2) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="created" value="7" <?php if ($created==7) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="created" value="30" <?php if ($created==30) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="created" value="365" <?php if ($created==365) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							else
							{
							?>
                  <input type="radio" name="created" value="1"/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="created" value="2"/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="created" value="7"/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="created" value="30"/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="created" value="365"/>
                  <?php echo $this->lang->line('txt_1_Year');?>
                  <?php
							}
							?></td>
              </tr>
              <tr>
                <td width="15%" align="left" valign="top" class="tdSpace"><?php echo $this->lang->line('txt_Modified_Within');?>: </td>
                <td width="85%" align="left" valign="top" class="tdSpace"><input type="radio" name="modified" value="1" <?php if ($modified==1) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Day');?>
                  <input type="radio" name="modified" value="2" <?php if ($modified==2) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_2_Days');?>
                  <input type="radio" name="modified" value="7" <?php if ($modified==7) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Week');?>
                  <input type="radio" name="modified" value="30" <?php if ($modified==30) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Month');?>
                  <input type="radio" name="modified" value="365" <?php if ($modified==365) { echo 'checked="checked"';}?>/>
                  <?php echo $this->lang->line('txt_1_Year');?></td>
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
                <td width="15%" align="left" valign="top">&nbsp;</td>
                <td width="85%" align="left" valign="top"><input type="hidden" name="searched" value="searched">
                  <input type="submit" name="Go" value="<?php echo $this->lang->line('txt_go');?>" class="button01">
                  <input type="button" name="Clear" value="<?php echo $this->lang->line('txt_Clear');?>" class="button01" onclick="clearForm(this.form);"></td>
              </tr>
            </table>
          </form>
          <?php	
					
					if(($this->input->post('searched') != '') && (count($arrTreeDetails)==0))
					{
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' (0 trees found)</span><hr>';
					}

					else if(count($arrTreeDetails) > 0)
					{	
						$rowColor1='rowColor3';
						$rowColor2='rowColor4';	
						$i = 1;
						
						echo '<span class="heading-search">' .$this->lang->line('txt_Search_Result') .' ('.count($arrTreeDetails).' trees found)</span><hr>';			 
						foreach($arrTreeDetails as $treeId=>$data)
						{	 
							$userDetails = $this->identity_db_manager->getUserDetailsByUserId($data['userId']);
							
							$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;
							
					?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%" align="left"><table width="100%">
                  <tr class="<?php echo $nodeBgColor;?>">
                    <td><b><?php echo $this->lang->line('txt_Tree');?>: </b>
                      <?php 
												if ($data['type']==1)
												{
											?>
                      (<?php echo $this->lang->line('txt_Document');?>)
                      <?php
												}
												if ($data['type']==2)
												{
											?>
                      (<?php echo $this->lang->line('txt_Discussions');?>)
                      <?php
												}
												if ($data['type']==3)
												{
											?>
                      (<?php echo $this->lang->line('txt_Chat');?>)
                      <?php
												}
												if ($data['type']==4)
												{
											?>
                      (<?php echo $this->lang->line('txt_Task');?>)
                      <?php
												}
												if ($data['type']==5)
												{
											?>
                      (<?php echo $this->lang->line('txt_Contacts');?>)
                      <?php
												}
												if ($data['type']==6)
												{
											?>
                      (<?php echo $this->lang->line('txt_Notes');?>)
                      <?php
												}
											?>
                      <?php 
												if ($data['type']==1)
												{
													echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$data["id"].'&doc=exist target=_blank>' .strip_tags($data['name']). '</a>';
												}		
												if ($data['type']==2)
												{
													echo '<a href='.base_url().'view_discussion/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
												}	
												if ($data['type']==3)
												{
													if ($data['status']==1)
													{
														echo '<a href='.base_url().'view_chat/chat_view/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
													}
													else
													{
														echo '<a href='.base_url().'view_chat/node1/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
													}
												}
												if ($data['type']==4)
												{
													echo '<a href='.base_url().'view_task/node/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
												}	
												if ($data['type']==5)
												{
													echo '<a href='.base_url().'contact/contactDetails/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
												}
												if ($data['type']==6)
												{
													echo '<a href='.base_url().'notes/Details/'.$data["id"].'/'.$workSpaceId.'/type/'.$workSpaceType.' target=_blank>' .strip_tags($data['name']). '</a>';
												}	
																		
											?>
                      <br />
                      <b><?php echo $this->lang->line('txt_Created_Date');?>: </b><?php echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['createdDate']),'m-d-Y h:i A'); ?>, <b><?php echo $this->lang->line('txt_Modified_Date');?>: </b><?php echo $this->time_manager->getUserTimeFromGMTTime(strip_tags($data['editedDate']),'m-d-Y h:i A'); ?>, <b><?php echo $this->lang->line('txt_Created_By');?>: </b><?php echo strip_tags($userDetails['userTagName']); ?><br /></td>
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
  <!-- close div id content --> 
</div>
<!-- close div id container -->
<div>
  <?php $this->load->view('common/foot');?>
  <?php $this->load->view('common/footer');?>
</div>
</body></html>
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