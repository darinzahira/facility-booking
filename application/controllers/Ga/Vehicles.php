<?php  

	class Vehicles extends CI_Controller
	{
		public function index()
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Vehicle_model->list();
			$data['innerdata'] = 'ga/vehicle_list';
			$this->load->view('ga/template', $data);
		}

		// public function add()
		// {
		// 	$data['innerdata'] = 'ga/dept_add';
		// 	$this->load->view('ga/template', $data);
		// }

		// public function store()
		// {
		// 	$this->form_validation->set_rules('dept_name', 'Departemen', 'required');
		// 	$this->form_validation->set_rules('status', 'Status', 'required');

		// 	if ($this->form_validation->run() == FALSE)
        //     {
		// 		$data['innerdata'] = 'ga/dept_add';
		// 		$this->load->view('ga/template', $data);
        //     }
        //     else
        //     {
        //         $result = $this->Dept_model->store();
		// 		 if ($result) {

		// 			$this->session->set_flashdata(
		// 				'success',
		// 				'Department berhasil ditambahkan.'
		// 			);

		// 		} else {

		// 			$this->session->set_flashdata(
		// 				'error',
		// 				'Department gagal ditambahkan.'
		// 			);
		// 		}
		// 		redirect(base_url() . 'index.php/ga/Departments');
        //     }
			
		// }

		// public function delete()
		// {
		// 	$id = $this->uri->segment(4);
		// 	$result = $this->Dept_model->delete($id);

		// 	if ($result) {
		// 		$this->session->set_flashdata(
		// 			'success',
		// 			'Department berhasil dihapus.'
		// 		);
		// 	} else {
		// 		$this->session->set_flashdata(
		// 			'error',
		// 			'Department gagal dihapus.'
		// 		);
		// 	}
		// 	redirect(base_url() . 'index.php/ga/Departments');
		// }

		// public function edit()
		// {
		// 	$id = $this->uri->segment(4);
		// 	$data['editdepartment'] = $this->Dept_model->edit($id);
		// 	$data['innerdata'] = 'ga/department_edit';
		// 	$this->load->view('ga/template', $data);
		// }

		// public function update()
		// {
		// 	$result = $this->Dept_model->update();
		// 	if ($result) {
		// 		$this->session->set_flashdata(
		// 			'success',
		// 			'Department berhasil diubah.'
		// 		);
		// 	} else {
		// 		$this->session->set_flashdata(
		// 			'error',
		// 			'Department gagal diubah.'
		// 		);
		// 	}
		// 	redirect(base_url() . 'index.php/ga/Departments');
		// }

	}
?>