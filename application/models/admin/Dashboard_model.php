<?php
	class Dashboard_model extends CI_Model{

		public function get_all_users(){
			return $this->db->count_all('ci_users');
		}

		public function get_active_users(){
			$this->db->where('is_active', 1);
			return $this->db->count_all_results('ci_users');
		}

		public function get_deactive_users(){
			$this->db->where('is_active', 0);
			return $this->db->count_all_results('ci_users');
		}

		public function get_active_ads(){
			$this->db->where('is_status', 1);
			return $this->db->count_all_results('ci_ads');
		}
		
		public function get_pending_ads(){
			$this->db->where('is_status', 0);
			return $this->db->count_all_results('ci_ads');
		}
	}

?>
