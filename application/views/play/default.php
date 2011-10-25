<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang = "pt-br" lang = "pt-br" dir = "ltr" >
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<?php
	echo link_tag('public/images/mk.png','shortcut icon','image/x-icon')."\r\n";
	echo link_tag('public/images/mk.png','icon','image/x-icon')."\r\n";
	echo link_tag('public/css/default.css')."\r\n";
	echo link_tag('public/css/tiles.css')."\r\n";
	echo js_tag(site_url('public/scripts/wok.js'))."\r\n";
?>
		<title> <? echo $title;?> </title>
	</head>

	<body onload = "config()">
		<div id = "wrap">
			<div id = "header">		
				<div id = "title">
					<h1>World of Kingdoms</h1>
				</div>
				<div id = "menu_content">
					<ul id="menu">
                        <li class="active"><?php echo anchor('play', 'Play', 'title="Play WoK"'); ?></li>
                        <li><?php echo anchor('play/info', 'Info', 'title="Info WoK"'); ?></li>
                        <li><?php echo anchor('users/logout', 'Logout', 'title="Exit WoK"'); ?></li>
                    </ul>
				</div>
			</div>
			<div id = "resources">
				<div class = "resource">
					<?= img(array('src' => site_url('public/images/tilesets/food_.png'), 'width' => 16)); ?>=
					<div id = "resource_com" class = "res_number">
						<? echo $resource->food; ?>
					</div>/<div id = "resource_com_max" class = "res_number"><? echo $resource->food_max; ?></div>
					<div id = "resource_com_vel" class = "res_number">+<? echo $resource->food_speed; ?></div> un/h
				</div>
				<div class = "resource">
					<?= img(array('src' => site_url('public/images/tilesets/gold.png'), 'width' => 16)); ?>=
					<div id = "resource_our" class = "res_number">
						<? echo $resource->gold; ?>
					</div>/<div id = "resource_our_max" class = "res_number"><? echo $resource->gold_max?></div> 
					<div id = "resource_our_vel" class = "res_number">+<? echo $resource->gold_speed?></div> un/h
				</div>
			</div>
			<div id = "content">
				<?php
				$data['cells'] = $cells;
				$this->load->view('play/map',$data);
				?>
				<div id = "right_content">
					<h1><?php echo $village->name?></h1>
					<h3>Ticket => <?php echo $ticket?> Time left(<span id = 'clock'>00</span>)</h3>
					<p id = "text">
						0, 0
					</p>
	            	<input type="button" value="_construct" onclick = "javascript: construct()"/>
	            	<input type="button" value="_moveTo" onclick = "javascript: move_to()"/>
				</div>
			</div>
			
			<script type="text/javascript">
				//load_map();	
			</script>
			
			<div id = "footer">   
				Página gerada em {elapsed_time} segundos. Desenvolvido com <a class = "link" href = "http://codeigniter.com"> Code Igniter 2.0.2</a>.
			</div>
		</div>
		<div id = "sql">
		</div>
		<script type="text/javascript">
			//sql_map();
			update();
		</script>
	</body>
</html>