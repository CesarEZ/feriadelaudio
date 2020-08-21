<?php
	class Package_model extends CI_Model{

		//-------------------------------------------------------
		// Get all packages
		public function get_all_packages(){
			$query = $this->db->get('ci_packages');
			// $this->db->order_by('ci_packages.title', 'asc');

			return $result = $query->result_array();
		}

		//-----------------------------------------------------
		// Add Packages
		public function add_package($data){
			$this->db->insert('ci_packages', $data);
			return true;
		}

		//---------------------------------------------------
		// Get package detial by ID
		public function get_package_by_id($id){
			$query = $this->db->get_where('ci_packages', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Update Package
		public function update_package($id, $data){
			$this->db->where('id', $id);
			$this->db->update('ci_packages', $data);
			return true;
		}

	}

?>