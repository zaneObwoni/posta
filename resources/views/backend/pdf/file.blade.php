<?php
require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');

// initiate FPDI
$pdf = new FPDI();

// get the page count
$pageCount = $pdf->setSourceFile('Laboratory-Report.pdf');
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

    $pdf->SetFont('Helvetica');
    $pdf->SetXY(5, 5);
    $pdf->Write(8, 'A complete document imported with FPDI');
}

// Output the new PDF
$pdf->Output();