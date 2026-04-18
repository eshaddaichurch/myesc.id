<?php

/*
 * FILE: application/views/dashboard/cetakcare_pdf.php
 *
 * Variabel dari controller Dashboardcare::cetak():
 *   $rowInfoGereja     - object (namagereja, alamatgereja, emailgereja)
 *   $rsJemaatBaru      - CI_DB_result
 *   $tglawal           - string Y-m-d
 *   $tglakhir          - string Y-m-d
 *   $totalJemaat       - int
 *   $totalSimpatisan   - int
 *   $totalBaptis       - int
 *   $jemaatBaruPeriode - int
 */

class MYPDF extends TCPDF
{
    public function Header()
    {
        $this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(
            0, 10,
            'Halaman ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
            0, false, 'C', 0, '', 0, false, 'T', 'M'
        );
    }
}

// =========================================================
// BUAT DOKUMEN PDF
// =========================================================
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('ESC App');
$pdf->SetAuthor($rowInfoGereja->namagereja ?? 'ESC');
$pdf->SetTitle('Laporan Dashboard Care');
$pdf->AddPage();

// =========================================================
// HEADER LOGO + INFO GEREJA
// =========================================================
$headerHtml = '
<table cellpadding="5">
    <tbody>
        <tr>
            <td width="12%" style="text-align:center; vertical-align:middle;">
                <img src="' . base_url('images/icon.png') . '" alt="" width="55px">
            </td>
            <td width="88%" style="text-align:left; vertical-align:middle;">
                <span style="font-size:20px; font-weight:bold;">' . htmlspecialchars($rowInfoGereja->namagereja ?? '') . '</span>
                <br><span style="font-size:11px;">' . htmlspecialchars($rowInfoGereja->alamatgereja ?? '') . '</span>
                <br><span style="font-size:11px;">Email: ' . htmlspecialchars($rowInfoGereja->emailgereja ?? '') . '</span>
            </td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($headerHtml, true, false, false, false, '');
$pdf->SetTopMargin(0);

// Garis pemisah
$pdf->SetLineWidth(0.5);
$pdf->Line(PDF_MARGIN_LEFT, $pdf->GetY() + 1, $pdf->getPageWidth() - PDF_MARGIN_RIGHT, $pdf->GetY() + 1);
$pdf->Ln(3);

// =========================================================
// JUDUL
// =========================================================
$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML('<h3 style="text-align:center;">LAPORAN DASHBOARD CARE</h3>', true, false, false, false, '');

// =========================================================
// PERIODE
// =========================================================
if ($tglawal !== $tglakhir) {
    $periodeTeks = tglindonesia($tglawal) . ' s/d ' . tglindonesia($tglakhir);
} else {
    $periodeTeks = tglindonesia($tglawal);
}

// =========================================================
// TABEL SUMMARY
// =========================================================
$summaryHtml = '
<br>
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="35%" style="font-weight:bold;">PERIODE LAPORAN</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="60%">' . $periodeTeks . '</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="35%" style="font-weight:bold;">TOTAL JEMAAT (SELURUH)</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="60%">' . number_format($totalJemaat) . ' Orang</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="35%" style="font-weight:bold;">TOTAL SIMPATISAN</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="60%">' . number_format($totalSimpatisan) . ' Orang</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="35%" style="font-weight:bold;">SUDAH DIBAPTIS</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="60%">' . number_format($totalBaptis) . ' Orang</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="35%" style="font-weight:bold;">JEMAAT BARU PERIODE INI</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="60%">' . number_format($jemaatBaruPeriode) . ' Orang</td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($summaryHtml, true, false, false, false, '');

// =========================================================
// TABEL DATA JEMAAT BARU
// =========================================================
$tabelHtml = '<br><h5 style="font-weight:bold;">DATA JEMAAT BARU PERIODE ' . strtoupper($periodeTeks) . '</h5><br>';
$tabelHtml .= '
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#dddddd;">
            <th width="5%"  style="text-align:center;">No</th>
            <th width="16%" style="text-align:center;">Tgl Bergabung</th>
            <th width="37%" style="text-align:center;">Nama Lengkap</th>
            <th width="8%"  style="text-align:center;">JK</th>
            <th width="9%"  style="text-align:center;">Umur</th>
            <th width="25%" style="text-align:center;">Nama DC</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($rsJemaatBaru->num_rows() > 0) {
    foreach ($rsJemaatBaru->result() as $row) {
        $jk = ($row->jeniskelamin === 'Laki-laki') ? 'L' : 'P';
        $bgColor = ($no % 2 === 0) ? '#f5f5f5' : '#ffffff';

        $tabelHtml .= '
        <tr style="font-size:11px; background-color:' . $bgColor . ';">
            <td width="5%"  style="text-align:center;">' . $no . '</td>
            <td width="16%" style="text-align:center;">' . tglindonesia($row->tanggalinsert) . '</td>
            <td width="37%" style="text-align:left;">' . htmlspecialchars($row->namalengkap) . '</td>
            <td width="8%"  style="text-align:center;">' . $jk . '</td>
            <td width="9%"  style="text-align:center;">' . ($row->umur ?? '-') . '</td>
            <td width="25%" style="text-align:left;">' . htmlspecialchars($row->namadc ?? '-') . '</td>
        </tr>';
        $no++;
    }
} else {
    $tabelHtml .= '
        <tr>
            <td colspan="6" style="font-size:11px; text-align:center; font-style:italic; padding:8px;">
                Tidak ada data jemaat baru pada periode ini.
            </td>
        </tr>';
}

$tabelHtml .= '</tbody></table>';

// =========================================================
// TANDA TANGAN
// =========================================================
$tglCetak = date('d-m-Y H:i');
$tabelHtml .= '
<br><br>
<table border="0" cellpadding="5">
    <tbody>
        <tr style="font-size:11px;">
            <td width="65%"></td>
            <td width="35%" style="text-align:center;">
                Dicetak pada ' . $tglCetak . '<br><br><br><br>
                (________________________)<br>
                <b>Penanggung Jawab</b>
            </td>
        </tr>
    </tbody>
</table>';

// =========================================================
// OUTPUT PDF
// =========================================================
$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($tabelHtml, true, false, false, false, '');

// 'I' = tampil di browser | 'D' = langsung download
$pdf->Output('Laporan_Care_' . $tglawal . '_sd_' . $tglakhir . '.pdf', 'I');
