<?php

$this->load->view('common/view_head.php');

?>
<script>

var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));

if(ismobile && /mobile/i.test(navigator.userAgent.toLowerCase()))

{

   document.cookie = "ismobile=1";

}

else

{

   document.cookie="ismobile=0";

}

</script>