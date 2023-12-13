<?php
    class Auth extends CI_Controller{

        public function __construct(){
            parent::__construct();
            $this->load->model('AuthModel', 'a');
            $this->load->model('EstablishmentModel', 'e');
        }

        function check_default($option){
            return $option == '0' ? FALSE : TRUE;
        }

        public function login(){
            $data['establishment'] = $this->e->getEstablishments();
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('establishment', 'Establishment', 'callback_check_default');
            $this->form_validation->set_message('check_default', 'You should select one value from list');
            if($this->form_validation->run()===FALSE){
                $this->load->view('pages/login', $data);
            }
            else{
                $post_data = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'establishment' => $this->input->post('establishment')
                );
                $result = $this->a->login($post_data);
                if($result){
                    $userdata = $this->a->userInformation($post_data['username'], $post_data['establishment']);
                    $session_data = array(
                        'establishment' => $post_data['establishment'],
                        'username' => $userdata->username,
                        'fullname' => $userdata->full_name,
                        'court_no' => $userdata->court_id,
                        'isLoggedIn' => true
                    );
                    $this->session->set_userdata($session_data);
                    redirect('disposed');
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong. Try again later!!!'
                    );
                   redirect('auth/login', $data);
                }
            }
        }
        public function logout(){
            $this->session->sess_destroy();
            redirect('auth/login');
        }
    }