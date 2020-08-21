<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Model extends CI_Model{

	//----------------------------------------------------------------------
	// registration
	public function insert_employers($data)
	{
		$this->db->insert('xx_employers',$data);
		$last_id = $this->db->insert_id();
		return  $last_id;
	}

	//----------------------------------------------------------------------
	// Insert company
	public function insert_company($data)
	{
		$this->db->insert('xx_companies',$data);
		$last_id = $this->db->insert_id();
		return  $last_id;
	}

	//----------------------------------------------------------------------
	// Insert emails
	public function insert_employer_emails($data)
	{
		$this->db->insert('xx_employer_emails',$data);
		return  true;
	}

	//----------------------------------------------------------------------
	// Insert phone
	public function insert_employer_phone($data)
	{
		$this->db->insert('xx_employer_phones',$data);
		return  true;
	}

	//----------------------------------------------------------------------
	// login function
	public function login($data)
	{
		$query = $this->db->get_where('xx_employers', array('email' => $data['email']));
		if ($query->num_rows() == 0){
			return array('status' => false, 'message' => 'Invalid email or password');
		}
		else{
			//Compare the password attempt with the password we have stored.
			$result = $query->row_array();
		    $validPassword = password_verify($data['password'], $result['password']);
		    // if($validPassword)
		    // {

		    	$current_date_time = new DateTime;

				$employer_last_login_time = new DateTime($result['last_login']);

				$date_interval = $employer_last_login_time->diff($current_date_time);


		    	if( $date_interval->d > 7 )
		    	{
		    		return array('status' => false, 'message' => 'Account blocked due to no activity from last '.$date_interval->d.' day(s). Please <a href="'.base_url("employers/auth/recover").'">Click Here</a> to activate your account again');
		    		exit();
		    	}
		    	elseif(!$result['is_active'])
		    	{
		    		return array('status' => false, 'message' => 'Your account is under review for Admin Verification');
		    		exit();
		    	}
		    	else
		    	{
			    	return array('status' => true, 'message' => $query->row_array());
		    	}
		    // }
		    // else
		    // {
		    // 	return array('status' => false, 'message' => 'Invalid email or password');
		    // }
		}
	}

	//============ Check User Email ============
    function check_emp_mail($email)
    {
    	$result = $this->db->get_where('xx_employers', array('email' => $email));

    	if($result->num_rows() > 0){
    		$result = $result->row_array();
    		return $result;
    	}
    	else {
    		return false;
    	}
    }

    //============ Update Reset Code Function ===================
    public function update_reset_code($reset_code, $user_id)
    {
    	$data = array('password_reset_code' => $reset_code);
    	$this->db->where('id', $user_id);
    	$this->db->update('xx_employers', $data);
    }

    public function add_reason($data)
    {
    	$this->db->insert('xx_employer_account_recovery',$data);
    	return true;
    }

    //============ Activation code for Password Reset Function ===================
    public function check_password_reset_code($code)
    {

    	$result = $this->db->get_where('xx_employers',  array('password_reset_code' => $code ));
    	if($result->num_rows() > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    //============ Reset Password ===================
    public function reset_password($id, $new_password){
	    $data = array(
			'password_reset_code' => '',
			'password' => $new_password
	    );
		$this->db->where('password_reset_code', $id);
		$this->db->update('xx_employers', $data);
		return true;
    }

    // Update employer last login
    public function updated_employer_last_login($id,$data)
    {
    	$this->db->where('id', $id);
		$this->db->update('xx_employers', $data);
		return true;
    }

} // endClass

?>