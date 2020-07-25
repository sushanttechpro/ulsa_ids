<?php

class Api_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function signup($add)
    {
        $add['password'] = base64_encode($add['password']);
        $this->db->where('email', $add['email']);

        $result = $this->db->get('sc_users');

        if ($result->result()) {
            $json = array(
                'status_code' => 6,
                'st' => 'error',
                'txt' => 'email already exist',
            );
            http_response_code(400);

            return $json;
        } else {
            $add['usertype'] = 3;
            $dataArray = array('name' => $add['name'], 'lastname' => $add['lastname'], 'email' => $add['email'], 'phone' => $add['phone'], 'password' => $add['password'], 'token' => $add['token'], 'usertype' => 3, 'push_notification_state' => $add['push_notification_state'], 'desired_clinic' => $add['desired_clinic'], 'special_notification' => $add['special_notification']);
            $this->db->insert('sc_users', $dataArray);
            $client_id = $this->db->insert_id();
            $this->db->select('sc_users.*,sc_desired_clinic.desired_clinic');
            $this->db->from('sc_users');
            $this->db->where('sc_users.id', $client_id);
            $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic=sc_desired_clinic.id');
            $returnArray = $this->db->get()->result();

            $json = array(
                'status_code' => 200,
                'status' => 'success',
                'data' => $returnArray,

            );
            return $json;

        }
    }
    /////////////////////////////////// mail Sent/////////////////////////////////////
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
        $this->email->from('tiwariaman635@gmail.com', 'Vida');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }
    /////////////////////////////////// mail Sent/////////////////////////////////////

    public function login($log)
    {
        $this->db->where('email', $log['email']);
        $data = $this->db->get('sc_users');
        if (!$data->result()) {
            $json = array(
                'status_code' => 209,
                'status' => 'error',
                'txt' => 'email not exist',

            );
            http_response_code(400);

        } else {

            $this->db->select('sc_users.*');
            $this->db->from('sc_users');
            $this->db->where('sc_users.usertype', 3);
            $this->db->where('sc_users.password', base64_encode($log['password']));
            $this->db->where('sc_users.email', $log['email']);
            $data = $this->db->get()->result();

            if ($data == null) {
                $json = array(
                    'status_code' => 207,
                    'status' => 'error',
                    'txt' => 'invalid credentials',

                );
                http_response_code(400);

            } else {
                if ($data) {
                    $json = array(
                        'status_code' => 200,
                        'status' => 'success',
                        'data' => $data[0],

                    );
                }
            }
        }return $json;
    }
