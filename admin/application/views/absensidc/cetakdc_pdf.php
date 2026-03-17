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
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Buat PDF landscape karena kolom cukup banyak
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('MyApp');
$pdf->SetAuthor('System');
$pdf->SetTitle('Laporan Absensi DC');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// ── HEADER GEREJA ─────────────────────────────────────────────────────────────
$titleHalaman = '
<table cellpadding="5">
  <tbody>
    <tr style="font-weight:bold;">
      <td width="10%" style="text-align:center;">
        <img src="' . base_url('images/icon.png') . '" alt="" width="55px;">
      </td>
      <td width="90%" style="text-align:left;">
        <span style="font-size:20px;">' . $rowInfoGereja->namagereja . '</span><br>
        <span style="font-size:12px;">' . $rowInfoGereja->alamatgereja . '</span><br>
        <span style="font-size:12px;">Email: ' . $rowInfoGereja->emailgereja . '</span>
      </td>
    </tr>
  </tbody>
</table>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');
$pdf->SetTopMargin(0);

// ── JUDUL LAPORAN ─────────────────────────────────────────────────────────────
$judulLaporan = '<h3 style="text-align:center;">LAPORAN ABSENSI DISCIPLES COMMUNITY (DC)</h3>';
$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($judulLaporan, true, false, false, false, '');

// ── SUB JUDUL PERIODE & FILTER ────────────────────────────────────────────────
if ($tglawal != $tglakhir) {
    $periode = $tglawal . ' s/d ' . $tglakhir;
} else {
    $periode = $tglawal;
}

$filterDcText = ($namaDc != '') ? $namaDc : 'Semua DC';

$subTitle = '
<table border="0" cellpadding="4">
  <tbody>
    <tr style="font-size:12px;">
      <td width="15%">Periode</td>
      <td width="3%" style="text-align:center;">:</td>
      <td width="82%">' . $periode . '</td>
    </tr>
    <tr style="font-size:12px;">
      <td width="15%">DC</td>
      <td width="3%" style="text-align:center;">:</td>
      <td width="82%">' . $filterDcText . '</td>
    </tr>
    <tr style="font-size:12px;">
      <td width="15%">Total Data</td>
      <td width="3%" style="text-align:center;">:</td>
      <td width="82%">' . $rsAbsensi->num_rows() . ' Absensi</td>
    </tr>
  </tbody>
</table><br>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($subTitle, true, false, false, false, '');

// ── TABEL DATA ABSENSI ────────────────────────────────────────────────────────
$table = '<h5>DATA ABSENSI DC</h5>';
$table .= '
<table border="1" cellpadding="5">
  <thead>
    <tr style="font-size:11px; font-weight:bold; background-color:#c0392b; color:#ffffff;">
      <th width="4%"  style="text-align:center;">No</th>
      <th width="22%" style="text-align:center;">Nama DC</th>
      <th width="18%" style="text-align:center;">Nama DM</th>
      <th width="25%" style="text-align:center;">Tanggal Absen</th>
      <th width="10%" style="text-align:center;">Total Peserta</th>
      <th width="21%" style="text-align:center;">Keterangan</th>
    </tr>
  </thead>
  <tbody>';

$no = 1;
if ($rsAbsensi->num_rows() > 0) {
    foreach ($rsAbsensi->result() as $row) {
        $bgColor = ($no % 2 == 0) ? 'background-color:#fef9f9;' : '';
        $table .= '
        <tr style="font-size:11px; ' . $bgColor . '">
          <td width="4%"  style="text-align:center;">' . $no++ . '</td>
          <td width="22%" style="text-align:left;"><b>' . htmlspecialchars($row->namadc) . '</b></td>
          <td width="18%" style="text-align:left;">' . htmlspecialchars($row->namadm) . '</td>
          <td width="25%" style="text-align:center;">' . formatHariTanggalJam($row->tglabsen) . '</td>
          <td width="10%" style="text-align:center;"><b>' . $row->totalpeserta . '</b></td>
          <td width="21%" style="text-align:left;">' . htmlspecialchars($row->keterangan) . '</td>
        </tr>';
    }
} else {
    $table .= '
    <tr>
      <td colspan="6" style="font-size:12px; text-align:center; font-style:italic; color:#888;">
        Tidak ada data absensi pada periode yang dipilih.
      </td>
    </tr>';
}

$table .= '</tbody></table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

// ── FOOTER CETAK ─────────────────────────────────────────────────────────────
$footerCetak = '<br><p style="font-size:9px; color:#888; text-align:right;">
    Dicetak pada : ' . date('d-m-Y H:i:s') . '
</p>';
$pdf->SetFont('times', '', 9);
$pdf->writeHTML($footerCetak, true, false, false, false, '');

$pdf->Output('Laporan_Absensi_DC_' . $tglawal . '_sd_' . $tglakhir . '.pdf', 'I');
// 'I' = tampil di browser | 'D' = langsung download
