<?php
    class Auth extends CI_Controller{

        public $data = [];

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'authModel');
            $this->load->model('EstablishmentModel', 'e');
        }

        public function index(){
            redirect('auth/login');
        }

        public function login(){
            $this->data['establishment'] = $this->e->getEstablishments();
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('establishment', 'Establishment', 'required');
            $this->form_validation->set_message('check_default', 'You should select one value from list');
            if($this->form_validation->run()===FALSE){
                $this->load->view('auth/login.php', $this->data);
            }
            else{
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'establishment' => $this->input->post('establishment')
                );
                $result = $this->authModel->login($data);
                if(!empty($result)){
                    $userRole = $this->authModel->verifyRole($result->userid, $data['establishment']);
                    if(!$userRole){
                        $this->session->set_flashdata('alert-class', 'alert-warning');
                        $this->session->set_flashdata('message', 'User role not defined. Contact System Administrator');
                        return redirect('auth/login');
                    }
                    $userdata = $this->authModel->userInformation($data['username'], $data['establishment']);
                    $session_data = array(
                        'username'      => $userdata['user']->username,
                        'fullname'      => $userdata['user']->full_name,
                        'userid'        => $userdata['user']->userid,
                        'establishment' => $userdata['role']->establishmentid,
                        'est_dbname'    => $data['establishment'],
                        'court_no'      => $userdata['role']->court_id,
                        'role'          => [$userdata['role']->role_type_id],
                        'case_type'     => $userdata['case_type'],
                        'isLoggedIn'    => true
                    );
                    $this->session->set_userdata($session_data);
                    redirect('dashboard');
                }
                else{
                    $this->session->set_flashdata('alert-class', 'alert-danger');
                    $this->session->set_flashdata('message', 'Invalid username or password');
                    $this->load->view('auth/login', $this->data);
                }
            }
        }
        
        public function logout(){
            // $this->session->sess_destroy();
            $this->session->unset_userdata(array(
                'username', 'fullname', 'userid', 'establishment', 'est_dbname', 'court_no', 'role', 'case_type', 'isLoggedIn'
            ));
            $this->session->set_flashdata('alert-class', 'alert-success');
            $this->session->set_flashdata('message', 'You are logged out successfully');
            redirect('auth/login');
        }

        public function user_casetype(){
            $this->data['users'] = $this->authModel->getUsers();
            $this->data['case_type'] = $this->authModel->getCaseType();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = array(
                    'user_id' => $this->input->post('user'),
                    'case_type' => $this->input->post('case_type')
                );
                $result = $this->authModel->saveUserCaseType($data);
                if($result){
                    $this->session->set_flashdata('alert-class', 'alert-success');
                    $this->session->set_flashdata('message', 'Casetype updated successfully');
                    $this->load->view('auth/user_casetype', $this->data);
                }
                else{
                    $this->session->set_flashdata('alert-class', 'alert-danger');
                    $this->session->set_flashdata('message', 'Something went wrong. Please try later!');
                    $this->load->view('auth/user_casetype', $this->data);
                }
            }
            $this->load->view('auth/user_casetype', $this->data);
        }

        public function error404(){
            $this->load->view('auth/404');
        }
    }