<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfirmasidc_model extends CI_Model
{

    public function getDC($iddc)
    {
        return $this->db->get_where('v_disciplescommunity', array('iddc' => $iddc));
    }

    public function getPermohonanID($idpermohonan)
    {
        $this->db->where('idpermohonan', $idpermohonan);
        return $this->db->get('v_dcmember_permohonan');
    }

    public function getPermohonan()
    {
        $this->db->where('iddc', $this->session->userdata('iddc'));
        return $this->db->get('v_dcmember_permohonan');
    }

    public function getDcMemberAktif($idjemaat)
    {
        $this->db->where('idjemaat', $idjemaat);
        $this->db->where('statusaktif', 'Aktif');
        return $this->db->get('v_dcmember');
    }

    public function setuju($idjemaat, $idpermohonan, $rowPermohonan, $idjemaatKonfirmasi = null)
    {
        try {
            $this->db->trans_begin();
            
            // ✅ Validasi idjemaatKonfirmasi
            if (empty($idjemaatKonfirmasi) || $idjemaatKonfirmasi === 'API_DEFAULT') {
                log_message('warning', 'idjemaatKonfirmasi tidak valid atau default: ' . $idjemaatKonfirmasi);
                // Gunakan nilai default yang lebih baik
                $idjemaatKonfirmasi = 'SYSTEM';
            }
            
            // ✅ LOG untuk debugging
            log_message('info', 'Menyimpan dengan idjemaatkonfirmasi: ' . $idjemaatKonfirmasi);
            
            $iddcmember = $this->db->query("select create_iddcmember('" . $this->session->userdata('iddc') . "') as iddcmember")->row()->iddcmember;
            $arrData = array(
                'iddcmember' => $iddcmember,
                'iddc' => $this->session->userdata('iddc'),
                'idjemaat' => $idjemaat,
                'statuskeanggotaan' => 'Anggota',
                'tanggalinsert' => date('Y-m-d H:i:s'),
                'tanggalupdate' => date('Y-m-d H:i:s'),
                'idjemaatupdate' => $idjemaatKonfirmasi,
                'idpermohonan' => $idpermohonan,
            );
            $this->db->insert('dcmember', $arrData);

            $arrKonfirmasi = array(
                'statuskonfirmasi' => 'Disetujui',
                'keterangankonfirmasi' => null,
                'tglkonfirmasi' => date('Y-m-d H:i:s'),
                'idjemaatkonfirmasi' => $idjemaatKonfirmasi,
            );
            $this->db->where('idpermohonan', $idpermohonan);
            $this->db->update('dcmember_permohonan', $arrKonfirmasi);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', 'Transaksi setuju gagal');
                return false;
            } else {
                $this->db->trans_commit();
                log_message('info', 'Transaksi setuju berhasil');
                return true;
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            log_message('error', 'Exception setuju: ' . $th->getMessage());
            return false;
        }
    }

    public function tolak($idpermohonan, $alasan, $idjemaatKonfirmasi = null)
    {
        try {
            $this->db->trans_begin();
            
            // ✅ Jika tidak ada idjemaatKonfirmasi dari parameter, gunakan dari session
            if ($idjemaatKonfirmasi === null) {
                $idjemaatKonfirmasi = $this->session->userdata('idjemaat') ?? 'DEFAULT_ADMIN';
            }
            
            $this->db->query("delete from dcmember where idpermohonan=$idpermohonan");

            $arrKonfirmasi = array(
                'statuskonfirmasi' => 'Ditolak',
                'keterangankonfirmasi' => $alasan,
                'tglkonfirmasi' => date('Y-m-d H:i:s'),
                'idjemaatkonfirmasi' => $idjemaatKonfirmasi, // ✅ GUNAKAN PARAMETER INI
            );
            $this->db->where('idpermohonan', $idpermohonan);
            $this->db->update('dcmember_permohonan', $arrKonfirmasi);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return false;
        }
    }
}