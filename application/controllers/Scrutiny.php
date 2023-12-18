<?php
    class Scrutiny extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'auth');
            $this->load->model('EstablishmentModel', 'est');
            $this->load->model('CaseModel', 'case');
            $this->load->model('ObjectionModel', 'objection');
            $this->load->model('IndexRegisterModel', 'indexregister');
        }

        public function index(){
            $this->load->view('index');
        }

        public function objection(){
            if(!$this->session->userdata('isLoggedIn')){
                return redirect('auth/login');
            }
            if(!$this->permission->has(['FORA'])){
                $this->load->view('auth/403');
            }
            $this->data['cases'] = $this->case->get_filing_numbers();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->form_validation->set_rules('filing_number', 'filing_number', 'required');
                $this->form_validation->set_rules('objection', 'objection', 'required');
                $this->form_validation->set_rules('scrutiny_date', 'scrutiny_date', 'required');
                if($this->input->post('objection') == 'Y'){
                    $this->form_validation->set_rules('objection_remarks', 'objection_remarks', 'required');
                    $this->form_validation->set_rules('communication_date', 'communication_date', 'required');
                    $this->form_validation->set_rules('compliance_date', 'compliance_date', 'required');
                    $this->form_validation->set_rules('receipt_date', 'receipt_date', 'required');
                }
                if($this->form_validation->run() == FALSE){
                    $this->load->view('scrutiny/objection', $this->data);
                }
                else{
                    $data = array(
                        'filing_number'         => $this->input->post('filing_number'),
                        'objection'             => $this->input->post('objection'),
                        'scrutiny_date'         => $this->input->post('scrutiny_date'),
                        'objection_remarks'     => $this->input->post('objection_remarks'),
                        'communication_date'    => $this->input->post('communication_date'),
                        'compliance_date'       => $this->input->post('compliance_date'),
                        'receipt_date'          => $this->input->post('receipt_date')
                    );
                    $result = $this->objection->update_objection($data);
                    if(!$result){
                        $this->session->set_flashdata('alert-class', 'alert-danger');
                        $this->session->set_flashdata('message', 'Something went wrong. Please try later!');
                    }else{
                        $filing_no  = $data['filing_number'];
                        return redirect("scrutiny/$filing_no/objection/documents");
                    }
                }
            }
            $this->load->view('scrutiny/objection', $this->data);
        }

        public function list_documents($filing_number){
            $this->data['documents'] = $this->indexregister->getEIndexRegisters($filing_number);
            $this->load->view('scrutiny/document_objection', $this->data);
        }

        public function update_objection($cino){
            $data = array(
                'cino'      => $this->input->post('cino'),
                'srno'      => $this->input->post('srno'),
                'objection' => $this->input->post('objection'),
                'remarks'   => $this->input->post('remarks')
            );
            $result = $this->indexregister->update_objection($data);
            if($result){
                return TRUE;
            }
            return FALSE;
        }


        public function get($filing_number){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->case->getDetailsByFilingNumber($filing_number));
        }

        
    }