<?php 

    class IndexRegisterModel extends CI_Model{

        public $est_dbname = null;
        
        public function __construct(){
            parent::__construct();
            $this->est_dbname = $this->session->userdata('est_dbname');
        }

        public function cause_list(){
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->select("CONCAT(t.type_name,'/',c.reg_no,'/',c.reg_year) AS case_number, c.case_no, date_of_decision, c.cino, purpose_priority, c.pet_name, c.res_name, c.pet_adv, c.res_adv, purpose_name, p.purpose_code");
            $db->from('daily_proc as d');
            $db->join('civil_t as c', 'd.cino=c.cino');
            $db->join('purpose_t as p', 'p.purpose_code=d.purpose_code');
            $db->join('case_type_t as t', 't.case_type=c.regcase_type');
            $db->where(array('next_date' => '2023-12-11', 'd.court_no'=> 1));
            $db->order_by('p.purpose_code');
            $result = $db->get()->result();
            if($result){
                return $result;
            }
            else{
                return false;
            }

        }

        public function getEIndexRegisters($filing_number){
            $db = $this->load->database($this->est_dbname, TRUE);
            // $data = $db->select('cino')->where('filing_no', $filing_number)->get('civil_t')->row();
            $db->select('*');
            $db->from('eindex_register');
            $db->where('cino', $filing_number);
            $db->order_by('srno', 'ASC');
            return $db->get()->result();
        }

        public function getIndexRegisters($data){
            $db = $this->load->database($this->est_dbname, TRUE);
            $index = array();
            $db->select('cino');
            $db->from('civil_t');
            $db->where('regcase_type', $data['case_type']); 
            $db->where('reg_no',  $data['case_no']);
            $db->where('reg_year' ,  $data['case_year']);
            if(!empty($data['court_no']))
                $db->where('court_no' ,  $data['court_no']);
            $index = $db->get()->row();
            if(empty($index)){
                $db->select('cino');
                $db->from('civil_t_a');
                $db->where('regcase_type', $data['case_type']); 
                $db->where('reg_no',  $data['case_no']);
                $db->where('reg_year' ,  $data['case_year']);
                if(!empty($data['court_no']))
                    $db->where('court_no' ,  $data['court_no']);
                $index = $db->get()->row();
            }
            if(!empty($index)){
                $db->select('i.cino, i.srno, d.docu_name, i.paperdate');
                $db->from('index_register as i');
                $db->join('docu_type_t as d', "d.docu_type=CAST(i.description AS integer)");
                $db->where('cino', $index->cino);
                $db->order_by('i.paperdate', 'DESC');
                $db->order_by('i.srno', 'ASC');
                return $db->get()->result();
            }else{
                return FALSE;
            }           
        }

        public function getIndexRegisterBycino($cino){
            $db = $this->load->database($this->est_dbname, TRUE);
            $index = array();
            $query1 = $db->select('cino')->from('civil_t')->where('cino', $cino);
                $index = $db->get()->row();
            if(empty($index)){
                $query2 = $db->select('cino')->from('civil_t_a')->where('cino', $cino);
                $index = $db->get()->row();
            }
            if(!empty($index)){
                $db->select('i.cino, i.srno, d.docu_name, i.paperdate, i.pleading_no, i.remarks, i.description');
                $db->from('index_register as i');
                $db->join('docu_type_t as d', "d.docu_type=CAST(i.description AS integer)");
                $db->where('cino', $index->cino);
                $db->order_by('i.paperdate', 'DESC');
                $db->order_by('i.srno', 'ASC');
                return $db->get()->result();
            }else{
                return FALSE;
            }           
        }

        public function get_eindex_document($cino, $srno){
            $document_root = "/var/www/html";
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->where('cino', $cino);
            $db->where('srno', $srno);
            $db->from('eindex_register');
            $index = $db->get()->row();

            $year = substr($cino,12);

            $file = "/$this->est_dbname/documents/$year/$cino".'_'."$srno.pdf";

            $file_path = file_exists("$document_root/$file") ? $file : null;

            return array(
                'title' => strtoupper($index->remarks),
                'file_path' => $file_path
            );
        }

        public function get_index_document($cino, $srno){
            $document_root = "/var/www/html";
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->select('d.docu_name, i.cino');
            $db->from('index_register as i');
            $db->join('docu_type_t as d', "d.docu_type=CAST(i.description AS integer)");
            $db->where('cino', $cino);
            $db->where('srno', $srno);

            $index = $db->get()->row();

            $year = substr($cino,12);

            $file = "/$this->est_dbname/documents/$year/$cino".'_'."$srno.pdf";

            $file_path = file_exists("$document_root/$file") ? $file : null;

            return array(
                'title' => strtoupper($index->docu_name),
                'file_path' => $file_path
            );
        }

        public function update_objection($data){
            $db = $this->load->database($this->est_dbname, TRUE);
            $civilt = $db->where('cino', $data['cino'])->get('civil_t')->row(); 
            $db->set('filing_no', $civilt->filing_no);
            $db->set('econfirm', $data['objection']);
            $db->set('reason_for_rej', $data['remarks']);
            $db->set('objection', $data['objection']);
            $db->set('create_modify', date("Y-m-d H:i:s"));
            $db->where(array('cino' => $data['cino'], 'srno' => $data['srno']));
            $result = $db->update('eindex_register');

            if($result):
                $db->select('*');
                $db->from('eindex_register');
                $db->where(array('cino'=> $data['cino'], 'srno'=>$data['srno']));
                $eindex = $db->get()->row(); 
                if($data['objection'] == 'Y'):
                    $result2 = $this->update_eindex_register($eindex);
                    if($result2):
                        return true;
                    else:
                        return false;
                    endif;
                endif;
                if($data['objection'] == 'N'):
                    $result3 = $this->update_index_register($eindex);
                    if($result3):
                        return true;
                    else:
                        return false;
                    endif;
                endif;
            else:
                return false;
            endif;
        }

        private function update_eindex_register($eindex){
            $db = $this->load->database($this->est_dbname, TRUE);
            $data = array(
                'caseno'            => $eindex->caseno,
                'srno'              => $eindex->srno,
                'description'       => $eindex->description,
                'paperdate'         => $eindex->paperdate,
                'noofparts'         => $eindex->noofparts,
                'alphabetical'      => $eindex->alphabetical,
                'remarks'           => $eindex->remarks,
                'lalphabetical'     => $eindex->lalphabetical,
                'lremarks'          => $eindex->lremarks,
                'display'           => $eindex->display,
                'upload_date'       => $eindex->upload_date,
                'cino'              => $eindex->cino,
                'doc_year'          => $eindex->doc_year,
                'doc_no'            => $eindex->doc_no,
                'filing_no'         => $eindex->filing_no,
                'amount'            => $eindex->amount,
                'name'              => $eindex->name,
                'type'              => $eindex->type,
                'party_no'          => $eindex->party_no,
                'adv_name'          => $eindex->adv_name,
                'adv_cd'            => $eindex->adv_cd,
                'extra_party'       => $eindex->extra_party,
                'objection'         => $eindex->objection,
                'oldnumber'         => $eindex->oldnumber,
                'remarks1'          => $eindex->remarks1,
                'advname1'          => $eindex->advname1,
                'advcd1'            => $eindex->advcd1,
                'efil_dt'           => $eindex->efil_dt,
                'econfirm'          => 'R',
                'efilno'            => $eindex->efilno,
                'create_on'         => $eindex->create_on,
                'amd'               => $eindex->amd,
                'create_modify'     => date("Y-m-d H:i:s"),
                'reason_for_rej'    => $eindex->reason_for_rej,
                'lreason_for_rej'   => $eindex->lreason_for_rej,
                'in_person'         => $eindex->in_person,
                'pleading_no'       => $eindex->pleading_no,
                'case_ia'           => $eindex->case_ia,
                'new_cino'          => $eindex->new_cino,
                'ia_no'             => $eindex->ia_no,
                'consumed_on'       => $eindex->consumed_on,
                'verified_on'       => $eindex->verified_on,
            );
            $result = $db->insert('eindex_register_rejected', $data);
            if($result){
                return true;
            }
            return false;
        }


        private function update_index_register($eindex){
            $db = $this->load->database($this->est_dbname, TRUE);
            $already_exists = $db->where(array('cino'=>$eindex->cino, 'srno'=>$eindex->srno))->get('index_register')->row();
            if($already_exists){
                return true;
            }
            $data = array(
                'caseno'            => $eindex->caseno,
                'srno'              => $eindex->srno,
                'description'       => $eindex->description,
                'paperdate'         => $eindex->paperdate,
                'noofparts'         => $eindex->noofparts,
                'alphabetical'      => $eindex->alphabetical,
                'remarks'           => $eindex->remarks,
                'lalphabetical'     => $eindex->lalphabetical,
                'lremarks'          => $eindex->lremarks,
                'display'           => $eindex->display,
                'upload_date'       => $eindex->upload_date,
                'cino'              => $eindex->cino,
                'doc_year'          => $eindex->doc_year,
                'doc_no'            => $eindex->doc_no,
                'filing_no'         => $eindex->filing_no,
                'amount'            => $eindex->amount,
                'name'              => $eindex->name,
                'type'              => $eindex->type,
                'party_no'          => $eindex->party_no,
                'adv_name'          => $eindex->adv_name,
                'adv_cd'            => $eindex->adv_cd,
                'extra_party'       => $eindex->extra_party,
                'objection'         => $eindex->objection,
                'oldnumber'         => $eindex->oldnumber,
                'remarks1'          => $eindex->remarks1,
                'advname1'          => $eindex->advname1,
                'advcd1'            => $eindex->advcd1,
                'amd'               => $eindex->amd,
                'create_modify'     => date("Y-m-d H:i:s"),
                'pleading_no'       => $eindex->pleading_no,
                'case_ia'           => $eindex->case_ia,
                'new_cino'          => $eindex->new_cino,
                'ia_no'             => $eindex->ia_no,
            );
            $result = $db->insert('index_register', $data);
            if($result):
                return true;
            else:
                return false;
            endif;
        }

        public function delete_index_register($cino, $srno){
            $db = $this->load->database($this->est_dbname, TRUE);
            $db->where_in('cino', $cino);
            $db->where_in('srno', $srno);
            $result = $db->delete('index_register');
            if($result):
                return true;
            else:
                return false;
            endif;
        }
    }
