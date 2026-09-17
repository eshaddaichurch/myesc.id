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

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
    <td width="22%">Total Departemen Aktif</td>
    <td width="3%">:</td>
    <td><b>' . $jumlahDepartement . ' Departemen</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Total Volunteer</td>
    <td>:</td>
    <td><b>' . $jumlahVolunteer . ' Orang</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Tanggal Cetak</td>
    <td>:</td>
    <td>' . date('d-m-Y H:i:s') . '</td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
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

// ── LOOP PER DEPARTEMEN ────────────────────────────────────
if (!empty($grouped)) {
  $noDept = 1;
  foreach ($grouped as $namadept => $listorang) {

    $jumlahOrang = count($listorang);

    // ── Header Departemen ──────────────────────────────
    $headerDept = '
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
          <tr>
            <td style="background-color:#2c3e50; color:#fff; font-size:12px;
                font-weight:bold; padding:6px 8px;">
              ' . $noDept++ . '. ' . htmlspecialchars($namadept) . '
              <span style="font-size:10px; font-weight:normal;">
                &nbsp;( ' . $jumlahOrang . ' Volunteer )
              </span>
            </td>
          </tr>
        </table>';

    $pdf->SetFont('times', '', 11);
    $pdf->writeHTML($headerDept, true, false, false, false, '');

    // ── Tabel Volunteer per Departemen ───────────────────
    $tabelVolunteer = '
        <table border="1" cellpadding="4">
          <thead>
            <tr style="font-size:10px; font-weight:bold; background-color:#bdc3c7;">
              <th width="4%"  style="text-align:center;">No</th>
              <th width="20%" style="text-align:center;">Nama Volunteer</th>
              <th width="13%" style="text-align:center;">No HP</th>
              <th width="25%" style="text-align:center;">Pelayanan</th>
              <th width="10%" style="text-align:center;">Kategori</th>
              <th width="10%" style="text-align:center;">Status</th>
              <th width="18%" style="text-align:center;">Tgl Bergabung</th>
            </tr>
          </thead>
          <tbody>';

    $noOrang = 1;
    foreach ($listorang as $orang) {
      $bgBaris = ($orang->kategori == 'Major') ? 'background-color:#fef9e7;' : '';

      $namapel = !empty($orang->namapelayanan) ? $orang->namapelayanan : '-';
      $statusbadge = ($orang->statusaktif == 'Aktif') ? 'Aktif' : 'Tidak Aktif';
      $tglgabung = !empty($orang->tanggalbergabung) ? date('d-m-Y', strtotime($orang->tanggalbergabung)) : '-';

      $tabelVolunteer .= '
                <tr style="font-size:10px; ' . $bgBaris . '">
                  <td width="4%"  style="text-align:center;">' . $noOrang++ . '</td>
                  <td width="20%" style="text-align:left; padding-left:5px;">
                    ' . htmlspecialchars($orang->namalengkap) . '
                  </td>
                  <td width="13%" style="text-align:center;">' . (!empty($orang->nohp) ? $orang->nohp : '-') . '</td>
                  <td width="25%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($namapel) . '</td>
                  <td width="10%" style="text-align:center;">' . $orang->kategori . '</td>
                  <td width="10%" style="text-align:center;">' . $statusbadge . '</td>
                  <td width="18%" style="text-align:center;">' . $tglgabung . '</td>
                </tr>';
    }

    $tabelVolunteer .= '</tbody></table><br>';

    $pdf->SetFont('times', '', 10);
    $pdf->writeHTML($tabelVolunteer, true, false, false, false, '');
  }
} else {
  $kosong = '<p style="text-align:center; font-style:italic; color:#888;">Tidak ada data volunteer untuk filter yang dipilih.</p>';
  $pdf->SetFont('times', '', 11);
  $pdf->writeHTML($kosong, true, false, false, false, '');
}

$pdf->Output('Laporan_Data_Volunteer_' . date('d-m-Y') . '.pdf', 'I');