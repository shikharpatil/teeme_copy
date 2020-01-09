<?php
class Mailcheck extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function mailtest()
	{
			//echo $now.'==='; exit;
	
			$to = 'testtask52@gmail.com'; // note the comma
			
			// Subject
			$subject = 'Birthday Reminders for August';
			
			// Message
			$message = '
			<!DOCTYPE html>
			<head>
              <meta charset="UTF-8">
			  <title>Birthday Reminders for August</title>
			</head>
			<body>
			  <p>Here are the birthdays upcoming in August!</p>
			  <table>
				<tr>
				  <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
				</tr>
				<tr>
				  <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
				</tr>
				<tr>
				  <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
				</tr>
			  </table>
			</body>
			</html>
			';
			
			// Additional headers

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <manoj.patidar@teeme.net>' . "\r\n" . 'Reply-To: <manoj.patidar@teeme.net>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
			
			// Mail it
			var_dump(mail($to, $subject, $message, $headers));
		
	
	
			
			/*$headers = 'From: Birthday Reminder <manoj.patidar@teeme.net>\r\n';
			$headers .= 'Reply-To: Manoj <manoj.patidar@teeme.net>\r\n';
			$headers .= 'Return-Path: Manoj <manoj.patidar@teeme.net>\r\n';	// these two to set reply address
			$headers .= 'Message-ID: <webmaster@'.$_SERVER['SERVER_NAME'].'>\r\n';
			$headers .= 'X-Mailer: PHP v'.phpversion();				
			
			// To send HTML mail, the Content-type header must be set
			$headers .= 'MIME-Version: 1.0\r\n';
			$headers .= 'Content-type: text/html; charset=UTF-8\r\n';*/
	
			//$to 	 = 'manoj.patidar@teambeyondborders.com';
			/*$to 	 = 'manoj.patidar@teeme.net';
			$subject = 'testing';
			$notificationEmailContent = 'test content';
			$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
			echo $emailSentStatus.'====status==='; exit;*/
			
			
			/*ini_set( 'display_errors', 1 );
    		error_reporting( E_ALL );
			
			$from = 'sanjay.singhai@teeme.net';
			
			$to = 'testtask52@gmail.com';
			
			$subject = 'Website Change Request';
			
			$message = '<!DOCTYPE html>
			<head>
              <meta charset="UTF-8">
			  <title>Birthday Reminders for August</title>
			</head>
			<body>
			  <p>Here are the birthdays upcoming in August!</p>
			  <table>
				<tr>
				  <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
				</tr>
				<tr>
				  <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
				</tr>
				<tr>
				  <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
				</tr>
			  </table>
			</body>
			</html>';
			
			$headers = "From: ". $from ."\r\n";
			$headers .= "Reply-To: ". $from ."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			
			var_dump(mail($to,$subject,$message,$headers));*/
			
			/*if (mail($to, $subject, $message, $headers)) {
              echo 'Your message has been sent successfully.';
            } else {
              echo 'There was a problem sending the email.';
            }*/
			//$error = error_get_last();
			//print_r($error);
			
			//$status = mail( $to, $subject, $message, $headers );
			//echo $status.'==success==';
			// Storing submitted values
		
			
				/* $emailConfig = [
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'manojpatidar338@gmail.com',
					'smtp_pass' => '9770779203',
					'mailtype' => 'html',
					'starttls'  => true,
					'charset' => 'iso-8859-1',
					'newline'   => "\r\n"
				];
				// Set your email information
				$from = [
					'email' => 'manoj.patidar@teeme.net',
					'name' => 'manoj'
				];
			  
				$to = array('testtask52@gmail.com');
				$subject = 'tesing message';
			  	$message = 'testtedfsdff';
		
				// Load CodeIgniter Email library
				$this->load->library('email', $emailConfig);
				// Sometimes you have to set the new line character for better result
				$this->email->set_newline("\r\n");
				// Set email preferences
				$this->email->from($from['email'], $from['name']);
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
				// Ready to send email and check whether the email was successfully sent
				if (!$this->email->send()) {
					// Raise error message
					show_error($this->email->print_debugger());
				} else {
					// Show success notification or other things here
					echo 'Success to send email';
				}*/
		
	}
}

?>