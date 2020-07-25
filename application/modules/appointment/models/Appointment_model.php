<?php
class Appointment_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_appointment';
        $this->column_order = array(null, 'name', 'sc_users.lastname', 'sc_users.email', 'sc_users.phone', 'sc_appointment_type.type', 'sc_desired_clinic.desired_clinic', 'appointment_date', 'appointment_state');
        // Set searchable column fields
        $this->column_search = array('sc_users.name', 'sc_users.lastname', 'sc_family_member.Firstname', 'sc_family_member.Lastname', 'sc_appointment_type.type', 'appointment_state', 'sc_desired_clinic.desired_clinic', 'appointment_date', 'appointment_state', 'sc_users.phone');
        // Set default order
        $this->order = array('sc_appointment.appointment_date' => 'asc');
    }

    public function getRows_appointment($postData)
    {
        $this->_get_datatables_query_appointment($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
        // print_r($this->db->last_query()); die;
    }

    public function countAll_appointment()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered_appointment($postData)
    {
        $this->_get_datatables_query_appointment($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query_appointment($postData)
    {
        $this->db->where('approved_status', $_POST['id']);
        $this->db->where('sc_appointment.status', 1);
        $this->db->where('sc_users.status', 1);
        $this->db->where('sc_desired_clinic.status', 1);
        $this->db->select('sc_appointment.*,sc_users.name,sc_users.lastname,sc_users.phone,sc_users.email,sc_desired_clinic.desired_clinic,sc_appointment_type.type,sc_family_member.Firstname,sc_family_member.Lastname,sc_users.push_notification_state,sc_users.special_notification,sc_users.gps_status,sc_users.id as userid');
        $this->db->from($this->table);

        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id', 'left');
        $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id', 'left');
        $this->db->join('sc_appointment_type', 'sc_appointment.appointment_type = sc_appointment_type.id', 'left');
        $this->db->join('sc_family_member', 'sc_appointment.family_member_id = sc_family_member.member_uniqid', 'left');

        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
        }

        $i = 0;
        // loop searchable columns
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function appointmentDetails($id)
    {

        $this->db->select('sc_appointment.*,sc_appointment_type.type,sc_users.name,sc_users.lastname,sc_users.phone,sc_users.email,sc_users.PatNum,
        sc_family_member.Firstname,
        sc_family_member.Lastname,sc_doctor.FName,sc_doctor.LName,sc_desired_clinic.id as clinic_id');
        $this->db->from('sc_appointment');
        $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id', 'left');
        $this->db->join('sc_appointment_type', 'sc_appointment.appointment_type = sc_appointment_type.id', 'left');
        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id', 'left');
        $this->db->join('sc_family_member', 'sc_appointment.family_member_id = sc_family_member.member_uniqid', 'left');
        $this->db->join('sc_doctor', 'sc_appointment.ProvNum = sc_doctor.ProvNum', 'left');
        $this->db->where('sc_appointment.id', $id);
        $data = $this->db->get()->result();
        return $data;
    }
    public function appointmentTime($id)
    {
        $this->db->select('sc_appointment.*,sc_appointment_time.*');
        $this->db->from('sc_appointment');
        $this->db->join('sc_appointment_time', 'sc_appointment.id =sc_appointment_time.appointment_id', 'left');
        $this->db->where('sc_appointment.id', $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function appointmenNote($id)
    {
        $this->db->select('sc_appointment.*,sc_notes.appointment_id,sc_notes.note_name,sc_notes.note_description');
        $this->db->from('sc_appointment');
        $this->db->join('sc_notes', 'sc_appointment.id = sc_notes.appointment_id', 'left');
        $this->db->where('sc_appointment.id', $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function reminderPush()
    {
        $stop_date = date('Y-m-d', strtotime(' +6 day'));
        $this->db->select('sc_appointment.id as appt_id,sc_appointment.user_id,sc_appointment.admin_approved_date,sc_users.*');
        $this->db->from('sc_appointment');
        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id');
        $this->db->where('sc_users.push_notification_state', 1);
        $this->db->where('sc_appointment.admin_approved_Date LIKE ', '%' . $stop_date . '%');
        $usersData = $this->db->get()->result();
        foreach ($usersData as $key) {
            $cronData = $this->db->get_where('sc_push_reminder', array('appointment_id' => $key->appt_id))->result()[0];
            $pushToUserId = $this->db->get_where('sc_player', array('customer_id' => $key->user_id))->result();
            $pushToUserIds[] =  $pushToUserId[0]->player_id;

            if ($cronData->confirmation_push == 0) {
                $message = "Please Confirm your appointment !";
                $pushRes = $this->sendPushNotification($pushToUserIds, $message);
                if (isset($pushRes['recipients'])) {
                    $pushData = array(
                        "confirmation_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            } else if ($cronData->confirmation_push == 1 && $cronData->patient_confirmation == 0) {
                $message = "Please Confirm your appointment !";
                $pushRes = $this->sendPushNotification($pushToUserIds, $message);
                if (isset($pushRes['recipients'])) {
                    $pushData = array(
                        "confirmation_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            } else if ($cronData->confirmation_push == 1 && $cronData->patient_confirmation == 1) {
                $message = "Just a firendly reminder that You have an appointment";
                $pushRes = $this->sendPushNotification($pushToUserIds, $message);
                if (isset($pushRes['recipients'])) {
                    $pushData = array(
                        "friendly_remnder_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            }
        }
    }
    //////****  Appoinment Fix *****/////
    public function approve($data, $id, $datasecond)
    {

        $this->db->where('id', $id);
        $q = $this->db->update('sc_appointment', $data);

        $this->db2 = $this->load->database('second', true);
        $this->db2->where('PatNum', $_POST['PatNum']);
        //    $this->db2->where('AptDateTime',date("Y-m-d", strtotime($_POST['date'])) . ' ' . $_POST['time']);
        $q = $this->db2->get('appointment')->result();
        if ($q) {
            $data = array('ProvNum' => $_POST['ProvNum'], 'AptDateTime' => date("Y-m-d", strtotime($_POST['date'])) . ' ' . $_POST['time']);
            $this->db2 = $this->load->database('second', true);
            $this->db2->where('PatNum', $_POST['PatNum']);
            // $this->db2->where('AptDateTime',date("Y-m-d", strtotime($_POST['date'])) .' '. $_POST['time']);
            $q = $this->db2->update('appointment', $data);
        } else {
            $this->db2 = $this->load->database('second', true);
            $q = $this->db2->insert('appointment', $datasecond);
        }
        $pushNot = $this->db->get_where('sc_appointment', array('id' => $id))->result()[0];
        $pushToUserId = $this->db->get_where('sc_player', array('customer_id' => $pushNot->user_id))->result();
        if (empty($pushToUserId)) {
            // echo "empty";
        } else {
            $pushToUserIds[] =  $pushToUserId[0]->player_id;
            $message = "Your appointment have been fixed";
            $pushRes = $this->sendPushNotification($pushToUserIds, $message);
            if (isset($pushRes['recipients'])) {
                $pushData = array(
                    "user_id" => $pushNot->user_id,
                    "appointment_id" => $id,
                    "appt_date" => $pushNot->admin_approved_date,
                    "appt_fix_push" => 1
                );
                $this->db->insert('sc_push_reminder', $pushData);
                // echo true;
            }
        }
        // print_r($userPLayerId);


    }

    public function sendPushNotification($pushToUserIds, $message)
    {
        $fields = array(
            'app_id' => "a2377344-621c-4ead-8928-2b70705417c2",
            'include_player_ids' => $pushToUserIds,
            'data' => array("title" => "Smile Centers"),
            'contents' => array("en" => $message),
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response, true);
        return $res;
        // print_r($res['recipients']); die;
        // die;

    }
    ////*****Appoinment insert in schedule table  *****///
    public function scheduleOld($data)
    {
        //    $this->db->where('PatNum',$id);
        //     $q= $this->db->get('schedule')->result();
        //     if($q){
        // $this->db2 = $this->load->database('second', TRUE);
        // $this->db2->where('PatNum',$_POST['PatNum']);
        // $this->db2->where('AptDateTime',date("Y-m-d", strtotime($_POST['date'])) . ' ' . $_POST['time']);
        // $q= $this->db2->get('schedule')->result();
        // if($q){

        $this->db2 = $this->load->database('second', true);
        $q = $this->db2->insert('schedule', $data);
    }
    public function cancelAppointment($data, $id)
    {
        $this->db->where('id', $id);
        $q = $this->db->update('sc_appointment', $data);
        if ($q == true) {
            echo true;
        } else {
            echo false;
        }
    }



    public function getNotificationAppt()
    {
        $datetime = date("Y-m-d H:i:s");
        $timestamp = strtotime($datetime);
        $time = $timestamp - (3 * 60 * 60);
        $datetime = date("Y-m-d H:i:s", $time);
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
        }

        $this->db->select('sc_appointment.appointment_date,sc_appointment.reminder_date,sc_desired_clinic.desired_clinic AS clinicname,sc_users.name,sc_users.lastname,
        sc_users.email,sc_appointment_type.type');
        $this->db->from('sc_appointment');
        $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id');
        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id');
        $this->db->join('sc_appointment_type', 'sc_appointment.appointment_type = sc_appointment_type.id');
        $this->db->where('sc_appointment.appointment_date > "' . $datetime . '"');
        $this->db->where('sc_appointment.status', 1);
        $this->db->order_by("sc_appointment.appointment_date", "desc");
        $this->db->limit(10);
        return $this->db->get()->result();
        // print_r($this->db->last_query()); die;

    }

    public function getNewMessages()
    {
        $datetime = date("Y-m-d H:i:s");
        $timestamp = strtotime($datetime);
        $time = $timestamp - (3 * 60 * 60);
        $datetime = date("Y-m-d H:i:s", $time);
        // if ($_SESSION['usertype'] == 2) {
        //     $this->db->where('appointment.clinic_id', $_SESSION['clinic']);
        // }

        $this->db->select('sc_desired_clinic.desired_clinic AS clinicname,sc_users.name,sc_users.lastname,
        sc_users.email,sc_message_table.created_date,MAX(sc_message_table.message) AS sc_usermsg,sc_message_table.from_user_id');
        $this->db->from('sc_users');
        $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic = sc_desired_clinic.id');
        $this->db->join('sc_message_table', 'sc_users.id = sc_message_table.from_user_id');
        // $this->db->join('users', 'appointment.user_id = users.id');
        // $this->db->join('appointment_type','appointment.appointment_type = appointment_type.id');
        $this->db->where('sc_message_table.created_date > "' . $datetime . '"');
        // $this->db->where('appointment.status',1);
        $this->db->order_by("sc_message_table.created_date", "desc");
        $this->db->group_by("sc_message_table.from_user_id");
        $this->db->limit(10);
        return $this->db->get()->result();
        // print_r($this->db->last_query()); die;

    }
    public function getDoctor($id)
    {

        $this->db->select('sc_appointment.*,sc_doctor_working.clinic_id,sc_doctor.ProvNum,sc_doctor.FName ,sc_doctor.LName');
        $this->db->from('sc_appointment');
        $this->db->join('sc_doctor_working', 'sc_appointment.clinic_id = sc_doctor_working.clinic_id', 'left');
        $this->db->join('sc_doctor', 'sc_doctor_working.doctor_id = sc_doctor.id', 'left');
        $this->db->where('sc_appointment.id', $id);
        $data = $this->db->get()->result();
        return $data;
    }

    ////******** check appointment ********////
    public function events($id, $date, $startTime, $endTime)
    {
        // $this->db->where('status',1);
        // $this->db2->select('appointment.*,patient.*,schedule.*');
        $this->db2 = $this->load->database('second', true);
        $this->db2->where('ProvNum', $id);
        $this->db2->where('schedDate', $date);
        $this->db2->where('startTime', $startTime);
        $this->db2->where('stopTime', $endTime);
        $q = $this->db2->get('schedule')->result();
        return $q;
    }

    public function insurance($id)
    {

        $this->db->select('sc_appointment.*,sc_insurance.*');
        $this->db->from('sc_appointment');
        $this->db->join('sc_insurance', 'sc_appointment.user_id = sc_insurance.user_id', 'left');
        // $this->db->join('sc_doctor', 'sc_doctor_working.doctor_id = sc_doctor.id','left');
        $this->db->where('sc_appointment.id', $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function sendnotification($id, $message)
    {
        $this->db->select('player_id');
        $this->db->where('customer_id', $id);
        $q = $this->db->get('sc_player')->result()[0];
        $pushToUserIds[] =  $q->player_id;
        $content = array(
            "en" => $message
            );
        $fields = array(
            'app_id' => "a2377344-621c-4ead-8928-2b70705417c2",
            'include_player_ids' => $pushToUserIds,
            'data' => array("title" => "Smile Centers"),
            'contents' => $content,
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        // $res = json_decode($response, true);
        // return $res;
        // print_r($res);
        //    print_r($q);


    }
}
