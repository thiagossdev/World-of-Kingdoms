<?php

class Admin extends CI_Controller {
	
	function __construct()	{
		parent::__construct();
		
        $this->load->library('ignitedrecord/ignitedrecord');
		$this->load->library('auth');
        
        $this->load->helper('date');
		$this->load->helper('file');
		$this->load->helper('time');
		
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
        
		$this->load->model('user');
		$this->load->model('event');
		$this->load->model('village');
		$this->load->model('map_cell');
		$this->load->model('resource');
        $this->load->model('build');
		
		/*if(!$this->auth->is_logged_in()) {
			redirect('users/login');
		}*/
	}
	
	function index() {
		redirect('admin/login');
	}
	
	function login() {
		//if($this->session->userdata('online') == "on") redirect("acesso_invalido");

		//$dados = $this->verificar();

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('', '<br/>');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "World of Kingdoms";
			$this->load->view('admin/login',$data);
		} else {
			redirect('admin/server');
		}
	}
  
	function validar_logon($nickname) {
		$this->user->where('nickname',$nickname);
		$password = set_value('password');
		$this->user->where('password', $password != '' ? $password : 'password');
		$users = $this->user->find_all();

		if (count($users) == 0 || !($nickname === "annubys")) {
			return FALSE;
		} else {
			foreach($users as $user);
			$data['user_id'] = $user->idusers;
			$data['nickname'] = $user->nickname;
			$data['current_village'] = $user->current_village;
			$this->auth->login($data);

			return TRUE;
		}
	}
	
	function server() {
		if($this->auth->is_logged_in()) {
			$data['title'] = "World of Kingdoms - Server Config";
			$this->load->view('admin/server',$data);
		} else {
			redirect('admin');
		}
	}
	
	function cmd_server($cmd) {
		switch ($cmd) {
			case 'start':
				$this->cache->save('server_status', 'ON', 60*60);
				$date = mdate('%Y/%m/%d %h:%i:%s');
				write_file('public/logs/_MASTER_LOG.log', "Log criado em $date.\n",'a');
				$this->run_server();
			break;
			case 'check':
				$this->run_server();
			break;
			case 'stop':
				if($this->cache->get('server_status')) { 
					$this->cache->delete('server_status');
				}
				redirect('admin/server');
			break;
		}
	}
	
	private function run_server() {
		set_time_limit(0);
		
		$ticket = 10;
		$first_ticket = calc_ticket($ticket);
		$filename = 'public/logs/LOG';
		
		if($first_ticket < (int)($ticket/3)) $first_ticket + $ticket;
		sleep($first_ticket);
		$filename = $filename.mdate('%Y-%m-%d_%h-%i-%s').'.log';
		echo "Log criado em $filename.";
		$status = $this->cache->get('server_status');
		$data['title'] = "World of Kingdoms - Server Config";
		$data['i'] = mdate('%Y/%m/%d %H:%i:%s');
		while($status === 'ON') {
			sleep(calc_ticket($ticket));
			
            $this->check_events($filename);
            
			$status = $this->cache->get('server_status');
		}
	}
    
    private function check_events($filename) {
        write_file($filename, '<>'.mdate('%Y/%m/%d %h:%i:%s')."\n", 'a');
        $this->event->where('status',1);
        $events = $this->event->find_all();
        foreach ($events as $event) {
            if($event->ticket == 1) {
                write_file($filename, "--->Event_$event->idevents>: <CMD>$event->event.\n", 'a');
                $village = $this->village->find($event->idvillages);
                $resource = $this->resource->find($event->idvillages);
                
                /////////////////////////////////////////////////
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
                /////////////////////////////////////////////////
                
                //$commands = explode(' ', $event->event);
                //foreach ($commands as $command) {
                    $command = explode('|', $event->event);
                    
                    switch ($command[0]) {
                        case 'FOOD_SPEED':
							$event->status = 2;
                            $resource->food_speed+= $command[1];
                            $resource->save();	
                        break;
                        case 'GOLD_SPEED':
							$event->status = 2;
                            $resource->gold_speed+= $command[1];
                            $resource->save();
                        break;
                        case '_construct':
							$event->status = 2;
                            $coor_x = $command[3];
                            $coor_y = -$command[4];

                            $build = $this->build->new_record();
                            $build->idvillages = $command[1];
                            $build->idbuildings = $command[2];
                            $build->coor_x = $coor_x;
                            $build->coor_y = $coor_y;
                            $build->save();
                            
                            $this->map_cell->where('idmaps', 1);
                            $this->map_cell->where('coor_x', "$coor_x");
                            
                            $this->map_cell->where('coor_y', "$coor_y");
                            $cells = $this->map_cell->find_all();
                            foreach($cells as $cell) {
                                $cell->idtype_cells = 3;
                                $cell->layer_2 = 25;
                                $cell->save();
                                break;
                            }
                            
                        break;
                        case '_moveTo':
                        	$coor_x = $command[1];
                            $coor_y = -$command[2];
                            $to_x = $command[3];
                            $to_y = -$command[4];
							
							if($coor_x == $to_x && $coor_y == $to_y) {
								$evt = $this->event->new_record();
								
								$evt->idvillages = $event->idvillages;
        						$evt->ticket = 3;
        						$evt->status = 1;
        						$evt->event = "$command[5]|$command[6]|$command[7]|$command[3]|$command[4]";
								$evt->save();
								$event->status = 2;
							} else {
								$n_coor_x = $coor_x;
								$n_coor_y = $coor_y;
								if($coor_x != $to_x) {
									$n_coor_x += $coor_x < $to_x ? 1 : -1;
								} else if($coor_y != $to_y){
									$n_coor_y += $coor_y < $to_y ? 1 : -1;
								}
								$event->ticket++;
								
								$this->map_cell->where('idmaps', 1);
	                            $this->map_cell->where('coor_x', "$n_coor_x");
	                            $this->map_cell->where('coor_y', "$n_coor_y");
	                            $cells = $this->map_cell->find_all();
	                            foreach($cells as $cell) {
	                                $cell->idtype_cells = 3;
	                                $cell->layer_3 = 1;
	                                $cell->save();
	                                break;
	                            }
								
								$n_coor_y = -$n_coor_y;
								$event->event = "_moveTo|$n_coor_x|$n_coor_y|$command[3]|$command[4]|$command[5]|$command[6]|$command[7]";
	                            
								$this->map_cell->where('idmaps', 1);
	                            $this->map_cell->where('coor_x', "$coor_x");
	                            $this->map_cell->where('coor_y', "$coor_y");
	                            $cells = $this->map_cell->find_all();
	                            foreach($cells as $cell) {
	                                $cell->idtype_cells = 3;
	                                $cell->layer_3 = 0;
	                                $cell->save();
									write_file($filename, "ARF\n", 'a');
	                                break;
	                            }
								write_file($filename, "$coor_x, $coor_y\n", 'a');
							}
                        break;
                    }
                }
            //}
            $event->ticket--;
            $event->save();
        }
        write_file($filename, '><'.mdate('%Y/%m/%d %h:%i:%s')."\n\n", 'a');
    }
}
/* END OF FILE*/