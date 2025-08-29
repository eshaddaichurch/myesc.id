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
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('El Shaddai Church');
$pdf->SetTitle('Akta Baptis');
$pdf->SetSubject('Akta Baptis');
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
        font-weight: 900;
        text-align: center;
    }
    .namasertifikat {
        font-size: 40px;
        width: 100%;
        text-align: center;
        font-weight: 900;
    }
    .default-text {
        font-size: 14px;
        width: 100%;
        font-weight: 900;
    }
        .nama-jemaat {
        font-size: 18px;
        font-weight: bold;
        width: 100%;
    }

    .listmateri {
        font-size: 11px;
        width: 100%;
    }
</style>
';


$html = $css . '<span class="default-text">' . $rsakta->noakta . '</span>';
$pdf->SetXY(51, 94);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="default-text">' . hari($rsakta->tglbaptis) . ', ' . tglindonesialengkap($rsakta->tglbaptis) . '</span>';
$pdf->SetXY(81, 142);
$pdf->writeHTML($html, true, false, true, false, '');
$html = $css . '<span class="default-text">EL SHADDAI</span>';
$pdf->SetXY(81, 157);
$pdf->writeHTML($html, true, false, true, false, '');


$html = $css . '<span class="nama-jemaat">' . $rsakta->namalengkap . '</span>';
$pdf->SetXY(81, 179);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->tempatlahir . '</span>';
$pdf->SetXY(81, 185);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . tglindonesialengkap($rsakta->tanggallahir) . '</span>';
$pdf->SetXY(130, 188);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namaayah . '</span>';
$pdf->SetXY(81, 192);
$pdf->writeHTML($html, true, false, true, false, '');


$html = $css . '<span class="default-text">' . $rsakta->namaibu . '</span>';
$pdf->SetXY(81, 201);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->dilakukanoleh . '</span>';
$pdf->SetXY(85, 227);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">Pontianak, ' . tglindonesialengkap($rsakta->tglakta) . '</span>';
$pdf->SetXY(112, 254);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . GEMBALAGEREJA . '</span>';
$pdf->SetXY(120, 281);
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('AktaBaptis.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+