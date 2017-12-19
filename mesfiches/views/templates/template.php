<?php

$data['message']=$message;

$this->load->view('templates/header');
$this->load->view('templates/nav');
$this->load->view('templates/message');
$this->load->view('content/'.$vue,$data);
$this->load->view('templates/footer');


?>
