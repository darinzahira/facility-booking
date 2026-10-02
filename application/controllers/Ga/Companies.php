<?php  

	class Companies extends MY_Controller
	{
		public function index()
		{
		
			$this->check_admin();
			
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Company_model->list();
			$data['innerdata'] = 'ga/company_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['innerdata'] = 'ga/company_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules(
				'company_code',
				'Kode Perusahaan',
				'required|trim|callback_check_company_code'
			);

			$this->form_validation->set_rules(
				'company_name',
				'Nama Perusahaan',
				'required|trim|callback_check_company_name'
			);
			
			$this->form_validation->set_rules('status', 'Status', 'required');

			// Pesan validasi
			$this->form_validation->set_message(
				'required',
				'{field} wajib diisi.'
			);

			if ($this->form_validation->run() == FALSE)
            {
				$data['innerdata'] = 'ga/company_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Company_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Perusahaan berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Perusahaan gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'ga/Companies');
            }
			
		}

		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Company_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Perusahaan berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Perusahaan gagal dihapus.'
				);
			}
			redirect(base_url() . 'ga/Companies');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editdata'] = $this->Company_model->edit($id);
			$data['innerdata'] = 'ga/company_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			
			$id = $this->input->post('id');

			// Validasi nama perusahaan
			$this->form_validation->set_rules(
				'company_code',
				'Kode Perusahaan',
				'required|trim|callback_check_company_code'
			);

			$this->form_validation->set_rules(
				'company_name',
				'Nama Perusahaan',
				'required|trim|callback_check_company_name'
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
				$data['editdata'] = $this->Company_model->edit($id);
				$data['innerdata'] = 'ga/company_edit';
				$this->load->view('ga/template', $data);
			}
			else
			{
				$result = $this->Company_model->update();

				if ($result === 'no_change') {

					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);

				} elseif ($result) {

					$this->session->set_flashdata(
						'success',
						'Perusahaan berhasil diubah.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Perusahaan gagal diubah.'
					);
				}

				redirect(base_url() . 'ga/Companies');
			}
		}

		public function check_company_name($company_name)
		{
			$id = $this->input->post('id');

			if ($this->Company_model->check_company_name($company_name, $id))
			{
				$this->form_validation->set_message(
					'check_company_name',
					'Nama Perusahaan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

		public function check_company_code($company_code)
		{
			$id = $this->input->post('id');

			if ($this->Company_model->check_company_code($company_code, $id))
			{
				$this->form_validation->set_message(
					'check_company_code',
					'Kode Perusahaan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

	}
?>