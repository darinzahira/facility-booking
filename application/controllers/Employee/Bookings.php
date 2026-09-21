<?php

class Bookings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Pastikan user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Pastikan hanya employee
        if ($this->session->userdata('role') != 'employee') {
            show_error(
                'Anda tidak memiliki akses ke halaman ini.',
                403,
                'Access Denied'
            );
        }

        $this->load->model('Booking_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $employee_id = $this->session->userdata('employee_id');
        $data['bookings'] = $this->Booking_model->get_by_employee($employee_id);
        $data['innerdata'] = 'employee/booking_list';
        $this->load->view('employee/template', $data);
    }

    public function detail($id)
    {
        $employee_id = $this->session->userdata('employee_id');
        $data['booking'] = $this->Booking_model->get_detail($id, $employee_id);

        // Kalau booking tidak ditemukan
        if (!$data['booking']) {
            show_404();
        }

        $data['innerdata'] = 'employee/booking_detail';

        $this->load->view('employee/template', $data);
    }

    public function add()
    {
        $data['innerdata'] = 'employee/booking_add';
        $this->load->view('employee/template',$data);
    }


    public function store()
    {
        $this->form_validation->set_rules('facility_type', 'Fasilitas', 'required');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('end_date', 'Tanggal Selesai', 'required');
        $this->form_validation->set_rules('purpose', 'Keperluan', 'required');
        $this->form_validation->set_message('required','{field} wajib diisi.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['innerdata'] = 'employee/booking_add';
            $this->load->view('employee/template', $data);
            return;
        }

        // Employee yang sedang login
        $employee_id = $this->session->userdata('employee_id');

        // Data booking
        $data = array(
            'booking_code'    => 'BK-' . date('YmdHis'),
            'employee_id'     => $employee_id,
            'facility_type'   => $this->input->post('facility_type'),
            'vehicle_id'      => NULL,
            'room_id'         => NULL,
            'meeting_room_id' => NULL,
            'driver_id'       => NULL,
            'start_date'      => $this->input->post('start_date'),
            'end_date'        => $this->input->post('end_date'),
            'start_time'      => $this->input->post('start_time') ?: NULL,
            'end_time'        => $this->input->post('end_time') ?: NULL,
            'purpose'         => $this->input->post('purpose'),
            'status'          => 'pending',
            'notes'           => NULL,
            'rejection_reason'=> NULL,
            'approved_by'     => NULL,
            'approved_at'     => NULL,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => NULL
        );

        $result = $this->Booking_model->store($data);

        if ($result)
        {
            $this->session->set_flashdata(
                'success',
                'Pengajuan peminjaman berhasil dibuat.'
            );
        }
        else
        {
            $this->session->set_flashdata(
                'error',
                'Pengajuan peminjaman gagal dibuat.'
            );
        }

        redirect(base_url() . 'employee/Bookings');
    }
}