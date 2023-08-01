<?php 

class AboutUs extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->view('frontend/header');
        $this->load->view('frontend/about_us');
        $this->load->view('frontend/footer');
    }

}


?>