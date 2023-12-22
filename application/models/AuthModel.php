<?php
    class AuthModel extends CI_Model{

        public function login($data){
            // $establishemnt = $this->db->where('est_dbname', $data['establishment'])->get('establishment')->row();
            $this->db->where('username', $data['username']);
            $this->db->where('user_password', md5($data['password']));
            $this->db->from('users as u');
            // $this->db->join('id_role_est as r', 'u.userid=r.user_id');
            // $this->db->where('r.establishmentid', $establishemnt->est_code);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->row();
            }
            return false;
        }

        public function verifyRole($userid, $est ){
            $establishemnt = $this->db->where('est_dbname', $est)->get('establishment')->row();
            $this->db->where('user_id', $userid);
            $this->db->where('establishmentid', $establishemnt->est_code);
            // $this->db->where('court_id is not null');
            $this->db->from('id_role_est');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return true;
            }
            return false;
        }


        public function userInformation($username, $est){
            $establishemnt = $this->db->where('est_dbname', $est)->get('establishment')->row();
            $this->db->select('username, full_name, userid');
            $this->db->from('users');
            $this->db->where('username', $username);
            $user = $this->db->get()->row();

            $this->db->where('user_id', $user->userid);
            $this->db->where('establishmentid', $establishemnt->est_code);
            // $this->db->where('court_id is not null');
            $this->db->from('id_role_est');
            $role = $this->db->get()->row();

            $this->db->select('case_type_id');
            $this->db->where('user_id', $user->userid);
            $this->db->from('user_case_type_t');
            $case_type = $this->db->get()->result();

            $user_case_type = [];
            foreach($case_type as $t):
                array_push($user_case_type, $t->case_type_id);
            endforeach;

            // $court_no = null;
            // foreach($role as $r):
            //     if($r->court_no !== null)
            //     $court_no = $r->court_no;
            // endforeach;
            
            return array(
                'user' => $user,
                'role' => $role,
                'case_type' => $user_case_type,
                // 'court_no' => $this->db->where(array('user_id' =>$user->userid, 'establishmentid'=> $establishemnt->est_code, 'court_id'=> 'is not null'))->get('id_role_est')->row();
            );

        }

        // public function userInformation($username){
        //     // $establishemnt = $this->db->where('est_dbname', $est)->get('establishment')->row();
        //     $this->db->select('u.username, u.full_name, u.uid, u.userid,u.display,r.court_id');
        //     $this->db->from('users as u');
        //     $this->db->join('id_role_est as r', 'u.userid=r.user_id');
        //     $this->db->where('u.username', $username);
        //     $this->db->where('r.court_id is NOT NULL', NULL, FALSE);
        //     // $this->db->where('r.establishmentid', $establishemnt->est_code);
        //     $query = $this->db->get();
        //     return $query->row();

            

        // }


        public function getCaseType(){
            $est_dbname = $this->session->userdata('est_dbname');
            $db = $this->load->database($est_dbname, TRUE);
            return $db->where('display', 'Y')->order_by('type_name', 'ASC')->get('case_type_t')->result();
        }

        public function getUsers(){
            return $this->db->get('users')->result();
        }

        public function saveUserCaseType($data){
            try{
                foreach ($data['case_type'] as $key => $value) :
                    $insert_data = [
                        'case_type_id' => $value,
                        'user_id' => $data['user_id']
                    ];
                    $this->db->insert('user_case_type_t', $insert_data);
                endforeach;
                return TRUE;
            }
            catch(Exception $e){
                return FALSE;
            }
        }
    }