<?php  
date_default_timezone_set('Asia/Kolkata');

class Chat extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Chat_model');
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

    public function fetchUser()
    {
        $data = $row = array();
        $rows = $this->Chat_model->getRows_users($_POST);
        foreach ($rows as $users) {
            $data[] = array($users->name,$users->lastname,
           $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',$users->desired_clinic,
           ' <a href="' . $this->config->item("base_url") . 'chat/chats?id=' . $users->id . ' " class="btn btn-success ">View Message</a>'
    
         );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Chat_model->countAll_users($_POST),
            "recordsFiltered" => $this->Chat_model->countFiltered_users($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function chats()
    {
        $data['user_id']=$_GET['id'];
        $data['countmessage']=$this->Chat_model->countAll_messaage($_GET['id']);
        $data['message']=$this->Chat_model->message($_GET['id']);
        $data['base_url'] = $this->config->item("base_url");

        $this->load->view('header',$data);
        $this->load->view('chat',$data);
        $this->load->view('footer',$data);

    }

    public function refreshChat(){
        // print_r($_SESSION); die;
        $data['user_id'] = $_POST['id'];
        $data['countmessage']=$this->Chat_model->countAll_messaage($_POST['id']);
        $data['message']=$this->Chat_model->messageRefresh($_POST['id'])[0];
        echo json_encode($data);
        // print_r($data['countmessage']); die;
    }

    public function send_msg()
    {

        $message = array(
            'message' => $_POST['message'],
            'from_user_id' => $this->session->userdata('ulsa_id'),
            'user_id' => $_POST['user_id'],
            'usertype'=>$this->session->userdata('usertype'),
            'created_date' => date("Y-m-d H:i:s")
        );

        echo $this->db->insert('sc_message_table', $message);
    }
}