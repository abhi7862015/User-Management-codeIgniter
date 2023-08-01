<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//load form validation 
		$this->load->library('form_validation');

		//load helper form
		$this->load->helper('form');
		$this->load->helper('url');

		//load database library manually
		$this->load->database();

		//load model
		$this->load->model('User_details_model');

		//load session 
		$this->load->library('session');
	}

	public function index()
	{
		$this->login();
	}
	public function signup()
	{
		//After submission of registration form
		if ($this->input->method(true)) {

			//Set variables for persistence
			$data['first_name'] = $this->input->post('first_name');
			$data['middle_name'] = $this->input->post('middle_name');
			$data['last_name'] = $this->input->post('last_name');
			$data['email'] = $this->input->post('email');
			$data['username'] = $this->input->post('username');
			$data['password'] = $this->input->post('password');
			$data['confirm_password'] = $this->input->post('confirm_password');

			//Validation start from here
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user_details.email]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user_details.user_name]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Confrim password', 'trim|required|min_length[5]');

			//Insert data if found no error in form 
			if ($this->form_validation->run() == true) {

				$result = $this->User_details_model->addUsers($data);

				if ($result) {
					$_SESSION['success_msg'] = 'User has been added successfully and the User ID is : ' . $result;
				} else {
					$_SESSION['failure_msg'] = 'User has not been added, please try again!';
				}
			}
		}

		$this->load->view("admin/authentication/sign_up", $data);
	}



	public function login()
	{
		$username = "";
		$password = "";

		//After submission of registration form
		if ($this->input->post("submit") == "Login") {

			//Set variables for persistence
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			//Validation start from here
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');

			//Insert data if found no error in form 
			if ($this->form_validation->run() == true) {

				$result = $this->User_details_model->getUserByUsernamePassword($username, $password);

				if (count($result) > 0) {

					if ($result[0]['user_status'] == 'Active') {
						if ($result[0]['role_id'] != NULL &&  $result[0]['user_type'] != NULL) {
							$_SESSION['user_id'] = $result[0]['user_id'];
							$_SESSION['role_id'] = $result[0]['role_id'];
							$_SESSION['user_type'] = $result[0]['user_type'];
							redirect('admin/dashboard', 'refresh');
						} else {
							$errors[0] = "Your Account don't have any Role/Designation, please contact Admin!";
						}
					} else {
						$errors[0] = "Your Account has been disabled, please contact Admin!";
					}
				} else {
					$errors[0] = "Wrong email or password, please try again!";
				}
				$data['errors'] = $errors;
			}
		}

		$data['username'] = $username;
		$data['password'] = $password;


		$this->load->view("admin/authentication/log_in", $data);
	}


	public function logout($user_id)
	{
		if (isset($user_id)) {
			unset($_SESSION['user_id']);
			unset($_SESSION['user_type']);
			unset($_SESSION['role_id']);
			redirect('admin/authentication/login', 'refresh');
		}
	}
}
