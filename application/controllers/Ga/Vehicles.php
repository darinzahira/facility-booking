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
			$this->form_validation->set_rules('vehicle_code', 'Kode Kendaraan', 'required|is_unique[vehicles.vehicle_code]');
			$this->form_validation->set_rules('plate_number', 'Plat Kendaraan', 'required|is_unique[vehicles.plate_number]');
			$this->form_validation->set_rules('vehicle_name', 'Brand Kendaraan', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('requires_driver', 'Status Driver', 'required');

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
				$data['innerdata'] = 'ga/vehicle_add';
				$this->load->view('ga/template', $data);
            }
            else
            {
                $result = $this->Vehicle_model->store();
				 if ($result) {

					$this->session->set_flashdata(
						'success',
						'Data Kendaraan berhasil ditambahkan.'
					);

				} else {

					$this->session->set_flashdata(
						'error',
						'Data Kendaraan gagal ditambahkan.'
					);
				}
				redirect(base_url() . 'ga/Vehicles');
            }
			
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
				$result = $this->Vehicle_model->update();

				if ($result == TRUE) {
					$this->session->set_flashdata(
						'success',
						'Data Kendaraan berhasil diubah.'
					);
				} 
				elseif ($result == 'no_change'){
					$this->session->set_flashdata(
						'warning',
						'Tidak ada perubahan data yang dilakukan.'
					);
				}
				else {
					$this->session->set_flashdata(
						'error',
						'Data Kendaraan gagal diubah.'
					);
				}
				redirect(base_url() . 'ga/Vehicles');
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