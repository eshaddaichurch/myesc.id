<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Baptisan_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carebaptisan');
    }

    public function getByID($idcarebaptisan)
    {
        $this->db->where('idcarebaptisan', $idcarebaptisan);
        return $this->db->get('v_carebaptisan');
    }


    public function simpan($data)
    {
        try {
            $this->db->trans_begin();

            $this->db->insert('carebaptisan', $data);            
            $idcarebaptisan = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan permohonan baptisan.',
                        'linknotifikasi' => 'baptisan/proses/' . $this->encrypt->encode($idcarebaptisan),
                        'idlinknotifikasi' => $idcarebaptisan,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Permohonan Baptisan',
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

    public function update($data, $idcarebaptisan)
    {
        $this->db->where("idcarebaptisan", $idcarebaptisan);
        return $this->db->update('carebaptisan', $data);
    }

    public function hapus($idcarebaptisan)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idcarebaptisan', $idcarebaptisan);
            $this->db->delete('carebaptisan');

            
            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idcarebaptisan and jenisnotifikasi = 'Permohonan Baptisan'
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

/* End of file Baptisan_model.php */
/* Location: ./application/models/Baptisan_model.php */