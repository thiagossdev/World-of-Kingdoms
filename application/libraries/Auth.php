<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth {
	var $CI;
	
	function __construct()	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}
	
    public function login($data) {
		$data['is_logged_in'] = TRUE;
		$this->CI->session->set_userdata($data);
    }
	
	public function is_logged_in() {
		return $this->CI->session->userdata('is_logged_in') === TRUE;
    }
	
	public function logout() {
		$this->CI->session->sess_destroy();
	}
	
	public function has_access() {
		return TRUE;
    }
	
	public function get_user_id() {
		return $this->CI->session->userdata('usuario_id');
	}
    
    public function get_data($data) {
		return $this->CI->session->userdata($data);
	}
}

/* End of file Auth.php */