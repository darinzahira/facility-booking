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
    
    public function store()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'employee_id',
            'Nama Karyawan',
            'required|integer'
        );

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

        $this->form_validation->set_message(
            'required',
            '{field} wajib diisi.'
        );

        if ($this->form_validation->run() == FALSE) {
            $data['innerdata'] = 'ga/booking_add';
            $data['employees'] = $this->Emp_model->get_active();

            $this->load->view('ga/template', $data);
            return;
        }

        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time   = $this->input->post('end_time');

        // Validasi rentang tanggal
        if ($end_date < $start_date) {
            $this->session->set_flashdata(
                'error',
                'Tanggal selesai tidak boleh mendahului tanggal mulai.'
            );

            redirect('ga/Bookings/add');
            return;
        }

        // Validasi jam jika booking berlangsung pada tanggal yang sama
        if (
            $start_date == $end_date &&
            $end_time <= $start_time
        ) {
            $this->session->set_flashdata(
                'error',
                'Jam selesai harus setelah jam mulai.'
            );

            redirect('ga/Bookings/add');
            return;
        }

        $employee_id = $this->input->post('employee_id');

        // Pastikan karyawan masih aktif
        $employee = $this->Emp_model->get_active_by_id($employee_id);

        if (!$employee) {
            $this->session->set_flashdata(
                'error',
                'Data karyawan tidak ditemukan atau tidak aktif.'
            );

            redirect('ga/Bookings/add');
            return;
        }

        $data = array(
            'booking_code'     => 'BK-' . date('YmdHis') . '-' . mt_rand(100, 999),
            'employee_id'      => $employee_id,
            'facility_type'    => $this->input->post('facility_type'),
            'vehicle_id'       => NULL,
            'room_id'          => NULL,
            'meeting_room_id'  => NULL,
            'driver_id'        => NULL,
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'start_time'       => $start_time,
            'end_time'         => $end_time,
            'purpose'          => $this->input->post('purpose'),
            'status'           => 'pending',
            'notes'            => NULL,
            'rejection_reason' => NULL,
            'approved_by'      => NULL,
            'approved_at'      => NULL,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => NULL
        );

        $result = $this->Booking_model->store($data);

        if ($result) {
            $this->session->set_flashdata(
                'success',
                'Pengajuan booking berhasil ditambahkan.'
            );

            redirect('ga/Bookings');
        } else {
            $this->session->set_flashdata(
                'error',
                'Pengajuan booking gagal ditambahkan.'
            );

            redirect('ga/Bookings/add');
        }
    }

    public function add()
    {
        $data['innerdata'] = 'ga/booking_add';
        $data['employees'] = $this->Emp_model->get_active();
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