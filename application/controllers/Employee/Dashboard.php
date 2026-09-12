<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // $this->check_role(array('employee'));
    }

    public function index()
    {
        // $data['username'] = $this->session->userdata('username');
        // $data['role']     = $this->session->userdata('role');

        // $data['notidata'] = 'adminnoti_tour';
        // $data['innerdata'] = 'staff_home';

        $this->load->view('employee/dashboard');
    }
}