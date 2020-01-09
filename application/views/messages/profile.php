<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>
<!--Html code start-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!--/*Changed by Surbhi IV*/-->

	<title>Teeme > Messages</title>

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

    <?php 

	$_SESSION['workSpaceType1']=$workSpaceType;

	$_SESSION['workSpaceId1']=$workSpaceId;

	$workSpaces 		= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
	//echo "wstype= " .$workSpaceType; exit;
	if ($workSpaceType==2)
	{
		$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
	}
	else
	{
		$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	
	}
	//print_r ($workSpaceDetails); exit;

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

    <?php $this->load->view('common/artifact_tabs', $details); 	?>

  </div>

    </div>

	<div id="container">

    <div id="content"> 

    

    <!--webbot bot="HTMLMarkup" startspan -->

    

    <div style="float:right;padding-bottom:10px;margin-right:2%;"> 
		<span id="reloadMsg"><a href="javascript:void(0);" onclick="countMessages = 0;views = 0;allSet=1;getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);"><img src="<?php echo base_url(); ?>images/new-version.png" title="<?php echo $this->lang->line('txt_Update');?>" border="0" title="<?php echo $this->lang->line('txt_Update_Tree'); ?>"></a></span>
	</div>

    <div class="menu_new" style="padding-right:10%;background:white;">

          <ul class="tab_menu_new">
		  
		  <?php if ($myProfileDetail['userGroup']>0) { ?>
		
		<li class=""><a href="<?php echo base_url()?>profile/index/<?php echo $_SESSION['userId'];  ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>" style="margin-top: 9px;padding-left:11px;<?php if(!$_SESSION['all']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" ><span>

          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName; ?>

          <?php } else { ?>

          My Space

          <?php } ?>

          </span></a></li>
		  <?php } else if ($workSpaceId>0){ ?>
		<li class=""><a href="<?php echo base_url()?>profile/index/<?php echo $_SESSION['userId'];  ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>" style="margin-top: 9px;padding-left:11px;<?php if(!$_SESSION['all']) { ?> background:#ECECEC;" class="active <?php } ?>" title="<?php echo $workSpaceName ?>"  id="curr" ><span>

          <?php 

		  //$_SESSION['all'] condition for hiding option for all tab

		  if($workSpaceId){ ?>

          <?php echo $workSpaceName; ?>

          <?php } else { ?>

          <?php echo $this->lang->line('txt_My_Workspace'); ?>

          <?php } ?>

          </span></a></li>
		  <?php } ?>
		  
		<?php if ($workSpaceDetails['workSpaceName']!="Try Teeme") { ?>
        <li class="" ><a href="<?php echo base_url()?>profile/index/<?php echo $_SESSION['userId'];  ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/0/1/all"  title="<?php echo "All" ;?>" style="margin-top: 9px;padding-left:11px;  <?php if($_SESSION['all']) { ?>background:#ECECEC;" class="active <?php } ?>" id="all"><?php echo $this->lang->line('all_txt'); ?></a></li>
		<?php } ?>
        <!-- <li><a href="javascript:reply(0,0,'<?php echo $this->uri->segment(7) ?>');" style="margin-top: 11px;padding-left:11px;" id="add"><img border="0" title="Add" src="<?php echo base_url(); ?>/images/addnew.png" ></a></li>

        -->

      </ul>

          <div class="clr"></div>

        </div>

    <div style="width:18%;float:left;">

          <?php

				//online user list view

				if ($workSpaceId_search_user == 0)

				{

					

				?>

          <?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>

          <a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($myProfileDetail['tagName'],20,"<br />\n",true); ?> </a>

		<?php
		if ($_SESSION['all'])
		{
			if ($myProfileDetail['userGroup']>0)
				$showSearchBox = 1;
			else
				$showSearchBox = 0;
		}
		else
		{
			$showSearchBox = 1;
		}
		if ($showSearchBox)	
		{
		?>
        	<input type="text" name="search" id="search" value="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:95%"/>
		<?php
		}
		?>

          <div class="clr"></div>

          <?php

					

					if(count($workSpaceMembers) > 0)

					{

						$rowColor1='rowColor6';

						$rowColor2='rowColor5';	

						$i = 1;

						?>

                        <div id="divSearchUser" name="divSearchUser" >

                        <?php 	

						//show online users	
						
						if ($_SESSION['all'])
						{
							if ($myProfileDetail['userGroup']>0)
								$showMemberList = 1;
							else
								$showMemberList = 0;
						}
						else
						{
							$showMemberList = 1;
						}
						
						if ($showMemberList)
						{
							foreach($workSpaceMembers  as $keyVal=>$arrVal)
							{
	
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
	
								//shows only online users on top
								
									if ($_SESSION['all'])
									{
										if ($myProfileDetail['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
	
								if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)	
								{
									if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
									{
										if ($arrVal['isPlaceManager']==1)
										{
											$showOnlyPlaceManagersForGuests = 1;
										}
										else
										{
											$showOnlyPlaceManagersForGuests = 0;
										}
									}
									else
									{
										$showOnlyPlaceManagersForGuests = 1;
									}
									if ($showOnlyPlaceManagersForGuests)
									{
								?>
	
									<div id="row1" class="<?php echo $rowColor;?>"> 
										<?php echo '<img src="'.base_url().'images/online_user.gif"  width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>
										<a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true); ?> </a>	
										<div class="clr"></div>	
									</div>
								<?php
									}
									$i++;
	
								} 
	
								 
	
							}//close online users 
	
							
	
							//shows remaining offline users
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
	
							{
	
								$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;	
	
									if ($_SESSION['all'])
									{
										if ($myProfileDetail['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
	
								//condition for showing (remaining)offline users	
	
								 if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
								 {
									if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
									{
										if ($arrVal['isPlaceManager']==1)
										{
											$showOnlyPlaceManagersForGuests = 1;
										}
										else
										{
											$showOnlyPlaceManagersForGuests = 0;
										}
									}
									else
									{
										$showOnlyPlaceManagersForGuests = 1;
									}	
									
									if ($showOnlyPlaceManagersForGuests)
									{
									?>
	
										<div id="row1" class="<?php echo $rowColor;?>" style="float:left;width:100%"> <?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16" style="margin-top:5px;float:left;" />';?> <a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a>
		
										  <div class="clr"></div>
		
										</div>
	
									<?php
									}
									$i++;
	
								 }
	
							}
						}
						

					  ?>

      </div>

          <?php

					}

				else

				{

				?>

          <span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span>

          <?php

				}

				 ?>

          <?php 

				}

				else

				{

				

				?>

        <div id="row1" >

        <?php  echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />'; ?>

        <a href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$myProfileDetail['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;margin-left:10px;"><?php echo wordwrap($myProfileDetail['tagName'],20,"<br />\n",true); ?> </a>


		<?php
		if ($_SESSION['all'])
		{
			if ($myProfileDetail['userGroup']>0)
				$showSearchBox = 1;
			else
				$showSearchBox = 0;
		}
		else
		{
			$showSearchBox = 1;
		}
		if ($showSearchBox)	
		{
		?>
        	<input type="text" name="search" id="search" value="Search"  onKeyUp="showSearchUser()" onclick="removeSearh()"  onblur="writeSearh()" style="width:95%"/>
		<?php
		}
		?>

        <div class="clr"></div>

      </div>

          <?php

					

				if(count($workSpaceMembers) > 0)

				{

						$rowColor1='rowColor2';

						$rowColor2='rowColor1';	

						$i = 1;



						?>

          <div id="divSearchUser" name="divSearchUser" >

        				<?php
						if ($_SESSION['all'])
						{
							if ($myProfileDetail['userGroup']>0)
								$showMemberList = 1;
							else
								$showMemberList = 0;
						}
						else
						{
							$showMemberList = 1;
						}	
						if ($showMemberList)
						{		
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
							{
									if ($_SESSION['all'])
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
								//shows only online users on top
	
								 if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
								 {
										if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
										{
											if ($arrVal['isPlaceManager']==1)
											{
												$showOnlyPlaceManagersForGuests = 1;
											}
											else
											{
												$showOnlyPlaceManagersForGuests = 0;
											}
										}
										else
										{
											$showOnlyPlaceManagersForGuests = 1;
										}	
										
										if ($showOnlyPlaceManagersForGuests)
										{
													
											$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;		
										?>
	
											<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/online_user.gif" width="15" height="16" style=" margin-top:5px;float:left;"  />';  ?> <a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo  $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a>
									
											<div class="clr"></div>
									
											</div>
	
										<?php
										}
								$i++;
	
								}
	
							}
	
							
	
							foreach($workSpaceMembers as $keyVal=>$arrVal)
							{
									if ($_SESSION['all'])
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($arrVal['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
								//shows only offline users 
	
								 if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] && $showGuestUser)
								 {
										if ($myProfileDetail['userGroup']==0 && $workSpaceDetails['workSpaceName']=="Try Teeme")
										{
											
											if ($arrVal['isPlaceManager']==1)
											{
												$showOnlyPlaceManagersForGuests = 1;
											}
											else
											{
												$showOnlyPlaceManagersForGuests = 0;
											}
										}
										else
										{
											$showOnlyPlaceManagersForGuests = 1;
										}	
										
										if ($showOnlyPlaceManagersForGuests)
										{
											$rowColor = ($i % 2) ? $rowColor1 : $rowColor2;						
	
										?>
	
											<div id="row1" class="<?php echo $rowColor;?>"> <?php echo '<img src="'.base_url().'images/offline_user.gif" width="15" height="16"  style="margin-top:5px;float:left;" />';?> <a href="<?php echo base_url();?>profile/index/<?php echo $arrVal['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ?>/<?php echo $workSpaceType_search_user; ?><?php if ($_SESSION['all']) {echo "/all";}?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal['statusUpdate']);  ?>" style="word-wrap:break-word;float:left;"><?php echo wordwrap($arrVal['tagName'],20,"<br />\n",true);?> </a>
									
											<div class="clr"></div>
									
											</div>
										<?php
										}
								$i++;
	
								}
	
							}
	
						}

						

				}

				else

				{

				?>

        <span class="infoMsg"><?php echo $this->lang->line('txt_None');?></span>

        <?php

				}

				?>

      </div>

          <?php 

				}

				?>

        </div>

    <div id="userDetailContainer"> </div>

    

    <!--View More-->

    <div id="viewMore" style="width:100%;text-align:center;color: #898686;font-weight: bold;line-height: 40px; display: <?php if($countAll>10){ echo 'block'; } else { echo 'none'; }?>; text-decoration: none;clear:both;"> <a href="javascript:void(0);" onclick="getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);"><?php echo $this->lang->line('view_more_txt'); ?></a> </div>

  </div>

    </div>

<div>

      <?php $this->load->view('common/foot.php');?>

      <?php $this->load->view('common/footer');?>

    </div>

</body>

</html>

<script language="javascript" src="<?php echo base_url();?>js/profile.js"></script>

<script>



	limitCount=1;

	var hidden = 0;

	var views = 0;

	var http2 = getHTTPObjectm();

	//upload image using ajax 

 

	//check all items

	function getHTTPObjectm() 

	{

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



	function getUserDetail(userId,workSpaceId,workSpaceType,workSpaceId_search_user,workSpaceType_search_user)
	{			
		<?php 
			if ($this->uri->segment(11)=='')
			{
				$nodeId = 0;
			}
			else if ($this->uri->segment(11)>0)
			{
				$nodeId = $this->uri->segment(11);
			}
			else
			{
				$nodeId = 0;
			}
		?>

		url='<?php echo base_url();?>profile/profileDetails/'+userId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId_search_user+'/'+workSpaceType_search_user+'/'+views+'/0/'+<?php echo $nodeId;?>;
		//url='<?php echo base_url();?>profile/profileDetails/'+userId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId_search_user+'/'+workSpaceType_search_user+'/'+views+'/0/0';
		

	//	alert(url);

		views	=	views+1;

		http2.open("GET", url,true);

		 

		http2.onreadystatechange = handleGetUserDetail; 

		

		http2.send(null); 

	}

	

	var countAll= <?php echo $countAll;?>;

	var allSet=0;

	var delComm=0;

	function handleGetUserDetail()

	{  

		if(http2.readyState == 4)

		{ 

			if(http2.status==200)

			{ 				

				var results=http2.responseText;	

				if(results.substr(0,1)==1 && delComm!=1){
					//alert ('Here');
					document.getElementById('viewMore').style.display='none';

					var text = document.getElementById('userDetailContainer').innerHTML;

					

					if(views==1){

						//$('<div class="newMessageBox"></div>').insertBefore('#allComment');

						document.getElementById('userDetailContainer').innerHTML= results.substr(1);

					}

					else{

						document.getElementById('userDetailContainer').innerHTML= text+results.substr(1);

					}

				}

				else if(allSet==0 && delComm!=1){
				
					//alert ('Here2');

				//	document.getElementById('viewMore').style.display='block';

					

					var text = document.getElementById('userDetailContainer').innerHTML;

					

					document.getElementById('userDetailContainer').innerHTML= text+results;

					if(views==1){

						//$('<div class="newMessageBox"></div>').insertBefore('#allComment');

					}

				}

				else{

					document.getElementById('viewMore').style.display='block';

					document.getElementById('userDetailContainer').innerHTML= results;

					if(views==1){

						//$('<div class="newMessageBox"></div>').insertBefore('#allComment');

					}

					delComm=0;

				}

				<?php /*?>if(CKEDITOR.instances['replyDiscussion0']){

					editorClose('replyDiscussion0');

				}<?php */?>

				

				//var editor = CKEDITOR.instances['replyDiscussion0'];

				//alert(limitCount*10);

				

				if(countAll < limitCount*10){

					document.getElementById('viewMore').style.display='none';

				}

				limitCount++;

				

				$("p > img").css({"max-width":"600px","max-height":"500px"});

				//change textarea to editor

				//added by monika

				//chnage_textarea_to_editor('comments','simple');

				//chnage_textarea_to_editor('other','simple');

			}

		}

	}


	function displayname(){

		if(document.getElementById('display_name').value=='' || document.getElementById('display_name').value==document.getElementById('first_name').value || document.getElementById('display_name').value==document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_' || document.getElementById('display_name').value==document.getElementById('first_name').value+'__'){

			document.getElementById('display_name').value=document.getElementById('first_name').value+'_'+document.getElementById('middle_name').value+'_'+document.getElementById('last_name').value;

		}

	}

	function validate(){

		var error='';

		if(document.getElementById('company_name').value==''){

			error+='<?php echo $this->lang->line('req_company_name'); ?>\n';

		}		

		if(document.getElementById('first_name').value==''){

			error+='<?php echo $this->lang->line('req_first_name'); ?>\n';

		}

		if(document.getElementById('last_name').value==''){

			error+='<?php echo $this->lang->line('req_last_name'); ?>\n';

		}

		if(document.getElementById('display_name').value==''){

			error+='<?php echo $this->lang->line('req_tag_name'); ?>\n';

		}

		if(error){

			jAlert(error);

			return false;

		}else{

			return true;

		}

	}

	function reply_remove(id,focusId)

	{

		var divid=id+'notes';

		document.getElementById(divid).style.display='';

		document.getElementById('profileDetails').style.display='none';

		document.getElementById('profileDetailsEdit').style.display='none';

	}

	function message_reply(id,focusId)

	{

		var divid=id+'msgnotes';

		document.getElementById(divid).style.display='';

	}

	function reply_close(id,workSpaceId)

	{

		divid=id+'notes';

 		document.getElementById(divid).style.display='none';

		document.getElementById('allComment').style.display='block';

		document.getElementById('viewMore').style.display='block';

		

		//CKEDITOR.instances.replyDiscussion0.setData('');

		setValueIntoEditor('replyDiscussion0','');

		

		if(workSpaceId==0)

		{

		   if($('#curr').hasClass('active'))

		   {

				$('#curr').removeClass('active');

		   }

		   if($('#add').hasClass('active'))

		   {

			   $('#add').removeClass('active');

		   }

		   $('#all').addClass('active');

		}

		else

		{

		   if($('#all').hasClass('active'))

		   {

				$('#all').removeClass('active');

		   }

		   if($('#add').hasClass('active'))

		   {

			   $('#add').removeClass('active');

		   }

		   $('#curr').addClass('active');	

		}

		$(".clsCheck").attr("checked",false);

	}

	

	function hideBlock(hideDivId,url)

	{	

		document.getElementById('det').style.display='block'; 

 		document.getElementById(hideDivId).style.display='none';

	    var userId=document.getElementById('userId').value;

		var request1 = $.ajax({

			  url: url,

			  type: "POST",

			  data: 'userId='+userId,

			  //data: '',

			  dataType: "html",



			  success:function(result)

			  { 

				

				$("#workPlaceDiv").html(result);

			  }

	   });

	   changViewProfileLabel();

	}

	

	

	function hideBlock(hideDivId)

	{

		

 		document.getElementById('det').style.display='block';

		document.getElementById(hideDivId).style.display='none';

	    var userId=document.getElementById('userId').value;

		

	   changViewProfileLabel();

	}

	

	function editNotesContents(id,focusId)

	{

		var divid=id+'edit_notes';

		//alert (divid);

		document.getElementById(divid).style.display='';

	}

	

function showNotesNodeOptions(position)

{	

	//alert ('Pos= ' + position);	

	var notesId = 'normalView'+position;	

	if(position > 0)

	{

		document.getElementById('normalView0').style.display = "none";

	}	

	if(document.getElementById(notesId).style.display == "none")

	{			

		document.getElementById(notesId).style.display = "";

	}

	else

	{

		document.getElementById(notesId).style.display = "none";

	}

	/*

	var totalNodes = document.getElementById('totalNodes').value;

	//alert (totalNodes);

	var nodesArray = totalNodes.split(",");

	

	//alert ('counter= ' +nodesArray.length);

	for(var i=0; i<nodesArray.length; i++)

	{

		if(nodesArray[i] != position)

		{

			notesId = 'normalView'+nodesArray[i];	

			//alert (notesId);

			document.getElementById(notesId).style.display = "none";

		}

	}

	*/

}

function validate_dis(replyDiscussion,formname,url,nodeOrder)

{

	var error='';

    //alert(document.getElementById('replyDiscussion1').value + '\n'+'<DIV id="11-span"><P>&nbsp;</P> <BR /><P>&nbsp;</P></DIV>');

	//replyDiscussion1=replyDiscussion+'1';

	var INSTANCE_NAME = $("#"+replyDiscussion).attr('name');

	

	//var getValue=CKEDITOR.instances[INSTANCE_NAME].getData();

	var getValue=getvaluefromEditor(INSTANCE_NAME);

	//alert(getValue);

	if(getValue == '')

	{

		error+='<?php echo $this->lang->line('enter_your_comment'); ?>\n';

	}

	/*if(compareDates(formname.starttime.value,formname.endtime.value) == 1){

	 	error+=' Please check start time and end time.';

	}*/

	if(error=='')

	{

	     /*Changed by surbhi IV*/

		//formname.submit();

		/* var urgent=document.getElementById('urgent').checked; 

		 if(urgent)

		 {

		    urgent=1;

		 }

		 else

		 {

		    urgent='';

		 }*/

		 urgent='';

		 //var recipientsCount= 

		 var recipients=document.getElementById("list").value.split(",");//document.getElementsByName("recipients[]").length;//new Array();

		/* for(var i=1;i<=recipientsCount;i++)

		 {

		    // if(document.getElementById("recipients_"+i).checked)

			 //{

			    recipients[i]=//document.getElementById("recipients_"+i).value;

			 //}	

		 }*/

		 

		 var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: 'editorname1=replyDiscussion0&reply=1&nodeOrder'+nodeOrder+'&urgent='+urgent+'&recipients='+recipients+'&replyDiscussion0='+encodeURIComponent(getValue),

				  //data: '',

				  dataType: "html",

				  success:function(result)

				  {//alert(result);return;

					  //document.getElementById('userDetailContainer').innerHTML= result;

					  //tinyMCE.execCommand('mceRemoveControl', true, 'replyDiscussion0');

					  //CKEDITOR.instances[INSTANCE_NAME].destroy();
					  
					  //Manoj: destroy froala editor
					  
					  editorClose(INSTANCE_NAME);

				  	  

					  $('.allComment').remove();

					  $('#0notes').remove();

					  views = 0;

					  document.getElementById('userDetailContainer').innerHTML='';
					  
					  window.location.href = location.href;
					  
					 getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

					  

				  }

		   });

		   /*End of Changed by surbhi IV*/

	}

	else

	{

		jAlert(error);

	}	

}

/*Added by surbhi IV*/

function updateStatus(url)

{

   var memberId=document.getElementById('memberId').value;

   var workSpaceId=document.getElementById('workSpaceId').value;

   var workSpaceType=document.getElementById('workSpaceType').value;

   var workSpaceId_search_user=document.getElementById('workSpaceId_search_user').value;

   var workSpaceType_search_user=document.getElementById('workSpaceType_search_user').value;

   var statusUpdate=document.getElementById('statusUpdate1').value;

   var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: 'memberId='+memberId+'&workSpaceId='+workSpaceId+'&workSpaceType'+workSpaceType+'&workSpaceId_search_user='+workSpaceId_search_user+'&workSpaceType_search_user='+workSpaceType_search_user+'&statusUpdate='+statusUpdate,

				  //data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 // alert(result);

					// getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

					$('#statusUpdate').hide();

					$('#normalView0').show();

					

					 $('.member_status').text('Status : '+result);

				  }

		   });

}  

function confirmDeleteComment(url)

{

	if (confirm("<?php echo $this->lang->line('sure_to_delete_message'); ?>"))

	{

		//return true;

		var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 views  = 0;

					 delComm = 1;

					 getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);
					  $('#msgDiv').html(result);

					 

				  }

		   });

	}

	else

	{

		return false ;

	}

}

