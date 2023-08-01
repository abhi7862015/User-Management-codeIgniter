<?php
require_once(dirname(__FILE__) . "/dashboard.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RoleActivities extends Dashboard
{
    public function index()
    {
        //Default Page
        $this->roleActivitiesList();
    }
    public function roleActivitiesList()
    {
        //Added Header
        $this->header();

        //Check User logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('roleActivitiesList');

        $result['roles_activities_details'] = $this->Roles_activities_model->getAllRolesActivities();

        $result['created_by_user_details'] = array();
        foreach ($result['roles_activities_details']  as $rows) {
            $result['created_by_user_details'][$rows['roles_activities_id']] = $this->Roles_activities_model->getUserDetailsById($rows['created_by']);
        }

        $result['edited_by_user_details'] = array();
        foreach ($result['roles_activities_details']  as $rows) {
            if ($rows['edited_by']) {
                $result['edited_by_user_details'][$rows['roles_activities_id']] = $this->Roles_activities_model->getUserDetailsById($rows['edited_by']);
            }
        }

        $this->load->view('admin/role_activities/role_activities_list', $result);
        $this->load->view('admin/dashboard/footer');
    }

    public function addRoleActivities()
    {
        //Added Header
        $this->header();

        //check logged in or not
        $this->checkUserSession();

        // Check User's Activties Permission 
        $this->checkUserAuthentication('addRoleActivities');

        $data['activities_name'] = '';
        $data['activities_description'] = '';
        $data['activities_keywords'] = '';
        $data['redirection_url'] = '';
        $data['message_to_user'] = '';

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['activities_name'] = $this->input->post('activities_name');
            $data['activities_description'] = $this->input->post('activities_description');
            $data['activities_keywords'] = $this->input->post('activities_keywords');
            $data['redirection_url'] = $this->input->post('redirection_url');
            $data['message_to_user'] = $this->input->post('message_to_user');
            $data['user_type_at_creation_time'] = $_SESSION['user_type'];
            $data['created_by'] = $_SESSION['user_id'];


            // //Validation start from here
            $this->form_validation->set_rules('activities_name', 'Activities Name', 'trim|required');
            $this->form_validation->set_rules('activities_description', 'Activities Description', 'trim|required');
            $this->form_validation->set_rules('activities_keywords', 'Activities Keywords', 'trim|required|alpha');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Roles_activities_model->addRoleActivities($data);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role Activities has been added successfully and the Role Activities ID is : ' . $result;
                } else {
                    $_SESSION['failure_msg'] = 'Role Activities has not been added, please try again!';
                }
                redirect('admin/roleActivities', 'refresh');
            }
        }

        $this->load->view('admin/role_activities/add_role_activities', $data);
        $this->load->view('admin/dashboard/footer');
    }


    public function editRoleActivities($roles_activities_id)
    {
        //Added Header
        $this->header();

        //check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('editRoleActivities');
        
        $data['roles_activities_details'] = $this->Roles_activities_model->getRoleActivitiesById($roles_activities_id);

        $data['activities_name'] =  $data['roles_activities_details'][0]['activities_name'];
        $data['activities_description'] =  $data['roles_activities_details'][0]['activities_description'];
        $data['activities_keywords'] = $data['roles_activities_details'][0]['activities_keywords'];
        $data['roles_activities_id'] = $roles_activities_id;

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['activities_name'] = $this->input->post('activities_name');
            $data['activities_description'] = $this->input->post('activities_description');
            $data['activities_keywords'] = $this->input->post('activities_keywords');
            $data['edited_by'] = $_SESSION['user_id'];
            $data['user_type_at_creation_time'] = $_SESSION['user_type'];

            // //Validation start from here
            $this->form_validation->set_rules('activities_name', 'Role Activities Name', 'trim|required');
            $this->form_validation->set_rules('activities_description', 'Role Activities Description', 'trim|required');
            $this->form_validation->set_rules('activities_keywords', 'Role Activities Status', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Roles_activities_model->editRoleActivities($data, $roles_activities_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role Activities has been edited successfull!';
                } else {
                    $_SESSION['failure_msg'] = 'Role Activities has not been edited, please try again!';
                }
                redirect('admin/roleActivities', 'refresh');
            }
        }

        $this->load->view('admin/role_activities/edit_role_activities', $data);
        $this->load->view('admin/dashboard/footer');
    }

    public function enabledDisabledRoleActivities($roles_activities_id, $activities_status)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('enabledDisabledRoleActivities');

        if (isset($roles_activities_id) && isset($activities_status)) {

            if ($activities_status == 'Active') {
                $activities_status = 'Inactive';
            } else {
                $activities_status = 'Active';
            }

            $result = $this->Roles_activities_model->enabledDisabledRoleActivities($roles_activities_id, $activities_status);

            if ($result) {
                $_SESSION['success_msg'] = 'Role Activities ID: ' . $roles_activities_id . ' has been ' . $activities_status . ' successfully!';
            } else {
                $_SESSION['failure_msg'] = 'Role Activities ID: ' . $roles_activities_id . ' has not been ' . $activities_status . ', please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'No Roles Activities\'s are seletced, please try again!';
        }

        redirect('admin/roleActivities', 'refresh');
    }



    public function deleteRoleActivities($roles_activities_id)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('deleteRoleActivities');

        if (isset($roles_activities_id)) {

            $check_Relation_With_Roles = $this->Roles_activities_model->checkRelationWithRoles($roles_activities_id);

            if (count($check_Relation_With_Roles) == 0) {

                $result = $this->Roles_activities_model->deleteRoleActivities($roles_activities_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Role Activities ID: ' . $roles_activities_id . ' has been deleted successfully!';
                } else {
                    $_SESSION['failure_msg'] = 'Role Activities ID: ' . $roles_activities_id . ' has not been deleted, please try again!';
                }
            } else {
                echo "<script>alert('Activities Already used with Roles.... First, you need delete all the relation to this activities (foriegn key) from the Roles List Tab');</script>";
            }
        } else {
            $_SESSION['failure_msg'] = 'Role Id is not found, please try again!';
        }

        redirect('admin/roleActivities', 'refresh');
    }


    public function deleteBulkActivities()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('deleteBulkActivities');

        if (count($this->input->post()) > 1) {

            $all_delete = true;
            foreach ($this->input->post() as $roles_activities_id => $value) {

                if (is_numeric($roles_activities_id)) {

                    $check_result = $this->Roles_activities_model->deleteRoleActivities($roles_activities_id);

                    if (!$check_result) {
                        $all_delete = false;
                    }
                }
            }

            if ($all_delete) {
                $_SESSION['success_msg'] = 'All selected Roles Activities has been deleted successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Roles Activities has not been deleted, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'No Roles Activities\'s are seletced, please try again!';
        }
        redirect('admin/roleActivities', 'refresh');
    }

    public function bulkActivitiesStatusChanged()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('bulkActivitiesStatusChanged');

        if (count($this->input->post()) > 1) {

            $all_status = true;
            foreach ($this->input->post() as $roles_activities_id => $value) {

                if (is_numeric($roles_activities_id)) {

                    $roles_activities_details =  $this->Roles_activities_model->getRoleActivitiesById($roles_activities_id);

                    if ($roles_activities_details[0]['activities_status'] == 'Active') {
                        $check_result = $this->Roles_activities_model->enabledDisabledRoleActivities($roles_activities_id, 'Inactive');
                    } else {
                        $check_result = $this->Roles_activities_model->enabledDisabledRoleActivities($roles_activities_id, 'Active');
                    }
                    if (!$check_result) {
                        $all_status = false;
                    }
                }
            }
            if ($all_status) {
                $_SESSION['success_msg'] = 'All selected Roles Activities\'s Status has been changed successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Roles Activities\'s Status has not been changed, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'No Roles Activities\'s are seletced, please try again!';
        }
        redirect('admin/roleActivities', 'refresh');
    }

    public function exportActivities()
    {

        //Checked User logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('exportActivities');

        //Fetched all details of roles activities to show in listed formated.
        $roles_activities_details = $this->Roles_activities_model->getAllRolesActivities();

        // Make excel sheet 
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'H') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setCellValue('A1', 'S. No.');
        $sheet->setCellValue('B1', 'Role Activities');
        $sheet->setCellValue('C1', 'Activities Keywords/Classname');
        $sheet->setCellValue('D1', 'Created By');
        $sheet->setCellValue('E1', 'Last Edited By');
        $sheet->setCellValue('F1', 'Activities Status');
        $sheet->setCellValue('G1', 'Last Update Date');
        $sheet->setCellValue('H1', 'Added Date');

        $count = 2;
        foreach ($roles_activities_details as $rows) {
            $created_by = $this->User_details_model->getUserByID($rows['created_by']);
            $edited_by = $this->User_details_model->getUserByID($rows['edited_by']);

            $sheet->setCellValue('A' . $count, $count - 1);
            $sheet->setCellValue('B' . $count,  $rows['activities_name']);
            $sheet->setCellValue('C' . $count, $rows['activities_keywords']);
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
            $sheet->setCellValue('F' . $count,  $rows['activities_status']);
            $sheet->setCellValue('G' . $count,  $rows['updated_date']);
            $sheet->setCellValue('H' . $count,  $rows['added_date']);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'roles_activities_details_export.xlsx';
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
