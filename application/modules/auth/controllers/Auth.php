<?php
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper('url');
        $this->load->library('session');
        // $this->load->helper('cookie');

    }

    public function index()
    {
        if (!$this->session->userdata('ulsa_id')) {
            $data['base_url'] = $this->config->item("base_url");
            $this->load->view('login', $data);
        } else {
            redirect('dashboard');
        }

    }

    public function check_email_login()
    {
        // print_r($_POST);die;
        $email = $_POST['email_address'];
        // $pass = $_POST['password'];
        $password = base64_encode($_POST['password']);
        // if ($_POST['remember'] == "true") {
        //     set_cookie('user', $email, 60);
        //     set_cookie('pass', $pass, 60);
        // }
        $select_user = $this->Auth_model->select_email_login($email, $password);
    }
    public function check_user_id()
    {
        $email = $_POST['email_address'];
        $select_user = $this->Auth_model->check_user_id($email);
    }

    public function forgot()
    {
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('forgot', $data);

    }
    public function not_authorised()
    {
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('not_authorised', $data);
        $this->load->view('footer', $data);
    }

    public function reset_password()
    {
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('reset_password', $data);
    }

    public function reset()
    {
        $this->load->helper('url');
        $_GET['us'] = base64_decode($_GET['us']);
        $data['codeExist'] = $this->db->get_where("sc_reset_password", array("user_id" => $_GET['us'], "code" => $_GET['code']))->num_rows();
        $data['base_url'] = $this->config->item("base_url");
        if (isset($_GET['ptype'])) {
            $data['ptype'] = $_GET['ptype'];
        }
        $this->load->view('reset', $data);
    }

    public function reset_pass_link()
    {
        echo $this->Auth_model->reset_pass_link($_POST['email']);
        // print_r($result);die;
    }

    public function reset_pass()
    {
        unset($_POST['confPassword']);
        echo $this->Auth_model->reset_pass();
        // print_r($result);die;

    }

    public function pass_change_msg()
    {
        $this->load->view('changepasswordmessage');
    }
    public function logout()
    {
        $session_data = array(
            'ulsa_id',
            'name',
            'email',
            'usertype',

        );
        $this->session->unset_userdata($session_data);
        $this->session->sess_destroy();
        redirect('auth');

    }

}
