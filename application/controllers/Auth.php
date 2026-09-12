<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            if ($user->role == 'employee') {
            redirect('employee/dashboard');
            }

            if ($user->role == 'ga') {
                redirect('ga/dashboard');
            }

            if ($user->role == 'admin') {
                redirect('admin/dashboard');
            }
        }

        $this->load->view('auth/login');
    }

    public function login()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata(
                'error',
                'Username atau password salah.'
            );

            redirect('auth');
        }

        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata(
                'error',
                'Username atau password salah.'
            );

            redirect('auth');
        }

        $session_data = array(
            'user_id'     => $user->id,
            'employee_id' => $user->employee_id,
            'username'    => $user->username,
            'role'        => $user->role,
            'logged_in'   => TRUE
        );

        $this->session->set_userdata($session_data);

        $this->db
            ->where('id', $user->id)
            ->update('users', array(
                'last_login' => date('Y-m-d H:i:s')
            ));

        if ($this->session->userdata('logged_in')) {
            if ($user->role == 'employee') {
            redirect('employee/dashboard');
            }

            if ($user->role == 'ga') {
                redirect('ga/dashboard');
            }

            if ($user->role == 'admin') {
                redirect('admin/dashboard');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('auth');
    }
}