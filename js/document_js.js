var editorArray=new Array();

var ua = navigator.userAgent.toLowerCase();

var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

var verIos = iOSversion();

var disableEditor;

//condition to check editor support for android and ios < 5.if disableEditor is set to 1 then editor will not load.



//if(isAndroid || verIos[0] < 5){
	if(verIos[0] < 5){

  //alert("test success");

  $('#editorChoiceMessage').show();

  $('#editorChoice').hide();

  disableEditor = 1;

  $('#config').hide();

}

else if(getCookie('disableEditor') == 1){

  disableEditor = 1;

}

else{

  disableEditor = 0;

}



$(document).ready(function(){

	editorCheck();
	
	var myTasksCount = $('#myTasksCount').val();
	var myTagsCount = $('#myTagsCount').val();
	//alert(myTasksCount);
	if(myTasksCount==1)
	{
		$('.dashboard_my_task').remove();
	}
	else
	{
		$('.dashboard_my_task').show();
	}
	if(myTagsCount==1)
	{
		$('.dashboard_my_tag').remove();
	}
	else
	{
		$('.dashboard_my_tag').show();
	}

	//code to remove style info from system tagged content

	$('.autoNumberContainer').next().find(".red_systemTag , .yellow_systemTag ,.green_systemTag ,.blue_systemTag ,.gray_systemTag > *").removeClass();

	$('.autoNumberContainer').next().find(".red_systemTag , .yellow_systemTag ,.green_systemTag ,.blue_systemTag ,.gray_systemTag > *").attr('style',"");

	

	//function to trigger alerts before navigating if session has expired.

	/*$(window).bind("beforeunload",function(e){

		$.ajax({

		  type: 'POST',

		  url: baseUrl+"login_check/verifySession",

		  success: function(data){

				if(data==0 && document.URL.search("admin_logout")==-1 && $("[value='Login']").length==0){

					e.preventDefault();

				}

			},

		  async:false //to make unload event happen after ajax call

		});

	});*/
	
});



function editorCheck(){

	if(disableEditor==1){

		$('.editLeafMobile').hide();

		var url = document.URL;

/*		if(url.indexOf('task')!=-1){

			$('textarea').live(function(){alert($(this).attr('name'));$(this).hide();});

		}

		else{

			$('.editDocumentOption').hide();

		}*/

	}

}





//function to determine iOS version to disable ckeditor- Monika

function iOSversion(){

  if (/iP(hone|od|ad)/.test(navigator.platform)) {

    // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>

    var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);

    return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];

  }

  else{

  	return 0;

  }

}

$("body").click(function(){
	//$(".fr-popup").addClass("fr-active");
	//$(".fr-popup").css({'display':'block'});
});

//Manoj: code to change textarea to editor start

function chnage_textarea_to_editor(textareaId,version)
{
	
//alert ('disable= ' +disableEditor);
//Check if editor was disable or not
if(disableEditor==0)
{
	
//RECORDER CODE START
  $.extend($.FroalaEditor.POPUP_TEMPLATES, {
    "customPlugin.popup": '[_BUTTONS_]'
  });
  
  $.extend($.FroalaEditor.POPUP_TEMPLATES, {
    "dropdowncustomPlugin.popup": '[_BUTTONS_]'
  });

  // Define popup buttons.
  $.extend($.FroalaEditor.DEFAULTS, {
    popupButtons: ['popupStopped', 'popupLoader', 'popupButton1', 'popupButton2', 'popupClose'],
	dropdownButtons: ['bold', 'italic', 'underline', 'formatOL'],
  });
  
  
  //Toolbar options drop down code start
  
   // The custom popup is defined inside a plugin (new or existing).
  $.FroalaEditor.PLUGINS.dropdowncustomPlugin = function (editor) {
    // Create custom popup.
    function initPopup () {
      // Popup buttons.
      var dropdown_buttons = '';

      // Create the list of buttons.
      if (editor.opts.dropdownButtons.length > 1) {
        dropdown_buttons += '<div class="fr-buttons">';
        dropdown_buttons += editor.button.buildList(editor.opts.dropdownButtons);
        dropdown_buttons += '</div>';
      }
	  

      // Load popup template.
      var template = {
        buttons: dropdown_buttons,
        /*custom_layer: '<div class="custom-layer" style="text-align:center">Hello World!</div>'*/
      };

      // Create popup.
      var $popup = editor.popups.create('dropdowncustomPlugin.popup', template);

      return $popup;
    }

    // Show the popup
    function showPopup () {
      // Get the popup object defined above.
      var $popup = editor.popups.get('dropdowncustomPlugin.popup');

      // If popup doesn't exist then create it.
      // To improve performance it is best to create the popup when it is first needed
      // and not when the editor is initialized.
      if (!$popup) $popup = initPopup();
	  //else hidePopup();

      // Set the editor toolbar as the popup's container.
      editor.popups.setContainer('dropdowncustomPlugin.popup', editor.$tb);
	  
	  // This will trigger the refresh event assigned to the popup.
      // editor.popups.refresh('customPlugin.popup');

      // This custom popup is opened by pressing a button from the editor's toolbar.
      // Get the button's object in order to place the popup relative to it.
      var $btn = editor.$tb.find('.fr-command[data-cmd="dropdownButton"]');

      // Set the popup's position.
      var left = $btn.offset().left + $btn.outerWidth() / 2;
      var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

	   // Show the custom popup.
      // The button's outerHeight is required in case the popup needs to be displayed above it.
      editor.popups.show('dropdowncustomPlugin.popup', left, top, $btn.outerHeight());
	  
	 // $('.fr-element').prop('contenteditable','false');
	 // $('.fr-element').prop('contenteditable','true');
	  
    }

    // Hide the custom popup.
    function hidePopup () {
      editor.popups.hide('dropdowncustomPlugin.popup');
	}

    // Methods visible outside the plugin.
    return {
      showPopup: showPopup,
      hidePopup: hidePopup
    }
  }
  
  //toolbar options drop down end

  // The custom popup is defined inside a plugin (new or existing).
  $.FroalaEditor.PLUGINS.customPlugin = function (editor) {
    // Create custom popup.
    function initPopup () {
      // Popup buttons.
      var popup_buttons = '';

      // Create the list of buttons.
      if (editor.opts.popupButtons.length > 1) {
        popup_buttons += '<div class="fr-buttons">';
        popup_buttons += editor.button.buildList(editor.opts.popupButtons);
        popup_buttons += '</div>';
      }
	  

      // Load popup template.
      var template = {
        buttons: popup_buttons,
        /*custom_layer: '<div class="custom-layer" style="text-align:center">Hello World!</div>'*/
      };

      // Create popup.
      var $popup = editor.popups.create('customPlugin.popup', template);

      return $popup;
    }

    // Show the popup
    function showPopup () {
      // Get the popup object defined above.
      var $popup = editor.popups.get('customPlugin.popup');

      // If popup doesn't exist then create it.
      // To improve performance it is best to create the popup when it is first needed
      // and not when the editor is initialized.
      if (!$popup) $popup = initPopup();
	  //else hidePopup();

      // Set the editor toolbar as the popup's container.
      editor.popups.setContainer('customPlugin.popup', editor.$tb);

      // This will trigger the refresh event assigned to the popup.
      // editor.popups.refresh('customPlugin.popup');

      // This custom popup is opened by pressing a button from the editor's toolbar.
      // Get the button's object in order to place the popup relative to it.
      var $btn = editor.$tb.find('.fr-command[data-cmd="myButton"]');

      // Set the popup's position.
      var left = $btn.offset().left + $btn.outerWidth() / 2;
      var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

      // Show the custom popup.
      // The button's outerHeight is required in case the popup needs to be displayed above it.
      editor.popups.show('customPlugin.popup', left, top, $btn.outerHeight());
    }

    // Hide the custom popup.
    function hidePopup () {
      editor.popups.hide('customPlugin.popup');
    }

    // Methods visible outside the plugin.
    return {
      showPopup: showPopup,
      hidePopup: hidePopup
    }
  }
  
   // Define an toolbar drop down
  $.FroalaEditor.DefineIcon('dropdownButton', { NAME: 'cog'})
  $.FroalaEditor.RegisterCommand('dropdownButton', {
    title: 'Toolbar options',
    icon: 'dropdownButton',
    undo: false,
	focus: false,
	popup: true,
    plugin: 'dropdowncustomPlugin',
    callback: function () {	
	 if (!this.popups.isVisible('dropdowncustomPlugin.popup')) {
      this.dropdowncustomPlugin.showPopup();
	}
	else {
      if (this.$el.find('.fr-marker')) {
        this.events.disableBlur();
        this.selection.restore();
      }
      this.popups.hide('dropdowncustomPlugin.popup');
    }
	 
    }
  });
  //dropdown end

  // Define an icon and command for the button that opens the custom popup.
  $.FroalaEditor.DefineIcon('buttonIcon', { NAME: 'bullhorn'})
  $.FroalaEditor.RegisterCommand('myButton', {
    title: 'Voice Recorder',
    icon: 'buttonIcon',
    undo: false,
    focus: false,
	popup: true,
    plugin: 'customPlugin',
    callback: function () {	
	 if (!this.popups.isVisible('customPlugin.popup')) {
      this.customPlugin.showPopup();
	   var editorId=this.id;
	  $('#popupButton2-'+editorId).attr('disabled', true);
	  $('#popupButton1-'+editorId).attr('disabled', false);
	  $('#popupLoader-'+editorId).hide();
	  $('#popupStopped-'+editorId).hide();
      startAudioRecord(editorId);
    }
	else {
      if (this.$el.find('.fr-marker')) {
        this.events.disableBlur();
        this.selection.restore();
      }
      this.popups.hide('customPlugin.popup');
    }
	 
    }
  });
  
  // Define custom popup for stop voice record.
  $.FroalaEditor.DefineIconTemplate('record_stopped', '<span>Stopped</span>');
  $.FroalaEditor.DefineIcon('popupStopped', { NAME: 'stopped', template: 'record_stopped' });
  $.FroalaEditor.RegisterCommand('popupStopped', {
    title: 'Stopped',
    undo: false,
    focus: false,
    callback: function () {
      
    }
  });
  
  // Define custom popup loader button icon and command.
  /*Commented by Dashrath- comment old code and add new changes code below with spinner icon change*/
  // $.FroalaEditor.DefineIconTemplate('record_loader', '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
  $.FroalaEditor.DefineIconTemplate('record_loader', '<i class="fa fa-registered"></i>');
  $.FroalaEditor.DefineIcon('popupLoader', { NAME: 'loader', template: 'record_loader' });
  $.FroalaEditor.RegisterCommand('popupLoader', {
    title: 'Loader',
    undo: false,
    focus: false,
    callback: function () {
      
    }
  });

  // Define custom popup close button icon and command.
  $.FroalaEditor.DefineIcon('popupClose', { NAME: 'times' });
  $.FroalaEditor.RegisterCommand('popupClose', {
    title: 'Close',
    undo: false,
    focus: false,
    callback: function () {
      this.customPlugin.hidePopup();
    }
  });

  // Define custom popup 1.
  //fa fa-microphon
  
  $.FroalaEditor.DefineIcon('popupButton1', { NAME: 'microphone' });
  $.FroalaEditor.RegisterCommand('popupButton1', {
    title: 'Record',
    undo: false,
    focus: false,
    callback: function () {
      //alert("popupButton1 was pressed");
	  //var idd=('myButton-'+(this.id));
	  //var getClass=$('#'+idd).parent(".fr-toolbar").next(".fr-wrapper").children( ".fr-element" ).attr("class");
	  //alert(getClass);
	  var editorId=this.id;
	  startRecording(editorId);
    }
  });

  // Define custom popup 2.
  $.FroalaEditor.DefineIcon('popupButton2', { NAME: 'stop' });
  $.FroalaEditor.RegisterCommand('popupButton2', {
    title: 'Stop',
    undo: false,
    focus: false,
    callback: function () {
      //alert("popupButton2");
	  var editorId=this.id;
	  stopRecording(editorId);
    }
  });
	
//RECORDER CODE END	

//Dropdown feature start

//$('#'+textareaId).off('editable.beforeImageUpload');
//$('#'+textareaId).off('froalaEditor.image.beforeUpload');


//dropdown feature end
	
	if(version=='simple')
	{
		$('#'+textareaId).froalaEditor({
								   
		  toolbarButtons: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'bold', 'italic', 'underline', 'formatOL', 'html', 'fullscreen'],
	 
	 	  height: 80,
		  
		  //imageUploadURL: baseUrl+'froala_editor/upload.php',
      imageUploadURL: baseUrl+'image_editing/imageUpload',

		  //videoUploadURL: baseUrl+'froala_editor/upload.php',
      videoUploadURL: baseUrl+'image_editing/imageUpload',

		  //fileUploadURL:  baseUrl+'froala_editor/upload.php',
      fileUploadURL:  baseUrl+'image_editing/imageUpload',
		  
		  toolbarButtonsMD: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'html', 'fullscreen'],

		  toolbarButtonsXS: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'dropdownButton', 'fullscreen'],
		  
		  toolbarButtonsSM: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'html', 'fullscreen'],
		  
      imageDefaultAlign: 'left',
      
      placeholderText: 'Type something',
		  
		  
    	});
	}
	else if(version=='talk')
	{
		$('#'+textareaId).froalaEditor({
								   
		  toolbarButtons: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],
	 
	 	  height: 110,
		  
		  //imageUploadURL: baseUrl+'froala_editor/upload.php',
      imageUploadURL: baseUrl+'image_editing/imageUpload',

		  //videoUploadURL: baseUrl+'froala_editor/upload.php',
      videoUploadURL: baseUrl+'image_editing/imageUpload',

		  //fileUploadURL:  baseUrl+'froala_editor/upload.php',
      fileUploadURL:  baseUrl+'image_editing/imageUpload',
		  
		  toolbarButtonsMD: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],

		  toolbarButtonsXS: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'dropdownButton', 'fullscreen'],
		  
		  toolbarButtonsSM: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],
		  
		  imageDefaultAlign: 'left',
		  
		  
    	});
	}
	else if(version=='talk2')
	{
		$('#'+textareaId).froalaEditor({
								   
		  toolbarButtons: ['insertImage', 'myButton',  'insertVideo', 'insertFile', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'specialCharacters', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink', 'insertFile', 'insertTable', '|', 'undo', 'redo', 'selectAll', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
	 
	 	  height: 120,
		  
		  //imageUploadURL: baseUrl+'froala_editor/upload.php',
      imageUploadURL: baseUrl+'image_editing/imageUpload',

		  //videoUploadURL: baseUrl+'froala_editor/upload.php',
      videoUploadURL: baseUrl+'image_editing/imageUpload',

		  //fileUploadURL:  baseUrl+'froala_editor/upload.php',
      fileUploadURL:  baseUrl+'image_editing/imageUpload',

		  toolbarButtonsXS: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'dropdownButton', 'fullscreen'],
		  
		  toolbarButtonsSM: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'strikeThrough', 'fontSize', 'color', 'align', 'formatOL', 'formatUL', 'insertTable', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
		  
		   toolbarButtonsMD: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'strikeThrough', 'fontSize', 'color', 'align', 'formatOL', 'formatUL', 'insertTable', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
		   
		   imageDefaultAlign: 'left',
		  
		  
    });
	}
	else if(version=='comment')
	{
		$('#'+textareaId).froalaEditor({
									   
		  //editor.events.focus(true);								   
								   
		  toolbarButtons: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],
	 
	 	  height: 60,
		  
		  //imageUploadURL: baseUrl+'froala_editor/upload.php',
      imageUploadURL: baseUrl+'image_editing/imageUpload',

		  //videoUploadURL: baseUrl+'froala_editor/upload.php',
      videoUploadURL: baseUrl+'image_editing/imageUpload',

		  //fileUploadURL:  baseUrl+'froala_editor/upload.php',
      fileUploadURL:  baseUrl+'image_editing/imageUpload',
		  
		  toolbarButtonsMD: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],

		  toolbarButtonsXS: ['insertImage', 'myButton', 'insertVideo',  'insertFile', 'dropdownButton', 'fullscreen'],
		  
		  toolbarButtonsSM: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'formatOL', 'fullscreen'],
		  
		  placeholderText: 'Your comment here...',
		  
		  imageDefaultAlign: 'left',
		  
		  
    	});
	}
	else
	{
	
	$('#'+textareaId).froalaEditor({
								   
		 // toolbarButtons: ['insertImage', 'myButton',  'insertVideo', 'insertFile', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'specialCharacters', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', 'insertLink',  'insertTable', '|', 'undo', 'redo', 'selectAll', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
		toolbarButtons: ['insertImage', 'myButton',  'insertVideo', 'insertFile', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'specialCharacters', 'color', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink',  'insertTable', '|', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
	   
      //Changed by dashrath- change height 250 to 150
	 	  height: 150,
		  
		  //imageUploadURL: baseUrl+'froala_editor/upload.php',
      imageUploadURL: baseUrl+'image_editing/imageUpload',

		  //videoUploadURL: baseUrl+'froala_editor/upload.php',
      videoUploadURL: baseUrl+'image_editing/imageUpload',

		  //fileUploadURL:  baseUrl+'froala_editor/upload.php',
      fileUploadURL:  baseUrl+'image_editing/imageUpload',

		  toolbarButtonsXS: ['insertImage', 'myButton', 'insertVideo', 'insertFile', 'dropdownButton', 'fullscreen'],
		  
		  toolbarButtonsSM: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'strikeThrough', 'fontSize', 'color', 'insertTable', 'align', 'formatOL', 'formatUL', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
		  
		   toolbarButtonsMD: ['insertImage', 'myButton', 'insertVideo', 'bold', 'italic', 'underline', 'strikeThrough', 'fontSize', 'color', 'insertTable', 'align', 'formatOL', 'formatUL', 'html', 'applyFormat', 'removeFormat', 'fullscreen'],
		   
		   imageDefaultAlign: 'left',
		   
		   
		  
		  
    })
	.off('froalaEditor.image.beforeUpload');
	}
	
	//Manoj: remove voice record icon from ios device 
	var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
	if(isios==true)
	{
		//alert('ios');
		$('.fa-bullhorn').parent().hide();
		$('.fa-file-o').parent().hide();

    /*Added by dashrath- hide video icon from editor*/
    $('.fa-video-camera').parent().hide();
    /*Dashrath- code end*/
	}

  /*Added by dashrath- hide audio icon from editor*/
  $('.fa-bullhorn').parent().hide();
  /*Dashrath- code end*/
	
}
}

//Manoj: code to change textarea to editor end