/********************* store appointment ****************************************/

    public function createAppointment($postData, $user_id)
    {
        if ($postData['family_member_id'] !== "null") {
            $this->db->where('user_id', $user_id);
            $this->db->where('family_member_id', $postData['family_member_id']);
            $this->db->like('appointment_date', date('Y-m-d'));
            $family_member_appointment = $this->db->get('sc_appointment')->result()[0];
            if ($family_member_appointment) {
                $json = array(
                    'status_code' => 209,
                    'status' => 'error',
                    'txt' => 'Appointment already exist for this member',

                );
                http_response_code(400);
                return $json;
            } else {
                $create = $this->db->insert('sc_appointment', array('user_id' => $user_id, 'family_member_id' => $postData['family_member_id'], 'clinic_id' => $postData['clinic_id'], 'description' => $postData['description'], 'appointment_type' => $postData['appointment_type'], 'appointment_state' => 'Pending', 'appointment_date' => date('Y-m-d H:i:s')));
                $appointment_id = $this->db->insert_id();

                $this->db->get_where('sc_appointment', array('id' => $appointment_id))->result();
                foreach ($postData['schedule'] as $schedule) {
                    $days = $schedule['days'];
                    $slots = $schedule['slots'];
                    $this->db->insert('sc_appointment_time', array('days' => $days, 'slots' => $slots, 'appointment_id' => $appointment_id));
                }
                $appointment_notes = $this->db->get_where('sc_appointment_type', array('id' => $postData['appointment_type']))->result();
                // print_r($appointment_notes); die;
                if (($appointment_notes[0]->note_1 !== "") && ($appointment_notes[0]->note_description_1 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_1, 'note_description' => $appointment_notes[0]->note_description_1, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_2 !== "") && ($appointment_notes[0]->note_description_2 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_2, 'note_description' => $appointment_notes[0]->note_description_2, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_3 !== "") && ($appointment_notes[0]->note_description_3 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_3, 'note_description' => $appointment_notes[0]->note_description_3, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_4 !== "") && ($appointment_notes[0]->note_description_4 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_4, 'note_description' => $appointment_notes[0]->note_description_4, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_5 !== "") && ($appointment_notes[0]->note_description_5 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_5, 'note_description' => $appointment_notes[0]->note_description_5, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');
                return $json;
            }
        }

        if ($postData['family_member_id'] == "null") {
            $this->db->where('user_id', $user_id);
            $this->db->like('appointment_date', date('Y-m-d'));
            $appointment_is_exist = $this->db->get('sc_appointment')->result()[0];

            if ($appointment_is_exist) {
                $json = array(
                    'status_code' => 208,
                    'status' => 'error',
                    'txt' => 'Appointment already exist',

                );
                http_response_code(400);
                return $json;
            } else {
                $create = $this->db->insert('sc_appointment', array('user_id' => $user_id, 'family_member_id' => $postData['family_member_id'], 'clinic_id' => $postData['clinic_id'], 'description' => $postData['description'], 'appointment_type' => $postData['appointment_type'], 'appointment_state' => 'Pending', 'appointment_date' => date('Y-m-d H:i:s')));
                $appointment_id = $this->db->insert_id();

                $this->db->get_where('sc_appointment', array('id' => $appointment_id))->result();
                foreach ($postData['schedule'] as $schedule) {
                    $days = $schedule['days'];
                    $slots = $schedule['slots'];
                    $this->db->insert('sc_appointment_time', array('days' => $days, 'slots' => $slots, 'appointment_id' => $appointment_id));
                }
                $appointment_notes = $this->db->get_where('sc_appointment_type', array('id' => $postData['appointment_type']))->result();
                // print_r($appointment_notes); die;
                if (($appointment_notes[0]->note_1 !== "") && ($appointment_notes[0]->note_description_1 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_1, 'note_description' => $appointment_notes[0]->note_description_1, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_2 !== "") && ($appointment_notes[0]->note_description_2 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_2, 'note_description' => $appointment_notes[0]->note_description_2, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_3 !== "") && ($appointment_notes[0]->note_description_3 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_3, 'note_description' => $appointment_notes[0]->note_description_3, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_4 !== "") && ($appointment_notes[0]->note_description_4 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_4, 'note_description' => $appointment_notes[0]->note_description_4, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                if (($appointment_notes[0]->note_5 !== "") && ($appointment_notes[0]->note_description_5 !== "")) {
                    $this->db->insert('sc_notes', array('note_name' => $appointment_notes[0]->note_5, 'note_description' => $appointment_notes[0]->note_description_5, 'user_id' => $user_id, 'appointment_id' => $appointment_id, 'is_created' => date('Y-m-d H:i:s')));
                }
                $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');
                return $json;
            }
        }

    }
//////////  Delete appointment /////////
    public function Delete_appointment($postData, $user_id)
    {
        $this->db->where('id', $postData['appointment_id']);
        $this->db->where('user_id', $user_id);
        $this->db->update('sc_appointment', array('status' => 0, 'deleted_date' => date('Y-m-d H:i:s')));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Deletion success');
        return $json;
    }
//////////  Delete appointment /////////

////////// Delete Note //////////////////
    public function Delete_notes($postData, $user_id)
    {
        $this->db->where('appointment_id', $postData['appointment_id']);
        $this->db->where('id', $postData['note_id']);
        $this->db->update('sc_notes', array('status' => 0, 'is_deleted' => date('Y-m-d H:i:s')));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Deletion success');
        return $json;
    }
////////// Delete Note //////////////////
    ///////// Update Notes /////////////////
    public function Update_notes($postData, $user_id)
    {
        $this->db->where('appointment_id', $postData['appointment_id']);
        $this->db->where('id', $postData['note_id']);
        $this->db->update('sc_notes', array('note_name' => $postData['note_name'], 'note_description' => $postData['note_description']));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Updation success');
        return $json;
    }
///////// Update Notes /////////////////

/********************* family member ****************************************/

    public function getName($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
    public function family_member($postData, $user_id)
    {
        $member_uniqId = $this->getName(8);
        $create = $this->db->insert('sc_family_member', array('user_id' => $user_id, 'Firstname' => $postData['Firstname'], 'Lastname' => $postData['Lastname'], 'phone_number' => $postData['phone_number'], 'member_uniqId' => $member_uniqId));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');

        return $json;
    }

    public function create_notes($postData, $user_id)
    {
        $create = $this->db->insert('sc_notes', array('user_id' => $user_id, 'note_name' => $postData['note_name'], 'note_description' => $postData['note_description'], 'appointment_id' => $postData['appointment_id']));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');

        return $json;
    }

////// Insurance ///////
    public function insurance($postData, $user_id)
    {
        $create = $this->db->insert('sc_insurance', array('user_id' => $user_id, 'subscriber_id' => $postData['subscriber_id'], 'patient_name' => $postData['patient_name'], 'subscriber_name' => $postData['subscriber_name'], 'patient_date_of_birth' => $postData['patient_date_of_birth'], 'subcriber_date_of_birth' => $postData['subcriber_date_of_birth'], 'created_date' => date('Y-m-d H:i:s')));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');

        return $json;
    }

////// Insurance ///////
    ////// Update Insurance ///////
    public function update_insurance($postData, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $_POST['insurance_id']);
        $this->db->update('sc_insurance', array('subscriber_id' => $postData['subscriber_id'], 'patient_name' => $postData['patient_name'], 'subscriber_name' => $postData['subscriber_name'], 'created_date' => date('Y-m-d H:i:s')));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');

        return $json;
    }

////// Emergency //////
    public function emergency($postData, $user_id)
    {
        $image = "";
        $is_exist = $this->db->get_where('sc_emergency', array('user_id' => $user_id))->num_rows();
        if ($is_exist == 0) {
            if (isset($postData['image'])) {

                $image = "";
                $img = explode(',', $postData['image']);
                $data = base64_decode($img[1]);

                $imageName = "emergency_" . rand(10000, 99999);
                $image = 'assets/images/' . $imageName . '.jpeg';
                file_put_contents($image, $data);
            }

            $create = $this->db->insert('sc_emergency', array('user_id' => $user_id, 'image' => $image, 'family_member_id' => $postData['family_member_id'], 'tooth_id' => $postData['tooth_id'], 'discomfort_id' => $postData['discomfort_id'], 'pain_intensity' => $postData['pain_intensity'], 'comments' => $postData['comments'], 'clinic_id' => $postData['clinic_id'], 'created_date' => date('Y-m-d H:i:s')));
            $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');
            return $json;

        } else {
            if (isset($postData['image'])) {

                $image = "";
                $img = explode(',', $postData['image']);
                $data = base64_decode($img[1]);

                $imageName = "emergency_" . rand(10000, 99999);
                $image = 'assets/images/' . $imageName . '.jpeg';
                file_put_contents($image, $data);
            }

            $this->db->where('user_id', $user_id);
            $this->db->update('sc_emergency', array('user_id' => $user_id, 'image' => $image, 'family_member_id' => $postData['family_member_id'], 'tooth_id' => $postData['tooth_id'], 'discomfort_id' => $postData['discomfort_id'], 'pain_intensity' => $postData['pain_intensity'], 'comments' => $postData['comments'], 'clinic_id' => $postData['clinic_id'], 'created_date' => date('Y-m-d H:i:s')));
            $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'creation success');
            return $json;

        }

        return $json;
    }

////// Emergency //////

/////////////////////  Update_family_member ///////////////////
    public function Update_family_member($postData, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('member_uniqId', $postData['member_uniqId']);
        $this->db->update('sc_family_member', array('Firstname' => $postData['Firstname'], 'Lastname' => $postData['Lastname'], 'phone_number' => $postData['phone_number']));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'Updation success');

        return $json;
    }
/////////////////////  Update_family_member ///////////////////

    public function change_password($data)
    {
        $updatepass = array('password' => base64_encode($data['password']));
        $this->db->where('id', $data['user_id']);
        $updatep = $this->db->update('sc_users', $updatepass);
        if ($updatep) {
            return true;
        } else {
            return false;
        }
    }

    public function send_message($postData, $user_id)
    {
        $array = array(
            'from_user_id' => $user_id,
            'message' => $postData['message'],
            'user_id' => $user_id,
            'usertype' => 3,
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('sc_message_table', $array);
        // $this->db->where('client_id', $user_id);
        // $this->db->delete('message_flag');
        // $this->db->where('usertype !=', 3);
        // $usersData = $this->db->get('user')->result();
        // $data = array();
        // foreach ($usersData as $id_of_user) {
        //     $data[] = array("user_id" => $id_of_user->id, "client_id" => $user_id);
        // }
        // $this->db->insert_batch('message_flag', $data);

        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'message created');
        return $json;
    }
/********************* get messages ****************************************/
    public function getMessages($user_id)
    {
        return $this->db->get_where('sc_message_table', array('user_id' => $user_id, 'status' => 1))->result();
    }
// public function getMessages($user_id)
    // {
    //     $this->db->select("message_table.*, user.image,user.name");
    //     $this->db->join("user", "user.id=message_table.from_user_id", "left");
    //     return $this->db->get_where('message_table', array('client_id' => $user_id))->result();
    // }

    public function get_User($user_id)
    {
        $this->db->select('sc_users.*');
        $this->db->from('sc_users');
        $this->db->where('sc_users.id', $user_id);
        // $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic=sc_desired_clinic.id');
        return $this->db->get()->result();
    }

    public function getclinic()
    {
        $this->db->where('usertype', 2);
        $this->db->where('status', 1);
        $clinic = $this->db->get('sc_users')->result();
        return $clinic;
    }

/********************* update profile ****************************************/

    public function updateProfile($add, $user_id)
    {
        // $dataArray = array('name' => $add['name'],'lastname' => $add['lastname'],'phone'=>$add['phone']);
        $this->db->where('id', $user_id);
        $update = $this->db->update('sc_users', array('name' => $add['name'], 'lastname' => $add['lastname'], 'user_dist_clinic' => $add['user_dist_clinic'], 'phone' => $add['phone'], 'desired_clinic' => $add['desired_clinic']));
        if ($update == 1) {
            $this->db->select('sc_users.*,sc_desired_clinic.desired_clinic');
            $this->db->where('sc_users.id', $user_id);
            $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic=sc_desired_clinic.id', "LEFT");
            $returnArray = $this->db->get('sc_users')->result();

            $json = array(
                'status_code' => 200,
                'status' => 'success',
                'data' => $returnArray,
            );

        } else {
            $json = array('status_code' => 111, 'status' => 'error', 'txt' => 'Updation failed');
            http_response_code(400);
        }
        return $json;

    }
//////////// Player ID /////////////
    public function addPlayerId($playerId, $userId)
    {
        $this->db->delete('sc_player', array('player_id' => $playerId));
        $this->db->insert('sc_player', array('player_id' => $playerId, 'customer_id' => $userId));
    }

    public function deletePlayerId($user_id)
    {
        $this->db->delete('sc_player', array('customer_id' => $user_id));
    }

/********************* get breed and species ****************************************/

    public function getBreedAndSpecies()
    {
        $getData = new stdClass();
        $this->db->select('id,breed_name,species_id');
        $getData->breeds = $this->db->get('breeds')->result();
        $this->db->select('id,species_name');
        $getData->species = $this->db->get('species')->result();
        return $getData;
    }

/********************* store animal ****************************************/

    public function createAnimal($postData, $user_id)
    {
        $imgName = "assets/images/animal/default.png";
        $valid_extensions = array('jpeg', 'jpg', 'png');

        if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] == 0) {

            $img = $_FILES['animal_image']['name'];
            $tmp = $_FILES['animal_image']['tmp_name'];
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            if (in_array($ext, $valid_extensions)) {

                $final_image = str_replace(" ", "_", rand(1000, 1000000) . $img);

                $path = "assets/images/animal/" . strtolower($final_image);
                if (move_uploaded_file($tmp, $path)) {

                    $imgName = $path;
                }

            } else {
                $json = array('status_code' => 99, 'status' => 'error', 'txt' => 'Image Invalid formate');
                http_response_code(400);

                return $json;
            }
        }
        $this->db->insert('animal', array('client_id' => $user_id, 'animal_image' => $imgName, 'animal_name' => $postData['animal_name'], 'species_id' => $postData['species_id'], 'breed_id' => $postData['breed_id'], 'date_of_birth' => $postData['date_of_birth'], 'electronic_number' => $postData['electronic_number']));
        $animal_id = $this->db->insert_id();
        $this->db->select('*');
        $this->db->from('animal');
        $this->db->where('animal.id', $animal_id);
        $returnArray = $this->db->get()->result()[0];
        $json = array('status_code' => 200, 'status' => 'success', 'data' => $returnArray, 'txt' => 'creation success');
        return $json;

    }

