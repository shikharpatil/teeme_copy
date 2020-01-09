<?php

$workPlaceDetails 	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

if($newMessageCount>=0){

	if($newMessageCount==0){

		die;

	}?>

	<div id="viewMore" style="width:100%;text-align:center;color: #898686;font-weight: bold;line-height: 40px;text-decoration: none;clear:both;">

    	<a href="javascript:void(0);" onclick="countMessages = 0;getNewMessages();"><?php echo $newMessageCount." ";?>New Message<?php echo ($newMessageCount>1)?'s':'';?></a>

    </div>

<?php

	die;

}

else{?>



<div>

  <!-- Start Full Tree Container -->

  <div style="float:left;"> </div>

  <!-- End Main body container -->

    <!-- Main body div starts -->

    <?php $nodeBgColor = 'seedBgColor'; ?>

    <div style="background:#DEDFE2; width:100%;" >

      <!-- Seed div starts -->

      <?php

	  //added for view more

	// echo $this->uri->segment(9);

	 if($this->uri->segment(9)==0 && $newMessageCount==-1)

	 {?>

      <div class="handCursor" style="float:left;width:100%;padding-bottom:2px;background:#DEDFE2;" >

        <div style="float:left; padding-left:2%; padding-top:10px;width:28% " class="msg_user_img">
		
		 <?php
								if ($Profiledetail['photo']!='noimage.jpg')
								{
							?>
									 <img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $Profiledetail['photo'];?>" border="0"  width="70" height="70" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $Profiledetail['photo'];?>" border="0"  width="70" height="70" id="imgName"> 
							<?php
								}
							?>
		 
		 
		 
		 </div>

        <div style="float:left;padding-top:10px;padding-left:2%;width:68%;">

          <?php if (in_array($Profiledetail['userId'],$onlineUsers)) {echo '<img src='.base_url().'images/online_user.gif width=15 height=16 />'; } else {echo '<img src='.base_url().'images/offline_user.gif width=15 height=16 />';}?>

          <?php

										echo '<b>' .strip_tags($Profiledetail['firstName'].' '.$Profiledetail['lastName'],'<b><em><span><img>') .'</b>';									 

									?>

          <br>

          <span class="member_status"> <?php echo $this->lang->line('txt_Status');?> : <?php echo stripslashes($Profiledetail['statusUpdate']);?>

          <?php 

			if ($Profiledetail['userId'] == $_SESSION['userId'])

			{

			?>

          <a href="javascript:void(0)" onClick="if(document.getElementById('statusUpdate').style.display=='none') { document.getElementById('statusUpdate').style.display='block';} else { document.getElementById('statusUpdate').style.display='none';}">

          <!--<?php //echo $this->lang->line('txt_Edit');?>-->

          <img border="0" title="Edit Status" alt="Edit" src="<?php echo base_url() ?>/images/editnew.png" style="margin-left:25px;"></a>

          <?php

			}

			?>

          </span> <span id="statusUpdate" style="display:none;">

          <form action="" method="post">

            <textarea name="statusUpdate" resize="none"  id="statusUpdate1" style="border: 1px solid rgb(136, 136, 136);height:80px; min-height: 80px; max-height: 80px;" ><?php echo stripslashes($Profiledetail['statusUpdate']);?></textarea>

            <input type="hidden" name="memberId" id="memberId" class="hidden" value="<?php echo $Profiledetail['userId'];?>" />

            <br />

            <input type="hidden" name="workSpaceId" id="workSpaceId" class="hidden" value="<?php echo $workSpaceId;?>"/>

            <input type="hidden" name="workSpaceType" id="workSpaceType" class="hidden" value="<?php echo $workSpaceType;?>"/>

            <input type="hidden" name="workSpaceId_search_user" id="workSpaceId_search_user" class="hidden" value="<?php echo $workSpaceId_search_user;?>"/>

            <input type="hidden" name="workSpaceType_search_user" id="workSpaceType_search_user" class="hidden" value="<?php echo $workSpaceType_search_user;?>"/>

            <input type="button" onclick="updateStatus('<?php echo base_url();?>edit_workplace_member/updateMemberStatusUpdate');" name="submitStatusUpdate" value="<?php echo $this->lang->line('txt_Post');?>"  class="buttonLogin" />

            <input type="reset" name="cancelStautsUpdate"  value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="if(document.getElementById('statusUpdate').style.display=='none') { document.getElementById('statusUpdate').style.display='block';document.getElementById('normalView0').style.display='block';} else { document.getElementById('statusUpdate').style.display='none';}" class="buttonLogin">

          </form>

          </span> </div>

        <div style="float:right;"> </div>

      </div>

      <div id="normalView0" style="width:100%; float:left;background:#DEDFE2;" >

        <div style="width:<?php echo ($this->config->item('page_width')/10)-3;?>%; padding-left:10px; word-wrap: break-word;" class="<?php echo $nodeBgColor; ?>" id="userDetail"> <div style="float:left; width:35%;"><?php if($Profiledetail['userTagName']){ echo $this->lang->line('txt_Tag_Name');?>:</div><div style="width:62%; float:left;"><?php echo $Profiledetail['userTagName'];}?></div>
		<div style="clear:both;"></div>
<div style="float:left; width:35%; margin-top:3%;"> <?php if($Profiledetail['userName']){echo $this->lang->line('txt_Email');?>:</div><div style="width:62%; float:left; margin-top:3%;"> <?php echo $Profiledetail['userName'];}?></div>
<div style="clear:both;"></div>
<div style="float:left; width:35%; margin-top:3%;"> <?php if($Profiledetail['phone']){echo $this->lang->line('txt_Telephone');?>: </div><div style="width:62%; float:left; margin-top:3%;"><?php echo $Profiledetail['phone'];}?></div>
<div style="clear:both;"></div>
<div style="float:left; width:35%; margin-top:3%;"> <?php if($Profiledetail['mobile']){echo $this->lang->line('txt_Mobile');?>:</div><div style="width:62%; float:left; margin-top:3%;"> <?php echo $Profiledetail['mobile'];}?> </div></div>

        <div style="" class="<?php echo $nodeBgColor; ?>">

          <!--<a href="javascript:reply(0,0);"><?php //echo $this->lang->line('txt_Add_new_message');?></a>-->

          <a href="javascript:showProfileDetails();"><span id="hideShowDetails">

          <?php //echo $this->lang->line('txt_View_Full_Details');?>

          <img border="0" title="<?php echo $this->lang->line('txt_View_Full_Details');?>" src="<?php echo base_url(); ?>/images/show_icon.png"></span></a>

          <?php

			if ($Profiledetail['userId']==$_SESSION['userId'])

			{

			?>

          <!--<a href="javascript:void(0);" onClick="profileEdit()"><?php //echo $this->lang->line('txt_Edit_Profile');?></a>-->

         <!-- <span style="float:right;"><a href="javascript:void(0);" onClick="profileEdit()"><img border="0" title="Edit" src="<?php echo base_url(); ?>/images/editnew.png"></a></span>&nbsp;&nbsp;-->

          <?php

			}

			?>

        </div>

      </div>

      

     

      <div style="padding-left:10px; float:left;" class="formSubmitMessages"> <?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg']	= '';?> </div>

      <div id="profileDetails" style="float:left; display:none;background:#DEDFE2;width:95%;padding-left:3%;" >

        <?php 

		if(count($Profiledetail))

		{

		?>

        <div style=" float:left;"> <strong><?php echo $this->lang->line('txt_Personal_Details');?></strong> </div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;" ><?php echo $this->lang->line('txt_Title');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['userTitle'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_First_Name');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['firstName'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Last_Name');?>:</div>

        <div style="width:60%;float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['lastName'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Role');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['role'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Department');?>:</div>

        <div style="width:60%;float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['department'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%;float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Tag_Name');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['userTagName'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Email');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['userName'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Mobile');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['mobile'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Telephone');?>:</div>

        <div style="width:60%; float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['phone'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Address');?>:</div>

        <div style="width:60%;float:left; word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['address1'];?>&nbsp;</div>

        <div class="clr"></div>

        <div style="width:35%; float:left; margin-top:6%;"><?php echo $this->lang->line('txt_Other');?>:</div>

        <div style="width:60%;float:left;word-wrap: break-word; margin-top:6%;"><?php echo $Profiledetail['other'];?>&nbsp;</div>

        <div class="clr"></div>

        <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" style="margin-top:10px;" onclick="hideBlock('profileDetails')" />

        <?php

			}

		

	

		?>

      </div>

      

      <div style="clear:both;"></div>

      <div class="menu_new" style="padding-right:10%;background:white;">

        <ul class="tab_menu_new">

          <li class=""><a href="<?php echo base_url()?>profile/index/<?php echo $this->uri->segment(3);  ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/1" style="margin-top: 9px;padding-left:11px; <?php if($this->uri->segment(7)==$this->uri->segment(4)) { ?>background:#999; color:#000;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>" id="curr" ><span>

            <?php if($workSpaceId){ ?>

            <?php echo $workSpaceName; ?>

            <?php } else { ?>

            My Space

            <?php } ?>

            </span></a></li>

          <li class="" ><a href="<?php echo base_url()?>profile/index/<?php echo $this->uri->segment(3);  ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/1/all"  title="<?php echo "All" ;?>" style="margin-top: 9px;padding-left:11px; <?php if($this->uri->segment(7)==0) { ?>background:#999; color:#000" class="active <?php } ?>" id="all">All</a></li>

          <li><a href="javascript:reply(0,0,'<?php echo $this->uri->segment(7) ?>');" style="margin-top: 11px;padding-left:11px;" id="add"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a></li>

        </ul>

        <div class="clr"></div>

      </div>

      

         <?php

	  ?>

      <div id="0notes" style="width:<?php echo ($this->config->item('page_width')/10)+2;?>%; padding-left:10px; float:left; display:none;" class="<?php echo $nodeBgColor; ?>">

        <form name="form10" id="form10" method="post" action="" >

          <textarea name="replyDiscussion0" id="replyDiscussion0" cols="75" rows="4"></textarea>
			
			<?php
		 if($workSpaceId==0){
			?>

          <br>

          <br>

          <?php echo $this->lang->line('txt_Select_Recepient(s)')." : "; ?><br>

          <br>

          <?php echo $this->lang->line('txt_Search')." : "; ?>

          <input type="text" id="searchTags" name="searchTags" onKeyUp="showTags()" size="50"/>

          &nbsp;&nbsp;

         <?php /*?> <input type="checkbox" name="urgent" id="urgent">

          <?php echo $this->lang->line('txt_Urgent');?><?php */?>

          <div id="showMan" style="height:120px;margin-left:45px; overflow:scroll; margin-bottom:30px; margin-top:0px; ">

            <?php if(count($workSpaceMembers_search_user)>0){ ?>

            <input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunction();"  />

            <?php echo $this->lang->line('txt_All');?><br />

            <?php } ?>

            <?php

				$i=1;			

				foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)

				{

					if($_SESSION['userId'] != $workPlaceMemberData['userId'] && $this->uri->segment(3)!=$workPlaceMemberData['userId'] ){						

				?>

<input type="checkbox" name="recipients[]" id="<?php echo 'recipients_'.$i ; ?>" value="<?php echo $workPlaceMemberData['userId'];?>"/ class="clsCheck" onclick="checkAllFunc()" >

<?php echo $workPlaceMemberData['tagName'];?><br />

<?php

				$i++;

					}

				}

				?>

          </div>
<?php

		  }

		  ?>
          <input style="float:left;" type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Post');?>" onClick="validate_dis('replyDiscussion0',document.form10,'<?php echo base_url();?>profile/addMyNotes/<?php echo $Profiledetail['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>','<?php echo $nodeOrder;?>');" class="button01" style="margin-left:0px" >

         

          <input style="float:left;" type="button" name="Replybutton1" value="<?php echo $this->lang->line('txt_Cancel');?>"  onClick="reply_close(0,'<?php echo $this->uri->segment(7) ?>');" class="button01">
		  	
		

          <input name="editorname1" type="hidden" value="replyDiscussion0">

          <input name="reply" type="hidden" id="reply" value="1">

          <input name="nodeOrder" type="hidden" id="reply" value="<?php echo $nodeOrder;?>">
		  
		  <div id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record" style="display:none; margin-left:2%; margin-top:0.4%; float:left;"></div></div>

        </form>
		
		

      </div>

      <?php

	  }?>

    </div>

    

    <!-- End seed container -->

    <!-- Begin Wall Comments -->

    <?php //echo $this->uri->segment(9);?>

    <div></div>

    <div <?php if($this->uri->segment(9)==0){?> id="allComment" <?php }?> class="allComment" >

      <?php 

		$focusId = 3;

		$totalNodes = array();



		$rowColor1='rowColor5';

		$rowColor2='rowColor6';	

		$rowColor3='nodeBgColorSelect';

		$limit = 10;

		if($limit%2==0){

			$i = 1;

		}

		else{

			$off = $this->uri->segment(9);

			if($off % 2 != 0){

				$i=2;

			}

			else{

				$i=1;

			}

		}

		if(count($ProfileNotes) > 0 )

		{ 

		?>

      <div style="float:left;width:97.8%">

        <?php

        $this->load->helper('form'); 

$attributes = array('name' => 'form2', 'id' => 'form2', 'method' => 'post', 'enctype' => 'multipart/form-data');	

//echo form_open('edit_leaf_save/index/doc/'.$this->input->get('doc'), $attributes);notes/editNotesContents/'+treeId1+'/'+workSpaceId1+'/type/'+workSpaceType1+

//echo form_open('profile/insertMessageReply/'.$this->uri->segment(3).'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user , $attributes);

?>

        <?php  

		$count=0;

 

		foreach($ProfileNotes as $keyVal=>$arrVal)

		{	 

		 

			$userDetails	= 	$this->profile_manager->getUserDetailsByUserId($arrVal['commenterId']);		



			if ( ($arrVal['urgent']==1|| $arrVal['notification']==1 ) && $arrVal['commenterId']!=$_SESSION['userId'])

			{

				$nodeBgColor = $rowColor3;

			}

			else

			{

				$nodeBgColor = ($i % 2) ? $rowColor2 : $rowColor1;

			}

	

			

			//if( ($arrVal['recipientId']==$_SESSION['userId']) || ($arrVal['commenterId']==$_SESSION['userId'] && $arrVal['recipientId']== $this->uri->segment(3) ) )

			//if( ($arrVal['recipientId']==$_SESSION['userId']) || ($arrVal['commenterId']==$_SESSION['userId']  ) )

			//Manoj: code for add space name 
			
			if ($arrVal['commentWorkSpaceId']==0)
			{
				$spaceStatus = 1;
				$isSpaceMember = 1;
			}
			else
			{
				if ($arrVal['commentWorkSpaceType']==2)
				{
					$workSpaceDetails1	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($arrVal['commentWorkSpaceId']);
					$workSpaceDetails1['workSpaceName'] = $workSpaceDetails1['subWorkSpaceName'];
					
					$isSpaceMember = $this->identity_db_manager->isSubWorkSpaceMember($arrVal['commentWorkSpaceId'],$_SESSION['userId']);
				}
				else
				{
					$workSpaceDetails1	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrVal['commentWorkSpaceId']);	
					
					$isSpaceMember = $this->identity_db_manager->isWorkSpaceMember($arrVal['commentWorkSpaceId'],$_SESSION['userId']);
				}	
				$spaceStatus = $workSpaceDetails1['status'];
			}
			if ($_SESSION['all'])
			{
				if ($workSpaceDetails1['workSpaceName']!="Try Teeme")
				{
					$showTryTeemeMessages = 1;
				}
				else
				{
					$showTryTeemeMessages = 0;
				}
				
/*				if ($userDetails['userGroup']>0)
				{
					$showGuestMessages = 1;
				}
				else
				{
					$showGuestMessages = 0;
				}*/
				$showGuestMessages = 1;
			}
			else
			{
				$showTryTeemeMessages = 1;
				$showGuestMessages = 1;
			}
			

			{ 

		?>

        <div onmouseover="$('.msg<?php echo $arrVal['id'];?>').show();" onmouseout="$('.msg<?php echo $arrVal['id'];?>').hide();" >

          <div style="padding-left:2.2%; float:left; padding-top:8%;width:100%; margin-top:8%;" class="<?php echo $nodeBgColor;?>">

            <!-- Div contains the total no of comments in messages  -->

            <div id="msgIcons_<?php echo $arrVal['id'];?>" class="msgIcons">

              <!--/* comment*/-->
			
			 

              <!-- <span style="float:right;padding-left:5px;"><?php //echo "# ".$this->profile_manager->getReplyByCommentId($arrVal['id'],0,'ASC',true);  ?></span> 	-->
				<div>
              <?php 

					

				if(($_SESSION['userId'] == $userDetails['userId']) || ($Profiledetail['userId']==$_SESSION['userId']) ||$arrVal['commenterId']==$_SESSION['userId'] )

				{		

				?>

              <span style="float:right;"><a style="margin-left:5px;"  href="javascript:void(0);" onClick="confirmDeleteComment('<?php echo base_url();?>profile/deleteComment/<?php echo $Profiledetail['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>/<?php echo $arrVal['id'];?>');"><img border="0" style="cursor:pointer;" title="Delete" alt="Delete" src="<?php echo base_url(); ?>images/icon_delete.gif">

              <?php //echo $this->lang->line('txt_Delete');?>

              </a> </span>
			 

              <!-- Arun- Convert chat in discuss 		

							&nbsp;&nbsp;<a href="<?php echo base_url();?>profile/convertMessageToDiscuss/<?php echo $Profiledetail['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>/<?php echo $arrVal['id'];?>" onClick="return confirmConvertMessageToDiscuss();"><?php echo $this->lang->line('txt_Convert_To_Discuss');?></a> -->

              <?php 

						//Arun only message owner move to discuss
						
						//Manoj: move icon hide after first move

						if($arrVal['commenterId']==$_SESSION['userId'] && $arrVal['status']!=2) { ?>

              <a  style="float:right; margin-left:5px;"  id="anchorMessage_<?php echo $arrVal['id'];?>" href="javaScript:void(0)" class="anchorMessage" onClick="return openConvertDiscussBlock(<?php echo $arrVal['id'];?>);" ><img src="<?php echo base_url(); ?>images/select-arrow1.png" />

              <?php //echo $this->lang->line('txt_Move_To_Discuss');?>

              </a>

              <?php

						

							}

						?>

              <?php

						}

					?>
 </div>
 		 <span style="font-size:0.8em;font-style:italic;"><?php if($arrVal['commentWorkSpaceId']==0){echo "My Space";}else{echo $workSpaceDetails1['workSpaceName'];}?></span>
			  
			
              <span class="clsCountTrees"><?php echo $this->profile_manager->getReplyByCommentId($arrVal['id'],0,'ASC',true);  ?></span>
 		
            </div>

            <?php echo stripslashes($arrVal['comment']); ?> 
			
			 <div id="success_msg_<?php echo $arrVal['id'];?>"></div>
			 
			 </div>

          <div style="padding-left:2.2%; height:48px;width:100%; " class="<?php echo $nodeBgColor;?>">

            <?php

						//echo $this->lang->line('txt_By') .': ';

					?>
			<div style="clear:both;"></div>
			
			<div style="float:right; font-size:0.8em; margin-top:5px;" >
			
       		<a style="font-style:italic;" href="<?php echo base_url();?>profile/index/<?php echo $userDetails['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo $userDetails['userTagName'];?>"><?php echo $userDetails['userTagName'];?></a>
			 <?php

						echo $this->time_manager->getUserTimeFromGMTTime($arrVal['commentTime'],$this->config->item('date_format'),1);

			?>
			
			</div>
			

            <!-- &nbsp;&nbsp;<a href="javascript:editNotesContents_1(<?php echo $arrVal['id'];?>,<?php echo $_SESSION['userId'];?>,'<?php echo $this->lang->line('txt_Done');?>',<?php echo $arrVal['commenterId'];?>);" ><?php echo $this->lang->line('txt_Comment');?></a>&nbsp;&nbsp;&nbsp; -->

            <br />

            <!--	&nbsp;&nbsp;<a href="<?php echo base_url();?>profile/message/<?php echo $arrVal['id'];?>/<?php echo $arrVal['commenterId'];?>"  target="_blank" class="example7" ><?php echo $this->lang->line('txt_Open_As_Talk');?></a>		-->

            <div id="divMessage_<?php echo $arrVal['id'];?>" class="divMessage" style="display:none; margin-top:3%;" >

			<?php
				if (count($discussTrees)==0)
				{
					echo "<span class='style2'>".$this->lang->line('msg_no_discuss_trees_to_move')."</span>";
				}
				else
				{
			?>

              <form id="form_<?php echo $arrVal['id'];?>"  method="post" action="<?php echo base_url();?>profile/convertMessageToDiscuss/<?php echo $Profiledetail['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>/<?php echo $arrVal['id'];?>"  >

                <select id="selectDiscussTree<?php echo $arrVal['id'];?>" name="selectDiscussTree" style="width:49%" >

                  <option value="0" ><?php echo $this->lang->line('txt_Select_Discuss_Tree');?></option>

                  <?php

							foreach($discussTrees as $keyDiscussTree=>$disTree )

							{

							

							  if(strlen($disTree['name'])>100)

							  {

					 ?>

                  <option value="<?php echo $keyDiscussTree; ?>" ><?php echo  substr(strip_tags(stripslashes($disTree['name']),'<b><em><span><img>'),0,100)."..."; ?></option>

                  <?php   

					 			}

								else

								{

					?>

                  <option value="<?php echo $keyDiscussTree; ?>" ><?php echo  strip_tags(stripslashes($disTree['name']),'<b><em><span><img>'); ?></option>

                  <?php

								

								

								}		       		

							}

								

					

					 ?>

                </select>

                <input type="submit" value="<?php echo $this->lang->line('txt_Move'); ?>" onClick="return submitConvertMessageToDiscuss(<?php echo $arrVal['id'];?>)"  class="button01"    />

                <input type="button" value="<?php echo $this->lang->line('txt_Cancel'); ?>" onclick="closeConvertDiscussBlock()"  class="button01"  />

              </form>
<?php
}
?>
            </div>

            <span id="editleaf<?php echo $arrVal['id'];?>" style="display:none;"></span>

            <?php $c=$this->profile_manager->getReplyByCommentId($arrVal['id'],0,'ASC',true);

				if($c<=0 && $arrVal['status']!=2)

				{ ?>

            <a style="float:left; margin-left:5px; display:none;" href="javaScript:void(0)" onClick="window.open('<?php echo base_url();?>profile/message/<?php echo $arrVal['id'];?>/<?php echo $arrVal['commenterId'];?>','','width=850,height=500,scrollbars=yes ')" class="msg<?php echo $arrVal['id'];?>"><img border="0" src="<?php echo base_url(); ?>images/subtask-icon_new.png" title="Add">

            <!--<?php //echo $this->lang->line('txt_Comment');?>-->

            </a>&nbsp;&nbsp;

            <?php } ?>

          </div>

          <?php 

			      

				$replyArray=$this->profile_manager->getReplyByCommentId($arrVal['id'],0,'ASC');

				

				if($replyArray && $arrVal['status']!=2)

				{

				  

			?>

          <div style="padding-left:2.2%; float:left;width:100%;" class="<?php echo $nodeBgColor;?>" id="comm">

           <div class="messageComments hrColorGray"></div> <?php

				 

				  	foreach($replyArray as $reply)

				  	{				     

					  $replyerUserDetails	= 	$this->profile_manager->getUserDetailsByUserId($reply['commenterId']);	

				  ?>
			<div style="clear:both;"></div>
            <div style="padding-left:1.5%;  float:left; margin-left:5%;width:80% " class="<?php echo $nodeBgColor;?>"> <?php echo stripslashes($reply['comment']); ?> </div>

            <div class="<?php echo $nodeBgColor;?> messageCommentDiv" style="font-size:0.8em; float:right; margin:0px;"> 
			
			<span style="float:right; padding-right:1.5%; ">

              <hr class="hrColorGray" />

            </span>   
			
            <a href="<?php echo base_url();?>profile/index/<?php echo $replyerUserDetails['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo $replyerUserDetails['userTagName'];?>"><?php echo $replyerUserDetails['userTagName'];?></a>
			
			<?php

				echo $this->time_manager->getUserTimeFromGMTTime($reply['commentTime'],$this->config->item('date_format'),1);
				
			?>

		 </div>

            <?php

			}

			?>

            <div style="padding-left:1.5%; float:left; " class="<?php echo $nodeBgColor1;?>"></div>

            <div style="clear:both;"> </div>

            <div style="height:30px">

            <a style="float:left; margin-left:5px;display:none;" href="javaScript:void(0)"  class="msg<?php echo $arrVal['id'];?>"  onClick="window.open('<?php echo base_url();?>profile/message/<?php echo $arrVal['id'];?>/<?php echo $arrVal['commenterId'];?>','','width=850,height=500,scrollbars=yes ')" ><img border="0" src="<?php echo base_url(); ?>images/subtask-icon_new.png" title="Add">

            

            <!--<?php //echo $this->lang->line('txt_Comment');?>-->

            </a> </div></div>

            <?php

				}?>

          <?php $i++;

			

			  ?>

        </div>

        <?php  

		

				$focusId = $focusId+2;	

				

			}    

		} 



			//Arun- update wall alert

			$this->profile_manager->updateWallAlert2($_SESSION['userId'],0);

			

			//Arun- update wall alert

			$this->profile_manager->updateMessageNotification($_SESSION['userId'],0);

		 

		?>

        <input type="hidden" name="editStatus" value="0" id="editStatus">

        <input type="hidden" name="commenterId" value="0" id="commenterId">

        <input type="hidden" name="reply" value="1" id="reply">

        <input type="hidden" name="msgId" id="msgId" />

      </div>

      <?php 		

	}

	?>

    </div>

    <!-- End Wall Comments -->

 

    

 

</div>



<?php



}

?>

<script>

		$(document).ready(function(){

			//Examples of how to assign the ColorBox event to elements

			$(".example7").colorbox({width:"<?php echo $this->config->item('page_width')+50;?>px", height:"500px", iframe:true});

		});

</script>

