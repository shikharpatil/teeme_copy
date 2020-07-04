	<script language="javascript" type="application/javascript" src="<?php echo base_url();?>js/function_tablet.js"></script>
	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
	
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
	<script language="javascript" src="<?php echo base_url();?>js/document.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script language="javascript" src="<?php  echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	
	
	<!--Manoj: Script added for print feature -->
	<script src="https://www.google.com/cloudprint/client/cpgadget.js"></script>
	<script Language="JavaScript" src="<?php echo base_url();?>js/print/printArea.js"></script>
	<!--Manoj: code end-->

	
	<script language="JavaScript" src="<?php  echo base_url();?>js/pop_menu.js"></script>
<!--	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	
    
	<script language="JavaScript1.2">mmLoadMenus();</script>-->
	<!-- scripts for menu --->
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
	<!--/*Changed By surbhi IV*/-->
	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
	<!--/*End of Changed By surbhi IV*/-->
	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
	<!-- close here -->

	<!-- for sub modal -->
	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script>
	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
	
	<!-- CSSMenuMaker -->
	<!--<script language="javascript"  src="<?php echo base_url();?>js/cssmenumaker.js"></script>-->
	<!-- CSSMenuMaker -->
<script type="text/javascript">

//Manoj: Load more notifications on scroll down

/*$('#allNotificationData').scroll(function() {
	//console.log(($(this).scrollTop()+$(this).innerHeight()) +'======'+ $(this)[0].scrollHeight);
    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) 
	{
		var limit = $("div[class*='notification_url']").length;
		loadResults(limit); 
    }
}); 
 
function loadResults(limit) {
	$.ajax({
        url: baseUrl+'notifications/getMoreNotifications/',
        type: "post",
        data: {
            limit: limit
		},
        success: function(data) {
			if(data!='')
			{
				$(".notificationContent").html(data);
			}
		}
    });
};*/


//Manoj: code end


//Notification popup code start here
/*$(document).ready(function()
{*/
	$("#notificationLink").click(function()
	{
		$("#notificationContainer").fadeToggle(300);
		$("#notification_count").fadeOut("slow");
		return false;
	});
	//Document Click hiding the popup 
	$(document).click(function()
	{
		$("#notificationContainer").hide();
	});
	
/*});*/
//Notification popup code end here			

//status update popup start
/*
$('a.showreranks').click(function () {
  position = $(this).position();
  // $('body').append('<div class="overlay"></div>');
  if($('#statusPopup').is(":visible"))
  {
  	$('#statusPopup').hide();
  }
  else
  {
    $('#statusPopup').show();
    $('#statusPopup').css('top', position.top + 17);
  } 
  return false;
});
*/

function updateUserStatus()
{
	//alert($('#userStatus').val());
	var userStatus = $('#userStatus').val();
	data_user = 'userStatus='+userStatus; 
	$.ajax({
			  url: baseUrl+"preference/updateUserStatus/",
			  type: "POST",
			  data: data_user,
			  dataType: "html",
			  success:function(result)
			  {
			  	  if(result==1)
				  {
				  	$('.showreranks').prop('title', userStatus.trim());
					$('#userStatus').html(userStatus.trim());
				  	$('#statusPopup').hide();
					//jAlert('Status updated successfully!');
				  	//$('.statusUpdateMsg').html('<?php //echo $this->lang->line('txt_status_update_msg'); ?>');
				  }
			  }
	});
}

function cancelStatusPopup()
{
  $('#statusPopup').hide();
  document.getElementById("userStatusForm").reset();
}
//status update popup end	

