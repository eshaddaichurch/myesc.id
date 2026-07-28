<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ============================================================
// VIEW CETAK PDF - Laporan Jemaat Baru
// Desain mengikuti pola dashboard/cetakdc_anggota_pdf.php,
// dengan skema warna oranye (brand ESC) sebagai satu-satunya
// perbedaan dari referensi tersebut.
//
// Class MYPDF dibuat langsung di sini (sama seperti pola aslinya),
// dibungkus class_exists() supaya aman kalau suatu saat view PDF
// lain yang juga mendefinisikan MYPDF ikut ter-load di request yang sama.
// ============================================================

if (!class_exists('MYPDF')) {
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
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('MYESC');
$pdf->SetTitle('Laporan Jemaat Baru');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// ── HEADER GEREJA ──────────────────────────────────────────
$namaGereja = !empty($rowInfoGereja->namagereja) ? $rowInfoGereja->namagereja : 'GBI El Shaddai';
$alamatGereja = !empty($rowInfoGereja->alamatgereja) ? $rowInfoGereja->alamatgereja : '';
$emailGereja = !empty($rowInfoGereja->emailgereja) ? $rowInfoGereja->emailgereja : '';

$titleHalaman = '
<table cellpadding="5">
  <tbody>
    <tr>
      <td width="10%" style="text-align:center;">
        <img src="' . base_url('images/icon.png') . '" alt="" width="55px;">
      </td>
      <td width="90%" style="text-align:left;">
        <span style="font-size:20px; font-weight:bold;">' . htmlspecialchars($namaGereja) . '</span><br>
        <span style="font-size:12px;">' . htmlspecialchars($alamatGereja) . '</span><br>
        <span style="font-size:12px;">Email: ' . htmlspecialchars($emailGereja) . '</span>
      </td>
    </tr>
  </tbody>
</table>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');
$pdf->SetTopMargin(0);

// ── JUDUL ──────────────────────────────────────────────────
$judul = '<h3 style="text-align:center;">LAPORAN JEMAAT BARU</h3>';
$pdf->SetFont('times', 'B', 14);
$pdf->writeHTML($judul, true, false, false, false, '');

// ── RINGKASAN + INFO FILTER ────────────────────────────────
$judulPeriode = 'Semua Periode';
if (!empty($tglMulai) && !empty($tglAkhir)) {
    $judulPeriode = formatHariTanggal($tglMulai) . ' s/d ' . formatHariTanggal($tglAkhir);
} elseif (!empty($tglMulai)) {
    $judulPeriode = 'Mulai ' . formatHariTanggal($tglMulai);
} elseif (!empty($tglAkhir)) {
    $judulPeriode = 'Sampai ' . formatHariTanggal($tglAkhir);
}

$jumlahData = ($rsData) ? $rsData->num_rows() : 0;

$ringkasan = '
<table border="0" cellpadding="3">
  <tr style="font-size:11px;">
    <td width="22%">Total Jemaat Baru</td>
    <td width="3%">:</td>
    <td><b>' . $jumlahData . ' Orang</b></td>
  </tr>
  <tr style="font-size:11px;">
    <td>Periode</td>
    <td>:</td>
    <td>' . $judulPeriode . '</td>
  </tr>
  <tr style="font-size:11px;">
    <td>Tanggal Cetak</td>
    <td>:</td>
    <td>' . date('d-m-Y H:i:s') . '</td>
  </tr>
</table><br>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($ringkasan, true, false, false, false, '');

// ── TABEL DATA JEMAAT BARU (skema warna oranye, brand ESC) ─
$tabelData = '
    <table border="1" cellpadding="4">
      <thead>
        <tr style="font-size:10px; font-weight:bold; color:#ffffff; background-color:#ff5008;">
          <th width="5%"  style="text-align:center;">No</th>
          <th width="25%" style="text-align:center;">Nama Jemaat</th>
          <th width="10%" style="text-align:center;">JK</th>
          <th width="15%" style="text-align:center;">Tgl Daftar</th>
          <th width="27%" style="text-align:center;">Email</th>
          <th width="18%" style="text-align:center;">Status</th>
        </tr>
      </thead>
      <tbody>';

if ($jumlahData > 0) {
    $no = 1;
    foreach ($rsData->result() as $row) {
        $bgBaris = ($no % 2 == 0) ? 'background-color:#fff3ee;' : '';
        $jk = ($row->jeniskelamin == 'Laki-laki') ? 'L' : 'P';

        $tabelData .= '
            <tr style="font-size:10px; ' . $bgBaris . '">
              <td width="5%"  style="text-align:center;">' . $no++ . '</td>
              <td width="25%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($row->namajemaat) . '</td>
              <td width="10%" style="text-align:center;">' . $jk . '</td>
              <td width="15%" style="text-align:center;">' . formatHariTanggalJam($row->tglinsert) . '</td>
              <td width="27%" style="text-align:left; padding-left:5px;">' . htmlspecialchars($row->email) . '</td>
              <td width="18%" style="text-align:center;">' . htmlspecialchars($row->status) . '</td>
            </tr>';
    }
} else {
    $tabelData .= '
        <tr>
          <td colspan="6" style="font-size:10px; text-align:center; font-style:italic; color:#888; padding:8px;">
            Tidak ada data untuk periode ini.
          </td>
        </tr>';
}

$tabelData .= '</tbody></table>';

$pdf->SetFont('times', '', 10);
$pdf->writeHTML($tabelData, true, false, false, false, '');

$pdf->Output('Laporan_Jemaat_Baru_' . date('d-m-Y') . '.pdf', 'I');

/* End of file cetak_pdf.php */
/* Location: ./application/views/jemaatbaru/cetak_pdf.php */
