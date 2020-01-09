/**

 * COMMON DHTML FUNCTIONS

 * These are handy functions I use all the time.

 *

 * By Seth Banks (webmaster at subimage dot com)

 * http://www.subimage.com/

 *

 * Up to date code can be found at http://www.subimage.com/dhtml/

 *

 * This code is free for you to use anywhere, just keep this comment block.

 */



/**

 * X-browser event handler attachment and detachment

 * TH: Switched first true to false per http://www.onlinetools.org/articles/unobtrusivejavascript/chapter4.html

 *

 * @argument obj - the object to attach event to

 * @argument evType - name of the event - DONT ADD "on", pass only "mouseover", etc

 * @argument fn - function to call

 */

function addEvent(obj, evType, fn){

 if (obj.addEventListener){

    obj.addEventListener(evType, fn, false);

    return true;

 } else if (obj.attachEvent){

    var r = obj.attachEvent("on"+evType, fn);

    return r;

 } else {

    return false;

 }

}

function removeEvent(obj, evType, fn, useCapture){

  if (obj.removeEventListener){

    obj.removeEventListener(evType, fn, useCapture);

    return true;

  } else if (obj.detachEvent){

    var r = obj.detachEvent("on"+evType, fn);

    return r;

  } else {

    jAlert("Handler could not be removed","Alert");

  }

}



/**

 * Code below taken from - http://www.evolt.org/article/document_body_doctype_switching_and_more/17/30655/

 *

 * Modified 4/22/04 to work with Opera/Moz (by webmaster at subimage dot com)

 *

 * Gets the full width/height because it's different for most browsers.

 */

function getViewportHeight() {

	if (window.innerHeight!=window.undefined) return window.innerHeight;

	if (document.compatMode=='CSS1Compat') return document.documentElement.clientHeight;

	if (document.body) return document.body.clientHeight; 



	return window.undefined; 

}

function getViewportWidth() {

	var offset = 17;

	var width = null;

	if (window.innerWidth!=window.undefined) return window.innerWidth; 

	if (document.compatMode=='CSS1Compat') return document.documentElement.clientWidth; 

	if (document.body) return document.body.clientWidth; 

}



/**

 * Gets the real scroll top

 */

function getScrollTop() {

	if (self.pageYOffset) // all except Explorer

	{

		return self.pageYOffset;

	}

	else if (document.documentElement && document.documentElement.scrollTop)

		// Explorer 6 Strict

	{

		return document.documentElement.scrollTop;

	}

	else if (document.body) // all other Explorers

	{

		return document.body.scrollTop;

	}

}

function getScrollLeft() {

	if (self.pageXOffset) // all except Explorer

	{

		return self.pageXOffset;

	}

	else if (document.documentElement && document.documentElement.scrollLeft)

		// Explorer 6 Strict

	{

		return document.documentElement.scrollLeft;

	}

	else if (document.body) // all other Explorers

	{

		return document.body.scrollLeft;

	}

}



function openEditTitleBox(treeId,version)
{

		updateSeedContents(treeId,1);

		/*Added by Surbhi IV for checking version */

		if(document.getElementById('edit_doc').style.display=='none') 
		{ 	

			if(version)
			{

				var request = $.ajax({

				  url: baseUrl+'lock_leaf/checkTreeLatestVersion/'+treeId,

				  type: "POST",

				  //data: 'treeId='+treeId+'&version='+version,

				  data: '',

				  dataType: "html",

				  success:function(result)

				  {

					   if(result>0)

					   {

						    //tinyMCE.execCommand('mceRemoveControl', true, 'documentName');

							//var documentName='documentName';

							//CKEDITOR.instances.documentName.destroy();

			                var request = $.ajax({

			  url: baseUrl+"comman/getTreeNameByTreeId",

			  type: "POST",

			  data: 'treeId='+treeId,

			  dataType: "html",

			  success:function(result){

				

				//CKEDITOR.instances.documentName.destroy();

 				//tinyMCE.execCommand('mceRemoveControl', true, 'documentName');
				

                editor_code(result,'documentName','divEditDoc');

	

			   // chnage_textarea_to_editor('documentName','simple');

			

				//tinyMCE.execCommand('mceFocus',false,'documentName');

				document.getElementById('edit_doc').style.display='block';

				//setValueIntoEditor('documentName',result,'simple');
				document.getElementById('documentName').value=result.trim();

			  							}

			});

					   }

					   else

					   {

					        jAlert("This tree title can not be edited because new version of this tree has been created.","Alert");

							return false;

					   }

				  }

				});

			}

			else

			{/*End of Added by Surbhi IV for checking version*/

			   // var documentName='documentName';

			   // CKEDITOR.instances.documentName.destroy();

			    //tinyMCE.execCommand('mceRemoveControl', true, 'documentName');	
				
			  var request = $.ajax({

			  url: baseUrl+"comman/getTreeNameByTreeId",

			  type: "POST",

			  data: 'treeId='+treeId,

			  dataType: "html",

			  success:function(result){

				

				//CKEDITOR.instances.documentName.destroy();

 				//tinyMCE.execCommand('mceRemoveControl', true, 'documentName');

              editor_code(result,'documentName','divEditDoc');

	

			//chnage_textarea_to_editor('documentName','simple');

			

			//tinyMCE.execCommand('mceFocus',false,'documentName');

			document.getElementById('edit_doc').style.display='block';

			//setValueIntoEditor('documentName',result,'simple');
			document.getElementById('documentName').value=result.trim();

			  							}

			});

			/*Added by Surbhi IV*/

			}

			

		}/*End of Added by Surbhi IV*/

	/*	else

		{ 

			 document.getElementById('edit_doc').style.display='none';

		}*/

		

}



