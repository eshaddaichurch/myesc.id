<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permohonandoa_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carepermohonandoa');
    }

    public function getByID($idpermohonan)
    {
        $this->db->where('idpermohonan', $idpermohonan);
        return $this->db->get('v_carepermohonandoa');
    }


    public function simpan($data)
    {
        try {
            $this->db->trans_begin();

            $this->db->insert('carepermohonandoa', $data);
            $idpermohonan = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan permohonan doa.',
                        'linknotifikasi' => 'permohonandoa/proses/' . $this->encrypt->encode($idpermohonan),
                        'idlinknotifikasi' => $idpermohonan,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Permohonan Doa',
                        'idjemaatpenerima' => $row->idjemaat,
                    );                    
                
                    $this->db->insert('notifikasi', $notifikasi);                    
                }
            }


            if ($this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                $this->db->trans_rollback();
                return ['status' => false, 'message' => 'Database error: ' . $error['code'] . ' - ' . $error['message']];
            } else {
                $this->db->trans_commit();
                return ['status' => true, 'message' => 'Berhasil'];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $th->getMessage()];
        }

        
    }

    public function update($data, $idpermohonan)
    {
        $this->db->where("idpermohonan", $idpermohonan);
        return $this->db->update('carepermohonandoa', $data);
    }

    public function hapus($idpermohonan)
    {

        try {
            $this->db->trans_begin();

            $this->db->where('idpermohonan', $idpermohonan);
            $this->db->delete('carepermohonandoa');

            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idpermohonan and jenisnotifikasi = 'Permohonan Doa'
            ");

            if ($this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                $this->db->trans_rollback();
                return ['status' => false, 'message' => 'Database error: ' . $error['code'] . ' - ' . $error['message']];
            } else {
                $this->db->trans_commit();
                return ['status' => true, 'message' => 'Berhasil'];
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $th->getMessage()];
        }

        
    }
}

/* End of file Permohonandoa_model.php */
/* Location: ./application/models/Permohonandoa_model.php */