//function chnage_textarea_to_editor(textareaId,version)
//
//{
//	//alert (textareaId);
//	//alert(getCookie('disableEditor'));//do not load editor if android or ios<5 detected
//
//	version = typeof version !== 'undefined' ? version : "";
//	//alert ('disable= ' +disableEditor);
//
//	if(disableEditor==0)
//	{
//			//Manoj: Multiple loader issue removed
//			CKEDITOR.on('instanceCreated', function(e){ $("#loading_editor").remove(); $("#" + textareaId).before("<div id='loading_editor' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>"); }); 
//
//			if(version=='simple'){
//				
//			
//			CKEDITOR.replace(textareaId,
//
//				{
//					"uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",	
//					
//					language: 'en',
//
//					fullPage : false,
//
//					toolbar  : [{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Scayt' ] },
//																
//								{ name: 'insert', items : [ 'Image','oembed'] },
//									
//								{ name: 'clipboard', items : [ 'PasteText' ] }]					
//
//				});		
//			}
//
//			else{
//
//			var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
//
//			var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
//			
//			
//			//Manoj: added condition for iphone issue
//			
//			/*if(ismobile==true && istablet==true)
//
//			{
//
//				CKEDITOR.replace(textareaId,
//
//							{
//							
//							   "uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",	
//							   language: 'en',
//
//							   fullPage : false,
//								//Manoj: change spellchecker to scayt
//							   toolbar : [ { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Scayt' ] },
//																		   
//									{ name: 'clipboard1', items : [ 'Undo','Redo']},
//
//									{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
//
//									//{ name: 'basicstyles1', items : ['Strike', 'Subscript','Superscript']},
//
//									//{ name: 'editing', items : [ 'Find','Replace','SelectAll' ] },
//
//									//{ name: 'paragraph', items : ['NumberedList','BulletedList','Outdent','Indent' ] },
//									
//									{ name: 'paragraph', items : ['BulletedList' ] },
//
//									{ name: 'insert', items : [ 'Image'] },
//
//									//{ name: 'paragraph1', items : ['Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
//
//									//{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
//
//									//{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
//
//									//{ name: 'colors', items : [ 'TextColor','BGColor' ] },
//
//									//{ name: 'styles', items : [ 'Format','Font','FontSize' ] },
//
//									{ name: 'tools', items : [ 'Maximize' ] }]
//
//						            
//
//							});
//							
//
//			}*/
//			
//			//Detect safari browser 
//			
//			if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 && (ismobile==true))
//			{			
//				
//				CKEDITOR.replace(textareaId,
//
//							{
//								
//							   "uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",
//							  
//							   language: 'en',
//			
//							   fullPage : false,
//
//							   toolbar : [ { name: 'basicstyles', items : [ 'Bold','Italic','Underline','SpellChecker' ] },
//
//									//{ name: 'clipboard', items : [ 'Cut','Copy','Paste' ] },
//
//									//{ name: 'clipboard1', items : [ 'Undo','Redo']},
//
//									//{ name: 'basicstyles1', items : ['Strike', 'Subscript','Superscript']},
//
//									//{ name: 'editing', items : [ 'RemoveFormat','Find','Replace','SelectAll' ] },
//
//									{ name: 'paragraph', items : ['BulletedList' ] },
//
//									{ name: 'insert', items : [ 'Image'] },
//
//									//{ name: 'paragraph1', items : ['Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
//
//									//{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
//
//									//{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
//
//									//{ name: 'colors', items : [ 'TextColor','BGColor' ] },
//
//									//{ name: 'styles', items : [ 'Format','Font','FontSize' ] },
//
//									{ name: 'tools', items : [ 'Maximize' ] }]
//
//						            
//
//							});
//			}
//			
//			//Manoj: code end
//
//			else if(ismobile==true)
//
//			{
//				
//				CKEDITOR.replace(textareaId,
//
//							{
//								
//							   "uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",
//							   
//							   language: 'en',
//			
//							   fullPage : false,
//
//							   toolbar : [ { name: 'basicstyles', items : [ 'Bold','Italic','Underline','SpellChecker' ] },
//
//									//{ name: 'clipboard', items : [ 'Cut','Copy','Paste' ] },
//
//									//{ name: 'clipboard1', items : [ 'Undo','Redo']},
//
//									//{ name: 'basicstyles1', items : ['Strike', 'Subscript','Superscript']},
//
//									//{ name: 'editing', items : [ 'RemoveFormat','Find','Replace','SelectAll' ] },
//
//									{ name: 'paragraph', items : ['BulletedList' ] },
//
//									{ name: 'insert', items : [ 'Image'] },
//
//									//{ name: 'paragraph1', items : ['Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
//
//									//{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
//
//									//{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
//
//									//{ name: 'colors', items : [ 'TextColor','BGColor' ] },
//
//									//{ name: 'styles', items : [ 'Format','Font','FontSize' ] },
//
//									{ name: 'tools', items : [ 'Maximize' ] }]
//
//						            
//
//							});
//
//			}
//
//			else if(istablet==true)
//
//			{
//				
//				CKEDITOR.replace(textareaId,
//
//							{
//								
//							   "uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",	
//							   language: 'en',
//
//							   fullPage : false,
//
//							   toolbar : [ { name: 'basicstyles', items : [ 'Bold','Italic','Underline','SpellChecker' ] },
//
//									{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
//
//									{ name: 'clipboard1', items : [ 'Undo','Redo']},
//
//									{ name: 'basicstyles1', items : ['Strike', 'Subscript','Superscript']},
//
//									{ name: 'editing', items : [ 'Find','Replace','SelectAll' ] },
//
//									{ name: 'paragraph', items : ['NumberedList','BulletedList','Outdent','Indent' ] },
//
//									{ name: 'insert', items : [ 'Image'] },
//
//									//{ name: 'paragraph1', items : ['Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
//
//									//{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
//
//									//{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
//
//									//{ name: 'colors', items : [ 'TextColor','BGColor' ] },
//
//									//{ name: 'styles', items : [ 'Format','Font','FontSize' ] },
//
//									{ name: 'tools', items : [ 'Maximize' ] }]
//
//						            
//
//							});
//
//			}
//
//			else if(ismobile==false && istablet==false)
//
//			{
//				/*CKEDITOR.replace( textareaId, {
//    "filebrowserImageUploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php"
//				});*/
//				//$("#loader_editor").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
//				//$("#loader_editor").show();
//				//CKEDITOR.on('instanceCreated', function(e){ $("#" + textareaId).before("<div id='loading_editor' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>"); });   
//				CKEDITOR.replace(textareaId,
//
//							{
//								// "filebrowserImageUploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php",
//								"uploadUrl": baseUrl+"ckeditor/plugins/imgupload/imgupload.php?black=mass",
//								language: 'en',
//
//							   fullPage : false,
//							   
//							   width: '80%',
//			   
//
//							   toolbar : [ { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Scayt' ] },
//
//									{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
//
//									{ name: 'clipboard1', items : [ 'Undo','Redo']},
//
//									{ name: 'basicstyles1', items : ['Strike', 'Subscript','Superscript']},
//
//									{ name: 'editing', items : [ 'RemoveFormat','Find','Replace','SelectAll' ] },
//
//									{ name: 'paragraph', items : ['NumberedList','BulletedList','Outdent','Indent' ] },
//
//									{ name: 'paragraph1', items : ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
//
//									{ name: 'links', items : [ 'Link','Unlink'] },
//
//									{ name: 'insert', items : [ 'Image','oembed'] },
//									
//									{ name: 'colors', items : [ 'TextColor','BGColor'] },
//
//									{ name: 'tools', items : [ 'Maximize' ] }]
//							});
//
////CKEDITOR.replace( textareaId );
//				
//
//
//			}
//
//			}
//
//
//			CKEDITOR.on('instanceReady', function(e){ $("#loading_editor").remove();});    
//
//		
//	}
//
//}



//for closing editor if instance exists

function editorClose(editorName){
	
	//if(disableEditor==0 && CKEDITOR.instances[editorName])
	
	var editor_content = $('#'+editorName).data('froala.editor');
	if(disableEditor==0 && editor_content)

	{
		//alert ('before destroy');
		//CKEDITOR.instances[editorName].destroy(true);
		//Manoj: code for destroy froala editor instance
		$('#'+editorName).froalaEditor('destroy');
		//Manoj: code end
		//alert ('after destroy');
/*		if (CKEDITOR.instances['text']) {
        CKEDITOR.remove(CKEDITOR.instances['text']);
		}
		CKEDITOR.replace('text');
*/
	}

}



// this function sets cookies using javascript

function setCookie(c_name,value,expiredays)

{

var exdate=new Date();

exdate.setDate(exdate.getDate()+expiredays);

document.cookie=c_name+ "=" +escape(value)+

((expiredays==null) ? "" : ";expires="+exdate.toUTCString());

}



function getCookie(c_name)

{


	if (document.cookie.length>0)

	{

		c_start=document.cookie.indexOf(c_name + "=");

		

		if (c_start!=-1)

		{

			c_start=c_start + c_name.length+1;

			c_end=document.cookie.indexOf(";",c_start);

			if (c_end==-1) c_end=document.cookie.length;

			if(c_name=='disableEditor'){

				return document.cookie.substring(c_start,c_end);

			}

			//alert(unescape(document.cookie.substring(c_start,c_end)));

			return unescape(document.cookie.substring(c_start,c_end));

		}

	}

	return "";

}

// function to set value into editor

function setValueIntoEditor(editorId,data)
{ 
	if(disableEditor==0){
		//CKEDITOR.instances[editorId].setData(data);
	}

	else{

		document.getElementById(editorId).value=data;

	}

}

function getvaluefromEditor(editorId){

	//condition to disable editor functions for android and ios<5
	if(disableEditor==0){

		

		//var INSTANCE_NAME = $("#"+editorId).attr('name');

		//var htmlVal = CKEDITOR.instances[INSTANCE_NAME].getData();
		
		//Manoj: code for getting froala html data 
		
		var htmlVal = $('#'+editorId).froalaEditor('html.get');
		
		//Manoj: code end
		

		if(htmlVal!=''){

		//	$('#cke_'+INSTANCE_NAME).hide();

		//	CKEDITOR.instances[INSTANCE_NAME].destroy();

		}

		return htmlVal;

	}

	else

	{

		//for android or ios < 5 return value from textarea

		return '<p>'+document.getElementById(editorId).value+'</p>';	

	}

}

function GetXmlHttpObject2()

{

  var xmlhttp3;

  if (window.XMLHttpRequest)

  {

  // code for IE7+, Firefox, Chrome, Opera, Safari

  xmlhttp3=new XMLHttpRequest();

  return xmlhttp3;

  }

	else if (window.ActiveXObject)

  {

  // code for IE6, IE5

  xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");

  return xmlhttp3;

  }

	else

  {

  jAlert("Your browser does not support XMLHTTP!","Alert");

  return null;

  }

  

}



function editor_code(val,ename,pId){ 



	if(document.getElementById(ename)){

		

	}else{

		var newInput = document.createElement('textarea');

		var inputName = ename;

		newInput.setAttribute('name',inputName);

		newInput.setAttribute('id',inputName);

		newInput.setAttribute('rows','10');

		newInput.setAttribute('cols','90');

		newInput.value=val; 

		document.getElementById(pId).appendChild(newInput);

		var newInput1 = document.createElement('span');

		inputName1=inputName+'sp';

		newInput1.setAttribute('id',inputName1);

		

		document.getElementById(pId).appendChild(newInput1);

	}

}



function hideShowSeed(treeId) 

{

	var seedId = 'normalViewTree'+treeId;			

	if(document.getElementById(seedId).style.display == "none")

	{

		document.getElementById(seedId).style.display="";

	}

	else

	{

		document.getElementById(seedId).style.display="none";

	}

}





function addFirstLeaf(treeId, leafOrder, version, addPosition)

{ 
  /*Added by Dashrath- add for set parameter default value*/
  if(addPosition === undefined) {
      addPosition = 1;
  }
  /*Dashrath- code end*/

  /*Added by Dashrath : code start */
  $sessionResult = leafPasteMoveAddConfirm(leafId=0,treeId, leafOrder);

  if($sessionResult)
  {
    return true;
  }
  /* Dashrath : code end */

	/*Added by Surbhi IV for checking version */

  /*Added by Dashrath- Add code and change condtition for add position feature*/
  var lastLeafNodeId = $(".lastLeafNodeId:last").attr("id");

  if(lastLeafNodeId > 0 && treeId > 0)
  {
    var leafDetails = getLeafDetailsByTreeId(treeId, lastLeafNodeId);
  }
  else
  {
    var leafDetails = 0;
  }
  

  //position 3 for bottom 
  if(addPosition==3 && leafDetails != 0)
  {
    leafDetailsArray = leafDetails.split("|||||");

    addLeafNew(leafDetailsArray[0],treeId, leafDetailsArray[1], leafDetailsArray[2]);
  }
  else
  {
                   
    var request = $.ajax({

				  url: baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId,

				  type: "POST",

				 // data: 'treeId='+treeId+'&version='+version,

				  data: '',

				  dataType: "html",

				  success:function(result)

				  { 

					   if(result > 0)

					   {/*End of Added by Surbhi IV for checking version */

					        if(document.getElementById('editStatus').value == 1)

                	{

                		// jAlert('Please save or close the current leaf before accessing another leaf','Alert');
                    jAlert('Please save or close the current content before accessing another content','Alert');

                		return false;

                	}
	
	                document.getElementById('loader'+leafOrder).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

	                document.getElementById('editStatus').value = 1;

                	//hideall();

                	//document.getElementById('leafAddFirst').style.display="";
                	//document.getElementById('docfirstLeaf').style.display="";
                	$('#leafAddFirst').show();
                	$('#docfirstLeaf').show();


                	if( document.getElementById("leafAddFirst"))
                	{

                	  var objleafAddFirst = document.getElementById("leafAddFirst");



                				  while (objleafAddFirst.hasChildNodes()) {

                								objleafAddFirst.removeChild(objleafAddFirst.lastChild);

                							}

                	}

	                editor_code('','editorLeafContentsAddFirst1','leafAddFirst');

	
	
                	//hideall();
                	//const recordVal = "'doc'";

                	// document.getElementById('editorLeafContentsAddFirst1'+'sp').innerHTML='<table width="8%" border="0" align="left" cellpadding="4" cellspacing="0"><tr><td colspan="2" align="left"><a href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+')"><div id="loader"></div><input type="button" class="button01" value="Done" /></a><a href="javascript:void(0)" onclick="cancelFirstLeaf('+treeId+','+leafOrder+')"><input type="button" class="button01" value="Cancel" ></a></td></tr></table><div id="audioRecordBox"><div style="float:left;margin-top:0.7%"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:5px; float:left;"><input onClick="startRecording(this,'+recordVal+');" type="button"  class="button01" value="Record"   /><input onClick="stopRecording(this);" type="button"  class="button01" value="Stop" disabled  /></div></div>';
                	
                  /*Commented by Dashrath- Add Save as Draft button in editor*/
                	// document.getElementById('editorLeafContentsAddFirst1'+'sp').innerHTML='<div><a href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+',\'publish\')"><div id="loader"></div><input style="float:left;" type="button" class="button01" value="Done" /></a><a href="javascript:void(0)" onclick="cancelFirstLeaf('+treeId+','+leafOrder+')"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><span id="audioRecordBox"><div style="float:left;margin-top:5px"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';
                  // document.getElementById('editorLeafContentsAddFirst1'+'sp').innerHTML='<div><a href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+',\'publish\')"><div id="loader"></div><input style="float:left;" type="button" class="button01" value="Done" /></a><a id="cancelFirstLeaf" href="javascript:void(0)" onclick="cancelFirstLeaf('+treeId+','+leafOrder+')"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><a href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+',\'draft\')"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" /></a><a id="discardAutoSaveDraftLeafFirst" href="javascript:void(0)" onclick="discardAutoSaveDraftLeaf(0,'+treeId+','+leafOrder+',\'discard\')" style="display:none;"><input style="float:left;" type="button" class="button01 discardButton" value="Discard Draft" ></a><span id="displayDraftSaveMessageFirst" class="draftSavedMessage"></span><span id="audioRecordBox"><div style="float:left;margin-top:5px"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';
                  document.getElementById('editorLeafContentsAddFirst1'+'sp').innerHTML='<div><a href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+',\'publish\')"><div id="loader"></div><input style="float:left;" type="button" class="button01" value="Done" /></a><a id="cancelFirstLeaf" href="javascript:void(0)" onclick="cancelFirstLeaf('+treeId+','+leafOrder+')"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><a id="SaveAsDraftLeafFirst" href="#" onclick="firstLeafSaveNew('+treeId+','+leafOrder+',\'draft\')" style="display:none;"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" /></a><span id="displayDraftSaveMessageFirst" class="draftSavedMessage"></span><span id="audioRecordBox"><div style="float:left;margin-top:5px"><span id="drop" style="margin-left:5px;"><a title="Record an audio" style="margin-left:0%; cursor:pointer;" onClick="startAudioRecord(1,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="1audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';
                
                	//Manoj: remove version simple
                	chnage_textarea_to_editor('editorLeafContentsAddFirst1','');

                	document.getElementById('loader'+leafOrder).innerHTML =" ";

                	// tinyMCE.execCommand('mceFocus',false,'editorLeafContentsAddFirst1');

					 

					       /*Added by Surbhi IV*/

                 /*Added by Dashrath- call function for auto save*/
                 document.getElementById('autoSaveMethodCalling').value = 0;
                 document.getElementById('openEditorId').value = 'editorLeafContentsAddFirst1';
                 document.getElementById('addDraftLeafNodeId').value = 0;
                 document.getElementById('addDraftLeafOldContent').value = "";
                 document.getElementById('addDraftLeafSaveType').value = 'first_leaf_save_new';

                 document.getElementById('addDraftLeafId').value = 0;
                 document.getElementById('addDraftNodeOrder').value = 0;

                 setInterval("addContentAutoSave()", 20000);
                 /*Dashrath- code end*/

                 /*Added by Dashrath- add for page scroll for editor focus*/
                 window.scrollTo(0, 0);
                 /*Dashrath- code end*/

					   }
					   else
					   {

						   jAlert("Leaf can not be added because new version of this tree has been created.","Alert");

						   return false;

					   }

				  }

		});/*End of Added by Surbhi IV*/
  
  }

}



function firstLeafSave(treeId, leafOrder) 

{		

	var editorId 	= "editorLeafContentsAddFirst1";

	var getvalue	= getvaluefromEditor(editorId);

		/*if ($("<p>"+getvalue+"</p>").text().trim()=='')

		{

			jAlert ('Please enter text','Alert');

			return false;

		}*/
	
		if (getvalue=='')

		{

			jAlert ('Please enter text','Alert');

			return false;

		}

	 

	document.frmEditLeaf.curLeaf.value 		= leafOrder;	

	document.frmEditLeaf.curContent.value 	= getvalue;

	document.frmEditLeaf.curLeafOrder.value = leafOrder;

	document.frmEditLeaf.curOption.value 	= 'addFirst';			

	document.frmEditLeaf.submit();

	return true;		

}



function firstLeafSaveNew(treeId, leafOrder,leafStatus, addStatus) 

{
  /*Added by Dashrath- add for set parameter default value*/
  if(addStatus === undefined) {
      addStatus = '';
  }
  /*Dashrath- code end*/

  //get autoSaveMethodCalling value
  var autoSaveMethodCalling  = $("#autoSaveMethodCalling").val();		

  if((autoSaveMethodCalling == 0 && addStatus=='') || addStatus=='autosave')
  {
  	var editorId 	= 'editorLeafContentsAddFirst1';

  	var getvalue	= getvaluefromEditor(editorId);

    /*Lock when user action manual from editor in this time auto save method not call*/
    if(getvalue != '' && addStatus == '')
    {
       document.getElementById('editorActionWithoutAutoSave').value = 1;
    }

    /*Lock editor buttons when auto save call*/
    if(addStatus=='autosave')
    {
      document.getElementById('autoSaveMethodCalling').value = 1;
    }

  	if (getvalue=='' && addStatus=='')

  		{
  			//for mobile device remove jAlert
  			jAlert ('Please enter text','Alert');

  			return false;

  		}

  		
    if(addStatus=='')
    {
  		$("[value=Done]").hide();

  		$("[value=Cancel]").hide();

      $("[value='Save as Draft']").hide();

      $("[value='Discard Draft']").hide();

  		$("#loader").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");

    }
  		 var data_user =$("#form10").serialize();

  			
      //get node id 
      var addDraftLeafNodeId  = $("#addDraftLeafNodeId").val();
      //get editor id when content auto save
      var openEditorId  = $("#openEditorId").val();

      if(openEditorId==editorId && addDraftLeafNodeId > 0)
      {
        addStatus = 'update_draft_content';
      }

  		 data_user=  data_user+'&curLeaf='+leafOrder+'&curContent='+encodeURIComponent(getvalue)+'&curLeafOrder='+leafOrder+'&frmEditLeaf=addFirst&editorname1=curContent&predecessor=0&successors=0&curOption=addFirst&workSpaceId='+workSpaceId+"&workSpaceType="+workSpaceType+"&leafPostStatus="+leafStatus+"&addStatus="+addStatus+"&addDraftLeafNodeId="+addDraftLeafNodeId; 

  		

  			  var request = $.ajax({

  			  url: baseUrl+"edit_leaf_save/index/doc/exit",

  			  type: "POST",

  			  data: data_user,

  			  dataType: "html",

  			  success:function(result){

            if(addStatus=='autosave')
            {
              document.getElementById('autoSaveMethodCalling').value = 0;

              if(result>0)
              {
                document.getElementById('addDraftLeafNodeId').value = result;

                //show discard draft button
                //document.getElementById('discardAutoSaveDraftLeafFirst').style.display = "inline";
      
                //hide cancel button
                //document.getElementById('cancelFirstLeaf').style.display = "none";

                //show save as draft button
                document.getElementById('SaveAsDraftLeafFirst').style.display = "inline";

                /*Added by Dashrath- add for auto save feature*/
                setInterval("checkDraftLeafLockDetailsByLeafId(0, 0)", 20000);
                /*Dashrath- code end*/

                // $('#displayDraftSaveMessage').html('Draft saved');
                $('#displayDraftSaveMessageFirst').html('Draft saved');

                setTimeout(function(){
                    $('#displayDraftSaveMessageFirst').html('');
                }, 9000);
              }
            }
            else
            {

      			  $("[value=Done]").show();

      			  $("[value=Cancel]").show();

      			  //alert(result);

      			  $("#leafAddFirst").hide();

      			   
       			  $("#docfirstLeaf").hide();
      			 

      			  $("#datacontainer").html(result);

      			   

      			  editorCheck();

      			  var editorId 	= 'editorLeafContentsAddFirst1';

      			  

      			  editorClose(editorId);
      			  
      			  $("#loader").html("");

              /*Added by Dashrath- clear hold value after leaf add*/
              document.getElementById('openEditorId').value = '';
              document.getElementById('addDraftLeafNodeId').value = 0;
              document.getElementById('addDraftLeafOldContent').value = "";
              document.getElementById('addDraftLeafSaveType').value ="";
              document.getElementById('addDraftLeafId').value = 0;
              document.getElementById('addDraftNodeOrder').value = 0;
              document.getElementById('editorActionWithoutAutoSave').value = 0;
              /*Dashrath- code end*/

            }

            /*Added by Dashrath- used for show hide draft icon in seed header*/
            if(treeId > 0)
            {
              getDraftLeafDataCount(treeId);
            }
            /*Dashrath- code end*/

            /*Added by Dashrath- remove docContainerNew class after add first leaf*/
            if($("#container").hasClass("docContainerNew"))
            {
              $('#container').removeClass('docContainerNew');
            }
            /*Dashrath- code end*/

  			  }

  			});

  }//if condition end
}

// this is a js function used to cancel to add the first leaf 

function cancelFirstLeaf( treeId, leafOrder) 

{

	editorClose("editorLeafContentsAddFirst1");//alert("asdsad");

	document.getElementById('leafAddFirst').style.display="none";	

	document.getElementById('editStatus').value = 0;	

  document.getElementById('editorActionWithoutAutoSave').value = 0;

  document.getElementById('autoSaveMethodCalling').value = 0;

  /*Added by Dashrath- Add for discard leaf if leaf in draft mode*/
  var addDraftLeafNodeId = $("#addDraftLeafNodeId").val();
  if(addDraftLeafNodeId>0)
  {
    //update leaf status
    updateDraftLeafStatus(addDraftLeafNodeId, treeId);
    //update leaf content
    getTreeLeafContents(treeId);
  }
  /*Dashrath- code end*/

  /*Added by Dashrath- Add for get leaf contents*/
  // var addDraftLeafNodeId = $("#addDraftLeafNodeId").val();
  // if(addDraftLeafNodeId>0)
  // {
  //   getTreeLeafContents(treeId);
  // }
  /*Dashrath- code end*/
	
	document.getElementById('docfirstLeaf').style.display="none";
	 
}	

function addLeaf_old(leafId,treeId, leafOrder){ 

	if(0)

	{

		jAlert('Please save or close the current leaf before accessing another leaf','Alert');

		return false;

	}

	document.getElementById('addleaf'+leafOrder).style.display="";

	editor_code('','editorLeafContentsAdd'+leafOrder+'1','addleaf'+leafOrder);

	hideall();

	

		

	

	document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div style="width:8%; float:left; padding:10px;"><form id="form2" name="form2" method="post"  ><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',1,2)"><img src="'+baseUrl+'images/done-btn.jpg" border="0"></a> <a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+',1)"><img src="'+baseUrl+'images/btn-cancel.jpg" border="0"></a></form></div>';

	



	chnage_textarea_to_editor('editorLeafContentsAdd'+leafOrder+'1');

	setValueIntoEditor('editorLeafContentsAdd'+leafOrder+'1','');	

}



function addLeafNew(leafId,treeId, leafOrder, version)

