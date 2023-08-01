<?php

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		//load helper form
		$this->load->helper('url');

		//load database library manually
		$this->load->database();

		//load model
		$this->load->model('User_details_model');
		$this->load->model('Blogs_details_model');
		$this->load->model('Blogs_categories_details_model');
		$this->load->model('Roles_details_model');
		$this->load->model('Roles_activities_model');

		//load session 
		$this->load->library('session');
	}


	public function index()
	{
		//check logged in or not
		$this->checkUserSession();

		//Add header
		$this->header();

		$this->load->view('admin/dashboard/index');
		$this->load->view('admin/dashboard/footer');
	}

	public function header()
	{
		if (isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			$result = $this->User_details_model->getUserByID($user_id);
			$data['user_details'] = $result;
		}
		$this->load->view('admin/dashboard/header', $data);
	}


	public function checkUserSession()
	{
		if (!isset($_SESSION['user_id'])) {
			redirect('admin/authentication/login', 'refresh');
		}
	}

	// Check User Authentication before giving the access of any functionalies.
	public function checkUserAuthentication($activities_keywords)
	{
		// Fetching all roles by using activities keywords
		$All_allowed_roles = $this->Roles_details_model->getAllRolesByActivtiesKeywords($activities_keywords);

		// Adding all user_type that are allowed to the corresponding activities keywords
		$All_allowed_user_type = array();
		foreach ($All_allowed_roles as $rows) {
			$All_allowed_user_type[] = $rows['role_name'];
		}

		// By give all permission to the Admin
		if (count($All_allowed_roles) == 0 || !in_array('Admin', $All_allowed_user_type)) {
			$All_allowed_user_type[] = 'Admin';
		}

		// Fetching role's activities by keywords 
		$activities_details = $this->Roles_activities_model->getRoleActivtiesByKeywords($activities_keywords);

		if (count($activities_details) > 0 || $activities_keywords == 'roleActivitiesList') {

			// Check the Current User are exits in allowed array or not
			if (!in_array($_SESSION['user_type'], $All_allowed_user_type)) {
				$message_to_user = $activities_details[0]["message_to_user"];
				$redirection_path = $activities_details[0]["redirection_url"];

				echo "<script>alert('$message_to_user');</script>";
				redirect($redirection_path, 'refresh');
			}
		} else {
			echo "<script>alert('First, You need to add/active this \'{$activities_keywords}\' activities in the role activities tab or please contact to Administration office!');</script>";
			redirect('admin/dashboard', 'refresh');
		}
	}

	public function checkActionOnAdmin($classname, $functionname, $id)
	{
		$alert = 'Something Wrong';
		$msg = 'Something Wrong';
		if ($classname == 'Users') {
			$user_details = $this->User_details_model->getUserByID($id);

			$user_type = $user_details[0]['user_type'];

			if ($functionname == 'editUser') {
				$alert = "<script>alert('You can\'t edit the details of the Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'enabledDisabledUser') {
				$alert = "<script>alert('You can\'t change the status of the Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'deleteUser') {
				$alert = "<script>alert('You can\'t delete Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'deleteBulkUsers') {
				$alert = "<script>alert('You can\'t delete Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'bulkUsersStatusChanged') {
				$alert = "<script>alert('You can\'t change the status of the Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'assignRoles') {
				$alert = "<script>alert('You can\'t change Admin\'s role, please contact to Adminitration Office!');</script>";
			}
			$msg = 'The selected user ID: ' . $id . ' has not been updated, please try again!';
			$redirection = 'admin/users/userlist';
		} else if ($classname == 'Roles') {
			

			$role_details = $this->Roles_details_model->getRoleByID($id);

			$user_type = $role_details[0]['role_name'];

			if ($functionname == 'editRole') {
				$alert = "<script>alert('You can\'t edit the role of the Admin, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'enabledDisabledRole') {
				$alert = "<script>alert('You can\'t change the status of the Admin\'s role, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'deleteRole') {
				$alert = "<script>alert('You can\'t delete Admin\'s role, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'deleteBulkRoles') {
				$alert = "<script>alert('You can\'t delete Admin\'s role, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'bulkRolesStatusChanged') {
				$alert = "<script>alert('You can\'t change the status of the  Admin\'s role, please contact to Adminitration Office!');</script>";
			} else if ($functionname == 'assignRoleActivities') {
				$alert = "<script>alert('You can\'t change the Admin\'s role activities, please contact to Adminitration Office!');</script>";
			}
			$msg = 'The selected role ID: ' . $id . ' has not been updated, please try again!';
			$redirection = 'admin/roles';
		}

		if ($user_type == 'Admin' && $_SESSION['user_type'] != 'Admin') {
			echo $alert;
			$_SESSION['failure_msg'] = $msg;
			redirect($redirection, 'refresh');
		}
	}

	public function logout($user_id)
	{
		if (isset($user_id)) {
			unset($_SESSION['user_id']);
			unset($_SESSION['user_type']);
			redirect('admin/authentication/login', 'refresh');
		}
	}
}
