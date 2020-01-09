<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?>
<?php 

	//arun-session variable used to hold timastamp for chat view in realtime 
	$_SESSION['chatTimeStamp']='';

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--/*Changed by Surbhi IV*/-->
	<title>Discuss ><?php echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>') ?></title>
	<!--/*End of Changed by Surbhi IV*/-->
	<?php $this->load->view('common/view_head.php');?>
	<?php $this->load->view('editor/editor_js.php');?>
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
	<!--Manoj: Back to top scroll script-->
	<?php $this->load->view('common/scroll_to_top'); ?>
	<!--Manoj: code end-->
	</head>
	<body class="bodyNewBackgroundColor">
<div id="wrap1">
      <div id="header-wrap">
    <?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/wp_header'); ?>
    <!-- remove common/artifact_tabs view-->
  </div>
    </div>
<div id="container">
        <div id="leftSideBar" class="leftSideBar"><?php $this->load->view('common/left_menu_bar'); ?>
            </div>
      <!-- Commented by Dashrath- change div id-->
      <!-- <div id="content">  -->
      <div id="rightSideBar"> 
      <!-- Dashrath -->

    <!-- Main menu -->
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
    <!-- Main Body -->
    
    <!-- commented by- Dashrath -->
    <!-- <?php $this->load->view('discuss/discuss_real_time_menu'); ?> -->
    <?php $position=0;
	$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);

			if ($treeId == $this->uri->segment(8))
				$nodeBgColor = 'nodeBgColorSelect';
			else
				$nodeBgColor = 'seedBgColor';
