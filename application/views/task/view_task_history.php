<?php /*Copyrights  2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Teeme</title>

<?php $this->load->view('common/view_head.php');?>

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

    

   

	<style type="text/css">

	<!--

	.style1 {font-size: 10px}

	.style2 {font-size: 11px}

	.style4 {font-size: 11px; font-weight: bold; }

	-->

	</style>



</head>

<!--Changed by Dashrath- Removed inline style="background-color:#FFFFFF;" from body tag-->
<body>

	<?php	

	$focusId = 2;

	$totalNodes = array();

	

	//$rowColor1='rowColor3';

	//$rowColor2='rowColor4';

	$rowColor1='seedBackgroundColorNew';

	$rowColor2='seedBackgroundColorNew';	

	$i = 1;	

	$compImages 			= array('empty-sqr.jpg', 'quarter-sqr.jpg', 'half-sqr.jpg', 'threefourth-sqr.jpg', 'fill-sqr.jpg');

	if($history)

	{		

	

	?>

	<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">

	<?php			 

		 foreach($history  as $data)

		{					

			$author=$this->task_db_manager->getUserTagNameByUserId($data['userId']);

			$nodeBgColor = ($i % 2) ? $rowColor1 : $rowColor2;

			?>			

      

		

			  

			  

				





  <tr>

    <td id="editcontent<?php echo $i;?>" onClick="showdetail(<?php echo $i;?>);" class=" <?php echo $nodeBgColor;?> handCursor <?php echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>">

	<?php

	



	

	?>

<?php

        

  ?>

       
  		<!--Changed by Dashrath- Remove class="<?php echo $nodeBgColor;?>"  from div -->
         <div>

         	<!--Changed by Dashrath- change margin-top:1.3% to 0.3% in div inline css-->
			<div  style="width:6%; float:left; margin-top:0.3%;"> <p>			

             <img src="<?php echo base_url();?>images/<?php echo $compImages[$data['complitionStatus']];?>"> 

			 </p>

			 </div>

			 <!--Changed by Dashrath- Remove margin-top:1% from div inline css-->
			 <div style="float:left; width:80%;">

			 <?php

			 $tempStr='';

			echo stripslashes($data['contents']);

			echo $author[0]['userTagName'];

			// if($data['starttime'][0]!=0)

			// $tempStr= '<br>'.$this->lang->line('txt_Start_Time').':'.$this->time_manager->getUserTimeFromGMTTime($data['starttime'], $this->config->item('date_format')).', ' ;

			// if($data['endtime'][0]!=0)

			// $tempStr .= $this->lang->line('txt_End_Time').':'.$this->time_manager->getUserTimeFromGMTTime($data['endtime'], $this->config->item('date_format')) ;

			$baseUrl1 = base_url();

			if($data['starttime'][0]!=0)
			{
				$tempStr= '<br>';

				$tempStr .= '<img src="'.$baseUrl1.'images/greennew.png" border="none" />';

				$tempStr .= $this->lang->line('txt_Start_Time').':'.$this->time_manager->getUserTimeFromGMTTime($data['starttime'], $this->config->item('date_format')).', ' ;

			}

			if($data['endtime'][0]!=0)
			{
				$tempStr .= '<img src="'.$baseUrl1.'images/rednew.png" border="none" />';

				$tempStr .= $this->lang->line('txt_End_Time').':'.$this->time_manager->getUserTimeFromGMTTime($data['endtime'], $this->config->item('date_format')) ;
			}

			if($data['assignedTo'])

			$tempStr .="<br/>".$this->lang->line('txt_Assigned_To').": ";

			echo $tempStr;

		    $temp= $data['assignedTo'];

						  
									
						          $temp=explode(',',$temp);

								 // print_r($temp); 

								   foreach($temp as $userId){

								 //  echo $userId;

								   if($userId)

								   {

								   $userInfo=$this->task_db_manager->getUserTagNameByUserId($userId);

								   

								   //print_r($userInfo);

								   $str=$userInfo[0]['userTagName'].", ";

								   }

								   echo trim($str,",");

								   //echo $temp1=implode(",",$userInfo[0]['userTagName']);

								   }

					   

						        

				echo "<br/>".$this->lang->line('modified_date_txt').": ".$this->time_manager->getUserTimeFromGMTTime($data['editTime'], $this->config->item('date_format'));		      

			?>

			</div>

			</div>

	</td>

  </tr>

  <!--Added by Dashrath- Add for task separter ui-->
  <tr>
  	<td class="treeLeafRowStyle2"></td>
  </tr>
  <!--Dashrath- code end-->

















		

		<?php

			$focusId = $focusId+2;

			$i++;

		}

		?>

		</table>

<?php

	}

else

{ 	

?>



<span><?php echo $this->lang->line('no_history_found_for_task'); ?></span>

<?php } ?>

  <?php $this->load->view('common/foot.php');?>  

    	

           

         

    



</body>

</html>
<script>
$(document).ready(function(){
	var artifactId = '';
	var artifactType = '';
	artifactId = '<?php echo $nodeId; ?>';
	artifactType = '2';
	//alert(artifactId+'==='+artifactType);
	setTagAndLinkCount(artifactId,artifactType);
	setTalkCountFromTagLink('<?php echo $leafTreeId; ?>');
	getSimpleColorTag(artifactId,artifactType);
	getUpdatedContents(artifactId,artifactType);
	
});
</script>