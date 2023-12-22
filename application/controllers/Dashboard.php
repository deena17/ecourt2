<?php

    class Dashboard extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('DashboardModel', 'd');
        }

        public function index(){
            if(!$this->session->userdata('isLoggedIn')){
                redirect('auth/login');
            }
            $this->data = $this->d->dashboard(); 
            $this->load->view('index', $this->data);
        }
    }