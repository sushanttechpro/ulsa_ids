<?php    
class Subadmin_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_users';
        $this->column_order = array( 'name','lastname','email','phone','sc_desired_clinic.desired_clinic');
        // Set searchable column fields
        $this->column_search = array('name','lastname','phone','email','sc_desired_clinic.desired_clinic');
        // Set default order
        $this->order = array('sc_users.created_date' => 'Desc');  
    }
 
    public function getRows_users($postData){
        $this->_get_datatables_query_users($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $this->db->where('usertype',2);
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
        $this->db->where('usertype',2);
        $this->db->where('sc_users.status',1);


        $this->db->select('sc_users.*,sc_desired_clinic.desired_clinic ');
        $this->db->from($this->table);
        $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic = sc_desired_clinic.id'); 

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

    public function editSubadmin($id)
    {
        $this->db->where('id',$id);
        $q=$this->db->get('sc_users');
        return $q->result(); 
    }

    public function updateSubadmin($id,$data)
    {
        $this->db->where('id',$id);
       $q= $this->db->update('sc_users',$data);
        if ($q==true){
            echo true;
             }
            else{
            echo false;
            }
    }

    public function deleteSubadmin($id,$status)
    {
      
        $this->db->where('id',$id);
       $q= $this->db->update('sc_users',$status);
        if ($q==true){
            echo true;
             }
            else{
            echo false;
            }
    }

    public function getClinic()
    {
       $q= $this->db->get('sc_desired_clinic')->result();
        return $q;
    }

  

    public function insertUser($data)
    {
        $q=$this->db->insert('sc_users',$data);
        if ($q==true){
            echo true;
             }
            else{
            echo false;
            }

    }

    public function Module()
    {
        $this->db->from('sc_modules');
        // $this->db->join('modules_details', 'modules.id = modules_details.module_id');        
        // $this->db->where('userid',$id);
        $data=$this->db->get();
        return $data->result();
    }

    public function subModule(){
        $this->db->from('sc_modules_details');
        // $this->db->join('modules_details', 'modules.id = modules_details.module_id');        
        // $this->db->where('userid',$id);
        $data=$this->db->get();
        return $data->result();
    }

   

}