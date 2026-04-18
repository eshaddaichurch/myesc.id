<?php

/*
 * FILE: application/views/dashboard/cetakcare_excel.php
 *
 * Variabel dari controller Dashboardcare::cetak():
 *   $rowInfoGereja     - object (namagereja, alamatgereja, emailgereja)
 *   $rsJemaatBaru      - CI_DB_result
 *   $tglawal           - string Y-m-d
 *   $tglakhir          - string Y-m-d
 *   $totalJemaat       - int
 *   $totalSimpatisan   - int
 *   $totalBaptis       - int
 *   $jemaatBaruPeriode - int
 */

// Header agar browser download sebagai file Excel
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=Laporan_Care_' . $tglawal . '_sd_' . $tglakhir . '.xls');

// =========================================================
// PERIODE
// =========================================================
if ($tglawal !== $tglakhir) {
    $periodeTeks = tglindonesia($tglawal) . ' s/d ' . tglindonesia($tglakhir);
} else {
    $periodeTeks = tglindonesia($tglawal);
}

$tglCetak = date('d-m-Y H:i');
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<!-- =========================================================
     HEADER GEREJA
========================================================= -->
<table border="0" cellpadding="3">
    <tbody>
        <tr>
            <td width="200px" style="font-size:16pt; font-weight:bold;">
                <?php echo htmlspecialchars($rowInfoGereja->namagereja ?? ''); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size:10pt;">
                <?php echo htmlspecialchars($rowInfoGereja->alamatgereja ?? ''); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size:10pt;">
                Email: <?php echo htmlspecialchars($rowInfoGereja->emailgereja ?? ''); ?>
            </td>
        </tr>
    </tbody>
</table>

<br>

<!-- =========================================================
     JUDUL LAPORAN
========================================================= -->
<table border="0" cellpadding="3">
    <tbody>
        <tr>
            <td style="font-size:14pt; font-weight:bold; text-align:center;">
                LAPORAN DASHBOARD CARE
            </td>
        </tr>
    </tbody>
</table>

<br>

<!-- =========================================================
     SUMMARY
========================================================= -->
<table border="0" cellpadding="3">
    <tbody>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">PERIODE LAPORAN</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo $periodeTeks; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">TOTAL JEMAAT (SELURUH)</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo number_format($totalJemaat); ?> Orang</td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">TOTAL SIMPATISAN</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo number_format($totalSimpatisan); ?> Orang</td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">SUDAH DIBAPTIS</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo number_format($totalBaptis); ?> Orang</td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">JEMAAT BARU PERIODE INI</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo number_format($jemaatBaruPeriode); ?> Orang</td>
        </tr>
        <tr>
            <td style="font-weight:bold; font-size:10pt;">DICETAK PADA</td>
            <td style="font-size:10pt;">:</td>
            <td style="font-size:10pt;"><?php echo $tglCetak; ?></td>
        </tr>
    </tbody>
</table>

<br>

<!-- =========================================================
     TABEL DATA JEMAAT BARU
========================================================= -->
<table border="1" cellpadding="4" style="border-collapse:collapse;">
    <thead>
        <tr style="font-weight:bold; background-color:#dddddd; font-size:10pt; text-align:center;">
            <th>No</th>
            <th>Tgl Bergabung</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Umur</th>
            <th>Nama DC</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($rsJemaatBaru->num_rows() > 0): ?>
            <?php $no = 1; ?>
            <?php foreach ($rsJemaatBaru->result() as $row): ?>
                <?php $jk = ($row->jeniskelamin === 'Laki-laki') ? 'Laki-laki' : 'Perempuan'; ?>
                <tr style="font-size:10pt;">
                    <td style="text-align:center;"><?php echo $no++; ?></td>
                    <td style="text-align:center;"><?php echo tglindonesia($row->tanggalinsert); ?></td>
                    <td><?php echo htmlspecialchars($row->namalengkap); ?></td>
                    <td style="text-align:center;"><?php echo $jk; ?></td>
                    <td style="text-align:center;"><?php echo $row->umur ?? '-'; ?></td>
                    <td><?php echo htmlspecialchars($row->namadc ?? '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; font-style:italic; font-size:10pt; padding:8px;">
                    Tidak ada data jemaat baru pada periode ini.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>