?>
    <!---------  Seed div starts here ---->
    
    <div id="divSeed" class="seedBackgroundColorNew" >

        <!-- Div contains tabs start-->
        <?php $this->load->view('discuss/discuss_seed_header'); ?>
        <!-- Div contains tabs end-->

          <!-- Commented by Dashrath -->
          <!-- <div  style="height:30px; ">  -->
        
            <!--       my tyest           -->
          
            <!-- <div id="ulNodesHeader0" class="ulNodesHeader" style="float:right; display:none " >
                  <?php 
    					if($arrDiscussionDetails["userId"]==$_SESSION["userId"]){
    					?>
                <div style="float:left; margin-right:10px;" class="selCont">
                    <div class="newListSelected" tabindex="0" style="position: relative; ">
                      <div class="selectedTxt" onclick="showTreeOptions()" ></div>
                      <ul id="ulTreeOption" style="visibility: visible; width: 50px; top: 19px; left: 0pt;  display: none;" class="newList">
                    <li><a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'stop_real_talk',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Stop'); ?></a></li>
                    </ul>
                    </div>
                </div>
                  <?php
    					}?>
            </div>
            <div class="clr"></div> -->
            
        <!-- </div> -->

        <!-- Dashrath-->
          <div>
        <div   class="clsNoteTreeHeader handCursor"  >
              <div id="treeContent"  style="display:block;" class="<?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">
            <?php
                            echo strip_tags(stripslashes($arrDiscussionDetails['name']),'<b><em><span><img>');  
                    ?>
          </div>
              <?php
                            if (!empty($arrDiscussionDetails['old_name']))
                            {
                                    echo '<div class=" floatLeft txtPreviousName">(Previous Name  &nbsp; :&nbsp; </div><div id="oldNameContainer" class=" floatLeft txtPreviousName "> ' .strip_tags(stripslashes($arrDiscussionDetails['old_name']),'<span><img>').')</div>';
                            }
                    ?>
            </div>
        <div class="clsNoteTreeHeaderLeft" >
              <div id="divAutoNumbering" style="display:none; float:right " > </div>
              
              <!-- ---------------------- move tree code starts --------------------------------------------------------------------------------------------------------------- -->
              <div id="spanMoveTree" style="float:right; text-align:right" >
            <input type="hidden" id="selWorkSpaceType" name="selWorkSpaceType" value="" />
            <input type="hidden" id="seltreeId" name="seltreeId" value="<?php echo $treeId; ?>" />
            <div class="lblMoveTree" > Move tree to:</div>
            <div class="floatLeft">
                  <?php   
                        if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
                        {   
                            $subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
                            $workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
                            $workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
                        ?>
                  <select name="select" id="selWorkSpaceId" onChange="setUserList(this,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>)" >
                <?php 
                    if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
                    {
                    ?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
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
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
                        ?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
						}
                        $subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
                      
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
									$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1)
										{
                                ?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
								}
                                }
                            }
                    }
                    }
                    else
                    {
                    ?>
                <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
                <?php if($workSpaceId){ ?>
                <option value="0" ><?php echo $this->lang->line('txt_My_Workspace'); ?></option>
                <?php } ?>
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
							$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['workSpaceId'],1);
							if($treeTypeStatus!=1 || $workSpaceData['workSpaceName']=='Try Teeme')
							{
						?>
                <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
                <?php
							}
                        }
                        $subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
                     
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
										$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceData['subWorkSpaceId'],2);
										if($treeTypeStatus!=1)
										{
                                ?>
                <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
                <?php
										}
                                    }
                                }
                            }
                    }
                    
                    }
                    ?>
              </select>
                  <?php
                }
                ?>
                </div>
            <div  class="floatLeft" id="divselectMoveToUser"  > </div>
            &nbsp;<img title="<?php echo  $this->lang->line("txt_Close"); ?>"  src="<?php echo base_url();?>images/close.png" onClick=" hideSpanMoveTree()" style="margin-top:-2px;"  border="0"  /> </div>
              
              <!-- -------------------------------------------------move tree code close here -------------------------------------------------------------- --> 
              
            </div>


             <!-- discuss seed footer start-->
        <div class="commonSeedFooter">
            <!-- footer left content start -->
            <div class="commonSeedFooterLeft">

                <span class="commonSeedLeafSpanLeft">
                    &nbsp;
                </span>

            </div>
            <!-- footer left content end -->
            <!-- footer right content start -->
            <div class="commonSeedFooterRight">

                <!--dropdown content start -->
                <span class="commonSeedLeafSpanRight">
                    <?php 
                        if($arrDiscussionDetails["userId"]==$_SESSION["userId"]){
                        ?>
                        <div style="float:left; margin-right:10px;" class="selCont">
                            <div class="newListSelected" tabindex="0" style="position: relative; ">
                              <div class="selectedTxt" onclick="showTreeOptions()" ></div>
                              <ul id="ulTreeOption" style="visibility: visible; width: 50px; top: 19px; left: 0pt;  display: none;" class="newList">
                            <?php
                            if($arrDiscussionDetails["status"]==1)
                            {
                            ?>
                                <li>
                                    <a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'stop_real_talk',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Stop'); ?>
                                    </a>
                                </li>
                            <?php
                            }
                            else
                            {
                            ?>
                                <li>
                                    <a href="JavaScript:void(0);" onclick="treeOperationsChat(this,'start_real_talk',<?php echo $treeId; ?>)" ><?php echo $this->lang->line('txt_Start'); ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                            </div>
                        </div>
                          <?php
                        }?>
                </span>
                <!--dropdown content end -->

                <!--create date start-->
                <span class="commonSeedLeafSpanRight tagStyleNew">
                    <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['editedDate'], $this->config->item('date_format'));?>
                </span>
                <!--create date end-->

                <!--tag name start-->
                <span class="commonSeedLeafSpanRight tagStyleNew">
                    <?php echo $userDetails['userTagName'];?> 
                </span>
                <!--tag name end-->
            </div>
            <!-- footer right content end -->
        </div>
        <!-- discuss seed footer end-->
       <!--  <div style="height:65px;">
              <div id="normalView0" class="normalView" style="display:none" >
            <div class="lblNotesDetails"   >
                  <div class="style2" style="width:920px" ><?php echo $userDetails['userTagName'];?>&nbsp;&nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussionDetails['editedDate'], $this->config->item('date_format'));?> </div>
                </div>
          </div>
              <div class=" lblTagName" > </div>
            </div> -->
      </div>
          <div class="divLinkFrame" >
        <div id="linkIframeId0" style="display:none;"></div>
      </div>
          <span id="spanArtifactLinks0" style="display:none;"></span>
          <?php
    		
            #********************************************* Tags ********************************************************88
            
            $dispViewTags = '';
            $dispResponseTags = '';
            $dispContactTags = '';
            $dispUserTags = '';
            $nodeTagStatus = 0;	
            ?>
          <div id="spanTagView0" style="display:none;">
        <div id="spanTagViewInner0">
              <div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; ">
            <?php	
            $tagAvlStatus = 0;				
            if(count($viewTags) > 0)
            {
                $tagAvlStatus = 1;	
                foreach($viewTags as $tagData)
                {													
                    $dispViewTags .= $tagData['tagName'].', ';						 
                }
            }					
            if(count($contactTags) > 0)
            {
                $tagAvlStatus = 1;	
                foreach($contactTags as $tagData)
                {
                    $dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
                }
            }
            if(count($userTags) > 0)
            {
                $tagAvlStatus = 1;	
                foreach($userTags as $tagData)
                {
                    $dispUserTags .= $tagData['userTagName'].', ';						
                }
            }
            if(count($actTags) > 0)
            {
                $tagAvlStatus = 1;	
                foreach($actTags as $tagData)
                {
                    $dispResponseTags .= $tagData['comments'].' [';							
                    $response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
                    if(!$response)
                    {
                        if ($tagData['tag']==1)
                            $dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
                        if ($tagData['tag']==2)
                            $dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
                        if ($tagData['tag']==3)
                            $dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
                        if ($tagData['tag']==4)
                            $dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
                    }
                    $dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
                    
                    $dispResponseTags .= '], ';
                }
            }
            
            
            ?>
          </div>
            </div>
        <div class="divTagsButton" style="width:auto" >
              <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagViewNew(0)" />
              <span id="spanTagNew0">
          <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(0,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $treeId; ?>,1,0,1,0)" />
          </span> </div>
      </div>
          <?php	
            #*********************************************** Tags ********************************************************																		
            ?>
          <div class="clr"></div>
        </div>
    
    <!---------  Seed div closes here ---->
    
    <?php
				if($pnodeId){?>
    <div id="<?php echo $position++;?>" >
          <?php
				if($pnodeId){ echo stripslashes($DiscussionPerent['contents']);}else{
				
				?>
          <?php echo $arrDiscussionDetails['name']; ?>
          <?php	
				}
				 ?>
          <br>
        </div>
    <?php	  }else{$position++;}
				 ?>
     <!--Commented by Dashrath- Comment old div code and new div with if else condition below with some changes for div fixed above editor-->
    <!-- <div style="height:300; width:100%; overflow:hidden">
          <div id="chat_msg" style="width:100%" >&nbsp;</div>
    </div> -->

    <!--Added by Dashrath- Add for fixed div above editor-->
    <?php 
    if($arrDiscussionDetails["status"]==1)
    {
    ?>
        <div id="chat_msg_outer" style="overflow-x: hidden; overflow-y: scroll;">
              <div id="chat_msg" style="" >&nbsp;</div>
        </div>
    <?php
    }
    else
    {
    ?>
        <div style="height:300; width:100%; overflow:hidden">
              <div id="chat_msg" style="width:100%" >&nbsp;</div>
        </div>
    <?php
    }
    ?>
    <!--Dashrath- code end-->

    <br>
    <div class="clr"></div>
    <!-- Added by Dashrath- check tree start or stop 1 for start and 0 for stop-->
    <?php 
    if($arrDiscussionDetails["status"]==1)
    {
    ?>

    <!--Commented by Dashrath- Comment old span and new span below with some style for editor fixed in bottom-->
    <!-- <span id="reply0"> -->
    <span id="reply0" style="bottom: 0;">
    <!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
	<div class="talkformchat handCursor">
        <form name="form10" method="post" action="<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>" style="margin-left: 0.5%; width: 99%;">
      <span id="chatTopicMsg" style="display:none;"> <?php echo "<img src='".base_url()."images/addnew.png'   border='0'><span style='margin-left:5px; font-weight:bold;'>Comment : </span> "; ?> </span> <span id="chatTopic"></span>
      <div><a name="focusContentArea"></a> <span id="contentArea"><img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ><span style="margin-left:5px" ><strong><?php echo $this->lang->line('txt_Topic');?>:</strong></span><br>
        <br>
        </span></div>
      <div>
            <textarea name="replyDiscussion0" id="replyDiscussion0"></textarea>
          </div>
      <div>
            <div id="loader"></div>
            <br>
            <span id="butReply" style="display:none;"> <a href="javascript:void(0);" onClick="validate_dis(0);">
			<!--Manoj: remove onclick for empty chat_msg in done button -->
            <input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done'); ?>" onclick="" style="float:left;"/>
            </a> </span> <span id="butTopic"> <a href="javascript:void(0);" onClick="nodeId=0; document.getElementById('butCancel').style.display = 'none';document.getElementById('butTopicCancel').style.display = '';document.getElementById('chatTopic').innerHTML = '';document.getElementById('chatTopicMsg').style.display= 'none';validate_dis(0);">
            <input type="button"  class="button01" value="<?php echo $this->lang->line('txt_Done'); ?>" style="float:left;"/>
            </a> </span> <span id="butCancel" style="display:none;"> <a href="javascript:void(0);" onClick="cancel(); request_refresh('1');">
            <input type="button"  class=" button01" value="<?php echo $this->lang->line('txt_Cancel'); ?>" style="float:left;" />
            </a> </span> <span id="butTopicCancel"> <a href="javascript:void(0);" onClick="cancel(); request_refresh('1');">
            <input type="button"  class="button01" value="<?php echo $this->lang->line('txt_Cancel'); ?>" style="float:left;" />
            </a> </span>
			<input name="realTime" type="hidden" id="realTime" value="1">
            <input name="reply" type="hidden" id="reply" value="1">
            <input name="editorname1" type="hidden" value="replyDiscussion">
            <input name="treeId" type="hidden" id="treeId" value="<?php echo $treeId;?>">
            <input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
            <input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
			<div class="clear"></div>
           <div id="audioRecordBox" style="margin-left:0.6%;"><div style="float:left;margin-top:0.3%;  margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></div>
		  </div>
		 
    </form>
	</div>
	 
        </span> 

    <?php
    }
    ?>

    </div>

    <!--Added by Dashrath- load notification side bar-->
    <?php $this->load->view('common/notification_sidebar.php');?>
    <!--Dashrath- code end-->
    
    </div>
