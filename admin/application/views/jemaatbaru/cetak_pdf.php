<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ============================================================
// VIEW CETAK PDF - Laporan Jemaat Baru
// Mengikuti pola yang sama dengan dashboard/cetakdc_pdf.php
// $this->pdf sudah tersedia di sini karena Pdf library sudah
// di-load di controller (Jemaatbaru::cetakpdf()) sebelum
// view ini dipanggil.
// ============================================================

$judulPeriode = 'Semua Periode';
if (!empty($tglMulai) && !empty($tglAkhir)) {
    $judulPeriode = 'Periode ' . formatHariTanggal($tglMulai) . ' s/d ' . formatHariTanggal($tglAkhir);
} elseif (!empty($tglMulai)) {
    $judulPeriode = 'Mulai ' . formatHariTanggal($tglMulai);
} elseif (!empty($tglAkhir)) {
    $judulPeriode = 'Sampai ' . formatHariTanggal($tglAkhir);
}

$namaGereja = !empty($rowInfoGereja->namagereja) ? $rowInfoGereja->namagereja : 'GBI El Shaddai';

$this->pdf->SetCreator('MYESC');
$this->pdf->SetAuthor($namaGereja);
$this->pdf->SetTitle('Laporan Jemaat Baru');

$this->pdf->setPrintHeader(false);
$this->pdf->setPrintFooter(false);
$this->pdf->SetMargins(10, 10, 10);
$this->pdf->AddPage('L', 'A4');  // Landscape, supaya kolom email/nohp cukup lebar

$html = '
    <h2 style="text-align:center; margin-bottom:2px;">Laporan Jemaat Baru</h2>
    <p style="text-align:center; margin-top:0;">' . htmlspecialchars($namaGereja) . ' &mdash; ' . $judulPeriode . '</p>
    <table border="1" cellpadding="4" style="font-size:10px;">
        <thead>
            <tr style="background-color:#ff5008; color:#ffffff; font-weight:bold;">
                <th width="5%">No</th>
                <th width="20%">Nama Jemaat</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="15%">Tgl Daftar</th>
                <th width="25%">Email</th>
                <th width="12%">No HP</th>
                <th width="13%">Status</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
if ($rsData && $rsData->num_rows() > 0) {
    foreach ($rsData->result() as $row) {
        $html .= '
            <tr>
                <td align="center">' . $no++ . '</td>
                <td>' . htmlspecialchars($row->namajemaat) . '</td>
                <td align="center">' . htmlspecialchars($row->jeniskelamin) . '</td>
                <td align="center">' . formatHariTanggalJam($row->tglinsert) . '</td>
                <td>' . htmlspecialchars($row->email) . '</td>
                <td align="center">' . htmlspecialchars($row->nohp) . '</td>
                <td align="center">' . htmlspecialchars($row->status) . '</td>
            </tr>';
    }
} else {
    $html .= '
            <tr>
                <td colspan="7" align="center">Tidak ada data untuk periode ini.</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
    <p style="font-size:9px; margin-top:10px;">
        Total data: ' . ($no - 1) . ' orang &mdash; Dicetak pada ' . date('d-m-Y H:i') . '
    </p>';

$this->pdf->writeHTML($html, true, false, true, false, '');
$this->pdf->Output('Laporan_Jemaat_Baru_' . date('YmdHis') . '.pdf', 'I');

/* End of file cetak_pdf.php */
/* Location: ./application/views/jemaatbaru/cetak_pdf.php */
