<?php
class Konfirmasidc extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Konfirmasidc_api_model', 'model');
    }

    private function json($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function index()
    {
        $iddc = $this->input->get('iddc');
        if (!$iddc) return $this->json(['status'=>false,'message'=>'iddc wajib']);

        $data = $this->db->where('iddc',$iddc)
                         ->get('v_dcmember_permohonan')
                         ->result();

        return $this->json(['status'=>true,'data'=>$data]);
    }

    public function setuju()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input['idpermohonan'] ?? null;

        if (!$id) return $this->json(['status'=>false,'message'=>'idpermohonan wajib']);

        $this->db->where('idpermohonan',$id)
                 ->update('dcmember_permohonan',[
                     'statuskonfirmasi'=>'Disetujui'
                 ]);

        return $this->json(['status'=>true]);
    }
}
