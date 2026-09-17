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
        <img src="' . base_url('images/icon.png') . '" alt="Logo" width="55px;">
      </td>
      <td width="90%" style="text-align:left;">
        <span style="font-size:20px; font-weight:bold;">' . $rowInfoGereja->namagereja . '</span><br>
        <span style="font-size:12px;">' . $rowInfoGereja->alamatgereja . '</span><br>
        <span style="font-size:12px;">Email: ' . $rowInfoGereja->emailgereja . '</span>
      </td>
    </tr>
  </tbody>
</table>';

$pdf->SetFont('helvetica', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');

// Garis pemisah header
$pdf->Ln(2);
$pdf->SetDrawColor(200, 200, 200);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(4);

// ── JUDUL ──────────────────────────────────────────────────
$judul = '<h3 style="text-align:center; margin-top:0;">LAPORAN DATA VOLUNTEER</h3>';
$pdf->SetFont('helvetica', 'B', 14);
$pdf->writeHTML($judul, true, false, false, false, '');

// ── RINGKASAN + INFO FILTER ────────────────────────────────
$ringkasan = '
<table border="0" cellpadding="4">
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

$pdf->SetFont('helvetica', '', 11);
$pdf->writeHTML($ringkasan, true, false, false, false, '');

// ── HELPER: Estimasi tinggi 1 blok orang (disesuaikan dengan spacing baru) ──
function estimasiTinggiBlok($jumlahBaris)
{
    // header nama+hp ~12mm, header tabel ~8mm, tiap baris data ~7mm, spacing & divider ~8mm
    return 12 + 8 + ($jumlahBaris * 7) + 8;
}

// ── LOOP PER ORANG ─────────────────────────────────────────
if (!empty($grouped)) {
  $noOrang = 1;
  foreach ($grouped as $idjemaat => $datajemaat) {

    $jumlahPelayanan = count($datajemaat['pelayanan']);

    // Cek sisa halaman
    $tinggiButuh = estimasiTinggiBlok($jumlahPelayanan);
    $sisaHalaman = $pdf->getPageHeight() - $pdf->GetY() - $pdf->getBreakMargin();
    if ($tinggiButuh > $sisaHalaman) {
        $pdf->AddPage();
    }

    // ── Header Nama + No HP ──
    $headerOrang = '
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
          <tr>
            <td style="background-color:#2c3e50; color:#ffffff; font-size:12px;
                font-weight:bold; padding:6px 10px;">
              ' . $noOrang++ . '. ' . htmlspecialchars($datajemaat['namalengkap']) . '
              <span style="font-size:10px; font-weight:normal; color:#d0d0d0;">
                &nbsp;(' . $jumlahPelayanan . ' Pelayanan)
              </span>
            </td>
          </tr>
          <tr>
            <td style="background-color:#fff3cd; color:#664d03; font-size:11px;
                font-weight:bold; padding:6px 10px; border-left:3px solid #2c3e50;
                border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">
               No Whatsapp: ' . (!empty($datajemaat['nohp']) ? htmlspecialchars($datajemaat['nohp']) : '-') . '
            </td>
          </tr>
        </table>';

    $pdf->SetFont('helvetica', '', 11);
    $pdf->writeHTML($headerOrang, true, false, false, false, '');

    // ── Tabel Detail Pelayanan ──
    $tabelPelayanan = '
        <table border="0" cellpadding="5" cellspacing="0" style="width:100%;">
          <thead>
            <tr style="font-size:10px; font-weight:bold; background-color:#eceff1; color:#333;">
              <th width="24%" style="text-align:left; padding-left:8px; border-bottom:1px solid #bbb;">Departement</th>
              <th width="30%" style="text-align:left; padding-left:8px; border-bottom:1px solid #bbb;">Pelayanan</th>
              <th width="14%" style="text-align:center; border-bottom:1px solid #bbb;">Kategori</th>
              <th width="16%" style="text-align:center; border-bottom:1px solid #bbb;">Status</th>
              <th width="16%" style="text-align:center; border-bottom:1px solid #bbb;">Bergabung</th>
            </tr>
          </thead>
          <tbody>';

    $baris = 0;
    foreach ($datajemaat['pelayanan'] as $pel) {
      $namapel     = !empty($pel->namapelayanan) ? $pel->namapelayanan : '-';
      $statuslabel = ($pel->statusaktif == 'Aktif') ? 'Aktif' : 'Tidak Aktif';
      $tglgabung   = !empty($pel->tanggalbergabung) ? date('d-m-Y', strtotime($pel->tanggalbergabung)) : '-';

      $bgBaris = ($baris % 2 == 1) ? 'background-color:#f7f8f9;' : '';
      $warnakategori = ($pel->kategori == 'Major') ? 'color:#b8860b; font-weight:bold;' : 'color:#777;';

      $tabelPelayanan .= '
                <tr style="font-size:10px; ' . $bgBaris . '">
                  <td width="24%" valign="middle" style="text-align:left; padding-left:8px; border-bottom:0.5px solid #e0e0e0;">' . htmlspecialchars($pel->namadepartement) . '</td>
                  <td width="30%" valign="middle" style="text-align:left; padding-left:8px; border-bottom:0.5px solid #e0e0e0;">' . htmlspecialchars($namapel) . '</td>
                  <td width="14%" valign="middle" style="text-align:center; border-bottom:0.5px solid #e0e0e0; ' . $warnakategori . '">' . $pel->kategori . '</td>
                  <td width="16%" valign="middle" style="text-align:center; border-bottom:0.5px solid #e0e0e0;">' . $statuslabel . '</td>
                  <td width="16%" valign="middle" style="text-align:center; border-bottom:0.5px solid #e0e0e0;">' . $tglgabung . '</td>
                </tr>';
      $baris++;
    }

    $tabelPelayanan .= '</tbody></table>';

    $pdf->SetFont('helvetica', '', 10);
    $pdf->writeHTML($tabelPelayanan, true, false, false, false, '');

    // ── Spacing & Garis Pemisah Antar Orang ──
    $pdf->Ln(6);
    $pdf->SetDrawColor(220, 220, 220); // Warna abu-abu sangat muda
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(6);
  }
} else {
  $kosong = '<p style="text-align:center; font-style:italic; color:#888;">Tidak ada data volunteer untuk filter yang dipilih.</p>';
  $pdf->SetFont('helvetica', '', 11);
  $pdf->writeHTML($kosong, true, false, false, false, '');
}

$pdf->Output('Laporan_Data_Volunteer_' . date('d-m-Y') . '.pdf', 'I');