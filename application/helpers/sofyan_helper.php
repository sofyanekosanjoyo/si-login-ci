<?php

function cek_akses_menu()
{
    $fungsiCI = get_instance(); // Memanggil fungsi-fungsi CI karena tidak dibentuk kelas (ini fungsi this)
    if (!$fungsiCI->session->userdata('email')) {
        redirect('auth');
    } else {
        $id_level = $fungsiCI->session->userdata('id_level');
        $menu = $fungsiCI->uri->segment(1); // Mengambil segmen menu

        $queryMenu = $fungsiCI->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $id_menu = $queryMenu['id'];

        $userAkses = $fungsiCI->db->get_where('user_access_menu', [
            'id_level' => $id_level,
            'id_menu' => $id_menu
        ]);

        if ($userAkses->num_rows() < 1) {
            redirect('auth/blokir');
        }
    }
}

function ceklis_akses($id_level, $id_menu)
{
    $fungsiCI = get_instance();

    $fungsiCI->db->where([
        'id_level' => $id_level,
        'id_menu' => $id_menu
    ]);

    $hasil = $fungsiCI->db->get('user_access_menu');

    if ($hasil->num_rows() > 0) {
        return "checked='checked'";
    }
}
