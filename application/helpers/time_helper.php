<?php
	function dataNormalToMySql($data) {
		$array = explode('/',$data);
		return "$array[2]-$array[1]-$array[0]"; 
	}

	function dataMySqlToNormal($data) {
		$array = explode('-',$data);
		return array('a' => $array[2], 'm' => $array[1], 'd' => $array[0]); 
	}
	
	function timeNormalToMySql($time) {
		return "$time[h]:$time[m]:$time[s]";
	}
	
	function timeMySqlToNormal($time) {
		$array = explode(':',$time);
		return array('s' => $array[2], 'm' => $array[1], 'h' => $array[0]);
	}
	
	function time_to_sec($time) { 
		return $time['h'] * 3600 + $time['m'] * 60 + $time['s']; 
	}
	
	function calc_ticket($seconds_per_ticket) {
		$time_old = mdate('%i %s'); 
		$time_old = explode(' ', $time_old);
		$time_old = $time_old[0]*60 + $time_old[1];
		
		$number_old_tickets = (int)($time_old/$seconds_per_ticket);
		$time_new = ($number_old_tickets+1) * $seconds_per_ticket - $time_old;
		
		return $time_new;
	}
?>