<?php $this->load->view('common/foot.php');?>
<!--footer remove -->
</body>
</html>
<script type="text/javascript">
function getfocus()
{
	document.getElementById('replyDiscussion0').focus();
}
var chatReplyNodeId = '';
function compareDates (dat1, dat2) 
{
	var date1, date2;
	var month1, month2;
	var year1, year2;
	value1 = dat1.substring (0, dat1.indexOf (" "));
	value2 = dat2.substring (0, dat2.indexOf (" "));
	time1= dat1.substring (1, dat1.indexOf (" "));
	time2= dat2.substring (1, dat2.indexOf (" "));	
	hours1= time1.substring (0, time1.indexOf (":"));
	minites1= time1.substring (1, time1.indexOf (":"));	
	hours2= time2.substring (0, time2.indexOf (":"));
	minites2= time2.substring (1, time2.indexOf (":"));	  
	year1 = value1.substring (0, value1.indexOf ("-"));
	month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
	date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
   else return 0;
} 

var request_refresh_point=1;
var nodeId='';
function validate_dis(nodeId) 
{ 
		treeId=$('#treeId').val();
		//alert(treeId+'=='+workSpaceId+'=='+workSpaceType);
	
		if(workSpaceId=='')
		{
			workSpaceId = $('#workSpaceId').val();
		}
		var leaf_data="&treeId="+treeId+"&nodeId=&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType=3";
					$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							
							//alert(result);
							
							result = result.split("|||");
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								return false;
							}
							else
							{
	chatReplyNodeId = nodeId;
	var error=''	
	var replyDiscussion = 'replyDiscussion'+nodeId;
	
	if (getvaluefromEditor(replyDiscussion) == ''){
		error+='<?php echo $this->lang->line('txt_enter');?>';
	}

	var thisdate = new Date();
	var curr_datetouse=thisdate.getYear()+'-'+thisdate.getMonth()+'-'+thisdate.getDate()+' '+thisdate.getHours()+':'+thisdate.getMinutes();
	if(error=='')
	{
		$("#loader").html("<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
		request_refresh_point=0;
		request_send();
	}
	else
	{
		jAlert(error);
	}
	} //else end
	} //success end
	});
}
function getHTTPObjectm() { 
	var xmlhttp; 
	if(window.XMLHttpRequest){ 
		xmlhttp = new XMLHttpRequest(); 
	}else if(window.ActiveXObject){ 
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		if(!xmlhttp){ 
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
		} 
	} 
	return xmlhttp; 
} 
var http1 = getHTTPObjectm();
var replay_target=1;
var start_chat_val=1;
function handleHttpResponsem1() 
{    
	if(http1.readyState == 4) { 
		if(http1.status==200) { 
			var results=http1.responseText; 
			
			 if(results=='0'){
			  	jAlert('This duscission has been stopped. You cannot submit a new topic.');return;
			 }
			 
			//Manoj: Get the id of active chat box 
				/*var active_nodeId = $('.active_chat').attr("id");
				if(active_nodeId !== undefined )
				{
					document.getElementById('chat_msg').innerHTML ='';	
				}*/
			//Manoj: code end
			//Comment chat message for current topic
			//document.getElementById('chat_msg').innerHTML +=results;
			
			
			//Manoj: Hide all topics , start & stop time except selected topic
			/*if(active_nodeId !== undefined )
			{
				$('.chat_box').hide();
				$('.chatSessionBGStop').hide();
				$('.chatSessionBGStart').hide();
				$('#'+active_nodeId).show();	
				$('#'+active_nodeId).addClass('active_chat');
			}*/
			//Manoj: code end
			
			document.getElementById('replyDiscussion'+chatReplyNodeId).value='';
		
			if(reply==1){
				$("#butReply").show();
				$("#butCancel").show();
			}
			
			$("#loader").html("");
			$(".fr-element").html("");
			reply=0;
			setValueIntoEditor ('replyDiscussion0','');
			request_refresh_point=1;
			
		}
	}
}
function request_send()
{	

	if(replay_target)
	{
		var jsData = getvaluefromEditor('replyDiscussion0');
		urlm='<?php echo base_url();?>new_chat/start_Chat/<?php echo $pnodeId;?>/1';
		data='reply=1&vks=1&editorname1=replyDiscussion&treeId=<?php echo $treeId;?>&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+encodeURIComponent(getvaluefromEditor('replyDiscussion0','simple'));
	}
	else
	{	
		urlm='<?php echo base_url();?>new_chat/index/<?php echo $treeId;?>/1';
		data='reply=1&editorname1=replyDiscussion&nodeId='+nodeId+'&workSpaceId=<?php echo $workSpaceId;?>&workSpaceType=<?php echo $workSpaceType;?>&replyDiscussion='+encodeURIComponent(getvaluefromEditor('replyDiscussion0','simple'));
	}
	
	http1.open("POST", urlm, true); 
	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.onreadystatechange = handleHttpResponsem1;     
	http1.send(data);
}

