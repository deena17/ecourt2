<?php
    class AuthModel extends CI_Model{

        public function login($data){
            $establishemnt = $this->db->where('est_dbname', $data['establishment'])->get('establishment')->row();
            $this->db->where('username', $data['username']);
            $this->db->where('user_password', md5($data['password']));
            $this->db->from('users as u');
            $this->db->join('id_role_est as r', 'u.userid=r.user_id');
            $this->db->where('r.establishmentid', $establishemnt->est_code);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return true;
            }
            return false;
        }

        public function userInformation($username){
            // $establishemnt = $this->db->where('est_dbname', $est)->get('establishment')->row();
            $this->db->select('u.username, u.full_name, u.uid, u.userid,u.display,r.court_id');
            $this->db->from('users as u');
            $this->db->join('id_role_est as r', 'u.userid=r.user_id');
            $this->db->where('u.username', $username);
            $this->db->where('r.court_id is NOT NULL', NULL, FALSE);
            // $this->db->where('r.establishmentid', $establishemnt->est_code);
            $query = $this->db->get();
            return $query->row();

        }
    }