function confirmDeleteComment1(url)

{ 

	if (confirm("Are you sure you want to delete this message?"))

	{

		//return true;

		var request1 = $.ajax({

				  url: url,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					 $('#msgDiv').html(result);

				  }

		   });

	}

	else

	{

		return false ;

	}

}

/*End of Added by surbhi IV*/


	function edit_close(pos,nodeId){

		var divId=pos+'edit_notes';

		var editorId = 'editDiscussion'+nodeId;



		document.getElementById(editorId).style.display='none';

		document.getElementById(divId).style.display='none';

	}

</script>

<script>

	var msgId1;

	var userId1;

	var textDone1;

	var commenterId1;

	function editNotesContents_1(msgId,userId,textDone,commenterId)

	{



		msgId1=msgId;

	 	userId1=userId;

	  	textDone1=textDone;

		commenterId1=commenterId;

	 

	 	if(document.getElementById('editStatus').value == 1)

		{

			jAlert('<?php echo $this->lang->line('save_close_current_reply'); ?>');

			//return false;

		}

		else

		{

			// position1=position;

			var temp=handleNoteLockLeafEdit();

		}

	

	}



function editLeafNote(leafId, leafOrder,treeId,nodeId) 

{  

	xmlHttpTree=GetXmlHttpObject2();

	var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

	xmlHttpTree.onreadystatechange = handleNoteTreeVersion;



	xmlHttpTree.open("GET", url, true);

	xmlHttpTree.send(null);

}