{ 

  /*Added by Dashrath : code start */
  $sessionResult = leafPasteMoveAddConfirm(leafId,treeId, leafOrder);

  if($sessionResult)
  {
    return true;
  }
  /* Dashrath : code end */

	var request = $.ajax({

				  url: baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					   if(result>0)
					   {

						    /*End of Added by Surbhi IV for checking version */
					      if(document.getElementById('editStatus').value == 1)
              	{

              		// jAlert('Please save or close the current leaf before accessing another leaf','Alert');
                  jAlert('Please save or close the current content before accessing another content','Alert');

              		return false;
              	}

              	document.getElementById('addloader'+leafId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

              	document.getElementById('editStatus').value = 1;

               	document.getElementById('addleaf'+leafOrder).style.display="";

              	if( document.getElementById('addleaf'+leafOrder))
              	{

              	  var objEditleaf = document.getElementById('addleaf'+leafOrder);



              	  while (objEditleaf.hasChildNodes()) {

              			objEditleaf.removeChild(objEditleaf.lastChild);

              		}

            	  }


	              var editorLeafContentsAddleafOrder1='editorLeafContentsAdd'+leafOrder+'1';

	              editor_code('','editorLeafContentsAdd'+leafOrder+'1','addleaf'+leafOrder);

              	//const recordVal = "'doc'";
              	
              	//document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div style="width:9%; float:left; padding:10px 0px;"><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',1,2)"><input type="button" class="button01" value="Done" ></a> <a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+',1)"><input type="button" class="button01" value="Cancel" ></a></div><div id="audioRecordBox"><div style="float:left;margin-top:1%; margin-left:0%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:10px; float:left;"><button onClick="startRecording(this,'+recordVal+');">Record</button><button onClick="stopRecording(this);" disabled>Stop</button></div></div>';
              	
                /*Commented by Dashrath- add save as draft button in new code*/
              	// document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',\'publish\')"><input style="float:left;" type="button" class="button01" value="Done" ></a><a href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+',1)"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';

                //Changed by Dashrath- Add editorBottomButton class
                // document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div class="editorBottomButton"><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',\'publish\')"><input style="float:left;" type="button" class="button01" value="Done" ></a><a id="cancelNewLeaf_'+leafOrder+'" href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+',1)"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',\'draft\')"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" ></a><a id="discardAutoSaveDraftLeafNew_'+leafOrder+'" href="javascript:void(0)" onclick="discardAutoSaveDraftLeaf('+leafId+','+treeId+','+leafOrder+',\'discard\')" style="display:none;"><input style="float:left;" type="button" class="button01 discardButton" value="Discard Draft" ></a><span id="displayDraftSaveMessage_'+leafOrder+'" class="draftSavedMessage"></span><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';
              	document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML='<div class="editorBottomButton"><a href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',\'publish\')"><input style="float:left;" type="button" class="button01" value="Done" ></a><a id="cancelNewLeaf_'+leafOrder+'" href="javascript:void(0)" onclick="cancelnewLeaf('+leafId+','+treeId+','+leafOrder+',1)"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a><a id="saveAsDraftLeafNew_'+leafOrder+'" href="javaScript:void(0)" onclick="newLeafSave('+leafId+','+treeId+','+leafOrder+',\'draft\')" style="display:none;"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" ></a><a id="discardAutoSaveDraftLeafNew_'+leafOrder+'" href="javascript:void(0)" onclick="discardAutoSaveDraftLeaf('+leafId+','+treeId+','+leafOrder+',\'discard\')" style="display:none;"><input style="float:left;" type="button" class="button01 discardButton" value="Discard Draft" ></a><span id="displayDraftSaveMessage_'+leafOrder+'" class="draftSavedMessage"></span><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(2,'+leafOrder+');"><span class="fa fa-microphon"></span></a></span></div><div id="2audio_record'+leafOrder+'" style="display:none; margin-left:1%; margin-top:0px; float:left;"></div></span></div>';

              	//Manoj: remove version simple
              	
              	chnage_textarea_to_editor('editorLeafContentsAdd'+leafOrder+'1','');

              	document.getElementById('addloader'+leafId).innerHTML = '';


                // Added by Dashrath- used for leaf edit autofocus
                /*Commented by Dashrath- comment old focus code and add new code below with if else condition*/
                // $('#leafAutoFocus'+leafOrder).focus();

                /*Added by Dashrath- Add new code for editor focus issue in ipad*/
                var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
                if(isios==true)
                {
                  $('#docLeafContent'+leafId).focus();
                }
                else
                {
                  $('#leafAutoFocus'+leafOrder).focus();
                }
                /*Dashrath- code end*/
	

                /*Added by Dashrath- call function for auto save*/
                document.getElementById('autoSaveMethodCalling').value = 0;
                document.getElementById('openEditorId').value = 'editorLeafContentsAdd'+leafOrder+'1';
                document.getElementById('addDraftLeafNodeId').value = 0;
                document.getElementById('addDraftLeafOldContent').value = "";
                document.getElementById('addDraftLeafSaveType').value = 'new_leaf_save';
                //used when add new leaf
                document.getElementById('addDraftLeafId').value = leafId;
                document.getElementById('addDraftNodeOrder').value = leafOrder;

                setInterval("addContentAutoSave()", 20000);
                /*Dashrath- code end*/

              				/*Added by Surbhi IV*/

					   }

					   else

					   {

						   jAlert("Leaf can not be added because new version of this tree has been created.","Alert");

							return false;

					   }

				  }

	});

	

}

function cancelnewLeaf( leafId,treeId, leafOrder) 

{

	

	var editorLeafContentsAddleafOrder1='editorLeafContentsAdd'+leafOrder+'1';

	var INSTANCE_NAME = $("#editorLeafContentsAdd"+leafOrder+"1").attr('name');

	

	

	editorClose(INSTANCE_NAME);

	

	document.getElementById('addleaf'+leafOrder).style.display="none";	

	 document.getElementById('editStatus').value = 0;	

  document.getElementById('editorActionWithoutAutoSave').value = 0;

  document.getElementById('autoSaveMethodCalling').value = 0;

  /*Added by Dashrath- Add for discard leaf if leaf in draft mode*/
  var addDraftLeafNodeId = $("#addDraftLeafNodeId").val();
  if(addDraftLeafNodeId>0)
  {
    //update leaf status
    updateDraftLeafStatus(addDraftLeafNodeId, treeId);
    //update leaf content
    getTreeLeafContents(treeId);
  }
  /*Dashrath- code end*/

  /*Added by Dashrath- Add for get leaf contents*/
  // var addDraftLeafNodeId = $("#addDraftLeafNodeId").val();
  // if(addDraftLeafNodeId>0)
  // {
  //   getTreeLeafContents(treeId);
  // }
  /*Dashrath- code end*/	

}

var leafId1;

var leafOrder1;

var treeId1;

var nodeId1;

var xmlHttp;

var xmlHttp4;

var xmlHttpTree;

function newLeafSave(leafId, treeId,leafOrder,leafStatus, addStatus) 

{	
  /*Added by Dashrath- add for set parameter default value*/
  if(addStatus === undefined) {
      addStatus = '';
  }
  /*Dashrath- code end*/

  //get autoSaveMethodCalling value
  var autoSaveMethodCalling  = $("#autoSaveMethodCalling").val();   

  if((autoSaveMethodCalling == 0 && addStatus=='') || addStatus=='autosave')
  {
  	var editorId = "editorLeafContentsAdd"+leafOrder+"1";

  	

  	var getvalue=getvaluefromEditor(editorId);
  	//alert (getvalue);
  	//return false;

    /*Lock when user action manual from editor in this time auto save method not call*/
    if(getvalue != '' && addStatus == '')
    {
       document.getElementById('editorActionWithoutAutoSave').value = 1;
    }

    /*Lock editor buttons when auto save call*/
    if(addStatus=='autosave')
    {
      document.getElementById('autoSaveMethodCalling').value = 1;
    }
  	
    /*Changed by Dashrath- add addStatus and condition for auto save feature*/
  	if (getvalue == '' && addStatus==''){

  		jAlert('Please enter text','Alert');

  		return false;

  	}

  	/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1){

  		jAlert('Please enter text','Alert');

  		return false;

  	}*/

  	//position: absolute; right: 0px; left: 0px; margin: 0px auto; top: 0px; bottom: 0px; width: 100%; z-index: 1000;


    if(addStatus=='')
    {
  	   document.getElementById('editorLeafContentsAdd'+leafOrder+'1sp').innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
    }

  	leafId1=leafId;

  	leafOrder1=leafOrder;



  	var xmlHttpTree=GetXmlHttpObject2();

  	
  	var url = baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

  	$.get(url,{},function(data){handleTreeVersion1(getvalue,data,editorId,leafStatus,addStatus);});

	} //if condition end

}


function handleTreeStateChange2(treeId,version) 

{				
	  var request = $.ajax({

	  url: baseUrl+"comman/checkVersion",

	  type: "POST",

	  data: 'treeId='+treeId+'&version='+version,

	  dataType: "html",

	  success:function(result)

	  {
			
		   if(result)

		   {
			   if(version!='')
			   {
			   		jAlert("New version of this tree has been created","Alert");
			   }
				var strPos1=$('#updateImage').attr('onClick').indexOf('&treeId=');

				var str1=$('#updateImage').attr('onClick').slice(0,strPos1+8);

				var strPos2=$('#updateImage').attr('onClick').indexOf('&doc=');

				var str2=$('#updateImage').attr('onClick').slice(strPos2);

				if(strPos2>-1)

				{

					$('#updateImage').attr('onClick',str1+''+result+''+str2);

				}

				$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');

		   }

		   else

		   {
			   $('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
		   }

	  }

	});

	

}


function checktreeUpdateCount(treeId,workSpaceId,workSpaceType,talk,version){
	if (talk == 1)
	{
		var url = baseUrl+'view_document/checkTreeUpdateCountNew/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/1';	
	}
	else
	{
		var url = baseUrl+'view_document/checkTreeUpdateCountNew/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/0';	  
	}

	xmlHttp4=GetXmlHttpObject2();

	xmlHttp4.onreadystatechange =function () 
	 {
		//alert (xmlHttp4.responseText);
		 if (xmlHttp4.readyState==4 && xmlHttp4.status == 200)
		 { 
        /*Commented by Dashrath- Comment old code and add new code below with some changes*/
			 // if(xmlHttp4.responseText==1)
			 // {
				// //alert ('here');
				//  handleTreeStateChange2(treeId,version);
			 // }

        /*Added by Dashrath- Code add for make treeupdate count and draft leaf count functionality common*/
        arrResponseText = xmlHttp4.responseText.split("|||||");
        if(arrResponseText[0]==1)
        {
          //alert ('here');
          handleTreeStateChange2(treeId,version);
        }

        if(arrResponseText[1]==1)
        {
          updateDraftIcon(treeId);
        }

        if(arrResponseText[2]==1)
        {
          updateShareIcon(treeId);
        }
        /*Dashrath- code end*/

			  //Add SetTimeOut 
			  setTimeout("checktreeUpdateCount('"+treeId+"','"+workSpaceId+"','"+workSpaceType+"','"+talk+"','"+version+"')", 30000);
		 }
	 };

	 xmlHttp4.open("GET", url, true);

	 xmlHttp4.send(null);
}
function checkTotalTreeCount(workSpaceId,workSpaceType){

	var url = baseUrl+'dashboard/checkTotalTreeCount/'+workSpaceId+'/'+workSpaceType;	  

	xmlHttp4=GetXmlHttpObject2();
	
	xmlHttp4.onreadystatechange =function () 
	 {
		//alert (xmlHttp4.responseText);
		 if (xmlHttp4.readyState==4 && xmlHttp4.status == 200)
		 { 
			 if(xmlHttp4.responseText==1)
			 {
				$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
				//$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
			 }
			  //Add SetTimeOut 
			 setTimeout("checkTotalTreeCount('"+workSpaceId+"','"+workSpaceType+"')", 30000);
		 }
	 };

	 xmlHttp4.open("GET", url, true);
	 xmlHttp4.send(null);
}

/*Added by Dashrath- checkTotalFeedCount*/
function checkTotalFeedCount(workSpaceId,workSpaceType){

  var url = baseUrl+'dashboard/checkTotalFeedCount/'+workSpaceId+'/'+workSpaceType;   

  xmlHttp4=GetXmlHttpObject2();
  
  xmlHttp4.onreadystatechange =function () 
   {
    //alert (xmlHttp4.responseText);
     if (xmlHttp4.readyState==4 && xmlHttp4.status == 200)
     { 
       if(xmlHttp4.responseText==1)
       {
        $('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
        //$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
       }
        //Add SetTimeOut 
       setTimeout("checkTotalFeedCount('"+workSpaceId+"','"+workSpaceType+"')", 30000);
     }
   };

   xmlHttp4.open("GET", url, true);
   xmlHttp4.send(null);
}
/*Dashrath- code end*/

/*Added by Dashrath- checkTotalMangeFilesCount*/
function checkTotalMangeFilesCount(workSpaceId,workSpaceType){

  var url = baseUrl+'external_docs/checkTotalMangeFilesCount/'+workSpaceId+'/'+workSpaceType;   

  xmlHttp4=GetXmlHttpObject2();
  
  xmlHttp4.onreadystatechange =function () 
   {
    //alert (xmlHttp4.responseText);
     if (xmlHttp4.readyState==4 && xmlHttp4.status == 200)
     { 
       if(xmlHttp4.responseText==1)
       {
        $('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
        //$('#updateImage').attr('src',baseUrl+'images/tab-icon/update-view-green.png');
       }
        //Add SetTimeOut 
       setTimeout("checkTotalMangeFilesCount('"+workSpaceId+"','"+workSpaceType+"')", 30000);
     }
   };

   xmlHttp4.open("GET", url, true);
   xmlHttp4.send(null);
}
/*Dashrath- code end*/



function docTitleSave()

{

	  

	var getvalue = getvaluefromEditor('documentName');

	

	if(getvalue == "")

	{

		jAlert("Please enter the document title","Alert");

		document.getElementById('documentName').focus();

		return false;

	}



	document.frmDocument.submit();

	return true;	

}

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

function docTitleSaveNew (version,treeId)

{

	//var getvalue = getvaluefromEditor('documentName');
	var getvalue = document.getElementById('documentName').value;

	var treeId = document.getElementById('treeId').value;



	/*if($("<p>"+getvalue+"</p>").text().trim()=='')

	{

		jAlert("Please enter the title","Alert");

		document.getElementById('documentName').focus();

		return false;

	}

	else if(getvalue.indexOf("<img")!=-1)

	{

		jAlert("Please do not use images in title","Alert");

		document.getElementById('documentName').focus();

		return false;

	}*/
	
	if(getvalue == '')

	{

		jAlert("Please enter the title","Alert");

		document.getElementById('documentName').focus();

		return false;

	}

	

	$("[value=Done]").hide();

	$("[value=Cancel]").hide();

	$("#loader").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");



	var httpDoc = getHTTPObjectm();

	



	var documentName='documentName';

	var jsData = getvalue;



	urlm=baseUrl+'edit_document/updateNew/'+workSpaceId+'/type/'+workSpaceType+'/notes';

	data='treeId='+treeId+'&documentName='+encodeURIComponent(jsData);

   

	httpDoc.open("POST", urlm, true); 

	httpDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	httpDoc.onreadystatechange = function()

				  {

					  if (httpDoc.readyState==4 && httpDoc.status==200)

					  {

							

							document.getElementById("treeContent").innerHTML=getvalue;

							if(document.getElementById("oldNameContainer"))

							{

							document.getElementById("oldNameContainer").innerHTML=httpDoc.responseText;

							

							

							}

							//editorClose(documentName);

							$("[value=Done]").show();

							$("[value=Cancel]").show();

							$("#loader").html("");

						document.getElementById("edit_doc").style.display='none';

						

					  }

				  }   

	httpDoc.send(data);

}



function docTitleCancel ()

{

	//editorClose('documentName');

	//updateSeedContents(treeId,1);

	if( document.getElementById("divEditDoc"))

	{

	  var objleafAddFirst = document.getElementById("divEditDoc");



				  while (objleafAddFirst.hasChildNodes()) {

								objleafAddFirst.removeChild(objleafAddFirst.lastChild);

							}

	}

	

	document.getElementById('edit_doc').style.display='none';

	

	return false;

}

function docTitleCancel_1(content)
{

	   
	editorClose('documentName');

	

	if( document.getElementById("divEditDoc"))

	{

	  var objleafAddFirst = document.getElementById("divEditDoc");



				  while (objleafAddFirst.hasChildNodes()) {

								objleafAddFirst.removeChild(objleafAddFirst.lastChild);

							}

	}

		

	document.getElementById('edit_doc').style.display='none';

	return false;

}





function editLeaf(leafId, leafOrder,treeId,nodeId,version,treeLeafStatus,parentLeafId) 

{
	//alert(workSpaceId);
	$('#loader'+leafOrder).html("<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
	//Code start here
	var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&leafId="+leafId+"&leafOrder="+leafOrder+"&parentLeafId="+parentLeafId+"&treeLeafStatus="+treeLeafStatus+"&workSpaceId="+workSpaceId;
	getTreeLeafObjectIconStatus(treeId, nodeId, leafId, leafOrder, parentLeafId, treeLeafStatus, workSpaceId, 2, 1);
	$.ajax({
		   
		   	url: baseUrl+'comman/getTreeLeafUserObjectStatus',

			type: "POST",

			 data: 'leaf_data='+leaf_data,
			
			dataType: "html",

			success:function(result)
			{
				//alert(result);
				result = result.split("|||");
				//alert(result[0]+'==='+result[1]);
				if(result[0]==1)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==2)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==3)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==4)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==5)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==6)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else if(result[0]==7)
				{
					$('#loader'+leafOrder).html("");
					
					jAlert(result[1],"Alert");
					
					return false;
				}
				else
				{
				var request = $.ajax({

				  url: baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {
					   if(result>0)

					   {
						   
						   /*End of Added by Surbhi IV for checking version */

					    if(document.getElementById('editStatus').value == 1)

							{

								$('#loader'+leafOrder).html("");
								
								// jAlert('Please save or close the current leaf before accessing another leaf','Alert');
                jAlert('Please save or close the current content before accessing another content','Alert');
								
								updateLeafContents(nodeId,treeId);
								
								return false;

							}

							else

							{
								//document.getElementById('loader'+nodeId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";

								document.getElementById('editStatus').value = 1;	

								 leafId1=leafId;

								 leafId2=leafId;

								 leafOrder1=leafOrder;

								 treeId1=treeId;

								 nodeId1=nodeId;
								 
								 treeLeafStatus1 = treeLeafStatus;
								 
								 parentLeafId1 = parentLeafId;

								

								initialleafcontentId='initialleafcontent'+leafOrder1;

						

								xmlHttpTree=GetXmlHttpObject2();

								var url =baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

								xmlHttpTree.onreadystatechange = handleTreeVersion;

						

								xmlHttpTree.open("GET", url, true);

								xmlHttpTree.send(null);

							}

					  /*Added by Surbhi IV*/

					   }

					   else

					   {

						   $('#loader'+leafOrder).html("");
						  
						   jAlert("This leaf can not be edited because new version of this tree has been created.","Alert");
						   
						   updateLeafContents(nodeId,treeId);
						   
						   return false;

					   }

				  }

				});
				}
			}
});

	

}



