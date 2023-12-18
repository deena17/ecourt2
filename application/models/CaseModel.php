<?php 

    class CaseModel extends CI_Model{

        public $est_dbname = null; 

        public function __construct(){
            parent::__construct();
            $this->est_dbname = $this->session->userdata('est_dbname');
        }

        public function get_case_types(){
            $db = $this->load->database($this->est_dbname, TRUE);
            return $db->where('display', 'Y')->order_by('type_name', 'ASC')->get('case_type_t')->result();
        }

        public function get_filing_numbers(){
            $user_case_type = $this->session->userdata['case_type'];
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->select("CONCAT(t.type_name,'/',c.fil_no,'/',c.fil_year) AS case_number, c.cino");
            $db->from('civil_t as c');
            $db->join('case_type_t as t', 't.case_type=c.filcase_type');
            $db->where('c.reg_no is null');
            if(!empty($user_case_type)){
                $db->where_in('filcase_type', $user_case_type);
            }
            return $db->get()->result();
        }

        public function get_by_filing_number($filing_number){
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->select('*');
            $db->from('civil_t');
            $db->where('cino', $filing_number);
            return $db->get()->row();
        }

        
    }
