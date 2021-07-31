<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User extends CI_Controller {

        public function __construct(){
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->model('User_Model');
            $this->load->helper('date');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache"); 
        }

        public function staffs_log(){

            if(isset($_POST['set']) && $_POST['set'] == 'staffs_log'){
                $emp_id        = $this->input->post('id');
                $password      = $this->input->post('pass');
                $returned_name = $this->User_Model->sign_in("users", $emp_id, $password);
                if(!empty($returned_name))
                {
                    foreach($returned_name as $return => $value)
                    {

                        $update_locator = array(
                            'field_reference' => 0,
                        );
                        $update_result = $this->User_Model->update_locator_in($this->input->post('id'), date('Y-M-d'), $update_locator);
                        $locator_data = array(
                            'user_id' => $value->employee_id,
                            'in_out' => $this->input->post('in_out'),
                            'event' => $this->input->post('events'),
                            'room_office' => $this->input->post('dest'),
                            'date' => date('Y-M-d'),
                            'field_reference' => 1,
                            'room_key' => '',
                            'time' => date('H:i:s')
                        );   
                        
                        $insert_result = $this->User_Model->insert('locator', $locator_data);
                        if($insert_result)
                        {
                            $user_data = array(
                                'name'      => '',
                                'key'       => '',
                                'msg'       => 'Staff locator set. ',
                                'login'    => true
                            );
                            echo json_encode($user_data);
                        }
                        else{
                            $user_data = array(
                                'name'      => '',
                                'key'       => '',
                                'msg'       => 'Cannot insert staff locator.',
                                'login'    => false
                            );
                            echo json_encode($user_data);
                        }
                    }
                }
                else{
                    $user_data = array(
                        'name'      => '',
                        'key'       => '',
                        'msg'       => 'Invalid username or password.',
                        'login'    => false
                    );
                    echo json_encode($user_data);
                }
            }
        }

        public function register()
        {
            if(isset($_POST['register']) && $_POST['register'] == 'register'){
                $name = $this->input->post('emp_name');
                $emp_id = $this->input->post('emp_id');
                $pass = $this->input->post('password');
                $dept = $this->input->post('dept');
                $data = array(
                    'employee_id'   => $emp_id,
                    'borrower_name' => $name,
                    'emp_password'  => $pass,
                    'college'       => $dept
                );
                $return_result = $this->User_Model->insert("users", $data);
                if($return_result){
                    $user_data = array(
                        'name'      => $name,
                        'key'       => '',
                        'msg'       => 'User '. $name .' has been successfully registered.',
                        'register'  => true
                    );
                    echo json_encode($user_data);
                }
                else{
                    $user_data = array(
                        'name'      => '',
                        'key'       => '',
                        'msg'       => 'Problem occured while registering the user.',
                        'register'  => false
                    );
                    echo json_encode($user_data);
                }
            }
            else{
                redirect('pages/registration/register');
            }
        }

        public function return(){
            if(isset($_POST['returned']) && $_POST['returned']  == 'keys'){
                $return_result_id = "";
                $time_borrowed = "";
                $time_duration = "";
                $time_overdue = "";
                $time = "";
                $keys      = $this->input->post('keys');
                $status    = "Unavailable";
                $college = '';
                $return_result_id = $this->User_Model->lookup_keys("key_status", $keys, $status);
                if(!empty($return_result_id))
                {
                    $emp_id        = $this->input->post('emp_id');
                    $password      = $this->input->post('password');
                    $returned_name = $this->User_Model->sign_in("users", $emp_id, $password);
                    if(!empty($returned_name))
                    {
                        $status = "borrowed";
                        foreach($returned_name as $return => $value)
                        {
                            $borrower = $value->borrower_name;
                            $college = $value->college;
                        }
                        
                        $return_result   = $this->User_Model->query_returned("room_keys_monitoring", $keys, $status, $borrower);
                        if($return_result)
                        {
                            foreach($return_result as $result)
                            {
                                $time_duration = $result->time_duration;
                                $time_borrowed = $result->Time_Borrowed;
                                $time_overdue = $result->time_overdue;
                            }
                            $time = date('H:i:s');
                            $time_due = date('H:i:s', strtotime($time_overdue));
                            if(date('H:i:s') > $time_due)
                            {
                                $data = array(
                                    'return_remarks'  => 'overdue',
                                    'overdue_time_return_attempt' => date('H:i:s')
                                );
                                
                                $overdue = $this->User_Model->update('borrowed', $keys, $data);
                                if($overdue)
                                {
                                    if(!empty($college))
                                    {
                                        $locator_data = array(
                                            'in_out' => $this->input->post('in_out'),
                                            'event' => $this->input->post('events'),
                                            'room_office' => $this->input->post('events'),
                                            'time' => date('H:i:s')
                                        );
                                        $update_result = $this->User_Model->update_locator($this->input->post('emp_id'), date('Y-M-d'), $locator_data, 
                                            $this->input->post('keys'));
                                        if($update_result)
                                        {
                                            $user_data = array(
                                                'name'      => '',
                                                'key'       => "",
                                                'msg'       => 'Overdue key! Please return the key to Sir James or Sir Alex. Thank You!',
                                                'return'    => false
                                            );
                                            echo json_encode($user_data);
                                        }
                                        else{
                                            $user_data = array(
                                                'name'      => '',
                                                'key'       => "",
                                                'msg'       => 'Error on setting the locator. Contact the developer to fixed it.',
                                                'return'    => false
                                            );
                                            echo json_encode($user_data);
                                        }
                                    }
                                    else{
                                        $user_data = array(
                                            'name'      => '',
                                            'key'       => "",
                                            'msg'       => 'Overdue key! Please return the key to Sir James or Sir Alex. Thank You!',
                                            'return'    => false
                                        );
                                        echo json_encode($user_data);
                                    }
                                }
                                else{
                                    $user_data = array(
                                        'name'      => '',
                                        'key'       => '',
                                        'msg'       => 'Problem occured while updating the key status.',
                                        'return'    => false
                                    );
                                    echo json_encode($user_data);
                                }
                            }
                            else{
                                $data = array(
                                    'Time_Returned'  => date('H:i:s'),
                                    'key_status'     => 'returned'
                                );
                                $return_result = $this->User_Model->update('borrowed', $keys, $data);
                                if($return_result)
                                {
                                    $return_update = $this->User_Model->cancel_borrow_approval($return_result_id);
                                    if($return_update)
                                    {
                                        if(!empty($college))
                                        {
                                            $locator_data = array(
                                                'in_out' => $this->input->post('in_out'),
                                                'event' => $this->input->post('events'),
                                                'room_office' => $this->input->post('events'),
                                                'time' => date('H:i:s')
                                            );
                                            $update_result = $this->User_Model->update_locator($this->input->post('emp_id'), date('Y-M-d'), $locator_data, 
                                                $this->input->post('keys'));
                                            if($update_result)
                                            {
                                                $user_data = array(
                                                    'name'      => '',
                                                    'key'       => $time_due,
                                                    'msg'       => 'Key log successfully updated. Thank you!',
                                                    'return'    => true
                                                );
                                                echo json_encode($user_data);
                                            }
                                            else{
                                                $user_data = array(
                                                    'name'      => '',
                                                    'key'       => "",
                                                    'msg'       => 'Error on setting the locator. Contact the developer to fixed it.',
                                                    'return'    => false
                                                );
                                                echo json_encode($user_data);
                                            }
                                        }
                                        else{
                                            $user_data = array(
                                                'name'      => '',
                                                'key'       => $time_due,
                                                'msg'       => 'Key log successfully updated. Thank you!',
                                                'return'    => true
                                            );
                                            echo json_encode($user_data);
                                        }
                                    }
                                    else{
                                        $user_data = array(
                                            'name'      => '',
                                            'key'       => '',
                                            'msg'       => 'Problem occured while updating the key log.',
                                            'return'    => false
                                        );
                                        echo json_encode($user_data);
                                    }
                                }
                                else{
                                    $user_data = array(
                                        'name'      => '',
                                        'key'       => '',
                                        'msg'       => 'Problem occured while returning the key.',
                                        'return'    => false
                                    );
                                    echo json_encode($user_data);
                                }
                            }
                        }
                        else{
                            $user_data = array(
                                'name'      => "",
                                'key'       => "",
                                'msg'       => 'You are returning a wrong key.',
                                'return'    => false
                            );
                            echo json_encode($user_data);
                        }           
                    }
                    else
                    {
                        $user_data = array(
                            'name'      => "",
                            'key'       => "",
                            'msg'       => 'Invalid username or password!',
                            'return'    => false
                        );
                        echo json_encode($user_data);
                    }   
                }
                else
                {
                    $user_data = array(
                        'name'      => "",
                        'key'       => "",
                        'msg'       => 'The key has been returned.',
                        'return'    => false
                    );
                    echo json_encode($user_data); 
                }
            }
            else
            {
                redirect('pages/return');
            }
        }

        public function borrow(){
            if(isset($_POST['borrow']) && $_POST['borrow']  == 'users'){ 
                $return_result_id = "";
                $borrower = ""; $time = '';
                $keys      = $this->input->post('keys');
                $status    = "Available";
                $college = '';
                $return_result_id = $this->User_Model->lookup_keys("key_status", $keys, $status);
                if(!empty($return_result_id))
                {
                    $emp_id        = $this->input->post('emp_id');
                    $password      = $this->input->post('password');
                    $returned_name = $this->User_Model->sign_in("users", $emp_id, $password);
                    if(!empty($returned_name))
                    {
                        foreach($returned_name as $result)
                        {
                            $borrower = $result->borrower_name;
                            $college = $result->college;
                            $data = array(
                                'Room_Key'       => $this->input->post('keys'),
                                'borrower'       => $result->borrower_name,
                                'Time_Borrowed'  => date('H:i:s'),
                                'time_duration'  => $this->input->post('duration'),
                                'key_status'     => 'borrowed',
                            );
                        }
                        $key_status = "borrowed";
                        $lookUp_keyUnreturned = $this->User_Model->query_Unreturned("room_keys_monitoring", $borrower, $key_status);
                        if(!empty($lookUp_keyUnreturned))
                        {
                            $user_data = array(
                                'name'      => $lookUp_keyUnreturned,
                                'key'       => '',
                                'msg'       => 'You still have unreturned key. Please return it before borrowing another one.',
                                'borrow'    => false
                            );
                            echo json_encode($user_data);
                        }
                        else{
                            $emp_id        = $this->input->post('emp_id');
                            $password      = $this->input->post('password');
                            $returned_borrower_info = $this->User_Model->sign_in("users", $emp_id, $password);
                            if(!empty($returned_borrower_info))
                            {
                                $hour = $this->input->post('duration');
                                $time = date('H:i:s', strtotime('+'.$hour.' hours'));
                                foreach($returned_borrower_info as $result)
                                {
                                    $data = array(
                                        'Room_Key'       => $this->input->post('keys'),
                                        'borrower'       => $result->borrower_name,
                                        'Time_Borrowed'  => date('H:i:s'),
                                        'time_duration'  => $this->input->post('duration'),
                                        'key_status'     => 'borrowed',
                                        'time_overdue'   => $time
                                    );
                                }
                                $returned_insert = $this->User_Model->insert("room_keys_monitoring", $data);
                                if($returned_insert)
                                {
                                    $return_result = $this->User_Model->update_borrow_approval($return_result_id);
                                    if($return_result)
                                    {
                                        if(!empty($college))
                                        {
                                            $update_locator = array(
                                                'field_reference' => 0,
                                                'in_out'  => 2,
                                                'time' => date('H:i:s')
                                            );
                                            $update_result = $this->User_Model->update_locator_in($this->input->post('emp_id'), 
                                                date('Y-M-d'), $update_locator);
                                            $locator_data = array(
                                                'user_id' => $this->input->post('emp_id'),
                                                'in_out'  => 1,
                                                'event'   => 'On-Class',
                                                'room_office' => $this->input->post('keys'),
                                                'time' => date('H:i:s').'-'.$time,
                                                'date'  => date('Y-M-d'),
                                                'field_reference' => 1,
                                                'room_key' => $this->input->post('keys')
                                            );
                                            $insert_result = $this->User_Model->insert('locator', $locator_data);
                                            if($insert_result)
                                            {
                                                $user_data = array(
                                                    'name'      => $return_result,
                                                    'key'       => '',
                                                    'msg'       => 'Please return the key on time',
                                                    'borrow'    => true
                                                );
                                                echo json_encode($user_data); 
                                            }
                                            else{
                                                $user_data = array(
                                                    'name'      => '',
                                                    'key'       => '',
                                                    'msg'       => 'Error while setting the locator. Contact the developer to fixed it.',
                                                    'borrow'    => false
                                                );
                                                echo json_encode($user_data); 
                                            }
                                        }
                                        else{
                                            $user_data = array(
                                                'name'      => $return_result,
                                                'key'       => '',
                                                'msg'       => 'Please return the key on time',
                                                'borrow'    => true
                                            );
                                            echo json_encode($user_data);
                                        }
                                    }
                                    else{
                                        $user_data = array(
                                            'name'      => '',
                                            'key'       => '',
                                            'msg'       => 'Error while updating keys status. Contact the developer to fixed it.',
                                            'borrow'    => false
                                        );
                                        echo json_encode($user_data); 
                                    }
                                }
                                else{
                                    $user_data = array(
                                        'name'      => '',
                                        'key'       => '',
                                        'msg'       => 'Error while borrowing the room key(s).',
                                        'borrow'    => false
                                    );
                                    echo json_encode($user_data); 
                                }
                            }
                            else{
                                $user_data = array(
                                    'name'      => '',
                                    'key'       => '',
                                    'msg'       => 'Cannot get borrower info. Contact the developer to fixed it.',
                                    'borrow'    => false
                                );
                                echo json_encode($user_data); 
                            }
                        }
                    }
                    else
                    {
                        $user_data = array(
                            'name'      => "",
                            'key'       => "",
                            'msg'       => 'Invalid username or password!',
                            'borrow'    => false
                        );
                        echo json_encode($user_data); 
                    }
                }
                else{
                    $keys   = $this->input->post('keys');
                    $status = 'borrowed';
                    $return_result   = $this->User_Model->query("room_keys_monitoring", $keys, $status);
                    if($return_result)
                    {
                        foreach($return_result as $result)
                        {
                            $user_data = array(
                                'name'      => $result->borrower,
                                'key'       => $result->Room_Key,
                                'msg'       => 'Key unavailable. The key was borrowed by '. $result->borrower .'. ',
                                'borrow'    => false
                            );
                        }
                        echo json_encode($user_data); 
                    }
                }
            }
            else{
                redirect('pages/login');
            }
        }

        public function getFaculty(){

            $sql = "SELECT * FROM locator WHERE date = date('Y-M-d') AND event = 'On-Travel'
             OR event = 'On-Leave' ";
            $result = $this->db->query($sql)->result(); 

            echo '<pre>';
            print_r($result);
        }

        public function update_event(){

            if(isset($_POST['update']) && $_POST['update'] == 'update'){

                if(!count($this->input->post('events')) == 0){
                    $query_return = $this->User_Model->query_update_event();
                    if($query_return){
                        $user_data = array(
                            'user_id'   => '',
                            'username'  => '',
                            'msg'       => 'Event already updated',
                            'save'      => false
                        );
                        echo json_encode($user_data);
                    }
                    else{
                        for ($i = 0; $i < count($this->input->post('events')); $i++) { 
                            $data = array(
                                'user_id'         => $this->input->post('user_id')[$i],
                                'event'           => $this->input->post('events')[$i],
                                'room_office'     => '',
                                'time'            => date('H:i:s'),
                                'date'            => date('Y-M-d'),
                                'field_reference' => 1,
                                'in_out'          => 2
                            );

                            $returnedLast_inserted_id = $this->User_Model->insert('locator', $data);
                            if($returnedLast_inserted_id){
                                $user_data = array(
                                    'user_id'   => '',
                                    'username'  => '',
                                    'msg'       => 'Locator setup successfull.',
                                    'save'      => true
                                );
                                echo json_encode($user_data);
                            }
                            else{
                                $user_data = array(
                                    'user_id'   => '',
                                    'username'  => '',
                                    'msg'       => 'Failed to update travel/leave event.',
                                    'save'      => false
                                );
                                echo json_encode($user_data);
                            }
                        }
                    }
                }
                else{
                    $user_data = array(
                        'user_id'   => '',
                        'username'  => '',
                        'msg'       => 'Cannot update travel/leave field.',
                        'save'      => false
                    );
                    echo json_encode($user_data);
                }
            }
            // else{
            //     redirect('pages/locator');
            // }
        }

        public function set_locator(){

            if(isset($_POST['set']) && $_POST['set'] == 'locator'){
                $faculty_name = $this->input->post('faculty');
                $return_result = $this->User_Model->getFaculty_info($faculty_name);
                if($return_result['result'] == TRUE){
                    foreach ($return_result['result_data'] as $key => $value) {
                        $id = $value->employee_id;
                        $data = array(
                            'user_id'         => $value->employee_id,
                            'event'           => $this->input->post('events'),
                            'room_office'     => $this->input->post('room'),
                            'time'            => date('H:i:s'),
                            'date'            => date('Y-M-d'),
                            'field_reference' => $this->input->post('ref'),
                            'in_out'          => $this->input->post('in_out')
                        );
                    }
                    $update_locator = array(
                        'field_reference' => 0,
                        'in_out'  => 2,
                        'time' => date('H:i:s')
                    );
                    $update_result = $this->User_Model->update_locator_in($id, date('Y-M-d'), $update_locator);
                    $returnedLast_inserted_id = $this->User_Model->insert('locator', $data);
                    if($returnedLast_inserted_id){
                        $user_data = array(
                            'user_id'   => '',
                            'username'  => '',
                            'msg'       => 'Locator setup successfull.',
                            'save'      => true,
                            'allowed'   => 'yes'
                        );
                        echo json_encode($user_data);
                    }
                    else{
                        $user_data = array(
                            'user_id'   => '',
                            'username'  => '',
                            'msg'       => 'Cannot set faculty and staffs locator.',
                            'save'      => false,
                            'allowed'   => 'no'
                        );
                        echo json_encode($user_data);
                    }
                }
                else{
                    $user_data = array(
						'user_id'   => '',
						'username'  => '',
                        'msg'       => 'Cannot find the faculty on the list.',
                        'save'      => false,
                        'allowed'   => 'not'
                    );
                    echo json_encode($user_data);
                }
                
            }
            else{
                redirect('pages/set_up');
            }
        }

        public function getBorrowOverdue(){
            if(isset($_POST['remarks']) && $_POST['remarks'] == 'overdue'){
                $id_num = $this->input->post('id_num');
                $remarks = $this->input->post('remarks');
                $status = $this->input->post('status');
                $return_result = $this->User_Model->get_borrower($remarks, $status);
                if($return_result){
                    foreach ($return_result as $key) {
                        $borrower_data = array(
                            'name'      => $key->borrower,
                            'data_set'           => true
                        );
                    }
                }
                else{
                    $borrower_data = array(
                        'data_set' => false,
                        'msg'      => 'Borrower not registered. Register now?'
                    );
                }
                echo json_encode($borrower_data);
            }
            else{
                redirect('pages/return_allow/allow');
            }
        }

        public function allowBorrower(){
            if(isset($_POST['status']) && $_POST['status'] == 'borrowed')
            {
                if($_POST['id'] == '164' || $_POST['id'] == '246')
                {
                    $emp_id        = $this->input->post('id');
                    $password      = $this->input->post('pass');
                    $returned_name = $this->User_Model->sign_in("users", $emp_id, $password);
                    if(!empty($returned_name))
                    {
                        $keys = $this->input->post('key');
                        $return_result_id = $this->User_Model->lookup_keys("key_status", $keys, 'Unavailable');
                        if(!empty($return_result_id))
                        {
                            $keys_update = $this->User_Model->cancel_borrow_approval($return_result_id);
                            if($keys_update)
                            {
                                $status = $this->input->post('status');
                                $key = $this->input->post('key');
                                $name = $this->input->post('emp_name');
                                $data = array(
                                    'return_remarks' => '',
                                    'key_status' => 'returned',
                                    'overdue_time_return_attempt' => '',
                                    'Time_Returned' => date('H:i:s')
                                );
                                $return_result = $this->User_Model->returnAllow($status, $key, $name, $data);
                                if($return_result)
                                {
                                    
                                    $user_data = array(
                                        'return' => true,
                                        'message' => 'Borrower '. $name .' were allowed to borrow again'
                                    );
                                    echo json_encode($user_data);
                                }
                                else{
                                    $user_data = array(
                                        'return' => false,
                                        'message' => 'Borrower '. $name .' cannot be allowed to borrow again. Please contact the developer.'
                                    );
                                    echo json_encode($user_data);
                                }
                            }
                            else{
                                $user_data = array(
                                    'return' => false,
                                    'message' => 'Error occured when updating key status.'
                                );
                                echo json_encode($user_data);
                            }
                        }
                        else{
                            $user_data = array(
                                'return' => false,
                                'message' => 'No such key exists as unavailable.'
                            );
                            echo json_encode($user_data);
                        }
                    }
                    else{
                        $user_data = array(
                            'return' => false,
                            'message' => 'Invalid username or password of the authorized personnel.'
                        );
                        echo json_encode($user_data);
                    }
                }
                else{
                    $user_data = array(
                        'return' => false,
                        'message' => 'You are not an authorized personnel to return the overdue key.'
                    );
                    echo json_encode($user_data);
                }
            }
            else
            {
                redirect('pages/return_allow/allow');
            }
        }

        // public function get__document_borrower(){
        //     if($_POST['get_data'] == 'get__document_borrower'){
        //         $transact_type = $this->input->post('transact_type');
        //         $action        = $this->input->post('action');
        //         $return_result = $this->User_Model->get__item_borrower($transact_type, $action);
        //         echo json_encode($return_result);
        //     }
        // }

        // public function borrow_items(){
        //     if($_POST['borrow'] == 'borrow_items'){
        //         $email              = $this->input->post('uid');
        //         $password           = $this->input->post('password');
        //         $encrypted_password = md5($password);
        //         $return_result_id = $this->User_Model->sign_in($email, $encrypted_password);
        //         if($return_result_id){
        //             $data = array(
        //                 'transact_type'       => $this->input->post('transact_choice'),
        //                 'ID_num'              => $this->input->post('id_num'),
        //                 'date_borrowed'       => $this->input->post('dateborrowed'),
        //                 'date_to_returned'    => $this->input->post('dateToreturn'),
        //                 'code'                => $this->input->post('code'),
        //                 'model_num'           => $this->input->post('model__num'),
        //                 'item_name'           => $this->input->post('doc_name'),
        //                 'description'         => $this->input->post('desc'),
        //                 'quantity'            => $this->input->post('quantity'),
        //                 'auth_by_uid'          => $this->input->post('uid'),
        //                 'auth_by_pass'        => $encrypted_password,
        //                 'action_taken'        => 'not_returned',
        //                 'set_onOff_history'   => 'On'
        //             );
        //             $returnedLast_inserted = $this->User_Model->insert('borrow', $data);
        //             if($returnedLast_inserted){
        //                 $row = $this->User_Model->query('borrow', $returnedLast_inserted);
        //                 foreach ($row as $key => $value) {
        //                     $new_data = array(
        //                         'id'             => $returnedLast_inserted,
        //                         'transact_type'  => $value->transact_type,
        //                         'borrower_id'    => $value->ID_num,
        //                         'set_field'      => 'pending'
        //                     );
        //                 }
                        
        //                 $this->User_Model->insert('approval', $new_data);
        //                 $user_data = array(
        //                     'msg'        => 'Data save successfully!',
        //                     'registered' => true
        //                 );
        //             }
        //             else{
        //                 $user_data = array(
        //                     'msg'       => 'Data cannot be inserted.',
        //                     'registered'=> false
        //                 );
        //             }
        //         }
        //         else{
        //             $user_data = array(
		// 				'user_id'   => 0,
		// 				'username'  => $email,
        //                 'msg'       => 'User authentication invalid!',
		// 				'registered' => false
		// 			);
        //         }

        //         echo json_encode($user_data);
        //     }
        //     else{
        //         redirect('pages/login');
        //     }
        // }

        // public function return_items(){
        //     if($_POST['returned'] == 'return_items'){
        //         $email              = $this->input->post('uid');
        //         $password           = $this->input->post('password');
        //         $encrypted_password = md5($password);
        //         $return_result_id = $this->User_Model->sign_in($email, $encrypted_password);
        //         if($return_result_id){
        //             $id_num = $this->input->post('id_num');
        //             $code   = $this->input->post('code');
        //             $data = array(
        //                 'date_returned'      => $this->input->post('dateReturn'),
        //                 'action_taken'       => 'returned',
        //                 'set_onOff_history'  => 'Off'
        //             );
        //             $returned_query = $this->User_Model->return_borrow($id_num, $code, $data);
        //             if($returned_query){
        //                 $id             = $this->input->post('id');
        //                 $transact_type  = $this->input->post('transact_type');
        //                 $data_cancel = array(
        //                     'set_field'      => 'returned'
        //                 );
        //                 $result = $this->User_Model->cancel_borrow_approval($id, $transact_type, $data_cancel);
        //                 if($result){
        //                     $user_data = array(
        //                         'transact'   => 'successful' ,
        //                         'msg'        => 'Item/Document cancelled!',
        //                         'returned'   => true
        //                     );
        //                 }
        //             }
        //             else{
        //                 $user_data = array(
        //                     'transact'   => 'failed' ,
        //                     'msg'        => 'Item/Document returned failed!',
        //                     'returned'   => false
        //                 );
        //             }
        //         }
        //         else{
        //             $user_data = array(
        //                 'transact' => $return_result_id ,
        //                 'msg'       => 'Not allowed.',
        //                 'registered' => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        // public function cancel_items(){
        //     if($_POST['cancelled'] == 'cancel'){
        //         $email              = $this->input->post('uid');
        //         $password           = $this->input->post('password');
        //         $encrypted_password = md5($password);
        //         $return_result_id = $this->User_Model->sign_in($email, $encrypted_password);
        //         if($return_result_id){
        //             $id_num = $this->input->post('id_num');
        //             $code   = $this->input->post('code');
        //             $data = array(
        //                 'date_returned'      => $this->input->post('dateReturn'),
        //                 'action_taken'       => 'cancelled',
        //                 'set_onOff_history'  => 'Off'
        //             );
        //             $returned_query = $this->User_Model->return_borrow($id_num, $code, $data);
        //             if($returned_query){
        //                 $id             = $this->input->post('id');
        //                 $transact_type  = $this->input->post('transact_type');
        //                 $data_cancel = array(
        //                     'set_field'      => 'cancelled'
        //                 );
        //                 $result = $this->User_Model->cancel_borrow_approval($id, $transact_type, $data_cancel);
        //                 if($result){
        //                     $user_data = array(
        //                         'transact'   => 'successful' ,
        //                         'msg'        => 'Item/Document cancelled!',
        //                         'returned'   => true
        //                     );
        //                 }
        //             }
        //             else{
        //                 $user_data = array(
        //                     'transact'   => 'failed' ,
        //                     'msg'        => 'Item/Document cancel failed!',
        //                     'returned'   => false
        //                 );
        //             }
        //         }
        //         else{
        //             $user_data = array(
        //                 'transact' => $return_result_id ,
        //                 'msg'       => 'Not allowed.',
        //                 'registered' => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        // public function borrow_approval(){
        //     if($_POST['approved'] == 'approved'){
        //         $id   = $this->input->post('id');
        //         $type = $this->input->post('type');
        //         $data = array(
        //             'approval_u_id'           => $this->input->post('uid'),
        //             'approval_u_position'     => $this->input->post('position'),
        //             'time_approval'           => (date("Y-m-d")." ".date("H:i:s")),
        //             'set_field'               => 'approved'
        //         );
        //         $return_result = $this->User_Model->update_borrow_approval($id, $type, $data);
        //         if($return_result){
        //             $user_data = array(
        //                 'msg'        => "Approval complete!",
        //                 'approved'   => true
        //             );
        //         }
        //         else{
        //             $user_data = array(
        //                 'msg'       => 'Not allowed.',
        //                 'approved'  => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        // public function denied_approval(){
        //     if($_POST['denied'] == 'denied'){
        //         $id   = $this->input->post('id');
        //         $type = $this->input->post('type');
        //         $data = array(
        //             'approval_u_id'           => $this->input->post('uid'),
        //             'approval_u_position'     => $this->input->post('position'),
        //             'time_approval'           => (date("Y-m-d")." ".date("H:i:s")),
        //             'set_field'               => 'denied'
        //         );
        //         $return_result = $this->User_Model->update_borrow_approval($id, $type, $data);
        //         if($return_result){
        //             $user_data = array(
        //                 'msg'        => "Borrow denied !",
        //                 'approved'   => true
        //             );
        //         }
        //         else{
        //             $user_data = array(
        //                 'msg'       => 'Not allowed.',
        //                 'approved'  => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        // public function query_by_month(){
        //     if($_POST["query"] == "monthly"){
        //         $month   = $this->input->post('month');
        //         $return_result = $this->User_Model->by_month($month);
        //         if($return_result){
                    
        //             $user_data = array(
        //                 'data'     => $return_result,
        //                 'query'   => true
        //             );
        //         }
        //         else{
        //             $user_data = array(
        //                 'msg'    => $return_result,
        //                 'query'  => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        // public function monthly(){
        //     if($_POST["by_month"] == "monthly"){
        //         $month   = $this->input->post('month');
        //         $return_result = $this->User_Model->by_month($month);
        //         if($return_result){
                    
        //             $user_data = array(
        //                 'data'     => $return_result,
        //                 'query'   => true
        //             );
        //         }
        //         else{
        //             $user_data = array(
        //                 'msg'    => $return_result,
        //                 'query'  => false
        //             );
        //         }
        //         echo json_encode($user_data);
        //     }
        // }

        public function logout(){
            $this->session->sess_destroy();
            redirect('pages/login/');
        }

    }