/********************* update animal ****************************************/

    public function updateAnimal($postData, $user_id, $animal_id)
    {

        $imgName = $this->db->query('SELECT animal_image FROM animal WHERE id=' . $animal_id)->row()->animal_image;
        $valid_extensions = array('jpeg', 'jpg', 'png');

        if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] == 0) {

            $img = $_FILES['animal_image']['name'];
            $tmp = $_FILES['animal_image']['tmp_name'];
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            if (in_array($ext, $valid_extensions)) {

                $final_image = str_replace(" ", "_", rand(1000, 1000000) . $img);

                $path = "assets/images/face/" . strtolower($final_image);
                if (move_uploaded_file($tmp, $path)) {
                    if (file_exists($imgName)) {
                        unlink($imgName);
                    }
                    $imgName = $path;

                }

            } else {
                $json = array('status_code' => 99, 'status' => 'error', 'txt' => 'Image Invalid formate');
                http_response_code(400);

                return $json;
            }
        }

        $this->db->where('id', $animal_id);
        $this->db->where('client_id', $user_id);
        $update = $this->db->update('animal', array('animal_image' => $imgName, 'animal_name' => $postData['animal_name'], 'species_id' => $postData['species_id'], 'breed_id' => $postData['breed_id'], 'date_of_birth' => $postData['date_of_birth'], 'electronic_number' => $postData['electronic_number']));

        if ($update) {
            $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'updation success');

            return $json;
        } else {
            $json = array('status' => 'error', 'txt' => 'updation failed');
            http_response_code(400);

            return $json;
        }
    }

