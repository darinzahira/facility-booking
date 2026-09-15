<?php  

	class Drivers extends CI_Controller
	{
		public function index()
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Driver_model->list();
			$data['innerdata'] = 'ga/driver_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['employees'] = $this->Driver_model->get_active();
            $data['innerdata'] = 'ga/driver_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('employee_id', 'Nama Karyawan', 'required');
			$this->form_validation->set_rules('driver_code', 'Kode Driver', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() == FALSE)
            {
                $data['employees'] = $this->Driver_model->get_active();
				$data['innerdata'] = 'ga/driver_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Driver_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Data Driver berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Data Driver gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'index.php/ga/Drivers');
            }
			
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Driver_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Driver berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Driver gagal dihapus.'
				);
			}
			redirect(base_url() . 'index.php/ga/Drivers');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editdrivers'] = $this->Driver_model->edit($id);
            $data['employees'] = $this->Driver_model->get_active();
			$data['innerdata'] = 'ga/driver_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			$result = $this->Driver_model->update();
			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Driver berhasil diubah.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Driver gagal diubah.'
				);
			}
			redirect(base_url() . 'index.php/ga/Drivers');
		}

	}
?>