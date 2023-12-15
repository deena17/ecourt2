<?php
    class Scrutiny extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'a');
            $this->load->model('EstablishmentModel', 'e');
            $this->load->model('CaseModel', 'case');
            $this->load->model('ObjectionModel', 'objection');
            $this->load->model('IndexRegisterModel', 'indexregister');
        }

        public function index(){
            $this->load->view('index');
        }

        public function objection(){
            $this->data['title'] = 'Welcome';
            $this->data['cases'] = $this->case->getFilingNumbers();
            $this->data['objections'] = $this->objection->getObjectionList();
            $this->load->view('scrutiny', $this->data);
        }

        public function indexregister(){
            $this->data['title'] = 'Welcome';
            $this->data['indexes'] = $this->indexregister->getEIndexRegisters();
            $this->load->view('index_register', $this->data);
        }


        public function get($filing_number){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->case->getDetailsByFilingNumber($filing_number));
        }
    }