<?php

class Bookings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Pastikan user sudah login
        $this->check_admin();

        $this->load->model('Booking_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['bookings'] = $this->Booking_model->get_all();

        $data['innerdata'] = 'ga/booking_list';

        $this->load->view('ga/template', $data);
    }

    public function detail($id)
    {
        $data['booking'] = $this->Booking_model->get_detail_admin($id);

        if (!$data['booking']) {
            show_404();
        }

        $data['vehicles'] = $this->Vehicle_model->get_active();
        $data['drivers']   = $this->Driver_model->get_active();

        $data['innerdata'] = 'ga/booking_detail';

        $this->load->view('ga/template', $data);
    }

    public function approve($id)
    {
        $booking = $this->Booking_model->get_detail_admin($id);

        if (!$booking) {
            show_404();
        }

        // Hanya booking pending yang bisa di-approve
        if ($booking->status != 'pending') {
            $this->session->set_flashdata(
                'error',
                'Booking ini sudah tidak berstatus pending.'
            );

            redirect('ga/Bookings/detail/' . $id);
        }

        $data = array(
            'status'      => 'approved',
            'approved_by' => $this->session->userdata('user_id'),
            'approved_at' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        );

        $result = $this->Booking_model->update_status($id, $data);

        if ($result) {
            $this->session->set_flashdata(
                'success',
                'Booking berhasil disetujui.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Booking gagal disetujui.'
            );
        }

        redirect('ga/Bookings/detail/' . $id);
    }

    public function reject($id)
    {
        $booking = $this->Booking_model->get_detail_admin($id);

        if (!$booking) {
            show_404();
        }

        // Hanya booking pending yang bisa ditolak
        if ($booking->status != 'pending') {
            $this->session->set_flashdata(
                'error',
                'Booking ini sudah tidak berstatus pending.'
            );

            redirect('ga/Bookings/detail/' . $id);
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'rejection_reason',
            'Alasan Penolakan',
            'required'
        );

        $this->form_validation->set_message(
            'required',
            '{field} wajib diisi.'
        );

        if ($this->form_validation->run() == FALSE) {

            $data['booking'] = $booking;
            $data['innerdata'] = 'ga/booking_detail';

            $this->load->view(
                'ga/template',
                $data
            );

            return;
        }

        $data = array(
            'status'           => 'rejected',
            'rejection_reason' => $this->input->post('rejection_reason'),
            'updated_at'       => date('Y-m-d H:i:s')
        );

        $result = $this->Booking_model->update_status($id, $data);

        if ($result) {
            $this->session->set_flashdata(
                'success',
                'Booking berhasil ditolak.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Booking gagal ditolak.'
            );
        }

        redirect('ga/Bookings/detail/' . $id);
    }
    
}