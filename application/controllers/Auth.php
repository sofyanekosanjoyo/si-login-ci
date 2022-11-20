<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Halaman Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_header');
        } else {
            // Pengecekan / validasi login
            $this->_login(); // Method Private
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // Jika usernya ada, ditemukan
        if ($user) {
            // Jika usernya aktif
            if ($user['status_aktifasi'] == 'Aktif') {
                // Cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'id_level' => $user['id_level']
                    ];
                    $this->session->set_userdata($data);
                    redirect('user');
                } else {
                    // Jika password salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Password salah! </div>');
                    redirect('auth');
                }
            } else {
                // Jika usernya tidak aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email belum diaktifasi! </div>');
                redirect('auth');
            }
        } else {
            // Jika usernya tidak ditemukan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email belum terdaftar! </div>');
            redirect('auth');
        }
    }

    public function registrasi()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah didaftarkan!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Registrasi User';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registrasi');
            $this->load->view('templates/auth_header');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'foto' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_level' => 2,
                'status_aktifasi' => 'Aktif',
                'tanggal_dibuat' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat! Akun kamu sudah dibuat. Silahkan login. </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_level');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Kamu sudah keluar! </div>');
        redirect('auth');
    }
}
