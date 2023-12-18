<?php
    class Cases extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('CaseModel', 'case');
        }

        public function get_case_details($filing_number){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->case->get_by_filing_number($filing_number));
        }
    }