//Reset value on cancel button
/*function resetEditorOnCancel(elementId) {
    var elementVal = document.getElementById(elementId);
    if (!elementVal.value || elementVal.value != elementVal.defaultValue) {
        elementVal.value = elementVal.defaultValue;
    }
}*/
	
			
function contactEdit()
{	
	var obj = document.getElementById('contactDetailsEdit'); 
	var obj1 = document.getElementById('contactDetails'); 
	var objHideShow = document.getElementById('hideShowDetails');
	
	if(obj.style.display == 'none')
	{
		obj.style.display = '';
		obj1.style.display = 'none';
		objHideShow.innerHTML = 'Hide Details';
	}
	else
	{
		obj.style.display = 'none';
		obj1.style.display = '';
		objHideShow.innerHTML = 'Hide Details';	
	}
	
}


  function showContactDetails()
{	
   
	var obj = document.getElementById('contactDetails'); 
	var obj1 = document.getElementById('contactDetailsEdit'); 
	var objHideShow = document.getElementById('hideShowDetails');
	if(obj.style.display == 'none')
	{
		obj.style.display = 'block';
		obj1.style.display = 'none';
		objHideShow.innerHTML = 'Hide Details';
	}
	else
	{
		obj.style.display = 'none';
		obj1.style.display = 'none';
		objHideShow.innerHTML = 'View Details';	
	}
	
}
$(document).ready(function() {

	if($(window).width()<760)
	{
		
		$("#artifact_tabs_for_smart_phone").css('display','inline'); 
		$("#artifact_tabs_for_web").css('display','none');
		$('#footer').css('padding-top','10px');     
	}
	else
	{
	    $("#artifact_tabs_for_smart_phone").css('display','none'); 
		$("#artifact_tabs_for_web").css('display','inline'); 
		//$('#footer').css('padding-top','22px');  //Manoj: reduced padding from 33px
	
	}
	window.addEventListener("orientationchange", function() {
		  var t=setTimeout(function(){
				if($(window).width()<760)
				{ 
				   $("#artifact_tabs_for_smart_phone").css('display','inline'); 
				   
				   $("#artifact_tabs_for_web").css('display','none');  
				   $('#footer').css('padding-top','10px');  
				}
				else
				{
					$("#artifact_tabs_for_smart_phone").css('display','none'); 
					$("#artifact_tabs_for_web").css('display','inline');  
					//$('#footer').css('padding-top','22px');  //Manoj: reduced padding from 33px
				}
		  },200)
	}, false);
	
});

</script>

<!--
  jCarousel skin stylesheet
-->
<script type="text/javascript">

$(document).ready(function() {
   // $('#jsddm').jcarousel();
});

</script>
<script type="text/javascript">

 if(mobile_detect('1','1',''))
 { 
    $('#logoutTxt').css('display','none');
 }
	
$(document).ready(function() {

    if($(window).width()<760 && $(window).width()>590)
	{
		$('#imgUsername').css('display','none');
		$('#spaceSelect').css('width','200px');
		$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo.png"  />');
		$('#logoImgA img').css('width','150px');
		
	}
	if($(window).width()<590 && $(window).width()>460)
	{
		$('#imgUsername').css('display','none');
		$('#spaceSelect').css('width','200px');
		$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo1.png"  />');
		$('#logoImgA img').css('width','40px');
		
	}
	if($(window).width()<460)
	{
		$('#imgUsername').css('display','none');
		$('#spaceSelect').css('width','100px');
		$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo1.png"  />');
		$('#logoImgA img').css('width','40px');
	}
    window.addEventListener("orientationchange", function() {
  // Announce the new orientation number
    
	var t=setTimeout(function(){
	if($(window).width()<760 && $(window).width()>590)
	{ 
		$('#imgUsername').css('display','none');
		$('#spaceSelect').css('width','200px');
		$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo.png"  />');
		$('#logoImgA img').css('width','150px');
		
	}
	else
	{
		if($(window).width()<590 && $(window).width()>460)
		{
			$('#imgUsername').css('display','none');
			$('#spaceSelect').css('width','200px');
			$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo1.png"  />');
			$('#logoImgA img').css('width','40px');
		}
		else
		{
	        if($(window).width()<460)
		    {
			    $('#imgUsername').css('display','none');
				$('#spaceSelect').css('width','100px');
				$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo1.png"  />');
				$('#logoImgA img').css('width','40px');
			}
			else
			{
				$('#imgUsername').css('display','inline');
				$('#spaceSelect').css('width','200px');
				$('#logoImgA').html('<img src="<?php echo base_url();?>images/logo.png"  />');
				$('#logoImgA img').css('width','150px');
			}	
		}	
	}
	
	},200)
    
}, false);
	
});

