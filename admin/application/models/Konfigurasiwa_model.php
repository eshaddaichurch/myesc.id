<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfigurasiwa_model extends CI_Model {

    public function simpanWaNextStep()
    {
        // Ambil data dari POST (bukan dari parameter method)
        $nextstepregistrasi = $this->input->post('nextstepregistrasi');
        $nextstepkonfirmasi = $this->input->post('nextstepkonfirmasi');

        // Validasi dasar
        if ($nextstepregistrasi === null || $nextstepkonfirmasi === null) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            exit();
        }

        $tglinsert = date('Y-m-d H:i:s');

        try {
            $this->db->trans_begin();

            // Query 1: Registrasi
            $sql1 = "INSERT INTO settings(prefix, deskripsi, `values`, tglinsert, tglupdate, issystem)
                    VALUES('wa_nextstep_registrasi', '', ?, ?, ?, 1)
                    ON DUPLICATE KEY UPDATE `values` = ?, tglupdate = ?";
            $this->db->query($sql1, [
                $nextstepregistrasi, $tglinsert, $tglinsert,
                $nextstepregistrasi, $tglinsert
            ]);

            // Query 2: Konfirmasi
            $sql2 = "INSERT INTO settings(prefix, deskripsi, `values`, tglinsert, tglupdate, issystem)
                    VALUES('wa_nextstep_konfirmasi', '', ?, ?, ?, 1)
                    ON DUPLICATE KEY UPDATE `values` = ?, tglupdate = ?";
            $this->db->query($sql2, [
                $nextstepkonfirmasi, $tglinsert, $tglinsert,
                $nextstepkonfirmasi, $tglinsert
            ]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['success' => false]);
            } else {
                $this->db->trans_commit();
                echo json_encode(['success' => true]);
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            // Opsional: log error $e->getMessage()
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        exit(); // Pastikan tidak ada output tambahan
    }

}