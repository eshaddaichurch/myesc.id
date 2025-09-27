<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kunjunganjemaat_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carekunjunganjemaat');
    }

    public function getByID($idkunjunganjemaat)
    {
        $this->db->where('idkunjunganjemaat', $idkunjunganjemaat);
        return $this->db->get('v_carekunjunganjemaat');
    }


    public function simpan($data)
    {
        try {
            $this->db->trans_begin();

            
            $this->db->insert('carekunjunganjemaat', $data);
            $idkunjunganjemaat = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan permohonan kunjungan jemaat.',
                        'linknotifikasi' => 'kunjunganjemaat/proses/' . $this->encrypt->encode($idkunjunganjemaat),
                        'idlinknotifikasi' => $idkunjunganjemaat,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Kunjungan Jemaat',
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

    public function update($data, $idkunjunganjemaat)
    {
        $this->db->where("idkunjunganjemaat", $idkunjunganjemaat);
        return $this->db->update('carekunjunganjemaat', $data);
    }

    public function hapus($idkunjunganjemaat)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idkunjunganjemaat', $idkunjunganjemaat);
            $this->db->delete('carekunjunganjemaat');

            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idkunjunganjemaat and jenisnotifikasi = 'Kunjungan Jemaat'
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

/* End of file Kunjunganjemaat_model.php */
/* Location: ./application/models/Kunjunganjemaat_model.php */