<?php

/*
 * Variabel dari Dashboarddc::cetak():
 *   $info, $mulai, $akhir, $banding, $bulanKeys, $labelBulan, $rincian,
 *   $jumlahDc, $jumlahMember
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
$pdf->SetAuthor($info->namagereja ?? 'ESC');
$pdf->SetTitle('Laporan Disciples Community');
$pdf->AddPage();

// KOP
$headerHtml = '
<table cellpadding="5">
    <tbody>
        <tr>
            <td width="12%" style="text-align:center; vertical-align:middle;">
                <img src="' . base_url('images/icon.png') . '" alt="" width="55px">
            </td>
            <td width="88%" style="text-align:left; vertical-align:middle;">
                <span style="font-size:20px; font-weight:bold;">' . htmlspecialchars($info->namagereja ?? '') . '</span>
                <br><span style="font-size:11px;">' . htmlspecialchars($info->alamatgereja ?? '') . '</span>
                <br><span style="font-size:11px;">Email: ' . htmlspecialchars($info->emailgereja ?? '') . '</span>
            </td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($headerHtml, true, false, false, false, '');
$pdf->SetLineWidth(0.5);
$pdf->Line(PDF_MARGIN_LEFT, $pdf->GetY() + 1, $pdf->getPageWidth() - PDF_MARGIN_RIGHT, $pdf->GetY() + 1);
$pdf->Ln(3);

// JUDUL + INFO
$periodeTeks = ($mulai !== $akhir)
    ? tglindonesia($mulai) . ' s/d ' . tglindonesia($akhir)
    : tglindonesia($mulai);

$selisih    = (int) $banding['selisih'];
$selisihTxt = ($selisih > 0 ? '+' : '') . number_format($selisih) .
    ' (' . ($banding['persen'] > 0 ? '+' : '') . $banding['persen'] . '%)';

$pdf->writeHTML('<h3 style="text-align:center;">LAPORAN DISCIPLES COMMUNITY</h3>', true, false, false, false, '');

$infoHtml = '
<br>
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="28%" style="font-weight:bold;">PERIODE</td>
            <td width="3%" style="text-align:center;">:</td>
            <td width="69%">' . $periodeTeks . '</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="28%" style="font-weight:bold;">PERIODE SEBELUMNYA</td>
            <td width="3%" style="text-align:center;">:</td>
            <td width="69%">' . tglindonesia($banding['prevawal']) . ' s/d ' . tglindonesia($banding['prevakhir']) . '</td>
        </tr>
    </tbody>
</table>';
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($infoHtml, true, false, false, false, '');

// A. RINGKASAN
$ringkasHtml = '<br><h5 style="font-weight:bold;">A. RINGKASAN</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#dddddd;">
            <th width="60%" style="text-align:center;">Keterangan</th>
            <th width="40%" style="text-align:center;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        <tr style="font-size:10px;"><td>Member baru pada periode ini</td><td style="text-align:center;">' . number_format($banding['now']) . '</td></tr>
        <tr style="font-size:10px; background-color:#f5f5f5;"><td>Member baru pada periode sebelumnya</td><td style="text-align:center;">' . number_format($banding['prev']) . '</td></tr>
        <tr style="font-size:10px;"><td>Selisih terhadap periode sebelumnya</td><td style="text-align:center;">' . $selisihTxt . '</td></tr>
        <tr style="font-size:10px; background-color:#f5f5f5;"><td>Disciples Community aktif</td><td style="text-align:center;">' . number_format($jumlahDc) . '</td></tr>
        <tr style="font-size:10px;"><td>Member aktif seluruh DC</td><td style="text-align:center;">' . number_format($jumlahMember) . '</td></tr>
    </tbody>
</table>';
$pdf->writeHTML($ringkasHtml, true, false, false, false, '');

// B. MEMBER BARU PER BULAN (dengan nama)
$pdf->writeHTML('<br><h5 style="font-weight:bold;">B. MEMBER BARU PER BULAN</h5>', true, false, false, false, '');

$adaData = false;
foreach ($bulanKeys as $ym) {
    $rows = isset($rincian[$ym]) ? $rincian[$ym] : array();
    if (empty($rows)) {
        continue;
    }
    $adaData = true;

    $html = '<p style="font-size:10px; font-weight:bold; background-color:#fbe4ef;">' .
        $labelBulan[$ym] . ' (' . count($rows) . ' orang)</p>
    <table border="1" cellpadding="3">
        <thead>
            <tr style="font-size:9px; font-weight:bold; background-color:#dddddd;">
                <th width="7%" style="text-align:center;">No</th>
                <th width="20%" style="text-align:center;">Tgl Disetujui</th>
                <th width="43%" style="text-align:center;">Nama</th>
                <th width="30%" style="text-align:center;">DC</th>
            </tr>
        </thead>
        <tbody>';

    $i = 1;
    foreach ($rows as $r) {
        $bg   = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
        $nama = isset($r['namalengkap']) ? $r['namalengkap'] : '-';
        $namaDc = isset($r['namadc']) ? $r['namadc'] : '-';

        $html .= '<tr style="font-size:9px; background-color:' . $bg . ';">
            <td width="7%" style="text-align:center;">' . $i . '</td>
            <td width="20%" style="text-align:center;">' . tglindonesia($r['tglkonfirmasi']) . '</td>
            <td width="43%">' . htmlspecialchars((string) $nama) . '</td>
            <td width="30%">' . htmlspecialchars((string) $namaDc) . '</td>
        </tr>';
        $i++;
    }

    $html .= '</tbody></table><br>';
    $pdf->writeHTML($html, true, false, false, false, '');
}

if (!$adaData) {
    $pdf->writeHTML(
        '<p style="font-size:10px; font-style:italic; text-align:center;">Tidak ada member baru pada periode ini.</p>',
        true, false, false, false, ''
    );
}

// TANDA TANGAN
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

$pdf->Output('Laporan_DC_' . $mulai . '_sd_' . $akhir . '.pdf', 'I');