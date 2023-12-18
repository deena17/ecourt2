<?php 

    class ObjectionModel extends CI_Model{

        public $est_dbname = null;

        public function __construct(){
            parent::__construct();
            $this->est_dbname = $this->session->userdata('est_dbname');
        }

        public function getObjectionList(){
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->select("*");
            $db->from('objection_t as c');
            return $db->get()->result();
        }

        public function update_objection($data){
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->set('under_obj', $data['objection']);
            $db->set('create_modify', date("Y-m-d H:i:s"));
            $db->where('filing_no', $data['filing_number']);
            $result1 = $db->update('civil_t');

            if($result1){
                // $db->set('obj_redate', $data['receipt_date']);
                $db->set('obj_flag', $data['objection']);
                $db->set('objreceipt_dt', $data['receipt_date']);
                $db->set('objreturn_dt', $data['scrutiny_date']);
                $db->set('objprepare_dt', $data['compliance_date']);
                $db->set('objection', $data['objection_remarks']);
                $db->set('create_modify', date("Y-m-d H:i:s"));
                $db->where('filing_no', $data['filing_number']);
                $result2 = $db->update('ecivil_t');
                if($result2){
                    return TRUE;
                }
                return FALSE;
            }
            return FALSE;
        }
    }
