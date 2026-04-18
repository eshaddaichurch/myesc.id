<?php

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

// ===== BUAT DOKUMEN PDF =====
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('El Shaddai Church');
$pdf->SetAuthor($rowInfoGereja->namagereja ?? 'ESC');
$pdf->SetTitle('Laporan Dashboard Care');

$pdf->AddPage();

// ===== HEADER: LOGO + INFO GEREJA =====
$titleHalaman = '
<table cellpadding="5">
    <tbody>
        <tr style="font-weight:bold;">
            <td width="10%" style="text-align:center;">
                <img src="' . base_url('images/icon.png') . '" alt="" width="55px">
            </td>
            <td width="90%" style="text-align:left;">
                <span style="font-size:20px;">' . ($rowInfoGereja->namagereja ?? '') . '</span>
                <br><span style="font-size:12px;">' . ($rowInfoGereja->alamatgereja ?? '') . '</span>
                <br><span style="font-size:12px;">Email: ' . ($rowInfoGereja->emailgereja ?? '') . '</span>
            </td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');
$pdf->SetTopMargin(0);

// ===== JUDUL LAPORAN =====
$title = '<h3 style="text-align:center;">LAPORAN DASHBOARD CARE</h3>';
$pdf->SetFont('times', '', 16);
$pdf->writeHTML($title, true, false, false, false, '');

// ===== PERIODE =====
if ($tglawal != $tglakhir) {
    $periodeTeks = tglindonesia($tglawal) . ' s/d ' . tglindonesia($tglakhir);
} else {
    $periodeTeks = tglindonesia($tglawal);
}

// ===== SUMMARY INFO BOX =====
$subTitle = '
<br>
<table border="0" cellpadding="5">
    <tbody>
        <tr style="font-size:12px; font-weight:bold;">
            <td width="30%" style="text-align:left;">PERIODE</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="65%" style="text-align:left;">' . $periodeTeks . '</td>
        </tr>
        <tr style="font-size:12px; font-weight:bold;">
            <td width="30%" style="text-align:left;">TOTAL JEMAAT</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="65%" style="text-align:left;">' . number_format($totalJemaat) . ' Orang</td>
        </tr>
        <tr style="font-size:12px; font-weight:bold;">
            <td width="30%" style="text-align:left;">TOTAL SIMPATISAN</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="65%" style="text-align:left;">' . number_format($totalSimpatisan) . ' Orang</td>
        </tr>
        <tr style="font-size:12px; font-weight:bold;">
            <td width="30%" style="text-align:left;">SUDAH DIBAPTIS</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="65%" style="text-align:left;">' . number_format($totalBaptis) . ' Orang</td>
        </tr>
        <tr style="font-size:12px; font-weight:bold;">
            <td width="30%" style="text-align:left;">JEMAAT BARU PERIODE INI</td>
            <td width="5%"  style="text-align:center;">:</td>
            <td width="65%" style="text-align:left;">' . number_format($jemaatBaruPeriode) . ' Orang</td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($subTitle, true, false, false, false, '');

// ===== TABEL DATA JEMAAT BARU =====
$tabel = '<br><h5>DATA JEMAAT BARU PERIODE ' . strtoupper($periodeTeks) . '</h5><br>';
$tabel .= '<table border="1" cellpadding="5">
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#f0f0f0;">
            <th width="5%"  style="text-align:center;">No</th>
            <th width="15%" style="text-align:center;">Tanggal</th>
            <th width="38%" style="text-align:center;">Nama Lengkap</th>
            <th width="8%"  style="text-align:center;">JK</th>
            <th width="9%"  style="text-align:center;">Umur</th>
            <th width="25%" style="text-align:center;">Nama DC</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($rsJemaatBaru->num_rows() > 0) {
    foreach ($rsJemaatBaru->result() as $row) {
        // Singkat jenis kelamin
        $jk = ($row->jeniskelamin == 'Laki-laki') ? 'L' : 'P';

        // Warna baris bergantian (zebra stripe)
        $bgColor = ($no % 2 == 0) ? '#f9f9f9' : '#ffffff';

        $tabel .= '
        <tr style="font-size:11px; background-color:' . $bgColor . ';">
            <td width="5%"  style="text-align:center;">' . $no . '</td>
            <td width="15%" style="text-align:center;">' . tglindonesia($row->tglkonfirmasi) . '</td>
            <td width="38%" style="text-align:left;">' . htmlspecialchars($row->namalengkap) . '</td>
            <td width="8%"  style="text-align:center;">' . $jk . '</td>
            <td width="9%"  style="text-align:center;">' . ($row->umur ?? '-') . '</td>
            <td width="25%" style="text-align:left;">' . htmlspecialchars($row->namadc ?? '-') . '</td>
        </tr>';
        $no++;
    }
} else {
    $tabel .= '
        <tr>
            <td colspan="6" style="font-size:12px; text-align:center; font-style:italic;">
                Tidak ada data jemaat baru pada periode ini.
            </td>
        </tr>';
}

$tabel .= '</tbody></table>';

// ===== TANDA TANGAN / FOOTER LAPORAN =====
$tglCetak = date('d-m-Y H:i');
$tabel .= '
<br><br>
<table border="0" cellpadding="5">
    <tbody>
        <tr style="font-size:11px;">
            <td width="70%"></td>
            <td width="30%" style="text-align:center;">
                Dicetak pada ' . $tglCetak . '<br><br><br><br>
                ________________________<br>
                <span style="font-weight:bold;">Penanggung Jawab</span>
            </td>
        </tr>
    </tbody>
</table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($tabel, true, false, false, false, '');

// ===== OUTPUT PDF =====
$pdf->Output('Laporan_Care_' . $tglawal . '_sd_' . $tglakhir . '.pdf', 'I');
