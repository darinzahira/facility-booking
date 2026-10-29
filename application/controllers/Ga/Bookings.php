<?php

class Bookings extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Pastikan user sudah login
        $this->check_admin();
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
        $data['usages'] = $this->Booking_vehicle_usage_model->get_pending_inspection();
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

    public function report()
    {
        $filters = array();

        // Ambil filter tanggal dari URL
        $start_date = $this->input->get('start_date', TRUE);
        $end_date   = $this->input->get('end_date', TRUE);

        // Validasi tanggal agar formatnya benar
        foreach (array(
            'start_date' => $start_date,
            'end_date'   => $end_date
        ) as $key => $date) {

            if (!empty($date)) {
                $parts = explode('-', $date);

                if (
                    count($parts) == 3 &&
                    checkdate(
                        (int) $parts[1],
                        (int) $parts[2],
                        (int) $parts[0]
                    ) &&
                    preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)
                ) {
                    $filters[$key] = $date;
                }
            }
        }

        // Jenis fasilitas yang diizinkan
        $facility_type = $this->input->get('facility_type', TRUE);

        if (in_array(
            $facility_type,
            array('vehicle', 'room', 'meeting_room')
        )) {
            $filters['facility_type'] = $facility_type;
        }

        // Status booking yang diizinkan
        $status = $this->input->get('status', TRUE);

        if (in_array(
            $status,
            array('pending', 'approved', 'rejected', 'cancelled')
        )) {
            $filters['status'] = $status;
        }

        $data['filters'] = $filters;
        $data['reports'] = $this->Booking_model
            ->get_usage_report($filters);
        
        // Ringkasan laporan mengikuti filter yang aktif
        $data['summary'] = array(
            'total' => count($data['reports']),
            'approved' => 0,
            'vehicle' => 0,
            'in_use' => 0,
            'pending_inspection' => 0
        );

        foreach ($data['reports'] as $row) {

            if ($row->status == 'approved') {
                $data['summary']['approved']++;
            }

            if ($row->facility_type == 'vehicle' &&
                $row->status == 'approved') {

                $data['summary']['vehicle']++;

                if ($row->status_penggunaan == 'digunakan') {
                    $data['summary']['in_use']++;
                }

                if ($row->status_penggunaan == 'menunggu_pemeriksaan') {
                    $data['summary']['pending_inspection']++;
                }
            }
        }

        $data['innerdata'] = 'ga/usage_report';

        $this->load->view('ga/template', $data);
    }
    
    public function export_csv()
    {
        // Ambil filter yang sama seperti halaman laporan
        $filters = array();

        $start_date = $this->input->get('start_date', TRUE);
        $end_date   = $this->input->get('end_date', TRUE);

        foreach (array(
            'start_date' => $start_date,
            'end_date'   => $end_date
        ) as $key => $date) {

            if (!empty($date)) {
                $parts = explode('-', $date);

                if (
                    count($parts) == 3 &&
                    preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) &&
                    checkdate(
                        (int) $parts[1],
                        (int) $parts[2],
                        (int) $parts[0]
                    )
                ) {
                    $filters[$key] = $date;
                }
            }
        }

        $facility_type = $this->input->get('facility_type', TRUE);

        if (in_array(
            $facility_type,
            array('vehicle', 'room', 'meeting_room')
        )) {
            $filters['facility_type'] = $facility_type;
        }

        $status = $this->input->get('status', TRUE);

        if (in_array(
            $status,
            array('pending', 'approved', 'rejected', 'cancelled')
        )) {
            $filters['status'] = $status;
        }

        $reports = $this->Booking_model->get_usage_report($filters);

        // Siapkan file CSV agar bisa dibuka dengan Excel
        $filename = 'laporan_penggunaan_fasilitas_' .
            date('Ymd_His') . '.csv';

        // Siapkan header unduhan
        $filename = 'laporan_penggunaan_fasilitas_' .
            date('Ymd_His') . '.csv';

        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header(
            'Content-Disposition: attachment; filename="' .
            $filename . '"'
        );
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // BOM UTF-8 agar karakter terbaca baik di Excel
        echo "\xEF\xBB\xBF";

        $output = fopen('php://output', 'w');

        // Header kolom
        fputcsv($output, array(
            'Kode Booking',
            'Kode Karyawan',
            'Nama Karyawan',
            'Jenis Fasilitas',
            'Nama Fasilitas',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jam Mulai',
            'Jam Selesai',
            'Keperluan',
            'Status Booking',
            'Status Penggunaan',
            'KM Awal',
            'KM Akhir',
            'Jarak Tempuh (KM)'
        ), ';');

        // Isi data
        foreach ($reports as $row) {
            $facility_name = '-';

            if ($row->facility_type == 'vehicle') {
                $facility_name = ($row->vehicle_name ?: '-') .
                    ' (' . ($row->plate_number ?: '-') . ')';
            } elseif ($row->facility_type == 'room') {
                $facility_name = $row->room_name ?: '-';
            } elseif ($row->facility_type == 'meeting_room') {
                $facility_name = $row->meeting_room_name ?: '-';
            }

            $facility_labels = array(
                'vehicle' => 'Kendaraan',
                'room' => 'Kamar',
                'meeting_room' => 'Ruang Meeting'
            );

            $booking_labels = array(
                'pending' => 'Menunggu Persetujuan',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'cancelled' => 'Dibatalkan'
            );

            $usage_labels = array(
                'belum_mulai' => 'Belum Mulai',
                'digunakan' => 'Sedang Digunakan',
                'menunggu_pemeriksaan' => 'Menunggu Pemeriksaan GA',
                'selesai' => 'Selesai Diperiksa'
            );

            $km_awal = $row->km_awal;
            $km_akhir = $row->km_akhir;
            $jarak = '';

            if ($km_awal !== NULL && $km_akhir !== NULL) {
                $jarak = (int) $km_akhir - (int) $km_awal;
            }

            fputcsv($output, array(
                $row->booking_code,
                $row->employee_code ?: '-',
                $row->employee_name ?: '-',
                isset($facility_labels[$row->facility_type])
                    ? $facility_labels[$row->facility_type]
                    : $row->facility_type,
                $facility_name,
                $row->start_date,
                $row->end_date,
                $row->start_time,
                $row->end_time,
                $row->purpose,
                isset($booking_labels[$row->status])
                    ? $booking_labels[$row->status]
                    : $row->status,
                isset($usage_labels[$row->status_penggunaan])
                    ? $usage_labels[$row->status_penggunaan]
                    : ($row->facility_type == 'vehicle'
                        ? 'Belum Ada Data'
                        : '-'),
                $km_awal,
                $km_akhir,
                $jarak
            ), ';');
        }

        fclose($output);
        exit;
    }

}