</script>
<?php 
if ($workSpaceId != '' && $workSpaceType != '' && $_SESSION['workPlacePanel'] != 1)
{
?>
<script>
		//check offline mode		
		/*setInterval(function () {
			//checkOfflineMode();
		}, 10000);*/
</script>


<!--Manoj: added a javascript for offline mode-->

<script>

//SetTimeOut Start

var u = 0;
//Add SetTimeOut 
setTimeout("showNotificationCount()", 20000);

function showNotificationCount(){
	$.ajax({
				url: baseUrl+'notifications/showNotificationCount',
				success:function(result)
				{
					//alert(result);
					if(result!='' && result!=0)
					{
						$('#notificationCount').show();
						$('#notificationCount').css({'background': 'none repeat scroll 0 0 #FA3E3E','color':'white'});
						$('#notificationCount').html(result);
					}
					else if(result==0)
					{
						$('#notificationCount').hide();
					}
					//console.log('test');
					//Add SetTimeOut 
					setTimeout("showNotificationCount()", 20000);
					
				}
		});
}

//SetTimeOut End

/*$(document).ready(function() {
	//checkOfflineMode();
	//showNotificationCount();
	//dispatchNotificationData();
});*/

/*setInterval(function () {
	showNotificationCount()
	//dispatchNotificationData()		
}, 5000);*/


function checkOfflineMode(){

	 $.ajax({

				url: baseUrl+'dashboard/getOfflineMode',

				success:function(result)
				{
					//alert(result.trim());
					if(result.trim()!='online')
					{
						$('body').html(result);
					}
				}
				, 
				async: true

		});
	//window.location.href = "<?php //echo base_url() ?>dashboard/getOfflineMode";
}




//Notification count for application end here




//On mouse hover change bookmark button color and text
function changeFollowStatusOver(seedId)
{
	var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(ismobile!=true && istablet!=true)
	{
		$('.marked'+seedId).css("background-color", "#CA2055");
		$('.marked'+seedId).text('<?php echo $this->lang->line('txt_object_unfollow') ?>');
	}
}
function changeFollowStatusOut(seedId)
{
	var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
	if(ismobile!=true && istablet!=true)
	{
		$('.marked'+seedId).css("background-color", "#999999");
		$('.marked'+seedId).text('<?php echo $this->lang->line('txt_object_following') ?>');
	}
}

function add_object_follow(seedId,followStatus,object_id=1)
{
		//alert(workSpaceId+'==='+workSpaceType);
		if(followStatus=='unfollow')
		{
			msg= '<?php echo $this->lang->line('txt_confirm_unfollow'); ?>';
	
			var agree = confirm(msg);
		
			if (agree)
		
			{
		
				$.ajax({
				type: "POST",
				url: baseUrl+"notifications/add_follow_status/"+seedId+"/0/"+workSpaceId+"/"+workSpaceType+"/"+object_id,
				cache: false,
				success:  function(result){
				  //alert(nodeId);
				  if(result==1)
				  {
					if(followStatus=='unfollow')
					{
						$('.followBtn'+seedId).html('<a class="bookmark2 follow_object" onclick="add_object_follow('+seedId+',\'follow\')"><?php echo $this->lang->line('txt_object_follow'); ?></a>');
					}
				  }
				}
				});
		   }
		   else
		   {
				return false;
		   }
		  }
		  else
		  {
		  	msg= '<?php echo $this->lang->line('txt_confirm_follow'); ?>';
	
			var agree = confirm(msg);
			//alert(seedId);
			//return false;
			if (agree)
			{
		  		$.ajax({
					type: "POST",
					url: baseUrl+"notifications/add_follow_status/"+seedId+"/1/"+workSpaceId+"/"+workSpaceType+"/"+object_id,
					cache: false,
					success:  function(result){
					  //alert(result);
					  if(result==1)
					  {
						if(followStatus=='follow')
						{
							$('.followBtn'+seedId).html('<a class="bookmarked2 marked'+seedId+' follow_object" onclick="add_object_follow('+seedId+',\'unfollow\')" onmouseover="changeFollowStatusOver('+seedId+')" onmouseout="changeFollowStatusOut('+seedId+')"><?php echo $this->lang->line('txt_object_following'); ?></a>');
						}
					  }
					}
				});
			}
		  }
}






//Manoj: code end
$(window).scroll(function (event) {
	var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
	if(isios==true)
	{
		if ($("body").hasClass("fr-fullscreen") != true) 
		{
			if($("#container").hasClass("contactWrapper") != true)
        	{
				var topDistance;  
				var offset = $(".fr-wrapper").offset();
				var w = $(window);
				var topPosition = offset.top-w.scrollTop();
				var deviceWidth = $(window).width();
				if(deviceWidth==768)
				{
					topDistance = 50;
				}
				else
				{
					topDistance = 25;
				}
				//console.log("(height): ("+($(".fr-toolbar").height())+")");
				//console.log($(window).width());
				if(topPosition<=topDistance)
				{
					$('#header-wrap').css({'position':'fixed','top':'0'});
					$('.fr-toolbar').hide();
					$('.commentEditorWrapper .fr-toolbar').show();
					$('.talkTreeComments .fr-toolbar').show();
				}
				else if(topPosition>topDistance)
				{
					$('.fr-toolbar').show();
				}
		
			}
		}
	}
});

$(document).ready(function() {

	var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
	if(navigator.userAgent.match('CriOS'))
	{
		var isChrome = 'true';
	}
	if(isios==true && isChrome=='true')
	{
		$("body").click(function(e) {
			if (e.target.id == "reply_teeme0" || $(e.target).parents("#reply_teeme0").size()) { 
			   // alert("Inside div");
				setTimeout(function(){
				 $('.abs #reply_teeme0').css('bottom','40px'); 
				},1000);
			} else { 
			   //$('.abs #reply_teeme0').css('bottom','0px'); 
			}
		});
	}
	
});

$(document).ready(function(){
				var element = $(".handCursor").hasClass("nodeBgColorSelect");
				var elementPost = $("#timelinePostContents").hasClass("nodeBgColorSelect");
				//alert(element+'=='+elementPost);
				//var element = $(".handCursor").find(".nodeBgColorSelect");
				if(element==true || elementPost==true)
				{
					//alert('test');
					var scroll= $(window).scrollTop();
					//alert(scroll);
					scroll= scroll-100;
					$('html, body').animate({
						scrollTop: scroll
					}, 100);
					$chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()); 
					if($chrome == true)
					{					
						$(window).one('scroll',function() {
							var scroll= $(this).scrollTop();
							//alert(scroll);
							scroll= scroll-100;
							$('html, body').animate({
								scrollTop: scroll
							}, 100);		
						});
					}
				}
				
				
 
});

