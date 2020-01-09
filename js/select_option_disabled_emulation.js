/****************************************************************
* Author:	Parv Neema			
* Date:		15 Sep 2010
* Purpose:	Emulate the disabled attributte for the <option> 
*			element in Internet Explorer.
****************************************************************/

window.onload = function() {
	if (document.getElementsByTagName) {
		var s = document.getElementsByTagName("select"); 


		if (s.length > 0) {
			window.select_current = new Array();

			for (var i=0, select; select = s[i]; i++) {
				select.onfocus = function(){ window.select_current[this.id] = this.selectedIndex; }
				select.onchange = function(){ restore(this); if (this.id=='spaceSelect') { goWorkSpace (this); } }
				emulate(select);
			}
		}
	}
}

function restore(e) {
	if (e.options[e.selectedIndex].disabled) {
		e.selectedIndex = window.select_current[e.id];
	}
}

function emulate(e) {

	for (var i=0, option; option = e.options[i]; i++) {
		if (option.disabled) {
			option.style.color = "graytext";
		}
		else {
			option.style.color = "menutext";
		}
	}

}