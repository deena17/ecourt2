<?php   

    class Permission{
        var $ci;

        public function __construct(){
            $this->ci =& get_instance();
        }

        public function has($perm){
            $this->ci->db->select('*')->from('id_role_est as e');
            $this->ci->db->where('user_id', $this->ci->session->userdata['userid']);
            $this->ci->db->join('role_master r', 'r.role_type_id=CAST(e.role_type_id AS integer)');
            $this->ci->db->where_in('r.role_type', $perm);
            $permission = $this->ci->db->get()->result();
            if($permission){
                return true;
            }else{
                return false;
            }         
        }
    }