function handleLockLeafEdit(){

	if(xmlHttp.readyState == 4) 

	{			

		if(xmlHttp.status == 200) 

		{									

			strResponseText = xmlHttp.responseText;				

			if(strResponseText == 0)

			{
				
				document.getElementById('loader'+leafOrder1).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
				//alert(leafOrder1+'===');
				/* Fetching last version of leaf */



				xmlHttpLast=GetXmlHttpObject2();

				var url =baseUrl+'current_leaf'+"/index/leafId/"+leafId1+"/"+parentLeafId1;

				

					xmlHttpLast.onreadystatechange=function() {

						if (xmlHttpLast.readyState==4) {

							var arrNode = Array ();

							var nodeDetails = xmlHttpLast.responseText;

								if (nodeDetails != 0)
								{

									//alert(nodeDetails);

									arrNode = nodeDetails.split("~!@");
									//alert(arrNode[0]);
									
									var reserveStatus1 = '';
									
									if (!arrNode[0].match(/onlyContents/g))
									{

										leafId1=arrNode[1];

										leafId2=arrNode[1];

										//leafOrder1=arrNode[2];

										treeId1=arrNode[3];

										nodeId1=arrNode[0];

										document.getElementById('initialleafcontent'+leafOrder1).value=arrNode[4];

										contents=arrNode[4];
										
										reserveStatus1=arrNode[5];
										
										leafTreeId=arrNode[6];

									}

									else

									{

										

										//alert ('contents1= ' + arrNode[1]);

										document.getElementById('initialleafcontent'+leafOrder1).value=arrNode[1];

										contents=arrNode[1];
										
										reserveStatus1=arrNode[2];
										
										leafTreeId=arrNode[3];

									}

									

								}

								

								var val=document.getElementById('initialleafcontent'+leafOrder1).value;

								document.getElementById('editleaf'+leafOrder1).style.display="";

								

								

								if( document.getElementById('editleaf'+leafOrder1))

								{

								  var objEditleaf = document.getElementById('editleaf'+leafOrder1);

							

											  while (objEditleaf.hasChildNodes()) {

															objEditleaf.removeChild(objEditleaf.lastChild);

														}

								}

								/*Added by Dashrath- value set in hidden field for content auto save feature*/
                document.getElementById('draftCurLeafId').value = leafId1;
                document.getElementById('draftCurLeafOrder').value = leafOrder1;
                document.getElementById('draftCurNodeId').value = nodeId1;
                document.getElementById('draftCurrentLeafMode').value = treeLeafStatus1;
                document.getElementById('editLeafOldContent').value  = contents;

                document.getElementById('editAutoSaveMethodCalling').value = 0;
                document.getElementById('newDraftLeafNodeId').value = 0;
                document.getElementById('editEditorActionWithoutAutoSave').value = 0;
                /*Dashrath- code end*/

								var editleafleafOrder1='editleaf'+leafOrder1;
								//alert (contents);
								editor_code(contents,'editorLeafContents'+leafOrder1+'1','editleaf'+leafOrder1);

								 //const recordVal = "'doc'";

								//document.getElementById('editorLeafContents'+leafOrder1+'1sp').innerHTML='<table width="9%" border="0" align="left" cellpadding="2" cellspacing="0"><tr><td colspan="4" align="left"><a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+')"><input type="button" class="button01" value="Done" ></a><a href="javascript:void(0)" onclick="canceleditLeaf('+leafId1+','+treeId1+','+leafOrder1+')"><input type="button" class="button01" value="Cancel" ></a></td></tr></table><div id="audioRecordBox"><div style="float:left;margin-top:6px"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(3,'+leafOrder1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+leafOrder1+'" style="display:none; margin-left:1%; margin-top:0.2%; float:left;"><button onClick="startRecording(this,'+recordVal+');">Record</button><button onClick="stopRecording(this);" disabled>Stop</button></div></div><div id="loaderImage"></div>';
								var discardBtn ='';
								var fourBtns = '';
								var saveBtn ='';
								var doneBtnTxt = 'Done';
								var leafTreeIdInput = '';

                //Added by dashrath- show draft save message
                //var displayDraftSaveMessage = '';

								//alert(reserveStatus1);

                /*Commented by Dashrath- add new code below commented code*/
								// if(reserveStatus1 == 1)
								// {
								// 	saveBtn = '<a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'draft\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" /></a>';
								// 	doneBtnTxt = 'Final';
								// }

                /*Added by Dashrath- show save as draft button for tree contributor*/
                // saveBtn = '<a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'draft\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" /></a>';

                /*Add condition for if leaf in draft mode show button name keep as draft*/
                if(treeLeafStatus1 == 'draft')
                {
                  saveBtn = '<a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'draft\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 saveDraft" value="Keep as Draft" /></a>';
                }
                else
                {
                  saveBtn = '<a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'draft\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 saveDraft" value="Save as Draft" /></a>';
                }
                  
                // if(reserveStatus1 == 1 || treeLeafStatus1 == 'draft')
                // {
                //   doneBtnTxt = 'Final';
                // }
                if(treeLeafStatus1 == 'draft')
                {
                  doneBtnTxt = 'Final';
                }
                /*Dashrath- code end*/

                /*Commented by Dashrath- Comment old code and add new code below*/
								// if(treeLeafStatus1 == 'draft' && reserveStatus1 == 1)
								// {
								// 	discardBtn = '<a href="javascript:void(0)" onclick="discardDraftLeaf('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'discard\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 discardButton" value="Discard Draft" ></a>';
								// 	fourBtns = 'fourBtns';
								// }

                /*Added by Dashrath- remove reserveStatus1 == 1 condition in if statement*/
                if(treeLeafStatus1 == 'draft')
                {
                  discardBtn = '<a href="javascript:void(0)" onclick="discardDraftLeaf('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'discard\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 discardButton" value="Discard Draft" ></a>';
                  fourBtns = 'fourBtns';
                }
                /*Dashrath- code end*/

                //Added by Dashrath- show draft save message
                // if(treeLeafStatus1 == 'draft')
                // {
                //   displayDraftSaveMessage = '<span id="displayDraftSaveMessage"></span>';
                // }
                var displayDraftSaveMessage = '<span id="displayDraftSaveMessageEdit_'+leafOrder1+'" class="draftSavedMessage"></span>';
								
                

								if(leafTreeId!='')
								{
									leafTreeIdInput = '<input type="hidden" value="'+leafTreeId+'" id="leafTreeIdTalk">';
								}
								
                //Changed by Dashrath- change for show draft save message
								// document.getElementById('editorLeafContents'+leafOrder1+'1sp').innerHTML='<div class="editorBottomButton '+fourBtns+'"><a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'publish\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 final" value="'+doneBtnTxt+'" ></a><a href="javascript:void(0)" onclick="canceleditLeaf('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a>'+saveBtn+discardBtn+displayDraftSaveMessage+'<div id="loader"></div><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(3,'+leafOrder1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+leafOrder1+'" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></span></div><div id="loaderImage"></div>'+leafTreeIdInput+'';
								
                /*Add condition for if leaf in draft mode cancel button not display*/
                if(treeLeafStatus1 == 'draft')
                {
                  fourBtns = '';
                  document.getElementById('editorLeafContents'+leafOrder1+'1sp').innerHTML='<div class="editorBottomButton '+fourBtns+'"><a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'publish\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 final" value="'+doneBtnTxt+'" ></a>'+saveBtn+discardBtn+displayDraftSaveMessage+'<div id="loader"></div><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(3,'+leafOrder1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+leafOrder1+'" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></span></div><div id="loaderImage"></div>'+leafTreeIdInput+'';
                }
                else
                {
                  document.getElementById('editorLeafContents'+leafOrder1+'1sp').innerHTML='<div class="editorBottomButton '+fourBtns+'"><a href="javascript:void(0)" onclick="editLeafSave('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\'publish\',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 final" value="'+doneBtnTxt+'" ></a><a href="javascript:void(0)" onclick="canceleditLeaf('+leafId1+','+treeId1+','+leafOrder1+','+nodeId1+',\''+treeLeafStatus1+'\','+parentLeafId1+')"><input style="float:left;" type="button" class="button01 docCancel" value="Cancel" ></a>'+saveBtn+discardBtn+displayDraftSaveMessage+'<div id="loader"></div><span id="audioRecordBox"><div style="float:left;margin-top:5px; margin-left:1%;"><span id="drop"><a title="Record an audio" style="margin-left:0%;" onClick="startAudioRecord(3,'+leafOrder1+');"><span class="fa fa-microphon"></span></a></span></div><div id="3audio_record'+leafOrder1+'" style="display:none; margin-left:1%; margin-top:0%; float:left;"></div></span></div><div id="loaderImage"></div>'+leafTreeIdInput+'';
                }

								//alert(leafOrder1+'===');
								
								chnage_textarea_to_editor('editorLeafContents'+leafOrder1+'1');
								
								document.getElementById('loader'+leafOrder1).innerHTML =" ";
								
								//alert(leafId1+'==='+leafId2);
								
								//Manoj: froala editor hide content on edit document leaf
								//alert('test'+nodeId1);
								document.getElementById('docLeafContent'+nodeId1).style.display="none";

								setValueIntoEditor('editorLeafContents'+leafOrder1+'1',contents);

								document.getElementById('editStatus').value = 1;

                /*Added by Dashrath- add for auto save feature*/
                setInterval("editContentAutoSave()", 20000);
                /*Dashrath- code end*/

                /*Added by Dashrath- add for auto save feature*/
                setInterval("checkLeafLockDetailsByLeafId(leafId1, leafOrder1, nodeId1, treeId1)", 10000);
                /*Dashrath- code end*/
                 

                // Added by Dashrath- used for leaf edit autofocus
								$('#leafAutoFocus'+leafOrder1).focus();

                /*Added by Dashrath- add for editor hide in blue header issue*/
                if($(window).scrollTop() > 120)
                {
                  $(window).scrollTop($('#leafAutoFocus'+leafOrder1).offset().top - 55); 
                }
                /*Dashrath- code end*/

						}

					}

						

				xmlHttpLast.open("GET", url, true);

				xmlHttpLast.send(null);

				

				

				

				

			}else{	
			
				$('#loader'+leafOrder1).html("");
				
				jAlert(strResponseText,"Alert");
				
				updateLeafContents(nodeId1,treeId1);
				
				document.getElementById('editStatus').value = 0;

			}					

		}

	}

}



function editLeafSave(leafId, treeId,leafOrder,nodeId,leafStatus,currentLeafMode,parentLeafId) 

{
  //get editAutoSaveMethodCalling value
  var editAutoSaveMethodCalling  = $("#editAutoSaveMethodCalling").val();   
  /*Added by Dashrath- editor button action run if auto save method not running*/
  if(editAutoSaveMethodCalling == 0)
  {
  	var leaf_data="&treeId="+treeId+"&nodeId="+nodeId+"&leafId="+leafId+"&leafOrder="+leafOrder+"&parentLeafId="+parentLeafId+"&treeLeafStatus="+currentLeafMode;
  	
  	$.ajax({
  		   
  		   	url: baseUrl+'comman/getTreeLeafUserObjectStatus',

  			type: "POST",

  			 data: 'leaf_data='+leaf_data,
  			
  			dataType: "html",

  			success:function(result)
  			{
  				//alert(result);
  				//return false;
  				
  				result = result.split("|||");
  				//alert(result[0]+'==='+result[1]);
  				if(result[0]==5)
  				{
  					$('#loader'+leafOrder).html("");
  					
  					jAlert(result[1],"Alert");
  					
  					return false;
  				}
  				else
  				{
  					var editorId = "editorLeafContents"+leafOrder+"1";
  				
  					var getvalue = getvaluefromEditor(editorId);
  				
  					
  				
  					var INSTANCE_NAME = $("#editorLeafContents"+leafOrder1+"1").attr('name');
  				
  					
  				
  					/*if ($("<p>"+getvalue+"</p>").text().trim()=='' && getvalue.indexOf("<img")==-1)
  				
  					{
  				
  						jAlert ('Please enter text','Alert');
  				
  						return false;
  				
  					}*/
  					
  					if (getvalue == '')
  				
  					{
  				
  						jAlert ('Please enter text','Alert');
  				
  						return false;
  				
  					}
  					

  					var leafTreeId = $('#leafTreeIdTalk').val();
  					
  					setTagAndLinkCount(nodeId,2);
  					
  					setTalkCount(leafTreeId);
  				
  					var originalContents = encodeURIComponent(document.getElementById('initialleafcontent'+leafOrder).value).replace(/%0A/g,"");
  				
  					var str=encodeURIComponent(getvalue).replace(/%0A/g,"");

            /*Changed by Dashrath- Add leafStatus or condition in if statement*/
  					if ((originalContents==str && currentLeafMode!='draft' && leafStatus!='draft'))
  				
  					{
   
  						jAlert('Contents not changed','Alert');
  				
  						return false;
  				
  					}
  				
  					else
  				
  					{
  				    
              /*Added by Dashrath- Used for check editor action is running for edit auto save feature*/
              document.getElementById('editEditorActionWithoutAutoSave').value = 1;
              /*Dashrath- code end*/

  						var tagLinks=$("#tagLinks").val();
  				
  							
  				
  						//$("[value=Done]").hide();
  						
  						$(".final").hide();
  				
  						$("[value=Cancel]").hide();
  						
  						$(".saveDraft").hide();
  						
  						$(".discardButton").hide();
  				
  						$("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
  				
  						  var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+leafOrder+"&treeId="+treeId+"&curNodeId="+nodeId+"&curLeaf="+leafId+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue)+"&leafPostStatus="+leafStatus;
  				      
                /*Added by Dashrath- get node details if new node create by auto save method*/
                var newDraftLeafNodeId  = $("#newDraftLeafNodeId").val();
               
                if(newDraftLeafNodeId > 0)
                {
                  var nodeDetails = getNodeDetailsFromNodeId(newDraftLeafNodeId);

                  if(nodeDetails != 0)
                  {
                    //0 index contain leaf id and 1 index contain leaf order
                    var nodeDetailsArray = nodeDetails.split("|||||");

                    user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+nodeDetailsArray[1]+"&treeId="+treeId+"&curNodeId="+newDraftLeafNodeId+"&curLeaf="+nodeDetailsArray[0]+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue)+"&leafPostStatus="+leafStatus;
                  }
                }
                /*Dashrath- code end*/

  							var request = $.ajax({
  				
  							  url: baseUrl+"edit_leaf_save/index/doc/exit",
  				
  							  type: "POST",
  				
  							  data: 'user_data='+user_data,
  				
  							  dataType: "html",
  				
  							  success:function(result)
  				
  									 {
  				
  										  if(result)
  				
  										 {
  											 //alert(result);
  				                
  											 editorClose(editorId);

                         //set value 0 for editor action complete for auto save feature
                         document.getElementById('editEditorActionWithoutAutoSave').value = 0;
  											 
  											 $("[value=Done]").show();
  				
  											 $("[value=Cancel]").show();
  											 
  											 $("#datacontainer").html(result);
  											
  											//Manoj: froala editor show content on edit document leaf
  											//document.getElementById('docLeafContent'+nodeId).style.display="block";
  											$('#docLeafContent'+nodeId).show();
  				
  											//document.getElementById('editStatus').value=0;
  											$('#editStatus').val('0');
  											
  											//Call for reserve, tree versioning or move status
  											//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+currentLeafMode+'=='+workSpaceId);	
  											getLeafObjectStatus(treeId,nodeId,leafId,leafOrder,parentLeafId,currentLeafMode,workSpaceId,1);
  											//Code end

                        /*Added by Dashrath- used for show hide draft icon in seed header*/
                        if(treeId > 0)
                        {
                          getDraftLeafDataCount(treeId);
                        }
                        /*Dashrath- code end*/
  				
  										 }
  				
  									}
  				
  								});
  				
  						
  				
  					}
  				} //else code end
  			} //success code end
  		});

  } //end if condition
				
}



function handleTreeVersion(){

	if(xmlHttpTree.readyState == 4) 

	{			

		if(xmlHttpTree.status == 200) 

		{									

			isLatest = xmlHttpTree.responseText;

					

					if(isLatest==0)

					{

						$('#loader'+leafOrder1).html("");
						
						jAlert ('This leaf can not be edited because new version of this tree has been created.','Alert');
						
						updateLeafContents(nodeId1,treeId1);

						document.getElementById('editStatus').value = 0;	

						return false;

						

						

					}

					else

					{

						xmlHttp=GetXmlHttpObject2();

						var url =baseUrl+'lock_leaf'+"/index/leafId/"+leafId1;

						xmlHttp.onreadystatechange = handleLockLeafEdit;				

						xmlHttp.open("GET", url, true);

						xmlHttp.send(null);

					}



		}					

	}

}	

var self = this;

function handleTreeVersion1(getvalue,data,editorId,leafStatus,addStatus){

  /*Added by Dashrath- add for set parameter default value*/
  if(addStatus === undefined) {
    addStatus = '';
  }
  /*Dashrath- code end*/

	isLatest = data;

			//alert (isLatest);

			if(isLatest==0 && addStatus=='')

			{

				jAlert ('New Idea can not be created because new version of the tree has been created.','Alert');

				return false;

			}

			else

			{ 
        //get node id 
        var addDraftLeafNodeId  = $("#addDraftLeafNodeId").val();
        //get editor id when content auto save
        var openEditorId  = $("#openEditorId").val();

        if(openEditorId==editorId && addDraftLeafNodeId > 0)
        {
          addStatus = 'update_draft_content';
        }

				user_data='tagLinks='+document.getElementById("tagLinks").value+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=add&curLeafOrder="+leafOrder1+"&treeId="+document.getElementById("treeId").value+"&curNodeId="+document.getElementById("curNodeId").value+"&curLeaf="+leafId1+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue)+"&leafPostStatus="+leafStatus+"&addStatus="+addStatus+"&addDraftLeafNodeId="+addDraftLeafNodeId;

				

				$('#image').show();

				

				var request = $.ajax({

				url: baseUrl+"edit_leaf_save/index/doc/exit",

				type: "POST",

				data: 'user_data='+user_data,

				dataType: "html",

				async:false,

				success:function(result)

					 { 

            if(addStatus=='autosave')
            {
              document.getElementById('autoSaveMethodCalling').value = 0;

              if(result>0)
              {
                document.getElementById('addDraftLeafNodeId').value = result;

                //show discard draft button
                //document.getElementById('discardAutoSaveDraftLeafNew_'+leafOrder1).style.display = "inline";

                //hide cancel button
                //document.getElementById('cancelNewLeaf_'+leafOrder1).style.display = "none";

                //show save as draft button
                document.getElementById('saveAsDraftLeafNew_'+leafOrder1).style.display = "inline";

                /*Added by Dashrath- add for auto save feature*/
                setInterval("checkDraftLeafLockDetailsByLeafId(leafId1, leafOrder1)", 20000);
                /*Dashrath- code end*/
                

                $('#displayDraftSaveMessage_'+leafOrder1).html('Draft saved');

                setTimeout(function(){
                    $('#displayDraftSaveMessage_'+leafOrder1).html('');
                }, 9000);
              }
            }
            else
            {

              /*Added by Dashrath- clear hold value after leaf add*/
              document.getElementById('openEditorId').value = '';
              document.getElementById('addDraftLeafNodeId').value = 0;
              document.getElementById('addDraftLeafOldContent').value = "";
              document.getElementById('addDraftLeafSaveType').value ="";
              document.getElementById('addDraftLeafId').value = 0;
              document.getElementById('addDraftNodeOrder').value = 0;
              document.getElementById('editorActionWithoutAutoSave').value = 0;
              /*Dashrath- code end*/

              editorClose(editorId);

              if(result){

                document.getElementById('datacontainer').innerHTML=result;

                //(elem=document.getElementById("overlay")).parent.removeChild(elem);
              }
              else
              {
                document.getElementById('docErrorMsg').innerHTML="error";
              }

              editorCheck();


            }

            /*Added by Dashrath- used for show hide draft icon in seed header*/
            if(document.getElementById("treeId").value > 0)
            {
              getDraftLeafDataCount(document.getElementById("treeId").value);
            }
            /*Dashrath- code end*/

					 }

				});

				return true;

			}



}





function canceleditLeaf(leafId, treeId, leafOrder, cNodeId, currentLeafMode,parentLeafId) 

{
	var editorLeafContentsleafOrder11='editorLeafContents'+leafOrder1+'1';

	var INSTANCE_NAME = $("#editorLeafContents"+leafOrder1+"1").attr('name');

	var getvalue = getvaluefromEditor(editorLeafContentsleafOrder11);
	
	//alert(getvalue);
	if(getvalue!='' && currentLeafMode=='draft')
	{
		//$('#leaf_contents'+cNodeId).html(getvalue);
		getUpdatedContents(cNodeId,2);
	}
	
	var leafTreeId = $('#leafTreeIdTalk').val();
		
	setTagAndLinkCount(cNodeId,2);
	
	setTagsAndLinksInTitle(cNodeId,2);
	
	//alert(leafTreeId);
	setTalkCount(leafTreeId);
	
	setLastTalk(leafTreeId);
	
	getSimpleColorTag(cNodeId,2);
	
	editorClose(INSTANCE_NAME);

	document.getElementById('editleaf'+leafOrder).style.display="none";
	
	//Manoj: froala editor show document leaf content on cancel
	if(document.getElementById('docLeafContent'+cNodeId))
	{
		document.getElementById('docLeafContent'+cNodeId).style.display="block";
	}
	

	document.getElementById('editStatus').value= 0;		

	var url = baseUrl+'unlock_leaf';		  

	xmlHttp1=GetXmlHttpObject2();

	queryString =   url; 

	queryString = queryString + '/index/leafId/'+leafId;

	

	xmlHttp1.open("GET", queryString, true);

	xmlHttp1.send(null);
	
	getTreeLeafObjectIconStatus(treeId, cNodeId, leafId, leafOrder, parentLeafId, currentLeafMode, workSpaceId, 2, 1);
	
	getLeafObjectStatus(treeId, cNodeId, leafId, leafOrder, parentLeafId, currentLeafMode, workSpaceId);

  /*Added by Dashrath- discard draft leaf*/
  var newDraftLeafNodeId=$("#newDraftLeafNodeId").val();
  if(newDraftLeafNodeId > 0)
  {
    //discard draft leaf
    discardDraftLeafByCancelButton(newDraftLeafNodeId);

    document.getElementById('newDraftLeafNodeId').value = 0;
    document.getElementById('editEditorActionWithoutAutoSave').value = 0;

    /*Added by Dashrath- used for show hide draft icon in seed header*/
    if(treeId > 0)
    {
      getDraftLeafDataCount(treeId);
    }
    /*Dashrath- code end*/
  }
  /*Dashrath- code end*/

  /*Added by Dashrath- delete memcache value*/
  if(leafId > 0)
  {
    deleteLeafLockDetailsFromMemcache(leafId);
  }
  /*Dashrath- code end*/

}



	function hideall(leafOrder)

	{

		if (document.getElementById('allnodesOrders'))

		{

			var arrLeafIds = new Array();

			arrLeafIds = document.getElementById('allnodesOrders').value.split(',');

		

			//alert ('arrleafids' + arrLeafIds);

			for(var i=0;i<arrLeafIds.length;i++)

			{

				if (leafOrder!=arrLeafIds[i])

				{

					if (document.getElementById('leafOptions'+arrLeafIds[i]).style.display != 'none')

					{

						document.getElementById('leafOptions'+arrLeafIds[i]).style.display = 'none';

					}

				}

			}

		}	

		if (document.getElementById('leafAddFirst'))

		{

			document.getElementById('leafAddFirst').style.display="none";	

		}

	}

	

	

	

	

function showLeafOptions(leafId, leafOrder, treeId, nodeId)

{

	var seedId = 'normalViewTree'+treeId;	

	 

	if(document.getElementById('editStatus').value == 1)

	{

		jAlert('Please click Save & Exit or Close button before accessing new leaf','Alert');

		return false;

	}		

	leafId1 	= leafId;	

	nodeId1 	= nodeId;		

	treeId1 	= treeId;

	leafOrder1 	= leafOrder;

	 

	timeInit 	= -1;



	hideall(leafOrder);



	

	if (document.getElementById('leafOptions'+leafOrder).style.display == "none")

	{

		//alert ('Here1');

		document.getElementById('leafOptions'+leafOrder).style.display = "";

	}

	else

	{

		//alert ('Here2');

		document.getElementById('leafOptions'+leafOrder).style.display = "none";

	}



}

	function handleLockLeaf() 

	{		

		if(xmlHttp.readyState == 4) 

		{			

			if(xmlHttp.status == 200) 

			{									

				strResponseText = xmlHttp.responseText;				

										

				if(strResponseText == 0)

				{}

				else

				{	

					jAlert('This leaf is already in edit mode','Alert');					

				}					

			}

		}



	}

	// this is a js function used for show the leaf previous version contents

	function showLeafPrevious(leafId, leafParentId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType, bgcolor,nodeId) 

	{	
	
		document.getElementById('versionLoader'+nodeId).innerHTML ="<span id='overlay' style='margin:15px 0px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></span>";

		nodeId1 = nodeId;

		nodeId_vk= leafId;

		curLeafId1 = curLeafId;

		curNodeOrder = leafOrder;

		spanTagLinkIconsId='spanTagLinkIcons'+leafOrder;

		

		var url = baseUrl+'view_leaf_previous_contents/index';  

		xmlHttp=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString+'/?leafParentId='+leafParentId+'&leafId='+leafId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&bgcolor='+bgcolor+'&nodeId='+nodeId;				

        xmlHttp.onreadystatechange = handleStateChange1;

		//alert ('state= ' + xmlHttp.status);
   // console.log (xmlHttp.responseText.split("|||"));

		spanTagViewInnerId='spanTagViewInner'+leafOrder;	

		leafHeaderId = 'leafOptionsHeader'+leafOrder;

		leafContentId = 'leafContent'+leafOrder;

		leafContentIdNew = 'leaf_contents'+nodeId;

		initialleafcontent='initialleafcontent'+leafOrder;

		spanTagNewId='spanTagNew'+leafOrder;

		spanTagViewLeafId='spanTagViewLeaf'+leafOrder;

		//alert (queryString);

		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, false);

		xmlHttp.send(null);

	}

	var nodeId1 ;

