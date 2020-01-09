<?php

		/*

		if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] !=	"")

		{

		?> 

			<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left; padding-left:10px;">

            	<span class="errorMsg"><?php echo $_SESSION['errorMsg']; $_SESSION['errorMsg'] ='';?></span>

            </div>

		<?php

		}

		*/

		?>

        

        <!-- Task body starts -->

		<?php	

		//echo "<li>count= " .count($arrDiscussions);

		if(count($arrDiscussions) > 0)

		{

			if($_COOKIE['ismobile']){

				require('view_task_body_for_mobile.php');

			}

			else{

				require('view_task_body.php');

			}

		}

		?> 

        <!-- Task body ends -->

		<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">

		<!--Added by Dashrath- used for when close edit task and sub task popup by close icon then lock status is clear in db-->
		<input type="hidden" id="task_sub_task_edit" name="task_sub_task_edit" value="0">
		<!--Dashrath- code end-->

    

  