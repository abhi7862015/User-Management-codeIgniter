<?php
require_once(dirname(__FILE__) . "/dashboard.php");

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Roles extends Dashboard
{

    public function index()
    {
        //Default Page
        $this->roleList();
    }
    public function roleList()
    {
        //Added Header
        $this->header();

        //Check User logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('roleList');

        //Fetched all details of roles to show in listed formated.
        $result['roles_details'] = $this->Roles_details_model->getAllRoles();

        //Fetched the user details who created this user.
        $result['created_by_user_details'] = array();
        foreach ($result['roles_details']  as $rows) {
            $result['created_by_user_details'][$rows['role_id']] = $this->Roles_details_model->getUserDetailsById($rows['created_by']);
        }

        //Fetched the user details users who last updated this user.
        $result['edited_by_user_details'] = array();
        foreach ($result['roles_details']  as $rows) {
            if ($rows['edited_by']) {
                $result['edited_by_user_details'][$rows['role_id']] = $this->Roles_details_model->getUserDetailsById($rows['edited_by']);
            }
        }

        //Fetched the role activities details to check this role have any assigned role activities or not.
        $result['checked_roles_activities_details'] = array();
        foreach ($result['roles_details']  as $rows) {
            $result['checked_roles_activities_details'][$rows['role_id']] = $this->Roles_details_model->checkAssignedRoleActivities($rows['role_id']);
        }

        //Fetch All Roles Activites to show model popup
        $result['all_roles_activities_details'] = $this->Roles_activities_model->getAllRolesActivitiesByStatus('Active');

        $this->load->view('admin/roles/roles_list', $result);
        $this->load->view('admin/dashboard/footer');
    }

    public function addRole()
    {
        //Added Header
        $this->header();

        //check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('addRole');

        //Fetched all details of roles to show in listed formated.
        $data['roles_details'] = $this->Roles_details_model->getAllRoles();

        //Set variables for persistence
        $data['role_name'] = "";
        $data['role_description'] = "";

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['role_name'] = $this->input->post('role_name');
            $data['role_description'] = $this->input->post('role_description');
            $data['created_by'] = $_SESSION['user_id'];
            $data['user_type'] = $_SESSION['user_type'];

            // //Validation start from here
            $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|is_unique[roles_details.role_name]');
            $this->form_validation->set_rules('role_description', 'Role Description', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Roles_details_model->addRole($data);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role/Designation has been added successfully and the Role ID is : ' . $result;
                } else {
                    $_SESSION['failure_msg'] = 'Role/Designation has not been added, please try again!';
                }
                redirect('admin/roles', 'refresh');
            }
        }

        $this->load->view('admin/roles/add_role', $data);
        $this->load->view('admin/dashboard/footer');
    }


    public function editRole($role_id)
    {
        //Added Header
        $this->header();

        //check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('editRole');

        //Check Action on Admin by other users
        $this->checkActionOnAdmin('Roles', 'editRole', $role_id);

        //Fetched all details of roles to make persistence.
        $data['roles_details'] = $this->Roles_details_model->getRoleById($role_id);

        //Set variables for persistence
        $data['role_name'] =  $data['roles_details'][0]['role_name'];
        $data['role_description'] =  $data['roles_details'][0]['role_description'];
        $data['role_status'] = $data['roles_details'][0]['role_status'];
        $data['role_id'] = $role_id;

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['role_name'] = $this->input->post('role_name');
            $data['role_description'] = $this->input->post('role_description');
            $data['edited_by'] = $_SESSION['user_id'];
            $data['user_type'] = $_SESSION['user_type'];

            //Validation start from here
            if ($this->input->post('role_name') != $data['roles_details'][0]['role_name']) {
                $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|is_unique[roles_details.role_name]');
            }
            $this->form_validation->set_rules('role_description', 'Role Description', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Roles_details_model->editRole($data, $role_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role/Designation has been edited successfull!';
                } else {
                    $_SESSION['failure_msg'] = 'Role/Designation has not been edited, please try again!';
                }
                redirect('admin/roles', 'refresh');
            }
        }

        $this->load->view('admin/roles/edit_role', $data);
        $this->load->view('admin/dashboard/footer');
    }

    public function enabledDisabledRole($role_id, $role_status)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('enabledDisabledRole');

        //Check Action on Admin by other users
        $this->checkActionOnAdmin('Roles', 'enabledDisabledRole', $role_id);

        if (isset($role_id) && isset($role_status)) {

            $roles_details =  $this->Roles_details_model->getRoleByID($role_id);

            if ($role_status == 'Active') {
                $role_status = 'Inactive';
            } else {

                // check role activities assigned or not, before enabling the status
                $check_role_activities_assigned = $this->Roles_details_model->getRoleActivitiesByRoleId($role_id);

                if (count($check_role_activities_assigned) > 0) {
                    $role_status = 'Active';
                } else {
                    echo "<script>alert('First make relation with the roles activities for this role.');</script>";

                    $_SESSION['failure_msg'] = 'This role id has not have any assigned role activities, please try again!';
                    redirect('admin/roles', 'refresh');
                }
            }

            $result = $this->Roles_details_model->enabledDisabledRole($role_id, $role_status);

            if ($result) {
                $_SESSION['success_msg'] = 'Role ID: ' . $role_id . ' has been ' . $role_status . ' successfully!';
            } else {
                $_SESSION['failure_msg'] = 'Role ID: ' . $role_id . ' has not been ' . $role_status . ', please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Role ID or role status are not found, please try again!';
        }

        redirect('admin/roles', 'refresh');
    }



    public function deleteRole($role_id)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('deleteRole');

        //Check Action on Admin by other users
        $this->checkActionOnAdmin('Roles', 'deleteRole', $role_id);

        if (isset($role_id)) {

            $check_Relation_With_users = $this->Roles_details_model->checkRelationWithUsers($role_id);

            if (count($check_Relation_With_users) == 0) {

                $result = $this->Roles_details_model->deleteRole($role_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role ID: ' . $role_id . ' has been deleted successfully!';
                } else {
                    $_SESSION['failure_msg'] = 'Role ID: ' . $role_id . ' has not been deleted, please try again!';
                }
            } else {
                echo "<script>alert('Role Already used in Users.... First, delete all user with the same role name (foriegn key) from the Users List Tab');</script>";
            }
        } else {
            $_SESSION['failure_msg'] = 'Role ID is not found, please try again!';
        }

        redirect('admin/roles', 'refresh');
    }


    public function assignRoleActivities()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('assignRoleActivities');

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            $role_id = $this->input->post('roleId');

            //Check Action on Admin by other users
            $this->checkActionOnAdmin('Roles', 'assignRoleActivities', $role_id);

            if ($role_id == $_SESSION['role_id']) {

                echo "<script>alert('You can\'t edit Admin role\'s activities, please contact to Administration office!');</script>";

                $_SESSION['failure_msg'] = 'Activites has not updated or assigned, please try again!';
            } else {

                // Fetch All Roles Activites to show model popup
                $result['roles_activities_details'] = $this->Roles_activities_model->getAllRolesActivities();

                // Added all selected id for activities to the current role
                $check_assign_roles_activities = $this->Roles_details_model->checkAssignedRoleActivities($this->input->post('roleId'));

                $all_selected_activities_id = array();
                foreach ($check_assign_roles_activities as $rows) {
                    $all_selected_activities_id[] = $rows['roles_activities_id'];
                }


                // Storing all activities that unchecked after previous selecting
                $delete_activities_id = array();
                foreach ($check_assign_roles_activities as $rows1) {
                    $is_delete = true;
                    foreach ($this->input->post() as $key2 => $rows2) {
                        if (is_numeric($key2)) {
                            if ($rows1['roles_activities_id'] == $key2) {
                                $is_delete = false;
                            }
                        }
                    }
                    if ($is_delete) {
                        $delete_activities_id[] = $rows1['roles_activities_id'];
                    }
                }

                // Storing activities if new activities checked/update 
                $add_activities_id = array();
                foreach ($this->input->post() as $key2 => $rows2) {
                    if (is_numeric($key2)) {
                        if (!in_array($key2, $all_selected_activities_id)) {
                            $add_activities_id[] = $key2;
                        }
                    }
                }

                // Delete all activities that unchecked after previous selecting
                if (count($delete_activities_id) > 0) {
                    $is_deleted = true;
                    foreach ($delete_activities_id as $key) {
                        if (is_numeric($key)) {
                            $data['roleId'] = $this->input->post('roleId');
                            $data['roles_activities_id'] = $key;
                            $this->Roles_details_model->deleteAssignedRoleActivities($data);
                        }
                    }
                } else {
                    $is_deleted = false;
                }

                // Added activities if new activities checked/update 
                if (count($add_activities_id) > 0) {
                    $is_added = true;
                    $check_result = true;
                    foreach ($add_activities_id as $key) {
                        if (is_numeric($key)) {
                            $data['roleId'] = $this->input->post('roleId');
                            $data['roles_activities_id'] = $key;
                            $res = $this->Roles_details_model->assignRoleActivities($data);
                            if (!$res) {
                                $is_added = false;
                                $check_result = false;
                            }
                        }
                    }
                } else {
                    $is_added = false;
                }

                if ($is_added == false && $is_deleted == false) {
                    $_SESSION['failure_msg'] = 'No changes detected, please try again!';
                } else {
                    $_SESSION['success_msg'] = 'Activites has been updated successfully';
                }
            }
        }

        redirect('admin/roles', 'refresh');
    }



    public function seeAllAssignedActivitiesList($role_id)
    {

        // Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('seeAllAssignedActivitiesList');

        //Fetched all roles details that have already assigned roles activities.
        $result['checked_roles_activities_details'] = $this->Roles_details_model->checkAssignedRoleActivities($role_id);

        //Fetched All Roles Activites to show model popup
        $result['all_roles_activities_details'] = $this->Roles_activities_model->getAllRolesActivitiesByStatus('Active');

        $result['role_id'] = $role_id;

        $this->load->view('admin/roles/see_all_assigned_activities', $result);
        $this->load->view('admin/dashboard/footer');
    }

    public function checkAssignedRoleActivities()
    {
        if ($_POST['role_id']) {
            // fetched all assigned activities to a particular roles
            $result['roles_activities_details'] = $this->Roles_details_model->checkAssignedRoleActivities($_POST['role_id']);
        }
    }

    public function checkUserAuthorization_OnRoleAssignment()
    {
        //Check User authentication";
        $this->checkUserAuthentication('checkUserAuthorization_OnRoleAssignment');
    }


    public function deleteBulkRoles()
    {
        //check logged in or not
        $this->checkUserSession();

        // Check User's Activties Permission 
        $this->checkUserAuthentication('deleteBulkRoles');

        if (count($this->input->post()) > 1) {

            $all_delete = true;
            foreach ($this->input->post() as $role_id => $value) {

                if (is_numeric($role_id)) {

                    //Check Action on Admin by other users
                    $this->checkActionOnAdmin('Roles', 'deleteBulkRoles', $role_id);

                    $check_result = $this->Roles_details_model->deleteRole($role_id);

                    if (!$check_result) {
                        $all_delete = false;
                    }
                }
            }

            if ($all_delete) {
                $_SESSION['success_msg'] = 'All selected Roles has been deleted successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Roles has not been deleted, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'No Roles are selected, please try again!';
        }

        redirect('admin/Roles', 'refresh');
    }

    public function bulkRolesStatusChanged()
    {
        //check logged in or not
        $this->checkUserSession();

        // Check User's Activties Permission 
        $this->checkUserAuthentication('bulkRolesStatusChanged');

        if (count($this->input->post()) > 1) {

            $all_status = true;
            foreach ($this->input->post() as $role_id => $value) {

                if (is_numeric($role_id)) {

                    //Check Action on Admin by other users
                    $this->checkActionOnAdmin('Roles', 'deleteBulkRoles', $role_id);

                    $roles_details =  $this->Roles_details_model->getRoleById($role_id);

                    if ($roles_details[0]['role_status'] == 'Active') {
                        $check_result = $this->Roles_details_model->enabledDisabledRole($role_id, 'Inactive');
                    } else {
                        $check_result = $this->Roles_details_model->enabledDisabledRole($role_id, 'Active');
                    }
                    if (!$check_result) {
                        $all_status = false;
                    }
                }
            }

            if ($all_status) {
                $_SESSION['success_msg'] = 'All selected Role\'s Status has been changed successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Role\'s Status has not been changed, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'No Roles are selected, please try again!';
        }


        redirect('admin/Roles', 'refresh');
    }

    public function exportRoles()
    {

        //Checked User logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('exportRoles');

        //Fetched all details of roles to show in listed formated.
        $roles_details = $this->Roles_details_model->getAllRoles();

        // Make excel sheet 
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'H') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setCellValue('A1', 'S. No.');
        $sheet->setCellValue('B1', 'Roles/Designation');
        $sheet->setCellValue('C1', 'Description');
        $sheet->setCellValue('D1', 'Created By');
        $sheet->setCellValue('E1', 'Last Edited By');
        $sheet->setCellValue('F1', 'Roles Status');
        $sheet->setCellValue('G1', 'Last Update Date');
        $sheet->setCellValue('H1', 'Added Date');

        $count = 2;
        foreach ($roles_details as $rows) {
            $created_by = $this->User_details_model->getUserByID($rows['created_by']);
            $edited_by = $this->User_details_model->getUserByID($rows['edited_by']);

            $sheet->setCellValue('A' . $count, $count - 1);
            $sheet->setCellValue('B' . $count,  $rows['role_name']);
            $sheet->setCellValue('C' . $count, $rows['role_description']);
            if (count($created_by) > 0) {
                $sheet->setCellValue('D' . $count, $created_by[0]['first_name'] . ' ' . $created_by[0]['last_name']);
            } else {
                $sheet->setCellValue('D' . $count, '');
            }
            if (count($edited_by) > 0) {
                $sheet->setCellValue('E' . $count, $edited_by[0]['first_name'] . ' ' . $edited_by[0]['last_name']);
            } else {
                $sheet->setCellValue('E' . $count, '');
            }
            $sheet->setCellValue('F' . $count,  $rows['role_status']);
            $sheet->setCellValue('G' . $count,  $rows['updated_date']);
            $sheet->setCellValue('H' . $count,  $rows['added_date']);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'roles_details_export.xlsx';
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
