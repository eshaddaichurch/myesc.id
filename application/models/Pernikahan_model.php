<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pernikahan_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carepernikahan');
    }

    public function getByID($idpernikahan)
    {
        $this->db->where('idpernikahan', $idpernikahan);
        return $this->db->get('v_carepernikahan');
    }


    public function simpan($data)
    {
        try {
            $this->db->trans_begin();

            $this->db->insert('carepernikahan', $data);
            $idpernikahan = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan permohonan pernikahan.',
                        'linknotifikasi' => 'pernikahan/proses/' . $this->encrypt->encode($idpernikahan),
                        'idlinknotifikasi' => $idpernikahan,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Permohonan Pernikahan',
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

    public function update($data, $idpernikahan)
    {
        $this->db->where("idpernikahan", $idpernikahan);
        return $this->db->update('carepernikahan', $data);
    }

    public function hapus($idpernikahan)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idpernikahan', $idpernikahan);
            $this->db->delete('carepernikahan');

            
            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idpernikahan and jenisnotifikasi = 'Permohonan Pernikahan'
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

/* End of file Pernikahan_model.php */
/* Location: ./application/models/Pernikahan_model.php */