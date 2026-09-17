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
      'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
      0, false, 'C', 0, '', 0, false, 'T', 'M'
    );
  }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('System');
$pdf->SetTitle('Laporan Data Volunteer');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// ── HEADER GEREJA ──────────────────────────────────────────
$titleHalaman = '
<table cellpadding="5">
  <tbody>
    <tr>
      <td width="10%" style="text-align:center;">
        <img src="' . base_url('images/icon.png') . '" alt="" width="55px;">
      </td>
      <td width="90%" style="text-align:left;">
        <span style="font-size:20px; font-weight:bold;">' . $rowInfoGereja->namagereja . '</span><br>
        <span style="font-size:12px;">' . $rowInfoGereja->alamatgereja . '</span><br>
        <span style="font-size:12px;">Email: ' . $rowInfoGereja->emailgereja . '</span>
      </td>
    </tr>
  </tbody>
</table>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');
$pdf->SetTopMargin(0);

// ── JUDUL ──────────────────────────────────────────────────
$judul = '<h3 style="text-align:center;">LAPORAN DATA VOLUNTEER</h3>';
$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($judul, true, false, false, false, '');

// ── RINGKASAN + INFO FILTER ────────────────────────────────
$ringkasan = '
<table border="0" cellpadding="3">
  <tr style="font-size:11px;">
    <td width="22%">Total Volunteer</td>
    <td width="3%">:</td>
    <td><b>' . $jumlahVolunteer . ' Orang</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Tanggal Cetak</td>
    <td>:</td>
    <td>' . date('d-m-Y H:i:s') . '</td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Departement</td>
    <td>:</td>
    <td>' . $labelDepartement . '</td>
  </tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Pelayanan</td>
    <td>:</td>
    <td>' . $labelPelayanan . '</td>
  </tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Status</td>
    <td>:</td>
    <td>' . $labelStatus . '</td>
  </tr>
</table><br>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($ringkasan, true, false, false, false, '');

// ── LOOP PER ORANG ─────────────────────────────────────────
if (!empty($grouped)) {
  $noOrang = 1;
  foreach ($grouped as $idjemaat => $datajemaat) {

    $jumlahPelayanan = count($datajemaat['pelayanan']);

    // ── Header Nama + No HP ──────────────────────────────
    $headerOrang = '
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
          <tr>
            <td style="background-color:#2c3e50; color:#fff; font-size:12px;
                font-weight:bold; padding:6px 8px;">
              ' . $noOrang++ . '. ' . htmlspecialchars($datajemaat['namalengkap']) . '
              <span style="font-size:10px; font-weight:normal;">
                &nbsp;( ' . $jumlahPelayanan . ' Pelayanan )
              </span>
            </td>
          </tr>
          <tr>
            <td style="background-color:#ecf0f1; font-size:10px;
                padding:4px 8px; border-left:3px solid #2c3e50;">
              <b>No HP :</b> ' . (!empty($datajemaat['nohp']) ? $datajemaat['nohp'] : '-') . '
            </td>
          </tr>
        </table>';

    $pdf->SetFont('times', '', 11);
    $pdf->writeHTML($headerOrang, true, false, false, false, '');

    // ── Tabel Detail Pelayanan (mirip modal Riwayat Pelayanan) ──
    $tabelPelayanan = '
        <table border="1" cellpadding="4">
          <thead>
            <tr style="font-size:10px; font-weight:bold; background-color:#bdc3c7;">
              <th width="25%" style="text-align:center;">Departement</th>
              <th width="30%" style="text-align:center;">Pelayanan</th>
              <th width="15%" style="text-align:center;">Kategori</th>
              <th width="15%" style="text-align:center;">Status</th>
              <th width="15%" style="text-align:center;">Tgl Bergabung</th>
            </tr>
          </thead>
          <tbody>';

    foreach ($datajemaat['pelayanan'] as $pel) {
      $namapel     = !empty($pel->namapelayanan) ? $pel->namapelayanan : '-';
      $statuslabel = ($pel->statusaktif == 'Aktif') ? 'Aktif' : 'Tidak Aktif';
      $tglgabung   = !empty($pel->tanggalbergabung) ? date('d-m-Y', strtotime($pel->tanggalbergabung)) : '-';

      $tabelPelayanan .= '
                <tr style="font-size:10px;">
                  <td width="25%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($pel->namadepartement) . '</td>
                  <td width="30%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($namapel) . '</td>
                  <td width="15%" style="text-align:center;">' . $pel->kategori . '</td>
                  <td width="15%" style="text-align:center;">' . $statuslabel . '</td>
                  <td width="15%" style="text-align:center;">' . $tglgabung . '</td>
                </tr>';
    }

    $tabelPelayanan .= '</tbody></table><br>';

    $pdf->SetFont('times', '', 10);
    $pdf->writeHTML($tabelPelayanan, true, false, false, false, '');
  }
} else {
  $kosong = '<p style="text-align:center; font-style:italic; color:#888;">Tidak ada data volunteer untuk filter yang dipilih.</p>';
  $pdf->SetFont('times', '', 11);
  $pdf->writeHTML($kosong, true, false, false, false, '');
}

$pdf->Output('Laporan_Data_Volunteer_' . date('d-m-Y') . '.pdf', 'I');