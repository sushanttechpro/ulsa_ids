<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');


class Users extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form', 'url','date');
        $this->db2 = $this->load->database('second', TRUE);
        $this->load->model('Users_model');
    }

    public function index()
    {
        $this->Users_model->addpatient();
        $data['clinic'] = $this->Users_model->get_desired_clinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer', $data);
    }

    public function fetchUsers()
    {
        $data = $row = array();
        $rows = $this->Users_model->getRows_users($_POST);
        $i = $_POST['start']+1;
        foreach ($rows as $users) {
            $data[] = array(
                $i,
                '<a href="' . $this->config->item("base_url") . 'users/view_User?id=' . $users->id . ' ">'.$users->name.'</a>',
                '<a href="' . $this->config->item("base_url") . 'users/view_User?id=' . $users->id . ' ">'.$users->lastname.'</a>',
                $users->email,
                '<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>', 
                $users->clinic,
                // ' <a href="' . $this->config->item("base_url") . 'users/edit_User?id=' . $users->id . ' " class="btn btn-primary edit"> <i class="fa fa-pencil"></i>Edit</a>',
        //         $users->status == "0" ? '<label class="switch">
        //     <input type="checkbox" id="userstatus" data-user_toggle="' . $users->id . '"  >
        //     <span class="slider round"></span>
        //   </label>' : '<label class="switch">
        //   <input type="checkbox" id="userstatus" data-user_toggle="' . $users->id . '" checked >
        //   <span class="slider round"></span>
        // </label>',

                ' <a href="' . $this->config->item("base_url") . 'users/view_User?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
         remove_red_eye </span></a> <i name="delete" id="' . $users->id . '" class="fa fa-trash-o deleteuser makepoint" style="margin-left: 20px;" aria-hidden="true"></i>'




            );
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Users_model->countAll_users($_POST),
            "recordsFiltered" => $this->Users_model->countFiltered_users($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    

    public function checkEmail()
    {
        $email=$_POST['email'];
		$data=$this->Users_model->checkEmail($email);
		if ($data==true){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function checkMobile()
    {
        $mobile=$_POST['phone'];
        $this->Users_model->checkMobile($mobile);
    }

    public function insertUser()
    {
        $Token = substr(md5(uniqid(mt_rand(), true)), 0, 15);

        $data = array(
            'name' => $_POST['name'],'lastname'=>$_POST['lastname'], 'email' => $_POST['email'],'phone'=>$_POST['phone'], 'usertype' => 3, 'token' => $Token,
            'push_notification_state' => (isset($_POST['push_notification_state']) == "on") ? 1 : 0, 'special_notification' => (isset($_POST['special_notification']) == "on") ? 1 : 0,
            'desired_clinic' => $_POST['desired_clinic'], 'password' => base64_encode($_POST['password']),'created_date'=>date("Y-m-d H:i:s")
        );
       $q= $this->Users_model->insertUser($data);

    }
    public function updateUser()
    {
        $id=$_POST['id'];
        $data = array(
            'name' => $_POST['name'],'lastname'=>$_POST['lastname'], 'email' => $_POST['email'],'phone'=>$_POST['phone'], 'updated_date'=>date("Y-m-d H:i:s"),
            'push_notification_state' => (isset($_POST['push_notification_state']) == "on") ? 1 : 0, 'special_notification' => (isset($_POST['special_notification']) == "on") ? 1 : 0,
            'gps_status' => (isset($_POST['gps_status']) == "on") ? 1 : 0,'comment'=>$_POST['comment'],
         
        );
        $this->Users_model->updateUser($data,$id);
        $this->Users_model->updateInsurance($id);


    }

    public function deleteUser()
    {
       

        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Users_model->deleteUser($id,$status);
        
    }

    public function change_user_status()
    {
        if ($_POST['prop'] == "false") {
            $this->db->where('id', $_POST['id']);
            $this->db->update('users', array('status' => 0));
        } else {
            $this->db->where('id', $_POST['id']);
            $this->db->update('users', array('status' => 1));
        }
    }

    public function view_user()
    {
        // $id=$_GET['id'];
        $data['profile']=$this->Users_model->profile($_GET['id']);
        $data['insurance']=$this->Users_model->insurance($_GET['id']);
        $data['base_url'] = $this->config->item("base_url");
        $data['id'] = $_GET['id'];
        $this->load->view('header', $data);
        $this->load->view('view', $data);
        $this->load->view('footer', $data);
    }


    public function fetch_member()
    {

        $data = $row = array();
        $rows = $this->Users_model->getRows_member($_POST);
        // $i=1;
        foreach ($rows as $all_campaign) {
            $data[] = array(
                $all_campaign->Firstname, $all_campaign->Lastname,
                $all_campaign->phone_number,

                '<i name="update" id="' . $all_campaign->id . '" class="fa fa-pencil edit_member makepoint" aria-hidden="true"></i> <i name="delete" id="' . $all_campaign->id . '" class="fa fa-trash-o delete_member makepoint" style="margin-left: 20px;" aria-hidden="true"></i>',

            );
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Users_model->countAll_member($_POST),
            "recordsFiltered" => $this->Users_model->countFiltered_member($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }



    function getName($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function insertMember()
    {
        $member_uniqId = $this->getName(8);
        $data = array('Firstname' => $_POST['Firstname'], 'Lastname' => $_POST['Lastname'], 'phone_number' => $_POST['phone_number'],
         'member_uniqid' => $member_uniqId, 'user_id' => $_POST['id'],'created_date'=>date("Y-m-d H:i:s"));

        $this->Users_model->insertMember($data);
    }
    public function checkmobile_member()
    {
        $mobile=$_POST['phone_number'];
        $this->Users_model->checkmobile_member($mobile);

    }

    public function deleteMember()
    {
      
        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Users_model->deleteMember($id,$status);
    }

    public function editMember()
    {
        $output = array();
        $data = $this->Users_model->editMember($_POST["id"]);
        foreach ($data as $row) {
            $output['id'] = $row->id;
            $output['Firstname'] = $row->Firstname;
            $output['Lastname'] = $row->Lastname;
            $output['phone_number'] = $row->phone_number;
            // $output['mobile'] = $row->mobile;
        }
        echo json_encode($output);
    }

    public function updateMember()
    {
        $id = $_POST['id'];
        $data = array('Firstname' => $_POST['Firstname'], 'Lastname' => $_POST['Lastname'], 'phone_number' => $_POST['phone_number'],'updated_date'=>date("Y-m-d H:i:s"), );
        $this->Users_model->updateMember($id, $data);
    
    }

      ///Adding Patient from oldplatform///
      public function export()
      {
          $this->Users_model->export();
      }

  
}