function handleNoteTreeVersion(){

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

			//alert (isLatest);

			if(isLatest==0)

			{

				jAlert ('<?php echo $this->lang->line('can_not_edited'); ?>');

				return false;

			}

			else

			{

				//document.frmEditLeaf.submit();

				//return true;

				xmlHttp=GetXmlHttpObject2();

				var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

				xmlHttp.onreadystatechange = handleNoteLockLeafEdit;				

				xmlHttp.open("GET", url, true);

				xmlHttp.send(null);

			}

		}					

	}

}

function handleNoteLockLeafEdit()

{

	document.getElementById('editStatus').value = 1;

	//var val=document.getElementById('initialleafcontent'+leafOrder1).value;

	document.getElementById('editleaf'+msgId1).style.display="";

	//document.getElementById('editStatus').value = 1;

					

	editor_code('','editorLeafContents'+msgId1+'1','editleaf'+msgId1);

	//var contents=document.getElementById('leaf_contents'+id1).innerHTML;



	document.getElementById('editorLeafContents'+msgId1+'1sp').innerHTML='<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0"><tr><td colspan="2" align="center"><a href="javascript:void(0)" onclick="editLeafSave1('+msgId1+','+commenterId1+')"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a></td> <td colspan="2" align="center"><a href="javascript:void(0)" onclick="canceleditLeaf1('+msgId1+')"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></td></tr></table>';

	

	chnage_textarea_to_editor('editorLeafContents'+msgId1+'1');

	setValueIntoEditor('editorLeafContents'+msgId1+'1',contents);	

	xmlHttpLast11=GetXmlHttpObject2();

	var url =baseUrl+'current_leaf'+"/index/leafId/"+nodeId1;

	xmlHttpLast11.onreadystatechange=function() {

	if (xmlHttpLast11.readyState==4) {

		

		document.getElementById('editStatus').value = 1;

					

			}

		}

			

	xmlHttpLast11.open("GET", url, true);

	xmlHttpLast11.send(null);

}



