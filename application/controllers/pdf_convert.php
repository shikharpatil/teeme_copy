<?php

class Pdf_convert extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->library('Pdf');
		$this->load->helper("url");		
	}	
	function index()
	{	
	//$datac = $this->load->view('common/pdf_report');
	
	//echo $datac;
	//print_r($_POST['html']);
	$orig = $_POST['html'];
	
	//print_r($orig);
	
	$a = htmlentities($orig);
	
	//print_r($a);
	
	if(!empty($_POST['html']))
	{
		$b = $_POST['html'];
	}
	//print_r($b);
	
	
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
 
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
 
    // set default header data
    
    // set header and footer fonts
    
    // set default monospaced font
   
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }   
 
    // ---------------------------------------------------------    
 
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);   
 
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 8, '', true);   
 
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage(); 
 
    // set text shadow effect
    //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));    
 
    // Set some content to print
	$html = '<style>'.file_get_contents($this->config->item('absolute_path').'css/style_new.css').'</style>';
	$html .= '<style>'.file_get_contents($this->config->item('absolute_path').'css/style1.css').'</style>';
    $html .= <<<EOD
    <div id="container">$b</div>
EOD;
 
    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);   
 
    // ---------------------------------------------------------    
 
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
   $pdf->Output($this->config->item('absolute_path').'workplaces/pdffile/teemeTree.pdf', 'F'); 
   
      
	
/*	if(!empty($_POST['html']))
	{
		$b = $_POST['html'];
	}
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);



// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 6);

// add a page
$pdf->AddPage();

// create columns content
$left_column = '<div id="container">'.$b.'</div>';


// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// get current vertical position
$y = $pdf->getY();

// set color for background
$pdf->SetFillColor(255, 255, 200);

// set color for text
$pdf->SetTextColor(0, 63, 127);

// write the first column
$pdf->writeHTMLCell(200, '', '', $y, $left_column, 1, 0, 1, true, 'J', true);



// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_001.pdf', 'D');*/

//$this->load->view('common/pdf_report');
  
	}
}
?>