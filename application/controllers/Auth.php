<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->library('form_validation');

        if ($this->session->userdata('email')) {
            redirect('user');
        }

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

                    if ($user['id_level'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
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
        $email = $this->input->post('email', true);

        $this->load->library('form_validation');

        if ($this->session->userdata('email')) {
            redirect('user');
        }

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
                'email' => htmlspecialchars($email),
                'foto' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_level' => 2,
                'status_aktifasi' => 'Tidak Aktif',
                'tanggal_dibuat' => time()
            ];

            // Siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' =>  $email,
                'token' => $token,
                'tanggal_dibuat' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_kirimEmail($token, 'verifikasi');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat! Akun kamu sudah dibuat. Silahkan aktifasi akun lewat email kamu. </div>');
            redirect('auth');
        }
    }

    private function _kirimEmail($token, $type)
    {
        $konfigurasiEmail = [
            'protocol'  =>  'smtp',
            'smtp_host' =>  'ssl://smtp.googlemail.com',
            'smtp_user' =>  'sofyanekosanjoyo@gmail.com',
            'smtp_pass' =>  'ijicnxuamwastwos',
            'smtp_port' =>  465,
            'emailtype' =>  'html',
            'charset'   =>  'utf-8',
            'newline'   =>  "\r\n"
        ];

        $this->load->library('email', $konfigurasiEmail);
        $this->email->initialize($konfigurasiEmail);
        $this->email->from('sofyanekosanjoyo@gmail.com', 'Programmer Ditjen SDA');
        $this->email->to($this->input->post('email'));


        if ($type == 'verifikasi') {
            $this->email->subject('Verifikasi Akun Sistem Login CI');
            $this->email->set_mailtype('html');
            $this->email->message('Klik link untuk memverifikasi akun : <a href="' . base_url() . 'auth/verifikasi?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktikan Akun!</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verifikasi()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['tanggal_dibuat'] < (60 * 60 * 24)) {
                    $this->db->set('status_aktifasi', 'Aktif');
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat ! Akun ' . $email . ' sudah diaktifasi. Silahkan login. </div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Token kadaluarsa! Gagal mengaktifkan akun!  </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Token salah! Gagal mengaktifkan akun! </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email salah! Gagal mengaktifkan akun! </div>');
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

    public function blokir()
    {
        $data['judul'] = 'Akses Diblokir';
        $this->load->view('auth/blokir', $data);
        $this->load->view('templates/footer');
    }
}
