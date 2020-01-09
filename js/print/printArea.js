//Code for print tree

function printDiv(divName) {
  //alert('test');
  var ua = navigator.userAgent.toLowerCase();
  var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
  var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));

  	if (isAndroid) 
	{
	  var MenuContents = $(".menu_new").html();
	  var MoveTreeContents = document.getElementById("spanMoveTree").innerHTML;
	  var SeedDropDown = document.getElementById("ulNodesHeader0").innerHTML;
	  
	  $(".menu_new").html(' ');
	  $("#spanMoveTree").html(' ');
	  $("#ulNodesHeader0").html(' ');
	  
	  // https://developers.google.com/cloud-print/docs/gadget
	  //alert(window.location.href+'.php');
	  //alert($("html").html());
      var gadget = new cloudprint.Gadget();
	  gadget.setPrintDocument("text/html", 'Teeme Tree Print' , $("#"+divName).html() , "utf-8");
	  //gadget.setPrintDocument("url", 'Teeme' , "https://www.google.com/landing/cloudprint/testpage.pdf" , "utf-8");
      gadget.openPrintDialog();
	  $(".menu_new").html(MenuContents);
	  $("#spanMoveTree").html(MoveTreeContents);
	  $("#ulNodesHeader0").html(SeedDropDown);
	  $("#ulNodesHeader0 #ulTreeOption").hide();
    } 
	else if(isios==true)
	{
		var SeedDropDown = document.getElementById("ulNodesHeader0").innerHTML;
		$("#ulNodesHeader0").html(' ');
		//$(".tab_menu_new").hide();
		$(".tab_menu_new").css({"display":"none"});
		
		var printContents = document.getElementById(divName).innerHTML;
		//alert(printContents);
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		//document.body.innerHTML = originalContents;
		
		$('#jsddm > li').bind('click', jsddm_open);
	
		$('#jsddm > li').bind('mouseover', jsddm_open_hover);
	
		$('#jsddm > li').bind('mouseout',  jsddm_timer);
	
		$('#jsddm1 > li').bind('click', jsddm_open);
	
		$('#jsddm1 > li').bind('mouseover', jsddm_open_hover);
	
		$('#jsddm1 > li').bind('mouseout',  jsddm_timer);
		
		$("#ulNodesHeader0").html(SeedDropDown);
		$("#ulNodesHeader0 #ulTreeOption").hide();
		//$(".tab_menu_new").show();
		//$(".tab_menu_new").css({"display":"block"});
		
		//window.print();
	}
	else 
	{
		var SeedDropDown = document.getElementById("ulNodesHeader0").innerHTML;
		$("#ulNodesHeader0").html(' ');
		$(".tab_menu_new").hide();
		$("#reply0").hide();

		/*Added by Dashrath- add for new ui*/
		$(".commonSeedHeader").hide();
		$(".commonSeedFooter").hide();
		/*Dashrath- code end*/
		
		//$(".tab_menu_new").css({"display":"none"});
		
		var printContents = document.getElementById(divName).innerHTML;
		//alert(printContents);
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		
		$('#jsddm > li').bind('click', jsddm_open);
	
		$('#jsddm > li').bind('mouseover', jsddm_open_hover);
	
		$('#jsddm > li').bind('mouseout',  jsddm_timer);
	
		$('#jsddm1 > li').bind('click', jsddm_open);
	
		$('#jsddm1 > li').bind('mouseover', jsddm_open_hover);
	
		$('#jsddm1 > li').bind('mouseout',  jsddm_timer);
		
		$("#ulNodesHeader0").html(SeedDropDown);
		$("#ulNodesHeader0 #ulTreeOption").hide();
		$(".tab_menu_new").show();
		$("#reply0").show();

		/*Added by Dashrath- add for new ui*/
		$(".commonSeedHeader").show();
		$(".commonSeedFooter").show();
		$("#ulTreeOption").hide();
		/*Dashrath- code end*/

		//$(".tab_menu_new").css({"display":"block"});
		
		//window.print();
	}
    return false;

}