function canceleditLeaf1(msgId) 

{

	document.getElementById('editleaf'+msgId).style.display="none";

	document.getElementById('editStatus').value= 0;		

}



function editLeafSave1(msgId,commenterId) 

{	

  //document.getElementById('editleaf'+leafOrder).style.display="none";

	document.getElementById('editStatus').value= 0;		

		

	var editorId = "editorLeafContents"+msgId+"1"; 

	var getvalue=getvaluefromEditor(editorId);//document.getElementById(editorId).value; 

	if (getvalue=='')

	{

		jAlert ('<?php echo $this->lang->line('enter_your_reply'); ?>');

		return false;

	}

	//var originalContents = document.getElementById('initialleafcontent'+leafOrder).value;

	//document.form2.curContent.value = getvalue;

	document.form2.msgId.value = msgId;	

	document.form2.commenterId.value = commenterId;

			

	document.form2.submit();		

	return true;

}



function showTags()

{

   	var toMatch = document.getElementById('searchTags').value;

	var val = '<input type="checkbox" name="checkAll" id="checkAll" onclick="checkAllFunction();" /><?php echo $this->lang->line('txt_All');?><br />';

	

	//if (toMatch!='')

	if(1)

	{

		var count = '';

		var sectionChecked = '';

		<?php

		$i=1;

		foreach($workSpaceMembers_search_user as $keyVal=>$workPlaceMemberData)
		{
									if ($_SESSION['all'])
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}
									else if ($workSpaceId>0)
									{
										$showGuestUser = 1;
									}
									else
									{
										if ($workPlaceMemberData['userGroup']>0)
											$showGuestUser = 1;
										else
											$showGuestUser = 0;
									}	
			if($workPlaceMemberData['userId']!=$_SESSION['userId'] && $workPlaceMemberData['userId']!=$this->uri->segment(3) && $showGuestUser){?>

				var str = '<?php echo $workPlaceMemberData['tagName']; ?>';

				

				var pattern = new RegExp('\^'+toMatch, 'gi');

				

				if (str.match(pattern))

				{

					val +=  '<input class="clsCheck" type="checkbox" id="recipients_<?php echo $i;?>" name="recipients[]" value="<?php echo $workPlaceMemberData['userId'];?>"  /><?php echo $workPlaceMemberData['tagName'];?><br>';

				}

				<?php

				$i++;	

			}

		

			?>document.getElementById('showMan').innerHTML = val;

			document.getElementById('showMan').style.display = 'block';

			<?php

		}?>

		var list = $("#list").val();

		var val1 = list.split(",");

		

		$(".clsCheck").each(function(){

			 if(val1.indexOf($(this).val())!=-1){

				$(this).attr("checked",true);

			 }

		});

	}

	else

	{

		document.getElementById('showMan').style.display = 'none';

	}



}



