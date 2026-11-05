<?php

/*
 * Variabel dari Dashboardcare::cetak():
 *   $rowInfoGereja  - object (namagereja, alamatgereja, emailgereja)
 *   $mulai, $akhir  - string Y-m-d
 *   $kategori       - array key kategori (urutan tampil)
 *   $labels         - array key => label kategori
 *   $labelBulan     - array label bulan ('Jan 2026', ...)
 *   $series         - array key => array jumlah per bulan (sejajar $labelBulan)
 *   $summary        - array key => total periode
 *   $komposisi      - array (jemaat, simpatisan, umum) kondisi saat cetak
 *   $errors         - array pesan error query (jika ada)
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

$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('ESC App');
$pdf->SetAuthor($rowInfoGereja->namagereja ?? 'ESC');
$pdf->SetTitle('Laporan Dashboard Care');
$pdf->AddPage();

// =========================================================
// KOP
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

$pdf->SetLineWidth(0.5);
$pdf->Line(PDF_MARGIN_LEFT, $pdf->GetY() + 1, $pdf->getPageWidth() - PDF_MARGIN_RIGHT, $pdf->GetY() + 1);
$pdf->Ln(3);

// =========================================================
// JUDUL + INFO PERIODE
// =========================================================
$periodeTeks = ($mulai !== $akhir)
    ? tglindonesia($mulai) . ' s/d ' . tglindonesia($akhir)
    : tglindonesia($mulai);

$namaKategori = array();
foreach ($kategori as $k) {
    $namaKategori[] = $labels[$k];
}

$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML('<h3 style="text-align:center;">LAPORAN DASHBOARD CARE</h3>', true, false, false, false, '');

$infoHtml = '
<br>
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="25%" style="font-weight:bold;">PERIODE</td>
            <td width="3%"  style="text-align:center;">:</td>
            <td width="72%">' . $periodeTeks . '</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="25%" style="font-weight:bold;">KATEGORI</td>
            <td width="3%"  style="text-align:center;">:</td>
            <td width="72%">' . htmlspecialchars(implode(', ', $namaKategori)) . '</td>
        </tr>
    </tbody>
</table>';
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($infoHtml, true, false, false, false, '');

// =========================================================
// 1. RINGKASAN PER KATEGORI
// =========================================================
$totalSemua = array_sum($summary);

$ringkasanHtml = '<br><h5 style="font-weight:bold;">A. RINGKASAN PER KATEGORI</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#dddddd;">
            <th width="8%"  style="text-align:center;">No</th>
            <th width="52%" style="text-align:center;">Kategori</th>
            <th width="20%" style="text-align:center;">Jumlah</th>
            <th width="20%" style="text-align:center;">Persentase</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($kategori as $k) {
    $pct = $totalSemua > 0 ? round($summary[$k] / $totalSemua * 100, 1) : 0;
    $bg  = ($no % 2 === 0) ? '#f5f5f5' : '#ffffff';
    $ringkasanHtml .= '
        <tr style="font-size:11px; background-color:' . $bg . ';">
            <td width="8%"  style="text-align:center;">' . $no . '</td>
            <td width="52%">' . htmlspecialchars($labels[$k]) . '</td>
            <td width="20%" style="text-align:center;">' . number_format($summary[$k]) . '</td>
            <td width="20%" style="text-align:center;">' . $pct . '%</td>
        </tr>';
    $no++;
}

$ringkasanHtml .= '
        <tr style="font-size:11px; font-weight:bold; background-color:#eeeeee;">
            <td colspan="2" style="text-align:center;">TOTAL</td>
            <td width="20%" style="text-align:center;">' . number_format($totalSemua) . '</td>
            <td width="20%" style="text-align:center;">100%</td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($ringkasanHtml, true, false, false, false, '');

// =========================================================
// 2. KOMPOSISI JEMAAT (kondisi saat cetak)
// =========================================================
$komposisiHtml = '<br><h5 style="font-weight:bold;">B. KOMPOSISI JEMAAT SAAT INI</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#dddddd;">
            <th width="8%"  style="text-align:center;">No</th>
            <th width="62%" style="text-align:center;">Status</th>
            <th width="30%" style="text-align:center;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <tr style="font-size:11px;">
            <td width="8%"  style="text-align:center;">1</td>
            <td width="62%">Jemaat</td>
            <td width="30%" style="text-align:center;">' . number_format($komposisi['jemaat']) . '</td>
        </tr>
        <tr style="font-size:11px; background-color:#f5f5f5;">
            <td width="8%"  style="text-align:center;">2</td>
            <td width="62%">Simpatisan</td>
            <td width="30%" style="text-align:center;">' . number_format($komposisi['simpatisan']) . '</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="8%"  style="text-align:center;">3</td>
            <td width="62%">Umum</td>
            <td width="30%" style="text-align:center;">' . number_format($komposisi['umum']) . '</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($komposisiHtml, true, false, false, false, '');

// =========================================================
// 3. RINCIAN PER BULAN
// =========================================================
$wKolom = count($kategori) > 0 ? round(78 / count($kategori), 2) : 78;

$rincianHtml = '<br><h5 style="font-weight:bold;">C. RINCIAN PER BULAN</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#dddddd;">
            <th width="22%" style="text-align:center;">Bulan</th>';
foreach ($kategori as $k) {
    $rincianHtml .= '<th width="' . $wKolom . '%" style="text-align:center;">' . htmlspecialchars($labels[$k]) . '</th>';
}
$rincianHtml .= '
        </tr>
    </thead>
    <tbody>';

$totalKolom = array();
foreach ($kategori as $k) {
    $totalKolom[$k] = 0;
}

foreach ($labelBulan as $i => $namaBulan) {
    $bg = ($i % 2 === 1) ? '#f5f5f5' : '#ffffff';
    $rincianHtml .= '<tr style="font-size:10px; background-color:' . $bg . ';">
            <td width="22%">' . $namaBulan . '</td>';
    foreach ($kategori as $k) {
        $v = $series[$k][$i];
        $totalKolom[$k] += $v;
        $rincianHtml .= '<td width="' . $wKolom . '%" style="text-align:center;">' . number_format($v) . '</td>';
    }
    $rincianHtml .= '</tr>';
}

$rincianHtml .= '
        <tr style="font-size:10px; font-weight:bold; background-color:#eeeeee;">
            <td width="22%" style="text-align:center;">TOTAL</td>';
foreach ($kategori as $k) {
    $rincianHtml .= '<td width="' . $wKolom . '%" style="text-align:center;">' . number_format($totalKolom[$k]) . '</td>';
}
$rincianHtml .= '
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($rincianHtml, true, false, false, false, '');

// =========================================================
// CATATAN ERROR (jika ada sumber data yang gagal dibaca)
// =========================================================
if (!empty($errors)) {
    $pdf->SetFont('times', 'I', 9);
    $pdf->writeHTML(
        '<br><span style="color:#b00020;">Catatan: sebagian data gagal dibaca dari database. Periksa log sistem.</span>',
        true, false, false, false, ''
    );
}

// =========================================================
// TANDA TANGAN
// =========================================================
$tglCetak = date('d-m-Y H:i');
$ttdHtml = '
<br><br>
<table border="0" cellpadding="5">
    <tbody>
        <tr style="font-size:11px;">
            <td width="60%"></td>
            <td width="40%" style="text-align:center;">
                Dicetak pada ' . $tglCetak . '<br><br><br><br>
                (________________________)<br>
                <b>Penanggung Jawab</b>
            </td>
        </tr>
    </tbody>
</table>';
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($ttdHtml, true, false, false, false, '');

// 'I' = tampil di browser
$pdf->Output('Laporan_Care_' . $mulai . '_sd_' . $akhir . '.pdf', 'I');