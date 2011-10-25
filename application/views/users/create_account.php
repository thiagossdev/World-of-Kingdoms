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
			<div id = "create">
				<?= form_open("users/create_account") ?>
					<p>
						Name: <?= form_input('user[name]', set_value('user[name]')); ?>
					</p>
					<?= form_error('user[name]'); ?>
					<p>
						Nickname: <?= form_input('user[nickname]', set_value('user[nickname]')); ?>
					</p>
					<?= form_error('user[nickname]'); ?>
					<p>
						Password: <?= form_password('user[password]', ''); ?>
					</p>
					<?= form_error('user[password]'); ?>
					<p>
						Re-type: <?= form_password('retype', ''); ?>
					</p>
					<?= form_error('retype'); ?>
					<p>
						<input type="submit" value="CREATE" />
						<input type="button" value="BACK" onclick = "javascript: history.go(-1)"/>
					</p>
				<?= form_close(); ?>
			</div>
		</div>
	</body>
</html>