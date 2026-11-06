<?php

/*
 * Variabel dari Dashboardnextstep::cetak():
 *   $info, $mulai, $akhir, $kelas (array kode), $labels (kode => nama),
 *   $summary (kode => jumlah), $bulanKeys, $labelBulan, $rincian (ym => kode => baris)
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
$pdf->SetTitle('Laporan Dashboard Equip');
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

$namaKelas = array();
foreach ($kelas as $k) {
    $namaKelas[] = $labels[$k];
}

$pdf->writeHTML('<h3 style="text-align:center;">LAPORAN DASHBOARD EQUIP</h3>', true, false, false, false, '');

$infoHtml = '
<br>
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="25%" style="font-weight:bold;">PERIODE</td>
            <td width="3%" style="text-align:center;">:</td>
            <td width="72%">' . $periodeTeks . '</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="25%" style="font-weight:bold;">KELAS</td>
            <td width="3%" style="text-align:center;">:</td>
            <td width="72%">' . htmlspecialchars(implode(', ', $namaKelas)) . '</td>
        </tr>
    </tbody>
</table>';
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($infoHtml, true, false, false, false, '');

// A. RINGKASAN PER KELAS
$totalSemua = array_sum($summary);

$ringkasHtml = '<br><h5 style="font-weight:bold;">A. RINGKASAN PER KELAS</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#dddddd;">
            <th width="8%" style="text-align:center;">No</th>
            <th width="72%" style="text-align:center;">Kelas</th>
            <th width="20%" style="text-align:center;">Sertifikat</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($kelas as $k) {
    $bg = ($no % 2 === 0) ? '#f5f5f5' : '#ffffff';
    $ringkasHtml .= '
        <tr style="font-size:11px; background-color:' . $bg . ';">
            <td width="8%" style="text-align:center;">' . $no . '</td>
            <td width="72%">' . htmlspecialchars($labels[$k]) . '</td>
            <td width="20%" style="text-align:center;">' . number_format($summary[$k]) . '</td>
        </tr>';
    $no++;
}

$ringkasHtml .= '
        <tr style="font-size:11px; font-weight:bold; background-color:#eeeeee;">
            <td colspan="2" style="text-align:center;">TOTAL</td>
            <td width="20%" style="text-align:center;">' . number_format($totalSemua) . '</td>
        </tr>
    </tbody>
</table>';
$pdf->writeHTML($ringkasHtml, true, false, false, false, '');

// B. RINCIAN PER BULAN (dengan nama)
$pdf->writeHTML('<br><h5 style="font-weight:bold;">B. RINCIAN PER BULAN</h5>', true, false, false, false, '');

$adaData = false;
foreach ($bulanKeys as $ym) {
    $adaBulan = false;
    foreach ($kelas as $k) {
        if (!empty($rincian[$ym][$k])) {
            $adaBulan = true;
            break;
        }
    }
    if (!$adaBulan) {
        continue;
    }
    $adaData = true;

    $html = '<p style="font-size:10px; font-weight:bold; background-color:#e8eef8;">' .
        $labelBulan[$ym] . '</p>';

    foreach ($kelas as $k) {
        $rows = isset($rincian[$ym][$k]) ? $rincian[$ym][$k] : array();
        if (empty($rows)) {
            continue;
        }

        $html .= '<p style="font-size:10px; font-weight:bold;">' . htmlspecialchars($labels[$k]) .
            ' (' . count($rows) . ' orang)</p>
        <table border="1" cellpadding="3">
            <thead>
                <tr style="font-size:9px; font-weight:bold; background-color:#dddddd;">
                    <th width="7%" style="text-align:center;">No</th>
                    <th width="18%" style="text-align:center;">Tanggal</th>
                    <th width="43%" style="text-align:center;">Nama</th>
                    <th width="10%" style="text-align:center;">JK</th>
                    <th width="22%" style="text-align:center;">No. Sertifikat</th>
                </tr>
            </thead>
            <tbody>';

        $i = 1;
        foreach ($rows as $r) {
            $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
            $jk = (isset($r['jeniskelamin']) && $r['jeniskelamin'] === 'Laki-laki') ? 'L' : 'P';
            $html .= '<tr style="font-size:9px; background-color:' . $bg . ';">
                <td width="7%" style="text-align:center;">' . $i . '</td>
                <td width="18%" style="text-align:center;">' . tglindonesia($r['tglsertifikat']) . '</td>
                <td width="43%">' . htmlspecialchars((string) ($r['namalengkap'] ?? '-')) . '</td>
                <td width="10%" style="text-align:center;">' . $jk . '</td>
                <td width="22%" style="text-align:center;">' . htmlspecialchars((string) ($r['nomorsertifikat'] ?? '-')) . '</td>
            </tr>';
            $i++;
        }

        $html .= '</tbody></table><br>';
    }

    $pdf->writeHTML($html, true, false, false, false, '');
}

if (!$adaData) {
    $pdf->writeHTML(
        '<p style="font-size:11px; font-style:italic; text-align:center;">Tidak ada sertifikat terbit pada periode ini.</p>',
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

$pdf->Output('Laporan_NextStep_' . $mulai . '_sd_' . $akhir . '.pdf', 'I');