<?php

/*
 * Variabel dari Dashboardcare::cetak():
 *   $rowInfoGereja - object (namagereja, alamatgereja, emailgereja)
 *   $mulai, $akhir - string Y-m-d
 *   $kategori      - array key kategori (urutan tampil)
 *   $labels        - key => label
 *   $summary       - key => jumlah data dalam periode
 *   $bulanKeys     - array 'YYYY-MM'
 *   $labelBulan    - 'YYYY-MM' => 'Januari 2026'
 *   $rincian       - 'YYYY-MM' => key => array baris ['tanggal','nama','keterangan']
 *   $errors        - array pesan error query
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
// A. RINGKASAN PER KATEGORI
// =========================================================
$totalSemua = array_sum($summary);

$ringkasanHtml = '<br><h5 style="font-weight:bold;">A. RINGKASAN PER KATEGORI</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#dddddd;">
            <th width="8%"  style="text-align:center;">No</th>
            <th width="72%" style="text-align:center;">Kategori</th>
            <th width="20%" style="text-align:center;">Jumlah</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($kategori as $k) {
    $bg = ($no % 2 === 0) ? '#f5f5f5' : '#ffffff';
    $ringkasanHtml .= '
        <tr style="font-size:11px; background-color:' . $bg . ';">
            <td width="8%"  style="text-align:center;">' . $no . '</td>
            <td width="72%">' . htmlspecialchars($labels[$k]) . '</td>
            <td width="20%" style="text-align:center;">' . number_format($summary[$k]) . '</td>
        </tr>';
    $no++;
}

$ringkasanHtml .= '
        <tr style="font-size:11px; font-weight:bold; background-color:#eeeeee;">
            <td colspan="2" style="text-align:center;">TOTAL</td>
            <td width="20%" style="text-align:center;">' . number_format($totalSemua) . '</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($ringkasanHtml, true, false, false, false, '');

// =========================================================
// B. RINCIAN PER BULAN (dengan nama)
// =========================================================
$pdf->writeHTML('<br><h5 style="font-weight:bold;">B. RINCIAN PER BULAN</h5>', true, false, false, false, '');

$adaData = false;

foreach ($bulanKeys as $ym) {
    // Lewati bulan yang tidak punya data di kategori yang dipilih
    $adaBulan = false;
    foreach ($kategori as $k) {
        if (!empty($rincian[$ym][$k])) {
            $adaBulan = true;
            break;
        }
    }
    if (!$adaBulan) {
        continue;
    }
    $adaData = true;

    $html = '<br><h5 style="font-weight:bold; background-color:#e8eef8;">' . $labelBulan[$ym] . '</h5>';

    foreach ($kategori as $k) {
        $rows = isset($rincian[$ym][$k]) ? $rincian[$ym][$k] : array();
        if (empty($rows)) {
            continue;
        }

        $html .= '<p style="font-size:10px; font-weight:bold;">' . htmlspecialchars($labels[$k])
               . ' (' . count($rows) . ' data)</p>';

        $html .= '
<table border="1" cellpadding="3">
    <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#dddddd;">
            <th width="7%"  style="text-align:center;">No</th>
            <th width="23%" style="text-align:center;">Tanggal</th>
            <th width="45%" style="text-align:center;">Nama</th>
            <th width="25%" style="text-align:center;">Keterangan</th>
        </tr>
    </thead>
    <tbody>';

        $i = 1;
        foreach ($rows as $r) {
            $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
            $html .= '
        <tr style="font-size:10px; background-color:' . $bg . ';">
            <td width="7%"  style="text-align:center;">' . $i . '</td>
            <td width="23%" style="text-align:center;">' . tglindonesia($r['tanggal']) . '</td>
            <td width="45%">' . htmlspecialchars((string) $r['nama']) . '</td>
            <td width="25%">' . htmlspecialchars((string) $r['keterangan']) . '</td>
        </tr>';
            $i++;
        }

        $html .= '</tbody></table><br>';
    }

    $pdf->writeHTML($html, true, false, false, false, '');
}

if (!$adaData) {
    $pdf->writeHTML(
        '<p style="font-size:11px; font-style:italic; text-align:center;">Tidak ada data pada periode ini.</p>',
        true, false, false, false, ''
    );
}

// =========================================================
// CATATAN ERROR
// =========================================================
if (!empty($errors)) {
    $pdf->writeHTML(
        '<br><span style="font-size:9px; color:#b00020;">Catatan: sebagian data gagal dibaca dari database. Periksa log sistem.</span>',
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
$pdf->writeHTML($ttdHtml, true, false, false, false, '');

// 'I' = tampil di browser
$pdf->Output('Laporan_Care_' . $mulai . '_sd_' . $akhir . '.pdf', 'I');