<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends MY_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_users';
        $this->column_order = array(null,'name','lastname','email','phone','sc_desired_clinic.desired_clinic');

        // Set searchable column fields
        $this->column_search = array('name','lastname','email','phone','sc_desired_clinic.desired_clinic');
        // Set default order
        $this->order = array('sc_users.created_date' => 'Desc');  
    }
 
    public function getRows_users($postData){
        $this->_get_datatables_query_users($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        // $this->db->like('usertype','3');
        // $this->db->where('usertype',3);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function countAll_users(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_users($postData){
        $this->_get_datatables_query_users($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_users($postData){
       
        $this->db->select('sc_users.*,sc_desired_clinic.desired_clinic as clinic');
        $this->db->from($this->table);
        $this->db->where('sc_users.usertype',3);
        $this->db->where('sc_users.status',1);
        $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic = sc_desired_clinic.id'); 
        
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_users.desired_clinic', $_SESSION['clinic']);
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


    public function deleteUser($id,$status)
    {

        $this->db->where('user_id',$id);
        $q= $this->db->update('sc_family_member',$status);
       
        $this->db->where('id',$id);
        $q= $this->db->update('sc_users',$status);

        if ($q==true){
            echo true;
             }
            else{
            echo false;
            }
    }

    public function get_desired_clinic()
    {
      

        if ($_SESSION['usertype'] == 2) {
            $this->db->where('id', $_SESSION['clinic']);
            $q= $this->db->get('sc_desired_clinic')->result();
     
        return $q;
        }  else{
            $q= $this->db->get('sc_desired_clinic')->result();
     
        return $q;

        }
    }

    public function insertUser($data)
    {
       $q= $this->db->insert('sc_users',$data);
       if ($q==true){
        echo true;
         }
        else{
        echo false;
        }

    }

    public function updateUser($data,$id)
    {
        $this->db->where('id',$id);
        $q=$this->db->update('sc_users',$data);
        if ($q==true){
            echo true;
             }
            else{
            echo false;
            }
    }


    public function checkEmail($email)
    {
       
        $this->db->where('email',$email);
        $data=$this->db->get('sc_users')->num_rows();
        if($data==1){
            return true;
        }else{
            return false;
        }


    }
    public function checkMobile($mobile)
    {
        $sql = "SELECT count(*) as count From sc_users Where phone = '$mobile'";
        $select = $this->db->query($sql);
        echo $select->result_array()[0]['count'];

    }


 
    ///member list datatable start from here
    public function getRows_member($postData)
    {
        $this->_get_datatables_query_member($postData);
        if ($postData['length'] != -1) {
        $this->db->limit($postData['length'], $postData['start']);
         }
         $id=$_POST['id'];
         $this->db->where('user_id',$id);
        $query = $this->db->get('sc_family_member')->result();
        return $query;

    }
    
    public function countAll_member($postData)
    {
        $this->db->from('sc_family_member');
        return $this->db->count_all_results();
        
    }

    public function countFiltered_member($postData)
    {
        $this->_get_datatables_query_member($postData);
        $query = $this->db->get('sc_family_member');
        return $query->num_rows();
        
    }
    
    public function _get_datatables_query_member($postData)
    {
        // Set searchable column fields
        $search= $this->column_search = array('Firstname','Lastname','phone_number');
        // Set orderable column fields
        $colorder= $this->column_order = array( 'Firstname','Lastname','phone_number');
        // Set default order
       
        $rorder= $this->order = array('id' => 'asc');

        $id=$_POST['id'];
        $this->db->get('sc_family_member');
        $this->db->where('user_id',$id);
        $this->db->where('status',1);



        $i = 0;
        // loop searchable columns 
        foreach($search as $item){
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
            $this->db->order_by($colorder[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($rorder)){
            $order = $rorder;
            $this->db->order_by(key($order), $order[key($order)]);
        }

      
    }


    public function insertMember($data)
    {
      $q=  $this->db->insert('sc_family_member',$data);
      if ($q==true){
        echo true;
        }
      else{
        echo false;
        }
    }

    public function checkmobile_member($mobile)
    {
        $sql = "SELECT count(*) as count From sc_family_member Where phone_number = '$mobile'";
        $select = $this->db->query($sql);
        echo $select->result_array()[0]['count'];

    }


    public function deleteMember($id,$status)
    {
        $this->db->where('id',$id);
       $q= $this->db->update('sc_family_member',$status);

       if ($q==true){
        echo true;
         }
        else{
        echo false;
        }
      

    }
    public function editMember($id)
    {
        $this->db->where('id',$id);
        $q=$this->db->get('sc_family_member');
        return $q->result(); 

    }
    public function updateMember($id,$data)
    {
        $this->db->where('id',$id);
        $q= $this->db->update('sc_family_member',$data);
        if ($q==true){
            echo true;
            }
          else{
            echo false;
            }
    }
    public function profile($id)
    { 
        $this->db->where('id',$id);
      $data=  $this->db->get('sc_users');  
        return $data->result()[0];
    }


     ///Adding Patient from oldplatform///
     public function addpatient()
     {
        $this->db2 = $this->load->database('second', TRUE);
         $data = $this->db2->get('patient')->result_array();
         foreach ($data as $row) {
             $id = $row['PatNum'];
             // print_r($id);
             $this->db2->where('PatNum', $id);
             $q = $this->db->get('sc_users')->num_rows();
             $sc_pat_data = $this->db->get('sc_users')->result();
             if (array_search($id, array_column($sc_pat_data, 'PatNum')) === false) {
                 $providerdata = array('PatNum' => $row['PatNum'], 'name' => $row['FName'], 'lastname' => $row['LName'],'email'=>$row['Email'],
             'usertype'=>3,'desired_clinic'=>1);
                 $this->db->insert('sc_users', $providerdata);
                 // echo true;
             }else{
                 // echo false;
             }
          
         }
     }
 
     public function export()
     {
         $this->db->where('PatNum',0);
         $this->db->where('usertype',3);
         $data = $this->db->get('sc_users')->result_array();
         // print_r($data);die;
 
         foreach ($data as $row) {
             $id = $row['PatNum'];
             $email = $row['email'];
             $this->db2 = $this->load->database('second', TRUE); 
 
             $this->db2->where('PatNum', $id);
             $q = $this->db2->get('patient')->num_rows();
             $sc_pat_data = $this->db2->get('patient')->result();
             if (array_search($id, array_column($sc_pat_data, 'PatNum')) === false) {
                 $usersdata = array('LName' => $row['lastname'], 'FName' => $row['name'],'Email'=>$row['email'],'Guarantor'=>0,);
                 $this->db2->insert('patient', $usersdata);
 
                 $insert_id = $this->db2->insert_id();//
                 // print_r($insert_id);
     
                 $updatedata=array('PatNum'=>$insert_id);
 
                 $this->db->where('email', $email);
                 $this->db->where('usertype',3);
                 $this->db->update('sc_users', $updatedata);
                 // print_r($this->db->last_query());
 
             }
 
             
          
         }
         echo true;
 
     }
     public function insurance($id)
     {
        $this->db->where('user_id',$id);
        $data=$this->db->get('sc_insurance')->num_rows();
        if($data==1){
            $this->db->where('user_id',$id);
            $q=$this->db->get('sc_insurance')->result()[0];
            return $q;
       }else{
            $this->db->where('user_id',$id);
            $q=  $this->db->get('sc_insurance')->result();
            return $q;
       }
    }


    

     public function updateInsurance($id)
     {
        
        $this->db->where('user_id',$id);
        $data=$this->db->get('sc_insurance')->num_rows();
        if($data==1){
            $insurance_data=array('patient_name'=>$_POST['patient_name'],'subscriber_id'=>$_POST['subscriber_id'],'subscriber_name'=>$_POST['subscriber_name'],
            'patient_date_of_birth'=>$_POST['patient_date_of_birth'],'subcriber_date_of_birth'=>$_POST['subcriber_date_of_birth'], 'updated_date' => date("Y-m-d H:i:s"));
            $this->db->where('user_id',$id);
            $this->db->update('sc_insurance',$insurance_data);
        }else{
            $sid=$id;
            $insurance_datas=array('patient_name'=>$_POST['patient_name'],'user_id'=>$sid,'subscriber_name'=>$_POST['subscriber_name'],
            'patient_date_of_birth'=>$_POST['patient_date_of_birth'],'subcriber_date_of_birth'=>$_POST['subcriber_date_of_birth'],
            'subscriber_id'=>$_POST['subscriber_id']);
            $this->db->insert('sc_insurance',$insurance_datas);
        }

     }

    






}