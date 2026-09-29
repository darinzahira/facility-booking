<?php  

	class Employees extends MY_Controller
	{
		public function index()
		{
			
			$this->check_admin();
		
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Emp_model->list();
			$data['innerdata'] = 'ga/employee_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['departments'] = $this->Dept_model->get_active();
			$data['company'] = $this->Company_model->get_active();
			$data['innerdata'] = 'ga/employee_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('employee_code', 'NIK Karyawan', 'required|is_unique[employees.employee_code]');
			$this->form_validation->set_rules('name', 'Nama Karyawan', 'required');
			$this->form_validation->set_rules('department_id', 'Departemen', 'required');
			$this->form_validation->set_rules('company_id', 'Perusahaan', 'required');
			$this->form_validation->set_rules('position', 'Jabatan', 'required');
			$this->form_validation->set_rules('phone','No Telpon','required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			$this->form_validation->set_message(
				'is_unique',
				'{field} harus berbeda karena sudah digunakan.'
			);

			$this->form_validation->set_message(
				'regex_match',
				'{field} hanya boleh menggunakan angka.'
			);

			if ($this->form_validation->run() == FALSE)
            {
				$data['departments'] = $this->Dept_model->get_active();
				$data['company'] = $this->Company_model->get_active();
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
				redirect(base_url() . 'ga/Employees');
            }
			
		}

		public function detail()
		{
			$id = $this->uri->segment(4);
			$data['detail'] = $this->Emp_model->get_detail($id);
			$data['innerdata'] = 'ga/employee_detail';
			if (!$data['detail']) {
				show_404();
			}
			$this->load->view('ga/template', $data);
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Emp_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Karyawan berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Karyawan gagal dihapus.'
				);
			}
			redirect(base_url() . 'ga/Employees');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editemployee'] = $this->Emp_model->edit($id);
			$data['departments'] = $this->Dept_model->get_active();
			$data['company'] = $this->Company_model->get_active();
			$data['innerdata'] = 'ga/employee_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			// $result = $this->Emp_model->update();
			// if ($result) {
			// 	$this->session->set_flashdata(
			// 		'success',
			// 		'Data Karyawan berhasil diubah.'
			// 	);
			// } else {
			// 	$this->session->set_flashdata(
			// 		'error',
			// 		'Data Karyawan gagal diubah.'
			// 	);
			// }
			// redirect(base_url() . 'ga/Employees');

			$id = $this->input->post('id');

			$this->form_validation->set_rules('employee_code','NIK Karyawan','required|callback_check_employee_code');
			$this->form_validation->set_rules('name','Nama Karyawan','required');
			$this->form_validation->set_rules('department_id','Departemen','required');
			$this->form_validation->set_rules('company_id','Perusahaan','required');
			$this->form_validation->set_rules('position','Jabatan','required');
			$this->form_validation->set_rules('phone','No Telpon','required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('username','Username','required|callback_check_username');
			$this->form_validation->set_rules('status','Status','required');
			$this->form_validation->set_rules('role','Role','required');

			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			$this->form_validation->set_message(
				'regex_match',
				'{field} hanya boleh menggunakan angka.'
			);

			if ($this->form_validation->run() == FALSE)
			{
				$data['editemployee'] = $this->Emp_model->edit($id);
				$data['departments'] = $this->Dept_model->get_active();
				$data['innerdata'] = 'ga/employee_edit';

				$this->load->view('ga/template', $data);
			} else {
				$result = $this->Emp_model->update();

				if ($result === 'no_change')
				{
					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);
				}
				elseif ($result)
				{
					$this->session->set_flashdata(
						'success',
						'Data Karyawan berhasil diubah.'
					);
				}
				else
				{
					$this->session->set_flashdata(
						'error',
						'Data Karyawan gagal diubah.'
					);
				}

				redirect(base_url() . 'ga/Employees');
			}
		}

		public function check_employee_code($employee_code)
		{
			$id = $this->input->post('id');

			if ($this->Emp_model->check_employee_code($employee_code, $id))
			{
				$this->form_validation->set_message(
					'check_employee_code',
					'NIK Karyawan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

		public function check_username($username)
		{
			$id = $this->input->post('id');

			if ($this->Emp_model->check_username($username, $id))
			{
				$this->form_validation->set_message(
					'check_username',
					'Username harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

	}
?>