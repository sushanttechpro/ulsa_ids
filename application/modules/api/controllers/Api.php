<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
class Api extends MX_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, token, user_id");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        // $method = $_SERVER['REQUEST_METHOD'];
        // if ($method == "OPTIONS") {
        //     die();
        // }
        $this->load->model(get_class($this) . '_model', 'model');
        $_POST = json_decode(file_get_contents('php://input'), true);
        parent::__construct();
        $this->load->helper('custom_helper');
    }

    public function register()
    {
        // print_r($_POST);die;
        $this->load->helper('custom_helper');
        $_POST['token'] = substr(md5(uniqid(mt_rand(), true)), 0, 15);

        if ($_POST['name'] == "") {
            $json = array('status_code' => 1, 'status' => 'error', 'txt' => 'name cannot be empty');
            http_response_code(400);

        } elseif ($_POST['lastname'] == "") {
            $json = array('status_code' => 33, 'status' => 'error', 'txt' => 'lastname cannot be empty');
            http_response_code(400);

        } elseif (strlen($_POST['name']) >= 60) {
            $json = array('status_code' => 2, 'status' => 'error', 'txt' => 'name cannot be greater than 60');
            http_response_code(400);

        } elseif ($_POST['email'] == "") {
            $json = array('status_code' => 204, 'status' => 'error', 'txt' => 'email address cannot be empty');
            http_response_code(400);

        } elseif (!(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST['email']))) {
            $json = array('status_code' => 205, 'status' => 'error', 'txt' => 'Invalid email');
            http_response_code(400);

        } elseif (strlen($_POST['password']) > 25) {
            $json = array('status_code' => 207, 'status' => 'error', 'txt' => 'password cannot be greater than 25 characters');
            http_response_code(400);

        } elseif ($_POST['password'] == "") {
            $json = array('status_code' => 206, 'status' => 'error', 'txt' => 'password cannot be empty');
            http_response_code(400);

        } elseif ($_POST['confirm_password'] == "") {
            $json = array('status_code' => 9, 'status' => 'error', 'txt' => 'confirm password cannot be empty');
            http_response_code(400);

        } elseif ($_POST['desired_clinic'] == "") {
            $json = array('status_code' => 5, 'status' => 'error', 'txt' => 'desired_clinic cannot be empty');
            http_response_code(400);

        } else {
            $json = $this->model->signup($_POST);

            // newRegistraionEmailSend($_POST['email_address'], 'Message','Subject');
            // newRegistraionEmailSend($_POST['email_address'], 'Message','Subject');

        }
        print_r(json_encode($json));
    }

    public function login()
    {
        if ($_POST['email'] == "") {
            $json = array('status_code' => 204, 'status' => 'error', 'txt' => 'email address cannot be empty');
            http_response_code(400);

        } elseif (!(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $_POST['email']))) {
            $json = array('status_code' => 205, 'status' => 'error', 'txt' => 'Invalid email');
            http_response_code(400);

        } elseif ($_POST['password'] == "") {
            $json = array('status_code' => 206, 'status' => 'error', 'txt' => 'password cannot be empty');
            http_response_code(400);

        } else {

            $json = $this->model->login($_POST);
        }
        print_r(json_encode($json));
    }
/////// Desired clinic ////////
    public function desired_clinic()
    {
        $json = $this->db->get_where('sc_desired_clinic', array('status' => 1))->result();
        print_r(json_encode($json));
    }
/////// Desired clinic ////////

///////  Desired clinic based on ID////////
    public function selected_clinic()
    {
        $this->db->where('id', $_POST['clinic_id']);
        $this->db->where('status', 1);
        $json = $this->db->get('sc_desired_clinic')->result();
        print_r(json_encode($json));
    }
/////// Desired clinic based on ID////////

    /////////General_dentistry_table  ////////////
    public function General_dentistry()
    {
        $json = $this->db->get_where('sc_General_dentistry_table', array('status' => 1))->result();
        print_r(json_encode($json));
    }

    /////// Get Doctor //////////
    public function Get_Doctors()
    {
        $json = $this->db->get_where('sc_doctor', array('status' => 1))->result();
        print_r(json_encode($json));
    }
    /////// Get Doctor //////////

    /////// Get Braces-op ///////
    public function Braces_post_op()
    {
        $json = $this->db->get_where('sc_Braces_post_op', array('status' => 1))->result();
        print_r(json_encode($json));
    }
    /////// Get Braces-op ///////

