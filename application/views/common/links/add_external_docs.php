<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs);
?>
<form name="form1" method="post" action="<?php echo base_url()?>external_docs/add/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>" enctype="multipart/form-data">
<table width="95%" border="0" cellpadding="0" cellspacing="0">
	 <?php
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")
	{
	?> 
		<tr><td height="18" colspan="2"><span class="errorMsg" style="padding-left:8px;"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span></td>
		
	<?php
	}
	?>
	<?php
	if(isset($_SESSION['successMsg']) && $_SESSION['successMsg'] !=	"")
	{
	?> 
		<tr><td height="18" colspan="2"><span class="successMsg" style="padding-left:8px;"><?php echo $_SESSION['successMsg']; $_SESSION['successMsg'] ='';?></span></td>
		
	<?php
	}
	?>
    
	
  <tr>
    <td width="40%" valign="top"><table width="80%" border="0"  cellpadding="8" cellspacing="0" id="import_file_tables">
    
    <div id="image_msg" style="color:#FF0000;"></div>
    
      <tr>
        <td valign="top"><?php echo $this->lang->line('txt_Select_File');?> </td>
        <td valign="top">
			<input type="file" name="workSpaceDoc[]" multiple>
			<?php /*?><span class="clsLabel"><?php echo $this->lang->line('txt_import_file_ext_hint'); ?></span><?php */?>
			<!-- <span class="clsLabel"><?php echo $this->lang->line('txt_import_file_size_hint'); ?></span> -->
			<!-- <div id="loaderExternalFile" style="display:none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></div> --></td>
      </tr>
      <!--Added by Dashrath : code start -->
      <tr>
      	<td valign="top"><?php echo $this->lang->line('txt_select_folder');?> </td>
      	<td valign="top">
		  <input type="file" webkitdirectory mozdirectory  name="folderFiles[]" onchange="selectFolder(event)" />
		  <!-- <span class="clsLabel"><?php echo $this->lang->line('txt_import_folder_size_hint'); ?></span> -->
		  <input type="hidden" name="hidden_folder_name" id="hidden_folder_name">
		  <div id="loaderExternalFile" style="display:none;"><br><img src="<?php echo base_url();?>images/ajax-loader-add.gif"></div>
		</td>
      </tr>
      <!-- Dashrath : code end -->
      <!-- <tr>
        <td valign="top"><?php echo $this->lang->line('txt_Caption_File');?> </td>
        <td valign="top">
          <input type="text" name="docCaption">
		  &nbsp;
		  <span class="clsLabel"><?php echo $this->lang->line('txt_import_file_hint'); ?></span>
          
          <input type="hidden" id="returnUrl"  name="returnUrl" value="" /> 
									  
        </td>
      </tr> -->
      <?php if($appliedCheckBox==true){ ?>
	<tr><td></td><td>
              <input type="hidden" id="flagCheckBox" name="flagCheckBox" value="<?php echo $appliedCheckBox ?>" />
              <input type="hidden" id="nodeId"  name="nodeId" value="<?php echo $nodeId; ?>" /> 
              <input type="hidden" id="artifactType"  name="artifactType" value="<?php echo $artifactType; ?>" /> 
              <input type="hidden" id="linkType"  name="linkType" value="<?php echo $linkType; ?>" /> 
              <input type="hidden" id="nodeOrder"  name="nodeOrder" value="<?php echo $nodeOrder; ?>" /> 
              <input type="hidden" id="latestVersion"  name="latestVersion" value="<?php echo $latestVersion; ?>" /> 
	       </td></tr>
	<?php } ?>
      <tr>
        <td  align="center" valign="top">&nbsp;</td>
        <td align="left" valign="top">
		
		
        <input type="submit" name="Submit" onclick="showwait();" value="<?php echo $this->lang->line('txt_Done');?>" class="button01">
		<?php if($appliedCheckBox==true){ ?>
        <input type="reset" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01"> 
        <?php }else{ ?>		
        <input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" onClick="javascript:history.go(-1)" class="button01">
      <?php } ?>
	    </td>
      </tr>
    </table></td>
     <td>
     	<table width="100%" border="0"  cellpadding="8" cellspacing="0" id="import_file_tables">
     		<tr>
     			<td>
     				<span class="style2"><?php echo $this->lang->line('txt_import_file_and_folder_size_hint'); ?></span>
     			</td>
     		</tr>
     		<tr>
     			<td>
     				<span class="style2"><?php echo $this->lang->line('txt_import_support_extension'); ?> <?php echo $this->lang->line('txt_import_file_support_hint'); ?></span>
     			</td>
     		</tr>
    	</table>
    </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>  
</table>
</form><script> $('#returnUrl').val(document.referrer);
//$("#loaderExternalFile").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
function showwait()
{
	//alert (baseUrl);
	//$("#loaderExternalFile").html("<div style='margin:15px 0px;'><br><img src='"+baseUrl+"/images/ajax-loader-add.gif'><br></div>");
	$( "#loaderExternalFile" ).show();
}
//Added by Dashrath : code start
function selectFolder(e) {
    var theFiles = e.target.files;
    var relativePath = theFiles[0].webkitRelativePath;
    var folder = relativePath.split("/");
    document.getElementById("hidden_folder_name").value = folder[0];
    //alert(folder[0])
}
//Dashrath : code end
</script>