var http2 = getHTTPObjectm();
function handleHttpResponsem_once() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) { 
			var results=http2.responseText;		
		
			document.getElementById('chat_msg').innerHTML= results;
		
			scrollToElement($("#reply0"));
		}
	}
}

function handleHttpResponsem2() 
{    
	if(http2.readyState == 4) { 
		if(http2.status==200) {
		
			var results=http2.responseText;
			
			//Manoj: Get the id of active chat box on each refresh
			/*var active_nodeId = $('.active_chat').attr("id");
			if(active_nodeId !== undefined )
			{
				document.getElementById('chat_msg').innerHTML ='';	
			}*/
			//Manoj: code end
			$("#totalNodes").remove();
			$("#totalCommentNodes").remove();
			$("#focusDown").remove();
			//document.getElementById('chat_msg').innerHTML = results;
			//alert(results);
			$("#chat_msg").append(results);
			
			//document.getElementById('chat_msg').innerHTML = results;
			
			//Manoj: Hide all topics , start & stop time except selected topic
			/*if(active_nodeId !== undefined )
			{
				$('.chat_box').hide();
				$('.chatSessionBGStop').hide();
				$('.chatSessionBGStart').hide();
				$('#'+active_nodeId).show();	
				$('#'+active_nodeId).addClass('active_chat');
			}*/
			//Manoj: code end
			
			document.getElementById("chat_msg").scrollTop = document.getElementById("chat_msg").scrollHeight;
		}
	}
}

