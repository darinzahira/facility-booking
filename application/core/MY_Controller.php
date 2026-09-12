<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    protected function check_role($roles = array())
    {
        $user_role = $this->session->userdata('role');

        if (!in_array($user_role, $roles)) {
            show_error(
                'Anda tidak memiliki akses ke halaman ini.',
                403,
                'Access Denied'
            );
        }
    }
}