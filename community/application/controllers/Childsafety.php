<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Childsafety extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('childsafety/index');
    }
}
