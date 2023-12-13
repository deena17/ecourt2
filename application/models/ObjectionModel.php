<?php 

    class ObjectionModel extends CI_Model{

        public function getObjectionList(){
            $db = $this->load->database('chnccc', TRUE);
            $db->select("*");
            $db->from('objection_t as c');
            return $db->get()->result();
        }
    }
