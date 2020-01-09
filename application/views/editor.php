<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>editor</title>
<?php include_once('editor/editor_js.php');?>
 <script>
 var workPlace_name='<?php echo $_SESSION['workPlaceId'];?>';
 
var workSpace_name='<?php echo $workSpaceId;?>';
var workSpace_user='<?php echo $_SESSION['userId'];?>'; 

 </script>
</head>

<body>
<form name="form1" method="post" action="">
<script> editorTeeme('replyDiscussion', '90%', '90%', 1, '<DIV id=1-span><P>&nbsp;</P></DIV>',1); 
	</script><br />
<input name="submit" type="button" value="Submit" onclick="showval();" /></form>
	
	
 
	 
</body>
</html>
