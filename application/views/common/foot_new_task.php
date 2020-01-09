	<script language="javascript" type="application/javascript" src="<?php echo base_url();?>js/function_tablet.js"></script>
	<script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>
    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>
	
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
	<script language="javascript" src="<?php echo base_url();?>js/document.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/document_js.js"></script>
	<script language="javascript" src="<?php  echo base_url();?>js/identity.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>
	<script language="javascript" src="<?php echo base_url();?>js/task.js"></script>
	
	
	<script language="JavaScript" src="<?php  echo base_url();?>js/pop_menu.js"></script>
	<!--	<script language="JavaScript" src="<?php echo base_url();?>js/mm_menu.js"></script>
	
	<script language="JavaScript1.2">mmLoadMenus();</script>-->
	<!-- scripts for menu --->
	<script type="text/javascript"  src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js"></script>
	<!--/*Changed By surbhi IV*/-->
	<script type="text/javascript" src="<?php echo base_url();?>js/modal-window.min.js"></script>
	<!--/*End of Changed By surbhi IV*/-->
	<script language="javascript"  src="<?php echo base_url();?>js/tabs.js"></script>
	<!-- close here -->

	<!-- for sub modal -->
	<script language="javascript"  src="<?php echo base_url();?>js/common.js"></script>
	<script language="javascript"  src="<?php echo base_url();?>js/subModal.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>jcalendar/calendar.js?random=20060118"></script>
	
	<!-- CSSMenuMaker -->
	<!--<script language="javascript"  src="<?php echo base_url();?>js/cssmenumaker.js"></script>-->
	<!-- CSSMenuMaker -->

	<!--Manoj: code for adding froala js and css files-->
	<?php $this->load->view('common/froala_editor');?>
	<!--Manoj: code end-->

	<?php $this->load->view('common/datepicker_js.php');?>