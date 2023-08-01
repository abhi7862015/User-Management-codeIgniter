<?php
require_once(dirname(__FILE__) . "/dashboard.php");

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Blogs extends dashboard
{

    public function index()
    {
        //Default page
        $this->blogList();
    }

    public function blogList()
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('blogList');

        //Fetched all details of blogs to show in listed formated.
        $result['blogs_details'] = $this->Blogs_details_model->getAllBlogs();

        //Fetched the user details who created this user.
        $result['created_by_user_details'] = array();
        foreach ($result['blogs_details']  as $rows) {
            $result['created_by_user_details'][$rows['blog_id']] = $this->Blogs_details_model->getUserDetailsById($rows['created_by']);
        }

        //Fetched the user details users who last updated this user.
        $result['edited_by_user_details'] = array();
        foreach ($result['blogs_details']  as $rows) {
            if ($rows['edited_by']) {
                $result['edited_by_user_details'][$rows['blog_id']] = $this->Blogs_details_model->getUserDetailsById($rows['edited_by']);
            }
        }

        //Fetched all categories details to show in categories name dropdown.
        $result['blogs_categories_details'] = array();
        foreach ($result['blogs_details']  as $rows) {
            if ($rows['blogs_categories_id']) {
                $result['blogs_categories_details'][$rows['blog_id']] = $this->Blogs_details_model->getBlogCategoriesDetailsById($rows['blogs_categories_id']);
            }
        }

        $this->load->view('admin/blogs/blogs_list', $result);
        $this->load->view('admin/dashboard/footer');
    }

    public function addBlog()
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('addBlog');

        //Fetched all categories details to show in listed formated.
        $data['categories_details'] = $this->Blogs_categories_details_model->getAllCategories();

        //Set variables 
        $data['blog_title'] = "";
        $data['blogs_categories_id'] = "";
        $data['short_desc'] = "";
        $data['blog_content'] = "";
        $data['blog_keywords'] = "";

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['blog_title'] = $this->input->post('blog_title');
            $data['blogs_categories_id'] = $this->input->post('blogs_categories');
            $data['short_desc'] = $this->input->post('short_desc');
            $data['blog_content'] = $this->input->post('blog_content');
            $data['blog_keywords'] = $this->input->post('blog_keywords');
            $data['user_type_at_creation_time'] = $_SESSION['user_type'];
            $data['created_by'] = $_SESSION['user_id'];

            //Validation start from here
            $this->form_validation->set_rules('blog_title', 'Blog Title', 'trim|required');
            $this->form_validation->set_rules('blogs_categories', 'Blogs Categories', 'trim|required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'trim|required');
            $this->form_validation->set_rules('blog_content', 'Blog Content', 'trim|required');
            $this->form_validation->set_rules('blog_keywords', 'Blog Keyword', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Blogs_details_model->addBlog($data);

                if ($result) {
                    $_SESSION['success_msg'] = 'Blog has been added successfully and the Blog ID is : ' . $result;
                } else {
                    $_SESSION['failure_msg'] = 'Blog has not been added, please try again!';
                }

                redirect('admin/blogs', 'refresh');
            }
        }

        $this->load->view('admin/blogs/add_blog', $data);
        $this->load->view('admin/dashboard/footer');
    }

    public function editBlog($blog_id)
    {
        //Added Header
        $this->header();

        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('editBlog');

        //Fetched all categories details to show in listed formated.
        $data['categories_details'] = $this->Blogs_categories_details_model->getAllCategories();

        //Fetched all details of blogs to make persistence.
        $result['blogs_details'] = $this->Blogs_details_model->getBlogById($blog_id);

        //Set variables for persistence
        $data['blog_id'] = $blog_id;
        $data['blog_title'] = $result['blogs_details'][0]['blog_title'];
        $data['blogs_categories_id'] = $result['blogs_details'][0]['blogs_categories_id'];
        $data['short_desc'] = $result['blogs_details'][0]['blog_short_description'];
        $data['blog_content'] = $result['blogs_details'][0]['blog_content'];
        $data['blog_keywords'] = $result['blogs_details'][0]['blog_keywords'];

        //After submission of registration form
        if ($this->input->method(true) &&  $this->input->post('submit')) {

            //Set variables for persistence
            $data['blog_title'] = $this->input->post('blog_title');
            $data['blogs_categories_id'] = $this->input->post('blogs_categories');
            $data['short_desc'] = $this->input->post('short_desc');
            $data['blog_content'] = $this->input->post('blog_content');
            $data['blog_keywords'] = $this->input->post('blog_keywords');
            $data['user_type_at_creation_time'] = $_SESSION['user_type'];
            $data['edited_by'] = $_SESSION['user_id'];

            // //Validation start from here
            $this->form_validation->set_rules('blog_title', 'Blog Title', 'trim|required');
            $this->form_validation->set_rules('blogs_categories', 'Blogs Categories', 'trim|required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'trim|required');
            $this->form_validation->set_rules('blog_content', 'Blog Content', 'trim|required');
            $this->form_validation->set_rules('blog_keywords', 'Blog Keyword', 'trim|required');

            //Insert data if found no error in form 
            if ($this->form_validation->run() == true) {

                $result = $this->Blogs_details_model->editBlog($data, $blog_id);

                if ($result) {
                    $_SESSION['success_msg'] = 'Blog ID ' . $blog_id . ' has been edited successfully!';
                } else {
                    $_SESSION['failure_msg'] = 'Blog ID ' . $blog_id . ' has not been edited, please try again!';
                }
                redirect('admin/blogs', 'refresh');
            }
        }

        $this->load->view('admin/blogs/edit_blog', $data);
        $this->load->view('admin/dashboard/footer');
    }


    public function enabledDisabledBlog($blog_Id, $blog_status)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('enabledDisabledBlog');

        if (isset($blog_Id) && isset($blog_status)) {
            if ($blog_status == 'Active') {
                $blog_status = 'Inactive';
            } else {
                $blog_status = 'Active';
            }

            $result = $this->Blogs_details_model->enabledDisabledBlog($blog_Id, $blog_status);

            if ($result) {
                $_SESSION['success_msg'] = 'Blog ID: ' . $blog_Id . ' has been ' . $blog_status . ' successfully!';
            } else {
                $_SESSION['failure_msg'] = 'Blog ID: ' . $blog_Id . ' has not been ' . $blog_status . ', please try again!';
            }
        }

        redirect('admin/blogs', 'refresh');
    }

    public function deleteBlog($blog_id)
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check User authentication";
        $this->checkUserAuthentication('deleteBlog');

        if (isset($blog_id)) {

            $result = $this->Blogs_details_model->deleteBlog($blog_id);

            if ($result) {
                $_SESSION['success_msg'] = 'Blog ID: ' . $blog_id . ' has been deleted successfully!';
            } else {
                $_SESSION['failure_msg'] = 'Blog ID: ' . $blog_id . ' has not been deleted, please try again!';
            }
        }

        redirect('admin/blogs', 'refresh');
    }

    public function deleteBulkBlogs()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('deleteBulkBlogs');

        if (count($this->input->post()) > 1) {

            $all_delete = true;
            foreach ($this->input->post() as $blog_id => $value) {

                if (is_numeric($blog_id)) {

                    $check_result = $this->Blogs_details_model->deleteBlog($blog_id);

                    if (!$check_result) {
                        $all_delete = false;
                    }
                }
            }

            if ($all_delete) {
                $_SESSION['success_msg'] = 'All selected blogs has been deleted successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected blogs has not been deleted, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Please select atleast one blog or please try again!';
        }

        redirect('admin/blogs', 'refresh');
    }

    public function bulkBlogsStatusChanged()
    {
        //Check logged in or not
        $this->checkUserSession();

        //Check Admin authentication
        $this->checkUserAuthentication('bulkBlogsStatusChanged');

        if (count($this->input->post()) > 1) {

            $all_status = true;
            foreach ($this->input->post() as $blog_id => $value) {
                if (is_numeric($blog_id)) {

                    $blog_details =  $this->Blogs_details_model->getBlogById($blog_id);

                    if ($blog_details[0]['blog_status'] == 'Active') {
                        $check_result = $this->Blogs_details_model->enabledDisabledBlog($blog_id, 'Inactive');
                    } else {
                        $check_result = $this->Blogs_details_model->enabledDisabledBlog($blog_id, 'Active');
                    }
                    if (!$check_result) {
                        $all_status = false;
                    }
                }
            }

            if ($all_status) {
                $_SESSION['success_msg'] = 'All selected blog\'s Status has been changed successfully!';
            } else {
                $_SESSION['failure_msg'] = 'All selected blog\'s Status has not been changed, please try again!';
            }
        } else {
            $_SESSION['failure_msg'] = 'Please select atleast one blog or please try again!';
        }

        redirect('admin/blogs', 'refresh');
    }

    public function exportBlogs()
    {

        //Checked User logged in or not
        $this->checkUserSession();

        //Check User's Activties Permission 
        $this->checkUserAuthentication('exportBlogs');

        //Fetched all details of blogs to show in listed formated.
        $blogs_details = $this->Blogs_details_model->getAllBlogs();

        // Make excel sheet 
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'H') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setCellValue('A1', 'S. No.');
        $sheet->setCellValue('B1', 'Blog Title');
        $sheet->setCellValue('C1', 'Categoies Name');
        $sheet->setCellValue('D1', 'Created By');
        $sheet->setCellValue('E1', 'Last Edited By');
        $sheet->setCellValue('F1', 'User Status');
        $sheet->setCellValue('G1', 'Last Update Date');
        $sheet->setCellValue('H1', 'Added Date');

        $count = 2;
        foreach ($blogs_details as $rows) {
            $categories_name =   $this->Blogs_details_model->getBlogCategoriesDetailsById($rows['blogs_categories_id']);
            $created_by = $this->User_details_model->getUserByID($rows['created_by']);
            $edited_by = $this->User_details_model->getUserByID($rows['edited_by']);

            $sheet->setCellValue('A' . $count, $count - 1);
            $sheet->setCellValue('B' . $count,  $rows['blog_title']);
            $sheet->setCellValue('C' . $count, $categories_name[0]['categories_name']);
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
            $sheet->setCellValue('F' . $count,  $rows['blog_status']);
            $sheet->setCellValue('G' . $count,  $rows['updated_date']);
            $sheet->setCellValue('H' . $count,  $rows['added_date']);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'blogs_details_export.xlsx';
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
