<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><script>
var who_focus=0;
</script>
<?php
$details = array();
?>
<table width="4%" border="0" cellpadding="0" cellspacing="0" class="bg-light-grey2">
	<!--- Editor Menus -->
	<tr>
		<td align="center" valign="top"> 
			<span id="currentMenus" style="display:none;">
				<img src="<?php echo base_url();?>images/bold.jpg" name="Boldcmd"  hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="Boldcmd" onClick="Bold_cmd();" alt="Bold"><img  src="<?php echo base_url();?>images/italic.jpg" name="Italiccmd" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="Italiccmd" onClick="Italic_cmd();" alt="Italic"><br />
				<img  src="<?php echo base_url();?>images/underline.jpg" name="Underlinecmd" hspace="4" height="19" width="23" vspace="3" border="0" class="editorCursor" id="Underlinecmd" onClick="Underline_cmd();" alt="Underline"><img src="<?php echo base_url();?>images/copy.jpg" name="Copycmd"  hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="Copycmd" onClick="Copy_cmd();" alt="Copy"><br />
				<img src="<?php echo base_url();?>images/ref-l.jpg" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="undocmd" onClick="Undo_cmd();" alt="Undo"><img src="<?php echo base_url();?>images/ref-r.jpg" hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="redoccmd" onClick="Redo_cmd();" alt="Redo"><br>
				<img src="<?php echo base_url();?>images/del.jpg" name="Cutcmd"  hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="Cutcmd" onClick="Cut_cmd();" alt="Cut"><img src="<?php echo base_url();?>images/paste.jpg" name="Pastecmd"  hspace="4" vspace="3" height="19" width="23" border="0" class="editorCursor" id="Pastecmd" onClick="Paste_cmd();" alt="Paste"><br />
				<img id="tablecmd" name="tablecmd" onclick="editor_table();" src="<?php echo base_url();?>editor/images/toolbar/table.gif" hspace="4" vspace="3" height="19" width="23" alt="Insert Table"><img id="backcolorcmd" name="backcolorcmd" onclick="editor_bgcolor();" src="<?php echo base_url();?>images/background-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Set Background Color"/>
				<img id="fontcolorcmd" name="fontcolorcmd" onclick="editor_text_color();" src="<?php echo base_url();?>images/text-color.jpg" hspace="4" vspace="3" height="19" width="23" alt="Text Color"><img id="subscriptcmd" name="subscriptcmd" onclick="editor_subscript();" src="<?php echo base_url();?>images/subscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Subscript"/>
				<img id="superscriptcmd" name="superscriptcmd" onclick="editor_superscript();" src="<?php echo base_url();?>images/superscript.jpg" hspace="4" vspace="3" height="19" width="23" alt="Superscript"><img id="strikethroughcmd" name="strikethroughcmd" onclick="editor_strikethrough();" src="<?php echo base_url();?>images/strikethrough.jpg" hspace="4" vspace="3" height="19" width="23" alt="Strikethrough"/>	
				<img id="indentcmd" name="indentcmd" onclick="editor_indent();" src="<?php echo base_url();?>images/indent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Indent"><img id="outdentcmd" name="outdentcmd" onclick="editor_outdent();" src="<?php echo base_url();?>images/outdent.jpg" hspace="4" vspace="3" height="19" width="23" alt="Outdent"/>	
				<img id="olcmd" name="olcmd" onclick="editor_orderlist();" src="<?php echo base_url();?>images/number-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Numbered Bullets"><img id="uolcmd" name="uolcmd" onclick="editor_unorderlist();" src="<?php echo base_url();?>images/round-bullets.jpg" hspace="4" vspace="3" height="19" width="23" alt="Bullets"/>
				<img id="justifyfullcmd" name="justifyfullcmd" onclick="editor_justify();" src="<?php echo base_url();?>images/justifyfull.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify"><img id="justifyleftcmd" name="justifyleftcmd" onclick="editor_justify_left();" src="<?php echo base_url();?>images/justifyleft.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Left"/>	
				<img id="justifycentercmd" name="justifycentercmd" onclick="editor_justify_center();" src="<?php echo base_url();?>images/justifycenter.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Center"><img id="justifyrightcmd" name="justifyrightcmd" onclick="editor_justify_right();" src="<?php echo base_url();?>images/justifyright.jpg" hspace="4" vspace="3" height="19" width="23" alt="Justify Right"/>
				<img id="insertImagecmd" name="insertImagecmd" onclick="editor_insert_image();" src="<?php echo base_url();?>images/insertImage.jpg" hspace="4" vspace="3" height="19" width="23" alt="Insert Image"><img id="WPastecmd" name="WPastecmd" onclick="editor_copy_from_word();" src="<?php echo base_url();?>images/copyfromWord.jpg" hspace="4" vspace="3" height="19" width="23" alt="Copy from Word"/>
								<img id="makeLinkcmd" name="makeLinkcmd" onclick="editor_link();" src="<?php echo base_url();?>images/makeLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Create Link"><img id="unLinkcmd" name="unLinkcmd" onclick="editor_unlink()" src="<?php echo base_url();?>images/unLink.jpg" hspace="4" vspace="3" height="19" width="23" alt="Unlink"/>
				<img id="findtextcmd" name="findtextcmd" onclick="findtextbox(1,'0')" src="<?php echo base_url();?>images/icon-search.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find"><img id="replacetextcmd" name="replacetextcmd" onclick="replacetextbox(1,'0')" src="<?php echo base_url();?>images/icon-replace.jpg" hspace="4" vspace="3" height="19" width="23" alt="Find & Replace"/>		
				<script language="javascript">	
				document.write('<div style="position:absolute; margin-top:-75px; margin-left:-75px; width: 200px;border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="replacetextDiv0"><table><tr><td>'+Search_caption+':</td><td> <input type="text" size="7" name="searchText1" id="searchText10"></td></tr><tr><td>'+Replace_With_caption+': </td><td><input type="text" size="7" name="replaceText" id="replaceText0"></td></tr><tr><td colspan="2"><input type="checkbox" name="sType1" id="sType10" value="1" /> '+Match_Case_caption+'</td></tr><tr><td colspan="2"><input type="checkbox" name="rType1" id="rType10" value="1" /> '+Replace_All_caption+'</td></tr><tr><td colspan="2"><input type="button" value="'+Replace_caption+'"  onclick="gotoReplace(\'0\',document.getElementById(\'searchText10\').value,document.getElementById(\'replaceText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="replacetextbox(0,\'0\');" ></td></tr></table></div>');
				document.write('<div style="position:absolute; margin-top:15px; margin-left:-12px; border:#666666; border:thin; background-color:#CCCCFF; display:none;" id="findtextDiv0">&nbsp;&nbsp;<br> &nbsp;&nbsp;'+Search_caption+': <input type="text" size="7" name="searchText" id="searchText0">&nbsp;&nbsp;<br>&nbsp;&nbsp;<input type="checkbox" name="sType" id="sType0" value="1" /> '+Match_Case_caption+'<br>&nbsp;&nbsp;<input type="button" value="'+Find_caption+'"  onclick="gotoSearch(0,document.getElementById(\'searchText0\').value);" >&nbsp;&nbsp;<input type="button" value="'+Close_caption+'"  onclick="findtextbox(0,0);" >&nbsp;&nbsp;</div>&nbsp;');
				</script>				

				</span>
		</td>
	</tr>
	<!---End Editor Menus -->
	<!--- Other floating Menus -->         
	<tr>
		<td align="left" valign="top"> 
		<span id="saveOption">
		<?php 
		if($this->input->get('doc') == 'new')
		{
		?>
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">	
				<tr>
					<td colspan="2" align="center"><a href="#" onClick="newLeafSave('<?php echo $leafOrder;?>','<?php echo $leafId;?>','<?php echo $treeId;?>','<?php echo $nodeId;?>')"><img src="<?php echo base_url();?>images/btn-save-exit.jpg" width="73" height="16" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><a href="javascript:void(0)" onClick="cancelNewLeaf('<?php echo $leafId;?>','<?php echo $leafOrder;?>','<?php echo 'spanFooterLeaf'.$leafId;?>','<?php echo $treeId;?>','<?php echo $nodeId;?>','<?php echo $whoFocus;?>')"><img src="<?php echo base_url();?>images/btn-cancel.jpg" width="52" height="16" border="0" /></a></td>
				</tr>
			</table>
		<?php
		}
		else
		{
			echo '';
		}
		?>
		</span>	
		<span id="saveId1"></span>		
		</td>
	</tr>
	<!--- End Other floating Menus -->     