function focusScroll()
{		
	document.getElementById('focusViewArea').focus();
}

function request_refresh(chat_refresh){
		var current_chat_id=$('.currentChatId').attr("id");
		//alert(current_chat_id);
		var realTimeDivIds;
		var realtimeChatCommentDivIds;
		if(request_refresh_point){
		
		if(document.getElementById("totalNodes"))
		{
			realTimeDivIds=document.getElementById('totalNodes').value;
		}
		if(document.getElementById("totalCommentNodes"))
		{
			realtimeChatCommentDivIds=document.getElementById('totalCommentNodes').value;
		}
		//alert(realTimeDivIds);
		
		if(current_chat_id!==undefined && chat_refresh!=1)
		{
			url='<?php echo base_url();?>view_chat/realTimeChatOrder/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/'+current_chat_id+'?realtimeChatCommentDivIds='+realtimeChatCommentDivIds;
		}
		else
		{	
			url='<?php echo base_url();?>view_chat/node_calendar/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>?realTimeDivIds='+realTimeDivIds;
		}
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem2; 
		http2.send(null);

	}
}

function request_refresh_once(){
		if(request_refresh_point){
		url='<?php echo base_url();?>view_chat/node_calendar/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>';
	
		http2.open("GET", url,true); 
 		http2.onreadystatechange = handleHttpResponsem_once; 
		http2.send(null); 
		
	}
}