// Arun- function returns search users 

function showSearchUser()

{

     

	var toMatch = document.getElementById('search').value;

	var val='';

	

		//if (toMatch!='')

		if (1)

		{

		

		var count = '';

		var sectionChecked = '';

		

		var rowColor1='rowColor2';

		var rowColor2='rowColor1';	

		var rowColor;

		var i = 1;

		//val+='<table cellpadding="0" cellspacing="0" id="divSrchUser">';

		<?php

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;		

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				val+='<div id="row1" class="'+ rowColor+'"><?php echo "<img src=\' ".base_url()."images/online_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo  str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></div>';

				 i++;

			}

        

		<?php

			

			

        }

		}

		

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;	

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				

				

				val+='<div id="row1" class="'+rowColor+'"><?php echo "<img src=\' ".base_url()."images/offline_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></div>';

						  

				i++;	 

				

			}

		<?php

			

        }

		}

		

        ?>

		

			val+='';

			//$('#divSrchUser').html(val);

			document.getElementById('divSearchUser').innerHTML=val;

			

			//document.getElementById('divSrchUser').style.display = 'block';

		

		}

		else

		{

			//document.getElementById('divSrchUser').style.display = 'none';

		}



}


<?php /*?>function showSearchUser()

{

     

	var toMatch = document.getElementById('search').value;

	var val='';

	

	

		//if (toMatch!='')

		if (1)

		{

		

		var count = '';

		var sectionChecked = '';

		

		var rowColor1='rowColor2';

		var rowColor2='rowColor1';	

		var rowColor;

		var i = 1;

		<?php

		

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   

		

		   if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

				$skills = preg_replace( "/\r|\n/", "", $arrVal['skills'] );

		?>  

			

			rowColor = (i % 2) ? rowColor1 : rowColor2;		

			

			var str = '<?php echo $arrVal['tagName']; ?>';
			
			var str2 = '<?php echo $skills; ?>';
			
			

			var pattern = new RegExp('\\'+toMatch, 'gi');
			
			

			if (str.match(pattern) || str2.match('/'+pattern+'/g'))

			{

				

				val+='<tr id="row1" class="'+ rowColor+'"><td width="1%" align="left" valign="top">&nbsp;</td><td width="20" align="left" valign="top" ><?php echo "<img src=\' ".base_url()."images/online_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?></td><td ><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo  str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></td></tr>';

						  

				 i++;

			}

        

		<?php

			

			

        	}

		}

		

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		   if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

		   {
				$skills = preg_replace( "/\r|\n/", "", $arrVal['skills'] );
		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;	

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			var str2 = '<?php echo $skills; ?>';

			var pattern = new RegExp('\\'+toMatch, 'gi');


			if (str.match(pattern) || str2.match(pattern))

			{

				

				

				val+='<tr id="row1" class="'+rowColor+'"><td width="1%" align="left" valign="top">&nbsp;</td><td width="20px" align="left" valign="top" ><?php echo "<img src=\' ".base_url()."images/offline_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?></td><td ><a href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>" class="blue-link-underline" title="<?php echo str_replace(chr(10)," ",$arrVal["statusUpdate"]); ?>" ><?php echo wordwrap($arrVal["tagName"],20,'<br />\n',true);?> </a></td></tr>';

						  

				i++;	 

				

			}

		<?php

			

        }

		}

		

        ?>

		

		

			

			$('#divSearchUser').html(val);

			document.getElementById('divSearchUser').style.display = 'block';

			

		

		

		}

		else

		{

			document.getElementById('divSearchUser').style.display = 'none';

		}



}<?php */?>

	

