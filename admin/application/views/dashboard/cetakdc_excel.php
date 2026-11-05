<?php
/*
 * Variabel dari Dashboarddc::cetakexcel():
 *   $mulai, $akhir, $rekapDc (array), $memberBaru (array)
 */
$periode = ($mulai !== $akhir)
    ? tglindonesia($mulai) . ' s/d ' . tglindonesia($akhir)
    : tglindonesia($mulai);
?>
<html>
<head><meta charset="UTF-8"></head>
<body>

<h3>DATA DISCIPLES COMMUNITY</h3>
<table border="1" cellpadding="5">
    <thead>
        <tr style="font-weight:bold;">
            <th>No</th>
            <th>Nama DC</th>
            <th>Nama DM</th>
            <th>Nama CT</th>
            <th>Jumlah Member</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rekapDc as $dc): ?>
        <tr>
            <td style="text-align:center;"><?= $no++ ?></td>
            <td><?= htmlspecialchars($dc['nama']) ?></td>
            <td><?= htmlspecialchars($dc['dm']) ?></td>
            <td><?= htmlspecialchars(!empty($dc['ct']) ? implode(', ', $dc['ct']) : '-') ?></td>
            <td style="text-align:center;"><?= (int) $dc['jumlah'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<h3>Data Member Baru Periode <?= $periode ?></h3>
<table border="1" cellpadding="5">
    <thead>
        <tr style="font-weight:bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Umur</th>
            <th>Nama DC</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($memberBaru)): ?>
        <tr>
            <td colspan="6" style="text-align:center;">Data tidak ditemukan...</td>
        </tr>
        <?php else: $no = 1; foreach ($memberBaru as $r): ?>
        <tr>
            <td style="text-align:center;"><?= $no++ ?></td>
            <td style="text-align:center;"><?= tglindonesia($r['tglkonfirmasi']) ?></td>
            <td><?= htmlspecialchars((string) ($r['namalengkap'] ?? '-')) ?></td>
            <td style="text-align:center;"><?= ($r['jeniskelamin'] ?? '') === 'Laki-laki' ? 'L' : 'P' ?></td>
            <td style="text-align:center;"><?= htmlspecialchars((string) ($r['umur'] ?? '-')) ?></td>
            <td><?= htmlspecialchars((string) ($r['namadc'] ?? '-')) ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
<p>Total Member Baru: <?= count($memberBaru) ?></p>

</body>
</html>