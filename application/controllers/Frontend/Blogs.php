<?php 

class Blogs extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function blogDetails(){
        $this->load->view('frontend/header');
        $this->load->view('frontend/blogs/blog_details');
        $this->load->view('frontend/footer');
    }

    public function postBlogs(){
        $this->load->view('frontend/header');
        $this->load->view('frontend/blogs/post_blogs');
        $this->load->view('frontend/footer');
    }

}


?>