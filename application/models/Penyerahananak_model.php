<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyerahananak_model extends CI_Model
{

    public function getAll()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        return $this->db->get('v_carepenyerahananak');
    }

    public function getByID($idpenyerahananak)
    {
        $this->db->where('idpenyerahananak', $idpenyerahananak);
        return $this->db->get('v_carepenyerahananak');
    }

    public function adaPermohonanSebelumnya()
    {
        $this->db->where('idjemaat', $this->session->userdata('idjemaat'));
        $this->db->where('status', 'Permohonan');
        $jlhRow = $this->db->get('v_carepenyerahananak')->num_rows();
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

            $this->db->insert('carepenyerahananak', $data);
            $idpenyerahananak = $this->db->insert_id();

            //notifikasi
            $rsUserOtorisasi = $this->db->query("
                SELECT * FROM otorisasiuser WHERE idotorisasi = '0005'
            ");
            if ($rsUserOtorisasi->num_rows() > 0) {
                foreach ($rsUserOtorisasi->result() as $row) {

                    $notifikasi = array(
                        'tglnotifikasi' => date('Y-m-d H:i:s'),
                        'deskripsi' => ucwords(strtolower($this->session->userdata('namalengkap'))) . ', mengajukan penyerahan anak..',
                        'linknotifikasi' => 'penyerahananak/proses/' . $this->encrypt->encode($idpenyerahananak),
                        'idlinknotifikasi' => $idpenyerahananak,
                        'namajemaatpembuat' => $this->session->userdata('namalengkap'),
                        'idjemaatpembuat' => $this->session->userdata('idjemaat'),
                        'jenisnotifikasi' => 'Penyerahan Anak',
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

    public function update($data, $idpenyerahananak)
    {
        $this->db->where("idpenyerahananak", $idpenyerahananak);
        return $this->db->update('carepenyerahananak', $data);
    }

    public function hapus($idpenyerahananak)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('idpenyerahananak', $idpenyerahananak);
            $this->db->delete('carepenyerahananak');

            //hapus notifikasi
            $idjemaatpemohon = $this->session->userdata('idjemaat');
            $this->db->query("
                delete from notifikasi where idlinknotifikasi = $idpenyerahananak and jenisnotifikasi = 'Penyerahan Anak'
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

/* End of file Penyerahananak_model.php */
/* Location: ./application/models/Penyerahananak_model.php */