var workSpaceIdSearchUser;

var workSpaceIdSearchType;	

//this function used to change the user WorkSpace

function goWorkSpace_user_old(workSpaceId_search_user)

{	



	if(workSpaceId_search_user.value != '')

	{		

		if(workSpaceId_search_user.value.substring(0,1) == 's')

		{

			

			var tmpArray = workSpaceId_search_user.value.split(',');

			

			var url = baseUrl+'profile/getSearchedSpaceUser/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[1]+'/2';

			workSpaceIdSearchUser=tmpArray[1];

			workSpaceIdSearchType=2;

			

		}



		else

		{

			var url = baseUrl+'profile/getSearchedSpaceUser/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId_search_user.value+'/1';

			workSpaceIdSearchUser=workSpaceId_search_user.value;

			workSpaceIdSearchType=1;

		}		

		

		http2.open("GET", url,true); 

		http2.onreadystatechange = handleGetUserDetail_user; 

		http2.send(null); 

	}

}



function goWorkSpace_user(workSpaceId_search_user)

{	



	if(workSpaceId_search_user.value != '')

	{		

		if(workSpaceId_search_user.value.substring(0,1) == 's')

		{

			

			var tmpArray = workSpaceId_search_user.value.split(',');

			var url = baseUrl+'profile/index/<?php echo $this->uri->segment(3); ?>/'+workSpaceId+'/type/'+workSpaceType+'/'+tmpArray[1]+'/2';

			workSpaceIdSearchUser=tmpArray[1];

			workSpaceIdSearchType=2;

		}

        else

		{

			

			var url = baseUrl+'profile/index/<?php echo $this->uri->segment(3);  ?>/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceId_search_user.value+'/1';

			workSpaceIdSearchUser=workSpaceId_search_user.value;

			workSpaceIdSearchType=1;

		}		

		

		window.location=url;

		

	}

}



