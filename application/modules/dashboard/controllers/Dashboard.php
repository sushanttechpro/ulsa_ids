<?php  
date_default_timezone_set('Asia/Kolkata');  
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Dashboard_model');
        $this->db2 = $this->load->database('second', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    public function index()
    {
         if($this->session->userdata('ulsa_id')){

           
            // $notification = $this->Dashboard_model->getNotificationAppt();
            // $session_data = array('notification' => $notification);
            // $this->session->set_userdata($session_data);

            // $message=$this->Dashboard_model->getNewMessages();
            // $session_data = array('message' => $message);
            // $this->session->set_userdata($session_data);


            

            $data['base_url'] = $this->config->item("base_url");
            $data['totalUsers'] = $this->Dashboard_model->countAll_users();
            $data['totalconfApp'] = $this->Dashboard_model->countAll_confappointments();
            $data['totalnewApp'] = $this->Dashboard_model->countAll_newappointments();

            $data['totalDoctors'] = $this->Dashboard_model->countAll_doctors();
            $data['totalEmergency'] = $this->Dashboard_model->countAll_emergency();

            // print_r($data); die;
            // $data['appointmentList'] = $this->Dashboard_model->getAppointmentList();
            // $data['notificationAppt'] = $this->Dashboard_model->getNotificationAppt();header me h iska funtion khol
            // $data['newMessages'] = $this->Dashboard_model->getNewMessages();
            // print_r($data['newMessages']); die;
            $this->load->view('header',$data);
            
            $this->load->view('index',$data);
            $this->load->view('footer',$data);
            // die;
        }else{
            redirect('auth');
        }
    }

    public function filter()
    {
        $id=$this->session->userdata('ulsa_id');
        $this->Dashboard_model->insertFilter($id);
           
    }

    public function fetchAppointment()
    {
        $data = $row = array();
        $rows = $this->Dashboard_model->getRows_appointment($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
          if ($users->approved_status == 1) {
            $approved_status = '<span class="label label-success">Confirmed</span>';
            if (empty($users->Firstname)) {
                
                $data[] = array($i,
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->name.'</a>', 
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->lastname.'</a>',
                $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                $users->type, $users->desired_clinic, date(" j F Y g:i a", strtotime($users->admin_approved_date)), $approved_status,
                '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                <i name="delete" title="Cancel Appointment" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                );
                $i++;

            } else {
                    $data[] = array($i,
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Firstname.'</a>', 
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Lastname.'</a>'. 
                    '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                    $users->email,' <a href="tel:'.$users->phone.' ">'.$users->phone.'</a>', $users->type, $users->desired_clinic, date(" j F Y g:i a", strtotime($users->admin_approved_date)), $approved_status,
                    ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i name="delete" title="Cancel Appointment" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                );
                $i++;
            }
          }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Dashboard_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Dashboard_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetchAppointmentPend()
    {
        $data = $row = array();
        $rows = $this->Dashboard_model->getRows_appointment($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
          if ($users->approved_status == 0) {
            $approved_status = '<span class="label label-warning">New</span>';
            if (empty($users->Firstname)) {
                
                $data[] = array($i,
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->name.'</a>', 
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->lastname.'</a>',
                $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                $users->type, $users->desired_clinic, date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                <i name="delete" title="Cancel Appointment" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                );
                $i++;

            } else {
                    $data[] = array($i,
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Firstname.'</a>', 
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Lastname.'</a>'. 
                    '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                    $users->email,' <a href="tel:'.$users->phone.' ">'.$users->phone.'</a>', 
                    $users->type, $users->desired_clinic, date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                    ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i name="delete" title="Cancel Appointment" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                );
                $i++;
            }
         }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Dashboard_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Dashboard_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetchAppointmentDec()
    {
        $data = $row = array();
        $rows = $this->Dashboard_model->getRows_appointment($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
         if ($users->approved_status == 2) {
            $approved_status = '<span class="label label-danger">Cancelled</span>';
            if (empty($users->Firstname)) {
                
                $data[] = array($i,
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->name.'</a>', 
                '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->lastname.'</a>',
                $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                $users->type, $users->desired_clinic, date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>'
                );
                $i++;

            } else {
                    $data[] = array($i,
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Firstname.'</a>', 
                    '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">'.  $users->Lastname.'</a>'. 
                    '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                    $users->email,' <a href="tel:'.$users->phone.' ">'.$users->phone.'</a>', $users->type, $users->desired_clinic,date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                    ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>'
                );
                $i++;
            }
         }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Dashboard_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Dashboard_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function profile()
    {  
        $data['status_date']= $this->Dashboard_model->getStatusdate();     
        $data['base_url'] = $this->config->item("base_url");
        $data['profile'] = $this->Dashboard_model->getProfile();
        // print_r($data); die;
        $this->load->view('header',$data);
        $this->load->view('adminprofile',$data);
        $this->load->view('footer',$data);
    }

    public function updateAdmin()
    {
        $id=$this->session->userdata('ulsa_id');
        
        $data=array('name'=>$_POST['name'],'lastname'=>$_POST['lastname'],'email'=>$_POST['email'],'phone'=>$_POST['phone'],'created_date'=>date("Y-m-d H:i:s"),'updated_date'=>date("Y-m-d H:i:s")
        );

        $this->Dashboard_model->updateAdmin($data,$id);

        echo true;

    }

    public function dashboardStatsData(){
        $data['totalUsers'] = $this->Dashboard_model->countAll_users();
        $data['totalAppointments'] = $this->Dashboard_model->countAll_appointments();
        // print_r($data);
    }
    public function checkPassword()
    {
	$password=base64_encode($_POST['oldpassword']);
    $id=$this->session->userdata('ulsa_id');
    $pass=$this->Dashboard_model->checkPassword($id);
        if($pass->password==$password){
            // $this->Welcome_model->changePassword($id,$newpass);
            echo true;


        }else{
            echo false;
        }
    }

    public function updatePassword()
    {
        $id=$this->session->userdata('ulsa_id');
        $data=array('password'=>base64_encode($_POST['password']),'updated_date'=>date("Y-m-d H:i:s"));
        $this->Dashboard_model->updatePassword($data,$id);

    }

    // public function test()
    // {
    //     $datetime = date("Y-m-d H:i:s");
    //     echo  $datetime; 
    //     echo "gg";

    // }
    


}






?>