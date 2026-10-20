<?php

class Bookings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Pastikan user sudah login
        $this->check_employee();

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

    public function cancel($id)
    {
        $employee_id = $this->session->userdata('employee_id');

        // Ambil booking milik employee yang sedang login
        $booking = $this->Booking_model->get_detail($id, $employee_id);

        // Kalau booking tidak ditemukan
        if (!$booking) {
            show_404();
        }

        // Hanya booking pending dan approved yang bisa dibatalkan
        if ($booking->status != 'pending' && $booking->status != 'approved') {

            $this->session->set_flashdata(
                'error',
                'Booking ini tidak dapat dibatalkan.'
            );

            redirect('employee/Bookings/detail/' . $id);
            return;
        }

        $data = array(
            'status'     => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        );

        $result = $this->Booking_model->update_status($id, $data);

        if ($result) {

            $this->session->set_flashdata(
                'success',
                'Booking berhasil dibatalkan.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Booking gagal dibatalkan.'
            );
        }

        redirect('employee/Bookings/detail/' . $id);
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
        $this->form_validation->set_rules('start_time','Jam Mulai','required');
        $this->form_validation->set_rules('end_time','Jam Selesai','required');
        $this->form_validation->set_rules('purpose', 'Keperluan', 'required');
        $this->form_validation->set_rules('participant_count', 'Jumlah Orang', 'required');
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
            'participant_count' => (int) $this->input->post('participant_count'),
            'notes'           => NULL,
            'rejection_reason'=> NULL,
            'approved_by'     => NULL,
            'approved_at'     => NULL,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => NULL
        );

        $result = $this->Booking_model->store_employee($data);

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Pengajuan peminjaman berhasil dibuat.'
            );
        } else {
            $this->session->set_flashdata('error', $result);
        }

        redirect('employee/Bookings');
    }

    
    public function edit()
    {
        $id = $this->uri->segment(4);
        $employee_id = $this->session->userdata('employee_id');
        $data['editdata'] = $this->Booking_model->get_detail($id, $employee_id);
        $data['innerdata'] = 'employee/booking_edit';
        $this->load->view('employee/template', $data);
    }

    public function update($id)
    {
        $employee_id = $this->session->userdata('employee_id');

        // Pastikan booking milik karyawan ini dan masih pending
        $booking = $this->Booking_model->get_detail($id, $employee_id);

        if (!$booking) {
            show_404();
            return;
        }

        if ($booking->status != 'pending') {
            $this->session->set_flashdata(
                'error',
                'Hanya booking berstatus pending yang dapat diedit.'
            );
            redirect('employee/Bookings');
            return;
        }

        // Validasi form
        $this->form_validation->set_rules(
            'facility_type',
            'Fasilitas',
            'required|in_list[vehicle,room,meeting_room]'
        );

        $this->form_validation->set_rules(
            'start_date',
            'Tanggal Mulai',
            'required'
        );

        $this->form_validation->set_rules(
            'end_date',
            'Tanggal Selesai',
            'required'
        );

        $this->form_validation->set_rules(
            'start_time',
            'Jam Mulai',
            'required'
        );

        $this->form_validation->set_rules(
            'end_time',
            'Jam Selesai',
            'required'
        );

        $this->form_validation->set_rules(
            'purpose',
            'Keperluan',
            'required|trim'
        );

        $this->form_validation->set_rules(
            'participant_count',
            'Jumlah Peserta',
            'required|integer|greater_than[0]'
        );

        $this->form_validation->set_message(
            'required',
            '{field} wajib diisi.'
        );

        $this->form_validation->set_message(
            'in_list',
            'Pilihan {field} tidak valid.'
        );

        $this->form_validation->set_message(
            'integer',
            '{field} harus berupa bilangan bulat.'
        );

        $this->form_validation->set_message(
            'greater_than',
            '{field} minimal 1 orang.'
        );

        if ($this->form_validation->run() == FALSE) {
            // Kembalikan ke form edit beserta data booking
            $data['editdata'] = $booking;

            $data['innerdata'] = 'employee/booking_edit';

            $this->load->view('employee/template', $data);
            return;
        }

        // Data yang boleh diubah oleh karyawan
        $update_data = array(
            'facility_type' => $this->input->post('facility_type', TRUE),
            'start_date' => $this->input->post('start_date', TRUE),
            'end_date' => $this->input->post('end_date', TRUE),
            'start_time' => $this->input->post('start_time', TRUE),
            'end_time' => $this->input->post('end_time', TRUE),
            'purpose' => trim($this->input->post('purpose', TRUE)),
            'participant_count' => (int) $this->input->post('participant_count'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $result = $this->Booking_model->update_employee(
            $id,
            $employee_id,
            $update_data
        );

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Booking berhasil diperbarui.'
            );

            redirect('employee/Bookings/detail/' . $id);
        } else {
            $this->session->set_flashdata('error', $result);
            redirect('employee/Bookings/edit/' . $id);
        }
    }

}