<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubmenu()
    {
        $query = "SELECT `user_submenu`.*, `user_menu`.`menu`
                    FROM `user_submenu` JOIN `user_menu`
                      ON `user_submenu`.`id_menu` = `user_menu`.`id`
                ";

        return $this->db->query($query)->result_array();
    }
}
