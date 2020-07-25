<?php    
class Emergency_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_emergency';
        // $this->column_order = array();
        $this->column_order = array( null,'name','sc_users.lastname','sc_users.email','sc_users.phone','sc_desired_clinic.desired_clinic','sc_emergency.created_date');

        // Set searchable column fields
        $this->column_search = array( 'name','sc_users.lastname','sc_users.email','sc_users.phone', 'sc_desired_clinic.desired_clinic','sc_emergency.created_date');
        // Set default order
        $this->order = array('sc_emergency.created_date' => 'asc');
    }
 
    public function getRows_emergency($postData){
        $this->_get_datatables_query_emergency($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        // print_r($_SERVER['REQUEST_URI']); die;
        return $query->result();
        // print_r($this->db->last_query()); die;
    }
    
    
    public function countAll_emergency(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_emergency($postData){
        $this->_get_datatables_query_emergency($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_emergency($postData){
       
        
    
        $this->db->select('sc_emergency.*,sc_users.name,sc_users.lastname,sc_users.phone,sc_users.email,sc_desired_clinic.desired_clinic,
        sc_family_member.Firstname,sc_family_member.Lastname,sc_doctor.FName,sc_doctor.LName');
        $this->db->from($this->table);

        $this->db->join('sc_users', 'sc_emergency.user_id = sc_users.id', 'left');
        $this->db->join('sc_doctor', 'sc_emergency.ProvNum = sc_doctor.ProvNum', 'left'); 
        
        $this->db->join('sc_desired_clinic', 'sc_emergency.clinic_id = sc_desired_clinic.id', 'left'); 
        // $this->db->join('sc_appointment_type', 'sc_emergency.appointment_type = sc_appointment_type.id', 'left'); 
        $this->db->join('sc_family_member', 'sc_emergency.family_member_id = sc_family_member.member_uniqid', 'left');

        if ($_POST['id']==0){
            $this->db->where('sc_emergency.status',0); 
        }else if($_POST['id']==1){
            $this->db->where('sc_emergency.status',1); 
        }else if($_POST['id']==2){
            $this->db->where('sc_emergency.status',2); 
        }else if($_POST['id']==3){
            $this->db->where('sc_emergency.status',1); 
            $this->db->where('sc_emergency.created_date like','%'.date('Y-m-d').'%');
        }else if($_POST['id']==4){
            $this->db->where('sc_emergency.status',0);
            $this->db->where('sc_emergency.created_date like','%'.date('Y-m-d').'%');
        }else if($_POST['id']==5){
            $this->db->where('sc_emergency.status',2); 
            $this->db->where('sc_emergency.created_date like','%'.date('Y-m-d').'%');
        }

        


        // if($this->session->userdata("emer")){
        //     $this->session->unset_userdata("emer");
        // } else {
        //     $this->db->where('sc_emergency.created_date like','%'.date('Y-m-d').'%');
        // }


        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_emergency.clinic_id', $_SESSION['clinic']);
        } 
        
      
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    


    public function emergencyDetails($id){

        $this->db->select('sc_emergency.*,sc_users.name,sc_users.lastname,sc_users.phone,sc_users.email,sc_users.PatNum,
        sc_family_member.Firstname,
        sc_family_member.Lastname,sc_doctor.FName,sc_doctor.LName,sc_desired_clinic.id as clinic_id');
        $this->db->from('sc_emergency');
        $this->db->join('sc_desired_clinic', 'sc_emergency.clinic_id = sc_desired_clinic.id','left'); 
        $this->db->join('sc_users', 'sc_emergency.user_id = sc_users.id', 'left'); 
        $this->db->join('sc_family_member', 'sc_emergency.family_member_id = sc_family_member.member_uniqid', 'left'); 
        $this->db->join('sc_doctor', 'sc_emergency.ProvNum = sc_doctor.ProvNum', 'left'); 
        $this->db->where('sc_emergency.id',$id);
        $data=$this->db->get()->result();
        return $data;
    }

    public function getTeethName($id){
        $this->db->select('sc_emergency.tooth_id');
        $this->db->from('sc_emergency');
        $this->db->where('sc_emergency.id',$id);
        $teethData = $this->db->get()->result()[0];
        $teethArray = explode(",",$teethData->tooth_id);
        $teethName = array(); 
        foreach ($teethArray as $key) {
            $this->db->select('teeth_name');
            $this->db->from('sc_teeth');
            $this->db->where('id',$key);
            $res = $this->db->get()->result()[0];
            // print_r($res->teeth_name);
            array_push($teethName,$res->teeth_name);
        }
        
        // print_r($teethName); 
        $teeths = implode(", ",$teethName);
        return $teeths;
    }

    public function getEmergencyService($id){
        $this->db->select('sc_emergency.discomfort_id');
        $this->db->from('sc_emergency');
        $this->db->where('sc_emergency.id',$id);
        $teethData = $this->db->get()->result()[0];
        $teethArray = explode(",",$teethData->discomfort_id);
        $teethName = array(); 
        foreach ($teethArray as $key) {
            $this->db->select('emergency_service');
            $this->db->from('sc_emergency_services');
            $this->db->where('id',$key);
            $res = $this->db->get()->result()[0];
            // print_r($res->teeth_name);
            array_push($teethName,$res->emergency_service);
        }
        
        // print_r($teethName); 
        $teeths = implode(", ",$teethName);
        return $teeths;
    }

    public function insurance($id)
    {
        $this->db->select('sc_emergency.*,sc_insurance.*');
        $this->db->from('sc_emergency');
        $this->db->join('sc_insurance', 'sc_emergency.user_id = sc_insurance.user_id','left'); 
        $this->db->where('sc_emergency.id',$id);
        $data=$this->db->get()->result();
        return $data;
    }

    public function getDoctor($id)
    {

        $this->db->select('sc_emergency.*,sc_doctor_working.clinic_id,sc_doctor.ProvNum,sc_doctor.FName ,sc_doctor.LName');
        $this->db->from('sc_emergency');
        $this->db->join('sc_doctor_working', 'sc_emergency.clinic_id = sc_doctor_working.clinic_id', 'left');
        $this->db->join('sc_doctor', 'sc_doctor_working.doctor_id = sc_doctor.id', 'left');
        $this->db->where('sc_emergency.id', $id);
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

    public function reminderPush(){
        $stop_date = date('Y-m-d', strtotime(' +6 day'));
        $this->db->select('sc_emergency.id as appt_id,sc_emergency.user_id,sc_emergency.admin_approved_date,sc_users.*');
        $this->db->from('sc_emergency');
        $this->db->join('sc_users', 'sc_emergency.user_id = sc_users.id');
        $this->db->where('sc_users.push_notification_state', 1);
        $this->db->where('sc_emergency.admin_approved_Date LIKE ', '%'.$stop_date.'%');
        $usersData = $this->db->get()->result();
        foreach ($usersData as $key ) {
            $cronData = $this->db->get_where('sc_push_reminder', array('appointment_id' => $key->appt_id))->result()[0];
            $pushToUserId = $this->db->get_where('sc_player', array('customer_id' => $key->user_id))->result();
            $pushToUserIds[] =  $pushToUserId[0]->player_id;

            if($cronData->confirmation_push == 0){
                $message = "Please Confirm your appointment !";
                $pushRes = $this->sendPushNotification($pushToUserIds,$message);
                if(isset($pushRes['recipients'])){
                    $pushData = array(
                        "confirmation_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            } else if($cronData->confirmation_push == 1 && $cronData->patient_confirmation == 0){
                $message = "Please Confirm your appointment !";
                $pushRes = $this->sendPushNotification($pushToUserIds,$message);
                if(isset($pushRes['recipients'])){
                    $pushData = array(
                        "confirmation_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            } else if($cronData->confirmation_push == 1 && $cronData->patient_confirmation == 1){
                $message = "Just a firendly reminder that You have an appointment";
                $pushRes = $this->sendPushNotification($pushToUserIds,$message);
                if(isset($pushRes['recipients'])){
                    $pushData = array(
                        "friendly_remnder_push" => 1
                    );
                    $this->db->where('appointment_id', $key->appt_id);
                    $this->db->update('sc_push_reminder', $pushData);
                }
            }

        }
        
    }

    public function approve($data, $id, $datasecond)
    {

        $this->db->where('id', $id);
        $q = $this->db->update('sc_emergency', $data);

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

        $pushNot = $this->db->get_where('sc_emergency', array('id' => $id))->result()[0];
        $pushToUserId = $this->db->get_where('sc_player', array('customer_id' => $pushNot->user_id))->result();
        if(empty($pushToUserId)){
            // echo "empty";
        } else {
            $pushToUserIds[] =  $pushToUserId[0]->player_id;
            $message = "Your Emeregency appointment have been fixed";
            $pushRes = $this->sendPushNotification($pushToUserIds,$message);
            if(isset($pushRes['recipients'])){
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
    }


    public function sendPushNotification($pushToUserIds,$message){
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
        $res = json_decode($response,true); 
        return $res;
        // print_r($res['recipients']); die;
        // die;
        
    }

    public function scheduleOld($data)
    {
      
        $this->db2 = $this->load->database('second', true);
        $q = $this->db2->insert('schedule', $data);

    }

    public function cancelEmergency($data, $id)
    {
        $this->db->where('id', $id);
        $q = $this->db->update('sc_emergency', $data);
        if ($q == true) {
            echo true;
        } else {
            echo false;
        }

    }

  

}