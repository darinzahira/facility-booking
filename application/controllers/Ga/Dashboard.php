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
    
        $data['innerdata'] = 'ga/dashboard';
		$this->load->view('ga/template', $data);

    }
}