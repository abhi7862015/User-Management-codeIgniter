<?php
require_once(dirname(__FILE__) . "/dashboard.php");

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends Dashboard
{

	public function index()
	{
		//Default page
		$this->userList();
	}

	public function userList()
	{
		//Added Header 
		$this->header();

		//Checked User logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('userList');

		//Fetched all details of users to show in listed formated.
		$result['user_details'] = $this->User_details_model->getAllUsers();

		//Fetched all roles details to show in role name dropdown.
		$result['roles_details'] = $this->Roles_details_model->getAllRoles();

		//Fetched the user details who created this user.
		$result['created_by_user_details'] = array();
		foreach ($result['user_details']  as $rows) {
			$result['created_by_user_details'][$rows['user_id']] = $this->User_details_model->getUserByID($rows['created_by']);
		}

		//Fetched the user details users who last updated this user.
		$result['edited_by_user_details'] = array();
		foreach ($result['user_details']  as $rows) {
			if ($rows['edited_by']) {
				$result['edited_by_user_details'][$rows['user_id']] = $this->User_details_model->getUserByID($rows['edited_by']);
			}
		}

		$this->load->view('admin/users/user_list', $result);
		$this->load->view('admin/dashboard/footer');
	}

	public function addUser()
	{
		//Added Header 
		$this->header();

		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('addUser');

		//Set variables 
		$data['first_name'] = '';
		$data['middle_name'] = '';
		$data['last_name'] = '';
		$data['email'] = '';
		$data['username'] = '';
		$data['password'] = '';
		$data['confirm_password'] = '';

		//After submission of registration form
		if ($this->input->post('submit') == "Submit") {

			//Set variables for persistence
			$data['first_name'] = $this->input->post('first_name');
			$data['middle_name'] = $this->input->post('middle_name');
			$data['last_name'] = $this->input->post('last_name');
			$data['email'] = $this->input->post('email');
			$data['username'] = $this->input->post('username');
			$data['password'] = $this->input->post('password');
			$data['confirm_password'] = $this->input->post('confirm_password');
			$data['user_type_at_creation_time'] = $_SESSION['user_type'];
			$data['created_by'] = $_SESSION['user_id'];

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
				redirect('admin/users/userlist', 'refresh');
			}
		}

		$this->load->view("admin/users/add_user", $data);
		$this->load->view("admin/dashboard/footer");
	}


	public function editUser($user_id)
	{
		//Added Header 
		$this->header();

		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('editUser');

		//Check Action on Admin by other users
		$this->checkActionOnAdmin('Users', 'editUser', $user_id);

		if (isset($user_id)) {

			$data['user_details'] = $this->User_details_model->getUserByID($user_id);

			//Set variables for persistence
			$data['user_id'] = $data['user_details'][0]['user_id'];
			$data['first_name'] = $data['user_details'][0]['first_name'];
			$data['middle_name'] = $data['user_details'][0]['middle_name'];
			$data['last_name'] = $data['user_details'][0]['last_name'];
			$data['email'] = $data['user_details'][0]['email'];
			$data['username'] = $data['user_details'][0]['user_name'];



			//After submission of registration form
			if ($this->input->post('submit') == 'Submit') {

				//Set variables for persistence
				$data['first_name'] = $this->input->post('first_name');
				$data['middle_name'] = $this->input->post('middle_name');
				$data['last_name'] = $this->input->post('last_name');
				$data['email'] = $this->input->post('email');
				$data['username'] = $this->input->post('username');

				//Validation start from here
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
				$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

				//Skipping username error if this field not edited by user.
				if ($data['user_details'][0]['user_name'] == $data['username']) {
					$this->form_validation->set_rules('username', 'Username', 'trim|required');
				} else {
					$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user_details.user_name]');
				}

				//Skipping email error if this field not edited by user.
				if ($data['user_details'][0]['email'] == $data['email']) {
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
				} else {
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user_details.email]');
				}

				//Insert data if found no error in form 
				if ($this->form_validation->run() == true) {

					$result =  $this->User_details_model->UpdateUserByID($data, $user_id);

					if ($result) {
						$_SESSION['success_msg'] = 'User has been updated successfully!';
					} else {
						$_SESSION['failure_msg'] = 'User has not been updated, please try again!';
					}
					redirect('admin/users/userlist', 'refresh');
				}
			}
		} else {
			$_SESSION['failure_msg'] = 'User ID not found, please try again!';
			redirect('admin/users/userlist', 'refresh');
		}

		$this->load->view('admin/users/edit_user', $data);
		$this->load->view("admin/dashboard/footer");
	}

	public function enabledDisabledUser($user_id)
	{
		//Check logged in or not
		$this->checkUserSession();

		//Check User's roles assigned or not 
		if (isset($user_id)) {
			$user_details = $this->User_details_model->getUserByID($user_id);
			if ($user_details[0]['user_type'] == NULL) {
				redirect('admin/users/userlist', 'refresh');
			}
		}

		//Check User's Activties Permission 
		$this->checkUserAuthentication('enabledDisabledUser');

		//Check Action on Admin by other users
		$this->checkActionOnAdmin('Users', 'enabledDisabledUser', $user_id);

		if (isset($user_id)) {

			$logged_user_disabled = false;
			if ($user_details[0]['user_status'] == 'Active') {

				$user_status = 'Inactive';

				// if user disabled itself user status 
				if ($user_details[0]['user_id'] == $_SESSION['user_id']) {
					$logged_user_disabled = true;
				}
			} else {
				$user_status = 'Active';
			}

			$result = $this->User_details_model->enabledDisabledUser($user_status, $user_id);

			if ($result) {
				if ($logged_user_disabled) {
					$this->logout($user_id);
				}
				$_SESSION['success_msg'] = 'User ID: ' . $user_id . ' has been ' . $user_status . ' successfully!';
			} else {
				$_SESSION['failure_msg'] = 'User ID: ' . $user_id . ' has not been ' . $user_status . ', please try again!';
			}
		} else {
			$_SESSION['failure_msg'] = 'User ID not found, please try again!';
		}
		redirect('admin/users/userlist', 'refresh');
	}


	public function deleteUser($user_id)
	{
		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('deleteUser');

		//Check Action on Admin by other users
		$this->checkActionOnAdmin('Users', 'deleteUser', $user_id);

		if (isset($user_id)) {

			$result =  $this->User_details_model->deleteUserByID($user_id);

			if ($result) {
				$_SESSION['success_msg'] = 'User ID: ' . $user_id . ' has been deleted successfully!';
			} else {
				$_SESSION['failure_msg'] = 'User ID: ' . $user_id . ' has not been deleted, please try again!';
			}
		}
		redirect('admin/users/userlist', 'refresh');
	}


	public function filterOutUser()
	{
		//Added Header 
		$this->header();

		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('filterOutUser');

		if ($this->input->get('submit') == 'Searched') {

			$searched = $this->input->get('search');
			$user_status = $this->input->get('userStatus');
			$user_type = $this->input->get('userType');

			$data['all_filter'] = '';
			$data['search_status'] = '';
			$data['search_type'] = '';
			$data['status_type'] = '';
			$data['search_cond'] = '';
			$data['status_cond'] = '';
			$data['type_cond'] = '';

			if (isset($searched) && isset($user_status) && isset($user_type) && $searched != '' && $user_status != '' && $user_type != '') {
				$data['all_filter'] = " Where (first_name like '" . $searched . "%' or email like'" . $searched . "%') and user_status='" . $user_status . "' and user_type='" . $user_type . "'";
			} else if (isset($searched) && isset($user_status) && $searched != '' && $user_status != '') {
				$data['search_status'] = " Where (first_name like '" . $searched . "%' or email like'" . $searched . "%') and user_status='" . $user_status . "'";
			} else if (isset($searched) && isset($user_type) && $searched != '' && $user_type != '') {
				$data['search_type']  = " Where (first_name like '" . $searched . "%' or email like'" . $searched . "%') and user_type='" . $user_type . "'";
			} else if (isset($user_status) && isset($user_type) && $user_status != '' && $user_type != '') {
				$data['status_type']  = " Where user_status='" . $user_status . "' and user_type='" . $user_type . "'";
			} else if (isset($searched) && $searched != '') {
				$data['search_cond']  = " where (first_name like '" . $searched . "%' or email like'" . $searched . "%')";
			} else if (isset($user_status) && $user_status != '') {
				$data['status_cond']  = " where user_status='" . $user_status . "'";
			} else if (isset($user_type) && $user_type != '') {
				$data['type_cond']  = " where user_type='" . $user_type . "'";
			}

			$searched_result = $this->User_details_model->getUserBySearched($data);

			$data['user_details'] = $searched_result;
			$data['searched'] = $searched;
			$data['user_status'] = $user_status;
			$data['user_type'] = $user_type;

			$data['roles_details'] = $this->Roles_details_model->getAllRoles();


			//Fetched the user details who created this user.
			$data['created_by_user_details'] = array();
			foreach ($data['user_details']  as $rows) {
				$data['created_by_user_details'][$rows['user_id']] = $this->User_details_model->getUserByID($rows['created_by']);
			}

			//Fetched the user details users who last updated this user.
			$data['edited_by_user_details'] = array();
			foreach ($data['user_details']  as $rows) {
				if ($rows['edited_by']) {
					$data['edited_by_user_details'][$rows['user_id']] = $this->User_details_model->getUserByID($rows['edited_by']);
				}
			}
		}

		$this->load->view('admin/users/user_list', $data);
		$this->load->view('admin/dashboard/footer');
	}


	public function assignRoles($user_id)
	{
		//Added Header 
		$this->header();

		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('assignRoles');

		//Check Action on Admin by other users
		$this->checkActionOnAdmin('Users', 'assignRoles', $user_id);

		//Fetched all roles details to show in role name dropdown.
		$data['roles_details'] = $this->Roles_details_model->getAllRoles();

		if (isset($user_id)) {

			// Make persistence while editing assigned role
			$data['user_details'] = $this->User_details_model->getRoleByID($user_id);
			$data['user_type'] = $data['user_details'][0]['user_type'];


			//After submission of registration form
			if ($this->input->post('submit') == "Submit") {

				//Set variables for persistence
				$data['user_type'] = $this->input->post('user_type');
				$data['edited_by'] = $_SESSION['user_id'];

				//Validation start from here
				$this->form_validation->set_rules('user_type', 'Roles Name', 'trim|required');

				//Insert data if found no error in form 
				if ($this->form_validation->run() == true) {

					$role_details = $this->Roles_details_model->getRoleByRoleName($data['user_type']);

					$data['role_id'] = $role_details[0]['role_id'];
					$result = $this->User_details_model->assignRoles($data, $user_id);

					if ($result) {
						$_SESSION['success_msg'] = 'Role has been assigned to the user id: ' . $user_id . ' successfully';
					} else {
						$_SESSION['failure_msg'] = 'Role has been assigned, please try again!';
					}
					redirect('admin/users/userlist', 'refresh');
				}
			}
		}

		$this->load->view("admin/users/assign_roles", $data);
		$this->load->view("admin/dashboard/footer");
	}


	public function deleteBulkUsers()
	{
		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('deleteBulkUsers');

		if (count($this->input->post()) > 1) {

			$all_delete = true;

			foreach ($this->input->post() as $user_id => $value) {

				if (is_numeric($user_id)) {

					//Check Action on Admin by other users
					$this->checkActionOnAdmin('Users', 'deleteBulkUsers', $user_id);

					$check_result = $this->User_details_model->deleteUserByID($user_id);

					if (!$check_result) {
						$all_delete = false;
					}
				}
			}

			if ($all_delete) {
				$_SESSION['success_msg'] = 'All selected Users has been deleted successfully!';
			} else {
				$_SESSION['failure_msg'] = 'All selected Users has not been deleted, please try again!';
			}
		} else {
			$_SESSION['failure_msg'] = 'Please select atleast one user or please try again!';
		}

		redirect('admin/users', 'refresh');
	}

	public function bulkUsersStatusChanged()
	{
		//Check logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('bulkUsersStatusChanged');

		if (count($this->input->post()) > 1) {

			$all_status = true;
			$logged_user_disabled = false;

			foreach ($this->input->post() as $user_id => $value) {

				if (is_numeric($user_id)) {

					//Check Action on Admin by other users
					$this->checkActionOnAdmin('Users', 'bulkUsersStatusChanged', $user_id);

					$users_details =  $this->User_details_model->getUserByID($user_id);

					if ($users_details[0]['user_status'] == 'Active') {

						// if user disabled itself user status 
						if ($users_details[0]['user_id'] == $_SESSION['user_id']) {
							$logged_user_disabled = true;
						}

						$check_result = $this->User_details_model->enabledDisabledUser('Inactive', $user_id);
					} else {
						$check_result = $this->User_details_model->enabledDisabledUser('Active', $user_id);
					}
					if (!$check_result) {
						$all_status = false;
					}
				}
			}

			if ($all_status) {
				if ($logged_user_disabled) {
					$this->logout($user_id);
				}
				$_SESSION['success_msg'] = 'All selected User\'s Status has been changed successfully!';
			} else {
				$_SESSION['failure_msg'] = 'All selected User\'s Status has not been changed, please try again!';
			}
		} else {
			$_SESSION['failure_msg'] = 'Please select atleast one user or please try again!';
		}
		redirect('admin/users', 'refresh');
	}


	public function exportUsers()
	{

		//Checked User logged in or not
		$this->checkUserSession();

		//Check User's Activties Permission 
		$this->checkUserAuthentication('exportUsers');

		//Fetched all details of users to show in listed formated.
		$user_details = $this->User_details_model->getAllUsers();

		// Make excel sheet 
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();

		foreach (range('A', 'I') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$sheet->setCellValue('A1', 'S. No.');
		$sheet->setCellValue('B1', 'Name');
		$sheet->setCellValue('C1', 'Username');
		$sheet->setCellValue('D1', 'Role (user_type)');
		$sheet->setCellValue('E1', 'Created By');
		$sheet->setCellValue('F1', 'Last Edited By');
		$sheet->setCellValue('G1', 'User Status');
		$sheet->setCellValue('H1', 'Last Update Date');
		$sheet->setCellValue('I1', 'Added Date');

		$count = 2;
		foreach ($user_details as $rows) {
			$created_by = $this->User_details_model->getUserByID($rows['created_by']);
			$edited_by = $this->User_details_model->getUserByID($rows['edited_by']);

			$sheet->setCellValue('A' . $count, $count - 1);
			$sheet->setCellValue('B' . $count,  $rows['first_name']);
			$sheet->setCellValue('C' . $count, $rows['user_name']);
			$sheet->setCellValue('D' . $count,  $rows['user_type']);
			if (count($created_by) > 0) {
				$sheet->setCellValue('E' . $count, $created_by[0]['first_name'] . ' ' . $created_by[0]['last_name']);
			} else {
				$sheet->setCellValue('E' . $count, '');
			}
			if (count($edited_by) > 0) {
				$sheet->setCellValue('F' . $count, $edited_by[0]['first_name'] . ' ' . $edited_by[0]['last_name']);
			} else {
				$sheet->setCellValue('F' . $count, '');
			}
			$sheet->setCellValue('G' . $count,  $rows['user_status']);
			$sheet->setCellValue('H' . $count,  $rows['updated_date']);
			$sheet->setCellValue('I' . $count,  $rows['added_date']);
			$count++;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'users_details_export.xlsx';
		$writer->save($filename);

		// Set the headers for download
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');

		ob_clean();
		flush();

		// Read and output the file
		readfile($filename);
		exit;
	}
}