var reply=0;
function showReply(focusId, nodeId)
{
	reply=1;
	var replySpanId = 'reply'+focusId;
	var contentEditorId = 'replyDiscussion'+focusId;
	document.getElementById(replySpanId).style.display = '';		
	if(nodeId == 0)
	{
		document.getElementById('butReply').style.display 		= 'none';
		document.getElementById('butTopic').style.display 		= '';
		document.getElementById('butCancel').style.display 		= 'none';
		document.getElementById('butTopicCancel').style.display = '';
		document.getElementById('chatTopic').innerHTML			= '';
		document.getElementById('contentArea').innerHTML		= '<img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ><span style="margin-left:5px" ><strong><?php echo $this->lang->line('txt_Topic');?>:</strong></span><br><br>';
		document.getElementById('chatTopicMsg').style.display	= 'none';
	}
	else
	{
		document.getElementById('butReply').style.display 		= '';
		document.getElementById('butTopic').style.display 		= 'none';
		document.getElementById('butCancel').style.display 		= '';
		document.getElementById('butTopicCancel').style.display = 'none';	
		document.getElementById('contentArea').innerHTML		= '';	
	}
	document.getElementById('replyDiscussion0').value = '';

	if(nodeId > 0)
	{
		url='<?php echo base_url();?>view_chat/show_topic/<?php echo $treeId;?>/'+nodeId+'/type/<?php echo $workSpaceType;?>';	
		http2.open("GET", url,true); 
		http2.onreadystatechange = handleHttpResponseTopic; 
		http2.send(null);
	}
}
function handleHttpResponseTopic() 
{    
	if(http2.readyState == 4)
	{ 
		if(http2.status==200) 
		{ 
			//Manoj: Hide all topics , start & stop time except selected topic
			
			$('.chat_box').hide();
			$('.chatSessionBGStop').hide();
			$('.chatSessionBGStart').hide();
			$('#chat_block'+nodeId).show();
			//$('#chat_block'+nodeId).addClass('active_chat');
			
			//Manoj: code end
			
			var results=http2.responseText; 
			document.getElementById('chatTopicMsg').style.display	= '';	
			
            /*Commented by Dashrath- comment olod code and new code below for set limit topic content*/
            // document.getElementById('chatTopic').innerHTML			= results+'<br><br>';
			
            /*Added by Dashrath- Add for set content limit for display topic*/
            if(results.length > 100)
            {
               var updateResult = results.substring(0,100)+'...';
               document.getElementById('chatTopic').innerHTML = updateResult+'<br><br>'; 
            }
            else
            {
                document.getElementById('chatTopic').innerHTML = results+'<br><br>';
            }
            /*Dashrath- code end*/ 
		}
	}
}
function hideReply(nodeId)
{
	var replySpanId = 'reply'+nodeId;
	document.getElementById(replySpanId).style.display = 'none';			
}
function cancel()
{
	//Manoj: On cancel showing all topics, start & stop time
	//alert('test');
		$(".currentChatId").remove();
		$(".SingleDiscussPage").remove();
		$('.chat_box').show();
		$('.chatSessionBGStop').show();
		$('.chatSessionBGStart').show();
		//$('#chat_block'+nodeId).removeClass('active_chat');
		
	//Manoj: code end
	//Manoj: clear froala editor 
	$(".fr-element").html("");
	setValueIntoEditor ('replyDiscussion0','','simple');
	
	replay_target=1;
	document.getElementById('butReply').style.display 		= 'none';
	document.getElementById('butTopic').style.display 		= '';
	document.getElementById('butCancel').style.display 		= 'none';
	document.getElementById('butTopicCancel').style.display = '';
	document.getElementById('chatTopic').innerHTML			= '';
	document.getElementById('contentArea').innerHTML		= '<img src="<?php echo  base_url(); ?>images/addnew.png"  title="<?php echo $this->lang->line("txt_Add"); ?>" border="0" ><span style="margin-left:5px" ><strong><?php echo $this->lang->line('txt_Topic');?>:</strong></span><br><br>';
	document.getElementById('chatTopicMsg').style.display	= 'none';
}
</script>
<script>
request_refresh_once();
chnage_textarea_to_editor('replyDiscussion0','');

