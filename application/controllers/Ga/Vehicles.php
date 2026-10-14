<?php  

	class Vehicles extends MY_Controller
	{
		public function index()
		{
			
			$this->check_admin();
		
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			
            $data['list'] = $this->Vehicle_model->list();
			$data['innerdata'] = 'ga/vehicle_list';
			$this->load->view('ga/template', $data);
		}

		public function add()
		{
			$data['innerdata'] = 'ga/vehicle_add';
			$this->load->view('ga/template', $data);
		}

		public function store()
		{
			$this->form_validation->set_rules('vehicle_code', 'Kode Kendaraan', 'required|trim|callback_check_vehicle_code');
			$this->form_validation->set_rules('plate_number', 'Plat Kendaraan', 'required|trim|callback_check_plate_number');
			$this->form_validation->set_rules('vehicle_name', 'Brand Kendaraan', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis Kendaraan', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun Kendaraan', 'required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('warna', 'Warna Kendaraan', 'required');
			$this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('requires_driver', 'Status Driver', 'required');

			// Pesan validasi
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
				$data['innerdata'] = 'ga/vehicle_add';
				$this->load->view('ga/template', $data);
				return;
			}

			// Foto kendaraan bersifat opsional
			$vehicle_photo = null;

			if (!empty($_FILES['vehicle_photo']['name']))
			{
				$upload_path = FCPATH . 'uploads/vehicles/';

				if (!is_dir($upload_path) || !is_writable($upload_path))
				{
					$this->session->set_flashdata(
						'error',
						'Folder upload foto kendaraan tidak ditemukan atau tidak dapat ditulis.'
					);

					redirect(base_url('ga/Vehicles/add'));
					return;
				}

				$config['upload_path']   = $upload_path;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = 2048;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload');
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('vehicle_photo'))
				{
					$this->session->set_flashdata(
						'error',
						strip_tags($this->upload->display_errors('', ''))
					);

					redirect(base_url('ga/Vehicles/add'));
					return;
				}

				$upload_data = $this->upload->data();
				$vehicle_photo = $upload_data['file_name'];
			}

			$result = $this->Vehicle_model->store($vehicle_photo);

			if ($result)
			{
				$this->session->set_flashdata(
					'success',
					'Data Kendaraan berhasil ditambahkan.'
				);
			}
			else
			{
				// Hapus file jika penyimpanan database gagal
				if ($vehicle_photo !== null)
				{
					$file_path = FCPATH . 'uploads/vehicles/' . $vehicle_photo;

					if (is_file($file_path))
					{
						unlink($file_path);
					}
				}

				$this->session->set_flashdata(
					'error',
					'Data Kendaraan gagal ditambahkan.'
				);
			}

			redirect(base_url('ga/Vehicles'));
		}
			

		public function detail()
		{
			$id = $this->uri->segment(4);
			$data['vehicle'] = $this->Vehicle_model->get_detail($id);
			$data['innerdata'] = 'ga/vehicle_detail';
			if (!$data['vehicle']) {
				show_404();
			}
			$this->load->view('ga/template', $data);
		}
		
		public function delete()
		{
			$id = $this->uri->segment(4);
			$result = $this->Vehicle_model->delete($id);

			if ($result) {
				$this->session->set_flashdata(
					'success',
					'Data Kendaraan berhasil dihapus.'
				);
			} else {
				$this->session->set_flashdata(
					'error',
					'Data Kendaraan gagal dihapus.'
				);
			}
			redirect(base_url() . 'ga/Vehicles');
		}

		public function edit()
		{
			$id = $this->uri->segment(4);
			$data['editvehicle'] = $this->Vehicle_model->edit($id);
			$data['innerdata'] = 'ga/vehicle_edit';
			$this->load->view('ga/template', $data);
		}

		public function update()
		{
			$id = $this->input->post('id');

			// Validasi input
			$this->form_validation->set_rules('vehicle_code','Kode Kendaraan','required|trim|callback_check_vehicle_code');
			$this->form_validation->set_rules('plate_number', 'Plat Kendaraan', 'required|trim|callback_check_plate_number');
			$this->form_validation->set_rules('vehicle_name', 'Brand Kendaraan', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis Kendaraan', 'required');
			$this->form_validation->set_rules('tahun', 'Tahun Kendaraan', 'required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('warna', 'Warna Kendaraan', 'required');
			$this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('requires_driver', 'Status Driver', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				// Ambil kembali data departemen yang sedang diedit
				$data['editvehicle'] = $this->Vehicle_model->edit($id);
				$data['innerdata'] = 'ga/vehicle_edit';
				$this->load->view('ga/template', $data);
			}
			else
			{
				$vehicle_photo = null;

				if (
					isset($_FILES['vehicle_photo']) &&
					!empty($_FILES['vehicle_photo']['name'])
				)
				{
					$upload_path = FCPATH . 'uploads/vehicles/';

					// Pastikan folder upload tersedia dan bisa ditulis
					if (!is_dir($upload_path) || !is_writable($upload_path))
					{
						$this->session->set_flashdata(
							'error',
							'Folder upload tidak ditemukan atau tidak dapat ditulis: '
							. $upload_path
						);

						redirect(base_url('ga/Vehicles/edit/' . $id));
						return;
					}

					$config = array(
						'upload_path'   => $upload_path,
						'allowed_types' => 'jpg|jpeg|png',
						'max_size'      => 2048,
						'encrypt_name'  => TRUE
					);

					$this->load->library('upload');
					$this->upload->initialize($config, TRUE);

					if (!$this->upload->do_upload('vehicle_photo'))
					{
						$error = strip_tags(
							$this->upload->display_errors('', '')
						);

						$this->session->set_flashdata('error', $error);

						redirect(base_url('ga/Vehicles/edit/' . $id));
						return;
					}

					$upload_data = $this->upload->data();
					$vehicle_photo = $upload_data['file_name'];
				}

				// Lanjutkan proses update database
				$result = $this->Vehicle_model->update($vehicle_photo);

				if ($result === TRUE)
				{
					$this->session->set_flashdata(
						'success',
						'Data Kendaraan berhasil diubah.'
					);
				}
				elseif ($result === 'no_change')
				{
					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);
				}
				else
				{
					$this->session->set_flashdata(
						'error',
						'Data Kendaraan gagal diubah.'
					);
				}

				redirect(base_url('ga/Vehicles'));
			}
		}

		public function check_vehicle_code($vehicle_code)
		{
			$id = $this->input->post('id');

			if ($this->Vehicle_model->check_vehicle_code($vehicle_code, $id))
			{
				$this->form_validation->set_message(
					'check_vehicle_code',
					'Kode Kendaraan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

		public function check_plate_number($plate_number)
		{
			$id = $this->input->post('id');

			if ($this->Vehicle_model->check_plate_number($plate_number, $id))
			{
				$this->form_validation->set_message(
					'check_plate_number',
					'Plat Kendaraan harus berbeda karena sudah digunakan.'
				);

				return FALSE;
			}

			return TRUE;
		}

	}
?>