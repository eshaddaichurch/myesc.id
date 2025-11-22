<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Model {

    public function update($values, $prefix)
    {
        $data = array(
            'values' => $values,
            'tglupdate' => date('Y-m-d H:i:s')
        );
        $this->db->where('prefix', $prefix);
        return $this->db->update('settings', $data);
    }

    public function getValues($prefix)
    {
        $this->db->where('prefix', $prefix);
        $rsSetting = $this->db->get('settings');
        if ($rsSetting->num_rows() > 0) {
            return $rsSetting->row()->values;
        }else{
            return '';
        }
    }

}