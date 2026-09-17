<?php  

	class Rooms extends CI_Controller
	{
		public function index()
		{
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
			$this->form_validation->set_rules('room_code', 'Kode Kamar', 'required|is_unique[rooms.room_code]');
			$this->form_validation->set_rules('room_name', 'Nama Kamar', 'required');
			$this->form_validation->set_rules('capacity', 'Kapasitas', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

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
				redirect(base_url() . 'index.php/ga/Rooms');
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
			redirect(base_url() . 'index.php/ga/Rooms');
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
			$result = $this->Room_model->update();
			if ($result) {
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
			redirect(base_url() . 'index.php/ga/Rooms');
		}

	}
?>