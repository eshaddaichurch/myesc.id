<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MYPDF extends TCPDF
{
    // Page header
    public function Header()
    {
        $this->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
    }

    // Page footer
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// ===== Buat PDF =====
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('El Shaddai Church');
$pdf->SetAuthor('System');
$pdf->SetTitle('Laporan Member Baru DC');
$pdf->SetPrintHeader(false);  // FIX: Nonaktifkan header default TCPDF agar tidak overlap
$pdf->SetPrintFooter(true);
$pdf->SetMargins(15, 15, 15);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 25);

$pdf->AddPage();
$pdf->SetFont('times', '', 12);

// ===== HEADER GEREJA =====
$logoPath = base_url('images/icon.png');
$namaGereja = isset($rowInfoGereja->namagereja) ? $rowInfoGereja->namagereja : '-';
$alamatGereja = isset($rowInfoGereja->alamatgereja) ? $rowInfoGereja->alamatgereja : '-';
$emailGereja = isset($rowInfoGereja->emailgereja) ? $rowInfoGereja->emailgereja : '-';

$titleHalaman = '
<table cellpadding="5">
    <tbody>
        <tr>
            <td width="12%" style="text-align:center; vertical-align:middle;">
                <img src="' . $logoPath . '" alt="Logo" width="55">
            </td>
            <td width="88%" style="text-align:left; vertical-align:middle;">
                <span style="font-size:18px; font-weight:bold;">' . $namaGereja . '</span><br>
                <span style="font-size:11px;">' . $alamatGereja . '</span><br>
                <span style="font-size:11px;">Email: ' . $emailGereja . '</span>
            </td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($titleHalaman, true, false, false, false, '');

// Garis pemisah
$pdf->SetLineWidth(0.5);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(3);

// ===== JUDUL LAPORAN =====
$pdf->SetFont('times', 'B', 14);
$pdf->Cell(0, 8, 'LAPORAN MEMBER BARU DISCIPLES COMMUNITY', 0, 1, 'C');
$pdf->Ln(2);

// ===== INFO RINGKAS =====
// FIX: Inisialisasi $subTitle dengan = bukan .= agar tidak PHP Warning
$subTitle = '
<table border="0" cellpadding="4">
    <tbody>
        <tr style="font-size:11px;">
            <td width="25%"><b>Jumlah DC</b></td>
            <td width="5%" style="text-align:center;">:</td>
            <td width="70%">' . (isset($jumlahDc) ? $jumlahDc : 0) . ' DC</td>
        </tr>
        <tr style="font-size:11px;">
            <td width="25%"><b>Jumlah Member</b></td>
            <td width="5%" style="text-align:center;">:</td>
            <td width="70%">' . (isset($jumlahMember) ? $jumlahMember : 0) . ' Orang</td>
        </tr>
    </tbody>
</table>';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($subTitle, true, false, false, false, '');
$pdf->Ln(2);

// Garis pemisah
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(4);

// ===== FORMAT PERIODE =====
// FIX: Gunakan tglindonesia() agar format tanggal konsisten
if (function_exists('tglindonesia')) {
    $periodeAwal = tglindonesia($tglawal);
    $periodeAkhir = tglindonesia($tglakhir);
} else {
    // Fallback manual jika helper tidak tersedia
    $periodeAwal = date('d-m-Y', strtotime($tglawal));
    $periodeAkhir = date('d-m-Y', strtotime($tglakhir));
}

$periode = ($tglawal != $tglakhir)
    ? $periodeAwal . ' s/d ' . $periodeAkhir
    : $periodeAwal;

// ===== TABEL MEMBER BARU =====
// FIX: Tabel DC dihapus — hanya tampilkan member baru sesuai permintaan
$pdf->SetFont('times', 'B', 11);
$pdf->Cell(0, 7, 'Data Member Baru Periode: ' . $periode, 0, 1, 'L');
$pdf->Ln(2);

$table = '<table border="1" cellpadding="4">';
$table .= '
    <thead>
        <tr style="font-size:11px; font-weight:bold; background-color:#f0f0f0;">
            <th width="5%"  style="text-align:center;">No</th>
            <th width="15%" style="text-align:center;">Tanggal</th>
            <th width="40%" style="text-align:center;">Nama Lengkap</th>
            <th width="10%" style="text-align:center;">JK</th>
            <th width="10%" style="text-align:center;">Umur</th>
            <th width="20%" style="text-align:center;">Nama DC</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;

if (isset($rsMemberBaru) && $rsMemberBaru->num_rows() > 0) {
    foreach ($rsMemberBaru->result() as $row) {
        $jk = (isset($row->jeniskelamin) && $row->jeniskelamin == 'Laki-laki') ? 'L' : 'P';

        // FIX: Gunakan tglindonesia() dengan fallback
        $tglKonfirmasi = '';
        if (!empty($row->tglkonfirmasi)) {
            $tglKonfirmasi = function_exists('tglindonesia')
                ? tglindonesia($row->tglkonfirmasi)
                : date('d-m-Y', strtotime($row->tglkonfirmasi));
        }

        $namaLengkap = isset($row->namalengkap) ? htmlspecialchars($row->namalengkap) : '-';
        $umur = isset($row->umur) ? $row->umur : '-';
        $namaDc = isset($row->namadc) ? htmlspecialchars($row->namadc) : '-';

        // Warna baris selang-seling
        $bgColor = ($no % 2 === 0) ? 'background-color:#f9f9f9;' : '';

        $table .= '
        <tr style="font-size:10px; ' . $bgColor . '">
            <td width="5%"  style="text-align:center;">' . $no++ . '</td>
            <td width="15%" style="text-align:center;">' . $tglKonfirmasi . '</td>
            <td width="40%" style="text-align:left;">' . $namaLengkap . '</td>
            <td width="10%" style="text-align:center;">' . $jk . '</td>
            <td width="10%" style="text-align:center;">' . $umur . '</td>
            <td width="20%" style="text-align:left;">' . $namaDc . '</td>
        </tr>';
    }
} else {
    $table .= '
        <tr>
            <td colspan="6" style="font-size:11px; text-align:center; padding:8px;">
                Data tidak ditemukan untuk periode ini.
            </td>
        </tr>';
}

$table .= '</tbody></table>';

$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

// ===== TOTAL =====
$totalMember = isset($rsMemberBaru) ? $rsMemberBaru->num_rows() : 0;
$pdf->Ln(3);
$pdf->SetFont('times', 'B', 10);
$pdf->Cell(0, 6, 'Total Member Baru: ' . $totalMember . ' Orang', 0, 1, 'R');

// ===== TANDA TANGAN =====
$pdf->Ln(10);
$tglCetak = function_exists('tglindonesia') ? tglindonesia(date('Y-m-d')) : date('d-m-Y');
$pdf->SetFont('times', '', 10);
$pdf->Cell(0, 5, 'Dicetak pada: ' . $tglCetak, 0, 1, 'R');

// ===== OUTPUT =====
$pdf->Output('laporan_member_baru_dc_' . date('Ymd') . '.pdf', 'I');
