<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--/*Changed by Surbhi IV*/-->

<title>Notes > New</title>

<!--/*End of Changed by Surbhi IV*/-->

<?php $this->load->view('common/view_head');?>

<?php $this->load->view('editor/editor_js.php');?>

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

    

  

<script>

function showFilteredMembers()

{

	var toMatch = document.getElementById('showMembers').value;

	var val = '';



		//if (toMatch!='')

		if (1)

		{

			<?php

			if ($workSpaceMembers==0 || $workSpaceId==0)

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';

				}

			<?php

			}

			else

			{

			?>

				if (toMatch=='')

				{

					val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>"/><?php echo $this->lang->line('txt_Me');?><br>';

					val +=  '<input type="checkbox" name="notesUsers[]" value="0" checked/><?php echo $this->lang->line('txt_All');?><br>';

				}

			<?php

			}



			foreach($workSpaceMembers as $arrData)	

			{

				if ($arrData['userId'] != $_SESSION['userId'])

				{

			?>

			var str = '<?php echo $arrData['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			



			if (str.match(pattern))

			{

				val +=  '<input type="checkbox" name="notesUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';

				document.getElementById('showMem').innerHTML = val;

			}

        

			<?php

				}

        	}

        	?>



		}

}

</script>

</head>

<body>

<div id="wrap1">

<div id="header-wrap">

<?php $this->load->view('common/header_for_mobile'); ?>

<?php $this->load->view('common/wp_header'); ?>

<?php $this->load->view('common/artifact_tabs_for_mobile', $details); ?>

</div>

</div>

<div id="container_for_mobile">



		<div id="content">

				

				<?php

			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );

			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);	

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

			<form name="form1" method="post" action="<?php echo base_url();?>notes/New_Notes/<?php echo $nodes;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $linkType;?>" onSubmit="return validateNotes(this)">

			  

			  <span class="taskLabel">

						<?php echo $this->lang->line('txt_Title');?>:

                        </span>
						<!--Manoj: added class TextMob and TitleMob-->
                       <span class="taskTextDiv TextMob">

			          <textarea id="name" name="name" class="TitleMob"></textarea>

                      </span>

					<!--Manoj: Commented contributors list start-->
					<?php /*?><span class="taskLabel">

						 <?php echo $this->lang->line('txt_Contributors');?>:

			        </span> 

				<span class="taskTextDiv">&nbsp;</span>

			 <span class="taskLabel">

						 <?php echo $this->lang->line('txt_Search');?>:

                         </span>

                       

                           <span class="taskTextDiv">

			         	<input type="text" id="showMembers" name="showMembers" onkeyup="showFilteredMembers()"/>     </span>

			   <span class="taskLabel">&nbsp;</span>

				 <span class="taskTextDiv" id="showMem">

			            <input type="checkbox" name="notesUsers[]" value="<?php echo $_SESSION['userId'];?>"/> <?php echo $this->lang->line('txt_Me');?><br />

                        <?php

						if ($workSpaceId != 0)

						{

						?>

                        <input type="checkbox" name="notesUsers[]" value="0" checked="checked"/> <?php echo $this->lang->line('txt_All');?><br />

						<?php

						}

						?>

  

                        <?php	

											

						foreach($workSpaceMembers as $arrData)

						{

							if($_SESSION['userId'] != $arrData['userId'])

							{						

						?>

                            <input type="checkbox" name="notesUsers[]" value="<?php echo $arrData['userId'];?>"/> <?php echo $arrData['tagName'];?><br />

					   <?php

					   		}

						}

						?>

                   </span>     

				   <span class="taskLabel">	  

						 <?php echo $this->lang->line('txt_Numbered_Notes');?>:

                         </span>

                          <span class="taskTextDiv">

			         	<input type="checkbox" name="autonumbering"/>  

				</span><?php */?>
				<!--Manoj: Commented contributors list end-->

			  

	                 	<input name="editorname1" type="hidden"  value="replyDiscussion">

                         <span class="taskTextDiv" style="width:80%;">

                        <input name="addnotes" type="submit" value="<?php echo $this->lang->line('txt_Done');?>" class="button01"> 

        <input name="btn_cancel" type="reset" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01"/>&nbsp;</span><div class="clearBoth"></div>

        <input name="reply" type="hidden" id="reply" value="1">

				

			      

      

   



			<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>">  

			<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>">   

			  </form>

        

	</div>

</div>

<?php $this->load->view('common/foot_for_mobile');?>

<?php $this->load->view('common/footer_for_mobile');?>

</body>

</html>

<script>
//Manoj: Added comment to remove editor 
//chnage_textarea_to_editor('name','simple');



// This is a js function used to validate the notes fields

function validateNotes(frm)

{	



 	var name = getvaluefromEditor('name');

	if(name=='')

	{

		jAlert('<?php echo $this->lang->line('enter_title');?>');

		return false;

	}

	

	return true;

}



// This is a js function used to submit the notes form to save

function saveNotes()

{

	var name = getvaluefromEditor('name');

	var frm = document.getElementById('notesFocus').value;	

	var replyDiscussion1	= 'replyDiscussion'+frm+'1';

	if(document.getElementById(replyDiscussion1).value=='')

	{

		jAlert('<?php echo $this->lang->line('enter_note'); ?>');

		return false;

	}

	else

	{

		

		document.forms[frm].submit();

	}

}

</script>