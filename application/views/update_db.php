<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

if($this->db->query('ALTER TABLE teeme_sub_work_space ADD status TINYINT( 1 ) NOT NULL DEFAULT \'0\''))	

{

	echo 'success';

}	

else

{

	echo 'failed';

}

?>