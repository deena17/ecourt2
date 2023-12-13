<?php   

    class Connection{
        var $ci;

        public function __construct(){
            $this->ci =& get_instance();
        }

        

        public function conn($db_name){
            $dsn = $this->dataSource($db_name);
            $conn = array(
                'dsn'	=> "pgsql:host=$dsn->ip_details;port=5432;dbname=$dsn->est_dbname",
		        //'dsn'	=> "pgsql:host=10.241.10.9;port=5432;dbname=$dsn->est_dbname",
                'hostname' => $dsn->ip_details, 
                'username' => $dsn->username,
                'password' => $dsn->user_password,
                'database' => $db_name,
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => TRUE,
                'port' => 5432,
                'dbdriver' => 'pdo',
            );
            return $conn;
        }

        private function dataSource($db_name){
            return $this->ci->db->where('est_dbname',$db_name)->get('establishment')->row();
        }
    }