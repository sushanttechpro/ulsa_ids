<?php
date_default_timezone_set('Asia/Kolkata');

class Emergency extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Emergency_model');
        $this->db2 = $this->load->database('second', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        // print_r($_GET["ids"]);
        // if(isset($_GET["q"])){
        //     $this->session->set_userdata("emer",$_GET["q"]);
        // }
        // $data['clinic'] = $this->Doctors_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer', $data);
    }

    public function fetchEmergency()
    {
        // print_r($_POST);die;
        
        $data = $row = array();
        $rows = $this->Emergency_model->getRows_emergency($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            if ($users->status == 1) {
                // <span class="label label-success">Confirmed</span>
                if ($users->status == 1) {
                    $status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->status == 2) {
                    $status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->status == 0) {
                    $status = '<span class="label label-warning">New</span>';
                }
                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                          $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                 $users->desired_clinic, date(" j F Y  ", strtotime($users->admin_approved_date)).date(" g:i a  ", strtotime($users->StartTime)), $status,
                        '<a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                            $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                             $users->desired_clinic, date(" j F Y ", strtotime($users->admin_approved_date)).date(" g:i a  ", strtotime($users->StartTime)), $status,
                        ' <a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Emergency_model->countAll_emergency($_POST),
            "recordsFiltered" => $this->Emergency_model->countFiltered_emergency($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function fetchEmergencyPend()
    {
        $data = $row = array();
        $rows = $this->Emergency_model->getRows_emergency($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            if ($users->status == 0) {
                // <span class="label label-success">Confirmed</span>
                if ($users->status == 1) {
                    $status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->status == 2) {
                    $status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->status == 0) {
                    $status = '<span class="label label-warning">New</span>';
                }
                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                        $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                        $users->desired_clinic, date(" j F Y g:i a", strtotime($users->created_date)), $status,
                        '<a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                            $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                            $users->desired_clinic,date(" j F Y g:i a", strtotime($users->created_date)), $status,
                        ' <a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Emergency_model->countAll_emergency($_POST),
            "recordsFiltered" => $this->Emergency_model->countFiltered_emergency($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function fetchEmergencyDec()
    {
        $data = $row = array();
        $rows = $this->Emergency_model->getRows_emergency($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            if ($users->status == 2) {
                // <span class="label label-success">Confirmed</span>
                if ($users->status == 1) {
                    $status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->status == 2) {
                    $status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->status == 0) {
                    $status = '<span class="label label-warning">New</span>';
                }
                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                        $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                 $users->desired_clinic, date(" j F Y g:i a", strtotime($users->created_date)), $status,
                        '<a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>'
                // <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                            $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',
                            $users->desired_clinic,date(" j F Y g:i a", strtotime($users->created_date)), $status,
                        ' <a href="' . $this->config->item("base_url") . 'emergency/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>'
                    // <i title="Cancel Emergency" name="delete" id="' . $users->id . '" class="fa fa-times cancel_emergency makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Emergency_model->countAll_emergency($_POST),
            "recordsFiltered" => $this->Emergency_model->countFiltered_emergency($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function details()
    {
        $data['doctors'] = $this->Emergency_model->getDoctor($_GET['id']);
        $data['emergency'] = $this->Emergency_model->emergencyDetails($_GET['id']);
        $data['insurance'] = $this->Emergency_model->insurance($_GET['id']);
        $data['teethNames'] = $this->Emergency_model->getTeethName($_GET['id']);
        $data['emergency_service'] = $this->Emergency_model->getEmergencyService($_GET['id']);


        $data['id'] = $_GET['id'];
        $data['base_url'] = $this->config->item("base_url");
        // print_r($data['appointment']); die;
        $this->load->view('header', $data);
        $this->load->view('view', $data);
        $this->load->view('footer', $data);
    }

    
    public function fixEmergency()
    {
        // die;
        // $start_date = date("Y-m-d", strtotime($_POST['date'])) . ' ' . $_POST['time'];
        $start_date = date("Y-m-d", strtotime($_POST['date']));
        $start_time=$_POST['time'];
        $end_time=$_POST['times'];        
        $doctor_id=$_POST['ProvNum'];
        $appoinmentdata= $this->Emergency_model->events($doctor_id,$start_date,$start_time,$end_time);
        if($appoinmentdata){
            echo false;
        }else{
            $id = $_POST['id'];
            // print_r( $_POST);die;
            $approveDate = date("Y-m-d", strtotime($_POST['date']));
            $approveStartTime=$_POST['time'];

            $approveStopTime=$_POST['times']; 

            $data1 = array('status' => 1, 'admin_approved_date' => $approveDate,'ProvNum'=>$_POST['ProvNum'],'StartTime'=>$approveStartTime,
            "StopTime"=>$approveStopTime);///For our database

            $data2=array('AptDateTime'=>$approveDate,'ProvNum'=>$_POST['ProvNum'],'PatNum'=>$_POST['PatNum'],'confirmed'=>0,'TimeLocked'=>0,
            'Op'=>0,'ProvHyg'=>0,'NextAptNum'=>0,'UnschedStatus'=>0,'Assistant'=>0,'ClinicNum'=>0,'DateTimeArrived'=>date('Y-m-d'),'DateTimeSeated'=>date('Y-m-d'),
            'DateTimeDismissed'=>date('Y-m-d'),'InsPlan1'=>0,'InsPlan2'=>0,'ProcsColored'=>'0','ColorOverride'=>0,'AppointmentTypeNum'=>0,'SecUserNumEntry'
            =>0,'Priority'=>0,'ProvBarText'=>'0','PatternSecondary'=>'0');

            $this->Emergency_model->approve($data1, $id,$data2);
            // $this->db->where('status',1);
            // $this->db->where('appointment_id',$id);
            // $q= $this->db->get('sc_doctor_appointment')->result();
            // if($q){
            //     $doctor_appoinment=array('title'=>'appointment','doctor_id'=> $_POST['doctor_id'],'start_event'=>$start_date,
            //     'updated_date' => date("Y-m-d H:i:s"));
            //     $this->db->where('appointment_id',$id);
            //     $this->db->where('status',1);
            //     $this->db->update('sc_doctor_appointment',$doctor_appoinment);
            //     // echo true;

            // }else{
            //     $doctor_appoinment=array('title'=>'appointment','doctor_id'=> $_POST['doctor_id'],'appointment_id'=>$id,'start_event'=>$start_date,
            //     'clinic_id'=>$_POST['clinic_id'],'created_date'=>date("Y-m-d H:i:s"),);
            //     $this->db->where('status',1);
            //     $this->db->insert('sc_doctor_appointment',$doctor_appoinment);
            //     // echo true;

            // }

            $schedule=array('SchedDate'=> date("Y-m-d", strtotime($_POST['date'])),'StartTime'=>$_POST['time'],'StopTime'=>$_POST['times'],
            'ProvNum'=>$_POST['ProvNum'],'BlockoutType'=>0,'EmployeeNum'=>0,'ClinicNum'=>0);
            $this->Emergency_model->scheduleOld($schedule);
            echo true;
            
        }
    }

       

        public function cancelEmergency()
        {
            $id = $_POST['id'];
            $data = array('status' => 2);
            $this->Emergency_model->cancelEmergency($data, $id);
          
    
        }

        
}