<?php  

	class Departments extends MY_Controller
	{
		public function index()
		{
		
			$this->check_admin();
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['deptlist'] = $this->Dept_model->deptlist();
			$data['innerdata'] = 'ga/department_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['innerdata'] = 'ga/dept_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('dept_name', 'Nama Departemen', 'required|trim|callback_check_department_name');
			$this->form_validation->set_rules('status', 'Status', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			if ($this->form_validation->run() == FALSE)
            {
				$data['innerdata'] = 'ga/dept_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Dept_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Department berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Department gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'ga/Departments');
            }
			
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
			redirect(base_url() . 'ga/Departments');
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
			// $result = $this->Dept_model->update();
			// if ($result) {
			// 	$this->session->set_flashdata(
			// 		'success',
			// 		'Department berhasil diubah.'
			// 	);
			// } else {
			// 	$this->session->set_flashdata(
			// 		'error',
			// 		'Department gagal diubah.'
			// 	);
			// }
			// redirect(base_url() . 'ga/Departments');
			$id = $this->input->post('id');

			// Validasi nama departemen
			$this->form_validation->set_rules(
				'dept_name',
				'Nama Departemen',
				'required|trim|callback_check_department_name'
			);

			// Validasi status
			$this->form_validation->set_rules(
				'status',
				'Status',
				'required'
			);

			if ($this->form_validation->run() == FALSE)
			{
				// Ambil kembali data departemen yang sedang diedit
				$data['editdepartment'] = $this->Dept_model->edit($id);

				$data['innerdata'] = 'ga/department_edit';

				$this->load->view('ga/template', $data);
			}
			else
			{
				$result = $this->Dept_model->update();

				if ($result === 'no_change') {

					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);

				} elseif ($result) {

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

				redirect(base_url() . 'ga/Departments');
			}
		}

		public function check_department_name($dept_name)
		{
			$id = $this->input->post('id');

			if ($this->Dept_model->check_department_name($dept_name, $id))
			{
				$this->form_validation->set_message(
					'check_department_name',
					'Nama Departemen harus berbeda karena sudah digunakan.'
				);

				return FALSE; 
			}

			return TRUE;
		}

	}
?>