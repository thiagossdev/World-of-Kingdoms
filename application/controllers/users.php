<?php

class Users extends CI_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library('ignitedrecord/ignitedrecord');
		$this->load->library('auth');
		$this->load->model('user');

	}
	
	function index() {
		redirect('users/login');
	}
	
	function login() {
		//if($this->session->userdata('online') == "on") redirect("acesso_invalido");

		//$dados = $this->verificar();

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('', '<br/>');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "World of Kingdoms";
			$this->load->view('users/login',$data);
		} else {
			redirect('play');
		}
	}
  
	function validar_logon($nickname) {
		$this->user->where('nickname',$nickname);
		$password = set_value('password');
		$this->user->where('password', $password != '' ? $password : 'password');
		$users = $this->user->find_all();

		if (count($users) == 0) {
			return FALSE;
		} else {
			$this->load->model('village');
			foreach($users as $user);
			$data['user_id'] = $user->idusers;
			$data['nickname'] = $user->nickname;
			$data['current_village'] = $user->current_village;
			$this->auth->login($data);

			return TRUE;
		}
	}
	
	function create_account() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<p class = "size05" >', '</p>');
		
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "World of Kingdoms - Create Account";
			$this->load->view('users/create_account',$data);
		} else {
			$this->load->helper('meu_html_helper');
			$user = $this->user->new_record();
			fillAttributes($user, $this->input->post('user'));
			$user->save();
			redirect('');
		}
	}
	
	function logout() {
		if( ! $this->auth->is_logged_in()) {
			redirect('users');
		} else {
			$this->auth->logout();
			redirect('users');
		}
	}
}
/* END OF FILE*/