<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang = "pt-br" lang = "pt-br" dir = "ltr" >
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

		<?=link_tag('public/images/mk.png','shortcut icon','image/x-icon'); ?>
		
		<?=link_tag('public/images/mk.png','icon','image/x-icon'); ?>
		
		<?=link_tag('public/css/default.css'); ?>
		
		
		<title> <?=$title?> </title>
	</head>
	
	<body>
		<div id = "login_wrap"> 	
			<?= img(array('src' => site_url('public/images/structure/wok_top.png'))); ?>
			
			<div id = "server">
				<h1>Server: </h1>
				<p>
					<input type="button" value="START" onclick = "<? echo location(site_url('admin/cmd_server/start')); ?>"/>
					<input type="button" value="STOP" onclick = "<? echo location(site_url('admin/cmd_server/stop')); ?>"/>
				</p>
			</div>
		</div>
	</body>
</html>