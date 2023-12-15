<?php 

    class CaseModel extends CI_Model{

        public function getFilingNumbers(){
            $db = $this->load->database('chnccc', TRUE);
            $db->select("CONCAT(t.type_name,'/',c.fil_no,'/',c.fil_year) AS case_number, c.filing_no");
            $db->from('civil_t as c');
            $db->join('case_type_t as t', 't.case_type=c.filcase_type');
            $db->where('c.reg_no is not null');
            // $db->order_by('t.case_type');
            $db->limit(100);
            return $db->get()->result();
        }

        public function getDetailsByFilingNumber($filing_number){
            $db = $this->load->database('chnccc', TRUE);
            $db->select('*');
            $db->from('civil_t');
            $db->where('filing_no', $filing_number);
            return $db->get()->row();
        }
    }
