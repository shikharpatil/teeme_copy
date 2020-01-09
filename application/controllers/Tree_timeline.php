<?php /*Copyright © 2008-2019. Team Beyond Borders Pty Ltd. All rights reserved.*/

class Tree_timeline extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	

	function index(){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objTime	= $this->time_manager;
			$modeId = '1';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(4);
			$currentTreeId = $this->uri->segment(5);

			//get notification data
			$notificationDataArray = $objIdentity->getTreeTimeline($currentTreeId, $workSpaceId, $workSpaceType, 0);

			// echo "hiii";
			// echo "<pre>";
			// print_r($notificationDataArray);die;

			$notificationAllDataArray['workSpaceType'] 	= $workSpaceType;	
			$notificationAllDataArray['workSpaceId'] 		= $workSpaceId;
			$notificationAllDataArray['treeId'] 		= $currentTreeId;

			$notificationAllDataArray['notificationSpaces']	= $this->notification_db_manager->get_user_notification_space($modeId,$_SESSION['userId']);

			/*current date used for check today condition*/
			$currentDate = date("Y-m-d", strtotime($objTime->getGMTTime()));

			/*yesterday date used for check yesterday condition*/
			//$yesterdayDate = date('Y-m-d',strtotime("-1 days"));
			$yesterdayDate = date('Y-m-d', strtotime('-1 day', strtotime($currentDate)));

			
			//this data used in loop
			$notificationContentArray2 = $notificationDataArray;
			$notificationContentArray3 = $notificationDataArray;

			//define oldMonthYear blank 
			$oldMonthYear = '';
			//define oldCreatedDate data
			$oldCreatedDate = '';

			foreach ($notificationDataArray as $key => $notificationDataValue) 
			{
				//define blank array
				$filterNotificationByDate = array();

				//get created date
				$createdDate1 = date("Y-m-d", strtotime($notificationDataValue['create_time']));
				$dateData1 = explode('-',$createdDate1);
				$year1 = $dateData1[0];
				$month1  = $dateData1[1];
				$monthYear1 = $month1.$year1;

				//get month year title
				$monthYearTitle = $this->getMonthYearTitle($month1, $year1);

				if($monthYear1!=$oldMonthYear)
				{
					$oldMonthYear = $monthYear1;

					foreach ($notificationContentArray2 as $notificationDataValue2) 
					{
						$createdDate2 = date("Y-m-d", strtotime($notificationDataValue2['create_time']));


						$dateData2 = explode('-',$createdDate2);
						$year2 = $dateData2[0];
						$month2  = $dateData2[1];
						$monthYear2 = $month2.$year2;

						if($monthYear1==$monthYear2 && $createdDate2!=$oldCreatedDate)
						{
							$oldCreatedDate = $createdDate2;

							$notifiDataArray = array();

							foreach ($notificationContentArray3 as $notificationDataValue3) 
							{
								$createdDate3 = date("Y-m-d", strtotime($notificationDataValue3['create_time']));
								$dateData3 = explode('-',$createdDate3);
								$year3 = $dateData3[0];
								$month3  = $dateData3[1];
								$monthYear3 = $month3.$year3;

								if($monthYear3==$monthYear2 && $createdDate3==$createdDate2)
								{
									$notifiDataArray[] = $notificationDataValue3;

								}
							}

							if($currentDate==$createdDate2)
							{
								$dayData['title'] = 'Today';
								$dayData['notificationData'] = $notifiDataArray;
							}
							else if($yesterdayDate==$createdDate2)
							{
								$dayData['title'] = 'Yesterday';
								$dayData['notificationData'] = $notifiDataArray;
							}
							else
							{
								$dayData['title'] = $createdDate2;

								
								// $dayDataFormat = $this->time_manager->getUserTimeFromGMTTime($createdDate2,$this->config->item('date_format'));

								
								// $dayDataFormatArray = explode(" ", $dayDataFormat);

								// $replaceStringFromDate = $dayDataFormatArray[count($dayDataFormatArray)-1];

								// $dayData['title'] =  str_replace($replaceStringFromDate,"",$dayDataFormat);
								
								// $dayData['title'] = date("jS M y H:i",mktime(0,0,0,$dateData2[2],$dateData2[1],$dateData2[0]));
								// echo 'year='+$dateData2[0].'-'.$dateData2[1].'-'.$dateData2[2];
								// echo '<br/>';

								

								// $createdDate2New = explode(" ",trim($notificationDataValue2['create_time']));

								// if(count($createdDate2New)>1)
								// {
								// 	$createdDate2Replace = str_replace($createdDate2New[1],"00:00:00",$notificationDataValue2['create_time']);

								// 	$dayDataFormat = $this->time_manager->getUserTimeFromGMTTime($createdDate2Replace,$this->config->item('date_format'));

								// 	$dayDataFormatArray = explode(" ", $dayDataFormat);

								// 	$replaceStringFromDate = $dayDataFormatArray[count($dayDataFormatArray)-1];

								// 	$dayData['title'] =  str_replace($replaceStringFromDate,"",$dayDataFormat);
								// }
								// else
								// {
								// 	$dayData['title'] = $createdDate2;
								// }


								$dayData['notificationData'] = $notifiDataArray;
							}

							$filterNotificationByDate[] = $dayData;

						}
					}

					$filterNotificationByMonth['title'] = $monthYearTitle;
					$filterNotificationByMonth['filterNotificationData'] = $filterNotificationByDate;

					$finalNotificationDataArray[] = $filterNotificationByMonth;	
				}
					
			}

			
			$notificationAllDataArray['finalNotificationData'] = $finalNotificationDataArray;

			/*Used for seed*/
			$this->load->model('dal/document_db_manager');
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($currentTreeId);

			$notificationAllDataArray['arrDocumentDetails'] = $arrDocumentDetails;

			//tree type used for check if condition on view
			$notificationAllDataArray['treeType'] = $this->uri->segment(6);

			//view type used for check if condition on view for real time view in discuss tree
			$notificationAllDataArray['viewType'] = $this->uri->segment(7);

			// $this->load->view('document/timeline_document',$notificationAllDataArray);
			$this->load->view('common/timeline_view',$notificationAllDataArray);
			
		}

	}
	//Dashrath : timeline function end

	//Added by Dashrath : getMonthYearTitle function start
	public function getMonthYearTitle($month, $year)
	{
		if($month=='01')
		{
			$monthYearTitle = 'January '.$year;
		}
		elseif($month=='02')
		{
			$monthYearTitle = 'February '.$year;
		}
		elseif($month=='03')
		{
			$monthYearTitle = 'March '.$year;
		}
		elseif($month=='04')
		{
			$monthYearTitle = 'April '.$year;
		}
		elseif($month=='05')
		{
			$monthYearTitle = 'May '.$year;
		}
		elseif($month=='06')
		{
			$monthYearTitle = 'June '.$year;
		}
		elseif($month=='07')
		{
			$monthYearTitle = 'July '.$year;
		}
		elseif($month=='08')
		{
			$monthYearTitle = 'August '.$year;
		}
		elseif($month=='09')
		{
			$monthYearTitle = 'September '.$year;
		}
		elseif($month=='10')
		{
			$monthYearTitle = 'October '.$year;
		}
		elseif($month=='11')
		{
			$monthYearTitle = 'November '.$year;
		}
		elseif($month=='12')
		{
			$monthYearTitle = 'December '.$year;
		}
		
		
		return $monthYearTitle;

	}
	//Dashrath : getMonthYearTitle function end		
}