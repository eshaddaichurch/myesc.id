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
$pdf->SetTitle('Laporan Anggota DC');
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
$judul = '<h3 style="text-align:center;">LAPORAN ANGGOTA DISCIPLES COMMUNITY</h3>';
$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($judul, true, false, false, false, '');

// ── RINGKASAN + INFO FILTER ────────────────────────────────
$labelJK = ($filterJeniskelamin != '') ? $filterJeniskelamin : 'Semua';
$labelUmur = ($filterUmur != '') ? $filterUmur . ' Tahun' : 'Semua';
$labelStatus = ($filterStatus != '') ? $filterStatus : 'Semua';

$ringkasan = '
<table border="0" cellpadding="3">
  <tr style="font-size:11px;">
    <td width="22%">Total DC Aktif</td>
    <td width="3%">:</td>
    <td><b>' . $jumlahDc . ' DC</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Total Anggota</td>
    <td>:</td>
    <td><b>' . $jumlahMember . ' Orang</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Tanggal Cetak</td>
    <td>:</td>
    <td>' . date('d-m-Y H:i:s') . '</td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Jenis Kelamin</td>
    <td>:</td>
    <td>' . $labelJK . '</td>
  </tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Umur</td>
    <td>:</td>
    <td>' . $labelUmur . '</td>
  </tr>
  <tr style="font-size:10px; color:#555;">
    <td>Filter Status</td>
    <td>:</td>
    <td>' . $labelStatus . '</td>
  </tr>
</table><br>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($ringkasan, true, false, false, false, '');

// ── LOOP PER DC ────────────────────────────────────────────
if ($rsDc->num_rows() > 0) {
  $noDc = 1;
  foreach ($rsDc->result() as $rowDc) {
    // Ambil Core Team
    $rsCt = $this->Dashboarddc_model->getCT($rowDc->iddc);
    $arrCt = array();
    if ($rsCt->num_rows() > 0) {
      foreach ($rsCt->result() as $rowCt) {
        $arrCt[] = $rowCt->namalengkap;
      }
    }
    $namaCt = !empty($arrCt) ? implode(', ', $arrCt) : '-';

    // Ambil anggota dengan filter
    $rsAnggota = $this->Dashboarddc_model->getAnggotaPerDc(
      $rowDc->iddc,
      $filterJeniskelamin,
      $filterUmur,
      $filterStatus
    );
    $jumlahAnggota = $rsAnggota->num_rows();

    // Skip DC jika tidak ada anggota setelah filter
    if ($jumlahAnggota == 0) {
      $noDc++;
      continue;
    }

    // ── Header DC ──────────────────────────────────────
    $headerDc = '
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
          <tr>
            <td style="background-color:#2c3e50; color:#fff; font-size:12px;
                font-weight:bold; padding:6px 8px;">
              ' . $noDc++ . '. ' . htmlspecialchars($rowDc->namadc) . '
              <span style="font-size:10px; font-weight:normal;">
                &nbsp;( ' . $jumlahAnggota . ' Anggota )
              </span>
            </td>
          </tr>
          <tr>
            <td style="background-color:#ecf0f1; font-size:10px;
                padding:4px 8px; border-left:3px solid #2c3e50;">
              <b>DM :</b> ' . htmlspecialchars($rowDc->namadm) . '
              &nbsp;&nbsp;&nbsp;
              <b>Core Team :</b> ' . htmlspecialchars($namaCt) . '
            </td>
          </tr>
        </table>';

    $pdf->SetFont('times', '', 11);
    $pdf->writeHTML($headerDc, true, false, false, false, '');

    // ── Tabel Anggota ──────────────────────────────────
    $tabelAnggota = '
        <table border="1" cellpadding="4">
          <thead>
            <tr style="font-size:10px; font-weight:bold; background-color:#bdc3c7;">
              <th width="5%"  style="text-align:center;">No</th>
              <th width="37%" style="text-align:center;">Nama Anggota</th>
              <th width="10%" style="text-align:center;">JK</th>
              <th width="8%"  style="text-align:center;">Umur</th>
              <th width="18%" style="text-align:center;">Status</th>
              <th width="22%" style="text-align:center;">Tgl Bergabung</th>
            </tr>
          </thead>
          <tbody>';

    if ($jumlahAnggota > 0) {
      $noAnggota = 1;
      foreach ($rsAnggota->result() as $rowAnggota) {
        $bgBaris = ($rowAnggota->statuskeanggotaan == 'Core Team')
          ? 'background-color:#fef9e7;'
          : '';

        $jk = ($rowAnggota->jeniskelamin == 'Laki-laki') ? 'L' : 'P';

        $tabelAnggota .= '
                <tr style="font-size:10px; ' . $bgBaris . '">
                  <td width="5%"  style="text-align:center;">' . $noAnggota++ . '</td>
                  <td width="37%" style="text-align:left; padding-left:5px;">
                    ' . htmlspecialchars($rowAnggota->namalengkap) . '
                  </td>
                  <td width="10%" style="text-align:center;">' . $jk . '</td>
                  <td width="8%"  style="text-align:center;">' . ($rowAnggota->umur ?? '-') . '</td>
                  <td width="18%" style="text-align:center;">
                    ' . htmlspecialchars($rowAnggota->statuskeanggotaan) . '
                  </td>
                  <td width="22%" style="text-align:center;">
                    ' . date('d-m-Y', strtotime($rowAnggota->tglbergabung)) . '
                  </td>
                </tr>';
      }
    } else {
      $tabelAnggota .= '
            <tr>
              <td colspan="6" style="font-size:10px; text-align:center;
                  font-style:italic; color:#888; padding:8px;">
                Tidak ada anggota.
              </td>
            </tr>';
    }

    $tabelAnggota .= '</tbody></table><br>';

    $pdf->SetFont('times', '', 10);
    $pdf->writeHTML($tabelAnggota, true, false, false, false, '');
  }
}

$pdf->Output('Laporan_Anggota_DC_' . date('d-m-Y') . '.pdf', 'I');
