<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('Login');
        }
    }

    protected function check_admin()
    {
        $this->check_login();

        if ($this->session->userdata('role') != 'admin') {
            redirect('employee/Dashboard');
        }
    }

    protected function check_employee()
    {
        $this->check_login();

        if ($this->session->userdata('role') != 'employee') {
            redirect('ga/Dashboard');
        }
    }
}