</script>

<!--Manoj: code for adding froala js and css files-->
<?php $this->load->view('common/froala_editor');?>
<!--Manoj: code end-->
<?php
}
?> 

<script>

//Seen all notification start here
function seenAllNotification(){
	
	/*Added by Dashrath- hide notification side bar*/
	/*used 1 for hide and 2 for show*/
	var isNotificationSidebar = getCookie('is_notification_bar');

	if($('#notficationRightSidebar').css('display') == 'inline' || $('#notficationRightSidebar').css('display') == 'block')
	{
		document.getElementById("notficationRightSidebar").style.display = "none";

		/*Changed by Dashrath- change for when close right side bar left side bar not open*/
		//document.getElementById("leftSideBar").style.display = "inline";
		//document.getElementById("rightSideBar").style.width = 'calc(100% - 220px)';
		document.getElementById("rightSideBar").style.width = "100%";
		/*Dashrath- changes end*/

		document.getElementById("rightSideBar").style.cssFloat = "right";

		//delete left menu bar cookie
		/*Commented by Dashrath- comment for when close right side bar left side bar not open*/
    	//deleteLeftMenuSideBarCookie();

    	//get data type is notification or timeline (used for check condition)
		var myDataTypeValue1 = getRightSidebarDataType();

		if(myDataTypeValue1=='notification')
		{
			//set cookie (used 1 for hide)
			setNotificationSideBarCookie(1);
		}

		//set seed width
		setFixedSeedWidth();

		//set post tab width
		setPostTabBarWidth();
	}


	 $.ajax({
				url: baseUrl+'notifications/seenAllAppNotification',
				success:function(result)
				{
					//alert(result);
					if(result==1)
					{
						$('#notificationCount').hide();
					}
				}
		});
	dispatchNotificationData();	
}
//Seen all notification end here

//Dispatch notification for application start here
function dispatchNotificationData(){
	
	$(".notifyLoader").html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	 $.ajax({
				url: baseUrl+'notifications/setDispatchNotification',
				success:function(result)
				{
					//alert(result);
					if(result!='')
					{
						$('#notificationsBody').html(result);
						$(".notifyLoader").html("");
					}
				}
		});
}
//Dispatch notification for application end here

//Added all notification space filter here
function getSpaceNotifications(){
	var workSpaceId = $("#spaceNotifications").val();
	var notificationModeId = $("#modeNotifications").val();
	//return;
	
	//alert(workSpaceId);
	$.ajax({
				url: baseUrl+'notifications/setDispatchNotification',
				type: 'POST',
				data: { spaceId: workSpaceId, modeId: notificationModeId },
				success:function(result)
				{
					//alert(result);
					if(result!='')
					{
						$('#allNotificationsBody').html(result);
					}
				}
		});
}
//Added all notification space filter end here

