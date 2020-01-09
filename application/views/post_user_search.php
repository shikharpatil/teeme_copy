<?php
var val='';

	

		//if (toMatch!='')

		if (1)

		{

		

		var count = '';

		var sectionChecked = '';

		

		var rowColor1='rowColor2';

		var rowColor2='rowColor1';	

		var rowColor;

		var i = 1;

		//val+='<table cellpadding="0" cellspacing="0" id="divSrchUser">';

		<?php
		
		if ($workSpaceId_search_user == 0)
		{

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{

		  /*if(in_array($arrVal['userId'],$arrayUsers))
		  {*/

		   if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;		

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				val+='<div id="row1" class="'+ rowColor+'"><?php echo "<img src=\' ".base_url()."images/online_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a <?php /*href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>"*/?> class="blue-link-underline" title="<?php echo trim(str_replace(chr(10)," ",$arrVal["statusUpdate"])); ?>" ><?php echo wordwrap($arrVal["tagName"],true);?> </a></div>';

				 i++;

			}

        

		<?php

			

			

        }

		/*}*/
		}

		

		foreach($workSpaceMembers as $keyVal=>$arrVal)

		{
		  /*if(in_array($arrVal['userId'],$arrayUsers))
		  {*/

		   if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )

		   {

		?>  

			rowColor = (i % 2) ? rowColor1 : rowColor2;	

			

			var str = '<?php echo $arrVal['tagName']; ?>';

			

			var pattern = new RegExp('\^'+toMatch, 'gi');

			

			if (str.match(pattern))

			{

				

				

				val+='<div id="row1" class="'+rowColor+'"><?php echo "<img src=\' ".base_url()."images/offline_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a <?php /*href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>"*/?> class="blue-link-underline" title="<?php echo trim(str_replace(chr(10)," ",$arrVal["statusUpdate"])); ?>" ><?php echo wordwrap($arrVal["tagName"],true);?> </a></div>';

						  

				i++;	 

				

			}

		<?php

			

        }

		/*}*/
		}

		}
		else
		{
			foreach($workSpaceMembers as $keyVal=>$arrVal)
			{
	
			  /*if(in_array($arrVal['userId'],$arrayUsers))
			  {*/
	
			   if (in_array($arrVal['userId'],$onlineUsers) && $arrVal['userId']!=$_SESSION['userId'] )
	
			   {
	
			?>  
	
				rowColor = (i % 2) ? rowColor1 : rowColor2;		
	
				
	
				var str = '<?php echo $arrVal['tagName']; ?>';
	
				
	
				var pattern = new RegExp('\^'+toMatch, 'gi');
	
				
	
				if (str.match(pattern))
	
				{
	
					val+='<div id="row1" class="'+ rowColor+'"><?php echo "<img src=\' ".base_url()."images/online_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a <?php /*href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>"*/?> class="blue-link-underline" title="<?php echo trim(str_replace(chr(10)," ",$arrVal["statusUpdate"])); ?>" ><?php echo wordwrap($arrVal["tagName"],true);?> </a></div>';
	
					 i++;
	
				}
	
			
	
			<?php
	
				
	
				
	
			}
	
			/*}*/
			}
	
			
	
			foreach($workSpaceMembers as $keyVal=>$arrVal)
	
			{
			  /*if(in_array($arrVal['userId'],$arrayUsers))
			  {*/
	
			   if ((!(in_array($arrVal['userId'],$onlineUsers))) && $arrVal['userId']!=$_SESSION['userId'] )
	
			   {
	
			?>  
	
				rowColor = (i % 2) ? rowColor1 : rowColor2;	
	
				
	
				var str = '<?php echo $arrVal['tagName']; ?>';
	
				
	
				var pattern = new RegExp('\^'+toMatch, 'gi');
	
				
	
				if (str.match(pattern))
	
				{
	
					
	
					
	
					val+='<div id="row1" class="'+rowColor+'"><?php echo "<img src=\' ".base_url()."images/offline_user.gif \' width=\'15\' height=\'16\' style=\'margin-top:5px\'  />";  ?><a <?php /*href="<?php echo base_url();?>profile/index/<?php echo $arrVal["userId"];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user ; ?>/<?php echo  $workSpaceType_search_user; ?>"*/?> class="blue-link-underline" title="<?php echo trim(str_replace(chr(10)," ",$arrVal["statusUpdate"])); ?>" ><?php echo wordwrap($arrVal["tagName"],true);?> </a></div>';
	
							  
	
					i++;	 
	
					
	
				}
	
			<?php
	
				
	
			}
	
			/*}*/
			}
		}

        ?>