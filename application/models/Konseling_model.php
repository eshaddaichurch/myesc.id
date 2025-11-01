<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konseling_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carekonseling');
    }

    public function getByID($idcarekonseling)
    {
        $this->db->where('idcarekonseling', $idcarekonseling);
        return $this->db->get('v_carekonseling');
    }

    public function adaPermohonanSebelumnya()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        $this->db->where('status', 'Permohonan');
        $jlhRow = $this->db->get('v_carekonseling')->num_rows();
        if ($jlhRow > 0) {
            return true;
        }else{
            return false;
        }
    }


    public function simpan($data)
    {
        try {
            $this->db->trans_begin();

            $this->db->insert('carekonseling', $data);
            $idcarekonseling = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan permohonan konseling.',
                        'linknotifikasi' => 'konseling/proses/' . $this->encrypt->encode($idcarekonseling),
                        'idlinknotifikasi' => $idcarekonseling,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Konseling',
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

    public function update($data, $idcarekonseling)
    {
        $this->db->where("idcarekonseling", $idcarekonseling);
        return $this->db->update('carekonseling', $data);
    }

    public function hapus($idcarekonseling)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idcarekonseling', $idcarekonseling);
            $this->db->delete('carekonseling');

            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idcarekonseling and jenisnotifikasi = 'Konseling'
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

/* End of file Konseling_model.php */
/* Location: ./application/models/Konseling_model.php */