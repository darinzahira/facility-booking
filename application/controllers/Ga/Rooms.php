<?php  

	class Rooms extends MY_Controller
	{
		public function index()
		{
			
			$this->check_admin();
		
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Room_model->list();
			$data['innerdata'] = 'ga/room_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['innerdata'] = 'ga/room_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|trim|callback_check_room_code');
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|trim|callback_check_room_name');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
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
				$data['innerdata'] = 'ga/room_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Room_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Data Kamar berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Data Kamar gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'ga/Rooms');
            }
			
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Room_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Kamar berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Kamar gagal dihapus.'
				);
			}
			redirect(base_url() . 'ga/Rooms');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editroom'] = $this->Room_model->edit($id);
			$data['innerdata'] = 'ga/room_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{

			$id = $this->input->post('id');

			// Validasi Input
			$this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|trim|callback_check_room_code');
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required|trim|callback_check_room_name');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			if ($this->form_validation->run() == FALSE)
			{
				// Ambil kembali data departemen yang sedang diedit
				$data['editroom'] = $this->Room_model->edit($id);
				$data['innerdata'] = 'ga/room_edit';
				$this->load->view('ga/template', $data);
			}
			else
			{
				$result = $this->Room_model->update();

				if ($result == 'no_change'){

					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);
				} elseif ($result == TRUE) {
					$this->session->set_flashdata(
						'success',
						'Data Kamar berhasil diubah.'
					);
				} else {
					$this->session->set_flashdata(
						'error',
						'Data Kamar gagal diubah.'
					);
				}
				redirect(base_url() . 'ga/Rooms');
			}
		}

		public function check_room_code($room_code)
		{
			$id = $this->input->post('id');

			if ($this->Room_model->check_room_code($room_code, $id))
			{
				$this->form_validation->set_message(
					'check_room_code',
					'Kode Kamar harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

		public function check_room_name($room_name)
		{
			$id = $this->input->post('id');

			if ($this->Room_model->check_room_name($room_name, $id))
			{
				$this->form_validation->set_message(
					'check_room_name',
					'Nama Kamar harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

	}
?>