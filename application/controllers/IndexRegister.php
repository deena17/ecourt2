<?php
    class IndexRegister extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'auth');
            $this->load->model('EstablishmentModel', 'est');
            $this->load->model('CaseModel', 'case');
            $this->load->model('IndexRegisterModel', 'indexregister');
        }

        public function index(){
            $this->data['title'] = 'Welcome';
            $this->data['indexes'] = $this->indexregister->getEIndexRegisters();
            $this->load->view('index_register', $this->data);
        }

        public function cause_list(){
            $this->data['cases'] = $this->indexregister->cause_list();
            $this->load->view('indexregister/cause_list', $this->data);
        }

        public function search(){
            $this->data['case_type'] = $this->case->get_case_types();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->form_validation->set_rules('case_type', 'case_type', 'required');
                $this->form_validation->set_rules('case_no', 'case_no', 'required');
                $this->form_validation->set_rules('case_year', 'case_year', 'required');
                if($this->form_validation->run() == FALSE){
                    $this->load->view('indexregister/list', $this->data);
                }
                else{
                    $data = array(
                        'case_type'         => $this->input->post('case_type'),
                        'case_no'           => $this->input->post('case_no'),
                        'case_year'         => $this->input->post('case_year'),
                    );
                    $indexs = $this->indexregister->getIndexRegisters($data);
                    if($indexs){
                        $this->data['case_type'] = $this->case->get_case_types();
                        $this->data['indexs'] = $indexs;
                    }
                }
            }
            $this->load->view('indexregister/list', $this->data);   
        }

        public function documents($cino){
            $documents = $this->indexregister->getIndexRegisterBycino($cino);
            if($documents){
                $this->data['indexs'] = $documents;
            }else{
                $this->data['noindex'] = true;
            }
            $this->load->view('indexregister/documents', $this->data);   
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

        public function get_index_document($cino, $srno){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->indexregister->get_index_document($cino, $srno));
        }

        public function get_eindex_document($cino, $srno){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->indexregister->get_eindex_document($cino, $srno));
        }
    }