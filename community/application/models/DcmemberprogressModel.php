<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DcmemberprogressModel extends CI_Model
{

    public function get_all()
    {
        $this->db->where('iddc', $this->session->userdata('iddc'));
        return $this->db->get('v_dcmember');
    }


    public function get_member_only()
    {
        $this->db->where('iddc', $this->session->userdata('iddc'));
        $this->db->where('statuskeanggotaan <>' , 'Disciples maker');
        return $this->db->get('v_dcmember');
    }

    public function get_by_id($iddcmember)
    {
        $this->db->where('iddcmember', $iddcmember);
        return $this->db->get('v_dcmember');
    }

    public function get_pertanyaan()
    {    
        $this->db->where('statusaktif', 'Aktif');
        $this->db->order_by('idkategori', 'asc');
        $this->db->order_by('tglinsert', 'asc');
        return $this->db->get('v_pertanyaanprogressdcm');
    }

    public function hapus($iddcmember)
    {
        $this->db->where('iddcmember', $iddcmember);
        return $this->db->delete('dcmember');
    }

    public function simpan($progress)
    {
        try {
            $this->db->trans_begin();
            $this->db->insert('dcmember_progress', $progress);
            $idprogress = $this->db->insert_id();

            $totalnilai = 0;
            $jumlahpertanyaan = 0;

            $detail = array();
            $rsPertanyaan = $this->DcmemberprogressModel->get_pertanyaan();
            if ($rsPertanyaan->num_rows()>0) {  
                foreach ($rsPertanyaan->result() as $row) {
                    $idpertanyaan = $row->idpertanyaan;
                    $rate = $this->input->post('rate_'.$row->idpertanyaan);
                    if (empty($rate)) {
                        $rate = 0;
                    }

                    $detail[] = array(
                        'idprogress' => $idprogress,
                        'idpertanyaan' => $row->idpertanyaan,
                        'nilai' => $rate,
                    );
                    $jumlahpertanyaan = $jumlahpertanyaan + 1;
                    $totalnilai = $totalnilai + $rate;
                }                
                $this->db->insert_batch('dcmember_progress_det', $detail);

                $ratarata = $totalnilai / $jumlahpertanyaan;
                $this->db->where('idprogress', $idprogress);
                $this->db->update('dcmember_progress', array('nilairatarata' => $ratarata));
            }
        
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

    public function update($data, $iddcmember)
    {
        $this->db->where('iddcmember', $iddcmember);
        return $this->db->update('dcmember', $data);
    }

    public function getRiwayat($iddcmember)
    {
        $this->db->where('iddcmember', $iddcmember);
        $this->db->order_by('idprogress', 'desc');
        return $this->db->get('dcmember_progress');        
    }
    
}
