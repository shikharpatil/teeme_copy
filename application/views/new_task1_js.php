<script>
function cancelTask(url)
{
	//window.location = url;
	location.reload (true);
}
function changeOption(thisVal)
{	
	document.getElementById('curOption').value = thisVal;
	if(thisVal == 1 && document.getElementById('treeStatus').value == 1 && trim(document.getElementById('replyDiscussion').value)=='')
	{
		window.location = baseUrl+'view_task/node_task/'+document.getElementById('nodeId').value+'/'+workSpaceId+'/type/'+workSpaceType;
	}
}

function changeMode(thisVal)
{
	if(thisVal.value == 'Yes')
	{
		document.getElementById('trTaskTitle').style.display = '';
		document.getElementById('butAddMore').style.display = '';
		
	}
	else
	{
		document.getElementById('trTaskTitle').style.display = 'none';
		document.getElementById('butAddMore').style.display = 'none';
		
		
	}
}
function compareDates (dat1, dat2) {

	//alert ('date1= ' +dat1);
	//alert ('date2= ' +dat2);
   var date1, date2;
   var month1, month2;
   var year1, year2;
	 value1 = dat1.substring (0, dat1.indexOf (" "));
	  value2 = dat2.substring (0, dat2.indexOf (" "));
	  time1= dat1.substring (16, dat1.indexOf (" "));
	  time2= dat2.substring (16, dat2.indexOf (" "));
	  
	  hours1= time1.substring (0, time1.indexOf (":"));
	  minites1= time1.substring (1, time1.indexOf (":"));
	  
	  hours2= time2.substring (0, time2.indexOf (":"));
	  minites2= time2.substring (1, time2.indexOf (":"));
	  
   year1 = value1.substring (0, value1.indexOf ("-"));
   month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
   date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);
   
   //alert ('hour1= ' + hours1);
   //alert ('hour2= ' + hours2);

   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
	else if(date1 == date2)
	{
		
		if (hours2 > hours1)
		{
			
			return -1;
		}
		else if(hours2 < hours1)
		{
			return 1;
		}
		else if(hours1 == hours2)
		{
			
			if(minites2 < minites1)
			{
				return 1;
			}	
			else
			{
				return -1;
			}
		}
	}
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
	
   else return 0;
} 

var nodeId='';
function validate_dis(){
	var error='';

	var formname=document.form1;
	//alert ('formstart= ' + formname.startCheck.checked);
	//alert ('formnend= ' + formname.endCheck.value);
	//var title = getvaluefromEditor('title','simple');
	var replyDiscussionValue = getvaluefromEditor('replyDiscussion','simple');
	

/*		if(title=='')
		{			
			error+='Please Enter SubTask Title \n';			
		}*/
		if(replyDiscussionValue=='')
		{			
			error+='Please Enter Task \n';			
		}		

	
	if(formname.starttime.value!='' && formname.endtime.value!='' && formname.startCheck.checked==true && formname.endCheck.checked==true){
		if(compareDates(formname.starttime.value,formname.endtime.value) == 1){
			error+=' Please check start time and end time.';
		}
	}
	if(error==''){
		request_refresh_point=0;
		document.form1.submit();
		//request_send();
	}else{
		alert(error);
		return false;
	}
	
}



function showFilteredMembers()
{
	var toMatch = document.getElementById('showMembers').value;
	var val = '';

		//if (toMatch!='')
		if (1)
		{
			<?php
			if ($workSpaceMembers==0)
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';
				}
			<?php
			}
			else
			{
			?>
				if (toMatch=='')
				{
					val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $_SESSION['userId'];?>" checked/><?php echo $this->lang->line('txt_Me');?><br>';
					val +=  '<input type="checkbox" name="taskUsers[]" value="0"/><?php echo $this->lang->line('txt_All');?><br>';
				}
			<?php
			}
			if ($workSpaceId != 0)
			{
			foreach($workSpaceMembers as $arrData)	
			{
				if ($arrData['userId'] != $_SESSION['userId'])
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
			}
			else
			{
			foreach($workSpaceMembers as $arrData)	
			{
				if ($arrData['userId'] != $_SESSION['userId'] && in_array($arrData['userId'],$sharedMembers))
				{
			?>
			var str = '<?php echo $arrData['tagName']; ?>';
			
			var pattern = new RegExp('\^'+toMatch, 'gi');
			
			

			if (str.match(pattern))
			{
				val +=  '<input type="checkbox" name="taskUsers[]" value="<?php echo $arrData['userId'];?>" <?php if (in_array($arrData['userId'],$contributorsUserId)) { echo 'checked="checked"';}?>/><?php echo $arrData['tagName'];?><br>';
				document.getElementById('showMem').innerHTML = val;
			}
        
			<?php
				}
        	}
			}
        	?>

		}
}
</script>