/*Added by Dashrath- hide(1 for hide) show(blank) left menu bar*/
$(document).ready(function(){

	/*used 1 for hide and blank for show*/
	var isLeftMenu1 = getCookie('is_left_menu');

	/*Added by Dashrath- loader hide from left menu bar and  left menu content style blank*/
	document.getElementById("leftMenuBarLoader").style.display = "none";

	if(isLeftMenu1!=1)
	{
		document.getElementById("left-menu-nav1").style.display = "";
	}
	/*Dashrath- code end*/

	//Add for hight left menu bar for tablet resoultion by default
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));

	/*used 1 for hide and blank for show*/
	//var isLeftMenu1 = getCookie('is_left_menu');

	/*used 1 for hide and 2 for show*/
	var isNotificationSidebar = getCookie('is_notification_bar');

	if(isNotificationSidebar==1)
	{
		//1 for change and 0 for no change
		var dataChange = 0;
		seeAllNotificationData(workSpaceId, workSpaceType, dataChange);
	}

	if(isNotificationSidebar==2)
	{
		document.getElementById("leftSideBar").style.display = "none";
		document.getElementById("rightSideBar").style.cssFloat = "left";

		// document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		if(istablet==true)
		{
			document.getElementById("rightSideBar").style.width = 'calc(100% - 222px)';
		}
		else
		{
			document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		}
		
		
		var dataChange = 1;
		seeAllNotificationData(workSpaceId, workSpaceType, dataChange);

		//document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "none"; 
   		document.getElementById("notficationRightSidebar").style.display = "inline";
	}
	else if(isLeftMenu1==1)
	{
		document.getElementById("leftSideBar").style.display = "none";
		document.getElementById("rightSideBar").style.width = "100%";
	}
	else if(istablet==true)
	{
		document.getElementById("leftSideBar").style.display = "none";
		document.getElementById("rightSideBar").style.width = "100%";
		//set left menu cookie (used 1 for hide)
		setLeftMenuSideBarCookie(1);
	}

	/*Added by Dashrath- left menu content style blank*/
	if(isLeftMenu1==1)
	{
		document.getElementById("left-menu-nav1").style.display = "";
	}
	/*Dashrath- code end*/

	//hide notification side bar
	//set cookie (used 1 for hide)
	//setNotificationSideBarCookie(1);

	/*delete cookie*/
	//deleteNotificationSideBarCookie();

	/*set seed width when fixed on top*/
	setFixedSeedWidth();
});

function getRightSidebarDataType()
{
	//get data type is notification or timeline (used for check condition)
	var dataTypeRecord = document.getElementById("dataType");

    if(dataTypeRecord)
    {
        var myDataTypeValue = dataTypeRecord.value;
    }
    else
    {
    	var myDataTypeValue ='';
    }

    return myDataTypeValue;
}

function leftMenuHideShow()
{
	//1for hide and blank for show
	var isLeftMenu = getCookie('is_left_menu');

	//1for hide and 2 for show
	var isNotificationSidebar = getCookie('is_notification_bar');

	//get data type is notification or timeline (used for check condition)
	var myDataTypeValue1 = getRightSidebarDataType();

	///alert('left menu= '+isLeftMenu);
	
	if(isLeftMenu=='')
	{
		//set left menu cookie (used 1 for hide)
		setLeftMenuSideBarCookie(1);
		// document.getElementById("leftSideBar").style.width = "0px";
		// document.getElementById("left-menu-nav1").style.display = "none";
		document.getElementById("leftSideBar").style.display = "none";
		document.getElementById("rightSideBar").style.width = "100%";
		document.getElementById("postArea").style.width = '73%';
		//$('.post_web_tab_menu_tab').css('width', '25%');

		
		/*Commented by Dashrath- Comment this code for when hide left menu right side bar not open*/
		// if(myDataTypeValue1=='notification' || myDataTypeValue1=='timeline' || myDataTypeValue1=='draftleaf')
		// {
		// 	// showNotificationSidebar();

		// 	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));

		// 	if(isNotificationSidebar==2 && myDataTypeValue1=='notification')
		// 	{
		// 		//set cookie (used 2 for show)
		// 		//setNotificationSideBarCookie(2);
		// 		document.getElementById("notficationRightSidebar").style.display = "inline";
		// 		document.getElementById("rightSideBar").style.cssFloat = "left";

  //  				// document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)'; 
  //  				if(istablet==true)
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 222px)';
		// 		}
		// 		else
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		// 		}
		// 	}
			
		// 	if(myDataTypeValue1=='timeline')
		// 	{
		// 		//document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "none"; 
  //  				document.getElementById("notficationRightSidebar").style.display = "inline"; 
  //  				document.getElementById("rightSideBar").style.cssFloat = "left";

  //  				// document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
  //  				if(istablet==true)
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 222px)';
		// 		}
		// 		else
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		// 		}
  //  			}

  //  			if(myDataTypeValue1=='draftleaf')
		// 	{
		// 		//document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "none"; 
  //  				document.getElementById("notficationRightSidebar").style.display = "inline"; 
  //  				document.getElementById("rightSideBar").style.cssFloat = "left";

  //  				// document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
  //  				if(istablet==true)
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 222px)';
		// 		}
		// 		else
		// 		{
		// 			document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		// 		}
  //  			}
		// }

		/*Dashrath- code end*/
	}
	else
	{
		//show left menu bar
		//delete cookie
		deleteLeftMenuSideBarCookie();
		document.getElementById("rightSideBar").style.width = 'calc(100% - 220px)';
		// document.getElementById("leftSideBar").style.width = "180px";
		// document.getElementById("left-menu-nav1").style.display = "inline";
		document.getElementById("leftSideBar").style.display = "inline";
		document.getElementById("postArea").style.width = '60%';
		//$('.post_web_tab_menu_tab').css('width', '22%');

		if(myDataTypeValue1=='notification' || myDataTypeValue1=='timeline' || myDataTypeValue1=='draftleaf')
		{
		
			// hideNotificationSidebar();
			if(isNotificationSidebar==2 && myDataTypeValue1=='notification')
			{
				//set cookie (used 1 for hide)
				//setNotificationSideBarCookie(1);
			}
			document.getElementById("notficationRightSidebar").style.display = "none";
			// document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "inline";
			document.getElementById("rightSideBar").style.cssFloat = "right";  
		}
	}

	//set seed div width
	setFixedSeedWidth();

	//set post tab width
	setPostTabBarWidth();
}
/*Dashrath- code end*/

