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
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
			$this->form_validation->set_rules('location', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

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
				redirect(base_url() . 'index.php/ga/Meeting');
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
			redirect(base_url() . 'index.php/ga/Meeting');
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
			$result = $this->Meeting_model->update();
			if ($result) {
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
			redirect(base_url() . 'index.php/ga/Meeting');
		}

	}
?>