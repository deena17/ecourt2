<?php 

    class IndexRegisterModel extends CI_Model{

        public function getEIndexRegisters(){
            $db = $this->load->database('chnccc', TRUE);
            $db->select('*');
            $db->from('eindex_register');
            $db->where('cino', 'TNCH010414782023');
            return $db->get()->result();
        }
    }