// this is a js function used to show the leaf next version contents from the current version

	function showLeafNext(leafId, leafChildId, version, curLeafId, leafOrder, treeId, workSpaceId, workSpaceType,bgcolor,nodeId) 

	{
   // alert ('leaf id= ' + leafId);
		document.getElementById('versionLoader'+nodeId).innerHTML ="<span id='overlay' style='margin:15px 0px;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></span>";

		curLeafId1 = curLeafId;	

		nodeId1=nodeId;

		nodeId_vk= leafId;

		curNodeOrder = leafOrder;
		
		treeId1 = treeId;

		spanTagLinkIconsId='spanTagLinkIcons'+leafOrder;

		//document.getElementById(spanTagLinkIconsId).style.display = 'none';

		var url = baseUrl+'view_leaf_next_contents/index';		

		xmlHttp=GetXmlHttpObject2();

		queryString =   url; 

		queryString = queryString+'/?leafChildId='+leafChildId+'&leafId='+leafId+'&version='+version+'&curLeafId='+curLeafId+'&leafOrder='+leafOrder+'&treeId='+treeId+'&workSpaceId='+workSpaceId+'&workSpaceType='+workSpaceType+'&bgcolor='+bgcolor+'&nodeId='+nodeId;			

		xmlHttp.onreadystatechange = handleStateChange1;

		leafHeaderId = 'leafOptionsHeader'+leafOrder

		leafContentId = 'leafContent'+leafOrder;

		leafContentIdNew = 'leaf_contents'+nodeId;

		initialleafcontent='initialleafcontent'+leafOrder;

		spanTagViewInnerId='spanTagViewInner'+leafOrder;

		spanTagViewLeafId='spanTagViewLeaf'+leafOrder;

		//alert (spanTagViewInnerId);

		spanTagNewId='spanTagNew'+leafOrder;



		hiddenId = 'hiddenId'+curNodeOrder;

		xmlHttp.open("GET", queryString, false);

		xmlHttp.send(null);

	}

	

	function handleStateChange1() 

	{
    //alert (xmlHttp.readyState);

		if(xmlHttp.readyState == 4) 

		{
       // alert (xmlHttp.status);
			if(xmlHttp.status == 200) 

			{					

				arrResponseText = new Array();

				//alert(xmlHttp.responseText);
        //alert(arrResponseText[12]);

				if(xmlHttp.responseText)
        {
          //alert(arrResponseText[0]);
					arrResponseText = xmlHttp.responseText.split("|||");
          //alert(arrResponseText[5]);
					
					//alert(arrResponseText[12]);
					//alert(arrResponseText[11]+"author"+nodeId1);

          // tag link talk li
					$("#ulNodesHeader"+nodeId1).html(arrResponseText[5]);

					//$("#normalView"+nodeId1).html(arrResponseText[7]);

          //blank &nbsp;
					$("#editDocumentOption"+nodeId1).html(arrResponseText[6]);

					
          //Added by dashrath : code start
          //remove copy, move and delete html
          document.getElementById('copyLeafSpan'+nodeId1).innerHTML  = '';
          document.getElementById('moveLeafSpan'+nodeId1).innerHTML  = '';
          document.getElementById('deleteLeafSpan'+nodeId1).innerHTML  = '';
          document.getElementById('draftTxt'+nodeId1).innerHTML  = '';
          //Dashrath : code end
					
          //leaf current version
          //alert(leafHeaderId+" content-- "+arrResponseText[0]);
					document.getElementById(leafHeaderId).innerHTML			= arrResponseText[0];
          // leaf content
					document.getElementById(leafContentIdNew).innerHTML		= arrResponseText[1];

					/*Changed by Dashrath- change id author to dateTime*/
          // leaf date time
					document.getElementById("dateTime"+nodeId1).innerHTML = arrResponseText[11];
					
					if(arrResponseText[12]!='')
					{
						$('#'+leafContentIdNew).removeAttr('class');
						$('#'+leafContentIdNew).addClass("contentContainer "+arrResponseText[12]+"_systemTag");
					}
					else
					{
						$('#'+leafContentIdNew).removeAttr('class');
						$('#'+leafContentIdNew).addClass("contentContainer");
					}

          /*Added by Dashrath- code start*/
          // reserved and unreserved span
          document.getElementById("reservedUnreserved"+nodeId1).innerHTML = arrResponseText[13];

          var tagNameDeleteMoveCopy = arrResponseText[14].split("^^^^");
          // Author name
          //document.getElementById("author"+nodeId1).innerHTML = arrResponseText[14];
          document.getElementById("author"+nodeId1).innerHTML = tagNameDeleteMoveCopy[0];

          // delete icon for latest version
          if(tagNameDeleteMoveCopy[1]!='' && tagNameDeleteMoveCopy[1]!==undefined)
          {
            document.getElementById("deleteLeafSpan"+nodeId1).innerHTML = tagNameDeleteMoveCopy[1];
          }

          // delete icon for latest version
          if(tagNameDeleteMoveCopy[2]!='' && tagNameDeleteMoveCopy[2]!==undefined)
          {
            document.getElementById("moveLeafSpan"+nodeId1).innerHTML = tagNameDeleteMoveCopy[2];
          }

          // delete icon for latest version
          if(tagNameDeleteMoveCopy[3]!='' && tagNameDeleteMoveCopy[3]!==undefined)
          {
            document.getElementById("copyLeafSpan"+nodeId1).innerHTML = tagNameDeleteMoveCopy[3];
          }
          //Dashrath : code end

          // draft text
           if(tagNameDeleteMoveCopy[4]!='' && tagNameDeleteMoveCopy[4]!==undefined)
          {
            document.getElementById("draftTxt"+nodeId1).innerHTML = tagNameDeleteMoveCopy[4];
          }
					
					//$("#draftNodesHeader"+nodeId1).html(arrResponseText[13]);
					
				}
				else
				{
					//alert(nodeId1+'=='+curLeafId1+'=='+curNodeOrder+'=='+treeId1);
					var leaf_data="&treeId="+treeId1+"&nodeId="+nodeId1;
	
					$.ajax({
									   
							url: baseUrl+'comman/getNextLeafReservedStatus',
							
							type: "POST",
							
							data: 'leaf_data='+leaf_data,
										
							dataType: "html",
							
							success:function(result)
							{
								//alert(result);
								result = result.split("|||");
								//alert(result[0]+'==='+result[1]);
								if(result[0]==1)
								{
									jAlert(result[1],"Alert");
												
									return false;
								}
								else if(result[0]==3)
								{
									jAlert(result[1],"Alert");
									
									return false;
								}
							}
					});
						
				}
				document.getElementById('versionLoader'+nodeId1).innerHTML =" ";

			}

		}

	}

	

	function saveDocument()

	{		

		//var getvalue1 = getvaluefromEditor('editorContents2');

		//var editorContents2='editorContents2';

		

		var documentTitle='documentTitle';

		

		//var getvalue2 = getvaluefromEditor('documentTitle');
		var getvalue2 = document.getElementById('documentTitle').value;
		

		//alert(getvalue1);

		//document.frmDocument.editorContents.value = getvalue1;		

		document.frmDocument.documentTitle.value = getvalue2;	

		var docTitle = document.getElementById('documentTitle').value;

		/*if(getvalue2.indexOf("<img")!=-1)

		{

			jAlert("Please do not use images in title","Alert");

			document.getElementById('documentName').focus();

			return false;

		}

		else if($("<p>"+getvalue2+"</p>").text().trim()=='')

		{

			jAlert("Please enter the title","Alert");

			document.getElementById('documentName').focus();

			return false;

		}*/
		if(getvalue2 == '')

		{

			jAlert("Please do not use images in title","Alert");

			document.getElementById('documentName').focus();

			return false;

		}

			

		document.frmDocument.submit();		

		return true;

	}

	

	function saveDocument2()

	{							

		var docTitle = document.getElementById('documentTitle').value;

	

		if(trim(docTitle) =="")

		{

			jAlert("Please enter the document title","Alert");

			document.getElementById('documentTitle').focus();

			return false;

		}		

		document.frmDocument.submit();		

		return true;	

	}

	function bodyUnload() 

	{

		var url = baseUrl+'unlock_leafs';		  

		xmlHttp1=GetXmlHttpObject2();

		queryString =   url; 		

		xmlHttp1.open("GET", queryString, true);

		xmlHttp1.send(null);	

		

	}

	function validateDocumentTitle()

	{

			//alert ('here');

		var getvalue = getvaluefromEditor('documentName');

		var documentName='documentName';

		

		if(getvalue == "")

		{

			jAlert("Please enter the document title","Alert");

			document.getElementById('documentName').focus();

			return false;

		}

		return true;

	}

	////////////////////// tags/////////////////

	function documentTreeOperations(object,operation,treeId,treeName)

	{
		
		var isios = (/iphone|ipod|ipad/i.test(navigator.userAgent.toLowerCase()));
		
		if(document.getElementById('aMove'))
		{
	  		document.getElementById('aMove').className='';
		}
		
		if(document.getElementById('acreateVersion'))

		{

			document.getElementById('acreateVersion').className='';

		}

		if(document.getElementById('aexportFile'))

		{

			document.getElementById('aexportFile').className='';

		}
		
		/*Manoj: assign Contributors className start*/
		if(document.getElementById('aContributors'))

		{

			document.getElementById('aContributors').className='';

		}
		/*Manoj: assign Contributors className end*/

    /*Dashrath: code start*/
		if(document.getElementById('aCreateLeaf'))
    {
        document.getElementById('aCreateLeaf').className='';
    }
    /*Dashrath: code end*/

    /*Dashrath: code start*/
    if(document.getElementById('aDocumentAddPos'))
    {
        document.getElementById('aDocumentAddPos').className='';
    }
    /*Dashrath: code end*/

    /*Dashrath: code start*/
    if(document.getElementById('aNumbered'))
    {
        document.getElementById('aNumbered').className='';
    }
    /*Dashrath: code end*/

	   	object.className="hiLite";

	    if(operation=='move')

	  	{

		  document.getElementById('ulTreeOption').style.display='none';

		 

		  //document.getElementById('spanMoveTree').style.display='block';
		  showPopWin(baseUrl+'comman/getMoveSpaceLists/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,500, 350, null, '');

		}

		 

		else if(operation=='createVersion')

	 	{	

		    /*Added by Surbhi IV for checking version */
			/*Changed by Dashrath- change message tree replace from document*/
			msg = "Are you sure you want to create a new version of document?";
						
			var agree = confirm(msg);
			if(agree)
			{

		    var request = $.ajax({

				  url: baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId,

				  type: "POST",

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					   if(result>0)

					   {

					   		/*End of Added by Surbhi IV for checking version */

						   // window.open(baseUrl+'create_tree_version/index/'+treeId);
						   window.location = baseUrl+'create_tree_version/index/'+treeId;

							document.getElementById('ulTreeOption').style.display='none';

							document.getElementById('spanMoveTree').style.display='none';

					   		/*Added by Surbhi IV for checking version */

					   }

					   else

					   {

					        jAlert("You can not create new version of tree because new version of this tree has been created.","Alert");

							return false;

					   }

				  }

				});
				
			}
			/*End of Added by Surbhi IV for checking version */

		}

		else if(operation=='exportFile')

		{

			//window.open(baseUrl+'create_xml_file/index/'+treeId);
			
			if(isios==true)
			{
				parent.window.open(baseUrl+'create_xml_file/index/'+treeId,"mywindow");
			}
			else
			{
				window.location = baseUrl+'create_xml_file/index/'+treeId;
			}
			

		}
		
		/*Manoj: Contributors operation start*/
	   else if(operation=='contributors')

		 {

			 document.getElementById('ulTreeOption').style.display='none';

			 document.getElementById('divAutoNumbering').style.display='none';

			 document.getElementById('spanMoveTree').style.display='none';	

		 	 showPopWin(baseUrl+'comman/getDocCountributors/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,600, 350, null, '');

		 }
		/*Manoj: Contributors operation end*/
		
		/*Manoj: Export popup start*/
	   	else if(operation=='export')

		 {

			 document.getElementById('ulTreeOption').style.display='none';

			 document.getElementById('divAutoNumbering').style.display='none';

			 document.getElementById('spanMoveTree').style.display='none';	

		 	 showPopWin(baseUrl+'comman/getExportOptions/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+treeName,600, 350, null, '');

		 }
		/*Manoj: Export popup end*/
		
		else if(operation=='exportPdf')

		 {

			if(isios==true)
			{
				parent.window.open(baseUrl+'pdf_generator/index/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+treeName,"mywindow");
			}
			else
			{
				window.location = baseUrl+'pdf_generator/index/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+treeName;	
			}
		 }
		
	   	else if(operation=='exportDoc')

		 {

			window.location = baseUrl+'doc_generator/index/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType+'/'+treeName;
			
		 }
		 
    else if(operation=='create_leaf_by_folder')
    {
      document.getElementById('ulTreeOption').style.display='none';

      showPopWin(baseUrl+'external_docs/getCreateLeafFoldersList/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,400, 200, null, '');
    }

    else if(operation=='document_add_position')
    {
      document.getElementById('ulTreeOption').style.display='none';

      showPopWin(baseUrl+'view_document/documentAddPositionView/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,400, 200, null, '');
    }

    else if(operation=='autoNumbering')
    {
      document.getElementById('ulTreeOption').style.display='none';

      showPopWin(baseUrl+'view_document/autoNumberingView/'+treeId+'/'+workSpaceId+'/type/'+workSpaceType,320, 150, null, '');
    }

		 

		 else

		 {

			 

		 	  document.getElementById('spanMoveTree').style.display='none';	

		 //return false;

		 }

	

	}

	

	function clickDocumentOptions(position)

	{ 

		nodeOptionsVisible=position;

		var notesId = 'normalView'+position;	

		$('.normalView').hide();

		$('.ulNodesHeader').hide();

		$('.clsDocNodeVersion').hide();

		

      	if(document.getElementById(notesId).style.display == "none")

	  	{

		  	document.getElementById(notesId).style.display = "block";

			document.getElementById("ulNodesHeader"+position).style.display = "block";

			//document.getElementById("divDocNodeVersion"+position).style.display = "block";
			$("#divDocNodeVersion"+position).show();
			$("#draftNodesHeader"+position).show();
			

		}

	  	else if(clickEvent!=position)

	  	{ 

		  	document.getElementById(notesId).style.display = "none";

			document.getElementById("ulNodesHeader"+position).style.display = "none";

			//document.getElementById("divDocNodeVersion"+position).style.display = "none";
			
			$("#divDocNodeVersion"+position).hide();
			
			$("#draftNodesHeader"+position).hide();

		}

	

	}

	

	function showDocumentNodeOptions(position)

	{	

		//alert(position+'==='+nodeOptionsVisible);

		/*if(nodeOptionsVisible!=position )

		{*/

			var notesId = 'normalView'+position;

			document.getElementById(notesId).style.display = "block";

			document.getElementById("ulNodesHeader"+position).style.display = "block";

			if(position)

			{

				//document.getElementById("divDocNodeVersion"+position).style.display = "block";
				
				$("#divDocNodeVersion"+position).show();
				
				$("#draftNodesHeader"+position).show();

			}

			clickEvent=position;

			

			

	  /* }*/

	}

	

	function hideDocumentNodeOptions(position)

	{	

		

		/*if(nodeOptionsVisible!=position)

		{*/

			var notesId = 'normalView'+position;	

			document.getElementById("ulNodesHeader"+position).style.display = "none";

			document.getElementById(notesId).style.display = "none";

			if(position){

			   //document.getElementById("divDocNodeVersion"+position).style.display = "none";
			   
			   $("#divDocNodeVersion"+position).hide();
			   
			   $("#draftNodesHeader"+position).hide();

			}

		/*}*/

	}
	
	function resetTaskSearchForm($form) { 
		 
		$form.find('select[name="originator"]').val("0");
		$form.find('select[name="assigned_to"]').val("0");
		$form.find('select[name="taskSort"]').val("3");
		$form.find('input:text, input:password, input:file, textarea').val('');
		$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
		document.getElementById("taskSearchResults").style.display = "none";
	}



var filterOpt = 0;

ajaxData='';

$(document).ready(function(){

	$(document).delegate('.tagm','click',function(){

		url = $(this).attr('href');
		
		//alert (url);

		tagName = $(this).text();

		if($(this).hasClass("userTag")){

			

			rm = $(this).attr("remUsr");

			

			if(rm==0){

				$(".userTag").removeClass("highlight");

				$(".userTag").attr("rem",0);

				$(".userTag > img").remove();

				

				$(this).replaceWith("<a href='"+url+"' class='blue-link-underline userTag highlight tagm' remUsr='1'>"+tagName+"<img src='"+baseUrl+"/images/del_black.png' style='vertical-align:middle;margin:2px;' ></a>");

				//url = url+"?ajax=1";
				if (url.indexOf("treeId")==-1)
				{
					url = url+"?ajax=1";
				}
				else
				{
					url = url+"&ajax=1";
				}				

			}

			else{

				$(this).replaceWith("<a href='"+url+"' class='blue-link-underline userTag tagm' remUsr='0'>"+tagName+"</a>");

				//url = url+"?ajax=1&remUsr="+rm;
				if (url.indexOf("treeId")==-1)
				{
					url = url+"?ajax=1&remUsr="+rm;
				}
				else
				{
					url = url+"&ajax=1&remUsr="+rm;
				}

			}

		}

		else{

			rm = $(this).attr("rem");

			//below is the code for removing user tags when selecting any other tag(uncomment if necessary)

			/*$(".userTag").removeClass("highlight");

			$(".userTag").attr("remUsr",0);

			$(".userTag > img").remove();*/

			if(rm==0){

				$(this).replaceWith("<a href='"+url+"' class='blue-link-underline highlight tagm' rem='1'>"+tagName+"<img src='"+baseUrl+"/images/del_black.png' style='vertical-align:middle;margin:2px;'></a>");
				
				//url = url+"?ajax=1";
				if (url.indexOf("treeId")==-1)
				{
					url = url+"?ajax=1";
				}
				else
				{
					url = url+"&ajax=1";
				}
			}

			else{

				$(this).replaceWith("<a href='"+url+"' class='blue-link-underline tagm' rem='0'>"+tagName+"</a>");

				//url = url+"?ajax=1&rem="+rm;
				if (url.indexOf("treeId")==-1)
				{
					url = url+"?ajax=1&rem="+rm;
				}
				else
				{
					url = url+"&ajax=1&rem="+rm;
				}

			}

		}

		$.post(url,{},function(data){

			ajaxData = data;

		});

		return false;

		});

		$(document).delegate('#go','click',function(){
			$("#leaves").html(ajaxData);

		});

		$(document).delegate('#clear','click',function(){

			$(".highlight").click();

			ajaxData = "";

			$("#leaves").html("");

		});

	

	});

//Manoj: code for start and stop audio record

function startAudioRecord(editorId)
 {
	//Manoj: Code to check audio record device
	 try {
     
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);
      window.URL = window.URL || window.webkitURL;

      audio_context = new AudioContext;
      //__log('Audio context set up.');
     // __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      //alert('No web audio support in this browser!');
    }
	
	navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
     // __log('No live audio input: ' + e);
	 $('#popupButton2-'+editorId).attr('disabled', true);
	 $('#popupButton1-'+editorId).attr('disabled', true);
	 $('#popupButton2-'+editorId).attr('title', 'Stop');
	 $('#popupButton1-'+editorId).attr('title', 'Record');
	 alert("No audio device found!");
	});
	
	
	
	//Manoj: Code end 
	 
	}

  var audio_context;
  var recorder;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
   // __log('Media stream created.' );
	//__log("input sample rate " +input.context.sampleRate);

    // Feedback!
    //input.connect(audio_context.destination);
   // __log('Input connected to audio context destination.');

    recorder = new Recorder(input, {
                  numChannels: 1
                });
   // __log('Recorder initialised.');
  }

  function startRecording(editorId) {
	//alert(leafTreeId);
	var usrtagname = $('#usrtagname').val();
	window.usrtagname=usrtagname;
	window.value=editorId;
    recorder && recorder.record();
	
	$('#popupLoader-'+editorId).show();
	$('#popupButton1-'+editorId).attr('disabled', true);
    $('#popupButton2-'+editorId).attr('disabled', false);
	$('#popupButton1-'+editorId).attr('title', 'Record');
   
   
  }

  function stopRecording(editorId) {
    recorder && recorder.stop();
    $('#popupLoader-'+editorId).hide();
	$('#popupButton1-'+editorId).css("margin-left", "25px");
	$('#popupStopped-'+editorId).css("float", "left");
	$('#popupStopped-'+editorId).show();
	$('#popupButton2-'+editorId).attr('disabled', true);
    $('#popupButton1-'+editorId).attr('disabled', false);
	$('#popupButton2-'+editorId).attr('title', 'Stop');
    createDownloadLink();
    recorder.clear();
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
     
    });
  }

//Manoj: code end

//Manoj: Talk chat box code start

