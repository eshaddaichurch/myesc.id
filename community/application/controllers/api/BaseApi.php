<?php
class BaseApi extends CI_Controller {

protected $user;

public function __construct()
{
    parent::__construct();

    $token = $this->input->get_request_header('Authorization');
    if (!$token) $this->unauthorized();

    $api = $this->db->get_where('api_key', ['key' => $token])->row();
    if (!$api) $this->unauthorized();

    $this->user = $this->db
        ->get_where('jemaat', ['idjemaat' => $api->user_id])
        ->row();

    if (!$this->user) $this->unauthorized();
}

protected function unauthorized()
{
    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}
}
