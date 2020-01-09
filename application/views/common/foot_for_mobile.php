<script language="javascript" type="application/javascript" src="<?php echo base_url();?>js/function_tablet.js"></script>
	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
	<?php /*?><script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.js"></script><?php */?>
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
	
	<!--<script Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>-->
	<script Language="JavaScript" src="<?php echo base_url();?>js/colorbox/jquery.colorbox.js"></script>
<!--    <script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	<script language="JavaScript1.2">mmLoadMenus();</script>-->
	<!-- scripts for menu --->
	<!--<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.4.4.min.js"></script>-->
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
	<!--/*Changed By surbhi IV*/-->
	<!--<script type="text/javascript" language="javascript" src="js/modal-window.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
	<!--/*End of Changed By surbhi IV*/-->
	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
	<!-- close here -->

	<!-- for sub modal -->
	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script>
	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/lib/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
	<script language="javascript" src="<?php echo base_url();?>js/contact/contact.js"></script>
	<!-- CSSMenuMaker -->
	<!--<script language="javascript"  src="<?php //echo base_url();?>js/cssmenumaker.js"></script>-->
	<!-- CSSMenuMaker -->
	<!--slick nav menu js-->
	<script language="javascript" src="<?php echo base_url();?>js/jquery.slicknav.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
	<!--slick nav menu js-->
	<?php /*?><script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script><?php */?>
  	<!--jCarousel skin stylesheet-->

<!--Manoj: slick nav menu js start-->

<script type="text/javascript">

//Manoj: Load more notifications on scroll down

$('#allNotificationData').scroll(function() {
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
};


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


//$.noConflict();
jQuery(document).ready(function($){

	//Manoj: Script for footer menu

	$(".menu-item-text").click(function(){
		
		if($(this).hasClass('hover')==true)
		{
			$(this).removeClass('hover');
			$(".demo-menu").fadeOut(300);
		}
		else
		{
			$(".demo-menu").slideDown(1000, "easeOutBounce");
			$(this).addClass('hover');
		}
	});
	//Manoj: footer menu script end
	
	$('#menuSlick').slicknav({
		label: 'MENU',
		duration: 1000,
		easingOpen: "easeOutBounce"
	});
});
</script>

<!--Manoj: slick nav menu js end-->

<script type="text/javascript">

$(document).ready(function() {
	$("#artifact_tabs_for_smart_phone").css('display','inline'); 
});

</script>
<script type="text/javascript">

	
$(document).ready(function() {

  
	if($(window).width()<590 && $(window).width()>460)
	{
		$('#spaceSelect').css('width','200px');
	}
	if($(window).width()<460)
	{
		$('#spaceSelect').css('width','100px');
	}
    window.addEventListener("orientationchange", function() {
  // Announce the new orientation number
    
	var t=setTimeout(function(){
	if($(window).width()<590 && $(window).width()>460)
	{
		$('#spaceSelect').css('width','200px');
	}
	else
	{
		if($(window).width()<460)
		{
			$('#spaceSelect').css('width','100px');
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

		checkWallAlerts2(<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>);
		
		//Arun-chekcing messages
		messageNotification(<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>);
		
</script>
<?php
//
?>
<!--Manoj: added a javascript for offline mode-->
<script>
$(document).ready(function() {
    //checkOfflineMode();
	//showNotificationCount();
	//dispatchNotificationData();
});

/*setInterval(function () {
	//checkOfflineMode(),
	showNotificationCount()
	//dispatchNotificationData()		
}, 10000);*/

//Add SetTimeOut 
setTimeout("showNotificationCount()", 10000);

function checkOfflineMode(){

	 $.ajax({

				url: baseUrl+'dashboard/getOfflineMode',

				success:function(result)
				{
					if(result!='online')
					{
						$('body').html(result);
					}
				}
				, 
				async: false

		});
	//window.location.href = "<?php //echo base_url() ?>dashboard/getOfflineMode";
}



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
					//Add SetTimeOut 
					setTimeout("showNotificationCount()", 10000);
				}
		});
}
//Notification count for application end here

//Seen all notification start here
function seenAllNotification(){
	
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

<!--Manoj: code for follow and unfollow buttons on mouse hover-->

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

function add_object_follow(seedId,followStatus)
{
		if(followStatus=='unfollow')
		{
			msg= '<?php echo $this->lang->line('txt_confirm_unfollow'); ?>';
	
			var agree = confirm(msg);
		
			if (agree)
		
			{
		
				$.ajax({
				type: "POST",
				url: baseUrl+"notifications/add_follow_status/"+seedId+"/0",
				cache: false,
				success:  function(result){
				  //alert(nodeId);
				  if(result==1)
				  {
					if(followStatus=='unfollow')
					{
						$('.followBtn'+seedId).html('<a class="bookmarkMob follow_object_mob" onclick="add_object_follow('+seedId+',\'follow\')"><img style="cursor:pointer;height:25px;border:0px; margin-top:4px;"  src="<?php echo base_url();?>images/follow.png"></a>');
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
					url: baseUrl+"notifications/add_follow_status/"+seedId+"/1",
					cache: false,
					success:  function(result){
					  //alert(nodeId);
					  if(result==1)
					  {
						if(followStatus=='follow')
						{
							$('.followBtn'+seedId).html('<a class="bookmarkedMob marked'+seedId+' follow_object_mob" onclick="add_object_follow('+seedId+',\'unfollow\')" onmouseover="changeFollowStatusOver('+seedId+')" onmouseout="changeFollowStatusOut('+seedId+')"><img style="cursor:pointer;height:25px;border:0px;margin-top:4px;"  src="<?php echo base_url();?>images/following.png"></a>');
						}
					  }
					}
				});
			}
		  }
}



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

//Manoj: code end
$(window).scroll(function (event) {
		//var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));

		if ($("body").hasClass("fr-fullscreen") != true) 
		{
        	if($("#container_for_mobile").hasClass("contactWrapper") != true)
        	{
				var topDistance;  
				var offset = $(".fr-wrapper").offset();
				var w = $(window);
				var topPosition = offset.top-w.scrollTop();
				var deviceWidth = $(window).width();
				if(deviceWidth<480)
				{
					topDistance = 30;
				}
				else
				{
					topDistance = 25;
				}
				//console.log(topDistance);
				//console.log(topPosition);
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
});
</script>
<?php
}
?>
<!--Manoj: code end-->

<!--Manoj: code for adding froala js and css files-->
<?php $this->load->view('common/froala_editor');?>
<!--Manoj: code end-->
<!--Manoj: script added for curious date time picker -->
	 	
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/scroll_date_time/dist/DateTimePicker.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/scroll_date_time/dist/DateTimePicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/scroll_date_time/dist/i18n/DateTimePicker-i18n.js"></script>
		
<!--Manoj: code end-->