/********************* delete animal ****************************************/

    public function deleteAnimal($user_id, $animal_id)
    {

        $imgName = $this->db->query('SELECT animal_image FROM animal WHERE id=' . $animal_id)->row()->animal_image;
        if (file_exists($imgName)) {
            unlink($imgName);
        }

        $this->db->where('client_id', $user_id);
        $this->db->where('id', $animal_id);
        $this->db->delete('animal');
        $this->db->where('animal_id', $animal_id);
        $del = $this->db->delete('appointment_table');

        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'deletion success');
        return $json;

    }

/********************* create appointment types ****************************************/

    public function getAppointmentTypes()
    {
        $this->db->select('id,type');
        $getData = $this->db->get('sc_appointment_type')->result();
        return $getData;
    }

/********************* create appointment types ****************************************/

    public function getClinics()
    {
        $this->db->where('usertype', 2);
        $this->db->select('id,name');
        $getData = $this->db->get('sc_users')->result();
        return $getData;
    }

/********************* get appointments ****************************************/

    public function getAppointments($user_id)
    {
        $appointmentData = new stdClass();

        $this->db->select('animal.animal_name,animal.animal_image,specialties.specialty_name as appointment_type,user.name as clinic_name,appointment_table.status,appointment_table.date_of_appointment,appointment_table.time,appointment_table.appointment_state');
        $this->db->from('appointment_table');
        $this->db->join('animal', 'appointment_table.animal_id=animal.id');
        $this->db->join('specialties', 'appointment_table.appointment_id=specialties.id');
        $this->db->join('user', 'appointment_table.clinic_id=user.id');
        $this->db->where("appointment_table.status=", 1);
        $this->db->where("appointment_table.client_id", $user_id);
        $this->db->where("appointment_table.date_of_appointment >=", date('Y-m-d'));
        $appointmentData->upcomming = $this->db->get()->result();

        $this->db->select('animal.animal_name,animal.animal_image,specialties.specialty_name as appointment_type,user.name as clinic_name,appointment_table.date_of_appointment,appointment_table.time,appointment_table.appointment_state');
        $this->db->from('appointment_table');
        $this->db->join('animal', 'appointment_table.animal_id=animal.id');
        $this->db->join('specialties', 'appointment_table.appointment_id=specialties.id');
        $this->db->join('user', 'appointment_table.clinic_id=user.id');
        $this->db->where("appointment_table.client_id", $user_id);
        $this->db->where("appointment_table.date_of_appointment <", date('Y-m-d'));
        $appointmentData->past = $this->db->get()->result();
        $last = $this->db->last_query();
        return $appointmentData;

    }

