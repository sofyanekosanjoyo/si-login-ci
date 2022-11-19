<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/login');
        $this->load->view('templates/auth_header');
    }

    public function registrasi()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/registrasi');
        $this->load->view('templates/auth_header');
    }
}
