<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->check_admin();
    }

    public function index()
    {
    
        $data['innerdata'] = 'ga/dashboard';
		$this->load->view('ga/template', $data);

    }
}