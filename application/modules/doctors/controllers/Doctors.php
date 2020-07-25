<?php
date_default_timezone_set('Asia/Kolkata');

class Doctors extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Doctors_model');
        $this->db2 = $this->load->database('second', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        
        $data['clinic'] = $this->Doctors_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer', $data);
    }

    public function fetchDoctors()
    {
        $data = $row = array();
        $rows = $this->Doctors_model->getRows_doctor($_POST);
        // print_r($rows);die;
        foreach ($rows as $users) {

            // if ($users->SchedDate == date('Y-m-d')) {
            //     $avilable_status = '<span class="label label-danger">Available</span>';
            // } else {
            //     $avilable_status = '<span class="label label-success">Not Available</span>';
            // }



            $data[] = array(
                ' <img src="' . $users->image . ' "  style="width:50px;height:50px;vertical-align:middle;border-radius:50%; "> ',
                '<a  href="' . $this->config->item("base_url") . 'doctors/appointment?id=' . $users->ProvNum . ' ">' .  $users->LName . '</a>',$users->FName,
                '<a href="tel:' . $users->phone . ' ">' . $users->phone . '</a>', $users->doctor_description, $users->desired_clinic,

        //         $users->doctstatus == "0" ? '<label class="switch">
        //     <input type="checkbox" id="doctorstatus" data-user_toggle="' . $users->doctid . '"  >
        //     <span class="slider round"></span>
        //   </label>' : '<label class="switch">
        //   <input type="checkbox" id="doctorstatus" data-user_toggle="' . $users->doctid . '" checked >
        //   <span class="slider round"></span>
        // </label>',
                '<i name="update" id="' . $users->id . '" class="fa fa-pencil makepoint edit_doctor" aria-hidden="true"></i> ',
                // <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_doctor makepoint" style="margin-left: 20px;" aria-hidden="true"></i>


            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Doctors_model->countAll_doctor($_POST),
            "recordsFiltered" => $this->Doctors_model->countFiltered_doctor($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function checkMobile()
    {
        $mobile = $_POST['phone'];
        $this->Doctors_model->checkMobile($mobile);
    }

    // public function addDoctor()
    // {

    //     $config['upload_path'] = './assets/images/doctor/';
    //     $config['allowed_types'] = 'jpg|jpeg|png|gif';
    //     $this->load->library('upload', $config);
    //     if (!$this->upload->do_upload('image')) {
    //         echo $this->upload->display_errors();
    //     } else {
    //         $data = $this->upload->data();

    //         $picture = array(
    //             'image' => 'assets/images/doctor/' . $data['file_name'], 'name' => $_POST['name'], 'phone' => $_POST['phone'],
    //             'doctor_description' => $_POST['Ck_editor_value'],'created_date'=>date("Y-m-d H:i:s")
    //         );
    //         $this->Doctors_model->addDoctor($picture);
    //     }
    //     echo true;
    // }

    public function editDoctor()
    {
        $output = array();
        $data = $this->Doctors_model->editDoctor($_POST["id"]);
        foreach ($data as $row) {
            $output['id'] = $row->id;
            $output['LName'] = $row->LName;
            $output['FName'] = $row->FName;

            $output['phone'] = $row->phone;

            $output['clinic_id'] = $row->clinic_id;

            $output['doctor_description'] = $row->doctor_description;
        }
        echo json_encode($output);
    }

    public function updateDoctor()
    {

        if (($_FILES['image']['name'] !== "")) {
            $id = $_POST['id'];
            $this->db->where('id', $id);
            $q = $this->db->get('sc_doctor')->result()[0];
            $p = $q->{'image'};
            unlink(FCPATH . '/' . $p);

            $config['upload_path'] = './assets/images/doctor/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->load->library('upload', $config);
            $this->upload->do_upload('image');
            $data = $this->upload->data();

            $picture = array(
                'image' => 'assets/images/doctor/' . $_FILES['image']['name'], 'LName' => $_POST['Lname'],'FName'=>$_POST['Fname'], 'phone' => $_POST['phone'],
                'doctor_description' => $_POST['Ck_editor_value'], 'updated_date' => date("Y-m-d H:i:s")
            );
            $this->Doctors_model->updateDoctor($picture, $id);
        } else {
            $id = $_POST['id'];
            // $this->db->where('id', $id);
            // $image_exist = $this->db->get('sc_doctor')->result()[0]->image;
            $data = array(
                'LName' => $_POST['Lname'],'FName'=>$_POST['Fname'], 'phone' => $_POST['phone'],
                'doctor_description' => $_POST['Ck_editor_value'], 'updated_date' => date("Y-m-d H:i:s")
            );
            // print_r($id); die;
            $this->Doctors_model->updateDoctor($data, $id);
        }
        echo true;
    }


    public function deleteDoctor()
    {
        $id = $_POST['id'];
        $status = array('status' => 0, 'deleted_date' => date("Y-m-d H:i:s"));
        $this->Doctors_model->deleteDoctor($id, $status);
    }

    public function  change_dctor_status()
    {
        if ($_POST['prop'] == "false") {
            $this->db->where('id', $_POST['id']);
            $this->db->update('sc_doctor_working', array('status' => 0));
        } else {
            $this->db->where('id', $_POST['id']);
            $this->db->update('sc_doctor_working', array('status' => 1));
        }
    }
    public function appointment()
    {

        $id = $_GET['id'];
        $session_data = array('doctor_id' => $id,);
        $this->session->set_userdata($session_data);
        $data['id'] = $_GET['id'];
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header', $data);
        $this->load->view('calendar', $data);
        $this->load->view('footer', $data);
    }


    public function fetch()
    {
        $id = $this->session->userdata('doctor_id');

        $event_data = $this->Doctors_model->fetch_all_event($id);
        // $event_dat = $this->Doctors_model->fetch_all_events($id);

        // foreach ($event_dat->result_array() as $rows)  {

        // //     // $data[] = array(
        // //     //     // 'ScheduleNum' => $row['ScheduleNum'],
        // //     //     'title' =>'Pateint name:'. $rows['FName'].' '.$rows['LName'],

        // //     //     // 'start' => $row['SchedDate'].' '.$row['StartTime'],
        // //     //     // 'end' => $row['SchedDate'].' '.$row['StopTime'],
               

        // //     // );

        // }




        foreach ($event_data->result_array() as $row)  {
            $data[] = array(
                'ScheduleNum' => $row['ScheduleNum'],
                'title' =>'Pateint name:'. $row['FName'].' '.$row['LName'],
                'start' => $row['SchedDate'].' '.$row['StartTime'],
                'end' => $row['SchedDate'].' '.$row['StopTime'],
               

            );
        }

        // foreach ($rows as $users) {

        // print_r($data); die;
        echo json_encode($data);
    }

    public function insert()
    {
        if ($this->input->post('title')) {
            $data = array(
                'title'  => $this->input->post('title'),
                'start_event' => $this->input->post('start'),
                'end_event' => $this->input->post('end'),
                'doctor_id' => $this->input->post('doctor_id'),
                'created_date'=>date("Y-m-d H:i:s")
            );
            $this->Doctors_model->insert_event($data);
        }
    }

    public function update()
    {
        if ($this->input->post('id')) {
            $data = array(
                'title'   => $this->input->post('title'),
                'start_event' => $this->input->post('start'),
                'end_event'  => $this->input->post('end'),
                'updated_date' => date("Y-m-d H:i:s")
            );

            $this->Doctors_model->update_event($data, $this->input->post('id'));


         
        }
    }

    public function delete()
    {
        if ($this->input->post('id')) {
            $data = array('deleted_date' => date("Y-m-d H:i:s"), 'status' => 0);
            $this->Doctors_model->delete_event($data, $this->input->post('id'));
        }
    }

    public function add_doctor()
    {
       
        $this->Doctors_model->add_doctor();



    }
}
