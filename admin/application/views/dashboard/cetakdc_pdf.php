<?php

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {

        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $this->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        //$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default header data
        $cop = '';

        // $this->writeHTML($cop, true, false, false, false, '');
        // // set margins
        // $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        // set default header data

    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->AddPage();

$titleHalaman = '<table cellpadding="5">
            <tbody>
                <tr style="font-weight: bold;">
                    <td width="10%" style="text-align: center;"><img src="' . base_url('images/icon.png') . '" alt="" width="55px;"></td>
                    <td width="80%" style="text-align: left;"><span style="font-size: 20px;">'.$rowInfoGereja->namagereja.'</span>
                        <br><span style="font-size: 12px;">'.$rowInfoGereja->alamatgereja.'</span>
                        <br><span style="font-size: 12px;">Email: '.$rowInfoGereja->emailgereja.'</span>
                    </td>
                </tr>   
            </tbody>
            </table>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($titleHalaman, true, false, false, false, '');
$pdf->SetTopMargin(0);


$title = '<h3 style="text-align: center;">DISCIPLES COMMUNITY REPORT</h3>';

$pdf->SetFont('times', '', 16);
$pdf->writeHTML($title, true, false, false, false, '');


$subTitle .= '<br><br><table border="0" cellpadding="5">
                <thead>
                    <tr style="font-size:12px; font-weight:bold;">
                        <th width="25%" style="text-align:left;">JUMLAH DC</th>
                        <th width="5%" style="text-align:center;">:</th>
                        <th width="70%" style="text-align:left;">' . $jumlahDc . ' DC</th>                        
                    </tr>
                    <tr style="font-size:12px; font-weight:bold;">
                        <th width="25%" style="text-align:left;">JUMLAH MEMBER</th>
                        <th width="5%" style="text-align:center;">:</th>
                        <th width="70%" style="text-align:left;">' . $jumlahMember .  ' Orang</th>
                    </tr>
                </thead>
            </table>
';

$pdf->SetFont('times', '', 11);
$pdf->writeHTML($subTitle, true, false, false, false, 'R');


$tabelDc = '<h5>DATA DISCPLES COMMUNITY</h5><br>';
$tabelDc .= '<table border="1" cellpadding="5">
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

        $tabelDc .= '
                <tr style="font-size:12px;">
                        <td width="5%" style="text-align:center;">' . $no++ .'</td>
                        <td width="40%" style="text-align:left;">' . $row->namadc . '</td>
                        <td width="25%" style="text-align:center;">' . $row->namadm . '</td>
                        <td width="15%" style="text-align:center;">' . substr($namaCt, 0, -2) . '</td>
                        <td width="15%" style="text-align:center;">' . $jumlahMemberDc . '</td>
                    </tr>';
        $no++;
    }
}

$tabelDc .= '</tbody></table>';

$pdf->writeHTML($tabelDc, true, false, false, false, '');



if ($tglawal != $tglakhir) {
    $periode = $tglawal.' s/d '.$tglakhir;
}else{
    $periode = $tglawal;
}
$table = '<h5>Data Member Baru Periode '.$periode.'</h5><br>';
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

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

$tglcetak = date('d-m-Y');

$pdf->Output();
