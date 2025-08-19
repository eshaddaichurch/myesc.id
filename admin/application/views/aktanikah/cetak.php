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
$pdf->SetTitle('AKTA NIKAH');
$pdf->SetSubject('AKTA NIKAH');
$pdf->SetKeywords('El Shaddai, church');

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
        text-align: center;
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
</style>
';


$html = $css . '<span class="default-text">' . $rsakta->noakta . '</span>';
$pdf->SetXY(50, 92);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="default-text">' . hari($rsakta->tglakta) . ', ' . tglindonesialengkap($rsakta->tglakta) . '</span>';
$pdf->SetXY(67, 105);
$pdf->writeHTML($html, true, false, true, false, '');
$html = $css . '<span class="default-text">' . $rsakta->jenisakta . '</span>';
$pdf->SetXY(100, 119);
$pdf->writeHTML($html, true, false, true, false, '');


$html = $css . '<span class="nama-jemaat">' . $rsakta->namajemaatpria . '</span>';
$pdf->SetXY(0, 139);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->tempatlahirpria . '</span>';
$pdf->SetXY(62, 147);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . tglindonesia($rsakta->tanggallahirpria) . '</span>';
$pdf->SetXY(105, 147);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namaayahpria . '</span>';
$pdf->SetXY(80, 161);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namaibupria . '</span>';
$pdf->SetXY(80, 168);
$pdf->writeHTML($html, true, false, true, false, '');



$html = $css . '<span class="nama-jemaat">' . $rsakta->namajemaatwanita . '</span>';
$pdf->SetXY(0, 182);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->tempatlahirwanita . '</span>';
$pdf->SetXY(62, 190);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . tglindonesia($rsakta->tanggallahirwanita) . '</span>';
$pdf->SetXY(105, 190);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namaayahwanita . '</span>';
$pdf->SetXY(80, 205);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">' . $rsakta->namaibuwanita . '</span>';
$pdf->SetXY(80, 211);
$pdf->writeHTML($html, true, false, true, false, '');


$html = $css . '<span class="default-text">' . $rsakta->dilakukanoleh . '</span>';
$pdf->SetXY(71, 232);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text">Pontianak, ' . tglindonesialengkap($rsakta->tglakta) . '</span>';
$pdf->SetXY(105, 260);
$pdf->writeHTML($html, true, false, true, false, '');

$html = $css . '<span class="default-text text-bold">' . GEMBALAGEREJA . '</span>';
$pdf->SetXY(110, 285);
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Aktanikah.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+