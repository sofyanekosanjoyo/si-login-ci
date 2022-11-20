<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function index()
    {
        $data['judul'] = 'Manajemen Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Menu baru berhasil ditambahkan! </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['judul'] = 'Manajemen Submenu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $this->load->model('Menu_model', 'menu'); // Pengunaan alias
        $this->load->model('Menu_model');

        $data['subMenu'] = $this->Menu_model->getSubmenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('id_menu', 'IdMenu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'judul' => $this->input->post('judul'),
                'id_menu' => $this->input->post('id_menu'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'status_aktifasi' => $this->input->post('status_aktifasi')
            ];

            $this->db->insert('user_submenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Submenu baru berhasil ditambahkan! </div>');
            redirect('menu/submenu');
        }
    }
}
