<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User_Model extends CI_Model {

        public function insert($table, $data){
            $result = $this->db->insert($table, $data);
            return $this->db->insert_id();
        }

        public function getFaculty(){

            $sql = "SELECT * FROM users WHERE college = 'CCSIT' OR college = 'Other' ORDER BY college, borrower_name ASC";
            $result = $this->db->query($sql)->result();

            foreach ($result as $key => $value) {
                $this->db->where('user_id', $value->employee_id);
                $this->db->where('date', date('Y-M-d'));
                $this->db->where('field_reference', 1);
                $user = $value->name = $this->db->get('locator')->result();
            }

            if(!empty($result)){
                return ['result' => TRUE, 'result_data' => $result];
            }
            else{
                return ['result' => FALSE, 'result_data' => ''];
            }
        }

        public function query_update_event(){
            $sql = "SELECT * FROM locator WHERE date = date('Y-M-d') AND event = 'On-Travel' OR event = 'On-Leave' ";
            $result = $this->db->query($sql); 
            if($result->num_rows() > 0){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function look_for_update_travel_leave($table, $user_id, $date){
            $sql = "SELECT * FROM '".$table."'' WHERE user_id = '".$user_id."' AND date = '".$date."' AND event = 'On-Travel' OR event = 'On-Leave' ";
            $query = $this->db->query($sql)->result();

            // $this->db->where('user_id', $user_id);
            // $this->db->where('date', $date);
            // $this->db->where('event', 'On-Travel')->or_where('event', 'On-Leave');
            // $query = $this->db->query($table)->result();
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function getFaculty_list(){

            $this->db->where('college', 'CCSIT');
            $this->db->order_by('borrower_name');
            $query = $this->db->get('users')->result();

            foreach ($query as $key => $value) {
                $this->db->where('user_id', $value->employee_id);
                $this->db->where('date', date('Y-M-d'));
                $this->db->where('field_reference', 1);
                $user = $value->name = $this->db->get('locator')->result();
            }
            if(!empty($query)){
                return $query;
            }
            else{
                return false;
            }
        }

        public function getFaculty_info($name){
            $this->db->where('college', 'CCSIT');
            $this->db->like('borrower_name', $name);
            $result = $this->db->get('users')->result();
            if(!empty($result)){
                return ['result' => TRUE, 'result_data' => $result];
            }
            else{
                return ['result' => FALSE, 'result_data' => ''];
            }
        }

        public function getFacultyInformationUpdate($id){
            $this->db->where('college', 'CCSIT');
            $this->db->like('employee_id', $id);
            $result = $this->db->get('users')->result();
            if(!empty($result)){
                return ['result' => TRUE, 'result_data' => $result];
            }
            else{
                return ['result' => FALSE, 'result_data' => ''];
            }
        }

        public function query_insert($emp_id, $name, $pass){
            $sql = "INSERT INTO `users` (``, `employee_id`, `borrower_name`, `emp_password`) VALUES ('', ".$emp_id.", ".$name.", ".$pass.") ";
            $query = $this->db->query($sql); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        // public function insert_authorize($data){
        //     $this->db->insert('users', $data);
        //     return $this->db->insert_id();
        // }

        // public function user_auth($user_id){
        //     $this->db->where('uid', $user_id);
        //     $result = $this->db->get('users');
        //     if($result->num_rows() == 1){
        //         return $result->row(0)->id;
        //     }
        //     else{
        //         return false;
        //     }
        // }

        public function getUser($table, $status){
            $this->db->where('key_status', $status);
            $result = $this->db->get($table);
            if($result->num_rows() > 0){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function getOverDue($table, $remarks){
            $this->db->where('return_remarks', $remarks);
            $result = $this->db->get($table);
            if($result->num_rows() > 0){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function lookup_keys($table, $key, $status){
            $this->db->where('room_keys', $key);
            $this->db->where('status', $status);
            $result = $this->db->get($table);
            if($result->num_rows() > 0){
                return $result->row(0)->id;
            }
            else{
                return false;
            }
        }

        public function query_Unreturned($table, $borrower, $key_status){
            $this->db->where('borrower', $borrower);
            $this->db->where('key_status', $key_status);

            $query = $this->db->get($table);
            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return false;
            }
        }

        public function sign_in($table, $emp_id, $pass){
            $this->db->where('employee_id', $emp_id);
            $this->db->where('emp_password', $pass);

            $query = $this->db->get($table);
            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return false;
            }
        }

        public function get_borrower($remarks, $status){
            $this->db->where('return_remarks', $remarks);
            $this->db->where('key_status', $status);
            $query = $this->db->get('room_keys_monitoring');
            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return false;
            }
        }

        public function returnAllow($status, $key, $name, $data){
            $this->db->where('key_status', $status);
            $this->db->where('Room_Key', $key);
            $this->db->where('borrower', $name);
            $this->db->set($data);
            $query = $this->db->update("room_keys_monitoring"); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        // public function get__borrowed_items($transact_type, $action, $set_field){
        //     $this->db->select('*');
        //     $this->db->from('register_borrower');
        //     $this->db->join('borrow', 'borrow.ID_num = register_borrower.ID_num');
        //     $this->db->join('approval', 'approval.id = borrow.id');
        //     $this->db->where('borrow.transact_type', $transact_type);
        //     $this->db->where('borrow.action_taken', $action);
        //     $this->db->where('borrow.set_onOff_history', 'On');
        //     $this->db->where('approval.set_field', $set_field);
        //     $this->db->where('MONTH(borrow.date_borrowed)', date('m'));
        //     $this->db->where('YEAR(borrow.date_borrowed)', date('Y'));
        //     $query = $this->db->get();
        //     if(!empty($query)){
        //         return $query->result();
        //     }
        //     else{
        //         return false;
        //     }
        // }

        // public function get__details($id){
        //     $this->db->where('ID_num', $id);
        //     $query = $this->db->get('register_borrower');
        //     if($query->num_rows() > 0){
        //         return $query->result();
        //     }
        //     else{
        //         return false;
        //     }
        // }

        // public function query_authorize($user_id, $pass){
        //     $this->db->where('uid', $user_id);
        //     $this->db->where('email_pass', $pass);

        //     $result = $this->db->get('users');
        //     if($result->num_rows() == 1){
        //         return $result->row(0)->id;
        //     }
        //     else{
        //         return false;
        //     }
        // }

        // public function insert_borrowed_items($table, $data){
        //     $this->db->insert($table, $data);
        //     return $this->db->row();
            
        // }

        // public function insert_borrowed_forApproval($table, $data){
        //     $this->db->insert($table, $data);
        //     return $this->db->insert_id();
        // }
        public function query_return($table ,$key, $status){
            $this->db->where('Room_Key', $key);
            $this->db->where('key_status', $status);
            $result = $this->db->get($table);
            if($result->num_rows() == 1){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function query($table ,$key, $status){
            $this->db->where('Room_Key', $key);
            $this->db->where('key_status', $status);
            $result = $this->db->get($table);
            if($result->num_rows() == 1){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function query_returned($table ,$key, $status, $borrower){
            $this->db->where('Room_Key', $key);
            $this->db->where('key_status', $status);
            $this->db->where('borrower', $borrower);
            $result = $this->db->get($table);
            if($result->num_rows() == 1){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function update($status, $key, $data){
            $this->db->where('key_status', $status);
            $this->db->where('Room_Key', $key);
            $this->db->set($data);
            $query = $this->db->update("room_keys_monitoring"); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function update_locator($id, $date, $data, $key){
            $this->db->where('user_id', $id);
            $this->db->like('date', $date);
            $this->db->where('room_key', $key);
            $this->db->set($data);
            $query = $this->db->update("locator"); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function update_locator_in($id, $date, $data){
            $this->db->where('user_id', $id);
            $this->db->like('date', $date);
            $this->db->where('field_reference', 1);
            $this->db->set($data);
            $query = $this->db->update("locator"); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function update_borrow_approval($id){
            $sql = "UPDATE `key_status` SET `status`= 'Unavailable' WHERE `id` = ".$id." ";
            $query = $this->db->query($sql); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function cancel_borrow_approval($id){
            $sql = "UPDATE `key_status` SET `status`= 'Available' WHERE `id` = ".$id." ";
            $query = $this->db->query($sql); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        public function getKeys($table, $status)
        {
            $this->db->where('status', $status);
            $result = $this->db->get($table);
            if($result->num_rows() > 0){
                return $result->result();
            }
            else{
                return false;
            }
        }

        public function updateAllowKeysOverdue($key){
            $sql = "UPDATE `key_status` SET `status`= 'Available' WHERE `room_keys` = ".$key." ";
            $query = $this->db->query($sql); 
            if($query){
                return true;
            }
            else{
                return false;
            }
        }

        // public function by_month($month){
        //     $this->db->select('*');
        //     $this->db->from('register_borrower');
        //     $this->db->join('borrow', 'borrow.ID_num = register_borrower.ID_num');
        //     $this->db->join('approval', 'approval.id = borrow.id');
        //     $this->db->where('approval.set_field', 'pending');
        //     $this->db->where('MONTH(borrow.date_borrowed)', $month);
        //     $this->db->where('YEAR(borrow.date_borrowed)', date('Y'));
        //     $query = $this->db->get();
        //     if(!empty($query)){
        //         return $query->result();
        //     }
        //     else{
        //         return false;
        //     }
        // }

        // public function get__borrower_details($id, $action_taken, $set_field){
        //     $this->db->select('*');
        //     $this->db->from('register_borrower');
        //     $this->db->join('borrow', 'borrow.ID_num = register_borrower.ID_num');
        //     $this->db->join('approval', 'approval.id = borrow.id');
        //     $this->db->where('approval.set_field', $set_field);
        //     $query_result = $this->db->get();
        //     return $query_result->result();
        // }

        // public function get__borrower_allDetails($transact_type){
        //     $this->db->select('*');
        //     $this->db->from('register_borrower');
        //     $this->db->join('borrow', 'borrow.ID_num = register_borrower.ID_num');
        //     $this->db->join('approval', 'approval.id = borrow.id');
        //     $this->db->where('borrow.transact_type', $transact_type);
        //     $this->db->order_by('approval.set_field, register_borrower.name, borrow.date_borrowed asc'); 
        //     $query = $this->db->get();
        //     if(!empty($query)){
        //         return $query->result();
        //     }
        //     else{
        //         return false;
        //     }
        // }

        // public function get__reports(){
        //     $this->db->select('*');
        //     $this->db->from('register_borrower');
        //     $this->db->join('borrow', 'borrow.ID_num = register_borrower.ID_num');
        //     $this->db->join('approval', 'approval.id = borrow.id');
        //     // $this->db->where('borrow.date_returned', 'null');
        //     // $this->db->order_by('approval.set_field, register_borrower.name, borrow.date_borrowed asc'); 
        //     $query = $this->db->get();
        //     if(!empty($query)){
        //         return $query->result();
        //     }
        //     else{
        //         return false;
        //     }
        // }

    }