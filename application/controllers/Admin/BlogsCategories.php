<?php
require_once(dirname(__FILE__) . "/dashboard.php");

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BlogsCategories extends dashboard
{

    public function index()
    {
        //Default page
        $this->categoriesList();
    }


    public function categoriesList()
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('categoriesList');

        //Fetched all details of blogs categories to show in listed formated.
        $result['categories_details'] = $this->Blogs_categories_details_model->getAllCategories();

        //Fetched the user details who created this user.
        $result['created_by_user_details'] = array();
        foreach ($result['categories_details']  as $rows) {
            $result['created_by_user_details'][$rows['blogs_categories_id']] = $this->Blogs_categories_details_model->getUserNameById($rows['created_by']);
        }

        //Fetched the user details users who last updated this user.
        $result['edited_by_user_details'] = array();
        foreach ($result['categories_details']  as $rows) {
            if ($rows['edited_by']) {
                $result['edited_by_user_details'][$rows['blogs_categories_id']] = $this->Blogs_categories_details_model->getUserNameById($rows['edited_by']);
            }
        }

        $this->load->view('admin/blogs_categories/categories_list', $result);
        $this->load->view('admin/dashboard/footer');
    }


    public function addCategories()
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('addCategories');

        //Set variables for persistence
        $data['categories_name'] = "";
        $data['categories_desc'] = "";
        $data['categories_keywords'] = "";

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['categories_name'] = $this->input->post('categories_name');
            $data['categories_desc'] = $this->input->post('categories_desc');
            $data['categories_keywords'] = $this->input->post('categories_keywords');
            $data['user_type_at_creation_time'] = $_SESSION['user_type'];
            $data['created_by'] = $_SESSION['user_id'];

            //Validation start from here
            $this->form_validation->set_rules('categories_name', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('categories_desc', 'Category Description', 'trim|required');
            $this->form_validation->set_rules('categories_keywords', 'Category Keywords', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Blogs_categories_details_model->addCategories($data);

                if ($result) {
                    $_SESSION['success_msg'] = 'Blogs Categories has been added successfully and Blogs Categories ID: ' . $result;
                } else {
                    $_SESSION['failure_msg'] = 'Categories has not been added, please try again!';
                }
                redirect('admin/BlogsCategories', 'refresh');
            }
        }

        $this->load->view('admin/blogs_categories/add_categories', $data);
        $this->load->view('admin/dashboard/footer');
    }


    public function editCategories($categories_id)
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('editCategories');

        //Fetched all details of blogs catgeories to make persistence.
        $result['categories_details'] = $this->Blogs_categories_details_model->getCategoriesById($categories_id);

        //Set variables for persistence
        $data['categories_id'] = $categories_id;
        $data['categories_name'] = $result['categories_details'][0]['categories_name'];
        $data['categories_desc'] =  $result['categories_details'][0]['categories_description'];
        $data['categories_keywords'] =  $result['categories_details'][0]['categories_keywords'];

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['categories_name'] = $this->input->post('categories_name');
            $data['categories_desc'] = $this->input->post('categories_desc');
            $data['categories_keywords'] = $this->input->post('categories_keywords');
            $data['edited_by'] = $_SESSION['user_id'];

            //Validation start from here
            $this->form_validation->set_rules('categories_name', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('categories_desc', 'Category Description', 'trim|required');
            $this->form_validation->set_rules('categories_keywords', 'Category Keywords', 'trim|required');


            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Blogs_categories_details_model->editCategories($data, $categories_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Blogs Categories has been updated successfully!!';
                } else {
                    $_SESSION['failure_msg'] = 'Categories has not been updated, please try again!';
                }
                redirect('admin/BlogsCategories', 'refresh');
            }
        }

        $this->load->view('admin/blogs_categories/edit_categories', $data);
        $this->load->view('admin/dashboard/footer');
    }

    public function enabledDisabledCategories($categories_Id, $categories_status)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('enabledDisabledCategories');

        if (isset($categories_Id) && isset($categories_status)) {
            if ($categories_status == 'Active') {
                $categories_status = 'Inactive';
            } else {
                $categories_status = 'Active';
            }

            $result = $this->Blogs_categories_details_model->enabledDisabledCategories($categories_Id, $categories_status);

            if ($result) {
                $_SESSION['success_msg'] = 'Category ID: ' . $categories_Id . ' has been ' . $categories_status . ' successfully!';
            } else {
                $_SESSION['failure_msg'] = 'Category ID: ' . $categories_Id . ' has not been ' . $categories_status . ', please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Category ID or Categories status are not found, please try again!';
        }

        redirect('admin/BlogsCategories', 'refresh');
    }

    public function deleteCategories($categories_Id)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('deleteCategories');

        if (isset($categories_Id)) {

            $check_Relation_With_Blogs = $this->Blogs_categories_details_model->checkRelationWithBlogs($categories_Id);

            if (count($check_Relation_With_Blogs) == 0) {

                $result = $this->Blogs_categories_details_model->deleteCategories($categories_Id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Category ID: ' . $categories_Id . ' has been deleted successfully!';
                } else {
                    $_SESSION['failure_msg'] = 'Category ID: ' . $categories_Id . ' has not been deleted, please try again!';
                }
            } else {
                echo "<script>alert('Categories Already used in Blogs.... First, you need delete the blog (foriegn key) from the Blogs List Tab');</script>";
            }
        } else {
            $_SESSION['failure_msg'] = 'Category ID is not found, please try again!';
        }

        redirect('admin/BlogsCategories', 'refresh');
    }

    public function deleteBulkCategories()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('deleteBulkCategories');

        if (count($this->input->post()) > 1) {

            $all_delete = true;
            foreach ($this->input->post() as $categories_Id => $value) {

                if (is_numeric($categories_Id)) {

                    $check_result = $this->Blogs_categories_details_model->deleteCategories($categories_Id);

                    if (!$check_result) {
                        $all_delete = false;
                    }
                }
            }

            if ($all_delete) {
                $_SESSION['success_msg'] = 'All selected Categories has been deleted successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Categories has not been deleted, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Please select atleast one catgeories or please try again!';
        }

        redirect('admin/BlogsCategories', 'refresh');
    }

    public function bulkCategoriesStatusChanged()
    {
        //check logged in or not
        $this->checkUserSession();

        // Check User's Activties Permission 
        $this->checkUserAuthentication('bulkCategoriesStatusChanged');

        if (count($this->input->post()) > 1) {

            $all_status = true;
            foreach ($this->input->post() as $categories_Id => $value) {

                if (is_numeric($categories_Id)) {

                    $Categories_details =  $this->Blogs_categories_details_model->getCategoriesById($categories_Id);

                    if ($Categories_details[0]['categories_status'] == 'Active') {
                        $check_result = $this->Blogs_categories_details_model->enabledDisabledCategories($categories_Id, 'Inactive');
                    } else {
                        $check_result = $this->Blogs_categories_details_model->enabledDisabledCategories($categories_Id, 'Active');
                    }
                    if (!$check_result) {
                        $all_status = false;
                    }
                }
            }

            if ($all_status) {
                $_SESSION['success_msg'] = 'All selected Categories\'s Status has been changed successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected Categories\'s Status has not been changed, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Please select atleast one catgeories or please try again!';
        }

        redirect('admin/BlogsCategories', 'refresh');
    }

    public function exportCategories()
    {

        //Checked User logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('exportCategories');

        //Fetched all details of blogs categories to show in listed formated.
        $categories_details = $this->Blogs_categories_details_model->getAllCategories();

        // Make excel sheet 
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'H') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setCellValue('A1', 'S. No.');
        $sheet->setCellValue('B1', 'Categoies Name');
        $sheet->setCellValue('C1', 'Keywords');
        $sheet->setCellValue('D1', 'Created By');
        $sheet->setCellValue('E1', 'Last Edited By');
        $sheet->setCellValue('F1', 'Categories Status');
        $sheet->setCellValue('G1', 'Last Update Date');
        $sheet->setCellValue('H1', 'Added Date');

        $count = 2;
        foreach ($categories_details as $rows) {
            $created_by = $this->User_details_model->getUserByID($rows['created_by']);
            $edited_by = $this->User_details_model->getUserByID($rows['edited_by']);

            $sheet->setCellValue('A' . $count, $count - 1);
            $sheet->setCellValue('B' . $count,  $rows['categories_name']);
            $sheet->setCellValue('C' . $count, $rows['categories_keywords']);
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
            $sheet->setCellValue('F' . $count,  $rows['categories_status']);
            $sheet->setCellValue('G' . $count,  $rows['updated_date']);
            $sheet->setCellValue('H' . $count,  $rows['added_date']);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'blogs_categories_details_export.xlsx';
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
