<?php 

    class DashboardModel extends CI_Model{

        public $est_dbname = null;

        public function __construct(){
            parent::__construct();
            $this->est_dbname = $this->session->userdata('est_dbname');
        }

        public function dashboard(){
            return array(
                'listed_today' => $this->listed_today(),
                'registered_today' => $this->registered_today(),
                'unregistered_today' => $this->unregistered_today(),
                'undated_today' => $this->undated_today()
            );
        }


        private function listed_today(){
            $db = $this->load->database($this->est_dbname, true);
            $db->select('count(*)');
            $db->from('civil_t as c');
            $db->join('hearing_status_t as h', 'c.case_no=h.case_no');
            $db->where('h.hearing_date', '2023-12-15');
            if(!empty($this->session->userdata['court_no']))
                $db->where('court_no', $this->session->userdata['court_no']);
            return $db->count_all_results();
        }

        private function registered_today(){
            $db = $this->load->database($this->est_dbname, true);
            $db->select('count(*)');
            $db->from('civil_t as c');
            $db->join('hearing_status_t as h', 'c.case_no=h.case_no');
            $db->where('h.hearing_date', '2023-12-15');
            $db->where('c.regcase_type is not null');
            $db->where('c.reg_no is not null');
            $db->where('c.reg_year is not null');
            if(!empty($this->session->userdata['court_no']))
                $db->where('court_no', $this->session->userdata['court_no']);
            return $db->count_all_results();
        }

        private function unregistered_today(){
            $db = $this->load->database($this->est_dbname, true);
            $db->select('count(*)');
            $db->from('civil_t as c');
            $db->join('hearing_status_t as h', 'c.case_no=h.case_no');
            $db->where('h.hearing_date', '2023-12-15');
            $db->where('c.regcase_type is null');
            $db->where('c.reg_no is null');
            $db->where('c.reg_year is null');
            if(!empty($this->session->userdata['court_no']))
                $db->where('court_no', $this->session->userdata['court_no']);
            return $db->count_all_results();
        }

        private function undated_today(){
            return 0;
        }
    }