<?php  

	class Meeting_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
			$this->db->from('meeting_rooms');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// // CREATE (STORE)
		public function store()
		{
			$room_code = $this->input->post('room_code');
			$room_name = $this->input->post('room_name');
			$capacity = $this->input->post('capacity');
			$location = $this->input->post('location');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'room_code' => $room_code, 
				'room_name' => $room_name, 
				'capacity' => $capacity, 
				'location' => $location, 
				'notes' => $notes, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('meeting_rooms', $data);
			return $result;
		}

		// // DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
    		return $this->db->delete('meeting_rooms');
		}

		// // EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('meeting_rooms');
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
			$location = $this->input->post('location');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			$editdata = array(
				'room_code' => $room_code, 
				'room_name' => $room_name, 
				'capacity' => $capacity, 
				'location' => $location, 
				'status' => $status,
				'updated_at' => $updated_at
			);

			if (!empty($notes)) {
				$editdata['notes'] = $notes ;
			}

			$this->db->where('id', $id);
			return $this->db->update('meeting_rooms', $editdata);
		}

		// public function get_active()
		// {
		// 	$this->db->where('status', 1);
		// 	return $this->db->get('departments')->result();
		// }
	}
?>