function handleGetUserDetail_user() 

{   

	if(http2.readyState == 4)

	{ 

		if(http2.status==200)

		{ 

			var results=http2.responseText;	

			

			window.location=baseUrl+'profile/index/<?php  echo $_SESSION['userId']; ?>/'+workSpaceId+'/type/'+workSpaceType+'/'+workSpaceIdSearchUser+'/'+workSpaceIdSearchType;

					

			document.getElementById('fetchData').innerHTML= results;

			

			getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,workSpaceIdSearchUser,workSpaceIdSearchType);		

							

		}

	}

}



function handleGetUserDetailSearch_user() 

{   

	if(http2.readyState == 4)

	{ 

		if(http2.status==200)

		{ 

			var results=http2.responseText;	

			

			document.getElementById('fetchData').innerHTML= results;

			

			getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,workSpaceIdSearchUser,workSpaceIdSearchType);		

							

		}

	}

}

var ie = (document.all) ? true : false;

function openConvertDiscussBlock(messageId)

{

	closeConvertDiscussBlock();

	document.getElementById('anchorMessage_'+messageId).style.display='none';

	document.getElementById('divMessage_'+messageId).style.display='block';

}



function closeConvertDiscussBlock()

{

		objClass='divMessage';

		var elements = (ie) ? document.all : document.getElementsByTagName('*');

  for (i=0; i<elements.length; i++){

    if (elements[i].className==objClass){

      elements[i].style.display="none"

    }

  }

  

  objClass='anchorMessage';

		var elements = (ie) ? document.all : document.getElementsByTagName('*');

  for (i=0; i<elements.length; i++){

    if (elements[i].className==objClass){

      elements[i].style.display="block"

    }

  }

		

}



