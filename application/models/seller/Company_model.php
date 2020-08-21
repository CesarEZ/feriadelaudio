<?php  defined('BASEPATH') OR exit('No direct script access allowed');
class Company_Model extends CI_Model{

	//----------------------------------------------------------------------
	// Get company info
	public function company_info($data)
	{
		$this->db->insert('xx_company_info',$data);
		return true;
	}

	//----------------------------------------------------------------------
	// Get company by ID
	public function get_company_info_by_id($emp_id)
	{
		$query = $this->db->get_where('xx_companies', array( 'employer_id' => $emp_id));
		return $result = $query->row_array();
	}

	//----------------------------------------------------------------------
	// Get company by ID
	public function get_company_emails($emp_id)
	{
		$query = $this->db->get_where('xx_employer_emails', array( 'emp_id' => $emp_id));
		return $result = $query->result_array();
	}

	//----------------------------------------------------------------------
	// Get company by ID
	public function get_company_phones($emp_id)
	{
		$query = $this->db->get_where('xx_employer_phones', array( 'emp_id' => $emp_id));
		return $result = $query->result_array();
	}

	//----------------------------------------------------------------------
	// Update Company
	public function update_company_info($data, $comp_id, $emp_id)
	{
		$this->db->where('id',$comp_id);
		$this->db->where('employer_id',$emp_id);
		$this->db->update('xx_companies',$data);
		echo $this->db->last_query();
		return true;
	}

	//----------------------------------------------------------------------
	// Update Employer
	public function update_employer($data,$e_id)
	{
		$this->db->where('id',$e_id);
		$this->db->update('xx_employers',$data);
		return true;
	}

	//----------------------------------------------------------------------
	// Get company info
	public function get_info_by_id($e_id)
	{
		$query = $this->db->get_where('xx_company_info', array('employer_id' => $e_id ));
		return $result = $query->row_array();
	}

	//----------------------------------------------------------------------
	// Insert emails
	public function insert_employer_emails($data)
	{
		$this->db->insert('xx_employer_emails',$data);
		return  true;
	}

	public function delete_employer_emails($id)
	{
		$this->db->where('emp_id',$id);
		$this->db->delete('xx_employer_emails');
		return  true;
	}

	//----------------------------------------------------------------------
	// Insert phone
	public function insert_employer_phone($data)
	{
		$this->db->insert('xx_employer_phones',$data);
		return  true;
	}

	public function delete_employer_phone($id)
	{
		$this->db->where('emp_id',$id);
		$this->db->delete('xx_employer_phones');
		return  true;
	}


		
} // endClass
?>