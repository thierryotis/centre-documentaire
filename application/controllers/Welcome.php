<?php
/*
* @ auteur: cedricgaelo@gmail.com
  @ login: cedrico gaelo
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helpers('url');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}
}
