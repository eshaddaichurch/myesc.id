<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Model
{
    public function sendEmailDaftar($email, $subject, $textemail)
    {
        $this->load->library('email');

        $smtp_host = 'mail.myesc.id';
        $smtp_port = '465';
        $smtp_user = 'connect@myesc.id';
        $smtp_pass = 'Elshaddaichurch1';
        $namapengirim = 'Elshaddai Church';

        $config = array();
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $smtp_host;
        $config['smtp_port'] = $smtp_port;
        $config['smtp_timeout'] = '5';
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_crypto'] = 'ssl';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $config['charset'] = 'utf-8';
        $this->email->initialize($config);

        $this->email->from($smtp_user, $namapengirim);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($textemail);

        return $this->email->send();
    }
}