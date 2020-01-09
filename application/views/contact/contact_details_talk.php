<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--/*Changed by Surbhi IV*/-->
    <title>Contact ><?php echo strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname'],'<b><em><span><img>');?></title>
    <!--/*End of Changed by Surbhi IV*/-->
    <?php $this->load->view('common/view_head.php');?>
    <script>
		var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>'; 
		var workSpace_name='<?php echo $workSpaceId;?>';
		var workSpace_user='<?php echo $_SESSION['userId'];?>';
	</script>
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
    <?php $this->load->view('common/artifact_tabs', $details); ?>
  </div>
    </div>
<div id="container">
<div id="content">
      <div style="float:left;"> 
    <!-- Main menu -->
    <?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
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
    <!-- Main menu --> 
    
  </div>
      <div style="width:100%; float:left;  padding-left:10px; background-color:#FFFFFF"> <!-- Main body div starts -->
    <?php $nodeOrder = 1;?>
    <div class="menu_new" >
          <ul class="tab_menu_new">
        <li class="contact-view"><a  href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Contact_View');?>" ></a></li>
        <li class="time-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Time_View');?>"></a></li>
        <li class="tag-view" ><a  href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/3" title="<?php echo $this->lang->line('txt_Tag_View');?>"  ></a></li>
        <li class="link-view"><a   href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Link_View');?>" ></a></li>
        <li class="talk-view_sel"><a class="active " href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/7" title="<?php echo $this->lang->line('txt_Talk_View');?>"  ></a></li>
        <?php
				if (($workSpaceId==0))
				{
				?>
        <li class="share-view"><a href="<?php echo base_url()?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" ></a></li>
        <?php
				}
				?>
				
														<?php 
														/*Code for follow button*/
															$treeDetails['seedId']=$treeId;
															$treeDetails['treeName']='contact';	
															$this->load->view('follow_object',$treeDetails); 
														/*Code end*/
														?>
				
      </ul>
          <div class="clr"></div>
        </div>
    <?php

				$nodeBgColor = 'seedBgColor';
				$temp_array=array();
				$main_array=array();
				
				 
		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
		{
		?>
    <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;"> <span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span> </div>
    <?php
		}
			
            $focusId = 3;
	
		$i = 1;
		
		if(count($talkDetails) > 0)
		{	 
			for($i=0;$i < count($talkDetails);$i++)
			{	 
			    $arrVal=$talkDetails[$i];
				if($this->identity_db_manager->isTalkActive($arrVal['id']))
				{
				  
					
				$content='';
				$content=$this->identity_db_manager->formatContent(stripslashes($arrVal['name']),1000);
				$tr = ($arrVal['type']==1)?1:0;
				$temp_array=array("id"=>"".$arrVal["id"]."","userId"=>"".$arrVal["userId"]."","content"=>"$content","editedDate"=>"".$arrVal["editedDate"]."","leaf_id"=>"".$arrVal["leaf_id"]."","isTree"=>$tr,"nodeId"=>"".$arrVal["nodeId"]."");
				array_push($main_array,$temp_array);
				}
			 } 
		}	

			
			 
		for($i=0;$i<count($main_array);$i++)
		{	 
			    $arrVal=$main_array[$i];
				$nodeBgColor = ($i%2)?'row1':'row2';
				$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);
				
				/* Start - Get last talk comment */
				$talk=$this->discussion_db_manager->getLastTalkByTreeId($arrVal['id']);

								if(strip_tags($talk[0]->contents))

								{

						            $latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails1['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

								}

								else

								{

									$latestTalk='Talk';

								}
				/* End - Get last talk comment */	
							
				  if($arrVal['isTree']==1)
				  {
				  	
							$leafdataContent=strip_tags($arrVal['content']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['content'], ENT_QUOTES);
				  
					?>
    <div class="seedBgColor views_div"> <!-- Leaf Container Starts here -->
          <?php
					//echo '<div class="flLt"><a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$arrVal['leaf_id'].'/1\' ,\'\',\'width=850,height=500,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title="'.$latestTalk.'" border=0></a></div>&nbsp;';
					?>
					<div class="flLt"><a id="liTalks<?php echo $arrVal['id'];?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $arrVal['id']; ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $arrVal['leaf_id'] ?>','<?php echo $talkTitle; ?>','1','','<?php echo $arrVal['nodeId']; ?>')" title="<?php echo $latestTalk ?>" border="0" ><img src='<?php echo base_url(); ?>images/talk.gif' alt='<?php echo $this->lang->line("txt_Talk");?>' title="<?php echo $latestTalk; ?>" border=0></a></div>&nbsp;
					
					<input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $arrVal['id']; ?>"/>
					<?php
					}
					else
					{
					
							$leafdataContent=strip_tags($arrVal['content']);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($arrVal['content'], ENT_QUOTES);
					
					?>
          <div class="<?php echo $nodeBgColor;?> views_div"> <!-- Leaf Container Starts here -->
		  
		  <div class="flLt"><a id="liTalks<?php echo $arrVal['id']; ?>" href="javaScript:void(0)"  onClick="talkOpen('<?php echo $arrVal['id'] ?>','<?php echo $workSpaceId ?>','<?php echo $workSpaceType ?>','<?php echo $treeId ?>','<?php echo $talkTitle; ?>','0','','<?php echo $arrVal['nodeId']; ?>', 2, 1)" title="<?php echo $latestTalk ?>" border="0" ><img src='<?php echo base_url(); ?>/images/talk.gif' alt='<?php echo $this->lang->line("txt_Talk");?>' title="<?php echo $latestTalk; ?>" border=0></a></div>&nbsp;
		  
		  <input type="hidden" value="<?php echo $leafhtmlContent; ?>" name="talk_content" id="talk_content<?php echo $arrVal['id']; ?>"/>
		  
        <?php
					//echo '<div class="flLt"><a href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$arrVal['id'] .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'\' ,\'\',\'width=850,height=500,scrollbars=yes\') "><img src='.base_url().'images/talk.gif alt='.$this->lang->line("txt_Talk").' title="'.$latestTalk.'" border=0></a></div>&nbsp;';
					
					}
					
					?>
        <div class="userLabelNoFloat flLt"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['editedDate'], $this->config->item('date_format')); ?> </div>
		<div class="clr"></div>						
        <?php
				 if($arrVal['isTree']==1)
				  {
				  
				 ?>
        <?php  echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['leaf_id'].'  style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>'; 
				
				  }else
				  {
				  
				  ?>
				  
				  <a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal['leaf_id'];?>#contactLeafContent<?php echo $arrVal['leaf_id'];?>"> <?php echo $this->identity_db_manager->formatContent($arrVal['content'],1000,1); ?> </a>
				  
				  <?php
				  
				 //echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal['leaf_id'].' style="text-decoration:none; color:#000;">'.$arrVal['content'].'</a>';  
				  ?>

        <?php
				  
				  }
				?>
      </div>
          <span id="spanArtifactLinks<?php echo $arrVal['nodeId'];?>" style="display:none;"></span> <span id="spanTagView<?php echo $arrVal['nodeId'];?>" style="display:none;"> <span id="spanTagViewInner<?php echo $arrVal['nodeId'];?>">
          <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">
            <?php	
				$tagAvlStatus = 0;				
				
				?>
          </div>
          </span> </span>
          <?php	
				#*********************************************** Tags ********************************************************																		
				?>
          <?php } ?>
        </div>
    <!-- Main Body Container ends here --> 
  </div>
    </div>
<?php $this->load->view('common/foot.php');?>
<?php $this->load->view('common/footer');?>
</body>
    </html>
<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".example7").colorbox({width:"<?php echo $this->config->item('page_width')+50;?>px", height:"500px", iframe:true});
		});
	</script>