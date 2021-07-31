<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('User_Model');
	}

	public function index($page="login")
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		$data['keys'] = $this->User_Model->getKeys("key_status", "Available");
		$this->load->view('template/header', $data);
        $this->load->view('pages/'.$page);
	}

	public function return($page = 'return')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		$data['keys'] = $this->User_Model->getKeys("key_status", "Unavailable");
		$this->load->view('template/header', $data);
        $this->load->view('pages/'.$page);

	}

	public function registration($page)
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		$this->load->view('template/head');
        $this->load->view('pages/'.$page);

	}

	public function attendance($page)
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		$data["employees"] = $this->User_Model->getUser("room_keys_monitoring", "borrowed");
		$this->load->view('template/header');
        $this->load->view('pages/'.$page, $data);

	}

	public function locator($page = 'locator')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		
		$faculty['name'] = $this->User_Model->getFaculty();
        $this->load->view('pages/'.$page, $faculty);

	}

	public function staffs_log($page = 'staff')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		// $name["name"] = $borrower.tostr();
		// $data["employees"] = $this->User_Model->getUser("users");
		// $this->load->view('template/locator-head');
        $this->load->view('pages/'.$page);

	}

	public function class_attendance($page, $borrower)
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		// $name["name"] = $borrower.tostr();
		// $data["employees"] = $this->User_Model->getUser("users");
		// $this->load->view('template/header');
        $this->load->view('pages/'.$page);

	}

	public function return_allow($page)
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		$data['return_allow'] = $this->User_Model->getOverDue("room_keys_monitoring", "overdue");
		$this->load->view('template/header-allow');
		$this->load->view('pages/'.$page, $data);
	}

	public function set_up($page = 'locator-setup')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		$data['faculty'] = $this->User_Model->getFaculty_list();
		$this->load->view('template/locator-head', $data);
        $this->load->view('pages/'.$page);

	}

	// public function main($page, $equip, $docs)
	// {
	// 	if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
	// 		show_404();
	// 	}

	// 	$return['equip'] = $this->User_Model->get__borrower_allDetails($equip);
	// 	$this->load->view('template/header_main', $return);
	// 	$return_result['docs'] = $this->User_Model->get__borrower_allDetails($docs);
    //     $this->load->view('pages/'.$page, $return_result);

	// }

	// public function borrow($page = 'borrow')
	// {
	// 	if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
	// 		show_404();
	// 	}

	// 	$this->load->view('template/header_main');
	// 	$this->load->view('pages/modal');
    //     $this->load->view('pages/'.$page);

	// }

	// public function admin($page, $equip, $docs, $action, $set_field)
	// {
	// 	if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
	// 		show_404();
	// 	}

	// 	$return['equip'] = $this->User_Model->get__item_borrower($equip, $action, $set_field);
	// 	$this->load->view('template/header_main', $return);
	// 	$return_result['docs'] = $this->User_Model->get__borrowed_items($docs, $action, $set_field);
    //     $this->load->view('pages/'.$page, $return_result);

	// }

	// public function reports($page)
	// {
	// 	if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
	// 		show_404();
	// 	}

	// 	$return_result['data'] = $this->User_Model->get__reports();
	// 	$this->load->view('template/header_main');
    //     $this->load->view('pages/'.$page, $return_result);
	// }

	// public function details($page, $id, $action_taken, $approved)
	// {
	// 	if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
	// 		show_404();
	// 	}

	// 	$registered_borrower['info'] = $this->Pages->get_borrower($id);
	// 	$this->load->view('template/header_main', $registered_borrower);
	// 	$this->load->view('pages/modal_cancel');
	// 	$this->load->view('pages/modal');
	// 	$borrower['data'] = $this->Pages->get__borrower_details($id, $action_taken, $approved);
    //     $this->load->view('pages/'.$page, $borrower);

	// }	
	
}