/*Added by Dashrath- delete cookie*/
function deleteLeftMenuSideBarCookie()
{
	//delete cookie
	document.cookie = "is_left_menu=''; expires = Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}
/*Dashrath- code end*/

/*Added by Dashrath- set cookie*/
function setLeftMenuSideBarCookie(cookieValue)
{
	var daysToExpire = 1095;
	var date = new Date();
	date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
	//set cookie
	document.cookie = "is_left_menu=" +cookieValue+ "; expires=" + date.toGMTString() +"; path=/";
}
/*Dashrath- code end*/

/*Added by Dashrath- set cookie*/
function setNotificationSideBarCookie(cookieValue)
{
	var daysToExpire = 1095;
	var date = new Date();
	date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
	//set cookie (used 1 for hide and 2 for hide)
	document.cookie = "is_notification_bar=" +cookieValue+ "; expires=" + date.toGMTString() +"; path=/";
}
/*Dashrath- code end*/

/*Added by Dashrath- delete cookie*/
function deleteNotificationSideBarCookie()
{
	//delete cookie
	document.cookie = "is_notification_bar=''; expires = Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}
/*Dashrath- code end*/

/*Added by Dashrath- setFixedSeedWidth function start*/
function setFixedSeedWidth()
{
	// var isLeftMenu1 = getCookie('is_left_menu');
	// var isNotificationSidebar = getCookie('is_notification_bar');

	if($('#leftSideBar').css('display') == 'none')
	{	
		//used 1 for hide left menu bar
		var isLeftMenu1 = 1;
	}
	else
	{
		//used blank for show left menu bar
		var isLeftMenu1 = '';
	}

	if($('#notficationRightSidebar').css('display') == 'none')
	{
		//used 1 for hide right timeline and notification sidebar
		var isNotificationSidebar = 1;

		$('#scroll_top').css('right', '');
		$('#scroll_bottom').css('right', '');
	}
	else
	{
		//used 2 for show right timeline and notification sidebar
		var isNotificationSidebar = 2;

		// $('#scroll_top').css('right', '382px');
		// $('#scroll_bottom').css('right', '382px');

		/*Added by Dashrath- check device*/
        var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
          
	    if(istablet==true)
	    {
	        $('#scroll_top').css('right', '232px');
			$('#scroll_bottom').css('right', '232px');
	    }
	    else
	    {
	    	$('#scroll_top').css('right', '382px');
			$('#scroll_bottom').css('right', '382px');
	    }
        /*Dashrath- code end*/

	}

	//alert('isLeftMenu1='+isLeftMenu1+" "+' isNotificationSidebar='+isNotificationSidebar)

	/*Added by Dashrath- check device*/
	var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));

	if(isLeftMenu1=='1' && isNotificationSidebar=='1')
	{
		// alert('both hide');
		// var subWidth = '-=56px';

		/*Commented by Dashrath- comment old code and add new code below with if else condition*/
		// var subWidth = '-=69px';
		if(istablet==true)
		{
			var subWidth = '-=52px';
		}
		else
		{
			var subWidth = '-=69px';
		}
		
	}
	else if(isLeftMenu1=='1' && isNotificationSidebar=='2')
	{
		// alert('left menu hide timeline show');
		/*Commented by Dashrath- comment old code and add new code below with if else condition*/
		// var subWidth = '-=441px';
		if(istablet==true)
		{
			// var subWidth = '-=424px';
			var subWidth = '-=274px';
		}
		else
		{
			var subWidth = '-=441px';
		}
	}
	else if(isLeftMenu1!='1' && isNotificationSidebar=='1')
	{
		// alert('timeline menu hide left menu show');
		/*Commented by Dashrath- comment old code and add new code below with if else condition*/
		// var subWidth = '-=290px';
		if(istablet==true)
		{
			var subWidth = '-=272px';
		}
		else
		{
			var subWidth = '-=290px';
		}
	}
	else if(isLeftMenu1!='1')
	{
		// alert('timeline menu hide left menu show else');
		/*Commented by Dashrath- comment old code and add new code below with if else condition*/
		// var subWidth = '-=288px';
		if(istablet==true)
		{
			var subWidth = '-=270px';
		}
		else
		{
			var subWidth = '-=288px';
		}
	}
	else
	{
		// alert('else')
		/*Commented by Dashrath- comment old code and add new code below with if else condition*/
		// var subWidth = '-=69px';
		if(istablet==true)
		{
			var subWidth = '-=52px';
		}
		else
		{
			var subWidth = '-=69px';
		}
	}
	
	$('.documentTreeFixed').css('width', screen.width).css('width', subWidth);
}