/* Modified By : Ritika Bhawsar

 * Purpose : Stop Page redirection & call ajax request for moving message chat in a disscussion.

 */

function submitConvertMessageToDiscuss(id)

{

	if(document.getElementById('selectDiscussTree'+id).value==0)

	{

		jAlert("<?php echo $this->lang->line('select_discuss'); ?>");

		return false;

	}	

	if(confirm("<?php echo $this->lang->line('are_you_really_want_move_msg_discuss'); ?>"))

	{

		var selectDiscussTree = document.getElementById('selectDiscussTree'+id).value;

		var url = $('#form_'+id).attr('action');

 		$.ajax({

 			url:url,

 			data:{selectDiscussTree:selectDiscussTree},

 			type:'POST',

 			success:function(data)

 			{

 				$('.subcomment_'+id).text('');

 				$('#msgIcons_'+id).text('');

 				$('#divMessage_'+id).text('');

 				$('.msg'+id).text('');

 				$('#success_msg_'+id).html('<div style="color:green;">'+data+'</div>');

				getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

 			}

 		});



		return false;

	}

	return false;

}



//Arun- function perform check/uncheck all user list in add new messages 

/*$(document).ready(function(){



	$("#checkAll").live('click',function(){

			if($('input[name=checkAll]').is(':checked'))

			{

				$('.clsCheck').attr('checked', true);

			}

			else

			{

				$('.clsCheck').attr('checked', false);

			}

	});

	

	

});*/

	var countMessages = 0;

	

	function getNewMessages(){

		if(countMessages!=0){

			url=baseUrl+'profile/profileDetails/<?php echo $this->uri->segment(3); ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>/0/count';

		}

		else{

			countMessages=1;

			getNewMessages();
			

			url=baseUrl+'profile/profileDetails/<?php echo $this->uri->segment(3); ?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>/0/1/';

		}
		//alert (url);
		$.post(url,{},function(data){

			if(data!=''){

				if(countMessages!=0){

					$('.newMessageBox').html(data);

					$('.newMessageBox').fadeIn('slow');

					countMessages=0;

				}

				else{

					$(data).insertAfter('.newMessageBox');

					$('.newMessageBox').html('');

				}

			}

			

		});

		

	}

		

	setInterval("countMessages=1;getNewMessages();", 20000);

	setInterval("messageNotification(<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>);", 10000);

	

	function checkAllFunction(){

		if($("#checkAll").prop("checked")==true){

			$('.clsCheck').prop("checked",true);

			$(".clsCheck").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(value+","+$(this).val());

				}

			});

		}

		else{

			//change prop to attr for server - Monika

			$('.clsCheck').prop("checked",false);

			$(".clsCheck").each(function(){

				value = $("#list").val();

				val1 = value.split(",");	

				var index = val1.indexOf($(this).val());

				val1.splice(index);	

				var arr = val1.join(",")

				$("#list").val(arr);

			});

		}

	}

	

	$('.clsCheck').live("click",function(){

		val = $("#list").val();

		val1 = val.split(",");	

		if($(this).prop("checked")==true){

			if($("#list").val()==''){

				$("#list").val($(this).val());

			}

			else{

				if(val1.indexOf($(this).val())==-1){

					$("#list").val(val+","+$(this).val());

				}

			}

		}

		else{

			var index = val1.indexOf($(this).val());

			val1.splice(index, 1);

			var arr = val1.join(",");

			$("#list").val(arr);

		}

	});

//Arun: get user details through ajax

getUserDetail(<?php echo $this->uri->segment(3); ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType; ?>,<?php echo $workSpaceId_search_user; ?>,<?php echo $workSpaceType_search_user; ?>);

</script>