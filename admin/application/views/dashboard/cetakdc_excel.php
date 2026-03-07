<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan-data-dc.xls");




$table = '<h5>DATA DISCPLES COMMUNITY</h5><br>';
$table .= '<table border="1" cellpadding="5">
                <thead>
                    <tr style="font-size:12px; font-weight:bold;">
                        <th width="5%" style="text-align:center;">No</th>
                        <th width="40%" style="text-align:center;">Nama DC</th>
                        <th width="25%" style="text-align:center;">Nama DM</th>
                        <th width="15%" style="text-align:center;">Nama CT</th>
                        <th width="15%" style="text-align:center;">Jumlah Member</th>
                    </tr>
                </thead></tbody>';

$no = 1;
if ($rsDc->num_rows() > 0) {
    foreach ($rsDc->result() as $row) {
        $namaCt = '';
        $noCt = 1;
        $rsCt = $this->Dashboarddc_model->getCT($row->iddc);
        if ($rsCt->num_rows()>0) {
            foreach ($rsCt->result() as $rowCt) {
                $namaCt .= $noCt++ .'. '. $rowCt->namalengkap.', ';
            }
        }

        $jumlahMemberDc = $this->Dashboarddc_model->getJumlahMemberDc($row->iddc);

        $table .= '
                <tr style="font-size:12px;">
                        <td width="5%" style="text-align:center;">' . $no .'</td>
                        <td width="40%" style="text-align:left;">' . $row->namadc . '</td>
                        <td width="25%" style="text-align:center;">' . $row->namadm . '</td>
                        <td width="15%" style="text-align:center;">' . substr($namaCt, 0, -2) . '</td>
                        <td width="15%" style="text-align:center;">' . $jumlahMemberDc . '</td>
                    </tr>';
        $no++;
    }
}

$table .= '</tbody></table>';



if ($tglawal != $tglakhir) {
    $periode = $tglawal.' s/d '.$tglakhir;
}else{
    $periode = $tglawal;
}
$table .= '<h5>Data Member Baru Periode '.$periode.'</h5><br>';
$table .= '<table border="1" cellpadding="5">';
$table .= '
            <thead>
                <tr style="font-size:12px; font-weight:bold;">
                    <th width="5%" style="text-align:center;">No</th>
                    <th width="15%" style="text-align:center;">Tanggal</th>
                    <th width="45%" style="text-align:center;">Nama Lengkap</th>
                    <th width="10%" style="text-align:center;">Jenis Kelamin</th>
                    <th width="10%" style="text-align:center;">Umur</th>
                    <th width="15%" style="text-align:center;">Nama Dc</th>
                </tr>
            </thead></tbody>';

$no = 1;

if ($rsMemberBaru->num_rows() > 0) {
    foreach ($rsMemberBaru->result() as $row) {

        if ($row->jeniskelamin=='Laki-laki') {
            $jeniskelamin = 'L';
        }else{
            $jeniskelamin = 'P';
        }
        $table .= '
        <tr style="font-size:11px;">
            <td width="5%" style="text-align:center;">' . $no++ . '</td>
            <td width="15%" style="text-align:center;">' . tglindonesia($row->tglkonfirmasi) . '</td>
            <td width="45%" style="text-align:left;">' . $row->namalengkap . '</td>
            <td width="10%" style="text-align:center;">' . $jeniskelamin . '</td>
            <td width="10%" style="text-align:center;">' . $row->umur . '</td>
            <td width="15%" style="text-align:left;">' . $row->namadc . '</td>
        </tr>
        ';

    }

} else {
    $table .= '
                <tr>
                    <td width="100%" style="font-size:12px; text-align:center;" colspan="7">Data tidak ditemukan...</td>
                </tr>
            ';
}

$table .= ' </tbody>
            </table>';


echo $table;
