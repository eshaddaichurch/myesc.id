<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {}
$legalFormat = array(215.9, 355.6);
// create new PDF document
$pdf = new MYPDF('P', 'mm', $legalFormat, true, 'UTF-8', false);

// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Elshaddai Church');
// $pdf->SetTitle('SERTIFIKAT FC1');
// $pdf->SetSubject('SERTIFIKAT FC1');
// $pdf->SetKeywords('elshaddai, churc');

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('El Shaddai Church');
$pdf->SetTitle('Akta Penyerahanan Anak');
$pdf->SetSubject('Akta Penyerahanan Anak');
$pdf->SetKeywords('El Shaddai, Church');


// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(-1);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

$pdf->setPrintHeader(false); // Tambahkan ini setelah inisialisasi

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('pdfacourier', '', 48);

$pdf->SetFont('times', 'B', 14);

// add a page
$pdf->AddPage();

// Print a text
$css = '

<style>
    .tglsertifikat {
        font-size: 35px;
        width: 100%;
        text-align: center;
    }
    .namasertifikat {
        font-size: 40px;
        width: 100%;
        text-align: center;
    }
    .default-text {
        font-size: 16px;
        width: 100%;
    }
    .nama-jemaat {
        font-size: 20px;
        font-weight: bold;
        width: 100%;
    }
    .text-ttd {
        font-size: 16px;
        font-weight: bold;
        width: 32%;
        text-align: center;
    }
    .text-tglttd {
        font-size: 14px;
        width: 50%;
        text-align: center;
    }


    .listmateri {
        font-size: 11px;
        width: 100%;
    }
    .text-bold {
        font-weight: bold;
    }

    .dilakukan-oleh {
        width: 100%;
        text-align: center;
    }
</style>
';


$html = $css . '<span class="default-text">' . $rsakta->noakta . '</span>';
$pdf->SetXY(52, 92);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="default-text">' . hari($rsakta->tglakta) . '</span>';
$pdf->SetXY(79, 130);
$pdf->writeHTML($html, true, false, true, false, '');

// $html = $css . '<span class="default-text">EL Shaddai Pinyuh</span>';
// $pdf->SetXY(81, 145);
// $pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namagereja . '</span>';
$pdf->SetXY(81, 145);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="default-text">' . tglindonesialengkap($rsakta->tglakta) . '</span>';
$pdf->SetXY(119, 130);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="nama-jemaat">' . $rsakta->namajemaatanak . '</span>';
$pdf->SetXY(79, 179);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->tempatlahiranak . ',  ' . tglindonesialengkap($rsakta->tgllahiranak) . '</span>';
$pdf->SetXY(79, 188);
$pdf->writeHTML($html, true, false, true, false, '');


$html = $css . '<span class="default-text">' . $rsakta->namajemaatayah . '</span>';
$pdf->SetXY(79, 196);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namajemaatibu . '</span>';
$pdf->SetXY(79, 203);
$pdf->writeHTML($html, true, false, true, false, '');




$html = $css . '<span class="default-text dilakukan-oleh">' . $rsakta->dilakukanoleh . '</span>';
$pdf->SetXY(0, 227);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">Pontianak, ' . tglindonesialengkap($rsakta->tglakta) . '</span>';
$pdf->SetXY(111, 250);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text text-bold">' . GEMBALAGEREJA . '</span>';
// $html = $css . '<span class="default-text text-bold">' . $rsakta->dilakukanoleh . '</span>';
$pdf->SetXY(120, 278);
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Aktanikah.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+