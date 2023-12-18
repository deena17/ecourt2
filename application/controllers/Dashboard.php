<?php

    class Dashboard extends CI_Controller{

        public function __construct(){
            parent::__construct();
        }

        public function index(){
            if(!$this->session->userdata('isLoggedIn')){
                redirect('auth/login');
            }
            $this->load->view('dashboard');
        }
    }