</table>
<script>
function Bold_cmd()
{	
	parent.frames[who_focus].gk.editing('Bold');
}
function Italic_cmd()
{
	parent.frames[who_focus].gk.editing('Italic');
}
function Underline_cmd()
{
	parent.frames[who_focus].gk.editing('Underline');
}
function Copy_cmd()
{
	parent.frames[who_focus].gk.editing('Copy');
}
function Undo_cmd()
{
	parent.frames[who_focus].gk.undofunction();
}
function Redo_cmd()
{
	parent.frames[who_focus].gk.redofunction();
}
function Cut_cmd()
{
	parent.frames[who_focus].gk.editing('Cut');
}
function idea_cmd()
{
	parent.frames[who_focus].gk.idea();
}
function Paste_cmd()
{
	parent.frames[who_focus].gk.editing('Paste');
}
function editor_table()
{
	parent.frames[who_focus].gk.tableHandle()
}
function editor_bgcolor()
{
	parent.frames[who_focus].gk.textcolor('backcolor');
}
function editor_text_color()
{
	parent.frames[who_focus].gk.textcolor('forecolor');
}
function editor_subscript()
{
	parent.frames[who_focus].gk.editing('subscript');
}
function editor_superscript()
{
	parent.frames[who_focus].gk.editing('superscript');
}
function editor_strikethrough()
{
	parent.frames[who_focus].gk.editing('strikethrough');
}
function editor_strikethrough()
{
	parent.frames[who_focus].gk.editing('strikethrough');
}
function editor_indent()
{
	parent.frames[who_focus].gk.makeol('indent');
}
function editor_outdent()
{
	parent.frames[who_focus].gk.makeol('outdent');
}
function editor_orderlist()
{
	parent.frames[who_focus].gk.makeol('insertorderedlist');
}
function editor_unorderlist()
{
	parent.frames[who_focus].gk.makeol('insertunorderedlist')
}
function editor_justify()
{
	parent.frames[who_focus].gk.editing('justifyfull');
}
function editor_justify_left()
{
	parent.frames[who_focus].gk.editing('justifyleft');
}
function editor_justify_center()
{
	parent.frames[who_focus].gk.editing('justifycenter')
}
function editor_justify_right()
{
	parent.frames[who_focus].gk.editing('justifyright')
}
function editor_insert_image()
{
	parent.frames[who_focus].gk.insertImage();
}
function editor_copy_from_word()
{
	parent.frames[who_focus].gk.copyfromWord();
}
function editor_link()
{
	parent.frames[who_focus].gk.makeLink();
}	
function editor_unlink()
{
	parent.frames[who_focus].gk.unLink1();
}
</script>