/////// Get special_offer ///////
    public function special_offer()
    {
        $json = $this->db->get_where('sc_special_offer', array('status' => 1))->result();
        print_r(json_encode($json));
    }
/////// Get special_offer ///////

/////// Get Emergency Service ///////
    public function get_emergency_service()
    {
        $json = $this->db->get_where('sc_emergency_services', array('status' => 1))->result();
        print_r(json_encode($json));
    }
/////// Get Emergency Service ///////

////// Update Reminder Date and Time //////
    public function UpdateReminderDate()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            if ($_POST['appointment_id'] == "") {
                $json = array('status_code' => 303, 'status' => 'error', 'txt' => 'Appointment id cannot be empty');
                http_response_code(400);
            } else {
                $this->db->where('user_id', $user_id);
                $this->db->where('id', $_POST['appointment_id']);
                $json = $this->db->update('sc_appointment', array('reminder_date' => $_POST['reminder_date'], 'reminder_time' => $_POST['reminder_time']));
                print_r(json_encode($json));
            }

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
////// Update Reminder Date and Time //////

/////// Get_family_member ///////
    public function Get_family_member()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->where('status', 1);
            $json = $this->db->get('sc_family_member')->result();
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
/////// Get_family_member ///////
    /////// get_insurance ///////
    public function get_insurance()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->where('status', 1);
            $json = $this->db->get('sc_insurance')->result();
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function Remove_insurance()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->where('id', $_POST['insurance_id']);
            $this->db->where('user_id', $user_id);
            $this->db->update('sc_insurance', array('status' => 0, 'deleted_date' => date('Y-m-d H:i:s')));
            $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Insurance deleted successfully');
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
/////// Remove_family_member ///////
    public function Remove_family_member()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->where('member_uniqId', $_POST['member_uniqId']);
            $this->db->delete('sc_family_member');
            $this->db->where('user_id', $user_id);
            $this->db->where('family_member_id', $_POST['member_uniqId']);
            $this->db->delete('sc_appointment');

            $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Member deleted successfully');
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////// Remove_family_member ///////

    /////// Update_family_member ///////
    public function Update_family_member()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            if ($_POST['Firstname'] == "") {
                $json = array('status_code' => 221, 'status' => 'error', 'txt' => 'Firstname cannot be empty');
                http_response_code(400);
            } elseif ($_POST['Lastname'] == "") {
                $json = array('status_code' => 222, 'status' => 'error', 'txt' => 'Lastname cannot be empty');
                http_response_code(400);
            } elseif ($_POST['phone_number'] == "") {
                $json = array('status_code' => 223, 'status' => 'error', 'txt' => 'phone number cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->Update_family_member($_POST, $user_id);
            }
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////// Update_family_member ///////

    /////// insurance ///////
    public function insurance()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            if ($_POST['patient_name'] == "") {
                $json = array('status_code' => 307, 'status' => 'error', 'txt' => 'patient name cannot be empty');
                http_response_code(400);
            } elseif ($_POST['subscriber_name'] == "") {
                $json = array('status_code' => 308, 'status' => 'error', 'txt' => 'subscriber name cannot be empty');
                http_response_code(400);
            } elseif ($_POST['patient_date_of_birth'] == "") {
                $json = array('status_code' => 309, 'status' => 'error', 'txt' => 'patient data of birth cannot be empty');
                http_response_code(400);
            } elseif ($_POST['subcriber_date_of_birth'] == "") {
                $json = array('status_code' => 310, 'status' => 'error', 'txt' => 'subscriber data of birth cannot be empty');
                http_response_code(400);
            } elseif ($_POST['subscriber_id'] == "") {
                $json = array('status_code' => 311, 'status' => 'error', 'txt' => 'subscriber id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->insurance($_POST, $user_id);
            }
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////// insurance ///////

    /////// Update insurance ///////
    public function update_insurance()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            if ($_POST['patient_name'] == "") {
                $json = array('status_code' => 307, 'status' => 'error', 'txt' => 'patient name cannot be empty');
                http_response_code(400);
            } elseif ($_POST['subscriber_name'] == "") {
                $json = array('status_code' => 308, 'status' => 'error', 'txt' => 'subscriber name cannot be empty');
                http_response_code(400);
            }
            // elseif ($_POST['patient_date_of_birth'] == "") {
            //     $json = array('status_code' => 309, 'status' => 'error', 'txt' => 'patient data of birth cannot be empty');
            //     http_response_code(400);
            // }
            // elseif ($_POST['subcriber_date_of_birth'] == "") {
            //     $json = array('status_code' => 310, 'status' => 'error', 'txt' => 'subscriber data of birth cannot be empty');
            //     http_response_code(400);
            // }
            elseif ($_POST['subscriber_id'] == "") {
                $json = array('status_code' => 311, 'status' => 'error', 'txt' => 'subscriber id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->update_insurance($_POST, $user_id);
            }
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////// Update insurance ///////

    /////// Get_profile ///////
    public function Get_profile()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->where('id', $user_id);
            $json = $this->db->get('sc_users')->result();
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /////// Get_profile ///////

    /////// Get_notes ///////
    public function Get_notes()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            // $this->db->where('appointment_id', $_POST['appointment_id']);
            $json = $this->db->get_where('sc_notes', array('status' => 1))->result();
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /////// Get_notes ///////

    /////// Emergency ///////
    public function emergency()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            $json = $this->model->emergency($_REQUEST, $user_id);

            print_r(json_encode($json));

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////// Emergency ///////
    //  ///// Update clicnic //////
    //  public function update_clinic()
    //  {
    //     $token_header = @$this->input->request_headers()['token'];
    //     $user_id = @$this->input->request_headers()['user_id'];
    //     if (check_token($token_header, $user_id)) {
    //         $this->db->where('id', $user_id);
    //         $this->db->update('id', $user_id);
    //         print_r(json_encode($json));
    //     } else {
    //         print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
    //     }
    //  }
    ///// Update clinic  //////
    /********************* store appointment ****************************************/

    public function createAppointment()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            if ($_POST['appointment_type'] == "") {
                $json = array('status_code' => 215, 'status' => 'error', 'txt' => 'appointment type cannot be empty');
                http_response_code(400);
            } elseif ($_POST['description'] == "") {
                $json = array('status_code' => 218, 'status' => 'error', 'txt' => 'description cannot be empty');
                http_response_code(400);
            } elseif ($_POST['clinic_id'] == "") {
                $json = array('status_code' => 219, 'status' => 'error', 'txt' => 'clinic id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->createAppointment($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

////// Get appointment /////////////
    public function getAppointment()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $this->db->select('sc_appointment.*,(SELECT name FROM sc_users WHERE id =sc_appointment.user_id)userName,(SELECT type FROM sc_appointment_type WHERE id =sc_appointment.appointment_type)appointment_type_name,(SELECT id FROM sc_family_member WHERE 	member_uniqid =sc_appointment.family_member_id) familyMemberId,(SELECT Firstname FROM sc_family_member WHERE 	member_uniqid =sc_appointment.family_member_id) MemberfirstName,(SELECT Lastname FROM sc_family_member WHERE 	member_uniqid =sc_appointment.family_member_id) MemberlastName, (SELECT desired_clinic FROM sc_desired_clinic WHERE id =sc_appointment.clinic_id) desired_clinic_name');
            $this->db->where('user_id', $user_id);
            $this->db->where('status', 1);

            $data = $this->db->get('sc_appointment')->result();
            foreach ($data as $key => $value) {
                $data[$key]->schedule = json_decode(json_encode($this->db->get_where("sc_appointment_time", array('appointment_id' => $value->id))->result()), true);

            }
            $list = json_decode(json_encode($data), true);
            print_r(json_encode($list));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
////// Get appointment /////////////

///////// Delete Appointmet///////////////
    public function Delete_appointment()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['appointment_id'] == "") {
                $json = array('status_code' => 300, 'status' => 'error', 'txt' => 'appointment id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->Delete_appointment($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
///////// Delete Appointmet///////////////

    /////////// Update Profile ////////////
    public function updateProfile()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            if ($_POST['name'] == "") {
                $json = array('status_code' => 1, 'status' => 'error', 'txt' => 'name cannot be empty');
                http_response_code(400);

            } elseif ($_POST['lastname'] == "") {
                $json = array('status_code' => 33, 'status' => 'error', 'txt' => 'lastname cannot be empty');
                http_response_code(400);

            } elseif (strlen($_POST['name']) >= 60) {
                $json = array('status_code' => 2, 'status' => 'error', 'txt' => 'name cannot be greater than 60');
                http_response_code(400);

            } elseif ($_POST['desired_clinic'] == "") {
                $json = array('status_code' => 5, 'status' => 'error', 'txt' => 'desired_clinic cannot be empty');
                http_response_code(400);

            } elseif ($_POST['user_dist_clinic'] == "") {
                $json = array('status_code' => 306, 'status' => 'error', 'txt' => 'Distance cannot be empty');
                http_response_code(400);

            } else {
                $json = $this->model->updateProfile($_POST, $user_id);

            }
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }

    }
    /////////// Update Profile ////////////
    /////////// Create family member ////////////

    public function family_member()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['Firstname'] == "") {
                $json = array('status_code' => 221, 'status' => 'error', 'txt' => 'Firstname cannot be empty');
                http_response_code(400);
            } elseif ($_POST['Lastname'] == "") {
                $json = array('status_code' => 222, 'status' => 'error', 'txt' => 'Lastname cannot be empty');
                http_response_code(400);
            } elseif ($_POST['phone_number'] == "") {
                $json = array('status_code' => 223, 'status' => 'error', 'txt' => 'phone number cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->family_member($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /////////// Create family member ////////////

////////// create Notes /////////////
    public function create_notes()
    {
//    print_r($_POST);die;
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['appointment_id'] == "") {
                $json = array('status_code' => 300, 'status' => 'error', 'txt' => 'appointment id cannot be empty');
                http_response_code(400);
            } elseif ($_POST['note_name'] == "") {
                $json = array('status_code' => 301, 'status' => 'error', 'txt' => 'note name cannot be empty');
                http_response_code(400);
            } elseif ($_POST['note_description'] == "") {
                $json = array('status_code' => 302, 'status' => 'error', 'txt' => 'note description cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->create_notes($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
////////// create Notes /////////////

////////// Delete Notes /////////////
    public function Delete_notes()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['note_id'] == "") {
                $json = array('status_code' => 304, 'status' => 'error', 'txt' => 'Note id cannot be empty');
                http_response_code(400);
            } elseif ($_POST['appointment_id'] == "") {
                $json = array('status_code' => 300, 'status' => 'error', 'txt' => 'appointment id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->Delete_notes($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
////////// Delete Notes /////////////

////////// Update Notes /////////////
    public function Update_notes()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['note_id'] == "") {
                $json = array('status_code' => 304, 'status' => 'error', 'txt' => 'Note id cannot be empty');
                http_response_code(400);
            } elseif ($_POST['appointment_id'] == "") {
                $json = array('status_code' => 300, 'status' => 'error', 'txt' => 'appointment id cannot be empty');
                http_response_code(400);
            } elseif ($_POST['note_name'] == "") {
                $json = array('status_code' => 301, 'status' => 'error', 'txt' => 'note name cannot be empty');
                http_response_code(400);
            } elseif ($_POST['note_description'] == "") {
                $json = array('status_code' => 302, 'status' => 'error', 'txt' => 'note description cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->Update_notes($_POST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
////////// Update Notes /////////////

//////////// Player ID //////////////
    public function addPlayerId()
    {
        $this->model->addPlayerId($_POST['player_id'], $_POST['user_id']);
        $json = array(
            'st' => 'success',
        );
        print_r(json_encode($json));
    }

    public function deletePlayerId()
    {
        $user_id = $this->input->request_headers()['user_id'];
        if ($user_id) {
            $this->model->deletePlayerId($user_id);
            $json = array(
                'st' => 'success',
            );
        } else {
            $json = array(
                'st' => 'error',
                'txt' => 'no player id',
            );
        }
        print_r(json_encode($json));
    }

/////// Get User ////////
    public function get_User()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $data = $this->model->get_User($user_id);
            $json = array(
                'st' => 'success',
                'data' => $data,
            );
            print_r(json_encode($json));

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

//////////// Player ID //////////////

    public function getAnimals()
    {
        $token_header = @$this->input->request_headers()['token'];

        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getAnimals($user_id);

            print_r(json_encode($json));
        } else {

            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }
    }

    public function getclinic()
    {

        $json = $this->model->getclinic();
        print_r(json_encode($json));

    }
    public function send_message()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['message'] == "") {
                $json = array('status_code' => 220, 'status' => 'error', 'txt' => 'message  cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->send_message($_POST, $user_id);

            }
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }

    }

    /********************* get messages  ****************************************/

    public function getMessages()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getMessages($user_id);

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }
    /********************* update profile ****************************************/

    // public function updateProfile()
    // {
    //     $token_header = @$this->input->request_headers()['token'];
    //     $user_id = @$this->input->request_headers()['user_id'];

    //     if (check_token($token_header, $user_id)) {
    //         if ($_REQUEST['fullname'] == "") {
    //             $json = array('status_code' => 1, 'status' => 'error', 'txt' => 'fullname cannot be empty');
    //             http_response_code(400);

    //         } elseif (strlen($_REQUEST['fullname']) >= 60) {
    //             $json = array('status_code' => 2, 'status' => 'error', 'txt' => 'username cannot be greater than 60');
    //             http_response_code(400);

    //         } elseif ($_REQUEST['tel_no1'] == "") {
    //             $json = array('status_code' => 3, 'status' => 'error', 'txt' => 'telephone1 cannot be empty');
    //             http_response_code(400);

    //         } elseif (strlen($_REQUEST['tel_no1']) > 10) {
    //             $json = array('status_code' => 4, 'status' => 'error', 'txt' => 'telephone1 cannot be greater than 12 characters');
    //             http_response_code(400);

    //         } elseif (strlen($_REQUEST['tel_no2']) > 10) {
    //             $json = array('status_code' => 16, 'status' => 'error', 'txt' => 'telephone2 cannot be greater than 12 characters');
    //             http_response_code(400);

    //         } elseif (strlen($_REQUEST['address']) > 51) {
    //             $json = array('status_code' => 18, 'status' => 'error', 'txt' => 'address cannot be greater than 50 character');
    //             http_response_code(400);

    //         } elseif (strlen($_REQUEST['city']) > 51) {
    //             $json = array('status_code' => 19, 'status' => 'error', 'txt' => 'city cannot be greater than 50 character');
    //             http_response_code(400);

    //         } else {
    //             $json = $this->model->updateProfile($_REQUEST, $user_id);
    //         }

    //         print_r(json_encode($json));
    //     } else {
    //         print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
    //         http_response_code(400);

    //     }
    // }

    /********************* store animal ****************************************/

    public function createAnimal()
    {

        // print_r($_FILES);die;
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_REQUEST['animal_name'] == "") {

                $json = array('status_code' => 7, 'txt' => 'animal name cannot be empty');
                http_response_code(400);

            } elseif (strlen($_REQUEST['animal_name']) > 51) {
                $json = array('status_code' => 8, 'status' => 'error', 'txt' => 'animal name cannot be greater than 50');
                http_response_code(400);

            } elseif ($_REQUEST['species_id'] == "") {
                $json = array('status_code' => 12, 'status' => 'error', 'txt' => 'animal species cannot be empty');
                http_response_code(400);

            } elseif ($_REQUEST['breed_id'] == "") {
                $json = array('status_code' => 13, 'status' => 'error', 'txt' => 'animal breed cannot be empty');
                http_response_code(400);

            }
            // elseif ($_REQUEST['date_of_birth'] == "") {
            //     $json = array('status_code' => 10, 'status' => 'error', 'txt' => 'date of birth cannot be empty');
            //     http_response_code(400);

            // }
            else {
                $json = $this->model->createAnimal($_REQUEST, $user_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }
    }

    /********************* update animal ****************************************/

    public function updateAnimal()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];
        $animal_id = @$_REQUEST['animal_id'];

        if (check_token($token_header, $user_id)) {
            if ($_REQUEST['animal_id'] == "") {
                $json = array('status_code' => 14, 'status' => 'error', 'txt' => 'animal id cannot be empty');
                http_response_code(400);

            } elseif ($_REQUEST['animal_name'] == "") {
                $json = array('status_code' => 7, 'status' => 'error', 'txt' => 'animal name cannot be empty');
                http_response_code(400);

            } elseif (strlen($_REQUEST['animal_name']) > 51) {
                $json = array('status_code' => 8, 'status' => 'error', 'txt' => 'animal name cannot be greater than 50');
                http_response_code(400);

            } elseif ($_REQUEST['species_id'] == "") {
                $json = array('status_code' => 12, 'status' => 'error', 'txt' => 'animal species cannot be empty');
                http_response_code(400);

            } elseif ($_REQUEST['breed_id'] == "") {
                $json = array('status_code' => 13, 'status' => 'error', 'txt' => 'animal breed cannot be empty');
                http_response_code(400);

            }
            //  elseif ($_REQUEST['date_of_birth'] == "") {
            //     $json = array('status_code' => 10, 'status' => 'error', 'txt' => 'date of birth cannot be empty');
            //     http_response_code(400);

            // }
            //  elseif ( $_REQUEST['electronic_number'] == "") {
            //     $json = array('status_code' => 9, 'status' => 'error', 'txt' => 'electronic number no cannot be empty');
            //     http_response_code(400);
            //    }

            else {
                $json = $this->model->updateAnimal($_REQUEST, $user_id, $animal_id);
            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }
    }

    /********************* get breed and species ****************************************/
    public function getBreedAndSpecies()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {
            $json = $this->model->getBreedAndSpecies();
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }
    }

    /********************* delete profile ****************************************/

    public function deleteProfile()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {
            echo "need to develop";
            exit();
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /********************* delete animal ****************************************/

    public function deleteAnimal()
    {
        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {
            if ($_POST['animal_id'] == "") {
                $json = array('status_code' => 214, 'status' => 'error', 'txt' => 'animal id cannot be empty');
                http_response_code(400);

            } else {
                $json = $this->model->deleteAnimal($user_id, $_POST['animal_id']);
            }
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
            http_response_code(400);

        }
    }

    /********************* Get animal ****************************************/

    public function get_animal()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {
            $this->db->select('animal.*,species.species_name,breeds.breed_name');
            $this->db->from('animal');
            $this->db->join("species", "species.id=animal.species_id", "left");
            $this->db->join("breeds", "breeds.id=animal.breed_id", "left");
            $this->db->where('client_id', $user_id);
            $json = $this->db->get()->result();
            if ($json) {
                print_r(json_encode($json));

            } else {
                print_r(json_encode(array('status' => 'error', 'txt' => 'No animal found')));

            }
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));

        }

    }

    /********************* create appointment screen ****************************************/

    public function createAppointment111()
    {

        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->createAppointment($user_id);
            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /********************* get appointments list ****************************************/

    public function getAppointments()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getAppointments($user_id);

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /********************* get appointments list ****************************************/

    public function getAppointmentTypes()
    {
        $json = $this->model->getAppointmentTypes();
        print_r(json_encode($json));

    }

    /********************* get appointments list ****************************************/

    public function getClinics()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getClinics();

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /********************* get campaigns  ****************************************/

    public function getCampaigns()
    {
        $json = $this->model->getCampaigns();

        print_r(json_encode($json));

    }

    /********************* get documents  ****************************************/

    public function getDocuments()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getDocuments($user_id);

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    /********************* get communications  ****************************************/

    public function getCommunications()
    {

        $token_header = @$this->input->request_headers()['token'];
        $user_id = @$this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->model->getCommunications();

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    //***********************************   set_prefered_clinic   *********************************************************************/

    public function set_prefered_clinic()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            if ($_POST['clinic_id'] == "") {
                $json = array('status_code' => 211, 'status' => 'error', 'txt' => 'clinic  id cannot be empty');
                http_response_code(400);
            } else {
                $json = $this->model->set_prefered_clinic($_POST, $user_id);

            }

            print_r(json_encode($json));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }

    }

//*********************************** forget password *********************************************************************/

    public function reset_pass_link()
    {
        // print_r($_POST);die;
        $this->load->library('email');
        $emailArray = $this->db->get_where("sc_users", array("email" => $_POST['email']));
        $emailExist = $emailArray->num_rows();
        if ($emailExist == 1) {
            $id = $emailArray->result_array()[0]['id'];
            $randNumber = $this->generateRandomString();
            $this->db->delete('sc_reset_password', array('user_id' => $id));
            $this->db->insert("sc_reset_password", array("user_id" => $id, "code" => $randNumber));

            $url = $this->config->item("base_url") . "auth/reset/?us=" . base64_encode($id) . "&code=" . $randNumber . "&ptype=mob";
            // <img src="' . $this->config->item("base_url") . '/assets/images/brand/logo.png"/>

            $data = $this->db->get_where("sc_users", array("id" => $id))->result()[0];
            $subject = "Request to change password - ULSA";
            $to = $data->email;
            $message = '<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
        <tr>
            <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
                <br>
                <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px; margin-bottom:20px;">
                    <tr style="background: white">
                        <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:0px;color:#DF4726;padding-left:24px;padding-right:24px">
                           <div style="text-align: center; width: 100%; height: auto;padding-top: 25px;">
                           </div>
                           <div class="title" style="max-width: 85%; margin: auto; margin-bottom:10px; background: #0061da; padding-top: 1px; padding-bottom: 1px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="container-padding content" align="left" style="padding-left: 10px; padding-right: 10px;padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:15px;background-color:#ffffff">
                            <div class="body-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: left; color: #000000;">
                            Hello ' . $data->name . ',
                            <br><br><div>
                              A password change request has been made for your account. Please go to<span><a href="' . $url . '"> reset link</a>
                            to enter your new password</span></div><br><br></div></td></tr></table></td></tr></table>';
            $this->sendMail($to, $subject, $message);
            $json = array(
                "st" => "success",
                "txt" => "email sent",
            );
        } else {
            $json = array(
                "st" => "error",
                "txt" => "email not found",
            );
        }
        print_r(json_encode($json));

    }

    public function reset_pass()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {

            $json = $this->db->update('sc_users', array("password" => base64_encode($_POST['password'])), "id = " . $user_id);
            print_r(json_encode(array('status' => 'success', 'txt' => $json, 'status_code' => 200)));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function check_old_password()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];

        if (check_token($token_header, $user_id)) {
            $old_password = $this->db->get_where('sc_users', array("password" => base64_encode($_POST['password']), 'id' => $user_id))->num_rows();
            if ($old_password !== 1) {
                print_r(json_encode(array('status' => 'error', 'txt' => 'Invalid old password', 'status_code' => 305)));
            } else {
                print_r(json_encode(array('status' => 'success', 'txt' => 'Password valid', 'status_code' => 200)));
            }
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendMail($to, $subject, $message)
    {
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => 'amankumar11111',
            'smtp_pass' => 'aman11111',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'crlf' => "\r\n",
            'newline' => "\r\n",
        );
        $this->email->initialize($config);
        $this->email->from('tiwariaman635@gmail.com', 'ULSA');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function get_communication()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            $json = $this->model->get_communication($_POST, $user_id);

            print_r(json_encode($json));

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function change_notification()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            $json = $this->model->change_notification($user_id);
            print_r(json_encode(array('status' => 'success', 'txt' => 'status changed')));

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }

    }

    public function notification_count()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {

            $json = $this->model->notification_count($user_id);
            if ($json) {
                print_r(json_encode(array('status' => 'success', 'count' => $json)));
            } else {
                print_r(json_encode(array('status' => 'error', 'txt' => 'no count found')));

            }

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }

    }

    public function delete_User()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $json = $this->model->delete_User($user_id);
            $json = array(
                'st' => 'success',
            );
            print_r(json_encode($json));

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function get_user_credit()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $json = $this->model->get_user_credit($user_id);
            if ($json) {
                print_r(json_encode($json));
            } else {
                print_r(json_encode(array('status' => 'error', 'txt' => 'no credit found')));
            }

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

    public function campaign_link()
    {
        $link = $this->db->get('campaign_link')->result()[0]->campaign_link;
        if ($link) {
            print_r(json_encode(array('status' => 'success', 'Link' => $link)));
        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'no link found')));
        }
    }

    public function get_user_discount()
    {
        $token_header = $this->input->request_headers()['token'];
        $user_id = $this->input->request_headers()['user_id'];
        if (check_token($token_header, $user_id)) {
            $json = $this->model->get_user_discount($user_id);
            if ($json) {
                print_r(json_encode($json));
            } else {
                print_r(json_encode($json));
            }

        } else {
            print_r(json_encode(array('status' => 'error', 'txt' => 'Unauthorized', 'status_code' => 401)));
        }
    }

}
