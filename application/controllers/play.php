<?php

class Play extends CI_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library('ignitedrecord/ignitedrecord');
		$this->load->library('auth');
		
		if( ! $this->auth->is_logged_in()) {
			redirect('users');
		}
	}
	
	function index() {
		$this->load->model('village');
		$this->load->model('resource');
		$this->load->model('map_cell');
		$this->load->helper('date');
		
		$village = $this->village->find($this->session->userdata('current_village'));
		$resource = $this->resource->find($village->idvillages);
		
		$t_ant = mysql_to_unix($village->time);
		$t_atu = time();
		$village->time = unix_to_human($t_atu,TRUE,'eu');
		$village->save(); 
		$t_dif = $t_atu - $t_ant;
		
		$resource->food += ($resource->food_speed/3600 * $t_dif);
		$resource->food = $resource->food <= $resource->food_max ? $resource->food : $resource->food_max;
		$resource->gold += ($resource->gold_speed/3600 * $t_dif);
		$resource->gold = $resource->gold <= $resource->gold_max ? $resource->gold : $resource->gold_max;
		
		$resource->save();
		$resource->food = (int) $resource->food;
		$resource->gold = (int) $resource->gold;
		
		$data['title'] = 'World of Kingdoms';
		$data['village'] = $village;
		$data['resource'] = $resource;
		
		$this->map_cell->where('idmaps', 1);
		$data['cells'] = $this->map_cell->find_all();
        
		$time = mdate('%H %i %s'); 
		$time = explode(' ', $time);
		$time = $time[0]*3600 + $time[1]*60 + $time[2];
		$data['ticket'] = (int)($time/30);
		
		$this->load->view('play/default',$data);
	}
    
    function construct($coor_x, $coor_y) {
        $this->load->model('event');
        $event = $this->event->new_record();
        $idvillages = $this->auth->get_data('current_village');
        $event->idvillages = $idvillages;
        $event->ticket = 3;
        $event->status = 1;
        $event->event = "_construct|$idvillages|3|$coor_x|$coor_y";
        $event->save();
        
        redirect('play');
    }
	
	function move_to($to_x, $to_y) {
        $this->load->model('event');
        $event = $this->event->new_record();
        $idvillages = $this->auth->get_data('current_village');
		$coor_x = 3;//$this->auth->get_data('coor_x');
		$coor_y = -3;//$this->auth->get_data('coor_y');
        $event->idvillages = $idvillages;
        $event->ticket = 1;
        $event->status = 1;
        $event->event = "_moveTo|$coor_x|$coor_y|$to_x|$to_y|_construct|$idvillages|3";
        $event->save();
        
        redirect('play');
    }
}
?>