//Changed by Dashrath - change time 20000 to 10000
setInterval("request_refresh()", 10000);
function scrollToElement(ele) {

    //show editor in focus
    $(window).scrollTop(ele.offset().top).scrollLeft(ele.offset().left);
}

//Real time view Chat order 19-01-17
function real_time_chat_order(treeId,workSpaceId,workSpaceType,commentNodeId,topicId)
{
	if(commentNodeId==0)
	{
		nodeId=topicId;
	}
	else
	{
		nodeId=commentNodeId;
	}
	//$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType
	//alert('test');
	$.ajax({
		type: "POST",
		url: baseUrl+"view_chat/realTimeChatOrder/"+treeId+"/"+workSpaceId+"/type/"+workSpaceType+"/"+nodeId,
		success:  function(data){
			//alert(data);
		 	$('#chat_msg').html(data);
		}
	 });
}
</script>

<script>
$(window).scroll(function(){
      // if ($(this).scrollTop() > 60) {
      //     $('#divSeed').addClass('documentTreeFixed');
      // } else {
      //     $('#divSeed').removeClass('documentTreeFixed');
      // }

      //call addAndRemoveClassOnSeed function
      addAndRemoveClassOnSeed($(this).scrollTop());
  });
</script>

<!--Added by Dashrath- make topic comment div hide dynamic and hide scroll icon top and bottom-->
<script>
    $(document).ready(function(){
        var seedDivHeight=document.getElementById('divSeed').offsetHeight
        var y=$(window).height();
        var newHeight= y-410-seedDivHeight;
        $("#chat_msg_outer").css('height', newHeight);

        //set padding-bottom 0px
        $('#container').css('padding-bottom','0px');
    });

    document.onreadystatechange = function () {
      if (document.readyState === 'complete') {
        //hide scroll top bottom icon
        $('#scroll_bottom').hide();
        $('#scroll_top').hide(); 
      }
    }

</script>
<!--Dashrath- code end-->