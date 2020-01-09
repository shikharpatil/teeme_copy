<?php /*Copyrights ? 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
class Installation extends CI_Controller {
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
		//echo "Begin installation"; exit;

		//$this->load->model('dal/identity_db_manager');
/*		$out = '';
		$data = '';
		$pattern = '$config[\'base_url\']';
		$newValue = 'whatever';

		$fileName = $this->config->item('absolute_path').'application/controllers/config.php'; 
		chmod($fileName,0777) or die("cannot set permission");
		if(file_exists($fileName)) {
			$file = fopen($fileName,'r+') or die("can't open file r");
			
			while(!feof($file)) { 
				$line = fgets($file) or die("can't gets");
				if(strpos($line, $pattern) !== false){
					$out .= $pattern . " = '". $newValue . "';";
				}else{
					$out .= $line;
				}
				
			}
			file_put_contents($fileName, $out) or die ("cannot write");
			fclose($file);
		} */
		
		if($this->input->post('Submit') == $this->lang->line('txt_Create'))
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			
			
			// Fresh instance installation
			$error = '';
			
				if ($this->input->post('server')=='')
				{
					$error = "<div>".$this->lang->line('enter_db_host')."</div>";
				}
				if ($this->input->post('server_username')=='')
				{
					$error .= "<div>".$this->lang->line('enter_db_user_name')."</div>";
				}
				if ($this->input->post('instance_name')=='')
				{
					$error .= "<div>".$this->lang->line('enter_database_name')."</div>";
				}
				//Manoj: Added auto update path url
				/*if ($this->input->post('autoupdate_path')=='')
				{
					$error .= "<div>".$this->lang->line('enter_auto_server_path')."</div>";
				}*/
				//Manoj: code end
				if ($error!='')		
				{
					$_SESSION['errorMsg'] = $error; 															
					redirect('installation', 'location');	
					exit;
				}	
				else
				{
					//Manoj: replace mysql_escape_str function
					$instance_db_name = $this->db->escape_str($this->input->post('instance_name'));
					$server = $this->db->escape_str($this->input->post('server'));
					$server_username = $this->db->escape_str($this->input->post('server_username'));
					$server_password = $this->input->post('server_password');
					$instance_db = $this->config->item('absolute_path')."db".DIRECTORY_SEPARATOR."teeme.sql";
					
					//Manoj: get autoupdate path url
					//$autoupdate_path = $this->input->post('autoupdate_path');
					//Manoj: code end
					
					//echo "now here= " .$instance_db_name; exit;

					$createInstance = $objIdentity->createFreshInstance ($instance_db_name,$server,$server_username,$server_password,$instance_db);
					//echo $createInstance; exit;
					if ($createInstance)
					{
						
						$_SESSION['errorMsg'] = $this->lang->line('instance_created_successfully'); 															
						redirect('installation', 'location');	
						exit;	
					}
				}
				
				
				//Restore instance backup
				if($restorePlace)
				{
					$this->load->model('dal/backup_manager');
					$objBackup	 = $this->backup_manager;
					
					//Extract
					$newdir = $objBackup->extractZip($_FILES['restorePlace']['tmp_name']);
					
					//Restore dbs
					if ($newdir!='failed')
					{
						$currentPath = $this->config->item('absolute_path').'uploads'.DIRECTORY_SEPARATOR.$newdir;
													
						$instancedbfile = glob($currentPath.DIRECTORY_SEPARATOR.'instancedb'.DIRECTORY_SEPARATOR.'*.sql');
						$sqlfilecount = 0;
								foreach ($instancedbfile as $file) {
									$instance_db = $file;
									$sqlfilecount++;
								}
								
						
						$placedbfiles = glob($currentPath.DIRECTORY_SEPARATOR.'placedb'.DIRECTORY_SEPARATOR.'*.sql');
						$sqlfilecount = 0;
								foreach ($placedbfiles as $file) {
									$place_db[] = $file;
									$sqlfilecount++;
								}
						
						$restoredbs = $objIdentity->restoreInstanceDBs ($instance_db,$place_db);
					}
					
					//Copy place documents
					if ($restoredbs)
					{
						
					}			
				}
	
		}

		//Manoj: Check for device
		
				if($_COOKIE[ismobile])
				{
					$this->load->view('common/installation_for_mobile', $arrDetails);
				}
				else
				{
					$this->load->view('common/installation', $arrDetails);
				}				
				
		//Manoj: code end
	}
}
?>