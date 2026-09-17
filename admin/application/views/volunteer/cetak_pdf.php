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

// ── TABEL VOLUNTEER ────────────────────────────────────────
$tabel = '
    <table border="1" cellpadding="4">
      <thead>
        <tr style="font-size:10px; font-weight:bold; background-color:#bdc3c7;">
          <th width="5%"  style="text-align:center;">No</th>
          <th width="25%" style="text-align:center;">Nama Volunteer</th>
          <th width="15%" style="text-align:center;">No HP</th>
          <th width="55%" style="text-align:center;">Detail Pelayanan</th>
        </tr>
      </thead>
      <tbody>';

if ($rsData->num_rows() > 0) {
    $no = 1;
    foreach ($rsData->result() as $row) {

        // -------------------------> Susun detail pelayanan jadi list bertingkat dalam satu cell
        // format tiap item: namadepartement|namapelayanan|kategori|statusaktif
        $items = explode(';;', $row->detail_pelayanan);
        $detailhtml = '';
        foreach ($items as $item) {
            $pecah = explode('|', $item);
            if (count($pecah) < 4) continue;

            $namadept = $pecah[0];
            $namapel  = $pecah[1];
            $kategori = $pecah[2];
            $status   = $pecah[3];

            $labelpel = ($namapel != '-') ? $namadept . ' - ' . $namapel : $namadept;
            $labelstatus = ($status != 'Aktif') ? ' (Tidak Aktif)' : '';

            $detailhtml .= '&bull; ' . htmlspecialchars($labelpel) . ' [' . $kategori . ']' . $labelstatus . '<br>';
        }

        $tabel .= '
            <tr style="font-size:10px;">
              <td width="5%"  style="text-align:center;">' . $no++ . '</td>
              <td width="25%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($row->namalengkap) . '</td>
              <td width="15%" style="text-align:center;">' . (!empty($row->nohp) ? $row->nohp : '-') . '</td>
              <td width="55%" style="text-align:left; padding-left:5px;">' . $detailhtml . '</td>
            </tr>';
    }
} else {
    $tabel .= '
        <tr>
          <td colspan="4" style="font-size:10px; text-align:center; font-style:italic; color:#888; padding:8px;">
            Tidak ada data volunteer untuk filter yang dipilih.
          </td>
        </tr>';
}

$tabel .= '</tbody></table>';

$pdf->SetFont('times', '', 10);
$pdf->writeHTML($tabel, true, false, false, false, '');

$pdf->Output('Laporan_Data_Volunteer_' . date('d-m-Y') . '.pdf', 'I');