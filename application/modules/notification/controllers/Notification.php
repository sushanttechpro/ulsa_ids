<?php    
class Notification extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Notification_model');
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    public function index()
    {
        

        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);
        
    }
}