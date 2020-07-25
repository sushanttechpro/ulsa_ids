<?php    
date_default_timezone_set('Asia/Kolkata');  

class Dashboard_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_appointment';
        // $this->column_order = array( 'name','sc_users.lastname','sc_users.email','sc_users.phone','sc_appointment_type.type', 'appointment_state','sc_desired_clinic.sc_desired_clinic','appointment_date');
        $this->column_order = array( null,'name','sc_users.lastname','sc_users.email','sc_users.phone','sc_appointment_type.type', 'sc_desired_clinic.desired_clinic','appointment_date','appointment_state');

        // Set searchable column fields
        $this->column_search = array( 'name','sc_users.lastname','sc_family_member.Firstname','sc_family_member.Lastname','sc_appointment_type.type','appointment_state','sc_desired_clinic.desired_clinic','appointment_date','appointment_state','sc_users.phone');
        // Set default order
        $this->order = array('sc_appointment.appointment_date' => 'asc');
    }
 
    public function getRows_appointment($postData){
        $this->_get_datatables_query_appointment($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
        // print_r($this->db->last_query()); die;
    }
    
    
    public function countAll_appointment(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_appointment($postData){
        $this->_get_datatables_query_appointment($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_appointment($postData){
        $this->db->where('approved_status', $_POST['id']);
        $this->db->where('sc_appointment.status', 1);
        $this->db->where('sc_users.status', 1);
        $this->db->where('sc_desired_clinic.status', 1);
        $this->db->where('DATE(appointment_date)',date('Y-m-d'));
        $this->db->select('sc_appointment.*,sc_users.name,sc_users.lastname,sc_users.email,sc_users.phone,sc_desired_clinic.desired_clinic,sc_appointment_type.type,sc_family_member.Firstname,sc_family_member.Lastname');
        $this->db->from($this->table);

        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id', 'left'); 
        $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id', 'left'); 
        $this->db->join('sc_appointment_type', 'sc_appointment.appointment_type = sc_appointment_type.id', 'left'); 
        $this->db->join('sc_family_member', 'sc_appointment.family_member_id = sc_family_member.member_uniqid', 'left'); 




        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
        }       
         
        // $this->db->from($this->table);
 
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





    public function getProfile(){
       $id= $this->session->userdata('ulsa_id');
        // $this->db->select('name,phone,email');
        $this->db->from('sc_users');
        // $this->db->join('modules_details', 'modules.id = modules_details.module_id');        
        $this->db->where('id',$id);
        $data=$this->db->get();
        return $data->result()[0];
    }

    public function updateAdmin($data,$id){
        $this->db->where('id',$id);
        $this->db->update('sc_users',$data);
    }
    public function insertFilter($id)
    {
        $this->db->where('user_id',$id);
        $data=$this->db->get('sc_filter_status')->num_rows();
        if($data==1){
            $filterdata_one=array('starting_date'=>date("Y-m-d", strtotime($_POST['date_one'])),
            'ending_date'=>date("Y-m-d", strtotime($_POST['date_two'])),'updated_date'=>date("Y-m-d H:i:s"));
            $this->db->where('user_id',$id);
            $this->db->update('sc_filter_status',$filterdata_one);
        }else{
            $filterdata=array('user_id'=>$this->session->userdata('ulsa_id'),
            'usertype'=>$this->session->userdata('usertype'),'starting_date'=>date("Y-m-d", strtotime($_POST['date_one'])),
            'ending_date'=>date("Y-m-d", strtotime($_POST['date_two'])),'created_date'=>date("Y-m-d H:i:s"));
            $this->db->insert('sc_filter_status',$filterdata);
        }
        echo true;
    }
    
    public function countAll_users(){
        $this->db->where('user_id',$this->session->userdata('ulsa_id'));
        $data=$this->db->get('sc_filter_status')->num_rows();
        if($data==1){
            $this->db->where('user_id',$this->session->userdata('ulsa_id'));
            $q=$this->db->get('sc_filter_status')->result()[0];
            $date1=$q->starting_date;
            $date2=$q->ending_date;
            $this->db->from('sc_users'); 
            $this->db->where('created_date BETWEEN "' . $date1 . '" and "' . $date2 . '"');
            if ($_SESSION['usertype'] == 2) {
                $this->db->where('sc_users.desired_clinic', $_SESSION['clinic']);
            }
            $this->db->where('sc_users.usertype',3);
            $this->db->where('sc_users.status',1);
            return $this->db->count_all_results();
        }else{
            $this->db->from('sc_users'); 
            $this->db->where('created_date',date('y-m-d'));
            if ($_SESSION['usertype'] == 2) {
                $this->db->where('sc_users.desired_clinic', $_SESSION['clinic']);
            }
            $this->db->where('sc_users.usertype',3);
            $this->db->where('sc_users.status',1);
            return $this->db->count_all_results();

        }
    }

    public function countAll_confappointments(){
        // $this->db->where('user_id',$this->session->userdata('ulsa_id'));
        // $data=$this->db->get('sc_filter_status')->num_rows();
        // if($data==1){
        //     $this->db->where('user_id',$this->session->userdata('ulsa_id'));
        //     $q=$this->db->get('sc_filter_status')->result()[0];

        //     $date1=$q->starting_date;
        //     $date2=$q->ending_date;
        //     $this->db->from('sc_appointment');
        //     $this->db->where('appointment_date BETWEEN "' . $date1 . '" and "' . $date2 . '"');
        //     if ($_SESSION['usertype'] == 2) {
        //         $this->db->where('clinic_id', $_SESSION['clinic']);
        //     }
           
        //     $this->db->where('status',1);
        //     $this->db->where('approved_status',1);
        //     return $this->db->count_all_results();

        // }else{
            $this->db->from('sc_appointment');
            $this->db->where('appointment_date >= "'.date('Y-m-d').'"');
            if ($_SESSION['usertype'] == 2) {
                $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
            }
            $this->db->where('status',1);
            $this->db->where('approved_status',1);
            return $this->db->count_all_results();
        // }
        
       
    }

    public function countAll_newappointments(){
     
        // $this->db->where('user_id',$this->session->userdata('ulsa_id'));
       
        // $data=$this->db->get('sc_filter_status')->num_rows();
        // if($data==1){
        //     $this->db->where('user_id',$this->session->userdata('ulsa_id'));
        //     $q=$this->db->get('sc_filter_status')->result()[0];
        
        //     $date1=$q->starting_date;
        //     $date2=$q->ending_date;
        //     $this->db->from('sc_appointment');
        //     $this->db->where('appointment_date BETWEEN "' . $date1 . '" and "' . $date2 . '"');
        //     if ($_SESSION['usertype'] == 2) {
        //         $this->db->where('clinic_id', $_SESSION['clinic']);
        //     }
        //     $this->db->where('status',1);
        //     $this->db->where('approved_status',0);
        //     return $this->db->count_all_results();
        // }else{
            $this->db->from('sc_appointment');
            $this->db->where('appointment_date >= "'.date('Y-m-d').'"');
            if ($_SESSION['usertype'] == 2) {
                $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
            }
            $this->db->where('status',1);
            $this->db->where('approved_status',0);
            return $this->db->count_all_results();

        // }

    }

    public function countAll_doctors(){
        // if ($_SESSION['usertype'] == 2) {
        //     $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
        // }
        $this->db2 = $this->load->database('second', TRUE);
        $this->db2->where('SchedDate',date('Y-m-d'));
        $this->db2->from('schedule');///schedule
        return $this->db2->count_all_results();
    }

    public function countAll_emergency(){
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_emergency.clinic_id', $_SESSION['clinic']);
        }

        $this->db->from('sc_emergency');
        $this->db->where('created_date >= "'.date('Y-m-d').'"');

        return $this->db->count_all_results();

    }


    public function getNotificationAppt(){
        // print_r($_SESSION); die;
        $datetime = date("Y-m-d H:i:s");
        $timestamp = strtotime($datetime);
        $time = $timestamp - (3 * 60 *60);
        $datetimes = date("Y-m-d H:i:s", $time);
        // print_r($datetimes); die;
        
        
        $this->db->select('sc_appointment.appointment_date,sc_appointment.reminder_date,sc_desired_clinic.desired_clinic AS clinicname,sc_users.name,sc_users.lastname,
        sc_users.email,sc_appointment_type.type');
        $this->db->from('sc_appointment');
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
        }
        $this->db->where('sc_appointment.appointment_date > "'.$datetimes.'"');
        $this->db->where('sc_appointment.status',1);
        $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id'); 
        $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id');
        $this->db->join('sc_appointment_type','sc_appointment.appointment_type = sc_appointment_type.id');
        
        $this->db->order_by("sc_appointment.appointment_date", "desc");
        $this->db->limit(10); 
        // print_r($this->db->get()->result()); die;
        return $this->db->get()->result();
        // print_r($this->db->last_query()); die;


        

    }

  

    public function getNewMessages(){
        $datetime = date("Y-m-d H:i:s");
        $timestamp = strtotime($datetime);
        $time = $timestamp - (3 * 60 *60);
        $datetime = date("Y-m-d H:i:s", $time);
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_desired_clinic.id', $_SESSION['clinic']);
        }
        
        $this->db->select('sc_desired_clinic.desired_clinic AS clinicname,sc_users.name,sc_users.lastname,
        sc_users.email,sc_message_table.created_date,MAX(sc_message_table.message) AS usermsg,sc_message_table.user_id');
        $this->db->from('sc_users');
        $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic = sc_desired_clinic.id'); 
        $this->db->join('sc_message_table', 'sc_users.id = sc_message_table.from_user_id'); 
        $this->db->where('sc_users.usertype',3);
        // $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id');
        // $this->db->join('sc_appointment_type','sc_appointment.sc_appointment_type = sc_appointment_type.id');
        $this->db->where('sc_message_table.created_date > "'.$datetime.'"');
        // $this->db->where('sc_appointment.status',1);
        $this->db->order_by("sc_message_table.created_date", "desc");
        $this->db->group_by("sc_message_table.from_user_id");
        $this->db->limit(10); 
        return $this->db->get()->result();
        // print_r($this->db->last_query()); die;

    }

    public function checkPassword($id)
    {
        
        $this->db->where('id',$id);
        $q=$this->db->get('sc_users');
        if($q->num_rows()){
            return $q->row();
        }else{
            return false;
        }

    }

    public function updatePassword($data,$id)
    {
        $this->db->where('id',$id);
        $q=$this->db->update('sc_users',$data);
        if($q){
            echo true;
        }else{
            echo false;
        }

    }
    public function getStatusdate()
    {
        
        $this->db->where('user_id',$this->session->userdata('ulsa_id'));
        $data=$this->db->get('sc_filter_status')->num_rows();
        if($data==1){
            $this->db->where('user_id',$this->session->userdata('ulsa_id'));
            $q=$this->db->get('sc_filter_status')->result()[0];
            return $q;
        }else{
            $this->db->where('user_id',$this->session->userdata('ulsa_id'));
            // $this->db->get('')
            $q=$this->db->get('sc_filter_status')->result();
            return $q;

        }
    }

  

 


    // public function getAppointmentList(){
    //     if ($_SESSION['usertype'] == 2) {
    //         $this->db->where('sc_appointment.clinic_id', $_SESSION['clinic']);
    //     }
    //     $this->db->select('sc_appointment.appointment_date,sc_appointment.reminder_date,sc_desired_clinic.sc_desired_clinic AS clinicname,sc_users.name,sc_users.lastname,
    //     sc_users.email,sc_users.phone,sc_appointment_type.type');
    //     $this->db->from('sc_appointment');
    //     $this->db->join('sc_desired_clinic', 'sc_appointment.clinic_id = sc_desired_clinic.id'); 
    //     $this->db->join('sc_users', 'sc_appointment.user_id = sc_users.id');
    //     $this->db->join('sc_appointment_type','sc_appointment.sc_appointment_type = sc_appointment_type.id');
    //     $this->db->order_by("sc_appointment.appointment_date", "asc");
    //     $this->db->limit(10); 
    //     return $this->db->get()->result();
       
    // }
}






?>