$(document).ready(function(){
	$("#container").append('<div id="mainTalkBox"><div class="otherarea"></div></div>');						   
});
//Added by Dashrath- changed container id to newContainer
//Commented by Dashrath- changed newContainer id to container
// $(document).ready(function(){
//   $("#newContainer").append('<div id="mainTalkBox"><div class="otherarea"></div></div>');               
// });
function closeTalkChat(leafTreeId,talkNodeId,treeId,workSpaceId,artifactType,treeType,talkseed)
{
	$(".talkLoader"+leafTreeId).html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	
	setTalkCount(leafTreeId);
	
	setLastTalk(leafTreeId);
	
  /*Changed by Dashrath- Add if else condition tag and link count and title disapper in talkseed*/
  if(talkseed==1)
  {
    setTagAndLinkCount(treeId,1);
  
    setTagsAndLinksInTitle(treeId,1);
  
    getSimpleColorTag(treeId,1);
  
    getUpdatedContents(treeId,1);
  }
  else
  {
  	setTagAndLinkCount(talkNodeId,2);
  	
  	setTagsAndLinksInTitle(talkNodeId,2);
  	
  	getSimpleColorTag(talkNodeId,2);
  	
  	getUpdatedContents(talkNodeId,2);
  }
  /*Dashrath- changes code end*/
	
	if($(".talk"+leafTreeId).is(":visible"))
	{
		setTimeout(function() 
		{ 	
			removeTalkWindow(leafTreeId);
		}, 100);	
	}
	
	if(artifactType==2 && treeType==1)
	{
		getTreeLeafObjectIconStatus(treeId, talkNodeId, '', '', '', '', workSpaceId, artifactType, treeType);
	}
	
	if(talkseed==1)
	{
		getParentUpdatedSeedContents(treeId,1);
	}
	
}
function removeTalkWindow(leafTreeId)
{
	$(".talkLoader"+leafTreeId).html("");
	$(".talk"+leafTreeId).remove();	
}
function hideTalkChat(leafTreeId,talkNodeId,treeId,workSpaceId,artifactType,treeType,talkseed)
{
	setTalkCount(leafTreeId);
	
	setLastTalk(leafTreeId);
	
  /*Changed by Dashrath- Add if else condition tag and link count and title disapper in talkseed*/
  if(talkseed==1)
  {
    setTagAndLinkCount(treeId,1);
  
    setTagsAndLinksInTitle(treeId,1);
  
    getSimpleColorTag(treeId,1);
  
    getUpdatedContents(treeId,1);
  }
  else
  {
  	setTagAndLinkCount(talkNodeId,2);
  	
  	setTagsAndLinksInTitle(talkNodeId,2);
  	
  	getSimpleColorTag(talkNodeId,2);
  	
  	getUpdatedContents(talkNodeId,2);
  }
  /*Dashrath- changes code end*/
	
	if($(".talk_content"+leafTreeId).is(":visible"))
	{
		$(".talk_content"+leafTreeId).hide();	
		$(".talk_chat_size"+leafTreeId).html('<i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp;&nbsp;');
		$("#tooltiptext"+leafTreeId).removeClass('tooltiptext').addClass('tooltiptextBottom');
		
	}
	else
	{
		$(".talk_content"+leafTreeId).show();
		$(".talk_chat_size"+leafTreeId).html('<b>_ </b>&nbsp;&nbsp;');
		$("#tooltiptext"+leafTreeId).removeClass('tooltiptextBottom').addClass('tooltiptext');
		$(".talk_head"+leafTreeId).removeClass('talkBlink');
	}
	
	if(artifactType==2 && treeType==1)
	{
		getTreeLeafObjectIconStatus(treeId, talkNodeId, '', '', '', '', workSpaceId, artifactType, treeType);
	}
	if(talkseed==1)
	{
		getParentUpdatedSeedContents(treeId,1);
	}
}

function talkOpen(leafTreeId,workSpaceId,workSpaceType,treeId,talkTitle,talkseed,talkhtmlTitle,talkNodeId,artifactType,treeType)
{	 
	if(talkseed!=1)
	{
		$("#versionLoader"+talkNodeId).html("<div id='overlay' style='margin:1% 0;'><img src='"+baseUrl+"/images/ajax-loader-add.gif'></div>");
	}

	if(treeId=='')
	{
		var className = 'abs_content_disable';
	}
	else
	{
		var className = 'abs_content';
	}
	 //alert(talkNodeId);
	 var talkhtmlTitle = $("#talk_content"+leafTreeId).val();
	 //alert(talkhtmlTitle);
	 var str = talkhtmlTitle.replace(/<{1}[^<>]{1,}>{1}/g," ");
	 var talkShortTitle;
	 if(talkTitle=='')
	 {
		 talkShortTitle = 'image/audio/video';
	 }
	 else
	 {
		 if(str.length > 25)
		 {
			talkShortTitle = (str.substring(0, 25))+'...'; 
		 }
		 else
		 {
			talkShortTitle = str;
		 }
	 }
	 //return false;
	
	if($(".talk"+leafTreeId).length == 0)
	{
		var talkBoxCount = $('.abs').length;
		//alert(talkBoxCount);
		//Manoj: check tablet device
		var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
		if(istablet==true)
		{
			if(talkBoxCount>1)
			{
				alert('You already have 2 talk windows open. Please close one to open a new window.');
				if(talkseed!=1)
				{
					$("#versionLoader"+talkNodeId).html("");
				}
				return false;
			}
		}
		else
		{
			if(talkBoxCount>3)
			{
				alert('You already have 4 talk windows open. Please close one to open a new window.');
				 if(talkseed!=1)
				 {
					$("#versionLoader"+talkNodeId).html("");
				 }
				return false;
			}
		}
		var urlLink;
		if(talkseed=='1')
		{
		 	urlLink = baseUrl+"view_talk_tree/node/"+leafTreeId+"/"+workSpaceId+"/type/"+workSpaceType+"/ptid/"+treeId+"/"+talkseed;
			talkNodeId = 0;
		}
		else
		{
			urlLink = baseUrl+"view_talk_tree/node/"+leafTreeId+"/"+workSpaceId+"/type/"+workSpaceType+"/ptid/"+treeId+"?talkNodeId="+talkNodeId;
		}
	$.ajax({

		  type: 'POST',
			
		  url: urlLink,
		  
		  success: function(data){
			  
			 //alert(data);
			 if($(".talk"+leafTreeId).length == 0)
			 {
				 $('.otherarea').append('<div class="talk'+leafTreeId+' abs"><div class="abs_head talk_head'+leafTreeId+'"><div class="talktxtTitle"><span class="shortTitle"><img src="'+baseUrl+'images/talk.gif" alt="Talk" border=0 ><b>'+talkShortTitle+'</b><span class="tooltip"><span id="tooltiptext'+leafTreeId+'" class="tooltiptext">'+talkhtmlTitle+'</span></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeTalkChat('+leafTreeId+','+talkNodeId+','+treeId+','+workSpaceId+','+artifactType+','+treeType+','+talkseed+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size'+leafTreeId+'" onclick="hideTalkChat('+leafTreeId+','+talkNodeId+','+treeId+','+workSpaceId+','+artifactType+','+treeType+','+talkseed+')"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="'+className+' talk_content'+leafTreeId+'">'+data+'</div></div>');
			 }
			 
			 if(talkseed!=1)
			 {
				$("#versionLoader"+talkNodeId).html("");
			 }
			
			},

		});
	}
	else
	{
		$(".talk_content"+leafTreeId).show();
		$(".talk_chat_size"+leafTreeId).html('<b>_ </b>&nbsp;&nbsp;');
		$("#tooltiptext"+leafTreeId).removeClass('tooltiptextBottom').addClass('tooltiptext');
		if(talkseed!=1)
		{
			$("#versionLoader"+talkNodeId).html("");
		}
		$(".talk_head"+leafTreeId).removeClass('talkBlink');
	}
	//setInterval("testing("+leafTreeId+","+workSpaceId+","+workSpaceType+","+treeId+")",10000);
}

function CommentBoxOpen(nodeId,workSpaceId,workSpaceType,treeId,talkTitle,talkseed,talkhtmlTitle)
{
	
	 var str = talkhtmlTitle.replace(/<{1}[^<>]{1,}>{1}/g," ");
	 var talkShortTitle;
	 if(talkTitle=='')
	 {
		 talkShortTitle = 'image/audio/video';
	 }
	 else
	 {
		 if(str.length > 25)
		 {
			talkShortTitle = (str.substring(0, 25))+'...'; 
		 }
		 else
		 {
			talkShortTitle = str;
		 }
	 }
	 //return false;
	
	if($(".talk"+nodeId).length == 0)
	{
		var talkBoxCount = $('.abs').length;
		//alert(talkBoxCount);
		//Manoj: check tablet device
		var istablet = (/ipad|android 4.1|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
		if(istablet==true)
		{
			if(talkBoxCount>1)
			{
				alert('You already have 2 talk windows open. Please close one to open a new window.');
				return false;
			}
		}
		else
		{
			if(talkBoxCount>3)
			{
				alert('You already have 4 talk windows open. Please close one to open a new window.');
				return false;
			}
		}
	 
	 	var urlLink;
		
		urlLink = baseUrl+"post/get_timeline_comment/"+nodeId+"/"+workSpaceId+"/type/"+workSpaceType+"/ptid/"+treeId;
		
		$.ajax({

		  type: 'POST',
			
		  url: urlLink,
		  
		  success: function(data){
			  
			 //alert(data);
			  //return false;
			 if($(".talk"+nodeId).length == 0)
			 { 
					$('.otherarea').append('<div class="talk'+nodeId+' abs"><div class="abs_head talk_head'+nodeId+'"><div class="talktxtTitle"><span class="shortTitle"><img src="'+baseUrl+'images/talk.gif" alt="Talk" border=0 ><b>'+talkShortTitle+'</b><span class="tooltip"><span id="tooltiptext'+nodeId+'" class="tooltiptext">'+talkhtmlTitle+'</span></span></span></div><div class="talkChatMinClose"><span class="talk_chat_close" onclick="closeTalkChat('+nodeId+')"><b>x </b>&nbsp;</span><span class="talk_chat_close talk_chat_size'+nodeId+'" onclick="hideTalkChat('+nodeId+')"><b>_ </b>&nbsp;&nbsp;</span></div></div><div class="abs_content talk_content'+nodeId+'">'+data+'</div></div>');
				 
				 	$('.focusText').focus();
			 }
			
			},

		});
	}
	else
	{
		$(".talk_content"+nodeId).show();
		$(".talk_chat_size"+nodeId).html('<b>_ </b>&nbsp;&nbsp;');
		$("#tooltiptext"+nodeId).removeClass('tooltiptextBottom').addClass('tooltiptext');
	}
}

//Manoj: code for remove search text

$('#headSearch').keydown(function(event) {
        if (event.keyCode == 13) {
            //alert(this.value);
			var query=this.value;
			query=$.trim(query);
			
			var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			if (!regex.test(query)) {
			   event.preventDefault();
			   jAlert('Please enter a valid character(s)');
			   return false;
			}
			
			location.href = baseUrl+"search/text/"+workSpaceId+"/type/"+workSpaceType+"/tree/"+query;
			//alert(query.length);
			//return false;
			/*if(query.length<3)
			{
				$searchErrorMsg=$('#searchMsg').val();
				alert($searchErrorMsg);
				return false;
			}	*/		
			
         }
});

function discardDraftLeaf(leafId, treeId,leafOrder,nodeId,leafStatus,parentLeafId) 

{
		//alert(workSpaceId);
		//return false;
		var leafTreeId = $('#leafTreeIdTalk').val();
			
		setTagAndLinkCount(nodeId,2);
		
		setTalkCount(leafTreeId);
	
		msg= "Are you sure you want to discard this draft?";

		var agree = confirm(msg);
	
		if (agree)
	
		{
					var editorId = "editorLeafContents"+leafOrder+"1";
						
						$(".final").hide();
						
						//$("[value=Done]").hide();
				
						$("[value=Cancel]").hide();
						
						$(".saveDraft").hide();
						
						$(".discardButton").hide();
					
						  $("#loaderImage").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
				
						   //var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+leafOrder+"&treeId="+treeId+"&curNodeId="+nodeId+"&curLeaf="+leafId+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue)+"&leafPostStatus="+leafStatus;
				
						  var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+leafOrder+"&treeId="+treeId+"&curNodeId="+nodeId+"&curLeaf="+leafId+"&leafPostStatus="+leafStatus;
						  
							var request = $.ajax({
				
							  url: baseUrl+"edit_leaf_save/discardDraftLeaf/doc/exit",
				
							  type: "POST",
				
							  data: 'user_data='+user_data,
				
							  dataType: "html",
				
							  success:function(result)
				
									 {
										if(result)
										{
											 //alert(result);
				
											 editorClose(editorId);
											 
											 $("[value=Done]").show();
				
											 $("[value=Cancel]").show();
											 
											 $("#datacontainer").html(result);
											
											 $("#loaderImage").html('');
											
											//Call for reserve, tree versioning or move status
											//alert(treeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'==draft=='+workSpaceId);	
											getLeafObjectStatus(treeId,nodeId,leafId,leafOrder,parentLeafId,'draft',workSpaceId);
											//Code end

                      /*Added by Dashrath- used for show hide draft icon in seed header*/
                      if(treeId > 0)
                      {
                        getDraftLeafDataCount(treeId);
                      }
                      /*Dashrath- code end*/
											
											//Manoj: froala editor show content on edit document leaf
											document.getElementById('docLeafContent'+nodeId).style.display="block";
				
											document.getElementById('editStatus').value=0;
											
										}
										  
				
									}
				
								});
					
		}
		else
		{
	
			return false ;
	
		}
}

function checkTreeMove(treeId,workSpaceId,workSpaceType,talk,version)
{
	  var request = $.ajax({

	  url: baseUrl+'comman/checkTreeMove/'+treeId+'/'+workSpaceId+'/'+workSpaceType+'/1',

	  type: "POST",

	  success:function(result)

	  {
		 // alert(result);
		 if(result==1)
		 {
			//alert ('here');
			handleTreeStateChange2(treeId,version);
		 }
		 //Add SetTimeOut 
		 setTimeout("checkTreeMove('"+treeId+"','"+workSpaceId+"','"+workSpaceType+"','"+talk+"','"+version+"')", 30000);

	  }

	});
}

function setTalkCountByLeafId(nodeId,treeId)
{
	var leaf_data="&nodeId="+nodeId+"&treeId="+treeId;
	
	$.ajax({

	  url: baseUrl+'comman/getLeafTreeId/'+nodeId,

	  type: "POST",
	  
	  data: 'leaf_data='+leaf_data,

	  success:function(result)

	  {
		 if(result!='')
		 {
			//alert(result);
			setTalkCount(result);
			
			setLastTalk(result);
		 }
	  }

	});
}
function updateLeafContents(nodeId,treeId)
{
	setTagAndLinkCount(nodeId,2);
	
	setTagsAndLinksInTitle(nodeId,2);
			
	setTalkCountByLeafId(nodeId,treeId);
				
	getUpdatedContents(nodeId,2);
				
	getSimpleColorTag(nodeId,2);
}
//For tree seed
function updateSeedContents(treeId,type)
{
	setTagAndLinkCount(treeId,type);
	
	setTagsAndLinksInTitle(treeId,type);
			
	setTalkCountByLeafId('',treeId);
				
	getSimpleColorTag(treeId,type);
}

function getTreeLeafUsertoolsObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,successorLeafStatus,treeType,artifactType,talkStatus)
{
	//alert($('#workSpaceId').val());
	//alert(workSpaceId);
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}
	//alert(workSpaceId);
	//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus+'=='+successorLeafStatus);	
	var leaf_data="&treeId="+currentTreeId+"&nodeId="+nodeId+"&leafId="+leafId+"&leafOrder="+leafOrder+"&parentLeafId="+parentLeafId+"&treeLeafStatus="+treeLeafStatus+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType;
				$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafObjectStatusOnApply',
			
						type: "POST",
			
						 data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							//alert(result);
							
							result = result.split("|||");
							
							if(result!='' && result[0]!=5 && successorLeafStatus!='draft')
							{
								$('.button'+nodeId).attr("disabled", 'disabled');
								if(talkStatus!=1)
								{
									$('.button01').attr("disabled", 'disabled');
								}
							}
							
							if(result[0]==1)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
							else if(result[0]==2 && successorLeafStatus!='draft')
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
							else if(result[0]==3)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
							else if(result[0]==4)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
							else if(result[0]==6)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
							else if(result[0]==7)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
						}
				});
}

function getLeafObjectStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,workSpaceId,leafEditStatus)
{
	//alert(workSpaceId);
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}
	//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus);	
	var leaf_data="&treeId="+currentTreeId+"&nodeId="+nodeId+"&leafId="+leafId+"&leafOrder="+leafOrder+"&parentLeafId="+parentLeafId+"&treeLeafStatus="+treeLeafStatus+"&workSpaceId="+workSpaceId+"&leafEditStatus="+leafEditStatus;
				$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserObjectStatus',
			
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
							else if(result[0]==6)
							{
								jAlert(result[1],"Alert");
								
								window.location.href = baseUrl+'view_document/index/'+workSpaceId+'/type/'+workSpaceType+'/?treeId='+result[2]+'&doc=exist';

								return false;
							}
							else if(result[0]==7)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}
						}
				});
}

function getTreeLeafObjectIconStatus(currentTreeId,nodeId,leafId,leafOrder,parentLeafId,treeLeafStatus,workSpaceId,artifactType,treeType)
{
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}
	//alert(currentTreeId+'=='+nodeId+'=='+leafId+'=='+leafOrder+'=='+parentLeafId+'=='+treeLeafStatus);	
	var leaf_data="&treeId="+currentTreeId+"&nodeId="+nodeId+"&leafId="+leafId+"&leafOrder="+leafOrder+"&parentLeafId="+parentLeafId+"&treeLeafStatus="+treeLeafStatus+"&workSpaceId="+workSpaceId;
				$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafObjectIconStatus',
			
						type: "POST",
			
						 data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							if(treeType==1 && artifactType==2)
							{
								//alert(result);
								result = result.split("|||");
								//alert(result[0]+'==='+result[1]+'==='+result[2]);
								if(parentLeafId === "undefined" || parentLeafId=='')
								{
									parentLeafId = result[4];
								}
								if(result[0]==1)
								{
									$('#liReserve'+parentLeafId,parent.document).hide();
									//$('#docEditBtn'+nodeId,parent.document).hide();

                  /*Commented by Dashrath- Comment old code and add new code below with if else condition*/
									// $('#docEditBtn'+nodeId,parent.document).removeClass();
									// $('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
                  
                  /*Added by Dashrath- Add new code with if else condition*/
                  if(treeLeafStatus=='draft' && result[5]==1)
                  {
                  }
                  else
                  {
                    $('#docEditBtn'+nodeId,parent.document).removeClass();
                    $('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
                  }
                  /*Dashrath- code end*/
								}
								else if(result[0]==2)
								{
									//$('#docEditBtn'+nodeId,parent.document).show();
									$("#liReserve"+parentLeafId,parent.document).html("");
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disblock3');
								}
								else if(result[0]==3)
								{
									$('#liReserve'+parentLeafId,parent.document).show();
									//$('#docEditBtn'+nodeId,parent.document).hide();
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
									$("#liReserve"+parentLeafId,parent.document).html("<img src='"+baseUrl+"/images/reserve.png' border='0'>");
									$("#liReserve"+parentLeafId,parent.document).attr('title', 'Reserved');
								}
								else if(result[0]==4)
								{
									$('#liReserve'+parentLeafId,parent.document).show();
									//$('#docEditBtn'+nodeId,parent.document).show();
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disblock3');
									$("#liReserve"+parentLeafId,parent.document).html("<img src='"+baseUrl+"/images/reserve.png' border='0'>");
									$("#liReserve"+parentLeafId,parent.document).attr('title', 'Reserved');
								}
								else if(result[0]==7)
								{
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
									$('#draftTxt'+nodeId,parent.document).hide();									
								}
								else if(result[0]==5 || result[0]==6 || result[0]==8 || result[0]==9)
								{
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
								}
								
								if(result[1]=='publish')
								{
									$('#draftTxt'+nodeId,parent.document).hide();
								}
								if(result[2]=='1')
								{
									$("#liReserve"+parentLeafId,parent.document).html("<img src='"+baseUrl+"/images/reserve.png' border='0'>");
									$("#liReserve"+parentLeafId,parent.document).attr('title', 'Reserved');
								}
								if(result[3]=='1')
								{
									$('#docEditBtn'+nodeId,parent.document).removeClass();
									$('#docEditBtn'+nodeId,parent.document).addClass('disnone2');
								}
							}
						}
				});
}
//For other trees
function getTreeLeafUserStatus(currentTreeId,nodeId,treeType,talkStatus)
{
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}
	var leaf_data="&treeId="+currentTreeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType="+treeType;
				$.ajax({
					   
						url: baseUrl+'comman/getTreeLeafUserStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							//alert(result);
							
							result = result.split("|||");
							
							/*if(result!='')
							{
								$('.button'+nodeId).attr("disabled", 'disabled');
								if(talkStatus!=1)
								{
									$('.button01').attr("disabled", 'disabled');
								}
							}*/
							
							if(result[0]==1)
							{
								$('.button'+nodeId).attr("disabled", 'disabled');
								if(talkStatus!=1)
								{
									$('.button01').attr("disabled", 'disabled');
								}
								
								jAlert(result[1],"Alert");
								
								return false;
							}
							/*else if(result[0]==2)
							{
								jAlert(result[1],"Alert");
								
								return false;
							}*/
						}
				});
}

function getShowHideTreeLeafIconsStatus(currentTreeId,nodeId,treeType,talkStatus)
{
	if(workSpaceId=='')
	{
		workSpaceId = $('#workSpaceId').val();
	}
	//alert(currentTreeId+'=='+nodeId+'=='+treeType+'=='+talkStatus);
	var leaf_data="&treeId="+currentTreeId+"&nodeId="+nodeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeType="+treeType;
				$.ajax({
					   
						url: baseUrl+'comman/getShowHideTreeLeafIconsStatus',
			
						type: "POST",
			
						data: 'leaf_data='+leaf_data,
						
						dataType: "html",
			
						success:function(result)
						{
							//result = result.split("|||");
							if(treeType == 4)
							{
								//alert(result);
								if(result==1)
								{
									$('.editDocumentOption',parent.document).show();
								}
								else if(result==2)
								{
									$('.editDocumentOption',parent.document).hide();
								}
							}
						}
				});
}

//Manoj: code end

