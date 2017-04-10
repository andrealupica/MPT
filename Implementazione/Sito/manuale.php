<?php
	### pagina per la pagina del manuale
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// per questa pagina è richiesto la libreria fpdf
	require('pdf/fpdf.php');
	// per questa pagina è richiesto la libreria fpdf
	require('fpdi/fpdi.php');
	// start della sessione
	session_start();
	if($_SESSION['email']!="" OR $_SESSION['email']!=null){
		$pdf = new FPDI(); // istanzio il pdf
		$pageCount = $pdf->setSourceFile('../../data/MPT/manuale/manuale.pdf');
		// iterate through all pages
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
		    // import a page
		    $templateId = $pdf->importPage($pageNo);
		    // get the size of the imported page
		    $size = $pdf->getTemplateSize($templateId);
		    // create a page (landscape or portrait depending on the imported page size)
		    if ($size['w'] > $size['h']) {
		        $pdf->AddPage('L', array($size['w'], $size['h']));
		    } else {
		        $pdf->AddPage('P', array($size['w'], $size['h']));
		    }
		    // use the imported page
		    $pdf->useTemplate($templateId);
		}
		// Output the new PDF
		$pdf->Output();
	}
	else{
		include '404.php';
	}
?>
