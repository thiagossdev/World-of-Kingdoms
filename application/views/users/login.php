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
			<?= form_open('users/login',array('id' => 'login_form')); ?>
				<div id = "login">	
						<p>
							Nickname: <?= form_input('nickname', set_value('nickname')); ?>
						</p>
						<p>
							Password: <?= form_password('password', ''); ?>
						</p>
						<p class = "tam05">
							<a class = "" href="<?=site_url('users/create_account')?>"> Create Account</a><br/>
							<?= validation_errors(); ?>
						</p>
				</div>
				<?= submit_js('login_ok', 'login_form'); ?>
			<?= form_close(); ?>
		</div>
	</body>
</html>