/*Added by Dashrath- delete cookie*/
function removeFixedSeedWidth()
{
	$('.documentTreeFixed').css('width', '');
}
/*Dashrath- code end*/


/*Added by Dashrath- seeAllNotificationData function start*/
function seeAllNotificationData(workSpaceId, workSpaceType, dataChange)
{
	/*Added by Dashrath- add for set parameter default value*/
	if(dataChange === undefined) {
	    dataChange = 1;
	}
	/*Dashrath- code end*/

	$.ajax({
		url: baseUrl+'notifications/setDispatchNotification/'+workSpaceId+'/'+workSpaceType,
		type: 'GET',
		async:false,
		success:function(result)
		{
			if(result!='')
			{
				if(dataChange==1)
		        {
					document.getElementById("notficationRightSidebar").style.display = "inline";
			        // document.getElementById("rightSideBar").style.width = "80%";

			        // document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
			        /*Added by Dashrath- check device*/
		            var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
		          
		          	if(istablet==true)
		          	{
		            	document.getElementById("rightSideBar").style.width = 'calc(100% - 222px)';
		          	}
		          	else
		          	{
		            	document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
		          	}
		          	/*Dashrath- code end*/

			        document.getElementById("rightSideBar").style.cssFloat = "left";
			        // document.getElementById("left-menu-nav1").style.display = "none";
			        // document.getElementById("leftSideBar").style.width = "0px";
			        document.getElementById("leftSideBar").style.display = "none";
			        //set cookie (used 2 for show)
		        	setNotificationSideBarCookie(2);

		        	//set left menu cookie (used 1 for hide)
		        	setLeftMenuSideBarCookie(1);
		        }
		        
		        $('#notficationRightSidebar').html(result);

		        //set seed width when seed fixed on top
		        setFixedSeedWidth();
			}
		}
	});
}
/*Dashrath- code end*/

/*Added by Dashrath- notification content highlight*/
function notificationContentHighlight(notification_dispatch_id)
{
  if(notification_dispatch_id>0)
  {
  	var previousNotficationClickId = document.getElementById("previousNotficationClickId").value;

  	if(previousNotficationClickId>0)
  	{
  		//used for notification content
        $('.notfi_'+previousNotficationClickId).removeClass('timelineContentDivStyle');
  	}

  	//used for notification content
    $('.notfi_'+notification_dispatch_id).addClass('timelineContentDivStyle');

    document.getElementById("previousNotficationClickId").value = notification_dispatch_id;
  }
}
/*Dashrath- code end*/


