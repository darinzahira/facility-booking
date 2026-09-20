<?php  

	class Meeting extends CI_Controller
	{
		public function index()
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Meeting_model->list();
			$data['innerdata'] = 'ga/meeting_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['innerdata'] = 'ga/meeting_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|is_unique[meeting_rooms.room_code]');
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|is_unique[meeting_rooms.room_name]');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
			$this->form_validation->set_rules('location', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			$this->form_validation->set_message(
				'is_unique',
				'{field} harus berbeda karena sudah digunakan.'
			);
			
			if ($this->form_validation->run() == FALSE)
            {
				$data['innerdata'] = 'ga/meeting_add';
				$this->load->view('ga/template', $data);
            }
            else
            { 
                $result = $this->Meeting_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Data Ruang Meeting berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Data Ruang Meeting gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'ga/Meeting');
            }
			
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Meeting_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Ruang Meeting berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Ruang Meeting gagal dihapus.'
				);
			}
			redirect(base_url() . 'ga/Meeting');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editroom'] = $this->Meeting_model->edit($id);
			$data['innerdata'] = 'ga/meeting_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			
			$id = $this->input->post('id');

			// Validasi Input
			$this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|trim|callback_check_room_code');
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|trim|callback_check_room_name');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
			$this->form_validation->set_rules('location', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			if ($this->form_validation->run() == FALSE)
			{
				// Ambil kembali data departemen yang sedang diedit
				$data['editroom'] = $this->Meeting_model->edit($id);
				$data['innerdata'] = 'ga/meeting_edit';
				$this->load->view('ga/template', $data);
			}
			else
			{
				$result = $this->Meeting_model->update();
				if ($result == 'no_change'){

					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);
				} elseif ($result) {
					$this->session->set_flashdata(
						'success',
						'Data Ruang Meeting berhasil diubah.'
					);
				} else {
					$this->session->set_flashdata(
						'error',
						'Data Ruang Meeting gagal diubah.'
					);
				}
				redirect(base_url() . 'ga/Meeting');
			}
		}

		public function check_room_code($room_code)
		{
			$id = $this->input->post('id');

			if ($this->Meeting_model->check_room_code($room_code, $id))
			{
				$this->form_validation->set_message(
					'check_room_code',
					'Kode Ruangan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

		public function check_room_name($room_name)
		{
			$id = $this->input->post('id');

			if ($this->Meeting_model->check_room_name($room_name, $id))
			{
				$this->form_validation->set_message(
					'check_room_name',
					'Nama Ruangan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

	}
?>