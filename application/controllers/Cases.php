<?php
    class Cases extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('CaseModel', 'case');
        }

        public function getDetailsByFilingNo($filing_number){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->case->getDetailsByFilingNumber($filing_number));
        }
    }