/*Added by Dashrath- call on scroll*/
$('#notficationRightSidebar').scroll(function() {
	
	var workSpaceIdNew = $("#spaceNotifications").val();
	var notificationModeId = $("#modeNotifications").val();

	if(workSpaceIdNew==='')
	{
		if($('#notficationRightSidebar').scrollTop() + $('#notficationRightSidebar').height() > $("#notificationSection").height())
	  	{
		  	var lastId = $(".all_notification_url:last").attr("id");

		  	var lastId1 = $(".notification_url:last").attr("id");

		  	if(lastId>0)
		  	{
		  		$(".scrollNotifyLoader").html("<div id='overlay' style='margin:1% 0;padding-left:7px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
			  	$.ajax({
						url: baseUrl+'notifications/setDispatchNotification/'+workSpaceId+'/'+workSpaceType+'/scroll/'+lastId,
						type: 'GET',
						async:false,
						success:function(result)
						{
							if(result!='')
							{
								$('#allNotificationsBody').append(result);
							}

							$(".scrollNotifyLoader").html("");
						}
					});
		  	}
		  	else if(lastId==undefined && lastId1>0)
		  	{
		  		getNotificationDataOnScroll(workSpaceIdNew, notificationModeId, lastId1);

		  	}
		}
	}
	else
	{

		if($('#notficationRightSidebar').scrollTop() + $('#notficationRightSidebar').height() > $("#notificationSection").height())
	  	{
		  	var lastId = $(".notification_url:last").attr("id");

		  	if(lastId>0)
		  	{
		  		getNotificationDataOnScroll(workSpaceIdNew, notificationModeId, lastId);
		  	}
		}

	}
});

function getNotificationDataOnScroll(workSpaceIdNew, notificationModeId, lastId)
{
	$(".scrollNotifyLoader").html("<div id='overlay' style='margin:1% 0;padding-left:7px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
  	$.ajax({
			url: baseUrl+'notifications/setDispatchNotification',
			type: 'POST',
			data: { spaceId: workSpaceIdNew, modeId: notificationModeId, dataGetType:'scroll', lastId:lastId },
			async:false,
			success:function(result)
			{
				//alert(result);
				if(result!='' && result.trim()!='No notifications yet')
				{
					$('.notificationContent').append(result);
				}

				$(".scrollNotifyLoader").html("");
			}
		});
}
/*Dashrath- code end*/

/*Added by Dashrath- call on scroll*/
$("#allNotificationData").scroll(function() {

	if($("#allNotificationData").scrollTop() + $("#allNotificationData").height() > $("#notificationsBody").height())
  	{
	  	var lastId = $(".notification_url:last").attr("id");

	  	if(lastId>0)
	  	{
	  		$(".scrollNotifyLoader").html("<div id='overlay' style='margin:1% 0;padding-left:7px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
		  	$.ajax({
					url: baseUrl+'notifications/setDispatchNotification',
					type: 'POST',
					data: { dataGetType:'scroll', lastId:lastId },
					async:false,
					success:function(result)
					{
						//alert(result);
						if(result!='' && result.trim()!='No notifications yet')
						{
							$('#notificationContent').append(result);
						}

						$(".scrollNotifyLoader").html("");
					}
				});
	  	}
	}
});
/*Dashrath- code end*/

/*Added by Dashrath- hide notification side bar*/
function hideNotificationSidebar() {
	document.getElementById("notficationRightSidebar").style.display = "none"; 
	//document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "inline"; 

	/*Changed by Dashrath- change for when close right side bar left side bar not open*/
	//document.getElementById("leftSideBar").style.display = "inline";
	//document.getElementById("rightSideBar").style.width = 'calc(100% - 220px)';
	document.getElementById("rightSideBar").style.width = "100%";
	/*Dashrath- changes end*/

	document.getElementById("rightSideBar").style.cssFloat = "right";

	//delete left menu bar cookie
	/*Commented by Dashrath- comment for when close right side bar left side bar not open*/
    //deleteLeftMenuSideBarCookie();

    //get data type is notification or timeline (used for check condition)
	var myDataTypeValue1 = getRightSidebarDataType();

	if(myDataTypeValue1=='notification')
	{
		//set cookie (used 1 for hide)
		setNotificationSideBarCookie(1);
	}

	//set seed width
	setFixedSeedWidth();

	//set post tab width
	setPostTabBarWidth();
};
/*Dashrath- code end*/
/*Added by Dashrath- show notification side bar*/
function showNotificationSidebar() {
   document.getElementById("notficationRightSidebarShowButtonDiv").style.display = "none"; 
   document.getElementById("notficationRightSidebar").style.display = "inline"; 
   document.getElementById("leftSideBar").style.display = "none";
   document.getElementById("rightSideBar").style.width = 'calc(100% - 372px)';
   document.getElementById("rightSideBar").style.cssFloat = "left";

    //set left menu cookie (used 1 for hide)
	setLeftMenuSideBarCookie(1);

	//get data type is notification or timeline (used for check condition)
	var myDataTypeValue1 = getRightSidebarDataType();

	if(myDataTypeValue1=='notification')
	{
		//set cookie (used 2 for show)
		setNotificationSideBarCookie(2);
	}
    
	//set seed width
	setFixedSeedWidth();

	//set post tab width
	setPostTabBarWidth();

};
/*Dashrath- code end*/
</script>

<div class="clr"></div>
<!--Manoj: added scroll to bottom button-->
<a href="#" id="scroll_bottom" title="Scroll to Bottom" style="display: none;">Bottom<span></span></a>

<!--Manoj: added scroll to top button-->
<a href="#" id="scroll_top" title="Scroll to Top" style="display: none;">Top<span></span></a>

<!--Added by Dashrath- this is used in footer.php but we comment footer.php so this code is add in foot.php-->
<input id="usrtagname" type="hidden" value="<?php echo $_SESSION['userTagName']; ?>" />
<!--Dashrath- code end-->