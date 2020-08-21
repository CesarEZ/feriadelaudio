<?php
	class Invoice_model extends CI_Model{

		//---------------------------------------------------
		// Get Customer detial by ID
		public function customer_detail($id){
			$query = $this->db->get_where('ci_users', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Insert New Invoice
		public function add_invoice($data){
			return $this->db->insert('ci_payments', $data);
		}

		//---------------------------------------------------
		// Insert New Invoice
		public function add_company($data){
			$this->db->insert('ci_companies', $data);
			return $this->db->insert_id();
		}

		//---------------------------------------------------
		// Get Add Invoices
		public function get_all_invoices(){
			$this->db->select('
					ci_payments.id,
	    			ci_payments.invoice_no,
	    			ci_users.firstname,
	    			ci_users.lastname,
	    			ci_payments.payment_status,
					ci_payments.grand_total,
					ci_payments.currency,
					ci_payments.due_date,
					ci_payments.created_date,
					ci_ads.title
					'
	    	);
	    	$this->db->from('ci_payments');
	    	$this->db->join('ci_users', 'ci_users.id = ci_payments.user_id ', 'Left');
	    	$this->db->join('ci_ads', 'ci_ads.id = ci_payments.ad_id ', 'Left');
	    	$query = $this->db->get();					 
			return $query->result_array();
		}

		//---------------------------------------------------
		// Get Customers List for Invoice
		public function get_customer_list(){
			$this->db->select('id, UPPER(CONCAT(firstname, ' . ' ,lastname)) as username');
			$this->db->from('ci_users');
			return $this->db->get()->result_array();
		}


		//---------------------------------------------------
		// Get Invoice Detil by ID
		public function get_invoice_by_id($id){

			$this->db->select('
					ci_payments.id,
					ci_payments.user_id as client_id,
	    			ci_payments.invoice_no,
	    			ci_payments.payment_status,
	    			ci_payments.package_id,
	    			ci_payments.sub_total,
	    			ci_payments.total_tax,
	    			ci_payments.discount,
					ci_payments.grand_total,
					ci_payments.currency,
					ci_payments.client_note,
					ci_payments.due_date,
					ci_payments.created_date,
					ci_users.firstname,
					ci_users.lastname,
					ci_users.email as client_email,
					ci_users.contact as client_mobile_no,
					ci_users.address as client_address,
					ci_ads.title as post_title,
					ci_packages.title as package,
					ci_packages.price as package_price
					'
	    	);
	    	$this->db->from('ci_payments');
	    	$this->db->join('ci_users', 'ci_users.id = ci_payments.user_id ', 'Left');
	    	$this->db->join('ci_ads', 'ci_ads.id = ci_payments.ad_id ', 'Left');
	    	$this->db->join('ci_packages', 'ci_packages.id = ci_payments.package_id ', 'Left');
	    	$this->db->where('ci_payments.id' , $id);
	    	$query = $this->db->get();					 
			return $query->row_array();

		}



		//---------------------------------------------------
		// Get Invoice Detil by ID
		public function update_invoice($data, $id){
			$this->db->where('id', $id);
			return $this->db->update('ci_payments', $data);
		}

		//---------------------------------------------------
		// Update Customer Detail in invoice
		public function update_company($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_companies', $data);
			return $id; // return the updated id
		}

		
	}

?>