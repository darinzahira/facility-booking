<?php  

	class Room_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
			$this->db->where('isdelete', 1);
			$this->db->from('rooms');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// // CREATE (STORE)
		public function store()
		{
			$room_code = $this->input->post('room_code');
			$room_name = $this->input->post('room_name');
			$capacity = $this->input->post('capacity');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'room_code' => $room_code, 
				'room_name' => $room_name, 
				'capacity' => $capacity, 
				'notes' => $notes, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('rooms', $data);
			return $result;
		}

		// // DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->update('rooms', [
				'isdelete' => 0
			]);

			return $this->db->affected_rows() > 0;
		}

		// // EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('rooms');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}

		// // UPDATE
		public function update()
		{
			$id = $this->input->post('id');
			$room_code = $this->input->post('room_code');
			$room_name = $this->input->post('room_name');
			$capacity = $this->input->post('capacity');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			// Ambil data lama
			$old_data = $this->edit($id);

			// Cek apakah ada perubahan data
			$room_changed = (
				$old_data->room_code != $room_code||
				$old_data->room_name != $room_name||
				$old_data->capacity != $capacity||
				$old_data->notes != $notes||
				$old_data->status != $status
			);

			// Kalau tidak ada perubahan data
			if (!$room_changed){
				return 'no_change';
			}

			$editdata = array(
				'room_code' => $room_code, 
				'room_name' => $room_name, 
				'capacity' => $capacity, 
				'status' => $status,
				'updated_at' => $updated_at
			);

			if (!empty($notes)) {
				$editdata['notes'] = $notes ;
			}

			$this->db->where('id', $id);
			return $this->db->update('rooms', $editdata);
		}

		public function check_room_code($room_code, $id)
		{
			$this->db->where('room_code', $room_code);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('rooms');

			return $query->num_rows() > 0;
		}

		public function check_room_name($room_name, $id)
		{
			$this->db->where('room_name', $room_name);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('rooms');

			return $query->num_rows() > 0;
		}


		// public function get_active()
		// {
		// 	$this->db->where('status', 1);
		// 	return $this->db->get('departments')->result();
		// }
	}
?>