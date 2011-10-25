<?php

$config = array(
  'users/create_account' => array(
    array(
      'field' => 'user[name]',
      'label' => 'Name',
      'rules' => 'trim|required|max_length[60]'
    ),
    array(
      'field' => 'usuario[email]',
      'label' => 'Email',
      'rules' => 'trim|required|valid_email'
    ),
    array(
      'field' => 'usuario[login]',
      'label' => 'Login',
      'rules' => 'trim|required|alfa_numeric|min_length[4]|max_length[16]|xss_clean|callback_validar_login'
    ),
    array(
      'field' => 'usuario[senha]',
      'label' => 'Senha',
      'rules' => 'trim|required|alfa_numeric|min_length[6]|max_length[16]|matches[confsenha]|md5'
    ),
    array(
      'field' => 'confsenha',
      'label' => 'Confirmação de Senha',
      'rules' => 'trim|required'
    )
  ),

  'users/login' => array(
    array(
      'field' => 'password',
      'label' => 'Password',
      'rules' => 'trim|required|alfa_numeric'
    ),
    array(
      'field' => 'nickname',
      'label' => 'Nickname',
      'rules' => 'trim|required|alfa_numeric|xss_clean|callback_validar_logon'
    )
  ),
  
  'admin/login' => array(
    array(
      'field' => 'password',
      'label' => 'Password',
      'rules' => 'trim|required|alfa_numeric'
    ),
    array(
      'field' => 'nickname',
      'label' => 'Nickname',
      'rules' => 'trim|required|alfa_numeric|xss_clean|callback_validar_logon'
    )
  )
  
);

?>