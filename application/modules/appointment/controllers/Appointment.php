<?php
date_default_timezone_set('Asia/Kolkata');

class Appointment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Appointment_model');
        $this->db2 = $this->load->database('second', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer', $data);

    }

    public function fetchAppointment()
    {
        
        $data = $row = array();
        $rows = $this->Appointment_model->getRows_appointment($_POST);
        // print_r($rows);

        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            // $stop_date = date('Y-m-d', strtotime($users->admin_approved_date.' -6 day'));
            $first_date = date('Y-m-d');
            $last_date = date('Y-m-d', strtotime(' +7 day'));
            // print_r($users);
            if(($users->admin_approved_date >= $first_date) && ($users->admin_approved_date <= $last_date)){
                if($users->push_notification_state == 1){
                    // $btn= '<button atr="pushon" id="' . $users->userid . '" class="btn btn-primary notification">Notification</button>';
                    $btn=   '<i   atr="pushoff" id="' . $users->userid . '" style="margin-left: 10px;" class="fa fa-commenting notification" aria-hidden="true"></i>';

                } else {
                    // $btn= '<button atr="pushoff" id="' . $users->userid . '" class="btn btn-primary notification">Notification</button>';
                     $btn=   '<i   atr="pushoff" id="' . $users->userid . '" style="margin-left: 10px;" class="fa fa-commenting notification" aria-hidden="true"></i>';

                }
                // $btn = '<span class="label label-success">Confirmed</span>';


            } else {
                $btn = '';
            }


          
            if ($users->approved_status == 1) {
                // <span class="label label-success">Confirmed</span>
                if ($users->approved_status == 1) {
                    $approved_status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->approved_status == 2) {
                    $approved_status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->approved_status == 0) {
                    $approved_status = '<span class="label label-warning">New</span>';
                }

                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>',
                        $users->desired_clinic, date(" j F Y ", strtotime($users->admin_approved_date)).date(" g:i a  ", strtotime($users->StartTime)), $approved_status,
                        '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                

                <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>'.$btn,

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>', $users->desired_clinic, date(" j F Y ", strtotime($users->admin_approved_date)).date(" g:i a  ", strtotime($users->StartTime)),
                         $approved_status,
                        ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>'.$btn,

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Appointment_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Appointment_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function fetchAppointmentPend()
    {
        $data = $row = array();
        $rows = $this->Appointment_model->getRows_appointment($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            if ($users->approved_status == 0) {
                // <span class="label label-success">Confirmed</span>
                if ($users->approved_status == 1) {
                    $approved_status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->approved_status == 2) {
                    $approved_status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->approved_status == 0) {
                    $approved_status = '<span class="label label-warning">New</span>';
                }
                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>',
                        $users->desired_clinic, date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                        '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>
                <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>', $users->desired_clinic,date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                        ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>
                    <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Appointment_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Appointment_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function fetchAppointmentDec()
    {
        $data = $row = array();
        $rows = $this->Appointment_model->getRows_appointment($_POST);
        $i = $_POST['start'] + 1;
        foreach ($rows as $users) {
            if ($users->approved_status == 2) {
                // <span class="label label-success">Confirmed</span>
                if ($users->approved_status == 1) {
                    $approved_status = '<span class="label label-success">Confirmed</span>';
                } else if ($users->approved_status == 2) {
                    $approved_status = '<span class="label label-danger">Cancelled</span>';
                } else if ($users->approved_status == 0) {
                    $approved_status = '<span class="label label-warning">New</span>';
                }
                if (empty($users->Firstname)) {

                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->name . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->lastname . '</a>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>',
                        $users->desired_clinic, date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                        '<a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                remove_red_eye </span></a>'
                // <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                } else {
                    $data[] = array(
                        $i,
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Firstname . '</a>',
                        '<a  href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' ">' .  $users->Lastname . '</a>' .
                            '<span data-toggle="tooltip" title=" ' . $users->name . ' ' . $users->lastname . '"><i style="margin-left:10px;" class="fa fa-users " aria-hidden="true"></i> </span>',
                        $users->email, '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>', $users->desired_clinic,date(" j F Y g:i a", strtotime($users->appointment_date)), $approved_status,
                        ' <a href="' . $this->config->item("base_url") . 'appointment/details?id=' . $users->id . ' " style="color:#212529;"><span class="material-icons makepoint">
                    remove_red_eye </span></a>'
                    // <i title="Cancel Appointment" name="delete" id="' . $users->id . '" class="fa fa-times cancel_apppoinment makepoint" style="margin-left: 5px;" aria-hidden="true"></i>',

                    );
                    $i++;
                }
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Appointment_model->countAll_appointment($_POST),
            "recordsFiltered" => $this->Appointment_model->countFiltered_appointment($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function details()
    {
        // $this->Appointment_model->reminderPush(); die;
        $data['doctors'] = $this->Appointment_model->getDoctor($_GET['id']);
        $data['insurance'] = $this->Appointment_model->insurance($_GET['id']);
        $id = $_GET['id'];
        $data['note'] = $this->Appointment_model->appointmenNote($id);
        $data['appointment_time'] = $this->Appointment_model->appointmentTime($id);
        $data['appointment'] = $this->Appointment_model->appointmentDetails($id);
        $data['base_url'] = $this->config->item("base_url");
        $data['id'] = $_GET['id'];
        // print_r($data['appointment']); die;
        $this->load->view('header', $data);
        $this->load->view('view', $data);
        $this->load->view('footer', $data);
    }

    public function fixAppointment()
    {
        // die;
        // $start_date = date("Y-m-d", strtotime($_POST['date'])) . ' ' . $_POST['time'];
        $start_date = date("Y-m-d", strtotime($_POST['date']));
        $start_time=$_POST['time'];
        $end_time=$_POST['times'];        
        $doctor_id=$_POST['ProvNum'];
        $appoinmentdata= $this->Appointment_model->events($doctor_id,$start_date,$start_time,$end_time);
        if($appoinmentdata){
            echo false;
        }else{
            $id = $_POST['id'];
            // print_r( $_POST);die;
            $approveDate = date("Y-m-d", strtotime($_POST['date']));
            $approveStartTime=$_POST['time'];

            $approveStopTime=$_POST['times']; 

            $data1 = array('status' => 1, 'admin_approved_date' => $approveDate,'ProvNum'=>$_POST['ProvNum'],'StartTime'=>$approveStartTime,
            "StopTime"=>$approveStopTime);

            $data2=array('AptDateTime'=>$approveDate,'ProvNum'=>$_POST['ProvNum'],'PatNum'=>$_POST['PatNum'],'confirmed'=>0,'TimeLocked'=>0,
            'Op'=>0,'ProvHyg'=>0,'NextAptNum'=>0,'UnschedStatus'=>0,'Assistant'=>0,'ClinicNum'=>0,'DateTimeArrived'=>date('Y-m-d'),'DateTimeSeated'=>date('Y-m-d'),
            'DateTimeDismissed'=>date('Y-m-d'),'InsPlan1'=>0,'InsPlan2'=>0,'ProcsColored'=>'0','ColorOverride'=>0,'AppointmentTypeNum'=>0,'SecUserNumEntry'
            =>0,'Priority'=>0,'ProvBarText'=>'0','PatternSecondary'=>'0');

            $this->Appointment_model->approve($data1, $id,$data2);
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
            $this->Appointment_model->scheduleOld($schedule);
            echo true;
            
        }

    }
 

    public function cancelAppointment()
    {
        $id = $_POST['id'];
        $data = array('approved_status' => 2);
        $this->Appointment_model->cancelAppointment($data, $id);
        // $doctor_appoinment=array('status'=>0,'deleted_date' => date("Y-m-d H:i:s"));
        // $this->db->where('appointment_id',$id);
        // $this->db->where('start_event',$_POST['start_event']);
        // $this->db->update('sc_doctor_appointment',$doctor_appoinment)
    }

    public function sendnotification()
    {
        $id=$_POST['id'];
        $text=$_POST['text'];
        $this->Appointment_model->sendnotification($id,$text);
        echo true;


    }

    

  
}
