<?php  

	class Employees extends CI_Controller
	{
		public function index()
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Emp_model->list();
			$data['innerdata'] = 'ga/employee_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['departments'] = $this->Dept_model->get_active();
			$data['innerdata'] = 'ga/employee_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('employee_code', 'NIK Karyawan', 'required|is_unique[employees.employee_code]');
			$this->form_validation->set_rules('name', 'Nama Karyawan', 'required');
			$this->form_validation->set_rules('department_id', 'Departemen', 'required');
			$this->form_validation->set_rules('position', 'Jabatan', 'required');
			$this->form_validation->set_rules('phone', 'No Telpon', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() == FALSE)
            {
				$data['departments'] = $this->Dept_model->get_active();
				$data['innerdata'] = 'ga/employee_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Emp_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Data Karyawan berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Data Karyawan gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'index.php/ga/Employees');
            }
			
		}

		public function detail()
		{
			$id = $this->uri->segment(4);
			$data['detail'] = $this->Emp_model->get_detail($id);
			$data['innerdata'] = 'employee_detail';
			if (!$data['employee']) {
				show_404();
			}
			$this->load->view('ga/template', $data);
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Dept_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Department berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Department gagal dihapus.'
				);
			}
			redirect(base_url() . 'index.php/ga/Departments');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editdepartment'] = $this->Dept_model->edit($id);
			$data['innerdata'] = 'ga/department_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			$result = $this->Dept_model->update();
			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Department berhasil diubah.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Department gagal diubah.'
				);
			}
			redirect(base_url() . 'index.php/ga/Departments');
		}

	}
?>