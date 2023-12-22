<?php
    class IndexRegister extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'auth');
            $this->load->model('CaseModel', 'case');
            $this->load->model('IndexRegisterModel', 'index');
        }


        public function cause_list(){
            if(!$this->session->userdata('isLoggedIn')){
                return redirect('auth/login');
            }
            $this->data['title'] = 'Today Cause List';
            $this->data['cases'] = $this->index->cause_list();
            $this->load->view('templates/header', $this->data);
            $this->load->view('indexregister/cause_list', $this->data);
            $this->load->view('templates/footer');
        }


        public function search_index(){
            if(!$this->session->userdata('isLoggedIn')){
                return redirect('auth/login');
            }
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
                        'court_no'          => $this->session->userdata('court_no'),
                    );
                    $indexs = $this->index->getIndexRegisters($data);
                    if(!$indexs){
                        $this->session->set_flashdata('alert-class', 'alert-warning');
                        $this->session->set_flashdata('message', 'Case does not exist or not belongs to this court');
                        return redirect('indexregister/search');
                    }
                    if($indexs){
                        $this->data['case_type'] = $this->case->get_case_types();
                        $this->data['indexs'] = $indexs;
                    }
                }
            }
            $this->load->view('indexregister/search', $this->data);   
        }


        public function list_index($cino){
            if(!$this->session->userdata('isLoggedIn')){
                return redirect('auth/login');
            }
            $documents = $this->index->getIndexRegisterBycino($cino);
            if($documents){
                $this->data['indexs'] = $documents;
            }else{
                $this->data['noindex'] = true;
            }
            $this->load->view('indexregister/documents', $this->data);   
        }
        

        public function delete(){
            header('Content-Type: application/json; charset=utf-8');
            $cino = $this->input->post('cino');
            $srno = $this->input->post('srno');
            $result = $this->index->delete_index_register($cino, $srno);
            if($result):
                echo json_encode(array(
                    'status' => 'success',
                    'code'   => 200
                ));
            else:
                echo json_encode(array(
                    'status' => 'failure',
                    'code'   => 400
                ));
            endif;
        }

        public function delete_selected(){
            header('Content-Type: application/json; charset=utf-8');
            $cino = $this->input->post('cino');
            $srno = $this->input->post('srno');
            $result = $this->index->delete_index_register($cino, $srno);
            if($result):
                echo json_encode(array(
                    'status' => 'success',
                    'code'   => 200
                ));
            else:
                echo json_encode(array(
                    'status' => 'failure',
                    'code'   => 400
                ));
            endif;
        }

        public function objection(){
            $this->data['title'] = 'Welcome';
            $this->data['cases'] = $this->case->getFilingNumbers();
            $this->data['objections'] = $this->objection->getObjectionList();
            $this->load->view('scrutiny', $this->data);
        }

        public function indexregister(){
            $this->data['title'] = 'Welcome';
            $this->data['indexes'] = $this->index->getEIndexRegisters();
            $this->load->view('index_register', $this->data);
        }


        public function get($filing_number){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->case->getDetailsByFilingNumber($filing_number));
        }

        public function get_index_document($cino, $srno){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->index->get_index_document($cino, $srno));
        }

        public function get_eindex_document($cino, $srno){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->index->get_eindex_document($cino, $srno));
        }
    }