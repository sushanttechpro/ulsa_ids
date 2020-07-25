<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api extends MX_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, token");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
       
        $this->load->model(get_class($this) . '_model', 'model');
        $_POST = json_decode(file_get_contents('php://input'), true);
        parent::__construct();

    }

    
    public function signup()
    {
       $this->load->helper('custom_helper');
        $_POST['token'] = substr(md5(uniqid(mt_rand(), true)), 0, 15);

        if ($_POST['username'] == "") {
            $json = array(
                'status' => 'error',
                'txt' => 'Username cannot be empty',
            );
        } elseif (strlen($_POST['username']) >= 60) {
            $json = array(
                'st' => 'error',
                'txt' => 'username cannot be greater than 60',
            );
        } elseif ($_POST['email'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'email cannot be empty',

            );
        } elseif (!(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST['email']))) {
            $json = array(
                'st' => 'error',
                'txt' => 'Invalid email',

            );
        } elseif (strlen($_POST['password']) > 25) {
            $json = array(
                'st' => 'error',
                'txt' => 'password cannot be greater than 25 characters',
            );
        } elseif ($_POST['password'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'password cannot be empty',
            );
        } elseif ($_POST['telephone'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'telephone cannot be empty',
            );
        } elseif (strlen($_POST['telephone']) > 12 ) {
            $json = array(
                'st' => 'error',
                'txt' => 'telephone cannot be greater than 12 characters',
            );
        } elseif ($_POST['tax_number'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'tax number cannot be empty',
            );
        }else {
            $json = $this->model->signup($_POST);

            newRegistraionEmailSendToUser($_POST['email']);
            newRegistraionEmailSendToAdmin($_POST['email']);

        }
        print_r(json_encode($json));
    }

    public function login()
    {
        if ($_POST['email'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'email cannot be empty',
            );
        } elseif ($_POST['password'] == "") {
            $json = array(
                'st' => 'error',
                'txt' => 'password cannot be empty',
            );
        } else {

            $json = $this->model->login($_POST);
        }
        print_r(json_encode($json));

    }

}
