<?php    
class Clinic_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_desired_clinic';
        $this->column_order = array( 'image','logo','desired_clinic','clinic_email','clinic_phoneno','working_hours','clinic_address');
        // Set searchable column fields
        $this->column_search = array( 'desired_clinic','clinic_email','clinic_phoneno','working_hours','clinic_address');
        // Set default order
        $this->order = array('id' => 'asc');
    }
 
    public function getRows_clinic($postData){
        $this->_get_datatables_query_clinic($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function countAll_clinic(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_clinic($postData){
        $this->_get_datatables_query_clinic($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_clinic($postData){
         
        $this->db->from($this->table);
        $this->db->where('status',1);

        if ($_SESSION['usertype'] == 2) {
            $this->db->where('id', $_SESSION['clinic']);
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

    public function editClinic($id){
        $this->db->where('id',$id);
        $q=$this->db->get('sc_desired_clinic');
        return $q->result();
    }
   
    public function updateClinic($picture,$id){
        $this->db->where('id',$id);
        $output = $this->db->update('sc_desired_clinic',$picture);

        //// Multiple doctor 
        if (!empty($_POST['doctor_id'])) {
                $this->db->where('clinic_id', $id);
                $q = $this->db->delete('sc_doctor_working');
                foreach ($_POST['doctor_id'] as $doctor_id) {
                    $doctorUpdate = array(
                        'doctor_id' => $doctor_id, 'clinic_id' => $id
                        );
                    $this->db->insert('sc_doctor_working', $doctorUpdate);
                }
            }
        // return $output;
    }
    // public function deleteClinic($id){
    // // public function delete_braces_data($id){
    //     // $this->db->where('id',$id);
    //     // $q=  $this->db->get('desired_clinic')->result()[0];
    //     // $p=$q->{'image'};
    //     // unlink(FCPATH.'/'.$p);


    //     // $this->db->where('id',$id);
    //     // $this->db->delete('desired_clinic');
    // }

    public function deleteClinic($id,$status)
    {
        $this->db->where('id',$id);
       $q= $this->db->update('sc_desired_clinic',$status);
       if ($q==true){
        echo true;
        }
      else{
        echo false;
        }
    }

    public function addClinic($picture){
       $q= $this->db->insert('sc_desired_clinic',$picture);
       $insert_id = $this->db->insert_id();

       foreach ($_POST['doctor_id'] as $doctor_id) {
            $data = array(
                'clinic_id' => $insert_id, 'doctor_id' => $doctor_id
            );
            $this->db->insert('sc_doctor_working', $data);
        }
    }


    public function getRows_appoinmenttype($postData)
    {
        $this->_get_datatables_query_appoinmenttype($postData);
        if ($postData['length'] != -1) {
        $this->db->limit($postData['length'], $postData['start']);
         }
         $id=$_POST['id'];
         $this->db->where('clinic_id',$id);
        $query = $this->db->get('sc_services')->result();
        return $query;

    }
    
    public function countAll_appoinmenttype($postData)
    {
        $this->db->from('sc_services');
        return $this->db->count_all_results();
        
    }

    public function countFiltered_appoinmenttype($postData)
    {
        $this->_get_datatables_query_appoinmenttype($postData);
        $query = $this->db->get('sc_services');
        return $query->num_rows();
        
    }
    
    public function _get_datatables_query_appoinmenttype($postData)
    {
        // Set searchable column fields
        $search= $this->column_search = array('service_type','service_description');
        // Set orderable column fields
        $colorder= $this->column_order = array( 'service_type','service_description');
        // Set default order
       
        $rorder= $this->order = array('id' => 'asc');

        $id=$_POST['id'];
        $this->db->get('sc_services');
        $this->db->where('clinic_id',$id);
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

    public function insertservices($data)
    {
       $q= $this->db->insert('sc_services',$data);
       if ($q==true){
        echo true;
        }
      else{
        echo false;
        }
    }

    public function editService($id)
    {
        $this->db->where('id',$id);
        $q=$this->db->get('sc_services');
        return $q->result();

    }

    public function updateService($data,$id)
    {
        $this->db->where('id',$id);
       $q= $this->db->update('sc_services',$data);
       if ($q==true){
        echo true;
        }
      else{
        echo false;
        }
    }

    public function deleteService($id,$status)
    {
        $this->db->where('id',$id);
       $q= $this->db->update('sc_services',$status);
       if ($q==true){
        echo true;
        }
      else{
        echo false;
        }


    }


    public function checkEmail($email)
    {
       
        $this->db->where('clinic_email',$email);
        $data=$this->db->get('sc_desired_clinic')->num_rows();
        if($data==1){
            return true;
        }else{
            return false;
        }


    }
    public function checkMobile($mobile)
    {
        $sql = "SELECT count(*) as count From sc_desired_clinic Where clinic_phoneno = '$mobile'";
        $select = $this->db->query($sql);
        echo $select->result_array()[0]['count'];

    }
    public function getDoctor()
    {
       $q= $this->db->get('sc_doctor')->result();
        return $q;
    }



   
   
  
}