/********************* get appointments ****************************************/

    public function getCampaigns()
    {

        $this->db->where('status', 1);
        $this->db->select('id,title,image,link');
        return $this->db->get('campaigns')->result();
    }

/********************* get Documents ****************************************/

    public function getDocuments($user_id)
    {

        $this->db->select('id,title,document_path,document_name,date');
        $this->db->where('client_id', $user_id);
        return $this->db->get('document_table')->result();
    }

/********************* get communications ****************************************/

    public function getCommunications()
    {
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'need to develop');
        return $json;
    }

/****************************** set_prefered_clinic ****************************************/

    public function set_prefered_clinic($clinic_id, $user_id)
    {

        $this->db->where('client_id', $user_id);
        $this->db->update('client_information', array('clinic_id' => $clinic_id['clinic_id']));
        $json = array('status_code' => 200, 'status' => 'success', 'txt' => 'clinic set');
        return $json;
    }

    public function get_communication($clinic_id, $user_id)
    {
        if (isset($clinic_id['clinic_id'])) {
            $this->db->where("clinic_id", $clinic_id['clinic_id']);
            $this->db->or_where("clinic_id", 0);
        } else {
            $this->db->where("clinic_id", 0);
        }
        $communicationData = $this->db->get('communication')->result();
        return $communicationData;
    }

    public function change_notification($user_id)
    {
        $this->db->where('client_id', $user_id);
        return $this->db->update('notification_table', array('status' => 1));
    }
    public function notification_count($user_id)
    {
        return $this->db->get_where('notification_table', array('client_id' => $user_id, 'status' => 0))->num_rows();

    }
    public function delete_User($id)
    {
        $this->db->trans_start();
        $this->db->query("DELETE FROM client_information WHERE client_id='$id'");
        $this->db->query("DELETE FROM animal WHERE client_id='$id'");
        $this->db->query("DELETE FROM appointment_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM discount_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM document_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM invoice_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM message_flag WHERE client_id='$id'");
        $this->db->query("DELETE FROM message_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM user_credit_table WHERE client_id='$id'");
        $this->db->query("DELETE FROM player WHERE customer_id='$id'");
        $this->db->query("DELETE FROM user WHERE id='$id'");
        $this->db->trans_complete();
        return 1;
    }

    public function get_user_credit($client_id)
    {
        $credit = $this->db->query("select (IFNULL((SELECT SUM(user_credit_table.credit_of_user) FROM user_credit_table WHERE client_id = " . $client_id . "),0) - IFNULL((SELECT SUM(discount_table.discount) FROM discount_table WHERE client_id = " . $client_id . "),0)) credit")->result();
        return $credit;
    }

    public function get_user_discount($client_id)
    {
        return $this->db->get_where('discount_table', array('client_id' => $client_id))->result();
    }

}