/* Added by Dashrath : code start */
function leafPasteMoveAddConfirm(leafId,treeId,leafOrder)
{
  var flag = true;

  var request = $.ajax({

  url: baseUrl+"edit_leaf_save/checkLeafSession",

  type: "GET",

  dataType: "html",

  async:false,

  success:function(result)
     { 
      if(result){

        if(result == 'copy')
        {
          if(leafId == 0)
          {
            if(firstNewLeafPaste(leafId,treeId,leafOrder))
            {
              flag = true;
            }else
            {
              flag = false;
            }
            
          }
          else{
            if(newLeafPaste(leafId,treeId,leafOrder))
            {
              flag = true;
            }else
            {
              flag = false;
            }
          }
          
          
        }else if(result == 'move')
        {
          if(newLeafMoveOrder(leafId,treeId,leafOrder))
          {
            flag = true;
          }else
          {
            flag = false;
          }
        }else{
          flag = false;
        }
        
      }
      else
      {
        document.getElementById('docErrorMsg').innerHTML="error";
      }
     }

  });

  return flag;
}

/* Dashrath : code end */


/* Added by Dashrath : code start */
function firstNewLeafPaste(leafId,treeId,leafOrder) 
{

  var r=confirm("Do you want to paste copied content?")
  if (r==true)
  {
    var flag = true;

    var xmlHttpTree=GetXmlHttpObject2();

    var getvalue = "";


    var data_user =$("#form10").serialize();

    data_user=  data_user+'&curLeaf='+leafOrder+'&curContent='+encodeURIComponent(getvalue)+'&curLeafOrder='+leafOrder+'&frmEditLeaf=addFirst&editorname1=curContent&predecessor=0&successors=0&curOption=addFirst&workSpaceId='+workSpaceId+"&workSpaceType="+workSpaceType ; 


    $('#image').show();

    var request = $.ajax({

    url: baseUrl+"edit_leaf_save/index/doc/exit/paste",

    type: "POST",

    data: data_user,

    dataType: "html",

    async:false,

    success:function(result)
        { 
        if(result){

          $("[value=Done]").show();

          $("[value=Cancel]").show();
    
          //alert(result);
    
          $("#leafAddFirst").hide();
    
           
           $("#docfirstLeaf").hide();
           
    
          $("#datacontainer").html(result);

          flag = true;

        }
        else
        {
          document.getElementById('docErrorMsg').innerHTML="error";
        }
        editorCheck();
        }

    });

    return flag;
  } 
  else
  {
    clearLeafData();
    return false;
  }
  
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function newLeafPaste(leafId,treeId,leafOrder) 
{
  var r=confirm("Do you want to paste copied content?")
  if (r==true)
  {
    document.getElementById('leafPasteLoader'+leafId).innerHTML ="<div id='overlay' style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>";
    var xmlHttpTree=GetXmlHttpObject2();

    var url = baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId;

    var flag = true;

    //$.get(url,{},function(data){handleTreeVersion1(getvalue,data,editorId);});

    $.get(url,{},function(data){
    
      isLatest = data;

      //alert (isLatest);

      if(isLatest==0)
      {
        jAlert ('New Idea can not be created because new version of the tree has been created.','Alert');

        return false;
      }

      else
      { 
        var getvalue = "";

        user_data='tagLinks='+document.getElementById("tagLinks").value+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=add&curLeafOrder="+leafOrder+"&treeId="+document.getElementById("treeId").value+"&curNodeId="+document.getElementById("curNodeId").value+"&curLeaf="+leafId+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue);

        $('#image').show();

        var request = $.ajax({

        url: baseUrl+"edit_leaf_save/index/doc/exit/paste",

        type: "POST",

        data: 'user_data='+user_data,

        dataType: "html",

        async:false,

        success:function(result)
           { 
            if(result){

              document.getElementById('datacontainer').innerHTML=result;

              flag = true;

            }
            else
            {
              document.getElementById('docErrorMsg').innerHTML="error";
            }
            editorCheck();
           }

        });

        

      }
    });

    return flag;

  } 
  else
  {
    clearLeafData();
    return false;
  }
  
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function newLeafMoveOrder(leafId,treeId,leafOrder) 
{
  var r=confirm("Do you really want to move this content?")
  if (r==true)
  {
    user_data='leafId='+leafId+"&treeId="+treeId+"&leafOrder="+leafOrder;

    var request = $.ajax({

    url: baseUrl+"edit_leaf_save/newLeafMoveOrder",

    type: "POST",

    data: user_data,

    dataType: "html",

    async:false,

    success:function(result)
        { 
        if(result){
          if(result=='same_order')
          {
            jAlert("Can't move","Alert");
            
          }else{
            location.reload();
          }          
        }
        else
        {
          document.getElementById('docErrorMsg').innerHTML="error";
        }
        }
    });

    return true;

  }
  else
  {
    clearLeafData();
    return false;
  }
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function clearLeafData()
{
  var request = $.ajax({

    url: baseUrl+'edit_leaf_save/clearLeafData',

    type: "GET",

    data: '',

    dataType: "html",

    success:function(result)
    { 
      return false;
    }

  });
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function deleteLeaf(leafId, workSpaceId, workSpaceType, treeId, treeType)
{
  /*Added by Dashrath- add for set parameter default value*/
  if(treeType === undefined) {
      treeType = 'document';
  }
  /*Dashrath- code end*/

  if(treeType==='post' || treeType==='post_comment')
  {
    var r=confirm("Do you really want to delete this post?");
  }
  else if(treeType==='task_sub_task')
  {
    var r=confirm("Do you really want to delete this task list? All sub-tasks in this list will also get deleted. This action is irreversible.");
  }
  else if(treeType==='task')
  {
    var r=confirm("Do you really want to delete this task?");
  }
  else if(treeType==='sub_task')
  {
    var r=confirm("Do you really want to delete this sub-task?");
  }
  else
  {
    var r=confirm("Do you really want to delete this content?");
  }
  
  if (r==true)
  {
    //make url according treeType
    if(treeType==='document')
    {
      url = baseUrl+"edit_leaf_save/deleteLeaf";
    }
    else if(treeType==='discuss')
    {
      url = baseUrl+"view_chat/deleteLeaf";
    }
    else if(treeType==='contact')
    {
      url = baseUrl+"contact/deleteLeaf";
    }
    else if(treeType==='task' || treeType==='task_sub_task' || treeType==='sub_task')
    {
      if(treeType==='task_sub_task')
      {
        treeType = 'task';
      }

      url = baseUrl+"view_task/deleteLeaf";
    }
    else if(treeType==='post' || treeType==='post_comment')
    {
      url = baseUrl+"post/deleteLeaf";
    }
    else{
      jAlert("Something went wrong.","Alert");
      location.reload();
    }

    user_data='leafId='+leafId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&treeId="+treeId+"&taskType="+treeType;

    var request = $.ajax({

      url: url,

      type: "POST",

      data: user_data,

      dataType: "html",

      async:false,

      success:function(result)
         { 
          if(result){
            if(result == 'lock'){
              jAlert("Currently this leaf is locked. Try again afer some time.","Alert");
            }else{
              if(treeType=='post_comment')
              {
                document.getElementById('deleteLeafIcon'+leafId).style.display = "none";
                document.getElementById('delete_content_hide_'+leafId).style.display = "none"; 
                document.getElementById('delete_content_show_'+leafId).style.display = "inline";
              }
              else
              {
                location.reload();
              }
               
            }
          }
          else
          {
            document.getElementById('docErrorMsg').innerHTML="error";
          }
         }

      });

      return true;
  }
  else
  {
    return false;
  }  
} 
/* Dashrath : code end */

/* Added by Dashrath : code start */
function newLeafCopy(leafId) 
{
    var request = $.ajax({

      url: baseUrl+"edit_leaf_save/copyLeaf/"+leafId,

      type: "GET",

      dataType: "html",

      async:false,

      success:function(result)
         { 
          if(result){
            jAlert("Copied!","Alert");
          }
          else
          {
            document.getElementById('docErrorMsg').innerHTML="error";
          }
         }

      });

      return true;
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function newLeafMove(leafId, treeId) 
{
  /*Added by Dashrath- add for set parameter default value*/
  if(treeId === undefined) {
      treeId = 0;
  }
  /*Dashrath- code end*/

    var request = $.ajax({

      url: baseUrl+"edit_leaf_save/moveLeaf/"+leafId,

      type: "GET",

      dataType: "html",

      async:false,

      success:function(result)
         { 
          if(result){

            if(localStorage.getItem("leaf_id"))
            {

              if(localStorage.getItem("leaf_id") != leafId && localStorage.getItem("leaf_tree_id") == treeId)
              {
                var id1 = "hideDivIcon"+localStorage.getItem("leaf_id");
                var id2 = "showMoveMessage"+localStorage.getItem("leaf_id");
                document.getElementById(id1).style.display = "inline"; 
                document.getElementById(id2).style.display = "none";
              }
            }
            
            var id1 = "hideDivIcon"+leafId;
            var id2 = "showMoveMessage"+leafId;
            document.getElementById(id1).style.display = "none"; 
            document.getElementById(id2).style.display = "inline";

            localStorage.setItem('leaf_id',leafId);
            localStorage.setItem('leaf_tree_id',treeId);
            
            //jAlert("Select position to move.","Alert");
          }
          else
          {
            document.getElementById('docErrorMsg').innerHTML="error";
          }
         }

      });

      return true;
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function clearLeafMoveData(leafId)
{
  var request = $.ajax({

    url: baseUrl+'edit_leaf_save/clearLeafData',

    type: "GET",

    data: '',

    dataType: "html",

    success:function(result)
    { 
      var id1 = "hideDivIcon"+leafId;
      var id2 = "showMoveMessage"+leafId;
      document.getElementById(id1).style.display = "inline"; 
      document.getElementById(id2).style.display = "none";
    }

  });
}
/* Dashrath : code end */

/* Added by Dashrath : code start */
function createLeafByFolder(treeId, workSpaceId, workSpaceType)
{
  var folderId = document.getElementById('selFolderId').value;
  var position = document.getElementById('selPos').value;
  var orderType    = document.getElementById('selOrder').value;

  if(folderId == "" || folderId == 0)
  {
    document.getElementById('createLeafErrorMessage').innerHTML="Please select folder";
  }
  else
  {

    if(confirm("Are you sure you want to add?"))
    {

      var checkBox=document.getElementById('addCaption');
      //check checkbox for add caption
      if (checkBox.checked == true)
      {
         var addCaption = 1;
      } 
      else 
      {
         var addCaption = 0;
      }
      
      document.getElementById('buttonCreateLeaf').style.display = "none";
      document.getElementById('loaderCreateLeaf').style.display = "inline";
		//alert (orderType); return false;
      user_data="treeId="+treeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&folderId="+folderId+"&position="+position+"&orderType="+orderType+"&addCaption="+addCaption;
      
      var request = $.ajax({

          url: baseUrl+"external_docs/createLeafByFolder",

          type: "POST",

          data: user_data,

          dataType: "html",

          async:false,

          success:function(result)
            { 
				//alert (result);
              if(result){
                window.top.location.href = baseUrl+result; 
              }
              else
              {
                document.getElementById('createLeafErrorMessage').innerHTML="Something went wrong!";
              }
            }
        });

        return true;
    }

  }

}
/* Dashrath : code end */

function activeLeftMenu(idName)
{
}

/* Added by Dashrath : function editContentAutoSave start */
function editContentAutoSave()
{
  var editStatus=$("#editStatus").val();
  var currentLeafMode=$("#draftCurrentLeafMode").val();
  //editor action not running if editEditorActionWithoutAutoSave is 0
  var editEditorActionWithoutAutoSave=$("#editEditorActionWithoutAutoSave").val();

  if(editStatus=='1' && editEditorActionWithoutAutoSave==0)
  {
    var treeId=$("#treeId").val();
    var leafId=$("#draftCurLeafId").val();
    var nodeId=$("#draftCurNodeId").val();
    var leafOrder=$("#draftCurLeafOrder").val();

    var editorId = "editorLeafContents"+leafOrder+"1";
    var getvalue=getvaluefromEditor(editorId);

    var newDraftLeafNodeId=$("#newDraftLeafNodeId").val();

    if (getvalue != '')
    {

      //var oldLeafContent = localStorage.getItem('old_leaf_content');
      var oldLeafContent = $("#editLeafOldContent").val();

      // if(oldLeafContent!='')
      // {
      //   var originalContents = oldLeafContent;
      // }
      // else
      // {
      //   var originalContents = encodeURIComponent(document.getElementById('initialleafcontent'+leafOrder).value).replace(/%0A/g,"");
      // } 
      //var str=encodeURIComponent(getvalue).replace(/%0A/g,"");
       
      if (oldLeafContent!=getvalue)
      {

        document.getElementById('editAutoSaveMethodCalling').value = 1;

        if(currentLeafMode=='draft' || newDraftLeafNodeId>0)
        {
          //localStorage.setItem('old_leaf_content',getvalue);

          if(newDraftLeafNodeId>0)
          {
            data_user = 'curContent='+encodeURIComponent(getvalue)+'&nodeId='+newDraftLeafNodeId+'&updateFrom=edit';
          }
          else
          {
            data_user = 'curContent='+encodeURIComponent(getvalue)+'&nodeId='+nodeId+'&updateFrom=edit';
          }
         

          var request = $.ajax({

            url: baseUrl+"edit_leaf_save/updateDraftLeafDetails",

            type: "POST",

            async: true,

            data: data_user,

            dataType: "html",

            success:function(result){

              document.getElementById('editAutoSaveMethodCalling').value = 0;

              //set old content value
              document.getElementById('editLeafOldContent').value = getvalue;

              if(result)
              {
                //set old content value
                //document.getElementById('editLeafOldContent').value = getvalue;

                $('#displayDraftSaveMessageEdit_'+leafOrder).html('Draft saved');

                setTimeout(function(){
                    $('#displayDraftSaveMessageEdit_'+leafOrder).html('');
                }, 9000);
              }
            }
          });
        }
        else
        {
          var tagLinks=$("#tagLinks").val();

          var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+leafOrder+"&treeId="+treeId+"&curNodeId="+nodeId+"&curLeaf="+leafId+"&curFocus=0&editStatus=1&curContent="+encodeURIComponent(getvalue)+"&leafPostStatus=draft&editFrom=autosave&contentAutoSave=1";

          var request = $.ajax({

            url: baseUrl+"edit_leaf_save/index/doc/exit",

            async: true,

            type: "POST",

            data: 'user_data='+user_data,

            dataType: "html",

            success:function(result){

              document.getElementById('editAutoSaveMethodCalling').value = 0;

              //set old content
              document.getElementById('editLeafOldContent').value = getvalue;
              if(result > 0)
              {
                //new leaf add in draft mode by edit auto save
                document.getElementById('newDraftLeafNodeId').value = result;

                //set old content
                //document.getElementById('editLeafOldContent').value = getvalue;

                /*Added by Dashrath- used for show hide draft icon in seed header*/
                if(treeId > 0)
                {
                  getDraftLeafDataCount(treeId);
                }
                /*Dashrath- code end*/  

                $('#displayDraftSaveMessageEdit_'+leafOrder).html('Draft saved');

                setTimeout(function(){
                    $('#displayDraftSaveMessageEdit_'+leafOrder).html('');
                }, 9000);

              }
            }
          });
        } 
      }
    }
  }
}
/* Dashrath : function editContentAutoSave end */


/* Added by Dashrath : code start */
function documentAddPosition(treeId, workSpaceId, workSpaceType)
{
  var position = document.getElementById('selPos').value;

  if(position == "" || position == 0)
  {
    document.getElementById('documentAddPosErrorMessage').innerHTML="Please select position";
  }
  else
  {

    // if(confirm("Are you sure you want to add?"))
    // {

      document.getElementById('buttonDocumentAddPos').style.display = "none";
      document.getElementById('loaderDocumentAddPos').style.display = "inline";
    
      user_data="treeId="+treeId+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&position="+position;
      
      var request = $.ajax({

          url: baseUrl+"view_document/documentAddPositionSet",

          async: true,

          type: "POST",

          data: user_data,

          dataType: "html",

          async:false,

          success:function(result)
            { 
              document.getElementById('loaderDocumentAddPos').style.display = "none";
              if(result!='error'){
                window.top.location.href = baseUrl+result; 
              }
              else
              {
                document.getElementById('documentAddPosErrorMessage').innerHTML="Something went wrong!";
              }
            }
        });

        return true;
    // }

  }

}
/* Dashrath : code end */

/*Added by Dashrath- get timeline data*/
function getTimelineData(workSpaceId, workSpaceType, treeId, treeType, viewType)
{
  /*Added by Dashrath- add for set parameter default value*/
  if(viewType === undefined) {
      viewType = 1;
  }
  /*Dashrath- code end*/

  $.ajax({
    url: baseUrl+'tree_timeline/index/'+workSpaceId+'/'+workSpaceType+'/'+treeId+'/'+treeType+'/'+viewType,
    type: 'GET',
    async:false,
    success:function(result)
    {
      if(result!='')
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
        
        
        $('#notficationRightSidebar').html(result);

        //set cookie (used 2 for show)
        //setNotificationSideBarCookie(2);

        //set left menu cookie (used 1 for hide)
        setLeftMenuSideBarCookie(1);

        //set seed width when seed fixed on top
        setFixedSeedWidth();
      }
    }
  });
}
/*Dashrath- code end*/

/*Added by Dashrath- leaf content highlight*/
function leafContentHighlight(nodeId, treeType, clickId, contentType, viewType, predecessorId)
{
  if(nodeId>0)
  {
    var previousClickId = document.getElementById("previousClickId").value;
    var previousLeafContentId = document.getElementById("previousLeafContentId").value; 

    if(treeType == 'document')
    {

      if(contentType=='seed')
      {
        var previousContentId = 'divSeed';
        var currentContentId = 'divSeed';

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'seedBackgroundColorNew'; 
        var previousAddClassName = 'seedBackgroundColorNew';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for leaf content highlight remove and add original class
        var oppositeClassAdd = 'treeLeafRowStyle';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'docLeafContent'+previousLeafContentId;
            
      }
      else
      {
        var previousContentId = 'docLeafContent'+previousLeafContentId;
        var currentContentId = 'docLeafContent'+nodeId;

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'treeLeafRowStyle'; 
        var previousAddClassName = 'treeLeafRowStyle';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for seed content highlight remove and add original class
        var oppositeClassAdd = 'seedBackgroundColorNew';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'divSeed';
      }
    }
    else if(treeType == 'discuss')
    {

      if(viewType=='real_time')
      {
        var contentDivId = 'chat_block';
      }
      else
      {
        var contentDivId = 'discussLeafContent';
      }

      if(contentType=='seed')
      {
        var previousContentId = 'divSeed';
        var currentContentId = 'divSeed';

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'seedBackgroundColorNew'; 
        var previousAddClassName = 'seedBackgroundColorNew';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for leaf content highlight remove and add original class
        var oppositeClassAdd = 'treeLeafRowStyle';
        var oppositeClassRemove = 'nodeBgColorSelect';

        var oppositePreviousContentId = contentDivId+previousLeafContentId;
            
      }
      else
      {
        var previousContentId = contentDivId+previousLeafContentId;
        var currentContentId = contentDivId+nodeId;

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'treeLeafRowStyle'; 
        var previousAddClassName = 'treeLeafRowStyle';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for seed content highlight remove and add original class
        var oppositeClassAdd = 'seedBackgroundColorNew';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'divSeed';
      }
    }
    else if(treeType == 'task')
    {

      var previousPredecessorId = document.getElementById("previousPredecessorId").value;
      if(previousPredecessorId>0)
      {
        $('#taskLeafContent'+previousPredecessorId).removeClass('nodeBgColorSelectNew');
      }

      if(predecessorId>0)
      {
        var contentDivId = 'subTaskLeafContent';
        var oppositeContentDivId = 'taskLeafContent'+previousLeafContentId;
        $('#'+oppositeContentDivId).removeClass('nodeBgColorSelectNew');

        $('#taskLeafContent'+predecessorId).addClass('nodeBgColorSelectNew');

        document.getElementById("previousPredecessorId").value = predecessorId; 
      }
      else
      {
        var contentDivId = 'taskLeafContent';
        var oppositeContentDivId = 'subTaskLeafContent'+previousLeafContentId;
        $('#'+oppositeContentDivId).removeClass('nodeBgColorSelectNew');

        document.getElementById("previousPredecessorId").value = 0;
      }

      if(contentType=='seed')
      {
        var previousContentId = 'divSeed';
        var currentContentId = 'divSeed';

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'seedBackgroundColorNew'; 
        var previousAddClassName = 'seedBackgroundColorNew';
        var previousRemoveClassName = 'nodeBgColorSelectNew';

        //used for leaf content highlight remove and add original class
        var oppositeClassAdd = '';
        var oppositeClassRemove = 'nodeBgColorSelectNew';
        var oppositePreviousContentId = contentDivId+previousLeafContentId;
            
      }
      else
      {
        var previousContentId = contentDivId+previousLeafContentId;
        var currentContentId = contentDivId+nodeId;

        var currentAddClassName = 'nodeBgColorSelectNew';
        var currentRemoveClassName = ''; 
        var previousAddClassName = '';
        var previousRemoveClassName = 'nodeBgColorSelectNew';

        //used for seed content highlight remove and add original class
        var oppositeClassAdd = 'seedBackgroundColorNew';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'divSeed';
      }
    }
    else if(treeType == 'contact')
    {

      if(contentType=='seed')
      {
        var previousContentId = 'divSeed';
        var currentContentId = 'divSeed';

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'seedBackgroundColorNew'; 
        var previousAddClassName = 'seedBackgroundColorNew';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for leaf content highlight remove and add original class
        var oppositeClassAdd = 'seedBackgroundColorNew';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'contactLeafContent'+previousLeafContentId;
            
      }
      else
      {
        var previousContentId = 'contactLeafContent'+previousLeafContentId;
        var currentContentId = 'contactLeafContent'+nodeId;

        var currentAddClassName = 'nodeBgColorSelect';
        var currentRemoveClassName = 'seedBackgroundColorNew'; 
        var previousAddClassName = 'seedBackgroundColorNew';
        var previousRemoveClassName = 'nodeBgColorSelect';

        //used for seed content highlight remove and add original class
        var oppositeClassAdd = 'seedBackgroundColorNew';
        var oppositeClassRemove = 'nodeBgColorSelect';
        var oppositePreviousContentId = 'divSeed';
      }
    }

    if(contentType=='seed')
    {
      $('#'+oppositePreviousContentId).addClass(oppositeClassAdd);
      $('#'+oppositePreviousContentId).removeClass(oppositeClassRemove); 
    }
    else
    {
      $('#'+oppositePreviousContentId).addClass(oppositeClassAdd);
      $('#'+oppositePreviousContentId).removeClass(oppositeClassRemove);
    }

    if(previousClickId>0)
    {
      //used for leaf content
      $('#'+previousContentId).addClass(previousAddClassName);
      $('#'+previousContentId).removeClass(previousRemoveClassName);

      //used for timeline content
      $('#timeline_content_'+previousClickId).removeClass('timelineContentDivStyle');
    }

    //used for leaf content
    $('#'+currentContentId).removeClass(currentRemoveClassName);
    $('#'+currentContentId).addClass(currentAddClassName);

    //used for timeline content
    $('#timeline_content_'+clickId).addClass('timelineContentDivStyle');

    document.getElementById("previousClickId").value = clickId;
    document.getElementById("previousLeafContentId").value = nodeId;

    if($(window).scrollTop() > 130 && contentType!='seed')
    {
      $(window).scrollTop($('#'+currentContentId).offset().top - $(window).scrollTop());
    }
      
    document.getElementById(currentContentId).focus();
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- documentTreeFixed class add and remove on seed in window scroll for seed fixed*/
function addAndRemoveClassOnSeed(height)
{
  if (height > 60) {
      $('#divSeed').addClass('documentTreeFixed');

      //set width
      setFixedSeedWidth();
  } else {
      //remove width
      removeFixedSeedWidth();

      $('#divSeed').removeClass('documentTreeFixed');
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- setPostTabBarWidth function start*/
function setPostTabBarWidth()
{
  // var isLeftMenu1 = getCookie('is_left_menu');
  // if(isLeftMenu1=='1')
  // {
  //   var subWidth = '-=375px';
  // }
  // else 
  // {
  //   var subWidth = '-=597px';
  // }
  
  // $('.postTabUIFixed').css('width', screen.width).css('width', subWidth);

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
  }
  else
  {
    //used 2 for show right timeline and notification sidebar
    var isNotificationSidebar = 2;
  }

  if(isLeftMenu1=='1' && isNotificationSidebar=='1')
  {
    //alert('both hide');
    // var subWidth = '-=56px';
    var subWidth = '-=377px';
    $('.postTabUIFixed').css('width', '73%')
  }
  else if(isLeftMenu1=='1' && isNotificationSidebar=='2')
  {
    //alert('left menu hide timeline show');
    var subWidth = '-=748px';
    $('.postTabUIFixed').css('width', screen.width).css('width', subWidth);
  }
  else if(isLeftMenu1!='1' && isNotificationSidebar=='1')
  {
    //alert('timeline menu hide left menu show');
    var subWidth = '-=596px';
    $('.postTabUIFixed').css('width', screen.width).css('width', subWidth);
  }
  else
  {
    //alert('else')
    var subWidth = '-=377px';
    $('.postTabUIFixed').css('width', screen.width).css('width', subWidth);
  }

  //$('.postTabUIFixed').css('width', screen.width).css('width', subWidth);
}
/*Dashrath- code end*/
/*Added by Dashrath- removePostTabBarWidth function start*/
function removePostTabBarWidth()
{
  $('.postTabUIFixed').css('width', '');
}
/*Dashrath- code end*/


/*Added by Dashrath- higlight content*/
document.onreadystatechange = function () {
  if (document.readyState === 'complete') {
    if (window.location.hash) {
      var higlightId = window.location.hash.replace('#', '');

      $('html, body').animate({
        scrollTop: $('#'+higlightId).offset().top - $('#divSeed').height() - 80
      }, 100);
    }
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- higlight content*/
function getLeafDetailsByTreeId(treeId, lastLeafNodeId)
{

  var result1 = 0;
  var request = $.ajax({

    url: baseUrl+'edit_leaf_save/getLeafDetailsByTreeId/'+treeId+'/'+lastLeafNodeId,

    type: "GET",

    data: '',

    dataType: "html",

    async:false,

    success:function(result)
    { 
       result1 = result;
    }
  });

  return result1;
}
/*Dashrath- code end*/


/*Added by Dashrath- getDraftLeafData*/
function getDraftLeafData(treeId)
{
  $.ajax({
    url: baseUrl+'view_document/getDraftLeafsDetail/'+treeId,
    type: 'GET',
    async:false,
    success:function(result)
    {
      if(result!='')
      {
        if(result==0)
        {
          document.getElementById("draftLeafHeaderIcon").style.display = "none";
        }
        else
        {
          document.getElementById("notficationRightSidebar").style.display = "inline";

          /*Update draft link icon*/
          $('#draftLeafUpdateImage').attr('src',baseUrl+'images/draft_icon.png');

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
          
          
          $('#notficationRightSidebar').html(result);

          //set cookie (used 2 for show)
          //setNotificationSideBarCookie(2);

          //set left menu cookie (used 1 for hide)
          setLeftMenuSideBarCookie(1);

          //set seed width when seed fixed on top
          setFixedSeedWidth();
        }
      }
    }
  });
}
/*Dashrath- code end*/

/*Added by Dashrath- draft leaf content highlight*/
function draftLeafContentHighlight(nodeId, clickId)
{
  if(nodeId>0)
  {
    var previousClickId = document.getElementById("previousClickId").value;
    var previousLeafContentId = document.getElementById("previousLeafContentId").value; 

    if(previousClickId != clickId)
    {
      //used for leaf content
      $('#docLeafContent'+nodeId).removeClass('treeLeafRowStyle');
      $('#docLeafContent'+nodeId).addClass('nodeBgColorSelect');
      
      if(previousClickId>0)
      {
        //used for leaf content
        $('#docLeafContent'+previousLeafContentId).addClass('treeLeafRowStyle');
        $('#docLeafContent'+previousLeafContentId).removeClass('nodeBgColorSelect');

        //used for timeline content
        $('#draft_leaf_content_'+previousClickId).removeClass('timelineContentDivStyle');
      }
     
      //used for timeline content
      $('#draft_leaf_content_'+clickId).addClass('timelineContentDivStyle');

      document.getElementById("previousClickId").value = clickId;
      document.getElementById("previousLeafContentId").value = nodeId;

      if($(window).scrollTop() > 130)
      {
        $(window).scrollTop($('#docLeafContent'+nodeId).offset().top - $(window).scrollTop());
      }
        
      document.getElementById('docLeafContent'+nodeId).focus();
    }
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- add content auto save*/
function addContentAutoSave()
{
  var editStatus=$("#editStatus").val();
  
  if(editStatus=='1')
  {
    //get tree id
    var treeId = $("#treeId").val();
    //get old content value
    var addDraftLeafOldContent  = $("#addDraftLeafOldContent").val();
    //get node id 
    var addDraftLeafNodeId  = $("#addDraftLeafNodeId").val();
    //get editor id
    var openEditorId  = $("#openEditorId").val();
    //get leaf id when new leaf save
    var addDraftLeafId  = $("#addDraftLeafId").val();
    //get node order when new leaf save
    var addDraftNodeOrder  = $("#addDraftNodeOrder").val();
    //get leaf save type
    var addDraftLeafSaveType  = $("#addDraftLeafSaveType").val();
    //default leafStatus
    var leafStatus = 'draft';

    if(addDraftLeafSaveType=='new_leaf_save')
    {
      var leafOrder = addDraftNodeOrder;
      var leafId = addDraftLeafId;
    }
    else
    {
      var leafOrder = 0;
    }
    
    var getvalue=getvaluefromEditor(openEditorId);

    if(getvalue != '')
    {
      if(addDraftLeafOldContent!=getvalue)
      {
        //set old content value
        document.getElementById('addDraftLeafOldContent').value = getvalue;

        if(addDraftLeafNodeId > 0)
        {
          //update first added leaf
          updateDraftLeafContent(addDraftLeafNodeId, getvalue,addDraftNodeOrder);
        }
        else
        {
          if($("#editorActionWithoutAutoSave").val()==0)
          {
            if(addDraftLeafSaveType=='new_leaf_save')
            {
              //leaf add first time
              newLeafSave(leafId, treeId,leafOrder,leafStatus, 'autosave')
            }
            else
            {
              //leaf add first time
              firstLeafSaveNew(treeId, leafOrder, leafStatus, 'autosave');
            }
          }
        }
      }
      
    }
  }

}
/*Dashrath- code end*/

/*Added by Dashrath- update draft content*/
function updateDraftLeafContent(nodeId, getvalue, addDraftNodeOrder)
{
  data_user = 'curContent='+encodeURIComponent(getvalue)+'&nodeId='+nodeId+'&updateFrom=add'; 
    var request = $.ajax({

    url: baseUrl+"edit_leaf_save/updateDraftLeafDetails",

    async: true,

    type: "POST",

    data: data_user,

    dataType: "html",

    success:function(result){
      if(result)
      {
        $('#displayDraftSaveMessage_'+addDraftNodeOrder).html('Draft saved');

        setTimeout(function(){
            $('#displayDraftSaveMessage_'+addDraftNodeOrder).html('');
        }, 9000);
      }
    }
  });
}
/*Dashrath- code end*/

/*Added by Dashrath- draft leaf discard*/
function updateDraftLeafStatus(nodeId, treeId)
{
  var request = $.ajax({

    url: baseUrl+"edit_leaf_save/updateDraftLeafStatus/"+nodeId,

    async: true,

    type: "GET",

    dataType: "html",

    success:function(result){
      document.getElementById('openEditorId').value = '';
      document.getElementById('addDraftLeafNodeId').value = 0;
      document.getElementById('addDraftLeafOldContent').value = "";
      document.getElementById('addDraftLeafSaveType').value = '';
      document.getElementById('addDraftLeafId').value = 0;
      document.getElementById('addDraftNodeOrder').value = 0;

      /*Added by Dashrath- used for show hide draft icon in seed header*/
      if(treeId > 0)
      {
        getDraftLeafDataCount(treeId);
      }
      /*Dashrath- code end*/
    }
  });
}
/*Dashrath- code end*/

/* Added by Dashrath : code start */
function autoNumberingUpdate(treeId)
{
  var checkBox=document.getElementById('autonumbering');

  //check checkbox for add caption
  if (checkBox.checked == true)
  {
     var autonumbering = 1;
  } 
  else 
  {
     var autonumbering = 0;
  }

  user_data="treeId="+treeId+"&autonumbering="+autonumbering;
  
  var request = $.ajax({

    url: baseUrl+"view_document/autoNumberingUpdateByAjax",

    type: "POST",

    data: user_data,

    dataType: "html",

    async:false,

    success:function(result)
    { 
      window.parent.location.reload();
    }
  });
}
/* Dashrath : code end */

/*Added by Dashrath- add and remove class for solution of higlight both tree and leaf issue*/
$(document).ready(function(){
  var urlParams = new URLSearchParams(window.location.search);
  var nodeId = urlParams.get('node');

  if(nodeId > 0)
  {
    var pathArray = window.location.pathname.split( '/' );

    if(pathArray[2] == 'view_document')
    {
      var removeClassName = 'nodeBgColorSelect';
      var addClassName = 'treeLeafRowStyle';
      var leafContentId = 'docLeafContent';
    }
    else if(pathArray[2] == 'view_chat')
    {
      var removeClassName = 'nodeBgColorSelect';
      var addClassName = 'treeLeafRowStyle1';
      var leafContentId = 'discussLeafContentNew';
    }
    else if(pathArray[2] == 'view_task')
    {
      var removeClassName = 'nodeBgColorSelect';
      var addClassName = 'seedBackgroundColorNew';
      var leafContentId = 'taskLeafContentNew';
    }
    else if(pathArray[2] == 'contact')
    {
      var removeClassName = 'seedBackgroundColorNewForSel';
      var addClassName = 'seedBackgroundColorNew';
      var leafContentId = 'contactLeafContent';
    }
    else
    {
      //document details default if any not found
      var removeClassName = 'nodeBgColorSelect';
      var addClassName = 'treeLeafRowStyle';
      var leafContentId = 'docLeafContent';
    }

    if (window.location.hash) {

      if(pathArray[2] == 'contact')
      {
        if($('#contact_first_last_name').hasClass('nodeBgColorSelect1'))
        {
          $('#contact_first_last_name').removeClass('nodeBgColorSelect1');
        }
        if($('#normalView0_old').hasClass('nodeBgColorSelect1'))
        {
          $('#normalView0_old').removeClass('nodeBgColorSelect1');
        }
        if($('#contactDetails').hasClass('nodeBgColorSelect1'))
        {
          $('#contactDetails').removeClass('nodeBgColorSelect1');
        }
        if($('#contactDetailsEdit').hasClass('nodeBgColorSelect1'))
        {
          $('#contactDetailsEdit').removeClass('nodeBgColorSelect1');
        }
      }
      else
      {
        if($('#divSeed').hasClass('nodeBgColorSelect'))
        {
          $('#divSeed').removeClass('nodeBgColorSelect');
          $('#divSeed').addClass('seedBackgroundColorNew');
        }
      }
    }
    else
    {
      if($('#'+leafContentId+nodeId).hasClass(removeClassName))
      {
        $('#'+leafContentId+nodeId).removeClass(removeClassName);
        $('#'+leafContentId+nodeId).addClass(addClassName);
      }
    }
  }
  
});
/*Dashrath- code end*/

/*Added by Dashrath- get node details by node id*/
function getNodeDetailsFromNodeId(nodeId)
{
  var result1 = 0;
  var request = $.ajax({

    url: baseUrl+"edit_leaf_save/getNodeDetailsFromNodeId/"+nodeId,

    type: "GET",

    dataType: "html",

    async:false,

    success:function(result){
        result1 = result;
    }
  });

  return result1;
}
/*Dashrath- code end*/

/*Added by Dashrath- discard draft leaf when click cancel button when open editor for edit leaf */
function discardDraftLeafByCancelButton(nodeId) 
{
 
  var nodeDetails = getNodeDetailsFromNodeId(nodeId);

  if(nodeDetails != 0)
  {
    //0 index contain leaf id and 1 index contain leaf order and 2 index contain treeId
    var nodeDetailsArray = nodeDetails.split("|||||");

    var tagLinks=$("#tagLinks").val();

    var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+nodeDetailsArray[1]+"&treeId="+nodeDetailsArray[2]+"&curNodeId="+nodeId+"&curLeaf="+nodeDetailsArray[0]+"&leafPostStatus=discard&discardFrom=cancelButton";
              
    var request = $.ajax({

      url: baseUrl+"edit_leaf_save/discardDraftLeaf/doc/exit",

      async: true,

      type: "POST",

      data: 'user_data='+user_data,

      dataType: "html",

      success:function(result){
          
        }
    });

  }
}
/*Dashrath- code end*/

/*Added by Dashrath- check leaf lock details by leaf id*/
function checkLeafLockDetailsByLeafId(leafId, leafOrder, cNodeId, treeId) 
{
  var editStatus=$("#editStatus").val();

  if(editStatus=='1')
  {
    //if draft leaf created by auto save method
    var newDraftLeafNodeId=$("#newDraftLeafNodeId").val();
    if(newDraftLeafNodeId > 0)
    {
      var leafId = newDraftLeafNodeId;
    }

    var request = $.ajax({

      url: baseUrl+"lock_leaf/checkLeafLockDetailsByLeafId/"+leafId,

      type: "GET",

      dataType: "html",

      async:false,

      success:function(result){
          if(result==1 && $("#editStatus").val()=='1')
          {
            if(newDraftLeafNodeId > 0)
            {
              document.getElementById('newDraftLeafNodeId').value = 0;
            }

            document.getElementById('editleaf'+leafOrder).style.display="none";

            if(document.getElementById('docLeafContent'+cNodeId))
            {
              /*Commented by Dashrath- comment this code because below update all content by getTreeLeafContents method*/
              // document.getElementById('docLeafContent'+cNodeId).style.display="block";

              /*Added by Dashrath- Update all contents*/
              getTreeLeafContents(treeId);
              /*Dashrath- code end*/
            }

            document.getElementById('editStatus').value= 0; 
          }  
      }
    });
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- delete lock leaf details from memcache by leaf id*/
function deleteLeafLockDetailsFromMemcache(leafId)
{
  var request = $.ajax({

    url: baseUrl+"lock_leaf/deleteLeafLockDetailsFromMemcache/"+leafId,

    type: "GET",

    dataType: "html",

    async:false,

    success:function(result){
       
    }
  });
}
/*Dashrath- code end*/


/*Added by Dashrath- discard auto save draft leaf when click discard draft button from add leaf editor*/
function discardAutoSaveDraftLeaf(leafId,treeId,leafOrder,leafStatus) 
{
  msg= "Are you sure you want to discard this draft?";

  var agree = confirm(msg);

  if(agree)
  {
    var addDraftLeafNodeId=$("#addDraftLeafNodeId").val();
    if(addDraftLeafNodeId > 0)
    {
      var nodeDetails = getNodeDetailsFromNodeId(addDraftLeafNodeId);

      if(nodeDetails != 0)
      {
        //get editor id
        //var openEditorId  = $("#openEditorId").val();
        if(leafId==0)
        {
          editorClose("editorLeafContentsAddFirst1");
          document.getElementById('leafAddFirst').style.display="none"; 
        }
        else
        {
          var INSTANCE_NAME = $("#editorLeafContentsAdd"+leafOrder+"1").attr('name');
          editorClose(INSTANCE_NAME);
          document.getElementById('addleaf'+leafOrder).style.display="none";
        }
        
        document.getElementById('editStatus').value = 0; 
        document.getElementById('editorActionWithoutAutoSave').value = 0;
        document.getElementById('autoSaveMethodCalling').value = 0;

        //0 index contain leaf id and 1 index contain leaf order and 2 index contain treeId
        var nodeDetailsArray = nodeDetails.split("|||||");

        var tagLinks=$("#tagLinks").val();

        var user_data='tagLinks='+tagLinks+"&workSpaceId="+workSpaceId+"&workSpaceType="+workSpaceType+"&curOption=edit&curLeafOrder="+nodeDetailsArray[1]+"&treeId="+nodeDetailsArray[2]+"&curNodeId="+addDraftLeafNodeId+"&curLeaf="+nodeDetailsArray[0]+"&leafPostStatus=discard&discardFrom=autoSaveDiscardButton";
                  
        var request = $.ajax({

          url: baseUrl+"edit_leaf_save/discardDraftLeaf/doc/exit",

          type: "POST",

          data: 'user_data='+user_data,

          dataType: "html",

          success:function(result){
              document.getElementById('openEditorId').value = '';
              document.getElementById('addDraftLeafNodeId').value = 0;
              document.getElementById('addDraftLeafOldContent').value = "";
              document.getElementById('addDraftLeafSaveType').value = '';
              document.getElementById('addDraftLeafId').value = 0;
              document.getElementById('addDraftNodeOrder').value = 0;
              $("#datacontainer").html(result);

              /*Added by Dashrath- used for show hide draft icon in seed header*/
              if(treeId > 0)
              {
                getDraftLeafDataCount(treeId);
              }
              /*Dashrath- code end*/
            }
        });

      }
    }
  }
  else
  {
    return false ;
  }
}
/*Dashrath- code end*/

/*Added by Dashrath- check leaf lock details by leaf id*/
function checkDraftLeafLockDetailsByLeafId(leafId, leafOrder) 
{
  var editStatus=$("#editStatus").val();
  var addDraftLeafNodeId=$("#addDraftLeafNodeId").val();

  if(editStatus=='1' && addDraftLeafNodeId > 0)
  {
    //if draft leaf created by auto save method
    var request = $.ajax({

      url: baseUrl+"lock_leaf/checkLeafLockDetailsByLeafId/"+addDraftLeafNodeId,

      type: "GET",

      dataType: "html",

      async:false,

      success:function(result){
          if(result==1 && $("#editStatus").val()=='1')
          {
            if(leafId==0)
            {
              editorClose("editorLeafContentsAddFirst1");
              document.getElementById('leafAddFirst').style.display="none"; 
            }
            else
            {
              var INSTANCE_NAME = $("#editorLeafContentsAdd"+leafOrder+"1").attr('name');
              editorClose(INSTANCE_NAME);
              document.getElementById('addleaf'+leafOrder).style.display="none";
            }
            document.getElementById('addDraftLeafNodeId').value = 0;
            document.getElementById('editStatus').value= 0; 
          }  
      }
    });
  }
}
/*Dashrath- checkDraftLeafLockDetailsByLeafId function end*/

/*Added by Dashrath- get tree leaf contents*/
function getTreeLeafContents(treeId)
{
    //if draft leaf created by auto save method
    var request = $.ajax({

      url: baseUrl+"edit_leaf_save/getTreeLeafContents/"+workSpaceId+"/"+workSpaceType+"/"+treeId,

      type: "GET",

      dataType: "html",

      //async:false,

      success:function(result){
          if(result != '')
          {
            $("#datacontainer").html(result);
          }  
      }
    });
}
/*Dashrath- getTreeLeafContents function end*/

/*Added by Dashrath- getDraftLeafData*/
function getDraftLeafDataCount(treeId)
{
  $.ajax({
    url: baseUrl+'view_document/getDraftLeafDataCount/'+treeId,
    type: 'GET',
    async:false,
    success:function(result)
    {
      if(result==0)
      {
        document.getElementById("draftLeafHeaderIcon").style.display = "none";
      }
      else
      {
        document.getElementById("draftLeafHeaderIcon").style.display = "block";
      }
    }
  });
}
/*Dashrath- code end*/

/*Added by Dashrath- updateDraftIcon function used for update draft icon in seed header*/
function updateDraftIcon(treeId)
{
  document.getElementById("draftLeafHeaderIcon").style.display = "inline";
  $('#draftLeafUpdateImage').attr('src',baseUrl+'images/draft_icon_green.png');
}
/*Dashrath- code end*/

/*Added by Dashrath- updateDraftIcon function used for update draft icon in seed header*/
function updateShareIcon(treeId)
{
  $('#shareUpdateImage').attr('src',baseUrl+'images/share_icon_16_16_green.png');
}
/*Dashrath- code end*/

/*Added by Dashrath- audioContentHideShow function used for hide show audio content*/
function audioContentHideShow(nodeId)
{
  $("#audio_contents"+nodeId).toggle();
}
/*Dashrath- code end*/