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

    public function pending()
    {
        $data['bookings'] = $this->Booking_model->get_pending();
        $data['innerdata'] = 'ga/booking_list_pending';
        $this->load->view('ga/template', $data);
    }
    
    public function store()
    {
        $this->load->library('form_validation');
        $facility_type = $this->input->post('facility_type');

        $this->form_validation->set_rules('employee_id','Nama Karyawan','required|integer');
        $this->form_validation->set_rules('facility_type','Fasilitas','required|in_list[vehicle,room,meeting_room]');
        $this->form_validation->set_rules('start_date','Tanggal Mulai','required');
        $this->form_validation->set_rules('end_date','Tanggal Selesai','required');
        $this->form_validation->set_rules('start_time','Jam Mulai','required');
        $this->form_validation->set_rules('end_time','Jam Selesai','required');
        $this->form_validation->set_rules('participant_count','Jumlah Orang','required|integer|greater_than[0]');

        $this->form_validation->set_rules(
            'purpose',
            'Keperluan',
            'required|trim'
        );

         // Validasi pilihan fasilitas sesuai jenis booking
        if ($facility_type == 'vehicle') {
            $this->form_validation->set_rules(
                'vehicle_id', 'Kendaraan', 'required|integer'
            );
        } elseif ($facility_type == 'room') {
            $this->form_validation->set_rules(
                'room_id', 'Ruangan', 'required|integer'
            );
        } elseif ($facility_type == 'meeting_room') {
            $this->form_validation->set_rules(
                'meeting_room_id', 'Meeting Room', 'required|integer'
            );
        }

        $this->form_validation->set_message(
            'required',
            '{field} wajib diisi.'
        );

        if ($this->form_validation->run() == FALSE) {
            $data = $this->load_booking_form_data();
            $data['innerdata'] = 'ga/booking_add';

            $this->load->view('ga/template', $data);
            return;
        }

        $result = $this->Booking_model->store();

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Booking berhasil dibuat dan disetujui.'
            );

            redirect('ga/Bookings');
            return;
        }

        // Jika gagal, tampilkan form kembali tanpa redirect
        // agar data yang telah diisi tidak hilang.
        $data = $this->load_booking_form_data();
        $data['innerdata'] = 'ga/booking_add';
        $data['booking_error'] = $result;

        $this->load->view('ga/template', $data);
    }

    public function add()
    {
        $data['innerdata'] = 'ga/booking_add';
        $data['employees'] = $this->Emp_model->get_active_with_company();
        $data['vehicles'] = $this->Vehicle_model->get_active();
        $data['rooms'] = $this->Room_model->get_active();
        $data['meeting_rooms'] = $this->Meeting_model->get_active();
        $data['drivers'] = $this->Driver_model->get_active();
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
        $data['rooms'] = $this->Room_model->get_active();
        $data['meeting_rooms']   = $this->Meeting_model->get_active();
        $data['innerdata'] = 'ga/booking_detail';

        $this->load->view('ga/template', $data);
    }

    public function approved($id)
    {
        $data['booking'] = $this->Booking_model->get_detail_admin($id);

        if (!$data['booking']) {
            show_404();
        }

        $data['vehicles'] = $this->Vehicle_model->get_active();
        $data['drivers']   = $this->Driver_model->get_active();
        $data['rooms'] = $this->Room_model->get_active();
        $data['meeting_rooms']   = $this->Meeting_model->get_active();
        $data['innerdata'] = 'ga/booking_approval';

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

    private function load_booking_form_data()
    {

        $data['employees'] = $this->Emp_model->get_active_with_company();
        $data['vehicles'] = $this->Vehicle_model->get_active();
        $data['rooms'] = $this->Room_model->get_active();
        $data['meeting_rooms'] = $this->Meeting_model->get_active();
        $data['drivers'] = $this->Driver_model->get_active();

        return $data;
    }

    public function edit($id)
    {
        $booking = $this->Booking_model->get_detail_admin($id);

        if (!$booking) {
            show_404();
        }

        // Hanya booking pending yang bisa diedit
        if ($booking->status != 'pending') {
            $this->session->set_flashdata(
                'error',
                'Hanya booking berstatus pending yang dapat diedit.'
            );

            redirect('ga/Bookings/detail/' . $id);
            return;
        }

        $data = $this->load_booking_form_data();
        $data['booking'] = $booking;
        $data['innerdata'] = 'ga/booking_edit';

        $this->load->view('ga/template', $data);
    }

    public function update($id)
    {
        $booking = $this->Booking_model->get_detail_admin($id);

        if (!$booking) {
            show_404();
        }

        // Pastikan hanya booking pending yang dapat diedit
        if ($booking->status != 'pending') {
            $this->session->set_flashdata(
                'error',
                'Hanya booking berstatus pending yang dapat diedit.'
            );

            redirect('ga/Bookings/detail/' . $id);
            return;
        }

        $this->load->library('form_validation');

        $facility_type = $this->input->post('facility_type');

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

        if ($facility_type == 'vehicle') {
            $this->form_validation->set_rules(
                'vehicle_id',
                'Kendaraan',
                'required|integer'
            );
        } elseif ($facility_type == 'room') {
            $this->form_validation->set_rules(
                'room_id',
                'Kamar',
                'required|integer'
            );
        } elseif ($facility_type == 'meeting_room') {
            $this->form_validation->set_rules(
                'meeting_room_id',
                'Ruang Meeting',
                'required|integer'
            );
        }

        $this->form_validation->set_message(
            'required',
            '{field} wajib diisi.'
        );

        if ($this->form_validation->run() == FALSE) {
            $data = $this->load_booking_form_data();
            $data['booking'] = $booking;
            $data['innerdata'] = 'ga/booking_edit';

            $this->load->view('ga/template', $data);
            return;
        }

        $result = $this->Booking_model->update_booking($id);

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Perubahan booking berhasil disimpan.'
            );

            redirect('ga/Bookings');
            return;
        }

        // Jika gagal, tampilkan form kembali dengan pesan kesalahan
        $data = $this->load_booking_form_data();
        $data['booking'] = $booking;
        $data['booking_error'] = $result;
        $data['innerdata'] = 'ga/booking_edit';

        $this->load->view('ga/template', $data);
    }
    
    public function assign_approve($id)
    {
        // Pastikan permintaan berasal dari form POST
        if ($this->input->method(TRUE) != 'POST') {
            show_404();
            return;
        }

        $result = $this->Booking_model->assign_and_approve($id);

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Booking berhasil disetujui dan fasilitas berhasil ditetapkan.'
            );

        redirect('ga/Bookings/detail/' . $id);

        } else {
            $this->session->set_flashdata('error', $result);
        redirect('ga/Bookings/approved/' . $id);

        }

    }
    
    public function vehicle_usage_list()
    {
        $data['usages'] =
            $this->Booking_vehicle_usage_model->get_pending_inspection();

        $data['innerdata'] = 'ga/vehicle_usage_list';

        $this->load->view('ga/template', $data);
    }

    public function vehicle_usage_detail($booking_id)
    {
        $booking = $this->Booking_model->get_detail_admin($booking_id);

        if (!$booking || $booking->facility_type !== 'vehicle') {
            show_404();
            return;
        }

        $usage =
            $this->Booking_vehicle_usage_model->get_by_booking($booking_id);

        if (!$usage) {
            show_404();
            return;
        }

        $data['booking'] = $booking;
        $data['usage'] = $usage;
        $data['innerdata'] = 'ga/vehicle_usage_detail';

        $this->load->view('ga/template', $data);
    }

    public function complete_vehicle_usage($booking_id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $booking = $this->Booking_model->get_detail_admin($booking_id);

        if (!$booking || $booking->facility_type !== 'vehicle') {
            show_404();
            return;
        }

        $result =
            $this->Booking_vehicle_usage_model
                ->complete_inspection($booking_id);

        if ($result === TRUE) {
            $this->session->set_flashdata(
                'success',
                'Pemeriksaan kendaraan selesai.'
            );
        } else {
            $this->session->set_flashdata('error', $result);
        }

        redirect('ga/Bookings/vehicle_usage_detail/' . $booking_id);
    }

}