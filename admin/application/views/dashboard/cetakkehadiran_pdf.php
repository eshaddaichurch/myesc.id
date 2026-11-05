<?php

/*
 * Variabel dari Dashboardkehadiran::cetak():
 *   $info      - object infogereja
 *   $jenisNama - nama jenis absen
 *   $mulai, $akhir - string Y-m-d
 *   $harian    - array (labels, tanggal, totalhari, sesi, ringkas)
 *   $lokasi    - array baris (idabsenlokasi, namaabsenlokasi, idsesi, namasesi, totalhadir)
 *   $banding   - array (now, prev, selisih, persen, prevawal, prevakhir)
 *   $kosong    - array (tgl, label) hari ibadah tanpa catatan
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
$pdf->SetTitle('Laporan Dashboard Kehadiran');
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

// =========================================================
// JUDUL + INFO
// =========================================================
$periodeTeks = ($mulai !== $akhir)
    ? tglindonesia($mulai) . ' s/d ' . tglindonesia($akhir)
    : tglindonesia($mulai);

$selisih = (int) $banding['selisih'];
$selisihTxt = ($selisih > 0 ? '+' : '') . number_format($selisih) .
    ' (' . ($banding['persen'] > 0 ? '+' : '') . $banding['persen'] . '%)';

$pdf->writeHTML('<h3 style="text-align:center;">LAPORAN KEHADIRAN</h3>', true, false, false, false, '');

$infoHtml = '
<br>
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="28%" style="font-weight:bold;">JENIS ABSEN</td>
            <td width="3%" style="text-align:center;">:</td>
            <td width="69%">' . htmlspecialchars($jenisNama) . '</td>
        </tr>
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

// =========================================================
// A. RINGKASAN
// =========================================================
$r = $harian['ringkas'];
$sesiTerbesar = $r['sesi_terbesar']['nama'] . ' (' . number_format($r['sesi_terbesar']['total']) . ')';

$ringkasHtml = '<br><h5 style="font-weight:bold;">A. RINGKASAN</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#dddddd;">
            <th width="50%" style="text-align:center;">Keterangan</th>
            <th width="50%" style="text-align:center;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        <tr style="font-size:10px;"><td>Total kehadiran periode ini</td><td style="text-align:center;">' . number_format($r['total']) . '</td></tr>
        <tr style="font-size:10px; background-color:#f5f5f5;"><td>Total kehadiran periode sebelumnya</td><td style="text-align:center;">' . number_format($banding['prev']) . '</td></tr>
        <tr style="font-size:10px;"><td>Selisih terhadap periode sebelumnya</td><td style="text-align:center;">' . $selisihTxt . '</td></tr>
        <tr style="font-size:10px; background-color:#f5f5f5;"><td>Rata-rata per hari ibadah</td><td style="text-align:center;">' . number_format($r['rata']) . '</td></tr>
        <tr style="font-size:10px;"><td>Hari ibadah tercatat</td><td style="text-align:center;">' . number_format($r['hari']) . '</td></tr>
        <tr style="font-size:10px; background-color:#f5f5f5;"><td>Hari dengan kehadiran tertinggi</td><td style="text-align:center;">' . $r['tertinggi']['tgl'] . ' (' . number_format($r['tertinggi']['jumlah']) . ')</td></tr>
        <tr style="font-size:10px;"><td>Ibadah terbanyak</td><td style="text-align:center;">' . htmlspecialchars($sesiTerbesar) . '</td></tr>
    </tbody>
</table>';
$pdf->writeHTML($ringkasHtml, true, false, false, false, '');

// =========================================================
// B. KEHADIRAN PER IBADAH
// =========================================================
$sesiHtml = '<br><h5 style="font-weight:bold;">B. KEHADIRAN PER IBADAH</h5><br>
<table border="1" cellpadding="4">
    <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#dddddd;">
            <th width="8%" style="text-align:center;">No</th>
            <th width="62%" style="text-align:center;">Ibadah</th>
            <th width="30%" style="text-align:center;">Jumlah</th>
        </tr>
    </thead>
    <tbody>';
$no = 1;
foreach ($harian['sesi'] as $s) {
    $bg = ($no % 2 === 0) ? '#f5f5f5' : '#ffffff';
    $sesiHtml .= '<tr style="font-size:10px; background-color:' . $bg . ';">
        <td width="8%" style="text-align:center;">' . $no . '</td>
        <td width="62%">' . htmlspecialchars($s['nama']) . '</td>
        <td width="30%" style="text-align:center;">' . number_format($s['total']) . '</td>
    </tr>';
    $no++;
}
$sesiHtml .= '</tbody></table>';
$pdf->writeHTML($sesiHtml, true, false, false, false, '');

// =========================================================
// C. RINCIAN HARIAN
// =========================================================
$pdf->writeHTML('<br><h5 style="font-weight:bold;">C. RINCIAN HARIAN</h5>', true, false, false, false, '');

if (empty($harian['labels'])) {
    $pdf->writeHTML('<p style="font-size:10px; font-style:italic; text-align:center;">Tidak ada data kehadiran pada periode ini.</p>',
        true, false, false, false, '');
} else {
    $jumlahSesi = count($harian['sesi']);
    $wTgl = 16;
    $wKolom = $jumlahSesi > 0 ? round((84 - 14) / ($jumlahSesi), 2) : 0;
    $wTotal = 14;

    $harianHtml = '<table border="1" cellpadding="3">
        <thead>
            <tr style="font-size:9px; font-weight:bold; background-color:#dddddd;">
                <th width="' . $wTgl . '%" style="text-align:center;">Tanggal</th>';
    foreach ($harian['sesi'] as $s) {
        $harianHtml .= '<th width="' . $wKolom . '%" style="text-align:center;">' . htmlspecialchars($s['nama']) . '</th>';
    }
    $harianHtml .= '<th width="' . $wTotal . '%" style="text-align:center;">Total</th></tr></thead><tbody>';

    $totalKolom = array();
    foreach ($harian['sesi'] as $s) {
        $totalKolom[$s['id']] = 0;
    }

    foreach ($harian['labels'] as $i => $_) {
        $bg = ($i % 2 === 1) ? '#f5f5f5' : '#ffffff';
        $harianHtml .= '<tr style="font-size:9px; background-color:' . $bg . ';">
            <td width="' . $wTgl . '%" style="text-align:center;">' . $harian['tanggal'][$i] . '</td>';
        foreach ($harian['sesi'] as $s) {
            $v = $s['data'][$i];
            $totalKolom[$s['id']] += $v;
            $harianHtml .= '<td width="' . $wKolom . '%" style="text-align:center;">' . number_format($v) . '</td>';
        }
        $harianHtml .= '<td width="' . $wTotal . '%" style="text-align:center; font-weight:bold;">' . number_format($harian['totalhari'][$i]) . '</td></tr>';
    }

    $harianHtml .= '<tr style="font-size:9px; font-weight:bold; background-color:#eeeeee;">
        <td width="' . $wTgl . '%" style="text-align:center;">TOTAL</td>';
    foreach ($harian['sesi'] as $s) {
        $harianHtml .= '<td width="' . $wKolom . '%" style="text-align:center;">' . number_format($totalKolom[$s['id']]) . '</td>';
    }
    $harianHtml .= '<td width="' . $wTotal . '%" style="text-align:center;">' . number_format($r['total']) . '</td></tr>';
    $harianHtml .= '</tbody></table>';

    $pdf->writeHTML($harianHtml, true, false, false, false, '');
}

// =========================================================
// D. KEHADIRAN PER RUANGAN (dikelompokkan per ibadah)
// =========================================================
$pdf->writeHTML('<br><h5 style="font-weight:bold;">D. KEHADIRAN PER RUANGAN</h5>', true, false, false, false, '');

$grup = array();
foreach ($lokasi as $l) {
    $sesiNama = $l['namasesi'] ? $l['namasesi'] : 'Tanpa Sesi';
    $grup[$sesiNama][] = $l;
}

if (empty($grup)) {
    $pdf->writeHTML('<p style="font-size:10px; font-style:italic; text-align:center;">Tidak ada data ruangan pada periode ini.</p>',
        true, false, false, false, '');
} else {
    foreach ($grup as $namaSesi => $items) {
        $totalGrup = 0;
        foreach ($items as $it) {
            $totalGrup += (int) $it['totalhadir'];
        }

        $html = '<p style="font-size:10px; font-weight:bold;">' . htmlspecialchars($namaSesi) .
            ' (' . number_format($totalGrup) . ' jemaat)</p>
        <table border="1" cellpadding="3">
            <thead>
                <tr style="font-size:9px; font-weight:bold; background-color:#dddddd;">
                    <th width="8%" style="text-align:center;">No</th>
                    <th width="72%" style="text-align:center;">Ruangan</th>
                    <th width="20%" style="text-align:center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>';
        $i = 1;
        foreach ($items as $it) {
            $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
            $html .= '<tr style="font-size:9px; background-color:' . $bg . ';">
                <td width="8%" style="text-align:center;">' . $i . '</td>
                <td width="72%">' . htmlspecialchars($it['namaabsenlokasi'] ?: '-') . '</td>
                <td width="20%" style="text-align:center;">' . number_format($it['totalhadir']) . '</td>
            </tr>';
            $i++;
        }
        $html .= '</tbody></table><br>';
        $pdf->writeHTML($html, true, false, false, false, '');
    }
}

// =========================================================
// E. IBADAH TANPA CATATAN
// =========================================================
$pdf->writeHTML('<br><h5 style="font-weight:bold;">E. IBADAH TANPA CATATAN ABSEN</h5>', true, false, false, false, '');

if (empty($kosong)) {
    $pdf->writeHTML('<p style="font-size:10px;">Semua hari ibadah dalam periode sudah tercatat.</p>',
        true, false, false, false, '');
} else {
    $listHtml = '<ul style="font-size:10px;">';
    foreach ($kosong as $k) {
        $listHtml .= '<li>' . htmlspecialchars($k['label']) . '</li>';
    }
    $listHtml .= '</ul>';
    $pdf->writeHTML($listHtml, true, false, false, false, '');
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

$pdf->Output('Laporan_Kehadiran_' . $mulai . '_sd_' . $akhir . '.pdf', 'I');