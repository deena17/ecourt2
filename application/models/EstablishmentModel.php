<?php

    class EstablishmentModel extends CI_Model{

        public function getEstablishments(){
            return $this->db->get('establishment')->result();
        }

        public function setEstablishment($est){
            return $this->db->where('est_dbname', $est)
                ->get('establishment')->result();
        }
        
    }